// Set your publishable key: remember to change this to your live publishable key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
var stripe = Stripe('pk_test_51H8QonCs4UEdws6aRONgPLXiL2mXpohnWvKfLSROlqUdkKbyGUEdHkNH5SCtd6S91nRGbYTBfpVluPTLLTMBqpte00oh63M1EJ');
var elements = stripe.elements();

$('#card-errors').hide();
$('#success-modal').hide();

// Custom styling can be passed to options when creating an Element.
var style = {
  base: {
    fontSize: '16px',
    color: '#32325d',
  },
};

// Create an instance of the card Element.
var cardNumber = elements.create('cardNumber', {
  placeholder: 'Kartes nr',
  style: style
});

// Add an instance of the card Element into the `card-element` <div>.
cardNumber.mount('#card-element-nr');

// Create an instance of the card Element.
var cardCvc = elements.create('cardCvc', {
  style: style
});

// Add an instance of the card Element into the `card-element` <div>.
cardCvc.mount('#card-element-cvc');

// Create an instance of the card Element.
var cardExpiry = elements.create('cardExpiry', {
  placeholder: 'MM/GG',
  style: style
});

// Add an instance of the card Element into the `card-element` <div>.
cardExpiry.mount('#card-element-expiry');

// Create a token or display an error when the form is submitted.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();

  stripe.createToken(cardNumber).then(function(result) {
    if (result.error) {
      // Inform the customer that there was an error.
      var errorElement = document.getElementById('card-errors');
      errorElement.textContent = result.error.message;
    } else {
      // Send the token to your server.
      stripeTokenHandler(result.token);
    }
  });
});

function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  // form.submit();

  $('#spinner').removeClass('d-none');
  var request;
  var $inputs = $('#payment-form').find("input, select, button, textarea");
  var data = $('#payment-form').serialize();

    // Abort any pending request
    if (request) {
      request.abort();
    }

    request = $.ajax({
        url : './charge.php',
        method : "POST",
        data : data,
        cache : false
    });
    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        if (response.includes('Paldies')) {
          $('#success-modal').show();
          $('#modal-key').html(response);
        } else {
          if (response == 'Your card was declined.') {
            response = 'Jūsu karte nav pieņemta';
          } else if (response == 'Your card\'s security code is incorrect.') {
            response = 'Neizdevās kartes CVC koda pārbaude vai kods ievadīts nepareizi. Lūdzu pārbaudiet un mēģiniet vēlreiz.'
          } else if (response == 'Your card\'s security code is incomplete.') {
             response = 'Nepareizs CVC kods.'
          } else if (response == 'Your card number is invalid.') {
             response = 'Kartes numurs nav pareizs.'
          } else if (response == 'Your card\'s expiration year is invalid.') {
             response = 'Kartes derīguma termiņš nepareizs.'
          }
          $('#card-errors').show();
          $('#card-errors').html(response);
        }
        $('#spinner').addClass('d-none');
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "Notikusi kļūda: "+
            textStatus, errorThrown
        );
        $('#spinner').addClass('d-none');
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });
}