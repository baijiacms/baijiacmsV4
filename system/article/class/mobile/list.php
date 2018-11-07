<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
			$articles = pdo_fetchall('SELECT distinct article_date_v FROM ' . tablename('eshop_article') . ' a left join ' . tablename('eshop_article_category') . ' c on c.id=a.article_category WHERE a.article_state=1 and a.uniacid=:uniacid order by a.displayorder desc,a.article_date_v desc ' , array(':uniacid' => $_W['uniacid']), 'article_date_v');

			foreach ($articles as &$a) {
				$a['articles'] = pdo_fetchall('SELECT id,article_title,article_date_v,resp_img,resp_desc,article_date_v,resp_desc FROM ' . tablename('eshop_article') . ' WHERE article_state=1 and uniacid=:uniacid and article_date_v=:article_date_v  order by displayorder desc,article_date desc  ', array(':uniacid' => $_W['uniacid'], ':article_date_v' => $a['article_date_v']));
			}

			unset($a);


include page('list');