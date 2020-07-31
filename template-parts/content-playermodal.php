<?php
/**
 * Template part for displaying player modal section
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
        $post_title = get_the_title();
        $post_url = get_the_permalink();
        $img_url = get_field('guest_thumbnail_photograph');
        $image_id = podcast_get_image_id($img_url);
        $image_thumb = wp_get_attachment_image_src($image_id, 'podcast-small');
        $pod_thumb = $image_thumb[0];
        $title = get_the_title();
        $number = get_field('episode_number');
        $sonix_id = get_field('sonix_id');
        $pod_url = get_field('episode_podcast_url');
        $gst_name = get_field('guest_full_name');
        $gst_posi = get_field('guest_full_name');
        $gst_company = get_field('guest_company');
        $short = get_field('short_description');
    }
} wp_reset_query(); ?>

<div class="player_modal text-center">
    <a id="mPlayClose" href="#" class="player_modal__toggle">CLOSE <i class="fas fa-chevron-down"></i></a>
    <div class="player_modal__inn">
        <div class="shell">
            <div class="container">
                <div class="cust_row spcace_center">
                    <div class="width_50 width_md_80 mob_full">
                        <div class="player_modal__cont">
                            <?php 
                            if($pod_thumb) {
                                echo '<img id="mPlayThumb" class="audio_thumb" src="'.$pod_thumb.'" alt="'.$title.'">';
                            } ?>
                            <h4 id="mPlayTitle">Episode: <?php echo $number; ?> <?php echo $gst_name; ?> at <?php echo $gst_company; ?></h4>
                            <p id="mPlaySubtitle"><?php echo $title; ?></p>
                        </div>
                        <div class="player_bar">
                            <div id="mPlayCurTime" class="player_bar__time">0.05</div>
                            <div id="mPlaySeek" class="player_bar__seek"></div>
                            <div id="mPlayBar" class="player_bar__item"></div>
                            <div id="mPlayTime" class="player_bar__time right">5.04</div>
                        </div>
                        <div class="player_btns">
                            <button id="mPlayPrevious" class="player_btns__back"><i class="fas fa-step-backward"></i></button>
                            <button id="mPlayRewind" class="player_btns__skip left"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'resources/images'; ?>/skip_btn_prev.svg" alt="skip time"></button>
                            <button id="mPlayButton" class="player_btns__play"><i class="fas fa-play"></i></button>
                            <button id="mPlayForward" class="player_btns__skip right"><img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'resources/images'; ?>/skip_btn.svg" alt="skip time"></button>
                            <button id="mPlayNext" class="player_btns__next"><i class="fas fa-step-forward"></i></button>
                        </div>
                        <div class="player_modal__desc">
                            <p id="mPlayDescription"><?php echo $short; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="player_modal__btns">
            <li><a id="mPlayTranscript" href="#" class="btn btn-primary">Transcript</a></li>
            <li>
                <a href="#" class="btn btn-primary player_modal__share">Share <i class="fas fa-chevron-up"></i></a>
                <div class="player_modal__social">
                    <ul>
                        <li><a target="_blank" href="https://www.facebook.com/sharer?u=<?php echo $post_url; ?>&t=<?php echo rawurlencode($post_title); ?>"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $post_url; ?>&title=<?php echo rawurlencode($post_title); ?>"><i class="fab fa-linkedin-in"></i></a></li>
                        <li><a target="_blank" href="http://twitter.com/intent/tweet?text=Currently%20reading%20<?php echo rawurlencode($post_title); ?>&amp;url=<?php echo $post_url; ?>"><i class="fab fa-twitter"></i></a></li>
                    </ul>
                </div>
            </li>
            <li><a href="#" class="btn btn-primary player_modal__listtoggle"><i class="fas fa-bars"></i></a></li>
        </ul>
    </div>
    <div class="player_modal__list d-none">
        <div class="shell">
            <div class="container text-left">
                <div class="player_modal__list__cont">
                    <p>Play a stream from the list</p>
                </div>
                <div class="cust_row spcace_center">
                    <div class="width_100">
                        <div class="player_btm__inn">
                            <a href="#" class="player_btm__play">
                                <i class="fas fa-play"></i>
                            </a>
                            <h4>Episode <?php echo $number ?>: Stemify Podcast with <?php echo $gst_name; ?></h4>
                            <p><?php echo $post_title; ?></p>
                            <div class="player_btm__time"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>