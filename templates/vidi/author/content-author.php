<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Author Style
$author_class = 'default';

if ( isset( $author_style ) ) {
    $author_class = $author_style;
}

?>
<article class="grid-item author-item <?php echo esc_attr( $author_class ); ?>">
    
</article>
