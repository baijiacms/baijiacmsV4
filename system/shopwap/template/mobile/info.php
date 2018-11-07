<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page('header_base');?>
<title>用户信息</title>
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
		var nickname = $('input[name=nickname]').val().trim();
	if (nickname=='') {
		document.getElementById('emsg').innerText="请填写您的昵称！";		
		    $('#iosDialog').fadeIn(200);
		return false;
	}
			var weixin = $('input[name=weixin]').val().trim();
	if (weixin=='') {
		document.getElementById('emsg').innerText="请填写您的微信号！";		
		    $('#iosDialog').fadeIn(200);
		return false;
	}
		$('#submit').click();
	
}	
</script>
<form  method="post" enctype="multipart/form-data">
	   
<div class="weui-cells_form" style="  margin-bottom:50px;   border-bottom: 0px solid #FFF;   margin-top: 0;">
	 <div class="page_topbar" >
     <a href="<?php echo create_url('mobile',array('act' => 'center','do' => 'member','m'=>'eshop'));?>" class="back"  style="color: #fff;text-align:center;"><i class="fa fa-angle-left"></i></a>
    <div class="title" style="color: #fff;text-align:center;">我的资料</div>
</div>
 <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label">头像</label>
                </div>
                <div class="weui-cell__bd">
                <img src="<?php if(!empty($memberinfo['avatar'])){ echo $memberinfo['avatar'];}else{?><?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png<?php }?>" id="p_avatar"  style="width:80px;height:80px;  float: left;" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'"/>
                
                   <div class="weui-uploader__input-box" style="margin-left:10px">
                                <input name="upload_image"  id="uploaderInput" class="weui-uploader__input" type="file" accept="image/*" multiple="">
                            </div>
                
                 </div>
            </div>
            
            
               <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label">昵称</label>
                </div>
                <div class="weui-cell__bd">
                  
                  <input type="text"  class="weui-input" autocomplete="off" id="nickname"  name="nickname" placeholder="请输入您的昵称" value="<?php echo $memberinfo['nickname'];?>" />
                </div>
              
            </div>
            
              <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label">姓名</label>
                </div>
                <div class="weui-cell__bd">
                  
                  <input type="text"  class="weui-input" autocomplete="off" id="realname"  name="realname" placeholder="请输入您的姓名"  value="<?php echo $memberinfo['realname'];?>" />
                </div>
              
            </div>
            
            
            
           
            <div class="weui-cell ">
                <div class="weui-cell__hd">
                    <label class="weui-label">手机号</label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="tel" autocomplete="off" name="mobile"  maxlength="11" id="phone"   placeholder="请输入手机号" value="<?php echo $memberinfo['mobile'];?>">
                </div>
            </div>
            
                <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label">微信号</label>
                </div>
                <div class="weui-cell__bd">
                  
                  <input type="text"  class="weui-input" autocomplete="off" id="weixin"  name="weixin" placeholder="请输入微信号"  value="<?php echo $memberinfo['weixin'];?>" />
                </div>
            </div>
            
                <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label">性别</label>
                </div>
                <div class="weui-cell__bd">
                 <span class="gender" data-val="1"><i class="fa <?php if($memberinfo['gender']=='1'){?>fa-check-circle-o<?php }else{ ?>fa-circle-o<?php } ?>" <?php if($memberinfo['gender']=='1'){?>style="color:#0C9;"<?php }?>></i> 男</span>&nbsp;&nbsp;
           			 <span class="gender" data-val="2"><i class="fa <?php if($memberinfo['gender']=='2'){?>fa-check-circle-o<?php }else{ ?>fa-circle-o<?php } ?>" <?php if($memberinfo['gender']=='2'){?>style="color:#0C9;"<?php }?>></i> 女
                <input type="hidden" id="gender" name="gender" value="<?php echo $memberinfo['gender'];?>" />
                
                </div>
            </div>
            
       
       
       
            
            <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" onclick="submitlogin('');" id="showTooltips">确定修改</a>
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
    
 <script type="text/javascript">
    $(function(){
       
				$uploaderInput = $("#uploaderInput"),
        $uploaderInput.on("change", function(e){
            var src, url = window.URL || window.webkitURL || window.mozURL, files = e.target.files;
            for (var i = 0, len = files.length; i < len; ++i) {
                var file = files[i];

                if (url) {
                    src = url.createObjectURL(file);
                } else {
                    src = e.target.result;
                }
   							 $("#p_avatar").attr("src", src);
            }
        });
   
    });

	     $('.gender').click(function() {
                    var $this = $(this);
                    var val = $this.data('val');
                    $('.gender').find('i').css('color', '#999').removeClass('fa-check-circle-o').addClass('fa-circle-o');
                    $(this).find('i').removeClass('fa-circle-o').addClass('fa-check-circle-o').css('color', '#0c9');
                    $('#gender').val(val);
                });
	</script>
<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>