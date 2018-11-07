<?php
global $_W, $_GPC;
$openid   = m('user')->getOpenid(true);
if(allow_commission()==false)
{
header("Location:".create_url('mobile',array('act' => 'shopwap','do' => 'membercenter'))	);
exit;
}

$tabwidth = "50";
$set = globalSetting('commission');
if(empty($set['level']))
{
header("Location:".create_url('mobile',array('do'=>'shop','act'=>'index','m'=>'eshop')));
exit;
}
if ($set['level'] >= 1) {
    $tabwidth = 100;
}
if ($set['level'] >= 2) {
    $tabwidth = 50;
}
if ($set['level'] >= 3) {
    $tabwidth = 33.3;
}
$member = m('commission')->getInfo($openid);
$total  = $member['agentcount'];
$level  = intval($_GPC['level']);
($level > 3 || $level <= 0) && $level = 1;
$condition = '';
$level1    = $member['level1'];
$level2    = $member['level2'];
$level3    = $member['level3'];
$hasangent = false;
if ($level == 1) {
    if ($level1 > 0) {
        $condition = " and agentid={$member['id']}";
        $hasangent = true;
    }
} else if ($level == 2) {
    if ($level2 > 0) {
        $condition = " and agentid in( " . implode(',', array_keys($member['level1_agentids'])) . ")";
        $hasangent = true;
    }
} else if ($level == 3) {
    if ($level3 > 0) {
        $condition = " and agentid in( " . implode(',', array_keys($member['level2_agentids'])) . ")";
        $hasangent = true;
    }
}
if ($_W['isajax']) {
    $pindex = max(1, intval($_GPC['page']));
    $psize  = 20;
    $list   = array();
    if ($hasangent) {
        $list = pdo_fetchall("select * from " . tablename('eshop_member') . " where isagent =1 and status=1 and uniacid = " . $_W['uniacid'] . " {$condition}  ORDER BY agenttime desc limit " . ($pindex - 1) * $psize . ',' . $psize);
        foreach ($list as &$row) {
            $info                    = m('commission')->getInfo($row['openid'], array(
                'total'
            ));
            $row['commission_total'] = $info['commission_total'];
            $row['agentcount']       = $info['agentcount'];
            $row['agenttime']        = date('Y-m-d H:i', $row['agenttime']);
        }
    }
    unset($row);
    show_json(1, array(
        'list' => $list,
        'pagesize' => $psize
    ));
}
include $this->template('team');