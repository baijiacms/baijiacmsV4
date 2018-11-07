<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<form id="setform"  action="" method="post" class="form-horizontal form">
    <div class='panel'>
       <h3 class="custom_page_header">优惠券发放通知 </h3>
     
        <div class='panel-body'>
          <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">优惠券发放通知</label>
                    <div class="col-sm-9 col-xs-12">
                    
                        <input type="text" name="coupon_templateid" class="form-control" value="<?php  echo $set['coupon_templateid'];?>" />
                        <div class="help-block">公众平台模板消息编号: OPENTM200605630  </div>
                        <div class="help-block">优惠券的发放或领取通知会优先使用客服消息发送图文消息，如果接收消息会员在４８小时没有互动，则使用模板消息,其他消息默认优先客服消息</div>
                    </div>
        </div>
        
        
        

         <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
            <div class="col-sm-9">
                <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"/>
                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
            </div>
        </div>
        </div>

 
</form>

<?php include page("footer-base");?>