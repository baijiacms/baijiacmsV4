<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
$openid = get_sysopenid(true);
$operation = empty($_GP["op"]) ? "display" : $_GP["op"];
$base_member = mysqld_select("SELECT * FROM ".table('base_member')." where openid=:openid and beid=:beid limit 1", array(':openid' => $openid,':beid'=>$_CMS['beid']));
if($operation=='unbinding_mobile')
{
	if(empty($base_member['weixin_openid'])&&empty($base_member['qq_openid']))
	{
	message("至少有一种以上绑定关系才能解绑");	
	}
	
			mysqld_update("base_member",array("mobile"=>""),array('openid' => $openid));
			message("手机号解绑成功！",create_url('mobile',array('act' => 'shopwap','do' => 'account')),'success');
}

if($operation=='unbinding_weixin')
{
	if(empty($base_member['mobile'])&&empty($base_member['qq_openid']))
	{
	message("至少有一种以上绑定关系才能解绑");	
	}
	
			mysqld_update("base_member",array("weixin_openid"=>""),array('openid' => $openid));
			message("微信号解绑成功！",create_url('mobile',array('act' => 'shopwap','do' => 'account')),'success');
}

if($operation=='unbinding_qq')
{
		if(empty($base_member['mobile'])&&empty($base_member['weixin_openid']))
	{
	message("至少有一种以上绑定关系才能解绑");	
	}
			mysqld_update("base_member",array("qq_openid"=>""),array('openid' => $openid));
						message("QQ号解绑成功！",create_url('mobile',array('act' => 'shopwap','do' => 'account')),'success');
}
if($operation=='binding_weixin')
{
		header("Location:".create_url('mobile',array('act' => 'weixin','do' => 'fastlogin','bizstate'=>'banding_weixin')));
	exit;
}
if($operation=='binding_qq')
{
	header("Location:".create_url('mobile',array('act' => 'qq','do' => 'fastlogin','bizstate'=>'banding_qq')));
	exit;
}
$qq_settings=globalSetting('qq');
include page('account');