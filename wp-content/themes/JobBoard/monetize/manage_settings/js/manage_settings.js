function EnterNumber(e)	{
	var keynum;
	var keychar;
	if(window.event) // IE 
	{
		keynum = e.keyCode;
	}else if(e.which) // Netscape/Firefox/Opera
	{
		keynum = e.which;
	}			
	if(keynum == 8){
		var numcheck = new RegExp("^[^a-z^A-Z]");			
	}else{
		var numcheck = new RegExp("^[0-9.,]");
	}
	keychar = String.fromCharCode(keynum);	
	return numcheck.test(keychar);
}
function confirmSubmit()
{
var agree=confirm("Are you sure you want to delete?");
if (agree)
	return true ;
else
	return false ;
}
jQuery(document).ready(function(){
	var check_position = '';
	var symbol = '$';
	jQuery('#symbol_position').change(function(){
		check_position = jQuery('#symbol_position').val();
		if(check_position == '1')
		{
			jQuery('#ex_position').html(symbol + '500');
		}else if(check_position == '2')
		{
			jQuery('#ex_position').html(symbol + ' 500');
		}else if(check_position == '3')
		{
			jQuery('#ex_position').html('500' + symbol);
		}else if(check_position == '4')
		{
			jQuery('#ex_position').html('500 ' + symbol);
		}
	});
});
// TinyMCE BOF
tinyMCE.init({
		// General options
		mode : "textareas",
		editor_selector : "mce",
		theme : "advanced",
		plugins :"advimage,advlink,emotions,iespell,",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,blockquote,|,link,unlink,anchor,image,code",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		width : "550",
		height : "150",
		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
		username : "Some User",
		staffid : "991234",
		}
	});

// TinyMCE EOF

function IsNumeric(sText) {
	var ValidChars = "123456789";
	var IsNumber=true;
	var Char;
	for (i = 0; i < sText.length && IsNumber == true; i++){ 
		Char = sText.charAt(i); 
		if (ValidChars.indexOf(Char) == -1){
			IsNumber = false;
		}
	}
	return IsNumber;
}
function perIsNumeric(sText) {
	var ValidChars = "0123456789.";
	var IsNumber=true;
	var Char;
	for (i = 0; i < sText.length && IsNumber == true; i++){ 
		Char = sText.charAt(i); 
		if (ValidChars.indexOf(Char) == -1){
			IsNumber = false;
		}
	}
	return IsNumber;
}
function currency_validation() {
	var ErrorMsg = "Following fields must be corrected \n\n";
	var Error = 0;
	if(document.getElementById('currency_name').value=='')
	{
		ErrorMsg = ErrorMsg + "Please Enter Currency Name \n\n";
		Error = 1;
	}
	if(document.getElementById('currency_code').value=='')
	{
		ErrorMsg = ErrorMsg + "Please Enter Currency Code \n\n";
		Error = 1;
	}if(document.getElementById('currency_symbol').value=='')
	{
		ErrorMsg = ErrorMsg + "Please Enter Currency Symbol \n\n";
		Error = 1;
	}
	if(Error == 1){
		alert(ErrorMsg);
		return false;
	}
	else{
		return true;
	}
}
function city_validation(){
	if(document.getElementById('title').value=='')
	{
		alert("Please enter Title");
		return false;
	}
	return true;
}
function price_validation()
{
	if(document.getElementById('title').value=='')
	{
		alert("Please enter Title");
		return false;
	}
	return true;
}
function chk_userfield_form()
{
	if(document.custom_fields_frm.site_title.value == "")

	{
		alert("Please Enter Frontend Title");

		document.custom_fields_frm.site_title.focus();

		return false;

	}
	if(document.custom_fields_frm.htmlvar_name.value == "")

	{

		alert("Please Enter HTML Variable Name");

		document.custom_fields_frm.htmlvar_name.focus();

		return false;

	}
}
function chk_field_form()
{
	if(document.custom_fields_frm.site_title.value == "")	{
		alert("Please Enter Frontend Title");
		document.custom_fields_frm.site_title.focus();
		return false;
	}
	if(document.custom_fields_frm.htmlvar_name.value == ""){
		alert("Please Enter HTML Variable Name");
		document.custom_fields_frm.htmlvar_name.focus();
		return false;
	}
}
function edit_cat(catid,price)
{
	if(document.getElementById('cat_edit_'+catid).style.display)
	{
		document.getElementById('cat_edit_'+catid).style.display = '';
		document.getElementById('pricecat'+catid).style.display = 'none';
		document.getElementById('cat_price'+catid).style.display = '';
		document.getElementById('add_cat'+catid).style.display = '';
		document.getElementById('edit_cat'+catid).style.display = 'none';
		
	}else
	{
		document.getElementById('cat_edit_'+catid).style.display = 'none';	
		document.getElementById('cat_price'+catid).style.display = 'none';
		document.getElementById('pricecat'+catid).style.display = '';
		document.getElementById('add_cat'+catid).style.display = 'none';
		document.getElementById('edit_cat'+catid).style.display = '';
	}
}
function openUl(uid)
{
	if(document.getElementById('term_'+uid).style.display)
	{
		document.getElementById('term_'+uid).style.display = '';
	}else
	{
		document.getElementById('term_'+uid).style.display = 'none';	
	}
}

function rec_div_show(str)
{
	if(str =='1'){
    jQuery('#rec_div').slideDown('slow');
	}else{
	jQuery('#rec_div').slideUp('fast');
	}
}
function show_price_detail(str)
{
	if(document.getElementById('price_'+str).style.display)
	{
		document.getElementById('price_'+str).style.display = '';
	}else
	{
		document.getElementById('price_'+str).style.display = 'none';	
	}
}
function createObject() {
var request_type;
var browser = navigator.appName;
if(browser == "Microsoft Internet Explorer"){
request_type = new ActiveXObject("Microsoft.XMLHTTP");
}else{
request_type = new XMLHttpRequest();
}
return request_type;
}
