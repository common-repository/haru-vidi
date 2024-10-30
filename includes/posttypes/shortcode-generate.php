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

if ( ! class_exists( 'Haru_Vidi_Shortcode_Post_Type' ) ) {
    class Haru_Vidi_Shortcode_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'haru_shortcode';

            add_action( 'init', array( $this, 'haru_shortcode' ), 5);
            add_action( 'save_post', array( $this, 'haru_save_shortcode' ), 20 , 2 );

            if ( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                add_filter( 'manage_haru_shortcode_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_haru_shortcode_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }

            // Set custom posttype templates
            add_filter( 'single_template', array( $this, 'haru_single_template' ) ); // Single template
        }

        function remove_plugin_metaboxes() {
            remove_meta_box( 'mymetabox_revslider_0', 'haru_shortcode', 'normal' );
            remove_meta_box( 'handlediv', 'haru_shortcode', 'normal' );
            remove_meta_box( 'commentsdiv', 'haru_shortcode', 'normal' );
        }

        function haru_shortcode() {
            $prefix = $this->prefix;

            $labels = array(
                'menu_name'          => esc_html__( 'Shortcodes', 'haru-vidi' ),
                'singular_name'      => esc_html__( 'Single Shortcode', 'haru-vidi' ),
                'name'               => esc_html__( 'Shortcode', 'haru-vidi' ),
                'add_new'            => esc_html__( 'Add New', 'haru-vidi' ) ,
                'add_new_item'       => esc_html__( 'Add New Shortcode', 'haru-vidi' ) ,
                'edit_item'          => esc_html__( 'Edit Shortcode', 'haru-vidi' ) ,
                'new_item'           => esc_html__( 'Add New Shortcode', 'haru-vidi' ) ,
                'view_item'          => esc_html__( 'View Shortcode', 'haru-vidi' ) ,
                'search_items'       => esc_html__( 'Search Shortcode', 'haru-vidi' ) ,
                'not_found'          => esc_html__( 'No Shortcode items found', 'haru-vidi' ) ,
                'not_found_in_trash' => esc_html__( 'No Shortcode items found in trash', 'haru-vidi' ) ,
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display Shortcode', 'haru-vidi' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_in_rest'          => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-index-card',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => false,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'supports'              => array( 'title'),
                'rewrite'           => array(
                    'slug'          => 'generate-shortcode', // use / to remove slug
                    'with_front'    => false
                ) ,
            );
            register_post_type( 'haru_shortcode', $args );

            // Register a taxonomy for Shortcode Categories.
            $category_labels = array(
                'name'                          => esc_html__( 'Shortcode Categories', 'haru-vidi' ) ,
                'singular_name'                 => esc_html__( 'Shortcode Category', 'haru-vidi' ) ,
                'menu_name'                     => esc_html__( 'Categories', 'haru-vidi' ) ,
                'all_items'                     => esc_html__( 'All Shortcode Categories', 'haru-vidi' ) ,
                'edit_item'                     => esc_html__( 'Edit Shortcode Category', 'haru-vidi' ) ,
                'view_item'                     => esc_html__( 'View Shortcode Category', 'haru-vidi' ) ,
                'update_item'                   => esc_html__( 'Update Shortcode Category', 'haru-vidi' ) ,
                'add_new_item'                  => esc_html__( 'Add New Shortcode Category', 'haru-vidi' ) ,
                'new_item_name'                 => esc_html__( 'New Shortcode Category Name', 'haru-vidi' ) ,
                'parent_item'                   => esc_html__( 'Parent Shortcode Category', 'haru-vidi' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Shortcode Category:', 'haru-vidi' ) ,
                'search_items'                  => esc_html__( 'Search Shortcode Categories', 'haru-vidi' ) ,
                'popular_items'                 => esc_html__( 'Popular Shortcode Categories', 'haru-vidi' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Shortcode Categories with commas', 'haru-vidi' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Shortcode Categories', 'haru-vidi' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Shortcode Categories', 'haru-vidi' ) ,
                'not_found'                     => esc_html__( 'No Shortcode Categories found', 'haru-vidi' ) ,
            );

            $category_args = array(
                'labels'            => $category_labels,
                'public'            => false,
                'show_in_rest'      => true,
                'show_ui'           => true,
                'show_in_nav_menus' => false,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => true,
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => 'shortcode-category',
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('shortcode_category', array(
                'haru_shortcode'
            ) , $category_args);
        }

        // Add columns to Shortcode
        function add_columns($columns) {
            unset(
                $columns['post-format'],
                $columns['title'],
                $columns['date']
            );
            $cols = array_merge(array('cb' => ('')), $columns);
            $cols = array_merge($cols, array('title' => esc_html__( 'Title', 'haru-vidi' )));
            $cols = array_merge($cols, array('shortcode' => esc_html__( 'Shortcode', 'haru-vidi' )));
            $cols = array_merge($cols, array('category' => esc_html__( 'Category', 'haru-vidi' )));
            $cols = array_merge($cols, array('date' => esc_html__( 'Date', 'haru-vidi' )));

            return $cols;
        }

        // Set values for columns
        function set_columns_value($column, $post_id) {
            $prefix = $this->prefix;

            switch ($column) {
                case 'id': {
                    echo wp_kses_post($post_id);
                    break;
                }
                case 'shortcode': {
                    $shortcode = get_post_meta( $post_id, 'haru_shortcode_code', true );
                    echo ( '<textarea class="haru-shortcode-core" onfocus="this.select();" readonly="readonly">' . $shortcode . '</textarea>' );

                    break;
                }
                case 'category': {
                    $terms = get_the_terms( $post_id, 'shortcode_category' );
                    if ( $terms && ! is_wp_error( $terms ) ) {
                        $term_links = array();
                        foreach($terms as $term) {
                            $term_links[] = $term->name;
                        }
                        echo join( ", ", $term_links );
                    }
                    break;
                }
            }
        }

        function haru_single_template($single) {
            global $post;

            /* Checks for single template by post type */
            if ( $post->post_type == 'haru_shortcode' ) {
                $template_path = haru_vidi_posttype_get_template('vidi/shortcodes/'. 'single-shortcode' . '.php', array(), '', '');

                return $template_path;
            }

            return $single;
        }

        // Save shortcode
        function haru_save_shortcode() {
            global $post;

            if ( !empty($post) ) {
                $post_type = get_post_type($post->ID);

                if ( 'haru_shortcode' != $post_type ) return;

                // Start
                $haru_shortcode_code = '[';
                if ( isset( $_POST['haru_shortcode_type'] ) ) {
                    $haru_shortcode_code .= $_POST['haru_shortcode_type'];
                    $haru_shortcode_type = $_POST['haru_shortcode_type'];
                }

                // Video List shortcode
                if ( isset( $_POST['haru_shortcode_video_list_layout'] ) && in_array( $haru_shortcode_type, array('haru_video_list') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_video_list_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_title'] ) && in_array( $haru_shortcode_type, array('haru_video_list') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_video_list_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_columns'] ) && in_array( $haru_shortcode_type, array('haru_video_list') ) ) {
                    $haru_shortcode_code .= ' columns="' . $_POST['haru_shortcode_video_list_columns'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_data_source'] ) && in_array( $haru_shortcode_type, array('haru_video_list') ) ) {
                    $haru_shortcode_code .= ' data_source="' . $_POST['haru_shortcode_video_list_data_source'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_category'] ) && in_array( $haru_shortcode_type, array('haru_video_list') ) ) {
                    $shortcode_video_category = implode($_POST['haru_shortcode_video_list_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_video_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_ids'] ) && in_array( $haru_shortcode_type, array('haru_video_list') ) ) {
                    $shortcode_video_ids = implode($_POST['haru_shortcode_video_list_ids'], ',');
                    $haru_shortcode_code .= ' video_ids="' . $shortcode_video_ids . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_style'] ) && in_array( $haru_shortcode_type, array('haru_video_list') ) ) {
                    $haru_shortcode_code .= ' video_style="' . $_POST['haru_shortcode_video_list_style'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_video_list') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_video_list_posts_per_page'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_orderby'] ) && in_array( $haru_shortcode_type, array('haru_video_list') ) ) {
                    $haru_shortcode_code .= ' orderby="' . $_POST['haru_shortcode_video_list_orderby'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_order'] ) && in_array( $haru_shortcode_type, array('haru_video_list') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_video_list_order'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_filter'] ) && in_array( $haru_shortcode_type, array('haru_video_list') ) ) {
                    $haru_shortcode_code .= ' filter="' . $_POST['haru_shortcode_video_list_filter'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_paging_style'] ) && in_array( $haru_shortcode_type, array('haru_video_list') ) ) {
                    $haru_shortcode_code .= ' paging_style="' . $_POST['haru_shortcode_video_list_paging_style'] . '"';
                }

                // Video Slideshow shortcode
                if ( isset( $_POST['haru_shortcode_video_slideshow_layout'] ) && in_array( $haru_shortcode_type, array('haru_video_slideshow') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_video_slideshow_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_slideshow_title'] ) && in_array( $haru_shortcode_type, array('haru_video_slideshow') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_video_slideshow_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_slideshow_columns'] ) && in_array( $haru_shortcode_type, array('haru_video_slideshow') ) ) {
                    $haru_shortcode_code .= ' columns="' . $_POST['haru_shortcode_video_slideshow_columns'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_slideshow_data_source'] ) && in_array( $haru_shortcode_type, array('haru_video_slideshow') ) ) {
                    $haru_shortcode_code .= ' data_source="' . $_POST['haru_shortcode_video_slideshow_data_source'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_slideshow_category'] ) && in_array( $haru_shortcode_type, array('haru_video_slideshow') ) ) {
                    $shortcode_video_category = implode($_POST['haru_shortcode_video_slideshow_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_video_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_slideshow_ids'] ) && in_array( $haru_shortcode_type, array('haru_video_slideshow') ) ) {
                    $shortcode_video_ids = implode($_POST['haru_shortcode_video_slideshow_ids'], ',');
                    $haru_shortcode_code .= ' video_ids="' . $shortcode_video_ids . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_slideshow_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_video_slideshow') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_video_slideshow_posts_per_page'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_slideshow_orderby'] ) && in_array( $haru_shortcode_type, array('haru_video_slideshow') ) ) {
                    $haru_shortcode_code .= ' orderby="' . $_POST['haru_shortcode_video_slideshow_orderby'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_slideshow_order'] ) && in_array( $haru_shortcode_type, array('haru_video_slideshow') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_video_slideshow_order'] . '"';
                }

                // Video Category
                if ( isset( $_POST['haru_shortcode_video_category_title'] ) && in_array( $haru_shortcode_type, array('haru_video_category') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_video_category_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_layout'] ) && in_array( $haru_shortcode_type, array('haru_video_category') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_video_category_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_columns'] ) && in_array( $haru_shortcode_type, array('haru_video_category') ) ) {
                    $haru_shortcode_code .= ' columns="' . $_POST['haru_shortcode_video_category_columns'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_category'] ) && in_array( $haru_shortcode_type, array('haru_video_category') ) ) {
                    $shortcode_video_category = implode($_POST['haru_shortcode_video_category_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_video_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_style'] ) && in_array( $haru_shortcode_type, array('haru_video_category') ) ) {
                    $haru_shortcode_code .= ' video_style="' . $_POST['haru_shortcode_video_category_style'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_video_category') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_video_category_posts_per_page'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_orderby'] ) && in_array( $haru_shortcode_type, array('haru_video_category') ) ) {
                    $haru_shortcode_code .= ' orderby="' . $_POST['haru_shortcode_video_category_orderby'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_order'] ) && in_array( $haru_shortcode_type, array('haru_video_category') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_video_category_order'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_filter'] ) && in_array( $haru_shortcode_type, array('haru_video_category') ) ) {
                    $haru_shortcode_code .= ' filter="' . $_POST['haru_shortcode_video_category_filter'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_filter_all'] ) && in_array( $haru_shortcode_type, array('haru_video_category') ) ) {
                    $haru_shortcode_code .= ' filter_all="' . $_POST['haru_shortcode_video_category_filter_all'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_view_more'] ) && in_array( $haru_shortcode_type, array('haru_video_category') ) ) {
                    $haru_shortcode_code .= ' view_more="' . $_POST['haru_shortcode_video_category_view_more'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_ajax_arrow'] ) && in_array( $haru_shortcode_type, array('haru_video_category') ) ) {
                    $haru_shortcode_code .= ' ajax_arrow="' . $_POST['haru_shortcode_video_category_ajax_arrow'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_dark_style'] ) && in_array( $haru_shortcode_type, array('haru_video_category') ) ) {
                    $haru_shortcode_code .= ' dark_style="' . $_POST['haru_shortcode_video_category_dark_style'] . '"';
                }

                // Video Category Single
                if ( isset( $_POST['haru_shortcode_video_category_single_layout'] ) && in_array( $haru_shortcode_type, array('haru_video_category_single') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_video_category_single_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_single_category'] ) && in_array( $haru_shortcode_type, array('haru_video_category_single') ) ) {
                    $shortcode_video_category_single = $_POST['haru_shortcode_video_category_single_category'];
                    $haru_shortcode_code .= ' categories="' . $shortcode_video_category_single . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_single_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_video_category_single') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_video_category_single_posts_per_page'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_single_orderby'] ) && in_array( $haru_shortcode_type, array('haru_video_category_single') ) ) {
                    $haru_shortcode_code .= ' orderby="' . $_POST['haru_shortcode_video_category_single_orderby'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_single_order'] ) && in_array( $haru_shortcode_type, array('haru_video_category_single') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_video_category_single_order'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_category_single_view_more'] ) && in_array( $haru_shortcode_type, array('haru_video_category_single') ) ) {
                    $haru_shortcode_code .= ' view_more="' . $_POST['haru_shortcode_video_category_single_view_more'] . '"';
                }

                // Video Order shortcode
                if ( isset( $_POST['haru_shortcode_video_order_layout'] ) && in_array( $haru_shortcode_type, array('haru_video_order') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_video_order_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_columns'] ) && in_array( $haru_shortcode_type, array('haru_video_order') ) ) {
                    $haru_shortcode_code .= ' columns="' . $_POST['haru_shortcode_video_order_columns'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_tabs'] ) && in_array( $haru_shortcode_type, array('haru_video_order') ) ) {
                    $shortcode_video_tabs = implode($_POST['haru_shortcode_video_order_tabs'], ',');
                    $haru_shortcode_code .= ' order_tabs="' . $shortcode_video_tabs . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_new_title'] ) && in_array( $haru_shortcode_type, array('haru_video_order') ) ) {
                    $haru_shortcode_code .= ' new_title="' . $_POST['haru_shortcode_video_order_new_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_view_title'] ) && in_array( $haru_shortcode_type, array('haru_video_order') ) ) {
                    $haru_shortcode_code .= ' view_title="' . $_POST['haru_shortcode_video_order_view_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_like_title'] ) && in_array( $haru_shortcode_type, array('haru_video_order') ) ) {
                    $haru_shortcode_code .= ' like_title="' . $_POST['haru_shortcode_video_order_like_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_random_title'] ) && in_array( $haru_shortcode_type, array('haru_video_order') ) ) {
                    $haru_shortcode_code .= ' random_title="' . $_POST['haru_shortcode_video_order_random_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_category'] ) && in_array( $haru_shortcode_type, array('haru_video_order') ) ) {
                    $shortcode_video_category = implode($_POST['haru_shortcode_video_order_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_video_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_style'] ) && in_array( $haru_shortcode_type, array('haru_video_order') ) ) {
                    $haru_shortcode_code .= ' video_style="' . $_POST['haru_shortcode_video_order_style'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_video_order') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_video_order_posts_per_page'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_ajax_arrow'] ) && in_array( $haru_shortcode_type, array('haru_video_order') ) ) {
                    $haru_shortcode_code .= ' ajax_arrow="' . $_POST['haru_shortcode_video_order_ajax_arrow'] . '"';
                }

                // Video Order Single shortcode
                if ( isset( $_POST['haru_shortcode_video_order_single_layout'] ) && in_array( $haru_shortcode_type, array('haru_video_order_single') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_video_order_single_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_single_tabs'] ) && in_array( $haru_shortcode_type, array('haru_video_order_single') ) ) {
                    $shortcode_video_tabs = $_POST['haru_shortcode_video_order_single_tabs'];
                    $haru_shortcode_code .= ' order_tabs="' . $shortcode_video_tabs . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_single_new_title'] ) && in_array( $haru_shortcode_type, array('haru_video_order_single') ) ) {
                    $haru_shortcode_code .= ' new_title="' . $_POST['haru_shortcode_video_order_single_new_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_single_view_title'] ) && in_array( $haru_shortcode_type, array('haru_video_order_single') ) ) {
                    $haru_shortcode_code .= ' view_title="' . $_POST['haru_shortcode_video_order_single_view_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_single_like_title'] ) && in_array( $haru_shortcode_type, array('haru_video_order_single') ) ) {
                    $haru_shortcode_code .= ' like_title="' . $_POST['haru_shortcode_video_order_single_like_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_single_random_title'] ) && in_array( $haru_shortcode_type, array('haru_video_order_single') ) ) {
                    $haru_shortcode_code .= ' random_title="' . $_POST['haru_shortcode_video_order_single_random_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_single_category'] ) && in_array( $haru_shortcode_type, array('haru_video_order_single') ) ) {
                    $shortcode_video_category = implode($_POST['haru_shortcode_video_order_single_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_video_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_single_style'] ) && in_array( $haru_shortcode_type, array('haru_video_order_single') ) ) {
                    $haru_shortcode_code .= ' video_style="' . $_POST['haru_shortcode_video_order_single_style'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_single_columns'] ) && in_array( $haru_shortcode_type, array('haru_video_order_single') ) ) {
                    $haru_shortcode_code .= ' columns="' . $_POST['haru_shortcode_video_order_single_columns'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_order_single_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_video_order_single') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_video_order_single_posts_per_page'] . '"';
                }

                // Video Featured shortcode
                if ( isset( $_POST['haru_shortcode_video_featured_title'] ) && in_array( $haru_shortcode_type, array('haru_video_featured') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_video_featured_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_featured_layout'] ) && in_array( $haru_shortcode_type, array('haru_video_featured') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_video_featured_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_featured_category'] ) && in_array( $haru_shortcode_type, array('haru_video_featured') ) ) {
                    $shortcode_video_category = implode($_POST['haru_shortcode_video_featured_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_video_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_featured_orderby'] ) && in_array( $haru_shortcode_type, array('haru_video_featured') ) ) {
                    $haru_shortcode_code .= ' orderby="' . $_POST['haru_shortcode_video_featured_orderby'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_featured_order'] ) && in_array( $haru_shortcode_type, array('haru_video_featured') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_video_featured_order'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_featured_filter'] ) && in_array( $haru_shortcode_type, array('haru_video_featured') ) ) {
                    $haru_shortcode_code .= ' filter="' . $_POST['haru_shortcode_video_featured_filter'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_featured_filter_all'] ) && in_array( $haru_shortcode_type, array('haru_video_featured') ) ) {
                    $haru_shortcode_code .= ' filter_all="' . $_POST['haru_shortcode_video_featured_filter_all'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_featured_view_more'] ) && in_array( $haru_shortcode_type, array('haru_video_featured') ) ) {
                    $haru_shortcode_code .= ' view_more="' . $_POST['haru_shortcode_video_featured_view_more'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_featured_ajax_arrow'] ) && in_array( $haru_shortcode_type, array('haru_video_featured') ) ) {
                    $haru_shortcode_code .= ' ajax_arrow="' . $_POST['haru_shortcode_video_featured_ajax_arrow'] . '"';
                }

                // Video TOP shortcode
                if ( isset( $_POST['haru_shortcode_video_top_layout'] ) && in_array( $haru_shortcode_type, array('haru_video_top') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_video_top_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_top_title'] ) && in_array( $haru_shortcode_type, array('haru_video_top') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_video_top_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_top_category'] ) && in_array( $haru_shortcode_type, array('haru_video_top') ) ) {
                    $shortcode_video_category = implode($_POST['haru_shortcode_video_top_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_video_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_top_order_by'] ) && in_array( $haru_shortcode_type, array('haru_video_top') ) ) {
                    $haru_shortcode_code .= ' order_by="' . $_POST['haru_shortcode_video_top_order_by'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_top_order'] ) && in_array( $haru_shortcode_type, array('haru_video_top') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_video_top_order'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_top_video_style'] ) && in_array( $haru_shortcode_type, array('haru_video_top') ) ) {
                    $haru_shortcode_code .= ' video_style="' . $_POST['haru_shortcode_video_top_video_style'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_top_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_video_top') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_video_top_posts_per_page'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_top_dark_style'] ) && in_array( $haru_shortcode_type, array('haru_video_top') ) ) {
                    $haru_shortcode_code .= ' dark_style="' . $_POST['haru_shortcode_video_top_dark_style'] . '"';
                }

                // Video List Category shortcode
                if ( isset( $_POST['haru_shortcode_video_list_category_layout'] ) && in_array( $haru_shortcode_type, array('haru_video_list_category') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_video_list_category_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_category_title'] ) && in_array( $haru_shortcode_type, array('haru_video_list_category') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_video_list_category_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_category_order_by'] ) && in_array( $haru_shortcode_type, array('haru_video_list_category') ) ) {
                    $haru_shortcode_code .= ' orderby="' . $_POST['haru_shortcode_video_list_category_order_by'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_category_count'] ) && in_array( $haru_shortcode_type, array('haru_video_list_category') ) ) {
                    $haru_shortcode_code .= ' count="' . $_POST['haru_shortcode_video_list_category_count'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_category_hierarchical'] ) && in_array( $haru_shortcode_type, array('haru_video_list_category') ) ) {
                    $haru_shortcode_code .= ' hierarchical="' . $_POST['haru_shortcode_video_list_category_hierarchical'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_category_show_children_only'] ) && in_array( $haru_shortcode_type, array('haru_video_list_category') ) ) {
                    $haru_shortcode_code .= ' show_children_only="' . $_POST['haru_shortcode_video_list_category_show_children_only'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_category_hide_empty'] ) && in_array( $haru_shortcode_type, array('haru_video_list_category') ) ) {
                    $haru_shortcode_code .= ' hide_empty="' . $_POST['haru_shortcode_video_list_category_hide_empty'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_video_list_category_max_depth'] ) && in_array( $haru_shortcode_type, array('haru_video_list_category') ) ) {
                    $haru_shortcode_code .= ' max_depth="' . $_POST['haru_shortcode_video_list_category_max_depth'] . '"';
                }

                // Channel Category
                if ( isset( $_POST['haru_shortcode_channel_category_layout'] ) && in_array( $haru_shortcode_type, array('haru_channel_category') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_channel_category_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_category_title'] ) && in_array( $haru_shortcode_type, array('haru_channel_category') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_channel_category_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_category_columns'] ) && in_array( $haru_shortcode_type, array('haru_channel_category') ) ) {
                    $haru_shortcode_code .= ' columns="' . $_POST['haru_shortcode_channel_category_columns'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_category_category'] ) && in_array( $haru_shortcode_type, array('haru_channel_category') ) ) {
                    $shortcode_channel_category = implode($_POST['haru_shortcode_channel_category_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_channel_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_category_style'] ) && in_array( $haru_shortcode_type, array('haru_channel_category') ) ) {
                    $haru_shortcode_code .= ' channel_style="' . $_POST['haru_shortcode_channel_category_style'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_category_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_channel_category') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_channel_category_posts_per_page'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_category_orderby'] ) && in_array( $haru_shortcode_type, array('haru_channel_category') ) ) {
                    $haru_shortcode_code .= ' orderby="' . $_POST['haru_shortcode_channel_category_orderby'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_category_order'] ) && in_array( $haru_shortcode_type, array('haru_channel_category') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_channel_category_order'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_category_filter'] ) && in_array( $haru_shortcode_type, array('haru_channel_category') ) ) {
                    $haru_shortcode_code .= ' filter="' . $_POST['haru_shortcode_channel_category_filter'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_category_filter_all'] ) && in_array( $haru_shortcode_type, array('haru_channel_category') ) ) {
                    $haru_shortcode_code .= ' filter_all="' . $_POST['haru_shortcode_channel_category_filter_all'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_category_view_more'] ) && in_array( $haru_shortcode_type, array('haru_channel_category') ) ) {
                    $haru_shortcode_code .= ' view_more="' . $_POST['haru_shortcode_channel_category_view_more'] . '"';
                }

                // Channel Slideshow shortcode
                if ( isset( $_POST['haru_shortcode_channel_slideshow_title'] ) && in_array( $haru_shortcode_type, array('haru_channel_slideshow') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_channel_slideshow_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_slideshow_layout'] ) && in_array( $haru_shortcode_type, array('haru_channel_slideshow') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_channel_slideshow_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_slideshow_columns'] ) && in_array( $haru_shortcode_type, array('haru_channel_slideshow') ) ) {
                    $haru_shortcode_code .= ' columns="' . $_POST['haru_shortcode_channel_slideshow_columns'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_slideshow_data_source'] ) && in_array( $haru_shortcode_type, array('haru_channel_slideshow') ) ) {
                    $haru_shortcode_code .= ' data_source="' . $_POST['haru_shortcode_channel_slideshow_data_source'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_slideshow_category'] ) && in_array( $haru_shortcode_type, array('haru_channel_slideshow') ) ) {
                    $shortcode_channel_category = implode($_POST['haru_shortcode_channel_slideshow_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_channel_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_slideshow_ids'] ) && in_array( $haru_shortcode_type, array('haru_channel_slideshow') ) ) {
                    $shortcode_channel_ids = implode($_POST['haru_shortcode_channel_slideshow_ids'], ',');
                    $haru_shortcode_code .= ' channel_ids="' . $shortcode_channel_ids . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_slideshow_style'] ) && in_array( $haru_shortcode_type, array('haru_channel_slideshow') ) ) {
                    $haru_shortcode_code .= ' channel_style="' . $_POST['haru_shortcode_channel_slideshow_style'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_slideshow_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_channel_slideshow') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_channel_slideshow_posts_per_page'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_slideshow_orderby'] ) && in_array( $haru_shortcode_type, array('haru_channel_slideshow') ) ) {
                    $haru_shortcode_code .= ' orderby="' . $_POST['haru_shortcode_channel_slideshow_orderby'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_slideshow_order'] ) && in_array( $haru_shortcode_type, array('haru_channel_slideshow') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_channel_slideshow_order'] . '"';
                }

                // Channel TOP shortcode
                if ( isset( $_POST['haru_shortcode_channel_top_layout'] ) && in_array( $haru_shortcode_type, array('haru_channel_top') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_channel_top_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_top_title'] ) && in_array( $haru_shortcode_type, array('haru_channel_top') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_channel_top_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_top_category'] ) && in_array( $haru_shortcode_type, array('haru_channel_top') ) ) {
                    $shortcode_channel_category = implode($_POST['haru_shortcode_channel_top_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_channel_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_top_order_by'] ) && in_array( $haru_shortcode_type, array('haru_channel_top') ) ) {
                    $haru_shortcode_code .= ' order_by="' . $_POST['haru_shortcode_channel_top_order_by'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_top_order'] ) && in_array( $haru_shortcode_type, array('haru_channel_top') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_channel_top_order'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_top_channel_style'] ) && in_array( $haru_shortcode_type, array('haru_channel_top') ) ) {
                    $haru_shortcode_code .= ' channel_style="' . $_POST['haru_shortcode_channel_top_channel_style'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_channel_top_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_channel_top') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_channel_top_posts_per_page'] . '"';
                }

                // Playlist Category
                if ( isset( $_POST['haru_shortcode_playlist_category_layout'] ) && in_array( $haru_shortcode_type, array('haru_playlist_category') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_playlist_category_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_category_title'] ) && in_array( $haru_shortcode_type, array('haru_playlist_category') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_playlist_category_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_category_columns'] ) && in_array( $haru_shortcode_type, array('haru_playlist_category') ) ) {
                    $haru_shortcode_code .= ' columns="' . $_POST['haru_shortcode_playlist_category_columns'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_category_category'] ) && in_array( $haru_shortcode_type, array('haru_playlist_category') ) ) {
                    $shortcode_playlist_category = implode($_POST['haru_shortcode_playlist_category_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_playlist_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_category_style'] ) && in_array( $haru_shortcode_type, array('haru_playlist_category') ) ) {
                    $haru_shortcode_code .= ' playlist_style="' . $_POST['haru_shortcode_playlist_category_style'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_category_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_playlist_category') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_playlist_category_posts_per_page'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_category_orderby'] ) && in_array( $haru_shortcode_type, array('haru_playlist_category') ) ) {
                    $haru_shortcode_code .= ' orderby="' . $_POST['haru_shortcode_playlist_category_orderby'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_category_order'] ) && in_array( $haru_shortcode_type, array('haru_playlist_category') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_playlist_category_order'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_category_filter'] ) && in_array( $haru_shortcode_type, array('haru_playlist_category') ) ) {
                    $haru_shortcode_code .= ' filter="' . $_POST['haru_shortcode_playlist_category_filter'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_category_filter_all'] ) && in_array( $haru_shortcode_type, array('haru_playlist_category') ) ) {
                    $haru_shortcode_code .= ' filter_all="' . $_POST['haru_shortcode_playlist_category_filter_all'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_category_view_more'] ) && in_array( $haru_shortcode_type, array('haru_playlist_category') ) ) {
                    $haru_shortcode_code .= ' view_more="' . $_POST['haru_shortcode_playlist_category_view_more'] . '"';
                }

                // Playlist Slideshow shortcode
                if ( isset( $_POST['haru_shortcode_playlist_slideshow_title'] ) && in_array( $haru_shortcode_type, array('haru_playlist_slideshow') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_playlist_slideshow_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_slideshow_layout'] ) && in_array( $haru_shortcode_type, array('haru_playlist_slideshow') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_playlist_slideshow_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_slideshow_columns'] ) && in_array( $haru_shortcode_type, array('haru_playlist_slideshow') ) ) {
                    $haru_shortcode_code .= ' columns="' . $_POST['haru_shortcode_playlist_slideshow_columns'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_slideshow_data_source'] ) && in_array( $haru_shortcode_type, array('haru_playlist_slideshow') ) ) {
                    $haru_shortcode_code .= ' data_source="' . $_POST['haru_shortcode_playlist_slideshow_data_source'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_slideshow_category'] ) && in_array( $haru_shortcode_type, array('haru_playlist_slideshow') ) ) {
                    $shortcode_playlist_category = implode($_POST['haru_shortcode_playlist_slideshow_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_playlist_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_slideshow_ids'] ) && in_array( $haru_shortcode_type, array('haru_playlist_slideshow') ) ) {
                    $shortcode_playlist_ids = implode($_POST['haru_shortcode_playlist_slideshow_ids'], ',');
                    $haru_shortcode_code .= ' playlist_ids="' . $shortcode_playlist_ids . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_slideshow_style'] ) && in_array( $haru_shortcode_type, array('haru_playlist_slideshow') ) ) {
                    $haru_shortcode_code .= ' playlist_style="' . $_POST['haru_shortcode_playlist_slideshow_style'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_slideshow_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_playlist_slideshow') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_playlist_slideshow_posts_per_page'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_slideshow_orderby'] ) && in_array( $haru_shortcode_type, array('haru_playlist_slideshow') ) ) {
                    $haru_shortcode_code .= ' orderby="' . $_POST['haru_shortcode_playlist_slideshow_orderby'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_slideshow_order'] ) && in_array( $haru_shortcode_type, array('haru_playlist_slideshow') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_playlist_slideshow_order'] . '"';
                }

                // Playlist TOP shortcode
                if ( isset( $_POST['haru_shortcode_playlist_top_layout'] ) && in_array( $haru_shortcode_type, array('haru_playlist_top') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_playlist_top_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_top_title'] ) && in_array( $haru_shortcode_type, array('haru_playlist_top') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_playlist_top_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_top_category'] ) && in_array( $haru_shortcode_type, array('haru_playlist_top') ) ) {
                    $shortcode_playlist_category = implode($_POST['haru_shortcode_playlist_top_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_playlist_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_top_order_by'] ) && in_array( $haru_shortcode_type, array('haru_playlist_top') ) ) {
                    $haru_shortcode_code .= ' order_by="' . $_POST['haru_shortcode_playlist_top_order_by'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_top_order'] ) && in_array( $haru_shortcode_type, array('haru_playlist_top') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_playlist_top_order'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_top_playlist_style'] ) && in_array( $haru_shortcode_type, array('haru_playlist_top') ) ) {
                    $haru_shortcode_code .= ' playlist_style="' . $_POST['haru_shortcode_playlist_top_playlist_style'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_playlist_top_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_playlist_top') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_playlist_top_posts_per_page'] . '"';
                }

                // Series Category
                if ( isset( $_POST['haru_shortcode_series_category_layout'] ) && in_array( $haru_shortcode_type, array('haru_series_category') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_series_category_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_category_title'] ) && in_array( $haru_shortcode_type, array('haru_series_category') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_series_category_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_category_columns'] ) && in_array( $haru_shortcode_type, array('haru_series_category') ) ) {
                    $haru_shortcode_code .= ' columns="' . $_POST['haru_shortcode_series_category_columns'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_category_category'] ) && in_array( $haru_shortcode_type, array('haru_series_category') ) ) {
                    $shortcode_series_category = implode($_POST['haru_shortcode_series_category_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_series_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_category_style'] ) && in_array( $haru_shortcode_type, array('haru_series_category') ) ) {
                    $haru_shortcode_code .= ' series_style="' . $_POST['haru_shortcode_series_category_style'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_category_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_series_category') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_series_category_posts_per_page'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_category_orderby'] ) && in_array( $haru_shortcode_type, array('haru_series_category') ) ) {
                    $haru_shortcode_code .= ' orderby="' . $_POST['haru_shortcode_series_category_orderby'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_category_order'] ) && in_array( $haru_shortcode_type, array('haru_series_category') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_series_category_order'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_category_filter'] ) && in_array( $haru_shortcode_type, array('haru_series_category') ) ) {
                    $haru_shortcode_code .= ' filter="' . $_POST['haru_shortcode_series_category_filter'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_category_filter_all'] ) && in_array( $haru_shortcode_type, array('haru_series_category') ) ) {
                    $haru_shortcode_code .= ' filter_all="' . $_POST['haru_shortcode_series_category_filter_all'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_category_view_more'] ) && in_array( $haru_shortcode_type, array('haru_series_category') ) ) {
                    $haru_shortcode_code .= ' view_more="' . $_POST['haru_shortcode_series_category_view_more'] . '"';
                }

                // Series Slideshow shortcode
                if ( isset( $_POST['haru_shortcode_series_slideshow_title'] ) && in_array( $haru_shortcode_type, array('haru_series_slideshow') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_series_slideshow_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_slideshow_layout'] ) && in_array( $haru_shortcode_type, array('haru_series_slideshow') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_series_slideshow_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_slideshow_columns'] ) && in_array( $haru_shortcode_type, array('haru_series_slideshow') ) ) {
                    $haru_shortcode_code .= ' columns="' . $_POST['haru_shortcode_series_slideshow_columns'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_slideshow_data_source'] ) && in_array( $haru_shortcode_type, array('haru_series_slideshow') ) ) {
                    $haru_shortcode_code .= ' data_source="' . $_POST['haru_shortcode_series_slideshow_data_source'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_slideshow_category'] ) && in_array( $haru_shortcode_type, array('haru_series_slideshow') ) ) {
                    $shortcode_series_category = implode($_POST['haru_shortcode_series_slideshow_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_series_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_slideshow_ids'] ) && in_array( $haru_shortcode_type, array('haru_series_slideshow') ) ) {
                    $shortcode_series_ids = implode($_POST['haru_shortcode_series_slideshow_ids'], ',');
                    $haru_shortcode_code .= ' series_ids="' . $shortcode_series_ids . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_slideshow_style'] ) && in_array( $haru_shortcode_type, array('haru_series_slideshow') ) ) {
                    $haru_shortcode_code .= ' series_style="' . $_POST['haru_shortcode_series_slideshow_style'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_slideshow_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_series_slideshow') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_series_slideshow_posts_per_page'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_slideshow_orderby'] ) && in_array( $haru_shortcode_type, array('haru_series_slideshow') ) ) {
                    $haru_shortcode_code .= ' orderby="' . $_POST['haru_shortcode_series_slideshow_orderby'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_slideshow_order'] ) && in_array( $haru_shortcode_type, array('haru_series_slideshow') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_series_slideshow_order'] . '"';
                }

                // Series TOP shortcode
                if ( isset( $_POST['haru_shortcode_series_top_layout'] ) && in_array( $haru_shortcode_type, array('haru_series_top') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_series_top_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_top_title'] ) && in_array( $haru_shortcode_type, array('haru_series_top') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_series_top_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_top_category'] ) && in_array( $haru_shortcode_type, array('haru_series_top') ) ) {
                    $shortcode_series_category = implode($_POST['haru_shortcode_series_top_category'], ',');
                    $haru_shortcode_code .= ' categories="' . $shortcode_series_category . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_top_order_by'] ) && in_array( $haru_shortcode_type, array('haru_series_top') ) ) {
                    $haru_shortcode_code .= ' order_by="' . $_POST['haru_shortcode_series_top_order_by'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_top_order'] ) && in_array( $haru_shortcode_type, array('haru_series_top') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_series_top_order'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_top_series_style'] ) && in_array( $haru_shortcode_type, array('haru_series_top') ) ) {
                    $haru_shortcode_code .= ' series_style="' . $_POST['haru_shortcode_series_top_series_style'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_series_top_posts_per_page'] ) && in_array( $haru_shortcode_type, array('haru_series_top') ) ) {
                    $haru_shortcode_code .= ' posts_per_page="' . $_POST['haru_shortcode_series_top_posts_per_page'] . '"';
                }

                // Author TOP shortcode
                if ( isset( $_POST['haru_shortcode_author_top_layout'] ) && in_array( $haru_shortcode_type, array('haru_author_top') ) ) {
                    $haru_shortcode_code .= ' layout="' . $_POST['haru_shortcode_author_top_layout'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_author_top_title'] ) && in_array( $haru_shortcode_type, array('haru_author_top') ) ) {
                    $haru_shortcode_code .= ' title="' . $_POST['haru_shortcode_author_top_title'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_author_top_order_by'] ) && in_array( $haru_shortcode_type, array('haru_author_top') ) ) {
                    $haru_shortcode_code .= ' order_by="' . $_POST['haru_shortcode_author_top_order_by'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_author_top_order'] ) && in_array( $haru_shortcode_type, array('haru_author_top') ) ) {
                    $haru_shortcode_code .= ' order="' . $_POST['haru_shortcode_author_top_order'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_author_top_number'] ) && in_array( $haru_shortcode_type, array('haru_author_top') ) ) {
                    $haru_shortcode_code .= ' number="' . $_POST['haru_shortcode_author_top_number'] . '"';
                }
                if ( isset( $_POST['haru_shortcode_author_top_dark_style'] ) && in_array( $haru_shortcode_type, array('haru_author_top') ) ) {
                    $haru_shortcode_code .= ' dark_style="' . $_POST['haru_shortcode_author_top_dark_style'] . '"';
                }

                // General Shortcodes
                if ( isset( $_POST['haru_shortcode_extra_class'] ) && ( $_POST['haru_shortcode_extra_class'] != '' ) ) {
                    $haru_shortcode_code .= ' extra_class="' . $_POST['haru_shortcode_extra_class'] . '"';
                }

                $haru_shortcode_code .= ']';
                // End
                
                update_post_meta( $post->ID, 'haru_shortcode_code', $haru_shortcode_code );
            }
        }
    }

    new Haru_Vidi_Shortcode_Post_Type;
}