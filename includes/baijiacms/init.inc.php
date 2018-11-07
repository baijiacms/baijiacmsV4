<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.baijiacms.com All rights reserved.
// +----------------------------------------------------------------------
// | Comments: mysql数据库操作
// +----------------------------------------------------------------------
// | Author: 百家cms <QQ:1987884799> <http://www.baijiacms.com>
// +----------------------------------------------------------------------
defined('SYSTEM_IN') or exit('Access Denied');
$BJCMS_ISINSTALL=false;
if(is_file(WEB_ROOT."/config/install.link"))
{
$BJCMS_ISINSTALL=true;
}
if($BJCMS_ISINSTALL==true)
{
	$_CMS['beid']=getDomainBeid();
}
if($BJCMS_ISINSTALL==true)
{

	$_CMS['system_globa_setting']=globaPriveteSystemSetting();

	if(!empty($_CMS['system_globa_setting'])&&!empty($_CMS['system_globa_setting']['system_isnetattach']))
	{
		if($_CMS['system_globa_setting']['system_isnetattach']==1)
		{
			define('ATTACHMENT_WEBROOT', $_CMS['system_globa_setting']['system_ftp_attachurl']);
		}
		if($_CMS['system_globa_setting']['system_isnetattach']==2)
		{
			define('ATTACHMENT_WEBROOT', $_CMS['system_globa_setting']['system_oss_attachurl']);
		}	
	}else
	{
			if(!empty($_CMS['system_globa_setting']['system_base_attachurl']))
		{
			
	define('ATTACHMENT_WEBROOT', $_CMS['system_globa_setting']['system_base_attachurl'].'attachment/');
	}else
	{
		
	define('ATTACHMENT_WEBROOT', WEBSITE_ROOT.'attachment/');
	}
		
	}

}


