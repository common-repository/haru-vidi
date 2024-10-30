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
    'post__in'       => explode(',', $series_ids),
    'posts_per_page' => $posts_per_page, // -1 is Unlimited series
    'post_type'      => 'haru_series',
    'paged'          => $paged,
    'post_status'    => 'publish'
);

if ( $data_source == 'categories' ) {
    $args = array(
        'posts_per_page' => $posts_per_page, // -1 is Unlimited series
        'orderby'        => $orderby,
        'order'          => $order,
        'post_type'      => 'haru_series',
        'paged'          => $paged,
        'post_status'    => 'publish',
        'tax_query'      => array(
            array(
                'taxonomy' => 'series_category',
                'field'    => 'slug',
                'terms'    => explode(',', $categories),
            )
        )
    );
}

$wp_query = new WP_Query($args);
$total_post = (int)$wp_query->found_posts;
// Enqueue assets
wp_enqueue_style( 'slick', plugins_url( PLUGIN_HARU_VIDI_NAME.'/assets/libraries/slick/slick.css'), array() );
wp_enqueue_script( 'slick', plugins_url( PLUGIN_HARU_VIDI_NAME.'/assets/libraries/slick/slick.min.js'), array( 'jquery' ), '', true );
?>
<?php if ( have_posts() ) : ?>
    <div class="series-slideshow-shortcode <?php echo esc_attr( $layout . ' ' . $extra_class); ?>">
        <?php if ( $title != '' ) : ?>
            <h6 class="series-slideshow-title haru-shortcode-title"><span><?php echo esc_html( $title ); ?></span></h6>
        <?php endif; ?>
            
        <?php if ( in_array($layout, array('default') ) ) : ?>
        <div class="series-list haru-slick" 
            data-slick='{"slidesToShow" : <?php echo esc_attr( $columns ); ?>, "slidesToScroll": 1, "infinite" : true, "dots": true, "responsive" : [{"breakpoint": 991,"settings":{"slidesToShow": 2}}, {"breakpoint": 757,"settings":{"slidesToShow": 1}}] }'
        >
            <?php while ( have_posts() ) : the_post(); ?>
                <?php echo haru_vidi_get_shortcode_template('vidi/series/'. 'content-series' . '.php', array( 'series_style' => $series_style ), '', ''); ?>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-vidi' ) ?></div>
<?php endif;

wp_reset_query();
$wp_query = $original_query;
