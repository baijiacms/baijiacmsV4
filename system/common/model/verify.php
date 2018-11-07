<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
if (!class_exists('VerifyModel')) {
    class VerifyModel
    {
    	public function getSet()
	    	{
	    		
	    	return globalSetting('verify');	
	    	}
        public function createQrcode($orderid = 0)
        {
            global $_W, $_GPC;
            $path = IA_ROOT . "/cache/eshop/data/qrcode/" . $_W['uniacid'];
            if (!is_dir($path)) {
                
                mkdirs($path);
            }
            
            $url         = WEBSITE_ROOT . create_url('mobile',array('do'=>'verify','act'=>'detail','m'=>'eshop','id'=>$orderid));
            $file        = 'order_verify_qrcode_' . $orderid . '.png';
            $qrcode_file = $path . '/' . $file;
            if (!is_file($qrcode_file)) {
                require IA_ROOT . '/includes/lib/phpqrcode/phpqrcode/phpqrcode.php';
                QRcode::png($url, $qrcode_file, QR_ECLEVEL_H, 4);
            }
            return $_W['siteroot'] . '/cache/eshop/data/qrcode/' . $_W['uniacid'] . '/' . $file;
        }
       
    }
}