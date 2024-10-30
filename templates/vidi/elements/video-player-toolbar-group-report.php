<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/


// Group Report
$report_status = haru_video_report_check( get_the_ID() );
$report_notice = '';

if ( !is_user_logged_in() ) {
    $report_notice = esc_html__( 'Please login to report!', 'haru-vidi' );
} else {
    if ( $report_status == true ) {
        $report_notice = esc_html__( 'You already reported this video!', 'haru-vidi' );
    } else {
        $report_notice = esc_html__( 'Please tell us the reason you want to report.', 'haru-vidi' );
    }
}
?>

<div class="toolbar-group video-report-group">
    <div class="video-report-form <?php echo haru_video_report_check( get_the_ID() ) == true ? 'reported' : ''; ?>">
        <div class="video-report-notice"><?php echo esc_html( $report_notice ); ?></div>

        <?php if ( is_user_logged_in() ) : ?>
        <div class="video-report-reason">
            <textarea maxlength="150" class="video-report-content" placeholder="<?php echo esc_attr__( 'Maximum length 150 characters', 'haru-vidi' ); ?>"></textarea>
        </div>
        <div class="video-report-submit">
            <a href="javascript:;" class="video-report-button button-background button-background--primary button-background--medium" data-video_id="<?php echo esc_attr( get_the_ID() )?>"><?php echo esc_html__( 'Send Report', 'haru-vidi' ); ?></a>
        </div>
        <!-- @TODO: show login button -->
        <?php endif; ?>
    </div>
</div>

