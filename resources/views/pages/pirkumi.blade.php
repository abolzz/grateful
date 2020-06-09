@extends('layouts.app')
        
@section('content')
    <h1>Pirkumi</h1>
    @foreach ($purchases as $purchase)
		@if($purchase->buyer == auth()->user()->email)
	    <div>{{$purchase->bought_listing}}</div>
	    @endif

	@endforeach
@endsection
