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
        <li class="shop">
        <a href="/veikali/<?php echo $shop['id'] ?>">
        
            <div class="well">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <img style="width:100%" src="/storage/cover_images/<?php echo $shop['cover_image'] ?>">
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <h3 class="shopName"><?php echo $shop['name'] ?></h3>
                        <p><?php echo $shop['address'] ?></p>
                        <small><?php echo $shop['type'] ?></small>
                    </div>
                </div>
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