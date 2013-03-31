<?php
if(!class_exists('PopUp_Domination')){
	die('No direct access allowed.');
}

/**
* Admin Class
*
* All admin dashboard functionality goes in this class.
*/

class PopUp_Domination_Admin extends PopUp_Domination {
	
	function PopUp_Domination_Admin(){
		parent::PopUp_Domination();
	}
	
	/**
	* admin_menu()
	*
	* Setups up the dashboard menu and the virtual plugin's admin panel.
	*/

	function admin_menu(){
		$ins = '';
		if($ins != $this->option('v3installed')){
			$this->submenu['main'] = add_menu_page('PopUp Domination', 'PopUp Domination', 'manage_options', 'popup-domination/campaigns', array(&$this, 'admin_page'), $this->plugin_url.'css/images/icon.png');
			$this->submenu['campaigns'] = add_submenu_page('popup-domination/campaigns', 'Campaigns', 'Campaigns','manage_options','popup-domination/campaigns', array(&$this, 'admin_page'));
			$this->submenu['analytics'] = add_submenu_page('popup-domination/campaigns', 'Analytics', 'Analytics','manage_options',$this->menu_url.'analytics', array(&$this, 'admin_page'));
			$this->submenu['ab'] = add_submenu_page('popup-domination/campaigns', 'A/B Testing', 'A/B Testing','manage_options',$this->menu_url.'a-btesting', array(&$this, 'admin_page'));
			$this->submenu['mailing'] = add_submenu_page('popup-domination/campaigns', 'Mailing List Manager', 'Mailing List Manager','manage_options',$this->menu_url.'mailinglist', array(&$this, 'admin_page'));
			$this->submenu['promote'] = add_submenu_page('popup-domination/campaigns', 'Promote', 'Promote','manage_options', $this->menu_url.'promote', array(&$this, 'admin_page'));
			$this->submenu['theme'] = add_submenu_page('popup-domination/campaigns', 'Theme Uploader', 'Theme Uploader','manage_options', $this->menu_url.'theme_upload', array(&$this, 'admin_page'));
			$this->admin_styles();
		}
	}
	
	/**
	* install_menu()
	*
	* Setups the menu seen before the plugin is verfied.
	*/

	function install_menu(){
			$this->submenu['main'] = add_menu_page('PopUp Domination', 'PopUp Domination', 'manage_options', 'popup-domination/install', array(&$this, 'installation_process'), $this->plugin_url.'css/images/icon.png');
	}
	
	/**
	* admin_styles_()
	*
	* Registers each stylesheet for each panel.
	* Works in conjustion with admin_styles() to load each only when the user navigates to that panel (no extra css loading).
	*/
	
	function admin_styles_campaigns(){
		wp_enqueue_style('popup-domination-campaigns-css');
	}
	
	function admin_styles_ab(){
		wp_enqueue_style('popup-domination-ab');
	}

	function admin_styles_fancybox(){
		wp_enqueue_style('fancybox');
	}
	function admin_styles_analytics(){
		wp_enqueue_style('popup-domination-anayltics');
	}
	function admin_styles_mailing(){
		wp_enqueue_style('popup-domination-mailing');
		wp_enqueue_style('fancybox');
	}
	function admin_styles_graphs(){
		wp_enqueue_style('the_graphs');
	}

	function admin_styles_theme_upload(){
		wp_enqueue_style('fileuploader');
	}
	function admin_styles_promote(){
		wp_enqueue_style('popup-domination-promote');
	}
	
	/**
	* admin_styles()
	*
	* Works out url in relation to wordpress and then decides which panel user is on a loads correct function for stylesheet.
	*/
	
	function admin_styles(){
		$this->opts_url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		foreach ($this->submenu as $t){
			$subpages[] = str_replace('popup-domination_page_popup-domination/','',$t);
		}
		$cururl  = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
		$tmp =  explode('admin.php?page=',$cururl);
		if(isset($tmp[1])){
			$temp2 = explode('/',$tmp[1]);
		}
		if(isset($temp2[1])){
			$temp =  explode('=',$temp2[1]);
		}
		if(isset($temp[0])){
			$this->curpage = $temp[0];
		}else{
			$this->curpage = '';
		}
		switch ($this->curpage) {
		    case 'campaigns':
		    	add_action('admin_print_styles', array(&$this, 'admin_styles_campaigns'));
		        break;
		    case 'analytics':
		    	add_action('admin_print_styles', array(&$this, 'admin_styles_analytics'));
		        break;
		    case 'a-btesting':
		    	add_action('admin_print_styles', array(&$this, 'admin_styles_campaigns'));
		        break;
		    case 'mailinglist':
		   		add_action('admin_print_styles', array(&$this, 'admin_styles_mailing'));
		        break;
		     case 'promote':
		     	add_action('admin_print_styles', array(&$this, 'admin_styles_promote'));
		        break;
		    case 'theme_upload':
		    	add_action('admin_print_styles', array(&$this, 'admin_styles_theme_upload'));
		        break;
		   	case 'campaigns&action':
		   		add_action('admin_print_styles', array(&$this, 'admin_styles_campaigns'));
		        break;
		   	case 'a-btesting&action':
		   		add_action('admin_print_styles', array(&$this, 'admin_styles_ab'));
		   		add_action('admin_print_styles', array(&$this, 'admin_styles_graphs'));
		        break;
		    case 'analytics&id':
		    	add_action('admin_print_styles', array(&$this, 'admin_styles_analytics'));
		    	add_action('admin_print_styles', array(&$this, 'admin_styles_graphs'));
		        break;
		    default:
		    	add_action('admin_print_styles', array(&$this, 'admin_styles_campaigns'));
		        break;
		}	
	}
	
	/**
	* installation_process()
	*
	* Encoded functionality for verifying the plugin.
	* Also contain encoded install code.
	*/
	
	function installation_process(){
		/*
		 * Decoded
		 */
		//${"\x47\x4c\x4fB\x41\x4cS"}["m\x70t\x68\x67\x67\x6d\x68"]="\x72\x65s\x70\x6f\x6e\x73\x65";${"\x47\x4c\x4fB\x41\x4c\x53"}["\x72\x69\x7atp\x6a\x79\x79\x75\x6d"]="ur\x6c";${"\x47\x4cO\x42ALS"}["\x69\x64\x76\x73\x78\x65\x71\x75\x6e\x62"]="\x61";${"\x47LO\x42\x41\x4c\x53"}["\x75\x6a\x62\x78\x69\x6fk\x72\x6e\x64e"]="t\x61\x62\x6c\x65_\x6ea\x6de";${"\x47L\x4f\x42AL\x53"}["\x74y\x76\x6b\x6be\x64"]="\x63h\x65ck";${"\x47\x4cO\x42\x41\x4c\x53"}["\x72u\x77ab\x62h"]="d\x65\x66\x61ul\x74\x73";${"\x47LO\x42\x41LS"}["dot\x65\x71k\x65\x75\x66"]="s\x71\x6c";${"G\x4c\x4f\x42A\x4c\x53"}["\x77f\x6bc\x73\x7av"]="sho\x77f\x6fr\x6d";$cbcghepqiw="\x69n\x73t\x61l\x6c";${"GL\x4fB\x41\x4c\x53"}["\x72\x74tu\x61\x72l\x77\x74\x61"]="\x69ns\x74all";${"\x47L\x4fBAL\x53"}["rt\x6ayt\x6f\x71\x76x\x67\x65\x79"]="\x73ho\x77\x66\x6frm";global$wpdb;${"\x47\x4cO\x42\x41LS"}["\x6b\x64la\x67\x77c\x65j"]="\x69";${${"\x47L\x4fB\x41\x4c\x53"}["\x72\x74\x6a\x79t\x6f\x71\x76\x78g\x65\x79"]}=true;${${"\x47\x4c\x4f\x42AL\x53"}["t\x79\x76k\x6be\x64"]}=${$cbcghepqiw}=false;${"\x47L\x4f\x42A\x4c\x53"}["e\x6a\x6f\x6cst\x6eo"]="\x74";$podqdbgwrqe="\x6b\x65\x79";${$podqdbgwrqe}="";if(isset($_POST["\x61ct\x69\x6f\x6e"])&&strtolower($_POST["act\x69\x6f\x6e"])=="\x63\x68e\x63k\x2d\x72ec\x65\x69\x70\x74"&&wp_verify_nonce($_POST["\x5fwpnonce"],"\x63\x68ec\x6b-r\x65\x63e\x69pt")){if(isset($_POST["\x72\x65\x63e\x69p\x74_\x6be\x79"])&&!empty($_POST["rec\x65\x69\x70t_\x6be\x79"])){$khcblctrp="\x6b\x65\x79";${"G\x4c\x4f\x42ALS"}["\x6e\x62\x73w\x6c\x79\x77\x75t"]="\x63\x68\x65c\x6b";$wxqgevmql="k\x65y";${$khcblctrp}=$_POST["\x72ece\x69\x70\x74\x5f\x6b\x65\x79"];if(${$wxqgevmql}=="P\x44TN\x4aC\x35\x54\x4d"){$jkjryntqd="s\x68\x6f\x77f\x6frm";${${"\x47\x4c\x4f\x42\x41\x4c\x53"}["r\x74tu\x61\x72\x6c\x77\x74\x61"]}=true;${$jkjryntqd}=false;}else{${${"\x47\x4c\x4f\x42\x41\x4cS"}["\x6d\x70t\x68\x67\x67\x6dh"]}="";${${"\x47L\x4fB\x41\x4cS"}["\x72\x69z\x74\x70\x6a\x79\x79\x75\x6d"]}="\x68\x74tp:\x2f\x2fpop\x75\x70domi\x6eati\x6fn.\x63\x6fm\x2fthan\x6bs-secu\x72\x65/\x63\x68e\x63k\x5fr\x65c\x65ipt.\x70\x68p\x3f\x72e\x63e\x69\x70\x74\x5f\x6b\x65\x79=".urlencode(base64_encode($_POST["r\x65c\x65ip\x74_\x6bey"]))."\x26\x76\x65\x72s\x69\x6fn=\x33&\x75r\x6c\x3d".urlencode(base64_encode($this->plugin_url))."\x26\x74ype\x3d\x70\x6c\x75\x67in";${"\x47L\x4f\x42\x41\x4c\x53"}["\x79u\x65\x71\x66\x6f\x6a\x62\x61\x67\x74"]="\x72\x65q";${"G\x4cO\x42\x41\x4c\x53"}["u\x62\x63\x68\x67f"]="c\x68\x65\x63\x6b";$pbmjzkwftbd="\x72\x65\x73pons\x65";${${"G\x4cOB\x41L\x53"}["yu\x65\x71\x66\x6fj\x62\x61\x67\x74"]}=new WP_Http();${"\x47\x4c\x4fBA\x4c\x53"}["\x74uxy\x79\x6b\x73\x68\x75u"]="\x72\x65\x73p\x6fn\x73e";${$pbmjzkwftbd}=$req->request(${${"GLO\x42\x41\x4c\x53"}["\x72i\x7a\x74\x70\x6ay\x79\x75m"]},array("\x74\x69me\x6fut"=>30));${${"\x47\x4c\x4f\x42\x41LS"}["\x6d\x70t\x68gg\x6d\x68"]}=isset(${${"\x47\x4c\x4f\x42\x41\x4c\x53"}["\x6d\x70\x74\x68\x67g\x6dh"]}["\x62\x6fd\x79"])?${${"\x47LO\x42\x41\x4c\x53"}["\x74\x75\x78\x79\x79\x6bs\x68\x75u"]}["\x62o\x64\x79"]:"";${${"\x47\x4c\x4fB\x41L\x53"}["\x75\x62\x63h\x67\x66"]}=true;}if(${${"\x47\x4cO\x42\x41LS"}["n\x62s\x77\x6c\x79\x77\x75\x74"]}){if(substr(${${"G\x4c\x4f\x42\x41\x4c\x53"}["\x6d\x70\x74h\x67\x67\x6d\x68"]},0,4)=="\x74\x72ue"){$cfzagrfzgc="i\x6e\x73ta\x6c\x6c";$icpmuwavwiq="\x73\x68\x6fwf\x6frm";${$icpmuwavwiq}=false;${$cfzagrfzgc}=true;}}if(${${"\x47LOBAL\x53"}["r\x74\x74\x75a\x72l\x77\x74\x61"]}){${"\x47\x4c\x4f\x42\x41\x4c\x53"}["\x6aru\x77a\x66\x78"]="\x74a\x62\x6ce";${"\x47LO\x42AL\x53"}["\x76\x7a\x66c\x71\x62n\x78\x6a"]="\x69";${"\x47\x4c\x4fB\x41L\x53"}["\x71\x72\x6b\x6d\x62\x65\x79\x6b\x65c"]="\x64\x65\x66\x61ult\x73";$dgsflhhhlj="\x62";${${"\x47\x4c\x4f\x42\x41LS"}["\x71\x72k\x6d\x62\x65y\x6b\x65c"]}=array("\x74\x65\x6dpl\x61te"=>"\x6cig\x68tb\x6f\x78","\x63\x6fl\x6f\x72"=>"blue","cook\x69\x65_t\x69me"=>7,"de\x6c\x61\x79"=>0,"bu\x74to\x6e\x5f\x63\x6fl\x6fr"=>"r\x65d","s\x68o\x77"=>serialize(array("\x65ver\x79\x77\x68\x65\x72\x65"=>"\x59")),"s\x68ow_\x6fpt"=>"ope\x6e","\x75n\x6c\x6f\x61\x64\x5f\x6ds\x67"=>"\x57ou\x6c\x64 you like\x20\x74\x6f\x20\x73\x69gnup\x20\x74\x6f\x20\x74he\x20\x6ee\x77\x73\x6ce\x74\x74er\x20\x62\x65f\x6f\x72\x65 y\x6fu \x67\x6f\x3f","\x69m\x70r\x65\x73s\x69\x6f\x6e\x5fc\x6f\x75n\x74"=>0,"ne\x77\x5f\x77i\x6e\x64ow"=>"\x4e","\x70\x72\x6f\x6d\x6ft\x65"=>"Y","\x69nstal\x6ce\x64"=>"\x59","v\x33\x69\x6e\x73\x74a\x6cl\x65\x64"=>"\x59",);foreach(${${"\x47\x4c\x4f\x42A\x4c\x53"}["ru\x77ab\x62\x68"]} as${${"\x47L\x4f\x42\x41\x4c\x53"}["\x69\x64\x76s\x78\x65\x71\x75\x6e\x62"]}=>${$dgsflhhhlj}){$juiwwfkrsi="\x62";$jedymrynu="\x61";if(!$this->option(${$jedymrynu}))$this->update(${${"\x47\x4c\x4f\x42\x41\x4cS"}["\x69\x64\x76s\x78\x65\x71\x75\x6e\x62"]},${$juiwwfkrsi});}${${"G\x4cO\x42AL\x53"}["\x75\x6a\x62x\x69\x6f\x6b\x72\x6e\x64\x65"]}=array("0"=>$wpdb->prefix."po\x70dom\x5f\x61\x62","1"=>$wpdb->prefix."\x70\x6fpdo\x6d_an\x61\x6cy\x74i\x63s","2"=>$wpdb->prefix."po\x70dom_\x63\x61m\x70\x61i\x67n\x73");${"\x47\x4c\x4f\x42AL\x53"}["\x75\x6fef\x6dvqzp"]="\x74\x61\x62le\x5fnam\x65";${${"G\x4c\x4f\x42\x41\x4c\x53"}["\x6a\x72uw\x61f\x78"]}=array("0"=>"(\n\t\t\t\t\t\t\x20\x20id \x69\x6e\x74(2\x35)\x20NOT\x20NU\x4cL \x41U\x54\x4f_I\x4eCR\x45\x4d\x45\x4eT\x2c\n\t\t\t\t\t\t\x20 \x63\x61mpai\x67n\x73\x20\x6c\x6f\x6egtex\x74 NO\x54\x20\x4eULL,\n\t\t\t\t\t\t\x20 \x73che\x64u\x6c\x65\x20\x6congtext\x20NO\x54 \x4e\x55LL,\n\t\t\t\t\t\t  \x61bsett\x69n\x67\x73 lon\x67\x74\x65x\x74\x20N\x4fT\x20\x4eU\x4cL,\n\t\t\t\t\t\t\x20\x20as\x74\x61ts \x6con\x67t\x65x\x74 NOT \x4e\x55L\x4c,\n\t\t\t\t\t\t\x20 r\x61t\x69n\x67 V\x41R\x43\x48\x41R(55)\x20\x44\x45F\x41U\x4c\x54 \x27'\x20\x4eOT N\x55\x4c\x4c\x2c\n\t\t\t\t\t\t\x20 \x6e\x61\x6de V\x41R\x43\x48\x41\x52\x2855\x29\x20D\x45\x46A\x55\x4c\x54\x20'\x27 N\x4fT NULL\x2c\n\t\t\t\t\t\t\x20 \x60d\x65\x73cri\x70t\x69\x6f\x6e\x60 \x6con\x67\x74\x65x\x74 N\x4fT N\x55\x4cL,\n\t\t\t\t\t\t \x20\x55\x4eI\x51UE\x20KEY \x69d\x20\x28id\x29\n\t\t\t\t\t\t);","1"=>"\x28\n\t\t\t\t\t\t\x20 \x69d\x20in\x74(\x32\x35\x29 \x4eOT \x4eULL\x20\x41\x55\x54O\x5fI\x4eC\x52EM\x45\x4e\x54\x2c\n\t\t\t\t\t\t \x20\x63\x61mp\x6ea\x6d\x65 l\x6fn\x67\x74e\x78\x74\x20\x4e\x4f\x54\x20NU\x4cL\x2c\n\t\t\t\t\t\t\x20\x20vi\x65ws \x49\x4e\x54(\x32\x35\x29 \x4e\x4f\x54\x20\x4eULL,\n\t\t\t\t\t\t  \x63\x6f\x6e\x76\x65r\x73io\x6e\x73 \x49N\x54\x282\x35\x29\x20\x4eO\x54\x20N\x55\x4cL,\n\t\t\t\t\t\t \x20\x72\x61\x74i\x6e\x67\x20\x49N\x54\x2825)\x20N\x4fT N\x55L\x4c\x2c\n\t\t\t\t\t\t  p\x72e\x76i\x6fu\x73\x64a\x74\x61\x20\x6cong\x74\x65\x78t N\x4f\x54 \x4e\x55L\x4c,\n\t\t\t\t\t\t\x20 \x55\x4eIQUE KEY id (i\x64\x29\n\t\t\t\t\t\t\x29\x3b","\x32"=>"(\n\t\t\t\t\t\t\x20\x20i\x64\x20\x69\x6e\x74\x282\x35)\x20\x4eOT NULL A\x55T\x4f\x5f\x49\x4e\x43\x52EME\x4eT,\n\t\t\t\t\t\t \x20c\x61mp\x61ign \x56AR\x43\x48\x41R\x2855\x29 \x44E\x46A\x55LT\x20\x27' NO\x54 \x4e\x55\x4c\x4c\x2c\n\t\t\t\t\t\t\x20\x20\x64\x61\x74\x61 \x6co\x6egt\x65x\x74 NOT\x20NU\x4cL,\n\t\t\t\t\t\t\x20 \x70ag\x65\x73 \x6co\x6egt\x65\x78t\x20\x4eOT N\x55L\x4c\x2c\n\t\t\t\t\t\t\x20\x20\x60des\x63\x60\x20\x6c\x6f\x6e\x67text NO\x54 N\x55L\x4c,\n\t\t\t\t\t\t\x20 \x55N\x49QUE \x4b\x45\x59\x20\x69\x64\x20(i\x64\x29\n\t\t\t\t\t\t\x29\x3b");${"\x47\x4c\x4f\x42ALS"}["e\x78n\x65a\x63\x64\x63s"]="\x74";${${"G\x4c\x4f\x42\x41\x4cS"}["\x76\x7a\x66\x63\x71\x62\x6exj"]}=0;foreach(${${"\x47\x4c\x4f\x42\x41L\x53"}["\x75\x6fe\x66m\x76q\x7ap"]} as${${"\x47\x4cOB\x41\x4c\x53"}["\x65\x78ne\x61cd\x63s"]}){$wfjqvnwot="t\x61\x62\x6ce";${${"\x47\x4cO\x42\x41\x4c\x53"}["\x64\x6ft\x65q\x6b\x65\x75\x66"]}="CREA\x54\x45 T\x41BLE\x20I\x46 N\x4fT EX\x49STS\x20".${${"\x47\x4cO\x42A\x4c\x53"}["\x65\x6aolst\x6eo"]}.${$wfjqvnwot}[${${"\x47\x4cOB\x41\x4c\x53"}["\x6bd\x6cag\x77cej"]}];${"\x47\x4cO\x42\x41\x4cS"}["\x6b\x78\x6bi\x70dlny"]="\x69";$djrlriqyyf="\x73q\x6c";require_once(ABSPATH."\x77p\x2d\x61\x64mi\x6e\x2f\x69\x6ecl\x75\x64es\x2fupg\x72ade\x2eph\x70");dbDelta(${$djrlriqyyf});${${"G\x4cO\x42\x41\x4c\x53"}["kx\x6bip\x64l\x6ey"]}++;}include("\x74\x70\x6c/in\x73tall\x5ff\x69\x6ei\x73h.p\x68p");}else{echo"<div cl\x61s\x73=\"\x75\x70\x64at\x65\x64\"\x3e\x3cp>T\x68e \x6fr\x64er\x20n\x75\x6d\x62\x65\x72 you \x65n\x74\x65\x72ed \x69s i\x6ev\x61l\x69\x64\x2e Please\x20c\x6f\x6e\x74\x61c\x74\x20su\x70p\x6frt.<\x2fp\x3e</div\x3e";}}}if(${${"\x47LO\x42\x41L\x53"}["\x77\x66\x6b\x63\x73\x7av"]}===true){include("\x74\x70l\x2fin\x73tal\x6c_st\x61\x72t\x2e\x70\x68p");}
						global $wpdb;
						$showform=true;
						$check=$install=false;
						$key="";
						if(isset($_POST["action"]) && strtolower($_POST["action"])=="check-receipt" && wp_verify_nonce($_POST["_wpnonce"],"check-receipt")){
							if(isset($_POST["receipt_key"]) && !empty($_POST["receipt_key"])){
								$key=$_POST["receipt_key"];
								if($key=="PDTNJC5TM"){
									$install=true;
									$showform=false;
								}else{
									$response="";
									$url="http://popupdomination.com/thanks-secure/check_receipt.php?receipt_key=".urlencode(base64_encode($_POST["receipt_key"]))."&version=3&url=".urlencode(base64_encode($this->plugin_url))."&type=plugin";
									$req=new WP_Http();
									$response=$req->request($url,array("timeout"=>30));
									$response=isset($response["body"])?$response["body"]:"";
									$check=true;
								}
								if($check){
									if(substr($response,0,4)=="true"){
										$showform=false;
										$install=true;
									} else {
										$showform=false;
										$install=true;
									}
								}
								if($install){
									$defaults=array("template"=>"lightbox","color"=>"blue","cookie_time"=>7,"delay"=>0,"button_color"=>"red","show"=>serialize(array("everywhere"=>"Y")),"show_opt"=>"open","unload_msg"=>"Would you like to signup to the newsletter before you go?","impression_count"=>0,"new_window"=>"N","promote"=>"Y","installed"=>"Y","v3installed"=>"Y");
									foreach($defaults as$a=>$b){if(!$this->option($a))$this->update($a,$b);}$table_name=array("0"=>$wpdb->prefix."popdom_ab","1"=>$wpdb->prefix."popdom_analytics","2"=>$wpdb->prefix."popdom_campaigns");$table=array("0"=>"(\n\t\t\t\t\t\t  id int(25) NOT NULL AUTO_INCREMENT,\n\t\t\t\t\t\t  campaigns longtext NOT NULL,\n\t\t\t\t\t\t  schedule longtext NOT NULL,\n\t\t\t\t\t\t  absettings longtext NOT NULL,\n\t\t\t\t\t\t  astats longtext NOT NULL,\n\t\t\t\t\t\t  rating VARCHAR(55) DEFAULT '' NOT NULL,\n\t\t\t\t\t\t  name VARCHAR(55) DEFAULT '' NOT NULL,\n\t\t\t\t\t\t  `description` longtext NOT NULL,\n\t\t\t\t\t\t  UNIQUE KEY id (id)\n\t\t\t\t\t\t);","1"=>"(\n\t\t\t\t\t\t  id int(25) NOT NULL AUTO_INCREMENT,\n\t\t\t\t\t\t  campname longtext NOT NULL,\n\t\t\t\t\t\t  views INT(25) NOT NULL,\n\t\t\t\t\t\t  conversions INT(25) NOT NULL,\n\t\t\t\t\t\t  rating INT(25) NOT NULL,\n\t\t\t\t\t\t  previousdata longtext NOT NULL,\n\t\t\t\t\t\t  UNIQUE KEY id (id)\n\t\t\t\t\t\t);","2"=>"(\n\t\t\t\t\t\t  id int(25) NOT NULL AUTO_INCREMENT,\n\t\t\t\t\t\t  campaign VARCHAR(55) DEFAULT '' NOT NULL,\n\t\t\t\t\t\t  data longtext NOT NULL,\n\t\t\t\t\t\t  pages longtext NOT NULL,\n\t\t\t\t\t\t  `desc` longtext NOT NULL,\n\t\t\t\t\t\t  UNIQUE KEY id (id)\n\t\t\t\t\t\t);");
									$i=0;
									foreach($table_name as $t){
										$sql="CREATE TABLE IF NOT EXISTS ".$t.$table[$i];
										require_once(ABSPATH."wp-admin/includes/upgrade.php");
										dbDelta($sql);
										$i++;
									}
									include("tpl/install_finish.php");
								}else{
									echo"<div class=\"updated\"><p>The order number you entered is invalid. Please contact support.</p></div>";
								}
							}
						}
						if($showform===true){include("tpl/install_start.php");}					
	
	}
	
	/**
	* get_mailing_list()
	*
	* Ajax triggered. Grabs PHP which loads another file depending on selected provider.
	*/
	
	function get_mailing_list(){
		include $this->plugin_path.'inc/provider.php';
		die();
	}
	
	/**
	* promote_settings()
	*
	* Ajax triggered. Grabs PHP which loads another file depending on selected provider.
	*/
	
	function promote_settings(){
		$success = false;
		if(isset($_POST['update'])){
			$popdom = $_POST['popup_domination'];
			$this->update('promote', $popdom['promote'],false);
			$this->update('clickbank', $popdom['clickbank'],false);
			$success = true;
		}
		$this->option('promote');
		if($promote = $this->option('promote')){
			if($promote == 'Y'){
				$clickbank = $this->option('clickbank');
			}
		} else {
			$promote = 'N';
		}
		if(isset($prev['promote'])){
			$promote = $prev['promote'];
			if($promote == 'Y'){
				$clickbank = (isset($prev['clickbank']))?$prev['clickbank']:'';
			}
		} else {
			$promote = 'N';
		}
		include $this->plugin_path.'tpl/promote_panel.php';
	}
	
	/**
	* load_abtesting()
	*
	* Loads list of A/B Campaigns in the A/B Split initial Admin panel.
	*/
	
	function load_abtesting(){
		$data = $this->get_db('popdom_ab');
		$this->abcamp = $data;
		foreach($data as $d){
			$temp = unserialize($d->campaigns);
			foreach($temp as $t){
				$camps = $this->get_db('popdom_campaigns', 'campaign = "'.$t.'"');
				$tmp = unserialize($camps[0]->data);
				$camp[] = $t;
				$temppreview = $tmp['template']['template'];
				$temppreviewcolor = $tmp['template']['color'];
				$temppreviewcolor = strtolower($temppreviewcolor);
				$temppreviewcolor = str_replace(' ','-',$temppreviewcolor);
				$tempname[$d->id][$t] = $temppreview;
				$previewurl[$d->id][$t] = $this->theme_url.$temppreview.'/previews/'.$temppreviewcolor.'.jpg';
				if($prevsize[$d->id] = @getimagesize($previewurl[$d->id])){
					$prevsize[$d->id] = getimagesize($previewurl[$d->id]);
					$height[$d->id] = ($prevsize[$d->id][1])/1.1;
					$width[$d->id] = ($prevsize[$d->id][0])/1.1;
				}else{
					$height[$d->id] = '';
					$width[$d->id] = '';
				}
			}
		}
		include $this->plugin_path.'tpl/list_ab.php';
	}
	
	/**
	* load_abtesting()
	*
	* Loads all settings needed for the A/B Split Campaign setup.
	* Also comtains functionality for saving the settings in these panels.
	*/
	
	function load_absettings(){
		$success = false;
		$this->newcampid = false;
		if(isset($_POST['update'])){
			$ab['name'] = stripslashes($_POST['campname']);
			$ab['desc'] = stripslashes($_POST['campaigndesc']);
			$pages = $_POST['popup_domination_show'];
			if(isset($_POST['trafficamount'])){
				$trafficamount = $_POST['trafficamount'];
			}else{
				$trafficamount = 0;
			}
			$ab['name'];
			$data = $this->get_db('popdom_ab','name = "'.$ab['name'].'"');
			$ab['campaigns'] = serialize($_POST['campaign']);
			$ab['show'] = serialize($pages);
			$ab['settings'] = serialize(array('visitsplit' => $_POST['numbervisitsplit'], 'page' => $_POST['conversionpage'], 'traffic' => $trafficamount));
			if(isset($_GET['id'])){
				$camp_id = $_GET['id'];
			}else{
				$camp_id = $this->newcampid;
			}
			if(empty($data)){
				$save = $this->write_db('popdom_ab',array('campaigns'=> $ab['campaigns'], 'schedule' => $ab['show'], 'absettings' => $ab['settings'], 'name' => $ab['name'], 'description' => $ab['desc']),array('%s', '%s', '%s', '%s', '%s'));
			}else{
				$save = $this->write_db('popdom_ab',array('campaigns'=> $ab['campaigns'], 'schedule' => $ab['show'], 'absettings' => $ab['settings'], 'name' => $ab['name'], 'description' => $ab['desc']),array('%s', '%s', '%s', '%s'), true, array('id' => $camp_id), array('%d'));
				if(isset($pages['everywhere']) && $pages['everywhere'] = 'Y'){
					$save = $this->write_db('popdom_ab',array('everywhere' => 'Y'), array('%s'), true, array('id' => $camp_id), array('%d'));
				}else{
					$save = $this->write_db('popdom_ab',array('everywhere' => 'N'), array('%s'), true, array('id' => $camp_id), array('%d'));
				}
			}
			$success = true;
		}
		if(isset($_GET['id']) || $this->newcampid != ''){
			if(isset($_GET['id'])){
				$camp_id = $_GET['id'];
			}else{
				$camp_id = $this->newcampid;
				$url = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
				$url = explode('action=create',$url);
				//print_r($url);
				$furl = $url[0].'action=edit&id='.$this->newcampid.'&message=1';
				echo '<script>window.location.href="'.$furl.'"</script>';
			}
			if(isset($_GET['message'])){
				$this->update_msg = 'Settings saved.';
			}
			$data = $this->get_db('popdom_ab','id = '.$camp_id);
			$split['campaigns'] = unserialize($data[0]->campaigns);
			$split['schedule'] = unserialize($data[0]->schedule);
			$split['absettings'] = unserialize($data[0]->absettings);
			$split['results'] = unserialize($data[0]->astats);
			$visitsplit = $split['absettings']['visitsplit'];
			$page = $split['absettings']['page'];
			$traffic = $split['absettings']['traffic'];
			$name = $data[0]->name;
			$desc = $data[0]->description;
			if(!empty($split['results'])){
				$keys = array_keys($split['results']);
				foreach($keys as $k){
					$campname[] = $this->get_db('popdom_campaigns','id = "'.$k.'"','campaign');
				}
			}else{
				$keys = array();
				$campname = array();
			}
			
		}else{
			$data = array();
			$split['campaigns'] = false;
			$split['schedule'] = '';
			$split['absettings'] = '';
			$visitsplit = '';
			$page = '';
			$traffic = '';
		}
		$campdata = $this->get_db('popdom_campaigns', NULL, 'campaign');
		
		$this->abcamp = $data;
		include $this->plugin_path.'tpl/ab_panel.php';
	}
	
	/**
	* mailing_settings()
	*
	* Loads and saves all the data for the Mailing List Manager panels.
	*/
	
	function mailing_settings(){
		$success = false;
		if(isset($_POST['update'])){
			$mailingdata = $_POST;
			
			$arr = array('provider','password','apikey','apiextra','password', 'username', 'listsid', 'customf', 'custom1', 'custom2', 'cc_custom1', 'cc_custom2','listname','redirecturl', 'disable_name');			
			foreach($arr as $a){
				if(isset($_POST[$a])){
					$data[$a] = $_POST[$a];
				}
			}
			if(isset($mailingdata['disable_name']) && !empty($mailingdata['disable_name']) && $mailingdata['disable_name'] == 'on'){
				$data['disable_name'] = 'Y';
			}else{
				$data['disable_name'] = 'N';
			}
			
			if(empty($data['listsid']) || !isset($data['listsid'])){
				if(isset($_POST['oldlistid']) && !empty($_POST['oldlistid'])){
					$data['listsid'] = $_POST['oldlistid'];
				}
			}
			
			$this->update('formapi', base64_encode(serialize($data)), false);
			$this->update('formhtml', '', false);
			
			if(!empty($data['redirecturl'])){
				if(!empty($mailingdata['redirecturl'])){
					$this->update('redirecturl', $mailingdata['redirecturl']);
					$this->update('redirectcheck', 'Y');
				}else{
					$this->update('redirecturl', '', false);
					$this->update('redirectcheck', 'N');
				}
			}else{
				$this->update('redirecturl', '', false);
				$this->update('redirectcheck', 'N');
			}
			$success = true;
		}else{	
			if(isset($_POST['customformsubmit'])){
				$customform = $_POST;
				if(isset($customform['popup_domination']['action'])){
					$this->update('action', $customform['popup_domination']['action'], false);
				}else{
					$this->update('action', '', false);
				}
				if(isset($customform['popup_domination']['name_box'])){
					$this->update('name_box', $this->encode2($customform['popup_domination']['name_box']), false);
				}else{
					$this->update('name_box', '', false);
				}
				if(isset($customform['popup_domination']['email_box'])){
					$this->update('email_box', $customform['popup_domination']['email_box'], false);
				}else{
					$this->update('email_box', '', false);
				}
				if(isset($customform['popup_domination']['custom1_box'])){
					$this->update('custom1_box', $customform['popup_domination']['custom1_box'], false);
				}else{
					$this->update('custom1_box', '', false);
				}
				if(isset($customform['popup_domination']['custom2_box'])){
					$this->update('custom2_box', $customform['popup_domination']['custom2_box'], false);
				}else{
					$this->update('custom2_box', '', false);
				}
				if(isset($customform['popup_domination']['formhtml'])){
					$this->update('formhtml', $this->encode2($customform['popup_domination']['formhtml']), false);
				}else{
					$this->update('formhtml', '', false);
				}
				if(isset($customform['popup_domination']['hidden_fields'])){
					$this->update('hidden_fields', $this->encode2($customform['popup_domination']['hidden_fields']), false);
				}else{
					$this->update('hidden_fields', '', false);
				}
				
				if(isset($customform['popup_domination']['new_window'])){
					$this->update('new_window', $customform['popup_domination']['new_window'], false);
				}else{
					$this->update('new_window', 'N', false);
				}
				if(isset($customform['popup_domination']['disable_name'])){
					$this->update('disable_name', $customform['popup_domination']['disable_name'], false);
				}else{
					$this->update('disable_name', 'N', false);
				}
				$data['provider'] = 'form';
				$this->update('formapi', base64_encode(serialize($data)), false);
			}
		}
		
		$formhtml = $this->option('formhtml', false);
		if(empty($formhtml)){
			$apidata = $this->option('formapi');
			$apidata = unserialize(base64_decode($apidata));
			
			$formhtml = '';
		}else{
			$form = $this->input_val($formhtml);
			$name_box =  $this->option('name_box');
			$email_box = $this->option('email_box');
			$custom1_box = $this->option('custom1_box');
			$custom2_box = $this->option('custom2_box');
			$apidata = '';
		}
		$redirecturl = $this->option('redirecturl');
		$redirectcheck = $this->option('redirectcheck');
		$this->update_msg = 'Settings saved.';
		
		if(!isset($campaignid)){
			$campaignid = '';	
		}
		if(!isset($name_box)){
			$name_box = '';	
		}
		if(!isset($email_box)){
			$email_box = '';	
		}

				
		include $this->plugin_path.'tpl/mailing_panel.php';
	}
	
	/**
	* save_options()
	*
	* Saves all the data set in the Campaign Panels.
	*/
	
	function save_options(){
		$superupdate = array();

		$update = $_POST['popup_domination'];
		$updatesch = $_POST['popup_domination_show'];
				
		if(!isset($_POST['campaignid'])){$campaignid = '0';}else{$campaignid = $_POST['campaignid'];};
		if(isset($update['custom_fields'])){
			$this->custominputs = $update['custom_fields'];
		}else{
			$this->custominputs = "";
		}
		$tmparr = array('template', 'color', 'button_color');		
		$fieldsarr = array();
		$tmpsch = array('cookie_time','delay','unload_msg', 'impression_count', 'show_opt', 'top_animate', 'top_delay');
		$tmparr2 = array('clickbank' => $this->option('clickbank'), 'disable_name' => 'N', 
						 'unload_msg' => $this->option('unload_msg'), 'new_window' => 'N');
		$arr = array();
		$arrt = array();
		foreach($tmparr as $t){
			if(!isset($update[$t])){
				$update[$t] = '';
				if(isset($tmparr2[$t]) && $tmparr2[$t])
					$update[$t] = $tmparr2[$t];
			}
			$arr[$t] = strtolower(stripslashes($update[$t]));
			
			$arr[$t] = str_replace(' ','-',$arr[$t]);
			
		}
		
		$extra_fields = $this->update('custom_fields', $_POST['extra_fields'] ,false);
		
		$superupdate['num_cus'] = str_replace (" ", "", $_POST['extra_fields']); 
				
		if(empty($arr['color'])){
			$arr['color'] = 'blue';
		}
		if(empty($arr['template'])){
			$arr['template'] = 'lightbox';
		}
		if(empty($arr['button_color'])){
			$arr['button_color'] = 'blue';
		}
		
		foreach($tmpsch as $t){
			if(!isset($update[$t])){
				$update[$t] = '';
				if(isset($tmparr2[$t]) && $tmparr2[$t])
					$update[$t] = $tmparr2[$t];
			}
			$arrsch[$t] = stripslashes($update[$t]);
		}
		$t = $this->get_theme_info($update['template']);
		if(isset($t['fields']) && count($t['fields']) > 0 && isset($_POST['popup_domination_fields'])){
			foreach($t['fields'] as $f){
				$arrt['field_'.$f['field_opts']['id']] = stripslashes($_POST['popup_domination_fields'][$f['field_opts']['id']]);
			}
		}
		
		$campname = stripslashes($_POST['campname']);
		$campdesc = stripslashes($_POST['campaigndesc']);
		
		foreach($arr as $a => $b){
			$superupdate['template'][$a] = $b;
		}
		foreach($arrsch as $a => $b){
			$superupdate['schedule'][$a] = $b;
		}
		foreach($updatesch as $a => $b){
			$superupdate['pages'][$a] = $b;
			$pages[$a] = $b;
		}
		
		foreach($arrt as $c => $d){
			$chk = ($c=='field_video-embed');
			$b = ($chk?$this->encode2($d):$d);
			$superupdate['fields'][$c] = $d;
		}		
		$fields = array();
		if(isset($_POST['field_name']) && isset($_POST['field_vals']) && count($_POST['field_name']) == count($_POST['field_vals'])){
			$fl = count($_POST['field_name']);
			for($i=0;$i<$fl;$i++){
				if(!empty($_POST['field_name'][$i])){
					$fields[$_POST['field_name'][$i]] = $_POST['field_vals'][$i];
				}
			}
		}

		$images = array();
		if(isset($_POST['field_img']) && count($_POST['field_img'])){
			$img = $_POST['field_img'];
			$fl = count($img);
			for($i=0;$i<$fl;$i++){
				if(!empty($img[$i])){
					$images[] = $img[$i];
				}
			}
		}
		$superupdate['images'] = $images;
		
		$list = array();
		if(isset($_POST['list_item']) && count($_POST['list_item']) > 0){
			foreach($_POST['list_item'] as $l){
				$list[] = stripslashes($l);
			}
		}
		$superupdate['list'] = $list;	
		$show = array(); $origshow = $this->show_var();
		if(isset($_POST['popup_domination_show'])){
			$sch = $_POST['popup_domination_show'];
			if(isset($sch['everywhere'])){
				$show['everywhere'] = 'Y';
				if(!isset($origshow['everywhere']) || $origshow['everywhere'] != 'Y'){
					$this->update('show_backup',serialize($origshow),false);
					$superupdate[] = $origshow;	
				}
			} else {
				$this->update('show_backup',serialize($origshow),false);
				$superupdate[] = $origshow;	
			}
			if(isset($sch['front']))
				$show['front'] = 'Y';
			$show['pageid'] = array();
			if(isset($sch['pageid']) && is_array($sch['pageid'])){
				foreach($sch['pageid'] as $s)
					$show['pageid'][] = $s;
			}
			$show['catid'] = array();
			if(isset($sch['catid']) && is_array($sch['catid'])){
				foreach($sch['catid'] as $s)
					$show['catid'][] = $s;
			}
			$show['caton'] = $sch['caton'];
		}
		$superupdate['show'] = $show;
		
		if(isset($superupdate['fields']['field_fb-sec']) && !empty($superupdate['fields']['field_fb-sec']) && isset($superupdate['fields']['field_fb-id']) && !empty($superupdate['fields']['field_fb-id'])){
			$this->update('facebook_enabled','Y');
			$this->update('facebook_sec', $superupdate['fields']['field_fb-sec']);
			$this->update('facebook_id', $superupdate['fields']['field_fb-id']);
		}else{
			$this->update('facebook_enabled','N');
		}
		$superupdate = serialize($superupdate);
		$qpage = $pages;
		$pages = serialize($pages);

		$check = $this->get_db('popdom_campaigns','id = '.$campaignid);
		$oldname = $check[0]->campaign;
		
		if(empty($check)){
			$save = $this->write_db('popdom_campaigns',array('campaign'=> $campname, 'data' => $superupdate, 'pages' => $pages, 'desc' => $campdesc),array('%s', '%s', '%s'));
		}else{
			$save = $this->write_db('popdom_campaigns',array('campaign'=> $campname, 'data' => $superupdate, 'pages' => $pages, 'desc' => $campdesc),array('%s', '%s', '%s'),true, array('id' => $campaignid), array('%d'));
			if(isset($qpage['everywhere']) && $qpage['everywhere'] = 'Y'){
				$save = $this->write_db('popdom_campaigns',array('everywhere' => 'Y'),array('%s'),true, array('id' => $campaignid), array('%d'));
			}else{
				$save = $this->write_db('popdom_campaigns',array('everywhere' => 'N'),array('%s'),true, array('id' => $campaignid), array('%d'));
			}
			if($oldname != $campname){
				$save = $this->write_db('popdom_analytics',array('campname'=> $campname,),array('%s'),true, array('campname' => $oldname), array('%s'));
			}
		}
		
		if(empty($campaignid)){
			$this->newcampid = $this->newcampid;
		}else{
			$this->newcampid = $campaignid;
		}
		$success = true;
	}
	
	/**
	* load_settings()
	*
	* Loads all the data for creating and editing campaigns.
	*/
	
	function load_settings(){
		$templates = $this->get_themes();
		if(isset($_GET['id'])){
			/**
			* If we are editing an existing campaign
			*/
			$camp_id = $_GET['id'];
			$data = $this->get_db('popdom_campaigns','id = '.$camp_id);
			$campaignid = $data[0]->id;
			$campaign = unserialize($data[0]->data);
			$this->campaigndata = $campaign;
			$campname = $data[0]->campaign;
			$val = $campaign;
			$valtemp = $campaign['template']['template'];
			$valc = $campaign['template']['color'];
			$valbuttonc = $campaign['template']['button_color'];
			$campdesc = htmlspecialchars($data[0]->desc);
		}else if($this->newcampid != ''){
			/**
			* If we have just saved a new campaingn and are returning to the screen.
			*/
			$camp_id = $this->newcampid;
			$data = $this->get_db('popdom_campaigns','id = '.$camp_id);
			$campaignid = $data[0]->id;
			$campaign = unserialize($data[0]->data);
			$this->campaigndata = $campaign;
			$campname = $data[0]->campaign;
			$campdesc = htmlspecialchars($data[0]->desc);
			$val = $campaign;
			$valtemp = $campaign['template']['template'];
			$valc = $campaign['template']['color'];
			$valbuttonc = $campaign['template']['button_color'];
		}else{
			/**
			* If it's a new campaign
			*/
			$valtemp = 'lightbox';
			$valc = 'blue';
			$valbuttonc = 'blue';
			$this->campaigndata = '';
			$campaignid = '';
			$val = '';
			$campaign = array('fields' => '','images' => '','list' => '');
		}
		/**
		* Now we start the complex process of creating the JSON that creates all the fields in the admin panel.
		*
		* This allows the fields to change depending on which templates has been selected in the drop down.
		*/	
		$js = '{'; $opts = $opts2 = $field_str = $cur_preview = ''; $numfields = $counter = 0; 
		$cur_theme = $cur_size = array();
		foreach($templates as $t){
				$selected = false;
				if($t['theme'] == $valtemp){
					$selected = true;
					if(isset($t['colors'])){
						foreach($t['colors'] as $c){
							$selected2 = false;
							$valc = strtolower($valc);
							$valc = str_replace(' ','-',$valc);
							if($valc == $c['info'][0]){
								$selected2 = true;
								$cur_preview = (isset($c['info'][2])) ? $c['info'][2] : '';
								if(isset($t['size']))
									$cur_size = $t['size'];
							}
							$opts2 .= '<option class="'.$c['info'][0].'" '.(($valc == $c['info'][0])?' selected="selected" ':'').'>'.$c['name'].'</option>';
						}
					}else if(isset($t['img'])){
						$cur_preview = $t['img'];
					}
				}
				$opts .= '<option value="'.$t['theme'].'"'.(($t['theme']==$valtemp)?' selected="selected"':'').'>'.$t['name'].'</option>';
				$js .= (($counter>0)?',':'').'"'.$t['theme'].'":{';
				if(count($t['colors']) > 0){
					$js .= '"colors":[';
					$count = 0;
					foreach($t['colors'] as $c){
						$js .= (($count > 0)?',':'').'{"name":"'.$this->input_val($c['name']).'","options":["'.$this->input_val($c['info'][0]).'","'.$this->input_val($c['info'][1]).'"]'.((isset($c['info'][2]))?',"preview":"'.$this->input_val($c['info'][2]).'"':'').'}';
						$count++;
					}
					$js .= '],';
				} elseif(isset($t['img'])){
					$js .= '"preview_image":"'.$t['img'].'",';				
				}
				if(isset($t['button_colors']) && count($t['button_colors']) > 0){
					$js .= '"button_colors":[';
					$count = 0;
					foreach($t['button_colors'] as $c){
						$js .= (($count>0)?',':'').'{"name":"'.$c['name'].'","color_id":"'.$c['color_id'].'"}';
						$count++;
					}
					$js .= '],';
				}
				if(isset($t['fields']) && is_array($t['fields']) && count($t['fields']) > 0){
					$js .= '"fields":[';
					$count = 0;
					foreach($t['fields'] as $f){
						$type = 'text';
						if(isset($f['field_opts']['type'])){
							$type = $f['field_opts']['type'];
						}
						$tmp = array('"type":"'.$type.'"');
						if($selected){
							$field_str .= '<p id="popup_domination_field_'.$f['field_opts']['id'].'">';
							$fieldid = 'popup_domination_field_'.$f['field_opts']['id'].'_field';
							$field_str .= '<label for="'.$fieldid.'">'.$f['name'].'</label><span class="line">&nbsp;</span>';
							if(!$val){
								$val = ((isset($f['field_opts']['default_val']))?$f['field_opts']['default_val']:'');
								if(isset($campaign['fields']['field_'.$f['field_opts']['id']])){
									$val = $campaign['fields']['field_'.$f['field_opts']['id']];
								}else{
									$val = '';
								}
							}else{
								if(isset($campaign['fields']['field_'.$f['field_opts']['id']])){
									$val = $campaign['fields']['field_'.$f['field_opts']['id']];
								}else{
									$val = '';
								}
							}
							switch($type){
								case 'textarea':
									$field_str .= '<textarea cols="60" rows="5" name="popup_domination_fields['.$f['field_opts']['id'].']" id="'.$fieldid.'">'.$this->input_val($val).'</textarea><br/>'.$this->maxlength_txt($f,$val);
									break;
								case 'image':
									$field_str .= '<input type="text"  name="popup_domination_fields['.$f['field_opts']['id'].']" id="popup_domination_field_'.$f['field_opts']['id'].'_field" value="'.$this->input_val($val).'" /> Resizes to: (max width: '.$f['field_opts']['max_w'].', max height: '.$f['field_opts']['max_h'].') <a href="#upload_file" class="button">Upload file</a><span id="popup_domination_field_'.$f['field_opts']['id'].'_field_btns"'.(($val=='')?' style="display:none"':'').'> | <a href="#remove" class="button ">Remove</a></span> <img class="waiting" style="display:none;" src="images/wpspin_light.gif" alt="" /> <span id="popup_domination_field_'.$f['field_opts']['id'].'_error" style="display:none"></span><br />Want to create a stunning eCover design to put here? Check out <a href="http://nanacast.com/vp/95449/69429/" target="_blank">eCover Creator 3D</a>.';
									break;
								case 'videoembed':
									$field_str .= '<textarea cols="60" rows="5" name="popup_domination_fields['.$f['field_opts']['id'].']" id="'.$fieldid.'">'.$val.'</textarea>'.$this->videosize($f);
									break;
								case 'video':
									$field_str .= '<br /><input class="sdfds '.$val.'" type="'.$type.'" name="popup_domination_fields['.$f['field_opts']['id'].']" id="'.$fieldid.'" value="'.$this->input_val($val).'" />'.$this->maxlength_txt($f,$val).'<br/>Want to display your video here? Want it to convert well? Want to use the same software we use? Check out <a href="http://spdom.webactix.hop.clickbank.net" target="_blank"> Easy Video Player now!</a>';
									break;
								default:
									$field_str .= '<input class="sdfds '.$val.'" type="'.$type.'" name="popup_domination_fields['.$f['field_opts']['id'].']" id="'.$fieldid.'" value="'.$this->input_val($val).'" />'.$this->maxlength_txt($f,$val);		
									break;
							}
							$field_str .= '</p>';
						}
						
						foreach($f['field_opts'] as $a => $b){
							if($a!='type')
								$tmp[] = '"'.$a.'":"'.$b.'"';
						}
						$tmp = '{'.implode(',',$tmp).'}';
						$js .= (($count > 0)?',':'').'{"name":"'.$this->input_val($f['name']).'","opts":'.$tmp.'}';
						$count++;
					}
					$js .= '],';
				}
				if(isset($t['size']) && count($t['size']) == 2){
					$js .= '"preview_size":["'.$t['size'][0].'","'.$t['size'][1].'"],';
				}
				$lcount = 0;
				if(isset($t['list'])){
					$lcount = $t['list'];
				}
				if($selected){
					$t['list_count'] = $lcount;
					$cur_theme = $t;
				}
				$js .= '"list_count":"'.$this->input_val($lcount).'",';
				$counter++;
				
				if(isset($t['numfields'])){
					$this->custominputs = $t['numfields'];					
				}else{
					$this->custominputs = 0;
				}
				$js .= '"numfields":" '.$this->custominputs.'"}';
			}
			$js .= '}';
		$showjs = $this->show_var(true);
		$js .= ', popup_domination_show_backup = {"opts":[';
		$count = 0;
		if(isset($showjs['everywhere']) && $showjs['everywhere'] == 'Y'){
			$js .= "'everywhere'";
			$count++;
		}
		if(isset($showjs['front']) && $showjs['front'] == 'Y'){
			$js .= (($count>0)?',':'')."'front'";
			$count++;
		}
		$js .= '],"catids":['.((isset($showjs['catid']))?implode(',',$showjs['catid']):'').'],';
		$js .= '"pageids":['.((isset($showjs['pageid']))?implode(',',$showjs['pageid']):'').'],';
		$js .= '"caton":\''.((isset($showjs['caton']))?$showjs['caton']:'').'\'}';
		$options = array('name_box','email_box');
		for($i = 1; $i<= $this->custominputs; $i++){
			$options[] = 'custom'.$i.'_box';
		}
		foreach($options as $o)
			$$o = $this->input_val($this->option($o));
			
		$fields = '';
		if($f = $campaign['fields']){
			if(!empty($f)){
				if(is_array($f))
					$fieldsarr = $f;
				else
					$fieldsarr = unserialize($f);
				foreach($fieldsarr as $a => $b)
					$fields .= '<input type="hidden" name="field_name[]" value="'.$a.'" /><input type="hidden" name="field_vals[]" value="'.$b.'" />';
			}
		}
		if($f = $campaign['images']){
			if(!empty($f)){
				if(is_array($f))
					$fieldsarr = $f;
				else
					$fieldsarr = unserialize($f);
				foreach($fieldsarr as $b)
					$fields .= '<input type="hidden" name="field_img[]" value="'.$b.'" />';
			}
		}
		$listitems = '';
		if($l = $campaign['list']){
			if(!empty($l)){
				if(is_array($l))
					$list = $l;
				else
					$list = unserialize($l);
				$count = 1;
				foreach($list as $a){
					$class = '';
					if(isset($cur_theme['list_count']) && $count > $cur_theme['list_count'])
						$class = 'over';
					$listitems .= '
							<li'.(($class=='')?'':' class="'.$class.'"').'><input type="text" name="list_item[]" value="'.htmlspecialchars($a).'" /> <a href="#delete" class="thedeletebutton remove_list_item">Delete</a><div class="clear"></div></li>';
					$count++;
				}
			}
		}

		if(isset($campaign['schedule']['show_opt'])){
			$show_opt = $campaign['schedule']['show_opt'];
		}else{
			$show_opt = 'open';
		}
		
		/**
		* The JSON is now been created, so let's display it on the page and create the fields.
		*/
		
		echo '<script>
		var popup_domination_tpl_info = '.$js.'
		</script>';
					
		include $this->plugin_path.'tpl/camps_details.php';
		//include $this->plugin_path.'tpl/campaign/campaign_page.php';
	}

	/**
	* admin_page()
	*
	* Initial function in fired in the plugin's Admin panels.
	* Also checks if the plugin has been verified and installed.
	*/
	
	function admin_page(){
		if(!$ins = $this->option('installed')){
			$this->installation_process();
		} else {
			if(isset($_POST['action']) && strtolower($_POST['action']) == 'theme-editor'):
				$this->save_theme_file();
			else:
				if(strstr($this->wpadmin_page,'campaign')){
					if(isset($_POST['popup_domination'])){
						if(wp_verify_nonce($_POST['_wpnonce'], 'update-options')){
							$this->save_options();
							$this->success = true;
						} else {
							$update_msg = 'Could not save settings due to verification problems. Please try again.';
							$this->success = false;
						}
					}else{
						$this->success = false;
					}
				}
			endif;
			$this->load_pages();
		}
	}
	
	/**
	* load_analytics()
	*
	* Loads all data for listing all analytics for campaigns.
	* Initial page when entering analytics panel.
	*/
	
	function load_analytics(){
		$data = $this->get_db('popdom_campaigns');
		foreach($data as $d){
			$name = $d->campaign;
			$tmp = unserialize($d->data);
			$temppreview = $tmp['template']['template'];
			$temppreviewcolor = $tmp['template']['color'];
			$temppreviewcolor = strtolower($temppreviewcolor);
			$temppreviewcolor = str_replace(' ','-',$temppreviewcolor);
			$previewurl[$d->id] = $this->theme_url.$temppreview.'/previews/'.$temppreviewcolor.'.jpg';
			$anay[$name] = $this->get_db('popdom_analytics', 'campname = "'.$name.'"');
			if($prevsize[$d->id] = @getimagesize($previewurl[$d->id])){
				$prevsize[$d->id] = getimagesize($previewurl[$d->id]);
				$height[$d->id] = ($prevsize[$d->id][1])/1.1;
				$width[$d->id] = ($prevsize[$d->id][0])/1.1;
			}else{
				$height[$d->id] = '';
				$width[$d->id] = '';
			}
		}
		include $this->plugin_path.'tpl/analytics_panel.php';
	}
	
	/**
	* analytics_settings()
	*
	* Loads all data needed to show analytic data for the selected campaign.
	*/
	
	function analytics_settings(){
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$data = $this->get_db('popdom_analytics', 'campname = "'.$id.'"');
			$prevmonths = unserialize($data[0]->previousdata);
			$campname = $_GET['id'];
		}
		include($this->plugin_path.'tpl/analytics_data.php');
	}
	
	/**
	* analytics_settings()
	*
	* Loads all data needed to show analytic data for the selected campaign.
	*/
	
	function theme_uploader(){
		include $this->plugin_path.'tpl/theme_uploader.php';
	}
	
	/**
	* load_pages()
	*
	* Works out which panel and which action the user is requesting via the url.
	* Loads function in relation to panel/action/url.
	*/
	
	function load_pages(){
		switch ($this->curpage) {
		    case 'campaigns':
		    	$this->load_campaigns();
		        break;
		    case 'analytics':
		        $this->load_analytics();
		        break;
		    case 'a-btesting':
		    	$this->load_abtesting();
		        break;
		    case 'mailinglist':
		    	$this->mailing_settings();
		        break;
		     case 'promote':
		        $this->promote_settings();
		        break;
		    case 'theme_upload':
		        $this->theme_uploader();
		        break;
		   	case 'campaigns&action':
		   		$this->load_settings();
		        break;
		   	case 'a-btesting&action':
		   		$this->load_absettings();
		        break;
		    case 'analytics&id':
		   		$this->analytics_settings();
		        break;
		    default:
		    	$this->load_campaigns();
		        break;
		}	
	}
	
	/**
	* maxlength_txt()
	*
	* Collects out text length, used for template fields and list points.
	* Loads these values from the theme.txt file.
	*/
	
	function maxlength_txt($f,$val){
		if(isset($f['field_opts']['max'])){
			$max = intval($f['field_opts']['max']);
			$len = strlen($val);
			$txt = ' Recommended '.$max;
			$class = 'green';
			$msg = 'remaining <span>'.($max-$len).'</span>';
			if(strlen($val) > $f['field_opts']['max']){
				$class = 'red';
				$msg = 'hmm, you\'re over the limit, it might look bad';
			}
			return '<span class="recommended"><span class="'.$class.'">'.$txt.'</span> <span class="note"> - '.$msg.'</span></span>';
		}
		return '';
	}
	
	/**
	* videosize()
	*
	* Collects out the max video dimensions from theme.txt file.
	*/
	
	function videosize($f){
		if(isset($f['field_opts']['max_w']) && isset($f['field_opts']['max_h'])){
			$max_w = intval($f['field_opts']['max_w']);
			$max_h = intval($f['field_opts']['max_h']);
			return '<span class="recommended"><span class="green">Recommended Video Size</span>: height = <strong>'.$max_h.'</strong>, width = <strong>'.$max_w.'</strong>.</span>';
		}
		return '';
	}
	
	/**
	* load_campaigns()
	*
	* Loads all data needed to list out campaigns, initial panels when navigation to campaign menu.
	*/
	
	function load_campaigns(){
		$data = $this->get_db('popdom_campaigns');
		$this->campaigns = $data;
		$count = 0;
		foreach($data as $d){
			$tmp = unserialize($d->data);
			$temppreview = $tmp['template']['template'];
			$temppreviewcolor = $tmp['template']['color'];
			$temppreviewcolor = strtolower($temppreviewcolor);
			$temppreviewcolor = str_replace(' ','-',$temppreviewcolor);
			$tempname[$d->id] = $temppreview;
			$previewurl[$d->id] = $this->theme_url.$temppreview.'/previews/'.$temppreviewcolor.'.jpg';
			if($prevsize[$d->id] = @getimagesize($previewurl[$d->id])){
				$prevsize[$d->id] = getimagesize($previewurl[$d->id]);
				$height[$d->id] = ($prevsize[$d->id][1])/1.1;
				$width[$d->id] = ($prevsize[$d->id][0])/1.1;
			}else{
				$height[$d->id] = '';
				$width[$d->id] = '';
			}
			$count++;
			$name[$d->id] = $d->campaign;
		}
		include $this->plugin_path.'tpl/list_camps.php';
	}
	
	/**
	* check_camp_name()
	*
	* Checks the DB if a campaign name is already registered and returns false (meaning name is free).
	*/
	
	function check_camp_name(){
		$return = '';
		$table = '';
		$data = '';
		$name = trim($_POST['name']);
		if($_POST['type'] == 'campaign') {
			$table = 'popdom_campaigns';
			$data = $this->get_db($table, 'campaign = "'.$name.'"');
		} else if ($_POST['type'] == 'ab'){
			$table = 'popdom_ab';
			$data = $this->get_db($table, 'name = "'.$name.'"');
		} else {
			$return = '-1';
			die();
		}
		if(!empty($data)){
			/**
			* If name already taken, returns DB Row ID incase it's same campaign.
			*/
			$return = $data[0]->id;
		}else{
			$return = 'false';
		}
		echo $return;
		die();
	}

	/**
	* deletecamp()
	*
	* Deletes a campaign from the DB.
	*/
	
	function deletecamp(){
		$campid = $_POST['id'];
		$table = $_POST['table'];
		if(isset($_POST['column']) && !empty($_POST['column'])){
			$col = $_POST['column'];
		}else{
			$col = NULL;
		}
		$table = 'popdom_'.$table;
		echo $this->delete_db($table, $campid, $col);
		die();
	}
	
	/**
	* preview()
	*
	* Loads up everything needed to do an almost live preview PopUp for ppl to check the formatting.
	*/
	
	function preview(){
		$form_action = '';
		$conversionpage = '';
		$camp = '';
		$num = '';
		$set = false;
		$splitcampcookie = false;
		$datasplit = false;
		if(!wp_verify_nonce($_POST['_wpnonce'], 'update-options')){
			exit('<p>You do not have permission to view this</p>');
		}
		$this->is_preview = true;
		$prev = $_POST['popup_domination'];
		$prevnew = array();
		foreach($prev as $a => $b){
			$prevnew[$a] = stripslashes($b);
		}
		$prev = $prevnew;
		$t = $prev['template'];
		$target = (isset($prev['new_window']) && $prev['new_window'] == 'Y') ? ' target="_blank"':'';
		if(!$themeopts = $this->get_theme_info($t)){
			exit('<p>The theme you have chosen could not be found.</p>');
		}
		if(isset($themeopts['colors']) && !($color = $this->option('color'))){
			exit('<p>You must first select a color for your theme.</p>');
		}
		if(isset($prev['color']))
			$color = $prev['color'];
			$color = strtolower($color);
			$color = str_replace(' ','-',$color);
		$clickbank = '';
		if(isset($prev['promote'])){
			$promote = $prev['promote'];
			if($promote == 'Y'){
				$clickbank = (isset($prev['clickbank']))?$prev['clickbank']:'';
			}
		} else {
			$promote = 'N';
		}
		$tmp_fields = $_POST['popup_domination_fields'];
		$inputs['hidden'] = '';
		$api = unserialize(base64_decode($this->option('formapi')));
		$provider = $api['provider'];
		
		if($provider == 'nm' || $provider == 'form'){
			$form = $this->option('custom_fields');
			if(isset($form)){
				$form_action .= $this->option('action');
			}else{
				$form_action .= $api['listsid'];
			} 
		}else{
			$form_action = '#';
			$inputs['hidden'] .= '<input class="listid" type="hidden" name="listid" value="'.$api['listsid'].'" />';
		}
		$inputs['hidden'] .= '<input class="provider" type="hidden" name="provider" value="'.$api['provider'].'" />';
		$fields = array();
		foreach($tmp_fields as $a => $b)
			$fields[$a] = $a=='video-embed'?stripslashes($b):$this->encode(stripslashes($b));
		
		if(isset($_POST['field_name']) && isset($_POST['field_vals']) && count($_POST['field_name']) == count($_POST['field_vals'])){
			$fl = count($_POST['field_name']);
			for($i=0;$i<$fl;$i++){
				$_POST['field_name'][$i] = stripslashes($_POST['field_name'][$i]);
				$_POST['field_vals'][$i] = stripslashes($_POST['field_vals'][$i]);
			}
		}
		if(isset($_POST['field_img']) && count($_POST['field_img'])){
			$fl = count($_POST['field_img']);
			for($i=0;$i<$fl;$i++){
				if(!empty($_POST['field_img'][$i])){
					$inputs['hidden'] .= '<div style="display:none"><img src="'.stripslashes($_POST['field_img'][$i]).'" alt="" width="1" height="1" /></div>';
				}
			}
		}
		$list_items = array();
		if(isset($_POST['list_item'])){
			$tmp_items = $_POST['list_item'];
			foreach($tmp_items as $tmp)
				$list_items[] = $this->encode(stripslashes($tmp));
		}
		$disable_name = 'N';
		if(isset($prev['disable_name']) && $prev['disable_name'] == 'Y'){
			$disable_name = 'Y';
		}
		$delay = $prev['delay'];
		$center = $themeopts['center'];
		$delay_hide = '';
		$button_color = isset($prev['button_color']) ? $prev['button_color'] : '';
		$base = dirname($this->base_name);
		$theme_url = $this->theme_url.$t.'/';
		$lightbox_id = 'popup_domination_lightbox_wrapper';
		$lightbox_close_id = 'popup_domination_lightbox_close';
		$cookie_time = $icount = 0;
		$custom1 = $this->option('custom1_box');
		$custom2 = $this->option('custom2_box');

		$fstr = '';
		$arr = array();
		if($disable_name == 'N'){
			$arr[] = array('class'=>'name','default'=>((isset($fields['name_default'])) ? $fields['name_default'] : ''), 'name'=>((isset($inputs['name']))?$inputs['name']:''));
		}
		$arr[] = array('class'=>'email','default'=>((isset($fields['email_default'])) ? $fields['email_default'] : ''), 'name'=>((isset($inputs['email']))?$inputs['email']:''));
		if(isset($fields['custom1_default'])){
			if($provider != 'aw' && $provider != 'form'){
				$arr[] = array('class'=>'custom1_input','default'=>((isset($fields['custom1_default'])) ? $fields['custom1_default'] : ''), 'name' => 'custom1_default');
			}else if($provider == 'aw'){
				$arr[] = array('class'=>'custom1_input','default'=>((isset($fields['custom1_default'])) ? $fields['custom2_default'] : ''), 'name' => 'custom '.$api['custom1']);
			}else{
				$arr[] = array('class'=>'custom1_input','default'=>((isset($fields['custom1_default'])) ? $fields['custom2_default'] : ''), 'name' => $custom1);
			}
		}
		if(isset($fields['custom2_default'])){
			if($provider != 'aw' && $provider != 'form'){
				$arr[] = array('class'=>'custom2_input','default'=>((isset($fields['custom2_default'])) ? $fields['custom2_default'] : ''), 'name' => 'custom2_default');
			}else if($provider == 'aw'){
				$arr[] = array('class'=>'custom2_input','default'=>((isset($fields['custom2_default'])) ? $fields['custom2_default'] : ''), 'name' => 'custom '.$api['custom2']);
			}else{
				$arr[] = array('class'=>'custom2_input','default'=>((isset($fields['custom2_default'])) ? $fields['custom2_default'] : ''), 'name' => $custom2);
			}
				}
		$fstr = '';
		foreach($arr as $a){
			$fstr .= '<input type="text" class="'.$a['class'].'" value="'.$a['default'].'" name="'.$a['name'].'" />';
		}
		$promote_link = (($promote=='Y') ? '<p class="powered"><a href="'.((!empty($clickbank))?'http://'.$clickbank.'.popdom.hop.clickbank.net/':'http://www.popupdomination.com/').'" target="_blank">Powered By PopUp Domination</a></p>':'');
		ob_start();
		include $this->theme_path.$t.'/template.php';
		$output = ob_get_contents();
		ob_end_clean();
		echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
<script type="text/javascript" src="/wp-includes/js/jquery/jquery.js?ver=1.7.1"></script>
<script type="text/javascript" src="'.$this->plugin_url.'js/lightbox-preview.js"></script>
<link rel="stylesheet" type="text/css" href="'.$this->plugin_url.'/themes/'.$t.'/lightbox.css" />
</head><body><p style="text-align:center"><a href="#open">Re-open lightbox</a></p>'.$output.'
<script type="text/javascript">
'.$this->generate_js($delay,$center,$cookie_time,$arr,$show_opt,$unload_msg,0,'').'
</script>
</body></html>';
		exit;
	}
	
	/**
	* page_list()
	*
	* Collects and generates all pages and categories to set campaigns to appear on.
	*/
	
	function page_list(){
		if(isset($this->campaigndata['pages'])){
			$selected = $this->campaigndata['pages'];
		}else{
			$selected = array('everywhere' => 'Y');
		}
		$front = get_option('page_on_front');
		$ex_pages = '';
		if(get_option('show_on_front') == 'page' && $front){
			$ex_pages = $front;
		}
		$catstr = ''; $selectedcat = isset($selected['caton']) ? $selected['caton'] : 0;
		$opts = array('Both','Category page','Post page within the categories');
		foreach($opts as $a => $b){
			$catstr .= '
					<option value="'.$a.'"'.(($a==$selectedcat)?' selected="selected"':'').'>'.$b.'</option>';
		}
		$cats = $this->cat_list_recursive(0,$selected);
		$str = '
		<ul class="page_list">
			<li class="everywhere"><input type="checkbox" name="popup_domination_show[everywhere]" id="popup_domination_show_everywhere" value="Y"'.((isset($selected['everywhere']))?' checked="checked"':'').' /> <label for="popup_domination_show_everywhere">Everywhere</label></li>
			<li class="home"><input type="checkbox" name="popup_domination_show[front]" id="popup_domination_show_front" value="Y"'.((isset($selected['front']))?' checked="checked"':'').' /> <label for="popup_domination_show_front">Front Page</label></li>
			<li>Pages:'.$this->page_list_recursive(0,$ex_pages,$selected).'</li>';
			if(!empty($cats)){
				$str .= '
			<li><label>Categories:</label><br/>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label for="popup_domination_show_caton">Show on:</label>&nbsp;
				<select name="popup_domination_show[caton]" id="popup_domination_show_caton">'.$catstr.'
				</select>
				'.$cats.'
			</li>';
			}
			$str .= '
		</ul>';
		echo $str;
	}
	
	/**
	* absplit_list()
	*
	* Collects and generates all pages and categories to set A/B Split campaigns to appear on.
	*/
	
	function absplit_list($splitdata){
		if(isset($splitdata)){
			$selected = $splitdata;
		}else{
			$selected = array('everywhere' => 'Y');
		}
		$front = get_option('page_on_front');
		$ex_pages = '';
		if(get_option('show_on_front') == 'page' && $front){
			$ex_pages = $front;
		}
		$catstr = ''; $selectedcat = isset($selected['caton']) ? $selected['caton'] : 0;
		$opts = array('Both','Category page','Post page within the categories');
		foreach($opts as $a => $b){
			$catstr .= '
					<option value="'.$a.'"'.(($a==$selectedcat)?' selected="selected"':'').'>'.$b.'</option>';
		}
		$cats = $this->cat_list_recursive(0,$selected);
		$str = '
		<ul class="page_list">
			<li class="everywhere"><input type="checkbox" name="popup_domination_show[everywhere]" id="popup_domination_show_everywhere" value="Y"'.((isset($selected['everywhere']))?' checked="checked"':'').' /> <label for="popup_domination_show_everywhere">Everywhere</label></li>
			<li class="home"><input type="checkbox" name="popup_domination_show[front]" id="popup_domination_show_front" value="Y"'.((isset($selected['front']))?' checked="checked"':'').' /> <label for="popup_domination_show_front">Front Page</label></li>
			<li>Pages:'.$this->page_list_recursive(0,$ex_pages,$selected).'</li>';
			if(!empty($cats)){
				$str .= '
			<li><label>Categories:</label>
				<label for="popup_domination_show_caton">Show on:</label>&nbsp;
				<select name="popup_domination_show[caton]" id="popup_domination_show_caton">'.$catstr.'
				</select>
				'.$cats.'
			</li>';
			}
			$str .= '
		</ul>';
		echo $str;
	}		

}

$popup_domination = new PopUp_Domination_Admin();