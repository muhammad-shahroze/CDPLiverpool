<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class BrunnInstagramWidget extends WP_Widget {
	protected $params;

	public function __construct() {
		parent::__construct(
			'qodef_instagram_widget',
			esc_html__( 'Brunn Instagram Widget', 'brunn-instagram-feed' ),
			array(
				'description' => esc_html__( 'Display your Instagram feed', 'brunn-instagram-feed' )
			)
		);

		$this->setParams();
	}

	protected function setParams() {
		$this->params = array(
			array(
				'name'  => 'title',
				'type'  => 'textfield',
				'title' => esc_html__( 'Title', 'brunn-instagram-feed' )
			),
			array(
				'name'    => 'type',
				'type'    => 'dropdown',
				'title'   => esc_html__( 'Type', 'brunn-instagram-feed' ),
				'options' => array(
					'gallery'  => esc_html__( 'Gallery', 'brunn-instagram-feed' ),
					'carousel' => esc_html__( 'Carousel', 'brunn-instagram-feed' )
				)
			),
			array(
				'name'    => 'number_of_cols',
				'type'    => 'dropdown',
				'title'   => esc_html__( 'Number of Columns', 'brunn-instagram-feed' ),
				'options' => array(
					'2' => esc_html__( 'Two', 'brunn-instagram-feed' ),
					'3' => esc_html__( 'Three', 'brunn-instagram-feed' ),
					'4' => esc_html__( 'Four', 'brunn-instagram-feed' ),
					'6' => esc_html__( 'Six', 'brunn-instagram-feed' ),
					'9' => esc_html__( 'Nine', 'brunn-instagram-feed' )
				)
			),
			array(
				'name'  => 'number_of_photos',
				'type'  => 'textfield',
				'title' => esc_html__( 'Number of Photos', 'brunn-instagram-feed' )
			),
			array(
				'name'    => 'image_size',
				'type'    => 'dropdown',
				'title'   => esc_html__( 'Image Size', 'brunn-instagram-feed' ),
				'options' => array(
					'thumbnail'           => esc_html__( 'Small', 'brunn-instagram-feed' ),
					'low_resolution'      => esc_html__( 'Medium', 'brunn-instagram-feed' ),
					'standard_resolution' => esc_html__( 'Large', 'brunn-instagram-feed' )
				)
			),
			array(
				'name'    => 'space_between_items',
				'type'    => 'dropdown',
				'title'   => esc_html__( 'Space Between Items', 'brunn-instagram-feed' ),
				'options' => brunn_select_get_space_between_items_array( false, array( 'large', 'huge' ) )
			),
			array(
				'name'    => 'show_instagram_icon',
				'type'    => 'dropdown',
				'title'   => esc_html__( 'Show Instagram Icon', 'brunn-instagram-feed' ),
				'options' => brunn_select_get_yes_no_select_array( false, true )
			),
			array(
				'name'  => 'transient_time',
				'type'  => 'textfield',
				'title' => esc_html__( 'Images Cache Time', 'brunn-instagram-feed' )
			)
		);
	}

	public function getParams() {
		return $this->params;
	}

	public function widget( $args, $instance ) {
		extract( $instance );

		print brunn_select_get_module_part( $args['before_widget'] );
		if ( ! empty( $title ) ) {
			print brunn_select_get_module_part( $args['before_title'] );
			print brunn_select_get_module_part( $title );
			print brunn_select_get_module_part( $args['after_title'] );
		}

		$number_of_photos = isset( $number_of_photos ) ? $number_of_photos : '6';

		$instagram_api = BrunnInstagramApi::getInstance();
		$images_array  = $instagram_api->getImages( $number_of_photos, array(
			'use_transients' => true,
			'transient_name' => $args['widget_id'],
			'transient_time' => $transient_time
		) );

		$type                = ! empty( $type ) ? $type : 'gallery';
		$number_of_cols      = $number_of_cols == '' ? 3 : $number_of_cols;
		$space_between_items = ! empty( $space_between_items ) ? $space_between_items : 'normal';
		$show_instagram_icon = ! empty( $show_instagram_icon ) ? $show_instagram_icon : 'yes';

		$widget_class = '';
		$slider_data  = array();

		if ( $type === 'carousel' ) {
			$widget_class = 'qodef-instagram-carousel qodef-owl-slider';

			$slider_margin = 0;
			if ( $space_between_items === 'normal' ) {
				$slider_margin = 30;
			} else if ( $space_between_items === 'small' ) {
				$slider_margin = 20;
			} else if ( $space_between_items === 'tiny' ) {
				$slider_margin = 10;
			} else if ( $space_between_items === 'no' ) {
				$slider_margin = 0;
			}

			$slider_data['data-number-of-items']   = esc_attr( $number_of_cols );
			$slider_data['data-slider-margin']     = esc_attr( $slider_margin );
			$slider_data['data-enable-navigation'] = 'no';
			$slider_data['data-enable-pagination'] = 'no';
		} else if ( $type == 'gallery' ) {
			$widget_class = 'qodef-instagram-gallery qodef-' . esc_attr( $space_between_items ) . '-space';
		}

		if ( is_array( $images_array ) && count( $images_array ) ) { ?>
            <ul class="qodef-instagram-feed clearfix qodef-col-<?php echo esc_attr( $number_of_cols ); ?> <?php echo esc_attr( $widget_class ); ?>" <?php echo brunn_select_get_inline_attrs( $slider_data ); ?>>
				<?php
				foreach ( $images_array as $image ) { ?>
                    <li>
                        <a href="<?php echo esc_url( $instagram_api->getHelper()->getImageLink( $image ) ); ?>" target="_blank">
							<?php if ( $show_instagram_icon == 'yes' ) { ?>
                                <span class="qodef-instagram-icon"><i class="social_instagram"></i></span>
							<?php } ?>
							<?php echo brunn_select_kses_img( $instagram_api->getHelper()->getImageHTML( $image, $image_size ) ); ?>
                        </a>
                    </li>
				<?php } ?>
            </ul>
		<?php }

		print brunn_select_get_module_part( $args['after_widget'] );
	}

	public function form( $instance ) {
		foreach ( $this->params as $param_array ) {
			$param_name    = $param_array['name'];
			${$param_name} = isset( $instance[ $param_name ] ) ? esc_attr( $instance[ $param_name ] ) : '';
		}

		$instagram_api = BrunnInstagramApi::getInstance();

		//user has connected with instagram. Show form
		if ( $instagram_api->hasUserConnected() ) {
			foreach ( $this->params as $param ) {
				switch ( $param['type'] ) {
					case 'textfield':
						?>
                        <p>
                            <label for="<?php echo esc_attr( $this->get_field_id( $param['name'] ) ); ?>"><?php echo esc_html( $param['title'] ); ?></label>
                            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $param['name'] ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( $param['name'] ) ); ?>" type="text" value="<?php echo esc_attr( ${$param['name']} ); ?>"/>
                        </p>
						<?php
						break;
					case 'dropdown':
						?>
                        <p>
                            <label for="<?php echo esc_attr( $this->get_field_id( $param['name'] ) ); ?>"><?php echo esc_html( $param['title'] ); ?></label>
							<?php if ( isset( $param['options'] ) && is_array( $param['options'] ) && count( $param['options'] ) ) { ?>
                                <select class="widefat" name="<?php echo esc_attr( $this->get_field_name( $param['name'] ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( $param['name'] ) ); ?>">
									<?php foreach ( $param['options'] as $param_option_key => $param_option_val ) {
										$option_selected = '';
										if ( ${$param['name']} == $param_option_key ) {
											$option_selected = 'selected';
										}
										?>
                                        <option <?php echo esc_attr( $option_selected ); ?> value="<?php echo esc_attr( $param_option_key ); ?>"><?php echo esc_attr( $param_option_val ); ?></option>
									<?php } ?>
                                </select>
							<?php } ?>
                        </p>

						<?php
						break;
				}
			}
		}
	}
}

if ( ! function_exists( 'brunn_instagram_feed_widget_load' ) ) {
	function brunn_instagram_feed_widget_load() {
		if ( brunn_instagram_theme_installed() ) {
			register_widget( 'BrunnInstagramWidget' );
		}
	}

	add_action( 'widgets_init', 'brunn_instagram_feed_widget_load' );
}