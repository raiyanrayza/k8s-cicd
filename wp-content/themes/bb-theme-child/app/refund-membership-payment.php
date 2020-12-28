<?php

function get_membership_plan_details_by_user($user_id){
	global $wpdb;
	$tab_memberships_users = $wpdb->prefix.'pmpro_memberships_users';
	$tab_membership_levels = $wpdb->prefix.'pmpro_membership_levels';
	$tab_embership_orders  = $wpdb->prefix.'pmpro_membership_orders';

	$paid_for_id = get_user_meta( $user_id, 'paid_for_level', true );

	$user_memberships = array();
	$user_memberships['status'] = 'error';
	
	if( get_user_meta( $user_id, 'first_payment', true ) != 'true' ){
		return $user_memberships;
	}

	$memberships_users = $wpdb->get_row("SELECT * FROM $tab_memberships_users WHERE user_id = '$user_id' AND status = 'inactive' AND membership_id = '$paid_for_id' ORDER BY id DESC LIMIT 1", ARRAY_A);
	
	if($memberships_users){		
		$membership_id = $memberships_users['membership_id'];
		$membership_levels = $wpdb->get_row("SELECT * FROM $tab_membership_levels WHERE id = '$membership_id' ORDER BY id DESC LIMIT 1", ARRAY_A);

		$embership_orders = $wpdb->get_row("SELECT * FROM $tab_embership_orders WHERE membership_id = '$membership_id' AND user_id = '$user_id' ORDER BY id DESC LIMIT 1", ARRAY_A);

		$user_memberships['status'] 		= 'success';
		$user_memberships['memberships'] 	= $memberships_users;
		$user_memberships['levels'] 		= $membership_levels;
		$user_memberships['orders'] 		= $embership_orders;
	}
	return $user_memberships;
}

add_action( 'show_user_profile', 'add_extra_user_fields' );
add_action( 'edit_user_profile', 'add_extra_user_fields' );
function add_extra_user_fields( $user ){

	$user_id = $user->ID;
	$stripe_customerid = get_user_meta($user_id, 'pmpro_stripe_customerid', true);
	$hasMembershipLevel = pmpro_hasMembershipLevel( null, $user_id );
	$pmpro_MembershipLevel = pmpro_getMembershipLevelsForUser( null, $user_id );

	$membership_plan = get_membership_plan_details_by_user($user_id);

	if( get_user_meta( $user->ID, 'first_payment', true ) == 'true' ){
		if($membership_plan['status'] == 'success'){
			if($membership_plan['memberships']['membership_id'] != 1){
				$paymentTransactionId = $membership_plan['orders']['payment_transaction_id'];
				$ct_order_id = $membership_plan['orders']['id'];
				$initial_payment = pmpro_round_price( (float)$membership_plan['memberships']['initial_payment'] );

				?>
				    <h3><?php _e("Refund Membership Payment", "fl-automator"); ?></h3>
				    <table class="form-table payment_transaction_table">
				        <tr class="user-job-title-wrap">
				            <th><label for="job_title"><?php _e('Refund Payment'); ?></label></th>
				            <td>
				            	<input type="checkbox" name="ct_refund_check" id="ct_refund_check" value="yes" class="regular-text ltr" />
				            	<br><br>
				            	<span class="dollor">$</span><input type="text" name="ct_refund_payment" id="ct_refund_payment" value="<?php echo $initial_payment; ?>" class="regular-text ltr active_pay_refund" placeholder="Refund Amount" disabled />
				            	<input type="hidden" name="ct_payment_transaction_id" id="ct_payment_transaction_id" value="<?php echo $paymentTransactionId; ?>">
				            	<input type="hidden" name="ct_order_id" id="ct_order_id" value="<?php echo $ct_order_id; ?>">
				            	<input type="hidden" name="ct_user_id" id="ct_user_id" value="<?php echo $user_id; ?>">
				            	<button type="button" name="ct_refund_pay" id="ct_refund_pay" class="button button-primary active_pay_refund" disabled>
				            		Refund Payment
				            	</button>
				            	<span class="payment_transaction_load">
				            	<img src="<?php echo FL_CHILD_THEME_URL; ?>/assets/image/load.gif" >
				            	</span>
				        </td>
				        </tr>
				        <tr>
				        	<th>&nbsp;</th>
				        	<td class="refund_pro_vel_message">
				        		
				        	</td>
				        </tr>
				    </table>
				<?php
			}
		}
	}
}

add_action( 'personal_options_update', 'save_extra_user_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_fields' );
function save_extra_user_fields( $user_id ){
	if(isset($_POST['job_title']))
    	update_user_meta( $user_id, 'job_title', sanitize_text_field( $_POST['job_title'] ) );
    if(isset($_POST['description']))
    	update_user_meta( $user_id, 'description', sanitize_text_field( $_POST['description'] ) );
}

add_action('admin_footer', function(){

	?>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$('#ct_refund_check').click(function(){
				if ($(this).prop('checked')) {
					$('#ct_refund_payment').removeAttr('disabled');
					$('#ct_refund_pay').removeAttr('disabled');
				}else{
					$('#ct_refund_payment').attr('disabled', true);
					$('#ct_refund_pay').attr('disabled', true);
				}
			});

			jQuery(document).ready(function($){
        		$('#ct_refund_pay').click(function(){
        			$('.payment_transaction_load').show();
        			$('.refund_pro_vel_message').html('');
        			if ($('#ct_refund_check').prop('checked')) {
        				var ct_refund_payment = $('#ct_refund_payment').val();
        				var ct_user_id        = $('#ct_user_id').val();
        				var ct_order_id        = $('#ct_order_id').val();
        				var payment_transaction_id = $('#ct_payment_transaction_id').val();
        				var data = {
					        'action'          		 : 'refund_payment_request',
					        'ct_refund_payment'      : ct_refund_payment,
					        'payment_transaction_id' : payment_transaction_id,
					        'ct_user_id'             : ct_user_id,
					        'ct_order_id'            : ct_order_id
					      };

					    jQuery.post("<?php echo admin_url( 'admin-ajax.php' ); ?>", data, function(response) {
					      
					      var objResponse = jQuery.parseJSON(response);
					      if(objResponse.type == 'success'){
					      	$('.refund_pro_vel_message').html('<div class="alert alert-success" role="alert">'+objResponse.message+'</div>');
					      	setTimeout(function(){
					      		window.location.reload();
					      	},2000);
					      }else{
					      	$('.refund_pro_vel_message').html('<div class="alert alert-danger" role="alert">'+objResponse.message+'</div>');
					      }
					      $('.payment_transaction_load').hide();
					  	});
        			}
        		});
        	});

		});
	</script>
	<?php

});

add_action( 'wp_ajax_refund_payment_request', 'refund_payment_request' );
add_action( 'wp_ajax_nopriv_refund_payment_request', 'refund_payment_request' );
function refund_payment_request(){
	require_once FL_CHILD_THEME_DIR.'/app/stripe/vendor/autoload.php';
	$secret_key = pmpro_getOption('stripe_secretkey');
	$StripeClient = new \Stripe\StripeClient($secret_key);

	$ct_refund_payment 		= $_POST['ct_refund_payment'];
	$payment_transaction_id = $_POST['payment_transaction_id'];
	$ct_user_id             = $_POST['ct_user_id'];
	$ct_order_id			= $_POST['ct_order_id'];
	try {				
		$Refunds = $StripeClient->refunds->create([
		    'charge' => $payment_transaction_id,
			'amount' => $ct_refund_payment
		]);
		
		$StripeRefundsChange = $Refunds->jsonSerialize();

		if($StripeRefundsChange['object'] == 'refund'){
			$user = get_user_by( 'ID', $ct_user_id );

			$user_refunds = get_user_meta($ct_user_id, 'refund_data', true);
			$refund_entry_data = array(
									'order_id'=>$ct_order_id,
									'amount' => $StripeRefundsChange['amount'],
									'created' => $StripeRefundsChange['created'],
									'status' => $StripeRefundsChange['status'],
									'charge' => $StripeRefundsChange['charge'],
									'id' => $StripeRefundsChange['id']
								);
			if( $user_refunds ){
				$user_refund_array = maybe_unserialize($user_refunds);
				$user_refund_array[$ct_order_id] = $refund_entry_data;
				// array_push($user_refund_array, array($ct_order_id => $refund_entry_data) );
				update_user_meta( $ct_user_id, 'refund_data', serialize( $user_refund_array ) );
			}else{				
				update_user_meta( $ct_user_id, 'refund_data', serialize( array($ct_order_id => $refund_entry_data) ) );
			}


			$membershipPlan = get_membership_plan_details_by_user($ct_user_id);
			$membershipPlan['refund'] = $StripeRefundsChange;
			update_user_meta($ct_user_id, 'refund_payment_request', $membershipPlan);
			if(pmpro_changeMembershipLevel(1, $ct_user_id)){
				update_user_meta( $ct_user_id, 'paid_for_level', '' );
				update_user_meta( $ct_user_id, 'first_payment', 'declined' );
				update_user_meta( $ct_user_id, 'pay_approved_by_admin', '0' );
			}else{
				update_user_meta( $ct_user_id, 'paid_for_level', '' );
				update_user_meta( $ct_user_id, 'first_payment', 'declined' );
				update_user_meta( $ct_user_id, 'pay_approved_by_admin', '0' );
			}
			update_user_meta( $ct_user_id, 'refund_done', 'true' );
			if( get_user_meta( $ct_user_id, 'refund_count', true ) ){
				$refund_count = intval( get_user_meta( $ct_user_id, 'refund_count', true ) );
				update_user_meta( $ct_user_id, 'refund_count', ($refund_count+1) );	
			}else{
				update_user_meta( $ct_user_id, 'refund_count', '1' );
			}
			$ref_mail_data = array();
			$ref_mail_data['amount'] = $StripeRefundsChange['amount'];
			$ref_mail_data['id'] = $StripeRefundsChange['id'];
			send_refund_success_mail( $user, $ref_mail_data );

			// wp_mail($user->user_email, 'refund successfull', 'refund mail');
			echo  json_encode(array('type' => 'success', 'message' => 'Amount has been refunded successfully'));
		}else{
			echo  json_encode(array('type' => 'error', 'message' => 'some error occurred please try again'));
		}
	}catch(Exception $e) {
		echo  json_encode(array('type' => 'error', 'message' => $e->getMessage()));
	}
	die();
}


function send_refund_success_mail( $user, $refund_data ){
	$to = $user->user_email;
	$subject = '';
	$body = '';

	if( get_field('refund_success_mail', 'option') ){

		$content = get_field('refund_success_mail', 'option');
		$subject = $content['subject'];
		$body = get_refund_success_mail_content();

		$data = array('user_name'=> $user->first_name, 'user_link'=>site_url( '/login/' ));
		$data['refund_amount'] = $refund_data['amount'];
		$data['transaction_id'] = $refund_data['id'];
		$body = fetch_replace_code_data( $body, $data );

	}else{

		$subject = 'Your refund successfully done';
		$body = 'Hi <br> your refund details are as following <br> Refund transaction id : '.$refund_data['id'].'<br>Refund amount : '.$refund_data['amount'];

	}
	$headers = ['Content-Type: text/html; charset=UTF-8'];
	
	if( wp_mail( $to, $subject, $body, $headers ) )
		return true;
	else
		return false;

}

function get_refund_success_mail_content(){
	$mail_content = get_field('refund_success_mail', 'option');
	return apply_filters( 'replace_paces_site_url', $mail_content['content'] );
}
