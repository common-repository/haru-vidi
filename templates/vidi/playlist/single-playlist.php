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

$single_layout_full = haru_vidi_get_setting( 'vidi-playlists-settings', 'single_playlist_settings_layout_full', 'off' );
$single_layout_sidebar = haru_vidi_get_setting( 'vidi-playlists-settings', 'single_playlist_settings_sidebar', 'sidebar-none' );
$single_sidebar_left = haru_vidi_get_setting( 'vidi-playlists-settings', 'single_playlist_settings_sidebar_left', '' );
$single_sidebar_right = haru_vidi_get_setting( 'vidi-playlists-settings', 'single_playlist_settings_sidebar_right', '' );
$single_style = haru_vidi_get_setting( 'vidi-playlists-settings', 'single_playlist_settings_style', 'style-1' );

?>
<div class="haru-single-breadcrumbs">
    <div class="<?php echo esc_attr( $single_layout_full == 'on' ? 'full-width' : 'haru-container' ); ?>">
        <?php echo haru_vidi_cpt_breadcrumbs(); ?>
    </div>
</div>
<div class="haru-single-playlist <?php echo esc_attr( $single_layout_full == 'on' ? '' : 'haru-container' ); ?>">
    <div class="single-content <?php if ( is_active_sidebar( $single_sidebar_left ) && in_array($single_layout_sidebar, array( 'sidebar-left', 'two-sidebar' ) ) ) echo esc_attr( 'has-left-sidebar' ); ?> <?php if ( is_active_sidebar( $single_sidebar_right ) && in_array($single_layout_sidebar, array( 'sidebar-right', 'two-sidebar' ) ) ) echo esc_attr( 'has-right-sidebar' ); ?>">
        <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();

                $video_ids = get_post_meta( get_the_ID(), 'haru_playlist_attached_videos', true );
                $playlist_id = get_the_ID();
        ?>
        <div class="single-playlist__thumbnail">
            <div class="single-playlist__thumbnail-images haru-slick"
                data-slick='{"slidesToShow" : 1, "slidesToScroll" : 1, "arrows" : true, "infinite" : true, "centerMode" : false, "focusOnSelect" : false, "vertical" : false }'
            >
                <img src="<?php echo esc_url( get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                <?php 
                    $attached_videos = get_post_meta( get_the_ID(), 'haru_playlist_attached_videos', true );
                    $thumbnail_count = count($attached_videos);
                    if ( isset($attached_videos) && !empty($attached_videos) ) :
                    $i = 1;
                    foreach( $attached_videos as $key => $thumbnail ) :
                        if ( $i <= $thumbnail_count ) :
                ?>
                <img src="<?php echo esc_url( get_the_post_thumbnail_url( $thumbnail, 'full' ) ? get_the_post_thumbnail_url( $thumbnail, 'full' ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                <?php 
                        endif;
                        $i++;
                    endforeach;
                endif;
                ?>
            </div>
            <div class="single-playlist__count-video"><?php echo haru_count_playlist_videos( get_the_ID() ); ?></div>
        </div>
        <h6 class="single-playlist__title"><?php echo get_the_title(); ?></h6>
        <div class="single-playlist__meta-top">
            <div class="single-playlist__author"><?php printf('<a href="%1$s"><i class="haru-icon haru-user"></i>%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() )); ?></div>
            <div class="single-playlist__date"><i class="haru-icon haru-calendar"></i><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
            <div class="single-playlist__like post-rating-count">
                <?php haru_display_like_count( get_the_ID() ); ?>
            </div>
            <div class="single-playlist__dislike post-rating-count">
                <?php haru_display_dislike_count( get_the_ID() ); ?>
            </div>
            <div class="single-playlist__view"><?php haru_get_post_views( get_the_ID() ); ?></div>
        </div>

        <div class="single-playlist__content"><?php the_content(); ?></div>

        <div class="haru-archive-top">
            <div class="haru-archive-top-left">
                <h6 class="archive-single__title"><?php echo esc_html__( 'Has total ', 'haru-vidi' ); ?>
                    <span class="archive-single__total-count"><?php echo haru_count_playlist_videos( get_the_ID() ); ?></span>
                </h6>
            </div>
            <div class="haru-archive-top-right">
                <div class="haru-archive-layout-toggle">
                    <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                    <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                    <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                </div>

                <div class="single-playlist__playall"><a href="<?php echo esc_url( get_permalink( $video_ids[0] ) ); ?>?<?php echo haru_vidi_get_playlist_slug(); ?>=<?php the_ID() ?>" class="button-background button-background--medium"><?php echo esc_html__( 'Play All Videos', 'haru-vidi' ); ?></a></div>
            </div>
        </div>
        <div class="single-playlist__videos layout-wrap style-grid grid-columns grid-columns__two">
            <?php
                
                $video_args = array(
                    'post__in'           => $video_ids,
                    'posts_per_page'     => -1,
                    'post_type'          => 'haru_video',
                    'orderby'            => 'post__in',
                    'post_status'        => 'publish',
                );
                $list_videos         = new WP_Query( $video_args );
            ?>
            <?php 
                if ( $list_videos->have_posts() ) :
                    while ( $list_videos->have_posts() ) : $list_videos->the_post();
                        echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array('playlist_id' => $playlist_id), '', '');
                    endwhile;
                endif;
                wp_reset_query();
            ?>
        </div>
        <?php
                endwhile;
            endif;
        ?>

        <div class="single-playlist__meta-bottom">
            <?php haru_display_rating( get_the_ID() ); ?>
            <?php include(haru_vidi_posttype_get_template('vidi/'. 'social-share' . '.php', array(), '', '')); ?>
        </div>

        <div class="single-playlist-nav">
            <?php 
                $prev_playlist = get_previous_post();
                if ( !empty( $prev_playlist ) ) :
            ?>
            <div class="single-playlist-prev">
                <a href="<?php echo get_permalink( $prev_playlist->ID ); ?>" class="playlist-nav-link"></a>
                <div class="single-playlist-nav-content">
                    <div class="playlist-nav-thumb playlist-prev-thumb">
                        <img src="<?php echo esc_url( get_the_post_thumbnail_url( $prev_playlist->ID ) ? get_the_post_thumbnail_url( $prev_playlist->ID ): PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="">
                        <div class="playlist-nav-count-video"><?php echo haru_count_playlist_videos( $prev_playlist->ID ); ?></div>
                    </div>
                    <div class="playlist-nav-meta">
                        <div class="playlist-nav-label"><?php echo esc_html__( 'Prev', 'haru-vidi' ); ?></div>
                        <h6 class="playlist-nav-title"><?php echo get_the_title( $prev_playlist->ID ); ?></h6>
                        <div class="playlist-nav-info">
                            <div class="playlist-nav-author">
                                <?php
                                    if ( function_exists('bp_is_active') ) {
                                        echo bp_core_get_userlink( get_the_author_meta('ID') );
                                    } else {
                                        printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                                    }
                                ?>
                            </div>
                            <div class="playlist-nav-date"><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php 
                $next_playlist = get_next_post();
                if ( !empty( $next_playlist ) ) :
            ?>
            <div class="single-playlist-next">
                <a href="<?php echo get_permalink( $next_playlist->ID ); ?>" class="playlist-nav-link"></a>
                <div class="single-playlist-nav-content">
                    <div class="playlist-nav-meta">
                        <div class="playlist-nav-label"><?php echo esc_html__( 'Next', 'haru-vidi' ); ?></div>
                        <h6 class="playlist-nav-title"><?php echo get_the_title( $next_playlist->ID ); ?></h6>
                        <div class="playlist-nav-info">
                            <div class="playlist-nav-author">
                                <?php
                                    if ( function_exists('bp_is_active') ) {
                                        echo bp_core_get_userlink( get_the_author_meta('ID') );
                                    } else {
                                        printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                                    }
                                ?>
                            </div>
                            <div class="playlist-nav-date"><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
                        </div>
                    </div>
                    <div class="playlist-nav-thumb playlist-next-thumb">
                        <img src="<?php echo esc_url( get_the_post_thumbnail_url( $next_playlist->ID ) ? get_the_post_thumbnail_url( $next_playlist->ID ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="">
                        <div class="playlist-nav-count-video"><?php echo haru_count_playlist_videos( $next_playlist->ID ); ?></div>
                    </div>      
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="single-related-playlist">
            <h6 class="related-title"><?php echo esc_html__( 'You Might Be Interested In', 'haru-vidi' ); ?></h6>
            <div class="related-list haru-slick"
                data-slick='{"slidesToShow" : 3, "slidesToScroll" : 1, "arrows" : true, "infinite" : true, "centerMode" : false, "focusOnSelect" : false, "vertical" : false, "responsive" : [{"breakpoint": 767,"settings":{"slidesToShow": 1}}] }'
            >
                <?php 
                    // Get video more by category
                    $custom_taxterms = wp_get_object_terms( get_the_ID(), 'playlist_category', array('fields' => 'ids') );

                    $playlist_args = array(
                        'post__not_in'       => array( get_the_ID() ),
                        'posts_per_page'     => 6,
                        'orderby'            => 'rand',
                        'post_type'          => 'haru_playlist',
                        'post_status'        => 'publish',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'playlist_category',
                                'field' => 'id',
                                'terms' => $custom_taxterms
                            )
                        ),
                    );
                    $more_playlists         = new WP_Query( $playlist_args );
                ?>
                <?php 
                    if ( $more_playlists->have_posts() ) :
                        while ( $more_playlists->have_posts() ) : $more_playlists->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/playlist/'. 'content-playlist' . '.php', array(), '', '');
                        endwhile;
                    endif;
                    wp_reset_query();
                ?>
            </div>
        </div>
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
