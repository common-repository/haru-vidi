<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$player_js                  = haru_vidi_get_setting( 'vidi-player-settings', 'player_js', 'none' );
$video_server               = get_post_meta( get_the_ID(), 'haru_video' . '_server', true );
$video_server_id            = get_post_meta( get_the_ID(), 'haru_video' . '_id', true );
$video_server_facebook_url  = get_post_meta( get_the_ID(), 'haru_video' . '_facebook_url', true );
$video_server_google_url    = get_post_meta( get_the_ID(), 'haru_video' . '_google_url', true );
$video_server_embed         = get_post_meta( get_the_ID(), 'haru_video' . '_embed', true );
$video_server_other         = get_post_meta( get_the_ID(), 'haru_video' . '_other', true );
$video_autoplay             = haru_vidi_get_setting( 'vidi-player-settings', 'player_settings_autoplay', 'off' );
// Video Selfhost
$video_server_url_type      = get_post_meta( get_the_ID(), 'haru_video' . '_url_type', true );
if ( $video_server_url_type == 'upload' ) {
    $video_file_mp4           = get_post_meta( get_the_ID(), 'haru_video' . '_file_mp4', true );
    $video_file_webm          = get_post_meta( get_the_ID(), 'haru_video' . '_file_webm', true );
} else {
    $video_server_url         = get_post_meta( get_the_ID(), 'haru_video' . '_url', true );
}

// Processe Membership
$user_access            = true;
$user_video_access      = true;
// $user_taxonomy_access   = true;
$user_category_access   = true;
$member_integrate       = haru_vidi_get_setting( 'vidi-member-settings', 'haru_member_integrate', 'off' );

if ( $member_integrate == 'on' ) {
    $member_plugin = haru_vidi_get_setting( 'vidi-member-settings', 'haru_member_plugin', 'pmpro' );

    // PaidMembershipsPro
    if ( $member_plugin == 'pmpro' ) {
        $page_levels            = haru_get_pmpro_page_meta();
        $user_levels            = pmpro_getMembershipLevelsForUser( get_current_user_id() );
        $user_video_access      = haru_get_pmpro_video_access( $page_levels, $user_levels );
        $member_settings_levels = haru_vidi_get_setting( 'vidi-member-settings', 'haru_member_pmpro_levels_group', '' );
        $user_levels            = pmpro_getMembershipLevelsForUser( get_current_user_id() );

        // Category required membership levels
        $category_levels        = haru_get_pmpro_category_levels();
        $user_category_access   = haru_get_pmpro_video_category_access( $category_levels, $user_levels );
        $pmpro_pages            = pmpro_get_pmpro_pages();

        if ( !empty( $page_levels ) ) {
            if ( ( $user_video_access == false ) ) {
                $user_access = false;
            }
        } else {
            if ( $user_category_access == false ) {
                $user_access = false;
            }
        }
        
        // @TODO: Check expired
        if ( is_user_logged_in() ) {
            $membership_level = pmpro_getMembershipLevelForUser( get_current_user_id() ); // pmpro_getMembershipLevelsForUser
            if ( isset( $membership_level ) && (int)$membership_level->enddate < time() ) {
                $user_access = false;
            }
        }
    }
    // Other
}

?>  
<div class="single-video-player">
    <div class="video-image player-direct">
        <div class="video-loading-icon">
            <div class="loading-bar"></div>
        </div>
        
        <?php if ( $user_access == true ) : ?>
        <div class="video-icon">
            <a href="javascript:;" 
                class="video-player-direct" 
                data-id="<?php echo esc_attr( get_the_ID() ); ?>" 
                data-video-id="<?php echo esc_attr( get_post_meta( get_the_ID(), 'haru_video' . '_id', true ) ); ?>"
                data-player="<?php echo esc_attr( $player_js ); ?>" 
                data-video-server="<?php echo esc_attr( $video_server ); ?>"
            >
            </a>
        </div>
        <?php endif; ?>
        
        <div class="player-wrapper">
            <div class="video-player">
                <?php
                    $single_video_thumbnail_size = haru_vidi_get_setting( 'vidi-thumbnail-settings', 'haru_video_thumbnail_single_size', 'ratio-169' );
                ?>
                <div class="media-wrapper <?php echo esc_attr( $single_video_thumbnail_size ); ?>" style="background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>); ">

                    <!-- Use Meberships -->
                    <?php if ( $user_access != true ) : ?>
                        <?php 
                            // Processe Membership
                            if ( $member_integrate == 'on' ) :
                                $member_plugin = haru_vidi_get_setting( 'vidi-member-settings', 'haru_member_plugin', 'pmpro' );

                                // PaidMembershipsPro
                                if ( $member_plugin == 'pmpro' ) :
                        ?>
                        <div class="pmpro-require-membership">
                            <div class="pmpro-require-content">
                                <!-- Page Levels -->
                                <?php if ( ( $user_video_access == false ) ) : ?>
                                    <h6 class="pmpro-require-message"><?php echo esc_html__( 'This content is for ', 'haru-vidi' ); ?>
                                        <?php foreach ( $page_levels as $level ) : ?>
                                            <?php if ( $level == end($page_levels) ) : ?>
                                            <span><?php echo esc_html( $level->name ); ?></span>
                                            <?php else : ?>
                                            <span><?php echo esc_html( $level->name ); ?><?php echo esc_html__( ' and', 'haru-vidi' ); ?></span>
                                            <?php endif; ?>   
                                        <?php endforeach; ?>
                                        <?php echo esc_html__( 'members only.', 'haru-vidi' ); ?>
                                    </h6>
                                <?php else : ?>
                                    <!-- Category Levels -->
                                    <?php if ( $user_category_access == false ) : ?>
                                        <h6 class="pmpro-require-message"><?php echo esc_html__( 'This content is for ', 'haru-vidi' ); ?>
                                        <?php foreach ( $category_levels as $category_level) : ?>
                                            <?php if ( $category_level == end($category_levels) ) : ?>
                                            <span><?php echo esc_html( pmpro_getLevel( $category_level )->name ); ?></span>
                                            <?php else : ?>
                                            <span><?php echo esc_html( pmpro_getLevel( $category_level )->name ); ?><?php echo esc_html__( ' and', 'haru-vidi' ); ?></span>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <?php echo esc_html__( 'members only.', 'haru-vidi' ); ?>
                                        </h6>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <!-- Subscription Expired -->
                                <?php
                                    if ( is_user_logged_in() ) :
                                        if ( (int)$membership_level->enddate < time() ) : 
                                ?>
                                <h6 class="pmpro-require-message"><?php echo esc_html__( 'Your Subcription has expired on ', 'haru-vidi' ) . date_i18n( get_option( 'date_format' ), $membership_level->enddate ); ?>
                                    <?php endif ?>
                                <?php endif ?>
                                   
                                <div class="pmpro-require-actions">
                                    <?php if ( !is_user_logged_in() ) : ?>
                                    <a href="<?php echo haru_get_url_of_page_with_id( $pmpro_pages['account'] ); ?>" class="pmpro-require-btn button-background button-background--primary button-background--medium" target="_blank"><?php echo esc_html__( 'Login', 'haru-vidi' ); ?></a>
                                    <?php endif; ?>
                                    
                                    <?php if ( isset( $membership_level ) && (int)$membership_level->enddate > time() ) : ?>
                                    <a href="<?php echo haru_get_url_of_page_with_id( $pmpro_pages['levels'] ); ?>" class="pmpro-require-btn button-background button-background--primary button-background--medium" target="_blank"><?php echo esc_html__( 'Renew Subcription', 'haru-vidi' ); ?></a>
                                    <?php else : ?>
                                    <a href="<?php echo haru_get_url_of_page_with_id( $pmpro_pages['levels'] ); ?>" class="pmpro-require-btn button-background button-background--primary button-background--medium" target="_blank"><?php echo esc_html__( 'Join Now', 'haru-vidi' ); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php 
                                endif;
                            endif;
                        ?>
                    <?php endif; ?>
                    
                    <?php if ( $video_server == 'youtube' ) : ?>
                        <?php if ( $video_autoplay != 'off' ) : ?>
                            <div class="video-youtube-unmute"><i class="haru-icon haru-volume-off"></i><?php echo esc_html__( 'Tap to Unmute', 'haru-vidi' ); ?></div>
                        <?php endif; ?>
                        <div id="youtube-video"></div>
                    <?php elseif ( $video_server == 'vimeo' ) : ?>
                        <div id="vimeo-video"></div>
                    <?php elseif ( $video_server == 'dailymotion' ) : // API Daily Motion: https://developer.dailymotion.com/player ?>
                        <div id="dailymotion-video"></div>
                    <?php elseif ( $video_server == 'twitch' ) : // API Twitch: https://dev.twitch.tv/docs/embed/ ?>
                        <div id="twitch-video"></div>
                    <?php elseif ( $video_server == 'facebook' ) : // API Facebook: https://developers.facebook.com/docs/plugins/embedded-video-player/ ?>
                        <script>
                            window.fbAsyncInit = function() {
                                FB.init({
                                    appId      : '633640254228672',
                                    xfbml      : true,
                                    version    : 'v3.2'
                                });
                            };
                        </script>
                        <div id="fb-root"></div>
                        <script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
                        <div id="facebook-video" 
                            class="fb-video" 
                            data-width="1920" 
                            data-height="1080" 
                            data-allowfullscreen="true"
                            data-href="<?php echo esc_url( $video_server_facebook_url ); ?>">
                        </div>
                    <?php elseif ( $video_server == 'google' ) : ?>
                        <?php if ( $video_autoplay != 'off' ) : ?>
                            <div class="video-mediaelement-unmute"><i class="haru-icon haru-volume-off"></i><?php echo esc_html__( 'Tap to Unmute', 'haru-vidi' ); ?></div>
                        <?php endif; ?>
                        <video id="video-player" width="640" height="360" style="max-width: 100%;" preload="none" controls playsinline webkit-playsinline>
                            <source src="<?php echo esc_url( $video_server_google_url ); ?>" type="video/mp4">
                        </video>
                    <?php elseif ( $video_server == 'selfhost' ) : ?>
                        <?php if ( $video_autoplay != 'off' ) : ?>
                            <div class="video-mediaelement-unmute"><i class="haru-icon haru-volume-off"></i><?php echo esc_html__( 'Tap to Unmute', 'haru-vidi' ); ?></div>
                        <?php endif; ?>
                        <video id="video-player" width="640" height="360" style="max-width: 100%; width: 100%; height: 100%" preload="none" controls playsinline webkit-playsinline>
                            <?php if ( $video_server_url_type == 'insert' ) : ?>
                                <?php if ( $video_server_url['mp4'] ) : ?>
                                    <source src="<?php echo esc_url( $video_server_url['mp4'] ); ?>" type="video/mp4">
                                <?php endif; ?>
                                <?php if ( $video_server_url['webm'] ) : ?>
                                    <source src="<?php echo esc_url( $video_server_url['webm'] ); ?>" type="video/webm">
                                <?php endif; ?>
                            <?php elseif ( $video_server_url_type == 'upload' ) : ?>
                                <?php if ( $video_server_url['mp4'] ) : ?>
                                    <source src="<?php echo esc_url( $video_file_mp4 ); ?>" type="video/mp4">
                                <?php endif; ?>
                                <?php if ( $video_server_url['webm'] ) : ?>    
                                    <source src="<?php echo esc_url( $video_file_webm ); ?>" type="video/webm">
                                <?php endif; ?>
                            <?php endif;?>
                        </video>
                    <?php elseif ( $video_server == 'embed' ) : ?>
                        <?php echo wp_kses( $video_server_embed, 'post' ); ?> 
                    <?php elseif ( $video_server == 'other' ) : ?>
                        <div id="other-video-player">
                        <?php echo do_shortcode( $video_server_other ); ?>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>

