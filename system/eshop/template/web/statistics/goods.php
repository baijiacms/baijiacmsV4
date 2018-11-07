<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<div class="panel panel-default">
	       <h3 class="custom_page_header"> 查询商品销售量和销售额明细 </h3>
    <div class="panel-body">

        <form action="" method="get" class="form-horizontal">
            <input type="hidden" name="mod" value="site" />
            <input type="hidden" name="m" value="eshop" />
            <input type="hidden" name="do" value="statistics" />
            <input type="hidden" name="act"  value="goods" />
              <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">商品名称</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                      <input name="title" type="text"  class="form-control" value="<?php  echo $_GPC['title'];?>">
                </div>
            </div>
        
            
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">下单时间</label>
                
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
                 <div class="col-sm-3">
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
            <thead class="navbar-inner">
                <tr>
                    <th>订单号</th>
                    <th>商品名称</th>
                    <th>商品编号</th>
                    <th>数量</th>
                    <th>价格</th>
                    <th>成交时间</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $item) { ?>
                <tr>
                    <td><?php  echo $item['ordersn'];?></td>
                    <td><img src="<?php  echo tomedia($item['thumb'])?>" style="width: 30px; height: 30px;border:1px solid #ccc;padding:1px;">
                        <?php  echo $item['title'];?></td>
					 <td><?php  echo $item['goodssn'];?></td>
                    <td><?php  echo $item['total'];?></td>
                    <td><?php  echo $item['price'];?></td>
                    <td><?php  echo date('Y-m-d  H:i:s',$item['createtime'])?></td>
                </tr>
                <?php  } } ?>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
<?php include page("footer-base");?>