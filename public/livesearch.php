<?php  

  $search = $_GET["search"];
  $link = mysqli_connect("localhost", "root", "") OR die (mysqli_error());
  mysqli_select_db ($link, "grateful") or die(mysqli_error());

  $query = "SELECT * FROM `shops` WHERE `name` LIKE '$search%' ORDER BY `id` DESC";

  $result = mysqli_query($link, $query) or die (mysqli_error());

  if($result) 
   {    
  
      foreach ($result as $shop) {
        ?>
                <li class="shop list-group-item col-md-4 col-sm-6 col-xs-12 mb-4 border-0 p-0">
                    <a href="/veikali/<?php echo $shop['id'] ?>" class="card col-11 mx-auto p-0">
                      <img class="card-img-top" src="/storage/cover_images/<?php echo $shop['cover_image'] ?>" alt="<?php echo $shop['name'] ?> cover image">
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