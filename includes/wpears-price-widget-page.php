<?php

if( ! defined( 'ABSPATH' ) ) {
	exit;
} // exit if directly access

if ( ! class_exists( 'wpears_price_widget' ) ) {
	class wpears_price_widget extends WP_Widget{
		function __construct(){
			add_action( 'widgets_init', array(&$this,'wpears_custom_price_widget') );
			parent::__construct(
				'wpearsPriceWidget',
				__('Wpears Price Widget', 'wpears'),
				__('Wpears Price Widget Description', 'wpears')
			);
		}

		

		function form( $instance ){
			$title = isset($instance['title']) ? $instance['title']: __('Wpears Price Widget', 'wpears');
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php  _e('Price Widget', 'wpears') ?></label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			</p>
			<?php

		}

		function widget( $args, $instance ) {
			echo $args['before_widget'];
			if( isset( $instance['title'] ) && $instance['title'] != "" ) {
				echo $args['before_title'];
				echo apply_filters( 'widget_title', $instance['title'] );
				echo $args['after_title'];
				
				?>

				<div class="wpears-widget">
					<br>
					<br>
					<div id="slider" class="noUi-target noUi-ltr noUi-horizontal">
					
					</div>
					<input type="hidden" id="minSlideValue">
					<input type="hidden" id="maxSlideValue">
					<br>
				</div>

			<?php
			}
			echo $args['after_widget'];
		}

		function wpears_custom_price_widget(){
			register_widget('wpears_price_widget');
		}
	}
}