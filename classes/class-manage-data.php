<?php 
/**
* admin manage data class for initiating necessary actions and core functions.
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if(!class_exists('Wpqai_Manage_Data'))
{
	class Wpqai_Manage_Data
	{

		function __construct() {
			add_action( 'init', array($this,'wpqai_handle_requests'));
            add_action( 'init', array($this,'quicq_afosto_active'));
            add_filter( 'the_content', array($this,'quicq_afosto_activated'));
        } 

		/* Afosto update requested data */
        function wpqai_handle_requests(){
        	global $wpdb;
        	if(isset($_GET['cdn_root']) && !empty($_GET['cdn_root']) && isset($_GET['name'])){
        		if ( get_option( 'wpqai_quicq_afosto_key' ) == "" ){

        			add_option( 'wpqai_quicq_afosto_status', 'added' );
        		}else{

        			update_option( 'wpqai_quicq_afosto_status', 'updated' );
        		}
				$cdnurl = explode("/", $_GET['cdn_root'] );
				$cdnKey = $cdnurl[3];
        		update_option( 'wpqai_quicq_afosto_key', $cdnKey );
                update_option( 'wpqai_quicq_afosto_cdn_url', $_GET['cdn_root'] );
                update_option( 'wpqai_quicq_afosto_site_url', content_url() );
        	}
        }

		/* check if connection is active or not */
		function quicq_afosto_active()
		{	
			if ( ! is_admin() && get_option( 'wpqai_quicq_afosto_enabled' ) == 1 ) {				
				ob_start(array($this,'quicq_afosto_activated'));
			}	
		}

		/* do action if activated */
		function quicq_afosto_activated($content){
			
			if ( ! is_admin() && get_option( 'wpqai_quicq_afosto_enabled' ) == 1 ) {
				//To use on live
				$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
				
				if (strpos($url,'localhost') !== false) {
					$content = preg_replace_callback( '/(http?:\/\/[-a-zA-Z0-9@:%._+~#=]{1,256}\b([-a-zA-Z0-9()@:%_+.~#?&\/\/=]*))(.png|.jpe?g|webp|.svg)/', array($this,'quicq_afosto_rewrite_url'), $content );
				}else{
					$content = preg_replace_callback( '/((https?:)?\/\/[-a-zA-Z0-9@:%._+~#=]{1,256}(\.[a-zA-Z0-9()]{1,6}|:\d+)\b([-a-zA-Z0-9()@:%_+.~#?&\/\/=]*))(.png|.jpe?g|webp|.svg)/', array($this,'quicq_afosto_rewrite_url'), $content );
				}
			}
			return $content;
		}

		/* rewrite the image url on frontend */
		/* rewrite the image url on frontend */
		function quicq_afosto_rewrite_url($images){


			//remove the https: remove the http: from the cdn url
			$quicq_url = get_option( 'wpqai_quicq_afosto_cdn_url' );
			$quicq_url = preg_replace("/https?:(.*)/","$1",$quicq_url);

			//remove the https: remove the http: from the cdn url
			$site_url = get_option('wpqai_quicq_afosto_site_url');
			$site_url = preg_replace("/https?:(.*)/","$1",$site_url);

			foreach ( $images as &$imageUrl ) {
				$imageUrl = str_replace($site_url, $quicq_url, $imageUrl );

			}

			return $images[0];
		}
	}
	new Wpqai_Manage_Data();
}

?>