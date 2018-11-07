<?php
//微信商城
if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$shopset = globalSetting('shop');
if ($operation == 'display') {
    $list = pdo_fetchall("SELECT * FROM " . tablename('eshop_member_level') . " WHERE uniacid = '{$_W['uniacid']}' ORDER BY level asc");
} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);
    
    $level = pdo_fetch("SELECT * FROM " . tablename('eshop_member_level') . " WHERE id = '$id'");
    if (checksubmit('submit')) {
        if (empty($_GPC['levelname'])) {
            message('抱歉，请输入分类名称！');
        }
        $data = array(
            'uniacid' => $_W['uniacid'],
            'level' => intval($_GPC['level']),
            'levelname' => trim($_GPC['levelname']),
            'ordercount' => intval($_GPC['ordercount']),
            'ordermoney' => $_GPC['ordermoney'],
            'discount' => $_GPC['discount']
        );
        if (!empty($id)) {
            pdo_update('eshop_member_level', $data, array(
                'id' => $id,
                'uniacid' => $_W['uniacid']
            ));
         } else {
            pdo_insert('eshop_member_level', $data);
            $id = pdo_insertid();
         }
        message('更新等级成功！', $this->createWebUrl('member/level', array(
            'op' => 'display'
        )), 'success');
    }
} elseif ($operation == 'delete') {
    $id    = intval($_GPC['id']);
    $level = pdo_fetch("SELECT id,levelname FROM " . tablename('eshop_member_level') . " WHERE id = '$id'");
    if (empty($level)) {
        message('抱歉，等级不存在或是已经被删除！', $this->createWebUrl('member/level', array(
            'op' => 'display'
        )), 'error');
    }
    pdo_delete('eshop_member_level', array(
        'id' => $id,
        'uniacid' => $_W['uniacid']
    ));
     message('等级删除成功！', $this->createWebUrl('member/level', array(
        'op' => 'display'
    )), 'success');
}

include $this->template('level');