<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page("system_header");?>


	  <div class="panel ">
        
            <h3 class="custom_page_header">   店铺管理     <a class='btn btn-default' href="<?php  echo create_url('site', array('act' => 'manager','do' => 'store','op'=>'post'))?>"><i class='fa fa-plus'></i> 添加店铺</a>
       </h3>
<div class="panel-body">
            <form  method="post" class="form-horizontal" plugins="form">
                
                <div class="form-group">
                	  <div class="col-sm-1  control-label">
                    店铺名称
                    </div>
                    <div class="col-sm-4">
                      <input class="form-control" name="sname" id="" type="text" value="<?php  echo $_GPC['sname'];?>" placeholder="店铺名称关键字搜索">
                    </div>
                      <div class="col-sm-4 ">
                       
                    &nbsp; &nbsp; <button class="btn btn-default"><i class="fa fa-search"></i> &nbsp; &nbsp; 搜索 &nbsp; &nbsp;</button>  </div>
 
                </div>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">店铺名称</th>
                            <th class="text-center">绑定域名</th>
                        <th class="text-center">状态</th>
                        <th class="text-center">操作</th>
                    </tr>
                </thead>
                 <tbody>
                 		<?php  if(is_array($store_list)) { foreach($store_list as $item) { ?>
				<tr>
	
          <td class="text-center">
          	<?php echo $item['sname']; ?>
          	</td>
           <td class="text-center"><?php echo $item['website']; ?></td>
          <td class="text-center">
          	 <?php if(empty($item['isclose'])){ ?> <label data="1" class="label label-success">正常</label><?php   } ?>
          	<?php if(!empty($item['isclose'])){ ?> <label data="1" class="label label-default  label-danger">关闭</label><?php   } ?></td>
            <td class="text-center">
           	<a href="<?php  echo create_url('site',array('act' => 'manager','do' => 'loginstore','beid'=> $item['id']))?>" class="btn btn-default btn-sm"  target="_blank" style="color: #d9534f;"><i class="fa fa-cog"></i>店铺管理</a>
             <br/>   <br/> <a href="<?php  echo web_url('store', array('op' => 'post', 'id' => $item['id']))?>"  class="btn btn-default btn-sm"  ><i class="fa fa-pencil"></i>&nbsp;修&nbsp;改&nbsp;</a> 
             		
                    	&nbsp;&nbsp;	<a  onclick="return confirm('此操作不可恢复，确认关闭？');return false;"  href="<?php  echo web_url('store', array('op' => 'delete', 'id' => $item['id']))?>"   class="btn btn-default btn-sm"  ><i class="fa fa-times"></i>&nbsp;关&nbsp;闭&nbsp;</a> </td>
                             </td>
				</tr>
				<?php  } } ?>
                </tbody>
            </table>
 
        </div>
     
    </div>


<?php include page("footer-base");?>