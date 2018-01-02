@component('layouts.master')

    @slot('title')
        Create payment method - {{ config('app.name') }}
    @endslot

    @slot('_token')
        {{ csrf_token() }}
    @endslot

    <div class="row content">

        <div class="col-md-12">
            <!-- Nav tabs -->
            @include('users.tabs')

            <ol class="breadcrumb">
                <li><a href="{{ route('payments') }}" role="tab">Payment Methods</a></li>
                <li class="active">Create payment method</li>
            </ol>

            <h1>Enter new Credit Card</h1>
        </div>

        <div class="col-md-6">
            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" id="add-payment-card-form" action="{{ route('payments.store') }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-12">
                        <div class="payment-errors alert alert-danger hide"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group card-number">
                            <label for="payment-cc-number" class="control-label required">Credit Card Number:</label>

                            <input type="number" id="payment-cc-number" class="form-control" name="payment[cc_number]" value="" data-stripe="number" maxlength="20" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="col-xs-6 col-lg-6 pl-zero">
                                <label for="payment-cc-expiry-month" class="control-label required">Month (MM):</label>

                                <input type="text" id="payment-cc-expiry-month" class="form-control" name="payment[cc_expiry_month]" value="" data-stripe="exp-month" required />
                            </div>

                            <div class="col-xs-6 col-lg-6 pl-zero">
                                <label for="payment-cc-expiry-year" class="control-label required">Year (YY):</label>

                                <input type="text" id="payment-cc-expiry-year" class="form-control" name="payment[cc_expiry_year]" value="" data-stripe="exp-year" required />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment-cc-cvc" class="control-label required">CVC:</label>

                            <input type="number" id="payment-cc-cvc" class="form-control" name="payment[cc_cvc]" value="" data-stripe="cvc" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="payment-cc-name" class="control-label required">Name On Card:</label>

                            <input type="text" id="payment-cc-name" class="form-control" name="payment[cc_name]" value="" data-stripe="name" maxlength="100" required />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success" title="Add this payment method"><i class="fa fa-save"></i> Submit</button>
                    </div>
                </div>

            </form>
        </div>

    </div>

    @slot('bottomBlock')
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

        <script>
            // This identifies your website in the createToken call below
            Stripe.setPublishableKey('{{ env('STRIPE_KEY') }}');

            $( document ).ready(function() {

                // Instantly show the card type
                $('.card-number input').keyup(function() {
                    var cardNumber = $(this).val(),
                        cardType = false;

                    if (cardNumber.match(/^4/)) {
                        cardType = 'visa';
                    } else if (cardNumber.match(/^5[1-5]/)) {
                        cardType = 'mastercard';
                    } else if (cardNumber.match(/^3[47]/)) {
                        cardType = 'american-express';
                    } else if (cardNumber.match(/^6(?:011|5)/)) {
                        cardType = 'discover';
                    } else if (cardNumber.match(/^(?:2131|1800|35)/)) {
                        cardType = 'jcb';
                    } else if (cardNumber.match(/^3(?:0[0-5]|[68])/)) {
                        cardType = 'diners-club';
                    }

                    $(this).parent('.card-number').removeClass('card-type-visa card-type-mastercard card-type-american-express card-type-discover card-type-jcb card-type-diners-club');

                    if (cardType !== false) {
                        $(this).parent('.card-number').addClass('card-type-' + cardType);
                    }
                })
                // Validate the full card number
                .focusout(function() {
                    var re = {
                        "visa": /^4[0-9]{12}(?:[0-9]{3})?$/,
                        "mastercard": /^5[1-5][0-9]{14}$/,
                        "american-express": /^3[47][0-9]{13}$/,
                        "diners-club": /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
                        "discover": /^6(?:011|5[0-9]{2})[0-9]{12}$/,
                        "jcb": /^(?:2131|1800|35\d{3})\d{11}$/
                    }

                    var cardNumber = $(this).val(),
                        cardType = false;

                    for (var key in re) {
                        if(re[key].test(cardNumber)) {
                            cardType = key;
                            break;
                        }
                    }

                    $(this).parent('.card-number').removeClass('card-type-visa card-type-mastercard card-type-american-express card-type-discover card-type-jcb card-type-diners-club');

                    if (cardType !== false) {
                        $(this).parent('.card-number').addClass('card-type-' + cardType);
                    }
                });

                var stripeResponseHandler = function(status, response) {
                    var $form = $('#add-payment-card-form');

                    if (response.error) {
                        // Show the errors on the form
                        $form.find('.payment-errors').text(response.error.message).removeClass('hide');
                        $form.find('button').prop('disabled', false);
                    } else {
                        // token contains id, last4, and card type
                        var token = response.id;

                        $.ajax({
                            headers: {
                                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                            },
                            url: "/shop/payments",
                            type: "POST",
                            data: {
                                "stripe_token": token
                            },
                            cache: false,
                            success: function(data) {
                                if (typeof data['status'] != 'undefined' && data['status'] === true) {
                                    window.location.href = '/payments';
                                }
                            },
                            error: function() {
                            }
                        });
                    }
                };

                $('#add-payment-card-form').submit(function() {
                    var $form = $(this);

                    // Disable the submit button to prevent repeated clicks
                    $form.find('button').prop('disabled', true);

                    Stripe.card.createToken($form, stripeResponseHandler);

                    return false;
                });
            });
        </script>
    @endslot

@endcomponent