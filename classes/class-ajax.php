<?php 
/**
* admin ajax class for defining all the ajax call functions.
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if(!class_exists('Wpqai_Ajax'))
{
	class Wpqai_Ajax
	{
		function __construct()
		{
			add_action('wp_ajax_wpqai_load_setting_data', 
                array($this,'wpqai_load_setting_data'));
			add_action('wp_ajax_wpqai_enable_quicq_afosto', 
                array($this,'wpqai_enable_quicq_afosto'));
            add_action('wp_ajax_wpqai_change_quicq_afosto_status', 
                array($this,'wpqai_change_quicq_afosto_status'));
            add_action('wp_ajax_wpqai_disconnect_quicq_afosto', 
                array($this,'wpqai_disconnect_quicq_afosto'));
            
        }

        /* to load template setting data */
        function wpqai_load_setting_data(){
        	$is_checked = (get_option( 'wpqai_quicq_afosto_enabled' ) == 1) ? "checked='checked'" : '';
            $is_enabled = (get_option( 'wpqai_quicq_afosto_key' )) ? '' : "disabled='true'";
            
            $content = array(
                'uploaded_url' => get_option( 'wpqai_quicq_afosto_site_url' ),
                'cdn_key'   => get_option( 'wpqai_quicq_afosto_key' ),
                'is_checked'    =>  $is_checked,
                'is_enabled'    =>  $is_enabled,
                'status'    =>  get_option( 'wpqai_quicq_afosto_status' ),
            );

        	ob_start();
			Wpqai_Template::render('template-setting-sections.php',$content);
	    	$html = ob_get_contents();
	    	ob_end_clean();
			$response = array('html' => $html );
    		wp_send_json_success( $response );
        }

        /* to enable-disable setting */
        function wpqai_enable_quicq_afosto(){
        	if(isset($_POST['checked'])){
        		update_option( 'wpqai_quicq_afosto_enabled', $_POST['checked'] );
                update_option( 'wpqai_quicq_afosto_status', 'updated');
        		wp_send_json_success('success');
        	}else{
        		wp_send_json_error(__('Facing issues while enabling Quicq Afosto.'));
        	}
        }

        /* to update data on disconnecting from afosto */
        function wpqai_disconnect_quicq_afosto(){
        	delete_option( 'wpqai_quicq_afosto_enabled' );
            delete_option( 'wpqai_quicq_afosto_key' );
            delete_option( 'wpqai_quicq_afosto_cdn_url' );
            delete_option( 'wpqai_quicq_afosto_site_url' );
            delete_option( 'wpqai_quicq_afosto_status' );
            wp_send_json_success('success');
        }

        /* to update afosto connection status */
        function wpqai_change_quicq_afosto_status(){
            update_option( 'wpqai_quicq_afosto_status', 'updated');
            wp_send_json_success('success');
        }

	}
	new Wpqai_Ajax();
}
?>