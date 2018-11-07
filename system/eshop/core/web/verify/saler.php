<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $list = pdo_fetchall("SELECT s.*,m.nickname,m.avatar,m.mobile,m.realname,store.storename FROM " . tablename('eshop_saler') . "  s " . " left join " . tablename('eshop_member') . " m on s.openid=m.openid and m.uniacid = s.uniacid " . " left join " . tablename('eshop_store') . " store on store.id=s.storeid " . " WHERE s.uniacid = '{$_W['uniacid']}' ORDER BY id asc");
} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);
    
    $item = pdo_fetch("SELECT * FROM " . tablename('eshop_saler') . " WHERE id =:id and uniacid=:uniacid limit 1", array(
        ':uniacid' => $_W['uniacid'],
        ':id' => $id
    ));
    if (!empty($item)) {
        $saler = m('member')->getMember($item['openid']);
        $store = pdo_fetch("SELECT * FROM " . tablename('eshop_store') . " WHERE id =:id and uniacid=:uniacid limit 1", array(
            ':uniacid' => $_W['uniacid'],
            ':id' => $item['storeid']
        ));
    }
    if (checksubmit('submit')) {
        $data = array(
            'uniacid' => $_W['uniacid'],
            'storeid' => intval($_GPC['storeid']),
            'openid' => trim($_GPC['openid']),
            'status' => intval($_GPC['status']),
	    	'salername' => trim($_GPC['salername'])
        );
        $m    = m('member')->getMember($data['openid']);
        if (!empty($id)) {
            pdo_update('eshop_saler', $data, array(
                'id' => $id,
                'uniacid' => $_W['uniacid']
            ));
        } else {
			$scount = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename('eshop_saler') . ' WHERE openid =:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $data['openid']));
			if ($scount > 0) {
				message('此会员已经成为核销员，没法重复添加', '', 'error');
			}
            pdo_insert('eshop_saler', $data);
            $id = pdo_insertid();
        }
        message('更新核销员成功！', $this->createWebUrl('verify/saler', array(
            'op' => 'display'
        )), 'success');
    }
	
} elseif ($operation == 'delete') {
   $id   = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id,openid FROM " . tablename('eshop_saler') . " WHERE id = '$id'");
    if (empty($item)) {
        message('抱歉，核销员不存在或是已经被删除！', $this->createWebUrl('verify/saler', array(
            'op' => 'display'
        )), 'error');
    }
    pdo_delete('eshop_saler', array(
        'id' => $id,
        'uniacid' => $_W['uniacid']
    ));
    $m = m('member')->getMember($item['openid']);
    message('核销员删除成功！', $this->createWebUrl('verify/saler', array(
        'op' => 'display'
    )), 'success');
} elseif ($operation == 'query') {
    $kwd                = trim($_GPC['keyword']);
    $params             = array();
    $params[':uniacid'] = $_W['uniacid'];
    $condition          = " and s.uniacid=:uniacid";
    if (!empty($kwd)) {
        $condition .= " AND ( m.nickname LIKE :keyword or m.realname LIKE :keyword or m.mobile LIKE :keyword or store.storename like :keyword )";
        $params[':keyword'] = "%{$kwd}%";
    }
    $ds = pdo_fetchall("SELECT s.*,m.nickname,m.avatar,m.mobile,m.realname,store.storename FROM " . tablename('eshop_saler') . "  s " . " left join " . tablename('eshop_member') . " m on s.openid=m.openid " . " left join " . tablename('eshop_store') . " store on store.id=s.storeid " . " WHERE 1 {$condition} ORDER BY id asc", $params);
    include $this->template('query_saler');
    exit;
}
include $this->template('saler');