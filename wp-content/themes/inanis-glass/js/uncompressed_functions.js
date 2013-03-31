// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// *# Inanis Glass Javascript Functions                          *#
// *# Authors: Inanis (http://www.inanis.net                     *#
// *#          Dynamic Drive: http://www.dynamicdrive.com        *#
// *#                                                            *#
// *# Functional Script Compressed by:                           *#
// *#           http://developer.yahoo.com/yui/compressor/       *#
// *#                                                            *#
// *# NOTE: This is the uncompressed version of the file, for    *#
// *# reference and development purposes. The compressed version *#
// *# of the file is the active one. If you modify this file,    *# 
// *# your changes will not become active unless you replace the *#
// *# active file (functions.js) with this file.                 *#
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// *# Style Sheet Switcher version 1.1x April 13, 2008           *#
// *# Author: Dynamic Drive: http://www.dynamicdrive.com         *#
// *# Usage terms: http://www.dynamicdrive.com/notice.htm        *#
// *# Modified/Compressed for use in Inanis Wordpress Themes     *#
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// var defaultstyle = ""; // Default Theme
// var manual_or_random = "manual";

var randomsetting="7 days";
var cookiename="moot";
var cookiepath="/";
var cookiesecure="";

if(manual_or_random=="manual"){
  var selectedtitle=getCookie(cookiename);
  if(selectedtitle==null){setStylesheet(defaultstyle)}
  else{setStylesheet(selectedtitle)}
}

else if(manual_or_random=="random"){
  if(randomsetting=="eachtime"){setStylesheet("","random")}
  else if(randomsetting=="sessiononly"){
    if(getCookie("mysheet_s")==null){
      document.cookie="mysheet_s="+setStylesheet("","random")+"; path=/"
    }
    else{
      setStylesheet(getCookie("mysheet_s"))
    }
  }
  else if(randomsetting.search(/^[1-9]+ days/i)!=-1){
    if(getCookie("mysheet_r")==null||parseInt(getCookie("mysheet_r_days"))!=parseInt(randomsetting)){
      setCookie("mysheet_r",setStylesheet("","random"),parseInt(randomsetting));setCookie("mysheet_r_days",randomsetting,parseInt(randomsetting))
    }
  }
  else {
    setStylesheet(getCookie("mysheet_r"))
  }
}

function setStylesheet(title,randomize){
  var i,cacheobj,altsheets=[""];for(i=0;(cacheobj=document.getElementsByTagName("link")[i]);i++){if(cacheobj.getAttribute("rel").toLowerCase()=="alternate stylesheet"&&cacheobj.getAttribute("title")){cacheobj.disabled=true;altsheets.push(cacheobj);if(cacheobj.getAttribute("title")==title){cacheobj.disabled=false}}}if(typeof randomize!="undefined"){var randomnumber=Math.floor(Math.random()*altsheets.length);altsheets[randomnumber].disabled=false}return(typeof randomize!="undefined"&&altsheets[randomnumber]!="")?altsheets[randomnumber].getAttribute("title"):""
}
  
function getCookie(Name){
  var re=new RegExp(Name+"=[^;]+","i");
  if(document.cookie.match(re)){
    return document.cookie.match(re)[0].split("=")[1]
  }
  return null
}

function setCookie(name,value,days,path,domain,secure){
  var expireDate=new Date();
  var expstring=(typeof days!="undefined")?expireDate.setDate(expireDate.getDate()+parseInt(days)):expireDate.setDate(expireDate.getDate()-5);
  document.cookie=name+"="+escape(value)+(days?"; expires="+expireDate.toGMTString():"")+(path?"; path="+path:"")+(domain?"; domain="+domain:"")+(secure?"; secure":"")
}
  
function chooseStyle(styletitle,days){
  if(document.getElementById){
    setStylesheet(styletitle);
    setCookie(cookiename,styletitle,days,cookiepath,cookiesecure)
  }
}
  
function deleteCookie(name){
  if(getCookie(name)){
    document.cookie=name+"="+((cookiepath)?"; path="+cookiepath:"")+";expires = 01/01/2000 00:00:00";alert(name+" - Cookie Deleted")
  }
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// *#                      Clock Functions                       *#
// *#          Author: Inanis (http://www.inanis.net)            *#
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
function init()
	{
	timeDisplay=document.createTextNode("");
	document.getElementById("clockhr").appendChild(timeDisplay);
	timeDisplay1=document.createTextNode("");
	document.getElementById("clockmin").appendChild(timeDisplay1);
	timeDisplay2=document.createTextNode("");
	document.getElementById("clockpart").appendChild(timeDisplay2)
}
function updateClock()
	{
	var currentTime=new Date();
	var currentHours=currentTime.getHours();
	var currentMinutes=currentTime.getMinutes();
	currentMinutes=(currentMinutes<10?"0":"")+currentMinutes;
	var timeOfDay;
	//var timestyle = 1;
	
	if (timestyle == 2 ){
  	//24 hour display
  	timeOfDay=" ";
	}
	else {
	  //12 hour display
	  timeOfDay=(currentHours<12)?"AM":"PM";
  	currentHours=(currentHours>12)?currentHours-12:currentHours;
  	currentHours=(currentHours===0)?12:currentHours;
  }
  
	document.getElementById("clockhr").firstChild.nodeValue=currentHours;
	document.getElementById("clockmin").firstChild.nodeValue=currentMinutes;
	document.getElementById("clockpart").firstChild.nodeValue=timeOfDay
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
//          Menu Animation and Mouse Hanlder Functions           *#
//            Author: Inanis (http://www.inanis.net)             *#
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Default variables and values
var $sbox;
var OrbWasClicked = 0;
var MenuIsUp=0;
var l=0;
var w=0;
var lt=0;
var throb=0;
var throbcount=0;
var FlyOutOpen=0;
var FlyOutSum = 0;
var FlyOutWasClicked = 0;
var mhovIsUp = 0;
var mhovLastUp = 0;
var mhovering = 0;
var lhovering=0;
var timer = "";
var tid;
var qlm=0;
var MOWasClicked=0;
var MOOpen=0;
var osIsNix=0;
var winsize=0;
var smtimer;
var rsanimConst=300;
var rstimer;
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Search Box Handlers
function SearchBoxFocus(e) {
  if (e.value == $sboxtext ){
    e.value = "";
    e.style.fontStyle = "normal";
  }
}

function SearchBoxBlur(e) {
  if (e.value == "" ){
    e.style.fontStyle = "italic";
    e.value = $sboxtext;
  }
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Options Menu Hanlders (fadein, fadeout, master reset)
function FadeOutMenu(){
    SMReset();    
    jQuery(document).ready(function($) {$(document.getElementById('StartMenu')).fadeOut(125, function(){document.getElementById('StartMenu').style.left = "-1000px";});}); 
    if (document.getElementById("smif")){
        document.getElementById("smif").style.display="none";
        document.getElementById("avif").style.display="none";
        document.getElementById("smif").style.visibility="hidden";
        document.getElementById("avif").style.visibility="hidden";
      }
}

function FadeInMenu(){
    document.getElementById('StartMenu').style.left = "0px"; 
    jQuery(document).ready(function($) {$(document.getElementById('StartMenu')).fadeIn(125);});
    if (osIsNix==1){
      document.getElementById("smif").style.display="block";
      document.getElementById("avif").style.display="block";
      document.getElementById("smif").style.visibility="visible";
      document.getElementById("avif").style.visibility="visible";
    }
}

function SMReset() {   
  jQuery(document).ready(function($) {
    $( ".SMsh, .SMfo" ).each(function(){
      SMLower(this);
    });  
  });
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// What to do when the Orb is clicked
function OClkd() {
  OrbWasClicked = 1;
  if (MenuIsUp == 0)
  {
    FadeInMenu();
    MenuIsUp = 1;
  }
  else
  {
    FadeOutMenu();
    MenuIsUp=0;
  }
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// What to do when the Options Menu body is clicked
function SMClkd(){
  MenuIsUp=1;
  OrbWasClicked=1;
  
  if (FlyOutSum > 0)
    {
      FlyOutSum = FlyOutSum - FlyOutOpen;
      FlyOutSum = "SMSub"+FlyOutSum;
      FlyOutSum = document.getElementById(FlyOutSum);
      SMLower(FlyOutSum);
      FlyOutSum=0;
    }
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// What to do when the user clicks anywhere on the page body
function BodyClicked() {  
  if (OrbWasClicked != 1)
    {
      FadeOutMenu();
      MenuIsUp=0;
    }
  if (FlyOutWasClicked != 1 && FlyOutOpen > 0)
    {
      SMLower(document.getElementById("SMSub5"));
      SMLower(document.getElementById("SMSub4"));
      FlyOutOpen=0;
      if (document.getElementById("flif")){
        document.getElementById("flif").style.display="none";
        document.getElementById("flif").style.visibility="hidden";
        document.getElementById("flif").style.width="1px";
        document.getElementById("flif").style.height="1px";
        document.getElementById("flif").style.left="-200px";
        document.getElementById("flif").style.bottom="0px";
      }
    }

  if (MOOpen > 0 && MOWasClicked!=1){
   molist(MOOpen);
   MOOpen=0;
  }

  OrbWasClicked=0;
  FlyOutWasClicked=0;
  MOWasClicked=0;
  lowermhov();
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Init Start Menu Throbber
function StartThrob(){
  var throbbedyet = getCookie("throb");
  
  if (opthrob==1) 
  {
    if (throbbedyet!="yes") {DoThrob();}
  }
  else if (opthrob==2){DoThrob();}
  else { /* gndn */ }    
}

function DoThrob(){
  OClkd();
  BodyClicked();
  document.cookie = "throb=yes";
  smtimer = setTimeout (BodyClicked, 6000);
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Cancel smtimer from the StartThrob if user hovered over
// the Options Menu while timer exists.
function SMHov(){  if (smtimer){clearTimeout(smtimer);}  }
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Show/Hide Secondary Submenus
function SMRaise(m) {  
  jQuery(document).ready(function($) {$(m).fadeIn(125);}); 
}

function SMLower(m){
  if (m){
    jQuery(document).ready(function($) {$(m).fadeOut(125);});
  }
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Hide/Show Flyout Menus
function SMFlot(n) {
  element = "SMSub" + n;  
  element = document.getElementById(element);
  
  jQuery(document).ready(function($) {  
  if($(element).is(":visible")){
    $(element).fadeOut(125);
    if (document.getElementById("flif")){
      document.getElementById("flif").style.display="none";
      document.getElementById("flif").style.visibility="hidden";
      document.getElementById("flif").style.width="1px";
      document.getElementById("flif").style.height="1px";
      document.getElementById("flif").style.left="-200px";
      document.getElementById("flif").style.bottom="0px";
    }
  }
  else{
    if (osIsNix==1){
      if (n==4){
        document.getElementById("flif").style.width="146px";
        document.getElementById("flif").style.height="72px";
        document.getElementById("flif").style.left="395px";
        document.getElementById("flif").style.bottom="37px";
        document.getElementById("flif").style.display="block";
        document.getElementById("flif").style.visibility="visible";
      }
     if (n==5){
        document.getElementById("flif").style.width="129px";
        document.getElementById("flif").style.height="181px";
        document.getElementById("flif").style.left="395px";
        document.getElementById("flif").style.bottom="70px";
        document.getElementById("flif").style.display="block";
        document.getElementById("flif").style.visibility="visible";
      }
    }
    $(element).fadeIn(125);
    FlyOutWasClicked = 1;
    FlyOutSum = FlyOutOpen + n;
    FlyOutOpen = n;
  }
  });     
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#


// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Show the More Options List (i.e. overflow Pages/Categories Buttons)
function molist(n) {
  element = "SMSub" + n;
  MOWasClicked = 1;
  if (MOOpen != 0){
    jQuery(document).ready(function($) {$(document.getElementById(element)).fadeOut(75, function(){document.getElementById(element).style.left = "-200px";});});
    if (osIsNix==1){
      document.getElementById("moif").style.display="none";
      document.getElementById("moif").style.visibility="hidden";
      document.getElementById("moif").style.left = "-200px";
    }
    MOOpen = 0;
  }
  else {
    jQuery(document).ready(function($) {$(document.getElementById(element)).fadeIn(75);});
    document.getElementById(element).style.left="705px";
    if (osIsNix==1){
      document.getElementById("moif").style.display="block";
      document.getElementById("moif").style.visibility="visible";
      document.getElementById("moif").style.left = "705px";
    }
    MOOpen = n;
  } 
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Resize the Sidebar to full document length, in pixels.
function sizeSidebar() {
  sh = document.getElementById("sidebar").scrollHeight;
  dh = document.getElementById("colwrap").scrollHeight;
  if (sh<dh){
    document.getElementById("sidebar").style.height=dh+"px";
  }
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Position the Sidebar, depending on document width
function positionSidebar() {
  // deal with side bar when browser window is resized
  jQuery(document).ready(function($) {
    docwidth = $(document).width();
    var sbleft = $("#sidebar").css("left"); 
    if (docwidth<=900) {
      $('#sidebar').css({right: null});
      $('#sidebar').css({left: 660});
    }
    else {
      $('#sidebar').css({left: null});
      $('#sidebar').css({right: 0});
    }
  });
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Taskbar Menu Child Popup Windows
function mhov(id,mt) {
  mt = (mt*73) + 10 + qlm;
  tid = "hov" + id;
  lhovering = 1;
  clearTimeout(timer);
  if (MenuIsUp == 0){
    if (mhovIsUp == 0){
      mhtimer = setTimeout("raisemhov('"+mt+"')", 500);
    }
    else {
      if (mhovLastUp!=tid){
        temptid = tid;
        tid = mhovLastUp;
        lowermhov();
        tid = temptid;
        raisemhov(mt);
      }
    }
  }
} 
function munhov(){
  lhovering = 0;
  if(typeof mhtimer !== "undefined"){clearTimeout(mhtimer);}
  timer = setTimeout ( "mhovkill()", 250 );
}
function mhovkill(){
  if (mhovering == 0 && lhovering == 0) {
    lowermhov();
  }
}
function raisemhov(mt){
  // if still over menu.
  if (lhovering==1){    
    document.getElementById(tid).style.left = mt + "px";
    jQuery(document).ready(function($) {$(document.getElementById(tid)).fadeIn(75);}); 
    mhovLastUp = tid;
    mhovIsUp = 1;
    if (MOOpen > 0 && MOWasClicked!=1){
      molist(MOOpen);
      MOOpen=0;
    }
    if (osIsNix==1){
      document.getElementById("hovif").style.display="block";
      document.getElementById("hovif").style.visibility="visible";
      document.getElementById("hovif").style.left = mt + "px";
    }
  }
}
function lowermhov(){   
  var atid = tid;
  if (tid){
    jQuery(document).ready(function($) {$(document.getElementById(atid)).fadeOut(75, function(){document.getElementById(atid).style.left = "-200px";});});
    if (osIsNix==1){
      document.getElementById("hovif").style.display="none";
      document.getElementById("hovif").style.visibility="hidden";
      document.getElementById("hovif").style.left = "-200px";
    }
  }
  mhovLastUp = 0;mhovIsUp = 0; 
}
function hovmhov(){mhovering = 1;}
function unhovmhov(){mhovering = 0;munhov();}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Some stuff to fix hovering issues on 'nix
function InitIFrame(){
  if (osIsNix==1){
    document.getElementById("tbif").style.display="block";
    document.getElementById("tbif").style.visibility="visible";
  }
}

function getOS() {
  // This script sets OSName variable as follows:
  // "Windows"    for all versions of Windows
  // "MacOS"      for all versions of Macintosh OS
  // "Linux"      for all versions of Linux
  // "UNIX"       for all other UNIX flavors 
  // "Unknown OS" indicates failure to detect the OS
  if (navigator.appVersion.indexOf("Win")!=-1) osIsNix=0;
  if (navigator.appVersion.indexOf("Mac")!=-1) osIsNix=0;
  if (navigator.appVersion.indexOf("X11")!=-1) osIsNix=1;
  if (navigator.appVersion.indexOf("Linux")!=-1) osIsNix=1;
}

// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Get the saved column size from the cookie, and set the column to that size
function getWinSize(){
  if (getCookie("winsize")){winsize = getCookie("winsize")}
  else {winsize = 2}
  rsanim=1; //on page load/resize, resize is instant
  setWinSize();
  rsanim=rsanimConst;  //reset to original rsanim
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Change the size of the column if the resize button is pressed, and save to cookie
function resizeColumn(){
  winsize++;
  if (winsize>2){winsize=0}
  setWinSize();
  document.cookie = "winsize="+winsize;
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Handle dynamic resize of column when column is set to middle sizing
// and the browser window is resized - also handles positioning of
// sidebar
function winResized(){  
  
  positionSidebar();
    
  // Dynamic resize of middle column size option 
  if (winsize==1){
   if (rstimer){clearTimeout(rstimer);}
   rstimer = setTimeout (getWinSize, 100);
  }
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Physically change the center column size
function setWinSize(){
  if (winsize==0){ /* Smallest Size */
    jQuery(document).ready(function($) {$("#colwrap").animate({ width: "660px"}, rsanim );});
    document.getElementById("sizer").innerHTML='<img style="padding:4px 0 0 4px;" src="'+templatedir+'/images/s_max.png" alt=" " />';   
  }  
  else if (winsize==1){ /* middle size */
    sidebarwidth = document.getElementById('sidebar').offsetWidth;  
    jQuery(document).ready(function($) {docwidth = $(document).width();});
    columnwidth = docwidth-sidebarwidth;
    newwidth = ((columnwidth-660)/2)+650;
    jQuery(document).ready(function($) {$("#colwrap").animate({ width: newwidth}, rsanim );});
    document.getElementById("sizer").innerHTML='<img style="padding:4px 0 0 4px;" src="'+templatedir+'/images/s_resize.png" alt=" " />';
  }
  else { /* Biggest size */  
    jQuery(document).ready(function($) {$("#colwrap").animate({ width: "99%"}, rsanim );});
    document.getElementById("sizer").innerHTML='<img style="padding:4px 0 0 4px;" src="'+templatedir+'/images/s_min.png" alt=" " />';
  }
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Set event handlers for all page mouse events
function InitPageEvents(){
  if(window.addEventListener){window.addEventListener('click', BodyClicked, false); } 
  else if(window.attachEvent){document.getElementById("bdy").attachEvent('onclick', BodyClicked);}
    
  jQuery(document).ready(function($) {
      $( window ).bind ("resize",function(){winResized();});      
      $( "#StartMenu" ).bind ("click",function(){SMClkd();});
      $( "#StartMenu" ).bind ("mouseover",function(){SMHov();});     
      $( "#orb" ).bind ("click",function(){OClkd();});
      
      // -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
      $( "#SMCatsB,#SMTagsB,#SMLpostsB" ).bind ("click",function(){
        element = $(this).attr('id');
        element = element.slice(0, -1)
        element=document.getElementById(element);
        SMRaise(element);
      });
      // -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
      $( "#SMCatsK,#SMTagsK,#SMLpostsK" ).bind ("click",function(){
        element = $(this).attr('id');
        element = element.slice(0, -1)
        element=document.getElementById(element);
        SMLower(element);
      });
      // -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
      $( "#SMThemeB" ).bind ("click",function(){SMFlot(5);});
      $( "#SMInfoB" ).bind ("click",function(){SMFlot(4);});
      $( "#SMSub4,#SMSub5" ).bind ("click",function(){FlyOutWasClicked=1;});
      $( "#SMSub6" ).bind ("click",function(){MOWasClicked=1;});
      $( "#voidb" ).bind ("click",function(){chooseStyle('none', 30);});
      $( "#lifeb" ).bind ("click",function(){chooseStyle('life-theme', 30);});
      $( "#earthb" ).bind ("click",function(){chooseStyle('earth-theme', 30);});
      $( "#windb" ).bind ("click",function(){chooseStyle('wind-theme', 30);});
      $( "#waterb" ).bind ("click",function(){chooseStyle('water-theme', 30);});
      $( "#fireb" ).bind ("click",function(){chooseStyle('fire-theme', 30);});
      $( "#liteb" ).bind ("click",function(){chooseStyle('lite-theme', 30);});
      $( "#mobutton" ).bind ("click",function(){molist(6);});  
    
      // Handlers for Mousing over/out of child page popups
      $( ".hovmhov" ).each(  
         function(){
           $( this ).bind ("mouseover",function(){ hovmhov(); });
           $( this ).bind ("mouseout",function(){ unhovmhov(); });
         }
       );
      
      // Set Searchboxes to "Start Search" on page load, and set handlers for focus and blur
      $( ".search" ).each(  
         function(){
           $( this ).val("Start Search");
           $( this ).bind ("focus",function(){SearchBoxFocus(this);});
           $( this ).bind ("blur",function(){SearchBoxBlur(this);});
         }
       );

      // Set handlers for hovering over page/cats buttons
      $( ".mh" ).each(  
         // "indIndex" is the loop iteration index on the current element.
         function( intIndex ){
           $( this ).bind ("mouseover",function(){
              numinloop = intIndex + 1;
              mhid = this.id;
              mhid = mhid.replace("mh", "");
              mhov(mhid,numinloop);
            });
           $(this).bind ("mouseout",function(){ munhov(); });
         }
       );

      
      // Handler for mouse events associated with the resize button
      $('.fadeThis').append('<span class="hover"></span>').each(function () {
    	  var $span = $('> span.hover', this).css('opacity', 0);
    	  $(this).hover(function () {
    	    if($.browser.msie){this.style.background = "url("+templatedir+"/images/s_rshov.png)";}
          else{$span.stop().fadeTo(120, 1); } 
    	  }, function () {
    	    if($.browser.msie){this.style.background = "url("+templatedir+"/images/s_rsb.png)";}
          else{$span.stop().fadeTo(200, 0);}   
    	  });
    	 $(this).click(function (){ $span.stop().fadeTo(1, 0);resizeColumn(); });  
       $(this).mousedown(function (){ $span.stop().fadeTo(1, 0); });  
    	});
    		
    	$('.fadeThis').append('<span class="mousedown"></span>').each(function () {
    	  var $span = $('> span.mousedown', this).css('opacity', 0);
    	  $(this).mousedown(function () {
    	    if($.browser.msie){
            this.style.background = "url("+templatedir+"/images/s_rsmdn.png)";
          }
          else{$span.stop().fadeTo(1, 1); } 
    	  }, function () {
    	    if($.browser.msie){
            this.style.background = "url("+templatedir+"/images/s_rsb.png)";
          }
          else{$span.stop().fadeTo(1, 0);}   
    	  });
    	  $(this).mouseout(function (){ $span.stop().fadeTo(1, 0); });
        $(this).click(function (){ 
          if($.browser.msie){this.style.background = "url("+templatedir+"/images/s_rsb.png)";}
          else{$span.stop().fadeTo(1, 0);} 
        }); 
    	});    	

    });  
}



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Functions to be run on page load
function InitPage() { 
  InitPageEvents();
  SMReset();
  getWinSize();
  getOS();
  InitIFrame();
  updateClock();
  setInterval('updateClock()', 5000 );
  sizeSidebar();
  positionSidebar();
  jQuery(document).ready(function($) {$(document.getElementById('StartMenu')).fadeOut(1);});
  StartThrob();
}
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Hander for OnLoad event
function AddOnload(myfunc)
  {
    if(window.addEventListener)
    window.addEventListener('load', myfunc, false);
    else if(window.attachEvent)
    window.attachEvent('onload', myfunc);
  }
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#



// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#
// Set up the script!
AddOnload(InitPage);
// *#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#*#