<?php

namespace App\Helpers;

use App\Coupon;

class CustomHelper {

    /**
     * Render S3 image URL
     *
     * @param $name
     * @param bool $thumbnail
     * @return string
     */
    public static function AWSimage($name, $thumbnail = false) {
        return env('AWS_URL') . '/' . env('AWS_BUCKET') . '/photos' . ($thumbnail ? '/thumbnails/' : '/') . $name;
    }

    public static function image($name, $thumbnail = false) {
        return 'http://www.illuminearts.com/cw4/images/orig/' . $name;
    }

    /**
     * Format a 10-digit phone number from xxxxxxxxxx to (xxx) xxx-xxxx
     *
     * @param $phone
     * @return string
     */
    public static function formatPhoneNumber($phone) {
        return strlen($phone) == 10 ? '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' .substr($phone,6) : $phone;
    }

    /**
     * Format address
     *
     * @param $data
     * @return string
     */
    public static function formatAddress($data) {
        $output = '';

        if (!empty($data['name'])) {
            $output .= $data['name'];
        } else {
            if (!empty($data['first_name'])) {
                $output .= $data['first_name'];
            }

            if (!empty($data['last_name'])) {
                $output .= ' ' . $data['last_name'];
            }
        }

        if (!empty($data['address_1'])) {
            if (!empty($data['name']) || !empty($data['first_name']) || !empty($data['last_name'])) {
                $output .= '<br />';
            }
            $output .= $data['address_1'];
        }

        if (!empty($data['address_2'])) {
            if (!empty($data['address_1'])) {
                $output .= ' ';
            }
            $output .= $data['address_2'];
        }

        if (!empty($data['city'])) {
            if (!empty($data['address_1']) || !empty($data['address_2'])) {
                $output .= '<br />';
            }
            $output .= $data['city'];
        }

        if (!empty($data['state'])) {
            if (!empty($data['city'])) {
                $output .= ', ';
            }
            $output .= $data['state'];
        }

        if (!empty($data['zipcode'])) {
            if (!empty($data['state'])) {
                $output .= ' ';
            }
            $output .= $data['zipcode'];
        }

        return $output;
    }

    /**
     * Format credit card
     *
     * @param $card
     * @return string
     */
    public static function formatCard($card) {
        $brand = '';

        switch($card['brand']) {
            case 'Visa':
                $brand = 'visa';
                break;
            case 'MasterCard':
                $brand = 'mastercard';
                break;
            case 'American Express':
                $brand = 'amex';
                break;
            case 'Discover':
                $brand = 'discover';
                break;
            case 'Diners Club':
                $brand = 'diners-club';
                break;
            case 'JCB':
                $brand = 'jcb';
                break;
        }

        return '<i class="fa fa-cc-' . $brand . '" title="'.$card['brand'].'"></i>' . ' ***' . $card['last4'] . ' - ' . $card['name_on_card'];
    }

    /**
     * Format order status
     *
     * @param $order
     * @return string
     */
    public function formatOrderStatus($order) {
        if ($order['status'] == 'processing') {
            return '<span class="label label-info" title="' . config('custom.order_status.' . $order['status']) . '">' . config('custom.order_status.' . $order['status']) . '</span>';
        } else {
            return '<span class="label label-default" title="' . config('custom.order_status.' . $order['status']) . '">' . config('custom.order_status.' . $order['status']) . '</span>';
        }
    }

    /**
     * Format order payment status
     *
     * @param $order
     * @return string
     */
    public function formatOrderPaymentStatus($order) {
        if ($order['payment_status'] == 'paid') {
            switch ($order['payment_method']) {
                case 'card':
                    return '<span class="label label-success" title="' . config('custom.payment_status.' . $order['payment_status']) . ' with card' . '"><i class="fa fa-credit-card"></i > ' . config('custom.payment_status.' . $order['payment_status']) . '</span>';
                    break;

                case 'cash':
                    return '<span class="label label-success" title="' . config('custom.payment_status.' . $order['payment_status']) . ' in cash' . '"><i class="fa fa-money"></i > ' . config('custom.payment_status.' . $order['payment_status']) . '</span>';
                    break;

                case 'paypal':
                    return '<span class="label label-success" title="' . config('custom.payment_status.' . $order['payment_status']) . ' with PayPal' . '"><i class="fa fa-paypal"></i > ' . config('custom.payment_status.' . $order['payment_status']) . '</span>';
                    break;
            }
        } else if ($order['payment_status'] == 'refunded') {
            return '<span class="label label-default" title="' . config('custom.payment_status.' . $order['payment_status']) . '">' . config('custom.payment_status.' . $order['payment_status']) . '</span>';
        } else if ($order['payment_status'] == 'free') {
            return '<span class="label label-default" title="' . config('custom.payment_status.' . $order['payment_status']) . '">' . config('custom.payment_status.' . $order['payment_status']) . '</span>';
        } else {
            return '<span class="label label-danger" title="' . config('custom.payment_status.' . $order['payment_status']) . '">' . config('custom.payment_status.' . $order['payment_status']) . '</span>';
        }
    }

    /**
     * Format tracking URL
     *
     * @param $order
     * @return string
     */
    public function formatTrackingURL($order) {
        switch ($order['shipping_carrier']) {
            case 'usps':
                return !empty($order['shipping_tracking_number']) ?
                    '<a href="https://tools.usps.com/go/TrackConfirmAction?tLabels=' . $order['shipping_tracking_number'] . '" target="_blank">' . $order['shipping_tracking_number'] . '</a>)':
                    'Not available';
                break;

            case 'ups':
                return !empty($order['shipping_tracking_number']) ?
                    '<a href="https://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=' . $order['shipping_tracking_number'] . '" target="_blank">' . $order['shipping_tracking_number'] . '</a>)':
                    'Not available';
                break;

            default:
                return 'Not available';
        }
    }

    /**
     * Compute all fees from a given Cart
     *
     * @param $cart
     * @return array
     */
    public static function computeFees() {
        $cart = session('cart');

        $fees = [
            'items' => collect($cart['items'])->sum('quantity'),
            'subtotal' => collect($cart['items'])->reduce(function ($carry, $item) { return $carry + ($item['price'] * $item['quantity']); })
        ];

        // Compute tax
        $fees['tax'] = round($fees['subtotal'] * config('custom.tax') / 100, 2);

        // Compute shipping fees
        $shipping = [
            'config' => config('custom.checkout.shipping')
        ];

        $shipping['default'] = $shipping['config']['default'];

        if (isset($cart['shipping'])) {
            if ($cart['shipping'] == 'cash_on_delivery') {
                $fees['shipping'] = 0;
            } else {
                $fees['shipping'] = $shipping['config']['carriers'][$cart['shipping']['carrier']]['plans'][$cart['shipping']['plan']]['fee'];
            }
        } else {
            $fees['shipping'] = $shipping['config']['carriers'][$shipping['default'][0]]['plans'][$shipping['default'][1]]['fee'];
        }

        $fees['discount'] = 0;

        // Apply coupon, if given
        if (!empty($cart['coupon'])) {
            // Retrieve the Coupon from Database
            $coupon = Coupon::where('id', $cart['coupon']['id'])->where('active', true)->with('products')->first();

            // If Coupon is invalid, simply remove Coupon
            if (!$coupon ||
                !$coupon['active'] ||
                ($coupon['limited'] && $coupon['usage'] >= $coupon['limit']) ||
                (!empty($coupon['start']) && $coupon['start']->isFuture()) ||
                (!empty($coupon['end']) && $coupon['end']->isPast())) {
                session()->forget('cart.coupon');
            }
            // Else, Coupon is valid
            else {
                // Update the updated Coupon to the current session
                session(['cart.coupon' => $coupon->toArray()]);

                $cart['coupon'] = session('cart.coupon');

                if ($cart['coupon']['shipping']) {
                    $fees['shipping'] = 0;
                }

                $couponProducts = collect(session('cart.coupon.products'))->pluck('id')->toArray();
                /*$cartProducts = collect(session('cart.items'))->pluck('product_id')->unique()->toArray();
                $eligibleProducts = array_intersect($couponProducts, $cartProducts);*/

                // If Coupon is applicable for all Products in the Cart
                if (count($couponProducts) == 0) {
                    switch ($cart['coupon']['type']) {
                        case 'percentage':
                            if (!empty($cart['coupon']['discount_percentage'])) {
                                $fees['discount'] = ($cart['coupon']['discount_percentage']  / 100) * $fees['subtotal'];
                            }
                            break;

                        case 'amount':
                            if (!empty($cart['coupon']['discount_amount'])) {
                                $fees['discount'] = $cart['coupon']['discount_amount'];
                            }
                            break;
                    }
                }
                // Else, Coupon is only applicable for some (or all) Products in the Cart
                else {
                    // Walk through each Cart Item
                    foreach ($cart['items'] as $cartItem) {
                        // If this Cart Item's Product is eligible for the Coupon, compute the discount on this Cart Item
                        if (in_array($cartItem['product_id'], $couponProducts)) {
                            switch ($cart['coupon']['type']) {
                                case 'percentage':
                                    if (!empty($cart['coupon']['discount_percentage'])) {
                                        $fees['discount'] += ($cart['coupon']['discount_percentage'] / 100) * $cartItem['price'] * $cartItem['quantity'];
                                    }
                                    break;

                                case 'amount':
                                    if (!empty($cart['coupon']['discount_amount']) && $cart['coupon']['discount_amount'] <= $cartItem['price']) {
                                        $fees['discount']+= $cart['coupon']['discount_amount'] * $cartItem['quantity'];
                                    }
                                    break;
                            }
                        }
                    }
                }

                $fees['discount'] = round($fees['discount'], 2);

                //$fees['subtotal'] = round(($fees['subtotal'] - $fees['discount']), 2);

                // Compute tax
                $fees['tax'] = round(($fees['subtotal'] - $fees['discount']) * config('custom.tax') / 100, 2);
            }
        }

        $fees['total'] = $fees['subtotal'] - $fees['discount'] + $fees['tax'] + $fees['shipping'];

        return $fees;
    }

}