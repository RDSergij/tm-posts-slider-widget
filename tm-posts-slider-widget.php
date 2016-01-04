<?php
/**
 * Plugin Name:  TM Posts Slide Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Posts slider widget
 * Version: 1.0.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: tm_post_slide_widget
 *
 * @package TM_Posts_Widget
 *
 * @since 1.0.0
 */

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
			__( 'TM Posts Slide Widget', 'tm_post_slide_widget' ),
			array( 'description' => __( 'Posts slider widget', 'tm_post_slide_widget' ) )
		);
		// Set default settings
		$this->instance_default = array(
			'title'			=> __( 'List', 'tm_post_slide_widget' ),
			'categories'	=> 0,
			'count'			=> 4,
			'button_is'		=> 'true',
			'button_text'	=> __( 'Button text', 'tm_post_slide_widget' ),
			'arrows_is'		=> 'true',
			'bullets_is'	=> 'true',
			'thumbnails_is'	=> 'true',
		);
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
		wp_enqueue_script( 'tm-post-slider-script-frontend' );

		// Swiper styles
		wp_register_style( 'tm-post-slider-swiper', plugins_url( 'assets/css/swiper.min.css', __FILE__ ) );
		wp_enqueue_style( 'tm-post-slider-swiper' );

		// Custom styles
		wp_register_style( 'tm-post-slider-frontend', plugins_url( 'assets/css/frontend.min.css', __FILE__ ) );
		wp_localize_script( 'tm-post-slider-frontend', 'TMWidgetParam', array(
					'ajaxurl'		=> admin_url( 'admin-ajax.php' ),
					'arrows_is'		=> $instance['arrows_is'],
					'bullets_is'	=> $instance['bullets_is'],
				)
			);
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

		// Ui cherri api
		wp_register_script( 'tm-post-slider-script-api', plugins_url( 'assets/js/cherry-api.js', __FILE__ ) );
		wp_localize_script( 'tm-post-slider-script-api', 'cherry_ajax', wp_create_nonce( 'cherry_ajax_nonce' ) );
		wp_localize_script( 'tm-post-slider-script-api', 'wp_load_style', null );
		wp_localize_script( 'tm-post-slider-script-api', 'wp_load_script', null );
		wp_enqueue_script( 'tm-post-slider-script-api' );

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
		require_once __DIR__ . '/admin/lib/ui-elements/ui-text/ui-text.php';
		require_once __DIR__ . '/admin/lib/ui-elements/ui-select/ui-select.php';
		require_once __DIR__ . '/admin/lib/ui-elements/ui-switcher/ui-switcher.php';

		$title_field = new UI_Text(
						array(
								'id'            => $this->get_field_id( 'title' ),
								'type'          => 'text',
								'name'          => $this->get_field_name( 'title' ),
								'placeholder'   => __( 'New title', 'tm_post_slide_widget' ),
								'value'         => $title,
								'label'         => __( 'Title widget', 'tm_post_slide_widget' ),
						)
				);
		$title_html = $title_field->render();

		$categories_list = get_categories( array( 'hide_empty' => 0 ) );
		$categories_array = array( '0' => 'not selected' );
		foreach ( $categories_list as $category_item ) {
			$categories_array[ $category_item->term_id ] = $category_item->name;
		}

		$categories_field = new UI_Select(
						array(
							'id'				=> $this->get_field_id( 'categories' ),
							'name'				=> $this->get_field_name( 'categories' ),
							'value'				=> $categories,
							'options'			=> $categories_array,
						)
					);
		$categories_html = $categories_field->render();

		$count_field = new UI_Text(
						array(
								'id'            => $this->get_field_id( 'count' ),
								'type'          => 'text',
								'name'          => $this->get_field_name( 'count' ),
								'placeholder'   => __( 'posts count', 'tm_post_slide_widget' ),
								'value'         => $count,
								'label'         => __( 'Count of posts', 'tm_post_slide_widget' ),
						)
				);
		$count_html = $count_field->render();

		$button_is_field = new UI_Switcher2(
							array(
									'id'				=> $this->get_field_id( 'button_is' ),
									'name'				=> $this->get_field_name( 'button_is' ),
									'value'				=> $button_is,
									'toggle'			=> array(
											'true_toggle'	=> 'On',
											'false_toggle'	=> 'Off',
									),

									'style'		=> 'normal',
							)
					);
		$button_is_html = $button_is_field->render();

		$button_text_field = new UI_Text(
						array(
								'id'            => $this->get_field_id( 'button_text' ),
								'type'          => 'text',
								'name'          => $this->get_field_name( 'button_text' ),
								'placeholder'   => __( 'read more...', 'tm_post_slide_widget' ),
								'value'         => $button_text,
								'label'         => __( 'Button text', 'tm_post_slide_widget' ),
						)
				);
		$button_text_html = $button_text_field->render();

		$arrows_is_field = new UI_Switcher2(
							array(
									'id'				=> $this->get_field_id( 'arrows_is' ),
									'name'				=> $this->get_field_name( 'arrows_is' ),
									'value'				=> $arrows_is,
									'toggle'			=> array(
											'true_toggle'	=> 'On',
											'false_toggle'	=> 'Off',
									),

									'style'		=> 'normal',
							)
					);
		$arrows_is_html = $arrows_is_field->render();

		$bullets_is_field = new UI_Switcher2(
							array(
									'id'				=> $this->get_field_id( 'bullets_is' ),
									'name'				=> $this->get_field_name( 'bullets_is' ),
									'value'				=> $bullets_is,
									'toggle'			=> array(
											'true_toggle'	=> 'On',
											'false_toggle'	=> 'Off',
									),

									'style'		=> 'normal',
							)
					);
		$bullets_is_html = $bullets_is_field->render();

		$thumbnails_is_field = new UI_Switcher2(
							array(
									'id'				=> $this->get_field_id( 'thumbnails_is' ),
									'name'				=> $this->get_field_name( 'thumbnails_is' ),
									'value'				=> $thumbnails_is,
									'toggle'			=> array(
											'true_toggle'	=> 'On',
											'false_toggle'	=> 'Off',
									),

									'style'		=> 'normal',
							)
					);
		$thumbnails_is_html = $thumbnails_is_field->render();

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
