@extends('layouts.app')

@section('content')
<a href="/dashboard" class="text-dark">
            <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-arrow-left-short" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M7.854 4.646a.5.5 0 0 1 0 .708L5.207 8l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0z"/>
              <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h6.5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
            </svg>
</a>
    <div class="container">
        {!! Form::open(['action' => 'ListingsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'class' => 'col-md-8 col-sm-12 mx-auto mb-2']) !!}
            <h1>Pievienot piedāvājumu</h1>
            <div class="form-group">
                {{Form::label('listing_name', 'Nosaukums')}}
                {{Form::text('listing_name', '', ['class' => 'form-control', 'placeholder' => 'Nosaukums'])}}
            </div>
            <div class="form-group">
                {{Form::label('description', 'Apraksts')}}
                {{Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'Īss info par piedāvājumu'])}}
            </div>
            <div class="col-12 p-0 d-md-flex justify-content-between">
                <div class="col-md-3 col-sm-12 p-0 form-group">
                    {{Form::label('price', 'Cena (EUR)')}}
                    {{Form::number('price', '', ['class' => 'form-control', 'placeholder' => 'Cena'])}}
                </div>
                <div class="col-md-3 col-sm-12 p-0 form-group">
                    {{Form::label('quantity', 'Skaits (1-10)')}}
                    {{Form::number('quantity', '', ['class' => 'form-control', 'placeholder' => 'Skaits'])}}
                </div>
                <div class="col-md-3 col-sm-12 p-0 form-group">
                    {{Form::label('pickup_time', 'Spēkā līdz')}}
                    <input class="form-control" placeholder="Spēkā līdz" type="time" name="pickup_time" min="<?php echo \Carbon\Carbon::now()->addMinutes(30)->timezone('Europe/Riga')->format('H:i'); ?>" required oninvalid="this.setCustomValidity('Saņemšanas laikam jābūt vismaz 30min no šī brīža.')">
                </div>
            </div>
                <input type="hidden" name="lister_name" value="{{ Auth::user()->email }}">
            {{Form::submit('Pievienot', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection