<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
if (!class_exists('OrderModel')) {
class OrderModel
{
    function getDispatchPrice($weight, $d)
    {
        if (empty($d)) {
            return 0;
        }
        $price = 0;
        if ($weight <= $d['firstweight']) {
            $price = floatval($d['firstprice']);
        } else {
            $price         = floatval($d['firstprice']);
            $secondweight  = $weight - floatval($d['firstweight']);
            $dsecondweight = floatval($d['secondweight']) <= 0 ? 1 : floatval($d['secondweight']);
            $secondprice   = 0;
            if ($secondweight % $dsecondweight == 0) {
                $secondprice = ($secondweight / $dsecondweight) * floatval($d['secondprice']);
            } else {
                $secondprice = ((int) ($secondweight / $dsecondweight) + 1) * floatval($d['secondprice']);
            }
            $price += $secondprice;
        }
        return $price;
    }
	function getCityDispatchPrice($_var_6, $_var_7, $weight, $d)
	{
		if (is_array($_var_6) && count($_var_6) > 0) {
			foreach ($_var_6 as $_var_8) {
				$_var_9 = explode(';', $_var_8['citys']);
				if (in_array($_var_7, $_var_9) && !empty($_var_9)) {
					return $this->getDispatchPrice($weight, $_var_8);
				}
			}
		}
		return $this->getDispatchPrice($weight, $d);
	}
    public function payResult($params)
    {
        global $_W;
        $fee     = intval($params['fee']);
        $data    = array(
            'status' => $params['result'] == 'success' ? 1 : 0
        );
        $ordersn = $params['tid'];
        $order   = pdo_fetch('select id,ordersn, price,openid,dispatchtype,addressid,carrier,status,isverify,virtual,isvirtual from ' . tablename('eshop_order') . ' where  ordersn=:ordersn and uniacid=:uniacid limit 1', array(
            ':uniacid' => $_W['uniacid'],
            ':ordersn' => $ordersn
        ));
        $orderid = $order['id'];
        if ($params['from'] == 'return') {
            $address = false;
            if (empty($order['dispatchtype'])) {
                $address = pdo_fetch('select realname,mobile,address from ' . tablename('eshop_member_address') . ' where id=:id limit 1', array(
                    ':id' => $order['addressid']
                ));
            }
            $carrier = false;
            if ($order['dispatchtype'] == 1 || $order['isvirtual'] == 1) {
                $carrier = unserialize($order['carrier']);
            }
            if ($params['type'] == 'cash') {
                return array(
                    'result' => 'success',
                    'order' => $order,
                    'address' => $address,
                    'carrier' => $carrier
                );
            } else {
                if ($order['status'] == 0) {
                    $pv = p('virtual');
                    if (!empty($order['virtual']) && $pv) {
                        $pv->pay($order);
                    } else {
                        pdo_update('eshop_order', array(
                            'status' => 1,
                            'paytime' => time()
                        ), array(
                            'id' => $orderid
                        ));
                       
                        $this->setStocksAndCredits($orderid, 1);
			if ( !empty($order['couponid'])) {
				p('coupon')->backConsumeCoupon($order['id']);
		    	}
                        m('notice')->sendOrderMessage($orderid);
                       
                            p('commission')->checkOrderPay($order['id']);
                        
                    }
                }
                return array(
                    'result' => 'success',
                    'order' => $order,
                    'address' => $address,
                    'carrier' => $carrier,
                    'virtual' => $order['virtual']
                );
            }
        }
    }
    function setStocksAndCredits($orderid = '', $type = 0)
    {
        global $_W;
        $order   = pdo_fetch('select id,ordersn,price,openid,dispatchtype,addressid,carrier,status from ' . tablename('eshop_order') . ' where id=:id limit 1', array(
            ':id' => $orderid
        ));
        $goods   = pdo_fetchall("select og.goodsid,og.total,g.totalcnf,og.realprice, g.credit,og.optionid,g.total as goodstotal,og.optionid,g.sales,g.salesreal from " . tablename('eshop_order_goods') . " og " . " left join " . tablename('eshop_goods') . " g on g.id=og.goodsid " . " where og.orderid=:orderid and og.uniacid=:uniacid ", array(
            ':uniacid' => $_W['uniacid'],
            ':orderid' => $orderid
        ));
        $credits = 0;
        foreach ($goods as $g) {
            $stocktype = 0;
            if ($type == 0) {
                if ($g['totalcnf'] == 0) {
                    $stocktype = -1;
                }
            } else if ($type == 1) {
                if ($g['totalcnf'] == 1) {
                    $stocktype = -1;
                }
            } else if ($type == 2) {
                if ($order['status'] >= 1) {
                    if ($g['totalcnf'] == 1) {
                        $stocktype = 1;
                    }
                } else {
                    if ($g['totalcnf'] == 0) {
                        $stocktype = 1;
                    }
                }
            }
            if (!empty($stocktype)) {
                if (!empty($g['optionid'])) {
                    $option = m('goods')->getOption($g['goodsid'], $g['optionid']);
                    if (!empty($option) && $option['stock'] != -1) {
                        $stock = -1;
                        if ($stocktype == 1) {
                            $stock = $option['stock'] + $g['total'];
                        } else if ($stocktype == -1) {
                            $stock = $option['stock'] - $g['total'];
                            $stock <= 0 && $stock = 0;
                        }
                        if ($stock != -1) {
                            pdo_update('eshop_goods_option', array(
                                'stock' => $stock
                            ), array(
                                'uniacid' => $_W['uniacid'],
                                'goodsid' => $g['goodsid'],
                                'id' => $g['optionid']
                            ));
                        }
                    }
                }
                if (!empty($g['goodstotal']) && $g['goodstotal'] != -1) {
                    $totalstock = -1;
                    if ($stocktype == 1) {
                        $totalstock = $g['goodstotal'] + $g['total'];
                    } else if ($stocktype == -1) {
                        $totalstock = $g['goodstotal'] - $g['total'];
                        $totalstock <= 0 && $totalstock = 0;
                    }
                    if ($totalstock != -1) {
                        pdo_update('eshop_goods', array(
                            'total' => $totalstock
                        ), array(
                            'uniacid' => $_W['uniacid'],
                            'id' => $g['goodsid']
                        ));
                    }
                }
            }
            $gcredit = trim($g['credit']);
            if (!empty($gcredit)) {
                if (strexists($gcredit, '%')) {
                    $credits += intval(floatval(str_replace('%', '', $gcredit)) / 100 * $g['realprice']);
                } else {
                    $credits += intval($g['credit']) * $g['total'];
                }
            }
            if ($type == 0) {
                pdo_update('eshop_goods', array(
                    'sales' => $g['sales'] + $g['total']
                ), array(
                    'uniacid' => $_W['uniacid'],
                    'id' => $g['goodsid']
                ));
            } elseif ($type == 1) {
                if ($order['status'] >= 1) {
                    $salesreal = pdo_fetchcolumn('select ifnull(sum(total),0) from ' . tablename('eshop_order_goods') . ' og ' . ' left join ' . tablename('eshop_order') . ' o on o.id = og.orderid ' . ' where og.goodsid=:goodsid and o.status>=1 and o.uniacid=:uniacid limit 1', array(
                        ':goodsid' => $g['goodsid'],
                        ':uniacid' => $_W['uniacid']
                    ));
                    pdo_update('eshop_goods', array(
                        'salesreal' => $salesreal
                    ), array(
                        'id' => $g['goodsid']
                    ));
                }
            }
        }
        if ($credits > 0) {
            $shopset = m('common')->getSysset('shop');
            if ($type == 1) {
           
                
                	member_credit($order['openid'],$credits,'addcredit', $shopset['name'] . '购物积分 订单号: ' . $order['ordersn']);
                
                
            } elseif ($type == 2) {
                if ($order['status'] >= 1) {
                	
                	member_credit($order['openid'],$credits,'addcredit', $shopset['name'] . '购物取消订单扣除积分 订单号: ' . $order['ordersn']);
                
                	
               
                }
            }
        }
    }
    
    
    
    
    function getDefaultDispatch(){
        global $_W;
        $dephp_31 = 'select * from ' . tablename('eshop_dispatch') . ' where isdefault=1 and uniacid=:uniacid and enabled=1 Limit 1';
        $dephp_11 = array(':uniacid' => $_W['uniacid']);
        $dephp_13 = pdo_fetch($dephp_31, $dephp_11);
        return $dephp_13;
    }
    function getNewDispatch(){
        global $_W;
        $dephp_31 = 'select * from ' . tablename('eshop_dispatch') . ' where uniacid=:uniacid and enabled=1 order by id desc Limit 1';
        $dephp_11 = array(':uniacid' => $_W['uniacid']);
        $dephp_13 = pdo_fetch($dephp_31, $dephp_11);
        return $dephp_13;
    }
    function getOneDispatch($dephp_32){
        global $_W;
        $dephp_31 = 'select * from ' . tablename('eshop_dispatch') . ' where id=:id and uniacid=:uniacid and enabled=1 Limit 1';
        $dephp_11 = array(':id' => $dephp_32, ':uniacid' => $_W['uniacid']);
        $dephp_13 = pdo_fetch($dephp_31, $dephp_11);
        return $dephp_13;
    }
    
    
}
}