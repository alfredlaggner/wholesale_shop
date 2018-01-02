<div class="row">
    <div class="col-md-3">
        <h5 style="line-height: normal; margin-top: 0;">Shipping</h5>
    </div>
    <div class="col-md-9">
        @if (app()->global['settings']['pay_later']['state'] && app()->global['settings']['cash_on_delivery']['state'])
            <label id="cash-on-delivery" style="color: #666666; font-size: 14px; font-weight: normal;"{!! session('cart.shipping') == 'cash_on_delivery' ? '' : ' class="hide"' !!}>
                <input type="checkbox" name="cash_on_delivery" {!! session('cart.shipping') == 'cash_on_delivery' ? 'checked' : ' disabled="disabled"' !!} />

                Cash on Delivery
                <br /><br />
            </label>
        @endif

        @foreach (config('custom.checkout.shipping.carriers') as $carrier => $carrierDetails)
            <fieldset class="shipping{!! session('cart.shipping') == 'cash_on_delivery' ? ' hide' : '' !!}"{!! session('cart.shipping') == 'cash_on_delivery' ? ' disabled="disabled"' : '' !!}>
                <legend style="color: #666666;">{{ $carrierDetails['name'] }}</legend>

                @foreach ($carrierDetails['plans'] as $plan => $planDetails)
                    <label style="color: #666666; font-size: 14px; font-weight: normal;">
                        <input type="radio" name="shipping[{{ $carrier }}]" value="{{ $plan }}"{{ isset($cart['shipping']) && isset($cart['shipping']['carrier']) ? ($carrier == $cart['shipping']['carrier'] && $plan == $cart['shipping']['plan'] ? ' checked' : '') : ($carrier == $shipping['default'][0] && $plan == $shipping['default'][1] ? ' checked' : '') }} />

                        {{ $planDetails['name'] }} ({{ $planDetails['plan'] }}) - ${{ number_format($planDetails['fee'], 2) }}
                    </label><br />
                @endforeach

                <br />
            </fieldset>
        @endforeach

        <hr class="separator" /><br />
    </div>
</div>

@section('bottom_block')
    @parent
    <script>
        $( document ).ready(function() {
            $('input[type="radio"][name^="shipping"]').change(function() {
                if ($(this).prop('checked')) {
                    $('input[type="radio"][name^="shipping"]').prop('checked', false); // Turn off other shipping options
                    $(this).prop('checked', true); // Turn this shipping option on

                    var name = $(this).attr('name'),
                        carrier = name.substring(9, name.indexOf(']')),
                        val = $(this).val();

                    $.ajax({
                        headers: {
                            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                        },
                        url: "/shop/cart/update",
                        type: "POST",
                        data: {
                            shipping: {
                                "carrier": carrier,
                                "plan": val
                            }
                        },
                        cache: false,
                        success: function(data) {
                            if (typeof data['status'] != 'undefined' && data['status'] === true) {
                                if (typeof data['fees'] != 'undefined') {
                                    $('#cart-shipping').text(data['fees']['shipping'].toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
                                    $('#cart-total').text(data['fees']['total'].toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,"));
                                }
                            }
                        },
                        error: function() {
                        }
                    });
                }
            });
        });
    </script>
@stop