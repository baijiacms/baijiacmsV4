<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<?php  if($operation == 'display') { ?>
     <form action="" method="post">
<div class="panel">
	       <h3 class="custom_page_header">文章管理-分类管理 
      <a class='btn btn-default' href="<?php  echo create_url('site',array('act' => 'article','do' => 'category','op' => 'post'))?>"><i class='fa fa-plus'></i> 添加文章</a>
                         
           
            <input name="submit" type="submit" class="btn btn-primary" value="保存分类">
         </h3>
    <div class="panel-body table-responsive">
        <table class="table table-hover">
            <thead class="navbar-inner">
                <tr>
                    <th style="width:80px;">ID</th>
                           <th >显示顺序</th>		
                    <th>分类名称</th>
                    <th >操作</th>
                </tr>
            </thead>
            <tbody >
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td><?php  echo $row['id'];?></td>
                       <td>
                
                           <input type="text" class="form-control" style='width:80px' name="displayorder[<?php  echo $row['id'];?>]" value="<?php  echo $row['displayorder'];?>">
                     
                    </td>
                    <td>
                   
                       <?php  echo $row['category_name'];?>
                     
                    </td>
                    <td >
             	<p>		<a href="<?php  echo  create_url('site',array('do' => 'category','act' => 'article','op' => 'post', 'id' => $row['id']))?>" class="btn btn-default btn-sm" title="修改"><i class="fa fa-edit"></i>修改</a> 
                     <a href="<?php  echo  create_url('site',array('do' => 'category','act' => 'article','op' => 'delete', 'id' => $row['id']))?>"class="btn btn-default btn-sm" onclick="return confirm('确认删除此分类?')" title="删除"><i class="fa fa-times"></i>删除</a>
                 </p>        </td>
                </tr>
                <?php  } } ?> 
              		
            </tbody>
        </table>
    </div>
 
</div>
</form>

<?php  } else if($operation == 'post') { ?>

<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" onsubmit='return formcheck()'>
        <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
        <div class="panel">
        
            <h3 class="custom_page_header">   文章管理-分类管理 </h3>
            <div class="panel-body">
                    <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
                    <div class="col-sm-9 col-xs-12">
                  
                                <input type="text" name="displayorder" class="form-control" value="<?php  echo $item['displayorder'];?>" />
                                <span class='help-block'>数字越大，排名越靠前</span>
                       
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span>分类名称</label>
                    <div class="col-sm-9 col-xs-12">
                       
                        <input type="text" id='category_name' name="category_name" class="form-control" value="<?php  echo $item['category_name'];?>" />
                       
                    </div>
                </div>
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
    function formcheck() {
        if ($("#category_name").isEmpty()) {
            Tip.focus("advname", "请填写分类名称!");
            return false;
        }
        return true;
    }
</script>
<?php  } ?>
 
<?php include page("footer-base");?>

