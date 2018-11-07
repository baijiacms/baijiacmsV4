<?php defined('SYSTEM_IN') or exit('Access Denied');?><?php  include page('header-base');?>
<form  action="" method="post" class="form-horizontal form" >
    <div class='panel'>
         
	 <h3 class="custom_page_header"> 余额配置</h3>
        <div class='panel-body'>
        	  <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付名称</label>
                <div class="col-sm-9 col-xs-12">
                    余额支付
                </div>
            </div>
            
                    	<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-md-2 control-label">支付方式描述：</label>

										<div class="col-sm-9 col-xs-12">
													 账户余额支付
										</div>
									</div>
									
						    <input type="hidden"  name="pay_order" value="0" />
            
            
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否在线支付</label>
                <div class="col-sm-9 col-xs-12">
                     <?php if(empty($item['online'])||$item['online']==0){?>
         	否<?php }else{ ?>
                                是
                                 <?php }?> 
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
 </div>
</form>

<?php  include page('footer-base');?>