<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}

global $_W, $_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$openid    = m('user')->getOpenid(true);
$uniacid   = $_W['uniacid'];
$set_trade=globalSetting('trade');
	  $member    = m('member')->getMember($openid);
	 if (empty($member["weixin"]) ) {
          message("请先完善您的微信号",create_url('mobile',array('act' => 'shopwap','do' => 'info')),'error');
    }
    $credit    = $member['credit2'];
    if(!empty($set_trade['withdrawmoney']))
    {
    	if(  $credit<$set_trade['withdrawmoney'])
    	{
    message('余额满' .$set_trade['withdrawmoney']. "元才能提现!" );	
  }
    }
if ($operation == 'display' && $_W['isajax']) {

  
    $returnurl = urlencode($this->createMobileUrl('member/withdraw'));
    $infourl   = $this->createMobileUrl('member/info', array(
        'returnurl' => $returnurl
    ));
    show_json(1, array(
        'credit' => $credit,
        'infourl' => $infourl,
        'noinfo' => empty($member['realname'])
    ));
} else if ($operation == 'submit' && $_W['ispost']) {
    $money  = floatval($_GPC['money']);
    if (empty($money)) {
        show_json(0, '申请金额为空!');
    }
    if ($money > $credit) {
        show_json(0, '提现金额过大!');
    }
 
     member_gold($openid,$money,'usegold','现金提现');
    $logno = m('common')->createNO('member_log', 'logno', 'RW');
    $log   = array(
        'uniacid' => $uniacid,
        'logno' => $logno,
        'openid' => $openid,
        'title' => '余额提现',
        'type' => 1,
        'createtime' => time(),
        'status' => 0,
        'money' => $money
    );
    pdo_insert('eshop_member_log', $log);
    $logid = pdo_insertid();
    m('notice')->sendMemberLogMessage($logid);
    show_json(1);
}
include $this->template('withdraw');