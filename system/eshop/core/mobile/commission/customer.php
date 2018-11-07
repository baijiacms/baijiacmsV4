<?php
global $_W, $_GPC;
$openid = m('user')->getOpenid(true);
if(allow_commission()==false)
{
header("Location:".create_url('mobile',array('act' => 'shopwap','do' => 'membercenter'))	);
exit;
}

$set = globalSetting('commission');
if(empty($set['level']))
{
header("Location:".create_url('mobile',array('do'=>'shop','act'=>'index','m'=>'eshop')));
exit;
}
$member = m('commission')->getInfo($openid);
$condition = '';
$total = pdo_fetchcolumn('select count(id) from ' . tablename('eshop_member') . ' where agentid=:agentid and ((isagent=1 and status=0) or isagent=0) and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':agentid' => $member['id']));
if ($_W['isajax']) {
    $pindex = max(1, intval($_GPC['page']));
    $psize = 20;
    $list = array();
    $sql = 'select * from ' . tablename('eshop_member') . " where agentid={$member['id']} and ((isagent=1 and status=0) or isagent=0) and uniacid = " . $_W['uniacid'] . " {$condition}  ORDER BY id desc limit " . ($pindex - 1) * $psize . ',' . $psize;
    $list = pdo_fetchall($sql);
    foreach ($list as &$row) {
        $row['createtime'] = date('Y-m-d H:i', $row['createtime']);
        $ordercount = pdo_fetchcolumn('select count(id) from ' . tablename('eshop_order') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid']));
        $row['ordercount'] = number_format(intval($ordercount), 0);
        $moneycount = pdo_fetchcolumn('select sum(og.realprice) from ' . tablename('eshop_order_goods') . ' og ' . ' left join ' . tablename('eshop_order') . ' o on og.orderid=o.id where o.openid=:openid  and o.status>=1 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid']));
        $row['moneycount'] = number_format(floatval($moneycount), 2);
    }
    unset($row);
    show_json(1, array('list' => $list, 'pagesize' => $psize));
}
include $this->template('customer');