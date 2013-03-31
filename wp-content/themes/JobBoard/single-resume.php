<?php get_header(); ?>
<div id="page">
<div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
<div id="content">
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?><div class="breadcums"><ul class="page-nav"><li><?php yoast_breadcrumb('',''); ?></li></ul></div><?php } ?>
<div class="newlisting"> 
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <h1 id="post-<?php the_ID(); ?>">
                <?php the_title(); ?>
            </h1>
        	<div>
				<?php echo POSTED_IN; ?>
                <?php echo get_the_term_list($post->ID,CUSTOM_CATEGORY_TYPE2,"",", ","");?>
				<?php echo AT; ?>
                <?php the_time(templ_get_date_format()); ?>
    		</div>

    <div class="detail_list">
    	<?php
			$author = $post->post_author;
			$email = get_user_meta( $author, 'user_email', true );
		?>
       	<a class="img"><?php echo get_avatar( $email,140); ?></a>
        <div class="col_right">
        	<h2><?php echo get_post_meta($post->ID,'fname', $single = true); ?> <?php echo get_post_meta($post->ID,'lname', $single = true); ?></h2>
            <?php	
				global $custom_post_meta_db_table_name;
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1 and show_on_detail = 1 and (post_type='".CUSTOM_POST_TYPE2."' or post_type='both')";
				$sql .=  " order by sort_order asc,cid asc";
				$post_meta_info = $wpdb->get_results($sql);
				foreach($post_meta_info as $post_meta_info_obj){
					if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype !='texteditor' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date' || $post_meta_info_obj->ctype =='multicheckbox' || $post_meta_info_obj->ctype =='radio' || $post_meta_info_obj->ctype =='select'){
							if($post_meta_info_obj->htmlvar_name != "category" && $post_meta_info_obj->htmlvar_name != "geo_latitude" && $post_meta_info_obj->htmlvar_name != "geo_longitude" && $post_meta_info_obj->htmlvar_name != "position_title" && $post_meta_info_obj->htmlvar_name != "company_name" && $post_meta_info_obj->htmlvar_name != "lname" && $post_meta_info_obj->htmlvar_name != "fname" && $post_meta_info_obj->htmlvar_name != "activities" && $post_meta_info_obj->htmlvar_name != "skills")
								{
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
	                                        	echo "<p><span>".$post_meta_info_obj->site_title."</span></p><p class='text-width'> ".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</p>";
											endif;
										endif;	
						}?>
					 <?php  $i++;
					 }
		}			
		?>
       </div>
       <div class="clear"></div>
    
	<h3><?php _e('Professional Informaion');?> : </h3>
    <?php foreach($post_meta_info as $post_meta_info_obj){
				if($post_meta_info_obj->ctype =='text' && $post_meta_info_obj->htmlvar_name == "skills" && get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true) != "") {
					echo "<div class='text-editor Professional-info'><span>".$post_meta_info_obj->site_title."</span><p>: ".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</p></div>";
				}
				elseif($post_meta_info_obj->ctype =='texteditor' && $post_meta_info_obj->htmlvar_name != "resume_desc" && get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true) != "") {
					echo "<div class='text-editor Professional-info'><span>".$post_meta_info_obj->site_title."</span> :".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</div>";
				}
				elseif($post_meta_info_obj->ctype =='textarea' && get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true) != "") {
					echo "<div class='text-editor Professional-info'><span>".$post_meta_info_obj->site_title."</span><p>: ".get_post_meta($post->ID,$post_meta_info_obj->htmlvar_name,$single = true)."</p></div>";
				}
	}
	?>
    <div class="text-editor Professional-info"><span><?php _e('Description'); ?></span><?php the_content(); ?></div>
    </div>
    <?php if(get_post_meta($post->ID,'attachment', $single = true) != ""): ?>
	    <p><?php _e('Click here to download resume'); ?> <a href="<?php echo get_post_meta($post->ID,'attachment', $single = true); ?>" class="normal_button">Download</a></p>
    <?php endif; ?>    
    <?php endwhile;  else: ?>
    <?php _e('Sorry, no posts matched your criteria.');?>
    <!--do not delete-->
    <?php endif; ?>
</div>
</div>
<div id="sidebar">
	<?php dynamic_sidebar("resume-detail-area"); ?>
</div>    
<?php get_footer(); ?>
