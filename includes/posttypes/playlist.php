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

if ( ! class_exists( 'Haru_Vidi_Playlist_Post_Type' ) ) {
    class Haru_Vidi_Playlist_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'haru_playlist';

            add_action( 'init', array( $this, 'haru_playlist'), '5' );
            add_action( 'save_post_haru_playlist', array( $this, 'haru_save_playlist' ) );

            if ( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                add_filter( 'manage_haru_playlist_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_haru_playlist_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }

            // Set custom posttype templates
            add_filter( 'single_template', array( $this, 'haru_single_template' ) ); // Single template
            add_filter( 'archive_template', array( $this, 'haru_archive_template' ) ); // Archive template
            add_filter( 'template_include', array( $this, 'haru_taxonomy_template' ) ); // Taxonomy template

            // Add permalink settings slug
            add_action( 'load-options-permalink.php', array( $this, 'haru_load_permalinks' ) );
        }

        function haru_load_permalinks() {
            if ( isset( $_POST['haru_playlist_base'] ) ) {
                update_option( 'haru_playlist_base', sanitize_title_with_dashes( $_POST['haru_playlist_base'] ) );
            }

            if ( isset( $_POST['haru_playlist_category_base'] ) ) {
                update_option( 'haru_playlist_category_base', sanitize_title_with_dashes( $_POST['haru_playlist_category_base'] ) );
            }

            // Add a settings field to the permalink page
            add_settings_field(
                'haru_playlist_base', 
                esc_html__( 'Playlist base', 'haru-vidi' ), 
                array( $this, 'haru_field_callback' ), 
                'permalink',
                'haru_settings_vidi',
                array( // The $args
                    'haru_playlist_base' // Should match Option ID
                )
            );

            add_settings_field( 
                'haru_playlist_category_base', 
                esc_html__( 'Playlist category base', 'haru-vidi' ), 
                array( $this, 'haru_field_callback' ), 
                'permalink', 
                'haru_settings_vidi',
                array( // The $args
                    'haru_playlist_category_base' // Should match Option ID
                )
            );
        }

        function haru_field_callback( $args ) {  
            $value = get_option( $args[0] );

            echo '<input type="text" value="' . esc_attr( $value ) . '" name="' . $args[0] . '" id="' . $args[0] . '" class="regular-text" />';
        }

        function remove_plugin_metaboxes() {
            remove_meta_box( 'mymetabox_revslider_0', 'haru_playlist', 'normal' );
            remove_meta_box( 'handlediv', 'haru_playlist', 'normal' );
            remove_meta_box( 'commentsdiv', 'haru_playlist', 'normal' );
        }

        function haru_playlist() {
            $prefix = $this->prefix;

            $playlist_slug = haru_vidi_get_playlist_slug();

            $labels = array(
                'menu_name'          => esc_html__( 'Playlists', 'haru-vidi' ),
                'singular_name'      => esc_html__( 'Single Playlist', 'haru-vidi' ),
                'name'               => esc_html__( 'Playlist', 'haru-vidi' ),
                'add_new'            => esc_html__( 'Add New', 'haru-vidi' ) ,
                'add_new_item'       => esc_html__( 'Add New Playlist', 'haru-vidi' ) ,
                'edit_item'          => esc_html__( 'Edit Playlist', 'haru-vidi' ) ,
                'new_item'           => esc_html__( 'Add New Playlist', 'haru-vidi' ) ,
                'view_item'          => esc_html__( 'View Playlist', 'haru-vidi' ) ,
                'search_items'       => esc_html__( 'Search Playlist', 'haru-vidi' ) ,
                'not_found'          => esc_html__( 'No Playlist items found', 'haru-vidi' ) ,
                'not_found_in_trash' => esc_html__( 'No Playlist items found in trash', 'haru-vidi' ) ,
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display Playlist', 'haru-vidi' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_in_rest'          => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-align-right',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'supports'              => array( 'title', 'editor', 'thumbnail' ),
                'rewrite'           => array(
                    'slug'          => $playlist_slug,
                    'with_front'    => false
                ) ,
            );
            register_post_type( 'haru_playlist', $args );

            // Register a taxonomy for Playlist Categories.
            $playlist_category_slug = haru_vidi_get_playlist_category_slug();

            $category_labels = array(
                'name'                          => esc_html__( 'Playlist Categories', 'haru-vidi' ) ,
                'singular_name'                 => esc_html__( 'Playlist Category', 'haru-vidi' ) ,
                'menu_name'                     => esc_html__( 'Categories', 'haru-vidi' ) ,
                'all_items'                     => esc_html__( 'All Playlist Categories', 'haru-vidi' ) ,
                'edit_item'                     => esc_html__( 'Edit Playlist Category', 'haru-vidi' ) ,
                'view_item'                     => esc_html__( 'View Playlist Category', 'haru-vidi' ) ,
                'update_item'                   => esc_html__( 'Update Playlist Category', 'haru-vidi' ) ,
                'add_new_item'                  => esc_html__( 'Add New Playlist Category', 'haru-vidi' ) ,
                'new_item_name'                 => esc_html__( 'New Playlist Category Name', 'haru-vidi' ) ,
                'parent_item'                   => esc_html__( 'Parent Playlist Category', 'haru-vidi' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Playlist Category:', 'haru-vidi' ) ,
                'search_items'                  => esc_html__( 'Search Playlist Categories', 'haru-vidi' ) ,
                'popular_items'                 => esc_html__( 'Popular Playlist Categories', 'haru-vidi' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Playlist Categories with commas', 'haru-vidi' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Playlist Categories', 'haru-vidi' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Playlist Categories', 'haru-vidi' ) ,
                'not_found'                     => esc_html__( 'No Playlist Categories found', 'haru-vidi' ) ,
            );

            $category_args = array(
                'labels'            => $category_labels,
                'public'            => true,
                'show_in_rest'      => true,
                'show_ui'           => true,
                'show_in_nav_menus' => true,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => true,
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => $playlist_category_slug,
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('playlist_category', array(
                'haru_playlist'
            ) , $category_args);
        }

        // Add columns to Playlist
        function add_columns($columns) {
            unset(
                $columns['post-format'],
                $columns['title'],
                $columns['date']
            );
            $cols = array_merge(array('cb' => ('')), $columns);
            $cols = array_merge($cols, array('title' => esc_html__( 'Title', 'haru-vidi' )));
            $cols = array_merge($cols, array('category' => esc_html__( 'Category', 'haru-vidi' )));
            $cols = array_merge($cols, array('thumbnail' => esc_html__( 'Thumbnail', 'haru-vidi' )));
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
                    $terms = get_the_terms( $post_id, 'playlist_category' );
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
            if ( $post->post_type == 'haru_playlist' ) {
                $template_path = haru_vidi_posttype_get_template('vidi/playlist/'. 'single-playlist' . '.php', array(), '', '');

                return $template_path;
            }

            return $single;
        }

        function haru_archive_template($archive_template) {
            $post_type =  get_post_type();

            if ( is_archive() && isset($post_type) && $post_type == 'haru_playlist'  ) {
                $template_path = haru_vidi_posttype_get_template('vidi/playlist/' . 'archive-playlist' . '.php', array(), '', '');

                return $template_path;
            }

            return $archive_template;
        }

        function haru_taxonomy_template($archive_template) {
            $post_type =  get_post_type();

            if ( is_tax( 'playlist_category' ) && isset($post_type) && $post_type == 'haru_playlist'  ) {
                $template_path = haru_vidi_posttype_get_template('vidi/playlist/' . 'archive-playlist' . '.php', array(), '', '');

                return $template_path;
            }

            return $archive_template;
        }

        // Save playlist
        function haru_save_playlist() {
            global $post;

            if ( !empty($post) ) {
                // Videos
                $video_ids = $_POST['haru_playlist_attached_videos'];
                $video_ids = explode(",", $video_ids);
                $video_ids_current = $_POST['haru_playlist_attached_videos-current']; // attached-posts-ids
                $video_ids_current = explode(",", $video_ids_current);
                $video_ids_add = array_diff($video_ids, $video_ids_current);
                $video_ids_delete = array_diff($video_ids_current, $video_ids);
                
                if ( !empty($video_ids_add) ) {
                    foreach ( $video_ids_add as $video_id ) {
                        $video_playlist = '';
                        $video_playlist = get_post_meta( $video_id, 'haru_video_attached_playlists', false );

                        if ( !empty($video_playlist) ) {
                            $video_playlist = $video_playlist[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( !in_array( (string)$post->ID, $video_playlist ) ) {
                            array_push($video_playlist, (string)$post->ID);
                        } 

                        update_post_meta( (int)$video_id, 'haru_video_attached_playlists', $video_playlist );
                    }
                }
                if ( !empty($video_ids_delete) ) {
                    foreach ( $video_ids_delete as $video_id ) {
                        $video_playlist = '';
                        $video_playlist = get_post_meta( $video_id, 'haru_video_attached_playlists', false );

                        if ( !empty($video_playlist) ) {
                            $video_playlist = $video_playlist[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( in_array( (string)$post->ID, $video_playlist ) ) {
                            if ( ($key = array_search((string)$post->ID, $video_playlist)) !== false ) {
                                unset($video_playlist[$key]);
                            }
                        }

                        update_post_meta( (int)$video_id, 'haru_video_attached_playlists', $video_playlist );
                    }
                }

                // Channels
                $channel_ids = $_POST['haru_playlist_attached_channels'];
                $channel_ids = explode(",", $channel_ids);
                $channel_ids_current = $_POST['haru_playlist_attached_channels-current']; // attached-posts-ids
                $channel_ids_current = explode(",", $channel_ids_current);
                $channel_ids_add = array_diff($channel_ids, $channel_ids_current);
                $channel_ids_delete = array_diff($channel_ids_current, $channel_ids);
                
                if ( !empty($channel_ids_add) ) {
                    foreach ( $channel_ids_add as $channel_id ) {
                        $channel_playlist = '';
                        $channel_playlist = get_post_meta( $channel_id, 'haru_channel_attached_playlists', false );

                        if ( !empty($channel_playlist) ) {
                            $channel_playlist = $channel_playlist[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( !in_array( (string)$post->ID, $channel_playlist ) ) {
                            array_push($channel_playlist, (string)$post->ID);
                        }

                        update_post_meta( (int)$channel_id, 'haru_channel_attached_playlists', $channel_playlist );
                    }
                }
                if ( !empty($channel_ids_delete) ) {
                    foreach ( $channel_ids_delete as $channel_id ) {
                        $channel_playlist = '';
                        $channel_playlist = get_post_meta( $channel_id, 'haru_channel_attached_playlists', false );

                        if ( !empty($channel_playlist) ) {
                            $channel_playlist = $channel_playlist[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( in_array( (string)$post->ID, $channel_playlist ) ) {
                            if ( ($key = array_search((string)$post->ID, $channel_playlist)) !== false ) {
                                unset($channel_playlist[$key]);
                            }
                        }

                        update_post_meta( (int)$channel_id, 'haru_channel_attached_playlists', $channel_playlist );
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

    new Haru_Vidi_Playlist_Post_Type;
}