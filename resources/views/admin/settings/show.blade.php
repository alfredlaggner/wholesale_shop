@component('layouts.admin')

    @slot('title')
        Admin - Edit Setting - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-12">

            <h2>Edit Setting - {{ config('custom.settings.' . $setting['name'] . '.name') }}</h2>

            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" action="{{ route('admin.settings.update', $setting['id']) }}" class="form-horizontal" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="row">
                    <div class="col-sm-12 col-md-6">

                        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                            <div class="col-md-6">
                                <label for="state" class="control-label">Setting State:</label>

                                <input type="checkbox" id="state" name="state" {{ old('state', $setting['state']) ? ' checked' : '' }} />

                                @include('snippets.errors_first', ['param' => 'state'])

                                <p class="help-block">
                                    Boolean (on/off) setting state
                                </p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success pull-right" title="Update this setting"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>

    </div>

@endcomponent