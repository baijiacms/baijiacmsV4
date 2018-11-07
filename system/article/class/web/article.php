<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
 
    if (!empty($_GPC['displayorder'])) {
   
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update('eshop_article', array(
                'displayorder' => $displayorder
            ), array(
                'id' => $id
            ));
        }

        message('文章排序更新成功！', create_url('site',array('act' => 'article','do' => 'article','op' => 'display')), 'success');
    }
		$select_category = (empty($_GPC['category']) ? '' : ' and a.article_category=' . intval($_GPC['category']) . ' ');
		$select_title = (empty($_GPC['keyword']) ? '' : ' and a.article_title LIKE \'%' . $_GPC['keyword'] . '%\' ');
		$page = (empty($_GPC['page']) ? '' : $_GPC['page']);
		$pindex = max(1, intval($page));
		$psize = 20;
		$articles = pdo_fetchall('SELECT a.id,a.displayorder,a.article_readnum_v,a.article_likenum_v,a.article_date_v, a.article_title,a.article_category,a.article_date,a.article_readnum,a.article_likenum,a.article_state,c.category_name FROM ' . tablename('eshop_article') . ' a left join ' . tablename('eshop_article_category') . ' c on c.id=a.article_category  WHERE a.uniacid= :uniacid ' . $select_title . $select_category . ' order by displayorder desc,article_date desc LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, array(':uniacid' => $_W['uniacid']));
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('eshop_article') . ' a left join ' . tablename('eshop_article_category') . ' c on c.id=a.article_category  WHERE a.uniacid= :uniacid ' . $select_title . $select_category, array(':uniacid' => $_W['uniacid']));
		$pager = pagination($total, $pindex, $psize);
		$articlenum = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('eshop_article') . ' WHERE uniacid= :uniacid ', array(':uniacid' => $_W['uniacid']));
		$categorys = pdo_fetchall('SELECT * FROM ' . tablename('eshop_article_category') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));

} elseif ($operation == 'post') {
    $id = intval($_GPC['id']);
		$aid=$_GPC['id'];
    if (checksubmit('submit')) {
        $article = array(
            'uniacid' => $_W['uniacid'],
            'article_title' => trim($_GPC['article_title']),
                'article_category' => intval($_GPC['article_category']),
                    'article_mp' => trim($_GPC['article_mp']),
                        'article_author' => trim($_GPC['article_author']),
                            'article_date_v' => trim($_GPC['article_date_v']),
            'article_linkurl' => trim($_GPC['article_linkurl']),
               'article_readnum_v' => intval($_GPC['article_readnum_v']),
                             'article_likenum_v' => intval($_GPC['article_likenum_v']),
                               'article_content' => htmlspecialchars_decode($_GPC['article_content']),
                                           'article_state' => intval($_GPC['article_state']),
            'displayorder' => intval($_GPC['displayorder']),
               'resp_desc' => trim($_GPC['resp_desc']),
                  'resp_img' => trim($_GPC['resp_img']),
        );
        
        $article['article_date'] = date('Y-m-d H:i:s');
        if (!empty($id)) {
            pdo_update('eshop_article', $article, array(
                'id' => $id
            ));
       
        } else {
            pdo_insert('eshop_article', $article);
            $id = pdo_insertid();
           
        }
        message('更新文章成功！', create_url('site',array('act' => 'article','do' => 'article','op' => 'display')), 'success');
    }
    $categorys = pdo_fetchall('SELECT * FROM ' . tablename('eshop_article_category') . ' WHERE uniacid=:uniacid ', array(':uniacid' => $_W['uniacid']));

    $article = pdo_fetch("select * from " . tablename('eshop_article') . " where id=:id and uniacid=:uniacid limit 1", array(
        ":id" => $id,
        ":uniacid" => $_W['uniacid']
    ));
} elseif ($operation == 'delete') {
   
    $id   = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id FROM " . tablename('eshop_article') . " WHERE id = '$id' AND uniacid=" . $_W['uniacid'] . "");
    if (empty($item)) {
        message('抱歉，文章不存在或是已经被删除！', create_url('site',array('act' => 'article','do' => 'article','op' => 'display')), 'error');
    }
    pdo_delete('eshop_article', array(
        'id' => $id
    ));
 
    message('文章删除成功！', create_url('site',array('act' => 'article','do' => 'article','op' => 'display')), 'success');
}

include page('article');