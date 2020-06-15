@extends('layouts.app')
@section('content')
<h1>Profils</h1>
<div class="row justify-content-center">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">Paroles maiņa</div>
			<div class="card-body">
				<form method="POST" action="{{ route('change.password') }}">
					@csrf
					<div class="form-group row">
						<label for="password" class="col-md-4 col-form-label text-md-right">Esošā parole</label>
						<div class="col-md-6">
							<input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
							@if ($errors->has('current_password')) <small class="text-danger">{{ $errors->first('current_password') }}</small> @endif
						</div>
					</div>
					<div class="form-group row">
						<label for="password" class="col-md-4 col-form-label text-md-right">Jaunā parole</label>
						<div class="col-md-6">
							<input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
							@if ($errors->has('new_password')) <small class="text-danger">{{ $errors->first('new_password') }}</small> @endif
						</div>
					</div>
					<div class="form-group row">
						<label for="password" class="col-md-4 col-form-label text-md-right">Apstipriniet jauno paroli</label>
						<div class="col-md-6">
							<input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
							@if ($errors->has('confirm_new_password')) <small class="text-danger">{{ $errors->first('confirm_new_password') }}</small> @endif
						</div>
					</div>
					<div class="form-group row mb-0">
						<div class="col-md-8 offset-md-4">
							<button type="submit" class="btn btn-primary">
							Mainīt paroli
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection