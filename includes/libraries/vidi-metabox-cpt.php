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

// Taxonomy Metabox
if ( !function_exists( 'haru_register_taxonomy_metabox' ) ) {
    function haru_register_taxonomy_metabox() { 
        /** 
         * Metabox to add fields to categories and tags 
         */ 

        $video_label = new_cmb2_box( array( 
            'id'               => 'haru_video_label' . '_edit', 
            'title'            => esc_html__( 'Video Label Metabox', 'haru-vidi' ), // Doesn't output for term boxes 
            'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta 
            'taxonomies'       => array( 'video_label' ), // Tells CMB2 which taxonomies should have these fields 
            'new_term_section' => true, // Will display in the "Add New Category" section 
        ) ); 
      
        $video_label->add_field( array( 
            'name'    => esc_html__( 'Video Label Background', 'haru-vidi' ),
            'id'      => 'haru_video_label' . '_background',
            'type'    => 'colorpicker',
            'default' => '#ffffff',
            'options' => array(
                'alpha' => false, // Make this a rgba color picker.
            ),
        ) ); 
    }

    add_action( 'cmb2_admin_init', 'haru_register_taxonomy_metabox' ); 
}

// Posts, CPT Metabox
if ( !function_exists( 'haru_vidi_field_metaboxes_cpt' ) ) {
    function haru_vidi_field_metaboxes_cpt() {
        // Playlist
        $playlist_meta = new_cmb2_box( array(
            'id'           => 'haru_playlist_attached_videos_field',
            'title'        => esc_html__( 'Add Videos to Playlist', 'haru-vidi' ),
            'object_types' => array( 'haru_playlist' ), // Post type
            'context'      => 'normal',
            'priority'     => 'low',
            'show_names'   => false, // Show field names on the left
        ) );

        $playlist_meta->add_field( array(
            'name'    => esc_html__( 'Attached Videos', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag videos from the left column to the right column to add them to this playlist. You may rearrange the order of the videos in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_playlist_attached_videos',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_video',
                ), // override the get_posts args
            ),
        ) );

        $playlist_meta->add_field( array(
            'name'    => esc_html__( 'Attached Channels', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag channels from the left column to the right column to add them to this playlist. You may rearrange the order of the channels in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_playlist_attached_channels',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_channel',
                ), // override the get_posts args
            ),
        ) );

        // Series
        $series_meta = new_cmb2_box( array(
            'id'           => 'haru_series_attached_videos_field',
            'title'        => esc_html__( 'Add Videos to Series', 'haru-vidi' ),
            'object_types' => array( 'haru_series' ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => false, // Show field names on the left
        ) );

        $series_meta->add_field( array(
            'name'    => esc_html__( 'Attached Videos', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag videos from the left column to the right column to add them to this Series. You may rearrange the order of the videos in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_series_attached_videos',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_video',
                ), // override the get_posts args
            ),
        ) );

        $series_meta->add_field( array(
            'name'    => esc_html__( 'Attached Channels', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag channels from the left column to the right column to add them to this Series. You may rearrange the order of the channels in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_series_attached_channels',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_channel',
                ), // override the get_posts args
            ),
        ) );

        $series_meta->add_field( array(
            'name'    => esc_html__( 'Attached Actors', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag actors from the left column to the right column to add them to this Series. You may rearrange the order of the actors in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_series_attached_actors',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_actor',
                ), // override the get_posts args
            ),
        ) );

        $series_meta->add_field( array(
            'name'    => esc_html__( 'Attached Directors', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag directors from the left column to the right column to add them to this Series. You may rearrange the order of the directors in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_series_attached_directors',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_director',
                ), // override the get_posts args
            ),
        ) );

        // Channel
        $channel_attached_meta = new_cmb2_box( array(
            'id'           => 'haru_channel_attached_videos_field',
            'title'        => esc_html__( 'Add Videos to Channel', 'haru-vidi' ),
            'object_types' => array( 'haru_channel' ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => false, // Show field names on the left
        ) );

        $channel_attached_meta->add_field( array(
            'name'    => esc_html__( 'Attached Videos', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag videos from the left column to the right column to add them to this channel. You may rearrange the order of the videos in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_channel_attached_videos',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_video',
                ), // override the get_posts args
            ),
        ) );

        $channel_attached_meta->add_field( array(
            'name'    => esc_html__( 'Attached Playlists', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag playlists from the left column to the right column to add them to this channel. You may rearrange the order of the playlists in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_channel_attached_playlists',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_playlist',
                ), // override the get_posts args
            ),
        ) );

        $channel_attached_meta->add_field( array(
            'name'    => esc_html__( 'Attached Series', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag series from the left column to the right column to add them to this channel. You may rearrange the order of the series in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_channel_attached_seriess',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_series',
                ), // override the get_posts args
            ),
        ) );

        $channel_meta = new_cmb2_box( array(
            'id'           => 'haru_channel_meta_field',
            'title'        => esc_html__( 'Channel Metaboxes', 'haru-vidi' ),
            'object_types' => array( 'haru_channel' ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ) );

        $channel_meta->add_field( array(
            'name'    => esc_html__( 'Facebook URL', 'haru-vidi' ),
            'id'      => 'haru_' . 'channel_facebook_url',
            'type'    => 'text_url',
            'default' => '',
        ) );

        $channel_meta->add_field( array(
            'name'    => esc_html__( 'Youtube URL', 'haru-vidi' ),
            'id'      => 'haru_' . 'channel_youtube_url',
            'type'    => 'text_url',
            'default' => '',
        ) );

        $channel_meta->add_field( array(
            'name'    => esc_html__( 'Twitter URL', 'haru-vidi' ),
            'id'      => 'haru_' . 'channel_twitter_url',
            'type'    => 'text_url',
            'default' => '',
        ) );

        $channel_meta->add_field( array(
            'name'    => esc_html__( 'Instagram URL', 'haru-vidi' ),
            'id'      => 'haru_' . 'channel_instagram_url',
            'type'    => 'text_url',
            'default' => '',
        ) );

        // Actor
        $actor_meta = new_cmb2_box( array(
            'id'           => 'haru_actor_attached_videos_field',
            'title'        => esc_html__( 'Add Videos to Actor', 'haru-vidi' ),
            'object_types' => array( 'haru_actor' ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => false, // Show field names on the left
        ) );

        $actor_meta->add_field( array(
            'name'    => esc_html__( 'Attached Videos', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag videos from the left column to the right column to add them to this actor. You may rearrange the order of the videos in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_actor_attached_videos',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_video',
                ), // override the get_posts args
            ),
        ) );

        $actor_meta->add_field( array(
            'name'    => esc_html__( 'Attached Series', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag seriess from the left column to the right column to add them to this actor. You may rearrange the order of the seriess in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_actor_attached_seriess',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_series',
                ), // override the get_posts args
            ),
        ) );

        $actor_meta->add_field( array(
            'name' => esc_html__( 'Filmography', 'haru-vidi' ),
            'desc' => esc_html__( 'Insert Filmography of actor.', 'haru-vidi' ),
            'type' => 'title',
            'id'   => 'haru_actor' . '_filmography_title',
        ) );

        $filmography_group_id = $actor_meta->add_field( array(
            'id'          => 'filmography_group',
            'type'        => 'group',
            'repeatable'  => true,
            'options'     => array(
                'group_title'   => 'Filmography {#}',
                'add_button'    => esc_html__( 'Add Another Filmography', 'haru-vidi' ),
                'remove_button' => esc_html__( 'Remove Filmography', 'haru-vidi' ),
                'closed'        => true,  // Repeater fields closed by default - neat & compact.
                'sortable'      => true,  // Allow changing the order of repeated groups.
            ),
        ) );

        $actor_meta->add_group_field( $filmography_group_id, array(
            'id'      => 'haru_actor' . '_filmography_year',
            'name'    => esc_html__( 'Year', 'haru-vidi' ),
            'desc'    => esc_html__( 'Insert Year.', 'haru-vidi' ),
            'type'    => 'text',
        ) );

        $actor_meta->add_group_field( $filmography_group_id, array(
            'id'      => 'haru_actor' . '_filmography_movie',
            'name'    => esc_html__( 'Movie', 'haru-vidi' ),
            'desc'    => esc_html__( 'Insert Movie Name.', 'haru-vidi' ),
            'type'    => 'text',
        ) );

        $actor_meta->add_group_field( $filmography_group_id, array(
            'id'      => 'haru_actor' . '_filmography_character',
            'name'    => esc_html__( 'Character', 'haru-vidi' ),
            'desc'    => esc_html__( 'Insert Character Name.', 'haru-vidi' ),
            'type'    => 'text',
        ) );

        // Director
        $director_meta = new_cmb2_box( array(
            'id'           => 'haru_director_attached_videos_field',
            'title'        => esc_html__( 'Add Videos to Director', 'haru-vidi' ),
            'object_types' => array( 'haru_director' ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => false, // Show field names on the left
        ) );

        $director_meta->add_field( array(
            'name'    => esc_html__( 'Attached Videos', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag videos from the left column to the right column to add them to this director. You may rearrange the order of the videos in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_director_attached_videos',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_video',
                ), // override the get_posts args
            ),
        ) );

        $director_meta->add_field( array(
            'name'    => esc_html__( 'Attached Series', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag seriess from the left column to the right column to add them to this director. You may rearrange the order of the seriess in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_director_attached_seriess',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_series',
                ), // override the get_posts args
            ),
        ) );

        $filmography_group_id_director = $director_meta->add_field( array(
            'id'          => 'filmography_group',
            'type'        => 'group',
            'repeatable'  => true,
            'options'     => array(
                'group_title'   => 'Filmography {#}',
                'add_button'    => esc_html__( 'Add Another Filmography', 'haru-vidi' ),
                'remove_button' => esc_html__( 'Remove Filmography', 'haru-vidi' ),
                'closed'        => true,  // Repeater fields closed by default - neat & compact.
                'sortable'      => true,  // Allow changing the order of repeated groups.
            ),
        ) );

        $director_meta->add_group_field( $filmography_group_id_director, array(
            'id'      => 'haru_director' . '_filmography_year',
            'name'    => esc_html__( 'Year', 'haru-vidi' ),
            'desc'    => esc_html__( 'Insert Year.', 'haru-vidi' ),
            'type'    => 'text',
        ) );

        $director_meta->add_group_field( $filmography_group_id_director, array(
            'id'      => 'haru_director' . '_filmography_movie',
            'name'    => esc_html__( 'Movie', 'haru-vidi' ),
            'desc'    => esc_html__( 'Insert Movie Name.', 'haru-vidi' ),
            'type'    => 'text',
        ) );

        $director_meta->add_group_field( $filmography_group_id_director, array(
            'id'      => 'haru_director' . '_filmography_character',
            'name'    => esc_html__( 'Character', 'haru-vidi' ),
            'desc'    => esc_html__( 'Insert Character Name.', 'haru-vidi' ),
            'type'    => 'text',
        ) );

        // Video
        $video_attached_meta = new_cmb2_box( array(
            'id'           => 'haru_video_attached_data_field',
            'title'        => esc_html__( 'Add Video to Playlists & Series,...', 'haru-vidi' ),
            'object_types' => array( 'haru_video' ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => false, // Show field names on the left
        ) );

        $video_attached_meta->add_field( array(
            'name'    => esc_html__( 'Attached Playlists', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag playlists from the left column to the right column to add them to this video. You may rearrange the order of the playlists in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_video_attached_playlists',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_playlist',
                ), // override the get_posts args
            ),
        ) );

        $video_attached_meta->add_field( array(
            'name'    => esc_html__( 'Attached Series', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag series from the left column to the right column to add them to this video. You may rearrange the order of the series in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_video_attached_seriess',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_series',
                ), // override the get_posts args
            ),
        ) );

        $video_attached_meta->add_field( array(
            'name'    => esc_html__( 'Attached Channels', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag channel from the left column to the right column to add them to this video. You may rearrange the order of the channel in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_video_attached_channels',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_channel',
                ), // override the get_posts args
            ),
        ) );

        $video_attached_meta->add_field( array(
            'name'    => esc_html__( 'Attached Actors', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag actor from the left column to the right column to add them to this video. You may rearrange the order of the actor in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_video_attached_actors',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_actor',
                ), // override the get_posts args
            ),
        ) );

        $video_attached_meta->add_field( array(
            'name'    => esc_html__( 'Attached Directors', 'haru-vidi' ),
            'desc'    => esc_html__( 'Drag director from the left column to the right column to add them to this video. You may rearrange the order of the director in the right column by dragging and dropping.', 'haru-vidi' ),
            'id'      => 'haru_video_attached_directors',
            'type'    => 'custom_attached_posts',
            'column'  => true, // Output in the admin post-listing as a custom column. https://github.com/CMB2/CMB2/wiki/Field-Parameters#column
            'options' => array(
                'show_thumbnails' => true, // Show thumbnails on the left
                'filter_boxes'    => true, // Show a text box for filtering the results
                'query_args'      => array(
                    'posts_per_page' => 10,
                    'post_type'      => 'haru_director',
                ), // override the get_posts args
            ),
        ) );

        // Video Metabox
        $video_meta = new_cmb2_box( array(
            'id'           => 'haru_video_metabox',
            'title'        => esc_html__( 'Video Metaboxes', 'haru-vidi' ),
            'object_types' => array( 'haru_video' ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ) );

        $video_meta->add_field( array(
            'name'              => esc_html__( 'Source Server', 'haru-vidi' ),
            'id'                => 'haru_video' . '_server',
            'type'              => 'select',
            'show_option_none'  => false,
            'desc'              => esc_html__( 'Please note Twitch video required HTTPS to works.', 'haru-vidi' ),
            'options'           => array(
                'youtube'       => esc_html__( 'Youtube','haru-vidi' ),
                'vimeo'         => esc_html__( 'Vimeo','haru-vidi' ),
            ),
            'default'          => 'youtube',
        ) );

        $video_meta->add_field( array(
            'id'      => 'haru_video' . '_id',
            'name'    => esc_html__( 'Video ID', 'haru-vidi' ),
            'desc'    => esc_html__( 'Insert Video ID from Youtube, Vimeo,... server.', 'haru-vidi' ),
            'type'    => 'text',
            'attributes'    => array(
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_video_server',
                'data-conditional-value' => wp_json_encode( array( 'youtube', 'vimeo', 'dailymotion', 'twitch' ) ),
            ),
        ) );

        $video_meta->add_field( array(
            'id'      => 'haru_video' . '_facebook_url',
            'name'    => esc_html__( 'Video Facebook Url', 'haru-vidi' ),
            'desc'    => esc_html__( 'Insert Video Url from Facebook.', 'haru-vidi' ),
            'type'    => 'text_url',
            'attributes'    => array(
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_video_server',
                'data-conditional-value' => wp_json_encode( array('facebook') ),
            ),
        ) );

        $video_meta->add_field( array(
            'id'      => 'haru_video' . '_google_url',
            'name'    => esc_html__( 'Video Google Url', 'haru-vidi' ),
            'desc'    => esc_html__( 'Insert Video Url from Google Drive.', 'haru-vidi' ),
            'type'    => 'text_url',
            'attributes'    => array(
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_video_server',
                'data-conditional-value' => wp_json_encode( array('google') ),
            ),
        ) );

        $video_meta->add_field( array(
            'id'                => 'haru_video' . '_url_type',
            'name'              => esc_html__( 'Video Source', 'haru-vidi' ),
            'desc'              => esc_html__( 'Use Upload video or Insert Video Url from other server (mp4 and webm).', 'haru-vidi' ),
            'type'              => 'pw_select',
            'show_option_none'  => false,
            'options'           => array(
                'insert'       => esc_html__( 'Insert URL','haru-vidi' ),
                'upload'       => esc_html__( 'Upload File','haru-vidi' ),
            ),
            'attributes'        => array(
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_video_server',
                'data-conditional-value' => wp_json_encode( array('selfhost') ),
            ),
        ) );

        $video_meta->add_field( array(
            'id'      => 'haru_video' . '_url',
            'name'    => esc_html__( 'Video Url', 'haru-vidi' ),
            'desc'    => esc_html__( 'Insert Video Url from other server (mp4 and webm).', 'haru-vidi' ),
            'type'    => 'text_list',
            'options' => array(
                'mp4'       => 'MP4',
                'webm'      => 'WebM',
            ),
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_video_url_type',
                'data-conditional-value' => wp_json_encode( array('insert') ),
            ),
        ) );

        $video_meta->add_field( array(
            'id'      => 'haru_video' . '_file_mp4',
            'name'    => esc_html__( 'Video MP4 File', 'haru-vidi' ),
            'desc'    => esc_html__( 'Upload your video file (MP4).', 'haru-vidi' ),
            'type'    => 'file',
            'options' => array(
                'url' => true,
            ),
            'text'    => array(
                'add_upload_file_text' => esc_html__( 'Add File', 'haru-vidi' ) // Change upload button text. Default: "Add or Upload File"
            ),
            'query_args' => array(
                'type' => array(
                    'video/mp4',
                ),
            ),
            'preview_size' => 'large',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_video_url_type',
                'data-conditional-value' => wp_json_encode( array('upload') ),
            ),
        ) );

        $video_meta->add_field( array(
            'id'      => 'haru_video' . '_file_webm',
            'name'    => esc_html__( 'Video WebM File', 'haru-vidi' ),
            'desc'    => esc_html__( 'Upload your video file (WebM).', 'haru-vidi' ),
            'type'    => 'file',
            'options' => array(
                'url' => true,
            ),
            'text'    => array(
                'add_upload_file_text' => esc_html__( 'Add File', 'haru-vidi' ) // Change upload button text. Default: "Add or Upload File"
            ),
            'query_args' => array(
                'type' => array(
                    'video/webm',
                ),
            ),
            'preview_size' => 'large',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_video_url_type',
                'data-conditional-value' => wp_json_encode( array('upload') ),
            ),
        ) );

        $video_meta->add_field( array(
            'id'          => 'haru_video'.  '_embed',
            'name'        => esc_html__( 'Embeded or Iframe', 'haru-vidi' ),
            'desc'        => esc_html__( 'Insert Embeded or Iframe.', 'haru-vidi' ),
            'type'        => 'textarea_code',
            'attributes'    => array(
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_video_server',
                'data-conditional-value' => wp_json_encode( array('embed') ),
            ),
        ) );

        $video_meta->add_field( array(
            'id'          => 'haru_video'.  '_other',
            'name'        => esc_html__( 'Embeded or Iframe, Object tag', 'haru-vidi' ),
            'desc'        => esc_html__( 'Insert Embeded or Iframe, Object tag.', 'haru-vidi' ),
            'type'        => 'textarea',
            'attributes'    => array(
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_video_server',
                'data-conditional-value' => wp_json_encode( array('other') ),
            ),
        ) );

        $video_meta->add_field( array(
            'name' => esc_html__( 'Information', 'haru-vidi' ),
            'desc' => esc_html__( 'Information of video as actor, director, client, producer,...', 'haru-vidi' ),
            'type' => 'title',
            'id'   => 'haru_video_information_title'
        ) );

        $video_meta->add_field( array(
            'name' => esc_html__( 'ScreenShot Images', 'haru-vidi' ),
            'id'   => 'haru_video' . '_screenshot',
            'type' => 'file_list',
            'desc' => esc_html__( 'Select images screenshot. This will use for Vidi Settings -> Thumbnail -> Video Thumbnail Type option Slideshow.','haru-vidi' ),
            'query_args' => array( 
                'type' => 'image'
            ),
        ) );

        $video_meta->add_field( array(
            'id'            => 'haru_video' . '_duration',
            'name'          => esc_html__( 'Video Duration', 'haru-vidi'),
            'type'          => 'text',
            'desc'          => esc_html__( 'You can set Video duration. Example: 3:15', 'haru-vidi' ),
        ) );

        // User metabox
        $user_meta = new_cmb2_box( array(
            'id'                => 'haru_user_metabox',
            'title'             => esc_html__( 'User Metaboxes', 'haru-vidi' ),
            'object_types'      => array( 'user' ), // Post type
            'context'           => 'normal',
            'priority'          => 'high',
            'show_names'        => true, // Show field names on the left
            'new_user_section'  => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
        ) );

        $user_meta->add_field( array( 
            'name'      => esc_html__( 'Extra Info', 'haru-vidi' ),  
            'desc'      => esc_html__( 'Add extra information for User', 'haru-vidi' ),  
            'id'        => 'haru' . 'extra_info',  
            'type'      => 'title',  
            'on_front'  => false,  
        ) ); 

        $user_meta->add_field( array(
            'name'    => esc_html__( 'Facebook URL', 'haru-vidi' ),
            'id'      => 'haru_' . 'user_facebook_url',
            'type'    => 'text_url',
            'default' => '',
        ) );

        $user_meta->add_field( array(
            'name'    => esc_html__( 'Twitter URL', 'haru-vidi' ),
            'id'      => 'haru_' . 'user_twitter_url',
            'type'    => 'text_url',
            'default' => '',
        ) );

        $user_meta->add_field( array(
            'name'    => esc_html__( 'Instagram URL', 'haru-vidi' ),
            'id'      => 'haru_' . 'user_instagram_url',
            'type'    => 'text_url',
            'default' => '',
        ) );

        // General meta: https://github.com/jcchavezs/cmb2-conditionals/blob/master/example-functions.php
        $post_meta_fake = new_cmb2_box( array(
            'id'           => 'haru_post_fake_count_metabox',
            'title'        => esc_html__( 'Fake Data Metaboxes', 'haru-vidi' ),
            'object_types' => array( 'haru_video', 'haru_playlist', 'haru_series', 'haru_channel', 'haru_actor', 'haru_director' ), // Post type
            'context'      => 'normal',
            'priority'     => 'low',
            'show_names'   => true, // Show field names on the left
        ) );

        $post_meta_fake->add_field( array(
            'name'    => esc_html__( 'Fake Like/Dislike', 'haru-vidi' ),
            'id'      => 'haru_fake_like_dislike',
            'type'    => 'switch',
            'default' => 'off' //If it's checked by default 
        ) );

        $post_meta_fake->add_field( array(
            'id'            => 'haru' . '_fake_like_count',
            'name'          => esc_html__( 'Fake Like', 'haru-vidi'),
            'type'          => 'text',
            'desc'          => esc_html__( 'Set Like Count Start. Example: 30', 'haru-vidi' ),
            'attributes'    => array(
                'type'                   => 'number',
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_fake_like_dislike',
                'data-conditional-value' => wp_json_encode( array( 'on' ) ),
            ),
        ) );

        $post_meta_fake->add_field( array(
            'id'            => 'haru' . '_fake_dislike_count',
            'name'          => esc_html__( 'Fake Dislike', 'haru-vidi'),
            'type'          => 'text',
            'desc'          => esc_html__( 'Set Dislike Count Start. Example: 10', 'haru-vidi' ),
            'attributes'    => array(
                'type'                   => 'number',
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_fake_like_dislike',
                'data-conditional-value' => wp_json_encode( array( 'on' ) ),
            ),
        ) );

        $post_meta_fake->add_field( array(
            'name'    => esc_html__( 'Fake View', 'haru-vidi' ),
            'id'      => 'haru' . '_fake_view',
            'type'    => 'switch',
            'default' => 'off' // If it's checked by default 
        ) );

        $post_meta_fake->add_field( array(
            'id'            => 'haru' . '_fake_view_count',
            'name'          => esc_html__( 'Fake View', 'haru-vidi'),
            'type'          => 'text',
            'desc'          => esc_html__( 'Set View Count Start. Example: 10', 'haru-vidi' ),
            'attributes'    => array(
                'type'                   => 'number',
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_fake_view',
                'data-conditional-value' => wp_json_encode( array( 'on' ) ),
            ),
        ) );

        // Subscribe
        $subscribe_meta_fake = new_cmb2_box( array(
            'id'           => 'haru_post_fake_subscribe_metabox',
            'title'        => esc_html__( 'Fake Subscribe Metaboxes', 'haru-vidi' ),
            'object_types' => array( 'haru_channel' ), // Post type
            'context'      => 'normal', //  'normal', 'advanced', or 'side'
            'priority'     => 'low',
            'show_names'   => true, // Show field names on the left
        ) );

        $subscribe_meta_fake->add_field( array(
            'name'    => esc_html__( 'Fake Subscribe', 'haru-vidi' ),
            'id'      => 'haru' . '_fake_subscribe',
            'type'    => 'switch',
            'default' => 'off' // If it's checked by default 
        ) );

        $subscribe_meta_fake->add_field( array(
            'id'            => 'haru' . '_fake_subscribe_count',
            'name'          => esc_html__( 'Fake Subscribe', 'haru-vidi'),
            'type'          => 'text',
            'desc'          => esc_html__( 'Set Subscribe Count Start. Example: 10', 'haru-vidi' ),
            'attributes'    => array(
                'type'                   => 'number',
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_fake_subscribe',
                'data-conditional-value' => wp_json_encode( array( 'on' ) ),
            ),
        ) );

        // Video Report
        $video_report_meta = new_cmb2_box( array(
            'id'           => 'haru_video_report_metabox',
            'title'        => esc_html__( 'Video Report Metaboxes', 'haru-vidi' ),
            'object_types' => array( 'haru_video_report' ), // Post type
            'context'      => 'normal', //  'normal', 'advanced', or 'side'
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ) );

        $video_report_meta->add_field( array(
            'id'            => 'haru_video_report'.  '_content',
            'name'          => esc_html__( 'Video Report Content', 'haru-vidi' ),
            'desc'          => esc_html__( 'Insert Video Report reason.', 'haru-vidi' ),
            'type'          => 'textarea',
        ) );
    }

    add_action( 'cmb2_init', 'haru_vidi_field_metaboxes_cpt' );
}
