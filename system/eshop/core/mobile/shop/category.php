<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
$set_shop=globalSetting('shop');
       $category_set=array();
        $category_set['level']  = 2;
        $category_set['show']   = $set_shop['catshow'];
        if(!empty($set_shop['catadvimg']))
        {
        $category_set['advimg'] = ATTACHMENT_WEBROOT.$set_shop['catadvimg'];
      }
        $category_set['advurl'] = trim($set_shop['catadvurl']);


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
	function getlocal_category($level)
	{
		$level = intval($level);
		$category = getshop_Category();
		$category_parent = array();
		$category_children = array();
		$category_grandchildren = array();
		array_walk($category['parent'], function($value) use(&$category_parent, &$category_children, &$category_grandchildren, $category, $level) {
			if ($value['enabled'] == 1) {
				$value['thumb'] = tomedia($value['thumb']);
				$value['advimg'] = tomedia($value['advimg']);
				$category_parent[$value['parentid']][] = $value;
				if (!empty($category['children'][$value['id']]) && (2 <= $level)) {
					array_walk($category['children'][$value['id']], function($val) use(&$category_children, &$category_grandchildren, $category, $level) {
						if ($val['enabled'] == 1) {
							$val['thumb'] = tomedia($val['thumb']);
							$val['advimg'] = tomedia($val['advimg']);
							$category_children[$val['parentid']][] = $val;
							if (!empty($category['children'][$val['id']]) && (3 <= $level)) {
								array_walk($category['children'][$val['id']], function($v) use(&$category_grandchildren) {
									if ($v['enabled'] == 1) {
										$v['thumb'] = tomedia($v['thumb']);
										$v['advimg'] = tomedia($v['advimg']);
										$category_grandchildren[$v['parentid']][] = $v;
									}
								});
							}
						}
					});
				}
			}
		});
		return array('parent' => $category_parent, 'children' => $category_children, 'grandchildren' => $category_grandchildren);
	}

		$category = getlocal_category(2);
		


include $this->template('category');