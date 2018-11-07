<?php
global $_W, $_GPC;

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update('eshop_notice', array(
                'displayorder' => $displayorder
            ), array(
                'id' => $id
            ));
        }
        message('排序更新成功！', $this->createWebUrl('shop/notice', array(
            'op' => 'display'
        )), 'success');
    }
    $list = pdo_fetchall("SELECT * FROM " . tablename('eshop_notice') . " WHERE uniacid = '{$_W['uniacid']}' ORDER BY displayorder DESC");
} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);

    if (checksubmit('submit')) {
        $data = array(
            'uniacid' => $_W['uniacid'],
            'displayorder' => intval($_GPC['displayorder']),
            'title' => trim($_GPC['title']),
            'thumb' => save_media($_GPC['thumb']),
            'link' => trim($_GPC['link']),
            'detail' => htmlspecialchars_decode($_GPC['detail']),
            'status' => intval($_GPC['status']),
            'createtime' => time()
        );
        if (!empty($id)) {
            pdo_update('eshop_notice', $data, array(
                'id' => $id
            ));
  
        } else {
            pdo_insert('eshop_notice', $data);
            $id = pdo_insertid();
        
        }
        message('更新店铺公告成功！', $this->createWebUrl('shop/notice', array(
            'op' => 'display'
        )), 'success');
    }
    $notice = pdo_fetch("SELECT * FROM " . tablename('eshop_notice') . " WHERE id = '$id' and uniacid = '{$_W['uniacid']}'");
} elseif ($operation == 'delete') {
  
    $id     = intval($_GPC['id']);
    $notice = pdo_fetch("SELECT id,title  FROM " . tablename('eshop_notice') . " WHERE id = '$id' AND uniacid=" . $_W['uniacid'] . "");
    if (empty($notice)) {
        message('抱歉，店铺公告不存在或是已经被删除！', $this->createWebUrl('shop/notice', array(
            'op' => 'display'
        )), 'error');
    }
    pdo_delete('eshop_notice', array(
        'id' => $id
    ));

    message('店铺公告删除成功！', $this->createWebUrl('shop/notice', array(
        'op' => 'display'
    )), 'success');
}

include $this->template('notice');