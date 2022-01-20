<?php
/**
 * Plugin Name:    Quicq for WebP images
 * Plugin URI:     https://quicq.io/
 * Description:    Quicq integration for Wordpress.
 * Version:        1.3
 * Author:        Afosto
 * Author URI:    https://afosto.com
 * Domain Path:   /languages
 * License:       GPL-2.0+
 * License URI:   http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:   quicq
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * All add_action hooks
 * @since 1.0
 */

add_action( 'init', 'quicq_load_textdomain', 1 );
add_action( 'admin_head', 'quicq_plugin_style' );
add_action( 'admin_menu', 'quicq_init_page' );
add_action( 'admin_init', 'quicq_add_settings' );

/**
 * added hooks when deactivating and removing
 * @since 1.2
 */
register_uninstall_hook( __FILE__, 'quicq_uninstall' );
register_deactivation_hook( __FILE__, 'quicq_deactivate' );
register_activation_hook( __FILE__, 'quicq_activate' );


if ( isset( $_GET['page'] ) ) {
	if ( $_GET['page'] == 'quicq_adminpage' ) {
		add_action( 'admin_enqueue_scripts', 'quicq_add_styles', 0 );
	}
}
/**
 * Multilanguage function
 * @since 1.0.0
 */


if ( ! function_exists( ' quicq_load_textdomain' ) ) {
	function quicq_load_textdomain() {
		if ( is_textdomain_loaded( 'quicq' ) ) {
			return;
		}

		load_theme_textdomain( 'quicq', dirname( __FILE__ ) . '/languages' );
	}
}

/**
 * function for when the plugin is being deactivated
 * @since 1.2.0
 */
if ( ! function_exists( ' quicq_deactivate' ) ) {
	function quicq_deactivate() {
		update_option( 'quicq_enabled', 0 );
		update_option( 'upload_url_path', '' );
	}
}

/**
 * function for when the plugin is being deactivated
 * @since 1.2.0
 */
if ( ! function_exists( ' quicq_activate' ) ) {
	function quicq_activate() {
		if ( get_option( 'quicq_key' ) != "" ) {
			update_option( 'quicq_enabled', 1 );
			update_option( 'upload_url_path', get_option( 'quicq_key' ) );
		}
	}
}

/**
 * function which uninstalls the plugin, removes traces for settings
 * @since 1.2.0
 */
if ( ! function_exists( ' quicq_uninstall' ) ) {
	function quicq_uninstall() {
		delete_option( 'quicq_enabled' );
		delete_option( 'quicq_key' );
		delete_option( 'upload_url_path' );
		unregister_setting( 'quicq-page', 'upload_url_path' );
		unregister_setting( 'quicq-page', 'quicq_enabled' );
		unregister_setting( 'quicq-page', 'quicq_key' );
	}
}

/**
 * Adds styles
 * @since 1.0.0
 */

if ( ! function_exists( ' quicq_add_styles' ) ) {
	function quicq_add_styles() {
		$plugin_url = plugin_dir_url( __FILE__ );

		wp_register_style( 'quicq-bootstrap', $plugin_url . 'assets/css/bootstrap.min.css' );
		wp_enqueue_style( 'quicq-bootstrap' );

		wp_register_style( 'quicq-styles', $plugin_url . 'assets/css/styles-quicq.css' );
		wp_enqueue_style( 'quicq-styles' );
	}
}

/**
 * Adds quicq settings page
 * @since 1.0
 */
if ( ! function_exists( ' quicq_init_page' ) ) {
	function quicq_init_page() {
		$plugin_url = plugin_dir_url( __FILE__ );
		$imageurl   = $plugin_url . 'images/quicqicon.png';
		add_menu_page(
			__( 'Quicq', 'quicq' ),
			__( 'Quicq', 'quicq' ),
			'manage_options',
			'quicq_adminpage',
			'quicq_adminpage',
			$imageurl,
			6
		);
	}
}

/**
 * Adds quicq settings
 * @since 1.0
 */
if ( ! function_exists( ' quicq_add_settings' ) ) {
	function quicq_add_settings() {
		register_setting( 'quicq-page', 'upload_url_path' );
		register_setting( 'quicq-page', 'quicq_enabled' );
		register_setting( 'quicq-page', 'quicq_key' );
	}
}


/**
 * Quicq SVG logo
 * @since 1.0
 */
if ( ! function_exists( ' quicq_logo' ) ) {
	function quicq_logo() {
		echo '<svg style="height:60px" class="logo-light" viewBox="0 0 72 41" fill="none"><path fill="#C1CED7" class="logo-transparent" d="M15.74 38v-7h2.46c.5 0 .9.08 1.22.24.33.15.57.37.73.64.16.27.24.57.24.9 0 .45-.12.81-.37 1.07-.24.26-.53.44-.87.54a1.66 1.66 0 011.21.91 1.87 1.87 0 01-.07 1.76c-.17.29-.43.52-.77.69a2.8 2.8 0 01-1.24.25h-2.54zm.84-3.94h1.56c.45 0 .79-.1 1.03-.31s.36-.5.36-.88c0-.35-.12-.64-.36-.85-.23-.21-.59-.32-1.06-.32h-1.53v2.36zm0 3.24h1.61c.48 0 .85-.11 1.11-.33.26-.23.39-.54.39-.94 0-.4-.14-.7-.41-.94a1.62 1.62 0 00-1.11-.36h-1.59v2.57zm5.67 2.9l1.23-2.68h-.3l-1.96-4.48h.9l1.65 3.86 1.74-3.86h.87l-3.25 7.16h-.88zm7.27-2.2l2.58-7h.89l2.57 7h-.9l-.63-1.8h-2.98L30.4 38h-.88zm1.78-2.48h2.48l-1.24-3.46-1.24 3.46zM36.65 38v-4.25h-.75v-.71h.75v-.86c0-.48.12-.83.36-1.05.24-.22.6-.33 1.05-.33h.5v.72h-.37c-.25 0-.43.05-.54.16-.1.1-.16.27-.16.52v.84h1.22v.71H37.5V38h-.84zm5.13.12a2.36 2.36 0 01-2.15-1.22c-.22-.4-.32-.85-.32-1.38 0-.53.1-.98.33-1.37.22-.4.51-.7.89-.91.38-.21.8-.32 1.27-.32.46 0 .88.1 1.26.32.37.21.66.52.88.91.22.39.33.84.33 1.37 0 .53-.11.99-.33 1.38-.22.39-.52.69-.9.9-.38.21-.8.32-1.26.32zm0-.72a1.57 1.57 0 001.4-.84c.15-.28.23-.63.23-1.04 0-.41-.08-.76-.23-1.04a1.5 1.5 0 00-1.38-.84 1.57 1.57 0 00-1.4.84c-.16.28-.23.63-.23 1.04 0 .41.07.76.23 1.04.15.28.35.49.59.63s.5.21.79.21zm5.56.72c-.6 0-1.1-.15-1.48-.45-.4-.3-.63-.7-.7-1.22h.87c.05.26.19.49.4.68.23.19.54.28.92.28.35 0 .6-.07.78-.22a.71.71 0 00.25-.54c0-.3-.11-.5-.33-.6a4.2 4.2 0 00-.91-.27 5.15 5.15 0 01-.8-.23c-.27-.1-.5-.24-.67-.42a1 1 0 01-.27-.73c0-.43.16-.79.48-1.06.32-.28.76-.42 1.32-.42a2 2 0 011.29.4c.34.26.53.63.59 1.12h-.83a.84.84 0 00-.33-.59 1.12 1.12 0 00-.73-.22c-.3 0-.54.06-.7.19a.6.6 0 00-.24.5c0 .2.1.36.3.47.22.11.5.21.87.29.3.07.6.15.87.25.28.1.5.24.68.43.18.19.27.46.27.82 0 .45-.17.82-.51 1.11-.34.29-.8.43-1.4.43zm4.83-.12a1.6 1.6 0 01-1.07-.33c-.26-.22-.39-.62-.39-1.19v-2.73h-.86v-.71h.86l.11-1.19h.73v1.19h1.46v.71h-1.46v2.73c0 .31.06.53.2.64.12.1.34.16.66.16h.52V38h-.76zm4.03.12c-.46 0-.88-.1-1.26-.32a2.35 2.35 0 01-.89-.9c-.21-.4-.32-.85-.32-1.38 0-.53.11-.98.33-1.37.22-.4.52-.7.9-.91.37-.21.8-.32 1.26-.32.47 0 .89.1 1.26.32.38.21.67.52.88.91.22.39.33.84.33 1.37 0 .53-.1.99-.33 1.38-.22.39-.52.69-.9.9-.37.21-.8.32-1.26.32zm0-.72a1.57 1.57 0 001.4-.84c.16-.28.23-.63.23-1.04 0-.41-.07-.76-.23-1.04a1.5 1.5 0 00-1.38-.84 1.57 1.57 0 00-1.4.84c-.15.28-.23.63-.23 1.04 0 .41.08.76.23 1.04.16.28.35.49.6.63.24.14.5.21.78.21z"></path><path fill="#000" class="logo-opaque" fill-rule="evenodd" clip-rule="evenodd" d="M59.6 21.07c.71.33 1.5.5 2.35.5 1.01 0 1.91-.2 2.7-.6a4.91 4.91 0 001.92-1.82v4.94h-1.52c-.44 0-.67.5-.35.79l3.22 2.98c.2.19.51.19.71 0l3.22-2.98c.32-.3.1-.8-.35-.8H70V8.9h-3v2.16a5.51 5.51 0 00-4.65-2.37 6.21 6.21 0 00-5.82 3.9 7.3 7.3 0 00-.03 5.06 6.08 6.08 0 003.08 3.44zm8.32 3.02h-.02.02zm-2.76-5.8a3.75 3.75 0 01-3.41.28 3.54 3.54 0 01-1.9-1.94 4.05 4.05 0 010-2.87c.19-.46.44-.86.74-1.21.33-.37.7-.65 1.13-.86a3.44 3.44 0 013.54.43 3.6 3.6 0 011.31 1.76v2.94c-.4.6-.86 1.1-1.4 1.47z"></path><path fill="#000" class="logo-opaque" d="M13.5 20.24c-.67.38-1.39.68-2.16.9-.77.2-1.59.31-2.46.31a8.8 8.8 0 01-8.24-5.39 8.16 8.16 0 011.9-9.12c.8-.79 1.75-1.41 2.85-1.87a8.87 8.87 0 013.56-.71 8.77 8.77 0 018.83 8.6 8.35 8.35 0 01-2.39 5.8l2.5 2.57h-3.34l-1.05-1.09zm-4.6-1.68c.47 0 .9-.05 1.29-.15.4-.1.78-.25 1.13-.42l-2.78-2.9h3.34l1.26 1.3a6.32 6.32 0 001.07-3.49A5.94 5.94 0 0012.79 9 4.93 4.93 0 008.9 7.25a5.05 5.05 0 00-3.95 1.78A5.94 5.94 0 003.6 12.9c0 .73.12 1.44.36 2.12a5.3 5.3 0 002.7 3.06 5.2 5.2 0 002.25.48zM24.24 21.57c-1.38 0-2.43-.41-3.15-1.23-.72-.83-1.08-2.05-1.08-3.66V8.89h3.44V16c0 1.92.74 2.87 2.23 2.87.67 0 1.31-.18 1.93-.54a4.16 4.16 0 001.54-1.71V8.89h3.43v8.79c0 .33.06.57.18.7.14.15.35.23.64.25v2.7a7.72 7.72 0 01-1.48.15c-.62 0-1.12-.13-1.52-.38-.37-.27-.6-.64-.66-1.1l-.08-1a5.6 5.6 0 01-2.31 1.93c-.94.43-1.98.64-3.1.64zM36 21.33V8.9h3.44v12.44H36zm0-14.17V4h3.44v3.16H36zM41.7 15.11a5.98 5.98 0 011.9-4.51 6.92 6.92 0 012.22-1.4 7.9 7.9 0 012.96-.52c1.47 0 2.72.29 3.74.88a5.8 5.8 0 012.34 2.3l-3.36.95c-.3-.46-.68-.8-1.16-1.05-.48-.25-1-.38-1.59-.38-.5 0-.96.1-1.39.29a3.3 3.3 0 00-1.87 1.92 4.32 4.32 0 00.03 3.04c.19.46.43.86.74 1.19.33.33.7.6 1.13.78a3.57 3.57 0 003.05-.16c.53-.29.9-.64 1.1-1.05l3.37.95a5.4 5.4 0 01-2.29 2.33c-1.06.6-2.33.9-3.82.9a7.9 7.9 0 01-2.95-.52 6.57 6.57 0 01-3.67-3.47 6.44 6.44 0 01-.49-2.47z"></path></svg>';
	}
}

if ( ! function_exists( ' quicq_doc_icon' ) ) {
	function quicq_doc_icon() {
		echo '<svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="file-alt" class="svg-inline--fa fa-file-alt fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zm-22.6 22.7c2.1 2.1 3.5 4.6 4.2 7.4H256V32.5c2.8.7 5.3 2.1 7.4 4.2l83.9 83.9zM336 480H48c-8.8 0-16-7.2-16-16V48c0-8.8 7.2-16 16-16h176v104c0 13.3 10.7 24 24 24h104v304c0 8.8-7.2 16-16 16zm-48-244v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm0 64v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12zm0 64v8c0 6.6-5.4 12-12 12H108c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h168c6.6 0 12 5.4 12 12z"/></svg>';
	}
}

if ( ! function_exists( ' quicq_arrow_icon' ) ) {
	function quicq_arrow_icon() {
		echo '<svg  style="height:12px; margin-left: 5px;"aria-hidden="true" focusable="false" data-prefix="far" data-icon="long-arrow-right" class="svg-inline--fa fa-long-arrow-right fa-w-14 fa-fw fa-xs ml-8" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M295.515 115.716l-19.626 19.626c-4.753 4.753-4.675 12.484.173 17.14L356.78 230H12c-6.627 0-12 5.373-12 12v28c0 6.627 5.373 12 12 12h344.78l-80.717 77.518c-4.849 4.656-4.927 12.387-.173 17.14l19.626 19.626c4.686 4.686 12.284 4.686 16.971 0l131.799-131.799c4.686-4.686 4.686-12.284 0-16.971L312.485 115.716c-4.686-4.686-12.284-4.686-16.97 0z"></path></svg>';
	}
}

/**
 * Adds quicq menu style
 * @since 1.0
 */
if ( ! function_exists( ' quicq_plugin_style' ) ) {
	function quicq_plugin_style() {
		?>
        <style media="screen">
            .wp-menu-image img {
                padding-top: unset !important;
                width: 25px;
                height: 25px;
                margin-top: 5px;
                border-radius: 2px;
            }
        </style>
		<?php
	}
}


/**
 * Quicq admin page
 * Styles inline for pagespeed
 * @since 1.0
 */
if ( ! function_exists( ' quicq_adminpage' ) ) {
	function quicq_adminpage() {

		if ( current_user_can( 'manage_options' ) ) {

			if ( isset( $_SERVER['REQUEST_METHOD'] ) && ! strcasecmp( $_SERVER['REQUEST_METHOD'], 'POST' ) ) {
				if ( isset( $_POST['quicq_key'] ) ) {
					$quicqKey  = sanitize_key( wp_unslash( $_POST['quicq_key'] ) );
					$quicq_url = 'https://cdn.quicq.io/' . $quicqKey;
					update_option( 'upload_url_path', $quicq_url );
					update_option( 'quicq_key', $quicq_url );
				}

				if ( isset( $_POST['action'] ) && $_POST['action'] == 'update' ) {

					if ( get_option( 'quicq_key' ) === "https://cdn.quicq.io/" || ! isset( $_POST['quicq_enabled'] ) ) {
						update_option( 'quicq_enabled', 0 );
						update_option( 'upload_url_path', '' );
					} else {
						$isEnabled = filter_input( INPUT_POST, 'quicq_enabled', FILTER_SANITIZE_NUMBER_INT );
						update_option( 'quicq_enabled', $isEnabled );
						update_option( 'upload_url_path', get_option( 'quicq_key' ) );
					}
				}
			}
		}


		?>

        <section class="quicq-admin quicq-admin-tab wrap">
            <div class="quicq-container-small">
                <div class="row">
                    <div class="col-12 py-3">
						<?php quicq_logo(); ?>
                        <h1 class="quicq-h3"><?php echo _e( 'Boost your website', 'quicq' ); ?></h1>
                        <div><?php echo _e( 'Compress images and improve your pagespeed with Quicq.', 'quicq' ); ?></div>
                    </div>
                    <div class="col-12 py-3"></div>
                </div>
            </div>
            <div class="quicq-container-small">
                <div class="row">
                    <div class="col-12 py-3">
                        <div class="quicq-card">
                            <div class="row">
                                <div class="col-md-8 my-auto">
                                    <h4 class="quicq-h4"> <?php echo _e( 'Join Quicq', 'quicq' ); ?> </h4>
                                    <div class="quicq-text-meta"><?php echo _e( 'Create a URL key in your Afosto account and enter it below to get your images in AVIF or WebP.', 'quicq' ); ?></div>
                                </div>
                                <div class="col-md-4 my-auto text-center">
                                    <a class="quicq-btn quicq-btn-primary btn-block w-300" target="_blank"
                                       href="https://afosto.app/auth/signup"><?php _e( 'Sign up', 'quicq' ); ?></a>
                                    <a class="text-center d-block py-2" target="_blank"
                                       href="https://afosto.app/auth/login"><?php _e( 'Log in', 'quicq' ); ?></a>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="quicq-container-small">
                <div class="row">
                    <div class="col-6">
                        <div class="quicq-card">
                            <div class="quicq-card-body p-3 mb-1">
                                <div class="quicq-h5 quicq-margin-remove"><?php echo _e( 'About Quicq', 'quicq' ); ?></div>
                                <div class="quicq-text-meta"><?php echo _e( 'Speed ​​up the loading time of your website or webshop by up to 80% with Quicq. Improve pagespeed, outperform competitors and boost your SEO.', 'quicq' ); ?></div>
                            </div>
                            <a href="https://afosto.com/docs/apps/quicq/wordpress-en/" target="_blank"
                               class="quicq-card-body text-dark text-decoration-none d-block p-3 mb-1">
                                <div class="row">
                                    <div class="col-1 my-auto">
                                        <div class="doc-icon-20 text-primary">
											<?php quicq_doc_icon(); ?>
                                        </div>
                                    </div>
                                    <div class="col-11">
                                        <div class="quicq-h5 quicq-margin-remove"><?php echo _e( 'How to setup Quicq?', 'quicq' ); ?></div>
                                        <div class="quicq-text-meta text-primary"><?php echo _e( 'Go to docs', 'quicq' );
											 quicq_arrow_icon(); ?> </div>
                                    </div>
                                </div>

                            </a>

                            <div class="quicq-card-body p-3 mb-1">
                                <div class="quicq-h5 quicq-margin-remove"><?php echo _e( 'Contribution', 'quicq' ); ?></div>
                                <div class="quicq-text-meta"><?php echo _e( 'This plugin was made in collaboration with', 'quicq' ); ?>
                                    <a class="text-decoration-none " href="https://kyano.app"
                                       target="_blank"><?php echo _e( 'Kyano.app', 'quicq' ); ?> </a></div>
                            </div>


                        </div>
                    </div>
                    <div class="col-6">
                        <div class="quicq-card">
                            <form method="post">
								<?php settings_fields( 'quicq-page' ); ?>
								<?php do_settings_sections( 'quicq-page' ); ?>
                                <div class="p-2 quicq-switcher quicq-margin">
                                    <div class="quicq-card-default quicq-card-body">
                                        <div class="quicq-width-xlarge quicq-grid my-auto pb-3"
                                             style="display: block !important;">
                                            <div class="  quicq-first-column">
                                                <div class="quicq-h5 quicq-margin-remove"><?php echo _e( 'URL Key:', 'quicq' ); ?></div>
                                                <div class="quicq-text-meta"><?php echo _e( 'Example:', 'quicq' ); ?>
                                                    <span
                                                            class="text-muted"> <?php echo _e( 'quicq', 'quicq' ); ?> </span>
                                                </div>
                                            </div>
                                            <div style="margin-top: 10px;">
                                                <label class="quicq-margin-left col-12" for="quicq_key">
													<?php if ( get_option( 'upload_url_path' ) == '' ) { ?>
														<?php $key = str_replace( "https://cdn.quicq.io/", "", get_option( 'quicq_key' ) ); ?>
                                                        <input type="text" name="quicq_key"
                                                               value="<?php echo esc_attr( $key ); ?>"/>
														<?php
													} else {
														$key = str_replace( "https://cdn.quicq.io/", "", get_option( 'upload_url_path' ) ); ?>
                                                        <input type="text" name="quicq_key"
                                                               value="<?php echo esc_attr( $key ); ?>"/>
														<?php
													}
													?>

                                                </label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="quicq-width-xlarge quicq-grid" quicq-grid="">
                                            <div class="my-auto quicq-first-column">
                                                <label class="checkbox-container" class="quicq-margin-left"
                                                       for="quicq_enabled">
                                                    <input class="switch" name="quicq_enabled" type="checkbox"
                                                           value="1" <?php checked( '1', get_option( 'quicq_enabled' ) ); ?> />
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="my-auto">
                                                <div class="quicq-h5 quicq-margin-remove"><?php echo _e( 'Activate Quicq', 'quicq' ); ?></div>
                                                <div class="quicq-text-meta"><?php echo _e( 'Activate quicq on your website.', 'quicq' ); ?></div>
                                            </div>

                                        </div>
                                    </div>
									<?php submit_button( '', 'quicq-btn quicq-btn-primary btn-block' ); ?>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
		<?php
	}
}

