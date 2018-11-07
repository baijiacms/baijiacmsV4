<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page("header-base");?>
<form  action="" method="post" class="form-horizontal form" enctype="multipart/form-data" >
    <div class='panel'>
         
	 <h3 class="custom_page_header"> QQ快捷登陆设置</h3>

          	
        <div class='panel-body'>
 
          	 <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">申请地址</label>
                <div class="col-sm-9 col-xs-12">
                     <a href="http://connect.qq.com" target="_blank">QQ互联</a>
                </div>
            </div>
            	 <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">QQ回调地址</label>
                <div class="col-sm-9 col-xs-12">
                   <input type='text' class='form-control' name='interface' value="<?php echo WEBSITE_ROOT.'api/qq_returnurl.php'?>" readonly="readonly" />
                </div>
            </div>
              <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">appid</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='fastlogin_appid' value="<?php  echo $settings['fastlogin_appid'];?>" />
                </div>
            </div>
      <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">appkey</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='fastlogin_appkey' value="<?php  echo $settings['fastlogin_appkey'];?>" />
                </div>
            </div>
      
             <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">QQ快捷登陆</label>
                    <div class="col-sm-9 col-xs-12">
                   
						<label class="radio-inline">
							<input type="radio" name="fastlogin_open" value='0' <?php  echo empty($settings['fastlogin_open'])?"checked=\"true\"":"";?> /> 关闭
						</label>
						<label class="radio-inline">
							<input type="radio" name="fastlogin_open" value='1' <?php  echo $settings['fastlogin_open']==1?"checked=\"true\"":"";?>/> 开启
						</label>
						
                      
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
<?php include page("footer-base");?>