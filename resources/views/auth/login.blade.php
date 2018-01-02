@component('layouts.master')

    @slot('title')
        Sign In - {{ config('app.name') }}
    @endslot

    <div class="row content">

        <div class="col-md-6 col-md-offset-3">

            <h2>Sign In</h2>

            @include('snippets.errors')
            @include('snippets.flash')

            @if (env('SHOP_DEMO'))
                <p class="alert alert-info">
                    <i class="fa fa-exclamation-circle"></i> Demo credentials:<br /><br />
                    <label>Admin:</label> Email: admin@gmail.com / Password: 123456<br />
                    <label>Customer:</label> Email: customer@gmail.com / Password: 123456<br />
                </p>
            @endif

            <form method="POST" action="{{ route('login') }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label required">Email:</label>

                            <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" maxlength="255" required />

                            @include('snippets.errors_first', ['param' => 'email'])
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label required">Password:</label>

                            <input type="password" id="password" class="form-control" name="password" value="" maxlength="255" required />

                            @include('snippets.errors_first', ['param' => 'password'])
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success"><i class="fa fa-lock"></i> Login</button>

                            <label class="control-label btn text-muted">
                                <input name="remember" type="checkbox" value="1" />

                                <span style="vertical-align: top;">Remember Me</span>
                            </label>

                            <a href="{{ url('password/reset') }}" class="btn btn-link pull-right">Forgot Your Password?</a>
                        </div>

                        <hr class="separator" />

                        <div class="form-group">
                            <label class="control-label">Need an account?</label>

                            <a href="{{ url('register') }}" class="btn btn-primary">Sign Up Now &raquo;</a>
                        </div>
                    </div>
                </div>

            </form>

        </div>

    </div>

@endcomponent