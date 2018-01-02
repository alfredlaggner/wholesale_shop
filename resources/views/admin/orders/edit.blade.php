@component('layouts.admin')

    @slot('title')
        Admin - Edit Order - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-12">

            <h2>Admin - Edit Order</h2>

            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" action="{{ route('admin.orders.update', $order['id']) }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="row">

                    <div class="col-md-6">

                        <div class="checkout-box">

                            <h2>
                                Order

                                <span class="pull-right">
                                    {!! CustomHelper::formatOrderPaymentStatus($order) !!}

                                    @if ($order['payment_status'] == 'paid' && (in_array($order['payment_method'], ['card', 'paypal'])))
                                        <a href="#" id="refund-btn" class="btn btn-info btn-sm" title="Click here to make a full refund for this order"><i class="fa fa-reply"></i> Refund</a>
                                    @endif
                                </span>
                            </h2>

                            <div class="form-group{{ $errors->has('order_number') ? ' has-error' : '' }}">
                                <label for="order-number" class="control-label required">Order Number:</label>

                                <input type="text" id="order-number" class="form-control" name="order_number" value="{{ old('order_number', $order['order_number']) }}" maxlength="10" required />

                                @include('snippets.errors_first', ['param' => 'order_number'])
                            </div>

                            <div class="form-group{{ $errors->has('confirmation_code') ? ' has-error' : '' }}">
                                <label for="confirmation-code" class="control-label required">Confirmation Code:</label>

                                <input type="text" id="confirmation-code" class="form-control" name="confirmation_code" value="{{ old('confirmation_code', $order['confirmation_code']) }}" maxlength="6" required />

                                @include('snippets.errors_first', ['param' => 'confirmation_code'])
                            </div>

                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <label for="status" class="control-label required">Order Status:</label>

                                <select id="status" class="form-control" name="status" required>
                                    @foreach (config('custom.order_status') as $key => $value)
                                        <option value="{{ $key }}"{{ old('status', !empty($order['status']) ? $order['status'] : '') == $key ? ' selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>

                                @include('snippets.errors_first', ['param' => 'status'])
                            </div>

                            <div class="form-group{{ $errors->has('payment_status') ? ' has-error' : '' }}">
                                <label for="payment-status" class="control-label required">Payment Status:</label>

                                <select id="payment-status" class="form-control" name="payment_status" required>
                                    @foreach (config('custom.payment_status') as $key => $value)
                                        <option value="{{ $key }}"{{ old('payment_status', $order['payment_status']) == $key ? ' selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>

                                @include('snippets.errors_first', ['param' => 'payment_status'])
                            </div>

                            <div class="form-group{{ $errors->has('payment_method') ? ' has-error' : '' }}">
                                <label for="payment-method" class="control-label">Payment Method:</label>

                                <select id="payment-method" class="form-control" name="payment_method">
                                    <option value="">Select one</option>
                                    @foreach (config('custom.payment_method') as $key => $value)
                                        <option value="{{ $key }}"{{ old('payment_method', $order['payment_method']) == $key ? ' selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>

                                @include('snippets.errors_first', ['param' => 'payment_method'])
                            </div>

                            <div class="form-group{{ $errors->has('contact_email') ? ' has-error' : '' }}">
                                <label for="contact-email" class="control-label required">Contact Email:</label>

                                <input type="email" id="contact-email" class="form-control" name="contact_email" value="{{ old('contact_email', $order['contact_email']) }}" maxlength="255" required />

                                @include('snippets.errors_first', ['param' => 'contact_email'])
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="checkout-box">

                            <h2>
                                Shipping

                                <a href="{{ route('admin.orders.send_email', [$order['id'], 'shipping_confirmation']) }}" class="btn btn-sm btn-info pull-right" title="Send shipping confirmation email to customer"><i class="fa fa-envelope"></i> Send Shipping Email</a>
                            </h2>

                            <div class="form-group{{ $errors->has('shipping_carrier') ? ' has-error' : '' }}">
                                <label for="shipping-carrier" class="control-label">Shipping Carrier:</label>

                                <select id="shipping-carrier" class="form-control" name="shipping_carrier">
                                    <option value="">Select a shipping carrier</option>
                                    <option value="usps"{{ old('shipping_carrier', $order['shipping_carrier']) == 'usps' ? ' selected' : '' }}>USPS</option>
                                </select>

                                @include('snippets.errors_first', ['param' => 'shipping_carrier'])
                            </div>

                            <div class="form-group{{ $errors->has('shipping_plan') ? ' has-error' : '' }}">
                                <label for="shipping-plan" class="control-label">Shipping Plan:</label>

                                <select id="shipping-plan" class="form-control" name="shipping_plan">
                                    <option value="">Select a shipping carrier</option>
                                    <option value="standard"{{ old('shipping_plan', $order['shipping_plan']) == 'standard' ? ' selected' : '' }}>Standard (USPS Priority Mail 1-2 Day)</option>
                                    <option value="express"{{ old('shipping_plan', $order['shipping_plan']) == 'express' ? ' selected' : '' }}>Express (USPS Priority Mail Express 1-Day)</option>
                                </select>

                                @include('snippets.errors_first', ['param' => 'shipping_plan'])
                            </div>

                            <div class="form-group{{ $errors->has('shipping_tracking_number') ? ' has-error' : '' }}">
                                <label for="shipping-tracking-number" class="control-label">Tracking Number:</label>

                                <input type="text" id="shipping-tracking-number" class="form-control" name="shipping_tracking_number" value="{{ old('shipping_tracking_number', $order['shipping_tracking_number']) }}" maxlength="45" />

                                @include('snippets.errors_first', ['param' => 'shipping_tracking_number'])
                            </div>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">

                        <div class="checkout-box">

                            <h2>Delivery</h2>

                            <div class="form-group{{ $errors->has('delivery_name') ? ' has-error' : '' }}">
                                <label for="delivery-name" class="control-label required">Name:</label>

                                <input type="text" id="delivery-name" class="form-control" name="delivery_name" value="{{ old('delivery_name', $order['delivery_name']) }}" maxlength="255" required />

                                @include('snippets.errors_first', ['param' => 'delivery_name'])
                            </div>

                            <div class="form-group{{ $errors->has('delivery_address_1') ? ' has-error' : '' }}">
                                <label for="delivery-address-1" class="control-label required">Address 1:</label>

                                <input type="text" id="delivery-address-1" class="form-control" name="delivery_address_1" value="{{ old('delivery_address_1', $order['delivery_address_1']) }}" maxlength="255" required />

                                @include('snippets.errors_first', ['param' => 'delivery_address_1'])
                            </div>

                            <div class="form-group{{ $errors->has('delivery_address_2') ? ' has-error' : '' }}">
                                <label for="delivery-address-2" class="control-label">Address 2:</label>

                                <input type="text" id="delivery-address-2" class="form-control" name="delivery_address_2" value="{{ old('delivery_address_2', $order['delivery_address_2']) }}" maxlength="255" />

                                <p class="help-block">Apt. / Ste.</p>

                                @include('snippets.errors_first', ['param' => 'delivery_address_2'])
                            </div>

                            <div class="form-group{{ $errors->has('delivery_city') ? ' has-error' : '' }}">
                                <label for="delivery-city" class="control-label required">City:</label>

                                <input type="text" id="delivery-city" class="form-control" name="delivery_city" value="{{ old('delivery_city', $order['delivery_city']) }}" maxlength="255" required />

                                @include('snippets.errors_first', ['param' => 'delivery_city'])
                            </div>

                            <div class="form-group{{ $errors->has('delivery_state') ? ' has-error' : '' }}">
                                <label for="delivery-state" class="control-label required">State:</label>

                                <select id="delivery-state" class="form-control" name="delivery_state" required>
                                    <option value="">Select one</option>
                                    @foreach (config('custom.states') as $key => $value)
                                        <option value="{{ $key }}"{{ old('delivery_state', $order['delivery_state']) == $key ? ' selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>

                                @include('snippets.errors_first', ['param' => 'delivery_state'])
                            </div>

                            <div class="form-group{{ $errors->has('delivery_zipcode') ? ' has-error' : '' }}">
                                <label for="delivery-zipcode" class="control-label required">Postal code:</label>

                                <input type="text" id="delivery-zipcode" class="form-control" name="delivery_zipcode" value="{{ old('delivery_zipcode', $order['delivery_zipcode']) }}" maxlength="20" required />

                                @include('snippets.errors_first', ['param' => 'delivery_zipcode'])
                            </div>

                            <div class="form-group{{ $errors->has('delivery_phone') ? ' has-error' : '' }}">
                                <label for="delivery-phone" class="control-label required">Phone Number:</label>

                                <input type="text" id="delivery-phone" class="form-control" name="delivery_phone" value="{{ old('delivery_phone', $order['delivery_phone']) }}" maxlength="20" required />

                                @include('snippets.errors_first', ['param' => 'delivery_phone'])
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="checkout-box">

                            <h2>Billing</h2>

                            <div class="form-group{{ $errors->has('billing_name') ? ' has-error' : '' }}">
                                <label for="billing-name" class="control-label">Name:</label>

                                <input type="text" id="billing-name" class="form-control" name="billing_name" value="{{ old('billing_name', $order['billing_name']) }}" maxlength="255" />

                                @include('snippets.errors_first', ['param' => 'billing_name'])
                            </div>

                            <div class="form-group{{ $errors->has('billing_address_1') ? ' has-error' : '' }}">
                                <label for="billing-address-1" class="control-label">Address 1:</label>

                                <input type="text" id="billing-address-1" class="form-control" name="billing_address_1" value="{{ old('billing_address_1', $order['billing_address_1']) }}" maxlength="255" />

                                @include('snippets.errors_first', ['param' => 'billing_address_1'])
                            </div>

                            <div class="form-group{{ $errors->has('billing_address_2') ? ' has-error' : '' }}">
                                <label for="billing-address-2" class="control-label">Address 2:</label>

                                <input type="text" id="billing-address-2" class="form-control" name="billing_address_2" value="{{ old('billing_address_2', $order['billing_address_2']) }}" maxlength="255" />

                                <p class="help-block">Apt. / Ste.</p>

                                @include('snippets.errors_first', ['param' => 'billing_address_2'])
                            </div>

                            <div class="form-group{{ $errors->has('billing_city') ? ' has-error' : '' }}">
                                <label for="billing-city" class="control-label">City:</label>

                                <input type="text" id="billing-city" class="form-control" name="billing_city" value="{{ old('billing_city', $order['billing_city']) }}" maxlength="255" />

                                @include('snippets.errors_first', ['param' => 'billing_city'])
                            </div>

                            <div class="form-group{{ $errors->has('billing_state') ? ' has-error' : '' }}">
                                <label for="billing-state" class="control-label">State:</label>

                                <select id="billing-state" class="form-control" name="billing_state">
                                    <option value="">Select one</option>
                                    @foreach (config('custom.states') as $key => $value)
                                        <option value="{{ $key }}"{{ old('billing_state', $order['billing_state']) == $key ? ' selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>

                                @include('snippets.errors_first', ['param' => 'billing_state'])
                            </div>

                            <div class="form-group{{ $errors->has('billing_zipcode') ? ' has-error' : '' }}">
                                <label for="billing-zipcode" class="control-label">Postal code:</label>

                                <input type="text" id="billing-zipcode" class="form-control" name="billing_zipcode" value="{{ old('billing_zipcode', $order['billing_zipcode']) }}" maxlength="20" />

                                @include('snippets.errors_first', ['param' => 'billing_zipcode'])
                            </div>

                            <div class="form-group{{ $errors->has('billing_phone') ? ' has-error' : '' }}">
                                <label for="billing-phone" class="control-label">Phone Number:</label>

                                <input type="text" id="billing-phone" class="form-control" name="billing_phone" value="{{ old('billing_phone', $order['billing_phone']) }}" maxlength="20" />

                                @include('snippets.errors_first', ['param' => 'billing_phone'])
                            </div>

                            <p class="buttons">
                                <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> Update</button>
                            </p>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

    @slot('bottomBlock')
        <script type="text/javascript">
            $( document ).ready(function() {
                $('#refund-btn').click(function(e) {
                    e.preventDefault();

                    var $form = $(this).closest('form');

                    $('<input>').attr({"type": "hidden",  "name": "refund", "value": true}).appendTo($form);

                    var r = confirm('Are you sure you want to refund this order?');

                    if (r == true) {
                        $form.submit();
                    } else {
                        return false;
                    }
                });
            });
        </script>
    @endslot

@endcomponent