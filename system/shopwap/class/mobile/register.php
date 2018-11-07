<?php	
if (!defined("IN_IA")) {
    exit("Access Denied");
}
if(is_login_account())
{
header("location:".create_url('mobile',array('act' => 'center','do' => 'member','m'=>'eshop')));	
		exit;	
}

	
		if (checksubmit("submit")) {
			$mobile=$_GP['mobile'];
	
				$pwd=$_GP['newpassword'];
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
					message("请输入手机号！");	
			}
				$member = mysqld_select("SELECT * FROM ".table('base_member')." where mobile=:mobile  and beid=:beid", array(':mobile' => $mobile,':beid'=>$_CMS['beid']));
			if(!empty($member['openid']))
			{
					message($mobile."已被注册。");	
			}
			if(empty($_GP['third_login']))
			{
					if(empty($pwd))
				{
						message("请输入密码！");	
				}
		}else
		{
			$pwd='';
		}
	
		$doaction=true;
					$settings=globalSetting('sms');
		if(!empty($settings['regsiter_usesms']))
		{
				 	require(WEB_ROOT.'/includes/lib/lib_sms.php'); 
		}
		if(!empty($settings['regsiter_usesms'])&&!empty($settings['sms_register_user'])&&!empty($settings['sms_register_user_signname']))
		{
			$doaction=false;
				if(!empty($_GP['fromsmspage']))
			{
					if(empty($_GP['mobilecode']))
					{
						message("验证码不能空");	
					}
					
						  $vcode_check=system_sms_validate($mobile,'register_user',$_GP['mobilecode']);
						  if( $vcode_check)
						  {
						
						    $doaction=true;	
						  }else
						  {
						
						  	  message("验证码错误");	
						  	  
						  }
			}else
			{
			
							system_sms_send($mobile,'register_user',$settings['sms_register_user'],$settings['sms_register_user_signname']);
					  	include page('register_smscheck');
					  	exit;
			}
		}

		if($doaction)
		{
		$shop_regcredit=intval($cfg['shop_regcredit']);
		

		$oldsessionid=get_sysopenid(false);

				$openid=member_create_new($mobile,$pwd);
		
				
		
				if(!empty($shop_regcredit))
				{
				member_credit($openid,$shop_regcredit,"addcredit","注册系统赠送积分");
				}
				
	
					
				save_member_login($openid);
	
			  message('注册成功！', gologinfromurl(), 'success');
			}
		}
	if(is_use_weixin()&&($_GP['op']!='account'))
				{
					$isregister=true;
					    include page('login_weixin');	
					    exit;
				}
        include page('register');	