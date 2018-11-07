<?php
        $orderid = intval($_GP['id']);
        $order = mysqld_select("SELECT id,status,logno,paytype FROM " . table('eshop_member_log') . " WHERE id = :id ", array(':id' => $orderid));
        	if (empty($order['id'])) {
   	echo json_encode(array('status'=>0));
   	exit;
}
        	
        	     if($order['paytype']==21)
        {
        		$iswechat_success=isWeixinPayFinish($order['logno'],'gold');
      	if($iswechat_success){
      	$returnvalue=	goldorder_finish($order['id']);
				    if($returnvalue)
				    {
			      	  	    $order = mysqld_select("SELECT id,status,logno FROM " . table('eshop_member_log') . " WHERE id = :id ", array(':id' => $orderid));
     
				echo json_encode($order);
				exit;
			      }
					}
				}
				
				
				   if($order['paytype']==22)
        {
        		$iswechat_success=isAliPayFinish($order['logno'],'gold');
      	if($iswechat_success){
      		$returnvalue=	goldorder_finish($order['id']);
				    if($returnvalue)
				    {
			      	  	    $order = mysqld_select("SELECT id,status,logno FROM " . table('eshop_member_log') . " WHERE id = :id ", array(':id' => $orderid));
     
				echo json_encode($order);
				exit;
			      }
					}
				}
					
					
	echo json_encode($order);