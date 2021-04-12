@extends('layouts.app')

@section('content')
<div class="row my-3">
  <form action="/charge.php" method="post" id="payment-form" class="w-100">
    @csrf
    
      <?php
        // Sanitize POST array
        $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

        $lister_name = $POST['lister_name'];
        $buyer = $POST['buyer'];
        $bought_quantity = $POST['boughtQuantity'];
        $bought_listing = $POST['boughtListing'];
        $price = $bought_quantity * $POST['price'] * 100;
      ?>
      <div class="col-12 col-md-6 mx-auto">
        <p><?=$bought_listing?></p>
        <p>Pirkuma summa: <?=$POST['price']*$bought_quantity?>EUR</p>

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
        <div class="clearfix">
          <div class="mb-2 col-6 form-control d-inline-block float-left" id="card-element-cvc">
          </div>
          <div class="mb-2 col-6 form-control d-inline-block float-left" id="card-element-expiry">
          </div>
        </div>

        <!-- Used to display Element errors. -->
        <div id="card-errors" role="alert" class="alert alert-danger"></div>
        <button id="pay-btn" class="btn btn-primary">Iesniegt maksājumu<span id="spinner" class="d-none spinner-border spinner-border-sm mx-2" role="status"></span></button>
      </div>
  </form>
</div>

                        <div id="success-modal" class="modal" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Paldies par pirkumu!</h5>
                                    </div>
                                    <div class="modal-body">
                                        <p id="modal-key"></p>
                                        <a href="/pirkumi">Mani pirkumi</a>
                                    </div>

                                    <!-- Sharingbutton Facebook -->
                                    <a class="resp-sharing-button__link" href="https://facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.grateful.lv" target="_blank" rel="noopener" aria-label="Share on Facebook">
                                      <div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/></svg>
                                        </div>Dalīties Facebook</div>
                                    </a>

                                    <!-- Sharingbutton Twitter -->
                                    <a class="resp-sharing-button__link" href="https://twitter.com/intent/tweet/?text=Hey!%20Es%20tikko%20ātri%20un viegli%20izglābu%20maltīti%20ar%20Grateful!&amp;url=http%3A%2F%2Fwww.grateful.lv" target="_blank" rel="noopener" aria-label="Share on Twitter">
                                      <div class="resp-sharing-button resp-sharing-button--twitter resp-sharing-button--large"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--solid">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M23.44 4.83c-.8.37-1.5.38-2.22.02.93-.56.98-.96 1.32-2.02-.88.52-1.86.9-2.9 1.1-.82-.88-2-1.43-3.3-1.43-2.5 0-4.55 2.04-4.55 4.54 0 .36.03.7.1 1.04-3.77-.2-7.12-2-9.36-4.75-.4.67-.6 1.45-.6 2.3 0 1.56.8 2.95 2 3.77-.74-.03-1.44-.23-2.05-.57v.06c0 2.2 1.56 4.03 3.64 4.44-.67.2-1.37.2-2.06.08.58 1.8 2.26 3.12 4.25 3.16C5.78 18.1 3.37 18.74 1 18.46c2 1.3 4.4 2.04 6.97 2.04 8.35 0 12.92-6.92 12.92-12.93 0-.2 0-.4-.02-.6.9-.63 1.96-1.22 2.56-2.14z"/></svg>
                                        </div>Dalīties Twitter</div>
                                    </a>


                                </div>
                            </div>
                        </div>
@endsection

@section('scripts')
  <script type="application/javascript" src="/js/jQuery.min.js"></script>
  <script src="https://js.stripe.com/v3/"></script>
  <script src="js/charge.js"></script>
@stop