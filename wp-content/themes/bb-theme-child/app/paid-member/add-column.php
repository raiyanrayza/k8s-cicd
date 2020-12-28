<?php
if( PMPRO_DIR ){
	require_once PMPRO_DIR.'/includes/lib/Stripe/init.php';
}
$stripe = new Stripe\StripeClient(pmpro_getOption( "stripe_secretkey" ));

add_filter( 'pmpro_manage_memberslist_columns', 'add_custom_column_renew', 10 , 1 );
function add_custom_column_renew( $columns ){
	if ( isset( $_REQUEST['l'] ) ) {
		$l = sanitize_text_field( $_REQUEST['l'] );
	} else {
		$l = false;
	}
	$columns['m_status'] = 'Status';
	// $columns['renew'] = 'Action';
	if ( 'expired' === $l ) {
		$columns['renew'] = 'Action';
	}
	return $columns;
}


// pmpro_manage_memberslist_custom_column
add_action( 'pmpro_manage_memberslist_custom_column', 'custom_column_renew_defualt', 10, 2 );
function custom_column_renew_defualt( $column_name, $item ){
	$card_check = get_user_meta( $item, 'membership_card_state', true );
	if( $column_name == 'renew' ){
		?>
		<style>
			.p-btn:hover {
				text-decoration: underline;
			}
		</style>
		<?php
		if( $card_check == 'expired' ){
			?>
			<div class="pc-action-btn">
				<a href="#" class="mail-action-btn p-btn" data-id='<?php echo $item; ?>'>
					Send Mail <span style="display: none;" class="dashicons dashicons-update spin"></span>
				</a>
				&nbsp;|&nbsp;
				<a href="#" class="card-action-btn p-btn" data-id='<?php echo $item; ?>'>
					Update Card <span style="display: none;" class="dashicons dashicons-update spin"></span>
				</a>
				&nbsp;|&nbsp;
				<a href="#" class="invoice-action-btn p-btn" data-id='<?php echo $item; ?>'>
					Send Invoice <span style="display: none;" class="dashicons dashicons-update spin"></span>
				</a>
			</div>
			<?php
		}else{
			?>
			<div class="pc-action-btn">
				<?php
				if(get_user_meta( $item, 'pmpro_stripe_customerid', true )){
					?>
					<a href="#" class="custom-action-btn p-btn" data-id='<?php echo $item; ?>'>
						Pay and Renew Now <span style="display: none;" class="dashicons dashicons-update spin"></span>
					</a>
					|
					<?php
				}
				?>
				<a href="#" class="manual-action-btn p-btn" data-id='<?php echo $item; ?>'>
					Manual Activate <span style="display: none;" class="dashicons dashicons-update spin"></span>
				</a>
				&nbsp;|&nbsp;
				<a href="#" class="invoice-action-btn p-btn" data-id='<?php echo $item; ?>'>
					Send Invoice <span style="display: none;" class="dashicons dashicons-update spin"></span>
				</a>
			</div>
			<?php
		}
			
	}
	if( $column_name == 'm_status' ){
		$approved_check = intval( get_user_meta($item,'pay_approved_by_admin',true) );
		if( $approved_check ){
			echo 'Approved (Paid)';
		}else if( get_user_meta($item,'first_payment',true) == 'declined' && get_user_meta($item,'refund_done',true) == 'true' ){
			echo 'Rejected';
		}else if( get_user_meta($item,'first_payment',true) == 'true' ){
			echo 'Pending';
		}else{
			echo 'Guest/Not joined';
		}
	}
}


add_action( 'wp_ajax_paces_manual_renew', 'paces_manual_renew_action' );
// add_action( 'wp_ajax_nopriv_paces_hard_renew', 'paces_hard_renew_action' );
function paces_manual_renew_action() {
	$user_id = intval($_POST['id']);
	if(empty($user_id)) die('fail');
	
 	$result = custom_pmpro_order_create_hack_by_check($user_id);
	if($result['status'] == 'success'){
		echo 'success';
	}else{
		echo 'fail';
	}
	wp_die();
}


add_action( 'wp_ajax_paces_hard_renew', 'paces_hard_renew_action' );
// add_action( 'wp_ajax_nopriv_paces_hard_renew', 'paces_hard_renew_action' );
function paces_hard_renew_action() {
	$user_id = intval($_POST['id']);
	if(empty($user_id)) die('fail');
 	$result = custom_pmpro_order_create_hack($user_id);
	if($result['status'] == 'success'){
		echo 'success';
	}else{
		echo 'fail';
	}
	wp_die();
}

add_action( 'wp_ajax_paces_send_mail', 'paces_send_mail_action' );
function paces_send_mail_action() {
	$user_id = intval($_POST['id']);
	if(empty($user_id)) die('fail');
	$user = get_user_by( 'ID', $user_id );
	$level_id = get_last_level_id($user_id);
 	if( send_card_update_mail($user, $level_id) ){
		echo 'success';
	}else{
		echo 'fail';
	}
	wp_die();
}

add_action( 'wp_ajax_paces_send_invoice_renew', 'paces_send_invoice_renew_action' );
function paces_send_invoice_renew_action() {
	$user_id = intval($_POST['id']);
	if( empty($user_id) || !get_user_by( 'ID', $user_id ) ) die('fail');
	
	$user = get_user_by( 'ID', $user_id );
	
	$level_id = get_last_level_id_any_status($user_id);

	if( $level_id ){
		if( send_upcoming_payment_invoice_mail($user, $level_id) ){
			echo 'success';
		}else{
			echo 'fail';
		}
	}else{
		echo 'fail';
	}
	wp_die();
}

function get_last_level_id_any_status($user_id){
	global $wpdb;
	$table = $wpdb->prefix . 'pmpro_memberships_users';
	$res = $wpdb->get_row(
		"SELECT	id, membership_id AS lid
		FROM {$table}
		WHERE user_id = $user_id
		ORDER BY id DESC
		LIMIT 1"
	);
	if($res){
		return $res->lid;
	}else{
		return false;
	}

}

function get_last_level_id($user_id){
	global $wpdb;
	$table = $wpdb->prefix . 'pmpro_memberships_users';
	$res = $wpdb->get_row(
		"SELECT	id, membership_id AS lid
		FROM {$table}
		WHERE user_id = $user_id AND status = 'expired'
		ORDER BY id DESC
		LIMIT 1"
	);
	if($res){
		return $res->lid;
	}else{
		return false;
	}

}


function paces_get_price_for_pmpro_level( $id){
	global $wpdb;
	$table = $wpdb->prefix . 'pmpro_membership_levels';

	$level = $wpdb->get_row( $wpdb->prepare( "
												SELECT * FROM $table
												WHERE id = %d LIMIT 1",
												$id
											),
												OBJECT
											);
	if( !empty( $level) ){
		return $level->initial_payment;
	}else{
		return false;
	}
}
// add_action( 'admin_footer', 'custom_pmpro_order_create_hack' );
// function to create order for renewal by stripe card
function custom_pmpro_order_create_hack($user_id_x){
	/*$user_id_x = '9';*/
	global $post, $gateway, $wpdb, $besecure, $discount_code, $discount_code_id, $pmpro_level, $pmpro_levels, $pmpro_msg, $pmpro_msgt, $pmpro_review, $skip_account_fields, $pmpro_paypal_token, $pmpro_show_discount_code, $pmpro_error_fields, $pmpro_required_billing_fields, $pmpro_required_user_fields, $wp_version, $current_user, $pmpro_requirebilling, $tospage, $username, $password, $password2, $bfirstname, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bcountry, $bphone, $bemail, $bconfirmemail, $CardType, $AccountNumber, $ExpirationMonth, $ExpirationYear, $pmpro_states, $recaptcha, $recaptcha_privatekey, $CVV;

	$level_id_x = '';
	if(empty($user_id_x)) return array('status'=>'fail','code'=>404);
	$mem_level = pmpro_getMembershipLevelForUser( $user_id_x, true ); 
	// print_r($mem_level);
	if($mem_level){
		$level_id_x = $mem_level->id;
	}
	if(empty($level_id_x)){
		$level_id_x = get_last_level_id($user_id_x);
		if(empty($level_id_x)){
			$result = array('status'=>'fail','code'=>403);
			return $result;
		}
	}
	// return $mem_level;
	$pmpro_level_x = new PMPro_Membership_Level( $level_id_x );
	$bemail = get_user_meta( $user_id_x, 'pmpro_bemail', true );
	$doit = new PMProGateway_stripe();
	$user_data = get_user_by( 'ID', $user_id_x );
	$stripe_cid = '';
	$payment_method_id_x = '';
	if(get_user_meta( $user_id_x, 'pmpro_stripe_customerid', true )){
		$stripe_cid = get_user_meta( $user_id_x, 'pmpro_stripe_customerid', true );

		$payment_method_id_x = $doit->get_payment_method_id_by_custom_id( $stripe_cid );
		$payment_method_id_x = 'pm_card_chargeDeclinedExpiredCard';
	}
	// // return;
	$morder                   = new MemberOrder();
	$morder->membership_id    = $pmpro_level_x->id;
	$morder->membership_level = $pmpro_level_x->id;
	$morder->membership_name  = $pmpro_level_x->name;
	$morder->discount_code    = $discount_code;
	$morder->InitialPayment   = pmpro_round_price( $pmpro_level_x->initial_payment );
	$morder->PaymentAmount    = pmpro_round_price( $pmpro_level_x->billing_amount );
	$morder->ProfileStartDate = date_i18n( "Y-m-d", current_time( "timestamp" ) ) . "T0:0:0";
	$morder->BillingPeriod    = $pmpro_level_x->cycle_period;
	$morder->BillingFrequency = $pmpro_level_x->cycle_number;
	$morder->code = $morder->getRandomCode();
	if ( $pmpro_level_x->billing_limit ) {
		$morder->TotalBillingCycles = $pmpro_level_x->billing_limit;
	}
	if ( pmpro_isLevelTrial( $pmpro_level_x ) ) {
		$morder->TrialBillingPeriod    = $pmpro_level_x->cycle_period;
		$morder->TrialBillingFrequency = $pmpro_level_x->cycle_number;
		$morder->TrialBillingCycles    = $pmpro_level_x->trial_limit;
		$morder->TrialAmount           = pmpro_round_price( $pmpro_level_x->trial_amount );
	}

	// Not saving email in order table, but the sites need it.
	$morder->Email = $user_data->user_email;
	
	// Save the user ID if logged in.
	if ( $current_user->ID ) {
		$morder->user_id = $user_id_x;
	}
	
	// Sometimes we need these split up.
	$morder->FirstName = $user_data->first_name;
	$morder->LastName  = $user_data->last_name;
	
	// Set other values.
	$morder->billing          = new stdClass();
	$morder->billing->name    = $user_data->first_name . " " . $user_data->last_name;
	$morder->setGateway();
	
	// // Set up level var.
	// $morder->getMembershipLevelAtCheckout();
	
	// Set tax.
	$initial_tax = $morder->getTaxForPrice( $morder->InitialPayment );
	
	// Set amounts.
	$morder->initial_amount = pmpro_round_price((float)$morder->InitialPayment + (float)$initial_tax);
	
	// Filter for order, since v1.8
	// $morder = apply_filters( 'pmpro_checkout_order', $morder );

	$morder->payment_method_id = $payment_method_id_x;

	$morder->done_by = 'admin';
	
	// get_payment_method_id_by_custom_id();
	$paydoit = $doit->process_charges($morder);
	if($morder->error_type){
		if( $morder->error_type == 'Your card has expired.' ){
			send_card_update_mail($user_data, $level_id_x);
			update_user_meta( $user_id_x, 'membership_card_state', 'expired' );
		}else{
			send_card_update_mail($user_data, $level_id_x);
			update_user_meta( $user_id_x, 'membership_card_state', 'expired' );			
		}
		$result = array('status'=>'fail','code'=>302);
		return $result;
	}else{
		update_user_meta( $user_id_x, 'membership_card_state', '' );
		delete_user_meta( $user_id_x, 'membership_card_state' );
	}

	$startdate = current_time( "mysql" );
	$startdate = apply_filters( "pmpro_checkout_start_date", $startdate, $user_id_x, $pmpro_level_x );

	if ( ! empty( $pmpro_level_x->expiration_number ) ) {
		$enddate =  date( "Y-m-d H:i:s", strtotime( "+ " . $pmpro_level_x->expiration_number . " " . $pmpro_level_x->expiration_period, current_time( "timestamp" ) ) );
	} else {
		$enddate = "NULL";
	}

	$enddate = apply_filters( "pmpro_checkout_end_date", $enddate, $user_id_x, $pmpro_level_x, $startdate );

	$custom_level = array(
			'user_id'         => $user_id_x,
			'membership_id'   => $pmpro_level_x->id,
			'code_id'         => '',
			'initial_payment' => pmpro_round_price( $pmpro_level_x->initial_payment ),
			'billing_amount'  => pmpro_round_price( $pmpro_level_x->billing_amount ),
			'cycle_number'    => $pmpro_level_x->cycle_number,
			'cycle_period'    => $pmpro_level_x->cycle_period,
			'billing_limit'   => $pmpro_level_x->billing_limit,
			'trial_amount'    => pmpro_round_price( $pmpro_level_x->trial_amount ),
			'trial_limit'     => $pmpro_level_x->trial_limit,
			'startdate'       => $startdate,
			'enddate'         => $enddate
		);

	if ( pmpro_changeMembershipLevel( $custom_level, $user_id_x, 'changed' ) ) {
		//we're good
		//blank order for free levels
		if ( empty( $morder ) ) {
			$morder                 = new MemberOrder();
			$morder->InitialPayment = 0;
			$morder->Email          = $bemail;
			$morder->gateway        = 'free';
			$morder->status			= 'success';
			$morder = apply_filters( "pmpro_checkout_order_free", $morder );
		}

		//add an item to the history table, cancel old subscriptions
		if ( ! empty( $morder ) ) {
			$morder->user_id       = $user_id_x;
			$morder->membership_id = $pmpro_level_x->id;
			$morder->saveOrder();
		}

		//show the confirmation
		$ordersaved = true;

		do_action( "pmpro_after_checkout", $user_id_x, $morder );
		$sendemails = apply_filters( "pmpro_send_checkout_emails", true);

		if($sendemails) { // Send the emails only if the flag is set to true

			//setup some values for the emails
			if ( ! empty( $morder ) ) {
				$invoice = new MemberOrder( $morder->id );
			} else {
				$invoice = null;
			}
			$user_data->membership_level = $pmpro_level_x; //make sure they have the right level info

			//send email to member
			$pmproemail = new PMProEmail();
			$pmproemail->sendCheckoutEmail( $user_data, $invoice );

			//send email to admin
			$pmproemail = new PMProEmail();
			$pmproemail->sendCheckoutAdminEmail( $user_data, $invoice );
		}

	}

	$result = array('status'=>'success','code'=>201);
	return $result;
}

// function to create order for renewal Check method
function custom_pmpro_order_create_hack_by_check($user_id_x){
	global $post, $gateway, $wpdb, $besecure, $discount_code, $discount_code_id, $pmpro_level, $pmpro_levels, $pmpro_msg, $pmpro_msgt, $pmpro_review, $skip_account_fields, $pmpro_paypal_token, $pmpro_show_discount_code, $pmpro_error_fields, $pmpro_required_billing_fields, $pmpro_required_user_fields, $wp_version, $current_user, $pmpro_requirebilling, $tospage, $username, $password, $password2, $bfirstname, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bcountry, $bphone, $bemail, $bconfirmemail, $CardType, $AccountNumber, $ExpirationMonth, $ExpirationYear, $pmpro_states, $recaptcha, $recaptcha_privatekey, $CVV;

	$level_id_x = '';
	// $user_id_x = '2';
	if(empty($user_id_x)) return array('status'=>'fail','code'=>404);
	$mem_level = pmpro_getMembershipLevelForUser( $user_id_x, true ); 
	// print_r($mem_level);
	if($mem_level){
		$level_id_x = $mem_level->id;
	}
	if(empty($level_id_x)){
		$level_id_x = get_last_level_id($user_id_x);
		if(empty($level_id_x)){
			$result = array('status'=>'fail','code'=>403);
			return $result;
		}
	}
	// return $mem_level;
	$pmpro_level_x = new PMPro_Membership_Level( $level_id_x );
	$bemail = get_user_meta( $user_id_x, 'pmpro_bemail', true );
	$doit = new PMProGateway('check');
	$user_data = get_user_by( 'ID', $user_id_x );
	
	// // return;
	$morder                   = new MemberOrder();
	$morder->membership_id    = $pmpro_level_x->id;
	$morder->membership_level = $pmpro_level_x->id;
	$morder->membership_name  = $pmpro_level_x->name;
	$morder->discount_code    = $discount_code;
	$morder->InitialPayment   = pmpro_round_price( $pmpro_level_x->initial_payment );
	$morder->PaymentAmount    = pmpro_round_price( $pmpro_level_x->billing_amount );
	$morder->ProfileStartDate = date_i18n( "Y-m-d", current_time( "timestamp" ) ) . "T0:0:0";
	$morder->BillingPeriod    = $pmpro_level_x->cycle_period;
	$morder->BillingFrequency = $pmpro_level_x->cycle_number;
	$morder->payment_type = 'Check';
	if ( $pmpro_level_x->billing_limit ) {
		$morder->TotalBillingCycles = $pmpro_level_x->billing_limit;
	}
	if ( pmpro_isLevelTrial( $pmpro_level_x ) ) {
		$morder->TrialBillingPeriod    = $pmpro_level_x->cycle_period;
		$morder->TrialBillingFrequency = $pmpro_level_x->cycle_number;
		$morder->TrialBillingCycles    = $pmpro_level_x->trial_limit;
		$morder->TrialAmount           = pmpro_round_price( $pmpro_level_x->trial_amount );
	}

	// Not saving email in order table, but the sites need it.
	$morder->Email = $user_data->user_email;
	
	// Save the user ID if logged in.
	if ( $current_user->ID ) {
		$morder->user_id = $user_id_x;
	}
	
	// Sometimes we need these split up.
	$morder->FirstName = $user_data->first_name;
	$morder->LastName  = $user_data->last_name;
	
	// Set other values.
	$morder->billing          = new stdClass();
	$morder->billing->name    = $user_data->first_name . " " . $user_data->last_name;
	$morder->setGateway('check');
	
	// // Set up level var.
	// $morder->getMembershipLevelAtCheckout();
	
	// Set tax.
	$initial_tax = $morder->getTaxForPrice( $morder->InitialPayment );
	
	// Set amounts.
	$morder->initial_amount = pmpro_round_price((float)$morder->InitialPayment + (float)$initial_tax);
	
	// Filter for order, since v1.8
	// $morder = apply_filters( 'pmpro_checkout_order', $morder );

	// $morder->payment_method_id = $payment_method_id_x;

	$morder->done_by = 'admin';
	
	
	// get_payment_method_id_by_custom_id();
	$paydoit = $doit->process($morder);
	
	$startdate = current_time( "mysql" );
	$startdate = apply_filters( "pmpro_checkout_start_date", $startdate, $user_id_x, $pmpro_level_x );
// print_r($pmpro_level_x);
	if ( ! empty( $pmpro_level_x->expiration_number ) ) {
		$enddate =  date( "Y-m-d H:i:s", strtotime( "+ " . $pmpro_level_x->expiration_number . " " . $pmpro_level_x->expiration_period, current_time( "timestamp" ) ) );
	} else {
		$enddate = "NULL";
	}

	$enddate = apply_filters( "pmpro_checkout_end_date", $enddate, $user_id_x, $pmpro_level_x, $startdate );

	$custom_level = array(
			'user_id'         => $user_id_x,
			'membership_id'   => $pmpro_level_x->id,
			'code_id'         => '',
			'initial_payment' => pmpro_round_price( $pmpro_level_x->initial_payment ),
			'billing_amount'  => pmpro_round_price( $pmpro_level_x->billing_amount ),
			'cycle_number'    => $pmpro_level_x->cycle_number,
			'cycle_period'    => $pmpro_level_x->cycle_period,
			'billing_limit'   => $pmpro_level_x->billing_limit,
			'trial_amount'    => pmpro_round_price( $pmpro_level_x->trial_amount ),
			'trial_limit'     => $pmpro_level_x->trial_limit,
			'startdate'       => $startdate,
			'enddate'         => $enddate
		);
// print_r($custom_level);
// die;
	if ( pmpro_changeMembershipLevel( $custom_level, $user_id_x, 'changed' ) ) {
		//we're good
		//blank order for free levels
		if ( empty( $morder ) ) {
			$morder                 = new MemberOrder();
			$morder->InitialPayment = 0;
			$morder->Email          = $bemail;
			$morder->gateway        = 'free';
			$morder->status			= 'success';
			$morder = apply_filters( "pmpro_checkout_order_free", $morder );
		}

		//add an item to the history table, cancel old subscriptions
		if ( ! empty( $morder ) ) {
			$morder->user_id       = $user_id_x;
			$morder->membership_id = $pmpro_level_x->id;
			$morder->saveOrder();
		}

		//show the confirmation
		$ordersaved = true;

		do_action( "pmpro_after_checkout", $user_id_x, $morder );
		$sendemails = apply_filters( "pmpro_send_checkout_emails", true);

		if($sendemails) { // Send the emails only if the flag is set to true

			//setup some values for the emails
			if ( ! empty( $morder ) ) {
				$invoice = new MemberOrder( $morder->id );
			} else {
				$invoice = null;
			}
			$user_data->membership_level = $pmpro_level_x; //make sure they have the right level info

			//send email to member
			$pmproemail = new PMProEmail();
			$pmproemail->sendCheckoutEmail( $user_data, $invoice );

			//send email to admin
			$pmproemail = new PMProEmail();
			$pmproemail->sendCheckoutAdminEmail( $user_data, $invoice );
		}

	}

	$result = array('status'=>'success','code'=>201);
	return $result;
}


add_action( 'admin_head', function(){
	echo '<style>
			.toplevel_page_mailpoet-newsletters .filter-links li:nth-child(2),
			.toplevel_page_mailpoet-newsletters .filter-links li:nth-child(3),
			.toplevel_page_mailpoet-newsletters .filter-links li:nth-child(4) {
				display:none;
			}
		</style>';
} );