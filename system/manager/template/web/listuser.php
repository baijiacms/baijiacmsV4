<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page("system_header");?>

	  <div class="panel ">
        
            <h3 class="custom_page_header">   管理员列表     <a class='btn btn-default' href="<?php  echo web_url('user', array('op'=>'edituser'))?>"><i class='fa fa-plus'></i> 新增管理员</a>
       </h3>
<div class="panel-body">
<table class="table">
                <thead>
                    <tr>
                        <th class="text-center">用户名</th>
                        <th class="text-center">类型</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                 <tbody>
                 					<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td style="text-align:center;"><?php  echo $item['username'];?></td>
			
									<td style="text-align:center;"><?php  echo empty($item['is_admin'])?"店铺管理员":"系统管理员";?></td>
						<td style="text-align:center;">
				
						<a class="btn btn-default btn-sm"   href="<?php  echo web_url('user', array('op'=>'changepwd','id' => $item['id']))?>"><i  class="fa fa-link"></i>修改密码</a>&nbsp;&nbsp;
					
						<a class="btn btn-default btn-sm"  href="<?php  echo web_url('user', array('op'=>'edituser','id' => $item['id']))?>" ><i  class="fa fa-pencil"></i>&nbsp;编&nbsp;辑&nbsp;</a>
						<a class="btn btn-default btn-sm"  href="<?php  echo web_url('user', array('op'=>'deleteuser','id' => $item['id']))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;"><i  class="fa fa-times"></i>&nbsp;删&nbsp;除&nbsp;</a>
					</td>
				</tr>
				<?php  } } ?>
                 	</tbody>
		</table>
                 	
                 	
</div>
</div>
<?php include page("footer-base");?>
