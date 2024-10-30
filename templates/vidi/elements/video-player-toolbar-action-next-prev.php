<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$next_video = haru_get_next_video_url( get_the_ID() );
$prev_video = haru_get_prev_video_url( get_the_ID() );

if ( !empty($prev_video) && $prev_video['link'] != '' ) : ?>
<div class="toolbar-action toolbar-action--border video-prev">
    <a href="<?php echo esc_url( $prev_video['link'] ); ?>"><i class="haru-icon haru-fast-backward"></i><?php echo esc_html__( 'Prev', 'haru-vidi' ); ?></a>
</div>
<?php endif; ?>
<?php if ( !empty($next_video) && $next_video['link'] != '' ) : ?>
<div class="toolbar-action toolbar-action--border video-next">
    <a href="<?php echo esc_url( $next_video['link'] ); ?>"><?php echo esc_html__( 'Next', 'haru-vidi' ); ?><i class="haru-icon haru-fast-forward"></i></a>
</div>
<?php endif;
