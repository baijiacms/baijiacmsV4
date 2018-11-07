<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<div class="main">
    <form id="dataform"    action="" method="post" class="form-horizontal form">
        <div class="panel">
           <h3 class="custom_page_header">满额包邮设置 </h3>
            <div class="panel-body">
                    <div class="form-group">
                       <label class="col-xs-12 col-sm-3 col-md-2 control-label">满额包邮</label>
                       <div class="col-sm-9 col-xs-12">
                           <label class="radio-inline">
                               <input type="radio" name="data[enoughfree]" value='1' <?php  if($set['enoughfree']==1) { ?>checked<?php  } ?> /> 开启
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="data[enoughfree]" value='0' <?php  if(empty($set['enoughfree'])) { ?>checked<?php  } ?> /> 关闭
                            </label>
                           <span class='help-block'>开启满包邮, 订单总金额超过多少可以包邮</span>
                         
                       </div>
                   </div> 
                
                  <div class="form-group">
                       <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                       <div class="col-sm-4">
                          <div class='input-group'>
                                   <span class="input-group-addon">单笔订单满</span>
                                   <input type="text" name="data[enoughorder]"  value="<?php  echo $set['enoughorder'];?>" class="form-control" />
                                   <span class='input-group-addon'>元</span>
                           </div>
                           <span class='help-block'>如果开启满额包邮，设置0为全场包邮</span>
                          
                       </div>
                   </div> 
                
                
                  <div class="form-group">
                       <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                       <div class="col-sm-9 col-xs-12">
                           <div id="areas" class="form-control-static"><?php  echo $set['enoughareas'];?></div>
                           <a href="javascript:;" class="btn btn-default" onclick="selectAreas()">添加不参加满包邮的地区</a>
                           <input type="hidden" id='selectedareas' name="data[enoughareas]" value="<?php  echo $set['enoughareas'];?>" />
                         
                       </div>
                   </div> 
                     <div class="form-group">
                       <label class="col-xs-12 col-sm-3 col-md-2 control-label">满额减</label>
                       <div class="col-sm-4">
                       
                          <div class='input-group'>
                                   <span class="input-group-addon">单笔订单满</span>
                                   <input type="text" name="data[enoughmoney]"  value="<?php  echo $set['enoughmoney'];?>" class="form-control" />
                                   <span class='input-group-addon'>元 立减</span>
                                   <input type="text" name="data[enoughdeduct]"  value="<?php  echo $set['enoughdeduct'];?>" class="form-control" />
                                   <span class='input-group-addon'>元</span>
			     <div class="input-group-btn"><button type='button' class="btn btn-default" ><i class="fa fa-minus"></i></button></div>
                           </div>
                        
                       </div>
                   </div> 
				<div class="form-group">
                       <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-4">
						<div class='recharge-items'>
							
							 <?php  if(is_array($set['enoughs'])) { foreach($set['enoughs'] as $item) { ?>
						 
						<div class="input-group recharge-item" style="margin-top:5px"> 
							<span class="input-group-addon">单笔订单满</span>
							<input type="text" class="form-control" name='enough[]' value='<?php  echo $item['enough'];?>' />
							<span class="input-group-addon">元 立减</span>
							<input type="text" class="form-control"  name='give[]' value='<?php  echo $item['give'];?>' />
							<span class="input-group-addon">元</span>
							<div class='input-group-btn'>
							<button class='btn btn-danger' type='button' onclick="removeConsumeItem(this)"><i class='fa fa-remove'></i></button>
							</div>
							 
						</div>
						 <?php  } } ?>
						 </div>  
						 
					   <div style="margin-top:5px"> 
					   <button type='button' class="btn btn-default" onclick='addConsumeItem()' style="margin-bottom:5px"><i class='fa fa-plus'></i> 增加优惠项</button>
					   </div>
						<span class="help-block">两项都填写才能生效</span>
						
						
						 
					 
                       </div>
                   </div>  
              
             
                <div class="form-group"></div>
                   <div class="form-group">
                           <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                           <div class="col-sm-9 col-xs-12">
                                 <input type="submit" name="submit"  value="保存设置" class="btn btn-primary"/>
                                 <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                           </div>
                    </div>
             
            </div>
        </div>
    </form>
</div>
<script language='javascript'>
	function addConsumeItem(){
		var html= '<div class="input-group recharge-item"  style="margin-top:5px">';
           html+='<span class="input-group-addon">单笔订单满</span>';
		 html+='<input type="text" class="form-control" name="enough[]"  />';
							html+='<span class="input-group-addon">元 立减</span>';
							html+='<input type="text" class="form-control"  name="give[]"  />';
							html+='<span class="input-group-addon">元</span>';
							html+='<div class="input-group-btn"><button class="btn btn-danger" onclick="removeRechargeItem(this)"><i class="fa fa-remove"></i></button></div>';
						html+='</div>';
						$('.recharge-items').append(html);
	}
	function removeConsumeItem(obj){
		$(obj).closest('.recharge-item').remove();
	}
	</script>
<?php include $this->template('selectareas', TEMPLATE_INCLUDEPATH);?>
<?php include page("footer-base");?>
