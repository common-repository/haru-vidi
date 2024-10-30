<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$shortcode_id = 'video-category-single-shortcode' . rand();
$columns = 1;
$video_style = 'default';

global $wp_query, $paged;

if ( is_front_page() ) {
    $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
} else {
    $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
}

$original_query = $wp_query;

$atts = compact('layout', 'columns', 'categories', 'video_style', 'posts_per_page', 'orderby', 'order', 'view_more');

$args = array(
    'posts_per_page' => $posts_per_page, // -1 is Unlimited video
    'orderby'        => $orderby,
    'order'          => $order,
    'post_type'      => 'haru_video',
    'paged'          => $paged,
    'post_status'    => 'publish',
);

$args['tax_query'] = array(
    array(
        'taxonomy' => 'video_category',
        'field'    => 'slug',
        'terms'    => explode(',', $categories)[0],
    )
);

$wp_query = new WP_Query($args);
// Enqueue assets

?>
<?php if ( have_posts() ) : ?>
    <div class="video-category-single-shortcode <?php echo esc_attr( $layout . ' ' . $extra_class); ?>" data-atts="<?php echo htmlentities( json_encode($atts) ); ?>" id="<?php echo esc_attr( $shortcode_id ) ?>">
        <?php
            $slugSelected = explode(',', $categories);
            $terms = get_terms(
                array(
                    'taxonomy'  => 'video_category',
                    'slug'      => $slugSelected,
                    'orderby'   => 'slug__in',
                )
            );
        ?>

        <ul class="video-filter">
            <?php foreach ( $terms as $key => $term ) : ?>
            <li>
                <h6 class="tab-item-heading">
                    <a class="filter-item <?php if ( $key == 0 ) echo 'active'; ?>"
                        href="javascript:;" 
                        data-category ="<?php echo esc_attr( $term->slug ); ?>"
                    ><?php echo wp_kses_post( $term->name ); ?></a>
                </h6>
            </li>
            <?php endforeach; ?>
        </ul>
        
        <div class="video-ajax-content">
            <div class="ajax-loading-icon"><div class="loading-bar"></div></div>
            <div class="video-category-single-content">
                <?php if ( in_array($layout, array('default', 'style-2') ) ) : ?>
                <div class="video-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn haru-clear">
                <?php endif; ?>
                <?php 
                    $i = 0;
                    while ( have_posts() ) : the_post();
                        if ( $i == 0 ) {
                            echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => 'video-style-2' ), '', '');
                        } else {
                            echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => $video_style ), '', '');
                        }
                    $i++;
                    endwhile;
                ?>
                </div>
                <?php if ( in_array($layout, array('default', 'style-2') ) && $view_more == 'button' ) : ?>
                    <div class="videos-ajax-view-more <?php echo esc_attr( $view_more == 'button' ? '' : 'hide' ); ?>">
                        <a href="<?php echo esc_url( get_term_link(explode(',', $categories)[0], 'video_category') ); ?>" class="button-background button-background--primary button-background--small"><?php echo esc_html__( 'View more', 'haru-vidi' ); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ( $wp_query->max_num_pages > 1 ) : ?>
        <div class="video-control <?php echo esc_attr( $view_more == 'arrow' ? '' : 'hide' ); ?>">
            <div class="video-control-item disable"
                data-max_pages="<?php echo esc_attr( $wp_query->max_num_pages ); ?>" 
                data-current_page="1"
                data-category="<?php echo esc_attr( explode(',', $categories)[0] ); ?>"
                data-action="prev"
            ><i class="haru-icon haru-arrow-left"></i></div>
            <div class="video-control-item"
                data-max_pages="<?php echo esc_attr( $wp_query->max_num_pages ); ?>" 
                data-current_page="1"
                data-category="<?php echo esc_attr( explode(',', $categories)[0] ); ?>"
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
