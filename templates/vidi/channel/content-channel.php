<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Channel Style
$channel_class = 'default';
if ( isset( $channel_style ) ) {
    $channel_class = $channel_style;
}

if ( !isset( $channel_style ) ) {
    $channel_style = 'default';
}

// Edit Channel
if ( isset( $can_edit ) ) {
    $haru_submit_channel_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_submit_channel_page', '' );
    $haru_submit_channel_page_url = ( $haru_submit_channel_page != '' && is_numeric( $haru_submit_channel_page ) ) ? get_permalink( $haru_submit_channel_page ) :  get_permalink( get_page_by_path( 'submit-channel' ) );
    $haru_edit_channel_url = $haru_submit_channel_page_url . '?channel_edit=' . get_the_ID();
}

?>
<article class="grid-item channel-item <?php echo esc_attr( $channel_class ); ?>">
    <div class="channel-item__thumbnail">
        <a href="<?php echo esc_url( get_permalink() ); ?>">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail(); ?>
            <?php else : ?>
                <img src="<?php echo esc_url( PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
            <?php endif; ?>
        </a>
        <div class="channel-item__icon">
            <a href="<?php echo esc_url( get_permalink() ); ?>" class="channel-player-direct"></a>
        </div>
        
        <?php if ( isset( $can_edit ) && ( $haru_submit_channel_page_url != '' ) ) : ?>
            <div class="channel-item__edit">
                <a href="<?php echo esc_url( $haru_edit_channel_url ); ?>"><i class="haru-icon haru-edit"></i><?php echo esc_html__( 'Edit Channel', 'haru-vidi' ); ?></a>
            </div>
        <?php endif; ?>

        <?php if ( !in_array($channel_style, array('channel-style-2', 'channel-style-7', 'channel-style-8') ) ) : ?>
        <div class="channel-item__subscribe">
            <?php echo haru_channel_subscribe_button( get_the_ID() ); ?>
        </div>
        <?php endif; ?>

        <?php if ( isset( $can_edit ) && ( $haru_submit_channel_page_url != '' ) ) : ?>
            <div class="channel-item__edit">
                <a href="<?php echo esc_url( $haru_edit_channel_url ); ?>"><i class="haru-icon haru-edit"></i><?php echo esc_html__( 'Edit Channel', 'haru-vidi' ); ?></a>
            </div>
        <?php endif; ?>
    </div>
    <div class="channel-item__content">
        <h6 class="channel-item__title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_title(); ?></a></h6>
        <div class="channel-item__category"><?php echo get_the_term_list( get_the_ID(), 'channel_category', '', ', ' ); ?></div>
        <div class="channel-item__meta">
            <div class="channel-item__author">
                <i class="fa fa-user"></i>
                <?php
                    if ( function_exists('bp_is_active') ) {
                        echo bp_core_get_userlink( get_the_author_meta('ID') );
                    } else {
                        printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                    }
                ?>
            </div>
            <div class="channel-item__date"><i class="fa fa-calendar"></i><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
            <div class="channel-item__like"><?php haru_display_like_count( get_the_ID() ); ?></div>
            <div class="channel-item__dislike"><?php haru_display_dislike_count( get_the_ID() ); ?></div>
            <div class="channel-item__view"><?php haru_get_post_views( get_the_ID() ); ?></div>
            <div class="channel-item__videos-count"><?php echo haru_count_channel_videos( get_the_ID() ); ?></div>
            <div class="channel-item__count-subscribed">
                <?php echo haru_count_channel_subscribed( get_the_ID(), true ); ?>
            </div>
        </div>
        <div class="channel-item__desc">
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

    <?php if ( in_array($channel_style, array('channel-style-2', 'channel-style-7', 'channel-style-8') ) ) : ?>
    <div class="channel-item__subscribe-2">
        <?php echo haru_channel_subscribe_button( get_the_ID() ); ?>
    </div>
    <?php endif; ?>
</article>
