@extends('layouts.app')
        
@section('content')
    <h1>Pirkumi</h1>
	    @foreach ($purchases as $purchase)
	    @guest
	    @else
			@if($purchase->buyer_email == auth()->user()->email)
		    <div>
		    	<p>Pirkums: {{$purchase->bought_listing}}</p>
		    	<p>Cena: {{$purchase->price}}</p>
		    	<p>Pirkuma kods: {{$purchase->purchase_key}}</p>
		    	<p>Laiks: {{ Carbon\Carbon::parse($purchase->purchase_time)->format('Y-m-d') }}</p>
		    </div>
		  @endif
		  @endguest

			@endforeach
@endsection
