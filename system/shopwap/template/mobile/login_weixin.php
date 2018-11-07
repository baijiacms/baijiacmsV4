<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page('header_base');?>
<title>微信快捷登陆</title>
<link rel="stylesheet" type="text/css" href="<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/css/style.css">

<style type="text/css">
    body {<?php if(is_mobile()){?>margin:0px;<?php }?> background:#efefef; font-family:'微软雅黑'; -moz-appearance:none;}
    .info_main {height:auto;  background:#fff; margin-top:14px; border-bottom:1px solid #e8e8e8; border-top:1px solid #e8e8e8;}
    .info_main .line {margin:0 10px; height:40px; border-bottom:1px solid #e8e8e8; line-height:40px; color:#999;}
    .info_main .line .title {height:40px; width:80px; line-height:40px; color:#444; float:left; font-size:16px;}
    .info_main .line .info { width:100%;float:right;margin-left:-80px; }
    .info_main .line .inner { margin-left:80px; }
    .info_main .line .inner input {height:40px; width:100%;display:block; padding:0px; margin:0px; border:0px; float:left; font-size:16px;}
    .info_main .line .inner .user_sex {line-height:40px;}
    .info_sub {cursor: pointer;	height:44px; margin:14px 5px; background:#31cd00; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
    .select { border:1px solid #ccc;height:25px;}
    .balance_sub0, .balance_sub1 {height:40px; margin:10px 5px; background:#31cd00; border-radius:3px; text-align:center; font-size:14px; line-height:40px; color:#fff;}
	.balance_sub2 {height:40px; margin:10px 5px; background:#f49c06; border-radius:3px; text-align:center; font-size:14px; line-height:40px; color:#fff;}
	.balance_sub3 {height:40px; margin:10px 5px;background:#e2cb04; border-radius:3px; text-align:center; font-size:14px; line-height:40px; color:#fff;}

</style>
	

				<form  method="post" >
    <div class="page_topbar" style="background: #008cd7;"  >
     <a href="<?php echo create_url('mobile',array('act' => 'center','do' => 'member','m'=>'eshop'));?>" class="back"  style="color: #fff;text-align:center;"><i class="fa fa-angle-left"></i></a>
    <div class="title" style="color: #fff;text-align:center;">微信快捷登陆</div>
</div>
 
    <div style="text-align:center;">
    	<div style="height: 30px;">
                    </div>
  <img src="<?php echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/iconwx.png?v=1" style="width: 25%;vertical-align: middle;">
 
    </div>
    <div style="height: 40px;">
                    </div>
        <div style="text-align: -webkit-center;">

                            <div class="balance_sub0" style="width:90%;padding:0px 2%;margin:auto;margin-top:20px " onclick="location.href='<?php echo create_url('mobile',array('act' => 'weixin','do' => 'fastlogin'));?>'">微信安全登录</div>
                        </div>
                      
                       </div>
                      <div style="height: 12px;">
                        </div>
     <div style="text-align:center;">
    	<?php if($isregister){?>
    	<a  style="font-size:16px;color: #939393;" href="<?php echo create_url('mobile',array('act' => 'shopwap','do' => 'register','op'=>'account'));?>">账户注册</a>
 
    	<?php }else{?>
  <a  style="font-size:16px;color: blue;" href="<?php echo create_url('mobile',array('act' => 'shopwap','do' => 'login','op'=>'account'));?>">其他账户登录</a>
 <?php } ?>
    </div>
        <button type="submit" id='submit'  name="submit" value="yes" style="display:none" >x</button>
    	</form>
    

<?php  $show_footer=false;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>