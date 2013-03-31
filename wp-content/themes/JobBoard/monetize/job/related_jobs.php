<?php
$post_id=$post->ID;
$terms = get_the_terms($post_id, 'jcategory');
$catId = '';
if(count($terms) > 0):
	foreach ($terms as $term):
		$catId .= $term->term_id.",";
	endforeach;
endif;	
$catId = substr($catId,0,-1);
if(get_option("ptthemes_related_job")):
	$limit = get_option("ptthemes_related_job");
else:
	$limit = 5;
endif;	
$query = "select $wpdb->posts.* from $wpdb->posts,$wpdb->terms,$wpdb->term_taxonomy,$wpdb->term_relationships where $wpdb->terms.term_id in (".$catId.") and $wpdb->terms.term_id = $wpdb->term_taxonomy.term_id and $wpdb->term_taxonomy.taxonomy = 'jcategory' and $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->term_relationships.term_taxonomy_id and  $wpdb->term_relationships.object_id = $wpdb->posts.ID and $wpdb->posts.ID != ".$post->ID." and $wpdb->posts.post_status='publish' group by $wpdb->posts.ID order by $wpdb->posts.ID LIMIT 0 ,$limit";
$post_content = $wpdb->get_results($query);
if($post_content)
{
?>
<p class="posted"><?php echo SIMILAR_JOB; ?></p>
<div class="list_01">
        <ul>
         <?php foreach($post_content as $post): ?>
        	<li>
				<?php if(get_post_meta($post->ID,'company_logo', $single = true)): ?>
                    <a href="<?php the_permalink(); ?>" class="img"><img src="<?php echo get_post_meta($post->ID,'company_logo', $single = true); ?>" border="0" class="company_logo" /></a>
                <?php else: ?>
                     <a href="<?php the_permalink(); ?>" class="img"><img src="<?php bloginfo("template_directory"); ?>/images/no-image.png" alt=""  class="company_logo" /></a>
                <?php endif; ?>
                <div class="job-listed">
                    <div class="col_1">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
                        <?php echo get_post_meta($post->ID,"company_name",$single = true); ?>
                   </div>
                   <div class="col_2">
                        <?php echo get_post_meta($post->ID,"job_location",$single = true); ?><br />
                        <small><?php echo get_post_meta($post->ID,"job_type",$single = true); ?></small>
                   </div>
                    <div class="col_3">
                        <?php the_time(templ_get_date_format()); ?>
                   </div>
               </div>
               <div class="clear"></div>
            </li>
         <?php endforeach; ?>   
        </ul>
    </div> 
<?php }?>