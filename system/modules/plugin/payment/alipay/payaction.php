<?php
defined('SYSTEM_IN') or exit('Access Denied');
	require_once(WEB_ROOT."/system/modules/plugin/payment/alipay/common.php");
 
        
		$payment = mysqld_select("SELECT id,configs FROM " . table('payment') . " WHERE  enabled=1 and code='alipay' and beid=:beid limit 1",array(":beid"=>$GLOBALS['_CMS']['beid']));
  $core_paylog = pdo_fetch("SELECT * FROM " . tablename("core_paylog") . " WHERE `uniacid`=:uniacid AND `module`=:module AND `tid`=:tid limit 1", array(
        ":uniacid" => $GLOBALS['_CMS']['beid'],
        ":module" => "eshop",
        ":tid" => $order["ordersn"]
    ));
          		$configs=unserialize($payment['configs']);
      $goodtitle=$order['ordersn'];
       pdo_update("eshop_order", array(
            "paytype" => 22
        ), array(
            "id" => $order["id"]
        ));
      
        	$success_url=WEBSITE_ROOT.create_url('mobile',array('act' => 'list','do' => 'order','m'=>'eshop','status'=>1));
         	$isaliapy_success=isAliPayFinish($order['ordersn'].'-'.$core_paylog['plid'],'order');
					if($isaliapy_success)
					{
			      $return_result=order_finish("alipay",22,$order["id"]);
			      if($return_result)
			      {
						message('支付成功！',$success_url,'success');
			      }
					}
    

    $sysParams=array();
		$sysParams["app_id"] = $configs['alipay_appid'];
		$sysParams["version"] = '1.0';
		$sysParams["format"] = 'json';
		$sysParams["notify_url"] = WEBSITE_ROOT.'api/alipay_notify.php';
		 if(is_mobile())
	{
		$sysParams["method"] = "alipay.trade.wap.pay";
		$sysParams["return_url"] = WEBSITE_ROOT.create_url("mobile",array("act"=>"modules","do"=>"alipay_success","out_trade_no"=>$order['ordersn'].'-'.$core_paylog['plid']));
	}else
	{
			$sysParams["method"] = "alipay.trade.precreate";
	}
		$sysParams["sign_type"] = "RSA";
		
		$sysParams["timestamp"] = date("Y-m-d H:i:s");
		$sysParams["charset"] = 'UTF-8';
				 if(is_mobile())
	{
		$sysParams["biz_content"] = json_encode(array("product_code"=>'QUICK_WAP_PAY',"out_trade_no"=>$order['ordersn'].'-'.$core_paylog['plid'],"subject"=>$goodtitle,"total_amount"=>$order['price']));
	}else
	{
				$sysParams["biz_content"] = json_encode(array("out_trade_no"=>$order['ordersn'].'-'.$core_paylog['plid'],"subject"=>$goodtitle,"total_amount"=>$order['price']));

	}
		$sysParams["sign"]=alipay_sign($configs['wap_dev_privatekey'],alipay_getSignContent($sysParams));

		$requestUrl = 'https://openapi.alipay.com/gateway.do' . "?";
		foreach ($sysParams as $sysParamKey => $sysParamValue) {
			$requestUrl .= "$sysParamKey=" . urlencode($sysParamValue) . "&";
		}
		$requestUrl = substr($requestUrl, 0, -1);

		 if(is_mobile())
	{
				header("Location:".$requestUrl);
		exit;
  }else
  {$retuanvalue=http_get($requestUrl);
$result = json_decode($retuanvalue, true);
$result=$result['alipay_trade_precreate_response'];
if(empty($result['out_trade_no']))
{
message("支付宝发起失败");	
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
<title>支付宝支付</title>
<link href="<?php echo RESOURCE_ROOT;?>public/weixin/main.css" rel="stylesheet" />
</head>
<style>
	.p-p-sidebar {
    float: left;
    width: 379px;
    height: 421px;
    padding-left: 50px;
    margin-top: -20px;
    background: url(<?php echo RESOURCE_ROOT;?>public/image/alipay.png) 50px 0 no-repeat;
}
	</style>
<body>
	
	
    <div class="p-header" style=" background-color: #F1F2F7;">
            <div class="w">
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
                    <div class="p-w-hd">支付宝支付</div>
                    <div class="p-w-bd">
                        <div class="p-w-box">
                            <div class="pw-box-hd">
                                <img alt="模式二扫码支付" src="<?php echo WEBSITE_ROOT;?>includes/lib/phpqrcode/qrcode.php?data=<?php echo urlencode($result['qr_code']);?>" style="width:298px;height:298px;"/>
                            </div>
                            <div class="pw-box-ft">
                                <p>请使用支付宝扫一扫</p>
                                <p>扫描二维码支付</p>
                            </div>
                        </div>
                        <div class="p-p-sidebar"></div>
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
}?>