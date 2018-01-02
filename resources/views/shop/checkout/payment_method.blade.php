<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="payment-method" class="control-label required">Payment Method:</label><br /><br />

            <label style="color: #666666; font-size: 14px; font-weight: normal;">
                <input type="radio" name="payment_method" value="credit_card"{{ old('payment[method]') == 'credit_card' ? ' checked' : (isset($cart['payment']) && !empty($cart['payment']['method']) ? ($cart['payment']['method'] == 'credit_card' ? ' checked': '') : ' checked') }} />

                <img src="/img/credit-cards.png" height="20px" />
            </label><br /><br />

            <label style="color: #666666; font-size: 14px; font-weight: normal;">
                <input type="radio" name="payment_method" value="paypal"{{ old('payment[method]') == 'paypal' ? ' checked' : (isset($cart['payment']) && !empty($cart['payment']['method']) ? ($cart['payment']['method'] == 'paypal' ? ' checked': '') : '') }} />

                <img src="/img/paypal.png" height="20px" />
            </label>
        </div>
    </div>
</div>