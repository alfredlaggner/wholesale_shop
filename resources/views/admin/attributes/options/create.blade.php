@component('layouts.admin')

    @slot('title')
        Admin - Add new Option - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-12">

            <h2>Add new Option</h2>

            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" action="{{ route('admin.attributes.attribute.options.store', $attribute['id']) }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label required">Option:</label>

                            <input type="text" id="name" class="form-control" name="name" value="{{ old('name') }}" maxlength="45" required />

                            @include('snippets.errors_first', ['param' => 'name'])
                        </div>

                        <div class="form-group">
                            <label for="order" class="control-label required">Order:</label>

                            <input type="number" id="order" class="form-control" name="order" value="{{ old('order') }}" maxlength="10" required />

                            <p class="help-block">Set the order of this option.</p>

                            @include('snippets.errors_first', ['param' => 'order'])
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Submit</button>

                            <a href="{{ route('admin.attributes.show', $attribute['id']) }}" class="btn" title="Cancel">Cancel</a>
                        </div>
                    </div>

                </div>

            </form>

        </div>

    </div>

@endcomponent