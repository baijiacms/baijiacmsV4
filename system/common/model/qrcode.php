<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
if (!class_exists('QrcodeModel')) {
class QrcodeModel
{
    public function createShopQrcode($mid = 0, $posterid = 0)
    {
        global $_W, $_GPC;
        $path = IA_ROOT . "/cache/eshop/data/qrcode/" . $_W['uniacid'] . "/";
        if (!is_dir($path)) {
            
            mkdirs($path);
        }
         
        $url = WEBSITE_ROOT . create_url('mobile',array('do'=>'shop','act'=>'index','m'=>'eshop','shareid'=>$mid));
        if (!empty($posterid)) {
            $url .= '&posterid=' . $posterid;
        }
        $file        = 'shop_qrcode_' . $posterid . '_' . $mid . '.png';
        $qrcode_file = $path . $file;
        if (!is_file($qrcode_file)) {
            require IA_ROOT . '/includes/lib/phpqrcode/phpqrcode/phpqrcode.php';
            QRcode::png($url, $qrcode_file, QR_ECLEVEL_L, 4);
        }
        return $_W['siteroot'] . 'cache/eshop/data/qrcode/' . $_W['uniacid'] . '/' . $file;
    }
    public function createGoodsQrcode($mid = 0, $goodsid = 0, $posterid = 0)
    {
        global $_W, $_GPC;
        $path = IA_ROOT . "/cache/eshop/data/qrcode/" . $_W['uniacid'];
        if (!is_dir($path)) {
            
            mkdirs($path);
        }
      	 $url = WEBSITE_ROOT . create_url('mobile',array('do'=>'shop','act'=>'detail','m'=>'eshop','mid'=>$mid,'id'=>$goodsid));
        if (!empty($posterid)) {
            $url .= '&posterid=' . $posterid;
        }
        $file        = 'goods_qrcode_' . $posterid . '_' . $mid . '_' . $goodsid . '.png';
        $qrcode_file = $path . '/' . $file;
        if (!is_file($qrcode_file)) {
              require IA_ROOT . '/includes/lib/phpqrcode/phpqrcode/phpqrcode.php';
            QRcode::png($url, $qrcode_file, QR_ECLEVEL_L, 4);
        }
        return $_W['siteroot'] . 'cache/eshop/data/qrcode/' . $_W['uniacid'] . '/' . $file;
    }
}
}