<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page("header-base");?>
<form  action="" method="post" class="form-horizontal form" enctype="multipart/form-data" >
    <div class='panel'>
         
	 <h3 class="custom_page_header"> 微信号设置</h3>

          	
        <div class='panel-body'>
        	
        		 
	   <?php if($isfirst){ ?>
			<div class="alert alert-info">
  系统检测到你是第一次访问，请先提交后再登录mp.weixin.qq.com进行配置
 </div>
          	<?php } ?>  
          	
          	
              <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">公众号名称</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='weixinname' value="<?php  echo $settings['weixinname'];?>" />
                </div>
            </div>
     
      
         <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span> 接口地址</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='interface' value="<?php echo WEBSITE_ROOT.'api.php?op=weixin'?>" readonly="readonly" />
                </div>
            </div>
            
               <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span> 微信Token</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' id="weixintoken" name='weixintoken' value="<?php  echo $settings['weixintoken'];?>" readonly="readonly"/><a href="javascript:;" onclick="tokenGen();">生成新的</a>
                </div>
            </div>
            
               <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span> EncodingAESKey</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' id="EncodingAESKey" name='EncodingAESKey' value="<?php  echo $settings['EncodingAESKey'];?>" readonly="readonly"/><a href="javascript:;" onclick="EncodingAESKey();">生成新的</a>
                </div>
            </div>
            
               <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span> 公众号AppId</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='weixin_appId' value="<?php  echo $settings['weixin_appId'];?>" />
                </div>
            </div>
    
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span> 公众号AppSecret</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='weixin_appSecret' value="<?php  echo $settings['weixin_appSecret'];?>" />
                </div>
            </div>
            
              <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">授权文件</label>
                <div class="col-sm-9 col-xs-12">
                   	<input type="file" name="weixin_verify_file" class="form-control">
                  				<?php  if(!empty($settings['weixin_hasverify'])){?><span class='help-block' >已上传授权文件：<?php  echo $settings['weixin_hasverify'];?></span><?php  }?>
                    					    <span class='help-block' style="color:red">请注意要上传的授权文件名称，这个会影响到验证是否正确。</span>
                </div>
            </div>
            
             <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">微信号类型</label>
                    <div class="col-sm-9 col-xs-12">
                   
						<label class="radio-inline">
							<input type="radio" name="weixin_noaccess" value='0' <?php  echo empty($settings['weixin_noaccess'])?"checked=\"true\"":"";?> /> 认证微信号
						</label>
						<label class="radio-inline">
							<input type="radio" name="weixin_noaccess" value='1' <?php  echo $settings['weixin_noaccess']==1?"checked=\"true\"":"";?>/> 非认证微信号
						</label>
						
                      
                    </div>
            </div>
            
                   <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">获取微信共享收货地址</label>
                    <div class="col-sm-9 col-xs-12">
                   
						<label class="radio-inline">
							<input type="radio" name="weixin_shareaddress" value='0' <?php  echo empty($settings['weixin_shareaddress'])?"checked=\"true\"":"";?> /> 关闭
						</label>
						<label class="radio-inline">
							<input type="radio" name="weixin_shareaddress" value='1' <?php  echo $settings['weixin_shareaddress']==1?"checked=\"true\"":"";?>/> 开启
						</label>
						    <span class='help-block'>是否在用户添加收货地址时候获取用户的微信收货地址</span>
                      
                    </div>
            </div>
		
			   
            
         <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
            <div class="col-sm-9">
                <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
            </div>
        </div>
        </div>
     
    </div>
</form>
<script type="text/javascript">
    	function EncodingAESKey() {
		var letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		var token = '';
		for(var i = 0; i < 43; i++) {
			var j = parseInt(Math.random() * 61 + 1);
			token += letters[j];
		}
		$(':text[name="EncodingAESKey"]').val(token);
	}
	
	function tokenGen() {
	var letters = 'abcdefghijklmnopqrstuvwxyz0123456789';
	var token = '';
	for(var i = 0; i < 32; i++) {
		var j = parseInt(Math.random() * (31 + 1));
		token += letters[j];
	}
	$(':text[name="weixintoken"]').val(token);
}
		if($('#weixintoken').val()=='')
	{
	tokenGen();
	}
	if($('#EncodingAESKey').val()=='')
	{
	EncodingAESKey();
	}
</script>
<?php include page("footer-base");?>