@component('layouts.master')

    @slot('title')
        Checkout - {{ config('app.name') }}
    @endslot

    @slot('headerBlock')
        <link media="all" type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css" />

        <style>
            .address-row {
                padding: 10px 0;
            }

            .address-row:not(:last-child) {
                border-bottom: 1px solid #eeeeee;
            }
        </style>
    @endslot

    @slot('_token')
        {{ csrf_token() }}
    @endslot

    <div class="row">
        <div class="col-md-12">
            <h1>
                Checkout

                @if (app()->global['settings']['pay_later']['state'])
                    <span class="pull-right">
                        <input name="pay_now" id="pay-now" type="checkbox" data-size="small" data-on-text="Pay Now" data-off-text="Pay Later"{{ session('cart.pay_later') ? '' : ' checked' }}/>
                    </span>
                @endif
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            @include('snippets.errors')
            @include('snippets.flash')

            @include('shop.checkout.login')

            <form method="POST" id="checkout-form" class="material" action="{{ route('shop.checkout.submit') }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}

                <input type="hidden" name="payment[method]" value="{{ old('payment[method]') ?: (isset($cart['payment']) && !empty($cart['payment']['method']) ? $cart['payment']['method'] : 'credit_card') }}" />

            @include('shop.checkout.contact')

            @include('shop.checkout.shipping')

            @include('shop.checkout.delivery')

            @if (app()->global['settings']['pay_later']['state'])
                @include('shop.checkout.pay_later')
            @endif

            @include('shop.checkout.payment')

            @include('shop.checkout.billing')
        </div>

        <div class="col-md-4">
            <div class="well">
                <strong>Order Summary</strong>

                <hr />

                <p class="row">
                    <span class="col-md-6">
                        <strong id="cart-items">{{ $fees['items'] }}</strong> item(s) &middot;
                        <a href="{{ route('shop.cart') }}"><small class="text-muted">Edit</small></a>
                    </span>
                    <span class="col-md-6 text-right">
                        $<strong id="cart-subtotal">{{ number_format($fees['subtotal'], 2) }}</strong>
                    </span>
                </p>

                <p class="row">
                    <span class="col-md-6">
                        Estimated Tax
                    </span>
                    <span class="col-md-6 text-right">
                        $<strong id="cart-tax">{{ number_format($fees['tax'], 2) }}</strong>
                    </span>
                </p>

                <p class="row">
                    <span class="col-md-6">
                        Shipping & Service
                    </span>
                    <span class="col-md-6 text-right">
                        $<strong id="cart-shipping">{{ number_format($fees['shipping'], 2) }}</strong>
                    </span>
                </p>

                <hr class="separator" />

                <p class="row{{ $fees['discount'] == 0 ? ' hide' : '' }}">
                    <span class="col-md-6">
                        Discount
                    </span>
                        <span class="col-md-6 text-right">
                        - $<strong id="cart-discount">{{ number_format($fees['discount'], 2) }}</strong>
                    </span>
                </p>

                <p class="row">
                    <span class="col-md-6">
                        Total
                    </span>
                    <span class="col-md-6 text-right">
                        $<strong id="cart-total">{{ number_format($fees['total'], 2) }}</strong>
                    </span>
                </p>

                <hr class="separator" />

                <p id="coupon-trigger-block" class="row">
                    <span class="col-md-6">
                        Promotion Code
                    </span>
                    @if (empty($cart['coupon']))
                        <span class="col-md-6 text-right">
                            <a href="#" id="coupon-trigger">Apply code <i class="fa fa-caret-down"></i></a>
                        </span>
                    @endif
                </p>

                <p id="coupon-block" class="row form-inline{{ empty($cart['coupon']) ? ' hide' : '' }}">
                    <span class="col-md-12 form-group">
                        <input type="text" id="coupon" class="form-control" placeholder="Promotion code" style="width: 150px;" />
                        <a href="#" id="coupon-btn" class="btn btn-primary form-control">Apply</a>
                    </span>
                </p>

                <p id="coupon-status" class="hide alert"></p>

                <p id="coupon-applied" class="row form-inline{{ empty($cart['coupon']) ? ' hide' : '' }}">
                    <span class="col-md-12">
                        Code applied: <strong>{{ !empty($cart['coupon']) ? $cart['coupon']['code'] : '' }}</strong>
                        <a href="#" id="coupon-remove-btn" class="pull-right"><small>Remove</small></a>
                    </span>
                </p>

                <br />

                <button id="place-order-btn" class="btn btn-block btn-primary" type="submit">
                    <strong>Place Order</strong>
                    &nbsp;<i class="fa fa-lock"></i>
                </button>

                <p class="help-block">
                    <br />
                    <img src="/img/comodo-badge-icon.png" class="pull-right" />
                    <small>
                        Order is securely processed using 256-bit SSL encryption and Stripe PCI-compliant technology.
                    </small>
                </p>

                </form>
            </div>

            @if (env('SHOP_DEMO'))
                <div class="well">
                    <p class="alert alert-info"><i class="fa fa-exclamation-circle"></i> Please use the following cards for testing.</p>

                    <table class="table table-striped">
                        <tr>
                            <th>Number</th>
                            <th>Card Type</th>
                        </tr>
                        <tr>
                            <td>4242 4242 4242 4242</td>
                            <td>Visa</td>
                        </tr>
                        <tr>
                            <td>4012 8888 8888 1881</td>
                            <td>Visa</td>
                        </tr>
                        <tr>
                            <td>4000 0566 5566 5556</td>
                            <td>Visa (debit)</td>
                        </tr>
                        <tr>
                            <td>5555 5555 5555 4444</td>
                            <td>Mastercard</td>
                        </tr>
                        <tr>
                            <td>5200 8282 8282 8210</td>
                            <td>Mastercard (debit)</td>
                        </tr>
                        <tr>
                            <td>5105 1051 0510 5100</td>
                            <td>Mastercard (prepaid)</td>
                        </tr>
                        <tr>
                            <td>3782 822463 10005</td>
                            <td>American Express</td>
                        </tr>
                        <tr>
                            <td>3714 496353 98431</td>
                            <td>American Express</td>
                        </tr>
                        <tr>
                            <td>6011 1111 1111 1117</td>
                            <td>Discover</td>
                        </tr>
                        <tr>
                            <td>6011 0009 9013 9424</td>
                            <td>Discover</td>
                        </tr>
                        <tr>
                            <td>3056 9309 0259 04</td>
                            <td>Diners Club</td>
                        </tr>
                        <tr>
                            <td>3852 0000 0232 37</td>
                            <td>Diners Club</td>
                        </tr>
                        <tr>
                            <td>3530 1113 3330 0000</td>
                            <td>JCB</td>
                        </tr>
                        <tr>
                            <td>3566 0020 2036 0505</td>
                            <td>JCB</td>
                        </tr>
                    </table>
                </div>
            @endif
        </div>
    </div>

    @if (auth()->check())
        @include('shop.checkout.delivery_modal')

        @include('shop.checkout.payment_modal')

        @include('shop.checkout.billing_modal')
    @endif

    @slot('bottomBlock')
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js"></script>

        <script type="text/javascript">
            $( document ).ready(function() {
                var currentShipping = function() {
                    if ($('input[name="cash_on_delivery"]').prop('checked')) {
                        return 'cash_on_delivery';
                    } else {
                        var shippingOption = $('input[type="radio"][name^="shipping"]:checked'),
                            shippingOptionName = shippingOption.attr('name'),
                            shippingOptionValue = shippingOption.val(),
                            shipping = {
                                "carrier": shippingOptionName.substr(9, (shippingOptionName.length - 10)),
                                "plan": shippingOptionValue
                            };

                        return shipping;
                    }
                },
                fees = {!! json_encode($fees) !!};

                // Change UI on Pay Now or Pay Later switch
                var switchPayNowElements = function(state) {
                    $('#pay-later-block, #cash-on-delivery').toggleClass('hide', state);

                    $('input[name="cash_on_delivery"]').attr('disabled', state);

                    $('#billing-fieldset, #payment-fieldset, input[name="billing[address_id]"], input[name="card_id"]').attr('disabled', !state);

                    $('#billing-block, #payment-block').toggleClass('hide', !state);
                };

                // Change UI when fees are updated
                var updateFees = function(data) {
                    fees = data['fees'];

                    $('#cart-subtotal').text(data['fees']['subtotal'].toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
                    $('#cart-tax').text(data['fees']['tax'].toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
                    $('#cart-shipping').text(data['fees']['shipping'].toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
                    $('#cart-discount').text(data['fees']['discount'].toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
                    $('#cart-total').text(data['fees']['total'].toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));

                    // If the total is $0, then disable & hide the Billing and Payment elements
                    if (data['fees']['total'] == 0) {
                        $('#billing-fieldset, #payment-fieldset, input[name="billing[address_id]"], input[name="card_id"]').attr('disabled', true);
                        $('#billing-block, #payment-block').toggleClass('hide', true);
                    }
                    // Else, enable the Billing and Payment elements if Pay Now/Pay Later feature is enabled and Pay Now is currently selected, or Pay Now/Pay Later feature is not enabled
                    else if (($('#pay-now').length > 0 && $('#pay-now').prop('checked')) || $('#pay-now').length == 0) {
                        $('#billing-fieldset, #payment-fieldset, input[name="billing[address_id]"], input[name="card_id"]').attr('disabled', false);
                        $('#billing-block, #payment-block').toggleClass('hide', false);
                    }
                };

                @if (app()->global['settings']['pay_later']['state'])
                    // Initial view (don't do this if total is $0)
                    @if ($fees['total'] > 0)
                        switchPayNowElements($('input[name="pay_now"]').prop('checked'));
                    @endif

                    $('#pay-now').bootstrapSwitch({
                        onSwitchChange: function(event, state) {
                            event.preventDefault();

                            switchPayNowElements(state);

                            $.ajax({
                                headers: {
                                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                                },
                                url: "/shop/cart/update",
                                type: "POST",
                                data: {
                                    "pay_later": !state,
                                    "shipping": currentShipping()
                                },
                                cache: false,
                                success: function(data) {
                                    if (typeof data['status'] != 'undefined' && data['status']  === true) {
                                        if (typeof data['fees'] != 'undefined') {
                                            updateFees(data);
                                        }
                                    }
                                },
                                error: function() {
                                }
                            });
                        }
                    });
                @endif

                {{-- If Pay Later and Cash on Delivery features are enabled --}}
                @if (app()->global['settings']['pay_later']['state'] && app()->global['settings']['cash_on_delivery']['state'])
                    // On click on the "Cash on Delivery" checkbox
                    $('input[name="cash_on_delivery"]').change(function() {
                        $('fieldset[class^="shipping"]').toggleClass('hide', $(this).prop('checked')).attr('disabled', $(this).prop('checked'));

                        $.ajax({
                            headers: {
                                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                            },
                            url: "/shop/cart/update",
                            type: "POST",
                            data: {
                                shipping: currentShipping()
                            },
                            cache: false,
                            success: function(data) {
                                if (typeof data['status'] != 'undefined' && data['status'] === true) {
                                    if (typeof data['fees'] != 'undefined') {
                                        updateFees(data);
                                    }
                                }
                            },
                            error: function() {
                            }
                        });
                    });
                @endif

                var coupon = {
                    "applied": false,
                    "code": ''
                };

                @if (!empty($cart['coupon']))
                    coupon['applied'] = true;
                    coupon['code'] = '{{ $cart['coupon']['code'] }}';
                @endif

                var resetCoupon = function(status) {
                    coupon['applied'] = false; // Mark current coupon as not applied
                    coupon['code'] = '';

                    // If this function is called when Coupon is invalid
                    if (typeof status != 'undefined') {
                        $('#coupon-status').removeClass('hide').addClass('alert-danger').html(status);
                    }
                    // If this function is called when Coupon is removed
                    else {
                        $('#coupon-status').html('').removeClass('alert-danger').addClass('hide');
                        $('#coupon').val('');
                    }

                    $('#coupon-applied').addClass('hide').find('strong').text('');

                    $('#cart-discount').closest('p').addClass('hide');
                };

                // Coupon - On click on 'Apply code' link, show coupon block and destroy this link
                $('#coupon-trigger').click(function(e) {
                    e.preventDefault();

                    $('#coupon-block').removeClass('hide');

                    $('#coupon').prop('disabled', false);

                    $(this).remove();
                });

                // Coupon - On click on the 'Apply' button
                $('#coupon-btn').click(function(e) {
                    e.preventDefault();

                    coupon['code'] = $('#coupon').val();

                    if (coupon['code'] == '') {
                        alert('Please enter a valid coupon code');

                        return false;
                    }

                    $.ajax({
                        contentType: 'application/json',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                        },
                        url: "/shop/cart/update",
                        type: "POST",
                        data: JSON.stringify({
                            "coupon": coupon['code']
                        }),
                        cache: false,
                        success: function(data) {
                            if (typeof data['status'] != 'undefined') {
                                updateFees(data); // Update the fees

                                // If coupon is valid
                                if (data['status'] === true && typeof data['coupon'] != 'undefined' && data['coupon'] === true) {
                                    coupon['applied'] = true; // Mark current coupon as applied

                                    $('#coupon-status').html('').removeClass('alert-danger').addClass('hide');
                                    $('#coupon-applied').removeClass('hide').find('strong').text(coupon['code']).fadeOut().fadeIn();

                                    if (typeof data['fees']['discount'] != 'undefined' && data['fees']['discount'] > 0) {
                                        $('#cart-discount').closest('p').removeClass('hide');
                                    }
                                }
                                // If coupon is invalid
                                else {
                                    resetCoupon('<i class="fa fa-exclamation-circle"></i> ' + data['msg']);
                                }
                            }
                        },
                        error: function() {
                        }
                    });
                });

                // Coupon - On click on "Remove" button
                $('#coupon-remove-btn').click(function(e) {
                    e.preventDefault();

                    $.ajax({
                        contentType: 'application/json',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                        },
                        url: "/shop/cart/update",
                        type: "POST",
                        data: JSON.stringify({
                            "coupon": false
                        }),
                        cache: false,
                        success: function(data) {
                            if (typeof data['status'] != 'undefined') {
                                // If coupon is removed
                                if (data['status'] === true) {
                                    updateFees(data); // Update the fees

                                    resetCoupon();
                                }
                            }
                        },
                        error: function() {
                        }
                    });
                });

                // On changing Payment Method
                $('input[name="payment_method"]').change(function() {
                    var val = $(this).val(),
                        paypal = val == 'paypal';

                    // Update the real (hidden) Payment Method
                    $('input[name="payment[method]"]').val(val);

                    // Disable/enable Billing fieldset, Credit Card fields, Card ID, and Save Payment Method checkbox
                    $('#billing-fieldset, ' +
                        'input[name="payment[cc_number]"],' +
                        'input[name="payment[cc_number]"],' +
                        'input[name="payment[cc_expiry_month]"],' +
                        'input[name="payment[cc_expiry_year]"],' +
                        'input[name="payment[cc_cvc]"],' +
                        'input[name="payment[cc_name]"],' +
                        'input[name="payment[save_payment_method]"],' +
                        'input[name="card_id"]').attr('disabled', paypal);

                    // Hide/show Billing block, Credit Card block, Current Card block, and Save Payment Method block
                    $('#billing-block, #credit-card-block, #current-card-block, #save-payment-method-block').toggleClass('hide', paypal);

                    if (paypal) {
                        $('#place-order-btn').html('Pay with <img src="/img/paypal.png" height="16px" />');
                    }
                    else {
                        $('#place-order-btn').html('Place Order &nbsp; <i class="fa fa-lock"></i>');
                    }

                });

                // On Checkout form submit
                $('#checkout-form').submit(function(e) {
                    e.preventDefault();

                    var $form = $(this);

                    if (!coupon['applied'] && coupon['code'] != '') {
                        alert('Please apply your coupon first');

                        return false;
                    } else if (coupon['applied'] && coupon['code'] == '') {
                        alert('Please apply your coupon again');

                        return false;
                    }

                    $('#place-order-btn').text('Placing order...');

                    // If total is $0, just submit
                    if (fees['total'] == 0) {
                        $form.get(0).submit();
                    }
                    else {
                        // If Pay Now/Pay Later is disabled or if it's enabled but Pay Now is selected
                        if ($('input[name="pay_now"]').length == 0 || $('input[name="pay_now"]').prop('checked')) {
                            // If Pay with Credit Card
                            if ($('input[name="payment[method]"]').val() == 'credit_card') {
                                {{-- For guests or users with no cards --}}
                                @if (!auth()->check() || auth()->user()->cards()->count() == 0)
                                // A handler callback function called when Striped converted Card info to a token
                                var stripeMainesponseHandler = function(status, response) {
                                    var $form = $('#checkout-form');

                                    if (response.error) {
                                        // Show the errors on the form
                                        $form.find('.payment-errors').text(response.error.message).removeClass('hide');
                                        $form.find('button').prop('disabled', false);

                                        $('#place-order-btn').text('Place Order');
                                    } else {
                                        // token contains id, last4, and card type
                                        var token = response.id;

                                        // Insert the token into the form so it gets submitted to the server
                                        $form.append($('<input type="hidden" name="stripe_token" />').val(token));

                                        // Disable the payment fields for PCI-Compliant
                                        $('#payment-fieldset').attr('disabled', true);

                                        // and re-submit
                                        $form.get(0).submit();
                                    }
                                };
                                @endif

                                // If there is a card_id
                                if ($('input[name="card_id"]').length > 0 && $('input[name="card_id"]').val() != '') {
                                    $form.get(0).submit();
                                }
                                // Else, submit the card info to Stripe to convert to a Stripe token
                                else {
                                    // Disable the submit button to prevent repeated clicks
                                    $form.find('button').prop('disabled', true);

                                    Stripe.card.createToken($form, stripeMainesponseHandler);

                                    // Prevent the form from submitting with the default action
                                    return false;
                                }
                            }
                            // Pay with PayPal
                            else {
                                $form.get(0).submit(); // Simply submit the form
                            }
                        }
                        // Else if Pay Later
                        else {
                            $('<input>').attr({"type": "hidden",  "name": "pay_later", "value": "1"}).appendTo($form);

                            $form.get(0).submit(); // Re-submit

                            return true;
                        }
                    }
                });
            });
        </script>

        @yield('bottom_block')
    @endslot

@endcomponent