<?php
/**
 * Plugin Name:    Quicq for WebP images
 * Plugin URI:     https://afosto.com/apps/quicq/
 * Description:    Quicq integration for Wordpress.
 * Version:        2.0.0
 * Author:        Afosto
 * Author URI:    https://afosto.com
 * Domain Path:   /languages
 * License:       GPL-2.0+
 * License URI:   http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:   quicq
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* defining constants */
define( 'WPQAI_URL', plugin_dir_url( __FILE__ ) );
define( 'WPQAI_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPQAI_TEMPLATE', WPQAI_DIR . 'templates/' );
define( 'WPQAI_INCLUDE', WPQAI_DIR . 'includes/' );
define( 'WPQAI_STAR_CLASS', WPQAI_DIR . 'classes/' );
define( 'WPQAI_ASSETS', WPQAI_URL . 'assets/' );
define( 'WPQAI_FILE_PATH', __FILE__ );

/* include required files */
include_once(ABSPATH.'wp-admin/includes/plugin.php');
require_once( WPQAI_STAR_CLASS . 'class-init.php' );
$obj = Wpqai_Init::init();

/* uninstallation hook */
register_uninstall_hook( WPQAI_FILE_PATH, 'wpqai_plugin_uninstall');
function wpqai_plugin_uninstall(){

    delete_option( 'wpqai_quicq_afosto_enabled' );
    delete_option( 'wpqai_quicq_afosto_key' );
    delete_option( 'wpqai_quicq_afosto_cdn_url' );
    delete_option( 'wpqai_quicq_afosto_site_url' );
    delete_option( 'wpqai_quicq_afosto_status' );
    
}