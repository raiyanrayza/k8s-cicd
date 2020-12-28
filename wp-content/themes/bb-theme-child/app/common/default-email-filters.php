<?php
// /bb-theme-child/app/common/default-email-filters.php 
function paces_def_get_heading_cell($heading_text){
	$heading_html = $heading_text;
	if( get_field( 'basic_template_in_parts', 'option' ) ){
		$template_parts = get_field( 'basic_template_in_parts', 'option' );

		$heading_html = $template_parts['heading'];
		
		$data = array( 'heading'=>$heading_text );
		
		$heading_html = fetch_replace_code_data( $heading_html, $data );
	}
	return $heading_html;
}

function paces_def_get_mail_header(){
	$html = ''; 
	if( get_field( 'basic_template_in_parts', 'option' ) ){
		$template_parts = get_field( 'basic_template_in_parts', 'option' );
		
		$html = $template_parts['header'];

  		$html = apply_filters( 'replace_paces_site_url', $html );
	}
	return $html;
}

function paces_def_get_mail_footer(){
	$html = '';
	if( get_field( 'basic_template_in_parts', 'option' ) ){
		$template_parts = get_field( 'basic_template_in_parts', 'option' );

		$html = $template_parts['footer'];
		
		$html = apply_filters( 'replace_paces_site_url', $html );
	}
	return $html;
}

function paces_def_get_full_mail_blank_template(){
	$html = '';
	if( get_field( 'basic_template_full', 'option' ) ){
		$template_parts = get_field( 'basic_template_full', 'option' );

		$html = $template_parts['place_full_template_html_here'];
		
		$html = apply_filters( 'replace_paces_site_url', $html );
	}
	return $html;
}


add_filter( 'retrieve_password_message', 'paces_udpate_retrieve_password_message', 99, 4 );
function paces_udpate_retrieve_password_message( $message, $key, $user_login, $user_data ){
	$full_html = paces_def_get_full_mail_blank_template();

	$data = array( 'mail_body'=>$message );

	$message = fetch_replace_code_data( $full_html, $data );
	// $message = paces_def_get_mail_header().$message.paces_def_get_mail_footer();
	return $message;
}


add_filter( 'retrieve_password_title', 'paces_udpate_retrieve_password_title' );
function paces_udpate_retrieve_password_title( $title ){
    $title = __( 'Password reset for PACES' );
    return $title;
}