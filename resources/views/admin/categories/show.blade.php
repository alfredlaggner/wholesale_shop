@component('layouts.admin')

    @slot('title')
        Admin - Edit Category - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-12">

            <h2>Edit Category</h2>

            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" action="{{ route('admin.categories.update', $category['id']) }}" accept-charset="UTF-8" role="form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label required">Category Name:</label>

                            <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $category['name']) }}" maxlength="45" required />

                            @include('snippets.errors_first', ['param' => 'name'])
                        </div>

                        <div class="form-group{{ $errors->has('uri') ? ' has-error' : '' }}">
                            <label for="uri" class="control-label required">Category URI:</label>

                            <input type="text" id="uri" class="form-control" name="uri" value="{{ old('uri', $category['uri']) }}" maxlength="45" required />

                            <p class="help-block">
                                This will appear as category name in the URL. Please use lower case only, with no spaces,
                                and separate words by hyphen.
                            </p>

                            @include('snippets.errors_first', ['param' => 'uri'])
                        </div>

                        <div class="form-group{{ $errors->has('parent_id') ? ' has-error' : '' }}">
                            <label for="parent-id" class="control-label">Parent Category:</label>

                            <select id="parent-id" class="form-control" name="parent_id" required>
                                <option value="0">No parent category (Root category)</option>
                                @foreach(collect($categories['list'])->mapWithKeys(function ($item) {
                                        return [$item['id'] => str_repeat('- ', $item['parents']) . $item['name']];
                                    }) as $key => $value)
                                    <option value="{{ $key }}"{{ old('parent_id', $category['parent_id']) == $key ? ' selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>

                            @include('snippets.errors_first', ['param' => 'parent_id'])
                        </div>

                        <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
                            <label for="order" class="control-label">Order:</label>

                            <input type="number" id="order" class="form-control" name="order" value="{{ old('order', $category['order']) }}" maxlength="3" min="0" />

                            <p class="help-block">Set the order of this category (relative to other categories in the same level).</p>

                            @include('snippets.errors_first', ['param' => 'order'])
                        </div>

                        <div class="form-group{{ $errors->has('menu') ? ' has-error' : '' }}">
                            <label for="menu" class="control-label">Menu:</label>

                            <input type="checkbox" id="menu" name="menu" value="1"{{ old('menu', $category['menu']) ? ' checked' : '' }} />

                            <p class="help-block">Display this category in the global menu.</p>

                            @include('snippets.errors_first', ['param' => 'menu'])
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success" title="Save this category"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>

                </div>

            </form>

        </div>

    </div>

@endcomponent