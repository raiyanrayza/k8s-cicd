<?php






/*
 * Mailpoet Plugin Changes
 */

function paces_mailPoet_subscribe_to_list($user_id, $list_ids){
	$option = array('send_confirmation_email' => false, 'schedule_welcome_email' => false);
	if (class_exists(\MailPoet\API\API::class)) {
		$mailpoet_api = \MailPoet\API\API::MP('v1');		 	

		// Get user details
		$user = get_user_by('id', $user_id);

		if (!$user) {
			return;
		}

		$email 			= $user->user_email;
		$user_login 	= $user->user_login;
		$first_name 	= $user->first_name;
		$last_name 		= $user->last_name;

		// If first name is empty give it the username
		$first_name 	= $first_name ? $first_name : $user_login;

		// Check if subscriber exists. If subscriber doesn't exist an exception is thrown
		try {
			$get_subscriber = $mailpoet_api->getSubscriber($email);
		} catch (\Exception $e) {}

		try {
			if (!$get_subscriber) {
			  // Subscriber doesn't exist let's create one
			  $mailpoet_api->addSubscriber([
									        'email' => $email,
									        'first_name' => $first_name,
									        'last_name' => $last_name,
									      ], $list_ids, $option);

			} else {
			  // In case subscriber exists just add him to new lists
			  $mailpoet_api->subscribeToLists($email, $list_ids, $option);
			}
		} catch (\Exception $e) {
			// $error_message = $e->getMessage(); 
		}
		paces_mailPoet_confirme_subscriber($user_id);
	}
	return true;
}

function paces_mailPoet_unsubscribe_from_list($user_id, $list_ids){
	if (class_exists(\MailPoet\API\API::class)) {
		$mailpoet_api = \MailPoet\API\API::MP('v1');		 	

		// Get user details
		$user = get_user_by('id', $user_id);

		if (!$user) {
			return;
		}

		$email 			= $user->user_email;
		$user_login 	= $user->user_login;
		$first_name 	= $user->first_name;
		$last_name 		= $user->last_name;

		// If first name is empty give it the username
		$first_name 	= $first_name ? $first_name : $user_login;

		// Check if subscriber exists. If subscriber doesn't exist an exception is thrown
		try {
			$get_subscriber = $mailpoet_api->getSubscriber($email);
		} catch (\Exception $e) {}

		try {
			if ($get_subscriber) {
			  $mailpoet_api->unsubscribeFromLists($email, $list_ids);

			}
		} catch (\Exception $e) {
			// $error_message = $e->getMessage(); 
		}
	}

	return true;
}

function paces_mailPoet_confirme_subscriber($user_id){
	global $wpdb;
	$table = $wpdb->prefix. 'mailpoet_subscribers';
	$update = array('status'=>'subscribed');
	$where = array('wp_user_id'=> $user_id);

	if( $wpdb->get_row("SELECT * FROM $table WHERE wp_user_id = '$user_id'") ){
		$wpdb->update($table, $update, $where);
	}
}