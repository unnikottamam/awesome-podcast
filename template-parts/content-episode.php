<?php
/**
 * Template part for displaying episode item
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package podcast
 */

?>

<div class="epidoes_list width_25 width_md_33 width_sm_50 width_xs_100">
    <div class="epidoes_list__inn">
        <a href="<?php the_permalink(); ?>"></a>
        <div class="epidoes_list__img">
            <?php
            $img_url = get_field('guest_thumbnail_photograph');
            $image_id = podcast_get_image_id($img_url);
            $image_thumb = wp_get_attachment_image_src($image_id, 'podcast-thumb');
            if($image_thumb[0]) {
                echo '<img src="'.$image_thumb[0].'" alt="'.get_the_title().'">';
            }
            else {
                echo '<div class="epidoes_list__imgin"><img src="https://via.placeholder.com/516x290/1fb6fb/1fb6fb" alt="image"></div>';
            } ?>
        </div>
        <div class="epidoes_list__cont">
            <h4><?php the_title(); ?></h4>
            <?php 
            if(get_field('guest_full_name'))
                echo '<h5><strong>'.get_field('guest_full_name').'</strong>';
            if(get_field('guest_position_name'))
                echo ', '.get_field('guest_position_name');
            if(get_field('guest_company')) 
                echo '<br>at <span>'.get_field('guest_company').'</span>';
            if(get_field('guest_full_name')) 
                echo '</h5>';
            if(get_field('short_description')) {
                ?>
                <p><?php echo mb_strimwidth(get_field('short_description'), 0, 110, '...'); ?></p>
            <?php } ?>
            <div class="epidoes_list__links" data-postid="<?php echo $post->ID; ?>" data-episode="<?php echo get_field('episode_number'); ?>" data-guest="<?php echo get_field('guest_full_name'); ?>" data-company="<?php echo get_field('guest_company'); ?>" data-position="<?php echo get_field('guest_position_name'); ?>" data-title="<?php echo get_the_title(); ?>" data-sonixid="<?php echo get_field('sonix_id'); ?>" data-podcasturl="<?php echo get_field('episode_podcast_url'); ?>" data-shortdesc="<?php echo get_field('short_description'); ?>" data-thumb="<?php echo get_field('guest_thumbnail_photograph'); ?>" >
                <div class="cust_row">
                    <div class="width_70">
                        <a href="<?php the_permalink(); ?>">Listen Now</a>
                    </div>
                    <div class="width_30 text-right">
                        <span class="play_btn"><i class="fas fa-play"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>