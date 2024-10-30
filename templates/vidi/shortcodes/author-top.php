<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$shortcode_id = 'author-top-shortcode' . rand();

// Get Top Videos Author: https://wordpress.stackexchange.com/questions/90600/wp-list-authors-including-custom-post-types
if ( !function_exists( 'haru_get_list_authors' ) ) {
    function haru_get_list_authors($args = '') {
        global $wpdb;

        $defaults = array(
            'orderby'           => 'name', // name, post_count
            'order'             => 'ASC', 
            'number'            => '',
            'exclude_admin'     => true,
            'hide_empty'        => true,
        );

        $args = wp_parse_args( $args, $defaults );
        extract( $args, EXTR_SKIP );

        $return = array();

        $query_args = wp_array_slice_assoc( $args, array( 'orderby', 'order', 'number' ) );
        $query_args['fields'] = 'ids';
        $authors = get_users( $query_args );

        $custom_post_types = array('haru_video');
        if ( !empty( $custom_post_types ) ) {
            $temp = implode ( "','", $custom_post_types );
            $custom_post_types = "'"; 
            $custom_post_types .= $temp; 
            $custom_post_types .= "','post'";
        } else {
            $custom_post_types .= "'post'";
        }

        $author_count = array();        
        foreach ( (array) $wpdb->get_results("SELECT DISTINCT post_author, COUNT(ID) AS count FROM $wpdb->posts WHERE post_type in ($custom_post_types) GROUP BY post_author") as $row )
            $author_count[$row->post_author] = $row->count;

        $return['authors'] = $authors;
        $return['author_count'] = $author_count;

        return $return;
    }
}

$exclude_admin = false; // @TODO: option
$hide_empty = false; // @TODO: option
$args = array(
    'orderby'           => $order_by,
    'order'             => $order,
    'number'            => $number,
    'exclude_admin'     => $exclude_admin,
    'hide_empty'        => $hide_empty,
);
$authors = haru_get_list_authors( $args )['authors'];
$author_count = haru_get_list_authors( $args )['author_count'];
// Enqueue assets

?>
<?php if ( ! empty( $authors ) ) : ?>
    <div class="author-top-shortcode <?php echo esc_attr( ($dark_style == 'yes') ? 'dark-style' : '' ); ?> <?php echo esc_attr( $layout . ' ' . $extra_class); ?>" 
        id="<?php echo esc_attr( $shortcode_id ); ?>"
        data-author_order_by="<?php echo esc_attr( $order_by ); ?>"
    >
        <?php if ( $title != '' ) : ?>
            <h6 class="author-top-title haru-shortcode-title"><span><?php echo esc_html( $title ); ?></span></h6>
        <?php endif; ?>

        <div class="author-ajax-content <?php echo esc_attr( $layout ); ?>">
            <div class="ajax-loading-icon"><div class="loading-bar"></div></div>
            <div class="author-top-content">
                <?php if ( in_array($layout, array('default') ) ) : $columns = 1; ?>
                <div class="author-list grid-columns grid-columns__<?php echo esc_attr( $columns ); ?> animated fadeIn haru-clear">
                <?php endif; ?>

                <?php
                    // Author Style
                    $author_class = 'default';

                    if ( isset( $author_style ) ) {
                        $author_class = $author_style;
                    }

                    foreach ( $authors as $key => $author_id ) :
                    $author = get_userdata( $author_id );

                    if ( $exclude_admin && 'admin' == $author->display_name )
                        continue;

                    $posts = isset( $author_count[$author->ID] ) ? $author_count[$author->ID] : 0;

                    if ( !$posts && $hide_empty )
                        continue;
                ?>
                <article class="grid-item author-item <?php echo esc_attr( $author_class ); ?>">
                    <div class="author-item__thumbnail">
                        <a href="<?php echo get_author_posts_url( $author->ID, $author->user_nicename ); ?>">
                            <?php echo get_avatar( $author_id ); ?>
                        </a>
                    </div>
                    <div class="author-item__content">
                        <h6 class="author-item__title"><a href="<?php echo esc_url( get_author_posts_url( $author->ID, $author->user_nicename ) ); ?>"><?php echo esc_html( $author->display_name ); ?></a></h6>
                        <div class="author-item__meta">
                            <div class="author-item__videos-count">
                                <?php echo esc_html( $posts ) . ( ($posts > 1) ? esc_html__( ' videos', 'haru-vidi' ) : esc_html__( ' video', 'haru-vidi' ) ); ?>
                            </div>
                            <div class="author-item__count-friends">
                                <?php
                                    if ( function_exists('bp_is_active') ) {
                                        do_action( 'haru_bp_friend_count' );
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="author-item__add-friend">
                    <?php 
                        if ( function_exists('bp_is_active') ) {
                            echo haru_bp_friend_button( $author_id );
                        }
                    ?>
                    </div>
                    
                </article>
                <?php endforeach; ?>

                <?php if ( in_array($layout, array('default') ) ) : ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="item-not-found"><?php echo esc_html__( 'No item found', 'haru-vidi' ); ?></div>
<?php endif;
