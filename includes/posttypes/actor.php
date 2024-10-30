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

if ( ! class_exists( 'Haru_Vidi_Actor_Post_Type' ) ) {
    class Haru_Vidi_Actor_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'haru_actor';

            add_action('init', array($this,'haru_actor'), '5');
            add_action('save_post_haru_actor', array($this, 'haru_save_actor') );

            if ( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                add_filter( 'manage_haru_actor_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_haru_actor_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }

            // Set custom posttype templates
            add_filter( 'single_template', array( $this, 'haru_single_template' ) ); // Single template
            add_filter( 'archive_template', array( $this, 'haru_archive_template' ) ); // Archive template
            add_filter( 'taxonomy_template', array( $this, 'haru_archive_template' ) );

            // Add permalink settings slug
            add_action( 'load-options-permalink.php', array( $this, 'haru_load_permalinks' ) );
        }

        function haru_load_permalinks() {
            if ( isset( $_POST['haru_actor_base'] ) ) {
                update_option( 'haru_actor_base', sanitize_title_with_dashes( $_POST['haru_actor_base'] ) );
            }

            if ( isset( $_POST['haru_actor_category_base'] ) ) {
                update_option( 'haru_actor_category_base', sanitize_title_with_dashes( $_POST['haru_actor_category_base'] ) );
            }

            // Add a settings field to the permalink page
            add_settings_field(
                'haru_actor_base', 
                esc_html__( 'Actor base', 'haru-vidi' ), 
                array( $this, 'haru_field_callback' ), 
                'permalink',
                'haru_settings_vidi',
                array( // The $args
                    'haru_actor_base' // Should match Option ID
                )
            );

            add_settings_field( 
                'haru_actor_category_base', 
                esc_html__( 'Actor category base', 'haru-vidi' ), 
                array( $this, 'haru_field_callback' ), 
                'permalink', 
                'haru_settings_vidi',
                array( // The $args
                    'haru_actor_category_base' // Should match Option ID
                )
            );
        }

        function haru_field_callback( $args ) {  
            $value = get_option( $args[0] );

            echo '<input type="text" value="' . esc_attr( $value ) . '" name="' . $args[0] . '" id="' . $args[0] . '" class="regular-text" />';
        }

        function remove_plugin_metaboxes() {
            remove_meta_box( 'mymetabox_revslider_0', 'haru_actor', 'normal' );
            remove_meta_box( 'handlediv', 'haru_actor', 'normal' );
            remove_meta_box( 'commentsdiv', 'haru_actor', 'normal' );
        }

        function haru_actor() {
            $prefix = $this->prefix;

            $actor_slug = haru_vidi_get_actor_slug();

            $labels = array(
                'menu_name'          => esc_html__( 'Actors', 'haru-vidi' ),
                'singular_name'      => esc_html__( 'Single Actor', 'haru-vidi' ),
                'name'               => esc_html__( 'Actor', 'haru-vidi' ),
                'add_new'            => esc_html__( 'Add New', 'haru-vidi' ) ,
                'add_new_item'       => esc_html__( 'Add New Actor', 'haru-vidi' ) ,
                'edit_item'          => esc_html__( 'Edit Actor', 'haru-vidi' ) ,
                'new_item'           => esc_html__( 'Add New Actor', 'haru-vidi' ) ,
                'view_item'          => esc_html__( 'View Actor', 'haru-vidi' ) ,
                'search_items'       => esc_html__( 'Search Actor', 'haru-vidi' ) ,
                'not_found'          => esc_html__( 'No Actor items found', 'haru-vidi' ) ,
                'not_found_in_trash' => esc_html__( 'No Actor items found in trash', 'haru-vidi' ) ,
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display Actor', 'haru-vidi' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_in_rest'          => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-businessperson',
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
                    'slug'          => $actor_slug,
                    'with_front'    => false
                ) ,
            );
            register_post_type( 'haru_actor', $args );

            // Register a taxonomy for Actor Categories.
            $actor_category_slug = haru_vidi_get_actor_category_slug();

            $category_labels = array(
                'name'                          => esc_html__( 'Actor Categories', 'haru-vidi' ) ,
                'singular_name'                 => esc_html__( 'Actor Category', 'haru-vidi' ) ,
                'menu_name'                     => esc_html__( 'Categories', 'haru-vidi' ) ,
                'all_items'                     => esc_html__( 'All Actor Categories', 'haru-vidi' ) ,
                'edit_item'                     => esc_html__( 'Edit Actor Category', 'haru-vidi' ) ,
                'view_item'                     => esc_html__( 'View Actor Category', 'haru-vidi' ) ,
                'update_item'                   => esc_html__( 'Update Actor Category', 'haru-vidi' ) ,
                'add_new_item'                  => esc_html__( 'Add New Actor Category', 'haru-vidi' ) ,
                'new_item_name'                 => esc_html__( 'New Actor Category Name', 'haru-vidi' ) ,
                'parent_item'                   => esc_html__( 'Parent Actor Category', 'haru-vidi' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Actor Category:', 'haru-vidi' ) ,
                'search_items'                  => esc_html__( 'Search Actor Categories', 'haru-vidi' ) ,
                'popular_items'                 => esc_html__( 'Popular Actor Categories', 'haru-vidi' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Actor Categories with commas', 'haru-vidi' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Actor Categories', 'haru-vidi' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Actor Categories', 'haru-vidi' ) ,
                'not_found'                     => esc_html__( 'No Actor Categories found', 'haru-vidi' ) ,
            );

            $category_args = array(
                'labels'            => $category_labels,
                'public'            => false,
                'show_in_rest'      => true,
                'show_ui'           => true,
                'show_in_nav_menus' => true,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => true,
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => $actor_category_slug,
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('actor_category', array(
                'haru_actor'
            ) , $category_args);
        }

        // Add columns to Actor
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
                    $terms = get_the_terms( $post_id, 'actor_category' );
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
            if ( $post->post_type == 'haru_actor' ) {
                $template_path = haru_vidi_posttype_get_template('vidi/actor/'. 'single-actor' . '.php', array(), '', '');

                return $template_path;
            }

            return $single;
        }

        function haru_archive_template($archive_template) {
            $post_type =  get_post_type();

            if ( ( is_archive() || is_tax() ) && isset($post_type) && $post_type == 'haru_actor'  ) {
                $template_path = haru_vidi_posttype_get_template('vidi/actor/'. 'archive-actor' . '.php', array(), '', '');

                return $template_path;
            }

            return $archive_template;
        }

        // Save actor
        function haru_save_actor() {
            global $post;

            if ( !empty($post) ) {
                $video_ids = $_POST['haru_actor_attached_videos'];
                $video_ids = explode(",", $video_ids);
                $video_ids_current = $_POST['haru_actor_attached_videos-current']; // attached-posts-ids
                $video_ids_current = explode(",", $video_ids_current);
                $video_ids_add = array_diff($video_ids, $video_ids_current);
                $video_ids_delete = array_diff($video_ids_current, $video_ids);
                
                if ( !empty($video_ids_add) ) {
                    foreach ( $video_ids_add as $video_id ) {
                        $video_actor = '';
                        $video_actor = get_post_meta( $video_id, 'haru_video_attached_actors', false );

                        if ( !empty($video_actor) ) {
                            $video_actor = $video_actor[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( !in_array( (string)$post->ID, $video_actor ) ) {
                            array_push($video_actor, (string)$post->ID);
                        } 

                        update_post_meta( (int)$video_id, 'haru_video_attached_actors', $video_actor );
                    }
                }
                if ( !empty($video_ids_delete) ) {
                    foreach ( $video_ids_delete as $video_id ) {
                        $video_actor = '';
                        $video_actor = get_post_meta( $video_id, 'haru_video_attached_actors', false );

                        if ( !empty($video_actor) ) {
                            $video_actor = $video_actor[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( in_array( (string)$post->ID, $video_actor ) ) {
                            if ( ($key = array_search((string)$post->ID, $video_actor)) !== false ) {
                                unset($video_actor[$key]);
                            }
                        }

                        update_post_meta( (int)$video_id, 'haru_video_attached_actors', $video_actor );
                    }
                }

                // Series
                $series_ids = $_POST['haru_actor_attached_seriess'];
                $series_ids = explode(",", $series_ids);
                $series_ids_current = $_POST['haru_actor_attached_seriess-current']; // attached-posts-ids
                $series_ids_current = explode(",", $series_ids_current);
                $series_ids_add = array_diff($series_ids, $series_ids_current);
                $series_ids_delete = array_diff($series_ids_current, $series_ids);
                
                if ( !empty($series_ids_add) ) {
                    foreach ( $series_ids_add as $series_id ) {
                        $series_actor = '';
                        $series_actor = get_post_meta( $series_id, 'haru_series_attached_actors', false );

                        if ( !empty($series_actor) ) {
                            $series_actor = $series_actor[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( !in_array( (string)$post->ID, $series_actor ) ) {
                            array_push($series_actor, (string)$post->ID);
                        }

                        update_post_meta( (int)$series_id, 'haru_series_attached_actors', $series_actor );
                    }
                }
                if ( !empty($series_ids_delete) ) {
                    foreach ( $series_ids_delete as $series_id ) {
                        $series_actor = '';
                        $series_actor = get_post_meta( $series_id, 'haru_series_attached_actors', false );

                        if ( !empty($series_actor) ) {
                            $series_actor = $series_actor[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( in_array( (string)$post->ID, $series_actor ) ) {
                            if ( ($key = array_search((string)$post->ID, $series_actor)) !== false ) {
                                unset($series_actor[$key]);
                            }
                        }

                        update_post_meta( (int)$series_id, 'haru_series_attached_actors', $series_actor );
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

    new Haru_Vidi_Actor_Post_Type;
}