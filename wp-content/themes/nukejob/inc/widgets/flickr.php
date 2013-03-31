<?php
// Add our function to the widgets_init hook
add_action( 'widgets_init', 'flickr_gallery_widget' );

//Register widget
function flickr_gallery_widget() {
	register_widget( 'flickr_widget' );
}

class flickr_widget extends WP_Widget {
	function flickr_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'flickr_widget', 'description' => __('A widget that displays your Flickr photos.', 'wpnuke') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 100, 'height' => 200, 'id_base' => 'flickr_widget' );
		/* Create the widget. */
		$this->WP_Widget( 'flickr_widget', __('WPNuke - Flickr', 'wpnuke'), $widget_ops, $control_ops );
	}

	// Display the Widget
	function widget( $args, $instance ) {
		extract( $args );

		/* User settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$flickrID = $instance['flickrID'];
		$postcount = $instance['postcount'];
		$type = $instance['type'];
		$display = $instance['display'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display Flickr Photos */
		 ?>
			
			<div class="flickr-widget-wrapper">
				<div class="flickr-widget">
					<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=s&amp;layout=x&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		
		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	// Update and save widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['flickrID'] = strip_tags( $new_instance['flickrID'] );
		$instance['postcount'] = $new_instance['postcount'];
		$instance['type'] = $new_instance['type'];
		$instance['display'] = $new_instance['display'];

		return $instance;
	}
	
	// Widget settings
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
		'title' => 'Flickr Gallery',
		'flickrID' => '1438980@N21',
		'postcount' => '6',
		'type' => 'group',
		'display' => 'random',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'flickrID' ); ?>"><?php _e('Flickr ID:', 'wpnuke') ?> (<a href="http://idgettr.com/">idGettr</a>)</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'flickrID' ); ?>" name="<?php echo $this->get_field_name( 'flickrID' ); ?>" value="<?php echo $instance['flickrID']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'postcount' ); ?>"><?php _e('Number of Photos:', 'wpnuke') ?></label>
			<select id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" class="widefat">
			    <option <?php if ( '3' == $instance['postcount'] ) echo 'selected="selected"'; ?>>3</option>
				<option <?php if ( '6' == $instance['postcount'] ) echo 'selected="selected"'; ?>>6</option>
				<option <?php if ( '9' == $instance['postcount'] ) echo 'selected="selected"'; ?>>9</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e('Type (user or group):', 'wpnuke') ?></label>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat">
				<option <?php if ( 'user' == $instance['type'] ) echo 'selected="selected"'; ?>>user</option>
				<option <?php if ( 'group' == $instance['type'] ) echo 'selected="selected"'; ?>>group</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e('Display (random or latest):', 'wpnuke') ?></label>
			<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
				<option <?php if ( 'random' == $instance['display'] ) echo 'selected="selected"'; ?>>random</option>
				<option <?php if ( 'latest' == $instance['display'] ) echo 'selected="selected"'; ?>>latest</option>
			</select>
		</p>
		
	<?php
	}
}
?>