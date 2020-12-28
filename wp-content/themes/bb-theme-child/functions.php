<?php
@ini_set( 'upload_max_size' , '2564M' );
@ini_set( 'post_max_size', '2564M');
// Defines
define( 'FL_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'FL_CHILD_THEME_URL', get_stylesheet_directory_uri() );


function remove_update_notifications( $value ) {
	if ( isset( $value ) && is_object( $value ) ) {
	    //unset( $value->response[ 'hello.php' ] );
	    unset( $value->response[ 'mailpoet/mailpoet.php' ] );
	    unset( $value->response[ 'bbpress/bbpress.php' ] );
	    unset( $value->response[ 'us-map/us-map.php' ] );
	    unset( $value->response[ 'pmpro-pay-by-check-dev/pmpro-pay-by-check.php' ] );
	    unset( $value->response[ 'paid-memberships-pro/paid-memberships-pro.php' ] );
	}
	return $value;
}
add_filter( 'site_transient_update_plugins', 'remove_update_notifications' );

// Classes
require_once 'classes/class-fl-child-theme.php';

require_once 'app/stripe/vendor/autoload.php';
require_once 'app/donate.php';
require_once 'app/refund-membership-payment.php';

// Actions
add_action( 'wp_enqueue_scripts', 'FLChildTheme::enqueue_scripts', 1000 );

// add admin style and script
add_action( 'admin_enqueue_scripts', 'paces_admin_scripts' );
function paces_admin_scripts() {
	wp_enqueue_style( 'padmin-custom-style', get_stylesheet_directory_uri() . '/css/admin-custom.css');
	wp_enqueue_script( 'padmin-custom-script', get_stylesheet_directory_uri() . '/js/admin-custom.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'pmpro-custom-script', get_stylesheet_directory_uri() . '/js/pmpro-custom-script.js', array( 'jquery' ), '', true );
}

// include custom files 
require_once 'included_files.php';
