<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/


get_header();
?>
<div class="haru-single-breadcrumbs">
    <div class="haru-container">
        <?php echo haru_vidi_cpt_breadcrumbs(); ?>
    </div>
</div>
<div class="haru-single-shortcode haru-container">
	<?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post(); 

            $haru_shortcode_code = get_post_meta(get_the_ID(), 'haru_shortcode_code', true);
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="single-shortcode-content">
            <textarea class="haru-shortcode-core" onfocus="this.select();" readonly="readonly"><?php echo get_post_meta(get_the_ID(), 'haru_shortcode_code', true); ?></textarea>
            <a href="javascript:;" class="haru-shortcode-copy button-background button-background--primary button-background--small"><?php echo esc_html__( 'Copy Shortcode', 'haru-vidi' ); ?></a>
        </div>
    	<?php echo do_shortcode( $haru_shortcode_code ); ?>
	</article>
	<?php
            endwhile;
        else :
    ?>
    <div class="single-no-shortcode">
        <?php echo esc_html__( 'No Shortcode Found.', 'haru-vidi' ); ?>
    </div>
    <?php
        endif;
    ?>
</div>
<?php
get_footer();
