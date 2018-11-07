<?php
if(!file_exists(str_replace("\\",'/', dirname(__FILE__)).'/config/install.link'))
{
	if((empty($_REQUEST['act'])||!empty($_REQUEST['act'])&&$_REQUEST['act']!='public'))
	{
			header("location:install.php");
		  exit;
	}
}
if(defined('SYSTEM_ACT')&&SYSTEM_ACT=='mobile')
{
	$mod='mobile';

}else
{
	if(!empty($_REQUEST['c']))
	{
		$mod=(empty($_REQUEST['c'])||$_REQUEST['c']=='entry')?'mobile':$_REQUEST['c'];	
	}else
	{
		$mod=empty($_REQUEST['mod'])?'mobile':$_REQUEST['mod'];	
	}
}
if($mod=='mobile')
{
	defined('SYSTEM_ACT') or define('SYSTEM_ACT', 'mobile');
}else
{
	defined('SYSTEM_ACT') or define('SYSTEM_ACT', 'index');	
}
if(empty($_REQUEST['do']))
{
$_GET['do']="shopindex";
}
	if(!empty($_REQUEST['act']))
{
$_GET['act']=$_REQUEST['act'];
}else
{
$_GET['act']="shopwap";	
}
ob_start();
require 'includes/baijiacms.php';
ob_end_flush();
exit;

