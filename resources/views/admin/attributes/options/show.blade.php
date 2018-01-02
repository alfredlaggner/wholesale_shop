@component('layouts.admin')

    @slot('title')
        Admin - Edit Product Attribute Option - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-5">

            <h2>Edit Option</h2>

            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" action="{{ route('admin.attributes.attribute.options.update', [$attribute['id'], $option['id']]) }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label required">Option:</label>

                            <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $option['name']) }}" maxlength="45" required />

                            @include('snippets.errors_first', ['param' => 'name'])
                        </div>

                        <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
                            <label for="order" class="control-label required">Order:</label>

                            <input type="number" id="order" class="form-control" name="order" value="{{ old('order', $option['order']) }}" maxlength="10" required />

                            <p class="help-block">Set the order of this option.</p>

                            @include('snippets.errors_first', ['param' => 'order'])
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>

                            <a href="{{ route('admin.attributes.show', $attribute['id']) }}" class="btn" title="Cancel">Cancel</a>
                        </div>
                    </div>

                </div>

            </form>

        </div>

        <div class="col-md-7">

            <h2>Associated Products</h2>

            @if (count($option->products()) > 0)
                <table class="table table-striped">
                    <tr>
                        <th>Product</th>
                        <th>Associated Inventory Items</th>
                        <th>Edit</th>
                    </tr>
                    @foreach ($option->products() as $product)
                        <tr>
                            <td>
                                <a href="{{ route('admin.products.show', $product['id']) }}">{{ $product['name'] }}</a>
                            </td>
                            <td>
                                {{ $option->inventoryItems()->count() }}
                            </td>
                            <td><a href="{{ route('admin.products.show', $product['id']) }}" class="btn btn-sm btn-primary" title="Edit this product"><i class="fa fa-pencil"></i> Edit</a></td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-warning">There are currently no products using this option.</div>
            @endif
        </div>

    </div>

@endcomponent