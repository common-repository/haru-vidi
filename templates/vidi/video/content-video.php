<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Video URL
$video_url = get_permalink();

$series_slug = haru_vidi_get_series_slug();
if ( isset( $series_id ) ) {
    $video_url = get_permalink() . '?' . $series_slug . '=' . $series_id;
}

$playlist_slug = haru_vidi_get_playlist_slug();
if ( isset( $playlist_id ) ) {
    $video_url = get_permalink() . '?' . $playlist_slug . '=' . $playlist_id;
}

$actor_slug = haru_vidi_get_actor_slug();
if ( isset( $actor_id ) ) {
    $video_url = get_permalink() . '?' . $actor_slug . '=' . $actor_id;
}

$director_slug = haru_vidi_get_director_slug();
if ( isset( $director_id ) ) {
    $video_url = get_permalink() . '?' . $director_slug . '=' . $director_id;
}

// Video Style
$video_class = 'default';
if ( isset( $video_style ) ) {
    $video_class = $video_style;
}

$terms = wp_get_post_terms( get_the_ID(), array('video_category') );
$filter_slug = '';
foreach ( $terms as $term ) {
    $filter_slug .= $term->slug . ' ';
}

$player_settings_popup = haru_vidi_get_setting( 'vidi-general-settings', 'player_settings_popup', 'off' );

// Edit Video
if ( isset( $can_edit ) ) {
    $haru_submit_video_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_submit_video_page', '' );
    $haru_submit_video_page_url = ( $haru_submit_video_page != '' && is_numeric( $haru_submit_video_page ) ) ? get_permalink( $haru_submit_video_page ) :  get_permalink( get_page_by_path( 'submit-video' ) );
    $haru_edit_video_url = $haru_submit_video_page_url . '?video_edit=' . get_the_ID();
}

?>
<article class="grid-item video-item video-<?php echo esc_attr( get_the_ID() ); ?> <?php echo esc_attr( $filter_slug . ' ' . $video_class ); ?>">
    <div class="video-item__thumbnail" <?php if ( $player_settings_popup == 'on' ) : ?> onclick="void(0)" <?php endif; ?>>
        <?php if ( $player_settings_popup != 'on' ) : ?>
        <a href="<?php echo esc_url( $video_url ); ?>">
        <?php endif; ?>    
            <?php haru_video_thumbnail( get_the_ID() ); ?>
        <?php if ( $player_settings_popup != 'on' ) : ?>
        </a>
        <?php endif; ?>
        <div class="video-item__icon">
            <?php if ( $player_settings_popup != 'on' ) : ?>
            <a href="<?php echo esc_url( $video_url ); ?>" class="video-item-player-direct">
                <i class="haru-icon haru-play"></i>
            </a>
            <?php else : ?>
            <a href="javascript:;" class="video-item-player-popup" data-id="<?php echo esc_attr( get_the_ID() ); ?>">
                <i class="haru-icon haru-play"></i>
            </a>
            <?php endif; ?>
        </div>
        <?php echo haru_vidi_get_shortcode_template('vidi/elements/'. 'video-player-toolbar-action-watch-later' . '.php', array(), '', ''); ?>
        <?php if ( isset( $can_edit ) && ( $haru_submit_video_page_url != '' ) ) : ?>
            <div class="video-item__edit">
                <a href="<?php echo esc_url( $haru_edit_video_url ); ?>"><i class="haru-icon haru-edit"></i><?php echo esc_html__( 'Edit Video', 'haru-vidi' ); ?></a>
            </div>
        <?php endif; ?>
        <div class="video-item__duration"><?php echo esc_html( get_post_meta(get_the_ID(), 'haru_video_duration', true) ); ?></div>
        <?php
            $video_labels = get_the_terms( get_the_ID(), 'video_label');
            if ( !empty( $video_labels ) ) :
        ?>
        <div class="video-item__labels">
            <?php foreach ( $video_labels as $label ) : 
                $bg_color = get_term_meta( $label->term_id, 'haru_video_label_background', true );
            ?>
            <div class="video-item__label" style="background-color: <?php echo esc_attr( $bg_color ? $bg_color : 'transparent' ); ?>"><?php echo esc_html( $label->name ); ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="video-item__content">
        <div class="video-item__category"><?php echo get_the_term_list( get_the_ID(), 'video_category', '', ', ' ); ?></div>
        <h6 class="video-item__title"><a href="<?php echo esc_url( $video_url ); ?>"><?php echo get_the_title(); ?></a></h6>
        <div class="video-item__meta">
            <div class="video-item__author">
                <i class="fa fa-user"></i>
                <?php
                    if ( function_exists('bp_is_active') ) {
                        echo bp_core_get_userlink( get_the_author_meta('ID') );
                    } else {
                        printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                    }
                ?>
            </div>
            <div class="video-item__date"><i class="fa fa-calendar"></i><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
            <div class="video-item__like"><?php haru_display_like_count( get_the_ID() ); ?></div>
            <div class="video-item__dislike"><?php haru_display_dislike_count( get_the_ID() ); ?></div>
            <div class="video-item__view"><?php haru_get_post_views( get_the_ID() ); ?></div>
        </div>
        <div class="video-item__desc">
            <?php 
                $excerpt_length = 20;
                if ( has_excerpt() ) {
                    echo wp_trim_words( get_the_excerpt(), $excerpt_length, '...' );
                } else {
                    echo wp_trim_words( get_the_content(), $excerpt_length, '...' ); 
                }
            ?>
        </div>
    </div>
</article>
