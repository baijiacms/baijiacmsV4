<?php
message("禁止访问");
exit;
if(allow_commission()==false)
{
header("Location:".create_url('mobile',array('act' => 'shopwap','do' => 'membercenter'))	);
exit;
}

global $_W, $_GPC;
$openid   = m("user")->getOpenid(true);
$shop_set = globalSetting("shop");
$set_commission = globalSetting('commission');
$set = $set_commission;
if(empty($set['level']))
{
header("Location:".create_url('mobile',array('do'=>'shop','act'=>'index','m'=>'eshop')));
exit;
}
$member   = m("member")->getMember($openid);
if ($member["isagent"] == 1 && $member["status"] == 1) {
    header("location: " . $this->createMobileUrl("commission"));
    exit;
}
if (empty($set_commission["become"])) {
}
$template_flag  = 0;

$mid = $openid;
if ($_W["isajax"]) {
    $agent = false;
    if (!empty($member["fixagentid"])) {
        $mid = $member["agentid"];
        if (!empty($mid)) {
            $agent = m("member")->getMember($member["agentid"]);
        }
    } else {
        if (!empty($member["agentid"])) {
            $mid   = $member["agentid"];
            $agent = m("member")->getMember($member["agentid"]);
        } else if (!empty($member["inviter"])) {
            $mid   = $member["inviter"];
            $agent = m("member")->getMember($member["inviter"]);
        } else if (!empty($mid)) {
            $agent = m("member")->getMember($mid);
        }
    }
    $ret           = array(
        "shop_set" => $shop_set,
        "set" => $set_commission,
        "member" => $member,
        "agent" => $agent
    );
    $ret["status"] = 0;
    $status        = intval($set_commission["become_order"]) == 0 ? 1 : 3;
    if (empty($set_commission["become"])) {
        $become_reg = intval($set_commission["become_reg"]);
        if (empty($become_reg)) {
            $become_check  = intval($set_commission["become_check"]);
            $ret["status"] = $become_check;
            $data          = array(
                "isagent" => 1,
                "agentid" => $mid,
                "status" => $become_check,
                "realname" => $_GPC["realname"],
                "weixin" => $_GPC["weixin"],
                "agenttime" => $become_check == 1 ? time() : 0
            );
            $is_update_member_mobile=update_member_mobile($member["openid"],$_GPC["mobile"]);
        if( $is_update_member_mobile==-1)
            {
                  show_json(0, $_GPC["mobile"]."手机号已被其他用户注册。");
                   exit;
           }
            pdo_update("eshop_member", $data, array(
                "id" => $member["id"]
            ));
            
            if ($become_check == 1) {
                m('commission')->sendMessage($member["openid"], array(
                    "agenttime" => $data["agenttime"]
                ), TM_COMMISSION_BECOME);
                m('commission')->upgradeLevelByAgent($member["id"]);
            }
        
        }
    } else if ($set_commission["become"] == "2") {
        $ordercount = pdo_fetchcolumn("select count(*) from " . tablename("eshop_order") . " where uniacid=:uniacid and openid=:openid and status>={$status} limit 1", array(
            ":uniacid" => $_W["uniacid"],
            ":openid" => $openid
        ));
        if ($ordercount < intval($set_commission["become_ordercount"])) {
            $ret["status"]     = 1;
            $ret["order"]      = number_format($ordercount, 0);
            $ret["ordercount"] = number_format($set_commission["become_ordercount"], 0);
        }
    } else if ($set_commission["become"] == "3") {
        $moneycount = pdo_fetchcolumn("select sum(goodsprice) from " . tablename("eshop_order") . " where uniacid=:uniacid and openid=:openid and status>={$status} limit 1", array(
            ":uniacid" => $_W["uniacid"],
            ":openid" => $openid
        ));
        if ($moneycount < floatval($set_commission["become_moneycount"])) {
            $ret["status"]     = 2;
            $ret["money"]      = number_format($moneycount, 2);
            $ret["moneycount"] = number_format($set_commission["become_moneycount"], 2);
        }
    } else if ($set_commission["become"] == 4) {
        $goods      = pdo_fetch("select id,title from" . tablename("eshop_goods") . " where id=:id and uniacid=:uniacid limit 1", array(
            ":id" => $set_commission["become_goodsid"],
            ":uniacid" => $_W["uniacid"]
        ));
        $goodscount = pdo_fetchcolumn("select count(*) from " . tablename("eshop_order_goods") . " og " . "  left join " . tablename("eshop_order") . " o on o.id = og.orderid" . " where og.goodsid=:goodsid and o.openid=:openid and o.status>=1  limit 1", array(
            ":goodsid" => $set_commission["become_goodsid"],
            ":openid" => $openid
        ));
        if ($goodscount <= 0) {
            $ret["status"] = 3;
            $ret["buyurl"] = $this->createMobileUrl("shop/detail", array(
                "id" => $goods["id"]
            ));
            $ret["goods"]  = $goods;
        } else {
            $ret["status"]    = 4;
            $data             = array(
                "isagent" => 1,
                "agentid" => $mid,
                "status" => 1,
                "agenttime" => time()
            );
            $member["status"] = 1;
            $ret["member"]    = $member;
            pdo_update("eshop_member", $data, array(
                "id" => $member["id"]
            ));
            m('commission')->sendMessage($member["openid"], array(
                "agenttime" => $data["agenttime"]
            ), TM_COMMISSION_BECOME);
            m('commission')->upgradeLevelByAgent($member["id"]);
        }
    }
    if ($_W["ispost"]) {
        if ($member["isagent"] == 1 && $member["status"] == 1) {
            show_json(0, "您已经是成为合伙人，无需再次申请!");
        }
        if ($ret["status"] == 1 || $ret["status"] == 2) {
            show_json(0, "您消费的还不够哦，无法申请合伙人!");
        } else {
            $become_check  = intval($set_commission["become_check"]);
            $ret["status"] = $become_check;
          
                $data = array(
                    "isagent" => 1,
                    "agentid" => $mid,
                    "status" => $become_check,
                    "realname" => $_GPC["realname"],
                    "weixin" => $_GPC["weixin"],
                    "agenttime" => $become_check == 1 ? time() : 0
                );
             $is_update_member_mobile=   update_member_mobile($member["openid"],$_GPC["mobile"]);
                    if( $is_update_member_mobile==-1)
            {
                  show_json(0, $_GPC["mobile"]."手机号已被其他用户注册。");
                   exit;
           }
                pdo_update("eshop_member", $data, array(
                    "id" => $member["id"]
                ));
           		 
                if ($become_check == 1) {
                    m('commission')->sendMessage($member["openid"], array(
                        "agenttime" => $data["agenttime"]
                    ), TM_COMMISSION_BECOME);
                    if (!empty($mid)) {
                        m('commission')->upgradeLevelByAgent($mid);
                    }
                }
             
           
        }
    }
    show_json(1, $ret);
}

    include $this->template("register");
?>