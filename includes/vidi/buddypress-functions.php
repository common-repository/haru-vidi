<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// https://gist.github.com/shanebp/5d3d2f298727a0a036e5
// https://rtmedia.io/docs/developers/add-remove-buddypress-tabs/
function haru_profile_tab_videos() {
    global $bp;

    // Videos
    bp_core_new_nav_item( array( 
        'name'                  => esc_html__( 'Videos', 'haru-vidi' ), 
        'slug'                  => 'video',
        'parent_url'            => $bp->displayed_user->domain,
        'parent_slug'           => $bp->profile->slug,
        'screen_function'       => 'haru_video_screen', 
        'position'              => 10,
        'default_subnav_slug'   => 'all'
    ) );

    bp_core_new_subnav_item( array(
        'name'              => esc_html__( 'All Videos', 'haru-vidi' ),
        'slug'              => 'all',
        'parent_url'        => $bp->displayed_user->domain . 'video/',
        'parent_slug'       => 'video',
        'screen_function'   => 'haru_video_screen',
        'position'          => 10,
    ) );

    // Playlist
    bp_core_new_nav_item( array( 
        'name'                  => esc_html__( 'Playlists', 'haru-vidi' ), 
        'slug'                  => 'playlist',
        'parent_url'            => $bp->displayed_user->domain,
        'parent_slug'           => $bp->profile->slug,
        'screen_function'       => 'haru_playlist_screen', 
        'position'              => 10,
        'default_subnav_slug'   => 'all'
    ) );

    bp_core_new_subnav_item( array(
        'name'              => esc_html__( 'All Playlists', 'haru-vidi' ),
        'slug'              => 'all',
        'parent_url'        => $bp->displayed_user->domain . 'playlist/',
        'parent_slug'       => 'playlist',
        'screen_function'   => 'haru_playlist_screen',
        'position'          => 10,
    ) );

    // Series
    bp_core_new_nav_item( array( 
        'name'                  => esc_html__( 'Series', 'haru-vidi' ), 
        'slug'                  => 'series',
        'parent_url'            => $bp->displayed_user->domain . 'series/',
        'parent_slug'           => $bp->profile->slug,
        'screen_function'       => 'haru_series_screen', 
        'position'              => 10,
        'default_subnav_slug'   => 'all'
    ) );

    bp_core_new_subnav_item( array(
        'name'              => esc_html__( 'All Series', 'haru-vidi' ),
        'slug'              => 'all',
        'parent_url'        => $bp->displayed_user->domain . 'series/',
        'parent_slug'       => 'series',
        'screen_function'   => 'haru_series_screen',
        'position'          => 10,
    ) );

    // Channel
    bp_core_new_nav_item( array( 
        'name'                  => esc_html__( 'Channels', 'haru-vidi' ), 
        'slug'                  => 'channel',
        'parent_url'            => $bp->displayed_user->domain . 'channel/',
        'parent_slug'           => $bp->profile->slug,
        'screen_function'       => 'haru_channel_screen', 
        'position'              => 10,
        'default_subnav_slug'   => 'all'
    ) );

    bp_core_new_subnav_item( array(
        'name'              => esc_html__( 'All Channels', 'haru-vidi' ),
        'slug'              => 'all',
        'parent_url'        => $bp->displayed_user->domain . 'channel/',
        'parent_slug'       => 'channel',
        'screen_function'   => 'haru_channel_screen',
        'position'          => 10,
    ) );
}
add_action( 'bp_setup_nav', 'haru_profile_tab_videos' );

// Videos
function haru_video_screen() {
    // Add title and content here - last is to call the members plugin.php template.
    add_action( 'bp_template_title', 'haru_video_title' );
    add_action( 'bp_template_content', 'haru_video_content' );
    bp_core_load_template( 'buddypress/members/single/plugins' );
}

function haru_video_title() {
    echo esc_html__( '', 'haru-vidi' );
}

function haru_video_content() {
    global $wp_query;

    $original_query     = $wp_query;
    $current_member_id  = bp_displayed_user_id();

    $args = array(
        'post_type'             => 'haru_video',
        'posts_per_page'        => 6,
        'post_status'           => 'publish',
        'author'                => $current_member_id,
    );

    $wp_query = new WP_Query($args);

    wp_enqueue_script( 'imagesloaded' );
    wp_enqueue_script( 'isotope', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/isotope.pkgd.min.js'), array( 'jquery' ), '', true );
    wp_enqueue_script( 'packery-mode', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/packery-mode.pkgd.min.js'), array( 'jquery' ), '', true );
    ?>
    <div class="haru-archive-top">
        <div class="haru-archive-top-left">
            <h6 class="archive-video__title"><?php echo esc_html__( 'Has total', 'haru-vidi' ); ?>
                <span class="archive-video__total-count"><?php echo esc_html( $wp_query->found_posts ) . esc_html__( ' videos', 'haru-vidi' ); ?></span>
            </h6>
        </div>
        <div class="haru-archive-top-right">
            <div class="haru-archive-layout-toggle">
                <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
            </div>
        </div>
    </div>
    <?php if ( have_posts() ) : ?>
    <div class="bd-tab-videos layout-wrap style-grid grid-columns grid-columns__3">
        <?php
            while ( have_posts() ) : the_post();
                echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array(), '', '');
            endwhile;
        ?>
    </div>
    <?php else : ?>
        <h6 class="bp-no-item"><?php echo esc_html__( 'This user haven\'t created any videos yet!' ); ?></h6>
    <?php endif; ?>
    <?php echo haru_bp_paging_load_more_video(); ?>

    <?php
    wp_reset_query();
    $wp_query = $original_query;
}

/* BuddyPress Load More Video */
if ( !function_exists('haru_bp_paging_load_more_video') ) {
    function haru_bp_paging_load_more_video() {
        global $wp_query;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        ?>
        <div class="bd-pagination-cpt">
            <button 
                type="button"
                data-current_page="1"
                data-max_page="<?php echo esc_attr( $wp_query->max_num_pages ); ?>"
                data-posts_per_page="6"
                class="bp-video-load-more"
            ><i class="haru-icon haru-spinner haru-spin loading-icon"></i>
                <?php echo esc_html__( 'Load More', 'haru-vidi' ); ?>
            </button>
        </div>
        <?php
    }
}

add_action( 'wp_ajax_haru_bp_get_video', 'haru_bp_get_video' );
add_action( 'wp_ajax_nopriv_haru_bp_get_video', 'haru_bp_get_video' );

if ( !function_exists( 'haru_bp_get_video' ) ) {
    function haru_bp_get_video() {
        if ( empty($_POST['current_page']) || empty( $_POST['max_page'] ) ) {
            die('0');
        }

        $current_page       = (int)$_POST['current_page'];
        $max_page           = (int)$_POST['max_page'];
        $posts_per_page     = (int)$_POST['posts_per_page'];
        $current_member_id  = bp_displayed_user_id();

        ob_start();

        $offset = $current_page * $posts_per_page;

        $args = array(
            'post_type'             => 'haru_video',
            'posts_per_page'        => $posts_per_page,
            'offset'                => $offset,
            'post_status'           => 'publish',
            'author'                => $current_member_id,
        );
        
        $videos = new WP_Query( $args );
        ?>
        
        <div class="video-list grid-columns grid-columns__3 animated fadeIn haru-clear">
            <?php
                if ( $videos->have_posts() ) {
                    while ( $videos->have_posts() ) { 
                        $videos->the_post();
                        echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array(), '', '');
                    }
                }
            ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Playlists
function haru_playlist_screen() {
    // Add title and content here - last is to call the members plugin.php template.
    add_action( 'bp_template_title', 'haru_playlist_title' );
    add_action( 'bp_template_content', 'haru_playlist_content' );
    bp_core_load_template( 'buddypress/members/single/plugins' );
}
function haru_playlist_title() {
    echo esc_html__( '', 'haru-vidi' );
}

function haru_playlist_content() {
    global $wp_query;

    $original_query     = $wp_query;
    $current_member_id  = bp_displayed_user_id();

    $args = array(
        'post_type'             => 'haru_playlist',
        'posts_per_page'        => 6,
        'post_status'           => 'publish',
        'author'                => $current_member_id,
    );

    $wp_query = new WP_Query($args);

    wp_enqueue_script( 'imagesloaded' );
    wp_enqueue_script( 'isotope', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/isotope.pkgd.min.js'), array( 'jquery' ), '', true );
    wp_enqueue_script( 'packery-mode', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/packery-mode.pkgd.min.js'), array( 'jquery' ), '', true );
    ?>
    <div class="haru-archive-top">
        <div class="haru-archive-top-left">
            <h6 class="archive-video__title"><?php echo esc_html__( 'Has total', 'haru-vidi' ); ?>
                <span class="archive-video__total-count"><?php echo esc_html( $wp_query->found_posts ) . esc_html__( ' playlists', 'haru-vidi' ); ?></span>
            </h6>
        </div>
        <div class="haru-archive-top-right">
            <div class="haru-archive-layout-toggle">
                <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
            </div>
        </div>
    </div>
    <?php if ( have_posts() ) : ?>
    <div class="bd-tab-playlists layout-wrap style-grid grid-columns grid-columns__3">
        <?php
            while ( have_posts() ) : the_post();
                echo haru_vidi_get_shortcode_template('vidi/playlist/'. 'content-playlist' . '.php', array(), '', '');
            endwhile;
        ?>
    </div>
    <?php else : ?>
        <h6 class="bp-no-item"><?php echo esc_html__( 'This user haven\'t created any playlists yet!' ); ?></h6>
    <?php endif; ?>
    <?php echo haru_bp_paging_load_more_playlist(); ?>

    <?php
    wp_reset_query();
    $wp_query = $original_query;
}

/* BuddyPress Load More Playlist */
if ( !function_exists('haru_bp_paging_load_more_playlist') ) {
    function haru_bp_paging_load_more_playlist() {
        global $wp_query;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        ?>
        <div class="bd-pagination-cpt">
            <button 
                type="button"
                data-current_page="1"
                data-max_page="<?php echo esc_attr( $wp_query->max_num_pages ); ?>"
                data-posts_per_page="1"
                class="bp-playlist-load-more"
            ><i class="haru-icon haru-spinner haru-spin loading-icon"></i>
                <?php echo esc_html__( 'Load More', 'haru-vidi' ); ?>
            </button>
        </div>
        <?php
    }
}

add_action( 'wp_ajax_haru_bp_get_playlist', 'haru_bp_get_playlist' );
add_action( 'wp_ajax_nopriv_haru_bp_get_playlist', 'haru_bp_get_playlist' );

if ( !function_exists( 'haru_bp_get_playlist' ) ) {
    function haru_bp_get_playlist() {
        if ( empty($_POST['current_page'] ) || empty( $_POST['max_page'] ) ) {
            die('0');
        }

        $current_page       = (int)$_POST['current_page'];
        $max_page           = (int)$_POST['max_page'];
        $posts_per_page     = (int)$_POST['posts_per_page'];
        $current_member_id  = bp_displayed_user_id();

        ob_start();

        $offset = $current_page * $posts_per_page;

        $args = array(
            'post_type'             => 'haru_playlist',
            'posts_per_page'        => $posts_per_page,
            'offset'                => $offset,
            'post_status'           => 'publish',
            'author'                => $current_member_id,
        );
        
        $playlists = new WP_Query( $args );
        ?>

        <div class="playlist-list grid-columns grid-columns__3 animated fadeIn haru-clear">
            <?php
                if ( $playlists->have_posts() ) {
                    while ( $playlists->have_posts() ) { 
                        $playlists->the_post();
                        echo haru_vidi_get_shortcode_template('vidi/playlist/'. 'content-playlist' . '.php', array(), '', '');
                    }
                }
            ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Series
function haru_series_screen() {
    // Add title and content here - last is to call the members plugin.php template.
    add_action( 'bp_template_title', 'haru_series_title' );
    add_action( 'bp_template_content', 'haru_series_content' );
    bp_core_load_template( 'buddypress/members/single/plugins' );
}
function haru_series_title() {
    echo esc_html__( '', 'haru-vidi' );
}

function haru_series_content() {
    global $wp_query;

    $original_query     = $wp_query;
    $current_member_id  = bp_displayed_user_id();

    $args = array(
        'post_type'             => 'haru_series',
        'posts_per_page'        => 6,
        'post_status'           => 'publish',
        'author'                => $current_member_id,
    );

    $wp_query = new WP_Query($args);

    wp_enqueue_script( 'imagesloaded' );
    wp_enqueue_script( 'isotope', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/isotope.pkgd.min.js'), array( 'jquery' ), '', true );
    wp_enqueue_script( 'packery-mode', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/packery-mode.pkgd.min.js'), array( 'jquery' ), '', true );
    ?>
    <div class="haru-archive-top">
        <div class="haru-archive-top-left">
            <h6 class="archive-video__title"><?php echo esc_html__( 'Has total', 'haru-vidi' ); ?>
                <span class="archive-video__total-count"><?php echo esc_html( $wp_query->found_posts ) . esc_html__( ' series', 'haru-vidi' ); ?></span>
            </h6>
        </div>
        <div class="haru-archive-top-right">
            <div class="haru-archive-layout-toggle">
                <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
            </div>
        </div>
    </div>
    <?php if ( have_posts() ) : ?>
    <div class="bd-tab-seriess layout-wrap style-grid grid-columns grid-columns__3">
        <?php
            while ( have_posts() ) : the_post();
                echo haru_vidi_get_shortcode_template('vidi/series/'. 'content-series' . '.php', array(), '', '');
            endwhile;
        ?>
    </div>
    <?php else : ?>
        <h6 class="bp-no-item"><?php echo esc_html__( 'This user haven\'t created any seriess yet!' ); ?></h6>
    <?php endif; ?>
    <?php echo haru_bp_paging_load_more_series(); ?>

    <?php
    wp_reset_query();
    $wp_query = $original_query;
}

/* BuddyPress Load More Series */
if ( !function_exists('haru_bp_paging_load_more_series') ) {
    function haru_bp_paging_load_more_series() {
        global $wp_query;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        ?>
        <div class="bd-pagination-cpt">
            <button 
                type="button"
                data-current_page="1"
                data-max_page="<?php echo esc_attr( $wp_query->max_num_pages ); ?>"
                data-posts_per_page="1"
                class="bp-series-load-more"
            ><i class="haru-icon haru-spinner haru-spin loading-icon"></i>
                <?php echo esc_html__( 'Load More', 'haru-vidi' ); ?>
            </button>
        </div>
        <?php
    }
}

add_action( 'wp_ajax_haru_bp_get_series', 'haru_bp_get_series' );
add_action( 'wp_ajax_nopriv_haru_bp_get_series', 'haru_bp_get_series' );

if ( !function_exists( 'haru_bp_get_series' ) ) {
    function haru_bp_get_series() {
        if ( empty($_POST['current_page']) || empty( $_POST['max_page'] ) ) {
            die('0');
        }

        $current_page       = (int)$_POST['current_page'];
        $max_page           = (int)$_POST['max_page'];
        $posts_per_page     = (int)$_POST['posts_per_page'];
        $current_member_id  = bp_displayed_user_id();

        ob_start();

        $offset = $current_page * $posts_per_page;

        $args = array(
            'post_type'             => 'haru_series',
            'posts_per_page'        => $posts_per_page,
            'offset'                => $offset,
            'post_status'           => 'publish',
            'author'                => $current_member_id,
        );
        
        $seriess = new WP_Query( $args );
        ?>

        <div class="series-list grid-columns grid-columns__3 animated fadeIn haru-clear">
            <?php
                if ( $seriess->have_posts() ) {
                    while ( $seriess->have_posts() ) { 
                        $seriess->the_post();
                        echo haru_vidi_get_shortcode_template('vidi/series/'. 'content-series' . '.php', array(), '', '');
                    }
                }
            ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Channels
function haru_channel_screen() {
    // Add title and content here - last is to call the members plugin.php template.
    add_action( 'bp_template_title', 'haru_channel_title' );
    add_action( 'bp_template_content', 'haru_channel_content' );
    bp_core_load_template( 'buddypress/members/single/plugins' );
}
function haru_channel_title() {
    echo esc_html__( '', 'haru-vidi' );
}

function haru_channel_content() {
    global $wp_query;

    $original_query     = $wp_query;
    $current_member_id  = bp_displayed_user_id();

    $args = array(
        'post_type'             => 'haru_channel',
        'posts_per_page'        => 6,
        'post_status'           => 'publish',
        'author'                => $current_member_id,
    );

    $wp_query = new WP_Query($args);

    wp_enqueue_script( 'imagesloaded' );
    wp_enqueue_script( 'isotope', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/isotope.pkgd.min.js'), array( 'jquery' ), '', true );
    wp_enqueue_script( 'packery-mode', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/isotope/packery-mode.pkgd.min.js'), array( 'jquery' ), '', true );
    ?>
    <div class="haru-archive-top">
        <div class="haru-archive-top-left">
            <h6 class="archive-video__title"><?php echo esc_html__( 'Has total', 'haru-vidi' ); ?>
                <span class="archive-video__total-count"><?php echo esc_html( $wp_query->found_posts ) . esc_html__( ' channels', 'haru-vidi' ); ?></span>
            </h6>
        </div>
        <div class="haru-archive-top-right">
            <div class="haru-archive-layout-toggle">
                <a href="javascript:;" class="toggle-layout active" data-layout="grid"><?php echo esc_html__( 'Grid', 'haru-vidi' ); ?><i class="haru-icon haru-grid"></i></a>
                <a href="javascript:;" class="toggle-layout" data-layout="list"><?php echo esc_html__( 'List', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
                <a href="javascript:;" class="toggle-layout" data-layout="list-2"><?php echo esc_html__( 'List 2', 'haru-vidi' ); ?><i class="haru-icon haru-list-small"></i></a>
            </div>
        </div>
    </div>
    <?php if ( have_posts() ) : ?>
    <div class="bd-tab-channels layout-wrap style-grid grid-columns grid-columns__3">
        <?php
            while ( have_posts() ) : the_post();
                echo haru_vidi_get_shortcode_template('vidi/channel/'. 'content-channel' . '.php', array(), '', '');
            endwhile;
        ?>
    </div>
    <?php else : ?>
        <h6 class="bp-no-item"><?php echo esc_html__( 'This user haven\'t created any channels yet!' ); ?></h6>
    <?php endif; ?>
    <?php echo haru_bp_paging_load_more_channel(); ?>

    <?php
    wp_reset_query();
    $wp_query = $original_query;
}

/* BuddyPress Load More Channel */
if ( !function_exists('haru_bp_paging_load_more_channel') ) {
    function haru_bp_paging_load_more_channel() {
        global $wp_query;
        // Don't print empty markup if there's only one page.
        if ( $wp_query->max_num_pages < 2 ) {
            return;
        }
        ?>
        <div class="bd-pagination-cpt">
            <button 
                type="button"
                data-current_page="1"
                data-max_page="<?php echo esc_attr( $wp_query->max_num_pages ); ?>"
                data-posts_per_page="1"
                class="bp-channel-load-more"
            ><i class="haru-icon haru-spinner haru-spin loading-icon"></i>
                <?php echo esc_html__( 'Load More', 'haru-vidi' ); ?>
            </button>
        </div>
        <?php
    }
}

add_action( 'wp_ajax_haru_bp_get_channel', 'haru_bp_get_channel' );
add_action( 'wp_ajax_nopriv_haru_bp_get_channel', 'haru_bp_get_channel' );

if ( !function_exists( 'haru_bp_get_channel' ) ) {
    function haru_bp_get_channel() {
        if ( empty($_POST['current_page']) || empty( $_POST['max_page'] ) ) {
            die('0');
        }

        $current_page       = (int)$_POST['current_page'];
        $max_page           = (int)$_POST['max_page'];
        $posts_per_page     = (int)$_POST['posts_per_page'];
        $current_member_id  = bp_displayed_user_id();

        ob_start();

        $offset = $current_page * $posts_per_page;

        $args = array(
            'post_type'             => 'haru_channel',
            'posts_per_page'        => $posts_per_page,
            'offset'                => $offset,
            'post_status'           => 'publish',
            'author'                => $current_member_id,
        );
        
        $channels = new WP_Query( $args );
        ?>

        <div class="channel-list grid-columns grid-columns__3 animated fadeIn haru-clear">
            <?php
                if ( $channels->have_posts() ) {
                    while ( $channels->have_posts() ) { 
                        $channels->the_post();
                        echo haru_vidi_get_shortcode_template('vidi/channel/'. 'content-channel' . '.php', array(), '', '');
                    }
                }
            ?>
        </div>
        <?php

        wp_reset_query();
        
        die(ob_get_clean());
    }
}

// Remove sub nav
function haru_hide_visibility_tab() {   
    if ( bp_is_active( 'videos' ) ) {
        bp_core_remove_subnav_item( 'videos', 'videos' ); 
    }
}
add_action( 'bp_ready', 'haru_hide_visibility_tab' );

/* BuddyPress Add Friend Button */
function haru_bp_friend_button( $user_id ) {
    if ( !$user_id ) {
        $user_id = get_the_author_meta( 'ID' );
    }

    if ( function_exists( 'bp_add_friend_button' ) ) {
        $mybutton = bp_add_friend_button( $user_id );

        if ( ( is_user_logged_in() && ! bp_is_my_profile() ) ) {
            echo $mybutton;
        }
    }
} 

add_action( 'haru_bp_friend_button', 'haru_bp_friend_button' );

/* BuddyPress Friends Count */
function haru_bp_total_friends() {
    $user_id = get_the_author_meta( 'ID' );
    if ( bp_is_active( 'friends' ) ) :  
        if ( bp_get_total_friend_count( $user_id ) > 1 ) {
            echo bp_get_total_friend_count( $user_id ) . '<span>' . esc_html__( ' followers', 'haru-vidi' ) . '</span>';
        } else {
            echo bp_get_total_friend_count( $user_id ) . '<span>' . esc_html__( ' follower', 'haru-vidi' ) . '</span>';
        }
    endif;
}

add_action( 'haru_bp_friend_count', 'haru_bp_total_friends');

