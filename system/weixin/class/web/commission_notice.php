<?php

global $_W, $_GPC;
 $set=globalSetting('commission');
if (checksubmit('submit')) {
    $data       = array();
    
    $data['weixin_templateid'] = $_GPC['weixin_templateid'];
    $data['weixin_commission_becometitle'] = $_GPC['weixin_commission_becometitle'];
    $data['weixin_commission_become'] = $_GPC['weixin_commission_become'];
    $data['weixin_commission_agent_newtitle'] = $_GPC['weixin_commission_agent_newtitle'];
    $data['weixin_commission_agent_new'] = $_GPC['weixin_commission_agent_new'];
    $data['weixin_commission_order_paytitle'] = $_GPC['weixin_commission_order_paytitle'];
    $data['weixin_commission_order_pay'] = $_GPC['weixin_commission_order_pay'];
    $data['weixin_commission_order_finishtitle'] = $_GPC['weixin_commission_order_finishtitle'];
    $data['weixin_commission_order_finish'] = $_GPC['weixin_commission_order_finish'];
    $data['weixin_commission_applytitle'] = $_GPC['weixin_commission_applytitle'];
    $data['weixin_commission_apply'] = $_GPC['weixin_commission_apply'];
    $data['weixin_commission_checktitle'] = $_GPC['weixin_commission_checktitle'];
    $data['weixin_commission_check'] = $_GPC['weixin_commission_check'];
    $data['weixin_commission_paytitle'] = $_GPC['weixin_commission_paytitle'];
    $data['weixin_commission_pay'] = $_GPC['weixin_commission_pay'];
    $data['weixin_commission_upgradetitle'] = $_GPC['weixin_commission_upgradetitle'];
    $data['weixin_commission_upgrade'] = $_GPC['weixin_commission_upgrade'];
       refreshSetting($data,'commission');
    message('设置保存成功!', referer(), 'success');
}

include page('commission_notice');