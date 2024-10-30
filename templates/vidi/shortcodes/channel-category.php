<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$shortcode_id = 'channel-category-shortcode' . rand();

global $wp_query, $paged;

if ( is_front_page() ) {
    $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
} else {
    $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
}

$original_query = $wp_query;

$atts = compact('layout', 'columns', 'categories', 'channel_style', 'posts_per_page', 'filter', 'filter_all', 'orderby', 'order', 'view_more');

$args = array(
    'posts_per_page' => $posts_per_page, // -1 is Unlimited channel
    'orderby'        => $orderby,
    'order'          => $order,
    'post_type'      => 'haru_channel',
    'paged'          => $paged,
    'post_status'    => 'publish',
);
if ( $filter_all == 'show' || $filter == 'hide' ) {
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
            'terms'    => explode(',', $categories)[0],
        )
    );
}

$wp_query = new WP_Query($args);
// Enqueue assets

?>
<?php if ( have_posts() ) : ?>
    <div class="channel-category-shortcode <?php echo esc_attr( $layout . ' ' . $extra_class); ?>" data-atts="<?php echo htmlentities( json_encode($atts) ); ?>" id="<?php echo esc_attr( $shortcode_id ) ?>">
        <?php
            $slugSelected = explode(',', $categories);
            $terms = get_terms(
                array(
                    'taxonomy'  => 'channel_category',
                    'slug'      => $slugSelected,
                    'orderby'   => 'slug__in',
                )
            );
        ?>
        <div class="channel-category-top">
            <?php if ( $title != '' ) : ?>
                <h6 class="channel-category-title haru-shortcode-title"><?php echo esc_html( $title ); ?></h6>
            <?php endif; ?>

            <?php if ( $filter == 'show' ) : ?>
            <ul class="channel-filter">
                <?php if ( $filter_all == 'show' ) : ?>
                <li>
                    <h6 class="tab-item-heading">
                        <a class="filter-item filter-all active"
                            href="javascript:;"
                            data-category="*"
                        ><?php echo esc_html__( 'All', 'haru-vidi' ); ?></a>
                    </h6>
                </li>
                <?php endif; ?>
                <?php foreach ( $terms as $key => $term ) : ?>
                <li>
                    <h6 class="tab-item-heading">
                        <a class="filter-item <?php if ( ($key == 0) && ($filter_all == 'hide') ) echo 'active';  ?>"
                            href="javascript:;" 
                            data-category ="<?php echo esc_attr( $term->slug ); ?>"
                        ><?php echo wp_kses_post( $term->name ); ?></a>
                    </h6>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>
        
        <div class="channel-ajax-content">
            <div class="ajax-loading-icon"><div class="loading-bar"></div></div>
            <div class="channel-category-content">
                <?php if ( in_array($layout, array('default') ) ) : ?>
                <div class="channel-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn <?php echo esc_attr( $channel_style == 'channel-style-6' ? 'layout-wrap style-list' : '' ); ?> haru-clear">
                <?php endif; ?>
                <?php 
                    while ( have_posts() ) : the_post();
                        echo haru_vidi_get_shortcode_template('vidi/channel/'. 'content-channel' . '.php', array( 'channel_style' => $channel_style ), '', '');
                    endwhile;
                ?>
                </div>
                <?php if ( in_array($layout, array('default') ) && $view_more == 'button' ) : ?>
                    <div class="channels-ajax-view-more <?php echo esc_attr( $view_more == 'button' ? '' : 'hide' ); ?>">
                        <a href="<?php echo esc_url( ( $filter_all == 'show' || $filter == 'hide' ) ? get_post_type_archive_link('haru_channel') : get_term_link(explode(',', $categories)[0], 'channel_category') ); ?>" class="button-background button-background--primary button-background--small"><?php echo esc_html__( 'View more', 'haru-vidi' ); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ( $wp_query->max_num_pages > 1 ) : ?>
        <div class="channel-control <?php echo esc_attr( $view_more == 'arrow' ? '' : 'hide-control' ); ?>">
            <div class="channel-control-item disable"
                data-max_pages="<?php echo esc_attr( $wp_query->max_num_pages ); ?>" 
                data-current_page="1"
                data-category="<?php echo esc_attr( ($filter_all == 'show' || $filter == 'hide' ) ? '*' : explode(',', $categories)[0] ); ?>"
                data-action="prev"
            ><i class="haru-icon haru-arrow-left"></i></div>
            <div class="channel-control-item"
                data-max_pages="<?php echo esc_attr( $wp_query->max_num_pages ); ?>" 
                data-current_page="1"
                data-category="<?php echo esc_attr( ($filter_all == 'show' || $filter == 'hide' ) ? '*' : explode(',', $categories)[0] ); ?>"
                data-action="next"
            ><i class="haru-icon haru-arrow-right"></i></div>
        </div>
        <?php else : ?>
        <div class="channel-control hide">
            <div class="channel-control-item disable"
                data-max_pages="1" 
                data-current_page="1"
                data-category="<?php echo esc_attr( ($filter_all == 'show' || $filter == 'hide' ) ? '*' : explode(',', $categories)[0] ); ?>"
                data-action="prev"
            ><i class="haru-icon haru-arrow-left"></i></div>
            <div class="channel-control-item"
                data-max_pages="1" 
                data-current_page="1"
                data-category="<?php echo esc_attr( ($filter_all == 'show' || $filter == 'hide' ) ? '*' : explode(',', $categories)[0] ); ?>"
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
