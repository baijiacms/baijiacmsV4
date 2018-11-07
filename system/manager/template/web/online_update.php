<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page("system_header");?>
     <form  method="post" class="form-horizontal form">
 <div class="panel ">
        
            <h3 class="custom_page_header">   在线更新   </h3>
       <div class="panel-body">
       
                    	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">本地版本：</label>
                    <div class="col-sm-9 col-xs-12">
                        百家cms微商城&nbsp;V<?php echo defined('SAPP_VERSION')?SAPP_VERSION:"4.0.0";?>&nbsp;&nbsp;<?php echo CORE_VERSION;?>
                    </div>
                </div>
                
       	  	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">服务器版本：</label>
                    <div class="col-sm-9 col-xs-12">
                    <?php if(!empty($has_update)){?> 
                    
                   百家cms微商城&nbsp;V<?php echo $sapp_version;?>&nbsp;&nbsp;<?php echo $core_version;?>
                  <?php }else{?>
                  
                  <label data="1" class="label label-danger">无法获取到服务器版本！请稍后再试！</label>
                   <?php }?>
                    </div>
                </div>
                
                     <?php if($has_update==2){?> 
                     
                            	  	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                  <label data="1" class="label label-info"> 暂无可用更新</label>
                    </div>
                </div>
                     
                    <?php }?>
                  <?php if($has_update==1){?> 
                	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">更新协议</label>
                    <div class="col-sm-9 col-xs-12">
                          	<div class="checkbox">
					<label>
						<input type="checkbox" id="check_0"> 已经做好相关文件的备份工作
					</label>
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" id="check_1"> 认同官方的更新内容并自愿承担更新所存在的风险
					</label>
				</div>

                    </div>
                </div>
                
                 	  	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                          		<?php  if(CORE_VERSION!=CORE_VERSION){?>
                          		<label class="label label-success">您已经是最新版无需更新。</label>
                          		<?php  }else{ ?>		  
                          	
                          		  <input type="submit" id="toupdate"  name="submit" value="立即更新到最新版本" class="btn btn-primary col-lg-3">
                          		  
                          		  
                          		  	<?php  }?>
                  
                    </div>
                </div>
                
                  	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                	<div class="alert alert-danger">
		<i class="fa fa-exclamation-triangle"></i> 更新时请先备份网站数据库和相关文件！百家cms不强制要求用户跟随百家cms同步更新！
	</div>
	  </div>
             </div>
             
                       <?php }else{?>
                       
                       		  	<?php  }?>
                  
                
        </div>
 </div>
 
 
 
 <div class="alert alert-info refresh-log">
					<h4><i class="fa fa-refresh"></i> 更新日志</h4>
					<ul class="list-unstyled">
					<?php echo $update_logjs;?>
					</ul>
				</div>
</form>
<script type="text/javascript">
	$('#toupdate').click(function(){
		var a = $("#check_0").is(':checked');
		var b = $("#check_1").is(':checked');
		if(a && b) {
			if(confirm('更新将直接覆盖本地文件, 请注意备份文件和数据. \n\n更新过程中不要关闭此浏览器窗口.')) {
			return true;
			}else
				{
								return false;
				}
		} else {
					alert("更新前请仔细阅读更新协议，并同意后打勾方可更新！", '', 'error');
			return false;
		}
	});
</script>

<?php include page("footer-base");?>