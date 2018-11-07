<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
		$id=intval($_GPC['id']);
		$aid = 	$id;


		if (empty($aid)) {
			exit('url参数错误！');
		}

			$lifeTime = 24 * 3600 * 1;
			session_set_cookie_params($lifeTime);
			@session_start();
				if ($_COOKIE['eshop_article_likenum'.$_W['uniacid'].'_'.$aid]==1) {
			$show_icon_likefill=true;
			}
			 $cookieparent='eshop_article_readnum';
			
						if (empty($_COOKIE[$cookieparent.$_W['uniacid'].'_'.$aid])) {
							 setcookie($cookieparent.$_W['uniacid'].'_'.$aid, 1);
								pdo_update('eshop_article', array('article_readnum' => $article['article_readnum'] + 1), array('id' => $article['id']));
				}


		$article = pdo_fetch('SELECT * FROM ' . tablename('eshop_article') . ' WHERE id=:aid and article_state=1 and uniacid=:uniacid limit 1 ', array(':aid' => $aid, ':uniacid' => $_W['uniacid']));

		if (empty($article)) {
			message('文章不存在!', create_url('mobile',array('act' => 'article','do' => 'list')), 'error');
		}
		

		$article['article_content'] = htmlspecialchars_decode($article['article_content']);
		$readnum = intval($article['article_readnum'] + $article['article_readnum_v']);
		$readnum = (100000 < $readnum ? '100000+' : $readnum);
		$likenum = intval($article['article_likenum'] + $article['article_likenum_v']);
		$likenum = (100000 < $likenum ? '100000+' : $likenum);

		if (!empty($article['article_areas'])) {
			$article['areas'] = explode(',', $article['article_areas']);
		}


		$article['article_linkurl'] = $article['article_linkurl'];
include page('article');