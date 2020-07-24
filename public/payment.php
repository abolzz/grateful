<!DOCTYPE html>
<html>
<head>
  <title></title>
  <link rel="stylesheet" type="text/css" href="css/app.css">
</head>
<body>

<form action="/charge.php" method="post" id="payment-form" class="container my-3">
  <div class="row">
    <?php
      // Sanitize POST array
      $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

      $lister_name = $POST['lister_name'];
      $buyer = $POST['buyer'];
      $bought_quantity = $POST['boughtQuantity'];
      $bought_listing = $POST['boughtListing'];
      $price = $bought_quantity * $POST['price'] * 100;
    ?>
    <div class="col-md-6 mx-auto">
      <p><?=$bought_listing?></p>
      <p>Pirkuma summa: <?=$POST['price']?>EUR</p>

      <input type="hidden" name="lister_name" value="<?=$lister_name?>">
      <input type="hidden" name="price" value="<?=$price?>">
      <input type="hidden" name="buyer" value="<?=$buyer?>">
      <input type="hidden" name="quantity" value="<?=$bought_quantity?>">
      <input type="hidden" name="listing" value="<?=$bought_listing?>">
      <input type="text" class="mb-2 form-control" placeholder="Vārds" name="first_name">
      <input type="text" class="mb-2 form-control" placeholder="Uzvārds" name="last_name">
      <input type="email" class="mb-2 form-control" placeholder="E-pasta adrese" name="email">
      <div class="mb-2 form-control" id="card-element-nr">
      </div>
      <div class="mb-2 col-6 form-control d-inline-block float-left" id="card-element-cvc">
      </div>
      <div class="mb-2 col-6 form-control d-inline-block float-left" id="card-element-expiry">
      </div>

      <!-- Used to display Element errors. -->
      <div id="card-errors" role="alert"></div>
      <button class="btn btn-primary">Iesniegt maksājumu</button>
    </div>
  </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="charge.js"></script>
</body>
</html>