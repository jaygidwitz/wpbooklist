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

    $stories_table_name = $wpdb->prefix . 'wpbooklist_jre_storytime_stories';
    $stories_db_data = $wpdb->get_results("SELECT * FROM $stories_table_name");

    // Build the Categories string
      $categories_string = '';
      $cat_array = array();
      foreach ($stories_db_data as $key => $value) {
        array_push($cat_array, $value->category);
      }
      $cat_array = array_unique($cat_array);
      foreach ($cat_array as $key => $value) {
        $categories_string = $categories_string.'<option value="'.$value.'">'.$value.'</option>';
      }

    // Build the Most Recent string
    $recent_string = '';
    $stories_db_data = array_reverse($stories_db_data);
    foreach ($stories_db_data as $key => $value) {
      $recent_string = $recent_string.'<p class="wpbooklist-storytime-listed-story" data-id="'.$value->ID.'">'.$value->title.'</p>';
    }

    // For displaying html informing the user they need to become a Patreon patron
    if(($opt_results->patreonack == null || $opt_results->patreonack == 0) && ($opt_results->patreonaccess == null || $opt_results->patreonaccess == 0) && ($opt_results->patreonrefresh == null || $opt_results->patreonrefresh == 0)   ){
      
      $patreon = '
      <div class="wpbooklist-storytime-patreon-div">
      <div>
          <p class="wpbooklist-storytime-p-1">'.__('Uh-Oh!','wpbooklist').'<img class="wpbooklist-storytime-shocked-img" src="'.ROOT_IMG_ICONS_URL.'shocked.svg"/></p>
          <p class="wpbooklist-storytime-p-2">'.__('Looks Like you\'re not a','wpbooklist').'<a href="https://www.patreon.com/wpbooklist"><img class="wpbooklist-storytime-patreon-img" src="'.ROOT_IMG_URL.'patreon-cropped.png" /></a>&nbsp;'.__('Patron yet!','wpbooklist').'</p><p class="wpbooklist-storytime-patreon-line"></p>
          <p><a class="wpbooklist-storytime-for-just-link" href="https://www.patreon.com/wpbooklist">'.__('for just','wpbooklist').'<span>&nbsp;'.__('$1 a month','wpbooklist').'</span></a>&nbsp;'.__('you\'ll receive quality content several times per week, including:','wpbooklist').'</p>
          <ul>
            <li><span class="wpbooklist-storytime-tilde">~</span>Sample Book Chapters<span class="wpbooklist-storytime-tilde">~</span></li>
            <li><span class="wpbooklist-storytime-tilde">~</span>Selected Excerpts<span class="wpbooklist-storytime-tilde">~</span></li>
            <li><span class="wpbooklist-storytime-tilde">~</span>Interviews with Authors<span class="wpbooklist-storytime-tilde">~</span></li>
            <li><span class="wpbooklist-storytime-tilde">~</span>Interviews with Publishers<span class="wpbooklist-storytime-tilde">~</span></li>
            <li><span class="wpbooklist-storytime-tilde">~</span>Exclusive Short Stories<span class="wpbooklist-storytime-tilde">~</span></li>
          </ul>
          <p>'.__('Once you become a Patron, content will auto-magically appear in the WPBookList StoryTime Reader','wpbooklist').' <a id="wpbooklist-storytime-for-demo-link" href="#wpbooklist-storytime-demo-top-cont">('.__('see','wpbooklist').'&nbsp;'.__('demo','wpbooklist').'&nbsp'.__('below','wpbooklist').')</a> - '.__('no action required whatsoever!','wpbooklist').'<br/><br/></p>
          <p>'.__('All content comes straight from new and established authors,','wpbooklist').'<br/>'.__(' publishers, and other industry insiders!','wpbooklist').'</p><p class="wpbooklist-storytime-patreon-line"></p><br/><br/>
          <div class="wpbooklist-storytime-signup-div">
            <div class="wpbooklist-storytime-signup-div-left">
              <p class="wpbooklist-storytime-signup-button-p">Step 1:</p>
              <p class="wpbooklist-storytime-signup-button-div">Become a Patron</p>
              <img src="'.ROOT_IMG_URL.'patreonsquare.jpg" />
            </div>
            <div class="wpbooklist-storytime-signup-div-middle">
              <img src="'.ROOT_IMG_URL.'redo.svg" />
            </div>
            <div class="wpbooklist-storytime-signup-div-right">
              <p class="wpbooklist-storytime-signup-button-p">Step 2:</p>
              <p class="wpbooklist-storytime-signup-button-div">Validate for Access!</p>
              <img src="'.ROOT_IMG_URL.'accept.svg" />
            </div>
          </div>
      </div>
      </div>'; 

      $demo_header = '
      <div class="wpbooklist-storytime-demo-top-cont" id="wpbooklist-storytime-demo-top-cont">
        <p>'.__('Check out a Demo of ','wpbooklist').'<span>'.__('WPBookList','wpbooklist').'<br/>'.__('StoryTime','wpbooklist').'<img src="'.ROOT_IMG_ICONS_URL.'storytime.svg" /></span>&nbsp;'.__('below!','wpbooklist').'</p>
      </div>';

      $storytime_reader = '
        <div class="wpbooklist-storytime-reader-top-cont">
          <div id="wpbooklist-storytime-reader-inner-cont">

            <div id="wpbooklist-storytime-reader-titlebar-div">
              <div class="wpbooklist-storytime-reader-titlebar-div-1">
                <img src="'.ROOT_IMG_ICONS_URL.'storytime.svg" />
                <p>StoryTime Reader</p>
              </div>
              <div id="wpbooklist-storytime-reader-titlebar-div-2">
                <h2>Select a Story...</h2>
              </div>
            </div>

            <div class="wpbooklist-storytime-reader-selection-div">
              <div id="wpbooklist-storytime-reader-selection-div-1-inner-1">
                <select id="wpbooklist-storytime-category-select">
                  <option selected default disabled>Select a Category...</option>
                  <option>Recent Additions</option>
                  '.$categories_string.'
                </select>
                '.$recent_string.'
              </div>
              <div id="wpbooklist-storytime-reader-selection-div-1-inner-2" data-location="backend">
                <p>Browse Stories...</p>
                <img src="'.ROOT_IMG_URL.'next-down.png" />
              </div>
            </div>
            <div id="wpbooklist-storytime-reader-content-div" data-location="backend">

            </div>
            <div id="wpbooklist-storytime-reader-pagination-div">
              <div id="wpbooklist-storytime-reader-pagination-div-1">
                <img src="'.ROOT_IMG_URL.'next-left.png" />
              </div>
              <div class="wpbooklist-storytime-reader-pagination-div-2">
                <div class="wpbooklist-storytime-reader-pagination-div-2-inner">
                  <p>
                    <span id="wpbooklist-storytime-reader-pagination-div-2-span-1">1</span><span id="wpbooklist-storytime-reader-pagination-div-2-span-2">/</span><span id="wpbooklist-storytime-reader-pagination-div-2-span-3">10</span>
                  </p>
                </div>
              </div>
              <div id="wpbooklist-storytime-reader-pagination-div-3">
                <img src="'.ROOT_IMG_URL.'next-right.png" />
              </div>
            </div>
            <div id="wpbooklist-storytime-reader-provider-div">
              <div id="wpbooklist-storytime-reader-provider-div-1">
                <img src="'.ROOT_IMG_URL.'icon-256x256.png" />
              </div>
              <div id="wpbooklist-storytime-reader-provider-div-2">
                <p id="wpbooklist-storytime-reader-provider-p-1"> Discover new Authors and Publishers!</p>
                <p id="wpbooklist-storytime-reader-provider-p-2">WPBookList StoryTime is WPBooklist\'s Content-Delivery System, providing you and your website visitors with Sample Chapters, Short Stories, News, Interviews and more!</p>
              </div>
              <div id="wpbooklist-storytime-reader-provider-div-delete">
              </div>
            </div>
          </div>
        </div>';

        $advertise = '<div class="wpbooklist-storytime-provider-advert-div">
          <p>'.__('Wanna have your work featured in','wpbooklist').' <span class="wpbooklist-color-orange-italic">'.__('WPBookList StoryTime?','wpbooklist').'       </span><br/><br/>'.__('All content in ','wpbooklist').'<span class="wpbooklist-color-orange-italic">'.__('WPBookList StoryTime','wpbooklist').'</span> '.__('is exposed to thousands of individuals per month - makes for some awesome, unique, and effective advertising!','wpbooklist').'</p>
          <p>'.__('Send an E-Mail to ','wpbooklist').' <a href="mailto:advertising@wpbooklist.com">'.__('Advertising@WPBookList.com','wpbooklist').'</a> '.__('for more info.','wpbooklist').'</p>
        </div>';
    } else {
      $patreon = '';
      $demo_header = '';
      $storytime_reader = '
        <div class="wpbooklist-storytime-reader-top-cont">
          <div id="wpbooklist-storytime-reader-inner-cont">

            <div id="wpbooklist-storytime-reader-titlebar-div">
              <div class="wpbooklist-storytime-reader-titlebar-div-1">
                <img src="'.ROOT_IMG_ICONS_URL.'storytime.svg" />
                <p>StoryTime Reader</p>
              </div>
              <div id="wpbooklist-storytime-reader-titlebar-div-2">
                <h2>Select a Story...</h2>
              </div>
            </div>

            <div class="wpbooklist-storytime-reader-selection-div">
              <div id="wpbooklist-storytime-reader-selection-div-1-inner-1">
                <select id="wpbooklist-storytime-category-select">
                  <option selected default disabled>Select a Category...</option>
                  <option>Recent Additions</option>
                  '.$categories_string.'
                </select>
                '.$recent_string.'
              </div>
              <div id="wpbooklist-storytime-reader-selection-div-1-inner-2" data-location="backend">
                <p>Browse Stories...</p>
                <img src="'.ROOT_IMG_URL.'next-down.png" />
              </div>
            </div>
            <div id="wpbooklist-storytime-reader-content-div" data-location="backend">

            </div>
            <div id="wpbooklist-storytime-reader-pagination-div">
              <div id="wpbooklist-storytime-reader-pagination-div-1">
                <img src="'.ROOT_IMG_URL.'next-left.png" />
              </div>
              <div class="wpbooklist-storytime-reader-pagination-div-2">
                <div class="wpbooklist-storytime-reader-pagination-div-2-inner">
                  <p>
                    <span id="wpbooklist-storytime-reader-pagination-div-2-span-1">1</span><span id="wpbooklist-storytime-reader-pagination-div-2-span-2">/</span><span id="wpbooklist-storytime-reader-pagination-div-2-span-3">10</span>
                  </p>
                </div>
              </div>
              <div id="wpbooklist-storytime-reader-pagination-div-3">
                <img src="'.ROOT_IMG_URL.'next-right.png" />
              </div>
            </div>
            <div id="wpbooklist-storytime-reader-provider-div">
              <div id="wpbooklist-storytime-reader-provider-div-1">
                <img src="'.ROOT_IMG_URL.'icon-256x256.png" />
              </div>
              <div id="wpbooklist-storytime-reader-provider-div-2">
                <p id="wpbooklist-storytime-reader-provider-p-1"> Discover new Authors and Publishers!</p>
                <p id="wpbooklist-storytime-reader-provider-p-2">WPBookList StoryTime is WPBooklist\'s Content-Delivery System, providing you and your website visitors with Sample Chapters, Short Stories, News, Interviews and more!</p>
              </div>
              <div id="wpbooklist-storytime-reader-provider-div-delete">
              </div>
            </div>
          </div>
        </div>';

        $advertise = '<div style="position:absolute; bottom:-145px;" class="wpbooklist-storytime-provider-advert-div">
          <p>'.__('Wanna have your work featured in','wpbooklist').' <span class="wpbooklist-color-orange-italic">'.__('WPBookList StoryTime?','wpbooklist').'       </span><br/><br/>'.__('All content in ','wpbooklist').'<span class="wpbooklist-color-orange-italic">'.__('WPBookList StoryTime','wpbooklist').'</span> '.__('is exposed to thousands of individuals per month - makes for some awesome, unique, and effective advertising!','wpbooklist').'</p>
          <p>'.__('Send an E-Mail to ','wpbooklist').' <a href="mailto:advertising@wpbooklist.com">'.__('Advertising@WPBookList.com','wpbooklist').'</a> '.__('for more info.','wpbooklist').'</p>
        </div>';
    }




    $string1 = '
    <div id="wpbooklist-addbook-container">
        <p>'.__('What is ','wpbooklist').'<span class="wpbooklist-storytime-word-actual">'.__('StoryTime','wpbooklist').'</span>&nbsp;'.__('you ask?','wpbooklist').'</br></br><span class="wpbooklist-storytime-word-actual">'.__('StoryTime','wpbooklist').'</span>&nbsp;'.__('is','wpbooklist').'&nbsp;<span class="wpbooklist-color-orange-italic">'.__('WPBookList\'s' ,'wpbooklist').'</span>&nbsp;'.__('content-delivery platform, providing you and your website visitors with awesome content from Authors and Publishers, including sample chapters, exclusive short stories, interviews, news, and more!','wpbooklist').'<br/><br/>'.__('New content will automatically appear in the StoryTime Reader below, organized by Category. ','wpbooklist').'
        </p>
        <p>'.__('Use this shortcode to display the Storytime Reader:','wpbooklist').'&nbsp;<strong>[wpbooklist_storytime]</strong></p>
        <br/>
        <br/>
          '.$patreon.'
          '.$advertise.'
        '.$demo_header.$storytime_reader.'
    </div>
        ';

        return $string1;
  }


}

endif;