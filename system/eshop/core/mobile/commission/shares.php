<?php
global $_W, $_GPC;
$openid    = m("user")->getOpenid(true);
if(allow_commission()==false)
{
header("Location:".create_url('mobile',array('act' => 'shopwap','do' => 'membercenter'))	);
exit;
}

$member    = m("member")->getMember($openid);
$shop_set  =globalSetting("shop");
$shop_set['logo']=tomedia($shop_set['logo']);

$set_commission = globalSetting('commission');
$set = $set_commission;
if(empty($set['level']))
{
header("Location:".create_url('mobile',array('do'=>'shop','act'=>'index','m'=>'eshop')));
exit;
}
$share_set  =globalSetting("share");
$share_set['icon']=tomedia($shop_set['icon']);
$can       = false;
if ($member["isagent"] == 1 && $member["status"] == 1) {
    $can = true;
}
if (!$can) {
    header("location: " . $this->createMobileUrl("commission/register"));
    exit;
}

$infourl   = "";
if (empty($set_commission["become_reg"])) {
    if (empty($member["realname"]) || empty($member["mobile"])) {
        message("请先完善用户资料",create_url('mobile',array('act' => 'shopwap','do' => 'info')),'success');
    }
}

if (empty($infourl) ) {
    $p = p("poster");


         $goodsid     = intval($_GPC["goodsid"]);
         if(!empty($goodsid))
         {
                $goods = pdo_fetch("select * from " . tablename("eshop_goods") . " where uniacid=:uniacid and id=:id limit 1", array(
            ":uniacid" => $_W["uniacid"],
            ":id" => $goodsid
        ));
        $goods = set_medias($goods, "thumb");
           
        if (empty($img)) {
            $img =  $p->createGoodsImage($goods, $shop_set);
        }
        if (empty($img)) {
            $img = $p->createCommissionPoster($openid);
        }
			}else
			{
				
            $img = $p->createCommissionPoster($openid);
        
        	
			}

}
include $this->template("shares");
?> 