<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<div class="panel panel-default">
	
	  <h3 class="custom_page_header"> 查询商品浏览量及购买转化率，默认排序为转化率从高到低 </h3>
    <div class="panel-body">
        <form action="./index.php" method="get" class="form-horizontal">
            <input type="hidden" name="mod" value="site" />
            <input type="hidden" name="m" value="eshop" />
            <input type="hidden" name="do" value="statistics" />
            <input type="hidden" name="act"  value="goods_trans" />
             <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">商品名称</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                      <input name="title" type="text"  class="form-control" value="<?php  echo $_GPC['title'];?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">排序方式</label>
                <div class="col-sm-2">
                    <label class='radio-inline'>
                        <input type='radio' name='orderby' value='0' <?php  if(empty($_GPC['orderby'])) { ?>checked<?php  } ?>/> 降序
                    </label>
                    
                    <label class='radio-inline'>
                        <input type='radio' name='orderby' value='1'  <?php  if($_GPC['orderby']==1) { ?>checked<?php  } ?>/> 升序
                    </label>
                </div>
                <div class="col-sm-6">
                    <button class="btn btn-default" ><i class="fa fa-search"></i> 搜索</button>
                     <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                   
                    <button type="submit" name="export" value="1" class="btn btn-primary">导出 Excel</button>
              
                </div>
            </div>
            
        </form>
    </div>

    <div class="panel-heading">总数: <span style='color:red'><?php  echo $total;?></span></div>
     <table class="table table-hover">
            <thead>
                <tr>
                
                    <th>商品名称</th>
                    <th style='width:100px;'>访问次数</th>
                    <th style='width:100px;'>购买件数</th>
                    <th>转化率</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td>
                        <img src="<?php  echo tomedia($row['thumb'])?>" style="width: 30px; height: 30px;border:1px solid #ccc;padding:1px;">
                        <?php  echo $row['title'];?></td>
                    <td><?php  echo $row['viewcount'];?></td>
                    <td><?php  echo $row['buycount'];?></td> 
                    <td>   <div class="progress" style='max-width:500px;'>
                            <div style="width: <?php  echo $row['percent'];?>%;" class="progress-bar progress-bar-info"><span style="color:#000"><?php echo empty($row['percent'])?'':$row['percent'].'%'?></span></div>
                       </div></td>
                </tr>
                <?php  } } ?>
        </table>
        <?php  echo $pager;?>
    </div>		
</div>
<?php include page("footer-base");?>