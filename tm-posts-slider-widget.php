<?php
/**
 * Plugin Name:  TM Posts Slide Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Posts slider widget
 * Version: 1.0.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab-base-tm
 *
 * @package TM_Posts_Widget
 *
 * @since 1.0.0
 */

if ( ! class_exists( 'TM_Posts_Widget' ) ) {
	/**
	 * Set constant text domain.
	 *
	 * @since 1.0.0
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_ALIAS' ) ) {
		define( 'PHOTOLAB_BASE_TM_ALIAS', 'photolab-base-tm' );
	}

	/**
	 * Set constant path of text domain.
	 *
	 * @since 1.0.0
	 */
	if ( ! defined( 'PHOTOLAB_BASE_TM_PATH' ) ) {
		define( 'PHOTOLAB_BASE_TM_PATH', dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Adds register_tm_posts_widget widget.
	 */
	class TM_Posts_Widget extends WP_Widget {

		/**
		 * Default settings
		 *
		 * @var type array
		 */
		private $instance_default = array();
		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'tm_posts_widget', // Base ID
				__( 'TM Posts Slide Widget', PHOTOLAB_BASE_TM_ALIAS ),
				array( 'description' => __( 'Posts slider widget', PHOTOLAB_BASE_TM_ALIAS ) )
			);
			// Set default settings
			$this->instance_default = array(
				'title'			=> __( 'List', PHOTOLAB_BASE_TM_ALIAS ),
				'categories'	=> 0,
				'count'			=> 4,
				'button_is'		=> 'true',
				'button_text'	=> __( 'Button text', PHOTOLAB_BASE_TM_ALIAS ),
				'arrows_is'		=> 'true',
				'bullets_is'	=> 'true',
				'thumbnails_is'	=> 'true',
				'autoplay'		=> 'false',
			);
		}

		/**
		 * Load languages
		 *
		 * @since 1.0.0
		 */
		public function include_languages() {
			load_plugin_textdomain( PHOTOLAB_BASE_TM_ALIAS, false, PHOTOLAB_BASE_TM_PATH );
		}

		/**
		 * Frontend view
		 *
		 * @param type $args array.
		 * @param type $instance array.
		 */
		public function widget( $args, $instance ) {
			// Swiper js
			wp_register_script( 'tm-post-slider-script-swiper', plugins_url( 'assets/js/swiper.min.js', __FILE__ ), '', '', true );
			wp_enqueue_script( 'tm-post-slider-script-swiper' );

			// Custom js
			wp_register_script( 'tm-post-slider-script-frontend', plugins_url( 'assets/js/frontend.min.js', __FILE__ ), '', '', true );
			$autoplay = ! empty( $instance['autoplay'] ) ? $instance['autoplay'] : $this->instance_default['autoplay'];
			wp_localize_script( 'tm-post-slider-script-frontend', 'TMSliderWidgetParam', array(
						'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
						'autoplay'		=> $autoplay,
					)
				);
			wp_enqueue_script( 'tm-post-slider-script-frontend' );

			// Swiper styles
			wp_register_style( 'tm-post-slider-swiper', plugins_url( 'assets/css/swiper.min.css', __FILE__ ) );
			wp_enqueue_style( 'tm-post-slider-swiper' );

			// Custom styles
			wp_register_style( 'tm-post-slider-frontend', plugins_url( 'assets/css/frontend.min.css', __FILE__ ) );
			wp_enqueue_style( 'tm-post-slider-frontend' );

			foreach ( $this->instance_default as $key => $value ) {
				$$key = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

			$query = new WP_Query( array( 'posts_per_page' => $count, 'cat' => $categories ) );

			if ( $query->have_posts() ) {
				require __DIR__ . '/views/frontend.php';
			}
		}

		/**
		 * Create admin form for widget
		 *
		 * @param type $instance array.
		 */
		public function form( $instance ) {
			foreach ( $this->instance_default as $key => $value ) {
				$$key = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
			}

			// Custom js
			wp_register_script( 'tm-post-slider-script-admin', plugins_url( 'assets/js/admin.min.js', __FILE__ ) );
			wp_localize_script( 'tm-post-slider-script-admin', 'TMWidgetParam', array(
						'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
						'button_is'		=> $this->get_field_id( 'button_is' ),
					)
				);
			wp_enqueue_script( 'tm-post-slider-script-admin' );
			// Custom styles
			wp_register_style( 'tm-post-slider-admin', plugins_url( 'assets/css/admin.min.css', __FILE__ ) );
			wp_enqueue_style( 'tm-post-slider-admin' );

			// include ui-elements
			require_once __DIR__ . '/admin/lib/fox-ui-elements/ui-switcher.php';
			require_once __DIR__ . '/admin/lib/fox-ui-elements/ui-input.php';
			require_once __DIR__ . '/admin/lib/fox-ui-elements/ui-select.php';

			$title_field = new UI_Input_Fox(
					array(
						'id'			=> $this->get_field_id( 'title' ),
						'class'			=> 'title',
						'name'			=> $this->get_field_name( 'title' ),
						'value'			=> $title,
						'placeholder'	=> __( 'New title', PHOTOLAB_BASE_TM_ALIAS ),
					)
			);
			$title_html = $title_field->output();

			$categories_list = get_categories( array( 'hide_empty' => 0 ) );
			$categories_array = array( '0' => 'not selected' );
			foreach ( $categories_list as $category_item ) {
				$categories_array[ $category_item->term_id ] = $category_item->name;
			}

			$category_field = new UI_Select_Fox(
							array(
								'id'				=> $this->get_field_id( 'categories' ),
								'name'				=> $this->get_field_name( 'categories' ),
								'default'			=> $categories,
								'options'			=> $categories_array,
							)
						);
			$categories_html = $category_field->output();

			$count_field = new UI_Input_Fox(
							array(
								'id'			=> $this->get_field_id( 'count' ),
								'name'			=> $this->get_field_name( 'count' ),
								'value'			=> $count,
								'placeholder'   => __( 'posts count', PHOTOLAB_BASE_TM_ALIAS ),
								'label'         => __( 'Count of posts', PHOTOLAB_BASE_TM_ALIAS ),
							)
					);
			$count_html = $count_field->output();

			$button_is_field = new UI_Switcher_Fox(
							array(
								'id'        => $this->get_field_id( 'button_is' ),
								'class'		=> 'pull-right',
								'name'      => $this->get_field_name( 'button_is' ),
								'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
								'default'    => $button_is,
							)
					);
			$button_is_html = $button_is_field->output();

			$button_text_field = new UI_Input_Fox(
							array(
								'id'			=> $this->get_field_id( 'button_text' ),
								'name'			=> $this->get_field_name( 'button_text' ),
								'value'			=> $button_text,
								'placeholder'   => __( 'read more...', PHOTOLAB_BASE_TM_ALIAS ),
								'label'         => __( 'Button text', PHOTOLAB_BASE_TM_ALIAS ),
							)
					);
			$button_text_html = $button_text_field->output();

			$arrows_is_field = new UI_Switcher_Fox(
							array(
								'id'        => $this->get_field_id( 'arrows_is' ),
								'class'		=> 'pull-right',
								'name'      => $this->get_field_name( 'arrows_is' ),
								'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
								'default'    => $arrows_is,
							)
					);
			$arrows_is_html = $arrows_is_field->output();

			$bullets_is_field = new UI_Switcher_Fox(
							array(
								'id'        => $this->get_field_id( 'bullets_is' ),
								'class'		=> 'pull-right',
								'name'      => $this->get_field_name( 'bullets_is' ),
								'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
								'default'    => $bullets_is,
							)
					);
			$bullets_is_html = $bullets_is_field->output();

			$thumbnails_is_field = new UI_Switcher_Fox(
							array(
								'id'        => $this->get_field_id( 'thumbnails_is' ),
								'class'		=> 'pull-right',
								'name'      => $this->get_field_name( 'thumbnails_is' ),
								'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
								'default'    => $thumbnails_is,
							)
					);
			$thumbnails_is_html = $thumbnails_is_field->output();

			$autoplay_field = new UI_Switcher_Fox(
								array(
									'id'        => $this->get_field_id( 'autoplay' ),
								'class'		=> 'pull-right',
									'name'      => $this->get_field_name( 'autoplay' ),
									'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
									'default'    => $autoplay,
								)
						);
			$autoplay_html = $autoplay_field->output();

			// show view
			require 'views/widget-form.php';
		}

		/**
		 * Update settings
		 *
		 * @param type $new_instance array.
		 * @param type $old_instance array.
		 * @return type array
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			foreach ( $this->instance_default as $key => $value ) {
				$instance[ $key ] = ! empty( $new_instance[ $key ] ) ? $new_instance[ $key ] : $value;
			}

			return $instance;
		}
	}

	/**
	 * Register widget
	 */
	function register_tm_posts_widget() {
		register_widget( 'tm_posts_widget' );
	}
	add_action( 'widgets_init', 'register_tm_posts_widget' );

}
