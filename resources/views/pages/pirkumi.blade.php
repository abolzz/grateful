@extends('layouts.app')
        
@section('content')
    <h1>Pirkumi</h1>
    @guest
	    <p>Ienāciet, lai veiktu pirkumus</p>
	    @else
	    @foreach ($purchases as $purchase)
			@if($purchase->buyer == auth()->user()->email)
		    <div>
		    	<p>Pirkums: {{$purchase->bought_listing}}</p>
		    	<p>Cena: {{$purchase->price}}</p>
		    	<p>Pirkuma kods: {{$purchase->purchase_key}}</p>
		    	<p>Laiks: {{ Carbon\Carbon::parse($purchase->purchase_time)->format('Y-m-d') }}</p>
		    </div>
		    @endif

		@endforeach
	@endguest
@endsection
