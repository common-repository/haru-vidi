<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

global $watch_later_cookie;
// Example: $layout

if ( !isset( $watch_later_cookie ) || !is_array( $watch_later_cookie ) ) {
    $watch_later_cookie = array();
}

$watch_later_video = $watch_later_cookie;

$player_settings_popup = haru_vidi_get_setting( 'vidi-general-settings', 'player_settings_popup', 'off' );
// @TODO
$watch_later_playlist = haru_vidi_get_setting( 'vidi-general-settings', 'haru_watch_later_playlist', 'off' );

// Check if not have video
if ( !is_array( $watch_later_video ) || count($watch_later_video) < 1 ) {
    ?>
    <div class="haru-archive-watch-later">
        <div class="haru-watch-later-videos empty-video"></div>
        <div class="haru-watch-later-empty-video">
            <i class="haru-icon haru-file-video"></i>
            <div class="watch-later-empty-message">
                <?php echo esc_html__( 'No videos in Watch Later list!', 'haru-vidi'); ?>                  
            </div>
        </div>
    </div>
    <?php
} else {
    $args_query = array(
        'post__in'              => is_array( $watch_later_video ) ? $watch_later_video : array(),
        'post_type'             => 'haru_video',
        'posts_per_page'        => -1,
        'post_status'           => 'publish',
    );
    
    $watch_later_query = new WP_Query($args_query);

    // Enqueue assets
    wp_enqueue_script( 'imagesloaded' );
    wp_enqueue_script( 'isotope', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/isotope.pkgd.min.js'), array( 'jquery' ), '', true );
    wp_enqueue_script( 'packery-mode', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/packery-mode.pkgd.min.js'), array( 'jquery' ), '', true );
    ?>
    <div class="haru-archive-watch-later">
        <div class="haru-watch-later-videos">
            <div class="haru-archive-top">
                <div class="haru-archive-top-left">
                    <h6 class="archive-video__title"><?php echo esc_html__( 'Watch Later List has total', 'haru-vidi' ); ?>
                        <span class="archive-video__total-count"><?php echo esc_html( $watch_later_query->found_posts ) . esc_html__( ' videos', 'haru-vidi' ); ?></span>
                    </h6>
                </div>

                <div class="haru-archive-top-right">
                    <div class="haru-archive-layout-toggle">
                        <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                        <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                        <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                    </div>

                    <div class="single-playlist__playall"><a href="<?php echo esc_url( get_permalink( $watch_later_video[0] ) ); ?>?<?php echo haru_vidi_get_playlist_slug(); ?>=watch-later" class="button-background button-background--primary button-background--medium"><?php echo esc_html__( 'Play All Videos', 'haru-vidi' ); ?></a></div>
                </div>
            </div>
            
            <div class="archive-video-list layout-wrap style-grid grid-columns grid-columns__3">
                <?php 
                    $watch_later_list = 'watch-later';

                    if ( $watch_later_query->have_posts() ) : 
                        while ( $watch_later_query->have_posts()  ):
                            $watch_later_query->the_post();
                            echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array('playlist_id' => $watch_later_list), '', '');
                        endwhile;
                    endif;
                ?>
            </div>
        </div>                     

        <div class="haru-watch-later-empty-video">
            <i class="haru-icon haru-file-video"></i>
            <div class="watch-later-empty-message">
                <?php echo esc_html__( 'No videos in Watch Later list!', 'haru-vidi'); ?>                  
            </div>
        </div>
    </div>
<?php
wp_reset_query();
}
