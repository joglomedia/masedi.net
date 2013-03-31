<?php
/*
Plugin Name: Blogroll to Page
Plugin URI: http://www.club-wp.com/blogroll-to-page-wordpress-plugin/
Description: Outputs your blogroll to any page or post on your blog by using the [blogroll-to-page] short code. The output parameters listed in the <a href="http://codex.wordpress.org/Function_Reference/wp_list_bookmarks#Parameters" target="_blank">WordPress Codex</a> can be set in the options page which is found under the 'Links' menu. View example output at our <a href="http://www.club-wp.com/wordpress-resources/" target="_blank">WordPress Resources</a> page.
Author: Club Wordpress
Version: 1.0.0
Author URI: http://www.club-wp.com/
*/

/*  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//vars
$pluginoptions = array();

add_action('init', 'get_options');

function get_options() {
  global $pluginoptions, $prefix;
  
  $prefix = 'blogroll_to_page';
  
  //each array item has option field, option value, label text.
  $pluginoptions = array(
    'categorize' =>       array('option_field' => $prefix.'_categorize', 'option_value' => 'true', 'type' => 'check', 'label' => 'Categorize', 'param' => 'categorize'),
    'category' =>         array('option_field' => $prefix.'_category', 'option_value' => '', 'type' => '', 'label' => 'Category', 'param' => 'category'),
    'exclude_category' => array('option_field' => $prefix.'_exclude_category', 'option_value' => '', 'type' => '', 'label' => 'Exclude Category', 'param' => 'exclude_category'),
    'category_name' =>    array('option_field' => $prefix.'_category_name', 'option_value' => '', 'type' => '', 'label' => 'Category Name', 'param' => 'category_name'),
    'category_before' =>  array('option_field' => $prefix.'_category_before', 'option_value' => "<li id='[category id]' class='linkcat'>", 'type' => '', 'label' => 'Category Before', 'param' => 'category_before'),
    'category_after' =>   array('option_field' => $prefix.'_category_after', 'option_value' => '</li>', 'type' => '', 'label' => 'Category After', 'param' => 'category_after'),
    'class' =>            array('option_field' => $prefix.'_class', 'option_value' => 'linkcat', 'type' => '', 'label' => 'Class', 'param' => 'class'),
    'category_orderby' => array('option_field' => $prefix.'_category_orderby', 'option_value' => 'name', 'type' => 'select', 'label' => 'Category Order By', 'param' => 'category_orderby', 
                                'options' => array('name', 'id', 'slug', 'count', 'term_group')),
    'category_order' =>   array('option_field' => $prefix.'_category_order', 'option_value' => 'ASC', 'type' => 'select', 'label' => 'Category Order', 'param' => 'category_order',
                                'options' => array('ASC', 'DESC')),
    'title_li' =>         array('option_field' => $prefix.'_title_li', 'option_value' => "__('Bookmarks')", 'type' => '', 'label' => 'Title List', 'param' => 'title_li'),
    'title_before' =>     array('option_field' => $prefix.'_title_before', 'option_value' => '<h2>', 'type' => '', 'label' => 'Title Before', 'param' => 'title_before'),
    'title_after' =>      array('option_field' => $prefix.'_title_after', 'option_value' => '</h2>', 'type' => '', 'label' => 'Title After', 'param' => 'title_after'),
    'show_private' =>     array('option_field' => $prefix.'_show_private', 'option_value' => 'false', 'type' => 'check', 'label' => 'Show Private', 'param' => 'show_private'),
    'include' =>          array('option_field' => $prefix.'_include', 'option_value' => '', 'type' => '', 'label' => 'Include', 'param' => 'include'),
    'exclude' =>          array('option_field' => $prefix.'_exclude', 'option_value' => '', 'type' => '', 'label' => 'Exclude', 'param' => 'exclude'),
    'orderby' =>          array('option_field' => $prefix.'_orderby', 'option_value' => 'name', 'type' => 'select', 'label' => 'Order By', 'param' => 'orderby',
                                'options' => array('id', 'url', 'name', 'target', 'description', 'owner', 'rating', 'updated', 'rel', 'notes', 'rss', 'length', 'rand')),
    'order' =>            array('option_field' => $prefix.'_order', 'option_value' => 'ASC', 'type' => 'select', 'label' => 'Order', 'param' => 'order',
                          'options' => array('ASC', 'DESC')),
    'after' =>            array('option_field' => $prefix.'_after', 'option_value' => '</li>', 'type' => '', 'label' => 'After', 'param' => 'after '),
    'limit' =>            array('option_field' => $prefix.'_limit', 'option_value' => '-1', 'type' => '', 'label' => 'Limit', 'param' => 'limit'),
    'before' =>           array('option_field' => $prefix.'_before', 'option_value' => '<li>', 'type' => '', 'label' => 'Before', 'param' => 'before '),
    'link_before' =>      array('option_field' => $prefix.'_link_before', 'option_value' => '', 'type' => '', 'label' => 'Link Before', 'param' => 'link_before'),
    'link_after' =>       array('option_field' => $prefix.'_link_after', 'option_value' => '', 'type' => '', 'label' => 'Link After', 'param' => 'link_after'),
    'between' =>          array('option_field' => $prefix.'_between', 'option_value' => '<br />', 'type' => '', 'label' => 'Between', 'param' => 'between'),
    'show_images' =>      array('option_field' => $prefix.'_show_images', 'option_value' => 'true', 'type' => 'check', 'label' => 'Show Images', 'param' => 'show_images'),
    'show_description' => array('option_field' => $prefix.'_show_description', 'option_value' => 'false', 'type' => 'check', 'label' => 'Show Description', 'param' => 'show_description'),
    'show_name' =>        array('option_field' => $prefix.'_show_name', 'option_value' => 'false', 'type' => 'check', 'label' => 'Show Name', 'param' => 'show_name'),
    'show_rating' =>      array('option_field' => $prefix.'_show_rating', 'option_value' => 'false', 'type' => 'check', 'label' => 'Show Rating', 'param' => 'show_rating'),
    'show_updated' =>     array('option_field' => $prefix.'_show_updated', 'option_value' => 'false', 'type' => 'check', 'label' => 'Show Updated', 'param' => 'show_updated'),
    'hide_invisible' =>   array('option_field' => $prefix.'_hide_invisible', 'option_value' => 'true', 'type' => 'check', 'label' => 'Hide Invisible', 'param' => 'hide_invisible'),
    'echo' =>             array('option_field' => $prefix.'_echo', 'option_value' => 'true', 'type' => 'check', 'label' => 'Echo', 'param' => 'echo'),
    'link_back' =>        array('option_field' => $prefix.'_link_back', 'option_value' => 'true', 'type' => 'check', 'label' => 'Include link to <a href="http://www.club-wp.com/blogroll-to-page-wordpress-plugin target="_blank">plugin homepage</a>', 'param' => 'link_back')
    
  );

  //return $pluginoptions;

}

register_activation_hook( __FILE__, 'blogroll_to_page_activate' );
function blogroll_to_page_activate() {

}

register_deactivation_hook( __FILE__, 'blogroll_to_page_deactivate' );
function blogroll_to_page_deactivate() {

}

add_action('admin_menu', 'blogroll_to_page_admin');

function blogroll_to_page_admin() {
	if (function_exists('add_submenu_page')) {
    global $pluginoptions, $prefix;

    $prefix = 'blogroll-to-page';
    $title = 'Blogroll to Page';
    
    
    if ( $_GET['page'].'.php' == basename(__FILE__) ) {
      
      if ( 'Save Changes' == $_REQUEST['Submit'] ) {
        
        // protect against request forgery
        check_admin_referer('blogroll-to-page-save');
        
        // save the options
        foreach ($pluginoptions as $value) {
          if( $value['type'] == 'check') {
            $val = stripslashes($_REQUEST[$value['option_field']]) == 'true' ? 'true' : 'false';
            
            update_option( $value['option_field'], $val );            
          }
          else {
            update_option( $value['option_field'], stripslashes($_REQUEST[$value['option_field']]));
          }
        }
                      
        // return to the options page
        header("Location: link-manager.php?page=blogroll-to-page&Submit=true");
        die;

      } else if ( 'Reset' == $_REQUEST['Reset'] ) {
        // protect against request forgery
        check_admin_referer('blogroll-to-page-save');
        
        // delete the options
        foreach ($pluginoptions as $value) {
          delete_option( $value['option_field'] );
        }
        
        add_options();
        
        // return to the options page
        header("Location: link-manager.php?page=blogroll-to-page&Reset=true");
        die;
      }
    }
    
    add_options();
    
    add_submenu_page( 'link-manager.php', $title.' Admin', $title, 'manage_links', 'blogroll-to-page', 'blogroll_to_page_admin_page');
    
  }
}

function add_options() {

    add_option($prefix.'_categorize', '1', '', 'yes');
    add_option($prefix.'_category', '', '', 'yes');
    add_option($prefix.'_exclude_category', '', '', 'yes');
    add_option($prefix.'_category_name', '', '', 'yes');
    add_option($prefix.'_category_before', '<li id="[category id]" class="linkcat">', '', 'yes');
    add_option($prefix.'_category_after', '</li>', '', 'yes');
    add_option($prefix.'_class', 'linkcat', '', 'yes');
    add_option($prefix.'_category_orderby', 'name', '', 'yes');
    add_option($prefix.'_category_order', 'ASC', '', 'yes');
    add_option($prefix.'_title_li', "__('Bookmarks')", '', 'yes');
    add_option($prefix.'_title_before', '<h2>', '', 'yes');
    add_option($prefix.'_title_after', '</h2>', '', 'yes');
    add_option($prefix.'_show_private', '0', '', 'yes');
    add_option($prefix.'_include', '', '', 'yes');
    add_option($prefix.'_exclude', '', '', 'yes');
    add_option($prefix.'_orderby', 'name', '', 'yes');
    add_option($prefix.'_order', 'ASC', '', 'yes');
    add_option($prefix.'_limit', '-1', '', 'yes');
    add_option($prefix.'_before', '<li>', '', 'yes');
    add_option($prefix.'_after', '</li>', '', 'yes');
    add_option($prefix.'_link_before', '', '', 'yes');
    add_option($prefix.'_link_after', '', '', 'yes');
    add_option($prefix.'_between', '\n', '', 'yes');
    add_option($prefix.'_show_images', '1', '', 'yes');
    add_option($prefix.'_show_description', '0', '', 'yes');
    add_option($prefix.'_show_name', '0', '', 'yes');
    add_option($prefix.'_show_rating', '0', '', 'yes');
    add_option($prefix.'_show_updated', '0', '', 'yes');
    add_option($prefix.'_hide_invisible', '1', '', 'yes');
    add_option($prefix.'_echo', '1', '', 'yes');
    add_option($prefix.'_link_back', '1', '', 'yes');

}

//Display the admin page
function blogroll_to_page_admin_page() {
  global $pluginoptions;

  if ( $_REQUEST['Submit'] ) echo '<div id="message" class="updated fade"><p><strong>Blogroll to Page settings saved.</strong></p></div>';
  if ( $_REQUEST['Reset'] ) echo '<div id="message" class="updated fade"><p><strong>Blogroll to Page settings reset.</strong></p></div>';
  ?>

  <div class="wrap nosubsub"> 
    <div id="icon-link-manager" class="icon32"><br /></div> 
    <h2>Blogroll to Page</h2> 
    
    <p>
      These parameters are described in the <a href="http://codex.wordpress.org/Function_Reference/wp_list_bookmarks#Parameters" target="_blank">WordPress Codex</a>.<br />
      For an example of how the plugin works, check out our <a href="http://www.club-wp.com/wordpress-resources/" target="_blank">WordPress Resources</a> page.
    </p> 
  </div>  

  <form method="post"> 

  <p class="submit"> 
    <input type="submit" name="Submit" class="button-primary" value="Save Changes" /> 
    <input type="submit" name="Reset" class="button-primary" value="Reset" /> 
  </p>
  
  <?php wp_nonce_field('blogroll-to-page-save'); ?>
  
  
  
  <table class="form-table"> 

  <?php
  $first = true;
  
  foreach($pluginoptions as $option) {
    
    echo '<tr valign="top">';
    echo '<th scope="row"><label for="blogname">'.$option['label'].'</label></th>'; 
    echo '<td>';

    switch ($option['type'])
    {
      case 'check':
        $checked = get_option($option['option_field'], $option['option_value']) == 'true' ? 'checked' : '';
        echo '<input name="'.$option['option_field'].'" id="'.$option['option_field'].'" type="checkbox" value="true" '.$checked.'/>';        
        break;
      case 'select':
        $control = '<select name="'.$option['option_field'].'" id="'.$option['option_field'].'">';
        foreach( $option['options'] as $o ) {
          $selected = $o == get_option($option['option_field'], $option['option_value']) ? ' selected="yes"' : '';
          $control .= '<option'.$selected.'>'.$o.'</option>';
        }
        $control .= '</select>';
        echo $control;
        break;
      default:
        echo '<input name="'.$option['option_field'].'" id="'.$option['option_field'].'" type="text" value="'.get_option($option['option_field'], $option['option_value']).'" size="50" />';
        break;
    }
    
    echo '</td>';
    
    if( $first ) {
      echo '<td rowspan='.count($pluginoptions).'>'.get_about_text().'<td>';
      
      $first = false;
    }    
    
    ?>
    
      
      
    </tr>   
  
  
    
    <?php
  }
  ?>
   
   </table>

  <p class="submit"> 
    <input type="submit" name="Submit" class="button-primary" value="Save Changes" /> 
    <input type="submit" name="Reset" class="button-primary" value="Reset" /> 
  </p>

  </form>
  
  <?php
}

add_shortcode('blogroll-to-page', 'output_blogroll_to_page');

function output_blogroll_to_page() {
  global $pluginoptions, $prefix;
  $args = '';
  
  foreach($pluginoptions as $option) {
    if( strlen($args) > 0 ) $args .= '&';
    
    $val = '';
    
    if( $option['option_field'] != $prefix.'_link_back' ) {
      if( $option['type'] == 'check' ) {
        $val = get_option($option['option_field'], $option['option_value']) == 'true' ? '1' : '0';
      } 
      else {
        $val = get_option($option['option_field'], $option['option_value']);
      }
      
      $args .= $option['param'].'='.$val;
    }
  }
    
  $result = wp_list_bookmarks($args);
  
  if( get_option($option['option_field'], $option['option_value']) == 'true' )
    $result .= '<p>Generated by <a href="http://www.club-wp.com/blogroll-to-page-wordpress-plugin" target="_blank">Blogroll to Page</a></p>';
 
  return $result;
}

function get_about_text() {
  $about = '<p>Blogroll to Page plugin is developed by <a href="http://www.club-wp.com/" target="_blank">Club Wordpress</a>.</p>
            <p>Visit us to find out more about our:</p>
            <ul>
              <li><a href="http://www.club-wp.com/category/themes/" target="_blank">WordPress Themes</a></li>
              <li><a href="http://www.club-wp.com/category/plugins/" target="_blank">WordPress plugins</a></li>
              <li><a href="http://www.club-wp.com/wordpress-services/" target="_blank">WordPress Services</a></li>
              <li><a href="http://feeds.feedburner.com/ClubWordpress" target="_blank">RSS Feed</a></li>
            <ul>
             <p>You can also find us on:</p>
            <ul>
              <li><a href="http://www.facebook.com/pages/Club-Wordpress-Wordpress-Themes-Plugins-and-Tutorials/171743681365" target="_blank">FaceBook</a></li>
              <li><a href="http://twitter.com/clubwordpress" target="_blank">Twitter</a></li>
            <ul>';
  
  
  return $about;
}
