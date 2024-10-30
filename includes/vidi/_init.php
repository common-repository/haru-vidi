<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if( ! class_exists( 'Haru_Vidi_Helper' ) ) {
    class Haru_Vidi_Helper {
        static $instance;

        public function __construct() {
            $this->haru_vidi_includes_files();
        }

        public function haru_vidi_includes_files() {
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/vidi/vidi-functions.php' );
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/vidi/buddypress-functions.php' );
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/vidi/author-functions.php' );
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/vidi/mycred-functions.php' );
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/vidi/vidi-hooks.php' );
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/vidi/vidi-shortcodes.php' );
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/vidi/vidi-ajax-actions.php' );
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/vidi/class-rating-system.php' );
            // Membership
            // PaidMembershipPro
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/vidi/class-membership-pmpro.php' );
        }
    }

    $haru_vidi = new Haru_Vidi_Helper;
}