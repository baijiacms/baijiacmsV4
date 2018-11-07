<?php
global $_W, $_GPC;

$set = globalSetting('sale');
if (checksubmit("submit")) {
    $data                    = is_array($_GPC["data"]) ? $_GPC["data"] : array();
    $set=array();
    $set["creditdeduct"]     = intval($data["creditdeduct"]);
    $set["credit"]           = 1;
    $set["money"]            = round(floatval($data["money"]), 2);
    refreshSetting($set,'sale');
    message("抵扣设置成功!", referer(), "success");
}

include $this->template("deduct");
?>