<?php
/**
 * Add a Custom Post Type: podcast
 */
if(!class_exists('PodcastPlugin_PodcastPostType')) {
	class PodcastPlugin_PodcastPostType {
		const SLUG = "episodes";

        /**
         * Construct the custom post type for Reports
         */
        public function __construct() {
            // register actions
        	add_action('init', array(&$this, 'init'));
        } // END public function __construct()
        
        /**
         * Hook into the init action
         */
        public function init() {
            // Register the Analytics Report post type
        	register_post_type(self::SLUG,
        		array(
        			'labels' => array(
        				'name' => __(sprintf('%s', ucwords(str_replace("_", " ", self::SLUG))), 'custom'),
        				'singular_name' => __(ucwords(str_replace("_", " ", self::SLUG)), 'custom')
        			),
                    'menu_icon' => 'dashicons-microphone',
        			'description' => __("Podcast post type", 'custom'),
        			'supports' => array(
        				'title',
        			),
        			'public' => true,
        			'show_ui' => true,
        			'has_archive' => true,
        		)
        	);

            $labels = [
                'name'              => _x('Category', 'taxonomy general name'),
                'singular_name'     => _x('Category', 'taxonomy singular name'),
                'search_items'      => __('Search Courses'),
                'all_items'         => __('All Courses'),
                'parent_item'       => __('Parent Category'),
                'parent_item_colon' => __('Parent Category:'),
                'edit_item'         => __('Edit Category'),
                'update_item'       => __('Update Category'),
                'add_new_item'      => __('Add New Category'),
                'new_item_name'     => __('New Category Name'),
                'menu_name'         => __('Category'),
            ];
            $args = [
                'hierarchical'      => true,
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => ['slug' => 'podcast-category'],
            ];
            register_taxonomy('podcast-category', [self::SLUG], $args);

        	if( function_exists('acf_add_local_field_group') ) {

                acf_add_local_field_group(array(
                    'key' => 'group_5bea7a0b32a89',
                    'title' => 'Episodes Fields',
                    'fields' => array(
                        array(
                            'key' => 'field_5c1dc32028dc7',
                            'label' => 'Guest Full Name',
                            'name' => 'guest_full_name',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => 'John Doe',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5c5273e26ab7c',
                            'label' => 'Guest Position Name',
                            'name' => 'guest_position_name',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => 'CEO, CTO, CIO, Founder',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5c1dc3c628dc8',
                            'label' => 'Guest Company',
                            'name' => 'guest_company',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => 'Acme Inc',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5c1dc3d728dc9',
                            'label' => 'Guest Company URL',
                            'name' => 'guest_company_url',
                            'type' => 'text',
                            'instructions' => 'This field has been disabled from this layout; however, if activated it augments SEO efforts through backlinking.',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => 'https://www.website.com',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5c1dc3e728dca',
                            'label' => 'Guest Photograph',
                            'name' => 'guest_photograph',
                            'type' => 'image',
                            'instructions' => 'The main image that will be used within an episode page, we recommend to use profile photos where the subject\'s head is at the center of the image. Keep dimensions to at least a 4:3 aspect ratio, to prevent distortion.',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'url',
                            'preview_size' => 'thumbnail',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                        array(
                            'key' => 'field_5c1dc3fc28dcb',
                            'label' => 'Guest Thumbnail Photograph',
                            'name' => 'guest_thumbnail_photograph',
                            'type' => 'image',
                            'instructions' => 'This image is used for thumbnail purposes. Dimensions should be at minimum   765x429 , cropping will occur automatically to handle mis-shaped images.',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'url',
                            'preview_size' => 'thumbnail',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                        ),
                        array(
                            'key' => 'field_5ecc482ceb606',
                            'label' => 'Short Description',
                            'name' => 'short_description',
                            'type' => 'textarea',
                            'instructions' => 'Displayed on homepage or when the user browses a collection of episodes, such as the homepage(   latest episodes section) , the search results page or the archive/tags pages.',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'maxlength' => '',
                            'rows' => 4,
                            'new_lines' => '',
                        ),
                        array(
                            'key' => 'field_5ecc4841eb607',
                            'label' => 'Long Description',
                            'name' => 'long_description',
                            'type' => 'textarea',
                            'instructions' => 'Keep this description at paragraph length. It is displayed on Episode pages, Featured Episode section, and episode player.',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'maxlength' => '',
                            'rows' => 4,
                            'new_lines' => '',
                        ),
                        array(
                            'key' => 'field_5c6310b1063f1',
                            'label' => 'Podcast links',
                            'name' => 'podcast_links',
                            'type' => 'repeater',
                            'instructions' => 'Define which podcast outlets:    Google Play, Spotify, ITunes Music, this episode can be listened on.',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'collapsed' => '',
                            'min' => 0,
                            'max' => 0,
                            'layout' => 'table',
                            'button_label' => '',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_5c74c34e3afa3',
                                    'label' => 'Select Icon',
                                    'name' => 'select_icon',
                                    'type' => 'select',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'choices' => array(
                                        0 => 'Select Image',
                                        1 => 'Apple Podcasts',
                                        2 => 'Google Play Music',
                                        3 => 'Spotify',
                                    ),
                                    'default_value' => false,
                                    'allow_null' => 0,
                                    'multiple' => 0,
                                    'ui' => 0,
                                    'return_format' => 'value',
                                    'ajax' => 0,
                                    'placeholder' => '',
                                ),
                                array(
                                    'key' => 'field_5c631a1ce9539',
                                    'label' => 'Icon',
                                    'name' => 'icon',
                                    'type' => 'image',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => array(
                                        array(
                                            array(
                                                'field' => 'field_5c74c34e3afa3',
                                                'operator' => '==',
                                                'value' => '0',
                                            ),
                                        ),
                                    ),
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'return_format' => 'url',
                                    'preview_size' => 'thumbnail',
                                    'library' => 'all',
                                    'min_width' => '',
                                    'min_height' => '',
                                    'min_size' => '',
                                    'max_width' => '',
                                    'max_height' => '',
                                    'max_size' => '',
                                    'mime_types' => '',
                                ),
                                array(
                                    'key' => 'field_5c631a32e953b',
                                    'label' => 'URL',
                                    'name' => 'url',
                                    'type' => 'text',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'maxlength' => '',
                                ),
                            ),
                        ),
                        array(
                            'key' => 'field_5bea7a296322d',
                            'label' => 'Episode Number',
                            'name' => 'episode_number',
                            'type' => 'text',
                            'instructions' => 'Assists the user with finding particular episodes for your podcast.',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '10',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5c1dc4ab453fa',
                            'label' => 'Date Released',
                            'name' => 'date_released',
                            'type' => 'date_picker',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '20',
                                'class' => '',
                                'id' => '',
                            ),
                            'display_format' => 'm/d/Y',
                            'return_format' => 'm/d/Y',
                            'first_day' => 1,
                        ),
                        array(
                            'key' => 'field_5c1dc4c1453fb',
                            'label' => 'Episode Podcast URL',
                            'name' => 'episode_podcast_url',
                            'type' => 'text',
                            'instructions' => 'This must be a direct link to a podcast episode file, either in mp3 or m4a formats.',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '20',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => 'http://....',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5bea7a6263230',
                            'label' => 'Download URL',
                            'name' => 'download',
                            'type' => 'text',
                            'instructions' => 'Serves as a backup source for acquiring episode files.',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '20',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => 'http://....',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5c1dc2e428dc6',
                            'label' => 'Sonix ID',
                            'name' => 'sonix_id',
                            'type' => 'text',
                            'instructions' => 'Disabled field; serves as the source of transcript for episodes.',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '20',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '(i.e. jeQ9KAcToT2mz11g3ebZYLxq )',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5ecea1a2eb064',
                            'label' => 'Podcast Notes Title',
                            'name' => 'podcast_notes_title',
                            'type' => 'text',
                            'instructions' => 'We recommend to use the default title, but you can also change it on a per episode basis.',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '100',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => 'Episode Notes',
                            'placeholder' => 'Episode Notes',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5c1dc40f28dcc',
                            'label' => 'Podcast Notes',
                            'name' => 'podcast_notes',
                            'type' => 'wysiwyg',
                            'instructions' => 'Additional notes relating to your podcast should be added here. This includes, but is not limited to recommended books, articles, journals, or other resources that were discussed during the podcast. Having these available keeps your users engaged, and validates the subject matter expert interviewed in episode.',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '100',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'tabs' => 'all',
                            'toolbar' => 'full',
                            'media_upload' => 1,
                            'delay' => 0,
                        ),
                        array(
                            'key' => 'field_5c1dc44228dce',
                            'label' => 'Transcript',
                            'name' => 'transcript',
                            'type' => 'textarea',
                            'instructions' => 'Optional, but recommended text transcript for both SEO and accessibility purposes.',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'maxlength' => '',
                            'rows' => 10,
                            'new_lines' => '',
                        ),
                        array(
                            'key' => 'field_5c5175538f0b4',
                            'label' => 'CTA Subscribe',
                            'name' => 'cta_subscribe',
                            'type' => 'group',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '100',
                                'class' => '',
                                'id' => '',
                            ),
                            'layout' => 'block',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_5c5176378f0b7',
                                    'label' => 'Title',
                                    'name' => 'title',
                                    'type' => 'text',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => 'Get the latest in your inbox',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'maxlength' => '',
                                ),
                                array(
                                    'key' => 'field_5c5176468f0b8',
                                    'label' => 'BG Color',
                                    'name' => 'bg_color',
                                    'type' => 'color_picker',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '33',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '#2049e6',
                                ),
                                array(
                                    'key' => 'field_5c5176968f0b9',
                                    'label' => 'BG Image',
                                    'name' => 'bg_image',
                                    'type' => 'image',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '33',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'return_format' => 'url',
                                    'preview_size' => 'thumbnail',
                                    'library' => 'all',
                                    'min_width' => '',
                                    'min_height' => '',
                                    'min_size' => '',
                                    'max_width' => '',
                                    'max_height' => '',
                                    'max_size' => '',
                                    'mime_types' => '',
                                ),
                                array(
                                    'key' => 'field_5c5176a78f0ba',
                                    'label' => 'Text Color',
                                    'name' => 'text_color',
                                    'type' => 'select',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '33',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'choices' => array(
                                        'light_text' => 'Light',
                                        'dark_text' => 'Dark',
                                    ),
                                    'default_value' => false,
                                    'allow_null' => 0,
                                    'multiple' => 0,
                                    'ui' => 0,
                                    'ajax' => 0,
                                    'return_format' => 'value',
                                    'placeholder' => '',
                                ),
                                array(
                                    'key' => 'field_5c9b125885488',
                                    'label' => 'Form Short code',
                                    'name' => 'form_short_code',
                                    'type' => 'text',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '50',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '[gravityform id="2" title="true" description="true"]',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'maxlength' => '',
                                ),
                            ),
                        ),
                        array(
                            'key' => 'field_5ee271b69f2da',
                            'label' => 'Categories',
                            'name' => 'categories',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => 'hidden',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5ee273da9f2db',
                            'label' => 'Tags',
                            'name' => 'tags',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => 'hidden',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                    ), 'location' => array(
                        array(
                            array(
                                'param' => 'post_type',
                                'operator' => '==',
                                'value' => self::SLUG,
                            ),
                        ),
                    ),
                    'menu_order' => 0,
                    'position' => 'acf_after_title',
                    'style' => 'default',
                    'label_placement' => 'top',
                    'instruction_placement' => 'label',
                    'hide_on_screen' => '',
                    'active' => true,
                    'description' => '',
                ));

            }

            add_action('acf/save_post', 'my_acf_save_post');
            function my_acf_save_post( $post_id ) {
                $post_cats = array();
                $output = "";
                $terms = get_the_terms( $post_id, 'podcast-category' );
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                    foreach ( $terms as $term ) {
                        $post_cats[] = $term->name;
                    }
                    $output = join( ", ", $post_cats );
                }
                update_field( 'categories', $output, $post_id );
            }

            add_action( 'pre_get_posts', function( $q ) {
                if( $title = $q->get( '_meta_or_title' ) ) {
                    add_filter( 'get_meta_sql', function( $sql ) use ( $title ) {
                        global $wpdb;
                        static $nr = 0; 
                        if( 0 != $nr++ ) return $sql;
                        $sql['where'] = sprintf(
                            " AND ( %s OR %s ) ",
                            $wpdb->prepare( "{$wpdb->posts}.post_title like '%%%s%%'", $title),
                            mb_substr( $sql['where'], 5, mb_strlen( $sql['where'] ) )
                        );
                        return $sql;
                    });
                }
            });
        } // END public function init()
    } // END class PodcastPlugin_PodcastPostType
} // END if(!class_exists('PodcastPlugin_PodcastPostType'))