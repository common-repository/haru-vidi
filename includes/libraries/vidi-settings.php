<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function haru_vidi_register_main_options_metabox() {
	/**
	 * Registers main options page menu item and form.
	 */
	$args = array(
		'id'           => 'vidi_settings_page',
		'title'        => esc_html__( 'Vidi Settings', 'haru-vidi' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'vidi-general-settings',
		'tab_group'    => 'vidi-general-settings',
		'tab_title'    => esc_html__( 'General', 'haru-vidi' ),
	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'haru_vidi_options_display_with_tabs';
	}

	$general_options = new_cmb2_box( $args );

	/**
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */

	$general_options->add_field( array(
		'name' => esc_html__( 'Special Pages Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for some special pages', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'haru_special_pages_settings_title'
	) );

	$general_options->add_field( array(
	  	'name' 				=> esc_html__( 'Watch Later Page', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Set Page for Watch Later Videos.', 'haru-vidi' ),
	  	'id' 				=> 'haru_watch_later_page',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_page_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Set Watch Later Videos Page', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
		),
  	) );

  	$general_options->add_field( array(
	  	'name' 				=> esc_html__( 'My Videos Page', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Set Page for My Videos.', 'haru-vidi' ),
	  	'id' 				=> 'haru_my_video_page',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_page_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Set My Videos Page', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
		),
  	) );

  	$general_options->add_field( array(
	  	'name' 				=> esc_html__( 'Submit Video Page', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Set Page for Submit Video.', 'haru-vidi' ),
	  	'id' 				=> 'haru_submit_video_page',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_page_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Set Submit Video Page', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
		),
  	) );

  	$general_options->add_field( array(
	  	'name' 				=> esc_html__( 'My Channels Page', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Set Page for My Channels.', 'haru-vidi' ),
	  	'id' 				=> 'haru_my_channel_page',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_page_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Set My Channels Page', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
		),
  	) );

  	$general_options->add_field( array(
	  	'name' 				=> esc_html__( 'Submit Channel Page', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Set Page for Submit Channel.', 'haru-vidi' ),
	  	'id' 				=> 'haru_submit_channel_page',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_page_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Set Submit Channel Page', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
		),
  	) );

  	$general_options->add_field( array(
	  	'name' 				=> esc_html__( 'My Playlists Page', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Set Page for My Playlists.', 'haru-vidi' ),
	  	'id' 				=> 'haru_my_playlist_page',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_page_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Set My Playlists Page', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
		),
  	) );

  	$general_options->add_field( array(
	  	'name' 				=> esc_html__( 'Submit Playlist Page', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Set Page for Submit Playlist.', 'haru-vidi' ),
	  	'id' 				=> 'haru_submit_playlist_page',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_page_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Set Submit Playlist Page', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
		),
  	) );

  	$general_options->add_field( array(
	  	'name' 				=> esc_html__( 'My Series Page', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Set Page for My Series.', 'haru-vidi' ),
	  	'id' 				=> 'haru_my_series_page',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_page_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Set My Series Page', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
		),
  	) );

  	$general_options->add_field( array(
	  	'name' 				=> esc_html__( 'Submit Series Page', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Set Page for Submit Series.', 'haru-vidi' ),
	  	'id' 				=> 'haru_submit_series_page',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_page_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Set Submit Series Page', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
		),
  	) );

  	$general_options->add_field( array(
		'name' => esc_html__( 'Other Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for Others', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'vidi_others_settings_title'
	) );

  	$general_options->add_field( array(
  		'name'    => esc_html__( 'Social Sharing', 'haru-vidi' ),
		'desc'    => esc_html__( 'Enable Social Sharing for networks.', 'haru-vidi' ),
		'id'      => 'haru_social_sharing',
		'type'    => 'multicheck',
		'options' => array(
			'facebook' 	=> esc_html__( 'Facebook', 'haru-vidi' ),
			'twitter' 	=> esc_html__( 'Twitter', 'haru-vidi' ),
			'google' 	=> esc_html__( 'Google', 'haru-vidi' ),
			'linkedin' 	=> esc_html__( 'LinkedIn', 'haru-vidi' ),
			'tumblr' 	=> esc_html__( 'Tumblr', 'haru-vidi' ),
			'pinterest' => esc_html__( 'Pinterest', 'haru-vidi' ),
			'pinterest' => esc_html__( 'Pinterest', 'haru-vidi' ),
			'vk' 		=> esc_html__( 'VK', 'haru-vidi' ),
		),
	) );

    /**
	 * Registers Player options page, and set main item as parent.
	 */
	$args = array(
		'id'           => 'vidi_player_settings_page',
		'menu_title'   => esc_html__( 'Player', 'haru-vidi' ), // Use menu title, & not title to hide main h2.
		'title'        => esc_html__( 'Player Settings', 'haru-vidi' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'vidi-player-settings',
		'parent_slug'  => 'vidi-general-settings',
		'tab_group'    => 'vidi-general-settings',
		'tab_title'    => esc_html__( 'Player', 'haru-vidi' ),
	);

	$player_options = new_cmb2_box( $args );

	$player_options->add_field( array(
        'name'             => esc_html__( 'Video Player Autoplay', 'haru-vidi' ),
        'id'               => 'player_settings_autoplay',
        'desc'             => esc_html__( 'Allow Video Autoplay in single video page. Please note on Safari Autoplay video must be muted and video source from Facebook is not allowed Autoplay on mobile. Video Sefthost and Google muted when Enable Autoplay', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'off' // If it's checked by default
    ) );

  	$player_options->add_field( array(
        'name'             => esc_html__( 'Video Player Popup', 'haru-vidi' ),
        'id'               => 'player_settings_popup',
        'desc'             => esc_html__( 'This option in Develope Mode and doesn\'t work now. Play Video on Popup. Please note Ads don\'t support in popup and Popup not support Single Video page.', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'off' // If it's checked by default 
    ) );

    $player_options->add_field( array(
		'name'    => esc_html__( 'Video Player JS Library', 'haru-vidi' ),
		'desc'    => esc_html__( 'Set Player JS to play SelfHost, Google Drive video.', 'haru-vidi' ),
		'id'      => 'player_js',
		'type'    => 'select',
		'options' => array(
			'none' 			=> esc_html__( 'None', 'haru-vidi' ),
		),
		'default' => 'none',
	) );

	/**
	 * Registers secondary options page, and set main item as parent.
	 */
	$args = array(
		'id'           => 'vidi_videos_settings_page',
		'menu_title'   => esc_html__( 'Videos', 'haru-vidi' ), // Use menu title, & not title to hide main h2.
		'title'        => esc_html__( 'Videos Settings', 'haru-vidi' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'vidi-videos-settings',
		'parent_slug'  => 'vidi-general-settings',
		'tab_group'    => 'vidi-general-settings',
		'tab_title'    => esc_html__( 'Videos', 'haru-vidi' ),
	);

	$videos_options = new_cmb2_box( $args );

	$videos_options->add_field( array(
		'name' => esc_html__( 'Archive Videos Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for Archive Videos', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'archive_videos_settings_title'
	) );

	$videos_options->add_field( array(
        'name'             => esc_html__( 'Fullwidth', 'haru-vidi' ),
        'id'               => 'archive_videos_settings_layout_full',
        'desc'             => esc_html__( 'Set layout Fullwidth or use Container', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'no' //If it's checked by default 
    ) );

	$videos_options->add_field( array(
		'name'             => esc_html__( 'Archive Layout', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set layout for Archive Video page', 'haru-vidi' ),
		'id'               => 'archive_videos_settings_sidebar',
		'type'             => 'radio_image',
		'default'          => 'sidebar-none',
		'options'          => array(
			'sidebar-none'  => esc_html__( 'No Sidebar', 'haru-vidi' ),
			'sidebar-left'  => esc_html__( 'Left Sidebar', 'haru-vidi' ),
			'sidebar-right' => esc_html__( 'Right Sidebar', 'haru-vidi' ),
			'two-sidebar'   => esc_html__( 'Two Sidebar', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'sidebar-none'  => 'images/sidebar-none.png',
			'sidebar-left'  => 'images/sidebar-left.png',
			'sidebar-right' => 'images/sidebar-right.png',
			'two-sidebar'   => 'images/sidebar-two.png',
		),
	) );

    $videos_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Left', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'archive_videos_settings_sidebar_left',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Select sidebar Left for Archive Video', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => 'archive_videos_settings_sidebar',
			'data-conditional-value' => wp_json_encode( array( 'sidebar-left', 'two-sidebar' ) ),
		),
  	) );

  	$videos_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Right', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'archive_videos_settings_sidebar_right',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Select sidebar Right for Archive Video', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => 'archive_videos_settings_sidebar',
			'data-conditional-value' => wp_json_encode( array( 'sidebar-right', 'two-sidebar' ) ),
		),
  	) );

  	$videos_options->add_field( array(
        'name'    => esc_html__( 'Archive Columns', 'haru-vidi' ),
        'id'      => 'archive_videos_settings_columns',
        'type'    => 'pw_select',
        'desc'    => esc_html__( 'Archive Video Columns.', 'haru-vidi' ),
        'options' => array(
            '2'     => esc_html__( '2','haru-vidi' ),
            '3'     => esc_html__( '3','haru-vidi' ),
            '4'     => esc_html__( '4','haru-vidi' ),
            '5'     => esc_html__( '5','haru-vidi' ),
        ),
        'attributes'    => array(
            'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
            'required'               => true, // Will be required only if visible.
        ),
    ) );

  	$videos_options->add_field( array(
		'name'    => esc_html__( 'Number of videos per page', 'haru-vidi' ),
		'desc'    => esc_html__( 'If leave empty it will use setting in Settings -> General', 'haru-vidi' ),
		'default' => '',
		'id'      => 'archive_videos_settings_per_page',
		'type'    => 'text',
	) );

	$videos_options->add_field( array(
		'name'    => esc_html__( 'Paging Style', 'haru-vidi' ),
		'desc'    => esc_html__( 'Set paging style for Archive Video', 'haru-vidi' ),
		'id'      => 'archive_videos_settings_paging_style',
		'type'    => 'radio_inline',
		'options' => array(
			'default' 			=> esc_html__( 'Default Nav', 'haru-vidi' ),
			'load-more'   		=> esc_html__( 'Loadmore', 'haru-vidi' ),
			'infinite-scroll'   => esc_html__( 'Infinite Scroll', 'haru-vidi' ),
		),
		'default' => 'default',
	) );

	// Single settings
	$videos_options->add_field( array(
		'name' => esc_html__( 'Single Video Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for Single Video', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'single_video_settings_title'
	) );

	$videos_options->add_field( array(
        'name'             => esc_html__( 'Fullwidth', 'haru-vidi' ),
        'id'               => 'single_video_settings_layout_full',
        'desc'             => esc_html__( 'Set layout Fullwidth or use Container', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'no' // If it's checked by default 
    ) );

	$videos_options->add_field( array(
		'name'             => esc_html__( 'Single Layout', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set layout for Single Video page', 'haru-vidi' ),
		'id'               => 'single_video_settings_sidebar',
		'type'             => 'radio_image',
		'default'          => 'sidebar-none',
		'options'          => array(
			'sidebar-none'  => esc_html__( 'No Sidebar', 'haru-vidi' ),
			'sidebar-left'  => esc_html__( 'Left Sidebar', 'haru-vidi' ),
			'sidebar-right' => esc_html__( 'Right Sidebar', 'haru-vidi' ),
			'two-sidebar'   => esc_html__( 'Two Sidebar', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'sidebar-none'  => 'images/sidebar-none.png',
			'sidebar-left'  => 'images/sidebar-left.png',
			'sidebar-right' => 'images/sidebar-right.png',
			'two-sidebar'   => 'images/sidebar-two.png',
		),
	) );

	$videos_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Left', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'single_video_settings_sidebar_left',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 				=> esc_html__( 'Select sidebar Left for Single Video', 'haru-vidi' ),
			'required'               	=> true, // Will be required only if visible.
			'data-conditional-id'    	=> 'single_video_settings_sidebar',
			'data-conditional-value' 	=> wp_json_encode( array( 'sidebar-left', 'two-sidebar' ) ),
		),
  	) );

  	$videos_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Right', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'single_video_settings_sidebar_right',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 				=> esc_html__( 'Select sidebar Right for Single Video', 'haru-vidi' ),
			'required'               	=> true, // Will be required only if visible.
			'data-conditional-id'    	=> 'single_video_settings_sidebar',
			'data-conditional-value' 	=> wp_json_encode( array( 'sidebar-right', 'two-sidebar' ) ),
		),
  	) );

	$videos_options->add_field( array(
		'name'             => esc_html__( 'Single Style', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set Style for Single Video page', 'haru-vidi' ),
		'id'               => 'single_video_settings_style',
		'type'             => 'radio_image',
		'options'          => array(
			'single-style-1'    	=> esc_html__( 'Style 1', 'haru-vidi' ),
			'single-style-2'    	=> esc_html__( 'Style 2', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'single-style-1'    	=> 'images/video-single-style-1.png',
			'single-style-2'    	=> 'images/video-single-style-2.png',
		),
		'default'          => 'single-style-1'
	) );

	/**             
	 * Registers tertiary options page, and set main item as parent.
	 */
	$args = array(
		'id'           => 'vidi_playlists_settings_page',
		'menu_title'   => esc_html__( 'Playlists', 'haru-vidi' ), // Use menu title, & not title to hide main h2.
		'title'        => esc_html__( 'Playlists Settings', 'haru-vidi' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'vidi-playlists-settings',
		'parent_slug'  => 'vidi-general-settings',
		'tab_group'    => 'vidi-general-settings',
		'tab_title'    => esc_html__( 'Playlists', 'haru-vidi' ),
	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'haru_vidi_options_display_with_tabs';
	}

	$playlist_options = new_cmb2_box( $args );

	$playlist_options->add_field( array(
		'name' => esc_html__( 'Archive Playlists Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for Archive Playlists', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'archive_playlists_settings_title'
	) );

	$playlist_options->add_field( array(
        'name'             => esc_html__( 'Fullwidth', 'haru-vidi' ),
        'id'               => 'archive_playlists_settings_layout_full',
        'desc'             => esc_html__( 'Set layout Fullwidth or use Container', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'no' // If it's checked by default 
    ) );

	$playlist_options->add_field( array(
		'name'             => esc_html__( 'Archive Layout', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set layout for Archive Playlist page', 'haru-vidi' ),
		'id'               => 'archive_playlists_settings_sidebar',
		'type'             => 'radio_image',
		'default'          => 'sidebar-none',
		'options'          => array(
			'sidebar-none'  => esc_html__( 'No Sidebar', 'haru-vidi' ),
			'sidebar-left'  => esc_html__( 'Left Sidebar', 'haru-vidi' ),
			'sidebar-right' => esc_html__( 'Right Sidebar', 'haru-vidi' ),
			'two-sidebar'   => esc_html__( 'Two Sidebar', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'sidebar-none'  => 'images/sidebar-none.png',
			'sidebar-left'  => 'images/sidebar-left.png',
			'sidebar-right' => 'images/sidebar-right.png',
			'two-sidebar'   => 'images/sidebar-two.png',
		),
	) );

    $playlist_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Left', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'archive_playlists_settings_sidebar_left',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Select sidebar Left for Archive Playlist', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => 'archive_playlists_settings_sidebar',
			'data-conditional-value' => wp_json_encode( array( 'sidebar-left', 'two-sidebar' ) ),
		),
  	) );

  	$playlist_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Right', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'archive_playlists_settings_sidebar_right',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Select sidebar Right for Archive Playlist', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => 'archive_playlists_settings_sidebar',
			'data-conditional-value' => wp_json_encode( array( 'sidebar-right', 'two-sidebar' ) ),
		),
  	) );

  	$playlist_options->add_field( array(
        'name'    => esc_html__( 'Archive Columns', 'haru-vidi' ),
        'id'      => 'archive_playlists_settings_columns',
        'type'    => 'pw_select',
        'desc'    => esc_html__( 'Archive Playlist Columns.', 'haru-vidi' ),
        'options' => array(
            '2'     => esc_html__( '2','haru-vidi' ),
            '3'     => esc_html__( '3','haru-vidi' ),
            '4'     => esc_html__( '4','haru-vidi' ),
            '5'     => esc_html__( '5','haru-vidi' ),
        ),
        'attributes'    => array(
            'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
            'required'               => true, // Will be required only if visible.
        ),
    ) );

  	$playlist_options->add_field( array(
		'name'    => esc_html__( 'Number of playlists per page', 'haru-vidi' ),
		'desc'    => esc_html__( 'If leave empty it will use setting in Settings -> General', 'haru-vidi' ),
		'default' => '',
		'id'      => 'archive_playlists_settings_per_page',
		'type'    => 'text',
	) );

	$playlist_options->add_field( array(
		'name'    => esc_html__( 'Paging Style', 'haru-vidi' ),
		'desc'    => esc_html__( 'Set paging style for Archive Playlist', 'haru-vidi' ),
		'id'      => 'archive_playlists_settings_paging_style',
		'type'    => 'radio_inline',
		'options' => array(
			'default' 			=> esc_html__( 'Default Nav', 'haru-vidi' ),
			'load-more'   		=> esc_html__( 'Loadmore', 'haru-vidi' ),
			'infinite-scroll'   => esc_html__( 'Infinite Scroll', 'haru-vidi' ),
		),
		'default' => 'default',
	) );

	// Single settings
	$playlist_options->add_field( array(
		'name' => esc_html__( 'Single Playlist Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for Single Playlist', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'single_playlist_settings_title'
	) );

	$playlist_options->add_field( array(
        'name'             => esc_html__( 'Fullwidth', 'haru-vidi' ),
        'id'               => 'single_playlist_settings_layout_full',
        'desc'             => esc_html__( 'Set layout Fullwidth or use Container', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'no' // If it's checked by default 
    ) );

	$playlist_options->add_field( array(
		'name'             => esc_html__( 'Single Layout', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set layout for Single Playlist page', 'haru-vidi' ),
		'id'               => 'single_playlist_settings_sidebar',
		'type'             => 'radio_image',
		'default'          => 'sidebar-none',
		'options'          => array(
			'sidebar-none'  => esc_html__( 'No Sidebar', 'haru-vidi' ),
			'sidebar-left'  => esc_html__( 'Left Sidebar', 'haru-vidi' ),
			'sidebar-right' => esc_html__( 'Right Sidebar', 'haru-vidi' ),
			'two-sidebar'   => esc_html__( 'Two Sidebar', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'sidebar-none'  => 'images/sidebar-none.png',
			'sidebar-left'  => 'images/sidebar-left.png',
			'sidebar-right' => 'images/sidebar-right.png',
			'two-sidebar'   => 'images/sidebar-two.png',
		),
	) );

	$playlist_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Left', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'single_playlist_settings_sidebar_left',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 				=> esc_html__( 'Select sidebar Left for Single Playlist', 'haru-vidi' ),
			'required'               	=> true, // Will be required only if visible.
			'data-conditional-id'    	=> 'single_playlist_settings_sidebar',
			'data-conditional-value' 	=> wp_json_encode( array( 'sidebar-left', 'two-sidebar' ) ),
		),
  	) );

  	$playlist_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Right', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'single_playlist_settings_sidebar_right',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 				=> esc_html__( 'Select sidebar Right for Single Playlist', 'haru-vidi' ),
			'required'               	=> true, // Will be required only if visible.
			'data-conditional-id'    	=> 'single_playlist_settings_sidebar',
			'data-conditional-value' 	=> wp_json_encode( array( 'sidebar-right', 'two-sidebar' ) ),
		),
  	) );

	$playlist_options->add_field( array(
		'name'             => esc_html__( 'Single Style', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set Style for Single Playlist page', 'haru-vidi' ),
		'id'               => 'single_playlist_settings_style',
		'type'             => 'radio_image',
		'options'          => array(
			'style-1'    	=> esc_html__( 'Style 1', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'style-1'    	=> 'images/sidebar-none.png',
		),
		'default'          => 'style-1'
	) );

	/**             
	 * Registers fourth options page, and set main item as parent.
	 */
	$args = array(
		'id'           => 'vidi_seriess_settings_page',
		'menu_title'   => esc_html__( 'Series', 'haru-vidi' ), // Use menu title, & not title to hide main h2.
		'title'        => esc_html__( 'Series Settings', 'haru-vidi' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'vidi-seriess-settings',
		'parent_slug'  => 'vidi-general-settings',
		'tab_group'    => 'vidi-general-settings',
		'tab_title'    => esc_html__( 'Series', 'haru-vidi' ),
	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'haru_vidi_options_display_with_tabs';
	}

	$series_options = new_cmb2_box( $args );

	$series_options->add_field( array(
		'name' => esc_html__( 'Archive Series Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for Archive Series', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'archive_seriess_settings_title'
	) );

	$series_options->add_field( array(
        'name'             => esc_html__( 'Fullwidth', 'haru-vidi' ),
        'id'               => 'archive_seriess_settings_layout_full',
        'desc'             => esc_html__( 'Set layout Fullwidth or use Container', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'no' // If it's checked by default 
    ) );

	$series_options->add_field( array(
		'name'             => esc_html__( 'Archive Layout', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set layout for Archive Series page', 'haru-vidi' ),
		'id'               => 'archive_seriess_settings_sidebar',
		'type'             => 'radio_image',
		'default'          => 'sidebar-none',
		'options'          => array(
			'sidebar-none'  => esc_html__( 'No Sidebar', 'haru-vidi' ),
			'sidebar-left'  => esc_html__( 'Left Sidebar', 'haru-vidi' ),
			'sidebar-right' => esc_html__( 'Right Sidebar', 'haru-vidi' ),
			'two-sidebar'   => esc_html__( 'Two Sidebar', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'sidebar-none'  => 'images/sidebar-none.png',
			'sidebar-left'  => 'images/sidebar-left.png',
			'sidebar-right' => 'images/sidebar-right.png',
			'two-sidebar'   => 'images/sidebar-two.png',
		),
	) );

    $series_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Left', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'archive_seriess_settings_sidebar_left',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Select sidebar Left for Archive Series', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => 'archive_seriess_settings_sidebar',
			'data-conditional-value' => wp_json_encode( array( 'sidebar-left', 'two-sidebar' ) ),
		),
  	) );

  	$series_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Right', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'archive_seriess_settings_sidebar_right',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Select sidebar Right for Archive Series', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => 'archive_seriess_settings_sidebar',
			'data-conditional-value' => wp_json_encode( array( 'sidebar-right', 'two-sidebar' ) ),
		),
  	) );

  	$series_options->add_field( array(
        'name'    => esc_html__( 'Archive Columns', 'haru-vidi' ),
        'id'      => 'archive_seriess_settings_columns',
        'type'    => 'pw_select',
        'desc'    => esc_html__( 'Archive Series Columns.', 'haru-vidi' ),
        'options' => array(
            '2'     => esc_html__( '2','haru-vidi' ),
            '3'     => esc_html__( '3','haru-vidi' ),
            '4'     => esc_html__( '4','haru-vidi' ),
            '5'     => esc_html__( '5','haru-vidi' ),
        ),
        'attributes'    => array(
            'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
            'required'               => true, // Will be required only if visible.
        ),
    ) );

  	$series_options->add_field( array(
		'name'    => esc_html__( 'Number of seriess per page', 'haru-vidi' ),
		'desc'    => esc_html__( 'If leave empty it will use setting in Settings -> General', 'haru-vidi' ),
		'default' => '',
		'id'      => 'archive_seriess_settings_per_page',
		'type'    => 'text',
	) );

	$series_options->add_field( array(
		'name'    => esc_html__( 'Paging Style', 'haru-vidi' ),
		'desc'    => esc_html__( 'Set paging style for Archive Series', 'haru-vidi' ),
		'id'      => 'archive_seriess_settings_paging_style',
		'type'    => 'radio_inline',
		'options' => array(
			'default' 			=> esc_html__( 'Default Nav', 'haru-vidi' ),
			'load-more'   		=> esc_html__( 'Loadmore', 'haru-vidi' ),
			'infinite-scroll'   => esc_html__( 'Infinite Scroll', 'haru-vidi' ),
		),
		'default' => 'default',
	) );

	// Single settings
	$series_options->add_field( array(
		'name' => esc_html__( 'Single Series Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for Single Series', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'single_series_settings_title'
	) );

	$series_options->add_field( array(
        'name'             => esc_html__( 'Fullwidth', 'haru-vidi' ),
        'id'               => 'single_series_settings_layout_full',
        'desc'             => esc_html__( 'Set layout Fullwidth or use Container', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'no' // If it's checked by default 
    ) );

	$series_options->add_field( array(
		'name'             => esc_html__( 'Single Layout', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set layout for Single Series page', 'haru-vidi' ),
		'id'               => 'single_series_settings_sidebar',
		'type'             => 'radio_image',
		'default'          => 'sidebar-none',
		'options'          => array(
			'sidebar-none'  => esc_html__( 'No Sidebar', 'haru-vidi' ),
			'sidebar-left'  => esc_html__( 'Left Sidebar', 'haru-vidi' ),
			'sidebar-right' => esc_html__( 'Right Sidebar', 'haru-vidi' ),
			'two-sidebar'   => esc_html__( 'Two Sidebar', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'sidebar-none'  => 'images/sidebar-none.png',
			'sidebar-left'  => 'images/sidebar-left.png',
			'sidebar-right' => 'images/sidebar-right.png',
			'two-sidebar'   => 'images/sidebar-two.png',
		),
	) );

	$series_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Left', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'single_series_settings_sidebar_left',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 				=> esc_html__( 'Select sidebar Left for Single Series', 'haru-vidi' ),
			'required'               	=> true, // Will be required only if visible.
			'data-conditional-id'    	=> 'single_series_settings_sidebar',
			'data-conditional-value' 	=> wp_json_encode( array( 'sidebar-left', 'two-sidebar' ) ),
		),
  	) );

  	$series_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Right', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'single_series_settings_sidebar_right',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 				=> esc_html__( 'Select sidebar Right for Single Series', 'haru-vidi' ),
			'required'               	=> true, // Will be required only if visible.
			'data-conditional-id'    	=> 'single_series_settings_sidebar',
			'data-conditional-value' 	=> wp_json_encode( array( 'sidebar-right', 'two-sidebar' ) ),
		),
  	) );

	$series_options->add_field( array(
		'name'             => esc_html__( 'Single Style', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set Style for Single Series page', 'haru-vidi' ),
		'id'               => 'single_series_settings_style',
		'type'             => 'radio_image',
		'options'          => array(
			'style-1'    	=> esc_html__( 'Style 1', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'style-1'    	=> 'images/sidebar-none.png',
		),
		'default'          => 'style-1'
	) );

	/**             
	 * Registers 5th options page, and set main item as parent.
	 */
	$args = array(
		'id'           => 'vidi_channels_settings_page',
		'menu_title'   => esc_html__( 'Channels', 'haru-vidi' ), // Use menu title, & not title to hide main h2.
		'title'        => esc_html__( 'Channels Settings', 'haru-vidi' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'vidi-channels-settings',
		'parent_slug'  => 'vidi-general-settings',
		'tab_group'    => 'vidi-general-settings',
		'tab_title'    => esc_html__( 'Channels', 'haru-vidi' ),
	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'haru_vidi_options_display_with_tabs';
	}

	$channel_options = new_cmb2_box( $args );

	$channel_options->add_field( array(
		'name' => esc_html__( 'Archive Channels Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for Archive Channels', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'archive_channels_settings_title'
	) );

	$channel_options->add_field( array(
        'name'             => esc_html__( 'Fullwidth', 'haru-vidi' ),
        'id'               => 'archive_channels_settings_layout_full',
        'desc'             => esc_html__( 'Set layout Fullwidth or use Container', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'no' // If it's checked by default 
    ) );

	$channel_options->add_field( array(
		'name'             => esc_html__( 'Archive Layout', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set layout for Archive Channel page', 'haru-vidi' ),
		'id'               => 'archive_channels_settings_sidebar',
		'type'             => 'radio_image',
		'default'          => 'sidebar-none',
		'options'          => array(
			'sidebar-none'  => esc_html__( 'No Sidebar', 'haru-vidi' ),
			'sidebar-left'  => esc_html__( 'Left Sidebar', 'haru-vidi' ),
			'sidebar-right' => esc_html__( 'Right Sidebar', 'haru-vidi' ),
			'two-sidebar'   => esc_html__( 'Two Sidebar', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'sidebar-none'  => 'images/sidebar-none.png',
			'sidebar-left'  => 'images/sidebar-left.png',
			'sidebar-right' => 'images/sidebar-right.png',
			'two-sidebar'   => 'images/sidebar-two.png',
		),
	) );

    $channel_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Left', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'archive_channels_settings_sidebar_left',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Select sidebar Left for Archive Channel', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => 'archive_channels_settings_sidebar',
			'data-conditional-value' => wp_json_encode( array( 'sidebar-left', 'two-sidebar' ) ),
		),
  	) );

  	$channel_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Right', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'archive_channels_settings_sidebar_right',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Select sidebar Right for Archive Channel', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => 'archive_channels_settings_sidebar',
			'data-conditional-value' => wp_json_encode( array( 'sidebar-right', 'two-sidebar' ) ),
		),
  	) );

  	$channel_options->add_field( array(
        'name'    => esc_html__( 'Archive Columns', 'haru-vidi' ),
        'id'      => 'archive_channels_settings_columns',
        'type'    => 'pw_select',
        'desc'    => esc_html__( 'Archive Channel Columns.', 'haru-vidi' ),
        'options' => array(
            '2'     => esc_html__( '2','haru-vidi' ),
            '3'     => esc_html__( '3','haru-vidi' ),
            '4'     => esc_html__( '4','haru-vidi' ),
            '5'     => esc_html__( '5','haru-vidi' ),
        ),
        'attributes'    => array(
            'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
            'required'               => true, // Will be required only if visible.
        ),
    ) );

  	$channel_options->add_field( array(
		'name'    => esc_html__( 'Number of channels per page', 'haru-vidi' ),
		'desc'    => esc_html__( 'If leave empty it will use setting in Settings -> General', 'haru-vidi' ),
		'default' => '',
		'id'      => 'archive_channels_settings_per_page',
		'type'    => 'text',
	) );

	$channel_options->add_field( array(
		'name'    => esc_html__( 'Paging Style', 'haru-vidi' ),
		'desc'    => esc_html__( 'Set paging style for Archive Channel', 'haru-vidi' ),
		'id'      => 'archive_channels_settings_paging_style',
		'type'    => 'radio_inline',
		'options' => array(
			'default' 			=> esc_html__( 'Default Nav', 'haru-vidi' ),
			'load-more'   		=> esc_html__( 'Loadmore', 'haru-vidi' ),
			'infinite-scroll'   => esc_html__( 'Infinite Scroll', 'haru-vidi' ),
		),
		'default' => 'default',
	) );

	// Single settings
	$channel_options->add_field( array(
		'name' => esc_html__( 'Single Channel Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for Single Channel', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'single_channel_settings_title'
	) );

	$channel_options->add_field( array(
        'name'             => esc_html__( 'Fullwidth', 'haru-vidi' ),
        'id'               => 'single_channel_settings_layout_full',
        'desc'             => esc_html__( 'Set layout Fullwidth or use Container', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'no' // If it's checked by default 
    ) );

	$channel_options->add_field( array(
		'name'             => esc_html__( 'Single Layout', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set layout for Single Channel page', 'haru-vidi' ),
		'id'               => 'single_channel_settings_sidebar',
		'type'             => 'radio_image',
		'default'          => 'sidebar-none',
		'options'          => array(
			'sidebar-none'  => esc_html__( 'No Sidebar', 'haru-vidi' ),
			'sidebar-left'  => esc_html__( 'Left Sidebar', 'haru-vidi' ),
			'sidebar-right' => esc_html__( 'Right Sidebar', 'haru-vidi' ),
			'two-sidebar'   => esc_html__( 'Two Sidebar', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'sidebar-none'  => 'images/sidebar-none.png',
			'sidebar-left'  => 'images/sidebar-left.png',
			'sidebar-right' => 'images/sidebar-right.png',
			'two-sidebar'   => 'images/sidebar-two.png',
		),
	) );

	$channel_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Left', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'single_channel_settings_sidebar_left',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 				=> esc_html__( 'Select sidebar Left for Single Channel', 'haru-vidi' ),
			'required'               	=> true, // Will be required only if visible.
			'data-conditional-id'    	=> 'single_channel_settings_sidebar',
			'data-conditional-value' 	=> wp_json_encode( array( 'sidebar-left', 'two-sidebar' ) ),
		),
  	) );

  	$channel_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Right', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'single_channel_settings_sidebar_right',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 				=> esc_html__( 'Select sidebar Right for Single Channel', 'haru-vidi' ),
			'required'               	=> true, // Will be required only if visible.
			'data-conditional-id'    	=> 'single_channel_settings_sidebar',
			'data-conditional-value' 	=> wp_json_encode( array( 'sidebar-right', 'two-sidebar' ) ),
		),
  	) );

	$channel_options->add_field( array(
		'name'             => esc_html__( 'Single Style', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set Style for Single Channel page', 'haru-vidi' ),
		'id'               => 'single_channel_settings_style',
		'type'             => 'radio_image',
		'options'          => array(
			'style-1'    	=> esc_html__( 'Style 1', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'style-1'    	=> 'images/sidebar-none.png',
		),
		'default'          => 'style-1'
	) );

	/**             
	 * Registers actor options page, and set main item as parent.
	 */
	$args = array(
		'id'           => 'vidi_actors_settings_page',
		'menu_title'   => esc_html__( 'Actors', 'haru-vidi' ), // Use menu title, & not title to hide main h2.
		'title'        => esc_html__( 'Actors Settings', 'haru-vidi' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'vidi-actors-settings',
		'parent_slug'  => 'vidi-general-settings',
		'tab_group'    => 'vidi-general-settings',
		'tab_title'    => esc_html__( 'Actors', 'haru-vidi' ),
	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'haru_vidi_options_display_with_tabs';
	}

	$actor_options = new_cmb2_box( $args );

	$actor_options->add_field( array(
		'name' => esc_html__( 'Archive Actors Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for Archive Actors', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'archive_actors_settings_title'
	) );

	$actor_options->add_field( array(
        'name'             => esc_html__( 'Fullwidth', 'haru-vidi' ),
        'id'               => 'archive_actors_settings_layout_full',
        'desc'             => esc_html__( 'Set layout Fullwidth or use Container', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'no' // If it's checked by default 
    ) );

	$actor_options->add_field( array(
		'name'             => esc_html__( 'Archive Layout', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set layout for Archive Actor page', 'haru-vidi' ),
		'id'               => 'archive_actors_settings_sidebar',
		'type'             => 'radio_image',
		'default'          => 'sidebar-none',
		'options'          => array(
			'sidebar-none'  => esc_html__( 'No Sidebar', 'haru-vidi' ),
			'sidebar-left'  => esc_html__( 'Left Sidebar', 'haru-vidi' ),
			'sidebar-right' => esc_html__( 'Right Sidebar', 'haru-vidi' ),
			'two-sidebar'   => esc_html__( 'Two Sidebar', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'sidebar-none'  => 'images/sidebar-none.png',
			'sidebar-left'  => 'images/sidebar-left.png',
			'sidebar-right' => 'images/sidebar-right.png',
			'two-sidebar'   => 'images/sidebar-two.png',
		),
	) );

    $actor_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Left', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'archive_actors_settings_sidebar_left',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Select sidebar Left for Archive Actor', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => 'archive_actors_settings_sidebar',
			'data-conditional-value' => wp_json_encode( array( 'sidebar-left', 'two-sidebar' ) ),
		),
  	) );

  	$actor_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Right', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'archive_actors_settings_sidebar_right',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Select sidebar Right for Archive Actor', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => 'archive_actors_settings_sidebar',
			'data-conditional-value' => wp_json_encode( array( 'sidebar-right', 'two-sidebar' ) ),
		),
  	) );

  	$actor_options->add_field( array(
        'name'    => esc_html__( 'Archive Columns', 'haru-vidi' ),
        'id'      => 'archive_actors_settings_columns',
        'type'    => 'pw_select',
        'desc'    => esc_html__( 'Archive Actor Columns.', 'haru-vidi' ),
        'options' => array(
            '2'     => esc_html__( '2','haru-vidi' ),
            '3'     => esc_html__( '3','haru-vidi' ),
            '4'     => esc_html__( '4','haru-vidi' ),
            '5'     => esc_html__( '5','haru-vidi' ),
        ),
        'attributes'    => array(
            'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
            'required'               => true, // Will be required only if visible.
        ),
    ) );

  	$actor_options->add_field( array(
		'name'    => esc_html__( 'Number of actors per page', 'haru-vidi' ),
		'desc'    => esc_html__( 'If leave empty it will use setting in Settings -> General', 'haru-vidi' ),
		'default' => '',
		'id'      => 'archive_actors_settings_per_page',
		'type'    => 'text',
	) );

	$actor_options->add_field( array(
		'name'    => esc_html__( 'Paging Style', 'haru-vidi' ),
		'desc'    => esc_html__( 'Set paging style for Archive Actor', 'haru-vidi' ),
		'id'      => 'archive_actors_settings_paging_style',
		'type'    => 'radio_inline',
		'options' => array(
			'default' 			=> esc_html__( 'Default Nav', 'haru-vidi' ),
			'load-more'   		=> esc_html__( 'Loadmore', 'haru-vidi' ),
			'infinite-scroll'   => esc_html__( 'Infinite Scroll', 'haru-vidi' ),
		),
		'default' => 'default',
	) );

	// Single settings
	$actor_options->add_field( array(
		'name' => esc_html__( 'Single Actor Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for Single Actor', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'single_actor_settings_title'
	) );

	$actor_options->add_field( array(
        'name'             => esc_html__( 'Fullwidth', 'haru-vidi' ),
        'id'               => 'single_actor_settings_layout_full',
        'desc'             => esc_html__( 'Set layout Fullwidth or use Container', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'no' // If it's checked by default 
    ) );

	$actor_options->add_field( array(
		'name'             => esc_html__( 'Single Layout', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set layout for Single Actor page', 'haru-vidi' ),
		'id'               => 'single_actor_settings_sidebar',
		'type'             => 'radio_image',
		'default'          => 'sidebar-none',
		'options'          => array(
			'sidebar-none'  => esc_html__( 'No Sidebar', 'haru-vidi' ),
			'sidebar-left'  => esc_html__( 'Left Sidebar', 'haru-vidi' ),
			'sidebar-right' => esc_html__( 'Right Sidebar', 'haru-vidi' ),
			'two-sidebar'   => esc_html__( 'Two Sidebar', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'sidebar-none'  => 'images/sidebar-none.png',
			'sidebar-left'  => 'images/sidebar-left.png',
			'sidebar-right' => 'images/sidebar-right.png',
			'two-sidebar'   => 'images/sidebar-two.png',
		),
	) );

	$actor_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Left', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'single_actor_settings_sidebar_left',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 				=> esc_html__( 'Select sidebar Left for Single Actor', 'haru-vidi' ),
			'required'               	=> true, // Will be required only if visible.
			'data-conditional-id'    	=> 'single_actor_settings_sidebar',
			'data-conditional-value' 	=> wp_json_encode( array( 'sidebar-left', 'two-sidebar' ) ),
		),
  	) );

  	$actor_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Right', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'single_actor_settings_sidebar_right',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 				=> esc_html__( 'Select sidebar Right for Single Actor', 'haru-vidi' ),
			'required'               	=> true, // Will be required only if visible.
			'data-conditional-id'    	=> 'single_actor_settings_sidebar',
			'data-conditional-value' 	=> wp_json_encode( array( 'sidebar-right', 'two-sidebar' ) ),
		),
  	) );

	$actor_options->add_field( array(
		'name'             => esc_html__( 'Single Style', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set Style for Single Actor page', 'haru-vidi' ),
		'id'               => 'single_actor_settings_style',
		'type'             => 'radio_image',
		'options'          => array(
			'style-1'    	=> esc_html__( 'Style 1', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'style-1'    	=> 'images/sidebar-none.png',
		),
		'default'          => 'style-1'
	) );

	/**             
	 * Registers actor options page, and set main item as parent.
	 */
	$args = array(
		'id'           => 'vidi_directors_settings_page',
		'menu_title'   => esc_html__( 'Directors', 'haru-vidi' ), // Use menu title, & not title to hide main h2.
		'title'        => esc_html__( 'Directors Settings', 'haru-vidi' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'vidi-directors-settings',
		'parent_slug'  => 'vidi-general-settings',
		'tab_group'    => 'vidi-general-settings',
		'tab_title'    => esc_html__( 'Directors', 'haru-vidi' ),
	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'haru_vidi_options_display_with_tabs';
	}

	$director_options = new_cmb2_box( $args );

	$director_options->add_field( array(
		'name' => esc_html__( 'Archive Directors Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for Archive Directors', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'archive_directors_settings_title'
	) );

	$director_options->add_field( array(
        'name'             => esc_html__( 'Fullwidth', 'haru-vidi' ),
        'id'               => 'archive_directors_settings_layout_full',
        'desc'             => esc_html__( 'Set layout Fullwidth or use Container', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'no' // If it's checked by default 
    ) );

	$director_options->add_field( array(
		'name'             => esc_html__( 'Archive Layout', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set layout for Archive Director page', 'haru-vidi' ),
		'id'               => 'archive_directors_settings_sidebar',
		'type'             => 'radio_image',
		'default'          => 'sidebar-none',
		'options'          => array(
			'sidebar-none'  => esc_html__( 'No Sidebar', 'haru-vidi' ),
			'sidebar-left'  => esc_html__( 'Left Sidebar', 'haru-vidi' ),
			'sidebar-right' => esc_html__( 'Right Sidebar', 'haru-vidi' ),
			'two-sidebar'   => esc_html__( 'Two Sidebar', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'sidebar-none'  => 'images/sidebar-none.png',
			'sidebar-left'  => 'images/sidebar-left.png',
			'sidebar-right' => 'images/sidebar-right.png',
			'two-sidebar'   => 'images/sidebar-two.png',
		),
	) );

    $director_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Left', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'archive_directors_settings_sidebar_left',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Select sidebar Left for Archive Director', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => 'archive_directors_settings_sidebar',
			'data-conditional-value' => wp_json_encode( array( 'sidebar-left', 'two-sidebar' ) ),
		),
  	) );

  	$director_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Right', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'archive_directors_settings_sidebar_right',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 			=> esc_html__( 'Select sidebar Right for Archive Director', 'haru-vidi' ),
			'required'               => true, // Will be required only if visible.
			'data-conditional-id'    => 'archive_directors_settings_sidebar',
			'data-conditional-value' => wp_json_encode( array( 'sidebar-right', 'two-sidebar' ) ),
		),
  	) );

  	$director_options->add_field( array(
        'name'    => esc_html__( 'Archive Columns', 'haru-vidi' ),
        'id'      => 'archive_directors_settings_columns',
        'type'    => 'pw_select',
        'desc'    => esc_html__( 'Archive Director Columns.', 'haru-vidi' ),
        'options' => array(
            '2'     => esc_html__( '2','haru-vidi' ),
            '3'     => esc_html__( '3','haru-vidi' ),
            '4'     => esc_html__( '4','haru-vidi' ),
            '5'     => esc_html__( '5','haru-vidi' ),
        ),
        'attributes'    => array(
            'placeholder'            => esc_html__( 'Choose Columns', 'haru-vidi'),
            'required'               => true, // Will be required only if visible.
        ),
    ) );

  	$director_options->add_field( array(
		'name'    => esc_html__( 'Number of directors per page', 'haru-vidi' ),
		'desc'    => esc_html__( 'If leave empty it will use setting in Settings -> General', 'haru-vidi' ),
		'default' => '',
		'id'      => 'archive_directors_settings_per_page',
		'type'    => 'text',
	) );

	$director_options->add_field( array(
		'name'    => esc_html__( 'Paging Style', 'haru-vidi' ),
		'desc'    => esc_html__( 'Set paging style for Archive Director', 'haru-vidi' ),
		'id'      => 'archive_directors_settings_paging_style',
		'type'    => 'radio_inline',
		'options' => array(
			'default' 			=> esc_html__( 'Default Nav', 'haru-vidi' ),
			'load-more'   		=> esc_html__( 'Loadmore', 'haru-vidi' ),
			'infinite-scroll'   => esc_html__( 'Infinite Scroll', 'haru-vidi' ),
		),
		'default' => 'default',
	) );

	// Single settings
	$director_options->add_field( array(
		'name' => esc_html__( 'Single Director Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for Single Director', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'single_director_settings_title'
	) );

	$director_options->add_field( array(
        'name'             => esc_html__( 'Fullwidth', 'haru-vidi' ),
        'id'               => 'single_director_settings_layout_full',
        'desc'             => esc_html__( 'Set layout Fullwidth or use Container', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'no' // If it's checked by default 
    ) );

	$director_options->add_field( array(
		'name'             => esc_html__( 'Single Layout', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set layout for Single Director page', 'haru-vidi' ),
		'id'               => 'single_director_settings_sidebar',
		'type'             => 'radio_image',
		'default'          => 'sidebar-none',
		'options'          => array(
			'sidebar-none'  => esc_html__( 'No Sidebar', 'haru-vidi' ),
			'sidebar-left'  => esc_html__( 'Left Sidebar', 'haru-vidi' ),
			'sidebar-right' => esc_html__( 'Right Sidebar', 'haru-vidi' ),
			'two-sidebar'   => esc_html__( 'Two Sidebar', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'sidebar-none'  => 'images/sidebar-none.png',
			'sidebar-left'  => 'images/sidebar-left.png',
			'sidebar-right' => 'images/sidebar-right.png',
			'two-sidebar'   => 'images/sidebar-two.png',
		),
	) );

	$director_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Left', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'single_director_settings_sidebar_left',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 				=> esc_html__( 'Select sidebar Left for Single Director', 'haru-vidi' ),
			'required'               	=> true, // Will be required only if visible.
			'data-conditional-id'    	=> 'single_director_settings_sidebar',
			'data-conditional-value' 	=> wp_json_encode( array( 'sidebar-left', 'two-sidebar' ) ),
		),
  	) );

  	$director_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Right', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'single_director_settings_sidebar_right',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 				=> esc_html__( 'Select sidebar Right for Single Director', 'haru-vidi' ),
			'required'               	=> true, // Will be required only if visible.
			'data-conditional-id'    	=> 'single_director_settings_sidebar',
			'data-conditional-value' 	=> wp_json_encode( array( 'sidebar-right', 'two-sidebar' ) ),
		),
  	) );

	$director_options->add_field( array(
		'name'             => esc_html__( 'Single Style', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set Style for Single Director page', 'haru-vidi' ),
		'id'               => 'single_director_settings_style',
		'type'             => 'radio_image',
		'options'          => array(
			'style-1'    	=> esc_html__( 'Style 1', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'style-1'    	=> 'images/sidebar-none.png',
		),
		'default'          => 'style-1'
	) );

	/**             
	 * Registers 6th options page, and set main item as parent.
	 */
	$args = array(
		'id'           => 'vidi_authors_settings_page',
		'menu_title'   => esc_html__( 'Authors', 'haru-vidi' ), // Use menu title, & not title to hide main h2.
		'title'        => esc_html__( 'Authors Settings', 'haru-vidi' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'vidi-authors-settings',
		'parent_slug'  => 'vidi-general-settings',
		'tab_group'    => 'vidi-general-settings',
		'tab_title'    => esc_html__( 'Authors', 'haru-vidi' ),
	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'haru_vidi_options_display_with_tabs';
	}

	$author_options = new_cmb2_box( $args );

	// Single settings
	$author_options->add_field( array(
		'name' => esc_html__( 'Single Author Settings', 'haru-vidi' ),
		'desc' => esc_html__( 'Settings display for Single Author. If you installed and actived BuddyPress plugin, author will be auto redirect to Member Profile page.', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'single_author_settings_title'
	) );

	$author_options->add_field( array(
        'name'             => esc_html__( 'Fullwidth', 'haru-vidi' ),
        'id'               => 'single_author_settings_layout_full',
        'desc'             => esc_html__( 'Set layout Fullwidth or use Container', 'haru-vidi' ),
        'type'	           => 'switch',
        'default'          => 'no' // If it's checked by default 
    ) );

	$author_options->add_field( array(
		'name'             => esc_html__( 'Single Layout', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set layout for Single Author page', 'haru-vidi' ),
		'id'               => 'single_author_settings_sidebar',
		'type'             => 'radio_image',
		'default'          => 'sidebar-none',
		'options'          => array(
			'sidebar-none'  => esc_html__( 'No Sidebar', 'haru-vidi' ),
			'sidebar-left'  => esc_html__( 'Left Sidebar', 'haru-vidi' ),
			'sidebar-right' => esc_html__( 'Right Sidebar', 'haru-vidi' ),
			'two-sidebar'   => esc_html__( 'Two Sidebar', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'sidebar-none'  => 'images/sidebar-none.png',
			'sidebar-left'  => 'images/sidebar-left.png',
			'sidebar-right' => 'images/sidebar-right.png',
			'two-sidebar'   => 'images/sidebar-two.png',
		),
	) );

	$author_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Left', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'single_author_settings_sidebar_left',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 				=> esc_html__( 'Select sidebar Left for Single Author', 'haru-vidi' ),
			'required'               	=> true, // Will be required only if visible.
			'data-conditional-id'    	=> 'single_author_settings_sidebar',
			'data-conditional-value' 	=> wp_json_encode( array( 'sidebar-left', 'two-sidebar' ) ),
		),
  	) );

  	$author_options->add_field( array(
	  	'name' 				=> esc_html__( 'Sidebar Right', 'haru-vidi' ),
	  	'desc' 				=> esc_html__( 'Select a sidebar to display if use layout have sidebar', 'haru-vidi' ),
	  	'id' 				=> 'single_author_settings_sidebar_right',
	  	'type'             	=> 'pw_select',
		'options_cb' 		=> 'haru_vidi_get_sidebar_list_options',
		'attributes' => array(
			'placeholder' 				=> esc_html__( 'Select sidebar Right for Single Author', 'haru-vidi' ),
			'required'               	=> true, // Will be required only if visible.
			'data-conditional-id'    	=> 'single_author_settings_sidebar',
			'data-conditional-value' 	=> wp_json_encode( array( 'sidebar-right', 'two-sidebar' ) ),
		),
  	) );

	$author_options->add_field( array(
		'name'             => esc_html__( 'Single Style', 'haru-vidi' ),
		'desc'             => esc_html__( 'Set Style for Single Author page', 'haru-vidi' ),
		'id'               => 'single_author_settings_style',
		'type'             => 'radio_image',
		'options'          => array(
			'style-1'    	=> esc_html__( 'Style 1', 'haru-vidi' ),
		),
		'images_path'      => plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/'),
		'images'           => array(
			'style-1'    	=> 'images/sidebar-none.png',
		),
		'default'          => 'style-1'
	) );

    /**             
	 * Registers 9th options page, and set main item as parent.
	 */
	$args = array(
		'id'           => 'vidi_thumbnail_settings_page',
		'menu_title'   => esc_html__( 'Thumbnail', 'haru-vidi' ), // Use menu title, & not title to hide main h2.
		'title'        => esc_html__( 'Thumbnail Settings', 'haru-vidi' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'vidi-thumbnail-settings',
		'parent_slug'  => 'vidi-general-settings',
		'tab_group'    => 'vidi-general-settings',
		'tab_title'    => esc_html__( 'Thumbnail', 'haru-vidi' ),
	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'haru_vidi_options_display_with_tabs';
	}

	$thumbnail_options = new_cmb2_box( $args );

	$thumbnail_options->add_field( array(
		'name' => esc_html__( 'Video Thumbnail', 'haru-vidi' ),
		'desc' => esc_html__( 'Video Thumbnail settings.', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'haru_video_thumbnail_title'
	) );

	$thumbnail_options->add_field( array(
        'id'      => 'haru_video_thumbnail' . '_type',
        'name'    => esc_html__( 'Video Thumbnail Type', 'haru-vidi'),
        'type'    => 'pw_select',
        'default' => 'image',
        'options' => array(
            'image'         => esc_html__( 'Default (Image)', 'haru-vidi' ),
            'slideshow'     => esc_html__( 'Slideshow', 'haru-vidi' ),
        ),
    ) );

    $thumbnail_options->add_field( array(
        'id'      => 'haru_video_thumbnail' . '_size',
        'name'    => esc_html__( 'Video Thumbnail Size', 'haru-vidi'),
        'type'    => 'pw_select',
        'default' => 'default',
        'options' => array(
            'default'      => esc_html__( 'Default', 'haru-vidi' ),
            'ratio-169'    => esc_html__( 'Ratio 16:9', 'haru-vidi' ),
            'ratio-43'     => esc_html__( 'Ratio 4:3', 'haru-vidi' ),
        ),
    ) );

    $thumbnail_options->add_field( array(
        'id'      => 'haru_video_thumbnail' . '_single_size',
        'name'    => esc_html__( 'Single Video Thumbnail Size', 'haru-vidi'),
        'type'    => 'pw_select',
        'default' => 'ratio-169',
        'options' => array(
        	'ratio-169'    => esc_html__( 'Ratio 16:9', 'haru-vidi' ),
        ),
    ) );

    /**             
	 * Registers 10th options page, and set main item as parent.
	 */
	$args = array(
		'id'           => 'vidi_appearance_settings_page',
		'menu_title'   => esc_html__( 'Appearance', 'haru-vidi' ), // Use menu title, & not title to hide main h2.
		'title'        => esc_html__( 'Appearance Settings', 'haru-vidi' ),
		'object_types' => array( 'options-page' ),
		'option_key'   => 'vidi-appearance-settings',
		'parent_slug'  => 'vidi-general-settings',
		'tab_group'    => 'vidi-general-settings',
		'tab_title'    => esc_html__( 'Appearance', 'haru-vidi' ),
	);

	// 'tab_group' property is supported in > 2.4.0.
	if ( version_compare( CMB2_VERSION, '2.4.0' ) ) {
		$args['display_cb'] = 'haru_vidi_options_display_with_tabs';
	}

	$appearance_options = new_cmb2_box( $args );

	$appearance_options->add_field( array(
		'name' => esc_html__( 'Color', 'haru-vidi' ),
		'desc' => esc_html__( 'Color settings. Please note our plugin will generate new css file in: wp-content/plugins/haru-vidi/assets/css/style-custom.css. If it doesn\'t work you need check your server to allow it.', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'haru_color_title'
	) );

	$appearance_options->add_field( array(
        'id'      => 'haru_color' . '_primary',
        'name'    => esc_html__( 'Primary Color', 'haru-vidi'),
        'type'    => 'colorpicker',
        'default' => '#fe2854',
    ) );

    $appearance_options->add_field( array(
        'id'      => 'haru_color' . '_heading',
        'name'    => esc_html__( 'Heading Color', 'haru-vidi'),
        'type'    => 'colorpicker',
        'default' => '#2c272d',
    ) );

    $appearance_options->add_field( array(
        'id'      => 'haru_color' . '_text',
        'name'    => esc_html__( 'Text Color', 'haru-vidi'),
        'type'    => 'colorpicker',
        'default' => '#6d5f6f',
    ) );

    $appearance_options->add_field( array(
        'id'      => 'haru_color' . '_text_secondary',
        'name'    => esc_html__( 'Text Color Secondary', 'haru-vidi'),
        'type'    => 'colorpicker',
        'default' => '#aba4ac',
    ) );

    $appearance_options->add_field( array(
        'id'      => 'haru_color' . '_border',
        'name'    => esc_html__( 'Border Color', 'haru-vidi'),
        'type'    => 'colorpicker',
        'default' => '#ededed',
    ) );

    $appearance_options->add_field( array(
        'id'      => 'haru_color' . '_black',
        'name'    => esc_html__( 'Black Color', 'haru-vidi'),
        'type'    => 'colorpicker',
        'default' => '#1a051d',
        'desc' => esc_html__( 'Use for some Heading,...', 'haru-vidi' ),
    ) );

    $appearance_options->add_field( array(
        'id'      => 'haru_color' . '_gray',
        'name'    => esc_html__( 'Gray Color', 'haru-vidi'),
        'type'    => 'colorpicker',
        'default' => '#6d5f6f',
        'desc' => esc_html__( 'Use for some Button,...', 'haru-vidi' ),
    ) );

    $appearance_options->add_field( array(
		'name' => esc_html__( 'Other', 'haru-vidi' ),
		'desc' => esc_html__( 'Other appearance settings.', 'haru-vidi' ),
		'type' => 'title',
		'id'   => 'haru_other_title'
	) );

	$appearance_options->add_field( array(
        'id'            => 'haru_scss' . '_border_radius',
        'name'          => esc_html__( 'Border Radius', 'haru-vidi'),
        'type'          => 'text_small',
        'default'       => '4px',
        'desc' 			=> esc_html__( 'Example: 4px', 'haru-vidi' ),
    ) );

    $appearance_options->add_field( array(
        'id'            => 'haru_scss' . '_border_radius_small',
        'name'          => esc_html__( 'Border Radius Small', 'haru-vidi'),
        'type'          => 'text_small',
        'default'       => '3px',
        'desc' 			=> esc_html__( 'Example: 3px', 'haru-vidi' ),
    ) );

    $appearance_options->add_field( array(
        'id'            => 'haru_scss' . '_border_radius_tiny',
        'name'          => esc_html__( 'Border Radius Tiny', 'haru-vidi'),
        'type'          => 'text_small',
        'default'       => '2px',
        'desc' 			=> esc_html__( 'Example: 2px', 'haru-vidi' ),
    ) );
}
add_action( 'cmb2_admin_init', 'haru_vidi_register_main_options_metabox' );

/**
 * A CMB2 options-page display callback override which adds tab navigation among
 * CMB2 options pages which share this same display callback.
 *
 * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
 */
function haru_vidi_options_display_with_tabs( $cmb_options ) {
	$tabs = haru_vidi_options_page_tabs( $cmb_options );
	?>
	<div class="wrap cmb2-options-page option-<?php echo $cmb_options->option_key; ?>">
		<?php if ( get_admin_page_title() ) : ?>
			<h2><?php echo wp_kses_post( get_admin_page_title() ); ?></h2>
		<?php endif; ?>
		<h2 class="nav-tab-wrapper">
			<?php foreach ( $tabs as $option_key => $tab_title ) : ?>
				<a class="nav-tab<?php if ( isset( $_GET['page'] ) && $option_key === $_GET['page'] ) : ?> nav-tab-active<?php endif; ?>" href="<?php menu_page_url( $option_key ); ?>"><?php echo wp_kses_post( $tab_title ); ?></a>
			<?php endforeach; ?>
		</h2>
		<form class="cmb-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="POST" id="<?php echo $cmb_options->cmb->cmb_id; ?>" enctype="multipart/form-data" encoding="multipart/form-data">
			<input type="hidden" name="action" value="<?php echo esc_attr( $cmb_options->option_key ); ?>">
			<?php $cmb_options->options_page_metabox(); ?>
			<?php submit_button( esc_attr( $cmb_options->cmb->prop( 'save_button' ) ), 'primary', 'submit-cmb' ); ?>
		</form>
	</div>
	<?php
}

/**
 * Gets navigation tabs array for CMB2 options pages which share the given
 * display_cb param.
 *
 * @param CMB2_Options_Hookup $cmb_options The CMB2_Options_Hookup object.
 *
 * @return array Array of tab information.
 */
function haru_vidi_options_page_tabs( $cmb_options ) {
	$tab_group = $cmb_options->cmb->prop( 'tab_group' );
	$tabs      = array();

	foreach ( CMB2_Boxes::get_all() as $cmb_id => $cmb ) {
		if ( $tab_group === $cmb->prop( 'tab_group' ) ) {
			$tabs[ $cmb->options_page_keys()[0] ] = $cmb->prop( 'tab_title' )
				? $cmb->prop( 'tab_title' )
				: $cmb->prop( 'title' );
		}
	}

	return $tabs;
}