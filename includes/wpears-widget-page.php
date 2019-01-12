<?php

if( ! defined( 'ABSPATH' ) ) {
	exit;
} // exit if directly access

if ( ! class_exists( 'wpears_widget' ) ) {
	class wpears_widget extends WP_Widget{
		function __construct(){
			add_action( 'widgets_init', array(&$this,'wpears_custom_widget') );
			parent::__construct(
				'wpearsWidget',
				__('Wpears Widget', 'wpears'),
				__('Wpears Widget Description', 'wpears')
			);
		}

		

		function form( $instance ){
			$title = isset($instance['title']) ? $instance['title']: __('Wpears Widget', 'wpears');
			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php  _e('Title', 'wpears') ?></label>
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
				global $product;
				// Get product attributes
				$attributes = get_terms( 'pa_color' );
				
				?>

				<div class="wpears-widget">
					<ul>
					<?php
						foreach ( $attributes as $attribute ) { ?>
							<li>
								<a href="" data-filterby="term" data-value="<?php echo $attribute->name; ?>"  data-WpearsTerm="term" data-Wpearsatribute="<?php echo $attribute->name; ?>"><?php echo $attribute->name; ?></a>
							</li>
						
					<?php } //end loop ?>
					</ul>
				</div>

			<?php
			}
			echo $args['after_widget'];
		}

		function wpears_custom_widget(){
			register_widget('wpears_widget');
		}
	}
}