<?php



// Function for adding a book 
function wpbooklist_dashboard_add_book_action_javascript() { 
	$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );

	// Translations
	$trans1 = __('Success!', 'wpbooklist');
	$trans2 = __("You've just added a new book to your library! Remember, to display your library, simply place this shortcode on a page or post:", 'wpbooklist');
	$trans3 = __("Click Here to View Your New Book", 'wpbooklist');
	$trans4 = __("Click Here to View This Book's Post", 'wpbooklist');
	$trans5 = __("Click Here to View This Book's Page", 'wpbooklist');
	$trans6 = __("Thanks for using WPBookList, and", 'wpbooklist');
	$trans7 = __("be sure to check out the WPBookList Extensions!", 'wpbooklist');
	$trans8 = __("If you happen to be thrilled with WPBookList, then by all means,", 'wpbooklist');
	$trans9 = __("Feel Free to Leave a 5-Star Review Here!", 'wpbooklist');
	$trans10 = __("Whoops! Looks like there was an error trying to add your book! Here is some developer/code info you might provide to", 'wpbooklist');
	$trans11 = __("WPBookList Tech Support at TechSupport@WPBookList.com:", 'wpbooklist');
	$trans12 = __('Hmmm...', 'wpbooklist');
	$trans13 = __("Your book was added, but it looks like there was a problem grabbing book info from Amazon. Try manually entering your book information, or wait a few seconds and try again, as sometimes Amazon gets confused. Remember, you don't", 'wpbooklist');
	$trans14 = __("HAVE", 'wpbooklist');
	$trans15 = __("to gather info from Amazon - WPBookList can work completely independently of Amazon.", 'wpbooklist');



	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		// For the book cover image upload
		var file_frame;
		var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
		var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this
		jQuery('#wpbooklist-addbook-upload_image_button, #wpbooklist-storefront-img-button-1, #wpbooklist-storefront-img-button-2, #wpbooklist-branding-img-button-1, #wpbooklist-branding-img-button-2').on('click', function( event ){
		var buttonid = $(this).attr('id');
		$(this).attr('data-active', true);
		console.log(buttonid);
		event.preventDefault();
		// If the media frame already exists, reopen it.
		if ( file_frame ) {
			// Set the post ID to what we want
			file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
			// Open frame
			file_frame.open();
			return;
		} else {
			// Set the wp.media post id so the uploader grabs the ID we want when initialised
			wp.media.model.settings.post.id = set_to_post_id;
		}
		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select a image to upload',
			button: {
			text: 'Use this image',
			},
			multiple: false // Set to true to allow multiple files to be selected
		});
		console.log(buttonid);
		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			var attachment = file_frame.state().get('selection').first().toJSON();
			// Do something with attachment.id and/or attachment.url here

			// Add preview image to dom
			if($('#wpbooklist-addbook-upload_image_button').attr('data-active') == 'true'){
				$( '#wpbooklist-addbook-image' ).val(attachment.url);
				$( '#wpbooklist-addbook-preview-img' ).attr('src', attachment.url);
				$('#wpbooklist-addbook-preview-img').attr('data-active', false);
			}

			// Add preview image to dom for branding extension
			if($('#wpbooklist-branding-img-button-1').attr('data-active') == 'true'){
				$( '#wpbooklist-branding-image-url-1' ).val(attachment.url);
				$( '#wpbooklist-branding-preview-img-1' ).attr('src', attachment.url);
				$('#wpbooklist-branding-img-button-1').attr('data-active', false);
			}

			// Add second preview image to dom for branding extension
			if($('#wpbooklist-branding-img-button-2').attr('data-active') == 'true'){
				$( '#wpbooklist-branding-image-url-2' ).val(attachment.url);
				$( '#wpbooklist-branding-preview-img-2' ).attr('src', attachment.url);
				$('#wpbooklist-branding-img-button-2').attr('data-active', false);
			}


			// Add preview image to dom for storefront extension
			if($('#wpbooklist-storefront-img-button-1').attr('data-active') == 'true'){
				$( '#wpbooklist-branding-image-url-2' ).val(attachment.url);
				$( '#wpbooklist-storefront-preview-img-1' ).attr('src', attachment.url);
				$('#wpbooklist-storefront-img-button-1').attr('data-active', false);
			}

			// Add second preview image to dom for storefront extension
			if($('#wpbooklist-storefront-img-button-2').attr('data-active') == 'true'){
				$( '#wpbooklist-storefront-preview-img-2' ).attr('src', attachment.url);
				$('#wpbooklist-storefront-img-button-2').attr('data-active', false);
			}

			// Restore the main post ID
			wp.media.model.settings.post.id = wp_media_post_id;
		});
			// Finally, open the modal
			file_frame.open();
		});
		// Restore the main ID when the add media button is pressed
		jQuery( 'a.add_media' ).on( 'click', function() {
			wp.media.model.settings.post.id = wp_media_post_id;
		});

		// When the Add A Book form submits
	  	$("#wpbooklist-admin-addbook-button").click(function(event){
	  		var successDiv = $('#wpbooklist-addbook-success-div');
	  		successDiv.html('');
	  		$('#wpbooklist-addbook-signed-first-table').animate({'margin-bottom':'40px'}, 500);
			$('#wpbooklist-success-view-post').animate({'opacity':'0'}, 500);

	  		event.preventDefault(event);
    		wpbooklist_add_book_validator();
    		var error = $('#wpbooklist-add-book-error-check').attr('data-add-book-form-error');

    		var woocommerce = false;
    		var woofile = '';
    		var amazonAuthYes = $( "input[name='authorize-amazon-yes']" ).prop('checked');
			var library = $('#wpbooklist-addbook-select-library').val();
			var useAmazonYes = $("input[name='use-amazon-yes']").prop('checked');
			var isbn = $( "input[name='book-isbn']" ).val();
			var title = $( "input[name='book-title']" ).val();
			var author = $( "input[name='book-author']" ).val();
			var authorUrl = $( "input[name='book-sale-author-link']" ).val();
			var category = $( "input[name='book-category']" ).val();
			var price = $( "input[name='book-price']" ).val();
			var pages = $( "input[name='book-pages']" ).val();
			var pubYear = $( "input[name='book-pubdate']" ).val();
			var publisher = $( "input[name='book-publisher']" ).val();
			var description = $( "textarea[name='book-description']" ).val();
			var subject = $( "input[name='book-subject']" ).val();
			var country = $( "input[name='book-country']" ).val();
			var notes = $( "textarea[name='book-notes']" ).val();
			var rating = $('#wpbooklist-addbook-rating').val();
			var image = $("input[name='book-image']").val();
			var finished = $("input[name='book-finished-yes']").prop('checked');
			var dateFinished = $("input[name='book-date-finished-text']").val();
			var signed = $("input[name='book-signed-yes']").prop('checked');
			var firstEdition = $("input[name='book-firstedition-yes']").prop('checked');
			var pageYes = $("input[name='book-indiv-page-yes']").prop('checked');
			var postYes = $("input[name='book-indiv-post-yes']").prop('checked');
			var swapYes = $("input[name='book-bookswapper-yes']").prop('checked');
			var copies = $("input[name='book-lend-copies']").val();
			var woocommerce = $("input[name='book-woocommerce-yes']").prop('checked');
			var salePrice = $( "input[name='book-woo-sale-price']" ).val();
			var regularPrice = $( "input[name='book-woo-regular-price']" ).val();
			var stock = $( "input[name='book-woo-stock']" ).val();
			var length = $( "input[name='book-woo-length']" ).val();
			var width = $( "input[name='book-woo-width']" ).val();
			var height = $( "input[name='book-woo-height']" ).val();
			var weight = $( "input[name='book-woo-weight']" ).val();
			var sku = $("#wpbooklist-addbook-woo-sku" ).val();
			var virtual = $("input[name='wpbooklist-woocommerce-vert-yes']").prop('checked');
			var download = $("input[name='wpbooklist-woocommerce-download-yes']").prop('checked');
			var woofile = $('#wpbooklist-storefront-preview-img-1').attr('data-id');
			var salebegin = $('#wpbooklist-addbook-woo-salebegin').val();
			var saleend = $('#wpbooklist-addbook-woo-saleend').val();
			var purchasenote = $('#wpbooklist-addbook-woo-note').val();
			var productcategory = $('#wpbooklist-woocommerce-category-select').val();
			var reviews = $('#wpbooklist-woocommerce-review-yes').prop('checked');
			var upsells = $('#select2-upsells').val();
			var crosssells = $('#select2-crosssells').val();

			var upsellString = '';
			var crosssellString = '';

			// Making checks to see if Storefront extension is active
			if(upsells != undefined){
				for (var i = 0; i < upsells.length; i++) {
					upsellString = upsellString+','+upsells[i];
				};
			}

			if(crosssells != undefined){
				for (var i = 0; i < crosssells.length; i++) {
					crosssellString = crosssellString+','+crosssells[i];
				};
			}

			if(salebegin != undefined && saleend != undefined){
				// Flipping the sale date start
				if(salebegin.indexOf('-')){
					var finishedtemp = salebegin.split('-');
					salebegin = finishedtemp[0]+'-'+finishedtemp[1]+'-'+finishedtemp[2]
				}

				// Flipping the sale date end
				if(saleend.indexOf('-')){
					var finishedtemp = saleend.split('-');
					saleend = finishedtemp[0]+'-'+finishedtemp[1]+'-'+finishedtemp[2]
				}	
			}


			// Flipping the date
			if(dateFinished.indexOf('-')){
				var finishedtemp = dateFinished.split('-');
				dateFinished = finishedtemp[1]+'-'+finishedtemp[2]+'-'+finishedtemp[0]
			}

			

    		if(error === 'false'){
    			// Show working spinner
    			$('#wpbooklist-spinner-1').animate({'opacity':'1'}, 500);
    			
	    		var data = {
					'action': 'wpbooklist_dashboard_add_book_action',
					'security': '<?php echo wp_create_nonce( "wpbooklist_dashboard_add_book_action_callback" ); ?>',
					'amazonAuthYes':amazonAuthYes,
					'library':library,
					'useAmazonYes':useAmazonYes,
					'isbn':isbn,
					'title':title,
					'author':author,
					'authorUrl':authorUrl,
					'category':category,
					'price':price,
					'pages':pages,
					'pubYear':pubYear,
					'publisher':publisher,
					'description':description,
					'subject':subject,
					'country':country,
					'notes':notes,
					'rating':rating,
					'image':image,
					'finished':finished,
					'dateFinished':dateFinished,
					'signed':signed,
					'firstEdition':firstEdition,
					'pageYes':pageYes,
					'postYes':postYes,
					'swapYes':swapYes,
					'copies':copies,
					'woocommerce':woocommerce,
					'saleprice':salePrice,
					'regularprice':regularPrice,
					'stock':stock,
					'length':length,
					'width':width,
					'height':height,
					'weight':weight,
					'sku':sku,
					'virtual':virtual,
					'download':download,
					'woofile':woofile,
					'salebegin':salebegin,
					'saleend':saleend,
					'purchasenote':purchasenote,
					'productcategory':productcategory,
					'reviews':reviews,
					'upsells':upsellString,
					'crosssells':crosssellString
				};
				console.log("Here's the data that is being sent to the server to add a book:")
				console.log(data)

		     	var request = $.ajax({
				    url: ajaxurl,
				    type: "POST",
				    data:data,
				    timeout: 0,
				    success: function(response) {

				    	// Split up the reponse, set up some variables based on reposne, display messages to user

				    	response = response.split('--sep--');
				    	console.log(response);
				    	if(response[0] == 1){

				    		var apicallreport = response[7];
					    	var whichapifound = JSON.parse(response[8]);
					    	var amazonapifailcount = response[9];

					    	console.log(apicallreport)
					    	console.log("Here's the report for where the this book's data was obtained from:");
					    	console.log(whichapifound)
					    	console.log('The Amazon Fail Count was: '+amazonapifailcount);

				    		 

				    		if(useAmazonYes){
				    			if(amazonapifailcount == 2 || amazonapifailcount == '2'){
				    				var addBookSuccess1 = "<p><span id='wpbooklist-add-book-success-span'><?php echo $trans12; ?></span><br/> <?php echo $trans13; ?><em> <?php echo $trans14; ?> </em><?php echo $trans15; ?>";
					    		} else {
					    			var addBookSuccess1 = "<p><span id='wpbooklist-add-book-success-span'><?php echo $trans1; ?></span><br/> <?php echo $trans2; ?> <span id='wpbooklist-addbook-success-shortcode'>";
					    		}
				    		} else {
				    			var addBookSuccess1 = "<p><span id='wpbooklist-add-book-success-span'><?php echo $trans1; ?></span><br/> <?php echo $trans2; ?> <span id='wpbooklist-addbook-success-shortcode'>"; 
				    		}

				    		

				    		if(library.includes('wpbooklist_jre_saved_book_log')){
				    			var shortcode = '[wpbooklist_shortcode]'
				    		} else {
				    			library = library.split('_');
				    			library = library[library.length-1];
				    			var shortcode = '[wpbooklist_shortcode table="'+library+'"]'
				    		}

				    		if(useAmazonYes){
				    			if(amazonapifailcount == 2 || amazonapifailcount == '2'){
				    				var addBookSuccess2 = '</span></p><a id="wpbooklist-success-1" class="wpbooklist-show-book-colorbox"><?php echo $trans3; ?></a>';
					    		} else {
					    			var addBookSuccess2 = shortcode+'</span></p><a id="wpbooklist-success-1" class="wpbooklist-show-book-colorbox"><?php echo $trans3; ?></a>';
					    		}
				    		} else {
				    			var addBookSuccess2 = shortcode+'</span></p><a id="wpbooklist-success-1" class="wpbooklist-show-book-colorbox"><?php echo $trans3; ?></a>';
				    		}
				    		
				    		

				    		var addBookSuccess3 = '';

				    		// If book addition was succesful and user chose to create a post
				    		if(response[4] == 'true' && response[3] == 'false'){
				    			var addBookSuccess3 = "<p id='wpbooklist-addbook-success-post-p'><a href='"+response[6]+"'><?php echo $trans4; ?></a></p></div>";
				    			$('#wpbooklist-addbook-signed-first-table').animate({'margin-bottom':'70px'}, 500);
				    			$('#wpbooklist-success-view-post').animate({'opacity':'1'}, 500);
				    		} 

				    		// If book addition was succesful and user chose to create a page
				    		if(response[3] == 'true' && response[4] == 'false'){
				    			var addBookSuccess3 = "<p id='wpbooklist-addbook-success-page-p'><a href='"+response[5]+"'><?php echo $trans5; ?></a></p></div>";
				    			$('#wpbooklist-addbook-signed-first-table').animate({'margin-bottom':'70px'}, 500);
				    			$('#wpbooklist-success-view-page').animate({'opacity':'1'}, 500);
				    		} 

				    		// If book addition was succesful and user chose to create a post and a page
				    		if(response[3] == 'true' && response[4] == 'true'){
				    			var addBookSuccess3 = "<p id='wpbooklist-addbook-success-page-p'><a href='"+response[5]+"'><?php echo $trans5; ?></a></p><p id='wpbooklist-addbook-success-post-p'><a href='"+response[6]+"'><?php echo $trans4; ?></a></p></div>";
				    			$('#wpbooklist-addbook-signed-first-table').animate({'margin-bottom':'100px'}, 500);
				    			$('#wpbooklist-success-view-page').animate({'opacity':'1'}, 500);
				    			$('#wpbooklist-success-view-post').animate({'opacity':'1'}, 500);
				    		} 

				    		// Add response message to DOM
				    		var endMessage = '<div id="wpbooklist-addbook-success-thanks"><?php echo $trans6; ?> <a href="http://wpbooklist.com/index.php/extensions/">&nbsp;<?php echo $trans7; ?></a><br/><br/><?php echo $trans8; ?> <a id="wpbooklist-addbook-success-review-link" href="https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5" ><?php echo $trans9; ?></a><img id="wpbooklist-smile-icon-1" src="<?php echo ROOT_IMG_ICONS_URL; ?>smile.png"></div>';
				    		successDiv.html(addBookSuccess1+addBookSuccess2+addBookSuccess3+endMessage);

				    		$('#wpbooklist-spinner-1').animate({'opacity':'0'}, 500);
				    		$('#wpbooklist-success-1').animate({'opacity':'1'}, 500);
				    		$('#wpbooklist-success-1').attr('data-bookid', response[1]);
				    		$('#wpbooklist-success-1').attr('data-booktable', response[2]);
				    	} else {
				    		$('#wpbooklist-addbook-signed-first-table').animate({'margin-bottom':'65px'}, 500);
				    		successDiv.html('<?php echo $trans10; ?> <a href="mailto:techsupport@wpbooklist.com"><?php echo $trans11; ?></a><br/><br/>'+response[1]);
				    		$('#wpbooklist-spinner-1').animate({'opacity':'0'}, 500);
				    		$('#wpbooklist-success-1').animate({'opacity':'1'}, 500);
				    	}
				    },
					error: function(jqXHR, textStatus, errorThrown) {
						$('#wpbooklist-success-1').html('<?php echo $trans10; ?>');
			    		$('#wpbooklist-spinner-1').animate({'opacity':'0'}, 500);
			    		$('#wpbooklist-success-1').animate({'opacity':'1'}, 500);
						console.log(errorThrown);
			            console.log(textStatus);
			            console.log(jqXHR);
			            // TODO: Log the console errors here
					}
				});
	     	}

	     	event.preventDefault ? event.preventDefault() : event.returnValue = false;

	  	});
	});
	</script>
	<?php
}

// Callback function for adding a book 
function wpbooklist_dashboard_add_book_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_dashboard_add_book_action_callback', 'security' );

	// First set the variables we'll be passing to class-book.php to ''
	$amazon_auth_yes = '';
	$library = '';
	$use_amazon_yes = '';
	$isbn = '';
	$title = '';
	$author = '';
	$author_url = '';
	$category = '';
	$price = '';
	$pages = '';
	$pub_year = '';
	$publisher = '';
	$description = '';
	$subject = '';
	$country = '';
	$notes = '';
	$rating = '';
	$image = '';
	$finished = '';
	$date_finished = '';
	$signed = '';
	$first_edition = '';
	$page_yes = '';
	$post_yes = '';
	$swap_yes = '';
	$copies = '';
	$woocommerce = '';
	$saleprice = '';
	$regularprice = '';
	$stock = '';
	$length = '';
	$width = '';
	$height = '';
	$weight = '';
	$sku = '';
	$virtual = '';
	$download = '';
	$woofile = '';
	$salebegin = '';
	$saleend = '';
	$purchasenote = '';
	$productcategory = '';
	$reviews = '';
	$crosssells = '';
	$upsells = '';








	if(isset($_POST['amazonAuthYes'])){
		$amazon_auth_yes = filter_var($_POST['amazonAuthYes'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['library'])){
		$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['useAmazonYes'])){
		$use_amazon_yes = filter_var($_POST['useAmazonYes'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['isbn'])){
		$isbn = filter_var($_POST['isbn'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['title'])){
		$title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['author'])){
		$author = filter_var($_POST['author'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['authorUrl'])){
		$author_url = filter_var($_POST['authorUrl'],FILTER_SANITIZE_URL);
	}

	if(isset($_POST['category'])){
		$category = filter_var($_POST['category'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['price'])){
		$price = filter_var($_POST['price'],FILTER_SANITIZE_STRING);
	}	

	if(isset($_POST['pages'])){
		$pages = filter_var($_POST['pages'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['pubYear'])){
		$pub_year = filter_var($_POST['pubYear'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['publisher'])){
		$publisher = filter_var($_POST['publisher'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['description'])){
		$description = filter_var(htmlentities($_POST['description']),FILTER_SANITIZE_STRING);
	}	

	if(isset($_POST['subject'])){
		$subject = filter_var($_POST['subject'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['country'])){
		$country = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['notes'])){
		$notes = filter_var(htmlentities($_POST['notes']),FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['rating'])){
		$rating = filter_var($_POST['rating'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['image'])){
		$image = filter_var($_POST['image'],FILTER_SANITIZE_URL);
	}

	if(isset($_POST['finished'])){
		$finished = filter_var($_POST['finished'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['dateFinished'])){
		$date_finished = filter_var($_POST['dateFinished'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['signed'])){
		$signed = filter_var($_POST['signed'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['firstEdition'])){
		$first_edition = filter_var($_POST['firstEdition'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['pageYes'])){
		$page_yes = filter_var($_POST['pageYes'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['postYes'])){
		$post_yes = filter_var($_POST['postYes'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['swapYes'])){
		$swap_yes = filter_var($_POST['swapYes'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['copies'])){
		$copies = filter_var($_POST['copies'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['woocommerce'])){
		$woocommerce = filter_var($_POST['woocommerce'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['saleprice'])){
		$saleprice = filter_var($_POST['saleprice'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['regularprice'])){
		$regularprice = filter_var($_POST['regularprice'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['stock'])){
		$stock = filter_var($_POST['stock'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['length'])){
		$length = filter_var($_POST['length'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['width'])){
		$width = filter_var($_POST['width'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['height'])){
		$height = filter_var($_POST['height'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['weight'])){
		$weight = filter_var($_POST['weight'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['sku'])){
		$sku = filter_var($_POST['sku'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['virtual'])){
		$virtual = filter_var($_POST['virtual'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['download'])){
		$download = filter_var($_POST['download'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['woofile'])){
		$woofile = filter_var($_POST['woofile'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['salebegin'])){
		$salebegin = filter_var($_POST['salebegin'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['saleend'])){
		$saleend = filter_var($_POST['saleend'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['purchasenote'])){
		$purchasenote = filter_var($_POST['purchasenote'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['productcategory'])){
		$productcategory = filter_var($_POST['productcategory'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['reviews'])){
		$reviews = filter_var($_POST['reviews'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['crosssells'])){
		$crosssells = filter_var($_POST['crosssells'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['upsells'])){
		$upsells = filter_var($_POST['upsells'],FILTER_SANITIZE_STRING);
	}


	$book_array = array(
		'amazon_auth_yes' => $amazon_auth_yes,
		'library' => $library,
		'use_amazon_yes' => $use_amazon_yes,
		'isbn' => $isbn,
		'title' => $title,
		'author' => $author,
		'author_url' => $author_url,
		'category' => $category,
		'price' => $price,
		'pages' => $pages,
		'pub_year' => $pub_year,
		'publisher' => $publisher,
		'description' => $description,
		'subject' => $subject,
		'country' => $country,
		'notes' => $notes,
		'rating' => $rating,
		'image' => $image,
		'finished' => $finished,
		'date_finished' => $date_finished,
		'signed' => $signed,
		'first_edition' => $first_edition,
		'page_yes' => $page_yes,
		'post_yes' => $post_yes,
		'swap_yes' => $swap_yes,
		'copies' => $copies,
		'woocommerce' => $woocommerce,
		'saleprice' => $saleprice,
		'regularprice' => $regularprice,
		'stock' => $stock,
		'length' => $length,
		'width' => $width,
		'height' => $height,
		'weight' => $weight,
		'sku' => $sku,
		'virtual' => $virtual,
		'download' => $download,
		'woofile' => $woofile,
		'salebegin' => $salebegin,
		'saleend' => $saleend,
		'purchasenote' => $purchasenote,
		'productcategory' => $productcategory,
		'reviews' => $reviews,
		'crosssells' => $crosssells,
		'upsells' => $upsells,
	);

	require_once(CLASS_DIR.'class-book.php');
	$book_class = new WPBookList_Book('add', $book_array, null);
	$insert_result = explode(',',$book_class->add_result);
	// If book added succesfully, get the ID of the book we just inserted, and return the result and that ID
	if($insert_result[0] == 1){
		$book_table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
  		$id_result = $insert_result[1];
  		$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $library WHERE ID = %d", $id_result));

  		// Get saved page URL
  		$pageurl = '';
		$table_name = $wpdb->prefix.'wpbooklist_jre_saved_page_post_log';
  		$page_results = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE book_uid = %s AND type = 'page'" , $row->book_uid));
  		if(is_object($page_results)){
  			$pageurl = $page_results->post_url;
  		}

  		// Get saved post URL
  		$posturl = '';
		$table_name = $wpdb->prefix.'wpbooklist_jre_saved_page_post_log';
  		$post_results = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE book_uid = %s AND type = 'post'", $row->book_uid));
  		if(is_object($post_results)){
  			$posturl = $post_results->post_url;
  		}

  		echo $insert_result[0].'--sep--'.$id_result.'--sep--'.$library.'--sep--'.$page_yes.'--sep--'.$post_yes.'--sep--'.$pageurl.'--sep--'.$posturl.'--sep--'.$book_class->apireport.'--sep--'.json_encode($book_class->whichapifound).'--sep--'.$book_class->apiamazonfailcount;
	} else {
		echo $insert_result[0].'--sep--'.$insert_result[1];
	}

	wp_die();
}


// Function for displaying a book in the colorbox window
function wpbooklist_show_book_in_colorbox_action_javascript() { 

	$trans1 = __('Loading, Please wait', 'wpbooklist');

	?>
  	<script type="text/javascript">
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click",".wpbooklist-show-book-colorbox", function(event){
  			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  		var bookId = $(this).attr('data-bookid');
	  		var bookTable = $(this).attr('data-booktable');

	  		var brandingtext1 = $('#wpbooklist-branding-text-1').attr('data-value');
	  		if(brandingtext1 == undefined){
	  			brandingtext1 = '';
	  		}
	  		var brandingtext2 = $('#wpbooklist-branding-text-2').attr('data-value');
	  		if(brandingtext2 == undefined){
	  			brandingtext2 = '';
	  		}
	  		var brandinglogo1 = $('#wpbooklist-branding-logo-1').attr('data-value');
	  		if(brandinglogo1 == undefined){
	  			brandinglogo1 = '';
	  		}
	  		var brandinglogo2 = $('#wpbooklist-branding-logo-2').attr('data-value');
	  		if(brandinglogo2 == undefined){
	  			brandinglogo2 = '';
	  		}

	  		// The variable to tell colorbox whether this string exists in the url: sortby=alphabeticallybyauthorlast, and if so, to swap around the Author names. 
	  		var sortParam = '';
	  		var url = window.location.href;
	  		if(url.indexOf('sortby=alphabeticallybyauthorlast') > -1){
	  			sortParam = 'true';
	  		}

		  	var data = {
				'action': 'wpbooklist_show_book_in_colorbox_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_show_book_in_colorbox_action_callback" ); ?>',
				'bookId':bookId,
				'bookTable':bookTable,
				'sortParam':sortParam
			};
			console.log(data);

			$.colorbox({
		        iframe:true,
		        title: "<?php echo $trans1; ?>", 
		        width: "50%", 
		        height: "80%", 
		        html: "&nbsp;", 
		        fastIframe:false,
		        onComplete:function(){
		        	if(brandinglogo1 != ''){
		        		$('#wpbooklist-branding-img-1-id').remove();
		        		$('#cboxLoadingGraphic').css({'background':'none'})
		        		$('#cboxLoadingGraphic').append('<img style="margin-left: auto;margin-right: auto;display: block;width: 20%;margin-top: 15%;" id="wpbooklist-branding-img-1-id" src="'+brandinglogo1+'" />')
		        		
		        	}

		        	if(brandingtext1 != ''){
		        		$('#wpbooklist-branding-text-1-id').remove();
		        		$('#cboxLoadingGraphic').css({'background':'none'})
		        		$('#cboxLoadingGraphic').append('<p style="text-align: center;font-style: italic;font-size: 17px;font-weight: bold;" id="wpbooklist-branding-text-1-id">'+brandingtext1+'</p>')
		        	}

		        	$('#cboxLoadingGraphic').show();
		            $('#cboxLoadingGraphic').css({'display':'block'})
		        }
		    });

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {

			    	response = response.split('---sep---');
			    	console.log(response[1]);
			    	
			    	$.colorbox({
						open: true,
						preloading: true,
						scrolling: true,
						width:'70%',
						height:'70%',
						html: response[0],
						onClosed:function(){
						  //Do something on close.
						},
						onComplete:function(){

							if(brandinglogo2 != '' && brandingtext2 == ''){
								$('#cboxTitle').css({'border':'solid 1px #e1e1e1','height':'100px','background-color':'white', 'bottom':'-95px'})
								$('#cboxWrapper').css({'overflow':'visible'})
								$('#colorbox').css({'height':($('#colorbox').height()+100)+'px'})
								$('#cboxTitle').append('<img id="wpbooklist-branding-logo-2-id" style="width:50px; margin-top:20px;" src="'+brandinglogo2+'" />')
							}

							if(brandingtext2 != '' && brandinglogo2 == ''){
								$('#cboxTitle').css({'border':'solid 1px #e1e1e1','height':'100px','background-color':'white', 'bottom':'-95px'})
								$('#cboxWrapper').css({'overflow':'visible'})
								$('#colorbox').css({'height':($('#colorbox').height()+100)+'px'})
								$('#cboxTitle').append('<p style="text-align: center;font-style: italic;font-size: 17px;font-weight: bold;" id="wpbooklist-branding-text-2-id">'+brandingtext2+'</p>')
							}

							if(brandingtext2 != '' && brandinglogo2 != ''){
								$('#cboxTitle').css({'border':'solid 1px #e1e1e1','height':'100px','background-color':'white', 'bottom':'-95px'})
								$('#cboxWrapper').css({'overflow':'visible'})
								$('#colorbox').css({'height':($('#colorbox').height()+100)+'px'})
								$('#cboxTitle').append('<img id="wpbooklist-branding-logo-2-id" style="display:inline-block; margin-right:10px; margin-top:20px; width:50px;" src="'+brandinglogo2+'" /><p style="display:inline-block; text-align: center; margin: 0; bottom: 20px; position: relative; font-style: italic;font-size: 17px;font-weight: bold;" id="wpbooklist-branding-text-2-id">'+brandingtext2+'</p>')
							}

							
							// Hide blank 'Similar Titles' images
							$('.wpbooklist-similar-image').load(function() {
								var image = new Image();
								image.src = $(this).attr("src");
								if(image.naturalHeight == '1'){
									$(this).parent().parent().css({'display':'none'})
								}
							});

							// For the Google Preview in the Google Preview Extension
							function alertInitialized() {
							  //alert("book successfully loaded and initialized!");
							  $('#google-preview-no-results-div').css({'display':'none'})
							  $('#wpbooklist-google-title-id').css({'display':'block'})
							  $('.wpbooklist_google_p_class').css({'display':'block'})
							}

							// For the Google Preview in the Google Preview Extension
							if($('#google-preview-div').length > 0){
								//$('#wpbooklist-google-title-id').css({'display':'none'})
								$('.wpbooklist_google_p_class').css({'display':'none'})
								var viewerDiv = document.getElementById("google-preview-div");
								bookViewer = new google.books.DefaultViewer(viewerDiv);
								var test = bookViewer.load(response[1], null, alertInitialized);
							}


							addthis.toolbox(
				              $(".addthis_sharing_toolbox").get()
				            );
				            addthis.toolbox(
				              $(".addthis_sharing_toolbox").get()
				            );
				            addthis.counter(
				              $(".addthis_counter").get()
				            );
						}
					});


			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});
	  	});
	});

	// If the Google Preview Extension is active and the Google global variable has been added...
	if (window.google !== undefined && window.hasOwnProperty('google')) {
   		google.load("books", "0");
		var bookViewer;
	}

	</script>
	<?php
}

// Callback function for showing books in the colorbox window
function wpbooklist_show_book_in_colorbox_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_show_book_in_colorbox_action_callback', 'security' );
	$book_id = filter_var($_POST['bookId'],FILTER_SANITIZE_NUMBER_INT);
	$book_table = filter_var($_POST['bookTable'],FILTER_SANITIZE_STRING);
	$sortParam = filter_var($_POST['sortParam'],FILTER_SANITIZE_STRING);

	// Double-check that Amazon review isn't expired
	require_once(CLASS_DIR.'class-book.php');
	$book = new WPBookList_Book($book_id, $book_table);
	$book->refresh_amazon_review($book_id, $book_table);

	// Instantiate the class that shows the book in colorbox
	require_once(CLASS_DIR.'class-show-book-in-colorbox.php');
	$colorbox = new WPBookList_Show_Book_In_Colorbox($book_id, $book_table, null, $sortParam);

	echo $colorbox->output.'---sep---'.$colorbox->isbn;
	wp_die();
}


function wpbooklist_new_lib_shortcode_action_javascript() { ?>
 <script type="text/javascript">
 "use strict";
  jQuery(document).ready(function($) {
    $("#wpbooklist-dynamic-shortcode-button").click(function(event){
      var currentVal;
      currentVal = ($("#wpbooklist-dynamic-input-library").val()).toLowerCase();
      var data = {
        'action': 'wpbooklist_new_lib_shortcode_action',
        'currentval': currentVal,
        'security': '<?php echo wp_create_nonce( "wpbooklist-jre-ajax-nonce-newlib" ); ?>'
      };

      $.post(ajaxurl, data, function(response) {
        document.location.reload(true);
      });
    });

    $(document).on("click",".wpbooklist_delete_custom_lib", function(event){
      var table = $(this).attr('id');
      console.log(table);
      var data = {
        'action': 'wpbooklist_new_lib_shortcode_action',
        'table': table,
        'security': '<?php echo wp_create_nonce( "wpbooklist-jre-ajax-nonce-newlib" ); ?>'
      };

      var request = $.ajax({
	    url: ajaxurl,
	    type: "POST",
	    data:data,
	    timeout: 0,
	    success: function(response) {
	    	console.log(response)
	    	document.location.reload(true);
	    },
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
            console.log(textStatus);
            console.log(jqXHR);
		}
	});


      
    });
  });
  </script> <?php
}

function wpbooklist_new_lib_shortcode_action_callback() {
  // Grabbing the existing options from DB
  global $wpdb;
  global $charset_collate;
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  check_ajax_referer( 'wpbooklist-jre-ajax-nonce-newlib', 'security' );
  $table_name_dynamic = $wpdb->prefix . 'wpbooklist_jre_list_dynamic_db_names';
  $db_name;

  function wpbooklist_clean($string) {
      $string = str_replace(' ', '_', $string); // Replaces all spaces with underscores.
      $string = str_replace('-', '_', $string);
      return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
  }
 
  // Create a new custom table
  if(isset($_POST['currentval'])){
      $db_name = sanitize_text_field($_POST['currentval']);
      $db_name = wpbooklist_clean($db_name);
  }

  // Delete the table
  if(isset($_POST['table'])){ 
      $table = $wpdb->prefix."wpbooklist_jre_".sanitize_text_field($_POST['table']);
      $pos = strripos($table,"_");
      $table = substr($table, 0, $pos);
      echo $table;
      $wpdb->query("DROP TABLE IF EXISTS $table");

      $delete_from_list = sanitize_text_field($_POST['table']);
      $pos2 = strripos($delete_from_list,"_");
      $delete_id = substr($delete_from_list, ($pos2+1));
      $wpdb->delete( $table_name_dynamic, array( 'ID' => $delete_id ), array( '%d' ) );
         
      // Dropping primary key in database to alter the IDs and the AUTO_INCREMENT value
      $table_name_dynamic = str_replace('\'', '`', $table_name_dynamic);
      $wpdb->query("ALTER TABLE $table_name_dynamic MODIFY ID bigint(190) NOT NULL");

      $wpdb->query("ALTER TABLE $table_name_dynamic DROP PRIMARY KEY");

      // Adjusting ID values of remaining entries in database
      $my_query = $wpdb->get_results("SELECT * FROM $table_name_dynamic");
      $title_count = $wpdb->num_rows;

      for ($x = $delete_id ; $x <= $title_count; $x++) {
        $data = array(
            'ID' => $delete_id 
        );
        $format = array( '%s'); 
        $delete_id ++;  
        $where = array( 'ID' => ($delete_id ) );
        $where_format = array( '%d' );
        $wpdb->update( $table_name_dynamic, $data, $where, $format, $where_format );
      }  
        
      // Adding primary key back to database 
      $wpdb->query("ALTER TABLE $table_name_dynamic ADD PRIMARY KEY (`ID`)");    

      $wpdb->query("ALTER TABLE $table_name_dynamic MODIFY ID bigint(190) AUTO_INCREMENT");

      // Setting the AUTO_INCREMENT value based on number of remaining entries
      $title_count++;
      $query5 = $wpdb->prepare( "ALTER TABLE $table_name_dynamic AUTO_INCREMENT=%d",$title_count);
      $query5 = str_replace('\'', '`', $query5);
      $wpdb->query($query5);
      
  }

  if(isset($db_name)){
      if(($db_name != "")  ||  ($db_name != null)){
          $wpdb->wpbooklist_jre_dynamic_db_name = "{$wpdb->prefix}wpbooklist_jre_{$db_name}";
          $wpdb->wpbooklist_jre_dynamic_db_name_settings = "{$wpdb->prefix}wpbooklist_jre_settings_{$db_name}";
          $wpdb->wpbooklist_jre_list_dynamic_db_names = "{$wpdb->prefix}wpbooklist_jre_list_dynamic_db_names";
          $sql_create_table = "CREATE TABLE {$wpdb->wpbooklist_jre_dynamic_db_name} 
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
          dbDelta( $sql_create_table );


          $sql_create_table2 = "CREATE TABLE {$wpdb->wpbooklist_jre_dynamic_db_name_settings} 
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
	        adminmessage varchar(10000) NOT NULL DEFAULT '".ADMIN_MESSAGE."',
	        PRIMARY KEY  (ID),
          	KEY username (username)
		  ) $charset_collate; ";
		  dbDelta( $sql_create_table2 );

		  	$table_name = $wpdb->wpbooklist_jre_dynamic_db_name_settings;
  			$wpdb->insert( $table_name, array('ID' => 1));

          $wpdb->insert( $table_name_dynamic, array('user_table_name' => $db_name ));
      }
  }
      
  wp_die();
}

// function for saving library display options
function wpbooklist_dashboard_save_library_display_options_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#wpbooklist-save-backend").click(function(event){

	  		var enablepurchase = $("input[name='enable-purchase-link']" ).prop('checked');
			var hidesearch = $("input[name='hide-search']" ).prop('checked');
			var hidefacebook = $("input[name='hide-facebook']" ).prop('checked');
			var hidetwitter = $("input[name='hide-twitter']" ).prop('checked');
			var hidegoogleplus = $("input[name='hide-googleplus']" ).prop('checked');
			var hidemessenger = $("input[name='hide-messenger']" ).prop('checked');
			var hidepinterest = $("input[name='hide-pinterest']" ).prop('checked');
			var hideemail = $("input[name='hide-email']" ).prop('checked');
			var hidestats = $("input[name='hide-stats']" ).prop('checked');
			var hidefilter = $("input[name='hide-filter']" ).prop('checked');
			var hidegoodreadswidget = $("input[name='hide-goodreads']" ).prop('checked');
			var hideamazonreview = $("input[name='hide-amazon-review']" ).prop('checked');
			var hidedescription = $("input[name='hide-description']" ).prop('checked');
			var hidesimilar = $("input[name='hide-similar']" ).prop('checked');
			var hidebooktitle = $("input[name='hide-book-title']" ).prop('checked');
			var hidebookimage = $("input[name='hide-book-image']" ).prop('checked');
			var hidefinished = $("input[name='hide-finished']" ).prop('checked');
			var hidefinishedsort = $("input[name='hide-finished-sort']" ).prop('checked');
			var hidesignedsort = $("input[name='hide-signed-sort']" ).prop('checked');
			var hidefirstsort = $("input[name='hide-first-sort']" ).prop('checked');
			var hidesubjectsort = $("input[name='hide-subject-sort']" ).prop('checked');
			var hidelibrarytitle = $("input[name='hide-library-title']" ).prop('checked');
			var hideauthor = $("input[name='hide-author']" ).prop('checked');
			var hidecategory = $("input[name='hide-category']" ).prop('checked');
			var hidepages = $("input[name='hide-pages']" ).prop('checked');
			var hidebookpage = $("input[name='hide-book-page']" ).prop('checked');
			var hidebookpost = $("input[name='hide-book-post']" ).prop('checked');
			var hidepublisher = $("input[name='hide-publisher']" ).prop('checked');
			var hidepubdate = $("input[name='hide-pub-date']" ).prop('checked');
			var hidesigned = $("input[name='hide-signed']" ).prop('checked');
			var hidesubject = $("input[name='hide-subject']" ).prop('checked');
			var hidecountry = $("input[name='hide-country']" ).prop('checked');
			var hidefirstedition = $("input[name='hide-first-edition']" ).prop('checked');
			var hidefeaturedtitles = $("input[name='hide-featured-titles']" ).prop('checked');
			var hidenotes = $("input[name='hide-notes']" ).prop('checked');
			var hidequotebook = $("input[name='hide-quote-book']" ).prop('checked');
			var hidequote = $("input[name='hide-quote']" ).prop('checked');
			var hideratingbook = $("input[name='hide-rating-book']" ).prop('checked');
			var hiderating = $("input[name='hide-rating']" ).prop('checked');
			var hidegooglepurchase = $("input[name='hide-google-purchase']" ).prop('checked');
			var hideamazonpurchase = $("input[name='hide-amazon-purchase']" ).prop('checked');
			var hidebnpurchase = $("input[name='hide-bn-purchase']" ).prop('checked');
			var hideitunespurchase = $("input[name='hide-itunes-purchase']" ).prop('checked');
			var hidefrontendbuyimg = $("input[name='hide-frontend-buy-img']" ).prop('checked');
			var hidefrontendbuyprice = $("input[name='hide-frontend-buy-price']" ).prop('checked');
			var hidecolorboxbuyimg = $("input[name='hide-colorbox-buy-img']" ).prop('checked');
			var hidecolorboxbuyprice = $("input[name='hide-colorbox-buy-price']" ).prop('checked');
			var hidekindleprev = $("input[name='hide-frontend-kindle-preview']" ).prop('checked');
			var hidegoogleprev = $("input[name='hide-frontend-google-preview']" ).prop('checked');
			var hidebampurchase = $("input[name='hide-bam-purchase']" ).prop('checked');
			var hidekobopurchase = $("input[name='hide-kobo-purchase']" ).prop('checked');
			var sortoption = $("#wpbooklist-jre-sorting-select" ).val();
			var booksonpage = $("input[name='books-per-page']").val();
			var library = $("#wpbooklist-library-settings-select").val();

			// Setting some variables to '' if they weren't found in DOM, due to not having an active WPBookList Extension
			if(hidegoogleprev == '' || hidegoogleprev == undefined){
				hidegoogleprev = '';
			}

			if(enablepurchase == '' || enablepurchase == undefined){
				enablepurchase = '';
			}

			if(hidefrontendbuyimg == '' || hidefrontendbuyimg == undefined){
				hidefrontendbuyimg = '';
			}

			if(hidecolorboxbuyimg == '' || hidecolorboxbuyimg == undefined){
				hidecolorboxbuyimg = '';
			}

			if(hidecolorboxbuyprice == '' || hidecolorboxbuyprice == undefined){
				hidecolorboxbuyprice = '';
			}

			if(hidefrontendbuyprice == '' || hidefrontendbuyprice == undefined){
				hidefrontendbuyprice = '';
			}

			if(hidekindleprev == '' || hidekindleprev == undefined){
				hidekindleprev = '';
			}

		  	var data = {
				'action': 'wpbooklist_dashboard_save_library_display_options_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_dashboard_save_library_display_options_action_callback" ); ?>',
				'enablepurchase' : enablepurchase,
				'hidesearch' : hidesearch,
				'hidefacebook' : hidefacebook,
				'hidetwitter' : hidetwitter,
				'hidegoogleplus' : hidegoogleplus,
				'hidemessenger' : hidemessenger,
				'hidepinterest' : hidepinterest,
				'hideemail' : hideemail,
				'hidestats' : hidestats,
				'hidefilter' : hidefilter,
				'hidegoodreadswidget' : hidegoodreadswidget,
				'hideamazonreview' : hideamazonreview,
				'hidedescription' : hidedescription,
				'hidesimilar' : hidesimilar,
				'hidebooktitle': hidebooktitle,
				'hidebookimage' : hidebookimage,
				'hidefinished': hidefinished,
				'hidefinishedsort' : hidefinishedsort,
				'hidesignedsort': hidesignedsort,
				'hidefirstsort' : hidefirstsort,
				'hidesubjectsort': hidesubjectsort,
				'hidelibrarytitle': hidelibrarytitle,
				'hideauthor': hideauthor,
				'hidecategory': hidecategory,
				'hidepages': hidepages,
				'hidebookpage': hidebookpage,
				'hidebookpost': hidebookpost,
				'hidepublisher': hidepublisher,
				'hidepubdate': hidepubdate,
				'hidesigned': hidesigned,
				'hidesubject': hidesubject,
				'hidecountry': hidecountry,
				'hidefirstedition': hidefirstedition,
				'hidefeaturedtitles' : hidefeaturedtitles,
				'hidenotes' : hidenotes,
				'hidequotebook' : hidequotebook,
				'hidequote' : hidequote,
				'hideratingbook' : hideratingbook,
				'hiderating' : hiderating,
				'hidegooglepurchase' : hidegooglepurchase,
				'hideamazonpurchase' : hideamazonpurchase,
				'hidebnpurchase' : hidebnpurchase,
				'hideitunespurchase' : hideitunespurchase,
				'hidefrontendbuyimg' : hidefrontendbuyimg,
				'hidecolorboxbuyimg' : hidecolorboxbuyimg,
				'hidecolorboxbuyprice' : hidecolorboxbuyprice,
				'hidefrontendbuyprice' : hidefrontendbuyprice,
				'hidekindleprev': hidekindleprev,
				'hidegoogleprev': hidegoogleprev,
				'hidekobopurchase': hidekobopurchase,
				'hidebampurchase': hidebampurchase,
				'sortoption' : sortoption,
				'booksonpage' : booksonpage,
				'library': library
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload(true);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for saving library display options
function wpbooklist_dashboard_save_library_display_options_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_dashboard_save_library_display_options_action_callback', 'security' );

	$enablepurchase = filter_var($_POST['enablepurchase'],FILTER_SANITIZE_STRING);
	$hidesearch = filter_var($_POST['hidesearch'],FILTER_SANITIZE_STRING);
	$hidefacebook = filter_var($_POST['hidefacebook'],FILTER_SANITIZE_STRING);
	$hidetwitter = filter_var($_POST['hidetwitter'],FILTER_SANITIZE_STRING);
	$hidegoogleplus = filter_var($_POST['hidegoogleplus'],FILTER_SANITIZE_STRING);
	$hidemessenger = filter_var($_POST['hidemessenger'],FILTER_SANITIZE_STRING);
	$hidepinterest = filter_var($_POST['hidepinterest'],FILTER_SANITIZE_STRING);
	$hideemail = filter_var($_POST['hideemail'],FILTER_SANITIZE_STRING);
	$hidestats = filter_var($_POST['hidestats'],FILTER_SANITIZE_STRING);
	$hidefilter = filter_var($_POST['hidefilter'],FILTER_SANITIZE_STRING);
	$hidegoodreadswidget = filter_var($_POST['hidegoodreadswidget'],FILTER_SANITIZE_STRING);
	$hideamazonreview = filter_var($_POST['hideamazonreview'],FILTER_SANITIZE_STRING);
	$hidedescription = filter_var($_POST['hidedescription'],FILTER_SANITIZE_STRING);
	$hidesimilar = filter_var($_POST['hidesimilar'],FILTER_SANITIZE_STRING);
	$hidebooktitle = filter_var($_POST['hidebooktitle'],FILTER_SANITIZE_STRING);
	$hidebookimage = filter_var($_POST['hidebookimage'],FILTER_SANITIZE_STRING);
	$hidefinished = filter_var($_POST['hidefinished'],FILTER_SANITIZE_STRING);
	$hidefinishedsort = filter_var($_POST['hidefinishedsort'],FILTER_SANITIZE_STRING);
	$hidesignedsort = filter_var($_POST['hidesignedsort'],FILTER_SANITIZE_STRING);
	$hidefirstsort = filter_var($_POST['hidefirstsort'],FILTER_SANITIZE_STRING);
	$hidesubjectsort = filter_var($_POST['hidesubjectsort'],FILTER_SANITIZE_STRING);
	$hidelibrarytitle = filter_var($_POST['hidelibrarytitle'],FILTER_SANITIZE_STRING);
	$hideauthor = filter_var($_POST['hideauthor'],FILTER_SANITIZE_STRING);
	$hidecategory = filter_var($_POST['hidecategory'],FILTER_SANITIZE_STRING);
	$hidepages = filter_var($_POST['hidepages'],FILTER_SANITIZE_STRING);
	$hidebookpage = filter_var($_POST['hidebookpage'],FILTER_SANITIZE_STRING);
	$hidebookpost = filter_var($_POST['hidebookpost'],FILTER_SANITIZE_STRING);	
	$hidepublisher = filter_var($_POST['hidepublisher'],FILTER_SANITIZE_STRING);
	$hidepubdate = filter_var($_POST['hidepubdate'],FILTER_SANITIZE_STRING);
	$hidesigned = filter_var($_POST['hidesigned'],FILTER_SANITIZE_STRING);
	$hidesubject = filter_var($_POST['hidesubject'],FILTER_SANITIZE_STRING);
	$hidecountry = filter_var($_POST['hidecountry'],FILTER_SANITIZE_STRING);
	$hidefirstedition= filter_var($_POST['hidefirstedition'],FILTER_SANITIZE_STRING); 
	$hidefeaturedtitles = filter_var($_POST['hidefeaturedtitles'],FILTER_SANITIZE_STRING);
	$hidenotes = filter_var($_POST['hidenotes'],FILTER_SANITIZE_STRING);
	$hidequotebook = filter_var($_POST['hidequotebook'],FILTER_SANITIZE_STRING);
	$hidequote = filter_var($_POST['hidequote'],FILTER_SANITIZE_STRING);
	$hideratingbook = filter_var($_POST['hideratingbook'],FILTER_SANITIZE_STRING);
	$hiderating = filter_var($_POST['hiderating'],FILTER_SANITIZE_STRING);
	$hidegooglepurchase = filter_var($_POST['hidegooglepurchase'],FILTER_SANITIZE_STRING);
	$hideamazonpurchase = filter_var($_POST['hideamazonpurchase'],FILTER_SANITIZE_STRING);
	$hidebnpurchase = filter_var($_POST['hidebnpurchase'],FILTER_SANITIZE_STRING);
	$hideitunespurchase = filter_var($_POST['hideitunespurchase'],FILTER_SANITIZE_STRING);
	$hidefrontendbuyimg = filter_var($_POST['hidefrontendbuyimg'],FILTER_SANITIZE_STRING);
	$hidecolorboxbuyimg = filter_var($_POST['hidecolorboxbuyimg'],FILTER_SANITIZE_STRING);
	$hidecolorboxbuyprice = filter_var($_POST['hidecolorboxbuyprice'],FILTER_SANITIZE_STRING);
	$hidefrontendbuyprice = filter_var($_POST['hidefrontendbuyprice'],FILTER_SANITIZE_STRING);
	$hidekindleprev = filter_var($_POST['hidekindleprev'],FILTER_SANITIZE_STRING);
	$hidegoogleprev = filter_var($_POST['hidegoogleprev'],FILTER_SANITIZE_STRING);
	$hidekobopurchase = filter_var($_POST['hidekobopurchase'],FILTER_SANITIZE_STRING);
	$hidebampurchase = filter_var($_POST['hidebampurchase'],FILTER_SANITIZE_STRING);
	$sortoption = filter_var($_POST['sortoption'],FILTER_SANITIZE_STRING);
	$booksonpage = filter_var($_POST['booksonpage'], FILTER_SANITIZE_NUMBER_INT);
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);

	$settings_array = array(
		'enablepurchase' => $enablepurchase,
		'hidesearch' => $hidesearch,
		'hidefacebook' => $hidefacebook,
		'hidetwitter' => $hidetwitter,
		'hidegoogleplus' => $hidegoogleplus,
		'hidemessenger' => $hidemessenger,
		'hidepinterest' => $hidepinterest,
		'hideemail' => $hideemail,
		'hidestats' => $hidestats,
		'hidequote' => $hidequote,
		'hidefilter' => $hidefilter,
		'hidegoodreadswidget' => $hidegoodreadswidget,
		'hideamazonreview' => $hideamazonreview,
		'hidedescription' => $hidedescription,
		'hidesimilar' => $hidesimilar,
		'hidebooktitle'=> $hidebooktitle,
		'hidebookimage' => $hidebookimage,
		'hidefinished'=> $hidefinished,
		'hidefinishedsort' => $hidefinishedsort,
		'hidesignedsort' => $hidesignedsort,
		'hidefirstsort' => $hidefirstsort,
		'hidesubjectsort' => $hidesubjectsort,
		'hidelibrarytitle'=> $hidelibrarytitle,
		'hideauthor'=> $hideauthor,
		'hidecategory'=> $hidecategory,
		'hidepages'=> $hidepages,
		'hidebookpage'=> $hidebookpage,
		'hidebookpost'=> $hidebookpost,
		'hidepublisher'=> $hidepublisher,
		'hidepubdate'=> $hidepubdate,
		'hidesigned'=> $hidesigned,
		'hidesubject'=> $hidesubject,
		'hidecountry'=> $hidecountry,
		'hidefirstedition'=> $hidefirstedition,
		'hidefeaturedtitles' => $hidefeaturedtitles,
		'hidenotes' => $hidenotes,
		'hidequotebook' => $hidequotebook,
		'hiderating' => $hiderating,
		'hideratingbook' => $hideratingbook,
		'hidegooglepurchase' => $hidegooglepurchase,
		'hideamazonpurchase' => $hideamazonpurchase,
		'hidebnpurchase' => $hidebnpurchase,
		'hideitunespurchase' => $hideitunespurchase,
		'hidefrontendbuyimg' => $hidefrontendbuyimg,
		'hidecolorboxbuyimg' => $hidecolorboxbuyimg,
		'hidecolorboxbuyprice' => $hidecolorboxbuyprice,
		'hidefrontendbuyprice' => $hidefrontendbuyprice,
		'hidekindleprev' => $hidekindleprev,
		'hidegoogleprev' => $hidegoogleprev,
		'hidebampurchase' => $hidebampurchase,
		'hidekobopurchase' => $hidekobopurchase,
		'sortoption' => $sortoption,
		'booksonpage' => $booksonpage
	);

	require_once(CLASS_DIR.'class-display-options.php');
	$settings_class = new WPBookList_Display_Options();
	$settings_class->save_library_settings($library, $settings_array);
	wp_die();
}

// function for saving post display options
function wpbooklist_dashboard_save_post_display_options_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#wpbooklist-save-post-backend").click(function(event){

	  		var enablepurchase = $("input[name='enable-purchase-link']" ).prop('checked');
			var hidefacebook = $("input[name='hide-facebook']" ).prop('checked');
			var hidetwitter = $("input[name='hide-twitter']" ).prop('checked');
			var hidegoogleplus = $("input[name='hide-googleplus']" ).prop('checked');
			var hidemessenger = $("input[name='hide-messenger']" ).prop('checked');
			var hidepinterest = $("input[name='hide-pinterest']" ).prop('checked');
			var hideemail = $("input[name='hide-email']" ).prop('checked');
			var hideamazonreview = $("input[name='hide-amazon-review']" ).prop('checked');
			var hidedescription = $("input[name='hide-description']" ).prop('checked');
			var hidesimilar = $("input[name='hide-similar']" ).prop('checked');
			var hidetitle = $("input[name='hide-book-title']" ).prop('checked');
			var hidebookimage = $("input[name='hide-book-image']" ).prop('checked');
			var hidefinished = $("input[name='hide-finished']" ).prop('checked');
			var hideauthor = $("input[name='hide-author']" ).prop('checked');
			var hidecategory = $("input[name='hide-category']" ).prop('checked');
			var hidepages = $("input[name='hide-pages']" ).prop('checked');
			var hidepublisher = $("input[name='hide-publisher']" ).prop('checked');
			var hidepubdate = $("input[name='hide-pub-date']" ).prop('checked');
			var hidesigned = $("input[name='hide-signed']" ).prop('checked');
			var hidesubject = $("input[name='hide-subject']" ).prop('checked');
			var hidecountry = $("input[name='hide-country']" ).prop('checked');
			var hidefirstedition = $("input[name='hide-first-edition']" ).prop('checked');
			var hidefeaturedtitles = $("input[name='hide-featured-titles']" ).prop('checked');
			var hidenotes = $("input[name='hide-notes']" ).prop('checked');
			var hidequote = $("input[name='hide-quote']" ).prop('checked');
			var hiderating = $("input[name='hide-rating']" ).prop('checked');
			var hidegooglepurchase = $("input[name='hide-google-purchase']" ).prop('checked');
			var hideamazonpurchase = $("input[name='hide-amazon-purchase']" ).prop('checked');
			var hidebnpurchase = $("input[name='hide-bn-purchase']" ).prop('checked');
			var hideitunespurchase = $("input[name='hide-itunes-purchase']" ).prop('checked');
			var hidefrontendbuyimg = $("input[name='hide-frontend-buy-img']" ).prop('checked');
			var hidecolorboxbuyimg = $("input[name='hide-colorbox-buy-img']" ).prop('checked');
			var hidecolorboxbuyprice = $("input[name='hide-colorbox-buy-price']" ).prop('checked');
			var hidefrontendbuyprice = $("input[name='hide-frontend-buy-price']" ).prop('checked');
			var hidekindleprev = $("input[name='hide-frontend-kindle-preview']" ).prop('checked');
			var hidegoogleprev = $("input[name='hide-frontend-google-preview']" ).prop('checked');
			var hidekobopurchase = $("input[name='hide-kobo-purchase']" ).prop('checked');
			var hidebampurchase = $("input[name='hide-bam-purchase']" ).prop('checked');

			// Setting some variables to '' if they weren't found in DOM, due to not having an active WPBookList Extension
			if(hidegoogleprev == '' || hidegoogleprev == undefined){
				hidegoogleprev = '';
			}

			if(enablepurchase == '' || enablepurchase == undefined){
				enablepurchase = '';
			}

			if(hidefrontendbuyimg == '' || hidefrontendbuyimg == undefined){
				hidefrontendbuyimg = '';
			}

			if(hidecolorboxbuyimg == '' || hidecolorboxbuyimg == undefined){
				hidecolorboxbuyimg = '';
			}

			if(hidecolorboxbuyprice == '' || hidecolorboxbuyprice == undefined){
				hidecolorboxbuyprice = '';
			}

			if(hidefrontendbuyprice == '' || hidefrontendbuyprice == undefined){
				hidefrontendbuyprice = '';
			}

			if(hidekindleprev == '' || hidekindleprev == undefined){
				hidekindleprev = '';
			}



		  	var data = {
				'action': 'wpbooklist_dashboard_save_post_display_options_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_dashboard_save_post_display_options_action_callback" ); ?>',
				'enablepurchase' : enablepurchase,
				'hidefacebook' : hidefacebook,
				'hidetwitter' : hidetwitter,
				'hidegoogleplus' : hidegoogleplus,
				'hidemessenger' : hidemessenger,
				'hidepinterest' : hidepinterest,
				'hideemail' : hideemail,
				'hideamazonreview' : hideamazonreview,
				'hidedescription' : hidedescription,
				'hidesimilar' : hidesimilar,
				'hidetitle': hidetitle,
				'hidebookimage' : hidebookimage,
				'hidefinished': hidefinished,
				'hideauthor': hideauthor,
				'hidecategory': hidecategory,
				'hidepages': hidepages,
				'hidepublisher': hidepublisher,
				'hidepubdate': hidepubdate,
				'hidesigned': hidesigned,
				'hidesubject': hidesubject,
				'hidecountry': hidecountry,
				'hidefirstedition': hidefirstedition,
				'hidefeaturedtitles' : hidefeaturedtitles,
				'hidenotes' : hidenotes,
				'hidequote' : hidequote,
				'hiderating' : hiderating,
				'hidegooglepurchase' : hidegooglepurchase,
				'hideamazonpurchase' : hideamazonpurchase,
				'hidebnpurchase' : hidebnpurchase,
				'hideitunespurchase' : hideitunespurchase,
				'hidefrontendbuyimg' : hidefrontendbuyimg,
				'hidecolorboxbuyimg' : hidecolorboxbuyimg,
				'hidecolorboxbuyprice' : hidecolorboxbuyprice,
				'hidefrontendbuyprice' : hidefrontendbuyprice,
				'hidekindleprev' : hidekindleprev,
				'hidegoogleprev' : hidegoogleprev,
				'hidebampurchase' : hidebampurchase,
				'hidekobopurchase' : hidekobopurchase,
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload(true);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for saving post display options
function wpbooklist_dashboard_save_post_display_options_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_dashboard_save_post_display_options_action_callback', 'security' );

	$enablepurchase = filter_var($_POST['enablepurchase'],FILTER_SANITIZE_STRING);
	$hidefacebook = filter_var($_POST['hidefacebook'],FILTER_SANITIZE_STRING);
	$hidetwitter = filter_var($_POST['hidetwitter'],FILTER_SANITIZE_STRING);
	$hidegoogleplus = filter_var($_POST['hidegoogleplus'],FILTER_SANITIZE_STRING);
	$hidemessenger = filter_var($_POST['hidemessenger'],FILTER_SANITIZE_STRING);
	$hidepinterest = filter_var($_POST['hidepinterest'],FILTER_SANITIZE_STRING);
	$hideemail = filter_var($_POST['hideemail'],FILTER_SANITIZE_STRING);
	$hideamazonreview = filter_var($_POST['hideamazonreview'],FILTER_SANITIZE_STRING);
	$hidedescription = filter_var($_POST['hidedescription'],FILTER_SANITIZE_STRING);
	$hidesimilar = filter_var($_POST['hidesimilar'],FILTER_SANITIZE_STRING);
	$hidetitle = filter_var($_POST['hidetitle'],FILTER_SANITIZE_STRING);
	$hidebookimage = filter_var($_POST['hidebookimage'],FILTER_SANITIZE_STRING);
	$hidefinished = filter_var($_POST['hidefinished'],FILTER_SANITIZE_STRING);
	$hideauthor = filter_var($_POST['hideauthor'],FILTER_SANITIZE_STRING);
	$hidecategory = filter_var($_POST['hidecategory'],FILTER_SANITIZE_STRING);
	$hidepages = filter_var($_POST['hidepages'],FILTER_SANITIZE_STRING);
	$hidepublisher = filter_var($_POST['hidepublisher'],FILTER_SANITIZE_STRING);
	$hidepubdate = filter_var($_POST['hidepubdate'],FILTER_SANITIZE_STRING);
	$hidesigned = filter_var($_POST['hidesigned'],FILTER_SANITIZE_STRING);
	$hidesubject = filter_var($_POST['hidesubject'],FILTER_SANITIZE_STRING);
	$hidecountry = filter_var($_POST['hidecountry'],FILTER_SANITIZE_STRING);
	$hidefirstedition= filter_var($_POST['hidefirstedition'],FILTER_SANITIZE_STRING); 
	$hidefeaturedtitles = filter_var($_POST['hidefeaturedtitles'],FILTER_SANITIZE_STRING);
	$hidenotes = filter_var($_POST['hidenotes'],FILTER_SANITIZE_STRING);
	$hidequote = filter_var($_POST['hidequote'],FILTER_SANITIZE_STRING);
	$hiderating = filter_var($_POST['hiderating'],FILTER_SANITIZE_STRING);
	$hidegooglepurchase = filter_var($_POST['hidegooglepurchase'],FILTER_SANITIZE_STRING);
	$hideamazonpurchase = filter_var($_POST['hideamazonpurchase'],FILTER_SANITIZE_STRING);
	$hidebnpurchase = filter_var($_POST['hidebnpurchase'],FILTER_SANITIZE_STRING);
	$hideitunespurchase = filter_var($_POST['hideitunespurchase'],FILTER_SANITIZE_STRING);
	$hidefrontendbuyimg = filter_var($_POST['hidefrontendbuyimg'],FILTER_SANITIZE_STRING);
	$hidecolorboxbuyimg = filter_var($_POST['hidecolorboxbuyimg'],FILTER_SANITIZE_STRING);
	$hidecolorboxbuyprice = filter_var($_POST['hidecolorboxbuyprice'],FILTER_SANITIZE_STRING);
	$hidefrontendbuyprice = filter_var($_POST['hidefrontendbuyprice'],FILTER_SANITIZE_STRING);
	$hidekindleprev = filter_var($_POST['hidekindleprev'],FILTER_SANITIZE_STRING);
	$hidegoogleprev = filter_var($_POST['hidegoogleprev'],FILTER_SANITIZE_STRING);
	$hidekobopurchase = filter_var($_POST['hidekobopurchase'],FILTER_SANITIZE_STRING);
	$hidebampurchase = filter_var($_POST['hidebampurchase'],FILTER_SANITIZE_STRING);

	$settings_array = array(
		'enablepurchase' => $enablepurchase,
		'hidefacebook' => $hidefacebook,
		'hidetwitter' => $hidetwitter,
		'hidegoogleplus' => $hidegoogleplus,
		'hidemessenger' => $hidemessenger,
		'hidepinterest' => $hidepinterest,
		'hideemail' => $hideemail,
		'hidequote' => $hidequote,
		'hideamazonreview' => $hideamazonreview,
		'hidedescription' => $hidedescription,
		'hidesimilar' => $hidesimilar,
		'hidetitle'=> $hidetitle,
		'hidebookimage' => $hidebookimage,
		'hidefinished'=> $hidefinished,
		'hideauthor'=> $hideauthor,
		'hidecategory'=> $hidecategory,
		'hidepages'=> $hidepages,
		'hidepublisher'=> $hidepublisher,
		'hidepubdate'=> $hidepubdate,
		'hidesigned'=> $hidesigned,
		'hidesubject'=> $hidesubject,
		'hidecountry'=> $hidecountry,
		'hidefirstedition'=> $hidefirstedition,
		'hidefeaturedtitles' => $hidefeaturedtitles,
		'hidenotes' => $hidenotes,
		'hiderating' => $hiderating,
		'hidegooglepurchase' => $hidegooglepurchase,
		'hideamazonpurchase' => $hideamazonpurchase,
		'hidebnpurchase' => $hidebnpurchase,
		'hideitunespurchase' => $hideitunespurchase,
		'hidefrontendbuyimg' => $hidefrontendbuyimg,
		'hidecolorboxbuyimg' => $hidecolorboxbuyimg,
		'hidecolorboxbuyprice' => $hidecolorboxbuyprice,
		'hidefrontendbuyprice' => $hidefrontendbuyprice,
		'hidekindleprev' => $hidekindleprev,
		'hidegoogleprev' => $hidegoogleprev,
		'hidebampurchase' => $hidebampurchase,
		'hidekobopurchase' => $hidekobopurchase
	);

	require_once(CLASS_DIR.'class-display-options.php');
	$settings_class = new WPBookList_Display_Options();
	$settings_class->save_post_settings($settings_array);
	wp_die();
}


// function for saving page display options
function wpbooklist_dashboard_save_page_display_options_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#wpbooklist-save-page-backend").click(function(event){

	  		var enablepurchase = $("input[name='enable-purchase-link']" ).prop('checked');
			var hidefacebook = $("input[name='hide-facebook']" ).prop('checked');
			var hidetwitter = $("input[name='hide-twitter']" ).prop('checked');
			var hidegoogleplus = $("input[name='hide-googleplus']" ).prop('checked');
			var hidemessenger = $("input[name='hide-messenger']" ).prop('checked');
			var hidepinterest = $("input[name='hide-pinterest']" ).prop('checked');
			var hideemail = $("input[name='hide-email']" ).prop('checked');
			var hideamazonreview = $("input[name='hide-amazon-review']" ).prop('checked');
			var hidedescription = $("input[name='hide-description']" ).prop('checked');
			var hidesimilar = $("input[name='hide-similar']" ).prop('checked');
			var hidetitle = $("input[name='hide-book-title']" ).prop('checked');
			var hidebookimage = $("input[name='hide-book-image']" ).prop('checked');
			var hidefinished = $("input[name='hide-finished']" ).prop('checked');
			var hideauthor = $("input[name='hide-author']" ).prop('checked');
			var hidecategory = $("input[name='hide-category']" ).prop('checked');
			var hidepages = $("input[name='hide-pages']" ).prop('checked');
			var hidepublisher = $("input[name='hide-publisher']" ).prop('checked');
			var hidepubdate = $("input[name='hide-pub-date']" ).prop('checked');
			var hidesigned = $("input[name='hide-signed']" ).prop('checked');
			var hidesubject = $("input[name='hide-subject']" ).prop('checked');
			var hidecountry = $("input[name='hide-country']" ).prop('checked');
			var hidefirstedition = $("input[name='hide-first-edition']" ).prop('checked');
			var hidefeaturedtitles = $("input[name='hide-featured-titles']" ).prop('checked');
			var hidenotes = $("input[name='hide-notes']" ).prop('checked');
			var hidequote = $("input[name='hide-quote']" ).prop('checked');
			var hiderating = $("input[name='hide-rating']" ).prop('checked');
			var hidegooglepurchase = $("input[name='hide-google-purchase']" ).prop('checked');
			var hideamazonpurchase = $("input[name='hide-amazon-purchase']" ).prop('checked');
			var hidebnpurchase = $("input[name='hide-bn-purchase']" ).prop('checked');
			var hideitunespurchase = $("input[name='hide-itunes-purchase']" ).prop('checked');
			var hidefrontendbuyimg = $("input[name='hide-frontend-buy-img']" ).prop('checked');
			var hidecolorboxbuyimg = $("input[name='hide-colorbox-buy-img']" ).prop('checked');
			var hidecolorboxbuyprice = $("input[name='hide-colorbox-buy-price']" ).prop('checked');
			var hidefrontendbuyprice = $("input[name='hide-frontend-buy-price']" ).prop('checked');
			var hidekindleprev = $("input[name='hide-frontend-kindle-preview']" ).prop('checked');
			var hidegoogleprev = $("input[name='hide-frontend-google-preview']" ).prop('checked');
			var hidebampurchase = $("input[name='hide-bam-purchase']" ).prop('checked');
			var hidekobopurchase = $("input[name='hide-kobo-purchase']" ).prop('checked');


			// Setting some variables to '' if they weren't found in DOM, due to not having an active WPBookList Extension
			if(hidegoogleprev == '' || hidegoogleprev == undefined){
				hidegoogleprev = '';
			}

			if(enablepurchase == '' || enablepurchase == undefined){
				enablepurchase = '';
			}

			if(hidefrontendbuyimg == '' || hidefrontendbuyimg == undefined){
				hidefrontendbuyimg = '';
			}

			if(hidecolorboxbuyimg == '' || hidecolorboxbuyimg == undefined){
				hidecolorboxbuyimg = '';
			}

			if(hidecolorboxbuyprice == '' || hidecolorboxbuyprice == undefined){
				hidecolorboxbuyprice = '';
			}

			if(hidefrontendbuyprice == '' || hidefrontendbuyprice == undefined){
				hidefrontendbuyprice = '';
			}

			if(hidekindleprev == '' || hidekindleprev == undefined){
				hidekindleprev = '';
			}

		  	var data = {
				'action': 'wpbooklist_dashboard_save_page_display_options_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_dashboard_save_page_display_options_action_callback" ); ?>',
				'enablepurchase' : enablepurchase,
				'hidefacebook' : hidefacebook,
				'hidetwitter' : hidetwitter,
				'hidegoogleplus' : hidegoogleplus,
				'hidemessenger' : hidemessenger,
				'hidepinterest' : hidepinterest,
				'hideemail' : hideemail,
				'hideamazonreview' : hideamazonreview,
				'hidedescription' : hidedescription,
				'hidesimilar' : hidesimilar,
				'hidetitle': hidetitle,
				'hidebookimage' : hidebookimage,
				'hidefinished': hidefinished,
				'hideauthor': hideauthor,
				'hidecategory': hidecategory,
				'hidepages': hidepages,
				'hidepublisher': hidepublisher,
				'hidepubdate': hidepubdate,
				'hidesigned': hidesigned,
				'hidesubject': hidesubject,
				'hidecountry': hidecountry,
				'hidefirstedition': hidefirstedition,
				'hidefeaturedtitles' : hidefeaturedtitles,
				'hidenotes' : hidenotes,
				'hidequote' : hidequote,
				'hiderating' : hiderating,
				'hidegooglepurchase' : hidegooglepurchase,
				'hideamazonpurchase' : hideamazonpurchase,
				'hidebnpurchase' : hidebnpurchase,
				'hideitunespurchase' : hideitunespurchase,
				'hidefrontendbuyimg' : hidefrontendbuyimg,
				'hidecolorboxbuyimg' : hidecolorboxbuyimg,
				'hidecolorboxbuyprice' : hidecolorboxbuyprice,
				'hidefrontendbuyprice' : hidefrontendbuyprice,
				'hidekindleprev' : hidekindleprev,
				'hidegoogleprev' : hidegoogleprev,
				'hidekobopurchase': hidekobopurchase,
				'hidebampurchase': hidebampurchase
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload(true);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for saving page display options
function wpbooklist_dashboard_save_page_display_options_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_dashboard_save_page_display_options_action_callback', 'security' );

	$enablepurchase = filter_var($_POST['enablepurchase'],FILTER_SANITIZE_STRING);
	$hidefacebook = filter_var($_POST['hidefacebook'],FILTER_SANITIZE_STRING);
	$hidetwitter = filter_var($_POST['hidetwitter'],FILTER_SANITIZE_STRING);
	$hidegoogleplus = filter_var($_POST['hidegoogleplus'],FILTER_SANITIZE_STRING);
	$hidemessenger = filter_var($_POST['hidemessenger'],FILTER_SANITIZE_STRING);
	$hidepinterest = filter_var($_POST['hidepinterest'],FILTER_SANITIZE_STRING);
	$hideemail = filter_var($_POST['hideemail'],FILTER_SANITIZE_STRING);
	$hideamazonreview = filter_var($_POST['hideamazonreview'],FILTER_SANITIZE_STRING);
	$hidedescription = filter_var($_POST['hidedescription'],FILTER_SANITIZE_STRING);
	$hidesimilar = filter_var($_POST['hidesimilar'],FILTER_SANITIZE_STRING);
	$hidetitle = filter_var($_POST['hidetitle'],FILTER_SANITIZE_STRING);
	$hidebookimage = filter_var($_POST['hidebookimage'],FILTER_SANITIZE_STRING);
	$hidefinished = filter_var($_POST['hidefinished'],FILTER_SANITIZE_STRING);
	$hideauthor = filter_var($_POST['hideauthor'],FILTER_SANITIZE_STRING);
	$hidecategory = filter_var($_POST['hidecategory'],FILTER_SANITIZE_STRING);
	$hidepages = filter_var($_POST['hidepages'],FILTER_SANITIZE_STRING);
	$hidepublisher = filter_var($_POST['hidepublisher'],FILTER_SANITIZE_STRING);
	$hidepubdate = filter_var($_POST['hidepubdate'],FILTER_SANITIZE_STRING);
	$hidesigned = filter_var($_POST['hidesigned'],FILTER_SANITIZE_STRING);
	$hidesubject = filter_var($_POST['hidesubject'],FILTER_SANITIZE_STRING);
	$hidecountry = filter_var($_POST['hidecountry'],FILTER_SANITIZE_STRING);
	$hidefirstedition= filter_var($_POST['hidefirstedition'],FILTER_SANITIZE_STRING); 
	$hidefeaturedtitles = filter_var($_POST['hidefeaturedtitles'],FILTER_SANITIZE_STRING);
	$hidenotes = filter_var($_POST['hidenotes'],FILTER_SANITIZE_STRING);
	$hidequote = filter_var($_POST['hidequote'],FILTER_SANITIZE_STRING);
	$hiderating = filter_var($_POST['hiderating'],FILTER_SANITIZE_STRING);
	$hidegooglepurchase = filter_var($_POST['hidegooglepurchase'],FILTER_SANITIZE_STRING);
	$hideamazonpurchase = filter_var($_POST['hideamazonpurchase'],FILTER_SANITIZE_STRING);
	$hidebnpurchase = filter_var($_POST['hidebnpurchase'],FILTER_SANITIZE_STRING);
	$hideitunespurchase = filter_var($_POST['hideitunespurchase'],FILTER_SANITIZE_STRING);
	$hidefrontendbuyimg = filter_var($_POST['hidefrontendbuyimg'],FILTER_SANITIZE_STRING);
	$hidecolorboxbuyimg = filter_var($_POST['hidecolorboxbuyimg'],FILTER_SANITIZE_STRING);
	$hidecolorboxbuyprice = filter_var($_POST['hidecolorboxbuyprice'],FILTER_SANITIZE_STRING);
	$hidefrontendbuyprice = filter_var($_POST['hidefrontendbuyprice'],FILTER_SANITIZE_STRING);
	$hidekindleprev = filter_var($_POST['hidekindleprev'],FILTER_SANITIZE_STRING);
	$hidegoogleprev = filter_var($_POST['hidegoogleprev'],FILTER_SANITIZE_STRING);
	$hidekobopurchase = filter_var($_POST['hidekobopurchase'],FILTER_SANITIZE_STRING);
	$hidebampurchase = filter_var($_POST['hidebampurchase'],FILTER_SANITIZE_STRING);

	$settings_array = array(
		'enablepurchase' => $enablepurchase,
		'hidefacebook' => $hidefacebook,
		'hidetwitter' => $hidetwitter,
		'hidegoogleplus' => $hidegoogleplus,
		'hidemessenger' => $hidemessenger,
		'hidepinterest' => $hidepinterest,
		'hideemail' => $hideemail,
		'hidequote' => $hidequote,
		'hideamazonreview' => $hideamazonreview,
		'hidedescription' => $hidedescription,
		'hidesimilar' => $hidesimilar,
		'hidetitle'=> $hidetitle,
		'hidebookimage' => $hidebookimage,
		'hidefinished'=> $hidefinished,
		'hideauthor'=> $hideauthor,
		'hidecategory'=> $hidecategory,
		'hidepages'=> $hidepages,
		'hidepublisher'=> $hidepublisher,
		'hidepubdate'=> $hidepubdate,
		'hidesigned'=> $hidesigned,
		'hidesubject'=> $hidesubject,
		'hidecountry'=> $hidecountry,
		'hidefirstedition'=> $hidefirstedition,
		'hidefeaturedtitles' => $hidefeaturedtitles,
		'hidenotes' => $hidenotes,
		'hiderating' => $hiderating,
		'hidegooglepurchase' => $hidegooglepurchase,
		'hideamazonpurchase' => $hideamazonpurchase,
		'hidebnpurchase' => $hidebnpurchase,
		'hideitunespurchase' => $hideitunespurchase,
		'hidefrontendbuyimg' => $hidefrontendbuyimg,
		'hidecolorboxbuyimg' => $hidecolorboxbuyimg,
		'hidecolorboxbuyprice' => $hidecolorboxbuyprice,
		'hidefrontendbuyprice' => $hidefrontendbuyprice,
		'hidekindleprev' => $hidekindleprev,
		'hidegoogleprev' => $hidegoogleprev,
		'hidebampurchase' => $hidebampurchase,
		'hidekobopurchase' => $hidekobopurchase,

	);

	require_once(CLASS_DIR.'class-display-options.php');
	$settings_class = new WPBookList_Display_Options();
	$settings_class->save_page_settings($settings_array);
	wp_die();
}

function wpbooklist_update_display_options_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#wpbooklist-library-settings-select").on('change', function(event){

	  		var optionsTable = $('#wpbooklist-jre-backend-options-table');
	  		var lowerTable = $('#wpbooklist-library-options-lower-table');
	  		var lowerTableInput = $('#wpbooklist-library-options-lower-table input');
	  		var optionsTableInput = $('#wpbooklist-jre-backend-options-table input');
	  		var spinner = $('#wpbooklist-spinner-2');
	  		var library = $('#wpbooklist-library-settings-select').val();
	  		var saveChanges = $('#wpbooklist-save-backend');
	  		spinner.animate({'opacity':'1'}, 200);
	  		optionsTable.animate({'opacity':'0.3'}, 500);
	  		lowerTable.animate({'opacity':'0.3'}, 500);
	  		lowerTable.animate({'opacity':'0.3'}, 500);
	  		saveChanges.animate({'opacity':'0.3'}, 500);
	  		saveChanges.attr('disabled', true);
	  		lowerTableInput.attr('disabled', true);

	  		var settingsArray = {
				'enablepurchase' : 'enable-purchase-link',
				'hidesearch' : 'hide-search',
				'hidefacebook' : 'hide-facebook',
				'hidetwitter' : 'hide-twitter',
				'hidegoogleplus' : 'hide-googleplus',
				'hidemessenger' : 'hide-messenger',
				'hidepinterest' : 'hide-pinterest',
				'hideemail' : 'hide-email',
				'hidestats' : 'hide-stats',
				'hidefilter' : 'hide-filter',
				'hidegoodreadswidget' : 'hide-goodreads',
				'hideamazonreview' : 'hide-amazon-review',
				'hidedescription' : 'hide-description',
				'hidesimilar' : 'hide-similar',
				'hidebooktitle' : 'hide-book-title',
				'hidebookimage'  : 'hide-book-image',
				'hidefinished' : 'hide-finished',
				'hidelibrarytitle' : 'hide-library-title',
				'hideauthor' : 'hide-author',
				'hidecategory' : 'hide-category',
				'hidepages' : 'hide-pages',
				'hidebookpage' : 'hide-book-page',
				'hidebookpost' : 'hide-book-post',
				'hidepublisher' : 'hide-publisher',
				'hidepubdate' : 'hide-pub-date',
				'hidesigned' : 'hide-signed',
				'hidesubject' : 'hide-subject',
				'hidecountry' : 'hide-country',
				'hidefinishedsort' : 'hide-finished-sort',
				'hidesignedsort' : 'hide-signed-sort',
				'hidefirstsort' : 'hide-first-sort',
				'hidesubjectsort' : 'hide-subject-sort',
				'hidefirstedition' : 'hide-first-edition',
				'hidefeaturedtitles' : 'hide-featured-titles',
				'hidenotes' : 'hide-notes',
				'hidequotebook' : 'hide-quote-book',
				'hidequote' : 'hide-quote',
				'hideratingbook' : 'hide-rating-book',
				'hiderating' : 'hide-rating',
				'hidegooglepurchase' : 'hide-google-purchase',
				'hideamazonpurchase' : 'hide-amazon-purchase',
				'hidebnpurchase' : 'hide-bn-purchase',
				'hideitunespurchase' : 'hide-itunes-purchase',
				'hidefrontendbuyimg' : 'hide-frontend-buy-img',
				'hidecolorboxbuyimg' : 'hide-colorbox-buy-img',
				'hidecolorboxbuyprice' : 'hide-colorbox-buy-price',
				'hidefrontendbuyprice' : 'hide-frontend-buy-price',
				'hidekindleprev' : 'hide-frontend-kindle-preview',
				'hidegoogleprev' : 'hide-frontend-google-preview',
				'hidebampurchase' : 'hide-bam-purchase',
				'hidekobopurchase' : 'hide-kobo-purchase',
				'sortoption' : 'sortoption',
				'booksonpage' : 'booksonpage',
				'library': 'library',
				'booksonpage': 'books-per-page'
			};

			console.log(settingsArray);

		  	var data = {
				'action': 'wpbooklist_update_display_options_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_update_display_options_action_callback" ); ?>',
				'library':library
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	response = JSON.parse(response);
			    	console.log(response)
			    	optionsTable.animate({'opacity':'1'}, 500);
			    	lowerTable.animate({'opacity':'1'}, 500);
			    	saveChanges.animate({'opacity':'1'}, 500);
	  				saveChanges.attr('disabled', false);
			    	optionsTableInput.attr('disabled', false);
			    	lowerTableInput.attr('disabled', false);
			    	spinner.animate({'opacity':'0'}, 200);
			    	for (var key in response) {
					  if (response.hasOwnProperty(key)) {
					  	if(response[key] == 1){
					  		var obj = $( "input[name='"+settingsArray[key]+"']" ).prop('checked', true);
					  	}

					  	if(response[key] == 0 || response[key] == null){
					  		var obj = $( "input[name='"+settingsArray[key]+"']" ).prop('checked', false);
					  	}

					  	if(key == 'booksonpage'){
					  		var obj = $( "input[name='books-per-page']" ).val(response[key]);
					  	}

					  	if(key == 'sortoption'){
					  		var obj = $( "#wpbooklist-jre-sorting-select" ).val(response[key]);
					  	}

					  }
					}
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for saving library display options
function wpbooklist_update_display_options_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_update_display_options_action_callback', 'security' );
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);
	$table_name = '';
	if($library == $wpdb->prefix.'wpbooklist_jre_saved_book_log'){
		$table_name = $wpdb->prefix.'wpbooklist_jre_user_options';
	} else {
		$library = explode('_', $library);
		$library = array_pop($library);
		$table_name = $wpdb->prefix.'wpbooklist_jre_settings_'.$library;
	}
	//$var2 = filter_var($_POST['var'],FILTER_SANITIZE_NUMBER_INT);
	$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE ID = %d", 1));
	echo $jsonData = json_encode($row); 
	wp_die();
}

// Function for showing the Edit Book form
function wpbooklist_edit_book_show_form_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click",".wpbooklist-edit-actions-edit-button", function(event){

	  		// Gather info needed to return book data
	  		var bookId = $(this).attr('data-book-id');
	  		var table = $(this).attr('data-table');
	  		var key = $(this).attr('data-key');

	  		// Clear any edit book forms that may already be in dom
			$('.wpbooklist-edit-form-div').html('');

			// Show spinner
			$('#wpbooklist-spinner-'+key).animate({'opacity':'1'})

		  	var data = {
				'action': 'wpbooklist_edit_book_show_form_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_edit_book_show_form_action_callback" ); ?>',
				'bookId':bookId,
				'table':table
			};

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {

			    	
	
			    	// Parse out the response
			    	response = response.split('–sep-seperator-sep–');
			    	var bookInfo = JSON.parse(response[0]);
			    	var editForm = response[1];
			    	
			    	// Add the edit book form into dom and show
			    	$('#wpbooklist-edit-form-div-'+key).html(editForm);
			    	
			    	$('#wpbooklist-edit-form-div-'+key).animate({'opacity':'1'});

			    	$('#wpbooklist-admin-cancel-button').attr('data-key', key);

			    	// Hide spinner
					$('#wpbooklist-spinner-'+key).animate({'opacity':'0'})

			    	// Populate all edit book form fields
			    	$('#wpbooklist-editbook-isbn').val(bookInfo.isbn);
			    	$('#wpbooklist-editbook-title').val(bookInfo.title);
			    	$('#wpbooklist-editbook-author').val(bookInfo.author);
			    	$('#wpbooklist-editbook-category').val(bookInfo.category);
			    	$('#wpbooklist-editbook-price').val(bookInfo.price);
			    	$('#wpbooklist-editbook-pages').val(bookInfo.pages);
			    	$('#wpbooklist-editbook-pubdate').val(bookInfo.pub_year);
			    	$('#wpbooklist-editbook-publisher').val(bookInfo.publisher);
			    	$('#wpbooklist-editbook-subject').val(bookInfo.subject);
			    	$('#wpbooklist-editbook-country').val(bookInfo.country);
			    	$('#wpbooklist-editbook-sale-author-link').val(bookInfo.author_url);

			    	// Populate the purchase links/URLs section
			    	$('#wpbooklist-editbook-books-a-million-buy-link').val(bookInfo.bam_link)
			    	$('#wpbooklist-editbook-amazon-buy-link').val(bookInfo.amazon_detail_page)
			    	$('#wpbooklist-editbook-bn-link').val(bookInfo.bn_link)
			    	$('#wpbooklist-editbook-google-play-buy-link').val(bookInfo.google_preview)
			    	$('#wpbooklist-editbook-itunes-link').val(bookInfo.itunes_page)
			    	$('#wpbooklist-editbook-kobo-link').val(bookInfo.kobo_link)




			    	if(bookInfo.page_yes == 'false' || bookInfo.page_yes == null || bookInfo.page_yes == undefined){
			    		$('#wpbooklist-editbook-page-no').prop('checked', true);
			    		$('#wpbooklist-editbook-page-yes').attr('data-page-id', bookInfo.page_yes);
			    	} else {
			    		$('#wpbooklist-editbook-page-yes').prop('checked', true);
			    		$('#wpbooklist-editbook-page-yes').attr('data-page-id', bookInfo.page_yes);
			    	}

			    	if(bookInfo.post_yes == 'false' || bookInfo.post_yes == null || bookInfo.post_yes == undefined){
			    		$('#wpbooklist-editbook-post-no').prop('checked', true);
			    		$('#wpbooklist-editbook-post-yes').attr('data-post-id', bookInfo.post_yes);
			    	} else {
			    		$('#wpbooklist-editbook-post-yes').prop('checked', true);
			    		$('#wpbooklist-editbook-post-yes').attr('data-post-id', bookInfo.post_yes);
			    	}

					var decoded = $('<textarea/>').html(bookInfo.description).text();
					var decoded2 = $('<textarea/>').html(decoded).text();
					decoded2 = decoded2.replace(/\\/g, "");

			    	$('#wpbooklist-editbook-description').val(decoded2);

			    	var decoded = $('<textarea/>').html(bookInfo.notes).text();
					var decoded2 = $('<textarea/>').html(decoded).text();
					decoded2 = decoded2.replace(/\\/g, "");

			    	$('#wpbooklist-editbook-notes').val(decoded2);

			    	if(bookInfo.rating != null && bookInfo.rating != 0){
			    		$('#wpbooklist-editbook-rating').val(bookInfo.rating)
			    	}

			    	$('#wpbooklist-editbook-image').val(bookInfo.image);
			    	$('#wpbooklist-editbook-preview-img').attr('src', bookInfo.image)

			    	$('#wpbooklist-admin-editbook-button').attr('data-book-id', bookId);
			    	$('#wpbooklist-admin-editbook-button').attr('data-book-uid', bookInfo.book_uid);

			    	if(bookInfo.lendable == 'true'){
			    		$('#wpbooklist-addbook-bookswapper-yes').prop('checked', true);
			    	} else {
			    		$('#wpbooklist-addbook-bookswapper-no').prop('checked', true);
			    	}

			    	$('#wpbooklist-bookswapper-copies').val(bookInfo.copies);


			    	if(bookInfo.finished == 'true'){
			    		$('#wpbooklist-editbook-finished-yes').prop('checked', true);

			    		var dateFinished = bookInfo.date_finished.split('-');
			    		dateFinished = dateFinished[2]+'-'+dateFinished[0]+'-'+dateFinished[1];

			    		$('#wpbooklist-editbook-date-finished').val(dateFinished)
			    		$('#wpbooklist-editbook-date-finished').css({'opacity':'1'});
			    	} else {
			    		$('#wpbooklist-editbook-finished-no').prop('checked', true);
			    	}

			    	if(bookInfo.signed == 'true'){
			    		$('#wpbooklist-editbook-signed-yes').prop('checked', true);
			    	} else {
			    		$('#wpbooklist-editbook-signed-no').prop('checked', true);
			    	}

			    	if(bookInfo.first_edition == 'true'){
			    		$('#wpbooklist-editbook-firstedition-yes').prop('checked', true);
			    	} else {
			    		$('#wpbooklist-editbook-firstedition-no').prop('checked', true);
			    	}

			    	// Populate all WooCommerce fields
			    	if(response[2] != 'null'){

			    		var crosssellsids = '';
			    		var crosssellstitles = '';
			    		var upsellsids = '';
			    		var upsellstitles = '';
			    		var cat = '';
			    		var filename = '';

			    		if(response[3] != 'null'){
					    	var storefront = response[3];
					    	// Activate the select2 code if the storefront extension is active
					    	if(storefront == 'true'){
					    		$('.select2-input').select2();
					    	}
					    }

					    if(response[4] != 'null'){
					    	crosssellsids = response[4];
					    }

					    if(response[5] != 'null'){
					    	crosssellstitles = response[5];

					    	crosssellstitles = response[5];
					    	if(crosssellstitles.includes(',')){
					    		var crosssellArray = crosssellstitles.split(',');
					    	} else {
					    		var crosssellArray = crosssellstitles;
					    	}

					    	$("#select2-crosssells").val(crosssellArray).trigger('change');
					    }

					    if(response[6] != 'null'){
					    	upsellsids = response[6];
					    }

					    if(response[7] != 'null'){
					    	upsellstitles = response[7];
					    	if(upsellstitles.includes(',')){
					    		var upsellArray = upsellstitles.split(',');
					    	} else {
					    		var upsellArray = upsellstitles;
					    	}

					    	$("#select2-upsells").val(upsellArray).trigger('change');
				    	}

				    	if(response[8] != 'null'){
					    	cat = response[8];
				    	}

				    	if(response[9] != 'null'){
					    	filename = response[9];
				    	}

			    		var productInfo = JSON.parse(response[2]);
			    		console.log(productInfo);
			    		// Populate all WooCommerce fields
			    		if(bookInfo.woocommerce != '' && bookInfo.woocommerce != null){
			    			$('#wpbooklist-woocommerce-yes').prop('checked', true);
			    			$('.wpbooklist-woo-row').css({'opacity':'1', 'display':'table-row'})

			    			$('#wpbooklist-addbook-woo-regular-woo-price').val(productInfo._price)
			    			$('#wpbooklist-addbook-woo-sale-price').val(productInfo._sale_price)
			    			$('#wpbooklist-addbook-woo-salebegin').val(productInfo._sale_price_dates_from)
			    			$('#wpbooklist-addbook-woo-saleend').val(productInfo._sale_price_dates_to)
			    			$('#wpbooklist-addbook-woo-width').val(productInfo._width)
			    			$('#wpbooklist-addbook-woo-height').val(productInfo._height)
			    			$('#wpbooklist-addbook-woo-length').val(productInfo._length)
			    			$('#wpbooklist-addbook-woo-weight').val(productInfo._weight)
			    			$('#wpbooklist-addbook-woo-sku').val(productInfo._sku)
			    			$('#wpbooklist-addbook-woo-stock').val(productInfo._stock)
			    			$('#wpbooklist-editbook-woo-note').val(productInfo._purchase_note)

			    			

			    			$('#wpbooklist-woocommerce-category-select').val(cat);

			    			if(productInfo._virtual == 'true'){
			    				$('#wpbooklist-woocommerce-vert-yes').prop('checked', true);
			    				$('#wpbooklist-woo-row-upload').css({'opacity':'1', 'display':'table-row'})
			    			}

			    			if(productInfo._downloadable == 'true'){
			    				$('#wpbooklist-woocommerce-download-yes').prop('checked', true)
			    				$('#wpbooklist-woocommerce-download-no').prop('checked', false)
			    				$('.wpbooklist-woo-row-upload').css({'opacity':'1', 'display':'table-row'})
			    			}

			    			if(filename != '' && filename != null && filename != undefined){
			    				$('#wpbooklist-storefront-uploaded-files-title').html(filename)
			    			}

			    			if(response[10] != '' && response[10]  != null && response[10]  != undefined){
			    				$('#wpbooklist-storefront-preview-img-1').attr('data-id', response[10]);
			    			}

console.log(response[7])
			    			//$('#wpbooklist-woocommerce-review-yes')



			    			

			    		}
			    	}

			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});

		// If the 'Cancel' button is clicked, reset all UI/Dom elements
		$(document).on("click","#wpbooklist-admin-cancel-button", function(event){

			var key = $(this).attr('data-key');
			var scrollTop = $("#wpbooklist-edit-book-indiv-div-id-"+key).offset().top-50

			// Clear any edit book forms that may already be in dom and hide edit form
			$('.wpbooklist-edit-form-div').animate({'opacity':'0'})
			$('.wpbooklist-edit-book-indiv-div-class').animate({'height':'100'},500)

			$('.wpbooklist-edit-book-indiv-div-class').animate({
			    'height':'100'
			}, {
			    queue: false,
			    duration: 500,
			    complete: function() {
			    	$('.wpbooklist-edit-form-div').html('');
					$('.wpbooklist-edit-book-indiv-div-class').css({'height':'auto'})

					// Scrolls back to the top of the title 
				    if(scrollTop != 0){
				      $('html, body').animate({
				        scrollTop: scrollTop
				      }, 500);
				      scrollTop = 0;
				    }


			    }
			});
		});
	});
	</script>
	<?php
}

// Callback Function for showing the Edit Book form
function wpbooklist_edit_book_show_form_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_edit_book_show_form_action_callback', 'security' );
	$book_id = filter_var($_POST['bookId'],FILTER_SANITIZE_NUMBER_INT);
	$table = filter_var($_POST['table'],FILTER_SANITIZE_STRING);
	$book_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE ID = %d",$book_id));
	$crosssell_ids = '';
	$crosssell_titles = '';
	$upsell_ids = '';
	$upsell_titles = '';
	$product = 'null';
	$image_thumb = array();
	$id = null;
	$image_url["file"] = '';
	$image_url["name"] = '';
	$attachment = array();

	// Get Woocommerce product, if one exists
	// $product = array();
	$cat = '';
	if($book_data->woocommerce != null){
		//$product = wc_get_product( $book_data->woocommerce );
		$product = get_post_meta($book_data->woocommerce); 

		// Get all downloadable files associated with product
		if(array_key_exists('_downloadable_files', $product) && array_key_exists(0, $product["_downloadable_files"])){
			$df = json_encode(current(unserialize($product["_downloadable_files"][0])));
			$image_url = current(unserialize($product["_downloadable_files"][0]));
			$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url["file"] ));

			if(is_array($attachment) && array_key_exists(0, $attachment)){
				$image_thumb = wp_get_attachment_image_src($attachment[0], 'thumbnail');
			}
		}
		//$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
		//$image_url = $attachment[0]

		// Get crosssell IDs and titles
		$cs = unserialize($product["_crosssell_ids"][0]);
		foreach ($cs as $key => $value) {
		    $crosssell_ids = $crosssell_ids.','.$value;
		}

		// Get upsell IDs and titles
		$us = unserialize($product["_upsell_ids"][0]);
		foreach ($us as $key => $value) {
		    $upsell_ids = $upsell_ids.','.$value;
		}

		// Get product category
		$cat = get_the_terms ( $book_data->woocommerce, 'product_cat' );
		if(is_array($cat) && array_key_exists(0, $cat)){
			$cat = $cat[0]->name;
		} else {
			$cat = '';
		}

		$product = json_encode($product);
	}

	require_once(CLASS_DIR.'class-book.php');
	$form = new WPBookList_Book;
	$edit_form = $form->display_edit_book_form();

	// Convert html entites back to normal as needed
	$book_data->title = stripslashes(html_entity_decode($book_data->title, ENT_QUOTES | ENT_XML1, 'UTF-8'));

	// Encode all book data for return trip
	$book_data = json_encode($book_data);

	// Check to see if Storefront extension is active
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if(is_plugin_active('wpbooklist-storefront/wpbooklist-storefront.php')){
		$storefront = 'true';
	} else {
		$storefront = 'false';
	}


	if(is_array($attachment) && array_key_exists(0, $attachment)){
		$attachment = $attachment[0];
	} else {
		$attachment = '';
	}

	

	echo $book_data.'–sep-seperator-sep–'.$edit_form.'–sep-seperator-sep–'.$product.'–sep-seperator-sep–'.$storefront.'–sep-seperator-sep–'.$crosssell_ids.'–sep-seperator-sep–'.$crosssell_ids.'–sep-seperator-sep–'.$upsell_ids.'–sep-seperator-sep–'.$upsell_ids.'–sep-seperator-sep–'.$cat.'–sep-seperator-sep–'.basename($image_url["file"]).'–sep-seperator-sep–'.$attachment;

	wp_die();
}


function wpbooklist_edit_book_pagination_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

  		// Set initial offset in dom
  		$('.wpbooklist-admin-tp-top-title').attr('data-offset', 0);
		
		// Get offset value from wpbooklist.php, convert to int
		var offset = '<?php echo EDIT_PAGE_OFFSET; ?>';
		offset = parseInt(offset);


		$(document).on("click","#wpbooklist-edit-next-100, #wpbooklist-edit-previous-100", function(event){

			// Grabbing library
			var library =  $("#wpbooklist-editbook-select-library").val();

			// Grabbing offset from dom
			var currentOffset = parseInt($('.wpbooklist-admin-tp-top-title').attr('data-offset'));

			// Grabbing total number of books in library
			var limit = parseInt($(this).attr('data-limit'));

			// Ensuring we don't go backwards if we're already on the first set results
			if($(this).attr('id') == 'wpbooklist-edit-previous-100'){
				var direction = 'back';
			} else {
				var direction = 'forward';
			}

			// Ensuring we don't go backwards if we're already on the first set results
			if(direction == 'back' &&  (currentOffset-offset) < 0){
				console.log('returnback');
				return;
			}

			// Ensuring we don't go over the total # of books in library
			if(direction == 'forward' &&  (currentOffset+offset) > limit){
				console.log('returnforward');
				return;
			}

			// Initial UI Stuff
			$('.wpbooklist-edit-book-indiv-div-class').animate({'opacity':'0.3'}, 500);
			$('#wpbooklist-spinner-pagination').animate({'opacity':'1'},500);

			if(direction == 'forward'){
				currentOffset = currentOffset+offset;
				$('.wpbooklist-admin-tp-top-title').attr('data-offset', currentOffset);
			} else {
				currentOffset = currentOffset-offset;
				$('.wpbooklist-admin-tp-top-title').attr('data-offset', currentOffset);
			}

			var data = {
				'action': 'wpbooklist_edit_book_pagination_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_edit_book_pagination_action_callback" ); ?>',
				'currentOffset':currentOffset,
				'library':library
			};

			var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data: data,
			    timeout: 0,
			    success: function(response) {

			    	response = response.split('_Separator_');

			    	// Resetting iniail UI stuff
			    	$('.wpbooklist-edit-book-indiv-div-class').animate({'opacity':'1'}, 500);
					$('#wpbooklist-spinner-pagination').animate({'opacity':'0'},500);

			    	// Clear existing books and replace with the response
			    	$('.wpbooklist-admin-tp-inner-container').html('');
			    	$('.wpbooklist-admin-tp-inner-container').html(response[0]);

			    	// Resetting table drop-down
			    	$("#wpbooklist-editbook-select-library").val(response[1]);

			    	if(direction == 'back' &&  (currentOffset-offset) < 0){
						$('#wpbooklist-edit-previous-100').css({'pointer-events':'none', 'opacity':'0.3'});
					} else {
						$('#wpbooklist-edit-previous-100').css({'pointer-events':'all', 'opacity':'1'});
					}

					if(direction == 'forward' &&  (currentOffset+offset) > limit){
						$('#wpbooklist-edit-next-100').css({'pointer-events':'none', 'opacity':'0.3'});
					} else {
						$('#wpbooklist-edit-next-100').css({'pointer-events':'all', 'opacity':'1'});
					}

					$('html, body').animate({
				        scrollTop: $("#wpbooklist-bulk-edit-mode-on-button").offset().top-100
				    }, 1000);
			    }

			});
		});
	});
	</script>
	<?php
}

// Callback function for the Edit Book pagination 
function wpbooklist_edit_book_pagination_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_edit_book_pagination_action_callback', 'security' );
	$currentOffset = filter_var($_POST['currentOffset'],FILTER_SANITIZE_NUMBER_INT);
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);

	require_once(CLASS_DIR.'class-edit-book-form.php');
	$form = new WPBookList_Edit_Book_Form;
	echo $form->output_edit_book_form($library, $currentOffset).'_Separator_'.$library;
	wp_die();
}

// Function for switching libraries on the Edit Book tab
function wpbooklist_edit_book_switch_lib_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("change","#wpbooklist-editbook-select-library", function(event){

  			var library =  $("#wpbooklist-editbook-select-library").val();

  			if(window.location.href.includes('library=') && window.location.href.includes('tab=') && window.location.href.includes('WPBookList')){
  				var newUrl = (window.location.href.substr(0, window.location.href.lastIndexOf("&")))+'&library='+library;
  			} else {
  				var newUrl = window.location.href+'&library='+library;
  			}

  			window.history.pushState(null,null,newUrl);

  			// Reset offset
  			$('.wpbooklist-admin-tp-top-title').attr('data-offset', 0);

  			// Initial UI Stuff
  			$('#wpbooklist-search-results-info').css({'opacity':'0'});
  			$('.wpbooklist-edit-book-indiv-div-class').animate({'opacity':'0.3'}, 500);
			$('#wpbooklist-spinner-edit-change-lib').animate({'opacity':'1'},500);

		  	var data = {
				'action': 'wpbooklist_edit_book_switch_lib_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_edit_book_switch_lib_action_callback" ); ?>',
				'library':library
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {

			    	response = response.split('_Separator_');
			    	$('#wpbooklist-spinner-edit-change-lib').animate({'opacity':'1'},500);

			    	// Clear existing books and replace with the response
			    	$('.wpbooklist-admin-tp-inner-container').html('');
			    	$('.wpbooklist-admin-tp-inner-container').html(response[0]);
			    	$("#wpbooklist-editbook-select-library").val(response[1]);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback Function for switching libraries on the Edit Book tab
function wpbooklist_edit_book_switch_lib_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_edit_book_switch_lib_action_callback', 'security' );
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);

	require_once(CLASS_DIR.'class-edit-book-form.php');
	$form = new WPBookList_Edit_Book_Form;
	echo $form->output_edit_book_form($library, 0).'_Separator_'.$library;

	wp_die();
}

// Function for searching for a title to edit
function wpbooklist_edit_book_search_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$(document).on('click', "#wpbooklist-edit-book-search-button", function(event){

	  		// Initial UI Stuff
	  		$('#wpbooklist-search-results-info').css({'opacity':'0'});
  			$('.wpbooklist-edit-book-indiv-div-class').animate({'opacity':'0.3'}, 500);
			$('#wpbooklist-spinner-edit-change-lib').animate({'opacity':'1'},500);

	  		var searchTerm = $('#wpbooklist-edit-book-search-input').val();
	  		var authorCheck = $('#wpbooklist-search-author-checkbox').prop('checked');
	  		var titleCheck = $('#wpbooklist-search-title-checkbox').prop('checked');
	  		var library =  $("#wpbooklist-editbook-select-library").val();

		  	var data = {
				'action': 'wpbooklist_edit_book_search_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_edit_book_search_action_callback" ); ?>',
				'searchTerm':searchTerm,
				'authorCheck':authorCheck,
				'titleCheck':titleCheck,
				'library':library
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	response = response.split('_Separator_');
			    	$('#wpbooklist-spinner-edit-change-lib').animate({'opacity':'1'},500);

			    	// Clear existing books and replace with the response
			    	$('.wpbooklist-admin-tp-inner-container').html('');
			    	$('.wpbooklist-admin-tp-inner-container').html(response[0]);
			    	$("#wpbooklist-editbook-select-library").val(response[1]);

			    	// UI Stuff
			    	var library = $("#wpbooklist-editbook-select-library").children("option:selected").text();
			    	if(library == 'Default Library'){
			    		library = 'Default';
			    	}

			    	if(response[2] == 1 || response[2] == '1'){
			    		var responseText = '<span class="wpbooklist-color-orange-italic">'+response[2]+' Result</span> Found from the '+library+' Library';
			    	} else {
			    		var responseText = '<span class="wpbooklist-color-orange-italic">'+response[2]+' Results</span> Found from the '+library+' Library';
			    	}

			    	$('#wpbooklist-search-results-info').html(responseText);
			    	$('#wpbooklist-search-results-info').css({'opacity':'1'});
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback Function for searching for a title to edit
function wpbooklist_edit_book_search_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_edit_book_search_action_callback', 'security' );
	$search_term = filter_var($_POST['searchTerm'],FILTER_SANITIZE_STRING);
	$author_check = filter_var($_POST['authorCheck'],FILTER_SANITIZE_STRING);
	$title_check = filter_var($_POST['titleCheck'],FILTER_SANITIZE_STRING);
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);

	if($title_check == 'true'){
		$search_mode = 'title';
	}

	if($author_check == 'true'){
		$search_mode = 'author';
	}

	if($author_check == 'true' && $title_check == 'true'){
		$search_mode = 'both';
	}

	if($author_check != 'true' && $title_check != 'true'){
		$search_mode = 'both';
	}

	require_once(CLASS_DIR.'class-edit-book-form.php');
	$form = new WPBookList_Edit_Book_Form;
	echo $form->output_edit_book_form($library, 0, $search_mode, $search_term).'_Separator_'.$library.'_Separator_'.$form->limit;
	wp_die();
}

function wpbooklist_edit_book_actual_action_javascript() { 
	$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );

	// Translations
	$trans1 = __('Success!', 'wpbooklist');
	$trans2 = __("You've just edited your book! Remember, to display your library, simply place this shortcode on a page or post:", 'wpbooklist');
	$trans3 = __('Click Here to View Your Edited Book', 'wpbooklist');
	$trans4 = __("Click Here to View This Book's Post", 'wpbooklist');
	$trans5 = __("Click Here to View This Book's Page", 'wpbooklist');
	$trans6 = __("Thanks for using WPBookList, and", 'wpbooklist');
	$trans7 = __("be sure to check out the WPBookList Extensions!", 'wpbooklist');
	$trans8 = __("If you happen to be thrilled with WPBookList, then by all means,", 'wpbooklist');
	$trans9 = __("Feel Free to Leave a 5-Star Review Here!", 'wpbooklist');
	$trans10 = __("Whoops! Looks like there was an error trying to add your book! Please check the information you provided (especially that ISBN number), and try again.", 'wpbooklist');
	$trans11 = __("WPBookList Tech Support at TechSupport@WPBookList.com:", 'wpbooklist');
	$trans12 = __('Hmmm...', 'wpbooklist');
	$trans13 = __("Your book was edited, but it looks like there was a problem grabbing book info from Amazon. Try manually entering your book information, or wait a few seconds and try again, as sometimes Amazon gets confused. Remember, you don't", 'wpbooklist');
	$trans14 = __("HAVE", 'wpbooklist');
	$trans15 = __("to gather info from Amazon - WPBookList can work completely independently of Amazon.", 'wpbooklist');


	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

  		// For the book cover image upload
		var file_frame;
		var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
		var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this

		$(document).on("click","#wpbooklist-editbook-upload_image_button", function(event){
			event.preventDefault();
			// If the media frame already exists, reopen it.
			if ( file_frame ) {
			  // Set the post ID to what we want
			  file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
			  // Open frame
			  file_frame.open();
			  return;
			} else {
			  // Set the wp.media post id so the uploader grabs the ID we want when initialised
			  wp.media.model.settings.post.id = set_to_post_id;
			}
			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
			  title: 'Select a image to upload',
			  button: {
			    text: 'Use this image',
			  },
			  multiple: false // Set to true to allow multiple files to be selected
			});
			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
			  // We set multiple to false so only get one image from the uploader
			  var attachment = file_frame.state().get('selection').first().toJSON();
			  // Do something with attachment.id and/or attachment.url here
			  $( '#wpbooklist-editbook-image' ).val(attachment.url);
			  $( '#wpbooklist-editbook-preview-img' ).attr('src', attachment.url);
			  // Restore the main post ID
			  wp.media.model.settings.post.id = wp_media_post_id;
			});
			  // Finally, open the modal
			  file_frame.open();
			});
			// Restore the main ID when the add media button is pressed
			jQuery( 'a.add_media' ).on( 'click', function() {
			wp.media.model.settings.post.id = wp_media_post_id;
		});

  		$(document).on("click","#wpbooklist-admin-editbook-button", function(event){
			var successDiv = $('#wpbooklist-editbook-success-div');
	  		successDiv.html('');
	  		$('#wpbooklist-editbook-signed-first-table').animate({'margin-bottom':'40px'}, 500);
			$('#wpbooklist-success-view-post').animate({'opacity':'0'}, 500);

    		wpbooklist_add_book_validator();
    		var error = $('#wpbooklist-add-book-error-check').attr('data-add-book-form-error');

    		var woocommerce = false;
    		var woofile = '';
    		var amazonAuthYes = $( "input[name='authorize-amazon-yes']" ).prop('checked');
			var library = $('#wpbooklist-editbook-select-library').val();
			var useAmazonYes = $("input[name='use-amazon-yes']").prop('checked');
			var isbn = $( "input[name='book-isbn']" ).val();
			var title = $( "input[name='book-title']" ).val();
			var author = $( "input[name='book-author']" ).val();
			var authorUrl = $( "input[name='book-sale-author-link']" ).val();
			var category = $( "input[name='book-category']" ).val();
			var price = $( "input[name='book-price']" ).val();
			var pages = $( "input[name='book-pages']" ).val();
			var pubYear = $( "input[name='book-pubdate']" ).val();
			var publisher = $( "input[name='book-publisher']" ).val();
			var description = $( "textarea[name='book-description']" ).val();
			var subject = $( "input[name='book-subject']" ).val();
			var country = $( "input[name='book-country']" ).val();
			var notes = $( "textarea[name='book-notes']" ).val();
			var rating = $('#wpbooklist-editbook-rating').val();
			var image = $("input[name='book-image']").val();
			var finished = $("input[name='book-finished-yes']").prop('checked');
			var dateFinished = $("input[name='book-date-finished-text']").val();
			var signed = $("input[name='book-signed-yes']").prop('checked');
			var firstEdition = $("input[name='book-firstedition-yes']").prop('checked');
			var pageYes = $("input[name='book-indiv-page-yes']").prop('checked');
			var postYes = $("input[name='book-indiv-post-yes']").prop('checked');
			var lendable = $("input[name='book-bookswapper-yes']").prop('checked');
			var copies = $("#wpbooklist-bookswapper-copies").val();
			var woocommerce = $("input[name='book-woocommerce-yes']").prop('checked');
			var salePrice = $( "input[name='book-woo-sale-price']" ).val();
			var regularPrice = $( "input[name='book-woo-regular-price']" ).val();
			var stock = $( "input[name='book-woo-stock']" ).val();
			var length = $( "input[name='book-woo-length']" ).val();
			var width = $( "input[name='book-woo-width']" ).val();
			var height = $( "input[name='book-woo-height']" ).val();
			var weight = $( "input[name='book-woo-weight']" ).val();
			var sku = $("#wpbooklist-addbook-woo-sku").val();
			var virtual = $("input[name='wpbooklist-woocommerce-vert-yes']").prop('checked');
			var download = $("input[name='wpbooklist-woocommerce-download-yes']").prop('checked');
			var woofile = $('#wpbooklist-storefront-preview-img-1').attr('data-id');
			var salebegin = $('#wpbooklist-addbook-woo-salebegin').val();
			var saleend = $('#wpbooklist-addbook-woo-saleend').val();
			var purchasenote = $('#wpbooklist-editbook-woo-note').val();
			var productcategory = $('#wpbooklist-woocommerce-category-select').val();
			var reviews = $('#wpbooklist-woocommerce-review-yes').val();
			var upsells = $('#select2-upsells').val();
			var crosssells = $('#select2-crosssells').val();
			var amazonbuylink = $( "input[name='amazon-purchase-link']" ).val();
			var bnbuylink = $( "input[name='bn-link']" ).val();
			var googlebuylink = $( "input[name='google-purchase-link']" ).val();
			var itunesbuylink = $( "input[name='itunes-link']" ).val();
			var booksamillionbuylink = $( "input[name='booksamillion-purchase-link']" ).val();
			var kobobuylink = $( "input[name='kobo-link']" ).val();


			var upsellString = '';
			var crosssellString = '';

			// Making checks to see if Storefront extension is active
			if(upsells != undefined){
				for (var i = 0; i < upsells.length; i++) {
					upsellString = upsellString+','+upsells[i];
				};
			}

			if(crosssells != undefined){
				for (var i = 0; i < crosssells.length; i++) {
					crosssellString = crosssellString+','+crosssells[i];
				};
			}

			if(salebegin != undefined && saleend != undefined){
				// Flipping the sale date start
				if(salebegin.indexOf('-')){
					var finishedtemp = salebegin.split('-');
					salebegin = finishedtemp[0]+'-'+finishedtemp[1]+'-'+finishedtemp[2]
				}

				// Flipping the sale date end
				if(saleend.indexOf('-')){
					var finishedtemp = saleend.split('-');
					saleend = finishedtemp[0]+'-'+finishedtemp[1]+'-'+finishedtemp[2]
				}	
			}


			if(lendable == true && copies == 0){
				copies = 1;
			}

			// Flipping the date
			if(dateFinished.indexOf('-')){
				var finishedtemp = dateFinished.split('-');
				var dateFinished = finishedtemp[1]+'-'+finishedtemp[2]+'-'+finishedtemp[0]
			}

			var pageId = $('#wpbooklist-editbook-page-yes').attr('data-page-id');
			var postId = $('#wpbooklist-editbook-post-yes').attr('data-post-id');
			var bookId = $(this).attr('data-book-id');
			var bookUid = $(this).attr('data-book-uid');

    		if(error === 'false'){
    			// Show working spinner
    			$('#wpbooklist-spinner-edit-indiv').animate({'opacity':'1'}, 500);
    			
	    		var data = {
					'action': 'wpbooklist_edit_book_actual_action',
					'security': '<?php echo wp_create_nonce( "wpbooklist_edit_book_actual_action_callback" ); ?>',
					'amazonAuthYes':amazonAuthYes,
					'library':library,
					'useAmazonYes':useAmazonYes,
					'isbn':isbn,
					'title':title,
					'author':author,
					'authorUrl':authorUrl,
					'category':category,
					'price':price,
					'pages':pages,
					'pubYear':pubYear,
					'publisher':publisher,
					'description':description,
					'subject':subject,
					'country':country,
					'notes':notes,
					'rating':rating,
					'image':image,
					'finished':finished,
					'dateFinished':dateFinished,
					'signed':signed,
					'firstEdition':firstEdition,
					'pageYes':pageYes,
					'postYes':postYes,
					'lendable':lendable,
					'copies':copies,
					'pageId':pageId,
					'postId':postId,
					'bookId':bookId,
					'bookUid':bookUid,
					'woocommerce':woocommerce,
					'saleprice':salePrice,
					'regularprice':regularPrice,
					'stock':stock,
					'length':length,
					'width':width,
					'height':height,
					'weight':weight,
					'sku':sku,
					'virtual':virtual,
					'download':download,
					'woofile':woofile,
					'salebegin':salebegin,
					'saleend':saleend,
					'purchasenote':purchasenote,
					'productcategory':productcategory,
					'reviews':reviews,
					'upsells':upsellString,
					'crosssells':crosssellString,
					'amazonbuylink':amazonbuylink,
					'bnbuylink':bnbuylink,
					'googlebuylink':googlebuylink,
					'itunesbuylink':itunesbuylink,
					'booksamillionbuylink':booksamillionbuylink,
					'kobobuylink':kobobuylink
				};
				console.log(data);

		     	var request = $.ajax({
				    url: ajaxurl,
				    type: "POST",
				    data:data,
				    timeout: 0,
				    success: function(response) {

				    	response = response.split('--sep--');
						
				    	if(response[0] == 1){

				    		var apicallreport = response[8];
					    	var whichapifound = JSON.parse(response[9]);

					    	console.log(apicallreport)
					    	console.log("Here's the report for where the this book's data was obtained from:");
					    	console.log(whichapifound)

					    	var amazonapifailcount = response[10];
					    	console.log('The Amazon Fail Count was: '+amazonapifailcount);


				    		if(useAmazonYes){
				    			if(amazonapifailcount == 2 || amazonapifailcount == '2'){
				    				var editbookSuccess1 = "<p><span id='wpbooklist-add-book-success-span'><?php echo $trans12; ?></span><br/> <?php echo $trans13; ?><em> <?php echo $trans14; ?> </em><?php echo $trans15; ?>";
					    		} else {
					    			var editbookSuccess1 = "<p><span id='wpbooklist-add-book-success-span'><?php echo $trans1; ?></span><br/>&nbsp;<?php echo $trans2 ; ?>&nbsp;<span id='wpbooklist-editbook-success-shortcode'>"; 
					    		}
				    		} else {
				    			var editbookSuccess1 = "<p><span id='wpbooklist-add-book-success-span'><?php echo $trans1; ?></span><br/>&nbsp;<?php echo $trans2 ; ?>&nbsp;<span id='wpbooklist-editbook-success-shortcode'>"; 
				    		}




				    		
				    		if(library == response[7]+'wpbooklist_jre_saved_book_log'){
				    			var shortcode = '[wpbooklist_shortcode]'
				    		} else {
				    			library = library.split('_');
				    			library = library[library.length-1];
				    			var shortcode = '[wpbooklist_shortcode table="'+library+'"]'
				    		}
				    		
				    		var editbookSuccess2 = shortcode+'</span></p><a id="wpbooklist-success-1" class="wpbooklist-show-book-colorbox"><?php echo $trans3; ?></a>';


							if(useAmazonYes){
				    			if(amazonapifailcount == 2 || amazonapifailcount == '2'){
				    				var editbookSuccess2 = '</span></p><a id="wpbooklist-success-1" class="wpbooklist-show-book-colorbox"><?php echo $trans3; ?></a>';
					    		} else {
					    			var editbookSuccess2 = shortcode+'</span></p><a id="wpbooklist-success-1" class="wpbooklist-show-book-colorbox"><?php echo $trans3; ?></a>';
					    		}
				    		} else {
				    			var editbookSuccess2 = shortcode+'</span></p><a id="wpbooklist-success-1" class="wpbooklist-show-book-colorbox"><?php echo $trans3; ?></a>';
				    		}

				    		var editbookSuccess3 = '';

				    		// If book addition was succesful and user chose to create a post
				    		if(response[4] == 'true' && response[3] == 'false'){
				    			var editbookSuccess3 = "<p id='wpbooklist-editbook-success-post-p'><a href='"+response[6]+"'><?php echo $trans4; ?></a></p></div>";
				    			$('#wpbooklist-editbook-signed-first-table').animate({'margin-bottom':'70px'}, 500);
				    			$('#wpbooklist-success-view-post').animate({'opacity':'1'}, 500);
				    		} 

				    		// If book addition was succesful and user chose to create a page
				    		if(response[3] == 'true' && response[4] == 'false'){
				    			var editbookSuccess3 = "<p id='wpbooklist-editbook-success-page-p'><a href='"+response[5]+"'><?php echo $trans5; ?></a></p></div>";
				    			$('#wpbooklist-editbook-signed-first-table').animate({'margin-bottom':'70px'}, 500);
				    			$('#wpbooklist-success-view-page').animate({'opacity':'1'}, 500);
				    		} 

				    		// If book addition was succesful and user chose to create a post and a page
				    		if(response[3] == 'true' && response[4] == 'true'){
				    			var editbookSuccess3 = "<p id='wpbooklist-editbook-success-page-p'><a href='"+response[5]+"'><?php echo $trans5; ?></a></p><p id='wpbooklist-editbook-success-post-p'><a href='"+response[6]+"'><?php echo $trans4; ?></a></p></div>";
				    			$('#wpbooklist-editbook-signed-first-table').animate({'margin-bottom':'100px'}, 500);
				    			$('#wpbooklist-success-view-page').animate({'opacity':'1'}, 500);
				    			$('#wpbooklist-success-view-post').animate({'opacity':'1'}, 500);
				    		} 

				    		// Add response message to DOM
				    		var endMessage = '<div id="wpbooklist-editbook-success-thanks"><?php echo $trans6; ?> <a href="http://wpbooklist.com/index.php/extensions/"><?php echo $trans7; ?></a><br/><br/> <?php echo $trans8; ?> <a id="wpbooklist-editbook-success-review-link" href="https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5" ><?php echo $trans9; ?></a><img id="wpbooklist-smile-icon-1" src="<?php echo ROOT_IMG_ICONS_URL; ?>smile.png"></div>';
				    		successDiv.html(editbookSuccess1+editbookSuccess2+editbookSuccess3+endMessage);

				    		$('#wpbooklist-spinner-edit-indiv').animate({'opacity':'0'}, 500);
				    		$('#wpbooklist-success-1').animate({'opacity':'1'}, 500);
				    		$('#wpbooklist-success-1').attr('data-bookid', response[1]);
				    		$('#wpbooklist-success-1').attr('data-booktable', response[2]);
				    	} else {
				    		$('#wpbooklist-editbook-signed-first-table').animate({'margin-bottom':'65px'}, 500);
				    		$('#wpbooklist-success-1').html('<?php echo $trans10; ?>');
				    		$('#wpbooklist-spinner-edit-indiv').animate({'opacity':'0'}, 500);
				    		$('#wpbooklist-success-1').animate({'opacity':'1'}, 500);
				    	}
				    },
					error: function(jqXHR, textStatus, errorThrown) {
						$('#wpbooklist-success-1').html('<?php echo $trans10; ?>');
			    		$('#wpbooklist-spinner-edit-indiv').animate({'opacity':'0'}, 500);
			    		$('#wpbooklist-success-1').animate({'opacity':'1'}, 500);
						console.log(errorThrown);
			            console.log(textStatus);
			            console.log(jqXHR);
			            // TODO: Log the console errors here
					}
				});
	     	}
	  	});
	});
	</script>
	<?php
}

// Callback function editing a book
function wpbooklist_edit_book_actual_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_edit_book_actual_action_callback', 'security' );
	
	// First set the variables we'll be passing to class-book.php to ''
	$amazon_auth_yes = '';    
	$library = '';    
	$use_amazon_yes = '';    
	$isbn = '';    
	$title = '';    
	$author = '';    
	$author_url = '';    
	$category = '';    
	$price = '';    
	$pages = '';    
	$pub_year = '';    
	$publisher = '';    
	$description = '';    
	$subject = '';    
	$country = '';    
	$notes = '';    
	$rating = '';    
	$image = '';    
	$finished = '';    
	$date_finished = '';    
	$signed = '';    
	$first_edition = '';    
	$page_yes = '';    
	$post_yes = '';    
	$lendable = '';    
	$copies = '';    
	$page_id = '';    
	$post_id = '';    
	$book_uid = '';    
	$book_id = '';    
	$woocommerce = '';    
	$saleprice = '';    
	$regularprice = '';    
	$stock = '';    
	$length = '';    
	$width = '';    
	$height = '';    
	$weight = '';    
	$sku = '';    
	$virtual = '';    
	$download = '';    
	$woofile = '';    
	$salebegin = '';    
	$saleend = '';    
	$purchasenote = '';    
	$productcategory = '';    
	$reviews = '';    
	$crosssells = '';    
	$upsells = '';    
	$amazonbuylink = '';    
	$bnbuylink = '';    
	$googlebuylink = '';    
	$itunesbuylink = '';    
	$booksamillionbuylink = '';    
	$kobobuylink = ''; 

	if(isset($_POST['amazonAuthYes'])){
		$amazon_auth_yes = filter_var($_POST['amazonAuthYes'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['library'])){
		$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['useAmazonYes'])){
		$use_amazon_yes = filter_var($_POST['useAmazonYes'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['isbn'])){
		$isbn = filter_var($_POST['isbn'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['title'])){
		$title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['author'])){
		$author = filter_var($_POST['author'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['authorUrl'])){
		$author_url = filter_var($_POST['authorUrl'],FILTER_SANITIZE_URL);
	}

	if(isset($_POST['category'])){
		$category = filter_var($_POST['category'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['price'])){
		$price = filter_var($_POST['price'],FILTER_SANITIZE_STRING);
	}	

	if(isset($_POST['pages'])){
		$pages = filter_var($_POST['pages'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['pubYear'])){
		$pub_year = filter_var($_POST['pubYear'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['publisher'])){
		$publisher = filter_var($_POST['publisher'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['description'])){
		$description = filter_var(htmlentities($_POST['description']),FILTER_SANITIZE_STRING);
	}	

	if(isset($_POST['subject'])){
		$subject = filter_var($_POST['subject'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['country'])){
		$country = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['notes'])){
		$notes = filter_var(htmlentities($_POST['notes']),FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['rating'])){
		$rating = filter_var($_POST['rating'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['image'])){
		$image = filter_var($_POST['image'],FILTER_SANITIZE_URL);
	}

	if(isset($_POST['finished'])){
		$finished = filter_var($_POST['finished'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['dateFinished'])){
		$date_finished = filter_var($_POST['dateFinished'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['signed'])){
		$signed = filter_var($_POST['signed'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['firstEdition'])){
		$first_edition = filter_var($_POST['firstEdition'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['pageYes'])){
		$page_yes = filter_var($_POST['pageYes'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['postYes'])){
		$post_yes = filter_var($_POST['postYes'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['lendable'])){
		$signed = filter_var($_POST['lendable'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['copies'])){
		$copies = filter_var($_POST['copies'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['pageId'])){
		$page_yes = filter_var($_POST['pageId'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['postId'])){
		$post_yes = filter_var($_POST['postId'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['bookUid'])){
		$book_uid = filter_var($_POST['bookUid'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['woocommerce'])){
		$woocommerce = filter_var($_POST['woocommerce'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['saleprice'])){
		$saleprice = filter_var($_POST['saleprice'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['regularprice'])){
		$regularprice = filter_var($_POST['regularprice'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['stock'])){
		$stock = filter_var($_POST['stock'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['length'])){
		$length = filter_var($_POST['length'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['width'])){
		$width = filter_var($_POST['width'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['height'])){
		$height = filter_var($_POST['height'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['weight'])){
		$weight = filter_var($_POST['weight'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['sku'])){
		$sku = filter_var($_POST['sku'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['virtual'])){
		$virtual = filter_var($_POST['virtual'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['download'])){
		$download = filter_var($_POST['download'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['woofile'])){
		$woofile = filter_var($_POST['woofile'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['salebegin'])){
		$salebegin = filter_var($_POST['salebegin'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['saleend'])){
		$saleend = filter_var($_POST['saleend'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['purchasenote'])){
		$purchasenote = filter_var($_POST['purchasenote'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['productcategory'])){
		$productcategory = filter_var($_POST['productcategory'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['reviews'])){
		$reviews = filter_var($_POST['reviews'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['crosssells'])){
		$crosssells = filter_var($_POST['crosssells'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['upsells'])){
		$upsells = filter_var($_POST['upsells'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['amazonbuylink'])){
		$amazonbuylink = filter_var($_POST['amazonbuylink'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['bnbuylink'])){
		$bnbuylink = filter_var($_POST['bnbuylink'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['googlebuylink'])){
		$googlebuylink = filter_var($_POST['googlebuylink'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['itunesbuylink'])){
		$itunesbuylink = filter_var($_POST['itunesbuylink'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['booksamillionbuylink'])){
		$booksamillionbuylink = filter_var($_POST['booksamillionbuylink'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['kobobuylink'])){
		$kobobuylink = filter_var($_POST['kobobuylink'],FILTER_SANITIZE_STRING);
	}

	if(isset($_POST['bookId'])){
		$book_id = filter_var($_POST['bookId'],FILTER_SANITIZE_STRING);
	}





	$book_array = array(
		'amazon_auth_yes' => $amazon_auth_yes,
		'library' => $library,
		'use_amazon_yes' => $use_amazon_yes,
		'isbn' => $isbn,
		'title' => $title,
		'author' => $author,
		'author_url' => $author_url,
		'category' => $category,
		'price' => $price,
		'pages' => $pages,
		'pub_year' => $pub_year,
		'publisher' => $publisher,
		'description' => $description,
		'subject' => $subject,
		'country' => $country,
		'notes' => $notes,
		'rating' => $rating,
		'image' => $image,
		'finished' => $finished,
		'date_finished' => $date_finished,
		'signed' => $signed,
		'first_edition' => $first_edition,
		'page_yes' => $page_yes,
		'post_yes' => $post_yes,
		'lendable' => $lendable,
		'copies' => $copies,
		'page_id' => $page_id,
		'post_id' => $post_id,
		'book_uid' => $book_uid,
		'woocommerce' => $woocommerce,
		'saleprice' => $saleprice,
		'regularprice' => $regularprice,
		'stock' => $stock,
		'length' => $length,
		'width' => $width,
		'height' => $height,
		'weight' => $weight,
		'sku' => $sku,
		'virtual' => $virtual,
		'download' => $download,
		'woofile' => $woofile,
		'salebegin' => $salebegin,
		'saleend' => $saleend,
		'purchasenote' => $purchasenote,
		'productcategory' => $productcategory,
		'reviews' => $reviews,
		'crosssells' => $crosssells,
		'upsells' => $upsells,
		'amazonbuylink' => $amazonbuylink,
		'bnbuylink' => $bnbuylink,
		'googlebuylink' => $googlebuylink,
		'itunesbuylink' => $itunesbuylink,
		'booksamillionbuylink' => $booksamillionbuylink,
		'kobobuylink' => $kobobuylink
	);

	require_once(CLASS_DIR.'class-book.php');
	$book_class = new WPBookList_Book('edit', $book_array, $book_id);

	$edit_result = $book_class->edit_result;

	// If book was succesfully edited, and return the page/post results
	if($edit_result == 1){
  		$row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $library WHERE ID = %d", $book_id));

  		// Get saved page URL
		$table_name = $wpdb->prefix.'wpbooklist_jre_saved_page_post_log';
  		$page_results = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE book_uid = %s AND type = 'page'" , $row->book_uid));
  		if(is_object($page_results)){
  			$page_url = $page_results->post_url;
  		} else {
  			$page_url = '';
  		}

  		// Get saved post URL
		$table_name = $wpdb->prefix.'wpbooklist_jre_saved_page_post_log';
  		$post_results = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE book_uid = %s AND type = 'post'", $row->book_uid));
  		if(is_object($page_results)){
  			$post_url = $post_results->post_url;
  		} else {
  			$post_url = '';
  		}

  		echo $edit_result.'--sep--'.$book_id.'--sep--'.$library.'--sep--'.$page_yes.'--sep--'.$post_yes.'--sep--'.$page_url.'--sep--'.$post_url.'--sep--'.$wpdb->prefix.'--sep--'.$book_class->apireport.'--sep--'.json_encode($book_class->whichapifound).'--sep--'.$book_class->apiamazonfailcount;


  	} else {
  		echo $edit_result;
  	}

	wp_die();
}

// For deleting a book
function wpbooklist_delete_book_action_javascript() { 

	// Translations
	$trans1 = __('Title was succesfully deleted!', 'wpbooklist');

	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click",".wpbooklist-edit-actions-delete-button", function(event){

  			// UI Stuff
  			var key = $(this).attr('data-key');
  			$('#wpbooklist-spinner-'+key).animate({'opacity':'1'});

  			var deleteString = '';
  			// Grabbing the post and page ID's, if they exist
  			$(this).parent().find('input').each(function(index){
  				if($(this).attr('data-id') != undefined && $(this).attr('data-id') != null){
  					deleteString = deleteString+'-'+$(this).attr('data-id');
  				}
  			});

  			var bookId = $(this).attr('data-book-id');
  			var library = $('#wpbooklist-editbook-select-library').val();

		  	var data = {
				'action': 'wpbooklist_delete_book_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_delete_book_action_callback" ); ?>',
				'deleteString':deleteString,
				'bookId':bookId,
				'library':library

			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	response = response.split('-');
			    	console.log(response);
			    	var resultString = '';
			    	if(response[0] == 1){
			    		resultString = '<span class="wpbooklist-color-orange-italic"><?php echo $trans1 ?></span><img id="wpbooklist-smile-icon-1" src="<?php echo ROOT_IMG_ICONS_URL; ?>smile.png"><br/>';
			    		$('#wpbooklist-spinner-'+key).animate({'opacity':'0'});

				    	$('#wpbooklist-delete-result-'+key).html(resultString);

				    	setTimeout(function(){
				    		document.location.reload(true);
				    	}, 3000)
			    	}

			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for deleting books 
function wpbooklist_delete_book_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_delete_book_action_callback', 'security' );
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);
	$delete_string = filter_var($_POST['deleteString'],FILTER_SANITIZE_STRING);
	$book_id = filter_var($_POST['bookId'],FILTER_SANITIZE_NUMBER_INT);


	require_once(CLASS_DIR.'class-book.php');
	$book_class = new WPBookList_Book;
	$delete_result = $book_class->delete_book($library, $book_id, $delete_string);
	echo $delete_result;
	wp_die();
}

// Function for saving user's API info
function wpbooklist_user_apis_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#wpbooklist-save-api-settings").click(function(event){

	  		var amazonapipublic = $('#wpbooklist-amazon-api-public').val();
	  		var amazonapisecret = $('#wpbooklist-amazon-api-secret').val();
	  		var googleapi = $('#wpbooklist-google-api').val();

		  	var data = {
		  		'amazonapipublic':amazonapipublic,
		  		'amazonapisecret':amazonapisecret,
		  		'googleapi':googleapi,
				'action': 'wpbooklist_user_apis_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_user_apis_action_callback" ); ?>',
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload(true);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for saving user's API info
function wpbooklist_user_apis_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_user_apis_action_callback', 'security' );
	$amazonapipublic = filter_var($_POST['amazonapipublic'],FILTER_SANITIZE_STRING);
	$amazonapisecret = filter_var($_POST['amazonapisecret'],FILTER_SANITIZE_STRING);
	$googleapi = filter_var($_POST['googleapi'],FILTER_SANITIZE_STRING);

	$table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
	$data = array(
        'amazonapipublic' => $amazonapipublic, 
        'amazonapisecret' => $amazonapisecret, 
        'googleapi' => $googleapi, 
    );
    $format = array( '%s');  
    $where = array( 'ID' => ( 1 ) );
    $where_format = array( '%d' );
    $result = $wpdb->update( $table_name, $data, $where, $format, $where_format );

	echo $result;
	wp_die();
}

// For uploading a new StylePak after purchase
function wpbooklist_upload_new_stylepak_action_javascript() { 

	// Translations
	$trans1 = __("Success!", 'wpbooklist');
	$trans2 = __("You've added a new StylePak!", 'wpbooklist');
	$trans6 = __("Thanks for using WPBookList, and", 'wpbooklist');
	$trans7 = __("be sure to check out the WPBookList Extensions!", 'wpbooklist');
	$trans8 = __("If you happen to be thrilled with WPBookList, then by all means,", 'wpbooklist');
	$trans9 = __("Feel Free to Leave a 5-Star Review Here!", 'wpbooklist');
	$trans10 = __("Uh-Oh!", 'wpbooklist');
	$trans11 = __("Looks like there was a problem uploading your StylePak! Are you sure you selected the right file? It should end with either a '.zip' or a '.css' - you could also try unzipping the file", 'wpbooklist');
	$trans12 = __("before", 'wpbooklist');
	$trans13 = __("uploading it", 'wpbooklist');
	

	wp_enqueue_media();
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

		// Enabling the 'Apply StylePak' button when first drop-down is changed
		$(document).on("change","#wpbooklist-select-library-stylepak", function(event){
			$('#wpbooklist-addstylepak-success-div').html('');
			$('#wpbooklist-apply-library-stylepak').prop('disabled', false);
		});

		// For uploading a new StylePak
  		$(document).on("change","#wpbooklist-add-new-library-stylepak", function(event){

  			$('.wpbooklist-spinner').animate({'opacity':'1'});

			var files = event.target.files; // FileList object
		    var theFile = files[0];
		    // Open Our formData Object
		    var formData = new FormData();
		    formData.append('action', 'wpbooklist_upload_new_stylepak_action');
		    formData.append('my_uploaded_file', theFile);
		    var nonce = '<?php echo wp_create_nonce( "wpbooklist_upload_new_stylepak_action_callback" ); ?>';
		    formData.append('security', nonce);

		    // If it's a zip file or a css file, proceed with uploading the file
		    if(theFile.name.includes('.zip') || theFile.name.includes('.css')){
			    jQuery.ajax({
					url: ajaxurl,
					type: 'POST',
					data: formData,
					contentType:false,
					processData:false,
					success: function(response){
						console.log(response);
						response = response.split('sep');
						if(response[2] == 1){
							$('.wpbooklist-spinner').animate({'opacity':'0'});
							$('#wpbooklist-addstylepak-success-div').html("<span id='wpbooklist-add-book-success-span'><?php echo $trans1 ?></span><br/><br/><?php echo $trans2 ?><div id='wpbooklist-addstylepak-success-thanks'><?php echo $trans6 ?>&nbsp;<a href='http://wpbooklist.com/index.php/extensions/'><?php echo $trans7 ?></a><br/><br/><?php echo $trans8 ?>&nbsp;<a id='wpbooklist-addbook-success-review-link' href='https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5'><?php echo $trans9 ?></a><img id='wpbooklist-smile-icon-1' src='http://evansclienttest.com/wp-content/plugins/wpbooklist/assets/img/icons/smile.png'></div>");

							$('html, body').animate({
						        scrollTop: $("#wpbooklist-addstylepak-success-div").offset().top-100
						    }, 1000);
						} else {

						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(errorThrown);
					    console.log(textStatus);
					    console.log(jqXHR);
					}	
			    }); 

			} else {
				// If the file isn't a zip or css file...
				$('.wpbooklist-spinner').animate({'opacity':'0'});
				$('#wpbooklist-addstylepak-success-div').html("<span id='wpbooklist-add-book-success-span'><?php echo $trans10 ?></span><br/><br/><?php echo $trans11 ?> <em><?php echo $trans12 ?></em> <?php echo $trans13 ?>.");

				$('html, body').animate({
			        scrollTop: $("#wpbooklist-addstylepak-success-div").offset().top-100
			    }, 1000);
			}

			//event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});

		// Actually assigning a StylePak to a library
		$(document).on("click","#wpbooklist-apply-library-stylepak", function(event){
		    var stylePak = $("#wpbooklist-select-library-stylepak").val();
		    var library = $('#wpbooklist-stylepak-select-library').val();

		    var data = {
		      'action': 'wpbooklist_upload_new_stylepak_action',
		      'security': '<?php echo wp_create_nonce("wpbooklist_upload_new_stylepak_action_callback" ); ?>',
		      'stylepak': stylePak,
		      'library':library
		    };

		    console.log(data);

		    var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    	document.location.reload();
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				    console.log(textStatus);
				    console.log(jqXHR);
				}
			});

	  	});

	});
	</script>
	<?php
}

// Callback function for uploading a new StylePak after purchase
function wpbooklist_upload_new_stylepak_action_callback(){

	global $wpdb;
	check_ajax_referer( 'wpbooklist_upload_new_stylepak_action_callback', 'security' );

	// For assigning a StylePak to a Library
	if(isset($_POST["stylepak"])){
		$stylepak = filter_var($_POST["stylepak"],FILTER_SANITIZE_STRING);
  		$library = filter_var($_POST["library"],FILTER_SANITIZE_STRING);

  		$stylepak = str_replace('.css', '', $stylepak);
  		$stylepak = str_replace('.zip', '', $stylepak);

  		// Build table name to store StylePak in
  		if(strpos($library, 'wpbooklist_jre_saved_book_log') !== false){
  			$table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';
	  		$data = array(
		      'stylepak' => $stylepak,
		    );
		    $format = array( '%s');   
		    $where = array( 'ID' => 1 );
		    $where_format = array( '%d' );
		    echo $wpdb->update( $table_name, $data, $where, $format, $where_format );
  		} else {
  			$table_name = $wpdb->prefix . 'wpbooklist_jre_list_dynamic_db_names';
  			$library = substr($library, strrpos($library, '_') + 1);
  			$data = array(
		      'stylepak' => $stylepak,
		    );
		    $format = array( '%s');   
		    $where = array( 'user_table_name' => $library );
		    $where_format = array( '%s' );
		    echo $stylepak.' '.$library;
		    echo $wpdb->update( $table_name, $data, $where, $format, $where_format );
  		}

	} else {
		// Create file structure in the uploads dir 
		$mkdir1 = null;
		if (!file_exists(UPLOADS_BASE_DIR."wpbooklist")) {
			// TODO: create log file entry 
			$mkdir1 = mkdir(UPLOADS_BASE_DIR."wpbooklist", 0777, true);
		}

		// Create file structure in the uploads dir 
		$mkdir2 = null;
		if (!file_exists(LIBRARY_STYLEPAKS_UPLOAD_DIR)) {
			// TODO: create log file entry 
			$mkdir2 = mkdir(LIBRARY_STYLEPAKS_UPLOAD_DIR, 0777, true);
		}

		// TODO: create log file entry 
		$move_result = move_uploaded_file($_FILES['my_uploaded_file']['tmp_name'], LIBRARY_STYLEPAKS_UPLOAD_DIR."{$_FILES['my_uploaded_file'] ['name']}");

		// Unzip the file if it's zipped
		if(strpos($_FILES['my_uploaded_file']['name'], '.zip') !== false){
			$zip = new ZipArchive;
			$res = $zip->open(LIBRARY_STYLEPAKS_UPLOAD_DIR.$_FILES['my_uploaded_file']['name']);
			if ($res === TRUE) {
			  $zip->extractTo(LIBRARY_STYLEPAKS_UPLOAD_DIR);
			  $zip->close();
			  unlink(LIBRARY_STYLEPAKS_UPLOAD_DIR.$_FILES['my_uploaded_file']['name']);
			}
		}

		echo $mkdir1.'sep'.$mkdir2.'sep'.$move_result;
	}
	wp_die();
}






// For uploading a new Post Template after purchase
function wpbooklist_upload_new_post_template_action_javascript() { 

	$trans1 = __("Success!", 'wpbooklist');
	$trans2 = __("You've added a new Template!", 'wpbooklist');
	$trans6 = __("Thanks for using WPBookList, and", 'wpbooklist');
	$trans7 = __("be sure to check out the WPBookList Extensions!", 'wpbooklist');
	$trans8 = __("If you happen to be thrilled with WPBookList, then by all means,", 'wpbooklist');
	$trans9 = __("Feel Free to Leave a 5-Star Review Here!", 'wpbooklist');
	$trans10 = __("Uh-Oh!", 'wpbooklist');
	$trans11 = __("Looks like there was a problem uploading your Template! Are you sure you selected the right file? It should end with either a '.zip' or a '.php' - you could also try unzipping the file", 'wpbooklist');
	$trans12 = __("before", 'wpbooklist');
	$trans13 = __("uploading it", 'wpbooklist');


	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

		// Enabling the 'Apply StylePak' button when first drop-down is changed
		$(document).on("change","#wpbooklist-select-post-template", function(event){
			$('#wpbooklist-apply-post-template').prop('disabled', false);
		});

		// For uploading a new StylePak
  		$(document).on("change","#wpbooklist-add-new-post-template", function(event){

  			$('.wpbooklist-spinner').animate({'opacity':'1'});

			var files = event.target.files; // FileList object
		    var theFile = files[0];
		    // Open Our formData Object
		    var formData = new FormData();
		    formData.append('action', 'wpbooklist_upload_new_post_template_action');
		    formData.append('my_uploaded_file', theFile);
		    var nonce = '<?php echo wp_create_nonce( "wpbooklist_upload_new_post_template_action_callback" ); ?>';
		    formData.append('security', nonce);

		    // If it's a zip file or a css file, proceed with uploading the file
		    if(theFile.name.includes('.zip') || theFile.name.includes('.php')){
			    jQuery.ajax({
					url: ajaxurl,
					type: 'POST',
					data: formData,
					contentType:false,
					processData:false,
					success: function(response){
						console.log(response);
						response = response.split('sep');
						if(response[2] == 1){
							$('.wpbooklist-spinner').animate({'opacity':'0'});
							$('#wpbooklist-addtemplate-success-div').html("<span id='wpbooklist-add-book-success-span'><?php echo $trans1 ?></span><br/><br/>&nbsp;<?php echo $trans2 ?><div id='wpbooklist-addtemplate-success-thanks'><?php echo $trans6 ?>&nbsp;<a href='http://wpbooklist.com/index.php/extensions/'><?php echo $trans7 ?></a><br/><br/>&nbsp;<?php echo $trans8 ?> &nbsp;<a id='wpbooklist-addbook-success-review-link' href='https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5'><?php echo $trans9 ?></a><img id='wpbooklist-smile-icon-1' src='http://evansclienttest.com/wp-content/plugins/wpbooklist/assets/img/icons/smile.png'></div>");

							$('html, body').animate({
						        scrollTop: $("#wpbooklist-addtemplate-success-div").offset().top-100
						    }, 1000);

						    setTimeout(function(){
					    		document.location.reload(true);
					    	}, 6000)

						} else {

						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(errorThrown);
					    console.log(textStatus);
					    console.log(jqXHR);
					}	
			    }); 

			} else {
				// If the file isn't a zip or css file...
				$('.wpbooklist-spinner').animate({'opacity':'0'});
				$('#wpbooklist-addtemplate-success-div').html("<span id='wpbooklist-add-book-success-span'><?php echo $trans10; ?></span><br/><br/> <?php echo $trans11; ?>&nbsp;<em><?php echo $trans12; ?></em> <?php echo $trans13; ?>");

				$('html, body').animate({
			        scrollTop: $("#wpbooklist-addtemplate-success-div").offset().top-100
			    }, 1000);
			}

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});

		// Actually assigning a StylePak to a library
		$(document).on("click","#wpbooklist-apply-post-template", function(event){
		    var template = $("#wpbooklist-select-post-template").val();

		    var data = {
		      'action': 'wpbooklist_upload_new_post_template_action',
		      'security': '<?php echo wp_create_nonce("wpbooklist_upload_new_post_template_action_callback" ); ?>',
		      'template': template
		    };

		    console.log(data);

		    var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    	document.location.reload();
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				    console.log(textStatus);
				    console.log(jqXHR);
				}
			});

	  	});

	});
	</script>
	<?php
}

// Callback function for uploading a new Post Template after purchase
function wpbooklist_upload_new_post_template_action_callback(){

	global $wpdb;
	check_ajax_referer( 'wpbooklist_upload_new_post_template_action_callback', 'security' );

	// For assigning a Template to a Library
	if(isset($_POST["template"])){
		$template = filter_var($_POST["template"],FILTER_SANITIZE_STRING);

  		$template = str_replace('.php', '', $template);
  		$template = str_replace('.zip', '', $template);

  		$table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';

  		$data = array(
	      'activeposttemplate' => $template,
	    );
	    $format = array( '%s');   
	    $where = array( 'ID' => 1 );
	    $where_format = array( '%d' );
	    echo $wpdb->update( $table_name, $data, $where, $format, $where_format );

	} else {
		// Create file structure in the uploads dir 
		$mkdir1 = null;
		if (!file_exists(UPLOADS_BASE_DIR."wpbooklist")) {
			// TODO: create log file entry 
			$mkdir1 = mkdir(UPLOADS_BASE_DIR."wpbooklist", 0777, true);
		}

		// Create file structure in the uploads dir 
		$mkdir2 = null;
		if (!file_exists(POST_TEMPLATES_UPLOAD_DIR)) {
			// TODO: create log file entry 
			$mkdir2 = mkdir(POST_TEMPLATES_UPLOAD_DIR, 0777, true);
		}

		// TODO: create log file entry 
		$move_result = move_uploaded_file($_FILES['my_uploaded_file']['tmp_name'], POST_TEMPLATES_UPLOAD_DIR."{$_FILES['my_uploaded_file'] ['name']}");

		// Unzip the file if it's zipped
		if(strpos($_FILES['my_uploaded_file']['name'], '.zip') !== false){
			$zip = new ZipArchive;
			$res = $zip->open(POST_TEMPLATES_UPLOAD_DIR.$_FILES['my_uploaded_file']['name']);
			if ($res === TRUE) {
			  $zip->extractTo(POST_TEMPLATES_UPLOAD_DIR);
			  $zip->close();
			  unlink(POST_TEMPLATES_UPLOAD_DIR.$_FILES['my_uploaded_file']['name']);
			}
		}

		echo $mkdir1.'sep'.$mkdir2.'sep'.$move_result;
	}
	wp_die();
}

// For uploading a new page Template after purchase
function wpbooklist_upload_new_page_template_action_javascript() { 

	$trans1 = __("Success!", 'wpbooklist');
	$trans2 = __("You've added a new Template!", 'wpbooklist');
	$trans6 = __("Thanks for using WPBookList, and", 'wpbooklist');
	$trans7 = __("be sure to check out the WPBookList Extensions!", 'wpbooklist');
	$trans8 = __("If you happen to be thrilled with WPBookList, then by all means,", 'wpbooklist');
	$trans9 = __("Feel Free to Leave a 5-Star Review Here!", 'wpbooklist');
	$trans10 = __("Uh-Oh!", 'wpbooklist');
	$trans11 = __("Looks like there was a problem uploading your Template! Are you sure you selected the right file? It should end with either a '.zip' or a '.php' - you could also try unzipping the file", 'wpbooklist');
	$trans12 = __("before", 'wpbooklist');
	$trans13 = __("uploading it", 'wpbooklist');

	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

		// Enabling the 'Apply Template' button when first drop-down is changed
		$(document).on("change","#wpbooklist-select-page-template", function(event){
			$('#wpbooklist-apply-page-template').prop('disabled', false);
		});

		// For uploading a new Template
  		$(document).on("change","#wpbooklist-add-new-page-template", function(event){

  			$('.wpbooklist-spinner').animate({'opacity':'1'});

			var files = event.target.files; // FileList object
		    var theFile = files[0];
		    // Open Our formData Object
		    var formData = new FormData();
		    formData.append('action', 'wpbooklist_upload_new_page_template_action');
		    formData.append('my_uploaded_file', theFile);
		    var nonce = '<?php echo wp_create_nonce( "wpbooklist_upload_new_page_template_action_callback" ); ?>';
		    formData.append('security', nonce);

		    // If it's a zip file or a css file, proceed with uploading the file
		    if(theFile.name.includes('.zip') || theFile.name.includes('.php')){
			    jQuery.ajax({
					url: ajaxurl,
					type: 'POST',
					data: formData,
					contentType:false,
					processData:false,
					success: function(response){
						console.log(response);
						response = response.split('sep');
						if(response[2] == 1){
							$('.wpbooklist-spinner').animate({'opacity':'0'});
							$('#wpbooklist-addtemplate-success-div').html("<span id='wpbooklist-add-book-success-span'><?php echo $trans1 ?></span><br/><br/>&nbsp;<?php echo $trans2 ?><div id='wpbooklist-addtemplate-success-thanks'><?php echo $trans6 ?>&nbsp;<a href='http://wpbooklist.com/index.php/extensions/'><?php echo $trans7 ?></a><br/><br/>&nbsp;<?php echo $trans8 ?> &nbsp;<a id='wpbooklist-addbook-success-review-link' href='https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5'><?php echo $trans8 ?></a><img id='wpbooklist-smile-icon-1' src='http://evansclienttest.com/wp-content/plugins/wpbooklist/assets/img/icons/smile.png'></div>");

							$('html, body').animate({
						        scrollTop: $("#wpbooklist-addtemplate-success-div").offset().top-100
						    }, 1000);

						    setTimeout(function(){
					    		document.location.reload(true);
					    	}, 6000)
					    	
						} else {

						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(errorThrown);
					    console.log(textStatus);
					    console.log(jqXHR);
					}	
			    }); 

			} else {
				// If the file isn't a zip or css file...
				$('.wpbooklist-spinner').animate({'opacity':'0'});
				$('#wpbooklist-addtemplate-success-div').html("<span id='wpbooklist-add-book-success-span'><?php echo $trans10; ?></span><br/><br/> <?php echo $trans11; ?>&nbsp;<em><?php echo $trans12; ?></em> <?php echo $trans13; ?>");

				$('html, body').animate({
			        scrollTop: $("#wpbooklist-addtemplate-success-div").offset().top-100
			    }, 1000);
			}

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});

		// Actually assigning a Template to a library
		$(document).on("click","#wpbooklist-apply-page-template", function(event){
		    var template = $("#wpbooklist-select-page-template").val();

		    var data = {
		      'action': 'wpbooklist_upload_new_page_template_action',
		      'security': '<?php echo wp_create_nonce("wpbooklist_upload_new_page_template_action_callback" ); ?>',
		      'template': template
		    };

		    console.log(data);

		    var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    	document.location.reload();
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				    console.log(textStatus);
				    console.log(jqXHR);
				}
			});

	  	});

	});
	</script>
	<?php
}

// Callback function for uploading a new page Template after purchase
function wpbooklist_upload_new_page_template_action_callback(){

	global $wpdb;
	check_ajax_referer( 'wpbooklist_upload_new_page_template_action_callback', 'security' );

	// For assigning a page_template
	if(isset($_POST["template"])){
		$template = filter_var($_POST["template"],FILTER_SANITIZE_STRING);

  		$template = str_replace('.php', '', $template);
  		$template = str_replace('.zip', '', $template);

  		$table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';

  		$data = array(
	      'activepagetemplate' => $template,
	    );
	    $format = array( '%s');   
	    $where = array( 'ID' => 1 );
	    $where_format = array( '%d' );
	    $wpdb->update( $table_name, $data, $where, $format, $where_format );

	} else {
		// Create file structure in the uploads dir 
		$mkdir1 = null;
		if (!file_exists(UPLOADS_BASE_DIR."wpbooklist")) {
			// TODO: create log file entry 
			$mkdir1 = mkdir(UPLOADS_BASE_DIR."wpbooklist", 0777, true);
		}

		// Create file structure in the uploads dir 
		$mkdir2 = null;
		if (!file_exists(PAGE_TEMPLATES_UPLOAD_DIR)) {
			// TODO: create log file entry 
			$mkdir2 = mkdir(PAGE_TEMPLATES_UPLOAD_DIR, 0777, true);
		}

		// TODO: create log file entry 
		$move_result = move_uploaded_file($_FILES['my_uploaded_file']['tmp_name'], PAGE_TEMPLATES_UPLOAD_DIR."{$_FILES['my_uploaded_file'] ['name']}");

		// Unzip the file if it's zipped
		if(strpos($_FILES['my_uploaded_file']['name'], '.zip') !== false){
			$zip = new ZipArchive;
			$res = $zip->open(PAGE_TEMPLATES_UPLOAD_DIR.$_FILES['my_uploaded_file']['name']);
			if ($res === TRUE) {
			  $zip->extractTo(PAGE_TEMPLATES_UPLOAD_DIR);
			  $zip->close();
			  unlink(PAGE_TEMPLATES_UPLOAD_DIR.$_FILES['my_uploaded_file']['name']);
			}
		}

		echo $mkdir1.'sep'.$mkdir2.'sep'.$move_result;
	}
	wp_die();
}

// For creating a DB backup of a Library
function wpbooklist_create_db_library_backup_action_javascript() { 

	$trans1 = __("Success!", 'wpbooklist');
	$trans2 = __("You've Created a New Backup! You can", 'wpbooklist');
	$trans6 = __("Thanks for using WPBookList, and", 'wpbooklist');
	$trans7 = __("be sure to check out the WPBookList Extensions!", 'wpbooklist');
	$trans8 = __("If you happen to be thrilled with WPBookList, then by all means,", 'wpbooklist');
	$trans9 = __("Feel Free to Leave a 5-Star Review Here!", 'wpbooklist');
	$trans14 = __("download your backup here", 'wpbooklist');
	

	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

  		// Enabling the 'Backup Library' button when first drop-down is changed
		$(document).on("change","#wpbooklist-backup-select-library", function(event){
			$('#wpbooklist-apply-library-backup').prop('disabled', false);
		});

  		$(document).on("click","#wpbooklist-apply-library-backup", function(event){

  			$('#wpbooklist-spinner-backup').animate({'opacity':'1'}, 500);

  			var library = $('#wpbooklist-backup-select-library').val();

		  	var data = {
				'action': 'wpbooklist_create_db_library_backup_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_create_db_library_backup_action_callback" ); ?>',
				'library':library
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	response = response.split(',');
			    	if(response[0] == '1'){
			    		$('#wpbooklist-spinner-backup').animate({'opacity':'0'}, 500);
			    		$('#wpbooklist-addbackup-success-div').html("<span id='wpbooklist-add-book-success-span'><?php echo $trans1 ?></span><br/><br/> <?php echo $trans2 ?> <a href='<?php echo LIBRARY_DB_BACKUPS_UPLOAD_URL; ?>"+response[1]+".zip'><?php echo $trans14 ?>.</a><div id='wpbooklist-addstylepak-success-thanks'><?php echo $trans6 ?> <a href='http://wpbooklist.com/index.php/extensions/'><?php echo $trans7 ?></a><br/><br/> <?php echo $trans8 ?> <a id='wpbooklist-addbook-success-review-link' href='https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5'><?php echo $trans9 ?></a><img id='wpbooklist-smile-icon-1' src='http://evansclienttest.com/wp-content/plugins/wpbooklist/assets/img/icons/smile.png'></div>");

						$('html, body').animate({
					        scrollTop: $("#wpbooklist-addbackup-success-div").offset().top-100
					    }, 1000);

			    	}
	
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for creating a DB backup of a Library
function wpbooklist_create_db_library_backup_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_create_db_library_backup_action_callback', 'security' );
	$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);

	require_once(CLASS_DIR.'class-backup.php');
	$backup_class = new WPBookList_Backup('library_database_backup', $library);
	echo $backup_class->create_backup_result; 
	wp_die();
}

// For restoring a backup of a Library
function wpbooklist_restore_db_library_backup_action_javascript() { 

	$trans1 = __("Success!", 'wpbooklist');
	$trans2 = __("You've Restored Your Library!", 'wpbooklist');
	$trans6 = __("Thanks for using WPBookList, and", 'wpbooklist');
	$trans7 = __("be sure to check out the WPBookList Extensions!", 'wpbooklist');
	$trans8 = __("If you happen to be thrilled with WPBookList, then by all means,", 'wpbooklist');
	$trans9 = __("Feel Free to Leave a 5-Star Review Here!", 'wpbooklist');
	$trans14 = __("download your backup here", 'wpbooklist');

	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

	  	// Enabling the 'Select a Backup' drop-down when first drop-down is changed
		$(document).on("change","#wpbooklist-select-library-backup", function(event){
			var table = $(this).val();
			$('#wpbooklist-select-actual-backup').val('Select a Backup...')
			$('#wpbooklist-apply-library-restore').prop('disabled', true)
			$('.wpbooklist-backup-actual-option').each(function(){
				if( $(this).attr('data-table') != table){
					$(this).css({'display':'none'});
				} else {
					$(this).css({'display':'block'});
				}
			})
			$('#wpbooklist-select-actual-backup').prop('disabled', false);
		});

		// Enabling the 'Restore Library' button when 'select a backup' drop-down is changed
		$(document).on("change","#wpbooklist-select-actual-backup", function(event){
			$('#wpbooklist-apply-library-restore').prop('disabled', false);
		});


  		$(document).on("click","#wpbooklist-apply-library-restore", function(event){

  			$('#wpbooklist-spinner-restore-backup').animate({'opacity':'1'}, 500);

  			var table = $('#wpbooklist-select-library-backup').val();
  			var backup = $('#wpbooklist-select-actual-backup').val();

		  	var data = {
				'action': 'wpbooklist_restore_db_library_backup_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_restore_db_library_backup_action_callback" ); ?>',
				'table':table,
				'backup':backup
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	$('#wpbooklist-spinner-restore-backup').animate({'opacity':'0'}, 500);
			    	$('#wpbooklist-addbackup-success-div').html("<span id='wpbooklist-add-book-success-span'><?php echo $trans1; ?></span><br/><br/> <?php echo $trans2; ?><div id='wpbooklist-addstylepak-success-thanks'><?php echo $trans6; ?> <a href='http://wpbooklist.com/index.php/extensions/'><?php echo $trans7; ?></a><br/><br/> <?php echo $trans8; ?> <a id='wpbooklist-addbook-success-review-link' href='https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5'><?php echo $trans9; ?></a><img id='wpbooklist-smile-icon-1' src='http://evansclienttest.com/wp-content/plugins/wpbooklist/assets/img/icons/smile.png'></div>");

					$('html, body').animate({
				        scrollTop: $("#wpbooklist-addbackup-success-div").offset().top-100
				    }, 1000);
		    		console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for restoring a backup of a Library
function wpbooklist_restore_db_library_backup_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_restore_db_library_backup_action_callback', 'security' );
	$table = filter_var($_POST['table'],FILTER_SANITIZE_STRING);
	$backup = filter_var($_POST['backup'],FILTER_SANITIZE_STRING);

	require_once(CLASS_DIR.'class-backup.php');
	$backup_class = new WPBookList_Backup('library_database_restore', $table, $backup);

	wp_die();
}


// For creating a .csv file of ISBN/ASIN numbers
function wpbooklist_create_csv_action_javascript() { 

	$trans1 = __("Success!", 'wpbooklist');
	$trans2 = __("You've Created a CSV file of ISBN/ASIN numbers! You can", 'wpbooklist');
	$trans6 = __("Thanks for using WPBookList, and", 'wpbooklist');
	$trans7 = __("be sure to check out the WPBookList Extensions!", 'wpbooklist');
	$trans8 = __("If you happen to be thrilled with WPBookList, then by all means,", 'wpbooklist');
	$trans9 = __("Feel Free to Leave a 5-Star Review Here!", 'wpbooklist');
	$trans14 = __("download your file here", 'wpbooklist');
	$trans15 = __("Remember, your new file will come in handy when using the", 'wpbooklist');
	$trans16 = __("WPBookList Bulk-Upload Extension!", 'wpbooklist');

	

	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

  		// Enabling the 'Restore Library' button when 'select a backup' drop-down is changed
		$(document).on("change","#wpbooklist-backup-csv-select-library", function(event){
			$('#wpbooklist-apply-library-backup-csv').prop('disabled', false);
		});


  		$(document).on("click","#wpbooklist-apply-library-backup-csv", function(event){

		  	$('#wpbooklist-spinner-backup-csv').animate({'opacity':'1'}, 500);

  			var table = $('#wpbooklist-backup-csv-select-library').val();

		  	var data = {
				'action': 'wpbooklist_create_csv_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_create_csv_action_callback" ); ?>',
				'table':table
			};

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	response = response.split(',');
			    	if(response[0] == '1'){
			    		$('#wpbooklist-spinner-backup-csv').animate({'opacity':'0'}, 500);
			    		$('#wpbooklist-addbackup-success-div').html("<span id='wpbooklist-add-book-success-span'><?php echo $trans1; ?></span><br/><br/> <?php echo $trans2; ?> <a href='<?php echo LIBRARY_DB_BACKUPS_UPLOAD_URL; ?>"+response[1]+".zip'><?php echo $trans14; ?>.</a> <?php echo $trans15; ?> <a href='https://wpbooklist.com/index.php/downloads/bulk-upload-extension/'><?php echo $trans16; ?></a> <div id='wpbooklist-addstylepak-success-thanks'><?php echo $trans6; ?> <a href='http://wpbooklist.com/index.php/extensions/'><?php echo $trans7; ?></a><br/><br/> <?php echo $trans8; ?> <a id='wpbooklist-addbook-success-review-link' href='https://wordpress.org/support/plugin/wpbooklist/reviews/?filter=5'><?php echo $trans9; ?></a><img id='wpbooklist-smile-icon-1' src='http://evansclienttest.com/wp-content/plugins/wpbooklist/assets/img/icons/smile.png'></div>");

						$('html, body').animate({
					        scrollTop: $("#wpbooklist-addbackup-success-div").offset().top-100
					    }, 1000);
			    		console.log('success!)');
			    	}
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for creating a .csv file of ISBN/ASIN numbers
function wpbooklist_create_csv_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_create_csv_action_callback', 'security' );
	$table = filter_var($_POST['table'],FILTER_SANITIZE_STRING);
	
	require_once(CLASS_DIR.'class-backup.php');
	$backup_class = new WPBookList_Backup('create_csv_file', $table);

	echo $backup_class->create_csv_result;
	wp_die();
}





// For setting the Amazon Localization
function wpbooklist_amazon_localization_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click","#wpbooklist-save-localization", function(event){

  			var country;
		    var boxes = jQuery(".wpbooklist-localization-checkbox");
		    for (var i=0; i<boxes.length; i++) {
			    if (boxes[i].checked) {
			    	country = boxes[i].value;
			    }
		    }

		  	var data = {
				'action': 'wpbooklist_amazon_localization_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_amazon_localization_action_callback" ); ?>',
				'country':country
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload();
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for setting the Amazon Localization
function wpbooklist_amazon_localization_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_amazon_localization_action_callback', 'security' );
	$country = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
	$table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';

	$data = array(
	    'amazoncountryinfo' => $country
	);
	$format = array( '%s');  
	$where = array( 'ID' => 1 );
	$where_format = array( '%d' );
	$wpdb->update( $table_name, $data, $where, $format, $where_format );
	wp_die();
}

// For deleting books in bulk
function wpbooklist_delete_book_bulk_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

  		// For switching into bulk delete mode
  		$(document).on("click","#wpbooklist-bulk-edit-mode-on-button", function(event){
  			$('#wpbooklist-reorder-button').css({'pointer-events':'none', 'opacity':'0.7'});
  			$('#wpbooklist-bulk-edit-div').animate({'height':'185px'})
  			$('.wpbooklist-edit-actions-edit-button').css({'opacity':'0.2', 'pointer-events':'none'});
  			$('.wpbooklist-edit-actions-delete-button').css({'opacity':'0.2', 'pointer-events':'none'});
  			$('.wpbooklist-edit-img-author-div').css({'opacity':'0.2', 'pointer-events':'none'});
  			$('.wpbooklist-bulk-delete-checkbox-div').css({'display':'block'})
  		});

  		// For cancelling bulk delete mode
  		$(document).on("click","#wpbooklist-bulk-edit-mode-delete-all-in-lib-cancel", function(event){
  			$('#wpbooklist-reorder-button').css({'pointer-events':'all', 'opacity':'1'});
  			$('#wpbooklist-bulk-edit-div').animate({'height':'60px'})
  			$('.wpbooklist-edit-actions-div').animate({'opacity':'1'})
  			$('.wpbooklist-edit-actions-edit-button').css({'opacity':'1', 'pointer-events':'all'});
  			$('.wpbooklist-edit-actions-delete-button').css({'opacity':'1', 'pointer-events':'all'});
  			$('.wpbooklist-edit-img-author-div').css({'opacity':'1', 'pointer-events':'all'});
  			$('.wpbooklist-bulk-delete-checkbox-div').css({'display':'none'})
  			$('#wpbooklist-reorder-button').prop('disabled', false)
  		});

  		// For enabling/disabling the 'Delete Checked Books' button
  		$(document).on("change",".wpbooklist-bulk-delete-checkbox", function(event){
  			$('#wpbooklist-bulk-edit-mode-delete-checked').attr('disabled', true);
  			$('.wpbooklist-bulk-delete-checkbox').each(function(){
  				if($(this).prop('checked') == true){
  					$('#wpbooklist-bulk-edit-mode-delete-checked').removeAttr('disabled');
  				}
  			})
  		});

  		// For deleting all books in library
  		$(document).on("click","#wpbooklist-bulk-edit-mode-delete-all-in-lib", function(event){

  			$('#wpbooklist-spinner-edit-change-lib').animate({'opacity':'1'}, 500);

  			var library = $('#wpbooklist-editbook-select-library').val();

  			var data = {
				'action': 'wpbooklist_delete_book_bulk_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_delete_book_bulk_action_callback" ); ?>',
				'library':library,
				'deleteallbooks':true
			};

			var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload();
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

  		});

  		// For deleting all books, pages, and posts in library
  		$(document).on("click","#wpbooklist-bulk-edit-mode-delete-all-plus-pp-in-lib", function(event){

  			$('#wpbooklist-spinner-edit-change-lib').animate({'opacity':'1'}, 500);

  			var library = $('#wpbooklist-editbook-select-library').val();

  			var data = {
				'action': 'wpbooklist_delete_book_bulk_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_delete_book_bulk_action_callback" ); ?>',
				'library':library,
				'deleteallbooksandpostandpages':true
			};

			var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload();
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

  		});
  		
  		// For deleting all titles that are checked
  		$(document).on("click","#wpbooklist-bulk-edit-mode-delete-checked", function(event){

  			$('#wpbooklist-spinner-edit-change-lib').animate({'opacity':'1'}, 500);

  			var bookId = '';
  			var library = '';
  			var deleteString = '';
  			$('.wpbooklist-bulk-delete-checkbox').each(function(){
  				if($(this).prop('checked') == true){
  					bookId = bookId+'sep'+$(this).attr('data-book-id');

  					// Grabbing the post and page ID's, if they exist
		  			$(this).parent().parent().parent().find('.wpbooklist-edit-actions-div .wpbooklist-edit-book-delete-page-post-div input').each(function(index){
		  				if($(this).prop('checked')){
		  					if($(this).attr('data-id') != undefined && $(this).attr('data-id') != null){
		  						deleteString = deleteString+'-'+$(this).attr('data-id');
		  					}
		  				}
		  			});

		  			deleteString = deleteString+'sep';

  				}
  			})

  			var library = $('#wpbooklist-editbook-select-library').val();

		  	var data = {
				'action': 'wpbooklist_delete_book_bulk_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_delete_book_bulk_action_callback" ); ?>',
				'deleteString':deleteString,
				'bookId':bookId,
				'library':library,
				'deletechecked':true
			};

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload();
			    	console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for deleting books in bulk
function wpbooklist_delete_book_bulk_action_callback(){
	global $wpdb;
	require_once(CLASS_DIR.'class-book.php');
	$book_class = new WPBookList_Book;
	check_ajax_referer( 'wpbooklist_delete_book_bulk_action_callback', 'security' );

	if(isset($_POST['deletechecked'])){
		$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);
		$delete_string = filter_var($_POST['deleteString'],FILTER_SANITIZE_STRING);
		$book_id = filter_var($_POST['bookId'],FILTER_SANITIZE_STRING);
		$book_id = ltrim($book_id, 'sep');

		// Creating array of IDs to delete.
		$delete_array = explode('sep', $book_id);

		// Creating array of Page/Post IDs to delete
		if($delete_string != null && $delete_string != ''){
			$delete_string = ltrim($delete_string, 'sep');
			$delete_page_post_array = explode('sep', $delete_string);
		}	


		// Required to delete the correct book, update the IDs, then delete the next correct book
		$delete_array = array_reverse($delete_array);

		// The loop that will send each book ID and Page/Post ID to class-book.php to be deleted.
		foreach($delete_array as $key=>$delete){

			// Send page/post IDs to delete to class-book.php if they exist, otherwise don't send
			if($delete_string != null && $delete_string != ''){
				$delete_result = $book_class->delete_book($library, $delete, $delete_page_post_array[$key]);
			} else {
				$delete_result = $book_class->delete_book($library, $delete, null);
			}	
		}
	}

	if(isset($_POST['deleteallbooks'])){

		$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);
		$delete_result = $book_class->empty_table($library);
	}

	if(isset($_POST['deleteallbooksandpostandpages'])){

		$library = filter_var($_POST['library'],FILTER_SANITIZE_STRING);
		$delete_result = $book_class->empty_everything($library);
	}

	wp_die();
}

// For dismissing the admin notice forever
function wpbooklist_jre_dismiss_prem_notice_forever_action_javascript(){
?>
<script>

  jQuery(".wpbooklist-my-notice-dismiss-forever").click(function(){

  	var id = $(this).attr('id');

    var data = {
      'action': 'wpbooklist_jre_dismiss_prem_notice_forever_action',
      'security': '<?php echo wp_create_nonce( "wpbooklist_jre_dismiss_prem_notice_forever_action" ); ?>',
      'id':id,
    };

    var request = $.ajax({
	    url: ajaxurl,
	    type: "POST",
	    data:data,
	    timeout: 0,
	    success: function(response) {
	    	document.location.reload();
	    },
		error: function(jqXHR, textStatus, errorThrown) {
			console.log(errorThrown);
            console.log(textStatus);
            console.log(jqXHR);
		}
	});


  });

  </script> <?php
}

// Callback function for dismissing the admin notice forever
function wpbooklist_jre_dismiss_prem_notice_forever_action_callback(){
	
	global $wpdb; // this is how you get access to the database
	check_ajax_referer( 'wpbooklist_jre_dismiss_prem_notice_forever_action', 'security' );

	$id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
 
 	// Handling the dismiss of the general admin message
	if($id == 'wpbooklist-my-notice-dismiss-forever-general'){
	  $table_name = $wpdb->prefix . 'wpbooklist_jre_user_options';

	  $data = array(
	      'admindismiss' => 0
	  );
	  $where = array( 'ID' => 1 );
	  $format = array( '%d');  
	  $where_format = array( '%d' );
	  echo $wpdb->update( $table_name, $data, $where, $format, $where_format );
	  wp_die();
	}

	// Handling the dismiss of the StoryTime admin message
	if($id == 'wpbooklist-my-notice-dismiss-forever-storytime'){
	  $table_name = $wpdb->prefix . 'wpbooklist_jre_storytime_stories_settings';

	  $data = array(
	      'notifydismiss' => 0
	  );
	  $where = array( 'ID' => 1 );
	  $format = array( '%d');  
	  $where_format = array( '%d' );
	  echo $wpdb->update( $table_name, $data, $where, $format, $where_format );
	  wp_die();
	}
}

// For re-ordering books on the 'Edit & Delete Books' tab
function wpbooklist_reorder_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

  		var book;
  		var origNode;
  		var mousedown = false;
  		var direction = "";
  		var oldx = 0

  		// Disable the edit & Delete buttons, change UI to reflect 'reorder mode'.
  		$(document).on("click","#wpbooklist-reorder-button", function(){
  			$('.wpbooklist-edit-actions-edit-button, .wpbooklist-edit-actions-delete-button, .wpbooklist-edit-book-title, .wpbooklist-edit-book-cover-img').css({'pointer-events':'none'})
  			$('#wpbooklist-reorder-button').prop('disabled', true)
  			$('#wpbooklist-bulk-edit-mode-on-button').animate({'top':'60px'})
  			$('#wpbooklist-cancel-reorder-button').animate({'opacity':'1'})
  			$('#wpbooklist-cancel-reorder-button').css({'z-index':'1'})
  			$('.wpbooklist-edit-actions-div').css({'opacity':'0.3'})
  			$('.wpbooklist-show-book-colorbox').css({'cursor':'move'})
  			$('.wpbooklist-edit-book-icon').css({'cursor':'move'})
  			$('.wpbooklist-search-indiv-container').css({'cursor':'move'})

  			$('.wpbooklist-search-indiv-container').each(function(){
  				$(this).addClass('wpbooklist-search-indiv-container-reorder');
  			})
  		});

  		// Enable the reorder button again immediately upon clicking 'Cancel'
  		$(document).on("mousedown","#wpbooklist-cancel-reorder-button", function(){
  			$('#wpbooklist-reorder-button').prop('disabled', false);
  		});

  		// Undo UI changes from 'reorder mode'.
  		$(document).on("click","#wpbooklist-cancel-reorder-button", function(){
  			$('.wpbooklist-edit-actions-edit-button, .wpbooklist-edit-actions-delete-button, .wpbooklist-edit-book-title, .wpbooklist-edit-book-cover-img').css({'pointer-events':'all'})
  			$('#wpbooklist-bulk-edit-mode-on-button').animate({'top':'31px'})
  			$('#wpbooklist-cancel-reorder-button').animate({'opacity':'0'})
  			$('#wpbooklist-cancel-reorder-button').css({'z-index':'-9'})
  			$('.wpbooklist-edit-actions-div').css({'opacity':'1'})
  			$('.wpbooklist-show-book-colorbox').css({'cursor':'pointer'})
  			$('.wpbooklist-edit-book-icon').css({'cursor':'auto'})
  			$('.wpbooklist-search-indiv-container').css({'cursor':'auto'})

  			$('.wpbooklist-search-indiv-container').each(function(){
  				$(this).removeClass('wpbooklist-search-indiv-container-reorder');
  			})

  		});

  		// Determining if user is scrolling
  		window.isScrolling = false;
		$(window).scroll(function() {
		    window.isScrolling = true;
		    clearTimeout($.data(this, "scrollTimer"));
		    $.data(this, "scrollTimer", setTimeout(function() {
		        // If the window didn't scroll for 250ms
		        window.isScrolling = false;
		    }, 500));
		});

	  	// disable mousewheel
  		function wpbookliststopmousewheel(){
  			if(mousedown == true){
             return false;
         	}
        }

		$(document).mousemove(wpbooklistmousemove);

  		$(document).on('mouseup', function(e){
 			// If Reorder mode is active...
 			console.log($('#wpbooklist-reorder-button').attr('disabled'));
  			if($('#wpbooklist-reorder-button').attr('disabled') == 'disabled'){

  				$(document).unbind("mouseenter", wpbooklistmouseenter);
	  			$(document).unbind("mousedown", wpbooklistmousedown);
	  			$(document).unbind("mousemove", wpbooklistmousemove);
	  			$(document).unbind("mousemove", wpbooklistmousemove);
	  			$(document).unbind("onmousewheel", wpbookliststopmousewheel);

  				$('#clone').remove();
  				$('#book-in-movement .wpbooklist-spinner').animate({'opacity':'1'})
	  			
	  			// Get the ids of books
	  			var idarray = [];
	  			$('.wpbooklist-edit-book-indiv-div-class .wpbooklist-edit-title-div .wpbooklist-edit-img-author-div .wpbooklist-edit-book-cover-img').each(function(){
	  				var id = $(this).attr('data-bookuid');
	  				idarray.push(id);
	  			})

	  			var idarray = JSON.stringify(idarray);
	  			var table = $("#wpbooklist-editbook-select-library").val();

	  			var data = {
					'action': 'wpbooklist_reorder_action',
					'security': '<?php echo wp_create_nonce( "wpbooklist_reorder_action_callback" ); ?>',
					'idarray':idarray,
					'table':table
				};
				console.log(data);

		     	var request = $.ajax({
				    url: ajaxurl,
				    type: "POST",
				    data:data,
				    timeout: 0,
				    success: function(response) {
				    	//if(response == 1){
				    		console.log(response);
				    		mousedown = false;
				  			$('.wpbooklist-search-indiv-container-reorder').css({'pointer-events':'all'})
				  			$('#book-in-movement .wpbooklist-spinner').animate({'opacity':'0'})
				  			$('.wpbooklist-edit-book-indiv-div-class').css({'opacity':'1'})
				  			$('.wpbooklist-edit-book-title, .wpbooklist-edit-book-cover-img, .wpbooklist-edit-book-icon, .wpbooklist-edit-book-author').css({'pointer-events':'all', 'opacity':'1'})
				  			$('.wpbooklist-edit-book-indiv-div-class').css({'border':'1px solid #e5e5e5', 'pointer-events':'all'});
				  			$('.wpbooklist-edit-actions-div').css({'opacity':'0.3'})
				  			$('#book-in-movement').removeAttr('id');

				  			// re-bind events
				  			$(document).mousemove(wpbooklistmousemove);
				  			$(document).on("mousedown",".wpbooklist-search-indiv-container-reorder", wpbooklistmousedown)
				  			$(document).mousemove(wpbooklistmousemove);
				  			$(document).on("mouseenter",".wpbooklist-search-indiv-container-reorder", wpbooklistmouseenter);
						//}
				    },
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(errorThrown);
			            console.log(textStatus);
			            console.log(jqXHR);
					}
				});

	  			}
  		});


		document.addEventListener('mousemove', wpbooklistmousemove);

  		function wpbooklistmousedown(){
	  		mousedown = true;
            document.onmousewheel = wpbookliststopmousewheel;

	  		if($('#wpbooklist-reorder-button').attr('disabled') == 'disabled'){
	  			//$('.wpbooklist-edit-book-indiv-div-class').css({'opacity':'0.2'})
	  			$('.wpbooklist-edit-book-title, .wpbooklist-edit-book-cover-img, .wpbooklist-edit-book-icon, .wpbooklist-edit-book-author, .wpbooklist-edit-actions-div').css({'pointer-events':'none'})
	  			$(this).css({'opacity':'1', 'pointer-events':'none'})

	  			book = $(this).attr('id');
	  			origNode = $(this);
	  			$(this).attr('id', 'book-in-movement');
	  			console.log(book);
	  			var clone = $(this).clone();
	  			clone.attr('id', 'clone');
	  			$(this).parent().append(clone);
	  			$('#book-in-movement img, #book-in-movement p, #book-in-movement .wpbooklist-edit-actions-div').css({'opacity':'0'})
	  			$('#book-in-movement .wpbooklist-edit-book-indiv-div-class').css({'border-color':'black', 'border':'1px dashed black'});
	  		}
		}

		function wpbooklistmousemove(e){

			if (e.pageY < oldx) {
	            direction = "up"
	        } else if (e.pageY > oldx) {
	            direction = "down"
	        }
	        oldx = e.pageY;

	        $('#clone .wpbooklist-edit-book-indiv-div-class').css({
	        	border:'none'
	       	});

		    $('#clone').css({
		       left:  e.pageX-250,
		       top:   e.pageY-250,
		       position: 'absolute',
			   float: 'left',
		       backgroundColor: 'white',
		       zIndex: '999',
		       pointerEvents: 'none',
		       border: '1px solid #e5e5e5'
		    });
		}

		function wpbooklistmouseenter(e){
			if (window.isScrolling) return;
			if($(this).attr('id') != 'book-in-movement'){
				if(mousedown){
					if(direction == 'up'){
						console.log(origNode.prev().attr('class'))
						if(origNode.prev().attr('class') == 'wpbooklist-search-indiv-container wpbooklist-search-indiv-container-reorder'){
							origNode.prev().insertAfter(origNode);
							// Scrolls back to the top of the title 
							var scrollTop = ($("#book-in-movement").offset().top + $("#book-in-movement").height() / 2) - document.documentElement.clientHeight/2;
						    if(scrollTop != 0){
						      $('html, body').animate({
						        scrollTop: scrollTop
						      }, 500);
						      scrollTop = 0;
						    }
							return;
						}
						return;
					}

					if(direction == 'down'){
						if(origNode.next().attr('class') == 'wpbooklist-search-indiv-container wpbooklist-search-indiv-container-reorder'){
							origNode.next().insertBefore(origNode);
							var scrollTop = ($("#book-in-movement").offset().top + $("#book-in-movement").height() / 2) - document.documentElement.clientHeight/2
						    if(scrollTop != 0){
						      $('html, body').animate({
						        scrollTop: scrollTop
						      }, 500);
						      scrollTop = 0;
						    }
							return;
						}
						return;
					}
					
				}
			}
		}

		// Registering the various listeners for 'Reorder' mode.
		$(document).on("mousedown",".wpbooklist-search-indiv-container-reorder", wpbooklistmousedown)
		$(document).on("mouseenter",".wpbooklist-search-indiv-container-reorder", wpbooklistmouseenter);

	});
	</script>
	<?php
}

// Callback function for re-ordering books on the 'Edit & Delete Books' tab
function wpbooklist_reorder_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_reorder_action_callback', 'security' );
	$table = filter_var($_POST['table'], FILTER_SANITIZE_STRING);
	$idarray = stripslashes($_POST['idarray']);
	$idarray = json_decode($idarray);

	// Dropping primary key in database to alter the IDs and the AUTO_INCREMENT value
	$wpdb->query("ALTER TABLE $table MODIFY ID BIGINT(190) NOT NULL");

	$wpdb->query("ALTER TABLE $table DROP PRIMARY KEY");

	foreach ($idarray as $key => $value) {
		$data = array(
		    'ID' => $key+1
		);

		$format = array( '%d');  
		$where = array( 'book_uid' => $value );
		$where_format = array( '%s' );
		$wpdb->update( $table, $data, $where, $format, $where_format );
	}

	// Adding primary key back to database 
	echo $wpdb->query("ALTER TABLE $table ADD PRIMARY KEY (`ID`)"); 

	// Adjusting ID values of remaining entries in database
	$my_query = $wpdb->get_results("SELECT * FROM $table");
	$title_count = $wpdb->num_rows;   

	$wpdb->query("ALTER TABLE $table MODIFY ID BIGINT(190) AUTO_INCREMENT");

	// Setting the AUTO_INCREMENT value based on number of remaining entries
	$title_count++;
	$wpdb->query($wpdb->prepare( "ALTER TABLE $table AUTO_INCREMENT = %d", $title_count));

	wp_die();
}

// For the exit survey triggered when user deactivates WPBookList
function wpbooklist_exit_results_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click","#wpbooklist-modal-submit, #wpbooklist-modal-close", function(event){



  			var id = '';
  			if($(this).attr('id') == 'wpbooklist-modal-close' ){
  				var id = 'wpbooklist-modal-close';
  			} else {
  				var id = 'wpbooklist-modal-submit';
  			}

  			var reasonEmail = $('#wpbooklist-modal-email').val()
  			console.log(reasonEmail)
  			if(reasonEmail != ''){
  				var reasonEmailInput = document.getElementById('wpbooklist-modal-email');
	  			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			    if (!filter.test(reasonEmailInput.value)) {
			    	alert('Whoops! Looks like that might not be a valid E-mail address!');
			    	reasonEmailInput.focus;
			    	return false;
				}
			}	

  			var reason1 = $('#wpbooklist-modal-reason1').prop('checked')
  			var reason2 = $('#wpbooklist-modal-reason2').prop('checked')
  			var reason3 = $('#wpbooklist-modal-reason3').prop('checked')
  			var reason4 = $('#wpbooklist-modal-reason4').prop('checked')
  			var reason5 = $('#wpbooklist-modal-reason5').prop('checked')
  			var reason6 = $('#wpbooklist-modal-reason6').prop('checked')
  			var reason7 = $('#wpbooklist-modal-reason7').prop('checked')
  			var reason8 = $('#wpbooklist-modal-reason8').prop('checked')
  			var reason9 = $('#wpbooklist-modal-reason9').prop('checked')
  			var reasonOther = $('#wpbooklist-modal-textarea').val()
  			var reasonEmail = $('#wpbooklist-modal-email').val()
  			var featureSuggestion = $('#wpbooklist-modal-textarea-suggest-feature').val()


		  	var data = {
				'action': 'wpbooklist_exit_results_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_exit_results_action_callback" ); ?>',
				'reason1':reason1,
				'reason2':reason2,
				'reason3':reason3,
				'reason4':reason4,
				'reason5':reason5,
				'reason6':reason6,
				'reason7':reason7,
				'reason8':reason8,
				'reason9':reason9,
				'reasonOther':reasonOther,
				'reasonEmail':reasonEmail,
				'featureSuggestion':featureSuggestion,
				'id':id
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {

			    	document.location.reload(true);



			    	console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for the exit survey triggered when user deactivates WPBookList
function wpbooklist_exit_results_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_exit_results_action_callback', 'security' );
	$reason1 = filter_var($_POST['reason1'],FILTER_SANITIZE_STRING);
	$reason2 = filter_var($_POST['reason2'],FILTER_SANITIZE_STRING);
	$reason3 = filter_var($_POST['reason3'],FILTER_SANITIZE_STRING);
	$reason4 = filter_var($_POST['reason4'],FILTER_SANITIZE_STRING);
	$reason5 = filter_var($_POST['reason5'],FILTER_SANITIZE_STRING);
	$reason6 = filter_var($_POST['reason6'],FILTER_SANITIZE_STRING);
	$reason7 = filter_var($_POST['reason7'],FILTER_SANITIZE_STRING);
	$reason8 = filter_var($_POST['reason8'],FILTER_SANITIZE_STRING);
	$reason9 = filter_var($_POST['reason9'],FILTER_SANITIZE_STRING);
	$id = filter_var($_POST['id'],FILTER_SANITIZE_STRING);
	$reasonOther = filter_var($_POST['reasonOther'],FILTER_SANITIZE_STRING);
	$featureSuggestion = filter_var($_POST['featureSuggestion'],FILTER_SANITIZE_STRING);
	$reasonEmail = filter_var($_POST['reasonEmail'],FILTER_SANITIZE_EMAIL);

	$message = $reason1.' '.$reason2.' '.$reason3.' '.$reason4.' '.$reason5.' '.$reason6.' '.$reason7.' '.$reason8.' '.$reason9.' '.$featureSuggestion.' '.$reasonOther.' '.$reasonEmail;

	if($id == 'wpbooklist-modal-submit'){
		wp_mail( 'jake@jakerevans.com', 'WPBookList Exit Survey', $message );

		if($reasonEmail != ''){
			$autoresponseMessage = 'Thanks for trying out WPBookList and providing valuable feedback that will help make WPBookList even better! I\'ll review your feedback and get back with you ASAP.  -Jake' ;
			wp_mail( $reasonEmail, 'WPBookList Deactivation Survey', $autoresponseMessage );
		}
	}

	deactivate_plugins( 'wpbooklist/wpbooklist.php');
	wp_die();
}

// For retrieving the WPBookList StoryTime Stories from the server when the 'Select a Category' drop-down changes.
function wpbooklist_storytime_select_category_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("change","#wpbooklist-storytime-category-select", function(event){

  			var category = $(this).val();
  			$('#wpbooklist-storytime-reader-selection-div-1-inner-1').animate({'opacity':0})

		  	var data = {
				'action': 'wpbooklist_storytime_select_category_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_storytime_select_category_action_callback" ); ?>',
				'category':category
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);


			    	$('#wpbooklist-storytime-reader-selection-div-1-inner-1').html(response).animate({'opacity':1})
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for retrieving the WPBookList StoryTime Stories from the server when the 'Select a Category' drop-down changes.
function wpbooklist_storytime_select_category_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_storytime_select_category_action_callback', 'security' );
	$category = filter_var($_POST['category'],FILTER_SANITIZE_STRING);

	require_once(CLASS_DIR.'class-storytime.php');
  	$storytime_class = new WPBookList_Storytime('categorychange', $category );


	echo $storytime_class->category_change_output;
	wp_die();
}

// For retreiving a WPBookList StoryTime Story from the server, once the user has selected one in the reader
function wpbooklist_storytime_get_story_action_javascript() { 

	$trans1 = __('Delete This Story','wpbooklist');

	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click",".wpbooklist-storytime-listed-story", function(event){

  			var title = $(this).text();
  			$('#wpbooklist-storytime-reader-titlebar-div-2 h2').animate({
               opacity: 0
            }, {
               duration: 500,
               complete: function() { 
               		$('#wpbooklist-storytime-reader-titlebar-div-2 h2').text(title)
               		$('#wpbooklist-storytime-reader-titlebar-div-2 h2').animate({'opacity':1})
               }
           });

  			$('#wpbooklist-storytime-reader-selection-div-1-inner-1').animate({
               height: 0,
               opacity: 0
            }, {
               duration: 500,
               complete: function() { 
	                $('#wpbooklist-storytime-reader-selection-div-1-inner-2').animate({
		               height: 48,
		               opacity: 1
		            }, {
		               duration: 500,
		               complete: function() { 
		                	$('#wpbooklist-storytime-reader-pagination-div').animate({
				               height: 45,
				               opacity: 1
				            }, {
				               duration: 500,
				               complete: function() { 
				                	//$('#wpbooklist-storytime-reader-pagination-div')
				               } 
				            }); 	
		               } 
		            });
               } 
            });


  			var dataId = $(this).attr('data-id')

		  	var data = {
				'action': 'wpbooklist_storytime_get_story_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_storytime_get_story_action_callback" ); ?>',
				'dataId':dataId
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {

			    	response = JSON.parse(response);

			    	$('#wpbooklist-storytime-reader-provider-div-1 img').animate({
		               opacity: 0
		            }, {
		               duration: 500,
		               complete: function() { 
		               		$(this).attr('src', response.providerimg)
		               		setTimeout(function(){ $('#wpbooklist-storytime-reader-provider-div-1 img').animate({'opacity':1}) }, 2000);
		               }
		           	});

			    	$('#wpbooklist-storytime-reader-provider-p-1').animate({
		               opacity: 0
		            }, {
		               duration: 500,
		               complete: function() { 
		               		$(this).text(response.providername)
		               		setTimeout(function(){ $('#wpbooklist-storytime-reader-provider-p-1').animate({'opacity':1}) }, 2000);
		               }
		           	});

		           	$('#wpbooklist-storytime-reader-provider-p-2').animate({
		               opacity: 0
		            }, {
		               duration: 500,
		               complete: function() { 
		               		$(this).html(response.providerbio)
		               		setTimeout(function(){ $('#wpbooklist-storytime-reader-provider-p-2').animate({'opacity':1}) }, 2000);
		               }
		           	});

			    	var content = $('#wpbooklist-storytime-reader-content-div').html(response.content);
			    	var contentLocation = content.attr('data-location');
			    	var contentHeight = content.height();

			    	if(contentLocation == 'backend'){
			    		content.css({'height':'337px', 'overflow':'auto'});
			    		var totalPages = Math.trunc(Math.ceil(contentHeight/337));
			    	} else {
			    		content.css({'height':'370px', 'overflow':'auto'});
			    		var totalPages = Math.trunc(Math.ceil(contentHeight/370));
			    	}

			    	setTimeout(function(){ $('#wpbooklist-storytime-reader-content-div').animate({'opacity':1}) }, 2000);

			    	if(contentLocation == 'backend'){
				    	// Add in the HTML for deleting the selected Story
				    	$("#wpbooklist-storytime-reader-provider-div-delete").html('<p id="wpbooklist-storytime-reader-provider-div-delete-p" data-id="'+dataId+'"><?php echo $trans1; ?></p>');
				    	setTimeout(function(){ 

				    		$('#wpbooklist-storytime-reader-provider-div-delete').animate({
				               opacity: 1
				            }, {
				               duration: 500,
				               complete: function() { 
				               		$('#wpbooklist-storytime-reader-provider-div-delete-p').css({'pointer-events':'all'})
				               }
				           	}); 
				    	}, 2500);
			    	}


			    	$('#wpbooklist-storytime-reader-pagination-div-2-span-3').text(totalPages)

			    	console.log(contentHeight)
			    	console.log(totalPages)

			    	console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for retreiving a WPBookList StoryTime Story from the server, once the user has selected one in the reader
function wpbooklist_storytime_get_story_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_storytime_get_story_action_callback', 'security' );
	$dataId = filter_var($_POST['dataId'],FILTER_SANITIZE_NUMBER_INT);
	
	require_once(CLASS_DIR.'class-storytime.php');
  	$storytime_class = new WPBookList_Storytime('getcontent', null, $dataId);

  	echo json_encode($storytime_class->stories_db_data);

	wp_die();
}

// For expanding the 'Browse Stories' section again once a Story has already been selected
function wpbooklist_storytime_expand_browse_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click","#wpbooklist-storytime-reader-selection-div-1-inner-2", function(event){

  			var contentLocation = $(this).attr('data-location');

  			if(contentLocation == 'backend'){
	  			$('#wpbooklist-storytime-reader-provider-div-delete').animate({
	               opacity: 0
	            }, {
	               duration: 500,
	               complete: function() { 
	               		$('#wpbooklist-storytime-reader-provider-div-delete-p').css({'pointer-events':'none'})
	               }
	           	}); 
  			}

  			$('#wpbooklist-storytime-reader-content-div').animate({
               opacity: 0
            }, {
               duration: 500,
               complete: function() { 
               		$('#wpbooklist-storytime-reader-content-div').css({'height':''})
               }
           });

  			$('#wpbooklist-storytime-reader-titlebar-div-2 h2').animate({
               opacity: 0
            }, {
               duration: 500,
               complete: function() { 
               		$('#wpbooklist-storytime-reader-titlebar-div-2 h2').text('Select a Story...')
               		$('#wpbooklist-storytime-reader-titlebar-div-2 h2').animate({'opacity':1})
               }
           });

  			$('#wpbooklist-storytime-reader-selection-div-1-inner-2').animate({
               height: 0,
               opacity: 0
            }, {
               duration: 500,
               complete: function() { 
	                $('#wpbooklist-storytime-reader-pagination-div').animate({
		               height: 0,
		               opacity: 0
		            }, {
		               duration: 500,
		               complete: function() { 
		                		
		               } 
		            });
               } 
            });

		  	var data = {
				'action': 'wpbooklist_storytime_expand_browse_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_storytime_expand_browse_action_callback" ); ?>',
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);

			    	$('#wpbooklist-storytime-reader-provider-div-1 img').animate({
		               opacity: 0
		            }, {
		               duration: 500,
		               complete: function() { 
		               		$(this).attr('src', "<?php echo ROOT_IMG_URL; ?>icon-256x256.png")
		               		setTimeout(function(){ $('#wpbooklist-storytime-reader-provider-div-1 img').animate({'opacity':1}) }, 1000);
		               }
		           	});

			    	$('#wpbooklist-storytime-reader-provider-p-1').animate({
		               opacity: 0
		            }, {
		               duration: 500,
		               complete: function() { 
		               		$(this).text('Discover new Authors and Publishers!')
		               		setTimeout(function(){ $('#wpbooklist-storytime-reader-provider-p-1').animate({'opacity':1}) }, 1000);
		               }
		           	});

		           	$('#wpbooklist-storytime-reader-provider-p-2').animate({
		               opacity: 0
		            }, {
		               duration: 500,
		               complete: function() { 
		               		$(this).text("WPBookList StoryTime is WPBooklist's Content-Delivery System, providing you and your website visitors with Sample Chapters, Short Stories, News, Interviews and more!")
		               		setTimeout(function(){ $('#wpbooklist-storytime-reader-provider-p-2').animate({'opacity':1}) }, 1000);
		               }
		           	});



			    	$('#wpbooklist-storytime-reader-selection-div-1-inner-1').html(response)
			    	$('#wpbooklist-storytime-reader-selection-div-1-inner-1').animate({
		               height: '466px',
       				   opacity: 1
		            }, {
		               duration: 500,
		               complete: function() { 
		                	//$('#wpbooklist-storytime-reader-pagination-div')
		               } 
		            }); 

			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for expanding the 'Browse Stories' section again once a Story has already been selected
function wpbooklist_storytime_expand_browse_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_storytime_expand_browse_action_callback', 'security' );

	require_once(CLASS_DIR.'class-storytime.php');
  	$storytime_class = new WPBookList_Storytime('categorychange', 'Recent Additions' );


	echo $storytime_class->category_change_output;
	wp_die();
}

// For saving the StoryTime Settings
function wpbooklist_storytime_save_settings_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click","#wpbooklist-storytime-settings-save", function(event){

  			$('#wpbooklist-spinner-storytime-settings').animate({'opacity':1})

  			var input1 = $('#wpbooklist-storytime-settings-input-1').prop('checked')
  			var input2 = $('#wpbooklist-storytime-settings-input-2').prop('checked')
  			var input3 = $('#wpbooklist-storytime-settings-input-3').prop('checked')
  			var input4 = $('#wpbooklist-storytime-settings-input-4').prop('checked')
  			var input5 = $('#wpbooklist-storytime-settings-input-5').prop('checked')
  			var input6 = $('#wpbooklist-storytime-settings-input-6').val();

		  	var data = {
				'action': 'wpbooklist_storytime_save_settings_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_storytime_save_settings_action_callback" ); ?>',
				'input1':input1,
				'input2':input2,
				'input3':input3,
				'input4':input4,
				'input5':input5,
				'input6':input6,
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	document.location.reload(true);
			    	console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for saving the StoryTime Settings
function wpbooklist_storytime_save_settings_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_storytime_save_settings_action_callback', 'security' );
	$createpost = filter_var($_POST['input1'],FILTER_SANITIZE_STRING);
	$createpage = filter_var($_POST['input2'],FILTER_SANITIZE_STRING);
	$deletedefault = filter_var($_POST['input3'],FILTER_SANITIZE_STRING);
	$newnotify = filter_var($_POST['input4'],FILTER_SANITIZE_STRING);
	$getstories = filter_var($_POST['input5'],FILTER_SANITIZE_STRING);
	$storypersist = filter_var($_POST['input6'],FILTER_SANITIZE_NUMBER_INT);

	if($createpost == 'true'){
		$createpost = 1;
	} else {
		$createpost = 0;
	}

	if($createpage == 'true'){
		$createpage = 1;
	} else {
		$createpage = 0;
	}

	if($deletedefault == 'true'){
		$deletedefault = 1;

		// Delete default data
		$stories_table = $wpdb->prefix . 'wpbooklist_jre_storytime_stories';
		$query_for_default_data = $wpdb->get_results("SELECT * FROM $stories_table");

		// If the default data still exists (based on the fact that war of the worlds should be first in db), proceed, otherwise do nothing.
		if($query_for_default_data[0]->title == 'Sample Chapter - The War of the Worlds'){

			$wpdb->query("DELETE FROM $stories_table WHERE providername = 'H. G. Wells' AND title = 'Sample Chapter - The War of the Worlds'");

			$wpdb->query("DELETE FROM $stories_table WHERE providername = 'Jane Austen' AND title = 'Sample Chapter - Pride and Predjudice'");

			$wpdb->query("DELETE FROM $stories_table WHERE providername = 'Matthew Dawes' AND title = 'Sample Chapter - Nightfall'");

			$wpdb->query("DELETE FROM $stories_table WHERE providername = 'Maine Authors Publishing' AND title = 'Interview - Maine Authors Publishing'");

			$wpdb->query("DELETE FROM $stories_table WHERE providername = 'Missouri Writers’ Guild' AND title = 'Article - Missouri Writers’ Guild'");

			$wpdb->query("DELETE FROM $stories_table WHERE providername = 'Benjamin Franklin' AND title = 'Autobiography of Benjamin Franklin'");

			$wpdb->query("DELETE FROM $stories_table WHERE providername = 'Zac Wilson' AND title = 'Sample Chapter - Morningland'");

			$wpdb->query("DELETE FROM $stories_table WHERE providername = 'David Luddington' AND title = 'Author Showcase - David Luddington'");

			$wpdb->query("DELETE FROM $stories_table WHERE providername = 'Bram Stoker' AND title = 'Sample Chapter - Dracula'");

			$wpdb->query("DELETE FROM $stories_table WHERE providername = 'Brendan T. Beery' AND title = 'Author Showcase - Brendan T. Beery'");

			// Dropping primary key in database to alter the IDs and the AUTO_INCREMENT value
			$wpdb->query("ALTER TABLE $stories_table MODIFY ID bigint(190)");
			$wpdb->query("ALTER TABLE $stories_table DROP PRIMARY KEY");

			// Adjusting ID values of remaining entries in database
			$my_query = $wpdb->get_results("SELECT * FROM $stories_table");
			$title_count = $wpdb->num_rows;
			$book_id = 10; // Hard-coded based on number of default rows included with WPBookList
			for ($x = 1; $x <= $title_count; $x++) {
				$data = array(
				    'ID' => $x
				);
				$format = array( '%d');  
				$where = array( 'ID' => $book_id);
				$where_format = array( '%d' );
				$wpdb->update( $stories_table, $data, $where, $format, $where_format );
				$book_id++; 
			}  

			// Adding primary key back to database 
			$wpdb->query("ALTER TABLE $stories_table ADD PRIMARY KEY (`ID`)");    
			$wpdb->query("ALTER TABLE $stories_table MODIFY ID bigint(190) AUTO_INCREMENT");

			// Setting the AUTO_INCREMENT value based on number of remaining entries
			$title_count++;
			$wpdb->query($wpdb->prepare( "ALTER TABLE $stories_table AUTO_INCREMENT = %d", $title_count));
		}

	} else {
		$deletedefault = 0;
	}

	if($newnotify == 'true'){
		$newnotify = 1;
	} else {
		$newnotify = 0;
	}

	if($getstories == 'true'){
		$getstories = 1;
	} else {
		$getstories = 0;
	}

	if($storypersist == '' || $storypersist == null || $storypersist == 0){
		$storypersist = null;
	}

	// Update StoryTime settings table
	$table_name = $wpdb->prefix . 'wpbooklist_jre_storytime_stories_settings';
	$data = array(
        'createpost' => $createpost,
		'createpage' => $createpage,
		'deletedefault' => $deletedefault,
		'newnotify' => $newnotify,
		'getstories' => $getstories,
		'storypersist' => $storypersist,
    );
    $format = array( '%d','%d','%d','%d','%d','%d'); 
    $where = array( 'ID' => 1 );
    $where_format = array( '%d' );
    $wpdb->update( $table_name, $data, $where, $format, $where_format );

	wp_die();
}

// For deleting a Story
function wpbooklist_delete_story_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click","#wpbooklist-storytime-reader-provider-div-delete-p", function(event){

  			var dataId = $(this).attr('data-id')

		  	var data = {
				'action': 'wpbooklist_delete_story_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_delete_story_action_callback" ); ?>',
				'dataId':dataId
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    	document.location.reload(true);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for deleting a Story
function wpbooklist_delete_story_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_delete_story_action_callback', 'security' );
	$id = filter_var($_POST['dataId'],FILTER_SANITIZE_NUMBER_INT);

	$stories_table = $wpdb->prefix . 'wpbooklist_jre_storytime_stories';
	$query_for_default_data = $wpdb->get_results("SELECT * FROM $stories_table");

	$wpdb->query("DELETE FROM $stories_table WHERE ID = $id");

	// Dropping primary key in database to alter the IDs and the AUTO_INCREMENT value
	$wpdb->query("ALTER TABLE $stories_table MODIFY ID bigint(190)");
	$wpdb->query("ALTER TABLE $stories_table DROP PRIMARY KEY");

	// Adjusting ID values of remaining entries in database
	$my_query = $wpdb->get_results("SELECT * FROM $stories_table");
	$title_count = $wpdb->num_rows;
	for ($x = $id; $x <= $title_count; $x++) {
		$data = array(
		    'ID' => $id
		);
		$format = array( '%d'); 
		$id++;  
		$where = array( 'ID' => ($id) );
		$where_format = array( '%d' );
		$wpdb->update( $stories_table, $data, $where, $format, $where_format );
	} 

	// Adding primary key back to database 
	$wpdb->query("ALTER TABLE $stories_table ADD PRIMARY KEY (`ID`)");    
	$wpdb->query("ALTER TABLE $stories_table MODIFY ID bigint(190) AUTO_INCREMENT");

	// Setting the AUTO_INCREMENT value based on number of remaining entries
	$title_count++;
	echo $wpdb->query($wpdb->prepare( "ALTER TABLE $stories_table AUTO_INCREMENT = %d", $title_count));

	wp_die();
}

/*
// For adding a book from the admin dashboard
add_action( 'admin_footer', 'wpbooklist_boilerplate_action_javascript' );
add_action( 'wp_ajax_wpbooklist_boilerplate_action', 'wpbooklist_boilerplate_action_callback' );
add_action( 'wp_ajax_nopriv_wpbooklist_boilerplate_action', 'wpbooklist_boilerplate_action_callback' );


function wpbooklist_boilerplate_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
  		$(document).on("click","#wpbooklist-select-sort-div", function(event){

		  	var data = {
				'action': 'wpbooklist_boilerplate_action',
				'security': '<?php echo wp_create_nonce( "wpbooklist_boilerplate_action_callback" ); ?>',
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for creating backups
function wpbooklist_boilerplate_action_callback(){
	global $wpdb;
	check_ajax_referer( 'wpbooklist_boilerplate_action_callback', 'security' );
	//$var1 = filter_var($_POST['var'],FILTER_SANITIZE_STRING);
	//$var2 = filter_var($_POST['var'],FILTER_SANITIZE_NUMBER_INT);
	echo 'hi';
	wp_die();
}*/




?>