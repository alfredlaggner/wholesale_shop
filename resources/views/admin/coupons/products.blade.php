<div class="table-responsive" style="max-height: 360px; overflow-y: auto;">
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th class="text-center">Category</th>
            <th class="text-center">Photo</th>
            <th class="text-center">Product</th>
            <th class="text-center">Applicable</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td><a href="{{ route('admin.categories.show', $product['category_id']) }}">{{ collect($categories['list'])->keyBy('id')[$product['category_id']]['name'] }}</a></td>
                <td>
                    @if ($product->defaultPhoto()->count() > 0)
                        <img src="{{ CustomHelper::image($product->defaultPhoto['name'], true) }}" alt="{!! $product['name'] !!}" width="50px" />
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.products.show', $product['id']) }}">{{ $product['name'] }}</a>
                    &middot;
                    <a href="{{ route('shop.product', [$product['uri'], $product['id']]) }}" target="_blank"><i class="fa fa-external-link"></i></a>
                </td>
                <td class="text-center">
                    <input type="checkbox" name="products[]" value="{{ $product['id'] }}"{{ isset($coupon) && $coupon->products()->count() > 0 && in_array($product['id'], $coupon->products()->pluck('products.id')->toArray()) ? ' checked' : '' }} />
                </td>
            </tr>
        @endforeach
    </table>
</div>