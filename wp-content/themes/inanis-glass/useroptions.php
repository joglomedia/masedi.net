<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'useroptions.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
/* ************************************************************************** */
/* TASKBAR DISPLAY OPTIONS */
/* ************************************************************************** */
// $MenuOption determines whether the "Taskbar" shows Pages or Categories 
//    1 = Pages
//    2 = Categories
// Anything else defaults to Pages.
  $MenuOption = 1;

// $MenuKids determines whether the "Taskbar" shows Page/Cats Children Popups
//    0 = NO
//    1 = YES
// Anything else defaults to YES
  $MenuKids = 1;
  
// $RollOff determines, in the event you think you have too many pages to fit
// on the "TaskBar", whether or not to show a button at the right side of the
// "TaskBar" that when clicked, shows the pages that might otherwise "Roll Off"
// the "TaskBar".
// NOTE: The rolloff point is somewhat static, meaning that it cuts the menu off
// around 700 pixels to the right. This is to account for people with low
// screen resolutions.
//    0 = NO
//    1 = YES
// Anything else defaults to NO
  $RollOff = 1;

/* ************************************************************************** */
/* DEFAULT USER THEME OPTIONS */
/* ************************************************************************** */
// $DefaultTheme determines which sub-theme is first shown to a new visitor
//    1 = Void
//    2 = Life
//    3 = Earth
//    4 = Wind
//    5 = Water
//    6 = Fire
//    7 = Lightweight
// Anything else defaults to Void.
  $DefaultTheme = 1;
  
// $ManualOrRandom determines whether the user first gets your $DefaultTheme
// above, or something completely random.
//    manual = your selected theme
//    random = some random theme
// Anything else will force the theme to Void, even if you or the user 
// picked something else.
  $ManualOrRandom = "manual";
  
/* ************************************************************************** */
/* QUICKLAUNCH BAR OPTIONS */
/* ************************************************************************** */
// The QuickLaunch bar is the area of buttons between the Options Orb and the
// Page/Category buttons on the Task Bar. To see a demo, just change 
// $QuickLaunch below to 1, save/upload this file and refresh your blog page.
// $QuickLaunch determines if the QuickLaunch area is shown.
// $qla[x] and $qlt[x] array entries determine what to show in each QuickLaunch
// button. MAKE SURE YOU HAVE THE SAME NUMBER OF $qla THAT YOU HAVE OF $qlt
// AND VICE VERSA. MAKE SURE THAT YOUR LISTS OF $qla AND $qlt GO IN NUMERICAL
// ORDER. FAILURE TO OBSERVE THESE RULES WILL RESULT IN BREAKAGE.
// 0 = Don't Display QuickLaunch.
// 1 = Display QuickLaunch
// Anything else defaults to Don't Display QuickLaunch
  $QuickLaunch = 0;
  
  // URLs for QuickLaunch Buttons
  $qla[0] = 'http://www.inanis.net/';
  $qla[1] = 'http://www.wordpress.org/';
  
  // Text for QuickLaunch Buttons (should be no more than 2 characters)
  // You can also place an image of no more than 19px wide by 22px high, that is
  // if you know how. You can use the examples below for help.
  $qlt[0] = '<img src="'.get_bloginfo('template_directory').'/images/void-button.png" alt=" " title="Visit Inanis.net" />';
  $qlt[1] = '<span title="Visit WordPress.org">WP</span>';


/* ************************************************************************** */
/* DISCLAIMER OPTIONS */
/* ************************************************************************** */
// $DiscOn determines whether the Disclaimer widget shows or not
//    0 = OFF
//    1 = ON
// Anything else defaults to ON.
//
// $Disclaimer is the disclaimer text you wish to display, should you wish to 
// customize it.
// $DiscTime grabs the current year, should you wish to place a copyright date
// in your disclaimer.
  $DiscOn = 1;
  $DiscTime = get_the_time('Y'); // DO NOT EDIT THIS LINE
  $Disclaimer = "The opinions expressed herein are my own personal opinions and do not represent anyone else's view in any way, including those of my employer.<br />&copy; Copyright ".$DiscTime;
  
/* ************************************************************************** */
/* CLOCK OPTIONS */
/* ************************************************************************** */
// $TimeStyle determines whether the clock is in 12 or 24 hour mode
//    1 = 12-Hour Mode
//    2 = 24-Hour Mode
// Anything else defaults to 12-Hour Mode.
  $TimeStyle = 1;
  
/* ************************************************************************** */
/* Options Menu Throb */
/* ************************************************************************** */
// $OpThrob determines whether or not the Options Menu pops up on first visit
//    0 = No Popup
//    1 = Popup on first visit (i.e. when no cookie is set)
//    2 = Popup on every page load
// Anything else defaults to No-Popup
  $OpThrob = 1;
?>
