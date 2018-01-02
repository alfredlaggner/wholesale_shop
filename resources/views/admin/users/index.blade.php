@component('layouts.admin')

    @slot('title')
        Admin - Users - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-12">

            <h1>Users ({{ count($users) }})</h1>

            @if (count($users) > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Joined</th>
                            <th class="text-center">Edit</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td><a href="{{ route('admin.users.show', $user['id']) }}">{{ $user['first_name'] . ' ' . $user['last_name'] }}</a></td>
                                <td>{{ $user['email'] }}</td>
                                <td>{{ $user['type'] == 'admin' ? 'Admin' : 'Customer' }}</td>
                                <td><span title="{{ $user['created_at']->timezone(config('custom.timezone'))->toDayDateTimeString() }}">{{ $user['created_at']->diffForHumans() }}</span></td>
                                <td class="text-center"><a href="{{ route('admin.users.show', $user['id']) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @else
                <div class="alert alert-warning">There are no users at the present.</div>
            @endif

        </div>

    </div>

@endcomponent