var loginRadiusSharingTheme = document.getElementsByName('LoginRadius_settings[LoginRadius_sharingTheme]');
var loginRadiusCounterTheme = document.getElementsByName('LoginRadius_settings[LoginRadius_counterTheme]');
var loginRadiusSharingProviders = document.getElementsByName('LoginRadius_settings[sharing_providers][]');

window.onload = function(){
	loginRadiusToggleShareTheme(loginRadiusSharingTheme[0].value);
	loginRadiusToggleCounterTheme(loginRadiusCounterTheme[0].value);
	if(document.getElementsByName('LoginRadius_settings[rearrange_providers][]').length == 0){
		for(var i = 0; i < loginRadiusSharingProviders.length; i++){
			if(loginRadiusSharingProviders[i].checked){
				loginRadiusRearrangeProviderList(loginRadiusSharingProviders[i]);
			}
		}
	}
	var loginRadiusEmailRequired = document.getElementsByName('LoginRadius_settings[LoginRadius_dummyemail]');
	for(var i = 0; i < loginRadiusEmailRequired.length; i++){
		if(loginRadiusEmailRequired[i].checked && loginRadiusEmailRequired[i].value == 'notdummyemail'){
			document.getElementById('loginRadiusPopupMessage').style.display = 'table-row'; 
			document.getElementById('loginRadiusPopupErrorMessage').style.display = 'table-row';
		}else if(loginRadiusEmailRequired[i].checked && loginRadiusEmailRequired[i].value == 'dummyemail'){
			document.getElementById('loginRadiusPopupMessage').style.display = 'none'; 
			document.getElementById('loginRadiusPopupErrorMessage').style.display = 'none';
		}
	}
	// login redirection
	var loginRadiusLoginRedirection = document.getElementsByName('LoginRadius_settings[LoginRadius_redirect]');
	for(var i = 0; i < loginRadiusLoginRedirection.length; i++){
		if(loginRadiusLoginRedirection[i].checked){
			if(loginRadiusLoginRedirection[i].value == "samepage"){
				document.getElementById('loginRadiusCustomLoginUrl').style.display = 'none'; 
			}else if(loginRadiusLoginRedirection[i].value == "homepage"){
				document.getElementById('loginRadiusCustomLoginUrl').style.display = 'none'; 
			}else if(loginRadiusLoginRedirection[i].value == "dashboard"){
				document.getElementById('loginRadiusCustomLoginUrl').style.display = 'none'; 
			}else if(loginRadiusLoginRedirection[i].value == "bp"){
				document.getElementById('loginRadiusCustomLoginUrl').style.display = 'none'; 
			}else if(loginRadiusLoginRedirection[i].value == "custom"){
				document.getElementById('loginRadiusCustomLoginUrl').style.display = 'block';
			}
		}
	}
	// logout redirection
	var loginRadiusLogoutRedirection = document.getElementsByName('LoginRadius_settings[LoginRadius_loutRedirect]');
	for(var i = 0; i < loginRadiusLogoutRedirection.length; i++){
		if(loginRadiusLogoutRedirection[i].checked){
			if(loginRadiusLogoutRedirection[i].value == "homepage"){
				document.getElementById('loginRadiusCustomLogoutUrl').style.display = 'none'; 
			}else if(loginRadiusLogoutRedirection[i].value == "custom"){
				document.getElementById('loginRadiusCustomLogoutUrl').style.display = 'block';
			}
		}
	}
}
jQuery(function(){
    jQuery("#loginRadiusSortable").sortable({
      revert: true
    });
});
// prepare rearrange provider list
function loginRadiusRearrangeProviderList(elem){
	var ul = document.getElementById('loginRadiusSortable');
	if(elem.checked){
		var listItem = document.createElement('li');
		listItem.setAttribute('id', 'loginRadiusLI'+elem.value);
		listItem.setAttribute('title', elem.value);
		listItem.setAttribute('class', 'lrshare_iconsprite32 lrshare_'+elem.value);
		// append hidden field
		var provider = document.createElement('input');
		provider.setAttribute('type', 'hidden');
		provider.setAttribute('name', 'LoginRadius_settings[rearrange_providers][]');
		provider.setAttribute('value', elem.value);
		listItem.appendChild(provider);
		ul.appendChild(listItem);
	}else{
		ul.removeChild(document.getElementById('loginRadiusLI'+elem.value));
	}
}
// limit maximum number of providers selected in sharing
function loginRadiusSharingLimit(elem){
	var checkCount = 0;
	for(var i = 0; i < loginRadiusSharingProviders.length; i++){
		if(loginRadiusSharingProviders[i].checked){
			// count checked providers
			checkCount++;
			if(checkCount >= 10){
				elem.checked = false;
				document.getElementById('loginRadiusSharingLimit').style.display = 'block';
				return;
			}
		}
	}
}
// toggle horizontal and vertical theme selection
function loginRadiusToggleShareTheme(theme){
	loginRadiusSharingTheme[0].value = theme;
	if(theme == "vertical"){
		verticalDisplay = 'table-row';
		horizontalDisplay = 'none';
	}else{
		verticalDisplay = 'none';
		horizontalDisplay = 'table-row';
	}
	document.getElementById('login_radius_vertical').style.display = verticalDisplay;
	document.getElementById('login_radius_vertical_position').style.display = verticalDisplay;
	document.getElementById('login_radius_sharing_offset').style.display = verticalDisplay;
	document.getElementById('login_radius_horizontal_top').style.display = horizontalDisplay;
	document.getElementById('login_radius_horizontal_bottom').style.display = horizontalDisplay;
}

// display options according to the selected counter theme
function loginRadiusToggleCounterTheme(theme){
	loginRadiusCounterTheme[0].value = theme;
	if(theme == "vertical"){
		verticalDisplay = 'table-row';
		horizontalDisplay = 'none';
	}else{
		verticalDisplay = 'none';
		horizontalDisplay = 'table-row';
	}
	document.getElementById('login_radius_vertical_counter').style.display = verticalDisplay;
	document.getElementById('login_radius_vertical_position_counter').style.display = verticalDisplay;
	document.getElementById('login_radius_counter_offset').style.display = verticalDisplay;
	document.getElementById('login_radius_horizontal_top_counter').style.display = horizontalDisplay;
	document.getElementById('login_radius_horizontal_bottom_counter').style.display = horizontalDisplay;
}

// assign update code function onchange event of elements
function loginRadiusAttachFunction(elems){
	for(var i = 0; i < elems.length; i++){
		elems[i].onchange = loginRadiusToggleTheme;
	}
}
function loginRadiusGetChecked(elems){
	var checked = [];
	// loop over all 
	for(var i=0; i<elems.length; i++){
		if(elems[i].checked){
			checked.push(elems[i].value);
		}
	}
	return checked;
}
function loginRadiusInterfacePosition(checkVar, elemName){
	if(elemName == "LoginRadius_settings[LoginRadius_loginform]") 
		var elem = document.getElementsByName('LoginRadius_settings[LoginRadius_loginformPosition]'); 
	else if(elemName == "LoginRadius_settings[LoginRadius_regform]") 
		var elem = document.getElementsByName('LoginRadius_settings[LoginRadius_regformPosition]'); 
	else if(elemName == "LoginRadius_settings[LoginRadius_loginformPosition]"){ 
		var elem = document.getElementsByName('LoginRadius_settings[LoginRadius_loginform]'); 
	}else if(elemName == "LoginRadius_settings[LoginRadius_regformPosition]"){ 
		var elem = document.getElementsByName('LoginRadius_settings[LoginRadius_regform]'); 
	} 
	 
	if(!checkVar){ 
		elem[0].checked = false; 
		elem[1].checked = false; 
	}else{ 
		elem[0].checked = true; 
	} 
}
jQuery(function(){
    function m(n, d){
        P = Math.pow;
        R = Math.round
        d = P(10, d);
        i = 7;
        while(i) {
            (s = P(10, i-- * 3)) <= n && (n = R(n * d / s) / d + "KMGTPE"[i])
        }
        return n;
    }
    jQuery.ajax({
        url: 'http://api.twitter.com/1/users/show.json',
        data: {
            screen_name: 'LoginRadius'
        },
        dataType: 'jsonp',
        success: function(data) {
           count = data.followers_count;
           jQuery('#followers').html(m(count, 1));
        }
    });
});