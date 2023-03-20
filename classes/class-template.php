<?php
/**
* admin template class for initiating necessary functions.
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if (!class_exists('Wpqai_Template')) {

	class Wpqai_Template {

		public static $view_dir = WPQAI_TEMPLATE;

		public static function prepare( $name, $data = [], $suffix = '.php' ) {
			$markup = '';
			$path = self::get_full_path( $name, $suffix );

			if ( $t = self::view_template_exists( $path ) ) {
				$data = self::prepare_data( $data );
				ob_start();
				include $path;
				$markup = ob_get_clean();
			}

			return $markup;
		}

		public static function render( $name, $data = [], $suffix = '.php' ) {
			echo self::prepare( $name, $data, $suffix );
		}

		private static function prepare_data( $data ) {

			// if data is not already an object, cast as object
			if ( ! is_object( $data ) ) {
				$data = (object) (array) $data;
			}

			return $data;
		}

		private static function view_template_exists( $name ) {
			return file_exists( $name );
		}

		private static function get_full_path( $name, $suffix ) {
			$path = trailingslashit( self::$view_dir ) . ltrim( $name, '/' );

			// If a file exists, return the file path.
			if ( file_exists( $path . $suffix ) ) {
				return $path . $suffix;
			}

			// If a dir of the same name exists, return a path to an index file within that dir.
			if ( is_dir( $path ) ) {
				return $path . '/index' . $suffix;
			}

			return $path;
		}

	}
}