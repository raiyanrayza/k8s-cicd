<?php
/*
	Adding First and Last Name to Checkout Form
*/

//add the fields to the form 
function my_pmpro_checkout_after_password() 
{
	if(!empty($_REQUEST['ep_special']))
		$ep_special = $_REQUEST['ep_special'];
	else
		$ep_special = "";
	
?>
	<div class="pmpro_checkout-field pmpro_checkout-field-bemail pmpro_paces-custom--input">
		<label for="ep_special">
			<input id="ep_special" name="ep_special" type="checkbox" class="input"value="true"<?php if($ep_special == 'true') echo "checked"; ?> />
			I'm, an EP Specialist
		</label>
	</div>
<?php
}
add_action('pmpro_checkout_after_email', 'my_pmpro_checkout_after_password');

//update the user after checkout
function my_update_first_and_last_name_after_checkout($user_id)
{
	if(isset($_REQUEST['ep_special']))
	{
		$ep_special = $_REQUEST['ep_special'];
	}
	elseif(isset($_SESSION['ep_special']))
	{
		//maybe in sessions?
		$ep_special = $_SESSION['ep_special'];
		
		//unset
		unset($_SESSION['ep_special']);
	}
	
	if(isset($ep_special))	
		update_user_meta($user_id, "ep_special", $ep_special);
}
add_action('pmpro_after_checkout', 'my_update_first_and_last_name_after_checkout');

//require the fields
function my_pmpro_registration_checks()
{
	global $pmpro_msg, $pmpro_msgt, $current_user;
	$ep_special = $_REQUEST['ep_special'];
	
	if($ep_special && $lastname && $companyname && $repname || $current_user->ID)
	{
		//all good
		return true;
	}
	else
	{
		$pmpro_msg = "The ep specialist field is required.";
		$pmpro_msgt = "pmpro_error";
		return false;
	}
}
// add_filter("pmpro_registration_checks", "my_pmpro_registration_checks");

function paces_show_extra_profile_fields($user)
{
	$ep_special = "";
	if(get_user_meta($user->ID, 'ep_special', true)){
		$ep_special = get_user_meta($user->ID, 'ep_special', true);
	}
	?>
		<h3>User is EP Specialist</h3>

		<table class="form-table">

			<tr>
				<th><label for="ep_special">I'm an EP Specialist</label></th>

				<td>
					<input id="ep_special" name="ep_special" type="checkbox" class="input"value="true"<?php if($ep_special == 'true') echo "checked"; ?> />	
				</td>
			</tr>

		</table>
	<?php
}
add_action( 'show_user_profile', 'paces_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'paces_show_extra_profile_fields' );


function paces_my_save_extra_profile_fields( $user_id ) 
{

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	if(isset($_POST['ep_special'])){
		update_user_meta( $user_id, 'ep_special', $_POST['ep_special'] );

		$ep_post_id = get_user_meta( $user_id, 'ep_special_post_id', true );

		if(!empty($ep_post_id)){
			if( get_post_status($ep_post_id) == 'draft'){
				$post = array( 'ID' => $ep_post_id, 'post_status' => 'publish' );
				wp_update_post($post);	
			}
			if(isset($_POST['first_name'])){
				update_field('first_name', sanitize_text_field($_POST['first_name']), $ep_post_id);
			}
			if(isset($_POST['last_name'])){
				update_field('last_name', sanitize_text_field($_POST['last_name']), $ep_post_id);
			}		
		}
	}else{
		update_user_meta( $user_id, 'ep_special', '' );
		$ep_post_id = get_user_meta( $user_id, 'ep_special_post_id', true );
		if(!empty($ep_post_id)){
			$post = array( 'ID' => $ep_post_id, 'post_status' => 'draft' );
			wp_update_post($post);
		}

	}

}
add_action( 'personal_options_update', 'paces_my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'paces_my_save_extra_profile_fields' );


// Enter user in EP Specialist custom posttype if checked 

add_action( 'user_register', 'add_in_cpt_registration_save', 10, 1 );
 
function add_in_cpt_registration_save( $user_id ) {
	$username = '';
 	if($user_id){
 		$user = get_user_by( 'ID', $user_id );
 		$username = $user->user_login;
 		update_user_meta( $user_id, 'approved_by_admin', '0' );

 		/* assign free membershiop to user */
 		if(pmpro_changeMembershipLevel(1, $user_id)){
            //email to admin
			$pmproemail = new PMProEmail();
			$pmproemail->sendAdminChangeAdminEmail(get_userdata($user_id));

			//email to member
			$pmproemail = new PMProEmail();
			// $pmproemail->sendAdminChangeEmail(get_userdata($user_id));
        }
 	}
    if ( isset( $_POST['ep_special'] ) ){
    	if( $_POST['ep_special'] == 'true' && !get_user_meta( $user_id, 'ep_special_post_id', true ) ){

    		$epid_title = $user->first_name. ' '.$user->last_name;

			if( empty( $epid_title ) ){
				$epid_title = $username;
			}

    		$my_post = array(
			  'post_title'    => wp_strip_all_tags( $epid_title ),
			  'post_type' 	=> 'ep-specialist'
			);
			 
			// Insert the post into the database
			$pid = wp_insert_post( $my_post );	
			if(!is_wp_error($pid)){
			  // post saved
				update_post_meta( $pid, 'user_id', $user_id );
				update_field('display_name', sanitize_text_field($username), $pid);
				update_user_meta( $user_id, 'ep_special_post_id', $pid );
				update_user_meta( $user_id, 'ep_special', $_POST['ep_special'] );
			}
    	}
    } 
    paces_mailPoet_subscribe_to_list( $user_id, array( '8','10' ) ); 
}


