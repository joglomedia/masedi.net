<?php
// Add our function to the widgets_init hook
add_action( 'widgets_init', 'custom_feedback_widget' );

//Register widget
function custom_feedback_widget() {
	register_widget( 'feedback_widget' );
}

class feedback_widget extends WP_Widget {
	function feedback_widget() {	
		/* Widget settings */
		$widget_ops = array( 'classname' => 'feedback_widget', 'description' =>__('A widget that displays random feedback.', 'wpnuke') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 100, 'height' => 200, 'id_base' => 'feedback_widget' );
		/* Create the widget */
		$this->WP_Widget( 'feedback_widget',__('WPNuke - Feedback Widget', 'wpnuke'), $widget_ops, $control_ops );
	}

	// Display the Widget
	function widget( $args, $instance ) {
		global $post;
		extract( $args );

		/* User settings. */
		$title = apply_filters('widget_title', $instance['title'] );

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		/* Display feedback widget */
		$feedback_query = new WP_Query('post_type=wpnuke_feedback&showposts=1&orderby=rand');
		while ( $feedback_query->have_posts() ) : $feedback_query->the_post();
		?>
		<div class="feedback-widget">
		    <div class="feedback-wrap-top"></div>
			<div class="feedback-wrap">
			    <p><?php echo get_post_meta($post->ID, '_wpnuke_feedback_msg', true); ?></p>
				<span><?php echo get_post_meta($post->ID, '_wpnuke_feedback_author', true); ?></span>
				<?php if (get_post_meta( get_the_ID( ), '_wpnuke_feedback_author_url', true )) { ?><a href="<?php echo get_post_meta($post->ID, '_wpnuke_feedback_author_url', true); ?>"><?php echo get_post_meta($post->ID, '_wpnuke_feedback_author_url', true); ?></a><?php } ?>
			</div>
			<div class="feedback-wrap-btm"></div>
		</div><!--feedback-widget-->
		<?php
		endwhile;
		wp_reset_query();

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	// Update and save widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		
		return $instance;
	}
	
	// Widget settings
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		
	<?php
	}
}
?>