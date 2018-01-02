@component('layouts.master')

    @slot('title')
        Edit your Profile - {{ config('app.name') }}
    @endslot

    <div class="row content">

        <div class="col-md-12">
            <!-- Nav tabs -->
            @include('users.tabs')

            <h1>Profile</h1>

            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" action="{{ route('account.update') }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first-name" class="control-label required">First Name:</label>

                            <input type="text" id="first-name" class="form-control" name="first_name" value="{{ old('first_name', auth()->user()['first_name']) }}" maxlength="255" required />

                            @include('snippets.errors_first', ['param' => 'first_name'])
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last-name" class="control-label required">Last Name:</label>

                            <input type="text" id="last-name" class="form-control" name="last_name" value="{{ old('last_name', auth()->user()['last_name']) }}" maxlength="255" required />

                            @include('snippets.errors_first', ['param' => 'last_name'])
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label required">Email Address:</label>

                            <input type="email" id="email" class="form-control" name="email" value="{{ old('email', auth()->user()['email']) }}" autocomplete="off" maxlength="255" required />

                            @include('snippets.errors_first', ['param' => 'email'])
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password:</label>

                            <input type="password" id="password" class="form-control" name="password" value="" autocomplete="off" maxlength="255" />

                            <p class="help-block">
                                Leave this field blank will keep the current password.
                            </p>

                            @include('snippets.errors_first', ['param' => 'password'])
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
                    </div>
                </div>

            </form>
        </div>

    </div>

@endcomponent