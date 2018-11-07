<?php
global $_W, $_GPC;
$openid = m('user')->getOpenid(true);
if(allow_commission()==false)
{
header("Location:".create_url('mobile',array('act' => 'shopwap','do' => 'membercenter'))	);
exit;
}

$set = globalSetting('commission');
if(empty($set['level']))
{
header("Location:".create_url('mobile',array('do'=>'shop','act'=>'index','m'=>'eshop')));
exit;
}
	  $emember    = m('member')->getMember($openid);
	 if (empty($emember["weixin"]) ) {
          message("请先完善您的微信号",create_url('mobile',array('act' => 'shopwap','do' => 'info')),'error');
    }
if ($_W['isajax']) {
    $level                   = $set['level'];
    $member                  = m('commission')->getInfo($openid, array(
        'ok'
    ));
    $time                    = time();
    $day_times               = intval($set['settledays']) * 3600 * 24;
    $commission_ok           = $member['commission_ok'];
    $cansettle               = $commission_ok >= floatval($set['withdraw']);
    $member['commission_ok'] = number_format($commission_ok, 2);
    if ($_W['ispost']) {
        $orderids = array();
        if ($level >= 1) {
            $level1_orders = pdo_fetchall('select distinct o.id from ' . tablename('eshop_order') . ' o ' . ' left join  ' . tablename('eshop_order_goods') . ' og on og.orderid=o.id ' . " where o.agentid=:agentid and o.status>=3  and og.status1=0 and og.nocommission=0 and ({$time} - o.createtime > {$day_times}) and o.uniacid=:uniacid  group by o.id", array(
                ':uniacid' => $_W['uniacid'],
                ':agentid' => $member['id']
            ));
            foreach ($level1_orders as $o) {
                if (empty($o['id'])) {
                    continue;
                }
                $orderids[] = array(
                    'orderid' => $o['id'],
                    'level' => 1
                );
            }
        }
        if ($level >= 2) {
            if ($member['level1'] > 0) {
                $level2_orders = pdo_fetchall('select distinct o.id from ' . tablename('eshop_order') . ' o ' . ' left join  ' . tablename('eshop_order_goods') . ' og on og.orderid=o.id ' . " where o.agentid in( " . implode(',', array_keys($member['level1_agentids'])) . ")  and o.status>=3  and og.status2=0 and og.nocommission=0 and ({$time} - o.createtime > {$day_times}) and o.uniacid=:uniacid  group by o.id", array(
                    ':uniacid' => $_W['uniacid']
                ));
                foreach ($level2_orders as $o) {
                    if (empty($o['id'])) {
                        continue;
                    }
                    $orderids[] = array(
                        'orderid' => $o['id'],
                        'level' => 2
                    );
                }
            }
        }
        if ($level >= 3) {
            if ($member['level2'] > 0) {
                $level3_orders = pdo_fetchall('select distinct o.id from ' . tablename('eshop_order') . ' o ' . ' left join  ' . tablename('eshop_order_goods') . ' og on og.orderid=o.id ' . " where o.agentid in( " . implode(',', array_keys($member['level2_agentids'])) . ")  and o.status>=3  and  og.status3=0 and og.nocommission=0 and ({$time} - o.createtime > {$day_times})   and o.uniacid=:uniacid  group by o.id", array(
                    ':uniacid' => $_W['uniacid']
                ));
                foreach ($level3_orders as $o) {
                    if (empty($o['id'])) {
                        continue;
                    }
                    $orderids[] = array(
                        'orderid' => $o['id'],
                        'level' => 3
                    );
                }
            }
        }
           if(!empty($set['closetocredit'])&&empty($_GPC["type"])) {
    	    show_json(0, '余额提现已关闭无法提现到余额账户。');
    	    exit;
    }
        $time = time();
        foreach ($orderids as $o) {
            pdo_update('eshop_order_goods', array(
                'status' . $o['level'] => 1,
                'applytime' . $o['level'] => $time
            ), array(
                'orderid' => $o['orderid'],
                'uniacid' => $_W['uniacid']
            ));
        }
        $applyno = m('common')->createNO('commission_apply', 'applyno', 'CA');
 
        $apply   = array(
            'uniacid' => $_W['uniacid'],
            'applyno' => $applyno,
            'orderids' => iserializer($orderids),
            'mid' => $member['id'],
            'commission' => $commission_ok,
             "type" => intval($_GPC["type"]) ,
            'status' => 1,
            'applytime' => $time
        );
        pdo_insert('eshop_commission_apply', $apply);
        $returnurl = urlencode($this->createMobileUrl('member/withdraw'));
        $infourl   = $this->createMobileUrl('member/info', array(
            'returnurl' => $returnurl
        ));
        m('commission')->sendMessage($openid, array(
            'commission' => $commission_ok,
            'type' => $apply['type'] == 1 ? '微信' : '余额'
        ), TM_COMMISSION_APPLY);
        show_json(1, '已提交,请等待审核!');
        exit;
    }
    $returnurl = urlencode($this->createMobileUrl('commission/apply'));
    $infourl   = $this->createMobileUrl('member/info', array(
        'returnurl' => $returnurl
    ));
    show_json(1, array(
        'commission_ok' => $member['commission_ok'],
        'cansettle' => $cansettle,
        'member' => $member,
        'set' => $set,
        'infourl' => $infourl,
        'noinfo' => empty($member['realname'])
    ));
    exit;
}
include $this->template('apply');