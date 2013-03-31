<?php

// look up for the path
require_once( dirname( dirname(__FILE__) ) .'/syntax-highlighter-compress-config.php');

global $wpdb;

// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') ) 
	wp_die(__("You are not allowed to be here"));
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Syntax Highlighter ComPress</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript">
	function init() {
		tinyMCEPopup.resizeToInnerSize();
	}
	
	function insertShcLink() {
		
		var langu;
		var codetext;
		
		var shc = document.getElementById('shc_panel');
		
		// who is active ?
		if (shc.className.indexOf('current') != -1) {
			var shcla = document.getElementById('shc_lang').value;			
			var shcid = document.getElementById('shc_code').value.replace(/</g,'&lt;').replace(/\n/g,'<br>');
				
			if (shcid != '' )
				codetext = "<pre class=\"brush:" + shcla + "\">" + shcid + "</pre>";
			else
				tinyMCEPopup.close();
		}
	
		
		if(window.tinyMCE) {
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, codetext);
			//Peforms a clean up of the current editor HTML. 
			//tinyMCEPopup.editor.execCommand('mceCleanup');
			//Repaints the editor. Sometimes the browser has graphic glitches. 
			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		
		return;
	}
	</script>
	<base target="_self" />
</head>
<body id="advimage" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';document.getElementById('shc_code').focus();" style="display: none">
<!-- <form onsubmit="insertLink();return false;" action="#"> -->
	<form name="shc_form" action="#">
	<div class="tabs">
		<ul>
			<li id="shc_tab" class="current"><span><a href="javascript:mcTabs.displayTab('shc_tab','shc_panel');" onmousedown="return false;"><?php _e("Syntax Highlighter ComPress", 'SHC'); ?></a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper">
		<!-- shc panel -->
		<div id="shc_panel" class="panel current">
		<br />
		<table border="0" cellpadding="4" cellspacing="0">
         <tr>
            <td nowrap="nowrap">
            <label for="shc_lang"><?php _e("Language:", 'SHC'); ?></label><br />
            <select name="shc_lang" id="shc_lang">
              <option value="applescript">AppleScript</option>
              <option value="as3">ActionScript3</option>
              <option value="shell">Bash/shell</option>
              <option value="csharp">C#</option>
              <option value="cf">Coldfusion</option>
              <option value="cpp">C++</option>
              <option value="css">CSS</option>
              <option value="delpi">Delphi</option>
              <option value="diff">Diff</option>
              <option value="groovy">Groovy</option>
              <option value="erl">Erlang</option>
              <option value="js">JavaScript</option>
              <option value="java">Java</option>
              <option value="jfx">JavaFX</option>
              <option value="perl">Perl</option>
              <option value="php">PHP</option>
              <option value="plain">Plain Text</option>
              <option value="py">Python</option>
              <option value="ruby">Ruby</option>
              <option value="scala">Scala</option>
              <option value="sql">SQL</option>
              <option value="vb">Visual Basic</option>
              <option value="xml">XML</option>              
            </select><br /><br />
            <label for="shc_code"><?php _e("Code:", 'SHC'); ?></label><br />
            <textarea id="shc_code" rows="18" name="shc_code" style="width: 300px" /></textarea>
            </td>
          </tr>
          
        </table>
		</div>
		<!-- end shc panel -->
	</div>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="submit" id="insert" name="insert" value="<?php _e("Insert", 'SHC'); ?>" onclick="insertShcLink();" />
		</div>

		<div style="float: right">
			<input type="button" id="cancel" name="cancel" value="<?php _e("Cancel", 'SHC'); ?>" onclick="tinyMCEPopup.close();" />
		</div>
	</div>
</form>
</body>
</html>
<?php

?>