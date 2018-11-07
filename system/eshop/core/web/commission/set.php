<?php
global $_W, $_GPC;

$set = globalSetting('commission');
if (checksubmit('submit')) {
    $data          =  array(
    'level'=> intval($_GPC['level']),
    'commission_limit'=> intval($_GPC['commission_limit']),
    'selfbuy'=> intval($_GPC['selfbuy']),
    'commission1'=> $_GPC['commission1'],
    'commission2'=> $_GPC['commission2'],
    'commission3'=> $_GPC['commission3'],
    'become_child'=> intval($_GPC['become_child']),
    'become'=> intval($_GPC['become']),
    'become_ordercount'=> intval($_GPC['become_ordercount']),
    'become_moneycount'=> $_GPC['become_moneycount'],
    'become_xmoneycount'=> $_GPC['become_xmoneycount'],
    'become_goodsid'=> intval($_GPC['become_goodsid']),
    'become_order'=> intval($_GPC['become_order']),
    'become_reg'=> intval($_GPC['become_reg']),
    'become_check'=> intval($_GPC['become_check']),
    'withdraw'=> $_GPC['withdraw'],
    'closetocredit'=> intval($_GPC['closetocredit']),
    'settledays'=> $_GPC['settledays'],
    'levelurl'=> $_GPC['levelurl'],
    'openorderdetail'=> intval($_GPC['openorderdetail']),
    'openorderbuyer'=> intval($_GPC['openorderbuyer']),
    'leveltype'=> intval($_GPC['leveltype'])
    );
    
    refreshSetting($data,'commission');
    message('设置保存成功!', referer(), 'success');
}

$goods = false;
if (!empty($set['become_goodsid'])) {
    $goods = pdo_fetch('select id,title from ' . tablename('eshop_goods') . ' where id=:id and uniacid=:uniacid limit 1 ', array(
        ':id' => $set['become_goodsid'],
        ':uniacid' => $_W['uniacid']
    ));
}

include $this->template('set');