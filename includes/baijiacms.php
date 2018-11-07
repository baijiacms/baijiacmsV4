<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.baijiacms.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 百家cms <QQ:1987884799> <http://www.baijiacms.com>
// +----------------------------------------------------------------------
(defined('SYSTEM_ACT') or defined('LOCK_TO_INSTALL')) or exit('Access Denied');
define('WEB_ROOT', str_replace("\\",'/', dirname(dirname(__FILE__))));
if(is_file(WEB_ROOT.'/config/version.php'))
{
	require WEB_ROOT.'/config/version.php';
}
if(is_file(WEB_ROOT.'/config/debug.php'))
{
	require WEB_ROOT.'/config/debug.php';
}
define('SAPP_NAME', 'baijiacms');
define('SAPP_VERSION', '4.1.4');
define('CORE_VERSION', 20170105);
header('Content-type: text/html; charset=UTF-8');
define('SYSTEM_WEBROOT', WEB_ROOT);
define('TIMESTAMP', time());
define('SYSTEM_IN', true);
defined('DATA_PROTECT') or define('DATA_PROTECT', false);
defined('CUSTOM_VERSION') or define('CUSTOM_VERSION', false);
date_default_timezone_set('PRC');
$document_root = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
$document_root =str_replace("//","/",$document_root);
if(empty($document_root)||substr($document_root, -1)!='/')
{
		$document_root=$document_root. '/';
}
define('WEBSITE_FOOTER', $document_root);	
define('SESSION_PREFIX', $_SERVER['HTTP_HOST']);	
define('WEB_WEBSITE', $_SERVER['HTTP_HOST']);	
define('WEBSITE_ROOT', 'http://'.$_SERVER['HTTP_HOST'].$document_root);
define('LOCAL_ATTACHMENT_WEBROOT', WEBSITE_ROOT.'attachment/');
define('RESOURCE_ROOT', WEBSITE_ROOT.'assets/');

define('SYSTEM_ROOT', WEB_ROOT.'/system/');	
define('CUSTOM_ROOT', WEB_ROOT.'/custom/');	
define('ADDONS_ROOT', WEB_ROOT.'/addons/');
defined('DEVELOPMENT') or define('DEVELOPMENT',0);
defined('SQL_DEBUG') or define('SQL_DEBUG', 0);
define('REGULAR_EMAIL', '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/i');
define('REGULAR_MOBILE', '/1\d{10}/');
define('REGULAR_USERNAME', '/^[\x{4e00}-\x{9fa5}a-z\d_\.]{3,15}$/iu');
define('WEIXIN_ROOT', 'https://mp.weixin.qq.com');
define('MAGIC_QUOTES_GPC', (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) || @ini_get('magic_quotes_sybase'));
define('MOBILE_SESSION_ACCOUNT', SESSION_PREFIX."mobile_sessionAccount");
define('MOBILE_ACCOUNT', SESSION_PREFIX."mobile_account");
define('MOBILE_WEIXIN_OPENID', SESSION_PREFIX."mobile_weixin_openid");
define('WEB_SESSION_ACCOUNT', SESSION_PREFIX."web_account");

if(!session_id())
{
session_start();
header("Cache-control:private");
}
if(DEVELOPMENT) {
	ini_set('display_errors','1');
error_reporting(E_ALL ^ E_NOTICE);
	//error_reporting(E_ERROR  | E_PARSE);
} else {
	error_reporting(0);
}
ob_start();
if(MAGIC_QUOTES_GPC) {
	  function stripslashes_deep($value){ 
         $value=is_array($value)?array_map('stripslashes_deep',$value):stripslashes($value); 
         return $value; 
     } 
     $_POST=array_map('stripslashes_deep',$_POST); 
     $_GET=array_map('stripslashes_deep',$_GET); 
     $_COOKIE=array_map('stripslashes_deep',$_COOKIE); 
     $_REQUEST=array_map('stripslashes_deep',$_REQUEST); 
}
$_GP = $_CMS =  array();
$_GP = array_merge($_GET, $_POST, $_GP);
function irequestsplite($var) {
	if (is_array($var)) {
		foreach ($var as $key => $value) {
			$var[htmlspecialchars($key)] = irequestsplite($value);
		}
	} else {
		$var = str_replace('&amp;', '&', htmlspecialchars($var, ENT_QUOTES));
	}
	return $var;
}
$_GP = irequestsplite($_GP);
if(empty($_GP['m']))
{
$modulename = $_GP['act'];
}else
{
	$modulename = $_GP['m'];
}


if(empty($_GP['do'])||empty($modulename))
{
	exit("do or act is null");
}



$pdo = $_CMS['pdo'] = null;


$_CMS['module']=$modulename;
$_CMS['beid']=$_GP['beid'];



if(!empty($_GP['isaddons']))
{
		$_CMS['isaddons']=true;
}


$bjconfigfile = WEB_ROOT."/config/config.php";
if(is_file($bjconfigfile))
{
require WEB_ROOT.'/includes/baijiacms/mysql.inc.php';
}
require WEB_ROOT.'/includes/baijiacms/common.inc.php';
require WEB_ROOT.'/includes/baijiacms/setting.inc.php';
require WEB_ROOT.'/includes/baijiacms/init.inc.php';
$_CMS[WEB_SESSION_ACCOUNT]=$_SESSION[WEB_SESSION_ACCOUNT];
require WEB_ROOT.'/includes/baijiacms/extends.inc.php';
require WEB_ROOT.'/includes/baijiacms/user.inc.php';
require WEB_ROOT.'/includes/baijiacms/auth.inc.php';
require WEB_ROOT.'/includes/baijiacms/weixin.inc.php';
require WEB_ROOT.'/includes/baijiacms/runner.inc.php';