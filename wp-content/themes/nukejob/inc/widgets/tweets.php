<?php
// Add our function to the widgets_init hook
add_action( 'widgets_init', 'latest_tweets_widget' );

//Register widget
function latest_tweets_widget() {
	register_widget( 'tweets_widget' );
}

class tweets_widget extends WP_Widget {
	function tweets_widget() {	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'tweets_widget', 'description' => __('A widget that displays your latest tweets.', 'wpnuke') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 100, 'height' => 200, 'id_base' => 'tweets_widget' );
		/* Create the widget. */
		$this->WP_Widget( 'tweets_widget', __('WPNuke - Latest Tweets', 'wpnuke'), $widget_ops, $control_ops );
	}

	// Display the Widget
	function widget( $args, $instance ) {
		extract( $args );

		/* User settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$username = $instance['username'];
		$tweetscount = $instance['tweetscount'];
		$followtext = $instance['followtext'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display Latest Tweets */
		?>

            <ul id="twitter_update_list">
                <li></li>
            </ul>
            <a href="http://twitter.com/<?php echo $username ?>" class="twitter-link"><?php echo $followtext ?></a>
			<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
			<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $username ?>.json?callback=twitterCallback2&amp;count=<?php echo $tweetscount ?>"></script>
		
		<?php 

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	// Update and save widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['tweetscount'] = strip_tags( $new_instance['tweetscount'] );
		$instance['followtext'] = strip_tags( $new_instance['followtext'] );

		return $instance;
	}
	
	// Widget settings
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
		'title' => 'Latest Tweets',
		'username' => 'WPNuke',
		'tweetscount' => '5',
		'followtext' => 'WPNuke on Twitter',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php _e('Twitter Username e.g. wpnuke', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" value="<?php echo $instance['username']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tweetscount' ); ?>"><?php _e('Number of tweets', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tweetscount' ); ?>" name="<?php echo $this->get_field_name( 'tweetscount' ); ?>" value="<?php echo $instance['tweetscount']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'followtext' ); ?>"><?php _e('Text e.g. WpNuke on Twitter', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'followtext' ); ?>" name="<?php echo $this->get_field_name( 'followtext' ); ?>" value="<?php echo $instance['followtext']; ?>" />
		</p>
		
	<?php
	}
}
?>