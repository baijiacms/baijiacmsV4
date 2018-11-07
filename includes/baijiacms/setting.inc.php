<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.baijiacms.com All rights reserved.
// +----------------------------------------------------------------------
// | Comments: mysql数据库操作
// +----------------------------------------------------------------------
// | Author: 百家cms <QQ:1987884799> <http://www.baijiacms.com>
// +----------------------------------------------------------------------
defined('SYSTEM_IN') or exit('Access Denied');
function globaPriveteSystemSetting()
{
	
		$config=array();
		$system_config_cache = mysqld_select('SELECT * FROM '.table('system_config')." where `name`='system_config_cache'");
		if(empty($system_config_cache['value']))
		{
		$configdata = mysqld_selectall('SELECT * FROM '.table('system_config'));
		foreach ($configdata as $item) {
			$config[$item['name']]=$item['value'];
		}
			if(!empty($system_config_cache['name']))
			{
				mysqld_update('system_config', array('value'=>serialize($config)), array('name'=>'system_config_cache'));
			}else
			{
	      mysqld_insert('system_config', array('name'=>'system_config_cache','value'=>serialize($config)));
	    }
			return $config;
		}else
		{
			return unserialize($system_config_cache['value']);
		}
}


function refreshSystemSetting($arrays)
{
		global $_CMS;
	if(is_array($arrays)) {
		   foreach ($arrays as $cid => $cate) {
		   	$config_data = mysqld_selectcolumn('SELECT `name` FROM '.table('system_config')." where `name`=:name",array(":name"=>$cid));
					if(empty($config_data))
					{
 					  mysqld_delete('system_config', array('name'=>$cid));
          	$data=array('name'=>$cid,'value'=>$cate);
          	 mysqld_insert('system_config', $data);
          }else
          {
 						 mysqld_update('system_config', array('value'=>$cate), array('name'=>$cid));
          }
       }
 			 mysqld_update('system_config', array('value'=>''), array('name'=>'system_config_cache'));
 			 $_CMS['system_globa_setting']=globaPriveteSystemSetting();
	}
}
function globaSystemSetting()
{
	global $_CMS;
	return $_CMS['system_globa_setting'];
}


function refreshSetting($arrays,$groupkey)
{
	global $_CMS;
	refreshBeSetting($_CMS['beid'],$arrays,$groupkey);
	$_CMS[$_CMS['beid'].'_'.$groupkey.'_setting']=globalBeSetting($_CMS['beid'],$groupkey);
}

function globalBeSetting($beid,$groupkey)
{
	
	global $_CMS;
	
		if(empty($beid))
		{
		message('未找到站点id');	
		}
			if(empty($groupkey))
	{
	message("读取配置失败");
	}
	if(!empty($_CMS[$_CMS['beid'].'_'.$groupkey.'_setting']))
	{
		return $_CMS[$_CMS['beid'].'_'.$groupkey.'_setting'];	
	}
			$config=array();
			$system_config_cache = mysqld_select('SELECT * FROM '.table('config')." where `name`='system_config_cache' and `beid`=:beid and `group`=:group",array(":beid"=>$beid,':group'=>$groupkey));
			if(empty($system_config_cache['value']))
			{
			$configdata = mysqld_selectall('SELECT * FROM '.table('config')." where `beid`=:beid and `group`=:group",array(":beid"=>$beid,':group'=>$groupkey));
			foreach ($configdata as $item) {
				$config[$item['name']]=$item['value'];
			}
				if(!empty($system_config_cache['name']))
				{
					mysqld_update('config', array('value'=>serialize($config)), array('name'=>'system_config_cache','beid'=>$beid,'group'=>$groupkey));
				}else
				{
		      mysqld_insert('config', array('name'=>'system_config_cache','value'=>serialize($config),'beid'=>$beid,'group'=>$groupkey));
		    }
		    $_CMS[$_CMS['beid'].'_'.$groupkey.'_setting']=$config;
				return $config;
			}else
			{
				$_CMS[$_CMS['beid'].'_'.$groupkey.'_setting']=unserialize($system_config_cache['value']);
				return unserialize($system_config_cache['value']);
			}	
}


function refreshBeSetting($beid,$arrays,$groupkey)
{
	global $_CMS;
	if(empty($beid))
	{
	message('未找到站点id');	
	}
	if(empty($groupkey))
	{
	message("保存配置失败");
	}
	if(is_array($arrays)) {
		   foreach ($arrays as $cid => $cate) {
		   	$config_data = mysqld_selectcolumn('SELECT `name` FROM '.table('config')." where `name`=:name and `beid`=:beid and `group`=:group",array(":name"=>$cid,":beid"=>$beid,':group'=>$groupkey));
					if(empty($config_data))
					{
 					  mysqld_delete('config', array('name'=>$cid,'beid'=>$beid,'group'=>$groupkey));
          	$data=array('name'=>$cid,'value'=>$cate,'beid'=>$beid,'group'=>$groupkey);
          	 mysqld_insert('config', $data);
          }else
          {
 						 mysqld_update('config', array('value'=>$cate), array('name'=>$cid,'beid'=>$beid,'group'=>$groupkey));
          }
       }
       unset($_CMS[$_CMS['beid'].'_'.$groupkey.'_setting']);
 			 mysqld_update('config', array('value'=>''), array('name'=>'system_config_cache','beid'=>$beid,'group'=>$groupkey));
 			 
	}
}


function globalSetting($groupkey)
{
	global $_CMS;
	return globalBeSetting($_CMS['beid'],$groupkey);
}

