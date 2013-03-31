<?php
if ( !class_exists('wpsmagix') ) :
	class wpsmagix
	{		
		var $plugin_url;
		var $plugin_image_url;
		var $tablename;
		var $tablemail;
		
		function wpsmagix()
		{	
			global $table_prefix;
			
			$this->plugin_url = trailingslashit( WP_PLUGIN_URL.'/'.dirname( plugin_basename(__FILE__) ));
			$this->plugin_image_url = trailingslashit( WP_PLUGIN_URL.'/'.dirname( plugin_basename(__FILE__) )).'images/';
			$this->tablename = $table_prefix . "wpsmagix";
			$this->tablemail = $table_prefix . "wpsmmail";
			
			add_action('wp_print_scripts', array($this,'scripts_action'));
			add_action('admin_menu', array($this, 'admin_menu'));
			add_shortcode('wpsmagix', array($this, 'wpsmagixShortCode'));
			add_shortcode('wpspvideo', array($this, 'wpspvideo'));
			
			add_filter('mce_external_plugins', array($this, 'editor_register'));
			add_filter('mce_buttons', array($this, 'editor_add_button'), 0);
			
			add_option('wpsmagix_css', 'true', '', 'yes');
			add_action('add_meta_boxes', array($this, 'wpsmagix_add_custom_box'));
		}
		function editor_add_button($buttons)
		{
			array_push($buttons, "separator", "wpsp_shortcode");
			return $buttons;
		}
		
		function editor_register($plugin_array)
		{
			$url = trim(get_bloginfo('url'), "/")."/wp-content/plugins/wpsalesmagix/js/editor_plugin.js";
			$plugin_array['wpsp_shortcode'] = $url;
			return $plugin_array;
		}
		function install()
		{
			global $wpdb;
			
			$this->setData();
			if($wpdb -> get_var("SHOW TABLES LIKE '".$this->tablename."'") != $this->tablename) {
			   
			   $install_query = 'CREATE TABLE IF NOT EXISTS `'.$this->tablename.'` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `question` varchar(512) NOT NULL,
								  `answers` text NOT NULL,
								  `added` int(11) NOT NULL,
								  `active` int(11) NOT NULL,
								  `totalvotes` int(11) NOT NULL,
								  `updated` int(11) NOT NULL,
								  `type` int(11) NOT NULL,
  									`imgType` int(11) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=MyISAM ;';
			  $wpdb->query($install_query);
			  
			  
			}
			if($wpdb -> get_var("SHOW TABLES LIKE '".$this->tablemail."'") != $this->tablemail) {
	   
	   $sql = 'CREATE TABLE IF NOT EXISTS ' . $this->tablemail . ' (
       `id` INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
	   `full_name` VARCHAR(100) NOT NULL,
       `email` VARCHAR(100) NOT NULL, 
       `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP) 
       ENGINE = MyISAM;';
	  
	   $wpdb->query($sql);	
	}
			
		}
		function curPageURL() 
		{
			 $url = '';
			if (isset($_SERVER['HTTPS']) && filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN))
				$url .= 'https';
			else
				$url .= 'http';
			$url .= '://';
			if (isset($_SERVER['HTTP_HOST']))
				$url .= $_SERVER['HTTP_HOST'];
			elseif (isset($_SERVER['SERVER_NAME']))
				$url .= $_SERVER['SERVER_NAME'];
			else
				trigger_error ('Could not get URL from $_SERVER vars');
			if ($_SERVER['SERVER_PORT'] != '80')
			  $url .= ':'.$_SERVER["SERVER_PORT"];
			if (isset($_SERVER['REQUEST_URI']))
				$url .= $_SERVER['REQUEST_URI'];
			elseif (isset($_SERVER['PHP_SELF']))
				$url .= $_SERVER['PHP_SELF'];
			elseif (isset($_SERVER['REDIRECT_URL']))
				$url .= $_SERVER['REDIRECT_URL'];
			else
				trigger_error ('Could not get URL from $_SERVER vars');
			return $url;
		}
		function deactivate()
		{
			global $wpdb;
			
			$general = get_option('wpsmagix_general');
			if(!$general['keepdata']){
			$wpdb->query("Drop table $this->tablename");
			$wpdb->query("Drop table $this->tablemail");
			}
			delete_option('wpsmagix_general');
		}
		
		function admin_menu()
		{
			add_menu_page('WP Sales Magix', 'WP Sales Magix', 'manage_options', 'wpsmagix', array($this, 'admin_settings'));
				add_submenu_page('wpsmagix', 'Add/New Edit', 'Add/New Edit', 'manage_options', 'wpsmagix-add', array($this, 'admin_options'));
				add_submenu_page('wpsmagix', 'Data', 'Data', 'manage_options', 'wpsmagix_data', array($this, 'wpsmagix_data'));
		}
		function wpsmagix_data()
{
    global $wpdb;
    $table_name = $this->tablemail;
    
    if(isset($_GET['delete']))
    {
        $id = absint($_GET['delete']);
        
        $ok = $wpdb -> query("DELETE FROM $table_name WHERE id = $id");
        
        if($ok == 1)
            $response = "Record successfully deleted.";
        else
            $response = "Unable to delete record.";
    }
    
    $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
    $limit = isset( $_GET['limit'] ) ? absint( $_GET['limit'] ) : 50;
    $offset = ( $pagenum - 1 ) * $limit;
    
    $entries = $wpdb -> get_results( "SELECT * FROM $table_name ORDER BY id DESC LIMIT $offset, $limit" );
    $total = $wpdb -> get_var( "SELECT COUNT(`id`) FROM $table_name" );
    $num_of_pages = ceil( $total / $limit );
    
    
    require_once('data.php');
}
		
		function admin_options()
		{ 			
			include('wpsmagix-options.php');
		}
		
		function setData()
		{
			delete_option('wpsmagix_general');
			$css = "min-width: 300px;
					min-height: 20px;
					padding: 15px 0;
					margin:0;
					text-align: center;
					font-size: 20px;
					background: yellow;
					overflow: hidden;";
			$email = file_get_contents(dirname(__FILE__) . '/default_email.txt');
			$wpsmagix_general = array(
			'fancybox' => 'true',
					//'link' => 'http://wp-winner.com',
					'html' => 'Download Report Here',
					'blink' => 0,
					'bgcolor'=>'3e4756',
					'barcolor'=>'159399',
					'textcolor'=>'f0f0f0',
					'leftcontent'=>'Test Content',
					'css' => $css,
					'width' => '1200',
					'emailwidth' => '660',
					'emailheight' => '340',
					'email' => $email,
					'keepdata' => 1,
					'bqlink' => 1,
					'isShare' => 1
				);
				add_option('wpsmagix_general', $wpsmagix_general);
		}
		
		function admin_settings()
		{ 	
			if(isset($_POST['btngeneral']) && $_POST['btngeneral']=='Save')
			{	
				$general_options = array();	
				$general_options['fancybox'] = $_POST['wpsmagix_fancybox'];
				//$general_options['link'] = $_POST['epoll_link'];
				$general_options['html'] = $_POST['wpsmagix_text'];
				$general_options['bgcolor'] = $_POST['bgcolor'];
				$general_options['barcolor'] = $_POST['barcolor'];
				$general_options['textcolor'] = $_POST['textcolor'];
				$general_options['blink'] = $_POST['wpsmagix_blink'];
				$general_options['css'] = $_POST['wpsmagix_css'];
				$general_options['width'] = $_POST['wpsmagix_width'];
				$general_options['keepdata'] = $_POST['wpsmagix_keepdata'];
				$general_options['email'] = $_POST['wpsmagix_email'];
				$general_options['emailwidth'] = $_POST['wpsmagix_emailwidth'];
				$general_options['emailheight'] = $_POST['wpsmagix_emailheight'];
				$general_options['bqlink'] = $_POST['wpsmagix_bqlink'];
				$general_options['isShare'] = $_POST['wpsmagix_isShare'];
				
				update_option('wpsmagix_general', $general_options);				
			}		
			include('wpsmagix-settings.php');
		}
		
		function wpsmagix_add_custom_box()
		{
			add_meta_box('wpsmagix_shortcodeid','WP Sales Magix',array($this, 'wpsmagix_shortcodecustom_box'),'post','side', 'high');
			add_meta_box('wpsmagix_shortcodeid','WP Sales Magix',array($this, 'wpsmagix_shortcodecustom_box'),'page','side', 'high');	
		}
		
		function wpsmagix_shortcodecustom_box($post)
		{
			global $wpdb;
			$post_id=$post->ID;
			
			wp_nonce_field( plugin_basename(__FILE__), 'wpgattack_noncename' );			
				?>
				<div style="width:100%; font-size:12px; line-height:22px;">
                	<strong>WP Sales Magix Shortcodes:</strong><br/>
                    <?php 
						$res = $wpdb->get_results("select * from $this->tablename");
						?>	
                        <script type="text/javascript">
						function wpsmagixfunc(selectObj){
							var idx = selectObj.selectedIndex; 
							var which = selectObj.options[idx].value; 
							document.getElementById('wpsmagixcode').innerHTML="[wpsmagix id='"+which+"']";
						}
						</script>
                       <form name="me">
                       <select name="wpsmagix" id="wpsmagix" onchange="wpsmagixfunc(this);" style="width:250px;">
                       <option value="">Select</option>
							<?php	
							foreach($res as $ras)
							{
                            ?>
                            <option value="<?php echo $ras->id;?>"><?php echo $ras->question;?></option>
                            <?php 		
                                }
                                ?>
                        </select>
                        </form>
                        <textarea id="wpsmagixcode"  onclick="document.getElementById('wpsmagixcode').focus();document.getElementById('wpsmagixcode').select();"  readonly="readonly"  style="width:250px;"></textarea>
                        <div style="clear:both;"></div>
                        Select drop down to get the shortcodes for the polls created and copy paste the shortcodes to the editor where you want to display polls.
                    <?php
					?>
				</div>
				<?php	
		}
		
		function scripts_action()
		{
			if(!is_admin()){
				wp_enqueue_script('jquery');
			
				echo '<link rel="stylesheet" href="'.$this->plugin_url.'wpsmagix.css" type="text/css" >';
			}
		}
		
		function enqueue_editor() 
		{
			wp_enqueue_script('common');
			wp_enqueue_script('jquery-affect');
			wp_admin_css('thickbox');
			wp_print_scripts('post');
			wp_print_scripts('media-upload');
			wp_print_scripts('jquery');
			wp_print_scripts('jquery-ui-core');
			wp_print_scripts('jquery-ui-tabs');
			wp_print_scripts('tiny_mce');
			wp_print_scripts('editor');
			wp_print_scripts('editor-functions');
		
			/* Include the link dialog functions */
			//include ABSPATH . 'wp-admin/includes/internal-linking.php';
			wp_print_scripts('wplink');
			wp_print_styles('wplink');
			add_action('tiny_mce_preload_dialogs', 'wp_link_dialog');
		
			add_thickbox();
			wp_tiny_mce();
			wp_admin_css();
			wp_enqueue_script('utils');
			do_action("admin_print_styles-post-php");
			do_action('admin_print_styles');
			//remove_all_filters('mce_external_plugins');
		}
		function wpspvideo($atts){
			global $post;
			extract(shortcode_atts( array(
					'src' => 1,
					'width' => 200,
					'height' =>150,
					'autoplay' => 1
					), $atts ) );
			if($autoplay)		
			$content='<iframe width="'.$width.'" height="'.$height.'" src="'.$src.'?autoplay=1" frameborder="0" allowfullscreen></iframe>';
			else
			$content='<iframe width="'.$width.'" height="'.$height.'" src="'.$src.'" frameborder="0" allowfullscreen></iframe>';
			return $content;
		}
		
		function wpsmagixShortCode($atts)
		{
			global $wpdb;
			global $post;
			global $wp_query;
			
			
			
			extract( shortcode_atts( array(
					'id' => 1
					), $atts ) );
			
				$res = $wpdb->get_row("select * from $this->tablename where id='$id'");
			
			$ans = unserialize($res->answers);
			$wpsmagix_general = get_option('wpsmagix_general');
			ob_start();
			?>
			
			<div class="wpsmagix" id="wpsmagix-<?php echo $res->id; ?>">
	<p class="question"><?php echo $res->question; ?></p>
	
	<!--<form method="post" action="<?php echo SP_URL; ?>page/user/poll-submit.php">-->
	<form method="post" action="" name="box">
			
			<fieldset>
				<ul>
				<?php foreach($ans as $key => $answers) : ?>

					<li>
						<?php if(!$res->type){?><input type="radio" name="answer" value="<?php echo $key; ?>" id="poll-<?php echo $res->id; ?>-<?php echo $key; ?>" onclick="epolfunc<?php echo $res->id; ?>(<?php echo $key; ?>);" /><?php }?>
						<label for="poll-<?php echo $id; ?>-<?php echo $key; ?>" <?php if($res->type)echo 'style="line-height:40px;"';?>>
						<?php if($res->type){?><a href="<?php bloginfo('url');?>/?wpsmid=<?php echo $res->id;?>&key=<?php echo $key; ?>"><?php }?>
						<?php echo $answers['answer']; ?>
                        <?php if($res->type){?></a><?php }?>
                        </label>
                        
                        <?php
				//$gettotal = mysql_num_rows($result);
				$gettotal = $res->totalvotes ;
				if($gettotal == 0)
					$gettotal = 1;
				
				$like=$answers['vote'];
				$likes=($like*150)/$gettotal;
			?>
             

				<div style="min-width:150px; float:left;">
                <?php if(!$res->type){
					
					?>
                <?php if($answers['vote']!=0){?>
                    <div class="greenBar" style="width:<?php echo $likes?>px; background:#<?php echo $wpsmagix_general['barcolor'];?>; height:10px;">&nbsp;</div>                      
                         <?php }}else{
							 if($res->imgType==0)$imgType = "crown";
					elseif($res->imgType==1)$imgType = "star";
					elseif($res->imgType==2)$imgType = "diamond";
					elseif($res->imgType==3)$imgType = "smiley";?><div style="background:url(<?php echo $this->plugin_image_url.$imgType;?>.png) top left repeat-x; height:30px; width:150px;"><div style="position: absolute;
                      background:url(<?php echo $this->plugin_image_url.$imgType;?>.png) left bottom repeat-x;   
height: 30px;
width:<?php if($answers['vote']){if($answers['vote']>5)$answers['vote']=5;echo $answers['vote']*30;}?>px;
display: block;
text-indent: -9000px;
z-index: 1;
border: none !important;
margin: 0 !important;
padding: 0 !important;
list-style: none !important;
border-image: initial;
"></div></div> <?php }echo 'Rated: '.$answers['vote'];?>
                         </div>
					</li>
					
				<?php endforeach; ?>
				</ul>
			</fieldset>
		
			<p id="wpsmagix-vote<?php echo $res->id; ?>"></p>
			<div style="clear:both;"></div>
		
		
	</form>
</div><script type="text/javascript">
function epolfunc<?php echo $res->id; ?>(key){
	
	<?php foreach($ans as $key => $answers) : ?>
	if(key==<?php echo $key; ?>)
	jQuery('#wpsmagix-vote<?php echo $res->id; ?>').html('<a href="<?php bloginfo('url');?>/?wpsmid=<?php echo $res->id;?>&key=<?php echo $key;?>" class="button">Reveal</a>');
	<?php endforeach; ?>
	
}
			</script>
<?php 
		 $content = ob_get_clean();	
			if(is_single() || is_page())
			{
				return $content;
			}
			
		}
		
		function wpsmagixgethtml($atts)
		{
			global $wpdb;
			global $post;
			global $wp_query;
			
			$res = $wpdb->get_row("select * from $this->tablename where id='$atts'");
			
			$ans = unserialize($res->answers);
			$wpsmagix_general = get_option('wpsmagix_general');
			ob_start();
			?>
<style type="text/css">
.wpsmagix {
	font-family: Helvetica, Arial, sans-serif;
	font-weight: 300;
	border:	1px solid #DDD;
	width: 550px;
	padding: 5px;
	-moz-border-radius:	5px; 
	border-radius: 5px;
	background: #FEFEFE;
	margin:	1em 0;
	padding: 1em;	
	box-shadow:	0 1px 8px	rgba(0, 0, 0, 0.3),
				0 0 4px 	rgba(0, 0, 0, 0.1) inset;
}
.wpsmagix a{
	color:#666 !important;
	text-decoration:none !important;
}
.wpsmagix a:hover{
	color:#000 !important;
}
.wpsmagix fieldset {
	border: 1px solid #E7E7E7;
	margin: 0;
	padding: 5px 24px 24px 24px;
}
.wpsmagix label, .wpsmagix input, .wpsmagix .button {
	cursor:	pointer;
}
.wpsmagix ul,.wpsmagix li {
	list-style:	none;
	margin:	0;
	padding: 0;
}
.wpsmagix li {
	clear: both;
	display: block;
	margin:	1em 0;
	padding: 10px 0;
}
.wpsmagix ul input {
	float: left;
	margin:	0.3em 1em 0 0;
}	
.wpsmagix ul label {
	display: inline-block;
	width: 270px;
	float: left;
	margin-right: 30px;
	line-height: <?php if(!$res->type)echo '22';else echo '35';?>px;
	color: #888;
}	
.wpsmagix dl {
	line-height: 1.5em;	
	margin:	0.5em 0;
	font-size: 0.9em;
}
.wpsmagix dt {
	font-weight: 300;	
	margin:	1em 0 0 ;
}
.wpsmagix dd {
	margin:	0 0 0.5em;
	border-top:	2px solid #C09;
	display: block;
}	
.wpsmagix p {
	margin:	0;
	text-align:	center;
}	
.wpsmagix .question {
	font-weight: 700;
	font-size: 1.1em;
	margin:	0 0 20px;
	border-bottom: 1px solid #DDD;
	text-align: left;
}	
.wpsmagix .button {
	cursor:	pointer;	
	font-size: 16px;
	color: #333;
	width: 100%;
	border:	1px solid #FEFEFE;	
	background:	#EFEFEF;
	-moz-border-radius:	5px; 
	border-radius: 5px;
	box-shadow:	0 0 3px	rgba(0, 0, 0, 0.6);
}
.wpsmagix .button:hover{
	background:	#DDD;
	box-shadow:	0 0 5px	rgba(0, 0, 0, 0.6);
}
.wpsmagix .button:active{
	background:	#EFEFEF;
	box-shadow:	0 0 5px	rgba(0, 0, 0, 0.3) inset;
}
.wpsmagix .button{
	width:100px;
	float:left;
	margin-left:30px;
	margin-top:30px;
}
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
</style>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<div class="wpsmagix" id="wpsmagix-<?php echo $res->id; ?>">
	<p class="question"><?php echo $res->question; ?></p>
    <form method="post" action="" name="box">
		<fieldset>
				<ul>
				<?php foreach($ans as $key => $answers) : ?>
					<li>
						<?php if(!$res->type){?><input type="radio" name="answer" value="<?php echo $key; ?>" id="poll-<?php echo $res->id; ?>-<?php echo $key; ?>" onclick="epolfunc<?php echo $res->id; ?>(<?php echo $key; ?>);" /><?php }?>
						<label for="poll-<?php echo $id; ?>-<?php echo $key; ?>"><a href="<?php bloginfo('url');?>/?wpsmid=<?php echo $res->id;?>&key=<?php echo $key; ?>"><?php echo $answers['answer']; ?></a></label>                        
                        <?php
				$gettotal = $res->totalvotes ;
				if($gettotal == 0)
					$gettotal = 1;
				
				$like=$answers['vote'];
				$likes=($like*150)/$gettotal;
			?>
            <div style="min-width:150px; float:left;">
                <?php if(!$res->type){?>
                <?php if($answers['vote']!=0){?>
                    <div class="greenBar" style="width:<?php echo $likes?>px; background:#<?php echo $wpsmagix_general['barcolor'];?>; height:10px;">&nbsp;</div>  <?php }}else{
							 if($res->imgType==0)$imgType = "crown";
					elseif($res->imgType==1)$imgType = "star";
					elseif($res->imgType==2)$imgType = "diamond";
					elseif($res->imgType==3)$imgType = "smiley";?><div class="baseCss" style="background:url(<?php echo $this->plugin_image_url.$imgType;?>.png) top left repeat-x;"><div class="ratedCss" style="background:url(<?php echo $this->plugin_image_url.$imgType;?>.png) left bottom repeat-x;width:<?php if($answers['vote']){if($answers['vote']>5)$answers['vote']=5;echo $answers['vote']*30;}?>px;"></div></div> <?php }echo 'Rated: '.$answers['vote'];?>
                         </div>	
			</li>					
				<?php endforeach; ?>
		</ul>
	</fieldset>		
	<p id="wpsmagix-vote<?php echo $res->id; ?>"></p>
	<div style="clear:both;"></div>		
</form>
</div>
<script type="text/javascript">
function epolfunc<?php echo $res->id; ?>(key){	
	<?php foreach($ans as $key => $answers) : ?>
	if(key==<?php echo $key; ?>)jQuery('#wpsmagix-vote<?php echo $res->id; ?>').html('<a href="<?php bloginfo('url');?>/?wpsmid=<?php echo $res->id;?>&key=<?php echo $key;?>" class="button">Vote</a>');<?php endforeach; ?>}</script>
<?php 
		 	$content = ob_get_clean();		
			return $content;
		}
		
		function wpsmagixgetfbhtml($atts)
		{
			global $wpdb;
			global $post;
			global $wp_query;
			
			$res = $wpdb->get_row("select * from $this->tablename where id='$atts'");
			
			$ans = unserialize($res->answers);
			$wpsmagix_general = get_option('wpsmagix_general');
			ob_start();
			?>
<style type="text/css">
.wpsmagix {
	font-family: Helvetica, Arial, sans-serif;
	font-weight: 300;
	border:	1px solid #DDD;
	width: 460px;
	padding: 5px;
	-moz-border-radius:	5px; 
	border-radius: 5px;
	background: #FEFEFE;
	margin:	1em 0;
	padding: 1em;	
	box-shadow:	0 1px 8px	rgba(0, 0, 0, 0.3),
				0 0 4px 	rgba(0, 0, 0, 0.1) inset;
}
.wpsmagix a{
	color:#666 !important;
	text-decoration:none !important;
}
.wpsmagix a:hover{
	color:#000 !important;
}
.wpsmagix fieldset {
	border: 1px solid #E7E7E7;
	margin: 0;
	padding: 5px 24px 24px 24px;
}
.wpsmagix label, .wpsmagix input, .wpsmagix .button {
	cursor:	pointer;
}
.wpsmagix ul,.wpsmagix li {
	list-style:	none;
	margin:	0;
	padding: 0;
}
.wpsmagix li {
	clear: both;
	display: block;
	margin:	1em 0;
	padding: 10px 0;
}
.wpsmagix ul input {
	float: left;
	margin:	0.3em 1em 0 0;
}	
.wpsmagix ul label {
	display: inline-block;
	width: 230px;
	float: left;
	margin-right: 30px;
	line-height: <?php if(!$res->type)echo '22';else echo '35';?>px;
	color: #888;
}	
.wpsmagix dl {
	line-height: 1.5em;	
	margin:	0.5em 0;
	font-size: 0.9em;
}
.wpsmagix dt {
	font-weight: 300;	
	margin:	1em 0 0 ;
}
.wpsmagix dd {
	margin:	0 0 0.5em;
	border-top:	2px solid #C09;
	display: block;
}	
.wpsmagix p {
	margin:	0;
	text-align:	center;
}	
.wpsmagix .question {
	font-weight: 700;
	font-size: 1.1em;
	margin:	0 0 20px;
	border-bottom: 1px solid #DDD;
	text-align: left;
}	
.wpsmagix .button {
	cursor:	pointer;	
	font-size: 16px;
	color: #333;
	width: 100%;
	border:	1px solid #FEFEFE;	
	background:	#EFEFEF;
	-moz-border-radius:	5px; 
	border-radius: 5px;
	box-shadow:	0 0 3px	rgba(0, 0, 0, 0.6);
}
.wpsmagix .button:hover{
	background:	#DDD;
	box-shadow:	0 0 5px	rgba(0, 0, 0, 0.6);
}
.wpsmagix .button:active{
	background:	#EFEFEF;
	box-shadow:	0 0 5px	rgba(0, 0, 0, 0.3) inset;
}
.wpsmagix .button{
	width:100px;
	float:left;
	margin-left:30px;
	margin-top:30px;
}
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
</style>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<div class="wpsmagix" id="wpsmagix-<?php echo $res->id; ?>">
	<p class="question"><?php echo $res->question; ?></p>
    <form method="post" action="" name="box">
		<fieldset>
            <ul>
            	<?php foreach($ans as $key => $answers) : ?>
                <li><?php if(!$res->type){?>
                    <input type="radio" name="answer" value="<?php echo $key; ?>" id="poll-<?php echo $res->id; ?>-<?php echo $key; ?>" onclick="epolfunc<?php echo $res->id; ?>(<?php echo $key; ?>);" /><?php }?>
                    <label for="poll-<?php echo $id; ?>-<?php echo $key; ?>"><a href="<?php bloginfo('url');?>/?wpsmid=<?php echo $res->id;?>&key=<?php echo $key; ?>" target="_blank"><?php echo $answers['answer']; ?></a></label>                        
        <?php
            $gettotal = $res->totalvotes ;
            if($gettotal == 0)
                $gettotal = 1;
            
            $like=$answers['vote'];
            $likes=($like*100)/$gettotal;
        ?>
        <div style="min-width:100px; float:left;">
            <?php if(!$res->type){?>
            <?php if($answers['vote']!=0){?>
                <div class="greenBar" style="width:<?php echo $likes?>px; background:#<?php echo $wpsmagix_general['barcolor'];?>; height:10px;">&nbsp;</div>  <?php }}else{ 
				if($res->imgType==0)$imgType = "crown";
                elseif($res->imgType==1)$imgType = "star";
                elseif($res->imgType==2)$imgType = "diamond";
                elseif($res->imgType==3)$imgType = "smiley";?>
                <div class="baseCss" style="background:url(<?php echo $this->plugin_image_url.$imgType;?>.png) top left repeat-x;">
                	<div class="ratedCss" style="background:url(<?php echo $this->plugin_image_url.$imgType;?>.png) left bottom repeat-x;width:<?php if($answers['vote']){if($answers['vote']>5)$answers['vote']=5;echo $answers['vote']*30;}?>px;"></div></div> <?php }echo 'Rated: '.$answers['vote'];?>
                     </div>	
        </li>					
            <?php endforeach; ?>
    </ul>
		</fieldset>		
        <p id="wpsmagix-vote<?php echo $res->id; ?>"></p>
        <div style="clear:both;"></div>		
	</form>
</div>
<script type="text/javascript">
function epolfunc<?php echo $res->id; ?>(key){	
	<?php foreach($ans as $key => $answers) : ?>
	if(key==<?php echo $key; ?>)jQuery('#wpsmagix-vote<?php echo $res->id; ?>').html('<a href="<?php bloginfo('url');?>/?wpsmid=<?php echo $res->id;?>&key=<?php echo $key;?>" class="button" target="_blank">Vote</a>');<?php endforeach; ?>}</script>
<?php 
		 	$content = ob_get_clean();		
			return $content;
		}
		
		function wpsmagix_getemailtemplates($atts)
		{
			global $wpdb;
			global $post;
			global $wp_query;
			
			$res = $wpdb->get_row("select * from $this->tablename where id='$atts'");
			
			$ans = unserialize($res->answers);
			$wpsmagix_general = get_option('wpsmagix_general');
			ob_start();
			?>

<table cellpadding="0" cellspacing="0" border="0" style="border: 1px solid #dddddd; padding:0 20px 20px 20px; ">
    <tr>
        <td colspan="3">
            <h2 style="border-bottom:1px solid #ddd;"><?php echo $res->question; ?></h2>
        </td>
    </tr>
    <?php foreach($ans as $key => $answers) : ?>
    <tr>
        <td valign="top" style="vertical-align:top;"><b><a href="<?php bloginfo('url');?>/?wpsmid=<?php echo $res->id;?>&key=<?php echo $key; ?>"><?php echo $answers['answer']; ?></a></b></td>
        <td width="20">&nbsp;</td>
        <td valign="top">
       	<div style="min-width:150px; float:left;">
                <?php if(!$res->type){
					?>
                    <a href="<?php bloginfo('url');?>/?wpsmid=<?php echo $res->id;?>&key=<?php echo $key;?>" style="text-decoration:none; color:#006;">Click Here to vote &raquo;</a>      <?php }else{
							if($res->imgType==0)$imgType = "crown";
							elseif($res->imgType==1)$imgType = "star";
							elseif($res->imgType==2)$imgType = "diamond";
							elseif($res->imgType==3)$imgType = "smiley";?><img src="<?php echo $this->plugin_image_url.$imgType;?>-<?php if($answers['vote']){if($answers['vote']>5)$answers['vote']=5;echo $answers['vote'];}?>.png" /><?php }echo '<br/>Rated: '.$answers['vote'];?>
                         </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="height:5px;"></td>
    </tr>
    <?php endforeach; ?>
    
</table>
<?php 
		$content = ob_get_clean();			
		return $content;		
	}			
}
else :
	exit ("Class wpsmagix already declared!");
endif;
	
?>