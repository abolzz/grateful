<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

<form action="/charge.php" method="post" id="payment-form">
  <div class="form-row">
    <label for="card-element">
      Credit or debit card
    </label>
    <?php
      // Sanitize POST array
      $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

      $lister_name = $POST['lister_name'];
      $buyer = $POST['buyer'];
      $bought_quantity = $POST['boughtQuantity'];
      $bought_listing = $POST['boughtListing'];
      $price = $bought_quantity * $POST['price'] * 100;
    ?>
    <input type="hidden" name="lister_name" value="<?=$lister_name?>">
    <input type="hidden" name="price" value="<?=$price?>">
    <input type="hidden" name="buyer" value="<?=$buyer?>">
    <input type="hidden" name="quantity" value="<?=$bought_quantity?>">
    <input type="hidden" name="listing" value="<?=$bought_listing?>">
    <input type="text" class="" placeholder="Vārds" name="first_name">
    <input type="text" class="" placeholder="Uzvārds" name="last_name">
    <input type="email" class="" placeholder="E-pasta adrese" name="email">
    <div id="card-element">
      <!-- A Stripe Element will be inserted here. -->
    </div>

    <!-- Used to display Element errors. -->
    <div id="card-errors" role="alert"></div>
  </div>

  <button>Submit Payment</button>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="charge.js"></script>
</body>
</html>