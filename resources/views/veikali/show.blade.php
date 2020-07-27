@extends('layouts.app')
@section('jumbotron')
<div class="jumbotron jumbotron-fluid p-0 shop-cover-image" style="background-image: url(https://res.cloudinary.com/hzdsckd6b/image/upload/v1594144521/{{$shop->cover_image}});">
    <img class="shop-logo position-absolute" src="https://res.cloudinary.com/hzdsckd6b/image/upload/v1594483516/{{$shop->logo_image}}" alt="{{$shop->name}} logo">
    <div class="container h-100 d-flex flex-column justify-content-between" >
        <a href="/veikali" class="text-white">
            <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-arrow-left-short" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M7.854 4.646a.5.5 0 0 1 0 .708L5.207 8l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0z"/>
              <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h6.5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
            </svg>
        </a>
        <div class="h-75 d-flex flex-column justify-content-end py-2">
            <h1 class="text-white">{{$shop->name}}</h1>
            <div>
                <?php $myArray = explode(',', $shop->type);
                    foreach($myArray as $my_Array) {
                ?>
                    <small class="border border-dark rounded p-1 bg-dark text-white"><?php echo $my_Array ?></small>
                <?php
                }?>
            </div>
            <div class="d-flex align-items-center">
                <p class="text-white py-2 mb-0 mr-4">
                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-geo" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path d="M11 4a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                      <path d="M7.5 4h1v9a.5.5 0 0 1-1 0V4z"/>
                      <path fill-rule="evenodd" d="M6.489 12.095a.5.5 0 0 1-.383.594c-.565.123-1.003.292-1.286.472-.302.192-.32.321-.32.339 0 .013.005.085.146.21.14.124.372.26.701.382.655.246 1.593.408 2.653.408s1.998-.162 2.653-.408c.329-.123.56-.258.701-.382.14-.125.146-.197.146-.21 0-.018-.018-.147-.32-.339-.283-.18-.721-.35-1.286-.472a.5.5 0 1 1 .212-.977c.63.137 1.193.34 1.61.606.4.253.784.645.784 1.182 0 .402-.219.724-.483.958-.264.235-.618.423-1.013.57-.793.298-1.855.472-3.004.472s-2.21-.174-3.004-.471c-.395-.148-.749-.336-1.013-.571-.264-.234-.483-.556-.483-.958 0-.537.384-.929.783-1.182.418-.266.98-.47 1.611-.606a.5.5 0 0 1 .595.383z"/>
                    </svg>
                    <a class="text-white" href="/karte">{{strtok($shop->address, ',')}}</a>
                </p>
                <p class="text-white mb-0">
                    <svg class="mr-1" width="1.25em" height="1.25em" viewBox="0 0 16 16" class="bi bi-envelope" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z"/>
                    </svg>
                    <a class="text-white" href="mailto:{{$shop->email}}">{{$shop->email}}</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<h2>Piedāvājumi</h2>
@if(count($listings) > 0)
<ul class="list-group">
    @foreach ($listings as $listing)
    @if($listing->quantity > 0 and Carbon\Carbon::now()->lt($listing->pickup_time))
    <li class="list-group-item col-12 listing mb-4 border-0 p-0">
                    <div class="card mx-auto p-0 text-dark d-flex flex-row justify-content-around align-items-center border rounded">
                        <h3 class="shopName mb-0 w-25">{{$listing->listing_name}}</h3>
                        <div class="w-25 d-flex justify-content-between">
                            <small>{{$listing->price}}</small>
                            <small>
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-clock" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm8-7A8 8 0 1 1 0 8a8 8 0 0 1 16 0z"/>
                                  <path fill-rule="evenodd" d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                                {{ Carbon\Carbon::parse($listing->pickup_time)->format('H:i') }}
                            </small>
                        </div>
                            @guest
                            @else
                                @if($shop->email != auth()->user()->email)
                                    <button onclick="buying({{$listing->id}});" class="btn btn-default w-25">Pirkt</button>
                                @else
                                    <a href="/piedavajumi/{{$listing->id}}/edit" class="btn btn-default w-25">Labot</a>
                                @endif
                            @endguest
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
    <a href="/veikali/{{$shop->id}}/edit" class="btn btn-primary mb-1">Labot veikalu</a>
    {!!Form::open(['action' => ['ShopsController@destroy', $shop->id], 'method' => 'POST', 'class' => 'pull-right mb-2'])!!}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Dzēst', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
    @endif
@endif
@endsection

@section('scripts')
    <script>
        function buying(id) {
            var buyingModal = '#buyingModal' + id;
            $(buyingModal).modal('show');
        }
    </script>
@stop