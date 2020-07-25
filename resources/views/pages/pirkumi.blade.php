@extends('layouts.app')
        
@section('content')
<div class="row">
    <h1>Pirkumi</h1>
    	<table class="col-12">
	    @foreach ($purchases as $purchase)
	    @guest
	    @else
			@if($purchase->buyer_email == auth()->user()->email)
		    
		    	<tr>
		    		<th>Pirkums:</th>
		    		<th>Pirkuma summa:</th>
		    		<th>Pirkuma kods:</th>
		    		<th>Laiks:</th>
		    	</tr>
		    	<tr>
		    		<td>{{$purchase->bought_listing}}</td>
		    		<td>{{$purchase->price}}</td>
		    		<td>{{$purchase->purchase_key}}</td>
		    		<td>{{ Carbon\Carbon::parse($purchase->purchase_time)->format('Y-m-d') }}</td>
		    	</tr>
		  @endif
		  @endguest

			@endforeach
	</table>
</div>
@endsection
