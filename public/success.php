<?php
  if(!empty($_GET['tid'] && !empty($_GET['product']))) {
    $GET = filter_var_array($_GET, FILTER_SANITIZE_STRING);

    $tid = $GET['tid'];
    $product = $GET['product'];
  } else {
    header('Location: index.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<h1>Paldies par pirkumu!</h1>
	<p></p>

</body>
</html>