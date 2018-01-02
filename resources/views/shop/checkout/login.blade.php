@if (!auth()->check())
    <div class="row">
        <div class="col-md-3">
            <h5 style="line-height: normal; margin-top: 0;">Login</h5>
        </div>
        <div class="col-md-9">
            <label style="font-weight: normal;">
                <input type="radio" name="login_choice" value="guest" checked />

                Checkout as Guest
            </label><br />

            <label style="font-weight: normal;">
                <input type="radio" name="login_choice" value="login" />

                Login
            </label>

            <form method="POST" id="login-box" class="material hide" action="{{ route('shop.checkout.login') }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="email" class="control-label required">Email:</label>

                    <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" maxlength="255" required />
                </div>

                <div class="form-group">
                    <label for="password" class="control-label required">Password:</label>

                    <input type="password" id="password" class="form-control" name="password" value="" maxlength="255" required />
                </div>

                <p>
                    <button class="btn btn-primary" type="submit">Login</button>
                    <a href="{{ url('password/reset') }}" class="btn btn-link">Forgot Your Password?</a><br />
                </p>

                <p>
                    Don't have an account yet? <a href="{{ url('register') }}" title="Register a new account">Register</a>
                </p>

            </form>

            <hr class="separator" /><br />
        </div>
    </div>
@endif

@section('bottom_block')
    @parent
    <script>
        $( document ).ready(function() {
            $('input[name="login_choice"]').click(function(){
                $('#login-box').toggleClass('hide', $(this).val() != 'login');
            });
        });
    </script>
@endsection