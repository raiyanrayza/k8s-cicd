<?php
// Add user in newsletters subscriber list for mailpoet on contact from 7 submit.

add_action( 'wpcf7_before_send_mail', 'wpcf7_before_send_mail_add_to_mailPoet_newsletters' );

function wpcf7_before_send_mail_add_to_mailPoet_newsletters( $contact_form ){
	if (class_exists(\MailPoet\API\API::class)) {
		$mailpoet_api = \MailPoet\API\API::MP('v1');

		if ( class_exists( 'WPCF7_Submission' ) && class_exists( 'WPCF7_FormTagsManager' ) ) {
			//Get submited form data
			$submission  = WPCF7_Submission::get_instance();
			$posted_data = ( $submission ) ? $submission->get_posted_data() : null;
			$option = array('send_confirmation_email' => false, 'schedule_welcome_email' => false);

			if( isset( $posted_data['mail_poet_fld'] ) && !empty( $posted_data['mail_poet_fld'] ) ){
				$mp_list_id = $posted_data['mail_poet_fld'];
				$name = trim( $posted_data['your-name'] );
				$email = trim( $posted_data['your-email'] );
				$list_ids[] = $mp_list_id;
				// Check if subscriber exists. If subscriber doesn't exist an exception is thrown
				try {
					$get_subscriber = $mailpoet_api->getSubscriber($email);
				} catch (\Exception $e) {}

				try {
					if (!$get_subscriber) {
					  // Subscriber doesn't exist let's create one
					  $mailpoet_api->addSubscriber([
											        'email' => $email,
											        'first_name' => $name
											      ], $list_ids, $option);

					} else {
					  // In case subscriber exists just add him to new lists
					  $mailpoet_api->subscribeToLists($email, $list_ids, $option);
					}
				} catch (\Exception $e) {
					// $error_message = $e->getMessage(); 
				}
			}
		} else {
			return;
		}
	}
}
