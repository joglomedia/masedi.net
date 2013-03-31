<?php
// Add our function to the widgets_init hook
add_action( 'widgets_init', 'sidebar_tab_widget' );

//Register widget
function sidebar_tab_widget() {
	register_widget( 'tab_widget' );
}

class tab_widget extends WP_Widget {
	function tab_widget() {	
		/* Widget settings */
		$widget_ops = array( 'classname' => 'tab_widget', 'description' =>__('A tabbed widget that display popular posts, recent posts, comments and tags.', 'wpnuke') );
		/* Widget control settings. */
		$control_ops = array( 'width' => 100, 'height' => 200, 'id_base' => 'tab_widget' );
		/* Create the widget */
		$this->WP_Widget( 'tab_widget',__('WPNuke - Tab Widget', 'wpnuke'), $widget_ops, $control_ops );
	}

	// Display the Widget
	function widget( $args, $instance ) {
		global $wpdb;
		extract( $args );

		/* User settings. */
		$tab1 = $instance['tab1'];
		$tab2 = $instance['tab2'];
		$tab3 = $instance['tab3'];
		$tab4 = $instance['tab4'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Randomize tab order in a new array. */
		$tab = array();
		
		?>
		<ul class="tabs">
		    <li id="tabs1"><a href="#tab1"><?php echo $tab1; ?></a></li>
			<li id="tabs2"><a href="#tab2"><?php echo $tab2; ?></a></li>
			<li id="tabs3"><a href="#tab3"><?php echo $tab3; ?></a></a></li>
			<li id="tabs4"><a href="#tab4"><?php echo $tab4; ?></a></li>
		</ul>
		<div class="tab-container">
		    <div id="tab1" class="tab-content">
			    <ul>
				    <?php
					$popPosts = new WP_Query();
					$popPosts->query('caller_get_posts=1&showposts=5&orderby=comment_count');
					while ($popPosts->have_posts()) : $popPosts->the_post(); ?>
					<li>
					    <div class="image">
						    <a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail('feature'); } else { ?><img src="<?php bloginfo('template_directory'); ?>/includes/timthumb.php?src=<?php echo catch_that_image() ?>&amp;h=41&amp;w=41" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /> <?php } ?></a>
						</div><!--image-->
						<div class="inside">
						    <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
							<span class="meta"><?php the_time(get_option('date_format')) ?><span class="meta-sep"> / </span><?php comments_popup_link(__('No comments', 'wpnuke'), __('1 Comment', 'wpnuke'), __('% Comments', 'wpnuke')); ?></span>
						</div><!--inside-->
					</li>
					<?php endwhile; ?>
					<?php wp_reset_query(); ?>
				</ul>
			</div><!--tab-content-->
			<div id="tab2" class="tab-content">
			    <ul>
				    <?php
					$recentPosts = new WP_Query();
					$recentPosts->query('caller_get_posts=1&showposts=5');
					while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
					<li>
					    <div class="image">
						    <a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail('feature'); } else { ?><img src="<?php bloginfo('template_directory'); ?>/includes/timthumb.php?src=<?php echo catch_that_image() ?>&amp;h=41&amp;w=41" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" /> <?php } ?></a>
						</div><!--image-->
						<div class="inside">
						    <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
							<span class="meta"><?php the_time(get_option('date_format')) ?><span class="meta-sep"> / </span><?php comments_popup_link(__('No comments', 'wpnuke'), __('1 Comment', 'wpnuke'), __('% Comments', 'wpnuke')); ?></span>
						</div><!--inside-->
					</li>
					<?php endwhile;?>
					<?php wp_reset_query(); ?>
				</ul>
			</div><!--tab-content-->
			<div id="tab3" class="tab-content">
			    <ul>
				    <?php
					$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,70) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT 5";
					$comments = $wpdb->get_results($sql);
					foreach ($comments as $comment) :
					?>
					<li>
					    <div class="image">
						    <a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> <?php _e('on ', 'wpnuke'); ?><?php echo $comment->post_title; ?>"><?php echo get_avatar( $comment, '50' ); ?></a>
						</div><!--image-->
						<div class="inside">
						    <h5><a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> <?php _e('on ', 'wpnuke'); ?><?php echo $comment->post_title; ?>"><?php echo strip_tags($comment->comment_author); ?>: <?php echo strip_tags($comment->com_excerpt); ?></a></h5>
						</div><!--inside-->
					</li>
					<?php endforeach; ?>
					<?php wp_reset_query(); ?>
				</ul>
			</div><!--tab-content-->
			<div id="tab4" class="tab-content">
			    <div class="tab-tags">
				    <?php wp_tag_cloud('largest=12&smallest=12&unit=px'); ?>
					<?php wp_reset_query(); ?>
					<div class="clear"></div>
				</div><!--tab-tags-->
			</div><!--tab-content-->
			<div class="clear"></div>
		</div><!--tab-container-->
		<div class="clear"></div>
		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	// Update and save widget
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['tab1'] = $new_instance['tab1'];
		$instance['tab2'] = $new_instance['tab2'];
		$instance['tab3'] = $new_instance['tab3'];
		$instance['tab4'] = $new_instance['tab4'];
		
		return $instance;
	}
	
	// Widget settings
	function form( $instance ) {
	
		/* Set up some default widget settings. */
		$defaults = array(
		'tab1' => 'Popular',
		'tab2' => 'Recent',
		'tab3' => 'Comments',
		'tab4' => 'Tags',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab1' ); ?>"><?php _e('Tab 1 Title:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tab1' ); ?>" name="<?php echo $this->get_field_name( 'tab1' ); ?>" value="<?php echo $instance['tab1']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tab2' ); ?>"><?php _e('Tab 2 Title:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tab2' ); ?>" name="<?php echo $this->get_field_name( 'tab2' ); ?>" value="<?php echo $instance['tab2']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tab3' ); ?>"><?php _e('Tab 3 Title:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tab3' ); ?>" name="<?php echo $this->get_field_name( 'tab3' ); ?>" value="<?php echo $instance['tab3']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tab4' ); ?>"><?php _e('Tab 4 Title:', 'wpnuke') ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tab4' ); ?>" name="<?php echo $this->get_field_name( 'tab4' ); ?>" value="<?php echo $instance['tab4']; ?>" />
		</p>	
	
	<?php
	}
}
?>