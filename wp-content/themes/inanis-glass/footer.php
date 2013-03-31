<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'footer.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
?>
    <div class="clear"></div>

<div id="StartMenu">
  <div class="SMTop"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
  <div class="SMMiddle">
    <div class="SMsub">
      <ul>
        <li id="SMCatsB">
          <img src="<?php bloginfo('template_directory'); ?>/images/categories_32.png" alt=" " />
          <b><?php _e('Categories','inanis');?></b><br />
          <?php _e('Show category details...','inanis');?>
        </li>
        <li id="SMTagsB">
          <img src="<?php bloginfo('template_directory'); ?>/images/tags_32.png" alt=" " />
          <b><?php _e('Tag Cloud','inanis');?></b><br />
          <?php _e('Show the Tag Cloud...','inanis');?>
        </li>
        <li>
          <a href="<?php bloginfo('atom_url'); ?>">
          <img src="<?php bloginfo('template_directory'); ?>/images/feed_32.png" alt=" " />
          <b><?php _e('Blog RSS','inanis');?></b><br />
          <?php _e('Follow the Blog RSS...','inanis');?>
          </a>
        </li>
        <li>
          <a href="<?php bloginfo('comments_rss2_url'); ?>">
          <img src="<?php bloginfo('template_directory'); ?>/images/comments_32.png" alt=" " />
          <b><?php _e('Comments RSS','inanis');?></b><br />
          <?php _e('Follow the Comments RSS...','inanis');?>
          </a>
        </li>
      </ul>
      <div class="SMsgbhr"><img src="<?php bloginfo('template_directory'); ?>/images/smhrlt.png" alt=" " /></div>
      <div class="SMsgb" id="SMLpostsB"><img src="<?php bloginfo('template_directory'); ?>/images/smfwd.png" alt=" " /><?php _e('Last 50 Posts','inanis');?></div>
      <div id="SMSearchForm"><?php include (TEMPLATEPATH . '/sm_searchform.php'); ?></div>
    </div>
    
    <div class="SMsub SMsh" id="SMCats">
      <div class="SMSubDiv" style="padding:0;margin:4px 0 0 4px;">
        <div class="SMCats"><ul><?php wp_list_categories('show_count=0&hierarchical=1&title_li='); ?></ul></div>
        <div class="SMsgbhr"><img src="<?php bloginfo('template_directory'); ?>/images/smhrlt.png" alt=" " /></div>
        <div class="SMsgb" id="SMCatsK"><img src="<?php bloginfo('template_directory'); ?>/images/smback.png" alt=" " /><?php _e('Back','inanis');?></div>
      </div>
    </div>
    
    <div class="SMsub SMsh" id="SMTags">
      <div class="SMSubDiv" style="padding:0;margin:4px 0 0 4px;">
          <div class="SMTags SMCats">
            <?php wp_tag_cloud('number=30'); ?>
          </div>
        <div class="SMsgbhr"><img src="<?php bloginfo('template_directory'); ?>/images/smhrlt.png" alt=" " /></div>
        <div class="SMsgb" id="SMTagsK"><img src="<?php bloginfo('template_directory'); ?>/images/smback.png" alt=" " /><?php _e('Back','inanis');?></div>
      </div>
    </div>
    
    <div class="SMsub SMsh" id="SMLposts">
      <div class="SMSubDiv SMap">
          <ul><?php wp_get_archives('type=postbypost&limit=50'); ?></ul>
        <div class="SMsgbhr"><img src="<?php bloginfo('template_directory'); ?>/images/smhrlt.png" alt=" " /></div>
        <div class="SMsgb" id="SMLpostsK"><img src="<?php bloginfo('template_directory'); ?>/images/smback.png" alt=" " /><?php _e('Back','inanis');?></div>
      </div>
    </div>
        
    <div class="SMRight">
    <div class="SMAvatarB"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
    
    
    <div class="SMAvatar">
      <?php global $userdata;
      get_currentuserinfo();
      echo get_avatar( $userdata->ID, 46 ); ?>
    </div>

    <?php if (is_user_logged_in()){ global $current_user; ?>
    <?php
      global $current_user, $wpdb;
      $role = $wpdb->prefix . 'capabilities';
      $current_user->role = array_keys($current_user->$role);
      $role = $current_user->role[0];
      $count_posts = wp_count_posts();
      $count_comments = wp_count_comments();
      $published_posts = $count_posts->publish;
      $published_comments = $count_comments->total_comments;
      
      echo '<div class="SMRtDiv">';
      ?><img class="SMSep" src="<?php bloginfo('template_directory'); ?>/images/sm-sep.png" alt=" " /><?php
      if ($role=="administrator" || $role=="editor" || $role=="author")
        { echo ('<a class="SMRtHov" href="' . get_option('siteurl') . '/wp-admin/post-new.php" title="'.__('Write a Post','inanis').'">'.__('Write a Post','inanis').'</a>'); }
      if ($role=="administrator" || $role=="editor")
        { echo ('<a class="SMRtHov" href="' . get_option('siteurl') . '/wp-admin/page-new.php" title="'.__('Write a Page','inanis').'">'.__('Write a Page','inanis').'</a>'); }
      ?><img class="SMSep" src="<?php bloginfo('template_directory'); ?>/images/sm-sep.png" alt=" " /><?php
      echo '</div>';
       ?>
    <?php } else {echo " ";} ?>
    
    
    <div class="clear"></div>
    
    <?php
      if (is_user_logged_in()){ global $current_user;
        if ($role!="subscriber")
          {
            $adminbtn1='<a class="SMRtHov" href="';
            $adminbtn2='/wp-admin/" title="'.__('Site Admin','inanis').'"><span>'.__('Site Admin','inanis').'</span></a>';
          }
        else
          {
            $adminbtn1='<a class="SMRtHov" href="';
            $adminbtn2='/wp-admin/" title="'.__('Edit Your Profile','inanis').'"><span>'.__('Edit Your Profile','inanis').'</span></a>';
          } 
          
      } else {
        $adminbtn1='<a class="SMRtHov" href="';
        $adminbtn2='/wp-login.php?action=register" title="'.__('Register an account','inanis').'"><span>'.__('Register an account','inanis').'</span></a>';
      } 
    ?>
      
      <div class="SMAdmin">
        <?php echo $adminbtn1;echo get_option('siteurl');echo $adminbtn2;?>
      </div>
      
      <div class="SMRtPoCom" id="SMThemeB"><?php _e('Change Theme...','inanis');?></div>
      
      <div class="liload">
      
      <?php
      //determine which state the logout/login/Admin buttons should be in
      if (is_user_logged_in()) {
        $vers = get_bloginfo('version');
        if ($vers >= "2.7"){
          /* Logout button for 2.7 and up */ 
          $logoutbtn1 = '<a title="'.__('Logout','inanis').'" href="' . wp_logout_url() . '"><span>'.__('Logout','inanis').'</span>';
        }
        else {
          /* Logout Button for Less than 2.7 */
          $logoutbtn1 = '<a title="'.__('Logout','inanis').'" href="' . get_option('siteurl') . '/wp-login.php?action=logout"><span>'.__('Logout','inanis').'</span>';
        }
        
        $logoutbtn2 = '</a>';
        $logoutcls = 'logout';
        
        $loginbtn1 = '<span>['.__('Logged In','inanis');
        $loginbtn2 = ']</span>';
        $logincls = 'loggedin';
        $uinfo = __('User Info','inanis');
      }
      else {
        $logoutbtn1 = '<span>['.__('Logged Out','inanis');
        $logoutbtn2 = ']</span>';
        $logoutcls ='loggedout';
        
        $loginbtn1 = '<a title="'.__('Login','inanis').'" href="' . get_option('siteurl') . '/wp-login.php?action=login"><span>'.__('Login','inanis').'</span>';
        $loginbtn2 = '</a>';
        $logincls = 'login';
        $uinfo = 'Blog Info';
      }?>

        <div class="LogAdmin">
          <ul>
            <li class="<?php echo $logoutcls; ?>"><?php echo $logoutbtn1;echo $logoutbtn2;?></li>
            <li class="<?php echo $logincls; ?>"><?php echo $loginbtn1;echo $loginbtn2;?></li>
            <li title="<?php echo $uinfo ?>" class="opts" id="SMInfoB">&nbsp;</li>
          </ul>
        </div>

      </div>
    </div>

    <div class="SMRtPoComFl SMfo" id="SMSub4">
      <ul class="SMRtFlOpt SMRtFlOptInd">
        <?php
        if (is_user_logged_in()){
          ?><li><b><?php _e('Role','inanis');?></b> &raquo; <?php echo $role; ?></li>
          <li><b><?php _e('Posts','inanis');?></b> &raquo; <?php echo $published_posts; ?></li>
          <li><b><?php _e('Comments','inanis');?></b> &raquo; <?php echo $published_comments; ?></li><?php
        }
        else {
          $all_blog_comments = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = '1'");
          if (0 < $all_blog_comments) $all_blog_comments = number_format($all_blog_comments);
          
          $numposts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish'");
          if (0 < $numposts) $numposts = number_format($numposts);
          
          $user_count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->users;");

          ?><li><b><?php _e('Users','inanis');?></b> &raquo; <?php echo $user_count; ?></li>
          <li><b><?php _e('Posts/Pages','inanis');?></b> &raquo; <?php echo $numposts; ?></li>
          <li><b><?php _e('Comments','inanis');?></b> &raquo; <?php echo $all_blog_comments; ?></li><?php
        }
        ?>

      </ul>
    </div>

    <?php insert_stylemenu(); ?>

  </div>
  <div class="SMBottom"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
</div>

<iframe src="javascript:false" 
  style="position:fixed; bottom: 32px; left: -200px; visibility:hidden; display: none; width: 174px; height: 128px; z-index: 5;"
  id="hovif" frameborder="0" scrolling="no">
</iframe>

<iframe src="javascript:false" 
  style="position:fixed; bottom: 32px; left: -200px; visibility:hidden; display: none; width: 174px; height: 128px; z-index: 5;"
  id="moif" frameborder="0" scrolling="no">
</iframe>

<iframe src="javascript:false" 
  style="position:fixed; bottom: 0px; left: -50px; visibility:hidden; display: none; width: 5000px; height: 34px; z-index: 5;"
  id="tbif" frameborder="0" scrolling="no">
</iframe>

<iframe src="javascript:false" 
  style="background:transparent;position:fixed; bottom: 30px; left: -50px; visibility:hidden; display: none; width: 445px; height: 233px; z-index: 5;"
  id="smif" frameborder="0" scrolling="no">
</iframe>

<iframe src="javascript:false" 
  style="position:fixed; bottom: 261px; left: 294px; visibility:hidden; display: none; width: 56px; height: 26px; z-index: 5;"
  id="avif" frameborder="0" scrolling="no">
</iframe>

<iframe src="javascript:false" 
  style="position:fixed; bottom: 0px; left: -200px; visibility:hidden; display: none; width: 5px; height: 5px; z-index: 5;"
  id="flif" frameborder="0" scrolling="no">
</iframe>
    
    <div id="menuspan" class="mnusp">
      <div class="menu">
        <div class="nvtl"><ul><li id="orb"><a><span>- O -</span></a></li></ul></div>
        <!-- Quick Launch -->
        <div class="menu-sep"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
        <?php insert_quicklaunch(); ?>       
        <div class="nav"><ul>
        <li<?php if (is_home()){?> class="current_page_item_tb" <?php } ?>><a href="<?php echo get_settings('home'); ?>/"><?php _e('Home','inanis');?></a></li>
        <?php 
          global $baby, $matches;
          insert_menu();
        ?></ul> 
        </div>
        <?php insert_mobutton(); ?>
        <div class="clock">
          <span id="clockhr">&nbsp;</span>:<span id="clockmin">&nbsp;</span>&nbsp;<span id="clockpart">&nbsp;</span>
        </div>
      </div>
    </div>
    <?php insert_kids(); ?>
    <?php insert_molist(); ?>
    <div class="clear"></div>
    <div class="footer"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /><?php wp_footer(); ?></div>
    <script type="text/javascript">
      document.getElementById('menuspan').style.zIndex = "10";
      document.getElementById('StartMenu').style.zIndex = "10";
    </script>
  </body>
</html>
