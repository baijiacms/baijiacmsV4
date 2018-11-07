<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page("header-base");?>
<form  action="" method="post" class="form-horizontal form" enctype="multipart/form-data" >
    <div class='panel'>
         
	 <h3 class="custom_page_header"> 分销中心-钉钉快捷登陆设置</h3>

          	
        <div class='panel-body'>
 
          	 <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">申请地址</label>
                <div class="col-sm-9 col-xs-12">
                     <a href="https://oa.dingtalk.com" target="_blank">钉钉企业号注册</a>
                </div>
            </div>
               <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">APPID</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='appid' value="<?php  echo $settings['appid'];?>" />
                </div>
            </div>
                  <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">AgentID</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='fastlogin_agentID' value="<?php  echo $settings['fastlogin_agentID'];?>" />
                </div>
            </div>
            
              <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">CorpID</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='fastlogin_corpID' value="<?php  echo $settings['fastlogin_corpID'];?>" />
                </div>
            </div>
      <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">CorpSecret</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='fastlogin_corpSecret' value="<?php  echo $settings['fastlogin_corpSecret'];?>" />
                </div>
            </div>
      
             <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">钉钉快捷登陆</label>
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