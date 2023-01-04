<?php
/**
* admin menu class for initiating necessary actions and core functions.
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if (!class_exists("Wpqai_Admin_Menu")) {
    class Wpqai_Admin_Menu {

        function __construct() {  
            /* action to add menu page */        
            add_action( 'admin_menu', array($this,'wpqai_menu_page' )); 
        }

       /* To add menu page */ 
        function wpqai_menu_page() {
            add_menu_page(
                __( 'Quicq Afosto Integration', 'quicq' ),
                __( 'Quicq Afosto Integration', 'quicq' ),
                'manage_options',
                'wp-quicq-afosto-settings',
                array($this,'wp_quicq_afosto_settings'), 
                "dashicons-admin-generic", 15
            );
        }

        /* To render setting template */
        function wp_quicq_afosto_settings(){
            $is_checked = (get_option( 'wpqai_quicq_afosto_enabled' ) == 1) ? "checked='checked'" : '';
            $is_enabled = (get_option( 'wpqai_quicq_afosto_key' )) ? '' : "disabled='true'";

            $content = array(
                'uploaded_url' => get_option( 'wpqai_quicq_afosto_site_url' ),
                'cdn_key'   => get_option( 'wpqai_quicq_afosto_key' ),
                'is_checked'    =>  $is_checked,
                'is_enabled'    =>  $is_enabled,
                'status'    =>  get_option( 'wpqai_quicq_afosto_status' ),
            );
            Wpqai_Template::render('template-settings',$content);
        }
    }
    new Wpqai_Admin_Menu();
}