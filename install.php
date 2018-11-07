<?php
if(file_exists(str_replace("\\",'/', dirname(__FILE__)).'/config/install.link'))
{
			header("location:index.php");
			
	  exit;
}
		define('LOCK_TO_INSTALL', true);	
$mod='mobile';
defined('SYSTEM_ACT') or define('SYSTEM_ACT', 'mobile');
$_GET['act']="public";
$_GET['do']="install";
ob_start();
$CLASS_LOADER="driver";
require 'includes/baijiacms.php';
ob_end_flush();
exit;

