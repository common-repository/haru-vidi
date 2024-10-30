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

if ( ! class_exists( 'Haru_Vidi_Video_Post_Type' ) ) {
    class Haru_Vidi_Video_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'haru_video';

            add_action( 'init', array( $this, 'haru_video' ), 5);
            add_action( 'save_post_haru_video', array( $this, 'haru_save_video' ) );

            if ( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                add_filter( 'manage_haru_video_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_haru_video_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }

            // Set custom posttype templates
            add_filter( 'single_template', array( $this, 'haru_single_template' ) ); // Single template
            add_filter( 'archive_template',array( $this, 'haru_archive_template' ) ); // Archive template
            add_filter( 'template_include', array( $this, 'haru_taxonomy_template') ); // Taxonomy template

            // Add permalink settings slug
            add_action( 'load-options-permalink.php', array( $this, 'haru_load_permalinks' ) );
        }

        function haru_load_permalinks() {
            if ( isset( $_POST['haru_video_base'] ) ) {
                update_option( 'haru_video_base', sanitize_title_with_dashes( $_POST['haru_video_base'] ) );
            }

            if ( isset( $_POST['haru_video_category_base'] ) ) {
                update_option( 'haru_video_category_base', sanitize_title_with_dashes( $_POST['haru_video_category_base'] ) );
            }

            if ( isset( $_POST['haru_video_tag_base'] ) ) {
                update_option( 'haru_video_tag_base', sanitize_title_with_dashes( $_POST['haru_video_tag_base'] ) );
            }

            if ( isset( $_POST['haru_video_label_base'] ) ) {
                update_option( 'haru_video_label_base', sanitize_title_with_dashes( $_POST['haru_video_label_base'] ) );
            }

            // Add a settings field to the permalink page
            add_settings_field( 
                'haru_video_base', 
                esc_html__( 'Video base', 'haru-vidi' ), 
                array( $this, 'haru_field_callback' ), 
                'permalink', 
                'haru_settings_vidi',
                array( // The $args
                    'haru_video_base' // Should match Option ID
                )
            );

            add_settings_field( 
                'haru_video_category_base', 
                esc_html__( 'Video category base', 'haru-vidi' ), 
                array( $this, 'haru_field_callback' ), 
                'permalink', 
                'haru_settings_vidi',
                array( // The $args
                    'haru_video_category_base' // Should match Option ID
                )
            );

            add_settings_field( 
                'haru_video_tag_base', 
                esc_html__( 'Video tag base', 'haru-vidi' ), 
                array( $this, 'haru_field_callback' ), 
                'permalink', 
                'haru_settings_vidi',
                array( // The $args
                    'haru_video_tag_base' // Should match Option ID
                )
            );

            add_settings_field( 
                'haru_video_label_base', 
                esc_html__( 'Video label base', 'haru-vidi' ), 
                array( $this, 'haru_field_callback' ), 
                'permalink', 
                'haru_settings_vidi',
                array( // The $args
                    'haru_video_label_base' // Should match Option ID
                )
            );
        }

        function haru_field_callback( $args ) {  
            $value = get_option( $args[0] );

            echo '<input type="text" value="' . esc_attr( $value ) . '" name="' . $args[0] . '" id="' . $args[0] . '" class="regular-text" />';
        }

        function remove_plugin_metaboxes() {
            remove_meta_box( 'mymetabox_revslider_0', 'haru_video', 'normal' );
            remove_meta_box( 'handlediv', 'haru_video', 'normal' );
            remove_meta_box( 'commentsdiv', 'haru_video', 'normal' );
        }

        function haru_video() {
            $prefix = $this->prefix;

            $video_slug = haru_vidi_get_video_slug();

            $labels = array(
                'menu_name'          => esc_html__( 'Videos', 'haru-vidi' ),
                'singular_name'      => esc_html__( 'Single Video', 'haru-vidi' ),
                'name'               => esc_html__( 'Video', 'haru-vidi' ),
                'add_new'            => esc_html__( 'Add New', 'haru-vidi' ) ,
                'add_new_item'       => esc_html__( 'Add New Video', 'haru-vidi' ) ,
                'edit_item'          => esc_html__( 'Edit Video', 'haru-vidi' ) ,
                'new_item'           => esc_html__( 'Add New Video', 'haru-vidi' ) ,
                'view_item'          => esc_html__( 'View Video', 'haru-vidi' ) ,
                'search_items'       => esc_html__( 'Search Video', 'haru-vidi' ) ,
                'not_found'          => esc_html__( 'No Video items found', 'haru-vidi' ) ,
                'not_found_in_trash' => esc_html__( 'No Video items found in trash', 'haru-vidi' ) ,
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display Video', 'haru-vidi' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_in_rest'          => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-format-video',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'supports'              => array( 'title', 'editor', 'thumbnail', 'comments' ),
                'rewrite'           => array(
                    'slug'          => $video_slug, // use / to remove slug
                    'with_front'    => false
                ) ,
            );
            register_post_type( 'haru_video', $args );

            // Register a taxonomy for Video Categories.
            $video_category_slug = haru_vidi_get_video_category_slug();

            $category_labels = array(
                'name'                          => esc_html__( 'Video Categories', 'haru-vidi' ) ,
                'singular_name'                 => esc_html__( 'Video Category', 'haru-vidi' ) ,
                'menu_name'                     => esc_html__( 'Video Categories', 'haru-vidi' ) ,
                'all_items'                     => esc_html__( 'All Video Categories', 'haru-vidi' ) ,
                'edit_item'                     => esc_html__( 'Edit Video Category', 'haru-vidi' ) ,
                'view_item'                     => esc_html__( 'View Video Category', 'haru-vidi' ) ,
                'update_item'                   => esc_html__( 'Update Video Category', 'haru-vidi' ) ,
                'add_new_item'                  => esc_html__( 'Add New Video Category', 'haru-vidi' ) ,
                'new_item_name'                 => esc_html__( 'New Video Category Name', 'haru-vidi' ) ,
                'parent_item'                   => esc_html__( 'Parent Video Category', 'haru-vidi' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Video Category:', 'haru-vidi' ) ,
                'search_items'                  => esc_html__( 'Search Video Categories', 'haru-vidi' ) ,
                'popular_items'                 => esc_html__( 'Popular Video Categories', 'haru-vidi' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Video Categories with commas', 'haru-vidi' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Video Categories', 'haru-vidi' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Video Categories', 'haru-vidi' ) ,
                'not_found'                     => esc_html__( 'No Video Categories found', 'haru-vidi' ) ,
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
                    'slug'          => $video_category_slug,
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('video_category', array(
                'haru_video'
            ) , $category_args);

            // Register a taxonomy for Video Tags.
            $video_tag_slug = haru_vidi_get_video_tag_slug();

            $tag_labels = array(
                'name'                          => esc_html__( 'Video Tags', 'haru-vidi' ) ,
                'singular_name'                 => esc_html__( 'Video Tag', 'haru-vidi' ) ,
                'menu_name'                     => esc_html__( 'Tags', 'haru-vidi' ) ,
                'all_items'                     => esc_html__( 'All Video Tags', 'haru-vidi' ) ,
                'edit_item'                     => esc_html__( 'Edit Video Tag', 'haru-vidi' ) ,
                'view_item'                     => esc_html__( 'View Video Tag', 'haru-vidi' ) ,
                'update_item'                   => esc_html__( 'Update Video Tag', 'haru-vidi' ) ,
                'add_new_item'                  => esc_html__( 'Add New Video Tag', 'haru-vidi' ) ,
                'new_item_name'                 => esc_html__( 'New Video Tag Name', 'haru-vidi' ) ,
                'parent_item'                   => esc_html__( 'Parent Video Tag', 'haru-vidi' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Video Tag:', 'haru-vidi' ) ,
                'search_items'                  => esc_html__( 'Search Video Tags', 'haru-vidi' ) ,
                'popular_items'                 => esc_html__( 'Popular Video Tags', 'haru-vidi' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Video Tags with commas', 'haru-vidi' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Video Tags', 'haru-vidi' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Video Tags', 'haru-vidi' ) ,
                'not_found'                     => esc_html__( 'No Video Tags found', 'haru-vidi' ) ,
            );

            $tag_args = array(
                'labels'            => $tag_labels,
                'public'            => true,
                'show_in_rest'      => true,
                'show_ui'           => true,
                'show_in_nav_menus' => true,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => false,
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => $video_tag_slug,
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('video_tag', array(
                'haru_video'
            ) , $tag_args);

            // Label like hot, new, trend
            $video_label_slug = haru_vidi_get_video_label_slug();

            $label_labels = array(
                'name'                          => esc_html__( 'Video Labels', 'haru-vidi' ) ,
                'singular_name'                 => esc_html__( 'Video Label', 'haru-vidi' ) ,
                'menu_name'                     => esc_html__( 'Labels', 'haru-vidi' ) ,
                'all_items'                     => esc_html__( 'All Video Labels', 'haru-vidi' ) ,
                'edit_item'                     => esc_html__( 'Edit Video Label', 'haru-vidi' ) ,
                'view_item'                     => esc_html__( 'View Video Label', 'haru-vidi' ) ,
                'update_item'                   => esc_html__( 'Update Video Label', 'haru-vidi' ) ,
                'add_new_item'                  => esc_html__( 'Add New Video Label', 'haru-vidi' ) ,
                'new_item_name'                 => esc_html__( 'New Video Label Name', 'haru-vidi' ) ,
                'parent_item'                   => esc_html__( 'Parent Video Label', 'haru-vidi' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Video Label:', 'haru-vidi' ) ,
                'search_items'                  => esc_html__( 'Search Video Labels', 'haru-vidi' ) ,
                'popular_items'                 => esc_html__( 'Popular Video Labels', 'haru-vidi' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Video Labels with commas', 'haru-vidi' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Video Labels', 'haru-vidi' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Video Labels', 'haru-vidi' ) ,
                'not_found'                     => esc_html__( 'No Video Labels found', 'haru-vidi' ) ,
            );

            $label_args = array(
                'labels'            => $label_labels,
                'public'            => true,
                'show_in_rest'      => true,
                'show_ui'           => true,
                'show_in_nav_menus' => true,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => false,
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => $video_label_slug,
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('video_label', array(
                'haru_video'
            ) , $label_args);
        }

        // Add columns to Video
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
                    $terms = get_the_terms( $post_id, 'video_category' );
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
            if ( $post->post_type == 'haru_video' ) {
                $template_path = haru_vidi_posttype_get_template('vidi/video/'. 'single-video' . '.php', array(), '', '');

                return $template_path;
            }

            return $single;
        }

        function haru_archive_template($archive_template) {
            $post_type =  get_post_type();

            if ( is_archive() && isset($post_type) && $post_type == 'haru_video'  ) {
                $template_path = haru_vidi_posttype_get_template('vidi/video/'. 'archive-video' . '.php', array(), '', '');

                return $template_path;
            }

            return $archive_template;
        }

        function haru_taxonomy_template($archive_template) {
            global $wp_query;

            $post_type =  get_post_type();

            if ( ( is_tax( 'video_category' ) || is_tax( 'video_tag' ) ) && isset($post_type) && $post_type == 'haru_video'  ) {
                $template_path = haru_vidi_posttype_get_template('vidi/video/'. 'archive-video' . '.php', array(), '', '');

                return $template_path;
            }

            // For search video: https://wordpress.stackexchange.com/questions/89886/how-to-create-a-custom-search-for-custom-post-type
            if ( $wp_query->is_search && ( get_query_var('post_type') == 'haru_video' ) ) {
                $template_path = haru_vidi_posttype_get_template('vidi/video/'. 'archive-video' . '.php', array(), '', '');

                return $template_path;
            }   

            return $archive_template;
        }

        // Save video
        function haru_save_video() {
            global $post;

            if ( !empty($post) && !empty($_POST) ) {
                $playlist_ids = $_POST['haru_video_attached_playlists'];
                $playlist_ids = explode(",", $playlist_ids);
                $playlist_ids_current = $_POST['haru_video_attached_playlists-current']; // attached-posts-ids
                $playlist_ids_current = explode(",", $playlist_ids_current);
                $playlist_ids_add = array_diff($playlist_ids, $playlist_ids_current);
                $playlist_ids_delete = array_diff($playlist_ids_current, $playlist_ids);
                
                if ( !empty($playlist_ids_add) ) {
                    foreach ( $playlist_ids_add as $playlist_id ) {
                        $playlist_video = '';
                        $playlist_video = get_post_meta( $playlist_id, 'haru_playlist_attached_videos', false );

                        if ( !empty($playlist_video) ) {
                            $playlist_video = $playlist_video[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( !in_array( (string)$post->ID, $playlist_video ) ) {
                            array_push($playlist_video, (string)$post->ID);
                        }

                        update_post_meta( (int)$playlist_id, 'haru_playlist_attached_videos', $playlist_video );
                    }
                }
                if ( !empty($playlist_ids_delete) ) {
                    foreach ( $playlist_ids_delete as $playlist_id ) {
                        $playlist_video = '';
                        $playlist_video = get_post_meta( $playlist_id, 'haru_playlist_attached_videos', false );

                        if ( !empty($playlist_video) ) {
                            $playlist_video = $playlist_video[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( in_array( (string)$post->ID, $playlist_video ) ) {
                            if ( ($key = array_search((string)$post->ID, $playlist_video)) !== false ) {
                                unset($playlist_video[$key]);
                            }
                        }

                        update_post_meta( (int)$playlist_id, 'haru_playlist_attached_videos', $playlist_video );
                    }
                }

                // Series
                $series_ids = $_POST['haru_video_attached_seriess'];
                $series_ids = explode(",", $series_ids);
                $series_ids_current = $_POST['haru_video_attached_seriess-current']; // attached-posts-ids
                $series_ids_current = explode(",", $series_ids_current);
                $series_ids_add = array_diff($series_ids, $series_ids_current);
                $series_ids_delete = array_diff($series_ids_current, $series_ids);
                
                if ( !empty($series_ids_add) ) {
                    foreach ( $series_ids_add as $series_id ) {
                        $series_video = '';
                        $series_video = get_post_meta( $series_id, 'haru_series_attached_videos', false );

                        if ( !empty($series_video) ) {
                            $series_video = $series_video[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( !in_array( (string)$post->ID, $series_video ) ) {
                            array_push($series_video, (string)$post->ID);
                        }

                        update_post_meta( (int)$series_id, 'haru_series_attached_videos', $series_video );
                    }
                }
                if ( !empty($series_ids_delete) ) {
                    foreach ( $series_ids_delete as $series_id ) {
                        $series_video = '';
                        $series_video = get_post_meta( $series_id, 'haru_series_attached_videos', false );

                        if ( !empty($series_video) ) {
                            $series_video = $series_video[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( in_array( (string)$post->ID, $series_video ) ) {
                            if ( ($key = array_search((string)$post->ID, $series_video)) !== false ) {
                                unset($series_video[$key]);
                            }
                        }

                        update_post_meta( (int)$series_id, 'haru_series_attached_videos', $series_video );
                    }
                }

                // Channels
                $channel_ids = $_POST['haru_video_attached_channels'];
                $channel_ids = explode(",", $channel_ids);
                $channel_ids_current = $_POST['haru_video_attached_channels-current']; // attached-posts-ids
                $channel_ids_current = explode(",", $channel_ids_current);
                $channel_ids_add = array_diff($channel_ids, $channel_ids_current);
                $channel_ids_delete = array_diff($channel_ids_current, $channel_ids);
                
                if ( !empty($channel_ids_add) ) {
                    foreach ( $channel_ids_add as $channel_id ) {
                        $channel_video = '';
                        $channel_video = get_post_meta( $channel_id, 'haru_channel_attached_videos', false );

                        if ( !empty($channel_video) ) {
                            $channel_video = $channel_video[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( !in_array( (string)$post->ID, $channel_video ) ) {
                            array_push($channel_video, (string)$post->ID);
                        }

                        update_post_meta( (int)$channel_id, 'haru_channel_attached_videos', $channel_video );
                    }
                }
                if ( !empty($channel_ids_delete) ) {
                    foreach ( $channel_ids_delete as $channel_id ) {
                        $channel_video = '';
                        $channel_video = get_post_meta( $channel_id, 'haru_channel_attached_videos', false );

                        if ( !empty($channel_video) ) {
                            $channel_video = $channel_video[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( in_array( (string)$post->ID, $channel_video ) ) {
                            if ( ($key = array_search((string)$post->ID, $channel_video)) !== false ) {
                                unset($channel_video[$key]);
                            }
                        }

                        update_post_meta( (int)$channel_id, 'haru_channel_attached_videos', $channel_video );
                    }
                }

                // Actors
                $actor_ids = $_POST['haru_video_attached_actors'];
                $actor_ids = explode(",", $actor_ids);
                $actor_ids_current = $_POST['haru_video_attached_actors-current']; // attached-posts-ids
                $actor_ids_current = explode(",", $actor_ids_current);
                $actor_ids_add = array_diff($actor_ids, $actor_ids_current);
                $actor_ids_delete = array_diff($actor_ids_current, $actor_ids);
                
                if ( !empty($actor_ids_add) ) {
                    foreach ( $actor_ids_add as $actor_id ) {
                        $actor_video = '';
                        $actor_video = get_post_meta( $actor_id, 'haru_actor_attached_videos', false );

                        if ( !empty($actor_video) ) {
                            $actor_video = $actor_video[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( !in_array( (string)$post->ID, $actor_video ) ) {
                            array_push($actor_video, (string)$post->ID);
                        }

                        update_post_meta( (int)$actor_id, 'haru_actor_attached_videos', $actor_video );
                    }
                }
                if ( !empty($actor_ids_delete) ) {
                    foreach ( $actor_ids_delete as $actor_id ) {
                        $actor_video = '';
                        $actor_video = get_post_meta( $actor_id, 'haru_actor_attached_videos', false );

                        if ( !empty($actor_video) ) {
                            $actor_video = $actor_video[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( in_array( (string)$post->ID, $actor_video ) ) {
                            if ( ($key = array_search((string)$post->ID, $actor_video)) !== false ) {
                                unset($actor_video[$key]);
                            }
                        }

                        update_post_meta( (int)$actor_id, 'haru_actor_attached_videos', $actor_video );
                    }
                }

                // Directors
                $director_ids = $_POST['haru_video_attached_directors'];
                $director_ids = explode(",", $director_ids);
                $director_ids_current = $_POST['haru_video_attached_directors-current']; // attached-posts-ids
                $director_ids_current = explode(",", $director_ids_current);
                $director_ids_add = array_diff($director_ids, $director_ids_current);
                $director_ids_delete = array_diff($director_ids_current, $director_ids);
                
                if ( !empty($director_ids_add) ) {
                    foreach ( $director_ids_add as $director_id ) {
                        $director_video = '';
                        $director_video = get_post_meta( $director_id, 'haru_director_attached_videos', false );

                        if ( !empty($director_video) ) {
                            $director_video = $director_video[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( !in_array( (string)$post->ID, $director_video ) ) {
                            array_push($director_video, (string)$post->ID);
                        }

                        update_post_meta( (int)$director_id, 'haru_director_attached_videos', $director_video );
                    }
                }
                if ( !empty($director_ids_delete) ) {
                    foreach ( $director_ids_delete as $director_id ) {
                        $director_video = '';
                        $director_video = get_post_meta( $director_id, 'haru_director_attached_videos', false );

                        if ( !empty($director_video) ) {
                            $director_video = $director_video[0]; // @TODO: first time array empty (Duplicator doesn't work)
                        }

                        if ( in_array( (string)$post->ID, $director_video ) ) {
                            if ( ($key = array_search((string)$post->ID, $director_video)) !== false ) {
                                unset($director_video[$key]);
                            }
                        }

                        update_post_meta( (int)$director_id, 'haru_director_attached_videos', $director_video );
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

    new Haru_Vidi_Video_Post_Type;
}