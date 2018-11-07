<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
$openid = get_sysopenid(true);

$memberinfo = mysqld_select("SELECT * FROM ".table('base_member')." where openid=:openid and beid=:beid limit 1", array(':openid' => $openid,':beid'=>$_CMS['beid']));

if(empty($memberinfo['mobile']))
{
	 message("请先完善您的手机号",create_url('mobile',array('act' => 'shopwap','do' => 'info')),'error');
}
if(empty($memberinfo['pwd']))
					{
						$hiddenoldpwd=true;
					}
				if (checksubmit("submit")) {
		

					if(!empty($memberinfo['pwd']))
					{
						if(empty($_GP['newpassword']))
						{
								message("请输入密码！");	
						}
						if($memberinfo['pwd']!=md5($_GP['oldpwd']))
						{
								message("原始密码错误！");	
						}
				}
		
		$doaction=true;
						
						
	  $settings=globalSetting('sms');
	  		if(!empty($settings['regsiter_usesms']))
		{
				 	require(WEB_ROOT.'/includes/lib/lib_sms.php'); 
		}
	  if(!empty($settings['regsiter_usesms'])&&!empty($settings['sms_change_pwd1'])&&!empty($settings['sms_change_pwd1_signname']))
		{
			$mobile=$memberinfo['mobile'];
			$doaction=false;
				if(!empty($_GP['fromsmspage']))
			{
					if(empty($_GP['mobilecode']))
					{
						message("验证码不能空");	
					}
					
						  $vcode_check=system_sms_validate($mobile,'changepwd',$_GP['mobilecode']);
						  if( $vcode_check)
						  {
						
						    $doaction=true;	
						  }else
						  {
						
						  	  message("验证码错误");	
						  	  
						  }
			}else
			{
			
							system_sms_send($mobile,'changepwd',$settings['sms_change_pwd1'],$settings['sms_change_pwd1_signname']);
					  	include page('changepwd_smscheck');
					  	exit;
			}
		}
	  
						if($doaction)
						{
				mysqld_update('base_member', array('pwd' => md5($_GP['newpassword'])),array('openid'=>$openid,'beid'=>$_CMS['beid']));
			  message('密码修改成功！', create_url('mobile',array('do'=>'member','act'=>'center','m'=>'eshop')), 'success');
						}
				
			}
include page('changepwd');