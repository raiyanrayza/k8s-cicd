<?php

function wpdocs_selectively_enqueue_admin_script( $hook ) {
    if ( 'memberships_page_pmpro-memberslist' != $hook ) {
        return;
    }
	wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script( 'jquery-ui-dialog' );
	wp_enqueue_style( 'wp-jquery-ui-dialog' );
}
add_action( 'admin_enqueue_scripts', 'wpdocs_selectively_enqueue_admin_script' );

function add_popup_html_in_footer(){
	?>
	<script src="https://js.stripe.com/v3/"></script>
	
	<div id="card-modal" title="Basic dialog" style="display: none;">
		<h3>User Name : <span class="pmc_name"></span></h3>
	  	<div class="form_group_filed">
	    	<div id="card-element" class="field is-empty"></div>
	    </div>
	    <input type="hidden" name="user_id" value="">
	    <input type="hidden" name="token" value="">
	    <button type="button" name="sc_update">Update <span style="display: none;" class="dashicons dashicons-update spin"></span></button>
	</div>
	<script>
		var stripepublicKey = '<?php echo pmpro_getOption( 'stripe_publishablekey' ); ?>';
		( function( $ ){
			$( document ).on( 'click', 'a.card-action-btn', function( e ){
				e.preventDefault();
				var uid = $(this).attr('data-id');
		 		var data = {
		 			'action' : 'paces_get_member_info',
		 			'id' : uid
		 		};
		 		$( this ).find('span').css( 'display', 'inline-block' );
		 		$.post( ajaxurl, data, function( response ){
		 			console.log(response);
		 			if(response != 'fail'){
		 				var res = JSON.parse(response);
		 				$( '#card-modal .pmc_name' ).html(res.name);
		 				$( '#card-modal' ).attr( 'title', res.name + '\'s Card update' );
		 				$( '#card-modal input[name="user_id"]' ).val(res.id);
						$( '#card-modal' ).dialog( { minWidth: 500 } );
		 			}else{
		 				alert('error while getting user details');
		 			}
		 			/*$( e.target ).find('span').css( 'display', 'none' );*/
		 		} );
			} );

			$( "#card-modal" ).on( "dialogclose", function( event, ui ) {
				$( "a.card-action-btn" ).find('span').css( 'display', 'none' );
			} );

		} )( jQuery );


		var stripe = Stripe( stripepublicKey );
    
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

		document.querySelector('button[name="sc_update"]').addEventListener('click', function(e) {
		    
		    e.preventDefault();
		    stripe.createToken(card).then(function(result) {
				// Handle result.error or result.token
				console.log(result);
				if( result.error )
					jQuery( '#card-modal input[name="token"]' ).val('');
				if( result.token ){
					jQuery( '#card-modal input[name="token"]' ).val(result.token.id);
					var data = {
						'action':'paces_update_card_by_token',
						'token' : result.token.id,
						'user_id':jQuery( '#card-modal input[name="user_id"]' ).val()
					};
					jQuery( e.target ).find('span').css( 'display', 'inline-block' );
					
					jQuery.post( ajaxurl, data, function( response ){
						console.log(response);
						var obj = JSON.parse(response);
						if(obj.type == 'fail'){
							alert('Card could not be added. \n Error - '.obj.msg);
						
						}else if(obj.type == 'error_attach'){
							alert('Card could not be added to customer. \n Error - '.obj.msg);	
						
						}else if(obj.type == 'error_default_set'){
							alert('Card could not be set as default to customer. \n Error - '.obj.msg);	
						
						}else{
							alert('Card added to customer successfully');
						}
						jQuery( e.target ).find('span').css( 'display', 'none' );
						jQuery( "#card-modal" ).dialog( "close" );
					} );

				}

			});
		  });
	</script>
	<?php
}
add_action('admin_footer', 'add_popup_html_in_footer');


add_action( 'wp_ajax_paces_update_card_by_token', 'paces_update_card_by_token_action' );
function paces_update_card_by_token_action() {
	
	$pmpro = new PMProGateway_stripe;
	$response = $pmpro->paces_update_card_by_token($_POST);
	echo json_encode( $response );
	wp_die();
}

add_action( 'wp_ajax_paces_get_member_info', 'paces_get_member_info_action' );
function paces_get_member_info_action() {
	$user_id = intval($_POST['id']);
	if(empty($user_id)) die('fail');
	$user = get_user_by( 'ID', $user_id );
	if( $user ){
		$stripe_cid = get_user_meta( $user->ID, 'pmpro_stripe_customerid', true );
		if( $stripe_cid )
			echo json_encode( array('email'=>$user->user_email, 'name'=>$user->user_login, 'id'=>$user->ID ) );
		else
			echo 'fail';
	}else{
		echo 'fail';
	}
	wp_die();
}
