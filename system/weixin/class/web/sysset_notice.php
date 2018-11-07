<?php

global $_W, $_GPC;
 $set=globalSetting('weixin');
    $salers = array();
    if (isset($set['notice_openid'])) {
        if (!empty($set['notice_openid'])) {
            $openids     = array();
            $strsopenids = explode(",", $set['notice_openid']);
            foreach ($strsopenids as $openid) {
                $openids[] = "'" . $openid . "'";
            }
            $salers = pdo_fetchall("select id,nickname,avatar,openid from " . tablename('eshop_member') . ' where openid in (' . implode(",", $openids) . ") and uniacid={$_W['uniacid']}");
        }
    }
    $newtype = explode(',', $set['notice_newtype']);
    
 
 
if (checksubmit('submit')) {
    $data       = array();
    $data['notice_new'] =$_GPC['notice_new'];
    $data['notice_submit'] =$_GPC['notice_submit'];
    $data['notice_carrier'] =$_GPC['notice_carrier'];
    $data['notice_cancel'] =$_GPC['notice_cancel'];
    $data['notice_pay'] =$_GPC['notice_pay'];
    $data['notice_send'] =$_GPC['notice_send'];
    $data['notice_finish'] =$_GPC['notice_finish'];
    $data['notice_refund'] =$_GPC['notice_refund'];
    $data['notice_refund1'] =$_GPC['notice_refund1'];
    $data['notice_refund2'] =$_GPC['notice_refund2'];
    $data['notice_upgrade'] =$_GPC['notice_upgrade'];
    $data['notice_recharge_ok'] =$_GPC['notice_recharge_ok'];
    $data['notice_recharge_refund'] =$_GPC['notice_recharge_refund'];
    $data['notice_withdraw'] =$_GPC['notice_withdraw'];
    $data['notice_withdraw_ok'] =$_GPC['notice_withdraw_ok'];
    $data['notice_withdraw_fail'] =$_GPC['notice_withdraw_fail'];
   
        if (is_array($_GPC['openids'])) {
            $data['notice_openid'] = implode(",", $_GPC['openids']);
        }
        $data['notice_newtype'] = $_GPC['notice_newtype'];
        if (is_array($data['notice_newtype'])) {
            $data['notice_newtype'] = implode(",", $data['notice_newtype']);
        }
       refreshSetting($data,'weixin');
    message('设置保存成功!', referer(), 'success');
}

include page('sysset_notice');