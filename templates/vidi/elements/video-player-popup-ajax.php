<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( !isset($_POST['video_id']) || empty( $_POST['video_id'] ) ) {
    die;
}
$video_popup_id = $_POST['video_id'];
// Clone from Player Direct
$player_type                = haru_get_option( 'player_type' );
$player_js                  = haru_get_option( 'player_js' );
$video_server               = get_post_meta( $video_popup_id, 'haru_video' . '_server', true );
$video_server_id            = get_post_meta( $video_popup_id, 'haru_video' . '_id', true );
$video_server_google_url    = get_post_meta( $video_popup_id, 'haru_video' . '_google_url', true );
$video_server_other         = get_post_meta( $video_popup_id, 'haru_video' . '_other', true );

// Video Selfhost
$video_server_url_type      = get_post_meta( get_the_ID(), 'haru_video' . '_url_type', true );
if ( $video_server_url_type == 'upload' ) {
    $video_file_mp4           = get_post_meta( get_the_ID(), 'haru_video' . '_file_mp4', true );
    $video_file_webm          = get_post_meta( get_the_ID(), 'haru_video' . '_file_webm', true );
} else {
    $video_server_url         = get_post_meta( get_the_ID(), 'haru_video' . '_url', true );
}
// @TODO

?>
<div class="video-player-container">
    <div class="video-player-wrap server-<?php echo esc_attr( $video_server ); ?>">
        <div class="video-player-content">
            <div class="video-float">
                <div class="video-float__title"><?php the_title(); ?></div>
                <div class="video-float__actions">
                    <div class="video-float__close"><?php echo esc_html__( 'Close', 'haru-vidi' ); ?></div>
                </div>
            </div>

            <div class="video-player">
                <div class="haru-video-player">
                    <div class="video-player-data" 
                        data-id="<?php echo esc_attr( $video_popup_id ); ?>" 
                        data-server="<?php echo get_post_meta( $video_popup_id, 'haru_video' . '_server', true ); ?>"
                        data-thumb-url="<?php echo esc_url( get_the_post_thumbnail_url( $video_popup_id ) ); ?>"
                    >
                    </div>

                    <div class="single-video-player">
                        <div class="video-image player-direct">
                            <div class="video-icon">
                                <a href="javascript:;" 
                                    class="video-player-direct" 
                                    data-id="<?php echo esc_attr( $video_popup_id ); ?>" 
                                    data-video-id="<?php echo esc_attr( get_post_meta( $video_popup_id, 'haru_video' . '_id', true ) ); ?>"
                                    data-player="<?php echo esc_attr( $player_js ); ?>" 
                                    data-video-server="<?php echo esc_attr( $video_server ); ?>"
                                >
                                </a>
                            </div>
                            
                            <div class="player-wrapper">
                                <div class="video-player">
                                    <div class="media-wrapper ratio-169" style="background-image: url(<?php echo esc_attr( get_the_post_thumbnail_url( $video_popup_id, 'full' ) ); ?>); ">
                                        <?php if ( $player_popup !== true ) : ?>
                                            <?php if ( $video_server == 'youtube' ) : ?>
                                                <div id="youtube-video"></div>
                                            <?php elseif ( $video_server == 'vimeo' ) : ?>
                                                <div id="vimeo-video"></div>
                                            <?php elseif ( $video_server == 'dailymotion' ) : // API Daily Motion: https://developer.dailymotion.com/player ?>
                                                <iframe id="dailymotion-video" frameborder="0" width="480" height="270" src="<?php echo is_ssl() ? 'https' : 'http' ?>://www.dailymotion.com/embed/video/<?php echo esc_attr( $video_server_id ); ?>?autoPlay=1&queue-enable=false&queue-autoplay-next=false" allowfullscreen="" allow="autoplay"></iframe>
                                            <?php elseif ( $video_server == 'twitch' ) : // API Twitch: https://dev.twitch.tv/docs/embed/ ?>
                                                <iframe id="twitch-video" src="https://player.twitch.tv/?video=<?php echo esc_attr( $video_server_id ); ?>&autoplay=true" height="720" width="1280" frameborder="0" scrolling="no" allowfullscreen="true"></iframe>
                                            <?php elseif ( $video_server == 'facebook' ) : // API Facebook: https://developers.facebook.com/docs/plugins/embedded-video-player/ ?>
                                                <iframe id="facebook-video" src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Ffacebook%2Fvideos%2F<?php echo esc_attr( $video_server_id ); ?>%2F&width=500&show_text=false&height=280&appId" width="500" height="280" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media" allowFullScreen="true"></iframe>
                                            <?php elseif ( $video_server == 'google' ) : // API Facebook: https://developers.facebook.com/docs/plugins/embedded-video-player/ ?>
                                                <video id="google-video" width="640" height="360" style="max-width: 100%;" preload="none" controls playsinline webkit-playsinline>
                                                    <source src="<?php echo esc_url( $video_server_google_url ); ?>" type="video/mp4">
                                                </video>
                                            <?php elseif ( $video_server == 'selfhost' ) : ?>
                                                <video id="video-player" width="640" height="360" style="max-width: 100%;" preload="none" controls playsinline webkit-playsinline>
                                                    <?php if ( $video_server_url_type == 'insert' ) : ?>
                                                        <source src="<?php echo esc_url( $video_server_url['mp4'] ); ?>" type="video/mp4">
                                                        <source src="<?php echo esc_url( $video_server_url['webm'] ); ?>" type="video/webm">
                                                    <?php elseif ( $video_server_url_type == 'upload' ) : ?>
                                                        <source src="<?php echo esc_url( $video_file_mp4 ); ?>" type="video/mp4">
                                                        <source src="<?php echo esc_url( $video_file_webm ); ?>" type="video/webm">
                                                    <?php endif;?>
                                                </video>
                                            <?php elseif ( $video_server == 'other' ) : ?>
                                                <div id="other-video-player">
                                                <?php echo do_shortcode( $video_server_other ); ?>
                                                </div>
                                            <?php endif;?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>   
        </div>
    </div>
</div>
<?php
    die;

