<?php defined('SYSTEM_IN') or exit('Access Denied');?><?php  include page('header-base');?>
<form  action="" method="post" class="form-horizontal form" >
    <div class='panel'>
         
	 <h3 class="custom_page_header"> 支付配置</h3>

          	
        <div class='panel-body'>
        	
        	 	  <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付名称</label>
                <div class="col-sm-9 col-xs-12">
                    <?php  echo $item['name'];?>
                </div>
            </div>
            
              <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付授权目录</label>
                <div class="col-sm-9 col-xs-12">
                    
                          <input type='text' class='form-control' name='interface' value="<?php echo WEBSITE_ROOT;?>" readonly="readonly" />
               <span class="help-block">登录mp.weixin.qq.com，点击&#34;微支付&#34;,点击&#34;开发者配置&#34;进行相关设置。</span>
                </div>
            </div>
             	  <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付回调URL</label>
                <div class="col-sm-9 col-xs-12">
                    
                          <input type='text' class='form-control' name='interface' value="<?php echo WEBSITE_ROOT.'api/weixin_returnurl.php';?>" readonly="readonly" />
                </div>
            </div>
             	<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-md-2 control-label">支付方式描述：</label>

										<div class="col-sm-9 col-xs-12">
													  <?php  echo $item['desc'];?>
										</div>
									</div>
									
									
										<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-md-2 control-label">微信支付商户号(MchId)：</label>

										<div class="col-sm-9 col-xs-12">
													  	<input type="text" name="wechat_pay_mchId"  class="form-control"   value="<?php  echo $configs['wechat_pay_mchId'];?>" />
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-md-2 control-label">通信密钥/商户支付密钥(paySignKey/api密钥)：</label>

										<div class="col-sm-9 col-xs-12">
													  	 <input type="text" name="wechat_pay_paySignKey"  class="form-control"  value="<?php  echo $configs['wechat_pay_paySignKey'];?>" />
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