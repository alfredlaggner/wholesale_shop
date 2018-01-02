<?php

namespace App\Helpers;

use PayPal\Api\Item;
use PayPal\Api\Sale;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Api\RedirectUrls;
use Illuminate\Http\Request;
use PayPal\Api\RefundRequest;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use PayPal\Exception\PayPalConnectionException;

class PayPalHelper {
    private $paypal;

    public function __construct() {
        // Setup PayPal API context
        $config = config('paypal');
        $this->paypal = new ApiContext(new OAuthTokenCredential($config['client_id'], $config['secret']));
        $this->paypal->setConfig($config['settings']);
    }

    public function pay($order, $orderedItems)
    {
        // Payer: who funds a payment
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        // Item List
        $items = [];

        foreach ($orderedItems as $orderedItem) {
            $item = new Item();

            $item->setName($orderedItem['product_name'])
                ->setCurrency('USD')
                ->setQuantity($orderedItem['quantity'])
                ->setSku($orderedItem['sku']) // Similar to `item_number` in Classic API
                ->setPrice($orderedItem['price']);

            $items[] = $item;
        }

        // Discount: add a "discount" item, and update the Subtotal
        if ($order['discount'] > 0) {
            $item = new Item();

            $item->setName('Discount')
                ->setCurrency('USD')
                ->setQuantity(1)
                /*->setSku($orderedItem['sku']) // Similar to `item_number` in Classic API*/
                ->setPrice(-$order['discount']);

            $items[] = $item;

            $order['subtotal'] -= $order['discount'];
        }

        $itemList = new ItemList();
        $itemList->setItems($items);

        // Additional Payment Details
        $details = new Details();
        $details->setShipping($order['shipping_fee'])
            ->setTax($order['tax'])
            ->setSubtotal($order['subtotal']);

        // Payment Amount
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($order['total'])
            ->setDetails($details);

        // Transaction: the contract of a payment - what is the payment for and who is fulfilling it
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('Order from ' . env('APP_NAME'))
            ->setInvoiceNumber(uniqid());

        // Redirect URLs: the urls that the buyer must be redirected to after payment approval / cancellation
        $redirectURLs = new RedirectUrls();
        $redirectURLs->setReturnUrl(route('shop.checkout.paypal', ['success' => 1]))
            ->setCancelUrl(route('shop.checkout.paypal', ['success' => 0]));

        // Payment: create one using the above types and intent set to 'sale'
        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectURLs)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->paypal);
        } catch (Exception $exception) {
            return back()->with('alert-danger', 'Something went wrong, funds could not be loaded');
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        // Add Payment ID to session
        session(['order.paypal.payment_id' => $payment->getId()]);

        if (isset($redirect_url)) {
            // Redirect to PayPal
            return redirect($redirect_url);
        }

        return back()->with('alert-danger', 'Unknown error occurred');
    }

    /**
     * Handle the response from PayPal
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|Payment
     */
    public function getPaymentStatus(Request $request)
    {
        // Get the Payment ID before session clear
        $paymentId = session()->get('order.paypal.payment_id');

        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            return redirect(route('shop.paypal'))->with('alert-danger', 'Payment failed');
        }

        $payment = Payment::get($paymentId, $this->paypal);

        // PaymentExecution object includes information necessary to execute a PayPal account payment.
        // The payer_id is added to the request query parameters when the user is redirected from PayPal back to website
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));

        // Execute the Payment
        $result = $payment->execute($execution, $this->paypal);

        return $result;
    }

    /**
     * Retrieve a Payment by a given Payment ID
     *
     * @param $paymentId
     * @return Payment
     */
    public function getPayment($paymentId) {
        try {
            $payment = Payment::get($paymentId, $this->paypal);
        }
        catch (PayPalConnectionException $exception) {
            if (env('BUGSNAG_API_KEY')) {
                Bugsnag::notifyException($exception);
            }
            exit();
        }
        catch (Exception $exception) {
            if (env('BUGSNAG_API_KEY')) {
                Bugsnag::notifyException($exception);
            }
            exit();
        }

        return $payment;
    }

    /**
     * Retrieve a Sale by a given Payment
     *
     * @param $payment
     * @return Sale
     */
    public function getSale($payment) {
        // Retrieve the Sale Transaction ID by a given Payment
        $transactions = $payment->getTransactions();
        $relatedResources = $transactions[0]->getRelatedResources();
        $sale = $relatedResources[0]->getSale();
        $saleId = $sale->getId();

        try {
            // Retrieve the Sale by a given Sale Transaction ID
            $sale = Sale::get($saleId, $this->paypal);
        }
        catch (PayPalConnectionException $exception) {
            if (env('BUGSNAG_API_KEY')) {
                Bugsnag::notifyException($exception);
            }
            exit();
        }
        catch (Exception $exception) {
            if (env('BUGSNAG_API_KEY')) {
                Bugsnag::notifyException($exception);
            }
            exit();
        }

        return $sale;
    }

    /**
     * Refund a Sale
     *
     * @param $saleId
     * @param $order
     * @return \PayPal\Api\DetailedRefund
     */
    public function refundSale($saleId, $order) {
        // Set a Refund Amount
        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($order['total']);

        // Set a Refund Request
        $refundRequest = new RefundRequest();
        $refundRequest->setAmount(5);

        // Set a Sale by a given Sale Transaction ID
        $sale = new Sale();
        $sale->setId($saleId);
        try {
            // Refund the Sale
            $refundedSale = $sale->refundSale($refundRequest, $this->paypal);
        }
        catch (PayPalConnectionException $exception) {
            if (env('BUGSNAG_API_KEY')) {
                Bugsnag::notifyException($exception);
            }
            exit();
        }
        catch (Exception $exception) {
            if (env('BUGSNAG_API_KEY')) {
                Bugsnag::notifyException($exception);
            }
            exit();
        }

        return $refundedSale;
    }
}