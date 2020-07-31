<?php
/**
 * Template part for displaying lode more episode item
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package podcast
 */

if(get_field('all_episodes_page', 'options')) {
	?>
	<div class="cust_row paddt_20">
		<div class="width_100 text-center">
			<a href="<?php the_field('all_episodes_page', 'options'); ?>" class="btn btn-primary">
				<?php echo get_field('all_podcast_text', 'options') ? get_field('all_podcast_text', 'options') : "More Podcasts"; ?>
			</a>
		</div>
	</div>
<?php }