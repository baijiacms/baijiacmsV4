<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page("header-base");?>

     <form action="" method="post">
<div class="panel">
			<h3 class="custom_page_header"><?php if($_GP['rtype']=='basic'){?>文字回复<?php } ?><?php if($_GP['rtype']=='news'){?>图文回复<?php } ?>
                          <a class='btn btn-default' href="<?php  echo create_url('site',array('act' => 'entry','do' => 'reply','rtype'=>$_GP['rtype'],'op'=>'edit'))?>"><i class='fa fa-plus'></i> 添加<?php if($_GP['rtype']=='basic'){?>文字回复<?php } ?><?php if($_GP['rtype']=='news'){?>图文回复<?php } ?></a>
          </h3>
    <div class="panel-body table-responsive">
        <table class="table table-hover">
            <thead class="navbar-inner">
                <tr>
                    <th style="width:50px;"></th>			
                    <th>规则名称</th>
                         <th>类型</th>
                       <th>关键词</th>
                    <th >操作</th>
                </tr>
            </thead>
            <tbody><?php  if(count($list)>0) { ?>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td></td>
                  
                    <td><?php  echo $row['name'];?></td>
                       <td><?php  echo $row['module']=='news'?'图文回复':'';?><?php  echo $row['module']=='basic'?'文本回复':'';?></td>
                        <td><?php  echo $row['keyword'];?></td>
                    <td style="text-align:left;">
                      <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'reply','rtype'=>$row['module'],'op'=>'edit','id'=>$row['id']))?>" class="btn btn-default btn-sm"  title="修改"><i class="fa fa-edit"></i></a>
                        <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'reply','rtype'=>$row['module'],'op'=>'delete','id'=>$row['id']))?>"class="btn btn-default btn-sm" 
                                                     onclick="return confirm('确认删除此公告?')"
                                                     title="删除"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                <?php  } } ?>
              <?php  } else { ?>
								<tr>
							<td colspan='5'>
                              <div  style='text-align: center;padding:30px;'>
                                  暂时没有数据!
                              </div>	</td>
						</tr>
                          <?php  } ?>
            </tbody>
        </table>
    </div>
</div>
</form>

<?php include page("footer-base");?>