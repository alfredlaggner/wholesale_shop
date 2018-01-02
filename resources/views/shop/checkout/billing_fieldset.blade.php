<fieldset id="billing-fieldset"{{ $fees['total'] == 0 ? ' disabled' : '' }}>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('billing.name') ? ' has-error' : '' }}">
                <label for="billing-name" class="control-label required">Name:</label>

                <input type="text" id="billing-name" class="form-control" name="billing[name]" value="{{ old('billing[name]') }}" maxlength="255" required />

                @include('snippets.errors_first', ['param' => 'billing.name'])
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('billing.phone') ? ' has-error' : '' }}">
                <label for="billing-phone" class="control-label required">Phone:</label>

                <input type="text" id="billing-phone" class="form-control" name="billing[phone]" value="{{ old('billing[phone]') }}" maxlength="20" required />

                @include('snippets.errors_first', ['param' => 'billing.phone'])
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('billing.address_1') ? ' has-error' : '' }}">
                <label for="billing-address-1" class="control-label required">Address:</label>

                <input type="text" id="billing-address-1" class="form-control" name="billing[address_1]" value="{{ old('billing[address_1]') }}" maxlength="255" required />

                @include('snippets.errors_first', ['param' => 'billing.address_1'])
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('billing.address_2') ? ' has-error' : '' }}">
                <label for="billing-address-2" class="control-label">Address 2:</label>

                <input type="text" id="billing-address-2" class="form-control" name="billing[address_2]" value="{{ old('billing[address_2]') }}" maxlength="255" />

                @include('snippets.errors_first', ['param' => 'billing.address_2'])
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('billing.city') ? ' has-error' : '' }}">
                <label for="billing-city" class="control-label required">City:</label>

                <input type="text" id="billing-city" class="form-control" name="billing[city]" value="{{ old('billing[city]') }}" maxlength="255" required />

                @include('snippets.errors_first', ['param' => 'billing.city'])
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('billing.state') ? ' has-error' : '' }}">
                <label for="billing-state" class="control-label required">State:</label>

                <select id="billing-state" class="form-control" name="billing[state]" required>
                    <option value="">Select one</option>
                    @foreach (config('custom.states') as $key => $value)
                        <option value="{{ $key }}"{{ old('billing[state]') == $key ? ' selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>

                @include('snippets.errors_first', ['param' => 'billing.state'])
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('billing.zipcode') ? ' has-error' : '' }}">
                <label for="billing-zipcode" class="control-label required">Postal Code:</label>

                <input type="text" id="billing-zipcode" class="form-control" name="billing[zipcode]" value="{{ old('billing[zipcode]') }}" maxlength="10" required />

                @include('snippets.errors_first', ['param' => 'billing.zipcode'])
            </div>
        </div>
    </div>
</fieldset>