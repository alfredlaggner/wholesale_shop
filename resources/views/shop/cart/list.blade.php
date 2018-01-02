@if (count($cartItems) > 0)
    <table class="basket-table">
        <thead>
        <tr class="row">
            <th class="col-md-8">Item</th>
            <th class="col-md-2">Quantity</th>
            <th class="col-md-2 text-right">Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($cartItems as $cartItem)
            @if (!empty($cartItem['inventory_item']))
                <tr class="row" id="item-{{ $cartItem['inventory_id'] }}" data-price="{{ $cartItem['price'] }}">
                    <td class="col-md-8">
                        @if ($cartItem['inventory_item']->product->defaultPhoto()->count() > 0)
                            <img class="img-thumbnail pull-left" src="{!! CustomHelper::image($cartItem['inventory_item']->product->defaultPhoto['name'], true) !!}" alt="{!! $cartItem['inventory_item']->product['name'] !!}" style="margin-right: 20px;" />
                        @endif

                        <a href="{{ route('shop.product', [$cartItem['inventory_item']->product['uri'], $cartItem['inventory_item']->product['id']]) }}" title="View this item">{{ $cartItem['inventory_item']->product['name'] }}</a><br />

                        @if ($cartItem['inventory_item']->options()->count() > 0)
                            <ul class="list-unstyled">
                                @foreach ($cartItem['inventory_item']->options()->get() as $option)
                                    <li>{!! $option->attribute['name'] !!}: {!! $option['name'] !!}</li>
                                @endforeach
                            </ul>
                        @endif

                        <p class="text-muted" style="margin-top: 10px;">${{ number_format($cartItem['price'], 2) }}</p>
                    </td>
                    <td class="col-md-2">
                        <div class="form-inline">
                            <select class="form-control text-right" name="number" style="width: 100px;">
                                @foreach (range(0, $cartItem['stock']) as $key)
                                    <option value="{{ $key }}"{{ $cartItem['quantity'] == $key ? ' selected' : '' }}>{{ $key }}</option>
                                @endforeach
                            </select>

                            <a href="javascript:void(0);" title="Remove this item" class="remove-btn"><i class="fa fa-times"></i></a>
                        </div>
                    </td>
                    <td class="col-md-2 text-right">$<span class="item-total">{{ number_format($cartItem['price'] * $cartItem['quantity'], 2) }}</span></td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-warning">Your cart is currently empty, please add some items to cart first.</div>
@endif