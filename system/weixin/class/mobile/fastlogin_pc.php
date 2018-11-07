<?php
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'dologin';
if($operation=='dologin')
{
if(is_weixin()==false)
{
message("请使用微信扫描登录");	
}
						
	if(is_access_weixin()&&!empty($_GP['skey']))
	{
			$weixin_openid=get_weixin_openid();		
			if(!empty($weixin_openid))
			{
						register_snsapi_userinfo($weixin_openid);
					register_from_wxfans($weixin_openid);
				$eshop_member = mysqld_select("SELECT openid FROM " . table('base_member') . " WHERE weixin_openid=:weixin_openid and beid=:beid ", array(':weixin_openid' =>$weixin_openid,":beid"=>$_CMS['beid']));
				if(!empty($eshop_member['openid']))
				{
					if (checksubmit("submit")) {
					$evalue=iserializer($eshop_member['openid']);
					$evalue=base64_encode($evalue);
					$ekey='wxlogin_'.base64_decode($_GP['skey']);
					mysqld_delete('key_exchange',array('ekey'=>$ekey,'beid'=>$_CMS['beid']));
					mysqld_insert('key_exchange',array('createtime'=>TIMESTAMP,'evalue'=>$evalue,'ekey'=>$ekey,'beid'=>$_CMS['beid']));
					save_member_login($eshop_member['openid']);
					message("登陆成功！",create_url('mobile',array('act' => 'shopwap','do' => 'membercenter')),'success');
					}else
					{
						$set_shop=globalSetting('shop');
						include page('fastlogin_pc_pre');
						exit;
					}
				}else
				{
					
				}
			}
		}
		
					message("登陆失败！请刷新二维码界面后重新扫描二维码！");
}
if($operation=='dologincheck')
{
		if(is_mobile()==false&&is_access_weixin()&&!empty($_GP['skey']))
		{
			$ekey='wxlogin_'.base64_decode($_GP['skey']);
			$key_exchange = mysqld_select("SELECT * FROM ".table('key_exchange')." where ekey=:ekey and beid=:beid  ", array(':ekey' => $ekey,':beid'=>$_CMS['beid']));
				if(!empty($key_exchange['evalue']))
			{
			$evalue= $key_exchange['evalue'];
			$evalue=base64_decode($evalue);
			$openid=iunserializer($evalue);
				$eshop_member = mysqld_select("SELECT openid FROM " . table('base_member') . " WHERE openid=:openid and beid=:beid ", array(':openid' =>$openid,":beid"=>$_CMS['beid']));
				if(!empty($eshop_member['openid']))
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
		if(is_mobile()==false&&is_access_weixin()&&!empty($_GP['skey']))
		{
			$ekey='wxlogin_'.get_sysopenid(false);
			$key_exchange = mysqld_select("SELECT * FROM ".table('key_exchange')." where ekey=:ekey and beid=:beid  ", array(':ekey' => $ekey,':beid'=>$_CMS['beid']));
				if(!empty($key_exchange['evalue']))
			{
				$openid= keyexchange_get_key($ekey);
				$eshop_member = mysqld_select("SELECT openid FROM " . table('base_member') . " WHERE openid=:openid and beid=:beid ", array(':openid' =>$openid,":beid"=>$_CMS['beid']));
				if(!empty($eshop_member['openid']))
				{
					save_member_login($eshop_member['openid']);
				message("登陆成功！",gologinfromurl(),'success');
				}
			}
			mysqld_delete('key_exchange',array('ekey'=>$ekey,'beid'=>$_CMS['beid']));	
		}
					message("登陆失败！请刷新二维码界面后重新扫描二维码！");	
}