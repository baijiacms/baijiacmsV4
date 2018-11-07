<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$openid    = m('user')->getOpenid(true);
$uniacid   = $_W['uniacid'];
$orderid   = intval($_GPC['id']);
$order = pdo_fetch('select * from ' . tablename('eshop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(
            ':id' => $orderid,
            ':uniacid' => $uniacid,
            ':openid' => $openid
        ));
header("Location:http://m.kuaidi100.com/index_all.html?type=".$order['express']."&postid=".$order['expresssn']."#input");
        
        