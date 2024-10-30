<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if( ! class_exists( 'Haru_Vidi_Posttypes' ) ) {
	class Haru_Vidi_Posttypes {
		static $instance;

		public static function init() {
			if ( !isset(self::$instance) ) {
				self::$instance = new Haru_Vidi_Posttypes;

				add_action( 'init', array( self::$instance, 'includes' ), 0 );
				add_filter( 'template_include', array( self::$instance, 'haru_author_page' ), 100 );

				// Add Settings -> Permalink: 
				// https://wordpress.stackexchange.com/questions/129180/add-multiple-custom-fields-to-the-general-settings-page
				// https://wordpress.stackexchange.com/questions/30021/theme-localization-of-slugs-custom-post-types-taxonomies
				add_action( 'admin_init', array( self::$instance, 'haru_permalink_settings_section' ), 0 );
			}

			return self::$instance;
		}

		public function haru_permalink_settings_section() {  
		    add_settings_section(  
		        'haru_settings_vidi', // Section ID 
		        esc_html__( 'Vidi permalinks slug', 'haru-vidi' ), // Section Title
		        array( self::$instance, 'haru_section_options_callback' ), // Callback
		        'permalink' // What Page?  This makes the section show up on the Permalink Settings Page
		    );
		}

		public function haru_section_options_callback() { // Section Callback
		    echo '<p>If you like, you may enter custom structures for your video, category and tag,... URLs here. For example, using <code>videos</code> as your custom posttype base would make your custom posttype archive link like <code>' . get_site_url() . '/videos/</code>. If you leave these blank the defaults will be used.</p>';
		}

		public function includes() {
			// Vidi
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/posttypes/video.php');
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/posttypes/video-report.php');
            // require_once( PLUGIN_HARU_VIDI_DIR . 'includes/posttypes/advertising.php');
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/posttypes/actor.php');
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/posttypes/director.php');
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/posttypes/playlist.php');
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/posttypes/series.php');
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/posttypes/channel.php');
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/posttypes/shortcode-generate.php');
		}

		public function haru_author_page( $template_path ) {
			if ( is_author() ) {
				$template_path = haru_vidi_posttype_get_template('vidi/author/'. 'single-author' . '.php', array(), '', '');
			}

			return $template_path;
		}
	}

	if ( ! function_exists('init_haru_vidi_framework_posttypes') ) {
        function init_haru_vidi_framework_posttypes() {
            return Haru_Vidi_Posttypes::init();
        }

        init_haru_vidi_framework_posttypes();
    }
}