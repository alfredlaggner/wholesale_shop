@component('layouts.master')

    @slot('title')
        Sign Up - {{ config('app.name') }}
    @endslot

    <div class="row content">

        <div class="col-md-6 col-md-offset-3">

            <h2>Sign Up</h2>

            @include('snippets.errors')

            <form method="POST" action="{{ url('register') }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('first_name') || $errors->has('last_name') ? ' has-error' : '' }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="first-name" class="control-label required">First Name:</label>

                                    <input type="text" id="first-name" class="form-control" name="first_name" value="{{ old('first_name') }}" maxlength="255" required />

                                    @include('snippets.errors_first', ['param' => 'first_name'])
                                </div>

                                <div class="col-md-6">
                                    <label for="last-name" class="control-label required">Last Name:</label>

                                    <input type="text" id="last-name" class="form-control" name="last_name" value="{{ old('last_name') }}" maxlength="255" required />

                                    @include('snippets.errors_first', ['param' => 'last_name'])
                                </div>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label required">Email:</label>

                            <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" maxlength="255" required />

                            @include('snippets.errors_first', ['param' => 'email'])
                        </div>

                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label required">Password:</label>

                            <input type="password" id="password" class="form-control" name="password" value="" maxlength="255" required />

                            @include('snippets.errors_first', ['param' => 'password'])
                        </div>

                        <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirmation" class="control-label required">Confirm Password:</label>

                            <input type="password" id="password-confirmation" class="form-control" name="password_confirmation" value="" maxlength="255" required />

                            @include('snippets.errors_first', ['param' => 'password_confirmation'])
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success center-block"><i class="fa fa-user"></i> Register</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>

    </div>

@endcomponent