<script type="text/javascript">
<?php
global $validation_info;

$js_code = 'jQuery(document).ready(function()
{
';
//$js_code .= '//global vars ';
$js_code .= 'var userform = jQuery("#registerform"); 
'; //form Id
$jsfunction = array();
for($i=0;$i<count($validation_info);$i++)
{
	$name = $validation_info[$i]['name'];
	$espan = $validation_info[$i]['espan'];
	$type = $validation_info[$i]['type'];
	$text = __($validation_info[$i]['text'],'templatic');
	
	$js_code .= '
	var '.$name.' = jQuery("#'.$name.'"); 
	';
	$js_code .= '
	var '.$espan.' = jQuery("#'.$espan.'"); 
	';

	if($type=='select' || $type=='checkbox' || $type=='multicheckbox' || $type=='catcheckbox')
	{
		$msg = sprintf(__("Please select %s",'templatic'),$text);
	}else	{
		$msg = sprintf(__("Please Enter %s",'templatic'),$text);
	}
	
	if($type=='multicheckbox' || $type=='catcheckbox' || $type=='radio')
	{
		$js_code .= '
		function validate_'.$name.'()
		{
			var chklength = document.getElementsByName("'.$name.'[]").length;
			var flag      = false;
			var temp	  = "";
			for(i=1;i<=chklength;i++)
			{
				if(eval(\'document.getElementById("'.$name.'_"+i+"")\'))
				{
				   temp = document.getElementById("'.$name.'_"+i+"").checked; 
				   if(temp == true)
				   {
						flag = true;
						break;
					}
				}
			}
			if("'.$type.'" =="radio")
			  { 
				if (!jQuery("input[@name='.$name.']:checked").val()) {
					flag = false;
				}
				else
				{
					flag = true;	
				}
			  }

			if(flag == false)
			{
				'.$espan.'.text("'.$msg.'");
				'.$espan.'.addClass("message_error2");
				return false;
			}
			else{			
				'.$espan.'.text("");
				'.$espan.'.removeClass("message_error2");
				return true;
			}
			
			return true;
		}
	';
	}else
	{
		$js_code .= '
		function validate_'.$name.'()
		{';
		if($type=='checkbox')
		{
			$js_code .='if(!document.getElementById("'.$name.'").checked)';
		}else
		{
			$js_code .= '
				if(jQuery("#'.$name.'").val() == "")
			';
		}
		$js_code .= '
			{
				'.$name.'.addClass("error");
				'.$espan.'.text("'.$msg.'");
				'.$espan.'.addClass("message_error2");
				return false;
			}
			else';
		if($name=='user_email')
		{
			$js_code .= '
			
			if(jQuery("#'.$name.'").val() != "")
			{
				var a = jQuery("#'.$name.'").val();
				var emailReg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
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
				}
				
				
			}else
			';
		}
		if($name=='pwd')
		{
			if(jQuery("#pwd").val() != jQuery("#cpwd").val()){
				$msg = __("Password could not be match","templatic");
				$js_code .= $name.'.addClass("error");
					'.$espan.'.text("'.$msg.'");
					'.$espan.'.addClass("message_error2");
				return false;';
			}
		}
		$js_code .= '{
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
$js_code .='var pwd = jQuery("#pwd"); 
	
	var pwd_error = jQuery("#pwdInfo"); 
	
		function validate_pwd()
		{
				if(jQuery("#pwd").val() == "")
			
			{
				pwd.addClass("error");
				pwd_error.text("Please enter password");
				pwd_error.addClass("message_error2");
				return false;
			}
			else{
				pwd.removeClass("error");
				pwd_error.text("");
				pwd_error.removeClass("message_error2");
				return true;
			}
		}
		pwd.blur(validate_pwd);
		pwd.keyup(validate_pwd); 
		var cpwd = jQuery("#cpwd"); 
	
	var cpwd_error = jQuery("#cpwdInfo"); 
	
		function validate_cpwd()
		{
				if(jQuery("#cpwd").val() == "")
			
			{
				cpwd.addClass("error");
				cpwd_error.text("Please enter confirm password");
				cpwd_error.addClass("message_error2");
				return false;
			} else if(jQuery("#cpwd").val() != jQuery("#pwd").val()) {
				cpwd.addClass("error");
				cpwd_error.text("Please confirm your password");
				cpwd_error.addClass("message_error2");
				return false;
			}
			else{
				cpwd.removeClass("error");
				cpwd_error.text("");
				cpwd_error.removeClass("message_error2");
				return true;
			}
		}
		cpwd.blur(validate_cpwd);
		cpwd.keyup(validate_cpwd);
		';

if($jsfunction)
{
	$jsfunction_str = implode(' & ', $jsfunction);	
}

//$js_code .= '//On Submitting ';
$js_code .= '	
userform.submit(function()
{
	if('.$jsfunction_str.' & validate_pwd() & validate_cpwd())
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

</script>