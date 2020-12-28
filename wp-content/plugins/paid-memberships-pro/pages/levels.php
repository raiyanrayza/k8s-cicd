<?php 
global $wpdb, $pmpro_msg, $pmpro_msgt, $current_user;

$pmpro_levels = pmpro_getAllLevels(false, true);
$pmpro_level_order = pmpro_getOption('level_order');

if(!empty($pmpro_level_order))
{
	$order = explode(',',$pmpro_level_order);

	//reorder array
	$reordered_levels = array();
	foreach($order as $level_id) {
		foreach($pmpro_levels as $key=>$level) {
			if($level_id == $level->id)
				$reordered_levels[] = $pmpro_levels[$key];
		}
	}

	$pmpro_levels = $reordered_levels;
}

$pmpro_levels = apply_filters("pmpro_levels_array", $pmpro_levels);

if($pmpro_msg)
{
?>
<div class="<?php echo pmpro_get_element_class( 'pmpro_message ' . $pmpro_msgt, $pmpro_msgt ); ?>"><?php echo $pmpro_msg?></div>
<?php
}
?>
<table id="pmpro_levels_table" class="<?php echo pmpro_get_element_class( 'pmpro_table pmpro_checkout', 'pmpro_levels_table' ); ?>">
<thead>
  <tr>
	<th><?php _e('Level', 'paid-memberships-pro' );?></th>
	<th><?php _e('Price', 'paid-memberships-pro' );?></th>	
	<th>&nbsp;</th>
  </tr>
</thead>
<tbody>
	<?php	
	$count = 0;

	$membership_purchase_level = 'no';
	foreach($pmpro_levels as $level){
		$user_paid_level = get_user_meta( $current_user->ID, 'paid_for_level', true );
		  if(isset($current_user->membership_level->ID))
			  $current_level = ($current_user->membership_level->ID == $level->id);
		  else
			  $current_level = false;
		  if( get_user_meta( $current_user->ID, 'pay_approved_by_admin', true ) == '0' && $user_paid_level == $level->id ){
			  if( ( get_user_meta( $current_user->ID, 'first_payment', true ) == 'true') && !( get_user_meta($current_user->ID,'first_payment',true) == 'declined' && get_user_meta($current_user->ID,'refund_done',true) == 'true' ) ){
					$current_level = true;
					$membership_purchase_level = 'yes';
			  }
		  }
	}

	foreach($pmpro_levels as $level)
	{
		$user_paid_level = get_user_meta( $current_user->ID, 'paid_for_level', true );
	  $extra_text_for_pending = '';
	  if(isset($current_user->membership_level->ID))
		  $current_level = ($current_user->membership_level->ID == $level->id);
	  else
		  $current_level = false;
	  if( get_user_meta( $current_user->ID, 'pay_approved_by_admin', true ) == '0' && $user_paid_level == $level->id ){
		  if( ( get_user_meta( $current_user->ID, 'first_payment', true ) == 'true') && !( get_user_meta($current_user->ID,'first_payment',true) == 'declined' && get_user_meta($current_user->ID,'refund_done',true) == 'true' ) ){
				$current_level = true;
				$extra_text_for_pending = 'Your membership for this plan is in pending for approval';
		  }
	  }

	?>
	<tr class="<?php if($count++ % 2 == 0) { ?>odd<?php } ?><?php if($current_level == $level) { ?> active<?php } ?>">
		<td><?php echo $current_level ? "<strong>{$level->name}</strong>" : $level->name?>
			<?php 
				if(!empty($extra_text_for_pending))
					echo '<p><span class="pending-txt">'.$extra_text_for_pending.'</span></p>';
			?>
		</td>
		<td>
			<?php 
				if(pmpro_isLevelFree($level))
					$cost_text = "<strong>" . __("Free", 'paid-memberships-pro' ) . "</strong>";
				else
					$cost_text = pmpro_getLevelCost($level, true, true); 
				$expiration_text = pmpro_getLevelExpiration($level);
				if(!empty($cost_text) && !empty($expiration_text))
					echo $cost_text . "<br />" . $expiration_text;
				elseif(!empty($cost_text))
					echo $cost_text;
				elseif(!empty($expiration_text))
					echo $expiration_text;

			?>
		</td>
		<td>
		<?php if(empty($current_user->membership_level->ID)) { ?>
			<a class="<?php echo pmpro_get_element_class( 'pmpro_btn pmpro_btn-select', 'pmpro_btn-select' ); ?> <?php if($membership_purchase_level == 'yes'){ ?> disabled purchase_level_apr<?php } ?>" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Select', 'paid-memberships-pro' );?></a>
		<?php } elseif ( !$current_level ) { ?>                	
			<a class="<?php echo pmpro_get_element_class( 'pmpro_btn pmpro_btn-select', 'pmpro_btn-select' ); ?> <?php if($membership_purchase_level == 'yes'){ ?> disabled purchase_level_apr<?php } ?>" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Select', 'paid-memberships-pro' );?></a>
		<?php } elseif($current_level) { ?>      
			
			<?php
				//if it's a one-time-payment level, offer a link to renew				
				if( pmpro_isLevelExpiringSoon( $current_user->membership_level) && $current_user->membership_level->allow_signups ) {
					?>
						<a class="<?php echo pmpro_get_element_class( 'pmpro_btn pmpro_btn-select', 'pmpro_btn-select' ); ?>" href="<?php echo pmpro_url("checkout", "?level=" . $level->id, "https")?>"><?php _e('Renew', 'paid-memberships-pro' );?></a>
					<?php
				} else {
					?>
						<a class="<?php echo pmpro_get_element_class( 'pmpro_btn disabled', 'pmpro_btn' ); ?> <?php if($membership_purchase_level == 'yes'){ ?> disabled purchase_level_apr<?php } ?>" href="<?php echo pmpro_url("account")?>"><?php _e('Your&nbsp;Level', 'paid-memberships-pro' );?></a>
					<?php
				}
			?>
			
		<?php } ?>
		</td>
	</tr>
	<?php
	}
	?>
	<tr>
		<td colspan="3">
			<div class="complimentary_plan_message">
				<?php echo get_field('complimentary_plan_message', 'option'); ?>
			</div>
		</td>
	</tr>
</tbody>
</table>
<p class="<?php echo pmpro_get_element_class( 'pmpro_actions_nav' ); ?>">
	<?php if(!empty($current_user->membership_level->ID)) { ?>
		<a href="<?php echo pmpro_url("account")?>" id="pmpro_levels-return-account"><?php _e('&larr; Return to Your Account', 'paid-memberships-pro' );?></a>
	<?php } else { ?>
		<a href="<?php echo home_url()?>" id="pmpro_levels-return-home"><?php _e('&larr; Return to Home', 'paid-memberships-pro' );?></a>
	<?php } ?>
</p> <!-- end pmpro_actions_nav -->
