<?php

global $_W, $_GPC;
$set_share=globalSetting('share');
$set=array();
$set['share']=$set_share;
if (checksubmit('submit')) {
$share        = is_array($_GPC['share']) ? $_GPC['share'] : array();
         $set=array();
         $set['followurl']=$share['followurl'];
         $set['title']=$share['title'];
         $set['desc']=$share['desc'];
         $set['url']=$share['url'];
       	 $set['icon'] = $share['icon'];
       	 refreshSetting($set,'share');
    message('设置保存成功!', referer(), 'success');
}

include page('follow');