<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page("system_header");?>
     <form  method="post" class="form-horizontal form">
 <div class="panel ">
 	
 	  <h3 class="custom_page_header">插件管理</h3>
       <div class="panel-body">
 	
 	<table class="table">
                <thead>
                    <tr>
                        <th class="text-center">插件名称</th>
                        <th class="text-center">标识</th>
                         <th class="text-center">版本</th>
                        <th class="text-center">状态</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                 <tbody>
                 	<?php  if(is_array($modules_list)&&!empty($modules_list)) { foreach($modules_list as $item) { ?>
				<tr>
				  <td class="text-center"><?php  echo $item['title'];?></td>
				  		  <td class="text-center"><?php  echo $item['name'];?></td>
				  		    <td class="text-center"><?php  echo $item['version'];?> <?php if($item['status']==2){ ?><br/><label data="1" class="label  label-default label-info">可更新版本<?php  echo $item['new_version'];?></label><?php   } ?></td>
				  		  	  		  <td class="text-center">
				  		  	  		  	 <?php if($item['status']==1){ ?> <label data="1" class="label label-success">已安装</label><?php   } ?>
				  		  	  		  	 <?php if($item['status']==2){ ?> <label data="1" class="label label-warning">待更新</label><?php   } ?>
          	<?php if(empty($item['status'])){ ?> <label data="1" class="label label-default  label-danger">未安装</label><?php   } ?>
				  		  	  		  	</td>
        <td class="text-center">
       	
       		 
       		 <?php if(empty($item['status'])){ ?> 
       		 
       		 	<a class="btn btn-default btn-sm"  href="<?php  echo web_url('modules', array('op'=>'install','module_name'=>$item['name']))?>" >
                                   <i class="fa fa-cog"></i>&nbsp;安&nbsp;装&nbsp;                               
                                </a>
                                
                                
       		 <?php   } ?>
       		 
       		  <?php if($item['status']==2){ ?> 
       		 
       		 	<a class="btn btn-default btn-sm"  href="<?php  echo web_url('modules', array('op'=>'update','module_name'=>$item['name']))?>" >
                                   <i class="fa fa-cog"></i>&nbsp;更&nbsp;新&nbsp;                               
                                </a>
       		 <?php   } ?>
       		 
       		 	 <?php if(!empty($item['status'])){ ?> 
       		 
       		 	<a class="btn btn-default btn-sm"  onclick="return confirm('确认卸载此模块？');return false;"  href="<?php  echo web_url('modules', array('op'=>'uninstall','module_name'=>$item['name']))?>" >
                                   <i class="fa fa-times"></i>&nbsp;卸&nbsp;载&nbsp;                               
                                </a>
       		 <?php   } ?>
       		   </td>			
				</tr>
				<?php  } }else{ ?> 
				
				<tr>
							<td colspan="6">
                              <div style="text-align: center;padding:30px;">
                                  暂时没有找到插件
                              </div>	</td>
						</tr>
					<?php  }  ?>
 	 	</tbody>
		</table>
 	
 </div>
</div>
</form><?php include page("footer-base");?>