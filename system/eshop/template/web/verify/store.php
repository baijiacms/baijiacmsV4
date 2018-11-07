<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<?php  if($operation == 'post') { ?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
        <div class='panel'>
        	    	<h3 class="custom_page_header">门店设置 </h3>
            <div class='panel-body'>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 门店名称</label>
                    <div class="col-sm-9 col-xs-12">
                   
                        <input type="text" name="storename" class="form-control" value="<?php  echo $item['storename'];?>" />
                      
                    </div>
                </div>
               <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">门店地址</label>
                    <div class="col-sm-9 col-xs-12">
                         
                        <input type="text" name="address" class="form-control" value="<?php  echo $item['address'];?>" />
                             
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">门店电话</label>
                    <div class="col-sm-9 col-xs-12">
                              
                        <input type="text" name="tel" class="form-control" value="<?php  echo $item['tel'];?>" />
                             
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">门店位置</label>
                    <div class="col-sm-9 col-xs-12">
                          
                        <?php  echo tpl_form_field_coordinate('map',array('lng'=>$item['lng'],'lat'=>$item['lat']))?>
                           
                    </div>
                </div>

             

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
                    <div class="col-sm-9 col-xs-12">
                         
                        <label class='radio-inline'>
                            <input type='radio' name='status' value=1' <?php  if($item['status']==1) { ?>checked<?php  } ?> /> 启用
                        </label>
                        <label class='radio-inline'>
                            <input type='radio' name='status' value=0' <?php  if($item['status']==0) { ?>checked<?php  } ?> /> 禁用
                        </label>
                          
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
        if($(':input[name=storename]').isEmpty()){
            Tip.focus($(':input[name=storename]'),'请输入门店名称!');
            return false;
        }
        return true;
    })
    </script>
<?php  } else if($operation == 'display') { ?>
               <form action="" method="get">

                   <input type="hidden" name="mod" value="site" />
                   <input type="hidden" name="m" value="eshop" />
                   <input type="hidden" name="act" value="store" />
                   <input type="hidden" name="do" value="verify" />
                   <input type="hidden" name="page" value="1" />
                	 <input type="hidden" name="beid" value="<?php echo $GLOBALS['_CMS']['beid'];?>" />
                   <div class="panel ">
                   	
        	    	<h3 class="custom_page_header">门店管理           <a class='btn btn-default' href="<?php  echo $this->createWebUrl('verify/store', array('op' => 'post'))?>"><i class="fa fa-plus"></i> 添加新门店</a></h3>
                       <div class="panel-body">
                           <div class="form-group">
                               <div class="col-sm-5">
                                   <div class='input-group' >
                                       <div class='input-group-addon'>关键词</div>
                                       <input class="form-control" name="keyword" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="门店名称/地址/电话">

                                       
                                   </div>
                               </div>
                               
                                 <div class="col-sm-6">
                                   <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                               </div>
                           </div>
                       </div>
                 
        
         <div class='panel-body'>

            <table class="table">
                <thead>
                    <tr>
                        <th>门店名称</th>
                        <th>门店地址</th>
                        <th>门店电话</th>
                        <th>核销员数量</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr>
                        <td><?php  echo $row['storename'];?></td>
                        <td><?php  echo $row['address'];?></td>
                        <td><?php  echo $row['tel'];?></td>
                        <td><?php  echo $row['salercount'];?></td>
                    
                        <td>
                                <?php  if($row['status']==1) { ?>
                                <span class='label label-success'>启用</span>
                                <?php  } else { ?>
                                <span class='label label-danger'>禁用</span>
                                <?php  } ?>
                            </td>
                        <td>
                         <a class='btn btn-default' href="<?php  echo $this->createWebUrl('verify/store', array('op' => 'post', 'id' => $row['id']))?>"><i class='fa fa-edit'></i></a>
                         <a class='btn btn-default'  href="<?php  echo $this->createWebUrl('verify/store', array('op' => 'delete', 'id' => $row['id']))?>" onclick="return confirm('确认删除此门店吗？');return false;"><i class='fa fa-remove'></i></a></td>

                    </tr>
                    <?php  } } ?>
                 
                </tbody>
            </table>
  
         </div>
 
     
     </div>
       </form>

<?php  echo $pager;?>


<?php  } ?>
<?php include page("footer-base");?>