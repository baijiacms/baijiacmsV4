<?php
if(strpos($_SERVER['HTTP_USER_AGENT'], 'DingTalk')== false)
					{
						
						message("钉钉浏览器才能访问");
					}

require_once(WEB_ROOT."/system/dingtalk/dingtalk_common.php");
$configs=globalSetting('dingtalk');
$usedingtalk=$dingtalk_settings['fastlogin_open'];
if(empty($usedingtalk))
{
message("未开启钉钉快捷登陆");	
}
$weburl=urlencode(	WEBSITE_ROOT.create_url('mobile',array('act' => 'dingtalk','do' => 'fastlogin')));

if(!empty($_GP['code']))
{
$persistent=dingtalk_getuserinfo($_GP['code']);	
$dingtalk_openid=$persistent['userid'];
if(!empty($dingtalk_openid))
{
$base_member = mysqld_select("SELECT openid FROM " . table('base_member') . " WHERE dingtalk_openid=:dingtalk_openid and beid=:beid ", array(':dingtalk_openid' =>$dingtalk_openid,":beid"=>$_CMS['beid']));

$eshop_member = mysqld_select("SELECT * FROM " . table('eshop_member') . " WHERE openid=:openid and uniacid=:uniacid ", array(':openid' =>$base_member['openid'],":uniacid"=>$_CMS['beid']));
if(empty($eshop_member['isagent'])||empty($eshop_member['status']))
{
	message("登录失败！您不是分销员或者状态不可用!",create_url('mobile',array('act' => 'shopwap','do' => 'logout')),"error"),
}
if(!empty($base_member['openid']))
				{
	
					save_member_login($base_member['openid']);
					message("登陆成功！",create_url('mobile',array('act' => 'shopwap','do' => 'membercenter')),'success');
				}else
				{
					$openid=register_from_dingtalk($dingtalk_openid);
					save_member_login($openid);
					message("登陆成功！",create_url('mobile',array('act' => 'shopwap','do' => 'membercenter')),'success');
				}
			}
message("登录错误");
}
//message($configs['fastlogin_agentID']);
message("登录错误");
exit;
					
				