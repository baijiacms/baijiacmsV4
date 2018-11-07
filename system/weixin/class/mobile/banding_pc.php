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
			
				$weixin_member = mysqld_select("SELECT * FROM " . table('base_member') . " WHERE weixin_openid=:weixin_openid and beid=:beid ", array(':weixin_openid' =>$weixin_openid,":beid"=>$_CMS['beid']));
			
				if(empty($weixin_member['openid']))
				{
					
					if (checksubmit("submit")) {
					$evalue=iserializer($weixin_openid);
					$evalue=base64_encode($evalue);
					$ekey='wxbanding_'.base64_decode($_GP['skey']);
					mysqld_delete('key_exchange',array('ekey'=>$ekey,'beid'=>$_CMS['beid']));
					mysqld_insert('key_exchange',array('createtime'=>TIMESTAMP,'evalue'=>$evalue,'ekey'=>$ekey,'beid'=>$_CMS['beid']));
					message("绑定成功！",create_url('mobile',array('act' => 'shopwap','do' => 'membercenter')),'success');
					}else
					{
						$set_shop=globalSetting('shop');
						include page('weixin_pc_pre');
						exit;
					}
				}else
				{
				message("已有账户绑定此微信号，需要先那个账户先解绑，才能用于此账户绑定！",create_url('mobile',array('act' => 'shopwap','do' => 'account')),'error',true,5);	
				
				}
			}
		}
		
					message("登陆失败！请刷新二维码界面后重新扫描二维码！");
}
if($operation=='dologincheck')
{
		if(is_mobile()==false&&is_access_weixin()&&!empty($_GP['skey']))
		{
			$ekey='wxbanding_'.base64_decode($_GP['skey']);
			$key_exchange = mysqld_select("SELECT * FROM ".table('key_exchange')." where ekey=:ekey and beid=:beid  ", array(':ekey' => $ekey,':beid'=>$_CMS['beid']));
				if(!empty($key_exchange['evalue']))
			{
			$evalue= $key_exchange['evalue'];
			$evalue=base64_decode($evalue);
			$weixin_openid=iunserializer($evalue);
					$openid = get_sysopenid(true);
			mysqld_update('base_member',array('weixin_openid'=>$weixin_openid),array('openid'=>$openid,'beid'=>$_CMS['beid']));
					
				$eshop_member = mysqld_select("SELECT weixin_openid FROM " . table('base_member') . " WHERE openid=:openid and beid=:beid ", array(':openid' =>$openid,":beid"=>$_CMS['beid']));
				if(!empty($eshop_member['weixin_openid']))
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