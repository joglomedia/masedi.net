<?php
/**
 * CMSC_Widget Class
 */
if(basename($_SERVER['SCRIPT_FILENAME']) == "widget.class.php"):
    exit;
endif;
class CMSC_Widget extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function CMSC_Widget() {
        parent::WP_Widget(false, $name = 'CMS Commander', array('description' => 'CMS Commander widget.'));	
    }
 
    /** @see WP_Widget::widget -- do not rename this */
    function widget($args, $instance) {	
        extract( $args );
        $instance['title'] = 'CMS Commander';
        $instance['message'] = 'We are happily using <a href="http://cmscommander.com" target="_blank">CMS Commander</a>';
        $title 		= apply_filters('widget_title', $instance['title']);
        $message 	= $instance['message'];
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
							<ul>
								<li><?php echo $message; ?></li>
							</ul>
              <?php echo $after_widget; ?>
        <?php
    }
    
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {	
        $title 		= 'CMS Commander';
        $message	= 'We are happily using <a href="http://cmscommander.com" target="_blank">CMS Commander</a>';
        echo '<p>'.$message.'</p>';
    }
 
 
} // end class example_widget

$cmsc_worker_brand = get_option("cmsc_worker_brand");
$worker_brand = 0;    	
if(is_array($cmsc_worker_brand)){
    		if($cmsc_worker_brand['name'] || $cmsc_worker_brand['desc'] || $cmsc_worker_brand['author'] || $cmsc_worker_brand['author_url']){
    			$worker_brand= 1;
    		} 
}
if(!$worker_brand){
	add_action('widgets_init', create_function('', 'return register_widget("CMSC_Widget");'));
}
?>