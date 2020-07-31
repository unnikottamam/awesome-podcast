<?php
/**
 * @package Podcast Plugin
 * @version 1.0
 *
Plugin Name: Podcast Plugin
Plugin URI: https://github.com/unnikottamam/awesome-podcast
Description: Podcast Plugin from Unnikrishnan
Author: Unnikrishnan
Version: 1.0
Author URI: https://github.com/unnikottamam/
*/

if(!class_exists("PodcastPlugin")) {
    /**
     * class:   PodcastPlugin
     * desc:    plugin class to allow reports be pulled from multipe GA accounts
     */

    class PodcastPlugin {
        /**
         * Created an instance of the PodcastPlugin class
         */
        public function __construct() {
            
            define( 'YOUR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

            // Set up ACF
            add_filter('acf/settings/path', function() {
                return sprintf("%s/includes/advanced-custom-fields-pro/", dirname(__FILE__));
            });
            add_filter('acf/settings/dir', function() {
                return sprintf("%s/includes/advanced-custom-fields-pro/", plugin_dir_url(__FILE__));
            });
            require_once(sprintf("%s/includes/advanced-custom-fields-pro/acf.php", dirname(__FILE__)));

            // Image resize
            add_action( 'init', 'podcast_image_size' );
            function podcast_image_size() {
                add_image_size( 'podcast-small', 300, 310, true );
                add_image_size( 'podcast-main', 340, 340, true );
                add_image_size( 'podcast-thumb', 516, 290, true );
            }

            // Get Image id using image id
            function podcast_get_image_id($image_url) {
                global $wpdb;
                $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
                return $attachment[0]; 
            }

            // Settings managed via ACF
            require_once(sprintf("%s/includes/settings.php", dirname(__FILE__)));
            $settings = new PodcastPlugin_Settings(plugin_basename(__FILE__));

            // CPT for example post type
            require_once(sprintf("%s/includes/podcast-post-type.php", dirname(__FILE__)));
            $podcastposttype = new PodcastPlugin_PodcastPostType();

            $timestamp_token = date('Ymdhs');
            function podcast_styles_scripts() {
                wp_register_style( 'podcast-styles', plugins_url('resources/css/styles.css',__FILE__ ) );
                wp_enqueue_style( 'podcast-styles' );
                wp_register_style( 'font-awesome-styles', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css' );
                wp_enqueue_style( 'font-awesome-styles' );
                wp_enqueue_script( 'podcast-jquery-library', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array( 'jquery' ) );
                wp_enqueue_script( 'podcast-main', plugins_url('resources/js/main.js',__FILE__ ) , array( 'jquery' ) );
            }
            add_action('wp_enqueue_scripts', 'podcast_styles_scripts');

            // Template parts loader
            // Usage : $template_loader = new PW_Template_Loader;
            if( ! class_exists( 'Gamajo_Template_Loader' ) ) {
                require YOUR_PLUGIN_DIR . '/includes/class-gamajo-template-loader.php';
            }
            require YOUR_PLUGIN_DIR . '/includes/class-pw-template-loader.php';

            // Create Single podcast template
            add_filter('single_template', 'podcast_single_template');
            function podcast_single_template($single) {
                global $post;
                if ( $post->post_type == 'episodes' ) {
                    if ( file_exists( plugin_dir_path( __FILE__ ) . '/templates/single-podcast.php' ) ) {
                        return plugin_dir_path( __FILE__ ) . '/templates/single-podcast.php';
                    }
                }
                return $single;
            }

            // Create Taxonomy podcast template
            add_filter('template_include', 'podcast_taxonomy_template');
            function podcast_taxonomy_template( $template ) {
                if( is_tax('podcast-category') && !podcast_taxonomy_is_template($template) )
                    $template = plugin_dir_path(__FILE__ ).'/templates/podcast-category.php';
                return $template;
            }

            function podcast_taxonomy_is_template( $template_path ) {
                $template = basename($template_path);
                if( 1 == preg_match('/^podcast-category((-(\S*))?).php/',$template) )
                    return true;
                return false;
            }

            // Shortcodes
            function awesome_all_episodes() {
                $episodes = new PW_Template_Loader;
                ob_start();
                $episodes->get_template_part( 'template', 'episodes' );
                return ob_get_clean();

            }
            add_shortcode( 'awesome-all-episodes', 'awesome_all_episodes' );

            function awesome_podcast_main($atts) {
                $podcast_main = new PW_Template_Loader;
                ob_start();
                $podcast_main->get_template_part( 'template', 'podcast' );
                return ob_get_clean();
            }
            add_shortcode('awesome-podcast-home', 'awesome_podcast_main');

            // Add Player to footer
            add_action('wp_footer', 'add_podcast_player');
            function add_podcast_player() {
                if(!get_field('hide_podcast_player_bar', 'options')) {
                    $player_btm = new PW_Template_Loader;
                    echo $player_btm->get_template_part( 'content', 'playerbtm' );
                }
            }

            // Add class when player enable
            add_filter( 'body_class', function( $classes ) {
                if(!get_field('hide_podcast_player_bar', 'options')) 
                    return array_merge( $classes, array( 'player_enabled' ) );
                else
                    return array_merge( $classes, array( 'player_disabled' ) );
            } );
        } // END public function __construct()

        /**
         * Hook into the WordPress activate hook
         */
        public static function activate() {
            // Do something
        }

        /**
         * Hook into the WordPress deactivate hook
         */
        public static function deactivate() {
            // Do something
        }
    } // END class PodcastPlugin
} // END if(!class_exists("PodcastPlugin"))

if(class_exists('PodcastPlugin')) {    
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('PodcastPlugin', 'activate'));
    register_deactivation_hook(__FILE__, array('PodcastPlugin', 'deactivate'));
    
    // instantiate the plugin class
    $plugin = new PodcastPlugin();
} // END if(class_exists('PodcastPlugin'))