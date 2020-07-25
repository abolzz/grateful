@extends('layouts.app')
@section('jumbotron')
<div class="jumbotron jumbotron-fluid p-0 shop-cover-image" style="background-image: url(https://res.cloudinary.com/hzdsckd6b/image/upload/v1594144521/{{$shop->cover_image}});">
    <img class="shop-logo position-absolute" src="https://res.cloudinary.com/hzdsckd6b/image/upload/v1594483516/{{$shop->logo_image}}" alt="{{$shop->name}} logo">
    <div class="container h-100 d-flex flex-column justify-content-between" >
        <a href="/veikali" class="text-dark">
            <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-arrow-left-short" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M7.854 4.646a.5.5 0 0 1 0 .708L5.207 8l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0z"/>
              <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h6.5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
            </svg>
        </a>
        <h1 class="">{{$shop->name}}</h1>
    </div>
</div>
@endsection
@section('content')
<div class="col-md-8 col-sm-8">
    <p>{{strtok($shop->address, ',')}}</p>
    <small>{{$shop->type}}</small>
    <small>{{$shop->email}}</small>
</div>
<h2>Piedāvājumi</h2>
@if(count($listings) > 0)
<ul class="list-group">
    @foreach ($listings as $listing)
    @if($listing->quantity > 0)
    <li class="list-group-item col-12 listing mb-4 border-0 p-0">
                    <div class="card mx-auto p-0 text-dark d-flex flex-row justify-content-around align-items-center border rounded">
                        <h3 class="shopName mb-0">{{$listing->listing_name}}</h3>
                        <small>{{$listing->price}}</small>
                        @if(Carbon\Carbon::now()->lt($listing->pickup_time))
                        <small>{{ Carbon\Carbon::parse($listing->pickup_time)->format('H:i') }}</small>
                            @guest
                            @else
                                @if($shop->email != auth()->user()->email)
                                    <button onclick="buying({{$listing->id}});" class="btn btn-default">Pirkt</button>
                                @else
                                    <a href="/piedavajumi/{{$listing->id}}/edit" class="btn btn-default">Labot</a>
                                @endif
                            @endguest
                        @else
                        <small>Par vēlu, mēģiniet atkal rīt</small>
                        @endif
                        <div id="buyingModal{{$listing->id}}" class="modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    @guest
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ienāciet, lai veiktu pirkumus</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <a class="link" href="{{ route('login') }}">{{ __('Ienākt') }}</a>
                                        <span>vai</span>
                                        <a class="link" href="{{ route('register') }}">{{ __('Reģistrēties') }}</a>
                                    </div>
                                    @else
                                    <div class="modal-header">
                                        <h5 class="modal-title">Izvēlēties daudzumu</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="mb-0 pb-3">{{$listing->description}}</p>
                                        <form action="/payment" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <select class="quantitySelect" name="boughtQuantity">
                                                    <?php for ($i = 1; $i <= $listing['quantity']; $i++) : ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <input type="hidden" name="lister_name" value="{{$listing->user_id}}">
                                            <input type="hidden" name="price" value="{{$listing->price}}">
                                            <input type="hidden" name="boughtListing" value="{{$listing->listing_name}}">
                                            <input type="hidden" name="buyer" value="{{Auth::user()->email}}">
                                            <button type="submit" class="btn btn-primary">Turpināt</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        
                                        {!! Form::close() !!}
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Atcelt</button>
                                    </div>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    </div>
    </li>
    @endif
    @endforeach
</ul>
@else
<p>Šobrīd nav neviena piedāvājuma...</p>
@endif
@if(!Auth::guest())
    @if(Auth::user()->id == $shop->user_id)
    <a href="/veikali/{{$shop->id}}/edit" class="btn btn-default">Labot veikalu</a>
    {!!Form::open(['action' => ['ShopsController@destroy', $shop->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Dzēst', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
    @endif
@endif
@endsection
<script>
    function buying(id) {
        var buyingModal = '#buyingModal' + id;
        $(buyingModal).modal('show');
    }
</script>