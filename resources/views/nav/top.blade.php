<ul class="top-nav">
    @if (auth()->check())
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user"></i>&nbsp; {{ auth()->user()->first_name }} <b class="caret"></b>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li><a href="{{ route('account') }}">Account Settings</a></li>
                <li><a href="{{ route('orders') }}">My Orders</a></li>
                <li class="divider"></li>
                @if (auth()->user()->type == 'admin')
                    <li><a href="{{ route('admin.home') }}" title="Admin Panel"><i class="fa fa-desktop"></i> Admin</a></li>
                @endif
                <li>
                    <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-power-off"></i> Log out
                    </a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </li>
    @else
        <li><a href="{{ route('login') }}">Login</a></li>
        <li><a href="{{ url('register') }}">Register</a></li>
    @endif
</ul>