<?php defined('IN_IA') or exit('Access Denied');?><?php  defined('SYSTEM_IN') or exit('Access Denied');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="telephone=no, address=no" name="format-detection">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" /> <!-- apple devices fullscreen -->
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<title>跳转提示</title>
<link href="<?php echo RESOURCE_ROOT;?>public/weui.min.css" rel="stylesheet">
<link href="<?php echo RESOURCE_ROOT;?>public/weui.plus.css?v=2" rel="stylesheet">
</head>
<body>
	
	<div class="page msg_success js_show" style="margin-top:50px">
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="<?php   if($label=='success') { ?>weui-icon-success<?php   } else  { ?>weui-icon-warn<?php   } ?> weui-icon_msg"></i></div>
    
           <div class="weui-msg__text-area">
        			<?php   if(is_array($msg)) { ?>
						<h4>MYSQL 错误：</h4>
						<p><?php  echo cutstr($msg['sql'], 300, 1);?></p>
						<p><b><?php  echo $msg['error']['0'];?> <?php  echo $msg['error']['1'];?>：</b><?php  echo $msg['error']['2'];?></p>
							<?php   }else{ ?>
				 <h2 class="weui-msg__title"><?php   echo $msg;?></h2>
				<?php   } ?> </div>
				
        <div class="weui-msg__opr-area">
            <p class="weui-btn-area">
            	
            		<?php   if($redirect) { ?>

  <a id="href" href="<?php   echo $redirect;?>" class="weui-btn <?php   if($label=='success') { ?>weui-btn_primary<?php   } else  { ?>weui-btn_warn<?php   } ?>">页面自动跳转，等待时间： <b id="wait"><?php echo $sec<=0?2:$sec?></b></a>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time == 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>

<?php   } else { ?>
<a href="javascript:history.go(-1);"class="weui-btn weui-btn_warn">点击这里返回上一页</a>
	<?php   } 
	?>
            	
            </p>
        </div>
        <div class="weui-msg__extra-area">
            <div class="weui-footer">
                
                <p class="weui-footer__text">Copyright © 2016 baijiacms.com</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
 