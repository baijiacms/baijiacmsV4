<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<div class="main">
    <form id="dataform"    action="" method="post" class="form-horizontal form">
        <div class="panel ">
            	<h3 class="custom_page_header">抵扣设置 </h3>
          
            <div class="panel-body">
                    <div class="form-group">
                       <label class="col-xs-12 col-sm-3 col-md-2 control-label">积分抵扣</label>
                       <div class="col-sm-9 col-xs-12">
                    
                           <label class="radio-inline">
                               <input type="radio" name="data[creditdeduct]" value='1' <?php  if($set['creditdeduct']==1) { ?>checked<?php  } ?> /> 开启
                           </label>
                           <label class="radio-inline">
                               <input type="radio" name="data[creditdeduct]" value='0' <?php  if(empty($set['creditdeduct'])) { ?>checked<?php  } ?> /> 关闭
                            </label>
                           <span class='help-block'>开启积分抵扣, 商品最多抵扣的数目需要在商品【营销设置】中单独设置</span>
                          
                       </div>
                   </div> 
                   <div class="form-group">
                       <label class="col-xs-12 col-sm-3 col-md-2 control-label">积分抵扣比例</label>
                       <div class="col-sm-5">
                    
                           <div class='input-group'>
                                   <input type="hidden" name="data[credit]" value="1" class="form-control" />
                                   <span class='input-group-addon'>1个积分 抵扣</span>
                                   <input type="text" name="data[money]"  value="<?php  echo $set['money'];?>" class="form-control" />
                                   <span class='input-group-addon'>元</span>
                           </div>
                           <span class='help-block'>积分抵扣比例设置</span>
                       
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
</div><?php include page("footer-base");?>
