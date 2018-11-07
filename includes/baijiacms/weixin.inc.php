<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.baijiacms.com All rights reserved.
// +----------------------------------------------------------------------
// | Comments: mysql数据库操作
// +----------------------------------------------------------------------
// | Author: 百家cms <QQ:1987884799> <http://www.baijiacms.com>
// +----------------------------------------------------------------------
defined('SYSTEM_IN') or exit('Access Denied');
function is_weixin()
{
	if ((strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!== false)) {
		return true;
	}
	return false;
}
function is_access_weixin()
{
	$configs=globalSetting('weixin');
	if(empty($configs['weixin_noaccess'])&&!empty($configs['weixin_appId']))
	{
		return true;
	}
			return false;	
}
function is_use_weixin()
{
	if(is_access_weixin())
	{
			if (is_weixin()) {
		return true;
		}
	}
			return false;	
}

function get_weixin_fans_info($weixin_openid,$openid)
{
        global $_W;
        if(empty($weixin_openid))
        {
	      $base_member = pdo_fetch('select weixin_openid from ' . tablename('base_member') . ' where  openid=:openid and beid=:beid limit 1', array(
	                ':beid' => $_W['uniacid'],
	                ':openid' => $openid
	        ));
	        $weixin_openid=$base_member['weixin_openid'];
      	}
        $info = pdo_fetch('select * from ' . tablename('weixin_fans') . ' where  weixin_openid=:weixin_openid and uniacid=:uniacid limit 1', array(
                ':uniacid' => $_W['uniacid'],
                ':weixin_openid' =>$weixin_openid
        ));
        return $info;
}
function get_weixin_token($refresh=false) {

	if($refresh)
	{
			$cfg = array('weixin_access_token'=>'');
		refreshSetting($cfg,'weixin');
	}
	$configs=globalSetting('weixin');
	$weixin_access_token=$configs['weixin_access_token'];
	if(is_array($weixin_access_token) && !empty($weixin_access_token['token']) && !empty($weixin_access_token['expire']) && $weixin_access_token['expire'] > TIMESTAMP) {
		return $weixin_access_token['token'];
	} else {
			$appid = $configs['weixin_appId'];
			$secret = $configs['weixin_appSecret'];
		
		if (empty($appid) || empty($secret)) {
			message('请填写公众号的appid及appsecret！');
		}
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
		$content = http_get($url);
		if(empty($content)) {
			message('获取微信公众号授权失败, 请稍后重试！');
		}
		$token = @json_decode($content, true);
		if(empty($token) || !is_array($token)) {
			message('获取微信公众号授权失败, 请稍后重试！ 公众平台返回原始数据为:' . $token);
		}
		if(empty($token['access_token']) || empty($token['expires_in'])) {
			message('解析微信公众号授权失败, 请稍后重试！');
		}
		$record = array();
		$record['token'] = $token['access_token'];
		$record['expire'] = TIMESTAMP + $token['expires_in'];
		$cfg = array('weixin_access_token'=> $record);
		refreshSetting($cfg,'weixin');
		return $record['token'];
	}
}
function get_js_ticket() {
	if(is_use_weixin()==false)
	{
	return '';
	}
 	$configs=globalSetting('weixin');
		$jsapi_ticket=$configs['jsapi_ticket'];
		$jsapi_ticket_exptime = intval($configs['jsapi_ticket_exptime']);
		if(empty($jsapi_ticket)||empty($jsapi_ticket_exptime)||$jsapi_ticket_exptime< time()) {
			
			$accessToken = get_weixin_token();
    	 $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
     		$content = http_get($url);
      $res = @json_decode($content,true);
      $ticket = $res['ticket'];
      
      if (!empty($ticket)) {
      	$cfg = array(
						'jsapi_ticket' => $ticket,
						'jsapi_ticket_exptime' => time() + intval($res['expires_in'])
					);
					refreshSetting($cfg,'weixin');
      	return $ticket;
      }
      return '';
			
			} else {
			return $jsapi_ticket;
			}
	}
	function function_weixinname_emoji(array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            }
	function filter_weixinname_emoji($string)
	{
		    $string = preg_replace_callback(
            '/./u',
            function_weixinname_emoji,
            $string);

     return $string;
 }
	function register_snsapi_userinfo($weixinopenid,$checkweixin=true)
	{
		if(is_use_weixin()==false&&$checkweixin)
		{
		return '';
		}
				global $_GP,$_CMS;
				$fans = mysqld_select("SELECT * FROM " . table('weixin_fans') . " WHERE weixin_openid=:weixin_openid and uniacid=:uniacid ", array(':weixin_openid' =>$weixinopenid,":uniacid"=>$_CMS['beid']));

		 if((!empty($_CMS['beid'])&&!empty($weixinopenid))&&(empty($fans['follow'])||empty($fans['nickname'])))
		 {
				
					$access_token=get_weixin_token();
					$oauth2_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$weixinopenid."&lang=zh_CN";
					$content = http_get($oauth2_url);
					$info = @json_decode($content, true);
					if($info['subscribe']==1)
					{
						$follow=1;
					}
		
				
			if(!empty($info['openid']))
				{
					$nickname=$info["nickname"];
					if(!empty($nickname))
					{
					$nickname=filter_weixinname_emoji($nickname);
					}
	
					 if(empty($fans['weixin_openid']))
						  {
						  $record = array(
								'follow' => $info['subscribe'],
								'followtime' => $info['subscribe_time'],
								'unfollowtime' => 0,
								'tag' => base64_encode(iserializer($info)),
								'gender' => $info['sex'],
								'nickname' => $nickname,
								'avatar' => $info['headimgurl'],
								'updatetime' => TIMESTAMP);
						 		$record['uniacid']= $_CMS['beid'];
						 		$record['weixin_openid']= $weixinopenid;
								mysqld_insert('weixin_fans', $record);	
							}else
							{
								$record = array();
							if(!empty($info['subscribe']))
								{
								$record['follow']=$info['subscribe'];
								}
									if(!empty($info['subscribe_time']))
								{
								$record['followtime']=$info['subscribe_time'];
								}
									if(!empty($info))
								{
								$record['tag']=base64_encode(iserializer($info));
								}
									if(!empty($info['sex']))
								{
								$record['gender']=$info['sex'];
								}
										if(!empty($nickname))
								{
								$record['nickname']=$nickname;
								}
										if(!empty($info['sex']))
								{
								$record['avatar']=$info['headimgurl'];
								}
									
								$record['updatetime']=TIMESTAMP;
								mysqld_update('weixin_fans', $record,array('uniacid'=>$_CMS['beid'],'weixin_openid'=>$weixinopenid));	
								
							}
									
				}
				unset($fans);
				
			}
		//register_from_wxfans($weixinopenid);
}
function get_weixin_follow_userinfo($openid)
{
		if ( is_access_weixin()==false ) {
		return false;
	}
		$accessToken = get_weixin_token();
    $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$accessToken&openid=$openid&lang=zh_CN";
    	$content = http_get($url);
      $res = @json_decode($content,true);
      return $res;
}
function register_from_wxfans($weixinopenid)
{
		global $_GP,$_CMS;
		$base_member = mysqld_select("SELECT * FROM " . table('base_member') . " WHERE weixin_openid=:weixin_openid and beid=:beid ", array(':weixin_openid' =>$weixinopenid,":beid"=>$_CMS['beid']));
		$fans = mysqld_select("SELECT * FROM " . table('weixin_fans') . " WHERE weixin_openid=:weixin_openid and uniacid=:uniacid ", array(':weixin_openid' =>$weixinopenid,":uniacid"=>$_CMS['beid']));
		if(!empty($fans['weixin_openid']))
		{
				if(empty($base_member['openid']))
			{
				
					$new_sys_openid=getNewOpenid();
		
					$data = array(
							    'mobile' => '',
		                    'pwd' =>'',
		                    'createtime' => time(),
		                   'weixin_openid' =>$fans['weixin_openid'], 'openid' =>$new_sys_openid,'beid'=>$_CMS['beid']);
						mysqld_insert('base_member', $data);
						

					$data = array(
					'nickname'=>$fans['nickname'],
					'gender'=>$fans['gender'],
					'avatar'=>$fans['avatar'],
					  'mobile' => '',
		                     'status' => 1,
		                    'createtime' => time(),
		                    'openid' =>$new_sys_openid,'uniacid'=>$_CMS['beid']);
						mysqld_insert('eshop_member', $data);	
						return $new_sys_openid;
			}else
			{
				$eshop_member = mysqld_select("SELECT * FROM " . table('eshop_member') . " WHERE openid=:openid and uniacid=:uniacid ", array(':openid' =>$base_member['openid'],":uniacid"=>$_CMS['beid']));
					$data = array();
			if(empty($eshop_member['nickname']))
			{
					$data['nickname']=$fans['nickname'];
			}
				if(empty($eshop_member['avatar']))
			{
					$data['avatar']=$fans['avatar'];
			}
				if(empty($eshop_member['gender']))
			{
					$data['gender']=$fans['gender'];
			}
				if(!empty($data)&&!empty($fans['follow']))
				{
						mysqld_update('eshop_member', $data,array( 'openid' =>$base_member['openid'],'uniacid'=>$_CMS['beid']));		
				}
				return false;
			}
		}
}


function weixin_js_signPackage($signPackage=array())
{
	if ( is_use_weixin()==false ) {
		return true;
		}
	 $settings=globalSetting('weixin');
	 $timestamp=TIMESTAMP;
   $nonceStr =weixin_createNonceStr(16);
   $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
   $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	 $jsapiTicket = get_js_ticket();
	 $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
	 $signature = sha1($string);
	 $signPackage["appId"]=$settings['weixin_appId'];
	 $signPackage["nonceStr"]=$nonceStr;
	 $signPackage["timestamp"]=$timestamp;
	 $signPackage["url"]=$url;
	 $signPackage["signature"]=$signature;
	 $signPackage["rawString"]=$string;
	 return $signPackage;
}
function weixin_createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}
function get_weixin_openid() {
  	global $_GP,$_CMS;
	if(is_use_weixin()==false)
	{
	return '';
	}
$settings=globalSetting('weixin');
$lifeTime = 24 * 3600 * 1;
session_set_cookie_params($lifeTime);
@session_start();
if(!empty($_SESSION[MOBILE_WEIXIN_OPENID]))
{
	return $_SESSION[MOBILE_WEIXIN_OPENID];	
}
 $cookieid = "__s".md5(SESSION_PREFIX)."_open";
$openid   = base64_decode($_COOKIE[$cookieid]);
	if (!empty($openid)) {
		if(empty($_SESSION[MOBILE_WEIXIN_OPENID]))
		{
		$_SESSION[MOBILE_WEIXIN_OPENID]=$openid;
		}
           return $openid;
  }
    $appId        = $settings['weixin_appId'];
        $appSecret    = $settings['weixin_appSecret'];
        	if(empty($appId) || empty($appSecret)){
					message('微信公众号没有配置公众号AppId和公众号AppSecret!') ;
					}
        $access_token = "";
        $code         = $_GP['code'];
        $url          = WEBSITE_ROOT . 'index.php?' . $_SERVER['QUERY_STRING'];
       
    if (empty($code)) {
           $authurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appId . "&redirect_uri=" . urlencode($url) . "&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
            header('location: ' . $authurl);
            exit();
        } else {
            $tokenurl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $appSecret . "&code=" . $code . "&grant_type=authorization_code";
         	$resp = http_get($tokenurl);
					$token = @json_decode($resp, true);
            if (!empty($token) && is_array($token) && $token['errmsg'] == 'invalid code') {
         
            $authurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appId . "&redirect_uri=" . urlencode($url) . "&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
                header('location: ' . $authurl);
                exit();
            }
            if (is_array($token) && !empty($token['openid'])) {
            
                $access_token = $token['access_token'];
                $openid       = $token['openid'];
                setcookie($cookieid, base64_encode($openid));
                  	if (!empty($openid)) {
                $_SESSION[MOBILE_WEIXIN_OPENID]=$openid;
     				  }
                    return $openid;
            } else {
                $querys = explode('&', $_SERVER['QUERY_STRING']);
                $newq   = array();
                foreach ($querys as $q) {
                    if (!strexists($q, 'code=') && !strexists($q, 'state=') && !strexists($q, 'from=') && !strexists($q, 'isappinstalled=')) {
                        $newq[] = $q;
                    }
                }
                $rurl    = WEBSITE_ROOT. 'index.php?' . implode('&', $newq);
                $authurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appId . "&redirect_uri=" . urlencode($rurl) . "&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
                header('location: ' . $authurl);
                exit;
            }
        }
          return $openid;
  	
}
function weixin_send_custom_message($from_user,$msg) {
	  
    	$access_token=get_weixin_token();
    	 $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
 	$msg = str_replace('"', '\\"',$msg);
  $post='{"touser":"'.$from_user.'","msgtype":"text","text":{"content":"'.$msg.'"}}';

    http_post($url,$post);
    	
}



function get_weixin_openid_autoreg() {
	global $_GP,$_CMS;
	if(is_use_weixin()==false)
	{
	return '';
	}
$settings=globalSetting('weixin');
$lifeTime = 24 * 3600 * 1;
session_set_cookie_params($lifeTime);
@session_start();
 $cookieid = "__s".md5(SESSION_PREFIX)."_open";
$openid   = base64_decode($_COOKIE[$cookieid]);
	if (!empty($openid)) {
		if(empty($_SESSION[MOBILE_WEIXIN_OPENID]))
		{
		$_SESSION[MOBILE_WEIXIN_OPENID]=$openid;
		}
           return $openid;
  }
    $appId        = $settings['weixin_appId'];
        $appSecret    = $settings['weixin_appSecret'];
        	if(empty($appId) || empty($appSecret)){
					message('微信公众号没有配置公众号AppId和公众号AppSecret!') ;
					}
        $access_token = "";
        $code         = $_GP['code'];
        $url          = WEBSITE_ROOT . '/index.php?' . $_SERVER['QUERY_STRING'];
       
    if (empty($code)) {
    			if($_GP['state']==2)
    			{
            $authurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appId . "&redirect_uri=" . urlencode($url) . "&response_type=code&scope=snsapi_userinfo&state=2#wechat_redirect";
            header('location: ' . $authurl);
            exit();
          }else
          {
          	  $authurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appId . "&redirect_uri=" . urlencode($url) . "&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
            header('location: ' . $authurl);
            exit();
          }
        } else {
            $tokenurl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appId . "&secret=" . $appSecret . "&code=" . $code . "&grant_type=authorization_code";
         	$resp = http_get($tokenurl);
					$token = @json_decode($resp, true);
            if (!empty($token) && is_array($token) && $token['errmsg'] == 'invalid code') {
            	if($_GP['state']==2)
		    			{
		            $authurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appId . "&redirect_uri=" . urlencode($url) . "&response_type=code&scope=snsapi_userinfo&state=2#wechat_redirect";
		            header('location: ' . $authurl);
		            exit();
		          }else
		          {
            $authurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appId . "&redirect_uri=" . urlencode($url) . "&response_type=code&scope=snsapi_base&state=1#wechat_redirect";
                header('location: ' . $authurl);
                exit();
              }
            }
            if (is_array($token) && !empty($token['openid'])) {
            
                $access_token = $token['access_token'];
                $openid       = $token['openid'];
             
                register_from_weixinopenid($access_token,$openid,$_GP['state']);
                setcookie($cookieid, base64_encode($openid));
                  	if (!empty($openid)) {
                $_SESSION[MOBILE_WEIXIN_OPENID]=$openid;
     				  }
                
            } else {
                $querys = explode('&', $_SERVER['QUERY_STRING']);
                $newq   = array();
                foreach ($querys as $q) {
                    if (!strexists($q, 'code=') && !strexists($q, 'state=') && !strexists($q, 'from=') && !strexists($q, 'isappinstalled=')) {
                        $newq[] = $q;
                    }
                }
                $rurl    = WEBSITE_ROOT. 'index.php?' . implode('&', $newq);
                $authurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appId . "&redirect_uri=" . urlencode($rurl) . "&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
                header('location: ' . $authurl);
                exit;
            }
        }
          return $openid;
}

function register_from_weixinopenid($access_token,$weixinopenid,$state)
	{
		if(is_use_weixin()==false)
		{
		return '';
		}
				global $_GP,$_CMS;
				$fans = mysqld_select("SELECT * FROM " . table('weixin_fans') . " WHERE weixin_openid=:weixin_openid and uniacid=:uniacid ", array(':weixin_openid' =>$weixinopenid,":uniacid"=>$_CMS['beid']));
 
		 if((!empty($_CMS['beid'])&&!empty($weixinopenid))&&(empty($fans['nickname'])||(!empty($fans['updatetime'])&&($fans['updatetime']+(24 * 3600 * 7))<TIMESTAMP)))
		 {
				if($state==2)
				{
	
					$oauth2_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$weixinopenid."&lang=zh_CN";
					$content = http_get($oauth2_url);
					$info = @json_decode($content, true);
					$follow=0;
				}else
				{
					$access_token=get_weixin_token();
					$oauth2_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$weixinopenid."&lang=zh_CN";
					$content = http_get($oauth2_url);
					$info = @json_decode($content, true);
					if($info['subscribe']==1)
					{
						$follow=1;
					}else
					{
					$settings=globalSetting('weixin');
						 $appId        = $settings['weixin_appId'];
						 $url          = WEBSITE_ROOT . '/index.php?' . $_SERVER['QUERY_STRING'];
						    $authurl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appId . "&redirect_uri=" . urlencode($url) . "&response_type=code&scope=snsapi_userinfo&state=2#wechat_redirect";
	            header('location: ' . $authurl);
	            exit();
					}
			}
				
			if(!empty($info['openid']))
				{
					$nickname=$info["nickname"];
					$nickname=filter_weixinname_emoji($nickname);
				  $record = array(
								'follow' => $info['subscribe'],
								'followtime' => $info['subscribe_time'],
								'unfollowtime' => 0,
								'tag' => base64_encode(iserializer($info)),
								'gender' => $info['sex'],
								'nickname' => $nickname,
								'avatar' => $info['headimgurl'],
								'updatetime' => TIMESTAMP);
					 if(empty($fans['weixin_openid']))
						  {
						 		$record['uniacid']= $_CMS['beid'];
						 		$record['weixin_openid']= $weixinopenid;
								mysqld_insert('weixin_fans', $record);	
							}else
							{
								
								mysqld_update('weixin_fans', $record,array('uniacid'=>$_CMS['beid'],'weixin_openid'=>$weixinopenid));	
								
							}
									
				}
				unset($fans);
				
			}
			$base_member = mysqld_select("SELECT * FROM " . table('base_member') . " WHERE weixin_openid=:weixin_openid and beid=:beid ", array(':weixin_openid' =>$weixinopenid,":beid"=>$_CMS['beid']));
		$fans = mysqld_select("SELECT * FROM " . table('weixin_fans') . " WHERE weixin_openid=:weixin_openid and uniacid=:uniacid ", array(':weixin_openid' =>$weixinopenid,":uniacid"=>$_CMS['beid']));
		 
				if(empty($base_member['openid']))
			{
			
					$new_sys_openid=getNewOpenid();
		
					$data = array(
							    'mobile' => '',
		                    'pwd' =>'',
		                    'createtime' => time(),
		                   'weixin_openid' =>$fans['weixin_openid'], 'openid' =>$new_sys_openid,'beid'=>$_CMS['beid']);
						mysqld_insert('base_member', $data);
						

					$data = array(
					'nickname'=>$fans['nickname'],
					'gender'=>$fans['gender'],
					'avatar'=>$fans['avatar'],
					  'mobile' => '',
		                     'status' => 1,
		                    'createtime' => time(),
		                    'openid' =>$new_sys_openid,'uniacid'=>$_CMS['beid']);
						mysqld_insert('eshop_member', $data);		
			}else
			{
				$eshop_member = mysqld_select("SELECT * FROM " . table('eshop_member') . " WHERE openid=:openid and uniacid=:uniacid ", array(':openid' =>$base_member['openid'],":uniacid"=>$_CMS['beid']));
					$data = array();
			if(empty($eshop_member['nickname']))
			{
					$data['nickname']=$fans['nickname'];
			}
				if(empty($eshop_member['avatar']))
			{
					$data['avatar']=$fans['avatar'];
			}
				if(empty($eshop_member['gender']))
			{
					$data['gender']=$fans['gender'];
			}
				if(!empty($data))
				{ 
						mysqld_update('eshop_member', $data,array( 'openid' =>$eshop_member['openid'],'uniacid'=>$_CMS['beid']));		
				}
			}
				
	}