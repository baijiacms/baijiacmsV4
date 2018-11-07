<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}


		global $_W;
		global $_GPC;
		$aid = intval($_GPC['id']);
				$article = pdo_fetch('SELECT * FROM ' . tablename('eshop_article') . ' WHERE id=:aid and article_state=1 and uniacid=:uniacid limit 1 ', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));

		if (!empty($article)) {
		$lifeTime = 24 * 3600 * 1;
session_set_cookie_params($lifeTime);
@session_start();

 $cookieparent='eshop_article_likenum';
			if (empty($_COOKIE[$cookieparent.$_W['uniacid'].'_'.$aid])) {
				 setcookie($cookieparent.$_W['uniacid'].'_'.$aid, 1);
				pdo_update('eshop_article', 'article_likenum=article_likenum+1', array('id' => $aid));
	   $ret = array(
        'status' =>0,
        'result'=>array('status' => 1)
    );
    die(json_encode($ret));
			}
				if ($_COOKIE[$cookieparent.$_W['uniacid'].'_'.$aid]==1) {
 setcookie($cookieparent.$_W['uniacid'].'_'.$aid, 0);
			pdo_update('eshop_article', 'article_likenum=article_likenum-1', array('id' => $aid));

    $ret = array(
        'status' =>0,
        'result'=>array('status' => 0)
    );
  }
    die(json_encode($ret));
  }else
  {
    $ret = array(
        'status' =>0,
        'result'=>array('status' => 0)
    );
    die(json_encode($ret));
  }