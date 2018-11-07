<?php 
	$payment = mysqld_select("SELECT id FROM " . table('payment') . " WHERE  enabled=1 and code='credit' and beid=:beid limit 1",array(":beid"=>$GLOBALS['_CMS']['beid']));
    if(empty($payment['id']))
    {
      message("未开启余额支付功能");	
      }
						$member=member_get($openid);
			if($member['credit2']>=$order['price'])
				{
					   pdo_update("eshop_order", array(
            "paytype" => 1
        ), array(
            "id" => $order["id"]
        ));
	member_gold($openid,$order['price'],'usegold','余额支付，订单编号：'.$order['ordersn']);
//==strart==
$return_result=order_finish("credit",1,$order["id"]);
      if($return_result)
      {
      	  message("余额支付成功",create_url('mobile',array('do'=>'order','act'=>'list','m'=>'eshop')),'success');        
      }else
      {
      	  message("余额支付失败，请重试",create_url('mobile',array('do'=>'order','act'=>'list','m'=>'eshop')),'error');        
     
      }
        
      }else
      {
      message("余额不足");	
      }
?>