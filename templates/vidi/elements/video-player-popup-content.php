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
$playlist_id = $_POST['playlist_id'];
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

// Ads
$video_ads = get_post_meta( $video_popup_id, 'haru_video' . '_ads', true );
if ( ($video_ads == '') || ($video_ads == '-1') ) {
    $video_ads = haru_vidi_get_setting( 'vidi-ads-settings', 'haru_video_ads', '0' );
}

$video_ads_type = get_post_meta( $video_popup_id, 'haru_video' . '_ads_type', true );
if ( ($video_ads_type == '') || ($video_ads_type == '-1') ) {
    $video_ads_type = haru_vidi_get_setting( 'vidi-ads-settings', 'haru_video_ads_type', '' );
}

$video_ads_image = get_post_meta( $video_popup_id, 'haru_video' . '_ads_image', false );
if ( ($video_ads_image == '') || ($video_ads_image == '-1') ) {
    $video_ads_image = haru_vidi_get_setting( 'vidi-ads-settings', 'haru_video_ads_image', '' );
}

$video_ads_video = get_post_meta( $video_popup_id, 'haru_video' . '_ads_video', false );
if ( ($video_ads_video == '') || ($video_ads_video == '-1') ) {
    $video_ads_video = haru_vidi_get_setting( 'vidi-ads-settings', 'haru_video_ads_video', '' );
}

$video_ads_google_ima = get_post_meta( $video_popup_id, 'haru_video' . '_ads_google_ima', false );
if ( ($video_ads_google_ima == '') || ($video_ads_google_ima == '-1') ) {
    $video_ads_google_ima = haru_vidi_get_setting( 'vidi-ads-settings', 'haru_video_ads_google_ima', '' );
}

// IMA Mobile
$video_ads_google_ima_mobile = get_post_meta( $video_popup_id, 'haru_video' . '_ads_google_ima_mobile', false );
if ( ($video_ads_google_ima_mobile == '') || ($video_ads_google_ima_mobile == '-1') ) {
    $video_ads_google_ima_mobile = haru_vidi_get_setting( 'vidi-ads-settings', 'haru_video_ads_google_ima_mobile', '' );
}

// Ads IDs
$video_ads_array = array();
if ( $video_ads_type == 'image' ) {
    $video_ads_ids = haru_get_random_by_weight($video_ads_image); // Need test again now is reserve
}
if ( $video_ads_type == 'html5_video' ) {
    $video_ads_ids = haru_get_random_by_weight($video_ads_video);
}
if ( $video_ads_type == 'google_ima' ) {
    $video_ads_ids = haru_get_random_by_weight($video_ads_google_ima);
}

foreach ( $video_ads_ids as $video_id => $weight ) {
    if ( $video_ads_type == 'image' ) {
        $video_ads_array[$weight]['image'] = wp_get_attachment_image_src( get_post_meta( $video_id, 'haru_advertising_image', true ), 'full' )[0];
    }

    if ( $video_ads_type == 'html5_video' ) {
        $video_ads_array[$weight]['video'][] = get_post_meta( $video_id, 'haru_advertising_html5_video', true );
    }

    if ( $video_ads_type == 'google_ima' ) {
        $video_ads_array[$weight]['google_ima'] = get_post_meta( $video_id, 'haru_advertising_google_ima', true );
    }
    // General
    if ( $video_ads_type !== 'google_ima' && $video_ads_type !== 'html5' ) {
        $video_ads_array[$weight]['link'] = get_post_meta( $video_id, 'haru_advertising_link', true );
    }
}

// Ads IDs Mobile
$video_ads_array_mobile = array();
if ( $video_ads_type == 'google_ima' ) {
    $video_ads_ids_mobile = haru_get_random_by_weight($video_ads_google_ima_mobile);

    foreach ( $video_ads_ids_mobile as $video_id => $weight ) {
        if ( $video_ads_type == 'google_ima' ) {
            $video_ads_array_mobile[$weight]['google_ima_mobile'] = get_post_meta( $video_id, 'haru_advertising_google_ima', true );
        }
    }
}

$video_ads_time_show = get_post_meta( $video_popup_id, 'haru_video' . '_ads_time_show', true );
if ( ($video_ads_time_show == '') || ($video_ads_time_show == '-1') ) {
    $video_ads_time_show = haru_vidi_get_setting( 'vidi-ads-settings', 'haru_video_ads_time_show', '' );
}
foreach ( $video_ads_time_show as $key => $time ) {
    $video_ads_time_show[$key] = (float)$time;
}

$video_ads_time_skip = get_post_meta( $video_popup_id, 'haru_video' . '_ads_time_skip', true );
if ( ($video_ads_time_skip == '') || ($video_ads_time_skip == '-1') ) {
    $video_ads_time_skip = haru_vidi_get_setting( 'vidi-ads-settings', 'haru_video_ads_time_skip', '' );
}

$video_ads_time_hide = get_post_meta( $video_popup_id, 'haru_video' . '_ads_time_hide', true );
if ( ($video_ads_time_hide == '') || ($video_ads_time_hide == '-1') ) {
    $video_ads_time_hide = haru_vidi_get_setting( 'vidi-ads-settings', 'haru_video_ads_time_hide', '' );
}

$data_ads                           = array();
$data_ads['ads_on']                 = ( $video_ads == '1' ) ? true : false;
$data_ads['ads_type']               = $video_ads_type;
$data_ads['ads_time_show']          = wp_json_encode($video_ads_time_show);
$data_ads['ads_time_skip']          = (float)$video_ads_time_skip;
$data_ads['ads_time_hide']          = (float)$video_ads_time_hide;
$data_ads['ads_images']             = wp_json_encode($video_ads_array);
$data_ads['ads_videos']             = wp_json_encode($video_ads_array);
$data_ads['ads_google_ima']         = wp_json_encode($video_ads_array);
$data_ads['ads_google_ima_mobile']  = wp_json_encode($video_ads_array_mobile);
?>
<div class="haru-lightbox-content">
	<div class="single-video-wrap <?php echo esc_attr( ( isset( $playlist_id ) && ($playlist_id != '') ) ? 'in-playlist' : '' ); ?>">
	    <div class="single-video-top">
	        <div class="video-player-container">
	            <div class="video-player-wrap server-<?php echo esc_attr( $video_server ); ?>">
	                <div class="video-player-content">
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
	                                            data-ads="<?php echo esc_attr( wp_json_encode($data_ads) ); ?>"
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
	                                <!-- Use this for Fullscreen with Ads -->
	                                <?php
	                                    $video_ads = get_post_meta( $video_popup_id, 'haru_video' . '_ads', true );
	                                    if ( ($video_ads == '') || ($video_ads == '-1') ) {
	                                        $video_ads = haru_vidi_get_setting( 'vidi-ads-settings', 'haru_video_ads', '0' );
	                                    }

	                                    if ( $video_ads == '1' ) :
	                                ?>
	                                <div class="video-toggle-fullscreen"><?php echo esc_html__( 'Full', 'haru-vidi' ); ?></div>
	                                <?php endif; ?>     
	                            </div>

	                            <!-- Ads -->
	                            <div class="video-ads-loading">
	                                <?php echo esc_html__( 'Loading advertisement...', 'haru-vidi' ); ?>
	                            </div>
	                        </div>
	                    </div>  
	                </div>
	            </div>
	        </div>
	        <!-- Lightbox Playlist -->
	        <?php 
	        if ( isset( $playlist_id ) && ($playlist_id != '') ) : ?>
	        <div class="single-video-playlist popup-playlist">
	            <?php 
	                $playlist_video_ids = get_post_meta( $playlist_id, 'haru_playlist_attached_videos', true ); 
	            ?>
	            <ul class="playlist-videos">
	            <?php foreach( $playlist_video_ids as $playlist_video_id ) : ?>
	                <li class="video-item <?php echo esc_attr( $video_popup_id == $playlist_video_id ? 'active' : '' ); ?>">
	                    <div class="video-thumbnail">
	                        <a href="javascript:;" 
	                            class="video-player-popup-ajax" 
	                            data-id="<?php echo esc_attr( $playlist_video_id ); ?>" 
	                        >
	                            <img src="<?php echo esc_url( get_the_post_thumbnail_url( $playlist_video_id ) ); ?>" alt="<?php echo get_the_title( $playlist_video_id ); ?>">
	                        </a>
	                    </div>
	                    <div class="video-content">
	                        <a href="<?php echo esc_url( get_permalink( $playlist_video_id ) ); ?>?<?php echo haru_vidi_get_playlist_slug(); ?>=<?php echo esc_attr( $playlist_id ); ?>"><?php echo esc_html( get_the_title( $playlist_video_id ) ); ?></a>
	                    </div>
	                </li>
	            <?php endforeach; ?>
	            </ul>
	        </div>
	        <?php endif; ?>
	    </div>
	</div>
</div>
<?php
die;

