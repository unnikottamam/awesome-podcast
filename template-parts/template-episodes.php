<?php
/**
 * Template Name: All Episodes
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package podcast
 */

$template_loader = new PW_Template_Loader;
wp_reset_query();
?>

<section class="eposodes_sec comm_padd">
	<div class="shell">
		<div class="container">
			<div class="cust_row">
				<div class="width_100">
					<h3><?php the_title(); ?></h3>
				</div>
			</div>
			<?php 
			wp_reset_query();
			$args = array( 'post_type' => 'episodes', 'posts_per_page' => 12, 'paged'=>max(1 , get_query_var('paged')));
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
				the_posts_pagination( array(
					'mid_size'  => 2,
					'prev_text' => __( '<i class="fas fa-chevron-left"></i>', 'textdomain' ),
					'next_text' => __( '<i class="fas fa-chevron-right"></i>', 'textdomain' ),
				) ); 
			} else { ?>
				<h4>There's no episodes available at this time.</h4>
				<?php
			} wp_reset_query();?>
		</div>
	</div>
</section>

<?php
