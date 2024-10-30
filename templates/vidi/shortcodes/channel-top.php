<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$shortcode_id = 'channel-top-shortcode' . rand();

global $wp_query, $paged;

if ( is_front_page() ) {
    $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
} else {
    $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
}

$original_query = $wp_query;

$columns = 1;
$channel_style = 'default';

$atts = compact('layout', 'title', 'categories', 'order_by', 'order', 'channel_style', 'posts_per_page'); 

$args = array(
    'posts_per_page'        => $posts_per_page, // -1 is Unlimited channel
    'post_type'             => 'haru_channel',
    'paged'                 => $paged,
    'order'                 => $order,
    'ignore_sticky_posts'   => 1,
    'post_status'           => 'publish',
    'meta_query'            => array(),
);
// If use Categories
if ( isset($categories) && ($categories != '') ) {
    $args['tax_query'] = array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'channel_category',
                                'field'    => 'slug',
                                'terms'    => explode(',', $categories),
                            )
                        );
}
// Query Order
switch ( $order_by ) {
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
        $args['orderby']  = 'meta_value_num';
        $args['meta_key']  = '_post_like_count_total';
}

$wp_query = new WP_Query($args);
// Enqueue assets

?>
<?php if ( have_posts() ) : ?>
    <div class="channel-top-shortcode <?php echo esc_attr( $layout . ' ' . $extra_class); ?>" 
        id="<?php echo esc_attr( $shortcode_id ); ?>" 
        data-atts="<?php echo htmlentities( json_encode($atts) ); ?>"
        data-channel_order_by="<?php echo esc_attr( $order_by ); ?>"
    >
        <?php if ( $title != '' ) : ?>
            <h6 class="channel-top-title haru-shortcode-title"><span><?php echo esc_html( $title ); ?></span></h6>
        <?php endif; ?>

        <div class="channel-ajax-content <?php echo esc_attr( $layout ); ?>">
            <div class="ajax-loading-icon"><div class="loading-bar"></div></div>
            <div class="channel-top-content">
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
                    while ( have_posts() ) : the_post();
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
                    endwhile;
                ?>
                
                <?php if ( in_array($layout, array('style-3', 'style-4', 'style-6') ) ) : ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ( ( $title != '' ) && !in_array($layout, array('style-3') ) ) : ?>
        <div class="channel-control <?php echo esc_attr( ($wp_query->max_num_pages > 1) ? '' : 'hide' ); ?>">
            <div class="channel-control-item disable"
                data-max_pages="<?php echo esc_attr( $wp_query->max_num_pages ); ?>" 
                data-current_page="1"
                data-channel_order_by="<?php echo esc_attr( $order_by ); ?>"
                data-action="prev"
            ><i class="haru-icon haru-arrow-left"></i></div>
            <div class="channel-control-item"
                data-max_pages="<?php echo esc_attr( $wp_query->max_num_pages ); ?>" 
                data-current_page="1"
                data-channel_order_by="<?php echo esc_attr( $order_by ); ?>"
                data-action="next"
            ><i class="haru-icon haru-arrow-right"></i></div>
        </div>
        <?php endif; ?>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-vidi' ); ?></div>
<?php endif;

wp_reset_query();
$wp_query = $original_query;
