<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" >
        <input type='hidden' name='op' value="trade" />
        <div class="pane">
	
       
	
  <h3 class="custom_page_header">交易设置 </h3>
            <div class='panel-body'>


                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">完成订单多少天内可申请退款</label>
                    <div class="col-sm-5">
                
                        <div class="input-group">
                            <input type="text" name="trade[refunddays]" class="form-control" value="<?php  echo $set['trade']['refunddays'];?>" />
                            <div class="input-group-addon">天</div>
                        </div>
                        <span class='help-block'>订单完成后 ，用户在x天内可以发起退款申请，设置0天不允许完成订单退款</span>
                      
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">退款说明</label>
                    <div class="col-sm-5">
                      
                        <textarea  name="trade[refundcontent]" class="form-control" value="<?php  echo $set['trade']['refundcontent'];?>" ><?php  echo $set['trade']['refundcontent'];?></textarea>
                        <span class='help-block'>用户在申请退款页面的说明</span>
                      
                    </div>
                </div>
			</div>
	
  <h3 class="custom_page_header">余额设置 </h3>
            <div class='panel-body'>


                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">开启账户充值</label>
                    <div class="col-sm-9 col-xs-12">
                    
                        <label class='radio-inline'><input type='radio' name='trade[closerecharge]' value='0' <?php  if(empty($set['trade']['closerecharge'])) { ?>checked<?php  } ?>/> 开启</label>
                        <label class='radio-inline'><input type='radio' name='trade[closerecharge]' value='1' <?php  if($set['trade']['closerecharge']=='1') { ?>checked<?php  } ?> /> 关闭</label>
                        <span class='help-block'>是否允许用户对账户余额进行充值</span>
                  
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">开启余额提现</label>
                    <div class="col-sm-9 col-xs-12">
                   
                        <label class='radio-inline'><input type='radio' name='trade[withdraw]' value='1' <?php  if($set['trade']['withdraw']==1) { ?>checked<?php  } ?>/> 开启</label>
                        <label class='radio-inline'><input type='radio' name='trade[withdraw]' value='0' <?php  if($set['trade']['withdraw']==0) { ?>checked<?php  } ?> /> 关闭</label>
                        <span class='help-block'>是否允许用户将余额提出</span>
                   
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">余额提现限制</label>
                    <div class="col-sm-9 col-xs-12">
                      
                        <input type="text" name="trade[withdrawmoney]" class="form-control" value="<?php  echo $set['trade']['withdrawmoney'];?>" />
                        <span class='help-block'>余额满多少才能提现,空或0不限制</span>
                  
                    </div>
                </div>
			</div>

  <h3 class="custom_page_header">积分比例 </h3>

            <div class='panel-body'>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">充值积分比例</label>
                    <div class="col-sm-9 col-xs-12">
                
                        <div class='input-group'>
                            <input type="text" name="trade[money]" class="form-control" value="<?php  echo $set['trade']['money'];?>" />
                            <span class='input-group-addon'>元 增加</span>
                            <input type="text" name="trade[credit]" class="form-control" value="<?php  echo $set['trade']['credit'];?>" />
                            <span class='input-group-addon'>分</span>
                        </div>
                        <span class='help-block'>用户充值获得的积分</span>
                      
                    </div>
                </div>
			</div>
			

  <h3 class="custom_page_header">优惠劵设置 </h3>

            <div class='panel-body'>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">领券中心开启状态</label>
                    <div class="col-sm-9 col-xs-12">
                
                        <div class='input-group'>
                           <label class='radio-inline'><input type='radio' name='coupon[closecenter]' value='0' <?php  if($set['coupon']['closecenter']==0) { ?>checked<?php  } ?>/> 开启</label>
                        <label class='radio-inline'><input type='radio' name='coupon[closecenter]' value='1' <?php  if($set['coupon']['closecenter']==1) { ?>checked<?php  } ?> /> 关闭</label>
                      </div>
                        <span class='help-block'>用户充值获得的积分</span>
                      
                    </div>
                    
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员中心和默认首页<br/>显示优惠劵</label>
                    <div class="col-sm-9 col-xs-12">
                
                        <div class='input-group'>
                           <label class='radio-inline'><input type='radio' name='coupon[closemember]' value='0' <?php  if($set['coupon']['closemember']==0) { ?>checked<?php  } ?>/> 开启</label>
                        <label class='radio-inline'><input type='radio' name='coupon[closemember]' value='1' <?php  if($set['coupon']['closemember']==1) { ?>checked<?php  } ?> /> 关闭</label>
                      </div>
                        <span class='help-block'>会员中心和默认首页显示优惠劵状态</span>
                      
                    </div>
                </div>
                
                
                         <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">充值优惠券统一使用说明</label>
                    <div class="col-sm-9 col-xs-12">
                
                        <div class='input-group'>
                     <?php echo tpl_ueditor('coupon[consumedesc]',$set['coupon']['consumedesc']);?>
                      </div>
                        <span class='help-block'>会员中心和默认首页显示优惠劵状态</span>
                      
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
</form>
<?php include page("footer-base");?>