<?php
function wpdocs_campaign_admin_script( $hook ) {
    wp_enqueue_style( 'admin_main_css', FL_CHILD_THEME_URL . '/assets/css/admin-custom.css', array(), time(), 'all');
}
add_action( 'admin_enqueue_scripts', 'wpdocs_campaign_admin_script' );

function add_theme_scripts() {

	if(is_page(1217)){
  		wp_enqueue_style( 'stripe_main_css', FL_CHILD_THEME_URL . '/assets/css/stripe_main.css', array(), time(), 'all');
  	} 
}

add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );

function getIPAddress_stripe() {  
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;  
}

add_action( 'wp_ajax_donate_payment_new_action', 'fn_donate_payment_new_action' );
add_action( 'wp_ajax_nopriv_donate_payment_new_action', 'fn_donate_payment_new_action' );

function fn_donate_payment_new_action(){

	$secret_key = pmpro_getOption('stripe_secretkey'); //FL_STRIPE_SECRET_KEY;


	$pay_amount = $_POST['pay_amount'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    
    $payment_token = $_POST['payment_token'];
 
    $email_id 		= $email; 
    $payment_atm 	= $pay_amount; 
    $ip_address 	= getIPAddress_stripe(); 
    $created_at     = date("Y-m-d H:i:s");    

    $description = 'Donate Payment - User - '.$name.' ('.$email.') '.' ('.$phone_number.')';

    \Stripe\Stripe::setApiKey($secret_key);

    try {
	  $token = $payment_token;
	  $charge = \Stripe\Charge::create([
	    'amount' => ($pay_amount*100),
	    'currency' => 'usd',
	    'description' => $description,
	    'source' => $token,
	    'receipt_email' => $email
	  ]);

	  $StripeChange 				= $charge->jsonSerialize();
	  $charge_id 					= $StripeChange['id'];
	  $charge_balance_transaction 	= $StripeChange['balance_transaction'];
	  $charge_payment_method 		= $StripeChange['payment_method'];
	  $charge_receipt_email 		= $StripeChange['receipt_email'];

	  $transaction_id   = $charge_id;
      $transaction_data = json_encode($StripeChange);

	  global $wpdb;
	  $payment_transaction = $wpdb->prefix.'donate_payment';

	 $wpdb->query("INSERT INTO $payment_transaction (name, email_id, phone_number, payment_atm, ip_address, created_at, transaction_id, transaction_data) VALUES ('$name', '$email_id', '$phone_number', '$payment_atm', '$ip_address', '$created_at', '$transaction_id', '$transaction_data')");
	  $insert_id = $wpdb->insert_id;
	  
	  $donation_data_arr = array();
	  $donation_data_arr['amount'] = $pay_amount;
	  $donation_data_arr['id'] = $StripeChange['id'];
	  $donation_data_arr['donor_name'] =$name;
	  $donation_data_arr['donor_email'] =$email;
	  
	  send_donation_mail_to_admin($donation_data_arr);
	  send_donation_mail_to_donor($donation_data_arr);

	  echo  json_encode(array('type' => 'success', 'order_id' => $insert_id, 'invoice_id' => $insert_id, 'payment_id' => $charge_id, 'stripe_result' => $charge->jsonSerialize()));

	}catch(Exception $e) {
	  echo  json_encode(array('type' => 'error', 'message' => $e->getMessage()));
	}

    die();

}


function fn_donate_paces(){ 
    ob_start();

    ?>

    <div class="stripe_success_payment_html stripe_form donate_form_view" style="display: none;" > </div>
	<div class="stripe_payment_html stripe_form donate_form_view">
	  <form name="ctp_purchased" id="ctp_purchased" class="ctp_purchased_form" >
	    <div class="pay_left">
	      <div class="form-group">
	        <label>
	        <span>Name <small>*</small></span>
	        <div class="form_group_filed">
	          <input name="cardholder-name" class="field is-empty" placeholder="Jane Doe" required id="cardholder_name"  value=""/>
	        </div>
	        </label>
	      </div>
	      <div class="form-group">
	        <label>
	        <span>Email <small>*</small></span>
	        <div class="form_group_filed">
	          <input class="field is-empty" type="email" placeholder="janedoe@gmail.com" id="email_name" value="" required />
	        </div>
	        </label>
	      </div>
	      <div class="form-group">
	        <label>
	        <span>Phone Number </span>
	        <div class="form_group_filed">
	          <input class="field is-empty phoneInputbit" type="tel" placeholder="(123) 456-7890" id="tel_name" value="" />
	        </div>
	        </label>
	      </div>
	      <div class="form-group">
	        <label>
	        <span>Credit or Debit Card <small>*</small></span>
	        <div class="form_group_filed">
	          <div id="card-element" class="field is-empty"></div>
	        </div>
	        </label>
	      </div>
	    </div>
	    <div class="pay_right">
	      <div class="form-group">
	        <label>
	        <span>Donation Amount <small>*</small></span>
	        <div class="form_group_filed">
	          <?php /*?><?php echo propertyCurrency('symbol'); ?><?php */?>
	          <input name="pay_amount" class="field is-empty" placeholder="Pay Amount" required id="pay_amount"  value=""/> <span class="ct_currency_type">(USD)</span>
	        </div>
	        </label>
	      </div>	      
	      <button type="submit" id="payment_submit_btn" >Donate Now <span class="loading_spinning_submit" style="display: none;"><i class="fas fa-circle-notch fa-spin"></i></span> </button>
	    </div>
	     <div class="outcome" style="display: none;">
	      <div class="error" role="alert"></div>
	      <div class="success"> Success! Your Stripe token is <span class="token"></span> 
	      </div>
	    </div>
	    
	    <div class="success_payment" style="display: none;">
	    </div>
	  </form>
	</div>


	<?php 
	$publishablekey = pmpro_getOption('stripe_publishablekey');
	$stripe_public_key = $secretkey = pmpro_getOption('stripe_secretkey');
	?>
	<script type="text/javascript">
	function setOutcome(result) {
	  jQuery('.stripe_success_payment_html').html('');
	  var successElement = document.querySelector('.success');
	  var errorElement = document.querySelector('.error');
	  successElement.classList.remove('visible');
	  errorElement.classList.remove('visible');

	  
	  if (result.token) {
	      var pay_amount      = jQuery('#pay_amount').val();
	      var cardholder_name = jQuery('#cardholder_name').val();
	      var email_name      = jQuery('#email_name').val();
	      var tel_name        = jQuery('#tel_name').val();
	      

	    var data = {
	        'action'          : 'donate_payment_new_action',
	        'pay_amount'      : pay_amount,        
	        'name'            : cardholder_name,
	        'email'           : email_name,
	        'phone_number'    : tel_name,
	        'payment_token'   : result.token.id
	      };

	    jQuery.post("<?php echo admin_url( 'admin-ajax.php' ); ?>", data, function(response) {
	      
	      var objResponse = jQuery.parseJSON(response);

	      if(objResponse.type == 'error'){
	        /*errorElement.textContent = objResponse.message;
	        errorElement.classList.add('visible');*/	        
	        jQuery('.stripe_success_payment_html').html('<div class="error_payment">'+objResponse.message+'</div>'); 
	        jQuery('.stripe_success_payment_html').show();
	      }else{
	        jQuery('.stripe_payment_html').hide();
	        jQuery('.stripe_success_payment_html').html('<div class="success_payment">Payment submitted successfully for this account! <spancclass="invoice_cts_id">Invoice Id : '+objResponse.invoice_id+'</span><span class="invoice_payment_id">Payment Id : '+objResponse.payment_id+'</span><div class="my_account_ref"></div></div>'); 
	        jQuery('.stripe_success_payment_html').show();      

	      }
	      jQuery('#payment_submit_btn').removeAttr('disabled');
	      jQuery('.loading_spinning_submit').hide();
	      

	    });
	    //alert(result.token.id);
	    /*
	    alert(result.token.id);    
	    alert(property_id);*/
	    
	  } else if (result.error) {
	    
	    errorElement.textContent = result.error.message;
	    errorElement.classList.add('visible');
	    jQuery('.loading_spinning_submit').hide();
	  }
	}

	    /*alert(stripe_detail.stripe_public_key);*/
	    var stripe = Stripe('<?php echo $publishablekey; ?>');
	    
	    var elements = stripe.elements();

	    var card = elements.create('card', {
	    	hidePostalCode: true,
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

	  document.querySelector('form#ctp_purchased').addEventListener('submit', function(e) {
	  	jQuery('#payment_submit_btn').attr('disabled', 'disabled');
	    jQuery('.loading_spinning_submit').show();
	    e.preventDefault();
	    var form = document.querySelector('form#ctp_purchased');
	    var extraDetails = {
	      name: form.querySelector('input[name="cardholder-name"]').value,
	    };
	    
	    stripe.createToken(card, extraDetails).then(setOutcome);
	  });

	  jQuery(document).ready(function($){
	  	$('body').on('click', '.donate_form_viewbt', function(evn){
	  		evn.preventDefault();
	  		$('.donate_form_view').show();
	  	});
	  });

	</script>

    <?php

	$content = ob_get_contents();
    ob_end_clean();
    return $content;
}
add_shortcode('donate_paces','fn_donate_paces');

/*Admin View*/
function wpdocs_register_my_custom_menu_page(){
    add_menu_page( 
        __( 'Donate Paces', 'textdomain' ),
        'Donate Paces',
        'manage_options',
        'donatepaces',
        'wpdocs_campaign_display_callback',
        'dashicons-index-card',
        6
    ); 
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );

function price_format($price){
	return number_format($price,2);
}

function wpdocs_campaign_display_callback( $post ) {
    
    global $wpdb;
	$tab_campaign_payment = $wpdb->prefix."donate_payment";

	$rresults = $wpdb->get_results("SELECT * FROM $tab_campaign_payment order by id desc");
	$ix = 1;
    ?>
<div class="wrap">
    <div class="campaign_payments_transactions">
    	<div class="payments_transactions_head"><h3>Donate Paces</h3></div>
		<table id="t_payment_table" class="display nowrap" style="width:100%">
		  <thead>
		      <tr>
		          <th>#</th>
		          <th>Name</th>
		          <th>Email</th>
		          <th>Phone Number</th>
		          <th>Donate Amount</th>
		          <th>Payment Date</th>          
		      </tr>
		  </thead>
		  <tbody>
		    <?php
		      if($rresults){
		        foreach ($rresults as $key => $results) {
		          ?>
		          <tr>
		              <td><?php echo $ix; ?></td>
		              <td><?php echo $results->name; ?></td>
		              <td><?php echo $results->email_id; ?></td>
		              <td><?php echo $results->phone_number; ?></td>
		              <td>$<?php echo price_format($results->payment_atm); ?></td>
		              <td><?php echo $results->created_at; ?></td>
		          </tr>
		          <?php
		          $ix++;
		        }
		      }
		    ?>      
		  </tbody>
		</table>
	</div>
</div>
	<script type="text/javascript" src="<?php echo FL_CHILD_THEME_URL; ?>/assets/datatables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?php echo FL_CHILD_THEME_URL; ?>/assets/datatables/dataTables.rowReorder.min.js"></script>
	<script type="text/javascript" src="<?php echo FL_CHILD_THEME_URL; ?>/assets/datatables/dataTables.responsive.min.js"></script>

	<link rel="stylesheet" type="text/css" href="<?php echo FL_CHILD_THEME_URL; ?>/assets/datatables/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo FL_CHILD_THEME_URL; ?>/assets/datatables/rowReorder.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo FL_CHILD_THEME_URL; ?>/assets/datatables/responsive.dataTables.min.css">

	<script type="text/javascript">
	  jQuery(document).ready(function($) {
	    var table = $('#t_payment_table').DataTable( {
	        responsive: true
	    } );
	} );
	</script>
    <?php
}



function send_donation_mail_to_admin( $donation_data ){
	$to = get_option( 'admin_email' );
	// $to = 'nilesh.bitcot@gmail.com';
	$subject = '';
	$body = '';

	if( get_field('donation_mail_to_admin', 'option') ){

		$content = get_field('donation_mail_to_admin', 'option');
		$subject = $content['subject'];
		$body = get_donation_success_mail_content();

		$data = array('user_name'=> $user->user_login, 'user_link'=>site_url( '/login/' ));
		$data['donation_amount'] = $donation_data['amount'];
		$data['transaction_id'] = $donation_data['id'];
		$data['donor_name'] = $donation_data['donor_name'];
		$body = fetch_replace_code_data( $body, $data );

	}else{

		$subject = 'We got gift in PACES Donation';
		$body = 'Hi <br> we got donation of '.$donation_data['amount'].'<br> transaction id : '.$donation_data['id'];

	}
	$headers = ['Content-Type: text/html; charset=UTF-8'];
	
	if( wp_mail( $to, $subject, $body, $headers ) )
		return true;
	else
		return false;

}
function get_donation_success_mail_content(){
	$mail_content = get_field('donation_mail_to_admin', 'option');
	return apply_filters( 'replace_paces_site_url', $mail_content['content'] );
}

function send_donation_mail_to_donor( $donation_data ){
	$to = $donation_data['donor_email'];
	$subject = '';
	$body = '';

	if( get_field('donation_mail_to_donor', 'option') ){

		$content = get_field('donation_mail_to_donor', 'option');
		$subject = $content['subject'];
		$body = get_donation_success_mail_donor_content();

		$data = array('donor_name'=> $donation_data['donor_name'] );
		$data['donation_amount'] = $donation_data['amount'];
		$data['transaction_id'] = $donation_data['id'];
		$body = fetch_replace_code_data( $body, $data );

	}else{

		$subject = 'Thank you for your generous gift (Donation) to PACES';
		$body = 'Hi <br> Thank you for your generous gift (Donation) to PACES <br> Refund transaction id : '.$donation_data['id'].'<br>Refund amount : '.$donation_data['amount'];

	}
	$headers = ['Content-Type: text/html; charset=UTF-8'];
	
	if( wp_mail( $to, $subject, $body, $headers ) )
		return true;
	else
		return false;

}



function get_donation_success_mail_donor_content(){
	$mail_content = get_field('donation_mail_to_donor', 'option');
	return apply_filters( 'replace_paces_site_url', $mail_content['content'] );
}