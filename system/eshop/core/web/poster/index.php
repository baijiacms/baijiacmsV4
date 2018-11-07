<?php
global $_W, $_GPC;

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

    $pindex    = max(1, intval($_GPC['page']));
    $psize     = 10;
    $params    = array(
        ':uniacid' => $_W['uniacid']
    );
    $condition = " and uniacid=:uniacid ";
  
    $list  = pdo_fetchall("SELECT * FROM " . tablename('eshop_poster') . " WHERE 1 {$condition} ORDER BY isdefault desc,createtime desc LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
    foreach ($list as &$row) {
    	$row['times'] = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_poster_scan') . ' where posterid=:posterid and uniacid=:uniacid', array(':posterid' => $row['id'], ':uniacid' => $_W['uniacid']));
    	$row['follows'] = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_poster_log') . ' where posterid=:posterid and uniacid=:uniacid', array(':posterid' => $row['id'], ':uniacid' => $_W['uniacid']));
    }
    unset($row);
    $total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('eshop_poster') . " where 1 {$condition} ", $params);
    $pager = pagination($total, $pindex, $psize);
} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT * FROM " . tablename('eshop_poster') . " WHERE id =:id and uniacid=:uniacid limit 1", array(
        ':id' => $id,
        ':uniacid' => $_W['uniacid']
    ));
    if (!empty($item)) {
        $data = json_decode(str_replace('&quot;', "'", $item['data']), true);
    }
    if (checksubmit('submit')) {
        $acid =  $_W['uniacid'];
        $data = array(
            'uniacid' => $_W['uniacid'],
            'title' => trim($_GPC['title']),
            'type' => intval($_GPC['type']),
            'keyword' => trim($_GPC['keyword']),
            'bg' => save_media($_GPC['bg']),
            'data' => htmlspecialchars_decode($_GPC['data']),
            'isdefault' => intval($_GPC['isdefault']),
            'isopen' => intval($_GPC['isopen']),
            'createtime' => time(),
            'waittext' => trim($_GPC['waittext'])
            
        );

        if ($data['isdefault'] == 1) {
            pdo_update('eshop_poster', array(
                'isdefault' => 0
            ), array(
                'uniacid' => $_W['uniacid'],
                'isdefault' => 1,
                'type' => $data['type']
            ));
        }
        if (!empty($id)) {
            pdo_update('eshop_poster', $data, array(
                'id' => $id,
                'uniacid' => $_W['uniacid']
            ));
        } else {
            pdo_insert('eshop_poster', $data);
            $id = pdo_insertid();
        }
     
        message('更新海报成功！', $this->createWebUrl('poster', array(
            'op' => 'display'
        )), 'success');
    }
  

} elseif ($operation == 'delete') {
    $id     = intval($_GPC['id']);
    $poster = pdo_fetch("SELECT id,title FROM " . tablename('eshop_poster') . " WHERE id = '$id'");
    if (empty($poster)) {
        message('抱歉，海报不存在或是已经被删除！', $this->createWebUrl('poster', array(
            'op' => 'display'
        )), 'error');
    }
    pdo_delete('eshop_poster', array(
        'id' => $id,
        'uniacid' => $_W['uniacid']
    ));
    pdo_delete('eshop_poster_log', array(
        'posterid' => $id,
        'uniacid' => $_W['uniacid']
    ));
    message('海报删除成功！', $this->createWebUrl('poster', array(
        'op' => 'display'
    )), 'success');
} else if ($operation == 'setdefault') {
    $id     = intval($_GPC['id']);
    $poster = pdo_fetch("SELECT * FROM " . tablename('eshop_poster') . " WHERE id = '$id'");
    if (empty($poster)) {
        message('抱歉，海报不存在或是已经被删除！', $this->createWebUrl('poster', array(
            'op' => 'display'
        )), 'error');
    }
    pdo_update('eshop_poster', array(
        'isdefault' => 0
    ), array(
        'uniacid' => $_W['uniacid'],
        'isdefault' => 1,
        'type' => $poster['type']
    ));
    pdo_update('eshop_poster', array(
        'isdefault' => 1
    ), array(
        'uniacid' => $_W['uniacid'],
        'id' => $poster['id']
    ));
   message('海报设置成功！', $this->createWebUrl('poster', array(
        'op' => 'display'
    )), 'success');
}
include $this->template('index');