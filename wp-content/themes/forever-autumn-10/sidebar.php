<!-- sidebar.php start -->
        <div id="sidebar">

            <div id="sb_search">

                    <form method="get" id="search_form" action="<?php bloginfo('home'); ?>/">
                   <div class="txt"><input type="text" value="Search" name="s" id="s" class="s_text" onfocus="clearfield(this);" /></div>
                   <div class="btn"><input type="submit" id="searchsubmit" value="" class="searchsubmit" /></div>
                    </form>

            </div>

			<ul>
		<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>
				<li class="sb-about">
				<!-- Write a little something about you here -->
				<h2>About Us</h2>
				<small>Describe yourself here!</small>
				<!-- end-->
				</li>
				<li id="pages">
				<h2>Pages</h2>
					<ul>
						<li><a href="<?php echo get_settings('home'); ?>/">Home</a></li>
						<?php wp_list_pages('title_li=' ); ?>
					</ul>
				
				</li>
				<li id="calendar">
				<h2>Calendar</h2>
				<?php get_calendar(); ?>
				</li>

				<li id="archives">
				<h2>Archives</h2>
					  <ul>
					  <?php wp_get_archives('type=monthly'); ?>
					  </ul>
				</li>
		    
				  <li id="categories">
				  <h2>Categories</h2>
					  <ul>
						<?php wp_list_cats(); ?>
					  </ul>
				  </li>
              
				  <li id="blogroll">
				  <h2>Blogroll</h2>
						<ul>
							<?php get_links(-1, '<li>', '</li>', '', FALSE, 'name', FALSE, FALSE, -1, FALSE); ?>
						</ul>
				  </li>
			  
				  <li id="recentposts">
				  <h2>Recent Posts</h2>
					<ul>
					   <?php wp_get_archives('type=postbypost&limit=50'); ?>
					</ul>
				  </li>
				  
				  <li id="meta">
					  <h2>Meta</h2>
					  <ul>
						<li><a href="<?php bloginfo('rss2_url'); ?>">RSS 2.0 Feed</a></li>
						  <li><a href="<?php bloginfo('atom_url'); ?>">Atom Feed</a></li>
						  <li><a href="<?php bloginfo_rss('comments_rss2_url'); ?>">Comments RSS Feed</a></li>
						  <li><?php wp_loginout(); ?></li>
						  <?php wp_register('<li>','</li>'); ?>
						<?php wp_meta(); ?>
						</ul>
				   </li>
			
			<?php endif; ?>
			</ul> 
			    
             
        </div>
        
        <!-- sidebar.php end -->