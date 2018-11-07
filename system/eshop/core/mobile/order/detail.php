<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
$operation      = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$openid         = m('user')->getOpenid(true);
$uniacid        = $_W['uniacid'];
$orderid        = intval($_GPC['id']);

$order          = pdo_fetch('select * from ' . tablename('eshop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(
    ':id' => $orderid,
    ':uniacid' => $uniacid,
    ':openid' => $openid
));

$core_paylog = pdo_fetch("SELECT * FROM " . tablename("core_paylog") . " WHERE `uniacid`=:uniacid AND `tid`=:tid limit 1", array(
        ":uniacid" => $GLOBALS['_CMS']['beid'],
        ":tid" => $order['ordersn']
    ));

if($order['paytype']==21&&empty($order['status'])&&!empty($order['ordersn'])&&!empty($core_paylog['plid']))
{
	   
    	
    	 	$iswechat_success=isWeixinPayFinish($order['ordersn'].'-'.$core_paylog['plid'],'order');
					if($iswechat_success)
					{
      
			      $return_result=order_finish("wechat",21,$order["id"]);
			      if($return_result)
			      {
						  $order          = pdo_fetch('select * from ' . tablename('eshop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(
    ':id' => $orderid,
    ':uniacid' => $uniacid,
    ':openid' => $openid
));
			      }
					}

}

	if($order['paytype']==22&&empty($order['status'])&&!empty($order['ordersn'])&&!empty($core_paylog['plid']))
{
	
    	 	$iswechat_success=isAliPayFinish($order['ordersn'].'-'.$core_paylog['plid'],'order');
					if($iswechat_success)
					{
      
			      $return_result=order_finish("alipay",22,$order["id"]);
			       if($return_result)
			      {
						  $order          = pdo_fetch('select * from ' . tablename('eshop_order') . ' where id=:id and uniacid=:uniacid and openid=:openid limit 1', array(
    ':id' => $orderid,
    ':uniacid' => $uniacid,
    ':openid' => $openid
));
			      }
					}
	}

if (!empty($order)) {
    $order['virtual_str'] = str_replace("\n", "<br/>", $order['virtual_str']);
   
    $goods        = pdo_fetchall("select og.goodsid,og.price,g.title,g.thumb,og.total,g.credit,og.optionid,og.optionname as optiontitle,g.isverify,g.storeids  from " . tablename('eshop_order_goods') . " og " . " left join " . tablename('eshop_goods') . " g on g.id=og.goodsid " . " where og.orderid=:orderid and og.uniacid=:uniacid ", array(
        ':uniacid' => $uniacid,
        ':orderid' => $orderid
    ));
    $show         = 1;
    foreach ($goods as &$g) {
        $g['thumb'] = tomedia($g['thumb']);
       
        unset($g);
    }
}
if ($_W['isajax']) {
    if (empty($order)) {
        show_json(0);
    }
    $order['virtual_str']     = str_replace("\n", "<br/>", $order['virtual_str']);
    $order['goodstotal']      = count($goods);
    $order['finishtimevalue'] = $order['finishtime'];
    $order['finishtime']      = date('Y-m-d H:i:s', $order['finishtime']);
    $order['createtime']      = date('Y-m-d H:i:s', $order['createtime']);
    $address                  = false;
    $carrier                  = false;
    $stores                   = array();
    if ($order['isverify'] == 1) {
        $storeids = array();
        foreach ($goods as $g) {
            if (!empty($g['storeids'])) {
                $storeids = array_merge(explode(',', $g['storeids']), $storeids);
            }
        }
        if (empty($storeids)) {
            $stores = pdo_fetchall('select * from ' . tablename('eshop_store') . ' where  uniacid=:uniacid and status=1', array(
                ':uniacid' => $_W['uniacid']
            ));
        } else {
            $stores = pdo_fetchall('select * from ' . tablename('eshop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1', array(
                ':uniacid' => $_W['uniacid']
            ));
        }
    } else {
        if ($order['dispatchtype'] == 0) {
            $address = iunserializer($order['address']);
            if (!is_array($address)) {
                $address = pdo_fetch('select realname,mobile,address from ' . tablename('eshop_member_address') . ' where id=:id limit 1', array(
                    ':id' => $order['addressid']
                ));
            }
        }
    }
    if ($order['dispatchtype'] == 1 || $order['isverify'] == 1 || !empty($order['virtual'])) {
        $carrier = unserialize($order['carrier']);
    }
    $set       = globalSetting('shop');
  	 $set['logo']=tomedia($set['logo']);
    $canrefund = false;
    if ($order['status'] == 1) {
        $canrefund = true;
    } else if ($order['status'] == 3) {
        if ($order['isverify'] != 1 && empty($order['virtual'])) {
            $tradeset   = globalSetting('trade');
            $refunddays = intval($tradeset['refunddays']);
            if ($refunddays > 0) {
                $days = intval((time() - $order['finishtimevalue']) / 3600 / 24);
                if ($days <= $refunddays) {
                    $canrefund = true;
                }
            }
        }
    }
    $order['canrefund'] = $canrefund;
    show_json(1, array(
        'order' => $order,
        'goods' => $goods,
        'address' => $address,
        'carrier' => $carrier,
        'stores' => $stores,
        'isverify' => $isverify,
        'set' => $set
    ));
}
include $this->template('detail');