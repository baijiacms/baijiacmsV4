<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
$days = 7;
$datas     = array();


 $commission_set = globalSetting("commission");
$timefield = 'createtime';
 $charttitle = "最近{$days}天增长趋势图";
    for ($i = $days; $i >= 0; $i--) {
        $time      = date("Y-m-d", strtotime("-" . $i . " day"));
        $condition = " and uniacid=:uniacid and {$timefield}>=:starttime and {$timefield}<=:endtime";
        $params    = array(
            ':uniacid' => $_W['uniacid'],
            ':starttime' => strtotime("{$time} 00:00:00"),
            ':endtime' => strtotime("{$time} 23:59:59")
        );
        $datas[]   = array(
            'date' => $time,
            'mcount' => pdo_fetchcolumn("select count(openid) from " . tablename('eshop_member') . " where 1=1 {$condition}", $params),
        );
    }
     $before7day_time=strtotime(date("Y-m-d", strtotime("-7 day"))." 00:00:00");
       $paras =  array(
        ":uniacid" => $_W["uniacid"]
    );
        $condition = " o.uniacid = :uniacid and o.deleted=0";
     $order_status0= pdo_fetchcolumn("SELECT COUNT(o.id) FROM " . tablename("eshop_order") . " o " . " left join ( select rr.id,rr.orderid,rr.status from " . tablename("eshop_order_refund") . " rr left join " . tablename("eshop_order") . " ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id" . " left join " . tablename("eshop_member") . " m on m.openid=o.openid  and m.uniacid =  o.uniacid" . " left join " . tablename("eshop_member_address") . " a on o.addressid = a.id " . " left join " . tablename("eshop_member") . " sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid" . " left join " . tablename("eshop_saler") . " s on s.openid = o.verifyopenid and s.uniacid=o.uniacid" . " WHERE $condition and o.status=0 and o.paytype<>3", $paras);
   $order_status1= pdo_fetchcolumn("SELECT COUNT(o.id) FROM " . tablename("eshop_order") . " o " . " left join ( select rr.id,rr.orderid,rr.status from " . tablename("eshop_order_refund") . " rr left join " . tablename("eshop_order") . " ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id" . " left join " . tablename("eshop_member") . " m on m.openid=o.openid  and m.uniacid =  o.uniacid" . " left join " . tablename("eshop_member_address") . " a on o.addressid = a.id " . " left join " . tablename("eshop_member") . " sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid" . " left join " . tablename("eshop_saler") . " s on s.openid = o.verifyopenid and s.uniacid=o.uniacid" . " WHERE $condition and ( o.status=1 or ( o.status=0 and o.paytype=3) )", $paras);
  $order_status2= pdo_fetchcolumn("SELECT COUNT(o.id) FROM " . tablename("eshop_order") . " o " . " left join ( select rr.id,rr.orderid,rr.status from " . tablename("eshop_order_refund") . " rr left join " . tablename("eshop_order") . " ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id" . " left join " . tablename("eshop_member") . " m on m.openid=o.openid  and m.uniacid =  o.uniacid" . " left join " . tablename("eshop_member_address") . " a on o.addressid = a.id " . " left join " . tablename("eshop_member") . " sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid" . " left join " . tablename("eshop_saler") . " s on s.openid = o.verifyopenid and s.uniacid=o.uniacid" . " WHERE $condition and o.status=2", $paras);
   $order_status4= pdo_fetchcolumn("SELECT COUNT(o.id) FROM " . tablename("eshop_order") . " o " . " left join ( select rr.id,rr.orderid,rr.status from " . tablename("eshop_order_refund") . " rr left join " . tablename("eshop_order") . " ro on rr.orderid =ro.id order by rr.id desc limit 1) r on r.orderid= o.id" . " left join " . tablename("eshop_member") . " m on m.openid=o.openid  and m.uniacid =  o.uniacid" . " left join " . tablename("eshop_member_address") . " a on o.addressid = a.id " . " left join " . tablename("eshop_member") . " sm on sm.openid = o.verifyopenid and sm.uniacid=o.uniacid" . " left join " . tablename("eshop_saler") . " s on s.openid = o.verifyopenid and s.uniacid=o.uniacid" . " WHERE $condition and o.refundid<>0", $paras);
  
  
        $condition = " uniacid = :uniacid and type=1 and status=0";
     $params    = array(
        ':uniacid' => $_W['uniacid']
    );
       $withdraw= pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename("eshop_member_log") . " WHERE $condition", $params);
       
  

			$condition = ' uniacid = :uniacid and  `total` <= 0 and `deleted`=0';
	  $out_goods= pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename("eshop_goods") . " WHERE $condition", $params);
 
			$condition = 'uniacid = :uniacid and   `status` = 0 and `deleted`=0';
  $stock_goods= pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename("eshop_goods") . " WHERE $condition", $params);

  			$condition = 'uniacid = :uniacid and `openid` !="" and `createtime`>="'.$before7day_time.'"';
  $comment= pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename("eshop_order_comment") . " WHERE $condition", $params);
 
 		$condition = 'uniacid = :uniacid and `status` =1';
  $commission_apply_status1= pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename("eshop_commission_apply") . " WHERE $condition", $params);
 
  		$condition = 'uniacid = :uniacid and `status` =2';
  $commission_apply_status2= pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename("eshop_commission_apply") . " WHERE $condition", $params);
 
  		$condition = 'uniacid = :uniacid and isagent=1 and status=1 and `agenttime`>="'.$before7day_time.'"';
  $commission_member_increase= pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename("eshop_member") . " WHERE $condition", $params);
 
 		$condition = 'uniacid = :uniacid and isagent=1 and status=0 ';
  $commission_member_apply= pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename("eshop_member") . " WHERE $condition", $params);
 
    
include $this->template('index');