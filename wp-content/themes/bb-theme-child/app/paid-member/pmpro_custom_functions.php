<?php

function custom_pmpro_order_create_assign_membership_using_check($user_id_x, $level_id_x, $exp_date){
	global $post, $gateway, $wpdb, $besecure, $discount_code, $discount_code_id, $pmpro_level, $pmpro_levels, $pmpro_msg, $pmpro_msgt, $pmpro_review, $skip_account_fields, $pmpro_paypal_token, $pmpro_show_discount_code, $pmpro_error_fields, $pmpro_required_billing_fields, $pmpro_required_user_fields, $wp_version, $current_user, $pmpro_requirebilling, $tospage, $username, $password, $password2, $bfirstname, $blastname, $baddress1, $baddress2, $bcity, $bstate, $bzipcode, $bcountry, $bphone, $bemail, $bconfirmemail, $CardType, $AccountNumber, $ExpirationMonth, $ExpirationYear, $pmpro_states, $recaptcha, $recaptcha_privatekey, $CVV;

	if(empty($user_id_x)) return false;
	
	if(empty($level_id_x) || !intval($level_id_x)){
		return false;
	}
	// return $mem_level;
	$pmpro_level_x = new PMPro_Membership_Level( $level_id_x );
	/*echo '<pre>';
	print_r($pmpro_level_x);
	echo "</pre>";*/

	$bemail = get_user_meta( $user_id_x, 'user_email', true );
	$doit = new PMProGateway('check');
	$user_data = get_user_by( 'ID', $user_id_x );
	
	// // return;
	$morder                   = new MemberOrder();
	$morder->membership_id    = $pmpro_level_x->id;
	$morder->membership_level = $pmpro_level_x->id;
	$morder->membership_name  = $pmpro_level_x->name;
	$morder->discount_code    = $discount_code;
	$morder->InitialPayment   = pmpro_round_price( $pmpro_level_x->initial_payment );
	$morder->PaymentAmount    = pmpro_round_price( $pmpro_level_x->billing_amount );
	$morder->ProfileStartDate = date_i18n( "Y-m-d", current_time( "timestamp" ) ) . "T0:0:0";
	$morder->BillingPeriod    = $pmpro_level_x->cycle_period;
	$morder->BillingFrequency = $pmpro_level_x->cycle_number;
	$morder->payment_type = 'Check';
	if ( $pmpro_level_x->billing_limit ) {
		$morder->TotalBillingCycles = $pmpro_level_x->billing_limit;
	}
	if ( pmpro_isLevelTrial( $pmpro_level_x ) ) {
		$morder->TrialBillingPeriod    = $pmpro_level_x->cycle_period;
		$morder->TrialBillingFrequency = $pmpro_level_x->cycle_number;
		$morder->TrialBillingCycles    = $pmpro_level_x->trial_limit;
		$morder->TrialAmount           = pmpro_round_price( $pmpro_level_x->trial_amount );
	}

	// Not saving email in order table, but the sites need it.
	$morder->Email = $user_data->user_email;
	
	// Save the user ID if logged in.
	if ( $current_user->ID ) {
		$morder->user_id = $user_id_x;
	}
	
	// Sometimes we need these split up.
	$morder->FirstName = $user_data->first_name;
	$morder->LastName  = $user_data->last_name;
	
	// Set other values.
	$morder->billing          = new stdClass();
	$morder->billing->name    = $user_data->first_name . " " . $user_data->last_name;
	$morder->setGateway('check');
	
	// // Set up level var.
	// $morder->getMembershipLevelAtCheckout();
	
	// Set tax.
	$initial_tax = $morder->getTaxForPrice( $morder->InitialPayment );
	
	// Set amounts.
	$morder->initial_amount = pmpro_round_price((float)$morder->InitialPayment + (float)$initial_tax);
	
	// Filter for order, since v1.8
	// $morder = apply_filters( 'pmpro_checkout_order', $morder );

	// $morder->payment_method_id = $payment_method_id_x;

	$morder->done_by = 'admin';
	
	
	// get_payment_method_id_by_custom_id();
	$paydoit = $doit->process($morder);
	
	$startdate = current_time( "mysql" );
	$startdate = apply_filters( "pmpro_checkout_start_date", $startdate, $user_id_x, $pmpro_level_x );
// print_r($pmpro_level_x);
	if ( ! empty( $pmpro_level_x->expiration_number ) ) {
		$enddate =  date( "Y-m-d H:i:s", strtotime( $exp_date ) );
	} else {
		$enddate = "NULL";
	}

	$enddate = apply_filters( "pmpro_checkout_end_date", $enddate, $user_id_x, $pmpro_level_x, $startdate );

	$custom_level = array(
			'user_id'         => $user_id_x,
			'membership_id'   => $pmpro_level_x->id,
			'code_id'         => '',
			'initial_payment' => pmpro_round_price( $pmpro_level_x->initial_payment ),
			'billing_amount'  => pmpro_round_price( $pmpro_level_x->billing_amount ),
			'cycle_number'    => $pmpro_level_x->cycle_number,
			'cycle_period'    => $pmpro_level_x->cycle_period,
			'billing_limit'   => $pmpro_level_x->billing_limit,
			'trial_amount'    => pmpro_round_price( $pmpro_level_x->trial_amount ),
			'trial_limit'     => $pmpro_level_x->trial_limit,
			'startdate'       => $startdate,
			'enddate'         => $enddate
		);
/*print_r($custom_level);
die;*/
	if ( $pmpro_mrow_id = paces_pmpro_changeMembershipLevel( $custom_level, $user_id_x, 'changed' ) ) {
		//we're good
		//blank order for free levels
		if ( empty( $morder ) ) {
			$morder                 = new MemberOrder();
			$morder->InitialPayment = 0;
			$morder->Email          = $bemail;
			$morder->gateway        = 'free';
			$morder->status			= 'success';
			$morder = apply_filters( "pmpro_checkout_order_free", $morder );
		}

		//add an item to the history table, cancel old subscriptions
		if ( ! empty( $morder ) ) {
			$morder->user_id       = $user_id_x;
			$morder->membership_id = $pmpro_level_x->id;
			$morder->saveOrder();
		}

		//show the confirmation
		$ordersaved = true;

		do_action( "pmpro_after_checkout", $user_id_x, $morder );
		$sendemails = apply_filters( "pmpro_send_checkout_emails", true);

		if($sendemails) { // Send the emails only if the flag is set to true

			//setup some values for the emails
			if ( ! empty( $morder ) ) {
				$invoice = new MemberOrder( $morder->id );
			} else {
				$invoice = null;
			}
			$user_data->membership_level = $pmpro_level_x; //make sure they have the right level info

			//send email to member
			// $pmproemail = new PMProEmail();
			// $pmproemail->sendCheckoutEmail( $user_data, $invoice );

			//send email to admin
			// $pmproemail = new PMProEmail();
			// $pmproemail->sendCheckoutAdminEmail( $user_data, $invoice );
		}

	}

	$result = array('status'=>'success','code'=>201);
	return $pmpro_mrow_id;
}


function paces_pmpro_changeMembershipLevel( $level, $user_id = null, $old_level_status = 'inactive', $cancel_level = null ) {
	global $wpdb;
	global $current_user, $pmpro_error;

	if ( empty( $user_id ) ) {
		$user_id = $current_user->ID;
	}

	if ( empty( $user_id ) ) {
		$pmpro_error = __( 'User ID not found.', 'paid-memberships-pro' );
		return false;
	}

	// make sure user id is int for security
	$user_id = intval( $user_id );

	if ( empty( $level ) ) {
		$level = 0;
	} else if ( is_array( $level ) ) {
		// custom level
		if ( empty( $level['membership_id'] ) ) {
			$pmpro_error = __( 'No membership_id specified in pmpro_changeMembershipLevel.', 'paid-memberships-pro' );
			return false;
		}

		$level_obj = pmpro_getLevel( $level['membership_id'] );
		if ( empty( $level_obj ) ) {
			$pmpro_error = __( 'Invalid level.', 'paid-memberships-pro' );
			return false;
		}
		unset( $level_obj );
	} else {
		// just level id
		$level_obj = pmpro_getLevel( $level );
		if ( empty( $level_obj ) ) {
			$pmpro_error = __( 'Invalid level.', 'paid-memberships-pro' );
			return false;
		}
		$level = $level_obj->id;
		unset( $level_obj );
	}

	// if it's a custom level, they're changing
	if ( ! is_array( $level ) ) {
		// are they even changing?
		if ( pmpro_hasMembershipLevel( $level, $user_id ) ) {
			$pmpro_error = __( 'not changing?', 'paid-memberships-pro' );
			return false; // not changing
		}
	}

	// get all active membershipships for this user
	$old_levels = pmpro_getMembershipLevelsForUser( $user_id );

		// get level id
	if ( is_array( $level ) ) {
		$level_id = $level['membership_id'];    // custom level
	} else {
		$level_id = $level; // just id
	}

	/**
	 * Action to run before the membership level changes.
	 *
	 * @param int $level_id ID of the level changed to.
	 * @param int $user_id ID of the user changed.
	 * @param array $old_levels array of prior levels the user belonged to.
	 * $param int $cancel_level ID of the level being cancelled if specified
	 */
	do_action( 'pmpro_before_change_membership_level', $level_id, $user_id, $old_levels, $cancel_level );

	// deactivate old memberships based on the old_level_status passed in (updates pmpro_memberships_users table)
	$pmpro_deactivate_old_levels = true;
	/**
	 * Filter whether old levels should be deactivated or not. This supports the MMPU addon.
	 * Typically you'll want to hook into pmpro_before_change_membership_level
	 * or pmpro_after_change_membership_level later to run your own deactivation logic.
	 *
	 * @since  1.8.11
	 * @var $pmpro_deactivate_old_levels bool True or false if levels should be deactivated. Defaults to true.
	 */
	$pmpro_deactivate_old_levels = apply_filters( 'pmpro_deactivate_old_levels', $pmpro_deactivate_old_levels );

	// make sure we deactivate the specified level if it's passed in
	if ( ! empty( $cancel_level ) ) {
		$pmpro_deactivate_old_levels = true;
		$new_old_levels = array();
		foreach ( $old_levels as $key => $old_level ) {
			if ( $old_level->id == $cancel_level ) {
				$new_old_levels[] = $old_levels[ $key ];
				break;
			}
		}
		$old_levels = $new_old_levels;
	}

	if ( $old_levels && $pmpro_deactivate_old_levels ) {
		foreach ( $old_levels as $old_level ) {

			$sql = "UPDATE $wpdb->pmpro_memberships_users SET `status`='$old_level_status', `enddate`='" . current_time( 'mysql' ) . "' WHERE `id`=" . $old_level->subscription_id;

			if ( ! $wpdb->query( $sql ) ) {
				$pmpro_error = __( 'Error interacting with database', 'paid-memberships-pro' ) . ': ' . ( $wpdb->last_error ? $wpdb->last_error : 'unavailable' );

				return false;
			}
		}
	}

	// should we cancel their gateway subscriptions?
	if ( ! empty( $cancel_level ) ) {
		$pmpro_cancel_previous_subscriptions = true;    // don't filter cause we're doing just the one

		$other_order_ids = $wpdb->get_col( "SELECT id FROM $wpdb->pmpro_membership_orders WHERE user_id = '" . $user_id . "' AND status = 'success' AND membership_id = '" . esc_sql( $cancel_level ) . "' ORDER BY id DESC LIMIT 1" );
	} else {
		$pmpro_cancel_previous_subscriptions = true;
		if ( isset( $_REQUEST['cancel_membership'] ) && $_REQUEST['cancel_membership'] == false ) {
			$pmpro_cancel_previous_subscriptions = false;
		}
		$pmpro_cancel_previous_subscriptions = apply_filters( 'pmpro_cancel_previous_subscriptions', $pmpro_cancel_previous_subscriptions );

		$other_order_ids = $wpdb->get_col(
			"SELECT id, IF(subscription_transaction_id = '', CONCAT('UNIQUE_SUB_ID_', id), subscription_transaction_id) as unique_sub_id
											FROM $wpdb->pmpro_membership_orders
											WHERE user_id = '" . $user_id . "'
												AND status = 'success'
											GROUP BY unique_sub_id
											ORDER BY id DESC"
		);
	}

	/**
	 * Filter the other/old order ids in case we want to exclude some.
	 * NOTE: As of version 2.0.3, includes/filters.php has code to
	 * ignore the order for the current checkout.
	 */
	$other_order_ids = apply_filters( 'pmpro_other_order_ids_to_cancel', $other_order_ids );

	// cancel any other subscriptions they have (updates pmpro_membership_orders table)
	if ( $pmpro_cancel_previous_subscriptions && ! empty( $other_order_ids ) ) {
		foreach ( $other_order_ids as $order_id ) {
			$c_order = new MemberOrder( $order_id );
			$c_order->cancel();

			if ( ! empty( $c_order->error ) ) {
				$pmpro_error = $c_order->error;
			} else {
				if( $old_level_status == 'error' ) {
					$c_order->updateStatus("error");
				}
			}
		}
	}
	$membership_row_id = 0;
	// insert current membership
	if ( ! empty( $level ) ) {
		// make sure the dates are in good formats
		if ( is_array( $level ) ) {
			// Better support mySQL Strict Mode by passing  a proper enum value for cycle_period
			if ( $level['cycle_period'] == '' ) {
				$level['cycle_period'] = 0; }

			// clean up date formatting (string/not string)
			$level['startdate'] = preg_replace( '/\'/', '', $level['startdate'] );
			$level['enddate'] = preg_replace( '/\'/', '', $level['enddate'] );

			$sql = $wpdb->prepare(
				"
					INSERT INTO {$wpdb->pmpro_memberships_users}
					(`user_id`, `membership_id`, `code_id`, `initial_payment`, `billing_amount`, `cycle_number`, `cycle_period`, `billing_limit`, `trial_amount`, `trial_limit`, `startdate`, `enddate`)
					VALUES
					( %d, %d, %d, %s, %s, %d, %s, %d, %s, %d, %s, %s )",
				$level['user_id'], // integer
				$level['membership_id'], // integer
				$level['code_id'], // integer
				$level['initial_payment'], // float (string)
				$level['billing_amount'], // float (string)
				$level['cycle_number'], // integer
				$level['cycle_period'], // string (enum)
				$level['billing_limit'], // integer
				$level['trial_amount'], // float (string)
				$level['trial_limit'], // integer
				$level['startdate'], // string (date)
				$level['enddate'] // string (date)
			);
		} else {
			$sql = $wpdb->prepare(
				"
				INSERT INTO {$wpdb->pmpro_memberships_users}
				( `user_id`, `membership_id`, `code_id`, `initial_payment`, `billing_amount`, `cycle_number`, `cycle_period`, `billing_limit`, `trial_amount`, `trial_limit`, `startdate`, `enddate`)
					VALUES
					( %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %s, %s )",
				$user_id,
				$level_id,
				'0',
				'0',
				'0',
				'0',
				'0',
				'0',
				'0',
				'0',
				current_time( 'mysql' ),
				'0000-00-00 00:00:00'
			);
		}

		if ( false === $wpdb->query( $sql ) ) {
			$pmpro_error = sprintf( __( 'Error interacting with database: %s', 'paid-memberships-pro' ), ( ! empty( $wpdb->last_error ) ? $wpdb->last_error : 'unavailable' ) );
			return false;
		}else{
			$membership_row_id = $wpdb->insert_id;
		}
	}

	// remove cached level
	global $all_membership_levels;
	unset( $all_membership_levels[ $user_id ] );
	
	// remove levels cache for user
	$cache_key = 'user_' . $user_id . '_levels';
	wp_cache_delete( $cache_key, 'pmpro' );

	// update user data and call action
	pmpro_set_current_user();

	/**
	 * Action to run after the membership level changes.
	 *
	 * @param int $level_id ID of the level changed to.
	 * @param int $user_id ID of the user changed.
	 * $param int $cancel_level ID of the level being cancelled if specified.
	 */
	do_action( 'pmpro_after_change_membership_level', $level_id, $user_id, $cancel_level );
	return $membership_row_id;
}

/*
	When users cancel (are changed to membership level 0) we give them another "cancelled" level. Can be used to downgrade someone to a free level when they cancel.
*/
function paces_pmpro_after_change_membership_level_default_level($level_id, $user_id)
{
	//if we see this global set, then another gist is planning to give the user their level back
	global $pmpro_next_payment_timestamp;
	if(!empty($pmpro_next_payment_timestamp))
		return;
	
	if($level_id == 0) {
		$approved_check = intval( get_user_meta($user_id,'pay_approved_by_admin',true) );
		if( $approved_check ){
			//cancelling, give them level 1 instead
			pmpro_changeMembershipLevel(1, $user_id);
		}
	}
}
add_action("pmpro_after_change_membership_level", "paces_pmpro_after_change_membership_level_default_level", 10, 2);