<?php
global $_W, $_GPC;
$openid = m("user")->getOpenid(true);
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
if ($_W["isajax"]) {
    $member                     = m('commission')->getInfo($openid, array(
        "total",
        "ok",
        "apply",
        "check",
        "lock",
        "pay"
    ));
    $cansettle                  = $member["commission_ok"] >= 1 && $member["commission_ok"] >= floatval($set["withdraw"]);
    $member["commission_ok"]    = number_format($member["commission_ok"], 2);
    $member["commission_total"] = number_format($member["commission_total"], 2);
    $member["commission_check"] = number_format($member["commission_check"], 2);
    $member["commission_apply"] = number_format($member["commission_apply"], 2);
    $member["commission_lock"]  = number_format($member["commission_lock"], 2);
    $member["commission_pay"]   = number_format($member["commission_pay"], 2);
    show_json(1, array(
        "cansettle" => $cansettle,
        "settlemoney" => number_format(floatval($set["withdraw"]), 2),
        "member" => $member,
        "set" => $set
    ));
}
include $this->template("withdraw");
?>