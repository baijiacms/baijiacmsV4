<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
if (!class_exists('CouponModel')) {
    class CouponModel
    {
    		public function getSet($key='coupon')
	    	{
	    		
	    	return globalSetting($key);	
	    	}
        function get_last_count($couponid = 0)
        {
            global $_W;
            $coupon = pdo_fetch('SELECT id,total FROM ' . tablename('eshop_coupon') . ' WHERE id=:id and uniacid=:uniacid ', array(
                ':id' => $couponid,
                ':uniacid' => $_W['uniacid']
            ));
            if (empty($coupon)) {
                return 0;
            }
            if ($coupon['total'] == -1) {
                return -1;
            }
            $gettotal = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_coupon_data') . ' where couponid=:couponid and uniacid=:uniacid limit 1', array(
                ':couponid' => $couponid,
                ':uniacid' => $_W['uniacid']
            ));
            return $coupon['total'] - $gettotal;
        }
      
        function poster($member, $couponid, $couponnum)
        {
            global $_W, $_GPC;
            $pposter = p('poster');
            if (!$pposter) {
                return;
            }
            $coupon = $this->getCoupon($couponid);
            if (empty($coupon)) {
                return;
            }
            for ($i = 1; $i <= $couponnum; $i++) {
                $couponlog = array(
                    'uniacid' => $_W['uniacid'],
                    'openid' => $member['openid'],
                    'logno' => m('common')->createNO('coupon_log', 'logno', 'CC'),
                    'couponid' => $couponid,
                    'status' => 1,
                    'paystatus' => -1,
                    'creditstatus' => -1,
                    'createtime' => time(),
                    'getfrom' => 3
                );
                pdo_insert('eshop_coupon_log', $couponlog);
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'openid' => $member['openid'],
                    'couponid' => $couponid,
                    'gettype' => 3,
                    'gettime' => time()
                );
                pdo_insert('eshop_coupon_data', $data);
            }
            $set = $this->getSet();
            $this->sendMessage($coupon, $couponnum, $member, $set['coupon_templateid']);
        }
        function payResult($logno)
        {
            global $_W;
            if (empty($logno)) {
                return error(-1);
            }
            $log = pdo_fetch('SELECT * FROM ' . tablename('eshop_coupon_log') . ' WHERE `logno`=:logno and `uniacid`=:uniacid  limit 1', array(
                ':uniacid' => $_W['uniacid'],
                ':logno' => $logno
            ));
            if (empty($log)) {
                return error(-1, '服务器错误!');
            }
            if ($log['status'] >= 1) {
                return true;
            }
            $coupon = pdo_fetch('select * from ' . tablename('eshop_coupon') . ' where id=:id limit 1', array(
                ':id' => $log['couponid']
            ));
            $coupon = $this->setCoupon($coupon, time());
            if (empty($coupon['gettype'])) {
                return error(-1, '无法领取');
            }
            if ($coupon['total'] != -1) {
                if ($coupon['total'] <= 0) {
                    return error(-1, '优惠券数量不足');
                }
            }
            if (!$coupon['canget']) {
                return error(-1, '您已超出领取次数限制');
            }
            if (empty($log['status'])) {
                $update = array();
                if ($coupon['credit'] > 0 && empty($log['creditstatus'])) {
                	
                        member_credit($order['openid'],$coupon['credit'],'usecredit',"购买优惠券扣除积分 {$coupon['credit']}");
                	
                    $update['creditstatus'] = 1;
                }
                if ($coupon['money'] > 0 && empty($log['paystatus'])) {
                    if ($coupon['paytype'] == 0) {
                    	member_gold($log['openid'],$coupon['money'],'usegold',"购买优惠券扣除余额 {$coupon['money']}");
                    }
                    $update['paystatus'] = 1;
                }
                $update['status'] = 1;
                pdo_update('eshop_coupon_log', $update, array(
                    'id' => $log['id']
                ));
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'openid' => $log['openid'],
                    'couponid' => $log['couponid'],
                    'gettype' => $log['getfrom'],
                    'gettime' => time()
                );
                pdo_insert('eshop_coupon_data', $data);
                $member = m('member')->getMember($log['openid']);
                $set    = $this->getSet();
                $this->sendMessage($coupon, 1, $member, $set['coupon_templateid']);
            }
            
             
            
            $url = WEBSITE_ROOT . create_url('mobile',array('do'=>'member','act'=>'center','m'=>'eshop'));
            if ($coupon['coupontype'] == 0) {
                $url = WEBSITE_ROOT . create_url('mobile',array('do'=>'shop','act'=>'list','m'=>'eshop'));
            } else {
                $url = WEBSITE_ROOT . create_url('mobile',array('do'=>'member','act'=>'recharge','m'=>'eshop'));
            }
          
            return array(
                'url' => $url
            );
        }
        function sendMessage($coupon, $send_total, $member, $templateid = '', $account = null)
        {
        	reutrn;
            global $_W;
            $articles = array();
            $title    = str_replace('[nickname]', $member['nickname'], $coupon['resptitle']);
            $desc     = str_replace('[nickname]', $member['nickname'], $coupon['respdesc']);
            $title    = str_replace('[total]', $send_total, $title);
            $desc     = str_replace('[total]', $send_total, $desc);
            $url      = empty($coupon['respurl']) ? $_W['siteroot'] . create_url('mobile',array('act' => 'my','do' => 'coupon','m'=>'eshop')) : $coupon['respurl'];
            if (!empty($coupon['resptitle'])) {
                $articles[] = array(
                    "title" => urlencode($title),
                    "description" => urlencode($desc),
                    "url" => $url,
                    "picurl" => tomedia($coupon['respthumb'])
                );
            }
            if (!empty($articles)) {
                $resp = m('message')->sendNews($member['openid'], $articles, $account);
                if (is_error($resp)) {
                    $msg = array(
                        'keyword1' => array(
                            'value' => $title,
                            "color" => "#73a68d"
                        ),
                        'keyword2' => array(
                            'value' => $desc,
                            "color" => "#73a68d"
                        )
                    );
                    if (!empty($templateid)) {
                        m('message')->sendTplNotice($member['openid'], $templateid, $msg, $url);
                    }
                }
            }
        }
        function sendBackMessage($openid, $coupon, $gives)
        {
            global $_W;
            if (empty($gives)) {
                return;
            }
            $set        = $this->getSet();
            $templateid = $set['coupon_templateid'];
            $content    = "您的优惠券【{$coupon['couponname']}】已返利 ";
            $givestr    = '';
            if (isset($gives['credit'])) {
                $givestr .= " {$gives['credit']}个积分";
            }
            if (isset($gives['money'])) {
                if (!empty($givestr)) {
                    $givestr .= "，";
                }
                $givestr .= "{$gives['money']}元余额";
            }
            if (isset($gives['redpack'])) {
                if (!empty($givestr)) {
                    $givestr .= "，";
                }
                $givestr .= "{$gives['redpack']}元现金";
            }
            $content .= $givestr;
            $content .= "，请查看您的账户，谢谢!";
            $msg = array(
                'keyword1' => array(
                    'value' => "优惠券返利",
                    "color" => "#73a68d"
                ),
                'keyword2' => array(
                    'value' => $content,
                    "color" => "#73a68d"
                )
            );
           
            $url =  WEBSITE_ROOT . create_url('mobile',array('do'=>'member','act'=>'center','m'=>'eshop'));
         
            if (!empty($templateid)) {
                m('message')->sendTplNotice($openid, $templateid, $msg, $url);
            } else {
                m('message')->sendCustomNotice($openid, $msg, $url);
            }
        }
        function sendReturnMessage($openid, $coupon)
        {
            global $_W;
            $set        = $this->getSet();
            $templateid = $set['coupon_templateid'];
            $msg        = array(
                'keyword1' => array(
                    'value' => "优惠券退回",
                    "color" => "#73a68d"
                ),
                'keyword2' => array(
                    'value' => "您的优惠券【{$coupon['couponname']}】已退回您的账户，您可以再次使用, 谢谢!",
                    "color" => "#73a68d"
                )
            );
             
            $url        = WEBSITE_ROOT . create_url('mobile',array('do'=>'coupon','act'=>'my','m'=>'eshop'));
            if (!empty($templateid)) {
                m('message')->sendTplNotice($openid, $templateid, $msg, $url);
            } else {
                m('message')->sendCustomNotice($openid, $msg, $url);
            }
        }
        function useRechargeCoupon($log)
        {
            global $_W;
            if (empty($log['couponid'])) {
                return;
            }
            $data = pdo_fetch('select id,openid,couponid,used from ' . tablename('eshop_coupon_data') . ' where id=:id and uniacid=:uniacid limit 1', array(
                ':id' => $log['couponid'],
                ':uniacid' => $_W['uniacid']
            ));
            if (empty($data)) {
                return;
            }
            if (!empty($data['used'])) {
                return;
            }
            $coupon = pdo_fetch('select enough,backcredit,backmoney from ' . tablename('eshop_coupon') . ' where id=:id and uniacid=:uniacid limit 1', array(
                ':id' => $data['couponid'],
                ':uniacid' => $_W['uniacid']
            ));
            if (empty($coupon)) {
                return;
            }
            if ($coupon['enough'] > 0 && $log['money'] < $coupon['enough']) {
                return;
            }
            $gives      = array();
            $backcredit = $coupon['backcredit'];
            if (!empty($backcredit)) {
                if (strexists($backcredit, '%')) {
                    $backcredit = intval(floatval(str_replace('%', '', $backcredit)) / 100 * $log['money']);
                } else {
                    $backcredit = intval($backcredit);
                }
                if ($backcredit > 0) {
                    $gives['credit'] = $backcredit;
                    member_credit($data['openid'],$backcredit,'addcredit','充值优惠券返积分');
                    
                }
            }
            $backmoney = $coupon['backmoney'];
            if (!empty($backmoney)) {
                if (strexists($backmoney, '%')) {
                    $backmoney = round(floatval(floatval(str_replace('%', '', $backmoney)) / 100 * $log['money']), 2);
                } else {
                    $backmoney = round(floatval($backmoney), 2);
                }
                if ($backmoney > 0) {
                    $gives['money'] = $backmoney;
                    	member_gold($data['openid'],$backmoney,'usegold','充值优惠券返利');
                    
                }
            }
          
            pdo_update('eshop_coupon_data', array(
                'used' => 1,
                'usetime' => time(),
                'ordersn' => $log['logno']
            ), array(
                'id' => $data['id']
            ));
            $this->sendBackMessage($log['openid'], $coupon, $gives);
        }
        function consumeCouponCount($openid, $money = 0)
        {
            global $_W, $_GPC;
            $time = time();
            $sql  = "select count(*) from " . tablename('eshop_coupon_data') . " d " . "  left join " . tablename('eshop_coupon') . " c on d.couponid = c.id " . "  where d.openid=:openid and d.uniacid=:uniacid and  c.coupontype=0 and {$money}>=c.enough and d.used=0 " . " and (   (c.timelimit = 0 and ( c.timedays=0 or c.timedays*86400 + d.gettime >=unix_timestamp() ) )  or  (c.timelimit =1 and c.timestart<={$time} && c.timeend>={$time}))";
            return pdo_fetchcolumn($sql, array(
                ':openid' => $openid,
                ':uniacid' => $_W['uniacid']
            ));
        }
        function useConsumeCoupon($orderid = 0)
        {
            global $_W, $_GPC;
            if (empty($orderid)) {
                return;
            }
            $order = pdo_fetch('select ordersn,createtime,couponid from ' . tablename('eshop_order') . ' where id=:id and status>=0 and uniacid=:uniacid limit 1', array(
                ':id' => $orderid,
                ':uniacid' => $_W['uniacid']
            ));
            if (empty($order)) {
                return;
            }
            $coupon = false;
            if (!empty($order['couponid'])) {
                $coupon = $this->getCouponByDataID($order['couponid']);
            }
            if (empty($coupon)) {
                return;
            }
            pdo_update('eshop_coupon_data', array(
                'used' => 1,
                'usetime' => $order['createtime'],
                'ordersn' => $order['ordersn']
            ), array(
                'id' => $order['couponid']
            ));
        }
        function returnConsumeCoupon($order)
        {
            global $_W;
            if (!is_array($order)) {
                $order = pdo_fetch('select id,openid,ordersn,createtime,couponid,status,finishtime from ' . tablename('eshop_order') . ' where id=:id and status>=0 and uniacid=:uniacid limit 1', array(
                    ':id' => intval($order),
                    ':uniacid' => $_W['uniacid']
                ));
            }
            if (empty($order)) {
                return;
            }
            $coupon = $this->getCouponByDataID($order['couponid']);
            if (empty($coupon)) {
                return;
            }
            if (!empty($coupon['returntype'])) {
                if (!empty($coupon['used'])) {
                    pdo_update('eshop_coupon_data', array(
                        'used' => 0,
                        'usetime' => 0,
                        'ordersn' => ''
                    ), array(
                        'id' => $order['couponid']
                    ));
                    $this->sendReturnMessage($order['openid'], $coupon);
                }
            }
        }
        function backConsumeCoupon($order)
        {
            global $_W;
            if (!is_array($order)) {
                $order = pdo_fetch('select id,openid,ordersn,createtime,couponid,status,finishtime,virtual from ' . tablename('eshop_order') . ' where id=:id and status>=0 and uniacid=:uniacid limit 1', array(
                    ':id' => intval($order),
                    ':uniacid' => $_W['uniacid']
                ));
            }
            if (empty($order)) {
                return;
            }
            $couponid = $order['couponid'];
            if (empty($couponid)) {
                return;
            }
            $coupon = $this->getCouponByDataID($order['couponid']);
            if (empty($coupon)) {
                return;
            }
            if (!empty($coupon['back'])) {
                return;
            }
            $gives   = array();
            $canback = false;
            if ($order['status'] == 1 && $coupon['backwhen'] == 2) {
                $canback = true;
            } else if ($order['status'] == 3) {
                if (!empty($order['virtual'])) {
                    $canback = true;
                } else {
                    if ($coupon['backwhen'] == 1) {
                        $canback = true;
                    } else if ($coupon['backwhen'] == 0) {
                        $canback    = true;
                        $tradeset   = globalSetting('trade');
                        $refunddays = intval($tradeset['refunddays']);
                        if ($refunddays > 0) {
                            $days = intval((time() - $order['finishtime']) / 3600 / 24);
                            if ($days <= $refunddays) {
                                $canback = false;
                            }
                        }
                    }
                }
            }
            if ($canback) {
                $ordermoney = pdo_fetchcolumn('select ifnull( sum(og.realprice),0) from ' . tablename('eshop_order_goods') . ' og ' . ' left join ' . tablename('eshop_order') . ' o on o.id=og.orderid ' . ' where o.id=:orderid and o.openid=:openid and o.uniacid=:uniacid ', array(
                    ':uniacid' => $_W['uniacid'],
                    ':openid' => $order['openid'],
                    ':orderid' => $order['id']
                ));
                $backcredit = $coupon['backcredit'];
                if (!empty($backcredit)) {
                    if (strexists($backcredit, '%')) {
                        $backcredit = intval(floatval(str_replace('%', '', $backcredit)) / 100 * $ordermoney);
                    } else {
                        $backcredit = intval($backcredit);
                    }
                    if ($backcredit > 0) {
                        $gives['credit'] = $backcredit;
                      
                        member_credit($order['openid'],$backcredit,'addcredit','充值优惠券返积分');
                        
                    }
                }
                $backmoney = $coupon['backmoney'];
                if (!empty($backmoney)) {
                    if (strexists($backmoney, '%')) {
                        $backmoney = round(floatval(floatval(str_replace('%', '', $backmoney)) / 100 * $ordermoney), 2);
                    } else {
                        $backmoney = round(floatval($backmoney), 2);
                    }
                    if ($backmoney > 0) {
                        $gives['money'] = $backmoney;
                    
                        
                        
        	member_gold($order['openid'],$backmoney,'addgold','购物优惠券返利');
                        
                    }
                }
             
                pdo_update('eshop_coupon_data', array(
                    'back' => 1,
                    'backtime' => time()
                ), array(
                    'id' => $order['couponid']
                ));
                $this->sendBackMessage($order['openid'], $coupon, $gives);
            }
        }
        function getCoupon($couponid = 0)
        {
            global $_W;
            return pdo_fetch('select * from ' . tablename('eshop_coupon') . ' where id=:id and uniacid=:uniacid limit 1', array(
                ':id' => $couponid,
                ':uniacid' => $_W['uniacid']
            ));
        }
        function getCouponByDataID($dataid = 0)
        {
            global $_W;
            $data = pdo_fetch('select id,openid,couponid,used,back,backtime from ' . tablename('eshop_coupon_data') . ' where id=:id and uniacid=:uniacid limit 1', array(
                ':id' => $dataid,
                ':uniacid' => $_W['uniacid']
            ));
            if (empty($data)) {
                return false;
            }
            $coupon = pdo_fetch('select * from ' . tablename('eshop_coupon') . ' where id=:id and uniacid=:uniacid limit 1', array(
                ':id' => $data['couponid'],
                ':uniacid' => $_W['uniacid']
            ));
            if (empty($coupon)) {
                return false;
            }
            $coupon['back']     = $data['back'];
            $coupon['backtime'] = $data['backtime'];
            $coupon['used']     = $data['used'];
            $coupon['usetime']  = $data['usetime'];
            return $coupon;
        }
        function setCoupon($row, $time, $withOpenid = true)
        {
            global $_W;
            if ($withOpenid) {
                $openid = m('user')->getOpenid(true);
            }
            $row['free']  = false;
            $row['past']  = false;
            $row['thumb'] = tomedia($row['thumb']);
            if ($row['money'] > 0 && $row['credit'] > 0) {
                $row['getstatus']  = 0;
                $row['gettypestr'] = "购买";
            } else if ($row['money'] > 0) {
                $row['getstatus']  = 1;
                $row['gettypestr'] = "购买";
            } else if ($row['credit'] > 0) {
                $row['getstatus']  = 2;
                $row['gettypestr'] = "兑换";
            } else {
                $row['getstatus']  = 3;
                $row['gettypestr'] = "领取";
            }
            $row['timestr'] = "0";
            if (empty($row['timelimit'])) {
                if (!empty($row['timedays'])) {
                    $row['timestr'] = 1;
                }
            } else {
                if ($row['timestart'] >= $time) {
                    $row['timestr'] = date('Y-m-d', $row['timestart']) . '-' . date('Y-m-d', $row['timeend']);
                } else {
                    $row['timestr'] = date('Y-m-d', $row['timeend']);
                }
            }
            $row['css'] = 'deduct';
            if ($row['backtype'] == 0) {
                $row['backstr']    = '立减';
                $row['css']        = 'deduct';
                $row['backpre']    = true;
                $row['_backmoney'] = $row['deduct'];
            } else if ($row['backtype'] == 1) {
                $row['backstr']    = '折';
                $row['css']        = 'discount';
                $row['_backmoney'] = $row['discount'];
            } else if ($row['backtype'] == 2) {
              if (!empty($row['backmoney'])) {
                    $row['backstr']    = '返利';
                    $row['css']        = "money";
                    $row['backpre']    = true;
                    $row['_backmoney'] = $row['backmoney'];
                } else if (!empty($row['backcredit'])) {
                    $row['backstr']    = '返积分';
                    $row['css']        = "credit";
                    $row['_backmoney'] = $row['backcredit'];
                }
            }
            if ($withOpenid) {
                $row['cangetmax'] = -1;
                $row['canget']    = true;
                if ($row['getmax'] > 0) {
                    $gets             = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_coupon_data') . ' where couponid=:couponid and openid=:openid and uniacid=:uniacid and gettype=1 limit 1', array(
                        ':couponid' => $row['id'],
                        ':openid' => $openid,
                        ':uniacid' => $_W['uniacid']
                    ));
                    $row['cangetmax'] = $row['getmax'] - $gets;
                    if ($row['cangetmax'] <= 0) {
                        $row['cangetmax'] = 0;
                        $row['canget']    = false;
                    }
                }
            }
            return $row;
        }
        function setMyCoupon($row, $time)
        {
            global $_W;
            $row['past']    = false;
            $row['thumb']   = tomedia($row['thumb']);
            $row['timestr'] = "";
            if (empty($row['timelimit'])) {
                if (!empty($row['timedays'])) {
                    $row['timestr'] = date('Y-m-d', $row['gettime'] + $row['timedays'] * 86400);
                    if ($row['gettime'] + $row['timedays'] * 86400 < $time) {
                        $row['past'] = true;
                    }
                }
            } else {
                if ($row['timestart'] >= $time) {
                    $row['timestr'] = date('Y-m-d H:i', $row['timestart']) . '-' . date('Y-m-d', $row['timeend']);
                } else {
                    $row['timestr'] = date('Y-m-d H:i', $row['timeend']);
                }
                if ($row['timeend'] < $time) {
                    $row['past'] = true;
                }
            }
            $row['css'] = 'deduct';
            if ($row['backtype'] == 0) {
                $row['backstr']    = '立减';
                $row['css']        = 'deduct';
                $row['backpre']    = true;
                $row['_backmoney'] = $row['deduct'];
            } else if ($row['backtype'] == 1) {
                $row['backstr']    = '折';
                $row['css']        = 'discount';
                $row['_backmoney'] = $row['discount'];
            } else if ($row['backtype'] == 2) {
                 if (!empty($row['backmoney'])) {
                    $row['backstr']    = '返利';
                    $row['css']        = "money";
                    $row['backpre']    = true;
                    $row['_backmoney'] = $row['backmoney'];
                } else if (!empty($row['backcredit'])) {
                    $row['backstr']    = '返积分';
                    $row['css']        = "credit";
                    $row['_backmoney'] = $row['backcredit'];
                }
            }
            if ($row['past']) {
                $row['css'] = 'past';
            }
            return $row;
        }
       
       
    }
}