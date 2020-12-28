function setOutcome(result) {
  var successElement = document.querySelector('.success');
  var errorElement = document.querySelector('.error');
  successElement.classList.remove('visible');
  errorElement.classList.remove('visible');

  if (result.token) {
    
      /*var pay_amount      = jQuery('#pay_amount').val();
      var processing_fees = jQuery('#processing_fees').val();
      var total_amount    = jQuery('#total_amount').val();
      var cardholder_name = jQuery('#cardholder_name').val();
      var email_name      = jQuery('#email_name').val();
      var tel_name        = jQuery('#tel_name').val();
      var user_id         = jQuery('#user_id').val();

    var data = {
        'action'          : 'property_purchase_new_action',
        'pay_amount'      : pay_amount,
        'processing_fees' : processing_fees,
        'total_amount'    : total_amount,
        'name'            : cardholder_name,
        'email'           : email_name,
        'phone_number'    : tel_name,
        'user_id'         : user_id,
        'payment_token'   : result.token.id
      };

    jQuery.post(stripe_detail.vb_ajax_url, data, function(response) {
      
      var objResponse = jQuery.parseJSON(response);

      if(objResponse.type == 'error'){
        errorElement.textContent = objResponse.message;
        errorElement.classList.add('visible');
      }else{
        jQuery('.stripe_payment_html').hide();
        jQuery('.stripe_success_payment_html').html('<div class="success_payment">Payment submitted successfully for this account! <spancclass="invoice_cts_id">Invoice Id : '+objResponse.invoice_id+'</span><span class="invoice_payment_id">Payment Id : '+objResponse.payment_id+'</span><div class="my_account_ref"><a href="'+objResponse.ref_url+'">My Account</a></div></div>');

        

      }

      jQuery('.loading_spinning_submit').hide();
      

    });*/
    alert(result.token.id);
    /*
    alert(result.token.id);    
    alert(property_id);*/
    
  } else if (result.error) {
    
    errorElement.textContent = result.error.message;
    errorElement.classList.add('visible');
    jQuery('.loading_spinning_submit').hide();
  }
}

    //alert(stripe_detail.stripe_public_key);
    var stripe = Stripe(stripe_detail.stripe_public_key);
    
    var elements = stripe.elements();

    var card = elements.create('card', {
      iconStyle: 'solid',
      style: {
        base: {
          iconColor: '#8898AA',
          color: '#000',
          lineHeight: '36px',
          fontWeight: 300,
          fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
          fontSize: '19px',

          '::placeholder': {
            color: '#8898AA',
          },
        },
        invalid: {
          iconColor: '#e85746',
          color: '#e85746',
        }
      },
      classes: {
        focus: 'is-focused',
        empty: 'is-empty',
      },
    });
    card.mount('#card-element');

    var inputs = document.querySelectorAll('input.field');
    Array.prototype.forEach.call(inputs, function(input) {
      input.addEventListener('focus', function() {
        input.classList.add('is-focused');
      });
      input.addEventListener('blur', function() {
        input.classList.remove('is-focused');
      });
      input.addEventListener('keyup', function() {
        if (input.value.length === 0) {
          input.classList.add('is-empty');
        } else {
          input.classList.remove('is-empty');
        }
      });
    });

  card.on('change', function(event) {
    setOutcome(event);
  });

  document.querySelector('form').addEventListener('submit', function(e) {
    jQuery('.loading_spinning_submit').show();   
    alert("test 123");
    e.preventDefault();
    var form = document.querySelector('form');
    var extraDetails = {
      name: form.querySelector('input[name="cardholder-name"]').value,
    };
    
    stripe.createToken(card, extraDetails).then(setOutcome);
  });


