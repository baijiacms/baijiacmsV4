<?php
if (!defined('IN_IA')) {
  print("Access Denied"); 
}
global $_W, $_GPC;

$op      = empty($_GPC['op']) ? 'shop' : trim($_GPC['op']);
if ($op == 'shop') {
$set_shop=globalSetting('shop');
$set=array();
$set['shop']=$set_shop;
}

if ($op == 'trade') {
$set_trade=globalSetting('trade');
$set_coupon=globalSetting('coupon');
$set=array();
$set['trade']=$set_trade;
$set['coupon']=$set_coupon;
}
if ($op == 'sms') {
	$settings=globalSetting('sms');
}

if (checksubmit()) {
    if ($op == 'shop') {
        $shop                   = is_array($_GPC['shop']) ? $_GPC['shop'] : array();
        $set=array();
        $set['name']    = trim($shop['name']);
				 $set['kefuu']    = trim($shop['kefuu']);
        $set['logo']    = save_media($shop['logo']);
					$set["diycode"] = $_POST["shop"]["diycode"]; 
					$set["close"] =intval($shop["close"]); 
					$set["closedetail"] = htmlspecialchars_decode($shop["closedetail"]);
					$set["closeurl"] =trim($shop["closeurl"]);
					 $set['levelurl']    = trim($shop['levelurl']);
					  $set['leveltype']    = trim($shop['leveltype']);
					  
					    $set['catlevel']  = 2;
        $set['catshow']   = 0;
        $set['catadvimg'] = save_media($shop['catadvimg']);
        $set['catadvurl'] = trim($shop['catadvurl']);
					   refreshSetting($set,'shop');
    } elseif ($op == 'trade') {
        $trade = is_array($_GPC['trade']) ? $_GPC['trade'] : array();
         $set=array();
         $set['refunddays']=$trade['refunddays'];
         $set['refundcontent']=$trade['refundcontent'];
         $set['closerecharge']=$trade['closerecharge'];
         $set['withdraw']=$trade['withdraw'];
         $set['withdrawmoney']=$trade['withdrawmoney'];
         $set['money']=$trade['money'];
         $set['credit']=$trade['credit'];
         
         refreshSetting($set,'trade');
         
         
            $coupon = is_array($_GPC['coupon']) ? $_GPC['coupon'] : array();
         $set=array();
            $set['closecenter']=intval($coupon['closecenter']);
               $set['closemember']=intval($coupon['closemember']);
               $set['consumedesc']=htmlspecialchars_decode($coupon['consumedesc']);
            refreshSetting($set,'coupon');
   
    } elseif ($op == 'sms') {

    	  if($_GPC['regsiter_usesms']==1)
				   		  {
				   		  	  if(empty($_GPC['sms_key']))
				   		  {
				   		  	message("短信key不能空");
				   		  }
				   		  	  	  if(empty($_GPC['sms_secret']))
				   		  {
				   		  	message("短信Secret不能空");
				   		  }
				   
				   		    	  if(empty($_GPC['sms_secret_resec']))
				   		  {
				   		  	message("验证码重发时间不能空");
				   		  }
				   		   	  if(empty($_GPC['sms_secret_count']))
				   		  {
				   		  	message("一天同一个业务最多发送多少条短信不能空");
				   		  }
				   		  }
	   	
            $cfg = array(
            'regsiter_usesms' => intval( $_GPC['regsiter_usesms']),
               'sms_key' => $_GPC['sms_key'],
                'sms_secret' => $_GPC['sms_secret'],
                'sms_secret_count' => intval($_GPC['sms_secret_count']),
                'sms_secret_resec' => intval($_GPC['sms_secret_resec']),
                'sms_register_user' => $_GPC['sms_register_user'],
                'sms_change_pwd1' => $_GPC['sms_change_pwd1'],
                'sms_change_pwd2' => $_GPC['sms_change_pwd2'],
                'sms_change_mobile' => $_GPC['sms_change_mobile'],
                'sms_mobile_test' => $_GPC['sms_mobile_test'],
                'sms_register_user_signname' => $_GPC['sms_register_user_signname'],
                'sms_change_pwd1_signname' => $_GPC['sms_change_pwd1_signname'],
                'sms_change_pwd2_signname' => $_GPC['sms_change_pwd2_signname'],
                'sms_change_mobile_signname' => $_GPC['sms_change_mobile_signname'],
                'sms_mobile_test_signname' => $_GPC['sms_mobile_test_signname']
            );
                  refreshSetting($cfg,'sms');
    }
   
   
    message('设置保存成功!', 'refresh', 'success');
}

include $this->template( $op);
exit;