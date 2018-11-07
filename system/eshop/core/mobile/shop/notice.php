<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($_W['isajax']) {
    if ($operation == 'display') {
        $pindex    = max(1, intval($_GPC['page']));
        $psize     = 10;
        $condition = ' and `uniacid` = :uniacid and status=1';
        $params    = array(
            ':uniacid' => $_W['uniacid']
        );
        $sql       = 'SELECT COUNT(*) FROM ' . tablename('eshop_notice') . " where 1 $condition";
        $total     = pdo_fetchcolumn($sql, $params);
        $sql       = 'SELECT * FROM ' . tablename('eshop_notice') . ' where 1 ' . $condition . ' ORDER BY displayorder desc,createtime desc LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
        $list      = pdo_fetchall($sql, $params);
        foreach ($list as &$row) {
            $row['createtime'] = date('Y-m-d H:i', $row['createtime']);
        }
        unset($row);
        $list = set_medias($list, 'thumb');
        show_json(1, array(
            'list' => $list,
            'pagesize' => $psize
        ));
    } 
}
if ($operation == 'get') {
        $id   = intval($_GPC['id']);
        $data = pdo_fetch('select * from ' . tablename('eshop_notice') . ' where uniacid=:uniacid and id=:id and status=1 limit 1', array(
            ':uniacid' => $_W['uniacid'],
            ':id' => $id
        ));
        if (!empty($data)) {
            $data['createtime'] = date('Y-m-d H:i', $data['createtime']);
        }
      include $this->template('notice_detail');
      exit;
    }
include $this->template('notice');