<?php
$post_id=$post->ID;
$company_name = get_post_meta($post_id,"company_name",$single = true);
if(get_option("ptthemes_other_job")):
	$limit = get_option("ptthemes_other_job");
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
<p class="posted"><?php echo OTHER_JOB; ?></p>
<div class="list_01">
        <ul>
         <?php foreach($post_content1 as $_post): ?>
        	<li>
				<?php if(get_post_meta($_post->ID,'company_logo', $single = true)): ?>
                    <a href="<?php echo get_permalink($_post->ID); ?>" class="img"><img src="<?php echo get_post_meta($_post->ID,'company_logo', $single = true); ?>" border="0" class="company_logo" /></a>
                <?php else: ?>
                     <a href="<?php echo get_permalink($_post->ID); ?>" class="img"><img src="<?php bloginfo("template_directory"); ?>/images/no-image.png" alt=""  class="company_logo" /></a>
                <?php endif; ?>
                <div class="job-listed">
                    <div class="col_1">
                        <h2><a href="<?php echo get_permalink($_post->ID); ?>"><?php echo get_the_title($_post->ID);?></a></h2>
                        <?php echo get_post_meta($_post->ID,"company_name",$single = true); ?>
                   </div>
                   <div class="col_2">
                        <?php echo get_post_meta($_post->ID,"job_location",$single = true); ?><br />
                        <small><?php echo get_post_meta($post->ID,"job_type",$single = true); ?></small>
                   </div>
                    <div class="col_3">
                        <?php echo get_the_time('j M ',$_post->ID) ?> <small><?php echo get_the_time('Y',$_post->ID) ?></small>
                   </div>
               </div>
               <div class="clear"></div>
            </li>
         <?php endforeach; ?>   
        </ul>
    </div> 
<?php }?>