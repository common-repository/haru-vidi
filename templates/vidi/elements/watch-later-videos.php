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

if ( !isset( $watch_later_cookie ) || !is_array( $watch_later_cookie ) ) {
    $watch_later_cookie = array();
}

$watch_later_video = $watch_later_cookie;

// Check if not have video
if ( !is_array( $watch_later_video ) || count($watch_later_video) < 1 ) {
    ?>
    <ul class="haru-watch-later-list">
        <li class="haru-watch-later-videos empty-video"></li>
        <li class="haru-watch-later-empty-video">
            <i class="haru-icon haru-file-video"></i>
            <div class="watch-later-empty-message">
                <?php echo esc_html__( 'An empty videos list!', 'haru-vidi'); ?>                  
            </div>
        </li>
        <li class="haru-watch-later-view-all">
            <?php 
                $haru_watch_later_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_watch_later_page', '' );
                $haru_watch_later_page_url = ( $haru_watch_later_page != '' && is_numeric( $haru_watch_later_page ) ) ? get_permalink( $haru_watch_later_page ) : get_permalink( get_page_by_path( 'watch-later' ) );
            ?>
            <a href="<?php echo esc_url( $haru_watch_later_page_url ); ?>" class="haru-button haru-button-default"><?php echo esc_html__( 'View all videos', 'haru-vidi' ); ?></a>
        </li>
    </ul>
    <?php
    return;
}
        
$args_query = array(
    'post__in'              => is_array( $watch_later_video ) ? $watch_later_video : array(),
    'post_type'             => 'haru_video',
    'posts_per_page'        => -1,
    'post_status'           => 'publish',
);

$watch_later_query = new WP_Query($args_query);
?>  
<ul class="haru-watch-later-list">
    <li class="haru-watch-later-videos">
    <?php 
        if ( $watch_later_query->have_posts() ) : 
            while ( $watch_later_query->have_posts()  ):
                $watch_later_query->the_post();
                ?>                      
                <div class="video-watch-later-item video-item video-<?php echo esc_attr( get_the_ID() ); ?>" id="video-watch-later-<?php echo esc_attr( get_the_ID() ); ?>">
                    <div class="video-content">
                        <div class="video-thumb">
                            <div class="video-img"><?php the_post_thumbnail(); ?></div>
                        </div>
                        <h6 class="video-title">
                            <a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a> 
                        </h6>
                    </div>
                    <div class="video-watch-later-delete" data-id="<?php echo esc_attr( get_the_ID() ); ?>"><i class="haru-icon haru-times"></i></div>
                </div>                      
                <?php
            endwhile;
        endif;
    ?>
    </li>
    <li class="haru-watch-later-empty-video">
        <i class="haru-icon haru-file-video"></i>
        <div class="watch-later-empty-message">
            <?php echo esc_html__( 'An empty videos list!', 'haru-vidi'); ?>                  
        </div>
    </li>
    <li class="haru-watch-later-view-all">
        <?php
            $haru_watch_later_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_watch_later_page', '' );;
            $haru_watch_later_page_url = ( $haru_watch_later_page != '' && is_numeric( $haru_watch_later_page ) ) ? get_permalink( $haru_watch_later_page ) : '#';
        ?>
        <a href="<?php echo esc_url( $haru_watch_later_page_url ); ?>" class="button-background button-background--primary button-background--medium"><?php echo esc_html__( 'View all videos', 'haru-vidi' ); ?></a>
    </li>
</ul>
<?php
wp_reset_query();

