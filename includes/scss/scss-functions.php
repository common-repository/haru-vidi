<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

require_once( PLUGIN_HARU_VIDI_DIR . 'includes/scss/scssphp/scss.inc.php' );
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\Server;
use ScssPhp\ScssPhp\Parser;
use ScssPhp\ScssPhp\Version;

if ( ! function_exists( 'haru_color_settings_save_function' ) ) {
    function haru_color_settings_save_function( $object_id, $updated, $cmb ) {
        if ( $object_id == 'vidi-appearance-settings' ) {
            try {
                if ( ! defined( 'FS_METHOD' ) ) {
                    define('FS_METHOD', 'direct');
                }

                $scss_variables                          = array();
                $scss_variables['primary_color']         = haru_vidi_get_setting( 'vidi-appearance-settings', 'haru_color_primary', '#fe2854' );
                $scss_variables['heading_color']         = haru_vidi_get_setting( 'vidi-appearance-settings', 'haru_color_heading', '#2c272d' );
                $scss_variables['text_color']            = haru_vidi_get_setting( 'vidi-appearance-settings', 'haru_color_text', '#6d5f6f' );
                $scss_variables['text_color_secondary']  = haru_vidi_get_setting( 'vidi-appearance-settings', 'haru_color_text_secondary', '#aba4ac' );
                $scss_variables['border_color']          = haru_vidi_get_setting( 'vidi-appearance-settings', 'haru_color_border', '#ededed' );
                $scss_variables['cl_black']              = haru_vidi_get_setting( 'vidi-appearance-settings', 'haru_color_black', '#1a051d' );
                $scss_variables['cl_gray']               = haru_vidi_get_setting( 'vidi-appearance-settings', 'haru_color_gray', '#6d5f6f' );
                $scss_variables['border_radius']         = haru_vidi_get_setting( 'vidi-appearance-settings', 'haru_scss_border_radius', '4px' );
                $scss_variables['border_radius_small']   = haru_vidi_get_setting( 'vidi-appearance-settings', 'haru_scss_border_radius_small', '3px' );
                $scss_variables['border_radius_tiny']    = haru_vidi_get_setting( 'vidi-appearance-settings', 'haru_scss_border_radius_tiny', '2px' );

                $scss = new Compiler();

                $scss->setImportPaths( PLUGIN_HARU_VIDI_DIR . 'assets/sass/' );
                // Preset Variables
                $scss->setVariables( $scss_variables );
                $css = $scss->compile('@import "style.scss";');

                require_once ABSPATH . 'wp-admin/includes/file.php';
                WP_Filesystem();
                global $wp_filesystem;

                if ( !$wp_filesystem->put_contents( PLUGIN_HARU_VIDI_DIR . "assets/css/style-custom.min.css", $css, FS_CHMOD_FILE) ) {
                    return array(
                        'status'  => 'error',
                        'message' => esc_html__( 'Could not save file! Please check your Server Permissions.', 'haru-vidi' )
                    );
                }
            } catch( Exception $e ) {
                $error_message = $e->getMessage();

                return array(
                    'status'  => 'error',
                    'message' => $error_message
                );
            }
        }
    }

    add_action( 'cmb2_save_options-page_fields', 'haru_color_settings_save_function', 10, 3 );

}