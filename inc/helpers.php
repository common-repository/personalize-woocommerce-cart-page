<?php 
/*
** Woo Hero Helper Functions
*/

/* == Direct access not allowed ==*/
if( ! defined('ABSPATH' ) ){ exit; }


/* == Load templates ==*/
function wooh_load_templates( $template_name, $vars = null) {

    if( $vars != null && is_array($vars) ){
        extract( $vars );
    };

    $template_path =  WOOH_PATH . "/templates/{$template_name}";
    if( file_exists( $template_path ) ){
    	require ( $template_path );
    } else {
        die( "Error while loading file {$template_path}" );
    }
}

/* == Print defualt array ==*/
function wooh_pa($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}


/**
* Lets add the woocommerce relation hooks
* actions
* =============== woocommerce action hooks ===============*/
function wooh_text_hooks_array() {
    

    $hooks_array = array(
    	/* ==== Cart Page ==== */
    	'woocommerce_before_cart_table'		   			=> '_beforecarttable',
    	'woocommerce_before_cart_contents'	     		=> '_beforecartcontents',
    	'woocommerce_cart_contents'						=> '_cartcontents',
    	'woocommerce_after_cart_contents'				=> '_aftercartcontents',
    	'woocommerce_after_cart_table'					=> '_aftercarttable',
    	'woocommerce_after_cart'						=> '_aftercart',
    	'woocommerce_proceed_to_checkout'				=> '_proceedtocheckout',
    	'woocommerce_cart_coupon'						=> '_cartcoupon',
    	'woocommerce_after_cart_totals'					=> '_aftercarttotals',
    	'woocommerce_before_cart_totals'				=> '_beforecart_totals',
    	'woocommerce_cart_is_empty'						=> '_cartis_empty',
    	'woocommerce_before_mini_cart'					=> '_beforeminicart',
    	'woocommerce_widget_shopping_cart_before_buttons'	=> '_widgetshoppingcartbeforebuttons',
    	'woocommerce_after_mini_cart'					=> '_afterminicart',
    	'woocommerce_cart_totals_before_shipping'		=> '_carttotalsbeforeshipping',
    	'woocommerce_cart_totals_after_shipping'		=> '_carttotalsaftershipping',
    	'woocommerce_cart_totals_before_order_total'	=> '_carttotalsbeforeordertotal',
    	'woocommerce_cart_totals_after_order_total'		=> '_carttotalsafterordertotal',
    	'woocommerce_before_shipping_calculator'		=> '_beforeshippingcalculator',
    	'woocommerce_after_shipping_calculator'			=> '_aftershippingcalculator',
    
    	/* ==== Checkout Page ==== */
    	'woocommerce_before_checkout_billing_form'		=> '_beforecheckoutbillingform',
    	'woocommerce_after_checkout_billing_form'		=> '_aftercheckoutbillingform',
    	'woocommerce_before_checkout_registration_form'	=> '_beforecheckoutregistrationform',
    	'woocommerce_after_checkout_registration_form'	=> '_aftercheckoutregistrationform',
    	'woocommerce_before_checkout_form'				=> '_beforecheckoutform',
    	'woocommerce_checkout_before_customer_details'	=> '_checkoutbeforecustomerdetails',
    	'woocommerce_checkout_billing'					=> '_checkoutbilling',
    	'woocommerce_checkout_shipping'					=> '_checkoutshipping',
    	'woocommerce_checkout_after_customer_details'	=> '_checkoutaftercustomerdetails',
    	//'woocommerce_checkout_order_review'			=> '_checkoutorderreview',
    	'woocommerce_after_checkout_form'				=> '_aftercheckoutform',
    	'woocommerce_before_checkout_shipping_form'		=> '_beforecheckoutshippingform',
    	'woocommerce_after_checkout_shipping_form'		=> '_aftercheckoutshippingform',
    	'woocommerce_before_order_notes'				=> '_beforeordernotes',
    	'woocommerce_after_order_notes'					=> '_afterordernotes',
    	'woocommerce_review_order_before_shipping'		=> '_revieworderbeforeshipping',
    	'woocommerce_review_order_after_shipping'		=> '_revieworderaftershipping',
    	'woocommerce_review_order_before_order_total'	=> '_revieworderbeforeordertotal',
    	'woocommerce_review_order_after_order_total'	=> '_revieworderafterordertotal',
    	'woocommerce_review_order_before_cart_contents'	=> '_revieworderbeforecartcontents',
    	'woocommerce_review_order_after_cart_contents'	=> '_revieworderaftercartcontents',
    	'woocommerce_review_order_before_payment'		=> '_revieworderbeforepayment',
    	'woocommerce_review_order_before_submit'		=> '_revieworderbeforesubmit',
    	'woocommerce_review_order_after_submit'			=> '_revieworderaftersubmit',
    	'woocommerce_review_order_after_payment'		=> '_revieworderafterpayment',	
    	'woocommerce_checkout_before_terms_and_conditions'		=> '_beforetermcondition',	
    	'woocommerce_checkout_after_terms_and_conditions'		=> '_aftertermcondition',	
    
    	/* ==== My Account Page ==== */
    	'woocommerce_before_customer_login_form'	=> '_beforecustomerloginform',	
    	'woocommerce_login_form_start'				=> '_loginformstart',	
    	'woocommerce_login_form'					=> '_loginform',	
    	'woocommerce_login_form_end'				=> '_loginformend',	
    	'woocommerce_register_form_start'			=> '_registerformstart',	
    	'woocommerce_register_form'					=> '_registerform',	
    	'woocommerce_register_form_end'				=> '_registerformend',	
    	'woocommerce_after_customer_login_form'		=> '_aftercustomerloginform',	
    	'woocommerce_before_my_account'				=> '_beforemyaccount',	
    	'woocommerce_after_my_account'				=> '_aftermyaccount',
    
    	/* ==== Order Details Page ==== */
    	'woocommerce_order_details_after_order_table_items'	=> '_orderitemstable',
    	'woocommerce_order_details_after_order_table'	    => '_orderdetailsafterordertable',
    	'woocommerce_order_details_after_customer_details'	=> '_orderdetailsaftercustomerdetails',
    
    	/* ==== Single Product Page ==== */
    	'woocommerce_before_single_product'             => '_beforesingleproduct',
    	'woocommerce_before_add_to_cart_quantity'       => '_beforeaddtocartquantity',
    	'woocommerce_after_add_to_cart_quantity'        => '_afteraddtocartquantity',
    	'woocommerce_before_add_to_cart_button'			=> '_beforeaddtocartbutton',
    	'woocommerce_after_add_to_cart_button'			=> '_afteraddtocartbutton',
    	'woocommerce_before_add_to_cart_form'			=> '_beforeaddtocartform',
    	'woocommerce_grouped_product_list_before_price'	=> '_groupedproductlistbeforeprice',
    	'woocommerce_after_add_to_cart_form'			=> '_afteraddtocartform',
    	'woocommerce_product_meta_start'				=> '_productmetastart',
    	'woocommerce_product_meta_end'				    => '_productmetaend',
    	'woocommerce_product_thumbnails'				=> '_productfeaturedimage',
    	'woocommerce_after_single_product'              => '_aftersingleproduct',
    
    	/* ==== Email Template ==== */
    	'woocommerce_email_header'				=> '_emailheader',
    	'woocommerce_email_before_order_table'	=> '_emailbeforeordertable',
    	'woocommerce_email_after_order_table'	=> '_emailafterordertable',
    	'woocommerce_email_order_meta'			=> '_emailordermeta',
    	'woocommerce_email_footer'				=> '_emailfooter',
    
    
    	'woocommerce_share'	=> '_share',
    
    );
    
    return apply_filters('wooh_text_hooks_array', $hooks_array);
}