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

$single_layout_full = haru_vidi_get_setting( 'vidi-seriess-settings', 'single_series_settings_layout_full', 'off' );
$single_layout_sidebar = haru_vidi_get_setting( 'vidi-seriess-settings', 'single_series_settings_sidebar', 'sidebar-none' );
$single_sidebar_left = haru_vidi_get_setting( 'vidi-seriess-settings', 'single_series_settings_sidebar_left', '' );
$single_sidebar_right = haru_vidi_get_setting( 'vidi-seriess-settings', 'single_series_settings_sidebar_right', '' );
$player_settings_popup = haru_vidi_get_setting( 'vidi-general-settings', 'player_settings_popup', 'off' );

?>
<div class="haru-single-breadcrumbs">
    <div class="<?php echo esc_attr( $single_layout_full == 'on' ? 'full-width' : 'haru-container' ); ?>">
        <?php echo haru_vidi_cpt_breadcrumbs(); ?>
    </div>
</div>
<div class="haru-single-series <?php echo esc_attr( $single_layout_full == 'on' ? '' : 'haru-container' ); ?>">
     <div class="single-content <?php if ( is_active_sidebar( $single_sidebar_left ) && in_array($single_layout_sidebar, array( 'sidebar-left', 'two-sidebar' ) ) ) echo esc_attr( 'has-left-sidebar' ); ?> <?php if ( is_active_sidebar( $single_sidebar_right ) && in_array($single_layout_sidebar, array( 'sidebar-right', 'two-sidebar' ) ) ) echo esc_attr( 'has-right-sidebar' ); ?>">
        <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();

                $video_ids = get_post_meta( get_the_ID(), 'haru_series_attached_videos', true );
                $series_id = get_the_ID();
        ?>
        <div class="single-series__thumbnail">
            <div class="single-series__thumbnail-images haru-slick"
                data-slick='{"slidesToShow" : 1, "slidesToScroll" : 1, "arrows" : true, "infinite" : true, "centerMode" : false, "focusOnSelect" : false, "vertical" : false }'
            >
                <img src="<?php echo esc_url( get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                <?php 
                    $attached_videos = get_post_meta( get_the_ID(), 'haru_series_attached_videos', true );
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
            <div class="single-series__count-video"><?php echo haru_count_series_videos( get_the_ID() ); ?></div>
        </div>
        
        <h6 class="single-series__title"><?php echo get_the_title(); ?></h6>
        <div class="single-series__meta-top">
            <div class="single-series__author"><?php printf('<a href="%1$s"><i class="fa fa-user"></i>%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() )); ?></div>
            <div class="single-series__date"><i class="fa fa-calendar"></i><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
            
            <div class="single-series__like post-rating-count">
                <?php haru_display_like_count( get_the_ID() ); ?>
            </div>
            <div class="single-series__dislike post-rating-count">
                <?php haru_display_dislike_count( get_the_ID() ); ?>
            </div>
            <div class="single-series__view"><?php haru_get_post_views( get_the_ID() ); ?></div>
        </div>

        <div class="single-series__content"><?php the_content(); ?></div>

        <?php
            $series_actor = get_post_meta( get_the_ID(), 'haru_series_attached_actors', true );
            if ( isset($series_actor) && !empty($series_actor) ) :
        ?>
        <div class="single-series-actor">
            <h5><?php echo esc_html__( 'Actor', 'haru-vidi' ); ?></h5>
            <div class="single-series-actor-list">
                <?php foreach( $series_actor as $actor_id ) : ?>
                    <div class="single-series-actor-item">
                        <div class="single-series-actor-item-avatar" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( $actor_id ) ? get_the_post_thumbnail_url( $actor_id ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>');">
                        </div>
                        <div class="single-series-actor-item-meta">
                            <h6><a href="<?php echo esc_url( get_the_permalink( $actor_id ) ); ?>"><?php echo esc_html( get_the_title( $actor_id ) ); ?></a></h6>
                            <div class="single-series-actor-item-meta-videos"><?php echo haru_count_actor_videos( $actor_id ); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php
            $series_director = get_post_meta( get_the_ID(), 'haru_series_attached_directors', true );
            if ( isset($series_director) && !empty($series_director) ) :
        ?>
        <div class="single-series-director">
            <h5><?php echo esc_html__( 'Director', 'haru-vidi' ); ?></h5>
            <div class="single-series-director-list">
                <?php foreach( $series_director as $director_id ) : ?>
                    <div class="single-series-director-item">
                        <div class="single-series-director-item-avatar" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( $director_id ) ? get_the_post_thumbnail_url( $director_id ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>');">
                        </div>
                        <div class="single-series-director-item-meta">
                            <h6><a href="<?php echo esc_url( get_the_permalink( $director_id ) ); ?>"><?php echo esc_html( get_the_title( $director_id ) ); ?></a></h6>
                            <div class="single-series-director-item-meta-videos"><?php echo haru_count_actor_videos( $director_id ); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        
        
        <div class="haru-archive-top">
            <div class="haru-archive-top-left">
                <h6 class="archive-single__title"><?php echo esc_html__( 'Has total ', 'haru-vidi' ); ?>
                    <span class="archive-single__total-count"><?php echo haru_count_series_videos( get_the_ID() ); ?></span>
                </h6>
            </div>
            <div class="haru-archive-top-right">
                <div class="haru-archive-layout-toggle">
                    <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                    <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                    <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                </div>

                <div class="single-series__playall"><a href="<?php echo esc_url( get_permalink( $video_ids[0] ) ); ?>?<?php echo haru_vidi_get_playlist_slug(); ?>=<?php the_ID() ?>" class="button-background button-background--medium"><?php echo esc_html__( 'Play All Videos', 'haru-vidi' ); ?></a></div>
            </div>
        </div>
        <div class="single-series__videos layout-wrap style-grid grid-columns grid-columns__two">
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
                        echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array('series_id' => $series_id), '', '');
                    endwhile;
                endif;
                wp_reset_query();
            ?>
        </div>
        <?php
                endwhile;
            endif;
        ?>

        <div class="single-series__meta-bottom">
            <?php haru_display_rating( get_the_ID() ); ?>
            <?php include(haru_vidi_posttype_get_template('vidi/'. 'social-share' . '.php', array(), '', '')); ?>
        </div>

        <div class="single-series-nav">
            <?php 
                $prev_series = get_previous_post();
                if ( !empty( $prev_series ) ) :
            ?>
            <div class="single-series-prev">
                <a href="<?php echo get_permalink( $prev_series->ID ); ?>" class="series-nav-link"></a>
                <div class="single-series-nav-content">
                    <div class="series-nav-thumb series-prev-thumb">
                        <img src="<?php echo esc_url( get_the_post_thumbnail_url( $prev_series->ID ) ? get_the_post_thumbnail_url( $prev_series->ID ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="">
                        <div class="series-nav-count-video"><?php echo haru_count_series_videos( $prev_series->ID ); ?></div>
                    </div>
                    <div class="series-nav-meta">
                        <div class="series-nav-label"><?php echo esc_html__( 'Prev', 'haru-vidi' ); ?></div>
                        <h6 class="series-nav-title"><?php echo get_the_title( $prev_series->ID ); ?></h6>
                        <div class="series-nav-info">
                            <div class="series-nav-author">
                                <?php
                                    if ( function_exists('bp_is_active') ) {
                                        echo bp_core_get_userlink( get_the_author_meta('ID') );
                                    } else {
                                        printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                                    }
                                ?>
                            </div>
                            <div class="series-nav-date"><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php 
                $next_series = get_next_post();
                if ( !empty( $next_series ) ) :
            ?>
            <div class="single-series-next">
                <a href="<?php echo get_permalink( $next_series->ID ); ?>" class="series-nav-link"></a>
                <div class="single-series-nav-content">
                    <div class="series-nav-meta">
                        <div class="series-nav-label"><?php echo esc_html__( 'Next', 'haru-vidi' ); ?></div>
                        <h6 class="series-nav-title"><?php echo get_the_title( $next_series->ID ); ?></h6>
                        <div class="series-nav-info">
                            <div class="series-nav-author">
                                <?php
                                    if ( function_exists('bp_is_active') ) {
                                        echo bp_core_get_userlink( get_the_author_meta('ID') );
                                    } else {
                                        printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                                    }
                                ?>
                            </div>
                            <div class="series-nav-date"><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
                        </div>
                    </div>
                    <div class="series-nav-thumb series-next-thumb">
                        <img src="<?php echo esc_url( get_the_post_thumbnail_url( $next_series->ID ) ? get_the_post_thumbnail_url( $next_series->ID ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="">
                        <div class="series-nav-count-video"><?php echo haru_count_series_videos( $next_series->ID ); ?></div>
                    </div>      
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="single-related-series">
            <h6 class="related-title"><?php echo esc_html__( 'You Might Be Interested In', 'haru-vidi' ); ?></h6>
            <div class="related-list haru-slick"
                data-slick='{"slidesToShow" : 3, "slidesToScroll" : 1, "arrows" : true, "infinite" : true, "centerMode" : false, "focusOnSelect" : false, "vertical" : false, "responsive" : [{"breakpoint": 767,"settings":{"slidesToShow": 1}}] }'
            >
                <?php 
                    // Get video more by category
                    $custom_taxterms = wp_get_object_terms( get_the_ID(), 'series_category', array('fields' => 'ids') );

                    $series_args = array(
                        'post__not_in'       => array( get_the_ID() ),
                        'posts_per_page'     => 5,
                        'orderby'            => 'rand',
                        'post_type'          => 'haru_series',
                        'post_status'        => 'publish',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'series_category',
                                'field' => 'id',
                                'terms' => $custom_taxterms
                            )
                        ),
                    );
                    $more_seriess         = new WP_Query( $series_args );
                ?>
                <?php 
                    if ( $more_seriess->have_posts() ) :
                        while ( $more_seriess->have_posts() ) : $more_seriess->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/series/'. 'content-series' . '.php', array(), '', '');
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
