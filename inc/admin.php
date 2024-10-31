<?php 
/*
** Woo Hero Admin side Functionality
*/

/* == Direct access not allowed ==*/
if( ! defined('ABSPATH' ) ){ exit; }



function wooh_wpml_translate($field_value, $domain='personalize-woocommerce-cart-page') {
		
	$field_name = $domain . ' - ' . sanitize_key($field_value);
	
	
	//WMPL
    /**
     * register strings for translation
     * source: https://wpml.org/wpml-hook/wpml_translate_single_string/
     */
    
    $field_value = stripslashes($field_value);
    
	return apply_filters('wpml_translate_single_string', $field_value, $domain, $field_name );

}

/* == render field in product tabs ==*/
function render_the_row($contents, $label_counter){
   
    echo '<div class="meta-row first-element">
        <table cellspacing="20">
          <tr>
            <td class="clone-me"><img src="'.WOOH_URL.'/images/plus.png" alt="Add"></td>
            <td class="remove-me"><img src=" '.WOOH_URL.'/images/minus.png" alt="Remove"></td>
            <td>
            <label style="font-weight:bold !important" for="default_tab">Tab Title</label></br>
              <input name="tab_title" type="text" placeholder="Tab Name Here..." value=" '.$contents['title'].'">
            </td>
            <td>
              <label style="font-weight:bold !important" for="default_desc">Default Description</label>
              <textarea name="default_desc" id="default_desc" rows="2">'.$contents['default_desc'].'</textarea>
            </td>
            </td>
          </tr>
        </table>
      </div>';
}

/* == render field in product tabs default ==*/
function render_the_default(){

	echo '<div class="meta-row first-element">
	    <table cellspacing="20">
	      <tr>
	        <td class="clone-me"><img src="'.WOOH_URL.'/images/plus.png" alt="Add"></td>
	        <td class="remove-me"><img src="'.WOOH_URL.'/images/minus.png" alt="Remove"></td>
	        <td>
	          <input name="tab_title" type="text" placeholder="Tab Name Here..." value="">
	        </td>
	        <td>
	          <label for="default_desc">Default Description</label>
	          <textarea name="default_desc" id="default_desc" rows="2"></textarea>
	        </td>
	        </td>
	      </tr>
	    </table>
	  </div>';
}

/* == Wooh settings ==*/
function wooh_admin_settings_array(){

	$setting = array('label-page' => array( 'name'		=> __('Button Labels', 'personalize-woocommerce-cart-page'),
											'type'	=> 'tab',
											'desc'	=> __('Here you can personalized all 
																buttons labels. <a href="http://
																www.najeebmedia.com/personalized-woostore-guide/#buttons"
																target="_blank">How it works!</a>'
																, 'woohero'),
											'meat'	=> array('add-to-cart-text-simple' => array(
													'label' => __('Add to cart', 'woohero'),
					 								'desc'	=> __('It will replace button label
					 								               for products in <b>Shop</b>', 'woohero'),
					 								'id'			=> 'wooh_'.'addtocartsimple',
						 							'type'			=> 'text',
						 							'default'		=> '',
						 							'help'			=> ''
					 							),

											'add-to-cart-text-single'	=> array(	'label'		=> __('Single product add to cart', 'personalize-woocommerce-cart-page'),
						 							'desc'		=> __('It will replace default add to cart button label on <b>Single Product Page</b>', 'personalize-woocommerce-cart-page'),
						 							'id'			=> 'wooh_'.'addtocartsingle',
						 							'type'			=> 'text',
						 							'default'		=> '',
						 							'help'			=> ''
						 							),

										'add-to-cart-text-grouped'	=> array(	'label'		=> __('View products', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will replace default button label for <b>Grouped Products in Shop</b>', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'addtocartgrouped',
					 							'type'			=> 'text',
					 							'default'		=> '',
					 							'help'			=> ''
					 							),

										'add-to-cart-text-variable'	=> array(	'label'		=> __('Select options', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will replace default button label for <b>Variable Products in Shop</b>', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'addtocartvariable',
					 							'type'			=> 'text',
					 							'default'		=> '',
					 							'help'			=> ''
					 							),

										'add-to-cart-text-external'	=> array(	'label'		=> __('Buy product', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will replace default button label for <b>Eternal Products in Shop</b>', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'addtocartexternal',
					 							'type'			=> 'text',
					 							'default'		=> '',
					 							'help'			=> ''
					 							),

										'add-to-cart-text-out'	=> array(	'label'		=> __('Single product out of stock', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will replace default out of stock text on <b>Single Product Page</b>', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'addtocartout',
					 							'type'			=> 'text',
					 							'default'		=> '',
					 							'help'			=> ''
					 							),

										'order-button-text'	=> array(	'label'		=> __('Order button text', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will replace default order button label on <b>Checkout Page</b>', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'orderbuttontext',
					 							'type'			=> 'text',
					 							'default'		=> '',
					 							'help'			=> ''
					 							),
					 					),
									),

							
																				
				'cart-page'	=> array(	'name'	=> __('Cart Page', 'personalize-woocommerce-cart-page'),
														'type'	=> 'tab',
														'desc'	=> __('Here you can personalized cart page areas. <a href="http://www.najeebmedia.com/personalized-woostore-guide/#cart" target="_blank">How it works!</a>', 'personalize-woocommerce-cart-page'),
														'meat'	=> array(
					'before-cart-table'	=> array(	'label'		=> __('Before cart table', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>Before cart TABLE</b> on Cart Page', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'beforecarttable',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('You can use HTML tags', 'personalize-woocommerce-cart-page')
					 							),

					'before-cart-contents'	=> array(	'label'		=> __('Before cart contents', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>Before cart CONTENTS</b> on Cart Page', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'beforecartcontents',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('Write between &lt;tr&gt;&lt;td&gt; &lt;/td&gt;&lt;/tr&gt;', 'personalize-woocommerce-cart-page')
					 							),

					'cart-contents'	=> array(	'label'		=> __('After products', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>After cart ITEMS</b> on Cart Page', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'cartcontents',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('Write between &lt;tr&gt;&lt;td&gt; &lt;/td&gt;&lt;/tr&gt;', 'personalize-woocommerce-cart-page')
					 							),
					
					'after-cart-contents'	=> array(	'label'		=> __('After cart contents', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text below PROCEED TO CHECKOUT button on cart page', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'aftercartcontents',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('Write between &lt;tr&gt;&lt;td&gt; &lt;/td&gt;&lt;/tr&gt;', 'personalize-woocommerce-cart-page')
					 							),

					'after-cart-table'	=> array(	'label'		=> __('After cart table', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>After cart TABLE</b> on Cart Page', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'aftercarttable',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('You can use HTML tags', 'personalize-woocommerce-cart-page')
					 							),

					'after-cart'	=> array(	'label'		=> __('At bottom of page', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text at the <b>Bottom</b> on Cart Page', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'aftercart',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('You can use HTML tags', 'personalize-woocommerce-cart-page')
					 							),

					'proceed-to-checkout'	=> array(	'label'		=> __('After proceed to checkout button', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>After PROCEED TO CHECKOUT</b> button on Cart Page', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'proceedtocheckout',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('You can use HTML tags', 'personalize-woocommerce-cart-page')
					 							),

					'cart-coupon'	=> array(	'label'		=> __('After coupon button', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>After COUPON button on Cart Page</b>', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'cartcoupon',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('You can use HTML tags', 'personalize-woocommerce-cart-page')
					 							),

					'before-cart-totals'	=> array(	'label'		=> __('Before cart totals', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>Before CART TOTALS</b> on Cart Page', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'beforecarttotals',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('You can use HTML tags', 'personalize-woocommerce-cart-page')
					 							),

					'after-cart-totals'	=> array(	'label'		=> __('After cart totals', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>After CART TOTALS</b> on cart page', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'aftercarttotals',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('You can use HTML tags', 'personalize-woocommerce-cart-page')
					 							),

					'cart-is-empty'	=> array(	'label'		=> __('When cart empty', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text when <b>Cart is Empty</b>', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'cartisempty',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('You can use HTML tags', 'personalize-woocommerce-cart-page')
					 							),

					'before-mini-cart'	=> array(	'label'		=> __('Before mini cart', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>Before MINI CART</b>', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'beforeminicart',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('You can use HTML tags', 'personalize-woocommerce-cart-page')
					 							),

					'widget-shopping-cart-before-buttons'	=> array(	'label'		=> __('Widget cart before buttons', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text before button of <b>Widget Shopping</b> cart', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'widgetshoppingcartbeforebuttons',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('You can use HTML tags', 'personalize-woocommerce-cart-page')
					 							),

					'after-mini-cart'	=> array(	'label'		=> __('After mini cart', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>After Mini Cart</b>', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'afterminicart',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('You can use HTML tags', 'personalize-woocommerce-cart-page')
					 							),

					'cart-totals-before-shipping'	=> array(	'label'		=> __('Cart totals before shipping', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>Before Shipping</b> cart totals', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'carttotalsbeforeshipping',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('Write between &lt;tr&gt;&lt;td&gt; &lt;/td&gt;&lt;/tr&gt;', 'personalize-woocommerce-cart-page')
					 							),

					'cart-totals-after-shipping'	=> array(	'label'		=> __('Cart totals after shipping', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>After Shipping</b> cart totals', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'carttotalsaftershipping',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('Write between &lt;tr&gt;&lt;td&gt; &lt;/td&gt;&lt;/tr&gt;', 'personalize-woocommerce-cart-page')
					 							),

					'cart-totals-before-order-total'	=> array(	'label'		=> __('Before order total', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>Before Order Totals</b>', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'carttotalsbeforeordertotal',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('Write between &lt;tr&gt;&lt;td&gt; &lt;/td&gt;&lt;/tr&gt;', 'personalize-woocommerce-cart-page')
					 							),
					
					'cart-totals-after-order-total'	=> array(	'label'		=> __('After order total', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>After Order Totals</b>', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'carttotalsafterordertotal',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('Write between &lt;tr&gt;&lt;td&gt; &lt;/td&gt;&lt;/tr&gt;', 'personalize-woocommerce-cart-page')
					 							),
					
					'before-shipping-calculator'	=> array(	'label'		=> __('Before shipping calculator', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>Before Shipping Calculator</b>', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'beforeshippingcalculator',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('You can use HTML tags', 'personalize-woocommerce-cart-page')
					 							),
					
					'after-shipping-calculator'	=> array(	'label'		=> __('After shipping calculator', 'personalize-woocommerce-cart-page'),
					 							'desc'		=> __('It will show text <b>After Shipping Calculator</b>', 'personalize-woocommerce-cart-page'),
					 							'id'			=> 'wooh_'.'aftershippingcalculator',
					 							'type'			=> 'textarea',
					 							'default'		=> '',
					 							'help'			=> __('You can use HTML tags', 'personalize-woocommerce-cart-page')
					 							),
					
				),
			),

			'get-pro'		=> array(	'name'		=> __('Pro Features', 'personalize-woocommerce-cart-page'),
															'type'	=> 'tab',
															'desc'	=> __('Get PRO version and enjoy following features', 'personalize-woocommerce-cart-page'),
															'meat'	=> array('file-meta'	=> array(	
									'desc'		=> '',
									'type'		=> 'file',
									'id'		=> 'get-pro.php',
									),
								),
														),
			'get-ppom'		=> array(	'name'		=> __('Product Addon', 'personalize-woocommerce-cart-page'),
															'type'	=> 'tab',
															'desc'	=> __('WooCommerce Product Addon', 'personalize-woocommerce-cart-page'),
															'meat'	=> array('file-meta'	=> array(	
									'desc'		=> '',
									'type'		=> 'file',
									'id'		=> 'get-ppom.php',
									),
								),
														
														),
	

		);


			return apply_filters( 'wooh_options_settings', $setting);



}