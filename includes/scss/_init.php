<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( ! class_exists( 'Haru_SCSSPHP_Helper' ) ) {
    class Haru_SCSSPHP_Helper {
        static $instance;

        public function __construct() {
            $this->haru_vidi_includes_files();
        }

        public function haru_vidi_includes_files() {
            require_once( PLUGIN_HARU_VIDI_DIR . 'includes/scss/scss-functions.php' );
        }
    }

    $haru_vidi = new Haru_SCSSPHP_Helper;
}