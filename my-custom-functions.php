<?php
/**
 * Plugin Name: My Custom Functions
 * Plugin URI: http://mycyberuniverse.com/my_programs/wp-plugin-my-custom-functions.html
 * Description: EASILY and SAFELY add your own functions, snippets or any custom codes directly out of your WordPress Dashboard without need of an external editor.
 * Author: Arthur "Berserkr" Gareginyan
 * Author URI: http://mycyberuniverse.com/author.html
 * Version: 1.3
 * License: GPL3
 * Text Domain: mcfunctions
 * Domain Path: /languages/
 *
 * Copyright 2014-2015  Arthur "Berserkr" Gareginyan  (email : arthurgareginyan@gmail.com)
 *
 * This file is part of "My Custom Functions".
 *
 * "My Custom Functions" is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * "My Custom Functions" is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with "My Custom Functions".  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * Prevent Direct Access
 */
defined('ABSPATH') or die("Restricted access!");

/**
 * Register text domain
 *
 * @since 0.1
 */
function anarcho_cfunctions_textdomain() {
	load_plugin_textdomain( 'anarcho_cfunctions', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'anarcho_cfunctions_textdomain' );

/**
 * Print direct link to Custom Functions admin page
 *
 * Fetches array of links generated by WP Plugin admin page ( Deactivate | Edit )
 * and inserts a link to the Custom Functions admin page
 *
 * @since  0.1
 * @param  array $links Array of links generated by WP in Plugin Admin page.
 * @return array        Array of links to be output on Plugin Admin page.
 */
function anarcho_cfunctions_settings_link( $links ) {
	$settings_page = '<a href="' . admin_url( 'themes.php?page=my-custom-functions.php' ) .'">' . __( 'Settings', 'anarcho_cfunctions' ) . '</a>';
	array_unshift( $links, $settings_page );
	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'anarcho_cfunctions_settings_link' );

/**
 * Register "Custom Functions" submenu in "Appearance" Admin Menu
 *
 * @since 0.1
 */
function anarcho_cfunctions_register_submenu_page() {
	add_theme_page( __( 'My Custom Functions', 'anarcho_cfunctions' ), __( 'Custom Functions', 'anarcho_cfunctions' ), 'edit_theme_options', basename( __FILE__ ), 'anarcho_cfunctions_render_submenu_page' );
}
add_action( 'admin_menu', 'anarcho_cfunctions_register_submenu_page' );

/**
 * Attach Settings Page
 *
 * @since 0.2
 */
require_once( plugin_dir_path( __FILE__ ) . 'inc/settings_page.php' );

/**
 * Register settings
 *
 * @since 0.1
 */
function anarcho_cfunctions_register_settings() {
	register_setting( 'anarcho_cfunctions_settings_group', 'anarcho_cfunctions_settings' );
}
add_action( 'admin_init', 'anarcho_cfunctions_register_settings' );

/**
 * Enqueue the CodeMirror scripts and styles
 *
 * @since 1.2
 */
function anarcho_enqueue_codemirror_scripts($hook) {
    if ( 'appearance_page_my-custom-functions' != $hook ) {
        return;
    }

    wp_enqueue_script('codemirror', plugin_dir_url(__FILE__) . 'inc/codemirror/lib/codemirror.js');
    wp_enqueue_script('codemirror_xml', plugin_dir_url(__FILE__) . 'inc/codemirror/mode/xml.js');
    wp_enqueue_script('codemirror_javascript', plugin_dir_url(__FILE__) . 'inc/codemirror/mode/javascript.js');
    wp_enqueue_script('codemirror_css', plugin_dir_url(__FILE__) . 'inc/codemirror/mode/css.js');
    wp_enqueue_script('codemirror_htmlmixed', plugin_dir_url(__FILE__) . 'inc/codemirror/mode/htmlmixed.js');
    wp_enqueue_script('codemirror_clike', plugin_dir_url(__FILE__) . 'inc/codemirror/mode/clike.js');
    wp_enqueue_script('codemirror_php', plugin_dir_url(__FILE__) . 'inc/codemirror/mode/php.js');
    wp_enqueue_style('codemirror_style', plugin_dir_url(__FILE__) . 'inc/codemirror/lib/codemirror.css');
}
add_action( 'admin_enqueue_scripts', 'anarcho_enqueue_codemirror_scripts' );

/**
 * Execute My Custom Functions
 *
 * @since 1.0
 */
function anarcho_cfunctions_exec() {
     // Read from BD
     $options = get_option( 'anarcho_cfunctions_settings' );
     $content = $options['anarcho_cfunctions-content'];

     // Cleaning
     $content = trim( $content );
     $content = trim( $content, '<?php' );

     // Reset error value
     update_option( 'anarcho_cfunctions_error', '0' );

     // Parsing and execute safe
     if( false === @eval( $content ) ) {
		// ERROR
		update_option( 'anarcho_cfunctions_error', '1' );
     }
}
anarcho_cfunctions_exec();


/**
 * Delete Options on Uninstall
 *
 * @since 0.1
 */
function anarcho_cfunctions_uninstall() {
	delete_option( 'anarcho_cfunctions_settings' );
        delete_option( 'anarcho_cfunctions_error' );
}
register_uninstall_hook( __FILE__, 'anarcho_cfunctions_uninstall' );


/* That's all folks! */
?>
