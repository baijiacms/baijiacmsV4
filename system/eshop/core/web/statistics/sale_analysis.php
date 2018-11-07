<?php
  if (!defined("IN_IA")) { 
  print("Access Denied"); 
  } 
global $_W, $_GPC;
function sale_analysis_count($sql)
{
    $c = pdo_fetchcolumn($sql);
    return intval($c);
}
$member_count    = sale_analysis_count("SELECT count(*) FROM " . tablename('eshop_member') . "   WHERE uniacid = '{$_W['uniacid']}' ");
$orderprice      = sale_analysis_count("SELECT sum(price) FROM " . tablename('eshop_order') . " WHERE status>=1 and uniacid = '{$_W['uniacid']}' ");
$ordercount      = sale_analysis_count("SELECT count(*) FROM " . tablename('eshop_order') . " WHERE status>=1 and uniacid = '{$_W['uniacid']}' ");
$viewcount       = sale_analysis_count("SELECT sum(viewcount) FROM " . tablename('eshop_goods') . " WHERE uniacid = '{$_W['uniacid']}' ");
    $member_buycount = sale_analysis_count("select count(*) from ".tablename("eshop_member")." where uniacid={$_W["uniacid"]} and  openid in ( SELECT distinct openid from " . tablename("eshop_order") . "   WHERE uniacid = '{$_W["uniacid"]}' and status>=1 )"); 
include $this->template('sale_analysis');