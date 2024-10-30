<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$shortcode_id = 'video-list-shortcode' . rand();

global $wp_query, $paged;
            
if ( is_front_page() ) {
    $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
} else {
    $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
}

if ( !is_singular('haru_shortcode') ) {
    $original_query = $wp_query;
}

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
        'orderby'        => 'post_date',
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
// Enqueue assets
wp_enqueue_script( 'imagesloaded' );
wp_enqueue_script( 'isotope', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/isotope.pkgd.min.js'), array( 'jquery' ), '', true );
wp_enqueue_script( 'packery-mode', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/packery-mode.pkgd.min.js'), array( 'jquery' ), '', true );
?>
<?php if ( have_posts() ) : ?>
    <div class="video-list-shortcode <?php echo esc_attr( $layout . ' ' . $extra_class); ?>" id="<?php echo esc_attr( $shortcode_id ) ?>">
        <?php 
            $termIds = array();
            $video_terms = get_terms('video_category');
            if ($categories != '') {
                $slugSelected = explode(',', $categories);
                foreach ( $video_terms as $term ) {
                    if ( in_array($term->slug, $slugSelected) ) {
                        $termIds[$term->term_id] = $term->term_id;
                    }
                }
            }
            $array_terms = array(
                'include' => $termIds
            );
            $terms = get_terms('video_category', $array_terms);
        ?>
        <div class="video-list-top">
            <?php if ( $title != '' ) : ?>
                <h6 class="video-list-title haru-shortcode-title <?php if ( $filter != 'show' ) echo 'no-filter'; ?>"><?php echo esc_html( $title ); ?></h6>
            <?php endif; ?>

            <?php if ( $filter == 'show' ) : ?>
            <ul data-option-key="filter" class="video-filter">
                <li>
                    <h6 class="tab-item-heading">
                        <a class=""
                            href="javascript:;" 
                            data-option-value="*"
                        ><?php echo esc_html__( 'All', 'haru-vidi' ); ?></a>
                    </h6>
                </li>
                <?php foreach ( $terms as $term ) : ?>
                <li>
                    <h6 class="tab-item-heading">
                        <a class=""
                            href="javascript:;" 
                            data-option-value =".<?php echo esc_attr($term->slug); ?>"
                        ><?php echo wp_kses_post( $term->name ); ?></a>
                    </h6>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>
        </div>

        <div class="video-list layout-wrap style-grid grid-columns grid-columns__<?php echo esc_attr( $columns ); ?>">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array( 'video_style' => $video_style ), '', ''); ?>
            <?php endwhile; ?>
        </div>

        <?php if ( $paging_style != 'none' ) : ?>
        <div class="archive-pagination">
        	<?php
                switch ( $paging_style ) {
                    case 'load-more':
                        haru_paging_load_more_cpt();
                        break;
                    case 'infinite-scroll':
                        haru_paging_infinitescroll_cpt();
                        break;
                    default:
                        echo haru_paging_nav_cpt();
                        break;
                }
            ?>
    	</div>
        <?php endif; ?>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-vidi' ) ?></div>
<?php endif;
wp_reset_query();

if ( !is_singular('haru_shortcode') ) {
    $wp_query = $original_query;
}

