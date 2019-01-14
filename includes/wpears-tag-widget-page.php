<?php

if( ! defined( 'ABSPATH' ) ) {
	exit;
} // exit if directly access

if ( ! class_exists( 'wpears_tag_widget' ) ) {
	class wpears_tag_widget extends WP_Widget{
		function __construct(){
			add_action( 'widgets_init', array(&$this,'wpears_tag_custom_widget') );
			parent::__construct(
				'wpearsTagWidget',
				__('Wpears Tag Widget', 'wpears'),
				__('Wpears Tag Widget Description', 'wpears')
			);
		}

		

		function form( $instance ){
			$title = isset($instance['title']) ? $instance['title']: __('Wpears Tag Widget', 'wpears');
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
			  	$taxonomy     = 'product_tag';
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
				$all_tags = get_categories( $args );
				
				
				
				?>

				<div class="wpears-widget">
					<ul>
					<?php
						foreach ( $all_tags as $tag ) { ?>
							<li>
								<a href="javascript:void(0)" data-filterby="tag" data-prop="wpear-tag" data-value="<?php echo $tag->term_id; ?>" data-rainbow="tag" data-rainbowTagID="<?php echo $tag->term_id; ?>"><?php echo $tag->name; ?></a>
							</li>
						
					<?php } //end loop ?>
					</ul>
				</div>
			</div>

			<?php
			}
			echo $args['after_widget'];
		}

		function wpears_tag_custom_widget(){
			register_widget('wpears_tag_widget');
		}
	}
}

