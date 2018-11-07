<?php
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'dologin';

if($operation=='dologin')
{
if(strpos($_SERVER['HTTP_USER_AGENT'], 'DingTalk')==false)
{
message("请使用钉钉扫描登录");	
}
$dingtalk_settings=globalSetting('dingtalk');
$usedingtalk=$dingtalk_settings['fastlogin_open'];
if(empty($usedingtalk))
{
message("未开启钉钉快捷登陆");	
}
	if($usedingtalk&&!empty($_GP['skey']))
	{
		require_once(WEB_ROOT."/system/dingtalk/dingtalk_common.php");
		if(!empty($_GP['code']))
{
$persistent=dingtalk_getuserinfo($_GP['code']);	
$dingtalk_openid=$persistent['userid'];
if(!empty($dingtalk_openid))
{
$base_member = mysqld_select("SELECT openid FROM " . table('base_member') . " WHERE dingtalk_openid=:dingtalk_openid and beid=:beid ", array(':dingtalk_openid' =>$dingtalk_openid,":beid"=>$_CMS['beid']));
				if(!empty($base_member['openid']))
				{
					$evalue=iserializer($base_member['openid']);
					$evalue=base64_encode($evalue);
					$ekey='dingtalklogin_'.base64_decode($_GP['skey']);
					mysqld_delete('key_exchange',array('ekey'=>$ekey,'beid'=>$_CMS['beid']));
					mysqld_insert('key_exchange',array('createtime'=>TIMESTAMP,'evalue'=>$evalue,'ekey'=>$ekey,'beid'=>$_CMS['beid']));
					save_member_login($base_member['openid']);
					message("登陆成功！",create_url('mobile',array('act' => 'shopwap','do' => 'membercenter')),'success');
				}
			}
				message("登陆失败！请刷新二维码界面后重新扫描二维码！");
}else
{
		
		$dingtalk_config=dingtalk_config();
	$set_shop=globalSetting('shop');
						include page('fastlogin_pc_pre');
						exit;	
}
			
		
		}
		
					message("登陆失败！请刷新二维码界面后重新扫描二维码！");
}
if($operation=='dologincheck')
{
		if(is_mobile()==false&&$usedingtalk&&!empty($_GP['skey']))
		{
			$ekey='dingtalk_'.base64_decode($_GP['skey']);
			$key_exchange = mysqld_select("SELECT * FROM ".table('key_exchange')." where ekey=:ekey and beid=:beid  ", array(':ekey' => $ekey,':beid'=>$_CMS['beid']));
				if(!empty($key_exchange['evalue']))
			{
			$evalue= $key_exchange['evalue'];
			$evalue=base64_decode($evalue);
			$openid=iunserializer($evalue);
				$base_member = mysqld_select("SELECT openid FROM " . table('base_member') . " WHERE openid=:openid and beid=:beid ", array(':openid' =>$openid,":beid"=>$_CMS['beid']));
				if(!empty($base_member['openid']))
				{
					show_json(1);
					exit;
				}else
				{
				mysqld_delete('key_exchange',array('ekey'=>$ekey,'beid'=>$_CMS['beid']));
				show_json(-1);
				exit;
				}
			}
				
		}
show_json(0);
}

if($operation=='tologin')
{
		if(is_mobile()==false&&$usedingtalk&&!empty($_GP['skey']))
		{
			$ekey='dingtalk_'.get_sysopenid(false);
			$key_exchange = mysqld_select("SELECT * FROM ".table('key_exchange')." where ekey=:ekey and beid=:beid  ", array(':ekey' => $ekey,':beid'=>$_CMS['beid']));
				if(!empty($key_exchange['evalue']))
			{
				$openid= keyexchange_get_key($ekey);
				$base_member = mysqld_select("SELECT openid FROM " . table('base_member') . " WHERE openid=:openid and beid=:beid ", array(':openid' =>$openid,":beid"=>$_CMS['beid']));
				if(!empty($base_member['openid']))
				{
					save_member_login($base_member['openid']);
				message("登陆成功！",gologinfromurl(),'success');
				}
			}
			mysqld_delete('key_exchange',array('ekey'=>$ekey,'beid'=>$_CMS['beid']));	
		}
					message("登陆失败！请刷新二维码界面后重新扫描二维码！");	
}