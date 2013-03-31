<?php
// Add our function to the widgets_init hook
add_action( 'widgets_init', 'ad_space_widget' );

//Register widget
function ad_space_widget() {
	register_widget( 'ad_widget' );
}

class ad_widget extends WP_Widget {
	function ad_widget() {	
		/* Widget settings */
		$widget_ops = array( 'classname' => 'ad_widget', 'description' =>__('A widget that display any type of Ad as a widget.', 'wpnuke') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 100, 'height' => 200, 'id_base' => 'ad_widget' );
		/* Create the widget */
		$this->WP_Widget( 'ad_widget',__('WPNuke - Ad Widget', 'wpnuke'), $widget_ops, $control_ops );
	}

	// Display the Widget
	function widget( $args, $instance ) {
		global $wpdb;
		extract( $args );

		/* User settings. */
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$adcode = $instance['adcode'];
		$adimgurl = $instance['adimgurl'];
		$addesturl = $instance['addesturl'];
		$adalt = $instance['adalt'];
		
		$adrel = $instance['adrel'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before_title and after_title defined by themes). */
		if ( $title ) { echo $before_title . $title . $after_title; }
		
		/* Display ad */
		if ( !empty( $adcode ) ) {
			echo $adcode;
		} else { ?>
			<a href="<?php echo $addesturl; ?>"<?php if ($adrel == 'nofollow') echo ' rel="nofollow"'; ?>><img src="<?php echo $adimgurl; ?>" alt="<?php echo $adalt; ?>" /></a>
		<?php
		}

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	// Update and save widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['adcode'] = $new_instance['adcode'];
		$instance['adimgurl'] = $new_instance['adimgurl'];
		$instance['addesturl'] = $new_instance['addesturl'];
		$instance['adalt'] = $new_instance['adalt'];
		
		$instance['adrel'] = $new_instance['adrel'];
		
		return $instance;
	}
	
	// Widget settings
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
			'title' => '',
			'adcode' => '',
			'adimgurl' => '',
			'addesturl' => '',
			'adalt' => '',
			'adrel' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'adcode' ); ?>"><?php _e('Insert ad code here:', 'wpnuke') ?></label>
			<textarea class="widefat" id="<?php echo $this->get_field_id('adcode'); ?>" name="<?php echo $this->get_field_name('adcode'); ?>"><?php echo $instance['adcode']; ?></textarea>
		</p>
		<p><strong>or</strong></p>
		<p>
			<label for="<?php echo $this->get_field_id( 'adimgurl' ); ?>"><?php _e('Ad image URL:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'adimgurl' ); ?>" name="<?php echo $this->get_field_name( 'adimgurl' ); ?>" value="<?php echo $instance['adimgurl']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'addesturl' ); ?>"><?php _e('Ad destination URL:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'addesturl' ); ?>" name="<?php echo $this->get_field_name( 'addesturl' ); ?>" value="<?php echo $instance['addesturl']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'adalt' ); ?>"><?php _e('Ad alt text:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'adalt' ); ?>" name="<?php echo $this->get_field_name( 'adalt' ); ?>" value="<?php echo $instance['adalt']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'adrel' ); ?>"><?php _e('Ad rel (nofollow/dofollow):', 'wpnuke') ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'adrel' ); ?>" name="<?php echo $this->get_field_name( 'adrel' ); ?>">
			<?php
				$list = '';
				$adrelopts = array('nofollow','dofollow');
				foreach ( $adrelopts as $adrelopt ) {
					if( $adrelopt == $instance['adrel'] ) {
						$selected = 'selected="selected"';
					} else { $selected = ''; }
					$list .= '<option ' . $selected . ' value="' . $adrelopt. '">' . $adrelopt . '</option>';
				}
				echo $list;
			?>
			</select>
		</p>
		
	<?php
	}
}
?>