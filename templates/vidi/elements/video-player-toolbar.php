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

<div class="video-toolbar">
    <div class="video-toolbar-actions">
        <?php 
            /**
             * haru_video_player_toolbar_group hook.
             *
             * @hooked haru_video_player_toolbar_action_rating - 5
             * @hooked haru_video_player_toolbar_action_watch_later - 10
             * @hooked haru_video_player_toolbar_action_report - 15
             * @hooked haru_video_player_toolbar_action_light - 20
             * @hooked haru_video_player_toolbar_action_share - 20
             * @hooked haru_video_player_toolbar_action_next_prev - 25
             * @hooked haru_video_player_toolbar_action_more - 30
             * @hooked haru_video_player_toolbar_action_auto_next - 35
             */
            do_action( 'haru_video_player_toolbar_action' ); 
        ?>
    </div>

    <?php 
        /**
         * haru_video_player_toolbar_group hook.
         *
         * @hooked haru_video_player_toolbar_group_report - 5
         * @hooked haru_video_player_toolbar_group_more - 10
         */
        do_action( 'haru_video_player_toolbar_group' ); 
    ?>
</div>

