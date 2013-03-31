<?php
require_once dirname( __FILE__ ) . '/form_process.php';
get_header( ); 
include_classified_form();
?>


<?php
	//This sets the $curauth variable
	if(isset($_GET['author_name'])) :
		$curauth = get_userdatabylogin($author_name);
	else :
		$curauth = get_userdata(intval($author));
	endif;
	
$sql_statement = "SELECT * FROM $wpdb->posts WHERE post_author = $curauth->ID AND post_type = 'post' AND post_status = 'publish' ORDER BY ID DESC";	
$authorposts = $wpdb->get_results($sql_statement, OBJECT);
	
?>
	
	<div class="content">
		<div class="main ins">
		
			<div class="left">
			
				<div class="title">
					<h2><?php _e('About','cp')?> <?php echo($curauth->display_name); ?></h2>
					
					
					<?php 
					if(function_exists('userphoto_exists')){
					  echo "<div id='user-photo'>";
						if(userphoto_exists($curauth->ID))
							userphoto($curauth->ID);
						else
							echo get_avatar($userdata->user_email, 96);
					  echo "</div>";
					}	
					 ?>
					 <div class="clear"></div>
				</div>
					
				
				<div class="author-main">
					
					<p>
					<strong><?php _e('Website:','cp'); ?></strong> <a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a>
					<br />
					<strong><?php _e('Description:','cp'); ?> </strong> <?php echo $curauth->user_description; ?>
					</p>

					<h3><?php _e('Other ads listed by','cp'); ?> <?php echo $curauth->display_name; ?></h3>

					<ul id="author-ads">
					
					<?php if ($authorposts): ?>
					
						<?php foreach ($authorposts as $post): ?>
						<li>
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
						</li>
						
						<?php endforeach; ?>
					
					<?php else: ?>
					
						<p><?php _e('No ads by this poster yet.','cp'); ?></p>
					
					<?php endif; ?>

					</ul>	


				</div>
			</div>
	
			
		<?php get_sidebar(); ?>	
			
			<div class="clear"></div>
		</div>
	</div>

<?php get_footer(); ?>
