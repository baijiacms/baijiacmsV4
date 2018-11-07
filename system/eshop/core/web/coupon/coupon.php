
<?php
if (!defined("IN_IA")) {
    print ("Access Denied");
}
global $_W, $_GPC;

$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
$type = 0;
if ($operation == "display") {
    if (checksubmit('submit',true)&&!empty($_GPC["displayorder"])) {
        foreach ($_GPC["displayorder"] as $id => $displayorder) {
            pdo_update("eshop_coupon", array(
                "displayorder" => $displayorder
            ) , array(
                "id" => $id
            ));
        }
        message("分类排序更新成功！", refresh() , "success");
    }
    $pindex = max(1, intval($_GPC["page"]));
    $psize = 20;
    $condition = " uniacid = :uniacid";
    $params = array(
        ":uniacid" => $_W["uniacid"]
    );
    if (!empty($_GPC["keyword"])) {
        $_GPC["keyword"] = trim($_GPC["keyword"]);
        $condition.= " AND couponname LIKE :couponname";
        $params[":couponname"] = "%" . trim($_GPC["keyword"]) . "%";
    }
    if (empty($starttime) || empty($endtime)) {
        $starttime = strtotime("-1 month");
        $endtime = time();
    }
    if (!empty($_GPC["searchtime"])) {
        $starttime = strtotime($_GPC["time"]["start"]);
        $endtime = strtotime($_GPC["time"]["end"]);
        if ($_GPC["searchtime"] == "1") {
            $condition.= " AND createtime >= :starttime AND createtime <= :endtime ";
            $params[":starttime"] = $starttime;
            $params[":endtime"] = $endtime;
        }
    }
    $sql = "SELECT * FROM " . tablename("eshop_coupon") . " " . " where  1 and {$condition} ORDER BY displayorder DESC,id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize;
    $list = pdo_fetchall($sql, $params);
    foreach ($list as & $row) {
        $row["gettotal"] = pdo_fetchcolumn("select count(*) from " . tablename("eshop_coupon_data") . " where couponid=:couponid and uniacid=:uniacid limit 1", array(
            ":couponid" => $row["id"],
            ":uniacid" => $_W["uniacid"]
        ));
        $row["usetotal"] = pdo_fetchcolumn("select count(*) from " . tablename("eshop_coupon_data") . " where used = 1 and couponid=:couponid and uniacid=:uniacid limit 1", array(
            ":couponid" => $row["id"],
            ":uniacid" => $_W["uniacid"]
        ));

    }
    unset($row);
    $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename("eshop_coupon") . " where 1 and {$condition}", $params);
    $pager = pagination($total, $pindex, $psize);
} elseif ($operation == "post") {
	
    $id = intval($_GPC["id"]);
   
	
    if (checksubmit("submit")) {
		
        $data = array(
            "uniacid" => $_W["uniacid"],
            "couponname" => trim($_GPC["couponname"]) ,
            "coupontype" => intval($_GPC["coupontype"]) ,
            "catid" => intval($_GPC["catid"]) ,
            "timelimit" => intval($_GPC["timelimit"]) ,
            "usetype" => intval($_GPC["usetype"]) ,
            "returntype" => intval($_GPC["returntype"]) ,
            "enough" => trim($_GPC["enough"]) ,
            "timedays" => intval($_GPC["timedays"]) ,
            "timestart" => strtotime($_GPC["time"]["start"]) ,
            "timeend" => strtotime($_GPC["time"]["end"]) ,
            "backtype" => intval($_GPC["backtype"]) ,
            "deduct" => trim($_GPC["deduct"]) ,
            "discount" => trim($_GPC["discount"]) ,
            "backmoney" => trim($_GPC["backmoney"]) ,
            "backcredit" => trim($_GPC["backcredit"]) ,
            "backredpack" => 0 ,
            "backwhen" => intval($_GPC["backwhen"]) ,
            "gettype" => intval($_GPC["gettype"]) ,
            "getmax" => intval($_GPC["getmax"]) ,
            "credit" => intval($_GPC["credit"]) ,
            "money" => trim($_GPC["money"]) ,
            "usecredit2" => intval($_GPC["usecredit2"]) ,
            "total" => intval($_GPC["total"]) ,
            "bgcolor" => trim($_GPC["bgcolor"]) ,
            "thumb" => save_media($_GPC["thumb"]) ,
            "remark" => trim($_GPC["remark"]) ,
            "status" => intval($_GPC["status"]) 
        );

        if (!empty($id)) {
          
            pdo_update("eshop_coupon", $data, array(
                "id" => $id,
                "uniacid" => $_W["uniacid"]
            ));
         } else {
        
            $data["createtime"] = time();
            pdo_insert("eshop_coupon", $data);
            $id = pdo_insertid();
        }
        $key = "eshop:coupon:" . $id;
        $rule = pdo_fetch("select * from " . tablename("rule") . " where uniacid=:uniacid and module=:module and name=:name  limit 1", array(
            ":uniacid" => $_W["uniacid"],
            ":module" => "eshop",
            ":name" => $key
        ));
       
        message("更新优惠券成功！", $this->createWebUrl("coupon/coupon") , "success");
    }
	
    $item = pdo_fetch("SELECT * FROM " . tablename("eshop_coupon") . " WHERE id =:id and uniacid=:uniacid limit 1", array(
        ":uniacid" => $_W["uniacid"],
        ":id" => $id
    ));
	
    if (empty($item)) {
        $starttime = time();
        $endtime = strtotime(date("Y-m-d H:i:s", $starttime) . "+7 days");
    } else {
        $type = $item["coupontype"];
        $starttime = $item["timestart"];
        $endtime = $item["timeend"];
    }
	
} elseif ($operation == "delete") {
    $id = intval($_GPC["id"]);
    $item = pdo_fetch("SELECT id,couponname FROM " . tablename("eshop_coupon") . " WHERE id =:id and uniacid=:uniacid limit 1", array(
        ":id" => $id,
        ":uniacid" => $_W["uniacid"]
    ));
    if (empty($item)) {
        message("抱歉，优惠券不存在或是已经被删除！", $this->createWebUrl("coupon/coupon", array(
            "op" => "display"
        )) , "error");
    }
    pdo_delete("eshop_coupon", array(
        "id" => $id,
        "uniacid" => $_W["uniacid"]
    ));
    $couponids = pdo_fetchall("select id from " . tablename("eshop_coupon") . " where uniacid=:uniacid", array(
        ":uniacid" => $_W["uniacid"]
    ) , "id");
    if (!empty($couponids)) {
        pdo_query("delete from " . tablename("eshop_coupon_data") . " where couponid not in (" . implode(",", array_keys($couponids)) . ") and uniacid=:uniacid", array(
            ":uniacid" => $_W["uniacid"]
        ));
    }
    pdo_delete("eshop_coupon_data", array(
        "couponid" => $id,
        "uniacid" => $_W["uniacid"]
    ));
    message("优惠券删除成功！", $this->createWebUrl("coupon/coupon", array(
        "op" => "display"
    )) , "success");
} else if ($operation == "query") {
    $kwd = trim($_GPC["keyword"]);
    $params = array();
    $params[":uniacid"] = $_W["uniacid"];
    $condition = " and uniacid=:uniacid";
    if (!empty($kwd)) {
        $condition.= " AND couponname like :couponname";
        $params[":couponname"] = "%{$kwd}%";
    }
    $time = time();
    $ds = pdo_fetchall("SELECT * FROM " . tablename("eshop_coupon") . "  WHERE 1 {$condition} ORDER BY id asc", $params);
    foreach ($ds as & $d) {
        $d = m('coupon')->setCoupon($d, $time, false);
        $d["last"] = m('coupon')->get_last_count($d["id"]);
        if ($d["last"] == - 1) {
            $d["last"] = "不限";
        }
    }
    unset($d);
    include $this->template("coupon/query");
    exit;
}


include $this->template("coupon"); ?>