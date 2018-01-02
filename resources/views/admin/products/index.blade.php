@component('layouts.admin')

    @slot('title')
        Admin - Manage Products - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-12">

            <h1>Products ({{ $products->total() }})</h1>

            @include('snippets.errors')
            @include('snippets.flash')

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th class="text-center">Category</th>
                        <th class="text-center">Order</th>
                        <th class="text-center">Product</th>
                        <th class="text-center">Inventory Items</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Old Price</th>
                        <th class="text-center">Edit</th>
                        <th class="text-center">Remove</th>
                    </tr>
                    @foreach ($products as $product)
                        <tr>
                            <td><a href="{{ route('admin.categories.show', $product['category_id']) }}">{{ collect($categories['list'])->keyBy('id')[$product['category_id']]['name'] }}</a></td>
                            <td class="text-right">{{ $product['order'] }}</td>
                            <td>
                                @if ($product->defaultPhoto()->count() > 0)
                                    <img src="{{ CustomHelper::image($product->defaultPhoto['name'], true) }}" alt="{!! $product['name'] !!}" width="50px" />
                                @endif

                                <a href="{{ route('admin.products.show', $product['id']) }}">{{ $product['name'] }}</a>
                                &middot;
                                <a href="{{ route('shop.product', [$product['uri'], $product['id']]) }}" target="_blank"><i class="fa fa-external-link"></i></a>

                                @if ($product['new'])
                                    &middot; <span class="label label-success">New</span>
                                @endif

                                @if ($product['special'])
                                    &middot; <span class="label label-primary">Special</span>
                                @endif

                                @if (!$product->inStock())
                                    &middot; <span class="label label-danger">Out of Stock</span>
                                @elseif ($product->hasOutOfStock())
                                    &middot; <span class="label label-warning">Inventory Out of Stock</span>
                                @endif
                            </td>
                            <td class="text-right">{{ $product->inventoryItems()->count() }}</td>
                            <td class="text-right">${{ number_format($product['price'], 2) }}</td>
                            <td class="text-right text-muted">
                                @if ($product['old_price'] > 0)
                                    <del>${{ number_format($product['old_price'], 2) }}</del>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="text-center"><a href="{{ route('admin.products.show', $product['id']) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a></td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('admin.products.destroy', $product['id']) }}" accept-charset="UTF-8" role="form" onsubmit="return confirm('Do you really want to remove this product?');">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            {{ $products->links() }}

        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add new Product</a><br /><br />
        </div>
    </div>

@endcomponent