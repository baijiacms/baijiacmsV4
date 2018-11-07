<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
if(is_use_weixin())
{
	
	$openid = get_sysopenid(true);
}else
{
$openid = get_sysopenid(false);
}
$hascoupon       = false;
$hascouponcenter = false;
$islogin=false;
if(is_login_account())
{
checkAgent();
$memberinfo = get_member_info($openid);
$islogin=true;
$set_shop=globalSetting('shop');
$set_trade=globalSetting('trade');
$pset = globalSetting('commission');
    if (!empty($pset["level"])&&allow_commission()) {
        if ($memberinfo["isagent"] == 1 && $memberinfo["status"] == 1) {
            $hascom = true;
        }
    }

$pcset =  globalSetting('coupon');
if (empty($pcset["closemember"])) {
        $hascoupon = true;
}
if (empty($pcset["closecenter"])) {
        $hascouponcenter = true;
 }
 
    $level = array(
        "levelname" => "普通会员"
    );
    
        if (!empty($member["level"])) {
          $level = pdo_fetch('select * from ' . tablename('eshop_member_level') . ' where id=:id and uniacid=:uniacid order by level asc', array(
            ':uniacid' => $_W['uniacid'],
            ':id' => $memberinfo['level']
        ));
    			}
    			
    			 $orderparams = array(
        ":uniacid" => $_CMS['beid'],
        ":openid" => $openid
    );
    $order       = array(
        "status0" => pdo_fetchcolumn("select count(*) from " . tablename("eshop_order") . " where openid=:openid and status=0  and uniacid=:uniacid limit 1", $orderparams),
        "status1" => pdo_fetchcolumn("select count(*) from " . tablename("eshop_order") . " where openid=:openid and status=1 and refundid=0 and uniacid=:uniacid limit 1", $orderparams),
        "status2" => pdo_fetchcolumn("select count(*) from " . tablename("eshop_order") . " where openid=:openid and status=2 and refundid=0 and uniacid=:uniacid limit 1", $orderparams),
        "status4" => pdo_fetchcolumn("select count(*) from " . tablename("eshop_order") . " where openid=:openid and refundid<>0 and uniacid=:uniacid limit 1", $orderparams)
    );
    
       $time   = time();
         $sql    = "select count(d.id)  from " . tablename("eshop_coupon_data") . " d";
    $sql .= " left join " . tablename("eshop_coupon") . " c on d.couponid = c.id";
    $sql .= " where d.openid=:openid and d.uniacid=:uniacid ";
    $sql .= " and (   (c.timelimit = 0 and ( c.timedays=0 or c.timedays*86400 + d.gettime >=unix_timestamp() ) )  or  (c.timelimit =1 and c.timestart<={$time} && c.timeend>={$time})) and  d.used =0 ";
   $coupon_count= pdo_fetchcolumn($sql,array(
        ":openid" => $openid,
        ":uniacid" => $_CMS['beid']
    ));
  if(!empty($set_trade['closerecharge'])||$hascoupon==false) {  $cart_count=pdo_fetchcolumn('select sum(total) from ' . tablename('eshop_member_cart') . ' where uniacid=:uniacid and openid=:openid and deleted=0 ', array(
            ':uniacid' => $_CMS['beid'],
            ':openid' => $openid
        ));}
}
    
include page('membercenter');