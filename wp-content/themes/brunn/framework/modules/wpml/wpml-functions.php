<?php

if ( ! function_exists( 'brunn_select_disable_wpml_css' ) ) {
	function brunn_select_disable_wpml_css() {
		define( 'ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true );
	}
	
	add_action( 'after_setup_theme', 'brunn_select_disable_wpml_css' );
}