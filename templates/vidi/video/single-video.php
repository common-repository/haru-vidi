<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

get_header();
// Load script
wp_enqueue_style( 'slick', plugins_url( PLUGIN_HARU_VIDI_NAME.'/assets/libraries/slick/slick.css'), array() );
wp_enqueue_script( 'slick', plugins_url( PLUGIN_HARU_VIDI_NAME.'/assets/libraries/slick/slick.min.js'), array( 'jquery' ), '', true );
wp_enqueue_script( 'mCustomScrollbar', plugins_url( PLUGIN_HARU_VIDI_NAME.'/assets/libraries/mCustomScrollbar/jquery.mCustomScrollbar.js'), array( 'jquery' ), true, false );
wp_enqueue_style( 'mCustomScrollbar', plugins_url( PLUGIN_HARU_VIDI_NAME.'/assets/libraries/mCustomScrollbar/jquery.mCustomScrollbar.min.css'), array(), true, 'all' );

$single_layout_full = haru_vidi_get_setting( 'vidi-videos-settings', 'single_video_settings_layout_full', 'off' );
$single_layout_sidebar = haru_vidi_get_setting( 'vidi-videos-settings', 'single_video_settings_sidebar', 'sidebar-none' );
$single_sidebar_left = haru_vidi_get_setting( 'vidi-videos-settings', 'single_video_settings_sidebar_left', '' );
$single_sidebar_right = haru_vidi_get_setting( 'vidi-videos-settings', 'single_video_settings_sidebar_right', '' );
$single_style = haru_vidi_get_setting( 'vidi-videos-settings', 'single_video_settings_style', 'style-1' );

?>
<div class="haru-single-breadcrumbs">
    <div class="<?php echo esc_attr( $single_layout_full == 'on' ? 'full-width' : 'haru-container' ); ?>">
        <?php echo haru_vidi_cpt_breadcrumbs(); ?>
    </div>
</div>
<div class="haru-single-video <?php echo esc_attr( $single_layout_full == 'on' ? '' : 'haru-container' ); ?>">
    <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post(); 

            $single_style = haru_vidi_get_setting( 'vidi-videos-settings', 'single_video_settings_style', 'single-style-1' );

            $related = false;
            if ( $single_style == 'single-style-2' ) {
                $related = true;
            }

            $playlist = false;
            $playlist_slug = haru_vidi_get_playlist_slug();
            if ( isset($_GET[$playlist_slug]) && trim($_GET[$playlist_slug]) != '' ) {                   
                $playlist = true;
                $playlist_id = $_GET[$playlist_slug];
            }

            $series = false;
            $series_slug = haru_vidi_get_series_slug();
            $single_video_series_style = 'video-series-style-1';
            if ( isset($_GET[$series_slug]) && trim($_GET[$series_slug]) != '' ) {                   
                $series = true;
                $series_id = $_GET[$series_slug];
            }

            $actor = false;
            $actor_slug = haru_vidi_get_actor_slug();
            if ( isset($_GET[$actor_slug]) && trim($_GET[$actor_slug]) != '' ) {                   
                $actor = true;
                $actor_id = $_GET[$actor_slug];
            }

            $director = false;
            $director_slug = haru_vidi_get_director_slug();
            if ( isset($_GET[$director_slug]) && trim($_GET[$director_slug]) != '' ) {                   
                $director = true;
                $director_id = $_GET[$director_slug];
            }
    ?>
    <div class="single-video-wrap <?php echo esc_attr( ($related == true || $playlist == true || $actor == true || $director == true) ? 'in-playlist' : '' ); ?>">
        <div class="single-video-main">
            <div class="single-video-player-wrap">
                <div class="single-video-player">
                    <?php do_action( 'haru_single_video_player' ); ?>
                </div>
                <div class="single-video-toolbar">
                    <?php do_action( 'haru_video_player_toolbar' ); ?>
                </div>
            </div>
            
            <h6 class="single-video-title"><?php the_title(); ?></h6>
            <div class="single-video-category"><?php echo get_the_term_list( get_the_ID(), 'video_category', '', ' ' ); ?></div>

            <div class="single-video-meta-top">
                <div class="single-video-meta-left">
                    <div class="single-video-view"><?php haru_get_post_views( get_the_ID() ); ?></div>
                    <div class="single-video-date"><i class="fa fa-calendar"></i><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
                </div>
                <div class="single-video-meta-right">
                    <div class="single-video-rating">
                        <div class="post-rating-count">
                            <?php haru_display_like_count( get_the_ID() ); ?>
                            <?php haru_display_dislike_count( get_the_ID() ); ?>
                        </div>
                        <?php haru_display_rating_bar( get_the_ID() ); ?>
                    </div>
                    
                    <!-- Screenshot -->
                    <?php
                        $video_screenshot = get_post_meta( get_the_ID(), 'haru_video_screenshot', true );
                        if ( isset($video_screenshot) && !empty($video_screenshot) ) :
                    ?>
                    <div class="single-video-screenshots">
                        <a href="javascript:;" class="single-video-screenshot-btn"><i class="haru-icon haru-file-image"></i><?php echo esc_html__( 'Screenshots', 'haru-vidi' ); ?></a>
                        <div class="video-screenshots">
                            <?php foreach( $video_screenshot as $screenshot ) : ?>
                                <a href="<?php echo esc_url( $screenshot ); ?>" class="video-screenshot"></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <!-- More actions -->

                </div>
            </div>
        </div>

        <!-- Playlist -->
        <?php if ( ($related == true) || ($playlist == true) || ($actor == true) || ($director == true) ) : ?>
            <div class="single-video-playlist">
                <?php
                    if ( $playlist == true ) {
                        $playlist_video_ids = get_post_meta( $playlist_id, 'haru_playlist_attached_videos', true );
                        $playlist_slug = haru_vidi_get_playlist_slug();
                        $playlist_id = $playlist_id;
                        $playlist_title = get_the_title( $playlist_id );
                        $playlist_url = get_permalink( $playlist_id );

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

                        // Watch later playlist
                        if ( $playlist_id == 'watch-later' ) {
                            global $watch_later_cookie;

                            $playlist_video_ids = $watch_later_cookie;
                            $playlist_title = esc_html__( 'My Watch Later list', 'haru-vidi' );
                            $haru_watch_later_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_watch_later_page', '' );
                            $playlist_url = ( $haru_watch_later_page != '' && is_numeric( $haru_watch_later_page ) ) ? get_permalink( $haru_watch_later_page ) :  get_permalink( get_page_by_path( 'watch-later' ) );
                        }
                    } else if ( $actor == true ) {
                        $playlist_video_ids = get_post_meta( $actor_id, 'haru_actor_attached_videos', true );

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
                        
                        $playlist_slug = haru_vidi_get_actor_slug();
                        $playlist_id = $actor_id;
                        $playlist_title = get_the_title( $playlist_id );
                        $playlist_url = get_permalink( $playlist_id );
                    } else if ( $director == true ) {
                        $playlist_video_ids = get_post_meta( $director_id, 'haru_director_attached_videos', true );
                        
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
                        
                        $playlist_slug = haru_vidi_get_director_slug();
                        $playlist_id = $director_id;
                        $playlist_title = get_the_title( $playlist_id );
                        $playlist_url = get_permalink( $playlist_id );
                    } else if ( $series == true ) {
                        $playlist_video_ids = get_post_meta( $series_id, 'haru_series_attached_videos', true );

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

                        $playlist_slug = haru_vidi_get_series_slug();
                        $playlist_id = $series_id;
                        $playlist_title = get_the_title( $playlist_id );
                        $playlist_url = get_permalink( $playlist_id );
                    } else {
                        if ( ( $related == true ) ) {
                            $custom_taxterms = wp_get_object_terms( get_the_ID(), 'video_category', array('fields' => 'ids') );

                            $video_args = array(
                                'post__not_in'       => array( get_the_ID() ),
                                'posts_per_page'     => 10,
                                'orderby'            => 'rand',
                                'post_type'          => 'haru_video',
                                'post_status'        => 'publish',
                                'tax_query' => array(
                                    array(
                                        'taxonomy'  => 'video_category',
                                        'field'     => 'id',
                                        'terms'     => $custom_taxterms
                                    )
                                ),

                            );
                            $more_videos         = new WP_Query( $video_args );
                            $playlist_video_ids = array();
                            if ( $more_videos->have_posts() ) :
                                while ( $more_videos->have_posts() ) : $more_videos->the_post();
                                    $playlist_video_ids[] = get_the_ID();
                                endwhile;
                            endif;
                            wp_reset_query();

                            $playlist_slug = '';
                            $playlist_title = esc_html__( 'Related Videos', 'haru-vidi' );
                        }
                    }
                ?>
                <h6 class="single-video-playlist-title">
                    <?php if ( isset( $playlist_url ) && ( $playlist_url != '' ) ) : ?>
                        <a href="<?php echo esc_url( $playlist_url ); ?>" class="single-video-playlist-title-link">
                    <?php endif; ?>
                    <span class="single-video-playlist-title-scroll <?php if ( $related == true ) echo esc_attr( 'no-count-videos' ); ?>"><span><?php echo esc_html( $playlist_title ); ?></span></span>
                    <?php foreach( $playlist_video_ids as $key => $playlist_video_id ) : // Don't use for Related ?>
                        <?php if ( get_the_ID() == $playlist_video_id ) : ?>
                        <span class="single-video-playlist-count"><?php echo esc_html( ( $playlist_id == 'watch-later' ) ? $key + 1 : $key + 1 ); ?>/<?php echo count( $playlist_video_ids ); ?></span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if ( isset( $playlist_url ) && ( $playlist_url != '' ) ) : ?>
                        </a>
                   <?php endif; ?> 
                </h6>

                <ul class="playlist-videos">
                <?php foreach( $playlist_video_ids as $playlist_video_id ) : ?>
                    <li class="video-item <?php echo esc_attr( get_the_ID() == $playlist_video_id ? 'active' : '' ); ?>">
                        <div class="video-item__thumbnail">
                            <a href="<?php echo esc_url( get_permalink( $playlist_video_id ) ); ?><?php echo esc_attr( $playlist_slug != '' ) ? '?' . esc_attr( $playlist_slug ) . '=' . esc_attr( $playlist_id ) : ''; ?>">
                                <img src="<?php echo esc_url( get_the_post_thumbnail_url( $playlist_video_id ) ); ?>" alt="<?php echo get_the_title( $playlist_video_id ); ?>">
                                <?php echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-toolbar-action-watch-later' . '.php', array(), '', ''); ?>
                                <div class="video-item__duration"><?php echo esc_html( get_post_meta( $playlist_video_id, 'haru_video_duration', true ) ); ?></div>
                            </a>
                        </div>
                        <div class="video-item__content">
                            <h6 class="video-item__title">
                                <a href="<?php echo esc_url( get_permalink( $playlist_video_id ) ); ?><?php echo esc_attr( $playlist_slug != '' ) ? '?' . esc_attr( $playlist_slug ) . '=' . esc_attr( $playlist_id ) : ''; ?>"><?php echo esc_html( get_the_title( $playlist_video_id ) ); ?></a>
                            </h6>
                            <div class="video-item__meta">
                                <div class="video-item__author">
                                    <i class="fa fa-user"></i>
                                    <?php
                                        $post_author_id = get_post_field( 'post_author', $playlist_video_id );

                                        if ( function_exists('bp_is_active') ) {
                                            echo bp_core_get_userlink( $post_author_id );
                                        } else {
                                            printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( $post_author_id ) ), esc_html( get_the_author() ));
                                        }
                                    ?>
                                </div>
                                <div class="video-item__view"><?php haru_get_post_views( $playlist_video_id ); ?></div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Series -->
        <?php if ( ( $series == true ) && ( $single_video_series_style == 'video-series-style-2' ) ) : ?>
            <div class="single-video-series">
                <?php $series_video_ids = get_post_meta( $series_id, 'haru_series_attached_videos', true ); ?>
                <div class="series-label"><?php echo esc_html__( 'Episodes', 'haru-vidi' ); ?></div>
                <ul class="series-videos">
                <?php $epi_count = 1; foreach( $series_video_ids as $series_video_id ) : ?>
                    <li class="video-item <?php echo esc_attr( get_the_ID() == $series_video_id ? 'active' : '' ); ?>">
                        <div class="video-content">
                            <a href="<?php echo esc_url( get_permalink( $series_video_id ) ); ?>?<?php echo haru_vidi_get_playlist_slug(); ?>=<?php echo esc_attr( $series_id ); ?>"><?php echo esc_html__( 'Episode', 'haru-vidi' ) . $epi_count; $epi_count++; ?></a>
                        </div>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    <?php
            endwhile;
        endif;
    ?>

    <div class="single-content <?php if ( is_active_sidebar( $single_sidebar_left ) && in_array($single_layout_sidebar, array( 'sidebar-left', 'two-sidebar' ) ) ) echo esc_attr( 'has-left-sidebar' ); ?> <?php if ( is_active_sidebar( $single_sidebar_right ) && in_array($single_layout_sidebar, array( 'sidebar-right', 'two-sidebar' ) ) ) echo esc_attr( 'has-right-sidebar' ); ?>">
        <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post(); 

                $video_ids = get_post_meta(get_the_ID(), 'haru_playlist_video', false);
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="single-video <?php echo esc_attr( $single_style ); ?>">
                <div class="single-video-wrap <?php echo esc_attr( ($playlist == true || $actor == true || $director == true) ? 'in-playlist' : '' ); ?>">

                    <div class="single-video-meta-bottom">
                        <div class="single-video-meta-left">
                            <div class="single-video-author-avatar">
                                <div class="author-avatar"><?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?></div>
                            </div>
                        </div>
                        <div class="single-video-meta-right">
                            <div class="single-video-author">
                                <h6>
                                    <?php
                                        if ( function_exists('bp_is_active') ) {
                                            echo bp_core_get_userlink( get_the_author_meta('ID') );
                                        } else {
                                            printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                                        } 
                                    ?>
                                </h6>
                            </div>

                            <div class="single-video-add-friend">
                            <?php 
                                if ( function_exists('bp_is_active') ) {
                                    do_action( 'haru_bp_friend_button' );
                                }
                            ?>
                            </div>
                            
                            <div class="single-video-meta-right-bottom">
                                <div class="single-video-author-count"><?php echo haru_count_author_videos( get_the_author_meta( 'ID' ) ); ?></div>
                                <div class="single-video-author-friends">
                                    <?php
                                        if ( function_exists('bp_is_active') ) {
                                            do_action( 'haru_bp_friend_count' );
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        // Processe Membership
                        $user_access            = true;
                        $user_video_access      = true;
                        $user_taxonomy_access   = true;
                        $member_integrate       = haru_vidi_get_setting( 'vidi-member-settings', 'haru_member_integrate', 'off' );

                        if ( $member_integrate == 'on' ) {
                            $member_plugin = haru_vidi_get_setting( 'vidi-member-settings', 'haru_member_plugin', 'pmpro' );

                            // PaidMembershipsPro
                            if ( $member_plugin == 'pmpro' ) {
                                $page_levels            = haru_get_pmpro_page_meta();
                                $user_levels            = pmpro_getMembershipLevelsForUser( get_current_user_id() );
                                $user_video_access      = haru_get_pmpro_video_access( $page_levels, $user_levels );
                                $category_levels        = haru_get_pmpro_category_levels();
                                $user_category_access   = haru_get_pmpro_video_category_access( $category_levels, $user_levels );
                                $pmpro_pages            = pmpro_get_pmpro_pages();

                                if ( !empty( $page_levels ) ) {
                                    if ( ( $user_video_access == false ) ) {
                                        $user_access = false;
                                    }
                                } else {
                                    if ( $user_category_access == false ) {
                                        $user_access = false;
                                    }
                                }

                                // @TODO: Check expired
                                if ( is_user_logged_in() ) {
                                    $membership_level = pmpro_getMembershipLevelForUser( get_current_user_id() ); // pmpro_getMembershipLevelsForUser
                                    if ( isset( $membership_level ) && (int)$membership_level->enddate < time() ) {
                                        $user_access = false;
                                    }
                                }
                            }
                        }
                        // Other
                    ?>
                    <div class="single-video-content">
                        <?php if ( $user_access == true ) : ?>
                            <?php the_content(); ?>
                        <?php else : ?>
                            <?php 
                                // Processe Membership
                                if ( $member_integrate == 'on' ) :
                                    $member_plugin = haru_vidi_get_setting( 'vidi-member-settings', 'haru_member_plugin', 'pmpro' );

                                    // PaidMembershipsPro
                                    if ( $member_plugin == 'pmpro' ) :
                            ?>
                            <div class="pmpro-require-membership-2">
                                <div class="pmpro-require-content-2">
                                    <!-- Page Levels -->
                                    <?php if ( ( $user_video_access == false ) ) : ?>
                                        <h6 class="pmpro-require-message-2"><?php echo esc_html__( 'This content is for ', 'haru-vidi' ); ?>
                                            <?php foreach ( $page_levels as $level ) : ?>
                                                <?php if ( $level == end($page_levels) ) : ?>
                                                <span><?php echo esc_html( $level->name ); ?></span>
                                                <?php else : ?>
                                                <span><?php echo esc_html( $level->name ); ?><?php echo esc_html__( ' and', 'haru-vidi' ); ?></span>
                                                <?php endif; ?>   
                                            <?php endforeach; ?>
                                            <?php echo esc_html__( 'members only.', 'haru-vidi' ); ?>
                                        </h6>
                                    <?php else : ?>
                                        <!-- Category Levels -->
                                        <?php if ( $user_category_access == false ) : ?>
                                            <h6 class="pmpro-require-message-2"><?php echo esc_html__( 'This content is for ', 'haru-vidi' ); ?>
                                            <?php foreach ( $category_levels as $category_level) : ?>
                                                <?php if ( $category_level == end($category_levels) ) : ?>
                                                <span><?php echo esc_html( pmpro_getLevel( $category_level )->name ); ?></span>
                                                <?php else : ?>
                                                <span><?php echo esc_html( pmpro_getLevel( $category_level )->name ); ?><?php echo esc_html__( ' and', 'haru-vidi' ); ?></span>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php echo esc_html__( 'members only.', 'haru-vidi' ); ?>
                                            </h6>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <!-- Subscription Expired -->
                                    <?php
                                        if ( is_user_logged_in() ) :
                                            if ( (int)$membership_level->enddate < time() ) : 
                                    ?>
                                    <h6 class="pmpro-require-message-2"><?php echo esc_html__( 'Your Subcription has expired on ', 'haru-vidi' ) . date_i18n( get_option( 'date_format' ), $membership_level->enddate ); ?>
                                        <?php endif ?>
                                    <?php endif ?>
                                       
                                    <div class="pmpro-require-actions-2">
                                        <?php if ( !is_user_logged_in() ) : ?>
                                        <a href="<?php echo haru_get_url_of_page_with_id($pmpro_pages['account']); ?>" class="pmpro-require-btn button-background button-background--primary button-background--medium" target="_blank"><?php echo esc_html__( 'Login', 'haru-vidi' ); ?></a>
                                        <?php endif; ?>

                                        <?php if ( isset( $membership_level ) && (int)$membership_level->enddate > time() ) : ?>
                                        <a href="<?php echo haru_get_url_of_page_with_id( $pmpro_pages['levels'] ); ?>" class="pmpro-require-btn button-background button-background--primary button-background--medium" target="_blank"><?php echo esc_html__( 'Renew Subcription', 'haru-vidi' ); ?></a>
                                        <?php else : ?>
                                        <a href="<?php echo haru_get_url_of_page_with_id($pmpro_pages['levels']); ?>" class="pmpro-require-btn button-background button-background--primary button-background--medium" target="_blank"><?php echo esc_html__( 'Join Now', 'haru-vidi' ); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                    endif;
                                endif;
                            ?>
                        <?php endif; ?>
                    </div>

                    <?php if ( !empty( get_the_content() ) && ( $user_access == true ) ) : ?>
                    <div class="single-video-content-toggle">
                        <a href="javascript:;" class="single-video-content-btn" data-show-more="<?php echo esc_html__( 'Show more', 'haru-vidi' ); ?>" data-show-less="<?php echo esc_html__( 'Show less', 'haru-vidi' ); ?>"><?php echo esc_html__( 'Show more', 'haru-vidi' ); ?></a>
                    </div>
                    <?php endif; ?>

                    <div class="single-video-tag"><i class="haru-icon haru-tags"></i><?php echo get_the_term_list( get_the_ID(), 'video_tag', '#', ' #' ); ?></div>

                    <?php
                        $video_actor = get_post_meta( get_the_ID(), 'haru_video_attached_actors', true );
                        if ( isset($video_actor) && !empty($video_actor) ) :
                    ?>
                    <div class="single-video-actor">
                        <h5><?php echo esc_html__( 'Actor', 'haru-vidi' ); ?></h5>
                        <div class="single-video-actor-list">
                            <?php foreach( $video_actor as $actor_id ) : ?>
                                <div class="single-video-actor-item">
                                    <div class="single-video-actor-item-avatar" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( $actor_id ) ); ?>');">
                                    </div>
                                    <div class="single-video-actor-item-meta">
                                        <h6><a href="<?php echo esc_url( get_the_permalink( $actor_id ) ); ?>"><?php echo esc_html( get_the_title( $actor_id ) ); ?></a></h6>
                                        <div class="single-video-actor-item-meta-videos"><?php echo haru_count_actor_videos( $actor_id ); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php
                        $video_director = get_post_meta( get_the_ID(), 'haru_video_attached_directors', true );
                        if ( isset($video_director) && !empty($video_director) ) :
                    ?>
                    <div class="single-video-director">
                        <h5><?php echo esc_html__( 'Director', 'haru-vidi' ); ?></h5>
                        <div class="single-video-director-list">
                            <?php foreach( $video_director as $director_id ) : ?>
                                <div class="single-video-director-item">
                                    <div class="single-video-director-item-avatar" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( $director_id ) ); ?>');">
                                    </div>
                                    <div class="single-video-director-item-meta">
                                        <h6><a href="<?php echo esc_url( get_the_permalink( $director_id ) ); ?>"><?php echo esc_html( get_the_title( $director_id ) ); ?></a></h6>
                                        <div class="single-video-director-item-meta-videos"><?php echo haru_count_director_videos( $director_id ); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="single-video-nav">
                        <?php
                            $prev_video = haru_get_prev_video_url( get_the_ID() );
                            if ( !empty($prev_video) && $prev_video['link'] != '' ) :
                        ?>
                        <div class="single-video-prev">
                            <a href="<?php echo esc_url( $prev_video['link'] ); ?>" class="video-nav-link"></a>
                            <div class="single-video-nav-content">
                                <div class="video-nav-thumb video-prev-thumb">
                                    <img src="<?php echo esc_url( get_the_post_thumbnail_url( $prev_video['ID'] ) ); ?>" alt="">
                                    <div class="video-nav-duration"><?php echo esc_html( get_post_meta($prev_video['ID'], 'haru_video_duration', true) ); ?></div>
                                </div>
                                <div class="video-nav-meta">
                                    <div class="video-nav-label"><?php echo esc_html__( 'Prev', 'haru-vidi' ); ?></div>
                                    <h6 class="video-nav-title"><?php echo get_the_title( $prev_video['ID'] ); ?></h6>
                                    <div class="video-nav-info">
                                        <div class="video-nav-author">
                                            <?php
                                                if ( function_exists('bp_is_active') ) {
                                                    echo bp_core_get_userlink( get_the_author_meta('ID') );
                                                } else {
                                                    printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                                                }
                                            ?>
                                        </div>
                                        <div class="video-nav-date"><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php 
                            $next_video = haru_get_next_video_url( get_the_ID() );
                            if ( !empty($next_video) && $next_video['link'] != '' ) :
                        ?>
                        <div class="single-video-next">
                            <a href="<?php echo esc_url( $next_video['link'] ); ?>" class="video-nav-link"></a>
                            <div class="single-video-nav-content">
                                <div class="video-nav-meta">
                                    <div class="video-nav-label"><?php echo esc_html__( 'Next', 'haru-vidi' ); ?></div>
                                    <h6 class="video-nav-title"><?php echo get_the_title( $next_video['ID'] ); ?></h6>
                                    <div class="video-nav-info">
                                        <div class="video-nav-author">
                                            <?php
                                                if ( function_exists('bp_is_active') ) {
                                                    echo bp_core_get_userlink( get_the_author_meta('ID') );
                                                } else {
                                                    printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                                                }
                                            ?>
                                        </div>
                                        <div class="video-nav-date"><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
                                    </div>
                                </div>
                                <div class="video-nav-thumb video-next-thumb">
                                    <img src="<?php echo esc_url( get_the_post_thumbnail_url( $next_video['ID'] ) ); ?>" alt="">
                                    <div class="video-nav-duration"><?php echo esc_html( get_post_meta($next_video['ID'], 'haru_video_duration', true) ); ?></div>
                                </div>      
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="single-related-video">
                        <h6 class="related-title"><?php echo esc_html__( 'You may also like this', 'haru-vidi' ); ?></h6>
                        <div class="related-list haru-slick"
                            data-slick='{"slidesToShow" : 3, "slidesToScroll" : 1, "arrows" : true, "infinite" : true, "centerMode" : false, "focusOnSelect" : false, "vertical" : false, "responsive" : [{"breakpoint": 767,"settings":{"slidesToShow": 1}}] }'
                        >
                            <?php 
                                // Get video more by category
                                $custom_taxterms = wp_get_object_terms( get_the_ID(), 'video_category', array('fields' => 'ids') );

                                $video_args = array(
                                    'post__not_in'       => array( get_the_ID() ),
                                    'posts_per_page'     => 6,
                                    'orderby'            => 'rand',
                                    'post_type'          => 'haru_video',
                                    'post_status'        => 'publish',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy'  => 'video_category',
                                            'field'     => 'id',
                                            'terms'     => $custom_taxterms
                                        )
                                    ),

                                );
                                $more_videos         = new WP_Query( $video_args );
                            ?>
                            <?php 
                                if ( $more_videos->have_posts() ) :
                                    while ( $more_videos->have_posts() ) : $more_videos->the_post();
                                        echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array(), '', '');
                                    endwhile;
                                endif;
                                wp_reset_query();
                            ?>
                        </div>
                    </div>

                    <div id="video-comments">
                        <?php
                            // If comments are open or we have at least one comment, load up the comment template.
                            if ( comments_open() || get_comments_number() ) {
                                comments_template();
                            }
                        ?>
                    </div>
                </div>
            </div>
        </article>
        <?php
                endwhile;
            else :
        ?>
        <div class="single-no-video">
            <?php echo esc_html__( 'No Video Found.', 'haru-vidi' ); ?>
        </div>
        <?php
            endif;
        ?>
    </div>

    <!-- Sidebar -->
    <?php if ( is_active_sidebar( $single_sidebar_left ) && in_array($single_layout_sidebar, array( 'sidebar-left', 'two-sidebar' ) ) ) : ?>
        <div class="single-sidebar left-sidebar">
            <?php dynamic_sidebar( $single_sidebar_left ); ?>
        </div>
    <?php endif; ?>
    
    <?php if ( is_active_sidebar( $single_sidebar_right ) && in_array($single_layout_sidebar, array( 'sidebar-right', 'two-sidebar' ) ) ) : ?>
        <div class="single-sidebar right-sidebar">
            <?php dynamic_sidebar( $single_sidebar_right ); ?>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer(); 
