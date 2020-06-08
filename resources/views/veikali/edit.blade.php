@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Labot veikalu</h1>
        {!! Form::open(['action' => ['ShopsController@update', $shop->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('name', 'Nosaukums')}}
                {{Form::text('name', $shop->name, ['class' => 'form-control', 'placeholder' => 'Nosaukums'])}}
            </div>
            <div class="form-group">
                {{Form::label('address', 'Adrese')}}
                {{Form::text('address', $shop->address, ['class' => 'form-control', 'placeholder' => 'Adrese'])}}
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
                {{Form::file('cover_image')}}
            </div>
            {{Form::hidden('_method', 'PUT')}}
            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection