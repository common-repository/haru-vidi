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

if ( ! class_exists( 'Haru_Vidi_Director_Post_Type' ) ) {
    class Haru_Vidi_Director_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'haru_director';

            add_action('init', array($this,'haru_director'), '5');
            add_action('save_post_haru_director', array($this, 'haru_save_director') );

            if ( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                add_filter( 'manage_haru_director_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_haru_director_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }

            // Set custom posttype templates
            add_filter( 'single_template', array( $this, 'haru_single_template' ) ); // Single template
            add_filter( 'archive_template', array( $this, 'haru_archive_template' ) ); // Archive template
            add_filter( 'taxonomy_template', array( $this, 'haru_archive_template' ) );

            // Add permalink settings slug
            add_action( 'load-options-permalink.php', array( $this, 'haru_load_permalinks' ) );
        }

        function haru_load_permalinks() {
            if ( isset( $_POST['haru_director_base'] ) ) {
                update_option( 'haru_director_base', sanitize_title_with_dashes( $_POST['haru_director_base'] ) );
            }

            if ( isset( $_POST['haru_director_category_base'] ) ) {
                update_option( 'haru_director_category_base', sanitize_title_with_dashes( $_POST['haru_director_category_base'] ) );
            }

            // Add a settings field to the permalink page
            add_settings_field(
                'haru_director_base', 
                esc_html__( 'Director base', 'haru-vidi' ), 
                array( $this, 'haru_field_callback' ), 
                'permalink',
                'haru_settings_vidi',
                array( // The $args
                    'haru_director_base' // Should match Option ID
                )
            );

            add_settings_field( 
                'haru_director_category_base', 
                esc_html__( 'Director category base', 'haru-vidi' ), 
                array( $this, 'haru_field_callback' ), 
                'permalink', 
                'haru_settings_vidi',
                array( // The $args
                    'haru_director_category_base' // Should match Option ID
                )
            );
        }

        function haru_field_callback( $args ) {  
            $value = get_option( $args[0] );

            echo '<input type="text" value="' . esc_attr( $value ) . '" name="' . $args[0] . '" id="' . $args[0] . '" class="regular-text" />';
        }

        function remove_plugin_metaboxes() {
            remove_meta_box( 'mymetabox_revslider_0', 'haru_director', 'normal' );
            remove_meta_box( 'handlediv', 'haru_director', 'normal' );
            remove_meta_box( 'commentsdiv', 'haru_director', 'normal' );
        }

        function haru_director() {
            $prefix = $this->prefix;

            $director_slug = haru_vidi_get_director_slug();

            $labels = array(
                'menu_name'          => esc_html__( 'Directors', 'haru-vidi' ),
                'singular_name'      => esc_html__( 'Single Director', 'haru-vidi' ),
                'name'               => esc_html__( 'Director', 'haru-vidi' ),
                'add_new'            => esc_html__( 'Add New', 'haru-vidi' ) ,
                'add_new_item'       => esc_html__( 'Add New Director', 'haru-vidi' ) ,
                'edit_item'          => esc_html__( 'Edit Director', 'haru-vidi' ) ,
                'new_item'           => esc_html__( 'Add New Director', 'haru-vidi' ) ,
                'view_item'          => esc_html__( 'View Director', 'haru-vidi' ) ,
                'search_items'       => esc_html__( 'Search Director', 'haru-vidi' ) ,
                'not_found'          => esc_html__( 'No Director items found', 'haru-vidi' ) ,
                'not_found_in_trash' => esc_html__( 'No Director items found in trash', 'haru-vidi' ) ,
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display Director', 'haru-vidi' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_in_rest'          => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-businessman',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => true,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'supports'              => array( 'title', 'editor', 'thumbnail' ),
                'rewrite'           => array(
                    'slug'          => $director_slug,
                    'with_front'    => false
                ) ,
            );
            register_post_type( 'haru_director', $args );

            // Register a taxonomy for Director Categories.
            $director_category_slug = haru_vidi_get_actor_category_slug();

            $category_labels = array(
                'name'                          => esc_html__( 'Director Categories', 'haru-vidi' ) ,
                'singular_name'                 => esc_html__( 'Director Category', 'haru-vidi' ) ,
                'menu_name'                     => esc_html__( 'Categories', 'haru-vidi' ) ,
                'all_items'                     => esc_html__( 'All Director Categories', 'haru-vidi' ) ,
                'edit_item'                     => esc_html__( 'Edit Director Category', 'haru-vidi' ) ,
                'view_item'                     => esc_html__( 'View Director Category', 'haru-vidi' ) ,
                'update_item'                   => esc_html__( 'Update Director Category', 'haru-vidi' ) ,
                'add_new_item'                  => esc_html__( 'Add New Director Category', 'haru-vidi' ) ,
                'new_item_name'                 => esc_html__( 'New Director Category Name', 'haru-vidi' ) ,
                'parent_item'                   => esc_html__( 'Parent Director Category', 'haru-vidi' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Director Category:', 'haru-vidi' ) ,
                'search_items'                  => esc_html__( 'Search Director Categories', 'haru-vidi' ) ,
                'popular_items'                 => esc_html__( 'Popular Director Categories', 'haru-vidi' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Director Categories with commas', 'haru-vidi' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Director Categories', 'haru-vidi' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Director Categories', 'haru-vidi' ) ,
                'not_found'                     => esc_html__( 'No Director Categories found', 'haru-vidi' ) ,
            );

            $category_args = array(
                'labels'            => $category_labels,
                'public'            => false,
                'show_ui'           => true,
                'show_in_rest'      => true,
                'show_in_nav_menus' => true,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => true,
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => $director_category_slug,
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('director_category', array(
                'haru_director'
            ) , $category_args);
        }

        // Add columns to Director
        function add_columns($columns) {
            unset(
                $columns['post-format'],
                $columns['title'],
                $columns['date']
            );
            $cols = array_merge(array('cb' => ('')), $columns);
            $cols = array_merge($cols, array('title' => esc_html__( 'Title', 'haru-vidi' )));
            $cols = array_merge($cols, array('thumbnail' => esc_html__( 'Thumbnail', 'haru-vidi' )));
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
                case 'thumbnail': {
                    echo get_the_post_thumbnail($post_id, 'thumbnail');
                    break;
                }
                case 'category': {
                    $terms = get_the_terms( $post_id, 'director_category' );
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
            if ( $post->post_type == 'haru_director' ) {
                $template_path = haru_vidi_posttype_get_template('vidi/director/'. 'single-director' . '.php', array(), '', '');

                return $template_path;
            }

            return $single;
        }

        function haru_archive_template($archive_template) {
            $post_type =  get_post_type();

            if ( ( is_archive() || is_tax() ) && isset($post_type) && $post_type == 'haru_director'  ) {
                $template_path = haru_vidi_posttype_get_template('vidi/director/'. 'archive-director' . '.php', array(), '', '');

                return $template_path;
            }

            return $archive_template;
        }

        // Save director
        function haru_save_director() {
            global $post;

            if ( !empty($post) ) {
                $video_ids = $_POST['haru_director_attached_videos'];
                $video_ids = explode(",", $video_ids);
                $video_ids_current = $_POST['haru_director_attached_videos-current']; // attached-posts-ids
                $video_ids_current = explode(",", $video_ids_current);
                $video_ids_add = array_diff($video_ids, $video_ids_current);
                $video_ids_delete = array_diff($video_ids_current, $video_ids);

                if ( !empty($video_ids_add) ) {
                    foreach ( $video_ids_add as $video_id ) {
                        $video_director = '';
                        $video_director = get_post_meta( $video_id, 'haru_video_attached_directors', false );

                        if ( !empty($video_director) ) {
                            $video_director = $video_director[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( !in_array( (string)$post->ID, $video_director ) ) {
                            array_push($video_director, (string)$post->ID);
                        } 

                        update_post_meta( (int)$video_id, 'haru_video_attached_directors', $video_director );
                    }
                }
                if ( !empty($video_ids_delete) ) {
                    foreach ( $video_ids_delete as $video_id ) {
                        $video_director = '';
                        $video_director = get_post_meta( $video_id, 'haru_video_attached_directors', false );

                        if ( !empty($video_director) ) {
                            $video_director = $video_director[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( in_array( (string)$post->ID, $video_director ) ) {
                            if ( ($key = array_search((string)$post->ID, $video_director)) !== false ) {
                                unset($video_director[$key]);
                            }
                        }

                        update_post_meta( (int)$video_id, 'haru_video_attached_directors', $video_director );
                    }
                }

                // Series
                $series_ids = $_POST['haru_director_attached_seriess'];
                $series_ids = explode(",", $series_ids);
                $series_ids_current = $_POST['haru_director_attached_seriess-current']; // attached-posts-ids
                $series_ids_current = explode(",", $series_ids_current);
                $series_ids_add = array_diff($series_ids, $series_ids_current);
                $series_ids_delete = array_diff($series_ids_current, $series_ids);
                
                if ( !empty($series_ids_add) ) {
                    foreach ( $series_ids_add as $series_id ) {
                        $series_director = '';
                        $series_director = get_post_meta( $series_id, 'haru_series_attached_directors', false );

                        if ( !empty($series_director) ) {
                            $series_director = $series_director[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( !in_array( (string)$post->ID, $series_director ) ) {
                            array_push($series_director, (string)$post->ID);
                        }

                        update_post_meta( (int)$series_id, 'haru_series_attached_directors', $series_director );
                    }
                }
                if ( !empty($series_ids_delete) ) {
                    foreach ( $series_ids_delete as $series_id ) {
                        $series_director = '';
                        $series_director = get_post_meta( $series_id, 'haru_series_attached_directors', false );

                        if ( !empty($series_director) ) {
                            $series_director = $series_director[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( in_array( (string)$post->ID, $series_director ) ) {
                            if ( ($key = array_search((string)$post->ID, $series_director)) !== false ) {
                                unset($series_director[$key]);
                            }
                        }

                        update_post_meta( (int)$series_id, 'haru_series_attached_directors', $series_director );
                    }
                }

                // Fake like/dislike count
                $like_count = (int)get_post_meta( $post->ID, '_post_like_count', true );
                $dislike_count = (int)get_post_meta( $post->ID, '_post_dislike_count', true );
                $fake_like_dislike = $_POST['haru_fake_like_dislike'];

                if ( $fake_like_dislike == '1' ) {
                    $fake_like_count = (int)$_POST['haru_fake_like_count'];
                    $fake_dislike_count = (int)$_POST['haru_fake_dislike_count'];
                    $total_like_count = $like_count + $fake_like_count;
                    $total_dislike_count = $dislike_count + $fake_dislike_count;

                    update_post_meta($post->ID, '_post_like_count_total', $total_like_count);
                    update_post_meta($post->ID, '_post_dislike_count_total', $total_dislike_count);
                } else {
                    update_post_meta($post->ID, '_post_like_count_total', $like_count);
                    update_post_meta($post->ID, '_post_dislike_count_total', $dislike_count);
                }
                // Fake view count
                // Use Post View Counter plugin
                if ( class_exists( 'Post_Views_Counter' ) ) {
                    $views = pvc_get_post_views( $post->ID ); // includes/functions.php
                    $fake_view = $_POST['haru_fake_view'];
                    $fake_view_count = (int)get_post_meta($post->ID, 'haru_fake_view_count', true);
                    if ( $fake_view == '1' ) {
                        $views += $fake_view_count;
                    }
                    update_post_meta($post->ID, '_post_view_count_total', $views);
                }
            }
        }
    }

    new Haru_Vidi_Director_Post_Type;
}