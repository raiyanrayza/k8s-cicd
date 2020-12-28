<?php


/*
 * Shortcode for Signup Registration form
 * 
**/

function paces_registration_form_shortcode() {
  include_once( FL_CHILD_THEME_DIR . '/app/common/country-list.php' );
  include_once( FL_CHILD_THEME_DIR . '/app/common/state-list.php' );
  $country_list = paces_get_country_list();
  $state_list = paces_get_states_list();
  ob_start();
  ?>
  <script src="https://www.google.com/recaptcha/api.js"></script>
  <section class="my-login-section my-signup-sec">
    <div class="home_content">
          <form method="POST" id="paces_registration_form" name="paces_registration_form">
            <div class="col-sm-12">
              <div class="dfr__body dfr__body_Paces">
                <!-- <h3> <span class="pmpro_checkout-h3-name">Register here</span></h3> -->
                <div class="dfr__bodyfields">
                  <div class="dfr_form">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="inputSalutation">Salutation</label>
                          <select class="form-control" id="inputSalutation" name="inputSalutation">
                            <option value="">Select One</option>
                            <option value="Dr.">Dr.</option>
                            <option value="M">M</option>
                            <option value="Miss">Miss</option>
                            <option value="Mr.">Mr.</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Ms.">Ms.</option>
                            <option value="Prof.">Prof.</option>
                            <option value="Rev">Rev</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="inputFirstname">First name*</label>
                          <input type="text" class="form-control" id="inputFirstname" name="inputFirstname" placeholder="First name" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="inputMiddlename">Middle Name</label>
                          <input type="text" class="form-control" id="inputMiddlename" name="inputMiddlename" placeholder="Middle name">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="inputLastname">Last Name / Surname*</label>
                          <input type="text" class="form-control" id="inputLastname" name="inputLastname" placeholder="Last name" required>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="inputSuffix">Suffix</label>
                          <select class="form-control" id="inputSuffix" name="inputSuffix">
                            <option value="">Select One</option>
                            <option value="II">II</option>
                            <option value="Sr.">Senior</option>
                            <option value="Jr.">Junior</option>
                            <option value="III">III</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="inputEmployer">Employer</label>
                          <input type="text" class="form-control" id="inputEmployer" name="inputEmployer" placeholder="Employer">
                        </div>
                      </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputDegree">Degree(s)</label>
                            <input type="text" class="form-control" id="inputDegree" name="inputDegree" placeholder="Degree(s)">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputDepartment">Department</label>
                            <input type="text" class="form-control" id="inputDepartment" name="inputDepartment" placeholder="Department">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="dfr__bodyfields">
                    <div class="dfr_form">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputAddress1">Address 1*</label>
                            <input type="text" class="form-control" id="inputAddress1" name="inputAddress1" placeholder="Address 1" required>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputAddress2">Address 2</label>
                            <input type="text" class="form-control" id="inputAddress2" name="inputAddress2" placeholder="Address 2">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputAddress3">Address 3</label>
                            <input type="text" class="form-control" id="inputAddress3" name="inputAddress3" placeholder="Address 3">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputCity">City*</label>
                            <input type="text" class="form-control" id="inputCity" name="inputCity" placeholder="City" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputState">State/Province</label>
                            <select class="form-control" id="inputState" name="inputState">
                              <option value="">Any</option>
                              <?php
                              if( $state_list ){
                                foreach ($state_list as $code => $state) {
                                  echo '<option value="'. $code .'">'. $state .'</option>';
                                }
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputPostalCode">Postal Code</label>
                            <input type="text" class="form-control" id="inputPostalCode" name="inputPostalCode" placeholder="Postal Code">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputCountry">Country*</label>
                            <select class="form-control" id="inputCountry" name="inputCountry" required>
                              <option value="">Any</option>
                              <?php 
                              if( $country_list ){
                                foreach ($country_list as $code => $country) {
                                  echo '<option value="'. $code .'">'. $country .'</option>';
                                }
                              }
                              ?>
                              <option value="US">United States of America</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputWorkPhone">Work Phone*</label>
                            <input type="text" class="form-control phoneInputbit" id="inputWorkPhone" name="inputWorkPhone" placeholder="Work Phone" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputEmail">Email Address*</label>
                            <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email Address" required>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputWebsite">Website Address</label>
                            <input type="text" class="form-control" id="inputWebsite" name="inputWebsite" placeholder="Website Address">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="dfr__bodyfields">
                    <div class="dfr_form">
                      
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputUserName">User Name*</label>
                            <input type="text" class="form-control" id="inputUserName" name="inputUserName" placeholder="User Name" required>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputPassword">Password*</label>
                            <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputRePassword">Repeat Password*</label>
                            <input type="password" class="form-control" id="inputRePassword" name="inputRePassword" placeholder="Repeat Password" required>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                            <label for="inputAddressLine1">Twitter Contact</label>
                            <input type="text" class="form-control" id="inputTwitter" name="inputTwitter" placeholder="Twitter Contact">
                          </div>
                        </div>
                      </div>
                      <!-- <div class="row">
                        <div class="col-sm-12">
                          <div class="form-group">
                            <label class="control-label" for="specialist">&nbsp;</label>
                            <span class="gwt-CheckBox">
                              <input value="true" id="ep_special" name="ep_special" tabindex="0" class="avi-fuel-stops-checkbox" type="checkbox">
                              <label for="ep_special" class="avi-fuel-stops-checkbox-label">I'm, an EP Specialist</label>
                            </span> </div>
                          </div>
                        </div> -->
                        <div id="custom-recaptch-wrap" class="row">
                        <div class="col-sm-12">
                          <div class="g-recaptcha" data-sitekey="<?php echo PACES_GOOGLE_RECAPTCHA_SITE_KEY; ?>"></div>
                          </div>
                        </div>
                        <div class="button_process">
                          <?php wp_nonce_field('paces_signup','paces_signup_nonce', true, true ); ?>
                          <input type="hidden" name="action" value="paces_singup_action">
                          <input type="hidden" name="ep_special" value="true">
                          <button type="submit" class="paces_checkout">Join Now <span style="display: none;"><i class="fa fa-circle-notch fa-spin"></i></span></button>
                          <!-- <input type="submit" id="pmpro_btn-submit" class="paces_checkout" value="Submit and Check Out »"> -->
                        </div>
                        <div class="form-group row notification-row" style="display: none;">
                          <div class="col-sm-12 note_msg"><div class="pmpro_message"></div></div>
                        </div>
                      </div>
                    </div>

                    <p class="pmpro_actions_nav">
                      Already a member <a href="<?php echo site_url('login'); ?>">Login Here</a>
                    </p>
                    
                  </div>
                </div>
              </div>
            </form>
      </div>
    </section>
<?php
if( is_user_logged_in() && !current_user_can('administrator') ){
	$redirect_to_s = site_url( 'home-professionals' );
	?>
	<script>
		( function($) {
			window.location.href = '<?php echo $redirect_to_s; ?>';
		})( jQuery );
	</script>
	<?php
}
?>
	
<script>
  /* confirm password */
  ( function($) {
      var password = document.getElementById("inputPassword")
        , confirm_password = document.getElementById("inputRePassword");

      function validatePassword(){
        if(password.value != confirm_password.value) {
          confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
          confirm_password.setCustomValidity('');
        }
      }

      password.onchange = validatePassword;
      confirm_password.onkeyup = validatePassword;

    })( jQuery );

  /* form submit */
	( function( $ ) {
		var regFormId = 'paces_registration_form';
		var res_text = '.notification-row .note_msg';
		var submit_btn = 'button[type="submit"]';

		// Your code goes here
		$('#'+regFormId).submit(function(event){
			event.preventDefault();
			var form = jQuery(this)[0];
	    	var form_data = new FormData(form);
       
	    	$(res_text).find('pmpro_message').removeClass('pmpro_error').removeClass('pmpro_success').removeClass('pmpro_alert').html('');
	    	$('.notification-row').hide();
	    	$(submit_btn).attr('disabled', 'disabled');
	    	$(submit_btn).find('span').css('display', 'inline-block');

			jQuery.ajax({
				url: paces_ajaxurl,
				type: "POST",
				data: form_data,
				contentType: false,
				processData: false,
				success: function (data, status, jqXHR) {
					console.log(status,data,jqXHR);
					
					if( !data.success ){
						/*alert('error '+data.data.error);*/
						$(res_text).find('.pmpro_message').addClass('pmpro_error');
						$(res_text).find('.pmpro_message').html(data.data.error);
					}else {
            if( jqXHR.status == 200 ){
						  $(res_text).find('.pmpro_message').addClass('pmpro_success').html(data.data.success);
              window.location.reload();
            }else{
              $(res_text).find('.pmpro_message').addClass('pmpro_alert').html(data.data.success);
            }
						/*alert(data.data.success);*/
					}
					$('.notification-row').show();
				},
				error: function (jqXHR, status, err) {
					let res = jqXHR.responseJSON;
					alert('Can not complete this action. '+res.data.error);
				},
				complete: function (jqXHR, status) {
					// console.log(status);
					// alert("Local completion callback.");
					$(submit_btn).find('span').hide();
					$(submit_btn).removeAttr('disabled');
          grecaptcha.reset();
				}
			});
		});
	} )( jQuery );
</script>
  
  <?php
  return ob_get_clean();
}
add_shortcode( 'paces_register_form', 'paces_registration_form_shortcode' );



function custom_remove_user( $user_id ) {
    $pid = get_user_meta( $user_id, 'ep_special_post_id', true );
    if($pid)
     	wp_delete_post( $pid, true);
}
add_action( 'delete_user', 'custom_remove_user', 10 );


/**
 * New Member registration
 *
 */
add_action('wp_ajax_paces_singup_action', 'paces_singup_action_callback');
add_action('wp_ajax_nopriv_paces_singup_action', 'paces_singup_action_callback');

function paces_singup_action_callback() {

	// Verify nonce
	if( !isset( $_POST['paces_signup_nonce'] ) || !wp_verify_nonce( $_POST['paces_signup_nonce'], 'paces_signup' ) ){
		wp_send_json_error( array('error'=>'Worng nonce code'), 401 );
		wp_die();
	}

  // Check if reCaptcha is valid
  $recaptcha=$_POST['g-recaptcha-response'];
  if(!empty($recaptcha)){
    $google_url = "https://www.google.com/recaptcha/api/siteverify";
    $secret = PACES_GOOGLE_RECAPTCHA_SECRET_KEY; // Replace your Google Secret Key here
    $ip = $_SERVER['REMOTE_ADDR'];
    $url = $google_url."?secret=".$secret."&response=".$recaptcha."&remoteip=".$ip;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
    $results = curl_exec($curl);
    curl_close($curl);
    $res= json_decode($results, true);
    if(!$res['success']) {
      wp_send_json_error( array('error'=>__('reCAPTCHA invalid') ), 201 );
      wp_die();
    }
  }else {
    wp_send_json_error( array('error'=>__('Please enter reCAPTCHA') ), 201 );
    wp_die();
  }

	// Post values
    $art_uname    = $_POST['inputUserName'];
    $email    = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];
    $fname    = $_POST['inputFirstname'];
    $lname    = $_POST['inputLastname'];

    $inputSalutation  = $_POST['inputSalutation'];
    $inputMiddlename    = $_POST['inputMiddlename'];
    $inputSuffix = $_POST['inputSuffix'];

    $inputEmployer = $_POST['inputEmployer'];
    $inputDegree = $_POST['inputDegree'];
    $inputDepartment = $_POST['inputDepartment'];
    
    $inputAddress1 = $_POST['inputAddress1'];
    $inputAddress2 = $_POST['inputAddress2'];
    $inputAddress3 = $_POST['inputAddress3'];
    $inputCity = $_POST['inputCity'];
    $inputState = $_POST['inputState'];
    $inputPostalCode = $_POST['inputPostalCode'];
	 $inputCountry = $_POST['inputCountry'];
    
    $inputWorkPhone = $_POST['inputWorkPhone'];
    $inputWebsite = $_POST['inputWebsite'];
    $inputTwitter = $_POST['inputTwitter'];



    if( empty( $art_uname ) || empty( $email ) || empty( $password ) ){
      wp_send_json_error( array('error'=>'Username or email or password can not be empty'), 201 );
      wp_die();
    }

    if( username_exists( $art_uname ) ){
      wp_send_json_error( array('error'=>'Sorry, that username already exists!'), 201 );
      wp_die();
    }

    if( email_exists( $email ) ){
      wp_send_json_error( array('error'=>'Sorry, that email already exists!'), 201 );
      wp_die();
    }

    $userdata = array(
        'user_login' => $art_uname,
        'user_pass'  => $password,
        'user_email' => $email,
        'first_name' => $fname,
        'last_name' => $lname,
        'role' => 'subscriber'
    );

    $user_id = wp_insert_user( $userdata ) ;

    if( !is_wp_error($user_id) ) {
    	
    	$pid = 0;
    	if ( isset( $_POST['ep_special'] ) && !get_user_meta( $user_id, 'ep_special_post_id', true ) ){
	    	if( $_POST['ep_special'] == 'true' ){

          $epid_title = $$fname. ' '.$lname;

          if( empty( $epid_title ) ){
            $epid_title = $art_uname;
          }

	    		$my_post = array(
  				  'post_title'    => wp_strip_all_tags( $epid_title ),
  				  'post_type' 	=> 'ep-specialist'
  				);
  				// Insert the post into the database
  				$pid = wp_insert_post( $my_post );	
  				if(!is_wp_error($pid)){
  					$pid = $pid;	  	
  				}
	    	}
	    }else if( isset( $_POST['ep_special'] ) && get_user_meta( $user_id, 'ep_special_post_id', true ) ){
	    	$pid = get_user_meta( $user_id, 'ep_special_post_id', true );
	    }

      update_user_meta( $user_id, 'approved_by_admin', '1' );

	    if($pid){
        update_user_meta( $user_id, 'ep_special', 'true' );
	    	update_post_meta( $pid, 'user_id', $user_id );
  			update_user_meta( $user_id, 'ep_special_post_id', $pid );
  			update_field('display_name', sanitize_text_field($art_uname), $pid);
  			update_field('first_name', sanitize_text_field($fname), $pid);
  			update_field('last_name', sanitize_text_field($lname), $pid);
  			update_field('company', sanitize_text_field($inputEmployer), $pid);
  			update_field('work_phone', sanitize_text_field($inputWorkPhone), $pid);
  			update_field('email', sanitize_text_field($email), $pid);
  			update_field('address_line_1', sanitize_text_field($inputAddress1), $pid);
  			update_field('address_line_2', sanitize_text_field($inputAddress2), $pid);
  			update_field('city', sanitize_text_field($inputCity), $pid);
  			update_field('state', sanitize_text_field($inputState), $pid);
  			update_field('postal_code', sanitize_text_field($inputPostalCode), $pid);
  			update_field('country', sanitize_text_field($inputCountry), $pid);
  			update_field('twitter_contact', sanitize_text_field($inputTwitter), $pid);
        update_field('website_address', sanitize_text_field($inputWebsite), $pid);
	    }

      update_user_meta( $user_id, 'salutation', sanitize_text_field($inputSalutation) );
      update_user_meta( $user_id, 'middle_name', sanitize_text_field($inputMiddlename) );
      update_user_meta( $user_id, 'suffix', sanitize_text_field($inputSuffix) );
      update_user_meta( $user_id, 'degree', sanitize_text_field($inputDegree) );
      update_user_meta( $user_id, 'department', sanitize_text_field($inputDepartment) );
      update_user_meta( $user_id, 'website_address', sanitize_text_field($inputWebsite) );
      
      
      update_user_meta( $user_id, 'company', sanitize_text_field($inputEmployer) );
      update_user_meta( $user_id, 'work_phone', sanitize_text_field($inputWorkPhone) );
      update_user_meta( $user_id, 'address_line_1', sanitize_text_field($inputAddress1) );
      update_user_meta( $user_id, 'address_line_2', sanitize_text_field($inputAddress2) );
      update_user_meta( $user_id, 'address_line_3', sanitize_text_field($inputAddress3) );
      update_user_meta( $user_id, 'city', sanitize_text_field($inputCity) );
      update_user_meta( $user_id, 'state', sanitize_text_field($inputState) );
      update_user_meta( $user_id, 'postal_code', sanitize_text_field($inputPostalCode) );
      update_user_meta( $user_id, 'country', sanitize_text_field($inputCountry) );
      update_user_meta( $user_id, 'twitter_contact', sanitize_text_field($inputTwitter) );

      $info = array();
      $info['user_login'] = $email;
      $info['user_password'] = $password;
      $info['remember'] = false;
      $user_signon = wp_signon( $info, false );

      if(!is_wp_error($user_signon)) {
        wp_clear_auth_cookie();

        $user = get_user_by( 'id', $user_id );
        wp_set_current_user( $user_id, $user->user_login );
        wp_set_auth_cookie( $user_id );

        wp_set_current_user ( $user_id );
        wp_set_auth_cookie  ( $user_id );
        do_action( 'wp_login', $user->user_login, $user );

        // paces_mailPoet_subscribe_to_list( $user_id, array( '8','10' ) ); 

        wp_send_json_success( array('success' => 'Signup successfully.' ), 200 );
      } else {
        wp_send_json_success( array('success' => 'Signup successfully, error while log in. '.$user_signon->get_error_message() ), 201 );
      }
	    // wp_send_json_success( array('success' => 'Thanks, your application is under review. You will get notification as it is apprved by admin.' ), 200 );
    	wp_die();
    	
    }else{
      wp_send_json_error( array( 'error'=>$user_id->get_error_message() ), 201 );
      wp_die();
    }
}

add_filter( 'pmpro_login_forms_handler_nav', 'pmpro_login_forms_register_url_replace', 10, 1 );
function pmpro_login_forms_register_url_replace( $links ){
    $links['register'] = sprintf( '<a href="%s">%s</a>', esc_url( site_url( 'join-now' ) ), esc_html__( 'Register', 'paid-memberships-pro' ) );
    return $links;
}

add_filter( 'pmpro_pages_shortcode_levels', 'pmpro_level_list_add_contents', 10, 1 );
function pmpro_level_list_add_contents( $temp_content ){
  $extra_content = get_field( 'membership_offline_form', 'option' );
    $div = '<div class="pre-level-header">
      <h4 class="fl-heading">
        <span class="fl-heading-text">'.$extra_content['heading'].'</span>
      </h4>
      <div class="fl-rich-text">
        '.$extra_content['description'].'
      </div>
    </div>';
    $temp_content = $div.$temp_content;
    return $temp_content;
}


add_filter('manage_users_columns', 'admin_approved_column');
function admin_approved_column($columns) {
  $new = array();
  foreach($columns as $key => $title) {
    if ($key=='username')
      $new['profile_approved'] = 'Profile Approved';
    $new[$key] = $title;
  }
  return $new;
}

// Add “manage_users_custom_column” filter to show data in the newly added column
add_filter( 'manage_users_custom_column', 'paces_show_admin_approved', 10, 3 );
function paces_show_admin_approved( $val, $column_name, $user_id ) {
  // Get user admin color. You can show whatever you want here.
  $usera = get_user_by( 'ID', $user_id );
  $approved_check = intval( get_user_meta($user_id,'pay_approved_by_admin',true) );
  if( in_array( 'subscriber', (array)$usera->roles ) && !in_array( 'administrator', (array)$usera->roles ) ){
    if( $approved_check ){
      $approved_check = '<span class="dashicons dashicons-yes"></span> Approved (Paid)';
    }else if( get_user_meta($user_id,'first_payment',true) == 'declined' && get_user_meta($user_id,'refund_done',true) == 'true' ){
      $approved_check = 'Rejected';
    }else if( get_user_meta($user_id,'first_payment',true) == 'true' ){
      $approved_check = 'Pending';
    }else{
      $approved_check = 'Guest/Not joined';
    }    
  }else{
    $approved_check = '<span class="dashicons dashicons-yes"></span>';
  }

  /*if( empty($approved_check) && in_array( 'subscriber', (array)$usera->roles ) && !in_array( 'administrator', (array)$usera->roles ) ){
    $approved_check = 'Un approved';
  }else{
    $approved_check = '<span class="dashicons dashicons-yes"></span>';
  }*/

  switch ($column_name) {
    case 'profile_approved' :
      return $approved_check;
      break;

    default:
  }
  return $val;
}


add_action( 'show_user_profile', 'paces_show_extra_profile_fields_for_approve', 50 );
add_action( 'edit_user_profile', 'paces_show_extra_profile_fields_for_approve', 50 );

function paces_show_extra_profile_fields_for_approve( $user ) {
  if(current_user_can('administrator')){
    if( get_user_meta( $user->ID, 'first_payment', true ) ){
    if( in_array( 'subscriber', (array)$user->roles ) && !in_array( 'administrator', (array)$user->roles ) ){
      $approved = intval( get_user_meta($user->ID,'pay_approved_by_admin',true) );
      if($approved){
        ?>
        <h3><?php esc_html_e( 'Member is approved', 'crf' ); ?></h3>
        <table class="form-table approved_disabled" >
          <tr>
            <th><label for="approved_by_admin"><?php esc_html_e( 'Member is approved', 'approved_by_admin' ); ?></label></th>
            <td><input type="checkbox" name="approved_by_admin" id="approved_by_admin" value="1" class="regular-text approved_by_admin" checked>
            </td>
          </tr>
          </table>
        <?php
      }else{
        ?>
        <h3><?php esc_html_e( 'Member Approval is pending', 'crf' ); ?></h3>
        <table class="form-table">
          <tr>
            <th><label for="approved_by_admin"><?php esc_html_e( 'Approve this member', 'approved_by_admin' ); ?></label></th>
            <td><input type="checkbox" name="approved_by_admin" id="approved_by_admin" value="1" class="regular-text approved_by_admin">
            </td>
          </tr>
          </table>
        <?php
        if( get_user_meta( $user->ID, 'first_payment', true ) == 'true' ){
          ?>
          <?php
        }
      }
    }
  }
    
  } 
}

add_action( 'personal_options_update', 'paces__update_profile_approve_fields' );
add_action( 'edit_user_profile_update', 'paces__update_profile_approve_fields' );

function paces__update_profile_approve_fields( $user_id ) {
  if ( ! current_user_can( 'edit_user', $user_id ) ) {
    return false;
  }
  $user = get_user_by( 'ID', $user_id );
  $ep_pid = get_user_meta( $user_id, 'ep_special_post_id', true );
  if(current_user_can('administrator')){
    update_user_meta( $user_id, 'pay_approved_by_admin', intval( $_POST['approved_by_admin'] ) );
    update_user_meta( $user_id, 'first_payment', 'done' );
    if( intval( $_POST['approved_by_admin'] ) ){
      $ep_post_id = get_user_meta( $user_id, 'ep_special_post_id', true );
      $paid_for_id = get_user_meta( $user_id, 'paid_for_level', true );
      if($paid_for_id){
        if(update_membership_for_approved_user(intval($paid_for_id), $user_id)){
          update_user_meta( $user_id, 'paid_for_level', '' );
          paces_mailPoet_unsubscribe_from_list( $user_id, array('10') );
          paces_mailPoet_subscribe_to_list( $user_id, array( '8','9' ) );
        }      
      }
      send_approve_email_to_user( $user );
      wp_update_post( array(
          'ID'           => $ep_post_id,
          'post_status'   => 'publish'
      ) );
    }else{
      paces_mailPoet_unsubscribe_from_list( $user_id, array('9') );
      paces_mailPoet_subscribe_to_list( $user_id, array( '8','10' ) );
      wp_update_post( array(
          'ID'           => $ep_post_id,
          'post_status'   => 'draft'
      ) );
    }      
  }
}

function update_membership_for_approved_user( $paid_for_id, $user_id){
  global $wpdb;
  $pmpro_level = new PMPro_Membership_Level( $paid_for_id );
  $tab_memberships_users = $wpdb->prefix.'pmpro_memberships_users';
  $tab_membership_levels = $wpdb->prefix.'pmpro_membership_levels';
  $tab_embership_orders  = $wpdb->prefix.'pmpro_membership_orders';
  
  $memberships_users = $wpdb->get_row("SELECT * FROM $tab_memberships_users WHERE user_id = '$user_id' AND status = 'inactive' AND membership_id = '$paid_for_id' ORDER BY id DESC LIMIT 1", ARRAY_A);

  $memberships_user_basic = $wpdb->get_row("SELECT * FROM $tab_memberships_users WHERE user_id = '$user_id' AND status = 'active' AND membership_id = '1' ORDER BY id DESC LIMIT 1", ARRAY_A);

  $embership_orders = $wpdb->get_row("SELECT * FROM $tab_embership_orders WHERE membership_id = '$paid_for_id' AND user_id = '$user_id' ORDER BY id DESC LIMIT 1", ARRAY_A);

  if($memberships_users){
    
    $enddate = "NULL";
    $startdate = current_time( 'mysql' );
    
    if ( ! empty( $pmpro_level->expiration_number ) ) {
      $enddate =  date( "Y-m-d H:i:s", strtotime( "+ " . $pmpro_level->expiration_number . " " . $pmpro_level->expiration_period, current_time( "timestamp" ) ) );
    }
    $enddate = apply_filters( "pmpro_checkout_end_date", $enddate, $user_id, $pmpro_level, $startdate );

    $basic_where = array('id' => $memberships_user_basic['id']);
    $basic_data = array('status' => 'inactive');
    $basic_updated = $wpdb->update($tab_memberships_users, $basic_data, $basic_where);

    $where = array('id' => $memberships_users['id']);
    $data = array('status' => 'active', 'enddate' => $enddate, 'startdate' => $startdate);
    $updated = $wpdb->update($tab_memberships_users, $data, $where);
    
    if($updated){
      $order_data = array('status' => 'success');
      $order_where = array('id' => $embership_orders['id']);
      $order_updated = $wpdb->update($tab_embership_orders, $order_data, $order_where); 
      return true; 
    }
  }else{
    return false;
  }

}