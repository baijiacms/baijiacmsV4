<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<form id="setform"  action="" method="post" class="form-horizontal form">
    <div class='panel panel-default'>
    	<h3 class="custom_page_header"> 基础设置</h3>
           <div class='panel-heading'>
            分销等级设置
        </div> 
        <div class='panel-body'>

            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销层级</label>
                <div class="col-sm-4">
                    <select  class="form-control" name="level">
                        <option value="0" <?php  if(empty($set['level'])) { ?>selected<?php  } ?>>不开启分销机制</option>
                        <option value="1" <?php  if($set['level']==1) { ?>selected<?php  } ?>>开启一级分销</option>
                        <option value="2" <?php  if($set['level']==2) { ?>selected<?php  } ?> >开启二级分销</option>
                        <option value="3" <?php  if($set['level']==3) { ?>selected<?php  } ?> >开启三级分销</option>
                    </select>
	              </div>
            </div> 
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">默认等级分销佣金比例</label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">一级</div>
                        <input type="text" name="commission1" class="form-control" value="<?php echo $set['commission1'];?>"  />
                        <div class="input-group-addon">%</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">二级</div>
                        <input type="text" name="commission2" class="form-control" value="<?php echo $set['commission2'];?>"  />
                        <div class="input-group-addon">%</div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <div class="input-group-addon">三级</div>
                        <input type="text" name="commission3" class="form-control" value="<?php echo $set['commission3'];?>"  />
                        <div class="input-group-addon">%</div>
                    </div>
                  <span class='help-block'>新加入的分销商（默认等级），采用此默认比例</span>
		<span class='help-block'>分销佣金计算优先级： 商品固定佣金比例 > 分销商等级佣金比例 >默认佣金比例</span>
			<div class='help-block'>其他等级佣金比例请到<a href='<?php  echo $this->createWebUrl('commission/level')?>' target='_blank'>【分销商等级】</a>进行设置</div>
  
                </div>
            </div>
                    <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销内购</label>
                <div class="col-sm-9 col-xs-12">
                     <label class="radio-inline"><input type="radio"  name="selfbuy" value="0" <?php  if($set['selfbuy'] ==0) { ?> checked="checked"<?php  } ?> /> 关闭</label>
                    <label class="radio-inline"><input type="radio"  name="selfbuy" value="1" <?php  if($set['selfbuy'] ==1) { ?> checked="checked"<?php  } ?> /> 开启</label>
                    <span class='help-block'>开启分销内购，分销商自己购买商品，享受一级佣金，上级享受二级佣金，上上级享受三级佣金</span>
                </div>
            </div>
            
             <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销中心访问权限</label>
                <div class="col-sm-9 col-xs-12">
                     <label class="radio-inline"><input type="radio"  name="commission_limit" value="0" <?php  if($set['commission_limit'] ==0) { ?> checked="checked"<?php  } ?> /> 全网访问</label>
                    <label class="radio-inline"><input type="radio"  name="commission_limit" value="1" <?php  if($set['commission_limit'] ==1) { ?> checked="checked"<?php  } ?> /> 禁止微信访问</label>
             <?php if(false){?>   <label class="radio-inline"><input type="radio"  name="commission_limit" value="2" <?php  if($set['commission_limit'] ==2) { ?> checked="checked"<?php  } ?> /> 只允许钉钉访问</label><?php } ?>
                </div>
            </div>
            
        </div>
        <div class='panel-heading'>
            分销设置
        </div>
        <div class='panel-body'>
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">成为下线条件</label>
                <div class="col-sm-9 col-xs-12">
                    <label class="radio-inline"><input type="radio"  name="become_child" value="0" <?php  if($set['become_child'] ==0) { ?> checked="checked"<?php  } ?> /> 首次点击分享连接</label>
                    <label class="radio-inline"><input type="radio"  name="become_child" value="1" <?php  if($set['become_child'] ==1) { ?> checked="checked"<?php  } ?> /> 首次下单</label>
                    <label class="radio-inline"><input type="radio"  name="become_child" value="2" <?php  if($set['become_child'] ==2) { ?> checked="checked"<?php  } ?> /> 首次付款</label>
                    <span class='help-block'>首次点击分享连接： 可以自由设置分销商条件</span>
                    <span class='help-block'>首次下单/首次付款： 无条件不可用</span>
                </div>
               </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">成为分销商条件</label>
                <div class="col-sm-9 col-xs-12">
                    <label class="radio-inline"><input type="radio"  name="become" value="0" <?php  if($set['become'] ==0) { ?> checked="checked"<?php  } ?> /> 无条件</label>
                </div> 
            </div>
            <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-6">
                         <label class="radio-inline"><input type="radio"  name="become" value="1" <?php  if($set['become'] ==1) { ?> checked="checked"<?php  } ?> /> 手动</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-6">
                         <div class='input-group' style='border:none;margin-left:-12px;'>
                            <div class='input-group-addon'  style='border:none;background:#fff;'><label class="radio-inline" style='margin-top:-3px;'><input type="radio"  name="become" value="2" <?php  if($set['become'] == 2) { ?> checked="checked"<?php  } ?> /> 消费达到</label></div>
                            <input type='text' class='form-control' name='become_ordercount' value="<?php  echo $set['become_ordercount'];?>" />
                            <div class='input-group-addon'  style='border:none;background:#fff;'>次</div>
                        </div>
                    </div>
                </div>
      

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-6">
                          <div class='input-group' style='border:none;margin-left:-12px;'>
                            <div class='input-group-addon'  style='border:none;background:#fff;'><label class="radio-inline" style='margin-top:-3px;'><input type="radio"  name="become" value="3" <?php  if($set['become'] == 3) { ?> checked="checked"<?php  } ?> /> 消费达到</label></div>
                            <input type='text' class='form-control' name='become_moneycount' value="<?php  echo $set['become_moneycount'];?>" />
                            <div class='input-group-addon'  style='border:none;background:#fff;'>元</div>
                        </div>
                          <div class='input-group' style='border:none;margin-top:5px;margin-left:-12px;'>
                            <div class='input-group-addon'  style='border:none;background:#fff;'><label class="radio-inline" style='margin-top:-3px;'>或一次性消费</label></div>
                            <input type='text' class='form-control' name='become_xmoneycount' value="<?php  echo $set['become_xmoneycount'];?>" />
                            <div class='input-group-addon'  style='border:none;background:#fff;'>元</div>
                        </div>
                    </div>
                </div>
			
			 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-6">
                       <input type='hidden' class='form-control' id='goodsid' name='become_goodsid' value="<?php  echo $set['become_goodsid'];?>" />
                          <div class='input-group' style='border:none;margin-left:-12px;'>
                            <div class='input-group-addon'  style='border:none;background:#fff;'><label class="radio-inline" style='margin-top:-3px;'><input type="radio"  name="become" value="4" <?php  if($set['become'] == 4) { ?> checked="checked"<?php  } ?> /> 购买商品</label></div>
                            <input type='text' class='form-control' id='goods' value="<?php  if(!empty($goods)) { ?>[<?php  echo $goods['id'];?>]<?php  echo $goods['title'];?><?php  } ?>" readonly />
                            <div class="input-group-btn">
								<button type="button" onclick="$('#modal-goods').modal()" class="btn btn-default" >选择商品</button>
			   </div>
                        </div>
                    </div>
                </div>
			
      <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                <div class="col-sm-9 col-xs-12">
                    <label class="radio-inline"><input type="radio"  name="become_order" value="0" <?php  if($set['become_order'] ==0) { ?> checked="checked"<?php  } ?> /> 付款后</label>
                    <label class="radio-inline"><input type="radio"  name="become_order" value="1" <?php  if($set['become_order'] ==1) { ?> checked="checked"<?php  } ?> /> 完成后</label>
                    <span class="help-block">消费条件统计的方式</span>
                </div>
           </div>
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销商必须完善资料</label>
                <div class="col-sm-9 col-xs-12">
                    <label class="radio-inline"><input type="radio"  name="become_reg" value="0" <?php  if($set['become_reg'] ==0) { ?> checked="checked"<?php  } ?> /> 需要</label>
                    <label class="radio-inline"><input type="radio"  name="become_reg" value="1" <?php  if($set['become_reg'] ==1) { ?> checked="checked"<?php  } ?> /> 不需要</label>
                    <span class="help-block">分销商在分销或提现时是否必须完善资料</span>
                </div>
           </div>
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">成为分销商是否需要审核</label>
                <div class="col-sm-9 col-xs-12">
                    <label class="radio-inline"><input type="radio"  name="become_check" value="0" <?php  if($set['become_check'] ==0) { ?> checked="checked"<?php  } ?> /> 需要</label>
                    <label class="radio-inline"><input type="radio"  name="become_check" value="1" <?php  if($set['become_check'] ==1) { ?> checked="checked"<?php  } ?> /> 不需要</label>
                    <span class="help-block">以上条件达到后，是否需要审核才能成为真正的分销商</span>
                </div>
           </div>
            
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">提现额度</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="withdraw" class="form-control" value="<?php echo empty($set['withdraw'])?1:$set['withdraw']?>"  />
                    <span class="help-block">分销商的佣金达到此额度时才能提现,最低1元</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">开启提现到余额</label>
                <div class="col-sm-9 col-xs-12">
                    <label class="radio-inline"><input type="radio"  name="closetocredit" value="0" <?php  if($set['closetocredit'] ==0) { ?> checked="checked"<?php  } ?> /> 开启</label>
                    <label class="radio-inline"><input type="radio"  name="closetocredit" value="1" <?php  if($set['closetocredit'] ==1) { ?> checked="checked"<?php  } ?> /> 关闭</label>
                    <span class="help-block">是否允许用户佣金提现到余额，否则只允许微信提现</span>
                </div>
            </div>
               <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">结算天数</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="settledays" class="form-control" value="<?php  echo $set['settledays'];?>"  />
                    <span class="help-block">当订单完成后的n天后，佣金才能申请提现</span>
                </div>
            </div>
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销等级说明连接</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="levelurl" class="form-control" value="<?php  echo $set['levelurl'];?>"  />
                    <span class="help-block">分销等级说明连接</span>
                </div>
            </div>
             
	 <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销订单商品详情</label>
                <div class="col-sm-9 col-xs-12">
                	<label class="radio-inline"><input type="radio"  name="openorderdetail" value="0" <?php  if(empty($set['openorderdetail'])) { ?> checked="checked"<?php  } ?> /> 关闭</label>
                    <label class="radio-inline"><input type="radio"  name="openorderdetail" value="1" <?php  if($set['openorderdetail'] ==1) { ?> checked="checked"<?php  } ?> /> 显示</label>
                    
                    <span class="help-block">分销中心分销订单是否显示商品详情</span>
                </div> 
           </div>
	   <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销订单购买者详情</label>
                <div class="col-sm-9 col-xs-12">
                	<label class="radio-inline"><input type="radio"  name="openorderbuyer" value="0" <?php  if(empty($set['openorderbuyer'])) { ?> checked="checked"<?php  } ?> /> 关闭</label>
                    <label class="radio-inline"><input type="radio"  name="openorderbuyer" value="1" <?php  if($set['openorderbuyer'] ==1) { ?> checked="checked"<?php  } ?> /> 显示</label>
                    
                    <span class="help-block">分销中心分销订单是否显示购买者</span>
                </div> 
           </div>
            
           
            
        </div>
 
	  <div class='panel-heading'>
            分销商等级升级设置
        </div>
	<div class='panel-body'>

		  <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销商等级升级依据</label>
                <div class="col-sm-9 col-xs-12">
              
                        <label class="radio radio-inline" style="width:240px">
                              <input type="radio" name="leveltype" value="0" <?php  if(empty($set['leveltype'])) { ?>checked<?php  } ?>/> 分销订单总额(完成的订单)
                        </label>
		    <label class="radio radio-inline" style="width:240px">
                              <input type="radio" name="leveltype" value="1" <?php  if($set['leveltype']==1) { ?>checked<?php  } ?>/> 一级分销订单金额(完成的订单)
                        </label>		<br/>
						
					
		   <label class="radio radio-inline" style="width:240px">
                              <input type="radio" name="leveltype" value="2" <?php  if($set['leveltype']==2) { ?>checked<?php  } ?>/> 分销订单总数(完成的订单)
                        </label>
						   <label class="radio radio-inline" style="width:240px">
                              <input type="radio" name="leveltype" value="3" <?php  if($set['leveltype']==3) { ?>checked<?php  } ?>/> 一级分销订单总数(完成的订单)
                        </label>
				<br /><br />	
		   <label class="radio radio-inline" style="width:240px">
                              <input type="radio" name="leveltype" value="4" <?php  if($set['leveltype']==4) { ?>checked<?php  } ?>/> 自购订单金额(完成的订单)
                        </label>		
						<label class="radio radio-inline" style="width:240px">
                              <input type="radio" name="leveltype" value="5" <?php  if($set['leveltype']==5) { ?>checked<?php  } ?>/> 自购订单数量(完成的订单)
                        </label>		
<br/>				
		   
		 <br />
	              <label class="radio radio-inline" style="width:240px">
                              <input type="radio" name="leveltype" value="6" <?php  if($set['leveltype']==6) { ?>checked<?php  } ?>/> 下线总人数（分销商+非分销商）
                        </label>		
		   <label class="radio radio-inline" style="width:240px">
                              <input type="radio" name="leveltype" value="7" <?php  if($set['leveltype']==7) { ?>checked<?php  } ?>/> 一级下线人数（分销商+非分销商）
                        </label> 
					<br />	
		   <label class="radio radio-inline" style="width:240px">
                              <input type="radio" name="leveltype" value="8" <?php  if($set['leveltype']==8) { ?>checked<?php  } ?>/> 下级分销商总人数
                        </label>		
		   <label class="radio radio-inline" style="width:240px">
                              <input type="radio" name="leveltype" value="9" <?php  if($set['leveltype']==9) { ?>checked<?php  } ?>/> 一级分销商人数
                        </label>
				<br /><br />
				 <label class="radio radio-inline" style="width:240px">
                              <input type="radio" name="leveltype" value="10" <?php  if($set['leveltype']==10) { ?>checked<?php  } ?>/> 已提现佣金总金额
                        </label>	
                        <span class="help-block">默认为分销订单总金额</span> 
                      
                </div>
            </div>
			
             
                  
               <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
            <div class="col-sm-9">
                <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" onclick='return formcheck()' />
                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
            </div>
        </div>
   
        </div>
        
    </div>
</form>
<div id="modal-goods"  class="modal fade" tabindex="-1">
                            <div class="modal-dialog" style='width: 920px;'>
                                <div class="modal-content">
                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择商品</h3></div>
                                    <div class="modal-body" >
                                        <div class="row"> 
                                            <div class="input-group"> 
                                                <input type="text" class="form-control" name="keyword" value="" id="search-kwd-goods" placeholder="请输入商品名称" />
                                                <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_goods();">搜索</button></span>
                                            </div>
                                        </div>
                                        <div id="module-menus-goods" style="padding-top:5px;"></div>
                                    </div>
                                    <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                </div>

                            </div>
                        </div>
<script language='javascript'>
	  function search_goods() {
             if( $.trim($('#search-kwd-goods').val())==''){
                 Tip.focus('#search-kwd-goods','请输入关键词');
                 return;
             }
		$("#module-goods").html("正在搜索....")
		$.get('<?php  echo $this->createWebUrl('shop/query')?>', {
			keyword: $.trim($('#search-kwd-goods').val())
		}, function(dat){
			$('#module-menus-goods').html(dat);
		});
	}
	function select_good(o) {
                              $("#goodsid").val(o.id);
                               $("#goods").val( "[" + o.id + "]" + o.title);
   	               $("#modal-goods .close").click();
	}
	
    function formcheck(){
        var become_child =$(":radio[name='become_child']:checked").val();
        if( become_child=='1'  || become_child=='2' ){
            if( $(":radio[name='become']:checked").val() =='0'){
              alert('成为下线条件选择了首次下单/首次付款，成为分销商条件不能选择无条件!')   ;
              return false;
            }
        }
        return true;
    }
    </script>
<?php include page("footer-base");?>