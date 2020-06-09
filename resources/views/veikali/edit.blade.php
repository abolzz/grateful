@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Labot veikalu</h1>
        {!! Form::open(['action' => ['ShopsController@update', $shop->id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'shop-form']) !!}
            <div class="form-group">
                {{Form::label('name', 'Nosaukums')}}
                {{Form::text('name', $shop->name, ['class' => 'form-control', 'placeholder' => 'Nosaukums'])}}
            </div>
            <div class="form-group">
                {{Form::label('phone', 'Telefona nr.')}}
                {{Form::number('phone', $shop->phone, ['class' => 'form-control', 'placeholder' => 'Telefona nr.'])}}
            </div>
            <div class="form-group">
                {{Form::label('type', 'Tips')}}
                {{Form::text('type', $shop->type, ['class' => 'form-control', 'placeholder' => 'Tips'])}}
            </div>
            <div class="form-group">
                {{Form::label('email', 'E-pasts')}}
                {{Form::text('email', $shop->email, ['class' => 'form-control', 'placeholder' => 'E-pasts'])}}
            </div>
            <div class="form-group">
                {{Form::label('address', 'Adrese')}}
                {{Form::text('address', $shop->address, ['class' => 'form-control map-input', 'id' => 'address-input', 'placeholder' => 'Adrese'])}}
                <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
            </div>
            <div id="address-map-container" style="width:100%;height:400px; ">
                <div style="width: 100%; height: 100%" id="address-map"></div>
            </div>
            <div class="form-group">
                {{Form::file('cover_image')}}
            </div>
            {{Form::hidden('_method', 'PUT')}}
            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
    <script type="application/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&language=lv" async defer></script>
    <script type="application/javascript" src="/js/mapInput.js"></script>
@stop