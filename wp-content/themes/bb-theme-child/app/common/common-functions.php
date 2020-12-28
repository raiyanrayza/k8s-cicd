<?php

/*
 * Change the text Posts by News
 * 
**/
add_filter('gettext', 'change_post_by_news_text_filter', 20, 3);

function change_post_by_news_text_filter( $translated_text, $untranslated_text, $domain ) {
  if( is_home() || is_archive() || is_single() )  {
 
    switch( $untranslated_text ) {
 
        case 'Recent Posts':
          $translated_text = __( 'Latest News','text_domain' );
        break;
 
        /*case 'Enter title here':
          $translated_text = __( 'NEW TITLE COPY','text_domain' );
        break;*/
     }
   }
   return $translated_text;
}

/*
 * Add signout link on header top bar
 * 
**/

function fn_member_login_logout() {
  ?>
  <div class="call_text">
        
    <?php
    $image_icon = '<i class="far fa-user"></i>';
    if (is_user_logged_in()){
      $user = wp_get_current_user();
      $display_name = $user->display_name;
      $user_ep_id = get_user_meta( $user->ID, 'ep_special_post_id', true );
      if( !empty( $user_ep_id ) ){
        $photo = get_field( 'picture', $user_ep_id );
        if( $photo ){
          $size = 'thumbnail';
          $thumb = $photo['sizes'][ $size ];
          $image_icon = '<img class="user-icn" src="'. esc_url($thumb) .'" alt="icon" width="18"/>';
        }
      }else if( get_user_meta( $user->ID, 'cusotm_avtar_id', true ) ){
        $profile_pic_id = get_user_meta( $user->ID, 'cusotm_avtar_id', true );
        $thumb = wp_get_attachment_image_src( $profile_pic_id, 'thumbnail', true );
        if($thumb)
          $image_icon = '<img class="user-icn" src="'. esc_url($thumb[0]) .'" alt="icon" width="18"/>';
      }
      ?>
      <a class="icns_link" href="<?php echo site_url( '/membership-account/your-profile/' ); ?>"><?php echo $image_icon; ?><span class="menu-text"><?php echo $display_name; ?></span></a>
      <span class="pipe">|</span>
      <a href="<?php echo wp_logout_url(site_url()); ?>"><i class="fas fa-sign-out-alt"></i><span class="menu-text">Sign Out</span></a>
      <?php 
    }else{
      ?>
      <a href="<?php echo site_url( 'membership-account' ); ?>"><i class="far fa-user"></i><span class="menu-text">Professional Login</span></a>
      <!-- <a href="<?php /*echo site_url( 'membership-account/membership-levels/' );*/ ?>"><i class="far fa-hand-point-up"></i><span class="menu-text">Join Today!</span></a> -->
      <?php 
    }
    ?>
      
  </div>
  <?php
}
add_shortcode( 'member_login_logout', 'fn_member_login_logout' );


/*
* Replace Forum text with Forum Category on discussion board page.
*/
function replace_forum_text( $translated_text ) {
  if( is_bbpress() ){
    if ( $translated_text == 'Forum' ) {
      $translated_text = 'Forum Category';
    }
  }
  return $translated_text;
}
add_filter( 'gettext', 'replace_forum_text', 20 );


/*
* Replace username and email with email from login form 
*/

// add_action( 'login_head', 'login_function_change' );
function login_function_change() {
  add_filter( 'gettext', 'username_change', 20, 3 );
  function username_change( $translated_text, $text, $domain ) {
    if ($text === 'Username or Email Address'){
        $translated_text = 'Email Address';
    }
    return $translated_text;
  }
}

// from login form in pages
// add_filter( 'login_form_defaults', 'th_login_form_defaults' );
function th_login_form_defaults( $defaults ) {
    $defaults['label_username'] = 'Email Address';
    return $defaults;
}


/*
* Add Custom option page to save send email for expiry card by admin
*/


if( function_exists('acf_add_options_page') ) {
  
  acf_add_options_page(array(
    'page_title'  => 'Custom Setting',
    'menu_title'  => 'Custom Setting',
    'menu_slug'   => 'theme-custom-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));

  // The filter function to replace site url in email content.
  function filter_paces_site_url( $string ) {
    $site_url = "{site_url}";
    $replaceData = site_url();
    $string = str_replace($site_url, $replaceData, $string);

      return $string;
  }
  add_filter( 'replace_paces_site_url', 'filter_paces_site_url', 10, 1 );
}

/*
* Function to get content of expiry email template
*/

function get_expiry_card_mail_content(){
  $mail_content = get_field('expiry_card_mail_template', 'option');
  return apply_filters( 'replace_paces_site_url', $mail_content['content'] );
}


/*
* Function to get content of send invoice email template
*/

function get_send_invoice_mail_content(){
  $mail_content = get_field('manual_invoice_to_member_mail', 'option');
  return apply_filters( 'replace_paces_site_url', $mail_content['content'] );
}
// add_action('admin_footer', 'get_expiry_card_mail_content');

function fetch_replace_code_data( $content, $data ){
  if( !empty( $data ) && is_array( $data ) ){
    foreach ($data as $replaceKey => $replaceData) {
      $string = "{".$replaceKey."}";
      
      $content = str_replace($string, $replaceData, $content);      
    }
  }
  return $content;
}


/*
* filter price text in proper format
*/
function paces_filter_price_text( $price ){
  $price = floatval( $price );
  $parts = explode( '.', (string)$price );

  if ( empty( $parts[1] ) ) {
    return $price;
  }
  if ( strlen( $parts[1] ) == 1 ) {
    $price = (string)$price . '0';
  }
  return $price;
}

/*
* Redirect non -logged in user to home if not logged in
*/

if ( class_exists( 'bbPress' ) ) {
  add_action('bbp_template_redirect', 'redirect_non_logged_user_from_bb_forum');
  function redirect_non_logged_user_from_bb_forum(){
    if( defined( 'DOING_AJAX' ) || is_admin()  ) return;
    
    if( is_bbpress() && !is_user_logged_in() ){
      $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

      $redirect_to = site_url('login').'?redirect_to='.urlencode($actual_link);
      wp_safe_redirect( $redirect_to );
      exit;
    } else if( is_bbpress() && is_user_logged_in() ){

      if( !pmpro_hasMembershipLevel( array( '2', '6', '7', '8', '9', '10', '11', '12' ), get_current_user_id() ) ){
        $redirect_to = site_url('/membership-account/membership-levels/');
        wp_safe_redirect( $redirect_to );
        exit;
      }
    }
  }

  add_action('bbp_footer', 'bbp_discussion_board_links_active');
  function bbp_discussion_board_links_active(){
    if( is_bbpress() ){
      ?>
      <script>
        ( function( $ ){
          $( 'li.discussion-board-menu' ).addClass('current-menu-item');
        } )( jQuery );
      </script>
      <?php
    }
  }
}

add_action('wp_head', 'pac_define_global_script_var');
function pac_define_global_script_var(){
  ?>
  <script>
    var paces_site_url = '<?php echo site_url(); ?>';
    var paces_ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
  </script>
  <?php
}

/*add_action('wp_head', 'redirect_non_logged_user_from_bbpress');
function redirect_non_logged_user_from_bbpress(){
  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  ?>
  <script>
    var paces_site_url = '<?php echo site_url(); ?>';
    var paces_ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
  </script>
  <?php
  // if( defined( 'DOING_AJAX' ) || is_admin()  ) return;
  if( is_bbpress() && !is_user_logged_in() ){
    $redirect_to = '/login/?redirect_to='.urlencode($actual_link);
    ?>
    <script> 
      var redirect_to = '<?php echo $redirect_to; ?>';
      window.location.href = paces_site_url+redirect_to; 
    </script>
    <?php
  }else
  if( is_bbpress() && is_user_logged_in() ){
    
    if( !pmpro_hasMembershipLevel( null, get_current_user_id() ) ){
      $redirect_to = site_url('/membership-account/membership-levels/');
      ?>
      <script> 
        var redirect_to = '<?php echo $redirect_to; ?>';
        window.location.href = redirect_to; 
      </script>
      <?php
    }
  }
}*/


/* 
* login redirect to home page not account page 
*/
  // pmpro_login_redirect_url
function my_login_redirect( $redirect_to, $request, $user ) {
    //is there a user to check?
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins
        return home_url('home-professionals');

        if ( in_array( 'administrator', $user->roles ) ) {
            // redirect them to the default place
            return $redirect_to;
        } else {
            return home_url('home-professionals');
        }
    } else {
        return $redirect_to;
    }
}
 
add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

/* 
*  Get all details of users by user object
*
*/

function paces_get_users_all_details( $user_id ){
  return get_metadata( 'user', $user_id );
}


add_action('template_redirect', 'paces_redirect_other_users_to_login');
function paces_redirect_other_users_to_login(){
  if(!is_user_logged_in() && get_the_ID() != '995' ){
    if( get_field( 'visible_for_', get_the_ID() ) ){
      $visible_for = get_field( 'visible_for_', get_the_ID() );
      if(!is_array($visible_for)) $visible_for = explode(', ', $visible_for);

      if( is_array( $visible_for ) && !empty( $visible_for ) ){
        if( !in_array( 'patients', $visible_for ) && in_array( 'professionals', $visible_for )  ){
          wp_redirect( site_url( 'login' ) );
          exit;
        }
      }
    }
  }
}


add_action( 'fl_content_open', 'add_custom_header_title_on_page' );
function add_custom_header_title_on_page(){
  $this_page = get_the_ID();
  $pages_id = get_field( 'custom_header_title_section', 'option' );
  if( !is_array( $pages_id ) )
    $pages_id = explode( ',', $pages_id );

  if( in_array( $this_page, $pages_id ) ){
    ob_start();
    ?>
    <div class="custom_paces_header-page_title">
      <div class="fl-row-content-wrap">
        <header class="fl-post-header">
          <div class="fl-module-content fl-node-content">
            <h1 class="fl-post-title">
            <span class="fl-heading-text"><?php echo get_the_title(); ?></span>
            </h1>
          </div>
        </header>
      </div>
    </div>
    <?php
    ob_get_contents();
  }
}