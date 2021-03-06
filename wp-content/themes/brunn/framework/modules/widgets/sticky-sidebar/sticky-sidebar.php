<?php

if ( class_exists( 'BrunnSelectClassWidget' ) ) {
	class BrunnSelectClassStickySidebar extends BrunnSelectClassWidget {
		public function __construct() {
			parent::__construct(
				'qodef_sticky_sidebar',
				esc_html__( 'Brunn Sticky Sidebar Widget', 'brunn' ),
				array( 'description' => esc_html__( 'Use this widget to make the sidebar sticky. Drag it into the sidebar above the widget which you want to be the first element in the sticky sidebar.', 'brunn' ) )
			);

			$this->setParams();
		}

		protected function setParams() {
		}

		public function widget( $args, $instance ) {
			echo '<div class="widget qodef-widget-sticky-sidebar"></div>';
		}
	}
}