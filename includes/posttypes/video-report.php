<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( !defined('ABSPATH') ) die('-1');

if ( ! class_exists( 'Haru_Vidi_Video_Report_Post_Type' ) ) {
    class Haru_Vidi_Video_Report_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'haru_video_report';

            add_action( 'init', array( $this, 'haru_video_report' ), 5);
            add_action( 'save_post_haru_video_report', array( $this, 'haru_save_video_report' ) );

            if ( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                add_filter( 'manage_haru_video_report_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_haru_video_report_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }
        }

        function remove_plugin_metaboxes() {
            remove_meta_box( 'mymetabox_revslider_0', 'haru_video_report', 'normal' );
            remove_meta_box( 'handlediv', 'haru_video_report', 'normal' );
            remove_meta_box( 'commentsdiv', 'haru_video_report', 'normal' );
        }

        function haru_video_report() {
            $prefix = $this->prefix;

            $labels = array(
                'menu_name'          => esc_html__( 'Video Reports', 'haru-vidi' ),
                'singular_name'      => esc_html__( 'Single Video Report', 'haru-vidi' ),
                'name'               => esc_html__( 'Video Report', 'haru-vidi' ),
                'add_new'            => esc_html__( 'Add New', 'haru-vidi' ) ,
                'add_new_item'       => esc_html__( 'Add New Video Report', 'haru-vidi' ) ,
                'edit_item'          => esc_html__( 'Edit Video Report', 'haru-vidi' ) ,
                'new_item'           => esc_html__( 'Add New Video Report', 'haru-vidi' ) ,
                'view_item'          => esc_html__( 'View Video Report', 'haru-vidi' ) ,
                'search_items'       => esc_html__( 'Search Video Report', 'haru-vidi' ) ,
                'not_found'          => esc_html__( 'No Video Report items found', 'haru-vidi' ) ,
                'not_found_in_trash' => esc_html__( 'No Video Report items found in trash', 'haru-vidi' ) ,
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display Video Report', 'haru-vidi' ),
                'hierarchical'          => false,
                'public'                => false,
                'show_in_rest'          => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-flag',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'supports'              => array( 'title' ),
                'rewrite'           => array(
                    'slug'          => 'video-report', // use / to remove slug
                    'with_front'    => false
                ),
            );
            register_post_type( 'haru_video_report', $args );
        }

        // Add columns to Video Report
        function add_columns($columns) {
            unset(
                $columns['post-format'],
                $columns['title'],
                $columns['date']
            );
            $cols = array_merge(array('cb' => ('')), $columns);
            $cols = array_merge($cols, array('title' => esc_html__( 'Title', 'haru-vidi' )));
            $cols = array_merge($cols, array('content_report' => esc_html__( 'Content', 'haru-vidi' )));
            $cols = array_merge($cols, array('user_report' => esc_html__( 'User Report', 'haru-vidi' )));
            $cols = array_merge($cols, array('edit_video' => esc_html__( 'Edit Video', 'haru-vidi' )));
            $cols = array_merge($cols, array('date' => esc_html__( 'Date', 'haru-vidi' )));

            return $cols;
        }

        // Set values for columns
        function set_columns_value($column, $post_id) {
            $prefix = $this->prefix;
            $report_meta = explode('_', get_post_meta($post_id, 'haru_video_report_meta', true));

            switch ($column) {
                case 'id': {
                    echo wp_kses_post($post_id);
                    break;
                }

                case 'content_report': {
                    echo '<code class="report-content">' . get_post_meta($post_id, 'haru_video_report_content', true) . '</code>';
                    
                    break;
                }

                case 'user_report': {
                    if ( is_array($report_meta) ) {
                        $user_obj = get_user_by( 'id', $report_meta[1] );
                        echo esc_html__( 'User Name: ', 'haru-vidi') . '<strong>' . $user_obj->user_login . '</strong> | <a href="' . esc_url( get_edit_user_link( $user_obj->ID ) ) . '" target="_blank">'. esc_html__( 'View User', 'haru-vidi' ) . '</a>';
                    }
                    
                    break;
                }

                case 'edit_video': {
                    if ( is_array($report_meta) ) {
                        echo '<a href="' . esc_url( get_edit_post_link( $report_meta[0] ) ) . '" target="_blank">Edit Video</a> | <a href="' . esc_url( get_permalink( $report_meta[0] ) ).'" target="_blank">View Video</a>';
                    }

                    break;
                }
            }
        }

        // Save video
        function haru_save_video_report() {
            global $post;

            if ( !empty($post) && !empty($_POST) ) {
                
            }
        }
    }

    new Haru_Vidi_Video_Report_Post_Type;
}