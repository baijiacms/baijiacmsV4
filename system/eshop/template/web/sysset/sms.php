<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" >
        <input type='hidden' name='setid' value="<?php  echo $set['id'];?>" />
        <input type='hidden' name='op' value="sms" />
        <div class="panel">
		
           <h3 class="custom_page_header">基本设置 </h3>
            <div class='panel-body'>  
            	
            	     <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">申请地址</label>
                    <div class="col-sm-9 col-xs-12">
                       
                          <a href="http://www.alidayu.com/" target="_blank">申请地址</a>
					

                    </div>
                </div>
                
                   <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">短信验证</label>
                    <div class="col-sm-9 col-xs-12">
                       
                       								   <input type="radio" name="regsiter_usesms" value="0" id="regsiter_usesms" <?php  if($settings['regsiter_usesms'] == 0) { ?>checked="true"<?php  } ?> /> 关闭  &nbsp;&nbsp;
             
              		  <input type="radio" name="regsiter_usesms" value="1" id="regsiter_usesms"  <?php  if($settings['regsiter_usesms'] == 1) { ?>checked="true"<?php  } ?> /> 开启
        

                    </div>
                </div>
                
            	
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">短信key：</label>
                    <div class="col-sm-9 col-xs-12">
                       
                        <input type="text" name="sms_key" class="form-control" value="<?php  echo $settings['sms_key'];?>" />
                     

                    </div>
                </div>
   
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">短信Secret：</label>
                    <div class="col-sm-9 col-xs-12">
                     
                        <input type="text" name="sms_secret" class="form-control" value="<?php  echo $settings['sms_secret'];?>" />
                   

                    </div>
                </div>
				
				
                
                			<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">验证码多久可重发：(秒)</label>
                    <div class="col-sm-9 col-xs-12">
                     
                        <input type="text" name="sms_secret_resec" class="form-control" value="<?php  echo $settings['sms_secret_resec'];?>" />

                    </div>
                </div>
				
					<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">一天同一个业务<br/>最多发送多少条短信：</label>
                    <div class="col-sm-9 col-xs-12">
                     
                        <input type="text" name="sms_secret_count" class="form-control" value="<?php  echo $settings['sms_secret_count'];?>" />

                    </div>
                </div>
                
                	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">用户注册验证码：</label>
                    <div class="col-sm-9 col-lg-9 col-xs-12">
                     
                     <div class="input-group">
                        <div class="input-group-addon">模板ID</div>
                   <input type="text" name="sms_register_user" class="form-control" value="<?php  echo $settings['sms_register_user'];?>"/>
                        <div class="input-group-addon">签名</div>
                       <input type="text" name="sms_register_user_signname" class="form-control" value="<?php  echo $settings['sms_register_user_signname'];?>"/>
                    </div>
                     
              
									
                    </div>
                </div>
                
                	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">修改密码验证码：</label>
                    <div class="col-sm-9 col-xs-12">
                    	
                    	
                    	    <div class="input-group">
                        <div class="input-group-addon">模板ID</div>
                   <input type="text" name="sms_change_pwd1" class="form-control" value="<?php  echo $settings['sms_change_pwd1'];?>"/>
                        <div class="input-group-addon">签名</div>
                   <input type="text" name="sms_change_pwd1_signname" class="form-control" value="<?php  echo $settings['sms_change_pwd1_signname'];?>"/>
                    </div>
                    
									 </div>
                </div>
					<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">密码取回验证码：</label>
                    <div class="col-sm-9 col-xs-12">
                       
                         	    <div class="input-group">
                        <div class="input-group-addon">模板ID</div>
                   <input type="text" name="sms_change_pwd2"  class="form-control" value="<?php  echo $settings['sms_change_pwd2'];?>"/>
                        <div class="input-group-addon">签名</div>
                   <input type="text" name="sms_change_pwd2_signname" class="form-control"  value="<?php  echo $settings['sms_change_pwd2_signname'];?>"/>
                     </div>
                     
										 </div>
                </div>
                
                	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">手机号变更验证码：</label>
                    <div class="col-sm-9 col-xs-12">
                    	
                    	<div class="input-group">
                        <div class="input-group-addon">模板ID</div>
                   <input type="text" name="sms_change_mobile"  class="form-control" value="<?php  echo $settings['sms_change_mobile'];?>"/>
                        <div class="input-group-addon">签名</div>
                  <input type="text" name="sms_change_mobile_signname"  class="form-control"  value="<?php  echo $settings['sms_change_mobile_signname'];?>"/>
                     </div>
                    	
									 </div>
                </div>
				
				<div class="form-group"></div>
            <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                         
                            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"  />
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                       
                     </div>
            </div>
            		
			</div>
			
        </div>     
    </form>
</div>
<?php include page("footer-base");?>     