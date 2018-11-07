<?php
//微信商城
if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
$operation = $_GPC['op'];
if($operation=='success')
{
		message('核销成功！','refresh',  'success');
}
$openid    = m('user')->getOpenid(true);
$uniacid   = $_W['uniacid'];
 $saler = pdo_fetch('select * from ' . tablename('eshop_saler') . ' where openid=:openid and uniacid=:uniacid limit 1', array(
                ':uniacid' => $_W['uniacid'],
                ':openid' => $openid
            ));
     if (empty($saler)) {
 
     		message('您不是核销员不能进行核销');
            exit;
            }
if (checksubmit("submit")) {
			$ordersn=trim($_GPC['ordersn']);
  $order = pdo_fetch('select * from ' . tablename('eshop_order') . ' where ordersn=:ordersn and uniacid=:uniacid', array(
                    ':ordersn' => $ordersn,
                    ':uniacid' => $_W['uniacid']
                ));
              
     if(empty($order['id']))
        {
        	 $order = pdo_fetch('select * from ' . tablename('eshop_order') . ' where verifycode=:vcode and uniacid=:uniacid', array(
                    ':vcode' => $ordersn,
                    ':uniacid' => $_W['uniacid']
                ));
        }
        
        if(empty($order['id']))
        {
         	  message("订单编号错误，未找到核销订单!");
            exit;
        }
        

     	 if (!empty($order['verified'])) {
				   message("核销失败！订单已完成了，不能重复核销!");
            exit;
				}
     	 if ($order['status'] < 1) {
        		message("订单未付款，无法核销!");
            exit;
        }
         if ($order['status'] ==3) {
     	 message("核销失败！订单已完成了，不能重复核销!");
            exit;
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

        m("notice")->sendOrderMessage($order['id']);
        if (p("commission")) {
            p("commission")->checkOrderFinish($order['id']);
        }
     
        
  	message("核销成功!",'refresh','success');
          exit;
}
include $this->template('index'); 