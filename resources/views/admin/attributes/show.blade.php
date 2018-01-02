@component('layouts.admin')

    @slot('title')
        Admin - Edit Attribute - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-5">

            <h2>Details</h2>

            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" action="{{ route('admin.attributes.update', $attribute['id']) }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label required">Attribute:</label>

                            <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $attribute['name']) }}" maxlength="45" required />

                            @include('snippets.errors_first', ['param' => 'name'])
                        </div>

                        <div class="form-group{{ $errors->has('display') ? ' has-error' : '' }}">
                            <label for="display" class="control-label required">Display Style:</label>

                            <select id="display" class="form-control" name="display" required>
                                <option value="radio"{{ old('display', $attribute['display']) == 'radio' ? ' selected' : '' }}>Radio check</option>
                                <option value="select"{{ old('display', $attribute['display']) == 'select' ? ' selected' : '' }}>Drop-down list</option>
                            </select>

                            @include('snippets.errors_first', ['param' => 'display'])
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>

                            <a href="{{ route('admin.attributes.index') }}" class="btn" title="Cancel">Cancel</a>
                        </div>
                    </div>

                </div>

            </form>

        </div>

        <div class="col-md-7">
            @include('admin.attributes.options.index')
        </div>

    </div>

@endcomponent