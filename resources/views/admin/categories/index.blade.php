@component('layouts.admin')

    @slot('title')
        Admin - Manage Categories - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-12">

            <h2>Categories</h2>

            @include('snippets.errors')
            @include('snippets.flash')

            @if (count($categories['list']) > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>Name</th>
                            <th>Products</th>
                            <th>Order</th>
                            <th>Edit</th>
                            <th>Remove</th>
                        </tr>
                        @foreach ($categories['list'] as $category)
                            <tr>
                                <td>
                                    @for ($i = 0; $i < $category['parents']; $i++)
                                        <i class="fa fa-caret-right"></i>
                                    @endfor

                                    <a href="{{ route('admin.categories.show', $category['id']) }}">{{ $category['name'] }}</a>
                                </td>
                                <td>{{ $category->products()->count() }}</td>
                                <td>{{ $category['order'] }}</td>
                                <td><a href="{{ route('admin.categories.show', $category['id']) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a></td>
                                <td>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category['id']) }}" accept-charset="UTF-8" role="form" onsubmit="return confirm('Do you really want to remove this category?');">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @else
                <div class="alert alert-warning">There are no categories at the present.</div>
            @endif

            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add new Category</a><br /><br />

        </div>

    </div>

    @slot('bottomBlock')
        <script>
            function remove(url) {
                var r = confirm("Are you sure you want to remove this category?");
                if (r == true) {
                    window.location.replace(url);
                } else {
                    return false;
                }
            }
        </script>
    @endslot

@endcomponent