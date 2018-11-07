<?php
defined('SYSTEM_IN') or exit('Access Denied');
function register_from_dingtalk($dingtalk_openid)
{
		global $_GP,$_CMS;
		$base_member = mysqld_select("SELECT * FROM " . table('base_member') . " WHERE dingtalk_openid=:dingtalk_openid and beid=:beid ", array(':dingtalk_openid' =>$dingtalk_openid,":beid"=>$_CMS['beid']));
	
				if(empty($base_member['openid']))
			{
				
					$new_sys_openid=getNewOpenid();
		
					$data = array(
							    'mobile' => '',
		                    'pwd' =>'',
		                    'createtime' => time(),
		                   'dingtalk_openid' =>$dingtalk_openid, 'openid' =>$new_sys_openid,'beid'=>$_CMS['beid']);
						mysqld_insert('base_member', $data);
						

					$data = array(
					'nickname'=>'',
					'gender'=>'',
					'avatar'=>'',
					  'mobile' => '',
		                     'status' => 1,
		                    'createtime' => time(),
		                    'openid' =>$new_sys_openid,'uniacid'=>$_CMS['beid']);
						mysqld_insert('eshop_member', $data);	
						return $new_sys_openid;
			}
	return $base_member['openid'];
}
function dingtalk_config()
{
	
$weburl=WEBSITE_ROOT . 'index.php?' . $_SERVER['QUERY_STRING'];
    	$configs=globalSetting('dingtalk');
    	
    $config_param=array("agentId"=>$configs['fastlogin_agentID'],"corpId"=>$configs['fastlogin_corpID']
    ,"timeStamp"=>time(),"nonceStr"=>dingtalk_createNonceStr());	
    $config_param['signature']=dingtalk_sign(get_dingtalk_jsticket(),$config_param['nonceStr'],$config_param['timeStamp'],$weburl);
    return $config_param;
}
function dingtalk_createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}
function dingtalk_sign($ticket, $nonceStr, $timeStamp, $url)
{
        $plain = 'jsapi_ticket=' . $ticket .
            '&noncestr=' . $nonceStr .
            '&timestamp=' . $timeStamp .
            '&url=' . $url;
        return sha1($plain);
}
function dingtalk_getuserinfo($usercode) {
	$dingtalk_access_token=get_dingtalk_accesstoken($refresh=false);
		$url = "https://oapi.dingtalk.com/user/getuserinfo?access_token={$dingtalk_access_token}&code={$usercode}";
		$content = http_get($url);
			$content = @json_decode($content, true);
			return $content;
}
function get_dingtalk_accesstoken($refresh=false) {
	if($refresh)
	{
			$cfg = array('dingtalk_access_token'=>'');
		refreshSetting($cfg,'dingtalk');
	}
	$configs=globalSetting('dingtalk');
	$dingtalk_access_token=$configs['dingtalk_access_token'];
	if(is_array($dingtalk_access_token) && !empty($dingtalk_access_token['token']) && !empty($dingtalk_access_token['expire']) && $dingtalk_access_token['expire'] > TIMESTAMP) {
		return $dingtalk_access_token['token'];
	} else {
			$corpID = $configs['fastlogin_corpID'];
			$secret = $configs['fastlogin_corpSecret'];
		
		if (empty($corpID) || empty($secret)) {
			message('请填写钉钉的corpID及corpSecret！');
		}
		
		$url = "https://oapi.dingtalk.com/gettoken?corpid={$corpID}&corpsecret={$secret}";
		$content = http_get($url);
		if(empty($content)) {
			message('获取钉钉信息, 请稍后重试！');
		}
		$token = @json_decode($content, true);
		if(empty($token) || !is_array($token)) {
			message('获取钉钉授权失败, 请稍后重试！ 公众平台返回原始数据为:' . $token);
		}
		if(empty($token['access_token'])) {
			message('解析钉钉授权失败, 请稍后重试！');
		}
		$record = array();
		$record['token'] = $token['access_token'];
		$record['expire'] = TIMESTAMP + "7200";
		$cfg = array('dingtalk_access_token'=> $record);
		refreshSetting($cfg,'dingtalk');
		return $record['token'];
	}
}
function get_dingtalk_jsticket() {
 	$configs=globalSetting('dingtalk');
		$jsapi_ticket=$configs['jsapi_ticket'];
		$jsapi_ticket_exptime = intval($configs['jsapi_ticket_exptime']);
		if(empty($jsapi_ticket)||empty($jsapi_ticket_exptime)||$jsapi_ticket_exptime< time()) {
			
			$accessToken = get_dingtalk_accesstoken();
    	 $url = "https://oapi.dingtalk.com/get_jsapi_ticket?access_token=$accessToken";
     		$content = http_get($url);
      $res = @json_decode($content,true);
      $ticket = $res['ticket'];
      
      if (!empty($ticket)) {
      	$cfg = array(
						'jsapi_ticket' => $ticket,
						'jsapi_ticket_exptime' => time() + intval($res['expires_in'])
					);
					refreshSetting($cfg,'dingtalk');
      	return $ticket;
      }
      return '';
			
			} else {
			return $jsapi_ticket;
			}
}