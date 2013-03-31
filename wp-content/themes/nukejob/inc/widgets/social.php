<?php
// Add our function to the widgets_init hook
add_action( 'widgets_init', 'social_media_widget' );

//Register widget
function social_media_widget() {
	register_widget( 'social_widget' );
}

class social_widget extends WP_Widget {
	function social_widget() {	
		/* Widget settings */
		$widget_ops = array( 'classname' => 'social_widget', 'description' =>__('A widget that display list of social media.', 'wpnuke') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 100, 'height' => 200, 'id_base' => 'social_widget' );
		/* Create the widget */
		$this->WP_Widget( 'social_widget',__('WPNuke - Social Media', 'wpnuke'), $widget_ops, $control_ops );
	}

	// Display the Widget
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$rsslink = $instance['rsslink'];
		$rsstext = $instance['rsstext'];
		$emaillink = $instance['emaillink'];
		$emailtext = $instance['emailtext'];
		$fblink = $instance['fblink'];
		$fbtext = $instance['fbtext'];
		$twitterlink = $instance['twitterlink'];
		$twittertext = $instance['twittertext'];
		$youtubelink = $instance['youtubelink'];
		$youtubetext = $instance['youtubetext'];
		$flickrlink = $instance['flickrlink'];
		$flickrtext = $instance['flickrtext'];
		$linkedinlink = $instance['linkedinlink'];
		$linkedintext = $instance['linkedintext'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display social media list. */
		?>
		<ul class="social-media-widget">
		    <?php if ($rsstext) : ?><li class="rss-url"><a href="<?php echo $rsslink ?>" title="RSS Feed"><?php echo $rsstext ?></a></li><?php endif; ?>
			<?php if ($emailtext) : ?><li class="email-url"><a href="<?php echo $emaillink ?>" title="Email"><?php echo $emailtext ?></a></li><?php endif; ?>
			<?php if ($fbtext) : ?><li class="facebook-url"><a href="<?php echo $fblink ?>" title="Facebook"><?php echo $fbtext ?></a></li><?php endif; ?>
			<?php if ($twittertext) : ?><li class="twitter-url"><a href="<?php echo $twitterlink ?>" title="Twitter"><?php echo $twittertext ?></a></li><?php endif; ?>
			<?php if ($youtubetext) : ?><li class="youtube-url"><a href="<?php echo $youtubelink ?>" title="Youtube"><?php echo $youtubetext ?></a></li><?php endif; ?>
			<?php if ($flickrtext) : ?><li class="flickr-url"><a href="<?php echo $flickrlink ?>" title="Flickr"><?php echo $flickrtext ?></a></li><?php endif; ?>
			<?php if ($linkedintext) : ?><li class="linkedin-url"><a href="<?php echo $linkedinlink ?>" title="LinkedIn"><?php echo $linkedintext ?></a></li><?php endif; ?>
		</ul>
		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	// Update and save widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['rsslink'] = $new_instance['rsslink'];
		$instance['rsstext'] = $new_instance['rsstext'];
		$instance['emaillink'] = $new_instance['emaillink'];
		$instance['emailtext'] = $new_instance['emailtext'];
		$instance['fblink'] = $new_instance['fblink'];
		$instance['fbtext'] = $new_instance['fbtext'];
		$instance['twitterlink'] = $new_instance['twitterlink'];
		$instance['twittertext'] = $new_instance['twittertext'];
		$instance['youtubelink'] = $new_instance['youtubelink'];
		$instance['youtubetext'] = $new_instance['youtubetext'];
		$instance['flickrlink'] = $new_instance['flickrlink'];
		$instance['flickrtext'] = $new_instance['flickrtext'];
		$instance['linkedinlink'] = $new_instance['linkedinlink'];
		$instance['linkedintext'] = $new_instance['linkedintext'];
		
		return $instance;
	}
	
	// Widget settings
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'title' => 'Social Media',
		'rsslink' => 'http://feeds.feedburner.com/wpnuke',
		'rsstext' => 'Subscribe RSS Feed',
		'emaillink' => '#',
		'emailtext' => 'Subscribe Via Email',
		'fblink' => 'http://www.facebook.com/WpNukeThemes',
		'fbtext' => 'Find Us on Facebook',
		'twitterlink' => 'http://twitter.com/WPNuke',
		'twittertext' => 'Follow Us on Twitter',
		'youtubelink' => '#',
		'youtubetext' => 'Our Videos on YouTube',
		'flickrlink' => 'http://www.flickr.com/groups/grafisia/',
		'flickrtext' => 'Our Gallery on Flickr',
		'linkedinlink' => '#',
		'linkedintext' => 'Find Us on LinkedIn',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'rsslink' ); ?>"><?php _e('RSS link:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'rsslink' ); ?>" name="<?php echo $this->get_field_name( 'rsslink' ); ?>" value="<?php echo $instance['rsslink']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'rsstext' ); ?>"><?php _e('RSS Text:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'rsstext' ); ?>" name="<?php echo $this->get_field_name( 'rsstext' ); ?>" value="<?php echo $instance['rsstext']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'emaillink' ); ?>"><?php _e('Email subscribe link:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'emaillink' ); ?>" name="<?php echo $this->get_field_name( 'emaillink' ); ?>" value="<?php echo $instance['emaillink']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'emailtext' ); ?>"><?php _e('Email subscribe text:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'emailtext' ); ?>" name="<?php echo $this->get_field_name( 'emailtext' ); ?>" value="<?php echo $instance['emailtext']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'fblink' ); ?>"><?php _e('Facebook link:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'fblink' ); ?>" name="<?php echo $this->get_field_name( 'fblink' ); ?>" value="<?php echo $instance['fblink']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'fbtext' ); ?>"><?php _e('Facebook text:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'fbtext' ); ?>" name="<?php echo $this->get_field_name( 'fbtext' ); ?>" value="<?php echo $instance['fbtext']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitterlink' ); ?>"><?php _e('Twitter link:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitterlink' ); ?>" name="<?php echo $this->get_field_name( 'twitterlink' ); ?>" value="<?php echo $instance['twitterlink']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twittertext' ); ?>"><?php _e('Twitter text:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twittertext' ); ?>" name="<?php echo $this->get_field_name( 'twittertext' ); ?>" value="<?php echo $instance['twittertext']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'youtubelink' ); ?>"><?php _e('YouTube link:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'youtubelink' ); ?>" name="<?php echo $this->get_field_name( 'youtubelink' ); ?>" value="<?php echo $instance['youtubelink']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'youtubetext' ); ?>"><?php _e('YouTube text:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'youtubetext' ); ?>" name="<?php echo $this->get_field_name( 'youtubetext' ); ?>" value="<?php echo $instance['youtubetext']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'flickrlink' ); ?>"><?php _e('Flickr link:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'flickrlink' ); ?>" name="<?php echo $this->get_field_name( 'flickrlink' ); ?>" value="<?php echo $instance['flickrlink']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'flickrtext' ); ?>"><?php _e('Flickr text:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'flickrtext' ); ?>" name="<?php echo $this->get_field_name( 'flickrtext' ); ?>" value="<?php echo $instance['flickrtext']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'linkedinlink' ); ?>"><?php _e('LinkedIn link:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'linkedinlink' ); ?>" name="<?php echo $this->get_field_name( 'linkedinlink' ); ?>" value="<?php echo $instance['linkedinlink']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'linkedintext' ); ?>"><?php _e('LinkedIn text:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'linkedintext' ); ?>" name="<?php echo $this->get_field_name( 'linkedintext' ); ?>" value="<?php echo $instance['linkedintext']; ?>" />
		</p>
	
	<?php
	}
}
?>