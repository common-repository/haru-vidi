<?php
/**
 * Plugin Name: Haru Vidi Free
 * Plugin URI: http://harutheme.com
 * Description: Haru Vidi - A Video WordPress plugin by HaruTheme.
 * Version: 1.0.2
 * Author: HaruTheme
 * Author URI: http://harutheme.com
 *
 * Text Domain: haru-vidi
 * Domain Path: /languages/
 *
 * @package Haru Vidi
 * @category Core Plugin
 * @author HaruTheme
 *
 **/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if access directly
}

if ( ! class_exists( 'Haru_Vidi' ) ) {
    class Haru_Vidi {
        protected $prefix;

        protected $version;

        function __construct() {
            $this->version = '1.0.2';
            $this->prefix = 'haru-vidi';
            $this->define_constants();
            $this->include_files();
            $this->load_plugin_textdomain();
            $this->init();
        }

        function define_constants() {
            if ( !defined( 'PLUGIN_HARU_VIDI_DIR' ) ) {
                define( 'PLUGIN_HARU_VIDI_DIR', plugin_dir_path(__FILE__) );
            }
            if ( !defined( 'PLUGIN_HARU_VIDI_URL' ) ) {
                define( 'PLUGIN_HARU_VIDI_URL', plugin_dir_url( __FILE__ ) );
            }
            if ( !defined( 'PLUGIN_HARU_VIDI_FILE' ) ) {
                define( 'PLUGIN_HARU_VIDI_FILE', __FILE__ );
            }
            if ( !defined( 'PLUGIN_HARU_VIDI_NAME' ) ) {
                define( 'PLUGIN_HARU_VIDI_NAME', 'haru-vidi' );
            }
            if ( !defined( 'HARU_VIDI_SHORTCODE_CATEGORY' ) ) {
                define( 'HARU_VIDI_SHORTCODE_CATEGORY', esc_html__( 'Vidi Shortcodes', 'haru-vidi' ) );
            }
        }

        function init() {
            add_action( 'plugins_loaded', array($this, 'load_plugin_textdomain' ));
            add_action( 'admin_init', array($this, 'haru_admin_script' ));
            add_action( 'wp_enqueue_scripts', array($this, 'haru_frontend_script' ), 1);
            add_action( 'widgets_init', array($this, 'haru_vidi_register_sidebar') );
            // Apply filter do_shortcode
            add_filter( 'widget_text', 'do_shortcode' );
            add_filter( 'widget_content', 'do_shortcode' );
        }

        public static function create_pages() {
            if ( ! current_user_can( 'activate_plugins' ) ) return;

            global $wpdb;
  
            if ( null === $wpdb->get_row( "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'watch-later'", 'ARRAY_A' ) ) {
                 
                $current_user = wp_get_current_user();
                
                // create post object
                $page = array(
                  'post_title'      => esc_html__( 'Watch Later', 'haru-vidi' ),
                  'post_content'    => '[haru_watch_later]',
                  'post_status'     => 'publish',
                  'post_author'     => $current_user->ID,
                  'post_type'       => 'page'
                );
                
                // insert the post into the database
                $watch_later_page = wp_insert_post( $page );
            }
        }

        function include_files() {
            // Libraries
            require_once( 'includes/libraries/_init.php' );
            require_once( 'includes/posttypes/_init.php' );
            require_once( 'includes/vidi/_init.php' ); // Vidi
            require_once( 'includes/widgets/widgets.php' );
            require_once( 'includes/scss/_init.php' );
        }

        public function load_plugin_textdomain() {
            load_plugin_textdomain( 'haru-vidi', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'  );
        }

        public function haru_vidi_register_sidebar() {
            register_sidebar( 
                array(
                    'name'          => esc_html__( 'Vidi Sidebar', 'haru-vidi' ),
                    'id'            => 'vidi-sidebar',
                    'description'   => esc_html__( 'Widget Area for Vidi plugin', 'haru-vidi' ),
                    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h4 class="widget-title"><span>',
                    'after_title'   => '</span></h4>',
                ) 
            );
        }


        // Load script admin
        public function haru_admin_script() {
            // CSS
            wp_enqueue_style( $this->prefix . '-admin', plugins_url( PLUGIN_HARU_VIDI_NAME.'/admin/assets/css/admin.css'), array(), $this->version, 'all' );

            // JS
        }
        // Load script front-end
        public function haru_frontend_script() {
            // CSS
            if ( !is_admin() ) {
                // Remove VC FontAwesome
                wp_deregister_style( 'vc_font_awesome_5_shims' );
                wp_deregister_style( 'vc_font_awesome_5' );
                $url_font_awesome_all = plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/fontawesome/css/all.min.css' );
                $url_font_awesome_shims = plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/fontawesome/css/v4-shims.min.css' );
                wp_enqueue_style( 'fontawesome-all', $url_font_awesome_all, array());
                wp_enqueue_style( 'fontawesome-shims', $url_font_awesome_shims, array());

                wp_enqueue_style( 'animate', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/animate/animate.min.css' ), array() );

                wp_enqueue_style( 'magnific-popup', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/magnificPopup/magnific-popup.css'), array() );

                if ( file_exists( PLUGIN_HARU_VIDI_DIR . '/assets/css/style-custom.min.css' ) ) {
                    wp_enqueue_style( 'haru-vidi-custom', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/css/style-custom.min.css'), array() );
                } else {
                    wp_enqueue_style( 'haru-vidi', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/css/style.css'), array() );
                }
            }
            // JS
            if ( !is_admin() ) {
                wp_enqueue_script( 'screenfull', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/screenfull/screenfull.js'), array( 'jquery' ), '', true );

                wp_enqueue_script( 'js-cookie', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/cookie/js-cookie.min.js'), array( 'jquery' ), '', true );

                wp_enqueue_script( 'jquery-magnific-popup', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/magnificPopup/jquery.magnific-popup.min.js'), array( 'jquery' ), '', true );

                wp_enqueue_script( 'infinitescroll', plugins_url ( PLUGIN_HARU_VIDI_NAME . '/assets/libraries/infinitescroll/jquery.infinitescroll.min.js'), array( 'jquery' ), '', true );

                wp_enqueue_script( 'haru-vidi', plugins_url( PLUGIN_HARU_VIDI_NAME . '/assets/js/haru-vidi.js'), array( 'jquery' ), '', true );
            }

            wp_localize_script( 'haru-vidi', 'haru_vidi_ajax_url', get_site_url() . '/wp-admin/admin-ajax.php?activate-multi=true' );
            wp_localize_script( 'haru-vidi', 'haru_vidi_plugin_url', PLUGIN_HARU_VIDI_URL );
        }
    }

    // Run Haru_Vidi
    if ( !function_exists( 'haru_init_haru_vidi' ) ) {
        function haru_init_haru_vidi() {
            $haruVidi = new Haru_Vidi();

            return $haruVidi;
        }
    }

    haru_init_haru_vidi();

    // Create pages when active
    register_activation_hook( __FILE__, array( 'Haru_Vidi', 'create_pages' ) );
}
