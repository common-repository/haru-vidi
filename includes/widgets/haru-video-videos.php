<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

defined( 'ABSPATH' ) || exit;

class Haru_Video_Videos_Widget extends Haru_Vidi_Widget {

    /**
     * Constructor.
     */

    public function __construct() {
        $this->widget_cssclass    = 'widget-video-videos';
        $this->widget_description = esc_html__( 'Widget display videos.', 'haru-vidi' );
        $this->widget_id          = 'haru_widget_video_videos';
        $this->widget_name        = esc_html__( 'Haru Videos', 'haru-vidi' );
        $this->cached             = false;
        $this->settings = array(
            'title'         => array(
                'type'  => 'text',
                'std'   => esc_html__( 'Videos', 'haru-vidi' ),
                'label' => esc_html__( 'Title', 'haru-vidi' )
            ),
            'style'         => array(
                'type'    => 'select',
                'std'     => 'default',
                'label'   => esc_html__( 'Style', 'haru-vidi' ),
                'options' => array(
                    'default' => esc_html__( 'Default', 'haru-vidi' ),
                    'style-1' => esc_html__( 'Background Dark', 'haru-vidi' ),
                )
            ),
            'number'      => array(
                'type'  => 'number',
                'step'  => 1,
                'min'   => 1,
                'max'   => '',
                'std'   => 5,
                'label' => esc_html__( 'Number of videos to show', 'haru-vidi' ),
            ),
            'orderby'     => array(
                'type'    => 'select',
                'std'     => 'date',
                'label'   => esc_html__( 'Order by', 'haru-vidi' ),
                'options' => array(
                    'date'  => esc_html__( 'Date', 'haru-vidi' ),
                    'title' => esc_html__( 'Title', 'haru-vidi' ),
                    'rand'  => esc_html__( 'Random', 'haru-vidi' ),
                ),
            ),
            'order'       => array(
                'type'    => 'select',
                'std'     => 'desc',
                'label'   => _x( 'Order', 'Sorting order', 'haru-vidi' ),
                'options' => array(
                    'asc'  => esc_html__( 'ASC', 'haru-vidi' ),
                    'desc' => esc_html__( 'DESC', 'haru-vidi' ),
                ),
            ),
            'hide_author' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => esc_html__( 'Hide author meta info', 'haru-vidi' )
            ),
            'hide_views' => array(
                'type'  => 'checkbox',
                'std'   => 0,
                'label' => esc_html__( 'Hide views meta info', 'haru-vidi' )
            ),
        );

        parent::__construct();
    }
    
    public function widget( $args, $instance ) {
        // global $wp_query;

        ob_start();
        extract( $args );

        $title          = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
        $style          = isset( $instance['style'] ) ? $instance['style'] : $this->settings['style']['std'];
        $number         = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
        $orderby        = ! empty( $instance['orderby'] ) ? sanitize_title( $instance['orderby'] ) : $this->settings['orderby']['std'];
        $order          = ! empty( $instance['order'] ) ? sanitize_title( $instance['order'] ) : $this->settings['order']['std'];

        $query_args = array(
            'posts_per_page' => $number,
            'post_status'    => 'publish',
            'post_type'      => 'haru_video',
            'no_found_rows'  => 1,
            'order'          => $order,
            'meta_query'     => array(),
            'tax_query'      => array(
                'relation' => 'AND',
            ),
        ); // WPCS: slow query ok.

        switch ( $orderby ) {
            case 'title':
                $query_args['orderby']  = 'title';
                break;
            case 'rand':
                $query_args['orderby'] = 'rand';
                break;
            default:
                $query_args['orderby'] = 'date';
        }

        $videos = new WP_Query( $query_args );

        if ( $videos && $videos->have_posts() ) :
            echo $before_widget;
                if ( $title ) echo $before_title . $title . $after_title;
                echo '<ul class="videos-list ' . esc_attr( $style ) . '">';
                while ( $videos->have_posts() ) : $videos->the_post();
                    echo haru_vidi_get_shortcode_template('vidi/widgets/'. 'widget-video-videos' . '.php', $instance, '', '');
                endwhile;
                echo  '</ul>';
            echo $after_widget;
        endif;

        $content = ob_get_clean();
        wp_reset_postdata();
        echo $content;
    }

}
if ( !function_exists( 'haru_register_widget_video_videos' ) ) {
    function haru_register_widget_video_videos() {
        register_widget( 'Haru_Video_Videos_Widget' );
    }
    add_action( 'widgets_init', 'haru_register_widget_video_videos' );
}