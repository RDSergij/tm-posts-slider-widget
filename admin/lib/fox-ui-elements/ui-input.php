<?php
/**
 * Description: Fox ui-elements
 * Version: 0.1.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 *
 * @package ui_input_fox
 *
 * @since 0.1.0
 */

if ( ! class_exists( 'UI_Input_Fox' ) ) {

	/**
	 * UI-input.
	 */
	class UI_Input_Fox {

		/**
		 * Default settings
		 *
		 * @var type array
		 */
		private $default_settings = array(
			'id'				=> 'input-fox',
			'class'				=> '',
			'type'				=> 'text',
			'name'				=> 'input-fox',
			'value'				=> '',
			'placeholder'		=> 'enter string',
		);

		/**
		 * Required settings
		 *
		 * @var type array
		 */
		private $required_settings = array(
			'class'				=> 'input-fox',
		);

		/**
		 * Settings
		 *
		 * @var type array
		 */
		public $settings;

		/**
		 * Init base settings
		 */
		public function __construct( $attr = null ) {
			if ( empty( $attr ) || ! is_array( $attr ) ) {
				$attr = $this->default_settings;
			} else {
				foreach ( $this->default_settings as $key => $value ) {
					if ( empty( $attr[ $key ] ) ) {
						$attr[ $key ] = $this->default_settings[ $key ];
					}
				}
			}

			$this->settings = $attr;
		}

		/**
		 * Add styles
		 */
		private function assets() {
			$url = plugins_url( 'fox-ui-elements/assets/css/input.min.css', dirname( __FILE__ ) );
			wp_enqueue_style( 'input-fox', $url, array(), '0.1.0', 'all' );
		}

		/**
		 * Render html
		 *
		 * @return string
		 */
		public function output() {
			$this->assets();
			foreach ( $this->required_settings as $key => $value ) {
				$this->settings[ $key ] = empty( $this->settings[ $key ] ) ? $value : $this->settings[ $key ] . ' ' . $value;
			}

			if ( ! empty( $this->settings['label'] ) ) {
				$label = $this->settings['label'];
				unset( $this->settings['label'] );
			}
			$attributes = '';
			foreach ( $this->settings as $key => $value ) {
				$attributes .= ' ' . $key . '="' . $value . '"';
			}

			ob_start();
			require( 'views/input.php' );
			return ob_get_clean();
		}
	}
}
