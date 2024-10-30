<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

/* Author Load More Video */
if ( !function_exists('haru_author_paging_load_more_video') ) {
    function haru_author_paging_load_more_video() {
        global $wp_query;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        ?>
        <div class="author-pagination-cpt">
            <button 
                type="button"
                data-current_page="1"
                data-max_page="<?php echo esc_attr( $wp_query->max_num_pages ); ?>"
                data-posts_per_page="6"
                class="author-video-load-more button-background button-background--primary button-background--medium"
            ><i class="haru-icon haru-spinner haru-spin loading-icon"></i>
                <?php echo esc_html__( 'Load More', 'haru-vidi' ); ?>
            </button>
        </div>
        <?php
    }
}

add_action( 'wp_ajax_haru_author_get_video', 'haru_author_get_video' );
add_action( 'wp_ajax_nopriv_haru_author_get_video', 'haru_author_get_video' );

if ( !function_exists( 'haru_author_get_video' ) ) {
    function haru_author_get_video() {
        if ( empty($_POST['current_page']) || empty( $_POST['max_page'] ) ) {
            die('0');
        }

        $current_page       = (int)$_POST['current_page'];
        $max_page           = (int)$_POST['max_page'];
        $posts_per_page     = (int)$_POST['posts_per_page'];
        $author             = get_user_by( 'slug', get_query_var( 'author_name' ) );
        $author_id          = $author->ID;

        ob_start();

        $offset = $current_page * $posts_per_page;

        $args = array(
            'post_type'             => 'haru_video',
            'posts_per_page'        => $posts_per_page,
            'offset'                => $offset,
            'post_status'           => 'publish',
            'author'                => $author_id,
        );
        
        $videos = new WP_Query( $args );
        ?>
        
        <div class="video-list grid-columns grid-columns__3 animated fadeIn haru-clear">
            <?php
                if ( $videos->have_posts() ) {
                    while ( $videos->have_posts() ) { 
                        $videos->the_post();
                        echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array(), '', '');
                    }
                }
            ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

/* Author Load More Playlist */
if ( !function_exists('haru_author_paging_load_more_playlist') ) {
    function haru_author_paging_load_more_playlist() {
        global $wp_query;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        ?>
        <div class="author-pagination-cpt">
            <button 
                type="button"
                data-current_page="1"
                data-max_page="<?php echo esc_attr( $wp_query->max_num_pages ); ?>"
                data-posts_per_page="1"
                class="author-playlist-load-more button-background button-background--primary button-background--medium"
            ><i class="haru-icon haru-spinner haru-spin loading-icon"></i>
                <?php echo esc_html__( 'Load More', 'haru-vidi' ); ?>
            </button>
        </div>
        <?php
    }
}

add_action( 'wp_ajax_haru_author_get_playlist', 'haru_author_get_playlist' );
add_action( 'wp_ajax_nopriv_haru_author_get_playlist', 'haru_author_get_playlist' );

if ( !function_exists( 'haru_author_get_playlist' ) ) {
    function haru_author_get_playlist() {
        if ( empty($_POST['current_page']) || empty( $_POST['max_page'] ) ) {
            die('0');
        }

        $current_page       = (int)$_POST['current_page'];
        $max_page           = (int)$_POST['max_page'];
        $posts_per_page     = (int)$_POST['posts_per_page'];
        $author             = get_user_by( 'slug', get_query_var( 'author_name' ) );
        $author_id          = $author->ID;

        ob_start();

        $offset = $current_page * $posts_per_page;

        $args = array(
            'post_type'             => 'haru_playlist',
            'posts_per_page'        => $posts_per_page,
            'offset'                => $offset,
            'post_status'           => 'publish',
            'author'                => $author_id,
        );
        
        $playlists = new WP_Query( $args );
        ?>
        
        <div class="playlist-list grid-columns grid-columns__3 animated fadeIn haru-clear">
            <?php
                if ( $playlists->have_posts() ) {
                    while ( $playlists->have_posts() ) { 
                        $playlists->the_post();
                        echo haru_vidi_get_shortcode_template('vidi/playlist/'. 'content-playlist' . '.php', array(), '', '');
                    }
                }
            ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

/* Author Load More Series */
if ( !function_exists('haru_author_paging_load_more_series') ) {
    function haru_author_paging_load_more_series() {
        global $wp_query;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        ?>
        <div class="author-pagination-cpt">
            <button 
                type="button"
                data-current_page="1"
                data-max_page="<?php echo esc_attr( $wp_query->max_num_pages ); ?>"
                data-posts_per_page="1"
                class="author-series-load-more button-background button-background--primary button-background--medium"
            ><i class="haru-icon haru-spinner haru-spin loading-icon"></i>
                <?php echo esc_html__( 'Load More', 'haru-vidi' ); ?>
            </button>
        </div>
        <?php
    }
}

add_action( 'wp_ajax_haru_author_get_series', 'haru_author_get_series' );
add_action( 'wp_ajax_nopriv_haru_author_get_series', 'haru_author_get_series' );

if ( !function_exists( 'haru_author_get_series' ) ) {
    function haru_author_get_series() {
        if ( empty($_POST['current_page']) || empty( $_POST['max_page'] ) ) {
            die('0');
        }

        $current_page       = (int)$_POST['current_page'];
        $max_page           = (int)$_POST['max_page'];
        $posts_per_page     = (int)$_POST['posts_per_page'];
        $author             = get_user_by( 'slug', get_query_var( 'author_name' ) );
        $author_id          = $author->ID;

        ob_start();

        $offset = $current_page * $posts_per_page;

        $args = array(
            'post_type'             => 'haru_series',
            'posts_per_page'        => $posts_per_page,
            'offset'                => $offset,
            'post_status'           => 'publish',
            'author'                => $author_id,
        );
        
        $seriess = new WP_Query( $args );
        ?>
        
        <div class="series-list grid-columns grid-columns__3 animated fadeIn haru-clear">
            <?php
                if ( $seriess->have_posts() ) {
                    while ( $seriess->have_posts() ) { 
                        $seriess->the_post();
                        echo haru_vidi_get_shortcode_template('vidi/series/'. 'content-series' . '.php', array(), '', '');
                    }
                }
            ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

/* Author Load More Channel */
if ( !function_exists('haru_author_paging_load_more_channel') ) {
    function haru_author_paging_load_more_channel() {
        global $wp_query;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        ?>
        <div class="author-pagination-cpt">
            <button 
                type="button"
                data-current_page="1"
                data-max_page="<?php echo esc_attr( $wp_query->max_num_pages ); ?>"
                data-posts_per_page="1"
                class="author-channel-load-more button-background button-background--primary button-background--medium"
            ><i class="haru-icon haru-spinner haru-spin loading-icon"></i>
                <?php echo esc_html__( 'Load More', 'haru-vidi' ); ?>
            </button>
        </div>
        <?php
    }
}

add_action( 'wp_ajax_haru_author_get_channel', 'haru_author_get_channel' );
add_action( 'wp_ajax_nopriv_haru_author_get_channel', 'haru_author_get_channel' );

if ( !function_exists( 'haru_author_get_channel' ) ) {
    function haru_author_get_channel() {
        if ( empty($_POST['current_page']) || empty( $_POST['max_page'] ) ) {
            die('0');
        }

        $current_page       = (int)$_POST['current_page'];
        $max_page           = (int)$_POST['max_page'];
        $posts_per_page     = (int)$_POST['posts_per_page'];
        $author             = get_user_by( 'slug', get_query_var( 'author_name' ) );
        $author_id          = $author->ID;

        ob_start();

        $offset = $current_page * $posts_per_page;

        $args = array(
            'post_type'             => 'haru_channel',
            'posts_per_page'        => $posts_per_page,
            'offset'                => $offset,
            'post_status'           => 'publish',
            'author'                => $author_id,
        );
        
        $channels = new WP_Query( $args );
        ?>
        
        <div class="channel-list grid-columns grid-columns__3 animated fadeIn haru-clear">
            <?php
                if ( $channels->have_posts() ) {
                    while ( $channels->have_posts() ) { 
                        $channels->the_post();
                        echo haru_vidi_get_shortcode_template('vidi/channel/'. 'content-channel' . '.php', array(), '', '');
                    }
                }
            ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

