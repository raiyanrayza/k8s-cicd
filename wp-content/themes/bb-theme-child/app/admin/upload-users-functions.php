<?php
add_action('admin_menu', 'upload_users_admin_menu');
function upload_users_admin_menu() {
	$menu_hook = add_submenu_page( 
					'users.php',
			        __( 'Upload users' ),
			        'Import Users',
			        'manage_options',
			        'paces-user-upload',
			        'paces_custom_user_upload',
			        ''
			    ); 
	
	add_action( 'admin_print_styles-' . $menu_hook, 'manage_upload_users_style' );
	add_action( 'admin_print_scripts-' . $menu_hook, 'manage_upload_users_script' );
}

function manage_upload_users_style() {
	if( class_exists( 'FLLayout' ) )
		FLLayout::enqueue_framework();	
    wp_enqueue_style( 'add_users_css', get_stylesheet_directory_uri() . '/css/add_users.css' );
}

function manage_upload_users_script() {
    wp_enqueue_script( 'add_users_script', get_stylesheet_directory_uri() . '/js/add_users.js', array(), time(), true );
}

function paces_custom_user_upload() { 
	global $wpdb;
	?>
    <div class="wrap">
        <h1><?php _e( 'Upload users' ); ?></h1>
        <?php 
        /*if(isset($_GET['upload']) && $_GET['upload'] == 'success' ){
        	?>
        	<div class="notice notice-success is-dismissible">
		        <p><?php _e( 'Done!', 'sample-text-domain' ); ?></p>
		    </div>
        	<?php
        }*/
        ?>
        <div class="main_div">
        	<div class="row">
        		<div class="col-sm-6">
		        	<div class="div_left">
		        		<div  class="show_form_div">
							<h3>Upload users</h3>
							<form name="add_paces_users" id="add_paces_users" method="post" action="<?php echo admin_url( 'admin.php?page=paces-user-upload' ); ?>" enctype="multipart/form-data">
							<div class="entry-form">
								<div class="form-group">
									<label>Choose csv file</label>
									<input type="file" name="user_csv_import" class="form-control" id="user_csv_import" accept=".csv">

								</div>

									<div class="form-group">
										<input type="hidden" name="action" value="add_paces_users">
												<?php wp_nonce_field( 'add_paces_users', '_pwpnonce' ); ?>
												<button class="button" type="submit" id="save">Save</button>
									</div>
							</div>
							</form>
						</div>
		        	</div>
		        </div>
		        <div class="col-sm-6">
		        	<div class="div_right">
		        		
		        		<div class="result_tables">
							<?php

							$number = 30; 
							$paged = (!empty($_GET['pagec'])) ? $_GET['pagec'] : 1;
							$offset = (intval($paged) - 1) * $number; 

							$query_args = array(
											'meta_key'=>'imported_users',
											'meta_value'=>true,
											'meta_compare'=>'='
										);

							$mail_sent_args = array(
											'meta_key'=>'password_mail_sent',
											'meta_value'=>'true',
											'meta_compare'=>'='
										);
							$mail_notsent_args = array(
											'meta_key'=>'password_mail_sent',
											'meta_value'=>'true',
											'meta_compare'=>'!='
										);
							$mail_sent_users = get_users( $mail_sent_args );
							$mail_notsent_users = get_users( $mail_notsent_args );

							$users = get_users( $query_args );
							
							$args = array(
								 'offset' => $offset,
								 'number' => $number,
								 'meta_key'=>'password_mail_sent',
								 'orderby' => 'meta_value',
								 'order' => 'ASC',
								 'fields' => array( 'ID', 'user_login', 'user_email' ),
								 'meta_query' => array(
												'key' => 'imported_users',
												'meta_value'=>true,
												'meta_compare'=>'=',
											)
							);

							$query = get_users($args);
							$total_users = count($users);
							$total_query = count($query);
							$total_pages = ($total_users / $number);
							$total_pages = is_float($total_pages) ? intval($total_users / $number) + 1 : intval($total_users / $number);


							if( is_array($query ) ){

								?>
								<form name="send_paces_pswd_email" id="send_paces_pswd_email" method="post" action="<?php echo admin_url( 'admin.php?page=paces-user-upload' ); ?>">
									<input type="hidden" name="action" value="send_mail_to_users">
									<input type="submit" name="submit" value="Send password mail">
									<p>Send password mail button will only trigger email to all user whom we did not send the new password mail.</p>
								</form>
								<?php echo 'Total imported users : '.$total_users. ' | Mail sent to : '.count($mail_sent_users). ' | Not sent to :'.count($mail_notsent_users) ; ?>

								<table>
									<thead>
										<th>ID</th>
										<th>username</th>
										<th>email id</th>
										<th>password email sent</th>
									</thead>
									<tbody>
										<?php
										foreach ($query as $key => $user) {
											$is_mail_sent = false;
											if( get_user_meta( $user->ID, 'password_mail_sent', true ) == 'true' ){
												$is_mail_sent = true;
											}
											?>
											<tr>
												<th><?php echo $user->ID; ?></th>
												<th><a href="<?php echo get_edit_user_link($user->ID); ?>"><?php echo $user->user_login; ?></a></th>
												<th><?php echo $user->user_email; ?></th>
												<th><?php echo ($is_mail_sent) ? 'Yes' : 'No'; ?></th>
											</tr>
											<?php
										}
										?>
									</tbody>
								</table>
								<?php
								    echo '<div id="support-pagination" class="clearfix">';
								    
									if ($total_users > $total_query) {
									    $current_page = max(1, $_GET['pagec']);
									    echo paginate_links(array(
									       'base' => get_pagenum_link(1) . '%_%',
									       'format' => '&pagec=%#%',
									       'current' => $current_page,
									       'total' => $total_pages,
									       'prev_next' => true,
									       'type' => 'list',
									    ));
									}
								 	echo '</div>';
								 ?> 
								<?php
							}
							?>
						</div>
					</div>
				</div>
        	</div>
        </div>
    </div>
    <?php
}

/* Paggination links for admin custom pages */
add_filter( 'get_pagenum_link', function($result){
	if( isset( $_GET['page'] ) && $_GET['page'] == 'paces-user-upload' ){
		return admin_url( 'users.php?page=paces-user-upload' );
	}else{
		return $result;
	}
}, 10, 1 );

function send_pswd_mail_to_imported_users( $user ){
	$to = $user->user_email;
	$mail_attachment = array();
	$subject = '';
	$message = '';
	$userpass = get_user_meta( $user->ID, 'temp_password', true );
	
	if( get_field( 'send_password_to_imported_users', 'option' ) ){
		$mail_attachment = array(FL_CHILD_THEME_DIR . '/images/PACES-New-website-announcement.pdf');
		$content = get_field( 'send_password_to_imported_users', 'option' );
		$subject = $content['subject'];
		$message = apply_filters( 'replace_paces_site_url', $content['content'] );
		$data = array('user_name'=> $user->user_login, 'user_link'=>site_url( '/login/' ), 'user_password' => $userpass );
		$message = fetch_replace_code_data( $message, $data );

	}else{

		$subject = 'welcome to new paces site';
		$message = 'Hi <br> your new username is '.$user->user_login.' with password : '.$userpass.'<br>login here '.site_url( '/login/' );

	}

	$headers = ['Content-Type: text/html; charset=UTF-8'];
	if( $to ){
		if( wp_mail( $to, $subject, $message, $headers, $mail_attachment ) ){
			update_user_meta( $user->ID, 'password_mail_sent', 'true' );
		}else{
			
		}
	}
}

add_action( 'admin_init', 'process_add_paces_users' );
function process_add_paces_users(){
	global $wpdb;
	if( isset( $_POST['action'] ) && $_POST['action'] == 'send_mail_to_users' ){
		$users_list = get_users(array('meta_key'=>'password_mail_sent', 'meta_value'=>'false', 'meta_compare'=>'='));
		if( $users_list ){
			foreach ($users_list as $key => $user) {				
				send_pswd_mail_to_imported_users($user);				
			}
		}
	}
	
	if( isset( $_POST['action'] ) && $_POST['action'] == 'add_paces_users' ){
	    // Check for current user privileges 
	    if( !current_user_can( 'manage_options' ) ){ return false; }

	    // Check if we are in WP-Admin
	    if( !is_admin() ){ return false; }

	    // Nonce Check
	    $nonce = isset( $_POST['_pwpnonce'] ) ? $_POST['_pwpnonce'] : '';
	    if ( ! wp_verify_nonce( $nonce, 'add_paces_users' ) ) {
	    	echo 'error';
	        die();
	    }
	    
	    $csv = array();
		
		if($_FILES['user_csv_import']['error'] == 0){
		    $name = $_FILES['user_csv_import']['name'];
		    $flname = explode('.', $_FILES['user_csv_import']['name']);
		    $ext = strtolower(end($flname));
		    $type = $_FILES['user_csv_import']['type'];
		    $tmpName = $_FILES['user_csv_import']['tmp_name'];
		    
		    /* check the file is a csv */
		    if($ext === 'csv'){

		        if( ( $handle = @fopen($tmpName, "r") ) !== FALSE ) {
		            // necessary if a large csv file 
		            set_time_limit(0);
		            $count = 0;
		            while ( ($row = fgetcsv($handle, 0) ) !== false ) {
		            // while(($data = fgetcsv($handle, 1000, ',')) !== FALSE) {  

		                if($count > 0){                
			                $user_custom_data = array();
			                $user_custom_data['Customer_ID'] = $row[0];
			                $user_custom_data['user_login'] = $row[1];
			                $user_custom_data['user_email'] = $row[2];
			                $user_custom_data['prefer_email'] = $row[4];
			                $user_custom_data['member_subclass'] = $row[5];
			                $user_custom_data['display_names'] = $row[9];
			                $user_custom_data['salutation'] = $row[10];
			                $user_custom_data['first_name'] = $row[11];
			                $user_custom_data['middle_name'] = $row[12];
			                $user_custom_data['last_name'] = $row[13];
			                $user_custom_data['suffix'] = $row[14];
			                $user_custom_data['degree'] = $row[15];
			                $user_custom_data['company'] = $row[16];
			                
			                $user_custom_data['address_line_1'] = $row[22];
			                $user_custom_data['address_line_2'] = $row[23];
			                $user_custom_data['address_line_3'] = $row[24];
			                $user_custom_data['city'] = $row[25];
			                $user_custom_data['state'] = $row[26];
			                $user_custom_data['postal_code'] = $row[27];
			                $user_custom_data['country'] = $row[28];

			                
			                $user_custom_data['prefer_phone'] = $row[31];
			                $user_custom_data['fax_phone'] = $row[32];
			                // $user_custom_data['fax_phone_ext'] = $row[0];
			                $user_custom_data['home_phone'] = $row[33];
			                // $user_custom_data['home_phone_ext'] = $row[0];
			                $user_custom_data['work_phone'] = $row[34];
			                // $user_custom_data['work_phone_ext'] = $row[0];
			                $user_custom_data['website_address'] = $row[35];


			                $user_custom_data['address_contact_text2'] = $row[19];
			                $user_custom_data['address_contact_text1'] = $row[20];

			                $user_custom_data['prefered_phone_number'] = $row[29];

			                /*$user_custom_data['sec_address_line_1'] = $row[0];
			                $user_custom_data['sec_address_line_2'] = $row[0];
			                $user_custom_data['sec_address_line_3'] = $row[0];
			                $user_custom_data['sec_city'] = $row[0];
			                $user_custom_data['sec_state'] = $row[0];
			                $user_custom_data['sec_postal_code'] = $row[0];
			                $user_custom_data['sec_country'] = $row[0];

			                $user_custom_data['prefer_add'] = $row[0];

			                $user_custom_data['department'] = $row[0];
			                

			                $user_custom_data['hospitalPosition'] = $row[0];
			                $user_custom_data['hospitalName'] = $row[0];

			                $user_custom_data['universityName'] = $row[0];
			                $user_custom_data['academicRankOtherText'] = $row[0];
			                $user_custom_data['institutionIsEPFellowship'] = $row[0];

			                $user_custom_data['publication1'] = $row[0];
			                $user_custom_data['publication_pmid1'] = $row[0];
			                $user_custom_data['publication2'] = $row[0];
			                $user_custom_data['publication_pmid2'] = $row[0];
			                $user_custom_data['publication3'] = $row[0];
			                $user_custom_data['publication_pmid3'] = $row[0];
			                $user_custom_data['publication4'] = $row[0];
			                $user_custom_data['publication_pmid4'] = $row[0];
			                $user_custom_data['publication5'] = $row[0];
			                $user_custom_data['publication_pmid5'] = $row[0];


			                $user_custom_data['pastScientificSocietyName'] = $row[0];
			                $user_custom_data['pastCommitteeName'] = $row[0];
			                $user_custom_data['pastRole'] = $row[0];
			                $user_custom_data['pastTenureDate'] = $row[0];
			                $user_custom_data['presentScientificSocietyName'] = $row[0];
			                $user_custom_data['presentRole'] = $row[0];
			                $user_custom_data['presentTenureDate'] = $row[0];
			                $user_custom_data['futureScientificSocietyName'] = $row[0];
			                $user_custom_data['futureCommitteeName'] = $row[0];
			                $user_custom_data['futureRole'] = $row[0];
			                $user_custom_data['futureTenureDate'] = $row[0];
			                $user_custom_data['pastNationalScientificGuideName'] = $row[0];
			                $user_custom_data['pastSocietyRepresentName'] = $row[0];

			                $user_custom_data['presentNationalScientificGuideName'] = $row[0];
			                $user_custom_data['presentSocietyRepresentName'] = $row[0];
			                $user_custom_data['futureNationalScientificGuideName'] = $row[0];
			                $user_custom_data['futureSocietyRepresentName'] = $row[0];
			                $user_custom_data['presentGrantInfo'] = $row[0];
			                $user_custom_data['presentGrantRole'] = $row[0];
			                $user_custom_data['pastGrantInfo'] = $row[0];
			                $user_custom_data['pastGrantRole'] = $row[0];
			                $user_custom_data['futureGrantInfo'] = $row[0];
			                $user_custom_data['futureGrantRole'] = $row[0];

			                $user_custom_data['academicRank'] = $row[0];
			                $user_custom_data['researchAreas'] = $row[0];
			                $user_custom_data['pacesInterests'] = $row[0];
			                $user_custom_data['relationshipIndustry'] = $row[0];*/


			                /*echo '<pre>';
			                print_r($user_custom_data);
			                
			                unset($user_custom_data['first_name']);
			                unset($user_custom_data['Customer_ID']);
			                print_r($user_custom_data);
			                echo "</pre>";*/

		                	// inster user here
		                	$user_custom_data['pc_membership_status'] = $row[7];
		                	$user_custom_data['pc_membership_exp'] = $row[8];

		                	$membership_levels = pmpro_paces_membership_levels_id_array();

		                	$membership_id = $row[5];
		                	$membership_status = $row[7];
		                	$exp_date = $row[8];
		                	if( isset( $membership_levels[$membership_id] ) )
		                		$membership_id = $membership_levels[$membership_id];
		                	$user_id = '';
		                	if( !empty( $user_custom_data['user_email'] ) ){
				            	if( ($user_id = add_create_users( $user_custom_data )) ){

				            		$pmpro_user_rowid = custom_pmpro_order_create_assign_membership_using_check($user_id,$membership_id,$exp_date);
				            		
				            		if( $membership_status == 'ACTIVE' ){
				            			update_user_meta( $user_id, 'approved_by_admin', '1' );
				            			update_user_meta( $user_id, 'pay_approved_by_admin', '1' );
				            		}else{
				            			update_user_meta( $user_id, 'approved_by_admin', '0' );
				            			update_user_meta( $user_id, 'pay_approved_by_admin', '0' );
				            			update_user_meta( $user_id, '_user_status', 'TERMINATED' );
				            			$sql = "UPDATE $wpdb->pmpro_memberships_users SET `status`='expired' WHERE `id`=" . $pmpro_user_rowid;
				            			$wpdb->query( $sql );

				            		}
				            		paces_mailPoet_unsubscribe_from_list( $user_id, array('10') );
									paces_mailPoet_subscribe_to_list( $user_id, array( '8','9' ) );
				            		update_user_meta( $user_id, 'imported_users', true );
				            	}
		                	}

			            }
		                // inc the row 
		                $count++;
		            }
		            fclose($handle);
		            // echo "success";
		        }
		        /*else{
		        	echo "error";
		        }*/
		    }
		    /*else{
		    	echo "error";
			}*/

		}
		/*else{
			echo "error";
		}*/
		if( !isset( $_GET['upload'] ) ){
	    	wp_redirect( add_query_arg( 'upload', 'success', admin_url( 'admin.php?page=' . 'paces-user-upload' ) ) );
	    	exit;
		}
	    
	}
}


function pmpro_paces_membership_levels_id_array(){
	return array(
		'PE_ASSO' => 6,
		'PE_FELL' => 7,
		'PE_AFF' => 8,
		'PE_FULL' => 9,
		'PE_EMER' => 10,
		'PE_INTL' => 11,
		'PE_COMP' => 12
	);
}

function sample_admin_notice__error() {
    $screen = get_current_screen();
 
    if ( $screen->id !== 'users_page_paces-user-upload') return;
    if ( isset( $_GET['upload'] ) ) {
        if ( 'success' === $_GET['upload'] ) : ?>
            <div class="notice notice-success is-dismissible">
                <p><strong><?php _e('User imported successfully.', 'textdomain') ?></strong></p>
            </div>
        <?php else : ?>
            <div class="notice notice-warning is-dismissible">
                <p><strong><?php _e('Sorry, I can not go through this.', 'textdomain') ?></strong></p>
            </div>
        <?php endif;
    }
}
add_action( 'admin_notices', 'sample_admin_notice__error' );


function add_create_users($user_data){
	if( isset( $user_data['user_login'] ) && !empty( $user_data['user_login'] ) && isset( $user_data['user_email'] ) && !empty( $user_data['user_email'] )  ){
		if( !username_exists( $user_data['user_login'] ) || !email_exists( $user_data['user_email'] ) ){
			$userLogin = $user_data['user_login'];
			$userEmail = $user_data['user_email'];
			$userFname = $user_data['first_name'];
			$userLname = $user_data['last_name'];
			$userPass = wp_generate_password( 10, true, true );
			$userdata = array(
		        'user_login' => $user_data['user_login'],
		        'user_email' => $user_data['user_email'],
		        'first_name' => $user_data['first_name'],
		        'last_name'   => $user_data['last_name'],
		        'user_pass'  => $userPass
		    );
		 
		    $user_id = wp_insert_user( $userdata ) ;
		  
		    // Return
		    if( !is_wp_error($user_id) ) {
		    	update_user_meta( $user_id, 'temp_password', $userPass );
		    	
		    	if( !get_user_meta( $user_id, 'ep_special_post_id', true ) ){

		    		$epid_title = $user_data['display_names'];

		    		if( empty( $epid_title ) ){
		    			$epid_title = $user_data['first_name']. ' '.$user_data['last_name']. ' '.$user_data['degree'];
		    		}
		    		if( empty( $epid_title ) ){
		    			$epid_title = $userLogin;
		    		}

		    		$membr_status = $user_data['pc_membership_status'];
		    		$pid_status = ($membr_status == 'ACTIVE') ? 'publish' : 'draft';
		    		$my_post = array(
					  'post_title'    => wp_strip_all_tags( $epid_title ),
					  'post_status'   => $pid_status,
					  'post_type' 	=> 'ep-specialist'
					);
					 
					// Insert the post into the database
					$pid = wp_insert_post( $my_post );	
					if(!is_wp_error($pid)){
					  // post saved
						update_post_meta( $pid, 'user_id', $user_id );
						update_field( 'display_name', sanitize_text_field( $user_data['display_names'] ), $pid );
						update_user_meta( $user_id, 'ep_special_post_id', $pid );
						update_user_meta( $user_id, 'ep_special', 'true' );

						unset( $user_data['display_names'] );
						
						foreach ($user_data as $key => $value) {
				    		$mvalue = $value;
				    		$mkey = $key;
				    		if( $key == 'prefer_email' ){
				    			update_field( 'email', sanitize_text_field( $mvalue ), $pid );
				    		}else if( $key == 'address_contact_text2' || $key == 'address_contact_text1' || $key == 'user_email' || $key == 'pc_membership_status' || $key == 'pc_membership_exp' ){
				    			// update_field( $key, sanitize_text_field( $mvalue ), $pid );
				    		}else if( $key == 'prefered_phone_number' ){
				    			update_field( 'work_phone', sanitize_text_field( $mvalue ), $pid );				    			
				    		}else{
				    			update_field( $key, sanitize_text_field( $mvalue ), $pid );
				    		}
				    	}

					}
				}

				unset( $user_data['user_login'] );
		    	unset( $user_data['user_email'] );
		    	unset( $user_data['first_name'] );
		    	unset( $user_data['last_name'] );

		    	foreach ($user_data as $key => $value) {
		    		$mvalue = $value;
		    		$mkey = $key;
		    		// echo $mkey.'-'.$mvalue;
		    		update_user_meta( $user_id, $key, $mvalue );
		    	}
		    	update_user_meta( $user_id, 'password_mail_sent', 'false' );
		    	return $user_id;
		    }else{
		    	return false;
		    }
		}else{
			return false;
		}
	}else{
		return false;
	}
	
}
