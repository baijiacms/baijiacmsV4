<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
 
<div class="panel panel-default">

       <h3 class="custom_page_header"> 订单统计 </h3>
    <div class="panel-body">

        <form action="" method="get" class="form-horizontal"  id="form1">
            <input type="hidden" name="mod" value="site" />
            <input type="hidden" name="m" value="eshop" />
            <input type="hidden" name="do" value="statistics" />
            <input type="hidden" name="act"  value="order" />

            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">会员名</label>
                <div class="col-sm-2">
                    <input name="realname" type="text"  class="form-control" value="<?php  echo $_GPC['realname'];?>">
                </div>
                  <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">收货人</label>
                <div class="col-sm-2">
                    <input name="addressname" type="text"  class="form-control" value="<?php  echo $_GPC['addressname'];?>">
                </div>
                
                     <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">订单号</label>
                <div class="col-sm-2">
                    <input name="ordersn" type="text"  class="form-control" value="<?php  echo $_GPC['ordersn'];?>">
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
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <button class="btn btn-default" ><i class="fa fa-search"></i> 搜索</button>
                    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                    <?php  if('statistics.export.order') { ?>
                    <button type="submit" name="export" value="1" class="btn btn-primary">导出 Excel</button>
                    <?php  } ?>
                </div>

            </div>

        </form>
    </div>

    <div class="panel-heading">
       共计 <span style="color:red; "><?php  echo $totalcount;?></span> 个订单 , 金额共计 <span style="color:red; "><?php  echo empty($totalmoney)?0:$totalmoney;?></span> 元
    </div>
    <div >
  <table class="table table-hover">
            <thead class="navbar-inner">
                <tr>
                    <th >订单号</th>
                    <th>金额/运费</th>
							
                    <th>付款方式</th>
                    <th>付款人信息</th>
                    <th>下单时间</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr  style="background: #eee">
                    <td><?php  echo $row['ordersn'];?></td>
                    <td><b><?php  echo $row['price'];?></b><a><i class="fa fa-question-circle" data-toggle="popover" data-placement="bottom" data-html="true" data-trigger="hover" data-content="<table class='table table-hover'>

                        

                        <tr><th>总金额</th><td><?php  echo $row['price'];?></td></tr>

                        <tr><th>商品小计</th><td><?php  echo $row['goodsprice'];?></td></tr>

                        <tr><th>运费</th><td><?php  echo $row['dispatchprice'];?></td></tr>

                        <tr><th>会员折扣</th><td><?php  if($row['discountprice']>0) { ?>-<?php  echo $row['discountprice'];?><?php  } ?></td></tr>

                        <tr><th>积分抵扣</th><td><?php  if($row['deductprice']>0) { ?>-<?php  echo $row['deductprice'];?><?php  } ?></td></tr>


                        <tr><th>满额立减</th><td><?php  if($row['deductenough']>0) { ?>-<?php  echo $row['deductenough'];?><?php  } ?></td></tr>

                        <tr><th>优惠券优惠</th><td><?php  if($row['couponprice']>0) { ?>-<?php  echo $row['couponprice'];?><?php  } ?></td></tr>

                        <tr><th>卖家改价</th><td><?php  if(0<$item['changeprice']) { ?>+<?php  } else { ?>-<?php  } ?><?php  echo number_format(abs($item['changeprice']),2)?></td></tr>

                        <tr><th>卖家改运费</th><td><?php  if(0<$item['changedipatchpriceprice']) { ?>+<?php  } else { ?>-<?php  } ?><?php  echo number_format(abs($item['changedipatchpriceprice']),2)?></td></tr>

                        </table>" data-original-title="" title=""></i></a>
                    	</td>
	
	
					
                    <td><?php  if($row['paytype'] == 1) { ?>
                               <span class="label label-primary">余额支付</span>
                                 <?php  } else if($row['paytype'] == 11) { ?>
                               <span class="label label-default">后台付款</span>
                           <?php  } else if($row['paytype'] == 2) { ?>
                               <span class="label label-danger">在线支付</span>
                                 <?php  } else if($row['paytype'] == 21) { ?>
                               <span class="label label-success">微信支付</span>
                                 <?php  } else if($row['paytype'] == 22) { ?>
                               <span class="label label-warning">支付宝支付</span>
                                 <?php  } else if($row['paytype'] == 23) { ?>
                               <span class="label label-primary">银联支付</span>
                           <?php  } else if($row['paytype'] == 3) { ?>
                           <span class="label label-success">货到付款</span>
                         <?php  } ?>
                    </td>
                    <td>会员姓名:<?php  echo $row['realname'];?><br/>
                    	收货人:<?php  echo $row['addressname'];?></td>
                 
                    <td><?php  echo date('Y-m-d',$row['createtime'])?><br/><?php  echo date('H:i:s',$row['createtime'])?></td>   
                </tr>	
                <tr >

                    <td colspan="5">
		   <?php  if(is_array($row['goods'])) { foreach($row['goods'] as $g) { ?>
		    <table style="width:200px;float:left;margin:10px 10px 0 10px;" title="<?php  echo $g['title'];?>">
				<tr>
					<td style="width:60px;"><img src="<?php  echo tomedia($g['thumb'])?>" style="width: 50px; height: 50px;border:1px solid #ccc;padding:1px;"></td>
					<td>
						单价: <?php  echo $g['realprice']/$g['total']?><br/>
						数量: <?php  echo $g['total'];?><br/>
						总价: <strong><?php  echo $g['realprice'];?></strong>
					</td>
				</tr>
			</table>
		   <?php  } } ?>
		 
                    </td></tr>	
            <?php  } } ?>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
<script language='javascript'>

 
    require(['bootstrap'], function ($) {

        

        $('[data-toggle="popover"]').popover({

            container: $(document.body)

        });

    });




</script>
<?php include page("footer-base");?>