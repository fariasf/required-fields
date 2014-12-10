<?php
/*
* Plugin Name: Required Fields
* Plugin URI: http://nikostsolakos.tk/wordpress/Required_Fields/Required_Fields.zip
* Description: Required Fields can check if you have fill in all the fields you have enabled
* Version: 1.0
* Author: NikosTsolakos
* Author URI: http://nikostsolakos.tk
* License: GPLv2
*/

/*
*	1. Plugin Activation / De-Activation
*	2. Admin Settings
*/

// =====
// 1. Plugin Activation / De-Activation
// =====

// Activation Start
register_activation_hook( __FILE__, "rf_activated");
function rf_activated()
{
	$default_settings = array(
        'rf_enabled_settings' => '0',
		'rf_title_settings' => 'checked',
		'rf_category_settings' => 'checked',
		'rf_tag_settings' => 'checked',
		'rf_image_settings' => 'checked'
    );
	add_option("rf_settings", $default_settings);
}
// Activation End

// De-Activation Start
register_deactivation_hook(__FILE__, 'rf_deactivated');
function rf_deactivated()
{
	delete_option( 'rf_settings' );
}
// De-Activation End

// =====
// 2. Admin Settings
// =====
function rf_settings_init()
{
	register_setting('rf_settings', 'rf_settings', 'rf_settings_validate');
	// Main Section
	add_settings_section('rf_main_section', '<h3 style="text-align: center;border: solid 1px #D23733;background: #D23733;color: white;">Required Fields</h3>', 'rf_main_section_text', __FILE__);
	// Fields Of Main Section
	add_settings_field('rf_title_settings', 'Set Title Required:', 'rf_title_settings', __FILE__, 'rf_main_section');
	add_settings_field('rf_category_settings', 'Set Categories Required:', 'rf_category_settings', __FILE__, 'rf_main_section');
	add_settings_field('rf_tag_settings', 'Set Tags Required:', 'rf_tag_settings', __FILE__, 'rf_main_section');
	add_settings_field('rf_image_settings', 'Set thumbnail Required:', 'rf_image_settings', __FILE__, 'rf_main_section');

}
// Add rf_settings_init to Admin Section
add_action('admin_init', 'rf_settings_init' );

// Functions Of Fields Start
function rf_settings_validate($input) {
	return $input; 
}
function rf_main_section_text(){
}

function rf_enabled_settings()
{
	$opt = get_option( 'rf_settings' );
	if (!isset($opt['rf_enabled_settings']))
	{
		$value = '0';
	} else {
		$value = $opt['rf_enabled_settings'];
	}
}

function rf_title_settings()
{
	$opt = get_option('rf_settings');
	if (!isset($opt['rf_title_settings']))
	{
		$value = '';
		echo '<div class="slideThree" style=" top: 0px; "><input type="checkbox" class="ch_location" value="None" id="rf_title_settings" style="display: none;" name="rf_settings[rf_title_settings]" '.$value.' /><label for="rf_title_settings"></label></div>';
	} else {
		$value = $opt['rf_title_settings'];
		echo '<div class="slideThree" style=" top: 0px; "><input type="checkbox" class="ch_location" value="None" id="rf_title_settings" style="display: none;" name="rf_settings[rf_title_settings]" checked /><label for="rf_title_settings"></label></div>';
	}
}

function rf_category_settings()
{
	$opt = get_option('rf_settings');
	if (!isset($opt['rf_category_settings']))
	{
		$value = '';
		echo '<div class="slideThree" style=" top: 0px; "><input type="checkbox" class="ch_location" value="None" id="rf_category_settings" style="display: none;" name="rf_settings[rf_category_settings]" '.$value.' /><label for="rf_category_settings"></label></div>';
	} else {
		$value = $opt['rf_category_settings'];
		echo '<div class="slideThree" style=" top: 0px; "><input type="checkbox" class="ch_location" value="None" id="rf_category_settings" style="display: none;" name="rf_settings[rf_category_settings]" checked /><label for="rf_category_settings"></label></div>';
	}
}

function rf_tag_settings()
{
	$opt = get_option('rf_settings');
	if (!isset($opt['rf_tag_settings']))
	{
		$value = '';
		echo '<div class="slideThree" style=" top: 0px; "><input type="checkbox" class="ch_location" value="None" id="rf_tag_settings" style="display: none;" name="rf_settings[rf_tag_settings]" '.$value.' /><label for="rf_tag_settings"></label></div>';
	} else {
		$value = $opt['rf_tag_settings'];
		echo '<div class="slideThree" style=" top: 0px; "><input type="checkbox" class="ch_location" value="None" id="rf_tag_settings" style="display: none;" name="rf_settings[rf_tag_settings]" checked /><label for="rf_tag_settings"></label></div>';
	}
}

function rf_image_settings()
{
	$opt = get_option('rf_settings');
	if (!isset($opt['rf_image_settings']))
	{
		$value = '';
		echo '<div class="slideThree" style=" top: 0px; "><input type="checkbox" class="ch_location" value="None" id="rf_image_settings" style="display: none;" name="rf_settings[rf_image_settings]" '.$value.' /><label for="rf_image_settings"></label></div>';
	} else {
		$value = $opt['rf_image_settings'];
		echo '<div class="slideThree" style=" top: 0px; "><input type="checkbox" class="ch_location" value="None" id="rf_image_settings" style="display: none;" name="rf_settings[rf_image_settings]" checked /><label for="rf_image_settings"></label></div>';
	}

}

// Functions Of Fields End

// Set Plugin To Admin Menu
add_action('admin_menu', 'rf_admin_actions');

function rf_admin_panel()
{
	if ( !current_user_can( 'manage_options' ) ) 
	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	$opt = get_option('rf_settings');
?>
	
	<div class="wrap" id="required_fields">
		<form action="options.php" method="post">
			<div id="poststuff">
				<div class="title_box">
					<h1>Required Fields</h1>						
				</div>	
				<div class="postbox" style="">
					<h3 style="color: #ffffff;"><div style="text-align: center;border: solid 1px #D23733;background: #D23733;" id="advanced">Active / De-Active</div></h3>
					<div style="margin: 10px !important;">
						<span>
						<style><?php require_once('css/checkbox.css');?></style>
							<section style=" margin-bottom: -30px !important; ">
								<p>Required Fields: </p>
									<div class="slideThree">
										<input type="checkbox" class="ch_location" value="None" id="slideThree" style="display: none;" name="rf_settings[rf_enabled_settings]" <?php if ( $opt['rf_enabled_settings'] )  echo 'checked';?> />
										<label for="slideThree"></label>
									</div>
							</section>
						</span>
					</div>
				</div>				
				<div class="postbox">
					<?php settings_fields('rf_settings'); ?>
					<?php do_settings_sections(__FILE__); ?>
					<style>
					.content {
						display: block;
						padding: 15px;
					}
					.adv-margin {
						padding-bottom: 20px;
					}
					.mr {
						margin-right: 50px;
					}
					h3 {
						padding: 0!important;
					}
					.form-table, .form-table td, .form-table td p, .form-table th, .form-wrap label {
						padding-left: 10px!important;					}
					input {
						border-radius: 15px;
					}
					a {
						color: #000000;
					}
					.button-primary {
						background: #D23733!important;
						border-color: #AE322F!important;
						-webkit-box-shadow: inset 0 1px 0 rgba(239, 115, 112, 1),0 1px 0 rgba(0,0,0,.15)!important;
						box-shadow: inset 0 1px 0 rgba(239, 115, 112, 1),0 1px 0 rgba(0,0,0,.15)!important;
						border-radius: 25px!important;
					}
					</style>
					<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
					<p class="submit" style="margin-left: 10px;">
						<input id="submit-rf-options" name="Submit" type="submit"  class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
					</p>
				</div>
			</div>
		</form>
	</div>
<?php }

function rf_admin_actions() {
	add_options_page("Required Fields Options", "Required Fields", 'manage_options', "Required_Fields", "rf_admin_panel");
}

// =====
// 3. Frontend
// =====
function wp_rf_sc()
{
	$opt = get_option('rf_settings');
	wp_enqueue_script('jquery');
}
add_action( 'wp_enqueue_script', 'wp_rf_sc' );
	// Check Functions And Run
	function required_fields()
	{
		$opt = get_option('rf_settings');
		if( isset($opt['rf_enabled_settings']) )
		{
			if ( isset($opt['rf_title_settings']) )
			{
				global $post_type;
				if($post_type=='post')
				{	
					echo "<script type='text/javascript'>\n";
					  echo "
					  jQuery('#publish').click(function(){
							var testervar = jQuery('[id^=\"titlediv\"]')
							.find('#title');
							if (testervar.val().length < 1)
							{
								jQuery('[name^=\"post_title\"]').css('background', '#F96');
								setTimeout(\"jQuery('#ajax-loading').css('visibility', 'hidden');\", 100);
								alert('Title is required');
								setTimeout(\"jQuery('#publish').removeClass('button-primary-disabled');\", 100);
								return false;
							}
						});
					  ";
					echo "</script>\n";
				}
			}
			
			if ( isset($opt['rf_category_settings']) )
			{
				global $post_type;
				if($post_type=='post')
				{	
					echo "<script>
							jQuery(function($){
								$('#publish, #save-post').click(function(e){
									if($('#taxonomy-category input:checked').length==0){
										jQuery('[id^=\"categorydiv\"]').css('background', '#F96');
										alert('" . __('Category is required.', 'require-post-category') . "');
										e.stopImmediatePropagation();
										return false;
									}else{
										return true;
									}
								});
								var publish_click_events = $('#publish').data('events').click;
								if(publish_click_events){
									if(publish_click_events.length>1){
										publish_click_events.unshift(publish_click_events.pop());
									}
								}
								if($('#save-post').data('events') != null){
									var save_click_events = $('#save-post').data('events').click;
									if(save_click_events){
									  if(save_click_events.length>1){
										  save_click_events.unshift(save_click_events.pop());
									  }
									}
								}
							});
							</script>";
				}
			}
			if ( isset($opt['rf_image_settings']) )
			{
				global $typenow;
				if (in_array($typenow, array('post','page','mm_photo '))){
					?>
					<script language="javascript" type="text/javascript">
						jQuery(document).ready(function() {
							jQuery('#post').submit(function() {
								if (jQuery("#set-post-thumbnail").find('img').size() > 0) {
									jQuery('#ajax-loading').hide();
									jQuery('#publish').removeClass('button-primary-disabled');
									return true;
								}else{
									jQuery('[id^=\"postimagediv\"]').css('background', '#F96');
									alert("Please Set An Image.");
									jQuery('#ajax-loading').hide();
									jQuery('#publish').removeClass('button-primary-disabled');
									return false;
								}
								return false;
							});
						});
					</script>
					<?php
				}
			}
			if ( isset($opt['rf_tag_settings']) )
			{
				global $post_type;
				if($post_type=='post'){
					echo "<script>
					jQuery(function($){
						$('#publish, #save-post').click(function(e){
							if($('#post_tag .tagchecklist span').length==0){
								jQuery('[id^=\"tagsdiv-post_tag\"]').css('background', '#F96');
								alert('Please set Less than one Tag.');
								e.stopImmediatePropagation();
								return false;
							}else{
								return true;
							}
						});
						var publish_click_events = $('#publish').data('events').click;
						if(publish_click_events){
							if(publish_click_events.length>1){
								publish_click_events.unshift(publish_click_events.pop());
							}
						}
						if($('#save-post').data('events') != null){
							var save_click_events = $('#save-post').data('events').click;
							if(save_click_events){
							  if(save_click_events.length>1){
								  save_click_events.unshift(save_click_events.pop());
							  }
							}
						}
					});
					</script>";
				}
			}
		}
	}
	add_action('admin_footer-post.php', 'required_fields');
	add_action('admin_footer-post-new.php', 'required_fields');
?>