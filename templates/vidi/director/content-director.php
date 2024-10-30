<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Director Style
$director_class = 'default';
if ( isset( $director_style ) ) {
    $director_class = $director_style;
}

if ( !isset( $director_style ) ) {
    $director_style = 'default';
}

// Edit Director
if ( isset( $can_edit ) ) {
    $haru_submit_director_page = haru_vidi_get_setting( 'vidi-general-settings', 'haru_submit_director_page', '' );
    $haru_submit_director_page_url = ( $haru_submit_director_page != '' && is_numeric( $haru_submit_director_page ) ) ? get_permalink( $haru_submit_director_page ) :  get_permalink( get_page_by_path( 'submit-director' ) );
    $haru_edit_director_url = $haru_submit_director_page_url . '?director_edit=' . get_the_ID();
}

?>
<article class="grid-item director-item <?php echo esc_attr( $director_class ); ?>">
    <div class="director-item__thumbnail">
        <a href="<?php echo esc_url( get_permalink() ); ?>">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail(); ?>
            <?php else : ?>
                <img src="<?php echo esc_url( PLUGIN_HARU_VIDI_URL . 'assets/images/placeholder.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
            <?php endif; ?>
            <div class="director-item__count-video"><?php echo haru_count_director_videos( get_the_ID() ); ?></div>
        </a>

        <?php if ( isset( $can_edit ) && ( $haru_submit_director_page_url != '' ) ) : ?>
            <div class="director-item__edit">
                <a href="<?php echo esc_url( $haru_edit_director_url ); ?>"><i class="haru-icon haru-edit"></i><?php echo esc_html__( 'Edit Director', 'haru-vidi' ); ?></a>
            </div>
        <?php endif; ?>
    </div>
    <div class="director-item__content">
        <h6 class="director-item__title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo get_the_title(); ?></a></h6>
        <div class="director-item__category"><?php echo get_the_term_list( get_the_ID(), 'director_category', '', ', ' ); ?></div>
        <div class="director-item__meta">
            <div class="director-item__author">
                <i class="fa fa-user"></i>
                <?php
                    if ( function_exists('bp_is_active') ) {
                        echo bp_core_get_userlink( get_the_author_meta('ID') );
                    } else {
                        printf('<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ));
                    }
                ?>
            </div>
            <div class="director-item__date"><i class="fa fa-calendar"></i><?php echo date_i18n( get_option( 'date_format' ), strtotime(get_the_date('Y-m-d')) ); ?></div>
            <div class="director-item__like"><?php haru_display_like_count( get_the_ID() ); ?></div>
            <div class="director-item__dislike"><?php haru_display_dislike_count( get_the_ID() ); ?></div>
            <div class="director-item__view"><?php haru_get_post_views( get_the_ID() ); ?></div>
        </div>
        <div class="director-item__desc">
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
</article>
