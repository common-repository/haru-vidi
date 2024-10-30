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
<div class="watch-later-element">
    <?php
        global $watch_later_cookie;

        if ( !isset( $watch_later_cookie ) || !is_array( $watch_later_cookie ) ) {
            $watch_later_cookie = array();
        }

        $haru_watch_later_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_watch_later_page', '' );
        $haru_watch_later_page_url = ( $haru_watch_later_page != '' && is_numeric( $haru_watch_later_page ) ) ? get_permalink( $haru_watch_later_page ) :  get_permalink( get_page_by_path( 'watch-later' ) );
    ?>
    <a href="javascript:;" class="watch-later-page-link">
        <span class="watch-later-icon">
            <i class="haru-icon haru-clock-o"></i>
            <span class="watch-later-status <?php echo ( ( count( $watch_later_cookie ) > 0 ) != '' ? 'has-videos ' : '' ); ?>"></span>
        </span>
    </a>
    <?php do_action( 'haru_watch_later_videos' ); ?>
</div>
