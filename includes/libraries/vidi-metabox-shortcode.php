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


// Posts, CPT Metabox
if ( !function_exists( 'haru_vidi_field_metaboxes_shortcode' ) ) {
    function haru_vidi_field_metaboxes_shortcode() {
        // Shortcode metabox
        $shortcode_meta = new_cmb2_box( array(
            'id'           => 'haru_shortcode_metabox',
            'title'        => esc_html__( 'Shortcode Generate', 'haru-vidi' ),
            'object_types' => array( 'haru_shortcode' ), // Post type
            'context'      => 'normal',
            'priority'     => 'high',
            'show_names'   => true, // Show field names on the left
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Shortcode Code', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_code',
            'type'    => 'textarea_small',
            'default' => '',
            'attributes'    => array(
                'readonly' => 'readonly',
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Shortcode Type', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_type',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Select Shortcode type.', 'haru-vidi' ),
            'options' => array(
                'haru_video_list'                   => esc_html__( 'Video List - Isotope Grid','haru-vidi' ),
                'haru_video_slideshow'              => esc_html__( 'Video Slideshow','haru-vidi' ),
                'haru_video_featured'               => esc_html__( 'Video Featured','haru-vidi' ),
                'haru_video_category'               => esc_html__( 'Video Category','haru-vidi' ),
                'haru_video_category_single'        => esc_html__( 'Video Category Single','haru-vidi' ),
                'haru_video_order'                  => esc_html__( 'Video Order','haru-vidi' ),
                'haru_video_order_single'           => esc_html__( 'Video Order Single','haru-vidi' ),
                'haru_video_top'                    => esc_html__( 'Video TOP','haru-vidi' ),
                'haru_video_list_category'          => esc_html__( 'Video List Category','haru-vidi' ),
                'haru_channel_category'             => esc_html__( 'Channel Category','haru-vidi' ),
                'haru_channel_slideshow'            => esc_html__( 'Channel Slideshow','haru-vidi' ),
                'haru_channel_top'                  => esc_html__( 'Channel TOP','haru-vidi' ),
                'haru_series_category'              => esc_html__( 'Series Category','haru-vidi' ),
                'haru_series_slideshow'             => esc_html__( 'Series Slideshow','haru-vidi' ),
                'haru_series_top'                   => esc_html__( 'Series TOP','haru-vidi' ),
                'haru_playlist_category'            => esc_html__( 'Playlist Category','haru-vidi' ),
                'haru_playlist_slideshow'           => esc_html__( 'Playlist Slideshow','haru-vidi' ),
                'haru_playlist_top'                 => esc_html__( 'Playlist TOP','haru-vidi' ),
                'haru_author_top'                   => esc_html__( 'Author (Member) TOP','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Type', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
            ),
        ) );

        // Video List shortcode options
        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Video List Layout', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_list_layout',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Video List layout.', 'haru-vidi' ),
            'options' => array(
                'default'               => esc_html__( 'Default','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_list') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Video List Title', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_list_title',
            'type'    => 'text',
            'desc'    => esc_html__( 'Video List Title.', 'haru-vidi' ),
            'default' => '',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_list') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Video List Columns', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_list_columns',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Video List Columns.', 'haru-vidi' ),
            'options' => array(
                '1'     => esc_html__( '1','haru-vidi' ),
                '2'     => esc_html__( '2','haru-vidi' ),
                '3'     => esc_html__( '3','haru-vidi' ),
                '4'     => esc_html__( '4','haru-vidi' ),
                '5'     => esc_html__( '5','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_list') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Data Source', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_list_data_source',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Video List Data Source.', 'haru-vidi' ),
            'options' => array(
                'categories'    => esc_html__( 'Categories','haru-vidi' ),
                'list_id'       => esc_html__( 'List IDs','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Data Source', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_list') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Video Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_video_list_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'video_category',
            'desc'          => esc_html__( 'Video List select Video Categories.', 'haru-vidi' ),
            'default'       => '',
            'attributes'    => array(
                'data-conditional-id'    => 'haru_shortcode_video_list_data_source',
                'data-conditional-value' => wp_json_encode( array('categories') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_list_ids',
            'name'          => esc_html__( 'Video IDs', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video List select Videos.', 'haru-vidi' ),
            'type'          => 'pw_multiselect',
            'options'       => haru_vidi_get_cpt_list_options('haru_video'), // 'options_cb'
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Select Videos', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_video_list_data_source',
                'data-conditional-value'    => wp_json_encode( array('list_id') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'             => esc_html__( 'Video Style', 'haru-vidi' ),
            'id'               => 'haru_' . 'shortcode_video_list_style',
            'desc'             => esc_html__( 'Video List select Video style.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'           => esc_html__( 'Default','haru-vidi' ),
                'video-style-2'     => esc_html__( 'Style 2','haru-vidi' ),
                'video-style-3'     => esc_html__( 'Style 3','haru-vidi' ),
                'video-style-4'     => esc_html__( 'Style 4','haru-vidi' ),
                'video-style-5'     => esc_html__( 'Style 5','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'   => 'images/shortcodes/video-style-default.png',
                'video-style-2'   => 'images/shortcodes/video-style-2.png',
                'video-style-3'   => 'images/shortcodes/video-style-3.png',
                'video-style-4'   => 'images/shortcodes/video-style-4.png',
                'video-style-5'   => 'images/shortcodes/video-style-5.png',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_list') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_list_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video List set Video per page.', 'haru-vidi' ),
            'type'          => 'text',
            'default'       => '',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_list') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_list_orderby',
            'name'          => esc_html__( 'Order by', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video List Order by.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'      => esc_html__( 'Date','haru-vidi' ),
                'title'     => esc_html__( 'Title','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order by', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_list') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_list_order',
            'name'          => esc_html__( 'Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video List Order.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'DESC'      => esc_html__( 'DESC','haru-vidi' ),
                'ASC'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_list') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_list_filter',
            'name'          => esc_html__( 'Filter', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video List Show/hide Filter.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'show'      => esc_html__( 'Show','haru-vidi' ),
                'hide'      => esc_html__( 'Hide','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Filter', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_list') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_list_paging_style',
            'name'          => esc_html__( 'Paging Style', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video List set Paging style.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'none'                  => esc_html__( 'None','haru-vidi' ),
                'default'               => esc_html__( 'Default','haru-vidi' ),
                'load-more'             => esc_html__( 'Load More','haru-vidi' ),
                'infinite-scroll'       => esc_html__( 'Infinite Scroll','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Paging style', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_list') ),
            ),
        ) );

        // Video Slideshow shortcode options
        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_video_slideshow_layout',
            'name'             => esc_html__( 'Video Slideshow Layout', 'haru-vidi' ),
            'desc'             => esc_html__( 'Video Slideshow Layout.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'            => esc_html__( 'Default - Slick','haru-vidi' ),
                'carousel-one'       => esc_html__( 'Carousel 1 Columns - Slick','haru-vidi' ),
                'carousel-one-2'     => esc_html__( 'Carousel 1 Columns (2) - Slick','haru-vidi' ),
                'nav-thumbnail'      => esc_html__( 'Nav Thumbnail - Slick','haru-vidi' ),
                'featured'           => esc_html__( 'Featured - Slick','haru-vidi' ),
                'list-small'         => esc_html__( 'List Small (Background Dark) - Slick','haru-vidi' ),
                'info-featured'      => esc_html__( 'Carousel 1 Columns (Info Left) - Slick','haru-vidi' ),
                'list-fullwidth'     => esc_html__( 'List Fullwidth (Background Dark) - Slick','haru-vidi' ),
                'carousel-no-padding'=> esc_html__( 'Carousel No Padding - Slick','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'               => 'images/shortcodes/video-slideshow-default.jpg',
                'carousel-one'          => 'images/shortcodes/video-slideshow-carousel-one.jpg',
                'carousel-one-2'        => 'images/shortcodes/video-slideshow-carousel-one-2.jpg',
                'nav-thumbnail'         => 'images/shortcodes/video-slideshow-nav-thumbnail.jpg',
                'featured'              => 'images/shortcodes/video-slideshow-featured.jpg',
                'list-small'            => 'images/shortcodes/video-slideshow-list-small.jpg',
                'info-featured'         => 'images/shortcodes/video-slideshow-info-featured.jpg',
                'list-fullwidth'        => 'images/shortcodes/video-slideshow-list-fullwidth.jpg',
                'carousel-no-padding'   => 'images/shortcodes/video-slideshow-carousel-no-padding.jpg',
            ),
            'attributes'    => array(
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Video Slideshow Title', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_slideshow_title',
            'type'    => 'text',
            'desc'    => esc_html__( 'Video Slideshow Title.', 'haru-vidi' ),
            'default' => '',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Video Slideshow Columns', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_slideshow_columns',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Video Slideshow Columns. With Featured List layout please set 1 Columns.', 'haru-vidi' ),
            'options' => array(
                '1'     => esc_html__( '1','haru-vidi' ),
                '2'     => esc_html__( '2','haru-vidi' ),
                '3'     => esc_html__( '3','haru-vidi' ),
                '4'     => esc_html__( '4','haru-vidi' ),
                '5'     => esc_html__( '5','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Data Source', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_slideshow_data_source',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Video Slideshow Data Source.', 'haru-vidi' ),
            'options' => array(
                'categories'    => esc_html__( 'Categories','haru-vidi' ),
                'list_id'       => esc_html__( 'List IDs','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Data Source', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Video Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_video_slideshow_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'video_category',
            'desc'          => esc_html__( 'Video Slideshow Categories.', 'haru-vidi' ),
            'attributes'    => array(
                'required'               => false,
                'data-conditional-id'    => 'haru_shortcode_video_slideshow_data_source',
                'data-conditional-value' => wp_json_encode( array('categories') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_slideshow_ids',
            'name'          => esc_html__( 'Video IDs', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Slideshow select Videos.', 'haru-vidi' ),
            'type'          => 'pw_multiselect',
            'options'       => haru_vidi_get_cpt_list_options('haru_video'), // 'options_cb'
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Select Videos', 'haru-vidi' ),
                'required'                  => false, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_video_slideshow_data_source',
                'data-conditional-value'    => wp_json_encode( array('list_id') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_slideshow_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Slideshow select Video per page.', 'haru-vidi' ),
            'type'          => 'text',
            'default'       => '6',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_slideshow_orderby',
            'name'          => esc_html__( 'Order by', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Slideshow Order by.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'      => esc_html__( 'Date','haru-vidi' ),
                'title'     => esc_html__( 'Title','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order by', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_slideshow_order',
            'name'          => esc_html__( 'Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Slideshow Order.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'DESC'      => esc_html__( 'DESC','haru-vidi' ),
                'ASC'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_slideshow') ),
            ),
        ) );

        // Video Category Single
        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_video_category_single_layout',
            'name'             => esc_html__( 'Video Category Single Layout', 'haru-vidi' ),
            'desc'             => esc_html__( 'Video Category Single Layout.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'           => esc_html__( 'Default','haru-vidi' ),
                'style-2'     => esc_html__( 'Style 2','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'     => 'images/shortcodes/video-category-single-default.jpg',
                'style-2'     => 'images/shortcodes/video-category-single-2.jpg',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_category_single') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'              => esc_html__( 'Video Category', 'haru-vidi' ),
            'id'                => 'haru_' . 'shortcode_video_category_single_category',
            'type'              => 'taxonomy_radio',
            'taxonomy'          => 'video_category',
            'desc'              => esc_html__( 'Video Category Single select Category', 'haru-vidi' ),
            'remove_default'    => 'true',
            'query_args'        => array(
                'orderby'           => 'slug',
                'hide_empty'        => true,
            ),
            'attributes'        => array(
                'required'               => false,
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_category_single') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_category_single_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Category Single posts per page.', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_category_single') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_category_single_orderby',
            'name'          => esc_html__( 'Order by', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Category Single Order by.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'      => esc_html__( 'Date','haru-vidi' ),
                'title'     => esc_html__( 'Title','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order by', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_category_single') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_category_single_order',
            'name'          => esc_html__( 'Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Category Single Order.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'DESC'      => esc_html__( 'DESC','haru-vidi' ),
                'ASC'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_category_single') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_category_single_view_more',
            'name'          => esc_html__( 'View More', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Category view more button link will go to category page. Video Category Arrow click show more video via Ajax.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'button'      => esc_html__( 'Button','haru-vidi' ),
                'arrow'       => esc_html__( 'Arrow','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'View More Style', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_category_single') ),
            ),
        ) );

        // Video Category
        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Video Category Title', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_category_title',
            'type'    => 'text',
            'desc'    => esc_html__( 'Video Category Category Title.', 'haru-vidi' ),
            'default' => '',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Video Category Layout', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_category_layout',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Video Category Layout.', 'haru-vidi' ),
            'options' => array(
                'default'               => esc_html__( 'Default','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Video Category Columns', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_category_columns',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Video Category Columns.', 'haru-vidi' ),
            'options' => array(
                '2'     => esc_html__( '2','haru-vidi' ),
                '3'     => esc_html__( '3','haru-vidi' ),
                '4'     => esc_html__( '4','haru-vidi' ),
                '5'     => esc_html__( '5','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Video Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_video_category_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'video_category',
            'desc'          => esc_html__( 'Video Category select Categories', 'haru-vidi' ),
            'default'       => '',
            'attributes'    => array(
                'required'               => false,
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_video_category_style',
            'name'             => esc_html__( 'Video Style', 'haru-vidi' ),
            'desc'             => esc_html__( 'Video Category video style. With Video style 6 Column auto equal 1.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'           => esc_html__( 'Default','haru-vidi' ),
                'video-style-2'     => esc_html__( 'Style 2','haru-vidi' ),
                'video-style-3'     => esc_html__( 'Style 3','haru-vidi' ),
                'video-style-4'     => esc_html__( 'Style 4','haru-vidi' ),
                'video-style-5'     => esc_html__( 'Style 5','haru-vidi' ),
                'video-style-6'     => esc_html__( 'Style 6','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'   => 'images/shortcodes/video-style-default.png',
                'video-style-2'   => 'images/shortcodes/video-style-2.png',
                'video-style-3'   => 'images/shortcodes/video-style-3.png',
                'video-style-4'   => 'images/shortcodes/video-style-4.png',
                'video-style-5'   => 'images/shortcodes/video-style-5.png',
                'video-style-6'   => 'images/shortcodes/video-style-6.png',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_category_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Category posts per page.', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_category_orderby',
            'name'          => esc_html__( 'Order by', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Category Order by.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'      => esc_html__( 'Date','haru-vidi' ),
                'title'     => esc_html__( 'Title','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order by', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_category_order',
            'name'          => esc_html__( 'Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Category Order.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'DESC'      => esc_html__( 'DESC','haru-vidi' ),
                'ASC'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_category_filter',
            'name'          => esc_html__( 'Filter', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Category Show/hide Filter.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'show'      => esc_html__( 'Show','haru-vidi' ),
                'hide'      => esc_html__( 'Hide','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Filter', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_category_filter_all',
            'name'          => esc_html__( 'Filter All', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Category Show/hide All Filter.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'show'      => esc_html__( 'Show','haru-vidi' ),
                'hide'      => esc_html__( 'Hide','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Filter All', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_video_category_filter',
                'data-conditional-value'    => wp_json_encode( array('show') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_category_view_more',
            'name'          => esc_html__( 'View More', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Category view more button link will go to category page. Video Category Arrow click show more video via Ajax.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'button'      => esc_html__( 'Button','haru-vidi' ),
                'arrow'       => esc_html__( 'Arrow','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'View More Style', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_category_dark_style',
            'name'          => esc_html__( 'Dark Style', 'haru-vidi' ),
            'desc'          => esc_html__( 'Enable/Disable style for background Dark.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
            	'no'      => esc_html__( 'No','haru-vidi' ),
                'yes'     => esc_html__( 'Yes','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Dark Style', 'haru-vidi' ),
                'required'                  => false, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_category') ),
            ),
        ) );

        // Video Order
        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Video Order Layout', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_order_layout',
            'type'    => 'pw_select',
            'options' => array(
                'default'               => esc_html__( 'Default - Grid','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_order') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Video Order Columns', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_order_columns',
            'type'    => 'pw_select',
            'options' => array(
                '1'     => esc_html__( '1','haru-vidi' ),
                '2'     => esc_html__( '2','haru-vidi' ),
                '3'     => esc_html__( '3','haru-vidi' ),
                '4'     => esc_html__( '4','haru-vidi' ),
                '5'     => esc_html__( '5','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_order') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_order_tabs',
            'name'          => esc_html__( 'Video Order Tabs', 'haru-vidi' ),
            'desc'          => esc_html__( 'Choose Tab you want to display', 'haru-vidi' ),
            'type'          => 'multicheck',
            'options'       => array(
                'new'       => esc_html__( 'Latest','haru-vidi' ),
                'view'      => esc_html__( 'Most Views','haru-vidi' ),
                'like'      => esc_html__( 'Most Liked','haru-vidi' ),
                'random'    => esc_html__( 'Random','haru-vidi' ),
            ),
            'attributes'    => array(
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_order') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_order_new_title',
            'name'          => esc_html__( 'Latest Tab title', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_video_order_tabs',
                'data-conditional-value'    => wp_json_encode( array('new') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_order_view_title',
            'name'          => esc_html__( 'Most View Tab title', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_video_order_tabs',
                'data-conditional-value'    => wp_json_encode( array('view') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_order_like_title',
            'name'          => esc_html__( 'Most Like Tab title', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_video_order_tabs',
                'data-conditional-value'    => wp_json_encode( array('like') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_order_random_title',
            'name'          => esc_html__( 'Random Tab title', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_video_order_tabs',
                'data-conditional-value'    => wp_json_encode( array('random') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Video Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_video_order_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'video_category',
            'attributes'    => array(
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_order') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_video_order_style',
            'name'             => esc_html__( 'Video Style', 'haru-vidi' ),
            'desc'             => esc_html__( 'Video Order video style. With Video style 6 Column auto equal 1.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'           => esc_html__( 'Default','haru-vidi' ),
                'video-style-2'     => esc_html__( 'Style 2','haru-vidi' ),
                'video-style-3'     => esc_html__( 'Style 3','haru-vidi' ),
                'video-style-4'     => esc_html__( 'Style 4','haru-vidi' ),
                'video-style-5'     => esc_html__( 'Style 5','haru-vidi' ),
                'video-style-6'     => esc_html__( 'Style 6','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'         => 'images/shortcodes/video-style-default.png',
                'video-style-2'   => 'images/shortcodes/video-style-2.png',
                'video-style-3'   => 'images/shortcodes/video-style-3.png',
                'video-style-4'   => 'images/shortcodes/video-style-4.png',
                'video-style-5'   => 'images/shortcodes/video-style-5.png',
                'video-style-6'   => 'images/shortcodes/video-style-6.png',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Select Video style', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_order') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_order_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Select Video per page.', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_order') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_order_ajax_arrow',
            'name'          => esc_html__( 'Ajax Arrow', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Order Arrow click show more video via Ajax.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'show'      => esc_html__( 'Show','haru-vidi' ),
                'hide'      => esc_html__( 'Hide','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Ajax Show More', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_order') ),
            ),
        ) );

        // Video Order Single
        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Video Order Single Layout', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_order_single_layout',
            'type'    => 'pw_select',
            'options' => array(
                'default'               => esc_html__( 'Default - List','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_order_single') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_order_single_tabs',
            'name'          => esc_html__( 'Video Order Single Tabs', 'haru-vidi' ),
            'desc'          => esc_html__( 'Choose Tab you want to display', 'haru-vidi' ),
            'type'          => 'radio',
            'options'       => array(
                'new'       => esc_html__( 'Latest','haru-vidi' ),
                'view'      => esc_html__( 'Most Views','haru-vidi' ),
                'like'      => esc_html__( 'Most Liked','haru-vidi' ),
                'random'    => esc_html__( 'Random','haru-vidi' ),
            ),
            'attributes'    => array(
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_order_single') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_order_single_new_title',
            'name'          => esc_html__( 'Latest Tab title', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_video_order_single_tabs',
                'data-conditional-value'    => wp_json_encode( array('new') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_order_single_view_title',
            'name'          => esc_html__( 'Most View Tab title', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_video_order_single_tabs',
                'data-conditional-value'    => wp_json_encode( array('view') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_order_single_like_title',
            'name'          => esc_html__( 'Most Like Tab title', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_video_order_single_tabs',
                'data-conditional-value'    => wp_json_encode( array('like') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_order_single_random_title',
            'name'          => esc_html__( 'Random Tab title', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_video_order_single_tabs',
                'data-conditional-value'    => wp_json_encode( array('random') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Video Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_video_order_single_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'video_category',
            'attributes'    => array(
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_order_single') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_video_order_single_style',
            'name'             => esc_html__( 'Video Style', 'haru-vidi' ),
            'desc'             => esc_html__( 'Video Order video style. With Video style 6 Column auto equal 1.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'           => esc_html__( 'Default','haru-vidi' ),
                'video-style-2'     => esc_html__( 'Style 2','haru-vidi' ),
                'video-style-3'     => esc_html__( 'Style 3','haru-vidi' ),
                'video-style-4'     => esc_html__( 'Style 4','haru-vidi' ),
                'video-style-5'     => esc_html__( 'Style 5','haru-vidi' ),
                'video-style-6'     => esc_html__( 'Style 6','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'         => 'images/shortcodes/video-style-default.png',
                'video-style-2'   => 'images/shortcodes/video-style-2.png',
                'video-style-3'   => 'images/shortcodes/video-style-3.png',
                'video-style-4'   => 'images/shortcodes/video-style-4.png',
                'video-style-5'   => 'images/shortcodes/video-style-5.png',
                'video-style-6'   => 'images/shortcodes/video-style-6.png',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Select Video style', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_order_single') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Video Order Single Columns', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_order_single_columns',
            'type'    => 'pw_select',
            'options' => array(
                '1'     => esc_html__( '1','haru-vidi' ),
                '2'     => esc_html__( '2','haru-vidi' ),
                '3'     => esc_html__( '3','haru-vidi' ),
                '4'     => esc_html__( '4','haru-vidi' ),
                '5'     => esc_html__( '5','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_order_single') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_order_single_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Select Video per page.', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_order_single') ),
            ),
        ) );

        // Video Featured
        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Video Featured Title', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_video_featured_title',
            'type'    => 'text',
            'desc'    => esc_html__( 'Video Featured Category Title.', 'haru-vidi' ),
            'default' => '',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_featured') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_video_featured_layout',
            'name'             => esc_html__( 'Video Featured Layout', 'haru-vidi' ),
            'desc'             => esc_html__( 'Video Featured Category Layout.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'     => esc_html__( 'Default','haru-vidi' ),
                'style-2'     => esc_html__( 'Style 2','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'     => 'images/shortcodes/video-featured-default.jpg',
                'style-2'     => 'images/shortcodes/video-featured-2.jpg',
            ),
            'attributes'    => array(
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_featured') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Video Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_video_featured_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'video_category',
            'desc'          => esc_html__( 'Video Featured Category select Categories', 'haru-vidi' ),
            'default'       => '',
            'attributes'    => array(
                'required'               => false,
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_featured') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_featured_orderby',
            'name'          => esc_html__( 'Order by', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Featured Category Order by.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'      => esc_html__( 'Date','haru-vidi' ),
                'title'     => esc_html__( 'Title','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order by', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_featured') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_featured_order',
            'name'          => esc_html__( 'Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Featured Category Order.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'DESC'      => esc_html__( 'DESC','haru-vidi' ),
                'ASC'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_featured') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_featured_filter',
            'name'          => esc_html__( 'Filter', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Featured Category Show/hide Filter.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'show'      => esc_html__( 'Show','haru-vidi' ),
                'hide'      => esc_html__( 'Hide','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Filter', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_featured') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_featured_filter_all',
            'name'          => esc_html__( 'Filter All', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Featured Category Show/hide All Filter.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'show'      => esc_html__( 'Show','haru-vidi' ),
                'hide'      => esc_html__( 'Hide','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Filter All', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_video_featured_filter',
                'data-conditional-value'    => wp_json_encode( array('show') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_featured_view_more',
            'name'          => esc_html__( 'View More', 'haru-vidi' ),
            'desc'          => esc_html__( 'Video Featured Category view more button will go to category page.  Arrow click show more video via Ajax', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'button'        => esc_html__( 'Button','haru-vidi' ),
                'arrow'         => esc_html__( 'Arrow','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'View More', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_featured') ),
            ),
        ) );

        // Video TOP
        $shortcode_meta->add_field( array(
            'name'             => esc_html__( 'Video TOP Layout', 'haru-vidi' ),
            'id'               => 'haru_' . 'shortcode_video_top_layout',
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'               => esc_html__( 'List - Small Thumbnail Left','haru-vidi' ),
                'style-2'               => esc_html__( 'List - Thumbnail Fullwidth','haru-vidi' ),
                'style-3'               => esc_html__( 'Carousel - Bullets','haru-vidi' ),
                'style-4'               => esc_html__( 'Grid - 2 Columns','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'   => 'images/shortcodes/video-top-default.png',
                'style-2'   => 'images/shortcodes/video-top-style-2.png',
                'style-3'   => 'images/shortcodes/video-top-style-3.png',
                'style-4'   => 'images/shortcodes/video-top-style-4.png',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_top_title',
            'name'          => esc_html__( 'Video TOP title', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Video Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_video_top_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'video_category',
            'attributes'    => array(
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_top_order_by',
            'name'          => esc_html__( 'Video Order By', 'haru-vidi' ),
            'desc'          => esc_html__( 'Choose Video Order By', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'       => esc_html__( 'Date','haru-vidi' ),
                'view'      => esc_html__( 'Views','haru-vidi' ),
                'like'      => esc_html__( 'Like','haru-vidi' ),
                'dislike'      => esc_html__( 'DisLike','haru-vidi' ),
            ),
            'attributes'    => array(
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_top_order',
            'name'          => esc_html__( 'Video Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Choose Video Order', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'desc'      => esc_html__( 'DESC','haru-vidi' ),
                'asc'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_top_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Select Video per page.', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_top_dark_style',
            'name'          => esc_html__( 'Dark Style', 'haru-vidi' ),
            'desc'          => esc_html__( 'Enable/Disable style for background Dark. Now in Develope Mode and does not work.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'no'      => esc_html__( 'No','haru-vidi' ),
                'yes'     => esc_html__( 'Yes','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Dark Style', 'haru-vidi' ),
                'required'                  => false, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_top') ),
            ),
        ) );

        // Video List Category
        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_video_list_category_layout',
            'name'             => esc_html__( 'Video List Category Layout', 'haru-vidi' ),
            'desc'             => esc_html__( 'Video List Category Layout.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'            => esc_html__( 'List Default','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'               => 'images/shortcodes/video-list-category-default.jpg',
            ),
            'attributes'    => array(
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_list_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_list_category_title',
            'name'          => esc_html__( 'Video List Category title', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_list_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_list_category_order_by',
            'name'          => esc_html__( 'Category Order By', 'haru-vidi' ),
            'desc'          => esc_html__( 'Choose Category Order By', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'name'   => esc_html__( 'Name', 'haru-vidi' ),
            ),
            'attributes'    => array(
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_list_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_list_category_count',
            'name'          => esc_html__( 'Show Count', 'haru-vidi' ),
            'desc'          => esc_html__( 'Show/Hide Video Count', 'haru-vidi' ),
            'type'          => 'checkbox',
            'attributes'    => array(
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_list_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Show hierarchical', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_video_list_category_hierarchical',
            'desc'          => esc_html__( 'Show/Hide Video Hierarchical', 'haru-vidi' ),
            'type'          => 'checkbox',
            'attributes'    => array(
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_list_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Only show children of the current category', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_video_list_category_show_children_only',
            'desc'          => esc_html__( 'Only show children of the current category', 'haru-vidi' ),
            'type'          => 'checkbox',
            'attributes'    => array(
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_list_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Hide empty categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_video_list_category_hide_empty',
            'desc'          => esc_html__( 'Hide empty categories', 'haru-vidi' ),
            'type'          => 'checkbox',
            'attributes'    => array(
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_video_list_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_video_list_category_max_depth',
            'name'          => esc_html__( 'Maximum depth', 'haru-vidi' ),
            'desc'          => esc_html__( 'Maximum depth.', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_video_list_category') ),
            ),
        ) );

        // Channel Category
        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Channel Category Layout', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_channel_category_layout',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Channel Category Layout.', 'haru-vidi' ),
            'options' => array(
                'default'               => esc_html__( 'Default','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_channel_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Channel Category Title', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_channel_category_title',
            'type'    => 'text',
            'desc'    => esc_html__( 'Channel Category Title.', 'haru-vidi' ),
            'default' => '',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_channel_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Channel Category Columns', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_channel_category_columns',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Channel Category Columns.', 'haru-vidi' ),
            'options' => array(
                '2'     => esc_html__( '2','haru-vidi' ),
                '3'     => esc_html__( '3','haru-vidi' ),
                '4'     => esc_html__( '4','haru-vidi' ),
                '5'     => esc_html__( '5','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_channel_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Channel Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_channel_category_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'channel_category',
            'desc'          => esc_html__( 'Channel Category select Categories', 'haru-vidi' ),
            'default'       => '',
            'attributes'    => array(
                'required'               => false,
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_channel_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_channel_category_style',
            'name'             => esc_html__( 'Channel Style', 'haru-vidi' ),
            'desc'             => esc_html__( 'Channel Category channel style. With Channel style 6 Column auto equal 1.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'            => esc_html__( 'Default','haru-vidi' ),
                'channel-style-2'     => esc_html__( 'Style 2','haru-vidi' ),
                'channel-style-3'     => esc_html__( 'Style 3','haru-vidi' ),
                'channel-style-4'     => esc_html__( 'Style 4','haru-vidi' ),
                'channel-style-5'     => esc_html__( 'Style 5','haru-vidi' ),
                'channel-style-6'     => esc_html__( 'Style 6','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'   => 'images/shortcodes/channel-style-default.jpg',
                'channel-style-2'   => 'images/shortcodes/channel-style-2.jpg',
                'channel-style-3'   => 'images/shortcodes/channel-style-3.jpg',
                'channel-style-4'   => 'images/shortcodes/channel-style-4.jpg',
                'channel-style-5'   => 'images/shortcodes/channel-style-5.jpg',
                'channel-style-6'   => 'images/shortcodes/channel-style-6.jpg',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Select Channel style', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_channel_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_channel_category_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Channel Category posts per page.', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_channel_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_channel_category_orderby',
            'name'          => esc_html__( 'Order by', 'haru-vidi' ),
            'desc'          => esc_html__( 'Channel Category Order by.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'      => esc_html__( 'Date','haru-vidi' ),
                'title'     => esc_html__( 'Title','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order by', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_channel_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_channel_category_order',
            'name'          => esc_html__( 'Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Channel Category Order.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'DESC'      => esc_html__( 'DESC','haru-vidi' ),
                'ASC'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_channel_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_channel_category_filter',
            'name'          => esc_html__( 'Filter', 'haru-vidi' ),
            'desc'          => esc_html__( 'Channel Category Show/hide Filter.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'show'      => esc_html__( 'Show','haru-vidi' ),
                'hide'      => esc_html__( 'Hide','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Filter', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_channel_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_channel_category_filter_all',
            'name'          => esc_html__( 'Filter All', 'haru-vidi' ),
            'desc'          => esc_html__( 'Channel Category Show/hide All Filter.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'show'      => esc_html__( 'Show','haru-vidi' ),
                'hide'      => esc_html__( 'Hide','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Filter All', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_channel_category_filter',
                'data-conditional-value'    => wp_json_encode( array('show') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_channel_category_view_more',
            'name'          => esc_html__( 'View More', 'haru-vidi' ),
            'desc'          => esc_html__( 'Channel Category view more button will go to category page. Ajax arrow will load more channels via Ajax.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'button'      => esc_html__( 'Button','haru-vidi' ),
                'arrow'       => esc_html__( 'Arrow','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'View More', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_channel_category') ),
            ),
        ) );

        // Channel Slideshow shortcode options
        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Channel Slideshow Title', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_channel_slideshow_title',
            'type'    => 'text',
            'desc'    => esc_html__( 'Channel Slideshow Title.', 'haru-vidi' ),
            'default' => '',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_channel_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Channel Slideshow Layout', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_channel_slideshow_layout',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Channel Slideshow Layout.', 'haru-vidi' ),
            'options' => array(
                'default'            => esc_html__( 'Default - Slick','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_channel_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Channel Slideshow Columns', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_channel_slideshow_columns',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Channel Slideshow Columns. With Featured List layout please set 1 Columns.', 'haru-vidi' ),
            'options' => array(
                '1'     => esc_html__( '1','haru-vidi' ),
                '2'     => esc_html__( '2','haru-vidi' ),
                '3'     => esc_html__( '3','haru-vidi' ),
                '4'     => esc_html__( '4','haru-vidi' ),
                '5'     => esc_html__( '5','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_channel_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Data Source', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_channel_slideshow_data_source',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Channel Slideshow Data Source.', 'haru-vidi' ),
            'options' => array(
                'categories'    => esc_html__( 'Categories','haru-vidi' ),
                'list_id'       => esc_html__( 'List IDs','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Data Source', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_channel_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Channel Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_channel_slideshow_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'channel_category',
            'desc'          => esc_html__( 'Channel Slideshow Categories.', 'haru-vidi' ),
            'attributes'    => array(
                'required'               => false,
                'data-conditional-id'    => 'haru_shortcode_channel_slideshow_data_source',
                'data-conditional-value' => wp_json_encode( array('categories') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_channel_slideshow_ids',
            'name'          => esc_html__( 'Channel IDs', 'haru-vidi' ),
            'desc'          => esc_html__( 'Channel Slideshow select Channels.', 'haru-vidi' ),
            'type'          => 'pw_multiselect',
            'options'       => haru_vidi_get_cpt_list_options('haru_channel'), // 'options_cb'
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Select Channels', 'haru-vidi' ),
                'required'                  => false, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_channel_slideshow_data_source',
                'data-conditional-value'    => wp_json_encode( array('list_id') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_channel_slideshow_style',
            'name'             => esc_html__( 'Channel Style', 'haru-vidi' ),
            'desc'             => esc_html__( 'Channel Slideshow select channel style.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'            => esc_html__( 'Default','haru-vidi' ),
                'channel-style-2'     => esc_html__( 'Style 2','haru-vidi' ),
                'channel-style-3'     => esc_html__( 'Style 3','haru-vidi' ),
                'channel-style-4'     => esc_html__( 'Style 4','haru-vidi' ),
                'channel-style-5'     => esc_html__( 'Style 5','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'   => 'images/shortcodes/channel-style-default.jpg',
                'channel-style-2'   => 'images/shortcodes/channel-style-2.jpg',
                'channel-style-3'   => 'images/shortcodes/channel-style-3.jpg',
                'channel-style-4'   => 'images/shortcodes/channel-style-4.jpg',
                'channel-style-5'   => 'images/shortcodes/channel-style-5.jpg',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Select Channel style', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_channel_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_channel_slideshow_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Channel Slideshow select Channel per page.', 'haru-vidi' ),
            'type'          => 'text',
            'default'       => '6',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_channel_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_channel_slideshow_orderby',
            'name'          => esc_html__( 'Order by', 'haru-vidi' ),
            'desc'          => esc_html__( 'Channel Slideshow Order by.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'      => esc_html__( 'Date','haru-vidi' ),
                'title'     => esc_html__( 'Title','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order by', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_channel_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_channel_slideshow_order',
            'name'          => esc_html__( 'Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Channel Slideshow Order.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'DESC'      => esc_html__( 'DESC','haru-vidi' ),
                'ASC'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_channel_slideshow') ),
            ),
        ) );

        // Channel TOP
        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_channel_top_layout',
            'name'             => esc_html__( 'Channel TOP Layout', 'haru-vidi' ),
            'desc'             => esc_html__( 'Channel TOP Layout.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'               => esc_html__( 'List - Small Thumbnail Left','haru-vidi' ),
                'style-2'               => esc_html__( 'List - Thumbnail Fullwidth','haru-vidi' ),
                'style-3'               => esc_html__( 'Carousel - Bullets','haru-vidi' ),
                'style-4'               => esc_html__( 'Grid - 3 Columns','haru-vidi' ),
                'style-5'               => esc_html__( 'List - Small Thumbnail Left Rounded','haru-vidi' ),
                'style-6'               => esc_html__( 'List - Thumbnail Rounded','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'   => 'images/shortcodes/channel-top-default.jpg',
                'style-2'   => 'images/shortcodes/channel-top-style-2.jpg',
                'style-3'   => 'images/shortcodes/channel-top-style-3.jpg',
                'style-4'   => 'images/shortcodes/channel-top-style-4.jpg',
                'style-5'   => 'images/shortcodes/channel-top-style-5.jpg',
                'style-6'   => 'images/shortcodes/channel-top-style-6.jpg',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Select Shortcode style', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_channel_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_channel_top_title',
            'name'          => esc_html__( 'Channel TOP title', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_channel_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Channel Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_channel_top_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'channel_category',
            'attributes'    => array(
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_channel_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_channel_top_order_by',
            'name'          => esc_html__( 'Channel Order By', 'haru-vidi' ),
            'desc'          => esc_html__( 'Choose Channel Order By', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'       => esc_html__( 'Date','haru-vidi' ),
                'view'      => esc_html__( 'Views','haru-vidi' ),
                'like'      => esc_html__( 'Like','haru-vidi' ),
                'dislike'      => esc_html__( 'DisLike','haru-vidi' ),
                'subscribe'      => esc_html__( 'Subscriber','haru-vidi' ),
            ),
            'attributes'    => array(
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_channel_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_channel_top_order',
            'name'          => esc_html__( 'Channel Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Choose Channel Order', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'desc'      => esc_html__( 'DESC','haru-vidi' ),
                'asc'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_channel_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_channel_top_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Select Channel per page.', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_channel_top') ),
            ),
        ) );

        // Playlist Category
        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Playlist Category Layout', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_playlist_category_layout',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Playlist Category Layout.', 'haru-vidi' ),
            'options' => array(
                'default'               => esc_html__( 'Default','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_playlist_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Playlist Category Title', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_playlist_category_title',
            'type'    => 'text',
            'desc'    => esc_html__( 'Playlist Category Title.', 'haru-vidi' ),
            'default' => '',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_playlist_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Playlist Category Columns', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_playlist_category_columns',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Playlist Category Columns.', 'haru-vidi' ),
            'options' => array(
                '2'     => esc_html__( '2','haru-vidi' ),
                '3'     => esc_html__( '3','haru-vidi' ),
                '4'     => esc_html__( '4','haru-vidi' ),
                '5'     => esc_html__( '5','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_playlist_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Playlist Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_playlist_category_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'playlist_category',
            'desc'          => esc_html__( 'Playlist Category select Categories', 'haru-vidi' ),
            'default'       => '',
            'attributes'    => array(
                'required'               => false,
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_playlist_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_playlist_category_style',
            'name'             => esc_html__( 'Playlist Style', 'haru-vidi' ),
            'desc'             => esc_html__( 'Playlist Category playlist style. With Video style 6 Column auto equal 1.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'            => esc_html__( 'Default','haru-vidi' ),
                'playlist-style-2'     => esc_html__( 'Style 2','haru-vidi' ),
                'playlist-style-3'     => esc_html__( 'Style 3','haru-vidi' ),
                'playlist-style-4'     => esc_html__( 'Style 4','haru-vidi' ),
                'playlist-style-5'     => esc_html__( 'Style 5','haru-vidi' ),
                'playlist-style-6'     => esc_html__( 'Style 6','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'   => 'images/shortcodes/playlist-style-default.jpg',
                'playlist-style-2'   => 'images/shortcodes/playlist-style-2.jpg',
                'playlist-style-3'   => 'images/shortcodes/playlist-style-3.jpg',
                'playlist-style-4'   => 'images/shortcodes/playlist-style-4.jpg',
                'playlist-style-5'   => 'images/shortcodes/playlist-style-5.jpg',
                'playlist-style-6'   => 'images/shortcodes/playlist-style-6.jpg',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Select Playlist style', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_playlist_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_playlist_category_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Playlist Category posts per page.', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_playlist_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_playlist_category_orderby',
            'name'          => esc_html__( 'Order by', 'haru-vidi' ),
            'desc'          => esc_html__( 'Playlist Category Order by.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'      => esc_html__( 'Date','haru-vidi' ),
                'title'     => esc_html__( 'Title','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order by', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_playlist_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_playlist_category_order',
            'name'          => esc_html__( 'Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Playlist Category Order.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'DESC'      => esc_html__( 'DESC','haru-vidi' ),
                'ASC'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_playlist_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_playlist_category_filter',
            'name'          => esc_html__( 'Filter', 'haru-vidi' ),
            'desc'          => esc_html__( 'Playlist Category Show/hide Filter.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'show'      => esc_html__( 'Show','haru-vidi' ),
                'hide'      => esc_html__( 'Hide','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Filter', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_playlist_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_playlist_category_filter_all',
            'name'          => esc_html__( 'Filter All', 'haru-vidi' ),
            'desc'          => esc_html__( 'Playlist Category Show/hide All Filter.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'show'      => esc_html__( 'Show','haru-vidi' ),
                'hide'      => esc_html__( 'Hide','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Filter All', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_playlist_category_filter',
                'data-conditional-value'    => wp_json_encode( array('show') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_playlist_category_view_more',
            'name'          => esc_html__( 'View More', 'haru-vidi' ),
            'desc'          => esc_html__( 'Playlist Category view more button will go to category page. Ajax Arrow will load more playlists via Ajax.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'button'      => esc_html__( 'Button','haru-vidi' ),
                'arrow'       => esc_html__( 'Arrow','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'View More', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_playlist_category') ),
            ),
        ) );

        // Playlist Slideshow shortcode options
        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Playlist Slideshow Title', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_playlist_slideshow_title',
            'type'    => 'text',
            'desc'    => esc_html__( 'Playlist Slideshow Title.', 'haru-vidi' ),
            'default' => '',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_playlist_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Playlist Slideshow Layout', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_playlist_slideshow_layout',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Playlist Slideshow Layout.', 'haru-vidi' ),
            'options' => array(
                'default'            => esc_html__( 'Default - Slick','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_playlist_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Playlist Slideshow Columns', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_playlist_slideshow_columns',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Playlist Slideshow Columns. With Featured List layout please set 1 Columns.', 'haru-vidi' ),
            'options' => array(
                '1'     => esc_html__( '1','haru-vidi' ),
                '2'     => esc_html__( '2','haru-vidi' ),
                '3'     => esc_html__( '3','haru-vidi' ),
                '4'     => esc_html__( '4','haru-vidi' ),
                '5'     => esc_html__( '5','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_playlist_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Data Source', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_playlist_slideshow_data_source',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Playlist Slideshow Data Source.', 'haru-vidi' ),
            'options' => array(
                'categories'    => esc_html__( 'Categories','haru-vidi' ),
                'list_id'       => esc_html__( 'List IDs','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Data Source', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_playlist_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Playlist Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_playlist_slideshow_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'playlist_category',
            'desc'          => esc_html__( 'Playlist Slideshow Categories.', 'haru-vidi' ),
            'attributes'    => array(
                'required'               => false,
                'data-conditional-id'    => 'haru_shortcode_playlist_slideshow_data_source',
                'data-conditional-value' => wp_json_encode( array('categories') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_playlist_slideshow_ids',
            'name'          => esc_html__( 'Playlist IDs', 'haru-vidi' ),
            'desc'          => esc_html__( 'Playlist Slideshow select Playlists.', 'haru-vidi' ),
            'type'          => 'pw_multiselect',
            'options'       => haru_vidi_get_cpt_list_options('haru_playlist'), // 'options_cb'
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Select Playlists', 'haru-vidi' ),
                'required'                  => false, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_playlist_slideshow_data_source',
                'data-conditional-value'    => wp_json_encode( array('list_id') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_playlist_slideshow_style',
            'name'             => esc_html__( 'Playlist Style', 'haru-vidi' ),
            'desc'             => esc_html__( 'Playlist Slideshow select playlist style.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'            => esc_html__( 'Default','haru-vidi' ),
                'playlist-style-2'     => esc_html__( 'Style 2','haru-vidi' ),
                'playlist-style-3'     => esc_html__( 'Style 3','haru-vidi' ),
                'playlist-style-4'     => esc_html__( 'Style 4','haru-vidi' ),
                'playlist-style-5'     => esc_html__( 'Style 5','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'   => 'images/shortcodes/playlist-style-default.jpg',
                'playlist-style-2'   => 'images/shortcodes/playlist-style-2.jpg',
                'playlist-style-3'   => 'images/shortcodes/playlist-style-3.jpg',
                'playlist-style-4'   => 'images/shortcodes/playlist-style-4.jpg',
                'playlist-style-5'   => 'images/shortcodes/playlist-style-5.jpg',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Select Playlist style', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_playlist_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_playlist_slideshow_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Playlist Slideshow select Playlist per page.', 'haru-vidi' ),
            'type'          => 'text',
            'default'       => '6',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_playlist_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_playlist_slideshow_orderby',
            'name'          => esc_html__( 'Order by', 'haru-vidi' ),
            'desc'          => esc_html__( 'Playlist Slideshow Order by.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'      => esc_html__( 'Date','haru-vidi' ),
                'title'     => esc_html__( 'Title','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order by', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_playlist_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_playlist_slideshow_order',
            'name'          => esc_html__( 'Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Playlist Slideshow Order.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'DESC'      => esc_html__( 'DESC','haru-vidi' ),
                'ASC'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_playlist_slideshow') ),
            ),
        ) );

        // Playlist TOP
        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_playlist_top_layout',
            'name'             => esc_html__( 'Playlist TOP Layout', 'haru-vidi' ),
            'desc'             => esc_html__( 'Playlist TOP Layout.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'               => esc_html__( 'List - Small Thumbnail Left', 'haru-vidi' ),
                'style-2'               => esc_html__( 'List - Thumbnail Fullwidth', 'haru-vidi' ),
                'style-3'               => esc_html__( 'Carousel - Bullets', 'haru-vidi' ),
                'style-4'               => esc_html__( 'Grid - 3 Columns', 'haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'   => 'images/shortcodes/playlist-top-default.jpg',
                'style-2'   => 'images/shortcodes/playlist-top-style-2.jpg',
                'style-3'   => 'images/shortcodes/playlist-top-style-3.jpg',
                'style-4'   => 'images/shortcodes/playlist-top-style-4.jpg',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Playlist TOP Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_playlist_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_playlist_top_title',
            'name'          => esc_html__( 'Playlist TOP title', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_playlist_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Playlist Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_playlist_top_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'playlist_category',
            'attributes'    => array(
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_playlist_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_playlist_top_order_by',
            'name'          => esc_html__( 'Playlist Order By', 'haru-vidi' ),
            'desc'          => esc_html__( 'Choose Playlist Order By', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'       => esc_html__( 'Date','haru-vidi' ),
                'view'      => esc_html__( 'Views','haru-vidi' ),
                'like'      => esc_html__( 'Like','haru-vidi' ),
                'dislike'      => esc_html__( 'DisLike','haru-vidi' ),
            ),
            'attributes'    => array(
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_playlist_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_playlist_top_order',
            'name'          => esc_html__( 'Playlist Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Choose Playlist Order', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'desc'      => esc_html__( 'DESC','haru-vidi' ),
                'asc'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_playlist_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_playlist_top_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Select Playlist per page.', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_playlist_top') ),
            ),
        ) );

        // Series Category
        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Series Category Layout', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_series_category_layout',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Series Category Layout.', 'haru-vidi' ),
            'default' => '',
            'options' => array(
                'default'               => esc_html__( 'Default','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_series_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Series Category Title', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_series_category_title',
            'type'    => 'text',
            'desc'    => esc_html__( 'Series Category Title.', 'haru-vidi' ),
            'default' => '',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_series_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Series Category Columns', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_series_category_columns',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Series Category Columns.', 'haru-vidi' ),
            'default' => '',
            'options' => array(
                '2'     => esc_html__( '2','haru-vidi' ),
                '3'     => esc_html__( '3','haru-vidi' ),
                '4'     => esc_html__( '4','haru-vidi' ),
                '5'     => esc_html__( '5','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_series_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Series Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_series_category_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'series_category',
            'desc'          => esc_html__( 'Series Category select Categories', 'haru-vidi' ),
            'default'       => '',
            'attributes'    => array(
                'required'               => false,
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_series_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_series_category_style',
            'name'             => esc_html__( 'Series Style', 'haru-vidi' ),
            'desc'             => esc_html__( 'Series Category series style. With Video style 6 Column auto equal 1.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'            => esc_html__( 'Default','haru-vidi' ),
                'series-style-2'     => esc_html__( 'Style 2','haru-vidi' ),
                'series-style-3'     => esc_html__( 'Style 3','haru-vidi' ),
                'series-style-4'     => esc_html__( 'Style 4','haru-vidi' ),
                'series-style-5'     => esc_html__( 'Style 5','haru-vidi' ),
                'series-style-6'     => esc_html__( 'Style 6','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'   => 'images/shortcodes/series-style-default.jpg',
                'series-style-2'   => 'images/shortcodes/series-style-2.jpg',
                'series-style-3'   => 'images/shortcodes/series-style-3.jpg',
                'series-style-4'   => 'images/shortcodes/series-style-4.jpg',
                'series-style-5'   => 'images/shortcodes/series-style-5.jpg',
                'series-style-6'   => 'images/shortcodes/series-style-6.jpg',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Select Series style', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_series_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_series_category_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Series Category posts per page.', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_series_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_series_category_orderby',
            'name'          => esc_html__( 'Order by', 'haru-vidi' ),
            'desc'          => esc_html__( 'Series Category Order by.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'      => esc_html__( 'Date','haru-vidi' ),
                'title'     => esc_html__( 'Title','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order by', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_series_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_series_category_order',
            'name'          => esc_html__( 'Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Series Category Order.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'DESC'      => esc_html__( 'DESC','haru-vidi' ),
                'ASC'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_series_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_series_category_filter',
            'name'          => esc_html__( 'Filter', 'haru-vidi' ),
            'desc'          => esc_html__( 'Series Category Show/hide Filter.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'show'      => esc_html__( 'Show','haru-vidi' ),
                'hide'      => esc_html__( 'Hide','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Filter', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_series_category') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_series_category_filter_all',
            'name'          => esc_html__( 'Filter All', 'haru-vidi' ),
            'desc'          => esc_html__( 'Series Category Show/hide All Filter.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'show'      => esc_html__( 'Show','haru-vidi' ),
                'hide'      => esc_html__( 'Hide','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Filter All', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_series_category_filter',
                'data-conditional-value'    => wp_json_encode( array('show') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_series_category_view_more',
            'name'          => esc_html__( 'View More', 'haru-vidi' ),
            'desc'          => esc_html__( 'Series Category view more button will go to category page. Ajax arrow will load more series via Ajax.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'button'      => esc_html__( 'Button','haru-vidi' ),
                'arrow'      => esc_html__( 'Arrow','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'View More', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_series_category') ),
            ),
        ) );

        // Series Slideshow shortcode options
        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Series Slideshow Title', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_series_slideshow_title',
            'type'    => 'text',
            'desc'    => esc_html__( 'Series Slideshow Title.', 'haru-vidi' ),
            'default' => '',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_series_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Series Slideshow Layout', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_series_slideshow_layout',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Series Slideshow Layout.', 'haru-vidi' ),
            'default' => '',
            'options' => array(
                'default'            => esc_html__( 'Default - Slick','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_series_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Series Slideshow Columns', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_series_slideshow_columns',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Series Slideshow Columns. With Featured List layout please set 1 Columns.', 'haru-vidi' ),
            'default' => '1',
            'options' => array(
                '1'     => esc_html__( '1','haru-vidi' ),
                '2'     => esc_html__( '2','haru-vidi' ),
                '3'     => esc_html__( '3','haru-vidi' ),
                '4'     => esc_html__( '4','haru-vidi' ),
                '5'     => esc_html__( '5','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_series_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'    => esc_html__( 'Data Source', 'haru-vidi' ),
            'id'      => 'haru_' . 'shortcode_series_slideshow_data_source',
            'type'    => 'pw_select',
            'desc'    => esc_html__( 'Series Slideshow Data Source.', 'haru-vidi' ),
            'default' => '',
            'options' => array(
                'categories'    => esc_html__( 'Categories','haru-vidi' ),
                'list_id'       => esc_html__( 'List IDs','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Shortcode Data Source', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_series_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Series Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_series_slideshow_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'series_category',
            'desc'          => esc_html__( 'Series Slideshow Categories.', 'haru-vidi' ),
            'attributes'    => array(
                'required'               => false,
                'data-conditional-id'    => 'haru_shortcode_series_slideshow_data_source',
                'data-conditional-value' => wp_json_encode( array('categories') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_series_slideshow_ids',
            'name'          => esc_html__( 'Series IDs', 'haru-vidi' ),
            'desc'          => esc_html__( 'Series Slideshow select Series.', 'haru-vidi' ),
            'type'          => 'pw_multiselect',
            'options'       => haru_vidi_get_cpt_list_options('haru_series'), // 'options_cb'
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Select Series', 'haru-vidi' ),
                'required'                  => false, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_series_slideshow_data_source',
                'data-conditional-value'    => wp_json_encode( array('list_id') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_series_slideshow_style',
            'name'             => esc_html__( 'Series Style', 'haru-vidi' ),
            'desc'             => esc_html__( 'Series Slideshow select series style.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'            => esc_html__( 'Default','haru-vidi' ),
                'series-style-2'     => esc_html__( 'Style 2','haru-vidi' ),
                'series-style-3'     => esc_html__( 'Style 3','haru-vidi' ),
                'series-style-4'     => esc_html__( 'Style 4','haru-vidi' ),
                'series-style-5'     => esc_html__( 'Style 5','haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'   => 'images/shortcodes/series-style-default.jpg',
                'series-style-2'   => 'images/shortcodes/series-style-2.jpg',
                'series-style-3'   => 'images/shortcodes/series-style-3.jpg',
                'series-style-4'   => 'images/shortcodes/series-style-4.jpg',
                'series-style-5'   => 'images/shortcodes/series-style-5.jpg',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Select Series style', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_series_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_series_slideshow_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Series Slideshow select Series per page.', 'haru-vidi' ),
            'type'          => 'text',
            'default'       => '6',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_series_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_series_slideshow_orderby',
            'name'          => esc_html__( 'Order by', 'haru-vidi' ),
            'desc'          => esc_html__( 'Series Slideshow Order by.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'      => esc_html__( 'Date','haru-vidi' ),
                'title'     => esc_html__( 'Title','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order by', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_series_slideshow') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_series_slideshow_order',
            'name'          => esc_html__( 'Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Series Slideshow Order.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'DESC'      => esc_html__( 'DESC','haru-vidi' ),
                'ASC'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Order', 'haru-vidi' ),
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_series_slideshow') ),
            ),
        ) );

        // Series TOP
        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_series_top_layout',
            'name'             => esc_html__( 'Series TOP Layout', 'haru-vidi' ),
            'desc'             => esc_html__( 'Series TOP Layout.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'               => esc_html__( 'List - Small Thumbnail Left', 'haru-vidi' ),
                'style-2'               => esc_html__( 'List - Thumbnail Fullwidth', 'haru-vidi' ),
                'style-3'               => esc_html__( 'Carousel - Bullets', 'haru-vidi' ),
                'style-4'               => esc_html__( 'Grid - 3 Columns', 'haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'   => 'images/shortcodes/series-top-default.jpg',
                'style-2'   => 'images/shortcodes/series-top-style-2.jpg',
                'style-3'   => 'images/shortcodes/series-top-style-3.jpg',
                'style-4'   => 'images/shortcodes/series-top-style-4.jpg',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Series TOP Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_series_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_series_top_title',
            'name'          => esc_html__( 'Series TOP title', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_series_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'name'          => esc_html__( 'Series Categories', 'haru-vidi' ),
            'id'            => 'haru_' . 'shortcode_series_top_category',
            'type'          => 'taxonomy_multicheck_inline',
            'taxonomy'      => 'series_category',
            'attributes'    => array(
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_series_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_series_top_order_by',
            'name'          => esc_html__( 'Series Order By', 'haru-vidi' ),
            'desc'          => esc_html__( 'Choose Series Order By', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'date'       => esc_html__( 'Date','haru-vidi' ),
                'view'      => esc_html__( 'Views','haru-vidi' ),
                'like'      => esc_html__( 'Like','haru-vidi' ),
                'dislike'      => esc_html__( 'DisLike','haru-vidi' ),
            ),
            'attributes'    => array(
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_series_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_series_top_order',
            'name'          => esc_html__( 'Series Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Choose Series Order', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'desc'      => esc_html__( 'DESC','haru-vidi' ),
                'asc'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_series_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_series_top_posts_per_page',
            'name'          => esc_html__( 'Posts Per Page', 'haru-vidi' ),
            'desc'          => esc_html__( 'Select Series per page.', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_series_top') ),
            ),
        ) );

        // Author (Member) TOP
        $shortcode_meta->add_field( array(
            'id'               => 'haru_' . 'shortcode_author_top_layout',
            'name'             => esc_html__( 'Author (Member) TOP Layout', 'haru-vidi' ),
            'desc'             => esc_html__( 'Author (Member) TOP Layout.', 'haru-vidi' ),
            'type'             => 'radio_image',
            'default'          => 'default',
            'options'          => array(
                'default'               => esc_html__( 'List - Thumbnail Left Rounded', 'haru-vidi' ),
                'style-2'               => esc_html__( 'List - Thumbnail Left Rounded No Border', 'haru-vidi' ),
            ),
            'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
            'images'           => array(
                'default'   => 'images/shortcodes/author-top-default.jpg',
                'style-2'   => 'images/shortcodes/author-top-style-2.jpg',
            ),
            'attributes'    => array(
                'placeholder'            => esc_html__( 'Choose Author (Member) TOP Layout', 'haru-vidi'),
                'required'               => true, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_author_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_author_top_title',
            'name'          => esc_html__( 'Author TOP title', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'required'               => false, // Will be required only if visible.
                'data-conditional-id'    => 'haru_shortcode_type',
                'data-conditional-value' => wp_json_encode( array('haru_author_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_author_top_order_by',
            'name'          => esc_html__( 'Author Order By', 'haru-vidi' ),
            'desc'          => esc_html__( 'Choose Author Order By', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'name'              => esc_html__( 'Name','haru-vidi' ),
                'post_count'        => esc_html__( 'Videos Created Count','haru-vidi' ),
            ),
            'attributes'    => array(
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_author_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_author_top_order',
            'name'          => esc_html__( 'Author Order', 'haru-vidi' ),
            'desc'          => esc_html__( 'Choose Author Order', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'desc'      => esc_html__( 'DESC','haru-vidi' ),
                'asc'       => esc_html__( 'ASC','haru-vidi' ),
            ),
            'attributes'    => array(
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_author_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_author_top_number',
            'name'          => esc_html__( 'Number', 'haru-vidi' ),
            'desc'          => esc_html__( 'Select Top Number to show.', 'haru-vidi' ),
            'type'          => 'text',
            'attributes'    => array(
                'type'                      => 'number',
                'required'                  => true, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_author_top') ),
            ),
        ) );

        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_author_top_dark_style',
            'name'          => esc_html__( 'Dark Style', 'haru-vidi' ),
            'desc'          => esc_html__( 'Enable/Disable style for background Dark. Now in Develope Mode and do not work.', 'haru-vidi' ),
            'type'          => 'pw_select',
            'options'       => array(
                'no'      => esc_html__( 'No','haru-vidi' ),
                'yes'     => esc_html__( 'Yes','haru-vidi' ),
            ),
            'attributes'    => array(
                'placeholder'               => esc_html__( 'Dark Style', 'haru-vidi' ),
                'required'                  => false, // Will be required only if visible.
                'data-conditional-id'       => 'haru_shortcode_type',
                'data-conditional-value'    => wp_json_encode( array('haru_author_top') ),
            ),
        ) );

        
        // General All shortcodes
        $shortcode_meta->add_field( array(
            'id'            => 'haru_' . 'shortcode_extra_class',
            'name'          => esc_html__( 'Extra Class', 'haru-vidi' ),
            'desc'          => esc_html__( 'Add extra class for shortcode.', 'haru-vidi' ),
            'type'          => 'text',
        ) );
    }

    add_action( 'cmb2_init', 'haru_vidi_field_metaboxes_shortcode' );
}
