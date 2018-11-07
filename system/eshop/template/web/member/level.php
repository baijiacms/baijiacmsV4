<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<?php  if($operation == 'post') { ?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $level['id'];?>" />
        <div class='panel'>
        
             <h3 class="custom_page_header"> 会员等级设置</h3>
        
            <div class='panel-body'>

                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">等级权重</label>
                    <div class="col-sm-9 col-xs-12">
                     
								<input type="text" name="level" class="form-control" value="<?php  echo $level['level'];?>">
								<span class="help-block">等级权重，数字越大越高级</span>
          
                     
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> <?php  if($id=='default') { ?>默认<?php  } ?>等级名称</label>
                    <div class="col-sm-9 col-xs-12">
                
                        <input type="text" name="levelname" class="form-control" value="<?php  echo $level['levelname'];?>" />
                        
                    </div>
                </div>
	
                  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">升级条件</label>
                    <div class="col-sm-9 col-xs-12">
                  
                        <div class='input-group'>
							<?php  if(empty($shopset['leveltype'])) { ?>
								  <span class='input-group-addon'>完成订单金额满</span>
								   <input type="text" name="ordermoney" class="form-control" value="<?php  echo $level['ordermoney'];?>" />
								   <span class='input-group-addon'>元</span>
							<?php  } ?>
							<?php  if($shopset['leveltype']==1) { ?> 
							<span class='input-group-addon'>完成订单数量满</span>
                            <input type="text" name="ordercount" class="form-control" value="<?php  echo $level['ordercount'];?>" />
                            <span class='input-group-addon'>个</span>
                          
							<?php  } ?>
                        </div>
						  <span class='help-block'>会员升级条件，不填写默认为不自动升级</span>
                        
                    </div>
                </div>

                 <div class="form-group">
                     <label class="col-xs-12 col-sm-3 col-md-2 control-label">折扣</label>
                    <div class="col-sm-9 col-xs-12">
                        
                        <input type="text" name="discount" class="form-control" value="<?php  echo $level['discount'];?>" />
                        <span class='help-block'>请输入0.1~9之间的数字,值为空则不设置折扣以商品折扣为准</span>
                     
                    </div>
                </div>
                
                    <div class="form-group"></div>
            <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                      
                            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"  />
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
           
                       <input type="button" name="back" onclick='history.back()' style='margin-left:10px;' value="返回列表" class="btn btn-default" />
                    </div>
            </div>
                
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
     <div class='panel'>
         
             <h3 class="custom_page_header"> 会员等级设置 <a class='btn btn-default' href="<?php  echo $this->createWebUrl('member/level', array('op' => 'post'))?>"><i class="fa fa-plus"></i> 添加新等级</a></h3>
         <div class='panel-body'>

            <table class="table">
                <thead>
                    <tr>
                        <th>等级权重</th>
                        <th>等级名称</th>
		                <th>等级折扣</th>
                        <th>升级条件</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr <?php  if($row['id']=='default') { ?>style='background:#ddd'<?php  } ?>>
                        <td>
							<?php  if($row['id']=='default') { ?>
							--
							<?php  } else { ?>
							<?php  echo $row['level'];?>
							<?php  } ?>
						</td>
		    
                        <td><?php  echo $row['levelname'];?></td>
						<td><?php  echo $row['discount'];?></td>
                           <td>
							   <?php  if($row['id']=='default') { ?>
							   默认等级
							   <?php  } else { ?>
							  
							   <?php  if(empty($shopset['leveltype'])) { ?>
						 <?php  if($row['ordermoney']>0) { ?>
						      完成订单金额满 <?php  echo $row['ordermoney'];?>元
							  <?php  } else { ?>
							  不自动升级
							  <?php  } ?> 
						 <?php  } ?>
			  <?php  if($shopset['leveltype']==1) { ?>
						     <?php  if($row['ordercount']>0) { ?>
						           完成订单数量满 <?php  echo $row['ordercount'];?>个
							    <?php  } else { ?>
							  不自动升级
							  <?php  } ?>
						 <?php  } ?>
						 <?php  } ?>
                          </td>                            
                        <td>
                      
                            <a class='btn btn-default' href="<?php  echo $this->createWebUrl('member/level', array('op' => 'post', 'id' => $row['id']))?>" title="修改"><i class='fa fa-edit'></i></a>
                       
							<?php  if($row['id']!='default') { ?>
                            
                             <a class='btn btn-default'  href="<?php  echo $this->createWebUrl('member/level', array('op' => 'delete', 'id' => $row['id']))?>" onclick="return confirm('确认删除此等级吗？');return false;"><i class='fa fa-remove'></i></a></td>
                  
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