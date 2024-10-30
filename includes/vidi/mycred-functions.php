<?php
/**
 * @package    HaruTheme/Haru Vidi
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( ! function_exists( 'haru_mycred_pro_run_sale_filter_later' ) ) {
	function haru_mycred_pro_run_sale_filter_later( $priority ) {
	    return 50;
	}

	add_filter( 'mycred_sell_content_priority', 'haru_mycred_pro_run_sale_filter_later' );
}

