<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// https://code.tutsplus.com/articles/how-to-create-a-simple-post-rating-system-with-wordpress-and-jquery--wp-24474
if ( ! class_exists( 'Haru_Vidi_Vote_System' ) ) {
    class Haru_Vidi_Vote_System {

        public function __construct() {

            add_action( 'admin_menu', array( $this, 'haru_register_video_vote_settings' ) );
            add_action( 'admin_init', array( $this, 'haru_register_video_vote_metabox' ) );

            if ( is_admin() ) {
                // Do something
            }
        }

        public function haru_register_video_vote_settings() {
            
        }

        public function haru_register_video_vote_metabox() {
            /**
             * Initiate the metabox
             */
        }
    }

    new Haru_Vidi_Vote_System;
}
// Ajax Rating
if ( !function_exists('haru_ajax_voting') ) {
    function haru_ajax_voting() {
        if ( !isset($_POST['post_id']) || empty( $_POST['post_id'] ) ) {
            die;
        }
        $post_id = $_POST['post_id'];
        $post_action = $_POST['post_action'];
        $vote_status = $_POST['vote_status'];

        $login_required = 'yes'; // @TODO

        $return = array();

        // Fake Like
        $fake_like_dislike = get_post_meta($post_id, 'haru_fake_like_dislike', true);
        if ( $fake_like_dislike == 'on' ) {
            $fake_like_count = (int)get_post_meta($post_id, 'haru_fake_like_count', true);
            $fake_dislike_count = (int)get_post_meta($post_id, 'haru_fake_dislike_count', true);
        } else {
            $fake_like_count = 0;
            $fake_dislike_count = 0;
        }

        if ( $login_required == 'yes' && !is_user_logged_in() ) {
            $return['ID']   = 1;
            $return['message']     = esc_html__('Please login to vote.', 'haru-vidi');

            wp_send_json($return); // https://codex.wordpress.org/Function_Reference/wp_send_json         
        } else {

            // Retrieve user IP address
            $ip = haru_get_user_ip();
            
            // Get votes count for the current post
            $like_count = (int)get_post_meta( $post_id, '_post_like_count', true );
            $dislike_count = (int)get_post_meta( $post_id, '_post_dislike_count', true );

            // Process
            if ( $post_action == $vote_status ) {
                if ( haru_has_already_voted( $post_id ) == false ) {
                    // Get voters'IPs for the current post
                    $meta_IP = get_post_meta($post_id, '_voted_IP');
                    if ( !empty( $meta_IP ) ) {
                        $voted_IP = $meta_IP[0];
                    } else {
                        $voted_IP = array();
                    }

                    $voted_IP[$ip] = $post_action;
                    update_post_meta($post_id, '_voted_IP', $voted_IP);

                    if ( $post_action == 'like' ) {
                        update_post_meta($post_id, '_post_like_count', $like_count + 1);
                        // Update total
                        update_post_meta($post_id, '_post_like_count_total', $fake_like_count + $like_count + 1);
                        update_post_meta($post_id, '_post_dislike_count_total', $fake_dislike_count + $dislike_count);

                        $return['like_count'] = haru_format_count_number( $fake_like_count + $like_count + 1 );
                        $return['dislike_count'] = haru_format_count_number( $fake_dislike_count + $dislike_count );
                        $return['vote_status'] = $vote_status;
                        $return['like_percentage'] = haru_get_like_percentage($fake_like_count + $like_count + 1, $fake_dislike_count + $dislike_count);
                        $return['message_like'] = esc_html__('You has just liked', 'haru-vidi');
                        $return['message_dislike'] = esc_html__('Click to dislike this', 'haru-vidi');
                    } else if ( $post_action == 'dislike' ) {
                        update_post_meta($post_id, '_post_dislike_count', $dislike_count + 1);
                        // Update total
                        update_post_meta($post_id, '_post_like_count_total', $fake_like_count + $like_count);
                        update_post_meta($post_id, '_post_dislike_count_total', $fake_dislike_count + $dislike_count + 1);

                        $return['like_count'] = haru_format_count_number( $fake_like_count + $like_count );
                        $return['dislike_count'] = haru_format_count_number( $fake_dislike_count + $dislike_count + 1 );
                        $return['vote_status'] = $vote_status;
                        $return['like_percentage'] = haru_get_like_percentage($fake_like_count + $like_count, $fake_dislike_count + $dislike_count + 1);
                        $return['message_like'] = esc_html__('Click to like this', 'haru-vidi');
                        $return['message_dislike'] = esc_html__('You has just disliked', 'haru-vidi');
                    }
                } else {
                    // Get voters'IPs for the current post
                    $meta_IP = get_post_meta($post_id, '_voted_IP');
                    $voted_IP = $meta_IP[0];

                    $voted_IP[$ip] = $post_action;
                    update_post_meta($post_id, '_voted_IP', $voted_IP);

                    if ( $post_action == 'like' ) {
                        update_post_meta($post_id, '_post_like_count', $like_count + 1);
                        update_post_meta($post_id, '_post_dislike_count', $dislike_count - 1);
                        // Update total
                        update_post_meta($post_id, '_post_like_count_total', $fake_like_count + $like_count + 1);
                        update_post_meta($post_id, '_post_dislike_count_total', $fake_dislike_count + $dislike_count - 1);

                        $return['like_count'] = haru_format_count_number( $fake_like_count + $like_count + 1 );
                        $return['dislike_count'] = haru_format_count_number( $fake_dislike_count + $dislike_count - 1 );
                        $return['vote_status'] = $vote_status;
                        $return['like_percentage'] = haru_get_like_percentage($fake_like_count + $like_count + 1, $fake_dislike_count + $dislike_count - 1);
                        $return['message_like'] = esc_html__('You has just liked', 'haru-vidi');
                        $return['message_dislike'] = esc_html__('Click to dislike this', 'haru-vidi');
                    } else if ( $post_action == 'dislike' ) {
                        update_post_meta($post_id, '_post_like_count', $like_count - 1);
                        update_post_meta($post_id, '_post_dislike_count', $dislike_count + 1);
                        // Update total
                        update_post_meta($post_id, '_post_like_count_total', $fake_like_count + $like_count - 1);
                        update_post_meta($post_id, '_post_dislike_count_total', $fake_dislike_count + $dislike_count + 1);

                        $return['like_count'] = haru_format_count_number( $fake_like_count + $like_count - 1 );
                        $return['dislike_count'] = haru_format_count_number( $fake_dislike_count + $dislike_count + 1 );
                        $return['vote_status'] = $vote_status;
                        $return['like_percentage'] = haru_get_like_percentage($fake_like_count + $like_count - 1, $fake_dislike_count + $dislike_count + 1);
                        $return['message_like'] = esc_html__('Click to like this', 'haru-vidi');
                        $return['message_dislike'] = esc_html__('You has just disliked', 'haru-vidi');
                    }
                }
            } else {
                $meta_IP = get_post_meta($post_id, '_voted_IP');
                $voted_IP = $meta_IP[0];

                unset($voted_IP[$ip]);

                update_post_meta($post_id, '_voted_IP', $voted_IP);

                if ( $post_action == 'like' ) {
                    update_post_meta($post_id, '_post_like_count', $like_count - 1);
                    // Update total
                    update_post_meta($post_id, '_post_like_count_total', $fake_like_count + $like_count - 1);
                    update_post_meta($post_id, '_post_dislike_count_total', $fake_dislike_count + $dislike_count);

                    $return['like_count'] = haru_format_count_number( $fake_like_count + $like_count - 1 );
                    $return['dislike_count'] = haru_format_count_number( $fake_dislike_count + $dislike_count );
                    $return['vote_status'] = '';
                    $return['like_percentage'] = haru_get_like_percentage($fake_like_count + $like_count - 1, $fake_dislike_count + $dislike_count);
                    $return['message_like'] = esc_html__('You has just unvote like', 'haru-vidi');
                    $return['message_dislike'] = esc_html__('Click to dislike this', 'haru-vidi');
                } else {
                    update_post_meta($post_id, '_post_dislike_count', $dislike_count - 1);
                    // Update total
                    update_post_meta($post_id, '_post_like_count_total', $fake_like_count + $like_count);
                    update_post_meta($post_id, '_post_dislike_count_total', $fake_dislike_count + $dislike_count - 1);

                    $return['like_count'] = haru_format_count_number( $fake_like_count + $like_count );
                    $return['dislike_count'] = haru_format_count_number( $fake_dislike_count + $dislike_count - 1 );
                    $return['vote_status'] = '';
                    $return['like_percentage'] = haru_get_like_percentage($fake_like_count + $like_count, $fake_dislike_count + $dislike_count - 1);
                    $return['message_like'] = esc_html__('Click to like this', 'haru-vidi');
                    $return['message_dislike'] = esc_html__('You has just unvote dislike', 'haru-vidi');
                }
            }

            wp_send_json($return);
        }

        die;
    }

    add_action( 'wp_ajax_haru_ajax_voting', 'haru_ajax_voting' );
    add_action( 'wp_ajax_nopriv_haru_ajax_voting', 'haru_ajax_voting' );
}

// https://www.wpbeginner.com/wp-tutorials/how-to-display-a-users-ip-address-in-wordpress/
if ( !function_exists('haru_get_user_ip') ) {
    function haru_get_user_ip() {
        if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            // Check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            // To check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return apply_filters( 'wpb_get_ip', $ip );
    }
}

if ( !function_exists('haru_has_already_voted') ) {
    function haru_has_already_voted($post_id) {
        // Retrieve post votes IPs
        $meta_IP = get_post_meta($post_id, '_voted_IP');

        if ( !empty( $meta_IP ) ) {
            $voted_IP = $meta_IP[0];
        } else {
            $voted_IP = array();
        }
             
        // Retrieve current user IP
        $ip = haru_get_user_ip();
         
        // If user has already voted
        if ( in_array($ip, array_keys($voted_IP)) ) {
            return true;
        }
        
        return false;
    }
}

if ( !function_exists('haru_has_already_voted_by_time') ) {
    function haru_has_already_voted_by_time($post_id) {
        global $timebeforerevote;
        
        $timebeforerevote = 43200; // 60 = 1 hours

        // Retrieve post votes IPs
        $meta_IP = get_post_meta($post_id, '_voted_IP');
        if ( !empty( $meta_IP ) ) {
            $voted_IP = $meta_IP[0];
        } else {
            $voted_IP = array();
        }
             
        // Retrieve current user IP
        $ip = haru_get_user_ip();
         
        // If user has already voted
        if ( in_array($ip, array_keys($voted_IP)) ) {
            $time = $voted_IP[$ip];
            $now = time();
             
            // Compare between current time and vote time
            if ( round(($now - $time) / 60) > $timebeforerevote )
                return false;
                 
            return true;
        }
         
        return false;
    }
}

if ( !function_exists('haru_format_count_number') ) {
    function haru_format_count_number($number) {
        $precision = 3;

        if ( $number >= 1000 && $number < 1000000 ) {
            $formatted = number_format( $number/1000, $precision ) . esc_html__( 'K', 'haru-vidi' );
        } else if ( $number >= 1000000 && $number < 1000000000 ) {
            $formatted = number_format( $number/1000000, $precision ) . esc_html__( 'M', 'haru-vidi' );
        } else if ( $number >= 1000000000 ) {
            $formatted = number_format( $number/1000000000, $precision ) . esc_html__( 'B', 'haru-vidi' );
        } else {
            $formatted = $number; // Number is less than 1000
        }

        $formatted = str_replace( '.00', '', $formatted );

        return $formatted;
    }
}

if ( !function_exists('haru_display_rating') ) {
    function haru_display_rating($post_id) {
        // Retrieve user IP address
        $ip = haru_get_user_ip();

        $meta_IP = get_post_meta($post_id, '_voted_IP');
        if ( !empty( $meta_IP ) ) {
            $voted_IP = $meta_IP[0];
        } else {
            $voted_IP = array();
        }

        $vote_status = '';
        // If user has already voted
        if ( in_array($ip, array_keys($voted_IP)) ) {
            $vote_status = $voted_IP[$ip];
        }

        $post_like_count = (int)get_post_meta( $post_id, '_post_like_count', true );
        $post_dislike_count = (int)get_post_meta( $post_id, '_post_dislike_count', true );
        // Check if haven't vote yet
        if ( !isset($post_like_count) ) $post_like_count = 0;
        if ( !isset($post_dislike_count) ) $post_dislike_count = 0;

        // Fake Like
        $fake_like_dislike = get_post_meta($post_id, 'haru_fake_like_dislike', true);
        $fake_like_count = (int)get_post_meta($post_id, 'haru_fake_like_count', true);
        $fake_dislike_count = (int)get_post_meta($post_id, 'haru_fake_dislike_count', true);

        if ( $fake_like_dislike == 'on' ) {
            $post_like_count += $fake_like_count; // Initial like count
            $post_dislike_count += $fake_dislike_count;
        }

        $like_click_message = esc_html__( 'Click to like this', 'haru-vidi' );
        $liked_message = esc_html__( 'You has just liked', 'haru-vidi' );
        $dislike_click_message = esc_html__( 'Click to dislike this', 'haru-vidi' );
        $disliked_message = esc_html__( 'You has just disliked', 'haru-vidi' );

        $login_required = 'yes'; // @TODO
        if ( $login_required == 'yes' && !is_user_logged_in() ) {
            $vote_status = '';
            $like_click_message = esc_html__( 'Please login to vote', 'haru-vidi' );
            $liked_message = esc_html__( 'Please login to vote', 'haru-vidi' );
            $dislike_click_message = esc_html__( 'Please login to vote', 'haru-vidi' );
            $disliked_message = esc_html__( 'Please login to vote', 'haru-vidi' );
        }

        ?>
        <div class="post-rating">
            <div class="post-rating__action">
                <div class="toolbar-action toolbar-action--background action-rating post-like <?php echo esc_attr( ($vote_status == 'like') ? 'active' : '' ); ?>" data-id="<?php echo esc_attr( $post_id ); ?>" data-action="like" data-vote-status="<?php echo esc_attr( $vote_status ); ?>" data-login="<?php echo esc_attr( is_user_logged_in() == true ? 'true' : 'false' ); ?>" data-login-required="<?php echo esc_attr( $login_required ); ?>"><i class="haru-icon haru-like"></i><span class="post-like-count"><?php echo haru_format_count_number( $post_like_count ); ?> </span><span class="rating-label"><?php echo esc_html__( 'Like', 'haru-vidi' ); ?></span>
                    <span class="haru-tooltip like-tooltip"><?php echo ( $vote_status == 'like' ? $liked_message : $like_click_message ); ?></span>
                </div>
                <div class="toolbar-action toolbar-action--background action-rating post-dislike <?php echo esc_attr( ($vote_status == 'dislike') ? 'active' : '' ); ?>" data-id="<?php echo esc_attr( $post_id ); ?>" data-action="dislike" data-vote-status="<?php echo esc_attr( $vote_status ); ?>" data-login="<?php echo esc_attr( is_user_logged_in() == true ? 'true' : 'false' ); ?>" data-login-required="<?php echo esc_attr( $login_required ); ?>"><i class="haru-icon haru-dislike"></i><span class="post-dislike-count"><?php echo haru_format_count_number( $post_dislike_count ); ?> </span><span class="rating-label"><?php echo esc_html__( 'Dislike', 'haru-vidi' ); ?></span>
                    <span class="haru-tooltip dislike-tooltip"><?php echo ( $vote_status == 'dislike' ? $disliked_message : $dislike_click_message ); ?></span>
                </div>
            </div>
            
        </div>
        <?php
    }
}

if ( !function_exists('haru_display_like_count') ) {
    function haru_display_like_count($post_id) {
        $post_like_count = (int)get_post_meta( $post_id, '_post_like_count', true );
        // Check if haven't vote yet
        if ( !isset($post_like_count) ) $post_like_count = 0;

        // Fake Like
        $fake_like_dislike = get_post_meta($post_id, 'haru_fake_like_dislike', true);
        $fake_like_count = (int)get_post_meta($post_id, 'haru_fake_like_count', true);
        if ( !isset($fake_like_count) ) $fake_like_count = 0;

        if ( $fake_like_dislike == 'on' ) {
            $post_like_count += $fake_like_count; // Initial like count
        }
        ?>
        <div class="post-like">
            <span class="post-vote-label"><?php echo esc_html__( 'like', 'haru-vidi' ); ?></span>
            <i class="haru-icon haru-like"></i>
            <span class="post-like-count"><?php echo haru_format_count_number( $post_like_count ); ?></span>
            <span class="post-like-unit"><?php echo ( $post_like_count > 1 ) ? esc_html__( ' likes', 'haru-vidi' ) : esc_html__( ' like', 'haru-vidi' ); ?></span>
        </div>
        <?php
    }
}

if ( !function_exists('haru_display_dislike_count') ) {
    function haru_display_dislike_count($post_id) {
        $post_dislike_count = (int)get_post_meta( $post_id, '_post_dislike_count', true );
        // Check if haven't vote yet
        if ( !isset($post_dislike_count) ) $post_dislike_count = 0;

        // Fake Like
        $fake_like_dislike = get_post_meta($post_id, 'haru_fake_like_dislike', true);
        $fake_dislike_count = (int)get_post_meta($post_id, 'haru_fake_dislike_count', true);

        if ( $fake_like_dislike == 'on' ) {
            $post_dislike_count += $fake_dislike_count;
        }
        
        ?>
        <div class="post-dislike">
            <span class="post-vote-label"><?php echo esc_html__( 'dislike', 'haru-vidi' ); ?></span>
            <i class="haru-icon haru-dislike"></i>
            <span class="post-dislike-count"><?php echo haru_format_count_number( $post_dislike_count ); ?></span>
            <span class="post-dislike-unit"><?php echo ( $post_dislike_count > 1 ) ? esc_html__( ' dislikes', 'haru-vidi' ) : esc_html__( ' dislike', 'haru-vidi' ); ?></span>
        </div>
        <?php
    }
}

if ( !function_exists('haru_display_rating_bar') ) {
    function haru_display_rating_bar($post_id) {
        // Retrieve user IP address
        $ip = haru_get_user_ip();

        $meta_IP = get_post_meta($post_id, '_voted_IP');
        if ( !empty( $meta_IP ) ) {
            $voted_IP = $meta_IP[0];
        } else {
            $voted_IP = array();
        }

        $vote_status = '';
        // If user has already voted
        if ( in_array($ip, array_keys($voted_IP)) ) {
            $vote_status = $voted_IP[$ip];
        }

        $post_like_count = (int)get_post_meta( $post_id, '_post_like_count', true );
        $post_dislike_count = (int)get_post_meta( $post_id, '_post_dislike_count', true );
        // Fake Like
        $fake_like_dislike = get_post_meta($post_id, 'haru_fake_like_dislike', true);
        $fake_like_count = (int)get_post_meta($post_id, 'haru_fake_like_count', true);
        $fake_dislike_count = (int)get_post_meta($post_id, 'haru_fake_dislike_count', true);

        // Check if haven't vote yet
        if ( !isset($post_like_count) ) $post_like_count = 0;
        if ( !isset($post_dislike_count) ) $post_dislike_count = 0;

        if ( $fake_like_dislike == 'on' ) {
            $post_like_count += $fake_like_count; // Initial like count
            $post_dislike_count += $fake_dislike_count;
        }
    ?>
        <div class="post-rating-bar">
            <div class="post-rating-percentage" style="width: <?php echo esc_attr( haru_get_like_percentage($post_like_count, $post_dislike_count) ); ?>;"></div>
        </div>
    <?php
    }
}

if ( !function_exists('haru_get_like_percentage') ) {
    function haru_get_like_percentage($like, $dislike) {
        $precision = 6;

        if ( $like == 0 ) {
            return '0';
        }

        return number_format(($like * 100)/($like + $dislike), $precision) . '%';
    }
}

// @TODO: move to other file
if ( !function_exists('haru_get_post_views') ) {
    function haru_get_post_views($post_id) {
        // Use Post View Counter plugin
        if ( class_exists( 'Post_Views_Counter' ) ) :
            $views = pvc_get_post_views( $post_id ); // includes/functions.php
            $fake_view = get_post_meta($post_id, 'haru_fake_view', true);
            $fake_view_count = (int)get_post_meta($post_id, 'haru_fake_view_count', true);

            if ( $fake_view == 'on' ) {
                $views += $fake_view_count;
            }

            // Update view total only on single page
            if ( is_singular() ) {
                update_post_meta($post_id, '_post_view_count_total', $views);
            }

            if ( $views > 1 ) {
                $view_text = esc_html__(' views', 'haru-vidi');
            } else {
                $view_text = esc_html__(' view', 'haru-vidi');
            }
        ?>
        <div class="post-views-count">
            <span class="post-views-label"><?php echo esc_html__( 'views', 'haru-vidi' ); ?></span>
            <i class="fa fa-eye"></i>
            <span class="post-view-count"><?php echo haru_format_count_number( $views ); ?></span>
            <span class="post-view-unit"><?php echo esc_html( $view_text ); ?></span>
        </div>
        <?php
        endif;
    }
}

