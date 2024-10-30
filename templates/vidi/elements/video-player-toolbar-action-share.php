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
<div class="toolbar-action toolbar-action--background single-video-share">
	<i class="haru-icon haru-share"></i><?php echo esc_html__( 'Share', 'haru-vidi' ); ?>
	<div class="video-social-share">
        <?php include(haru_vidi_posttype_get_template('vidi/'. 'social-share' . '.php', array(), '', '')); ?>
    </div>
</div>
