<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

    if (!empty($_GPC['catname'])) {
        foreach ($_GPC['catname'] as $id => $catname) {
            if ($id == 'new') {
               pdo_insert('eshop_virtual_category', array(
                    'name' => $catname,
                    'uniacid' => $_W['uniacid']
                ));
                $insert_id = pdo_insertid();
            } else {
                pdo_update('eshop_virtual_category', array(
                    'name' => $catname
                ), array(
                    'id' => $id
                ));
            }
        }
       message('分类更新成功！', $this->createWebUrl('virtual/category', array(
            'op' => 'display'
        )), 'success');
    }
    $list = pdo_fetchall("SELECT * FROM " . tablename('eshop_virtual_category') . " WHERE uniacid = '{$_W['uniacid']}' ORDER BY id DESC");
} elseif ($operation == 'delete') {
    $id   = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id,name FROM " . tablename('eshop_virtual_category') . " WHERE id = '$id' AND uniacid=" . $_W['uniacid'] . "");
    if (empty($item)) {
        message('抱歉，分类不存在或是已经被删除！', $this->createWebUrl('virtual/category', array(
            'op' => 'display'
        )), 'error');
    }
    pdo_delete('eshop_virtual_category', array(
        'id' => $id
    ));
    message('分类删除成功！', $this->createWebUrl('virtual/category', array(
        'op' => 'display'
    )), 'success');
}

include $this->template('category');