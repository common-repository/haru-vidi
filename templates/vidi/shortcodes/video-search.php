<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$shortcode_id = 'video-search-shortcode' . rand();

global $video_search_form_index;

if ( empty( $video_search_form_index ) ) {
    $video_search_form_index = 0;
}

$index = $video_search_form_index++;
?>
<div class="video-search-shortcode style-<?php echo esc_attr( $layout . ' ' . $extra_class); ?>">
    <?php if ( $layout == 'default' ) : ?>
    <form role="search" method="get" class="haru-video-search search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <label for="haru-video-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>">
            <span class="screen-reader-text"><?php echo esc_html__( 'Search for:', 'haru-vidi' ); ?></span>
            <input type="search" id="haru-video-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field" placeholder="<?php echo esc_attr__( 'Search videos&hellip;', 'haru-vidi' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        </label>
        <button type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'haru-vidi' ); ?>">
            <span><?php echo esc_html_x( 'Search', 'submit button', 'haru-vidi' ); ?></span>
        </button>
        <input type="hidden" name="post_type" value="haru_video" />
    </form>
    <?php elseif ( $layout == 'button' ) : ?>
    <a href="javascript:;" class="video-search-button" data-effect="search-zoom-in"><i class="haru-icon haru-search"></i></a>
    <div id="video-search-popup-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="video-search-popup white-popup mfp-hide mfp-with-anim">
        <form role="search" method="get" class="haru-video-search search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <label for="haru-video-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>">
                <span class="screen-reader-text"><?php echo esc_html__( 'Search for:', 'haru-vidi' ); ?></span>
                <input type="search" id="haru-video-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field" placeholder="<?php echo esc_attr__( 'Search videos&hellip;', 'haru-vidi' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
            </label>
            <button type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'haru-vidi' ); ?>">
                <span><?php echo esc_html_x( 'Search', 'submit button', 'haru-vidi' ); ?></span>
            </button>
            <input type="hidden" name="post_type" value="haru_video" />
        </form>
    </div>
    <?php endif; ?>
</div>
