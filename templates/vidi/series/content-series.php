<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Series Style
$series_class = 'default';

if ( isset( $series_style ) ) {
    $series_class = $series_style;
}

// Edit Series
if ( isset( $can_edit ) ) {
    $haru_submit_series_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_submit_series_page', '' );
    $haru_submit_series_page_url = ( $haru_submit_series_page != '' && is_numeric( $haru_submit_series_page ) ) ? get_permalink( $haru_submit_series_page ) :  get_permalink( get_page_by_path( 'submit-series' ) );
    $haru_edit_series_url = $haru_submit_series_page_url . '?series_edit=' . get_the_ID();
}

?>
<article class="grid-item series-item <?php echo esc_attr( $series_class ); ?>">
    <div class="series-item__thumbnail">
        <a href="<?php echo esc_url( get_permalink() ); ?>">
            <?php haru_series_thumbnail( get_the_ID() ); ?>
            <div class="series-item__count-video"><?php echo haru_count_series_videos( get_the_ID() ); ?></div>
        </a>
        <div class="series-item__icon">
            <a href="<?php echo esc_url( get_permalink() ); ?>" class="series-player-direct">
                <i class="haru-icon haru-play"></i>
            </a>
        </div>
        <?php if ( isset( $can_edit ) && ( $haru_submit_series_page_url != '' ) ) : ?>
            <div class="series-item__edit">
                <a href="<?php echo esc_url( $haru_edit_series_url ); ?>"><i class="haru-icon haru-edit"></i><?php echo esc_html__( 'Edit Series', 'haru-vidi' ); ?></a>
            </div>
        <?php endif; ?>
    </div>
    <div class="series-item__content">
        <h6 class="series-item__title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_title(); ?></a></h6>
        <div class="series-item__category"><?php echo get_the_term_list( get_the_ID(), 'series_category', '', ', ' ); ?></div>
        <div class="series-item__meta">
            <div class="series-item__author">
                <i class="fa fa-user"></i>
                <?php
                    if ( function_exists('bp_is_active') ) {
                        echo bp_core_get_userlink( get_the_author_meta('ID') );
                    } else {
                        printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                    }
                ?>
            </div>
            <div class="series-item__date"><i class="fa fa-calendar"></i><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
            <div class="series-item__like"><?php haru_display_like_count( get_the_ID() ); ?></div>
            <div class="series-item__dislike"><?php haru_display_dislike_count( get_the_ID() ); ?></div>
            <div class="series-item__view"><?php haru_get_post_views( get_the_ID() ); ?></div>
        </div>
        <div class="series-item__desc">
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
