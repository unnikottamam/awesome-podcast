<?php
/**
 * The template for displaying podcast category
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package podcast
 */

$template_loader = new PW_Template_Loader;
get_header(); ?>

<section class="eposodes_sec comm_padd">
	<div class="shell">
		<div class="container">
			<div class="cust_row">
				<div class="width_100">
					<?php
					the_archive_title( '<h3>', '</h3>' );
					the_archive_description( '<p>', '</p>' );
					?>
				</div>
			</div>
			<?php if (have_posts()) { ?>
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
				<p>There's no episodes available in this category.</p>
				<?php
			} ?>
		</div>
	</div>
</section>

<?php
get_footer();
