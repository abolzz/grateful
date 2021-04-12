@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Vadības panelis</div>

                <div class="panel-body">
                    @if(count($shops) < 1)
                        <a href="/veikali/create" class="btn btn-primary">Izveidot veikalu</a>
                    @endif
                    <h3>Jūsu veikali</h3>
                    @if(count($shops) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th>Nosaukums</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($shops as $shop)
                                <tr>
                                    <td>
                                        <a href="/veikali/{{$shop->id}}">{{$shop->name}}</a></td>
                                    <td>
                                        <a href="/veikali/{{$shop->id}}/edit" class="btn btn-default">Labot</a>
                                    </td>
                                    <td>
                                        <a href="/piedavajumi/create" class="btn btn-default">Pievienot piedāvājumu</a>
                                    </td>
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
                                <th>Pirkumi</th>
                                <th>Daudzums</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($listings as $listing)
                                <tr>
                                    <td>{{$listing->listing_name}}</td>
                                    <td>
                                        @if($listing->purchases > 0)
                                        <a href="javascript:void(0)" onclick="purchases({{$listing->id}});">
                                        @endif
                                            {{$listing->purchases}}
                                        @if($listing->purchases > 0)
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{$listing->quantity}}</td>
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
@endsection

                        <div id="purchasesModal" class="modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Pirkumi</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table>
                                            @foreach($purchases as $purchase)
                                            <tr>
                                                <th>Pirkuma kods</th>
                                                <th>Pirkuma laiks</th>
                                            </tr>
                                            <tr>
                                                <td>{{$purchase->purchase_key}}</td>
                                                <td>{{$purchase->purchase_time}}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


@section('scripts')
<script>
    function purchases(id) {
        $('#purchasesModal').modal('show');
    }
</script>
@stop
