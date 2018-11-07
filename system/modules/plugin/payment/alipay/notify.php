<?php
defined('SYSTEM_IN') or exit('Access Denied');
	$payment = mysqld_select("SELECT id,configs FROM " . table('payment') . " WHERE  enabled=1 and code='alipay' and beid=:beid limit 1",array(":beid"=>$GLOBALS['_CMS']['beid']));
 $configs=unserialize($payment['configs']);

$post_data = serialize($_GET);
mysqld_insert('paylog', array('typename'=>'支付宝返回数据记录','pdate'=>$post_data,'ptype'=>'success','paytype'=>'alipay',"beid"=>$GLOBALS['_CMS']['beid']));
     
if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	$out_trade_no = $_POST['out_trade_no'];

	//支付宝交易号

	$trade_no = $_POST['trade_no'];

	//交易状态
	$trade_status = $_POST['trade_status'];


    	if ($_POST['trade_status'] == 'TRADE_SUCCESS'||$_POST['trade_status'] == 'TRADE_FINISHED') {
    		echo "success";		exit;
    }
    echo "fail";
        
		exit;
	
}
else {
	
	mysqld_insert('paylog', array('typename'=>'通信出错','pdate'=>$post_data,'ptype'=>'error','paytype'=>'alipay',"beid"=>$GLOBALS['_CMS']['beid']));
    echo "fail";
	exit;
}