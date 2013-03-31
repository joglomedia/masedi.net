<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
//<![CDATA[
<?php
global $validation_info;
$js_code = '';
//$js_code .= '//global vars ';
$js_code .= 'var resumeform = jQuery("#resumeform"); 
'; //form Id
$jsfunction = array();
for($i=0;$i<count($validation_info);$i++) {
	$title = $validation_info[$i]['title'];
	$name = $validation_info[$i]['name'];
	$espan = $validation_info[$i]['espan'];
	$type = $validation_info[$i]['type'];
	$text = $validation_info[$i]['text'];
	$validation_type = $validation_info[$i]['validation_type'];
	
	$js_code .= '
	dml = document.forms[\'resumeform\'];
	var '.$name.' = jQuery("#'.$name.'"); ';
	$js_code .= '
	var '.$espan.' = jQuery("#'.$espan.'"); 
	';

	if($type=='selectbox' || $type=='checkbox')
	{
		$msg = sprintf($text);
	}else
	{
		$msg = sprintf($text);
	}
	
	if($type == 'multicheckbox' || $type=='checkbox' || $type=='radio')
	{
		$js_code .= '
		function validate_'.$name.'()
		{
			var chklength = jQuery("#'.$name.'").length;
			if("'.$type.'" =="multicheckbox")
			  {
				chklength = document.getElementsByName("'.$name.'[]").length;
			  }
			if("'.$name.'" == "category"){
				chklength = document.getElementsByName("'.$name.'[]").length;
			}
			if("'.$type.'" =="radio")
			  {
				if (!jQuery("input[@name='.$name.']:checked").val()) {
					flag = 1;
				}
			  }
			var temp	  = "";
			var i = 0;
			chk_'.$name.' = document.getElementsByName("'.$name.'[]");
			if("'.$name.'" == "category"){
				chk_'.$name.' = document.getElementsByName("'.$name.'[]");
			}
			if(chklength == 0){
			
				if ((chk_'.$name.'.checked == false)) {
					flag = 1;	
				} 
			} else {
				var flag      = 0;
				for(i=0;i<chklength;i++) {
					
					if ((chk_'.$name.'[i].checked == false)) { ';
						$js_code .= '
						flag = 1;	
					} else {
						flag = 0;
						break;
					}
				}
				
			}
			if(flag == 1)
			{
				'.$espan.'.text("'.$msg.'");
				'.$espan.'.addClass("message_error2");
				if("'.$name.'" == "category")
				 {
					jQuery("#category_span").html("'.$msg.'");	 
				 }
				return false;
			}
			else{			
				'.$espan.'.text("");
				'.$espan.'.removeClass("message_error2");
				return true;
			}
			alert(flag);
			
		}
	';
	}else {
		$js_code .= '
		function validate_'.$name.'()
		{';
			if($validation_type == 'email') {
				$js_code .= '
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				if(jQuery("#'.$name.'").val() == "") { ';
					$msg = __("Please provide your email address","templatic");
				$js_code .= $name.'.addClass("error");
					'.$espan.'.text("'.$msg.'");
					'.$espan.'.addClass("message_error2");
				return false;';
					
				$js_code .= ' } else if(!emailReg.test(jQuery("#'.$name.'").val())) { ';
					$msg = __("Please provide valid email address","templatic");
					$js_code .= $name.'.addClass("error");
					'.$espan.'.text("'.$msg.'");
					'.$espan.'.addClass("message_error2");
					return false;';
				$js_code .= '
				} else {
					'.$name.'.removeClass("error");
					'.$espan.'.text("");
					'.$espan.'.removeClass("message_error2");
					return true;
				}';
			} if($validation_type == 'phone'){
				$js_code .= '
				var phonereg = /^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/;
				if(jQuery("#'.$name.'").val() == "") { ';
					$msg = $text;
					$js_code .= $name.'.addClass("error");
					'.$espan.'.text("'.$msg.'");
					'.$espan.'.addClass("message_error2");
				return false;';
					
				$js_code .= ' } else if(!phonereg.test(jQuery("#'.$name.'").val())) { ';
					$msg = "Enter Valid Phone No.";
					$js_code .= $name.'.addClass("error");
					'.$espan.'.text("'.$msg.'");
					'.$espan.'.addClass("message_error2");
					return false;';
				$js_code .= '
				} else {
					'.$name.'.removeClass("error");
					'.$espan.'.text("");
					'.$espan.'.removeClass("message_error2");
					return true;
				}';
			}if($validation_type == 'digit'){
				$js_code .= '
				var digitreg = /^[0-9.,]/;
				if(jQuery("#'.$name.'").val() == "") { ';
					$msg = $text;
				$js_code .= $name.'.addClass("error");
					'.$espan.'.text("'.$msg.'");
					'.$espan.'.addClass("message_error2");
				return false;';
					
				$js_code .= ' } else if(!digitreg.test(jQuery("#'.$name.'").val())) { ';
					$msg = "This field allow only digit.";
					$js_code .= $name.'.addClass("error");
					'.$espan.'.text("'.$msg.'");
					'.$espan.'.addClass("message_error2");
					return false;';
				$js_code .= '
				} else {
					'.$name.'.removeClass("error");
					'.$espan.'.text("");
					'.$espan.'.removeClass("message_error2");
					return true;
				}';
			}
			$js_code .= 'if(jQuery("#'.$name.'").val() == "")';
			
		
		$js_code .= '
			{
				'.$name.'.addClass("error");
				'.$espan.'.text("'.$msg.'");
				'.$espan.'.addClass("message_error2");
				return false;
			}
			else{
				'.$name.'.removeClass("error");
				'.$espan.'.text("");
				'.$espan.'.removeClass("message_error2");
				return true;
			}
		}
		';
	}
	//$js_code .= '//On blur ';
	$js_code .= $name.'.blur(validate_'.$name.'); ';
	
	//$js_code .= '//On key press ';
	$js_code .= $name.'.keyup(validate_'.$name.'); ';
	
	$jsfunction[] = 'validate_'.$name.'()';

}

if($jsfunction)
{
	$jsfunction_str = implode(' & ', $jsfunction);	
}

//$js_code .= '//On Submitting ';
$js_code .= '	
resumeform.submit(function()
{
	var id_value = jQuery(".apply_resume").val();
	if(id_value != "" && id_value)
	 { 
		  var valid_extensions = /(.txt|.pdf|.doc|.xls|.xlsx|.csv|.docx|.rar|.zip)$/i; 
		  if(valid_extensions.test(id_value))
		  {
			  
		  }
		  else
		  {
		   jQuery("#apply_resume_error").html("You are uploading invalid file type. Allowed file types are : txt, pdf, doc, xls, csv, docx, xlsx, zip, rar");
		   return false;
		  }
	 }
	if('.$jsfunction_str.')
	{
		return true
	}
	else
	{
		return false;
	}
});
';

$js_code .= '
});';

echo $js_code;
?>
//]]>

</script>