<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<style>

.i_qq{
  width: 100%;
  height: auto;
  border: #eee solid 1px;
  margin: 10px 0;
  box-shadow: 0 1px 3px #eee;padding:0 0 20px 0;
}
.i_qq h3{    line-height: 1.5;font-size: 16px;border-bottom:1px solid #eee;
  font-weight: 600;padding:12px;color:#456;padding: 12px;
      margin-top: 0px;
    margin-bottom: 0px;
}

.i_qq_bg {
	width: 100%;
	height: auto;
	background-color: #D2EBFF;
	border: #36A3FC solid 1px;
	margin: 10px 0;
	padding: 30px 0;
	box-shadow: 0 1px 3px #eee;
}

.i_qq_bg table {
	width: 100%;
	height: auto;
	text-align: center;
	line-height: 50px;
}

.i_qq_bgt {
	color: #757584;
	font-size: 16px;
	font-weight: bold;
	width: 20%;
}

.i_qq_bgl {
	color: #31313F;
	font-size: 34px;
	font-weight: bold;
	font-family: 'Arial';
}

.i_qq_bgk {
	color: #757584;
	font-size: 12px;
	line-height: 18px;
}

.i_qq_bgk span {
	color: #757584;
	font-size: 12px;
}

.i_qq_bg2 {
	width: 100%;
	float: left;
	height: auto;
	margin-top: 10px;
	border: #DBDBEA solid 1px;
	border-top: 0;
	text-align: left;
	font-size: 12px;
	color: #727284;
}

.i_qq_bg2 td {
	border-top: #DBDBEA solid 1px;
	line-height: 36px;
}

.i_qq_bgt2 {
	background: #fff url("de.png") repeat-x left top;
	text-align: center;
}

.i_qq_bgl2 {
	text-align: center;
}

.i_qq_bgc {
	text-align: center;
	width: 100px;
}
#graph,.graph {
		height: 250px;
	position: relative;
	border: 1px #DBDBEA solid;
	margin-top: 10px;
	border-radius: 5px;
	box-shadow: 0 1px 3px #eee;
}
</style>
<div id="i_qq" class="graph" style="height: 420px;-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
	
	  <div id="container" style="min-width: 300px; height: 400px; margin: 0 auto"></div>  
	</div>

<div class="i_qq_bg i_qq" style="padding:0 0 20px 0;border-color: rgb(219, 219, 234); background: rgb(255, 255, 255);">
<h3 >订单统计</h3>
	<table>
			<tbody><tr>
			<td class="i_qq_bgt">待发货</td>
				<td class="i_qq_bgt">待收货</td>
				<td class="i_qq_bgt">退款申请</td>
				<td class="i_qq_bgt">待付款</td>
			</tr>
			<tr>
			<td class="i_qq_bgl" ><a href="<?php echo create_url('site',array('do'=>'order','act'=>'list','m'=>'eshop','op'=>'display','status'=>1));?>"><?php echo $order_status1;?></a></td>
				<td class="i_qq_bgl" ><a href="<?php echo create_url('site',array('do'=>'order','act'=>'list','m'=>'eshop','op'=>'display','status'=>2));?>"><?php echo $order_status2;?></a></td>
				<td class="i_qq_bgl"><a href="<?php echo create_url('site',array('do'=>'order','act'=>'list','m'=>'eshop','op'=>'display','status'=>4));?>"><?php echo $order_status4;?></a></td>
				<td class="i_qq_bgl"><a href="<?php echo create_url('site',array('do'=>'order','act'=>'list','m'=>'eshop','op'=>'display','status'=>0));?>"><?php echo $order_status0;?></a></td>
			</tr>
			
		</tbody></table>
</div>
<div class="i_qq_bg i_qq " style="padding:0 0 20px 0;border-color: rgb(219, 219, 234); background: rgb(255, 255, 255);">
<h3>综合统计</h3>
	<table>
			<tbody><tr>
			<td class="i_qq_bgt">提现申请</td>
				<td class="i_qq_bgt">售完商品</td>
				<td class="i_qq_bgt">最近7天商品评论</td>
				<td class="i_qq_bgt">未上架商品</td>
			</tr>
			<tr>
			<td class="i_qq_bgl" ><a href="<?php  echo create_url('site',array('act' => 'log','do' => 'finance','m' => 'eshop','type'=>1))?>" ><?php echo $withdraw;?></a></td>
				<td class="i_qq_bgl" > <a href="<?php  echo create_url('site',array('act' => 'goods','do' => 'shop','m' => 'eshop','goodsfrom'=>'out'))?>"><?php echo  $out_goods;?></a></td>
				<td class="i_qq_bgl"><a href="<?php  echo create_url('site',array('act' => 'comment','do' => 'shop','m' => 'eshop'))?>" ><?php echo $comment;?></a></td>
				<td class="i_qq_bgl"><a href="<?php  echo create_url('site',array('act' => 'goods','do' => 'shop','m' => 'eshop','goodsfrom'=>'stock'))?>"><?php echo  $stock_goods;?></a></td>
			</tr>
			
		</tbody></table>
</div>
<?php  if(!empty($commission_set['level'])){?>
<div class="i_qq_bg i_qq " style="padding:0 0 20px 0;border-color: rgb(219, 219, 234); background: rgb(255, 255, 255);">
<h3>分销统计</h3>
	<table>
			<tbody><tr>
			<td class="i_qq_bgt">待审核提现申请</td>
				<td class="i_qq_bgt">待打款提现申请</td>
				<td class="i_qq_bgt">待审核分销商</td>
				<td class="i_qq_bgt">最近7天最新分销商</td>
			</tr>
			<tr>
			<td class="i_qq_bgl" ><a href="<?php  echo create_url('site',array('do' => 'commission','m' => 'eshop','act'=>'apply','status'=>1))?>"><?php echo $commission_apply_status1;?></a></td>
				<td class="i_qq_bgl" ><a href="<?php  echo create_url('site',array('do' => 'commission','m' => 'eshop','act'=>'apply','status'=>2))?>"><?php echo $commission_apply_status2;?></a></td>
				<td class="i_qq_bgl"><a href="<?php  echo create_url('site',array('do' => 'commission','m' => 'eshop','act'=>'agent'))?>"><?php echo $commission_member_apply;?></a></td>
				<td class="i_qq_bgl"><a href="<?php  echo create_url('site',array('do' => 'commission','m' => 'eshop','act'=>'agent'))?>"><?php echo $commission_member_increase;?></a></td>
			</tr>
			
		</tbody></table>
</div>

<?php  } ?>
<script language="javascript" src="<?php echo RESOURCE_ROOT;?>eshop/static/js/dist/highcharts/highcharts.js"></script>
<script type="text/javascript">
   
    $(function () {
        $('#container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
             text: '<?php  echo $charttitle;?>',
        },
        subtitle: {
            text: ''
        },
        colors: [
'#0061a5',
'#ff0000'
],
        xAxis: {
            categories: [    <?php  if(is_array($datas)) { foreach($datas as $key => $row) { ?>
                   <?php  if($key>0) { ?>,<?php  } ?>"<?php  echo $row['date'];?>"
                   <?php  } } ?>]
        },
        yAxis: {
            title: {
                text: '人数'
            },allowDecimals:false
        },
        tooltip: {
            enabled: false,
            formatter: function() {
                return '<b>'+ this.series.name +'</b><br>'+this.x +': '+ this.y +'°C';
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [
            {
               name: '会员',
               data: [
                   <?php  if(is_array($datas)) { foreach($datas as $key => $row) { ?>
                   <?php  if($key>0) { ?>,<?php  } ?><?php  echo $row['mcount'];?>
                   <?php  } } ?>
               ]
            } ]
    });
    
});
</script>
<?php include page("footer-base");?>
 