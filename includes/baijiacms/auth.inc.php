<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.baijiacms.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 百家cms <QQ:1987884799> <http://www.baijiacms.com>
// +----------------------------------------------------------------------
defined('SYSTEM_IN') or exit('Access Denied');
function check_managerlogin()
		{
			global $_CMS;
				if (empty($_SESSION[WEB_SESSION_ACCOUNT])||empty($_SESSION[WEB_SESSION_ACCOUNT]['is_admin'])) {
				message('会话已过期，请先登录！',create_url('mobile',array('act' => 'public','do' => 'logout')), 'error');
			}
			return true;
			
		}
function check_login()
		{
			global $_CMS;
							if (empty($_SESSION[WEB_SESSION_ACCOUNT])) {
				message('会话已过期，请先登录！',create_url('mobile',array('act' => 'public','do' => 'logout')), 'error');
			}
		
		
				if (!empty($_SESSION[WEB_SESSION_ACCOUNT])) {
					if(!empty($_SESSION[WEB_SESSION_ACCOUNT]['is_admin']))
					{
						 $system_user = mysqld_select('SELECT id FROM '.table('user')." WHERE  id=:id" , array(':id'=> $_SESSION[WEB_SESSION_ACCOUNT]['id']));
	 $store = mysqld_select("SELECT id FROM " . table('system_store')." where `deleted`=0 and `id`=:id ",array(":id"=>$_CMS['beid']));
     if(empty($system_user['id'])||empty($store['id']))
     {
				message('会话已过期，请先登录！',create_url('mobile',array('act' => 'public','do' => 'logout')), 'error');
			}
		}else
		{
					 $system_user = mysqld_select('SELECT id,beid FROM '.table('user')." WHERE  id=:id" , array(':id'=> $_SESSION[WEB_SESSION_ACCOUNT]['id']));
	 $store = mysqld_select("SELECT id FROM " . table('system_store')." where `deleted`=0 and `id`=:id ",array(":id"=>$_CMS['beid']));
     if($system_user['beid']!=$_CMS['beid']||empty($system_user['id'])||empty($store['id']))
     {
				message('会话已过期，请先登录！',create_url('mobile',array('act' => 'public','do' => 'logout')), 'error');
			}
			
		}
		}
		
		
			
			return true;
			
		}