<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

global $wp_query, $paged;
            
if ( is_front_page() ) {
    $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
} else {
    $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
}

$original_query = $wp_query; 

$args = array(
    'orderby'        => 'post__in',
    'post__in'       => explode(',', $video_ids),
    'posts_per_page' => $posts_per_page, // -1 is Unlimited video
    'post_type'      => 'haru_video',
    'paged'          => $paged,
    'post_status'    => 'publish'
);

if ( $data_source == 'categories' ) {
    $args = array(
        'posts_per_page' => $posts_per_page, // -1 is Unlimited video
        'orderby'        => $orderby,
        'order'          => $order,
        'post_type'      => 'haru_video',
        'paged'          => $paged,
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'video_category',
                'field'    => 'slug',
                'terms'    => explode(',', $categories),
            )
        )
    );
}

$wp_query = new WP_Query($args);
$total_post = (int)$wp_query->found_posts;

// @TODO: Dark style
if ( in_array( $layout, array('list-small', 'list-fullwidth') ) ) {
    $dark_style = 'yes';
} else {
    $dark_style = 'no';
}

// Enqueue assets
wp_enqueue_style( 'slick', plugins_url( PLUGIN_HARU_VIDI_NAME.'/assets/libraries/slick/slick.css'), array() );
wp_enqueue_script( 'slick', plugins_url( PLUGIN_HARU_VIDI_NAME.'/assets/libraries/slick/slick.min.js'), array( 'jquery' ), '', true );
?>
<?php if ( have_posts() ) : ?>
    <div class="video-slideshow-shortcode <?php echo esc_attr( ($dark_style == 'yes') ? 'dark-style' : '' ); ?> <?php echo esc_attr( $layout . ' ' . $extra_class); ?>">
        <?php if ( ( $title != '') && !in_array($layout, array('list-small', 'list-fullwidth') ) ) : ?>
            <h6 class="video-slideshow-title haru-shortcode-title"><span><?php echo esc_html( $title ); ?></span></h6>
        <?php endif; ?>

        <?php if ( $layout == 'default' ) : ?>
        <div class="video-list haru-slick" 
            data-slick='{"slidesToShow" : <?php echo esc_attr( $columns ); ?>, "slidesToScroll": 1, "infinite" : true, "dots": true, "responsive" : [{"breakpoint": 991,"settings":{"slidesToShow": 3}}, {"breakpoint": 767,"settings":{"slidesToShow": 1}}] }'
        >
            <?php while ( have_posts() ) : the_post(); ?>
                <?php echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array(), '', ''); ?>
            <?php endwhile; ?>
        </div>

        <?php elseif ( in_array($layout, array('carousel-one', 'carousel-one-2') ) ) : ?>
        <div class="video-list haru-slick" 
            data-slick='{"slidesToShow" : 1, "slidesToScroll": 1, "infinite" : true, "dots": true }'
        >
            <?php while ( have_posts() ) : the_post(); ?>
                <?php echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array('video_style' => 'video-style-4'), '', ''); ?>
            <?php endwhile; ?>
        </div>

        <?php elseif ( $layout == 'featured' ) : ?>
        <div class="video-list haru-slick" 
            data-slick='{"slidesToShow" : 1, "slidesToScroll": 1, "infinite" : true, "dots": false, "variableWidth": false }'
        >
            <?php
            $i = 1;
            while ( have_posts() ) : the_post(); ?>
                <?php if ( ($i == 1) || ( ($i%5) == 1 ) ) : ?>
                <div class="item-slick grid-columns grid-columns__featured">
                    <?php endif; ?>
                <?php echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array('video_style' => 'video-style-2'), '', ''); ?>
                <?php if ( ( ($i%5) == 0 ) || ( $i == $total_post ) ) : ?>
                        </div>
                <?php endif; ?>
            <?php $i++; endwhile; ?>
        </div>

        <?php elseif ( $layout == 'nav-thumbnail' ) : ?>
        <div class="video-list haru-slick" 
            data-slick='{"slidesToShow" : 1, "slidesToScroll": 1, "infinite" : true, "dots": false, "asNavFor" : ".video-nav" }'
        >
            <?php while ( have_posts() ) : the_post(); ?>
                <?php echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array('video_style' => 'video-style-2'), '', ''); ?>
            <?php endwhile; ?>
        </div>
        <div class="video-nav haru-slick"
            data-slick='{"slidesToShow" : 4, "slidesToScroll" : 1, "arrows" : true, "infinite" : true, "centerMode" : false, "focusOnSelect" : true, "vertical" : false, "asNavFor" : ".video-list", "responsive" : [{"breakpoint": 991,"settings":{"slidesToShow": 3}}, {"breakpoint": 767,"settings":{"slidesToShow": 2}}] }'
        >
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="video-nav-item">
                    <?php haru_video_thumbnail( get_the_ID() ); ?>
                    <h6 class="video-item__title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_title(); ?></a></h6>
                </div>
            <?php endwhile; ?>
        </div>

        <?php elseif ( $layout == 'list-small' ) : ?>
        <div class="video-list haru-slick" 
            data-slick='{"slidesToShow" : <?php echo esc_attr( $columns ); ?>, "slidesToScroll": 1, "infinite" : true, "dots": false, "responsive" : [{"breakpoint": 991,"settings":{"slidesToShow": <?php echo esc_attr( $extra_class == 'style-sidebar' ? '2' : '3' ); ?>}}, {"breakpoint": 767,"settings":{"slidesToShow": 1}}] }'
        >
            <?php while ( have_posts() ) : the_post(); ?>
                <?php echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array(), '', ''); ?>
            <?php endwhile; ?>
        </div>

        <?php elseif ( $layout == 'info-featured' ) : ?>
        <div class="video-list haru-slick" 
            data-slick='{"slidesToShow" : 1, "slidesToScroll": 1, "infinite" : true, "dots": true }'
        >
            <?php while ( have_posts() ) : the_post(); ?>
                <?php echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array(), '', ''); ?>
            <?php endwhile; ?>
        </div>

        <?php elseif ( $layout == 'list-fullwidth' ) : ?>
        <div class="video-list haru-slick" 
            data-slick='{"slidesToShow" : <?php echo esc_attr( $columns ); ?>, "slidesToScroll": 1, "infinite" : true, "dots": false, "responsive" : [{"breakpoint": 991,"settings":{"slidesToShow": 3}}, {"breakpoint": 767,"settings":{"slidesToShow": 1}}] }'
        >
            <?php while ( have_posts() ) : the_post(); ?>
                <?php echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array(), '', ''); ?>
            <?php endwhile; ?>
        </div>

        <?php elseif ( $layout == 'carousel-no-padding' ) : ?>
        <div class="video-list haru-slick" 
            data-slick='{"slidesToShow" : <?php echo esc_attr( $columns ); ?>, "slidesToScroll": 1, "infinite" : true, "dots": false, "responsive" : [{"breakpoint": 991,"settings":{"slidesToShow": 2}}, {"breakpoint": 767,"settings":{"slidesToShow": 1}}] }'
        >
            <?php while ( have_posts() ) : the_post(); ?>
                <?php echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array('video_style' => 'video-style-2'), '', ''); ?>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-vidi' ) ?></div>
<?php endif;

wp_reset_query();
$wp_query = $original_query;
