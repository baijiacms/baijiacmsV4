<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page("system_header");?>
<form  method="post" class="form-horizontal form">
<?php  if($operation=='display')
 {?>		
 <div class="panel ">
        
            <h3 class="custom_page_header">   数据库备份  <a class='btn btn-default' href="<?php  echo create_url('site', array('act' => 'manager','do' => 'database','op'=>'restore'))?>"><i class='fa fa-link'></i> 数据库还原</a>  </h3>
	  <div class="panel-body">
	  	   	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">日期</label>
                    <div class="col-sm-9 col-xs-12">
                       	<?php  echo date('Ymd', time())?>
                    </div>
                </div>
                
                 	   	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                       <input type="submit" name="submit" value="备份商城数据" class="btn btn-warning col-lg-3">
                    </div>
                </div>
	  	
	  	</div>
	  		</div>			
				<?php }?>	
				
				
				<?php  if($operation=='restore'){?>
				         <h3 class="custom_page_header">   数据库还原  <a class='btn btn-default' href="<?php  echo create_url('site', array('act' => 'manager','do' => 'database'))?>"><i class='fa fa-pencil'></i> 数据库备份</a> <strong style="color:red">此操作不可还原，请慎重操作。 </strong> </h3>
	
 	 <table class="table">
                <thead>
                <tr >
  	 <th class="text-center" >备份名称</th>
 <th class="text-center" >备份时间</th>
    <th class="text-center">分卷数量</th>
	<th class="text-center" >操作</th>
  </tr>
                </thead>
                 <tbody>
                 	<?php if(is_array($ds)) { foreach($ds as $item) { ?>
				<tr>
										<td style="text-align:center;"><?php  echo $item['bakdir'];?></td>
															<td style="text-align:center;"><?php  echo date('Y-m-d H:i:s', $item['time']);?></td>
																				<td style="text-align:center;"><?php  echo $item['volume'];?></td>
																									<td style="text-align:center;">
																										
				<a  class="btn btn-default btn-sm"href="<?php  echo 			create_url('site', array('act' => 'manager','do' => 'database','op'=>'torestore','id'=>base64_encode($item['bakdir'])));?>" onclick="return confirm('确认开始还原，此操作不可恢复？');return false;"><i class="fa fa-pencil"></i>&nbsp;还原此备份&nbsp;</a></a>

				<a class="btn btn-default btn-sm" href="<?php  echo 			create_url('site', array('act' => 'manager','do' => 'database','op'=>'delete','id'=>base64_encode($item['bakdir'])));?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;"><i class="fa fa-times"></i>&nbsp;删&nbsp;除&nbsp;</a></a>
			
																										</td>
				</tr>
			<?php } } ?>
 	
   </tbody>
            </table>
 

<?php } ?>	
<?php include page("footer-base");?>