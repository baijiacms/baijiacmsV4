<?php defined('SYSTEM_IN') or exit('Access Denied');?><?php  include page('header-base');?>
<form  action="" method="post" class="form-horizontal form" >
    <div class='panel'>
         
	 <h3 class="custom_page_header"> 支付宝配置</h3>

          	
        <div class='panel-body'>
        	
        	  <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付名称</label>
                <div class="col-sm-9 col-xs-12">
                    <?php  echo $item['name'];?>
                </div>
            </div>
           
        	<div class="form-group">
										<label class="col-xs-12 col-sm-3 col-md-2 control-label">支付方式描述：</label>

										<div class="col-sm-9 col-xs-12">
													  <?php  echo $item['desc'];?>
										</div>
									</div>
									
        	  <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付宝帐户</label>
                <div class="col-sm-9 col-xs-12">
                     <input type="text" name="alipay_account" class="form-control" value="<?php  echo $configs['alipay_account'];?>" />
                </div>
            </div>
            	  <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">APPID</label>
                <div class="col-sm-9 col-xs-12">
                     <input type="text" name="alipay_appid" class="form-control" value="<?php  echo $configs['alipay_appid'];?>" />
                </div>
            </div>
             <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">开放平台密钥<br/>应用私钥RSA(SHA1)</label>
                <div class="col-sm-9 col-xs-12">
                     <input type="text" name="wap_dev_privatekey" class="form-control" value="<?php  echo $configs['wap_dev_privatekey'];?>" />
                </div>
            </div>
              <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">开放平台密钥<br/>支付宝公钥RSA(SHA1)</label>
                <div class="col-sm-9 col-xs-12">
                     <input type="text" name="wap_alipay_publickey" class="form-control" value="<?php  echo $configs['wap_alipay_publickey'];?>" />
                </div>
            </div>
            
           
                 <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">密钥生产指南</label>
                <div class="col-sm-9 col-xs-12">
                    <a href="https://doc.open.alipay.com/docs/doc.htm?treeId=291&articleId=105971&docType=1" target="_blank" style="color:red">支付接入参考文档</a>
                </div>
            </div>
              <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">支付接入参考文档</label>
                <div class="col-sm-9 col-xs-12">
                    <a href="https://doc.open.alipay.com/docs/doc.htm?treeId=203&articleId=105285&docType=1" target="_blank" style="color:red">支付接入参考文档</a>
                </div>
            </div>
            
              <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">申请地址</label>
                <div class="col-sm-9 col-xs-12">
                    <a href="https://openhome.alipay.com/" target="_blank" style="color:red">支付宝申请地址</a>
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