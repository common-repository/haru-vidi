<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if( ! class_exists( 'Haru_Vidi_Libraries' ) ) {
    class Haru_Vidi_Libraries {
        static $instance;

        public function __construct() {
            $this->haru_vidi_includes_files();
        }

        public function haru_vidi_includes_files() {
            if ( file_exists( WP_PLUGIN_DIR . '/cmb2/init.php' ) && !defined( 'CMB2_LOADED') ) {
                require_once WP_PLUGIN_DIR . '/cmb2/init.php';
            } else {
                require_once PLUGIN_HARU_VIDI_DIR . '/includes/libraries/cmb2/init.php';
            }

            if ( defined( 'CMB2_LOADED') ) {
                require_once PLUGIN_HARU_VIDI_DIR . '/includes/libraries/cmb2-conditionals/cmb2-conditionals.php';
                require_once PLUGIN_HARU_VIDI_DIR . '/includes/libraries/cmb2-attached-posts/cmb2-attached-posts-field.php';
                require_once PLUGIN_HARU_VIDI_DIR . '/includes/libraries/cmb2-radio-image/cmb2-radio-image.php';
                require_once PLUGIN_HARU_VIDI_DIR . '/includes/libraries/cmb2-switch-button/cmb2-switch-button.php';
                require_once PLUGIN_HARU_VIDI_DIR . '/includes/libraries/cmb-field-select2/cmb-field-select2.php';
                require_once PLUGIN_HARU_VIDI_DIR . '/includes/libraries/cmb2-text-list/cmb2-text-list.php';
            }
            
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/libraries/vidi-metabox-cpt.php' );
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/libraries/vidi-metabox-custom-taxonomy.php' );
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/libraries/vidi-metabox-shortcode.php' );
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/libraries/vidi-settings.php' );
        }
    }

    $haru_vidi = new Haru_Vidi_Libraries;
}