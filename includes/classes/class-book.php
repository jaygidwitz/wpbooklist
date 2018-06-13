<?php
/**
 * WPBookList Book Class
 * Handles functions for:
 * - Saving a Book to database
 * - Editing existing books
 * - Deleting Existing books
 * @author   Jake Evans
 * @category Root Product
 * @package  Includes/Classes
 * @version  1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WPBookList_Book', false ) ) :
/**
 * WPBookList_Book Class.
 */
class WPBookList_Book {

	public $add_result;
	public $edit_result;
	public $delete_result;
	public $title;
	public $author;
	public $author_url;
	public $image;
	public $amazon_array = array();
	public $library;
	public $retrieved_book;
	public $options_results;
	public $review_iframe;
	public $isbn;
	public $subject;
	public $country;
	public $notes;
	public $rating;
	public $copies;
	public $pages;
	public $finished;
	public $date_finished;
	public $first_edition;
	public $signed;
	public $description;
	public $category;
	public $pub_year;
	public $publisher;
	public $woocommerce;
	public $woofile;
	public $wooid;
	public $book_page;
	public $post_yes;
	public $page_yes;
	public $page_id;
	public $post_id;
	public $lendable;
	public $itunes_page;
	public $google_preview;
	public $amazon_detail_page;
	public $similar_products;
	public $price;
	public $saleprice;
	public $regularprice;
	public $stock;
	public $length;
	public $width;
	public $height;
	public $weight;
	public $sku;
	public $virtual;
	public $download;
	public $book_uid;
	public $salebegin;
	public $saleend;
	public $purchasenote;
	public $productcategory;
	public $reviews;
	public $upsells;
	public $crosssells;
	public $amazonbuylink;
	public $bnbuylink;
	public $googlebuylink;
	public $itunesbuylink;
	public $booksamillionbuylink;
	public $kobobuylink;
	public $id;
	public $go_amazon;
	public $defaultprice;
	public $finalauthorlastnames;
	public $finalauthorfirstnames;

	//variable to report back on the various API successes and/or failures
	public $apireport = '';


	// Variables that hold the different API responses
	public $amazonapiresult = '';
	public $googleapiresult = '';
	public $itunesapiresult = '';
	public $openlibapiresult = '';

	// Variables to hold how many times each api fails, indicating possible rate limits for Amazon
	public $apiamazonfailcount = 0; 

	public $rerun_amazon_flag = true;

	// The array variable that will tell us which API found what data
	public $whichapifound = array();

	
	public function __construct($action = null, $book_array = null, $id = null) {

		// Setting up default keys/values for the $whichapifound array
		$this->whichapifound['title'] = '';
		$this->whichapifound['image'] = '';
		$this->whichapifound['author'] = '';
		$this->whichapifound['pages'] = '';
		$this->whichapifound['pub_year'] = '';
		$this->whichapifound['publisher'] = '';
		$this->whichapifound['description'] = '';
		$this->whichapifound['amazondetailpage'] = '';
		$this->whichapifound['review_iframe'] = '';
		$this->whichapifound['similar_products'] = '';
		$this->whichapifound['category'] = '';
		$this->whichapifound['google_preview'] = '';
		$this->whichapifound['itunes_page'] = '';
		
		if(($action == 'add' || $action == 'edit' || $action == 'search' || $action == 'bookfinder-colorbox') && $book_array != null){

			// Setting up $book_array values, wrapped in isset() to prevent php error_log notices 
			if(isset($book_array['amazon_auth_yes'])){
				$this->amazon_auth_yes = $book_array['amazon_auth_yes'];
			}

			if(isset($book_array['library'])){
				$this->library = $book_array['library'];
			}

			if(isset($book_array['use_amazon_yes'])){
				$this->use_amazon_yes = $book_array['use_amazon_yes'];
			}

			if(isset($book_array['isbn'])){
				$this->isbn = $book_array['isbn'];
			}

			if(isset($book_array['title'])){
				$this->title = $book_array['title'];
			}

			if(isset($book_array['author'])){
				$this->author = $book_array['author'];
			}

			if(isset($book_array['author_url'])){
				$this->author_url = $book_array['author_url'];
			}

			if(isset($book_array['category'])){
				$this->category = $book_array['category'];
			}

			if(isset($book_array['price'])){
				$this->price = $book_array['price'];
			}

			if(isset($book_array['pages'])){
				$this->pages = $book_array['pages'];
			}

			if(isset($book_array['pub_year'])){
				$this->pub_year = $book_array['pub_year'];
			}

			if(isset($book_array['publisher'])){
				$this->publisher = $book_array['publisher'];
			}

			if(isset($book_array['description'])){
				$this->description = $book_array['description'];
			}

			if(isset($book_array['country'])){
				$this->country = $book_array['country'];
			}

			if(isset($book_array['subject'])){
				$this->subject = $book_array['subject'];
			}

			if(isset($book_array['notes'])){
				$this->notes = $book_array['notes'];
			}

			if(isset($book_array['rating'])){
				$this->rating = $book_array['rating'];
			}

			if(isset($book_array['image'])){
				$this->image = $book_array['image'];
			}

			if(isset($book_array['finished'])){
				$this->finished = $book_array['finished'];
			}

			if(isset($book_array['date_finished'])){
				$this->date_finished = $book_array['date_finished'];
			}

			if(isset($book_array['signed'])){
				$this->signed = $book_array['signed'];
			}

			if(isset($book_array['first_edition'])){
				$this->first_edition = $book_array['first_edition'];
			}

			if(isset($book_array['page_yes'])){
				$this->page_yes = $book_array['page_yes'];
			}

			if(isset($book_array['copies'])){
				$this->copies = $book_array['copies'];
			}

			if(isset($book_array['post_yes'])){
				$this->post_yes = $book_array['post_yes'];
			}

			if(isset($book_array['page_id'])){
				$this->page_id = $book_array['page_id'];
			}

			if(isset($book_array['post_id'])){
				$this->post_id = $book_array['post_id'];
			}

			if(isset($book_array['lendable'])){
				$this->lendable = $book_array['lendable'];
			}

			if(isset($book_array['itunes_page'])){
				$this->itunes_page = $book_array['itunes_page'];
			}

			if(isset($book_array['google_preview'])){
				$this->google_preview = $book_array['google_preview'];
			}

			if(isset($book_array['amazon_detail_page'])){
				$this->amazon_detail_page = $book_array['amazon_detail_page'];
			}

			if(isset($book_array['review_iframe'])){
				$this->review_iframe = $book_array['review_iframe'];
			}

			if(isset($book_array['similar_products'])){
				$this->similar_products = $book_array['similar_products'];
			}

			if(isset($book_array['woocommerce'])){
				$this->woocommerce = $book_array['woocommerce'];
			}

			if(isset($book_array['saleprice'])){
				$this->saleprice = $book_array['saleprice'];
			}

			if(isset($book_array['regularprice'])){
				$this->regularprice = $book_array['regularprice'];
			}

			if(isset($book_array['stock'])){
				$this->stock = $book_array['stock'];
			}

			if(isset($book_array['length'])){
				$this->length = $book_array['length'];
			}

			if(isset($book_array['width'])){
				$this->width = $book_array['width'];
			}

			if(isset($book_array['height'])){
				$this->height = $book_array['height'];
			}

			if(isset($book_array['weight'])){
				$this->weight = $book_array['weight'];
			}

			if(isset($book_array['sku'])){
				$this->sku = $book_array['sku'];
			}

			if(isset($book_array['virtual'])){
				$this->virtual = $book_array['virtual'];
			}

			if(isset($book_array['download'])){
				$this->download = $book_array['download'];
			}

			if(isset($book_array['book_uid'])){
				$this->book_uid = $book_array['book_uid'];
			}

			if(isset($book_array['woofile'])){
				$this->woofile = $book_array['woofile'];
			}

			if(isset($book_array['salebegin'])){
				$this->salebegin = $book_array['salebegin'];
			}

			if(isset($book_array['saleend'])){
				$this->saleend = $book_array['saleend'];
			}

			if(isset($book_array['purchasenote'])){
				$this->purchasenote = $book_array['purchasenote'];
			}

			if(isset($book_array['productcategory'])){
				$this->productcategory = $book_array['productcategory'];
			}

			if(isset($book_array['reviews'])){
				$this->reviews = $book_array['reviews'];
			}

			if(isset($book_array['upsells'])){
				$this->upsells = $book_array['upsells'];
			}

			if(isset($book_array['crosssells'])){
				$this->crosssells = $book_array['crosssells'];
			}

			if(isset($book_array['amazonbuylink'])){
				$this->amazonbuylink = $book_array['amazonbuylink'];
			}

			if(isset($book_array['bnbuylink'])){
				$this->bnbuylink = $book_array['bnbuylink'];
			}

			if(isset($book_array['googlebuylink'])){
				$this->googlebuylink = $book_array['googlebuylink'];
			}

			if(isset($book_array['itunesbuylink'])){
				$this->itunesbuylink = $book_array['itunesbuylink'];
			}

			if(isset($book_array['booksamillionbuylink'])){
				$this->booksamillionbuylink = $book_array['booksamillionbuylink'];
			}

			if(isset($book_array['kobobuylink'])){
				$this->kobobuylink = $book_array['kobobuylink'];
			}

			$this->id = $id;
		}

		if($action == 'addbulk' && $book_array != null){

			if(isset($book_array['amazon_auth_yes'])){
				$this->amazon_auth_yes = $book_array['amazon_auth_yes'];
			}

			if(isset($book_array['library'])){
				$this->library = $book_array['library'];
			}

			if(isset($book_array['use_amazon_yes'])){
				$this->use_amazon_yes = $book_array['use_amazon_yes'];
			}

			if(isset($book_array['isbn'])){
				$this->isbn = $book_array['isbn'];
			}

			if(isset($book_array['post_yes'])){
				$this->post_yes = $book_array['post_yes'];
			}

			if(isset($book_array['page_yes'])){
				$this->page_yes = $book_array['page_yes'];
			}
		}

		if($action == 'add' || $action == 'addbulk'){
			$this->add_book();
		}

		if($action == 'edit'){
			$this->id = $id;
			$this->edit_book();
		}

		if($action == 'delete'){
			$this->id = $id;
			$this->delete_book();
		}

		if($action == 'search'){
			$this->book_page = $book_array['book_page'];
			$this->amazon_auth_yes = $book_array['amazon_auth_yes'];
			if($this->amazon_auth_yes == 'true' && $this->use_amazon_yes == 'true'){
				$this->go_amazon === true;
				$this->gather_amazon_data();
				$this->gather_google_data();
				$this->gather_open_library_data();
				$this->gather_itunes_data();
				$this->create_buy_links();
			} else {
				// If $this->go_amazon is false, query the other apis and add the provided data to database
				$this->go_amazon === false;
				$this->gather_google_data();
				$this->gather_open_library_data();
				$this->gather_itunes_data();
				$this->create_buy_links();
			}
		}

		if($action == 'bookfinder-colorbox'){
			$this->gather_google_data();
			$this->gather_open_library_data();
			$this->gather_itunes_data();
			$this->create_buy_links();

			
		}
	}

	private function create_buy_links(){

		// Building Kobo Link
		$opts = array('http' =>
		    array(
		        'follow_location' => 1,
		        'timeout' => 10
		    )
		);

		$result = '';
		$responsecode = '';
		if(function_exists('file_get_contents')){
    		$result = @file_get_contents('http://store.kobobooks.com/en-ca/Search?Query='.$this->isbn, false);
    	}

    	if($result == ''){
    		if (function_exists('curl_init')){ 
    			error_log('entered the kobo curl');
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
				curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
				$url = 'http://store.kobobooks.com/en-ca/Search?Query='.$this->isbn;
				curl_setopt($ch, CURLOPT_URL, $url);
				$result = curl_exec($ch);
				$responsecode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
	    	} else {
	        	$this->apireport = $this->apireport.'Looks like neither file_get_contents() nor cURL area available! ';
	    	}
    	}

    	if(strpos($result, 'did not return any results') !== false){
    		$this->kobo_link = null;
    	} else {
    		$this->kobo_link = 'http://store.kobobooks.com/en-ca/Search?Query='.$this->isbn;
    	}


    	// Creating Books-a-Million link
    	$opts = array('http' =>
		    array(
		        'follow_location' => 1,
		        'timeout' => 10
		    )
		);

		$result = '';
		$responsecode = '';
		if(function_exists('file_get_contents')){
    		$result = @file_get_contents('http://www.booksamillion.com/p/'.$this->isbn, false);
    	}

    	if($result == ''){
    		if (function_exists('curl_init')){ 
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
				curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds
				$url = 'http://www.booksamillion.com/p/'.$this->isbn;
				curl_setopt($ch, CURLOPT_URL, $url);
				$result = curl_exec($ch);
				$responsecode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
	    	} else {
	        	$this->apireport = $this->apireport.'Looks like neither file_get_contents() nor cURL area available! ';
	    	}
    	}

    	if(strpos($result, 'SORRY, WE COULD NOT FIND THE REQUESTED PRODUCT') !== false){
    		$this->bam_link = null;
    	} else {
    		$this->bam_link = 'http://www.booksamillion.com/p/'.$this->isbn;
    	}





	}

	private function add_book(){
		// First do Amazon Authorization check
		if($this->amazon_auth_yes == 'true' && $this->use_amazon_yes == 'true'){
			$this->go_amazon === true;
			$this->gather_amazon_data();
			$this->gather_google_data();
			$this->gather_open_library_data();
			$this->gather_itunes_data();
			$this->create_buy_links();
			$this->set_default_woocommerce_data();
			$this->create_wpbooklist_woocommerce_product();
			$this->create_author_first_last();
			$this->add_to_db();
		} else {
			// If $this->go_amazon is false, query the other apis and add the provided data to database
			$this->go_amazon === false;
			$this->gather_google_data();
			$this->gather_open_library_data();
			$this->gather_itunes_data();
			$this->create_buy_links();
			$this->set_default_woocommerce_data();
			$this->create_wpbooklist_woocommerce_product();
			$this->create_author_first_last();
			$this->add_to_db();
		}
	}

	private function gather_amazon_data(){
		global $wpdb;

		// Get associate tag for creating API call post data
		$table_name_options = $wpdb->prefix . 'wpbooklist_jre_user_options';
  		$this->options_results = $wpdb->get_row("SELECT * FROM $table_name_options");

		$params = array();

		# Build Query
		// Determine Amazon region
		$region = '';
		switch ($this->options_results->amazoncountryinfo) {
	        case "au":
	        	$region = 'com.au';
	            break;
	        case "ca":
	        	$region = 'ca';
	            break;
	        case "fr":
	        	$region = 'fr';
	            break;
	        case "de":
	        	$region = 'de';
	            break;
	        case "in":
	        	$region = 'in';
	            break;
	        case "it":
	        	$region = 'it';
	            break;
	        case "jp":
	        	$region = 'co.jp';
	            break;
	        case "mx":
	        	$region = 'com.mx';
	            break;
	        case "es":
	        	$region = 'es';
	            break;
	        case "uk":
	        	$region = 'co.uk';
	            break;
	        case "cn":
	        	$region = 'cn';
	            break;
	        case "sg":
	        	$region = 'com.sg';
	        	break;
	        case "nl":
	        	$region = 'nl';
	            break;
	        case "br":
	        	$region = 'com.br';
	            break;
	        default:
	        	$region = 'com';
	    }

		// If user has saved their own Amazon API Keys
		if($this->options_results->amazonapisecret != null && $this->options_results->amazonapisecret != '' && $this->options_results->amazonapipublic != null && $this->options_results->amazonapipublic != ''){
			$postdata = http_build_query(
			  array(
			      'isbn' => $this->isbn,
			      'associate_tag' => $this->options_results->amazonaff,
			      'book_title' => $this->title,
			      'book_author' => $this->author,
			      'book_page' => $this->book_page,
			      'region' => $region,
			      'api_secret'=>$this->options_results->amazonapisecret,
			      'api_public'=>$this->options_results->amazonapipublic
			  )
			);
		} else {
			$postdata = http_build_query(
			  array(
			      'isbn' => $this->isbn,
			      'associate_tag' => $this->options_results->amazonaff,
			      'book_title' => $this->title,
			      'book_author' => $this->author,
			      'book_page' => $this->book_page,
			      'region' => $region,
			  )
			);
		}
		$opts = array('http' =>
		  array(
		      'method'  => 'POST',
		      'header'  => 'Content-type: application/x-www-form-urlencoded',
		      'content' => $postdata
		  )
		);

		if($this->isbn != '' && $this->isbn != null){
			$this->apireport = $this->apireport."Results for '".$this->isbn."': ";
		} else if($this->title != '' && $this->title != null){
			$this->apireport = $this->apireport."Results for '".$this->title."': ";
		} else {
			$this->apireport = $this->apireport."Results for Unknown Book: ";
		}

		

		$status = '';
		$this->amazonapiresult = '';
    	if(function_exists('file_get_contents')){
    		$this->amazonapiresult = @file_get_contents('https://sublime-vine-199216.appspot.com/?'.$postdata);
    		list($version, $status, $text) = explode(' ', $http_response_header[0], 3);
    		if($status == 200 && $this->amazonapiresult != ''){
    			$this->apireport = $this->apireport."Amazon API call via file_get_contents looks to be successful. URL Request was: 'https://sublime-vine-199216.appspot.com/?".$postdata."'. ";
    		} else {
    			$this->apireport = $this->apireport."Looks like we tried the Amazon file_get_contents function, but something went wrong. Status Code is: ".$status.". URL Request was: 'https://sublime-vine-199216.appspot.com/?".$postdata."'. ";

    			if($status == 500 || $status == '500'){
    				$this->apiamazonfailcount++;
    				$this->amazonfailstatus = '500';
    			}
    		}
    	}

    	if($this->amazonapiresult == ''){
    		if(function_exists('curl_init')){ 
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$url = 'https://sublime-vine-199216.appspot.com/?'.$postdata;
				curl_setopt($ch, CURLOPT_URL, $url);

				if($this->options_results->amazonapisecret != null && $this->options_results->amazonapisecret != '' && $this->options_results->amazonapipublic != null && $this->options_results->amazonapipublic != ''){
					$data = array('api_public'=>$this->options_results->amazonapipublic, 'api_secret'=>$this->options_results->amazonapisecret, 'book_page' => $this->book_page, 'book_title' => $this->title, 'book_author' => $this->author, 'associate_tag' => $this->options_results->amazonaff, 'isbn' => $this->isbn);
				} else {
					$data = array('book_title' => $this->title, 'associate_tag' => $this->options_results->amazonaff, 'isbn' => $this->isbn);
				}

				//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
				$this->amazonapiresult = curl_exec($ch);
				$responsecode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

				if($responsecode == 200){
					$this->apireport = $this->apireport."Amazon API call via cURL looks to be successful. URL Request was: 'https://sublime-vine-199216.appspot.com/?".$postdata."'. ";
				} else {
					$this->apireport = $this->apireport."Looks like we tried the Amazon cURL function, but something went wrong. Status Code is: ".$responsecode.". URL Request was: 'https://sublime-vine-199216.appspot.com/?".$postdata."'. ";

					if($status == 500 || $status == '500'){
    					$this->apiamazonfailcount++;
    					$this->amazonfailstatus = '500';
    				}

				}
				curl_close($ch);
	    	} else {
	        	$this->apireport = $this->apireport.'Looks like neither file_get_contents() nor cURL area available! ';
	    	}
    	}

    	// Convert result from API call to regular ol' array
    	if($this->apiamazonfailcount < 2){

	   		// If we're dealing with the Bookfinder Extension, do not append '</ItemLookupResponse>', otherwise do so
	    	if(strpos($this->amazonapiresult, '</ItemSearchResponse>') !== false){
	    		$this->amazonapiresult = explode('</ItemSearchResponse>', $this->amazonapiresult);
	    		$this->amazonapiresult = $this->amazonapiresult[0].'</ItemSearchResponse>';
	    	} else {
	    		$this->amazonapiresult = explode('</ItemLookupResponse>', $this->amazonapiresult);
	    		$this->amazonapiresult = $this->amazonapiresult[0].'</ItemLookupResponse>';
	    	}

    	
    		//error_log(print_r($this->amazonapiresult, TRUE));
			$xml = simplexml_load_string($this->amazonapiresult, 'SimpleXMLElement', LIBXML_NOCDATA);


			// Checking to see if the XML conversion was successful
			if($xml === false){
				$this->apireport = $this->apireport.'Looks like something went wrong with converting the Amazon API result to XML. ';
			} else {
				$this->apireport = $this->apireport.'Amazon XML conversion went well. ';

				// Convert XML to array
				$json = json_encode($xml);
				$this->amazon_array = json_decode($json,TRUE);
				//error_log(print_r($this->amazon_array, TRUE));

				// Now check and see if the converted XML contains any error report, and set the error flag if so
				$error_flag = false;
				if(	   array_key_exists('Items', $this->amazon_array) 
					&& array_key_exists('Request', $this->amazon_array['Items']) 
					&& array_key_exists('Errors', $this->amazon_array['Items']['Request']) 
					&& array_key_exists('Error', $this->amazon_array['Items']['Request']['Errors']) 
					&& array_key_exists('Message', $this->amazon_array['Items']['Request']['Errors']['Error'])){

					$this->apireport = $this->apireport."Amazon Error message is: '".$this->amazon_array['Items']['Request']['Errors']['Error']['Message']."' ";
					$error_flag = true;
				}


				# If $error_flag is false,  begin assigning values from $this->amazon_array to properties
				if(!$error_flag){
					// Get values from the Amazon Array that has a '0' as a key
					if(array_key_exists('Items', $this->amazon_array) && array_key_exists('Item', $this->amazon_array['Items']) && array_key_exists(0, $this->amazon_array['Items']['Item'])){


						// Get title
						if($this->title == null || $this->title == ''){
							$this->title = $this->amazon_array['Items']['Item'][0]['ItemAttributes']['Title'];
						}

						// Get cover image
						if($this->image == null || $this->image == ''){
							if(array_key_exists('LargeImage', $this->amazon_array['Items']['Item'][0]) && array_key_exists('URL', $this->amazon_array['Items']['Item'][0]['LargeImage'])){
								$this->image = $this->amazon_array['Items']['Item'][0]['LargeImage']['URL'];
							}
						}

						// Get author
						$author_string = '';
						if($this->author == null || $this->author == ''){

							if(array_key_exists('Author', $this->amazon_array['Items']['Item'][0]['ItemAttributes'])){
								$this->author = $this->amazon_array['Items']['Item'][0]['ItemAttributes']['Author'];
							}


							if(is_array($this->author)){
								foreach($this->author as $author){
									$author_string = $author_string.', '.$author;
								}
								$author_string = rtrim($author_string, ', ');
								$author_string = ltrim($author_string, ', ');
								$this->author = $author_string;
							}
						}

						// Getting pages
						if($this->pages == null || $this->pages == ''){
							if(array_key_exists('NumberOfPages', $this->amazon_array['Items']['Item'][0]['ItemAttributes'])){
								$this->pages = $this->amazon_array['Items']['Item'][0]['ItemAttributes']['NumberOfPages'];
							}
						}

						// Getting publication date
						if($this->pub_year == null || $this->pub_year == ''){
							$this->pub_year = $this->amazon_array['Items']['Item'][0]['ItemAttributes']['PublicationDate'];
						}

						// Getting publisher
						if($this->publisher == null || $this->publisher == ''){
							if(array_key_exists('Publisher', $this->amazon_array['Items']['Item'][0]['ItemAttributes'])){
								$this->publisher = $this->amazon_array['Items']['Item'][0]['ItemAttributes']['Publisher'];
							}
						}

						// Getting description
						if($this->description == null || $this->description == ''){

							if(array_key_exists('EditorialReviews', $this->amazon_array['Items']['Item'][0]) && array_key_exists('EditorialReview', $this->amazon_array['Items']['Item'][0]['EditorialReviews']) && array_key_exists('Content', $this->amazon_array['Items']['Item'][0]['EditorialReviews']['EditorialReview'])){
								$this->description = $this->amazon_array['Items']['Item'][0]['EditorialReviews']['EditorialReview']['Content'];
							}

							if($this->description == null || $this->description == ''){
								if(array_key_exists('EditorialReviews', $this->amazon_array['Items']['Item'][0]) && array_key_exists('EditorialReview', $this->amazon_array['Items']['Item'][0]['EditorialReviews']) && array_key_exists(0, $this->amazon_array['Items']['Item'][0]['EditorialReviews']['EditorialReview']) && array_key_exists('Content', $this->amazon_array['Items']['Item'][0]['EditorialReviews']['EditorialReview'][0])){

									$this->description = $this->amazon_array['Items']['Item'][0]['EditorialReviews']['EditorialReview'][0]['Content'];
								}
							}
					
						}

						// Getting amazon link, if we don't already have one
						if($this->amazonbuylink == '' || $this->amazonbuylink == null){
							if($this->amazon_detail_page == null || $this->amazon_detail_page == ''){
								$this->amazon_detail_page = $this->amazon_array['Items']['Item'][0]['DetailPageURL'];
							}
						} else {
							$this->amazon_detail_page = $this->amazonbuylink;
						}

						// Getting Amazon reviews iFrame
						if($this->review_iframe == null || $this->review_iframe == ''){
							$this->review_iframe = $this->amazon_array['Items']['Item'][0]['CustomerReviews']['IFrameURL'];
						}
						
				        
				        // Getting similar books
				        $similarproductsstring = '';
						if($this->similar_products == null || $this->similar_products == ''){
							if(array_key_exists('SimilarProducts', $this->amazon_array['Items']['Item'][0])){
								$this->similar_products = $this->amazon_array['Items']['Item'][0]['SimilarProducts']['SimilarProduct'];
							}
							if(is_array($this->similar_products)  && array_key_exists(0, $this->similar_products)){
								foreach($this->similar_products as $prod){
							      	$similarproductsstring = $similarproductsstring.';bsp;'.$prod['ASIN'].'---'.$prod['Title'];
							    }
							} else {
								$similarproductsstring = $similarproductsstring.';bsp;'.$this->similar_products['ASIN'].'---'.$this->similar_products['Title'];
							}

							$this->similar_products = $similarproductsstring;
						}


					} 

					// Get values from the Amazon Array that does not have a '0' as a key
					if(array_key_exists('Items', $this->amazon_array) && array_key_exists('Item', $this->amazon_array['Items']) && !array_key_exists(0, $this->amazon_array['Items']['Item'])){

						// Get title
						if($this->title == null || $this->title == ''){
							$this->title = $this->amazon_array['Items']['Item']['ItemAttributes']['Title'];
						}

						// Get cover image
						if($this->image == null || $this->image == ''){
							$this->image = $this->amazon_array['Items']['Item']['LargeImage']['URL'];
						}

						// Get author
						$author_string = '';
						if($this->author == null || $this->author == ''){
							if(array_key_exists('Author', $this->amazon_array['Items']['Item']['ItemAttributes'])){
								$this->author = $this->amazon_array['Items']['Item']['ItemAttributes']['Author'];
							}
							if(is_array($this->author)){
								foreach($this->author as $author){
									$author_string = $author_string.', '.$author;
								}
								$author_string = rtrim($author_string, ', ');
								$author_string = ltrim($author_string, ', ');
								$this->author = $author_string;
							}
						}

						// Getting pages
						if($this->pages == null || $this->pages == ''){
							if(array_key_exists('NumberOfPages', $this->amazon_array['Items']['Item']['ItemAttributes'])){
								$this->pages = $this->amazon_array['Items']['Item']['ItemAttributes']['NumberOfPages'];
							}
						}

						// Getting publication date
						if($this->pub_year == null || $this->pub_year == ''){
							if(array_key_exists('PublicationDate', $this->amazon_array['Items']['Item']['ItemAttributes'])){
								$this->pub_year = $this->amazon_array['Items']['Item']['ItemAttributes']['PublicationDate'];
							}
						}

						// Getting publisher
						if($this->publisher == null || $this->publisher == ''){
							if(array_key_exists('Publisher', $this->amazon_array['Items']['Item']['ItemAttributes'])){
								$this->publisher = $this->amazon_array['Items']['Item']['ItemAttributes']['Publisher'];
							}
						}

						// Getting description
						if($this->description == null || $this->description == ''){

							if( array_key_exists('EditorialReviews', $this->amazon_array['Items']['Item']) && array_key_exists('EditorialReview', $this->amazon_array['Items']['Item']['EditorialReviews']) && array_key_exists('Content', $this->amazon_array['Items']['Item']['EditorialReviews']['EditorialReview'])){
								$this->description = $this->amazon_array['Items']['Item']['EditorialReviews']['EditorialReview']['Content'];
							}

							if($this->description == null || $this->description == ''){

								if(array_key_exists('EditorialReviews', $this->amazon_array['Items']['Item']) && array_key_exists('EditorialReview', $this->amazon_array['Items']['Item']['EditorialReviews']) && array_key_exists(0, $this->amazon_array['Items']['Item']['EditorialReviews']['EditorialReview']) && array_key_exists('Content', $this->amazon_array['Items']['Item']['EditorialReviews']['EditorialReview'][0])){

									$this->description = $this->amazon_array['Items']['Item']['EditorialReviews']['EditorialReview'][0]['Content'];

								}
							}
						}

						// Getting amazon link, if we don't already have one
						if($this->amazonbuylink == '' || $this->amazonbuylink == null){
							if($this->amazon_detail_page == null || $this->amazon_detail_page == ''){
								$this->amazon_detail_page = $this->amazon_array['Items']['Item']['DetailPageURL'];
							}
						} else {
							$this->amazon_detail_page = $this->amazonbuylink;
						}

						// Getting Amazon reviews iFrame
						if($this->review_iframe == null || $this->review_iframe == ''){
							$this->review_iframe = $this->amazon_array['Items']['Item']['CustomerReviews']['IFrameURL'];
						}
				        
				        // Getting similar books
				        $similarproductsstring = '';
						if($this->similar_products == null || $this->similar_products == ''){

							if(array_key_exists('SimilarProducts', $this->amazon_array['Items']['Item'])){
								$this->similar_products = $this->amazon_array['Items']['Item']['SimilarProducts']['SimilarProduct'];
							}

							if(is_array($this->similar_products)  && array_key_exists(0, $this->similar_products)){
								foreach($this->similar_products as $prod){
							      	$similarproductsstring = $similarproductsstring.';bsp;'.$prod['ASIN'].'---'.$prod['Title'];
							    }
							} else {
								$similarproductsstring = $similarproductsstring.';bsp;'.$this->similar_products['ASIN'].'---'.$this->similar_products['Title'];
							}

							$this->similar_products = $similarproductsstring;
						}
					}

					// Setting up iFrame to play with https
					if( isset($_SERVER['HTTPS'] ) ) {
			            $pos = strpos($this->review_iframe, ':');
			            $this->review_iframe = substr_replace($this->review_iframe, 'https', 0, $pos);
			        }

		    	}

			}
		} else {

			if($this->rerun_amazon_flag){
				error_log('Re-running gather_amazon_data()');
				sleep(1);
				$this->rerun_amazon_flag = false;
				$this->apiamazonfailcount = 0;
				$this->gather_amazon_data();
			}
		}

        // Create report of what values were found and what weren't
        if($this->title != null && $this->title != ''){
        	$this->whichapifound['title'] = 'Amazon';
        }

        if($this->image != null && $this->image != ''){
        	$this->whichapifound['image'] = 'Amazon';
        }

        if($this->author != null && $this->author != ''){
        	$this->whichapifound['author'] = 'Amazon';
        }

        if($this->pages != null && $this->pages != ''){
        	$this->whichapifound['pages'] = 'Amazon';
        }

        if($this->pub_year != null && $this->pub_year != ''){
        	$this->whichapifound['pub_year'] = 'Amazon';
        }

        if($this->publisher != null && $this->publisher != ''){
        	$this->whichapifound['publisher'] = 'Amazon';
        }

        if($this->description != null && $this->description != ''){
        	$this->whichapifound['description'] = 'Amazon';
        }

        if($this->amazon_detail_page != '' && $this->amazon_detail_page != null){
        	$this->whichapifound['amazondetailpage'] = 'Amazon';
        }

        if($this->review_iframe != null && $this->review_iframe != ''){
        	$this->whichapifound['review_iframe'] = 'Amazon';
        }

        if($this->similar_products != null && $this->similar_products != ''){
        	$this->whichapifound['similar_products'] = 'Amazon';
        }



	}

	private function gather_google_data(){
		// If there's no ISBN # provided, there's no use in doing anything here
		if($this->isbn == null || $this->isbn == ''){
			return;
		}

		if($this->options_results->googleapi != null && $this->options_results->googleapi != ''){
			$google_api = $this->options_results->googleapi;
		} else {
			$google_api = 'AIzaSyBl6KEeKRddmhnK-jX65pGkjBW1Y6Q5_rM';
		}

		$status = '';
		$this->googleapiresult = '';
    	if(function_exists('file_get_contents')){
    		$this->googleapiresult = @file_get_contents('https://www.googleapis.com/books/v1/volumes?q=isbn:'.$this->isbn.'&key='.$google_api.'&country=US');
    		list($version, $status, $text) = explode(' ', $http_response_header[0], 3);
    		if($status == 200 && $this->googleapiresult != ''){
    			$this->apireport = $this->apireport."Google API call via file_get_contents looks to be successful. URL Request was: 'https://www.googleapis.com/books/v1/volumes?q=isbn:".$this->isbn."&key=".$google_api."&country=US. ";
    		} else {
    			$this->apireport = $this->apireport."Looks like we tried the Google file_get_contents function, but something went wrong. Status Code is: ".$status.". URL Request was: 'https://www.googleapis.com/books/v1/volumes?q=isbn:".$this->isbn."&key=".$google_api."&country=US. ";
    		}
    	}

    	if($this->googleapiresult == ''){
    		if (function_exists('curl_init')){ 
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$url = 'https://www.googleapis.com/books/v1/volumes?q=isbn:'.$this->isbn.'&key='.$google_api;
				curl_setopt($ch, CURLOPT_URL, $url);
				$this->googleapiresult = curl_exec($ch);
				$responsecode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if($responsecode == 200){
					$this->apireport = $this->apireport."Google API call via cURL looks to be successful. URL Request was: 'https://www.googleapis.com/books/v1/volumes?q=isbn:".$this->isbn."&key=".$google_api.". ";
				} else {
					$this->apireport = $this->apireport."Looks like we tried the Google cURL function, but something went wrong. Status Code is: ".$responsecode.". URL Request was: 'https://www.googleapis.com/books/v1/volumes?q=isbn:".$this->isbn."&key=".$google_api.". ";
				}
				curl_close($ch);
	    	} else {
	        	$this->apireport = $this->apireport.'Looks like neither file_get_contents() nor cURL area available! ';
	    	}
    	}

		if($this->googleapiresult != ''){		

	    	// Convert result to array
	    	$json_output_google = json_decode($this->googleapiresult, true);

	    	if(is_array($json_output_google)){
	    		$this->apireport = $this->apireport.'Google Array conversion went well. ';
	    	} else {
	    		$this->apireport = $this->apireport.'Looks like something went wrong with converting the Google API result to an array. ';
	    	}	

	    	// Now check and see if the array contains any error report, and set the error flag if so
			$error_flag = false;
			if(array_key_exists('error', $json_output_google) 
				&& array_key_exists('errors', $json_output_google['error']) 
				&& array_key_exists(0, $json_output_google['error']['errors']) 
				&& array_key_exists('message', $json_output_google['error']['errors'][0])){

				$this->apireport = $this->apireport."Google Error message is: '".$json_output_google['error']['errors'][0]['message']."' ";
				$error_flag = true;
			}

	    	//error_log(print_r($json_output_google, TRUE));
			if(!$error_flag){
		    	if(is_array($json_output_google) && array_key_exists('items', $json_output_google) && array_key_exists(0, $json_output_google['items']) && array_key_exists('volumeInfo', $json_output_google['items'][0]) ){
			    	# Making sure we didn't miss any values from Amazon data grab
					if($this->author == null || $this->author == ''){

						if(array_key_exists('author', $json_output_google['items'][0]['volumeInfo'])){
							$this->author  = $json_output_google['items'][0]['volumeInfo']['author'];
						}

						if(array_key_exists('authors', $json_output_google['items'][0]['volumeInfo']) && array_key_exists(0, $json_output_google['items'][0]['volumeInfo']['authors']) ){
							$this->author  = $json_output_google['items'][0]['volumeInfo']['authors'][0];
						}
					}

					if($this->image == null || $this->image == ''){
						$this->image = $json_output_google['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
					}

					if($this->pages == null || $this->pages == ''){
						$this->pages = $json_output_google['items'][0]['volumeInfo']['pageCount'];
					}   

					if($this->pub_year == null || $this->pub_year == ''){
						$this->pub_year = $json_output_google['items'][0]['volumeInfo']['publishedDate'];
					}

					if($this->publisher == null || $this->publisher == ''){
						$this->publisher = $json_output_google['items'][0]['volumeInfo']['publisher'];
					}

					if($this->description == null || $this->description == ''){
						if(array_key_exists('description', $json_output_google['items'][0]['volumeInfo'])){
							$this->description = $json_output_google['items'][0]['volumeInfo']['description'];
						}
					}

					if($this->category == null || $this->category == ''){
						if(array_key_exists('categories', $json_output_google['items'][0]['volumeInfo'])){
		  					$this->category = $json_output_google['items'][0]['volumeInfo']['categories'][0];
		  				}
			  		}
		  		}

		  		// Now getting new data
				if($this->googlebuylink == '' || $this->googlebuylink == 'undefined'){
					if(array_key_exists('items', $json_output_google)){
						$this->google_preview = $json_output_google['items'][0]['accessInfo']['webReaderLink'];
					}
				} else {
					$this->google_preview = $this->googlebuylink;
				}

			}
		}

		// Create report of what values were found and what weren't
        if($this->title != null && $this->title != '' && $this->whichapifound['title'] == ''){
        	$this->whichapifound['title'] = 'Google';
        }

        if($this->image != null && $this->image != '' && $this->whichapifound['image'] == ''){
        	$this->whichapifound['image'] = 'Google';
        }

        if($this->author != null && $this->author != '' && $this->whichapifound['author'] == ''){
        	$this->whichapifound['author'] = 'Google';
        }

        if($this->pages != null && $this->pages != '' && $this->whichapifound['pages'] == ''){
        	$this->whichapifound['pages'] = 'Google';
        }

        if($this->pub_year != null && $this->pub_year != '' && $this->whichapifound['pub_year'] == ''){
        	$this->whichapifound['pub_year'] = 'Google';
        }

        if($this->publisher != null && $this->publisher != '' && $this->whichapifound['publisher'] == ''){
        	$this->whichapifound['publisher'] = 'Google';
        }

        if($this->description != null && $this->description != '' && $this->whichapifound['description'] == ''){
        	$this->whichapifound['description'] = 'Google';
        }

        if($this->category != null && $this->category != '' && $this->whichapifound['category'] == ''){
        	$this->whichapifound['category'] = 'Google';
        }

        if($this->google_preview != null && $this->google_preview != '' && $this->whichapifound['google_preview'] == ''){
        	$this->whichapifound['google_preview'] = 'Google';
        }

	}

	private function gather_open_library_data(){

		// If there's no ISBN # provided, there's no use in doing anything here
		if($this->isbn == null || $this->isbn == ''){
			return;
		}



    	if(function_exists('file_get_contents')){
    		$this->openlibapiresult = @file_get_contents("https://openlibrary.org/api/books?bibkeys=ISBN:".$this->isbn."&jscmd=data&format=json");
    		list($version, $status, $text) = explode(' ', $http_response_header[0], 3);
    		if($status == 200 && $this->openlibapiresult != ''){
    			$this->apireport = $this->apireport."OpenLibrary API call via file_get_contents looks to be successful. URL Request was: 'https://openlibrary.org/api/books?bibkeys=ISBN:".$this->isbn."&jscmd=data&format=json'. ";
    		} else {
    			$this->apireport = $this->apireport."Looks like we tried the OpenLibrary file_get_contents function, but something went wrong. Status Code is: ".$status.". URL Request was: 'https://openlibrary.org/api/books?bibkeys=ISBN:".$this->isbn."&jscmd=data&format=json'. ";
    		}
    	}

    	if($this->openlibapiresult == ''){
    		if (function_exists('curl_init')){ 
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$url = "https://openlibrary.org/api/books?bibkeys=ISBN:".$this->isbn."&jscmd=data&format=json";
				curl_setopt($ch, CURLOPT_URL, $url);
				$this->openlibapiresult = curl_exec($ch);
				$responsecode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if($responsecode == 200){
					$this->apireport = $this->apireport."OpenLibrary API call via cURL looks to be successful. URL Request was: 'https://openlibrary.org/api/books?bibkeys=ISBN:".$this->isbn."&jscmd=data&format=json".". ";
				} else {
					$this->apireport = $this->apireport."Looks like we tried the OpenLibrary cURL function, but something went wrong. Status Code is: ".$responsecode.". URL Request was: 'https://openlibrary.org/api/books?bibkeys=ISBN:".$this->isbn."&jscmd=data&format=json".". ";
				}
				curl_close($ch);
	    	} else {
	        	$this->apireport = $this->apireport.'Looks like neither file_get_contents() nor cURL area available! ';
	    	}
    	}

    	if($this->openlibapiresult != ''){		

	    	// Convert result to array
	    	$json_output_ol = json_decode($this->openlibapiresult, true);
	    	$isbn_var = 'ISBN:'.$this->isbn; 


	    	if(is_array($json_output_ol) && sizeof($json_output_ol) > 0){
	    		$this->apireport = $this->apireport.'OpenLibrary Array conversion went well. ';
	    	} else {

	    		if(!is_array($json_output_ol)){
	    			$this->apireport = $this->apireport.'Looks like results may or may not have been returned from OpenLibrary, but either way, something went wrong with converting the result to an array. ';
	    		} else {
	    			$this->apireport = $this->apireport.'Looks like the conversion to an array from OpenLibrary was successful, but it doesn\'t contain any data - book can\'t be found via OpenLibrary API. ';
	    		}
	    	}
	    	

	    	if(array_key_exists($isbn_var, $json_output_ol)){

				if($this->author == null || $this->author == ''){
					if(array_key_exists('authors', $json_output_ol[$isbn_var]) && array_key_exists(0, $json_output_ol[$isbn_var]['authors']) &&  array_key_exists('name', $json_output_ol[$isbn_var]['authors'][0]) ){
						$this->author = $json_output_ol[$isbn_var]['authors'][0]['name'];
					}
				}

				if($this->image == null || $this->image == ''){
					if(array_key_exists('cover', $json_output_ol[$isbn_var])){
						$this->image = $json_output_ol[$isbn_var]['cover']['large'];
					}
				}

				if($this->pages == null || $this->pages == ''){
					if(array_key_exists('number_of_pages', $json_output_ol[$isbn_var])){
						$this->pages = $json_output_ol[$isbn_var]['number_of_pages'];
					}
				}   

				if($this->pub_year == null || $this->pub_year == ''){
					if(array_key_exists('publish_date', $json_output_ol[$isbn_var])){
						$this->pub_year = $json_output_ol[$isbn_var]['publish_date'];
					}
				}

				if($this->publisher == null || $this->publisher == ''){
					if(array_key_exists('publishers', $json_output_ol[$isbn_var])){
						$this->publisher = $json_output_ol[$isbn_var]['publishers'][0]['name'];
					}
				}

				if($this->category == null || $this->category == ''){
					if(array_key_exists('subjects', $json_output_ol[$isbn_var])){
						$this->category = $json_output_ol[$isbn_var]['subjects'][0]['name'];	
					}
				}
			}
		}

		// Create report of what values were found and what weren't
        if($this->title != null && $this->title != '' && $this->whichapifound['title'] == ''){
        	$this->whichapifound['title'] = 'OpenLibrary';
        }

        if($this->image != null && $this->image != '' && $this->whichapifound['image'] == ''){
        	$this->whichapifound['image'] = 'OpenLibrary';
        }

        if($this->author != null && $this->author != '' && $this->whichapifound['author'] == ''){
        	$this->whichapifound['author'] = 'OpenLibrary';
        }

        if($this->pages != null && $this->pages != '' && $this->whichapifound['pages'] == ''){
        	$this->whichapifound['pages'] = 'OpenLibrary';
        }

        if($this->pub_year != null && $this->pub_year != '' && $this->whichapifound['pub_year'] == ''){
        	$this->whichapifound['pub_year'] = 'OpenLibrary';
        }

        if($this->publisher != null && $this->publisher != '' && $this->whichapifound['publisher'] == ''){
        	$this->whichapifound['publisher'] = 'OpenLibrary';
        }

        if($this->description != null && $this->description != '' && $this->whichapifound['description'] == ''){
        	$this->whichapifound['description'] = 'OpenLibrary';
        }

        if($this->category != null && $this->category != '' && $this->whichapifound['category'] == ''){
        	$this->whichapifound['category'] = 'OpenLibrary';
        }

 
	}

	private function gather_itunes_data(){

		// If there's no ISBN # provided, there's no use in doing anything here
		if($this->isbn == null || $this->isbn == ''){
			return;
		}

		global $wpdb;

		// Get associate tag for creating API call post data
		$table_name_options = $wpdb->prefix . 'wpbooklist_jre_user_options';
  		$this->options_results = $wpdb->get_row("SELECT * FROM $table_name_options");


    	if(function_exists('file_get_contents')){
    		$this->itunesapiresult = @file_get_contents('https://itunes.apple.com/lookup?isbn='.$this->isbn.'&at='.$this->options_results->itunesaff);
    		list($version, $status, $text) = explode(' ', $http_response_header[0], 3);
    		if($status == 200 && $this->itunesapiresult != ''){
    			$this->apireport = $this->apireport."iTunes iBooks API call via file_get_contents looks to be successful. URL Request was: 'https://itunes.apple.com/lookup?isbn=".$this->isbn."&at=".$this->options_results->itunesaff.". ";
    		} else {
    			$this->apireport = $this->apireport."Looks like we tried the iTunes iBooks file_get_contents function, but something went wrong. Status Code is: ".$status.". URL Request was: 'https://itunes.apple.com/lookup?isbn=".$this->isbn."&at=".$this->options_results->itunesaff.". ";
    		}
    	}

    	if($this->itunesapiresult == ''){
    		if (function_exists('curl_init')){ 
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$url = 'https://itunes.apple.com/lookup?isbn='.$this->isbn.'&at='.$this->options_results->itunesaff;
				curl_setopt($ch, CURLOPT_URL, $url);
				$this->itunesapiresult = curl_exec($ch);
				$responsecode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				if($responsecode == 200){
					$this->apireport = $this->apireport."iTunes iBooks API call via cURL looks to be successful. URL Request was: 'https://itunes.apple.com/lookup?isbn=".$this->isbn."&at=".$this->options_results->itunesaff.". ";
				} else {
					$this->apireport = $this->apireport."Looks like we tried the iTunes iBooks cURL function, but something went wrong. Status Code is: ".$responsecode.". URL Request was: 'https://itunes.apple.com/lookup?isbn=".$this->isbn."&at=".$this->options_results->itunesaff.". ";
				}
				curl_close($ch);
	    	} else {
	        	$this->apireport = $this->apireport.'Looks like neither file_get_contents() nor cURL area available! ';
	    	}
    	}

	    if($this->itunesapiresult != ''){	
		  	$json_output_itunes = json_decode($this->itunesapiresult, true);

		  	if(is_array($json_output_itunes) && array_key_exists('resultCount', $json_output_itunes) && $json_output_itunes['resultCount'] != 0){
	    		$this->apireport = $this->apireport.'iTunes iBooks Array conversion went well. ';
	    	} else {

	    		if(!is_array($json_output_itunes)){
	    			$this->apireport = $this->apireport.'Looks like results may or may not have been returned from iTunes iBooks, but either way, something went wrong with converting the result to an array. ';
	    		} else {
	    			$this->apireport = $this->apireport.'Looks like the conversion to an array from iTunes iBooks was successful, but it doesn\'t contain any data - book can\'t be found via iTunes iBooks API. ';
	    		}
	    	}

	    	//error_log(print_r($json_output_itunes, TRUE));

		  	if($this->itunesbuylink == '' || $this->itunesbuylink == null){
		  		if($json_output_itunes != null && is_array($json_output_itunes) && array_key_exists('results', $json_output_itunes) && array_key_exists(0, $json_output_itunes) && array_key_exists('trackViewUrl', $json_output_itunes)){
			  		$this->itunes_page = $json_output_itunes['results'][0]['trackViewUrl'];
			  	}	
		  	} else {
		  		$this->itunes_page = $this->itunesbuylink;
		  	}

	  	}





	  	// If we didn't find the book via iBooks, let's search for the Audiobook via itunes
		if($this->itunes_page == null || $this->itunes_page == ''){
	    	if(function_exists('file_get_contents')){
	    		$title = urlencode($this->title);
	    		$this->itunesapiresult = @file_get_contents('https://itunes.apple.com/search?term='.$title.'&at='.$this->options_results->itunesaff);
	    		list($version, $status, $text) = explode(' ', $http_response_header[0], 3);
	    		if($status == 200 && $this->itunesapiresult != ''){
	    			$this->apireport = $this->apireport."iTunes Audiobooks API call via file_get_contents looks to be successful. URL Request was: 'https://itunes.apple.com/lookup?isbn=".$this->isbn."&at=".$this->options_results->itunesaff.". ";
	    		} else {
	    			$this->apireport = $this->apireport."Looks like we tried the iTunes Audiobooks file_get_contents function, but something went wrong. Status Code is: ".$status.". URL Request was: 'https://itunes.apple.com/lookup?isbn=".$this->isbn."&at=".$this->options_results->itunesaff.". ";
	    		}
	    	}

		  	if($this->itunesapiresult == ''){
	    		if (function_exists('curl_init')){ 
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$url = 'https://itunes.apple.com/search?term='.$title.'&at='.$this->options_results->itunesaff;
					$this->itunesapiresult = curl_exec($ch);
					$responsecode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					if($responsecode == 200){
						$this->apireport = $this->apireport."iTunes Audiobooks API call via cURL looks to be successful. URL Request was: 'https://itunes.apple.com/search?term=".$title."&at=".$this->options_results->itunesaff;
					} else {
						$this->apireport = $this->apireport."Looks like we tried the iTunes Audiobooks cURL function, but something went wrong. Status Code is: ".$responsecode.". URL Request was: 'https://itunes.apple.com/search?term=".$title."&at=".$this->options_results->itunesaff;
					}
						curl_close($ch);
			    	} else {
			        	$this->apireport = $this->apireport.'Looks like neither file_get_contents() nor cURL area available! ';
			    	}
	    	}

		  	$json_output_itunes = json_decode($this->itunesapiresult, true);

		  	if(is_array($json_output_itunes) && array_key_exists('resultCount', $json_output_itunes) && $json_output_itunes['resultCount'] != 0){
	    		$this->apireport = $this->apireport.'iTunes Audiobooks Array conversion went well. ';
	    	} else {

	    		if(!is_array($json_output_itunes)){
	    			$this->apireport = $this->apireport.'Looks like results may or may not have been returned from iTunes Audiobooks, but either way, something went wrong with converting the result to an array. ';
	    		} else {
	    			$this->apireport = $this->apireport.'Looks like the conversion to an array from iTunes Audiobooks was successful, but it doesn\'t contain any data - book can\'t be found via iTunes Audiobooks API. ';
	    		}
	    	}

		  	if($json_output_itunes != null && is_array($json_output_itunes) && array_key_exists('results', $json_output_itunes) && array_key_exists(0, $json_output_itunes) && array_key_exists('trackViewUrl', $json_output_itunes)){
		  		$this->itunes_page = $json_output_itunes['results'][0]['trackViewUrl'];
		  	}

		}


	  	// Create report of what values were found and what weren't
        if($this->itunes_page != null && $this->itunes_page != '' && $this->whichapifound['itunes_page'] == ''){
        	$this->whichapifound['itunes_page'] = 'iTunes iBooks';
        }

        
	}

	private function set_default_woocommerce_data(){
		global $wpdb;

		// Check to see if Storefront extension is active
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if(is_plugin_active('wpbooklist-storefront/wpbooklist-storefront.php')){
			
			// Get saved settings
	    	$settings_table = $wpdb->prefix."wpbooklist_jre_storefront_options";
	    	$settings = $wpdb->get_row("SELECT * FROM $settings_table");

	    	if($this->saleprice == '' || $this->saleprice == null){
	    		$this->saleprice = $settings->defaultsaleprice;
	    	}

	    	if($this->regularprice == '' || $this->regularprice == null){
	    		$this->regularprice = $settings->defaultprice;
	    	}

	    	if($this->stock == '' || $this->stock == null){
	    		$this->stock = $settings->defaultstock;
	    	}

	    	if($this->length == '' || $this->length == null){
	    		$this->length = $settings->defaultlength;
	    	}

	    	if($this->width == '' || $this->width == null){
	    		$this->width = $settings->defaultwidth;
	    	}

	    	if($this->height == '' || $this->height == null){
	    		$this->height = $settings->defaultheight;
	    	}

	    	if($this->weight == '' || $this->weight == null){
	    		$this->weight = $settings->defaultweight;
	    	}

	    	if($this->sku == '' || $this->sku == null){
	    		$this->sku = $settings->defaultsku;
	    	}

	    	if($this->virtual == '' || $this->virtual == null){
	    		$this->virtual = $settings->defaultvirtual;
	    	}

	    	if($this->download == '' || $this->download == null){
	    		$this->download = $settings->defaultdownload;
	    	}

	    	if($this->salebegin == '-undefined-undefined' || $this->salebegin == null){
	    		$this->salebegin = $settings->defaultsalebegin;
	    	}

	    	if($this->saleend == '-undefined-undefined' || $this->saleend == null){
	    		$this->saleend = $settings->defaultsaleend;
	    	}

	    	if($this->purchasenote == '' || $this->purchasenote == null){
	    		$this->purchasenote = $settings->defaultnote;
	    	}

	    	if($this->productcategory == '' || $this->productcategory == null){
	    		$this->productcategory = $settings->defaultcategory;
	    	}

	    	if($this->upsells == '' || $this->upsells == null){
	    		$this->upsells = $settings->defaultupsell;
	    	}

	    	if($this->crosssells == '' || $this->crosssells == null){
	    		$this->crosssells = $settings->defaultcrosssell;
	    	}

		}

	}

	private function create_wpbooklist_woocommerce_product(){

		global $wpdb;

		if($this->woocommerce === 'true'){

			$price = '';
			if($this->price != null && $this->price != ''){
				if(!is_numeric($this->price[0])){
					$price = substr($this->price, 1);
				} else {
					$price = $this->price;
				}
			} else {
				if($this->regularprice != null && $this->regularprice != ''){
					if(!is_numeric($this->regularprice[0])){
						$price = substr($this->regularprice, 1);
					} else {
						$price = $this->regularprice;
					}
				} else {
					$price = '0.00';
				}
			}

			$woocommerce_existing_id = $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->library WHERE ID = %d",$this->id ));
			
			include_once( STOREFRONT_CLASS_DIR . 'class-storefront-woocommerce.php');
  			$this->woocommerce = new WPBookList_StoreFront_WooCommerce($this->title, $this->description, $this->image, $price, $this->saleprice, $this->stock, $this->length, $this->width, $this->height, $this->weight, $this->sku, $this->virtual, $this->download, $this->woofile, $this->salebegin, $this->saleend, $this->purchasenote, $this->productcategory, $this->reviews, $woocommerce_existing_id->woocommerce, $this->upsells, $this->crosssells);

  			$this->wooid = $this->woocommerce->post_id;
  			error_log('Woocommerce post id:'.$this->woocommerce->post_id.' and '.$woocommerce_existing_id->woocommerce);

		}
	}

	private function create_author_first_last(){

		$title_array = array(
          'Jr.',
          'Ph.D.',
          'Mr.',
          'Mrs.'
        );



        $origauthorname = $this->author;
        $title = '';
        $this->finalauthorlastnames = '';
        $this->finalauthorfirstnames = '';

        // First let's handle names with commas, which we'll assume indicates multiple authors
        if(strpos($origauthorname, ',') !== false && $this->finalauthorlastnames == '' && $this->finalauthorfirstnames == ''){
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
            $this->finalauthorlastnames = $lastnamecolonstring;
            $this->finalauthorfirstnames = $firstnamecolonstring;
        }

        // Next we'll handle the names of single authors who may have a title in their name
        foreach ($title_array as $titlekey => $titlevalue) {

          // If author name has a title in it, and does not have a comma (indicating multiple authors), then proceed
          if($this->finalauthorlastnames == '' && $this->finalauthorfirstnames == '' && stripos($origauthorname, $titlevalue) !== false &&  stripos($origauthorname, ',') === false ){
            $tempname = str_replace($titlevalue, '', $origauthorname);
            $tempname = rtrim($tempname, ' ');
            $title = $titlevalue;
          
            // Now split up first/last names
            $this->finalauthorfirstnames = implode(' ', explode(' ', $tempname, -1)).' '.$titlevalue;
            $temp = explode(' ', strrev($tempname), 2);
            $this->finalauthorlastnames = strrev($temp[0]);

          }
        }

        // Now if the Author's name does not contain a comma or a title...
        foreach ($title_array as $titlekey => $titlevalue) {
          // If author name does not have a title in it, and does not have a comma (indicating multiple authors), then proceed
          if($this->finalauthorlastnames == '' && $this->finalauthorfirstnames == '' && stripos($origauthorname, $titlevalue) === false &&  stripos($origauthorname, ',') === false ){
            // Now split up first/last names
            $this->finalauthorfirstnames = implode(' ', explode(' ', $origauthorname, -1));
            $temp = explode(' ', strrev($origauthorname), 2);
            $this->finalauthorlastnames = strrev($temp[0]);
          }
        }
	}

	private function add_to_db(){

		$post = null;
		$page = null;

		// Create a unique identifier for this book
		$this->book_uid = uniqid();

		if($this->page_yes || $this->post_yes){
			$page_post_array = array(
				'library' => $this->library,
				'amazon_auth_yes' => $this->amazon_auth_yes,
				'use_amazon_yes' => $this->use_amazon_yes,
				'title' => $this->title, 
				'isbn' => $this->isbn,
				'author' => $this->author,
				'author_url' => $this->author_url,
				'price' => $this->price,
				'finished' => $this->finished,
				'date_finished' => $this->date_finished,
				'signed' => $this->signed,
				'first_edition' => $this->first_edition,
				'image' => $this->image,
				'pages' => $this->pages,
				'pub_year' => $this->pub_year,
				'publisher' => $this->publisher,
				'category' => $this->category,
				'subject' => $this->subject,
				'country' => $this->country,
				'description' => $this->description,
				'notes' => $this->notes,
				'rating' => $this->rating,
				'page_yes' => $this->page_yes,
				'post_yes' => $this->post_yes,
				'itunes_page' => $this->itunes_page,
				'google_preview' => $this->google_preview,
				'amazon_detail_page' => $this->amazon_detail_page,
				'review_iframe' => $this->review_iframe,
				'similar_products' => $this->similar_products,
				'book_uid' => $this->book_uid,
				'lendable' => $this->lendable,
				'copies' => $this->copies,
				'kobo_link' => $this->kobo_link,
				'bam_link' => $this->bam_link,
				'woocommerce' => $this->wooid,
				'authorfirst' => $this->finalauthorfirstnames,
				'authorlast' => $this->finalauthorlastnames
			);

			# Each of these class instantiations will return the ID of the page/post created for storage in DB
			$page = $this->page_yes;
			$post = $this->post_yes;

			if($this->post_yes == 'true'){
				require_once(CLASS_DIR.'class-post.php');
				$post = new WPBookList_Post($page_post_array);
				$post = $post->post_id;
			}

			if($this->page_yes == 'true'){
				require_once(CLASS_DIR.'class-page.php');
				$page = new WPBookList_Page($page_post_array);
				$page = $page->create_result;
			}

		}

		// Check to see if Storefront extension is active
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if(is_plugin_active('wpbooklist-storefront/wpbooklist-storefront.php')){
			if($this->author_url == '' || $this->author_url == null){
				if($this->wooid != '' || $this->wooid != null){
					$this->author_url = get_permalink($this->wooid);

					if($this->price == null || $this->price == ''){
						$this->price = $this->regularprice;
					}
				}
			}
		}

		// Adding submitted values to the DB
		global $wpdb;
		$result = $wpdb->insert( $this->library, array(
          'title' => $this->title, 
          'isbn' => $this->isbn,
          'author' => $this->author,
          'author_url' => $this->author_url,
          'price' => $this->price,
          'finished' => $this->finished,
          'date_finished' => $this->date_finished,
          'signed' => $this->signed,
          'first_edition' => $this->first_edition,
          'image' => $this->image,
          'pages' => $this->pages,
          'pub_year' => $this->pub_year,
          'publisher' => $this->publisher,
          'category' => $this->category,
          'subject' => $this->subject,
          'country' => $this->country,
          'description' => $this->description,
          'notes' => $this->notes,
          'rating' => $this->rating,
          'page_yes' => $page,
          'post_yes' => $post,
          'itunes_page' => $this->itunes_page,
          'google_preview' => $this->google_preview,
          'amazon_detail_page' => $this->amazon_detail_page,
          'review_iframe' => $this->review_iframe,
          'similar_products' => $this->similar_products,
          'book_uid' => $this->book_uid,
          'lendable' => $this->lendable,
		  'copies' => $this->copies,
		  'kobo_link' => $this->kobo_link,
		  'bam_link' => $this->bam_link,
		  'woocommerce' => $this->wooid,
		  'authorfirst' => $this->finalauthorfirstnames,
		  'authorlast' => $this->finalauthorlastnames
          ),
        array(
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s',
              '%d',
              '%s',
              '%s',
              '%s',
              '%s',
              '%s'
          )   
  		);

		$this->add_result = $result;
		if($result == 1){

			// Introduce a check for reporting to the user that it looks like there wasn't much API data found for the book


			$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->library WHERE book_uid = %s", $this->book_uid));
			$this->add_result = $this->add_result.','.$row->ID;
		} else {
			$this->add_result = $this->add_result.','.$wpdb->last_error;

		}
		// TODO: Create a log class to record the result of adding the book - or maybe just record an error, if there is one. Make a link for the log file somehwere, on settings page perhaps, for user to download. 

		// Insert the Amazon Authorization into the DB if it's not already set to 'Yes'
		$table_name_options = $wpdb->prefix . 'wpbooklist_jre_user_options';
  		$this->options_results = $wpdb->get_row("SELECT * FROM $table_name_options");
  		if($this->options_results->amazonauth != 'true'){
			$data = array(
	        	'amazonauth' => $this->amazon_auth_yes
		    );
		    $format = array( '%s'); 
		    $where = array( 'ID' => 1 );
		    $where_format = array( '%d' );
		    $wpdb->update( $wpdb->prefix.'wpbooklist_jre_user_options', $data, $where, $format, $where_format );
		}

	}

	public static function display_edit_book_form(){

		// Perform check for previously-saved Amazon Authorization
		global $wpdb;
		$table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
		$opt_results = $wpdb->get_row("SELECT * FROM $table_name");

		$table_name = $wpdb->prefix . 'wpbooklist_jre_list_dynamic_db_names';
		$db_row = $wpdb->get_results("SELECT * FROM $table_name");

		// For grabbing an image from media library
		wp_enqueue_media();
	 	$string1 = '<div id="wpbooklist-editbook-container">
				<p><span ';

					if($opt_results->amazonauth == 'true'){ 
						$string2 = 'style="display:none;"';
					} else {
						$string2 = '';
					}

					$string3 = ' >You must check the box below to authorize <span class="wpbooklist-color-orange-italic">WPBookList</span> to gather data from Amazon, otherwise, the only data that will be added for your book is what you fill out on the form below. WPBookList uses it\'s own Amazon Product Advertising API keys to gather book data, but if you happen to have your own API keys, you can use those instead by adding them on the <a href="'.menu_page_url( 'WPBookList-Options-settings', false ).'&tab=amazon">Amazon Settings</a> page.</span></p>
          		<form id="wpbooklist-editbook-form" method="post" action="">
		          	<div id="wpbooklist-authorize-amazon-container">
		    			<table>';

		    			if($opt_results->amazonauth == 'true'){ 
							$string4 = '<tr style="display:none;"">
		    					<td><p id="auth-amazon-question-label">Authorize Amazon Usage?</p></td>
		    				</tr>
		    				<tr style="display:none;"">
		    					<td>
		    						<input checked type="checkbox" name="authorize-amazon-yes" />
		    						<label for="authorize-amazon-yes">Yes</label>
		    						<input type="checkbox" name="authorize-amazon-no" />
		    						<label for="authorize-amazon-no">No</label>
		    					</td>
		    				</tr>';
						} else {
							$string4 = '<tr>
		    					<td><p id="auth-amazon-question-label">Authorize Amazon Usage?</p></td>
		    				</tr>
		    				<tr>
		    					<td>
		    						<input type="checkbox" name="authorize-amazon-yes" />
		    						<label for="authorize-amazon-yes">Yes</label>
		    						<input type="checkbox" name="authorize-amazon-no" />
		    						<label for="authorize-amazon-no">No</label>
		    					</td>
		    				</tr>';
						}

		    			$string5 = '</table>
		    		</div>
	          		<div id="wpbooklist-use-amazon-container">
		    			<table>
		    				<tr>
		    					<td><p id="use-amazon-question-label">Automatically Gather Book Info From Amazon (ISBN/ASIN number required)?</p></td>
		    				</tr>
		    				<tr>
		    					<td style="text-align:center;">
		    						<input checked type="checkbox" name="use-amazon-yes" />
		    						<label for="use-amazon-yes">Yes</label>
		    						<input type="checkbox" name="use-amazon-no" />
		    						<label for="use-amazon-no">No</label>
		    					</td>
		    				</tr>
		    			</table>
		    		</div>
		          	<table>
		            	<tbody>
		            		<tr>
				              <td>
				                <label for="isbn">ISBN/ASIN: </label>
				              </td>
				              <td>
				                <label id="wpbooklist-editbook-label-booktitle" for="book-title">Book Title:</label>
				              </td>
				              <td>
				                <label for="book-author">Author: </label>
				              </td>
				              <td>
				                <label for="book-category">Category: </label><br>
				              </td>
		            		</tr>
		            		<tr>
								<td>
									<input type="text" id="wpbooklist-editbook-isbn" name="book-isbn">
								</td>
								<td>
									<input type="text" id="wpbooklist-editbook-title" name="book-title" size="30">
								</td>
								<td>
									<input type="text" id="wpbooklist-editbook-author" name="book-author" size="30">
								</td>
								<td>
									<input type="text" id="wpbooklist-editbook-category" name="book-category" size="30">
								</td>
		            		</tr>
		            		<tr>
								<td>
									<label for="book-pages">'.__('Pages:','wpbooklist').' </label><br>
								</td>
								<td>
									<label for="book-pubdate">'.__('Publication Year:','wpbooklist').' </label><br>
								</td>
								<td>
									<label for="book-publisher">'.__('Publisher:','wpbooklist').' </label><br>
								</td>
								<td>
									<label for="book-subject">'.__('Subject:','wpbooklist').' </label><br>
								</td>
		            		</tr>
		            		<tr>
								<td>
									<input type="number" id="wpbooklist-editbook-pages" name="book-pages" size="30">
								</td>
								<td>
									<input type="text" id="wpbooklist-editbook-pubdate" name="book-pubdate" size="30">
								</td>
								<td>
									<input type="text" id="wpbooklist-editbook-publisher" name="book-publisher" size="30">
								</td>
								<td>
									<input type="text" id="wpbooklist-editbook-subject" name="book-subject" size="30">
								</td>
		            		</tr>
		            		<tr>
								<td>
									<label for="book-country">'.__('Country:','wpbooklist').' </label><br>
								</td>
		            		</tr>
		            		<tr>
								<td>
									<input type="text" id="wpbooklist-editbook-country" name="book-country" size="30">
								</td>
		            		</tr>
		            		<tr id="wpbooklist-addbook-page-post-create-label-row">
								<td colspan="2">
									<label class="wpbooklist-editbook-page-post-label" for="book-indiv-page">Create Individual Page?</label><br>
								</td>
								<td colspan="2">
									<label class="wpbooklist-editbook-page-post-label" for="book-indiv-post">Create Individual Post? </label><br>
								</td>
		            		</tr>
				            <tr id="wpbooklist-editbook-page-post-row">
				              <td colspan="2" class="wpbooklist-editbook-post-page-checkboxes">
				              	<input type="checkbox" id="wpbooklist-editbook-page-yes" name="book-indiv-page-yes" value="yes"/><label>Yes</label>
		                        <input type="checkbox" id="wpbooklist-editbook-page-no" name="book-indiv-page-no" value="no"/><label>No</label>
				              </td>
				              <td colspan="2" class="wpbooklist-editbook-post-page-checkboxes">
				              	<input type="checkbox" id="wpbooklist-editbook-post-yes" name="book-indiv-post-yes" value="yes"/><label>Yes</label>
		                        <input type="checkbox" id="wpbooklist-editbook-post-no" name="book-indiv-post-no" value="no"/><label>No</label>
				              </td>
				            </tr>
		            		<tr>
								<td colspan="2">
									<label for="book-description">Description (accepts html): </label><br>
								</td>
								<td colspan="2">
									<label for="book-notes">Notes (accepts html):</label><br>
								</td>
		            		</tr>
				            <tr>
				              <td colspan="2">
				                <textarea id="wpbooklist-editbook-description" name="book-description" rows="3" size="30"></textarea>
				              </td>
				              <td colspan="2">
				                <textarea id="wpbooklist-editbook-notes" name="book-notes" rows="3" size="30"></textarea>
				              </td>
				            </tr>
		            		<tr>
		              			<td colspan="2">
									<label for="book-rating">Rate This Title: </label><img id="wpbooklist-editbook-rating-img" src="'.ROOT_IMG_URL.'5star.png'.'" /><br>
								</td>
		              			<td colspan="2">
				                	<label id="wpbooklist-editbook-image-label" for="book-image">Cover Image:</label><input id="wpbooklist-editbook-upload_image_button" type="button" value="Choose Image"/><br>
				              	</td>
		            		</tr>
		            		<tr>
		              			<td colspan="2" style="vertical-align:top">
		                        	<select id="wpbooklist-editbook-rating">
		                        		<option selected>
		                        			Select a Rating...
		                        		</option>
		                    			<option value="5">
		                    				5 Stars
		                    			</option>
		                    			<option value="4">
		                    				4 Stars
		                    			</option>
		                    			<option value="3">
		                    				3 Stars
		                    			</option>
		                    			<option value="2">
		                    				2 Stars
		                    			</option>
		                    			<option value="1">
		                    				1 Star
		                    			</option>
		                  			</select>
		                        </td>
		              			<td colspan="2" style="position:relative">
		                			<input type="text" id="wpbooklist-editbook-image" name="book-image">
		                			<img id="wpbooklist-editbook-preview-img" src="'.ROOT_IMG_ICONS_URL.'book-placeholder.svg'.'" />
		                		</td>
		        			</tr>
		        			<tr>
								<td colspan="2">
									<label for="amazon-purchase-link">Amazon Link: </label><br>
								</td>
								<td colspan="2">
									<label for="bn-link">Barnes & Noble Link:</label><br>
								</td>
		            		</tr>
		        			<tr>
				              <td colspan="2">
				                <input type="text" id="wpbooklist-editbook-amazon-buy-link" name="amazon-purchase-link">
				              </td>
				              <td colspan="1">
				                <input type="text" id="wpbooklist-editbook-bn-link" name="bn-link">
				              </td>
				            </tr>
				            <tr>
								<td colspan="2">
									<label for="google-purchase-link">Google Play Link: </label><br>
								</td>
								<td colspan="2">
									<label for="itunes-link">iTunes Link:</label><br>
								</td>
		            		</tr>
		        			<tr>
				              <td colspan="2">
				                <input type="text" id="wpbooklist-editbook-google-play-buy-link" name="google-purchase-link">
				              </td>
				              <td colspan="1">
				                <input type="text" id="wpbooklist-editbook-itunes-link" name="itunes-link">
				              </td>
				            </tr>
				            <tr>
								<td colspan="2">
									<label for="booksamillion-purchase-link">Books-A-Million Link: </label><br>
								</td>
								<td colspan="2">
									<label for="kobo-link">Kobo Link:</label><br>
								</td>
		            		</tr>
		        			<tr>
				              <td colspan="2">
				                <input type="text" id="wpbooklist-editbook-books-a-million-buy-link" name="booksamillion-purchase-link">
				              </td>
				              <td colspan="1">
				                <input type="text" id="wpbooklist-editbook-kobo-link" name="kobo-link">
				              </td>
				            </tr>';

		        			// This filter allows the addition of one or more rows of items into the 'Add A Book' form. 
		        			$string6 = '';
		        			if(has_filter('wpbooklist_append_to_editbook_form')) {
            					$string6 = apply_filters('wpbooklist_append_to_editbook_form', $string6);
        					}

        					// This filter allows the addition of one or more rows of items into the 'Add A Book' form. 
		        			if(has_filter('wpbooklist_append_to_addbook_form_bookswapper')) {
            					$string6 = apply_filters('wpbooklist_append_to_addbook_form_bookswapper', $string6);
        					}



		        			$string7 = '
		          		</tbody>
		          	</table>
		            <div id="wpbooklist-editbook-signed-first-container">
						<table id="wpbooklist-editbook-signed-first-table">
			                <tbody>
			                	<tr>
				                    <td><label for="book-date-finished">Have You Finished This Book?</label></td>
				                    <td><label id="wpbooklist-editbook-signed-question" for="book-signed">Is This Book Signed?</label></td>
				                    <td><label id="wpbooklist-editbook-first-edition-question" for="book-first-edition">Is it a First Edition?</label></td>
			                	</tr>
		                        <tr>
		                            <td>
		                            	<input type="checkbox" id="wpbooklist-editbook-finished-yes" name="book-finished-yes" value="yes"/><label>Yes</label>
		                            	<input type="checkbox" id="wpbooklist-editbook-finished-no" name="book-finished-no" value="no"/><label>No</label>
		                            </td>
		                            <td id="wpbooklist-editbook-signed-td">
		                            	<input type="checkbox" id="wpbooklist-editbook-signed-yes" name="book-signed-yes" value="yes"/><label>Yes</label>
		                            	<input type="checkbox" id="wpbooklist-editbook-signed-no" name="book-signed-no" value="no"/><label>No</label>
		                            </td>
		                            <td id="wpbooklist-editbook-firstedition-td">
		                            	<input type="checkbox" id="wpbooklist-editbook-firstedition-yes" name="book-firstedition-yes" value="yes"/><label>Yes</label>
		                            	<input type="checkbox" id="wpbooklist-editbook-firstedition-no" name="book-firstedition-no" value="no"/><label>No</label>
		                            </td>
		                            <tr>
		                            	<td id="wpbooklist-editbook-date-finished-td" colspan="3">
		                            		<label for="book-date-finished-text"  id="book-date-finished-label">Date Finished: </label>
		                            		<input name="book-date-finished-text" type="date" id="wpbooklist-editbook-date-finished" />
		                            		<div id="wpbooklist-editbook-add-cancel-div">
		                            			<button type="button" id="wpbooklist-admin-editbook-button">Edit Book</button>
		                            			<button type="button" id="wpbooklist-admin-cancel-button">Cancel</button>
		                            		</div>
		                            		<div class="wpbooklist-spinner" id="wpbooklist-spinner-edit-indiv"></div>
		                            		<div id="wpbooklist-editbook-success-div" data-bookid="" data-booktable="">

		                            		</div>
		                            	</td>
		                            </tr>
		                        </tr>
		                    </tbody>
		                </table>
		            </div>
	        	</form>
	        	<div id="wpbooklist-add-book-error-check" data-add-book-form-error="true" style="display:none" data-></div>
    		</div>';

    		return $string1.$string2.$string3.$string4.$string5.$string6.$string7;
	}

	private function edit_book(){
		global $wpdb;
		// First do Amazon Authorization check
		if($this->amazon_auth_yes == 'true' && $this->use_amazon_yes == 'true'){
			$this->go_amazon === true;
			$this->gather_amazon_data();
			$this->gather_google_data();
			$this->gather_open_library_data();
			$this->gather_itunes_data();
			$this->create_wpbooklist_woocommerce_product();
			$this->create_author_first_last();
		} else {
			// If $this->go_amazon is false, query the other apis and add the provided data to database
			$this->go_amazon === false;
			$this->gather_google_data();
			$this->gather_open_library_data();
			$this->gather_itunes_data();
			$this->create_wpbooklist_woocommerce_product();
			$this->create_author_first_last();
		}

		$page = null;
		$post = null;
		if($this->page_yes || $this->post_yes){

			$page_post_array = array(
				'title' => $this->title, 
				'isbn' => $this->isbn,
				'author' => $this->author,
				'author_url' => $this->author_url,
				'price' => $this->price,
				'finished' => $this->finished,
				'date_finished' => $this->date_finished,
				'signed' => $this->signed,
				'first_edition' => $this->first_edition,
				'image' => $this->image,
				'pages' => $this->pages,
				'pub_year' => $this->pub_year,
				'publisher' => $this->publisher,
				'category' => $this->category,
				'description' => $this->description,
				'notes' => $this->notes,
				'rating' => $this->rating,
				'page_yes' => $this->page_yes,
				'post_yes' => $this->post_yes,
				'itunes_page' => $this->itunes_page,
				'google_preview' => $this->google_preview,
				'amazon_detail_page' => $this->amazon_detail_page,
				'review_iframe' => $this->review_iframe,
				'similar_products' => $this->similar_products,
				'book_uid' => $this->book_uid,
				'lendable' => $this->lendable,
		  		'copies' => $this->copies,
		  		'bn_link' => $this->bnbuylink,
				'bam_link' => $this->booksamillionbuylink,
				'kobo_link' => $this->kobobuylink
			);

			# Each of these class instantiations will return the ID of the page/post created for storage in DB
			$page = $this->page_id;
			$post = $this->post_id;
			if($this->page_yes == 'true' && ($this->page_id == 'false' || $this->page_id == 'true')){
				error_log('entered 2');
				require_once(CLASS_DIR.'class-page.php');
				$page = new WPBookList_Page($page_post_array);
				$page = $page->create_result;
			}

			if($this->post_yes == 'true' && ($this->post_id == 'false' || $this->post_id == 'true')){
				error_log('entered 3');
				require_once(CLASS_DIR.'class-post.php');
				$post = new WPBookList_Post($page_post_array);
				$post = $post->post_id;
			}
		}

		$data = array(
        	'title' => $this->title, 
			'isbn' => $this->isbn,
			'author' => $this->author,
			'author_url' => $this->author_url,
			'price' => $this->price,
			'finished' => $this->finished,
			'date_finished' => $this->date_finished,
			'signed' => $this->signed,
			'first_edition' => $this->first_edition,
			'image' => $this->image,
			'pages' => $this->pages,
			'pub_year' => $this->pub_year,
			'publisher' => $this->publisher,
			'category' => $this->category,
			'subject' => $this->subject,
			'country' => $this->country,
			'description' => $this->description,
			'notes' => $this->notes,
			'rating' => $this->rating,
			'page_yes' => $page,
			'post_yes' => $post,
			'itunes_page' => $this->itunes_page,
			'google_preview' => $this->google_preview,
			'amazon_detail_page' => $this->amazon_detail_page,
			'review_iframe' => $this->review_iframe,
			'similar_products' => $this->similar_products,
			'book_uid' => $this->book_uid,
			'lendable' => $this->lendable,
		  	'copies' => $this->copies,
		  	'woocommerce' => $this->wooid,
			'bn_link' => $this->bnbuylink,
			'bam_link' => $this->booksamillionbuylink,
			'kobo_link' => $this->kobobuylink,
			'authorfirst' => $this->finalauthorfirstnames,
		  	'authorlast' => $this->finalauthorlastnames
	    );

	    $format = array( '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%s','%s','%s','%s','%s','%s'); 
	    $where = array( 'ID' => $this->id );
	    $where_format = array( '%d' );
	    $result = $wpdb->update( $this->library, $data, $where, $format, $where_format );


		// Insert the Amazon Authorization into the DB if it's not already set to 'Yes'
		$table_name_options = $wpdb->prefix . 'wpbooklist_jre_user_options';
  		$this->options_results = $wpdb->get_row("SELECT * FROM $table_name_options");
  		if($this->options_results->amazonauth != 'true'){
			$data = array(
	        	'amazonauth' => $this->amazon_auth_yes
		    );
		    $format = array( '%s'); 
		    $where = array( 'ID' => 1 );
		    $where_format = array( '%d' );
		    $wpdb->update( $wpdb->prefix.'wpbooklist_jre_user_options', $data, $where, $format, $where_format );
		}

		$this->edit_result = $result;


	}

	public function empty_table($library){
		global $wpdb;
		$wpdb->query("TRUNCATE TABLE $library");

		// Drop table and re-create
		$row2 = $wpdb->get_results('SHOW CREATE TABLE '.$library);
		$wpdb->query("DROP TABLE $library");
		$wpdb->query($row2[0]->{'Create Table'});
		// Make sure auto_increment is set to 1
		$wpdb->query("ALTER TABLE $library AUTO_INCREMENT = 1");
		
	}

	public function empty_everything($library){
		global $wpdb;
		$results = $wpdb->get_results("SELECT * FROM $library");

		foreach($results as $result){
			wp_delete_post( $result->page_yes, true );
			wp_delete_post( $result->post_yes, true );
		}

		$wpdb->query("TRUNCATE TABLE $library");
	}

	public function delete_book($library, $book_id, $delete_string = null){
		global $wpdb;

		// Delete the associated post and page
		$post_delete = '';
		if($delete_string != null){
			$delete_array = explode('-', $delete_string);
			foreach($delete_array as $delete){
				$delete_result = wp_delete_post( $delete, true );

				if($delete_result){
					$d_result = 1;
				}
				
				$post_delete = $post_delete.'-'.$d_result;
			}
		}

		// Deleting book from saved_page_post_log
		$book_row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $library WHERE ID = %d",$book_id ));
		if(is_object($book_row)){
			$uid = $book_row->book_uid;
			$pp_table = $wpdb->prefix.'wpbooklist_jre_saved_page_post_log';
			$wpdb->delete( $pp_table, array( 'book_uid' => $uid ));
		}

		// Deleting the actual book row
		$book_delete = $wpdb->delete( $library, array( 'ID' => $book_id ) );

		// Dropping primary key in database to alter the IDs and the AUTO_INCREMENT value
		$wpdb->query("ALTER TABLE $library MODIFY ID BIGINT(190) NOT NULL");
		$wpdb->query("ALTER TABLE $library DROP PRIMARY KEY");

		// Adjusting ID values of remaining entries in database
		$title_count = $wpdb->get_var("SELECT COUNT(*) FROM $library");
		for ($x = $book_id; $x <= $title_count; $x++) {
			$data = array(
			    'ID' => $book_id
			);
			$format = array( '%d'); 
			$book_id++;  
			$where = array( 'ID' => ($book_id) );
			$where_format = array( '%d' );
			$wpdb->update( $library, $data, $where, $format, $where_format );
		}  

		// Adding primary key back to database 
		$wpdb->query("ALTER TABLE $library ADD PRIMARY KEY (`ID`)");    
		$wpdb->query("ALTER TABLE $library MODIFY ID BIGINT(190) AUTO_INCREMENT");

		// Setting the AUTO_INCREMENT value based on number of remaining entries
		$title_count++;
		$wpdb->query($wpdb->prepare( "ALTER TABLE $library AUTO_INCREMENT = %d", $title_count));

		return $book_delete.'-'.$post_delete;
		

		
	}

	public function refresh_amazon_review($id, $library){
		global $wpdb;

		// Build options table
		if(strpos($library, 'wpbooklist_jre_saved_book_log') !== false){
			$table_name_options = $wpdb->prefix . 'wpbooklist_jre_user_options';
		} else {
			$table = explode('wpbooklist_jre_', $library);
			$table_name_options = $wpdb->prefix . 'wpbooklist_jre_settings_'.$table[1];
		}

		// Get options for amazon affiliate id and hideamazonreview
		$this->options_results = $wpdb->get_row("SELECT * FROM $table_name_options");

		// Get book by id
		$this->get_book_by_id($id, $library);

		// Set isbn for gather Amazon data function
		$this->isbn = $this->retrieved_book->isbn;

		// Check and see if Amazon review URL is expired. If so, make a new api call, get URL, saved in DB.
		if($this->options_results->hideamazonreview == null || $this->options_results->hideamazonreview == 0){
			parse_str($this->retrieved_book->review_iframe, $output);
			if($output != null && $output != '' && isset($output['exp'])){
				$expire_date = substr($output['exp'], 0, 10);
				$today_date = date("Y-m-d");

				if($today_date == $expire_date || $today_date > $expire_date){

					$this->isbn = $this->retrieved_book->isbn;
					$this->title = $this->retrieved_book->title;

					// Gather Amazon data
					$this->gather_amazon_data();

					// Save new iframe url
					$data = array(
					  'review_iframe' => $this->review_iframe
					);
					$format = array( '%s'); 
					$where = array( 'ID' => $this->retrieved_book->ID );
					$where_format = array( '%d' );
					$wpdb->update( $library, $data, $where, $format, $where_format );
				}
			}
		}
	}

	private function get_book_by_id($id, $library){
		global $wpdb;
		$this->retrieved_book = $wpdb->get_row($wpdb->prepare("SELECT * FROM $library WHERE ID = %d", $id));
	}



}

endif;