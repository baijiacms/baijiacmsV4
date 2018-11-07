<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<?php  if($operation == 'display') { ?>
     <form action="" method="post">
<div class="panel">
			<h3 class="custom_page_header">公告管理 
                          <a class='btn btn-default' href="<?php  echo $this->createWebUrl('shop/notice',array('op'=>'post'))?>"><i class='fa fa-plus'></i> 添加公告</a>
                    
                          
                        
                          <input name="submit" type="submit" class="btn btn-primary" value="保存排序">
                           <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        </h3>
    <div class="panel-body table-responsive">
        <table class="table table-hover">
            <thead class="navbar-inner">
                <tr>
                    <th style="width:30px;">ID</th>
                    <th style='width:80px'>显示顺序</th>					
                    <th>标题</th>
                    <th>链接</th>
                    <th>状态</th>
                    <th >操作</th>
                </tr>
            </thead>
            <tbody><?php  if(count($list)>0) { ?>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td><?php  echo $row['id'];?></td>
                    <td>
                           <input type="text" class="form-control" name="displayorder[<?php  echo $row['id'];?>]" value="<?php  echo $row['displayorder'];?>">
                      </td>
                    <td><?php  echo $row['title'];?></td>
                    <td><?php  echo $row['link'];?></td>
                       <td>
                                    <?php  if($row['status']==1) { ?>
                                    <span class='label label-success'>显示</span>
                                    <?php  } else { ?>
                                    <span class='label label-danger'>隐藏</span>
                                    <?php  } ?>
                                </td>
                    <td style="text-align:left;">
                      <a href="<?php  echo $this->createWebUrl('shop/notice', array('op' => 'post', 'id' => $row['id']))?>" class="btn btn-default btn-sm"  title="修改"><i class="fa fa-edit"></i></a>
                        <a href="<?php  echo $this->createWebUrl('shop/notice', array('op' => 'delete', 'id' => $row['id']))?>"class="btn btn-default btn-sm" 
                                                     onclick="return confirm('确认删除此公告?')"
                                                     title="删除"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                <?php  } } ?>
              <?php  } else { ?>
								<tr>
							<td colspan='6'>
                              <div  style='text-align: center;padding:30px;'>
                                  暂时没有公告!
                              </div>	</td>
						</tr>
                          <?php  } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
</form>
<script>
    require(['bootstrap'], function ($) {
        $('.btn').hover(function () {
            $(this).tooltip('show');
        }, function () {
            $(this).tooltip('hide');
        });
    });
</script>

<?php  } else if($operation == 'post') { ?>

<div class="main">
    <form     action="" method="post" class="form-horizontal form" enctype="multipart/form-data" onsubmit='return formcheck()'>
        <input type="hidden" name="id" value="<?php  echo $notice['id'];?>" />
        <div class="panel">
         
              <h3 class="custom_page_header">   公告设置</h3>
        
            <div class="panel-body">
            	 <input type="hidden" name="displayorder" value="<?php  echo $notice['displayorder'];?>" />
                       
            	    <?php  if(false) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
                    <div class="col-sm-9 col-xs-12">
                     
                        <input type="text" name="displayorder" class="form-control" value="<?php  echo $notice['displayorder'];?>" />
                        
                  
                    </div>
                </div>
                      <?php  } ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span>公告标题</label>
                    <div class="col-sm-9 col-xs-12">
                       
                        <input type="text" id='title' name="title" class="form-control" value="<?php  echo $notice['title'];?>" />
                       
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">公告图片</label>
                    <div class="col-sm-9 col-xs-12">
                      
                        <?php  echo tpl_form_field_image('thumb', $notice['thumb'])?>
                        <span class="help-block">正方型图片</span>
             
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">公告连接</label>
                    <div class="col-sm-9 col-xs-12">
                    
                        <input type="text" name="link" class="form-control" value="<?php  echo $notice['link'];?>" />
                        <span class="help-block">如果输入链接，则不显示内容，直接跳转</span>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">公告内容</label>
                    <div class="col-sm-9 col-xs-12">    
                     
                            <?php  echo tpl_ueditor('detail',$notice['detail'])?>
                        
                            
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否显示</label>
                    <div class="col-sm-9 col-xs-12">
                       
                        <label class='radio-inline'>
                            <input type='radio' name='status' value=1' <?php  if($notice['status']==1) { ?>checked<?php  } ?> /> 是
                        </label>
                        <label class='radio-inline'>
                            <input type='radio' name='status' value=0' <?php  if($notice['status']==0) { ?>checked<?php  } ?> /> 否
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
    function formcheck() {
        if ($("#title").isEmpty()) {
            Tip.focus("title", "请填写公告标题!");
            return false;
        }
        return true;
    }
</script>
<?php  } ?>
<?php include page("footer-base");?>