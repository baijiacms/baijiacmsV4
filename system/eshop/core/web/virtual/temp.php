<?php

global $_W, $_GPC;

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
  
    $page   = empty($_GPC['page']) ? "" : $_GPC['page'];
    $pindex = max(1, intval($page));
    $psize  = 12;
    $items  = pdo_fetchall('SELECT * FROM ' . tablename('eshop_virtual_type') . ' WHERE uniacid=:uniacid order by id desc limit ' . ($pindex - 1) * $psize . ',' . $psize, array(
        ':uniacid' => $_W['uniacid']
    ));
    $total  = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('eshop_virtual_type') . " WHERE uniacid=:uniacid order by id desc ", array(
        ':uniacid' => $_W['uniacid']
    ));
    $pager  = pagination($total, $pindex, $psize);
} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);
    
    $datacount = 0;
    if (!empty($id)) {
        $item           = pdo_fetch('SELECT * FROM ' . tablename('eshop_virtual_type') . ' WHERE id=:id and uniacid=:uniacid ', array(
            ':id' => $id,
            ':uniacid' => $_W['uniacid']
        ));
        $item['fields'] = iunserializer($item['fields']);
        $datacount      = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_virtual_data') . " where typeid=:typeid and uniacid=:uniacid and openid='' limit 1", array(
            ':typeid' => $id,
            ':uniacid' => $_W['uniacid']
        ));
    }
    if ($_W['ispost']) {
        $keywords = $_GPC['tp_kw'];
        $names    = $_GPC['tp_name'];
        if (!empty($keywords)) {
            $data = array();
            foreach ($keywords as $key => $val) {
                $data[$keywords[$key]] = $names[$key];
            }
        }
        $insert = array(
            'uniacid' => $_W['uniacid'],
            'cate' => intval($_GPC['cate']),
            'title' => trim($_GPC['tp_title']),
            'fields' => iserializer($data)
        );
        if (empty($id)) {
            pdo_insert('eshop_virtual_type', $insert);
            $id = pdo_insertid();
      
        } else {
            pdo_update('eshop_virtual_type', $insert, array(
                'id' => $id
            ));
        }
        message('保存成功！', $this->createWebUrl('virtual/temp'));
    }
} elseif ($operation == 'addtype') {
   $addt = $_GPC['addt'];
    $kw   = $_GPC['kw'];
    if ($addt == 'type') {
        include $this->template('tp_type');
    } elseif ($addt == 'data') {
        $item           = pdo_fetch('SELECT * FROM ' . tablename('eshop_virtual_type') . ' WHERE id=:id and uniacid=:uniacid ', array(
            ':id' => $_GPC['typeid'],
            ':uniacid' => $_W['uniacid']
        ));
        $item['fields'] = iunserializer($item['fields']);
        $num            = $_GPC['numlist'];
        include $this->template('tp_data');
    }
    exit;
} elseif ($operation == 'delete') {
     $id = $_GPC['id'];
    if (!empty($id)) {
        pdo_delete('eshop_virtual_type', array(
            'id' => $id
        ));
        pdo_delete('eshop_virtual_data', array(
            'typeid' => $id
        ));
       message('删除成功！', $this->createWebUrl('virtual/temp'));
    } else {
        message('Url参数错误！请重试！', $this->createWebUrl('virtual/temp'), 'error');
    }
    exit;
}
$category = pdo_fetchall('select * from ' . tablename('eshop_virtual_category') . ' where uniacid=:uniacid order by id desc', array(
    ':uniacid' => $_W['uniacid']
), 'id');

include $this->template('temp');