@component('layouts.admin')

    @slot('title')
        Admin - Edit User - {{ config('app.name') }}
    @endslot

    <div class="row">

        <div class="col-md-5">

            <h2>Account</h2>

            @include('snippets.errors')
            @include('snippets.flash')

            <form method="POST" action="{{ route('admin.users.update', $user['id']) }}" accept-charset="UTF-8" enctype="multipart/form-data" role="form">
                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <label for="first-name" class="control-label required">First Name:</label>

                    <input type="text" id="first-name" class="form-control" name="first_name" value="{{ old('first_name', $user['first_name']) }}" maxlength="255" required />

                    @include('snippets.errors_first', ['param' => 'first_name'])
                </div>

                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                    <label for="last-name" class="control-label required">Last Name:</label>

                    <input type="text" id="last-name" class="form-control" name="last_name" value="{{ old('last_name', $user['last_name']) }}" maxlength="255" required />

                    @include('snippets.errors_first', ['param' => 'last_name'])
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="control-label required">Email:</label>

                    <input type="email" id="email" class="form-control" name="email" value="{{ old('email', $user['email']) }}" maxlength="255" required />

                    @include('snippets.errors_first', ['param' => 'email'])
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="control-label">Password:</label>

                    <input type="password" id="password" class="form-control" name="password" value="" maxlength="255" />

                    <p class="help-block">
                        Leave this field blank will keep the current password.
                    </p>

                    @include('snippets.errors_first', ['param' => 'password'])
                </div>

                <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                    <label for="type" class="control-label required">User Type:</label>

                    <select id="type" class="form-control" name="type" required>
                        <option value="user"{{ old('type', $user['type']) == 'user' ? ' selected' : '' }}>User</option>
                        <option value="admin"{{ old('admin', $user['type']) == 'admin' ? ' selected' : '' }}>Admin</option>
                    </select>

                    @include('snippets.errors_first', ['param' => 'type'])
                </div>

                <div class="form-group">
                    <button class="btn btn-success"><i class="fa fa-save"></i> Save</button>

                    <a href="{{ route('admin.users.index') }}" class="btn" title="Cancel">Cancel</a>
                </div>

            </form>
        </div>

        <div class="col-md-7">
            <h2>Info</h2>

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#orders" aria-controls="orders" role="tab" data-toggle="tab">Orders</a></li>
                <li role="presentation"><a href="#addresses" aria-controls="addresses" role="tab" data-toggle="tab">Addresses</a></li>
                <li role="presentation"><a href="#payments" aria-controls="payments" role="tab" data-toggle="tab">Payments</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="orders">
                    @include('admin.users.orders.index')
                </div>
                <div role="tabpanel" class="tab-pane" id="addresses">
                    @include('admin.users.addresses.index')
                </div>
                <div role="tabpanel" class="tab-pane" id="payments">
                    @include('admin.users.payments.index')
                </div>
            </div>
        </div>
    </div>

@endcomponent