<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

global $watch_later_cookie;

$watch_later_active = '';

if ( !isset( $watch_later_cookie ) || !is_array( $watch_later_cookie ) ) {
    $watch_later_cookie = array();
}               

if ( array_search( get_the_ID(), $watch_later_cookie ) !== false ) {
    $watch_later_active = 'active ';
}
?>
<div class="toolbar-action toolbar-action--background video-watch-later <?php echo esc_attr( $watch_later_active ); ?>"
    data-id="<?php echo esc_attr( get_the_ID() ); ?>"
    data-title="<?php the_title(); ?>"
    data-permalink="<?php echo esc_url( get_the_permalink() ); ?>"
    data-thumb="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>"
>
    <i class="haru-icon haru-clock"></i>
    <?php echo esc_html__( 'Watch Later', 'haru-vidi' ); ?>
</div>

