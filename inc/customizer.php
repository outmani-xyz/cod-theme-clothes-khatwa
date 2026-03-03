<?php

/**
 * Customizer Singleton Class
 *
 * @package khutwa
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (! class_exists('Customizer')) {

    class Customizer
    {
        /**
         * The single instance of the class.
         *
         * @var Customizer
         */
        private static $instance = null;

        /**
         * Main Customizer Instance.
         *
         * Ensures only one instance of Customizer is loaded or can be loaded.
         *
         * @return Customizer - Main instance.
         */
        public static function instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
                self::$instance->setup();
            }
            return self::$instance;
        }

        /**
         * Setup hooks and functions.
         */
        public function setup()
        {
            add_action('customize_register', array($this, 'register'));
        }

        /**
         * Register Customizer settings.
         *
         * @param WP_Customize_Manager $wp_customize Theme Customizer object.
         */
        public function register($wp_customize)
        {
            // Note: Site Title & Tagline, and Site Logo are native WP settings
            // Title & Tagline: Section 'title_tagline', Settings 'blogname', 'blogdescription'
            // Logo: Section 'title_tagline', Setting 'custom_logo'

            // ==========================================
            // Section: Social Media
            // ==========================================
            $wp_customize->add_section(
                'khutwa_social_media',
                array(
                    'title'    => __('Social Media Links', 'khutwa'),
                    'priority' => 30,
                )
            );

            // Setting: Facebook
            $wp_customize->add_setting(
                'social_facebook',
                array(
                    'default'           => '',
                    'sanitize_callback' => 'esc_url_raw',
                )
            );
            $wp_customize->add_control(
                'social_facebook',
                array(
                    'label'   => __('Facebook URL', 'khutwa'),
                    'section' => 'khutwa_social_media',
                    'type'    => 'url',
                )
            );

            // Setting: Instagram
            $wp_customize->add_setting(
                'social_instagram',
                array(
                    'default'           => '',
                    'sanitize_callback' => 'esc_url_raw',
                )
            );
            $wp_customize->add_control(
                'social_instagram',
                array(
                    'label'   => __('Instagram URL', 'khutwa'),
                    'section' => 'khutwa_social_media',
                    'type'    => 'url',
                )
            );

            // Setting: TikTok
            $wp_customize->add_setting(
                'social_tiktok',
                array(
                    'default'           => '',
                    'sanitize_callback' => 'esc_url_raw',
                )
            );
            $wp_customize->add_control(
                'social_tiktok',
                array(
                    'label'   => __('TikTok URL', 'khutwa'),
                    'section' => 'khutwa_social_media',
                    'type'    => 'url',
                )
            );

            // ==========================================
            // Section: Testimonials
            // ==========================================
            $wp_customize->add_section(
                'khutwa_testimonials',
                array(
                    'title'    => __('Testimonials (Home Page)', 'khutwa'),
                    'priority' => 35,
                )
            );

            for ($i = 1; $i <= 3; $i++) {
                // Testimonial Text
                $wp_customize->add_setting(
                    "testimonial_{$i}_text",
                    array(
                        'default'           => $this->get_default_testimonial_text($i),
                        'sanitize_callback' => 'sanitize_textarea_field',
                    )
                );
                $wp_customize->add_control(
                    "testimonial_{$i}_text",
                    array(
                        'label'   => sprintf(__('Testimonial %d - Text', 'khutwa'), $i),
                        'section' => 'khutwa_testimonials',
                        'type'    => 'textarea',
                    )
                );

                // Testimonial Author
                $wp_customize->add_setting(
                    "testimonial_{$i}_author",
                    array(
                        'default'           => $this->get_default_testimonial_author($i),
                        'sanitize_callback' => 'sanitize_text_field',
                    )
                );
                $wp_customize->add_control(
                    "testimonial_{$i}_author",
                    array(
                        'label'   => sprintf(__('Testimonial %d - Author', 'khutwa'), $i),
                        'section' => 'khutwa_testimonials',
                        'type'    => 'text',
                    )
                );

                // Testimonial Location
                $wp_customize->add_setting(
                    "testimonial_{$i}_location",
                    array(
                        'default'           => $this->get_default_testimonial_location($i),
                        'sanitize_callback' => 'sanitize_text_field',
                    )
                );
                $wp_customize->add_control(
                    "testimonial_{$i}_location",
                    array(
                        'label'   => sprintf(__('Testimonial %d - Location', 'khutwa'), $i),
                        'section' => 'khutwa_testimonials',
                        'type'    => 'text',
                    )
                );
            }
        }

        /**
         * Get default text for testimonials.
         */
        private function get_default_testimonial_text($index)
        {
            $defaults = array(
                1 => __("The leather quality is exceptional. A babouche that combines comfort and elegance, I highly recommend!", 'khutwa'),
                2 => __("Fast and careful shipping. You can feel it's handmade with passion. I love my clogs.", 'khutwa'),
                3 => __("Minimalist and chic. It's exactly what I was looking for for my daily outfits.", 'khutwa'),
            );
            return isset($defaults[$index]) ? $defaults[$index] : '';
        }

        private function get_default_testimonial_author($index)
        {
            $defaults = array(
                1 => "Sarah B.",
                2 => "Mehdi A.",
                3 => "Imane T.",
            );
            return isset($defaults[$index]) ? $defaults[$index] : '';
        }

        private function get_default_testimonial_location($index)
        {
            $defaults = array(
                1 => "Casablanca",
                2 => "Rabat",
                3 => "Marrakech",
            );
            return isset($defaults[$index]) ? $defaults[$index] : '';
        }
    }
}

// Initialize the Customizer Singleton.
Customizer::instance();
