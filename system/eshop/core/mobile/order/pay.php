<?php
if (!defined("IN_IA")) {
    exit("Access Denied");
}
global $_W, $_GPC;
$operation = !empty($_GPC["op"]) ? $_GPC["op"] : "display";
$openid    = m("user")->getOpenid(true);
if (empty($openid)) {
    $openid = $_GPC["openid"];
}
$member  = m("member")->getMember($openid);
$uniacid = $_W["uniacid"];
$orderid = intval($_GPC["orderid"]);
  if (!empty($orderid)) {
  	    $order = pdo_fetch("select * from " . tablename("eshop_order") . " where id=:id and uniacid=:uniacid and openid=:openid limit 1", array(
        ":id" => $orderid,
        ":uniacid" => $uniacid,
        ":openid" => $openid
    ));
    if (!empty($order)) {
    	$log = pdo_fetch("SELECT * FROM " . tablename("core_paylog") . " WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1", array(
        ":uniacid" => $uniacid,
        ":module" => "eshop",
        ":tid" => $order["ordersn"]
    ));
    $core_paylog=$log;
    }
  }
if ($operation == "display" && $_W["isajax"]) {
    if (empty($orderid)) {
        show_json(0, "参数错误!");
    }
    
    
    if (empty($order)) {
        show_json(0, "订单未找到!");
    }
    if ($order["status"] == -1) {
        show_json(-1, "订单已关闭, 无法付款!");
    } else if ($order["status"] >= 1) {
        show_json(-1, "订单已付款, 无需重复支付!");
    }
    
    if (!empty($log) && $log["status"] != '0') {
    	$returnvalue=order_checkorder($order["id"]);
      if($returnvalue)
      {
        show_json(-1, "订单已支付, 无需重复支付!");
      }
    }
   
    $plid = $log["plid"];
    if (empty($log)) {
        $log = array(
            "uniacid" => $uniacid,
            "openid" => $member["uid"],
            "module" => "eshop",
            "tid" => $order["ordersn"],
            "fee" => $order["price"],
            "status" => 0
        );
        pdo_insert("core_paylog", $log);
        $plid = pdo_insertid();
    }
    
    if (!empty($plid)&&!empty($order["id"])&&($order["price"]==0)&&empty($order["status"])) {
    
        pdo_update("core_paylog", array("status"=>1), array(
            "plid" => $plid
        ));
        
        $returnvalue=order_checkorder($order["id"]);
      if($returnvalue)
      {
        show_json(-1, "订单已支付成功!");
      }
        
    }
    
    
    $set_shop=globalSetting("shop");
     $set_pay=globalSetting("pay");
    $credit        = array(
        "success" => false
    );
    $currentcredit = 0;

     $alipay = array(
        "success" => false
    );

      $unionpay = array(
        "success" => false
    );
     $wechat  = array(
        "success" => false
    );
        $cash  = array(
        "success" => false
    );
			$payment_list = pdo_fetchall('SELECT * FROM ' . tablename('payment') . ' WHERE `beid` = :beid and enabled=1', array(':beid' => $_W['uniacid']));

    foreach ($payment_list as $item_py) {
    	
    	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')== false&&$item_py['code']=='alipay')
    	{
    	//			if(is_weixin()==false)
   
    		  $alipay = array(
        "success" => true
    );

    	}
    	if($item_py['code']=='credit')
    	{
    		   
            $credit = array(
                "success" => true,
                "current" => m("member")->getCredit($openid, "credit2")
            );
    	}
    	if($item_py['code']=='unionpay')
    	{
    		    $unionpay = array(
        "success" => true
    );
    	}
    	 	if(((is_mobile()&&strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger'))||is_mobile()==false)&&$item_py['code']=='wechat')
    	{
    //		if(is_weixin())
    	
    		   $wechat  = array(
        "success" => true
    );
 
    	}
    	 	if($item_py['code']=='cash')
    	{
    		 
    $cash      = array(
        "success" => $order["cash"] == 1 && true
    );
    	}
    }
    
 

    $returnurl = urlencode($this->createMobileUrl("order/pay", array(
        "orderid" => $orderid
    )));
    show_json(1, array(
        "order" => $order,
        "credit" => $credit,
        "wechat" => $wechat,
        "alipay" => $alipay,
        "unionpay" => $unionpay,
         "cash" => $cash,
        "isweixin" => is_weixin(),
        "currentcredit" => $currentcredit,
        "returnurl" => $returnurl
    ));
} else if ($operation == "pay" && $_W["ispost"]) {
   
    $order = pdo_fetch("select * from " . tablename("eshop_order") . " where id=:id and uniacid=:uniacid and openid=:openid limit 1", array(
        ":id" => $orderid,
        ":uniacid" => $uniacid,
        ":openid" => $openid
    ));
    if (empty($order)) {
        show_json(0, "订单未找到!");
    }
    $type = $_GPC["type"];
    if (!in_array($type, array(
        "wechat",
        "alipay",
        "unionpay",
        "cash",
        "credit"
    ))) {
        show_json(0, "未找到支付方式");
    }    
    $log = pdo_fetch("SELECT * FROM " . tablename("core_paylog") . " WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1", array(
        ":uniacid" => $uniacid,
        ":module" => "eshop",
        ":tid" => $order["ordersn"]
    ));
    if (empty($log)) {
        show_json(0, "支付出错,请重试!");
    }
    $order_goods = pdo_fetchall("select og.id,g.title, og.goodsid,og.optionid,g.total as stock,og.total as buycount,g.status,g.deleted,g.maxbuy,g.usermaxbuy,g.istime,g.timestart,g.timeend,g.buylevels,g.buygroups from  " . tablename("eshop_order_goods") . " og " . " left join " . tablename("eshop_goods") . " g on og.goodsid = g.id " . " where og.orderid=:orderid and og.uniacid=:uniacid ", array(
        ":uniacid" => $_W["uniacid"],
        ":orderid" => $orderid
    ));
    foreach ($order_goods as $data) {
        if (empty($data["status"]) || !empty($data["deleted"])) {
            show_json(-1, $data["title"] . "<br/> 已下架!");
        }
        if ($data["maxbuy"] > 0) {
            if ($data["buycount"] > $data["maxbuy"]) {
                show_json(-1, $data["title"] . "<br/> 一次限购 " . $data["maxbuy"] . $unit . "!");
            }
        }
        if ($data["usermaxbuy"] > 0) {
            $order_goodscount = pdo_fetchcolumn("select ifnull(sum(og.total),0)  from " . tablename("eshop_order_goods") . " og " . " left join " . tablename("eshop_order") . " o on og.orderid=o.id " . " where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ", array(
                ":goodsid" => $data["goodsid"],
                ":uniacid" => $uniacid,
                ":openid" => $openid
            ));
            if ($order_goodscount >= $data["usermaxbuy"]) {
                show_json(-1, $data["title"] . "<br/> 最多限购 " . $data["usermaxbuy"] . $unit . "!");
            }
        }
        if ($data["istime"] == 1) {
            if (time() < $data["timestart"]) {
                show_json(-1, $data["title"] . "<br/> 限购时间未到!");
            }
            if (time() > $data["timeend"]) {
                show_json(-1, $data["title"] . "<br/> 限购时间已过!");
            }
        }
        if ($data["buylevels"] != '') {
            $buylevels = explode(",", $data["buylevels"]);
            if (!in_array($member["level"], $buylevels)) {
                show_json(-1, "您的会员等级无法购买<br/>" . $data["title"] . "!");
            }
        }
        if ($data["buygroups"] != '') {
            $buygroups = explode(",", $data["buygroups"]);
            if (!in_array($member["groupid"], $buygroups)) {
                show_json(-1, "您所在会员组无法购买<br/>" . $data["title"] . "!");
            }
        }
        if (!empty($data["optionid"])) {
            $option = pdo_fetch("select id,title,marketprice,goodssn,productsn,stock,virtual from " . tablename("eshop_goods_option") . " where id=:id and goodsid=:goodsid and uniacid=:uniacid  limit 1", array(
                ":uniacid" => $uniacid,
                ":goodsid" => $data["goodsid"],
                ":id" => $data["optionid"]
            ));
            if (!empty($option)) {
                if ($option["stock"] != -1) {
                    if (empty($option["stock"])) {
                        show_json(-1, $data["title"] . "<br/>" . $option["title"] . " 库存不足!");
                    }
                }
            }
        } else {
            if ($data["stock"] != -1) {
                if (empty($data["stock"])) {
                    show_json(-1, $data["title"] . "<br/>库存不足!");
                }
            }
        }
    }
    $plid        = $log["plid"];
    $param_title = $set_shop["name"] . "订单";  
    if ($type == "wechat") {
      
        show_json(1);
    } else if ($type == "alipay") {
        show_json(1);
    }else if ($type == "credit") {
        show_json(1);
    }else if ($type == "unionpay") {
    	exit;
        pdo_update("eshop_order", array(
            "paytype" => 23
        ), array(
            "id" => $order["id"]
        ));
        show_json(1);
    }
    exit;
}
if ($operation == "display") {
	
	if($order['paytype']==21&&empty($order['status'])&&!empty($order['ordersn'])&&!empty($core_paylog['plid']))
{
	
    	 	$iswechat_success=isWeixinPayFinish($order['ordersn'].'-'.$core_paylog['plid'],'order');
					if($iswechat_success)
					{
      
			      $return_result=order_finish("wechat",21,$order["id"]);
			      if($return_result)
			      {
						header("Location:".create_url('mobile',array('do'=>'order','act'=>'detail','m'=>'eshop','id'=>$order["id"])));
			      }
					}
	}
	if($order['paytype']==22&&empty($order['status'])&&!empty($order['ordersn'])&&!empty($core_paylog['plid']))
{
	
    	 	$iswechat_success=isAliPayFinish($order['ordersn'].'-'.$core_paylog['plid'],'order');
					if($iswechat_success)
					{
      
			      $return_result=order_finish("alipay",22,$order["id"]);
			      if($return_result)
			      {
						header("Location:".create_url('mobile',array('do'=>'order','act'=>'detail','m'=>'eshop','id'=>$order["id"])));
			      }
					}
	}

	
    include $this->template("pay");
}
?>