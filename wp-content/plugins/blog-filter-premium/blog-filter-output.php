<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div class="blog_filter_main" >
	<?php
	// get all selected categories
	global $wp_query;
	if($blog_filtering == 'blog_category'){
		$taxonomy_name = 'category';
		$term_args = array( 'hide_empty' => true, 'include' => $selected_categories, 'orderby' => $blog_filter_order_by, 'order' => $blog_filter_order );
	} else if($blog_filtering == 'blog_tag') {
		$taxonomy_name = 'post_tag';
		$term_args = array( 'hide_empty' => true, 'include' => $selected_tags, 'orderby' => $blog_filter_order_by, 'order' => $blog_filter_order );
	}
	$terms = get_terms($taxonomy_name, $term_args); // Get all terms of a taxonomy
	if ( $terms && !is_wp_error( $terms ) ) :
		if($blog_filters == "yes"){ 
			?>
			<!-- filters -->
			<div class="text-center">
				<ul class="simplefilter">
				<?php 
				if ( $blog_filter_all == "yes" ) {
					if ( $blog_multi_filter == "no" ) { ?>
						<li id="all" class="snip0047 active" data-filter="all"><span style="pointer-events: none;"><?php _e("All", BF_TXTDM); ?></span><i class="fa fa-check" style="pointer-events: none;"></i></li>
					<?php 
					} else if ( $blog_multi_filter == "yes" ) { ?>
						<li id="filter-all" class="snip0047 filter-active" data-multifilter="all"><span style="pointer-events: none;"><?php _e("All", BF_TXTDM); ?></span><i class="fa fa-check" style="pointer-events: none;"></i></li>
						<?php 
					}
				}
				
				foreach ( $terms as $term) { 
				if ( $blog_multi_filter == "no" ) { ?>
					<li id="<?php echo $term->term_id; ?>" class="snip0047" value="<?php echo $term->term_id; ?>" data-filter="<?php echo $term->term_id; ?>"><span style="pointer-events: none;"><?php _e($term->name, BF_TXTDM); ?></span><i class="fa fa-check" style="pointer-events: none;"></i></li>
					<?php 
				} else if ( $blog_multi_filter == "yes" ) { ?>
					<li id="<?php echo $term->term_id; ?>" class="snip0047" value="<?php echo $term->term_id; ?>" data-multifilter="<?php echo $term->term_id; ?>"><span style="pointer-events: none;"><?php _e($term->name, BF_TXTDM); ?></span><i class="fa fa-check" style="pointer-events: none;"></i></li>
					<script>
						jQuery('#<?php echo $term->term_id; ?>').toggle(function() {
							jQuery('#<?php echo $term->term_id; ?>').addClass('filter-active');
							//alert('first-click');
						}, function() {
							jQuery('#<?php echo $term->term_id; ?>').removeClass('filter-active', 'active');
							//alert('second-click');
						});
					</script>
				<?php 
				}	?>
				<?php 
				}	?>
				</ul>
			</div>
		<?php 
		} if($blog_search == "yes") { ?>
			<div class="text-center">
				<input type="text" class="blog_search " name="blog_search" placeholder="<?php echo 'Search'; ?>" data-search>
			</div> <?php 
		}
	endif;
	
	$no_of_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	if($blog_filtering == 'blog_category'){
		$custom_query_args_posts = array( 'cat' => $selected_categories, 'category__not_in' => $exclude_categories, 'posts_per_page' => $blog_per_page, 'paged' => $no_of_page, 'orderby' => $blog_order_by, 'order' => $blog_order);
	} else if($blog_filtering == 'blog_tag') { 
		$new_selected_tags = explode(",",$selected_tags);
		$new_exclude_tags = explode(",",$exclude_tags);
		$custom_query_args_posts = array( 'tag__in' => $new_selected_tags, 'tag__not_in' => $new_exclude_tags, 'posts_per_page' => $blog_per_page, 'paged' => $no_of_page, 'orderby' => $blog_order_by, 'order' => $blog_order);
	}
	$custom_query = new WP_Query( $custom_query_args_posts );
	$temp_query = $wp_query;
	$wp_query   = NULL;
	$wp_query = $custom_query;

	if( $custom_query->have_posts()) : ?>
	<!-- posts -->
	<div id="bf_gallery_1" class="filtr-container filters-div ">
		<?php
		$abc = 0;
		while ( $custom_query->have_posts()) : $custom_query->the_post();
			
			$post_id = get_the_ID();
			//Categories Fetch
			global $post;
			if($blog_filtering == 'blog_category'){
				$category_detail= get_the_category( $post->ID );
				$prefix = $keys = '';
				$prefix2 = $lightbox_keys = '';
				
				foreach ($category_detail as $filter_value) {
					$keys .= $prefix . $filter_value->cat_ID;
					$prefix = ', ';
					$lightbox_keys .= $prefix2 . $filter_value->cat_ID;
					$prefix2 = ' ';
				}
			} else if($blog_filtering == 'blog_tag') {
				$tag_detail= get_the_tags( $post->ID );
				$prefix = $keys = '';
				$prefix2 = $lightbox_keys = '';
				foreach ($tag_detail as $filter_value) {
					$keys .= $prefix . $filter_value->term_id;
					$prefix = ', ';
					$lightbox_keys .= $prefix2 . $filter_value->term_id;
					$prefix2 = ' ';
				}
			}
			?>
			<div style="opacity:0;" id="bf_<?php echo get_the_ID(); ?>" data-category="<?php echo $keys; ?>" data-sort="<?php echo $filter_value->name; ?>" class=" pfg_theme_1 filtr-item filtr_item_1 single_one <?php echo $blog_col_large_desktops; ?> <?php echo $blog_col_desktops; ?> <?php echo $blog_col_tablets; ?> <?php echo $blog_col_phones; ?>">
				<div class="bf_thumb_box_1 hvr-shadow-radial">
					<div class="bf_title_box_1">
						<?php 
						if($blog_title_below_image == "no"){ 
							if($blog_title == "yes"){ 
								if($blog_title_link == "yes"){ ?>
									<a class="" href="<?php the_permalink(); ?>" target="<?php echo $link_open_new_tab; ?>"><h3 class="bf_title_1"><?php echo ucwords(the_title()); ?></h3></a>
								<?php 
								} else { ?>
									<h3 class="bf_title_1"><?php echo ucwords(the_title()); ?></h3>
								<?php 
								} 
							} 
						} if($blog_date_below_image == "no"){ 
							if($blog_date == "yes"){ 
							$day   = get_the_date('d');
							$month = get_the_date('M');
							$year = get_the_date('Y');
							?>
								<div class="blog_metaInfo">
									<span><i class="fa fa-calendar"></i> <a href="<?php echo get_day_link( $year, $month, $day ); ?>"><?php the_time('j F, Y'); ?></a> </span>
								</div>
								<?php 
							}
						} if($blog_author_below_image == "no"){
							if($blog_author == "yes"){ ?>
								<div class="blog_metaInfo">
									<span><i class="fa fa-user-o"></i> <?php _e('By') ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a> </span>
								</div>
							<?php 
							}
						} ?>
					</div>
					<?php
					if($blog_image == "yes"){ 
						if($blog_image_hover_effect == "hover1"){ ?>
							<figure class="snip1550">
								<img title="" class="portfolio_thumbnail" src="<?php echo get_the_post_thumbnail_url(null, $blog_image_quality); ?>" alt="">
								<div class="icons">
									<?php 
									if($blog_image_lightbox == "yes"){ ?>
										<a href="<?php echo get_the_post_thumbnail_url(); ?>" title="" class="lightbox_keys woodwork <?php echo $lightbox_keys; ?>" id="filter_main"><i class="fa fa-picture-o"></i></a>
									<?php
									} if($blog_image_link == "yes"){ ?>
										<a href="<?php the_permalink(); ?>" target="<?php echo $link_open_new_tab; ?>" ><i class="fa fa-link"></i></a>
									<?php 
									} ?>
								</div>
							</figure>
						<?php
						} if($blog_image_hover_effect == "hover2"){ ?>
							<figure class="snip1228 blue">
								<img title="" class="portfolio_thumbnail" src="<?php echo get_the_post_thumbnail_url(null, $blog_image_quality); ?>" alt="">
								<figcaption>
									<div>
										<?php 
										if($blog_image_lightbox == "yes"){ ?>
											<a href="<?php echo get_the_post_thumbnail_url(); ?>" title="" class="lightbox_keys woodwork <?php echo $lightbox_keys; ?>" id="filter_main"><i class="fa fa-picture-o left"></i></a>
										<?php
										} if($blog_image_link == "yes"){ ?>
											<a href="<?php the_permalink(); ?>" target="<?php echo $link_open_new_tab; ?>" ><i class="fa fa-link right"></i></a>
										<?php 
										} ?>
									</div>
								</figcaption>
							</figure>
						<?php
						} if($blog_image_hover_effect == "hover3"){ ?>
							<figure class="snip1210">
								<img title="" class="portfolio_thumbnail" src="<?php echo get_the_post_thumbnail_url(null, $blog_image_quality); ?>" alt="">
								<figcaption>
									<?php 
									if($blog_image_lightbox == "yes"){ ?>
										<a href="<?php echo get_the_post_thumbnail_url(); ?>" title="" class="lightbox_keys woodwork <?php echo $lightbox_keys; ?>" id="filter_main"><i class="fa fa-picture-o"></i></a>
									<?php
										} if($blog_image_link == "yes"){ ?>
										<a href="<?php the_permalink(); ?>" target="<?php echo $link_open_new_tab; ?>" ><i class="fa fa-link right"></i></a>
									<?php 
									} ?>
								</figcaption>
							</figure>
						<?php
						} if($blog_image_hover_effect == "hover4"){ ?>
							<figure class="snip1118 blue ">
								<img title="" class="portfolio_thumbnail" src="<?php echo get_the_post_thumbnail_url(null, $blog_image_quality); ?>" alt="">
								<h3 class=""><?php echo ucwords(the_title()); ?></h3>
								<div>
									<?php 
									if($blog_image_lightbox == "yes"){ ?>
										<a href="<?php echo get_the_post_thumbnail_url(); ?>" title="" class="lightbox_keys woodwork <?php echo $lightbox_keys; ?>" id="filter_main"><i class="fa fa-picture-o"></i></a>
									<?php
										} if($blog_image_link == "yes"){ ?>
										<a href="<?php the_permalink(); ?>" target="<?php echo $link_open_new_tab; ?>" ><i class="fa fa-link right"></i></a>
									<?php 
									} ?>
								</div>
							</figure>
								
						<?php } if($blog_image_hover_effect == "hover5"){ ?>
						<figure class="snip1120 blue">
							<img title="" class="portfolio_thumbnail" src="<?php echo get_the_post_thumbnail_url(null, $blog_image_quality); ?>" alt="">
							<div class="icons">
								<?php 
								if($blog_image_lightbox == "yes"){ ?>
									<a href="<?php echo get_the_post_thumbnail_url(); ?>" title="" class="lightbox_keys woodwork <?php echo $lightbox_keys; ?>" id="filter_main"><i class="fa fa-picture-o"></i></a>
								<?php
								} if($blog_image_link == "yes"){ ?>
									<a href="<?php the_permalink(); ?>" target="<?php echo $link_open_new_tab; ?>" ><i class="fa fa-link right"></i></a>
								<?php 
								} ?>
							</div>
						</figure>
						<?php
						} if($blog_image_hover_effect == "none"){ 
							if($blog_image_link == "yes"){ ?>
								<a href="<?php the_permalink(); ?>" target="<?php echo $link_open_new_tab; ?>" >
									<img title="" class="portfolio_thumbnail" src="<?php echo get_the_post_thumbnail_url(null, $blog_image_quality); ?>" alt="">
								</a>
								<?php 
							} else { ?>
								<img title="" class="portfolio_thumbnail" src="<?php echo get_the_post_thumbnail_url(null, $blog_image_quality); ?>" alt="">
							<?php 
							}
						} 
					} ?>
					<div class="bf_title_box_2">
						<?php 
						if($blog_title_below_image == "yes"){ 
							if($blog_title == "yes"){ 
								if($blog_title_link == "yes"){ ?>
									<a class="" href="<?php the_permalink(); ?>" target="<?php echo $link_open_new_tab; ?>"><h3 class="bf_title_1"><?php echo ucwords(the_title()); ?></h3></a>
								<?php 
								} else { ?>
									<h3 class="bf_title_1"><?php echo ucwords(the_title()); ?></h3>
								<?php 
								} 
							} 
						} if($blog_date_below_image == "yes"){ 
							if($blog_date == "yes"){ 
							$day   = get_the_date('d');
							$month = get_the_date('M');
							$year = get_the_date('Y');
							?>
								<div class="blog_metaInfo">
									<span><i class="fa fa-calendar"></i> <a href="<?php echo get_day_link( $year, $month, $day ); ?>"><?php the_time('j F, Y'); ?></a> </span>
								</div>
								<?php 
							}
						} if($blog_author_below_image == "yes"){
							if($blog_author == "yes"){ ?>
								<div class="blog_metaInfo">
									<span><i class="fa fa-user-o"></i> <?php _e('By') ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a> </span>
								</div>
							<?php 
							}
						} if($blog_categories == "yes"){ ?>
							<div class="blog_metaInfo">
								<span><i class=""><img class="blog_cat_icon" src="<?php echo BF_PLUGIN_URL ?>img/cat.png"></i> <a href="#"><?php $categories = get_the_category();
								$separator = ", ";
								$output = '';
								if($categories){
									foreach($categories as $category){
										$output .= '<a href="' .get_category_link($category->term_id) .'">' . $category->cat_name . '</a>'  . $separator;
									}
									echo trim($output, $separator);
								} ?></a> </span>
							</div><!-- end meta -->
						<?php 
						} if($blog_desc == "yes"){ ?>
							<div class="bf_desc_1">
								<?php echo ucfirst(stripcslashes(substr(get_the_excerpt(), 0, $blog_desc_characters)).'...'); ?>
							</div>
						<?php 
						} if($blog_tags == "yes"){ ?>
						<div class="blog_metaInfo">
							<?php
							if( get_the_tags() ){
								echo '<span><i class=""><img class="blog_tag_icon" src="'.BF_PLUGIN_URL.'img/tag.png"></i> <a href="#">';
								ucwords( the_tags( '',', ','' ) );
								echo '</a> </span>';
							} ?>
						</div>
						<?php 
						} if($blog_read_more == "yes"){ ?>
						<div class="bf_read_more_div_1">
							<a class="snip0047 bf_read_more_1" href="<?php the_permalink(); ?>" target="<?php echo $link_open_new_tab; ?>"><span><?php echo $blog_read_more_text; ?></span><i class="fa fa-link"></i></a>
						</div>
						<?php 
						} ?>
					</div>
				</div>
			</div>
			<script>
			jQuery( window ).load(function() {
				jQuery('*[data-filter]').click(function() {
					var targetFilter = jQuery(this).data('filter');
					//alert(targetFilter);
					//Exit case
					if (targetFilter == 'all') {
					   ;( function( jQuery ) {
							jQuery( '.woodwork' ).swipebox( {
								useCSS : true, // false will force the use of jQuery for animations
								useSVG : true, // false to force the use of png for buttons
								initialIndexOnArray : 0, // which image index to init when a array is passed
								hideCloseButtonOnMobile : false, // true will hide the close button on mobile devices
								removeBarsOnMobile : true, // false will show top bar on mobile devices
								hideBarsDelay : false, // delay before hiding bars on desktop
								videoMaxWidth : 1140, // videos max width
								beforeOpen: function() {}, // called before opening
								afterOpen: null, // called after opening
								afterClose: function() {}, // called after closing
								loopAtEnd: true // true will return to the first image after the last image is reached
							} );
						} )( jQuery );
					} 
				   
					if (targetFilter != 'all')  {
						jQuery(".lightbox_keys").removeClass("woodwork");
					   ;( function( jQuery ) {
							jQuery( '.<?php echo $lightbox_keys; ?>' ).swipebox( {
								useCSS : true, // false will force the use of jQuery for animations
								useSVG : true, // false to force the use of png for buttons
								initialIndexOnArray : 0, // which image index to init when a array is passed
								hideCloseButtonOnMobile : false, // true will hide the close button on mobile devices
								removeBarsOnMobile : true, // false will show top bar on mobile devices
								hideBarsDelay : false, // delay before hiding bars on desktop
								videoMaxWidth : 1140, // videos max width
								beforeOpen: function() {}, // called before opening
								afterOpen: null, // called after opening
								afterClose: function() {}, // called after closing
								loopAtEnd: true // true will return to the first image after the last image is reached
							} );
						} )( jQuery );
					}
				});
			//swipebox js
			}); 
		</script>
		<?php
		$abc++;
		endwhile;
		// Reset Post Data
		wp_reset_postdata(); ?>
		
		<div class="blog_loader"></div>
	</div>
	
	<div style="text-align: center; <?php if($blog_pagination == "no"){ ?> display:none; <?php } ?>" class="blog_pagination font-alt col-lg-12 col-md-12 col-sm-12">
		<?php the_posts_pagination( array(
			'mid_size' => 2,
			'prev_text' => __( '<i class="fa fa-caret-left"></i>', 'textdomain' ),
			'next_text' => __( '<i class="fa fa-caret-right"></i>', 'textdomain' ),
		) ); 
		// Reset main query object
		$wp_query = NULL;
		$wp_query = $temp_query;
		?>
	</div>
</div>

<script>
jQuery( window ).load(function() {

	<?php 
	if($blog_filtering == "blog_category"){ 
		if($default_cat_filter != "none"){ ?>
			jQuery( "#<?php echo $default_cat_filter; ?>" ).addClass('active');
			<?php
			$new_filter_value = $default_cat_filter;
		}
	} if($blog_filtering == "blog_tag"){ 
		if($default_tag_filter != "none"){ ?>
			jQuery( "#<?php echo $default_tag_filter; ?>" ).addClass('active');
			<?php
			$new_filter_value = $default_tag_filter;
		}
	} ?>
	
	// Animate loader off screen
	jQuery(".blog_loader").hide();
	jQuery(".pfg_theme_1").css("opacity", 1);
	//Filterizd Default options
	options = {
		animationDuration: 0.5,
		callbacks: {
			onFilteringStart: function() { },
			onFilteringEnd: function() { },
			onShufflingStart: function() { },
			onShufflingEnd: function() { },
			onSortingStart: function() { },
			onSortingEnd: function() { }
		},
		filter:<?php if($new_filter_value){ echo $new_filter_value; } else { ?> "all" <?php } ?>,
		layout: 'sameWidth',
		<?php
		if($blog_multi_filter == "yes"){
			if($blog_multi_filter_logic == "yes"){ ?>
				multifilterLogicalOperator: 'and',
			<?php 
			}
		} ?>
		
		selector: '#bf_gallery_1',
		setupControls: true
	}
	var filterizd = jQuery('#bf_gallery_1').filterizr(options);
});

//blog_pagination class add and active class add
jQuery(document).ready(function(){
	jQuery( "ul.page-numbers" ).addClass( "blog_pagination mrgt-0" );
});
</script>
<?php //include('js/jquery-filterizr-new.php'); 
endif;
?>