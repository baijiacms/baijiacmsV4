<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
$commission_set = globalSetting('commission');
$op     = $operation = $_GPC['op'] ? $_GPC['op'] : 'display';
$groups = m('member')->getGroups();
$levels = m('member')->getLevels();
$shop   = globalSetting('shop');
if ($op == 'display') {
    $pindex    = max(1, intval($_GPC['page']));
    $psize     = 20;
    $condition = " and dm.uniacid=:uniacid";
    $params    = array(
        ':uniacid' => $_W['uniacid']
    );
    if (!empty($_GPC['realname'])) {
        $_GPC['realname'] = trim($_GPC['realname']);
        $condition .= ' and ( dm.realname like :realname or dm.nickname like :realname or dm.mobile like :realname or dm.openid=:ropenid)';
        $params[':realname'] = "%{$_GPC['realname']}%";
         $params[':ropenid'] = "{$_GPC['realname']}";
    }
    if (empty($starttime) || empty($endtime)) {
        $starttime = strtotime('-1 month');
        $endtime   = time();
    }
    if (!empty($_GPC['time'])) {
        $starttime = strtotime($_GPC['time']['start']);
        $endtime   = strtotime($_GPC['time']['end']);
        if ($_GPC['searchtime'] == '1') {
            $condition .= " AND dm.createtime >= :starttime AND dm.createtime <= :endtime ";
            $params[':starttime'] = $starttime;
            $params[':endtime']   = $endtime;
        }
    }
    if ($_GPC['level'] != '') {
        $condition .= ' and dm.level=' . intval($_GPC['level']);
    }
    if ($_GPC['groupid'] != '') {
        $condition .= ' and dm.groupid=' . intval($_GPC['groupid']);
    }
 
    if ($_GPC['isblack'] != '') {
        $condition .= ' and dm.isblack=' . intval($_GPC['isblack']);
    }
    $sql = "select dm.*,l.levelname,g.groupname,a.nickname as agentnickname,a.avatar as agentavatar from " . tablename('eshop_member') . " dm " . " left join " . tablename('eshop_member_group') . " g on dm.groupid=g.id" . " left join " . tablename('eshop_member') . " a on a.id=dm.agentid" . " left join " . tablename('eshop_member_level') . " l on dm.level =l.id"  . " where 1 {$condition}  ORDER BY dm.id DESC";
    if (empty($_GPC['export'])) {
        $sql .= " limit " . ($pindex - 1) * $psize . ',' . $psize;
    }
    $list = pdo_fetchall($sql, $params);
    foreach ($list as &$row) {
        $row['levelname']  = empty($row['levelname']) ? (empty($shop['levelname']) ? '普通会员' : $shop['levelname']) : $row['levelname'];
        $row['ordercount'] = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_order') . ' where uniacid=:uniacid and openid=:openid and status=3', array(
            ':uniacid' => $_W['uniacid'],
            ':openid' => $row['openid']
        ));
        $row['ordermoney'] = pdo_fetchcolumn('select sum(goodsprice) from ' . tablename('eshop_order') . ' where uniacid=:uniacid and openid=:openid and status=3', array(
            ':uniacid' => $_W['uniacid'],
            ':openid' => $row['openid']
        ));
        $row['credit1']    = m('member')->getCredit($row['openid'], 'credit1');
        $row['credit2']    = m('member')->getCredit($row['openid'], 'credit2');
        $row['followed']   = m('user')->followed($row['openid']);
    }
    unset($row);
    if ($_GPC['export'] == '1') {
        foreach ($list as &$row) {
            $row['createtime'] = date('Y-m-d H:i', $row['createtime']);
            $row['groupname']  = empty($row['groupname']) ? '无分组' : $row['groupname'];
            $row['levelname']  = empty($row['levelname']) ? '普通会员' : $row['levelname'];
        }
        unset($row);
        m('excel')->export($list, array(
            "title" => "会员数据-" . date('Y-m-d-H-i', time()),
            "columns" => array(
                array(
                    'title' => '昵称',
                    'field' => 'nickname',
                    'width' => 12
                ),
                array(
                    'title' => '姓名',
                    'field' => 'realname',
                    'width' => 12
                ),
                array(
                    'title' => '手机号',
                    'field' => 'mobile',
                    'width' => 12
                ),
                array(
                    'title' => '会员等级',
                    'field' => 'levelname',
                    'width' => 12
                ),
                array(
                    'title' => '会员分组',
                    'field' => 'groupname',
                    'width' => 12
                ),
                array(
                    'title' => '注册时间',
                    'field' => 'createtime',
                    'width' => 12
                ),
                array(
                    'title' => '积分',
                    'field' => 'credit1',
                    'width' => 12
                ),
                array(
                    'title' => '余额',
                    'field' => 'credit2',
                    'width' => 12
                ),
                array(
                    'title' => '成交订单数',
                    'field' => 'ordercount',
                    'width' => 12
                ),
                array(
                    'title' => '成交总金额',
                    'field' => 'ordermoney',
                    'width' => 12
                )
            )
        ));
    }
    $total           = pdo_fetchcolumn("select count(*) from" . tablename('eshop_member') . " dm " . " left join " . tablename('eshop_member_group') . " g on dm.groupid=g.id" . " left join " . tablename('eshop_member_level') . " l on dm.level =l.id" .  " where 1 {$condition} ", $params);
    $pager           = pagination($total, $pindex, $psize);
   	$opencommission = true;
} else if ($op == 'detail') {
    $hascommission = false;
    $p_com    = p('commission');
    if ($p_com) {
         $p_com_set =globalSetting('commission');
        $hascommission  = !empty($p_com_set['level']);
    }
    $id = intval($_GPC['id']);
         $member = m('member')->getMember($id);
      

      
    if (checksubmit('submit')) {
        $data = is_array($_GPC['data']) ? $_GPC['data'] : array();
        	if(empty($member['openid']))
        {
        message("未找到用户信息");	
        }
      	if(empty($data['mobile']))
        {
        message("手机号不能为空");	
        }
      	

                  if(!empty($data['mobile']))
                    {
                     $is_update_member_mobile=update_member_mobile($member['openid'],$data['mobile']);
                      if( $is_update_member_mobile==-1)
					            {
					                  message($data['mobile']."手机号已经被其他用户注册。");
					          	 }
					          }
					          if(!empty($data['upassword']))
                    {
                    	     pdo_update('base_member', array('pwd'=> md5($data['upassword'])), array(
                        'openid' => $member['openid'],
                        'beid' => $_W['uniacid']
                    ));
                    
                    }
           
      
			 unset($data['mobile']);
        unset($data['upassword']);
        pdo_update('eshop_member', $data, array(
            'id' => $id,
            'uniacid' => $_W['uniacid']
        ));
          
      
   
        if ($hascommission) {
          
                $adata = is_array($_GPC['adata']) ? $_GPC['adata'] : array();
                if (!empty($adata)) {
                 
					          
					          
					                	if (!empty($adata['isagent'])) {
       		$adata['status']=1;
       		if (empty($member['isagent'])) {
			       		 $p_com->sendMessage($member['openid'], array(
			        'nickname' => $member['nickname'],
			        'agenttime' => time()
			    ), TM_COMMISSION_BECOME);
			    if (!empty($member['agentid'])) {
			        $p_com->upgradeLevelByAgent($member['agentid']);
			    }
       	}
       		
       	}else
       	{
       		$adata['status']=0;
       	}
					          
					          
                     unset($adata['mobile']);
                       unset($adata['upassword']);
                     pdo_update('eshop_member', $adata, array(
                        'id' => $id,
                        'uniacid' => $_W['uniacid']
                    ));
                    
                    if (empty($_GPC['oldstatus']) && $adata['status'] == 1) {
                        if (!empty($member['agentid'])) {
                            $p_com->upgradeLevelByAgent($member['agentid']);
                        }
                    }
                }
          
        }
        message('保存成功!', $this->createWebUrl('member/list'), 'success');
    }
    if ($hascommission) {
        $agentlevels = $p_com->getLevels();
    }

 
    $member['self_ordercount'] = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_order') . ' where uniacid=:uniacid and openid=:openid and status=3', array(
        ':uniacid' => $_W['uniacid'],
        ':openid' => $member['openid']
    ));
    $member['self_ordermoney'] = pdo_fetchcolumn('select sum(goodsprice) from ' . tablename('eshop_order') . ' where uniacid=:uniacid and openid=:openid and status=3', array(
        ':uniacid' => $_W['uniacid'],
        ':openid' => $member['openid']
    ));
    if (!empty($member['agentid'])) {
        $parentagent = m('member')->getMember($member['agentid']);
    }
	   $member['base_member'] = mysqld_select("SELECT * FROM ".table('base_member')." where  openid=:openid and beid=:beid  limit 1", array(':beid'=> $_W['uniacid'],':openid' =>  $member['openid']));
				
} else if ($op == 'delete') {

    $id      = intval($_GPC['id']);
    $isagent = intval($_GPC['isagent']);
    $member  = pdo_fetch("select * from " . tablename('eshop_member') . " where uniacid=:uniacid and id=:id limit 1 ", array(
        ':uniacid' => $_W['uniacid'],
        ':id' => $id
    ));
    if (empty($member)) {
        message('会员不存在，无法删除!', $this->createWebUrl('member/list'), 'error');
    }

        $agentcount = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_member') . ' where  uniacid=:uniacid and agentid=:agentid limit 1 ', array(
            ':uniacid' => $_W['uniacid'],
            ':agentid' => $id
        ));
        if ($agentcount > 0) {
            message('此会员有下线存在，无法删除! ', '', 'error');
        }
    pdo_delete('base_member', array(
        'openid' => $member['openid']
    ));
    pdo_delete('eshop_member', array(
        'id' => $_GPC['id']
    ));
    message('删除成功！', $this->createWebUrl('member/list'), 'success');
} else if ($operation == 'setblack') {
    $id     = intval($_GPC['id']);
    $member = pdo_fetch("select * from " . tablename('eshop_member') . " where uniacid=:uniacid and id=:id limit 1 ", array(
        ':uniacid' => $_W['uniacid'],
        ':id' => $id
    ));
    if (empty($member)) {
        message('会员不存在，无法设置黑名单!', $this->createWebUrl('member/list'), 'error');
    }
    $black = intval($_GPC['black']);
    if (!empty($black)) {
    	 pdo_update('base_member', array(
            'isblack' => 1
        ), array(
        'openid' => $member['openid']
    ));
        pdo_update('eshop_member', array(
            'isblack' => 1
        ), array(
            'id' => $_GPC['id']
        ));
         message('设置黑名单成功！', $this->createWebUrl('member/list'), 'success');
    } else {
    		 pdo_update('base_member', array(
            'isblack' => 0
        ), array(
        'openid' => $member['openid']
    ));
        pdo_update('eshop_member', array(
            'isblack' => 0
        ), array(
            'id' => $_GPC['id']
        ));
        message('取消黑名单成功！', $this->createWebUrl('member/list'), 'success');
    }
}

include $this->template('list');