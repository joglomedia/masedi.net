<?php 
global $wpdb;
$mode = $_REQUEST['mode'];
$page = $_REQUEST['page'];
$pid = $_REQUEST['pid'];
//require_once( 'wpsmagix.php' );
$pObj = new wpsmagix();
$pObj->enqueue_editor();
$baseurl = $_SERVER["PHP_SELF"];
if(isset($_POST['question']) && isset($_POST['ans']))
{		
		
		$question		= $_POST['question'];
		$pollID			= isset($_POST['pid'])?$_POST['pid']:'';
		$answers		= $_POST['ans'];
		$urls 			= $_POST['url'];
		
		if( $answers ) {
			
			$cntAnswers = 0;
			foreach($answers as $key => $answer) {		
				if($answer['answer']){
					++$cntAnswers;
					if(isset($answer['vote'])){
						$vote = $answer['vote'];
					} else {
						$vote = 0;
					}
					
					$pollForDB[$cntAnswers]['answer']	= htmlspecialchars( stripcslashes($answer['answer']), ENT_QUOTES, get_bloginfo('charset') );
					$pollForDB[$cntAnswers]['vote']		= $vote;
					
					$pollForDB[$cntAnswers]['url']	= htmlspecialchars( stripcslashes($urls[$cntAnswers]['urls']), ENT_QUOTES, get_bloginfo('charset') );				
				}				
			}	
			if( $cntAnswers <= 1 ) {
				$error[] = 'Need at least 2 answers';
			}
			
		} else {
			$error[] = 'No answers given';
		}	
		
		$active 		= true;
		$totalvotes 	= 0;
		$time 			= time();
		$pollfordb = serialize($pollForDB);
		if(empty($pollID))
		$wpdb->query("insert into ".$pObj->tablename." set question='$question', answers='$pollfordb', added='$time', active='$active', totalvotes='$totalvotes' ");
		else
		$wpdb->query("update ".$pObj->tablename." set question='$question', answers='$pollfordb', updated='$time' where id=$pollID");			
}
?>
<link rel="Stylesheet" type="text/css" href="<?php echo $pObj->plugin_url;?>css/jPicker-1.1.6.min.css" />
<script src="<?php echo $pObj->plugin_url;?>js/jpicker-1.1.6.min.js" type="text/javascript"></script>
<script type="text/javascript">
var dq =jQuery.noConflict();
    dq(document).ready(function()
      {
        dq.fn.jPicker.defaults.images.clientPath='<?php echo trailingslashit( WP_PLUGIN_URL.'/'.dirname( plugin_basename(__FILE__) ));?>images/';
        var LiveCallbackElement = dq('#Live'),
            LiveCallbackButton = dq('#LiveButton');
        
        
	dq('#bgcolor').jPicker({window:{title:'Background Color', position:
    {
      x: 'screenCenter',
      y: 'bottom', 
    }},color:{active:new dq.jPicker.Color({ahex:'993300ff'})}});
	
	dq('#barcolor').jPicker({window:{title:'Poll Bar Color', position:
    {
      x: 'screenCenter', 
      y: 'bottom', 
    }},color:{active:new dq.jPicker.Color({ahex:'993300ff'})}});
	
	dq('#textcolor').jPicker({window:{title:'Poll Text Color', position:
    {
      x: 'screenCenter', 
      y: 'bottom', 
    }},color:{active:new dq.jPicker.Color({ahex:'993300ff'})}});
	
        
      });
</script>
<div>
	<h2>WP Sales Magix</h2>
    <p><a href="http://wp-salesmagix.com" target="_blank">Plugin Site</a> | <a href="mailto:wpsalesmagix@gmail.com">*Support</a></p>
    <br/>
</div>
<div style="clear:both;"></div>
<div class="wrap">

<style type="text/css">
input[type=button]{
width:auto;	
}
input[type=text]{
	width:400px;
}
input[type=submit]{
	width:150px;
	font:14px/18px Arial bold;
	margin-left:150px;	
}
.small{
	width:100px !important;
}
#wrap label{
	width:150px;
	display:block;
	float:left;
	line-height:16px;
	font-weight:bold;
	
}
#wrap{
	padding-left:10px;
}
</style>

<?php
if(!empty($_POST)) : ?>
	<div id="message" class="updated">
    	<p>Settings saved.</p>
    </div>
<?php
	  endif;  
	  
	  $checked = 'checked="checked"'; $selected = 'selected="selected"';
	  $wpsmagix_general = get_option('wpsmagix_general');
	 
?>
<div class="postbox ">
<div id="wptmlsgbox" class="handlediv" title="Click to toggle" style="float: right;width: 27px;height: 30px;cursor: pointer;"><br></div>
	<h3 class="hndle"  style="cursor:pointer; padding:7px 10px; margin:0;"> GENERAL SETTINGS</h3>
    <div id="wrap">
        <form name="poll-setting" action="" method="post" enctype="multipart/form-data">
        
        	<p>
            	<label style="width:350px;">Please Select this box to make Download Text Blink: </label> 
            	<input type="checkbox" name="wpsmagix_blink" value="1" <?php if($wpsmagix_general['blink']==1)echo "checked";?> />
            </p><br/>        
        	<p>
            	<label style="width:350px;">Enable Back To Query Link on Pages after we Vote: </label>
                <input type="checkbox" name="wpsmagix_bqlink" value="1" <?php if($wpsmagix_general['bqlink'])echo "checked";?> />
            </p><br/>        
        	<p>
            	<label style="width:350px;">Include Shares on Page: </label>
                <input type="checkbox" name="wpsmagix_isShare" value="1" <?php if($wpsmagix_general['isShare'])echo "checked";?>  />
            </p><br/>        
        	<p>
            	<label>Fancybox:</label> 
                <select name="wpsmagix_fancybox">
        			<option value="true" <?php if($wpsmagix_general['fancybox']=='true')echo $selected;?>>True</option>
        			<option value="false" <?php if($wpsmagix_general['fancybox']=='false')echo $selected;?>>False</option>
        		</select>
            </p>
        	<p>
            	<label>Keep Data after Disable: </label>
                <input type="checkbox" name="wpsmagix_keepdata" id="wpsmagix_keepdata" <?php if($wpsmagix_general['keepdata'])echo "checked";?> value="1" />
            </p>        
        	<p>
            	<label>Download Text: </label>
                <input type="text" name="wpsmagix_text" value="<?php echo $wpsmagix_general['html'];?>" />
            </p>
        	<p>
            <div id="jPicker">
              <label>Poll Bg color:</label>        
              <input id="bgcolor" name="bgcolor" type="text" style="width:100px;" value="<?php echo $wpsmagix_general['bgcolor'];?>" />
            </div>
           	</p>
            <p><div id="jPicker">
                  <label>Poll Bar color:</label>        
                  <input id="barcolor" name="barcolor" type="text" style="width:100px;" value="<?php echo $wpsmagix_general['barcolor'];?>" />
               </div>
           	</p>
            <p><div id="jPicker">
                  <label>Poll Result Text color:</label>        
                  <input id="textcolor" name="textcolor" type="text" style="width:100px;" value="<?php echo $wpsmagix_general['textcolor'];?>" />
               </div>
           	</p>
        	<p>
            	<label>Width: </label>
                <input type="text" name="wpsmagix_width" id="wpsmagix_width" class="small" value="<?php echo $wpsmagix_general['width'];?>" />
        	</p>
        	<p>
            	<label>Email Width: </label>
                <input type="text" name="wpsmagix_emailwidth" id="wpsmagix_emailwidth" class="small" value="<?php echo $wpsmagix_general['emailwidth'];?>" />
            </p>
        	<p>
            	<label>Email Height: </label>
                <input type="text" name="wpsmagix_emailheight" id="wpsmagix_emailheight" class="small" value="<?php echo $wpsmagix_general['emailheight'];?>" />
            </p> 
        	<p>
            	<label>Email HTML: </label>
                <textarea name="wpsmagix_email" id="wpsmagix_email"  cols="80" rows="15" ><?php if($wpsmagix_general['email'])echo stripslashes(stripslashes($wpsmagix_general['email']));?></textarea>
            </p>
        <p></p>
        <p><input type="submit" name="btngeneral" onclick="sp_content_save();"  value="Save" /></p>
        </form>
    <div style="margin:40px 20px;">
    <a href="<?php echo $baseurl;?>?page=wpsmagix-add"><span style="cursor:pointer; text-decoration:none; padding:7px 10px; font-size:20px;">Create Poll &raquo;</span></a>
    </div>
    </div>

</div>
