<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page("system_header");?>
     <form  method="post" class="form-horizontal form">
 <div class="panel ">
        
            <h3 class="custom_page_header">   系统信息   </h3>
       <div class="panel-body">
       	
       	       	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">开发模式：</label>
                    <div class="col-sm-9 col-xs-12">
                          <?php  if($core_development== 1) { ?>开启&nbsp;&nbsp;&nbsp; <a  href="<?php  echo create_url('site', array('act' => 'manager','do' => 'dev','op'=>'development','status'=>0))?>"  >                              
                                        点此关闭</a>【<font style="color:red">非开发者建议关闭</font>】<?php  } ?> <?php  if($core_development== 0) { ?>关闭&nbsp;&nbsp;&nbsp; <a  href="<?php  echo create_url('site', array('act' => 'manager','do' => 'dev','op'=>'development','status'=>1))?>"  >                              
                                        点此开启</a><?php  } ?>
                    </div>
                </div>
                
                   	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">本地版本：</label>
                    <div class="col-sm-9 col-xs-12">
                         百家cms微商城&nbsp;V<?php echo defined('SAPP_VERSION')?SAPP_VERSION:"4.0.0";?>&nbsp;&nbsp;<?php echo $localversion;?>
                    </div>
                </div>
                
                    	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">内核版本：</label>
                    <div class="col-sm-9 col-xs-12">
                          	 百家cms微商城&nbsp;V<?php echo defined('SAPP_VERSION')?SAPP_VERSION:"4.0.0";?>&nbsp;&nbsp;<?php echo CORE_VERSION;?>
                    </div>
                </div>
                
                 	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">服务器系统：</label>
                    <div class="col-sm-9 col-xs-12">
                          		<?php  echo $info['os'];?>
                    </div>
                </div>
                
                
                        	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">PHP版本：</label>
                    <div class="col-sm-9 col-xs-12">
                          			PHP Version <?php  echo $info['php'];?>
                    </div>
                </div>
                
                
                 	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">运行环境软件：</label>
                    <div class="col-sm-9 col-xs-12">
                          				<?php  echo $info['sapi'];?>
                    </div>
                </div>
                
                
                    	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">MySQL 版本：</label>
                    <div class="col-sm-9 col-xs-12">
                          					<?php  echo $info['mysql']['version'];?>
                    </div>
                </div>
                
                 	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">单个附件最大尺寸：</label>
                    <div class="col-sm-9 col-xs-12">
                          				<?php  echo $info['limit'];?>
                    </div>
                </div>
       	
        </div>
 </div>
</form>
<?php include page("footer-base");?>