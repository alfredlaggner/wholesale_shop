@component('layouts.master')

	@slot('title')
		Reset Password - {{ config('app.name') }}
	@endslot

	<div class="row content">
		<div class="col-md-6 col-md-offset-3">

			<h2>Reset Password</h2>

			@include('snippets.errors')
			@include('snippets.flash')

			<form method="POST" action="{{ url('password/reset') }}" accept-charset="UTF-8" role="form">
				{{ csrf_field() }}

				<input type="hidden" name="token" value="{{ $token }}" />

				<div class="row">
					<div class="col-md-12">
						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							<label for="email" class="control-label required">Email:</label>

							<input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" maxlength="255" required />

							@include('snippets.errors_first', ['param' => 'email'])
						</div>

						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							<label for="password" class="control-label required">Password:</label>

							<input type="password" id="password" class="form-control" name="password" value="" maxlength="255" required />

							@include('snippets.errors_first', ['param' => 'password'])
						</div>

						<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
							<label for="password-confirmation" class="control-label required">Confirm Password:</label>

							<input type="password" id="password-confirmation" class="form-control" name="password_confirmation" value="" maxlength="255" required />

							@include('snippets.errors_first', ['param' => 'password_confirmation'])
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-success center-block"><i class="fa fa-save"></i> Reset Password</button>
						</div>
					</div>
				</div>

			</form>

		</div>

	</div>

@endcomponent