<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page('header_base');?>
<title>微信账户登录</title>
<link href="<?php echo RESOURCE_ROOT;?>public/weui.min.css" rel="stylesheet">
<link href="<?php echo RESOURCE_ROOT;?>public/weui.plus.css?v=2" rel="stylesheet">
<style>
	.weui-grid:before {
    border-right: 0px solid #d9d9d9;
      border-bottom: 0px solid #d9d9d9;
}	.weui-grid:after {
    border-right: 0px solid #d9d9d9;
      border-bottom: 0px solid #d9d9d9;
}
	</style>
<form  method="post" >
	   
<div class="weui-cells_form" style="  margin-bottom:50px;   border-bottom: 0px solid #FFF;   margin-top: 0;">




 <div class="icon-box" style="text-align:center;margin-top:50px;">
            <i class="weui-icon-waiting weui-icon_msg"></i>
            <div class="icon-box__ctn">
                <h3 class="icon-box__title">&nbsp;</h3>
                <p class="icon-box__desc">您确认使用微信来登陆<?php echo $set_shop['name'];?>系统吗？</p>
            </div>
        </div>
            
            <div class="weui-btn-area">
            <button class="weui-btn weui-btn_primary" onclick="doc" name="submit"  value="yes" >登录</button>
        </div>
       

</form>

    

<?php  $show_footer=false;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>