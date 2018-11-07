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
	<?php if($hiddenoldpwd==false){?> var password = $('input[name=oldpwd]').val().trim();
	if (password=='') {
				document.getElementById('emsg').innerText="请输入原始密码！";		
		    $('#iosDialog').fadeIn(200);
		return false;
	}<?php }?> 
	
	
	var newpassword = $('input[name=newpassword]').val().trim();
	if (!/^.{6,16}/.test(newpassword)) {
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
	if (newpassword!=repassword) {
		document.getElementById('emsg').innerText="新密码与确认密码不相同！";		
		    $('#iosDialog').fadeIn(200);
		return false;
	}

		$('#submit').click();
	
}	
</script>
<form  method="post" >
	   
<div class="weui-cells_form" style="  margin-bottom:50px;   border-bottom: 0px solid #FFF;   margin-top: 0;">
	 <div class="page_topbar" >
     <a href="<?php echo create_url('mobile',array('act' => 'center','do' => 'member','m'=>'eshop'));?>" class="back"  style="color: #fff;text-align:center;"><i class="fa fa-angle-left"></i></a>
    <div class="title" style="color: #fff;text-align:center;">修改密码</div>
</div>

      
            <div class="weui-cell ">
                <div class="weui-cell__hd">
                    <label class="weui-label">手机号</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" readonly="radonly" type="tel" value="<?php echo $memberinfo['mobile'];?>" autocomplete="off" name="mobile"  maxlength="11" id="phone"   placeholder="请输入手机号">
                </div>
              
            </div>
            
             <?php if($hiddenoldpwd==false){?> 
                <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">原密码</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="password"  autocomplete="off" name="oldpwd" placeholder="请输入原密码">
                </div>
            </div>
            <?php } ?>
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
       
            
            <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" onclick="submitlogin('');" id="showTooltips">修改密码</a>
                    <button type="submit" id='submit'  name="submit" value="yes" style="display:none" >x</button>
        </div>
       
 
      
        
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