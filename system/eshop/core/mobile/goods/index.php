<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}
global $_W;
global $_GPC;
$shopset  = globalSetting('shop');
if($_GPC['op']=='get_list')
{
		$order="";
	if($_GPC['order']=='sales'||$_GPC['order']=="marketprice")
	{
		$order=$_GPC['order'];
	}
	$by="";
	if($_GPC['by']=='asc'||$_GPC['by']=="desc")
	{
		$by=$_GPC['by'];
	}
		$args = array('pagesize' => 10, 'page' => intval($_GPC['page']), 'isnew' => trim($_GPC['isnew']), 'ishot' => trim($_GPC['ishot']), 'isrecommand' => trim($_GPC['isrecommand']), 'isdiscount' => trim($_GPC['isdiscount']), 'istime' => trim($_GPC['istime']), 'issendfree' => trim($_GPC['issendfree']), 'keywords' => trim($_GPC['keywords']), 'cate' => trim($_GPC['cate']), 'order' => trim($order), 'by' => trim($by));

		if (isset($_GPC['nocommission'])) {
			$args['nocommission'] = intval($_GPC['nocommission']);
		}
function goods_getList($args = array())
	{
		global $_W;
		$page = (!empty($args['page']) ? intval($args['page']) : 1);
		$pagesize = (!empty($args['pagesize']) ? intval($args['pagesize']) : 10);
		$random = (!empty($args['random']) ? $args['random'] : false);
		$order = (!empty($args['order']) ? $args['order'] : ' displayorder desc,sales desc ,viewcount desc ,createtime desc');
		$orderby = (empty($args['order']) ? '' : (!empty($args['by']) ? $args['by'] : ''));
		$condition = ' and `uniacid` = :uniacid AND `deleted` = 0 and status=1';
		$params = array(':uniacid' => $_W['uniacid']);
		$ids = (!empty($args['ids']) ? trim($args['ids']) : '');

		if (!empty($ids)) {
			$condition .= ' and id in ( ' . $ids . ')';
		}

		$isnew = (!empty($args['isnew']) ? 1 : 0);

		if (!empty($isnew)) {
			$condition .= ' and isnew=1';
		}

		$ishot = (!empty($args['ishot']) ? 1 : 0);

		if (!empty($ishot)) {
			$condition .= ' and ishot=1';
		}

		$isrecommand = (!empty($args['isrecommand']) ? 1 : 0);

		if (!empty($isrecommand)) {
			$condition .= ' and isrecommand=1';
		}

		$isdiscount = (!empty($args['isdiscount']) ? 1 : 0);

		if (!empty($isdiscount)) {
			$condition .= ' and isdiscount=1';
		}

		$issendfree = (!empty($args['issendfree']) ? 1 : 0);

		if (!empty($issendfree)) {
			$condition .= ' and issendfree=1';
		}

		$istime = (!empty($args['istime']) ? 1 : 0);

		if (!empty($istime)) {
			$condition .= ' and istime=1 and ' . time() . '>=timestart and ' . time() . '<=timeend';
		}

		if (isset($args['nocommission'])) {
			$condition .= ' AND `nocommission`=' . intval($args['nocommission']);
		}

		$keywords = (!empty($args['keywords']) ? $args['keywords'] : '');

		if (!empty($keywords)) {
			$condition .= ' AND `title` LIKE :title';
			$params[':title'] = '%' . trim($keywords) . '%';
		}

		if (!empty($args['cate'])) {
			$condition .= ' AND ( pcate=' . $args['cate'] . ' or ccate=' . $args['cate'] . ' )';
		}


		$total = '';

		if (!$random) {
			$sql = 'SELECT id,title,thumb,marketprice,productprice,sales,total,description FROM ' . tablename('eshop_goods') . ' where 1 ' . $condition . ' ORDER BY ' . $order . ' ' . $orderby . ' LIMIT ' . (($page - 1) * $pagesize) . ',' . $pagesize;
			$total = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_goods') . ' where 1 ' . $condition . ' ', $params);
		}
		else {
			$sql = 'SELECT id,title,thumb,marketprice,productprice,sales,total,description FROM ' . tablename('eshop_goods') . ' where 1 ' . $condition . ' ORDER BY rand() LIMIT ' . $pagesize;
			$total = $pagesize;
		}

		$list = pdo_fetchall($sql, $params);
		$list = set_medias($list, 'thumb');
		return array('list' => $list, 'total' => $total);
	}

		$goods = goods_getList($args);
		show_json(1, array('list' => $goods['list'], 'total' => $goods['total'], 'pagesize' => $args['pagesize']));
}
	function getshop_Category()
	{
		global $_W;

			$parents = array();
			$children = array();
			$category = pdo_fetchall('SELECT * FROM ' . tablename('eshop_category') . ' WHERE uniacid =:uniacid ORDER BY parentid ASC, displayorder DESC', array(':uniacid' => $_W['uniacid']));

			foreach ($category as $index => $row) {
				if (!empty($row['parentid'])) {
					$children[$row['parentid']][] = $row;
					unset($category[$index]);
				}
				else {
					$parents[] = $row;
				}
			}

			$allcategory = array('parent' => $parents, 'children' => $children);


		return $allcategory;
	}
		$allcategory = getshop_Category();
		$catlevel =2;
		$opencategory = true;
		$plugin_commission = p('commission');


include $this->template('index');

?>