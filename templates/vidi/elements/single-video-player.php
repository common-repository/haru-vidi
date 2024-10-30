<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$video_thumbnail_single_size = haru_vidi_get_setting( 'vidi-videos-settings', 'haru_video_thumbnail_single_size', 'ratio-169' );
$video_server = get_post_meta( get_the_ID(), 'haru_video' . '_server', true );
$video_autoplay = haru_vidi_get_setting( 'vidi-player-settings', 'player_settings_autoplay', 'off' );

$player_popup = false;
if ( $player_popup != true ) :
?>

<div class="video-player-container <?php echo esc_attr( $video_thumbnail_single_size ); ?>">
    <div class="video-light-off-overlay"></div>
    <div class="video-player-wrap server-<?php echo esc_attr( $video_server ); ?>">
        <div class="video-player-content">
            <div class="video-float">
                <h6 class="video-float__title"><?php the_title(); ?></h6>
                <div class="video-float__actions">
                    <div class="video-float__close"><i class="haru-icon haru-times"></i></div>
                </div>
            </div>

            <div class="video-player">
                <div class="haru-video-player">
                    <div class="video-player-data" 
                        data-id="<?php echo esc_attr( get_the_ID() ); ?>" 
                        data-server="<?php echo get_post_meta( get_the_ID(), 'haru_video' . '_server', true ); ?>"
                        data-thumb-url="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID() ) ? get_the_post_thumbnail_url( get_the_ID() ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>"
                        data-autoplay="<?php echo esc_attr( $video_autoplay == 'off' ? 'false' : 'true' ); ?>"
                    >
                    </div>

                    <?php do_action( 'haru_video_player_direct' ); ?>

                    <!-- Ads -->
                    <div class="video-ads-loading"><?php echo esc_html__( 'Loading advertisement...', 'haru-vidi' ); ?></div>
                    
                    <?php 
                        $next_video = haru_get_next_video_url( get_the_ID() );
                        if ( !empty($next_video) && $next_video['ID'] != '' ) :              
                    ?>
                        <div class="video-auto-next-wrap" data-next-url="<?php echo esc_url( $next_video['link'] ); ?>" style="background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( $next_video['ID'], 'full' ) ? get_the_post_thumbnail_url( $next_video['ID'], 'full' ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>);">
                            <div class="video-auto-next-content">
                                <div class="video-next-label"><?php echo esc_html__( 'Next Video', 'haru-vidi' ); ?></div>
                                <h6 class="video-next-title"><?php echo esc_html( get_the_title( $next_video['ID'] ) ); ?></h6>
                                
                                <div class="progress-time-wrap">
                                    <div class="progess-time-remain"></div>
                                    <svg class="progess-time" viewBox="0 0 40 40">
                                        <circle class="progress-time-circle" r="18" cx="20" cy="20"></circle>
                                    </svg>
                                </div>
                                
                                <a href="javascript:;" class="video-next-cancel"><?php echo esc_html__( 'Cancel', 'haru-vidi' ); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div> 
            </div>
        </div>
    </div>
</div>

<?php else : ?>
<div class="player-wrapper">
    <div class="video-player">
        <div class="media-wrapper" style="background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>); ">
            <div class="video-icon">
                <a href="javascript:;" 
                    class="video-player-popup" 
                    data-id="<?php echo esc_attr( the_ID() ); ?>" 
                >
                <?php echo esc_html__( 'Popup', 'haru-vidi' ); ?>
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

