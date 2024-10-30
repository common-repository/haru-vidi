<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Video Featured
add_action( 'wp_ajax_haru_get_video_featured', 'haru_get_video_featured' );
add_action( 'wp_ajax_nopriv_haru_get_video_featured', 'haru_get_video_featured' );

if ( !function_exists( 'haru_get_video_featured' ) ) {
    function haru_get_video_featured( $atts ) {
        if ( empty($_POST['atts']) || empty( $_POST['category'] ) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $category       = $_POST['category'];

        ob_start();

        extract($atts);

        $args = array(
            'posts_per_page' => $posts_per_page, // -1 is Unlimited video
            'orderby'        => $orderby,
            'order'          => $order,
            'post_type'      => 'haru_video',
            'post_status'    => 'publish',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'video_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $category),
                )
            )
        );
        
        $videos = new WP_Query( $args );
        ?>
        <div class="video-featured-content" data-max_pages="<?php echo esc_attr( $videos->max_num_pages ); ?>" data-category="<?php echo esc_attr( $category ); ?>">
            <?php if ( in_array($layout, array('default', 'style-2') ) ) : ?>
                <div class="video-list grid-columns grid-columns__4 animated fadeIn haru-clear">
            <?php endif; ?>
                <?php
                    if ( $videos->have_posts() ) {
                        while ( $videos->have_posts() ) { 
                            $videos->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => 'video-style-2' ), '', '');
                        }
                    }
                ?>
            </div>
            <?php if ( in_array($layout, array('default', 'style-2') ) && $view_more == 'button' ) : ?>
                <div class="videos-ajax-view-more <?php echo esc_attr( $view_more == 'button' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( get_term_link( $category, 'video_category') ); ?>" class="button-background button-background--primary button-background--small"><?php echo esc_html__( 'View more', 'haru-vidi' ); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Video Featured Next
add_action( 'wp_ajax_haru_get_video_featured_next', 'haru_get_video_featured_next' );
add_action( 'wp_ajax_nopriv_haru_get_video_featured_next', 'haru_get_video_featured_next' );

if ( !function_exists( 'haru_get_video_featured_next' ) ) {
    function haru_get_video_featured_next( $atts ) {
        if ( empty($_POST['atts']) || empty( $_POST['category'] ) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $category       = $_POST['category'];
        $current_page   = $_POST['current_page'];

        ob_start();

        extract($atts);

        $args = array(
            'posts_per_page' => $posts_per_page, // -1 is Unlimited video
            'orderby'        => $orderby,
            'order'          => $order,
            'post_type'      => 'haru_video',
            'paged'          => $current_page + 1,
            'post_status'    => 'publish',
        );

        if ( $category == '*' ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'video_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $categories),
                )
            );
        } else {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'video_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $category),
                )
            );
        }
        
        $videos = new WP_Query( $args );
        ?>
        <div class="video-featured-content">
            <?php if ( in_array($layout, array('default', 'style-2') ) ) : ?>
                <div class="video-list grid-columns grid-columns__4 animated fadeIn haru-clear">
            <?php endif; ?>
                <?php
                    if ( $videos->have_posts() ) {
                        while ( $videos->have_posts() ) { 
                            $videos->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => 'video-style-2' ), '', '');
                        }
                    }
                ?>
            </div>
            <?php if ( in_array($layout, array('default', 'style-2') ) && $view_more == 'button' ) : ?>
                <div class="videos-ajax-view-more <?php echo esc_attr( $view_more == 'button' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( ( $category == '*' ) ? get_post_type_archive_link('haru_video') : get_term_link($category, 'video_category') ); ?>" class="button-background button-background--primary button-background--small"><?php echo esc_html__( 'View more', 'haru-vidi' ); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Video Category
add_action( 'wp_ajax_haru_get_video_category', 'haru_get_video_category' );
add_action( 'wp_ajax_nopriv_haru_get_video_category', 'haru_get_video_category' );

if ( !function_exists( 'haru_get_video_category' ) ) {
    function haru_get_video_category( $atts ) {
        if ( empty($_POST['atts']) || empty( $_POST['category'] ) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $category       = $_POST['category'];

        ob_start();

        extract($atts);

        $args = array(
            'posts_per_page' => $posts_per_page, // -1 is Unlimited video
            'orderby'        => $orderby,
            'order'          => $order,
            'post_type'      => 'haru_video',
            'post_status'    => 'publish',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'video_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $category),
                )
            )
        );
        
        $videos = new WP_Query( $args );
        ?>
        <div class="video-category-content" data-max_pages="<?php echo esc_attr( $videos->max_num_pages ); ?>" data-category="<?php echo esc_attr( $category ); ?>">
            <?php if ( in_array($layout, array('default') ) ) : ?>
                <div class="video-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn <?php echo esc_attr( $video_style == 'video-style-6' ? 'layout-wrap style-list' : '' ); ?> haru-clear">
            <?php endif; ?>
                <?php
                    if ( $videos->have_posts() ) {
                        while ( $videos->have_posts() ) { 
                            $videos->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => $video_style ), '', '');
                        }
                    }
                ?>
            </div>

            <?php if ( in_array($layout, array('default') ) && $view_more == 'button' ) : ?>
                <div class="videos-ajax-view-more <?php echo esc_attr( $view_more == 'button' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( get_term_link( $category, 'video_category') ); ?>" class="button-background button-background--primary button-background--small"><?php echo esc_html__( 'View more', 'haru-vidi' ); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Video Category Next
add_action( 'wp_ajax_haru_get_video_category_next', 'haru_get_video_category_next' );
add_action( 'wp_ajax_nopriv_haru_get_video_category_next', 'haru_get_video_category_next' );

if ( !function_exists( 'haru_get_video_category_next' ) ) {
    function haru_get_video_category_next( $atts ) {
        if ( empty($_POST['atts']) || empty( $_POST['category'] ) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $category       = $_POST['category'];
        $current_page   = $_POST['current_page'];

        ob_start();

        extract($atts);

        $args = array(
            'posts_per_page' => $posts_per_page, // -1 is Unlimited video
            'orderby'        => $orderby,
            'order'          => $order,
            'post_type'      => 'haru_video',
            'paged'          => $current_page + 1,
            'post_status'    => 'publish',
        );

        if ( $category == '*' ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'video_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $categories),
                )
            );
        } else {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'video_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $category),
                )
            );
        }
        
        $videos = new WP_Query( $args );
        ?>
        <div class="video-category-content">
            <?php if ( in_array($layout, array('default') ) ) : ?>
                <div class="video-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn <?php echo esc_attr( $video_style == 'video-style-6' ? 'layout-wrap style-list' : '' ); ?> haru-clear">
            <?php endif; ?>
                <?php
                    if ( $videos->have_posts() ) {
                        while ( $videos->have_posts() ) { 
                            $videos->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => $video_style ), '', '');
                        }
                    }
                ?>
            </div>
            <?php if ( in_array($layout, array('default') ) && $view_more == 'button' ) : ?>
                <div class="videos-ajax-view-more <?php echo esc_attr( $view_more == 'arrow' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( ( $category == '*' ) ? get_post_type_archive_link('haru_video') : get_term_link($category, 'video_category') ); ?>" class="button-background button-background--primary button-background--small"><?php echo esc_html__( 'View more', 'haru-vidi' ); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Video Category Single Next
add_action( 'wp_ajax_haru_get_video_category_single_next', 'haru_get_video_category_single_next' );
add_action( 'wp_ajax_nopriv_haru_get_video_category_single_next', 'haru_get_video_category_single_next' );

if ( !function_exists( 'haru_get_video_category_single_next' ) ) {
    function haru_get_video_category_single_next( $atts ) {
        if ( empty($_POST['atts']) || empty( $_POST['category'] ) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $category       = $_POST['category'];
        $current_page   = $_POST['current_page'];

        ob_start();

        extract($atts);

        $args = array(
            'posts_per_page' => $posts_per_page, // -1 is Unlimited video
            'orderby'        => $orderby,
            'order'          => $order,
            'post_type'      => 'haru_video',
            'paged'          => $current_page + 1,
            'post_status'    => 'publish',
        );

        $args['tax_query'] = array(
            array(
                'taxonomy' => 'video_category',
                'field'    => 'slug',
                'terms'    => explode(',', $category),
            )
        );
        
        $videos = new WP_Query( $args );
        ?>
        <div class="video-category-single-content">
            <?php if ( in_array($layout, array('default', 'style-2') ) ) : ?>
                <div class="video-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn haru-clear">
            <?php endif; ?>
                <?php
                    if ( $videos->have_posts() ) {
                        $i = 0;
                        while ( $videos->have_posts() ) { 
                            $videos->the_post();
                            if ( $i == 0 ) {
                                echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => 'video-style-2' ), '', '');
                            } else {
                                echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => $video_style ), '', '');
                            }
                            $i++;
                        }
                    }
                ?>
            </div>
            <?php if ( in_array($layout, array('default', 'style-2') ) && $view_more == 'button' ) : ?>
                <div class="videos-ajax-view-more <?php echo esc_attr( $view_more == 'button' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( get_term_link($category, 'video_category') ); ?>" class="button-background button-background--primary button-background--small"><?php echo esc_html__( 'View more', 'haru-vidi' ); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Video Order
add_action( 'wp_ajax_haru_get_video_order', 'haru_get_video_order' );
add_action( 'wp_ajax_nopriv_haru_get_video_order', 'haru_get_video_order' );

if ( !function_exists('haru_get_video_order') ) {
    function haru_get_video_order( $atts ) {
        if ( empty($_POST['atts']) || empty($_POST['video_order']) ) {
            die('0');
        }

        $atts            = $_POST['atts'];
        $video_order     = $_POST['video_order'];

        ob_start();
        extract($atts);

        $args = array(
            'post_type'           => 'haru_video',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page'      => $posts_per_page,
            'post_status'         => 'publish',
        );
        // If use Categories
        if ( isset($categories) && ($categories != '') ) {
            $args['tax_query'] = array(
                                    array(
                                        'taxonomy' => 'video_category',
                                        'field'    => 'slug',
                                        'terms'    => explode(',', $categories),
                                    )
                                );
        }
        // Query Order
        if ( $video_order == 'new' ) {
            $args['orderby']    = 'date';
            $args['order']      = 'desc';
        } elseif ( $video_order == 'view' ) {
            $args['meta_key']   = '_post_view_count_total';
            $args['orderby']    = 'meta_value_num';
        } elseif ( $video_order == 'like' ) {
            $args['meta_key']   = '_post_like_count_total';
            $args['orderby']    = 'meta_value_num';
        } elseif ( $video_order == 'random' ) {
            $args['orderby']    = 'rand';
        } else {
            $args['orderby']    = 'date';
            $args['order']      = 'desc';
        }
        
        $videos = new WP_Query( $args );
        ?>
        <div class="video-order-content" data-max_pages="<?php echo esc_attr( $videos->max_num_pages ); ?>" data-video_order="<?php echo esc_attr( $video_order ); ?>">
            <?php if ( in_array($layout, array('default') ) ) : ?>
            <div class="video-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn <?php echo esc_attr( $video_style == 'video-style-6' ? 'layout-wrap style-list' : '' ); ?> haru-clear">
            <?php endif; ?>
                <?php
                    if ( $videos->have_posts() ) {   
                        while ( $videos->have_posts() ) { 
                            $videos->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => $video_style ), '', '');
                        }
                    }
                ?>
            </div>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Video Order Next
add_action( 'wp_ajax_haru_get_video_order_next', 'haru_get_video_order_next' );
add_action( 'wp_ajax_nopriv_haru_get_video_order_next', 'haru_get_video_order_next' );

if ( !function_exists('haru_get_video_order_next') ) {
    function haru_get_video_order_next( $atts ) {
        if ( empty($_POST['atts']) || empty($_POST['video_order']) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $video_order    = $_POST['video_order'];
        $current_page   = $_POST['current_page'];

        ob_start();

        extract($atts);

        $args = array(
            'post_type'             => 'haru_video',
            'post_status'           => 'publish',
            'paged'                 => $current_page + 1,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $posts_per_page,
        );
        // If use Categories
        if ( isset($categories) && ($categories != '') ) {
            $args['tax_query'] = array(
                                    array(
                                        'taxonomy' => 'video_category',
                                        'field'    => 'slug',
                                        'terms'    => explode(',', $categories),
                                    )
                                );
        }
        // Query Order
        if ( $video_order == 'new' ) {
            $args['orderby']    = 'date';
            $args['order']      = 'desc';
        } elseif ( $video_order == 'view' ) {
            $args['meta_key']   = '_post_view_count_total';
            $args['orderby']    = 'meta_value_num';
        } elseif ( $video_order == 'like' ) {
            $args['meta_key']   = '_post_like_count_total';
            $args['orderby']    = 'meta_value_num';
        } elseif ( $video_order == 'random' ) {
            $args['orderby']    = 'rand';
        } else {
            $args['orderby']    = 'date';
            $args['order']      = 'desc';
        }
        
        $videos = new WP_Query( $args );
        ?>
        <div class="video-order-content" data-max_pages="<?php echo esc_attr( $videos->max_num_pages ); ?>" data-video_order="<?php echo esc_attr( $video_order ); ?>">
            <?php if ( in_array($layout, array('default') ) ) : ?>
            <div class="video-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn <?php echo esc_attr( $video_style == 'video-style-6' ? 'layout-wrap style-list' : '' ); ?> haru-clear">
            <?php endif; ?>
                <?php
                    if ( $videos->have_posts() ) {   
                        while ( $videos->have_posts() ) { 
                            $videos->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => $video_style ), '', '');
                        }
                    }
                ?>
            </div>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Video Order Single Next
add_action( 'wp_ajax_haru_get_video_order_single_next', 'haru_get_video_order_single_next' );
add_action( 'wp_ajax_nopriv_haru_get_video_order_single_next', 'haru_get_video_order_single_next' );

if ( !function_exists('haru_get_video_order_single_next') ) {
    function haru_get_video_order_single_next( $atts ) {
        if ( empty($_POST['atts']) || empty($_POST['video_order']) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $video_order    = $_POST['video_order'];
        $current_page   = $_POST['current_page'];

        ob_start();

        extract($atts);

        $args = array(
            'post_type'             => 'haru_video',
            'post_status'           => 'publish',
            'paged'                 => $current_page + 1,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $posts_per_page,
        );
        // If use Categories
        if ( isset($categories) && ($categories != '') ) {
            $args['tax_query'] = array(
                                    array(
                                        'taxonomy' => 'video_category',
                                        'field'    => 'slug',
                                        'terms'    => explode(',', $categories),
                                    )
                                );
        }
        // Query Order
        if ( $video_order == 'new' ) {
            $args['orderby']    = 'date';
            $args['order']      = 'desc';
        } elseif ( $video_order == 'view' ) {
            $args['meta_key']   = '_post_view_count_total';
            $args['orderby']    = 'meta_value_num';
        } elseif ( $video_order == 'like' ) {
            $args['meta_key']   = '_post_like_count_total';
            $args['orderby']    = 'meta_value_num';
        } elseif ( $video_order == 'random' ) {
            $args['orderby']    = 'rand';
        } else {
            $args['orderby']    = 'date';
            $args['order']      = 'desc';
        }
        
        $videos = new WP_Query( $args );
        ?>
        <div class="video-order-single-content" data-max_pages="<?php echo esc_attr( $videos->max_num_pages ); ?>" data-video_order="<?php echo esc_attr( $video_order ); ?>">
            <?php if ( in_array($layout, array('default') ) ) : ?>
            <div class="video-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn <?php echo esc_attr( $video_style == 'video-style-6' ? 'layout-wrap style-list' : '' ); ?> haru-clear">
            <?php endif; ?>
                <?php
                    if ( $videos->have_posts() ) {   
                        while ( $videos->have_posts() ) { 
                            $videos->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => $video_style ), '', '');
                        }
                    }
                ?>
            </div>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Video Top Next
add_action( 'wp_ajax_haru_get_video_top_next', 'haru_get_video_top_next' );
add_action( 'wp_ajax_nopriv_haru_get_video_top_next', 'haru_get_video_top_next' );

if ( !function_exists('haru_get_video_top_next') ) {
    function haru_get_video_top_next( $atts ) {
        if ( empty($_POST['atts']) || empty($_POST['video_order_by']) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $video_order_by    = $_POST['video_order_by'];
        $current_page   = $_POST['current_page'];

        ob_start();

        extract($atts);

        $args = array(
            'post_type'             => 'haru_video',
            'post_status'           => 'publish',
            'paged'                 => $current_page + 1,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $posts_per_page,
        );
        // If use Categories
        if ( isset($categories) && ($categories != '') ) {
            $args['tax_query'] = array(
                                    array(
                                        'taxonomy' => 'video_category',
                                        'field'    => 'slug',
                                        'terms'    => explode(',', $categories),
                                    )
                                );
        }
        // Query Order
        switch ( $video_order_by ) {
            case 'like':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key']  = '_post_like_count_total';
                break;
            case 'dislike':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key']  = '_post_dislike_count_total';
                break;
            case 'views':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key']  = '_post_view_count_total';
                break;
            default:
                $args['orderby']  = 'date';
        }
        
        $videos = new WP_Query( $args );
        ?>
        <div class="video-top-content" data-max_pages="<?php echo esc_attr( $videos->max_num_pages ); ?>" data-video_order_by="<?php echo esc_attr( $video_order_by ); ?>">
            <?php if ( in_array($layout, array('style-3') ) ) : ?>
            <div class="video-list haru-slick grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn haru-clear" data-slick='{"slidesToShow" : 1, "slidesToScroll": 1, "infinite" : true, "dots": true, "responsive" : [{"breakpoint": 991,"settings":{"slidesToShow": 1}}, {"breakpoint": 767,"settings":{"slidesToShow": 1}}] }'>
            <?php endif; ?>

            <?php if ( in_array($layout, array('style-4') ) ) : $columns = 2; ?>
            <div class="video-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn haru-clear">
            <?php endif; ?>

                <?php
                    if ( $videos->have_posts() ) {   
                        while ( $videos->have_posts() ) { 
                            $videos->the_post();
                            if ( $layout == 'style-2' ) {
                                echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => 'video-style-3' ), '', '');
                            } elseif ( $layout == 'style-3' ) {
                                echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => 'video-style-2' ), '', '');
                            } else {
                                echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array(), '', '');
                            }
                        }
                    }
                ?>
            <?php if ( in_array($layout, array('style-3', 'style-4') ) ) : ?>
            </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Channel Category
add_action( 'wp_ajax_haru_get_channel_category', 'haru_get_channel_category' );
add_action( 'wp_ajax_nopriv_haru_get_channel_category', 'haru_get_channel_category' );

if ( !function_exists( 'haru_get_channel_category' ) ) {
    function haru_get_channel_category( $atts ) {
        if ( empty($_POST['atts']) || empty( $_POST['category'] ) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $category       = $_POST['category'];

        ob_start();

        extract($atts);

        $args = array(
            'posts_per_page' => $posts_per_page, // -1 is Unlimited channel
            'orderby'        => $orderby,
            'order'          => $order,
            'post_type'      => 'haru_channel',
            'post_status'    => 'publish',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'channel_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $category),
                )
            )
        );
        
        $channels = new WP_Query( $args );
        ?>
        <div class="channel-category-content" data-max_pages="<?php echo esc_attr( $channels->max_num_pages ); ?>" data-category="<?php echo esc_attr( $category ); ?>">
            <?php if ( in_array($layout, array('default') ) ) : ?>
                <div class="channel-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn <?php echo esc_attr( $channel_style == 'channel-style-6' ? 'layout-wrap style-list' : '' ); ?> haru-clear">
            <?php endif; ?>
                <?php
                    if ( $channels->have_posts() ) {
                        while ( $channels->have_posts() ) { 
                            $channels->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/channel/'. 'content-channel' . '.php', array( 'channel_style' => $channel_style ), '', '');
                        }
                    }
                ?>
            </div>
            <?php if ( in_array($layout, array('default') ) && $view_more == 'button' ) : ?>
                <div class="channels-ajax-view-more <?php echo esc_attr( $view_more == 'button' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( get_term_link( $category, 'channel_category') ); ?>" class="button-background button-background--primary button-background--small"><?php echo esc_html__( 'View more', 'haru-vidi' ); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Channel Category Next
add_action( 'wp_ajax_haru_get_channel_category_next', 'haru_get_channel_category_next' );
add_action( 'wp_ajax_nopriv_haru_get_channel_category_next', 'haru_get_channel_category_next' );

if ( !function_exists( 'haru_get_channel_category_next' ) ) {
    function haru_get_channel_category_next( $atts ) {
        if ( empty($_POST['atts']) || empty( $_POST['category'] ) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $category       = $_POST['category'];
        $current_page   = $_POST['current_page'];

        ob_start();

        extract($atts);

        $args = array(
            'posts_per_page' => $posts_per_page, // -1 is Unlimited channel
            'orderby'        => $orderby,
            'order'          => $order,
            'post_type'      => 'haru_channel',
            'paged'          => $current_page + 1,
            'post_status'    => 'publish',
        );

        if ( $category == '*' ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'channel_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $categories),
                )
            );
        } else {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'channel_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $category),
                )
            );
        }
        
        $channels = new WP_Query( $args );
        ?>
        <div class="channel-category-content">
            <?php if ( in_array($layout, array('default') ) ) : ?>
                <div class="channel-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn <?php echo esc_attr( $channel_style == 'channel-style-6' ? 'layout-wrap style-list' : '' ); ?> haru-clear">
            <?php endif; ?>
                <?php
                    if ( $channels->have_posts() ) {
                        while ( $channels->have_posts() ) { 
                            $channels->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/channel/'. 'content-channel' . '.php', array( 'channel_style' => $channel_style ), '', '');
                        }
                    }
                ?>
            </div>
            <?php if ( in_array($layout, array('default') ) && $view_more == 'button' ) : ?>
                <div class="channels-ajax-view-more <?php echo esc_attr( $view_more == 'button' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( ( $category == '*' ) ? get_post_type_archive_link('haru_channel') : get_term_link($category, 'channel_category') ); ?>" class="button-background button-background--primary button-background--small"><?php echo esc_html__( 'View more', 'haru-vidi' ); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Channel Top Next
add_action( 'wp_ajax_haru_get_channel_top_next', 'haru_get_channel_top_next' );
add_action( 'wp_ajax_nopriv_haru_get_channel_top_next', 'haru_get_channel_top_next' );

if ( !function_exists('haru_get_channel_top_next') ) {
    function haru_get_channel_top_next( $atts ) {
        if ( empty($_POST['atts']) || empty($_POST['channel_order_by']) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $channel_order_by    = $_POST['channel_order_by'];
        $current_page   = $_POST['current_page'];

        ob_start();

        extract($atts);

        $args = array(
            'post_type'             => 'haru_channel',
            'post_status'           => 'publish',
            'paged'                 => $current_page + 1,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $posts_per_page,
        );
        // If use Categories
        if ( isset($categories) && ($categories != '') ) {
            $args['tax_query'] = array(
                                    array(
                                        'taxonomy' => 'channel_category',
                                        'field'    => 'slug',
                                        'terms'    => explode(',', $categories),
                                    )
                                );
        }
        // Query Order
        switch ( $channel_order_by ) {
            case 'like':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key']  = '_post_like_count_total';
                break;
            case 'dislike':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key']  = '_post_dislike_count_total';
                break;
            case 'views':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key']  = '_post_view_count_total';
                break;
            case 'subscribe':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key']  = '_post_subscribe_count_total';
                break;
            default:
                $args['orderby']  = 'date';
        }
        
        $channels = new WP_Query( $args );
        ?>
        <div class="channel-top-content" data-max_pages="<?php echo esc_attr( $channels->max_num_pages ); ?>" data-channel_order_by="<?php echo esc_attr( $channel_order_by ); ?>">
            <?php if ( in_array($layout, array('style-3') ) ) : ?>
            <div class="channel-list haru-slick grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn haru-clear" data-slick='{"slidesToShow" : 1, "slidesToScroll": 1, "infinite" : true, "dots": true, "responsive" : [{"breakpoint": 991,"settings":{"slidesToShow": 1}}, {"breakpoint": 767,"settings":{"slidesToShow": 1}}] }'>
            <?php endif; ?>

            <?php if ( in_array($layout, array('style-4') ) ) : $columns = 3; ?>
            <div class="channel-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn haru-clear">
            <?php endif; ?>

            <?php if ( in_array($layout, array('style-6') ) ) : $columns = 5; ?>
            <div class="channel-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn haru-clear">
            <?php endif; ?>

                <?php
                    if ( $channels->have_posts() ) {   
                        while ( $channels->have_posts() ) { 
                            $channels->the_post();
                            if ( $layout == 'style-2' ) {
                                echo haru_vidi_get_shortcode_template('vidi/channel/'. 'content-channel' . '.php', array( 'channel_style' => 'channel-style-2' ), '', '');
                            } elseif ( $layout == 'style-3' ) {
                                echo haru_vidi_get_shortcode_template('vidi/channel/'. 'content-channel' . '.php', array( 'channel_style' => 'channel-style-2' ), '', '');
                            } elseif ( $layout == 'style-5' ) {
                                echo haru_vidi_get_shortcode_template('vidi/channel/'. 'content-channel' . '.php', array( 'channel_style' => 'channel-style-7' ), '', '');
                            } elseif ( $layout == 'style-6' ) {
                                echo haru_vidi_get_shortcode_template('vidi/channel/'. 'content-channel' . '.php', array( 'channel_style' => 'channel-style-8' ), '', '');
                            } else {
                                echo haru_vidi_get_shortcode_template('vidi/channel/'. 'content-channel' . '.php', array(), '', '');
                            }
                        }
                    }
                ?>
            <?php if ( in_array($layout, array('style-3', 'style-4', 'style-6') ) ) : ?>
            </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Series Category
add_action( 'wp_ajax_haru_get_series_category', 'haru_get_series_category' );
add_action( 'wp_ajax_nopriv_haru_get_series_category', 'haru_get_series_category' );

if ( !function_exists( 'haru_get_series_category' ) ) {
    function haru_get_series_category( $atts ) {
        if ( empty($_POST['atts']) || empty( $_POST['category'] ) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $category       = $_POST['category'];

        ob_start();

        extract($atts);

        $args = array(
            'posts_per_page' => $posts_per_page, // -1 is Unlimited series
            'orderby'        => $orderby,
            'order'          => $order,
            'post_type'      => 'haru_series',
            'post_status'    => 'publish',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'series_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $category),
                )
            )
        );
        
        $seriess = new WP_Query( $args );
        ?>
        <div class="series-category-content" data-max_pages="<?php echo esc_attr( $seriess->max_num_pages ); ?>" data-category="<?php echo esc_attr( $category ); ?>">
            <?php if ( in_array($layout, array('default') ) ) : ?>
                <div class="series-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn <?php echo esc_attr( $series_style == 'series-style-6' ? 'layout-wrap style-list' : '' ); ?> haru-clear">
            <?php endif; ?>
                <?php
                    if ( $seriess->have_posts() ) {
                        while ( $seriess->have_posts() ) { 
                            $seriess->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/series/'. 'content-series' . '.php', array( 'series_style' => $series_style ), '', '');
                        }
                    }
                ?>
            </div>
            <?php if ( in_array($layout, array('default') ) && $view_more == 'button' ) : ?>
                <div class="seriess-ajax-view-more <?php echo esc_attr( $view_more == 'button' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( get_term_link( $category, 'series_category') ); ?>" class="button-background button-background--primary button-background--small"><?php echo esc_html__( 'View more', 'haru-vidi' ); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Series Category Next
add_action( 'wp_ajax_haru_get_series_category_next', 'haru_get_series_category_next' );
add_action( 'wp_ajax_nopriv_haru_get_series_category_next', 'haru_get_series_category_next' );

if ( !function_exists( 'haru_get_series_category_next' ) ) {
    function haru_get_series_category_next( $atts ) {
        if ( empty($_POST['atts']) || empty( $_POST['category'] ) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $category       = $_POST['category'];
        $current_page   = $_POST['current_page'];

        ob_start();

        extract($atts);

        $args = array(
            'posts_per_page' => $posts_per_page, // -1 is Unlimited series
            'orderby'        => $orderby,
            'order'          => $order,
            'post_type'      => 'haru_series',
            'paged'          => $current_page + 1,
            'post_status'    => 'publish',
        );

        if ( $category == '*' ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'series_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $categories),
                )
            );
        } else {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'series_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $category),
                )
            );
        }
        
        $seriess = new WP_Query( $args );
        ?>
        <div class="series-category-content">
            <?php if ( in_array($layout, array('default') ) ) : ?>
                <div class="series-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn <?php echo esc_attr( $series_style == 'series-style-6' ? 'layout-wrap style-list' : '' ); ?> haru-clear">
            <?php endif; ?>
                <?php
                    if ( $seriess->have_posts() ) {
                        while ( $seriess->have_posts() ) { 
                            $seriess->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/series/'. 'content-series' . '.php', array( 'series_style' => $series_style ), '', '');
                        }
                    }
                ?>
            </div>
            <?php if ( in_array($layout, array('default') ) && $view_more == 'button' ) : ?>
                <div class="seriess-ajax-view-more <?php echo esc_attr( $view_more == 'button' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( ( $category == '*' ) ? get_post_type_archive_link('haru_series') : get_term_link($category, 'series_category') ); ?>" class="button-background button-background--primary button-background--small"><?php echo esc_html__( 'View more', 'haru-vidi' ); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Series Top Next
add_action( 'wp_ajax_haru_get_series_top_next', 'haru_get_series_top_next' );
add_action( 'wp_ajax_nopriv_haru_get_series_top_next', 'haru_get_series_top_next' );

if ( !function_exists('haru_get_series_top_next') ) {
    function haru_get_series_top_next( $atts ) {
        if ( empty($_POST['atts']) || empty($_POST['series_order_by']) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $series_order_by    = $_POST['series_order_by'];
        $current_page   = $_POST['current_page'];

        ob_start();

        extract($atts);

        $args = array(
            'post_type'             => 'haru_series',
            'post_status'           => 'publish',
            'paged'                 => $current_page + 1,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $posts_per_page,
        );
        // If use Categories
        if ( isset($categories) && ($categories != '') ) {
            $args['tax_query'] = array(
                                    array(
                                        'taxonomy' => 'series_category',
                                        'field'    => 'slug',
                                        'terms'    => explode(',', $categories),
                                    )
                                );
        }
        // Query Order
        switch ( $series_order_by ) {
            case 'like':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key']  = '_post_like_count_total';
                break;
            case 'dislike':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key']  = '_post_dislike_count_total';
                break;
            case 'views':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key']  = '_post_view_count_total';
                break;
            default:
                $args['orderby']  = 'date';
        }
        
        $seriess = new WP_Query( $args );
        ?>
        <div class="series-top-content" data-max_pages="<?php echo esc_attr( $seriess->max_num_pages ); ?>" data-series_order_by="<?php echo esc_attr( $series_order_by ); ?>">
            <?php if ( in_array($layout, array('style-3') ) ) : ?>
            <div class="series-list haru-slick grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn haru-clear" data-slick='{"slidesToShow" : 1, "slidesToScroll": 1, "infinite" : true, "dots": true, "responsive" : [{"breakpoint": 991,"settings":{"slidesToShow": 1}}, {"breakpoint": 767,"settings":{"slidesToShow": 1}}] }'>
            <?php endif; ?>

            <?php if ( in_array($layout, array('style-4') ) ) : $columns = 3; ?>
            <div class="series-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn haru-clear">
            <?php endif; ?>
                <?php
                    if ( $seriess->have_posts() ) {   
                        while ( $seriess->have_posts() ) { 
                            $seriess->the_post();
                            if ( $layout == 'style-2' ) {
                                echo haru_vidi_get_shortcode_template('vidi/series/'. 'content-series' . '.php', array( 'series_style' => 'series-style-3' ), '', '');
                            } elseif ( $layout == 'style-3' ) {
                                echo haru_vidi_get_shortcode_template('vidi/series/'. 'content-series' . '.php', array( 'series_style' => 'series-style-2' ), '', '');
                            } else {
                                echo haru_vidi_get_shortcode_template('vidi/series/'. 'content-series' . '.php', array(), '', '');
                            }
                        }
                    }
                ?>
            <?php if ( in_array($layout, array('style-3') ) ) : ?>
            </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Playlist Category
add_action( 'wp_ajax_haru_get_playlist_category', 'haru_get_playlist_category' );
add_action( 'wp_ajax_nopriv_haru_get_playlist_category', 'haru_get_playlist_category' );

if ( !function_exists( 'haru_get_playlist_category' ) ) {
    function haru_get_playlist_category( $atts ) {
        if ( empty($_POST['atts']) || empty( $_POST['category'] ) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $category       = $_POST['category'];

        ob_start();

        extract($atts);

        $args = array(
            'posts_per_page' => $posts_per_page, // -1 is Unlimited playlist
            'orderby'        => $orderby,
            'order'          => $order,
            'post_type'      => 'haru_playlist',
            'post_status'    => 'publish',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'playlist_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $category),
                )
            )
        );
        
        $playlists = new WP_Query( $args );
        ?>
        <div class="playlist-category-content" data-max_pages="<?php echo esc_attr( $playlists->max_num_pages ); ?>" data-category="<?php echo esc_attr( $category ); ?>">
            <?php if ( in_array($layout, array('default') ) ) : ?>
                <div class="playlist-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn <?php echo esc_attr( $playlist_style == 'playlist-style-6' ? 'layout-wrap style-list' : '' ); ?> haru-clear">
            <?php endif; ?>
                <?php
                    if ( $playlists->have_posts() ) {
                        while ( $playlists->have_posts() ) { 
                            $playlists->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/playlist/'. 'content-playlist' . '.php', array( 'playlist_style' => $playlist_style ), '', '');
                        }
                    }
                ?>
            </div>
            <?php if ( in_array($layout, array('default') ) && $view_more == 'button' ) : ?>
                <div class="playlists-ajax-view-more <?php echo esc_attr( $view_more == 'button' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( get_term_link( $category, 'playlist_category') ); ?>" class="button-background button-background--primary button-background--small"><?php echo esc_html__( 'View more', 'haru-vidi' ); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Playlist Category Next
add_action( 'wp_ajax_haru_get_playlist_category_next', 'haru_get_playlist_category_next' );
add_action( 'wp_ajax_nopriv_haru_get_playlist_category_next', 'haru_get_playlist_category_next' );

if ( !function_exists( 'haru_get_playlist_category_next' ) ) {
    function haru_get_playlist_category_next( $atts ) {
        if ( empty($_POST['atts']) || empty( $_POST['category'] ) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $category       = $_POST['category'];
        $current_page   = $_POST['current_page'];

        ob_start();

        extract($atts);

        $args = array(
            'posts_per_page' => $posts_per_page, // -1 is Unlimited playlist
            'orderby'        => $orderby,
            'order'          => $order,
            'post_type'      => 'haru_playlist',
            'paged'          => $current_page + 1,
            'post_status'    => 'publish',
        );

        if ( $category == '*' ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'playlist_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $categories),
                )
            );
        } else {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'playlist_category',
                    'field'    => 'slug',
                    'terms'    => explode(',', $category),
                )
            );
        }
        
        $playlists = new WP_Query( $args );
        ?>
        <div class="playlist-category-content">
            <?php if ( in_array($layout, array('default') ) ) : ?>
                <div class="playlist-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn <?php echo esc_attr( $playlist_style == 'playlist-style-6' ? 'layout-wrap style-list' : '' ); ?> haru-clear">
            <?php endif; ?>
                <?php
                    if ( $playlists->have_posts() ) {
                        while ( $playlists->have_posts() ) { 
                            $playlists->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/playlist/'. 'content-playlist' . '.php', array( 'playlist_style' => $playlist_style ), '', '');
                        }
                    }
                ?>
            </div>
            <?php if ( in_array($layout, array('default') ) && $view_more == 'button' ) : ?>
                <div class="playlists-ajax-view-more <?php echo esc_attr( $view_more == 'button' ? '' : 'hide' ); ?>">
                    <a href="<?php echo esc_url( ( $category == '*' ) ? get_post_type_archive_link('haru_playlist') : get_term_link($category, 'playlist_category') ); ?>" class="button-background button-background--primary button-background--small"><?php echo esc_html__( 'View more', 'haru-vidi' ); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Playlist Top Next
add_action( 'wp_ajax_haru_get_playlist_top_next', 'haru_get_playlist_top_next' );
add_action( 'wp_ajax_nopriv_haru_get_playlist_top_next', 'haru_get_playlist_top_next' );

if ( !function_exists('haru_get_playlist_top_next') ) {
    function haru_get_playlist_top_next( $atts ) {
        if ( empty($_POST['atts']) || empty($_POST['playlist_order_by']) ) {
            die('0');
        }

        $atts           = $_POST['atts'];
        $playlist_order_by    = $_POST['playlist_order_by'];
        $current_page   = $_POST['current_page'];

        ob_start();

        extract($atts);

        $args = array(
            'post_type'             => 'haru_playlist',
            'post_status'           => 'publish',
            'paged'                 => $current_page + 1,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => 1,
            'posts_per_page'        => $posts_per_page,
        );
        // If use Categories
        if ( isset($categories) && ($categories != '') ) {
            $args['tax_query'] = array(
                                    array(
                                        'taxonomy' => 'playlist_category',
                                        'field'    => 'slug',
                                        'terms'    => explode(',', $categories),
                                    )
                                );
        }
        // Query Order
        switch ( $playlist_order_by ) {
            case 'like':
                $args['orderby']  = 'meta_value_num';
                $args['meta_key']  = '_post_like_count_total';
                break;
            case 'dislike':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key']  = '_post_dislike_count_total';
                break;
            case 'views':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key']  = '_post_view_count_total';
                break;
            default:
                $args['orderby']  = 'date';
        }
        
        $playlists = new WP_Query( $args );
        ?>
        <div class="playlist-top-content" data-max_pages="<?php echo esc_attr( $playlists->max_num_pages ); ?>" data-playlist_order_by="<?php echo esc_attr( $playlist_order_by ); ?>">
            <?php if ( in_array($layout, array('style-3') ) ) : ?>
            <div class="playlist-list haru-slick grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn haru-clear" data-slick='{"slidesToShow" : 1, "slidesToScroll": 1, "infinite" : true, "dots": true, "responsive" : [{"breakpoint": 991,"settings":{"slidesToShow": 1}}, {"breakpoint": 767,"settings":{"slidesToShow": 1}}] }'>
            <?php endif; ?>

            <?php if ( in_array($layout, array('style-4') ) ) : $columns = 3; ?>
            <div class="playlist-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn haru-clear">
            <?php endif; ?>
                <?php
                    if ( $playlists->have_posts() ) {   
                        while ( $playlists->have_posts() ) { 
                            $playlists->the_post();
                            if ( $layout == 'style-2' ) {
                                echo haru_vidi_get_shortcode_template('vidi/playlist/'. 'content-playlist' . '.php', array( 'playlist_style' => 'playlist-style-3' ), '', '');
                            } elseif ( $layout == 'style-3' ) {
                                echo haru_vidi_get_shortcode_template('vidi/playlist/'. 'content-playlist' . '.php', array( 'playlist_style' => 'playlist-style-2' ), '', '');
                            } else {
                                echo haru_vidi_get_shortcode_template('vidi/playlist/'. 'content-playlist' . '.php', array(), '', '');
                            }
                        }
                    }
                ?>
            <?php if ( in_array($layout, array('style-3') ) ) : ?>
            </div>
            <?php endif; ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}
