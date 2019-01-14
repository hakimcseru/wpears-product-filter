<?php

if( ! defined( 'ABSPATH' ) ) {
	exit;
} // exit if directly access

if ( ! class_exists( 'wpears_sorting_widget' ) ) {
	class wpears_sorting_widget extends WP_Widget{
		function __construct(){
			add_action( 'widgets_init', array(&$this,'wpears_custom_widget') );
			parent::__construct(
				'wpearsSortingWidget',
				__('Wpears Sorting Widget', 'wpears'),
				__('Wpears Sorting Widget Description', 'wpears')
			);
		}

		function form( $instance ) {
			$title = isset($instance['title']) ? $instance['title']: __('Wpears Sorting Widget', 'wpears');
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
				
				?>

				<div class="wpears-widget" id="wpears-sorting-product">
 					<ul>
						<li>
							<a href="javascript:void(0)" data-filterby="sorting" data-value="newest">Newest</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-filterby="sorting" data-value="most-popular">Most Popular</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-filterby="sorting" data-value="most-purchased">Most Purchased</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-filterby="sorting" data-value="priceLH">Price: Low to High</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-filterby="sorting" data-value="priceHL">Price: High to Low</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-filterby="sorting" data-value="avarRat">Avarage Rating</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-filterby="sorting" data-value="shipping">Shipping</a>
						</li>
						<li>
							<a href="javascript:void(0)" data-filterby="sorting" data-value="topRatSel">Top Rated Seller</a>
						</li>
					</ul>
					
				</div>

			<?php
			}
			echo $args['after_widget'];
		}

		function wpears_custom_widget() {
			register_widget('wpears_sorting_widget');
		}
	}
}