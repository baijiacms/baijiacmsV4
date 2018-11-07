<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $list    = array(
        array(
            'groupname' => '无分组',
            'membercount' => pdo_fetchcolumn('select count(*) from ' . tablename('eshop_member') . ' where uniacid=:uniacid and groupid=0 limit 1', array(
                ':uniacid' => $_W['uniacid']
            ))
        )
    );
    $alllist = pdo_fetchall("SELECT * FROM " . tablename('eshop_member_group') . " WHERE uniacid = '{$_W['uniacid']}' ORDER BY id asc");
    foreach ($alllist as &$row) {
        $row['membercount'] = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_member') . ' where uniacid=:uniacid and groupid=:groupid limit 1', array(
            ':uniacid' => $_W['uniacid'],
            ':groupid' => $row['id']
        ));
    }
    unset($row);
    $list = array_merge($list, $alllist);
} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);
   
    $group = pdo_fetch("SELECT * FROM " . tablename('eshop_member_group') . " WHERE id = '$id'");
    if (checksubmit('submit')) {
        if (empty($_GPC['groupname'])) {
            message('抱歉，请输入分类名称！');
        }
        $data = array(
            'uniacid' => $_W['uniacid'],
            'groupname' => trim($_GPC['groupname'])
        );
        if (!empty($id)) {
            pdo_update('eshop_member_group', $data, array(
                'id' => $id,
                'uniacid' => $_W['uniacid']
            ));
        } else {
            pdo_insert('eshop_member_group', $data);
            $id = pdo_insertid();
        }
        message('更新分组成功！', $this->createWebUrl('member/group', array(
            'op' => 'display'
        )), 'success');
    }
} elseif ($operation == 'delete') {
    $id    = intval($_GPC['id']);
    $group = pdo_fetch("SELECT id,groupname FROM " . tablename('eshop_member_group') . " WHERE id = '$id'");
    if (empty($group)) {
        message('抱歉，分组不存在或是已经被删除！', $this->createWebUrl('member/group', array(
            'op' => 'display'
        )), 'error');
    }
    pdo_delete('eshop_member_group', array(
        'id' => $id,
        'uniacid' => $_W['uniacid']
    ));
    pdo_update('eshop_member', array(
        'groupid' => 0
    ), array(
        'uniacid' => $_W['uniacid']
    ));
    message('分组删除成功！', $this->createWebUrl('member/group', array(
        'op' => 'display'
    )), 'success');
}

include $this->template('group');