<?php

if(!function_exists('brunn_core_add_vertical_showcase_shortcodes')) {
	function brunn_core_add_vertical_showcase_shortcodes($shortcodes_class_name) {
		$shortcodes = array(
			'BrunnCore\CPT\Shortcodes\VerticalShowcase\VerticalShowcase'
		);
		
		$shortcodes_class_name = array_merge($shortcodes_class_name, $shortcodes);
		
		return $shortcodes_class_name;
	}
	
	add_filter('brunn_core_filter_add_vc_shortcode', 'brunn_core_add_vertical_showcase_shortcodes');
}