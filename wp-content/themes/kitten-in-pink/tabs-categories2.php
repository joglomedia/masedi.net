


<div class="domtab">
  <ul class="domtabs">
    <li><a href="#t1">My Themes</a></li>
    <li><a href="#t2">My Plugins</a></li>
 <li><a href="#t3">Interview</a></li>
 <li><a href="#t4">How To</a></li>
  </ul>
  <div>
    
   <?php  
   
   $c_name="my-themes";
    $c_query = new WP_Query('tag='.$c_name.'&showposts=2');
// Loop through the posts
	while ($c_query->have_posts()) : $c_query->the_post();
		// Show the post and its contents
		?>
		<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?> name="t1" id="t1""><?php the_title(); ?></a></h2>
		
			<?php the_excerpt(); ?>
			
		
		<?php 
	endwhile;
	
	
 ?>
    
  <a href="<?php echo get_settings('home'); ?>/tag/my-themes/" >More of my Themes >></a>
    
  </div>
  <div>
  	<?php
    $c_name="my-plugins";
    $c_query = new WP_Query('tag='.$c_name.'&showposts=2');
// Loop through the posts
	while ($c_query->have_posts()) : $c_query->the_post();
		// Show the post and its contents
		?>
		<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?> name="t2" id="t2""><?php the_title(); ?></a></h2>
		
			<?php the_excerpt(); ?>
			
		
		<?php 
	endwhile;
	?>
	<a href="<?php echo get_settings('home'); ?>/tag/my-plugins/" >More of my plugins >></a>
  </div>
  
   <div>
  	<?php
    $c_name="interview";
    $c_query = new WP_Query('tag='.$c_name.'&showposts=2');
// Loop through the posts
	while ($c_query->have_posts()) : $c_query->the_post();
		// Show the post and its contents
		?>
		<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?> name="t3" id="t3""><?php the_title(); ?></a></h2>
		
			<?php the_excerpt(); ?>
			
		
		<?php 
	endwhile;
	?>
	<a href="<?php echo get_settings('home'); ?>/tag/interview/" >More Interviews >></a>
  </div>



 <div>
  	<?php
    $c_name="how-to";
    $c_query = new WP_Query('tag='.$c_name.'&showposts=2');
// Loop through the posts
	while ($c_query->have_posts()) : $c_query->the_post();
		// Show the post and its contents
		?>
		<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?> name="t4" id="t4""><?php the_title(); ?></a></h2>
		
			<?php the_excerpt(); ?>
			
		
		<?php 
	endwhile;
	?>
	<a href="<?php echo get_settings('home'); ?>/tag/interview/" >More How To >></a>
  </div>









</div>