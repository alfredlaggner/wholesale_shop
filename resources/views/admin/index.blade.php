@component('layouts.admin')

    @slot('title')
        Admin Panel - {{ config('app.name') }}
    @endslot

    <div class="row">
        <div class="col-md-12">
            <h1>Dashboard</h1>
        </div>
    </div>

    <div class="row">

        <div class="col-md-4">

            <table class="table table-bordered table-striped">
                <tr class="info">
                    <th colspan="3" class="text-center">
                        <i class="fa fa-shopping-cart"></i> Orders
                        <a href="{{ route('admin.orders.index') }}" class="pull-right" title="View all orders"><small class="label label-info">View all &raquo;</small></a>
                    </th>
                </tr>
                <tr>
                    <th></th>
                    <th class="text-center">Orders</th>
                    <th class="text-center">Total</th>
                </tr>
                <tr>
                    <td>Processing</td>
                    <td class="text-right">{{ $stats['orders']['processing'] }}</td>
                    <td class="text-right">${{ number_format($stats['orders']['processing_total'], 2) }}</td>
                </tr>
                <tr>
                    <td>Last Month</td>
                    <td class="text-right">{{ $stats['orders']['last_month'] }}</td>
                    <td class="text-right">${{ number_format($stats['orders']['last_month_total'], 2) }}</td>
                </tr>
                <tr>
                    <td>Month-To-Date</td>
                    <td class="text-right">{{ $stats['orders']['month_to_date'] }}</td>
                    <td class="text-right">${{ number_format($stats['orders']['month_to_date_total'], 2) }}</td>
                </tr>
                <tr>
                    <td>Last Year</td>
                    <td class="text-right">{{ $stats['orders']['last_year'] }}</td>
                    <td class="text-right">${{ number_format($stats['orders']['last_year_total'], 2) }}</td>
                </tr>
                <tr>
                    <td>Year-To-Date</td>
                    <td class="text-right">{{ $stats['orders']['year_to_date'] }}</td>
                    <td class="text-right">${{ number_format($stats['orders']['year_to_date_total'], 2) }}</td>
                </tr>
                <tr>
                    <td>Lifetime</td>
                    <td class="text-right">{{ $stats['orders']['lifetime'] }}</td>
                    <td class="text-right">${{ number_format($stats['orders']['lifetime_total'], 2) }}</td>
                </tr>
                <tr>
                    <td>Last Order</td>
                    <td class="text-center" colspan="2">
                        @if (isset($stats['orders']) && $stats['orders']['last_order'])
                            <a href="{{ route('admin.orders.show', $stats['orders']['last_order']['id']) }}" title="View this order">#{{ $stats['orders']['last_order']['order_number'] }}</a> &middot; <small>${{ number_format($stats['orders']['last_order']['total'], 2) }} ~ {{ $stats['orders']['last_order']['created_at']->diffForHumans() }}</small>
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            </table>

        </div>

        <div class="col-md-4">

            <table class="table table-bordered table-striped">
                <tr class="info">
                    <th colspan="3" class="text-center"><i class="fa fa-home"></i> Store</th>
                </tr>
                <tr>
                    <td>Categories</td>
                    <td class="text-right">{{ $stats['store']['categories'] }}</td>
                    <td class="text-center"><a href="{{ route('admin.categories.index') }}" title="Manage categories"><small class="label label-info">Manage</small></a></td>
                </tr>
                <tr>
                    <td>Attributes</td>
                    <td class="text-right">{{ $stats['store']['attributes'] }}</td>
                    <td class="text-center"><a href="{{ route('admin.attributes.index') }}" title="Manage attributes"><small class="label label-info">Manage</small></a></td>
                </tr>
                <tr>
                    <td>Products</td>
                    <td class="text-right">{{ $stats['store']['products'] }}</td>
                    <td class="text-center"><a href="{{ route('admin.products.index') }}" title="Manage products & inventory"><small class="label label-info">Manage</small></a></td>
                </tr>
                <tr>
                    <td>Inventory</td>
                    <td class="text-right">{{ $stats['store']['inventory'] }}</td>
                    <td class="text-center"><a href="{{ route('admin.products.index') }}" title="Manage products & inventory"><small class="label label-info">Manage</small></a></td>
                </tr>
                <tr>
                    <td>Out of Stock</td>
                    <td class="text-right">
                        @if ($stats['store']['out_of_stock'] > 0)
                            <a href="{{ route('admin.products.out_of_stock') }}">{{ $stats['store']['out_of_stock'] }}</a>
                        @else
                            0
                        @endif

                        items
                    </td>
                    <td class="text-center"><a href="{{ route('admin.products.out_of_stock') }}" title="Manage out of stock items"><small class="label label-info">Manage</small></a></td>
                </tr>
                <tr>
                    <td>Coupons</td>
                    <td class="text-right">{{ $stats['store']['coupons'] }}</td>
                    <td class="text-center"><a href="{{ route('admin.coupons.index') }}" title="Manage coupons"><small class="label label-info">Manage</small></a></td>
                </tr>
            </table>

        </div>

        <div class="col-md-4">

            <table class="table table-bordered table-striped">
                <tr class="info">
                    <th colspan="2" class="text-center">
                        <i class="fa fa-users"></i> Users
                        <a href="{{ route('admin.users.index') }}" class="pull-right" title="View all users"><small class="label label-info">View all &raquo;</small></a>
                    </th>
                </tr>
                <tr>
                    <td>Admins</td>
                    <td class="text-right">{{ $stats['users']['admins'] }}</td>
                </tr>
                <tr>
                    <td>Customers</td>
                    <td class="text-right">{{ $stats['users']['customers'] }}</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td class="text-right">{{ $stats['users']['total'] }}</td>
                </tr>
                <tr>
                    <td>Last User</td>
                    <td class="text-center">
                        <a href="{{ route('admin.users.show', $stats['users']['last_user']['id']) }}">{{ $stats['users']['last_user']['first_name'] . ' ' . $stats['users']['last_user']['last_name'] }}</a> &middot; <small>{{ $stats['users']['last_user']['created_at']->diffForHumans() }}</small>
                    </td>
                </tr>
            </table>

        </div>

    </div>

@endcomponent