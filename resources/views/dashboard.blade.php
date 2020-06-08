{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Vadības panelis</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="/veikali/create" class="btn btn-primary">Izveidot veikalu</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
  
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Vadības panelis</div>

                <div class="panel-body">
                    <a href="/veikali/create" class="btn btn-primary">Izveidot veikalu</a>
                    <a href="/piedavajumi/create" class="btn btn-default">Pievienot piedāvājumu</a>
                    <h3>Jūsu veikali</h3>
                    @if(count($shops) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th>Nosaukums</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($shops as $shop)
                                <tr>
                                    <td>{{$shop->name}}</td>
                                    <td><a href="/veikali/{{$shop->id}}/edit" class="btn btn-default">Labot</a></td>
                                    <td>
                                        {!!Form::open(['action' => ['ShopsController@destroy', $shop->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Dzēst', ['class' => 'btn btn-danger'])}}
                                        {!!Form::close()!!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>Jums nav veikalu</p>
                    @endif

                    <h3>Jūsu piedāvājumi</h3>
                    @if(count($listings) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th>Nosaukums</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($listings as $listing)
                                <tr>
                                    <td>{{$listing->listing_name}}</td>
                                    <td><a href="/piedavajumi/{{$listing->id}}/edit" class="btn btn-default">Labot</a></td>
                                    <td>
                                        {!!Form::open(['action' => ['ListingsController@destroy', $listing->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Dzēst', ['class' => 'btn btn-danger'])}}
                                        {!!Form::close()!!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>Jums nav piedāvājumu</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
