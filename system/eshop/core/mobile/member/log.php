<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$openid    = m('user')->getOpenid(true);
$uniacid   = $_W['uniacid'];
$trade=globalSetting('trade');

if ($_W['isajax']) {
    if ($operation == 'display') {
        $pindex    = max(1, intval($_GPC['page']));
        $psize     = 10;
        $condition = " and openid=:openid and uniacid=:uniacid and type=:type";
        $params    = array(
            ':uniacid' => $uniacid,
            ':openid' => $openid,
            ':type' => intval($_GPC['type'])
        );
        $list      = pdo_fetchall("select * from " . tablename('eshop_member_log') . " where 1 {$condition} order by createtime desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
        $total     = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_member_log') . " where 1 {$condition}", $params);
        foreach ($list as &$row) {
            $row['createtime'] = date('Y-m-d H:i', $row['createtime']);
        }
        unset($row);
        show_json(1, array(
            'total' => $total,
            'list' => $list,
            'pagesize' => $psize
        ));
    }
}
include $this->template('log');