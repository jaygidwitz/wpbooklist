<?php

$string1 = '';
$string2 = '';
$string3 = '';
$string4 = '';
$string5 = '';
$string6 = '';
$string7 = '';
$string8 = '';
$string9 = '';
$string10 = '';
$string11 = '';
$string12 = '';
$string13 = '';
$string14 = '';
$string15 = '';
$string16 = '';
$string17 = '';
$string18 = '';
$string19 = '';
$string20 = '';
$string21 = '';
$string22 = '';
$string23 = '';
$string24 = '';
$string25 = '';
$string26 = '';
$string27 = '';
$string28 = '';
$string29 = '';
$string30 = '';
$string31 = '';
$string32 = '';
$string33 = '';
$string34 = '';
$string35 = '';
$string36 = '';
$string37 = '';
$string38 = '';
$string39 = '';
$string40 = '';
$string41 = '';
$string42 = '';
$string43 = '';
$string44 = '';
$string45 = '';
$string46 = '';
$string47 = '';
$string48 = '';
$string49 = '';
$string50 = '';
$string51 = '';

$string1 =  '<div id="wpbl-posttd-top-container">
	<div id="wpbl-posttd-left-row">
		<div id="wpbl-posttd-image">';
			if($options_post_row->hidebookimage == null || $options_post_row->hidebookimage == 0){ 

				if($book_row->image == null){
							$string2 =  '<img id="wpbl-posttd-img" src="'.ROOT_IMG_URL.'image_unavaliable.png"/>';
				} else {
							$string2 =  '<img id="wpbl-posttd-img" src="'.$book_row->image.'"/>';
				} 
			}


		$string3 =  '</div>
		<div id="wpbl-posttd-details-div">';

			if(($options_post_row->hiderating == null) && ($book_row->rating != 0)){ 

				if($book_row->rating == 5){
				    $string4 =  '<img id="wpbl-posttd-rating-img" src="'.ROOT_IMG_URL.'5star.png'.'" />';
				}    

				if($book_row->rating == 4){
				    $string4 =  '<img id="wpbl-posttd-rating-img" src="'.ROOT_IMG_URL.'4star.png'.'" />';
				}    

				if($book_row->rating == 3){
				    $string4 =  '<img id="wpbl-posttd-rating-img" src="'.ROOT_IMG_URL.'3star.png'.'" />';
				}    

				if($book_row->rating == 2){
				    $string4 =  '<img id="wpbl-posttd-rating-img" src="'.ROOT_IMG_URL.'2star.png'.'" />';
				}    

				if($book_row->rating == 1){
				    $string4 =  '<img id="wpbl-posttd-rating-img" src="'.ROOT_IMG_URL.'1star.png'.'" />';
				}    
			} 

			if(($options_post_row->hidefacebook == null || $options_post_row->hidefacebook == 0) || ($options_post_row->hidetwitter == null || $options_post_row->hidetwitter == 0) || ($options_post_row->hidegoogleplus == null || $options_post_row->hidegoogleplus == 0) || ($options_post_row->hidemessenger == null || $options_post_row->hidemessenger == 0) || ($options_post_row->hidepinterest == null || $options_post_row->hidepinterest == 0) || ($options_post_row->hideemail == null || $options_post_row->hideemail == 0)){ 

			    $string5 =  '<div><p class="wpbl-posttd-share-text">'.__('Share This Book','wpbooklist').'</p>';

			    if($options_post_row->hidefacebook == null || $options_post_row->hidefacebook == 0){
			    	$string6 =  '<div class="addthis_sharing_toolbox addthis_default_style" style="cursor:pointer"><a style="cursor:pointer;" href="" addthis:title="'.$book_row->title.'" addthis:description="'.htmlspecialchars(addslashes($book_row->description)).'"addthis:url="'.$book_row->amazon_detail_page.'" class="addthis_button_facebook"></a></div>';
				}

				if($options_post_row->hidetwitter == null || $options_post_row->hidetwitter == 0){
			    	$string7 =  '<div class="addthis_sharing_toolbox addthis_default_style" style="cursor:pointer"><a style="cursor:pointer;" href="" addthis:title="'.$book_row->title.'" addthis:description="'.htmlspecialchars(addslashes($book_row->description)).'"addthis:url="'.$book_row->amazon_detail_page.'" class="addthis_button_twitter"></a></div>';
				}

				if($options_post_row->hidegoogleplus == null || $options_post_row->hidegoogleplus == 0){
			    	$string8 =  '<div class="addthis_sharing_toolbox addthis_default_style" style="cursor:pointer"><a style="cursor:pointer;" href="" addthis:title="'.$book_row->title.'" addthis:description="'.htmlspecialchars(addslashes($book_row->description)).'"addthis:url="'.$book_row->amazon_detail_page.'" class="addthis_button_google_plusone_share"></a></div>';
				}

				if($options_post_row->hidemessenger == null || $options_post_row->hidemessenger == 0){
			    	$string9 =  '<div class="addthis_sharing_toolbox addthis_default_style" style="cursor:pointer"><a style="cursor:pointer;" href="" addthis:title="'.$book_row->title.'" addthis:description="'.htmlspecialchars(addslashes($book_row->description)).'"addthis:url="'.$book_row->amazon_detail_page.'" class="addthis_button_messenger"></a></div>';
				}

				if($options_post_row->hidepinterest == null || $options_post_row->hidepinterest == 0){
                	$string10 =  '<div class="addthis_sharing_toolbox addthis_default_style" style="cursor:pointer"><a style="cursor:pointer;" href="" addthis:title="'.$book_row->title.'" addthis:description="'.htmlspecialchars(addslashes($book_row->description)).'"addthis:url="'.$book_row->amazon_detail_page.'" class="addthis_button_pinterest_share"></a></div>';
				}

				if($options_post_row->hideemail == null || $options_post_row->hideemail == 0){
			    	$string11 =  '<div class="addthis_sharing_toolbox addthis_default_style" style="cursor:pointer"><a style="cursor:pointer;" href="" addthis:title="'.$book_row->title.'" addthis:description="'.htmlspecialchars(addslashes($book_row->description)).'"addthis:url="'.$book_row->amazon_detail_page.'" class="addthis_button_gmail"></a></div>';
				}

				$string12 =  '</div>';
			} 

			if($options_post_row->hidesimilar != 1 && $similar_string != '<span id="wpbooklist-page-span-hidden" style="display:none;"></span>'){
				$string13 =  '<div id="wpbl-similar-div"><p style="font-weight:bold; font-size:18px; margin-bottom:5px;" class="wpbl-posttd-share-text">'.__('Similar Titles','wpbooklist').'</p>'.$similar_string;
			}

			$kindle_array = array($book_row->isbn, $options_post_row->amazonaff);
			$isbn_test = preg_match("/[a-z]/i", $book_row->isbn);
			$string14 = '';
			if(($options_post_row->hidekindleprev == null || $options_post_row->hidekindleprev == 0) && $isbn_test){
				if(has_filter('wpbooklist_add_to_post_kindle')) {
					$string14 = apply_filters('wpbooklist_add_to_post_kindle', $kindle_array);
				}
			}

			if($options_post_row->hidegoogleprev == null || $options_post_row->hidegoogleprev == 0){
				if(has_filter('wpbooklist_add_to_post_google')) {
					$string14 = $string14.apply_filters('wpbooklist_add_to_post_google', $book_row->isbn);
				}
			}

			if($options_post_row->hidequote == null || $options_post_row->hidequote == 0){
				$string14 = $string14.'<div id="wpbl-posttd-post-quote">'.stripslashes($quote).'</div>';
			}
		$string15 =  '</div>
	</div>
	<div id="wpbl-posttd-right-row">';
		if($options_post_row->hidetitle == null || $options_post_row->hidetitle == 0){
			$string16 =  '<h3 id="wpbl-posttd-book-title">'.stripslashes($book_row->title).'</h3>';
		}
		$string17 =  '<div id="wpbl-posttd-book-details-div">';
			if($options_post_row->hideauthor == null || $options_post_row->hideauthor == 0){
				$string18 =  '<div id="wpbl-posttd-book-details-1">
						<span>'.__('Author:', 'wpbooklist').' </span> '.$book_row->author.'
					</div>';
			}

			if(($options_post_row->enablepurchase != null && $options_post_row->enablepurchase != 0) && $book_row->price != null && $book_row->author_url != null){
				$string19 =  '<div id="wpbl-posttd-book-details-9">
					<span>'.__('Price:','wpbooklist').' </span>'.$book_row->price;
				$string20 =  '</div>';
			}

			if($options_post_row->hidepages == null || $options_post_row->hidepages == 0){
				$string21 =  '<div id="wpbl-posttd-book-details-2">
					<span>'.__('Pages:','wpbooklist').' </span>'.$book_row->pages.'
				</div>';
			}

			if($options_post_row->hidecategory == null || $options_post_row->hidecategory == 0){
				$string22 =  '<div id="wpbl-posttd-book-details-3">
					<span>'.__('Category:','wpbooklist').' </span>'.$book_row->category.'
				</div>';
			}

			if($options_post_row->hidepublisher == null || $options_post_row->hidepublisher == 0){
				$string23 =  '<div id="wpbl-posttd-book-details-4">
					<span>'.__('Publisher:','wpbooklist').' </span>'.$book_row->publisher.'
				</div>';
			}

			if($options_post_row->hidesubject == null || $options_post_row->hidesubject == 0){
				$string50 =  '<div id="wpbl-posttd-book-details-4">
					<span>'.__('Subject:','wpbooklist').' </span>'.$book_row->subject.'
				</div>';
			}

			if($options_post_row->hidecountry == null || $options_post_row->hidecountry == 0){
				$string51 =  '<div id="wpbl-posttd-book-details-4">
					<span>'.__('Country:','wpbooklist').' </span>'.$book_row->country.'
				</div>';
			}

			if($options_post_row->hidepubdate == null || $options_post_row->hidepubdate == 0){
				$string24 =  '<div id="wpbl-posttd-book-details-5">
					<span>'.__('Publication Date:','wpbooklist').' </span>'.$book_row->pub_year.'
				</div>';
			}

			if($options_post_row->hidefinished == null || $options_post_row->hidefinished == 0){
				if($book_row->finished != false && $book_row->finished != 'false'){
					$string25 =  '<div id="wpbl-posttd-book-details-6">
						<span>'.__('Finished?','wpbooklist').'</span> '.__('Yes', 'wpbooklist');

					if($book_row->date_finished != 'undefined-undefined-'){ 
						$string26 =  ', on '.$book_row->date_finished; 
					}
					
					$string27 =  '</div>';
				} else {
					$string25 =  '<div id="wpbl-posttd-book-details-6">
						<span>'.__('Finished?','wpbooklist').'</span> '.__('No', 'wpbooklist');
					$string27 =  '</div>';
				}
			}

			if($options_post_row->hidesigned == null || $options_post_row->hidesigned == 0){
				$string28 =  '<div id="wpbl-posttd-book-details-7">
					<span>'.__('Signed?','wpbooklist').'</span>'; 
				if($book_row->signed == 'false'){
					$string29 =  __(' No','wpbooklist'); 
				} else {
					$string29 =   __(' Yes','wpbooklist'); 
				}

				$string30 =  '</div>';
			}

			if($options_post_row->hidefirstedition == null || $options_post_row->hidefirstedition == 0){
				$string31 =  '<div id="wpbl-posttd-book-details-8">
				<span>'.__('First Edition?', 'wpbooklist').'</span>';
				if($book_row->first_edition == 'false'){ 
					$string32 =  __(' No','wpbooklist'); 
				} else { 
					$string32 =  __(' Yes','wpbooklist');
				}
				$string33 =  '</div>';
			}
		$string34 = '</div>';

		if(($options_post_row->enablepurchase != null && $options_post_row->enablepurchase != 0) && $book_row->price != null && $book_row->author_url != null){ 

			  if(has_filter('wpbooklist_add_storefront_calltoaction_post')) {
			    $string35 =  $var = apply_filters('wpbooklist_add_storefront_calltoaction_post', $book_row->author_url);
			  }

		}

		if(($options_post_row->hideamazonpurchase == null || $options_post_row->hideamazonpurchase == 0) || ($options_post_row->hidebnpurchase == null || $options_post_row->hidebnpurchase == 0) || ($options_post_row->hidegooglepurchase == null || $options_post_row->hidegooglepurchase == 0) || ($options_post_row->hideitunespurchase == null || $options_post_row->hideitunespurchase == 0) || (($options_post_row->enablepurchase != null && $options_post_row->enablepurchase != 0) && $book_row->price != null && $book_row->author_url != null) ){ 
			$string36 =  '<div id="wpbl-posttd-top-purchase-div">
				<h4 id="wpbl-posttd-purchase-title">'.__('Purchase this title at:','wpbooklist').' </h4>
				<div id="wpbl-posttd-line-under-purchase"></div>';
				if (($book_row->amazon_detail_page != null) && ($options_post_row->hideamazonpurchase == null || $options_post_row->hideamazonpurchase == 0 )){

					if(preg_match("/[a-z]/i", $book_row->isbn)){
						$string37 =  '<a class="wpbl-posttd-wpbooklist-purchase-img" href="'.$book_row->amazon_detail_page.'" target="_blank"><img src="'.ROOT_IMG_URL.'kindle.png" /></a>';
					} else {
						$string37 =  '<a class="wpbl-posttd-wpbooklist-purchase-img" href="'.$book_row->amazon_detail_page.'" target="_blank"><img src="'.ROOT_IMG_URL.'amazon.png" /></a>';
					}
				}

				if($book_row->bn_link == null || $book_row->bn_link == ''){
					$book_row->bn_link = 'http://www.barnesandnoble.com/s/'.$book_row->isbn;
				}

				if (($book_row->isbn != null) && ($options_post_row->hidebnpurchase == null || $options_post_row->hidebnpurchase == 0 )){
					$string38 =  '<a class="wpbl-posttd-wpbooklist-purchase-img" href="'.$book_row->bn_link.'" target="_blank"><img src="'.ROOT_IMG_URL.'bn.png" /></a>';
				}

				if (($book_row->google_preview != null) && ($options_post_row->hidegooglepurchase == null || $options_post_row->hidegooglepurchase == 0 )){
					$string39 =  '<a class="wpbl-posttd-wpbooklist-purchase-img" href="'.$book_row->google_preview.'" target="_blank"><img src="'.ROOT_IMG_URL.'googlebooks.png" /></a>';
				}

				if (($book_row->itunes_page != null) && ($options_post_row->hideitunespurchase == null || $options_post_row->hideitunespurchase == 0 )){
					$string40 =  '<a class="wpbl-posttd-wpbooklist-purchase-img" href="'.$book_row->itunes_page.'" target="_blank"><img id="wpbl-posttd-itunes-img" src="'.ROOT_IMG_URL.'ibooks.png" /></a>';
				}

				if (($book_row->bam_link != null) && ($options_post_row->hidebampurchase == null || $options_post_row->hidebampurchase == 0 )){
					$string48 =  '<a class="wpbl-posttd-wpbooklist-purchase-img" href="'.$book_row->bam_link.'" target="_blank"><img src="'.ROOT_IMG_URL.'bam-icon.jpg" /></a>';
				}

				if (($book_row->kobo_link != null) && ($options_post_row->hidekobopurchase == null || $options_post_row->hidekobopurchase == 0 )){
					$string49 =  '<a class="wpbl-posttd-wpbooklist-purchase-img" href="'.$book_row->kobo_link.'" target="_blank"><img id="wpbl-posttd-itunes-img" src="'.ROOT_IMG_URL.'kobo-icon.png" /></a>';
				}

				if(($options_post_row->enablepurchase != null && $options_post_row->enablepurchase != 0) && ($book_row->author_url != null)){
					if(has_filter('wpbooklist_add_storefront_bookimg_post')) {
					    $string41 =  $var = apply_filters('wpbooklist_add_storefront_bookimg_post', $book_row->author_url);
					}
				}
			$string42 = '</div>';
		} 
		if(($options_post_row->hidedescription == null || $options_post_row->hidedescription == 0) && $book_row->description != null){
			$string43 =  '<div id="wpbl-posttd-book-description-div">
				<h5 id="wpbl-posttd-book-description-h5">'.__('Description','wpbooklist').'</h5>
				<div id="wpbl-posttd-book-description-contents">'.html_entity_decode(stripslashes($book_row->description)).'</div>
			</div>';
		}
		if(($options_post_row->hidenotes == null || $options_post_row->hidenotes == 0) && $book_row->notes != null){
		$string44 =  '<div id="wpbl-posttd-book-notes-div">
			<h5 id="wpbl-posttd-book-notes-h5">'.__('Notes','wpbooklist').'</h5>
			<div id="wpbl-posttd-book-notes-contents">'.html_entity_decode(stripslashes($book_row->notes)) .'</div>
		</div>';
		} 
		if(($options_post_row->hideamazonreview == null || $options_post_row->hideamazonreview == 0) && $book_row->review_iframe != null){
		$string45 =  '<div id="wpbl-posttd-book-amazon-review-div">
			<h5 id="wpbl-posttd-book-amazon-review-h5">'.__('Amazon Reviews','wpbooklist').'</h5>
			<iframe id="wpbl-posttd-book-amazon-review-contents" src="'.$book_row->review_iframe.'"></iframe>
		</div>';
		} 

		$append_string = '';
		if(has_filter('wpbooklist_append_to_default_post_template_right_column')) {
			$append_string = apply_filters('wpbooklist_append_to_default_post_template_right_column', $append_string);
		}
		$string46 =  $append_string;


	$string47 = '</div>

</div>';


