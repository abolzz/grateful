@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Apstipriniet savu e-pasta adresi') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Nosūtījām Jums e-pastu ar turpmākajām instrukcijām.') }}
                        </div>
                    @endif

                    {{ __('Lūdzu pārbaudiet savu e-pastu') }}
                    {{ __('Ja nesaņēmāt e-pastu') }}, <a href="{{ route('verification.resend') }}">{{ __('spiediet šeit, lai pieprasītu jaunu') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
