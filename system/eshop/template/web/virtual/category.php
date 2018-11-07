<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

     <form action="" method="post">
<div class="panel">
	       <h3 class="custom_page_header">虚拟物品-分类管理 
            <input name="button" type="button" class="btn btn-default" value="添加分类" onclick='addCategory()'>
       
           
            <input name="submit" type="submit" class="btn btn-primary" value="保存分类">
         </h3>
    <div class="panel-body table-responsive">
        <table class="table table-hover">
            <thead class="navbar-inner">
                <tr>
                    <th style="width:60px;">ID</th>
                    <th>分类名称</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id='tbody-items'>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td><?php  echo $row['id'];?></td>
                    <td>
                   
                           <input type="text" class="form-control" name="catname[<?php  echo $row['id'];?>]" value="<?php  echo $row['name'];?>">
                     
                    </td>
                    <td>
                         <a href="<?php  echo $this->createWebUrl('virtual/category', array('op' => 'delete', 'id' => $row['id']))?>"class="btn btn-default btn-sm" onclick="return confirm('确认删除此分类?')" title="删除"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                <?php  } } ?> 
              		
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
 
</div>
</form>
<script>
    function addCategory(){
         var html ='<tr>';
         html+='<td><i class="fa fa-plus"></i></td>';
         html+='<td>';
         html+='<input type="text" class="form-control" name="catname[new]" value="">';
         html+='</td><td></td></tr>';;
         $('#tbody-items').append(html);
    }

</script>
 
<?php include page("footer-base");?>

