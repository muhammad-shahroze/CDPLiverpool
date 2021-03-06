<?php

if ( ! function_exists( 'brunn_select_map_post_audio_meta' ) ) {
	function brunn_select_map_post_audio_meta() {
		$audio_post_format_meta_box = brunn_select_create_meta_box(
			array(
				'scope' => array( 'post' ),
				'title' => esc_html__( 'Audio Post Format', 'brunn' ),
				'name'  => 'post_format_audio_meta'
			)
		);
		
		brunn_select_create_meta_box_field(
			array(
				'name'          => 'qodef_audio_type_meta',
				'type'          => 'select',
				'label'         => esc_html__( 'Audio Type', 'brunn' ),
				'description'   => esc_html__( 'Choose audio type', 'brunn' ),
				'parent'        => $audio_post_format_meta_box,
				'default_value' => 'social_networks',
				'options'       => array(
					'social_networks' => esc_html__( 'Audio Service', 'brunn' ),
					'self'            => esc_html__( 'Self Hosted', 'brunn' )
				)
			)
		);
		
		$qodef_audio_embedded_container = brunn_select_add_admin_container(
			array(
				'parent' => $audio_post_format_meta_box,
				'name'   => 'qodef_audio_embedded_container'
			)
		);
		
		brunn_select_create_meta_box_field(
			array(
				'name'        => 'qodef_post_audio_link_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Audio URL', 'brunn' ),
				'description' => esc_html__( 'Enter audio URL', 'brunn' ),
				'parent'      => $qodef_audio_embedded_container,
				'dependency' => array(
					'show' => array(
						'qodef_audio_type_meta' => 'social_networks'
					)
				)
			)
		);
		
		brunn_select_create_meta_box_field(
			array(
				'name'        => 'qodef_post_audio_custom_meta',
				'type'        => 'text',
				'label'       => esc_html__( 'Audio Link', 'brunn' ),
				'description' => esc_html__( 'Enter audio link', 'brunn' ),
				'parent'      => $qodef_audio_embedded_container,
				'dependency' => array(
					'show' => array(
						'qodef_audio_type_meta' => 'self'
					)
				)
			)
		);
	}
	
	add_action( 'brunn_select_action_meta_boxes_map', 'brunn_select_map_post_audio_meta', 23 );
}