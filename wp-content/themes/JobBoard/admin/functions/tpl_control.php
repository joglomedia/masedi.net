<?php
/************************************
//FUNCTION NAME : templ_template_include
//ARGUMENTS : None
//RETURNS : Site page template file as per desing settings
***************************************/
add_filter('template_include','templ_template_include');
function templ_template_include($template)
{
	return apply_filters('templ_add_template_page_filter',$template);
}


///-----------------------------------------------------------------
	  //  SIDEBAR 1  //
///----------------------------------------------------------------

function templ_sidebar1_st($class='')
{
	$class = apply_filters('templ_sidebar1_css_filter',$class);
	if($class){ $class = 'class="'.$class.'"';}
	return apply_filters('templ_sidebar1_st_filter',"<div  $class >");
}

function templ_sidebar1_end()
{
	return apply_filters('templ_sidebar1_end_filter','</div>');
}

function templ_sidebar1($class='sidebar left')
{
	echo templ_sidebar1_st($class);
	$widget = apply_filters('sidebar1_widget_filter','sidebar1');
	if (function_exists('dynamic_sidebar') && $widget){ dynamic_sidebar($widget); }
	do_action('templ_sidebar2');
	echo templ_sidebar1_end();
}

function templ_sidebar_2col_merge()
{
	$widget = apply_filters('sidebar_2col_merge_widget_filter','sidebar_2col_merge');
	if (function_exists('dynamic_sidebar') && $widget){ dynamic_sidebar($widget); }
}


///-----------------------------------------------------------------
	  //  SIDEBAR 2  //
///----------------------------------------------------------------

function templ_sidebar2_st($class='')
{
	$class = apply_filters('templ_sidebar2_css_filter',$class);
	if($class){ $class = 'class="'.$class.'"';}
	return apply_filters('templ_sidebar2_st_filter',"<div  $class >");
}

function templ_sidebar2_end()
{
	return apply_filters('templ_sidebar2_end_filter','</div>');
}
function templ_sidebar2($class='sidebar right')
{
	echo templ_sidebar2_st($class);
	$widget = apply_filters('sidebar2_widget_filter','sidebar2');
	if (function_exists('dynamic_sidebar') && $widget){ dynamic_sidebar($widget); }
	do_action('templ_sidebar2');
	echo templ_sidebar2_end();
}


///-----------------------------------------------------------------
	  //  Content Area  //
///----------------------------------------------------------------

function templ_content_css($class='')
{
	if(templ_is_layout('3_col_fix'))  ////Sidebar 3 column fixed
	{
		$class .= 'content content_3col column_spacer left';
	}else
	if(templ_is_layout('3_col_left'))  ////Sidebar 3 column left
	{
		$class .= 'content content_3col_right right';
	}else
	if(templ_is_layout('3_col_right'))  ////Sidebar 3 column right
	{
		$class .= 'content content_3col_left left';
	}else
	if(templ_is_layout('full_width'))  ////Sidebar Full width page
	{
		$class .= 'content content_full';
	}else
	if(templ_is_layout('2_col_right'))  ////Sidebar 2 column right
	{
		$class .= 'content left';
	}
	else  ////Sidebar 2 column left as default setting
	{
		$class .= 'content right';
	}		
	$class = apply_filters('templ_content_css_filter',$class);
	echo $class;
}



/************************************
//FUNCTION NAME : templ_page_layout_options
//ARGUMENTS : None
//RETURNS : page layout options array
***************************************/
function templ_page_layout_options()
{
	return $layout_arr = 
			array(
				'3_col_fix'		=> 'Page 3 column - Fixed',
				'3_col_left'	=> 'Page 3 column - Left Sidebar',
				'3_col_right'	=> 'Page 3 column - Right Sidebar',
				'full_width'	=> 'Full Page',
				'2_col_right'	=> 'Page 2 column - Right Sidebar',
				'2_col_left'	=> 'Page 2 column - Left Sidebar',
				);	
}

/************************************
//FUNCTION NAME : templ_get_page_layout
//ARGUMENTS : None
//RETURNS : page layout set as per from <br />
wp-admin desing settings, default is "left sidebar'
***************************************/
function templ_get_page_layout()
{
	if(get_option('ptthemes_page_layout')){
		$layout = get_option('ptthemes_page_layout');
	}else{
		$layout = 'Page 2 column - Left Sidebar';
	}
	$layout =  apply_filters('templ_current_page_layout_filter',$layout);
	$layout_opts = templ_page_layout_options();
	$opt_key = array_keys($layout_opts,$layout);
	return $opt_key[0];
}

/************************************
//FUNCTION NAME : templ_is_layout
//ARGUMENTS : page layout code
//RETURNS : true/false as per conditon
***************************************/
function templ_is_layout($type)
{
	if(templ_get_page_layout()==$type)
	{
		return true;
	}
	return false;
}
?>