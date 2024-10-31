<?php
/*
 * this is main settings apply plugin class
*/

/* == Direct access not allowed == */
if( ! defined('ABSPATH' ) ){ exit; }


class WOOH_Settings {

	var $actions, $filters, $product_type;
	private static $ins = null;

	function __construct(){
			
			if($this->wooh_get_option('_protectproduct') == 'yes'){
				if( get_current_user_id() ) {
					
					remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
					remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
					remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
					remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
					remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
				}
			}
		
		/**
		* Lets add the woocommerce relation hooks
		* filters
		* =============== woocommerce filters hooks ===============*/
		
	
		$this -> filters =  array(	'woocommerce_product_add_to_cart_text'	=> 
			array(	'simple'	=> $this -> wooh_get_option('_addtocartsimple'),
				 	'variable'	=> $this -> wooh_get_option('_addtocartvariable'),
				 	'grouped'	=> $this -> wooh_get_option('_addtocartgrouped'),
					'external'	=> $this -> wooh_get_option('_addtocartexternal'),
				),

			'woocommerce_product_single_add_to_cart_text' => $this -> wooh_get_option('_addtocartsingle'),
			'woocommerce_get_availability'	=> $this -> wooh_get_option('_addtocartout'),
			'woocommerce_order_button_text'	=> $this -> wooh_get_option('_orderbuttontext'),
			'woocommerce_my_account_my_orders_title' => $this -> wooh_get_option('_myaccountmyorderstitle'),
			'woocommerce_sale_flash'		=> $this -> wooh_get_option('_saleflash'),
			'woocommerce_short_description'	=> $this -> wooh_get_option('_shortdescription'),
			'loop_shop_per_page'	        => $this -> wooh_get_option('_productdisplayedperpage'),
			'loop_shop_columns'          	=> $this -> wooh_get_option('_productcolumnsdisplayedperpage'),
			'woocommerce_product_thumbnails_columns' => $this -> wooh_get_option('_productthumbnailcolumnsperpage'),
			'woocommerce_output_related_products_args' => $this -> wooh_get_option('_relatedproductperpage'),
									
		);

		
		foreach ($this -> filters as $filter => $label) {
			
			switch ($filter) {
				case 'woocommerce_product_add_to_cart_text':
					add_filter($filter, array($this, 'loop_product_add_to_cart_text'), 10, 2);
					break;

				case 'woocommerce_product_single_add_to_cart_text':
			
					if($label != '')
						add_filter($filter, array($this, 'product_single_add_to_cart_text'));
					break;

				case 'woocommerce_get_availability':
					if($label != '')
						add_filter($filter, array($this, 'check_if_out_of_stock'), 10, 2);
					break;
				
				case 'woocommerce_order_button_text':
					if($label != '')
						add_filter($filter, array($this, 'order_button_text'));
					break;
				case 'woocommerce_my_account_my_orders_title':
					if($label != '')
						add_filter($filter, array($this, 'my_account_my_orders_title'));
					break;
				
				case 'woocommerce_sale_flash':
					if($label != '')
						add_filter($filter, array($this, 'sale_flash'),40,3);
					break;
				
				case 'woocommerce_short_description':
					if($label != '')
						add_filter($filter, array($this, 'short_description'),10,1);
					break;
					
				case 'wc_add_to_cart_message_html':
					if($label != '')
						add_filter($filter, array($this, 'add_to_cart_message'),10,1);
					break;
				case 'loop_shop_per_page':
					if($label != '')
					
						add_filter($filter, array($this, 'wooh_loop_shop_per_page'),40, 1);
					break;
				case 'loop_shop_columns':
					if($label != '')
						add_filter($filter, array($this, 'wooh_loop_shop_columns'), 40);
					break;
				case 'woocommerce_product_thumbnails_columns':
					if($label != '')
						add_filter($filter, array($this, 'wooh_wc_product_thumbnails_columns'), 40, 1);
					break;
				case 'woocommerce_output_related_products_args':
					if($label != '' || $this->wooh_get_option('_relatedproductcolumns') !='')
						add_filter($filter, array($this, 'wooh_output_related_products_args'), 150);
					break;
			}
			
		}

		/* == Products tabs ==*/
		add_filter( 'woocommerce_product_tabs', array($this, 'wooh_product_tabs'), 98 );
		
		
		/* == Text without filters will be changed with 'gettext' filer ==*/
		add_filter( 'gettext', array($this, 'change_non_filter_text'), 20, 3 );

		
		if($this->wooh_get_option('_disabledrelatedproduct') == 'yes'){
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		}

		
	
		if($this->wooh_get_option('_removeitem') == 'yes'){
			 
			add_action('woocommerce_cart_coupon', array($this, 'remove_cart_item'));
		}
		
	
		
		
		/*
		 * hooking up scripts for front-end
		*/
		add_action('wp_enqueue_scripts', array($this, 'load_scripts_styles'));


		
		
		add_action( 'wp_ajax_wooh_action_settings_save_frontend' ,array($this, 'wooh_action_settings_save_frontend') );
		add_action( 'wp_ajax_nopriv_wooh_action_settings_save_frontend' ,array($this, 'wooh_action_settings_save_frontend') );
		
		

	}
	
	
	
	
	function remove_cart_item(){

		global $woocommerce;
    	if (isset( $_GET['empty-cart'] ) && $woocommerce->cart->get_cart_contents_count() > 0 ) {
	    	
		    $woocommerce->cart->empty_cart();
	    	echo "<script type='text/javascript'>
        		window.location=document.location.href;
        		</script>";
		    
	    }else {
	    	$label = $this->wooh_get_option('_removebtnlabel');
	    	if(empty($label)){
	    		$label = 'Remove Items';
	    	}
			$arr_params = array( 'empty-cart' => true);
			$label = sprintf(__("%s",'personalize-woocommerce-cart-page'), $label);
			echo '<a href="'.esc_url( add_query_arg($arr_params) ).'" class="button" style="margin-right: 10px;">'.esc_attr($label).'</a>';
	    	
	    }
		
	}
	
	
	

	

	public static function get_instance() {
	    // create a new object if it doesn't exist.
		is_null(self::$ins) && self::$ins = new self;
		return self::$ins;
	}

	/*==== Woocommerce filters callbacks start  =====*/
	/*== to render labels on loop ==*/
	function loop_product_add_to_cart_text($text, $product) {

		$product_type = $product->get_type();

		if($this -> filters['woocommerce_product_add_to_cart_text'][$product_type] != '')
			return sprintf( __("%s", 'personalize-woocommerce-cart-page'), wooh_wpml_translate($this->filters['woocommerce_product_add_to_cart_text'][$product_type]));
		else
			return $text;
	}

	/*== render label on single product page ==*/
	function product_single_add_to_cart_text(){
		
		
		return	sprintf( __("%s", 'personalize-woocommerce-cart-page'), wooh_wpml_translate($this -> filters['woocommerce_product_single_add_to_cart_text']));
		
	}


	/*== render label on single product page when out of stock ==*/
	function check_if_out_of_stock($availability, $_product) {
  
	    if ( !$_product->is_in_stock() ) {

			$out_of_stock = wooh_wpml_translate($this -> filters['woocommerce_get_availability']);
	    	$availability['availability'] = sprintf( __("%s", 'personalize-woocommerce-cart-page'), $out_of_stock);	        					
	    	return $availability;
	    	
	    }
	}

	/*== render label on place order button on checkout page ==*/
	function order_button_text(){

		return wooh_wpml_translate($this -> filters['woocommerce_order_button_text']);
	}

	/*== render recent products text on my account page ==*/
	function my_account_my_orders_title(){

		return wooh_wpml_translate($this -> filters['woocommerce_my_account_my_orders_title']);
	}
	
	/*== change sale text on loop ==*/
	function sale_flash($content, $post, $product){
	
		$sale_flash = wooh_wpml_translate($this -> filters['woocommerce_sale_flash']);
	
		return ! empty( $sale_flash ) ? "<span class='onsale'>{$sale_flash}</span>" : $content;
	}	


	/*== Product short description ==*/
	function short_description($description){

		$description = $description. ' '. wooh_wpml_translate($this -> filters['woocommerce_short_description']);
		return sprintf( __("%s", 'personalize-woocommerce-cart-page'), $description );
	}
	
	/*== Product add to cart message ==*/
	function add_to_cart_message( $message ){

		if( isset($this -> filters['wc_add_to_cart_message_html']) && $this -> filters['wc_add_to_cart_message_html'] !=''){
			
			$message = wooh_wpml_translate($this -> filters['wc_add_to_cart_message_html']);
		}
		
		return sprintf( __("%s", 'personalize-woocommerce-cart-page'), $message );
	}
	
	
	function wooh_loop_shop_per_page($e4olve_loop_shop_per_page){
		
	
		if( isset($this -> filters['loop_shop_per_page']) && $this -> filters['loop_shop_per_page'] !=''){
			
			$message = wooh_wpml_translate($this -> filters['loop_shop_per_page']);
			
			$evolve_loop_shop_per_page = $message;
		}
		
	
		return $evolve_loop_shop_per_page;
	}
	
	function wooh_loop_shop_columns(){
		
		if( isset($this -> filters['loop_shop_columns']) && $this -> filters['loop_shop_columns'] !=''){
			
			$evolve_loop_shop_per_colums = wooh_wpml_translate($this -> filters['loop_shop_columns']);
		}
	
		return $evolve_loop_shop_per_colums;
	}
	
	function wooh_wc_product_thumbnails_columns($int){
		
		if( isset($this -> filters['woocommerce_product_thumbnails_columns']) && $this -> filters['woocommerce_product_thumbnails_columns'] !=''){
			
			$thumbnails_columns = wooh_wpml_translate($this -> filters['woocommerce_product_thumbnails_columns']);
			$int = $thumbnails_columns;
		}
	
		return $int;
	}
	
	function wooh_output_related_products_args(){
			
		$posts_per_page = 4;
		$columns		= $this->wooh_get_option('_relatedproductcolumns');
			
		if( isset($this -> filters['woocommerce_output_related_products_args']) && $this -> filters['woocommerce_output_related_products_args'] !=''){
			
			$posts_per_page = wooh_wpml_translate($this -> filters['woocommerce_output_related_products_args']);
		}
		
		return array(
				'posts_per_page' => $posts_per_page,
				'columns'        => $columns,
			);
	}
	

	/* == setting woo tabs ==*/
	function wooh_product_tabs( $tabs ){
		
		
		global $product;
		
		/**
		 * we will use it for inqury form too
		*/
		 
		$defined_tabs = get_option('wooh_tabs');
		
		$disable_default_checked = get_post_meta( $product->get_id(), '_disable_default_tabs', true );
		
		
		//if default tabe are disabled
		
		$priority = 1;
		if($defined_tabs) {
			foreach ($defined_tabs as $tab){

				$tab_id       = sanitize_key($tab['title']);
				$tab_title    = esc_html($tab['title']);
				$default_desc = esc_html($tab['default_desc']);
				
				$tab_title = wooh_wpml_translate($tab_title);
				
				// Adds the new tab

				$tabs[$tab_id] = array(
						'title' 	=> sprintf(__( '%s', 'personalize-woocommerce-cart-page'), $tab_title),
						'default_desc'=> sprintf(__( '%s', 'personalize-woocommerce-cart-page'), $default_desc),
						'priority' 	=> ($priority * 100),
						'tab_id'	=> $tab_id,
						'callback' 	=> array($this, "wooh_product_tabs_contents"),
				);

					
				$priority++;
			}
		}
		
		if($disable_default_checked == 'yes'){
			
			unset( $tabs['description'] );      	// Remove the description tab
    		unset( $tabs['reviews'] ); 			// Remove the reviews tab
    		unset( $tabs['additional_information'] );
    		
		}
		
		
		/* ==Inquiry Tab Settings ==*/
		
		 
		if($this -> wooh_get_option('_enable_enquiry') == 'yes'){

			if ($this -> wooh_get_option('_enquiry_title')) {
				$enq_title = $this -> wooh_get_option('_enquiry_title');
			} else {
				$enq_title = 'Enquiry';
			}
			
			
			$tabs['inquiry_form'] = array(
					'title' 	=> sprintf(__( '%s', 'personalize-woocommerce-cart-page'), $enq_title ),
					'priority' 	=> ($priority * 100),
					'callback' 	=> array($this, "wooh_product_enquiry_form"),
			);
		}
		
		return $tabs;
	}
	

	/*==== Woocommerce filters callbacks end =====*/


	
	
	
	
	


	/*== new tab contents ==*/
	function wooh_product_tabs_contents($key, $tab){
		
		global $product;
		
		// wooh_pa($tab);
		$default_desc = isset($tab['default_desc']) ? stripslashes($tab['default_desc']) : '';
		
		$content = get_post_meta($product->get_id(), "_tab_{$key}", true);
		
		if( empty( $content ) ){
			$content = $default_desc;
		}
		
		$content = wooh_wpml_translate($content);
		
		echo apply_filters('the_content', html_entity_decode($content));
	}
	
	/*== this is rendering the enquiry form ==*/
	function wooh_product_enquiry_form(){
		
		global $product;
		
		ob_start ();
			
		wooh_load_templates( 'admin/inquiry-tab.php', array('product_id'=>$product->get_id()) );
			
		$output_string = ob_get_contents ();
		ob_end_clean ();
		
		echo apply_filters('the_content', $output_string);
	}
	

	function change_non_filter_text( $translated_text, $text, $domain ) {

	    switch ( $translated_text ) {
	
            case 'Proceed to checkout' :

				$proceedcheckout = $this->wooh_get_option('_proceedtocheckouttext');
				
				if(empty($proceedcheckout)) $proceedcheckout="Proceed to checkout";
                
                $translated_text = wooh_wpml_translate($proceedcheckout);
                break;

        }
        
        
        // Since 2.6 Any text can be changable
        $anytexts = $this->wooh_get_option('_anytext');
        $anytexts = preg_split('/\r\n|[\r\n]/', $anytexts);
        // wooh_pa($anytexts);
        
        if( count($anytexts) > 0 ) {
        	
        	foreach( $anytexts as $text ) {
        		
        		$text_line = explode('|', $text);
        		$text_line = array_map('trim', $text_line);
        		$current_t = isset($text_line[0]) ? $text_line[0] : '';
        		$new_t		= isset($text_line[1]) ? $text_line[1] : '';
        		
        		if( $current_t == $translated_text ) {
        			$translated_text = $new_t;
        		}
        		
        		// woostore_pa($text_line);
        	}
        }
        
        
        
	    return $translated_text;
	}
	


	/*==  this function is getting single ==*/
	function wooh_get_option($key){
	
		return $the_option =  get_option('wooh'.$key);
	}


	function load_scripts_styles() {
		
		// if( ! is_product() ) return;

		wp_enqueue_style('wooh-frontend-style', WOOH_URL.'/css/inquiry-form.css');
		wp_enqueue_style('wooh-sweetalet', WOOH_URL.'/css/sweetalert.css');
		
		
		wp_enqueue_script('wooh-scripts-sweetalert', WOOH_URL.'/js/sweetalert.js', true);
		wp_enqueue_script('wooh-frontend-js' , WOOH_URL .'/js/wooh-front-end.js', array('jquery'));
		
		$js_vars = array('ajaxurl' => admin_url( 'admin-ajax.php', (is_ssl() ? 'https' : 'http') ));
		wp_localize_script('wooh-frontend-js', 'wooh_vars', $js_vars);
	}

	
	
	
	
	function wooh_action_settings_save_frontend(){
		
		if(isset($_REQUEST)){
		
			$wooh_key     = sanitize_key($_REQUEST['wooh_key']);
			$text_value   = null;
			
			$key = 'personalize-woocommerce-cart-page'.$wooh_key;
			
			switch($key) {
	    		
	    		case 'wooh_share':
	    		case 'wooh_orderitemstable':
	    		case 'wooh_beforecarttable':
	    		case 'wooh_beforecartcontents':
	    		case 'wooh_cartcontents':
	    		case 'wooh_aftercartcontents':
	    		case 'wooh_aftercarttable':
	    		case 'wooh_aftercart':
	    		case 'wooh_proceedtocheckout':
	    		case 'wooh_cartcoupon':
	    		case 'wooh_beforecarttotals':
	    		case 'wooh_aftercarttotals':
	    		case 'wooh_beforeminicart':
	    		case 'wooh_widgetshoppingcartbeforebuttons':
	    		case 'wooh_afterminicart':
	    		case 'wooh_carttotalsbeforeshipping':
	    		case 'wooh_carttotalsaftershipping':
	    		case 'wooh_carttotalsafterordertotal':
	    		case 'wooh_carttotalsbeforeordertotal':
	    		case 'wooh_beforeshippingcalculator':
	    		case 'wooh_aftershippingcalculator':
	    		case 'wooh_beforeaddtocartbutton':
	    		case 'wooh_afteraddtocartbutton':
	    		case 'wooh_productmetastart':
	    		case 'wooh_beforeaddtocartform':
	    		case 'wooh_afteraddtocartform':
	    		case 'wooh_productmetaend':
	    		case 'wooh_productfeaturedimage':
	    		case 'wooh_addtocartmessage':
	    		case 'wooh_beforecheckoutbillingform':
	    		case 'wooh_aftercheckoutbillingform':
	    		case 'wooh_beforecheckoutregistrationform':
	    		case 'wooh_aftercheckoutregistrationform':
	    		case 'wooh_beforecheckoutform':
	    		case 'wooh_checkoutbeforecustomerdetails':
	    		case 'wooh_checkoutbilling':
	    		case 'wooh_checkoutshipping':
	    		case 'wooh_checkoutaftercustomerdetails':
	    		case 'wooh_aftercheckoutform':
	    		case 'wooh_beforecheckoutshippingform':
	    		case 'wooh_aftercheckoutshippingform':
	    		case 'wooh_beforeordernotes':
	    		case 'wooh_revieworderaftershipping':
	    		case 'wooh_afterordernotes':
	    		case 'wooh_revieworderbeforeshipping':
	    		case 'wooh_revieworderbeforeordertotal':
	    		case 'wooh_revieworderafterordertotal':
	    		case 'wooh_revieworderbeforecartcontents':
	    		case 'wooh_revieworderaftercartcontents':
	    		case 'wooh_revieworderbeforepayment':
	    		case 'wooh_revieworderafterpayment':
	    		case 'wooh_revieworderbeforesubmit':
	    		case 'wooh_revieworderaftersubmit':
	    		case 'wooh_beforecustomerloginform':
	    		case 'wooh_loginformstart':
	    		case 'wooh_loginform':
	    		case 'wooh_loginformend':
	    		case 'wooh_registerformstart':
	    		case 'wooh_registerform':
	    		case 'wooh_registerformend':
	    		case 'wooh_aftercustomerloginform':
	    		case 'wooh_beforemyaccount':
	    		case 'wooh_aftermyaccount':
	    		case 'wooh_myaccountmyorderstitle':
	    		case 'wooh_orderdetailsafterordertable':
	    		case 'wooh_orderdetailsaftercustomerdetails':
	    		case 'wooh_emailheader':
	    		case 'wooh_emailbeforeordertable':
	    		case 'wooh_emailafterordertable':
	    		case 'wooh_emailordermeta':
	    		case 'wooh_emailfooter':
	    		case 'wooh_shortdescription':
	    		case 'wooh_anytext':
	    			
					$text_value =  wp_kses_post($_REQUEST['text_value']);
				break;
				
				default:
					$text_value =  sanitize_text_field($_REQUEST['text_value']);
				break;
	    			
	    	}
	      
			if(update_option($key,$text_value)){
				remove_query_arg('is_active');
				wp_send_json('success');
			}
			
		}
		
	}
		
}

setting_class();
function setting_class() {
	return WOOH_Settings::get_instance();
}