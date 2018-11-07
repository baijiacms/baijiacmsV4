<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_W, $_GPC;
$openid         = m('user')->getOpenid(false);
$member         = m('member')->getMember($openid);
$uniacid        = $_W['uniacid'];
$goodsid        = intval($_GPC['id']);
$goods          = pdo_fetch("SELECT * FROM " . tablename('eshop_goods') . " WHERE id = :id limit 1", array(
    ':id' => $goodsid
));
if ($goods['showlevels'] != '') {
    	$buylevels = explode(',', $goods['showlevels']);
    if (!in_array($member['level'], $buylevels)) {
       message('您的会员等级无法浏览' . $goods['title'] . '!');
    }
}
if ($goods['showgroups'] != '') {
    $buygroups = explode(',', $goods['showgroups']);
    if (!in_array($member['groupid'], $buygroups)) {
    message( '您所在会员组无法浏览' . $goods['title'] . '!');
   }
}
$goods['content']=preg_replace('/__ATTACHMENT__/',ATTACHMENT_WEBROOT, $goods['content']);
$shop           = globalSetting('shop');
$shop['logo']=tomedia($shop['logo']);
$shop['url']    = $this->createMobileUrl('shop');
$mid            = 0;
$opencommission = false;
if (is_login_account()&&allow_commission()) {
    if (empty($member['agentblack'])) {
        $cset           = globalSetting('commission');
        $opencommission = intval($cset['level']) > 0;
        if ($opencommission) {
            if (empty($mid)) {
                if ($member['isagent'] == 1 && $member['status'] == 1) {
                    $mid = $member['id'];
                }
            }
         
            $commission_text = empty($cset['buttontext']) ? '分享好友' : $cset['buttontext'];
        }
    }
}

$html = $goods['content'];
preg_match_all("/<img.*?src=[\'| \"](.*?(?:[\.gif|\.jpg]?))[\'|\"].*?[\/]?>/", $html, $imgs);
if (isset($imgs[1])) {
    foreach ($imgs[1] as $img) {
        $im       = array(
            "old" => $img,
            "new" => tomedia($img)
        );
        $images[] = $im;
    }
    if (isset($images)) {
        foreach ($images as $img) {
            $html = str_replace($img['old'], $img['new'], $html);
        }
    }
    $goods['content'] = $html;
}
$set =globalSetting("shop");
$set["kefuu"] =tomedia($set["kefuu"]);
$set["img"] =tomedia($set["img"]);



if ($_W['isajax']) {
    if (empty($goods)) {
        show_json(0);
    }
    $goods              = set_medias($goods, 'thumb');
    $goods['canbuy']    = !empty($goods['status']) && empty($goods['deleted']);
    $goods['timestate'] = '';
    $goods['userbuy']   = '1';
    if ($goods['usermaxbuy'] > 0) {
        $order_goodscount = pdo_fetchcolumn('select ifnull(sum(og.total),0)  from ' . tablename('eshop_order_goods') . ' og ' . ' left join ' . tablename('eshop_order') . ' o on og.orderid=o.id ' . ' where og.goodsid=:goodsid and  o.status>=1 and o.openid=:openid  and og.uniacid=:uniacid ', array(
            ':goodsid' => $goodsid,
            ':uniacid' => $uniacid,
            ':openid' => $openid
        ));
        if ($order_goodscount >= $goods['usermaxbuy']) {
            $goods['userbuy'] = 0;
        }
    }
    $levelid           = $member['level'];
    $groupid           = $member['groupid'];
    $goods['levelbuy'] = '1';
    if ($goods['buylevels'] != '') {
        $buylevels = explode(',', $goods['buylevels']);
        if (!in_array($levelid, $buylevels)) {
            $goods['levelbuy'] = 0;
        }
    }
    $goods['groupbuy'] = '1';
    if ($goods['buygroups'] != '') {
        $buygroups = explode(',', $goods['buygroups']);
        if (!in_array($groupid, $buygroups)) {
            $goods['groupbuy'] = 0;
        }
    }
    $goods['timebuy'] = '0';
    if ($goods['istime'] == 1) {
        if (time() < $goods['timestart']) {
            $goods['timebuy']   = '-1';
            $goods['timestate'] = "before";
            $goods['buymsg']    = "限时购活动未开始";
        } else if (time() > $goods['timeend']) {
            $goods['timebuy'] = '1';
            $goods['buymsg']  = '限时购活动已经结束';
        } else {
            $goods['timestate'] = 'after';
        }
    }
    $goods['canaddcart'] = true;
    if ($goods['isverify'] == 2 || $goods['type'] == 2 || $goods['type'] == 3) {
        $goods['canaddcart'] = false;
    }
    $pics     = array(
        $goods['thumb']
    );
    $thumburl = unserialize($goods['thumb_url']);
    if (is_array($thumburl)) {
        $pics = array_merge($pics, $thumburl);
    }
    unset($thumburl);
    $pics         = set_medias($pics);
    $marketprice  = $goods['marketprice'];
    $productprice = $goods['productprice'];
    $maxprice     = $marketprice;
    $minprice     = $marketprice;
    $stock        = $goods['total'];
    $allspecs     = array();
    if (!empty($goods['hasoption'])) {
        $allspecs = pdo_fetchall("select * from " . tablename('eshop_goods_spec') . " where goodsid=:id order by displayorder asc", array(
            ':id' => $goodsid
        ));
        foreach ($allspecs as &$s) {
            $items      = pdo_fetchall("select * from " . tablename('eshop_goods_spec_item') . " where  `show`=1 and specid=:specid order by displayorder asc", array(
                ":specid" => $s['id']
            ));
            $s['items'] = set_medias($items, 'thumb');
        }
        unset($s);
    }
    $options = array();
    if (!empty($goods['hasoption'])) {
        $options = pdo_fetchall("select id,title,thumb,marketprice,productprice,costprice, stock,weight,specs from " . tablename('eshop_goods_option') . " where goodsid=:id order by id asc", array(
            ':id' => $goodsid
        ));
        $options = set_medias($options, 'thumb');
        foreach ($options as $o) {
            if ($maxprice < $o['marketprice']) {
                $maxprice = $o['marketprice'];
            }
            if ($minprice > $o['marketprice'] && $o['marketprice'] > 0) {
                $minprice = $o['marketprice'];
            }
        }
        $goods['maxprice'] = $maxprice;
        $goods['minprice'] = $minprice;
    }
    $specs  = $allspecs;
    $fcount = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_member_favorite') . ' where uniacid=:uniacid and openid=:openid and goodsid=:goodsid and deleted=0 ', array(
        ':uniacid' => $uniacid,
        ':openid' => $openid,
        ':goodsid' => $goods['id']
    ));
    pdo_query('update ' . tablename('eshop_goods') . " set viewcount=viewcount+1 where id=:id and uniacid='{$uniacid}' ", array(
        ":id" => $goodsid
    ));
    if(is_login_account())
    {
    $history = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_member_history') . ' where goodsid=:goodsid and uniacid=:uniacid and openid=:openid and deleted=0 limit 1', array(
        ':goodsid' => $goodsid,
        ':uniacid' => $uniacid,
        ':openid' => $openid
    ));

    if ($history <= 0) {
        $history = array(
            'uniacid' => $uniacid,
            'openid' => $openid,
            'goodsid' => $goodsid,
            'deleted' => 0,
            'createtime' => time()
        );
        pdo_insert('eshop_member_history', $history);
    }
  	}
    $level     = m('member')->getLevel($openid);
    $discounts = json_decode($goods['discounts'], true);
    if (is_array($discounts)) {
        if (!empty($level['id'])) {
            if ($discounts['level' . $level['id']] > 0 && $discounts['level' . $level['id']] < 10) {
                $level['discount'] = $discounts['level' . $level['id']];
            }
        } else {
            $level['levelname'] = empty($shopset['levelname']) ? '普通会员' : $shopset['levelname'];
            if ($discounts['default'] > 0 && $discounts['default'] < 10) {
                $level['discount'] = $discounts['default'];
            } else {
                $level['discount'] = 10;
            }
        }
    }
    $stores = array();
    if ($goods['isverify'] == 2) {
        $storeids = array();
        if (!empty($goods['storeids'])) {
            $storeids = array_merge(explode(',', $goods['storeids']), $storeids);
        }
        if (empty($storeids)) {
            $stores = pdo_fetchall('select * from ' . tablename('eshop_store') . ' where  uniacid=:uniacid and status=1', array(
                ':uniacid' => $_W['uniacid']
            ));
        } else {
            $stores = pdo_fetchall('select * from ' . tablename('eshop_store') . ' where id in (' . implode(',', $storeids) . ') and uniacid=:uniacid and status=1', array(
                ':uniacid' => $_W['uniacid']
            ));
        }
    }
    $followed    = m('user')->followed($openid);
    $followurl   = empty($goods['followurl']) ? $shop['followurl'] : $goods['followurl'];
    $followtip   = empty($goods['followtip']) ? '如果您想要购买此商品，需要您关注我们的公众号，点击【确定】关注后再来购买吧~' : $goods['followtip'];
    $sale_p = p('sale');
    $saleset     = false;
    if ($sale_p) {
        $saleset            = globalSetting('sale');
        $saleset['enoughs'] = $sale_p->getEnoughs();
    }
    $ret        = array(
        'goods' => $goods,
        'followed' => $followed ? 1 : 0,
        'followurl' => $followurl,
        'followtip' => $followtip,
        'saleset' => $saleset,
        'pics' => $pics,
        'options' => $options,
        'specs' => $specs,
        'commission' => $opencommission,
        'commission_text' => $commission_text,
        'level' => $level,
        'shop' => $shop,
        'goodscount' => pdo_fetchcolumn('select count(*) from ' . tablename('eshop_goods') . ' where uniacid=:uniacid and status=1 and deleted=0 ', array(
            ':uniacid' => $uniacid
        )),
        'cartcount' => pdo_fetchcolumn('select sum(total) from ' . tablename('eshop_member_cart') . ' where uniacid=:uniacid and openid=:openid and deleted=0 ', array(
            ':uniacid' => $uniacid,
            ':openid' => $openid
        )),
        'isfavorite' => $fcount > 0,
        'stores' => $stores
    );
    $commission = p('commission');

    $ret['detail'] = array(
        'logo' => !empty($goods['detail_logo']) ? tomedia($goods['detail_logo']) : $shop['logo'],
        'shopname' => !empty($goods['detail_shopname']) ? $goods['detail_shopname'] : $shop['name'],
        'totaltitle' => trim($goods['detail_totaltitle']),
        'btntext1' => trim($goods['detail_btntext1']),
        'btnurl1' => !empty($goods['detail_btnurl1']) ? $goods['detail_btnurl1'] : $this->createMobileUrl('shop/list'),
        'btntext2' => trim($goods['detail_btntext2']),
        'btnurl2' => !empty($goods['detail_btnurl2']) ? $goods['detail_btnurl2'] : $shop['url']
    );
    show_json(1, $ret);
}
$weixin_share_dzddes=$goods['description'];
$weixin_share_dzdtitle=!empty($goods['share_title']) ? $goods['share_title'] : $goods['title'];
$weixin_share_dzdpic=!empty($goods['share_icon']) ? tomedia($goods['share_icon']) : tomedia($goods['thumb']);
$weixin_share_url=WEBSITE_ROOT.$this->createMobileUrl('shop/detail', array(
        'id' => $goods['id']
    ));
$com             = p('commission');

include $this->template('detail');