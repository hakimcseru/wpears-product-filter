<?php

if( ! defined( 'ABSPATH' ) ) {
	exit;
} // exit if directly access

if ( ! class_exists( 'wpears_category_widget' ) ) {
	class wpears_category_widget extends WP_Widget{
		function __construct(){
			add_action( 'widgets_init', array(&$this,'wpears_category_custom_widget') );
			parent::__construct(
				'wpearsCategoryWidget',
				__('Wpears Category Widget', 'wpears'),
				__('Wpears Category Widget Description', 'wpears')
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
				// Get product Categories
			  	$taxonomy     = 'product_cat';
			  	$orderby      = 'name';  
			  	$show_count   = 0;      // 1 for yes, 0 for no
			  	$pad_counts   = 0;      // 1 for yes, 0 for no
			  	$hierarchical = 1;      // 1 for yes, 0 for no  
			  	$title        = '';  
			  	$empty        = 0;
			  	$args = array(
				         'taxonomy'     => $taxonomy,
				         'orderby'      => $orderby,
				         'show_count'   => $show_count,
				         'pad_counts'   => $pad_counts,
				         'hierarchical' => $hierarchical,
				         'title_li'     => $title,
				         'hide_empty'   => $empty
				  );
				$all_categories = get_categories( $args );
				
				
				
				?>

				<div class="wpears-widget">
					<ul>
					<?php
						foreach ( $all_categories as $cat ) { ?>
							<li>
								<a href="javascript:void(0)" data-prop="wpear-cat" data-value="<?php echo $cat->term_id; ?>" data-rainbow="category" data-rainbowCategoryID="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></a>
							</li>
						
					<?php } //end loop ?>
					</ul>
				</div>
			</div>

			<?php
			}
			echo $args['after_widget'];
		}

		function wpears_category_custom_widget(){
			register_widget('wpears_category_widget');
		}
	}
}

