<fieldset id="delivery-fieldset">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('delivery.name') ? ' has-error' : '' }}">
                <label for="delivery-name" class="control-label required">Name:</label>

                <input type="text" id="delivery-name" class="form-control" name="delivery[name]" value="{{ old('delivery[name]') }}" maxlength="255" required />

                @include('snippets.errors_first', ['param' => 'delivery.name'])
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('delivery.phone') ? ' has-error' : '' }}">
                <label for="delivery-phone" class="control-label required">Phone:</label>

                <input type="text" id="delivery-phone" class="form-control" name="delivery[phone]" value="{{ old('delivery[phone]') }}" maxlength="20" required />

                @include('snippets.errors_first', ['param' => 'delivery.phone'])
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('delivery.address_1') ? ' has-error' : '' }}">
                <label for="delivery-address-1" class="control-label required">Address:</label>

                <input type="text" id="delivery-address-1" class="form-control" name="delivery[address_1]" value="{{ old('delivery[address_1]') }}" maxlength="255" required />

                @include('snippets.errors_first', ['param' => 'delivery.address_1'])
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('delivery.address_2') ? ' has-error' : '' }}">
                <label for="delivery-address-2" class="control-label">Address 2:</label>

                <input type="text" id="delivery-address-2" class="form-control" name="delivery[address_2]" value="{{ old('delivery[address_2]') }}" maxlength="255" />

                @include('snippets.errors_first', ['param' => 'delivery.address_2'])
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('delivery.city') ? ' has-error' : '' }}">
                <label for="delivery-city" class="control-label required">City:</label>

                <input type="text" id="delivery-city" class="form-control" name="delivery[city]" value="{{ old('delivery[city]') }}" maxlength="255" required />

                @include('snippets.errors_first', ['param' => 'delivery.city'])
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('delivery.state') ? ' has-error' : '' }}">
                <label for="delivery-state" class="control-label required">State:</label>

                <select id="delivery-state" class="form-control" name="delivery[state]" required>
                    <option value="">Select one</option>
                    @foreach (config('custom.states') as $key => $value)
                        <option value="{{ $key }}"{{ old('delivery[state]') == $key ? ' selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>

                @include('snippets.errors_first', ['param' => 'delivery.state'])
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('delivery.zipcode') ? ' has-error' : '' }}">
                <label for="delivery-zipcode" class="control-label required">Postal Code:</label>

                <input type="text" id="delivery-zipcode" class="form-control" name="delivery[zipcode]" value="{{ old('delivery[zipcode]') }}" maxlength="10" required />

                @include('snippets.errors_first', ['param' => 'delivery.zipcode'])
            </div>
        </div>
    </div>
</fieldset>