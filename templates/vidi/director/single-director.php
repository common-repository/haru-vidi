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

$single_layout_full = haru_vidi_get_setting( 'vidi-directors-settings', 'single_director_settings_layout_full', 'off' );
$single_layout_sidebar = haru_vidi_get_setting( 'vidi-directors-settings', 'single_director_settings_sidebar', 'sidebar-none' );
$single_sidebar_left = haru_vidi_get_setting( 'vidi-directors-settings', 'single_director_settings_sidebar_left', '' );
$single_sidebar_right = haru_vidi_get_setting( 'vidi-directors-settings', 'single_director_settings_sidebar_right', '' );
$single_style = haru_vidi_get_setting( 'vidi-directors-settings', 'single_director_settings_style', 'style-1' );

?>
<div class="haru-single-breadcrumbs">
    <div class="<?php echo esc_attr( $single_layout_full == 'on' ? 'full-width' : 'haru-container' ); ?>">
        <?php echo haru_vidi_cpt_breadcrumbs(); ?>
    </div>
</div>
<div class="haru-single-director <?php echo esc_attr( $single_layout_full == 'on' ? '' : 'haru-container' ); ?>">
    <div class="single-content <?php if ( is_active_sidebar( $single_sidebar_left ) && in_array($single_layout_sidebar, array( 'sidebar-left', 'two-sidebar' ) ) ) echo esc_attr( 'has-left-sidebar' ); ?> <?php if ( is_active_sidebar( $single_sidebar_right ) && in_array($single_layout_sidebar, array( 'sidebar-right', 'two-sidebar' ) ) ) echo esc_attr( 'has-right-sidebar' ); ?>">
        <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();

                $video_ids = get_post_meta( get_the_ID(), 'haru_director_attached_videos', true );
                $director_id = get_the_ID();
        ?>

        <div class="single-director__top">
            <div class="single-director__thumbnail">
                <div class="single-director__thumbnail-images">
                    <img src="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
                </div>
                <div class="single-director__count-video"><?php echo haru_count_director_videos( get_the_ID() ); ?></div>
            </div>
            <div class="single-director__info">
                <h6 class="single-director__title"><?php echo get_the_title(); ?></h6>
                <div class="single-director__meta-top">
                    <div class="single-director__author"><?php printf('<a href="%1$s"><i class="fa fa-user"></i>%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() )); ?></div>
                    <div class="single-director__date"><i class="fa fa-calendar"></i><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
                    <div class="single-director__like post-rating-count">
                        <?php haru_display_like_count( get_the_ID() ); ?>
                    </div>
                    <div class="single-director__dislike post-rating-count">
                        <?php haru_display_dislike_count( get_the_ID() ); ?>
                    </div>
                    <div class="single-director__view"><?php haru_get_post_views( get_the_ID() ); ?></div>
                </div>

                <div class="single-director__content"><?php the_content(); ?></div>
            </div>
        </div>
        
        <?php
            $filmography = get_post_meta( get_the_ID(), 'filmography_group', true );
            if ( isset( $filmography ) && !empty( $filmography ) ) :
        ?>
        <div class="single-director__filmography">
            <h6 class="single-director__filmography-title"><?php echo esc_html__( 'Filmography', 'haru-vidi' ); ?></h6>
            <ul>
            <?php foreach ( $filmography as $filmo ) : ?>
                <li class="single-director__filmography-item">
                    <span class="filmography-year"><?php echo esc_html( $filmo['haru_director_filmography_year'] ); ?></span>
                    <span class="filmography-movie"><?php echo esc_html( $filmo['haru_director_filmography_movie'] ); ?></span>
                    <span class="filmography-text"><?php echo esc_html__( ' as', 'haru-vidi' ); ?></span>
                    <span class="filmography-character"><?php echo esc_html( $filmo['haru_director_filmography_character'] ); ?></span>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="haru-archive-top">
            <div class="haru-archive-top-left">
                <h6 class="archive-single__title"><?php echo esc_html__( 'Has total ', 'haru-vidi' ); ?>
                    <span class="archive-single__total-count"><?php echo haru_count_director_videos( get_the_ID() ); ?></span>
                </h6>
            </div>
            <div class="haru-archive-top-right">
                <div class="haru-archive-layout-toggle">
                    <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                    <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                    <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                </div>
                
                <div class="single-director__playall"><a href="<?php echo esc_url( get_permalink( $video_ids[0] ) ); ?>?<?php echo haru_vidi_get_director_slug(); ?>=<?php the_ID() ?>" class="button-background button-background--medium"><?php echo esc_html__( 'Play All Videos', 'haru-vidi' ); ?></a></div>
            </div>
        </div>
        <div class="single-director__videos layout-wrap style-grid grid-columns grid-columns__3">
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
                        echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array('director_id' => $director_id), '', '');
                    endwhile;
                endif;
                wp_reset_query();
            ?>
        </div>
        <?php
                endwhile;
            endif;
        ?>

        <div class="single-director__meta-bottom">
            <?php haru_display_rating( get_the_ID() ); ?>
            <?php include(haru_vidi_posttype_get_template('vidi/'. 'social-share' . '.php', array(), '', '')); ?>
        </div>

        <div class="single-director-nav">
            <?php 
                $prev_director = get_previous_post();
                if ( !empty( $prev_director ) ) :
            ?>
            <div class="single-director-prev">
                <a href="<?php echo get_permalink( $prev_director->ID ); ?>" class="director-nav-link"></a>
                <div class="single-director-nav-content">
                    <div class="director-nav-thumb director-prev-thumb">
                        <img src="<?php echo esc_url( get_the_post_thumbnail_url( $prev_director->ID ) ? get_the_post_thumbnail_url( $prev_director->ID ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="">
                        <div class="director-nav-count-video"><?php echo haru_count_director_videos( $prev_director->ID ); ?></div>
                    </div>
                    <div class="director-nav-meta">
                        <div class="director-nav-label"><?php echo esc_html__( 'Prev', 'haru-vidi' ); ?></div>
                        <h6 class="director-nav-title"><?php echo get_the_title( $prev_director->ID ); ?></h6>
                        <div class="director-nav-info">
                            <div class="director-nav-author">
                                <?php
                                    if ( function_exists('bp_is_active') ) {
                                        echo bp_core_get_userlink( get_the_author_meta('ID') );
                                    } else {
                                        printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                                    }
                                ?>
                            </div>
                            <div class="director-nav-date"><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php 
                $next_director = get_next_post();
                if ( !empty( $next_director ) ) :
            ?>
            <div class="single-director-next">
                <a href="<?php echo get_permalink( $next_director->ID ); ?>" class="director-nav-link"></a>
                <div class="single-director-nav-content">
                    <div class="director-nav-meta">
                        <div class="director-nav-label"><?php echo esc_html__( 'Next', 'haru-vidi' ); ?></div>
                        <h6 class="director-nav-title"><?php echo get_the_title( $next_director->ID ); ?></h6>
                        <div class="director-nav-info">
                            <div class="director-nav-author">
                                <?php
                                    if ( function_exists('bp_is_active') ) {
                                        echo bp_core_get_userlink( get_the_author_meta('ID') );
                                    } else {
                                        printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                                    }
                                ?>
                            </div>
                            <div class="director-nav-date"><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
                        </div>
                    </div>
                    <div class="director-nav-thumb director-next-thumb">
                        <img src="<?php echo esc_url( get_the_post_thumbnail_url( $next_director->ID ) ? get_the_post_thumbnail_url( $next_director->ID ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="">
                        <div class="director-nav-count-video"><?php echo haru_count_director_videos( $next_director->ID ); ?></div>
                    </div>      
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="single-related-director">
            <h6 class="related-title"><?php echo esc_html__( 'You Might Be Interested In', 'haru-vidi' ); ?></h6>
            <div class="related-list haru-slick"
                data-slick='{"slidesToShow" : 3, "slidesToScroll" : 1, "arrows" : true, "infinite" : true, "centerMode" : false, "focusOnSelect" : false, "vertical" : false, "responsive" : [{"breakpoint": 767,"settings":{"slidesToShow": 2}}] }'
            >
                <?php 
                    // Get video more by category
                    $custom_taxterms = wp_get_object_terms( get_the_ID(), 'director_category', array('fields' => 'ids') );

                    $director_args = array(
                        'post__not_in'       => array( get_the_ID() ),
                        'posts_per_page'     => 6,
                        'orderby'            => 'rand',
                        'post_type'          => 'haru_director',
                        'post_status'        => 'publish',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'director_category',
                                'field' => 'id',
                                'terms' => $custom_taxterms
                            )
                        ),
                    );
                    $more_directors         = new WP_Query( $director_args );
                ?>
                <?php 
                    if ( $more_directors->have_posts() ) :
                        while ( $more_directors->have_posts() ) : $more_directors->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/director/'. 'content-director' . '.php', array(), '', '');
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
