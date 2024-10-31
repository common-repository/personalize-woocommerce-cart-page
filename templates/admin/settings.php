<?php 
/*
 * this file rendering admin options for the plugin
*/

global $nmwoostore;


$admin_settings = wooh_admin_settings_array();

?>

<div class="wooh_refresh_loader"></div>
<div id="wooh-hole-code" style="display:none">
	<h2><?php _e('WooHero Store Customization', 'personalize-woocommerce-cart-page');?></h2>
	<form id="wooh_store_settings_save">
		<div id="filemanager-tabs">

		<input type="hidden"  name="action" value="wooh_save_settings" >
		<input type="hidden" id="_wpnonce_id" name="_wpnonce_id" value="<?php echo wp_create_nonce( 'wooh_nonce' ) ?>" >
	
		<ul id="nm-tabs">
			<?php foreach($admin_settings as $id => $option){ ?>
			<li>
				<a name="#<?php echo esc_attr($id);?>" id="#<?php echo esc_attr($id);?>" href="#<?php echo esc_attr($id);?>"><?php echo esc_html($option['name']);?></a>
			</li>
			<?php }?>
		</ul>
		<select id="nm-tabs-mobile" class="widefat">
			<?php foreach($admin_settings as $id => $option){ ?>
				<option value="#<?php echo esc_attr($id);?>"><?php echo esc_html($option['name']);?></option>
			<?php }?>
		</select>
		<div id="nm-content">
			<?php foreach($admin_settings as $id => $options){ ?>
				<div id="<?php echo esc_attr($id);?>" class="general-settings">
					<p> <?php echo wp_kses_post($options['desc']);?> </p>
					<ul>
					<?php 
						foreach($options['meat'] as $key => $data){
			
							$default_value = (isset($data['default']) ? $data['default'] : '');
							$the_value     = get_option($data['id']);
					?>
				
					<li id="<?php echo esc_attr($key);?>" class="plugin-field-set">			
						<?php switch($data['type']){
							case 'text':
								$text_val = stripcslashes($the_value); 
						?>
						<ul>
							
							<label class="setting-text" for="<?php echo esc_attr($data['id']);?>">
								<?php echo esc_html($data['label']);?> 
							</label>
							<br/>
							<input type="text" name="<?php echo esc_attr($data['id']);?>" id="<?php echo esc_attr($data['id']);?>" value="<?php echo get_option($data['id']); ?>" class="regular-text" style="float: left;margin-right: 10px;margin-top: 13px;">
							<li>
								<h4><?php echo wp_kses_post($data['desc'])?></h4>
								<br/>
							<em class="help"><?php echo wp_kses_post($data['help']);?> </em> 
							</li>
							
						</ul> <?php 
						break;
						case 'textarea':
							?>
								<ul>
									<label class="textarea-class" for="<?php echo esc_attr($data['id']);?>"><?php echo esc_html($data['label']);?>
										
									</label><br/> 
									<textarea cols="45" rows="6" name="<?php echo esc_attr($data['id']);?>" id="<?php echo esc_attr($data['id']);?>"><?php echo stripcslashes($the_value)?></textarea>
									<li><h4><?php echo wp_kses_post($data['desc']);?> </h4>
									<br />
									<em><?php echo wp_kses_post($data['help']);?> </em>
									</li>
								</ul> 
						<?php 
						break;
						
						case 'checkbox':?>
						<ul>
							<li>
							<h4><?php echo wp_kses_post($data['desc']);?> </h4>
							
							<?php
							 
							foreach($data['options'] as $k => $label){?>
							
								<label for="<?php echo esc_attr($data['id']);?>"> <input type="checkbox" name="<?php echo esc_attr($data['id']);?>" id="<?php echo $data['id']; ?>" value="yes" <?php checked(get_option($data['id']), 'yes', true); ?> > <?php echo $label?>
								</label>
							<?php }?>
							
							<br />
							<em><?php echo wp_kses_post($data['help']);?> </em> 
							</li>
						</ul>
						<?php break;
						case 'radio':?>
								<ul>
									<li>
									<h4><?php echo wp_kses_post($data['desc'])?> </h4>
									
									<?php foreach($data['options'] as $k => $label){?>
									
										<label for="<?php echo esc_attr($data['id'].'-'.$k);?>"> <input type="radio" name="<?php echo esc_attr($data['id']);?>" id="<?php echo esc_attr($data['id'].'-'.$k);?>" value="<?php echo $k?>"> <?php echo $label?></label>
									<?php }?>
									
									<br />
									<em><?php echo wp_kses_post($data['help']);?> </em> 
									</li>
								</ul>
						<?php break;
				
						case 'select':?>
								<ul>
									<li>
										<h4><?php echo wp_kses_post($data['desc'])?> </h4>
										
											<label for="<?php echo esc_attr($data['id']);?>"><?php echo esc_html($data['label']);?> 										 
											<select name="<?php echo esc_attr($data['id']);?>" id="<?php echo esc_attr($data['id']);?>">
												<option value=""><?php echo esc_html($data['default']);?></option>
												
												<?php foreach($data['options'] as $k => $label){
													
														$selected = ($k == $nmwoostore -> plugin_settings[ $data['id'] ]) ? 'selected = "selected"' : '';
														
														echo '<option value="'.esc_attr($k).'" '.esc_attr($selected).'>'.esc_html($label).'</option>';
												}
													?>
												
											</select> 
											</label>
										<br />
										<em><?php echo wp_kses_post($data['help']);?> </em>
									</li>
								</ul>
							<?php break;
								
							case 'para':?>
									<ul>
										<li>
										<h4><?php echo wp_kses_post($data['desc'])?> </h4>
										
										<br />
										<em><?php echo wp_kses_post($data['help']);?> </em>
										</li>
									</ul>
								<?php break;
		
							case 'file':?>
									<ul >
										<li>
										<?php 
										
										wooh_load_templates($data['id']);
										?> 
										</li>
									</ul>
													
							<?php break;

					} ?></li>
			<?php }
			
			?>
		</ul>

	<?php ?>
	<input type="submit" class="button button-primary" Value="<?php _e('Save settings', 'personalize-woocommerce-cart-page')?>">
	</p>
	
	</div>

	<?php 
	}
	?>
</div>
</div>
</form>
</div>