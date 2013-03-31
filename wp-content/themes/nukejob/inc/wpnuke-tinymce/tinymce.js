(function() {
	// Get the URL to this script file
	var scripts = document.getElementsByTagName( "script"),
	src = scripts[scripts.length-1].src;
	if ( scripts.length ) {
		for ( i in scripts ) {
			var scriptSrc = '';
			if ( typeof scripts[i].src != 'undefined' ) { scriptSrc = scripts[i].src; }
			var txt = scriptSrc.search( 'wpnuke-tinymce' );
			if ( txt != -1 ) {
				src = scripts[i].src;
			}
		}
	}
	var template_url = src.split( '/includes/' );
	
	// Creates a new tinyMCE plugin
	tinymce.create('tinymce.plugins.wpnukeshortcodes', {
        createControl: function(n, cm) {
            switch (n) {
                case 'wpnukeshortcodes':
					var c = cm.createMenuButton('wpnukeshortcodes', {
							title : 'WpNuke Shortcodes',
							image : template_url[0] + '/images/shortcode-icon.png',
							icons : false
					});
					c.onRenderMenu.add(function(c, m) {
						var sub;
						m.add({title : 'Horizontal Rule', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[hr]');
						}});
						m.add({title : 'Back to Top', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[back_top]');
						}});
						m.add({title : 'Text Highlight', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[highlight color="" text_bg_color=""]' + tinyMCE.activeEditor.selection.getContent() + '[/highlight]');
						}});
						m.add({title : 'Dropcap', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[dropcap]' + tinyMCE.activeEditor.selection.getContent() + '[/dropcap]');
						}});
						m.add({title : 'Image without Frame', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[img_no_frame]' + tinyMCE.activeEditor.selection.getContent() + '[/img_no_frame]');
						}});
						m.add({title : 'Toggle Content', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[toggle title="Toggle Title"]' + 'Insert your text here' + '[/toggle]');
						}});
						m.add({title : 'Tab Content', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[tabs]' + '[tab title="Tab 1"]' + 'Tab 1 content goes here.' + '[/tab]' + '[tab title="Tab 2"]' + 'Tab 2 content goes here.' + '[/tab]' + '[tab title="Tab 3"]' + 'Tab 3 content goes here.' + '[/tab]' + '[/tabs]');
						}});
						m.add({title : 'Google Map', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[googlemap width="456" height="300" src="URL"]');
						}});
						m.add({title : 'Contact Form', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[contact_form email="me@mysite.com"]');
						}});
						sub = m.addMenu({title : 'Icon Box'});
						sub.add({title : 'Magnifying Glass', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="magnifying-glass.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Trashcan', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="trashcan.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Presentation', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="presentation.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Download', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="download.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Upload', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="upload.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Flag', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="flag.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Cup', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="cup.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Home', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="home.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Book', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="book.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Link', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="link.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Mail', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="mail.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Help', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="help.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'RSS', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="rss.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Apartment', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="apartment.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Companies', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="companies.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Vault', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="vault.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Archive', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="archive.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'File Cabinet', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="file-cabinet.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Post Card', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="post-card.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Alert', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="alert.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Bell', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="bell.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Robot', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="robot.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Globe', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="globe.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Chemical', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="chemical.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Light Bulb', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="light-bulb.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Cloud', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="cloud.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Paperclip', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="paperclip.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Footprints', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="footprints.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Folder', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="folder.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Leaf', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="leaf.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Locked', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="locked.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Unlocked', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="unlocked.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Tags', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="tags.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Windows', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="windows.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Mac OS', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="mac-os.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Linux', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="linux.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Applications', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="applications.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Write', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="write.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Traffic Light', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="traffic-light.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Glass', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="glass.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Plate', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="plate.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Key', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="key.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Acces Denied', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="acces-denied.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Balloons', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="balloons.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Airplane', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="airplane.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Truck', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="truck.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Car', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="car.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Info', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="info.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Alarm Clock', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="alarm-clock.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Clock', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="clock.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Calendar', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="calendar.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Cog', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="cog.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Settings', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="settings.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Images', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="images.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Sound', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="sound.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Megaphone', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="megaphone.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Film', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="film.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Headphones', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="headphones.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Microphone', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="microphone.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Clapboard', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="clapboard.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Printer', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="printer.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Television', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="television.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Computer', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="computer.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Laptop', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="laptop.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Camera', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="camera.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Film Camera', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="film-camera.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'WordPress', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="wordpress.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Suitcase', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="suitcase.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'PayPal', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="paypal.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Visa', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="visa.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Mastercard', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="mastercard.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Money', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="money.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Price Tags', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="price-tags.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Piggy Bank', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="piggy-bank.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Shopping Basket', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="shopping-basket.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Shopping Cart', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="shopping-cart.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Digg', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="digg.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Delicious', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="delicious.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Twitter', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="twitter.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Tumblr', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="tumblr.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Dribbble', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="dribbble.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'YouTube', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="youtube.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Vimeo', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="vimeo.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Skype', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="skype.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Facebook', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="facebook.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'iChat', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="ichat.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Male Contour', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="male-contour.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Female Contour', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="female-contour.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'User', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="user.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Group', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="group.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Speech Bubbles', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="speech-bubbles.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Phone', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="phone.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Paint Brush', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="paint-brush.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Clipboard', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="clipboard.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Tools', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="tools.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Graph', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="graph.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub.add({title : 'Chart', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[iconbox title="The Title" icon="chart.png"]' + 'Insert your text here' + '[/iconbox]');
						}});
						sub = m.addMenu({title : 'Quote'});
						sub.add({title : 'Left Quote', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[left_quote]' + tinyMCE.activeEditor.selection.getContent() + '[/left_quote]');
						}});
						sub.add({title : 'Right Quote', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[right_quote]' + tinyMCE.activeEditor.selection.getContent() + '[/right_quote]');
						}});
						sub = m.addMenu({title : 'Lists'});
						sub.add({title : 'Check List', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[check_list]' + '<ul><li>Item 1</li><li>Item 2</li><li>Item 3</li></ul>' + '[/check_list]');
						}});
						sub.add({title : 'Check List with Line', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[check_list_line]' + '<ul><li>Item 1</li><li>Item 2</li><li>Item 3</li></ul>' + '[/check_list_line]');
						}});
						sub.add({title : 'Arrow List', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[arrow_list]' + '<ul><li>Item 1</li><li>Item 2</li><li>Item 3</li></ul>' + '[/arrow_list]');
						}});
						sub.add({title : 'Arrow List with Line', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[arrow_list_line]' + '<ul><li>Item 1</li><li>Item 2</li><li>Item 3</li></ul>' + '[/arrow_list_line]');
						}});
						sub = m.addMenu({title : 'Notification'});
						sub.add({title : 'Info', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[info_box]' + tinyMCE.activeEditor.selection.getContent() + '[/info_box]');
						}});
						sub.add({title : 'Warning', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[warning_box]' + tinyMCE.activeEditor.selection.getContent() + '[/warning_box]');
						}});
						sub.add({title : 'Success', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[success_box]' + tinyMCE.activeEditor.selection.getContent() + '[/success_box]');
						}});
						sub.add({title : 'Error', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[error_box]' + tinyMCE.activeEditor.selection.getContent() + '[/error_box]');
						}});
						sub = m.addMenu({title : 'Buttons'});
						sub.add({title : 'Black', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[button color="black" size="medium" link="#"]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
						}});
						sub.add({title : 'Silver', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[button color="silver" size="medium" link="#"]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
						}});
						sub.add({title : 'Red', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[button color="red" size="medium" link="#"]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
						}});
						sub.add({title : 'Orange', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[button color="orange" size="medium" link="#"]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
						}});
						sub.add({title : 'Green', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[button color="green" size="medium" link="#"]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
						}});
						sub.add({title : 'Blue', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[button color="blue" size="medium" link="#"]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
						}});
						sub.add({title : 'Aqua', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[button color="aqua" size="medium" link="#"]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
						}});
						sub.add({title : 'Teal', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[button color="teal" size="medium" link="#"]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
						}});
						sub.add({title : 'Purple', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[button color="purple" size="medium" link="#"]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
						}});
						sub.add({title : 'Pink', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[button color="pink" size="medium" link="#"]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
						}});
						sub.add({title : 'Gray', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[button color="gray" size="medium" link="#"]' + tinyMCE.activeEditor.selection.getContent() + '[/button]');
						}});
						sub = m.addMenu({title : 'Columns'});
						sub.add({title : 'One Half', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[one_half]' + tinyMCE.activeEditor.selection.getContent() + '[/one_half]');
						}});
						sub.add({title : 'One Half Last', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[one_half_last]' + tinyMCE.activeEditor.selection.getContent() + '[/one_half_last]');
						}});
						sub.add({title : 'One Third', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[one_third]' + tinyMCE.activeEditor.selection.getContent() + '[/one_third]');
						}});
						sub.add({title : 'One Third Last', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[one_third_last]' + tinyMCE.activeEditor.selection.getContent() + '[/one_third_last]');
						}});
						sub.add({title : 'Two Third', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[two_third]' + tinyMCE.activeEditor.selection.getContent() + '[/two_third]');
						}});
						sub.add({title : 'Two Third Last', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[two_third_last]' + tinyMCE.activeEditor.selection.getContent() + '[/two_third_last]');
						}});
						sub.add({title : 'One Fourth', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[one_fourth]' + tinyMCE.activeEditor.selection.getContent() + '[/one_fourth]');
						}});
						sub.add({title : 'One Fourth Last', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[one_fourth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/one_fourth_last]');
						}});
						sub.add({title : 'Three Fourth', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[three_fourth]' + tinyMCE.activeEditor.selection.getContent() + '[/three_fourth]');
						}});
						sub.add({title : 'Three Fourth Last', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[three_fourth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/three_fourth_last]');
						}});
						sub.add({title : 'One Fifth', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[one_fifth]' + tinyMCE.activeEditor.selection.getContent() + '[/one_fifth]');
						}});
						sub.add({title : 'One Fifth Last', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[one_fifth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/one_fifth_last]');
						}});
						sub.add({title : 'Two Fifth', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[two_fifth]' + tinyMCE.activeEditor.selection.getContent() + '[/two_fifth]');
						}});
						sub.add({title : 'Two Fifth Last', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[two_fifth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/two_fifth_last]');
						}});
						sub.add({title : 'Three Fifth', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[three_fifth]' + tinyMCE.activeEditor.selection.getContent() + '[/three_fifth]');
						}});
						sub.add({title : 'Three Fifth Last', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[three_fifth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/three_fifth_last]');
						}});
						sub.add({title : 'Four Fifth', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[four_fifth]' + tinyMCE.activeEditor.selection.getContent() + '[/four_fifth]');
						}});
						sub.add({title : 'Four Fifth Last', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[four_fifth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/four_fifth_last]');
						}});
						sub.add({title : 'One Sixth', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[one_sixth]' + tinyMCE.activeEditor.selection.getContent() + '[/one_sixth]');
						}});
						sub.add({title : 'One Sixth Last', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[one_sixth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/one_sixth_last]');
						}});
						sub.add({title : 'Five Sixth', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[five_sixth]' + tinyMCE.activeEditor.selection.getContent() + '[/five_sixth]');
						}});
						sub.add({title : 'Five Sixth Last', onclick : function() {
							tinyMCE.activeEditor.selection.setContent('[five_sixth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/five_sixth_last]');
						}});
					});
					// Return the new menu button instance
					return c;
            }
            return null;
        }
    });
	tinymce.PluginManager.add('wpnukeshortcodes', tinymce.plugins.wpnukeshortcodes);
})();