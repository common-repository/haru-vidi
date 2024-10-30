<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */

// Channel Submit
if ( !function_exists( 'haru_vidi_field_metaboxes_custom_taxonomy' ) ) {
    function haru_vidi_field_metaboxes_custom_taxonomy() {
        /**
         * Metabox to add fields to categories and tags
         */
        $video_taxonomy_meta = new_cmb2_box( array(
            'id'               => 'haru_video_category' . '_edit',
            'title'            => esc_html__( 'Video Category Metabox', 'haru-vidi' ), // Doesn't output for term boxes
            'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
            'taxonomies'       => array( 'video_category' ), // Tells CMB2 which taxonomies should have these fields
        ) );

        // Other
    }

    add_action( 'cmb2_admin_init', 'haru_vidi_field_metaboxes_custom_taxonomy' );
}

function haru_vidi_get_pmpro_list_levels() {
    $return = array();

    $pmpro_levels = pmpro_getAllLevels(false, true);

    if ( empty( $pmpro_levels ) ) {
        return $return;
    }

    foreach ( $pmpro_levels as $level ) {
        $return[$level->id] = $level->name;
    }

    return $return;
}
