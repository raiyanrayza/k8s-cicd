<?php get_header(); ?>

<div class="container">
	<div class="row">

		<?php /*FLTheme::sidebar( 'left' );*/ ?>

		<div class="fl-content fl-content-left col-md-12">
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					get_template_part( 'content', 'location' );
				endwhile;
			endif;
			?>
		</div>

		<?php /*FLTheme::sidebar( 'right' );*/ ?>

	</div>
</div>

<?php get_footer(); ?>
