<?php 
/**
* admin enqueue class for loading necessary files.
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if(!class_exists('Wpqai_Enqueue'))
{
	class Wpqai_Enqueue
	{
		function __construct()
		{
			add_action( 'admin_enqueue_scripts', array($this, 'admin_script'));
		}

		/* Load assets files needed in plugin for the backend end plugin page */
		function admin_script()
		{	
			global $pagenow;
            if($pagenow == 'admin.php' && $_GET['page'] == 'wp-quicq-afosto-settings')
            {
				
                wp_enqueue_style('wpqai/font-awesome', WPQAI_ASSETS.'css/all.min.css', false, null);
                wp_enqueue_style('wpqai/custom', WPQAI_ASSETS.'css/custom.css', false, null);

                wp_enqueue_style('wpqai/fonts', WPQAI_ASSETS.'fonts/graphik/fonts.css', false, null);

                wp_register_script('wpqai/script',WPQAI_ASSETS.'js/script.js', ['jquery'],null, true);
                wp_localize_script('wpqai/script','wpqai', 
                    array(
                        'ajaxurl' =>admin_url( 'admin-ajax.php'),
                        'setting_page_url'=> admin_url('admin.php?page=wp-quicq-afosto-settings')
                    )
                );
                wp_enqueue_script('wpqai/script');
            }
		}
	}
	new Wpqai_Enqueue();
}
?>