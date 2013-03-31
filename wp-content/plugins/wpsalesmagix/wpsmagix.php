<?php
/*
Plugin Name: WP Sales Magix
Plugin URI: http://wpsalesmagix.com
Description: WP Sales Poll advance polling plugin.
Author: WP Sales Magix
Version: 1.0
Author URI: http://wpsalesmagix.com
*/

global $wp_version;

$exit_msg = 'WP Sales Magix has been tested and implemented only on WP 2.0 and higher. To ensure usability <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>';

if(version_compare($wp_version, "2.0", "<"))
	echo $exit_msg;
	
require_once('wpsalesmagix.php');
$wpspObj = new wpsmagix();
if (isset($wpspObj))
{
	register_activation_hook( __FILE__, array($wpspObj,	'install') );
	register_deactivation_hook( __FILE__, array($wpspObj,	'deactivate') );
}

add_filter('query_vars', 'wpsp_queryvars' );

function wpsp_queryvars( $qvars )
{
$qvars[] = 'wpsmid';
return $qvars;
}

if($_REQUEST['wpsmid'])
{
	$result=$wpdb->get_row("select * from $wpspObj->tablename WHERE id = '$_REQUEST[wpsmid]'");
	
	$ans = unserialize($result->answers);
	
	foreach($ans as $key=>$answer)
	{
		if($key == $_REQUEST['key']){
			if(!$result->type)
			$answer['vote']=$answer['vote']+1;
		}
		$ans[$key] = $answer;
	}
	$answers  =serialize($ans);
	$totalvotes = $result->totalvotes + 1;
	if(!$result->type)
	$wpdb->query("update $wpspObj->tablename set answers='$answers',totalvotes=$totalvotes where id = '$_REQUEST[wpsmid]'");
	
	?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:title" content="<?php echo $ans[$_REQUEST['key']]['message']." | ";?>WP Sales Magix" />
<title><?php echo $ans[$_REQUEST['key']]['message']." | ";?>WP Sales Magix </title>   
<script type="text/javascript" src="<?php echo $wpspObj->plugin_url;?>js/jquery.js"></script> 
<script type="text/javascript" src="<?php echo $wpspObj->plugin_url;?>fancybox/jquery.fancybox-1.3.1.pack.js"></script> 
<?php $wpsmagix_general = get_option('wpsmagix_general');
if($wpsmagix_general['blink']==1){?>
<script type="text/javascript">
	var refreshing = setInterval(function(){
		var array=new Array('#1c54f2','#eb12de','#000','#cc0000','#13ab21');
		var choose = array[Math.floor(Math.random() * array.length)];
		jQuery("#blink").css('color',choose);
	},500);
</script>
<?php }?>
<link rel="stylesheet" href="<?php echo $wpspObj->plugin_url;?>fancybox/jquery.fancybox-1.3.1.css" type="text/css" media="screen" />   
<style type="text/css">
	body { margin: 0; padding: 0; overflow: hidden;font-family:Arial, Helvetica, sans-serif;color :#<?php echo $wpsmagix_general['textcolor'];?>;}
	.clear{ clear:both;}
	#wpsmagix_bg{ width:100%; background:#<?php echo $wpsmagix_general['bgcolor'];?>}
	#wpsmagix_bg h3{margin:5px 0; padding:5px 0;}
	#wpsmagix_bg .innerbg{ width:<?php echo $wpsmagix_general['width'];?>px; margin:0 auto;}
	
	#fancybox-inner{ min-height:200px;}
	#wpsmagix_bg .left{	float:left;	width:30%; margin-right:4%;	/*background:yellow;*/ text-align:left;	padding-left:1%; padding-top:5px;}
	#wpsmagix_bg .middle{ float:left; width:30%; /*background:yellow;*/	margin-right:4% ; text-align:center;}
	#wpsmagix_bg .right{ float:right; width:30%; /*background:yellow;*/ padding-left:1%; padding-top:5px; text-align:left;}
	#wpsmagix_bg a{ text-decoration:none; color:#<?php echo $wpsmagix_general['textcolor'];?>;}
	#wpsmagix_bg a:hover{color:#000;}
	.baseCss{
	 height:30px; width:150px;
}
.ratedCss{
	position: absolute;  
	height: 30px; 
	display: block; 
	text-indent: -9000px; 
	z-index: 1; 
	border: none !important; 
	margin: 0 !important; 
	padding: 0 !important; 
	list-style: none !important; 
	border-image: initial;
}
	ul{ min-width:300px;padding:0 !important; margin:0 !important;}
	ul li{font-size:12px; list-style:none; font-family:Arial, Helvetica, sans-serif; font-weight:bold; color:#<?php echo $wpsmagix_general['textcolor'];?>;}
	
	ul.suHostedBadge{list-style-position:outside;list-style-type:none;color:#000;}
	ul.suHostedBadge li a{color:#000 !important;}
	.wpsmagix_image{ margin-right:10px;	float:left;	cursor: pointer;}
	.wpsmagix_image:hover { margin-top: -10px; }
	.suHostedBadge a{display:block;overflow:hidden;border:0;cursor:pointer;color:#258db1;font-weight:bold;font-family:Arial,Helvetica,sans-serif;font-size:11px;text-decoration:none;line-height:18px}
	.suHostedBadge a.logo{text-indent:-999em}
	.badge1 .suHostedBadge{width:74px;height:18px;}
	.badge1 li{float:left;display:inline}
	.badge1 .suHostedBadge a{background:transparent url(http://cdn.stumble-upon.com/i/badges/badgeRect74x18.png) no-repeat 0 0}
	.badge1 .suHostedBadge a.logo{width:20px;height:18px;background-position:0 0}
	.badge1 .suHostedBadge a.count{width:54px;height:18px;text-align:center;background-position:100% 0}
	.badge2 .suHostedBadge{width:65px;height:18px;z-index:999}
	.badge2 li{float:left;display:inline}
	.badge2 .suHostedBadge a{background:transparent url(http://cdn.stumble-upon.com/i/badges/badgeRound65x18.png) no-repeat 0 0}
	.badge2 .suHostedBadge a.logo{width:18px;height:18px;background-position:0 0}
	.badge2 .suHostedBadge a.count{width:47px;height:18px;text-align:center;background-position:100% 0}
	.badge3 .suHostedBadge{width:65px;height:18px;z-index:999}
	.badge3 li{float:left;display:inline}
	.badge3 .suHostedBadge a{background:transparent url(http://cdn.stumble-upon.com/i/badges/badgeLogo18x18.png) no-repeat 0 0}
	.badge3 .suHostedBadge a.logo{width:18px;height:18px;background-position:0 0}
	.badge3 .suHostedBadge a.count{width:47px;height:18px;text-align:center;background:transparent none}
	.badge4 .suHostedBadge{width:18px;height:18px;z-index:999}
	.badge4 li{float:left;display:inline}
	.badge4 .suHostedBadge a{background:transparent url(http://cdn.stumble-upon.com/i/badges/badgeLogo18x18.png) no-repeat 0 0}
	.badge4 .suHostedBadge a.logo{width:18px;height:18px;background-position:0 0}
	.badge4 .suHostedBadge a.count{width:47px;height:18px;text-align:center;background:transparent none}
	.badge5 .suHostedBadge{width:50px;height:60px;z-index:999}
	.badge5 li{float:none}
	.badge5 .suHostedBadge a{background:transparent url(http://cdn.stumble-upon.com/i/badges/badgeRect50x60.png) no-repeat 0 0}
	.badge5 .suHostedBadge a.logo{width:50px;height:40px;background-position:0 0}
	.badge5 .suHostedBadge a.count{width:50px;height:20px;text-align:center;background-position:0 100%}
	.badge6 .suHostedBadge{width:30px;height:31px;z-index:999}
	.badge6 li{float:left;display:inline}
	.badge6 .suHostedBadge a{background:transparent url(http://cdn.stumble-upon.com/i/badges/badgeLogo30x31.png) no-repeat 0 0}
	.badge6 .suHostedBadge a.logo{width:30px;height:31px;background-position:0 0}
	.badge6 .suHostedBadge a.count{width:47px;height:18px;text-align:center;background:transparent none}
	.badge200 .suHostedBadge,.badge210 .suHostedBadge,.badge300 .suHostedBadge{width:108px;height:20px;z-index:999}
	.badge200 li,.badge210 li,.badge300 li{float:left;display:inline}
	.badge200 .suHostedBadge a,.badge200 .suHostedBadge .rate a span,.badge210 .suHostedBadge a,.badge210 .suHostedBadge .rate a span,.badge300 .suHostedBadge a,.badge300 .suHostedBadge .rate a span{outline:0;background:transparent url(http://cdn.stumble-upon.com/i/badges/badgeCustom.png) no-repeat 0 0}
	.badge300 .suHostedBadge a{font-weight:normal}
	.badge200 .suHostedBadge a.text,.badge210 .suHostedBadge a.text,.badge300 .suHostedBadge a.text{width:60px;height:20px;padding-left:22px;text-align:center;line-height:20px;background-position:0 0}
	.badge200 .suHostedBadge a.text:hover,.badge210 .suHostedBadge a.text:hover,.badge300 .suHostedBadge a.text:hover{background-position:0 -21px}
	.badge200 .suHostedBadge .rate a,.badge210 .suHostedBadge .rate a,.badge300 .suHostedBadge .rate a{width:25px;height:20px;background-position:-82px 0}
	.badge200 .suHostedBadge .rate a:hover,.badge210 .suHostedBadge .rate a:hover,.badge300 .suHostedBadge .rate a:hover{background-position:-82px -21px}
	.badge200 .suHostedBadge .rate a span,.badge210 .suHostedBadge .rate a span,.badge300 .suHostedBadge .rate a span{height:20px;width:22px;display:block;background-position:-115px 0}
	.badge200 .suHostedBadge .rate a.active span,.badge210 .suHostedBadge .rate a.active span,.badge300 .suHostedBadge .rate a.active span{background-position:-115px -21px}
	.badge310 .suHostedBadge{width:128px;height:18px;z-index:999}
	.badge310 li{float:left;display:inline}
	.badge310 .suHostedBadge a.logo{width:20px;height:18px;background:transparent url(http://cdn.stumble-upon.com/i/badges/badgeLogo18x18.png) no-repeat 0 0}
	.badge310 .suHostedBadge a.count{width:47px;height:18px;text-align:center;background:transparent none}
</style> 
<?php
if($wpsmagix_general['fancybox']=='false'){?>
<script type='text/javascript'> 
	function resizeIframe() {
		var viewportwidth;
		var viewportheight;
		
		if (typeof window.innerWidth != 'undefined') {
			viewportwidth = window.innerWidth,
			viewportheight = window.innerHeight-window.document.getElementById('wpsmagix_bg').offsetHeight;
		}
		else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0) {
			viewportwidth = document.documentElement.clientWidth,
			viewportheight = document.documentElement.clientHeight
		} 
		else {
			viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
			viewportheight = document.getElementsByTagName('body')[0].clientHeight
		 }
		
		if(document.getElementById("iframe")) {
			document.getElementById("iframe").style.height=parseInt(viewportheight) + "px";
		}
		else
			setTimeout("resizeIframe();", 50);
	}	
	window.onresize = resizeIframe; 		
</script>
<?php }else{?>
<script type='text/javascript'> 
	function resizeIframe() {
		var viewportwidth;
		var viewportheight;
		if (typeof window.innerWidth != 'undefined') {
			viewportwidth = window.innerWidth,
			viewportheight = window.innerHeight;
		}
		else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0) {
			viewportwidth = document.documentElement.clientWidth,
			viewportheight = document.documentElement.clientHeight
		} 
		else {
			viewportwidth = document.getElementsByTagName('body')[0].clientWidth,
			viewportheight = document.getElementsByTagName('body')[0].clientHeight
		 }
		
		if(document.getElementById("iframe")) {
			document.getElementById("iframe").style.height=parseInt(viewportheight) + "px";
		}
		else
			setTimeout("resizeIframe();", 50);
	}
	window.onresize = resizeIframe; 		
</script> 
<?php }?>
</head>    
<body onload='resizeIframe()'> 
	<div style="display:none;"><?php echo stripslashes($ans[$_REQUEST['key']]['message']);?></div>
<?php
	if($wpsmagix_general['fancybox']=='false'){
?>
    <div id="wpsmagix_bg">
        <div class="innerbg">        
        	<div class="left">
				<?php echo apply_filters('the_content',html_entity_decode(stripslashes($ans[$_REQUEST['key']]['lcontent'])));?>
                <div class="clear"></div>
            </div>
        	<div class="middle">
            	<h3 class="wpsmagix_text">
                	<a href="<?php echo $ans[$_REQUEST['key']]['durl'];?>" target="_blank" id="blink"><?php echo $wpsmagix_general['html'];?></a>
                </h3>
        		<?php 
					if($wpsmagix_general['isShare']){
				?>
        
                <div>
                <div style="width:165px; margin:0 auto;">
                
                    <script type="text/javascript">
                      (function() {
                        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                        po.src = 'https://apis.google.com/js/plusone.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                      })();
                    </script>
                <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
                <script type="text/javascript">
                function openPopup(element, w, h) {
                         
                        var width  = 575,
                            height = 400,
                            left   = (jQuery(window).width()  - width)  / 2,
                            top    = (jQuery(window).height() - height) / 2,
                            url    = element.href;
                            
                            if(w != 0)
                                width = w;
                            if(h != 0)
                                height = h;	
                                
                            var opts   = 'status=1' +
                                     ',width='  + width  +
                                     ',height=' + height +
                                     ',top='    + top    +
                                     ',left='   + left;
                                     
                        
                        
                        window.open(url, 'Share', opts);
                        "  . $closeonclick . "
                        return false;
                    }
                    </script>
                <a href="<?php echo $wpspObj->plugin_url;?>email.php" onClick="return openPopup(this, <?php echo $wpsmagix_general['emailwidth'].', '. $wpsmagix_general['emailheight'];?>);"><img class="wpsmagix_image" src="<?php echo $wpspObj->plugin_image_url;?>email.png"  /></a>
                    
                    <a href="http://www.facebook.com/sharer.php?u=<?php echo $wpspObj->curPageURL();?>&t=<?php echo $ans[$_REQUEST['key']]['message'];?>" onClick="return openPopup(this,500,350);"><img class="wpsmagix_image" src="<?php echo $wpspObj->plugin_image_url;?>facebook.png" /></a>
                    
                    <a href="http://twitter.com/share?url=<?php echo urlencode($wpspObj->curPageURL());?>&text=<?php echo $ans[$_REQUEST['key']]['message'];?>" onClick="return openPopup(this,500,350);"><img style="margin-right:0" class="wpsmagix_image" src="<?php echo $wpspObj->plugin_image_url;?>twitter.png" /></a>
                    <div style="clear:both;"></div>
                    </div>	
                    
                    <div style="width:340px; margin:0 auto; margin-top:10px;">
                 
                  <span class="badge1" id="stumbleupon_span" style="height: 18px; margin-left: 10px; float:left;
                    width: 74px;" onClick="showButton();">
                                <ul class="suHostedBadge" style="margin: 0; padding:0;">
                                   <li><a target="_blank" onClick="return openPopup(this, 640, 400);" href="http://www.stumbleupon.com/submit?url=<?php echo urlencode($wpspObj->curPageURL());?>" class="logo">StumbleUpon</a></li>
                                   <li><a target="_blank" onClick="return openPopup(this, 640, 400);" href="http://www.stumbleupon.com/submit?url=<?php echo urlencode($wpspObj->curPageURL());?>" class="count">
                                         <span>Submit</span>
                                       </a>
                                   </li>
                                </ul>
                            </span>
                            <div id='gplusid' style='float:left; margin: 0 10px 0 20px;'><g:plusone size="medium" annotation="none"  callback='showButton'></g:plusone></div>
                           <div style="float:left;margin:0 5px;"> <a class="DiggThisButton DiggCompact" href="http://digg.com/submit?url=<?php echo urlencode($wpspObj->curPageURL());?>&amp;title=<?php echo $ans[$_REQUEST['key']]['message'];?>"></a>
                           <script type="text/javascript">
                (function() {
                var s = document.createElement("SCRIPT"), s1 = document.getElementsByTagName("SCRIPT")[0];
                s.type = "text/javascript";
                s.async = true;
                s.src = "http://widgets.digg.com/buttons.js";
                s1.parentNode.insertBefore(s, s1);
                })();
                </script>
                <div class="clear"></div>
                </div>
                <div style="float:left;margin:0 5px;"> 
            <a href="http://www.reddit.com/submit?url=<?php echo urlencode($wpspObj->curPageURL());?>" onClick="return openPopup(this,500,350);"> <img src="http://www.reddit.com/static/spreddit7.gif" alt="submit to reddit" border="0" /> </a>
			</div>
                </div>
                </div>
        		<?php }?>
                <div style="clear:both; padding-bottom:10px;"></div>
        	</div>
            <div class="right">
            
            <h3><?php if($result->type)echo "Review";else echo "Results";?></h3>
            <ul>
                        <?php foreach($ans as $key => $answers) : ?>
            
                            <li>
                                <label for="poll-<?php echo $id; ?>-<?php echo $key; ?>" style="<?php if($result->type)echo "line-height:30px;";?>float:left; display:block; margin-right:15px; width:150px;"> <?php echo $answers['answer']; ?></label>
                                
              <?php if($result->type){
					if($result->imgType==0)$imgType = "crown";
					elseif($result->imgType==1)$imgType = "star";
					elseif($result->imgType==2)$imgType = "diamond";
					elseif($result->imgType==3)$imgType = "smiley";?>
                    <div style="float:right;"><div class="baseCss" style="background:url(<?php echo $wpspObj->plugin_image_url.$imgType;?>.png) top left repeat-x;"><div class="ratedCss" style="background:url(<?php echo $wpspObj->plugin_image_url.$imgType;?>.png) left bottom repeat-x;width:<?php if($answers['vote'])echo $answers['vote']*30;?>px;"></div></div><?php echo 'Rated: '.$answers['vote'];?> </div>     
                                <?php
						}else{
                        $gettotal = $result->totalvotes ;
                        if($gettotal == 0)
                            $gettotal = 1;
                        
                        $like=$answers['vote'];
                        $likes=($like*100)/$gettotal;
                    ?>
                        <div style="min-width:100px; float:left;">
                        
                        <?php if($answers['vote']!=0){?>
                            <div class="greenBar" style="width:<?php echo $likes?>px; background:#<?php echo $wpsmagix_general['barcolor'];?>; height:11px;float:left;">&nbsp;</div>			
                                 <?php }?>
                                 </div><?php echo $answers['vote']; }?>
                            </li>
                            <div style="clear:both"></div>
                            
                        <?php endforeach; ?>
                        </ul>
              <?php if($wpsmagix_general['bqlink']){?>
                    <a href="<?php echo $_SERVER['HTTP_REFERER'];?>" style="float:right; padding-top:10px;"> Back to Results Page &raquo;&nbsp;&nbsp; </a> 
              <?php }?> 
              <div style="clear:both"></div>        
              </div>
                   
        </div>
    	<div class="clear"></div> 
    </div>
<?php }?>
<iframe style='width:100%;height:800px;border:none;' frameBorder='0' id='iframe' src='<?php echo $ans[$_REQUEST['key']]['url'];?>'></iframe> 
<script type='text/javascript'> 
		<?php 
			 if($wpsmagix_general['fancybox']=='true'){
			 ?>
		jQuery(document).ready(function(){
			
			 jQuery('a#wpsmagix_link').fancybox(
			{
				'padding' : 0,
				'margin'  : 0,
				'hideOnOverlayClick': false,
				'onClosed': function(){
					window.location.href = '<?php echo $ans[$_REQUEST['key']]['url'];?>';
				}
			});
			jQuery('a#wpsmagix_link').trigger('click');
		});
		<?php }?>		
</script> 

<a id="wpsmagix_link" href="#wpsmagixid" style="display: none;position:relative;">WP Sales Magix</a>			
	<div style="display: none;">
        <div id="wpsmagixid">
            <div id="wpsmagix_bg">
                <div class="innerbg">
                
               		<div class="left"><?php echo apply_filters('the_content',html_entity_decode(stripslashes($ans[$_REQUEST['key']]['lcontent'])));?>
                    <div class="clear"></div>
                    </div>
                    <div class="middle"><h3 class="wpsmagix_text"><a href="<?php echo $ans[$_REQUEST['key']]['durl'];?>" target="_blank" id="blink"><?php echo $wpsmagix_general['html'];?></a></h3>
                    <?php if($wpsmagix_general['isShare']){?>
                    <div>
                    <div style="width:165px; margin:0 auto;">
                    
                        
                        <!-- Place this render call where appropriate -->
                        <script type="text/javascript">
                          (function() {
                            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                            po.src = 'https://apis.google.com/js/plusone.js';
                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                          })();
                        </script>
                    <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
                    <script type="text/javascript">
                    function openPopup(element, w, h) {
                             
                            var width  = 575,
                                height = 400,
                                left   = (jQuery(window).width()  - width)  / 2,
                                top    = (jQuery(window).height() - height) / 2,
                                url    = element.href;
                                
                                if(w != 0)
                                    width = w;
                                if(h != 0)
                                    height = h;	
                                    
                                var opts   = 'status=1' +
                                         ',width='  + width  +
                                         ',height=' + height +
                                         ',top='    + top    +
                                         ',left='   + left;
                                         
                            
                            
                            window.open(url, 'twitte', opts);
                            "  . $closeonclick . "
                            return false;
                        }
                        </script>
                    <a href="<?php echo $wpspObj->plugin_url;?>email.php" onClick="return openPopup(this, <?php echo $wpsmagix_general['emailwidth'].', '. $wpsmagix_general['emailheight'];?>);"><img class="wpsmagix_image" src="<?php echo $wpspObj->plugin_image_url;?>email.png"  /></a>
                        
                        <a href="http://www.facebook.com/sharer.php?u=<?php echo $wpspObj->curPageURL();?>&t=<?php echo $ans[$_REQUEST['key']]['message'];?>" onClick="return openPopup(this,500,350);"><img class="wpsmagix_image" src="<?php echo $wpspObj->plugin_image_url;?>facebook.png" /></a>
                        
                       
                        
                        <a href="http://twitter.com/share?url=<?php echo urlencode($wpspObj->curPageURL());?>&text=<?php echo $ans[$_REQUEST['key']]['message'];?>" onClick="return openPopup(this,500,350);"><img style="margin-right:0" class="wpsmagix_image" src="<?php echo $wpspObj->plugin_image_url;?>twitter.png" /></a>
                        <div style="clear:both;"></div>
                        </div>	
                        
                        <div style="width:340px; margin:0 auto; margin-top:10px;">
                     
                      <span class="badge1" id="stumbleupon_span" style="height: 18px; margin-left: 10px; float:left;
                        width: 74px;" onClick="showButton();">
                                    <ul class="suHostedBadge" style="margin: 0; padding:0;">
                                       <li><a target="_blank" onClick="return openPopup(this, 640, 400);" href="http://www.stumbleupon.com/submit?url=<?php echo urlencode($wpspObj->curPageURL());?>" class="logo">StumbleUpon</a></li>
                                       <li><a target="_blank" onClick="return openPopup(this, 640, 400);" href="http://www.stumbleupon.com/submit?url=<?php echo urlencode($wpspObj->curPageURL());?>" class="count">
                                             <span>Submit</span>
                                           </a>
                                       </li>
                                    </ul>
                                </span>
                                <div id='gplusid' style='float:left; margin:0 10px 0 20px;'><g:plusone size="medium" annotation="none"  callback='showButton'></g:plusone></div>
                               <div style="float:left;margin:0 5px;"> 
                                    <a class="DiggThisButton DiggCompact" 
                                    href="http://digg.com/submit?url=<?php echo urlencode($wpspObj->curPageURL());?>&amp;title=<?php echo $ans[$_REQUEST['key']]['message'];?>">
                                    </a>
                                   <script type="text/javascript">
                                        (function() {
                                        var s = document.createElement("SCRIPT"), s1 = document.getElementsByTagName("SCRIPT")[0];
                                        s.type = "text/javascript";
                                        s.async = true;
                                        s.src = "http://widgets.digg.com/buttons.js";
                                        s1.parentNode.insertBefore(s, s1);
                                        })();
                                    </script>
                                </div>
                                <div style="float:left;margin:0 5px;"> 
                                <a href="http://www.reddit.com/submit" onClick="return openPopup('http://www.reddit.com/submit?url=' + encodeURIComponent(window.location),500,350);"> <img src="http://www.reddit.com/static/spreddit7.gif" alt="submit to reddit" border="0" /> </a>
                                </div>
                    <div style="clear:both;"></div> 
                    </div><div style="clear:both;"></div> 
                    </div>
                    <?php }?>
                    <div style="clear:both; padding-bottom:10px;"></div>
                    </div>
                    <div class="right">
                    
                    <h3><?php if($result->type)echo "Review";else echo "Results";?></h3>
                    <ul>
                                <?php foreach($ans as $key => $answers) : ?>
                    
                                    <li>
                                        <label for="poll-<?php echo $id; ?>-<?php echo $key; ?>" style="<?php if($result->type)echo "line-height:30px;";?>float:left; display:block; margin-right:15px; width:150px;"> <?php echo $answers['answer']; ?></label>
                                    <?php if($result->type){
                                                 if($result->imgType==0)$imgType = "crown";
                                        elseif($result->imgType==1)$imgType = "star";
                                        elseif($result->imgType==2)$imgType = "diamond";
                                        elseif($result->imgType==3)$imgType = "smiley";?>
                                        <div style="float:right;"><div style="background:url(<?php echo $wpspObj->plugin_image_url.$imgType;?>.png) top left repeat-x; height:30px; width:150px; overflow:hidden;"><div style="position: absolute;
                                          background:url(<?php echo $wpspObj->plugin_image_url.$imgType;?>.png) left bottom repeat-x;   
                    height: 30px;
                    width:<?php if($answers['vote'])echo $answers['vote']*30;?>px;
                    display: block;
                    text-indent: -9000px;
                    z-index: 1;
                    border: none !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    list-style: none !important;
                    border-image: initial;
                    "></div></div> <?php echo 'Rated: '.$answers['vote'];?> </div>    
                                                    <?php
                        }else{	
                                $gettotal = $result->totalvotes ;
                                if($gettotal == 0)
                                    $gettotal = 1;
                                
                                $like=$answers['vote'];
                                $likes=($like*100)/$gettotal;
                            ?>
                                <div style="min-width:100px; float:left;">
                                
                                <?php if($answers['vote']!=0){?>
                                    <div class="greenBar" style="width:<?php echo $likes?>px; background:#<?php echo $wpsmagix_general['barcolor'];?>; height:11px;float:left;">&nbsp;</div>			
                                         <?php }?>
                                         </div><?php echo $answers['vote'].' Votes'; }?>
                                    </li>
                                    <div style="clear:both"></div>
                                    
                                <?php endforeach; ?>
                                </ul>
                      <a href="<?php echo $_SERVER['HTTP_REFERER'];?>" style="float:right;padding-top:10px;"> Back to Poll Page &raquo;&nbsp;&nbsp; </a>          				<div style="clear:both"></div>
                      </div>
                           
                </div>
			<div style="clear:both;"></div> 
			</div>
		</div>
	</div>
</body> 
</html>         
<?php
exit;	
}
?>
