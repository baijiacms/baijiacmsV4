<?php
//微信商城
global $_W, $_GPC;
 
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {

    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update('eshop_dispatch', array(
                'displayorder' => $displayorder
            ), array(
                'id' => $id
            ));
        }
        message('分类排序更新成功！', $this->createWebUrl('shop/dispatch', array(
            'op' => 'display'
        )), 'success');
    }
    $list = pdo_fetchall("SELECT * FROM " . tablename('eshop_dispatch') . " WHERE uniacid = '{$_W['uniacid']}' ORDER BY id asc");
} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);
   
    if (checksubmit('submit')) {
        $areas   = array();
        $randoms = $_GPC['random'];
        if (is_array($randoms)) {
            foreach ($randoms as $random) {
                $areas[] = array(
                    'citys' => $_GPC['citys'][$random],
                    'firstprice' => $_GPC['firstprice'][$random],
                    'firstweight' => $_GPC['firstweight'][$random],
                    'secondprice' => $_GPC['secondprice'][$random],
                    'secondweight' => $_GPC['secondweight'][$random]
                );
            }
        }
        $carriers  = array();
        $addresses = $_GPC['address'];
        if (is_array($addresses)) {
            foreach ($addresses as $key => $address) {
                $carriers[] = array(
                    'address' => $_GPC['address'][$key],
                    'realname' => $_GPC['realname'][$key],
                    'mobile' => $_GPC['mobile'][$key],
                    'content' => $_GPC['content'][$key]
                );
            }
        }
        $data = array(
            'uniacid' => $_W['uniacid'],
            'isdefault' => intval($_GPC['isdefault']),
            'displayorder' => intval($_GPC['displayorder']),
            'dispatchtype' => intval($_GPC['dispatchtype']),
            'dispatchname' => trim($_GPC['dispatchname']),
            'express' => trim($_GPC['express']),
            'firstprice' => trim($_GPC['default_firstprice']),
            'firstweight' => trim($_GPC['default_firstweight']),
            'secondprice' => trim($_GPC['default_secondprice']),
            'secondweight' => trim($_GPC['default_secondweight']),
            'areas' => iserializer($areas),
            'carriers' => iserializer($carriers),
            'enabled' => intval($_GPC['enabled'])
        );
        if (!empty($id)) {
            pdo_update('eshop_dispatch', $data, array(
                'id' => $id
            ));
        } else {
            pdo_insert('eshop_dispatch', $data);
            $id = pdo_insertid();
        }
        message('更新配送方式成功！', $this->createWebUrl('shop/dispatch', array(
            'op' => 'display'
        )), 'success');
    }
    $dispatch = pdo_fetch("SELECT * FROM " . tablename('eshop_dispatch') . " WHERE id = '$id' and uniacid = '{$_W['uniacid']}'");
    if (!empty($dispatch)) {
        $dispatch_areas    = unserialize($dispatch['areas']);
        $dispatch_carriers = unserialize($dispatch['carriers']);
    }

        require_once WEB_ROOT . '/includes/lib/json/xml2json.php';;
        $file    =ESHOP_AREA_XMLFILE;
        $content = file_get_contents($file);
        $json    = xml2json::transformXmlStringToJson($content);
        $areas   = json_decode($json, true);
} elseif ($operation == 'delete') {
    $id       = intval($_GPC['id']);
    $dispatch = pdo_fetch("SELECT id,dispatchname FROM " . tablename('eshop_dispatch') . " WHERE id = '$id' AND uniacid=" . $_W['uniacid'] . "");
    if (empty($dispatch)) {
        message('抱歉，配送方式不存在或是已经被删除！', $this->createWebUrl('shop/dispatch', array(
            'op' => 'display'
        )), 'error');
    }
    pdo_delete('eshop_dispatch', array(
        'id' => $id
    ));
    message('配送方式删除成功！', $this->createWebUrl('shop/dispatch', array(
        'op' => 'display'
    )), 'success');
} else if ($operation == 'tpl') {
    $random = random(16);
    ob_clean();
    ob_start();
    include $this->template('tpl/dispatch');
    $contents = ob_get_contents();
    ob_clean();
    die(json_encode(array(
        'random' => $random,
        'html' => $contents
    )));
} else if ($operation == 'tpl1') {
    $random = random(16);
    ob_clean();
    ob_start();
    include $this->template('tpl/carrier');
    $contents = ob_get_contents();
    ob_clean();
    die(json_encode(array(
        'random' => $random,
        'html' => $contents
    )));
}
include $this->template('dispatch');