<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
  	$settings=globalSetting('sms');
	if(empty($settings['regsiter_usesms']))
				{
				message("后台未开启短信功能");
				
					}
if (checksubmit("submit")) {
	if(empty($_GP['mobile']))
	{
		message("请填写手机号");	
	}
	$mobile=$_GP['mobile'];
	$base_member = mysqld_select("SELECT * FROM ".table('base_member')." where  mobile=:mobile and beid=:beid  limit 1", array(':beid'=>$_CMS['beid'],':mobile' => $mobile));
	if(empty($base_member['openid']))
	{
				message("不存在此手机号的用户");	
	}
	$doaction=false;
	
		if(!empty($settings['regsiter_usesms']))
				{
						 	require(WEB_ROOT.'/includes/lib/lib_sms.php'); 
				}
			  if(!empty($settings['regsiter_usesms'])&&!empty($settings['sms_change_pwd2'])&&!empty($settings['sms_change_pwd2_signname']))
				{
					$mobile=$base_member['mobile'];
						if(!empty($_GP['fromsmspage']))
					{
							if(empty($_GP['mobilecode']))
							{
								message("验证码不能空");	
							}
							
								  $vcode_check=system_sms_validate($mobile,'forgetpwd',$_GP['mobilecode']);
								  if( $vcode_check)
								  {
								
								    $doaction=true;	
								  }else
								  {
								
								  	  message("验证码错误");	
								  	  
								  }
					}else
					{
					
									system_sms_send($mobile,'forgetpwd',$settings['sms_change_pwd2'],$settings['sms_change_pwd2_signname']);
							  	include page('forgetpwd_smscheck');
							  	exit;
					}
				}
	
			if($doaction)
						{
				mysqld_update('base_member', array('pwd' => md5($_GP['newpassword'])),array('openid'=>$base_member['openid'],'beid'=>$_CMS['beid']));
			  message('密码修改请用新密码登录！', create_url('mobile',array('do'=>'member','act'=>'center','m'=>'eshop')), 'success');
						}
}
include page('forgetpwd');