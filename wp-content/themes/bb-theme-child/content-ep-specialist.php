<?php global $current_user; ?>
<?php do_action( 'fl_before_post' ); ?>
<?php
// check if user logged in and have active membership level
$show_entries = false;
if( is_user_logged_in() ){
	if( get_user_meta( $current_user->ID, 'pay_approved_by_admin', true ) == '1' || get_user_meta( $current_user->ID, 'pay_approved_by_admin', true ) == 1 ){
		$show_entries = true;
		/*$order = new MemberOrder();
		$order->getLastMemberOrder( $current_user->ID );
		if ( isset( $order->membership_id ) && ! empty( $order->membership_id ) && empty( $level->id ) ) {
			$level = pmpro_getLevel( $order->membership_id );
			echo '<pre>';
			print_r($level);
			echo "</pre>";
			if ( ! empty( $level ) && ! empty( $level->allow_signups ) ) {}
		}*/

	}


}
?>

<article <?php post_class( 'fl-post' ); ?> id="fl-post-<?php the_ID(); ?>" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">

	<?php if ( FLTheme::show_post_header() ) : ?>
	<header class="fl-post-header">
		<h1 class="fl-post-title" itemprop="headline"><?php the_title(); ?></h1>
		<?php edit_post_link( _x( 'Edit', 'Edit page link text.', 'fl-automator' ) ); ?>
	</header><!-- .fl-post-header -->
	<?php endif; ?>
	<?php do_action( 'fl_before_post_content' ); ?>
	<div class="fl-post-content clearfix" itemprop="text">
		<?php
		$ep_user_id = intval(get_post_meta( get_the_ID(), 'user_id', true ));
			// the_content();
			$address = '';
			if(get_field('address_line_1')){
				$address = get_field('address_line_1');
			}
			if(get_field('address_line_2')){
				$address .= '<br>'.get_field('address_line_2').'<br>';
			}
			if(get_field('city')){
				$address .= get_field('city');
			}
			if(get_field('state')){
				$address .= ', '.get_field('state');
			}
			if(get_field('postal_code')){
				$address .= ', '.get_field('postal_code');
			}

		?>
		<div class="back_nav single-page">
			<a href="#" onclick="history.back(-1);return false;"><i aria-hidden="true" class="fa fa-angle-left"></i> Back</a>
		</div>
		<div class="ep-specialist-data">
			<table class="specialist-table" width="100%">
				<?php
				if(get_field('display_name')){
					?>
					<tr>
						<td>Display Name</td>
						<td><?php echo get_field('display_name'); ?><?php echo (get_user_meta( $ep_user_id, 'degree', true )) ? ', '.get_user_meta( $ep_user_id, 'degree', true ) : ''; ?></td>
					</tr>
					<?php 
				}
				if(get_field('company')){
					?>
					<tr>
						<td>Institution / Company</td>
						<td><?php echo get_field('company'); ?></td>
					</tr>
					<?php 
				}
				if($address){
					?>
					<tr>
						<td>Preferred Address</td>
						<td><?php echo $address; ?></td>
					</tr>
					<?php
				}
				if(get_field('work_phone') && $show_entries ){
					?>
					<tr>
						<td>Work Phone</td>
						<td><?php echo get_field('work_phone'); ?></td>
					</tr>
					<?php
				}
				if(get_field('title')){
					?>
					<tr>
						<td>Title</td>
						<td><?php echo get_field('title'); ?></td>
					</tr>
					<?php
				}
				if(get_field('picture')){
					$image = get_field('picture');
					$image_url = $image['sizes']['thumbnail'];
					?>
					<tr>
						<td>Picture</td>
						<td class="ep-img-thumb"><img src="<?php echo $image_url; ?>" alt="<?php echo $image['alt']; ?>"></td>
					</tr>
					<?php
				}
				if(get_field('contact_card_vcard')){
					$file = get_field('contact_card_vcard');
					$file_url = $file['url'];
					$file_alt = !empty($file['alt']) ? $file['alt'] : get_field('first_name'); 
					?>
					<tr class="contact_card_row">
						<td>Contact Card (vCard)</td>
						<td>
							<img src="<?php echo $file_url; ?>" alt="<?php echo $file_alt; ?>">
						</td>
					</tr>
					<?php
				}
				if(get_field('email') && $show_entries ){
					?>
					<tr>
						<td>Best Email</td>
						<td><a href="mailto:<?php echo get_field('email'); ?>"><?php echo get_field('email'); ?></a></td>
					</tr>
					<?php
				}
				?>					

			</table>
		</div>
	</div><!-- .fl-post-content -->
	<?php do_action( 'fl_after_post_content' ); ?>

</article>

<?php /* comments_template(); */ 	?>
<?php do_action( 'fl_after_post' ); ?>
<!-- .fl-post -->
