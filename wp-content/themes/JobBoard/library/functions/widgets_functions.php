<?php
//Begin widget code
if ( function_exists('register_sidebars') )
  {
	register_sidebars(1,array('name' => 'Header: Right Area', 'description' => 'The widgets added in this area will be displayed at the right hand site of the site title.', 'id' => 'header-top-right-widget-area','before_widget' => '','after_widget' => '','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	register_sidebars(1,array('name' => 'Header: Search Area', 'description' => 'You can use the search widget in this area. It will be displayed below the site title bar.', 'id' => 'header-search-widget-area','before_widget' => '','after_widget' => '','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	register_sidebars(1,array('name' => 'Header Navigation', 'description' => 'The main header navigation are where you can place the "Custom menu" widget.', 'before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	register_sidebars(1,array('name' => 'Home Page Sidebar', 'description' => 'The widgets placed will be displayed in right hand side of the following pages : Home, All, Full Time, Part Time and Freelance.', 'id' => 'home-page-sidebar','before_widget' => '<ul><li class="widget">','after_widget' => '</li></ul>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	register_sidebars(1,array('name' => 'Post a Job Page: Sidebar', 'description' => 'The widgets placed will be displayed in right hand side of the "Post a Job" page.', 'id' => 'post-job-sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	register_sidebars(1,array('name' => 'Post a Resume Page: Sidebar', 'description' => 'The widgets placed will be displayed in right hand side of the "Post a Resume" page.', 'id' => 'post-resume-sidebar','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	register_sidebars(1,array('name' => 'Job Listing: Sidebar', 'description' => 'The widgets placed will be displayed in right hand side of the Jobs listing page.', 'id' => 'job-listing-area','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
	register_sidebars(1,array('name' => 'Resume Listing: Sidebar', 'description' => 'The widgets placed will be displayed in right hand side of the Resumes listing page.','id' => 'resume-listing-area','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
   register_sidebars(1,array('name' => 'Job Detail Page: Sidebar', 'description' => 'The widgets placed will be displayed in right hand side of the Jobs Detail page.','id' => 'job-detail-area','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
   register_sidebars(1,array('name' => 'Resume Detail Page: Sidebar', 'description' => 'The widgets placed will be displayed in right hand side of the Resumes Detail page.','id' => 'resume-detail-area','before_widget' => '<div class="widget">','after_widget' => '</div>','before_title' => '<h3><span>','after_title' => '</span></h3>'));
   register_sidebars(1,array('name' => 'Footer Area Link Widget', 'description' => 'The widgets placed will be displayed Footer below the "Copyright" text.','id' => 'footer-area','before_widget' => '','after_widget' => '','before_title' => '','after_title' => ''));
  }
  
add_action( 'widgets_init', 'example_load_widgets' );

function example_load_widgets() {
	register_widget( 'Example_Widget' );
}

class Example_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Example_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Featured', 'description' => __('Displays a list of featured companies. You can upload the logos of the companies along with their site URL.') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'example-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'example-widget', __('T &rarr; Featured Companies'), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$logo = array();
		$url = array();
		if($instance['logo1'])
		{
			$logo[] = $instance['logo1'];
			$url[] = $instance['url1'];
		}
		if($instance['logo2'])
		{
			$logo[] = $instance['logo2'];
			$url[] = $instance['url2'];
		}
		if($instance['logo3'])
		{
			$logo[] = $instance['logo3'];
			$url[] = $instance['url3'];
		}
		if($instance['logo4'])
		{
			$logo[] = $instance['logo4'];
			$url[] = $instance['url4'];
		}		
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		?>
        <ul class="featured_companies">
       <?php 
	   if($logo)
	   {
	   	for($i=0;$i<count($logo);$i++)
		{
		?>
        <li><a href="<?php echo  $url[$i];?>"><img src="<?php echo $logo[$i];?>" alt="<?php echo $url[$i];?>"></a></li>
        <?php
		}
	   }
	   ?>
        </ul>
        <?php
		
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['logo1'] = strip_tags( $new_instance['logo1'] );
		$instance['url1'] = strip_tags( $new_instance['url1'] );
		$instance['logo2'] = strip_tags( $new_instance['logo2'] );
		$instance['url2'] = strip_tags( $new_instance['url2'] );
		$instance['logo3'] = strip_tags( $new_instance['logo3'] );
		$instance['url3'] = strip_tags( $new_instance['url3'] );
		$instance['logo4'] = strip_tags( $new_instance['logo4'] );
		$instance['url4'] = strip_tags( $new_instance['url4'] );
		
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Featured Companies') );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'logo1' ); ?>"><?php _e('Logo1:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'logo1' ); ?>" name="<?php echo $this->get_field_name( 'logo1' ); ?>" value="<?php echo $instance['logo1']; ?>" style="width:100%;" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'url1' ); ?>"><?php _e('Logo1 URL:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'url1' ); ?>" name="<?php echo $this->get_field_name( 'url1' ); ?>" value="<?php echo $instance['url1']; ?>" style="width:100%;" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'logo2' ); ?>"><?php _e('Logo2:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'logo2' ); ?>" name="<?php echo $this->get_field_name( 'logo2' ); ?>" value="<?php echo $instance['logo2']; ?>" style="width:100%;" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'url2' ); ?>"><?php _e('Logo2 URL:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'url2' ); ?>" name="<?php echo $this->get_field_name( 'url2' ); ?>" value="<?php echo $instance['url2']; ?>" style="width:100%;" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'logo3' ); ?>"><?php _e('Logo3:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'logo3' ); ?>" name="<?php echo $this->get_field_name( 'logo3' ); ?>" value="<?php echo $instance['logo3']; ?>" style="width:100%;" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'url3' ); ?>"><?php _e('Logo3 URL:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'url3' ); ?>" name="<?php echo $this->get_field_name( 'url3' ); ?>" value="<?php echo $instance['url3']; ?>" style="width:100%;" />
		</p>
        <p>
			<label for="<?php echo $this->get_field_id( 'logo4' ); ?>"><?php _e('logo4:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'logo4' ); ?>" name="<?php echo $this->get_field_name( 'logo4' ); ?>" value="<?php echo $instance['logo4']; ?>" style="width:100%;" />
		</p>
        
        <p>
			<label for="<?php echo $this->get_field_id( 'url4' ); ?>"><?php _e('Logo4 URL:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'url4' ); ?>" name="<?php echo $this->get_field_name( 'url4' ); ?>" value="<?php echo $instance['url4']; ?>" style="width:100%;" />
		</p>
        
      

	<?php
	}
}

// =============================== Advt Sidebar 244x188px Widget ======================================
class advtwidget extends WP_Widget {
	function advtwidget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Advt 244x188px', 'description' => 'Display your Advertisement.' );		
		$this->WP_Widget('widget_advt', 'T &rarr; Sidebar Advt 244x188px', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$advt1 = empty($instance['advt1']) ? '' : apply_filters('widget_advt1', $instance['advt1']);
		$advt_link1 = empty($instance['advt_link1']) ? '' : apply_filters('widget_advt_link1', $instance['advt_link1']);
		 ?>
        <div class="sidebanner">
          <?php if ( $advt1 <> "" ) { ?>
            <div class="Sponsors">
              <a href="<?php echo $advt_link1; ?>"><img src="<?php echo $advt1; ?> " alt="" class="ads" /></a>
            </div>  
          <?php } ?>
        </div>
<?php
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['advt1'] = ($new_instance['advt1']);
		$instance['advt_link1'] = ($new_instance['advt_link1']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'advt1' => '', 'advt_link1' => '', 'advt2' => '', 'advt_link2' => '' ) );		
		$title = strip_tags($instance['title']);
		$advt1 = ($instance['advt1']);
		$advt_link1 = ($instance['advt_link1']);
 ?>
<p>
  <label for="<?php echo $this->get_field_id('advt1'); ?>"><?php echo ADVT_IMAGE_PATH_TEXT;?>
    <input class="widefat" id="<?php echo $this->get_field_id('advt1'); ?>" name="<?php echo $this->get_field_name('advt1'); ?>" type="text" value="<?php echo esc_attr($advt1); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('advt_link1'); ?>"><?php echo ADVT_LINK_TEXT;?>
    <input class="widefat" id="<?php echo $this->get_field_id('advt_link1'); ?>" name="<?php echo $this->get_field_name('advt_link1'); ?>" type="text" value="<?php echo esc_attr($advt_link1); ?>" />
  </label>
</p>
<?php
	}}
register_widget('advtwidget');

// =============================== Advt Sidebar 244x188px Widget Ends ======================================

// =============================== Login & Dashboard widget ======================================

class widget_listing_link extends WP_Widget {
	function widget_listing_link() {
	//Constructor
		$widget_ops = array('classname' => 'widget Featured Video', 'description' => __('Displays links for Login, Registration and User Dashboard.'));
		$this->WP_Widget('listing_link', __('T &rarr; Login & Dashboard widget'), $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		?>
        <?php
        global $current_user;
        if($current_user->ID == '')
        {
        ?>
        <h2><?php _e(WELCOME_GUEST_TEXT);?></h2>
            <ul>
                <li><a href="<?php echo get_option('siteurl');?>/?page=register&ptype=login"><?php _e(LOGIN_TEXT);?></a></li>
                <?php if ( get_option('users_can_register') ) { ?>
                <li><a href="<?php echo get_option('siteurl');?>/?page=register"><?php _e(REGISTRATION_TEXT);?></a></li>
                <?php } ?>
            </ul>
          
        <?php
        }else
        {
        ?>
        <h2><?php _e(WELCOME_TEXT);?> <?php echo $current_user->nickname; ?>,</h2>
        
        <ul>
            <li><a href="<?php echo get_author_link($echo = false, $current_user->ID);?>"><?php _e(MY_DASHBOARD_TEXT);?></a></li>
            <li><a href="<?php echo get_option('siteurl');?>/?page=profile"><?php _e(EDIT_PROFILE_TEXT);?></a></li>
            <li><a href="<?php echo get_option('siteurl');?>/?page=register&action=logout"><?php _e(LOGOUT_TEXT);?></a></li>
        </ul>
        
        <?php
        }
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = strip_tags($instance['title']);
?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php  echo TITLE_TEXT;?>
    :
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<?php
	}
}
register_widget('widget_listing_link');
// =============================== Login & Dashboard widget Ends ======================================

// =============================== Connect Widget ======================================
class social_media extends WP_Widget {
	function social_media() {
	//Constructor

		$widget_ops = array('classname' => 'widget Social Media', 'description' => apply_filters('templ_socialmedia_widget_desc_filter',__('Displays social media sharing buttons.','templatic')) );		
		$this->WP_Widget('social_media', apply_filters('templ_socialmedia_widget_title_filter',__('T &rarr; Social media','templatic')), $widget_ops);

	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$twitter = empty($instance['twitter']) ? '' : apply_filters('widget_twitter', $instance['twitter']);
		$facebook = empty($instance['facebook']) ? '' : apply_filters('widget_facebook', $instance['facebook']);
		$email = empty($instance['email']) ? '' : apply_filters('widget_email', $instance['email']);
		$rss = empty($instance['rss']) ? '' : apply_filters('widget_rss', $instance['rss']);
		 ?>
          <?php if($title): ?>
	          <h3><span><?php _e($title,'templatic');?></span></h3>
          <?php endif; ?>    
          <ul>
            <?php if ( $facebook <> "" ) { ?>
            <li> <a href="<?php echo $facebook; ?>" class="i_face"> <?php echo FACEBOOK; ?></a></li>
            <?php } ?>
            <?php if ( $email <> "" ) { ?>
            <li> <a href="<?php echo $email; ?>" class="i_email"> <?php echo EMAIL; ?></a></li>
            <?php } ?>
            <?php if ( $rss <> "" ) { ?>
            <li> <a href="<?php echo $rss; ?>" class="i_rss"> <?php echo RSS; ?></a></li>
            <?php } ?>
            <?php if ( $twitter <> "" ) { ?>
            <li><a href="<?php echo $twitter; ?>" class="i_twitter"><?php echo TWITT; ?></a></li>
            <?php } ?>
          </ul>
<!-- widget #end -->
<?php
	echo $after_widget;
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['twitter'] = ($new_instance['twitter']);
		$instance['facebook'] = ($new_instance['facebook']);
		$instance['email'] = ($new_instance['email']);
		$instance['rss'] = ($new_instance['rss']);
		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'twitter' => '', 'facebook' => '', 'email' => '', 'rss' => '' ) );		
		$title = strip_tags($instance['title']);
		$twitter = ($instance['twitter']);
		$facebook = ($instance['facebook']);
		$email = ($instance['email']);
		$rss = ($instance['rss']);
?>
<p><?php echo SOCIAL_MEDIA_CON; ?></p>
<p>
  <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php echo TWITTER_URL_TEXT;?>:
    <input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php echo FACEBOOK_URL_TEXT;?> :
    <input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($facebook); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('email'); ?>"><?php echo EMAIL_URL_TEXT;?> :
    <input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo esc_attr($email); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('rss'); ?>"><?php echo RSS_URL_TEXT;?> :
    <input class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" type="text" value="<?php echo esc_attr($rss); ?>" />
  </label>
</p>
<?php
	}}
register_widget('social_media');
// =============================== Connect Widget Ends ======================================

/* ===== Search By Job and Location widget BOF ===== */
if(!class_exists('templ_searchbyjob')){
	class templ_searchbyjob extends WP_Widget {
		function templ_searchbyjob() {
		//Constructor
			$widget_ops = array('classname' => 'searchByJob', 'description' => 'A search widget to search by Job and Location.' );
		   $this->WP_Widget('templ_searchbyjob', 'T &rarr; Search By Job and Location', $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? 'Search : ' : apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		 ?>
         <?php include (TEMPLATEPATH . "/library/includes/searchform.php"); ?>
<?php
		echo $after_widget;
		}
		function update($new_instance, $old_instance) {
		//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
		}
		function form($instance) {
		//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 't1' => '', 't2' => '', 't3' => '',  'img1' => '', 'desc1' => '' ) );		
		$title = strip_tags($instance['title']);
		?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT;?>:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<?php			
	}}
	register_widget('templ_searchbyjob');
}

/* ===== Search By Job and Location widget EOF ===== */


/******Category listing widget BOF*******/
class category_listing extends WP_Widget {
	function category_listing() {
	//Constructor
		$widget_ops = array('classname' => 'widget Category wise listing', 'description' => __('Displays a list of Job OR Resume categories.') );
		$this->WP_Widget('cat_listing', __('T &rarr; Categories'), $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$post_category_type = empty($instance['post_category_type']) ? '' : apply_filters('widget_post_type', $instance['post_category_type']);
		$show_count = empty($instance['show_count']) ? '' : apply_filters('widget_show_count', $instance['show_count']);

		 global $post;
	
		//list terms in a given taxonomy using wp_list_categories  (also useful as a widget)
		$orderby = 'name';
		$show_count = $show_count; // 1 for yes, 0 for no
		$pad_counts = 0; // 1 for yes, 0 for no
		$hierarchical = 1; // 1 for yes, 0 for no
		$taxonomy = $post_category_type;
		
		$args = array(
		  'orderby' => $orderby,
		  'show_count' => $show_count,
		  'pad_counts' => $pad_counts,
		  'hierarchical' => $hierarchical,
		  'taxonomy' => $taxonomy,
		  'title_li' => ''
		);
		echo "<h3>".$title."</h3>";
		?>
		<ul class="categorywise_listing_widget">
		<?php
		wp_list_categories($args);
		?>
		</ul>
	<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_category_type'] = strip_tags($new_instance['post_category_type']);
		$instance['show_count'] = strip_tags($new_instance['show_count']);

		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$my_post_type = strip_tags($instance['post_category_type']);
		$show_count = strip_tags($instance['show_count']);


?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:');?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_category_type'); ?>"><?php _e('Post type:');?>
     <select id="<?php echo $this->get_field_id('post_category_type'); ?>" name="<?php echo $this->get_field_name('post_category_type'); ?>" style="width:50%;">
		<option value="<?php echo CUSTOM_CATEGORY_TYPE1; ?>" <?php if(attribute_escape($my_post_type)==CUSTOM_CATEGORY_TYPE1){ echo 'selected="selected"';}?>><?php _e(CUSTOM_MENU_TITLE,'templatic'); ?></option>
		<option value="<?php echo CUSTOM_CATEGORY_TYPE2; ?>" <?php if(attribute_escape($my_post_type)==CUSTOM_CATEGORY_TYPE2){ echo 'selected="selected"';}?>><?php _e(CUSTOM_MENU_TITLE2,'templatic'); ?></option>
			  
	</select>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('show_count'); ?>"><?php _e('Show post count with category :');?>
    <select id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" style="width:50%;">
		<option value="1" <?php if(attribute_escape($show_count)==1){ echo 'selected="selected"';}?>><?php _e('Yes','templatic'); ?></option>
		<option value="0" <?php if(attribute_escape($show_count)==0){ echo 'selected="selected"';}?>><?php _e('No','templatic'); ?></option>
			  
	</select> </label>
</p>

<?php
	}
}
register_widget('category_listing');
/******Category listing widget EOF*******/


/******Tag listing widget BOF*******/
class tag_listing_widget extends WP_Widget {
	function tag_listing_widget() {
	//Constructor
		$widget_ops = array('classname' => 'widget tag wise listing', 'description' => __('Displays a list of Job OR Resume Tags.') );
		$this->WP_Widget('tag_listing_widget', __('T &rarr; Tag wise listing'), $widget_ops);
	}

	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$post_tag_type = empty($instance['post_tag_type']) ? '' : apply_filters('widget_post_type', $instance['post_tag_type']);
		$show_count = empty($instance['show_count']) ? '' : apply_filters('widget_show_count', $instance['show_count']);

		 global $post;
	
		//list terms in a given taxonomy using wp_tag_cloud (also useful as a widget)
		$orderby = 'name';
		$show_count = $show_count; // 1 for yes, 0 for no
		$pad_counts = 0; // 1 for yes, 0 for no
		$hierarchical = 1; // 1 for yes, 0 for no
		$taxonomy = $post_tag_type;
		if(!$taxonomy){ $taxonomy = CUSTOM_TAG_TYPE1; }
		$args = array(
		'smallest'                  => 8, 
		'largest'                   => 22,
		'unit'                      => 'pt', 
		'number'                    => $show_count,  
		'format'                    => 'flat',
		'separator'                 => ", ",
		'orderby'                   => 'name', 
		'order'                     => 'ASC',
		'exclude'                   => null, 
		'include'                   => null, 
		'topic_count_text_callback' => default_topic_count_text,
		'link'                      => 'view', 
		'taxonomy'                  => $taxonomy, 
		'echo'                      => true );
		echo "<h3>".$title."</h3>";
		?>
		<ul class="tagwise_listing_widget">
		<?php
		wp_tag_cloud( $args );
		?>
		</ul>
	<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_tag_type'] = strip_tags($new_instance['post_tag_type']);
		$instance['show_count'] = strip_tags($new_instance['show_count']);

		return $instance;

	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'post_number' => '' ) );
		$title = strip_tags($instance['title']);
		$my_post_type_tag = strip_tags($instance['post_tag_type']);
		$show_count = strip_tags($instance['show_count']);
		if(!$show_count){ $show_count = "45"; }

?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:');?>
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_tag_type'); ?>"><?php _e('Post type:');?>
     <select id="<?php echo $this->get_field_id('post_tag_type'); ?>" name="<?php echo $this->get_field_name('post_tag_type'); ?>" style="width:50%;">
		<option value="<?php echo CUSTOM_TAG_TYPE1; ?>" <?php if(attribute_escape($my_post_type_tag)== CUSTOM_TAG_TYPE1){ echo 'selected="selected"';}?>><?php _e(CUSTOM_MENU_TITLE,'templatic'); ?></option>
		<option value="<?php echo CUSTOM_TAG_TYPE2; ?>" <?php if(attribute_escape($my_post_type_tag)== CUSTOM_TAG_TYPE2){ echo 'selected="selected"';}?>><?php _e(CUSTOM_MENU_TITLE2,'templatic'); ?></option>
			  
	</select>
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('show_count'); ?>"><?php _e('Show number of tags :');?>

	    <input class="widefat" id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" type="text" value="<?php echo attribute_escape($show_count); ?>" /></label>

</p>

<?php
	}

}
register_widget('tag_listing_widget');

/******Tag listing widget EOF*******/

/*-latest Jobs widget EOF -*/

class tmpl_latest_job extends WP_Widget {
		function tmpl_latest_job() {
		//Constructor
			$widget_ops = array('classname' => 'latestJob', 'description' => 'Displays a list of the Latest Jobs.' );	
			$this->WP_Widget('tmpl_latest_job','T &rarr; Latest Jobs', $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? 'Recently Added Jobs' : apply_filters('widget_title', $instance['title']);
		$post_number = empty($instance['post_number']) ? '&nbsp;' : apply_filters('widget_post_number', $instance['post_number']);
		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);

		global $post;
		$userid =  $post->post_author;
		$user_details = get_userdata( $userid );
		
		global $wpdb;
		if($category)
					{
						$arg = "AND $wpdb->posts.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category)  )";	
					}
				$post_content = $wpdb->get_results("SELECT DISTINCT $wpdb->posts.*
				FROM $wpdb->posts, $wpdb->postmeta
				WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
				AND $wpdb->posts.post_status = 'publish' 
				AND $wpdb->posts.post_type = '".CUSTOM_POST_TYPE1."'
				$arg 
				ORDER BY (SELECT $wpdb->postmeta.meta_value from $wpdb->postmeta where ($wpdb->posts.ID = $wpdb->postmeta.post_id) AND $wpdb->postmeta.meta_key = 'featured_h' AND $wpdb->postmeta.meta_value = 'h') DESC,$wpdb->posts.ID DESC LIMIT 0,$post_number");


		?>
            <div class="similar-pro">
              <div class="title-container">
                <h3><span><?php echo $title;?></span></h3>
                <ul class="nav_recent">
					<?php
                    foreach($post_content as $key=>$val)
                    {
                       $post_id = $val->ID;
					?>   
						<li>
						<?php if(get_post_meta($post_id,'company_logo', $single = true) != ""): ?>
						   <a href="<?php echo get_permalink($post_id); ?>"><img class="company_logo" src="<?php echo get_post_meta($post_id,"company_logo",$single = true); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" width="60"  /></a>
                        <?php else: ?>
                        	<a href="<?php echo get_permalink($post_id); ?>"><img class="company_logo" src="<?php echo get_bloginfo('template_directory'); ?>/images/no-image.png" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" width="60" /></a>
                        <?php endif; ?>    
					   <h4>
                       		<a href="<?php echo get_permalink($post_id); ?>"><?php echo $val->post_title; ?></a>
					   		<span><?php echo get_post_meta($post_id,'company_name', $single = true); ?></span>
                       </h4>
                       </li>
                    <?php
                    }
                    ?>
			  </ul>
              </div>
            </div>
<?php
		echo $after_widget;
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['category'] = strip_tags($new_instance['category']);
			$instance['post_number'] = strip_tags($new_instance['post_number']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ,'post_number' => '','category' => '' ) );		
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo WIDGET_TITLE_TEXT;?>:
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php echo NUMBER_OF_POSTS_TEXT;?>:
    <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('category'); ?>"><?php echo CATEGORY_ID_TEXT;?>:
    <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
  </label>
</p>
<?php
	}}
register_widget('tmpl_latest_job');

/*-latest Jobs widget EOF -*/


/*-latest Resumes widget BOF -*/

class tmpl_latest_resume extends WP_Widget {
		function tmpl_latest_resume() {
		//Constructor
			$widget_ops = array('classname' => 'latestResume', 'description' => 'Displays a list of the Latest Resumes.' );
			$this->WP_Widget('tmpl_latest_resume','T &rarr; Latest Resumes', $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? 'Recently Added Resumes' : apply_filters('widget_title', $instance['title']);
		$post_number = empty($instance['post_number']) ? '3' : apply_filters('widget_post_number', $instance['post_number']);
		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);

		global $post;
		$userid =  $post->post_author;
		$user_details = get_userdata( $userid );
		
		global $wpdb;
		if($category)
				{
					$arg = "AND $wpdb->posts.ID in (select tr.object_id from $wpdb->term_relationships tr join $wpdb->term_taxonomy t on t.term_taxonomy_id=tr.term_taxonomy_id where t.term_id in ($category)  )";	
				}
				$post_content = $wpdb->get_results("SELECT DISTINCT $wpdb->posts.*
				FROM $wpdb->posts, $wpdb->postmeta
				WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
				AND $wpdb->posts.post_status = 'publish' 
				AND $wpdb->posts.post_type = '".CUSTOM_POST_TYPE2."'
				$arg 
				ORDER BY (SELECT $wpdb->postmeta.meta_value from $wpdb->postmeta where ($wpdb->posts.ID = $wpdb->postmeta.post_id) AND $wpdb->postmeta.meta_key = 'featured_h' AND $wpdb->postmeta.meta_value = 'h') DESC,$wpdb->posts.ID DESC LIMIT 0,$post_number");


		?>
            <div class="similar-pro">
              <div class="title-container">
                <h3><span><?php _e(LATEST_RESUMES_TEXT);?></span></h3>
                <ul class="nav_recent">
					<?php
                    foreach($post_content as $key=>$val)
                    {
                       $post = $val->ID;
					?>   
					   <li>
                       		<?php 
                             global $current_user;
							 $role =  $current_user->roles[0];
						 	 $author = $val->post_author;
							 $email = get_user_meta( $author, 'user_email', true );
							?>
	                       <?php if($role == "Job Provider" || current_user_can( 'administrator')): ?>
                       	   		<a class="recent-icon" href="<?php echo get_permalink($post); ?>"><?php echo get_avatar( $email,40); ?></a>
                           <?php else: ?>     
	                           <a class="recent-icon"><?php echo get_avatar( $email,40); ?></a>
                           <?php endif; ?>     
                           <h4>
                           		<label><?php echo get_post_meta($post,'fname', $single = true)." ".get_post_meta($post,'lname', $single = true); ?></label>
                           		<?php if($role == "Job Provider" || current_user_can( 'administrator')): ?>
	                                <a class="resume-link" href="<?php echo get_permalink($post); ?>"><?php echo $val->post_title; ?></a>
                                <?php else: ?>
	                                <a class="resume-link"><?php echo $val->post_title; ?></a>
                                <?php endif; ?>    
                           </h4>
                       </li>
                    <?php
                    }
                    ?>
			  </ul>
              </div>
            </div>
		<?php
		echo $after_widget;
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;		
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['category'] = strip_tags($new_instance['category']);
			$instance['post_number'] = strip_tags($new_instance['post_number']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ,'post_number' => '','category' => '' ) );		
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo WIDGET_TITLE_TEXT;?>:
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
          </label>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php echo NUMBER_OF_POSTS_TEXT;?>:
            <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
          </label>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('category'); ?>"><?php echo CATEGORY_ID_TEXT;?>:
            <input class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" type="text" value="<?php echo esc_attr($category); ?>" />
          </label>
        </p>
<?php
	}}
register_widget('tmpl_latest_resume');

/*-latest Resume widget EOF -*/


/*-other Jobs widget BOF -*/

class tmpl_other_job extends WP_Widget {
		function tmpl_other_job() {
		//Constructor
			$widget_ops = array('classname' => 'otherJob', 'description' => 'Display a list of Jobs posted by a Particular Company.' );
			$this->WP_Widget('tmpl_other_job','T &rarr; Other Jobs Listed by the Company', $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? 'Other Jobs Listed by the Company' : apply_filters('widget_title', $instance['title']);
		$post_number = empty($instance['post_number']) ? '' : apply_filters('widget_post_number', $instance['post_number']);
		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
				global $post,$wpdb;
				$post_id=$post->ID;
				$company_name = get_post_meta($post_id,"company_name",$single = true);
				if($post_number):
					$limit = $post_number;
				else:
					$limit = 5;
				endif;	
						$query = "SELECT DISTINCT $wpdb->posts.*
								FROM $wpdb->posts, $wpdb->postmeta
								WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
								AND $wpdb->posts.post_status = 'publish' 
								AND $wpdb->posts.post_type = '".CUSTOM_POST_TYPE1."'
								AND $wpdb->postmeta.meta_key = 'company_name'
								AND $wpdb->postmeta.meta_value LIKE '%".$company_name."%'
								AND $wpdb->posts.ID != ".$post_id."
								order by $wpdb->posts.ID LIMIT 0 ,$limit";
				$post_content1 = $wpdb->get_results($query);
				if($post_content1)
				{
				?>
                <h3><span><?php echo $title; ?></span></h3>
                    <ul class="nav_recent">
                     <?php foreach($post_content1 as $_post): ?>
                        <li>
                            <?php if(get_post_meta($_post->ID,'company_logo', $single = true)): ?>
                                <a href="<?php echo get_permalink($_post->ID); ?>" ><img src="<?php echo get_post_meta($_post->ID,'company_logo', $single = true); ?>" border="0" class="company_logo" /></a>
                            <?php else: ?>
                                 <a href="<?php echo get_permalink($_post->ID); ?>" ><img src="<?php bloginfo("template_directory"); ?>/images/no-image.png" alt=""  class="company_logo" /></a>
                            <?php endif; ?>
                            <h4>
                                <a href="<?php echo get_permalink($_post->ID); ?>"><?php echo get_the_title($_post->ID);?></a>
                                <span><?php echo get_post_meta($_post->ID,"company_name",$single = true); ?></span>
                            </h4>
                        </li>
                     <?php endforeach; ?>   
                    </ul>
			<?php }?>
		<?php
		echo $after_widget;
		}
		function update($new_instance, $old_instance) {
		//save the widget
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['category'] = strip_tags($new_instance['category']);
			$instance['post_number'] = strip_tags($new_instance['post_number']);
			return $instance;
		}
		function form($instance) {
		//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ,'post_number' => '','category' => '' ) );
		$title = strip_tags($instance['title']);
		$category = strip_tags($instance['category']);
		$post_number = strip_tags($instance['post_number']);
		?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php echo WIDGET_TITLE_TEXT;?>:
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
          </label>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php echo NUMBER_OF_POSTS_TEXT;?>:
            <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo attribute_escape($post_number); ?>" />
          </label>
        </p>
<?php
	}}
register_widget('tmpl_other_job');

/*-other Jobs widget EOF -*/

?>