<?php

if (!defined('IN_IA')) {
    die('Access Denied');
}
global $_W, $_GPC;

$op = $operation = $_GPC['op'] ? $_GPC['op'] : 'display';
$id = intval($_GPC['id']);
$profile = m('member')->getInfo($id);
if ($op == 'credit1') {
    if ($_W['ispost']) {
    	 member_credit($profile['openid'],$_GPC['num'],'addcredit', "后台积分充值");
          
    	
        message('充值成功!', referer(), 'success');
    }
    $profile['credit1'] = m('member')->getCredit($profile['openid'], 'credit1');
} elseif ($op == 'credit2') {
    if ($_W['ispost']) {
    	member_gold($profile['openid'],$_GPC['num'],'addgold', '后台现金充值');
           
    	
        $set = globalSetting('shop');
        $data = array('openid' => $profile['openid'], 'uniacid' => $_W['uniacid'], 'type' => '0', 'createtime' => TIMESTAMP, 'status' => '1', 'title' => $set['name'] . '会员充值', 'money' => $_GPC['num'], 'rechargetype' => 'system');
        pdo_insert('eshop_member_log', $data);
        $logid = pdo_insertid();
        m('member')->setRechargeCredit($openid, $log['money']);
        m('notice')->sendMemberLogMessage($logid);
        message('充值成功!', referer(), 'success');
    }
    $profile['credit2'] = m('member')->getCredit($profile['openid'], 'credit2');
}

include $this->template('recharge');