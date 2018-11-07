<?php
global $_W, $_GPC;
$openid = m("user")->getOpenid(true);
$catid  = trim($_GPC["catid"]);
$set_coupon=globalSetting('coupon');
if (!empty($set_coupon['closecenter'])) {
	header('location: ' . create_url('mobile',array('act' => 'shopwap','do' => 'membercenter')));
	exit;
}
if ($_W["isajax"]) {
    $pindex = max(1, intval($_GPC["page"]));
    $psize  = 10;
    $time   = time();
    $sql    = "select id,timelimit,timedays,timestart,timeend,thumb,couponname,enough,backtype,deduct,discount,backmoney,backcredit,bgcolor,thumb,credit,money,getmax from " . tablename("eshop_coupon") . " c ";
    $sql .= " where uniacid=:uniacid and gettype=1 and (total=-1 or total>0) and ( timelimit = 0 or  (timelimit=1 and timeend>unix_timestamp()))";
    if (!empty($catid)) {
        $sql .= " and catid=" . $catid;
    }
    $sql .= " order by displayorder desc, id desc  LIMIT " . ($pindex - 1) * $psize . "," . $psize;
    $coupons = set_medias(pdo_fetchall($sql, array(
        ":uniacid" => $_W["uniacid"]
    )), "thumb");
    foreach ($coupons as &$row) {
        $row = m('coupon')->setCoupon($row, $time);
    }
    unset($row);
    show_json(1, array(
        "list" => $coupons,
        "pagesize" => $psize
    ));
}

$shop     = globalSetting("shop");

include $this->template("center");
?>