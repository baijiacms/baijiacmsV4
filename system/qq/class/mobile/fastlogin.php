<?php
$settings=globalSetting('qq');

$app_id =$settings['fastlogin_appid'];
$app_secret = $settings['fastlogin_appkey']; 
@session_start();
$my_url = WEBSITE_ROOT.'api/qq_returnurl.php';
$code = $_GP["code"];//存放Authorization Code 
$bizstate = $_GP["state"];
if(empty($bizstate))
{
	$bizstate = empty($_GP["bizstate"]) ? "qqlogin" : $_GP["bizstate"];
}
if($bizstate=='banding_qq')
{
	$openid = get_sysopenid(true);	
}

if(empty($code)) 
{
    //state参数用于防止CSRF攻击，成功授权后回调时会原样带回 
    //拼接URL 
    $dialog_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id="
     . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
     . $bizstate; 
    echo("<script> top.location.href='" . $dialog_url . "'</script>");
    exit;
}
   
    if(!empty($bizstate)&&!empty($code)) 
   {
    //拼接URL 
    $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
     . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url) 
     . "&client_secret=" . $app_secret . "&code=" . $code; 
    $response = file_get_contents($token_url); 
    if (strpos($response, "callback") !== false)//如果登录用户临时改变主意取消了，返回true!==false,否则执行step3 
    { 
     $lpos = strpos($response, "("); 
     $rpos = strrpos($response, ")"); 
     $response = substr($response, $lpos + 1, $rpos - $lpos -1); 
   	$msg = json_decode($response, true);	
     if (isset($msg['error'])) 
     { 
	message("QQ快捷登录出现".$msg['error']."错误,错误描述：".$msg['error_description'],create_url('mobile',array('do'=>'shop','act'=>'index','m'=>'eshop')),"error");	
     } 
    }
    
    
     //Step3：使用Access Token来获取用户的OpenID 
    $params = array(); 
    parse_str($response, $params);//把传回来的数据参数变量化 
    if(empty($params['access_token']))
    {
    message("QQ快捷登录出现错误",create_url('mobile',array('do'=>'shop','act'=>'index','m'=>'eshop')),"error");	
    }
    if(is_mobile())
    {
    	$graph_url = "https://graph.z.qq.com/moc2/me";
    }else
    {
 
    }
    $graph_url = "https://graph.qq.com/oauth2.0/me";
    $graph_url = $graph_url."?access_token=".$params['access_token']; 
    $str = file_get_contents($graph_url); 
    if (strpos($str, "callback") !== false) 
    { 
     $lpos = strpos($str, "("); 
     $rpos = strrpos($str, ")"); 
     $str = substr($str, $lpos + 1, $rpos - $lpos -1); 
    } 
    $user = json_decode($str, true);//存放返回的数据 client_id ，openid 
    if (isset($user['error'])||empty($user['openid'])) 
    { 
     
        	message("QQ快捷登录出现".$user['error']."错误,错误描述：".$user['error_description']);	
    } 
	
  $base_member = mysqld_select("SELECT * FROM " . table('base_member') . " WHERE qq_openid=:qq_openid and beid=:beid ", array(':qq_openid' =>$user['openid'],":beid"=>$_CMS['beid']));
			if($bizstate=="qqlogin")
			{
	    //Step4：使用<span style="font-family: Arial, Helvetica, sans-serif;">openid,</span><span style="font-family: Arial, Helvetica, sans-serif;">access_token来获取所接受的用户信息。</span> 
	     if(empty($base_member['openid']))
				{
					$user_data_url = "https://graph.qq.com/user/get_user_info?access_token={$params['access_token']}&oauth_consumer_key={$app_id}&openid={$user['openid']}&format=json"; 
	    	 $user_data = file_get_contents($user_data_url);//此为获取到的user信息
	  			   $fans = json_decode($user_data, true);
	  
								$new_sys_openid=getNewOpenid();
			
						$data = array(
								    'mobile' => '',
			                    'pwd' =>'',
			                    'createtime' => time(),
			                   'qq_openid' =>$user['openid'], 'openid' =>$new_sys_openid,'beid'=>$_CMS['beid']);
							mysqld_insert('base_member', $data);
							
	
						$data = array(
						'nickname'=>$fans['nickname'],
						'gender'=>$fans['gender']=='女'?1:0,
						'avatar'=>$fans['figureurl'],
						  'mobile' => '',
			                     'status' => 1,
			                    'createtime' => time(),
			                    'openid' =>$new_sys_openid,'uniacid'=>$_CMS['beid']);
							mysqld_insert('eshop_member', $data);	
							save_member_login($new_sys_openid);
				}else
				{
					save_member_login($base_member['openid']);
				}
	    
	    	message("QQ登陆成功！",gologinfromurl(),'success');	
    	}
    		if($bizstate=="banding_qq")
			{
				$base_member = mysqld_select("SELECT * FROM " . table('base_member') . " WHERE qq_openid=:qq_openid and beid=:beid ", array(':qq_openid' =>$user['openid'],":beid"=>$_CMS['beid']));
				if(!empty($base_member['qq_openid']))
				{
				message("已有账户绑定此QQ号，需要先那个账户先解绑，才能用于此账户绑定！",create_url('mobile',array('act' => 'shopwap','do' => 'account')),'error',true,5);	
				}
				$openid = get_sysopenid(true);
					mysqld_update("base_member",array("qq_openid"=>$user['openid']),array('openid' => $openid));
				  	message("QQ号绑定成功！",create_url('mobile',array('act' => 'shopwap','do' => 'account')),'success');	
			}
    	
    }
    else
    { 
    	message("QQ快捷登录出现错误！");	
    } 
		
