<?php
defined('SYSTEM_IN') or exit('Access Denied');

class weixinAddons  extends BjSystemModule {
			public function do_subscribe_entry()
	{
		$this->__web(__FUNCTION__);
	}
			public function do_follow()
	{
		$this->__web(__FUNCTION__);
	}
		public function do_sysset_notice()
	{
		$this->__web(__FUNCTION__);
	}
		public function do_commission_notice()
	{
		$this->__web(__FUNCTION__);
	}
	
		public function do_coupon_send_notice()
	{
		$this->__web(__FUNCTION__);
	}
	public function do_virtual_send_notice()
	{
		$this->__web(__FUNCTION__);
	}
	public function do_setting()
	{
		$this->__web(__FUNCTION__);
	}
	
	public function do_designer()
	{
		$this->__web(__FUNCTION__);
	}
		public function menuQuery() {
		$token = get_weixin_token();
		$url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$token}";
		$content = http_get($url);

 $types = array(
		'view', 'click', 'scancode_push',
		'scancode_waitmsg', 'pic_sysphoto', 'pic_photo_or_album',
		'pic_weixin', 'location_select'
	);
		$dat=$content;
		$result = json_decode($dat, true);
		if(is_array($result) && !empty($result['menu'])) {
			$menus = array();
			foreach($result['menu']['button'] as $val) {
				$m = array();
				$m['type'] = in_array($val['type'], $types ) ? $val['type'] : 'url';
				$m['title'] = $val['name'];
				if($m['type'] != 'view') {
					$m['forward'] = $val['key'];
				} else {
					$m['type'] = 'url';
					$m['url'] = $val['url'];
				}
				$m['subMenus'] = array();
				if(!empty($val['sub_button'])) {
					foreach($val['sub_button'] as $v) {
						$s = array();
						$s['type'] = in_array($v['type'], $types ) ? $v['type'] : 'url';
						$s['title'] = $v['name'];
						if($s['type'] != 'view') {
							$s['forward'] = $v['key'];
						} else {
							$s['type'] = 'url';
							$s['url'] = $v['url'];
						}
						$m['subMenus'][] = $s;
					}
				}
				$menus[] = $m;
			}
			return $menus;
		} else {
			if(is_array($result)) {
				if($result['errcode'] == '46003') {
					return array();
				}
						
				get_weixin_token(true);
				message("微信公众平台返回接口错误. \n错误代码为: {$result['errcode']} \n错误信息为: {$result['errmsg']} \n错误描述为: " . $result['errcode']);
			} else {
				return array();
			}
		}
	
	

	}
	public function menuCreate($menu) {
		$dat = $this->menuBuildMenuSet($menu);
		$token = get_weixin_token();
		if(is_error($token)){
			return $token;
		}
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$token}";
		$content = http_post($url, $dat);
		return $this->menuResponseParse($content);
	}
	
	
	
	function menuBuildMenuSet($menu) {
		 $types = array(
		'view', 'click', 'scancode_push',
		'scancode_waitmsg', 'pic_sysphoto', 'pic_photo_or_album',
		'pic_weixin', 'location_select'
	);
		$set = array();
		$set['button'] = array();
		foreach($menu as $m) {
			$entry = array();
			$entry['name'] = urlencode($m['title']);
			if(!empty($m['subMenus'])) {
				$entry['sub_button'] = array();
				foreach($m['subMenus'] as $s) {
					$e = array();
					if ($s['type'] == 'url') {
						$e['type'] = 'view';
					} elseif (in_array($s['type'], $types)) {
						$e['type'] = $s['type'];
					} else {
						$e['type'] = 'click';
					}
						$e['name'] = urlencode($s['title']);
						if($e['type'] == 'view') {
							$e['url'] = urlencode($s['url']);
						} else {
							$e['key'] = urlencode($s['forward']);
					}
					$entry['sub_button'][] = $e;
				}
			} else {
				if ($m['type'] == 'url') {
					$entry['type'] = 'view';
				} elseif (in_array($m['type'], $types)) {
					$entry['type'] = $m['type'];
				} else {
					$entry['type'] = 'click';
				}
				if($entry['type'] == 'view') {
					$entry['url'] = urlencode($m['url']);
				} else {
					$entry['key'] = urlencode($m['forward']);
				}
			}
			$set['button'][] = $entry;
		}
		$dat = json_encode($set);
		$dat = urldecode($dat);
		return $dat;
	}
	
		public function menuDelete() {
		$token = get_weixin_token();
		$url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token={$token}";
		$content = http_get($url);
		return $this->menuResponseParse($content);
	}


		private function menuResponseParse($content) {
		if(empty($content)) {
			return message( "接口调用失败，请重试！公众平台返回错误信息: {$content}" );
		}
		$dat = $content;
		$result = @json_decode($dat, true);
		if(is_array($result) && $result['errcode'] == '0') {
			return true;
		} else {
			if(is_array($result)) {
				return  message("微信公众平台返回错误. 错误代码: {$result['errcode']} 错误信息: {$result['errmsg']} 错误描述: " . $this->error_code($result['errcode']));
			} else {
				return  message('微信公众平台未知错误');
			}
		}
	}
	
	
	private function error_code($code) {
		$errors = array(
			'-1' => '系统繁忙',
			'0' => '请求成功',
			'40001' => '获取access_token时AppSecret错误，或者access_token无效',
			'40002' => '不合法的凭证类型',
			'40003' => '不合法的OpenID',
			'40004' => '不合法的媒体文件类型',
			'40005' => '不合法的文件类型',
			'40006' => '不合法的文件大小',
			'40007' => '不合法的媒体文件id',
			'40008' => '不合法的消息类型',
			'40009' => '不合法的图片文件大小',
			'40010' => '不合法的语音文件大小',
			'40011' => '不合法的视频文件大小',
			'40012' => '不合法的缩略图文件大小',
			'40013' => '不合法的APPID',
			'40014' => '不合法的access_token',
			'40015' => '不合法的菜单类型',
			'40016' => '不合法的按钮个数',
			'40017' => '不合法的按钮个数',
			'40018' => '不合法的按钮名字长度',
			'40019' => '不合法的按钮KEY长度',
			'40020' => '不合法的按钮URL长度',
			'40021' => '不合法的菜单版本号',
			'40022' => '不合法的子菜单级数',
			'40023' => '不合法的子菜单按钮个数',
			'40024' => '不合法的子菜单按钮类型',
			'40025' => '不合法的子菜单按钮名字长度',
			'40026' => '不合法的子菜单按钮KEY长度',
			'40027' => '不合法的子菜单按钮URL长度',
			'40028' => '不合法的自定义菜单使用用户',
			'40029' => '不合法的oauth_code',
			'40030' => '不合法的refresh_token',
			'40031' => '不合法的openid列表',
			'40032' => '不合法的openid列表长度',
			'40033' => '不合法的请求字符，不能包含\uxxxx格式的字符',
			'40035' => '不合法的参数',
			'40038' => '不合法的请求格式',
			'40039' => '不合法的URL长度',
			'40050' => '不合法的分组id',
			'40051' => '分组名字不合法',
			'41001' => '缺少access_token参数',
			'41002' => '缺少appid参数',
			'41003' => '缺少refresh_token参数',
			'41004' => '缺少secret参数',
			'41005' => '缺少多媒体文件数据',
			'41006' => '缺少medSYSTEM_id参数',
			'41007' => '缺少子菜单数据',
			'41008' => '缺少oauth code',
			'41009' => '缺少openid',
			'42001' => 'access_token超时',
			'42002' => 'refresh_token超时',
			'42003' => 'oauth_code超时',
			'43001' => '需要GET请求',
			'43002' => '需要POST请求',
			'43003' => '需要HTTPS请求',
			'43004' => '需要接收者关注',
			'43005' => '需要好友关系',
			'44001' => '多媒体文件为空',
			'44002' => 'POST的数据包为空',
			'44003' => '图文消息内容为空',
			'44004' => '文本消息内容为空',
			'45001' => '多媒体文件大小超过限制',
			'45002' => '消息内容超过限制',
			'45003' => '标题字段超过限制',
			'45004' => '描述字段超过限制',
			'45005' => '链接字段超过限制',
			'45006' => '图片链接字段超过限制',
			'45007' => '语音播放时间超过限制',
			'45008' => '图文消息超过限制',
			'45009' => '接口调用超过限制',
			'45010' => '创建菜单个数超过限制',
			'45015' => '回复时间超过限制',
			'45016' => '系统分组，不允许修改',
			'45017' => '分组名字过长',
			'45018' => '分组数量超过上限',
			'46001' => '不存在媒体数据',
			'46002' => '不存在的菜单版本',
			'46003' => '不存在的菜单数据',
			'46004' => '不存在的用户',
			'47001' => '解析JSON/XML内容错误',
			'48001' => 'api功能未授权',
			'50001' => '用户未授权该api',
		);
		$code = strval($code);
	if($code == '40001') {
					$rec = array();
					$rec['access_token'] = '';
			$cfg = array('weixin_access_token'=>'');
		refreshSetting($rec,'weixin');
			
			return '微信公众平台授权异常, 系统已修复这个错误, 请刷新页面重试.';
		}
		if($errors[$code]) {
			return $errors[$code];
		} else {
			return '未知错误';
		}
	}
}