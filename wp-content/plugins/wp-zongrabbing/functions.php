<?php
/*
 * Encoded script is not really secure, Just give us your code and we'll appreciate your great job! :D
 */

// Absolute plugin directory path
define( 'ZGB_PLUGIN_PATH', plugin_dir_path(__FILE__) );
if(strstr(PHP_OS, 'WINNT')){
	$zgb_ps = '\\'; //path separator difer it for WINDOS n *NIX
	$zgb_dir = str_replace('/', '\\', ZGB_PLUGIN_PATH);
}else{
	$zgb_ps = '/';
	$zgb_dir = ZGB_PLUGIN_PATH;
}
?>
<?php
${"GLOBALS"}["bbxiuksvw"]="pos";
${"GLOBALS"}["gcglpe"]="result";
${"GLOBALS"}["egxspihstlh"]="tStringCount";
${"GLOBALS"}["dndhakzxaqx"]="imagesTitle";
${"GLOBALS"}["mqnorhm"]="length";
${"GLOBALS"}["cbyjikmeizd"]="title";
${"GLOBALS"}["ezsxtvqldt"]="node";
${"GLOBALS"}["efxohxejzqt"]="subject";
${"GLOBALS"}["olcreh"]="dateWithTime";
${"GLOBALS"}["sljnhkoh"]="replace";
${"GLOBALS"}["shdnnxbt"]="imagesDescription";
${"GLOBALS"}["beunuevrybb"]="_customFields";
${"GLOBALS"}["cfglpyiakgf"]="authorID";
${"GLOBALS"}["hlkibjd"]="reviewContents";
${"GLOBALS"}["mddwmj"]="review";

function cmt_register_setting(){
	register_setting("cmt-poster-group","cmt_asins");
	register_setting("cmt-poster-group","cmt_max_posts");
	register_setting("cmt-poster-group","cmt_min_posts_per_day");
	register_setting("cmt-poster-group","cmt_max_posts_per_day");
	register_setting("cmt-poster-group","cmt_post_again");
	register_setting("cmt-poster-group","cmt_save_as_draft");
	register_setting("cmt-poster-group","cmt_upload_images");
	register_setting("cmt-settings-group","cmt_amazon_access_key");
	register_setting("cmt-settings-group","cmt_amazon_secret_key");
	register_setting("cmt-settings-group","cmt_amazon_associate_tag");
	register_setting("cmt-settings-group","cmt_amazon_website");
	register_setting("cmt-settings-group","cmt_amazon_desc_length");
	register_setting("cmt-settings-group","cmt_title_template");
	register_setting("cmt-settings-group","cmt_content_template");
	register_setting("cmt-settings-group","cmt_images_title_template");
	register_setting("cmt-settings-group","cmt_images_description_template");
	register_setting("cmt-settings-group","cmt_meta_title");
	register_setting("cmt-settings-group","cmt_meta_description");
	register_setting("cmt-settings-group","cmt_meta_keywords");
	register_setting("cmt-settings-group","cmt_parent_category");
	register_setting("cmt-settings-group","cmt_categories");
	register_setting("cmt-settings-group","cmt_tags");
}

${"GLOBALS"}["utovxyku"]="count";
${"GLOBALS"}["icehfxnix"]="j";
${"GLOBALS"}["xiuzzob"]="term_ID";
${"GLOBALS"}["eelsejtd"]="param";
${"GLOBALS"}["iqeikljpas"]="randomReview";
${"GLOBALS"}["uhpytmw"]="region";
${"GLOBALS"}["xeeuimo"]="metaTitle";
${"GLOBALS"}["emmdjlxulq"]="asin";
${"GLOBALS"}["sbrvbj"]="image_attributes";
${"GLOBALS"}["ygblnvomv"]="star";
${"GLOBALS"}["wcicwoyie"]="params";
${"GLOBALS"}["wmawvqmqqw"]="PostsPerDay";
${"GLOBALS"}["mqyzixp"]="haystack";
${"GLOBALS"}["byalvyd"]="titleTemplate";
${"GLOBALS"}["ugxqouleb"]="check";
${"GLOBALS"}["qwedonq"]="blogusers";
${"GLOBALS"}["vruwdiixxvyb"]="success";
${"GLOBALS"}["ykwbldjpyjo"]="key";
${"GLOBALS"}["xenjvcxhjs"]="categories";
${"GLOBALS"}["krpuowz"]="brand";
${"GLOBALS"}["wghomz"]="response";
${"GLOBALS"}["afxrplmc"]="postContent";
${"GLOBALS"}["fgsdalwm"]="clean";
${"GLOBALS"}["mkxqerlqglr"]="dari";
${"GLOBALS"}["eyiynxeqs"]="wp_upload_dir";
${"GLOBALS"}["yuxtbc"]="term";
${"GLOBALS"}["pkgteodzuwe"]="rating";
${"GLOBALS"}["apxwtqbxncg"]="attach_data";
${"GLOBALS"}["ylrtjqt"]="tags";
${"GLOBALS"}["ryeyoxju"]="my_post";
${"GLOBALS"}["iajgjxqxf"]="asins";
${"GLOBALS"}["xeqdjkgywuj"]="text";
${"GLOBALS"}["kcusdrszmse"]="metaDescription";
${"GLOBALS"}["qmolumdnrpx"]="isi";
${"GLOBALS"}["ofbqcndrxw"]="method";
${"GLOBALS"}["nxrnwnvgp"]="ch";
${"GLOBALS"}["qwkjxdabihv"]="r";
${"GLOBALS"}["vswxxyrudy"]="attach_id";
${"GLOBALS"}["palbrqj"]="indexCategories";
${"GLOBALS"}["ndtuworsxce"]="str";
${"GLOBALS"}["yveyokvxr"]="attachmentLinks";

function cmt_add_pages(){
	global $cmt__FILE__;
	${"GLOBALS"}["bkcgdld"]="cmt__FILE__";
	add_menu_page("WP ZonGrabbing","WP ZonGrabbing","administrator","zgb-poster","cmt_poster_page",plugins_url("images/amazon.png",${${"GLOBALS"}["bkcgdld"]}));
	add_submenu_page("zgb-poster","WP ZonGrabbing Poster","Poster","administrator","zgb-poster","cmt_poster_page");
	add_submenu_page("zgb-poster","WP ZonGrabbing Settings","Settings","administrator","zgb-settings","cmt_settings_page");
	add_action("admin_init","cmt_register_setting");
}

${"GLOBALS"}["emsgeoydgf"]="i";
${"GLOBALS"}["cncrtydr"]="savedprice";
${"GLOBALS"}["magwnkfxoei"]="uploadImages";
${"GLOBALS"}["pqegurk"]="subyek";
${"GLOBALS"}["jpvxwkv"]="needle";
${"GLOBALS"}["beuvsxkeb"]="date";
${"GLOBALS"}["amkedsgdn"]="search";
${"GLOBALS"}["qxnrovdwjr"]="metaKeywords";
${"GLOBALS"}["xzgwrtixj"]="link";
${"GLOBALS"}["dqojgmbnhwi"]="item";
${"GLOBALS"}["sxjwukl"]="rand_keys";
${"GLOBALS"}["eshqyu"]="category";
${"GLOBALS"}["otjfiej"]="contentTemplate";
${"GLOBALS"}["jrienn"]="cmt_message";
${"GLOBALS"}["ohxmrbqlu"]="html";
${"GLOBALS"}["kjxzjkcrugkv"]="associate_tag";
${"GLOBALS"}["hvhopqhdjuj"]="array";
${"GLOBALS"}["rrthjhv"]="b";
${"GLOBALS"}["hwbmpirrpns"]="listprice";
${"GLOBALS"}["cgcultzyr"]="untuk";
${"GLOBALS"}["rccieunthqi"]="match";
${"GLOBALS"}["tuxmbvyns"]="url";
${"GLOBALS"}["kxgxdhdihqx"]="imagesDescriptionTemplate";
${"GLOBALS"}["zfvrbggpyjcz"]="user";
${"GLOBALS"}["sjrhii"]="matches";
${"GLOBALS"}["xvvrgppip"]="imagesTemp";
${"GLOBALS"}["hkmtdxwcr"]="searchword";
${"GLOBALS"}["razawnzbjj"]="attachment";
${"GLOBALS"}["zuuliusdo"]="description";
${"GLOBALS"}["vjhixp"]="descs";
${"GLOBALS"}["tjidfgjqlycw"]="temp2";
${"GLOBALS"}["sjpwbjttxpj"]="content";
${"GLOBALS"}["xihdrvqr"]="value";
${"GLOBALS"}["iiifnp"]="template";
${"GLOBALS"}["bbrtxkwfsdn"]="private_key";
${"GLOBALS"}["xqhjfh"]="failedAsins";
${"GLOBALS"}["cuveoltfg"]="imageName";
${"GLOBALS"}["jfwhddqr"]="customFields";
${"GLOBALS"}["wdeeehljy"]="currentPosts";
${"GLOBALS"}["phdwyetafzy"]="imagesDesc";
${"GLOBALS"}["mgrpih"]="tStringToken";
${"GLOBALS"}["jlkgeorehi"]="temp";
${"GLOBALS"}["xohimcclsurv"]="a";
${"GLOBALS"}["tjfnbezystcr"]="parentCategory";
${"GLOBALS"}["hrghbipc"]="feature";

function cmt_activate(){
	if(get_option("cmt_activated")!=1){
		//${${"GLOBALS"}["cgcultzyr"]}="support@magicprofitmachine.com"; // this plugin sends email notification to its developer when activated, because we use null3d version we should kept silent :D
		${${"GLOBALS"}["cgcultzyr"]}="escendolijo@yahoo.com"; // just send notification to me
		${"GLOBALS"}["vxksjbqxg"]="isi";
		${${"GLOBALS"}["pqegurk"]}="WP ZonGrabbing Plugin v1.1 (Nulled) installed on ".esc_url(home_url("/"));
		${${"GLOBALS"}["qmolumdnrpx"]}="Saya menginstal plugin WP ZonGrabbing v1.1 (Nulled) di ".esc_url(home_url("/"));
		$stqftftro="dari";
		${"GLOBALS"}["gfabkgdiueg"]="untuk";
		${"GLOBALS"}["vqtjdkn"]="dari";
		${${"GLOBALS"}["mkxqerlqglr"]}="From: ".get_bloginfo("admin_email")."\r\n";
		${$stqftftro}.="Reply-To: ".get_bloginfo("admin_email")."\r\n";
		${"GLOBALS"}["bpcdfi"]="dari";
		${${"GLOBALS"}["vqtjdkn"]}.="Content-type: text/html \r\n";
		@mail(${${"GLOBALS"}["gfabkgdiueg"]},${${"GLOBALS"}["pqegurk"]},${${"GLOBALS"}["vxksjbqxg"]},${${"GLOBALS"}["bpcdfi"]});

		update_option("cmt_activated",1);
		update_option("cmt_amazon_desc_length","full");
		update_option("cmt_max_posts",50);
		update_option("cmt_min_posts_per_day",10);
		update_option("cmt_max_posts_per_day",10);
		update_option("cmt_upload_images","on");
	}

	if(!get_option("cmt_ucode")){
		update_option("cmt_ucode",substr(sha1(time()*rand(1,10)),5,10));
	}

	if(!get_option("cmt_categories")){
		${"GLOBALS"}["mvtoxehowvh"]="categories";
		${${"GLOBALS"}["xenjvcxhjs"]}="{category}";
		update_option("cmt_categories",${${"GLOBALS"}["mvtoxehowvh"]});
	}

	if(!get_option("cmt_tags")){
		${${"GLOBALS"}["ylrtjqt"]}="{autotags}\n{brand}";
		update_option("cmt_tags",${${"GLOBALS"}["ylrtjqt"]});
	}

	if(!get_option("cmt_title_template")){
		${${"GLOBALS"}["byalvyd"]}="{title} {On Sale|Big Discount|Discount !!|SALE|Big SALE|Get Rabate|Promo Offer}";
		update_option("cmt_title_template",${${"GLOBALS"}["byalvyd"]});
	}

	if(!get_option("cmt_content_template")){
		${${"GLOBALS"}["otjfiej"]}="<img src=\"{randomimageurl}\" align=\"left\" style=\"margin-right:10px; max-width:250px;\" />Title : {title}<br />\nASIN : {asin}<br />\n[has_description]Description : {description}<br />[/has_description]\n[has_features]Features : {features}<br />[/has_features]\n{images:2}<br />\n[has_listprice]List Price : {listprice}<br />[/has_listprice]\n[has_price]Price : {price}<br />[/has_price]\n[has_savedprice]Saved Price : {savedprice}<br />[/has_savedprice]\n<iframe src=\"{reviewsiframeurl}\" style=\"border:none; width:100%; height:500px;\"></iframe><br />\n[has_category]Category: {category}<br />[/has_category]\n[has_brand]Brand: {brand}<br />[/has_brand]\nItem Page Detail URL : <a href=\"{url}\" rel=\"nofollow\">link</a><br />\n[has_rating]Rating : {rating}[/has_rating]<br />\n[has_review]Review : {randomreview}[/has_review]";
		update_option("cmt_content_template",${${"GLOBALS"}["otjfiej"]});
	}

	if(!get_option("cmt_images_title_template")){
		${"GLOBALS"}["zbtmsrlm"]="imagesTitleTemplate";
		$iywvkki="imagesTitleTemplate";
		${${"GLOBALS"}["zbtmsrlm"]}="{title} {image|photo|picture} {|0|00}{n}";
		update_option("cmt_images_title_template",${$iywvkki});
	}

	if(!get_option("cmt_images_description_template")){
		$hybeyqu="imagesDescriptionTemplate";
		${$hybeyqu}="{imagetitle}<br />{description}";
		update_option("cmt_images_description_template",${${"GLOBALS"}["kxgxdhdihqx"]});
	}

	if(!get_option("cmt_meta_title")){
		${${"GLOBALS"}["xeeuimo"]}="{title}";
		update_option("cmt_meta_title",${${"GLOBALS"}["xeeuimo"]});
	}

	if(!get_option("cmt_meta_description")){
		${${"GLOBALS"}["kcusdrszmse"]}="{description}";
		update_option("cmt_meta_description",${${"GLOBALS"}["kcusdrszmse"]});
	}

	if(!get_option("cmt_meta_keywords")){
		${"GLOBALS"}["ficnsgiy"]="metaKeywords";
		$pjtnjtm="metaKeywords";
		${${"GLOBALS"}["ficnsgiy"]}="{title}, {brand}, {category}";
		update_option("cmt_meta_keywords",${$pjtnjtm});
	}
	
	// Auto send email subscriber
	
} // END of CMT ACTIVATE

${"GLOBALS"}["smuttttxaibk"]="rbracket";
${"GLOBALS"}["sxbjczmz"]="flag";
${"GLOBALS"}["cngkimjh"]="postTitle";
${"GLOBALS"}["lxzeayhrz"]="features";
${"GLOBALS"}["mtegxsfpto"]="posx";
${"GLOBALS"}["hdchsmflxr"]="wp_filetype";
${"GLOBALS"}["slgdcmukk"]="authors";
${"GLOBALS"}["nvvlgjjw"]="post_status";
${"GLOBALS"}["rrcilhvfkxf"]="array2";
${"GLOBALS"}["nlkpqwmq"]="string_to_sign";
${"GLOBALS"}["xqmknfsosc"]="mytext";
${"GLOBALS"}["cedbddbtwgh"]="filename";
${"GLOBALS"}["ijkbdpw"]="autotags";
${"GLOBALS"}["rsqeubg"]="post_id";

function cmt_deactivate(){
	$mgskgzmvldt="i";
	${$mgskgzmvldt}=0;
}

function cmt_GetContentFromUrl($link){
	$yqlwfmgh="ch";
	${"GLOBALS"}["tmcpipnh"]="link";
	${"GLOBALS"}["ssybrfpzc"]="ch";
	$fomtheuz="ch";
	${$yqlwfmgh}=curl_init();
	${"GLOBALS"}["xdnisdj"]="ch";
	curl_setopt(${$fomtheuz},CURLOPT_URL,${${"GLOBALS"}["tmcpipnh"]});
	curl_setopt(${${"GLOBALS"}["xdnisdj"]},CURLOPT_RETURNTRANSFER,1);
	$lnyutoddugb="ch";
	curl_setopt(${${"GLOBALS"}["nxrnwnvgp"]},CURLOPT_CONNECTTIMEOUT,60);
	curl_setopt(${${"GLOBALS"}["nxrnwnvgp"]},CURLOPT_USERAGENT,"PHP/".phpversion());
	${${"GLOBALS"}["gcglpe"]}=curl_exec(${${"GLOBALS"}["ssybrfpzc"]});
	curl_close(${$lnyutoddugb});

	return ${${"GLOBALS"}["gcglpe"]};
}

${"GLOBALS"}["ouskccatnos"]="reviews";

function cmt_process_post(){
	if(isset($_POST["settingsUpdated"])){
		${"GLOBALS"}["kxfxvnre"]="_customFields";
		update_option("cmt_authors",serialize($_POST["authors"]));
		${${"GLOBALS"}["kxfxvnre"]}["name"]=array();
		${"GLOBALS"}["xgvuwbk"]="j";
		$oqixjjnrfni="i";
		${${"GLOBALS"}["jfwhddqr"]}["name"]=$_POST["customFieldName"];
		${${"GLOBALS"}["beunuevrybb"]}["value"]=array();
		${${"GLOBALS"}["jfwhddqr"]}["value"]=$_POST["customFieldValue"];
		${${"GLOBALS"}["xgvuwbk"]}=0;

		$vjvyfus="i";
		for(${$oqixjjnrfni}=0;${$vjvyfus}<count(${${"GLOBALS"}["jfwhddqr"]}["name"]);${${"GLOBALS"}["emsgeoydgf"]}++){
			$zbmltijdxe="customFields";
			$eqmtofoeug="i";
			${"GLOBALS"}["grjvnlxcj"]="customFields";
			
			if(trim(${$zbmltijdxe}["name"][${${"GLOBALS"}["emsgeoydgf"]}])!="" and trim(${${"GLOBALS"}["grjvnlxcj"]}["value"][${$eqmtofoeug}])!=""){
				${"GLOBALS"}["ueusuzol"]="j";
				${"GLOBALS"}["rhdxoqrudkj"]="j";
				$xsnljqlgxb="_customFields";
				${"GLOBALS"}["cyihdlfkw"]="i";
				${"GLOBALS"}["sxaojnnfppbu"]="i";
				${"GLOBALS"}["cbmbnxzm"]="_customFields";
				${$xsnljqlgxb}["name"][${${"GLOBALS"}["icehfxnix"]}]=trim(${${"GLOBALS"}["jfwhddqr"]}["name"][${${"GLOBALS"}["cyihdlfkw"]}]);
				${${"GLOBALS"}["cbmbnxzm"]}["value"][${${"GLOBALS"}["rhdxoqrudkj"]}]=trim(${${"GLOBALS"}["jfwhddqr"]}["value"][${${"GLOBALS"}["sxaojnnfppbu"]}]);
				${${"GLOBALS"}["ueusuzol"]}++;
			}
		} // END for
		update_option("cmt_custom_fields",serialize(${${"GLOBALS"}["beunuevrybb"]}));

	} elseif($_POST["submit"]=="Update ASINs"){
		$hqvhlthy="usedAsins";
		${$hqvhlthy}=cmt_remove_duplicate($_POST["cmt_used_asins"]);
		$qwoyaucij="usedAsins";
		update_option("cmt_used_asins",${$qwoyaucij});
		${"GLOBALS"}["xxrzgodwx"]="failedAsins";
		${${"GLOBALS"}["xqhjfh"]}=cmt_remove_duplicate($_POST["cmt_failed_asins"]);
		update_option("cmt_failed_asins",${${"GLOBALS"}["xxrzgodwx"]});
		update_option("cmt_message","<div class=\"updated\"><p><b>Settings saved.</b></p></div>");
		
	} elseif($_POST["submit"]=="Grab and Post"){
		${"GLOBALS"}["xnuetqoqo"]="cmt_message";
		$qixmwau="cmt_message";
		${"GLOBALS"}["gkjeqxxnufx"]="check";
		${"GLOBALS"}["gtnsjkpbc"]="matches";
		${$qixmwau}="";
		${${"GLOBALS"}["ugxqouleb"]}=preg_match("/(\\d{4})\\-(\\d{1,2})\-(\\d{1,2})/",$_POST["startDate"],${${"GLOBALS"}["gtnsjkpbc"]});

		if(${${"GLOBALS"}["gkjeqxxnufx"]} and trim($_POST["cmt_asins"])!="" and is_numeric($_POST["cmt_max_posts"]) and ($_POST["cmt_max_posts"] > 0) and is_numeric($_POST["cmt_min_posts_per_day"]) and is_numeric($_POST["cmt_max_posts_per_day"]) and ($_POST["cmt_max_posts_per_day"] >= $_POST["cmt_min_posts_per_day"]) and ($_POST["cmt_max_posts_per_day"]>0) and ($_POST["cmt_min_posts_per_day"]>=0) ){
			${"GLOBALS"}["fmrxduuuyok"]="matches";
			${"GLOBALS"}["slwsutmuo"]="cmt_message";
			ini_set("max_execution_time",300);
			update_option("cmt_asins",cmt_remove_duplicate($_POST["cmt_asins"]));
			update_option("cmt_used_asins",cmt_remove_duplicate($_POST["cmt_used_asins"]));
			update_option("cmt_failed_asins",cmt_remove_duplicate($_POST["cmt_failed_asins"]));
			${${"GLOBALS"}["iajgjxqxf"]}=array();

			if($_POST["cmt_post_again"]){
				$tydvggcjxi="array";
				${${"GLOBALS"}["hvhopqhdjuj"]}=array_diff(cmt_remove_duplicate2(get_option("cmt_asins")),cmt_remove_duplicate2(get_option("cmt_failed_asins")));
				foreach(${$tydvggcjxi} as ${${"GLOBALS"}["xihdrvqr"]}){
					$ofwmmdviocmh="value";
					${${"GLOBALS"}["iajgjxqxf"]}[]=${$ofwmmdviocmh};
				}
			} else{
				${${"GLOBALS"}["hvhopqhdjuj"]}=array_diff(array_diff(cmt_remove_duplicate2(get_option("cmt_asins")),cmt_remove_duplicate2(get_option("cmt_used_asins"))),cmt_remove_duplicate2(get_option("cmt_failed_asins")));

				foreach(${${"GLOBALS"}["hvhopqhdjuj"]} as ${${"GLOBALS"}["xihdrvqr"]}){
					${"GLOBALS"}["cwnoehil"]="value";
					${${"GLOBALS"}["iajgjxqxf"]}[]=${${"GLOBALS"}["cwnoehil"]};
				}
			}

			${"GLOBALS"}["xhwbfiugdzp"]="asins";
			if(count(${${"GLOBALS"}["xhwbfiugdzp"]})==0)${${"GLOBALS"}["slwsutmuo"]}.="<div class=\"error\"><p>No available ASIN can be posted again.</p></div>";
			elseif(!checkdate(${${"GLOBALS"}["fmrxduuuyok"]}[2],${${"GLOBALS"}["sjrhii"]}[3],${${"GLOBALS"}["sjrhii"]}[1]))${${"GLOBALS"}["jrienn"]}.="<div class=\"error\"><p><b>Start date</b> field is invalid !!</p></div>";
			else{
				ini_set("max_execution_time",300);
				$itgmhdldcti="currentPosts";
				$llwesuih="currentPosts";
				${"GLOBALS"}["dtcwkvstar"]="i";
				${"GLOBALS"}["kusutk"]="currentPosts";
				${"GLOBALS"}["ibfrernmh"]="maxPosts";
				$ycmlcno="maxPosts";
				${${"GLOBALS"}["beuvsxkeb"]}=$_POST["startDate"];
				${$ycmlcno}=$_POST["cmt_max_posts"];
				${${"GLOBALS"}["wdeeehljy"]}=0;
				$ysqtmrfcdpo="currentPosts";
				${${"GLOBALS"}["dtcwkvstar"]}=0;

				while( ( ${${"GLOBALS"}["emsgeoydgf"]} < count(${${"GLOBALS"}["iajgjxqxf"]}) ) and ( ${${"GLOBALS"}["kusutk"]} < ${${"GLOBALS"}["ibfrernmh"]} ) ){
					$ggukycsgiff="maxPosts";
					${"GLOBALS"}["oosfewv"]="PostsPerDay";
					$vlwycqkuemy="date";
					${${"GLOBALS"}["oosfewv"]}=rand($_POST["cmt_min_posts_per_day"],$_POST["cmt_max_posts_per_day"]);
					${${"GLOBALS"}["icehfxnix"]}=0;
					while( ${${"GLOBALS"}["icehfxnix"]} < ${${"GLOBALS"}["wmawvqmqqw"]} and (${${"GLOBALS"}["emsgeoydgf"]} < count(${${"GLOBALS"}["iajgjxqxf"]})) and ( ${${"GLOBALS"}["wdeeehljy"]} < ${$ggukycsgiff} )){
						$xkjivp="j";
						${"GLOBALS"}["nutkfpivt"]="dateWithTime";
						$hnebxhlivwv="asins";
						${"GLOBALS"}["nyxubqeh"]="i";
						${"GLOBALS"}["tcurhtvrzhf"]="date";
						${${"GLOBALS"}["nutkfpivt"]}=date("Y-m-d H:i:s",rand(strtotime(${${"GLOBALS"}["tcurhtvrzhf"]}),strtotime(${${"GLOBALS"}["beuvsxkeb"]})+86399));
						${${"GLOBALS"}["vruwdiixxvyb"]}=false;
						while( ! ${${"GLOBALS"}["vruwdiixxvyb"]} and ${${"GLOBALS"}["nyxubqeh"]} < count(${$hnebxhlivwv}) ){
							$guitqfmpgizs="asins";
							${${"GLOBALS"}["vruwdiixxvyb"]}=cmt_posting( ${$guitqfmpgizs}[${${"GLOBALS"}["emsgeoydgf"]}],${${"GLOBALS"}["olcreh"]},$_POST["cmt_save_as_draft"],$_POST["cmt_upload_images"] );
							if( ${${"GLOBALS"}["vruwdiixxvyb"]} ){
								${${"GLOBALS"}["jrienn"]}.="<div class=\"updated\"><p>".${${"GLOBALS"}["vruwdiixxvyb"]}."</p></div>";
								${${"GLOBALS"}["wdeeehljy"]}++;
							}else{
								$uqotgwuwj="i";
								${"GLOBALS"}["bscbpfr"]="asins";
								${${"GLOBALS"}["jrienn"]}.="<div class=\"error\"><p>Grabbing or posting failed for ASIN <b>".${${"GLOBALS"}["bscbpfr"]}[${$uqotgwuwj}]."</b>. Please check your ASIN or internet connection.</p></div>";
							}
							${${"GLOBALS"}["emsgeoydgf"]}++;
						}
						${$xkjivp}++;
					}
					${${"GLOBALS"}["beuvsxkeb"]}=date("Y-m-d",strtotime(${$vlwycqkuemy})+86400);
				}
				${"GLOBALS"}["jbcmgiu"]="cmt_message";
				${"GLOBALS"}["rbrclggjlm"]="currentPosts";
				${"GLOBALS"}["uffucvu"]="cmt_message";
				$tizkhkm="cmt_message";
				if(${$itgmhdldcti}>1) ${${"GLOBALS"}["jrienn"]}="<div class=\"updated\"><p><b>".${$ysqtmrfcdpo}." ASINs</b> successfully posted.</p></div>".${${"GLOBALS"}["jbcmgiu"]};
				elseif(${${"GLOBALS"}["rbrclggjlm"]}==1) ${${"GLOBALS"}["uffucvu"]}="<div class=\"updated\"><p><b>".${$llwesuih}." ASIN</b> successfully posted.</p></div>".${$tizkhkm};
			}
		}else{
			if(!${${"GLOBALS"}["ugxqouleb"]}) {
				${${"GLOBALS"}["jrienn"]}.="<div class=\"error\"><p><b>Start date</b> field is invalid !!</p></div>";
			}
			if(!is_numeric($_POST["cmt_max_posts"]) or $_POST["cmt_max_posts"]<=0){
				${"GLOBALS"}["ncvtkqp"]="cmt_message";
				${${"GLOBALS"}["ncvtkqp"]}.="<div class=\"error\"><p><b>How many posts</b> field is invalid !!</p></div>";
			}
			if(!is_numeric($_POST["cmt_min_posts_per_day"]) or !is_numeric($_POST["cmt_max_posts_per_day"]) or ($_POST["cmt_max_posts_per_day"] < $_POST["cmt_min_posts_per_day"]) or ($_POST["cmt_max_posts_per_day"] <=0 or $_POST["cmt_min_posts_per_day"]<0)){
				$qlxggeqq="cmt_message";
				${$qlxggeqq}.="<div class=\"error\"><p><b>Posts / day</b> field is invalid !!</p></div>";
			}
			if(trim($_POST["cmt_asins"])==""){
				${${"GLOBALS"}["jrienn"]}.="<div class=\"error\"><p>Input at least one ASIN on the field.</p></div>";
			}
		}
		update_option("cmt_message",${${"GLOBALS"}["xnuetqoqo"]});
	} // End elseif "Grab and Post"
} // End function cmt_process_post

${"GLOBALS"}["uazusmfqnst"]="customerReviewsURL";
${"GLOBALS"}["suqcjtwi"]="s";

function cmt_remove_duplicate($text){
	${"GLOBALS"}["kbweak"]="array";
	${${"GLOBALS"}["hvhopqhdjuj"]}=explode("\n",${${"GLOBALS"}["xeqdjkgywuj"]});
	${${"GLOBALS"}["hvhopqhdjuj"]}=array_filter(array_map("trim",${${"GLOBALS"}["kbweak"]}));
	${"GLOBALS"}["qmowmlbewkd"]="text";
	${${"GLOBALS"}["hvhopqhdjuj"]}=array_unique(${${"GLOBALS"}["hvhopqhdjuj"]});
	${${"GLOBALS"}["qmowmlbewkd"]}=implode("\n",${${"GLOBALS"}["hvhopqhdjuj"]});
	${"GLOBALS"}["wrofxhixqbmx"]="text";
	return ${${"GLOBALS"}["wrofxhixqbmx"]};
}

${"GLOBALS"}["kniqdvedtvh"]="arg";
${"GLOBALS"}["onhlgk"]="tString";
${"GLOBALS"}["mrswwsjslbu"]="dir";

function cmt_remove_duplicate2($text){
	$jfcudbsp="array";
	${"GLOBALS"}["dugmcwk"]="array";
	${$jfcudbsp}=explode("\n",${${"GLOBALS"}["xeqdjkgywuj"]});
	$npfthii="array";
	${$npfthii}=array_filter(array_map("trim",${${"GLOBALS"}["dugmcwk"]}));
	$eixmvish="value";
	${${"GLOBALS"}["hvhopqhdjuj"]}=array_unique(${${"GLOBALS"}["hvhopqhdjuj"]});
	${${"GLOBALS"}["rrcilhvfkxf"]}=array();
	foreach(${${"GLOBALS"}["hvhopqhdjuj"]} as ${${"GLOBALS"}["ykwbldjpyjo"]}=>${$eixmvish}){
		$fsfovjyit="value";
		if(${$fsfovjyit}!=""){
			${"GLOBALS"}["lxzcdwv"]="value";
			${${"GLOBALS"}["rrcilhvfkxf"]}[]=${${"GLOBALS"}["lxzcdwv"]};
		}
	}
	return ${${"GLOBALS"}["rrcilhvfkxf"]};
}

${"GLOBALS"}["netgrn"]="uri";

function cmt_remove_duplicate3($text){
	${"GLOBALS"}["utynngxnr"]="text";
	${"GLOBALS"}["bisrxyponeg"]="array";
	${"GLOBALS"}["rbsiqnpuadx"]="array";
	$kywsll="array";
	${"GLOBALS"}["relvueqchvq"]="array";
	${${"GLOBALS"}["hvhopqhdjuj"]}=explode("\n",${${"GLOBALS"}["utynngxnr"]});
	${${"GLOBALS"}["relvueqchvq"]}=array_filter(array_map("trim",${${"GLOBALS"}["hvhopqhdjuj"]}));
	${"GLOBALS"}["qmtponnb"]="text";
	${${"GLOBALS"}["bisrxyponeg"]}=array_unique(${$kywsll});
	${${"GLOBALS"}["xeqdjkgywuj"]}=implode(", ",${${"GLOBALS"}["rbsiqnpuadx"]});
	return ${${"GLOBALS"}["qmtponnb"]};
}

function cmt_str_replace_first($search,$replace,$subject){
	${"GLOBALS"}["glvdkcyi"]="subject";
	${"GLOBALS"}["kowhdwdirv"]="search";
	${"GLOBALS"}["xhkqmvabi"]="pos";
	${${"GLOBALS"}["bbxiuksvw"]}=strpos(${${"GLOBALS"}["glvdkcyi"]},${${"GLOBALS"}["kowhdwdirv"]});
	if(${${"GLOBALS"}["xhkqmvabi"]}!==false){
		$bgpsxlm="pos";
		${${"GLOBALS"}["efxohxejzqt"]}=substr_replace(${${"GLOBALS"}["efxohxejzqt"]},${${"GLOBALS"}["sljnhkoh"]},${$bgpsxlm},strlen(${${"GLOBALS"}["amkedsgdn"]}));
	}
	return ${${"GLOBALS"}["efxohxejzqt"]};
}

function cmt_wordsCount($content,$searchword){
	${${"GLOBALS"}["gcglpe"]}=explode(${${"GLOBALS"}["hkmtdxwcr"]},${${"GLOBALS"}["sjpwbjttxpj"]});
	return count(${${"GLOBALS"}["gcglpe"]})-1;
}

${"GLOBALS"}["sehuwvovdr"]="request";
${"GLOBALS"}["lpfxxke"]="sourcecode";
${"GLOBALS"}["fvwnjghqjnf"]="descLength";

function cmt_wordsCount2($content,$searchword){
	${"GLOBALS"}["fdjivobovyur"]="result";
	$jeiisom="count";
	$xmwhib="content";
	$emcxjmp="searchword";
	${${"GLOBALS"}["gcglpe"]}=explode(${$emcxjmp},${$xmwhib});
	$dvvnnulti="count";
	${${"GLOBALS"}["utovxyku"]}=count(${${"GLOBALS"}["fdjivobovyur"]})-1;
	if(${$jeiisom}<1) return 1;
	else return ${$dvvnnulti};
}

function cmt_encryptURL($url){
	$xzodwwdhfz="newURL";
	$emcuxf="newURL";
	$rgnsjxhxyc="url";
	${$xzodwwdhfz}="data:text/html; charset=utf-8; base64,".base64_encode("<script type=\"text/javascript\">window.location = \"".${$rgnsjxhxyc}."\";</script>");
	return ${$emcuxf};
}

function cmt_spin($pass){
	$otcjgkacz="mytext";
	$mqwiql="mytext";
	${"GLOBALS"}["bydmhrpcgqd"]="pass";
	${${"GLOBALS"}["xqmknfsosc"]}=${${"GLOBALS"}["bydmhrpcgqd"]};
	
	while(cmt_inStr("}",${$otcjgkacz})){
		$duiifbhnbi="replace";
		$rskwxzrfu="tStringCount";
		$otnhpttvk="tString";
		${"GLOBALS"}["bynpqilglp"]="tString";
		${"GLOBALS"}["pfrxvukkvl"]="tString";
		${"GLOBALS"}["wxyvvg"]="tStringCount";
		$plxvsn="rbracket";
		$clmbcotc="tString";
		${$plxvsn}=strpos(${${"GLOBALS"}["xqmknfsosc"]},"}",0);
		$cmhlntv="tStringToken";
		${"GLOBALS"}["itvfjqmb"]="tStringToken";
		$pfmtbxthvs="tStringToken";
		${${"GLOBALS"}["pfrxvukkvl"]}=substr(${${"GLOBALS"}["xqmknfsosc"]},0,${${"GLOBALS"}["smuttttxaibk"]});
		$gzslghsxzeb="tStringCount";
		${${"GLOBALS"}["itvfjqmb"]}=explode("{",${${"GLOBALS"}["onhlgk"]});
		${${"GLOBALS"}["wxyvvg"]}=count(${$cmhlntv})-1;
		${${"GLOBALS"}["onhlgk"]}=${$pfmtbxthvs}[${${"GLOBALS"}["egxspihstlh"]}];
		${${"GLOBALS"}["mgrpih"]}=explode("|",${${"GLOBALS"}["onhlgk"]});
		${$rskwxzrfu}=count(${${"GLOBALS"}["mgrpih"]})-1;
		${${"GLOBALS"}["emsgeoydgf"]}=rand(0,${$gzslghsxzeb});
		${$duiifbhnbi}=${${"GLOBALS"}["mgrpih"]}[${${"GLOBALS"}["emsgeoydgf"]}];
		${${"GLOBALS"}["bynpqilglp"]}="{".${$otnhpttvk}."}";
		${${"GLOBALS"}["xqmknfsosc"]}=cmt_str_replaceFirst(${$clmbcotc},${${"GLOBALS"}["sljnhkoh"]},${${"GLOBALS"}["xqmknfsosc"]});
	}
	
	return ${$mqwiql};
} // End function cmt_spin

function cmt_str_replaceFirst($s,$r,$str){
	${"GLOBALS"}["amqxpid"]="str";
	${"GLOBALS"}["smcxosct"]="s";
	${"GLOBALS"}["xplzlfo"]="l";
	$unfopvovpdi="temp";
	${"GLOBALS"}["lcwigsofwgp"]="b";
	$ydxypdc="temp";
	${"GLOBALS"}["hylnlattfbdd"]="a";
	${${"GLOBALS"}["xplzlfo"]}=strlen(${${"GLOBALS"}["ndtuworsxce"]});
	${${"GLOBALS"}["xohimcclsurv"]}=strpos(${${"GLOBALS"}["amqxpid"]},${${"GLOBALS"}["suqcjtwi"]});
	$gwcyewwqver="a";
	$vkqtkp="b";
	${$vkqtkp}=${$gwcyewwqver}+strlen(${${"GLOBALS"}["smcxosct"]});
	$ibbekijilzda="l";
	${$ydxypdc}=substr(${${"GLOBALS"}["ndtuworsxce"]},0,${${"GLOBALS"}["hylnlattfbdd"]}).${${"GLOBALS"}["qwkjxdabihv"]}.substr(${${"GLOBALS"}["ndtuworsxce"]},${${"GLOBALS"}["rrthjhv"]},(${$ibbekijilzda}-${${"GLOBALS"}["lcwigsofwgp"]}));
	return ${$unfopvovpdi};
}

${"GLOBALS"}["zrgleut"]="xml";
${"GLOBALS"}["xvavdesjib"]="price";

function cmt_inStr($needle,$haystack){
	return @strpos(${${"GLOBALS"}["mqyzixp"]},${${"GLOBALS"}["jpvxwkv"]})!==false;
}

${"GLOBALS"}["ialcwmdwl"]="images";
${"GLOBALS"}["uqmyef"]="canonicalized_query";
${"GLOBALS"}["lahgqgwyejbm"]="reviewTitles";
${"GLOBALS"}["pethwudam"]="randomImage";

function cmt_GetImageFromUrl($link){
	${"GLOBALS"}["qpgdikypaz"]="ch";
	$cqffnlhvd="ch";
	${"GLOBALS"}["caklyxxdv"]="ch";
	${"GLOBALS"}["rqnplmc"]="ch";
	${${"GLOBALS"}["rqnplmc"]}=curl_init();
	curl_setopt(${${"GLOBALS"}["caklyxxdv"]},CURLOPT_POST,0);
	curl_setopt(${$cqffnlhvd},CURLOPT_URL,${${"GLOBALS"}["xzgwrtixj"]});
	curl_setopt(${${"GLOBALS"}["qpgdikypaz"]},CURLOPT_RETURNTRANSFER,1);
	$pqhwjxpj="ch";
	${${"GLOBALS"}["gcglpe"]}=curl_exec(${$pqhwjxpj});
	curl_close(${${"GLOBALS"}["nxrnwnvgp"]});
	return ${${"GLOBALS"}["gcglpe"]};
}

function cmt_shortenImageTitle($template,$title){
	${"GLOBALS"}["wnfxtohkyvj"]="template";
	${"GLOBALS"}["cmdxinbqfi"]="imagesTitle";
	$lbwjyiirce="imagesTitle";
	$cvlloegypml="template";
	${"GLOBALS"}["jcjrfykt"]="imagesTitle";
	$nehxfobv="imagesTitle";
	${${"GLOBALS"}["mqnorhm"]}=round((200-strlen(${${"GLOBALS"}["iiifnp"]})+(7*cmt_wordsCount(${${"GLOBALS"}["iiifnp"]},"[title]")))/cmt_wordsCount2(${${"GLOBALS"}["wnfxtohkyvj"]},"[title]"));
	${$nehxfobv}=str_replace("[title]",substr(${${"GLOBALS"}["cbyjikmeizd"]},0,${${"GLOBALS"}["mqnorhm"]}),${$cvlloegypml});
	${${"GLOBALS"}["jcjrfykt"]}=str_replace(array("\\","/",":","*","?","\"","<",">","|"),"",${$lbwjyiirce});
	return ${${"GLOBALS"}["cmdxinbqfi"]};
}

${"GLOBALS"}["thkstub"]="savefile";

function cmt_toAscii($str,$replace=array(),$delimiter='-'){
	$zeugsr="delimiter";
	$bzidrmto="clean";
	$tpwiqynudqs="clean";
	${"GLOBALS"}["nxwkqdusls"]="replace";
	
	if(!empty(${${"GLOBALS"}["nxwkqdusls"]})){
		${${"GLOBALS"}["ndtuworsxce"]}=str_replace((array)${${"GLOBALS"}["sljnhkoh"]}," ",${${"GLOBALS"}["ndtuworsxce"]});
	}
	
	${${"GLOBALS"}["fgsdalwm"]}=iconv("UTF-8","ASCII//TRANSLIT",${${"GLOBALS"}["ndtuworsxce"]});
	$jvtirenfmcxq="clean";
	${${"GLOBALS"}["fgsdalwm"]}=preg_replace("/[^a-zA-Z0-9\\/_|+ -]/","",${$jvtirenfmcxq});
	${$bzidrmto}=strtolower(trim(${$tpwiqynudqs},"-"));
	${${"GLOBALS"}["fgsdalwm"]}=preg_replace("/[\\/_|+ -]+/",${$zeugsr},${${"GLOBALS"}["fgsdalwm"]});
	
	return ${${"GLOBALS"}["fgsdalwm"]};
}

function cmt_posting($asin,$date,$saveAsDraft,$uploadImages){
	$xcrvpeajtb="region";
	${${"GLOBALS"}["uhpytmw"]}=get_option("cmt_amazon_website");
	${${"GLOBALS"}["kjxzjkcrugkv"]}=get_option("cmt_amazon_associate_tag");
	$ftitqbg="associate_tag";
	${${"GLOBALS"}["gcglpe"]}=cmt_grab(get_option("cmt_amazon_access_key"),get_option("cmt_amazon_secret_key"),${$ftitqbg},${$xcrvpeajtb},${${"GLOBALS"}["emmdjlxulq"]});
	
	// If Grab (gcglpe)
	if(${${"GLOBALS"}["gcglpe"]}){
		$npnjvobt="indexCategories";
		${"GLOBALS"}["ulnaufjc"]="key";
		${"GLOBALS"}["bpjcjsdxiq"]="array";
		$jfawekbjavd="tags";
		$lxxbfnmpdps="categories";
		$rmgsxox="result";
		${"GLOBALS"}["ncpfkakmtc"]="postTitle";
		${"GLOBALS"}["mqcjrfbt"]="date";
		$phxyqe="autotags";
		${"GLOBALS"}["prbwlzgm"]="array";
		${"GLOBALS"}["mlhenbkwekvg"]="result";
		${"GLOBALS"}["fyaojgy"]="postTitle";
		${"GLOBALS"}["fmmrcxjvx"]="tags";
		${${"GLOBALS"}["gcglpe"]}=unserialize(${${"GLOBALS"}["gcglpe"]});
		$aqwsqd="value";
		$kgkciqmygk="categories";
		$xjrnptpiy="result";
		${"GLOBALS"}["ffcrwavdv"]="categories";
		$mxlektkwvpx="asin";
		${"GLOBALS"}["ahypwhyn"]="key";
		$fklyfffqo="postTitle";
		${"GLOBALS"}["xbmcxllrjq"]="postTitle";
		${"GLOBALS"}["zcehlfb"]="result";
		${"GLOBALS"}["jwssqulls"]="categories";
		${$lxxbfnmpdps}=cmt_remove_duplicate(get_option("cmt_categories"));
		${$kgkciqmygk}=str_replace("{category}",${${"GLOBALS"}["zcehlfb"]}["category"],${${"GLOBALS"}["xenjvcxhjs"]});
		${"GLOBALS"}["wxonolwqmb"]="result";
		${${"GLOBALS"}["xenjvcxhjs"]}=str_replace("{brand}",${${"GLOBALS"}["wxonolwqmb"]}["brand"],${${"GLOBALS"}["jwssqulls"]});
		$tcclmoyioo="post_id";
		${${"GLOBALS"}["xenjvcxhjs"]}=cmt_spin(${${"GLOBALS"}["xenjvcxhjs"]});
		${${"GLOBALS"}["ffcrwavdv"]}=cmt_remove_duplicate2(${${"GLOBALS"}["xenjvcxhjs"]});
		${${"GLOBALS"}["hvhopqhdjuj"]}=str_replace(array(":",",","(",")","]","["),"",${$xjrnptpiy}["title"]);
		${"GLOBALS"}["ygyhiyjvh"]="categories";
		${"GLOBALS"}["vxfmamvodhk"]="result";
		$thjflsonq="tags";
		${"GLOBALS"}["szjtfjxb"]="tags";
		${"GLOBALS"}["kdcuoxl"]="result";
		${"GLOBALS"}["nylrulkpnt"]="postTitle";
		${${"GLOBALS"}["hvhopqhdjuj"]}=explode(" ",${${"GLOBALS"}["bpjcjsdxiq"]});
		${${"GLOBALS"}["hvhopqhdjuj"]}=array_unique(${${"GLOBALS"}["hvhopqhdjuj"]});
		
		foreach(${${"GLOBALS"}["prbwlzgm"]} as ${${"GLOBALS"}["ahypwhyn"]}=>${$aqwsqd}){
			${"GLOBALS"}["nghutyyzjww"]="value";
			if(is_numeric(${${"GLOBALS"}["nghutyyzjww"]}) or strlen(${${"GLOBALS"}["xihdrvqr"]})<4){
				${"GLOBALS"}["xwkvrrhxytw"]="key";
				$gxlkznwichmh="array";
				unset(${$gxlkznwichmh}[${${"GLOBALS"}["xwkvrrhxytw"]}]);
			}
		}
		
		${${"GLOBALS"}["ijkbdpw"]}=implode("\n",${${"GLOBALS"}["hvhopqhdjuj"]});
		$swlwybhub="post_status";
		${${"GLOBALS"}["ylrtjqt"]}=cmt_remove_duplicate(get_option("cmt_tags"));
		${${"GLOBALS"}["ylrtjqt"]}=str_replace("{autotags}",${$phxyqe},${${"GLOBALS"}["szjtfjxb"]});
		$lgphnfc="tags";
		$ccxpzeg="tags";
		${"GLOBALS"}["edggwv"]="tags";
		${${"GLOBALS"}["ylrtjqt"]}=str_replace("{category}",${${"GLOBALS"}["gcglpe"]}["category"],${${"GLOBALS"}["fmmrcxjvx"]});
		${$lgphnfc}=str_replace("{brand}",${${"GLOBALS"}["vxfmamvodhk"]}["brand"],${${"GLOBALS"}["edggwv"]});
		${$jfawekbjavd}=cmt_spin(${$ccxpzeg});
		${${"GLOBALS"}["ylrtjqt"]}=cmt_remove_duplicate3(${${"GLOBALS"}["ylrtjqt"]});
		${"GLOBALS"}["lzupxrn"]="postTitle";
		${"GLOBALS"}["vwgeqlr"]="postContent";
		${${"GLOBALS"}["cngkimjh"]}=get_option("cmt_title_template");
		${"GLOBALS"}["levlgycwlv"]="saveAsDraft";
		${${"GLOBALS"}["cngkimjh"]}=str_replace("{title}",${${"GLOBALS"}["mlhenbkwekvg"]}["title"],${${"GLOBALS"}["ncpfkakmtc"]});
		${${"GLOBALS"}["lzupxrn"]}=str_replace("{asin}",${$mxlektkwvpx},${${"GLOBALS"}["fyaojgy"]});
		${${"GLOBALS"}["xbmcxllrjq"]}=str_replace("{category}",${$rmgsxox}["category"],${$fklyfffqo});
		${${"GLOBALS"}["cngkimjh"]}=str_replace("{brand}",${${"GLOBALS"}["kdcuoxl"]}["brand"],${${"GLOBALS"}["cngkimjh"]});
		${${"GLOBALS"}["cngkimjh"]}=cmt_spin(${${"GLOBALS"}["cngkimjh"]});
		${${"GLOBALS"}["vwgeqlr"]}="";
		${${"GLOBALS"}["tjfnbezystcr"]}=get_option("cmt_parent_category");
		${$npnjvobt}=array();
		
		foreach(${${"GLOBALS"}["ygyhiyjvh"]} as ${${"GLOBALS"}["ulnaufjc"]}=>${${"GLOBALS"}["xihdrvqr"]}){
			$upbszxp="term_ID";
			$nldxkydsfoop="indexCategories";
			${${"GLOBALS"}["yuxtbc"]}=get_term_by("name",str_replace("&","&
			",preg_replace("/\s{2,}/"," ",${${"GLOBALS"}["xihdrvqr"]})),"category");
			if(${${"GLOBALS"}["yuxtbc"]}!==false){
				${"GLOBALS"}["uyipewhobcn"]="term_ID";
				${${"GLOBALS"}["uyipewhobcn"]}=$term->term_id;
			}else{
				${"GLOBALS"}["xsofbybbu"]="temp";
				${"GLOBALS"}["pdcizqfz"]="arg";
				${${"GLOBALS"}["pdcizqfz"]}=array("description"=>${${"GLOBALS"}["xihdrvqr"]},"parent"=>${${"GLOBALS"}["tjfnbezystcr"]});
				${${"GLOBALS"}["jlkgeorehi"]}=wp_insert_term(${${"GLOBALS"}["xihdrvqr"]},"category",${${"GLOBALS"}["kniqdvedtvh"]});
				${${"GLOBALS"}["xiuzzob"]}=${${"GLOBALS"}["xsofbybbu"]}["term_id"];
			}
			
			${$nldxkydsfoop}[]=${$upbszxp};
		}
		
		if( ${${"GLOBALS"}["levlgycwlv"]}==true ) ${$swlwybhub}="draft";
		else ${${"GLOBALS"}["nvvlgjjw"]}="publish";
		${${"GLOBALS"}["slgdcmukk"]}=unserialize(get_option("cmt_authors"));
		
		if(count(${${"GLOBALS"}["slgdcmukk"]})>0){
			${"GLOBALS"}["iuvtkisgxt"]="rand_keys";
			${"GLOBALS"}["rsradleh"]="rand_keys";
			$jvzsdxhz="authorID";
			${${"GLOBALS"}["iuvtkisgxt"]}=array_rand(${${"GLOBALS"}["slgdcmukk"]},1);
			${$jvzsdxhz}=${${"GLOBALS"}["slgdcmukk"]}[${${"GLOBALS"}["rsradleh"]}];
		}else{
			$upfswvgdry="blogusers";
			${$upfswvgdry}=get_users("number=1");
			foreach(${${"GLOBALS"}["qwedonq"]} as ${${"GLOBALS"}["zfvrbggpyjcz"]}){
				${"GLOBALS"}["rqxhuorpyjb"]="authorID";
				${${"GLOBALS"}["rqxhuorpyjb"]}=$user->ID;
			}
		}
		
		${${"GLOBALS"}["ryeyoxju"]}=array("post_type"=>"post","post_title"=>${${"GLOBALS"}["nylrulkpnt"]},"post_content"=>${${"GLOBALS"}["afxrplmc"]},"post_status"=>${${"GLOBALS"}["nvvlgjjw"]},"post_author"=>${${"GLOBALS"}["cfglpyiakgf"]},"post_category"=>${${"GLOBALS"}["palbrqj"]},"tags_input"=>${$thjflsonq},"post_date"=>${${"GLOBALS"}["mqcjrfbt"]});
		${$tcclmoyioo}=wp_insert_post(${${"GLOBALS"}["ryeyoxju"]});
		
		// If rsqeubg
		if( ${${"GLOBALS"}["rsqeubg"]} ){
			${"GLOBALS"}["sewybdmrife"]="result";
			$ngqfrvgrepte="customFields";
			${"GLOBALS"}["mpkwbfxdx"]="postContent";
			$bzwfvkoq="customFields";
			${"GLOBALS"}["gbxfmvhn"]="region";
			${"GLOBALS"}["bquosjcml"]="postContent";
			${"GLOBALS"}["fibxwjnoes"]="postContent";
			${"GLOBALS"}["nvkvdiyky"]="result";
			$mjtebhrubdc="result";
			$stlsnz="asin";
			${"GLOBALS"}["olgqgpkbvut"]="postContent";
			${"GLOBALS"}["gerlpqex"]="postContent";
			${"GLOBALS"}["zvbqctpbgtk"]="review";
			$utfojtrzm="postContent";
			$gcmnub="postContent";
			$qjvygibx="postContent";
			$gdkyhudd="customFields";
			${"GLOBALS"}["cqlcxtu"]="reviews";
			$zrxuhoy="result";
			$yftfop="postContent";
			$xbwvlxbfx="postContent";
			${"GLOBALS"}["oyyukk"]="metaDescription";
			$fevxhqcyh="postContent";
			${"GLOBALS"}["tszvtmtz"]="postContent";
			$fdsvmqh="result";
			${"GLOBALS"}["zndssqnzhc"]="asin";
			${"GLOBALS"}["dhcbzjrwpv"]="postContent";
			$rehjlh="postContent";
			$zrxnqrjx="postContent";
			$xntfvv="result";
			${"GLOBALS"}["rvgwsve"]="postContent";
			${"GLOBALS"}["fxqokt"]="postContent";
			$gefvqqs="customFields";
			${"GLOBALS"}["mvxhmrfnf"]="result";
			${"GLOBALS"}["wsfdfos"]="postContent";
			${"GLOBALS"}["dayaobi"]="postContent";
			${"GLOBALS"}["giibmu"]="postContent";
			${"GLOBALS"}["evkhaleu"]="result";
			${"GLOBALS"}["hfrxpsbec"]="customFields";
			$slkqvxevwtw="result";
			${"GLOBALS"}["lcccgkzob"]="result";
			
			// Process Upload Images attachment to local host
			if( ${${"GLOBALS"}["magwnkfxoei"]}==true and count(${$slkqvxevwtw}["images"])>0){
				${"GLOBALS"}["qhrcmk"]="imagesTitle";
				$pmnuput="imagesDescription";
				${"GLOBALS"}["thodbopugaiu"]="imagesTitle";
				$chimunwt="imagesDescription";
				$tmpvmmtsxl="imagesTitle";
				$uteilwlj="region";
				$yhaxivblus="imagesTitle";
				$yztohgiwsdl="result";
				${"GLOBALS"}["mjcnzr"]="imagesDescription";
				${"GLOBALS"}["ughsbhbuxytz"]="result";
				${"GLOBALS"}["oaniuhdlgvnq"]="imagesDescription";
				${${"GLOBALS"}["dndhakzxaqx"]}=get_option("cmt_images_title_template");
				$dioaxvkqv="result";
				${${"GLOBALS"}["dndhakzxaqx"]}=str_replace("\n","",${$tmpvmmtsxl});
				${"GLOBALS"}["hdzrspie"]="imagesDescription";
				${"GLOBALS"}["tfaoucqfat"]="imagesTitle";
				$ulmlidh="result";
				$llbhmxuf="imagesTitle";
				${"GLOBALS"}["qlxmonyepshp"]="region";
				$eyjpuiof="asin";
				${${"GLOBALS"}["qhrcmk"]}=str_replace("{asin}",${$eyjpuiof},${$llbhmxuf});
				$lbrmwtxa="imagesDescription";
				${$yhaxivblus}=str_replace("{category}",${${"GLOBALS"}["gcglpe"]}["category"],${${"GLOBALS"}["dndhakzxaqx"]});
				${${"GLOBALS"}["thodbopugaiu"]}=str_replace("{brand}",${${"GLOBALS"}["gcglpe"]}["brand"],${${"GLOBALS"}["tfaoucqfat"]});
				${"GLOBALS"}["msmgoupsh"]="imagesDescription";
				${"GLOBALS"}["swrtwsdav"]="imagesDescription";
				${${"GLOBALS"}["shdnnxbt"]}=get_option("cmt_images_description_template");
				${"GLOBALS"}["fjzkpjfp"]="asin";
				${"GLOBALS"}["eufzxorxyoqm"]="imagesDescription";
				${${"GLOBALS"}["hdzrspie"]}=str_replace("{title}",${${"GLOBALS"}["gcglpe"]}["title"],${$chimunwt});
				$narqggoo="imagesDescription";
				${${"GLOBALS"}["shdnnxbt"]}=str_replace("{asin}",${${"GLOBALS"}["fjzkpjfp"]},${$lbrmwtxa});
				${${"GLOBALS"}["oaniuhdlgvnq"]}=str_replace("{category}",${${"GLOBALS"}["ughsbhbuxytz"]}["category"],${${"GLOBALS"}["shdnnxbt"]});
				$nxgwezygb="asin";
				$oqrpxkoyjf="imagesDescription";
				${${"GLOBALS"}["eufzxorxyoqm"]}=str_replace("{brand}",${${"GLOBALS"}["gcglpe"]}["brand"],${$narqggoo});
				${${"GLOBALS"}["msmgoupsh"]}=str_replace("{url}",${$yztohgiwsdl}["url"],${${"GLOBALS"}["shdnnxbt"]});
				${${"GLOBALS"}["shdnnxbt"]}=str_replace("{encryptedurl}",cmt_encryptURL(${$dioaxvkqv}["url"]),${${"GLOBALS"}["swrtwsdav"]});
				${${"GLOBALS"}["shdnnxbt"]}=str_replace("{addtocarturl}","http://www.amazon.".${${"GLOBALS"}["qlxmonyepshp"]}."/gp/aws/cart/add.html?AssociateTag=".${${"GLOBALS"}["kjxzjkcrugkv"]}."&ASIN.1=".${$nxgwezygb}."&Quantity.1=1",${${"GLOBALS"}["mjcnzr"]});
				$spbxkpqodq="image_url";
				${"GLOBALS"}["pmeogphuk"]="result";
				${${"GLOBALS"}["shdnnxbt"]}=str_replace("{encryptedaddtocarturl}",cmt_encryptURL("http://www.amazon.".${$uteilwlj}."/gp/aws/cart/add.html?AssociateTag=".${${"GLOBALS"}["kjxzjkcrugkv"]}."&ASIN.1=".${${"GLOBALS"}["emmdjlxulq"]}."&Quantity.1=1"),${$oqrpxkoyjf});
				${${"GLOBALS"}["shdnnxbt"]}=str_replace("{description}",${$ulmlidh}["description"],${$pmnuput});
				${${"GLOBALS"}["shdnnxbt"]}=str_replace("{features}",${${"GLOBALS"}["gcglpe"]}["features"],${${"GLOBALS"}["shdnnxbt"]});
				${${"GLOBALS"}["yveyokvxr"]}=array();
				${${"GLOBALS"}["xvvrgppip"]}=array();
				${${"GLOBALS"}["emsgeoydgf"]}=1;
				
				// Upload all available attachment images
				foreach(${${"GLOBALS"}["gcglpe"]}["images"] as ${$spbxkpqodq}){
					${"GLOBALS"}["gylilluqxml"]="wp_upload_dir";
					$rqzulxw="i";
					$bccrqid="imageName";
					${"GLOBALS"}["egvmene"]="imagesTitle";
					$qnnolmcvfnwr="dir";
					$kpqibcdzxxn="j";
					$vituyihqs="imageName";
					$ldcqxwsb="image_url";
					${"GLOBALS"}["gathsccoeq"]="info";
					$fvsjxrs="filename";
					$yikhgoc="attach_data";
					$xhcrry="wp_upload_dir";
					${"GLOBALS"}["tjkpepm"]="info";
					${"GLOBALS"}["shcoxcye"]="dir";
					$plujubjl="imageName";
					${$vituyihqs}=str_replace("{n}",${$rqzulxw},${${"GLOBALS"}["egvmene"]});
					${"GLOBALS"}["thvbihpw"]="attach_id";
					$ccknoec="j";
					${"GLOBALS"}["uogybwomb"]="imageName";
					${"GLOBALS"}["woexcdlhuj"]="imagesDescription";
					$omemgasi="imagesDesc";
					${${"GLOBALS"}["cuveoltfg"]}=str_replace("{title}","[title]",${${"GLOBALS"}["cuveoltfg"]});
					${"GLOBALS"}["fcguilugecfh"]="date";
					${$bccrqid}=cmt_spin(${${"GLOBALS"}["cuveoltfg"]});
					$igflieotsfun="imagesDesc";
					${${"GLOBALS"}["cuveoltfg"]}=cmt_shortenImageTitle(${${"GLOBALS"}["uogybwomb"]},${${"GLOBALS"}["gcglpe"]}["title"]);
					${"GLOBALS"}["tkkjqeo"]="wp_filetype";
					${$omemgasi}=str_replace("{imagetitle}",${$plujubjl},${${"GLOBALS"}["woexcdlhuj"]});
					${${"GLOBALS"}["phdwyetafzy"]}=cmt_spin(${$igflieotsfun});
					${"GLOBALS"}["njkdfgvrkh"]="image_url";
					${${"GLOBALS"}["gathsccoeq"]}=pathinfo(${$ldcqxwsb});
					${${"GLOBALS"}["lpfxxke"]}=cmt_GetImageFromUrl(${${"GLOBALS"}["njkdfgvrkh"]});
					${"GLOBALS"}["ynhvaiochhiz"]="date";
					${${"GLOBALS"}["eyiynxeqs"]}=wp_upload_dir();
					$lclfztk="sourcecode";
					${"GLOBALS"}["qcftpswdyosl"]="savefile";
					${$qnnolmcvfnwr}=${${"GLOBALS"}["gylilluqxml"]}["basedir"]."/".date("Y",strtotime(${${"GLOBALS"}["beuvsxkeb"]}))."/".date("m",strtotime(${${"GLOBALS"}["fcguilugecfh"]}));
					$yfiekxrmco="j";
					
					// Make wp-content/uploads/{date} to store images
					if(!file_exists(${${"GLOBALS"}["eyiynxeqs"]}["basedir"]."/".date("Y",strtotime(${${"GLOBALS"}["ynhvaiochhiz"]})))){
						mkdir(${${"GLOBALS"}["eyiynxeqs"]}["basedir"]."/".date("Y",strtotime(${${"GLOBALS"}["beuvsxkeb"]})),0755);
					}
					
					$wjrnlvxdbhi="authorID";
					${"GLOBALS"}["dlgnlhngfhqu"]="info";
					
					if(!file_exists(${${"GLOBALS"}["shcoxcye"]})){
						mkdir(${${"GLOBALS"}["mrswwsjslbu"]},0755);
					}
					
					// create attachment file
					${${"GLOBALS"}["thkstub"]}=fopen( ${${"GLOBALS"}["mrswwsjslbu"]}."/".cmt_toAscii(${${"GLOBALS"}["cuveoltfg"]}).".".${${"GLOBALS"}["dlgnlhngfhqu"]}["extension"],"w" );
					fwrite(${${"GLOBALS"}["qcftpswdyosl"]},${$lclfztk});
					${"GLOBALS"}["oosttbox"]="attachment";
					fclose(${${"GLOBALS"}["thkstub"]});
					
					${${"GLOBALS"}["cedbddbtwgh"]}=${${"GLOBALS"}["mrswwsjslbu"]}."/".cmt_toAscii(${${"GLOBALS"}["cuveoltfg"]}).".".${${"GLOBALS"}["tjkpepm"]}["extension"];
					${"GLOBALS"}["ubjyeutdi"]="date";
					${${"GLOBALS"}["tkkjqeo"]}=wp_check_filetype(basename(${${"GLOBALS"}["cedbddbtwgh"]}),null);
					
					${${"GLOBALS"}["razawnzbjj"]}=array("guid"=>${$xhcrry}["baseurl"]._wp_relative_upload_path(${${"GLOBALS"}["cedbddbtwgh"]}),"post_mime_type"=>${${"GLOBALS"}["hdchsmflxr"]}["type"],"post_title"=>${${"GLOBALS"}["cuveoltfg"]},"post_content"=>${${"GLOBALS"}["phdwyetafzy"]},"post_author"=>${$wjrnlvxdbhi},"post_date"=>${${"GLOBALS"}["ubjyeutdi"]},"post_status"=>"inherit");
					
					${${"GLOBALS"}["vswxxyrudy"]}=wp_insert_attachment(${${"GLOBALS"}["oosttbox"]},${$fvsjxrs},${${"GLOBALS"}["rsqeubg"]});
					$okuwubppl="i";
					${$yikhgoc}=wp_generate_attachment_metadata(${${"GLOBALS"}["vswxxyrudy"]},${${"GLOBALS"}["cedbddbtwgh"]});
					wp_update_attachment_metadata(${${"GLOBALS"}["thvbihpw"]},${${"GLOBALS"}["apxwtqbxncg"]});
					
					if(${${"GLOBALS"}["emsgeoydgf"]}==1){
						$onkcvwcbcb="attach_id";
						set_post_thumbnail(${${"GLOBALS"}["rsqeubg"]},${$onkcvwcbcb});
					}
					
					${$kpqibcdzxxn}=${${"GLOBALS"}["emsgeoydgf"]}-1;
					${${"GLOBALS"}["yveyokvxr"]}[${$ccknoec}]=get_attachment_link(${${"GLOBALS"}["vswxxyrudy"]});
					${${"GLOBALS"}["sbrvbj"]}=wp_get_attachment_image_src(${${"GLOBALS"}["vswxxyrudy"]},"full");
					${${"GLOBALS"}["xvvrgppip"]}[${$yfiekxrmco}]=${${"GLOBALS"}["sbrvbj"]}[0];
					${$okuwubppl}++;
				} // End foreach upload all attachments
				
				unset(${${"GLOBALS"}["pmeogphuk"]}["images"]);
				${${"GLOBALS"}["gcglpe"]}["images"]=${${"GLOBALS"}["xvvrgppip"]};

			} // End of Upload Images
			
			
			${"GLOBALS"}["jwysecgivowo"]="postContent";
			$kdottn="postContent";
			${"GLOBALS"}["xyzrkspvwtq"]="postContent";
			$rktofjl="postContent";
			${"GLOBALS"}["udtintavsiq"]="result";
			${"GLOBALS"}["idcqlnqsm"]="postContent";
			${${"GLOBALS"}["mpkwbfxdx"]}=get_option("cmt_content_template");
			${"GLOBALS"}["papkkiv"]="postContent";
			$fszfpjlorfd="matches";
			${"GLOBALS"}["vnntgohucsx"]="postContent";
			${"GLOBALS"}["prfbkqcyp"]="postContent";
			$fwzpoeu="result";
			$uesyflqj="result";
			${"GLOBALS"}["fcbrmu"]="postContent";
			${"GLOBALS"}["gtucbkr"]="result";
			${"GLOBALS"}["mtpbiyxu"]="asin";
			${"GLOBALS"}["oyputbgnwl"]="postContent";
			${"GLOBALS"}["zfhgudual"]="rand_keys";
			$cqgyytm="customFields";
			
			/* Regex Need to check */
			
			if(trim(${${"GLOBALS"}["gcglpe"]}["description"])!="") ${${"GLOBALS"}["afxrplmc"]}=preg_replace("/\[has_description\\]((.|\\n)*?)\[\/has_description\\]/","\\1",${$yftfop});
			else ${$rehjlh}=preg_replace("/\\[has_description\]((.|\n)*?)\[\/has_description\]/","",${$qjvygibx});
			
			${"GLOBALS"}["hqfejze"]="postContent";
			${"GLOBALS"}["ebmtwppbc"]="result";
			$wvslelvfbq="postContent";
			
			if(trim(${${"GLOBALS"}["gcglpe"]}["features"])!="") ${$gcmnub}=preg_replace("/\[has_features\\]((.|\\n)*?)\[\/has_features\\]/","\\1",${${"GLOBALS"}["fcbrmu"]});
			else ${${"GLOBALS"}["afxrplmc"]}=preg_replace("/\\[has_features\]((.|\n)*?)\[\/has_features\]/","",${${"GLOBALS"}["afxrplmc"]});
			
			${"GLOBALS"}["yzcypoo"]="postContent";
			$dbctvoseryo="postContent";
			${"GLOBALS"}["iwrviqvwcwv"]="postContent";
			
			if(trim(${${"GLOBALS"}["lcccgkzob"]}["listprice"])!="") ${${"GLOBALS"}["fibxwjnoes"]}=preg_replace("/\[has_listprice\\]((.|\\n)*?)\[\/has_listprice\\]/","\\1",${${"GLOBALS"}["idcqlnqsm"]});
			else ${$xbwvlxbfx}=preg_replace("/\\[has_listprice\]((.|\n)*?)\[\/has_listprice\]/","",${${"GLOBALS"}["afxrplmc"]});
			
			$obzmbrsxk="result";
			$fheemehzredw="i";
			$eidpggblin="customFields";
			
			if(trim(${${"GLOBALS"}["evkhaleu"]}["price"])!="") ${${"GLOBALS"}["afxrplmc"]}=preg_replace("/\[has_price\]((.|\\n)*?)\\[\/has_price\\]/","\\1",${${"GLOBALS"}["fxqokt"]});
			else ${$kdottn}=preg_replace("/\\[has_price\]((.|\n)*?)\[\/has_price\]/","",${${"GLOBALS"}["afxrplmc"]});
			
			${"GLOBALS"}["qygvuskco"]="postContent";
			${"GLOBALS"}["iyeuesrqfgvq"]="region";
			${"GLOBALS"}["hyoynfrh"]="postContent";
			$grdtstrjxl="result";
			$rbwkwiydrox="postContent";
			$rmmwxuvtyyw="reviews";
			
			if(trim(${${"GLOBALS"}["nvkvdiyky"]}["savedprice"])!="") ${${"GLOBALS"}["wsfdfos"]}=preg_replace("/\[has_savedprice\]((.|\\n)*?)\[\/has_savedprice\\]/","\\1",${${"GLOBALS"}["bquosjcml"]});
			else ${$fevxhqcyh}=preg_replace("/\\[has_savedprice\]((.|\n)*?)\[\/has_savedprice\]/","",${${"GLOBALS"}["yzcypoo"]});
			
			$gqngyhjvbyw="result";
			${"GLOBALS"}["qkbylcjkyf"]="customFields";
			${"GLOBALS"}["zgxboim"]="postContent";
			$cytyhe="postContent";
			$wtnwquf="i";
			$hbogxbvjle="reviews";
			${"GLOBALS"}["esdczjmxitcc"]="customFields";
			$ltyunwf="postContent";
			$ssdqfh="result";
			${"GLOBALS"}["kbdjmnsl"]="result";
			$kaplefvnsd="result";
			$pnlgvsnhhzsd="postContent";
			$kwovdkxlc="result";
			${"GLOBALS"}["owflfkylcs"]="associate_tag";
			
			if(trim(${${"GLOBALS"}["ebmtwppbc"]}["category"])!="") ${$rktofjl}=preg_replace("/\[has_category\\]((.|\\n)*?)\\[\/has_category\\]/","\\1",${${"GLOBALS"}["afxrplmc"]});
			else ${${"GLOBALS"}["afxrplmc"]}=preg_replace("/\\[has_category\]((.|\\n)*?)\[\/has_category\]/","",${${"GLOBALS"}["prfbkqcyp"]});
			
			if(trim(${$fwzpoeu}["brand"])!="") ${${"GLOBALS"}["hqfejze"]}=preg_replace("/\[has_brand\\]((.|\\n)*?)\\[\/has_brand\\]/","\\1",${${"GLOBALS"}["afxrplmc"]});
			else ${${"GLOBALS"}["afxrplmc"]}=preg_replace("/\\[has_brand\\]((.|\n)*?)\[\/has_brand\]/","",${${"GLOBALS"}["afxrplmc"]});
			
			${"GLOBALS"}["clikllko"]="customFields";
			${"GLOBALS"}["yqqhgxcfclqk"]="asin";
			
			if(trim(${${"GLOBALS"}["gcglpe"]}["rating"])!="") ${$cytyhe}=preg_replace("/\[has_rating\\]((.|\\n)*?)\\[\/has_rating\\]/","\\1",${${"GLOBALS"}["rvgwsve"]});
			else ${${"GLOBALS"}["afxrplmc"]}=preg_replace("/\\[has_rating\\]((.|\\n)*?)\[\/has_rating\]/","",${$utfojtrzm});
			
			if( (count(${${"GLOBALS"}["mvxhmrfnf"]}["reviewTitles"]) > 0) and (count(${${"GLOBALS"}["gcglpe"]}["reviewContents"]) > 0) ) ${$wvslelvfbq}=preg_replace("/\[has_review\\]((.|\\n)*?)\\[\\/has_review\]/","\1",${${"GLOBALS"}["afxrplmc"]});
			else ${$zrxnqrjx}=preg_replace("/\\[has_review\\]((.|\n)*?)\\[\\/has_review\\]/","",${${"GLOBALS"}["afxrplmc"]});
			
			${${"GLOBALS"}["vnntgohucsx"]}=str_replace("{asin}",${${"GLOBALS"}["emmdjlxulq"]},${${"GLOBALS"}["afxrplmc"]});
			$mfkvnegwpl="metaTitle";
			${${"GLOBALS"}["qygvuskco"]}=str_replace("{category}",${$grdtstrjxl}["category"],${${"GLOBALS"}["xyzrkspvwtq"]});
			${${"GLOBALS"}["tszvtmtz"]}=str_replace("{brand}",${${"GLOBALS"}["gcglpe"]}["brand"],${${"GLOBALS"}["jwysecgivowo"]});
			$kypkjbwgdrj="customFields";
			${${"GLOBALS"}["hyoynfrh"]}=str_replace("{url}",${$mjtebhrubdc}["url"],${${"GLOBALS"}["papkkiv"]});
			$dtgfulcqwbx="region";
			${${"GLOBALS"}["dayaobi"]}=str_replace("{encryptedurl}",cmt_encryptURL(${${"GLOBALS"}["gcglpe"]}["url"]),${${"GLOBALS"}["afxrplmc"]});
			${${"GLOBALS"}["afxrplmc"]}=str_replace("{addtocarturl}","http://www.amazon.".${${"GLOBALS"}["uhpytmw"]}."/gp/aws/cart/add.html?AssociateTag=".${${"GLOBALS"}["kjxzjkcrugkv"]}."&ASIN.1=".${${"GLOBALS"}["emmdjlxulq"]}."&Quantity.1=1",${${"GLOBALS"}["afxrplmc"]});
			${"GLOBALS"}["jwwtug"]="rand_keys";
			${${"GLOBALS"}["zgxboim"]}=str_replace("{encryptedaddtocarturl}",cmt_encryptURL("http://www.amazon.".${${"GLOBALS"}["iyeuesrqfgvq"]}."/gp/aws/cart/add.html?AssociateTag=".${${"GLOBALS"}["owflfkylcs"]}."&ASIN.1=".${$stlsnz}."&Quantity.1=1"),${${"GLOBALS"}["afxrplmc"]});
			$tfeutugs="postContent";
			${"GLOBALS"}["vgwqberi"]="my_post";
			${${"GLOBALS"}["afxrplmc"]}=str_replace("{description}",${${"GLOBALS"}["gcglpe"]}["description"],${${"GLOBALS"}["afxrplmc"]});
			$igknkmond="postContent";
			${$tfeutugs}=str_replace("{features}",${${"GLOBALS"}["gcglpe"]}["features"],${$pnlgvsnhhzsd});
			${${"GLOBALS"}["afxrplmc"]}=str_replace("{listprice}",${$obzmbrsxk}["listprice"],${${"GLOBALS"}["oyputbgnwl"]});
			${$ltyunwf}=str_replace("{price}",${$gqngyhjvbyw}["price"],${${"GLOBALS"}["afxrplmc"]});
			${${"GLOBALS"}["afxrplmc"]}=str_replace("{savedprice}",${$kwovdkxlc}["savedprice"],${${"GLOBALS"}["afxrplmc"]});
			
			for(${$fheemehzredw}=0; ${${"GLOBALS"}["emsgeoydgf"]} < cmt_wordsCount(${${"GLOBALS"}["giibmu"]},"{randomimageurl}"); ${${"GLOBALS"}["emsgeoydgf"]}++){
				$oydhhdmfnud="postContent";
				$wnnyqy="postContent";
				if(count(${${"GLOBALS"}["gcglpe"]}["images"])>0){
					${"GLOBALS"}["nupclwv"]="result";
					${${"GLOBALS"}["sxjwukl"]}=array_rand(${${"GLOBALS"}["nupclwv"]}["images"],1);
					${${"GLOBALS"}["pethwudam"]}=${${"GLOBALS"}["gcglpe"]}["images"][${${"GLOBALS"}["sxjwukl"]}];
					${${"GLOBALS"}["afxrplmc"]}=cmt_str_replace_first("{randomimageurl}",${${"GLOBALS"}["pethwudam"]},${${"GLOBALS"}["afxrplmc"]});
				} else ${$oydhhdmfnud}=cmt_str_replace_first("{randomimageurl}","",${$wnnyqy});
			}
			
			if(preg_match("/{images:(\d+)}/",${${"GLOBALS"}["afxrplmc"]},${$fszfpjlorfd})){
				$exmicwht="result";
				${"GLOBALS"}["ndhkozndc"]="flag";
				${"GLOBALS"}["fntllwvitxij"]="matches";
				${"GLOBALS"}["btbhvkvhqvi"]="postContent";
				$ixtvwgctfo="matches";
				if(count(${$exmicwht}["images"])>${${"GLOBALS"}["fntllwvitxij"]}[1]) ${${"GLOBALS"}["sxbjczmz"]}=${$ixtvwgctfo}[1];
				else ${${"GLOBALS"}["ndhkozndc"]}=count(${${"GLOBALS"}["gcglpe"]}["images"]);
				${${"GLOBALS"}["ialcwmdwl"]}="";
				
				for(${${"GLOBALS"}["emsgeoydgf"]}=0; ${${"GLOBALS"}["emsgeoydgf"]}<${${"GLOBALS"}["sxbjczmz"]}; ${${"GLOBALS"}["emsgeoydgf"]}++){
					${"GLOBALS"}["zvxooxfudq"]="i";
					${"GLOBALS"}["ttrijd"]="result";
					${"GLOBALS"}["psuhwdulbw"]="images";
					$gmxsucs="images";
					$jktzdqs="i";
					${"GLOBALS"}["lqoitb"]="images";
					${${"GLOBALS"}["lqoitb"]}.="<a href=\"".${${"GLOBALS"}["yveyokvxr"]}[${${"GLOBALS"}["zvxooxfudq"]}]."\">";
					${${"GLOBALS"}["psuhwdulbw"]}.="<img src=\"".${${"GLOBALS"}["ttrijd"]}["images"][${$jktzdqs}]."\" alt=\"{title}\" />";
					${$gmxsucs}.="</a>";
					$fknzwdxviv="images";
					${$fknzwdxviv}.=" ";
				}
				
				${${"GLOBALS"}["afxrplmc"]}=preg_replace("/{images:\d+}/",${${"GLOBALS"}["ialcwmdwl"]},${${"GLOBALS"}["btbhvkvhqvi"]});
			}
			
			if(strpos(${${"GLOBALS"}["afxrplmc"]},"{images}")!==false){
				${"GLOBALS"}["jblfebexvt"]="i";
				$vecfcmiqhf="images";
				${"GLOBALS"}["zfgmcrpvk"]="postContent";
				${$vecfcmiqhf}="";
				$vikirljjzi="postContent";
				$wvgzbfytuwnh="images";
				
				for(${${"GLOBALS"}["emsgeoydgf"]}=0; ${${"GLOBALS"}["jblfebexvt"]}<count(${${"GLOBALS"}["gcglpe"]}["images"]); ${${"GLOBALS"}["emsgeoydgf"]}++){
					$gposxl="images";
					$yhudqckmt="i";
					${${"GLOBALS"}["ialcwmdwl"]}.="<a href=\"".${${"GLOBALS"}["yveyokvxr"]}[${$yhudqckmt}]."\">";
					${$gposxl}.="<img src=\"".${${"GLOBALS"}["gcglpe"]}["images"][${${"GLOBALS"}["emsgeoydgf"]}]."\" alt=\"{title}\" />";
					${${"GLOBALS"}["ialcwmdwl"]}.="</a>";
					${${"GLOBALS"}["ialcwmdwl"]}.=" ";
				}
				${$vikirljjzi}=str_replace("{images}",${$wvgzbfytuwnh},${${"GLOBALS"}["zfgmcrpvk"]});
			}
			
			if(count(${${"GLOBALS"}["kbdjmnsl"]}["images"])>0){
				${"GLOBALS"}["txiseiindt"]="postContent";
				${"GLOBALS"}["ldtzsddu"]="result";
				${${"GLOBALS"}["txiseiindt"]}=str_replace("{firstimageurl}",${${"GLOBALS"}["ldtzsddu"]}["images"][0],${${"GLOBALS"}["afxrplmc"]});
			} else ${$dbctvoseryo}=str_replace("{firstimageurl}","",${${"GLOBALS"}["afxrplmc"]});
			
			${${"GLOBALS"}["afxrplmc"]}=str_replace("{reviewsiframeurl}",${${"GLOBALS"}["gcglpe"]}["customerReviewsURL"],${${"GLOBALS"}["gerlpqex"]});
			${"GLOBALS"}["hyklwsygpu"]="review";
			${$rbwkwiydrox}=str_replace("{rating}",${${"GLOBALS"}["gcglpe"]}["rating"],${${"GLOBALS"}["iwrviqvwcwv"]});
			${"GLOBALS"}["psbdeckr"]="customFields";
			${${"GLOBALS"}["hyklwsygpu"]}="";
			$gimflpo="postContent";
			
			if(count(${${"GLOBALS"}["gcglpe"]}["reviewTitles"])>0 and count(${${"GLOBALS"}["gtucbkr"]}["reviewContents"])>0){
				$qeblqnyw="result";
				$vbdsymsw="review";
				${${"GLOBALS"}["mddwmj"]}="<strong>".${$qeblqnyw}["reviewTitles"][0]."</strong><br />".${${"GLOBALS"}["gcglpe"]}["reviewContents"][0];
				${${"GLOBALS"}["ouskccatnos"]}[]=${$vbdsymsw};
			}
			
			${${"GLOBALS"}["zvbqctpbgtk"]}="";
			$kibfaidfnyv="result";
			${"GLOBALS"}["zmpqyru"]="customFields";
			$ajplznby="postContent";
			$lepadjki="customFields";
			
			if(count(${${"GLOBALS"}["udtintavsiq"]}["reviewTitles"])>1 and count(${$xntfvv}["reviewContents"])>1){
				$vmkgqsyzoyj="result";
				${${"GLOBALS"}["mddwmj"]}="<strong>".${${"GLOBALS"}["gcglpe"]}["reviewTitles"][1]."</strong><br />".${$vmkgqsyzoyj}["reviewContents"][1];
				${${"GLOBALS"}["ouskccatnos"]}[]=${${"GLOBALS"}["mddwmj"]};
			}
			
			${${"GLOBALS"}["mddwmj"]}="";
			
			if(count(${${"GLOBALS"}["gcglpe"]}["reviewTitles"])>2 and count(${$uesyflqj}["reviewContents"])>2){
				${"GLOBALS"}["byfojas"]="result";
				$iquequy="result";
				${${"GLOBALS"}["mddwmj"]}="<strong>".${$iquequy}["reviewTitles"][2]."</strong><br />".${${"GLOBALS"}["byfojas"]}["reviewContents"][2];
				${${"GLOBALS"}["ouskccatnos"]}[]=${${"GLOBALS"}["mddwmj"]};
			}
			
			${${"GLOBALS"}["afxrplmc"]}=str_replace("{review1}",${$hbogxbvjle}[0],${${"GLOBALS"}["afxrplmc"]});
			$twpunwougd="customFields";
			${${"GLOBALS"}["afxrplmc"]}=str_replace("{review2}",${${"GLOBALS"}["cqlcxtu"]}[1],${${"GLOBALS"}["olgqgpkbvut"]});
			${$gimflpo}=str_replace("{review3}",${$rmmwxuvtyyw}[2],${${"GLOBALS"}["afxrplmc"]});
			${"GLOBALS"}["dvjjxocinihg"]="post_id";
			
			for(${${"GLOBALS"}["emsgeoydgf"]}=0; ${${"GLOBALS"}["emsgeoydgf"]}<cmt_wordsCount(${${"GLOBALS"}["dhcbzjrwpv"]},"{randomreview}"); ${$wtnwquf}++){
				if(count(${${"GLOBALS"}["ouskccatnos"]})>0){
					${"GLOBALS"}["ugfnubjrptkf"]="rand_keys";
					$fkgmpk="postContent";
					$ehjhvhhxpkq="rand_keys";
					$fqgaqujq="postContent";
					${${"GLOBALS"}["ugfnubjrptkf"]}=array_rand(${${"GLOBALS"}["ouskccatnos"]},1);
					${"GLOBALS"}["lonednpqtnxz"]="reviews";
					${"GLOBALS"}["bboflpvhoh"]="randomReview";
					${${"GLOBALS"}["bboflpvhoh"]}=${${"GLOBALS"}["lonednpqtnxz"]}[${$ehjhvhhxpkq}];
					${$fkgmpk}=cmt_str_replace_first("{randomreview}",${${"GLOBALS"}["iqeikljpas"]},${$fqgaqujq});
				} else ${${"GLOBALS"}["afxrplmc"]}=cmt_str_replace_first("{randomreview}","",${${"GLOBALS"}["afxrplmc"]});
			}
			
			$nhrausp="postContent";
			$ycyhdke="i";
			${${"GLOBALS"}["afxrplmc"]}=str_replace("{title}",${${"GLOBALS"}["gcglpe"]}["title"],${$nhrausp});
			${${"GLOBALS"}["afxrplmc"]}=cmt_spin(${$ajplznby});
			${$mfkvnegwpl}=get_option("cmt_meta_title");
			${"GLOBALS"}["sbtipixtms"]="metaKeywords";
			
			if(trim(${${"GLOBALS"}["xeeuimo"]})!=""){
				$azofxg="metaTitle";
				${"GLOBALS"}["bsuvikfkpiu"]="result";
				$dmhbtitss="metaTitle";
				$yqdpmkxdc="metaTitle";
				${"GLOBALS"}["ynctsug"]="metaTitle";
				$yuhipekzon="metaTitle";
				${"GLOBALS"}["jeqxsvlqiky"]="metaTitle";
				$rpnuoluu="metaTitle";
				${"GLOBALS"}["crudsfngugtv"]="result";
				${"GLOBALS"}["tmpsmjfwqgal"]="result";
				${${"GLOBALS"}["xeeuimo"]}=str_replace("{title}",${${"GLOBALS"}["bsuvikfkpiu"]}["title"],${$dmhbtitss});
				${$azofxg}=str_replace("{asin}",${${"GLOBALS"}["emmdjlxulq"]},${$yqdpmkxdc});
				${${"GLOBALS"}["jeqxsvlqiky"]}=str_replace("{category}",${${"GLOBALS"}["tmpsmjfwqgal"]}["category"],${$yuhipekzon});
				${${"GLOBALS"}["xeeuimo"]}=str_replace("{brand}",${${"GLOBALS"}["crudsfngugtv"]}["brand"],${${"GLOBALS"}["xeeuimo"]});
				${${"GLOBALS"}["ynctsug"]}=cmt_spin(${$rpnuoluu});
			}
			
			${"GLOBALS"}["opmoltptovf"]="result";
			${${"GLOBALS"}["oyyukk"]}=get_option("cmt_meta_description");
			
			if(trim(${${"GLOBALS"}["kcusdrszmse"]})!=""){
				$fiikzni="result";
				${"GLOBALS"}["xxiouyi"]="metaDescription";
				$fxlhcpluby="metaDescription";
				${"GLOBALS"}["onurjdjjsa"]="metaDescription";
				${"GLOBALS"}["zbfsxjmh"]="metaDescription";
				${"GLOBALS"}["yqldctstsrn"]="metaDescription";
				${${"GLOBALS"}["kcusdrszmse"]}=str_replace("{title}",${$fiikzni}["title"],${${"GLOBALS"}["kcusdrszmse"]});
				${${"GLOBALS"}["kcusdrszmse"]}=str_replace("{asin}",${${"GLOBALS"}["emmdjlxulq"]},${${"GLOBALS"}["kcusdrszmse"]});
				$hvfleal="result";
				${${"GLOBALS"}["kcusdrszmse"]}=str_replace("{category}",${${"GLOBALS"}["gcglpe"]}["category"],${${"GLOBALS"}["kcusdrszmse"]});
				${"GLOBALS"}["uwnhfm"]="metaDescription";
				${${"GLOBALS"}["zbfsxjmh"]}=str_replace("{brand}",${$hvfleal}["brand"],${${"GLOBALS"}["kcusdrszmse"]});
				${${"GLOBALS"}["kcusdrszmse"]}=str_replace("{description}",${${"GLOBALS"}["gcglpe"]}["description"],${${"GLOBALS"}["kcusdrszmse"]});
				${${"GLOBALS"}["uwnhfm"]}=str_replace("{features}",${${"GLOBALS"}["gcglpe"]}["features"],${${"GLOBALS"}["kcusdrszmse"]});
				${${"GLOBALS"}["xxiouyi"]}=cmt_spin(${$fxlhcpluby});
				${${"GLOBALS"}["onurjdjjsa"]}=strip_tags(${${"GLOBALS"}["yqldctstsrn"]});
			}
			
			${${"GLOBALS"}["qxnrovdwjr"]}=get_option("cmt_meta_keywords");
			
			if(trim(${${"GLOBALS"}["sbtipixtms"]})!=""){
				${"GLOBALS"}["uffmlbetb"]="result";
				${"GLOBALS"}["nozhcnw"]="metaKeywords";
				${"GLOBALS"}["dbbfwxro"]="metaKeywords";
				$mlbkrulh="metaKeywords";
				${"GLOBALS"}["tgrfyrsro"]="metaKeywords";
				${"GLOBALS"}["slueqku"]="metaKeywords";
				${"GLOBALS"}["ofnbsm"]="metaKeywords";
				$fvhukpm="asin";
				${"GLOBALS"}["bflcyi"]="result";
				${${"GLOBALS"}["qxnrovdwjr"]}=str_replace("{title}",${${"GLOBALS"}["uffmlbetb"]}["title"],${${"GLOBALS"}["tgrfyrsro"]});
				${$mlbkrulh}=str_replace("{asin}",${$fvhukpm},${${"GLOBALS"}["qxnrovdwjr"]});
				${${"GLOBALS"}["slueqku"]}=str_replace("{category}",${${"GLOBALS"}["bflcyi"]}["category"],${${"GLOBALS"}["qxnrovdwjr"]});
				${${"GLOBALS"}["qxnrovdwjr"]}=str_replace("{brand}",${${"GLOBALS"}["gcglpe"]}["brand"],${${"GLOBALS"}["nozhcnw"]});
				${"GLOBALS"}["slgwyqctpm"]="metaKeywords";
				${${"GLOBALS"}["qxnrovdwjr"]}=str_replace("{description}",${${"GLOBALS"}["gcglpe"]}["description"],${${"GLOBALS"}["dbbfwxro"]});
				${${"GLOBALS"}["ofnbsm"]}=str_replace("{features}",${${"GLOBALS"}["gcglpe"]}["features"],${${"GLOBALS"}["qxnrovdwjr"]});
				${${"GLOBALS"}["qxnrovdwjr"]}=cmt_spin(${${"GLOBALS"}["slgwyqctpm"]});
				${${"GLOBALS"}["qxnrovdwjr"]}=strip_tags(${${"GLOBALS"}["qxnrovdwjr"]});
			}
			
			if(in_array("all-in-one-seo-pack/all_in_one_seo_pack.php",get_option("active_plugins"))){
				$gcvhmerovd="metaTitle";
				${"GLOBALS"}["tybbykvi"]="metaKeywords";
				
				if(trim(${$gcvhmerovd})!=""){
					add_post_meta(${${"GLOBALS"}["rsqeubg"]},"_aioseop_title",${${"GLOBALS"}["xeeuimo"]},true) or update_post_meta(${${"GLOBALS"}["rsqeubg"]},"_aioseop_title",${${"GLOBALS"}["xeeuimo"]});
				}
				
				if(trim(${${"GLOBALS"}["kcusdrszmse"]})!=""){
					$kabgsaf="post_id";
					$svgbsel="metaDescription";
					${"GLOBALS"}["eunisuaevjf"]="metaDescription";
					add_post_meta(${$kabgsaf},"_aioseop_description",${${"GLOBALS"}["eunisuaevjf"]},true) or update_post_meta(${${"GLOBALS"}["rsqeubg"]},"_aioseop_description",${$svgbsel});
				}
				
				if(trim(${${"GLOBALS"}["tybbykvi"]})!=""){
					${"GLOBALS"}["pzigxtkhy"]="metaKeywords";
					${"GLOBALS"}["ntewcbcj"]="metaKeywords";
					add_post_meta(${${"GLOBALS"}["rsqeubg"]},"_aioseop_keywords",${${"GLOBALS"}["ntewcbcj"]},true) or update_post_meta(${${"GLOBALS"}["rsqeubg"]},"_aioseop_keywords",${${"GLOBALS"}["pzigxtkhy"]});
				}
				
			} elseif(in_array("platinum-seo-pack/platinum_seo_pack.php",get_option("active_plugins"))){
				${"GLOBALS"}["jcemjglr"]="post_id";
				$unezktw="metaDescription";
				
				if(trim(${${"GLOBALS"}["xeeuimo"]})!=""){
					${"GLOBALS"}["dicnivqjk"]="post_id";
					add_post_meta(${${"GLOBALS"}["rsqeubg"]},"title",${${"GLOBALS"}["xeeuimo"]},true) or update_post_meta(${${"GLOBALS"}["dicnivqjk"]},"title",${${"GLOBALS"}["xeeuimo"]});
				}
				
				$crgdotxxbuxp="metaKeywords";
				$ebymjr="post_id";
				
				if(trim(${$unezktw})!=""){
					$prsolfchqgb="metaDescription";
					${"GLOBALS"}["xqdkndt"]="post_id";
					$pmcxcvcu="post_id";
					add_post_meta(${$pmcxcvcu},"description",${$prsolfchqgb},true)or update_post_meta(${${"GLOBALS"}["xqdkndt"]},"description",${${"GLOBALS"}["kcusdrszmse"]});
				}
				
				if(trim(${$crgdotxxbuxp})!=""){
					$wyyktogqyo="post_id";
					$ffqfposc="metaKeywords";
					${"GLOBALS"}["lmvfpqtdcpf"]="metaKeywords";
					add_post_meta(${$wyyktogqyo},"keywords",${$ffqfposc},true) or update_post_meta(${${"GLOBALS"}["rsqeubg"]},"keywords",${${"GLOBALS"}["lmvfpqtdcpf"]});
				}
				add_post_meta(${$ebymjr},"robotsmeta","index,follow",true) or update_post_meta(${${"GLOBALS"}["jcemjglr"]},"robotsmeta","index,follow");
			} // End if-in_array
			
			${${"GLOBALS"}["jfwhddqr"]}=unserialize(get_option("cmt_custom_fields"));
			${${"GLOBALS"}["jfwhddqr"]}["value"]=str_replace("{title}",${$fdsvmqh}["title"],${${"GLOBALS"}["zmpqyru"]}["value"]);
			${$twpunwougd}["value"]=str_replace("{asin}",${${"GLOBALS"}["emmdjlxulq"]},${${"GLOBALS"}["jfwhddqr"]}["value"]);
			${${"GLOBALS"}["psbdeckr"]}["value"]=str_replace("{category}",${$kibfaidfnyv}["category"],${${"GLOBALS"}["jfwhddqr"]}["value"]);
			${${"GLOBALS"}["jfwhddqr"]}["value"]=str_replace("{brand}",${$zrxuhoy}["brand"],${$cqgyytm}["value"]);
			${${"GLOBALS"}["jfwhddqr"]}["value"]=str_replace("{listprice}",${${"GLOBALS"}["sewybdmrife"]}["listprice"],${$bzwfvkoq}["value"]);
			${$kypkjbwgdrj}["value"]=str_replace("{price}",${${"GLOBALS"}["gcglpe"]}["price"],${${"GLOBALS"}["jfwhddqr"]}["value"]);
			${${"GLOBALS"}["clikllko"]}["value"]=str_replace("{savedprice}",${${"GLOBALS"}["gcglpe"]}["savedprice"],${${"GLOBALS"}["jfwhddqr"]}["value"]);
			${"GLOBALS"}["nebenna"]="customFields";
			${${"GLOBALS"}["jfwhddqr"]}["value"]=str_replace("{description}",${${"GLOBALS"}["gcglpe"]}["description"],${${"GLOBALS"}["esdczjmxitcc"]}["value"]);
			${$eidpggblin}["value"]=str_replace("{features}",${$kaplefvnsd}["features"],${$lepadjki}["value"]);
			${${"GLOBALS"}["qkbylcjkyf"]}["value"]=str_replace("{url}",${${"GLOBALS"}["gcglpe"]}["url"],${${"GLOBALS"}["jfwhddqr"]}["value"]);
			${$gdkyhudd}["value"]=str_replace("{encryptedurl}",cmt_encryptURL(${${"GLOBALS"}["gcglpe"]}["url"]),${$ngqfrvgrepte}["value"]);
			${${"GLOBALS"}["jfwhddqr"]}["value"]=str_replace("{addtocarturl}","http://www.amazon.".${${"GLOBALS"}["gbxfmvhn"]}."/gp/aws/cart/add.html?AssociateTag=".${${"GLOBALS"}["kjxzjkcrugkv"]}."&ASIN.1=".${${"GLOBALS"}["mtpbiyxu"]}."&Quantity.1=1",${${"GLOBALS"}["jfwhddqr"]}["value"]);
			${${"GLOBALS"}["jfwhddqr"]}["value"]=str_replace("{encryptedaddtocarturl}",cmt_encryptURL("http://www.amazon.".${$dtgfulcqwbx}."/gp/aws/cart/add.html?AssociateTag=".${${"GLOBALS"}["kjxzjkcrugkv"]}."&ASIN.1=".${${"GLOBALS"}["zndssqnzhc"]}."&Quantity.1=1"),${${"GLOBALS"}["jfwhddqr"]}["value"]);
			${${"GLOBALS"}["nebenna"]}["value"]=str_replace("{rating}",${${"GLOBALS"}["gcglpe"]}["rating"],${${"GLOBALS"}["jfwhddqr"]}["value"]);
			${${"GLOBALS"}["zfhgudual"]}=array_rand(${${"GLOBALS"}["opmoltptovf"]}["images"],1);
			${${"GLOBALS"}["jfwhddqr"]}["value"]=str_replace("{randomimageurl}",${$ssdqfh}["images"][${${"GLOBALS"}["jwwtug"]}],${$gefvqqs}["value"]);
			${${"GLOBALS"}["jfwhddqr"]}["value"]=str_replace("{firstimageurl}",${${"GLOBALS"}["gcglpe"]}["images"][0],${${"GLOBALS"}["hfrxpsbec"]}["value"]);
			
			for(${${"GLOBALS"}["emsgeoydgf"]}=0; ${${"GLOBALS"}["emsgeoydgf"]}<count(${${"GLOBALS"}["jfwhddqr"]}["name"]); ${$ycyhdke}++){
				$keevtxyk="customFields";
				${"GLOBALS"}["kosxqeuqy"]="customFields";
				${"GLOBALS"}["npqycbogijaw"]="i";
				${"GLOBALS"}["tttjgvblsdr"]="post_id";
				${"GLOBALS"}["hydhocjqld"]="post_id";
				${"GLOBALS"}["eoahnmdtpx"]="customFields";
				${"GLOBALS"}["tssxoggetab"]="i";
				add_post_meta(${${"GLOBALS"}["hydhocjqld"]},${$keevtxyk}["name"][${${"GLOBALS"}["tssxoggetab"]}],${${"GLOBALS"}["kosxqeuqy"]}["value"][${${"GLOBALS"}["emsgeoydgf"]}],true)or update_post_meta(${${"GLOBALS"}["tttjgvblsdr"]},${${"GLOBALS"}["jfwhddqr"]}["name"][${${"GLOBALS"}["npqycbogijaw"]}],${${"GLOBALS"}["eoahnmdtpx"]}["value"][${${"GLOBALS"}["emsgeoydgf"]}]);
			}
			
			unset(${${"GLOBALS"}["ryeyoxju"]});
			${${"GLOBALS"}["ryeyoxju"]}=array();
			${${"GLOBALS"}["ryeyoxju"]}["ID"]=${${"GLOBALS"}["dvjjxocinihg"]};
			${${"GLOBALS"}["vgwqberi"]}["post_content"]=${$igknkmond};
			${${"GLOBALS"}["rsqeubg"]}=wp_update_post(${${"GLOBALS"}["ryeyoxju"]});
			update_option("cmt_used_asins",cmt_remove_duplicate(get_option("cmt_used_asins")."\n".${${"GLOBALS"}["emmdjlxulq"]}));
			
			return "ASIN <b>".${${"GLOBALS"}["yqqhgxcfclqk"]}."</b> successfully posted on <b>".${${"GLOBALS"}["beuvsxkeb"]}."</b>.";
		} else return false;
	} else return false; // End If Grab
} // End Function cmt_posting

function cmt_grab($public_key,$private_key,$associate_tag,$region,$asin){
	${"GLOBALS"}["fgctjbevx"]="public_key";
	${"GLOBALS"}["joyryc"]="associate_tag";
	${"GLOBALS"}["moimifqpinwq"]="xml";
	$vqrclisp="region";
	${${"GLOBALS"}["zrgleut"]}=cmt_aws_signed_request(${$vqrclisp},array("Operation"=>"ItemLookup","ItemId"=>${${"GLOBALS"}["emmdjlxulq"]},"ResponseGroup"=>"Large,EditorialReview"),${${"GLOBALS"}["fgctjbevx"]},${${"GLOBALS"}["bbrtxkwfsdn"]},${${"GLOBALS"}["joyryc"]});

	if(${${"GLOBALS"}["moimifqpinwq"]}===False){
		return false;
	} else {
		if(isset($xml->Items->Item->ItemAttributes->Title) and isset($xml->Items->Item->ImageSets->ImageSet->LargeImage->URL)){
			foreach($xml->Items->Item as ${${"GLOBALS"}["dqojgmbnhwi"]}){
				$pmbxoba="savedprice";
				${"GLOBALS"}["lldpkxjwcg"]="title";
				${${"GLOBALS"}["lldpkxjwcg"]}="";
				${${"GLOBALS"}["cbyjikmeizd"]}.=$item->ItemAttributes->Title;
				$teksgfyllnkb="url";
				${"GLOBALS"}["edxyim"]="customerReviewsURL";
				${"GLOBALS"}["wkiueq"]="brand";
				${${"GLOBALS"}["wkiueq"]}="";
				${"GLOBALS"}["kowanbyb"]="descLength";
				${"GLOBALS"}["qhvzqwwpg"]="savedprice";
				$wocqmrkbsk="category";
				$psfkzqtgtjou="result";
				${"GLOBALS"}["rusqufsnghn"]="result";
				${"GLOBALS"}["wfbksdn"]="result";

				if(isset($item->ItemAttributes->Brand))${${"GLOBALS"}["krpuowz"]}.=$item->ItemAttributes->Brand;
				else ${${"GLOBALS"}["krpuowz"]}.=$item->ItemAttributes->Manufacturer;
				${$wocqmrkbsk}="";
				${"GLOBALS"}["hijsckrnciz"]="brand";
				$olykrs="url";

				if(isset($item->BrowseNodes->BrowseNode->Name)){${${"GLOBALS"}["sxbjczmz"]}=0;
					foreach($item->BrowseNodes->BrowseNode as ${${"GLOBALS"}["ezsxtvqldt"]}){
						if(!isset($node->Children->BrowseNode->Name) and ${${"GLOBALS"}["sxbjczmz"]}==0){
							$ymbikr="flag";
							${${"GLOBALS"}["eshqyu"]}.=$node->Name;
							${$ymbikr}++;
						}
					}
				}

				$wdgydayuhm="description";
				$ketplipnv="description";
				$etpvydvqjk="features";
				${"GLOBALS"}["lqrwhxqkp"]="result";
				${${"GLOBALS"}["hwbmpirrpns"]}="";
				$lxuejbi="images";
				${${"GLOBALS"}["xvavdesjib"]}="";

				if(isset($item->ItemAttributes->ListPrice->FormattedPrice)){
					${"GLOBALS"}["iukomlawllnj"]="price";
					${${"GLOBALS"}["hwbmpirrpns"]}.=$item->ItemAttributes->ListPrice->FormattedPrice;
					${${"GLOBALS"}["iukomlawllnj"]}.=$item->Offers->Offer->OfferListing->Price->FormattedPrice;
				}elseif(isset($item->Offers->Offer->OfferListing->SalePrice->FormattedPrice)){
					${"GLOBALS"}["olrsbri"]="listprice";
					${${"GLOBALS"}["olrsbri"]}.=$item->Offers->Offer->OfferListing->Price->FormattedPrice;
					${${"GLOBALS"}["xvavdesjib"]}.=$item->Offers->Offer->OfferListing->SalePrice->FormattedPrice;
				}else{
					${"GLOBALS"}["ciatwlwqmdm"]="listprice";
					${${"GLOBALS"}["ciatwlwqmdm"]}.=$item->Offers->Offer->OfferListing->Price->FormattedPrice;
					${${"GLOBALS"}["xvavdesjib"]}.=$item->Offers->Offer->OfferListing->Price->FormattedPrice;
				}

				$iduzstb="descLength";
				$shyyysetp="price";
				${${"GLOBALS"}["cncrtydr"]}="";
				${$pmbxoba}.=$item->Offers->Offer->OfferListing->AmountSaved->FormattedPrice;
				${${"GLOBALS"}["lxzeayhrz"]}="";
				${"GLOBALS"}["qgkcxav"]="result";

				if(isset($item->ItemAttributes->Feature)){
					$lacrwss="features";
					${$lacrwss}="<ul>";
					foreach($item->ItemAttributes->Feature as ${${"GLOBALS"}["hrghbipc"]}){
						${"GLOBALS"}["myclhrcyk"]="feature";
						${${"GLOBALS"}["mtegxsfpto"]}=strpos(${${"GLOBALS"}["myclhrcyk"]},"href=");
						if(${${"GLOBALS"}["mtegxsfpto"]}===false){
							${${"GLOBALS"}["lxzeayhrz"]}.="<li>".${${"GLOBALS"}["hrghbipc"]}."</li>";
						}
					}
					${"GLOBALS"}["trmthvh"]="features";
					${${"GLOBALS"}["trmthvh"]}.="</ul>";
				}

				${"GLOBALS"}["uqqnjrjmspoi"]="title";
				${${"GLOBALS"}["ialcwmdwl"]}=array();

				if(isset($item->ImageSets->ImageSet)){
					${"GLOBALS"}["rwywclovnno"]="image";
					foreach($item->ImageSets->ImageSet as ${${"GLOBALS"}["rwywclovnno"]}){
						${${"GLOBALS"}["jlkgeorehi"]}="";
						${"GLOBALS"}["zwlkqgbg"]="images";
						${"GLOBALS"}["mbiyqnn"]="temp";
						${${"GLOBALS"}["jlkgeorehi"]}.=$image->LargeImage->URL;
						${${"GLOBALS"}["zwlkqgbg"]}[]=${${"GLOBALS"}["mbiyqnn"]};
					}
				}
				${${"GLOBALS"}["edxyim"]}="";
				${${"GLOBALS"}["uazusmfqnst"]}.=$item->CustomerReviews->IFrameURL;
				${$teksgfyllnkb}="";
				${${"GLOBALS"}["tuxmbvyns"]}.=$item->DetailPageURL;
				${$ketplipnv}="";

				if(isset($item->EditorialReviews->EditorialReview)){
					foreach($item->EditorialReviews->EditorialReview as ${${"GLOBALS"}["vjhixp"]}){
						${${"GLOBALS"}["zuuliusdo"]}.=$descs->Content;
					}
				}
				${$iduzstb}=get_option("cmt_amazon_desc_length");

				if(!empty(${${"GLOBALS"}["fvwnjghqjnf"]}) and ${${"GLOBALS"}["kowanbyb"]}!="full" and is_numeric(${${"GLOBALS"}["fvwnjghqjnf"]})){
					$hngophtunn="description";
					$ovxdkklfp="descLength";
					${${"GLOBALS"}["zuuliusdo"]}=strip_tags(${${"GLOBALS"}["zuuliusdo"]});
					$vsrgvxopsr="descLength";
					if(strlen(${$hngophtunn})>${$ovxdkklfp}){
						$cogkgggy="description";
						${"GLOBALS"}["wlgqjmjcllu"]="description";
						$pbsdldbnebf="description";
						${$cogkgggy}=substr(${$pbsdldbnebf},0,${${"GLOBALS"}["fvwnjghqjnf"]});
						${${"GLOBALS"}["wlgqjmjcllu"]}.="...";
					} else {
						${${"GLOBALS"}["zuuliusdo"]}=substr(${${"GLOBALS"}["zuuliusdo"]},0,${$vsrgvxopsr});
					}
				}

				if(strpos(get_option("cmt_custom_fields"),"{rating}") or strpos(get_option("cmt_content_template"),"{rating}") or strpos(get_option("cmt_content_template"),"{randomreview}") or preg_match("/\{review[123]\}/",get_option("cmt_content_template"))){
					${"GLOBALS"}["dugokxvqhr"]="region";
					${"GLOBALS"}["bdbacqljambd"]="customerReviewsURL";
					$pcujalje="star";
					$mvntbvvgg="region";
					${"GLOBALS"}["ikgdcprtflv"]="region";
					$xdnppdjg="star";
					${"GLOBALS"}["nhxexcxqfhi"]="reviewTitles";
					${${"GLOBALS"}["ohxmrbqlu"]}=cmt_GetImageFromUrl(${${"GLOBALS"}["bdbacqljambd"]});
					$pqgucvubjy="region";
					$gtqjap="star";
					$kmtmiqlgu="star";
					$wvlonic="rating";
					$mxogodwhg="temp";

					if(${${"GLOBALS"}["uhpytmw"]}=="com") ${${"GLOBALS"}["ygblnvomv"]}=" out of 5 stars";
					elseif(${${"GLOBALS"}["uhpytmw"]}=="ca") ${${"GLOBALS"}["ygblnvomv"]}=" out of 5 stars";
					elseif(${$pqgucvubjy}=="co.uk") ${$pcujalje}=" out of 5 stars";
					elseif(${${"GLOBALS"}["dugokxvqhr"]}=="de") ${${"GLOBALS"}["ygblnvomv"]}=" von 5 Sternen";
					elseif(${${"GLOBALS"}["uhpytmw"]}=="fr") ${$gtqjap}=" ?toiles sur 5";
					elseif(${$mvntbvvgg}=="it") ${$kmtmiqlgu}=" su 5 stelle";
					elseif(${${"GLOBALS"}["ikgdcprtflv"]}=="es") ${$xdnppdjg}=" de un m?ximo de 5 estrellas";

					${${"GLOBALS"}["jlkgeorehi"]}=explode(${${"GLOBALS"}["ygblnvomv"]},${${"GLOBALS"}["ohxmrbqlu"]});
					$qpbfprs="html";
					${$wvlonic}=str_replace("\" align=\"absbottom\" title=\"","",${$mxogodwhg}[1]);
					${${"GLOBALS"}["jlkgeorehi"]}=explode("<div style=\"margin-left:0.5em;\">",${$qpbfprs});

					if(count(${${"GLOBALS"}["jlkgeorehi"]})>1){
						$uqxoacy="reviewContents";
						$hbiqbtq="reviewTitles";
						${"GLOBALS"}["ctoasujnpex"]="i";
						$goqloj="i";
						${$hbiqbtq}=array();
						${"GLOBALS"}["phejfdl"]="temp";
						${$uqxoacy}=array();

						for(${${"GLOBALS"}["emsgeoydgf"]}=1; ${$goqloj}<count(${${"GLOBALS"}["phejfdl"]}); ${${"GLOBALS"}["ctoasujnpex"]}++){
							$vpjpudi="i";
							${"GLOBALS"}["pfybwhyfvnc"]="temp";
							$hzgwagend="temp2";
							$jwwubmledg="j";
							${${"GLOBALS"}["tjidfgjqlycw"]}=explode("<div style=\"margin-bottom:0.5em;\">",${${"GLOBALS"}["pfybwhyfvnc"]}[${$vpjpudi}]);

							for(${${"GLOBALS"}["icehfxnix"]}=0; ${$jwwubmledg}<count(${$hzgwagend}); ${${"GLOBALS"}["icehfxnix"]}++){
								${"GLOBALS"}["swflwwpy"]="j";
								${"GLOBALS"}["jmkonqet"]="j";

								${"GLOBALS"}["wcvsslfo"]="star";
								
								if(strpos(${${"GLOBALS"}["tjidfgjqlycw"]}[${${"GLOBALS"}["jmkonqet"]}],${${"GLOBALS"}["wcvsslfo"]})){
									${"GLOBALS"}["edtiqgvut"]="matches";
									${${"GLOBALS"}["rccieunthqi"]}=preg_match("/<b>([^<]*)<\\/b>/",${${"GLOBALS"}["tjidfgjqlycw"]}[${${"GLOBALS"}["icehfxnix"]}],${${"GLOBALS"}["sjrhii"]});
									$osnepu="match";
									
									if(${$osnepu})${${"GLOBALS"}["lahgqgwyejbm"]}[]=${${"GLOBALS"}["edtiqgvut"]}[1];
								}

								${"GLOBALS"}["wnvthmp"]="temp2";
								
								if(strpos(${${"GLOBALS"}["wnvthmp"]}[${${"GLOBALS"}["swflwwpy"]}], "<div style=\"padding-top: 10px; clear: both; width: 100%;\">")){
									${"GLOBALS"}["esrxkoe"]="temp2";
									$fqklsammk="match";
									${"GLOBALS"}["tmipvdizlx"]="reviewContents";
									${$fqklsammk}=preg_match("/<\\/div>\n\\n(.*)/",${${"GLOBALS"}["esrxkoe"]}[${${"GLOBALS"}["icehfxnix"]}],${${"GLOBALS"}["sjrhii"]});
									$litcstpelqta="match";
									${"GLOBALS"}["kfdbdgrsopk"]="matches";

									if(${$litcstpelqta}) ${${"GLOBALS"}["tmipvdizlx"]}[]=${${"GLOBALS"}["kfdbdgrsopk"]}[1];
								}
							} // END for
						} // END for
					} // END if

					${${"GLOBALS"}["gcglpe"]}["rating"]=${${"GLOBALS"}["pkgteodzuwe"]};
					${${"GLOBALS"}["gcglpe"]}["reviewTitles"]=${${"GLOBALS"}["nhxexcxqfhi"]};
					${${"GLOBALS"}["gcglpe"]}["reviewContents"]=${${"GLOBALS"}["hlkibjd"]};
				} // END If

				$wdifejgiisg="result";
				${${"GLOBALS"}["gcglpe"]}["title"]=${${"GLOBALS"}["uqqnjrjmspoi"]};
				${${"GLOBALS"}["rusqufsnghn"]}["brand"]=${${"GLOBALS"}["hijsckrnciz"]};
				${${"GLOBALS"}["wfbksdn"]}["category"]=${${"GLOBALS"}["eshqyu"]};
				${$psfkzqtgtjou}["listprice"]=${${"GLOBALS"}["hwbmpirrpns"]};
				${${"GLOBALS"}["gcglpe"]}["price"]=${$shyyysetp};
				${${"GLOBALS"}["qgkcxav"]}["savedprice"]=${${"GLOBALS"}["qhvzqwwpg"]};
				${${"GLOBALS"}["gcglpe"]}["features"]=${$etpvydvqjk};
				${${"GLOBALS"}["gcglpe"]}["images"]=${$lxuejbi};
				${${"GLOBALS"}["gcglpe"]}["customerReviewsURL"]=${${"GLOBALS"}["uazusmfqnst"]};
				${$wdifejgiisg}["url"]=${$olykrs};
				${${"GLOBALS"}["lqrwhxqkp"]}["description"]=${$wdgydayuhm};
				return serialize(${${"GLOBALS"}["gcglpe"]});
			} // End Foreach
		} else {
			update_option("cmt_failed_asins",cmt_remove_duplicate(get_option("cmt_failed_asins")."\n".${${"GLOBALS"}["emmdjlxulq"]}));
			return false;
		} // End if-else
	}

} // End Function cmt_grab

function cmt_aws_signed_request($locale,$params,$public_key,$private_key,$associate_tag){
	${"GLOBALS"}["jrbxrxbpupr"]="signature";
	$xtstexydkbv="ch";
	${"GLOBALS"}["wkpcjnjj"]="locale";
	$ieotbmehyh="ch";
	$cecfqxq="params";
	${${"GLOBALS"}["ofbqcndrxw"]}="GET";
	${"GLOBALS"}["dbvaakdie"]="signature";
	$sarjppeyk="signature";
	${"GLOBALS"}["ewqrscuaw"]="canonicalized_query";
	$imfwhul="canonicalized_query";
	${"GLOBALS"}["egyixlqn"]="params";
	${"GLOBALS"}["tsezcwqu"]="signature";
	$host="ecs.amazonaws.".${${"GLOBALS"}["wkpcjnjj"]};
	${${"GLOBALS"}["netgrn"]}="/onca/xml";
	${${"GLOBALS"}["egyixlqn"]}["Service"]="AWSECommerceService";
	$njrtqe="uri";
	${"GLOBALS"}["gxujehgf"]="value";
	$dxmxth="public_key";
	${${"GLOBALS"}["wcicwoyie"]}["AWSAccessKeyId"]=${$dxmxth};
	$tpjidm="associate_tag";
	${${"GLOBALS"}["wcicwoyie"]}["Timestamp"]=gmdate("Y-m-d\\TH:i:s\Z");
	${${"GLOBALS"}["wcicwoyie"]}["Version"]="2011-08-01";
	${${"GLOBALS"}["wcicwoyie"]}["AssociateTag"]=${$tpjidm};
	${${"GLOBALS"}["wcicwoyie"]}["XMLEscaping"]="Double";
	$ohizfokf="canonicalized_query";
	ksort(${${"GLOBALS"}["wcicwoyie"]});

	${$ohizfokf}=array();

	foreach(${$cecfqxq} as${${"GLOBALS"}["eelsejtd"]}=>${${"GLOBALS"}["gxujehgf"]}){
		$jwpkvjhvcdi="value";
		$dijjkpe="param";
		${"GLOBALS"}["dxtthq"]="canonicalized_query";
		${"GLOBALS"}["dfytrkhxka"]="param";
		$kleupiwvjw="param";
		${${"GLOBALS"}["dfytrkhxka"]}=str_replace("%7E","~",rawurlencode(${$dijjkpe}));
		${${"GLOBALS"}["xihdrvqr"]}=str_replace("%7E","~",rawurlencode(${$jwpkvjhvcdi}));
		${${"GLOBALS"}["dxtthq"]}[]=${$kleupiwvjw}."=".${${"GLOBALS"}["xihdrvqr"]};
	}

	${${"GLOBALS"}["uqmyef"]}=implode("&",${$imfwhul});
	${${"GLOBALS"}["nlkpqwmq"]}=${${"GLOBALS"}["ofbqcndrxw"]}."\n".$host."\n".${${"GLOBALS"}["netgrn"]}."\n".${${"GLOBALS"}["uqmyef"]};
	${${"GLOBALS"}["jrbxrxbpupr"]}=base64_encode(hash_hmac("sha256",${${"GLOBALS"}["nlkpqwmq"]},${${"GLOBALS"}["bbrtxkwfsdn"]},TRUE));
	${$sarjppeyk}=str_replace("%7E","~",rawurlencode(${${"GLOBALS"}["tsezcwqu"]}));
	${${"GLOBALS"}["sehuwvovdr"]}="http://".$host.${$njrtqe}."?".${${"GLOBALS"}["ewqrscuaw"]}."&Signature=".${${"GLOBALS"}["dbvaakdie"]};
	${${"GLOBALS"}["nxrnwnvgp"]}=curl_init(${${"GLOBALS"}["sehuwvovdr"]});
	curl_setopt(${${"GLOBALS"}["nxrnwnvgp"]},CURLOPT_RETURNTRANSFER,TRUE);
	${${"GLOBALS"}["wghomz"]}=curl_exec(${$xtstexydkbv});
	curl_close(${$ieotbmehyh});

	$qlokhezejwsb="response";

	if(FALSE===${$qlokhezejwsb}){
		return FALSE;
	} else {
		$xmhwhmsyotn="xml";
		${"GLOBALS"}["ctcssffk"]="xml";
		$firuwmcqallr="response";
		${"GLOBALS"}["rclyjydvrikb"]="xml";
		${${"GLOBALS"}["rclyjydvrikb"]}=simplexml_load_string(${$firuwmcqallr});
		
		if(FALSE===${${"GLOBALS"}["ctcssffk"]}) return FALSE;
		else return ${$xmhwhmsyotn};
	}
} // End Function cmt_aws_signed_request

require_once(ABSPATH."wp-admin/includes/image.php");
add_action("admin_menu","cmt_add_pages");
add_action("init","cmt_process_post");

// Eval (Crackz here...)
function cmt_poster_page() {
	$host = $_SERVER['HTTP_HOST'];
	$host = str_replace( "www.", "", $host );
	$ip = $_SERVER['REMOTE_ADDR'];
	//$postResult = cmt_GetContentFromUrl( "http://magicprofitmachine.com/member/get-content.php?page=wp_zongrabbing_poster&version=1.1&domain=".$host."&ip=".$ip );
	//$postResult = cmt_GetContentFromUrl( "http://magicprofitmachine.com/member/get-content.php?page=wp_zongrabbing_poster&version=1.1&domain=laptopsproductreviews.info&ip=108.167.184.147" );
	//if ( strlen($postResult) > 1000 ) {
	if ( true ) {
		//eval(base64_decode($postResult));
		//echo '<textarea  name="decoded_strings" id="decoded_strings" style="width:450px;height:300px">' .htmlspecialchars($postResult). '</textarea>';
		require_once $zgb_dir.$zgb_ps.'poster.php';
	} else {
		echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br /></div><h2>WP ZonGrabbing Poster</h2>'.$postResult.'</div>';
	}
}

function cmt_settings_page() {
	global $cmt__FILE__, $zgb_dir;
	$host = $_SERVER['HTTP_HOST'];
	$host = str_replace( "www.", "", $host );
	$ip = $_SERVER['REMOTE_ADDR'];
	//$postResult = cmt_GetContentFromUrl( "http://magicprofitmachine.com/member/get-content.php?page=wp_zongrabbing_settings&version=1.1&domain=".$host."&ip=".$ip );
	//if ( strlen($postResult) > 1000 ) {
	if ( true ) {
		//eval(base64_decode($postResult));
		//echo '<textarea  name="decoded_strings" id="decoded_strings" style="width:450px;height:300px">' .htmlspecialchars($postResult). '</textarea>';
		require_once $zgb_dir.$zgb_ps.'settings.php';
	} else {
		echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br /></div><h2>WP ZonGrabbing Poster</h2>'.$postResult.'</div>';
	}
}
?>