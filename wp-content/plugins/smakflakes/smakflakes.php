<?php
/*
Plugin Name: Smakflakes for WP
Plugin URI: 
Description: "Smakflakes" - wonderful effect snow flakes on your site.
Version: 1.0
Author: Yury Vasilyev aka iamMakep
Author URI: 
License: 
*/
if ( is_admin() ){
	add_action('admin_menu', 'smakflakes_add_pages');	
	}	
function smakflakes_add_pages() {
	add_action('admin_init', 'smakflakes_register_settings');
	if (!is_null(get_option('wpsmf_opt_showinmainmenu')) && get_option('wpsmf_opt_showinmainmenu') == 1) add_menu_page(__('Smakflakes options', 'wordpress-smakflakes'), 'Smakflakes', 'edit_pages', 'wpsmf-options', 'smakflakes_options_page', WP_PLUGIN_URL.'/smakflakes/assets/img/smakflakes_wpicon.png');
	add_options_page(__('Smakflakes options', 'wordpress-smakflakes'), 'Smakflakes', 'edit_pages', 'wpsmf-options', 'smakflakes_options_page' );
}
function smakflakes_register_settings() {
	register_setting( 'wpsmf-settings', 'wpsmf_opt_showinmainmenu', 'sanitize_power');	
	register_setting( 'wpsmf-settings', 'wpsmf_opt_power', 'sanitize_power');
	register_setting( 'wpsmf-settings', 'wpsmf_opt_flakesize', 'sanitize_flakesize');
	register_setting( 'wpsmf-settings', 'wpsmf_opt_flakescount', 'sanitize_flakescount');
	register_setting( 'wpsmf-settings', 'wpsmf_opt_randomsize', 'sanitize_randomsize');
	register_setting( 'wpsmf-settings', 'wpsmf_opt_flaketype', 'sanitize_flaketype');
	register_setting( 'wpsmf-settings', 'wpsmf_opt_onoffpos', 'sanitize_onoffpos');
	register_setting( 'wpsmf-settings', 'wpsmf_opt_falspeed','sanitize_falspeed');
	register_setting( 'wpsmf-settings', 'wpsmf_opt_wind','sanitize_wind');	
	register_setting( 'wpsmf-settings', 'wpsmf_opt_flakecolor');
	register_setting( 'wpsmf-settings', 'wpsmf_opt_flakeshadow_color');
	register_setting( 'wpsmf-settings', 'wpsmf_opt_flakecolor_rgb');
	register_setting( 'wpsmf-settings', 'wpsmf_opt_flakeshadow_color_rgb');	
	register_setting( 'wpsmf-settings', 'wpsmf_opt_flakesfile','');
	register_setting( 'wpsmf-settings', 'wpsmf_opt_firotation','sanitize_firotation');
	
	if (get_option('wpsmf_opt_power') == null) update_option( 'wpsmf_opt_power', 1 );
	if (get_option('wpsmf_opt_showinmainmenu') == null) update_option( 'wpsmf_opt_showinmainmenu', 1 );
	if (get_option('wpsmf_opt_flakescount') == null) update_option( 'wpsmf_opt_flakescount', 60);	
	if (get_option('wpsmf_opt_flakesize') == null) update_option( 'wpsmf_opt_flakesize', 2);
	if (get_option('wpsmf_opt_randomsize') == null) update_option( 'wpsmf_opt_randomsize', 1);
	if (get_option('wpsmf_opt_flaketype') == null) update_option( 'wpsmf_opt_flaketype', 'varicolored');
	if (get_option('wpsmf_opt_onoffpos') == null) update_option( 'wpsmf_opt_onoffpos', 'top right');
	if (get_option('wpsmf_opt_falspeed') == null) update_option( 'wpsmf_opt_falspeed', 1);
	if (get_option('wpsmf_opt_wind') == null) update_option( 'wpsmf_opt_wind', 0);
	if (get_option('wpsmf_opt_flakecolor') == null) update_option( 'wpsmf_opt_flakecolor', '#ffffff');
	if (get_option('wpsmf_opt_flakeshadow_color') == null) update_option( 'wpsmf_opt_flakeshadow_color', '#000000');
	if (get_option('wpsmf_opt_flakecolor_rgb') == null) update_option( 'wpsmf_opt_flakecolor_rgb', '{r:255,g:255,b:255}');
	if (get_option('wpsmf_opt_flakeshadow_color_rgb') == null) update_option( 'wpsmf_opt_flakeshadow_color_rgb', '{r:0,g:0,b:0}');
	if (get_option('wpsmf_opt_flakesfile') == null) update_option( 'wpsmf_opt_flakesfile', '');
	if (get_option('wpsmf_opt_firotation') == null) update_option( 'wpsmf_opt_firotation','cw');
	
}

function sanitize_power($input) {
	if (intval($input) == 1) return 1;
	else return 0;
}
function sanitize_falspeed($input) {
	if (intval($input) < 1) $input = 1;
	if (intval($input) > 30) $input = 30;
	return intval($input);
}
function sanitize_wind($input) {
	if (intval($input) < -5) $input = -5;
	if (intval($input) > 5) $input = 5;
	return intval($input);
}
function sanitize_flakesize($input) {
	if (intval($input) < 1) $input = 1;
	if (intval($input) > 30) $input = 30;
	return intval($input);
}
function sanitize_randomsize($input) {
	if (intval($input) == 1) return 1;
	else return 0;
}
function sanitize_flakescount($input) {
	if ((intval($input) < 1) || (intval($input) > 300)) $input = 60;
	return intval($input);
}
function sanitize_flaketype($input) {
	switch($input) {
		case 'lighter': case 'darker': case 'varicolored': case 'colored': case 'rainbow': case 'rainbow_shadow': return $input; break;
		default: return 'darker'; break;
		}
}
function sanitize_firotation($input) {
	switch($input) {
		case 'cw': case 'ccw': case 'toandfro': case 'none': return $input; break;
		default: return 'toandfro'; break;
		}
}
function sanitize_onoffpos($input) {
	switch($input) {
		case 'top left': case 'top right': case 'bottom left': case 'bottom right': case 'none': return $input; break;
		default: return 'top right'; break;
		}
}
function smakflakes_options_page() {
	?>
	<div class="wrap">
	<h2><?php echo __('Smakflakes options', 'wordpress-smakflakes'); ?></h2>	
	<?php if(isset($_GET['settings-updated']) ) { ?>
	<div id="setting-error-settings_updated" class="updated settings-error"><p>
    <strong>
    <?php _e('Settings saved.') ?>
	</strong>
    </p>
	</div>
	<?php } ?>	
	<form method="post" action="options.php">
	<?php settings_fields('wpsmf-settings'); ?>	
	<table class="form-table">	
	
	<tr valign="top">
	<th scope="row"><?php echo __('Show icon in main menu', 'wordpress-smakflakes'); ?></th>
	<td>
	<input name="wpsmf_opt_showinmainmenu" type="checkbox" value="1" <?php if (1 == get_option('wpsmf_opt_showinmainmenu')) echo 'checked'; ?>/>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row"><?php echo __('On/Off', 'wordpress-smakflakes'); ?></th>
	<td>
	<input name="wpsmf_opt_power" type="checkbox" value="1" <?php if (1 == get_option('wpsmf_opt_power')) echo 'checked'; ?>/>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row"><?php echo __('Flakes count', 'wordpress-smakflakes'); ?></th>
	<td><input type="number" name="wpsmf_opt_flakescount" maxlength="3" size="3" min="1" max="300" pattern="[0-9]{1,3}" value="<?php echo get_option('wpsmf_opt_flakescount'); ?>" required />
	<p class="description"><?php echo __('number of flakes. (1 - 300) default: 60', 'wordpress-smakflakes'); ?></p></td>	
	</tr>
	
	<tr valign="top">
	<th scope="row"><?php echo __('Flake size', 'wordpress-smakflakes'); ?></th>
	<td><input type="number" name="wpsmf_opt_flakesize" maxlength="2" size="2" min="1" max="30" pattern="[0-9]{1,2}" value="<?php echo get_option('wpsmf_opt_flakesize'); ?>" required />
	<p class="description"><?php echo __('size of flakes. (1 - 30) default: 1<br>', 'wordpress-smakflakes') . __('/* option has no effect on images flakes */', 'wordpress-smakflakes'); ?></p></td>	
	</tr>
	
	<tr valign="top">
	<th scope="row"><?php echo __('Random size for flakes', 'wordpress-smakflakes'); ?></th>
	<td>
	<input name="wpsmf_opt_randomsize" type="checkbox" value="1" <?php if (get_option('wpsmf_opt_randomsize') == 1) echo 'checked'; ?>/>
	<p class="description"><?php echo __('/* option has no effect on images flakes */', 'wordpress-smakflakes'); ?></p>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row"><?php echo __('Falling speed', 'wordpress-smakflakes'); ?></th>
	<td><input type="number" name="wpsmf_opt_falspeed" maxlength="2" size="2" min="1" max="30" pattern="[0-9]{1,2}" value="<?php echo get_option('wpsmf_opt_falspeed'); ?>" required />
	<p class="description"><?php echo __('falling speed. (1 - 30) default: 1', 'wordpress-smakflakes'); ?></p></td>	
	</tr>
	
	<tr valign="top">
	<th scope="row"><?php echo __('Wind speed', 'wordpress-smakflakes'); ?></th>
	<td><input type="number" name="wpsmf_opt_wind" maxlength="2" size="2" min="-5" max="5" pattern="[0-9\-]{1,2}" value="<?php echo get_option('wpsmf_opt_wind'); ?>" required />
	<p class="description"><?php echo __('wind speed. (-5 - 5) default: 0', 'wordpress-smakflakes'); ?></p></td>	
	</tr>
	
	<tr valign="top">
	<th scope="row"><?php echo __('Flakes mode', 'wordpress-smakflakes'); ?></th>
	<td>
		<select id="flaketype" name="wpsmf_opt_flaketype" size="1">		
			<option value="lighter"<?php if (get_option('wpsmf_opt_flaketype') == 'lighter') echo ' selected'; ?>><?php echo __('Lighter', 'wordpress-smakflakes'); ?></option>
			<option value="darker"<?php if (get_option('wpsmf_opt_flaketype') == 'darker') echo ' selected'; ?>><?php echo __('Darker', 'wordpress-smakflakes'); ?></option>
			<option value="varicolored"<?php if (get_option('wpsmf_opt_flaketype') == 'varicolored') echo ' selected'; ?>><?php echo __('Varicolored', 'wordpress-smakflakes'); ?></option>
			<option value="colored"<?php if (get_option('wpsmf_opt_flaketype') == 'colored') echo ' selected'; ?>><?php echo __('Colored', 'wordpress-smakflakes'); ?></option>
			<option value="rainbow"<?php if (get_option('wpsmf_opt_flaketype') == 'rainbow') echo ' selected'; ?>><?php echo __('Rainbow (dynamical change flakes color)', 'wordpress-smakflakes'); ?></option>
			<option value="rainbow_shadow"<?php if (get_option('wpsmf_opt_flaketype') == 'rainbow_shadow') echo ' selected'; ?>><?php echo __('Rainbow Shadow (dynamical change flakes shadow)', 'wordpress-smakflakes'); ?></option>
		</select>
	<p class="description"><?php echo __('note: to use these modes, "flakes file" field should be empty', 'wordpress-smakflakes'); ?></p></td>	
	</td>
	</tr>	
	
	<tr valign="top" id="flakecolors">
	<th scope="row"><?php echo __('Flake color and shadow color', 'wordpress-smakflakes'); ?></th>
	<td>
		<input id="flakecolor_rgb" name="wpsmf_opt_flakecolor_rgb" type="text" value="<?php echo get_option('wpsmf_opt_flakecolor_rgb'); ?>" hidden />
		<input id="flakeshadow_color_rgb" name="wpsmf_opt_flakeshadow_color_rgb" type="text" value="<?php echo get_option('wpsmf_opt_flakeshadow_color_rgb'); ?>" hidden />
		<input id="flakecolor" name="wpsmf_opt_flakecolor" type="text" value="<?php echo get_option('wpsmf_opt_flakecolor'); ?>" class="color-field" data-default-color="#ffffff" />
		<input id="flakeshadow_color" name="wpsmf_opt_flakeshadow_color" type="text" value="<?php echo get_option('wpsmf_opt_flakeshadow_color'); ?>" class="color-field" data-default-color="#000000" />
	</td>	
	</tr>
	
	<tr valign="top">
	<th scope="row"><?php echo __('Flakes file', 'wordpress-smakflakes'); ?></th>
	<td><input type="text" name="wpsmf_opt_flakesfile" size="70" value="<?php echo get_option('wpsmf_opt_flakesfile'); ?>"/>
	<p class="description"><?php echo __('path to image file with flakes texture atlas with one row (note: image width must be a multiple its height. eg. 128x16 - contains 8 kinds of flakes with size 16x16)', 'wordpress-smakflakes'); ?></p></td>	
	</tr>
	
	<tr valign="top">
	<th scope="row"><?php echo __('Flakes image rotation', 'wordpress-smakflakes'); ?></th>
	<td>
		<select id="flakerotation" name="wpsmf_opt_firotation" size="1">		
			<option value="cw"<?php if (get_option('wpsmf_opt_firotation') == 'cw') echo ' selected'; ?>><?php echo __('Clockwise', 'wordpress-smakflakes'); ?></option>
			<option value="ccw"<?php if (get_option('wpsmf_opt_firotation') == 'ccw') echo ' selected'; ?>><?php echo __('Counterclockwise', 'wordpress-smakflakes'); ?></option>
			<option value="toandfro"<?php if (get_option('wpsmf_opt_firotation') == 'toandfro') echo ' selected'; ?>><?php echo __('To and Fro', 'wordpress-smakflakes'); ?></option>
			<option value="none"<?php if (get_option('wpsmf_opt_firotation') == 'none') echo ' selected'; ?>><?php echo __('None', 'wordpress-smakflakes'); ?></option>
		</select>
	</td>
	</tr>

	</table>	
	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="wpsmf_opt_power, wpsmf_opt_firotation,wpsmf_opt_flakesfile,wpsmf_opt_flakeshadow_color, wpsmf_opt_flakecolor, wpsmf_opt_flaketype, wpsmf_opt_wind, wpsmf_opt_flakescount, wpsmf_opt_showinmainmenu, wpsmf_opt_flakesize, wpsmf_opt_randomsize, wpsmf_opt_falspeed" />
	<p class="submit">
	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
	</form>
	</div>
	<?php
}
function smakflakes_admin_header() {
	$page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
	if( 'wpsmf-events' != $page ) return;
	}
function wpsmf_activate() {
	} 
function wpsmf_deactivate() {
	return true;
	} 
function wpsmf_uninstall() {
	}
register_activation_hook(__FILE__, 'wpsmf_activate');
register_deactivation_hook(__FILE__, 'wpsmf_deactivate');
register_uninstall_hook(__FILE__, 'wpsmf_uninstall');
function smakflakes_scripts() {
	wp_enqueue_script('jquery');
	wp_register_script('smakflakes', plugins_url('/assets/js/smakflakes.js' , __FILE__));    
	wp_enqueue_script('smakflakes');
	wp_register_style('smakflakes_style', plugins_url('/assets/css/main.css', __FILE__));	
	wp_enqueue_style('smakflakes_style');
}
add_action('wp_enqueue_scripts','smakflakes_scripts');
function wpsf_add_color_picker() {
	if(is_admin()) {      
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_script('wpsf-cp-script', plugins_url( '/assets/js/cp.js', __FILE__ ), array( 'wp-color-picker' ), false, true ); 
		}
}
add_action( 'admin_enqueue_scripts', 'wpsf_add_color_picker' );
add_action('admin_head', 'smakflakes_admin_header');
function smakflakes_wp_header() {
	$settings = '';
	if (get_option('wpsmf_opt_flakesize') != "") {
		if ($settings != '') $settings .= ",\n";
		$settings .= 'flakesize: '.get_option('wpsmf_opt_flakesize');
		}
	if (get_option('wpsmf_opt_flakescount') != "") {
		if ($settings != '') $settings .= ",\n";
		$settings .= 'flakescount: '.get_option('wpsmf_opt_flakescount');
		}
	if (get_option('wpsmf_opt_randomsize') != "") {
		if ($settings != '') $settings .= ",\n";
		$settings .= 'randomsize: '.get_option('wpsmf_opt_randomsize');
		}
	if (get_option('wpsmf_opt_flaketype') != "") {
		if ($settings != '') $settings .= ",\n";
		$settings .= 'flaketype: \''.get_option('wpsmf_opt_flaketype').'\'';
		}
	if (get_option('wpsmf_opt_onoffpos') != "") {
		if ($settings != '') $settings .= ",\n";
		$settings .= 'onoffpos: \''.get_option('wpsmf_opt_onoffpos').'\'';
		}
	if (get_option('wpsmf_opt_falspeed') != "") {
		if ($settings != '') $settings .= ",\n";
		$settings .= 'falspeed: '.get_option('wpsmf_opt_falspeed');
		}
	if (get_option('wpsmf_opt_wind') != "") {
		if ($settings != '') $settings .= ",\n";
		$settings .= 'wind: '.get_option('wpsmf_opt_wind');
		}
	if (get_option('wpsmf_opt_flakesfile') != "") {
		if ($settings != '') $settings .= ",\n";
		$settings .= 'flakesfile: \''.get_option('wpsmf_opt_flakesfile').'\'';
		}
	if (get_option('wpsmf_opt_firotation') != "") {
		if ($settings != '') $settings .= ",\n";
		$settings .= 'firotation: \''.get_option('wpsmf_opt_firotation').'\'';
		}
		
	if (get_option('wpsmf_opt_flakecolor_rgb') != "") {
		if ($settings != '') $settings .= ",\n";
		$settings .= 'flakecolor: '.get_option('wpsmf_opt_flakecolor_rgb').'';
		}
	if (get_option('wpsmf_opt_flakeshadow_color_rgb') != "") {
		if ($settings != '') $settings .= ",\n";
		$settings .= 'flakeshadow_color: '.get_option('wpsmf_opt_flakeshadow_color_rgb').'';
		}
	
    
	if (get_option('wpsmf_opt_power') == 1)	
		echo '<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(\'body\').smakflakes({'.$settings.'});		
		});
</script>';
		else echo '';
}
add_action('wp_head', 'smakflakes_wp_header');
?>