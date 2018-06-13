<?php

/*
 * Adds the WordPress Ajax Library.
*/

// Code for adding the form checks js file
function wpbooklist_form_checks_js($hook) {
  // Loading this up on just the WPBookList admin pages that need it
  if(stripos($hook, 'WPBookList-Options') !== false){
    wp_register_script( 'wpbooklist_form_checks_js', JAVASCRIPT_URL.'formchecks.js', array('jquery') );
    wp_enqueue_script('wpbooklist_form_checks_js');
  }
}

// Code for adding the jquery masked input file
function wpbooklist_jquery_masked_input_js($hook) {
  if(stripos($hook, 'WPBookList-Options') !== false){
    wp_register_script( 'wpbooklist_jquery_masked_input_js', JAVASCRIPT_URL.'jquery-masked-input/jquery-masked-input.js', array('jquery') );
    wp_enqueue_script('wpbooklist_jquery_masked_input_js');
  }
}

// Code for adding the jquery readmore file for text blocks like description and notes
function wpbooklist_jquery_readmore_js() {
  wp_register_script( 'wpbooklist_jquery_readmore_js', JAVASCRIPT_URL.'jquery-readmore/readmore.min.js', array('jquery') );
  wp_enqueue_script('wpbooklist_jquery_readmore_js');
}

// Code for adding the colorbox js file
function wpbooklist_jre_plugin_colorbox_script($hook) {
  // If on an admin page, loading this up on just the WPBookList admin pages that need it. Else, load it on the frontend that has a WPBookList Shortcode
  if(is_admin()){
    if(stripos($hook, 'WPBookList-Options') !== false){
      wp_register_script( 'colorboxjsforwpbooklist', JAVASCRIPT_URL.'jquery-colorbox/jquery.colorbox-min.js', array('jquery') );
      wp_enqueue_script('colorboxjsforwpbooklist');
    }
  } else {
    global $wpdb;
    $id = get_the_ID();
    $post = get_post($id);
    $content = '';
    if($post){
      $content = $post->post_content;
    }

    // If we find any of these in $content, load the colorbox js 
    $shortcode_array = array(
      'showbookcover',
      'wpbooklist_shortcode',
      'wpbooklist_bookfinder',
      'wpbooklist_carousel',
      'wpbooklist_categories',
      'wpbooklist'
    );

    foreach ($shortcode_array as $key => $value) {
      if(stripos($content, $value) !== false){
        wp_register_script( 'colorboxjsforwpbooklist', JAVASCRIPT_URL.'jquery-colorbox/jquery.colorbox-min.js', array('jquery') );
        wp_enqueue_script('colorboxjsforwpbooklist');
      }
    }

    // If we're on the homepage or the blog page, just go ahead and load
    if(!wp_script_is('colorboxjsforwpbooklist')){
      if (is_front_page() || is_home() ) {
        wp_register_script( 'colorboxjsforwpbooklist', JAVASCRIPT_URL.'jquery-colorbox/jquery.colorbox-min.js', array('jquery') );
        wp_enqueue_script('colorboxjsforwpbooklist');
      }
    }
  }
}


// Code for adding the addthis js file
function wpbooklist_jre_plugin_addthis_script($hook) {

  // If on an admin page, loading this up on just the WPBookList admin pages that need it. Else, load it on all of the frontend
  if(is_admin()){
    if(stripos($hook, 'WPBookList-Options') !== false){
      wp_register_script( 'addthisjsforwpbooklist', JAVASCRIPT_URL.'jquery-addthis/addthis.js', array('jquery') );
      wp_enqueue_script('addthisjsforwpbooklist');
    }
  } else {
    global $wpdb;
    $id = get_the_ID();
    $post = get_post($id);
    $content = '';
    if($post){
      $content = $post->post_content;
    }

    // If we find any of these in $content, load the addthis js 
    $shortcode_array = array(
      'showbookcover',
      'wpbooklist_shortcode',
      'wpbooklist_bookfinder',
      'wpbooklist_carousel',
      'wpbooklist_categories',
      'wpbooklist'
    );

    foreach ($shortcode_array as $key => $value) {
      if(stripos($content, $value) !== false){
        wp_register_script( 'addthisjsforwpbooklist', JAVASCRIPT_URL.'jquery-addthis/addthis.js', array('jquery') );
        wp_enqueue_script('addthisjsforwpbooklist');
      }
    }

    // If we're on the homepage or the blog page, just go ahead and load
    if(!wp_script_is('addthisjsforwpbooklist')){
      if (is_front_page() || is_home() ) {
        wp_register_script( 'addthisjsforwpbooklist', JAVASCRIPT_URL.'jquery-addthis/addthis.js', array('jquery') );
        wp_enqueue_script('addthisjsforwpbooklist');
      }
    }

    $table_name = $wpdb->prefix . 'wpbooklist_jre_saved_page_post_log';
    $row = $wpdb->get_results("SELECT * FROM $table_name");
    foreach ($row as $key => $value) {
      if($id == $value->post_id){
        wp_register_script( 'addthisjsforwpbooklist', JAVASCRIPT_URL.'jquery-addthis/addthis.js', array('jquery') );
        wp_enqueue_script('addthisjsforwpbooklist');
      }
    }

  }
}

// Code for adding the colorbox CSS file
function wpbooklist_jre_plugin_colorbox_style($hook) {
  // If on an admin page, loading this up on just the WPBookList admin pages that need it. Else, load it on all of the frontend
  if(is_admin()){
    if(stripos($hook, 'WPBookList-Options') !== false){
      wp_register_style( 'colorboxcssforwpbooklist', ROOT_CSS_URL.'colorbox.css' );
      wp_enqueue_style('colorboxcssforwpbooklist');
    }
  } else {
    global $wpdb;
    $id = get_the_ID();
    $post = get_post($id);
    $content = '';
    if($post){
      $content = $post->post_content;
    }

    // If we find any of these in $content, load the colorbox.css 
    $shortcode_array = array(
      'showbookcover',
      'wpbooklist_shortcode',
      'wpbooklist_bookfinder',
      'wpbooklist_carousel',
      'wpbooklist_categories',
      'wpbooklist'
    );

    foreach ($shortcode_array as $key => $value) {
      if(stripos($content, $value) !== false){
        wp_register_style( 'colorboxcssforwpbooklist', ROOT_CSS_URL.'colorbox.css' );
        wp_enqueue_style('colorboxcssforwpbooklist');
      }
    }

    // If we're on the homepage or the blog page, just go ahead and load
    if(!wp_script_is('colorboxcssforwpbooklist')){
      if (is_front_page() || is_home() ) {
        wp_register_style( 'colorboxcssforwpbooklist', ROOT_CSS_URL.'colorbox.css' );
        wp_enqueue_style('colorboxcssforwpbooklist');
      }
    }
  }
}

// Code for adding the frontend sort/search CSS file
function wpbooklist_jre_plugin_sort_search_style() {
   
    global $wpdb;
    $id = get_the_ID();
    $post = get_post($id);
    $content = '';
    if($post){
      $content = $post->post_content;
    }

    // If we find any of these in $content, load the colorbox.css 
    $shortcode_array = array(
      'showbookcover',
      'wpbooklist_shortcode',
      'wpbooklist_bookfinder',
      'wpbooklist_carousel',
      'wpbooklist_categories',
      'wpbooklist'
    );

    foreach ($shortcode_array as $key => $value) {
      if(stripos($content, $value) !== false){
        wp_register_style( 'sortsearchcssforwpbooklist', ROOT_CSS_URL.'frontend-sort-search-ui.css' );
        wp_enqueue_style('sortsearchcssforwpbooklist');
      }
    }

    // If we're on the homepage or the blog page, just go ahead and load
    if(!wp_script_is('sortsearchcssforwpbooklist')){
      if (is_front_page() || is_home() ) {
        wp_register_style( 'sortsearchcssforwpbooklist', ROOT_CSS_URL.'frontend-sort-search-ui.css' );
        wp_enqueue_style('sortsearchcssforwpbooklist');
      }
    }
}

// For pushing a new message to the admin notice area
function wpbooklist_jre_rest_api_notice( $data ){
    global $wpdb;
    $table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
    $options_row = $wpdb->get_results("SELECT * FROM $table_name");
    $newmessage = $data['notice'];
    $dismiss = $options_row[0]->admindismiss;
    if($dismiss == 0){
      $data = array(
          'admindismiss' => 1,
          'adminmessage' => $newmessage
      );
      $format = array( '%d', '%s'); 
      $where = array( 'ID' => 1 );
      $where_format = array( '%d' );
      $result = $wpdb->update( $table_name, $data, $where, $format, $where_format );
      $result = $result.' - Also Changed admindismiss';
    } else {
      $data = array(
          'adminmessage' => $newmessage
      );
      $format = array('%s'); 
      $where = array( 'ID' => 1 );
      $where_format = array( '%d' );
      $result = $wpdb->update( $table_name, $data, $where, $format, $where_format );
      $result = $result.' - only updated adminmessage';
    }

    return ($result);
}

function wpbooklist_jre_for_reviews_and_wpbooklist_admin_notice__success() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
  $options_row = $wpdb->get_results("SELECT * FROM $table_name");
  $dismiss = $options_row[0]->admindismiss;

  if($dismiss == 1){
    $message = $options_row[0]->adminmessage;
    $url = home_url();
    $newmessage = str_replace('alaainqphpaholeechoaholehomeanusurlalparpascaholeainqara',$url,$message);
    $newmessage = str_replace('asq',"'",$newmessage);
    $newmessage = str_replace("hshmrk","#",$newmessage);
    $newmessage = str_replace("ampersand","&",$newmessage);
    $newmessage = str_replace('adq','"',$newmessage);
    $newmessage = str_replace('aco',':',$newmessage);
    $newmessage = str_replace('asc',';',$newmessage);
    $newmessage = str_replace('aslash','/',$newmessage);
    $newmessage = str_replace('ahole',' ',$newmessage);
    $newmessage = str_replace('ara','>',$newmessage);
    $newmessage = str_replace('ala','<',$newmessage);
    $newmessage = str_replace('anem','!',$newmessage);
    $newmessage = str_replace('dash','-',$newmessage);
    $newmessage = str_replace('akomma',',',$newmessage);
    $newmessage = str_replace('anequal','=',$newmessage);
    $newmessage = str_replace('dot','.',$newmessage);
    $newmessage = str_replace('anus','_',$newmessage);
    $newmessage = str_replace('adollar','$',$newmessage);
    $newmessage = str_replace('ainq','?',$newmessage);
    $newmessage = str_replace('alp','(',$newmessage);
    $newmessage = str_replace('arp',')',$newmessage);
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php echo $newmessage; ?></p>
    </div>
    <?php
  }
}

function wpbooklist_jre_for_storytime_admin_notice__success() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'wpbooklist_jre_storytime_stories_settings';
  $settings_results = $wpdb->get_row("SELECT * FROM $table_name");

  $dismiss = $settings_results->newnotify;
  $dismissparticularmessage = $settings_results->notifydismiss;

  if($dismiss == 1 && $settings_results->notifymessage != '' && $dismissparticularmessage == 1){
    $message = $settings_results->notifymessage;
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php echo $message; ?></p>
    </div>
    <?php
  }
}


// Adding the front-end library ui css file or StylePak
function wpbooklist_jre_frontend_library_ui_default_style() {
  global $wpdb;
  $id = get_the_ID();
  $post = get_post($id);
  $content = '';
  if($post){
    $content = $post->post_content;
  }
  $stylepak = '';

  $table_name2 = $wpdb->prefix . 'wpbooklist_jre_list_dynamic_db_names';
  $db_row = $wpdb->get_results("SELECT * FROM $table_name2");
   foreach($db_row as $table){
    $shortcode = 'wpbooklist_shortcode table="'.$table->user_table_name.'"';

    if(stripos($content, $shortcode) !== false){
      $stylepak = $table->stylepak;
    }
  }

  if($stylepak == ''){
    if(stripos($content, '[wpbooklist_shortcode') !== false){
        $table_name2 = $wpdb->prefix . 'wpbooklist_jre_user_options';
        $row = $wpdb->get_results("SELECT * FROM $table_name2");
        $stylepak = $row[0]->stylepak;
    }
  }

  if($stylepak == '' || $stylepak == null || $stylepak == 'Default'){
    $stylepak = 'default';
  }

  if($stylepak == 'default' || $stylepak == 'Default StylePak'){

    $id = get_the_ID();
    $post = get_post($id);
    $content = '';
    if($post){
      $content = $post->post_content;
    }

    // If we find any of these in $content, load the colorbox.css 
    
    $shortcode_array = array(
      'showbookcover',
      'wpbooklist_shortcode',
      'wpbooklist_bookfinder',
      'wpbooklist_carousel',
      'wpbooklist_categories',
      'wpbooklist'
    );

    // Checking for WPBookList content on page
    foreach ($shortcode_array as $key => $value) {
      if(stripos($content, $value) !== false){
        wp_register_style( 'frontendlibraryui', ROOT_CSS_URL.'frontend-library-ui.css' );
        wp_enqueue_style('frontendlibraryui');
      }
    }

    // If we're on the homepage or the blog page, just go ahead and load
    if(!wp_script_is('frontendlibraryui')){
      if (is_front_page() || is_home() ) {
        wp_register_style( 'frontendlibraryui', ROOT_CSS_URL.'frontend-library-ui.css' );
        wp_enqueue_style('frontendlibraryui');
      }
    }
  }

  $library_stylepaks_upload_dir = LIBRARY_STYLEPAKS_UPLOAD_URL;

  // Modify the 'LIBRARY_STYLEPAKS_UPLOAD_URL' to make sure we're using the right protocol, as it seems that (wp_upload_dir() doesn't return https - introduced in 5.5.2
  $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; 
  if($protocol == 'https://' || $protocol == 'https'){
    if(strpos(LIBRARY_STYLEPAKS_UPLOAD_URL, 'http://') !== false){
     $library_stylepaks_upload_dir = str_replace('http://', 'https://', LIBRARY_STYLEPAKS_UPLOAD_URL);
    }
  }

  if($stylepak == 'StylePak1'){
    wp_register_style( 'StylePak1', $library_stylepaks_upload_dir.'StylePak1.css' );
    wp_enqueue_style('StylePak1');
  }

  if($stylepak == 'StylePak2'){
    wp_register_style( 'StylePak2', $library_stylepaks_upload_dir.'StylePak2.css' );
    wp_enqueue_style('StylePak2');
  }

  if($stylepak == 'StylePak3'){
    wp_register_style( 'StylePak3', $library_stylepaks_upload_dir.'StylePak3.css' );
    wp_enqueue_style('StylePak3');
  }

  if($stylepak == 'StylePak4'){
    wp_register_style( 'StylePak4', $library_stylepaks_upload_dir.'StylePak4.css' );
    wp_enqueue_style('StylePak4');
  }

  if($stylepak == 'StylePak5'){
    wp_register_style( 'StylePak5', $library_stylepaks_upload_dir.'StylePak5.css' );
    wp_enqueue_style('StylePak5');
  }

  if($stylepak == 'StylePak6'){
    wp_register_style( 'StylePak6', $library_stylepaks_upload_dir.'StylePak6.css' );
    wp_enqueue_style('StylePak6');
  }

  if($stylepak == 'StylePak7'){
    wp_register_style( 'StylePak7', $library_stylepaks_upload_dir.'StylePak7.css' );
    wp_enqueue_style('StylePak7');
  }

  if($stylepak == 'StylePak8'){
    wp_register_style( 'StylePak8', $library_stylepaks_upload_dir.'StylePak8.css' );
    wp_enqueue_style('StylePak8');
  }


}

// Adding the frontend-storytime-ui.css file
function wpbooklist_jre_frontend_storytime_style() {
  global $wpdb;
  $id = get_the_ID();
  $post = get_post($id);
  $content = '';
  if($post){
    $content = $post->post_content;
  }
  $storytime_stylepak = '';

  if(stripos($content, '[wpbooklist_storytime') !== false){
    $table_name = $wpdb->prefix . 'wpbooklist_jre_storytime_stories_settings';
    $row = $wpdb->get_row("SELECT * FROM $table_name");
    $storytime_stylepak = $row->storytimestylepak;


    if($storytime_stylepak == '' || $storytime_stylepak == null){
      $storytime_stylepak = 'default';
    }

    if($storytime_stylepak == 'default'){
      wp_register_style( 'storytimefrontendui', ROOT_CSS_URL.'frontend-storytime-ui.css' );
      wp_enqueue_style('storytimefrontendui');
    }
  }
}


// Code for adding the default posts & pages CSS file
function wpbooklist_jre_posts_pages_default_style() {
  
    global $wpdb;
    $id = get_the_ID();
    $stylepak = '';

    $table_name = $wpdb->prefix . 'wpbooklist_jre_saved_page_post_log';

    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE post_id = %d", $id));

    if($row != null){
      if($row->type == 'post'){
        $table_name_post = $wpdb->prefix . 'wpbooklist_jre_post_options';
      } else {
        $table_name_post = $wpdb->prefix . 'wpbooklist_jre_page_options';
      }

      $row = $wpdb->get_row("SELECT * FROM $table_name_post");
      $stylepak = $row->stylepak;
    }

    if($stylepak == '' || $stylepak == null || $stylepak == 'Default StylePak'){
      $stylepak = 'default';
    }

    if($stylepak == 'Default' || $stylepak == 'default' || $stylepak == 'Default StylePak'){
      wp_register_style( 'postspagesdefaultcssforwpbooklist', ROOT_CSS_URL.'posts-pages-default.css' );
      wp_enqueue_style('postspagesdefaultcssforwpbooklist');
    }

    if($stylepak == 'Post-StylePak1'){
      wp_register_style( 'Post-StylePak1', POST_STYLEPAKS_UPLOAD_URL.'Post-StylePak1.css' );
      wp_enqueue_style('Post-StylePak1');
    }

    if($stylepak == 'Post-StylePak2'){
      wp_register_style( 'Post-StylePak2', POST_STYLEPAKS_UPLOAD_URL.'Post-StylePak2.css' );
      wp_enqueue_style('Post-StylePak2');
    }

    if($stylepak == 'Post-StylePak3'){
      wp_register_style( 'Post-StylePak3', POST_STYLEPAKS_UPLOAD_URL.'Post-StylePak3.css' );
      wp_enqueue_style('Post-StylePak3');
    }

    if($stylepak == 'Post-StylePak4'){
      wp_register_style( 'Post-StylePak4', POST_STYLEPAKS_UPLOAD_URL.'Post-StylePak4.css' );
      wp_enqueue_style('Post-StylePak4');
    }

    if($stylepak == 'Post-StylePak5'){
      wp_register_style( 'Post-StylePak5', POST_STYLEPAKS_UPLOAD_URL.'Post-StylePak5.css' );
      wp_enqueue_style('Post-StylePak5');
    }

    
}

// Code for adding the general admin CSS file
function wpbooklist_jre_plugin_general_admin_style($hook) {
  wp_register_style( 'wpbooklist_ui_style', ROOT_CSS_URL.'admin.css');
  wp_enqueue_style('wpbooklist_ui_style');
}

// Code for adding the admin template CSS file
function wpbooklist_jre_plugin_admin_template_style($hook) {
  // If on an admin page, loading this up on just the WPBookList admin pages that need it. Else, load it on all of the frontend
  if(stripos($hook, 'WPBookList-Options') !== false){
    wp_register_style( 'wpbooklist_admin_template_style', ROOT_CSS_URL.'admin-template.css');
    wp_enqueue_style('wpbooklist_admin_template_style');
  }
}


function wpbooklist_jre_prem_add_ajax_library() {
 
    $html = '<script type="text/javascript">';

    // checking $protocol in HTTP or HTTPS
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
        // this is HTTPS
        $protocol  = "https";
    } else {
        // this is HTTP
        $protocol  = "http";
    }
    $tempAjaxPath = admin_url( 'admin-ajax.php' );
    $goodAjaxUrl = $protocol.strchr($tempAjaxPath,':');

    $html .= 'var ajaxurl = "' . $goodAjaxUrl . '"';
    $html .= '</script>';
    echo $html;
    
} // End add_ajax_library

// Function to add table names to the global $wpdb
function wpbooklist_jre_register_table_name() {
    global $wpdb;
    $wpdb->wpbooklist_jre_saved_book_log = "{$wpdb->prefix}wpbooklist_jre_saved_book_log";
    $wpdb->wpbooklist_jre_saved_page_post_log = "{$wpdb->prefix}wpbooklist_jre_saved_page_post_log";
    $wpdb->wpbooklist_jre_saved_books_for_featured = "{$wpdb->prefix}wpbooklist_jre_saved_books_for_featured";
    $wpdb->wpbooklist_jre_user_options = "{$wpdb->prefix}wpbooklist_jre_user_options";
    $wpdb->wpbooklist_jre_page_options = "{$wpdb->prefix}wpbooklist_jre_page_options";
    $wpdb->wpbooklist_jre_post_options = "{$wpdb->prefix}wpbooklist_jre_post_options";
    $wpdb->wpbooklist_jre_list_dynamic_db_names = "{$wpdb->prefix}wpbooklist_jre_list_dynamic_db_names";
    $wpdb->wpbooklist_jre_book_quotes = "{$wpdb->prefix}wpbooklist_jre_book_quotes";
    $wpdb->wpbooklist_jre_purchase_stylepaks = "{$wpdb->prefix}wpbooklist_jre_purchase_stylepaks";
    $wpdb->wpbooklist_jre_color_options = "{$wpdb->prefix}wpbooklist_jre_color_options";
    $wpdb->wpbooklist_jre_active_extensions = "{$wpdb->prefix}wpbooklist_jre_active_extensions";
    $wpdb->wpbooklist_jre_storytime_stories = "{$wpdb->prefix}wpbooklist_jre_storytime_stories";
    $wpdb->wpbooklist_jre_storytime_stories_settings = "{$wpdb->prefix}wpbooklist_jre_storytime_stories_settings";

}

// Runs once upon plugin activation and creates tables
function wpbooklist_jre_create_tables() {
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  global $wpdb;
  global $charset_collate; 

  $url = home_url(); 
  $plugin  ='WPBookList';
  $date = time();

  $postdata = http_build_query(
      array(
          'url' => $url,
          'plugin' => $plugin,
          'date' => $date
      )
  );

  $opts = array('http' =>
      array(
          'method'  => 'POST',
          'header'  => 'Content-type: application/x-www-form-urlencoded',
          'content' => $postdata
      )
  );

  $context = stream_context_create($opts);
  $result = '';
    $responsecode = '';
    if(function_exists('file_get_contents')){
        file_get_contents('https://jakerevans.com/pmfileforrecord.php', false, $context);
    } else {
      if (function_exists('curl_init')){ 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
        $url = 'https://jakerevans.com/pmfileforrecord.php';
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = array('url'=>$url, 'plugin'=>$plugin, 'date' => $date);

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $result = curl_exec($ch);
        $responsecode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
      }
    }


  // Call this manually as we may have missed the init hook
  wpbooklist_jre_register_table_name();
  //Creating the table

  $default_table = $wpdb->prefix."wpbooklist_jre_saved_book_log";

  $sql_create_table1 = "CREATE TABLE {$wpdb->wpbooklist_jre_saved_book_log} 
  (
        ID bigint(190) auto_increment,
        title varchar(255),
        isbn varchar(190),
        subject varchar(255),
        country varchar(255),
        author varchar(255),
        author_url varchar(255),
        price varchar(255),
        finished varchar(255),
        date_finished varchar(255),
        signed varchar(255),
        first_edition varchar(255),
        image varchar(255),
        pages bigint(255),
        pub_year bigint(255),
        publisher varchar(255),
        category varchar(255),
        description MEDIUMTEXT, 
        notes MEDIUMTEXT,
        itunes_page varchar(255),
        google_preview varchar(255),
        amazon_detail_page varchar(255),
        kobo_link varchar(255),
        bam_link varchar(255),
        bn_link varchar(255),
        rating bigint(255),
        review_iframe varchar(255),
        similar_products MEDIUMTEXT,
        page_yes varchar(255),
        post_yes varchar(255),
        book_uid varchar(255),
        lendstatus varchar(255),
        currentlendemail varchar(255),
        currentlendname varchar(255),
        lendable varchar(255),
        copies bigint(255),
        copieschecked bigint(255),
        lendedon bigint(255),
        woocommerce varchar(255),
        authorfirst varchar(255),
        authorlast varchar(255),
        PRIMARY KEY  (ID),
          KEY isbn (isbn)
  ) $charset_collate; ";
  dbDelta( $sql_create_table1 );

  $sql_create_table2 = "CREATE TABLE {$wpdb->wpbooklist_jre_user_options} 
  (
        ID bigint(190) auto_increment,
        username varchar(190),
        version varchar(255) NOT NULL DEFAULT '3.3',
        amazonaff varchar(255) NOT NULL DEFAULT 'wpbooklistid-20',
        amazonauth varchar(255),
        itunesaff varchar(255) NOT NULL DEFAULT '1010lnPx',
        enablepurchase bigint(255),
        amazonapipublic varchar(255),
        amazonapisecret varchar(255),
        googleapi varchar(255),
        appleapi varchar(255),
        openlibraryapi varchar(255),
        hidestats bigint(255),
        hidesortby bigint(255),
        hidesearch bigint(255),
        hidefilter bigint(255),
        hidebooktitle bigint(255),
        hidebookimage bigint(255),
        hidefinished bigint(255),
        hidelibrarytitle bigint(255),
        hideauthor bigint(255),
        hidecategory bigint(255),
        hidepages bigint(255),
        hidebookpage bigint(255),
        hidebookpost bigint(255),
        hidepublisher bigint(255),
        hidepubdate bigint(255),
        hidesigned bigint(255),
        hidesubject bigint(255),
        hidecountry bigint(255),
        hidefirstedition bigint(255),
        hidefinishedsort bigint(255),
        hidesignedsort bigint(255),
        hidefirstsort bigint(255),
        hidesubjectsort bigint(255),
        hidefacebook bigint(255),
        hidemessenger bigint(255),
        hidetwitter bigint(255),
        hidegoogleplus bigint(255),
        hidepinterest bigint(255),
        hideemail bigint(255),
        hidefrontendbuyimg bigint(255),
        hidefrontendbuyprice bigint(255),
        hidecolorboxbuyimg bigint(255),
        hidecolorboxbuyprice bigint(255),
        hidegoodreadswidget bigint(255),
        hidedescription bigint(255),
        hidesimilar bigint(255),
        hideamazonreview bigint(255),
        hidenotes bigint(255),
        hidebottompurchase bigint(255),
        hidegooglepurchase bigint(255),
        hidefeaturedtitles bigint(255),
        hidebnpurchase bigint(255),
        hideitunespurchase bigint(255),
        hideamazonpurchase bigint(255),
        hiderating bigint(255),
        hideratingbook bigint(255),
        hidequote bigint(255),
        hidequotebook bigint(255),
        sortoption varchar(255),
        booksonpage bigint(255) NOT NULL DEFAULT 12,
        amazoncountryinfo varchar(255) NOT NULL DEFAULT 'US',
        stylepak varchar(255) NOT NULL DEFAULT 'Default',
        admindismiss bigint(255) NOT NULL DEFAULT 1,
        activeposttemplate varchar(255),
        activepagetemplate varchar(255),
        hidekindleprev bigint(255),
        hidegoogleprev bigint(255),
        hidebampurchase bigint(255),
        hidekobopurchase bigint(255),
        patreonaccess varchar(255),
        patreonrefresh varchar(255),
        patreonack varchar(255),
        adminmessage varchar(10000) NOT NULL DEFAULT '".ADMIN_MESSAGE."',
        PRIMARY KEY  (ID),
          KEY username (username)
  ) $charset_collate; ";

  // If table doesn't exist, create table and add initial data to it
  $test_name = $wpdb->prefix.'wpbooklist_jre_user_options';
  if($wpdb->get_var("SHOW TABLES LIKE '$test_name'") != $test_name) {
    dbDelta( $sql_create_table2 );
    $table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
    $wpdb->insert( $table_name, array('ID' => 1));
  } 

  $sql_create_table3 = "CREATE TABLE {$wpdb->wpbooklist_jre_page_options} 
  (
        ID bigint(190) auto_increment,
        username varchar(190),
        amazonaff varchar(255) NOT NULL DEFAULT 'wpbooklistid-20',
        amazonauth varchar(255),
        barnesaff varchar(255),
        itunesaff varchar(255) NOT NULL DEFAULT '1010lnPx',
        enablepurchase bigint(255),
        hidetitle bigint(255),
        hidebooktitle bigint(255),
        hidebookimage bigint(255),
        hidefinished bigint(255),
        hideauthor bigint(255),
        hidefrontendbuyimg bigint(255),
        hidefrontendbuyprice bigint(255),
        hidecolorboxbuyimg bigint(255),
        hidecolorboxbuyprice bigint(255),
        hidecategory bigint(255),
        hidepages bigint(255),
        hidepublisher bigint(255),
        hidepubdate bigint(255),
        hidesigned bigint(255),
        hidesubject bigint(255),
        hidecountry bigint(255),
        hidefirstedition bigint(255),
        hidefinishedsort bigint(255),
        hidesignedsort bigint(255),
        hidefirstsort bigint(255),
        hidesubjectsort bigint(255),
        hidefacebook bigint(255),
        hidemessenger bigint(255),
        hidetwitter bigint(255),
        hidegoogleplus bigint(255),
        hidepinterest bigint(255),
        hideemail bigint(255),
        hidedescription bigint(255),
        hidesimilar bigint(255),
        hideamazonreview bigint(255),
        hidenotes bigint(255),
        hidegooglepurchase bigint(255),
        hidefeaturedtitles bigint(255),
        hidebnpurchase bigint(255),
        hideitunespurchase bigint(255),
        hideamazonpurchase bigint(255),
        hiderating bigint(255),
        hidequote bigint(255),
        hidekindleprev bigint(255),
        hidegoogleprev bigint(255),
        hidebampurchase bigint(255),
        hidekobopurchase bigint(255),
        amazoncountryinfo varchar(255) NOT NULL DEFAULT 'US',
        stylepak varchar(255) NOT NULL DEFAULT 'Default',
        PRIMARY KEY  (ID),
          KEY username (username)
  ) $charset_collate; ";

  // If table doesn't exist, create table and add initial data to it
  $test_name = $wpdb->prefix.'wpbooklist_jre_page_options';
  if($wpdb->get_var("SHOW TABLES LIKE '$test_name'") != $test_name) {
    dbDelta( $sql_create_table3 );
    $table_name = $wpdb->prefix . 'wpbooklist_jre_page_options';
    $wpdb->insert( $table_name, array('ID' => 1)); 
  }

  $sql_create_table4 = "CREATE TABLE {$wpdb->wpbooklist_jre_post_options} 
  (
        ID bigint(190) auto_increment,
        username varchar(190),
        amazonaff varchar(255) NOT NULL DEFAULT 'wpbooklistid-20',
        amazonauth varchar(255),
        barnesaff varchar(255),
        itunesaff varchar(255) NOT NULL DEFAULT '1010lnPx',
        enablepurchase bigint(255),
        hidetitle bigint(255),
        hidebooktitle bigint(255),
        hidebookimage bigint(255),
        hidefinished bigint(255),
        hideauthor bigint(255),
        hidefrontendbuyimg bigint(255),
        hidefrontendbuyprice bigint(255),
        hidecolorboxbuyimg bigint(255),
        hidecolorboxbuyprice bigint(255),
        hidecategory bigint(255),
        hidepages bigint(255),
        hidepublisher bigint(255),
        hidepubdate bigint(255),
        hidesigned bigint(255),
        hidesubject bigint(255),
        hidecountry bigint(255),
        hidefirstedition bigint(255),
        hidefacebook bigint(255),
        hidemessenger bigint(255),
        hidetwitter bigint(255),
        hidegoogleplus bigint(255),
        hidepinterest bigint(255),
        hideemail bigint(255),
        hidedescription bigint(255),
        hidesimilar bigint(255),
        hideamazonreview bigint(255),
        hidenotes bigint(255),
        hidegooglepurchase bigint(255),
        hidefeaturedtitles bigint(255),
        hidebnpurchase bigint(255),
        hideitunespurchase bigint(255),
        hideamazonpurchase bigint(255),
        hiderating bigint(255),
        hidequote bigint(255),
        hidekindleprev bigint(255),
        hidegoogleprev bigint(255),
        hidebampurchase bigint(255),
        hidekobopurchase bigint(255),
        amazoncountryinfo varchar(255) NOT NULL DEFAULT 'US',
        stylepak varchar(255) NOT NULL DEFAULT 'Default',
        PRIMARY KEY  (ID),
          KEY username (username)
  ) $charset_collate; ";

  // If table doesn't exist, create table and add initial data to it
  $test_name = $wpdb->prefix.'wpbooklist_jre_post_options';
  if($wpdb->get_var("SHOW TABLES LIKE '$test_name'") != $test_name) {
    dbDelta( $sql_create_table4 );
    $table_name = $wpdb->prefix . 'wpbooklist_jre_post_options';
    $wpdb->insert( $table_name, array('ID' => 1)); 
  }

  $sql_create_table5 = "CREATE TABLE {$wpdb->wpbooklist_jre_list_dynamic_db_names} 
  (
        ID bigint(190) auto_increment,
        stylepak varchar(190),
        user_table_name varchar(255) NOT NULL,
        PRIMARY KEY  (ID),
          KEY stylepak (stylepak)
  ) $charset_collate; ";
  dbDelta( $sql_create_table5 ); 

  $sql_create_table6 = "CREATE TABLE {$wpdb->wpbooklist_jre_book_quotes} 
  (
        ID bigint(190) auto_increment,
        placement varchar(190),
        quote varchar(255),
        PRIMARY KEY  (ID),
          KEY placement (placement)
  ) $charset_collate; ";
  dbDelta( $sql_create_table6 );

  // Get the default quotes for adding to database
  $quote_string = file_get_contents(QUOTES_DIR.'defaultquotes.txt');
  $quote_array = explode(';', $quote_string);
  $table_name = $wpdb->prefix . 'wpbooklist_jre_book_quotes';
  foreach($quote_array as $quote){
    if(strlen($quote) > 100){
      $placement = 'ui';
    } else {
      $placement = 'book';
    }
    if(strlen($quote) > 1){
      $wpdb->insert( $table_name, array('quote' => $quote, 'placement' => $placement)); 
    }
  }

  $sql_create_table7 = "CREATE TABLE {$wpdb->wpbooklist_jre_saved_page_post_log} 
  (
        ID bigint(190) auto_increment,
        book_uid varchar(190),
        book_title varchar(255),
        post_id bigint(255),
        type varchar(255),
        post_url varchar(255),
        author bigint(255),
        active_template varchar(255),
        PRIMARY KEY  (ID),
          KEY book_uid (book_uid)
  ) $charset_collate; ";
  dbDelta( $sql_create_table7 );

  

  //Creating the table
  $sql_create_table8 = "CREATE TABLE {$wpdb->wpbooklist_jre_saved_books_for_featured} 
  (
        ID bigint(190) auto_increment,
        book_title varchar(190),
        isbn varchar(255),
        subject varchar(255),
        country varchar(255),
        author varchar(255),
        authorurl varchar(255),
        purchaseprice varchar(255),
        currentdate varchar(255),
        finishedyes varchar(255),
        finishedno varchar(255),
        booksignedyes varchar(255),
        booksignedno varchar(255),
        firsteditionyes varchar(255),
        firsteditionno varchar(255),
        yearfinished bigint(255),
        coverimage varchar(255),
        pagenum bigint(255),
        pubdate bigint(255),
        publisher varchar(255),
        weight bigint(255),
        category varchar(255),
        description MEDIUMTEXT, 
        notes MEDIUMTEXT,
        itunespage varchar(255),
        googlepreview varchar(255),
        amazondetailpage varchar(255),
        bookrating bigint(255),
        reviewiframe varchar(255),
        similarproducts MEDIUMTEXT,
        PRIMARY KEY  (ID),
          KEY book_title (book_title)
  ) $charset_collate; ";
  dbDelta( $sql_create_table8 );

  $sql_create_table9 = "CREATE TABLE {$wpdb->wpbooklist_jre_active_extensions} 
  (
        ID bigint(190) auto_increment,
        active varchar(190),
        extension_name varchar(255),
        PRIMARY KEY  (ID),
          KEY active (active)
  ) $charset_collate; ";
  dbDelta( $sql_create_table9 );

  $sql_create_table10 = "CREATE TABLE {$wpdb->wpbooklist_jre_storytime_stories} 
  (
        ID bigint(190) auto_increment,
        providername varchar(190),
        providerimg varchar(255),
        providerbio MEDIUMTEXT,
        content LONGTEXT,
        title varchar(255),
        category varchar(255),
        pageid bigint(255),
        postid bigint(255),
        storydate bigint(255),
        PRIMARY KEY  (ID),
          KEY providername (providername)
  ) $charset_collate; ";
  dbDelta( $sql_create_table10 );

  $sql_create_table11 = "CREATE TABLE {$wpdb->wpbooklist_jre_storytime_stories_settings} 
  (
        ID bigint(190) auto_increment,
        getstories bigint(255),
        createpost bigint(255),
        createpage bigint(255),
        storypersist bigint(255),
        deletedefault bigint(255),
        notifydismiss bigint(255) NOT NULL DEFAULT 1,
        newnotify bigint(255) NOT NULL DEFAULT 1,
        notifymessage MEDIUMTEXT,
        storytimestylepak varchar(255) NOT NULL DEFAULT 'default',
        PRIMARY KEY  (ID),
          KEY getstories (getstories)
  ) $charset_collate; ";
  dbDelta( $sql_create_table11 );

  // If table doesn't exist, create table and add initial data to it
  $table_name = $wpdb->prefix . 'wpbooklist_jre_storytime_stories_settings';
  if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    dbDelta( $sql_create_table11 );
    $table_name = $wpdb->prefix . 'wpbooklist_jre_storytime_stories_settings';
    $wpdb->insert( $table_name, array('ID' => 1)); 
  } 

  // Call the class that will insert default Storytime data into the table we just created. Seperate file simply because of length of content.
  require_once(CLASS_DIR.'class-storytime.php');
  $storytime_class = new WPBookList_Storytime('install');
}

// Function for deleting tables upon deletion of plugin
function wpbooklist_jre_delete_tables() {
    global $wpdb;
    $table1 = $wpdb->prefix."wpbooklist_jre_saved_book_log";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table1", $table1));
    
    $table2 = $wpdb->prefix."wpbooklist_jre_saved_page_post_log";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table2", $table2));

    $table4 = $wpdb->prefix."wpbooklist_jre_saved_books_for_featured";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table4", $table4));

    $table5 = $wpdb->prefix."wpbooklist_jre_user_options";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table5", $table5));

    $table6 = $wpdb->prefix."wpbooklist_jre_page_options";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table6", $table6));

    $table7 = $wpdb->prefix."wpbooklist_jre_post_options";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table7", $table7));

    $table8 = $wpdb->prefix."wpbooklist_jre_book_quotes";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table8", $table8));

    $table9 = $wpdb->prefix."wpbooklist_jre_book_quotes";
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table9", $table9));
    
    $table3 = $wpdb->prefix."wpbooklist_jre_list_dynamic_db_names";
    $user_created_tables = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table3", $table3), $table3);
    foreach($user_created_tables as $utable){
      $table = $wpdb->prefix."wpbooklist_jre_".$utable->user_table_name;
      $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table", $table));
    }
    $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS $table3", $table3));
}

//Function to add the admin menu
function wpbooklist_jre_my_admin_menu() {
  add_menu_page( 'WPBookList Options', 'WPBookList', 'manage_options', 'WPBookList-Options', 'wpbooklist_jre_admin_page_function', ROOT_IMG_URL.'icon-256x256.png', 6  );

  $submenu_array = array(
    "Books",
    "Display Options",
    "Settings",
    "StoryTime",
    "Extensions",
    "StylePaks",
    "Template Paks"
  );

  // Filter to allow the addition of a new subpage
  if(has_filter('wpbooklist_add_sub_menu')) {
    $submenu_array = apply_filters('wpbooklist_add_sub_menu', $submenu_array);
  }

  foreach($submenu_array as $key=>$submenu){
    $menu_slug = strtolower(str_replace(' ', '-', $submenu));
    add_submenu_page('WPBookList-Options', 'WPBookList', $submenu, 'manage_options', 'WPBookList-Options-'.$menu_slug, 'wpbooklist_jre_admin_page_function');
  }

  remove_submenu_page('WPBookList-Options', 'WPBookList-Options');


}

function wpbooklist_jre_admin_page_function(){
  global $wpdb;
  require_once(ROOT_INCLUDES_UI_ADMIN_DIR.'class-admin-master-ui.php');
}


// Function to allow users to specify which table they want displayed by passing as an argument in the shortcode
function wpbooklist_jre_plugin_dynamic_shortcode_function($atts){
  global $wpdb;

  extract(shortcode_atts(array(
          'table' => $wpdb->prefix."wpbooklist_jre_saved_book_log",
          'action' => 'colorbox'
  ), $atts));

  // Set up the table
  if(isset($atts['table'])){
    $which_table = $wpdb->prefix . 'wpbooklist_jre_'.$table;
  } else {
    $which_table = $wpdb->prefix."wpbooklist_jre_saved_book_log";
  }

  // set up the action taken when cover image is clicked on
  if(isset($atts['action'])){
    $action = $atts['action'];
  } else {
    $action = 'colorbox';
  }

  if($atts == null){
    $which_table = $wpdb->prefix.'wpbooklist_jre_saved_book_log';
    $action = 'colorbox';
  }

  $offset = 0;

  ob_start();
  include_once( ROOT_INCLUDES_UI . 'class-frontend-library-ui.php');
  $front_end_library_ui = new WPBookList_Front_End_Library_UI($which_table, 'initial');
  return ob_get_clean();
}
 

// The function that determines which template to load for WPBookList Pages
function wpbooklist_set_page_post_template( $content ) {
  global $wpdb;

  $id = get_the_id();
  $blog_url = get_permalink( get_option( 'page_for_posts' ) );
  $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  if($blog_url == $actual_link){
  
  }

  $table_name = $wpdb->prefix.'wpbooklist_jre_saved_page_post_log';
  $page_post_row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE post_id = %d", $id));

  // If current page/post is a WPBookList Page or Post...
  if($page_post_row != null){

    if($page_post_row->type == 'page'){
      $table_name = $wpdb->prefix.'wpbooklist_jre_page_options';
      $options_page_row = $wpdb->get_row("SELECT * FROM $table_name");
    }

    if($page_post_row->type == 'post'){
      $table_name = $wpdb->prefix.'wpbooklist_jre_post_options';
      $options_post_row = $wpdb->get_row("SELECT * FROM $table_name");
    }

    $options_table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
    $options_row = $wpdb->get_row("SELECT * FROM $options_table_name");
    $amazon_country_info = $options_row->amazoncountryinfo;

    $table_name = $wpdb->prefix.'wpbooklist_jre_saved_book_log';
    $book_row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE book_uid = %s", $page_post_row->book_uid));


    // If book wasn't found in default library, loop through and search custom libraries
    if($book_row == null){
      $table_name = $wpdb->prefix . 'wpbooklist_jre_list_dynamic_db_names';
      $db_row = $wpdb->get_results("SELECT * FROM $table_name");
      
      foreach($db_row as $row){
        $table_name = $wpdb->prefix.'wpbooklist_jre_'.$row->user_table_name;
        $book_row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE book_uid = %s", $page_post_row->book_uid));
        if($book_row == null){
          continue;
        } else {
          break;
        }
      }
    }

    switch ($amazon_country_info) {
          case "au":
              $book_row->amazon_detail_page = str_replace(".com",".com.au", $book_row->amazon_detail_page);
              $book_row->$review_iframe = str_replace(".com",".com.au", $this->$review_iframe);
              break;
          case "br":
              $book_row->amazon_detail_page = str_replace(".com",".com.br", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".com.br", $book_row->review_iframe);
              break;
          case "ca":
              $book_row->amazon_detail_page = str_replace(".com",".ca", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".ca", $book_row->review_iframe);
              break;
          case "cn":
              $book_row->amazon_detail_page = str_replace(".com",".cn", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".cn", $book_row->review_iframe);
              break;
          case "fr":
              $book_row->amazon_detail_page = str_replace(".com",".fr", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".fr", $book_row->review_iframe);
              break;
          case "de":
              $book_row->amazon_detail_page = str_replace(".com",".de", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".de", $book_row->review_iframe);
              break;
          case "in":
              $book_row->amazon_detail_page = str_replace(".com",".in", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".in", $book_row->review_iframe);
              break;
          case "it":
              $book_row->amazon_detail_page = str_replace(".com",".it", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".it", $book_row->review_iframe);
              break;
          case "jp":
              $book_row->amazon_detail_page = str_replace(".com",".co.jp", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".co.jp", $book_row->review_iframe);
              break;
          case "mx":
              $book_row->amazon_detail_page = str_replace(".com",".com.mx", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".com.mx", $book_row->review_iframe);
              break;
          case "nl":
              $book_row->amazon_detail_page = str_replace(".com",".nl", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".nl", $book_row->review_iframe);
              break;
          case "es":
              $book_row->amazon_detail_page = str_replace(".com",".es", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".es", $book_row->review_iframe);
              break;
          case "uk":
              $book_row->amazon_detail_page = str_replace(".com",".co.uk", $book_row->amazon_detail_page);
              $book_row->review_iframe = str_replace(".com",".co.uk", $book_row->review_iframe);
              break;
          case "sg":
              $this->amazon_detail_page = str_replace(".com",".com.sg", $this->amazon_detail_page);
              $this->review_iframe = str_replace(".com",".com.sg", $this->review_iframe);
              break;
          default:
              //$book_row->amazon_detail_page = $saved_book->amazon_detail_page;//filter_var($saved_book->amazon_detail_page, FILTER_SANITIZE_URL);
    }

    

    // Getting/creating quotes
    $quotes = file_get_contents(QUOTES_DIR.'defaultquotes.txt');
    $quotes_array = explode(';', $quotes);
    $quote = $quotes_array[array_rand($quotes_array)];
    $quote_array_2 = explode('-', $quote);

    if(sizeof($quote_array_2) == 2){
      $quote = '<span id="wpbooklist-quote-italic">'.$quote_array_2[0].'</span> - <span id="wpbooklist-quote-bold">'.$quote_array_2[1].'</span>';
    }

    // Getting Similar titles
    if($page_post_row->type == 'post'){
      $similar_string = '<span id="wpbooklist-post-span-hidden" style="display:none;"></span>';
    }

    if($page_post_row->type == 'page'){
      $similar_string = '<span id="wpbooklist-page-span-hidden" style="display:none;"></span>';
    }

    $similarproductsarray = explode(';bsp;',$book_row->similar_products);
    $similarproductsarray = array_unique($similarproductsarray);
    $similar_products_array = array_values($similarproductsarray);
    foreach($similar_products_array as $key=>$prod){
      $arr = explode("---", $prod, 2);
      $asin = $arr[0];


      // Removing my Affiliate ID, as it's only needed for initial API calls when Adding/Editing/Searching for books
      if($options_row->amazonaff == 'wpbooklistid-20'){
        $options_row->amazonaff = '';
      }


      $image = 'http://images.amazon.com/images/P/'.$asin.'.01.LZZZZZZZ.jpg';
      $url = 'https://www.amazon.com/dp/'.$asin.'?tag='.$options_row->amazonaff;
      if(strlen($image) > 51 ){
        if($page_post_row->type == 'page'){
          $similar_string = $similar_string.'<a class="wpbooklist-similar-link-post" target="_blank" href="'.$url.'"><img class="wpbooklist-similar-image-page" src="'.$image.'" /></a>';
        }
        if($page_post_row->type == 'post'){
          $similar_string = $similar_string.'<a class="wpbooklist-similar-link-post" target="_blank" href="'.$url.'"><img class="wpbooklist-similar-image-post" src="'.$image.'" /></a>';
        }
      }
    }

    $similar_string = $similar_string.'</div>';

    $table_name_options = $wpdb->prefix . 'wpbooklist_jre_user_options';
    $row = $wpdb->get_row("SELECT * FROM $table_name_options");
    $active_post_template = $row->activeposttemplate;
    $active_page_template = $row->activepagetemplate;

    // Double-check that Amazon review isn't expired
    require_once(CLASS_DIR.'class-book.php');
    $book = new WPBookList_Book($book_row->ID, $table_name);
    $book->refresh_amazon_review($book_row->ID, $table_name);

    // Removing my Affiliate ID, as it's only needed for initial API calls when Adding/Editing/Searching for books
    if(stripos($book_row->amazon_detail_page, 'tag=wpbooklistid-20') !== false){
      $book_row->amazon_detail_page = str_replace('tag=wpbooklistid-20', '', $book_row->amazon_detail_page);
    }

    if($page_post_row->type == 'page'){

      switch ($active_page_template) {
        case 'Page-Template-1':
          include(PAGE_TEMPLATES_UPLOAD_DIR.'Page-Template-1.php');
          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string41.$string42.$string43.$string44.$string45.$string46.$string47;
        break;
        case 'Page-Template-2':
          include(PAGE_TEMPLATES_UPLOAD_DIR.'Page-Template-2.php');
          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string41.$string42.$string43.$string44.$string45.$string46.$string47;
        break;
        case 'Page-Template-3':
          include(PAGE_TEMPLATES_UPLOAD_DIR.'Page-Template-3.php');
          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string41.$string42.$string43.$string44.$string45.$string46.$string47;
        break;
        case 'Page-Template-4':
          include(PAGE_TEMPLATES_UPLOAD_DIR.'Page-Template-4.php');
          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string41.$string42.$string43.$string44.$string45.$string46.$string47;
        break;
        case 'Page-Template-5':
          include(PAGE_TEMPLATES_UPLOAD_DIR.'Page-Template-5.php');
          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string41.$string42.$string43.$string44.$string45.$string46.$string47;
        break;
        default:
          include(PAGE_POST_TEMPLATES_DEFAULT_DIR.'page-template-default.php');
          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string50.$string51.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string48.$string49.$string41.$string42.$string43.$string44.$string45.$string46.$string47;
        break;
      }
    }

    if($page_post_row->type == 'post'){

      switch ($active_post_template) {
        case 'Post-Template-1':
          include(POST_TEMPLATES_UPLOAD_DIR.'Post-Template-1.php');
          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string41.$string42.$string43.$string44.$string45.$string46.$string47;
        break;
        case 'Post-Template-2':
          include(POST_TEMPLATES_UPLOAD_DIR.'Post-Template-2.php');
          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string41.$string42.$string43.$string44.$string45.$string46.$string47;
        break;
        case 'Post-Template-3':
          include(POST_TEMPLATES_UPLOAD_DIR.'Post-Template-3.php');
          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string41.$string42.$string43.$string44.$string45.$string46.$string47;
        break;
        case 'Post-Template-4':
          include(POST_TEMPLATES_UPLOAD_DIR.'Post-Template-4.php');
          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string41.$string42.$string43.$string44.$string45.$string46.$string47;
        break;
        case 'Post-Template-5':
          include(POST_TEMPLATES_UPLOAD_DIR.'Post-Template-5.php');
          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string41.$string42.$string43.$string44.$string45.$string46.$string47;
        break;
        default:
          include(PAGE_POST_TEMPLATES_DEFAULT_DIR.'post-template-default.php');
          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string50.$string51.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string48.$string49.$string41.$string42.$string43.$string44.$string45.$string46.$string47;
        break;
      }
    }




    /*
    switch ($page_post_row->active_template) {
      case 'template1':
        if($page_post_row->type == 'page'){
          include(PAGE_TEMPLATES_UPLOAD_DIR.'page-template-1.php');
          //return $content;
        } else {
          include(PAGE_TEMPLATES_UPLOAD_DIR.'post-template-1.php');
          //return $content;
        }
        break;
      case 'template2':
        if($page_post_row->type == 'page'){
          include(PAGE_TEMPLATES_UPLOAD_DIR.'page-template-2.php');
         // return $content;
        } else {
          include(PAGE_TEMPLATES_UPLOAD_DIR.'post-template-2.php');
          //return $content;
        }
        break;
      case 'default':
        if($page_post_row->type == 'page'){
          include(PAGE_TEMPLATES_DEFAULT_DIR.'page-template-default.php');

          // Double-check that Amazon review isn't expired
          require_once(CLASS_DIR.'class-book.php');
          $book = new WPBookList_Book($book_row->ID, $table_name);
          $book->refresh_amazon_review($book_row->ID, $table_name);

          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string41.$string42.$string43.$string44.$string45.$string46.$string47;

        } else {
          include(PAGE_TEMPLATES_DEFAULT_DIR.'post-template-default.php');

          // Double-check that Amazon review isn't expired
          require_once(CLASS_DIR.'class-book.php');
          $book = new WPBookList_Book($book_row->ID, $table_name);
          $book->refresh_amazon_review($book_row->ID, $table_name);

          return $content.$string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10.$string11.$string12.$string13.$string14.$string15.$string16.$string17.$string18.$string19.$string20.$string21.$string22.$string23.$string24.$string25.$string26.$string27.$string28.$string29.$string30.$string31.$string32.$string33.$string34.$string35.$string36.$string37.$string38.$string39.$string40.$string41.$string42.$string43.$string44.$string45.$string46.$string47;
        }
        break;
      default:
        //return $content;
        break;
    }
    */

  }

  // Making double-sure content gets returned.
  return $content; 
}

// Handles various aestetic functions for the front end
function wpbooklist_various_aestetic_bits_front_end(){

  $transstring1 = __('Search...','wpbooklist');

  ?>
  <script type="text/javascript" >
  "use strict";
  jQuery(document).ready(function($) {

    // Clears the frontend search box on click if it has it's default value
    $(document).on("click",".wpbooklist-search-text-class", function(event){
      if($(this).val() == '<?php echo $transstring1; ?>'){
        $(this).val('');
      }
    });

    // Enables the 'Read More' link for the description block in a post utilizing the readmore.js file
    $('#wpbl-posttd-book-description-contents').readmore({
      speed: 175,
      heightMargin: 16,
      collapsedHeight: 100,
      moreLink: '<a href="#">Read more</a>',
      lessLink: '<a href="#">Read less</a>'
    });

    // Enables the 'Read More' link for the notes block in a post utilizing the readmore.js file
    $('#wpbl-posttd-book-notes-contents').readmore({
      speed: 75,
      heightMargin: 16,
      collapsedHeight: 100,
      moreLink: '<a href="#">Read more</a>',
      lessLink: '<a href="#">Read less</a>'
    });

    // Enables the 'Read More' link for the description block in a post utilizing the readmore.js file
    $('#wpbl-pagetd-book-description-contents').readmore({
      speed: 175,
      heightMargin: 16,
      collapsedHeight: 100,
      moreLink: '<a href="#">Read more</a>',
      lessLink: '<a href="#">Read less</a>'
    });

    // Enables the 'Read More' link for the notes block in a post utilizing the readmore.js file
    $('#wpbl-pagetd-book-notes-contents').readmore({
      speed: 75,
      heightMargin: 16,
      collapsedHeight: 100,
      moreLink: '<a href="#">Read more</a>',
      lessLink: '<a href="#">Read less</a>'
    });
  });
  </script>
  <?php
}

// Handles various aestetic functions for the back end
function wpbooklist_various_aestetic_bits_back_end(){
  wp_enqueue_media();
  ?>
  <script type="text/javascript" >
  "use strict";
  jQuery(document).ready(function($) {

    // Making the last active library the viewed library after page reload
    if(window.location.href.includes('library=') && window.location.href.includes('tab=edit-books') && window.location.href.includes('WPBookList')){
          $('#wpbooklist-editbook-select-library').val(window.location.href.substr( window.location.href.lastIndexOf("=")+1));
          $('#wpbooklist-editbook-select-library').trigger("change");
    }

    // Highlight active tab
    if(window.location.href.includes('&tab=')){
      $('.nav-tab').each(function(){
        if(window.location.href == '<?php echo admin_url();?>admin.php'+$(this).attr('href')){
          $(this).first().css({'background-color':'#F05A1A', 'color':'white'})
        }
      })
    } else {
      $('.nav-tab').first().css({'background-color':'#F05A1A', 'color':'white'})
    }

    // Only allow one localization checkbox to be checked
    $(".wpbooklist-localization-checkbox").change(function(){
      $('[name=us-based-book-info]').attr('checked', false);
      $('[name=uk-based-book-info]').attr('checked', false);
      $('[name=au-based-book-info]').attr('checked', false);
      $('[name=br-based-book-info]').attr('checked', false);
      $('[name=ca-based-book-info]').attr('checked', false);
      $('[name=cn-based-book-info]').attr('checked', false);
      $('[name=fr-based-book-info]').attr('checked', false);
      $('[name=de-based-book-info]').attr('checked', false);
      $('[name=in-based-book-info]').attr('checked', false);
      $('[name=it-based-book-info]').attr('checked', false);
      $('[name=jp-based-book-info]').attr('checked', false);
      $('[name=mx-based-book-info]').attr('checked', false);
      $('[name=es-based-book-info]').attr('checked', false); 
      $('[name=nl-based-book-info]').attr('checked', false);
      $('[name=sg-based-book-info]').attr('checked', false);
      $(this).attr('checked', true);
    });

    // Handles the enabling/disabling of the 'Create a Library' button and input placeholder text
    $(".wpbooklist-dynamic-input").on('click', function() { 
      var currentVal = $(".wpbooklist-dynamic-input").val();
      if(currentVal == 'Create a New Library Here...'){
        $(".wpbooklist-dynamic-input").val('');
      }
    });
    $(".wpbooklist-dynamic-input").bind('input', function() { 
      var currentVal = $(".wpbooklist-dynamic-input").val();
      if((currentVal.length > 0) && (currentVal != 'Create a New Library Here...')){
        $("#wpbooklist-dynamic-shortcode-button").attr('disabled', false);
      }
    });

    // Handles the 'check all' and 'uncheck all' function of the display options
    $("#wpbooklist-check-all").on('click', function() { 
      $("#wpbooklist-uncheck-all").prop('checked', false);
      $('#wpbooklist-jre-backend-options-table input').each(function(){
        $(this).prop('checked', true);
      })
    });
    $("#wpbooklist-uncheck-all").on('click', function() { 
      $("#wpbooklist-check-all").prop('checked', false);
      $('#wpbooklist-jre-backend-options-table input').each(function(){
        $(this).prop('checked', false);
      })
    });

  });
  </script>
  <?php
}


// Shortcode function for displaying book cover image/link
function wpbooklist_book_cover_shortcode($atts) {
  global $wpdb;

  extract(shortcode_atts(array(
          'table' => $wpdb->prefix."saved_book_log",
          'isbn' => '',
          'width' => '100',
          'align' => 'left',
          'margin' => '5px',
          'action' => 'bookview',
          'display' => 'justimage'
  ), $atts));

  if($atts == null){
    $table = $wpdb->prefix.'wpbooklist_jre_saved_book_log';
    $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table  LIMIT %d",1));
    $isbn = $options_row[0]->isbn;
    $width = '100';
    //echo 'table: '.$table.PHP_EOL.'isbn: '.$isbn;
  }

  if(!isset($atts['isbn']) && !isset($atts['table']) ){
    $table = $wpdb->prefix.'wpbooklist_jre_saved_book_log';
    $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table LIMIT %d",1));
    $isbn = $options_row[0]->isbn;
  }

  if(!isset($atts['isbn']) && isset($atts['table']) ){
    $table = $wpdb->prefix.'wpbooklist_jre_'.strtolower($table);
    $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table  LIMIT %d",1));
    $isbn = $options_row[0]->isbn;

  }

  if(isset($atts['isbn']) && !isset($atts['table']) ){
    $table = $wpdb->prefix.'wpbooklist_jre_saved_book_log';
  }

  if(isset($atts['isbn']) && isset($atts['table'])){
    $table = $wpdb->prefix.'wpbooklist_jre_'.strtolower($table);
  }

  $isbn = str_replace('-','', $isbn);
  $options_row = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table WHERE isbn = %s", $isbn));
  if(sizeof($options_row) == 0){
    echo __("This book isn't in your Library! Please check the ISBN/ASIN number you provided.",'wpbooklist');
  } else {
    $image = $options_row[0]->image;
    $link = $options_row[0]->amazon_detail_page;
    $table_name_options = $wpdb->prefix . 'wpbooklist_jre_user_options';
    $options_results = $wpdb->get_row("SELECT * FROM $table_name_options");

    // Replace with user's affiliate id, if available
    $amazonaff = $options_results->amazonaff;
    $link = str_replace('wpbooklistid-20', $amazonaff, $link);

    $amazoncountryinfo = $options_results->amazoncountryinfo;
    switch ($amazoncountryinfo) {
        case "au":
            $link = str_replace(".com",".com.au", $link);
            break;
        case "br":
            $link = str_replace(".com",".com.br", $link);
            break;
        case "ca":
            $link = str_replace(".com",".ca", $link);
            break;
        case "cn":
            $link = str_replace(".com",".cn", $link);
            break;
        case "fr":
            $link = str_replace(".com",".fr", $link);
            break;
        case "de":
            $link = str_replace(".com",".de", $link);
            break;
        case "in":
            $link = str_replace(".com",".in", $link);
            break;
        case "it":
            $link = str_replace(".com",".it", $link);
            break;
        case "jp":
            $link = str_replace(".com",".co.jp", $link);
            break;
        case "mx":
            $link = str_replace(".com",".com.mx", $link);
            break;
        case "nl":
            $link = str_replace(".com",".nl", $link);
            break;
        case "es":
            $link = str_replace(".com",".es", $link);
            break;
        case "uk":
            $link = str_replace(".com",".co.uk", $link);
            break;
        default:
            $link;
    }//end switch 

    $class = 'class="wpbooklist_jre_book_cover_shortcode_link wpbooklist-show-book-colorbox"';
    if(isset($atts['action'])){
      switch ($atts['action']) {
        case "amazon":
          $class = 'class="wpbooklist_jre_book_cover_shortcode_link"';
          $link = $link;
        break;
        case "googlebooks":
          $class = 'class="wpbooklist_jre_book_cover_shortcode_link"';
          $link = $options_row[0]->google_preview;
          if($link == null){
            $link = $options_row[0]->amazon_detail_page;
          }
        break;
        case "ibooks":
          $class = 'class="wpbooklist_jre_book_cover_shortcode_link"';
          $link = $options_row[0]->itunes_page;
          if($link == null){
            $link = $options_row[0]->amazon_detail_page;
          }
        break;
        case "booksamillion":
          $class = 'class="wpbooklist_jre_book_cover_shortcode_link"';
          $link = $options_row[0]->bam_link;
          if($link == null){
            $link = $options_row[0]->amazon_detail_page;
          }
        break;
        case "barnesandnoble":
          $class = 'class="wpbooklist_jre_book_cover_shortcode_link"';
          $link = $options_row[0]->bn_link;
          if($link == null){
            $link = $options_row[0]->amazon_detail_page;
          }
        break;
        case "kobo":
          $class = 'class="wpbooklist_jre_book_cover_shortcode_link"';
          $link = $options_row[0]->kobo_link;
          if($link == null){
            $link = $options_row[0]->amazon_detail_page;
          }
        break;
        case "bookview":
          $class = 'class="wpbooklist_jre_book_cover_shortcode_link wpbooklist-show-book-colorbox"';
        default:
          $class = 'class="wpbooklist_jre_book_cover_shortcode_link wpbooklist-show-book-colorbox"';
          $link = $link;
        break;
      }
    } else {
      $link = $link;
      $class = 'class="wpbooklist_jre_book_cover_shortcode_link wpbooklist-show-book-colorbox"';
    }

    $final_link = '<div style="float:'.$align.'; margin:'.$margin.'; margin-bottom:50px;" class="wpbooklist-shortcode-entire-container"><a  style="z-index:9; float:'.$align.'; margin:'.$margin.';" '.$class.' data-booktable="'.$table.'" data-bookid="'.$options_row[0]->ID.'" '.$class.' target="_blank" href="'.$link.'"><img style="min-width:150px; margin-right: 5px; width:'.$width.'px!important" src="'.$image.'"/></a>';

    $display = '';
    if(isset($atts['display'])){
      switch ($atts['display']) {
        case "justimage":
          $display = '';
        break;
        case "excerpt":

          $final_link = str_replace('float:right', 'float:left', $final_link);
          $final_link = str_replace('float:right', 'float:left', $final_link);

          $text = $options_row[0]->description;

          $text = str_replace('<br />', ' ', html_entity_decode($text));
          $text = str_replace('<br/>', ' ', html_entity_decode($text));
          $text = str_replace('<div>', '', html_entity_decode($text));
          $text = str_replace('</div>', '', html_entity_decode($text));
          //echo highlight_string($text);
          //$text = strip_tags($text);
          
          $limit = 40;
          if (str_word_count($text, 0) > $limit) {
              $words = str_word_count($text, 2);
              $pos = array_keys($words);
              $text = substr($text, 0, $pos[$limit]) . '...';
          }

          $title = $options_row[0]->title;
          $limit = 10;
          if (str_word_count($title, 0) > $limit) {
              $words = str_word_count($title, 2);
              $pos = array_keys($words);
              $title = substr($title, 0, $pos[$limit]) . '...';
          }
          
          // if the 'allow_url_fopen' directive is allowed, use getimagesize(), otherwise do the roundabout cUrl way to retrieve the remote image and determine the size
          if( ini_get('allow_url_fopen') ) {
              $size = getimagesize($image);
          }
          else {
              $ch = curl_init();
              $timeout = 5; // set to zero for no timeout
              curl_setopt ($ch, CURLOPT_URL, $image);
              curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
              $file_contents = curl_exec($ch);
              curl_close($ch);

              $new_image = ImageCreateFromString($file_contents);
              imagejpeg($new_image, "temp.png",100);

              // Get new dimensions
              $size = getimagesize("temp.png");

          }
          
          $origwidth = $size[0];
          $origheight = $size[1];
          $final_height = ($origheight*$width)/$origwidth;

          $descheight = $final_height-50-40;

          $string1 = '';
          $string2 = '';
          $string3 = '';
          $string4 = '';
          $string5 = '';
          $string6 = '';
          $display = '<div style="display:grid; height:'.$final_height.'px" class="wpbooklist-shortcode-below-link-div">
            <h3 class="wpbooklist-shortcode-h3" style="text-align:'.$align.';">'.$title.'</h3>
            <div style="text-align:'.$align.'; position:relative; bottom:5px; class="wpbooklist-shortcode-below-link-excerpt">'.$text.'</div>
            <div class="wpbooklist-shortcode-link-holder-media" style="text-align:'.$align.'; bottom:-10px; class="wpbooklist-shortcode-purchase-links">';

            if($options_row[0]->amazon_detail_page != null){
              $string1 = '<a class="wpbooklist-purchase-img" href="'.$options_row[0]->amazon_detail_page.'" target="_blank">
                <img src="'.ROOT_IMG_URL.'amazon.png">
              </a>';
            }

            $string2 = '<a class="wpbooklist-purchase-img" href="http://www.barnesandnoble.com/s/'.$options_row[0]->isbn.'" target="_blank">
                <img src="'.ROOT_IMG_URL.'bn.png">
              </a>';

            if($options_row[0]->google_preview != null){
              $string3 = '<a class="wpbooklist-purchase-img" href="'.$options_row[0]->google_preview.'" target="_blank">
                <img src="'.ROOT_IMG_URL.'googlebooks.png">
              </a>';
            }

            if($options_row[0]->itunes_page != null){
              $string4 = '<a class="wpbooklist-purchase-img" href="'.$options_row[0]->itunes_page.'" target="_blank">
                <img src="'.ROOT_IMG_URL.'ibooks.png" id="wpbooklist-itunes-img">
              </a>';
            }

            if($options_row[0]->bam_link != null){
              $string5 = '<a class="wpbooklist-purchase-img" href="'.$options_row[0]->bam_link.'" target="_blank">
                <img src="'.ROOT_IMG_URL.'bam-icon.jpg">
              </a>';
            }

            if($options_row[0]->kobo_link != null){
              $string6 = '<a class="wpbooklist-purchase-img" href="'.$options_row[0]->kobo_link.'" target="_blank">
                <img src="'.ROOT_IMG_URL.'kobo-icon.png">
              </a>';
            }


            $string7 ='</div>
          </div></div>';

          $display = $display.$string1.$string2.$string3.$string4.$string5.$string6.$string7;

        break;
        default:
          $display = '';
        break;
      }
    }
    return $final_link.$display;
  }
 
}

// Function to run any code that is needed to modify the plugin between different versions
function wpbooklist_upgrade_function(){

  global $wpdb;
  // Get current version #
  $table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
  $row = $wpdb->get_row("SELECT * FROM $table_name");
  $version = $row->version;

  // If version number does not match the current version number found in wpbooklist.php
  if($version != WPBOOKLIST_VERSION_NUM){

    // ADD COLUMNS TO THE 'wpbooklist_jre_user_options' TABLE
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'activeposttemplate'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD activeposttemplate varchar( 255 ) NOT NULL DEFAULT 'default'");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'activepagetemplate'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD activepagetemplate varchar( 255 ) NOT NULL DEFAULT 'default'");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'hidekindleprev'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD hidekindleprev bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'hidegoogleprev'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD hidegoogleprev bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'hidekobopurchase'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD hidekobopurchase bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'hidebampurchase'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD hidebampurchase bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'hidesubject'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD hidesubject bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'hidecountry'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD hidecountry bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'hidefilter'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD hidefilter bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'hidefinishedsort'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD hidefinishedsort bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'hidesignedsort'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD hidesignedsort bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'hidefirstsort'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD hidefirstsort bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'hidesubjectsort'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD hidesubjectsort bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'patreonaccess'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD patreonaccess varchar(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'patreonrefresh'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD patreonrefresh varchar(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name` LIKE 'patreonack'") == 0){
       $wpdb->query("ALTER TABLE $table_name ADD patreonack bigint(255)");
    }


    // ADD COLUMNS TO THE 'wpbooklist_jre_page_options' TABLE
    $table_name_page_options = $wpdb->prefix . 'wpbooklist_jre_page_options';
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_page_options` LIKE 'hidekindleprev'") == 0){
       $wpdb->query("ALTER TABLE $table_name_page_options ADD hidekindleprev bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_page_options` LIKE 'hidegoogleprev'") == 0){
       $wpdb->query("ALTER TABLE $table_name_page_options ADD hidegoogleprev bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_page_options` LIKE 'hidekobopurchase'") == 0){
       $wpdb->query("ALTER TABLE $table_name_page_options ADD hidekobopurchase bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_page_options` LIKE 'hidebampurchase'") == 0){
       $wpdb->query("ALTER TABLE $table_name_page_options ADD hidebampurchase bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_page_options` LIKE 'hidesubject'") == 0){
       $wpdb->query("ALTER TABLE $table_name_page_options ADD hidesubject bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_page_options` LIKE 'hidecountry'") == 0){
       $wpdb->query("ALTER TABLE $table_name_page_options ADD hidecountry bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_page_options` LIKE 'hidefilter'") == 0){
       $wpdb->query("ALTER TABLE $table_name_page_options ADD hidefilter bigint(255)");
    }

    // ADD COLUMNS TO THE 'wpbooklist_jre_post_options' TABLE
    $table_name_post_options = $wpdb->prefix . 'wpbooklist_jre_post_options';
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_post_options` LIKE 'hidekindleprev'") == 0){
       $wpdb->query("ALTER TABLE $table_name_post_options ADD hidekindleprev bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_post_options` LIKE 'hidegoogleprev'") == 0){
       $wpdb->query("ALTER TABLE $table_name_post_options ADD hidegoogleprev bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_post_options` LIKE 'hidekobopurchase'") == 0){
       $wpdb->query("ALTER TABLE $table_name_post_options ADD hidekobopurchase bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_post_options` LIKE 'hidebampurchase'") == 0){
       $wpdb->query("ALTER TABLE $table_name_post_options ADD hidebampurchase bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_post_options` LIKE 'hidesubject'") == 0){
       $wpdb->query("ALTER TABLE $table_name_post_options ADD hidesubject bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_post_options` LIKE 'hidecountry'") == 0){
       $wpdb->query("ALTER TABLE $table_name_post_options ADD hidecountry bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_post_options` LIKE 'hidefilter'") == 0){
       $wpdb->query("ALTER TABLE $table_name_post_options ADD hidefilter bigint(255)");
    }

    // Add columns to the default WPBookList table, if they don't exist.
    $table_name_default = $wpdb->prefix . 'wpbooklist_jre_saved_book_log';
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'subject'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD subject varchar(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'country'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD country varchar(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'woocommerce'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD woocommerce varchar(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'kobo_link'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD kobo_link varchar(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'bam_link'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD bam_link varchar(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'bn_link'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD bn_link varchar(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'lendstatus'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD lendstatus varchar(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'currentlendemail'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD currentlendemail varchar(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'currentlendname'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD currentlendname varchar(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'lendable'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD lendable varchar(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'copies'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD copies bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'copieschecked'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD copieschecked bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'lendedon'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD lendedon bigint(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'authorfirst'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD authorfirst varchar(255)");
    }
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'authorlast'") == 0){
       $wpdb->query("ALTER TABLE $table_name_default ADD authorlast varchar(255)");
    }


  

    // Modify the ISBN column in the default library to be varchar, which will allow the storage of ASIN numbers
    $wpdb->query("ALTER TABLE $table_name_default MODIFY isbn varchar( 190 )");



    // Modify any existing custom libraries - both the book data and the settings data
    $table_dyna = $wpdb->prefix."wpbooklist_jre_list_dynamic_db_names";
    $user_created_tables = $wpdb->get_results("SELECT * FROM $table_dyna");
    foreach($user_created_tables as $utable){

      $table = $wpdb->prefix."wpbooklist_jre_".$utable->user_table_name;

      // This is how we get the column type
      $result = $wpdb->get_row("SHOW COLUMNS FROM `$table` LIKE 'isbn'");
      if($result->Type != 'varchar(190)'){
        $wpdb->query("ALTER TABLE $table MODIFY isbn varchar( 190 )");
      }

      // Add WooCommerce column
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'woocommerce'") == 0){
       $wpdb->query("ALTER TABLE $table ADD woocommerce varchar(255)");
      }

      // Add additional columns that may not be there already
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'kobo_link'") == 0){
         $wpdb->query("ALTER TABLE $table ADD kobo_link varchar(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'bam_link'") == 0){
         $wpdb->query("ALTER TABLE $table ADD bam_link varchar(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'bn_link'") == 0){
         $wpdb->query("ALTER TABLE $table ADD bn_link varchar(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'lendstatus'") == 0){
         $wpdb->query("ALTER TABLE $table ADD lendstatus varchar(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'currentlendemail'") == 0){
         $wpdb->query("ALTER TABLE $table ADD currentlendemail varchar(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'currentlendname'") == 0){
         $wpdb->query("ALTER TABLE $table ADD currentlendname varchar(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'lendable'") == 0){
         $wpdb->query("ALTER TABLE $table ADD lendable varchar(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'copies'") == 0){
         $wpdb->query("ALTER TABLE $table ADD copies bigint(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'copieschecked'") == 0){
         $wpdb->query("ALTER TABLE $table ADD copieschecked bigint(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'lendedon'") == 0){
         $wpdb->query("ALTER TABLE $table ADD lendedon bigint(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'subject'") == 0){
         $wpdb->query("ALTER TABLE $table ADD subject varchar(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'country'") == 0){
         $wpdb->query("ALTER TABLE $table ADD country varchar(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'authorfirst'") == 0){
       $wpdb->query("ALTER TABLE $table ADD authorfirst varchar(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'authorlast'") == 0){
         $wpdb->query("ALTER TABLE $table ADD authorlast varchar(255)");
      }

      // Now begin modifying the custom library's settings tables
      $table = $wpdb->prefix."wpbooklist_jre_settings_".$utable->user_table_name;
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'activeposttemplate'") == 0){
         $wpdb->query("ALTER TABLE $table ADD activeposttemplate varchar( 255 ) NOT NULL DEFAULT 'default'");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'activepagetemplate'") == 0){
         $wpdb->query("ALTER TABLE $table ADD activepagetemplate varchar( 255 ) NOT NULL DEFAULT 'default'");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'hidekindleprev'") == 0){
         $wpdb->query("ALTER TABLE $table ADD hidekindleprev bigint(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'hidegoogleprev'") == 0){
         $wpdb->query("ALTER TABLE $table ADD hidegoogleprev bigint(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'hidekobopurchase'") == 0){
         $wpdb->query("ALTER TABLE $table ADD hidekobopurchase bigint(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'hidebampurchase'") == 0){
         $wpdb->query("ALTER TABLE $table ADD hidebampurchase bigint(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'hidesubject'") == 0){
         $wpdb->query("ALTER TABLE $table ADD hidesubject bigint(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'hidecountry'") == 0){
         $wpdb->query("ALTER TABLE $table ADD hidecountry bigint(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'hidefilter'") == 0){
         $wpdb->query("ALTER TABLE $table ADD hidefilter bigint(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'hidefinishedsort'") == 0){
         $wpdb->query("ALTER TABLE $table ADD hidefinishedsort bigint(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'hidesignedsort'") == 0){
         $wpdb->query("ALTER TABLE $table ADD hidesignedsort bigint(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'hidefirstsort'") == 0){
         $wpdb->query("ALTER TABLE $table ADD hidefirstsort bigint(255)");
      }
      if($wpdb->query("SHOW COLUMNS FROM `$table` LIKE 'hidesubjectsort'") == 0){
         $wpdb->query("ALTER TABLE $table ADD hidesubjectsort bigint(255)");
      }


    }

    // Add the StoryTime table, introduced in 5.7.0
    $storytime_table_name = $wpdb->prefix.'wpbooklist_jre_storytime_stories';
    if($wpdb->get_var("SHOW TABLES LIKE '$storytime_table_name'") != $storytime_table_name) {

      // include everything needed to add a table, and register the table name
      global $charset_collate;
      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      $wpdb->wpbooklist_jre_storytime_stories = "{$wpdb->prefix}wpbooklist_jre_storytime_stories";

      // Add the StoryTime table
        $sql_create_table10 = "CREATE TABLE {$wpdb->wpbooklist_jre_storytime_stories} 
      (
            ID bigint(190) auto_increment,
            providername varchar(190),
            providerimg varchar(255),
            providerbio MEDIUMTEXT,
            content LONGTEXT,
            title varchar(255),
            category varchar(255),
            pageid bigint(255),
            postid bigint(255),
            storydate bigint(255),
            PRIMARY KEY  (ID),
              KEY providername (providername)
      ) $charset_collate; ";
      dbDelta( $sql_create_table10 );

      require_once(CLASS_DIR.'class-storytime.php');
      $storytime_class = new WPBookList_Storytime('install');

    }


    // Add the StoryTime Settings table, introduced in 5.7.0
    $storytime_settings_table_name = $wpdb->prefix.'wpbooklist_jre_storytime_stories_settings';
    if($wpdb->get_var("SHOW TABLES LIKE '$storytime_settings_table_name'") != $storytime_settings_table_name) {

      // include everything needed to add a table, and register the table name
      global $charset_collate;
      require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
      $wpdb->wpbooklist_jre_storytime_stories_settings = "{$wpdb->prefix}wpbooklist_jre_storytime_stories_settings";

      // Add the StoryTime table
      $sql_create_table11 = "CREATE TABLE {$wpdb->wpbooklist_jre_storytime_stories_settings} 
      (
            ID bigint(190) auto_increment,
            getstories bigint(255),
            createpost bigint(255),
            createpage bigint(255),
            storypersist bigint(255),
            deletedefault bigint(255),
            notifydismiss bigint(255) NOT NULL DEFAULT 1,
            newnotify bigint(255) NOT NULL DEFAULT 1,
            notifymessage MEDIUMTEXT,
            storytimestylepak varchar(255) NOT NULL DEFAULT 'default',
            PRIMARY KEY  (ID),
              KEY getstories (getstories)
      ) $charset_collate; ";
      dbDelta( $sql_create_table11 );

      // Insert the row
      $table_name = $wpdb->prefix . 'wpbooklist_jre_storytime_stories_settings';
      $wpdb->insert( $table_name, array('ID' => 1)); 
    }

    $table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';

    // Update admin message
    $data = array(
      'adminmessage' => 'aladivaholeidanequaladqwpbooklistdashnoticedashholderadqaraaholeaholealaaaholehrefanequaladqhttpsacoaslashaslashwpbooklistdotcomaslashadqaraaholeaholeaholeaholealaimgaholewidthanequaladq100ampersandpercntascadqaholesrcanequaladqhttpsacoaslashaslashwpbooklistdotcomaslashwpdashcontentaslashuploadsaslash2018aslash01aslashScreenshotdash2018dash01dash25dash18dot35dot59dash5dotpngadqaslasharaaholeaholealaaslashaaraaholeaholealadivaholeclassanequaladqwpbooklistdashmydashnoticedashdismissdashforeveradqaholeidanequaladqwpbooklistdashmydashnoticedashdismissdashforeverdashgeneraladqaraDismissaholeForeveralaaslashdivaraaholeaholealabuttonaholetypeanequaladqbuttonadqaholeclassanequaladqnoticedashdismissadqaraaholeaholeaholeaholealaspanaholeclassanequaladqscreendashreaderdashtextadqaraDismissaholethisaholenoticealaaslashspanaraaholeaholealaaslashbuttonaraalaaslashdivaraalabuttonaholetypeanequaladqbuttonadqaholeclassanequaladqnoticedashdismissadqaraalaspanaholeclassanequaladqscreendashreaderdashtextadqaraDismissaholethisaholenoticedotalaaslashspanaraalaaslashbuttonara',
    );
    $format = array( '%s');   
    $where = array( 'ID' => 1 );
    $where_format = array( '%d' );
    $wpdb->update( $table_name, $data, $where, $format, $where_format );

    // Functions for taking Authors from existing Author column, splitting the name up, and adding to the new authorfirst and authorlast columns. Called here to be a part of the upgrade function, but too large to remain in this particualr function. Also needs to be ran before the version number is updated below.
    wpbooklist_add_author_first_last_default_table();
    wpbooklist_add_author_first_last_dynamic_table();

 
    // Update verison number
    $data = array(
      'version' => WPBOOKLIST_VERSION_NUM,
    );
    $format = array( '%s');   
    $where = array( 'ID' => 1 );
    $where_format = array( '%d' );
    $wpdb->update( $table_name, $data, $where, $format, $where_format );

  }
}

// Function for taking Authors from existing Author column, splitting the name up, and adding to the new authorfirst and authorlast columns in the default table.
function wpbooklist_add_author_first_last_default_table(){
  global $wpdb;
  // Get current version #
  $table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
  $row = $wpdb->get_row("SELECT * FROM $table_name");
  $version = $row->version;

  // If version number does not match the current version number found in wpbooklist.php
  if($version != WPBOOKLIST_VERSION_NUM){

    // Modifying the default WPBookList table First, then any possible user-created dynamic tables
    $table_name_default = $wpdb->prefix . 'wpbooklist_jre_saved_book_log';
    // If the two new Author columns do exist...
    if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'authorfirst'") != 0 && $wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'authorlast'") != 0){
       
      $book_array = $wpdb->get_results("SELECT * FROM $table_name_default");
      $nonamearray = array();
      foreach ($book_array as $key => $value) {
        // Building array of titles to look for in author's names
        $title_array = array(
          'Jr.',
          'Ph.D.',
          'Mr.',
          'Mrs.'
        );



        $origauthorname = $value->author;
        $title = '';
        $finallastnames = '';
        $finalfirstnames = '';

        // First let's handle names with commas, which we'll assume indicates multiple authors
        if(strpos($origauthorname, ',') !== false && $finallastnames == '' && $finalfirstnames == ''){
            $origauthorcommaarray = explode(',', $origauthorname);

            $lastnamecolonstring =  '';
            $firstnamecolonstring =  '';
              
            foreach ($origauthorcommaarray as $key2 => $individual) {

              // First let's remove troublesome things like Ph.D., Jr., etc, and save them to be added back to end of the name
              foreach ($title_array as $titlekey => $titlevalue) {
                if(stripos($individual, $titlevalue) !== false){
                  $individual = str_replace($titlevalue, '', $individual);
                  $individual = rtrim($individual, ' ');
                  $title = $titlevalue;
                }
              }
              // explode by last space in name
              $firstname = implode(' ', explode(' ', $individual, -1));
              $temp = explode(' ', strrev($individual), 2);
              $lastname = strrev($temp[0]);

              $lastnamecolonstring = $lastnamecolonstring.';'.$lastname;
           
              if($title != ''){
                $firstnamecolonstring = $firstnamecolonstring.';'.$firstname.' '.$title;
              } else {
                $firstnamecolonstring = $firstnamecolonstring.';'.$firstname;
              }

            }

            // trim left spaces and ;
            $lastnamecolonstring = ltrim($lastnamecolonstring, ' ');
            $lastnamecolonstring = ltrim($lastnamecolonstring, ';');

            // trim left spaces and ;
            $firstnamecolonstring = ltrim($firstnamecolonstring, ' ');
            $firstnamecolonstring = ltrim($firstnamecolonstring, ';');

            // Now build finalfirstname and finallastname string for the two new db columns
            $finallastnames = $lastnamecolonstring;
            $finalfirstnames = $firstnamecolonstring;
        }

        // Next we'll handle the names of single authors who may have a title in their name
        foreach ($title_array as $titlekey => $titlevalue) {

          // If author name has a title in it, and does not have a comma (indicating multiple authors), then proceed
          if($finallastnames == '' && $finalfirstnames == '' && stripos($origauthorname, $titlevalue) !== false &&  stripos($origauthorname, ',') === false ){
            $tempname = str_replace($titlevalue, '', $origauthorname);
            $tempname = rtrim($tempname, ' ');
            $title = $titlevalue;
          
            // Now split up first/last names
            $finalfirstnames = implode(' ', explode(' ', $tempname, -1)).' '.$titlevalue;

            $temp = explode(' ', strrev($tempname), 2);
            $finallastnames = strrev($temp[0]);

          }
        }

        // Now if the Author's name does not contain a comma or a title...
        foreach ($title_array as $titlekey => $titlevalue) {
          // If author name does not have a title in it, and does not have a comma (indicating multiple authors), then proceed
          if($finallastnames == '' && $finalfirstnames == '' && stripos($origauthorname, $titlevalue) === false &&  stripos($origauthorname, ',') === false ){
            // Now split up first/last names
            $finalfirstnames = implode(' ', explode(' ', $origauthorname, -1));
            $temp = explode(' ', strrev($origauthorname), 2);
            $finallastnames = strrev($temp[0]);
          }
        }

        // Now update every row in the default table with our new author first name and author last name values
        $data = array(
          'authorfirst' => $finalfirstnames,
          'authorlast' => $finallastnames
        );
        $format = array( '%s', '%s'); 
        $where = array( 'ID' => $value->ID );
        $where_format = array( '%d' );
        $admin_notice_result = $wpdb->update( $table_name_default, $data, $where, $format, $where_format );

      }
    }
  }
}


// Function for taking Authors from existing Author column, splitting the name up, and adding to the new authorfirst and authorlast columns in all dynamic, user-created tables.
function wpbooklist_add_author_first_last_dynamic_table(){
    global $wpdb;
    // Modify any existing custom libraries - both the book data and the settings data
    $table_dyna = $wpdb->prefix."wpbooklist_jre_list_dynamic_db_names";
    $user_created_tables = $wpdb->get_results("SELECT * FROM $table_dyna");
    foreach($user_created_tables as $utable){

      $table = $wpdb->prefix."wpbooklist_jre_".$utable->user_table_name;

      // Get current version #
      $table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
      $row = $wpdb->get_row("SELECT * FROM $table_name");
      $version = $row->version;

      // If version number does not match the current version number found in wpbooklist.php
      if($version != WPBOOKLIST_VERSION_NUM){

        // Modifying the default WPBookList table First, then any possible user-created dynamic tables
        $table_name_default = $wpdb->prefix."wpbooklist_jre_".$utable->user_table_name;
        // If the two new Author columns do exist...
        if($wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'authorfirst'") != 0 && $wpdb->query("SHOW COLUMNS FROM `$table_name_default` LIKE 'authorlast'") != 0){
           
          $book_array = $wpdb->get_results("SELECT * FROM $table_name_default");
          $nonamearray = array();
          foreach ($book_array as $key => $value) {
            // Building array of titles to look for in author's names
            $title_array = array(
              'Jr.',
              'Ph.D.',
              'Mr.',
              'Mrs.'
            );



            $origauthorname = $value->author;
            $title = '';
            $finallastnames = '';
            $finalfirstnames = '';

            // First let's handle names with commas, which we'll assume indicates multiple authors
            if(strpos($origauthorname, ',') !== false && $finallastnames == '' && $finalfirstnames == ''){
                $origauthorcommaarray = explode(',', $origauthorname);

                $lastnamecolonstring =  '';
                $firstnamecolonstring =  '';
                  
                foreach ($origauthorcommaarray as $key2 => $individual) {

                  // First let's remove troublesome things like Ph.D., Jr., etc, and save them to be added back to end of the name
                  foreach ($title_array as $titlekey => $titlevalue) {
                    if(stripos($individual, $titlevalue) !== false){
                      $individual = str_replace($titlevalue, '', $individual);
                      $individual = rtrim($individual, ' ');
                      $title = $titlevalue;
                    }
                  }
                  // explode by last space in name
                  $firstname = implode(' ', explode(' ', $individual, -1));
                  $temp = explode(' ', strrev($individual), 2);
                  $lastname = strrev($temp[0]);

                  $lastnamecolonstring = $lastnamecolonstring.';'.$lastname;
               
                  if($title != ''){
                    $firstnamecolonstring = $firstnamecolonstring.';'.$firstname.' '.$title;
                  } else {
                    $firstnamecolonstring = $firstnamecolonstring.';'.$firstname;
                  }

                }

                // trim left spaces and ;
                $lastnamecolonstring = ltrim($lastnamecolonstring, ' ');
                $lastnamecolonstring = ltrim($lastnamecolonstring, ';');

                // trim left spaces and ;
                $firstnamecolonstring = ltrim($firstnamecolonstring, ' ');
                $firstnamecolonstring = ltrim($firstnamecolonstring, ';');

                // Now build finalfirstname and finallastname string for the two new db columns
                $finallastnames = $lastnamecolonstring;
                $finalfirstnames = $firstnamecolonstring;
            }

            // Next we'll handle the names of single authors who may have a title in their name
            foreach ($title_array as $titlekey => $titlevalue) {

              // If author name has a title in it, and does not have a comma (indicating multiple authors), then proceed
              if($finallastnames == '' && $finalfirstnames == '' && stripos($origauthorname, $titlevalue) !== false &&  stripos($origauthorname, ',') === false ){
                $tempname = str_replace($titlevalue, '', $origauthorname);
                $tempname = rtrim($tempname, ' ');
                $title = $titlevalue;
              
                // Now split up first/last names
                $finalfirstnames = implode(' ', explode(' ', $tempname, -1)).' '.$titlevalue;
                $temp = explode(' ', strrev($tempname), 2);
                $finallastnames = strrev($temp[0]);

              }
            }

            // Now if the Author's name does not contain a comma or a title...
            foreach ($title_array as $titlekey => $titlevalue) {
              // If author name does not have a title in it, and does not have a comma (indicating multiple authors), then proceed
              if($finallastnames == '' && $finalfirstnames == '' && stripos($origauthorname, $titlevalue) === false &&  stripos($origauthorname, ',') === false ){
                // Now split up first/last names
                $finalfirstnames = implode(' ', explode(' ', $origauthorname, -1));
                $temp = explode(' ', strrev($origauthorname), 2);
                $finallastnames = strrev($temp[0]);
              }
            }

            // Now update every row in the default table with our new author first name and author last name values
            $data = array(
              'authorfirst' => $finalfirstnames,
              'authorlast' => $finallastnames
            );
            $format = array( '%s', '%s'); 
            $where = array( 'ID' => $value->ID );
            $where_format = array( '%d' );
            $admin_notice_result = $wpdb->update( $table_name_default, $data, $where, $format, $where_format );

          }
        }
      }

    }
}








// Handles the popup that appears when the user deactivates WPBookList
function wpbooklist_exit_survey(){
  ?>
  <script type="text/javascript" >
  "use strict";
  jQuery(document).ready(function($) {

    var modalHtml = '<!-- The Modal --><div id="myModal" class="modal"><!-- Modal content --><div class="modal-content"><span class="close">&times;</span><img id="jre-domain-all-zips-loc" width="40" src="<?php echo ROOT_IMG_URL ?>icon-256x256.png" /><p id="wpbooklist-modal-title">Whoa, Wait a sec!</p><p id="wpbooklist-modal-desc"><span style="font-weight:bold;font-style:italic;">Tell me why you\'re getting rid of WPBookList</span>, and I\'ll do my best to fix the issue! </p><div id="wpbooklist-modal-reason-div"><div><input type="checkbox" id="wpbooklist-modal-reason1" /><label>I Can\'t Add Any Books!</label></div><div><input type="checkbox" id="wpbooklist-modal-reason2" /><label>It\'s Ugly!</label>  (<a href="https://wpbooklist.com/index.php/stylepaks-2/">StylePaks</a> - <a href="https://wpbooklist.com/index.php/templates-2/">Template Paks</a> - <a href="https://wpbooklist.com/index.php/downloads/stylizer-extension/">Stylizer Extension</a>)</div><div><input type="checkbox" id="wpbooklist-modal-reason3" /><label>It Doesn\'t Have a Feature I Need!</label><div id="wpbooklist-suggested-feature-div"><label></label><textarea id="wpbooklist-modal-textarea-suggest-feature" placeholder="What kind of feature are you looking for?"></textarea><label>Also, be sure to check out <a href="https://wpbooklist.com/index.php/extensions/">all the available Extensions</a> - chances are the feature you\'re looking for already exists!</label></div></div><div><input type="checkbox" id="wpbooklist-modal-reason4" /><label>It Broke My Website!</label></div><div><input type="checkbox" id="wpbooklist-modal-reason5" /><label>It Doesn\'t Work Right With My Theme!</label></div><div><input type="checkbox" id="wpbooklist-modal-reason6" /><label>The <a href="https://wpbooklist.com/index.php/extensions/" target="_blank">Extensions</a> Are Too Expensive!</label></div><div><input type="checkbox" id="wpbooklist-modal-reason7" /><label>I Prefer a Different Book Plugin!</label></div><div><input type="checkbox" id="wpbooklist-modal-reason8" /><label>This Pop-Up Is Annoying!</label></div><div><input type="checkbox" id="wpbooklist-modal-reason9" /><label>Just Not What I Thought It Was...</label></div><textarea id="wpbooklist-modal-textarea" placeholder="Provide Another Reason & Some Details Here"></textarea></div><div id="wpbooklist-modal-email-div"><label><span style="font-weight:bold;margin-bottom: -9px;display: block;">E-Mail Address (Optional)</span></br>(If provided, I\'ll personally respond to your concern)</label><input id="wpbooklist-modal-email" style="margin-top: 7px;width:200px;" type="text" placeholder="E-Mail Address" /></div><div id="wpbooklist-modal-submit">Submit - And Thanks For Trying WPBookList!</div><div id="wpbooklist-modal-close">Nah - Just Deactivate WPBookList!</div></div></div>';

    $('body').append(modalHtml);
    $('#myModal').css({'display':'none'})

    $(document).on("click",".deactivate", function(event){
      if( $(this).find('a').attr('href').indexOf('wpbooklist.php') != -1){

        // Get and open the modal
        var modal = document.getElementById('myModal');
        modal.style.display = "block";

        // Get the button that opens the modal
        var btn = document.getElementById("myBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            //modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                //modal.style.display = "none";
            }
        }

        event.preventDefault ? event.preventDefault() : event.returnValue = false;

      }
    })

    $(document).on("click","#wpbooklist-modal-reason3", function(event){

      if($(this).prop('checked')){
        $('#wpbooklist-suggested-feature-div').animate({'height':'110px', 'top':'5px'})
      } else {
        $('#wpbooklist-suggested-feature-div').animate({'height':'0px', 'top':'0px'})
      }
    });
    

  });
  </script>
  <?php
}

// For validating that a user has become a Patreon Patron for StoryTimee
function wpbooklist_patreon_validate_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("click",".wpbooklist-storytime-signup-div-right", function(event){

        window.location = "https://www.patreon.com/oauth2/authorize?response_type=code&client_id=fuL1ZQLyad6UPwhiIS1s3dlZcprkkF_mxcbdxWshJ-w_5znpRaap_NulMDa__2jH&redirect_uri=https://wpbooklist.com/index.php/storytime-patreon-redirect/&state="+encodeURIComponent(window.location.href);

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

// For simply linking to Patreon
function wpbooklist_patreon_link_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("click",".wpbooklist-storytime-signup-div-left", function(event){

        window.location = "https://www.patreon.com/wpbooklist";

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });

      $(document).on("click","#wpbooklist-storytime-for-demo-link", function(event){

        var scrollTop = $("#wpbooklist-storytime-demo-top-cont").offset().top-50

        // Scrolls back to the top of the title 
        if(scrollTop != 0){
          $('html, body').animate({
            scrollTop: scrollTop
          }, 1500);
          scrollTop = 0;
        }

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });



  });
  </script>
  <?php
}

// For scrolling the StoryTime content div on arrow clicks & for playing sound effects
function wpbooklist_storytime_scroll_action_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {


      var contentDiv = $("#wpbooklist-storytime-reader-content-div");
      var contentLocation = contentDiv.attr('data-location');
      var path = "<?php echo SOUNDS_URL ?>navleftright.mp3"
      var snd = new Audio(path);

      if(contentLocation == 'backend'){
        contentDiv.scroll(function() {
            $('#wpbooklist-storytime-reader-pagination-div-2-span-1').text(Math.trunc(contentDiv.scrollTop()/337)+1)
        });
      } else {
        contentDiv.scroll(function() {
            $('#wpbooklist-storytime-reader-pagination-div-2-span-1').text(Math.trunc(contentDiv.scrollTop()/370)+1)
        });
      }

      $(document).on("click","#wpbooklist-storytime-reader-pagination-div-3", function(event){

        var contentDiv = $("#wpbooklist-storytime-reader-content-div");
        var path = "<?php echo SOUNDS_URL ?>navleftright.mp3"
        var snd = new Audio(path);
        snd.play();

        $(this).css({'pointer-events':'none'})

        var currentPage = $('#wpbooklist-storytime-reader-pagination-div-2-span-1');
        var currentPageNum = parseInt($('#wpbooklist-storytime-reader-pagination-div-2-span-1').text());
        var totalPages = parseInt($('#wpbooklist-storytime-reader-pagination-div-2-span-3').text());

        if(contentLocation == 'backend'){
          var scrollGoal =  (currentPageNum)*337
        } else {
          var scrollGoal =  (currentPageNum)*370
        }

        contentDiv.animate({
             scrollTop: scrollGoal+'px'
          }, {
             duration: 1000,
             complete: function() { 
                $('#wpbooklist-storytime-reader-pagination-div-3').css({'pointer-events':'all'})
                
             }
         });

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });

      $(document).on("click","#wpbooklist-storytime-reader-pagination-div-1", function(event){

        var contentDiv = $("#wpbooklist-storytime-reader-content-div");
        var path = "<?php echo SOUNDS_URL ?>navleftright.mp3"
        var snd = new Audio(path);
        snd.play();

        $(this).css({'pointer-events':'none'})

        var currentPage = $('#wpbooklist-storytime-reader-pagination-div-2-span-1');
        var currentPageNum = parseInt($('#wpbooklist-storytime-reader-pagination-div-2-span-1').text());
        var totalPages = parseInt($('#wpbooklist-storytime-reader-pagination-div-2-span-3').text());


        if(contentLocation == 'backend'){
          if(contentDiv.scrollTop()%337 == 0){
            var scrollGoal =  (currentPageNum-2)*337
          } else {
            var scrollGoal =  (currentPageNum-1)*337
          }
        } else {
          if(contentDiv.scrollTop()%370 == 0){
            var scrollGoal =  (currentPageNum-2)*370
          } else {
            var scrollGoal =  (currentPageNum-1)*370
          }
        }

        contentDiv.animate({
             scrollTop: scrollGoal+'px'
          }, {
             duration: 1000,
             complete: function() { 
                $('#wpbooklist-storytime-reader-pagination-div-1').css({'pointer-events':'all'})
                
             }
         });

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

function wpbooklist_jre_storytime_rest_api_notice( $data ){
    global $wpdb;
    $table_name = $wpdb->prefix . 'wpbooklist_jre_storytime_stories';
    $responsedata = array();
    $result = '';

    // Get parameters from POST call coming from PluginManage
    $data = $data->get_params();

    // Check and see if this content has already been added to this website
    $duplicate = false;
    $stories_db_data = $wpdb->get_results("SELECT * FROM $table_name");
    foreach ($stories_db_data as $key => $value) {
      if($data['providername'] == $value->providername && $data['title'] == $value->title){
        $duplicate = true;
      }
    }

    if($duplicate == false){
      
      // Get the StoryTime settings table and perform actions accordingly
      $table_name_settings = $wpdb->prefix . 'wpbooklist_jre_storytime_stories_settings';
      $settings_results = $wpdb->get_row("SELECT * FROM $table_name_settings");

      // If duplicate data wasn't detected, the user hasn't opted out of receiving Stories
      if($settings_results->getstories == null || $settings_results->getstories == 0){

        // Check and see if I choose to send Stories to ALL users, or just those that are validated Patreon Patrons
        if($data['sendtopatreononly'] == 'true'){

          // Get the wpbooklist user options to verify that user has validated their Patreon Status. If validated, finally add to DB
          $table_name_patreon_settings = $wpdb->prefix . 'wpbooklist_jre_user_options';
          $patreon_settings_results = $wpdb->get_row("SELECT * FROM $table_name_patreon_settings");

          if($patreon_settings_results->patreonaccess != null && $patreon_settings_results->patreonrefresh != null && $patreon_settings_results->patreonack != null){

            // Insert the Story
            $insert_data = array(
                'content' => $data['content'],
                'providername' => $data['providername'],
                'providerimg' => $data['providerimg'],
                'providerbio' => $data['providerbio'],
                'title' => $data['title'],
                'category' => $data['category'],
            );
            $mask_array = array('%s','%s','%s','%s','%s','%s');
            $result = $wpdb->insert( $table_name, $insert_data, $mask_array);

            // Create a page, if user has opted for that
            if($settings_results->createpage == 1){
              require_once(CLASS_DIR.'class-storytime.php');
              $storytime_class = new WPBookList_Storytime('createpage', null, null, $insert_data);
              $page_result = $storytime_class->create_page_result;

              if($page_result != 0){
                $result = $result.' - Page Succesfully Created -';
              } else {
                $result = $result.' - Page Creation Failed -';
              }
            }

            // Create a post, if user has opted for that
            if($settings_results->createpost == 1){
              require_once(CLASS_DIR.'class-storytime.php');
              $storytime_class = new WPBookList_Storytime('createpost', null, null, $insert_data);
              $post_result = $storytime_class->create_post_result;

              if($post_result != 0){
                $result = $result.' - Post Succesfully Created -';
              } else {
                $result = $result.' - Post Creation Failed -';
              }
            }

            // Add the new admin message for this latest Story, if user hasn't disabled it
            if($settings_results->newnotify == 1){

              // Create the new message
              $new_story_message = '
              <div id="wpbooklist-notice-holder">
                <div id="wpbooklist-storytime-notify-div">
                  <div id="wpbooklist-storytime-notify-div-inner-1">
                    <img src="'.$data['providerimg'].'" />
                  </div>
                  <div id="wpbooklist-storytime-notify-div-inner-2">
                    <h2>A New</h2>
                    <div id="wpbooklist-storytime-notify-span-div">
                      <span id="wpbooklist-storytime-notify-span-div1" class="wpbooklist-color-orange-italic">WPBookList</span> 
                      <span id="wpbooklist-storytime-notify-span-div2">StoryTime</span> 
                      <img id="wpbooklist-storytime-notify-span-div-img-1" src="'.ROOT_IMG_ICONS_URL.'storytime.svg" /> 
                    </div>
                    <h2>Story Has Arrived!</h2>
                    <p>Be sure to check out <span id="wpbooklist-storytime-notify-span1">"'.$data['title'].'"</span>, from <span id="wpbooklist-storytime-notify-span2">'.$data['providername'].'</span></p>
                    <a href="'.admin_url().'admin.php?page=WPBookList-Options-storytime">Check it out now</a>
                  </div>
                  <div class="wpbooklist-my-notice-dismiss-forever" id="wpbooklist-my-notice-dismiss-forever-storytime">Dismiss</div>
                  <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss</span>
                  </button>
                  </div>
                </div>
                <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss</span></button>';
             
              // Reset the dismiss flag for this new message
              $data = array(
                'notifymessage' => $new_story_message,
                'notifydismiss' => 1
              );
              $format = array( '%s', '%d'); 
              $where = array( 'ID' => 1 );
              $where_format = array( '%d' );
              $admin_notice_result = $wpdb->update( $table_name_settings, $data, $where, $format, $where_format );

              if($admin_notice_result == 1){
                $result = $result.' - Also added new Dashboard Notification Message - ';
              } else {
                $result = $result.' - Possible problem adding a Dashboard Notification Message - ';
              }
            }
          } else {
            $result = $result." - User isn't a validated Patreon Patron - ";
          }

        } else {
          // Insert the Story
          $insert_data = array(
              'content' => $data['content'],
              'providername' => $data['providername'],
              'providerimg' => $data['providerimg'],
              'providerbio' => $data['providerbio'],
              'title' => $data['title'],
              'category' => $data['category'],
          );
          $mask_array = array('%s','%s','%s','%s','%s','%s');
          $result = $wpdb->insert( $table_name, $insert_data, $mask_array);

          // Create a page, if user has opted for that
          if($settings_results->createpage == 1){
            require_once(CLASS_DIR.'class-storytime.php');
            $storytime_class = new WPBookList_Storytime('createpage', null, null, $insert_data);
            $page_result = $storytime_class->create_page_result;

            if($page_result != 0){
              $result = $result.' - Page Succesfully Created -';
            } else {
              $result = $result.' - Page Creation Failed -';
            }
          }

          // Create a post, if user has opted for that
          if($settings_results->createpost == 1){
            require_once(CLASS_DIR.'class-storytime.php');
            $storytime_class = new WPBookList_Storytime('createpost', null, null, $insert_data);
            $post_result = $storytime_class->create_post_result;

            if($post_result != 0){
              $result = $result.' - Post Succesfully Created -';
            } else {
              $result = $result.' - Post Creation Failed -';
            }
          }

          // Add the new admin message for this latest Story, if user hasn't disabled it
          if($settings_results->newnotify == 1){

            // Create the new message
            $new_story_message = '
            <div id="wpbooklist-notice-holder">
              <div id="wpbooklist-storytime-notify-div">
                <div id="wpbooklist-storytime-notify-div-inner-1">
                  <img src="'.$data['providerimg'].'" />
                </div>
                <div id="wpbooklist-storytime-notify-div-inner-2">
                  <h2>A New</h2>
                  <div id="wpbooklist-storytime-notify-span-div">
                    <span id="wpbooklist-storytime-notify-span-div1" class="wpbooklist-color-orange-italic">WPBookList</span> 
                    <span id="wpbooklist-storytime-notify-span-div2">StoryTime</span> 
                    <img id="wpbooklist-storytime-notify-span-div-img-1" src="'.ROOT_IMG_ICONS_URL.'storytime.svg" /> 
                  </div>
                  <h2>Story Has Arrived!</h2>
                  <p>Be sure to check out <span id="wpbooklist-storytime-notify-span1">"'.$data['title'].'"</span>, from <span id="wpbooklist-storytime-notify-span2">'.$data['providername'].'</span></p>
                  <a href="'.admin_url().'admin.php?page=WPBookList-Options-storytime">Check it out now</a>
                </div>
                <div class="wpbooklist-my-notice-dismiss-forever" id="wpbooklist-my-notice-dismiss-forever-storytime">Dismiss</div>
                <button type="button" class="notice-dismiss">
                  <span class="screen-reader-text">Dismiss</span>
                </button>
                </div>
              </div>
              <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss</span></button>';
           
            // Reset the dismiss flag for this new message
            $data = array(
              'notifymessage' => $new_story_message,
              'notifydismiss' => 1
            );
            $format = array( '%s', '%d'); 
            $where = array( 'ID' => 1 );
            $where_format = array( '%d' );
            $admin_notice_result = $wpdb->update( $table_name_settings, $data, $where, $format, $where_format );

            if($admin_notice_result == 1){
              $result = $result.' - Also added new Dashboard Notification Message - ';
            } else {
              $result = $result.' - Possible problem adding a Dashboard Notification Message - ';
            }
          }
        }
      } else {
        $result = 'Looks Like the user disabled StoryTime!';
      }
    } else {
      $result = 'No Dice - Duplicate content detected!';
    }
    
    return ($result);
}



function wpbooklist_jre_storytime_delete_rest_api_notice( $data ){
    global $wpdb;
    $stories_table = $wpdb->prefix . 'wpbooklist_jre_storytime_stories';
    $responsedata = array();

    $providername = $data['providername'];
    $providertitle = $data['title'];
    $providercategory = $data['category'];

    // Get the ID of the Story we're deleting
    $query_for_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $stories_table WHERE providername = %s AND title = %s AND category = %s", $providername, $providertitle, $providercategory));

    $result = '';
    if(is_object($query_for_data)){
      $id = $query_for_data->ID;
      $result = 'Found The title in the user\'s database. It\'s ID is '.$id.'. ';
    } else {
      $result = 'Couldn\'t find the Title in User\'s Database! Check your entries in the TextAreas above. ';
      return $result;
    }

    $result1 = $wpdb->query($wpdb->prepare("DELETE FROM $stories_table WHERE providername = %s AND title = %s AND category = %s", $providername, $providertitle, $providercategory));

    // Dropping primary key in database to alter the IDs and the AUTO_INCREMENT value
    $result2 = $wpdb->query("ALTER TABLE $stories_table MODIFY ID bigint(190)");
    $result3 = $wpdb->query("ALTER TABLE $stories_table DROP PRIMARY KEY");

    // Adjusting ID values of remaining entries in database
    $my_query = $wpdb->get_results("SELECT * FROM $stories_table");
    $title_count = $wpdb->num_rows;
    $result4 = '';
    for ($x = $id; $x <= $title_count; $x++) {
      $data = array(
          'ID' => $id
      );
      $format = array( '%d'); 
      $id++;  
      $where = array( 'ID' => ($id) );
      $where_format = array( '%d' );
      $result4 = $result4.$wpdb->update( $stories_table, $data, $where, $format, $where_format );
    } 

    // Adding primary key back to database 
    $result5 = $wpdb->query("ALTER TABLE $stories_table ADD PRIMARY KEY (`ID`)");    
    $result6 = $wpdb->query("ALTER TABLE $stories_table MODIFY ID bigint(190) AUTO_INCREMENT");

    // Setting the AUTO_INCREMENT value based on number of remaining entries
    $title_count++;
    $result7 = $wpdb->query($wpdb->prepare( "ALTER TABLE $stories_table AUTO_INCREMENT = %d", $title_count));

    return $result.' Actual Deletion: '.$result1.' ALTER TABLE: '.$result2.' Drop Primary Key: '.$result3.' ID Adjustments: '.$result4.' Add Primary Key:  '.$result5.' ALTER TABLE: '.$result6.' Adjust Auto_Increment Value: '.$result7;

}

function wpbooklist_jre_storytime_patreon_validate_rest_api_notice( $data ){
    global $wpdb;
    $table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
    //$data['firstkey'];

    $data = array(
          'patreonaccess' => urldecode($data['firstkey']),
          'patreonrefresh' => urldecode($data['secondkey']),
          'patreonack' => time()
    );
    $format = array( '%s', '%s', '%s'); 
    $where = array( 'ID' => 1 );
    $where_format = array( '%d' );
    $result = $wpdb->update( $table_name, $data, $where, $format, $where_format );
    $result = $result.' - Saved Patreon Access Credentials';
    
    return ($result);
}

// Handles the front-end search stuff, as well as the 'Reset Filters, Sort, and Search' button
function wpbooklist_library_frontend_search() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {

      // The click handler for the big ol' "Reset Filter, Sort & Search" button
      $(document).on("click",".wpbooklist-reset-search-and-filters", function(event){

        // Simply reload the page without any URL parameters
        var url = window.location.href;
        if (url.indexOf('?') > -1){
          var beforeParams = url.split('?')[0];
          url = beforeParams;
        }

        // Reload the page
        window.location.href = url;

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });

      // When the Search form is submitted/the Search button is clicked
      $(".wpbooklist-search-form").on("submit", function() {

        // Get info we need to build search query, specific to the particular library on the page in question, and not every Library that may exist on the same page 
        var formid = $(this).attr('id');
        var table = $(this).attr('data-table');
        var title = $('#'+formid+' #wpbooklist-book-title-search').prop('checked');
        var author = $('#'+formid+' #wpbooklist-author-search').prop('checked');
        var category = $('#'+formid+' #wpbooklist-cat-search').prop('checked');
        var searchterm = $('#'+formid+' #wpbooklist-search-text').val();
        var url = window.location.href;
        var params = '';


        // Set the params based on they type of search
        if(title){
          params = params+'searchbytitle=title&';
        }

        if(author){
          params = params+'searchbyauthor=author&';
        }

        if(category){
          params = params+'searchbycategory=category&';
        }

        // If all of, or none of, the checkboxes were checked
        if((!title && !author && !category) || (title && author && category)){
          params = 'searchbytitle=title&searchbyauthor=author&searchbycategory=category&';
        }

        // Append the actual search term
        params = params+'searchterm='+searchterm+'&querytable='+table;

        // Build the final complete URL
        if (url.indexOf('?') > -1){
          var beforeParams = url.split('?')[0];
          beforeParams = beforeParams+'?';
          url = beforeParams+params;
        }else{
          url += '?'+params
        }

        // Reload the page with the completed search parameters
        window.location.href = url;

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}

// Handles the front-end pagination select and left & right buttons
function wpbooklist_library_frontend_pagination() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {

      // The change handler for the 'Sort By...' Select input
      $(document).on("change",".wpbooklist-pagination-middle-div-select", function(event){

        var table = $(this).attr('data-table');
        var selection = $(this).val();
        var url = window.location.href;


        // Build the final complete URL //
          // If params already exist...
        if (url.indexOf('?') > -1){
          var beforeParams = url.split('?')[0];
          var existingParams = url.split('?')[1];

          // If there is already an offset in the URL, remove it
          if(existingParams.indexOf('offset') > -1){
            existingParams = existingParams.split('offset')[1];

            //if there are residual parts of the offset param left, remove them
            if(existingParams.startsWith("=")){
              existingParams = existingParams.split(/&(.+)/)[1];
            }
          }

          url = beforeParams+'?offset='+selection+'&'+existingParams;

        }else{
          url += '?offset='+selection+'&querytable='+table;
        }

        // Reload the page with the completed sort parameter, and any existing Search parameters 
        window.location.href = url;

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });

      // The click handler for the 'Sort By...' Select input
      $(document).on("click",".wpbooklist-pagination-left-div", function(event){

        var table = $(this).attr('data-table');
        var selection = $(this).attr('data-offset')
        var url = window.location.href;


        // Build the final complete URL //
          // If params already exist...
        if (url.indexOf('?') > -1){
          var beforeParams = url.split('?')[0];
          var existingParams = url.split('?')[1];

          // If there is already an offset in the URL, remove it
          if(existingParams.indexOf('offset') > -1){
            existingParams = existingParams.split('offset')[1];

            //if there are residual parts of the offset param left, remove them
            if(existingParams.startsWith("=")){
              existingParams = existingParams.split(/&(.+)/)[1];
            }
          }

          url = beforeParams+'?offset='+selection+'&'+existingParams;

        }else{
          url += '?offset='+selection+'&querytable='+table;
        }

        // Reload the page with the completed sort parameter, and any existing Search parameters 
        window.location.href = url;

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });

      // The click handler for the 'Sort By...' Select input
      $(document).on("click",".wpbooklist-pagination-right-div", function(event){

        var table = $(this).attr('data-table');
        var selection = $(this).attr('data-offset')
        var url = window.location.href;


        // Build the final complete URL //
          // If params already exist...
        if (url.indexOf('?') > -1){
          var beforeParams = url.split('?')[0];
          var existingParams = url.split('?')[1];

          // If there is already an offset in the URL, remove it
          if(existingParams.indexOf('offset') > -1){
            existingParams = existingParams.split('offset')[1];

            //if there are residual parts of the offset param left, remove them
            if(existingParams.startsWith("=")){
              existingParams = existingParams.split(/&(.+)/)[1];
            }
          }

          url = beforeParams+'?offset='+selection+'&'+existingParams;

        }else{
          url += '?offset='+selection+'&querytable='+table;
        }

        // Reload the page with the completed sort parameter, and any existing Search parameters 
        window.location.href = url;

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });

  });
  </script>
  <?php
}

// Handles the front-end 'Sort By...' Select input
function wpbooklist_library_frontend_sort_select() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {

      // The change handler for the 'Sort By...' Select input
      $(document).on("change",".wpbooklist-sort-select-box", function(event){

        var table = $(this).attr('data-table');
        var selection = $(this).val();
        var url = window.location.href;


        // Build the final complete URL //
          // If params already exist...
        if (url.indexOf('?') > -1){
          var beforeParams = url.split('?')[0];
          var existingParams = url.split('?')[1];


          // If there is already an offset in the URL, remove it
          if(existingParams.indexOf('offset') > -1){
            existingParams = existingParams.split('offset')[1];

            //if there are residual parts of the offset param left, remove them
            if(existingParams.startsWith("=")){
              existingParams = existingParams.split(/&(.+)/)[1];
            }
          }

          if(existingParams.indexOf('sortby') > -1){
            existingParams = existingParams.split(/&(.+)/)[1];
          }



          url = beforeParams+'?sortby='+selection+'&'+existingParams;

        }else{
          url += '?sortby='+selection+'&querytable='+table;
        }
        // Reload the page with the completed sort parameter, and any existing Search parameters 
        window.location.href = url;

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}


// Handles the front-end 'Filter By' Select inputs
function wpbooklist_library_frontend_filter_selects() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {

      // The change handler for the 'Sort By...' Select input
      $(document).on("change",".wpbooklist-frontend-filter-select", function(event){

        var table = $(this).attr('data-table');
        var which = $(this).attr('data-which');
        var selection = $(this).val();

        // Handling the pubyear filter scenario
        if(which == 'pubyears'){
          selection = $('#wpbooklist-year-range-1-'+table).val()+$('#wpbooklist-year-range-2-'+table).val()+'-'+$('#wpbooklist-year-range-3-'+table).val()+selection;
        }

        console.log(selection);

        // Replace any '&' characters found in selection to prevent confusion in the URL between params and the actual values - applies mainly to multiple authors when sorted by last name.
        selection = encodeURI(selection.replace(/&/g, '-'));/,/g
        var url = window.location.href;

        // If params already exist...
        if (url.indexOf('?') > -1){
          var beforeParams = url.split('?')[0];
          var existingParams = url.split('?')[1];

          // If there is already an offset in the URL, remove it
          if(existingParams.indexOf('offset') > -1){
            existingParams = existingParams.split('offset')[1];
            //if there are residual parts of the offset param left, remove them
            if(existingParams.startsWith("=")){
              // If ther is an '&' in existingParams still, split by it. If not, set existingParams to ''.
              if(existingParams.indexOf('&') > -1){
                existingParams = existingParams.split(/&(.+)/)[1];
              } else {
                existingParams = '';
              }
            }
          }

          // If this filter already exists in the URL, simply replace it with the selected one
          if(existingParams.indexOf('filter'+which) > -1){
            var beforeFilter = existingParams.split('filter'+which)[0];
            var afterFilter = existingParams.split('filter'+which)[1];
            if(afterFilter.indexOf('&') > -1){
              afterFilter = '&'+afterFilter.split('&')[1];
            } else{
              afterFilter = '';
            }
            url = beforeParams+'?'+beforeFilter+'filter'+which+'='+selection+afterFilter;
             console.log('url1')
            console.log(url)

          } else {
            if(existingParams == ''){
              url = beforeParams+'?filter'+which+'='+selection+'&querytable='+table;
              console.log('url2')
              console.log(url)
            }else{
              url = beforeParams+'?'+existingParams+'&filter'+which+'='+selection;
              console.log('url3')
              console.log(url)
            }
          }
        }else{
          // Append the new stuff plus the table, as there are no parameters in the URL at all yet
          url += '?filter'+which+'='+selection+'&querytable='+table;
          console.log('url4')
              console.log(url)
        }

        // Reload the page with the completed sort parameter, and any existing Search parameters 
        window.location.href = url;

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}



// Function taht displays StoryTime on the front end
function wpbooklist_storytime_shortcode($atts){
  global $wpdb;

  ob_start();
  require_once(CLASS_DIR.'class-storytime.php');
  $storytime_class = new WPBookList_Storytime('frontend_shortcode_output');
  echo $storytime_class->reader_shortcode_output;
  return ob_get_clean();
}

/*
 * Below is a boilerplate function with Javascript
 *
/*

// For 
add_action( 'admin_footer', 'wphealthtracker_boilerplate_javascript' );

function wphealthtracker_boilerplate_javascript() { 
  ?>
    <script type="text/javascript" >
    "use strict";
    jQuery(document).ready(function($) {
      $(document).on("click",".wphealthtracker-trigger-actions-checkbox", function(event){

        event.preventDefault ? event.preventDefault() : event.returnValue = false;
      });
  });
  </script>
  <?php
}
*/
?>