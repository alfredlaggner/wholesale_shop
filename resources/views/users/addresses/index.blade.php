@component('layouts.master')

    @slot('title')
        Manage Addresses - {{ config('app.name') }}
    @endslot

    <div class="row content">

        <div class="col-md-12">
            <!-- Nav tabs -->
            @include('users.tabs')

            <h1>My Addresses</h1>

            @include('snippets.errors')
            @include('snippets.flash')

            @if (auth()->user()->deliveryAddresses()->count() > 0)
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>
                            Delivery
                            <a href="{{ route('addresses.create', ['type' => 'delivery']) }}" class="pull-right"><i class="fa fa-plus"></i> Add new</a>
                        </th>
                    </tr>
                    @foreach (auth()->user()->deliveryAddresses as $deliveryAddress)
                        <tr>
                            <td>
                                <span class="pull-left">
                                    {!! CustomHelper::formatAddress($deliveryAddress) !!}
                                </span>
                                <span class="pull-right text-right">
                                    <a href="{{ route('addresses.edit', $deliveryAddress['id']) }}">Edit</a> <br />

                                    @if ($deliveryAddress['default_delivery'])
                                        <i class="fa fa-check"></i> Primary
                                    @else
                                        <a href="{{ route('addresses.primary', $deliveryAddress['id']) }}">Make Primary</a>
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-warning">
                    You have no saved delivery addresses at the present. Click <a href="{{ route('addresses.create', ['type' => 'delivery']) }}">here</a> to add a new delivery address.
                </div>
            @endif

            @if (auth()->user()->billingAddresses()->count() > 0)
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>
                            Billing
                            <a href="{{ route('addresses.create', ['type' => 'billing']) }}" class="pull-right"><i class="fa fa-plus"></i> Add new</a>
                        </th>
                    </tr>
                    @foreach (auth()->user()->billingAddresses as $billingAddress)
                        <tr>
                            <td>
                                <span class="pull-left">
                                    {!! CustomHelper::formatAddress($billingAddress) !!}
                                </span>
                                <span class="pull-right text-right">
                                    <a href="{{ route('addresses.edit', $billingAddress['id']) }}">Edit</a>
                                    <br />
                                    @if ($billingAddress['default_billing'])
                                        <i class="fa fa-check"></i> Primary
                                    @else
                                        <a href="{{ route('addresses.primary', $billingAddress['id']) }}">Make Primary</a>
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-warning">
                    You have no saved billing addresses at the present. Click <a href="{{ route('addresses.create', ['type' => 'billing']) }}">here</a> to add a new billing address.
                </div>
            @endif

        </div>

    </div>

@endcomponent