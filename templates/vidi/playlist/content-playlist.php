<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Playlist Style
$playlist_class = 'default';

if ( isset( $playlist_style ) ) {
    $playlist_class = $playlist_style;
}

// Edit Playlist
if ( isset( $can_edit ) ) {
    $haru_submit_playlist_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_submit_playlist_page', '' );
    $haru_submit_playlist_page_url = ( $haru_submit_playlist_page != '' && is_numeric( $haru_submit_playlist_page ) ) ? get_permalink( $haru_submit_playlist_page ) :  get_permalink( get_page_by_path( 'submit-playlist' ) );
    $haru_edit_playlist_url = $haru_submit_playlist_page_url . '?playlist_edit=' . get_the_ID();
}

?>
<article class="grid-item playlist-item <?php echo esc_attr( $playlist_class ); ?>">
    <div class="playlist-item__thumbnail">
        <a href="<?php echo esc_url( get_permalink() ); ?>">
            <?php haru_playlist_thumbnail( get_the_ID() ); ?>
            <div class="playlist-item__count-video"><?php echo haru_count_playlist_videos( get_the_ID() ); ?></div>
        </a>
        <div class="playlist-item__icon">
            <a href="<?php echo esc_url( get_permalink() ); ?>" class="playlist-player-direct">
                <i class="haru-icon haru-play"></i>
            </a>
        </div>
        <?php if ( isset( $can_edit ) && ( $haru_submit_playlist_page_url != '' ) ) : ?>
            <div class="playlist-item__edit">
                <a href="<?php echo esc_url( $haru_edit_playlist_url ); ?>"><i class="haru-icon haru-edit"></i><?php echo esc_html__( 'Edit Playlist', 'haru-vidi' ); ?></a>
            </div>
        <?php endif; ?>
    </div>
    <div class="playlist-item__content">
        <h6 class="playlist-item__title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_title(); ?></a></h6>
        <div class="playlist-item__category"><?php echo get_the_term_list( get_the_ID(), 'playlist_category', '', ', ' ); ?></div>
        <div class="playlist-item__meta">
            <div class="playlist-item__author">
                <i class="far fa-user"></i>
                <?php
                    if ( function_exists('bp_is_active') ) {
                        echo bp_core_get_userlink( get_the_author_meta('ID') );
                    } else {
                        printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                    }
                ?>
            </div>
            <div class="playlist-item__date"><i class="fa fa-calendar"></i><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
            <div class="playlist-item__like"><?php haru_display_like_count( get_the_ID() ); ?></div>
            <div class="playlist-item__dislike"><?php haru_display_dislike_count( get_the_ID() ); ?></div>
            <div class="playlist-item__view"><?php haru_get_post_views( get_the_ID() ); ?></div>
        </div>
        <div class="playlist-item__desc">
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
