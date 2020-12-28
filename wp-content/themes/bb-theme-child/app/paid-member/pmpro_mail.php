<?php

function send_card_update_mail( $user, $lid ){
	$to = $user->user_email;
	$subject = '';
	$body = '';

	if( get_field('expiry_card_mail_template', 'option') ){

		$content = get_field('expiry_card_mail_template', 'option');
		$subject = $content['subject'];
		$body = get_expiry_card_mail_content();

		$data = array('user_name'=> $user->first_name, 'user_link'=>site_url( '/membership-account/membership-checkout/?level='.$lid ));
		$body = fetch_replace_code_data( $body, $data );

	}else{

		$subject = 'Your card has been expired.';
		$body = 'Hi <br> Your card has been expired please update your card by paying for your membership amount. please click on this link'.site_url( '/membership-account/membership-checkout/?level='.$lid );

	}
	$headers = ['Content-Type: text/html; charset=UTF-8'];
	
	if( wp_mail( $to, $subject, $body, $headers ) )
		return true;
	else
		return false;
}

function send_upcoming_payment_invoice_mail( $user, $lid ){
	$to = $user->user_email;
	$subject = '';
	$body = '';
	$amount = '';
	if( paces_get_price_for_pmpro_level( $lid ) ){
		$amount = paces_filter_price_text( paces_get_price_for_pmpro_level( $lid ) );
	}

	if( get_field('manual_invoice_to_member_mail', 'option') ){

		$content = get_field('manual_invoice_to_member_mail', 'option');
		$subject = $content['subject'];
		$body = get_send_invoice_mail_content();

		$data = array(
				'user_name' => $user->first_name,
				'user_link' =>site_url( '/membership-account/membership-checkout/?level='.$lid ),
				'amount_to_pay' => $amount
			);
		$body = fetch_replace_code_data( $body, $data );

	}else{

		$subject = 'Your card has been expired.';
		$body = 'Dear Member, <br> Your paces membership will going to expire soon please pay the due amount of $ '.$amount.'. please click on this link'.site_url( '/membership-account/membership-checkout/?level='.$lid );

	}
	$headers = ['Content-Type: text/html; charset=UTF-8'];
	
	if( wp_mail( $to, $subject, $body, $headers ) )
		return true;
	else
		return false;
}

function send_new_paid_member_request_details_to_admin	( $user ){
	include_once( FL_CHILD_THEME_DIR . '/app/common/user_meta_keys.php' );
	$to = get_field('to_email', 'option');
	$subject = '';
	$body = '';
	
	$paid_for_level = get_user_meta( $user->ID, 'paid_for_level', true );
	$level = pmpro_getLevel( $paid_for_level );

	$user_data = paces_get_users_all_details($user->ID);
	$user_meta_keys = get_user_meta_profile_keys();
	$checkbox_value_keys = array('pacesInterests','relationshipIndustry','academicRank','researchAreas');
	
	if( get_field('new_paid_member', 'option') ){

		$content = get_field('new_paid_member', 'option');
		$subject = $content['subject'];

		$body = apply_filters( 'replace_paces_site_url', $content['content'] );

		$add_data = '<p><strong>Username</strong> : '.$user->user_login.'<br>
				<strong>Email</strong> : '.$user->user_email.'</p>';
		if( $level ){
			$add_data .= '<p><strong>Request Membership</strong> : '.$level->name.'</p>';
		}
			if( $user_meta_keys ){
				foreach ( $user_meta_keys as $key => $value ) {
					if(!empty($user_data[$key][0]) && !in_array($key, $checkbox_value_keys) )
						$add_data .= '<strong>'.$value.'</strong> : '.$user_data[$key][0].'<br>';
					if(!empty($user_data[$key][0]) && in_array($key, $checkbox_value_keys) ){
						$add_data .= '<strong>'.$value.'</strong> : ';
						$user_check_data = get_user_meta( $user->ID, $key, true );
						if($user_check_data){
							$add_data .= implode(", ",map_user_profile_checkbox_entries($user_check_data, $key));
						}
						$add_data .= '<br>';
					}
				}
			}
		$data = array(
				'user_data' => $add_data
			);
		$body = fetch_replace_code_data( $body, $data );

	}else{

		

		$subject = 'Hi, Admin New Member Joins the Paid Plan';
		$body = '<h3>Hi Admin,</h3>
				<p>New Paid Member request has been come followings are the user\'s details.</p>
				<p><strong>Username</strong> : '.$user->user_login.'<p>
				<p><strong>Email</strong> : '.$user->user_email.'<p>';
			if( $user_meta_keys ){
				foreach ( $user_meta_keys as $key => $value ) {
					if(!empty($user_data[$key][0]) && !in_array($key, $checkbox_value_keys) )
						$body .= '<p><strong>'.$value.'</strong> : '.$user_data[$key][0].'<p>';
					if(!empty($user_data[$key][0]) && in_array($key, $checkbox_value_keys) ){
						$body .= '<p><strong>'.$value.'</strong> : ';
						$user_check_data = get_user_meta( $user->ID, $key, true );
						if($user_check_data){
							$body .= implode(", ",map_user_profile_checkbox_entries($user_check_data, $key));
						}
						$body .= '</p>';
					}
				}
			}

	}
	$headers = ['Content-Type: text/html; charset=UTF-8'];

	if( wp_mail( $to, $subject, $body, $headers ) )
		return true;
	else
		return false;
}


add_filter( 'pmpro_non_member_text_filter', 'paces_update_pmpro_non_member_text_filter', 10, 1 );
function paces_update_pmpro_non_member_text_filter($msg){
	global $post, $current_user;
	$order = new MemberOrder();
	$order->getLastMemberOrder( $current_user->ID, array( 'cancelled', 'expired', 'admin_cancelled' ) );

	if( get_user_meta( $current_user->ID, 'pay_approved_by_admin', true ) == '1' || get_user_meta( $current_user->ID, 'pay_approved_by_admin', true ) == 1 ){

		if ( isset( $order->membership_id ) && ! empty( $order->membership_id ) && empty( $level->id ) ) {
			$level = pmpro_getLevel( $order->membership_id );
		}

		if ( ! empty( $level ) && ! empty( $level->allow_signups ) ) {
			$url = pmpro_url( 'checkout', '?level=' . $level->id );
			
			return '<div class="members_only-notice-wrap"><div class="members_only-notice">Your membership is not active.</div><div class="members_only-buttons"><a href="'.$url.'">Renew Now</a></div></div>';
		}else{
			return $msg;
		}
	}
	return $msg;

}


