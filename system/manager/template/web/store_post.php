<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page("system_header");?>
     <form  method="post" class="form-horizontal form">
 <div class="panel ">
        
            <h3 class="custom_page_header">   店铺编辑   </h3>
       <div class="panel-body">
       
            	<input type="hidden" name="id" value="<?php echo $store['id'];?>" />
            	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">店铺名称<span style="color:red">*</span></label>
                    <div class="col-sm-9 col-xs-12">
                       	<input type="text" name="sname" class="form-control" value="<?php echo $store['sname'];?>" />
                    </div>
                </div>

 	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">绑定域名<span style="color:red">*</span></label>
                    <div class="col-sm-9 col-xs-12">
                       	<input type="text" name="website" class="form-control" value="<?php echo $store['website'];?>" />
                   <span class="help-block">如：***.baijiacms.com，请注意格式（***部分可为你定义的英文）不含二级目录和http。</span>
                    </div>
                </div>

 	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">完整域名(选填)</label>
                    <div class="col-sm-9 col-xs-12">
                       	<input type="text" name="fullwebsite" class="form-control" value="<?php echo $store['fullwebsite'];?>" />
                    <span class="help-block"><span style="color:red">可空，系统会自动完善</span>。如特殊情况需手动修改，请注意格式如：http://***/demo/，请注意格式（***部分可为你定义的域名）。</span>
                    </div>
                </div>
            	
            	 	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否开启：</label>
                     <div class="col-sm-9 col-xs-12">
                       
                        <label class="radio-inline">
                            <input type="radio" name="status" value="1'" <?php  if($store['isclose'] == 1) { ?>checked="true"<?php  } ?>> 关闭
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="status" value="0'" <?php  if($store['isclose'] == 0) { ?>checked="true"<?php  } ?>> 开启
                        </label>
                         
                    </div>
                </div>
                
                
                 	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">前台访问链接</label>
                    <div class="col-sm-9 col-xs-12">
                    	   <?php if(!empty($store['id'])){?>
                       	<input  readonly="readlony" type="text" name="mobile_url" class="form-control" value="<?php  if(empty($store['fullwebsite'])) { ?>http://<?php echo $store['website'];?>/<?php }else{ ?><?php echo $store['fullwebsite'];?><?php } ?>index.php" /><a target="_blank" href="<?php  if(empty($store['fullwebsite'])) { ?>http://<?php echo $store['website'];?>/<?php }else{ ?><?php echo $store['fullwebsite'];?><?php } ?>index.php">预览</a>
                    <?php }else{?>
													提交后生成链接
														<?php }?>
                    
                    </div>
                </div>
            	
            	
            	    	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">后台访问链接</label>
                    <div class="col-sm-9 col-xs-12">
                    	   <?php if(!empty($store['id'])){?>
                       	<input  readonly="readlony" type="text" name="mobile_url" class="form-control" value="<?php  if(empty($store['fullwebsite'])) { ?>http://<?php echo $store['website'];?>/<?php }else{ ?><?php echo $store['fullwebsite'];?><?php } ?>admin.php" /><a target="_blank" href="<?php  if(empty($store['fullwebsite'])) { ?>http://<?php echo $store['website'];?>/<?php }else{ ?><?php echo $store['fullwebsite'];?><?php } ?>admin.php">预览</a>
                    <?php }else{?>
													提交后生成链接
														<?php }?>
                    
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