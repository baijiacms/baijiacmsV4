<?php
if((empty($_REQUEST['act'])||!empty($_REQUEST['act'])&&$_REQUEST['act']!='modules')&&!file_exists(str_replace("\\",'/', dirname(__FILE__)).'/config/install.link'))
{
			header("location:install.php");
			
	  exit;
}
$mod='mobile';
$_GET['act']="public";
defined('SYSTEM_ACT') or define('SYSTEM_ACT', 'mobile');
if(empty($_REQUEST['do']))
{
	$_GET['do']='index';
}

ob_start();
$CLASS_LOADER="driver";
require 'includes/baijiacms.php';
ob_end_flush();
exit;

