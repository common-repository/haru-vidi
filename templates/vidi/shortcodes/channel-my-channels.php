<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$shortcode_id = 'channel-my-channels-shortcode' . rand();

if ( is_user_logged_in() ) :

    global $wp_query, $paged;
                
    if ( is_front_page() ) {
        $paged   = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
    } else {
        $paged   = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
    }

    if ( !is_singular('haru_shortcode') ) {
        $original_query = $wp_query;
    }

    $channel_style = 'default';
    $paging_style = 'default';
    $columns = 3;
    $posts_per_page = 9;    
    $author_id = get_current_user_id();

    $args = array(
        'posts_per_page' => $posts_per_page, // -1 is Unlimited channel
        'post_type'      => 'haru_channel',
        'paged'          => $paged,
        'post_status'    => 'publish', // @TODO: can add option pending channel when edit
        'author'         => $author_id
    );

    $wp_query = new WP_Query($args);
    // Enqueue assets

    ?>

    <?php if ( have_posts() ) : ?>
        <div class="channel-my-channels-shortcode <?php echo esc_attr( $layout . ' ' . $extra_class); ?>" id="<?php echo esc_attr( $shortcode_id ) ?>">
            <div class="haru-archive-top">
                <div class="haru-archive-top-left">
                    <h6 class="archive-channel__title"><?php echo esc_html__( 'You has total', 'haru-vidi' ); ?>
                        <span class="archive-channel__total-count"><?php echo esc_html( $wp_query->found_posts ) . esc_html__( ' channels', 'haru-vidi' ); ?></span>
                    </h6>
                </div>

                <div class="haru-archive-top-right">
                    <div class="haru-archive-layout-toggle">
                        <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                        <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                        <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                    </div>
                </div>
            </div>
                
            <div class="channel-list layout-wrap style-grid grid-columns grid-columns__<?php echo esc_attr( $columns ); ?>">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php echo haru_vidi_get_shortcode_template('vidi/channel/'. 'content-channel' . '.php', array( 'channel_style' => $channel_style, 'can_edit' => true ), '', ''); ?>
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
        <h6 class="haru-notice"><?php echo esc_html__( 'You don\'t created any channels yet!', 'haru-vidi' ) ?></h6>
    <?php endif;
    wp_reset_query();

    if ( !is_singular('haru_shortcode') ) {
        $wp_query = $original_query;
    }
?>

<?php else : ?>
    <h6 class="haru-notice"><?php echo esc_html__( 'Please login to see your channels!', 'haru-vidi' ); ?></h6>
<?php endif; ?>