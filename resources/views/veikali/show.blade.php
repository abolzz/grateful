@extends('layouts.app')

@section('content')
    <a href="/veikali" class="btn btn-default">Atpakaļ</a>
    <h1>{{$shop->name}}</h1>
    <img style="width:100%" src="/storage/cover_images/{{$shop->cover_image}}">
    <div class="col-md-8 col-sm-8">
        <p>{{strtok($shop->address, ',')}}</p>
        <small>{{$shop->type}}</small>
        <small>{{$shop->email}}</small>
    </div>
        <h2>Piedāvājumi</h2>
        @if(count($listings) > 0)
            <ul class="">
            @foreach ($listings as $listing)
                @if($listing->lister_name == $shop->email)
                <?php if ($listing['quantity'] > 0) : ?>
                <li class="shop">
                    {{-- <a href="/veikali/{{$listing->id}}"> --}}
                    
                        <div class="well">
                            <div class="row">
                                {{-- <div class="col-md-4 col-sm-4">
                                    <img style="width:100%" src="/storage/cover_images/{{$shop->cover_image}}">
                                </div> --}}
                                <div class="col-md-8 col-sm-8">
                                    <h3 class="shopName">{{$listing->listing_name}}</h3>
                                    <p>{{$listing->description}}</p>
                                    <small>{{$listing->price}}</small>
                                    <small>{{$listing->lister_name}}</small>
                                    <button onclick="buying({{$listing->id}});" class="btn btn-default">Pirkt</button>

                                    <div id="buyingModal{{$listing->id}}" class="modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title">Izvēlēties daudzumu</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="../buying.php" method="GET">
                                                {{-- {!! Form::open(['action' => 'ListingsController@buy', 'method' => 'GET']) !!} --}}
                                                    <div class="form-group">
                                                        {{-- {{Form::label('quantity', 'Skaits')}}
                                                        {{Form::select('quantity', , ['class' => 'form-control', 'placeholder' => 'Skaits'])}} --}}
                                                        <select class="quantitySelect" name="boughtQuantity">
                                                            <?php for ($i = 1; $i <= $listing['quantity']; $i++) : ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                        <input type="hidden" name="lister_name" value="{{$listing->lister_name}}">
                                                        <input type="hidden" name="boughtListing" value="{{$listing->listing_name}}">
                                                        <input type="hidden" name="buyer" value="admins@gmail.com">
                                                        {{-- {{Form::submit('Turpināt', ['class'=>'btn btn-primary'])}} --}}
                                                        <button type="submit" class="btn btn-primary">Turpināt</button>
                                                    </form>
                                            </div>
                                            <div class="modal-footer">
                                                    
                                                {!! Form::close() !!}
                                              <button type="button" class="btn btn-danger" data-dismiss="modal">Atcelt</button>
                                            </div>
                                          </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    {{-- </a> --}}
                </li>
            <?php endif; ?>
                @endif
            @endforeach
            </ul>
            @else
            <p>Šobrīd nav neviena piedāvājuma...</p>
        @endif

    @if(!Auth::guest())
        @if(Auth::user()->id == $shop->user_id)
            <a href="/veikali/{{$shop->id}}/edit" class="btn btn-default">Labot</a>

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