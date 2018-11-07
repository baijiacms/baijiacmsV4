<?php

global $_W, $_GPC;

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

if ($operation == 'display') {
    $typeid = $_GPC['typeid'];
    if (empty($typeid)) {
        message("Url参数错误！请重试！", $this->createWebUrl('virtual/temp'), 'error');
        exit;
    }
    $page           = empty($_GPC['page']) ? "" : $_GPC['page'];
    $pindex         = max(1, intval($page));
    $psize          = 100;
    $type           = pdo_fetch('SELECT * FROM ' . tablename('eshop_virtual_type') . ' WHERE id=:id and uniacid=:uniacid ', array(
        ':id' => $typeid,
        ':uniacid' => $_W['uniacid']
    ));
    $type['fields'] = iunserializer($type['fields']);
    $condition      = " and d.typeid=:typeid and d.uniacid=:uniacid";
    $params         = array(
        ':typeid' => $typeid,
        ':uniacid' => $_W['uniacid']
    );
    if ($_GPC['status'] == '0') {
        $condition .= " and d.openid=''";
    } else if ($_GPC['status'] == '1') {
        $condition .= " and d.openid<>''";
    }

    $items = pdo_fetchall('SELECT d.*,o.carrier,m.avatar,m.nickname FROM ' . tablename('eshop_virtual_data') . " d " . " left join " . tablename('eshop_member') . ' m on m.openid = d.openid and m.uniacid= d.uniacid ' . " left join " . tablename('eshop_order') . ' o on o.id = d.orderid ' . " where  1 {$condition} order by openid desc,id limit " . ($pindex - 1) * $psize . ',' . $psize, $params);
    foreach ($items as &$row) {
        $carrier = iunserializer($row['carrier']);
        if (is_array($carrier)) {
            $row['realname'] = $carrier['carrier_realname'];
            $row['mobile']   = $carrier['carrier_mobile'];
        }
    }
    unset($row);
    $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('eshop_virtual_data') . " d " . " left join " . tablename('eshop_member') . ' m on m.openid = d.openid and m.uniacid=d.uniacid ' . " left join " . tablename('eshop_order') . ' o on o.id = d.orderid ' . " where 1 {$condition} ", $params);
    $pager = pagination($total, $pindex, $psize);
} elseif ($operation == 'post') {
    $typeid = $_GPC['typeid'];
    $editid = $_GPC['id'];
    if (empty($typeid)) {
        message("Url参数错误！请重试！", $this->createWebUrl('virtual/temp'), 'error');
        exit;
    }
    $item = pdo_fetch('SELECT * FROM ' . tablename('eshop_virtual_type') . ' WHERE id=:id and uniacid=:uniacid ', array(
        ':id' => $_GPC['typeid'],
        ':uniacid' => $_W['uniacid']
    ));
    if (!empty($item)) {
        $item['fields'] = iunserializer($item['fields']);
    }
    if (!empty($editid)) {
        $data         = pdo_fetch('SELECT * FROM ' . tablename('eshop_virtual_data') . ' WHERE id=:id and typeid=:typeid and uniacid=:uniacid ', array(
            ':id' => $editid,
            ':typeid' => $typeid,
            ':uniacid' => $_W['uniacid']
        ));
        $data['edit'] = $editid;
    }
    if ($_W['ispost']) {
        $typeid = intval($_GPC['typeid']);
        if (!empty($typeid)) {
            $item           = pdo_fetch('SELECT * FROM ' . tablename('eshop_virtual_type') . ' WHERE id=:id and uniacid=:uniacid ', array(
                ':id' => $typeid,
                ':uniacid' => $_W['uniacid']
            ));
            $item['fields'] = iunserializer($item['fields']);
            if (!empty($item['fields'])) {
                $tpids = $_GPC['tp_id'];
                foreach ($tpids as $index => $id) {
                    $values = array();
                    foreach ($item['fields'] as $key => $name) {
                        $values[$key] = $_GPC['tp_value_' . $key][$index];
                    }
                    $insert = array(
                        'typeid' => $_GPC['typeid'],
                        'pvalue' => $values['key'],
                        'fields' => iserializer($values),
                        'uniacid' => $_W['uniacid']
                    );
                    $datas  = pdo_fetch('SELECT * FROM ' . tablename('eshop_virtual_data') . ' WHERE id=:id and typeid=:typeid and uniacid=:uniacid ', array(
                        ':id' => $id,
                        ':typeid' => $typeid,
                        ':uniacid' => $_W['uniacid']
                    ));
                    if (empty($datas)) {
                        $keydata = pdo_fetch('SELECT * FROM ' . tablename('eshop_virtual_data') . ' WHERE pvalue=:pvalue  and typeid=:typeid and uniacid=:uniacid ', array(
                            ':pvalue' => $insert['pvalue'],
                            ':typeid' => $typeid,
                            ':uniacid' => $_W['uniacid']
                        ));
                        if (empty($keydata)) {
                            pdo_insert('eshop_virtual_data', $insert);
                            pdo_update('eshop_virtual_type', 'alldata=alldata+1', array(
                                'id' => $item['id']
                            ));
                        } else {
                            pdo_update('eshop_virtual_data', $insert, array(
                                'id' => $keydata['id']
                            ));
                        }
                    } else {
                        $keydata = pdo_fetch('SELECT * FROM ' . tablename('eshop_virtual_data') . ' WHERE pvalue=:pvalue and id<>:id and typeid=:typeid and uniacid=:uniacid ', array(
                            ':pvalue' => $insert['pvalue'],
                            ':id' => $id,
                            ':typeid' => $typeid,
                            ':uniacid' => $_W['uniacid']
                        ));
                        if (empty($keydata)) {
                            pdo_update('eshop_virtual_data', $insert, array(
                                'id' => $datas['id']
                            ));
                        } else {
                            $noinsert .= $insert['pvalue'] . ',';
                        }
                    }
                }
                m('virtual')->updateStock($typeid);
                if (!empty($noinsert)) {
                    $tip = '<br>未保存成功的数据：主键=' . $noinsert . '<br>失败原因：已经使用无法更改';
                    message('部分数据保存成功！' . $tip, '', 'warning');
                } else {
                    message('保存成功！', $this->createWebUrl('virtual/data', array(
                        'typeid' => $typeid
                    )));
                }
            }
        }
        exit;
    }
} else if ($operation == 'autonum') {
    $num = $_GPC['num'];
    $len = intval($_GPC['len']);
    $len == 0 && $len = 1;
    $arr    = array(
        $num
    );
    $maxlen = strlen($num);
    for ($i = 1; $i <= $len; $i++) {
        $add    = bcadd($num, $i) . "";
        $addlen = strlen($add);
        if ($addlen > $maxlen) {
            $maxlen = $addlen;
        }
        $arr[] = $add;
    }
    $len = count($arr);
    for ($i = 0; $i < $len; $i++) {
        $zerocount = $maxlen - strlen($arr[$i]);
        if ($zerocount > 0) {
            $arr[$i] = str_pad($arr[$i], $maxlen, "0", STR_PAD_LEFT);
        }
    }
    die(json_encode($arr));
} elseif ($operation == 'delete') {
    $id     = intval($_GPC['id']);
    $typeid = intval($_GPC['typeid']);
    if (!empty($id)) {
        $type = pdo_fetch('SELECT * FROM ' . tablename('eshop_virtual_data') . ' WHERE id=:id and uniacid=:uniacid ', array(
            ':id' => $id,
            ':uniacid' => $_W['uniacid']
        ));
        if (!empty($type['openid'])) {
            message("数据已使用，无法删除！", $this->createWebUrl('virtual/data', array(
                'typeid' => $typeid
            )), 'error');
        }
        pdo_delete('eshop_virtual_data', array(
            'id' => $id
        ));
        pdo_update('eshop_virtual_type', 'alldata=alldata-1', array(
            'id' => $typeid
        ));
        m('virtual')->updateStock($typeid);
        message('删除成功！', $this->createWebUrl('virtual/data', array(
            'typeid' => $typeid
        )));
    } else {
        message('Url参数错误！请重试！', $this->createWebUrl('virtual/data', array(
            'typeid' => $typeid
        )), 'error');
    }
    exit;
}
function createAutoNum($a, $b)
{
    $m      = strlen($a);
    $n      = strlen($b);
    $num    = $m > $n ? $m : $n;
    $result = '';
    $flag   = 0;
    while ($num--) {
        $t1 = 0;
        $t2 = 0;
        if ($m > 0) {
            $t1 = $a[--$m];
        }
        if ($n > 0) {
            $t2 = $b[--$n];
        }
        $t      = $t1 + $t2 + $flag;
        $flag   = $t / 10;
        $result = ($t % 10) . $result;
    }
    return $result;
}
function NumToStr($num)
{
    if (stripos($num, 'e') === false)
        return $num;
    $num    = trim(preg_replace('/[=\'"]/', '', $num, 1), '"');
    $result = "";
    while ($num > 0) {
        $v      = $num - floor($num / 10) * 10;
        $num    = floor($num / 10);
        $result = $v . $result;
    }
    return $result;
}
include $this->template('data');