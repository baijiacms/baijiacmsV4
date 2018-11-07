<?php
        $orderid = intval($_GP['id']);
        $order = mysqld_select("SELECT id,ordersn,status,paytype FROM " . table('eshop_order') . " WHERE id = :id ", array(':id' => $orderid));
  $core_paylog = pdo_fetch("SELECT * FROM " . tablename("core_paylog") . " WHERE `uniacid`=:uniacid AND `tid`=:tid limit 1", array(
        ":uniacid" => $GLOBALS['_CMS']['beid'],
        ":tid" => $order['ordersn']
    ));
if (empty($order['id'])) {
   	echo json_encode(array('status'=>0));
   	exit;
}
        		//检查订单是否支付
        if($order['paytype']==21)
        {
    	$iswechat_success=isWeixinPayFinish($order['ordersn'].'-'.$core_paylog['plid'],'order');
					if($iswechat_success)
					{
      
			      $return_result=order_finish("wechat",21,$order["id"]);
			      if($return_result)
			      {
			      	    $order = mysqld_select("SELECT id,ordersn,status FROM " . table('eshop_order') . " WHERE id = :id ", array(':id' => $orderid));
   
				echo json_encode($order);
				exit;
			      }
					}
				}
				    if($order['paytype']==22)
        {
    	$iswechat_success=isAliPayFinish($order['ordersn'].'-'.$core_paylog['plid'],'order');
  
					if($iswechat_success)
					{
      
			      $return_result=order_finish("alipay",22,$order["id"]);
			      if($return_result)
			      {
			      	    $order = mysqld_select("SELECT id,ordersn,status FROM " . table('eshop_order') . " WHERE id = :id ", array(':id' => $orderid));
   
				echo json_encode($order);
				exit;
			      }
					}
				}
	echo json_encode($order);