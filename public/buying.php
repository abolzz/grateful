<?php

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function

    // require_once 'includes/PHPMailer/PHPMailer.php';
    // require_once 'includes/PHPMailer/Exception.php';
    // require_once 'includes/PHPMailer/SMTP.php';


    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require_once 'connection.php';
    require_once 'lib/autoload.php';

    // session_start();

    // if(isset($_SESSION['username']) && !isset($_COOKIE['currentuser'])) {
    //     $thisuser = $_SESSION['username'];
    // } else {
    //     header("Location: /");
    // }
    
    // reservations(buying)
    if(isset($_GET['boughtListing']) && isset($_GET['boughtQuantity']) && isset($_GET['lister_name']) && isset($_GET['buyer'])) {
   
        $bought_listing = $_GET['boughtListing'];
        $bought_quantity = $_GET['boughtQuantity'];
        $listerName = $_GET['lister_name'];
        $buyer = $_GET['buyer'];

        // $listings = $link->query("SELECT *, DATE_FORMAT(pickup_time, '%d/%m/%y %H:%i') as time FROM listings WHERE (listing_name = '".$bought_listing."') AND (quantity > 0) AND pickup_time > DATE_ADD(NOW(), INTERVAL 30 MINUTE)");
        $listings = $link->query("SELECT * FROM listings WHERE (listing_name = '".$bought_listing."')");

        $listings = $listings->fetch_assoc();

        // $clients_address = $link->query("SELECT address FROM clients WHERE name = '".$listerName."'");

        // $clients_address = $clients_address->fetch_assoc();

        $price = $bought_quantity * $listings["price"];
        
        if(!empty($_GET["status"])) {

            //echo "<h4>Payment Done Successfully<h4>" ;
        }

        if(isset($_GET["status"])) {

            if($_GET["status"] == 0) {

                //echo "<h4> Payment Unsuccessfull Reason : ".$_GET["msg"]."</h4>" ;

                //erorrs
            }

        }
        
    } else {
        header('Location: '. '/');
    }

    $gateway = new Braintree_Gateway([
        'environment' => 'sandbox',
        'merchantId' => 'mz5fgmzpfsvs3fr7',
        'publicKey' => 'd86b5qmcg38np4mh',
        'privateKey' => 'fa4ed398b8e52b26665c9e2201d868af'
    ]);
    
    $clientToken = $gateway->clientToken()->generate();
    
    if (isset($_POST['nonceFromTheClient'])) {

                $result = $gateway->transaction()->sale([
                    'amount' => $_POST['price'],
                    'paymentMethodNonce' => $_POST['nonceFromTheClient'],
                    'options' => ['submitForSettlement' => True]
                ]);

    //        echo "<pre>";
    //        print_r($result);
    //        exit();


            //successful transaction
            if($result->success) {

            // session_start();

            $listings = $link->query("SELECT *, DATE_FORMAT(pickup_time, '%d/%m/%y %H:%i') as time FROM listings WHERE (listing_name = '".$_POST["listing"]."') AND quantity > 0");

            $listings = $listings->fetch_assoc();

            // $clients_address = $link->query("SELECT address FROM clients WHERE name = '".$_POST['lister_name']."'");

            // $clients_address = $clients_address->fetch_assoc();

                // update quantity
            $update_quantity = $link->query("UPDATE listings SET quantity = quantity - 1 WHERE (listing_name = '".$_POST["listing"]."') AND quantity > 0");


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


            // set purchase
            $set_buyer = $link->query("INSERT INTO purchases (buyer,bought_from,bought_listing,bought_quantity, purchase_key) VALUES ('".$_POST["buyer"]."', '".$_POST["lister_name"]."', '".$listings["listing_name"]."', '".$_POST["quantity"]."', '".$purchase_key."')");

            // ob_start(); //STARTS THE OUTPUT BUFFER
            // include('includes/receipt.php');  //INCLUDES YOUR PHP PAGE AND EXECUTES THE PHP IN THE FILE
            // $receipt_contents = ob_get_contents() ;  //PUT THE CONTENTS INTO A VARIABLE
            // ob_clean();  //CLEAN OUT THE OUTPUT BUFFER

            // // send a mail
            // $mail = new PHPMailer(true);
            // $mail->CharSet = 'UTF-8';

            // try {
            //     //Server settings
            //     $mail->isSMTP();                                            // Set mailer to use SMTP
            //     $mail->Host       = 'mail.grateful.lv';  // Specify main and backup SMTP servers
            //     $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            //     $mail->Username   = 'contact@grateful.lv';                     // SMTP username
            //     $mail->Password   = 'w290k9p]^pPW';                               // SMTP password
            //     $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
            //     $mail->Port       = 25;                                    // TCP port to connect to

            //     //Recipients
            //     $mail->setFrom('contact@grateful.lv', 'Grateful');
            //     $mail->addAddress($_SESSION['username']);     // Add a recipient
            //     //$mail->addAddress('davisabols@inbox.lv');               // Name is optional
            //     $mail->addReplyTo('contact@grateful.lv', 'Information');

            //     // Content
            //     $mail->isHTML(true);                                  // Set email format to HTML
            //     $mail->Subject = 'Čeks par pirkumu';

            //     $mail->Body = $receipt_contents;

            //     $mail->AltBody = "";

            //     $mail->send();
            //     // echo 'Message has been sent';
            // } catch (Exception $e) {
            //     // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            // }

            header("Location: buying.php?buyer=".$_POST["buyer"]."&boughtQuantity=".$_POST["quantity"]."&lister_name=".$_POST["lister_name"]."&boughtListing=".urlencode($listings["listing_name"])."&purchase_key=".$purchase_key."&status=1");

            //     die;

            // } else {

            //     header("Location: https://app.grateful.lv/buying.php?boughtQuantity=".$_POST["quantity"]."&lister_name=".$_POST["lister_name"]."&boughtListing=".urlencode($listings["listing_name"])."&status=0&msg=".urlencode($result->message));

            //         // errors
            } else {
                print_r($result->message);

            }

    }
    
    ?>
<!DOCTYPE html>
<html lang="lv">
<head>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style>
            .toast {
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 9999;
            }

            .bootstrap-basic {
            background: white;
            }

            /* Braintree Hosted Fields styling classes*/
            .braintree-hosted-fields-focused {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }

            .braintree-hosted-fields-focused.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
            }
        </style>
</head>

<body class="buying">

<?php
    if(!isset($_GET['status'])) {
       ?>

<button class="backButton" onclick="window.history.back(); ga('gtag_UA_138741693_1.send', 'event', 'buyingBackButton', 'click')">
    <img src="img/back-button.svg" alt="Back">
</button>

<?php
	} else {
?>
		<a href="https://app.grateful.lv" class="backButton" onclick="ga('gtag_UA_138741693_1.send', 'event', 'buyingBackButton', 'click')">
    <img src="img/back-button.svg" alt="Back">
</a>
<?php
	}
?>



<div class="overlay"></div>

<main id="buyingContainer" class="popup">

    <!-- Bootstrap inspired Braintree Hosted Fields example -->
<div class="bootstrap-basic container">
  <form class="needs-validation" novalidate="" action="buying.php" method="post" id="form_submit">

            <input type="hidden" name="nonceFromTheClient" id="nonce">
            <input type="hidden" name="lister_name" value="<?=$listings['lister_name']?>">
            <input type="hidden" name="price" value="<?=$price?>">
            <input type="hidden" name="buyer" value="<?=$buyer?>">
            <input type="hidden" name="quantity" value="<?=$bought_quantity?>">
            <input type="hidden" name="listing" value="<?=$listings['listing_name']?>">

    <div class="row">
      <div class="col-sm-6 mb-3">
        <label for="cc-name">Vārds</label>
        <input type="text" class="form-control" id="cc-name" placeholder="" required="true">
        <!-- <small class="text-muted">Vāŗds, uzvārds uz kartes</small> -->
        <!-- <div class="invalid-feedback">
          Lūdzu ievadiet vārdu uz kartes
        </div> -->
      </div>
      <!-- <div class="col-sm-6 mb-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" placeholder="you@example.com">
        <div class="invalid-feedback">
          Please enter a valid email address for shipping updates.
        </div>
      </div>
    </div> -->

    <div class="row">
      <div class="col-sm-6 mb-3">
        <label for="cc-number">Kartes nr</label>
        <div class="form-control" id="cc-number"></div>
        <!-- <div class="invalid-feedback">
            Kartes nr nav pareizs
        </div> -->
      </div>
      <div class="col-sm-3 mb-3">
        <label for="cc-expiration">Derīga līdz</label>
        <div class="form-control" id="cc-expiration"></div>
        <!-- <div class="invalid-feedback">
          Lūdzu aizpildiet
        </div> -->
      </div>
      <div class="col-sm-3 mb-3">
        <label for="cc-expiration">CVV</label>
        <div class="form-control" id="cc-cvv"></div>
        <!-- <div class="invalid-feedback">
          Lūdzu aizpildiet
        </div> -->
      </div>
    </div>

    <hr class="mb-4">
    <div class="text-center">
    <button class="btn btn-primary btn-lg" type="submit">Izpildīt maksājumu</button>
    <!-- <span id="card-brand">Card</span> -->
    </div>
  </form>
</div>
<div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
<div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
  <div class="toast-header">
    <!-- <strong class="mr-auto">Success!</strong> -->
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="toast-body">
    Apstrādājam maksājumu, lūdzu uzgaidiet...
  </div>
</div>
</div>

  <!-- Load the required client component. -->
  <script src="https://js.braintreegateway.com/web/3.58.0/js/client.min.js"></script>

  <!-- Load Hosted Fields component. -->
  <script src="https://js.braintreegateway.com/web/3.58.0/js/hosted-fields.min.js"></script>

</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script>
    // var button = document.querySelector('#submit-button');

    // braintree.dropin.create({
    //     authorization: "<?=$clientToken?>",
    //     container: '#dropin-container',
    //     translations: {
    //         payWithCard: 'Veikt maksājumu',
    //         expirationDateLabel: 'Derīga līdz',
    //         cardNumberLabel: 'Kartes nr. ...',
    //         fieldEmptyForNumber: 'Lūdzu ievadiet kartes numuru.',
    //         fieldEmptyForExpirationDate: 'Lūdzu ievadiet kartes derīguma termiņu.',
    //         hostedFieldsFieldsInvalidError: 'Lūdzu pārbaudiet savu informāciju un mēģiniet vēlreiz.',
    //         fieldInvalidForNumber: 'Kartes numurs nav pareizs.',
    //         fieldInvalidForExpirationDate: 'Derīguma termiņš nav pareizs.',
    //         endingIn: 'Kartes nr. {{lastFourCardDigits}}',
    //     }
    // }, function (createErr, instance) {
    //     button.addEventListener('click', function () {
    //         instance.requestPaymentMethod(function (err, payload) {
    //             //console.log(payload);
    //             document.getElementById("nonce").value = payload.nonce;
    //             document.getElementById("form_submit").submit();

    //             button.classList.add("d-none");

    //         });
    //     });
    // });

    var form = $('form');

braintree.client.create({
  authorization: '<?=$clientToken?>'
}, function(err, clientInstance) {
  if (err) {
    console.error(err);
    return;
  }

  braintree.hostedFields.create({
    client: clientInstance,
    styles: {
      input: {
        // change input styles to match
        // bootstrap styles
        'font-size': '1rem',
        color: '#495057'
      }
    },
    fields: {
      number: {
        selector: '#cc-number',
        placeholder: '4111 1111 1111 1111'
      },
      cvv: {
        selector: '#cc-cvv',
        placeholder: '123'
      },
      expirationDate: {
        selector: '#cc-expiration',
        placeholder: 'MM / YY'
      }
    }
  }, function(err, hostedFieldsInstance) {
    if (err) {
      console.error(err);
      return;
    }
    function createInputChangeEventListener(element) {
      return function () {
        validateInput(element);
      }
    }

    function setValidityClasses(element, validity) {
      if (validity) {
        element.removeClass('is-invalid');
        element.addClass('is-valid');  
      } else {
        element.addClass('is-invalid');
        element.removeClass('is-valid');  
      }    
    }
    
    function validateInput(element) {
      // very basic validation, if the
      // fields are empty, mark them
      // as invalid, if not, mark them
      // as valid

      if (!element.val().trim()) {
        setValidityClasses(element, false);

        return false;
      }

      setValidityClasses(element, true);

      return true;
    }
    
    // function validateEmail () {
    //   var baseValidity = validateInput(email);
      
    //   if (!baseValidity) {  
    //     return false;
    //   }

    //   if (email.val().indexOf('@') === -1) {
    //     setValidityClasses(email, false);
    //     return false;
    //   }
      
    //   setValidityClasses(email, true);
    //   return true;
    // }

    var ccName = $('#cc-name');
    // var email = $('#email');

    ccName.on('change', function () {
      validateInput(ccName);
    });
    // email.on('change', validateEmail);


            hostedFieldsInstance.on('validityChange', function(event) {
      var field = event.fields[event.emittedBy];

      // Remove any previously applied error or warning classes
      $(field.container).removeClass('is-valid');
      $(field.container).removeClass('is-invalid');

      if (field.isValid) {
        $(field.container).addClass('is-valid');
      } else if (field.isPotentiallyValid) {
        // skip adding classes if the field is
        // not valid, but is potentially valid
      } else {
        $(field.container).addClass('is-invalid');
      }
    });

    hostedFieldsInstance.on('cardTypeChange', function(event) {
      var cardBrand = $('#card-brand');
      var cvvLabel = $('[for="cc-cvv"]');

      if (event.cards.length === 1) {
        var card = event.cards[0];

        // change pay button to specify the type of card
        // being used
        cardBrand.text(card.niceType);
        // update the security code label
        cvvLabel.text(card.code.name);
      } else {
        // reset to defaults
        cardBrand.text('Card');
        cvvLabel.text('CVV');
      }
    });

    form.submit(function(event) {
      event.preventDefault();

      var formIsInvalid = false;
      var state = hostedFieldsInstance.getState();

      // perform validations on the non-Hosted Fields
      // inputs
    //   if (!validateEmail() || !validateInput($('#cc-name'))) {
    //     formIsInvalid = true;
    //   }

      // Loop through the Hosted Fields and check
      // for validity, apply the is-invalid class
      // to the field container if invalid
      Object.keys(state.fields).forEach(function(field) {
        if (!state.fields[field].isValid) {
          $(state.fields[field].container).addClass('is-invalid');
          formIsInvalid = true;
        }
      });

      if (formIsInvalid) {
        // skip tokenization request if any fields are invalid
        return;
      }

        hostedFieldsInstance.tokenize({
        cardholderName: $('#cc-name').val()
      }, function(err, payload) {
        if (err) {
          console.error(err);
          return;
        }

        $('.toast').toast('show');

        document.getElementById("nonce").value = payload.nonce;
        document.getElementById("form_submit").submit();
      });
    });
  });
});
</script>

<?php
    if(isset($_GET['status']) && ($_GET['status'] == 1)) {
       ?>
       
       <script type="text/javascript">
       document.getElementById("buyingContainer").classList.add("d-none");
        </script>
        <div class="popupWrap">
           <div class="popup paymentDonePopup">
               <p class="popupText thankYou">Paldies par pirkumu!</p>
               <p class="popupText">Saņemt pasūtījumu varēsiet uzrādot pirkuma kodu:<br>
                <span class="purchaseKeyInner">
                    <?php echo $_GET['purchase_key']; ?>
                </span>
                </p>
               <a href="/pirkumi" class="popupText">Iet uz pirkumiem</a>
           </div>
       </div>
       <?php
    } else {
        //header("Location: /");
    }

?>

</body>

</html>