<?php
// Add our function to the widgets_init hook
add_action( 'widgets_init', 'video_widget' );

//Register widget
function video_widget() {
	register_widget( 'vid_widget' );
}

class vid_widget extends WP_Widget {
	function vid_widget() {	
		/* Widget settings */
		$widget_ops = array( 'classname' => 'vid_widget', 'description' =>__('A widget that displays your video.', 'wpnuke') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 100, 'height' => 200, 'id_base' => 'vid_widget' );
		/* Create the widget */
		$this->WP_Widget( 'vid_widget',__('WPNuke - Video Widget', 'wpnuke'), $widget_ops, $control_ops );
	}

	// Display the Widget
	function widget( $args, $instance ) {
		global $wpdb;
		extract( $args );

		/* User settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$embed = $instance['embed'];
		$desc = $instance['desc'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
		/* Display video widget */
		?>
		<div class="video-widget">
			<?php echo $embed ?>
		</div>
		<p><?php echo $desc ?></p>
		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	// Update and save widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['embed'] = $new_instance['embed'];
		$instance['desc'] = $new_instance['desc'];
		
		return $instance;
	}
	
	// Widget settings
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => '',
		'embed' => '',
		'desc' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'embed' ); ?>"><?php _e('Video embed code (best at 300px wide):', 'wpnuke') ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('embed'); ?>" name="<?php echo $this->get_field_name('embed'); ?>"><?php echo $instance['embed']; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'desc' ); ?>"><?php _e('Your video description:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'desc' ); ?>" name="<?php echo $this->get_field_name( 'desc' ); ?>" value="<?php echo $instance['desc']; ?>" />
		</p>
		
	<?php
	}
}
?>