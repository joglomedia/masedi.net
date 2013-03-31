<?php get_header(); ?>
<div id="page">
<div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
<div id="content">
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?><div class="breadcums"><ul class="page-nav"><li><?php  yoast_breadcrumb('',''); ?></li></ul></div><?php } ?>
<div class="newlisting newlisting-block"> 
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <h1 id="post-<?php the_ID(); ?>">
                <?php the_title(); ?>
            </h1>
        	<div class="posted-date">
				<?php echo POSTED_IN; ?>
                <?php echo get_the_term_list($post->ID,CUSTOM_CATEGORY_TYPE1,"",",","");?>
				<?php echo AT; ?>
                <?php the_time(templ_get_date_format()); ?>
    		</div>

    <div class="detail_list">
        	<?php if(get_post_meta($post->ID,'company_logo', $single = true)): ?>
		        <a href="<?php the_permalink(); ?>" class="img"><img src="<?php echo get_post_meta($post->ID,'company_logo', $single = true); ?>" width="100" height="100"  border="0" class="company_logo" /></a>
			<?php else: ?>
	             <a href="<?php the_permalink(); ?>" class="img"><img src="<?php bloginfo("template_directory"); ?>/images/no-image.png" alt="" class="company_logo" /></a>
            <?php endif; ?>

        <div class="col_right">
        	<h2><?php echo get_post_meta($post->ID,'company_name', $single = true); ?></h2>
            <?php	
				global $custom_post_meta_db_table_name;
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail = 1 and (post_type='".CUSTOM_POST_TYPE1."' or post_type='both')";
				if($fields_name)
				{
					$fields_name = '"'.str_replace(',','","',$fields_name).'"';
					$sql .= " and htmlvar_name in ($fields_name) ";
				}
				$sql .=  " order by sort_order asc,cid asc";
				$post_meta_info = $wpdb->get_results($sql);
				foreach($post_meta_info as $post_meta_info_obj){
					if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date' || $post_meta_info_obj->ctype =='multicheckbox' || $post_meta_info_obj->ctype =='radio' || $post_meta_info_obj->ctype =='select'){
							if($post_meta_info_obj->htmlvar_name != "category" && $post_meta_info_obj->htmlvar_name != "geo_latitude" && $post_meta_info_obj->htmlvar_name != "geo_longitude" && $post_meta_info_obj->htmlvar_name != "position_title" && $post_meta_info_obj->htmlvar_name != "company_name" && $post_meta_info_obj->htmlvar_name != "how_to_apply" && $post_meta_info_obj->htmlvar_name != "job_desc")
								{
                                    if($post_meta_info_obj->ctype =='texteditor' && get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true) != "") {
                                        echo "<div class='text-editor'><span>".$post_meta_info_obj->site_title." </span>".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</div>";
                                    }
									elseif($post_meta_info_obj->ctype =='textarea' && get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true) != "") {
                                        echo "<p><span>".$post_meta_info_obj->site_title."</span></p><p class='text-width'> ".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</p>";
                                    }
									else {
										if($post_meta_info_obj->ctype == 'multicheckbox'):
										    $checkArr = get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true);
											if($checkArr):
												foreach($checkArr as $_checkArr)
												{
													$check .= $_checkArr.",";
												}
											endif;	
											$check = substr($check,0,-1);
											if($check):
												echo "<p><span>".$post_meta_info_obj->site_title."</span></p><p class='text-width'> ".$check."</p>";
											endif;	
										else:
											if(get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true) != ""):
												if($post_meta_info_obj->htmlvar_name == 'company_web'):
		                                        	echo "<p><span>".$post_meta_info_obj->site_title."</span></p><p class='text-width'> <a href=".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true).">".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</a></p>";
												else:
													echo "<p><span>".$post_meta_info_obj->site_title."</span></p><p class='text-width'> ".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</p>";
												endif;
											endif;	
										endif;	
                                    } 
						}?>
					 <?php  $i++;
					 }
		}			
		?>
       </div>
       <div class="clear"></div>
    </div>
    <h3> <?php _e('Description');?> : </h3>
	<?php the_content('continue'); ?>
    <!--Post Meta-->
    <?php
    $blogcatids = get_category_by_cat_name(get_option('pt_blog_cat'));
	if(!in_category($blogcatids))
	{
	?>
    <div class="post_bottom">
		<?php if(get_post_meta($post->ID,'how_to_apply',$single = true)) : ?>
			<h3><?php _e('How to apply','templatic');?> : </h3>
			<p><?php echo get_post_meta($post->ID,'how_to_apply',$single = true); ?></p>
		<?php endif; ?>
		<?php 
		global $current_user;
		if((get_currentuser_role() == 'Job Seeker' && is_currentuser_resume($current_user->ID)) || !get_current_user_id()){ ?>
        <p class="job_application">
			<?php if(get_post_meta($post->ID,'position_filled',true)=='Yes'){ ?><span><?php if(get_option('pt_position_filled')){ echo get_option('pt_position_filled'); }else{
			_e('Position','templatic'); echo " : "; _e('filled','templatic');
			}?></span><?php }else{ 
			job_application_html($post->post_author,$post->ID); } ?>
		</p>
		<?php }else if(get_currentuser_role() == 'Job Seeker' && !is_currentuser_resume($current_user->ID)){ 
			echo '<span style="color:green;">'.APPLY_JOB_MESSAGE.' click <a href='.get_option("siteurl").'/?page=postaresume>here</a></span>';
		} ?>
    </div>
    <?php	
	}else
	{
	?>
   	<div class="post_bottom"> 
    	<?php the_tags(' <span class="i_tags">'.__('Tags : ').'', ', ', '</span>'); ?> 
    </div>  
    <?php
	}
	?>
    <!--post paging-->
    <?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
    <!--include comments template-->
    <ul class="fav_link">
          <?php if(get_option("ptthemes_print") == "Yes"): ?>
	          <li class="print"><a href="#" onclick="window.print();return false;"><?php _e('Print');?></a></li>
          <?php endif; ?>    
          <?php if(get_option("ptthemes_share") == "Yes"): ?>
			  <?php if ( get_option('ptthemes_feedburner_url') != "") {
                $pt_feedburner_url = get_option('ptthemes_feedburner_url')
               ?>
              <li class="sharethis"><a class="a2a_dd" target="_blank" href="http://www.addtoany.com/subscribe?linkname=http%3A%2F%2Fpt.com&amp;linkurl=http%3A%2F%2F<?php echo $pt_feedburner_url; ?>"><?php _e('Share This');?></a>
                <script type="text/javascript" >a2a_linkname="<?php echo $pt_feedburner_url; ?>";a2a_linkurl="<?php echo $pt_feedburner_url; ?>";</script>
                <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/feed.js"></script>
              </li>
              <?php } ?>
              <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4c873bb26489d97f"></script>
          <?php endif; ?>
          <?php if(get_option("ptthemes_rss") == "Yes"): ?>    
	          <li class="rss"><a href="<?php echo $pt_feedburner_url; ?>"><?php _e('RSS','templatic');?></a> </li>
          <?php endif; ?>    
    	  <?php if(get_option("ptthemes_email_on_detailpage") == "Yes"): ?>
          <li class="emailtofriend"> <a href="javascript:void(0);"><?php _e('Email to Friend');?></a> <?php if($_REQUEST['jemail']=='success'){ echo '&nbsp;&nbsp;<span class="text_success_msg2">'; _e('Email to your Friend sent successfully','templatic'); echo '</span>';}?>
		  <?php if(isset($_REQUEST['ecptcha']) == 'captch')
				{
					$a = get_option("recaptcha_options");
					$blank_field = $a['no_response_error'];
					$incorrect_field = $a['incorrect_response_error'];
					echo '<div class="error_msg">'.$incorrect_field.'</div>';
				}
		  ?>
          <?php endif; ?>
          </li>
	      <?php require_once (TEMPLATEPATH . '/library/includes/email_a_job.php');?>
    </ul>
    <?php 
	$address = get_post_meta($post->ID,'address',true);
	$geo_latitude = get_post_meta($post->ID,'geo_latitude',true);
	$geo_longitude = get_post_meta($post->ID,'geo_longitude',true);
	$logo = get_post_meta($post->ID,'company_logo',true);
	if($address){  ?>
			<div class="row">
                <div class="title_space">
                    <div class="title-container">
                        <h3><span><?php echo JOB_MAP_TEXT;?></span></h3>
                        <div class="clearfix"></div>
                    </div>
                    <p><strong><?php _e('Location : '); echo $add_str;?></strong></p>
                </div>
				<div id="gmap" class="graybox img-pad">
            <?php if($geo_longitude &&  $geo_latitude):
					$title = $job_name;
					$address = $address;
				 	$pimg = $logo;
					if(!$pimg):
						$pimg = get_template_directory_uri()."/images/no-image.png";
					endif;	
					$more = VIEW_MORE_DETAILS_TEXT;
                    require_once (TEMPLATEPATH . '/library/map/preview_map.php');
					$retstr .= "<img src=\"$pimg\" width=\"140\" height=\"140\" alt=\"\" />";
					$retstr .= "<h1><a href=\"\" class=\"ptitle\" style=\"color:#444444;font-size:16px;\"><span>$title</span></a></h1>";
					if($address){$retstr .= "<span style=\"font-size:10px;\">$address</span>";}
                    preview_address_google_map($geo_latitude,$geo_longitude,$retstr);
            	  else:
			?>
            		<iframe src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $address;?>&amp;ie=UTF8&amp;z=14&amp;iwloc=A&amp;output=embed" height="358" width="100%" scrolling="no" frameborder="0" ></iframe>
            <?php endif; ?>
</div>
			</div>
		<?php }?>
   
   <?php if(get_option("ptthemes_other_job_display") == "Yes"): ?>
	   <?php require_once (TEMPLATEPATH . '/monetize/job/other_jobs.php');?> 
   <?php endif; ?>    
   <?php require_once (TEMPLATEPATH . '/monetize/job/related_jobs.php');?>
   <?php
    wp_reset_query();
	global $current_user;
	$role =  $current_user->roles[0];
	if($role == 'Job Provider'): ?>
			<?php
            $job_qry = "select * from $wpdb->usermeta where meta_key LIKE 'user_applied_jobs' and meta_value LIKE '%".$post->ID."%'";
            $user_data = $wpdb->get_results($job_qry);
            $email = get_post_meta($post->ID,'email',true);
			if($user_data):
			?>
			<p class="posted"><?php _e('Job Applyers'); ?></p>
            <div class="list_01">
            <ul>
             <?php foreach($user_data as $jq):?>
                <li>
                	<?php 
					$userdata = get_userdata($jq->user_id);
					$author_query = "select ID from $wpdb->posts where $wpdb->posts.post_author = '".$jq->user_id."' and post_type='resume' and post_status='publish'";
					$resume_id = $wpdb->get_var($author_query);
					?>
                    <a class="img" href="<?php echo get_permalink($resume_id); ?>"><?php echo get_avatar($userdata->user_email,40); ?></a>
                    <div class="job-listed">
	                    <div class="col_1">
                            <h2><a href="<?php echo get_permalink($resume_id); ?>"><?php echo get_post_meta($resume_id,'fname', $single = true)." ".get_post_meta($resume_id,'lname', $single = true); ?></a></h2>
                            <?php echo get_the_title($resume_id); ?>
                        </div>
                        <div class="col_2">
                        <?php echo get_post_meta($resume_id,"resume_location",$single = true); ?><br />
                        <small><?php echo get_post_meta($resume_id,"resume_type",$single = true); ?></small>
                   </div>
                    <div class="col_3">
                        <?php echo get_the_time('j M ',$resume_id) ?> <small><?php echo get_the_time('Y',$resume_id) ?></small>
                   </div>

                    </div>
                    <div class="clear"></div>
                </li>
           <?php endforeach; ?>
           </ul>
       </div>
   <?php endif; ?>    
   <?php endif; ?>
   <?php
	  if(get_option('pt_show_postacomment') == 'Yes')  //Please comment to display comment on blog page as default settins
	  {
	 	comments_template(); 
      }
	  ?> 
    <!--do not delete-->
    <?php endwhile;  else: ?>
    <?php _e('Sorry, no posts matched your criteria.');?>
    <!--do not delete-->
    <?php endif; ?>
    <!--single.php end-->
  <!--single.php end-->
<script type='text/javascript' src='<?php bloginfo('template_directory'); ?>/js/jquery.js'></script>
<script type='text/javascript' src='<?php bloginfo('template_directory'); ?>/js/jquery.simplemodal.js'></script>
<script type='text/javascript' src='<?php bloginfo('template_directory'); ?>/js/basic.js'></script>
</div>
</div>
<div id="sidebar">
	<?php dynamic_sidebar("job-detail-area"); ?>
</div>    
<?php get_footer(); ?>
