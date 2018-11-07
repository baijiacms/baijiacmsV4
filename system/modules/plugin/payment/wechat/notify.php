<?php
/**
 * 通用通知接口demo
 * ====================================================
 * 支付完成后，微信会把相关支付和用户信息发送到商户设定的通知URL，
 * 商户接收回调信息后，根据需要设定相应的处理流程。
 * 
 * 这里举例使用log文件形式记录回调信息。
*/
error_reporting(0);
	$payment = mysqld_select("SELECT id,configs FROM " . table('payment') . " WHERE  enabled=1 and code='wechat' and beid=:beid limit 1",array(":beid"=>$_CMS['beid']));

       if(empty($payment['id']))
    {
     exit;
      }

	 $xml = $GLOBALS['HTTP_RAW_POST_DATA'];	

	 mysqld_insert('paylog', array('typename'=>'微信支付记录','pdate'=>$xml,'ptype'=>'success','paytype'=>'weixin',"beid"=>$_CMS['beid']));

	 	header("Content-type: text/xml;charset=utf-8");
								echo "<xml>";
								echo "<return_code><![CDATA[SUCCESS]]></return_code>";
								echo "<return_msg><![CDATA[OK]]></return_msg>";
								echo "</xml>";
								exit;
?>