<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$shortcode_id = 'video-order-shortcode' . rand();

global $wp_query, $paged;

if ( is_front_page() ) {
    $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
} else {
    $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
}

$original_query = $wp_query;

$atts = compact('layout', 'columns', 'categories', 'video_style', 'posts_per_page'); 

$args = array(
    'posts_per_page'        => $posts_per_page, // -1 is Unlimited video
    'post_type'             => 'haru_video',
    'paged'                 => $paged,
    'ignore_sticky_posts'   => 1,
    'post_status'           => 'publish',
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
$video_order   = explode(',', $order_tabs)[0];
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

$wp_query = new WP_Query($args);
// Enqueue assets

?>
<?php if ( have_posts() ) : ?>
    <div class="video-order-shortcode <?php echo esc_attr( $layout . ' ' . $extra_class); ?>" id="<?php echo esc_attr( $shortcode_id ); ?>" data-atts="<?php echo htmlentities( json_encode($atts) ); ?>">
        <ul class="video-filter clearfix">
            <?php
                $order_tabs   = explode(',', $order_tabs);

                if ( !empty( $order_tabs ) ) :
                    foreach( $order_tabs as $key => $tab ) :
                        $tab_title = $tab . '_title';
            ?>
                <li class="tab-item <?php echo esc_attr( $tab ); ?>">
                    <h6 class="tab-item-heading">
                        <a class="filter-item <?php echo esc_attr( ($key == 0) ? 'active' : '' ); ?>"
                            href="javascript:;"
                            data-video_order="<?php echo esc_attr( $tab ); ?>"><?php echo esc_html( $$tab_title ); ?>
                        </a>
                    </h6>
                </li>
            <?php
                    endforeach;
                endif;
            ?>
        </ul>
        
        <div class="video-ajax-content <?php echo esc_attr( $layout ); ?>">
            <div class="ajax-loading-icon"><div class="loading-bar"></div></div>
            <div class="video-order-content">
                <?php if ( in_array($layout, array('default') ) ) : ?>
                <div class="video-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn <?php echo esc_attr( $video_style == 'video-style-6' ? 'layout-wrap style-list' : '' ); ?> haru-clear">
                <?php endif; ?>
                <?php 
                    while ( have_posts() ) : the_post();
                        echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => $video_style ), '', '');
                    endwhile;
                ?>
                </div>
            </div>
        </div>

        <div class="video-control <?php echo esc_attr( ($wp_query->max_num_pages > 1) ? '' : 'hide' ); ?> <?php echo esc_attr( $ajax_arrow == 'show' ? '' : 'hide' ); ?>">
            <div class="video-control-item disable"
                data-max_pages="<?php echo esc_attr( $wp_query->max_num_pages ); ?>" 
                data-current_page="1"
                data-video_order="<?php echo esc_attr( $order_tabs[0] ); ?>"
                data-action="prev"
            ><i class="haru-icon haru-arrow-left"></i></div>
            <div class="video-control-item"
                data-max_pages="<?php echo esc_attr( $wp_query->max_num_pages ); ?>" 
                data-current_page="1"
                data-video_order="<?php echo esc_attr( $order_tabs[0] ); ?>"
                data-action="next"
            ><i class="haru-icon haru-arrow-right"></i></div>
        </div>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-vidi' ); ?></div>
<?php endif;

wp_reset_query();
$wp_query = $original_query;
