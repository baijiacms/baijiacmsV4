<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

    if (!empty($_GPC['displayorder'])) {
   
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update('eshop_article_category', array(
                'displayorder' => $displayorder
            ), array(
                'id' => $id
            ));
        }
  
        message('分类排序更新成功！', create_url('site',array('do' => 'category','act' => 'article','op' => 'display')), 'success');
    }
    $list = pdo_fetchall("SELECT * FROM " . tablename('eshop_article_category') . " WHERE uniacid = '{$_W['uniacid']}' ORDER BY displayorder desc,id DESC");
} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);

    if (checksubmit('submit')) {
        $data = array(
            'uniacid' => $_W['uniacid'],
            'category_name' => trim($_GPC['category_name']),
            'displayorder' => intval($_GPC['displayorder']),
            'isshow' => 1
        );
        if (!empty($id)) {
            pdo_update('eshop_article_category', $data, array(
                'id' => $id
            ));
       
        } else {
            pdo_insert('eshop_article_category', $data);
            $id = pdo_insertid();
           
        }
        message('更新分类成功！', create_url('site',array('do' => 'category','act' => 'article','op' => 'display')), 'success');
    }
    $item = pdo_fetch("select * from " . tablename('eshop_article_category') . " where id=:id and uniacid=:uniacid limit 1", array(
        ":id" => $id,
        ":uniacid" => $_W['uniacid']
    ));
} elseif ($operation == 'delete') {
  
    $id   = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id,category_name FROM " . tablename('eshop_article_category') . " WHERE id = '$id' AND uniacid=" . $_W['uniacid'] . "");
    if (empty($item)) {
        message('抱歉，分类不存在或是已经被删除！',create_url('site',array('do' => 'category','act' => 'article','op' => 'display')), 'error');
    }
    pdo_delete('eshop_article_category', array(
        'id' => $id
    ));
 
    message('分类删除成功！', create_url('site',array('do' => 'category','act' => 'article','op' => 'display')), 'success');
}
include page('category');