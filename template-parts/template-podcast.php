<?php
/**
 * Template Name: Podcast Home
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package podcast
 */

$template_loader = new PW_Template_Loader;
$no_episodes = false;
$episodes_count = 0;
$args1 = array( 'post_type' => 'episodes', 'posts_per_page' => 3 );
query_posts($args1);
if (have_posts()) {
	while (have_posts()) {
		the_post();
		$episodes_count++;
	}
}
wp_reset_query();
$args = array( 'post_type' => 'episodes', 'posts_per_page' => 1 );
query_posts($args);
if (have_posts()) {
	while (have_posts()) {
		the_post();
		$curr_id = get_the_ID();
		?>
		<section class="episode_head comm_padd" style="background-color: #f1f8ff;">
			<div class="shell">
				<div class="container">
					<div class="cust_row spcace_between">
						<?php if(get_field('guest_photograph')) { ?>
							<div class="episode_head__left width_40 mob_full">
								<?php
								$img_url = get_field('guest_photograph');
								$image_id = podcast_get_image_id($img_url);
								$image_thumb = wp_get_attachment_image_src($image_id, 'podcast-main');
								?>
								<img src="<?php echo $image_thumb[0]; ?>" alt="<?php the_title(); ?>">
							</div>
						<?php } ?>
						<div class="episode_head__right <?php if(get_field('guest_photograph')) { ?>width_60<?php } else { ?>width_100<?php } ?> mob_full">
							<h5 class="post_player" data-episode="<?php echo get_field('episode_number'); ?>" data-guest="<?php echo get_field('guest_full_name'); ?>" data-company="<?php echo get_field('guest_company'); ?>" data-position="<?php echo get_field('guest_position_name'); ?>" data-title="<?php echo get_the_title(); ?>" data-podcasturl="<?php echo get_field('episode_podcast_url'); ?>" data-shortdesc="<?php echo get_field('short_description'); ?>" data-thumb="<?php echo get_field('guest_thumbnail_photograph'); ?>" >
								<span class="play_btn"><i class="fas fa-play"></i></span> Episode <?php the_field('episode_number'); ?>
							</h5>
							<h2><?php the_title(); ?></h2>
							<?php if(get_field('guest_full_name')) { ?>
								<h4>Guest: <?php the_field('guest_full_name'); ?></h4>
								<?php 
							} if(get_field('long_description')) {
								echo '<p>'.get_field('long_description').'</p>';
							} if ( have_rows('podcast_links') ) {
								?>
								<ul class="cta_list">
									<?php
									while ( have_rows('podcast_links') ) {
										the_row();
										?>
										<li>
											<a target="_blank" href="<?php the_sub_field('url'); ?>">
												<?php if(get_sub_field('select_icon') != 0) { ?>
													<span>Listen on</span>
													<img src="<?php echo get_template_directory_uri(); ?>/resources/images/<?php the_sub_field('select_icon'); ?>.png" alt="<?php the_title(); ?>">
													<?php
													if(get_sub_field('select_icon') == 1) {
														echo 'Apple Podcasts';
													}
													elseif (get_sub_field('select_icon') == 2) {
														echo 'Google Podcasts';
													}
													elseif (get_sub_field('select_icon') == 3) {
														echo 'Spotify';
													} ?>
												<?php } else { ?>
													<img src="<?php the_sub_field('icon'); ?>" alt="<?php the_title(); ?>">
												<?php } ?>
											</a>
										</li>
										<?php
									} ?>
								</ul>
								<?php
							} ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php 
	}
} else {
	$no_episodes = true;
	?>
	<section class="episode_head comm_padd" style="background-color: #f1f8ff;">
		<div class="shell">
			<div class="container">
				<div class="cust_row spcace_between">
					<div class="width_100 text-center mob_full">
						<h4>There's no episodes available at this time.</h4>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
}  if(get_field('cta_newsletter_title', 'options') || get_field('cta_newsletter_form', 'options')) {
	$text_style = 'light_text';
	$bg_color = '#2049e6';
	?>
	<section class="contact_sec sm_padd <?php echo $text_style; ?>" style="background-color: <?php echo $bg_color; ?>; background-image: <?php the_sub_field('bg_image'); ?>;">
		<div class="shell">
			<div class="container">
				<div class="cust_row spcace_center">
					<div class="width_70 mob_full">
						<?php if(get_field('cta_newsletter_title', 'options')) { ?>
							<div class="text-center">
								<h3><?php the_field('cta_newsletter_title', 'options'); ?></h3>
							</div>
						<?php } echo do_shortcode( get_field('cta_newsletter_form', 'options') ); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
} if(!$no_episodes) { ?>
	<section class="eposodes_sec comm_padd">
		<div class="shell">
			<div class="container">
				<div class="cust_row">
					<div class="width_100">
						<h3>Latest Episode<?php if($episodes_count > 1) echo 's'; ?></h3>
					</div>
				</div>
				<?php 
				wp_reset_query();
				if($episodes_count > 1)
					$args = array( 'post_type' => 'episodes', 'posts_per_page' => 8, 'post__not_in' => array( $curr_id ) );
				else 
					$args = array( 'post_type' => 'episodes', 'posts_per_page' => 8 );
				query_posts($args);
				if (have_posts()) { ?>
					<div class="cust_row episodes_lists">
						<?php
						while (have_posts()) {
							the_post();
							$template_loader->get_template_part( 'content', 'episode' );
						} ?>
					</div>
					<?php
					$template_loader->get_template_part( 'content', 'loadmore' );
				} wp_reset_query(); ?>
			</div>
		</div>
	</section>
	<?php
}
