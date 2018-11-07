<?php
if (!defined("IN_IA")) {
    exit("Access Denied");
}
global $_W, $_GPC,$_CMS,$_GP;
$orderid=$_GPC['orderid'];
$openid=m("user")->getOpenid(true);
$uniacid=$_W["uniacid"];

 $order = pdo_fetch("select * from " . tablename("eshop_order") . " where id=:id and uniacid=:uniacid and openid=:openid limit 1", array(
        ":id" => $orderid,
        ":uniacid" => $uniacid,
        ":openid" => $openid
    ));
    if (empty($order)) {
        message("订单未找到!");
    }
    
        $log = pdo_fetch("SELECT * FROM " . tablename("core_paylog") . " WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1", array(
        ":uniacid" => $uniacid,
        ":module" => "eshop",
        ":tid" => $order["ordersn"]
    ));
    if (empty($log)) {
        message("支付出错,请重试!");
    }
    
if($_GPC['op']=='alipay')
{
	$pay_type='alipay';
	$pay_paytype=22;
	 	require(WEB_ROOT.'/system/modules/plugin/payment/alipay/payaction.php'); 
    	exit;
}
if($_GPC['op']=='credit')
{
			$pay_type='credit';
	$pay_paytype=1;
	 	require(WEB_ROOT.'/system/modules/plugin/payment/credit/payaction.php'); 
    	exit;
}

if($_GPC['op']=='wechat')
{
		$pay_type='wechat';
	$pay_paytype=21;
	 	require(WEB_ROOT.'/system/modules/plugin/payment/wechat/payaction.php'); 
    	exit;
}
if($_GPC['op']=='unionpay')
{
		$pay_type='wechat';
	$pay_paytype=23;
	 	require(WEB_ROOT.'/system/modules/plugin/payment/unionpay/payaction.php'); 
    	exit;
}
?>