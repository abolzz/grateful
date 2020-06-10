@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Labot piedāvājumu</h1>
        {!! Form::open(['action' => ['ListingsController@update', $listing->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('listing_name', 'Nosaukums')}}
                {{Form::text('listing_name', $listing->listing_name, ['class' => 'form-control', 'placeholder' => 'Nosaukums'])}}
            </div>
            <div class="form-group">
                {{Form::label('description', 'Apraksts')}}
                {{Form::textarea('description', $listing->description, ['class' => 'form-control', 'placeholder' => 'Apraksts'])}}
            </div>
            <div class="form-group">
                {{Form::label('price', 'Cena')}}
                {{Form::number('price', $listing->price, ['class' => 'form-control', 'placeholder' => 'Cena'])}}
            </div>
            <div class="form-group">
                {{Form::label('quantity', 'Skaits')}}
                {{Form::number('quantity', $listing->quantity, ['class' => 'form-control', 'placeholder' => 'Skaits'])}}
            </div>
            <div class="form-group">
                {{Form::label('pickup_time', 'Spēkā līdz')}}
                {{Form::time('pickup_time', \Carbon\Carbon::now()->timezone('Europe/Riga')->format('H:i'),['class' => 'form-control', 'placeholder' => 'Spēkā līdz'])}}
            </div>
                <input type="hidden" name="lister_name" value="{{ Auth::user()->email }}">
                {{Form::hidden('_method', 'PUT')}}
                {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection