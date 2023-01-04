<?php
/**
* admin init class for initiating necessary actions and core functions.
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if (!class_exists("Wpqai_Init")) {
    class Wpqai_Init {

        private static $_instance;

        public static function init(){
            if( !self::$_instance instanceof Wpqai_Init ){
                self::$_instance = new Wpqai_Init();
            }
            return self::$_instance;
        }

        function __construct() {
            /* register plugin activation hook */
            register_activation_hook( WPQAI_FILE_PATH, array($this,'wpqai_plugin_activate'));
            $this->wpqai_load_files();

            /* register plugin activation hook */
            register_deactivation_hook( WPQAI_FILE_PATH, array($this,'wpqai_plugin_deactivate'));

            /*register_uninstall_hook( WPQAI_FILE_PATH, array($this,'wpqai_plugin_uninstall'));*/

            /* load textdomain */
            //add_action( 'init', array($this,'wpqai_load_textdomain'), 1 );

            add_action( 'plugins_loaded', array($this,'wpqai_quicq_init') );
        }

        /* plugin activation function */
        function wpqai_plugin_activate() {
            
            if ( get_option( 'wpqai_quicq_afosto_key' ) != "" ) {
                update_option( 'wpqai_quicq_afosto_enabled', 1 );
            }
        }

        /* plugin deactivation function */
        function wpqai_plugin_deactivate(){
            update_option( 'wpqai_quicq_afosto_enabled', 0 );
        }

        /* function wpqai_plugin_uninstall(){
            add_action('admin_notices', function () { include_once( WPQAI_TEMPLATE . 'template-uninstallation-warning.php' );
            });
            delete_option( 'wpqai_quicq_afosto_enabled' );
            delete_option( 'wpqai_quicq_afosto_key' );
            delete_option( 'wpqai_quicq_afosto_cdn_url' );
            delete_option( 'wpqai_quicq_afosto_site_url' );
        }
        */

        /* load required files */
        function wpqai_load_files(){   
            require_once( WPQAI_STAR_CLASS   . 'class-enqueue.php' );
            require_once( WPQAI_STAR_CLASS   . 'class-admin-menu.php' );
            require_once( WPQAI_STAR_CLASS   . 'class-template.php' );
            require_once( WPQAI_STAR_CLASS   . 'class-ajax.php' );
            require_once( WPQAI_STAR_CLASS   . 'class-manage-data.php' );
        }
        
        /* load textdomain */
        /*function wpqai_load_textdomain(){
            if ( is_textdomain_loaded( 'quicq' ) ) {
                return;
            }
            load_theme_textdomain( 'quicq', WPQAI_DIR. '/languages' );
        }*/

        function wpqai_quicq_init(){

            if (isset($_GET['po_lang']) ) {
                $locale = $_GET['po_lang'];
            }else if(is_admin() && !wp_doing_ajax() && function_exists( 'get_user_locale' )){
                $locale =  get_user_locale();
            }
            else if(is_admin() && function_exists( 'get_user_locale' )){
                $locale = get_user_locale();
            }else{
                $locale = get_locale();
            }
            $locale = apply_filters( 'plugin_locale', $locale, 'quicq' );
    
            unload_textdomain( 'quicq' );
            load_textdomain( 'quicq', WPQAI_DIR. 'languages/' . "quicq-".$locale . '.mo' );
            load_plugin_textdomain( 'quicq', false, WPQAI_DIR. 'languages' );
    
        }
    }
}