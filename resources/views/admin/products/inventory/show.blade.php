@component('layouts.admin')

    @slot('title')
        Admin - Edit Product Inventory Item - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-12">

            <h2>Admin - Edit Product Inventory Item</h2>

            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" action="{{ route('admin.products.product.inventory.update', [$product['id'], $inventoryItem['id']]) }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
                            <label for="sku" class="control-label required">SKU:</label>

                            <input type="text" id="sku" class="form-control" name="sku" value="{{ old('sku', $inventoryItem['sku']) }}" maxlength="100" required />

                            <p class="help-block">
                                A unique code name for each inventory item. Convention: (capital product name with option keys,
                                separated by underscores).<br />

                                For example, if the product name is Single Lashes, and it has 3 options with the following option
                                keys: J, 015, 11, then the suggested SKU value is <strong>SL_J_015_11</strong>.
                            </p>

                            @include('snippets.errors_first', ['param' => 'sku'])
                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="control-label required">Price Difference:</label>

                            <input type="number" id="price" class="form-control" name="price" value="{{ number_format(old('price', $inventoryItem['price']), 2) }}" maxlength="6" step="0.01" required />

                            <p class="help-block">
                                Set this value if you want this item to have different price (in dollars) from its product's price (${{ money_format('%i', $inventoryItem->product['price']) }}).<br />
                                For example, if the product's price is ${{ money_format('%i', $inventoryItem->product['price']) }}, then putting a value of <strong>1.50</strong> will make this item's price as <strong>${{ money_format('%i', ($inventoryItem->product['price'] + 1.50)) }}</strong>,<br />
                                or <strong>-1.00</strong> will make this item's price as <strong>${{ money_format('%i', ($inventoryItem->product['price'] - 1.00)) }}</strong><br />
                                Leave this field with value <strong>0.00</strong> will make this item has the same price as its product's price (${{ money_format('%i', $inventoryItem->product['price']) }}).
                            </p>

                            @include('snippets.errors_first', ['param' => 'price'])
                        </div>

                        <div class="form-group{{ $errors->has('stock') ? ' has-error' : '' }}">
                            <label for="stock" class="control-label required">Stock:</label>

                            <input type="number" id="stock" class="form-control" name="stock" value="{{ old('stock', $inventoryItem['stock']) }}" maxlength="10" required />

                            <p class="help-block">How many of this item (with the selected options) are in your inventory.</p>

                            @include('snippets.errors_first', ['param' => 'stock'])
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" title="Update this inventory item"><i class="fa fa-save"></i> Update</button>

                            <a href="{{ route('admin.products.show', $inventoryItem->product['id']) }}" class="btn">Cancel</a>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="options" class="control-label">Options:</label>

                            <br />
                            @foreach ($attributes as $attribute)
                                @if ($attribute->options() && $attribute->options()->count() > 0)
                                    <strong>{{ $attribute['name'] }}</strong>

                                    @foreach ($attribute->options as $option)
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="options[]" value="{{ $option['id'] }}"{{ in_array($option['id'], collect($inventoryItem->options()->get()->toArray())->pluck('id')->all()) ? ' checked' : '' }} />

                                                {{ $option['name'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>

            </form>

        </div>

    </div>

@endcomponent