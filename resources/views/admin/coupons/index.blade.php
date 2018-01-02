@component('layouts.admin')

    @slot('title')
        Admin - Manage Coupons - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-12">

            <h1>Coupons</h1>

            @include('snippets.errors')
            @include('snippets.flash')

            @if (count($coupons) > 0)
                <table class="table table-striped">
                    <tr>
                        <th>Code</th>
                        <th>Discount</th>
                        <th>Free Shipping</th>
                        <th>Applicable Products</th>
                        <th>Usage</th>
                        <th>Valid</th>
                        <th>Active</th>
                        <th>Edit</th>
                        <th>Remove</th>
                    </tr>
                    @foreach ($coupons as $coupon)
                        <tr>
                            <td>
                                <strong class="label label-primary">{{ $coupon['code'] }}</strong>
                            </td>
                            <td>
                                {{ $coupon['type'] == 'percentage' ? ($coupon['discount_percentage'] . '%') : ('$' . number_format($coupon['discount_amount'], 2)) }}
                            </td>
                            <td>
                                {{ $coupon['shipping'] ? 'Yes' : 'No' }}
                            </td>
                            <td>
                                {{ $coupon->products()->count() > 0 ? $coupon->products()->count() . ' products' : 'All products' }}
                            </td>
                            <td>
                                {{ $coupon['usage'] }} times

                                @if ($coupon['limited'])
                                    / {{ $coupon['limit'] }} times
                                @endif
                            </td>
                            <td>
                                @if (empty($coupon['start']) && empty($coupon['end']))
                                    N/A
                                @elseif (!empty($coupon['start']) && empty($coupon['end']))
                                    From {{ $coupon['start']->timezone(config('custom.timezone'))->format('m/d/Y g:i A') }}
                                @elseif (empty($coupon['start']) && !empty($coupon['end']))
                                    {{ $coupon['end']->isPast() ? 'Expired' : 'Expires' }} on {{ $coupon['end']->timezone(config('custom.timezone'))->format('m/d/Y g:i A') }}
                                @elseif ($coupon['end']->isPast())
                                    Expired
                                @else
                                    From {{ $coupon['start']->timezone(config('custom.timezone'))->format('m/d/Y g:i A') }}
                                    to {{ $coupon['end']->timezone(config('custom.timezone'))->format('m/d/Y g:i A') }}
                                @endif
                            </td>
                            <td>
                                @if ($coupon['active'])
                                    <i class="fa fa-check"></i> Active
                                @else
                                    <i class="fa fa-times"></i> Inactive
                                @endif
                            </td>
                            <td><a href="{{ route('admin.coupons.show', $coupon['id']) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a></td>
                            <td>
                                <form method="POST" action="{{ route('admin.coupons.destroy', $coupon['id']) }}" accept-charset="UTF-8" role="form" onsubmit="return confirm('Do you really want to remove this coupon?');">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-warning">There are no coupons at the present.</div>
            @endif

            <a href="{{ route('admin.coupons.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add new Coupon</a><br /><br />

        </div>

    </div>

@endcomponent