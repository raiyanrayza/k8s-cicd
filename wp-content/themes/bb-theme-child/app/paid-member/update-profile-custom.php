<?php


// Update EP Specialist custom post type if user updated fron front end.

add_action( 'pmpro_personal_options_update', 'paces_update_cpt_ep_specialist_info', 10, 1 );
function paces_update_cpt_ep_specialist_info($user_id){
	include_once( ABSPATH . 'wp-admin/includes/image.php' );
	$wordpress_upload_dir = wp_upload_dir();
	
	if(empty($_POST['action'])){
		return true;
	}
	$user_data = get_user_by( 'ID', $user_id );
	$email = sanitize_email( $_POST['user_email'] );
	$inputSalutation  = sanitize_text_field($_POST['inputSalutation']);
    $inputSuffix = sanitize_text_field($_POST['inputSuffix']);
    $inputMiddlename = sanitize_text_field($_POST['inputMiddlename']);

    $inputEmployer = sanitize_text_field($_POST['inputEmployer']);
    $inputDegree = sanitize_text_field($_POST['inputDegree']);
    $inputDepartment = sanitize_text_field($_POST['inputDepartment']);
    
    $inputAddress1 = sanitize_text_field($_POST['inputAddress1']);
    $inputAddress2 = sanitize_text_field($_POST['inputAddress2']);
    $inputAddress3 = sanitize_text_field($_POST['inputAddress3']);
    $inputCity = sanitize_text_field($_POST['inputCity']);
    $inputState = sanitize_text_field($_POST['inputState']);
    $inputPostalCode = sanitize_text_field($_POST['inputPostalCode']);
	$inputCountry = sanitize_text_field($_POST['inputCountry']);
    
    $inputWorkPhone = sanitize_text_field($_POST['inputWorkPhone']);
    $inputWebsite = sanitize_text_field($_POST['inputWebsite']);
    $inputTwitter = sanitize_text_field($_POST['inputTwitter']);

    


    $inputSecAddress1 = sanitize_text_field($_POST['inputSecAddress1']);
	$inputSecAddress2 = sanitize_text_field($_POST['inputSecAddress2']);
	$inputSecAddress3 = sanitize_text_field($_POST['inputSecAddress3']);
	$inputSecCity = sanitize_text_field($_POST['inputSecCity']);
	$inputSecState = sanitize_text_field($_POST['inputSecState']);
	$inputSecPostalCode = sanitize_text_field($_POST['inputSecPostalCode']);
	$inputSecCountry = sanitize_text_field($_POST['inputSecCountry']);
	$inputPreferredAddress = sanitize_text_field($_POST['inputPreferredAddress']);
	$inputHomePhone = sanitize_text_field($_POST['inputHomePhone']);
	$inputFax = sanitize_text_field($_POST['inputFax']);
	$inputPreferredPhone = sanitize_text_field($_POST['inputPreferredPhone']);
	$inputWPExt = sanitize_text_field($_POST['inputWPExt']);
	$inputHPExt = sanitize_text_field($_POST['inputHPExt']);
	$inputFaxExt = sanitize_text_field($_POST['inputFaxExt']);
/*---------*/
	$hospitalPosition = sanitize_text_field($_POST['hospitalPosition']);
	$hospitalName = sanitize_text_field($_POST['hospitalName']);
	$universityName = sanitize_text_field($_POST['universityName']);
	
	$academicRankOtherText = sanitize_text_field($_POST['academicRankOtherText']);

	$institutionIsEPFellowship = sanitize_text_field($_POST['institutionIsEPFellowship']);
	

	$publication1 = sanitize_textarea_field($_POST['publication1']);
	$publication_pmid1 = sanitize_text_field($_POST['publication_pmid1']);

	$publication2 = sanitize_textarea_field($_POST['publication2']);
	$publication_pmid2 = sanitize_text_field($_POST['publication_pmid2']);

	$publication3 = sanitize_textarea_field($_POST['publication3']);
	$publication_pmid3 = sanitize_text_field($_POST['publication_pmid3']);

	$publication4 = sanitize_textarea_field($_POST['publication4']);
	$publication_pmid4 = sanitize_text_field($_POST['publication_pmid4']);

	$publication5 = sanitize_textarea_field($_POST['publication5']);
	$publication_pmid5 = sanitize_text_field($_POST['publication_pmid5']);

	$pastScientificSocietyName  = sanitize_text_field($_POST['pastScientificSocietyName']);
	$pastCommitteeName = sanitize_text_field($_POST['pastCommitteeName']);
	$pastRole = sanitize_text_field($_POST['pastRole']);
	$pastTenureDate = sanitize_text_field($_POST['pastTenureDate']);

	$presentScientificSocietyName = sanitize_text_field($_POST['presentScientificSocietyName']);
	$presentCommitteeName = sanitize_text_field($_POST['presentCommitteeName']);
	$presentRole = sanitize_text_field($_POST['presentRole']);
	$presentTenureDate = sanitize_text_field($_POST['presentTenureDate']);

	$futureScientificSocietyName = sanitize_text_field($_POST['futureScientificSocietyName']);
	$futureCommitteeName = sanitize_text_field($_POST['futureCommitteeName']);
	$futureRole = sanitize_text_field($_POST['futureRole']);
	$futureTenureDate = sanitize_text_field($_POST['futureTenureDate']);

	$pastNationalScientificGuideName = sanitize_text_field($_POST['pastNationalScientificGuideName']);
	$pastSocietyRepresentName = sanitize_text_field($_POST['pastSocietyRepresentName']);
	$presentNationalScientificGuideName = sanitize_text_field($_POST['presentNationalScientificGuideName']);
	$presentSocietyRepresentName = sanitize_text_field($_POST['presentSocietyRepresentName']);
	$futureNationalScientificGuideName = sanitize_text_field($_POST['futureNationalScientificGuideName']);
	$futureSocietyRepresentName = sanitize_text_field($_POST['futureSocietyRepresentName']);

	$presentGrantInfo = sanitize_text_field($_POST['presentGrantInfo']);
	$presentGrantRole = sanitize_text_field($_POST['presentGrantRole']);
	$pastGrantInfo = sanitize_text_field($_POST['pastGrantInfo']);
	$pastGrantRole = sanitize_text_field($_POST['pastGrantRole']);
	$futureGrantInfo = sanitize_text_field($_POST['futureGrantInfo']);
	$futureGrantRole = sanitize_text_field($_POST['futureGrantRole']);

	$academicRank = $_POST['academicRank'];
	$researchAreas = $_POST['researchAreas'];
	$pacesInterests = $_POST['pacesInterests'];
	$relationshipIndustry = $_POST['relationshipIndustry'];

/*---------*/

    update_user_meta( $user_id, 'salutation', $inputSalutation );
	update_user_meta( $user_id, 'suffix', $inputSuffix );
	update_user_meta( $user_id, 'middle_name', $inputMiddlename );

	update_user_meta( $user_id, 'degree', $inputDegree );
	update_user_meta( $user_id, 'department', $inputDepartment );
	
	update_user_meta( $user_id, 'company', $inputEmployer );
    update_user_meta( $user_id, 'work_phone', $inputWorkPhone );
    update_user_meta( $user_id, 'address_line_1', $inputAddress1 );
    update_user_meta( $user_id, 'address_line_2', $inputAddress2 );
    update_user_meta( $user_id, 'address_line_3', $inputAddress3 );
    update_user_meta( $user_id, 'city', $inputCity );
    update_user_meta( $user_id, 'state', $inputState );
    update_user_meta( $user_id, 'postal_code', $inputPostalCode );
    update_user_meta( $user_id, 'country', $inputCountry );
    update_user_meta( $user_id, 'website_address', $inputWebsite );

    update_user_meta( $user_id, 'sec_address_line_1', $inputSecAddress1 );
    update_user_meta( $user_id, 'sec_address_line_2', $inputSecAddress2 );
    update_user_meta( $user_id, 'sec_address_line_3', $inputSecAddress3 );
    update_user_meta( $user_id, 'sec_city', $inputSecCity );
    update_user_meta( $user_id, 'sec_state', $inputSecState );
    update_user_meta( $user_id, 'sec_postal_code', $inputSecPostalCode );
    update_user_meta( $user_id, 'sec_country', $inputSecCountry );
    update_user_meta( $user_id, 'prefer_add', $inputPreferredAddress );
    update_user_meta( $user_id, 'home_phone', $inputHomePhone );
    update_user_meta( $user_id, 'fax_phone', $inputFax );
    update_user_meta( $user_id, 'prefer_phone', $inputPreferredPhone );
    update_user_meta( $user_id, 'work_phone_ext', $inputWPExt );
    update_user_meta( $user_id, 'home_phone_ext', $inputHPExt );
    update_user_meta( $user_id, 'fax_phone_ext', $inputFaxExt );

    update_user_meta( $user_id, 'hospitalPosition', $hospitalPosition );
    update_user_meta( $user_id, 'hospitalName', $hospitalName );
    update_user_meta( $user_id, 'universityName', $universityName );
    update_user_meta( $user_id, 'academicRankOtherText', $academicRankOtherText );
    update_user_meta( $user_id, 'institutionIsEPFellowship', $institutionIsEPFellowship );
    
    update_user_meta( $user_id, 'publication1', $publication1 );
    update_user_meta( $user_id, 'publication_pmid1', $publication_pmid1 );
    update_user_meta( $user_id, 'publication2', $publication2 );
    update_user_meta( $user_id, 'publication_pmid2', $publication_pmid2 );
    update_user_meta( $user_id, 'publication3', $publication3 );
    update_user_meta( $user_id, 'publication_pmid3', $publication_pmid3 );
    update_user_meta( $user_id, 'publication4', $publication4 );
    update_user_meta( $user_id, 'publication_pmid4', $publication_pmid4 );
    update_user_meta( $user_id, 'publication5', $publication5 );
    update_user_meta( $user_id, 'publication_pmid5', $publication_pmid5 );

    update_user_meta( $user_id, 'pastScientificSocietyName', $pastScientificSocietyName );
    update_user_meta( $user_id, 'pastCommitteeName', $pastCommitteeName );
    update_user_meta( $user_id, 'pastRole', $pastRole );
    update_user_meta( $user_id, 'pastTenureDate', $pastTenureDate );
    update_user_meta( $user_id, 'presentScientificSocietyName', $presentScientificSocietyName );
    update_user_meta( $user_id, 'presentCommitteeName', $presentCommitteeName );
    update_user_meta( $user_id, 'presentRole', $presentRole );
    update_user_meta( $user_id, 'presentTenureDate', $presentTenureDate );
    update_user_meta( $user_id, 'futureScientificSocietyName', $futureScientificSocietyName );
    update_user_meta( $user_id, 'futureCommitteeName', $futureCommitteeName );
    update_user_meta( $user_id, 'futureRole', $futureRole );
    update_user_meta( $user_id, 'futureTenureDate', $futureTenureDate );
    update_user_meta( $user_id, 'pastNationalScientificGuideName', $pastNationalScientificGuideName );
    update_user_meta( $user_id, 'pastSocietyRepresentName', $pastSocietyRepresentName );

    update_user_meta( $user_id, 'presentNationalScientificGuideName', $presentNationalScientificGuideName );
    update_user_meta( $user_id, 'presentSocietyRepresentName', $presentSocietyRepresentName );
    update_user_meta( $user_id, 'futureNationalScientificGuideName', $futureNationalScientificGuideName );
    update_user_meta( $user_id, 'futureSocietyRepresentName', $futureSocietyRepresentName );
    update_user_meta( $user_id, 'presentGrantInfo', $presentGrantInfo );

    update_user_meta( $user_id, 'presentGrantRole', $presentGrantRole );
    update_user_meta( $user_id, 'pastGrantInfo', $pastGrantInfo );
    update_user_meta( $user_id, 'pastGrantRole', $pastGrantRole );
    update_user_meta( $user_id, 'futureGrantInfo', $futureGrantInfo );
    update_user_meta( $user_id, 'futureGrantRole', $futureGrantRole );

    update_user_meta( $user_id, 'academicRank', $academicRank );
    update_user_meta( $user_id, 'researchAreas', $researchAreas );
    update_user_meta( $user_id, 'pacesInterests', $pacesInterests );
    update_user_meta( $user_id, 'relationshipIndustry', $relationshipIndustry );







	$ep_post_id = get_user_meta( $user_id, 'ep_special_post_id', true );
	$upload_id = '';
	$c_upload_id = '';
	if( isset( $_FILES['upload_photo'] ) && !empty( $_FILES['upload_photo']['name'] ) ){ 
		$file = $_FILES['upload_photo'];

		$profilepicture = $file;
		$new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
		$new_file_mime = mime_content_type( $profilepicture['tmp_name'] );

		if( !empty( $profilepicture ) && in_array( $new_file_mime, get_allowed_mime_types() ) && $profilepicture['size'] < wp_max_upload_size() ){

			if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) {			 
				$upload_id = wp_insert_attachment( array(
					'guid'           => $new_file_path, 
					'post_mime_type' => $new_file_mime,
					'post_title'     => preg_replace( '/\.[^.]+$/', '', $profilepicture['name'] ),
					'post_content'   => '',
					'post_status'    => 'inherit'
				), $new_file_path );			 
				wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
			}
		}
	}

	if( isset( $_FILES['upload_contact'] ) && !empty( $_FILES['upload_contact']['name'] ) ){
		$c_file = $_FILES['upload_contact'];
		
		$contact_picture = $c_file;
		$new_cfile_path = $wordpress_upload_dir['path'] . '/' . $contact_picture['name'];
		$new_cfile_mime = mime_content_type( $contact_picture['tmp_name'] );

		if( !empty( $contact_picture ) && in_array( $new_cfile_mime, get_allowed_mime_types() ) && $contact_picture['size'] < wp_max_upload_size() ){

			if( move_uploaded_file( $contact_picture['tmp_name'], $new_cfile_path ) ) {			 
				$c_upload_id = wp_insert_attachment( array(
					'guid'           => $new_cfile_path, 
					'post_mime_type' => $new_cfile_mime,
					'post_title'     => preg_replace( '/\.[^.]+$/', '', $contact_picture['name'] ),
					'post_content'   => '',
					'post_status'    => 'inherit'
				), $new_cfile_path );			 
				wp_update_attachment_metadata( $c_upload_id, wp_generate_attachment_metadata( $c_upload_id, $new_cfile_path ) );
			}
		}
	}

    

	if(!empty($ep_post_id)){
		if(isset($_POST['first_name'])){
			update_field('first_name', sanitize_text_field($_POST['first_name']), $ep_post_id);
		}
		if(isset($_POST['last_name'])){
			update_field('last_name', sanitize_text_field($_POST['last_name']), $ep_post_id);
		}		
		if( !empty( $upload_id ) ){
			update_user_meta( $user_id, 'cusotm_avtar_id', $upload_id );
			update_field( 'picture', $upload_id, $ep_post_id);
		}
		if( !empty( $c_upload_id ) ){
			update_user_meta( $user_id, 'contact_card_vcard', $c_upload_id );
			update_field( 'contact_card_vcard', $c_upload_id, $ep_post_id);	
		}
		update_field('display_name', sanitize_text_field($_POST['display_name']), $ep_post_id);
		update_field('company', sanitize_text_field($inputEmployer), $ep_post_id);
		update_field('work_phone', sanitize_text_field($inputWorkPhone), $ep_post_id);
		update_field('email', sanitize_text_field($email), $ep_post_id);
		update_field('address_line_1', sanitize_text_field($inputAddress1), $ep_post_id);
		update_field('address_line_2', sanitize_text_field($inputAddress2), $ep_post_id);
		update_field('city', sanitize_text_field($inputCity), $ep_post_id);
		update_field('state', sanitize_text_field($inputState), $ep_post_id);
		update_field('postal_code', sanitize_text_field($inputPostalCode), $ep_post_id);
		update_field('country', sanitize_text_field($inputCountry), $ep_post_id);
		update_field('twitter_contact', sanitize_text_field($inputTwitter), $ep_post_id);
		update_field('website_address', sanitize_text_field($inputWebsite), $ep_post_id);
        
	}else{

        $epid_title = $_POST['display_name'];

        if( empty( $epid_title ) ){
			$epid_title = sanitize_text_field( $_POST['first_name'] ). ' '.sanitize_text_field( $_POST['last_name'] ).' '.$inputDegree;
        }

        if( empty( $epid_title ) ){
			$epid_title = $user_data->display_name;
        }

        $ep_status = 'draft';
        $approved_check = intval( get_user_meta($user_id,'pay_approved_by_admin',true) );
        if( $approved_check ){
        	$ep_status = 'publish';
        }else if( in_array( 'administrator', (array) $user_data->roles ) ){
        	$ep_status = 'publish';
        }

		$my_post = array(
		  'post_title'    => wp_strip_all_tags( $epid_title ),
		  'post_type' 	=> 'ep-specialist',
		  'post_status' => $ep_status
		);
		// Insert the post into the database
		$pid = wp_insert_post( $my_post );
		if(!is_wp_error($pid)){
			$pid = $pid;

			update_user_meta( $user_id, 'ep_special_post_id', $pid );
			update_post_meta( $pid, 'user_id', $user_id );

			if(isset($_POST['first_name'])){
				update_field('first_name', sanitize_text_field($_POST['first_name']), $pid);
			}
			if(isset($_POST['last_name'])){
				update_field('last_name', sanitize_text_field($_POST['last_name']), $pid);
			}
			if( !empty( $upload_id ) ){
				update_user_meta( $user_id, 'cusotm_avtar_id', $upload_id );
				update_field( 'picture', $upload_id, $pid);
			}
			if( !empty( $c_upload_id ) ){
				update_user_meta( $user_id, 'contact_card_vcard', $c_upload_id );
				update_field( 'contact_card_vcard', $c_upload_id, $pid);
			}
			update_field('display_name', sanitize_text_field($_POST['display_name']), $pid);
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

		if( !empty( $upload_id ) ){
			update_user_meta( $user_id, 'cusotm_avtar_id', $upload_id );
		}
		if( !empty( $c_upload_id ) ){
			update_user_meta( $user_id, 'contact_card_vcard', $c_upload_id );
		}
	}
	
}