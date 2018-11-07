<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<?php  if($operation == 'post') { ?>
<div class="main">
    
    <form  action="" method="post" class="form-horizontal form" enctype="multipart/form-data" >
    
        <div class="panel">
        	    	<h3 class="custom_page_header">商品分类 </h3>
          
            <div class="panel-body">
                
                <?php  if(!empty($item['id'])) { ?>
                 <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分类链接</label>
                <div class="col-sm-9 col-xs-12">
               	
                    	<div class="input-group ">
                           <?php  if(empty($parent)) { ?>
                           
                  
                                  <input   type="text" name="cpurl"  class="form-control" readonly value="<?php  echo $this->createMobileUrl('shop/list',array('pcate'=>$item['id']))?>" />
                           <span class="input-group-btn">
                             <a  class="btn btn-default" href="<?php  echo $this->createMobileUrl('shop/list',array('pcate'=>$item['id']))?>" target="_blank"><i class="fa fa-eye"></i> 点击预览</a>
                            		</span><?php  } else { ?>
                               <?php  if(empty($parent1)) { ?>
                                 <input type="text" name="cpurl"  class="form-control" readonly value="<?php  echo $this->createMobileUrl('shop/list',array('ccate'=>$item['id']))?>" />
                            <span class="input-group-btn"> <a class="btn btn-default" href="<?php  echo $this->createMobileUrl('shop/list',array('ccate'=>$item['id']))?>" target="_blank"><i class="fa fa-eye"></i> 点击预览</a>
                              	</span> <?php  } else { ?>
                                 <input type="text" name="cpurl" class="form-control" readonly value="<?php  echo $this->createMobileUrl('shop/list',array('tcate'=>$item['id']))?>" />
                            <span class="input-group-btn"> <a  class="btn btn-default" href="<?php  echo $this->createMobileUrl('shop/list',array('tcate'=>$item['id']))?>" target="_blank"><i class="fa fa-eye"></i> 点击预览</a>
                                	</span> 
                               <?php  } ?>
                           <?php  } ?>
                        
                  		</div>
                </div>
            </div>
                <?php  } ?>
                
                <?php  if(!empty($parentid)) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">上级分类</label>
                    <div class="col-sm-9 col-xs-12 control-label" style="text-align:left;">
                        <?php  if(!empty($parent1)) { ?><?php  echo $parent1['name'];?> >> <?php  } ?>
                        <?php  echo $parent['name'];?></div>
                </div>
                <?php  } ?>
                
                  <input type="hidden" name="displayorder" class="form-control" value="<?php  echo $item['displayorder'];?>" />
                  <?php  if(false) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="displayorder" class="form-control" value="<?php  echo $item['displayorder'];?>" />
                    </div>
                </div>    <?php  } ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span>分类名称</label>
                    <div class="col-sm-9 col-xs-12">
                     
                        <input type="text" name="catename" class="form-control" value="<?php  echo $item['name'];?>" />
                        
                    </div>
                </div>
               <?php  if(!empty($parentid)) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分类图片</label>
                    <div class="col-sm-9 col-xs-12">
                    
                             <?php  echo tpl_form_field_image('thumb', $item['thumb'])?>
                            <span class="help-block">建议尺寸: 100*100，或正方型图片 </span>
                    
                    </div>
                </div>
               <?php  } ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分类描述</label>
                    <div class="col-sm-9 col-xs-12">
                   
                        <textarea name="description" class="form-control" cols="70"><?php  echo $item['description'];?></textarea>
                      
                        
                    </div>
                </div> 
      <?php  if(empty($parent)) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分类广告</label>
                    <div class="col-sm-9 col-xs-12">
                  
                        <?php  echo tpl_form_field_image('advimg', $item['advimg'])?>
                        <span class="help-block">建议尺寸: 640*320</span>
                        
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分类广告链接</label>
                    <div class="col-sm-9 col-xs-12">
                       
                        <input type="text" name="advurl" class="form-control" value="<?php  echo $item['advurl'];?>" />
                       
                    </div>
                </div>
               <?php  } ?>
               <?php  if(!empty($parentid)) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否推荐</label>
                    <div class="col-sm-9 col-xs-12">
                          
                        <label class='radio-inline'>
                            <input type='radio' name='isrecommand' value=1' <?php  if($item['isrecommand']==1) { ?>checked<?php  } ?> /> 是
                        </label>
                        <label class='radio-inline'>
                            <input type='radio' name='isrecommand' value=0' <?php  if($item['isrecommand']==0) { ?>checked<?php  } ?> /> 否
                        </label>
                           
                    </div> 
                </div>
               <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">首页推荐</label>
                    <div class="col-sm-9 col-xs-12">
                         
                        <label class='radio-inline'>
                            <input type='radio' name='ishome' value=1' <?php  if($item['ishome']==1) { ?>checked<?php  } ?> /> 是
                        </label>
                        <label class='radio-inline'>
                            <input type='radio' name='ishome' value=0' <?php  if($item['ishome']==0) { ?>checked<?php  } ?> /> 否
                        </label>
                        
                    </div> 
                </div>
                <?php  } ?>  
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否显示</label>
                    <div class="col-sm-9 col-xs-12">
                 
                        <label class='radio-inline'>
                            <input type='radio' name='enabled' value=1' <?php  if($item['enabled']==1) { ?>checked<?php  } ?> /> 是
                        </label>
                        <label class='radio-inline'>
                            <input type='radio' name='enabled' value=0' <?php  if($item['enabled']==0) { ?>checked<?php  } ?> /> 否
                        </label>
                        
                    </div>
                </div>
                
                 <div class="form-group">   </div>
            <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                      
                            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" onclick="return formcheck()" />
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                      
                       <input type="button" name="back" onclick='history.back()' style='margin-left:10px;' value="返回列表" class="btn btn-default " />
                    </div>
            </div>
                
            </div>
        </div>
      
    </form>
</div>
<script language='javascript'>
        
    $('form').submit(function(){
        if($(':input[name=catename]').isEmpty()){
            Tip.focus(':input[name=catename]','请输入分类名称!');
            return false;
        }
        return true;
    });
</script>
<?php  } else if($operation == 'display') { ?>
<script language="javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/nestable/jquery.nestable.js"></script>
<link rel="stylesheet" type="text/css" href="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/nestable/nestable.css" />
<style type='text/css'>
    .dd-handle { height: 40px; line-height: 30px}
</style>
<div class="main">
    <div class="category">
        <form action="" method="post">
            <div class="panel ">
            	
            	<h3 class="custom_page_header">分类管理  
                                    <a href="<?php  echo $this->createWebUrl('shop/category',array('op' => 'post'))?>" class="btn btn-default"><i class="fa fa-plus"></i> 添加新分类</a>
                               
                                    <input id="save_category" type="button" class="btn btn-primary" value="保存分类排序">
                                
                                    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                                    <input type="hidden" name="datas" value="" /></h3>
            	
                <div class="panel-body table-responsive">
   <?php  if(count($category)>0) { ?>
                        <div class="dd" id="div_nestable">
                            <ol class="dd-list">

                               <?php  if(is_array($category)) { foreach($category as $row) { ?>
                                 <?php  if(empty($row['parentid'])) { ?>
                                <li class="dd-item" data-id="<?php  echo $row['id'];?>">

                                    <div class="dd-handle"  style='width:100%;'>
                                        [ID: <?php  echo $row['id'];?>] <?php  echo $row['name'];?>  <?php  if(empty($row['enabled'])) { ?> <span class="label label-danger">隐藏</span>   <?php  } ?>
                                        <span class="pull-right">
                                       <a class='btn btn-default btn-sm' href="<?php  echo $this->createWebUrl('shop/category', array('parentid' => $row['id'], 'op' => 'post'))?>" title='添加子分类' ><i class="fa fa-plus"></i>添加子分类</a>
                                         
                                             <a class='btn btn-default btn-sm' href="<?php  echo $this->createWebUrl('shop/category', array('id' => $row['id'], 'op' => 'post'))?>" title="修改" ><i class="fa fa-edit"></i>修改</a>
                                     
                                         <a class='btn btn-default btn-sm' href="<?php  echo $this->createWebUrl('shop/category', array('id' => $row['id'], 'op' => 'delete'))?>" title='删除' onclick="return confirm('确认删除此分类吗？');return false;"><i class="fa fa-remove"></i>删除</a>
                                        </span>
                                    </div>
                                    <?php  if(count($children[$row['id']])>0) { ?>
                                    
                                    <ol class="dd-list"  style='width:100%;'>
                                        <?php  if(is_array($children[$row['id']])) { foreach($children[$row['id']] as $child) { ?>
                                        <li class="dd-item" data-id="<?php  echo $child['id'];?>">
                                            <div class="dd-handle">
                                                <img src="<?php  echo tomedia($child['thumb']);?>" width='30' height="30" onerror="$(this).remove()" style='padding:1px;border: 1px solid #ccc;float:left;' /> &nbsp;
                                                [ID: <?php  echo $child['id'];?>] <?php  echo $child['name'];?><?php  if(empty($row['enabled'])) { ?> <span class="label label-danger">隐藏</span>   <?php  } ?>
                                                <span class="pull-right">
                                                      <a class='btn btn-default btn-sm' href="<?php  echo $this->createWebUrl('shop/category', array('id' => $child['id'], 'op' => 'post'))?>" title="修改" ><i class="fa fa-edit"></i>修改</a>
                                                   <a class='btn btn-default btn-sm' href="<?php  echo $this->createWebUrl('shop/category', array('id' => $child['id'], 'op' => 'delete'))?>" title='删除' onclick="return confirm('确认删除此分类吗？');return false;"><i class="fa fa-remove"></i>删除</a>
                                                </span>
                                            </div>
                                                  
                                        </li>
                                        <?php  } } ?>
                                    </ol>
                                    <?php  } ?>
                                    
                                </li>
                                <?php  } ?>
                              <?php  } } ?>
                              
                           
                                
                            </ol>
                         
                </div>
                		<?php  } else { ?>
                    <div  style='text-align: center;padding:30px;'>
                                  暂时没有任何分类！
                              </div>    <?php  } ?>
            </div>
        </form>
    </div>
</div>
    <script language='javascript'>
     
      
      
    $(function(){
      var depth = <?php  echo intval($shopset['catlevel'])?>;
      if(depth<=0) {
          depth =2;
      }
      $('#div_nestable').nestable({maxDepth: depth });
         
        $(".dd-handle a,dd-handle embed,dd-handle div").mousedown(function (e) {
            e.stopPropagation();
        }); 
        var $expand = false;
        $('#nestableMenu').on('click', function(e)
        {
            if ($expand) {
                $expand = false;
                $('.dd').nestable('expandAll');
            }else {
                $expand = true;
                $('.dd').nestable('collapseAll');
            }
        });
        
        $("#save_category").click(function(){
             var json = window.JSON.stringify($('#div_nestable').nestable("serialize"));
             $(':input[name=datas]').val(json);
             $('form').submit();
        })
        
    })
    </script>
 
<?php  } ?>
<?php include page("footer-base");?>