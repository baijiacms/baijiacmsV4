<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
$kwd      = trim($_GPC['keyword']);
$wechatid = intval($_GPC['wechatid']);
if (empty($wechatid)) {
    $wechatid = $_W['uniacid'];
}
$params             = array();
$params[':uniacid'] = $wechatid;
$condition          = " and uniacid=:uniacid";
if (!empty($kwd)) {
    $condition .= " AND ( `nickname` LIKE :keyword or `realname` LIKE :keyword or `mobile` LIKE :keyword  or `openid`=:ropenid)";
    $params[':keyword'] = "%{$kwd}%";
    $params[':ropenid'] = "{$kwd}";
}
$ds = pdo_fetchall('SELECT id,avatar,nickname,openid,realname,mobile FROM ' . tablename('eshop_member') . " WHERE 1 {$condition} order by createtime desc", $params);
include $this->template('query');