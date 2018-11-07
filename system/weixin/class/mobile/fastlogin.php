<?php
	if(is_access_weixin())
		{
			$weixin_openid=get_weixin_openid();
			if(empty($_GP['bizstate'])||$_GP['bizstate']!='banding_weixin')
			{
				if(!empty($weixin_openid))
				{
					register_snsapi_userinfo($weixin_openid);
					register_from_wxfans($weixin_openid);
					$eshop_member = mysqld_select("SELECT openid FROM " . table('base_member') . " WHERE weixin_openid=:weixin_openid and beid=:beid ", array(':weixin_openid' =>$weixin_openid,":beid"=>$_CMS['beid']));
					if(!empty($eshop_member['openid']))
					{
		
						save_member_login($eshop_member['openid']);
						message("登陆成功！",gologinfromurl(),'success');
					}
				}
			}else
			{
			
			if(is_mobile())
			{
							$weixin_openid=get_weixin_openid();
									$base_member = mysqld_select("SELECT * FROM " . table('base_member') . " WHERE weixin_openid=:weixin_openid and beid=:beid ", array(':weixin_openid' =>$weixin_openid,":beid"=>$_CMS['beid']));
				if(!empty($base_member['weixin_openid']))
				{
				message("已有账户绑定此微信号，需要先那个账户先解绑，才能用于此账户绑定！",create_url('mobile',array('act' => 'shopwap','do' => 'account')),'error',true,5);	
				}
				$openid = get_sysopenid(true);
					mysqld_update("base_member",array("weixin_openid"=>$weixin_openid),array('openid' => $openid));
				  	message("微信号绑定成功！",create_url('mobile',array('act' => 'shopwap','do' => 'account')),'success');	
				}else
				{
				$showkey=base64_encode(get_sysopenid(true));
						$furl=WEBSITE_ROOT.create_url('mobile',array('act' => 'weixin','do' => 'banding_pc','op'=>'dologin','skey'=>$showkey));
								$qurl=common_qrcode($furl);
				include page('badding_weixin_pc');
				exit;
				}
			}
		}
		
					message("登陆失败！",gologinfromurl(),'error');	