<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
/* 积分排行 */
global $_W, $_GPC;


$limitsum = 10; //显示多少个排行

$sql = "SELECT openid,avatar,nickname,credit1 FROM " . tablename('eshop_member')." WHERE uniacid = :uniacid and credit1>0 ORDER BY credit1 DESC,createtime LIMIT {$limitsum}";

$params = array(':uniacid' => $_W['uniacid']);
$list = pdo_fetchall($sql, $params);


include $this->template('phb');