<?php 
global $wpdb;
$mode = $_REQUEST['mode'];
$page = $_REQUEST['page'];
$pid = $_REQUEST['pid'];
//require_once( 'wpsmagix.php' );
$pObj = new wpsmagix();
$pObj->enqueue_editor();

if($mode=='delete'){
	$wpdb->query("delete from $pObj->tablename where id=$pid");
}
if(isset($_POST['question']) && isset($_POST['ans']))
{	
		$question		= $_POST['question'];
		$type 			= $_POST['wpsmagixtype'];
		
		$imgType		= $_POST['wpsmagiximgType'];
		$pollID			= isset($_POST['pid'])?$_POST['pid']:'';
		$answers		= $_POST['ans'];
		$urls 			= $_POST['url'];
		$durls 			= $_POST['durl'];
		$lcontents		= $_POST['lcontent'];
		$initialVotes	=  $_POST['initialVote'];
		$messages	=  $_POST['message'];
		$totalvotes = 0;
		
		if( $answers ) {			
			$cntAnswers = 0;
						
			// Sort the data out
			foreach($answers as $key => $answer) {
									
				if($answer['answer']){
					// We have an answer so build that back into the array with new values
					++$cntAnswers;
					
					if(isset($answer['vote'])){
						$vote = $answer['vote'];
					} else {
						$vote = 0;
					}					
					$pollForDB[$cntAnswers]['answer']	= htmlspecialchars( stripcslashes($answer['answer']), ENT_QUOTES, get_bloginfo('charset') );
					$pollForDB[$cntAnswers]['vote']		= $vote;
					$pollForDB[$cntAnswers]['message']		= htmlspecialchars( stripcslashes($answer['message']), ENT_QUOTES, get_bloginfo('charset') );
					
					$pollForDB[$cntAnswers]['url']	= htmlspecialchars( stripcslashes($urls[$cntAnswers]['urls']), ENT_QUOTES, get_bloginfo('charset') );
					$pollForDB[$cntAnswers]['durl']	= htmlspecialchars( stripcslashes($durls[$cntAnswers]['durls']), ENT_QUOTES, get_bloginfo('charset') );
					$pollForDB[$cntAnswers]['lcontent']	= htmlspecialchars( stripcslashes($lcontents[$cntAnswers]['lcontents']), ENT_QUOTES, get_bloginfo('charset') );
									
				}
			$totalvotes		=	$totalvotes+$answer['vote'];		
			}		
			
			if( $cntAnswers <= 1 ) {
				$error[] = 'Need at least 2 answers';
			}
			
		} else {
			$error[] = 'No answers given';
		}	
		
		$active 		= true;
		$time 			= time();
		
		$pollfordb = serialize($pollForDB);
		if(empty($pollID))
		$wpdb->query("insert into ".$pObj->tablename." set question='$question', answers='$pollfordb', added='$time', active='$active', totalvotes='$totalvotes', type=$type, imgType=$imgType");
		else
		$wpdb->query("update ".$pObj->tablename." set question='$question', answers='$pollfordb', totalvotes='$totalvotes', updated='$time', type=$type, imgType=$imgType where id=$pollID");
}
?>
<div style="width:1000px;float:left;">
	<h1>WP Sales Magix</h1>
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
	width:300px;
}
#createPoll label{
	clear:both;
	width:200px;
	display:block;
	float:left;
	line-height:25px;
	font-weight:bold;	
}
.answer{
	font-size:18px;
	font-weight:bold;
	cursor:pointer;
	padding:7px 10px;
	margin:0;
	}
.hidden, .js .closed .wpsmGethtml, .js .hide-if-js, .no-js .hide-if-no-js {
display: none;
}
.hidden, .js .closed .wpsmGetetemplate, .js .hide-if-js, .no-js .hide-if-no-js {
display: none;
}
.hidden, .js .closed .wpsmGetfbhtml, .js .hide-if-js, .no-js .hide-if-no-js {
display: none;
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
?>
<?php 
$result = $wpdb->get_results("select * from ".$pObj->tablename);
?>
<table class="widefat fixed comments">
    <thead>
    	<tr>
    		<th width="5%">S.No.</th>
            <th width="30%">Question</th>
    		<th width="20%">Shortcode</th>
    		<th width="20%">Date</th>
            <th width="15%">Action</th>
    	</tr>
    </thead>
    
    <tbody>
    
    <?php if( $result ) { ?>
 
            <?php
            $count = 1;
            $class = '';
            foreach( $result as $entry ) {
               ?>
 
            <tr<?php echo $class; ?>>
                <td><?php echo $count; ?></td>
                <td><?php echo $entry -> question; ?></td>
                <td><?php echo "[wpsmagix id='".$entry -> id."']"; ?></td>
                <td><?php echo date('Y M d G:i:s',$entry -> added); ?></td>
                <td><a href="<?php echo $_SERVER["PHP_SELF"]?>?page=<?php echo $page;?>&pid=<?php echo $entry->id;?>&mode=edit">Edit</a> | <a href="<?php echo $_SERVER["PHP_SELF"]?>?page=<?php echo $page;?>&pid=<?php echo $entry->id;?>&mode=delete" onclick="return confirm('Template will be permanently deleted. Are you sure you want to delete?')">Delete</a></td>
            </tr>
 
            <?php
                $count++;
            }
            ?>
 
        <?php } else { ?>
        <tr>
            <td colspan="3">No Polls yet</td>
        </tr>
    <?php } ?>
    </tbody>
    
    <tfoot>
        <tr>
    		<th width="5%">S.No.</th>
            <th width="30%">Question</th>
    		<th width="20%">Shortcode</th>
    		<th width="20%">Date</th>
            <th width="15%">Action</th>
    	</tr>
    </tfoot>
    
 </table>
<br/><br/>

	
<form method="post" action="" id="createPoll">
<?php 
if($mode=='edit' && !empty($_REQUEST['pid']))
{
	  $res = $wpdb->get_row("select * from $pObj->tablename where id=$pid");
	  $answers = unserialize($res->answers);	
	  echo '<input type="hidden" name="pid" value="'.$pid.'" />';	
}?>
	<h2> <?php if($mode=='edit')echo 'Edit Poll &raquo;';else echo 'Add Poll &raquo;';?></h2>
    <p>
    	<h2>Question</h2>
    	<input type="text" name="question" value="<?php echo !empty($pid)?$res->question:'';?>" />
    </p>
    <p>
    	<label style="line-height:26px;">Type:</label>
        <select name="wpsmagixtype" id="wpsmagixtype" onchange="if(this.value==1){
        document.getElementById('wpsmagix_imgType').style.display='block'; 
        jQuery('.nameChange').html('Reviews(Max. upto 5)');       
        }else 
        {document.getElementById('wpsmagix_imgType').style.display='none';
        jQuery('.nameChange').html('Votes');}">
        	<option value="0" <?php if($res->type==0)echo "selected";?>>Poll</option>
            <option value="1" <?php if($res->type==1)echo "selected";?>>Review</option>
        </select>
    </p>
    <div id="wpsmagix_imgType" <?php if(!$res->type)echo 'style="display:none;"';?>>
    <label style="line-height:26px;">Select Image for Review:</label>
    	<select name="wpsmagiximgType" id="polltype">
            <option value="0" <?php if($res->imgType==0)echo "selected";?>>Crown</option>
            <option value="1" <?php if($res->imgType==1)echo "selected";?>>Star</option>
            <option value="2" <?php if($res->imgType==2)echo "selected";?>>Diamond</option>
            <option value="3" <?php if($res->imgType==3)echo "selected";?>>Smiley</option>
        </select>
     </div>
    <p>&nbsp;</p>
    <script type="text/javascript">
	function anstoggle(value){
		//jQuery('.ans').hide();
		//jQuery('#ans'+value).show();	
		jQuery('#ans'+value).toggle();	
	}	
	</script>
    <?php if(!empty($_REQUEST['pid'])){?>
    <div class="postbox closed ">
<div class="handlediv" title="Click to toggle" style="float: right;width: 27px;height: 30px;cursor: pointer;background:transparent url(<?php echo $pObj->plugin_image_url;?>arrows.png) no-repeat 6px 7px;"><br></div>
	<h3 class="hndle"  style="cursor:pointer; padding:7px 10px; margin-top:0px;">Get HTML</h3>
    <div class="wpsmGethtml" id="wpsmGethtml" style="padding:0 10px 10px;">
    <textarea id="gethtml" onclick="document.getElementById('gethtml').focus();
    document.getElementById('gethtml').select();" rows="10" style="width:100%"><?php echo $pObj->wpsmagixgethtml($_REQUEST['pid']);?></textarea>
    </div>
    </div>
    <div class="postbox closed ">
<div class="handlediv" title="Click to toggle" style="float: right;width: 27px;height: 30px;cursor: pointer;background:transparent url(<?php echo $pObj->plugin_image_url;?>arrows.png) no-repeat 6px 7px;"><br></div>
	<h3 class="hndle"  style="cursor:pointer; padding:7px 10px; margin-top:0px;">Get HTML for Facebook pages</h3>
    <div class="wpsmGetfbhtml" id="wpsmGetfbhtml" style="padding:0 10px 10px;">
    <textarea id="getfbhtml" onclick="document.getElementById('getfbhtml').focus();
    document.getElementById('getfbhtml').select();" rows="10" style="width:100%"><?php echo $pObj->wpsmagixgetfbhtml($_REQUEST['pid']);?></textarea>
    </div>
    </div>
    <div class="postbox closed ">
<div class="handlediv" title="Click to toggle" style="float: right;width: 27px;height: 30px;cursor: pointer;background:transparent url(<?php echo $pObj->plugin_image_url;?>arrows.png) no-repeat 6px 7px;"><br></div>
	<h3 class="hndle"  style="cursor:pointer; padding:7px 10px; margin-top:0px;">Get Simple Email Template</h3>
    <div class="wpsmGetetemplate" id="wpsmGetetemplate" style="padding:0 10px 10px;">
    
    <textarea id="getemailtemplate" onclick="document.getElementById('getemailtemplate').focus();
    document.getElementById('getemailtemplate').select();" rows="10" style="width:100%"><?php echo $pObj->wpsmagix_getemailtemplates($_REQUEST['pid']);?></textarea>
    </div></div>
	<?php }?>
    	<h2>Answers</h2>       
        
        <?php for($i=1; $i<=10; $i++){?>
           <div class="postbox">
           <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td>
                <div id="gsbox" class="handlediv" title="Click to toggle" style="float: right;width: 27px;height: 30px;cursor: pointer;"  onclick="anstoggle(<?php echo $i;?>)"><br></div>
                 <h3 class="answer hndle" onclick="anstoggle(<?php echo $i;?>)">Answer <?php echo $i;?> &raquo;</h3>
                 
                 </td>
            </tr> 
            <tr>
            	<td>
           		   <table cellpadding="0" cellspacing="0" width="100%" border="0" id="ans<?php echo $i;?>" class="ans" <?php echo (!empty($pid) && isset($answers[$i]['answer']))?'style=" padding:20px;"':'style="display:none; padding:20px;"';?>>
                        <tr>
                            <td colspan="3">
                            	<label>Answer:</label> 
                                <input type="text" name="ans[<?php echo $i;?>][answer]" value="<?php echo (!empty($pid) && isset($answers[$i]['answer']))?$answers[$i]['answer']:'';?>" /> &nbsp; <strong> 
								 <?php if($res->type)echo "<span class='nameChange'>Reviews(Max. upto 5)</span>";else echo "<span class='nameChange'>Votes</votes>";?>: </strong> <input type="text" name="ans[<?php echo $i;?>][vote]"  value="<?php echo (!empty($pid) && isset($answers[$i]['vote']))?$answers[$i]['vote']:'';?>" style="width:50px;" <?php if($res->type){?>onchange="if(this.value>5){alert('Max value: 5');this.value=5;}"<?php }?> />
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3"><?php $curl = (!empty($pid) && isset($answers[$i]['url']))?$answers[$i]['url']:'';?><label>URL:</label> <input type="text" name="url[<?php echo $i;?>][urls]" value="<?php echo (!empty($pid) && isset($answers[$i]['url']))?$answers[$i]['url']:'';?>" /> &nbsp; <strong><?php if($pid){?>Created URL:</strong> <input type="text" name=""  value="<?php if($pid)echo get_bloginfo('url').'/?wpsmid='.$pid.'&key='.$i?>" /><?php }?>
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3">&nbsp;</td>	
                        </tr>
                        <tr>
                            <td colspan="3"><label>Download URL: </label> <input type="text" name="durl[<?php echo $i;?>][durls]" value="<?php echo (!empty($pid) && isset($answers[$i]['durl']))?$answers[$i]['durl']:'';?>" />
                            </td>
                        </tr>
                   
                        <tr>
                        	<td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3"><label>Custom Message for Shares:</label> <input type="text" name="ans[<?php echo $i;?>][message]" value="<?php echo (!empty($pid) && isset($answers[$i]['message']))?$answers[$i]['message']:'';?>" /> 
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="3">&nbsp;</td>
                        </tr>
						<style type="text/css">
					   		textarea{width: 948px;}
					   </style>
                        <tr>
                            <td colspan="3">
                            
                                <label>Left Content:</label><div id="poststuff" style="clear:both;">
                                <?php $lcontent =  (!empty($pid) && isset($answers[$i]['lcontent']))?$answers[$i]['lcontent']:'';
								$lcontent = empty($lcontent)?'<img src="'.$pObj->plugin_image_url.'one.png" style="border:none;display:none;">':$lcontent;
								?>
                                    <?php the_editor(stripslashes(html_entity_decode($lcontent)),'lcontent['.$i.'][lcontents]','lcontent['.$i.'][lcontents]',true,$i); ?>                    
                            </div>
                            </td>
                        </tr>
            		</table>
				</td>
            </tr>
            
             </table>
             </div> 
        <?php }?>
          
      
   
    <p><input type="submit" name="add-poll" value="<?php if($mode=='edit')echo 'Edit Poll';else echo 'Create Poll';?>"  />
</form>
<div style="clear:both;"></div>