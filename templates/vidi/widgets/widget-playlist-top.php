<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// @TODO
$hide_date = 1;
$hide_vote = 1;
?>
<li class="playlist-item clearfix">
    <div class="playlist-item__thumbnail">
    	<a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo get_the_post_thumbnail( null, 'thumbnail', array( 'title' => strip_tags( get_the_title() ) ) ); ?></a>
    </div>
    <div class="playlist-item__content">
    	<h6 class="playlist-item__title"><a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo get_the_title(); ?></a></h6>
    	<div class="playlist-item__meta">
    		<?php if ( $hide_author != '1' ) : ?>
	    	<div class="playlist-item__author"><i class="fa fa-user"></i><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo esc_html( get_the_author() ); ?></a></div>
	    	<?php endif; ?>
	    	<?php if ( $hide_date != '1' ) : ?>
	    	<div class="playlist-item__date"><i class="fa fa-calendar"></i><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
	    	<?php endif; ?>
	    	<div class="playlist-item__count-videos"><?php echo haru_count_playlist_videos( get_the_ID() ); ?></div>
	    	<?php if ( $hide_vote != '1' ) : ?>
	    	<div class="playlist-item__like"><?php haru_display_like_count( get_the_ID() ); ?></div>
	    	<div class="playlist-item__dislike"><?php haru_display_dislike_count( get_the_ID() ); ?></div>
	    	<?php endif; ?>
	    	<?php if ( $hide_views != '1' ) : ?>
	    	<div class="playlist-item__view"><?php echo haru_get_post_views( get_the_ID() ); ?></div>
	    	<?php endif; ?>
    	</div>
    </div>
</li>
