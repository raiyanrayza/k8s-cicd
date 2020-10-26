<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//toggle button CSS
wp_enqueue_style( 'awl-blog-filter-settings-css', plugin_dir_url( __FILE__ ) . 'css/blog-filter-settings.css' );
//wp_enqueue_style( 'awl-fontawesome-all-5.min-css', plugin_dir_url( __FILE__ ).'css/fontawesome-all-5.min.css' );
wp_enqueue_style( 'awl-font-awesome-4-min-css', plugin_dir_url( __FILE__ ).'css/font-awesome-4.min.css' );
wp_enqueue_style( 'awl-bootstrap-css', plugin_dir_url( __FILE__ ) .'css/blog-filter-bootstrap.css' );
wp_enqueue_style( 'awl-styles-css', plugin_dir_url( __FILE__ ) . 'css/styles.css' );
wp_enqueue_style( 'wp-color-picker' );

//js
wp_enqueue_script('jquery');
wp_enqueue_script('wp-color-picker');
wp_enqueue_script('awl-blog-filter-isotope-js', plugin_dir_url( __FILE__ ) .'js/isotope.pkgd.js', array('jquery'), '' , false);
wp_enqueue_script( 'awl-bootstrap-js',  plugin_dir_url( __FILE__ ) .'js/bootstrap.js', array( 'jquery' ), '', true  );
?>

<div class="panel panel-info" style="margin-top:20px; margin-bottom:10px;">
	<div class="panel-heading text-center">
		<h3 class="panel-title"><?php _e('Blog Filter Settings Page', BF_TXTDM); ?></h3>
	</div>
	<div class="panel-body " style="padding-top:20px" id="BlogFilter-SettingsPags">
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Template Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Template Right To Left ', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_direction" name="blog_direction" value="rtl" >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Blog Template', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_template" name="blog_template" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="template1" ><?php _e('Template 1', BF_TXTDM); ?></option>
									<option value="template2" ><?php _e('Template 2', BF_TXTDM); ?></option>
									<option value="template3" ><?php _e('Template 3', BF_TXTDM); ?></option>
								</select>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Column On Large Desktop', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_col_large_desktops" name="blog_col_large_desktops" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="col-lg-12" ><?php _e('1 Column', BF_TXTDM); ?></option>
									<option value="col-lg-6" ><?php _e('2 Column', BF_TXTDM); ?></option>
									<option value="col-lg-4" selected><?php _e('3 Column', BF_TXTDM); ?></option>
									<option value="col-lg-3" ><?php _e('4 Column', BF_TXTDM); ?></option>
									<option value="col-lg-2" ><?php _e('6 Column', BF_TXTDM); ?></option>
									<option value="col-lg-1" ><?php _e('12 Column', BF_TXTDM); ?></option>
								</select>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Column On Desktop', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_col_desktops" name="blog_col_desktops" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="col-md-12" ><?php _e('1 Column', BF_TXTDM); ?></option>
									<option value="col-md-6" ><?php _e('2 Column', BF_TXTDM); ?></option>
									<option value="col-md-4" selected><?php _e('3 Column', BF_TXTDM); ?></option>
									<option value="col-md-3" ><?php _e('4 Column', BF_TXTDM); ?></option>
									<option value="col-md-2" ><?php _e('6 Column', BF_TXTDM); ?></option>
									<option value="col-md-1" ><?php _e('12 Column', BF_TXTDM); ?></option>
								</select>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Column On Tablet', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_col_tablets" name="blog_col_tablets" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="col-sm-12" ><?php _e('1 Column', BF_TXTDM); ?></option>
									<option value="col-sm-6" selected><?php _e('2 Column', BF_TXTDM); ?></option>
									<option value="col-sm-4"><?php _e('3 Column', BF_TXTDM); ?></option>
									<option value="col-sm-3"><?php _e('4 Column', BF_TXTDM); ?></option>
									<option value="col-sm-2"><?php _e('6 Column', BF_TXTDM); ?> &nbsp </option>
								</select>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Column On Phone', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_col_phones" name="Blog_col_phones" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="col-xs-12" selected><?php _e('1 Column', BF_TXTDM); ?></option>
									<option value="col-xs-6" ><?php _e('2 Column', BF_TXTDM); ?></option>
									<option value="col-xs-4" ><?php _e('3 Column', BF_TXTDM); ?></option>
									<option value="col-xs-3" ><?php _e('4 Column', BF_TXTDM); ?> &nbsp </option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</section>
			
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Image Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Blog Images', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_image" name="blog_image" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Link On Image', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_image_link" name="blog_image_link" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Lightbox On Image', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_image_lightbox" name="blog_image_lightbox" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Image Hover Effect', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_image_hover_effect" name="blog_image_hover_effect" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="none" ><?php _e('None', BF_TXTDM); ?> &nbsp &nbsp </option>
									<option value="hover1" selected ><?php _e('Hover 1', BF_TXTDM); ?></option>
									<option value="hover2" ><?php _e('Hover 2', BF_TXTDM); ?></option>
									<option value="hover3" ><?php _e('Hover 3', BF_TXTDM); ?></option>
									<option value="hover4" ><?php _e('Hover 4', BF_TXTDM); ?></option>
									<option value="hover5" ><?php _e('Hover 5', BF_TXTDM); ?></option>
								</select>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Image Quality', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_image_quality" name="blog_image_quality" class="blog_image_quality" style="cursor:pointer;">
									<option value="thumbnail" ><?php _e('Thumbnail', BF_TXTDM); ?></option>
									<option value="medium" selected><?php _e('Medium', BF_TXTDM); ?></option>
									<option value="large" ><?php _e('Large', BF_TXTDM); ?></option>
									<option value="full" ><?php _e('Full', BF_TXTDM); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Title Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Blog Title', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_title" name="blog_title" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner title_setings blog_title_below_image">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Title Below The Image', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_title_below_image" name="blog_title_below_image" value="yes" >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner title_setings">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Link On Title', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_title_link" name="blog_title_link" value="yes" >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner title_setings">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Title Text Color', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<input type="text" class="form-control" id="blog_title_color" name="blog_title_color" value="#000" default-color="#000">
							</div>
						</div>
						<div class="module-content-inner title_setings">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Title Font Size', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p class="range-slider">
									<input id="blog_title_font_size" name="blog_title_font_size" class="range-slider__range" type="range" value="25" min="15" max="45" step="1">
									<span class="range-slider__value">0</span>
								</p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Description Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Blog Description', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_desc" name="blog_desc" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Description Text Color', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<input type="text" class="form-control" id="blog_desc_color" name="blog_desc_color" value="#a4a6ac" default-color="#a4a6ac">
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Description Box Color', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<input type="text" class="form-control" id="blog_desc_box_color" name="blog_desc_box_color" value="#EDEEF0" default-color="#EDEEF0">
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Description Font Size', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p class="range-slider">
									<input id="blog_desc_font_size" name="blog_desc_font_size" class="range-slider__range" type="range" value="14" min="8" max="25" step="1">
									<span class="range-slider__value">0</span>
								</p>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('How Much Characters Show In Description', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<input type="number" id="blog_desc_characters" name="blog_desc_characters" value="100" style="width: -webkit-fill-available;" >
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Post Meta Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Post Date', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_date" name="blog_date" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner title_setings blog_date_below_image">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Date Below The Image', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_date_below_image" name="blog_date_below_image" value="yes" >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Post Author', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_author" name="blog_author" value="yes" >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner title_setings blog_author_below_image">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Author Below The Image', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_author_below_image" name="blog_author_below_image" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Post Categories', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_categories" name="blog_categories" value="yes" >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Post Tags', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_tags" name="blog_tags" value="yes" >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="blog_comments_count module-content-inner" style="display:none">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Comments Count in Template 3', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_comments_count" name="blog_comments_count" value="yes" checked>
									<div class="slider round"></div>
								</label>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Link (URL) Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Read More Link', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_read_more" name="blog_read_more" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Link Open In New Tab', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="link_open_new_tab" name="link_open_new_tab" value="_blank" >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Text For Read More Link', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
							<input type="text" id="blog_read_more_text" name="blog_read_more_text" value="Read More" style="width: -webkit-fill-available;" >
							</div>
						</div>
						
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Post Order Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Post Order By', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_order_by" name="blog_order_by" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="date" selected><?php _e('Date', BF_TXTDM); ?></option>
									<option value="title"><?php _e('Title', BF_TXTDM); ?></option>
									<option value="name"><?php _e('Slug', BF_TXTDM); ?></option>
								</select>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Post Order', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_order" name="blog_order" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="ASC"><?php _e('Ascending ', BF_TXTDM); ?></option>
									<option value="DESC" selected><?php _e('Descending  ', BF_TXTDM); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Pagination Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Pagination', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_pagination" name="blog_pagination" value="yes" checked>
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Pagination Color', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<input type="text" class="form-control" id="blog_pagination_color" name="blog_pagination_color" value="#58BBEE" default-color="#58BBEE">
							</div>
						</div>
						<div class="module-content-inner title_setings">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Blogs On Per Page', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<input type="number" id="blog_per_page" name="blog_per_page" value="12" style="width: -webkit-fill-available;" >
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		 <div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Filter Order Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Filter Order By', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_filter_order_by" name="blog_filter_order_by" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="date"><?php _e('Date', BF_TXTDM); ?></option>
									<option value="title" selected><?php _e('Title', BF_TXTDM); ?></option>
									<option value="name"><?php _e('Slug', BF_TXTDM); ?></option>
								</select>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Filter Order', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_filter_order" name="blog_filter_order" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="ASC" selected><?php _e('Ascending ', BF_TXTDM); ?></option>
									<option value="DESC"><?php _e('Descending  ', BF_TXTDM); ?></option>
								</select>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Filter Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Filters', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_filters" name="blog_filters" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Filter "All"', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_filter_all" name="blog_filter_all" value="yes" >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Multi-Filter In Same Time', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_multi_filter" name="blog_multi_filter" value="yes" >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('"And" logic for Multi-Filter', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_multi_filter_logic" name="blog_multi_filter_logic" value="yes" >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Blog Search Field', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_search" name="blog_search" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Buttons Color', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<input type="text" class="form-control" id="blog_buttons_color" name="blog_buttons_color" value="#58BBEE" default-color="#58BBEE">
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Filtering with', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_filtering" name="blog_filtering" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="blog_category" selected><?php _e('Category', BF_TXTDM); ?></option>
									<option value="blog_tag" ><?php _e('Tag', BF_TXTDM); ?></option>
								</select>
							</div>
						</div>
						<div id="default_cat" class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Select Category Default Filter', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="default_cat_filter" name="default_cat_filter" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="none" selected><?php _e('None', BF_TXTDM); ?></option>
									<?php $taxonomy_name = 'category';
									//$term_args = array( 'hide_empty' => true, 'child_of' => 0, 'hierarchical' => true, );
									$term_args = array( 'hide_empty' => true, );
									$terms = get_terms($taxonomy_name, $term_args); // Get all terms of a taxonomy
									if ( $terms && !is_wp_error( $terms ) ) :
										foreach ( $terms as $term) { ?>
											<option value="<?php echo $term->term_id; ?>" ><?php _e($term->name, BF_TXTDM); ?></option>
										<?php 
										}
									endif; ?>
								</select>
							</div>
						</div>
						<div id="default_tag" style="display:none;" class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Select Tag Default Filter', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="default_tag_filter" name="default_tag_filter" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="none" selected><?php _e('None', BF_TXTDM); ?></option>
									<?php $taxonomy_name = 'post_tag';
									//$term_args = array( 'hide_empty' => true, 'child_of' => 0, 'hierarchical' => true, );
									$term_args = array( 'hide_empty' => true, );
									$terms = get_terms($taxonomy_name, $term_args); // Get all terms of a taxonomy
									if ( $terms && !is_wp_error( $terms ) ) :
										foreach ( $terms as $term) { ?>
											<option value="<?php echo $term->term_id; ?>" ><?php _e($term->name, BF_TXTDM); ?></option>
										<?php 
										}
									endif; ?>
								</select>
							</div>
						</div>
						<div id="cat_filtering" class="module-content-inner ">
							<div class="table-responsive" style="max-height:400px;" >
								<?php $taxonomy_name = 'category';
								//$term_args = array( 'hide_empty' => true, 'child_of' => 0, 'hierarchical' => true, );
								$term_args = array( 'hide_empty' => true, );
								$terms = get_terms($taxonomy_name, $term_args); // Get all terms of a taxonomy
								if ( $terms && !is_wp_error( $terms ) ) :
								?>
									<table class="table table-bordered">
										<thead>
										  <tr>
											<th><?php _e('ID', BF_TXTDM); ?></th>
											<th><?php _e('Category', BF_TXTDM); ?></th>
											<th class="text-center"><input class="checkbox_cat" type="checkbox" id="all_checked_category" name="all_checked_category"></th>
										  </tr>
										</thead>
										<tbody>
										<?php foreach ( $terms as $term) { ?>
										  <tr>
											<td><?php echo $term->term_id; ?></td>
											<td><?php  _e($term->name, BF_TXTDM); ?></td>
											<td class="text-center"><input class="checkbox_cat" type="checkbox" id="selected_categories[]" name="selected_categories[]" value="<?php echo $term->term_id; ?>"></td>
										  </tr>
										  <?php }	?>
										</tbody>
									</table>
								<?php 
								endif; ?>
							</div>
						</div>
						<div id="tag_filtering" style="display:none;" class="module-content-inner ">
							<div class="table-responsive" style="max-height:400px;" >
								<?php $taxonomy_name = 'post_tag';
								$term_args = array( 'hide_empty' => true, );
								$terms = get_terms($taxonomy_name, $term_args); // Get all terms of a taxonomy
								if ( $terms && !is_wp_error( $terms ) ) :
								?>
									<table class="table table-bordered">
										<thead>
										  <tr>
											<th><?php _e('ID', BF_TXTDM); ?></th>
											<th><?php _e('Post Tag', BF_TXTDM); ?></th>
											<th class="text-center"><input class="checkbox_tag" type="checkbox" id="all_checked_tag" name="all_checked_tag"></th>
										  </tr>
										</thead>
										<tbody>
										<?php foreach ( $terms as $term) { ?>
										  <tr>
											<td><?php echo $term->term_id; ?></td>
											<td><?php  _e($term->name, BF_TXTDM); ?></td>
											<td class="text-center"><input class="checkbox_tag" type="checkbox" id="selected_tags[]" name="selected_tags[]" value="<?php echo $term->term_id; ?>"></td>
										  </tr>
										  <?php }	?>
										</tbody>
									</table>
								<?php 
								endif; ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Exclude Post', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div id="cat_exclude" class="module-content-inner">
							<div class="table-responsive" style="max-height:400px;" >
								<?php $taxonomy_name = 'category';
								$term_args = array( 'hide_empty' => true, );
								$terms = get_terms($taxonomy_name, $term_args); // Get all terms of a taxonomy
								if ( $terms && !is_wp_error( $terms ) ) :
								?>
									<table class="table table-bordered">
										<thead>
										  <tr>
											<th><?php _e('ID', BF_TXTDM); ?></th>
											<th><?php _e('Category', BF_TXTDM); ?></th>
											<th class="text-center"></th>
										  </tr>
										</thead>
										<tbody>
										<?php foreach ( $terms as $term) { ?>
										  <tr>
											<td><?php echo $term->term_id; ?></td>
											<td><?php  _e($term->name, BF_TXTDM); ?></td>
											<td class="text-center"><input class="checkbox_exclude_cat" type="checkbox" id="exclude_categories[]" name="exclude_categories[]" value="<?php echo $term->term_id; ?>"></td>
										  </tr>
										  <?php }	?>
										</tbody>
									</table>
								<?php 
								endif; ?>
							</div>
						</div>
						<div id="tag_exclude" style="display:none;" class="module-content-inner ">
							<div class="table-responsive" style="max-height:400px;" >
								<?php $taxonomy_name = 'post_tag';
								$term_args = array( 'hide_empty' => true, );
								$terms = get_terms($taxonomy_name, $term_args); // Get all terms of a taxonomy
								if ( $terms && !is_wp_error( $terms ) ) :
								?>
									<table class="table table-bordered">
										<thead>
										  <tr>
											<th><?php _e('ID', BF_TXTDM); ?></th>
											<th><?php _e('Post Tag', BF_TXTDM); ?></th>
											<th class="text-center"></th>
										  </tr>
										</thead>
										<tbody>
										<?php foreach ( $terms as $term) { ?>
										  <tr>
											<td><?php echo $term->term_id; ?></td>
											<td><?php  _e($term->name, BF_TXTDM); ?></td>
											<td class="text-center"><input class="checkbox_exclude_tag" type="checkbox" id="exclude_tags[]" name="exclude_tags[]" value="<?php echo $term->term_id; ?>"></td>
										  </tr>
										  <?php }	?>
										</tbody>
									</table>
								<?php 
								endif; ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><a target="_blank" href="http://awplife.com/" style="text-decoration:none"><?php _e('A WP Life Services', BF_TXTDM); ?></a></h3>
					</div>
					<div class="module-content-inner title_setings">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<p><b><?php _e('Please Rate Us', BF_TXTDM); ?></b></p>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
							<p><a class="btn button_1 btn-primary" target="_blank" href="https://wordpress.org/support/plugin/blog-filter/reviews/" style="text-decoration:none">Rate Us</a></p>
						</div>
					</div>
					<div class="module-content-inner title_setings">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<p><b><?php _e('Update Sortcode, Without Regenerate It', BF_TXTDM); ?></b></p>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
							<p><a class="btn button_1 btn-primary" target="_blank" href="http://awplife.com/configure-blog-filter-plugin-shortcode/" style="text-decoration:none">See Post</a></p>
						</div>
					</div>
					<div class="module-content-inner title_setings">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
							<p><b><?php _e('Product Support', BF_TXTDM); ?></b></p>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
							<p><a class="btn button_1 btn-primary" target="_blank" href="https://awplife.com/account/helpdesk" style="text-decoration:none">Support</a></p>
						</div>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Product Documentation', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn button_1 btn-primary" target="_blank" href="http://awplife.com/docs/wp-documentation/blog-filter-premium/" style="text-decoration:none">Documentation</a></p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<div class="panel panel-info bf_pannel_bottom">
	<div class="panel-body eva-bottom-panel">
		<div class="col-md-6 text-left">
			<div class="eva_option_head">
			<h3 class="bf_footer_title"><?php _e('Blog Filter Premium', BF_TXTDM); ?> <p style="display:inline;"><?php _e('Version - 4.7.1', BF_TXTDM); ?><p></h3>
			</div>
		</div>
		<div class="col-md-6 text-right">
			<div class="eva_option_head">
			<button type="button" onclick="BfGetShortcode();" class="bf_button button_1"><?php _e('[ Generate Sortcode ]', BF_TXTDM); ?></button>
			</div>
		</div>
	</div>
	
</div>

<div class="loader" style="display:none;"></div>

<div class="modal" id="modal-show-shortcode" tabindex="-1" role="dialog" aria-labelledby="modal-new-short-code-label">
	<div class="modal-dialog" role="document" id="inner-modal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal-new-ticket-label"><?php _e('Blog Filter Shortcode', BF_TXTDM); ?></h4>
			</div>
			<div id="" class="modal-body text-center">
				<p><?php _e('Copy The Shortcode', BF_TXTDM); ?></p>
				<textarea id="awl-shortcode" readonly rows="13" cols="120" style="width: 468px;">
				</textarea>
				<div id="" class="center-block text-center">
					<button type="button" class="bf_button button_1" data-toggle="tooltip" title="Copied" onclick="CopyShortcode()" ><i class="fa fa-copy" aria-hidden="true"></i> <?php _e('Copy Sortcode', BF_TXTDM); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
//short code []
function BfGetShortcode() {
	var shortcode = '[AWL-BlogFilter';
	
	var blog_direction = jQuery("#blog_direction").val();
	if(jQuery("#blog_direction").prop('checked') == true){
		shortcode = shortcode + ' blog_direction="' + blog_direction + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_template = jQuery("#blog_template").val();
	if(blog_template){
		shortcode = shortcode + ' blog_template="' + blog_template + '"';
	}

	var blog_col_large_desktops = jQuery("#blog_col_large_desktops").val();
	if(blog_col_large_desktops){
		shortcode = shortcode + ' blog_col_large_desktops="' + blog_col_large_desktops + '"';
	}

	var blog_col_desktops = jQuery("#blog_col_desktops").val();
	if(blog_col_desktops){
		shortcode = shortcode + ' blog_col_desktops="' + blog_col_desktops + '"';
	}	
	
	var blog_col_tablets = jQuery("#blog_col_tablets").val();
	if(blog_col_tablets){
		shortcode = shortcode + ' blog_col_tablets="' + blog_col_tablets + '"';
	}	
	
	var blog_col_phones = jQuery("#blog_col_phones").val();
	if(blog_col_phones){
		shortcode = shortcode + ' blog_col_phones="' + blog_col_phones + '"';
	}
	
	var blog_image = jQuery("#blog_image").val();
	if(jQuery("#blog_image").prop('checked') == true){
		shortcode = shortcode + ' blog_image="' + blog_image + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_image_link = jQuery("#blog_image_link").val();
	if(jQuery("#blog_image_link").prop('checked') == true){
		shortcode = shortcode + ' blog_image_link="' + blog_image_link + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_image_lightbox = jQuery("#blog_image_lightbox").val();
	if(jQuery("#blog_image_lightbox").prop('checked') == true){
		shortcode = shortcode + ' blog_image_lightbox="' + blog_image_lightbox + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_image_hover_effect = jQuery("#blog_image_hover_effect").val();
	if(blog_image_hover_effect){
		shortcode = shortcode + ' blog_image_hover_effect="' + blog_image_hover_effect + '"';
	}
	
	var blog_image_quality = jQuery("#blog_image_quality").val();
	if(blog_image_quality){
		shortcode = shortcode + ' blog_image_quality="' + blog_image_quality + '"';
	}
	
	var blog_title = jQuery("#blog_title").val();
	if(jQuery("#blog_title").prop('checked') == true){
		shortcode = shortcode + ' blog_title="' + blog_title + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_title_link = jQuery("#blog_title_link").val();
	if(jQuery("#blog_title_link").prop('checked') == true){
		shortcode = shortcode + ' blog_title_link="' + blog_title_link + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_title_font_size = jQuery("#blog_title_font_size").val();
	if(blog_title_font_size){
		shortcode = shortcode + ' blog_title_font_size="' + blog_title_font_size + '"';
	}
	
	var blog_title_color = jQuery("#blog_title_color").val();
	if(blog_title_color){
		shortcode = shortcode + ' blog_title_color="' + blog_title_color + '"';
	}
	
	var blog_title_below_image = jQuery("#blog_title_below_image").val();
	if(jQuery("#blog_title_below_image").prop('checked') == true){
		shortcode = shortcode + ' blog_title_below_image="' + blog_title_below_image + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_desc = jQuery("#blog_desc").val();
	if(jQuery("#blog_desc").prop('checked') == true){
		shortcode = shortcode + ' blog_desc="' + blog_desc + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_desc_characters = jQuery("#blog_desc_characters").val();
	if(blog_desc_characters){
		shortcode = shortcode + ' blog_desc_characters="' + blog_desc_characters + '"';
	}
	
	var blog_desc_font_size = jQuery("#blog_desc_font_size").val();
	if(blog_desc_font_size){
		shortcode = shortcode + ' blog_desc_font_size="' + blog_desc_font_size + '"';
	}
	
	var blog_desc_color = jQuery("#blog_desc_color").val();
	if(blog_desc_color){
		shortcode = shortcode + ' blog_desc_color="' + blog_desc_color + '"';
	}
	
	var blog_desc_box_color = jQuery("#blog_desc_box_color").val();
	if(blog_desc_box_color){
		shortcode = shortcode + ' blog_desc_box_color="' + blog_desc_box_color + '"';
	}
	
	var link_open_new_tab = jQuery("#link_open_new_tab").val();
	if(jQuery("#link_open_new_tab").prop('checked') == true){
		shortcode = shortcode + ' link_open_new_tab="' + link_open_new_tab + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_read_more = jQuery("#blog_read_more").val();
	if(jQuery("#blog_read_more").prop('checked') == true){
		shortcode = shortcode + ' blog_read_more="' + blog_read_more + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_read_more_text = jQuery("#blog_read_more_text").val();
	if(blog_read_more_text){
		shortcode = shortcode + ' blog_read_more_text="' + blog_read_more_text + '"';
	}
	
	var blog_date = jQuery("#blog_date").val();
	if(jQuery("#blog_date").prop('checked') == true){
		shortcode = shortcode + ' blog_date="' + blog_date + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_date_below_image = jQuery("#blog_date_below_image").val();
	if(jQuery("#blog_date_below_image").prop('checked') == true){
		shortcode = shortcode + ' blog_date_below_image="' + blog_date_below_image + '"';
	}  else {
		shortcode = shortcode + '';
	}
	
	var blog_author = jQuery("#blog_author").val();
	if(jQuery("#blog_author").prop('checked') == true){
		shortcode = shortcode + ' blog_author="' + blog_author + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_author_below_image = jQuery("#blog_author_below_image").val();
	if(jQuery("#blog_author_below_image").prop('checked') == true){
		shortcode = shortcode + ' blog_author_below_image="' + blog_author_below_image + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_categories = jQuery("#blog_categories").val();
	if(jQuery("#blog_categories").prop('checked') == true){
		shortcode = shortcode + ' blog_categories="' + blog_categories + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_tags = jQuery("#blog_tags").val();
	if(jQuery("#blog_tags").prop('checked') == true){
		shortcode = shortcode + ' blog_tags="' + blog_tags + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_comments_count = jQuery("#blog_comments_count").val();
	if(jQuery("#blog_comments_count").prop('checked') == true){
		shortcode = shortcode + ' blog_comments_count="' + blog_comments_count + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_order_by = jQuery("#blog_order_by").val();
	if(blog_order_by){
		shortcode = shortcode + ' blog_order_by="' + blog_order_by + '"';
	}
	
	var blog_order = jQuery("#blog_order").val();
	if(blog_order){
		shortcode = shortcode + ' blog_order="' + blog_order + '"';
	}
	
	var blog_filter_order_by = jQuery("#blog_filter_order_by").val();
	if(blog_filter_order_by){
		shortcode = shortcode + ' blog_filter_order_by="' + blog_filter_order_by + '"';
	}
	
	var blog_filter_order = jQuery("#blog_filter_order").val();
	if(blog_filter_order){
		shortcode = shortcode + ' blog_filter_order="' + blog_filter_order + '"';
	}
	
	var blog_pagination = jQuery("#blog_pagination").val();
	var blog_pagination_color = jQuery("#blog_pagination_color").val();
	if(jQuery("#blog_pagination").prop('checked') == true){
		shortcode = shortcode + ' blog_pagination="' + blog_pagination + '"' + ' blog_pagination_color="' + blog_pagination_color + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_per_page = jQuery("#blog_per_page").val();
	if(blog_per_page){
		shortcode = shortcode + ' blog_per_page="' + blog_per_page + '"';
	}
	
	var blog_filters = jQuery("#blog_filters").val();
	if(jQuery("#blog_filters").prop('checked') == true){
		shortcode = shortcode + ' blog_filters="' + blog_filters + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_filter_all = jQuery("#blog_filter_all").val();
	if(jQuery("#blog_filter_all").prop('checked') == true){
		shortcode = shortcode + ' blog_filter_all="' + blog_filter_all + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_multi_filter = jQuery("#blog_multi_filter").val();
	var blog_multi_filter_logic = jQuery("#blog_multi_filter_logic").val();
	if(jQuery("#blog_multi_filter").prop('checked') == true){
		shortcode = shortcode + ' blog_multi_filter="' + blog_multi_filter + '"' + ' blog_multi_filter_logic="' + blog_multi_filter_logic + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_search = jQuery("#blog_search").val();
	if(jQuery("#blog_search").prop('checked') == true){
		shortcode = shortcode + ' blog_search="' + blog_search + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_filtering = jQuery("#blog_filtering").val();
	if(blog_filtering){
		shortcode = shortcode + ' blog_filtering="' + blog_filtering + '"';
	}
	
	var blog_buttons_color = jQuery("#blog_buttons_color").val();
	if(blog_buttons_color){
		shortcode = shortcode + ' blog_buttons_color="' + blog_buttons_color + '"';
	}
	if( blog_filtering == 'blog_category' ) {
		
		var selected_categories = [];
		jQuery('.checkbox_cat:checked').map(function() {
			if (jQuery.isNumeric(this.value)) {
				selected_categories.push(this.value);
			}
		}); 
	
		shortcode = shortcode + ' selected_categories="' + selected_categories + '"';
		
		var exclude_categories = [];
		jQuery('.checkbox_exclude_cat:checked').map(function() {
			if (jQuery.isNumeric(this.value)) {
				exclude_categories.push(this.value);
			}
		}); 
	
		shortcode = shortcode + ' exclude_categories="' + exclude_categories + '"';
		
		var default_cat_filter = jQuery("#default_cat_filter").val();
		if(default_cat_filter){
			shortcode = shortcode + ' default_cat_filter="' + default_cat_filter + '"';
		}
		
	} else if( blog_filtering == 'blog_tag' ) {
	
		var selected_tags = [];
		jQuery('.checkbox_tag:checked').map(function() {
			if (jQuery.isNumeric(this.value)) {
				selected_tags.push(this.value);
			}
		});
		
		shortcode = shortcode + ' selected_tags="' + selected_tags + '"';
		
		var exclude_tags = [];
		jQuery('.checkbox_exclude_tag:checked').map(function() {
			if (jQuery.isNumeric(this.value)) {
				exclude_tags.push(this.value);
			}
		});
		
		shortcode = shortcode + ' exclude_tags="' + exclude_tags + '"';
	
		var default_tag_filter = jQuery("#default_tag_filter").val();
		if(default_tag_filter){
			shortcode = shortcode + ' default_tag_filter="' + default_tag_filter + '"';
		}
	
	}
	
	shortcode = shortcode + ' custom-css="' + ' "';
	
	shortcode = shortcode + ' ]';
	
	jQuery('#awl-shortcode').text(shortcode);
	jQuery('#modal-show-shortcode').modal('show');
	
}

function CopyShortcode() {
  var copyText = document.getElementById("awl-shortcode");
  copyText.select();
  document.execCommand("copy");
  
}

jQuery(document).ready(function () {
	// isotope effect function
	// Method 1 - Initialize Isotope, then trigger layout after each image loads.
	var $grid = jQuery('#BlogFilter-SettingsPags').isotope({
		// options...
		itemSelector: '.module-wrapper',
	});
	
	//template color
	jQuery('#blog_template').change(function () {
		var blog_template = jQuery('#blog_template').val();
		if (blog_template == 'template1') {
			jQuery('#blog_title_color').iris('color', '#000000');
			jQuery('#blog_desc_color').iris('color', '#a4a6ac');
			jQuery('#blog_desc_box_color').iris('color', '#EDEEF0');
			jQuery('#blog_pagination_color').iris('color', '#58BBEE');
			jQuery('#blog_buttons_color').iris('color', '#58BBEE');
			jQuery('.blog_title_below_image').show();
			jQuery('.blog_date_below_image').show();
			jQuery('.blog_author_below_image').show();
			jQuery('.blog_comments_count').hide();
			jQuery("#blog_image_hover_effect option[value=hover1]").attr('selected', 'selected');
		} else if (blog_template == 'template2') {
			jQuery('.blog_title_below_image').show();
			jQuery('.blog_date_below_image').hide();
			jQuery('.blog_author_below_image').hide();
			jQuery('#blog_title_color').iris('color', '#FFFFFF');
			jQuery('#blog_desc_color').iris('color', '#CDCDCD');
			jQuery('#blog_desc_box_color').iris('color', '#262626');
			jQuery('#blog_pagination_color').iris('color', '#900C3E');
			jQuery('#blog_buttons_color').iris('color', '#900C3E');
			jQuery('.blog_comments_count').hide();
			jQuery("#blog_image_hover_effect option[value=hover1]").attr('selected', 'selected');
		} else if (blog_template == 'template3') {
			jQuery('#blog_title_color').iris('color', '#000000');
			jQuery('#blog_desc_color').iris('color', '#4c4c4c');
			jQuery('#blog_desc_box_color').iris('color', '#FFFFFF');
			jQuery('#blog_pagination_color').iris('color', '#ff0000');
			jQuery('#blog_buttons_color').iris('color', '#ff0000');
			jQuery('.blog_title_below_image').hide();
			jQuery('.blog_date_below_image').hide();
			jQuery('.blog_author_below_image').hide();
			jQuery('.blog_comments_count').show();
			jQuery("#blog_image_hover_effect option[value=hover2]").attr('selected', 'selected');
			
		}
	});
	
	jQuery('#blog_filtering').change(function () {
		var blog_filtering = jQuery('#blog_filtering').val();
	if (blog_filtering == 'blog_category') {
			jQuery('#cat_filtering').show();
			jQuery('#cat_exclude').show();
			jQuery('#default_cat').show();
			jQuery('#tag_filtering').hide();
			jQuery('#tag_exclude').hide();
			jQuery('#default_tag').hide();
		} else if (blog_filtering == 'blog_tag') {
			jQuery('#cat_filtering').hide();
			jQuery('#cat_exclude').hide();
			jQuery('#default_cat').hide();
			jQuery('#tag_filtering').show();
			jQuery('#tag_exclude').show();
			jQuery('#default_tag').show();
		}
	});
	
	//range slider
	var rangeSlider = function(){
	  var slider = jQuery('.range-slider'),
		range = jQuery('.range-slider__range'),
		value = jQuery('.range-slider__value');
		
	  slider.each(function(){
		value.each(function(){
		  var value = jQuery(this).prev().attr('value');
		  jQuery(this).html(value);
		});

		range.on('input', function(){
		  jQuery(this).next(value).html(this.value);
		});
	  });
	};
	rangeSlider();
	
	//checkbox
	jQuery('#all_checked_category').click(function () {
		if (this.checked == false) {
			jQuery('.checkbox_cat:checked').attr('checked', false);
		} else {
			jQuery('.checkbox_cat:not(:checked)').attr('checked', true);
		}
	});
	
	jQuery('#all_checked_tag').click(function () {
		if (this.checked == false) {
			jQuery('.checkbox_tag:checked').attr('checked', false);
		} else {
		jQuery('.checkbox_tag:not(:checked)').attr('checked', true);
		}
	});
	
	//color-picker
	(function( jQuery ) {
		jQuery(function() {
			// Add Color Picker to all inputs that have 'color-field' class
			jQuery('#blog_title_color, #blog_desc_color, #blog_desc_box_color, #blog_pagination_color, #blog_buttons_color').wpColorPicker();
			
		});
	})( jQuery );
    jQuery(document).ajaxComplete(function() {
		jQuery('#blog_title_color, #blog_desc_color, #blog_desc_box_color, #blog_pagination_color, #blog_buttons_color').wpColorPicker();
	});	
	
	// Tooltip
	jQuery('[data-toggle="tooltip"]').tooltip({
		animated: 'fade',
		placement: 'bottom',
		trigger: 'focus',
		delay: {hide: 1000}
	});
	
});	
</script>