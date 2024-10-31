<?php
/*
 * Admin side function control
*/

/* == Direct access not allowed == */
if( ! defined('ABSPATH' ) ){ exit; }


class WOOH_Admin{
	
	private static $ins = null;

	function __construct(){

		/* == Woohero menu added in menu ==*/
		add_action('admin_menu', array($this, 'wooh_admin_option_settings')); 
		
		if(class_exists('WOOH_MAIN_PRO')){
			
			/* == admin bar menu added ==*/
			
			
			
			
		}
		
		/* == Woohero save settings hook ==*/
		add_action( 'wp_ajax_wooh_save_settings', array($this, 'save_settings'));
		add_action( 'wp_ajax_nopriv_wooh_save_settings', array($this, 'save_settings'));
		
	}

	

	/*=== Woohero menu added in menu function ===*/
	function wooh_admin_option_settings(){

    	add_submenu_page('woocommerce','WooHero', 'WooHero', 'manage_options', 'wooh_settings', array($this , 'wooh_admin_option_settings_template'));

	}

	function wooh_admin_option_settings_template(){
		
		$this->wooh_admin_settings_script();
		
		wooh_load_templates("admin/settings.php");
	}
	
	/*=== Wooh all admin side script ===*/
	function wooh_admin_settings_script(){
	
		/*== CSS Files ==*/
		wp_enqueue_style('wooh-style', WOOH_URL.'/css/style.css');
		wp_enqueue_style('wooh-sweetalet', WOOH_URL.'/css/sweetalert.css');
		wp_enqueue_style('wooh-easytabs', WOOH_URL.'/js/easytabs/tabs.css');
	
	
		/*== JS Files ==*/
		wp_enqueue_script('wooh-scripts-sweetalert', WOOH_URL.'/js/sweetalert.js', true);
		wp_enqueue_script('wooh-scripts-admin', WOOH_URL.'/js/admin.js', true);
		wp_enqueue_script('wwoh-scripts-global', WOOH_URL.'/js/nm-global.js', true);
		wp_enqueue_script('wooh-tabs', WOOH_URL.'/js/easytabs/jquery.easytabs.js', true);
		wp_enqueue_script('wooh-new-scripts-admin', WOOH_URL.'/js/wooh-admin.js',  array('jquery-ui-sortable','jquery'), WOOH_VERSION,  true);
		
		$js_vars = array('ajaxurl' => admin_url( 'admin-ajax.php', (is_ssl() ? 'https' : 'http') ));
		wp_localize_script('wooh-new-scripts-admin', 'wooh_vars', $js_vars);
	}

	
	/*=== saving admin setting in wp option data table ===*/
  	function save_settings(){
  		
	    $nonce = $_REQUEST['_wpnonce_id'];
	    
	    if ( !wp_verify_nonce( $nonce, 'wooh_nonce' ) ){
			
			$response = array( 'status'   => 'error',
	                           'message'  => __('Sorry for security reason.', 'personalize-woocommerce-cart-page'),
	                    );  
	    }else{

		      $settings = array();
		      
		      if(!array_key_exists('wooh_enable_enquiry', $_REQUEST)){
		      		
		      		$settings['wooh_enable_enquiry'] = 'no';
		      }
		      if(!array_key_exists('wooh_removeitem', $_REQUEST)){
		      		
		      		$settings['wooh_removeitem'] = 'no';
		      }
		      if(!array_key_exists('wooh_protectproduct', $_REQUEST)){
		      		
		      		$settings['wooh_protectproduct'] = 'no';
		      }
		      if(!array_key_exists('wooh_disabledrelatedproduct', $_REQUEST)){
		      		
		      		$settings['wooh_disabledrelatedproduct'] = 'no';
		      }
	      
	    		foreach($_REQUEST as $key => $value) {
	      
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
	    		case 'wooh_beforetermcondition':
	    		case 'wooh_beforetermcondition':
	    		case 'wooh_anytext':
	    
					$settings[$key] =  wp_kses_post($value);
				break;
				
				default:
					$settings[$key] =  sanitize_text_field($value);
				break;
	    			
	    	}
	      }
	      
	      
		      foreach ($settings as $s_key => $s_value) {
		        update_option($s_key, $s_value);
		        
		      }
	      
	      $response = array( 'status'   => 'success',
	                          'message'  => __('All options are updated.', 'personalize-woocommerce-cart-page'),
	                      );
	    }
	    
	      wp_send_json( $response );
	}
	
	
	public static function get_instance() {
	    // create a new object if it doesn't exist.
		is_null(self::$ins) && self::$ins = new self;
		return self::$ins;
	}

}

admin_class();
function admin_class() {
	return WOOH_Admin::get_instance();
}