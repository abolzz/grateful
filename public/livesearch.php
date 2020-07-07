<?php  

  require_once "../vendor/autoload.php";
  use Dotenv\Dotenv;

  $search = $_GET["search"];
  $link = mysqli_connect(env('DB_HOST', '127.0.0.1'), env('DB_USERNAME', 'forge'), env('DB_PASSWORD', ''), env('DB_DATABASE', '')) OR die (mysqli_error());
  mysqli_select_db ($link, env('DB_DATABASE', 'grateful')) or die(mysqli_error());

  $query = "SELECT * FROM `shops` WHERE `name` LIKE '$search%' ORDER BY `id` DESC";

  $result = mysqli_query($link, $query) or die (mysqli_error());

  if($result) 
   {    
  
      foreach ($result as $shop) {
        ?>
                <li class="shop list-group-item col-md-4 col-sm-6 col-xs-12 mb-4 border-0 p-0">
                    <a href="/veikali/<?php echo $shop['id'] ?>" class="card col-11 mx-auto p-0">
                      <div style="background-image: url(https://res.cloudinary.com/hzdsckd6b/image/upload/v1594144521/{{$shop->cover_image}});background-size: cover;height: 150px;background-position: center;"></div>
                      <div class="card-body">
                        <h5 class="card-title"><?php echo $shop['name'] ?></h5>
                        <p class="card-text"><?php echo $shop['address'] ?></p>
                        <small><?php echo $shop['type'] ?></small>
                      </div>
                    </a>
                </li>
        <?php
      }
     }
   else
     { 
       echo "No result";  
     }
 ?>