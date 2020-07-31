<?php
/**
 * Template part for displaying player bar section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package podcast
 */

$args = array( 'post_type' => 'episodes', 'posts_per_page' => 1);
query_posts($args);
if (have_posts()) {
    while (have_posts()) {
        the_post();
        $img_url = get_field('guest_thumbnail_photograph');
        $title = get_the_title();
        $number = get_field('episode_number');
        $sonix_id = get_field('sonix_id');
        $pod_url = get_field('episode_podcast_url');
        $gst_name = get_field('guest_full_name');
        $gst_posi = get_field('guest_position_name');
        $gst_company = get_field('guest_company');
        $short = get_field('short_description');
    }
} ?>

<div class="player_btm" data-episode="<?php echo $number; ?>" data-guest="<?php echo $gst_name; ?>" data-company="<?php echo $gst_company; ?>" data-position="<?php echo $gst_posi ?>" data-title="<?php echo $title; ?>" data-podcasturl="<?php echo $pod_url; ?>" data-shortdesc="<?php echo $short; ?>" data-thumb="<?php echo $img_url; ?>">
    <a href="#" class="player_btm__open"></a>
    <div class="shell">
        <div class="container">
            <div class="cust_row">
                <div class="width_100">
                    <div class="player_btm__inn">
                        <a href="#" class="player_btm__play">
                            <i class="fas fa-play"></i>
                        </a>
                        <h4><?php echo $title; ?></h4>
                        <p><?php echo $gst_name; ?>, <?php echo $gst_posi; ?> at <?php echo $gst_company; ?></p>
                        <div class="player_btm__timer"><span class="player_btm__time d-none">10:04</span> - <span class="player_btm__duration d-none">10:04</span></div>
                        <a href="#" class="player_btm__toggle">OPEN <i class="fas fa-chevron-up"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$templates = new PW_Template_Loader;
$templates->get_template_part( 'content', 'playermodal' );
wp_reset_query();
?>