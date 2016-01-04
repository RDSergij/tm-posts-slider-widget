<?php
/**
 * Admin view
 * @package TM_Posts_Widget
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

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
<p></p>
