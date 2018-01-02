@component('layouts.admin')

    @slot('title')
        Admin - Create new Coupon - {{ config('app.name') }}
    @endslot

    @slot('headerBlock')
        <link media="all" type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css" />
    @endslot

    <div class="row">

        <div class="col-md-12">

            <h2>Create new Coupon</h2>

            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" class="form-horizontal" action="{{ route('admin.coupons.store') }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}

                <div class="row">

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <label for="code" class="control-label required">Coupon Code:</label>

                                <input type="text" id="code" class="form-control" name="code" value="{{ old('code') }}" maxlength="20" required />

                                @include('snippets.errors_first', ['param' => 'code'])

                                <p class="help-block">
                                    Coupon code must be unique, and only use alphanumeric, dash, and underscore letters.
                                </p>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('type') || $errors->has('discount') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <label for="type" class="control-label required">Discount Type:</label>

                                <select id="type" class="form-control" name="type" required>
                                    <option value="percentage"{{ old('type') == 'percentage' ? ' selected' : '' }}>Percentage</option>
                                    <option value="amount"{{ old('type') == 'amount' ? ' selected' : '' }}>Amount</option>
                                </select>

                                <p class="help-block" id="discount-percentage-help-block">
                                    How many percents discounted from the order subtotal.
                                </p>

                                <p class="help-block hide" id="discount-amount-help-block">
                                    The exact amount discounted from the order subtotal.
                                </p>

                                @include('snippets.errors_first', ['param' => 'type'])
                            </div>

                            <div class="col-md-6" id="discount-percentage-block">
                                <label for="discount-percentage" class="control-label required">Discount Percentage:</label>

                                <div class="input-group">
                                    <input type="number" id="discount-percentage" class="form-control" name="discount_percentage" value="{{ old('discount_percentage') }}" max="100" maxlength="3" min="0" pattern="[0-9]{10}" step="1" required />

                                    <div class="input-group-addon">%</div>
                                </div>

                                @include('snippets.errors_first', ['param' => 'discount_percentage'])
                            </div>

                            <div class="col-md-6 hide" id="discount-amount-block">
                                <label for="discount-amount" class="control-label required">Discount Amount:</label>

                                <div class="input-group">
                                    <div class="input-group-addon">$</div>

                                    <input type="number" id="discount-amount" class="form-control" name="discount_amount" value="{{ old('discount_amount') }}" maxlength="6" min="0" step="0.01" disabled required />
                                </div>

                                @include('snippets.errors_first', ['param' => 'discount_amount'])
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('shipping') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="shipping" class="control-label">Free Shipping:</label>

                                <input type="checkbox" id="shipping" name="shipping" value="1"{{ old('shipping') ? ' checked' : '' }} />

                                <p class="help-block">
                                    Whether the order has free shipping. This does not apply for Express shipping method.
                                </p>

                                @include('snippets.errors_first', ['param' => 'shipping'])
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('limited') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="limited" class="control-label">Limited:</label>

                                <input type="checkbox" id="limited" name="limited" value="1"{{ old('limited') ? ' checked' : '' }} />

                                <p class="help-block">
                                    Check for this coupon to be used for limited times; otherwise, the coupon can be used
                                    for unlimited times (unless it's inactive or expired).
                                </p>

                                @include('snippets.errors_first', ['param' => 'limited'])
                            </div>
                        </div>

                        <div class="form-group hide{{ $errors->has('limit') ? ' has-error' : '' }}" id="limit-block">
                            <div class="col-md-6">
                                <label for="limit" class="control-label required">Limit:</label>

                                <input type="number" id="limit" class="form-control" name="limit" value="{{ old('limit') }}" maxlength="10" disabled required />

                                <p class="help-block">
                                    How many times this coupon can be used.
                                </p>

                                @include('snippets.errors_first', ['param' => 'limit'])
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('start') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <label for="start" class="control-label">Start Date:</label>

                                <div class="input-group date">
                                    <input type="text" id="start" class="form-control" name="start" value="{{ old('start') }}" />

                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                </div>

                                @include('snippets.errors_first', ['param' => 'start'])
                            </div>

                            <div class="col-md-6">
                                <label for="end" class="control-label">Expired Date:</label>

                                <div class="input-group date">
                                    <input type="text" id="end" class="form-control" name="end" value="{{ old('end') }}" />

                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                </div>

                                @include('snippets.errors_first', ['param' => 'end'])
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="products" class="control-label">Applicable Products:</label>

                                <p class="alert alert-info">
                                    <i class="fa fa-info-circle"></i> Leave blank if you want the coupon to be applicable for ALL products.<br />
                                    If coupon is not restricted to any products, then discount will be applied to all items in the cart. <br />
                                    If coupon is restricted to some products, then discount will be applied to all items of those products in the cart.
                                </p>

                                @include('admin.coupons.products')
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success pull-right" title="Create this new coupon"><i class="fa fa-save"></i> Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>

    </div>

    @slot('bottomBlock')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>

        <script>
            $(document).ready(function() {
                // Initialize the Date & Time picker for Start & Expired Dates
                $('input[name="start"]').parent().datetimepicker();

                $('input[name="end"]').parent().datetimepicker();

                var switchDiscountBlock = function() {
                    var type = $('select[name="type"]').val();

                    $('#discount-percentage-block, #discount-percentage-help-block').toggleClass('hide', type != 'percentage');

                    $('#discount-amount-block, #discount-amount-help-block').toggleClass('hide', type == 'percentage');

                    $('#discount-percentage').prop('disabled', type != 'percentage');

                    $('#discount-amount').prop('disabled', type == 'percentage');
                };

                var toggleLimitBlock = function() {
                    var checked = $('input[type="checkbox"][name="limited"]').prop('checked');

                    $('#limit-block').toggleClass('hide', !checked);

                    $('#limit-block input').prop('disabled', !checked);
                };

                switchDiscountBlock();

                toggleLimitBlock();

                $('select[name="type"]').change(function() {
                    switchDiscountBlock();
                });

                $('input[type="checkbox"][name="limited"]').change(function() {
                    toggleLimitBlock();
                });
            });
        </script>
    @endslot

@endcomponent