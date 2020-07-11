@extends('layouts.app')

@section('content')

    @if(count($shops) > 0)
        <div class="row">
          <form id="search-form" class="col-8 mx-auto align-self-center d-flex" style="height: 100px">  
            <input class="form-control align-self-center" type="search" name="search" onkeydown="noEnter();" onkeyup="noEnter();showHint(this.value)" onsearch="noEnter();showHint(this.value)" placeholder="Meklēt"><br>  
          </form>
        </div>
        <ul id="total_records" class="list-group shops-list flex-row flex-wrap">
            @foreach ($shops as $shop)
                <li class="shop list-group-item col-md-4 col-sm-6 col-xs-12 mb-4 border-0 p-0 bg-transparent" data-mh="info">
                    <a href="/veikali/{{$shop->id}}" class="card col-11 mx-auto p-0 text-dark btn">
                      <div class="shop-cover-image d-flex justify-content-center align-items-center" style="background-image: url(https://res.cloudinary.com/hzdsckd6b/image/upload/v1594144521/{{$shop->cover_image}});"><img src="https://res.cloudinary.com/hzdsckd6b/image/upload/v1594483516/{{$shop->logo_image}}" class="shop-logo" alt="{{$shop->name}} logo"></div>
                      <div class="card-body text-left py-3">
                        <h5 class="card-title mb-2">{{$shop->name}}</h5>
                        <p class="card-text mb-1">{{substr($shop->address, 0, strpos($shop->address, ','))}}</p>
                        <?php $myArray = explode(',', $shop->type);
                        foreach($myArray as $my_Array){
                         ?><small class="border border-dark rounded p-1 bg-dark text-white"><?php echo $my_Array ?></small>
                        <?php
                        }?>
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

<script>

        var enter = false;

        function noEnter() {
            document.getElementById("search-form").addEventListener('keypress', function(e) {
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