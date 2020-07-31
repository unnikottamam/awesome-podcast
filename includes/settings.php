<?php
if(!class_exists('PodcastPlugin_Settings')) {
	class PodcastPlugin_Settings {
		const SLUG = "podcast-plugin-options";

        /**
         * Construct the plugin object
         */
        public function __construct($plugin) {
            // register actions
        	acf_add_options_page(array(
        		'page_title' => __('Podcast Plugin'),
        		'menu_title' => __('Podcast Plugin'),
        		'menu_slug' => self::SLUG,
        		'capability' => 'manage_options',
        		'redirect' => false
        	));

        	add_action('init', array(&$this, "init"));
        	add_action('admin_menu', array(&$this, 'admin_menu'), 20);
        	add_filter("plugin_action_links_$plugin", array(&$this, 'plugin_settings_link'));
        } // END public function __construct
        
        /**
         * Add options page
         */
        public function admin_menu() {
            // Duplicate link into properties mgmt
        	add_submenu_page(
        		self::SLUG,
        		__('Settings'),
        		__('Settings'),
        		'manage_options',
        		self::SLUG,
        		1
        	);
        }

        /**
         * Add settings fields via ACF
         */
        public function init() {
        	if( function_exists('acf_add_local_field_group') ) {

                acf_add_local_field_group(array(
                    'key' => 'group_5ee94d2948740',
                    'title' => 'Podcast options',
                    'fields' => array(
                        array(
                            'key' => 'field_5ecc54b234178',
                            'label' => 'All episodes page',
                            'name' => 'all_episodes_page',
                            'type' => 'page_link',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
                                'class' => '',
                                'id' => '',
                            ),
                            'post_type' => array(
                                0 => 'page',
                            ),
                            'taxonomy' => '',
                            'allow_null' => 0,
                            'allow_archives' => 1,
                            'multiple' => 0,
                        ),
                        array(
                            'key' => 'field_5ee94d63fd8a0',
                            'label' => 'All Podcast Button',
                            'name' => 'all_podcast_button',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '50',
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
                            'key' => 'field_5ee94d86fd8a1',
                            'label' => 'Hide Podcast Player Bar?',
                            'name' => 'hide_podcast_player_bar',
                            'type' => 'true_false',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'message' => '',
                            'default_value' => 0,
                            'ui' => 0,
                            'ui_on_text' => '',
                            'ui_off_text' => '',
                        ),
                    ),
                    'location' => array(
                        array(
                            array(
                                'param' => 'options_page',
                                'operator' => '==',
                                'value' => self::SLUG,
                            ),
                        ),
                    ),
                    'menu_order' => 0,
                    'position' => 'normal',
                    'style' => 'default',
                    'label_placement' => 'top',
                    'instruction_placement' => 'label',
                    'hide_on_screen' => '',
                    'active' => true,
                    'description' => '',
                ));

            }
		}

        /**
         * Add the settings link to the plugins page
         */
        public function plugin_settings_link($links) { 
        	$settings_link = sprintf('<a href="admin.php?page=%s">Settings</a>', self::SLUG); 
        	array_unshift($links, $settings_link); 
        	return $links; 
        } // END public function plugin_settings_link($links)
    } // END class PodcastPlugin_Settings
} // END if(!class_exists('PodcastPlugin_Settings'))