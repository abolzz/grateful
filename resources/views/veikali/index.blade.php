@extends('layouts.app')

@section('content')

    @if(count($shops) > 0)
        <div class="row">
            <div class="col-md-8 col-sm-12 mx-auto p-3 d-md-flex">
              <input id="search" class="form-control align-self-center col-md-9 col-12 mb-2" type="search" name="search" placeholder="Meklēt">
              <select id="selectType" class="form-control col-md-2 col-12 mx-auto">
                <option>Visi</option>
                <option>Pica</option>
                <option>Kebabi</option>
                <option>Sushi</option>
              </select>
            </div> 
        </div>
        <ul id="total_records" class="list-group shops-list flex-row flex-wrap">
            @foreach ($shops as $shop)
                <li class="shop list-group-item col-md-4 col-sm-6 col-xs-12 mb-4 border-0 p-0 bg-transparent" data-mh="info">
                    <a href="/veikali/{{$shop->id}}" class="card col-11 mx-auto p-0 text-dark btn">
                      <div class="shop-cover-image d-flex justify-content-center align-items-center lazy" data-bg="https://res.cloudinary.com/hzdsckd6b/image/upload/v1594144521/{{$shop->cover_image}}"><img src="https://res.cloudinary.com/hzdsckd6b/image/upload/v1594150512/image-placeholder_rrc5fk.jpg" data-src="https://res.cloudinary.com/hzdsckd6b/image/upload/v1594483516/{{$shop->logo_image}}" class="shop-logo position-absolute lazy" alt="{{$shop->name}} logo"></div>
                      <div class="card-body text-left py-3">
                        <h5 class="card-title mb-2">{{$shop->name}}</h5>
                        <p class="card-text mb-1">{{substr($shop->address, 0, strpos($shop->address, ','))}}</p>
                        <?php $shopTypes = explode(',', $shop->type); ?>
                        @foreach($shopTypes as $shop_type)
                          <small class="border-dark rounded p-1 bg-dark text-white">{{$shop_type}}</small>
                        @endforeach
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

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){

          $(".loader-bg").fadeOut("slow");

          $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#total_records li").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });

          $("#selectType").on("change", function() {
            var value = $(this).val().toLowerCase();
              $("#total_records li").filter(function() {
                if (value !== "visi") {
                  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                } else {
                  $(this).show();
                }
              });
          });

          var lazyLoadInstance = new LazyLoad();

          $(function() {
            $('.card').matchHeight(
                {
                    byRow: true,
                    property: 'height',
                    target: null,
                    remove: false
                }
            );
          });
        });
    </script>
@stop