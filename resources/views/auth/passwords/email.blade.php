@component('layouts.master')

	@slot('title')
		Reset Password - {{ config('app.name') }}
	@endslot

	<div class="row content">
		<div class="col-md-6 col-md-offset-3">

			<h2>Reset Password</h2>

			@include('snippets.errors')
			@include('snippets.flash')

			<form method="POST" action="{{ url('password/email') }}" accept-charset="UTF-8" role="form">
				{{ csrf_field() }}

				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="email" class="control-label required">Email:</label>

							<input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" maxlength="255" required />
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary center-block"><i class="fa fa-envelope-o"></i> Send Password Reset Link</button>
						</div>
					</div>
				</div>

			</form>

		</div>
	</div>

@endcomponent