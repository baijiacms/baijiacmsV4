<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.baijiacms.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 百家cms <QQ:1987884799> <http://www.baijiacms.com>
// +----------------------------------------------------------------------
defined('SYSTEM_IN') or exit('Access Denied');

function system_sms_validate($tell,$smstype,$vcode) {
		global $_CMS;
	
			if(empty($smstype)||empty($tell)||empty($vcode))
	{
	return  false;	
	}
	$sms_cache = mysqld_select("SELECT * FROM " . table('sms_cache').'where tell=:tell and smstype=:smstype and beid=:beid',array(":tell"=>$tell,":smstype"=>$smstype,':beid'=>$_CMS['beid']) );

  	$settings=globalSetting('sms');
  if(!empty($sms_cache['vcode']))
  {

  	if($vcode==$sms_cache['vcode'])
  	{
  		
  	return true;	
  	}
  	
  }
  return false;
	
	
}
function system_sms_curlsend($tell,$smstype,$sms_template_code,$sms_free_sign_name,$vcode) 
{
		global $_CMS;
	if(empty($sms_template_code)||empty($tell)||empty($sms_free_sign_name)||empty($vcode))
	{
	return;	
	}
	 $settings=globalSetting('sms');
		$productname="短信";
		if($smstype=='register_user')
		{
			$productname="用户注册";
		}
				if($smstype=='changepwd')
		{
			$productname="修改密码";
		}
				if($smstype=='changeinfo')
		{
			$productname="修改手机号";
		}
				if($smstype=='forgetpwd')
		{
			$productname="密码取回";
		}
		
		 $requestUrl="http://gw.api.taobao.com/router/rest?";
				$sysParams=array();
				$sysParams["app_key"] = $settings['sms_key'];
		$sysParams["v"] = "2.0";
		$sysParams["format"] = "json";
		$sysParams["sign_method"] = "md5";
		$sysParams["method"] = "alibaba.aliqin.fc.sms.num.send";
		$sysParams["timestamp"] = date("Y-m-d H:i:s");

		$apiParams = array("sms_type"=>"normal","sms_free_sign_name"=>$sms_free_sign_name,"rec_num"=>$tell,"sms_template_code"=>$sms_template_code,"sms_param"=>"{\"code\":\"".$vcode."\",\"product\":\"".$productname."\"}");
		
		$sysParams["sign"] = system_sms_generateSign(array_merge($apiParams, $sysParams));
			
				foreach ($sysParams as $sysParamKey => $sysParamValue)
		{
			// if(strcmp($sysParamKey,"timestamp") != 0)
			$requestUrl .= "$sysParamKey=" . urlencode($sysParamValue) . "&";
		}
						


		// $requestUrl .= "timestamp=" . urlencode($sysParams["timestamp"]) . "&";
		$requestUrl = substr($requestUrl, 0, -1);

		$data = http_post($requestUrl, $apiParams);		
			unset($apiParams);
				$return=@json_decode($data,true);
				$return=$return['alibaba_aliqin_fc_sms_num_send_response'];
					$return=$return['result'];
			if(empty($return['success']))
			{
			message("出现错误：".$data);	
			}

}
//$sms_template_code 短信模板
//$sms_free_sign_name 短信前面
//$smstype 区分用
function system_sms_send($tell,$smstype,$sms_template_code,$sms_free_sign_name) {
		global $_CMS;
	
			if(empty($sms_template_code))
	{
	return;	
	}
	$sms_cache = mysqld_select("SELECT * FROM " . table('sms_cache').'where tell=:tell and smstype=:smstype and beid=:beid',array(":tell"=>$tell,":smstype"=>$smstype,':beid'=>$_CMS['beid']) );
 	$settings=globalSetting('sms');
 	
  if(empty($sms_cache['id'])||($sms_cache['cachetime']+intval($settings['sms_secret_resec']))<=time())
  {
  	$sms_secret_count=5;
	if(!empty($settings['sms_secret_count']))
	{
		 	$sms_secret_count=intval($settings['sms_secret_count']);
	}
	if((($sms_cache['createtime']+(60*60*20))<time()))
	{
		
							$insertdate['checkcount']=0;
								$insertdate['createtime']=time();
				mysqld_update('sms_cache',$insertdate,array('id'=>$sms_cache['id'],'beid'=>$_CMS['beid']));
				$sms_cache = mysqld_select("SELECT * FROM " . table('sms_cache').'where id=:id and beid=:beid',array(":id"=>$sms_cache['id'],':beid'=>$_CMS['beid']) );
 	
	}
	
	
		if($sms_cache['checkcount']>=$sms_secret_count&&(($sms_cache['createtime']+(60*60*20))>=time()))
		{
			message("手机号：".$tell."的该短信业务已超过今天最大使用次数,请明天再试。");
		}else
		{
						
			$member=get_sysopenid(false);
			$vcode=rand(10000,99999);
			$insertdate=array('cachetime'=>time(),'smstype'=>$smstype,'vcode'=>$vcode,'tell'=>$tell);
			if(empty($sms_cache['id']))
			{
				$insertdate['createtime']=time();
				$insertdate['checkcount']=1;
				$insertdate['beid']=$_CMS['beid'];
				mysqld_insert('sms_cache',$insertdate);
			}else
			{
					
						$insertdate['checkcount']=$sms_cache['checkcount']+1;
				mysqld_update('sms_cache',$insertdate,array('id'=>$sms_cache['id'],'beid'=>$_CMS['beid']));
			}
		
			system_sms_curlsend($tell,$smstype,$sms_template_code,$sms_free_sign_name,$vcode);
		}
  }
}
function system_sms_test($tell,$sms_mobile_test,$sms_mobile_test_signname) 
{
	$vcode=rand(10000,99999);
	system_sms_curlsend($tell,'sms_test',$sms_mobile_test,$sms_mobile_test_signname,$vcode);
}
function system_sms_generateSign($params)
	{
		ksort($params);
		$settings=globalSetting('sms');
		$stringToBeSigned = $settings['sms_secret'];
		foreach ($params as $k => $v)
		{
			if(is_string($v) && "@" != substr($v, 0, 1))
			{
				$stringToBeSigned .= "$k$v";
			}
		}
		unset($k, $v);
		$stringToBeSigned .= $settings['sms_secret'];

		return strtoupper(md5($stringToBeSigned));
	}
function system_sms_curl($url, $postFields = null)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
		curl_setopt ( $ch, CURLOPT_USERAGENT, "top-sdk-php" );
		//https 请求
		if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" ) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		}

		if (is_array($postFields) && 0 < count($postFields))
		{
			$postBodyString = "";
			$postMultipart = false;
			foreach ($postFields as $k => $v)
			{
				if(!is_string($v))
					continue ;

				if("@" != substr($v, 0, 1))//判断是不是文件上传
				{
					$postBodyString .= "$k=" . urlencode($v) . "&"; 
				}
				else//文件上传用multipart/form-data，否则用www-form-urlencoded
				{
					$postMultipart = true;
					if(class_exists('\CURLFile')){
						$postFields[$k] = new \CURLFile(substr($v, 1));
					}
				}
			}
			unset($k, $v);
			curl_setopt($ch, CURLOPT_POST, true);
			if ($postMultipart)
			{
				if (class_exists('\CURLFile')) {
				    curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
				} else {
				    if (defined('CURLOPT_SAFE_UPLOAD')) {
				        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
				    }
				}
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
			}
			else
			{
				$header = array("content-type: application/x-www-form-urlencoded; charset=UTF-8");
				curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
				curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString,0,-1));
			}
		}
		$reponse = curl_exec($ch);
		
		if (curl_errno($ch))
		{
			throw new Exception(curl_error($ch),0);
		}
		else
		{
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if (200 !== $httpStatusCode)
			{
				throw new Exception($reponse,$httpStatusCode);
			}
		}
		curl_close($ch);
		return $reponse;
	}