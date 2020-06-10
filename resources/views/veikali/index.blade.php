@extends('layouts.app')

@section('content')

    @if(count($shops) > 0)
        <form id="search-form" class="col-md-4">  
            <input class="form-control" type="search" name="search" onkeydown="noEnter();" onkeyup="noEnter();showHint(this.value)" onsearch="noEnter();showHint(this.value)" placeholder="Meklēt"><br>  
          </form>
        <ul id="total_records">
            @foreach ($shops as $shop)
                <li class="shop">
                    <a href="/veikali/{{$shop->id}}">
                    
                        <div class="well">
                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <img style="width:100%" src="/storage/cover_images/{{$shop->cover_image}}">
                                </div>
                                <div class="col-md-8 col-sm-8">
                                    <h3 class="shopName">{{$shop->name}}</h3>
                                    <p>{{strtok($shop->address, ',')}}</p>
                                    <small>{{$shop->type}}</small>
                                </div>
                            </div>
                        </div>

                    </a>
                </li>
            @endforeach
            {{$shops->links()}}
        </ul>
    @else
        <p>Veikali nav atrasti...</p>
    @endif
@endsection

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

<script>

        var enter = false;

        function noEnter() {
            $("#search-form").bind("keypress", function(e) {
                if (e.keyCode == 13) {
                    enter = true;
                    return false;
                } else {
                    enter = false;
                }
            });
        };
        function showHint(str) {
            if (enter != true) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200 && this.responseText != "") {
                        document.getElementById("total_records").innerHTML = this.responseText;
                    } else if (this.readyState == 4 && this.status == 200 && this.responseText == "") {
                            document.getElementById("total_records").innerHTML = "Nekas netika atrasts...";
                    }
                };
                xmlhttp.open("GET", "livesearch.php?search=" + str, true);
                xmlhttp.send();
            }
        }
</script>