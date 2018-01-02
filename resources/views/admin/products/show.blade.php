@component('layouts.admin')

    @slot('title')
        Admin - Edit Product - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-5">

            <h2>Details</h2>

            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" action="{{ route('admin.products.update', $product['id']) }}" accept-charset="UTF-8" enctype="multipart/form-data" role="form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="control-label required">Product Name:</label>

                    <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $product['name']) }}" maxlength="255" required />

                    @include('snippets.errors_first', ['param' => 'name'])
                </div>

                <div class="form-group{{ $errors->has('uri') ? ' has-error' : '' }}">
                    <label for="uri" class="control-label required">Product URI:</label>

                    <input type="text" id="uri" class="form-control" name="uri" value="{{ old('uri', $product['uri']) }}" maxlength="255" required />

                    <p class="help-block">To be used in the URL, make sure to use lowercase with hyphen, i.e. "product-title".</p>

                    @include('snippets.errors_first', ['param' => 'uri'])
                </div>

                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label for="description" class="control-label">Product Description:</label>

                    <textarea id="description" class="form-control" name="description" maxlength="2048" rows="5">{{ old('description', $product['description']) }}</textarea>

                    @include('snippets.errors_first', ['param' => 'description'])
                </div>

                <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                    <label for="price" class="control-label required">Price:</label>

                    <input type="text" id="price" class="form-control" name="price" value="{{ old('price', number_format($product['price'], 2)) }}" maxlength="10" required />

                    @include('snippets.errors_first', ['param' => 'price'])
                </div>

                <div class="form-group{{ $errors->has('old_price') ? ' has-error' : '' }}">
                    <label for="old-price" class="control-label">Old Price:</label>

                    <input type="text" id="old-price" class="form-control" name="old_price" value="{{ old('old_price', number_format($product['old_price'], 2)) }}" maxlength="10" />

                    @include('snippets.errors_first', ['param' => 'old_price'])
                </div>

                <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                    <label for="category-id" class="control-label required">Category:</label>

                    <select id="category-id" class="form-control" name="category_id" required>
                        <option value="">Select one</option>
                        @foreach(collect($categories['list'])->mapWithKeys(function ($item) {
                                return [$item['id'] => str_repeat('- ', $item['parents']) . $item['name']];
                            }) as $key => $value)
                            <option value="{{ $key }}"{{ old('category_id', $product['category_id']) == $key ? ' selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>

                    @include('snippets.errors_first', ['param' => 'category_id'])
                </div>

                <div class="form-group">
                    <label for="special" class="control-label">Special:</label>

                    <input type="checkbox" id="special" name="special" value="on"{{ old('special', $product['special']) ? ' checked' : '' }} />

                    <p class="help-block">Check this to mark this product as a "special" product, which will be shown
                        in the Specials block in homepage.</p>

                    @include('snippets.errors_first', ['param' => 'special'])
                </div>

                <div class="form-group">
                    <label for="new" class="control-label">New:</label>

                    <input type="checkbox" id="new" name="new" value="on"{{ old('new', $product['new']) ? ' checked' : '' }} />

                    <p class="help-block">Check this to mark this product as a "new" product, which will have a "New"
                        ribbon on its thumbnail image.</p>

                    @include('snippets.errors_first', ['param' => 'new'])
                </div>

                <div class="form-group">
                    <label for="photos" class="control-label">Photos:</label>

                    @if ($product->photos()->count() > 0)
                        <table class="table">
                            <tr>
                                <th>Photo</th>
                                <th>Default</th>
                                <th>Remove</th>
                            </tr>
                            @foreach ($product->photos as $photo)
                                <tr>
                                    <td><img src="{{ CustomHelper::image($photo['name'], true) }}" width="100" /></td>
                                    <td><input type="radio" name="photos_default" value="{{ $photo['id'] }}" {{ $photo['default'] ? 'checked' : '' }} /></td>
                                    <td><input type="checkbox" name="photos_remove[]" value="{{ $photo['id'] }}" /></td>
                                </tr>
                            @endforeach
                        </table>
                    @endif

                    <input type="file" id="photos" name="photos[]" multiple />
                </div>

                <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
                    <label for="order" class="control-label required">Order:</label>

                    <input type="number" id="order" class="form-control" name="order" value="{{ old('order', $product['order']) }}" maxlength="10" required />

                    <p class="help-block">Set the order of this product in its category.</p>

                    @include('snippets.errors_first', ['param' => 'order'])
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success" title="Update this product"><i class="fa fa-save"></i> Save</button>

                    <a href="{{ route('admin.products.index') }}" class="btn" title="Click here to cancel">Cancel</a>
                </div>

                @if (env('SHOP_DEMO'))
                    <div class="form-group">
                        <p class="alert alert-info"><i class="fa fa-exclamation-circle"></i> Please note that photo upload is disabled in this demo.</p>
                    </div>
                @endif

            </form>
        </div>

        <div class="col-md-7">
            @include('admin.products.inventory.index', ['product' => $product, 'inventoryItems' => $product->inventoryItems])
        </div>
    </div>

@endcomponent