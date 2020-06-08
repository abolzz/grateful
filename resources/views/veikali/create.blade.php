@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Pievienot veikalu</h1>
        {!! Form::open(['action' => 'ShopsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('name', 'Nosaukums')}}
                {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Nosaukums'])}}
            </div>
            <div class="form-group">
                {{Form::label('address', 'Adrese')}}
                {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Adrese'])}}
            </div>
            <div class="form-group">
                {{Form::label('phone', 'Telefona nr.')}}
                {{Form::number('phone', '', ['class' => 'form-control', 'placeholder' => 'Telefona nr.'])}}
            </div>
            <div class="form-group">
                {{Form::label('type', 'Tips')}}
                {{Form::text('type', '', ['class' => 'form-control', 'placeholder' => 'Tips'])}}
            </div>
            <div class="form-group">
                {{Form::label('email', 'E-pasts')}}
                {{Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'E-pasts'])}}
            </div>
            <div class="form-group">
                {{Form::file('cover_image')}}
            </div>
            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection