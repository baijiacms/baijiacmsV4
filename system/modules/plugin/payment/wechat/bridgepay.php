<?php 
$payment = mysqld_select("SELECT id,configs FROM " . table('payment') . " WHERE  enabled=1 and code='wechat' and beid=:beid limit 1",array(":beid"=>$GLOBALS['_CMS']['beid']));
    if(empty($payment['id']))
    {
      message("未开启微信支付功能");	
      }
   $ordersn=base64_decode(urldecode($_GP['osn']));
       if(empty($ordersn))
    {
    message('订单错误');	
    }
   $order = mysqld_select("SELECT * FROM " . table('eshop_order') . " WHERE ordersn =:ordersn", array(':ordersn' => $ordersn));
   $goodtitle=$order['ordersn'];
    if(empty($order['id']))
    {
    message('订单错误');	
    }
      pdo_update("eshop_order", array(
            "paytype" => 21
        ), array(
            "id" => $order["id"]
        ));
      $core_paylog = pdo_fetch("SELECT * FROM " . tablename("core_paylog") . " WHERE `uniacid`=:uniacid AND `tid`=:tid limit 1", array(
        ":uniacid" => $GLOBALS['_CMS']['beid'],
        ":tid" => $ordersn
    ));
		$configs=unserialize($payment['configs']);
    	$settings=globalSetting('weixin');
    		$success_url=WEBSITE_ROOT.create_url('mobile',array('act' => 'list','do' => 'order','m'=>'eshop','status'=>1));
	if($_GP['isok'] == '1') {
				if(!empty($order["id"]))
				{
				 	$iswechat_success=isWeixinPayFinish($order['ordersn'].'-'.$core_paylog['plid'],'order');
					if($iswechat_success)
					{
						   $return_result=order_finish("wechat",21,$order["id"]);
					}
				}
					message('支付成功！',$success_url,'success');
				}
    	//检查订单是否支付
    	$iswechat_success=isWeixinPayFinish($order['ordersn'].'-'.$core_paylog['plid'],'order');
					if($iswechat_success)
					{
      
			      $return_result=order_finish("wechat",21,$order["id"]);
			      if($return_result)
			      {
						message('支付成功！',$success_url,'success');
			      }
					}
    	//检查订单是否支付end
    
	
	if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
			$wechat_openid=get_weixin_openid();
				}
			$cfg=globalSetting('weixin');
					$shopcfg=globalSetting('shop');
			$package = array();
		$package['appid'] = $cfg['weixin_appId'];
		$package['mch_id'] = $configs['wechat_pay_mchId'];
		$package['nonce_str'] = random(8);
		$package['body'] = $goodtitle;
		$package['out_trade_no'] = $order['ordersn'].'-'.$core_paylog['plid'];
		$package['total_fee'] = $order['price']*100;
		$package['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];
			if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
		$package['notify_url'] =WEBSITE_ROOT.'api/weixin_notify.php';
		$package['trade_type'] = 'JSAPI';
		$package['openid'] = $wechat_openid;
				}else
				{
						$package['notify_url'] =WEBSITE_ROOT.'api/weixin_notify.php';
						$package['product_id'] =  $order['ordersn'].'-'.$core_paylog['plid'];
						$package['trade_type'] = 'NATIVE';
				}
		ksort($package, SORT_STRING);
		$string1 = '';
		foreach($package as $key => $v) {
			$string1 .= "{$key}={$v}&";
		}
		$string1 .= "key=".$configs['wechat_pay_paySignKey'];
		$package['sign'] = strtoupper(md5($string1));
		
        $xml = "<xml>";  
        foreach ($package as $key=>$val)
        {
     
        	 if (is_numeric($val))
        	 {
        	 	$xml.="<".$key.">".$val."</".$key.">"; 

        	 }
        	 else
        	 	$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
        }
        $xml.="</xml>";
	  $data =http_post("https://api.mch.weixin.qq.com/pay/unifiedorder",$xml);
       	
			
					if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
		
			if(!empty($data))
			{
				$xml = @simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
			if(!empty($xml->err_code)&&$xml->err_code=='OUT_TRADE_NO_USED')
			{
		if(!empty($_GP['x']))
		{
		message($data);
		}
				 $core_paylog = pdo_fetch("SELECT * FROM " . tablename("core_paylog") . " WHERE `uniacid`=:uniacid AND `tid`=:tid limit 1", array(
        ":uniacid" => $GLOBALS['_CMS']['beid'],
        ":tid" => $ordersn
    ));
      
         mysqld_delete('core_paylog',array('plid'=>$core_paylog['plid']));
           unset($core_paylog['plid']);
     unset($core_paylog['createtime']);
       mysqld_insert('core_paylog',$core_paylog );
				
					header("Location:".WEBSITE_ROOT.create_url("mobile",array("act"=>"modules","do"=>"weixin_bridgepay","x"=>1,"osn"=>urlencode(base64_encode($ordersn)))));
	exit;

			}
						$prepayid = $xml->prepay_id;
						$jsApiParameters=array();
					$jsApiParameters['appId'] = $cfg['weixin_appId'];
					$jsApiParameters['timeStamp'] = time();
					$jsApiParameters['nonceStr'] = random(8);
					$jsApiParameters['package'] = 'prepay_id='.$prepayid;
					$jsApiParameters['signType'] = 'MD5';
			
					ksort($jsApiParameters, SORT_STRING);
					foreach($jsApiParameters as $key => $v) {
						$string .= "{$key}={$v}&";
					}
					$string .= "key=".$configs['wechat_pay_paySignKey'];
					$jsApiParameters['paySign'] = strtoupper(md5($string));
					

			}
		}else
		{
 
				$xml = @simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
						if(!empty($xml->err_code)&&$xml->err_code=='OUT_TRADE_NO_USED')
			{
		
				 $core_paylog = pdo_fetch("SELECT * FROM " . tablename("core_paylog") . " WHERE `uniacid`=:uniacid AND `tid`=:tid limit 1", array(
        ":uniacid" => $GLOBALS['_CMS']['beid'],
        ":tid" => $ordersn
    ));
 
         mysqld_delete('core_paylog',array('plid'=>$core_paylog['plid']));
            unset($core_paylog['plid']);
     unset($core_paylog['createtime']);
       mysqld_insert('core_paylog',$core_paylog );
				
					header("Location:".WEBSITE_ROOT.create_url("mobile",array("act"=>"modules","do"=>"weixin_bridgepay","x"=>1,"osn"=>urlencode(base64_encode($ordersn)))));
	exit;

			}
					$code_url = $xml->code_url;
				if(empty($code_url))
				{
					
				message("无法发起二维码支付，请更换另外一种付款方式，或者联系管理员");	
				}
			?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="telephone=no, address=no" name="format-detection">
<script type="text/javascript" src="<?php echo RESOURCE_ROOT;?>weengine/js/lib/jquery-1.11.1.min.js"></script>
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" /> <!-- apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<title>微信支付</title>
<link href="<?php echo RESOURCE_ROOT;?>public/weixin/main.css" rel="stylesheet" />
</head>
<body>
	
	
    <div class="p-header" style=" background-color: #F1F2F7;">
            <div class="w" >
                <div id="logo">
                
                </div>
            </div>
    </div>
 <!-- p-header end -->

    
    <div class="main">
        <div class="w">
            <!-- order 订单信息 -->
                         <!-- order 订单信息 -->
<div class="order">
        <div class="o-left">
            <h3 class="o-title">
                			请您及时付款，以便订单尽快处理！    		           	订单号：<?php echo $order['ordersn'];?>

			
            </h3>
            <p class="o-tips">
				
                							        			            	请您在提交订单后尽快完成支付。
																</p>
        </div>
        <div class="o-right">
            <div class="o-price">
                <em>应付金额</em><strong><?php echo $order['price'];?></strong><em>元</em>
            </div>

                           
            
        </div>
        <div class="clr"></div>
        
                                                
            		      
  
</div>
<!-- order 订单信息 end -->            <!-- order 订单信息 end -->

            <!-- payment 支付方式选择 -->
            <div class="payment">
                <!-- 微信支付 -->
                <div class="pay-wechat">
                    <div class="p-w-hd">微信支付</div>
                    <div class="p-w-bd">
                        <div class="p-w-box">
                            <div class="pw-box-hd">
                                <img alt="模式二扫码支付" src="<?php echo WEBSITE_ROOT;?>includes/lib/phpqrcode/qrcode.php?data=<?php echo urlencode($code_url);?>" style="width:298px;height:298px;"/>
                            </div>
                            <div class="pw-box-ft">
                                <p>请使用微信扫一扫</p>
                                <p>扫描二维码支付</p>
                            </div>
                        </div>
                        <div class="p-w-sidebar"></div>
                    </div>
                </div>
                <!-- 微信支付 end -->
                <!-- payment-change 变更支付方式 -->
                <div class="payment-change">
                    <a class="pc-wrap" id="reChooseUrl" href="javascript:history.back();">
                    	<i class="pc-w-arrow-left">&lt;</i>
                        <strong>选择其他支付方式</strong>
                    </a>
                       <a class="pc-wrap" style="float:right" href="<?php echo $success_url;?>">
                        <strong>如完成支付没有跳转请点击</strong>
                        <i class="pc-w-arrow-right">&gt;</i>
                    </a>
                </div>
                <!-- payment-change 变更支付方式 end -->
            </div>
            <!-- payment 支付方式选择 end -->
        </div>
    </div>





    <div class="p-footer">
      <div class="pf-wrap w">
          <div class="pf-line">
              <span class="pf-l-copyright">Copyright © <?php echo $shopcfg['name'] ?></span>
            
          </div>
      </div>
</div>

  <script type="text/javascript" language="javascript">
      function checkorder()
      {
      	$.getJSON("<?php echo 	create_url('mobile',array('act' => 'shopwap','do' => 'getorder','id'=>$order['id']));?>", { }, function(json){

  if(json.status>0)
  {
  location.href="<?php echo $success_url;?>";	
  }
});

      }
   setInterval("checkorder()", 3000);	
    
        </script>
</body>
</html>
			
				<?php
		}
		
			if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')) {
?>
	<script>

document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',{
		'appId' : '<?php echo $jsApiParameters['appId'];?>',
		'timeStamp': '<?php echo $jsApiParameters['timeStamp'];?>',
		'nonceStr' : '<?php echo $jsApiParameters['nonceStr'];?>',
		'package' : '<?php echo $jsApiParameters['package'];?>',
		'signType' : '<?php echo $jsApiParameters['signType'];?>',
		'paySign' : '<?php echo $jsApiParameters['paySign'];?>'
	}, function(res) {
					if(res.err_msg == 'get_brand_wcpay_request:ok') {
						location.search += '&isok=1';
					} else {
							alert('微信支付未完成');
					
						history.go(-1);
					}
				}
			);
		});

	</script>
<?php
}
?>