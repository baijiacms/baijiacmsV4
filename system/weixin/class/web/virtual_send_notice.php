<?php

global $_W, $_GPC;
 $set=globalSetting('weixin');
if (checksubmit('submit')) {
    $data       = array();
    $data['virtual_send_notice'] = $_GPC['virtual_send_notice'];
       refreshSetting($data,'weixin');
    message('设置保存成功!', referer(), 'success');
}

include page('virtual_send_notice');