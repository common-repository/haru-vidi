<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

?>
<div class="user-menu-shortcode <?php echo esc_attr( $layout . ' ' . $extra_class); ?>">
	<div class="user-account-wrap">
	    <?php if ( is_user_logged_in() ) : ?>
	        <div class="user-account-content logged-in">
	            <a href="javascript:;" class="header-icon">
	                <?php echo get_avatar( get_the_author_meta( 'ID', get_current_user_id() ), 45 ); ?>
	            </a>
	            <ul class="user-account-menu">
	                <?php 
	                    if ( class_exists( 'Haru_Vidi' ) ) : 
	                    	// My Content
		                    $haru_my_videos_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_my_video_page', '' );
		                    $haru_my_videos_page_url = ( $haru_my_videos_page != '' && is_numeric( $haru_my_videos_page ) ) ? get_permalink( $haru_my_videos_page ) :  get_permalink( get_page_by_path( 'my-videos' ) );
	                    	$haru_my_channels_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_my_channel_page', '' );
	                    	$haru_my_channels_page_url = ( $haru_my_channels_page != '' && is_numeric( $haru_my_channels_page ) ) ? get_permalink( $haru_my_channels_page ) :  get_permalink( get_page_by_path( 'my-channels' ) );
	                    	$haru_my_playlists_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_my_playlist_page', '' );
	                    	$haru_my_playlists_page_url = ( $haru_my_playlists_page != '' && is_numeric( $haru_my_playlists_page ) ) ? get_permalink( $haru_my_playlists_page ) :  get_permalink( get_page_by_path( 'my-playlists' ) );
	                    	$haru_my_seriess_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_my_series_page', '' );
	                    	$haru_my_seriess_page_url = ( $haru_my_seriess_page != '' && is_numeric( $haru_my_seriess_page ) ) ? get_permalink( $haru_my_seriess_page ) :  get_permalink( get_page_by_path( 'my-seriess' ) );

	                    	// Submit
	                    	$haru_submit_video_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_submit_video_page', '' );
		                    $haru_submit_video_page_url = ( $haru_submit_video_page != '' && is_numeric( $haru_submit_video_page ) ) ? get_permalink( $haru_submit_video_page ) :  get_permalink( get_page_by_path( 'submit-video' ) );
		                    $haru_submit_channel_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_submit_channel_page', '' );
		                    $haru_submit_channel_page_url = ( $haru_submit_channel_page != '' && is_numeric( $haru_submit_channel_page ) ) ? get_permalink( $haru_submit_channel_page ) :  get_permalink( get_page_by_path( 'submit-channel' ) );
		                    $haru_submit_playlist_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_submit_playlist_page', '' );
		                    $haru_submit_playlist_page_url = ( $haru_submit_playlist_page != '' && is_numeric( $haru_submit_playlist_page ) ) ? get_permalink( $haru_submit_playlist_page ) :  get_permalink( get_page_by_path( 'submit-playlist' ) );
		                    $haru_submit_series_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_submit_series_page', '' );
		                    $haru_submit_series_page_url = ( $haru_submit_series_page != '' && is_numeric( $haru_submit_series_page ) ) ? get_permalink( $haru_submit_series_page ) :  get_permalink( get_page_by_path( 'submit-series' ) );
	                ?>
	                	<?php
	                		// Processe Membership
		                	$member_integrate       = haru_vidi_get_setting( 'vidi-member-settings', 'haru_member_integrate', 'off' );

							if ( $member_integrate == 'on' ) :
						?>
						<li class="menu-item membership">
		                    <a href="<?php echo esc_url( haru_get_profile_url() ); ?>"><?php echo esc_html__( 'Membership', 'haru-vidi' ); ?></a>
		                    <ul class="sub-menu">
		                    	<?php
								    $member_plugin = haru_vidi_get_setting( 'vidi-member-settings', 'haru_member_plugin', 'pmpro' );

								    // PaidMembershipsPro
								    if ( $member_plugin == 'pmpro' ) :
								    	$pmpro_pages            = pmpro_get_pmpro_pages();
								?>
									<li><a href="<?php echo haru_get_url_of_page_with_id($pmpro_pages['account']); ?>"><?php echo esc_html__( 'Account', 'haru-vidi' ); ?></a></li>
									<li><a href="<?php echo haru_get_url_of_page_with_id($pmpro_pages['billing']); ?>"><?php echo esc_html__( 'Billing', 'haru-vidi' ); ?></a></li>
		                    	<?php endif; ?>
		                    </ul>
		                </li>
						<?php endif; ?>
	                	<li class="menu-item">
		                    <a href="<?php echo esc_url( haru_get_profile_url() ); ?>"><?php echo esc_html__( 'My Profile', 'haru-vidi' ); ?></a>
		                </li>
		                <?php
		                	$submit_allow = haru_vidi_get_setting( 'vidi-submit-settings', 'haru_submit_allow', 'off' );
        					if ( $submit_allow == 'on' ) :
		                ?>
		                <li class="menu-item">
		                    <a href="<?php echo esc_url( $haru_my_videos_page_url ); ?>"><?php echo esc_html__( 'My Videos', 'haru-vidi' ); ?></a>
		                </li>
		                <li class="menu-item">
		                    <a href="<?php echo esc_url( $haru_my_channels_page_url ); ?>"><?php echo esc_html__( 'My Channels', 'haru-vidi' ); ?></a>
		                </li>
		                <li class="menu-item">
		                    <a href="<?php echo esc_url( $haru_my_playlists_page_url ); ?>"><?php echo esc_html__( 'My Playlists', 'haru-vidi' ); ?></a>
		                </li>
		                <li class="menu-item">
		                    <a href="<?php echo esc_url( $haru_my_seriess_page_url ); ?>"><?php echo esc_html__( 'My Seriess', 'haru-vidi' ); ?></a>
		                </li>
		                <li class="menu-item">
		                    <a href="<?php echo esc_url( $haru_submit_video_page_url ); ?>"><?php echo esc_html__( 'Submit Video', 'haru-vidi' ); ?></a>
		                </li>
		                <li class="menu-item">
		                    <a href="<?php echo esc_url( $haru_submit_channel_page_url ); ?>"><?php echo esc_html__( 'Submit Channel', 'haru-vidi' ); ?></a>
		                </li>
		                <li class="menu-item">
		                    <a href="<?php echo esc_url( $haru_submit_playlist_page_url ); ?>"><?php echo esc_html__( 'Submit Playlist', 'haru-vidi' ); ?></a>
		                </li>
		                <li class="menu-item">
		                    <a href="<?php echo esc_url( $haru_submit_series_page_url ); ?>"><?php echo esc_html__( 'Submit Series', 'haru-vidi' ); ?></a>
		                </li>
		            	<?php endif; ?>
	                <?php endif; ?>
	                   
	                <li>
	                    <a href="<?php echo esc_url( haru_get_logout_redirect_url() ); ?>"><?php echo esc_html__( 'Logout', 'haru-vidi' ); ?></a>
	                </li>
	            </ul>
	        </div>
	    <?php else : ?>
	        <div class="user-account-content logged-out">
	            <a href="<?php echo esc_url( haru_get_login_url() ); ?>" class="user-menu-login"><i class="haru-icon haru-user"></i></a>
	        </div>
	    <?php endif; ?>
	</div>
</div>
