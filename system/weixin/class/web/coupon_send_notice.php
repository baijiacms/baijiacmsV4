<?php

global $_W, $_GPC;
 $set=globalSetting('coupon');
if (checksubmit('submit')) {
    $data       = array();
    $data['coupon_templateid'] = $_GPC['coupon_templateid'];
       refreshSetting($data,'coupon');
    message('设置保存成功!', referer(), 'success');
}

include page('coupon_send_notice');