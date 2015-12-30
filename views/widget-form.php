<?php
/**
 * Admin view
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

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

?>

<div class="tm-post-slider-form-widget">
	<p>
		<?php echo $title_html ?>
	</p>

	<p>
		<label for="categories"><?php _e( 'Category', 'tm_post_slide_widget' ) ?></label>
		<?php echo $categories_html ?>
	</p>

	<p>
		<?php echo $count_html ?>
	</p>

	<div id="button-show">
		<label for="button_is">
			<?php _e( 'Show button', 'tm_post_slide_widget' ) ?><br/>
			<?php echo $button_is_html ?>
		</label>

		<p class="tm-post-slider-button-text" <?php if ( 'false' == $button_is ) : ?>style="display: none;"<?php endif; ?>>
			<?php echo $button_text_html ?>
		</p>
	</div>

	<div class="line-switcher">
		<label for="arrows_is">
		<?php _e( 'Show arrows', 'tm_post_slide_widget' ) ?><br/>
		<?php echo $arrows_is_html ?>
		</label>

		<label for="bullets_is">
		<?php _e( 'Show bullets', 'tm_post_slide_widget' ) ?><br/>
		<?php echo $bullets_is_html ?>
		</label>

		<label for="thumbnails_is">
		<?php _e( 'Show thumbnails', 'tm_post_slide_widget' ) ?><br/>
		<?php echo $thumbnails_is_html ?>
		</label>
	</div>
</div>
