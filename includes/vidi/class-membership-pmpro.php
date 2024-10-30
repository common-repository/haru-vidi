<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( ! class_exists( 'Haru_Vidi_Membership_PMPro' ) ) {
    class Haru_Vidi_Membership_PMPro {

        public function __construct() {

            add_action( 'admin_menu', array( $this, 'haru_register_membership_settings' ), 20 );
            add_action( 'admin_init', array( $this, 'haru_custom_membership_functions' ) );

            if ( is_admin() ) {
                // Do something
            }
        }

        public function haru_register_membership_settings() {
            // Duplicate this row for each CPT. This one adds the meta boxes to 'haru_video' CPTs.
            add_meta_box('pmpro_page_meta', esc_html__( 'Require Membership', 'haru-vidi' ), 'pmpro_page_meta', 'haru_video', 'side', 'high' );
        }

        public function haru_custom_membership_functions() {
            /**
             * Initiate the metabox
             */
            
        }
    }

    new Haru_Vidi_Membership_PMPro;
}

if ( !function_exists( 'haru_get_pmpro_page_meta' ) ) {
    function haru_get_pmpro_page_meta() {
        global $post, $wpdb;

        $membership_levels = pmpro_getAllLevels(true, true);
        $page_levels = $wpdb->get_col("SELECT membership_id FROM {$wpdb->pmpro_memberships_pages} WHERE page_id = '{$post->ID}'");

        $return = array();
        foreach ( $membership_levels as $level ) {
            if ( in_array( $level->id, $page_levels ) ) {
                $return[] = $level;
            }
        }

        return $return;
    }
}

if ( !function_exists( 'haru_get_pmpro_video_access' ) ) {
    function haru_get_pmpro_video_access( $page_levels, $user_levels ) {
        if ( empty( $page_levels ) ) {
            return true;
        }

        if ( ! $user_levels ) {
            return false;
        }

        foreach( $page_levels as $level ) {
            $page_ids[] = $level->id;
        }

        foreach ( $user_levels as $user_level ) {
            $user_ids[] = $user_level->id;
        }

        if ( array_intersect( $page_ids, $user_ids ) ) {
            return true;
        } else {
            return false;
        }
    }
}

if ( !function_exists( 'haru_get_pmpro_video_taxonomy_access' ) ) {
    function haru_get_pmpro_video_taxonomy_access( $taxonomy_levels, $user_levels ) {
        if ( empty( $taxonomy_levels ) ) {
            return true;
        }

        if ( ! $user_levels ) {
            return false;
        }

        foreach( $taxonomy_levels as $level ) {
            $taxonomy_ids[] = $level;
        }

        foreach ( $user_levels as $user_level ) {
            $user_ids[] = $user_level->id;
        }

        if ( array_intersect( $taxonomy_ids, $user_ids ) ) {
            return true;
        } else {
            return false;
        }
    }
}

if ( !function_exists( 'haru_get_pmpro_taxonomy_meta' ) ) {
    function haru_get_pmpro_taxonomy_meta() {
        $return = array();

        $custom_taxterms = wp_get_object_terms( get_the_ID(), 'video_category', array( 'fields' => 'ids' ) );

        foreach ( $custom_taxterms as $custom_tax ) {
            $taxonomy_levels = get_term_meta( $custom_tax, 'haru_video_category_pmpro_levels', true );

            if ( !is_array( $taxonomy_levels ) ) {
                return $return;
            }

            foreach ( $taxonomy_levels as $level ) {
                if ( !in_array( $level, $return ) ) {
                    $return[] = $level;
                }
            }
        }

        return $return;
    }
}

if ( !function_exists( 'haru_get_pmpro_category_levels' ) ) {
    function haru_get_pmpro_category_levels() {
        $return = array();

        $member_settings_levels = haru_vidi_get_setting( 'vidi-member-settings', 'haru_member_pmpro_levels_group', '' );

        $taxonomies = get_terms( 'video_category', array(
                                    'hide_empty' => false,
                                ) );

        $pmpro_taxonomy = array();
        foreach ( $taxonomies as $taxonomy ) {
            foreach ( $member_settings_levels as $settings_level ) {
                if ( isset( $settings_level['haru_member_pmpro_level_categories'] ) && !empty( $settings_level['haru_member_pmpro_level_categories'] ) ) {
                    if ( in_array($taxonomy->slug, $settings_level['haru_member_pmpro_level_categories']) ) {
                        $pmpro_taxonomy[$taxonomy->slug][] = $settings_level['haru_member_pmpro_level']; 
                    }
                }
            }
        }

        $custom_taxterms = wp_get_object_terms( get_the_ID(), 'video_category', array( 'fields' => 'ids' ) );
        $category_levels = array();
        foreach ( $custom_taxterms as $custom_tax ) {
            $term = get_term_by('id', $custom_tax, 'video_category');

            if ( isset( $pmpro_taxonomy[$term->slug] ) ) {
                $category_levels = $pmpro_taxonomy[$term->slug];
            }

            foreach ( $category_levels as $level ) {
                if ( !in_array( $level, $return ) ) {
                    $return[] = $level;
                }
            }
        }

        return $return;
    }
}

if ( !function_exists( 'haru_get_pmpro_video_category_access' ) ) {
    function haru_get_pmpro_video_category_access( $category_levels, $user_levels ) {
        if ( empty( $category_levels ) ) {
            return true;
        }

        if ( ! $user_levels ) {
            return false;
        }

        foreach( $category_levels as $level ) {
            $category_ids[] = $level;
        }

        foreach ( $user_levels as $user_level ) {
            $user_ids[] = $user_level->id;
        }

        if ( array_intersect( $category_ids, $user_ids ) ) {
            return true;
        } else {
            return false;
        }
    }
}

if ( !function_exists( 'haru_get_url_of_page_with_id' ) ) {
    function haru_get_url_of_page_with_id( $page_id ) {
        return get_permalink( $page_id );
    }

    add_action( 'after_setup_theme', 'haru_get_url_of_page_with_id' );
}
