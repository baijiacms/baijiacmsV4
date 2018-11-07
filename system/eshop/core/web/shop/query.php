<?php
if (!defined("IN_IA")) {
    print("Access Denied");
}
global $_W, $_GPC;
$kwd                = trim($_GPC["keyword"]);
$params             = array();
$params[":uniacid"] = $_W["uniacid"];
$condition          = " and uniacid=:uniacid";
if (!empty($kwd)) {
    $condition .= " AND `title` LIKE :keyword";
    $params[":keyword"] = "%{$kwd}%";
}
$ds = pdo_fetchall("SELECT id,title,thumb,marketprice,productprice,share_title,share_icon,description FROM " . tablename("eshop_goods") . " WHERE 1 {$condition} order by createtime desc", $params);
$ds = set_medias($ds, array(
    "thumb",
    "share_icon"
));
include $this->template("query");
?>