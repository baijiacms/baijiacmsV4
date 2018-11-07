<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
if (!class_exists('ShopModel')) {
class ShopModel
{
    public function getCategory()
    {
        global $_W;
        $shopset     = globalSetting('shop');
        $allcategory = array();
        $category    = pdo_fetchall("SELECT * FROM " . tablename('eshop_category') . " WHERE uniacid=:uniacid and enabled=1 ORDER BY parentid ASC, displayorder DESC", array(
            ':uniacid' => $_W['uniacid']
        ));
        $category    = set_medias($category, array(
            'thumb',
            'advimg'
        ));
        foreach ($category as $c) {
            if (empty($c['parentid'])) {
                $children = array();
                foreach ($category as $c1) {
                    if ($c1['parentid'] == $c['id']) {
                        $children[] = $c1;
                    }
                }
                $c['children'] = $children;
                $allcategory[] = $c;
            }
        }
        return $allcategory;
    }
}
}