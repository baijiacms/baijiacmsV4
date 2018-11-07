<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page('header_base');?>
<title>验证码</title>
<link href="<?php echo RESOURCE_ROOT;?>public/weui.min.css" rel="stylesheet">
<link href="<?php echo RESOURCE_ROOT;?>public/weui.plus.css?v=2" rel="stylesheet">
<script>

/**
 * 提交注册
 * 
 * @param obj
 * @returns {Boolean}
 */
function submitlogin(obj) {

		var mobilecode = $('input[name=mobilecode]').val().trim();
	if (mobilecode=='') {
		document.getElementById('emsg').innerText="请正写验证码！";		
		    $('#iosDialog').fadeIn(200);
		return false;
	}
		$('#submit').click();
	
}	
</script>
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
	 <div class="page_topbar" >
     <a href="javascript:;" onclick="history.back()" class="back"  style="color: #fff;text-align:center;"><i class="fa fa-angle-left"></i></a>
    <div class="title" style="color: #fff;text-align:center;">手机号验证码</div>
</div>
		    <input type="hidden" name="oldpwd"  value="<?php echo $_GP['oldpwd'];?>">
		     <input type="hidden" name="newpassword"  value="<?php echo $_GP['newpassword'];?>">
		      <input type="hidden" name="repassword"  value="<?php echo $_GP['repassword'];?>">
		               <input type="hidden" name="fromsmspage"  value="1">
                
            <div class="weui-cell  ">
                <div class="weui-cell__hd">
                    <label class="weui-label">验证码</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="tel" autocomplete="off" name="mobilecode"  maxlength="11" id="mobilecode"   placeholder="请输入验证码">
                </div>
            </div>
            
            <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" onclick="submitlogin('');" id="showTooltips">提交</a>
                    <button type="submit" id='submit'  name="submit" value="yes" style="display:none" >x</button>
        </div>
       
        
</form>
 <div class="js_dialog" id="iosDialog" style="display: none;">
            <div class="weui-mask"></div>
            <div class="weui-dialog">
                <div class="weui-dialog__bd" id="emsg"></div>
                <div class="weui-dialog__ft">
                    <a href="javascript:;" id="iosDialog_btn" onclick=" $('#iosDialog').fadeOut(200);" class="weui-dialog__btn weui-dialog__btn_primary">知道了</a>
                </div>
            </div>
        </div>
<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>