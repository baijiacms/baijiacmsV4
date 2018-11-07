<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
if (!class_exists('CommonModel')) {
class CommonModel
{
	  public function getAccount()
    {
        return m('account');
    }
		public function getSysset($key)
    {
        return globalSetting($key);
    }
    public function createNO($table, $field, $prefix)
    {
        $billno =substr(date("Y",TIMESTAMP),-2).date("mdHis",TIMESTAMP) . random(6, true);
        while (1) {
            $count = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_' . $table) . " where {$field}=:billno limit 1", array(
                ':billno' => $billno
            ));
            if ($count <= 0) {
                break;
            }
            $billno = date('YmdHis') . random(6, true);
        }
        return $prefix . $billno;
    }
    public function html_images($detail = '')
    {
        $detail = htmlspecialchars_decode($detail);
        preg_match_all("/<img.*?src=[\'| \"](.*?(?:[\.gif|\.jpg|\.png|\.jpeg]?))[\'|\"].*?[\/]?>/", $detail, $imgs);
        $images = array();
        if (isset($imgs[1])) {
            foreach ($imgs[1] as $img) {
                $im       = array(
                    "old" => $img,
                    "new" => save_media($img)
                );
                $images[] = $im;
            }
        }
        foreach ($images as $img) {
            $detail = str_replace($img['old'], $img['new'], $detail);
        }
        return $detail;
    }
    public function paylog($log = '')
    {
        global $_W;
     
    }
    public function checkClose()
    {
        if (strexists($_SERVER['REQUEST_URI'], '/web/')) {
            return;
        }
        $shop = globalSetting('shop');
        if (!empty($shop['close'])) {
            if (!empty($shop['closeurl'])) {
                header('location: ' . $shop['closeurl']);
                exit;
            }
            die("<!DOCTYPE html>
					<html>
						<head>
							<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
							<title>抱歉，商城暂时关闭</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>
						</head>
						<body>
						<style type='text/css'>
						body { background:#fbfbf2; color:#333;}
						img { display:block; width:100%;}
						.header {
						width:100%; padding:10px 0;text-align:center;font-weight:bold;}
						</style>
						<div class='page_msg'>
						
						<div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span>{$shop['closedetail']}</div></div>
						</body>
					</html>");
        }
    }
}
}