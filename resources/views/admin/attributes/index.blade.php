@component('layouts.admin')

    @slot('title')
        Admin - Manage Product Attributes - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-12">

            <h1>Attributes</h1>

            @include('snippets.errors')
            @include('snippets.flash')

            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Display Style</th>
                    <th>Options</th>
                    <th>Edit</th>
                    <th>Remove</th>
                </tr>
                @foreach ($attributes as $attribute)
                    <tr>
                        <td><a href="{{ route('admin.attributes.show', $attribute['id']) }}">{{ $attribute['name'] }}</a></td>
                        <td>{{ $attribute['display'] == 'select' ? 'Drop-down list' : 'Radio check' }}</td>
                        <td>{{ $attribute->options()->count() }}</td>
                        <td><a href="{{ route('admin.attributes.show', $attribute['id']) }}" title="Edit this attribute" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a></td>
                        <td>
                            <form method="POST" action="{{ route('admin.attributes.destroy', $attribute['id']) }}" accept-charset="UTF-8" role="form" onsubmit="return confirm('Do you really want to remove this attribute?');">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" class="btn btn-sm btn-danger" title="Remove this attribute"><i class="fa fa-times"></i> Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>

            <a href="{{ route('admin.attributes.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add new attribute</a><br /><br />

        </div>

    </div>

@endcomponent