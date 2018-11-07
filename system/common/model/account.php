<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}
if (!class_exists('AccountModel')) {
class AccountModel
{
	public function sendTplNotice($touser, $template_id, $postdata, $url = '', $topcolor = '#FF683F') {
				global $_CMS;
			if(!empty($touser))
			{
					 $base_member = mysqld_select("SELECT weixin_openid FROM ".table('base_member')." where  openid=:openid and beid=:beid  limit 1", array(':beid'=>$_CMS['beid'],':openid' => $touser));
					if(!empty($base_member['weixin_openid']))
					{
						$touser=$base_member['weixin_openid'];
					}
			}else
					{
					return true;	
					}
			
			if(is_access_weixin()==false)
			{
			return true;
			}
		if(empty($touser)) {
			return error(-1, '参数错误,粉丝openid不能为空');
		}
		if(empty($template_id)) {
			return error(-1, '参数错误,模板标示不能为空');
		}
		if(empty($postdata) || !is_array($postdata)) {
			return error(-1, '参数错误,请根据模板规则完善消息内容');
		}
		$token = get_weixin_token();
		if (is_error($token)) {
			return $token;
		}
		$data = array();
		$data['touser'] = $touser;
		$data['template_id'] = trim($template_id);
		$data['url'] = trim($url);
		$data['topcolor'] = trim($topcolor);
		$data['data'] = $postdata;
		$data = json_encode($data);
		$post_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$token}";
		$response = http_post($post_url, $data);
		if(is_error($response)) {
			return error(-1, "访问公众平台接口失败, 错误: {$response['message']}");
		}
		$result = @json_decode($response, true);
		if(empty($result)) {
			return error(-1, "接口调用失败, 元数据: {$response['meta']}");
		} elseif(!empty($result['errcode'])) {
			return error(-1, "访问微信接口错误, 错误代码: {$result['errcode']}, 错误信息: {$result['errmsg']}");
		}
		return true;
	}
	
		public function sendCustomNotice($data) {		
			global $_CMS;
			if(!empty($data['touser']))
			{
					 $base_member = mysqld_select("SELECT weixin_openid FROM ".table('base_member')." where  openid=:openid and beid=:beid  limit 1", array(':beid'=>$_CMS['beid'],':openid' => $data['touser']));
			if(!empty($base_member['weixin_openid']))
					{
						$data['touser']=$base_member['weixin_openid'];
				
					}else
					{
					return true;	
					}
			}else
					{
					return true;	
					}
				if(is_access_weixin()==false)
			{
			return true;
			}
		if(empty($data)) {
			return error(-1, '参数错误');
		}
		$token = get_weixin_token();
		if(is_error($token)){
			return $token;
		}
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$token}";
		$response = http_post($url, urldecode(json_encode($data)));
		if(is_error($response)) {
			return error(-1, "访问公众平台接口失败, 错误: {$response['message']}");
		}
		$result = @json_decode($response, true);
		if(empty($result)) {
			return error(-1, "接口调用失败, 元数据: {$response['meta']}");
		} elseif(!empty($result['errcode'])) {
			return error(-1, "访问微信接口错误, 错误代码: {$result['errcode']}, 错误信息: {$result['errmsg']},错误详情：{$result['errcode']}");
		}
		return $result;
	}
	
}
	
}