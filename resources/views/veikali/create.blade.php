@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Pievienot veikalu</h1>
        {!! Form::open(['action' => 'ShopsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'shop-form']) !!}
            <div class="form-group">
                {{Form::label('name', 'Nosaukums')}}
                {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Nosaukums'])}}
            </div>
            <div class="form-group">
                {{Form::label('phone', 'Telefona nr.')}}
                {{Form::number('phone', '', ['class' => 'form-control', 'placeholder' => 'Telefona nr.'])}}
            </div>
              <div class="form-group">
                <label for="type">Tips</label>
                <select multiple class="form-control" name="type[]" id="type" size="5">
                  <option>Sushi</option>
                  <option>Pica</option>
                  <option>Kebabi</option>
                  <option>Tradicionālā virtuve</option>
                  <option>Dažādi</option>
                </select>
              </div>
            <div class="form-group">
                {{Form::label('address', 'Adrese')}}
                {{Form::text('address', '', ['class' => 'form-control map-input', 'id' => 'address-input', 'placeholder' => 'Adrese'])}}
                <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
            </div>
            <div id="address-map-container" style="width:100%;height:400px; ">
                <div style="width: 100%; height: 100%" id="address-map"></div>
            </div>
            <div class="form-group">
                {{Form::label('cover_image', 'Veikala titulbilde')}}
                {{Form::file('cover_image')}}
            </div>
            <div class="form-group">
                {{Form::label('logo_image', 'Veikala logotips')}}
                {{Form::file('logo_image')}}
            </div>
            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection

@section('scripts')
    <script type="application/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize&language=lv" async defer></script>
    <script type="application/javascript" src="/js/mapInput.js"></script>
@stop