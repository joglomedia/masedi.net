(function() {

    tinymce.create('tinymce.plugins.wpsp_shortcode', {

        init : function(ed, url){
            ed.addButton('wpsp_shortcode', {
				title : '',
				image : url+'/youtube.png',
				onclick : function() {
					idPattern = /(?:(?:[^v]+)+v.)?([^&=]{11})(?=&|$)/;
					var vidId = prompt("YouTube Video", "Enter the id or url for your video");
					var m = idPattern.exec(vidId);
					if (m != null && m != 'undefined')
						ed.execCommand('mceInsertContent', false, '[wpspvideo src=http://www.youtube.com/embed/'+m[1]+' width=300 height=250 autoplay=1]');
				}
			});
        },

        getInfo : function() {
            return {
                longname : 'WP Sales Magix',
                author : 'WP Sales Magix',
                authorurl : 'http://wpsalesmagix.com',
                infourl : '',
                version : "1.0"
            };
        }
    });

    tinymce.PluginManager.add('wpsp_shortcode', tinymce.plugins.wpsp_shortcode);
    
})();
