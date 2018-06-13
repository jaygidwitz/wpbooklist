<?php
/**
 * WPBookList Add-Edit-Book-Form Tab Class
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WPBookList_Add_Book_Form', false ) ) :
/**
 * WPBookList_Admin_Menu Class.
 */
class WPBookList_Add_Book_Form {

  public static function output_add_book_form(){

    // Perform check for previously-saved Amazon Authorization
    global $wpdb;
    $table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
    $opt_results = $wpdb->get_row("SELECT * FROM $table_name");

    $table_name = $wpdb->prefix . 'wpbooklist_jre_list_dynamic_db_names';
    $db_row = $wpdb->get_results("SELECT * FROM $table_name");

    // For grabbing an image from media library
    wp_enqueue_media();
    $string1 = '<div style="text-align:center;" id="wpbooklist-addbook-container">
        <p style="max-width:600px; margin-left:auto; margin-right:auto;">'.__('In short, WPBookList collects one thing and one thing only: The URL of the website that WPBookList was activated on. That\'s It.','wpbooklist').'</p>
        <p style="text-align:center; max-width:600px; font-weight:bold; font-size:15px; margin-left:auto; margin-right:auto;">'.__("Why does WPBookList record the URL its activated on?",'wpbooklist').'</p>
        <p style="max-width:600px; margin-left:auto; margin-right:auto;"><span class="wpbooklist-color-orange-italic">'.__('WPBookList','wpbooklist').'</span>&nbsp;'.__('utilizes the WordPress REST API to perform certain functions, like displaying admin messages, communicating with','wpbooklist').'&nbsp;<a href="https://wpbooklist.com/index.php/downloads/mobile-app-extension/">'.__('The Mobile App','wpbooklist').'</a>'.__(', pushing new StoryTime Stories, etc., and in order to complete those actions, WPBookList needs your URL.','wpbooklist').'</p>
        <p style="text-align:center; max-width:600px; font-weight:bold; font-size:15px; margin-left:auto; margin-right:auto;">'.__("Can I request to have my URL removed & not recorded?",'wpbooklist').'</p>
        <p style="max-width:600px; margin-left:auto; margin-right:auto;">'.__('Absolutely! Simply shoot an E-Mail to ','wpbooklist').'<a href="mailto:General@WPBookList.com">'.__('General@WPBookList.com','wpbooklist').'</a>&nbsp;'.__("with the subject line of 'Remove My URL', and we'll delete your URL from our records. Simple as that.",'wpbooklist').'</p>
        <p style="text-align:center; max-width:600px; font-weight:bold; font-size:15px; margin-left:auto; margin-right:auto;">'.__("Refund Policy",'wpbooklist').'</p>
        <p style="max-width:600px; margin-left:auto; margin-right:auto;">'.__("Generally speaking, refunds aren't given for the purchase of ",'wpbooklist').'<a href="https://wpbooklist.com/index.php/extensions/">'.__('Extensions','wpbooklist').'</a>,&nbsp;<a href="https://wpbooklist.com/index.php/stylepaks-2/">'.__("StylePaks",'wpbooklist').'</a>,&nbsp;'.__("and",'wpbooklist').'&nbsp;<a href="https://wpbooklist.com/index.php/templates-2/">'.__("Template Paks",'wpbooklist').'</a>,&nbsp;'.__("but if you feel your purchase is").'&nbsp;<span style="font-weight:bold; font-style:italic;">'.__('signifigantly','wpbooklist').'</span>&nbsp;'.__("not what it was advertised to be, feel free to get in touch at",'wpbooklist').'&nbsp;<a href="mailto:General@WPBookList.com">'.__('General@WPBookList.com','wpbooklist').'</a>&nbsp;</p><br/><br/>
        <p style="text-align:center; max-width:600px; font-weight:bold; font-size:17px; margin-left:auto; margin-right:auto;">'.__("Thanks for Using",'wpbooklist').'&nbsp;<span class="wpbooklist-color-orange-italic">'.__('WPBookList!','wpbooklist').'</span></p>
        <img style="margin-left:auto; margin-right:auto; width:75px; margin-bottom:50px;" src="'.ROOT_IMG_ICONS_URL.'happy.svg" />
        </div>';


//Why does WPBookList record the URL it\'s activated on?
//.__('WPBookList','wpbooklist').'</span>&nbsp;'.__(', etc., and in order to complete those actions, WPBookList needs your URL.','wpbooklist').
        return $string1;
  }


}

endif;