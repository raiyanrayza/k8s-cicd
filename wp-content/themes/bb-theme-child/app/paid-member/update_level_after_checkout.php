<?php
/*
* After payment change membership level back to basic/free for unapproved user/members
*/
add_action( 'pmpro_confirmation_message', 'update_membership_level_back_to_basic', 10, 2 );
function update_membership_level_back_to_basic( $confirmation_message, $pmpro_invoice ){
	$user_id = $pmpro_invoice->user->ID;
	$paid_for_level = $pmpro_invoice->membership_level->id;
	$send_notify_to_admin = false;
	
	$approved_check = intval( get_user_meta($user_id,'pay_approved_by_admin',true) );
	if( $approved_check ){
		return $confirmation_message;
	}else if( get_user_meta($user_id,'first_payment',true) == 'declined' && get_user_meta($user_id,'refund_done',true) == 'true' ){
		
		if(pmpro_changeMembershipLevel(1, $user_id)){
			update_user_meta( $user_id, 'paid_for_level', $paid_for_level );
			update_user_meta( $user_id, 'first_payment', 'true' );
			update_user_meta( $user_id, 'pay_approved_by_admin', '0' );
	    }
	    $confirmation_message = '<div class="custom_confirm"><p><span>Thank you for applying as a member for PACE community, your application is in process and will be updated in 24 hours. .If in case your account is rejected you will get a refund in 48 hours.</span></p><p>For more information contact <a href="mailto:support@pacesep.org">support@pacesep.org</a></p></div>';

	    $send_notify_to_admin = true;

	}else if( !get_user_meta( $user_id, 'first_payment', true ) ){
		if(pmpro_changeMembershipLevel(1, $user_id)){
			update_user_meta( $user_id, 'paid_for_level', $paid_for_level );
			update_user_meta( $user_id, 'first_payment', 'true' );
			update_user_meta( $user_id, 'pay_approved_by_admin', '0' );
	        //email to admin
			// $pmproemail = new PMProEmail();
			// $pmproemail->sendAdminChangeAdminEmail(get_userdata($user_id));

			//email to member
			// $pmproemail = new PMProEmail();
			// $pmproemail->sendAdminChangeEmail(get_userdata($user_id));
	    }
	    $send_notify_to_admin = true;
	    // $confirmation_message = 'Thank you for payment. You will be update when your membership got approval.';
	    $confirmation_message = '<div class="custom_confirm"><p><span>Thank you for applying as a member for PACE community, your application is in process and will be updated in 24 hours. .If in case your account is rejected you will get a refund in 48 hours.</span></p><p>For more information contact <a href="mailto:support@pacesep.org">support@pacesep.org</a></p></div>';
	    
	}
	if( $send_notify_to_admin && !empty( $pmpro_invoice->user ) ){
		send_new_paid_member_request_details_to_admin( $pmpro_invoice->user );	
	}
    return $confirmation_message;
}

// change the content message for logged in paid members but not approved.

add_filter( 'pmpro_non_member_text_filter', 'update_restrict_content_messages', 10, 2 );
function update_restrict_content_messages( $message ){
	if( is_user_logged_in() ){
		$user = wp_get_current_user();
		$user_id = $user->ID;
		if( get_user_meta( $user_id, 'first_payment', true ) == 'true' && get_user_meta( $user_id, 'pay_approved_by_admin', true ) == '0' ){
			$message = '<div class="members_only-notice-wrap paces_custom-notice"><div class="members_only-notice"><p>Your application is in process and will be updated in 24 hours.</p> <p>If in case your account is rejected you will get a refund in 48 hours.</p><p>For more information contact <a href="mailto:support@pacesep.org">support@pacesep.org</a></p></div></div>';
		}
	}

    return $message;
}