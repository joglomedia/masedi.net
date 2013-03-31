<?php 
if($current_user->ID == '')
{
	wp_redirect(get_option('siteurl').'/?page=registration');
}
?>
<?php get_header(); ?>
<?php
if(isset($_GET['author_name'])) :
	$curauth = get_userdatabylogin($author_name);
else :
	$curauth = get_userdata(intval($author));
endif;
?>

<div id="page">
 <div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
 
<div id="content">
  <h2><?php _e(DASHBOARD_PAGE_TITLE);?></h2>
  <?php
	$totalpost_count = 0;
	$limit = 1000;
	global $current_user;
	$userID =  $current_user->ID;
	$email = $current_user->user_email;
	$querypost .= "&author=$userID";
	$querypost .= "&post_status=draft,publish";
	$querypost1 = $querypost . "&showposts= $limit";
	query_posts($querypost1);
	if(have_posts())
	{
		while(have_posts())
		{
			the_post();
			$totalpost_count++;
		}
	}
	?>
  <div class="detail_list my-dashboard">
	  <a class="img"><?php echo get_avatar( $email,140); ?></a>
      <div class="col_right">
        	<h2><?php echo $curauth->display_name; ?></h2>
			<div class="profiledesc"><span><?php _e('Email','templatic'); ?></span><p>: <?php echo $curauth->user_email; ?> </p> </div>
            <?php
				 global $form_fields_usermeta;
				 $dirinfo = wp_upload_dir();
				 $path = $dirinfo['path'];
				 $url = $dirinfo['url'];
				 $subdir = $dirinfo['subdir'];
				 $basedir = $dirinfo['basedir'];
				 $baseurl = $dirinfo['baseurl'];
				 foreach($form_fields_usermeta as $key=> $_form_fields_usermeta)
				  {
					  if($key != 'user_fname' && $key != 'user_lname' && $key != 'user_email' ):
						 if(get_user_meta($current_user->ID,$key,true) != ""):
							if($_form_fields_usermeta['on_profile'] == 1 ):
							if($_form_fields_usermeta['type']!='upload') :
				 ?>	  
								<div class="profiledesc"><span><?php echo $_form_fields_usermeta['label']; ?> </span>
                                	<?php if($_form_fields_usermeta['type']!='texteditor'): ?>
                                    <p>:
                                    <?php endif; ?>
                                		<?php if($_form_fields_usermeta['type']=='multicheckbox'): ?>
											<?php
												$checkbox = '';
												foreach(get_user_meta($current_user->ID,$key,true) as $check):
														$checkbox .= $check.",";
												endforeach;
												echo substr($checkbox,0,-1);
											?>
                                        <?php else: ?>
	                                        <?php echo get_user_meta($current_user->ID,$key,true); ?>
                                        <?php endif; ?>
                                   <?php if($_form_fields_usermeta['type']!='texteditor'): ?>
                                    </p>
                                   <?php endif; ?> 
                                </div>
								
							<?php
							endif;
							if($_form_fields_usermeta['type']=='upload')
							{?>
							<p><label  style="vertical-align:top;"><?php echo $_form_fields_usermeta['label']." : "; ?></label> <img src="<?php echo get_user_meta($current_user->ID,$key,true);?>" style="width:150px;height:150px" /></p>
							<?php }
				
								
							endif;
						endif;
					  endif;
				  }
			?>
       </div>
       <div class="clear"></div>
  </div>
  <?php
  global $current_user;
  $role = $current_user->roles[0];
  if($role == "Job Provider"):
  ?>
      <p class="posted"><?php echo POSTED_JOB; ?></p>
      <?php 
        global $posts_per_page,$paged;
        $limit = $posts_per_page;
        $querypost .= "&showposts=$limit";
        $querypost .= "&paged=$paged";
        query_posts($querypost);
      if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
      <div class="listings">
        <?php if(get_post_meta($post->ID,'company_logo', $single = true)): ?>
            <img class="company_logo" src="<?php echo get_post_meta($post->ID,"company_logo",$single = true); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" />
        <?php else: ?>
            <img class="company_logo" src="<?php echo get_bloginfo('template_directory'); ?>/images/no-image.png" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" />
        <?php endif; ?>
 		<div class="featured-data">   
        <h3  id="post-<?php the_ID(); ?>">
        <span class="job_title"> 
            <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>" class="jp_title" ><?php the_title(); ?></a>
            <span class="company_name "><?php echo stripslashes(get_post_meta($post->ID,'company_name', $single = true));?></span>
            <?php
			$job_post_expiry_days = get_time_difference( $post->post_date, $post->ID);
            $day = date('d',mktime(0,0,0,date('m'),date('d')-$job_post_expiry_days,date('Y')));
            $month = date('m',mktime(0,0,0,date('m'),date('d')-$job_post_expiry_days,date('Y')));
            $year = date('Y',mktime(0,0,0,date('m'),date('d')-$job_post_expiry_days,date('Y')));
			  if($post->post_status == 'publish')
			  {
			  ?>
			  <span class="status_active"><?php _e(ACTIVE_TEXT);?></span> 
			  <?php
			  }else
			  {
				$day = date('d',strtotime($post->post_date));
				$month = date('m',strtotime($post->post_date));
				$year = date('Y',strtotime($post->post_date));
				$expiry_days = get_post_meta($post->ID,'alive_days', $single = true);
				$jobs_expirty_time =mktime(0,0,0,$month,$day+$expiry_days,$year);
				if($jobs_expirty_time<time())
				{
				?>
				 <span class="status_expired"><?php _e('Expired');?></span>
				<?php
				}else
				{
				?>
				<span class="status_expired"><?php _e('Pending Review');?></span> <a class="renew" href="<?php echo get_option('siteurl'); ?>/?page=editjob&renew=1&pid=<?php echo $post->ID;?>">(<?php _e('renew');?>)</a>
				<?php	
				}
			  }
			  ?>
         	 <?php if($post->post_status != 'publish'): ?>
	             <a href="<?php echo get_option('siteurl'); ?>/?page=editjob&pid=<?php echo $post->ID;?>&renew=1" title="Edit <?php the_title(); ?>" class="edit" ><?php _e('(renew)');?> </a> 
             <?php else: ?>
	             <a href="<?php echo get_option('siteurl'); ?>/?page=editjob&pid=<?php echo $post->ID;?>" title="Edit <?php the_title(); ?>" class="edit" ><?php _e('(edit)');?> </a> 
             <?php endif; ?>
        	 <a href="<?php echo get_option('siteurl'); ?>/?page=preview&pid=<?php echo $post->ID;?>" title="Delete <?php the_title(); ?>" class="delete" ><?php _e('(delete)');?> </a>
			  <?php 
                $post_id = $post->ID;
                $job_qry = "select * from $wpdb->usermeta where meta_key LIKE 'user_applied_jobs' and meta_value LIKE '%".$post_id."%'";
                $user_data = count($wpdb->get_results($job_qry));
              ?>
			<a href="<?php the_permalink() ?>" class="delete" ><?php _e('(applyers('.$user_data.'))');?> </a>
        </span>
      
        
          <?php if(get_post_meta($post->ID,'position_filled',true)=='Yes'){?><span><?php if(get_option('pt_position_filled')){echo get_option('pt_position_filled'); }else{ _e('Position:filled');}?></span><?php }?>
           </h3>
           <span class="place"><?php echo stripslashes(get_post_meta($post->ID,'job_location', $single = true));?> <br/>
           <small><?php echo stripslashes(get_post_meta($post->ID,'job_type', $single = true));?> </small> </span>
	       <span class="date" ><?php the_time(templ_get_date_format()); ?></span>
       </div>    
        <!--Post Meta-->
      </div>
		<!--post end -->
      <?php endwhile; ?>
      <!-- Prev/Next page navigation -->
      <div class="pagenavi">
        <?php if(function_exists('wp_pagenavi')) { ?>
        <div class="wp-pagenavi">
          <?php wp_pagenavi();  ?>
        </div>
        <?php 
        } else {?>
        <div class="page-nav">
          <div class="nav-previous">
            <?php previous_posts_link('Previous Page') ?>
          </div>
          <div class="nav-next">
            <?php next_posts_link('Next Page') ?>
          </div>
        </div>
        <?php } ?>
      </div>
      <!--page navi end -->
      <?php else : ?>
      <h3><?php _e(NO_POSTS_DASHBOARD_MSG);?></h3>
      <h4><a href="<?php echo get_option('siteurl');?>/?page=postajob"><?php _e(POST_A_NEW_JOB_TEXT);?></a></h4>
      <?php endif; ?>
		<?php elseif($role == "Job Seeker"):  ?>
		<p class="posted"><?php echo POSTED_RESUME; ?></p>
		  <?php 
			global $posts_per_page,$paged;
			$limit = $posts_per_page;
			$querypost .= "&showposts=$limit";
			$querypost .= "&paged=$paged";
			query_posts($querypost);
			if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				<div class="listings">
                <?php $image = pathinfo(get_post_meta($post->ID,'attachment', $single = true));	?>
					<?php if($image['extension'] == 'doc'): ?>
						<img class="company_logo" src="<?php echo get_bloginfo('template_directory'); ?>/images/file_extension_doc.png" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" />
					<?php elseif(($image['extension'] == 'pdf')): ?>
						<img class="company_logo" src="<?php echo get_bloginfo('template_directory'); ?>/images/file_extension_pdf.png" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60"/>
					<?php elseif(($image['extension'] == 'txt')): ?>
	                    <img class="company_logo" src="<?php echo get_bloginfo('template_directory'); ?>/images/file_extension_txt.png" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60"/>
                    <?php elseif(($image['extension'] == 'zip')): ?>
                   	    <img class="company_logo" src="<?php echo get_bloginfo('template_directory'); ?>/images/file_extension_zip.png" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60"/>
                    <?php else: ?>
	                    <img class="company_logo" src="<?php echo get_bloginfo('template_directory'); ?>/images/no-image.png" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60"/>
					<?php endif; ?>
                    
					<h3  id="post-<?php the_ID(); ?>">
					<span class="job_title"> 
						<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>" class="jp_title" ><?php the_title(); ?></a>
						<a href="<?php echo get_option('siteurl'); ?>/?page=editresume&pid=<?php echo $post->ID;?>" title="Edit <?php the_title(); ?>" class="edit" ><?php _e('(edit)');?> </a> 
						<a href="<?php echo get_option('siteurl'); ?>/?page=previews&pid=<?php echo $post->ID;?>" title="Delete <?php the_title(); ?>" class="delete" ><?php _e('(delete)');?> </a> 
					</span>
					</h3>
                    <a href="<?php echo get_post_meta($post->ID,'attachment', $single = true); ?>" class="normal_button">Download</a>
			<!--Post Meta-->
				</div>
				<?php endwhile; ?>
		   <?php else : ?> 
				<h3><?php _e(NO_RESUME_DASHBOARD_MSG);?></h3>
				<h4><a href="<?php echo get_option('siteurl');?>/?page=postaresume"><?php _e(POST_A_NEW_RESUME_TEXT);?></a></h4>
		   <?php endif; ?>
	   <p class="posted"><?php echo APPLIED_JOBS_TITLE; ?></p>
	   <?php 
		add_action('posts_where','author_applied_jobs');
		$my_query = new WP_Query('category_name=featured&showposts=3');
        if ($my_query->have_posts()) :
			while ($my_query->have_posts()) : $my_query->the_post(); ?>
			<div class="listings">
				<?php if(get_post_meta($post->ID,'company_logo', $single = true)): ?>
					<img class="company_logo" src="<?php echo get_post_meta($post->ID,"company_logo",$single = true); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" width="60"  />
				<?php else: ?>
					<img class="company_logo" src="<?php echo get_bloginfo('template_directory'); ?>/images/no-image.png" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" width="60"  />
				<?php endif; ?>    
				<h3  id="post-<?php the_ID(); ?>">
					<span class="job_title"> 
						<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>" class="jp_title" ><?php the_title(); ?></a>
					</span>
				</h3>
			   <span class="place"><?php echo stripslashes(get_post_meta($post->ID,'resume_location', $single = true));?> <br/>
			   <small><?php echo stripslashes(get_post_meta($post->ID,'availability', $single = true));?> </small> </span>
			   <span class="date" ><?php the_time(templ_get_date_format()); ?></small></span>
			<!--Post Meta-->
			</div>
			<?php endwhile; wp_reset_query();
	  else: ?>
			<h3><?php echo NO_APPLIED_JOBS;?></h3>
	  <?php 
	  endif; 
	  else: ?>
  	  <p class="posted"><?php echo POSTED_POST; ?></p>
      <?php 
        global $posts_per_page,$paged;
        $limit = $posts_per_page;
        $querypost .= "&showposts=$limit";
        $querypost .= "&paged=$paged";
        query_posts($querypost);
        if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); $post_id = $post->ID;?>
      <div class="listings">
        <?php if(get_post_meta($post->ID,'company_logo', $single = true)): ?>
            <img class="company_logo" src="<?php echo get_post_meta($post->ID,"company_logo",$single = true); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" width="60"  />
        <?php else: ?>
            <img class="company_logo" src="<?php echo get_bloginfo('template_directory'); ?>/images/no-image.png" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" width="60"  />
        <?php endif; ?>    
        <h3 id="post-<?php the_ID(); ?>">
            <span class="job_title">
                <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>" class="jp_title" ><?php the_title(); ?></a>
            </span>
        </h3>
	       <span class="date" ><?php the_time(templ_get_date_format()); ?></span>
        <!--Post Meta-->
		
      </div>
      <?php endwhile; ?>
      <div class="wp-pagenavi">
          <?php wp_pagenavi();  ?>
      </div>
      <?php else : ?>
      <h3><?php _e(NO_POST_DASHBOARD_MSG);?></h3>
      <?php endif; ?>

 <?php endif; ?>
</div>
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>