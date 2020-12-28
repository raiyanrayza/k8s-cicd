<?php

/*
* Add Edit page link in user edit profile.
*/
function paces_edit_extra_fields_link($user){
	$edit_url = '#';
	$edit_url = add_query_arg( array('page' => 'edit-user-large-details' , 'user_id'=>$user->ID), admin_url( 'users.php' ) );
	?>
	<table class="form-table edit_profile_wrap">

		<tr>
			<th><label for="ep_special">Edit/See More Details</label></th>

			<td>
				<a href="<?php echo esc_url($edit_url); ?>" class="button">Edit/See</a>
			</td>
		</tr>

	</table>
	<?php
}
add_action( 'show_user_profile', 'paces_edit_extra_fields_link' );
add_action( 'edit_user_profile', 'paces_edit_extra_fields_link' );


/*
* Add Edit page as user submenu.
*/
function paces_new_edit_users_menu() {
    $page = add_users_page(
        __( 'Edit Users Fields' ),
        __( 'Edit users Fields' ),
        'read',
        'edit-user-large-details',
        'pacess_edit_user_large_details_function'
    );
}
add_action('admin_menu', 'paces_new_edit_users_menu');

/*
* Remove Edit page link (menu) from users admin menu.
*/
function admin_menu_filter(){
    remove_submenu_page( 'users.php', 'edit-user-large-details' );
}
add_filter( 'admin_menu', 'admin_menu_filter',500 );

/*
* Remove Edit page link (menu) from users admin menu.
*/
/*function hide_customize_submenus(){
    echo '<style>#customize-current-theme-link{display:none;}</style>';
}
add_action( 'admin_print_styles-themes.php', 'hide_customize_submenus' );*/

/*
* Add enqueue bb theme set bootstrap style and script.
*/
function add_bootstrap_to_admin(){
	// users_page_edit-user-large-details
	$screen = get_current_screen();
	if( $screen->id == 'users_page_edit-user-large-details' ){
		if( class_exists( 'FLLayout' ) )
				FLLayout::enqueue_framework();		
	}
}
add_action( 'admin_enqueue_scripts', 'add_bootstrap_to_admin' );


/*
*  Edit new fields page Contents.
*/


function pacess_edit_user_large_details_function(){
	global $pagenow;
	echo '<div class="wrap paces_wrap">';
	if( !isset( $_GET['user_id'] ) || empty( $_GET['user_id'] ) ){
		echo '<h1>No user to edit.</h1>';
		echo '<a href="'.admin_url( 'users.php' ).'">Back</a>';
	}else{
		$user_id = intval($_GET['user_id']);
		if( get_user_by( 'ID', $user_id ) ){
			echo '<h1>Edit users Details</h1>';
			echo 'Edit Extra fields of user here:';
				echo show_users_more_fields_to_edit($user_id);			
		}else{
			echo '<h1>No user to edit.</h1>';
			echo '<a href="'.admin_url( 'users.php' ).'">Back</a>';
		}
	}
	echo '</div>';
}

function show_users_more_fields_to_edit($user_id){
	global $wp;

	$ref_url = add_query_arg( array( 'user_id' => $user_id ), menu_page_url('edit-user-large-details', false) );
	$user = get_user_by( 'ID', $user_id );
	include_once( FL_CHILD_THEME_DIR . '/app/common/country-list.php' );
	include_once( FL_CHILD_THEME_DIR . '/app/common/state-list.php' );

	$country_list = paces_get_country_list();
	$state_list = paces_get_states_list();

	$inputSecAddress1 = '';
	$inputSecAddress2 = '';
	$inputSecAddress3 = '';
	$inputSecCity = '';
	$inputSecState = '';
	$inputSecPostalCode = '';
	$inputSecCountry = '';
	$inputPreferredAddress = '';
	$inputHomePhone = '';
	$inputFax = '';
	$inputWPExt = '';
	$inputHPExt = '';
	$inputFaxExt = '';
	$inputPreferredPhone = '';

	$hospitalPosition = get_user_meta( $user->ID, 'hospitalPosition', true );
	$hospitalName = get_user_meta( $user->ID, 'hospitalName', true );
	$universityName = get_user_meta( $user->ID, 'universityName', true );
	$academicRank = get_user_meta( $user->ID, 'academicRank', true );
	$academicRankOtherText = get_user_meta( $user->ID, 'academicRankOtherText', true );

	$institutionIsEPFellowship = get_user_meta( $user->ID, 'institutionIsEPFellowship', true );
	$researchAreas = get_user_meta( $user->ID, 'researchAreas', true );

	$publication1 = get_user_meta( $user->ID, 'publication1', true );
	$publication_pmid1 = get_user_meta( $user->ID, 'publication_pmid1', true );

	$publication2 = get_user_meta( $user->ID, 'publication2', true );
	$publication_pmid2 = get_user_meta( $user->ID, 'publication_pmid2', true );

	$publication3 = get_user_meta( $user->ID, 'publication3', true );
	$publication_pmid3 = get_user_meta( $user->ID, 'publication_pmid3', true );

	$publication4 = get_user_meta( $user->ID, 'publication4', true );
	$publication_pmid4 = get_user_meta( $user->ID, 'publication_pmid4', true );

	$publication5 = get_user_meta( $user->ID, 'publication5', true );
	$publication_pmid5 = get_user_meta( $user->ID, 'publication_pmid5', true );

	$pastScientificSocietyName  = get_user_meta( $user->ID, 'pastScientificSocietyName', true );
	$pastCommitteeName = get_user_meta( $user->ID, 'pastCommitteeName', true );
	$pastRole = get_user_meta( $user->ID, 'pastRole', true );
	$pastTenureDate = get_user_meta( $user->ID, 'pastTenureDate', true );

	$presentScientificSocietyName = get_user_meta( $user->ID, 'presentScientificSocietyName', true );
	$presentCommitteeName = get_user_meta( $user->ID, 'presentCommitteeName', true );
	$presentRole = get_user_meta( $user->ID, 'presentRole', true );
	$presentTenureDate = get_user_meta( $user->ID, 'presentTenureDate', true );

	$futureScientificSocietyName = get_user_meta( $user->ID, 'futureScientificSocietyName', true );
	$futureCommitteeName = get_user_meta( $user->ID, 'futureCommitteeName', true );
	$futureRole = get_user_meta( $user->ID, 'futureRole', true );
	$futureTenureDate = get_user_meta( $user->ID, 'futureTenureDate', true );

	$pastNationalScientificGuideName = get_user_meta( $user->ID, 'pastNationalScientificGuideName', true );
	$pastSocietyRepresentName = get_user_meta( $user->ID, 'pastSocietyRepresentName', true );
	$presentNationalScientificGuideName = get_user_meta( $user->ID, 'presentNationalScientificGuideName', true );
	$presentSocietyRepresentName = get_user_meta( $user->ID, 'presentSocietyRepresentName', true );
	$futureNationalScientificGuideName = get_user_meta( $user->ID, 'futureNationalScientificGuideName', true );
	$futureSocietyRepresentName = get_user_meta( $user->ID, 'futureSocietyRepresentName', true );

	$presentGrantInfo = get_user_meta( $user->ID, 'presentGrantInfo', true );
	$presentGrantRole = get_user_meta( $user->ID, 'presentGrantRole', true );
	$pastGrantInfo = get_user_meta( $user->ID, 'pastGrantInfo', true );
	$pastGrantRole = get_user_meta( $user->ID, 'pastGrantRole', true );
	$futureGrantInfo = get_user_meta( $user->ID, 'futureGrantInfo', true );
	$futureGrantRole = get_user_meta( $user->ID, 'futureGrantRole', true );

	$pacesInterests = get_user_meta( $user->ID, 'pacesInterests', true );
	$relationshipIndustry = get_user_meta( $user->ID, 'relationshipIndustry', true );

	if(!$pacesInterests)
		$pacesInterests = array();
	if(!$relationshipIndustry)
		$relationshipIndustry = array();

	if(!$academicRank)
		$academicRank = array();
	if(!$researchAreas)
		$researchAreas = array();

	$inputSecAddress1 = get_user_meta( $user->ID, 'sec_address_line_1', true );
    $inputSecAddress2 = get_user_meta( $user->ID, 'sec_address_line_2', true );
    $inputSecAddress3 = get_user_meta( $user->ID, 'sec_address_line_3', true );
    $inputSecCity = get_user_meta( $user->ID, 'sec_city', true );
    $inputSecState = get_user_meta( $user->ID, 'sec_state', true );
    $inputSecPostalCode = get_user_meta( $user->ID, 'sec_postal_code', true );
    $inputSecCountry = get_user_meta( $user->ID, 'sec_country', true );
    $inputPreferredAddress = get_user_meta( $user->ID, 'prefer_add', true );
    $inputHomePhone = get_user_meta( $user->ID, 'home_phone', true );
    $inputFax = get_user_meta( $user->ID, 'fax_phone', true );
    $inputPreferredPhone = get_user_meta( $user->ID, 'prefer_phone', true );
    $inputWPExt = get_user_meta( $user->ID, 'work_phone_ext', true );
    $inputHPExt = get_user_meta( $user->ID, 'home_phone_ext', true );
    $inputFaxExt = get_user_meta( $user->ID, 'fax_phone_ext', true );


	$image_icon = site_url().'/wp-content/themes/bb-theme-child/images/avatar-bg.png';
	$contact_card_icon = site_url().'/wp-content/themes/bb-theme-child/images/vc_card.jpg';
	
	$user_ep_id = get_user_meta( $user->ID, 'ep_special_post_id', true );
	if( !empty( $user_ep_id ) ){
		$photo = get_field( 'picture', $user_ep_id );
		if( $photo ){
			$size = 'thumbnail';
			$thumb = $photo['sizes'][ $size ];
			$image_icon = $thumb;
		}

		$vcard_image = get_field( 'contact_card_vcard', $user_ep_id );
		if( $vcard_image['type'] == 'image' ){
			$size = 'thumbnail';
			$thumb = $vcard_image['sizes'][ $size ];
			if(!empty($thumb))
				$contact_card_icon = $thumb;
		}

	}else {
		if( get_user_meta( $user->ID, 'cusotm_avtar_id', true ) ){
			$profile_pic_id = get_user_meta( $user->ID, 'cusotm_avtar_id', true );
			$thumb = wp_get_attachment_image_src( $profile_pic_id, 'thumbnail', true );
			if($thumb)
				$image_icon = $thumb[0];
		}
		if( get_user_meta( $user->ID, 'contact_card_vcard', true ) ){
			$contact_pic_id = get_user_meta( $user->ID, 'contact_card_vcard', true );
			$thumb = wp_get_attachment_image_src( $contact_pic_id, 'thumbnail', true );
			if($thumb)
				$contact_card_icon = $thumb[0];
		}
	}


	$inputSalutation = get_user_meta( $user->ID, 'salutation', true );
	$inputSuffix = get_user_meta( $user->ID, 'suffix', true );
	$inputMiddlename = get_user_meta( $user->ID, 'middle_name', true );
	
	$inputEmployer = get_user_meta( $user->ID, 'company', true );
	$inputDegree = get_user_meta( $user->ID, 'degree', true );
	$inputDepartment = get_user_meta( $user->ID, 'department', true );

    $inputWorkPhone = get_user_meta( $user->ID, 'work_phone', true );
    
    $inputAddress1 = get_user_meta( $user->ID, 'address_line_1', true );
    $inputAddress2 = get_user_meta( $user->ID, 'address_line_2', true );
    $inputAddress3 = get_user_meta( $user->ID, 'address_line_3', true );
    $inputCity = get_user_meta( $user->ID, 'city', true );
    $inputState = get_user_meta( $user->ID, 'state', true );
    $inputPostalCode = get_user_meta( $user->ID, 'postal_code', true );
    $inputCountry = get_user_meta( $user->ID, 'country', true );
    
    $inputTwitter = get_user_meta( $user->ID, 'twitter_contact', true );
    $inputWebsite = get_user_meta( $user->ID, 'website_address', true );

    if(!empty($user_ep_id)){
    	$inputEmployer = get_field('company', $user_ep_id);
		$inputWorkPhone = get_field('work_phone', $user_ep_id);
		$inputAddress1 = get_field('address_line_1', $user_ep_id);
		$inputAddress2 = get_field('address_line_2', $user_ep_id);
		$inputCity = get_field('city', $user_ep_id);
		$inputState = get_field('state', $user_ep_id);
		$inputPostalCode = get_field('postal_code', $user_ep_id);
		$inputCountry = get_field('country', $user_ep_id);
		$inputTwitter = get_field('twitter_contact', $user_ep_id);
		$inputWebsite = get_field('website_address', $user_ep_id);
    }

    $salution_values = array(
    						"Dr."=>"Dr.",
							"M"=>"M",
							"Miss"=>"Miss",
							"Mr."=>"Mr.",
							"Mrs."=>"Mrs.",
							"Ms."=>"Ms.",
							"Prof."=>"Prof.",
							"Rev"=>"Rev"
    					);
    $suffix_values = array(
    						"II"=>"II",
							"Sr."=>"Sr.",
							"Jr."=>"Jr.",
							"III"=>"III"
    					);
	?>
	<div class="admin_page-wrap">
	<form id="member-profile-edit-admin" class="pmpro_form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" enctype="multipart/form-data">
	<div class="dfr__body dfr__body_Paces">
		<div class="dfr__bodyfields">
			<div class="dfr_form pre_head_fade">
				<div class="row">
					<div class="col-sm-6">
						<h6 class="float-left">Email : <?php echo $user->user_email; ?></h6>
					</div>
					<div class="col-sm-6">
						<h6 class="float-right">Username : <?php echo $user->user_login; ?></h6>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
							<div class="avatar-edit">
								<div class="btnnn">
									<img src="<?php echo esc_url($image_icon); ?>" alt="img">
								</div>
								<div class="avatar-preview">
									<div id="imagePreview"></div>
								</div>
								<div class="pr_user_img_cont_wrapper">
									<label for="upload_photo">Change Profile Image</label>
									<input type='file' id="upload_photo" name="upload_photo" accept=".png, .jpg, .jpeg" />
								 </div>
							</div>
					</div>
				</div>
			</div>
		</div>
		<!-- <h3> <span class="pmpro_checkout-h3-name">Register here</span></h3> -->
		<div class="dfr__bodyfields">
			<div class="dfr_form">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputSalutation">Prefix</label>
							<select class="form-control" id="inputSalutation" name="inputSalutation">
								<option value="">Select One</option>
								<?php
								if( $salution_values ){
									foreach ($salution_values as $slcode => $salutation) {
										if($inputSalutation == $slcode){
											$checked = 'selected';
										}else{
											$checked = '';
										}
										echo '<option value="'. $slcode .'" '. $checked .'>'. $salutation .'</option>';
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="first_name">First name*</label>
							<input type="text" class="form-control <?php echo pmpro_get_element_class( 'input', 'first_name' ); ?>" id="first_name" name="first_name" placeholder="First name" value="<?php echo $user->first_name; ?>" required>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputMiddlename">Middle Name</label>
							<input type="text" class="form-control" id="inputMiddlename" name="inputMiddlename" placeholder="Middle name" value="<?php echo $inputMiddlename; ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="last_name">Last Name / Surname*</label>
							<input type="text" class="form-control <?php echo pmpro_get_element_class( 'input', 'last_name' ); ?>" id="last_name" name="last_name" placeholder="Last name" value="<?php echo $user->last_name; ?>" required>
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="display_name">Display Name</label>
							<input type="text" class="form-control <?php echo pmpro_get_element_class( 'input', 'display_name' ); ?>" id="display_name" name="display_name" placeholder="Display name" value="<?php echo $user->display_name; ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputSuffix">Suffix</label>
							<select class="form-control" id="inputSuffix" name="inputSuffix">
								<option value="">Select One</option>
								<?php
								if( $suffix_values ){
									foreach ($suffix_values as $scode => $suffix) {
										if($inputSuffix == $scode){
											$checked = 'selected';
										}else{
											$checked = '';
										}
										echo '<option value="'. $scode .'" '. $checked.'>'. $suffix .'</option>';
									}
								}
								?>
								<!-- <option value="II">II</option>
								<option value="Sr.">Senior</option>
								<option value="Jr.">Junior</option>
								<option value="III">III</option> -->
							</select>
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputEmployer">Employer</label>
							<input type="text" class="form-control" id="inputEmployer" name="inputEmployer" placeholder="Employer" value="<?php echo esc_attr( $inputEmployer ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputDegree">Degree(s)</label>
							<input type="text" class="form-control" id="inputDegree" name="inputDegree" placeholder="Degree(s)" value="<?php echo esc_attr( $inputDegree ); ?>">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="dfr__bodyfields">
			<h3>Main Address</h3>
			<div class="dfr_form">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputDepartment">Department</label>
							<input type="text" class="form-control" id="inputDepartment" name="inputDepartment" placeholder="Department" value="<?php echo esc_attr( $inputDepartment ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputAddress1">Address 1*</label>
							<input type="text" class="form-control" id="inputAddress1" name="inputAddress1" placeholder="Address 1" required  value="<?php echo esc_attr( $inputAddress1 ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputAddress2">Address 2</label>
							<input type="text" class="form-control" id="inputAddress2" name="inputAddress2" placeholder="Address 2" value="<?php echo esc_attr( $inputAddress2 ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputAddress3">Address 3</label>
							<input type="text" class="form-control" id="inputAddress3" name="inputAddress3" placeholder="Address 3" value="<?php echo esc_attr( $inputAddress3 ); ?>">
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputCity">City*</label>
							<input type="text" class="form-control" id="inputCity" name="inputCity" placeholder="City" value="<?php echo esc_attr( $inputCity ); ?>" required>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputState">State/Province</label>
							<select class="form-control" id="inputState" name="inputState">
								<option value="">Any</option>
								<?php
								if( $state_list ){
									foreach ($state_list as $code => $state) {
										$checked = '';
										if($inputState == $code){
											$checked = 'selected';
										}
										echo '<option value="'. $code .'" '. $checked.'>'. $state .'</option>';
									}
								}
								?>
							</select>
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputPostalCode">Postal Code</label>
							<input type="text" class="form-control" id="inputPostalCode" name="inputPostalCode" placeholder="Postal Code" value="<?php echo esc_attr( $inputPostalCode ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputCountry">Country*</label>
							<select class="form-control" id="inputCountry" name="inputCountry" required>
								<option value="">Any</option>
								<?php
								if( $country_list ){
	                                foreach ($country_list as $code => $country) {
	                                	$attr_checked = '';
										if($inputCountry == $code){
											$attr_checked = 'selected';
										}	
	                                	echo '<option value="'. $code .'" '. $attr_checked .'>'. $country .'</option>';
	                                }
	                            }
								?>
								<option value="US" <?php if($inputCountry == 'US') echo 'selected'; ?>>United States of America</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="dfr__bodyfields">
			<h3>Secondary Address</h3>
			<div class="dfr_form">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputSecAddress1">Address 1</label>
							<input type="text" class="form-control" id="inputSecAddress1" name="inputSecAddress1" placeholder="Address 1"  value="<?php echo esc_attr( $inputSecAddress1 ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputSecAddress2">Address 2</label>
							<input type="text" class="form-control" id="inputSecAddress2" name="inputSecAddress2" placeholder="Address 2" value="<?php echo esc_attr( $inputSecAddress2 ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputSecAddress3">Address 3</label>
							<input type="text" class="form-control" id="inputSecAddress3" name="inputSecAddress3" placeholder="Address 3" value="<?php echo esc_attr( $inputSecAddress3 ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputSecCity">City</label>
							<input type="text" class="form-control" id="inputSecCity" name="inputSecCity" placeholder="City" value="<?php echo esc_attr( $inputSecCity ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputSecState">State/Province</label>
							<select class="form-control" id="inputSecState" name="inputSecState">
								<option value="">Any</option>
								<?php
								if( $state_list ){
									foreach ($state_list as $code => $state) {
										$checked = '';
										if($inputState == $code){
											$checked = 'selected';
										}
										echo '<option value="'. $code .'" '. $checked.'>'. $state .'</option>';
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputSecPostalCode">Postal Code</label>
							<input type="text" class="form-control" id="inputSecPostalCode" name="inputSecPostalCode" placeholder="Postal Code" value="<?php echo esc_attr( $inputSecPostalCode ); ?>">
						</div>
					</div>
				</div>
				<div class="row">					
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputSecCountry">Country</label>
							<select class="form-control" id="inputSecCountry" name="inputSecCountry">
								<option value="">Any</option>
								<?php
								if( $country_list ){
	                                foreach ($country_list as $code => $country) {
	                                	$attr_checked = '';
										if($inputCountry == $code){
											$attr_checked = 'selected';
										}	
	                                	echo '<option value="'. $code .'" '. $attr_checked .'>'. $country .'</option>';
	                                }
	                            }
								?>
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputPreferredAddress">Preferred Address:</label>
							<select class="form-control" id="inputPreferredAddress" name="inputPreferredAddress">
								<option value="">Specify Your Preferred Address...</option>
								<option value="main_add" <?php if( $inputPreferredAddress == 'main_add') echo 'selected'; ?>>Main Address:</option>
								<option value="sec_add" <?php if( $inputPreferredAddress == 'sec_add') echo 'selected'; ?>>Secondary Address: </option>								
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="dfr__bodyfields">
			<h3>Contact Numbers</h3>
			<div class="dfr_form">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputWorkPhone">Work Phone (This number will be displayed in the directory)</label>
							<input type="text" class="form-control phoneInputbit" id="inputWorkPhone" name="inputWorkPhone" placeholder="Work Phone" value="<?php echo esc_attr( $inputWorkPhone ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputWPExt">Ext:</label>
							<input type="text" class="form-control" id="inputWPExt" name="inputWPExt" placeholder="Ext" value="<?php echo esc_attr( $inputWPExt ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputHomePhone">Home Phone:</label>
							<input type="text" class="form-control phoneInputbit" id="inputHomePhone" name="inputHomePhone" placeholder="Home Phone" value="<?php echo esc_attr( $inputHomePhone ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputHPExt">Ext:</label>
							<input type="text" class="form-control" id="inputHPExt" name="inputHPExt" placeholder="Ext" value="<?php echo esc_attr( $inputHPExt ); ?>">
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputFax">Fax:</label>
							<input type="text" class="form-control phoneInputbit" id="inputFax" name="inputFax" placeholder="Fax" value="<?php echo esc_attr( $inputFax ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputFaxExt">Ext:</label>
							<input type="text" class="form-control" id="inputFaxExt" name="inputFaxExt" placeholder="Ext" value="<?php echo esc_attr( $inputFaxExt ); ?>">
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputPreferredPhone">Preferred Phone:</label>
							<select class="form-control" id="inputPreferredPhone" name="inputPreferredPhone">
								<option value="">Specify Your Preferred Phone...</option>
								<option value="work" <?php if( $inputPreferredPhone == 'work') echo 'selected'; ?>>Work Phone</option>
								<option value="home" <?php if( $inputPreferredPhone == 'home') echo 'selected'; ?>>Home Phone</option>
								<option value="fax" <?php if( $inputPreferredPhone == 'fax') echo 'selected'; ?>>FAX</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="dfr__bodyfields">
			<h3>Other Social Presence</h3>
			<div class="dfr_form">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputAddressLine1">Twitter Contact</label>
							<input type="text" class="form-control" id="inputTwitter" name="inputTwitter" placeholder="Twitter Contact" value="<?php echo esc_attr( $inputTwitter ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="inputWebsite">Website Address</label>
							<input type="text" class="form-control" id="inputWebsite" name="inputWebsite" placeholder="Website Address" value="<?php echo esc_attr( $inputWebsite ); ?>">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="dfr__bodyfields">
			<!-- <h3>Other Social Presence</h3> -->
			<div class="dfr_form">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="hospitalPosition">Hospital Position</label>
							<input type="text" class="form-control" id="hospitalPosition" name="hospitalPosition" placeholder="Hospital Position" value="<?php echo esc_attr( $hospitalPosition ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="hospitalName">Name of Hospital/Institution</label>
							<input type="text" class="form-control" id="hospitalName" name="hospitalName" placeholder="Hospital/Institution Name" value="<?php echo esc_attr( $hospitalName ); ?>">
						</div>
					</div>
				</div>
				<div class="row">					
					<div class="col-sm-6">
						<div class="form-group">
							<label for="universityName">Name of University or Academic Affiliation (if applicable)</label>
							<input type="text" class="form-control" id="universityName" name="universityName" placeholder="Name of University or Academic Affiliation" value="<?php echo esc_attr( $universityName ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="institutionIsEPFellowship">Does your institution have an EP Fellowship?</label>
							<select class="form-control" id="institutionIsEPFellowship" name="institutionIsEPFellowship">
								<option value="">Please Specify...</option>
								<option value="yes" <?php if( $institutionIsEPFellowship == 'yes') echo 'selected'; ?>>Yes</option>
								<option value="no" <?php if( $institutionIsEPFellowship == 'no') echo 'selected'; ?>>No</option>
								<option value="notevery_year" <?php if( $institutionIsEPFellowship == 'notevery_year') echo 'selected'; ?>>Not Every Year</option>								
							</select>
							
						</div>
					</div>
				</div>
				<div class="row">
					
					<div class="col-sm-6">
						<div class="form-group pace-checks">
							<label>Academic Rank (if applicable)</label>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="academicRank1" name="academicRank[]" value="instructor" <?php echo in_array('instructor', $academicRank) ? 'checked' : ''; ?>>
								<label for="academicRank1">Instructor</label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="academicRank2" name="academicRank[]" value="assistant_prof" <?php echo in_array('assistant_prof', $academicRank) ? 'checked' : ''; ?>>
								<label for="academicRank2">Assistant Professor </label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="academicRank3" name="academicRank[]" value="associate_prof" <?php echo in_array('associate_prof', $academicRank) ? 'checked' : ''; ?>>
								<label for="academicRank3">Associate Professor </label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="academicRank4" name="academicRank[]" value="professor" <?php echo in_array('professor', $academicRank) ? 'checked' : ''; ?>> 
								<label for="academicRank4">Professor </label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="academicRank5" name="academicRank[]" value="none" <?php echo in_array('none', $academicRank) ? 'checked' : ''; ?>> 
								<label for="academicRank5">None</label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="academicRankOther" name="academicRank[]" value="other" <?php echo in_array('other', $academicRank) ? 'checked' : ''; ?>> 
								<label for="academicRankOther">Other - Please Specify</label>
							</span>
							<input type="text" class="form-control" id="academicRankOtherText" name="academicRankOtherText" placeholder="If Other - Please Specify" value="<?php echo $academicRankOtherText; ?>">

						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group pace-checks">
							<label>Areas of Clinical/research interest: Check all that apply</label>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="researchAreas1" name="researchAreas[]" value="device_therapy" <?php echo in_array('device_therapy', $researchAreas) ? 'checked' : ''; ?>>
								<label for="researchAreas1">Device therapy </label>
							</span>
							<span class="gwt-CheckBox">							
								<input type="checkbox" class="form-control" id="researchAreas2" name="researchAreas[]" value="catheter_ablation" <?php echo in_array('catheter_ablation', $researchAreas) ? 'checked' : ''; ?>> 
								<label for="researchAreas2">Catheter Ablation </label>
							</span>
							<span class="gwt-CheckBox">							
								<input type="checkbox" class="form-control" id="researchAreas3" name="researchAreas[]" value="fetal_arrhythmia" <?php echo in_array('fetal_arrhythmia', $researchAreas) ? 'checked' : ''; ?>> 
								<label for="researchAreas3">Fetal arrhythmia </label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="researchAreas4" name="researchAreas[]" value="cardiac_channelopathy" <?php echo in_array('cardiac_channelopathy', $researchAreas) ? 'checked' : ''; ?>> 
								<label for="researchAreas4">Cardiac Channelopathy </label>
							</span>
							<span class="gwt-CheckBox">							
								<input type="checkbox" class="form-control" id="researchAreas5" name="researchAreas[]" value="autonomic_nervous" <?php echo in_array('autonomic_nervous', $researchAreas) ? 'checked' : ''; ?>> 
								<label for="researchAreas5">Autonomic Nervous System </label>
							</span>
							<span class="gwt-CheckBox">							
								<input type="checkbox" class="form-control" id="researchAreas6" name="researchAreas[]" value="adult_congenital_heart" <?php echo in_array('adult_congenital_heart', $researchAreas) ? 'checked' : ''; ?>> 
								<label for="researchAreas6">Adult Congenital Heart Disease </label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="researchAreas7" name="researchAreas[]" value="anti_arrhythmic_drugs" <?php echo in_array('anti_arrhythmic_drugs', $researchAreas) ? 'checked' : ''; ?>> 
								<label for="researchAreas7"> Anti-Arrhythmic Drugs </label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="researchAreas8" name="researchAreas[]" value="sudden_cardiac_death" <?php echo in_array('sudden_cardiac_death', $researchAreas) ? 'checked' : ''; ?>> 
								<label for="researchAreas8">Sudden Cardiac Death </label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="researchAreas9" name="researchAreas[]" value="new_technology" <?php echo in_array('new_technology', $researchAreas) ? 'checked' : ''; ?>>
								<label for="researchAreas9">New Technology</label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="researchAreas10" name="researchAreas[]" value="rhythm_monitoring" <?php echo in_array('rhythm_monitoring', $researchAreas) ? 'checked' : ''; ?>> 
								<label for="researchAreas10">Rhythm Monitoring </label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="researchAreas11" name="researchAreas[]" value="remote_monitoring" <?php echo in_array('remote_monitoring', $researchAreas) ? 'checked' : ''; ?>> 
								<label for="researchAreas11">Remote Monitoring </label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="researchAreas12" name="researchAreas[]" value="health_care_policy" <?php echo in_array('health_care_policy', $researchAreas) ? 'checked' : ''; ?>> 
								<label for="researchAreas12">Health Care Policy </label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="researchAreas13" name="researchAreas[]" value="patient_education" <?php echo in_array('patient_education', $researchAreas) ? 'checked' : ''; ?>> 
								<label for="researchAreas13">Patient Education </label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="researchAreas14" name="researchAreas[]" value="quality_of_life" <?php echo in_array('quality_of_life', $researchAreas) ? 'checked' : ''; ?>>
								<label for="researchAreas14">Quality of Life </label>
							</span>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="researchAreas15" name="researchAreas[]" value="all_of_above" <?php echo in_array('all_of_above', $researchAreas) ? 'checked' : ''; ?>>
								<label for="researchAreas15">All of the above</label>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="dfr__bodyfields">
				<h3>Enter Top 5 publications below: <small>Please include PMID for each.</small></h3>
			<div class="dfr_form">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="publication1">Publication 1</label>
							<textarea rows="4" class="form-control" name="publication1" id="publication1"><?php echo esc_attr( $publication1 ); ?></textarea>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="publication_pmid1">PMID 1</label>
							<input type="text" class="form-control" id="publication_pmid1" name="publication_pmid1" value="<?php echo esc_attr( $publication_pmid1 ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="publication2">Publication 2</label>
							<textarea rows="4" class="form-control" name="publication2" id="publication2"><?php echo esc_attr( $publication2 ); ?></textarea>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="publication_pmid2">PMID 2</label>
							<input type="text" class="form-control" id="publication_pmid2" name="publication_pmid2" value="<?php echo esc_attr( $publication_pmid2 ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="publication3">Publication 3</label>
							<textarea rows="4" class="form-control" name="publication3" id="publication3"><?php echo esc_attr( $publication3 ); ?></textarea>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="publication_pmid3">PMID 3</label>
							<input type="text" class="form-control" id="publication_pmid3" name="publication_pmid3" value="<?php echo esc_attr( $publication_pmid3 ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="publication4">Publication 4</label>
							<textarea rows="4" class="form-control" name="publication4" id="publication4"><?php echo esc_attr( $publication4 ); ?></textarea>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="publication_pmid4">PMID 4</label>
							<input type="text" class="form-control" id="publication_pmid4" name="publication_pmid4" value="<?php echo esc_attr( $publication_pmid4 ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="publication5">Publication 5</label>
							<textarea rows="4" class="form-control" name="publication5" id="publication5"><?php echo esc_attr( $publication5 ); ?></textarea>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="publication_pmid5">PMID 5</label>
							<input type="text" class="form-control" id="publication_pmid5" name="publication_pmid5" value="<?php echo esc_attr( $publication_pmid5 ); ?>">
						</div>
					</div>
				</div>

			</div>
		</div>

		<div class="dfr__bodyfields">
				<h3>National Scientific Committees: <small>Please state name of scientific society, name of committee, role, and tenure on committee</small></h3>
			<div class="dfr_form">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="pastScientificSocietyName">PAST Scientific Society Name</label>
							<input type="text" class="form-control" id="pastScientificSocietyName" name="pastScientificSocietyName" placeholder="PAST Scientific Society Name" value="<?php echo esc_attr( $pastScientificSocietyName ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="pastCommitteeName">PAST Committee Name</label>
							<input type="text" class="form-control" id="pastCommitteeName" name="pastCommitteeName" placeholder="PAST Committee Name" value="<?php echo esc_attr( $pastCommitteeName ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="pastRole">PAST Role</label>
							<input type="text" class="form-control" id="pastRole" name="pastRole" placeholder="PAST Role" value="<?php echo esc_attr( $pastRole ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="pastTenureDate">PAST Tenure Dates</label>
							<input type="text" class="form-control" id="pastTenureDate" name="pastTenureDate" placeholder="PAST Tenure Dates" value="<?php echo esc_attr( $pastTenureDate ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="presentScientificSocietyName">PRESENT Scientific Society Name</label>
							<input type="text" class="form-control" id="presentScientificSocietyName" name="presentScientificSocietyName" placeholder="PRESENT Scientific Society Name" value="<?php echo esc_attr( $presentScientificSocietyName ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="presentCommitteeName">PRESENT Committee Name</label>
							<input type="text" class="form-control" id="presentCommitteeName" name="presentCommitteeName" placeholder="PRESENT Committee Name" value="<?php echo esc_attr( $presentCommitteeName ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="presentRole">PRESENT Role</label>
							<input type="text" class="form-control" id="presentRole" name="presentRole" placeholder="PRESENT Role" value="<?php echo esc_attr( $presentRole ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="presentTenureDate">PRESENT Tenure Dates</label>
							<input type="text" class="form-control" id="presentTenureDate" name="presentTenureDate" placeholder="PRESENT Tenure Dates" value="<?php echo esc_attr( $presentTenureDate ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="futureScientificSocietyName">FUTURE Scientific Society Name</label>
							<input type="text" class="form-control" id="futureScientificSocietyName" name="futureScientificSocietyName" placeholder="FUTURE Scientific Society Name" value="<?php echo esc_attr( $futureScientificSocietyName ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="futureCommitteeName">FUTURE Committee Name</label>
							<input type="text" class="form-control" id="futureCommitteeName" name="futureCommitteeName" placeholder="FUTURE Committee Name" value="<?php echo esc_attr( $futureCommitteeName ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="futureRole">FUTURE Role</label>
							<input type="text" class="form-control" id="futureRole" name="futureRole" placeholder="FUTURE Role" value="<?php echo esc_attr( $futureRole ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="futureTenureDate">FUTURE Tenure Dates</label>
							<input type="text" class="form-control" id="futureTenureDate" name="futureTenureDate" placeholder="FUTURE Tenure Dates" value="<?php echo esc_attr( $futureTenureDate ); ?>">
						</div>
					</div>
				</div>

			</div>
		</div>

		<div class="dfr__bodyfields">
			<h3>National Scientific Guidelines/Consensus Statements: <small> Please include the name of the society that you represented on the document e.g. PACES representative <strong>(if applicable)</strong></small></h3>
			<div class="dfr_form">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="pastNationalScientificGuideName">Name of PAST National Scientific Guidelines/Consensus Statements</label>
							<input type="text" class="form-control" id="pastNationalScientificGuideName" name="pastNationalScientificGuideName" value="<?php echo esc_attr( $pastNationalScientificGuideName ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="pastSocietyRepresentName">Name of PAST Society that you represented</label>
							<input type="text" class="form-control" id="pastSocietyRepresentName" name="pastSocietyRepresentName" value="<?php echo esc_attr( $pastSocietyRepresentName ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="presentNationalScientificGuideName">Name of PRESENT National Scientific Guidelines/Consensus Statements</label>
							<input type="text" class="form-control" id="presentNationalScientificGuideName" name="presentNationalScientificGuideName" value="<?php echo esc_attr( $presentNationalScientificGuideName ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="presentSocietyRepresentName">Name of PRESENT Society that you represent</label>
							<input type="text" class="form-control" id="presentSocietyRepresentName" name="presentSocietyRepresentName" value="<?php echo esc_attr( $presentSocietyRepresentName ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="futureNationalScientificGuideName">Name of FUTURE National Scientific Guidelines/Consensus Statements</label>
							<input type="text" class="form-control" id="futureNationalScientificGuideName" name="futureNationalScientificGuideName" value="<?php echo esc_attr( $futureNationalScientificGuideName ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="futureSocietyRepresentName">Name of FUTURE Society that you will represent</label>
							<input type="text" class="form-control" id="futureSocietyRepresentName" name="futureSocietyRepresentName" value="<?php echo esc_attr( $futureSocietyRepresentName ); ?>">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="dfr__bodyfields">
			<h3>GRANTS</h3>
			<div class="dfr_form">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="presentGrantInfo">Please enter the PRESENT grant information</label>
							<input type="text" class="form-control" id="presentGrantInfo" name="presentGrantInfo" value="<?php echo esc_attr( $presentGrantInfo ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="presentGrantRole">Enter the PRESENT grant role</label>
							<input type="text" class="form-control" id="presentGrantRole" name="presentGrantRole" value="<?php echo esc_attr( $presentGrantRole ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="pastGrantInfo">Please enter the PAST grant information</label>
							<input type="text" class="form-control" id="pastGrantInfo" name="pastGrantInfo" value="<?php echo esc_attr( $pastGrantInfo ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="pastGrantRole">Enter the PAST grant role</label>
							<input type="text" class="form-control" id="pastGrantRole" name="pastGrantRole" value="<?php echo esc_attr( $pastGrantRole ); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="futureGrantInfo">Please enter the FUTURE grant information</label>
							<input type="text" class="form-control" id="futureGrantInfo" name="futureGrantInfo" value="<?php echo esc_attr( $futureGrantInfo ); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="futureGrantRole">Enter the FUTURE grant role</label>
							<input type="text" class="form-control" id="futureGrantRole" name="futureGrantRole" value="<?php echo esc_attr( $futureGrantRole ); ?>">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="dfr__bodyfields">
			<!-- <h3>GRANTS</h3> -->
			<div class="dfr_form">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group pace-checks">
							<label>PACES Interests: Check all that apply</label>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="pacesInterests1" name="pacesInterests[]" value="scientific_guidelines" <?php echo in_array('scientific_guidelines', $pacesInterests) ? 'checked' : ''; ?>>
								<label for="pacesInterests1">Scientific guidelines </label>
							</span>
							<span class="gwt-CheckBox">							
								<input type="checkbox" class="form-control" id="pacesInterests2" name="pacesInterests[]" value="education" <?php echo in_array('education', $pacesInterests) ? 'checked' : ''; ?>> 
								<label for="pacesInterests2">Education</label>
							</span>
							<span class="gwt-CheckBox">							
								<input type="checkbox" class="form-control" id="pacesInterests3" name="pacesInterests[]" value="research_collab" <?php echo in_array('research_collab', $pacesInterests) ? 'checked' : ''; ?>> 
								<label for="pacesInterests3">Research collaboration</label>
							</span>
							<span class="gwt-CheckBox">							
								<input type="checkbox" class="form-control" id="pacesInterests4" name="pacesInterests[]" value="international_liaison" <?php echo in_array('international_liaison', $pacesInterests) ? 'checked' : ''; ?>> 
								<label for="pacesInterests4">International Liaison </label>
							</span>
							<span class="gwt-CheckBox">							
								<input type="checkbox" class="form-control" id="pacesInterests5" name="pacesInterests[]" value="scientific_review" <?php echo in_array('scientific_review', $pacesInterests) ? 'checked' : ''; ?>> 
								<label for="pacesInterests5">Scientific Review</label>
							</span>
							<span class="gwt-CheckBox">							
								<input type="checkbox" class="form-control" id="pacesInterests6" name="pacesInterests[]" value="professional_networking" <?php echo in_array('professional_networking', $pacesInterests) ? 'checked' : ''; ?>> 
								<label for="pacesInterests6">Professional Networking </label>
							</span>
							<span class="gwt-CheckBox">							
								<input type="checkbox" class="form-control" id="pacesInterests7" name="pacesInterests[]" value="mentoring" <?php echo in_array('mentoring', $pacesInterests) ? 'checked' : ''; ?>> 
								<label for="pacesInterests7">Mentoring</label>
							</span>
							<span class="gwt-CheckBox">							
								<input type="checkbox" class="form-control" id="pacesInterests8" name="pacesInterests[]" value="administration" <?php echo in_array('administration', $pacesInterests) ? 'checked' : ''; ?>> 
								<label for="pacesInterests8">Administration</label>
							</span>
							<span class="gwt-CheckBox">							
								<input type="checkbox" class="form-control" id="pacesInterests9" name="pacesInterests[]" value="happy_to_be" <?php echo in_array('happy_to_be', $pacesInterests) ? 'checked' : ''; ?>> 
								<label for="pacesInterests9">Happy to be a member </label>
							</span>
							<span class="gwt-CheckBox">							
								<input type="checkbox" class="form-control" id="pacesInterests10" name="pacesInterests[]" value="qa_qi" <?php echo in_array('qa_qi', $pacesInterests) ? 'checked' : ''; ?>> 
								<label for="pacesInterests10">QA/QI</label>
							</span>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group pace-checks">
							<label>Relationship with Industry</label>
							<span class="gwt-CheckBox">
								<input type="checkbox" class="form-control" id="relationshipIndustry1" name="relationshipIndustry[]" value="yes" <?php echo in_array('yes', $relationshipIndustry) ? 'checked' : ''; ?>>
								<label for="relationshipIndustry1">Yes</label>
							</span>
							<span class="gwt-CheckBox">							
								<input type="checkbox" class="form-control" id="relationshipIndustry2" name="relationshipIndustry[]" value="no" <?php echo in_array('no', $relationshipIndustry) ? 'checked' : ''; ?>> 
								<label for="relationshipIndustry2">No</label>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="dfr__bodyfields">
			<!-- <h3>GRANTS</h3> -->
			<div class="dfr_form">
				<div class="row">
					<div class="col-sm-12">
						<div class="avatar-edit contact">
								<div class="btnnn">
									<img src="<?php echo esc_url($contact_card_icon); ?>" alt="img">
								</div>
								<div class="avatar-preview">
									<div id="imagePreview"></div>
								</div>
								<div class="pr_user_img_cont_wrapper">
									<label for="upload_contact">Upload/Change Contact Card</label>
									<input type='file' id="upload_contact" name="upload_contact" accept=".png, .jpg, .jpeg, .svg" />
								 </div>
							</div>
					</div>
				</div>
			</div>
		</div>

		<div class="dfr__bodyfields">
			<!-- <h3>GRANTS</h3> -->
			<div class="dfr_form">
				<div class="row">
					<div class="col-sm-12">
						<p>** Please note that at this time we are simply asking you to self identify any relationships with industry. We are not collecting detailed information on the membership profile form. The responsibility for identifying and disclosing information related to any given activity within PACES or another partner society (such as HRS, ACC, AHA) is that of the member. </p>
						<p>Please confirm the above information is correct by clicking the Save button below.</p>
					</div>
				</div>
			</div>
		</div>

		<div class="dfr__bodyfields ">
			<div class="dfr_form submit_row">
				<div class="row">
					<div class="col-sm-12">
						<input type="submit" name="submit" id="save_data" value="Save">
					</div>
				</div>
			</div>
		</div>

	</div>
	<input type="hidden" name="user_email" value="<?php echo esc_attr( $user->user_email ); ?>" />
	<input type="hidden" name="user_id" value="<?php echo esc_attr( $user->ID ); ?>" />
	<input type="hidden" name="action" value="edit_save_profile_data" />
	<input type="hidden" name="redirect" value="<?php echo $ref_url; ?>">

</form>
	<script>
		( function($){
			function readURL(input) {
				var parentDiv = $(input).parents('.avatar-edit');
				console.log(parentDiv);
				console.log(input);
				if (input.files && input.files[0]) {
					var reader = new FileReader();
					reader.onload = function(e) {
						parentDiv.find('#imagePreview').css('background-image', 'url('+e.target.result +')');
						parentDiv.find('#imagePreview').hide();
						parentDiv.find('#imagePreview').fadeIn(650);
					}
					reader.readAsDataURL(input.files[0]);
				}
			}
			jQuery("#upload_photo").change(function() {
				readURL(this);
			});
			jQuery("#upload_contact").change(function() {
				readURL(this);
			});
		} )(jQuery);
	</script>
	</div>
	<?php

}

