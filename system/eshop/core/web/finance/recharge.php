<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;

$op      = $operation = $_GPC['op'] ? $_GPC['op'] : 'display';
$id      = intval($_GPC['id']);
$profile = m('member')->getMember($id);
if ($op == 'credit1') {
	if ($_W['ispost']) {
		if(empty($_GPC['credittype']))
		{
         member_credit($profile['openid'],$_GPC['num'],'addcredit','后台会员充值积分');
		}else
		{
			 member_credit($profile['openid'],$_GPC['num'],'usecredit','后台会员消费积分');
		}
		message('充值成功!', referer(), 'success');
	}
	$profile['credit1'] = m('member')->getCredit($profile['openid'], 'credit1');
} elseif ($op == 'credit2') {
	if ($_W['ispost']) {
		if(empty($_GPC['goldtype']))
		{
		   member_gold($profile['openid'],$_GPC['num'],'addgold','后台会员充值余额');
		}else
		{
			 member_gold($profile['openid'],$_GPC['num'],'usegold','后台会员消费余额');
		}
		$set = globalSetting('shop');
		$logno = m('common')->createNO('member_log', 'logno', 'RC');
		$data = array('openid' => $profile['openid'], 'logno' => $logno, 'uniacid' => $_W['uniacid'], 'type' => '0', 'createtime' => TIMESTAMP, 'status' => '1', 'title' => $set['name'] . '会员充值', 'money' => $_GPC['num'], 'rechargetype' => 'system',);
		pdo_insert('eshop_member_log', $data);
		$logid = pdo_insertid();
	if(empty($_GPC['goldtype']))
		{
		if (floatval($_GPC['num']) > 0) {
			m('notice')->sendMemberLogMessage($logid);
		}
	}
		message('充值成功!', referer(), 'success');
	}
	$profile['credit2'] = m('member')->getCredit($profile['openid'], 'credit2');
}
include $this->template('recharge');