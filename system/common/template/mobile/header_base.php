<?php defined('IN_IA') or exit('Access Denied');?><!doctype html>
<html xmlns="http://www.w3.org/1999/html">
    <head>
        <meta charset="utf-8">
        <link href="<?php  echo RESOURCE_ROOT;?>eshop/static/css/font-awesome.min.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=no">
     	  <meta content="yes" name="apple-mobile-web-app-capable">
		    <meta content="black" name="apple-mobile-web-app-status-bar-style">
		    <meta content="telephone=no" name="format-detection">
				<script>window.global_website="<?php echo WEBSITE_ROOT;?>";</script>
        <script language="javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/jquery-1.11.1.min.js"></script>
        <script language="javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/jquery.gcjs.js"></script>
        <script>var wxshare=false;</script>
        <?php include page('footer_weixin_share');?>
        <style>
	  a, a:visited {
        text-decoration: none;    cursor: auto; }
        #container{
        	margin-bottom:50px;
        	}
        
	</style>
		
    </head>
    <body style="<?php if(is_mobile()==false){?>max-width: 750px;  margin:auto;<?php }?>">
<?php if(is_mobile()==false){?>
<div style="height: 240px;width: 180px;border: 1px solid #e4e4e4;border-radius: 5px;margin-bottom: 20px;background-color: #fff;padding: 10px;text-align: center;position: fixed;left: 50%;top: 100px; margin-left: 388px;">
    <div ><img style="height: 160px;width: 160px;" src="<?php echo WEBSITE_ROOT;?>includes/lib/phpqrcode/qrcode.php?data=<?php echo urlencode(WEBSITE_ROOT.create_url('mobile',array('do'=>'shop','act'=>'index','m'=>'eshop')));?>"/></div>
    <p style="font-size: 14px;color: #666;line-height: 26px;">手机“扫一扫”浏览</p>
</div>
<?php }?>