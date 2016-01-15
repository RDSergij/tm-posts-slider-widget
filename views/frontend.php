<?php
/**
 * Frontend view
 *
 * @package TM_Posts_Widget
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
<!-- Swiper -->
<div class="swiper-container tm-post-slider-widget">
	<h2><?php echo $title ?></h2>
	<div class="swiper-wrapper">
		<?php while ( $query->have_posts() ) : ?>
		<?php $query->the_post(); ?>
		<div class="swiper-slide">
			<a href="<?php echo get_the_permalink(); ?>">
				<h4><?php echo get_the_title() ?></h4>
			</a>
			<?php if ( 'true' == $thumbnails_is && has_post_thumbnail( get_the_ID() ) ) : ?>
			<?php echo get_the_post_thumbnail( get_the_ID(), 'thumbnail', array( 'class' => 'alignleft' ) ) ?>
			<?php endif; ?>
			<div class="slider-description">
				<?php echo get_the_excerpt() ?>
			</div>
			<?php if ( 'true' == $button_is ) : ?>
			<div class="slide-button"><a href="<?php echo get_the_permalink(); ?>"><?php echo $button_text ?></a></div>
			<?php endif; ?>
		</div>
		<?php endwhile; ?>
	</div>
	<?php if ( 'true' == $bullets_is ) : ?>
	<!-- Add Pagination -->
	<div class="swiper-pagination"></div>
	<?php endif; ?>

	<?php if ( 'true' == $arrows_is ) : ?>
	<!-- Add Arrows -->
	<div class="swiper-button-next"></div>
	<div class="swiper-button-prev"></div>
	<?php endif; ?>
</div>
