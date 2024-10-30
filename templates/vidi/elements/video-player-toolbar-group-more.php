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

<!-- Group more -->
<div class="toolbar-group video-more-group">
    <div class="haru-slick-wrap">
        <div class="related-list haru-slick-more-videos"
            data-slick='{"slidesToShow" : 4, "slidesToScroll" : 1, "arrows" : true, "infinite" : true, "centerMode" : false, "focusOnSelect" : false, "vertical" : false, "responsive" : [{"breakpoint": 767,"settings":{"slidesToShow": 2}}] }'
        >
            <?php 
                // Get video more by category
                $custom_taxterms = wp_get_object_terms( get_the_ID(), 'video_category', array('fields' => 'ids') );

                $video_args = array(
                    'post__not_in'       => array( get_the_ID() ),
                    'posts_per_page'     => 6,
                    'orderby'            => 'rand',
                    'post_type'          => 'haru_video',
                    'post_status'        => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'video_category',
                            'field' => 'id',
                            'terms' => $custom_taxterms
                        )
                    ),

                );
                $more_videos         = new WP_Query( $video_args );
            ?>
            <?php 
                if ( $more_videos->have_posts() ) :
                    while ( $more_videos->have_posts() ) : $more_videos->the_post();
                        echo haru_vidi_get_shortcode_template('vidi/video/'. 'content-video' . '.php', array(), '', '');
                    endwhile;
                endif;
                wp_reset_query();
            ?>
        </div>
    </div>
</div>

