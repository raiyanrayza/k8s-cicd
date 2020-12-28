<?php

function send_approve_email_to_user( $user ){
	$to = $user->user_email;
	$subject = '';
	$body = '';

	if( get_field('approve_member_mail_template', 'option') ){

		$content = get_field('approve_member_mail_template', 'option');
		$subject = $content['subject'];
		$body = get_approve_member_mail_content();

		$data = array('user_name'=> $user->first_name, 'user_link'=>site_url( '/login/' ));
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


/*
* Function to get content of send approve email content
*/

function get_approve_member_mail_content(){
  $mail_content = get_field('approve_member_mail_template', 'option');
  return apply_filters( 'replace_paces_site_url', $mail_content['content'] );
}
