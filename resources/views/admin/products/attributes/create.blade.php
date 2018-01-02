@component('layouts.admin')

    @slot('title')
        Admin - Add new Product Attribute - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-12">

            <h2>Admin - Add new Product Attribute</h2>

            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" action="{{ route('admin.attributes.store') }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group{{ $errors->has('key') ? ' has-error' : '' }}">
                            <label for="key" class="control-label required">Attribute Key:</label>

                            <input type="text" id="key" class="form-control" name="key" value="{{ old('key') }}" maxlength="100" required />

                            @include('snippets.errors_first', ['param' => 'key'])
                        </div>

                        <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                            <label for="value" class="control-label required">Attribute Value:</label>

                            <input type="text" id="value" class="form-control" name="value" value="{{ old('value') }}" maxlength="100" required />

                            @include('snippets.errors_first', ['param' => 'value'])
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Submit</button>

                            <a href="{{ route('admin.attributes.index') }}" title="Click here to cancel">Cancel</a>
                        </div>
                    </div>

                </div>

            </form>

        </div>

    </div>

@endcomponent