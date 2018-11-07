<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page('header_base');?>
<title>个人中心</title>
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
	var phoneNumber = $('input[name="mobile"]').val();
	var phone = phoneNumber;
	
	if (!/^1\d{10}$/.test(phone)) {
		document.getElementById('emsg').innerText="请正确填写手机号！";		
    $('#iosDialog').fadeIn(200);

		return false;
	}
	var password = $('input[name=newpassword]').val().trim();
	if (!/^.{6,16}/.test(password)) {
		document.getElementById('emsg').innerText="请正确输入新密码,至少6位数！";		
		    $('#iosDialog').fadeIn(200);
		return false;
	}
		var repassword = $('input[name=repassword]').val().trim();
	if (!/^.{6,16}/.test(repassword)) {
		document.getElementById('emsg').innerText="请正确输入确认密码,至少6位数！";		
		    $('#iosDialog').fadeIn(200);
		return false;
	}
	if (password!=repassword) {
		document.getElementById('emsg').innerText="新密码与确认密码不相同！";		
		    $('#iosDialog').fadeIn(200);
		return false;
	}
		var verify = $('input[name=verify]').val().trim();
	if (verify=='') {
		document.getElementById('emsg').innerText="请正确填写验证码！";		
		    $('#iosDialog').fadeIn(200);
		return false;
	}
		$('#submit').click();
	
}	
</script>
<form  method="post" >
	   
<div class="weui-cells_form" style="  margin-bottom:50px;   border-bottom: 0px solid #FFF;   margin-top: 0;">
	 <div class="page_topbar" >
     <a href="<?php echo create_url('mobile',array('act' => 'shopwap','do' => 'login'));?>" class="back"  style="color: #fff;text-align:center;"><i class="fa fa-angle-left"></i></a>
    <div class="title" style="color: #fff;text-align:center;">用户注册</div>
</div>

      
            <div class="weui-cell ">
                <div class="weui-cell__hd">
                    <label class="weui-label">手机号</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="tel" autocomplete="off" name="mobile"  maxlength="11" id="phone"  placeholder="请输入手机号">
                </div>
             
            </div>

             <?php if(false){?>
             <div class="weui-cell   weui-cell_vcode">
                <div class="weui-cell__hd">
                    <label class="weui-label">验证码</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="tel" autocomplete="off" name="mobile"  maxlength="11" id="phone"  placeholder="请输入验证码">
                </div>
               <div class="weui-cell__ft">
                    <a href="javascript:;" class="weui-vcode-btn">获取验证码</a>
                </div>
            </div>
             <?php }?>
                  <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">新密码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="password"  autocomplete="off" name="newpassword" placeholder="设置密码，6-16位数字、字母或符号组成">
                </div>
            </div>
              <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">确认密码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="password"  autocomplete="off" name="repassword" placeholder="设置密码，6-16位数字、字母或符号组成">
                </div>
            </div>
            <div class="weui-cell weui-cell_vcode">
                <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" name="verify"  placeholder="请输入验证码"  autocomplete="off" >
                </div>
                <div class="weui-cell__ft">
                    <img  id="verifyimg" onClick="fleshVerify()"  class="weui-vcode-img" src="<?php echo create_url('mobile',array('act' => 'shopwap','do' => 'verifycode'));?>">
                </div>
            </div>
            
            <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" onclick="submitlogin('');" id="showTooltips">立即注册</a>
                    <button type="submit" id='submit'  name="submit" value="yes" style="display:none" >x</button>
        </div>
       
        
            <div class="weui-btn-area"style="text-align:center">
             	<?php if(is_use_weixin()){ ?>
 <a  style="color:blue;margin-right:30px" href="<?php echo create_url('mobile',array('act' => 'shopwap','do' => 'login','op'=>'weixin'));?>">微信登陆</a>
       <?php } ?>      
 <a  style="color:blue"  href="<?php echo create_url('mobile',array('act' => 'shopwap','do' => 'login'));?>">用户登录</a>
 
        </div>
        
      
        
        </div>
</form>
<script>
		function fleshVerify(){
	var verifyimg = $("#verifyimg").attr("src");
	if( verifyimg.indexOf('?')>0){
                    $("#verifyimg").attr("src", verifyimg+'&random='+Math.random());
                }else{
                    $("#verifyimg").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
                }
	}
</script>			
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