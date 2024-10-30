<?php
/**
 *  
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2019, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

/* 
 * TABLE OF FUNCTIONS
 * 1.1. Watch Later Shortcode
 * 1.2. Watch Later Element
 * 2.1. Video Submit Shortcode
 * 2.2. Video List Shortcode
 * 2.3. Video Slideshow Shortcode
 * 2.4. Video Category Single Shortcode
 * 2.5. Video Category Shortcode
 * 2.6. Video Order Shortcode
 * 2.7. Video Order Single Shortcode
 * 2.8. Video Featured Shortcode
 * 2.9. Video TOP Shortcode
 * 2.10. Video Category Shortcode
 * 2.11. My Videos Shortcode
 * 3.1. Channel Shortcode
 * 3.2. Channel Slideshow Shortcode
 * 4.1. Playlist Shortcode
 * 4.2. Playlist Slideshow Shortcode
 * 5.1. Series Shortcode
 * 5.2. Series Slideshow Shortcode
 * 6. Author (Member) TOP Shortcode
 * 7. User Dashboard Shortcode
*/

/* 
 * 1.1. Watch Later Shortcode
*/
if ( !function_exists( 'haru_watch_later_shortcode' ) ) {
    function haru_watch_later_shortcode( $atts ) {
        $defaults_array =  array(
            'layout' => 'default'
        );
        $later = shortcode_atts( $defaults_array, $atts );

        // Example: $later['layout'];
        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'watch-later' . '.php', $later, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_watch_later', 'haru_watch_later_shortcode' );
}

/* 
 * 1.2. Watch Later Element
*/
if ( !function_exists( 'haru_watch_later_element' ) ) {
    function haru_watch_later_element( $atts ) {
        $defaults_array =  array(
            'layout' => 'default'
        );
        $later = shortcode_atts( $defaults_array, $atts );
        
        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'watch-later-element' . '.php', $later, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_watch_later_element', 'haru_watch_later_element');
}

/* 
 * 2.1. Video Submit Shortcode
*/
if ( !function_exists( 'haru_video_submit_shortcode' ) ) {
    function haru_video_submit_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'        => 'default',
            'playlist'      => 'show',
            'series'        => 'show',
            'channel'       => 'show',
            'actor'         => 'show',
            'director'      => 'show',
        );
        $submit = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'video-submit' . '.php', $submit, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_submit_video', 'haru_video_submit_shortcode' );
}

/* 
 * 2.2. Video List Shortcode
*/
if ( !function_exists( 'haru_video_list_shortcode' ) ) {
    function haru_video_list_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'columns'           => 'two', // 2,3,4,5
            'data_source'       => '', // categories/list_id
            'categories'        => '',
            'video_ids'         => '',
            'video_style'       => 'style_1', // style_1/style_2
            'posts_per_page'    => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'filter'            => 'show', // show/hide
            'paging_style'      => 'none', // none/default/load-more/infinite-scroll
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'video-list' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_video_list', 'haru_video_list_shortcode' );
}

/* 
 * 2.3. Video Slideshow Shortcode
*/
if ( !function_exists( 'haru_video_slideshow_shortcode' ) ) {
    function haru_video_slideshow_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'columns'           => '1', // 1,2,3,4,5
            'data_source'       => '', // categories/list_id
            'categories'        => '',
            'video_ids'         => '',
            'posts_per_page'    => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'video-slideshow' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_video_slideshow', 'haru_video_slideshow_shortcode' );
}

/* 
 * 2.4. Video Category Single Shortcode
*/
if ( !function_exists( 'haru_video_category_single_shortcode' ) ) {
    function haru_video_category_single_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'categories'        => '',
            'posts_per_page'    => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'view_more'         => 'show', // show/hide
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'video-category-single' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_video_category_single', 'haru_video_category_single_shortcode' );
}

/* 
 * 2.5. Video Category Shortcode
*/
if ( !function_exists( 'haru_video_category_shortcode' ) ) {
    function haru_video_category_shortcode( $atts ) {
        $defaults_array =  array(
            'title'             => '',
            'layout'            => 'default',
            'columns'           => '2', // 1,2,3,4,5
            'categories'        => '',
            'video_style'       => 'default', // default/style_2
            'posts_per_page'    => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'filter'            => 'show', // hide
            'filter_all'        => 'show', // hide
            'view_more'         => 'show', // show/hide
            'ajax_arrow'        => 'show', // hide
            'dark_style'        => 'no', // yes
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'video-category' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_video_category', 'haru_video_category_shortcode' );
}

/* 
 * 2.6. Video Order Shortcode
*/
if ( !function_exists( 'haru_video_order_shortcode' ) ) {
    function haru_video_order_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'columns'           => '1', // 2,3,4,5
            'order_tabs'        => '',
            'new_title'         => '',
            'view_title'        => '',
            'like_title'        => '',
            'random_title'      => '',
            'categories'        => '',
            'video_style'       => 'default', // default/video-style-2
            'posts_per_page'    => '',
            'ajax_arrow'        => 'show', // hide
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'video-order' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_video_order', 'haru_video_order_shortcode' );
}

/* 
 * 2.7. Video Order Single Shortcode
*/
if ( !function_exists( 'haru_video_order_single_shortcode' ) ) {
    function haru_video_order_single_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'order_tabs'        => '',
            'new_title'         => '',
            'view_title'        => '',
            'like_title'        => '',
            'random_title'      => '',
            'categories'        => '',
            'video_style'       => '',
            'columns'           => '',
            'posts_per_page'    => '',
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'video-order-single' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_video_order_single', 'haru_video_order_single_shortcode' );
}

/* 
 * 2.8. Video Featured Shortcode
*/
if ( !function_exists( 'haru_video_featured_shortcode' ) ) {
    function haru_video_featured_shortcode( $atts ) {
        $defaults_array =  array(
            'title'             => '',
            'layout'            => 'default',
            'categories'        => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'filter'            => 'show', // hide
            'filter_all'        => 'show', // hide
            'view_more'         => 'show', // hide
            'ajax_arrow'        => 'show', // hide
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'video-featured' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_video_featured', 'haru_video_featured_shortcode' );
}

/* 
 * 2.9. Video TOP Shortcode
*/
if ( !function_exists( 'haru_video_top_shortcode' ) ) {
    function haru_video_top_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'categories'        => '',
            'order_by'          => '',
            'order'             => '',
            'posts_per_page'    => '',
            'dark_style'        => 'no', // yes
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'video-top' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_video_top', 'haru_video_top_shortcode' );
}

/* 
 * 2.10. Video Category Shortcode
*/
if ( !function_exists( 'haru_video_list_category_shortcode' ) ) {
    function haru_video_list_category_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'orderby'           => '',
            'count'             => 0,
            'hierarchical'      => 0,
            'show_children_only'=> 0,
            'hide_empty'        => 0,
            'max_depth'         => '',
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'video-list-category' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_video_list_category', 'haru_video_list_category_shortcode' );
}

/* 
 * 2.11. My Videos Shortcode
*/
if ( !function_exists( 'haru_my_videos_shortcode' ) ) {
    function haru_my_videos_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'posts_per_page'    => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'video-my-videos' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_my_videos', 'haru_my_videos_shortcode' );
}

/* 
 * 2.12. Video Search Shortcode
*/
if ( !function_exists( 'haru_video_search_shortcode' ) ) {
    function haru_video_search_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'video-search' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_video_search', 'haru_video_search_shortcode' );
}

/* 
 * 3.1. Channel Shortcode
*/
if ( !function_exists( 'haru_channel_category_shortcode' ) ) {
    function haru_channel_category_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'columns'           => '1', // 2,3,4,5
            'categories'        => '',
            'channel_style'     => 'default', // default/channel-style-2
            'posts_per_page'    => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'filter'            => 'show', // hide
            'filter_all'        => 'show', // hide
            'view_more'         => 'show', // hide
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'channel-category' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_channel_category', 'haru_channel_category_shortcode' );
}

/* 
 * 3.2. Channel Slideshow Shortcode
*/
if ( !function_exists( 'haru_channel_slideshow_shortcode' ) ) {
    function haru_channel_slideshow_shortcode( $atts ) {
        $defaults_array =  array(
            'title'             => '',
            'layout'            => 'default',
            'columns'           => '1', // 1,2,3,4,5
            'data_source'       => '', // categories/list_id
            'categories'        => '',
            'channel_ids'       => '',
            'channel_style'     => 'style_1', // style_1/style_2
            'posts_per_page'    => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'channel-slideshow' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_channel_slideshow', 'haru_channel_slideshow_shortcode' );
}

/* 
 * 3.3. Channel TOP Shortcode
*/
if ( !function_exists( 'haru_channel_top_shortcode' ) ) {
    function haru_channel_top_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'categories'        => '',
            'order_by'          => '',
            'order'             => '',
            'posts_per_page'    => '',
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'channel-top' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_channel_top', 'haru_channel_top_shortcode' );
}

/* 
 * 3.4. Channel Submit Shortcode
*/
if ( !function_exists( 'haru_channel_submit_shortcode' ) ) {
    function haru_channel_submit_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'        => 'default',
            'playlist'      => 'show',
            'series'        => 'show',
            'channel'       => 'show',
            'actor'         => 'show',
            'director'      => 'show',
        );
        $submit = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'channel-submit' . '.php', $submit, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_submit_channel', 'haru_channel_submit_shortcode' );
}

/* 
 * 3.5. My Channels Shortcode
*/
if ( !function_exists( 'haru_my_channels_shortcode' ) ) {
    function haru_my_channels_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'posts_per_page'    => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'channel-my-channels' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_my_channels', 'haru_my_channels_shortcode' );
}

/* 
 * 4.1. Playlist Shortcode
*/
if ( !function_exists( 'haru_playlist_category_shortcode' ) ) {
    function haru_playlist_category_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'columns'           => '1', // 2,3,4,5
            'categories'        => '',
            'playlist_style'     => 'default', // default/playlist-style-2
            'posts_per_page'    => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'filter'            => 'show', // hide
            'filter_all'        => 'show', // hide
            'view_more'         => 'show', // hide
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'playlist-category' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_playlist_category', 'haru_playlist_category_shortcode' );
}

/* 
 * 4.2. Playlist Slideshow Shortcode
*/
if ( !function_exists( 'haru_playlist_slideshow_shortcode' ) ) {
    function haru_playlist_slideshow_shortcode( $atts ) {
        $defaults_array =  array(
            'title'             => '',
            'layout'            => 'default',
            'columns'           => '1', // 1,2,3,4,5
            'data_source'       => '', // categories/list_id
            'categories'        => '',
            'playlist_ids'      => '',
            'playlist_style'    => 'style_1', // style_1/style_2
            'posts_per_page'    => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'playlist-slideshow' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_playlist_slideshow', 'haru_playlist_slideshow_shortcode' );
}

/* 
 * 4.3. Playlist TOP Shortcode
*/
if ( !function_exists( 'haru_playlist_top_shortcode' ) ) {
    function haru_playlist_top_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'categories'        => '',
            'order_by'          => '',
            'order'             => '',
            'posts_per_page'    => '',
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'playlist-top' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_playlist_top', 'haru_playlist_top_shortcode' );
}

/* 
 * 4.4. My Playlists Shortcode
*/
if ( !function_exists( 'haru_my_playlists_shortcode' ) ) {
    function haru_my_playlists_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'posts_per_page'    => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'playlist-my-playlists' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_my_playlists', 'haru_my_playlists_shortcode' );
}

/* 
 * 5.1. Series Shortcode
*/
if ( !function_exists( 'haru_series_category_shortcode' ) ) {
    function haru_series_category_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'columns'           => '1', // 2,3,4,5
            'categories'        => '',
            'series_style'      => 'default', // default/series-style-2
            'posts_per_page'    => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'filter'            => 'show', // hide
            'filter_all'        => 'show', // hide
            'view_more'         => 'show', // hide
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'series-category' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_series_category', 'haru_series_category_shortcode' );
}

/* 
 * 5.2. Series Slideshow Shortcode
*/
if ( !function_exists( 'haru_series_slideshow_shortcode' ) ) {
    function haru_series_slideshow_shortcode( $atts ) {
        $defaults_array =  array(
            'title'             => '',
            'layout'            => 'default',
            'columns'           => '1', // 1,2,3,4,5
            'data_source'       => '', // categories/list_id
            'categories'        => '',
            'series_ids'        => '',
            'series_style'      => 'style_1', // style_1/style_2
            'posts_per_page'    => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'series-slideshow' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_series_slideshow', 'haru_series_slideshow_shortcode' );
}

/* 
 * 5.3. Series TOP Shortcode
*/
if ( !function_exists( 'haru_series_top_shortcode' ) ) {
    function haru_series_top_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'categories'        => '',
            'order_by'          => '',
            'order'             => '',
            'posts_per_page'    => '',
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'series-top' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_series_top', 'haru_series_top_shortcode' );
}

/* 
 * 5.4. My Series Shortcode
*/
if ( !function_exists( 'haru_my_seriess_shortcode' ) ) {
    function haru_my_seriess_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'posts_per_page'    => '',
            'orderby'           => 'date', // title
            'order'             => 'DESC', // ASC
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'series-my-seriess' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_my_seriess', 'haru_my_seriess_shortcode' );
}

/* 
 * 6. Author (Member) TOP Shortcode
*/
if ( !function_exists( 'haru_author_top_shortcode' ) ) {
    function haru_author_top_shortcode( $atts ) {
        $defaults_array =  array(
            'layout'            => 'default',
            'title'             => '',
            'order_by'          => '',
            'order'             => '',
            'number'            => '',
            'dark_style'        => 'no', // yes
            'extra_class'       => '',
        );
        $options = shortcode_atts( $defaults_array, $atts );

        ob_start();
        echo haru_vidi_get_shortcode_template('vidi/shortcodes/'. 'author-top' . '.php', $options, '', '');
        $content = ob_get_clean();

        return $content;
    }

    add_shortcode( 'haru_author_top', 'haru_author_top_shortcode' );
}


