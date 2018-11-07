<?php
if (!defined("IN_IA")) {
    print("Access Denied");
}
global $_W, $_GPC;
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
$openid    = m("user")->getOpenid(true);
$uniacid   = $_W["uniacid"];
$orderid   = intval($_GPC["id"]);
$saler     = pdo_fetch("select * from " . tablename("eshop_saler") . " where openid=:openid and uniacid=:uniacid limit 1", array(
    ":uniacid" => $_W["uniacid"],
    ":openid" => $openid
));
if (empty($saler)) {
    show_json(0, "您无核销权限!");
}
$order = pdo_fetch("select * from " . tablename("eshop_order") . " where id=:id and uniacid=:uniacid  limit 1", array(
    ":id" => $orderid,
    ":uniacid" => $uniacid
));
if (empty($order)||empty($order['price'])) {
    show_json(0, "订单不存在!");
}
if ($order["status"] < 1) {
    show_json(0, "订单未付款，无法核销!");
}
if (empty($order["isverify"])) {
    show_json(0, "订单无需核销!");
}
if (!empty($order["verified"])) {
    show_json(0, "订单此已核销，无需要重复核!");
}
$storeids = array();
$goods    = pdo_fetchall("select og.goodsid,og.price,g.title,g.thumb,og.total,g.credit,og.optionid,g.isverify,g.storeids from " . tablename("eshop_order_goods") . " og " . " left join " . tablename("eshop_goods") . " g on g.id=og.goodsid " . " where og.orderid=:orderid and og.uniacid=:uniacid ", array(
    ":uniacid" => $uniacid,
    ":orderid" => $orderid
));
foreach ($goods as $g) {
    if (!empty($g["storeids"])) {
        $storeids = array_merge(explode(",", $g["storeids"]), $storeids);
    }
}
if (!empty($storeids)) {
    if (!empty($saler["storeid"])) {
        if (!in_array($saler["storeid"], $storeids)) {
            show_json(0, "您无此门店的核销权限!");
        }
    }
}
$time = time();
pdo_update("eshop_order", array(
    "status" => 3,
    "sendtime" => $time,
    "finishtime" => $time,
    "verifytime" => $time,
    "verified" => 1,
    "verifyopenid" => $openid,
    "verifystoreid" => $saler["storeid"]
), array(
    "id" => $order["id"]
));
m("notice")->sendOrderMessage($orderid);
if (p("commission")) {
    p("commission")->checkOrderFinish($orderid);
}
show_json(1);
?>