(function() {
	tinymce.create('tinymce.plugins.optinlite', {
		init : function(ed, url) {
			
		},
		
		createControl : function(n, cm) {
			if ( n == 'optinlite' ) {
				var opl = cm.createListBox('optinliteList', {
					title : 'InstaBuilder',
					onselect : function(v) { //Option value as parameter
						if ( v == 'two_cols' ) {
							var two_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Column 1 content here';
							var col = '';
							col += '[ez_two]<p>' + two_content + '</p>[/ez_two]<br />';
							col += '[ez_two_last]<p>Column 2 content here</p>[/ez_two_last]';
							tinyMCE.activeEditor.selection.setContent(col);
						} else if ( v == 'three_cols' ) {
							var three_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Column 1 content here';
							var col = '';
							col += '[ez_three]<p>' + three_content + '</p>[/ez_three]<br />';
							col += '[ez_three]<p>Column 2 content here</p>[/ez_three]<br />';
							col += '[ez_three_last]<p>Column 3 content here</p>[/ez_three_last]';
							tinyMCE.activeEditor.selection.setContent(col);
						} else if ( v == 'four_cols' ) {
							var four_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Column 1 content here';
							var col = '';
							col += '[ez_four]<p>' + four_content + '</p>[/ez_four]<br />';
							col += '[ez_four]<p>Column 2 content here</p>[/ez_four]<br />';
							col += '[ez_four]<p>Column 3 content here</p>[/ez_four]<br />';
							col += '[ez_four_last]<p>Column 4 content here</p>[/ez_four_last]';
							tinyMCE.activeEditor.selection.setContent(col);
						} else if ( v == 'five_cols' ) {
							var five_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Column 1 content here';
							var col = '';
							col += '[ez_five]<p>' + five_content + '</p>[/ez_five]<br />';
							col += '[ez_five]<p>Column 2 content here</p>[/ez_five]<br />';
							col += '[ez_five]<p>Column 3 content here</p>[/ez_five]<br />';
							col += '[ez_five]<p>Column 4 content here</p>[/ez_five]<br />';
							col += '[ez_five_last]<p>Column 5 content here</p>[/ez_five_last]<br />';
							tinyMCE.activeEditor.selection.setContent(col);
						} else if ( v == 'six_cols' ) {
							var six_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Column 1 content here';
							var col = '';
							col += '[ez_six]<p>' + six_content + '</p>[/ez_six]<br />';
							col += '[ez_six]<p>Column 2 content here</p>[/ez_six]<br />';
							col += '[ez_six]<p>Column 3 content here</p>[/ez_six]<br />';
							col += '[ez_six]<p>Column 4 content here</p>[/ez_six]<br />';
							col += '[ez_six]<p>Column 5 content here</p>[/ez_six]<br />';
							col += '[ez_six_last]<p>Column 6 content here</p>[/ez_six_last]<br />';
							tinyMCE.activeEditor.selection.setContent(col);
						
						} else if ( v == 'colvar_1' ) {
							var three_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Column 1 content here';
							var col = '';
							col += '[ez_one_fourth]<p>' + three_content + '</p>[/ez_one_fourth]<br />';
							col += '[ez_three_fourth_last]<p>Column 2 content here</p>[/ez_three_fourth_last]';
							tinyMCE.activeEditor.selection.setContent(col);
						
						} else if ( v == 'colvar_2' ) {
							var three_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Column 1 content here';
							var col = '';
							col += '[ez_three_fourth]<p>' + three_content + '</p>[/ez_three_fourth]<br />';
							col += '[ez_one_fourth_last]<p>Column 2 content here</p>[/ez_one_fourth_last]';
							tinyMCE.activeEditor.selection.setContent(col);
							
						} else if ( v == 'colvar_3' ) {
							var three_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Column 1 content here';
							var col = '';
							col += '[ez_one_third]<p>' + three_content + '</p>[/ez_one_third]<br />';
							col += '[ez_two_third_last]<p>Column 2 content here</p>[/ez_two_third_last]';
							tinyMCE.activeEditor.selection.setContent(col);
						
						} else if ( v == 'colvar_4' ) {
							var three_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Column 1 content here';
							var col = '';
							col += '[ez_two_third]<p>' + three_content + '</p>[/ez_two_third]<br />';
							col += '[ez_one_third_last]<p>Column 2 content here</p>[/ez_one_third_last]';
							tinyMCE.activeEditor.selection.setContent(col);
							
						} else if ( v == 'tab_content' ) {
							var tab_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Tab 1 content here';
							var tabs = '';
							tabs += '[ez_tabs tab1="Tab 1 Title" tab2="Tab 2 Title" tab3="Tab 3 Title" tab4="Tab 4 Title"]<br />';
							tabs += '[ez_tab]<p>' + tab_content + '</p>[/ez_tab]<br />';
							tabs += '[ez_tab]<p>Tab 2 content here</p>[/ez_tab]<br />';
							tabs += '[ez_tab]<p>Tab 3 content here</p>[/ez_tab]<br />';
							tabs += '[ez_tab]<p>Tab 4 content here</p>[/ez_tab]<br />';
							tabs += '[/ez_tabs]';
							tinyMCE.activeEditor.selection.setContent(tabs);
							
						} else if ( v == 'ez_date' ) {
							tinyMCE.activeEditor.selection.setContent('[' + v + ']');
						} else if ( v == 'grey_btn' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_btn color="grey" url="http://" target="_self"]' + tinyMCE.activeEditor.selection.getContent() + '[/ez_btn]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_btn color="grey" url="http://" target="_self"]Button Label[/ez_btn]');
						} else if ( v == 'red_btn' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_btn color="red" url="http://" target="_self"]' + tinyMCE.activeEditor.selection.getContent() + '[/ez_btn]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_btn color="red" url="http://" target="_self"]Button Label[/ez_btn]');
						} else if ( v == 'orange_btn' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_btn color="orange" url="http://" target="_self"]' + tinyMCE.activeEditor.selection.getContent() + '[/ez_btn]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_btn color="orange" url="http://" target="_self"]Button Label[/ez_btn]');
						} else if ( v == 'yellow_btn' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_btn color="yellow" url="http://" target="_self"]' + tinyMCE.activeEditor.selection.getContent() + '[/ez_btn]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_btn color="yellow" url="http://" target="_self"]Button Label[/ez_btn]');
						} else if ( v == 'green_btn' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_btn color="green" url="http://" target="_self"]' + tinyMCE.activeEditor.selection.getContent() + '[/ez_btn]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_btn color="green" url="http://" target="_self"]Button Label[/ez_btn]');
						} else if ( v == 'blue_btn' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_btn color="blue" url="http://" target="_self"]' + tinyMCE.activeEditor.selection.getContent() + '[/ez_btn]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_btn color="blue" url="http://" target="_self"]Button Label[/ez_btn]');
						} else if ( v == 'black_btn' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_btn color="black" url="http://" target="_self"]' + tinyMCE.activeEditor.selection.getContent() + '[/ez_btn]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_btn color="black" url="http://" target="_self"]Button Label[/ez_btn]');
						
						} else if ( v == 'big_yellow_btn' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_big_btn color="yellow" url="http://" target="_self" circle="yes"]' + tinyMCE.activeEditor.selection.getContent() + '[/ez_big_btn]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_big_btn color="yellow" url="http://" target="_self" circle="yes"]Button Label[/ez_big_btn]');
						} else if ( v == 'big_red_btn' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_big_btn color="red" url="http://" target="_self" circle="yes"]' + tinyMCE.activeEditor.selection.getContent() + '[/ez_big_btn]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_big_btn color="red" url="http://" target="_self" circle="yes"]Button Label[/ez_big_btn]');
						} else if ( v == 'big_orange_btn' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_big_btn color="orange" url="http://" target="_self" circle="yes"]' + tinyMCE.activeEditor.selection.getContent() + '[/ez_big_btn]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_big_btn color="orange" url="http://" target="_self" circle="yes"]Button Label[/ez_big_btn]');
						} else if ( v == 'big_blue_btn' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_big_btn color="blue" url="http://" target="_self" circle="yes"]' + tinyMCE.activeEditor.selection.getContent() + '[/ez_big_btn]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_big_btn color="blue" url="http://" target="_self" circle="yes"]Button Label[/ez_big_btn]');
						} else if ( v == 'big_grey_btn' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_big_btn color="grey" url="http://" target="_self" circle="yes"]' + tinyMCE.activeEditor.selection.getContent() + '[/ez_big_btn]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_big_btn color="grey" url="http://" target="_self" circle="yes"]Button Label[/ez_big_btn]');
						} else if ( v == 'big_green_btn' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_big_btn color="green" url="http://" target="_self" circle="yes"]' + tinyMCE.activeEditor.selection.getContent() + '[/ez_big_btn]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_big_btn color="green" url="http://" target="_self" circle="yes"]Button Label[/ez_big_btn]');
						
						} else if ( v == 'youtube' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_youtube url="' + tinyMCE.activeEditor.selection.getContent() + '" width="640" height="360" autoplay="0" autohide="2" controls="1"]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_youtube url="http://youtu.be/xxxxxxxx" width="640" height="360" autoplay="0" autohide="2" controls="1"]');
						} else if ( v == 'vimeo' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_vimeo url="' + tinyMCE.activeEditor.selection.getContent() + '" width="640" height="360" portrait="1" title="1" byline="1" autoplay="0"]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_vimeo url="http://vimeo.com/xxxxxxx" width="640" height="360" portrait="1" title="1" byline="1" autoplay="0"]');
						} else if ( v == 'mp4' ) {
							if ( tinyMCE.activeEditor.selection.getContent() != '' )
								tinyMCE.activeEditor.selection.setContent('[ez_video url="' + tinyMCE.activeEditor.selection.getContent() + '" player="flowplayer" width="640" height="360" autoplay="1" autohide="1" controls="1"]');
							else
								tinyMCE.activeEditor.selection.setContent('[ez_video url="http://" player="flowplayer" width="640" height="360" autoplay="1" autohide="1" controls="1"]');
						
						} else if ( v == 'pop_image' ) {
							tinyMCE.activeEditor.selection.setContent('[ez_popup type="image" text="Click Here" thumb_url="Thumbnail image URL here..."]Main Image URL here...[/ez_popup]');
						
						} else if ( v == 'pop_youtube' ) {
							tinyMCE.activeEditor.selection.setContent('[ez_popup type="youtube" text="Click Here To Watch Video" thumb_url="Thumbnail image URL here..." width="640" height="360"]YouTube video URL here...[/ez_popup]');
						
						} else if ( v == 'pop_vimeo' ) {
							tinyMCE.activeEditor.selection.setContent('[ez_popup type="vimeo" text="Click Here To Watch Video" thumb_url="Thumbnail image URL here..." width="640" height="360"]Vimeo video URL here...[/ez_popup]');
							
						} else if ( v == 'pop_content' ) {
							var pop_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Rich content for the popup goes here...';
							var pop = '[ez_popup type="content" text="Click Here" thumb_url="Thumbnail image URL here..." width="600" height="420"]';
							pop += '<p>' + pop_content + '</p>';
							pop += '[/ez_popup]';
							tinyMCE.activeEditor.selection.setContent(pop);
							
						} else if ( v == 'feat_blue' ) {
							var f_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Feature box content goes here...';
							var feat = '[ez_box title="Feature Box Title" color="blue"]';
							feat += '<p>' + f_content + '</p>';
							feat += '[/ez_box]';
							tinyMCE.activeEditor.selection.setContent(feat);
						} else if ( v == 'feat_green' ) {
							var f_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Feature box content goes here...';
							var feat = '[ez_box title="Feature Box Title" color="green"]';
							feat += '<p>' + f_content + '</p>';
							feat += '[/ez_box]';
							tinyMCE.activeEditor.selection.setContent(feat);
						} else if ( v == 'feat_red' ) {
							var f_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Feature box content goes here...';
							var feat = '[ez_box title="Feature Box Title" color="red"]';
							feat += '<p>' + f_content + '</p>';
							feat += '[/ez_box]';
							tinyMCE.activeEditor.selection.setContent(feat);
						} else if ( v == 'feat_orange' ) {
							var f_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Feature box content goes here...';
							var feat = '[ez_box title="Feature Box Title" color="orange"]';
							feat += '<p>' + f_content + '</p>';
							feat += '[/ez_box]';
							tinyMCE.activeEditor.selection.setContent(feat);
						} else if ( v == 'feat_grey' ) {
							var f_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Feature box content goes here...';
							var feat = '[ez_box title="Feature Box Title" color="grey"]';
							feat += '<p>' + f_content + '</p>';
							feat += '[/ez_box]';
							tinyMCE.activeEditor.selection.setContent(feat);
							
						} else if ( v == 'viral_download' ) {
							tinyMCE.activeEditor.selection.setContent('[ez_viral_download]');
							
						} else if ( v == 'fb_reveal' ) {
							var fb_content = ( tinyMCE.activeEditor.selection.getContent() != '' ) ? tinyMCE.activeEditor.selection.getContent() : 'Enter the content for your Facebook page fans here';
							
							var fb = '[ez_fb for="non-fans"]<br />';
							fb += '<p>Enter the content for non-fans here</p>';
							fb += '[/ez_fb]<br />';
							fb += '[ez_fb for="fans"]<br />';
							fb += '<p>' + fb_content + '</p>';
							fb += '[/ez_fb]<br />';
							
							tinyMCE.activeEditor.selection.setContent(fb);
						
						} else if ( v == 'optin_form' ) {
							tinyMCE.activeEditor.selection.setContent('[ez_optin_form]');
						
						} else if ( v == 'ez_countdown' ) {
							tinyMCE.activeEditor.selection.setContent('[ez_countdown day="31" month="12" year="2012" hour="11" min="0" sec="0" style="dark"]');
							
						} else if ( v == '' || v == 'vidcode' || v == 'concode' || v == 'colcode' || v == 'btncode' || v == 'bbtncode' || v == 'popcode' ) {
							// do nothing
								
						} else {
							if ( tinyMCE.activeEditor.selection.getContent() != '' ) {
								tinyMCE.activeEditor.selection.setContent('[' + v + ']' + tinyMCE.activeEditor.selection.getContent() + '[/' + v + ']');
                        	} else {
								tinyMCE.activeEditor.selection.setContent('[' + v + '][/' + v + ']');
                        	}
                       }
					}
				});
				
				
				opl.add('[-- display videos --]', 'vidcode');
				opl.add('MP4 Video', 'mp4');
				opl.add('YouTube', 'youtube');
				opl.add('Vimeo', 'vimeo');
				opl.add('[-- multi columns --]', 'colcode');
				opl.add('Two Columns', 'two_cols');
				opl.add('Three Columns', 'three_cols');
				opl.add('Four Columns', 'four_cols');
				opl.add('Five Columns', 'five_cols');
				opl.add('Six Columns', 'six_cols');
				opl.add('1/4 + 3/4 columns', 'colvar_1');
				opl.add('3/4 + 1/4 columns', 'colvar_2');
				opl.add('1/3 + 2/3 columns', 'colvar_3');
				opl.add('2/3 + 1/3 columns', 'colvar_4');
				opl.add('[-- standard buttons --]', 'btncode');
				opl.add('Grey Button', 'grey_btn');
				opl.add('Red Button', 'red_btn');
				opl.add('Orange Button', 'orange_btn');
				opl.add('Yellow Button', 'yellow_btn');
				opl.add('Green Button', 'green_btn');
				opl.add('Blue Button', 'blue_btn');
				opl.add('[-- big buttons --]', 'bbtncode');
				opl.add('Big Grey Button', 'big_grey_btn');
				opl.add('Big Red Button', 'big_red_btn');
				opl.add('Big Orange Button', 'big_orange_btn');
				opl.add('Big Yellow Button', 'big_yellow_btn');
				opl.add('Big Green Button', 'big_green_btn');
				opl.add('Big Blue Button', 'big_blue_btn');
				opl.add('[-- feature boxes --]', 'featcode');
				opl.add('Feature Box - Blue', 'feat_blue');
				opl.add('Feature Box - Green', 'feat_green');
				opl.add('Feature Box - Red', 'feat_red');
				opl.add('Feature Box - Orange', 'feat_orange');
				opl.add('Feature Box - Grey', 'feat_grey');
				opl.add('[-- popups --]', 'popcode');
				opl.add('PopUp Image', 'pop_image');
				opl.add('PopUp YouTube Video', 'pop_youtube');
				opl.add('PopUp Vimeo Video', 'pop_vimeo');
				opl.add('PopUp Content', 'pop_content');
				opl.add('[-- misc --]', 'concode');
				opl.add('Today\'s Date', 'ez_date');
				opl.add('Countdown', 'ez_countdown');
				opl.add('Tabbed Content', 'tab_content');
				opl.add('Optin Form', 'optin_form');
				opl.add('Viral Download Lock', 'viral_download');
				opl.add('Facebook Content Reveal', 'fb_reveal');
				
                return opl;
			}
			return null;
		},
             
		getInfo : function() {
			return {
				longname : "InstaBuilder Shortcodes",
				author : 'Suzanna Theresia',
				authorurl : 'http://instabuilder.com/',
				infourl : 'http://instabuilder.com/',
				version : "1.0"
			};
		}
	});
	tinymce.PluginManager.add('optinlite', tinymce.plugins.optinlite);
})();