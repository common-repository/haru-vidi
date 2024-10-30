<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$shortcode_id = 'video-list-category-shortcode' . rand();

global $wp_query;

$title = $title;
$style = $layout;
$orderby = isset( $orderby ) ? $orderby : 'title';
$count = ( $count === 'on' ) ? 1 : 0;
$hierarchical = ( $hierarchical === 'on' ) ? 1 : 0;
$show_children_only = ( $show_children_only === 'on' ) ? 1 : 0;
$hide_empty = ( $hide_empty === 'on' ) ? 1 : 0;

$list_args          = array(
    'show_count'   => $count,
    'hierarchical' => $hierarchical,
    'taxonomy'     => 'video_category',
    'hide_empty'   => $hide_empty,
);
$max_depth          = absint( isset( $max_depth ) ? $max_depth : '' );

$list_args['menu_order'] = false;
$list_args['depth']      = $max_depth;

if ( 'order' === $orderby ) {
    $list_args['orderby']      = 'meta_value_num';
    $list_args['meta_key']     = 'order';
}

$current_cat   = false;
$cat_ancestors = array();

if ( is_tax( 'video_category' ) ) {
    $current_cat   = $wp_query->queried_object;
    $cat_ancestors = get_ancestors( $current_cat->term_id, 'video_category' );

} elseif ( is_singular( 'haru_video' ) ) {
    $terms = get_terms(
        'video_category',
        array(
            'orderby' => 'parent',
            'order'   => 'DESC',
        )
    );

    if ( $terms ) {
        $main_term     = $terms[1]; // $terms[0]
        $current_cat   = $main_term;
        $cat_ancestors = get_ancestors( $main_term->term_id, 'video_category' );
    }
}

// Show Siblings and Children Only.
if ( $show_children_only && $current_cat ) {
    if ( $hierarchical ) {
        $include = array_merge(
            $cat_ancestors,
            array( $current_cat->term_id ),
            get_terms(
                'video_category',
                array(
                    'fields'       => 'ids',
                    'parent'       => 0,
                    'hierarchical' => true,
                    'hide_empty'   => false,
                )
            ),
            get_terms(
                'video_category',
                array(
                    'fields'       => 'ids',
                    'parent'       => $current_cat->term_id,
                    'hierarchical' => true,
                    'hide_empty'   => false,
                )
            )
        );
        // Gather siblings of ancestors.
        if ( $cat_ancestors ) {
            foreach ( $cat_ancestors as $ancestor ) {
                $include = array_merge(
                    $include,
                    get_terms(
                        'video_category',
                        array(
                            'fields'       => 'ids',
                            'parent'       => $ancestor,
                            'hierarchical' => false,
                            'hide_empty'   => false,
                        )
                    )
                );
            }
        }
    } else {
        // Direct children.
        $include = get_terms(
            'video_category',
            array(
                'fields'       => 'ids',
                'parent'       => $current_cat->term_id,
                'hierarchical' => true,
                'hide_empty'   => false,
            )
        );
    }

    $list_args['include']     = implode( ',', $include );

    if ( empty( $include ) ) {
        return;
    }
} elseif ( $show_children_only ) {
    $list_args['depth']            = 1;
    $list_args['child_of']         = 0;
    $list_args['hierarchical']     = 1;
}

include_once PLUGIN_HARU_VIDI_DIR . '/includes/vidi/class-video-cat-list-walker.php';

$list_args['walker']                     = new Haru_Vidi_Cat_List_Walker();
$list_args['title_li']                   = '';
$list_args['pad_counts']                 = 1;
$list_args['show_option_none']           = esc_html__( 'No video categories exist.', 'haru-vidi' );
$list_args['current_category']           = ( $current_cat ) ? $current_cat->term_id : '';
$list_args['current_category_ancestors'] = $cat_ancestors;
$list_args['max_depth']                  = $max_depth;

?>
<div class="video-list-category-shortcode <?php echo esc_attr( ( $style == 'default' ) ? : '' ); ?> widget-video-categories <?php echo esc_attr( $layout . ' ' . $extra_class); ?>" id="<?php echo esc_attr( $shortcode_id ); ?>">
    <?php if ( $title ) : ?>
    <h6 class="video-list-category-title haru-shortcode-title">
        <span><?php echo esc_html( $title ); ?></span>
    </h6>
    <?php endif; ?>
    <ul class="video-categories <?php echo esc_attr( $style ); ?>">
        <?php echo wp_list_categories( $list_args ); ?>
    </ul>
</div>

