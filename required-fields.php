<?php
/*
* Plugin Name: Required Fields
* Plugin URI: https://downloads.wordpress.org/plugin/required-fields.1.4.zip
* Description: Required Fields can check if you have fill in all the fields you have enabled
* Version: 1.4
* Author: NikosTsolakos
* Author URI: https://profiles.wordpress.org/nikostsolakos/#content-plugins
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
        'rf_for_page_enabled' => '',
		'rf_image_for_page' => '',
		'rf_title_for_page' => '',
		'rf_title_settings' => '0',
		'rf_category_settings' => '0',
		'rf_tag_settings' => '0',
		'rf_image_settings' => '0',
		'rf_title_error' => 'Title is required',
		'rf_cat_error' => 'Categories are required',
		'rf_tag_error' => 'Please set less one tag',
		'rf_img_error' => 'Post Thumbnail is required'
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
	// Error Logs
	add_settings_section('rf_error_logs', '<div id="advanced"><a href="#collapse1">Set Error Logs</a></div>', 'rf_error_logs_text', rf_error_logs_text);
	// Fields Of Error logs
	add_settings_field('rf_title_error', 'Set Error For Title:', 'rf_title_error', __FILE__, 'rf_error_logs');
	add_settings_field('rf_cat_error', 'Set Error For Categories:', 'rf_cat_error', __FILE__, 'rf_error_logs');
	add_settings_field('rf_tag_error', 'Set Error For Tags:', 'rf_tag_error', __FILE__, 'rf_error_logs');
	add_settings_field('rf_img_error', 'Set Error For Post thumbnail:', 'rf_img_error', __FILE__, 'rf_error_logs');
	// For Page
	add_settings_section('rf_for_page', '<div id="forpage"><a href="#collapse2">Required Fields For Page</a></div>', 'rf_for_page_text', rf_for_page_text);
	// Fields For Page
	add_settings_field('rf_for_page_enabled', 'Set Required Fields:', 'rf_for_page_enabled', __FILE__, 'rf_for_page');
	add_settings_field('rf_image_for_page', 'Image For Page:', 'rf_image_for_page', __FILE__, 'rf_for_page');
	add_settings_field('rf_title_for_page', 'Tag For Page:', 'rf_title_for_page', __FILE__, 'rf_for_page');

}
// Add rf_settings_init to Admin Section
add_action('admin_init', 'rf_settings_init' );


// Functions Of Fields Start

require_once('options/functions.php');

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
								<p>Required Fields For Post: </p>
									<div class="slideThree" style="margin: 0px 16%;">
									<?php rf_enabled_settings();?>
										<label for="slideThree"></label>
									</div>
							</section>
							<section style=" margin-bottom: -30px !important; ">
								<p>Required Fields For Page: </p>
									<div class="slideThree" style="margin: 0px 16%;">
									<?php rf_for_page_enabled();?>
										<label for="rf_for_page_enabled"></label>
									</div>
							</section>
						</span>
					</div>
				</div>				
				<div class="postbox">
					<?php settings_fields('rf_settings'); ?>
					<?php do_settings_sections(__FILE__); ?>
					<?php do_settings_sections(rf_error_logs_text); ?>
					<hr style="  border: solid 2px #000;  border-left: solid 0px;border-right: solid 0px;border-bottom: solid 0px;border-style: dotted;">
					<?php do_settings_sections(rf_for_page_text); ?>
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
					#advanced {
						text-align: center; border: solid 1px #D23733; background: #D23733;
					}
					#advanced a {
						color: #ffffff;
					}
					#forpage {
						text-align: center; border: solid 1px #D23733; background: #D23733;
					}
					#forpage a {
						color: #ffffff;
					}
					</style>
					<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
					<script>
					$('#advanced a').click(function () {
						var collapse_content_selector = $(this).attr('href');
						var toggle_switch = $(this);
						$(collapse_content_selector).slideToggle(function () {
							$(this).is(':visible')? toggle_switch.text('Close Error Logs') : toggle_switch.text('Set Error Logs');
						});
					});
					</script>
					<script>
					$('#forpage a').click(function () {
						var collapse_content_selector = $(this).attr('href');
						var toggle_switch = $(this);
						$(collapse_content_selector).slideToggle(function () {
							$(this).is(':visible')? toggle_switch.text('Close Required Fields For Page') : toggle_switch.text('Required Fields For Page');
						});
					});
					</script>
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
	require_once('options/frontend.php');
	add_action('admin_footer-post.php', 'required_fields');
	add_action('admin_footer-post-new.php', 'required_fields');
?>