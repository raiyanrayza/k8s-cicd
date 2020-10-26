<style>

	<?php 
	if ( $blog_direction == "rtl" ) { ?>
		.blog_filter_main {
			direction: rtl;
		}
		<?php 
	} ?>
	
	.post-module:hover {
  transform: scale(1);
  box-shadow: 5px 20px 30px rgba(0, 0, 0, 0.2);
}
	
	#bf_gallery_1 .portfolio_thumbnail {
		border-radius: 0;
		display: block;
		height: auto;
		line-height: 1.42857;
		width: 100%;
		float: left;
	}

	/* thumb spacing */

	#bf_gallery_1 .col-xs-1, #bf_gallery_1 .col-sm-1, #bf_gallery_1 .col-md-1, #bf_gallery_1 .col-lg-1, #bf_gallery_1 .col-xs-2, #bf_gallery_1 .col-sm-2, #bf_gallery_1 .col-md-2, #bf_gallery_1 .col-lg-2, 
	 #bf_gallery_1 .col-xs-3, #bf_gallery_1 .col-sm-3, #bf_gallery_1 .col-md-3, #bf_gallery_1 .col-lg-3, #bf_gallery_1 .col-xs-4, #bf_gallery_1 .col-sm-4, #bf_gallery_1 .col-md-4, #bf_gallery_1 .col-lg-4, 
	 #bf_gallery_1 .col-xs-5, #bf_gallery_1 .col-sm-5, #bf_gallery_1 .col-md-5, #bf_gallery_1 .col-lg-5, #bf_gallery_1 .col-xs-6, #bf_gallery_1 .col-sm-6, #bf_gallery_1 .col-md-6, #bf_gallery_1 .col-lg-6, 
	 #bf_gallery_1 .col-xs-7, #bf_gallery_1 .col-sm-7, #bf_gallery_1 .col-md-7, #bf_gallery_1 .col-lg-7, #bf_gallery_1 .col-xs-8, #bf_gallery_1 .col-sm-8, #bf_gallery_1 .col-md-8, #bf_gallery_1 .col-lg-8, 
	 #bf_gallery_1 .col-xs-9, #bf_gallery_1 .col-sm-9, #bf_gallery_1 .col-md-9, #bf_gallery_1 .col-lg-9, #bf_gallery_1 .col-xs-10, #bf_gallery_1 .col-sm-10, #bf_gallery_1 .col-md-10, #bf_gallery_1 .col-lg-10, 
	 #bf_gallery_1 .col-xs-11, #bf_gallery_1 .col-sm-11, #bf_gallery_1 .col-md-11, #bf_gallery_1 .col-lg-11, #bf_gallery_1 .col-xs-12, #bf_gallery_1 .col-sm-12, #bf_gallery_1 .col-md-12, #bf_gallery_1 .col-lg-12 {
		padding-right: 5px !important;
		padding-left: 5px !important;
		padding-bottom: 5px !important;
		padding-top: 5px !important;
	}
	.simplefilter {
		font-family: 'Raleway', Arial, sans-serif;
		text-align: center;
		text-transform: uppercase;
		font-weight: 500;
		letter-spacing: 1px;
		padding: 0;
		margin:20px 0px 20px 0px;
	}
	.snip0047 {
		background-color: <?php echo $blog_buttons_color; ?> !important;
	}
	.snip0047:focus {
		background-color: <?php echo $blog_buttons_color; ?> !important;
	}
	.snip0047:active {
		background-color: <?php echo $blog_buttons_color; ?> !important;
	}
	
	<?php 
	if ( $blog_multi_filter == "no" ) { ?>
		.snip0047:hover span,
		.snip0047.active span {
			-webkit-transform: translate3d(-20px, 0px, 0px);
			transform: translate3d(-20px, 0px, 0px);
			opacity: 1;
		}
		.snip0047:hover i,
		.snip0047.active i {
			opacity: 1;
			-webkit-transition-delay: 0.15s;
			transition-delay: 0.15s;
		}
		.snip0047:hover:before,
		.snip0047.active:before {
			width: 38px;
			-webkit-transition-delay: 0s;
			transition-delay: 0s;
			border-radius: 5px;
		}
		
	<?php
	} if ( $blog_multi_filter == "yes" ) { ?>
		/*Multi filter active Css*/
		.snip0047:hover span,
		.snip0047.filter-active span {
		  -webkit-transform: translate3d(-20px, 0px, 0px);
		  transform: translate3d(-20px, 0px, 0px);
		  opacity: 1;
		}
		.snip0047:hover i,
		.snip0047.filter-active i {
		  opacity: 1;
		  -webkit-transition-delay: 0.15s;
		  transition-delay: 0.15s;
		}
		.snip0047:hover:before,
		.snip0047.filter-active:before {
		  width: 38px;
		  -webkit-transition-delay: 0s;
		  transition-delay: 0s;
		  border-radius: 5px;
		}
	<?php
	} ?>
	
	.blog_search {
		margin-bottom:20px;
		display: inline-block !important;
	}
	.blog_metaInfo {
		margin-top: 10px;
		margin-bottom: 10px;
		padding: 0;
		font-size: 14px;
		font-weight: 600;
		display:inline-block;
	}
	.bf_read_more_div_1 {
		text-align: right;
		margin:20px 0px 5px 0px;
	}
	.bf_read_more_1 {
		text-decoration:none;
	} 
	.bf_read_more_1:hover {
		text-decoration:none;
	}
	.blog_pagination {
		display: inline-block;
		padding-left: 0;
		margin: 20px 0;
		border-radius: 4px;
		z-index:9;
	}
	.blog_pagination span { 
		background : <?php echo $blog_pagination_color; ?>;
		border: 1px solid #eaeaea;
		display: inline-block;
		text-align: center;
		color: #FFFFFF;
		padding: 4px 12px;
		border-radius:5px;
	}
	.blog_pagination span:hover { 
		background : <?php echo $blog_pagination_color; ?>; 
		color : #ffffff; 
	}
	.blog_pagination a {
		border: 1px solid <?php echo $blog_pagination_color; ?>;
		display: inline-block;
		text-align: center;
		color: <?php echo $blog_pagination_color; ?>;
		padding: 4px 12px;
		border-radius:5px;
		transition: 0.7s;
	}
	.blog_pagination a:hover, .blog_pagination a:focus {
		background: <?php echo $blog_pagination_color; ?>;
		color: #FFFFFF;
		text-decoration:none;
	}
	
	figure.snip1228 figcaption i {
		background-color: <?php echo $blog_buttons_color; ?> !important;
	}
	.comments-area{
		z-index:99;
	}
	.blog_loader {
    border-top: 5px solid <?php echo $blog_buttons_color; ?> !important;
}
	<?php 
	if($blog_template == 'template1'){ ?>
		/* title box css*/

		.bf_thumb_box_1 {
			padding: inherit;
			background-color: <?php echo $blog_desc_box_color; ?>;
			border: 1px solid;
			border-color: rgba( <?php echo $r; ?>, <?php echo $g; ?>, <?php echo $b; ?> );
			/* border-color: #d5d8dd; */
		}
		<?php 
		if($blog_title_below_image == "no" || $blog_date_below_image == "no" || $blog_author_below_image == "no" ){  ?>
		.bf_title_box_1 {
			padding-top: 5px;
			padding-bottom: 10px;
			padding-left: 8px;
			padding-right: 8px;
		}
		<?php } ?>
		.bf_title_box_2 {
			padding-top: 10px;
			padding-bottom: 10px;
			padding-left: 8px;
			padding-right: 8px;
		}
		.bf_title_1 {
			margin-top: 15px;
			margin-bottom: 15px;
			font-size: <?php echo $blog_title_font_size; ?>px;
			color : <?php echo $blog_title_color; ?>;
			font-weight: bold;
		}
		.bf_desc_1 {
			font-size: <?php echo $blog_desc_font_size; ?>px;
			color: <?php echo $blog_desc_color; ?>;
			margin:10px 1px;
		}
		
		.blog_metaInfo > span {
			display: inline-block;
			margin-right: 6px;
			color: #777;
		}
		
		.blog_metaInfo > span > i > .blog_cat_icon {
			height: 16px !important;
			width: 20px !important;
			opacity: 0.7;
			margin-bottom: 2px
		}
		.blog_metaInfo > span > i > .blog_tag_icon {
			height: 22px !important;
			width: 22px !important;
			margin-bottom: 2px
		} 
		
	<?php
	} else if($blog_template == 'template2'){ ?>
		.blog_metaInfo > span > a {
			color: #fff !important;
		}
		.blog_metaInfo > span > i {
			height: 16px !important;
			width: 20px !important;
			margin-bottom: 2px;
		}
		.bf_desc_1 {
			font-size: <?php echo $blog_desc_font_size; ?>px;
			color: <?php echo $blog_desc_color; ?>;
			margin:10px 1px;
		}
		figure.snip1216 {
			font-family: 'Raleway', Arial, sans-serif;
			color: #fff;
			position: relative;
			background-color: <?php echo $blog_desc_box_color; ?>;
			text-align: left;
			font-size: 16px;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
		}
		figure.snip1216 * {
			-webkit-box-sizing: border-box;
			box-sizing: border-box;
			-webkit-transition: all 0.3s ease;
			transition: all 0.3s ease;
		}
		figure.snip1216 .image {
			overflow: hidden;
		}
		figure.snip1216 img {
			vertical-align: top;
			position: relative;
		}
		figure.snip1216 .blog_content {
			padding: 25px;
			position: relative;
		}
		<?php 
		if($blog_title_below_image == "no" || $blog_author_below_image == "no" ){  ?>
			figure.snip1216 .blog_content_2 {
				padding: 25px;
			  position: relative;
			}
		<?php 
		} else if($blog_title_below_image == "yes" && $blog_author_below_image == "yes" ){  ?>
			figure.snip1216 .blog_content_2 {
				display:none;
			}
		<?php 
		} ?>
		figure.snip1216 .date {
			background-color: <?php echo $blog_buttons_color; ?>;
			top: 25px;
			color: #fff;
			left: 25px;
			min-height: 48px;
			min-width: 48px;
			position: absolute;
			text-align: center;
			font-size: 20px;
			font-weight: 700;
			text-transform: uppercase;
		}
		figure.snip1216 .date span {
			display: block;
			line-height: 24px;
		}
		figure.snip1216 .date .month {
			font-size: 14px;
			background-color: rgba(0, 0, 0, 0.1);
		}
		figure.snip1216 .date .day {
			padding:3px;
		}
		figure.snip1216 .blog_title{
			margin: 0;
			padding: 0;
		}
		
		figure.snip1216 .blog_title {
			min-height: 50px;
			margin-left: 60px;
			line-height: 1.1;
			margin-bottom:20px;
			display: block;
			font-weight: 600;
			text-transform: uppercase;
			font-size: <?php echo $blog_title_font_size; ?>px;
			color : <?php echo $blog_title_color; ?>;
		}

		figure.snip1216 .blog_footer {
			padding: 0 25px;
			background-color: rgba(0, 0, 0, 0.5);
			color: #e6e6e6;
			font-size: 0.8em;
			line-height: 30px;
		}
	<?php 
	} else if($blog_template == 'template3'){ ?>
		.post-module {
			transform: scale(0.99);
			position: relative;
			z-index: 1;
			display: block;
			background: #FFFFFF;
			/*min-width: 270px;*/
			/*height: 470px;*/
			-webkit-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.15);
			-moz-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.15);
			box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.15);
			-webkit-transition: all 0.3s linear 0s;
			-moz-transition: all 0.3s linear 0s;
			-ms-transition: all 0.3s linear 0s;
			-o-transition: all 0.3s linear 0s;
			transition: all 0.3s linear 0s;
		}
		.post-module .thumbnail {
			position:relative;
			/*background: #000000;*/
			/*height: 400px;*/
			overflow: hidden;
		}
		.post-module .thumbnail .date {
			position: absolute;
			top: 20px;
			right: 20px;
			z-index: 1;
			background: <?php echo $blog_buttons_color; ?>;
			width: 55px;
			height: 55px;
			padding: 7.5px 0;
			line-height: normal;
			-webkit-border-radius: 100%;
			-moz-border-radius: 100%;
			border-radius: 100%;
			color: #FFFFFF;
			font-weight: 700;
			text-align: center;
			-webkti-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}
		.post-module .thumbnail .date .day {
			font-size: 17px;
		}
		.post-module .thumbnail .date .month {
			font-size: 11px;
			text-transform: uppercase;
		}
		.post-module .thumbnail .category {
			position: absolute;
			bottom: 0px;
			left: 0;
			background: <?php echo $blog_buttons_color; ?>;
			padding: 5px 15px;
			color: #FFFFFF;
			font-size: 13px;
			font-weight: 600;
			text-transform: uppercase;
		}
		.post-module .thumbnail img {
			display: block;
			width: 120%;
			-webkit-transition: all 0.3s linear 0s;
			-moz-transition: all 0.3s linear 0s;
			-ms-transition: all 0.3s linear 0s;
			-o-transition: all 0.3s linear 0s;
			transition: all 0.3s linear 0s;
		}
		.post-module .post-content {
			/*position: absolute;*/
			bottom: 0;
			background: <?php echo $blog_desc_box_color; ?>;
			width: 100%;
			padding: 30px;
			-webkti-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			-webkit-transition: all 0.3s cubic-bezier(0.37, 0.75, 0.61, 1.05) 0s;
			-moz-transition: all 0.3s cubic-bezier(0.37, 0.75, 0.61, 1.05) 0s;
			-ms-transition: all 0.3s cubic-bezier(0.37, 0.75, 0.61, 1.05) 0s;
			-o-transition: all 0.3s cubic-bezier(0.37, 0.75, 0.61, 1.05) 0s;
			transition: all 0.3s cubic-bezier(0.37, 0.75, 0.61, 1.05) 0s;
		}
		.post-module .post-content .blog_title {
			margin: 0;
			padding: 0 0 10px;
			color: <?php echo $blog_title_color; ?>;
			font-size: <?php echo $blog_title_font_size; ?>px;
			font-weight: 700;
		}
		.post-module .post-content .blog_sub_title {
			margin: 0;
			padding: 0 0 5px;
			color: #e74c3c;
			font-size: 20px;
			font-weight: 400;
		}
		.post-module .post-content .blog_description {
			color: <?php echo $blog_desc_color; ?>;
			font-size: <?php echo $blog_desc_font_size; ?>px;
			line-height: 1.8em;
		}
		.post-module .post-content .post-meta {
			<?php if($blog_description == "yes"){ ?>
			margin: 30px 0 0;
			<?php } ?>
			color: #999999;
		}
		.post-module .post-content .post-meta .timestamp {
			margin: 0 16px 0 0;
		}
		.post-module .post-content .post-meta a {
			color: #999999;
			text-decoration: none;
		}
		.blog_metaInfo > span {
			display: inline-block;
			margin-right: 6px;
			color: <?php echo $blog_buttons_color; ?>;
		}
		.blog_metaInfo > span > a {
			/*color: #FE0101 !important;*/
		}
		.blog_metaInfo > span > a:hover {
			text-decoration: none !important;
		}
		.blog_metaInfo > span > i {
			height: 16px !important;
			width: 20px !important;
			margin-bottom: 2px
		}
	<?php
	} ?>
	
	<?php echo $custom_css; ?>
</style>