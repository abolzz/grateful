@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>{{$title}}</h1>
        <p>
            <a class="btn btn-primary btn-lg" href="/login" role="button">Ienākt &raquo;</a>
            <a class="btn btn-success btn-lg" href="/register" role="button">Reģistrēties &raquo;</a>
        </p>
    </div>
@endsection