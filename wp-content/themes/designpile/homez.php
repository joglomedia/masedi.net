<?php get_header(); ?>

<!-- begin colleft -->
				<div id="colLeft">
				<div id="colLeftInner" class="clearfix">
					<!-- begin fetured post -->
				 <?php query_posts('tag=featured');?>
                     <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div id="featuredPost">
						<span class="label">FEATURED POST</span>
						<h2 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
						<div class="meta">
							By <span class="author"><?php the_author_link(); ?></span> &nbsp;//&nbsp;  <?php the_category(', ') ?>  &nbsp;//&nbsp;  <?php comments_popup_link('No Comments', '1 Comment ', '% Comments'); ?> 
						</div>
						<div class="featuredDetails"><?php the_excerpt()?>
                        <?php $featured_img = get_post_meta($post->ID, 'featured_img', $single = true); ?>
						<a href="<?php the_permalink(); ?>"><img src="<?php echo $featured_img ?>" border="0" alt="<?php the_title(); ?>" /></a>
						</div>
					</div>
					<!-- end featured post -->
                   <?php endwhile; ?>
				   <?php else : ?>
				   <?php endif; ?>
                    
					<?php $posts_query = new WP_Query($query_string.'tag=homepost&posts_per_page=-1');
						  if(!$posts_query -> have_posts()){
							  $latestposts_no = get_option('designpile_latest_posts');
							  if($latestposts_no != null){
								 $posts_query = new WP_Query($query_string.'posts_per_page='.$latestposts_no);
							  }else{
								 $posts_query = new WP_Query($query_string.'posts_per_page=6');
							  }
						  }
						  $odd_or_even = 'odd'; ?>
                        <?php if ($posts_query -> have_posts()) : while ($posts_query -> have_posts()) : $posts_query -> the_post();  ?>
                        <div class="homePost <?php echo $odd_or_even; ?>">
                            <div class="date"><?php the_time('M') ?><br /><span><?php the_time('j') ?></span></div>
                             <div class="meta">
                                By <span class="author"><?php the_author_link(); ?></span> &nbsp;//&nbsp;  <?php comments_popup_link('No Comments', '1 Comment ', '% Comments'); ?>
                            </div>
                            <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                           
                            <div><a href="#"><img src="<?php if ( function_exists('p75GetThumbnail') )echo p75GetThumbnail($post->ID); ?>" alt="" /></a><?php the_excerpt(); ?> </div>
                        </div>
                        <?php $odd_or_even = ('odd'==$odd_or_even) ? 'even' : 'odd'; ?>
                        <?php endwhile; ?>
                    
                        <?php else : ?>
                    
                            <p>Sorry, but you are looking for something that isn't here.</p>
                    
                        <?php endif; ?>
					
					
					 </div>
					<!-- end colleftInner -->
					
				</div>
			<!-- end colleft -->
			<?php get_sidebar(); ?>	
			
<?php get_footer(); ?>
