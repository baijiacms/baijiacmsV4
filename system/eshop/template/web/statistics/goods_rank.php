<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<div class="panel panel-default">
	  <h3 class="custom_page_header"> 查询商品销售量和销售额，默认排序为销售额从高到低 </h3>
    <div class="panel-body">
        <form action="" method="get" class="form-horizontal">
            <input type="hidden" name="mod" value="site" />
            <input type="hidden" name="m" value="eshop" />
            <input type="hidden" name="do" value="statistics" />
            <input type="hidden" name="act"  value="goods_rank" />
             <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">商品名称</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                      <input name="title" type="text"  class="form-control" value="<?php  echo $_GPC['title'];?>">
                </div>
            </div>
            
            
             <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">订单时间</label>
                
                 <div class="col-sm-10">
                    <div class='input-group'>
                        <div class='input-group-addon'>
                            <label class='radio-inline' style='margin-top:-7px;'>
                                <input type='radio' value='0' name='searchtime' <?php  if(empty($_GPC['searchtime'])) { ?>checked<?php  } ?>>不搜索
                            </label>
                            <label class='radio-inline'  style='margin-top:-7px;'>
                                <input type='radio' value='1' name='searchtime' <?php  if($_GPC['searchtime']=='1') { ?>checked<?php  } ?>>搜索
                            </label>
                        </div>
                                     <?php  echo tpl_form_field_daterange('datetime', array('starttime'=>date('Y-m-d H:i',$starttime),'endtime'=>date('Y-m-d H:i',$endtime)), true)?>
                
                     </div>
                       
            			</div>
               
            </div>
            
             
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">排序方式</label>
                <div class="col-sm-3">
                    <label class='radio-inline'>
                        <input type='radio' name='orderby' value='0' <?php  if(empty($_GPC['orderby'])) { ?>checked<?php  } ?>/> 按销售额
                    </label>
                    
                    <label class='radio-inline'>
                        <input type='radio' name='orderby' value='1'  <?php  if($_GPC['orderby']==1) { ?>checked<?php  } ?>/> 按销售量
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
    <div class="panel-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style='width:80px;'>排行</th>
                    <th>商品名称</th>
                    <th>销售量</th>
                    <th>销售额</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $key => $row) { ?>
                <tr>
                    <td><?php  if(($pindex -1)* $psize + $key + 1<=3) { ?>
                             <labe class='label label-danger' style='padding:8px;'>&nbsp;<?php  echo ($pindex -1)* $psize + $key + 1?>&nbsp;</labe>
                            <?php  } else { ?>
                             <labe class='label label-default'  style='padding:8px;'>&nbsp;<?php  echo ($pindex -1)* $psize + $key + 1?>&nbsp;</labe>
                           <?php  } ?>
                        </td>
                    <td>
                        <img src="<?php  echo tomedia($row['thumb'])?>" style="width: 30px; height: 30px;border:1px solid #ccc;padding:1px;">
                        <?php  echo $row['title'];?></td>
                    <td><?php  echo $row['count'];?></td>
                    <td><?php  echo $row['money'];?></td>
                </tr>
                <?php  } } ?>
        </table>
        <?php  echo $pager;?>
    </div>		
</div>
<?php include page("footer-base");?>