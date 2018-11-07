<?php defined('SYSTEM_IN') or exit('Access Denied');?>

<?php if($_GPC['store']=='1'){$noleft=1;include page("header-base");}else{include page("system_header");}?>
<form  method="post" class="form-horizontal form">
         <div class="panel ">
            <h3 class="custom_page_header"> 修改密码</h3>
            	  <div class="panel-body">
            	  	 	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">用户名：</label>
                    <div class="col-sm-9 col-xs-12">
              	<input type="text" readonly="readonly" name="username" value="<?php echo $username ?>" class="form-control" />
                    </div>
                </div>
                
                	 	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">原密码：</label>
                    <div class="col-sm-9 col-xs-12">
              	 			 <input type="password" name="oldpassword" class="form-control"  />
                    </div>
                </div>


  	 	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">新密码：</label>
                    <div class="col-sm-9 col-xs-12">
              	 			 <input type="password" name="newpassword" class="form-control"  />
                    </div>
                </div>
                
                	 	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">新密码：</label>
                    <div class="col-sm-9 col-xs-12">
              	 			 <input type="password" name="confirmpassword" class="form-control"  />
                    </div>
                </div>
                
                
	  	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                        
                            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1">
                      </div>
            </div>
            	  	
	</div>
	</div>

</form>
<?php include page("footer-base");?>