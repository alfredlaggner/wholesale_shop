@component('layouts.admin')

    @slot('title')
        Admin - Create new Product - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-12">

            <h2>Create new Product</h2>

            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" action="{{ route('admin.products.store') }}" accept-charset="UTF-8" enctype="multipart/form-data" role="form">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label required">Product Name:</label>

                            <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" maxlength="255" required />

                            @include('snippets.errors_first', ['param' => 'name'])
                        </div>

                        <div class="form-group{{ $errors->has('uri') ? ' has-error' : '' }}">
                            <label for="uri" class="control-label required">Product URI:</label>

                            <input type="text" id="uri" class="form-control" name="uri" value="{{ old('uri') }}" maxlength="255" required />

                            <p class="help-block">To be used in the URL, make sure to use lowercase with hyphen, i.e. "product-title".</p>

                            @include('snippets.errors_first', ['param' => 'uri'])
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="control-label">Product Description:</label>

                            <textarea id="description" class="form-control" name="description" maxlength="2048" rows="5">{{ old('description') }}</textarea>

                            @include('snippets.errors_first', ['param' => 'description'])
                        </div>

                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="control-label required">Price:</label>

                            <input type="text" id="price" class="form-control" name="price" value="{{ old('price') }}" maxlength="10" required />

                            @include('snippets.errors_first', ['param' => 'price'])
                        </div>

                        <div class="form-group{{ $errors->has('old_price') ? ' has-error' : '' }}">
                            <label for="old-price" class="control-label">Old Price:</label>

                            <input type="text" id="old-price" class="form-control" name="old_price" value="{{ old('old_price') }}" maxlength="10" />

                            @include('snippets.errors_first', ['param' => 'old_price'])
                        </div>

                        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label for="category-id" class="control-label required">Category:</label>

                            <select id="category-id" class="form-control" name="category_id" required>
                                <option value="">Select one</option>
                                @foreach(collect($categories['list'])->mapWithKeys(function ($item) {
                                        return [$item['id'] => str_repeat('- ', $item['parents']) . $item['name']];
                                    }) as $key => $value)
                                    <option value="{{ $key }}"{{ old('category_id') == $key ? ' selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>

                            @include('snippets.errors_first', ['param' => 'category_id'])
                        </div>

                        <div class="form-group">
                            <label for="special" class="control-label">Special:</label>

                            <input type="checkbox" id="special" name="special" value="on"{{ old('special') ? ' checked' : '' }} />

                            <p class="help-block">Check this to mark this product as a "special" product, which will be shown
                                in the Special block in homepage.</p>

                            @include('snippets.errors_first', ['param' => 'special'])
                        </div>

                        <div class="form-group">
                            <label for="new" class="control-label">New:</label>

                            <input type="checkbox" id="new" name="new" value="on"{{ old('new') ? ' checked' : '' }} />

                            <p class="help-block">Check this to mark this product as a "new" product, which will have a "New"
                                ribbon on its thumbnail image.</p>

                            @include('snippets.errors_first', ['param' => 'new'])
                        </div>

                        <div class="form-group">
                            <label for="photos" class="control-label">Photos:</label>

                            <input type="file" id="photos" name="photos[]" multiple />
                        </div>

                        <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
                            <label for="order" class="control-label required">Order:</label>

                            <input type="number" id="order" class="form-control" name="order" value="{{ old('order') }}" maxlength="10" required />

                            <p class="help-block">Set the order of this product in its category.</p>

                            @include('snippets.errors_first', ['param' => 'order'])
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success" title="Create this new product"><i class="fa fa-save"></i> Submit</button>

                            <a href="{{ route('admin.products.index') }}" title="Click here to cancel">Cancel</a>
                        </div>

                        @if (env('SHOP_DEMO'))
                            <div class="form-group">
                                <p class="alert alert-info"><i class="fa fa-exclamation-circle"></i> Please note that photo upload is disabled in this demo.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </form>

        </div>

    </div>

@endcomponent