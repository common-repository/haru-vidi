<?php
/*
Plugin Name: CMB2 Radio Image
Description: https://github.com/satwinderrathore/CMB2-Radio-Image/
Version: 0.1
Author: Satwinder Rathore
Author URI: http://satwinderrathore.wordpress.com
License: GPL-2.0+
*/

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if( !class_exists( 'Haru_CMB_Text_List' ) ) {
    /**
     * Class Haru_CMB_Text_List
     */
    class Haru_CMB_Text_List {

        public function __construct() {
            add_action( 'cmb2_render_text_list', array( $this, 'callback' ), 10, 5 );
            add_action( 'admin_head', array( $this, 'admin_head' ) );
        }

        public function callback($field, $escaped_value, $object_id, $object_type, $field_type_object) {
            $field_name = $field->_name();

            $options = (array) $field_type_object->field->options();
           	
           	echo '<div class="cmb2-text-list">';
           	foreach ( $options as $key => $value ) {
           		$args = array(
	           			'type'  		=> 'text',
	           			'id'			=> $field_name . '['. $key .']',
	           			'name'  		=> $field_name . '['. $key .']',
	           			'desc'			=> '',
	           			'placeholder' 	=> $value,
	           		);
           		if ( $escaped_value != '' ) {
           			$args['value'] = $escaped_value[$key];
           		}
           		echo $field_type_object->input($args);
           	}
           	echo '</div>';
           	$field_type_object->_desc( true, true );
        }

        public function admin_head() {
            ?>
            <style>
                .cmb2-text-list {

                }
            </style>
            <?php
        }
    }

    $cmb2_text_list = new Haru_CMB_Text_List();

}