<h2>Options</h2>

<table class="table table-striped">
    <tr>
        <th>Order</th>
        <th>Option</th>
        <th>Edit</th>
        <th>Remove</th>
    </tr>
    @foreach ($attribute->options()->orderBy('order')->get() as $option)
        <tr>
            <td>{{ $option['order'] }}</td>
            <td>{!! $option['name'] !!}</td>
            <td><a href="{{ route('admin.attributes.attribute.options.show', [$attribute['id'], $option['id']]) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a></td>
            <td>
                <form method="POST" action="{{ route('admin.attributes.attribute.options.destroy', [$attribute['id'], $option['id']]) }}" accept-charset="UTF-8" role="form" onsubmit="return confirm('Do you really want to remove this option?');">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Remove</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

<a href="{{ route('admin.attributes.attribute.options.create', $attribute['id']) }}" class="btn btn-sm btn-success" title="Add a new option to this attribute"><i class="fa fa-plus"></i> Add new Option</a><br /><br />