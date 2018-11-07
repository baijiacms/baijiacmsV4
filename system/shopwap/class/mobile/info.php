<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
$openid = get_sysopenid(true);

$memberinfo = get_member_info($openid);

				if (checksubmit("submit")) {
				if(empty($_GP['fromsmspage']))
					{
    	     
      if (!empty($_FILES['upload_image']['tmp_name'])) {
    
                    $upload = file_upload($_FILES['upload_image']);
                    if (is_error($upload)) {
                        message($upload['message'], '', 'error');
                    }
                    
                  	$avatar=ATTACHMENT_ROOT.$upload['path'];
                }
    
    
      $update_member=array(
       	'nickname'=> $_GP['nickname'],
                            'realname'=> $_GP['realname'],
                            'weixin'=> $_GP['weixin'],
                            'gender'=> $_GP['gender']
      );
      
      if(!empty($avatar))
    	{
    		$update_member['avatar']=$avatar;
    	}
            mysqld_update('eshop_member', $update_member, array(
                'openid' => $openid,
                'uniacid' => $_W['uniacid']
            ));
            
      }
            
            
    		if(empty($_GP['mobile']))
				{
					message("请填写手机号");	
				}
      	$is_update_member_mobile=update_member_mobile($openid,$_GP['mobile'],false);
      	  if( $is_update_member_mobile==-1)
            {
                  message($_GP['mobile']."手机号已被其他用户注册。");
                  exit;
           }
 				$doaction=true;
            		
  	$settings=globalSetting('sms');
     if( $is_update_member_mobile==1)
    {
	  		if(!empty($settings['regsiter_usesms']))
				{
						 	require(WEB_ROOT.'/includes/lib/lib_sms.php'); 
				}
			  if(!empty($settings['regsiter_usesms'])&&!empty($settings['sms_change_mobile'])&&!empty($settings['sms_change_mobile_signname']))
				{
					$mobile=$_GP['mobile'];
					$doaction=false;
						if(!empty($_GP['fromsmspage']))
					{
							if(empty($_GP['mobilecode']))
							{
								message("验证码不能空");	
							}
							
								  $vcode_check=system_sms_validate($mobile,'changeinfo',$_GP['mobilecode']);
								  if( $vcode_check)
								  {
								
								    $doaction=true;	
								  }else
								  {
								
								  	  message("验证码错误");	
								  	  
								  }
					}else
					{
					
									system_sms_send($mobile,'changeinfo',$settings['sms_change_mobile'],$settings['sms_change_mobile_signname']);
							  	include page('changeinfo_smscheck');
							  	exit;
					}
				}
            		
    
            	
            }
            if($doaction)
            {
            	  $is_update_member_mobile=update_member_mobile($openid,$_GP['mobile'],true);
            	  if( $is_update_member_mobile==-1)
		            {
		                  message($_GP['mobile']."手机号已被其他用户注册。",create_url('mobile',array('do'=>'member','act'=>'center','m'=>'eshop')),'error');
		                  exit;
		          	 }
            }
			  message('资料修改成功！', create_url('mobile',array('do'=>'member','act'=>'center','m'=>'eshop')), 'success');
				
				
			}
include page('info');