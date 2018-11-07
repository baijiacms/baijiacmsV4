<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<?php  if($operation == 'post') { ?>
<div class="main">
    <form action="" action="" method="post"  class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $level['id'];?>" />
        <div class='panel panel-default'>
          
	 <h3 class="custom_page_header"> 分销商等级设置</h3>
	 <div class='alert alert-info'>
    提示: 没有设置等级的分销商将按默认设置计算提成。商品指定的佣金金额的优先级仍是最高的，也就是说只要商品指定了佣金金额就按商品的佣金金额来计算，不受等级影响
</div>
            <div class='panel-body'>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 等级名称</label>
                    <div class="col-sm-9 col-xs-12">
					
                        <input type="text" name="levelname" class="form-control" value="<?php  echo $level['levelname'];?>" />
				
                    </div>
                </div>
                <?php  if($set['level']>=1) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">一级佣金比例</label>
                    <div class="col-sm-9 col-xs-12">
					
                        <input type="text" name="commission1" class="form-control" value="<?php  echo $level['commission1'];?>" />
					
                    </div>
                </div>
                <?php  } ?>
                  <?php  if($set['level']>=2) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">二级佣金比例</label>
                    <div class="col-sm-9 col-xs-12">
                
                        <input type="text" name="commission2" class="form-control" value="<?php  echo $level['commission2'];?>" />
				
                    </div>
                </div>
                    <?php  } ?>
                  <?php  if($set['level']>=3) { ?>
                  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">三级佣金比例</label>
                    <div class="col-sm-9 col-xs-12">
                 
                        <input type="text" name="commission3" class="form-control" value="<?php  echo $level['commission3'];?>" />
				
                    </div>
                </div>
                    <?php  } ?>
					<?php  if($level['id']!='default') { ?>
                  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">升级条件</label>
                    <div class="col-sm-9 col-xs-12">
					
                        <div class='input-group'>
							<?php  if($leveltype==0) { ?>
									<span class='input-group-addon'>分销订单金额满</span>
									<input type="text" name="ordermoney" class="form-control" value="<?php  echo $level['ordermoney'];?>" />
									<span class='input-group-addon'>元</span>
								 
							<?php  } ?>
							
							<?php  if($leveltype==1) { ?>
									<span class='input-group-addon'>一级分销订单金额满</span>
									<input type="text" name="ordermoney" class="form-control" value="<?php  echo $level['ordermoney'];?>" />
									<span class='input-group-addon'>元</span>
							<?php  } ?>
							 
							
							<?php  if($leveltype==2) { ?>
									<span class='input-group-addon'>分销订单数量满</span>
									<input type="text" name="ordercount" class="form-control" value="<?php  echo $level['ordercount'];?>" />
									<span class='input-group-addon'>个</span>
							<?php  } ?>
							
							<?php  if($leveltype==3) { ?>
									<span class='input-group-addon'>一级分销订单数量满</span>
									<input type="text" name="ordercount" class="form-control" value="<?php  echo $level['ordercount'];?>" />
									<span class='input-group-addon'>个</span>
							<?php  } ?>
							
							<?php  if($leveltype==4) { ?>
									<span class='input-group-addon'>自购订单金额满</span>
									<input type="text" name="ordermoney" class="form-control" value="<?php  echo $level['ordermoney'];?>" />
									<span class='input-group-addon'>元</span>
							<?php  } ?>
							
							<?php  if($leveltype==5) { ?>
									<span class='input-group-addon'>自购订单数量满</span>
									<input type="text" name="ordercount" class="form-control" value="<?php  echo $level['ordercount'];?>" />
									<span class='input-group-addon'>个</span>
							<?php  } ?>
							<?php  if($leveltype==6) { ?>
									<span class='input-group-addon'>下级总人数满</span>
									<input type="text" name="downcount" class="form-control" value="<?php  echo $level['downcount'];?>" />
									<span class='input-group-addon'>个（分销商+非分销商）</span>
							<?php  } ?>
							<?php  if($leveltype==7) { ?>
									<span class='input-group-addon'>一级下级人数满</span>
									<input type="text" name="downcount" class="form-control" value="<?php  echo $level['downcount'];?>" />
									<span class='input-group-addon'>个（分销商+非分销商）</span>
							<?php  } ?>
							<?php  if($leveltype==8) { ?>
									<span class='input-group-addon'>团队总人数满</span>
									<input type="text" name="downcount" class="form-control" value="<?php  echo $level['downcount'];?>" />
									<span class='input-group-addon'>个（分销商）</span>
							<?php  } ?>
							<?php  if($leveltype==9) { ?>
									<span class='input-group-addon'>一级团队人数满</span>
									<input type="text" name="downcount" class="form-control" value="<?php  echo $level['downcount'];?>" />
									<span class='input-group-addon'>个（分销商）</span>
							<?php  } ?>
							 
							<?php  if($leveltype==10) { ?>
									<span class='input-group-addon'>已提现佣金总金额满</span>
									<input type="text" name="commissionmoney" class="form-control" value="<?php  echo $level['commissionmoney'];?>" />
									<span class='input-group-addon'>元</span>
							<?php  } ?>
							
							
                        </div>
                        <span class='help-block'>分销商升级条件，不填写默认为不自动升级</span>
						
				
                    </div>
                </div>
					<?php  } ?>
                

            </div>
        </div>
     
	
	
	<div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
            <div class="col-sm-9">
          <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
	<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
  </div>
        </div>
   
	
    </form>
</div>
<script language='javascript'>
    $('form').submit(function(){
        if($(':input[name=levelname]').isEmpty()){
            Tip.focus($(':input[name=levelname]'),'请输入等级名称!');
            return false;
        }
        return true;
    })
    </script>
<?php  } else if($operation == 'display') { ?>
            <form action="" method="post" onsubmit="return formcheck(this)">
     <div class='panel panel-default'>
          
	 <h3 class="custom_page_header"> 分销商等级设置                     <a class='btn btn-default' href="<?php  echo $this->createWebUrl('commission/level', array('op' => 'post'))?>"><i class="fa fa-plus"></i> 添加新等级</a>
       </h3>
         <div class='panel-body'>
   
            <table class="table">
                <thead>
                    <tr>
                        <th>等级名称</th>
                        <?php  if($set['level']>=1) { ?><th>一级佣金比例</th><?php  } ?>
                        <?php  if($set['level']>=2) { ?><th>二级佣金比例</th><?php  } ?>
                        <?php  if($set['level']>=3) { ?><th>三级佣金比例</th><?php  } ?>
                        <th>升级条件</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr <?php  if($row['id']=='default') { ?>style='background:#ddd'<?php  } ?>>
                        <td><?php  echo $row['levelname'];?><?php  if($row['id']=='default') { ?>【默认等级】<?php  } ?></td>
                        <?php  if($set['level']>=1) { ?><td><?php  echo $row['commission1'];?>%</td><?php  } ?>
                         <?php  if($set['level']>=2) { ?><td><?php  echo $row['commission2'];?>%</td><?php  } ?>
                          <?php  if($set['level']>=3) { ?><td><?php  echo $row['commission3'];?>%</td><?php  } ?>
                          <td>	<?php  if($row['id']!='default') { ?>
						<?php  if($leveltype==0) { ?><?php  if($row['ordermoney']>0) { ?>分销订单金额满 <?php  echo $row['ordermoney'];?> 元 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==1) { ?><?php  if($row['ordermoney']>0) { ?>一级分销订单金额满 <?php  echo $row['ordermoney'];?> 元 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==2) { ?><?php  if($row['ordercount']>0) { ?>分销订单数量满 <?php  echo $row['ordercount'];?> 个 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==3) { ?><?php  if($row['ordercount']>0) { ?>一级分销订单数量满 <?php  echo $row['ordercount'];?> 个 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==4) { ?><?php  if($row['ordermoney']>0) { ?>自购订单金额满 <?php  echo $row['ordermoney'];?> 元 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==5) { ?><?php  if($row['ordercount']>0) { ?>自购订单数量满 <?php  echo $row['ordercount'];?> 个 <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						
						<?php  if($leveltype==6) { ?><?php  if($row['downcount']>0) { ?>下级总人数满 <?php  echo $row['downcount'];?> 个（分销商+非分销商） <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==7) { ?><?php  if($row['downcount']>0) { ?>一级下级人数满 <?php  echo $row['downcount'];?> 个（分销商+非分销商） <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						
						<?php  if($leveltype==8) { ?><?php  if($row['downcount']>0) { ?>团队总人数满 <?php  echo $row['downcount'];?> 个（分销商） <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						<?php  if($leveltype==9) { ?><?php  if($row['downcount']>0) { ?>一级团队人数满 <?php  echo $row['downcount'];?> 个（分销商） <?php  } else { ?>不自动升级<?php  } ?><?php  } ?>
						
						 
						<?php  if($leveltype==10) { ?><?php  if($row['commissionmoney']>0) { ?>已提现佣金总金额满 <?php  echo $row['commissionmoney'];?> 元<?php  } else { ?>不自动升级<?php  } ?><?php  } ?>	 
					<?php  } else { ?>
					默认等级
					<?php  } ?>
                          </td>
                        <td>        
                            <a class='btn btn-default' href="<?php  echo $this->createWebUrl('commission/level', array('op' => 'post', 'id' => $row['id']))?>" title="修改"><i class='fa fa-edit'></i></a>
                          
                            <?php  if($row['id']!='default') { ?>
			
								<a class='btn btn-default'  href="<?php  echo $this->createWebUrl('commission/level', array('op' => 'delete', 'id' => $row['id']))?>" onclick="return confirm('确认删除此等级吗？');return false;" title='删除'><i class='fa fa-remove'></i></a></td>

						<?php  } ?>

                    </tr>
                    <?php  } } ?>
                
                </tbody>
            </table>

         </div>
        
     </div>
         </form>
<?php  } ?>
<?php include page("footer-base");?>