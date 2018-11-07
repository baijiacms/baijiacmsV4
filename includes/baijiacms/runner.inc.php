<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.baijiacms.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 百家cms <QQ:1987884799> <http://www.baijiacms.com>
// +----------------------------------------------------------------------
defined('SYSTEM_IN') or exit('Access Denied');
if(!empty($_CMS['beid'])&&SYSTEM_ACT=='mobile'&&($modulename=="shopwap"||$_CMS['isaddons']==true||$_GP['m']=='eshop'))
{
		$t_set_shop=globalSetting('shop');
		if(!empty($t_set_shop['close'])&&!empty($t_set_shop['closedetail']))
		{
			
			if(!empty($t_set_shop['closeurl']))
			{
						message($t_set_shop['closedetail'],$t_set_shop['closeurl'],'error');
			}else
			{
					message($t_set_shop['closedetail']);	
			}
	
		}
}
$classname = $modulename."Addons";
if($_CMS['isaddons']==true)
	{
			require(WEB_ROOT.'/system/common/addons.php');
			if(SYSTEM_ACT=='mobile')
			{
				require(WEB_ROOT.'/system/common/mobile.php');
				$file = ADDONS_ROOT . $modulename."/mobile.php";
			}else
			{
					$file = ADDONS_ROOT . $modulename."/web.php";
			}
	}else
	{
			if(SYSTEM_ACT=='mobile')
			{
				require(WEB_ROOT.'/system/common/mobile.php');
				$file = SYSTEM_ROOT . $modulename."/mobile.php";
			}else
			{
				require(WEB_ROOT.'/system/common/web.php');
					$file = SYSTEM_ROOT . $modulename."/web.php";
			}
	}

if(!is_file($file)) {
				exit('ModuleSite Definition File Not Found '.$file);
}
if(!empty($_GP['m']))
{
	require(WEB_ROOT.'/system/common/common.php');
}
require $file;
if(!class_exists($classname)) {
			exit('ModuleSite Definition Class Not Found');
}

$class = new $classname();
$class->module = $modulename;
$class->inMobile = SYSTEM_ACT=='mobile';

if($_GP['m']!='eshop')
{
if($_CMS['isaddons']==true)
	{
		
					if($class instanceof BjModule) {
				if(!empty($class)) {
					if(isset($_GP['do'])) {
						if(SYSTEM_ACT=='mobile')
						{
								$class->inMobile = true;
					
						}else
						{
								$_W['isfounder']=true;
								if($modulename=='manager')
								{
									check_managerlogin();
								}else
								{
									check_login();
								}
								$class->inMobile = false;
						}
								$method = 'do_'.$_GP['do'];
					}
					$class->module = $modulename;
					if (method_exists($class, $method)) {
									exit($class->$method());
					}else
					{
									exit($method." no this method");
					}
							
					}
			}
					
						exit('BjSystemModule Class Definition Error');
		
	}else
	{
			if($class instanceof BjSystemModule) {
				if(!empty($class)) {
					if(isset($_GP['do'])) {
						if(SYSTEM_ACT=='mobile')
						{
								$class->inMobile = true;
						}else
						{
							
								$_W['isfounder']=true;
								if($modulename=='manager')
								{
									check_managerlogin();
								}else
								{
									check_login();
								}
								$class->inMobile = false;
						}
								$method = 'do_'.$_GP['do'];
					}
					$class->module = $modulename;
					if (method_exists($class, $method)) {
									exit($class->$method());
					}else
					{
									exit($method." no this method");
					}
							
					}
			}
					
}

}else
{


			
if($class instanceof BJexModule) {

$class->uniacid = $class->weid = $_W['uniacid'];
$class->modulename = $_W['module'];
$class->__define = $file;
$class->inMobile = defined('IN_MOBILE');
	
	if(SYSTEM_ACT=='mobile')
{
	define('IN_MOBILE', true);
		$method = 'doMobile' . ucfirst($_GPC['do']);
if (method_exists($class, $method)) {

	exit($class->$method());
}
exit();


}else
{
define('IN_SYS', true);
define('IN_MODULE', $_W['module']);
define('IN_IA', true);
$_W['isfounder']=true;
$method = 'doWeb' . ucfirst($_GPC['do']);
if (method_exists($class, $method)) {
	check_login();
	exit($class->$method());
}


  
exit("访问的方法 {$method} 不存在.");
}
	
						
			} 
					
					
						exit('BjSystemModule Class Definition Error');
}