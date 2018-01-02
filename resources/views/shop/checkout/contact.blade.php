@if (!auth()->check())
    <div class="row">
        <div class="col-md-3">
            <h5 style="line-height: normal; margin-top: 0;">Contact</h5>
        </div>
        <div class="col-md-9">
            <div class="form-group {{ $errors->has('contact_email') ? ' has-error' : '' }}">
                <label for="contact-email" class="control-label required">Contact Email:</label>

                <input type="email" id="contact-email" class="form-control" name="contact_email" value="{{ old('contact_email') }}" maxlength="255" required />

                @include('snippets.errors_first', ['param' => 'contact_email'])
            </div>

            <hr class="separator" /><br />
        </div>
    </div>
@endif