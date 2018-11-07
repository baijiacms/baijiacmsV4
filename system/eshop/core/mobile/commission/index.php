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
$member                     = m('commission')->getInfo($openid, array(
        "total",
        "ordercount0",
        "ok"
    ));
if (empty($set["become_reg"])) {

    if (empty($member["realname"]) || empty($member["mobile"])) {
          message("请先完善用户资料",create_url('mobile',array('act' => 'shopwap','do' => 'info')),'error');
    }
}

    $cansettle                  = $member["commission_ok"] >= 1 && $member["commission_ok"] >= floatval($set["withdraw"]);
    $commission_ok              = $member["commission_ok"];
    $member["agentcount"]       = number_format($member["agentcount"], 0);
    $member["ordercount0"]      = number_format($member["ordercount0"], 0);
    $member["commission_ok"]    = number_format($member["commission_ok"], 2);
    $member["commission_pay"]   = number_format($member["commission_pay"], 2);
    $member["commission_total"] = number_format($member["commission_total"], 2);
    $member["customercount"]    = pdo_fetchcolumn("select count(id) from " . tablename("eshop_member") . " where agentid=:agentid and ((isagent=1 and status=0) or isagent=0) and uniacid=:uniacid limit 1", array(
        ":uniacid" => $_W["uniacid"],
        ":agentid" => $member["id"]
    ));
    if (mb_strlen($member["nickname"], "utf-8") > 6) {
        $member["nickname"] = mb_substr($member["nickname"], 0, 6, "utf-8");
    }

    $level                   = m('commission')->getLevel($openid);

$settlemoney=number_format(floatval($set["withdraw"]), 2);
include $this->template("index");
?> 