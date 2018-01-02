<ul class="nav nav-tabs" role="tablist">
    <li role="presentation"{!! strpos(Route::currentRouteName(), 'account') === 0 ? ' class="active"' : '' !!}><a href="{{ route('account') }}" role="tab">Profile</a></li>
    <li role="presentation"{!! strpos(Route::currentRouteName(), 'orders') === 0 || Route::currentRouteName() == 'user_order' ? ' class="active"' : '' !!}><a href="{{ route('orders') }}" role="tab">My Orders</a></li>
    <li role="presentation"{!! strpos(Route::currentRouteName(), 'addresses') === 0 ? ' class="active"' : '' !!}><a href="{{ route('addresses') }}" role="tab">Addresses</a></li>
    <li role="presentation"{!! strpos(Route::currentRouteName(), 'payments') === 0 ? ' class="active"' : '' !!}><a href="{{ route('payments') }}" role="tab">Payments</a></li>
</ul>