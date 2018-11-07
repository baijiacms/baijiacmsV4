<?php
defined('SYSTEM_IN') or exit('Access Denied');
abstract class BjSystemModule {
		public function __mobile($f_name){
			global $_CMS,$_GP,$_W,$_GPC;
			
				if(empty($_CMS['beid']))
			{
			message("未找到站点ID");	
			}

			$filephp=$_CMS['module'].'/class/mobile/'.strtolower(substr($f_name,3)).'.php';
	
			include_once  SYSTEM_ROOT.$filephp;
	}
	public function __mobile2($f_name){
			global $_CMS,$_GP,$_W,$_GPC;
			$filephp=$_CMS['module'].'/class/mobile/'.strtolower(substr($f_name,3)).'.php';
			include_once  SYSTEM_ROOT.$filephp;
	}
}

if(is_login_account()&&!empty($_CMS['beid'])&&($_GP['m']=='eshop'||$_GP['act']=='shopwap'))
{
		$tg_openid=get_sysopenid(false);
		$tg_member = pdo_fetch('select openid,isagent,status,isblack from ' . tablename('eshop_member') . ' where  openid=:openid and uniacid=:uniacid limit 1', array(
                ':uniacid' =>$_CMS['beid'],
                ':openid' => $tg_openid));
                
			if(!empty($tg_member['isblack']))
			{
			message("该账户已被管理员加入黑名单禁止访问。");	
			}
			if(empty($tg_member['isagent']))
			{
				
			}
			
		if(!empty($tg_member['isagent'])&&!empty($tg_member['status']))
		{
			$_CMS['shopwap_member_isagent']=true;
			if(empty($_GP['shareid']))
			{
				if(!empty($_SERVER['QUERY_STRING']))
				{
						 $url  = WEBSITE_ROOT . 'index.php?' . $_SERVER['QUERY_STRING'].'&shareid='.$tg_member['openid'] ;
						}else
						{
								 $url  = WEBSITE_ROOT . 'index.php?shareid='.$tg_member['openid'] ;
					
						}
					header("Location:".$url);
					exit;
				}
		}
			
}
if(is_login_account()==false){
if(empty($_SESSION[MOBILE_USER_SHAREID])&&!empty($_GP['shareid']))
			{
				$_SESSION[MOBILE_USER_SHAREID]=$_GP['shareid'];
			}
}