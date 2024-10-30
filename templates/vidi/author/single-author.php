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

global $wp_query;

// Enqueue assets
wp_enqueue_script( 'imagesloaded' );
wp_enqueue_script( 'isotope', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/isotope.pkgd.min.js'), array( 'jquery' ), '', true );
wp_enqueue_script( 'packery-mode', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/packery-mode.pkgd.min.js'), array( 'jquery' ), '', true );

$single_layout_full = haru_vidi_get_setting( 'vidi-authors-settings', 'single_author_settings_layout_full', 'off' );
$single_layout_sidebar = haru_vidi_get_setting( 'vidi-authors-settings', 'single_author_settings_sidebar', 'sidebar-none' );
$single_sidebar_left = haru_vidi_get_setting( 'vidi-authors-settings', 'single_author_settings_sidebar_left', '' );
$single_sidebar_right = haru_vidi_get_setting( 'vidi-authors-settings', 'single_author_settings_sidebar_right', '' );
$single_style = haru_vidi_get_setting( 'vidi-authors-settings', 'single_author_settings_style', 'style-1' );
$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
$author_id = $author->ID;

// https://code.tutsplus.com/articles/how-to-create-a-wordpress-authors-page-template--wp-23573 (get_user_meta)
?>
<div class="haru-single-breadcrumbs">
    <div class="<?php echo esc_attr( $single_layout_full == 'on' ? 'full-width' : 'haru-container' ); ?>">
        <?php echo haru_vidi_cpt_breadcrumbs(); ?>
    </div>
</div>

<div class="haru-single-author <?php echo esc_attr( $single_layout_full == 'on' ? '' : 'haru-container' ); ?>">
    <div class="single-content <?php if ( is_active_sidebar( $single_sidebar_left ) && in_array($single_layout_sidebar, array( 'sidebar-left', 'two-sidebar' ) ) ) echo esc_attr( 'has-left-sidebar' ); ?> <?php if ( is_active_sidebar( $single_sidebar_right ) && in_array($single_layout_sidebar, array( 'sidebar-right', 'two-sidebar' ) ) ) echo esc_attr( 'has-right-sidebar' ); ?>">
        <div class="author-info">
            <div class="author-avatar"><?php echo get_avatar( get_the_author_meta( 'user_email', $author_id ) ); ?></div>
            <div class="author-meta">
                <h6 class="author-name"><?php echo get_the_author_meta( 'display_name', $author_id ); ?></h6>
                <?php if ( get_the_author_meta( 'description', $author_id ) != '' ) : ?>
                <p class="author-bio"><?php echo get_the_author_meta( 'description', $author_id ); ?></p>
                <?php endif; ?>
                <ul class="author-social">
                    <?php if ( get_the_author_meta( 'user_email', $author_id ) != '' ) : ?>
                    <li><a class="author-social__email" href="mailto:<?php echo get_the_author_meta( 'user_email', $author_id ); ?>"><i class="fa fa-envelope"></i></a></li>
                    <?php endif; ?>
                    <?php if ( get_the_author_meta( 'haru_user_facebook_url', $author_id ) != '' ) : ?>
                    <li><a class="author-social__facebook" href="<?php echo esc_url( get_the_author_meta( 'haru_user_facebook_url', $author_id ) ); ?>"><i class="fa fa-facebook-f"></i></a></li>
                    <?php endif; ?>
                    <?php if ( get_the_author_meta( 'haru_user_twitter_url', $author_id ) != '' ) : ?>
                    <li><a class="author-social__twitter" href="<?php echo esc_url( get_the_author_meta( 'haru_user_twitter_url', $author_id ) ); ?>"><i class="fa fa-twitter"></i></a></li>
                    <?php endif; ?>
                    <?php if ( get_the_author_meta( 'haru_user_instagram_url', $author_id ) != '' ) : ?>
                    <li><a class="author-social__instagram" href="<?php echo esc_url( get_the_author_meta( 'haru_user_instagram_url', $author_id ) ); ?>"><i class="fa fa-instagram"></i></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <?php
            $tab_id = '';
            if ( isset($_GET['tab']) && trim($_GET['tab']) != '' ) {                   
                $tab_id = $_GET['tab'];
            }
        ?>
        <div class="single-author__tabs">
            <div class="single-author__tab single-author__tab-videos <?php echo ( $tab_id == '' || $tab_id == 'videos' ) ? 'active' : ''; ?>">
                <h6 class="tab-item-heading">
                    <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>?tab=videos" class="single-author__tab-link"><?php echo esc_html__( 'Videos', 'haru-vidi' ); ?></a>
                </h6>
            </div>
            <div class="single-author__tab single-author__tab-playlists <?php echo ( $tab_id == 'playlist' ) ? 'active' : ''; ?>">
                <h6 class="tab-item-heading">
                    <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>?tab=playlist" class="single-author__tab-link"><?php echo esc_html__( 'Playlists', 'haru-vidi' ); ?></a>
                </h6>
            </div>
            <div class="single-author__tab single-author__tab-seriess <?php echo ( $tab_id == 'series' ) ? 'active' : ''; ?>">
                <h6 class="tab-item-heading">
                    <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>?tab=series" class="single-author__tab-link"><?php echo esc_html__( 'Series', 'haru-vidi' ); ?></a>
                </h6>
            </div>
            <div class="single-author__tab single-author__tab-channels <?php echo ( $tab_id == 'channels' ) ? 'active' : ''; ?>">
                <h6 class="tab-item-heading">
                    <a href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>?tab=channels" class="single-author__tab-link"><?php echo esc_html__( 'Channels', 'haru-vidi' ); ?></a>
                </h6>
            </div>
        </div>

        <div class="single-author__tab-content">
            <!-- Video Tab -->
            <?php if ( $tab_id == '' || $tab_id == 'videos' ) : ?>
                <?php
                    $original_query = $wp_query;

                    $args = array(
                        'post_type'             => 'haru_video',
                        'posts_per_page'        => 6,
                        'post_status'           => 'publish',
                        'author'                => $author_id,
                    );

                    $wp_query = new WP_Query($args);
                ?>
                <?php if ( have_posts() ) : ?>
                    <div class="haru-archive-top">
                        <div class="haru-archive-top-left">
                        </div>

                        <div class="haru-archive-top-right">
                            <div class="haru-archive-layout-toggle">
                                <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                                <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                                <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                            </div>
                        </div>
                    </div>
        
                    <div class="single-author__videos layout-wrap style-grid grid-columns grid-columns__3">
                        <?php 
                            while ( have_posts() ) : the_post();
                                echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array(), '', '');
                            endwhile;
                        ?>
                    </div>
                <?php else : ?>
                    <h6 class="haru-no-item"><?php echo esc_html__( 'This user haven\'t created any videos yet!', 'haru-vidi' ); ?></h6>
                <?php endif; ?>

                <?php 
                    haru_author_paging_load_more_video(); 
                    wp_reset_query();
                    $wp_query = $original_query;
                ?>
            <?php endif; ?>

            <!-- Playlist Tab -->
            <?php if ( $tab_id == 'playlist' ) : ?>
                <?php
                    $original_query = $wp_query;

                    $args = array(
                        'post_type'             => 'haru_playlist',
                        'posts_per_page'        => 6,
                        'post_status'           => 'publish',
                        'author'                => $author_id,
                    );

                    $wp_query = new WP_Query($args);
                ?>
                <?php if ( have_posts() ) : ?>
                    <div class="haru-archive-top">
                        <div class="haru-archive-top-left">
                        </div>

                        <div class="haru-archive-top-right">
                            <div class="haru-archive-layout-toggle">
                                <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                                <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                                <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                            </div>
                        </div>
                    </div>
        
                    <div class="single-author__playlists layout-wrap style-grid grid-columns grid-columns__3">
                        <?php 
                            while ( have_posts() ) : the_post();
                                echo haru_vidi_get_shortcode_template('vidi/playlist/'. 'content-playlist' . '.php', array(), '', '');
                            endwhile;
                        ?>
                    </div>
                <?php else : ?>
                    <h6 class="haru-no-item"><?php echo esc_html__( 'This user haven\'t created any playlists yet!', 'haru-vidi' ); ?></h6>
                <?php endif; ?>

                <?php 
                    haru_author_paging_load_more_playlist();
                    wp_reset_query();
                    $wp_query = $original_query;
                ?>
            <?php endif; ?>

            <!-- Series Tab -->
            <?php if ( $tab_id == 'series' ) : ?>
                <?php
                    $original_query = $wp_query;

                    $args = array(
                        'post_type'             => 'haru_series',
                        'posts_per_page'        => 6,
                        'post_status'           => 'publish',
                        'author'                => $author_id,
                    );

                    $wp_query = new WP_Query($args);
                ?>
                <?php if ( have_posts() ) : ?>
                    <div class="haru-archive-top">
                        <div class="haru-archive-top-left">
                        </div>

                        <div class="haru-archive-top-right">
                            <div class="haru-archive-layout-toggle">
                                <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                                <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                                <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                            </div>
                        </div>
                    </div>
        
                    <div class="single-author__seriess layout-wrap style-grid grid-columns grid-columns__3">
                        <?php 
                            while ( have_posts() ) : the_post();
                                echo haru_vidi_get_shortcode_template('vidi/series/'. 'content-series' . '.php', array(), '', '');
                            endwhile;
                        ?>
                    </div>
                <?php else : ?>
                    <h6 class="haru-no-item"><?php echo esc_html__( 'This user haven\'t created any series yet!', 'haru-vidi' ); ?></h6>
                <?php endif; ?>

                <?php 
                    haru_author_paging_load_more_series();
                    wp_reset_query();
                    $wp_query = $original_query;
                ?>
            <?php endif; ?>

            <!-- Channel Tab -->
            <?php if ( $tab_id == 'channels' ) : ?>
                <?php
                    $original_query = $wp_query;

                    $args = array(
                        'post_type'             => 'haru_channel',
                        'posts_per_page'        => 6,
                        'post_status'           => 'publish',
                        'author'                => $author_id,
                    );

                    $wp_query = new WP_Query($args);
                ?>
                <?php if ( have_posts() ) : ?>
                    <div class="haru-archive-top">
                        <div class="haru-archive-top-left">
                        </div>

                        <div class="haru-archive-top-right">
                            <div class="haru-archive-layout-toggle">
                                <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                                <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                                <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                            </div>
                        </div>
                    </div>
        
                    <div class="single-author__channels layout-wrap style-grid grid-columns grid-columns__3">
                        <?php 
                            while ( have_posts() ) : the_post();
                                echo haru_vidi_get_shortcode_template('vidi/channel/'. 'content-channel' . '.php', array(), '', '');
                            endwhile;
                        ?>
                    </div>
                <?php else : ?>
                    <h6 class="haru-no-item"><?php echo esc_html__( 'This user haven\'t created any channels yet!', 'haru-vidi' ); ?></h6>
                <?php endif; ?>

                <?php 
                    haru_author_paging_load_more_channel();
                    wp_reset_query();
                    $wp_query = $original_query;
                ?>
            <?php endif; ?>
        </div>
    </div>
    <!-- Sidebar -->
    <?php if ( is_active_sidebar( $single_sidebar_left ) && in_array($single_layout_sidebar, array( 'sidebar-left', 'two-sidebar' ) ) ) : ?>
        <div class="single-sidebar left-sidebar">
            <?php dynamic_sidebar( $single_sidebar_left ); ?>
        </div>
    <?php endif; ?>
    <?php if ( is_active_sidebar( $single_sidebar_right ) && in_array($single_layout_sidebar, array( 'sidebar-right', 'two-sidebar' ) ) ) : ?>
        <div class="single-sidebar right-sidebar">
            <?php dynamic_sidebar( $single_sidebar_right ); ?>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer(); 
