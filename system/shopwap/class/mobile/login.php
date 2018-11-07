<?php	
if (!defined("IN_IA")) {
    exit("Access Denied");
}
if(is_login_account())
{
header("location:".create_url('mobile',array('act' => 'center','do' => 'member','m'=>'eshop')));	
		exit;	
}
//(strpos($_SERVER['HTTP_USER_AGENT'], 'DingTalk')!== false)
				if (checksubmit("submit")) {
						
					
								$mobile=$_GP['mobile'];
	
				$pwd=$_GP['password'];
				$verify=$_GP['verify'];
						if(empty($verify))
					{
					message("请输入验证码！");	
					}
					$verify =strtolower($verify);
							if(md5($verify)!=$_SESSION["mobile_login_verification"])
					{
					message("验证码错误！",'refresh','error');	
					}
					if(empty($mobile))
					{
					message("请输入手机号");	
					}
					if(empty($pwd))
					{
					message("请输入密码");	
					}
		
					
						$oldsessionid=get_sysopenid(false);
					$loginid=member_login($mobile,$pwd);
					if($loginid==-1)
					{
							message("账户已被禁用！");	
					}
					if(empty($loginid))
					{
					message("用户名或密码错误");	
					}else
					{
						header("location:".gologinfromurl());		
					}
		}
 
			$qq_settings=globalSetting('qq');
			$dingtalk_settings=globalSetting('dingtalk');
			//is_use_weixin
				if(is_access_weixin()&&((strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!== false&&empty($_GP['op']))||$_GP['op']=='weixin'))
				{
					if(is_use_weixin())
					{
					    include page('login_weixin');	
					    exit;
					}else
					{
						if(is_mobile()==false)
						{
							$showkey=base64_encode(get_sysopenid(false));
							$furl=WEBSITE_ROOT.create_url('mobile',array('act' => 'weixin','do' => 'fastlogin_pc','op'=>'dologin','skey'=>$showkey));
								$qurl=common_qrcode($furl);
					    include page('login_weixin_pc');	
					    exit;
					  }
					}
				}
						if(!empty($qq_settings['fastlogin_open'])&&((strpos($_SERVER['HTTP_USER_AGENT'], 'QQ')!=false&&empty($_GP['op']))||$_GP['op']=='qq'))
				{
					if(strpos($_SERVER['HTTP_USER_AGENT'], 'QQ')!= false)
					{
					header("Location:".create_url('mobile',array('act' => 'qq','do' => 'fastlogin')));
					 exit;
					}else
					{
					   include page('login_qq');	
					    exit;
					 }
				}
				
				if(!empty($dingtalk_settings['fastlogin_open'])&&((is_mobile()==false||(strpos($_SERVER['HTTP_USER_AGENT'], 'DingTalk')!=false&&empty($_GP['op'])))&&$_GP['op']=='dingtalk'))
				{
					if(strpos($_SERVER['HTTP_USER_AGENT'], 'DingTalk')!= false)
					{
						require_once(WEB_ROOT."/system/dingtalk/dingtalk_common.php");
						$dingtalk_config=dingtalk_config();
					   include page('login_dingtalk');	
					    exit;
					}else
					{
						require_once(WEB_ROOT."/system/dingtalk/dingtalk_common.php");
						$dingtalk_config=globalSetting('dingtalk');
						$weburl=urlencode(	WEBSITE_ROOT.create_url('mobile',array('act' => 'dingtalk','do' => 'fastlogin')));
						header("Location:"."https://oapi.dingtalk.com/connect/qrconnect?appid=".$dingtalk_config['appid']."&response_type=code&scope=snsapi_login&state=STATE&redirect_uri=".$weburl);
						exit;
							$showkey=base64_encode(get_sysopenid(false));
							$furl=WEBSITE_ROOT.create_url('mobile',array('act' => 'dingtalk','do' => 'fastlogin_pc','op'=>'dologin','skey'=>$showkey));
								$qurl=common_qrcode($furl);
				   include page('login_dingtalk_pc');	
					    exit;
					 }
				}
				
			$sms_settings=globalSetting('sms');
		
		include page('login');