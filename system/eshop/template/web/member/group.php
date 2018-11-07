<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<?php  if($operation == 'post') { ?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $group['id'];?>" />
        <div class='panel panel-default'>
      
                 <h3 class="custom_page_header"> 会员分组设置</h3>
       
            <div class='panel-body'>
               
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 分组名称</label>
                    <div class="col-sm-9 col-xs-12">
                     
                        <input type="text" name="groupname" class="form-control" value="<?php  echo $group['groupname'];?>" />
                       
                    </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                     
                            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
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
        if($(':input[name=groupname]').isEmpty()){
            Tip.focus($(':input[name=groupname]'),'请输入分组名称!');
            return false;
        }
        return true;
    })
    </script>
<?php  } else if($operation == 'display') { ?>
               <form action="" method="post" onsubmit="return formcheck(this)">
     <div class='panel'>
           
               <h3 class="custom_page_header"> 会员分组设置                     <a class='btn btn-default' href="<?php  echo $this->createWebUrl('member/group', array('op' => 'post'))?>"><i class="fa fa-plus"></i> 添加新分组</a>
       </h3>
       
         <div class='panel-body'>

            <table class="table">
                <thead>
                    <tr>
                        <th>分组名称</th>
                        <th>会员数</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr>
                        <td><?php  echo $row['groupname'];?></td>
                        <td><?php  echo $row['membercount'];?></td>
                        <td>
                            <a class='btn btn-default' href="<?php  echo $this->createWebUrl('member/list', array('groupid' => $row['id']))?>"><i class='fa fa-users'></i></a>
                            <?php  if(!empty($row['id'])) { ?>
                    
                                <a class='btn btn-default' href="<?php  echo $this->createWebUrl('member/group', array('op' => 'post', 'id' => $row['id']))?>"><i class='fa fa-edit'></i></a>
                
                          
                               <a class='btn btn-default'  href="<?php  echo $this->createWebUrl('member/group', array('op' => 'delete', 'id' => $row['id']))?>" onclick="return confirm('确认删除此会员分组吗？');return false;"><i class='fa fa-remove'></i></a></td>
                         
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
