<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

/*
* 0. Get template for posttype @See: http://jeroensormani.com/how-to-add-template-files-in-your-plugin/
*/

function haru_vidi_locate_template( $template_name, $template_path = '', $default_path = '' ) {
    // Set variable to search in haru-vidi folder of theme.
    if ( ! $template_path ) :
        $template_path = 'haru-vidi/';
    endif;
    // Set default plugin templates path.
    if ( ! $default_path ) :
        $default_path = PLUGIN_HARU_VIDI_DIR . 'templates/'; // Path to the template folder
    endif;
    // Search template file in theme folder.
    $template = locate_template( array(
        $template_path . $template_name,
        $template_name
    ) );
    // Get plugins template file.
    if ( ! $template ) :
        $template = $default_path . $template_name;
    endif;

    return apply_filters( 'haru_vidi_locate_template', $template, $template_name, $template_path, $default_path );
}

function haru_vidi_posttype_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
    if ( is_array( $args ) && isset( $args ) ) :
        extract( $args );
    endif;
    $template_file = haru_vidi_locate_template( $template_name, $tempate_path, $default_path );

    if ( ! file_exists( $template_file ) ) :
        _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
        return;
    endif;

    return $template_file;
}

function haru_vidi_get_shortcode_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
    if ( is_array( $args ) && isset( $args ) ) :
        extract( $args );
    endif;
    $template_file = haru_vidi_locate_template( $template_name, $tempate_path, $default_path );

    if ( ! file_exists( $template_file ) ) :
        _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
        return;
    endif;
    
    include $template_file;
}

/*
* 1. Short link for video: https://kellenmace.com/remove-custom-post-type-slug-from-permalinks/
*/
function haru_vidi_remove_cpt_slug( $post_link, $post ) {
    if ( 'haru_video' === $post->post_type && 'publish' === $post->post_status ) {
        $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    }

    return $post_link;
}
add_filter( 'post_type_link', 'haru_vidi_remove_cpt_slug', 10, 2 );

function haru_vidi_add_cpt_post_names_to_main_query( $query ) {
    if ( ! $query->is_main_query() ) {
        return;
    }

    if ( ! isset( $query->query['page'] ) || 2 !== count( $query->query ) ) {
        return;
    }

    if ( empty( $query->query['name'] ) ) {
        return;
    }

    $query->set( 'post_type', array( 'post', 'page', 'haru_video' ) );
}
add_action( 'pre_get_posts', 'haru_vidi_add_cpt_post_names_to_main_query' );

// Get option
function haru_vidi_get_setting( $option_key, $key = '', $default = false ) {
    if ( function_exists( 'cmb2_get_option' ) ) {
        // Use cmb2_get_option as it passes through some key filters.
        return cmb2_get_option( $option_key, $key, $default );
    }
    // Fallback to get_option if CMB2 is not loaded yet.
    $opts = get_option( $option_key, $default );
    $val = $default;
    if ( 'all' == $key ) {
        $val = $opts;
    } elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
        $val = $opts[ $key ];
    }
    return $val;
}

// CPT Breadcrumbs: https://wordpress.stackexchange.com/questions/204738/breadcrumbs-with-custom-post-type-without-plugin
if ( !function_exists( 'haru_vidi_cpt_breadcrumbs' ) ) {
    function haru_vidi_cpt_breadcrumbs() {
        // Set variables for later use
        $home_link        = home_url('/');
        $home_text        = esc_html__( 'Home', 'haru-vidi' );
        $link_before      = '<span typeof="v:Breadcrumb">';
        $link_after       = '</span>';
        $link_attr        = ' rel="v:url" property="v:title"';
        $link             = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
        $delimiter        = '<span class="delimiter"> &raquo; </span>';              // Delimiter between crumbs
        $before           = '<span class="current">'; // Tag before the current crumb
        $after            = '</span>';                // Tag after the current crumb
        $page_addon       = '';                       // Adds the page number if the query is paged
        $breadcrumb_trail = '';
        $category_links   = '';

        /** 
         * Set our own $wp_the_query variable. Do not use the global variable version due to 
         * reliability
         */
        $wp_the_query   = $GLOBALS['wp_the_query'];
        $queried_object = $wp_the_query->get_queried_object();

        // Handle single post requests which includes single pages, posts and attatchments
        if ( is_singular() ) {
            /** 
             * Set our own $post variable. Do not use the global variable version due to 
             * reliability. We will set $post_object variable to $GLOBALS['wp_the_query']
             */
            $post_object = sanitize_post( $queried_object );

            // Set variables 
            $title          = apply_filters( 'the_title', $post_object->post_title );
            $parent         = $post_object->post_parent;
            $post_type      = $post_object->post_type;
            $post_id        = $post_object->ID;
            $post_link      = $before . $title . $after;
            $parent_string  = '';
            $post_type_link = '';

            if ( 'post' === $post_type ) {
                // Get the post categories
                $categories = get_the_category( $post_id );
                if ( $categories ) {
                    // Lets grab the first category
                    $category  = $categories[0];

                    $category_links = get_category_parents( $category, true, $delimiter );
                    $category_links = str_replace( '<a',   $link_before . '<a' . $link_attr, $category_links );
                    $category_links = str_replace( '</a>', '</a>' . $link_after,             $category_links );
                }
            }

            if ( !in_array( $post_type, ['post', 'page', 'attachment'] ) ) {
                $post_type_object = get_post_type_object( $post_type );
                $archive_link     = esc_url( get_post_type_archive_link( $post_type ) );

                $post_type_link   = sprintf( $link, $archive_link, $post_type_object->labels->menu_name ); // @TODO: singular_name -> menu_name
            }

            // Get post parents if $parent !== 0
            if ( 0 !== $parent ) {
                $parent_links = [];
                while ( $parent ) {
                    $post_parent = get_post( $parent );

                    $parent_links[] = sprintf( $link, esc_url( get_permalink( $post_parent->ID ) ), get_the_title( $post_parent->ID ) );

                    $parent = $post_parent->post_parent;
                }

                $parent_links = array_reverse( $parent_links );

                $parent_string = implode( $delimiter, $parent_links );
            }

            // Lets build the breadcrumb trail
            if ( $parent_string ) {
                $breadcrumb_trail = $parent_string . $delimiter . $post_link;
            } else {
                $breadcrumb_trail = $post_link;
            }

            if ( $post_type_link )
                $breadcrumb_trail = $post_type_link . $delimiter . $breadcrumb_trail;

            if ( $category_links )
                $breadcrumb_trail = $category_links . $breadcrumb_trail;
        }

        // Handle archives which includes category-, tag-, taxonomy-, date-, custom post type archives and author archives
        if ( is_archive() ) {
            if ( is_category() || is_tag() || is_tax() ) {
                // Set the variables for this section
                $term_object        = get_term( $queried_object );
                $taxonomy           = $term_object->taxonomy;
                $term_id            = $term_object->term_id;
                $term_name          = $term_object->name;
                $term_parent        = $term_object->parent;
                $taxonomy_object    = get_taxonomy( $taxonomy );
                $current_term_link  = $before . $taxonomy_object->labels->menu_name . ': ' . $term_name . $after; // @TODO: singular_name -> menu_name
                $parent_term_string = '';

                if ( 0 !== $term_parent ) {
                    // Get all the current term ancestors
                    $parent_term_links = [];
                    while ( $term_parent ) {
                        $term = get_term( $term_parent, $taxonomy );

                        $parent_term_links[] = sprintf( $link, esc_url( get_term_link( $term ) ), $term->name );

                        $term_parent = $term->parent;
                    }

                    $parent_term_links  = array_reverse( $parent_term_links );
                    $parent_term_string = implode( $delimiter, $parent_term_links );
                }

                if ( $parent_term_string ) {
                    $breadcrumb_trail = $parent_term_string . $delimiter . $current_term_link;
                } else {
                    $breadcrumb_trail = $current_term_link;
                }

            } elseif ( is_author() ) {

                $breadcrumb_trail = esc_html__( 'Author archive for ', 'haru-vidi' ) .  $before . $queried_object->data->display_name . $after;

            } elseif ( is_date() ) {
                // Set default variables
                $year     = $wp_the_query->query_vars['year'];
                $monthnum = $wp_the_query->query_vars['monthnum'];
                $day      = $wp_the_query->query_vars['day'];

                // Get the month name if $monthnum has a value
                if ( $monthnum ) {
                    $date_time  = DateTime::createFromFormat( '!m', $monthnum );
                    $month_name = $date_time->format( 'F' );
                }

                if ( is_year() ) {

                    $breadcrumb_trail = $before . $year . $after;

                } elseif( is_month() ) {

                    $year_link        = sprintf( $link, esc_url( get_year_link( $year ) ), $year );

                    $breadcrumb_trail = $year_link . $delimiter . $before . $month_name . $after;

                } elseif( is_day() ) {

                    $year_link        = sprintf( $link, esc_url( get_year_link( $year ) ),             $year       );
                    $month_link       = sprintf( $link, esc_url( get_month_link( $year, $monthnum ) ), $month_name );

                    $breadcrumb_trail = $year_link . $delimiter . $month_link . $delimiter . $before . $day . $after;
                }

            } elseif ( is_post_type_archive() ) {

                $post_type        = $wp_the_query->query_vars['post_type'];
                $post_type_object = get_post_type_object( $post_type );

                $breadcrumb_trail = $before . $post_type_object->labels->menu_name . $after; // @TODO: singular_name -> menu_name

            }
        }   

        // Handle the search page
        if ( is_search() ) {
            $breadcrumb_trail = esc_html__( 'Search query for: ', 'haru-vidi' ) . $before . get_search_query() . $after;
        }

        // Handle 404's
        if ( is_404() ) {
            $breadcrumb_trail = $before . esc_html__( 'Error 404', 'haru-vidi' ) . $after;
        }

        // Handle paged pages
        if ( is_paged() ) {
            $current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
            $page_addon   = $before . sprintf( __( ' ( Page %s )' ), number_format_i18n( $current_page ) ) . $after;
        }

        $breadcrumb_output_link  = '';
        $breadcrumb_output_link .= '<div class="haru-breadcrumb">';
        if ( is_home() || is_front_page() ) {
            // Do not show breadcrumbs on page one of home and frontpage
            if ( is_paged() ) {
                $breadcrumb_output_link .= '<a href="' . $home_link . '">' . $home_text . '</a>';
                $breadcrumb_output_link .= $page_addon;
            }
        } else {
            $breadcrumb_output_link .= '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $home_text . '</a>';
            $breadcrumb_output_link .= $delimiter;
            $breadcrumb_output_link .= $breadcrumb_trail;
            $breadcrumb_output_link .= $page_addon;
        }
        $breadcrumb_output_link .= '</div><!-- .breadcrumbs -->';

        return $breadcrumb_output_link;
    }
}


// Process email template
function haru_vidi_process_email_template( $replace_array, $message ) {
    foreach ( $replace_array as $key => $replace ) {
        $search = '{{' . $key . '}}';
        $message = str_replace($search, $replace, $message);
    }

    return $message;
}

/**
 * Filter the mail content type. See: https://developer.wordpress.org/reference/hooks/wp_mail_content_type/
 * https://developer.wordpress.org/reference/functions/wp_mail/
 */
if ( !function_exists( 'haru_vidi_set_html_mail_content_type' ) ) {
    function haru_vidi_set_html_mail_content_type() {
        return 'text/html';
    }

    add_filter( 'wp_mail_content_type', 'haru_vidi_set_html_mail_content_type' );
}

// CMB2 Options Funtions
// Get Post List by Meta key
if ( !function_exists( 'haru_vidi_get_advertising_list_options' ) ) {
    function haru_vidi_get_advertising_list_options( $type ) {

        if ( !is_admin() ) {
            return array();
        }

        $query_args  = array(
            'post_type'         => 'haru_advertising',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
            'meta_query'        => array(
                'relation' => 'AND',
                array(
                    'key'       => 'haru_advertising_type',
                    'value'     => $type,
                    'compare'   => '=',
                )
            )
        );

        $ads_query = new WP_Query( $query_args );

        $advertising_list = array();

        if ( $ads_query->have_posts() ) {
            while($ads_query->have_posts()) : $ads_query->the_post();
                $key = get_the_ID();
                $advertising_list[$key] = get_the_title();
            endwhile;
        }

        return $advertising_list;
    }
}

// Get Video List by Meta key
if ( !function_exists( 'haru_vidi_get_cpt_list_options' ) ) {
    function haru_vidi_get_cpt_list_options( $post_type ) {

        if ( !is_admin() ) {
            return array();
        }

        $query_args  = array(
            'post_type'         => $post_type,
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
        );

        $cpt_query = new WP_Query( $query_args );

        $cpt_list = array();

        if ( $cpt_query->have_posts() ) {
            while($cpt_query->have_posts()) : $cpt_query->the_post();
                $key = get_the_ID();
                $cpt_list[$key] = get_the_title();
            endwhile;
        }

        return $cpt_list;
    }
}

// Get Page List by Meta key
if ( !function_exists( 'haru_vidi_get_page_list_options' ) ) {
    function haru_vidi_get_page_list_options() {

        if ( !is_admin() ) {
            return array();
        }

        $query_args  = array(
            'post_type'         => 'page',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
        );

        $page_query = new WP_Query( $query_args );

        $page_list = array();

        if ( $page_query->have_posts() ) {
            while($page_query->have_posts()) : $page_query->the_post();
                $key = get_the_ID();
                $page_list[$key] = get_the_title();
            endwhile;
        }

        return $page_list;
    }
}

// Get Sidebar List
if ( !function_exists( 'haru_vidi_get_sidebar_list_options' ) ) {
    function haru_vidi_get_sidebar_list_options() {

        if ( !is_admin() ) {
            return array();
        }

        $sidebar_list = array();

        foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
            $sidebar_list[ $sidebar['id'] ] = ucwords( $sidebar['name'] );
        }

        return $sidebar_list;
    }
}


/**
 * Retrieve page ids - used for videos, channels,... returns -1 if no page is found.
 *
 * @param string $page Page slug.
 * @return int
 */
function haru_get_page_id( $page ) {
    $page = apply_filters( 'haru_get_' . $page . '_page_id', haru_vidi_get_setting( 'vidi-general-settings', 'haru_' . $page . '_page', '' ) );

    return $page ? absint( $page ) : -1;
}

/**
 * Add a post display state for special Vidi pages in the page list table.
 *
 * @param array   $post_states An array of post display states.
 * @param WP_Post $post        The current post object.
 */
function haru_add_display_post_states( $post_states, $post ) {
    if ( haru_get_page_id( 'my_video' ) === $post->ID ) {
        $post_states['haru_page_for_my_video'] = esc_html__( 'My Videos Page', 'haru-vidi' );
    }

    if ( haru_get_page_id( 'submit_video' ) === $post->ID ) {
        $post_states['haru_page_for_submit_video'] = esc_html__( 'Submit Video Page', 'haru-vidi' );
    }

    if ( haru_get_page_id( 'my_channel' ) === $post->ID ) {
        $post_states['haru_page_for_my_channel'] = esc_html__( 'My Channels Page', 'haru-vidi' );
    }

    if ( haru_get_page_id( 'submit_channel' ) === $post->ID ) {
        $post_states['haru_page_for_submit_channel'] = esc_html__( 'Submit Channel Page', 'haru-vidi' );
    }

    if ( haru_get_page_id( 'my_playlist' ) === $post->ID ) {
        $post_states['haru_page_for_my_playlist'] = esc_html__( 'My Playlists Page', 'haru-vidi' );
    }

    if ( haru_get_page_id( 'submit_playlist' ) === $post->ID ) {
        $post_states['haru_page_for_submit_playlist'] = esc_html__( 'Submit Playlist Page', 'haru-vidi' );
    }

    if ( haru_get_page_id( 'my_series' ) === $post->ID ) {
        $post_states['haru_page_for_my_series'] = esc_html__( 'My Series Page', 'haru-vidi' );
    }

    if ( haru_get_page_id( 'submit_series' ) === $post->ID ) {
        $post_states['haru_page_for_submit_series'] = esc_html__( 'Submit Series Page', 'haru-vidi' );
    }

    return $post_states;
}

add_filter( 'display_post_states', 'haru_add_display_post_states', 10, 2 );

// Get Login URL
if ( !function_exists( 'haru_get_login_url' ) ) {
    function haru_get_login_url() {
        $login_url = wp_login_url( get_permalink() );

        $haru_login_page = haru_vidi_get_setting( 'vidi-member-settings', 'haru_login_page', '' );
        if ( $haru_login_page != '' && is_numeric( $haru_login_page ) ) {
            $login_url = get_permalink( $haru_login_page );
        }

        return $login_url;
    }
}

// Get Register URL
if ( !function_exists( 'haru_get_register_url' ) ) {
    function haru_get_register_url() {
        $register_url = wp_registration_url();

        $haru_register_page = haru_vidi_get_setting( 'vidi-member-settings', 'haru_register_page', '' );
        if ( $haru_register_page != '' && is_numeric( $haru_register_page ) ) {
            $register_url = get_permalink( $haru_register_page );
        }

        return $register_url;
    }
}

// Get Profile URL
if ( !function_exists( 'haru_get_profile_url' ) ) {
    function haru_get_profile_url() {
        if ( is_user_logged_in() ) {
            $user_id = get_current_user_id();

            if ( function_exists('bp_is_active') ) {
                $profile_url = bp_core_get_userlink( $user_id, false, true );
            } else {
                $profile_url = get_edit_profile_url( $user_id ); // get_edit_user_link
            }

            return $profile_url;
        } else {

            return;
        }
                
    }
}

// Get Logout Redirect URL
if ( ! function_exists( 'haru_get_logout_redirect_url' ) ) {
    function haru_get_logout_redirect_url() {
        $logout_redirect_url = wp_registration_url();

        $haru_logout_redirect_page = haru_vidi_get_setting( 'vidi-member-settings', 'haru_logout_redirect_page', '' );
        if ( $haru_logout_redirect_page != '' && is_numeric( $haru_logout_redirect_page ) ) {
            $logout_redirect_url = get_permalink( $haru_logout_redirect_page );
        }

        return $logout_redirect_url;
    }
}

// Get vidi CPT slug
if ( ! function_exists( 'haru_vidi_get_video_slug' ) ) {
    function haru_vidi_get_video_slug() {
        $video_slug = get_option( 'haru_video_base' );
        if ( ! $video_slug ) $video_slug = 'video';

        return $video_slug;
    }
}

if ( ! function_exists( 'haru_vidi_get_video_category_slug' ) ) {
    function haru_vidi_get_video_category_slug() {
        $video_category_slug = get_option( 'haru_video_category_base' );
        if ( ! $video_category_slug ) $video_category_slug = 'video-category';

        return $video_category_slug;
    }
}

if ( ! function_exists( 'haru_vidi_get_video_tag_slug' ) ) {
    function haru_vidi_get_video_tag_slug() {
        $video_tag_slug = get_option( 'haru_video_tag_base' );
        if ( ! $video_tag_slug ) $video_tag_slug = 'video-tag';

        return $video_tag_slug;
    }
}

if ( ! function_exists( 'haru_vidi_get_video_label_slug' ) ) {
    function haru_vidi_get_video_label_slug() {
        $video_label_slug = get_option( 'haru_video_label_base' );
        if ( ! $video_label_slug ) $video_label_slug = 'video-label';

        return $video_label_slug;
    }
}

if ( ! function_exists( 'haru_vidi_get_channel_slug' ) ) {
    function haru_vidi_get_channel_slug() {
        $channel_slug = get_option( 'haru_channel_base' );
        if ( ! $channel_slug ) $channel_slug = 'channel';

        return $channel_slug;
    }
}

if ( ! function_exists( 'haru_vidi_get_channel_category_slug' ) ) {
    function haru_vidi_get_channel_category_slug() {
        $channel_category_slug = get_option( 'haru_channel_category_base' );
        if ( ! $channel_category_slug ) $channel_category_slug = 'channel-category';

        return $channel_category_slug;
    }
}

if ( ! function_exists( 'haru_vidi_get_playlist_slug' ) ) {
    function haru_vidi_get_playlist_slug() {
        $playlist_slug = get_option( 'haru_playlist_base' );
        if ( ! $playlist_slug ) $playlist_slug = 'playlist';

        return $playlist_slug;
    }
}

if ( ! function_exists( 'haru_vidi_get_playlist_category_slug' ) ) {
    function haru_vidi_get_playlist_category_slug() {
        $playlist_category_slug = get_option( 'haru_playlist_category_base' );
        if ( ! $playlist_category_slug ) $playlist_category_slug = 'playlist-category';

        return $playlist_category_slug;
    }
}

if ( ! function_exists( 'haru_vidi_get_series_slug' ) ) {
    function haru_vidi_get_series_slug() {
        $series_slug = get_option( 'haru_series_base' );
        if ( ! $series_slug ) $series_slug = 'series';

        return $series_slug;
    }
}

if ( ! function_exists( 'haru_vidi_get_series_category_slug' ) ) {
    function haru_vidi_get_series_category_slug() {
        $series_category_slug = get_option( 'haru_series_category_base' );
        if ( ! $series_category_slug ) $series_category_slug = 'series-category';

        return $series_category_slug;
    }
}

if ( ! function_exists( 'haru_vidi_get_actor_slug' ) ) {
    function haru_vidi_get_actor_slug() {
        $actor_slug = get_option( 'haru_actor_base' );
        if ( ! $actor_slug ) $actor_slug = 'actor';

        return $actor_slug;
    }
}

if ( ! function_exists( 'haru_vidi_get_actor_category_slug' ) ) {
    function haru_vidi_get_actor_category_slug() {
        $actor_category_slug = get_option( 'haru_actor_category_base' );
        if ( ! $actor_category_slug ) $actor_category_slug = 'actor-category';

        return $actor_category_slug;
    }
}

if ( ! function_exists( 'haru_vidi_get_director_slug' ) ) {
    function haru_vidi_get_director_slug() {
        $director_slug = get_option( 'haru_director_base' );
        if ( ! $director_slug ) $director_slug = 'director';

        return $director_slug;
    }
}

if ( ! function_exists( 'haru_vidi_get_director_category_slug' ) ) {
    function haru_vidi_get_director_category_slug() {
        $director_category_slug = get_option( 'haru_director_category_base' );
        if ( ! $director_category_slug ) $director_category_slug = 'director-category';

        return $director_category_slug;
    }
}
