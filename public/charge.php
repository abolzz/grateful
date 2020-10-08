<?php

require_once('lib//autoload.php');
require_once('config/db.php');
require_once('lib/pdo_db.php');
require_once('models/Purchase.php');
require_once('../vendor/stripe/stripe-php/init.php');
\Stripe\Stripe::setApiKey(getenv('STRIPE_API_KEY'));

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

ini_set('display_errors',1);
error_reporting(E_ALL);

// Sanitize POST array
$POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

$buyer = $POST['buyer'];
$lister_name = $POST['lister_name'];
$bought_quantity = $POST['quantity'];
$first_name = $POST['first_name'];
$last_name = $POST['last_name'];
$price = $POST['price'];
$bought_listing = $POST['listing'];
$email = $POST['email'];
$token = $POST['stripeToken'];

try {
	// Create Customer in Stripe
	$customer = \Stripe\Customer::create(array(
		"email" => $email,
		"source" => $token
	));
	// Try to Charge Customer or catch errors
	$charge = \Stripe\Charge::create(array(
		"amount" => $price,
		"currency" => "eur",
		"description" => $bought_listing,
		"customer" => $customer->id
	));
} catch (Exception $e) {    
	$error = $e->getMessage();
	echo $error;
	exit();
}

// print_r($charge);

// generate a random string as an activation code
function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

$purchase_key = random_str(10);

// Purchase Data
$purchaseData = [
  'buyer' => $buyer,
  'first_name' => $first_name,
  'last_name' => $last_name,
  'bought_from' => $lister_name,
  'bought_listing' => $bought_listing,
  'bought_quantity' => $bought_quantity,
  'purchase_key' => $purchase_key,
  'status' => $charge->status,
  'customer_id' => $charge->id
];

// Instantiate Purchase
$purchase = new Purchase();

// Add Purchase To DB
$purchase->addPurchase($purchaseData);

$mail = new PHPMailer();

// Settings
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';

$mail->Host       = "smtp.gmail.com"; // SMTP server example
$mail->SMTPSecure = 'tls';
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
$mail->Username   = "abolzzy@gmail.com"; // SMTP account username example
$mail->Password   = getenv('MAIL_PASSWORD');        // SMTP account password example
$mail->SetFrom("abolzzy@gmail.com");

// Content
$mail->isHTML(true);                              // Set email format to HTML
$mail->AddAddress($email);
$mail->Subject = 'Grateful pirkums';
$mail->Body    = 'Paldies par pirkumu! Pirkuma kods: '.$purchase_key;
$mail->AltBody = 'Paldies par pirkumu! Pirkuma kods: '.$purchase_key;

if(!$mail->Send()) {
   echo "Mailer Error: " . $mail->ErrorInfo;
} else {
   // Redirect to success
echo "Paldies par pirkumu! Pirkuma kods: $purchase_key";
}

?>