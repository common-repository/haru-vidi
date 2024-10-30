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
 * 1. 
*/


/* 
 * 1. Check Cookie
*/
if ( !function_exists( 'haru_check_watch_later_cookie_status' ) ) {
    function haru_check_watch_later_cookie_status() {
        global $watch_later_cookie;

        if ( isset( $_COOKIE['haruwatchlatervideos'] ) ) {
            $watch_later_cookie = array_filter( explode( ',', trim( $_COOKIE['haruwatchlatervideos'] ) ) );
        } else {
            $watch_later_cookie = array();
        }
    }

    add_action( 'init', 'haru_check_watch_later_cookie_status', 1 );
}

/* 
 * 2. Watch Later Video List
*/
if ( !function_exists( 'haru_watch_later_videos' ) ) {
    function haru_watch_later_videos() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'watch-later-videos' . '.php', array(), '', '');
    }

    add_action( 'haru_watch_later_videos', 'haru_watch_later_videos', 5 );
}

/* 
 * 4. Video Player functions 
*/
if ( !function_exists( 'haru_single_video_player' ) ) {
    function haru_single_video_player() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'single-video-player' . '.php', array(), '', '');
    }

    add_action( 'haru_single_video_player', 'haru_single_video_player', 10, 3 );
}

/* 
 * 5. Video Player Toolbar
*/
if ( !function_exists( 'haru_video_player_toolbar' ) ) {
    function haru_video_player_toolbar() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-toolbar' . '.php', array(), '', '');
    }

    add_action( 'haru_video_player_toolbar', 'haru_video_player_toolbar', 10, 3 );
}


/* 
 * 5. Video Player Direct function
*/
if ( !function_exists( 'haru_video_player_direct' ) ) {
    function haru_video_player_direct() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-direct' . '.php', array(), '', '');
    }

    add_action( 'haru_video_player_direct', 'haru_video_player_direct', 10, 3 );
}

/* 
 * 5. Video Player Popup function
*/
if ( !function_exists( 'haru_video_player_popup' ) ) {
    function haru_video_player_popup() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-popup' . '.php', array(), '', '');
    }

    add_action( 'haru_video_player_popup', 'haru_video_player_popup', 10, 3 );
}

// Ajax Video Popup
if ( !function_exists( 'haru_video_player_popup_content' ) ) {
    function haru_video_player_popup_content() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-popup-content' . '.php', array(), '', '');
    }

    add_action( 'wp_ajax_haru_video_player_popup_content', 'haru_video_player_popup_content' );
    add_action( 'wp_ajax_nopriv_haru_video_player_popup_content', 'haru_video_player_popup_content' );
}

// Get Video Popup Ajax
if ( !function_exists( 'haru_get_video_player_popup_ajax' ) ) {
    function haru_get_video_player_popup_ajax() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-popup-ajax' . '.php', array(), '', '');
    }

    add_action( 'wp_ajax_haru_get_video_player_popup_ajax', 'haru_get_video_player_popup_ajax' );
    add_action( 'wp_ajax_nopriv_haru_get_video_player_popup_ajax', 'haru_get_video_player_popup_ajax' );
}

/* 
 * 6. Channel Subscribe button function
*/
if ( !function_exists( 'haru_channel_subscribe_button' ) ) {
    function haru_channel_subscribe_button( $channel_id ) {
        $loggedIn = 'no';
        $subscribe_list = array();
        $class_subscribe    = '';

        if ( is_user_logged_in() ) {  
            $loggedIn           = 'yes';          
            $current_user       = wp_get_current_user();
            $user_id            = (int)$current_user->ID;
            
            if ( get_the_author_meta('_post_subscribe_list', $user_id) !== NULL && get_the_author_meta('_post_subscribe_list', $user_id) != '' ) {
                $subscribe_list     = get_the_author_meta('_post_subscribe_list', $user_id);
            }

            if ( in_array($channel_id, $subscribe_list) ) {
                $class_subscribe = 'subscribed';
            }
        }
        ?>
        <a href="javascript:;" 
            class="channel-subscribe button-background button-background--small <?php echo esc_attr( $class_subscribe ); ?>" 
            data-channel_id="<?php echo esc_attr( $channel_id ); ?>"
            data-login="<?php echo esc_attr( $loggedIn ); ?>"
            data-login_url="<?php echo haru_get_login_url(); ?>"
            data-text_subscribe="<?php echo esc_html__( 'Subscribe', 'haru-vidi' ); ?>"
            data-text_subscribed="<?php echo esc_html__( 'Unsubscribe', 'haru-vidi' ); ?>"
        >
            <span class="status-subscribe"><i class="haru-icon haru-user-plus"></i></span>
            <span class="status-subscribed"><i class="haru-icon haru-user-times"></i></span>
            <span class="text-subscribe"><?php echo ( in_array($channel_id, $subscribe_list) ) ? esc_html__( 'Unsubscribe', 'haru-vidi' ) : esc_html__( 'Subscribe', 'haru-vidi' ); ?></span>
            <?php echo haru_count_channel_subscribed( $channel_id ); ?>
        </a>
    <?php
    }
}

if ( ! function_exists( 'haru_count_channel_subscribed' ) ) {
    function haru_count_channel_subscribed( $channel_id, $unit = false ) {    
        $subscribe_count = (int)get_post_meta( $channel_id, '_post_subscribe_count', true );

        // Fake Subscribe
        $fake_subscribe = get_post_meta($channel_id, 'haru_fake_subscribe', true);
        if ( $fake_subscribe == 'on' ) {
            $fake_subscribe_count = (int)get_post_meta($channel_id, 'haru_fake_subscribe_count', true);
        } else {
            $fake_subscribe_count = 0;
        }

        $subscribe_count += $fake_subscribe_count;

        $subscribe_return = '<span class="count-subscribed">' . haru_format_count_number($subscribe_count) . '</span>';

        if ( $unit == false ) {
            return $subscribe_return;
        } else {
            if ( $subscribe_count > 1 ) {
                $subscribe_return .= '<span class="count-subscribed-unit">' . esc_html__( ' subscribers', 'haru-vidi' ) . '</span>';
            } else {
                $subscribe_return .= '<span class="count-subscribed-unit">' . esc_html__( ' subscriber', 'haru-vidi' ) . '</span>';
            }

            return $subscribe_return;
        }
    }
}

if ( !function_exists( 'haru_channel_subscribe' ) ) {
    function haru_channel_subscribe() {
        if ( !isset($_POST['channel_id']) || empty( $_POST['channel_id'] ) ) {
            die;
        }

        $channel_id = $_POST['channel_id'];

        $return = array();
        $subscribe_list = array();

        // Fake Subscribe
        $fake_subscribe = get_post_meta($channel_id, 'haru_fake_subscribe', true);
        if ( $fake_subscribe == 'on' ) {
            $fake_subscribe_count = (int)get_post_meta($channel_id, 'haru_fake_subscribe_count', true);
        } else {
            $fake_subscribe_count = 0;
        }

        if ( !is_user_logged_in() ) {
            $return['ID']   = 1;
            $return['message']     = esc_html__( 'Please login to subscribe.', 'haru-vidi' );

            wp_send_json($return); // https://codex.wordpress.org/Function_Reference/wp_send_json         
        } else {
            $current_user   = wp_get_current_user();
            $user_id        = (int)$current_user->ID;
            $channel_id     = $_POST['channel_id'];
            // Get subscribe count for the current channel
            $subscribe_count = (int)get_post_meta( $channel_id, '_post_subscribe_count', true );
            if ( get_the_author_meta('_post_subscribe_list', $user_id) !== NULL && get_the_author_meta('_post_subscribe_list', $user_id) != '' ) {
                $subscribe_list = get_the_author_meta('_post_subscribe_list', $user_id);
            }

            if ( !in_array($channel_id, $subscribe_list) ) {
                array_push($subscribe_list, (string)$channel_id);

                update_user_meta( $user_id, '_post_subscribe_list', $subscribe_list );
                // Update post
                update_post_meta( $channel_id, '_post_subscribe_count', $subscribe_count + 1);
                update_post_meta( $channel_id, '_post_subscribe_count_total', $fake_subscribe_count + $subscribe_count + 1);
                $return['channel_subscribed'] = 1;
                $return['channel_subscribed_count'] = $fake_subscribe_count + $subscribe_count + 1;
            } else {
                if ( ($key = array_search((string)$channel_id, $subscribe_list)) !== false ) {
                    unset($subscribe_list[$key]);
                }

                update_user_meta( $user_id, '_post_subscribe_list', $subscribe_list );
                // Update post
                update_post_meta( $channel_id, '_post_subscribe_count', $subscribe_count - 1);
                update_post_meta( $channel_id, '_post_subscribe_count_total', $fake_subscribe_count + $subscribe_count - 1);
                $return['channel_subscribed'] = 0;
                $return['channel_subscribed_count'] = $fake_subscribe_count + $subscribe_count - 1;
            }

            wp_send_json($return);
        }

        die;
    }
}

add_action('wp_ajax_haru_channel_subscribe', 'haru_channel_subscribe');
add_action('wp_ajax_nopriv_haru_channel_subscribe', 'haru_channel_subscribe');


if ( !function_exists( 'haru_video_report' ) ) {
    function haru_video_report() {
        if ( !isset($_POST['video_id']) || empty( $_POST['video_id'] ) ) {
            die;
        }

        $video_id       = $_POST['video_id'];
        $report_content = $_POST['report_content'];
        $current_user   = wp_get_current_user();
        $user_id        = (int)$current_user->ID;
        $report_meta    = $video_id . '_' . $user_id;

        $return = array();

        if ( haru_video_report_check( $video_id ) == true ) {
            $return['status'] = 'reported';
            $return['message'] = esc_html__( 'You already reported this video!', 'haru-vidi' );

            return;
        }

        $post_data = array();                                            
        $post_data['post_title']    = esc_html__( 'Video Report: ' , 'haru-vidi' ) . get_the_title( $video_id ) . esc_html__( ' by ' , 'haru-vidi' ) . $current_user->display_name; 
        $post_data['post_status']   = 'publish';
        $post_data['post_type']     = 'haru_video_report';
        
        $new_report_id = wp_insert_post( $post_data, true );
        
        if ( $new_report_id && !is_wp_error($new_report_id)  ) {
            // Update post
            update_post_meta($new_report_id, 'haru_video_report_meta', $report_meta);
            update_post_meta($new_report_id, 'haru_video_report_content', $report_content);
            $return['status'] = 'success';
            $return['message'] = esc_html__( 'You have just reported this video. Thanks so much!', 'haru-vidi' );
            // @TODO: send email
        } else {
            $return['status'] = 'failed';
            $return['message'] = esc_html__( 'Video reported failed! Please try again later!', 'haru-vidi' );
        }

        wp_send_json($return);

        die;
    }
}

add_action('wp_ajax_haru_video_report', 'haru_video_report');
add_action('wp_ajax_nopriv_haru_video_report', 'haru_video_report');

if ( !function_exists( 'haru_video_report_check' ) ) {
    function haru_video_report_check( $video_id ) {
        $current_user   = wp_get_current_user();
        $user_id        = (int)$current_user->ID;
        $report_meta    = $video_id . '_' . $user_id;

        $video_reports = new WP_Query(array(
            'post_type'         => 'haru_video_report',
            'post_status'       => 'any',
            'posts_per_page'    => -1,           
            'meta_query'        => array(
                array(
                    'key'     => 'haru_video_report_meta',
                    'value'   => $report_meta,
                    'compare' => '=',
                ),
            ),
        ));

        if ( $video_reports->have_posts() ) {         

            return true;
        }

        return false;
    }
}

/* 
 * 6. Get Random in Array by Weight 
*/
if ( !function_exists( 'haru_get_random_by_weight' ) ) {
    function haru_get_random_by_weight(array $video_ads) {
        $ads_arr = array();
        $count_arr = array();
        $ads_arr_rand = array();
        foreach ( $video_ads as $key => $ad ) {
            $ad_weight = (int)get_post_meta( $ad, 'haru_advertising_priority', true );
            if ( $ad_weight == '' ) {
                $ad_weight = 1;
            }
            $ads_arr[$ad] = $ad_weight;
            $count_arr[$ad] = 0;
        }
        $sumOfWeights = array_sum($ads_arr);

        for ( $i = 0; $i < 100; $i++ ) {
            $random = rand( 1, $sumOfWeights ); 
            foreach ( $ads_arr as $name => $weighting ) {
                $random -= $weighting;
                if ( $random <= 0 ) {
                    $count_arr[$name]++; 
                    break;
                }
            }
        }

        foreach ($count_arr as $name => $result) {
            $ads_arr_rand[$name] = $result;
        }
        asort($ads_arr_rand);

        return $ads_arr_rand;
    }
}

/* 
 * 7. Video Lightbox
*/
if ( !function_exists( 'haru_video_lightbox' ) ) {
    function haru_video_lightbox() {
        ?>
        <div class="haru-lightbox-overlay"></div>
        <div class="haru-lightbox"><div class="close-lightbox"><i class="haru-icon haru-times"></i></div></div>
        <?php
    }

    add_action( 'haru_after_page_main', 'haru_video_lightbox', 15 );
}

/* 
 * 7. Video Thumbnail
*/
if ( !function_exists( 'haru_video_thumbnail' ) ) {
    function haru_video_thumbnail( $post_id ) {
        $video_screenshot = get_post_meta( get_the_ID(), 'haru_video_screenshot', true );
        if ( $video_screenshot != '' ) {
            $screenshot_count = count($video_screenshot);
        } else {
            $screenshot_count = 0;
        }
        if ( $screenshot_count > 5 ) {
            $screenshot_count = 5;
        }
        $video_thumbnail_type = haru_vidi_get_setting( 'vidi-thumbnail-settings', 'haru_video_thumbnail_type', 'image' );
        $video_thumbnail_size = haru_vidi_get_setting( 'vidi-thumbnail-settings', 'haru_video_thumbnail_size', 'default' );
        ?>
        <div class="video-thumbnail <?php echo esc_attr( $video_thumbnail_type . ' ' . $video_thumbnail_size ); ?>" data-speed="1000">
            <img src="<?php echo esc_url( get_the_post_thumbnail_url( $post_id, 'full' ) ? get_the_post_thumbnail_url( $post_id, 'full' ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>">
            <?php
            if ( $video_thumbnail_type == 'slideshow' ) :
                if ( isset($video_screenshot) && !empty($video_screenshot) ) :
                    $i = 0;
                    foreach( $video_screenshot as $key => $screenshot ) :
                        if ( $i <= 5 ) :
            ?>
            <img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php echo esc_attr( get_the_title( $post_id ) ); ?>">
            <?php 
                        endif;
                        $i++;
                    endforeach;
                endif;
            endif;
        ?>
        </div>
        <?php
    }
}

/* 
 * 7. Playlist Thumbnail
*/
if ( !function_exists( 'haru_playlist_thumbnail' ) ) {
    function haru_playlist_thumbnail( $playlist_id ) {
        $attached_videos = get_post_meta( get_the_ID(), 'haru_playlist_attached_videos', true );
        $video_args = array(
            'post__in'           => $attached_videos,
            'posts_per_page'     => -1,
            'post_type'          => 'haru_video',
            'orderby'            => 'post__in',
            'post_status'        => 'publish',
        );
        $list_videos         = new WP_Query( $video_args );

        $thumbnail_count = $list_videos->found_posts;
        ?>
        <div class="playlist-thumbnail" data-speed="1000">
            <img src="<?php echo esc_url( get_the_post_thumbnail_url( $playlist_id, 'full' ) ? get_the_post_thumbnail_url( $playlist_id, 'full' ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title( $playlist_id ) ); ?>">
            <?php
            if ( isset($attached_videos) && !empty($attached_videos) ) :
                $i = 1;
                foreach( $attached_videos as $key => $thumbnail ) :
                    if ( $i <= $thumbnail_count ) :
            ?>
            <img src="<?php echo get_the_post_thumbnail_url( $thumbnail, 'full' ); ?>" alt="<?php echo esc_attr( get_the_title( $playlist_id ) ); ?>">
            <?php 
                    endif;
                    $i++;
                endforeach;
            endif;
        ?>
        </div>
        <?php
    }
}

if ( !function_exists( 'haru_series_thumbnail' ) ) {
    function haru_series_thumbnail( $series_id ) {
        $attached_videos = get_post_meta( get_the_ID(), 'haru_series_attached_videos', true );

        $video_args = array(
            'post__in'           => $attached_videos,
            'posts_per_page'     => -1,
            'post_type'          => 'haru_video',
            'orderby'            => 'post__in',
            'post_status'        => 'publish',
        );
        $list_videos         = new WP_Query( $video_args );

        $thumbnail_count = $list_videos->found_posts;
        ?>
        <div class="series-thumbnail" data-speed="1000">
            <img src="<?php echo esc_url( get_the_post_thumbnail_url( $series_id, 'full' ) ? get_the_post_thumbnail_url( $series_id, 'full' ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title( $series_id ) ); ?>">
            <?php
            if ( isset($attached_videos) && !empty($attached_videos) ) :
                $i = 1;
                foreach( $attached_videos as $key => $thumbnail ) :
                    if ( $i <= $thumbnail_count ) :
            ?>
            <img src="<?php echo get_the_post_thumbnail_url( $thumbnail, 'full' ); ?>" alt="<?php echo esc_attr( get_the_title( $series_id ) ); ?>">
            <?php 
                    endif;
                    $i++;
                endforeach;
            endif;
        ?>
        </div>
        <?php
    }
}

/* 8. Post per page archive CPT */
add_action('pre_get_posts','haru_set_posts_per_page_cpt');
function haru_set_posts_per_page_cpt($query) {
    if ( $query->is_main_query() && !is_admin() ) {
        // Archive video
        if ( is_post_type_archive( 'haru_video' ) || is_tax( 'video_category' ) || is_tax( 'video_tag' ) ) {
            $archive_per_page = haru_vidi_get_setting( 'vidi-videos-settings', 'archive_videos_settings_per_page', '' );
            if ( $archive_per_page != '' ) {
                $posts_per_page = $archive_per_page;
            }
        }

        if ( is_post_type_archive( 'haru_playlist' ) || is_tax( 'playlist_category' ) || is_tax( 'playlist_tag' ) ) {
            $archive_per_page = haru_vidi_get_setting( 'vidi-playlists-settings', 'archive_playlists_settings_per_page', '' );
            if ( $archive_per_page != '' ) {
                $posts_per_page = $archive_per_page;
            }
        }

        if ( is_post_type_archive( 'haru_series' ) || is_tax( 'series_category' ) || is_tax( 'series_tag' ) ) {
            $archive_per_page = haru_vidi_get_setting( 'vidi-seriess-settings', 'archive_seriess_settings_per_page', '' );
            if ( $archive_per_page != '' ) {
                $posts_per_page = $archive_per_page;
            }
        }

        if ( is_post_type_archive( 'haru_channel' ) || is_tax( 'channel_category' ) || is_tax( 'channel_tag' ) ) {
            $archive_per_page = haru_vidi_get_setting( 'vidi-channels-settings', 'archive_channels_settings_per_page', '' );
            if ( $archive_per_page != '' ) {
                $posts_per_page = $archive_per_page;
            }
        }

        if ( is_post_type_archive( 'haru_actor' ) || is_tax( 'actor_category' ) || is_tax( 'actor_tag' ) ) {
            $archive_per_page = haru_vidi_get_setting( 'vidi-actors-settings', 'archive_actors_settings_per_page', '' );
            if ( $archive_per_page != '' ) {
                $posts_per_page = $archive_per_page;
            }
        }

        if ( is_post_type_archive( 'haru_director' ) || is_tax( 'director_category' ) || is_tax( 'director_tag' ) ) {
            $archive_per_page = haru_vidi_get_setting( 'vidi-directors-settings', 'archive_directors_settings_per_page', '' );
            if ( $archive_per_page != '' ) {
                $posts_per_page = $archive_per_page;
            }
        }
        
        if ( isset($posts_per_page) && ( $posts_per_page != '' ) ) {
            $query->set('posts_per_page', $posts_per_page );
        }

        if ( isset($_GET['orderby']) && ( $_GET['orderby'] != '' ) ) {
            $query->set('orderby', $_GET['orderby'] );
        }

        if ( isset($_GET['order']) && ( $_GET['order'] != '' ) ) {
            $query->set('order', $_GET['order'] );
        }
    }
}

/* 7.1. Paging Load More */
if ( !function_exists('haru_paging_load_more_cpt') ) {
    function haru_paging_load_more_cpt() {
        global $wp_query;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        $link = get_next_posts_page_link($wp_query->max_num_pages);
        if ( !empty($link) ) :
            ?>
            <button data-href="<?php echo esc_url($link); ?>" type="button" class="video-load-more button-background button-background--primary button-background--medium"><i class="haru-icon haru-spinner haru-spin loading-icon"></i>
                <?php echo esc_html__( 'Load More', 'haru-vidi' ); ?>
            </button>
        <?php
        endif;
    }
}

/* 7.2. Paging Infinite Scroll */
if ( !function_exists('haru_paging_infinitescroll_cpt') ) {
    function haru_paging_infinitescroll_cpt() {
        global $wp_query;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        $link = get_next_posts_page_link($wp_query->max_num_pages);
        if ( !empty($link) ) :
            ?>
            <nav id="infinite_scroll_button" data-max-page="<?php echo esc_attr( $wp_query->max_num_pages ); ?>" data-msgText="<?php echo esc_attr__( 'Loading...', 'haru-vidi' ); ?>" data-finishedMsg="<?php echo esc_attr__( 'All items loaded.', 'haru-vidi' ); ?>">
                <a href="<?php echo esc_url($link); ?>"></a>
            </nav>
            <div id="infinite_scroll_loading" class="align-center infinite-scroll-loading"></div>
        <?php
        endif;
    }
}

/* 7.3. Paging Nav */
if ( ! function_exists( 'haru_paging_nav_cpt' ) ) {
    function haru_paging_nav_cpt() {
        the_posts_pagination(
            array(
                'mid_size'  => 1,
                'prev_text' => esc_html__( 'Prev', 'haru-vidi' ),
                'next_text' => esc_html__( 'Next', 'haru-vidi' )
            )
        );
    }
}

// 
if ( !function_exists('haru_get_archive_url') ) {
    function haru_get_archive_url() {
        global $wp;

        $current_url = home_url( $wp->request );
        $paging = strpos( $current_url , '/page' );
        $archive_url = ( $paging ) ? substr( $current_url, 0, $paging ) : $current_url;

        return add_query_arg( array(
                    $wp->query_string => '',
                    'paged' => '1'
                ), trailingslashit( $archive_url ) );
    }
}

// Pagination in single CPT
if ( !function_exists('haru_template_redirect_single_cpt') ) {
    function haru_template_redirect_single_cpt() {
        if ( is_singular( 'haru_channel' ) ) {
            global $wp_query;

            $page = ( int ) $wp_query->get( 'page' );
            if ( $page > 1 ) {
                // convert 'page' to 'paged'
                $query->set( 'page', 1 );
                $query->set( 'paged', $page );
            }
            // prevent redirect
            remove_action( 'template_redirect', 'redirect_canonical' );
        }
    }
}
add_action('template_redirect', 'haru_template_redirect_single_cpt', 0); // on priority 0 to remove 'redirect_canonical' added with priority 10

// Count Playlist videos
if ( !function_exists('haru_count_playlist_videos') ) {
    function haru_count_playlist_videos( $playlist_id ) {
        $attached_videos = get_post_meta( $playlist_id, 'haru_playlist_attached_videos', true );
        
        $video_args = array(
            'post__in'           => $attached_videos,
            'posts_per_page'     => -1,
            'post_type'          => 'haru_video',
            'orderby'            => 'post__in',
            'post_status'        => 'publish',
        );
        $list_videos         = new WP_Query( $video_args );

        $video_count = $list_videos->found_posts;

        if ( $video_count > 1 ) {
            return $video_count . esc_html__( ' videos', 'haru-vidi' );
        } else {
            return $video_count . esc_html__( ' video', 'haru-vidi' );
        }
    }
}

// Count Series videos
if ( !function_exists('haru_count_series_videos') ) {
    function haru_count_series_videos( $series_id ) {
        $attached_videos = get_post_meta( $series_id, 'haru_series_attached_videos', true );

        $video_args = array(
            'post__in'           => $attached_videos,
            'posts_per_page'     => -1,
            'post_type'          => 'haru_video',
            'orderby'            => 'post__in',
            'post_status'        => 'publish',
        );
        $list_videos         = new WP_Query( $video_args );

        $video_count = $list_videos->found_posts;

        if ( $video_count > 1 ) {
            $video_count .= '<span>' . esc_html__( ' videos', 'haru-vidi' ) . '</span>';
        } else {
            $video_count .= '<span>' . esc_html__( ' video', 'haru-vidi' ) . '</span>';
        }

        return $video_count;
    }
}

// Count Channel videos
if ( !function_exists('haru_count_channel_videos') ) {
    function haru_count_channel_videos( $channel_id ) {
        $attached_videos = get_post_meta( $channel_id, 'haru_channel_attached_videos', true );

        $video_args = array(
            'post__in'           => $attached_videos,
            'posts_per_page'     => -1,
            'post_type'          => 'haru_video',
            'orderby'            => 'post__in',
            'post_status'        => 'publish',
        );
        $list_videos         = new WP_Query( $video_args );

        $video_count = $list_videos->found_posts;

        if ( $video_count > 1 ) {
            $video_count .= '<span>' . esc_html__( ' videos', 'haru-vidi' ) . '</span>';
        } else {
            $video_count .= '<span>' . esc_html__( ' video', 'haru-vidi' ) . '</span>';
        }

        return $video_count;
    }
}

// Count Actor videos
if ( !function_exists('haru_count_actor_videos') ) {
    function haru_count_actor_videos( $actor_id ) {
        $attached_videos = get_post_meta( $actor_id, 'haru_actor_attached_videos', true );

        $video_args = array(
            'post__in'           => $attached_videos,
            'posts_per_page'     => -1,
            'post_type'          => 'haru_video',
            'orderby'            => 'post__in',
            'post_status'        => 'publish',
        );
        $list_videos         = new WP_Query( $video_args );

        $video_count = $list_videos->found_posts;

        if ( $video_count > 1 ) {
            $video_count .= '<span>' . esc_html__( ' videos', 'haru-vidi' ) . '</span>';
        } else {
            $video_count .= '<span>' . esc_html__( ' video', 'haru-vidi' ) . '</span>';
        }

        return $video_count;
    }
}

// Count Director videos
if ( !function_exists('haru_count_director_videos') ) {
    function haru_count_director_videos( $director_id ) {
        $attached_videos = get_post_meta( $director_id, 'haru_director_attached_videos', true );

        $video_args = array(
            'post__in'           => $attached_videos,
            'posts_per_page'     => -1,
            'post_type'          => 'haru_video',
            'orderby'            => 'post__in',
            'post_status'        => 'publish',
        );
        $list_videos         = new WP_Query( $video_args );

        $video_count = $list_videos->found_posts;

        if ( $video_count > 1 ) {
            $video_count .= '<span>' . esc_html__( ' videos', 'haru-vidi' ) . '</span>';
        } else {
            $video_count .= '<span>' . esc_html__( ' video', 'haru-vidi' ) . '</span>';
        }

        return $video_count;
    }
}

// Count Author videos
if ( !function_exists('haru_count_author_videos') ) {
    function haru_count_author_videos( $author_id ) {
        $args = array(
            'post_type'             => 'haru_video',
            'posts_per_page'        => -1,
            'post_status'           => 'publish',
            'author'                => $author_id,
        );
        
        $videos = new WP_Query( $args );
        $video_count = $videos->found_posts;

        if ( $video_count > 1 ) {
            $video_count .= '<span>' . esc_html__( ' videos', 'haru-vidi' ) . '</span>';
        } else {
            $video_count .= '<span>' . esc_html__( ' video', 'haru-vidi' ) . '</span>';
        }

        return $video_count;
    }
}

// Add items to menu
add_action( 'admin_menu', 'haru_post_status_menu' );
if ( !function_exists('haru_post_status_menu') ) {
    function haru_post_status_menu() {

        if ( !current_user_can( 'edit_posts' ) ) {
            return;
        }

        global $submenu;

        // Add Pending Sub menu for these posttypes
        $wp_post_types = array(
            'post'          => esc_html__( 'Posts', 'haru-vidi' ),
            'haru_video'    => esc_html__( 'Video', 'haru-vidi' ),
            'haru_playlist' => esc_html__( 'Playlist', 'haru-vidi' ),
            'haru_series'   => esc_html__( 'Series', 'haru-vidi' ),
            'haru_channel'  => esc_html__( 'Channel', 'haru-vidi' ),
        );

        // Loop through the post types array we just got
        foreach( $wp_post_types as $wp_type_id => $wp_type_name ) {
            
            if ( ( $wp_type_id === 'page' ) && !current_user_can( 'edit_pages' ) ) {
                continue;
            }

            // An array of all the statuses
            $wp_statuses = get_post_stati( array( 'show_in_admin_status_list' => true ), 'objects' );

            // Show statuses you want
            $wp_statuses = array(
                'pending' => $wp_statuses['pending'] 
            );

            // Get status counts of all post types
            $wp_status_counts = wp_count_posts( $wp_type_id );

            // Get the correct submenu. Posts are a weird case.
            if ( $wp_type_id == 'post' ) {
                $menu = 'edit.php';
            } else {
                $menu = 'edit.php?post_type=' . $wp_type_id;
            }

            // Loop through statuses array
            foreach ( $wp_statuses as $key => $status ) {
                $wp_status_id = $status->name;
                $wp_status_count = $wp_status_counts -> $wp_status_id;

                // If a status has any posts, show it
                if ( $wp_status_count > 0 ) {
                    // Get the plural post status label
                    $wp_status_label = $status->label;
                    $submenu[$menu][] = array(
                        sprintf(
                            '%1$s (%2$s)',
                            esc_attr( $wp_status_label ),
                            intval( $wp_status_count )
                        ),
                        'read',
                        sprintf(
                            'edit.php?post_status=%1$s&post_type=%2$s',
                            $wp_status_id,
                            $wp_type_id
                        )
                    );
                }
            }
        }
    }
}

// Get prev video URL
if ( !function_exists('haru_get_prev_video_url') ) {
    function haru_get_prev_video_url( $video_id ) {
        global $post;
        
        $oldGlobal = $post;
        $post = get_post( $video_id );
        $prev_video = get_previous_post();
        $post = $oldGlobal;
        $prev_link = '';
        $prev_id = '';
        $prev_return = array();

        if ( !empty( $prev_video ) ) {
            $prev_link = get_permalink( $prev_video->ID );
            $prev_id = $prev_video->ID;
        }

        $playlist_slug = haru_vidi_get_playlist_slug();
        if ( isset($_GET[$playlist_slug]) && trim($_GET[$playlist_slug]) != '' ) {
            $playlist_id = $_GET[$playlist_slug];

            if ( $playlist_id != 'watch-later' ) {
                $playlist_video_ids = get_post_meta( $playlist_id, 'haru_playlist_attached_videos', true );

                // Process pending Videos
                $video_args = array(
                    'post__in'           => $playlist_video_ids,
                    'posts_per_page'     => -1,
                    'post_type'          => 'haru_video',
                    'orderby'            => 'post__in',
                    'post_status'        => 'publish',
                );
                $list_videos         = new WP_Query( $video_args );

                $playlist_video_ids = array();

                if ( $list_videos->have_posts() ) :
                    while ( $list_videos->have_posts() ) : $list_videos->the_post();
                        $playlist_video_ids[] = get_the_ID();
                    endwhile;
                endif;
                wp_reset_query();

                $current_key = array_search( $video_id, $playlist_video_ids );
                $video_count = count($playlist_video_ids);

                if ( $video_count >= 2 ) {
                    if ( $current_key <= 0 ) {
                        $prev_id = '';
                        $prev_link = '';
                    } else if ( 0 < $current_key && $current_key < ($video_count - 1) ) {
                        $prev_key = $current_key - 1;
                        $prev_id = $playlist_video_ids[$prev_key];
                        $prev_link = get_permalink( $prev_id ) . '?' . $playlist_slug . '=' . $playlist_id;
                    } else {
                        $prev_key = $current_key - 1;
                        $prev_id = $playlist_video_ids[$prev_key];
                        $prev_link = get_permalink( $prev_id ) . '?' . $playlist_slug . '=' . $playlist_id;
                    }
                } else {
                    $prev_id = '';
                    $prev_link = '';
                }
            }

            // Watch later playlist
            if ( $playlist_id == 'watch-later' ) {
                global $watch_later_cookie;

                $playlist_id = 'watch-later';

                $playlist_video_ids = $watch_later_cookie;

                // @TODO: Process pending Videos

                $current_key = array_search( $video_id, $playlist_video_ids );
                $video_count = count($playlist_video_ids);

                if ( $video_count >= 2 ) {
                    if ( $current_key <= 1 ) {
                        $prev_id = '';
                        $prev_link = '';
                    } else if ( 1 < $current_key && $current_key < $video_count ) {
                        $prev_key = $current_key - 1;
                        $prev_id = $playlist_video_ids[$prev_key];
                        $prev_link = get_permalink( $prev_id ) . '?' . $playlist_slug . '=' . $playlist_id;
                    } else {
                        $prev_key = $current_key - 1;
                        $prev_id = $playlist_video_ids[$prev_key];
                        $prev_link = get_permalink( $prev_id ) . '?' . $playlist_slug . '=' . $playlist_id;
                    }
                } else {
                    $prev_id = '';
                    $prev_link = '';
                }
            }
        }

        $series_slug = haru_vidi_get_series_slug();
        if ( isset($_GET[$series_slug]) && trim($_GET[$series_slug]) != '' ) {
            $series_id = $_GET[$series_slug];
            $series_video_ids = get_post_meta( $series_id, 'haru_series_attached_videos', true );

            // Process pending Videos
            $video_args = array(
                'post__in'           => $series_video_ids,
                'posts_per_page'     => -1,
                'post_type'          => 'haru_video',
                'orderby'            => 'post__in',
                'post_status'        => 'publish',
            );
            $list_videos         = new WP_Query( $video_args );

            $series_video_ids = array();

            if ( $list_videos->have_posts() ) :
                while ( $list_videos->have_posts() ) : $list_videos->the_post();
                    $series_video_ids[] = get_the_ID();
                endwhile;
            endif;
            wp_reset_query();

            $current_key = array_search( $video_id, $series_video_ids );
            $video_count = count($series_video_ids);

            if ( $video_count >= 2 ) {
                if ( $current_key <= 0 ) {
                    $prev_id = '';
                    $prev_link = '';
                } else if ( 0 < $current_key && $current_key < ($video_count - 1) ) {
                    $prev_key = $current_key - 1;
                    $prev_id = $series_video_ids[$prev_key];
                    $prev_link = get_permalink( $prev_id ) . '?' . $series_slug . '=' . $series_id;
                } else {
                    $prev_key = $current_key - 1;
                    $prev_id = $series_video_ids[$prev_key];
                    $prev_link = get_permalink( $prev_id ) . '?' . $series_slug . '=' . $series_id;
                }
            } else {
                $prev_id = '';
                $prev_link = '';
            }
        }

        $actor_slug = haru_vidi_get_actor_slug();
        if ( isset($_GET[$actor_slug]) && trim($_GET[$actor_slug]) != '' ) {
            $actor_id = $_GET[$actor_slug];
            $actor_video_ids = get_post_meta( $actor_id, 'haru_actor_attached_videos', true );

            // Process pending Videos
            $video_args = array(
                'post__in'           => $actor_video_ids,
                'posts_per_page'     => -1,
                'post_type'          => 'haru_video',
                'orderby'            => 'post__in',
                'post_status'        => 'publish',
            );
            $list_videos         = new WP_Query( $video_args );

            $actor_video_ids = array();

            if ( $list_videos->have_posts() ) :
                while ( $list_videos->have_posts() ) : $list_videos->the_post();
                    $actor_video_ids[] = get_the_ID();
                endwhile;
            endif;
            wp_reset_query();

            $current_key = array_search( $video_id, $actor_video_ids );
            $video_count = count($actor_video_ids);

            if ( $video_count >= 2 ) {
                if ( $current_key <= 0 ) {
                    $prev_id = '';
                    $prev_link = '';
                } else if ( 0 < $current_key && $current_key < ($video_count - 1) ) {
                    $prev_key = $current_key - 1;
                    $prev_id = $actor_video_ids[$prev_key];
                    $prev_link = get_permalink( $prev_id ) . '?' . $actor_slug . '=' . $actor_id;
                } else {
                    $prev_key = $current_key - 1;
                    $prev_id = $actor_video_ids[$prev_key];
                    $prev_link = get_permalink( $prev_id ) . '?' . $actor_slug . '=' . $actor_id;
                }
            } else {
                $prev_id = '';
                $prev_link = '';
            }
        }

        $director_slug = haru_vidi_get_director_slug();
        if ( isset($_GET[$director_slug]) && trim($_GET[$director_slug]) != '' ) {
            $director_id = $_GET[$director_slug];
            $director_video_ids = get_post_meta( $director_id, 'haru_director_attached_videos', true );

            // Process pending Videos
            $video_args = array(
                'post__in'           => $director_video_ids,
                'posts_per_page'     => -1,
                'post_type'          => 'haru_video',
                'orderby'            => 'post__in',
                'post_status'        => 'publish',
            );
            $list_videos         = new WP_Query( $video_args );

            $director_video_ids = array();

            if ( $list_videos->have_posts() ) :
                while ( $list_videos->have_posts() ) : $list_videos->the_post();
                    $director_video_ids[] = get_the_ID();
                endwhile;
            endif;
            wp_reset_query();

            $current_key = array_search( $video_id, $director_video_ids );
            $video_count = count($director_video_ids);

            if ( $video_count >= 2 ) {
                if ( $current_key <= 0 ) {
                    $prev_id = '';
                    $prev_link = '';
                } else if ( 0 < $current_key && $current_key < ($video_count - 1) ) {
                    $prev_key = $current_key - 1;
                    $prev_id = $director_video_ids[$prev_key];
                    $prev_link = get_permalink( $prev_id ) . '?' . $director_slug . '=' . $director_id;
                } else {
                    $prev_key = $current_key - 1;
                    $prev_id = $director_video_ids[$prev_key];
                    $prev_link = get_permalink( $prev_id ) . '?' . $director_slug . '=' . $director_id;
                }
            } else {
                $prev_id = '';
                $prev_link = '';
            }
        }

        $prev_return['ID'] = $prev_id;
        $prev_return['link'] = $prev_link;

        return $prev_return;
    }
}

// Get next video URL: https://wordpress.stackexchange.com/questions/55259/get-previous-next-posts-by-post-id
if ( !function_exists('haru_get_next_video_url') ) {
    function haru_get_next_video_url( $video_id ) {
        global $post;
        $oldGlobal = $post;
        $post = get_post( $video_id );
        $next_video = get_next_post();
        $post = $oldGlobal;
        $next_link = '';
        $next_id = '';
        $next_return = array();

        if ( !empty( $next_video ) ) {
            $next_link = get_permalink( $next_video->ID );
            $next_id = $next_video->ID;
        }

        $playlist_slug = haru_vidi_get_playlist_slug();
        if ( isset($_GET[$playlist_slug]) && trim($_GET[$playlist_slug]) != '' ) {
            $playlist_id = $_GET[$playlist_slug];

            if ( $playlist_id != 'watch-later' ) {
                $playlist_video_ids = get_post_meta( $playlist_id, 'haru_playlist_attached_videos', true );

                // Process pending Videos
                $video_args = array(
                    'post__in'           => $playlist_video_ids,
                    'posts_per_page'     => -1,
                    'post_type'          => 'haru_video',
                    'orderby'            => 'post__in',
                    'post_status'        => 'publish',
                );
                $list_videos         = new WP_Query( $video_args );

                $playlist_video_ids = array();

                if ( $list_videos->have_posts() ) :
                    while ( $list_videos->have_posts() ) : $list_videos->the_post();
                        $playlist_video_ids[] = get_the_ID();
                    endwhile;
                endif;
                wp_reset_query();

                $current_key = array_search( $video_id, $playlist_video_ids );
                $video_count = count($playlist_video_ids);

                if ( $video_count >= 2 ) {
                    if ( $current_key <= 0 ) {
                        $next_key = $current_key + 1;
                        $next_id = $playlist_video_ids[$next_key];
                        $next_link = get_permalink( $next_id ) . '?' . $playlist_slug . '=' . $playlist_id;
                    } else if ( 0 < $current_key && $current_key < ($video_count - 1) ) {
                        $next_key = $current_key + 1;
                        $next_id = $playlist_video_ids[$next_key];
                        $next_link = get_permalink( $next_id ) . '?' . $playlist_slug . '=' . $playlist_id;
                    } else {
                        $next_id = '';
                        $next_link = '';
                    }
                } else {
                    $next_id = '';
                    $next_link = '';
                }
            }


            // Watch later playlist
            if ( $playlist_id == 'watch-later' ) {
                global $watch_later_cookie;

                $playlist_id = 'watch-later';

                $playlist_video_ids = $watch_later_cookie;

                // @TODO: Process pending Videos?

                $current_key = array_search( $video_id, $playlist_video_ids );
                $video_count = count($playlist_video_ids);

                if ( $video_count >= 2 ) {
                    if ( $current_key <= 1 ) {
                        $next_key = $current_key + 1;
                        $next_id = $playlist_video_ids[$next_key];
                        $next_link = get_permalink( $next_id ) . '?' . $playlist_slug . '=' . $playlist_id;
                    } else if ( 1 < $current_key && $current_key < $video_count ) {
                        $next_key = $current_key + 1;
                        $next_id = $playlist_video_ids[$next_key];
                        $next_link = get_permalink( $next_id ) . '?' . $playlist_slug . '=' . $playlist_id;
                    } else {
                        $next_id = '';
                        $next_link = '';
                    }
                } else {
                    $next_id = '';
                    $next_link = '';
                }
            }
        }

        $series_slug = haru_vidi_get_series_slug();
        if ( isset($_GET[$series_slug]) && trim($_GET[$series_slug]) != '' ) {
            $series_id = $_GET[$series_slug];
            $series_video_ids = get_post_meta( $series_id, 'haru_series_attached_videos', true );

            // Process pending Videos
            $video_args = array(
                'post__in'           => $series_video_ids,
                'posts_per_page'     => -1,
                'post_type'          => 'haru_video',
                'orderby'            => 'post__in',
                'post_status'        => 'publish',
            );
            $list_videos         = new WP_Query( $video_args );

            $series_video_ids = array();

            if ( $list_videos->have_posts() ) :
                while ( $list_videos->have_posts() ) : $list_videos->the_post();
                    $series_video_ids[] = get_the_ID();
                endwhile;
            endif;
            wp_reset_query();

            $current_key = array_search( $video_id, $series_video_ids );
            $video_count = count($series_video_ids);

            if ( $video_count >= 2 ) {
                if ( $current_key <= 0 ) {
                    $next_key = $current_key + 1;
                    $next_id = $series_video_ids[$next_key];
                    $next_link = get_permalink( $next_id ) . '?' . $series_slug . '=' . $series_id;
                } else if ( 0 < $current_key && $current_key < ($video_count - 1) ) {
                    $next_key = $current_key + 1;
                    $next_id = $series_video_ids[$next_key];
                    $next_link = get_permalink( $next_id ) . '?' . $series_slug . '=' . $series_id;
                } else {
                    $next_id = '';
                    $next_link = '';
                }
            } else {
                $next_id = '';
                $next_link = '';
            }
        }

        $actor_slug = haru_vidi_get_actor_slug();
        if ( isset($_GET[$actor_slug]) && trim($_GET[$actor_slug]) != '' ) {
            $actor_id = $_GET[$actor_slug];
            $actor_video_ids = get_post_meta( $actor_id, 'haru_actor_attached_videos', true );

            // Process pending Videos
            $video_args = array(
                'post__in'           => $actor_video_ids,
                'posts_per_page'     => -1,
                'post_type'          => 'haru_video',
                'orderby'            => 'post__in',
                'post_status'        => 'publish',
            );
            $list_videos         = new WP_Query( $video_args );

            $actor_video_ids = array();

            if ( $list_videos->have_posts() ) :
                while ( $list_videos->have_posts() ) : $list_videos->the_post();
                    $actor_video_ids[] = get_the_ID();
                endwhile;
            endif;
            wp_reset_query();

            $current_key = array_search( $video_id, $actor_video_ids );
            $video_count = count($actor_video_ids);

            if ( $video_count >= 2 ) {
                if ( $current_key <= 0 ) {
                    $next_key = $current_key + 1;
                    $next_id = $actor_video_ids[$next_key];
                    $next_link = get_permalink( $next_id ) . '?'. $actor_slug . '=' . $actor_id;
                } else if ( 0 < $current_key && $current_key < ($video_count - 1) ) {
                    $next_key = $current_key + 1;
                    $next_id = $actor_video_ids[$next_key];
                    $next_link = get_permalink( $next_id ) . '?'. $actor_slug . '=' . $actor_id;
                } else {
                    $next_id = '';
                    $next_link = '';
                }
            } else {
                $next_id = '';
                $next_link = '';
            }
        }

        $director_slug = haru_vidi_get_director_slug();
        if ( isset($_GET[$director_slug]) && trim($_GET[$director_slug]) != '' ) {
            $director_id = $_GET[$director_slug];
            $director_video_ids = get_post_meta( $director_id, 'haru_director_attached_videos', true );

            // Process pending Videos
            $video_args = array(
                'post__in'           => $director_video_ids,
                'posts_per_page'     => -1,
                'post_type'          => 'haru_video',
                'orderby'            => 'post__in',
                'post_status'        => 'publish',
            );
            $list_videos         = new WP_Query( $video_args );

            $director_video_ids = array();

            if ( $list_videos->have_posts() ) :
                while ( $list_videos->have_posts() ) : $list_videos->the_post();
                    $director_video_ids[] = get_the_ID();
                endwhile;
            endif;
            wp_reset_query();

            $current_key = array_search( $video_id, $director_video_ids );
            $video_count = count($director_video_ids);

            if ( $video_count >= 2 ) {
                if ( $current_key <= 0 ) {
                    $next_key = $current_key + 1;
                    $next_id = $director_video_ids[$next_key];
                    $next_link = get_permalink( $next_id ) . '?' . $director_slug . '=' . $director_id;
                } else if ( 0 < $current_key && $current_key < ($video_count - 1) ) {
                    $next_key = $current_key + 1;
                    $next_id = $director_video_ids[$next_key];
                    $next_link = get_permalink( $next_id ) . '?' . $director_slug . '=' . $director_id;
                } else {
                    $next_id = '';
                    $next_link = '';
                }
            } else {
                $next_id = '';
                $next_link = '';
            }
        }

        $next_return['ID'] = $next_id;
        $next_return['link'] = $next_link;

        return $next_return;
    }
}

// Toolbar Action
if ( !function_exists('haru_video_player_toolbar_action_rating') ) {
    function haru_video_player_toolbar_action_rating() {
        haru_display_rating( get_the_ID() );
    }
}
add_action( 'haru_video_player_toolbar_action', 'haru_video_player_toolbar_action_rating', 5);

if ( !function_exists('haru_video_player_toolbar_action_watch_later') ) {
    function haru_video_player_toolbar_action_watch_later() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-toolbar-action-watch-later' . '.php', array(), '', '');
    }
}
add_action( 'haru_video_player_toolbar_action', 'haru_video_player_toolbar_action_watch_later', 10);

if ( !function_exists('haru_video_player_toolbar_action_report') ) {
    function haru_video_player_toolbar_action_report() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-toolbar-action-report' . '.php', array(), '', '');
    }
}
add_action( 'haru_video_player_toolbar_action', 'haru_video_player_toolbar_action_report', 15);

if ( !function_exists('haru_video_player_toolbar_action_light') ) {
    function haru_video_player_toolbar_action_light() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-toolbar-action-light' . '.php', array(), '', '');
    }
}
add_action( 'haru_video_player_toolbar_action', 'haru_video_player_toolbar_action_light', 20);

if ( !function_exists('haru_video_player_toolbar_action_share') ) {
    function haru_video_player_toolbar_action_share() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-toolbar-action-share' . '.php', array(), '', '');
    }
}
add_action( 'haru_video_player_toolbar_action', 'haru_video_player_toolbar_action_share', 20);

if ( !function_exists('haru_video_player_toolbar_action_next_prev') ) {
    function haru_video_player_toolbar_action_next_prev() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-toolbar-action-next-prev' . '.php', array(), '', '');
    }
}
add_action( 'haru_video_player_toolbar_action', 'haru_video_player_toolbar_action_next_prev', 25);

if ( !function_exists('haru_video_player_toolbar_action_more') ) {
    function haru_video_player_toolbar_action_more() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-toolbar-action-more' . '.php', array(), '', '');
    }
}
add_action( 'haru_video_player_toolbar_action', 'haru_video_player_toolbar_action_more', 30);

if ( !function_exists('haru_video_player_toolbar_action_auto_next') ) {
    function haru_video_player_toolbar_action_auto_next() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-toolbar-action-auto-next' . '.php', array(), '', '');
    }
}
add_action( 'haru_video_player_toolbar_action', 'haru_video_player_toolbar_action_auto_next', 35);


// Toolbar Group
if ( !function_exists('haru_video_player_toolbar_group_report') ) {
    function haru_video_player_toolbar_group_report() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-toolbar-group-report' . '.php', array(), '', '');
    }
}
add_action( 'haru_video_player_toolbar_group', 'haru_video_player_toolbar_group_report', 5);

if ( !function_exists('haru_video_player_toolbar_group_more') ) {
    function haru_video_player_toolbar_group_more() {
        echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-toolbar-group-more' . '.php', array(), '', '');
    }
}
add_action( 'haru_video_player_toolbar_group', 'haru_video_player_toolbar_group_more', 10);

