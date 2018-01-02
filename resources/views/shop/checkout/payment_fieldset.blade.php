<div class="row">
    <div class="col-md-12">
        <div class="payment-errors alert alert-danger hide"></div>
    </div>
</div>

<fieldset id="payment-fieldset"{{ $fees['total'] == 0 ? ' disabled' : '' }}>
    @if (env('PAYPAL_MODE'))
        @include('shop.checkout.payment_method')
    @endif

    <div id="credit-card-block">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="payment-cc-number" class="control-label required">Credit Card Number:</label>

                    <input type="text" id="payment-cc-number" class="form-control" name="payment[cc_number]" value="" data-stripe="number" maxlength="20" required />
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
    </div>
</fieldset>