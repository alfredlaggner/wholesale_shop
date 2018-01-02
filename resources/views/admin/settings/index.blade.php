@component('layouts.admin')

    @slot('title')
        Admin - Manage Settings - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-12">
            <h1>Settings</h1>

            @include('snippets.errors')
            @include('snippets.flash')

            @if (count($settings) > 0)
                <table class="table table-striped">
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Edit</th>
                    </tr>
                    @foreach ($settings as $setting)
                        <tr>
                            <td>
                                {{ config('custom.settings.' . $setting['name'] . '.name') }}
                            </td>
                            @if (empty($setting['value']))
                                <td>
                                    @if ($setting['state'])
                                        <i class="fa fa-check"></i> ON
                                    @else
                                        <i class="fa fa-times"></i> OFF
                                    @endif
                                </td>
                            @else
                                <td>
                                    {{ $setting['value'] }}
                                </td>
                            @endif
                            <td><a href="{{ route('admin.settings.show', $setting['id']) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a></td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div class="alert alert-warning">There are no settings at the present.</div>
            @endif
        </div>

    </div>

@endcomponent