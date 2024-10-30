<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

get_header();

$count = $GLOBALS['wp_query']->found_posts;

// Enqueue assets
wp_enqueue_script( 'imagesloaded' );
wp_enqueue_script( 'isotope', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/isotope.pkgd.min.js'), array( 'jquery' ), '', true );
wp_enqueue_script( 'packery-mode', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/packery-mode.pkgd.min.js'), array( 'jquery' ), '', true );

$archive_layout_full = haru_vidi_get_setting( 'vidi-playlists-settings', 'archive_playlists_settings_layout_full', 'off' );
$archive_layout_sidebar = haru_vidi_get_setting( 'vidi-playlists-settings', 'archive_playlists_settings_sidebar', 'sidebar-none' );
$archive_sidebar_left = haru_vidi_get_setting( 'vidi-playlists-settings', 'archive_playlists_settings_sidebar_left', '' );
$archive_sidebar_right = haru_vidi_get_setting( 'vidi-playlists-settings', 'archive_playlists_settings_sidebar_right', '' );
$archive_columns = haru_vidi_get_setting( 'vidi-playlists-settings', 'archive_playlists_settings_columns', '2' );
$archive_per_page = haru_vidi_get_setting( 'vidi-playlists-settings', 'archive_playlists_settings_per_page', '' );
$archive_paging_style = haru_vidi_get_setting( 'vidi-playlists-settings', 'archive_playlists_settings_paging_style', 'default' );

?>
<div class="haru-archive-breadcrumbs">
    <div class="<?php echo esc_attr( $archive_layout_full == 'on' ? 'full-width' : 'haru-container' ); ?>">
        <?php echo haru_vidi_cpt_breadcrumbs(); ?>
    </div>
</div>
<div class="haru-archive-playlist <?php echo esc_attr( $archive_layout_full == 'on' ? '' : 'haru-container' ); ?>">
    <!-- Content -->
    <div class="archive-content <?php if ( is_active_sidebar( $archive_sidebar_left ) && in_array($archive_layout_sidebar, array( 'sidebar-left', 'two-sidebar' ) ) ) echo esc_attr( 'has-left-sidebar' ); ?> <?php if ( is_active_sidebar( $archive_sidebar_right ) && in_array($archive_layout_sidebar, array( 'sidebar-right', 'two-sidebar' ) ) ) echo esc_attr( 'has-right-sidebar' ); ?>">
       
        <?php 
            $archive_video_url = haru_get_archive_url(); // Similar Woo
            $orderby = 'date';
            if ( isset($_GET['orderby']) && ( $_GET['orderby'] !== '' ) ) {
                $orderby = $_GET['orderby'];
            }
        ?>

        <div class="haru-archive-top">
            <div class="haru-archive-top-left">
                 <h6 class="archive-playlist__title"><?php echo esc_html__( 'Has total', 'haru-vidi' ); ?>
                    <span class="archive-playlist__total-count"><?php echo esc_html( $count ); echo ( $count > 1 ) ? esc_html__( ' playlists', 'haru-vidi' ) : esc_html__( ' playlist', 'haru-vidi' ); ?></span>
                </h6>
            </div>
            <div class="haru-archive-top-right">
                <div class="haru-archive-layout-toggle">
                    <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                    <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                    <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                </div>
                <div class="haru-archive-order">
                    <div class="order-item-current"><?php echo esc_html( $orderby ); ?></div>
                    <ul class="order-items">
                        <li class="order-item <?php echo esc_attr( ($orderby == 'date') ? 'selected' : '' ); ?>">
                            <a href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'date' ), $archive_video_url ) ); ?>"><?php echo esc_html__( 'Date', 'haru-vidi' ); ?></a>
                        </li>                                    
                        <li class="order-item <?php echo esc_attr( ($orderby == 'title') ? 'selected' : '' ); ?>">
                            <a href="<?php echo esc_url( add_query_arg( array( 'orderby' => 'title' ), $archive_video_url ) ); ?>"><?php echo esc_html__( 'Title', 'haru-vidi' ); ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <?php if ( have_posts() ) : ?>
        <div class="archive-playlist-list layout-wrap style-grid grid-columns grid-columns__<?php echo esc_attr( $archive_columns ); ?>">
            <?php
                // Start the Loop.
                while ( have_posts() ) : the_post();
                    echo haru_vidi_get_shortcode_template('vidi/playlist/'. 'content-playlist' . '.php', array(), '', '');
                endwhile;
            ?>
        </div>
        <?php else : ?>
        <h6 class="haru-notice"><?php echo esc_html__( 'No Item Found!', 'haru-vidi' ); ?></h6>
        <?php endif; ?>
        
        <?php
            global $wp_query;

            if ( $wp_query->max_num_pages >= 2 ) :
        ?>
        <div class="archive-pagination">
            <?php
                switch ( $archive_paging_style ) {
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
    <!-- Sidebar -->
    <?php if ( is_active_sidebar( $archive_sidebar_left ) && in_array($archive_layout_sidebar, array( 'sidebar-left', 'two-sidebar' ) ) ) : ?>
        <div class="archive-sidebar left-sidebar">
            <?php dynamic_sidebar( $archive_sidebar_left ); ?>
        </div>
    <?php endif; ?>
    <?php if ( is_active_sidebar( $archive_sidebar_right ) && in_array($archive_layout_sidebar, array( 'sidebar-right', 'two-sidebar' ) ) ) : ?>
        <div class="archive-sidebar right-sidebar">
            <?php dynamic_sidebar( $archive_sidebar_right ); ?>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer(); 

