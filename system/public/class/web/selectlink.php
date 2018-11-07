<?php
defined('SYSTEM_IN') or exit('Access Denied');

 $type = $_GPC['type'];
            $kw   = $_GPC['kw'];
            if ($type == 'notice') {
                $notices = pdo_fetchall("select * from " . tablename('eshop_notice') . ' where title LIKE :title and status=:status and uniacid=:uniacid ', array(
                    ':uniacid' => $_W['uniacid'],
                    ':status' => '1',
                    ':title' => "%{$kw}%"
                ));
                echo json_encode($notices);
            } elseif ($type == 'good') {
                $goods = pdo_fetchall("select title,id,thumb,marketprice,productprice from " . tablename('eshop_goods') . ' where title LIKE :title and status=1 and deleted=0 and uniacid=:uniacid ', array(
                    ':uniacid' => $_W['uniacid'],
                    ':title' => "%{$kw}%"
                ));
             $goods = set_medias($goods, 'thumb');
                  echo json_encode($goods);
                
            }  elseif ($type == "coupon") {
                $articles = pdo_fetchall("select id,couponname,coupontype from " . tablename("eshop_coupon") . " where couponname LIKE :title and uniacid=:uniacid ", array(
                    ":uniacid" => $_W["uniacid"],
                    ":title" => "%{$kw}%"
                ));
                echo json_encode($articles);
            } else {
                exit();
            }