<?php

$options[] = array(	"type" => "maintabletop");

    /// General Settings
	
	    $options[] = array(	"name" => "General Settings",
						"type" => "heading");
						
		    $options[] = array(	"name" => "Theme Colorscheme",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"desc" => "Please select the CSS colorscheme for your site here.",
					                "id" => $shortname."_alt_stylesheet",
					                "std" => "Select a CSS skin:",
					                "type" => "select",
					                "options" => $alt_stylesheets);
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Customize Your Design",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Use Custom Stylesheet",
						            "desc" => "If you want to make custom design changes using CSS enable and <a href='". $customcssurl . "'>edit custom.css file here</a>.",
						            "id" => $shortname."_customcss",
						            "std" => "false",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Favicon",
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"desc" => "Paste the full URL for your favicon image here if you wish to show it in browsers. <a href='http://www.favicon.cc/'>Create one here</a>",
						            "id" => $shortname."_favicon",
						            "std" => "",
						            "type" => "text");	
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Header Logo Settings",
						        "toggle" => "true",
								"type" => "subheadingtop");

                $options[] = array(	"desc" => "Paste the full URL to your logo image here. ( logo size width:300px max )",
						            "id" => $shortname."_logo_url",
						            "std" => "",
						            "type" => "file");

				$options[] = array(	"name" => "Choose Site Title over Logo",
				                    "desc" => "This option will overwrite your logo selection above - You can <a href='". $generaloptionsurl . "'>change your settings here</a>",
						            "label" => "Show Site Title + Tagline.",
						            "id" => $shortname."_show_blog_title",
						            "std" => "true",
						            "type" => "checkbox");	

			$options[] = array(	"type" => "subheadingbottom");
			
			 $options[] = array(	"name" => "Sidebar Position Settings",
						        "toggle" => "true",
								"type" => "subheadingtop");
				
				$options[] = array(	"name" => "Select a Sidebar Position",
			    		            "desc" => "",
									"id" => $shortname."_sidebar_left",
			    		            "type" => "select",
			    		            "options" => array('right','left'));
						
		    $options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Syndication / Feed",
						        "toggle" => "true",
								"type" => "subheadingtop");			
						
			$options[] = array( "desc" => "If you are using a service like Feedburner to manage your RSS feed, enter full URL to your feed into box above. If you'd prefer to use the default WordPress feed, simply leave this box blank.",
			    		            "id" => $shortname."_feedburner_url",
			    		            "std" => "",
			    		            "type" => "text");	
						
			$options[] = array(	"type" => "subheadingbottom");
								
 $options[] = array(	"name" => "Image Setting (Tim thumb setting - Image Cutting Edge)",
						        "toggle" => "true",
								"type" => "subheadingtop");	

$options[] = array(	"name" => __("Default Image Cutting Edge"),
					                "desc" => __("Set Default Image Cutting Edge Position."),
					                "id" => $shortname."_image_x_cut",
					                "std" => "",
									"options" => array('center','top','bottom','left','right','top right','top left','bottom right','bottom left'),
					                "type" => "select");
				$options[] = array(	"type" => "subheadingbottom");
			 
			 					
		$options[] = array(	"type" => "maintablebreak");
		
		
    /// Navigation Settings												
				
		$options[] = array(	"name" => "Navigation Settings",
						    "type" => "heading");
										
				$options[] = array(	"name" => "Exclude Pages from Header Menu",
								"toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"type" => "multihead");
						
				$options = pages_exclude($options);
									
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Show \"Browse Properties\" Link",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Show \"Browse Properties\" link in main menu?",
						            "desc" => "",
						            "id" => $shortname."_borwse_link_flag",
						            "std" => "true",
						            "type" => "checkbox");
									
				$options[] = array(	"label" => "Show \"Browse Properties\" link at the end of manu menu",
						            "desc" => "",
						            "id" => $shortname."_borwse_link_pos_flag",
						            "std" => "true",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Show \"Agents Listing\" Link",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Show \"Agents\" link in main menu",
						            "desc" => "",
						            "id" => $shortname."_agents_link_flag",
						            "std" => "true",
						            "type" => "checkbox");
									
				$options[] = array(	"label" => "Show \"Agents\"  link at the end of manu menu",
						            "desc" => "",
						            "id" => $shortname."_agents_link_post_flag",
						            "std" => "true",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Breadcrumbs Navigation",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Show breadcrumbs navigation bar",
						            "desc" => "i.e. Home > Blog > Title - <a href='". $breadcrumbsurl . "'>Change options here</a>",
						            "id" => $shortname."_breadcrumbs",
						            "std" => "true",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
$options[] = array(	"name" => "Footer Navigation",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Show breadcrumbs navigation bar",
                	                "desc" => "Enter a comma-separated list of the <code>page ID's</code> that you'd like to display in footer (on the right). (ie. <code>1,2,3,4</code>)",
						            "id" => $shortname."_footerpages",
						            "std" => "",
						            "type" => "text");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
			
			
			$options[] = array(	"name" => "Header advertise banner",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Header advertise",
                	                "desc" => "add your advertise url or google adsense code here",
						            "id" => $shortname."_header_advt",
						            "std" => "",
						            "type" => "textarea");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
						
		$options[] = array(	"type" => "maintablebreak");
		
		
		
	   
		
	/// Blog Section Settings												
				
		$options[] = array(	"name" => "Blog Section Settings",
						    "type" => "heading");
			
		    $options[] = array(	"name" => "Pick Category for Your Blog Posts",
						        "toggle" => "true",
								"type" => "subheadingtop");
				
				$options[] = array(	"name" => "Select a category for your blog posts",
			    		            "desc" => "Pick a category where your blog posts will be. It is advisable to create category and name it 'blog'. After that put all other blog categories as child categories of 'blog' so you don't need to change categories in posts.",
									"id" => $shortname."_blogcategory",
			    		            "type" => "select",
			    		            "options" => $pn_categories);
						
		    $options[] = array(	"type" => "subheadingbottom");
			
		$options[] = array(	"name" => "Content Display",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Display Full Post Content",
						            "desc" => "Instead of default Post excerpts display Full Post Content in Blog Section",
						            "id" => $shortname."_postcontent_full",
						            "std" => "false",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
		
			
			
			$options[] = array(	"name" => "Single post footer advertise",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "Single post footer advertise",
                	                "desc" => "advertise url & link",
						            "id" => $shortname."_single_post_advt",
						            "std" => "",
						            "type" => "textarea");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
		 $options[] = array(	"type" => "maintablebreak");
			
	/// Property Section Settings												
				
		$options[] = array(	"name" => "Property Category Settings",
						    "type" => "heading");
			
		    $options[] = array(	"name" => "Featured Category",
						        "toggle" => "true",
								"type" => "subheadingtop");
				
				$options[] = array(	"name" => "Select a category for your Featured listings",
			    		            "desc" => "Pick a category under which your Featured listings will be published. It is advisable to create category and name it 'Featured'.",
									"id" => $shortname."_featuredcategory",
			    		            "type" => "select",
			    		            "options" => $parent_cat_arr);
						
		    $options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Properties Category",
						        "toggle" => "true",
								"type" => "subheadingtop");
				
				$options[] = array(	"name" => "Select a category for Properties",
			    		            "desc" => "Pick a category under which you will add different Properties will be inserted. It is advisable to create category and name it 'Properties'",
									"id" => $shortname."_propertycategory",
			    		            "type" => "select",
			    		            "options" => $parent_cat_arr);
						
		    $options[] = array(	"type" => "subheadingbottom");
			
		$options[] = array(	"name" => "'New' property duration",
						        "toggle" => "true",
								"type" => "subheadingtop");	
						
				$options[] = array(	"name" => "A small 'new' icon is shown to the newly submitted properties. For how many days the icon should be shown?",
					                "desc" => "",
					                "id" => $shortname."_new_properties",
					                "std" => "30",
					                "type" => "text");
			
			$options[] = array(	"type" => "subheadingbottom");

		$options[] = array(	"type" => "maintablebottom");
				
$options[] = array(	"type" => "maintabletop");


		/// Map Options
				
		$options[] = array(	"name" => "Google Map Settings",
						    "type" => "heading");
			
			$options[] = array(	"name" => "Map Central - latitude, longitude & scaling factor",
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"name" => "Google Map API key",
					                "desc" => "Enter Google Map API key. You can get it from <a href=\"http://code.google.com/apis/maps/signup.html\" target=\"_blank\">Get Google Map API Key</a>.",
					                "id" => $shortname."_api_key",
					                "std" => "",
					                "type" => "text");
			
		$options[] = array(	"name" => "Map Central latitute",
					                "desc" => "Enter latitude value of the central of map for the city you want to display. You can get it from http://map.google.com. Default value is '34'.",
					                "id" => $shortname."_latitute",
					                "std" => "34",
					                "type" => "text");

				$options[] = array(	"name" => "Map Central longitude",
					                "desc" => "Enter longitude value of the central of map for the city you want to display. You can get it from http://map.google.com. Default value is '0'.",
						            "id" => $shortname."_longitute",
						            "std" => "0",
						            "type" => "text");
									
				$options[] = array(	"name" => "Map Scaling Factor",
					                "desc" => "Enter scaling factor of map - how much detail you want to show. Scaling factor can be in between 1 to 20 only. Default is '3'.",
						            "id" => $shortname."_scaling_factor",
						            "std" => "5",
						            "type" => "text");
						
			$options[] = array(	"type" => "subheadingbottom");
			
		$options[] = array(	"type" => "maintablebreak");
		
 			///settings			
		$options[] = array(	"name" => "Home Page Settings",
						    "type" => "heading");
										
			$options[] = array(	"name" => "Number of 'Latest Properties' to be shown",
						        "toggle" => "true",
								"type" => "subheadingtop");	
						
				$options[] = array(	"name" => "Number of Latest Properties display on Home page",
					                "desc" => "",
					                "id" => $shortname."_latest_properties",
					                "std" => "3",
					                "type" => "text");
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Home page Slider Settings",
						        "toggle" => "true",
								"type" => "subheadingtop");	
						
				$options[] = array(	"name" => "Featured properties slider speed in milliseconds before second slide is shown",
					                "desc" => "",
					                "id" => $shortname."_sliderspeed_homepage",
					                "std" => "1500",
					                "type" => "text");
			
				$options[] = array(	"label" => "Auto animate the featured property slider in the homepage",
						            "desc" => "",
						            "id" => $shortname."_homepage_sliderrotate_flag",
						            "std" => "true",
						            "type" => "checkbox");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
									
		$options[] = array(	"type" => "maintablebreak");


 /// Property Detail Page Settings												
				
		$options[] = array(	"name" => "Property Details Page  Settings",
						    "type" => "heading");
			
	//Related Property 
			$options[] = array(	"name" => "Number of similar / related properties",
						        "toggle" => "true",
								"type" => "subheadingtop");	
						
				$options[] = array(	"name" => "Maximum number of related properties to be displayed on property detail page",
					                "desc" => "",
					                "id" => $shortname."_related_property",
					                "std" => "5",
					                "type" => "text");
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Set comments on Property detail",
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"label" => "Wish to enable comments on Property Detail page?",
									"desc" => "",
						            "id" => $shortname."_set_comments",
						            "std" => "true",
						            "type" => "checkbox");
			$options[] = array(	"type" => "subheadingbottom");
			
				
			$options[] = array(	"name" => "Social Icons",
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"label" => "Add to Facebook",
									"desc" => "deselect social icons that you do not want to show on property details page",
						            "id" => $shortname."_facebook",
						            "std" => "true",
						            "type" => "checkbox");
									
				$options[] = array(	"label" => "Add to tag Digg It.",
						            "id" => $shortname."_digg",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add to Delicious",
						            "id" => $shortname."_del",
						            "std" => "true",
						            "type" => "checkbox");
									
			    $options[] = array(	"label" => "Add Twitter",
						            "id" => $shortname."_twitter",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add  to Redd It",
						            "id" => $shortname."_reddit",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add  to Linked In",
						            "id" => $shortname."_linkedin",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add to Technorati",
						            "id" => $shortname."_technorati",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add to MySpace",
						            "id" => $shortname."_myspace",
						            "std" => "true",
						            "type" => "checkbox");
				
						
			$options[] = array(	"type" => "subheadingbottom");
			
			
						
		$options[] = array(	"type" => "maintablebreak");	
			
	/// Blog Section Settings												
				
		$options[] = array(	"name" => "Add/edit content at the top of  <br /> Login & Registration page",
						    "type" => "heading");
			
		  
			$options[] = array(	"name" => "Login page top content",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "",
                	                "desc" => "",
						            "id" => $shortname."_logoin_page_content",
						            "std" => "",
						            "type" => "textarea");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Registration page top content",
						        "toggle" => "true",
								"type" => "subheadingtop");
						
				$options[] = array(	"label" => "",
                	                "desc" => "",
						            "id" => $shortname."_reg_page_content",
						            "std" => "",
						            "type" => "textarea");	
						
			$options[] = array(	"type" => "subheadingbottom");
			
		 $options[] = array(	"type" => "maintablebreak");
		
	/// Blog Stats and Scripts											
				
		$options[] = array(	"name" => "Stats and Scripts",
						    "type" => "heading");
										
			$options[] = array(	"name" => "Header Scripts",
						        "toggle" => "true",
								"type" => "subheadingtop");	
						
				$options[] = array(	"name" => "Header Scripts",
					                "desc" => "If you need to add scripts to your header (like <a href='http://haveamint.com/'>Mint</a> tracking code), do so here.",
					                "id" => $shortname."_scripts_header",
					                "std" => "",
					                "type" => "textarea");
			
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Footer Scripts",
						        "toggle" => "true",
								"type" => "subheadingtop");	
						
				$options[] = array(	"name" => "Footer Scripts",
					                "desc" => "If you need to add scripts to your footer (like <a href='http://www.google.com/analytics/'>Google Analytics</a> tracking code), do so here.",
					                "id" => $shortname."_google_analytics",
					                "std" => "",
					                "type" => "textarea");
			
			$options[] = array(	"type" => "subheadingbottom");
						
		$options[] = array(	"type" => "maintablebreak");
		

		
	/// SEO Options
				
		$options[] = array(	"name" => "SEO Options",
						    "type" => "heading");
						
			$options[] = array(	"name" => "Home Page <code>&lt;meta&gt;</code> tags",
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"name" => "Meta Description",
					                "desc" => "You should use meta descriptions to provide search engines with additional information about topics that appear on your site. This only applies to your home page.",
					                "id" => $shortname."_meta_description",
					                "std" => "",
					                "type" => "textarea");

				$options[] = array(	"name" => "Meta Keywords (comma separated)",
					                "desc" => "Meta keywords are rarely used nowadays but you can still provide search engines with additional information about topics that appear on your site. This only applies to your home page.",
						            "id" => $shortname."_meta_keywords",
						            "std" => "",
						            "type" => "text");
									
				$options[] = array(	"name" => "Meta Author",
					                "desc" => "You should write your <em>full name</em> here but only do so if this blog is writen only by one outhor. This only applies to your home page.",
						            "id" => $shortname."_meta_author",
						            "std" => "",
						            "type" => "text");
						
			$options[] = array(	"type" => "subheadingbottom");
			
			$options[] = array(	"name" => "Add <code>&lt;noindex&gt;</code> tags",
						        "toggle" => "true",
								"type" => "subheadingtop");

				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to category archives.",
						            "id" => $shortname."_noindex_category",
						            "std" => "true",
						            "type" => "checkbox");
									
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to tag archives.",
						            "id" => $shortname."_noindex_tag",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to author archives.",
						            "id" => $shortname."_noindex_author",
						            "std" => "true",
						            "type" => "checkbox");
									
			    $options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to Search Results.",
						            "id" => $shortname."_noindex_search",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to daily archives.",
						            "id" => $shortname."_noindex_daily",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to monthly archives.",
						            "id" => $shortname."_noindex_monthly",
						            "std" => "true",
						            "type" => "checkbox");
				
				$options[] = array(	"label" => "Add <code>&lt;noindex&gt;</code> to yearly archives.",
						            "id" => $shortname."_noindex_yearly",
						            "std" => "true",
						            "type" => "checkbox");
				
						
			$options[] = array(	"type" => "subheadingbottom");
			
			
		$options[] = array(	"type" => "maintablebreak");
		
	 
$options[] = array(	"type" => "maintablebottom");

?>