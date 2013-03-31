<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<title>
<?php global $page, $paged;
wp_title( '|', true, 'right' );
if('page' != get_option('show_on_front')):
	bloginfo('name');
endif;	
if(($_REQUEST['page'] || $_REQUEST['jtype']) && 'page' == get_option('show_on_front')):
	bloginfo('name');
endif;
?>
</title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<!-- leave this for stats -->
<?php if ( get_option('ptthemes_favicon') <> "" ) { ?>
<link rel="shortcut icon" type="image/png" href="<?php echo get_option('ptthemes_favicon'); ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css"  href="<?php bloginfo('template_directory'); ?>/library/css/print.css" media="print" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/print.css" media="print" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!--[if lt IE 7]>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/pngfix.js"></script>
<![endif]-->
<?php wp_head(); ?>
<?php do_action('templ_head_js'); ?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/skins/<?php echo get_option('pt_body_color'); ?>.css" type="text/css" media="screen" />
<?php
global $options;
foreach ($options as $value) {
		global $$value['id'];
        if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>
</head>
<body >
<div id="header" class="clearfix">
  <div id="header-in" >
	  <div class="h_left">
          <div class="logo"> 
                <?php st_header(); ?>
           </div>
 	 <div class="description">
        <?php bloginfo('description'); ?>
      </div> 
      
      </div><!--hleft end -->
          
     <?php dynamic_sidebar("header-top-right-widget-area"); ?>
          
  </div> <!--header in end -->
</div><!--header end -->

<div id="search_section" > 
	<div id="search_section-in" class="clearfix">
    	 
         <?php dynamic_sidebar("header-search-widget-area"); ?>
          <div id="navmenu-h" >
	           <div id="menu-top-menu" class="top_navigation topnav-container">
	   				 <div class="top_navigation_in clearfix">
                             <?php st_navbar(); ?>
							 <?php
                                if(get_option("ptthemes_show_menu") == 'Yes')
                                {
                                    wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary', ));
                                }
                                else
                                {
                                    $nav_menu = get_option('theme_mods_jobboard2');
                                    if($nav_menu['nav_menu_locations']['primary'] != 0)
                                      {
                                        wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary', ));
                                      }
                                    elseif (function_exists('dynamic_sidebar') && dynamic_sidebar('Header Navigation') ){}
                                }
                            ?>
                          </div>
                      </div>    
			  </div>         
    </div>
</div>
<div id="main_tab">
	<div id="main_tab-in"> 
     <ul id="tab">
      <li class="page_item <?php if($_GET['jtype']=='all'){echo "current_page_item";}?>" ><a href="<?php echo get_option('siteurl');?>/?jtype=all"><?php _e('All');?></a></li> 
      <?php
	  global $custom_post_meta_db_table_name,$wpdb;
	  $query = "select option_values from $custom_post_meta_db_table_name where htmlvar_name = 'job_type'";
	  $jobs_type_predefined_values = explode(",",$wpdb->get_var($query));

      foreach($jobs_type_predefined_values as $key=>$val)
	  {
		?>
        <li class="page_item <?php if($_GET['jtype']==$val){echo "current_page_item";}?>"><a href="<?php echo get_option('siteurl');?>/?jtype=<?php echo $val;?>"><?php echo $val;?></a></li>
        <?php
	  }
	  ?>
     </ul>
    <div class="b_postajob">
    <?php
		$current_user = wp_get_current_user();
		$login = $current_user->user_login;
		if($login):
			 global $current_user;
			 $role =  $current_user->roles[0];
			 if($role == "Job Seeker")
				{
				  if(get_option('pt_show_postaresumelink') == 'Yes' )
					{
						global $wpdb,$current_user;
						$user_id = $current_user->ID;
						$args = array('author'=> $user_id);
						$id = custom_get_user_posts_count($user_id,'resume','publish');
				 ?>  
						<?php if($id): ?>
							<a href="<?php echo get_option('siteurl');?>/?page=editresume&pid=<?php echo $id; ?>"><?php _e('Edit a Resume');?></a>
						<?php else: ?>
							<a href="<?php echo get_option('siteurl');?>/?page=postaresume"><?php _e('Post a Resume');?></a>
						<?php endif; ?>    
				  <?php
					}
				}
			  else
			  {
				  if(get_option('pt_show_postajoblink') == 'Yes' ) 
				  {
				  ?>  <a href="<?php echo get_option('siteurl');?>/?page=postajob"><?php _e('Post a Job');?></a>
				  <?php
				  }
			  }
		else:
			if(get_option('pt_show_button') == 'Post a job'):?>
				  <a href="<?php echo get_option('siteurl');?>/?page=postajob"><?php _e('Post a Job');?></a>
			<?php elseif(get_option('pt_show_button') == 'Post a resume'): ?>
				  <a href="<?php echo get_option('siteurl');?>/?page=postaresume"><?php _e('Post a Resume');?></a>
			<?php elseif(get_option('pt_show_button') == 'Both'): ?>
                  <div style="float:right; margin-left:10px;"><a href="<?php echo get_option('siteurl');?>/?page=postaresume"><?php _e('Post a Resume');?></a></div>
                  <div style="float:right;"><a href="<?php echo get_option('siteurl');?>/?page=postajob"><?php _e('Post a Job');?></a></div>
            <?php endif; ?>
	 <?php endif;  ?>
     </div>
     <div class="clear"></div>
  </div>
</div> <!-- main tab #end -->