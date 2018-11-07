<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">优惠方式</label>
                <div class="col-sm-9 col-xs-12">
					<input type="hidden" name="coupontype" value="0"/>
                
                     <label class="radio-inline " ><input type="radio" name="backtype" onclick='showbacktype(0)' value="0" <?php  if($item['backtype']==0) { ?>checked<?php  } ?>>立减</label>
                     <label class="radio-inline"><input type="radio" name="backtype" onclick='showbacktype(1)' value="1" <?php  if($item['backtype']==1) { ?>checked<?php  } ?>>打折</label>
                     <label class="radio-inline "><input type="radio" name="backtype" onclick='showbacktype(2)' value="2" <?php  if($item['backtype']==2) { ?>checked<?php  } ?>>返利</label>
                    
                </div>
 </div>
<div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                
              
                    <div class="col-sm-2 backtype backtype0" <?php  if($item['backtype']!=0) { ?>style='display:none'<?php  } ?>>
                    <div class='input-group'>
                        <span class='input-group-addon'>立减</span>
                        <input type='text' class='form-control' name='deduct' value="<?php  echo $item['deduct'];?>"/>
                        <span class='input-group-addon'>元</span>
                     </div>
                        </div>
                     <div class="col-sm-2 backtype backtype1"  <?php  if($item['backtype']!=1) { ?>style='display:none'<?php  } ?>>
                    <div class='input-group'>
                        <span class='input-group-addon'>打</span>
                        <input type='text' class='form-control' name='discount'  placeholder='0.1-10' value="<?php  echo $item['discount'];?>"/>
                        <span class='input-group-addon'>折</span>
                     </div>   </div>
                     <div class="col-sm-5 backtype backtype2"  <?php  if($item['backtype']!=2) { ?>style='display:none'<?php  } ?>>
                    <div class='input-group'>
                        <span class='input-group-addon'>返</span>
                        <input type='text' class='form-control' name='backmoney' value="<?php  echo $item['backmoney'];?>"/>
                        <span class='input-group-addon'>余额 返</span>
                        <input type='text' class='form-control' name='backcredit' value="<?php  echo $item['backcredit'];?>"/>
                        <span class='input-group-addon'>积分 返</span>
                     </div>   
                    　<span class='help-block'>带%为返消费金额的百分比: 如10% ，消费200元，返20元</span>
               </div>
	
                  
                     
                </div>
 
           				
		  <div class="form-group backtype backtype2"  <?php  if($item['backtype']!=2) { ?>style='display:none'<?php  } ?>>
			   <label class="col-xs-12 col-sm-3 col-md-2 control-label">返利方式</label>
			  <div class="col-sm-9 col-xs-12" >
				       
				   <label class="radio-inline" >
					<input type="radio" name="backwhen" value="0" <?php  if($item['backwhen'] == 0) { ?>checked="true"<?php  } ?> /> 交易完成后（过退款期限自动返利）
				</label>
			   
                         <label class="radio-inline"'>
					<input type="radio" name="backwhen" value="1" <?php  if($item['backwhen'] == 1) { ?>checked="true"<?php  } ?> /> 订单完成后（收货后）
				</label>
						  <label   class="radio-inline" >
					<input type="radio" name="backwhen" value="2" <?php  if($item['backwhen'] == 2) { ?>checked="true"<?php  } ?>  /> 订单付款后
				</label>
				
			  </div>
                    </div>
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">退还方式</label>
    <div class="col-sm-9 col-xs-12" >
  
        <label class="radio-inline">
            <input type="radio" name="returntype" value="0" <?php  if($item['returntype'] == 0) { ?>checked="true"<?php  } ?>  onclick="$('.returntype').hide()"/> 不可退还
        </label>
        <label class="radio-inline">
            <input type="radio" name="returntype" value="1" <?php  if($item['returntype'] == 1) { ?>checked="true"<?php  } ?> onclick="$('.returntype').show()" /> 下单取消可退还
        </label>
        
		  <span class='help-block'>会员使用过的优惠券在订单取消或退款后是否自动退回到会员账户</span>
		
         
    </div>
</div>				         