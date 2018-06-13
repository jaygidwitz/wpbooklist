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
    $table_name = $wpdb->prefix . 'wpbooklist_jre_storytime_stories_settings';
    $settings_results = $wpdb->get_row("SELECT * FROM $table_name");

    if($settings_results->createpost == 1){
      $input1 = '<input checked id="wpbooklist-storytime-settings-input-1" type="checkbox" />';
    } else {
      $input1 = '<input id="wpbooklist-storytime-settings-input-1" type="checkbox" />';
    }
    
    if($settings_results->createpage == 1){
      $input2 = '<input checked id="wpbooklist-storytime-settings-input-2" type="checkbox" />';
    } else {
      $input2 = '<input id="wpbooklist-storytime-settings-input-2" type="checkbox" />';
    }

    if($settings_results->deletedefault == 1){
      $input3 = '<input checked id="wpbooklist-storytime-settings-input-3" type="checkbox" />';
    } else {
      $input3 = '<input id="wpbooklist-storytime-settings-input-3" type="checkbox" />';
    }

    if($settings_results->newnotify == 1){
      $input4 = '<input checked id="wpbooklist-storytime-settings-input-4" type="checkbox" />';
    } else {
      $input4 = '<input id="wpbooklist-storytime-settings-input-4" type="checkbox" />';
    }

    if($settings_results->getstories == 1){
      $input5 = '<input checked id="wpbooklist-storytime-settings-input-5" type="checkbox" />';
    } else {
      $input5 = '<input id="wpbooklist-storytime-settings-input-5" type="checkbox" />';
    }

    if($settings_results->storypersist != null){
      $input6 = '<input value="'.$settings_results->storypersist.'" id="wpbooklist-storytime-settings-input-6" type="number" />';
    } else {
      $input6 = '<input id="wpbooklist-storytime-settings-input-6" type="number" />';
    }


    $string1 = '
    <div id="wpbooklist-addbook-container">
        <p>'.__('Here you can manage all of the','wpbooklist').' <span class="wpbooklist-color-orange-italic">'.__('WPBookList StoryTime','wpbooklist').'</span> '.__('Settings, to include how long Stories are kept, how you\'d like to be notifed when new Stories arrive, whether or not to create a Page and/or Post when new Stories arrive, and more!','wpbooklist').'</p>
        <p>'.__('Remember, use this shortcode to display the Storytime Reader:','wpbooklist').'&nbsp;<strong>[wpbooklist_storytime]</strong></p>
        <div id="wpbooklist-storytime-settings-cont">
          <p>Settings</p>
          <div id="wpbooklist-storytime-settings-inner">
            <div class="wpbooklist-storytime-row-div">
              <label>Create a Post every time a new Story arrives?</label>
              '.$input1.'
            </div>
            <div class="wpbooklist-storytime-row-div">
              <label>Create a Page every time a new Story arrives?</label>
              '.$input2.'
            </div>
            <div class="wpbooklist-storytime-row-div">
              <label>Delete all Default StoryTime Content?</label>
              '.$input3.'
            </div>
            <div class="wpbooklist-storytime-row-div">
              <label>Display Dashboard notification when new Stories arrive?</label>
              '.$input4.'
            </div>
            <div class="wpbooklist-storytime-row-div">
              <label>Disable StoryTime (you will no longer receive <em>ANY</em> Stories)?</label>
              '.$input5.'
            </div>
            <div style="display:none;" class="wpbooklist-storytime-row-div" id="wpbooklist-storytime-row-div-6">
              <label>Keep Stories for</label>
              '.$input6.'
              <label>Days (leave blank to keep all Stories forever)</label>
            </div>
          </div>
          <div class="wpbooklist-storytime-settings-save-div">
            <button id="wpbooklist-storytime-settings-save">Save Settings</button>
            <div class="wpbooklist-spinner" id="wpbooklist-spinner-storytime-settings"></div>
          </div>
        </div>
    </div>
        ';

        return $string1;
  }


}

endif;