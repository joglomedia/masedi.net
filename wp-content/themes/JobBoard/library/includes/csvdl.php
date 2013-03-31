<?php
if($_REQUEST['page'] == 'csvdl_job')
{
	$csvfilepath = get_option( 'siteurl' ) ."/wp-content/themes/".get_option( 'template' )."/job_sample.csv";
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header("Content-Type: image/png");
	header("Content-type: application/force-download");
	header('Content-Disposition: inline; filename="job_sample.csv"');
	header('Content-Transfer-Encoding: binary');
	readfile($csvfilepath);
	exit;
}
elseif($_REQUEST['page'] == 'csvdl_resume')
{
	$csvfilepath = get_option( 'siteurl' ) ."/wp-content/themes/".get_option( 'template' )."/resume_sample.csv";	
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header("Content-Type: image/png");
	header("Content-type: application/force-download");
	header('Content-Disposition: inline; filename="resume_sample.csv"');
	header('Content-Transfer-Encoding: binary');
	readfile($csvfilepath);
	exit;

}
else
{
	$csvfilepath = get_option( 'siteurl' ) ."/wp-content/themes/".get_option( 'template' )."/post_sample.csv";
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header("Content-Type: image/png");
	header("Content-type: application/force-download");
	header('Content-Disposition: inline; filename="post_sample.csv"');
	header('Content-Transfer-Encoding: binary');
	readfile($csvfilepath);
	exit;
}


?>