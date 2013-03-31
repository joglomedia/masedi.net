<?php
require_once "include.php";
require_once (dirname($cmt__FILE__)."/../../../wp-config.php");

if($_GET["code"]==get_option("cmt_ucode")){
	require_once "functions.php";

	ini_set("max_execution_time",300);
	$asins=array();
	$array=array_diff(array_diff(cmt_remove_duplicate2(get_option("cmt_asins")),cmt_remove_duplicate2(get_option("cmt_used_asins"))),cmt_remove_duplicate2(get_option("cmt_failed_asins")));

	foreach($array as $value){
		$asins[]=$value;
	}

	if(count($asins)>0){
		if($_GET["draft"]=="true") $saveAsDraft=true;
		else $saveAsDraft=false;

		if($_GET["upload"]=="true") $uploadImages=true;
		else $uploadImages=false;

		if(is_numeric($_GET["num"]) and $_GET["num"]>0) $num=$_GET["num"];
		else $num=1;
		$cmt_message="";
		$today=date("Y-m-d");

		$i=0;
		$j=0;

		while($j<$num and $i<count($asins)){
			$date=date("Y-m-d H:i:s",rand(strtotime($today),strtotime($today)+86399));
			$success=false;
			
			while(!$success and $i<count($asins)){
				$success=cmt_posting($i[$i],$date,$saveAsDraft,$uploadImages);

				if($success){
					$cmt_message.="<div class=\"updated\"><p>".$success."</p></div>";
					echo"<p>".$success."</p>";
					$j++;
				}else{
					$cmt_message.="<div class=\"error\"><p>Grabbing or posting failed for ASIN <b>".$asins[$i]."</b>. Please check your ASIN or internet connection.</p></div>";
					echo"<p>Grabbing or posting failed for ASIN <b>".$asins[$i]."</b>. Please check your ASIN or internet connection.</p>";
				}
				update_option("cmt_message",$cmt_message);
				$i++;
			}
		}
	}
}
?>
