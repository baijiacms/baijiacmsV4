<?php
defined('SYSTEM_IN') or exit('Access Denied');
class modulesAddons  extends BjSystemModule {
			public function do_weixin_goldbridgepay()
	{
				global $_CMS,$_GP;
					include_once(WEB_ROOT."/system/modules/plugin/payment/wechat/gold_bridgepay.php");
					exit;		
	}
		public function do_weixin_bridgepay()
	{
				global $_CMS,$_GP;
					include_once(WEB_ROOT."/system/modules/plugin/payment/wechat/bridgepay.php");
					exit;		
	}
	
	public function do_weixin_notify()
	{		
		global $_CMS;
					include_once(WEB_ROOT."/system/modules/plugin/payment/wechat/notify.php");
					exit;
	}	public function do_weixin_gold_notify()
	{		
		global $_CMS;
					include_once(WEB_ROOT."/system/modules/plugin/payment/wechat/gold_notify.php");
					exit;
	}
		public function do_weixin_returnurl()
	{		
		global $_CMS;
					include_once(WEB_ROOT."/system/modules/plugin/payment/wechat/returnurl.php");
					exit;
	}
	
	
	public function do_qq_returnurl()
	{		
					global $_CMS,$_GP;
		$system_store = mysqld_select('SELECT id,website,fullwebsite FROM '.table('system_store')." where `id`=:id",array(":id"=>$GLOBALS['_CMS']['beid']));
					if(empty($system_store['fullwebsite']))
					{
					
					$store_website="http://".$system_store['website']."/";
					}else
					{
					$store_website=$system_store['fullwebsite'];
					}
					
header("Location:".$store_website.create_url('mobile',array('act' => 'qq','do' => 'fastlogin','state'=>$_GP['state'],'code'=>$_GP['code'])));
	}
				public function do_alipay_goldbridgepay()
	{
				global $_CMS,$_GP;
					include_once(WEB_ROOT."/system/modules/plugin/payment/alipay/gold_bridgepay.php");
					exit;		
	}
	public function do_alipay_notify()
	{		
		global $_CMS;
					include_once(WEB_ROOT."/system/modules/plugin/payment/alipay/notify.php");
					exit;
	}	public function do_alipay_gold_notify()
	{		
		global $_CMS;
					include_once(WEB_ROOT."/system/modules/plugin/payment/alipay/gold_notify.php");
					exit;
	}
		public function do_alipay_returnurl()
	{		
		global $_CMS;
					include_once(WEB_ROOT."/system/modules/plugin/payment/alipay/returnurl.php");
					exit;
	}
			public function do_alipay_success()
	{
				global $_GP;
		$out_trade_no=$_GP['out_trade_no'];
		   	$success_url=WEBSITE_ROOT.create_url('mobile',array('act' => 'list','do' => 'order','m'=>'eshop','status'=>1));
         	$isaliapy_success=isAliPayFinish($out_trade_no,'order');
         			$out_trade_no=explode('-',$out_trade_no);
     		$ordersn = $out_trade_no[0];
     			$order = mysqld_select("SELECT * FROM " . table('eshop_order') . " WHERE ordersn =:ordersn and uniacid=:uniacid limit 1", array(':ordersn' => $ordersn,":uniacid"=>$GLOBALS['_CMS']['beid']));

					if($isaliapy_success)
					{
			      $return_result=order_finish("alipay",22,$order["id"]);
			  
					}
			message('支付成功！',$success_url,'success');	
	}
	
	
			public function do_pay_success()
	{
			message('支付成功！',WEBSITE_ROOT.create_url('mobile',array('act' => 'shopwap','do' => 'membercenter')),'success');	
	}
	


}


