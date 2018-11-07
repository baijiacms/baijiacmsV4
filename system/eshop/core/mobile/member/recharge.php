<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$openid    = m('user')->getOpenid(true);

$uniacid   = $_W['uniacid'];


$p_sale = p('sale');
if ($operation == 'display' && $_W['isajax']) {

    $set_shop=globalSetting('shop');
    $set_pay=globalSetting('pay');
    $set_trade=globalSetting('trade');
    
    if (!empty($set_trade['closerecharge'])) {
        show_json(-1, '系统未开启账户充值!');
    }
    pdo_delete('eshop_member_log', array(
        'openid' => $openid,
        'status' => 0,
        'type' => 0,
        'uniacid' => $_W['uniacid']
    ));
    $logno = m('common')->createNO('member_log', 'logno', 'RC');
    $log   = array(
        'uniacid' => $_W['uniacid'],
        'logno' => $logno,
        'title' => $set_shop['name'] . "会员充值",
        'openid' => $openid,
        'type' => 0,
        'createtime' => time(),
        'status' => 0
    );
    pdo_insert('eshop_member_log', $log);
    $logid  = pdo_insertid();
    $credit = m('member')->getCredit($openid, 'credit2');
    
     $alipay = array(
        "success" => false
    );
      $unionpay = array(
        "success" => false
    );
     $wechat  = array(
        "success" => false
    );
    $payment_list = pdo_fetchall('SELECT * FROM ' . tablename('payment') . ' WHERE `beid` = :beid and enabled=1', array(':beid' => $_W['uniacid']));

    foreach ($payment_list as $item_py) {
    	
    	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')== false&&$item_py['code']=='alipay')
    	{
    	//			if(is_weixin()==false)
   
    		  $alipay = array(
        "success" => true
    );

    	}
    	if($item_py['code']=='unionpay')
    	{
    		    $unionpay = array(
        "success" => true
    );
    	}
    	 	if(((is_mobile()&&strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger'))||is_mobile()==false)&&$item_py['code']=='wechat')
    	{
    //		if(is_weixin())
    	
    		   $wechat  = array(
        "success" => true
    );
 
    	}
    	 
    }
    
    $acts = false;
    if ($p_sale) {
        $acts = $p_sale->getRechargeActivity();
    }
    show_json(1, array(
        'set' => $set,
        'logid' => $logid,
        'isweixin' => is_weixin(),
        'wechat' => $wechat,
        'unionpay' => $unionpay,
        'alipay' => $alipay,
        'credit' => $credit,
        'acts' => $acts
    ));
} else if ($operation == 'recharge' && $_W['ispost']) {
    $logid = intval($_GPC['logid']);
    if (empty($logid)) {
        show_json(0, '充值出错, 请重试!');
    }
    $money = floatval($_GPC['money']);
    if (empty($money)) {
        show_json(0, '请填写充值金额!');
    }
    $type = $_GPC['type'];
    if (!in_array($type, array(
        'wechat',
        'alipay',
        'unionpay'
    ))) {
        show_json(0, '未找到支付方式');
    }
    $log = pdo_fetch('SELECT * FROM ' . tablename('eshop_member_log') . ' WHERE `id`=:id and `uniacid`=:uniacid limit 1', array(
        ':uniacid' => $uniacid,
        ':id' => $logid
    ));
    if (empty($log)) {
        show_json(0, '充值出错, 请重试!');
    }
	
	/*修复支付问题*/
	if($log['money'] <= 0){
        pdo_update('eshop_member_log', array('money' => $money), array('id' => $log['id']));
    }
	  $set_shop=globalSetting('shop');
    $set_pay=globalSetting('pay');
     show_json(1,array('logid'=>$log['id']));
}
if ($operation == 'display') {
    include $this->template('recharge');
}