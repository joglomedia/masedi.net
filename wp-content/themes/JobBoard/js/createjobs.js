function set_login_registration_frm(val)
{
	if(val=='existing_user')
	{
		document.getElementById('contact_detail_id').style.display = 'none';
		document.getElementById('login_user_frm_id').style.display = '';
		//document.getElementById('user_login_or_not').value = val;
	}else  //new_user
	{
		document.getElementById('contact_detail_id').style.display = '';
		document.getElementById('login_user_frm_id').style.display = 'none';
		//document.getElementById('user_login_or_not').value = val;
	}
}
function check_frm()
{
	if(eval(document.getElementById('new_user_id')))
	{
		if(document.getElementById('new_user_id').checked)
		{
			if(document.getElementById('reg_username').value == '')
			{
				alert("Please enter Username");
				document.getElementById('reg_username').focus();
				return false;
			}
			if(document.getElementById('reg_email').value == '')
			{
				alert("Please enter Email");
				document.getElementById('reg_email').focus();
				return false;
			}else
			{
				if (echeck(document.getElementById('reg_email').value)==false){
					document.getElementById('reg_email').focus();
					return false
				}	
			}
			
			if(document.getElementById('reg_pass').value == '')
			{
				alert("Please enter Password");
				document.getElementById('reg_pass').focus();
				return false;
			}else
			if(document.getElementById('reg_pass').value.length < 5)
			{
				alert("Password should minimum of 5 charecters");
				document.getElementById('reg_pass').focus();
				return false;
				return false;
			}
		}
	}

	if(document.getElementById('company_name').value == '')
	{
		alert("Please enter Company Name");
		document.getElementById('company_name').focus();
		return false;
	}
	if(document.getElementById('company_email').value == '')
	{
		alert("Please enter Company Email");
		document.getElementById('company_email').focus();
		return false;
	}
	if (echeck(document.getElementById('company_email').value)==false){
		document.getElementById('company_email').focus();
		return false
	}
	if(document.getElementById('job_location').value == '')
	{
		alert("Please select Location");
		document.getElementById('job_location').focus();
		return false;
	}
	
	var chklength = document.getElementsByName("category[]").length;
	var flag      = false;
	var temp	  ='';
	for(i=1;i<=chklength;i++)
	{
	   temp = document.getElementById("category_"+i+"").checked; 
	   if(temp == true)
	   {
			flag = true;
			break;
		}
	}
	
	if(flag == false)
	{
		alert("Please select atleast one Job Category");
		return false;
	}
	
	if(document.getElementById('post_title').value == '')
	{
		alert("Please enter Position Title");
		document.getElementById('post_title').focus();
		return false;
	}
	 if(post_id == '' || renewal_flag==1)
	 {
	if(!document.getElementById('termandconditions').checked)
	{
		alert("Are you agree with terms and conditions?");
		document.getElementById('termandconditions').focus();
		return false;
	}
	//document.createjob_frm.submit();
	 }
}

function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    alert("Invalid E-mail ID")
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    alert("Invalid E-mail ID")
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }

 		 return true					
	}
if(eval(document.getElementById('new_user_id')))
{
	if(document.getElementById('new_user_id').checked)
	{
		set_login_registration_frm(document.getElementById('new_user_id').value);	
	}
}
if(eval(document.getElementById('existing_user_id')))
{
	if(document.getElementById('existing_user_id').checked)
	{
		set_login_registration_frm(document.getElementById('existing_user_id').value);	
	}
}