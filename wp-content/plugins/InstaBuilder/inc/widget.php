<?php if ( !defined('ABSPATH') ) die('No direct access');
class oplSidebarOptin extends WP_Widget {

	function oplSidebarOptin() {
		$instance = array('description' => 'Drag this widget to display an optin form in your blog sidebar.' );
		parent::WP_Widget(false, 'InstaBuilder Sidebar Optin', $instance);      
	}

	function widget($args, $instance) {  
		extract($args);
		
		$title       = ( opl_isset($instance['title']) != '' ) ? stripslashes(esc_attr($instance['title'])) : 'Get FREE Stuff Now!';
		$resp        = opl_isset(stripslashes($instance['resp']));
		$instruction = ( opl_isset($instance['instruction_txt']) != '' ) ? stripslashes(esc_attr($instance['instruction_txt'])) : 'Enter your name and email below to GET INSTANT ACCESS!';
		$name_label  = ( opl_isset($instance['name_label']) != '' ) ? stripslashes(esc_attr($instance['name_label'])) : '** Your name here';
		$email_label = ( opl_isset($instance['email_label']) != '' ) ? stripslashes(esc_attr($instance['email_label'])) : '** Your email here';
		$btn_color   = opl_isset(stripslashes(esc_attr($instance['btn_color'])));
		$btn_label   = opl_isset(stripslashes(esc_attr($instance['btn_label'])));
		$privacy     = ( opl_isset($instance['privacy']) != '' ) ? stripslashes(esc_attr($instance['privacy'])) : 'Your privacy is SAFE';

		echo $before_widget;

		echo '<div class="opl-sidebar-optin">';
		echo '<h2 class="opl-sidebar-optin-title">' . $title . '</h2>';

		if ( $instruction != '' ) echo '<p>' . $instruction . '</p>';

		$form = opl_extract_fields( $resp, $name_label, $email_label );
		
		echo '<form method="post" id="opl-widget-submit_' . $id . '" action="' . opl_isset($form['action']) . '">' . "\n";
		if ( isset($form['fields']) && is_array($form['fields']) && count($form['fields']) > 0 ) {
			foreach ( $form['fields'] as $k => $v ) {
				$field_id = ( stristr( $k, 'mail') || stristr( $k, 'from') ) ? 'opl_email' : 'opl_name';
				$field_class = ( stristr( $k, 'mail') || stristr( $k, 'from') ) ? 'opl-email' : 'opl-name';
				echo '<input type="text" name="' . $k . '" value="' . stripslashes($v) . '" id="' . $field_id . '" class="opl-widget-field ' . $field_class . '" onfocus="if ( this.value == \'' . stripslashes($v) . '\') this.value = \'\';" onblur="if ( this.value == \'\') this.value = \'' . stripslashes($v) . '\';" />' . "\n";
			}
		}
		
		if ( isset($form['hiddens']) && is_array($form['hiddens']) && count($form['hiddens']) > 0 ) {
			foreach ( $form['hiddens'] as $k => $v ) {
				echo '<input type="hidden" name="' . $k . '" value="' . $v . '" />' . "\n";
			}
		}
		
		echo '<a href="#" id="opl-widget-btn_' . $id . '" class="opl-btn button btn-' . $btn_color . '"><span>' . $btn_label . '</span></a>';
		
		echo '<p><small>' . $privacy . '</small></p>' . "\n";
		echo '</form>' . "\n";
		
		echo '</div>';
		echo '
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#opl-widget-btn_' . $id . '").click(function(e){
				document.getElementById("opl-widget-submit_' . $id . '").submit();
				e.preventDefault();
			});
		});
		</script>
		';
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {                
		return $new_instance;
	}

	function form( $instance ) {    
		$title       = ( opl_isset($instance['title']) != '' ) ? stripslashes($instance['title']) : 'Get FREE Stuff Now!';
		$resp        = opl_isset(stripslashes($instance['resp']));
		$instruction = ( opl_isset($instance['instruction_txt']) != '' ) ? stripslashes( $instance['instruction_txt'] ) : 'Enter your name and email below to GET INSTANT ACCESS!';
		$name_label  = ( opl_isset($instance['name_label']) != '' ) ? stripslashes( $instance['name_label'] ) : '** Your name here';
		$email_label = ( opl_isset($instance['email_label']) != '' ) ? stripslashes( $instance['email_label'] ) : '** Your email here';
		$btn_color   = opl_isset(stripslashes($instance['btn_color']));
		$btn_label   = opl_isset(stripslashes($instance['btn_label']));
		$privacy     = ( opl_isset($instance['privacy']) != '' ) ? stripslashes( $instance['privacy'] ) : 'Your privacy is SAFE';

		echo '
		<p>
            	<label for="' . $this->get_field_id('title') . '">Title:</label>
            	<input type="text" name="' . $this->get_field_name('title') . '" value="' . $title . '" class="widefat" id="' . $this->get_field_id('title') . '" />
        </p>
		<p>
            	<label for="' . $this->get_field_id('resp') . '">Autoresponder Code:</label>
            	<textarea name="' . $this->get_field_name('resp') . '" class="widefat" id="' . $this->get_field_id('resp') . '">' . $resp . '</textarea>
        </p>
		<p>
            	<label for="' . $this->get_field_id('instruction_txt') . '">Subscribe Instruction:</label>
            	<textarea name="' . $this->get_field_name('instruction_txt') . '" class="widefat" id="' . $this->get_field_id('instruction_txt') . '">' . $instruction . '</textarea>
        	</p>

		<p>
            	<label for="' . $this->get_field_id('name_label') . '">Name Field Label:</label>
            	<input type="text" name="' . $this->get_field_name('name_label') . '" value="' . $name_label . '" class="widefat" id="' . $this->get_field_id('name_label') . '" />
        	</p>

		<p>
            	<label for="' . $this->get_field_id('email_label') . '">Email Field Label:</label>
            	<input type="text" name="' . $this->get_field_name('email_label') . '" value="' . $email_label . '" class="widefat" id="' . $this->get_field_id('email_label') . '" />
        	</p>

		<p>
            	<label for="' . $this->get_field_id('btn_color') . '">Button Color:</label>
            	<select name="' . $this->get_field_name('btn_color') . '" id="' . $this->get_field_id('btn_color') . '" class="widefat">
		';

		$colors = array('yellow' => 'Yellow', 'orange' => 'Orange', 'green' => 'Green', 'blue' => 'Blue', 'grey' => 'Grey', 'red' => 'Red' );
		foreach ( $colors as $color => $option ) {
			$selected = ( $btn_color == $color ) ? ' selected="selected"' : '';
			echo '<option value="' . $color . '"' . $selected . '>' . $option . '</option>';
		}
		
		echo '
		</select>
        	</p>

		<p>
            	<label for="' . $this->get_field_id('btn_label') . '">Button Label:</label>
            	<input type="text" name="' . $this->get_field_name('btn_label') . '" value="' . $btn_label . '" class="widefat" id="' . $this->get_field_id('btn_label') . '" />
        </p>
		<p>
            	<label for="' . $this->get_field_id('privacy') . '">Privacy Notice:</label>
            	<textarea name="' . $this->get_field_name('privacy') . '" class="widefat" id="' . $this->get_field_id('privacy') . '">' . $privacy . '</textarea>
        	</p>
		';
	}
}

add_action( 'widgets_init', 'opl_register_widget' );
function opl_register_widget() {
	register_widget( 'oplSidebarOptin' );
}
