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
// Enqueue assets
wp_enqueue_script( 'imagesloaded' );
wp_enqueue_script( 'isotope', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/isotope.pkgd.min.js'), array( 'jquery' ), '', true );
wp_enqueue_script( 'packery-mode', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/packery-mode.pkgd.min.js'), array( 'jquery' ), '', true );

wp_enqueue_style( 'slick', plugins_url( PLUGIN_HARU_VIDI_NAME.'/assets/libraries/slick/slick.css'), array() );
wp_enqueue_script( 'slick', plugins_url( PLUGIN_HARU_VIDI_NAME.'/assets/libraries/slick/slick.min.js'), array( 'jquery' ), '', true );
wp_enqueue_script( 'mCustomScrollbar', plugins_url( PLUGIN_HARU_VIDI_NAME.'/assets/libraries/mCustomScrollbar/jquery.mCustomScrollbar.js'), array( 'jquery' ), true, false );
wp_enqueue_style( 'mCustomScrollbar', plugins_url( PLUGIN_HARU_VIDI_NAME.'/assets/libraries/mCustomScrollbar/jquery.mCustomScrollbar.min.css'), array(), true, 'all' );

$single_layout_full = haru_vidi_get_setting( 'vidi-channels-settings', 'single_channel_settings_layout_full', 'off' );
$single_layout_sidebar = haru_vidi_get_setting( 'vidi-channels-settings', 'single_channel_settings_sidebar', 'sidebar-none' );
$single_sidebar_left = haru_vidi_get_setting( 'vidi-channels-settings', 'single_channel_settings_sidebar_left', '' );
$single_sidebar_right = haru_vidi_get_setting( 'vidi-channels-settings', 'single_channel_settings_sidebar_right', '' );
$single_style = haru_vidi_get_setting( 'vidi-channels-settings', 'single_channel_settings_style', 'style-1' );

?>
<div class="haru-single-breadcrumbs">
    <div class="<?php echo esc_attr( $single_layout_full == 'on' ? 'full-width' : 'haru-container' ); ?>">
        <?php echo haru_vidi_cpt_breadcrumbs(); ?>
    </div>
</div>
<div class="haru-single-channel <?php echo esc_attr( $single_layout_full == 'on' ? '' : 'haru-container' ); ?>">
    <div class="single-content <?php if ( is_active_sidebar( $single_sidebar_left ) && in_array($single_layout_sidebar, array( 'sidebar-left', 'two-sidebar' ) ) ) echo esc_attr( 'has-left-sidebar' ); ?> <?php if ( is_active_sidebar( $single_sidebar_right ) && in_array($single_layout_sidebar, array( 'sidebar-right', 'two-sidebar' ) ) ) echo esc_attr( 'has-right-sidebar' ); ?>">
        <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    
                $channel_id = get_the_ID();
        ?>
        <div class="single-channel__thumbnail">
            <img src="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"> 
            <ul class="single-channel__social">
                <?php if ( get_post_meta( get_the_ID(), 'haru_channel_facebook_url', true ) != '' ) : ?>
                <li><a class="single-channel__social-facebook" href="<?php echo esc_url( get_post_meta( get_the_ID(), 'haru_channel_facebook_url', true ) ); ?>"><i class="fa fa-facebook-f"></i></a></li>
                <?php endif; ?>

                <?php if ( get_post_meta( get_the_ID(), 'haru_channel_youtube_url', true ) != '' ) : ?>
                <li><a class="single-channel__social-youtube" href="<?php echo esc_url( get_post_meta( get_the_ID(), 'haru_channel_youtube_url', true ) ); ?>"><i class="fa fa-youtube"></i></a></li>
                <?php endif; ?>

                <?php if ( get_post_meta( get_the_ID(), 'haru_channel_twitter_url', true ) != '' ) : ?>
                <li><a class="single-channel__social-twitter" href="<?php echo esc_url( get_post_meta( get_the_ID(), 'haru_channel_twitter_url', true ) ); ?>"><i class="fa fa-twitter"></i></a></li>
                <?php endif; ?>

                <?php if ( get_post_meta( get_the_ID(), 'haru_channel_instagram_url', true ) != '' ) : ?>
                <li><a class="single-channel__social-instagram" href="<?php echo esc_url( get_post_meta( get_the_ID(), 'haru_channel_instagram_url', true ) ); ?>"><i class="fa fa-instagram"></i></a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="single-channel__meta-info">
            <div class="single-channel__meta-info-left">
                <div class="single-channel__author-avatar">
                    <?php
                        if ( function_exists('bp_is_active') ) {
                            echo bp_core_get_userlink( get_the_author_meta('ID') );
                        } else {
                            printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                        } 
                    ?>
                    <div class="author-avatar"><?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?></div>
                </div>
                <div class="single-channel__info">
                    <h6 class="single-channel__title"><?php echo get_the_title(); ?></h6>
                    <div class="single-channel__meta">
                        <div class="single-channel__videos-count"><?php echo haru_count_channel_videos( get_the_ID() ); ?></div>
                        <div class="single-channel__count-subscribed">
                            <?php echo haru_count_channel_subscribed( get_the_ID(), true ); ?>
                        </div>
                    </div>
                    <div class="single-channel__add-friend">
            <?php 
                if ( function_exists('bp_is_active') ) {
                    do_action( 'haru_bp_friend_button' );
                }
            ?>
            </div>
                </div>
            </div>
            

            <div class="single-channel__subscribe">
                <?php echo haru_channel_subscribe_button( get_the_ID() ); ?>
            </div>
        </div>
        
        <?php
            $tab_id = '';
            if ( isset($_GET['tab']) && trim($_GET['tab']) != '' ) {                   
                $tab_id = $_GET['tab'];
            }
        ?>
        <div class="single-channel__tabs <?php echo esc_attr( $tab_id ); ?>">
            <div class="single-channel__tab single-channel__tab-videos <?php echo ( $tab_id == '' || $tab_id == 'videos' ) ? 'active' : ''; ?>">
                <h6 class="single-channel__tab-title">
                    <a href="<?php echo esc_url( get_permalink() ); ?>?tab=videos" class="single-channel__tab-link"><?php echo esc_html__( 'Videos', 'haru-vidi' ); ?></a>
                </h6>
            </div>
            <div class="single-channel__tab single-channel__tab-playlists <?php echo ( $tab_id == 'playlist' ) ? 'active' : ''; ?>">
                <h6 class="single-channel__tab-title">
                    <a href="<?php echo esc_url( get_permalink() ); ?>?tab=playlist" class="single-channel__tab-link"><?php echo esc_html__( 'Playlists', 'haru-vidi' ); ?></a>
                </h6>
            </div>
            <div class="single-channel__tab single-channel__tab-seriess <?php echo ( $tab_id == 'series' ) ? 'active' : ''; ?>">
                <h6 class="single-channel__tab-title">
                    <a href="<?php echo esc_url( get_permalink() ); ?>?tab=series" class="single-channel__tab-link"><?php echo esc_html__( 'Series', 'haru-vidi' ); ?></a>
                </h6>
            </div>
            <div class="single-channel__tab single-channel__tab-about <?php echo ( $tab_id == 'about' ) ? 'active' : ''; ?>">
                <h6 class="single-channel__tab-title">
                    <a href="<?php echo esc_url( get_permalink() ); ?>?tab=about" class="single-channel__tab-link"><?php echo esc_html__( 'About', 'haru-vidi' ); ?></a>
                </h6>
            </div>
            <div class="single-channel__tab single-channel__tab-discussion <?php echo ( $tab_id == 'discussion' ) ? 'active' : ''; ?>">
                <h6 class="single-channel__tab-title">
                    <a href="<?php echo esc_url( get_permalink() ); ?>?tab=discussion" class="single-channel__tab-link"><?php echo esc_html__( 'Discussion', 'haru-vidi' ); ?></a>
                </h6>
            </div>
        </div>

        <div class="single-channel__tab-content">
            <!-- Video Tab -->
            <?php if ( $tab_id == '' || $tab_id == 'videos' ) : ?>
                <?php 
                    $video_ids = get_post_meta( get_the_ID(), 'haru_channel_attached_videos', true );
                    $single_cpt_url = get_the_permalink() . '?tab=videos'; // Similar Woo
                    $orderby = 'default'; // Order in metabox
                    if ( isset($_GET['orderby']) && ($_GET['orderby'] !== '') ) {
                        $orderby = $_GET['orderby'];
                    }
                ?>
                
                <div class="haru-archive-top">
                    <div class="haru-archive-top-left">
                        
                    </div>
                    <div class="haru-archive-top-right">
                        <div class="haru-archive-layout-toggle">
                            <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                            <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                            <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                        </div>

                        <div class="haru-archive-order">
                            <div class="order-item-current"><?php echo esc_html( $orderby ); ?></div>
                            <ul class="order-items">
                                <li class="order-item <?php echo esc_attr( ($orderby == 'default') ? 'selected' : '' ); ?>">
                                    <a href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'default' ), $single_cpt_url ) ); ?>"><?php echo esc_html__( 'Default', 'haru-vidi' ); ?></a>
                                </li>  
                                <li class="order-item <?php echo esc_attr( ($orderby == 'date') ? 'selected' : '' ); ?>">
                                    <a href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'date' ), $single_cpt_url ) ); ?>"><?php echo esc_html__( 'Date', 'haru-vidi' ); ?></a>
                                </li>                                    
                                <li class="order-item <?php echo esc_attr( ($orderby == 'title') ? 'selected' : '' ); ?>">
                                    <a href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'title' ), $single_cpt_url ) ); ?>"><?php echo esc_html__( 'Title', 'haru-vidi' ); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="single-channel__videos layout-wrap style-grid grid-columns grid-columns__2">
                    <?php
                        if ( $orderby == 'default' ) {
                            $orderby == 'post__in';
                        }

                        global $paged;

                        $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1; // Not Fontpage

                        $original_query = $wp_query;

                        $video_args = array(
                            'post__in'           => $video_ids,
                            'posts_per_page'     => 4,
                            'post_type'          => 'haru_video',
                            'orderby'            => $orderby,
                            'paged'              => $paged,
                            'post_status'        => 'publish',
                        );

                        $wp_query = new WP_Query($video_args);
                    ?>
                    <?php 
                        if ( have_posts() ) :
                            while ( have_posts() ) : the_post();
                                echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array(), '', '');
                            endwhile;
                        endif;
                    ?>
                </div>
                <div class="single-pagination">
                    <?php
                        $single_paging_style = 'load-more';
                        switch ( $single_paging_style ) {
                            case 'load-more':
                                haru_paging_load_more_cpt();
                                break;
                            case 'infinite-scroll':
                                haru_paging_infinitescroll_cpt();
                                break;
                            default:
                                echo haru_paging_nav_cpt();
                                break;
                        }
                    ?>
                </div>
                <?php 
                    wp_reset_query();
                    $wp_query = $original_query;
                ?>

            <?php endif; ?>

            <!-- Playlist Tab -->
            <?php if ( $tab_id == 'playlist' ) : ?>

                <?php 
                    $playlist_ids = get_post_meta( get_the_ID(), 'haru_channel_attached_playlists', true );
                    $single_cpt_url = get_the_permalink() . '?tab=playlist'; // Similar Woo
                    $orderby = 'default'; // Order in metabox
                    if ( isset($_GET['orderby']) && ($_GET['orderby'] !== '') ) {
                        $orderby = $_GET['orderby'];
                    }
                ?>

                <div class="haru-archive-top">
                    <div class="haru-archive-top-left">
                        
                    </div>
                    <div class="haru-archive-top-right">
                        <div class="haru-archive-layout-toggle">
                            <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                            <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                            <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                        </div>

                        <div class="haru-archive-order">
                            <div class="order-item-current"><?php echo esc_html( $orderby ); ?></div>
                            <ul class="order-items">
                                <li class="order-item <?php echo esc_attr( ($orderby == 'default') ? 'selected' : '' ); ?>">
                                    <a href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'default' ), $single_cpt_url ) ); ?>"><?php echo esc_html__( 'Default', 'haru-vidi' ); ?></a>
                                </li>  
                                <li class="order-item <?php echo esc_attr( ($orderby == 'date') ? 'selected' : '' ); ?>">
                                    <a href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'date' ), $single_cpt_url ) ); ?>"><?php echo esc_html__( 'Date', 'haru-vidi' ); ?></a>
                                </li>                                    
                                <li class="order-item <?php echo esc_attr( ($orderby == 'title') ? 'selected' : '' ); ?>">
                                    <a href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'title' ), $single_cpt_url ) ); ?>"><?php echo esc_html__( 'Title', 'haru-vidi' ); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="single-channel__playlists layout-wrap style-grid grid-columns grid-columns__2">
                    <?php
                        if ( $orderby == 'default' ) {
                            $orderby == 'post__in';
                        }

                        global $paged;

                        $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1; // Not Fontpage

                        $original_query = $wp_query;

                        $playlist_args = array(
                            'post__in'           => $playlist_ids,
                            'posts_per_page'     => 4,
                            'post_type'          => 'haru_playlist',
                            'orderby'            => $orderby,
                            'paged'              => $paged,
                            'post_status'        => 'publish',
                        );

                        $wp_query = new WP_Query($playlist_args);
                    ?>
                    <?php 
                        if ( have_posts() ) :
                            while ( have_posts() ) : the_post();
                                echo haru_vidi_get_shortcode_template('vidi/playlist/'. 'content-playlist' . '.php', array(), '', '');
                            endwhile;
                        endif;
                    ?>
                </div>
                <div class="single-pagination">
                    <?php
                        $single_paging_style = 'load-more';
                        switch ( $single_paging_style ) {
                            case 'load-more':
                                haru_paging_load_more_cpt();
                                break;
                            case 'infinite-scroll':
                                haru_paging_infinitescroll_cpt();
                                break;
                            default:
                                echo haru_paging_nav_cpt();
                                break;
                        }
                    ?>
                </div>
                <?php 
                    wp_reset_query();
                    $wp_query = $original_query;
                ?>

            <?php endif; ?>

            <!-- Series Tab -->
            <?php if ( $tab_id == 'series' ) : ?>
                
                <?php 
                    $series_ids = get_post_meta( get_the_ID(), 'haru_channel_attached_seriess', true );
                    $single_cpt_url = get_the_permalink() . '?tab=series'; // Similar Woo
                    $orderby = 'default'; // Order in metabox
                    if ( isset($_GET['orderby']) && ($_GET['orderby'] !== '') ) {
                        $orderby = $_GET['orderby'];
                    }
                ?>
                
                <div class="haru-archive-top">
                    <div class="haru-archive-top-left">
                        
                    </div>
                    <div class="haru-archive-top-right">
                        <div class="haru-archive-layout-toggle">
                            <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                            <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                            <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                        </div>

                        <div class="haru-archive-order">
                            <div class="order-item-current"><?php echo esc_html( $orderby ); ?></div>
                            <ul class="order-items">
                                <li class="order-item <?php echo esc_attr( ($orderby == 'default') ? 'selected' : '' ); ?>">
                                    <a href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'default' ), $single_cpt_url ) ); ?>"><?php echo esc_html__( 'Default', 'haru-vidi' ); ?></a>
                                </li>  
                                <li class="order-item <?php echo esc_attr( ($orderby == 'date') ? 'selected' : '' ); ?>">
                                    <a href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'date' ), $single_cpt_url ) ); ?>"><?php echo esc_html__( 'Date', 'haru-vidi' ); ?></a>
                                </li>                                    
                                <li class="order-item <?php echo esc_attr( ($orderby == 'title') ? 'selected' : '' ); ?>">
                                    <a href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'title' ), $single_cpt_url ) ); ?>"><?php echo esc_html__( 'Title', 'haru-vidi' ); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="single-channel__seriess layout-wrap style-grid grid-columns grid-columns__2">
                    <?php
                        if ( $orderby == 'default' ) {
                            $orderby == 'post__in';
                        }

                        global $paged;

                        $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1; // Not Fontpage

                        $original_query = $wp_query;

                        $series_args = array(
                            'post__in'           => $series_ids,
                            'posts_per_page'     => 4,
                            'post_type'          => 'haru_series',
                            'orderby'            => $orderby,
                            'paged'              => $paged,
                            'post_status'        => 'publish',
                        );

                        $wp_query = new WP_Query($series_args);
                    ?>
                    <?php 
                        if ( have_posts() ) :
                            while ( have_posts() ) : the_post();
                                echo haru_vidi_get_shortcode_template('vidi/series/'. 'content-series' . '.php', array(), '', '');
                            endwhile;
                        endif;
                    ?>
                </div>
                <div class="single-pagination">
                    <?php
                        $single_paging_style = 'load-more';
                        switch ( $single_paging_style ) {
                            case 'load-more':
                                haru_paging_load_more_cpt();
                                break;
                            case 'infinite-scroll':
                                haru_paging_infinitescroll_cpt();
                                break;
                            default:
                                echo haru_paging_nav_cpt();
                                break;
                        }
                    ?>
                </div>
                <?php 
                    wp_reset_query();
                    $wp_query = $original_query;
                ?>

            <?php endif; ?>

            <!-- About Tab -->
            <?php if ( $tab_id == 'about' ) : ?>
                <div class="single-channel__meta-top">
                    <div class="single-channel__author"><?php printf('<a href="%1$s"><i class="fa fa-user"></i>%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() )); ?></div>
                    <div class="single-channel__date"><i class="fa fa-calendar"></i><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
                    <div class="single-channel__like post-rating-count">
                        <?php haru_display_like_count( get_the_ID() ); ?>
                    </div>
                    <div class="single-channel__dislike post-rating-count">
                        <?php haru_display_dislike_count( get_the_ID() ); ?>
                    </div>
                    <div class="single-channel__view"><?php haru_get_post_views( get_the_ID() ); ?></div>
                </div>
                <div class="single-channel__content"><?php the_content(); ?></div>
                <div class="single-channel__meta-bottom">
                    <?php haru_display_rating( get_the_ID() ); ?>
                    <?php include(haru_vidi_posttype_get_template('vidi/'. 'social-share' . '.php', array(), '', '')); ?>
                </div>

                <div class="single-channel-nav">
                    <?php 
                        $prev_channel = get_previous_post();
                        if ( !empty( $prev_channel ) ) :
                    ?>
                    <div class="single-channel-prev">
                        <a href="<?php echo get_permalink( $prev_channel->ID ); ?>" class="channel-nav-link"></a>
                        <div class="single-channel-nav-content">
                            <div class="channel-nav-thumb channel-prev-thumb">
                                <img src="<?php echo esc_url( get_the_post_thumbnail_url( $prev_channel->ID ) ? get_the_post_thumbnail_url( $prev_channel->ID ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="">
                                <div class="channel-nav-count-video"><?php echo haru_count_channel_videos( $prev_channel->ID ); ?></div>
                            </div>
                            <div class="channel-nav-meta">
                                <div class="channel-nav-label"><?php echo esc_html__( 'Prev', 'haru-vidi' ); ?></div>
                                <h6 class="channel-nav-title"><?php echo get_the_title( $prev_channel->ID ); ?></h6>
                                <div class="channel-nav-info">
                                    <div class="channel-nav-author">
                                        <?php
                                            if ( function_exists('bp_is_active') ) {
                                                echo bp_core_get_userlink( get_the_author_meta('ID') );
                                            } else {
                                                printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                                            }
                                        ?>
                                    </div>
                                    <div class="channel-nav-date"><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php 
                        $next_channel = get_next_post();
                        if ( !empty( $next_channel ) ) :
                    ?>
                    <div class="single-channel-next">
                        <a href="<?php echo get_permalink( $next_channel->ID ); ?>" class="channel-nav-link"></a>
                        <div class="single-channel-nav-content">
                            <div class="channel-nav-meta">
                                <div class="channel-nav-label"><?php echo esc_html__( 'Next', 'haru-vidi' ); ?></div>
                                <h6 class="channel-nav-title"><?php echo get_the_title( $next_channel->ID ); ?></h6>
                                <div class="channel-nav-info">
                                    <div class="channel-nav-author">
                                        <?php
                                            if ( function_exists('bp_is_active') ) {
                                                echo bp_core_get_userlink( get_the_author_meta('ID') );
                                            } else {
                                                printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                                            }
                                        ?>
                                    </div>
                                    <div class="channel-nav-date"><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
                                </div>
                            </div>
                            <div class="channel-nav-thumb channel-next-thumb">
                                <img src="<?php echo esc_url( get_the_post_thumbnail_url( $next_channel->ID ) ? get_the_post_thumbnail_url( $next_channel->ID ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="">
                            </div>      
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="single-related-channel">
                    <h6 class="related-title"><?php echo esc_html__( 'You Might Be Interested In', 'haru-vidi' ); ?></h6>
                    <div class="related-list haru-slick"
                        data-slick='{"slidesToShow" : 3, "slidesToScroll" : 1, "arrows" : true, "infinite" : true, "centerMode" : false, "focusOnSelect" : false, "vertical" : false, "responsive" : [{"breakpoint": 767,"settings":{"slidesToShow": 1}}] }'
                    >
                        <?php 
                            // Get video more by category
                            $custom_taxterms = wp_get_object_terms( get_the_ID(), 'channel_category', array('fields' => 'ids') );

                            $channel_args = array(
                                'post__not_in'       => array( get_the_ID() ),
                                'posts_per_page'     => 5,
                                'orderby'            => 'rand',
                                'post_type'          => 'haru_channel',
                                'post_status'        => 'publish',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'channel_category',
                                        'field' => 'id',
                                        'terms' => $custom_taxterms
                                    )
                                ),

                            );
                            $more_channels = new WP_Query( $channel_args );
                        ?>
                        <?php 
                            if ( $more_channels->have_posts() ) :
                                while ( $more_channels->have_posts() ) : $more_channels->the_post();
                                    echo haru_vidi_get_shortcode_template('vidi/channel/' . 'content-channel' . '.php', array(), '', '');
                                endwhile;
                            endif;
                            wp_reset_query();
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- About Tab -->
            <?php if ( $tab_id == 'discussion' ) : ?>
                <div class="single-channel__discussion">
                    <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        }
                    ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
                endwhile;
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
