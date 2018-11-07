<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<link href="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/select2/select2.css" rel="stylesheet">
<link href="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/select2/select2-bootstrap.css" rel="stylesheet">
<script language="javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/select2/select2.min.js"></script>
<script language="javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/select2/select2_locale_zh-CN.js"></script>
<style type='text/css'>
.trhead td {  background:#efefef;text-align: center}
.trbody td {  text-align: center; vertical-align:top;border-left:1px solid #ccc;overflow: hidden;}
.goods_info{position:relative;width:60px;}
.goods_info img {width:50px;background:#fff;border:1px solid #CCC;padding:1px;}
.goods_info:hover {z-index:1;position:absolute;width:auto;}
.goods_info:hover img{width:320px; height:320px; }
 
.form-control .select2-choice {
    border: 0 none;
    border-radius: 2px;
    height: 32px;    line-height: 32px;
}
</style>

<div class="panel panel-default">
    <div class="panel-body">
        <form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
            <input type="hidden" name="mod" value="site" />
            <input type="hidden" name="m" value="eshop" />
            <input type="hidden" name="do" value="order" />
             <input type="hidden" name="act" value="list" />
            <input type="hidden" name="status" value="<?php  echo $status;?>" />
            <input type="hidden" name="agentid" value="<?php  echo $_GPC['agentid'];?>" />
            <input type="hidden" name="refund" value="<?php  echo $_GPC['refund'];?>" />  
            <div class="form-group">
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <div class='input-group'>
                        <div class='input-group-addon'>订单号</div>
                        <input class="form-control" name="keyword" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="订单号">
                        <div class='input-group-addon'>快递单号</div>
                        <input class="form-control" name="expresssn" type="text" value="<?php  echo $_GPC['expresssn'];?>" placeholder="快递单号">
                        <div class='input-group-addon'>用户信息</div>
                        <input class="form-control" name="member" type="text" value="<?php  echo $_GPC['member'];?>" placeholder="昵称/姓名/手机号/会员ID">
                  
                    </div>
                </div>
            </div> 
			<div class='form-group'>
				  <div class="col-sm-8 col-lg-9 col-xs-12">
                    <div class='input-group'>
				   <div class='input-group-addon'>核销员</div>
                        <input class="form-control" name="saler" type="text" value="<?php  echo $_GPC['saler'];?>" placeholder="核销员昵称/姓名/手机号/会员ID">
						<div class='input-group-addon'>核销门店</div>
                        <select name="storeid" class="form-control select2" style='height:35px;'>
                            <option value="" ></option>
			 <?php  if(is_array($stores)) { foreach($stores as $store) { ?>
			<option value="<?php  echo $store['id'];?>" <?php  if($_GPC['storeid'] ==$store['id']) { ?> selected="selected" <?php  } ?>><?php  echo $store['storename'];?></option>
			<?php  } } ?>
                        </select>
                              <div class='input-group-addon'>支付方式</div>
                        <select name="paytype" class="form-control">
                            <option value="" <?php  if($_GPC['paytype']=='') { ?>selected<?php  } ?>>不限</option>
                            <?php  if(is_array($paytype)) { foreach($paytype as $key => $type) { ?>
                            <option value="<?php  echo $key;?>" <?php  if($_GPC['paytype'] == "$key") { ?> selected="selected" <?php  } ?>><?php  echo $type['name'];?></option>
                            <?php  } } ?>
                        </select>
			</div>
				  </div>
			</div>
            <div class="form-group">

                <div class="col-sm-6">

                    <div class='input-group'>
                        <div class='input-group-addon'>下单时间
                            <label class='radio-inline' style='margin-top:-7px;'>
                                <input type='radio' value='0' name='searchtime' <?php  if($_GPC['searchtime']=='0') { ?>checked<?php  } ?>>不搜索
                            </label>
                            <label class='radio-inline'  style='margin-top:-7px;'>
                                <input type='radio' value='1' name='searchtime' <?php  if($_GPC['searchtime']=='1') { ?>checked<?php  } ?>>搜索
                            </label>
                        </div>
                        <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d H:i', $endtime)),true);?>

                        <div class='input-group-addon'>完成时间
                            <label class='radio-inline' style='margin-top:-7px;'>
                                <input type='radio' value='0' name='fsearchtime' <?php  if($_GPC['fsearchtime']=='0') { ?>checked<?php  } ?>>不搜索
                            </label>
                            <label class='radio-inline'  style='margin-top:-7px;'>
                                <input type='radio' value='1' name='fsearchtime' <?php  if($_GPC['fsearchtime']=='1') { ?>checked<?php  } ?>>搜索
                            </label>
                        </div>
                        <?php  echo tpl_form_field_daterange('ftime', array('starttime'=>date('Y-m-d H:i', $fstarttime),'endtime'=>date('Y-m-d H:i', $fendtime)),true);?>
                    </div>

                </div>

            </div>

            <div class="form-group">

                <div class="col-sm-6">

                    <div class='input-group'>
                        <div class='input-group-addon'>付款时间
                            <label class='radio-inline' style='margin-top:-7px;'>
                                <input type='radio' value='0' name='psearchtime' <?php  if($_GPC['psearchtime']=='0') { ?>checked<?php  } ?>>不搜索
                            </label>
                            <label class='radio-inline'  style='margin-top:-7px;'>
                                <input type='radio' value='1' name='psearchtime' <?php  if($_GPC['psearchtime']=='1') { ?>checked<?php  } ?>>搜索
                            </label>
                        </div>
                        <?php  echo tpl_form_field_daterange('ptime', array('starttime'=>date('Y-m-d H:i', $pstarttime),'endtime'=>date('Y-m-d H:i', $pendtime)),true);?>

                        <div class='input-group-addon'>发货时间
                            <label class='radio-inline' style='margin-top:-7px;'>
                                <input type='radio' value='0' name='ssearchtime' <?php  if($_GPC['ssearchtime']=='0') { ?>checked<?php  } ?>>不搜索
                            </label>
                            <label class='radio-inline'  style='margin-top:-7px;'>
                                <input type='radio' value='1' name='ssearchtime' <?php  if($_GPC['ssearchtime']=='1') { ?>checked<?php  } ?>>搜索
                            </label>
                        </div>
                        <?php  echo tpl_form_field_daterange('stime', array('starttime'=>date('Y-m-d H:i', $sstarttime),'endtime'=>date('Y-m-d H:i', $sendtime)),true);?>
                    </div>

                </div>

                <?php  if(!empty($agentid) && $level>0) { ?>
                <div class="col-sm-3">
                    <div class='input-group'>
                        <div class='input-group-addon'>分销订单级数</div>
                        <select name="olevel" class="form-control">
                            <option value="" >不限</option>
                            <option value="1" <?php  if($_GPC['olevel'] ==1) { ?> selected="selected" <?php  } ?>>一级订单</option>
                            <option value="2" <?php  if($_GPC['olevel'] ==2) { ?> selected="selected" <?php  } ?>>二级订单</option>
                            <option value="3" <?php  if($_GPC['olevel'] ==3) { ?> selected="selected" <?php  } ?>>三级订单</option>
                        </select>
                    </div>    </div>
                <?php  } ?>

            </div>

            <div class="form-group">

                <div class="col-sm-7 col-lg-9 col-xs-12">
                    <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                    <button type="submit" name="export" value="1" class="btn btn-primary">导出 Excel</button>
                </div>
            </div>
     
        </form>
    </div>
</div>

 
        <table class='table' style='float:left;border:1px solid #ccc;margin-bottom:5px;table-layout: fixed'>
                <tr class='trhead'>
                    <td colspan='2' style='width:300px;text-align: left'>订单数: <?php  echo $total;?> 订单金额: <?php  echo $totalmoney;?></td>
                    <td  style='width:150px;text-align:left;'>单价/数量</td>
                    <td  >买家</td>
                    <td >支付方式/配送方式</td>
                    <td  style='width:200px;'>价格</td>           
                    <td>操作</td>
                </tr>
            </table>
          
                <?php  if(is_array($list)) { foreach($list as $item) { ?>
  <table class='table' style='float:left;border:1px solid #ccc;margin-top:5px;margin-bottom:0px;table-layout: fixed;'>
                <tr >
                    <td colspan='6'  style='border-bottom:1px solid #ccc;background:#efefef;' > 
                        <b>订单编号:</b>  <?php  echo $item['ordersn'];?>     
                        <b>下单时间:  </b><?php  echo date('Y-m-d H:i:s', $item['createtime'])?>
                         <?php  if(!empty($item['refundid'])) { ?><label class='label label-danger'>退款申请</label><?php  } ?> 
						 <?php  if(!empty($agentid)) { ?>
						 <b>分销订单级别:</b> <?php  echo $item['level'];?>级 <b>分销佣金:</b> <?php  echo $item['commission'];?> 元
						
						 <?php  } ?>
						 <?php  if(!empty($level)) { ?>
						    
						      <?php  if(empty($agentid)) { ?>
							  <?php  if($item['commission1']!=-1) { ?><b>1级佣金:</b> <?php  echo $item['commission1'];?> 元 <?php  } ?>
							  <?php  if($item['commission2']!=-1) { ?><b>2级佣金:</b> <?php  echo $item['commission2'];?> 元 <?php  } ?>
							  <?php  if($item['commission3']!=-1) { ?><b>3级佣金:</b> <?php  echo $item['commission3'];?> 元 <?php  } ?>
						      <?php  } ?>
						      <?php  if(!empty($item['agentid'])) { ?>
				
							<a href='javascript:;' class='btn btn-default' onclick="commission_change('<?php  echo $item['id'];?>')">修改佣金</a>
					
						      <?php  } ?>
						 
						 <?php  } ?>
						 
                    <td style='border-bottom:1px solid #ccc;background:#efefef;text-align: center' colspan='2'  >
                          <?php  if(empty($item['statusvalue'])) { ?>
                        
                                  <a class="btn btn-default btn-sm" href="javascript:;" onclick="$('#modal-close').find(':input[name=id]').val('<?php  echo $item['id'];?>')" data-toggle="modal" data-target="#modal-close">关闭订单</a>
                     
                            <?php  } ?>
                            
                            
                    <a class="btn btn-default btn-sm" style="float:right"  href="<?php  echo $this->createWebUrl('order', array('op' => 'detail','act'=>'list', 'id' => $item['id']))?>"   >查看详情</a>
                    </td>
                         
                </tr>
  </table>
	  <table class='table' style='float:left;border:1px solid #ccc;border-top:none;table-layout: fixed;'>


                <?php  if(is_array($item['goods'])) { foreach($item['goods'] as $k => $g) { ?>
                <tr class='trbody'>
                    <td class="goods_info">
						 <img src="<?php  echo tomedia($g['thumb'])?>">
					</td>
                    <td valign='top'  style='border-left:none;text-align: left;width:240px;'  >
						<?php  echo $g['title'];?><?php  if(!empty($g['optiontitle'])) { ?><br/><span class="label label-primary"><?php  echo $g['optiontitle'];?></span><?php  } ?>
						<br/><?php  echo $g['goodssn'];?>
					</td>
                    <td style='border-left:none;text-align:left;width:150px'>原价: <?php  echo number_format( $g['price']/$g['total'],2)?> <br />应付: <?php  echo number_format($g['realprice']/$g['total'],2)?>
		<br/>数量: <?php  echo $g['total'];?>			 
					</td>
                    
                    <?php  if($k==0) { ?>
                    <td rowspan="<?php  echo count($item['goods'])?>" >
						
						 <a href="<?php  echo $this->createWebUrl('member/list',array('op'=>'detail', 'id'=>$item['mid']))?>"> <?php  echo $item['nickname'];?></a>
					
							 
							 <br/>
						<?php  echo $item['addressdata']['realname'];?><br/><?php  echo $item['addressdata']['mobile'];?></td>
                    <td rowspan="<?php  echo count($item['goods'])?>"    >

                        <?php  if($item['statusvalue'] > 0) { ?>
                        <label class='label label-<?php  echo $item['css'];?>'><?php  echo $item['paytype'];?></label><br/>
                        <?php  } else if($item['statusvalue'] == 0) { ?>
                        <label class='label label-default'>未支付</label><br/>
                        <?php  } else if($item['statusvalue'] == -1) { ?>
                        <label class='label label-default'><?php  echo $item['paytype'];?></label><br/>
                        <?php  } ?>



									   <?php  echo $item['dispatchname'];?>
									   <?php  if($item['addressid']!=0 && $item['statusvalue']>=2) { ?><br/>
									   <a class='btn btn-default btn-sm' href="http://m.kuaidi100.com/index_all.html?type=<?php  echo $item['express']?>&postid=<?php  echo $item['expresssn']?>#input" target="_blank">查看物流</a>
									   <?php  } ?>
					</td>
                    <td  rowspan="<?php  echo count($item['goods'])?>" style='width:200px;'>
						<table style='width:100%;'>
							<tr>
								<td  style='border:none;text-align:right;'>商品小计：</td>
								<td  style='border:none;text-align:right;;'>￥<?php  echo number_format( $item['goodsprice'] ,2)?></td>
							</tr>
							<tr>
								<td  style='border:none;text-align:right;'>运费：</td>
								<td  style='border:none;text-align:right;;'>￥<?php  echo number_format( $item['olddispatchprice'],2)?></td>
							</tr>
							<?php  if($item['discountprice']>0) { ?>
							<tr>
								<td  style='border:none;text-align:right;'>会员折扣：</td>
								<td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['discountprice'],2)?></td>
							</tr>
							<?php  } ?>
							<?php  if($item['deductprice']>0) { ?>
							<tr>
								<td  style='border:none;text-align:right;'>积分抵扣：</td>
								<td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['deductprice'],2)?></td>
							</tr>
							<?php  } ?>
							<?php  if($item['deductenough']>0) { ?>
							<tr>
								<td  style='border:none;text-align:right;'>满额立减：</td>
								<td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['deductenough'],2)?></td>
							</tr>
							<?php  } ?>
							<?php  if($item['couponprice']>0) { ?>
							<tr>
								<td  style='border:none;text-align:right;'>优惠券优惠：</td>
								<td  style='border:none;text-align:right;;'>-￥<?php  echo number_format( $item['couponprice'],2)?></td>
							</tr>
							<?php  } ?>
							<?php  if(intval($item['changeprice'])!=0) { ?>
							<tr>
								<td  style='border:none;text-align:right;'>卖家改价：</td>
								<td  style='border:none;text-align:right;;'><span style="<?php  if(0<$item['changeprice']) { ?>color:green<?php  } else { ?>color:red<?php  } ?>"><?php  if(0<$item['changeprice']) { ?>+<?php  } else { ?>-<?php  } ?>￥<?php  echo number_format(abs($item['changeprice']),2)?></span></td>
							</tr>
						         <?php  } ?>
							<?php  if(intval($item['changedispatchprice'])!=0) { ?>
							<tr>
								<td  style='border:none;text-align:right;'>卖家改运费：</td>
								<td  style='border:none;text-align:right;;'><span style="<?php  if(0<$item['changedispatchprice']) { ?>color:green<?php  } else { ?>color:red<?php  } ?>"><?php  if(0<$item['changedispatchprice']) { ?>+<?php  } else { ?>-<?php  } ?>￥<?php  echo abs($item['changedispatchprice'])?></span></td>
							</tr>
						         <?php  } ?> 
						<tr>
								<td style='border:none;text-align:right;'>应收款：</td>
								<td  style='border:none;text-align:right;color:green;'>￥<?php  echo number_format($item['price'],2)?></td>
							</tr>
					
			<?php  if(empty($item['statusvalue'])) { ?>
							<tr>
								<td style='border:none;text-align:right;'></td>
								<td  style='border:none;text-align:right;color:green;'><a href="javascript:;" class="btn btn-link " onclick="changePrice('<?php  echo $item['id'];?>')">修改价格</a></td>
							</tr>
							<?php  } ?> 
						</table>
 				 
				 
	 
                    </td>
 <td   rowspan="<?php  echo count($item['goods'])?>" >
 	
 	<?php  if(!empty($item['refundid'])) { ?><label class='label label-danger'>退款申请</label><br/>
  <a class="btn btn-default btn-sm" href="<?php  echo $this->createWebUrl('order', array('op' => 'detail','act'=>'list', 'id' => $item['id']))?>"   >退款处理</a>
                  
<?php  }else{ ?>
 	<label class='label label-<?php  echo $item['statuscss'];?>'><?php  echo $item['status'];?></label><br/><br/>
  <?php include $this->template('ops');?>
  <?php  } ?> 
 </td>
            <?php  } ?> 
                                                                                                                  </tr>
                                                                                                                  <?php  } } ?>
   </table>

                                                                                                                  <?php  } } ?>

                    <?php  echo $pager;?>
         <?php include $this->template('modals');?>
		
		  
         <?php include $this->template('commission/changecommission',false);?>
		  
		  <script language='javascript'>
			  $(function () {
				$('.select2').select2({
					search: true,
					placeholder: "请选择门店",
					allowClear: true
				});
			});
			  </script>
<?php include page("footer-base");?>
