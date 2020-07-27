@extends('layouts.app')

@section('content')
        <div class="row my-3">
            <div class="col-md-8 col-sm-12 mx-auto">
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
                        <label for="type">Tips</label>
                        <select multiple class="form-control" name="type[]" id="type" size="5">
                          <option @if(str_contains($shop->type, 'Sushi') !== false) selected="selected" @endif>Sushi</option>
                          <option @if(str_contains($shop->type, 'Pica') !== false) selected="selected" @endif>Pica</option>
                          <option @if(str_contains($shop->type, 'Kebabi') !== false) selected="selected" @endif>Kebabi</option>
                          <option @if(str_contains($shop->type, 'Tradicionālā virtuve') !== false) selected="selected" @endif>Tradicionālā virtuve</option>
                          <option @if(str_contains($shop->type, 'Dažādi') !== false) selected="selected" @endif>Dažādi</option>
                        </select>
                      </div>
                    <div class="form-group">
                        {{Form::label('address', 'Adrese')}}
                        {{Form::text('address', $shop->address, ['class' => 'form-control map-input', 'id' => 'address-input', 'placeholder' => 'Adrese'])}}
                        <input type="hidden" name="address_latitude" id="address-latitude" value="0" />
                        <input type="hidden" name="address_longitude" id="address-longitude" value="0" />
                    </div>
                    <div class="form-group">
                        {{Form::label('cover_image', 'Veikala titulbilde', ['class' => 'mt-3'])}}<br>
                        <img class="col-12" src="https://res.cloudinary.com/hzdsckd6b/image/upload/v1594144521/{{$shop->cover_image}}">
                        <br><br>
                        {{Form::file('cover_image')}}
                    </div>
                    <div class="form-group pt-3">
                        {{Form::label('logo_image', 'Veikala logotips')}}<br>
                        <img class="col-12" src="https://res.cloudinary.com/hzdsckd6b/image/upload/v1594483516/{{$shop->logo_image}}">
                        <br><br>
                        {{Form::file('logo_image')}}
                    </div>
                    {{Form::hidden('_method', 'PUT')}}
                    {{Form::submit('Labot', ['class'=>'btn btn-primary'])}}
                {!! Form::close() !!}
            </div>
        </div>
@endsection

@section('scripts')
    <script type="application/javascript" src="/js/jQuery.min.js"></script>
    <script type="application/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&language=lv"></script>
    <script type="application/javascript" src="/js/mapInput.js"></script>
    <script type="text/javascript">
        initialize();
    </script>
@stop