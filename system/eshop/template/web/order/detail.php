<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/area/cascade.js"></script>


<style type="text/css">
    .main .form-horizontal .form-group{margin-bottom:0;}
    .main .form-horizontal .modal .form-group{margin-bottom:15px;}
    #modal-confirmsend .control-label{margin-top:0;}
    .ad2 {display: none;}
</style>
<div class="main">
    <form class="form-horizontal form" action="" method="post">
        <?php  if($item['transid']) { ?><div  class="alert alert-error"><i class="fa fa-lightbulb"></i> 此为微信支付订单，必须要提交发货状态！</div><?php  } ?>
        <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
        <input type="hidden" name="dispatchid" value="<?php  echo $dispatch['id'];?>" />
        <div class="panel panel-default">
            <h3 class="custom_page_header"> 订单信息</h3>
            <div class="panel-body">
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">粉丝</label>
                <div class="col-sm-9 col-xs-12">
                    <img src='<?php  echo $member['avatar'];?>'  onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" style='width:100px;height:100px;padding:1px;border:1px solid #ccc' />
                         <?php  echo $member['nickname'];?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员信息</label>
                <div class="col-sm-9 col-xs-12">
                    <div class='form-control-static'>ID: <?php  echo $member['id'];?> 姓名: <?php  echo $member['realname'];?> / 手机号: <?php  echo $member['mobile'];?> /微信号: <?php  echo $member['weixin'];?></div>
                </div>
            </div>
                
                <?php  if($item['transid']) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">微信交易号 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static"><?php  echo $item['transid'];?></p>
                    </div>
                </div>
                <?php  } ?>
                      <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单编号 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static"><?php  echo $item['ordersn'];?> </p>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单金额 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <div class="form-control-static"><table cellspacing="0" cellpadding="0">
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
						</table></div>
                    </div>
                </div>
				<?php  if(!empty($coupon)) { ?>
				  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">使用优惠券 :</label>
                    <div class="col-sm-9 col-xs-12">
						<p class="form-control-static">
							<a href="<?php  echo $this->createWebUrl('coupon/coupon',array('op'=>'post','id'=>$coupon['id']))?>" target='_blank'>
								
							[<?php  echo $coupon['id'];?>]<?php  echo $coupon['couponname'];?></a> - 
						  
						   <?php  if($coupon['backtype']==0) { ?>
						  立减 <?php  echo $coupon['deduct'];?> 元
						  <?php  } else if($coupon['backtype']==1) { ?>
						  打 <?php  echo $coupon['discount'];?> 折
						  <?php  } else if($coupon['backtype']==2) { ?>
						  <?php  if($coupon['backmoney']>0) { ?>返 <?php  echo $coupon['backmoney'];?> 余额;<?php  } ?>
						  <?php  if($coupon['backcredit']>0) { ?>返 <?php  echo $coupon['backcredit'];?> 积分;<?php  } ?>
						  <b>返利方式: </b>
						    <?php  if($item['backwhen']==0) { ?>
						  交易完成后（过退款期限）
						  <?php  } else if($item['backwhen']==1) { ?>
						 订单完成后（收货后）
						  <?php  } else { ?>
						  订单付款后
						  <?php  } ?>
						  <b>返利情况: </b> <?php  if(empty($coupon['back'])) { ?>
						  <span class='label label-default'>未返利</span>
						  <?php  } else { ?>
						  <span class='label label-danger'>已返利 <?php  echo data('Y-m-d H:i',$coupon['backtime'])?></span>
						  <?php  } ?>
						  <?php  } ?> 
					</p>
				  </div>
				  </div>
				<?php  } ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">配送方式 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static">
							<?php  if(empty($item['addressid'])) { ?>
                                <?php  if($item['isverify']==1) { ?>
                                    线下核销
                                <?php  } else if($item['isvirtual']==1) { ?>
                                    虚拟物品
                                <?php  } else if(!empty($item['virtual'])) { ?>
                                    虚拟物品(卡密)自动发货<!--virtual-->
                                <?php  } else if($item['dispatchtype']==1) { ?>
                                    自提
                                <?php  } ?>

                            <?php  } else { ?>
                                <?php  if(empty($dispatchtype)) { ?>
                                快递
                                <?php  } ?>
                            <?php  } ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">付款方式 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static">
                            <?php  if($item['paytype'] == 0) { ?>未支付<?php  } ?>
                            <?php  if($item['paytype'] == 1) { ?>余额支付<?php  } ?>
                            <?php  if($item['paytype'] == 11) { ?>后台付款<?php  } ?>
                            <?php  if($item['paytype'] == 21) { ?>微信支付<?php  } ?>
                            <?php  if($item['paytype'] == 22) { ?>支付宝支付<?php  } ?>
                            <?php  if($item['paytype'] == 23) { ?>银联支付<?php  } ?>
                            <?php  if($item['paytype'] == 3) { ?>货到付款<?php  } ?>

                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单状态 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static">
                            <?php  if($item['status'] == 0) { ?><span class="label label-info">待付款</span><?php  } ?>
                            <?php  if($item['status'] == 1) { ?><span class="label label-info">待发货</span><?php  } ?>
                            <?php  if($item['status'] == 2) { ?><span class="label label-info">待收货</span><?php  } ?>
                            <?php  if($item['status'] == 3) { ?><span class="label label-success">已完成</span><?php  } ?>
                            <?php  if($item['status'] == -1) { ?>
                              <?php  if(!empty($refund) && $refund['status']==1) { ?>
                                <span class="label label-default">已退款</span> <?php  if(!empty($refund['refundtime'])) { ?>退款时间: <?php  echo date('Y-m-d H:i:s',$refund['refundtime'])?><?php  } ?>
                                <?php  } else { ?>
                              <span class="label label-default">已关闭</span>
                              <?php  } ?>
                            <?php  } ?>
                        </p>
                    </div>
                </div>
                 <?php  if(!empty($refund) && $refund['status']==1) { ?>
                  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">退款时间 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <div class="form-control-static"><?php  echo date('Y-m-d H:i:s',$item['refundtime'])?></div>
                    </div>
                </div>
                <?php  } ?>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">下单日期 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static"><?php  echo date('Y-m-d H:i:s', $item['createtime'])?></p>
                    </div>
                </div>
                <?php  if($item['status']>=1) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">付款时间 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static"><?php  echo date('Y-m-d H:i:s', $item['paytime'])?></p>
                    </div>
                </div>
                <?php  } ?>
                
                <?php  if($item['status']>=2 && !empty($item['addressid']) ) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">发货信息 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static">快递公司: <?php  echo $item['expresscom'];?>  <br/>快递单号: <?php  echo $item['expresssn'];?> <br/>发货时间: <?php  echo date('Y-m-d H:i:s', $item['sendtime'])?><br/>
									   <a  class='btn btn-default' href="http://m.kuaidi100.com/index_all.html?type=<?php  echo $item['express']?>&postid=<?php  echo $item['expresssn']?>#input" target="_blank" >查看物流</a>
						</p>
                    </div>
                </div>
                <?php  } ?>
                  
                <?php  if($item['status']>=2 && !empty($item['virtual']) ) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">发货信息 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static"><?php  echo str_replace("\n","<br/>", $item['virtual_str'])?>
						
									   
						</p>
                    </div>
                </div>
                <?php  } ?>
                
                <?php  if($item['status']>=3) { ?>
                <?php  if($item['isverify']==1) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">核销信息 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static">
                            消费码: <?php  echo $item['verifycode'];?><br/> 
                            核销时间: <?php  echo date('Y-m-d H:i:s', $item['finishtime'])?><br/>
			 <?php  if(!empty($saler)) { ?>
                            核销人:  <?php  echo $saler['nickname'];?>( <?php  echo $saler['salername'];?> )<br/>
							<?php  } ?>
                           <?php  if(!empty($store)) { ?>
			    核销门店: <?php  echo $store['storename'];?><br/>
                           <?php  } ?>
                        </p>
                    </div>
                </div>
                <?php  } else { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">完成时间 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static"><?php  echo date('Y-m-d H:i:s', $item['finishtime'])?></p>
                    </div>
                </div>
                <?php  } ?>
                
                <?php  } ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">备注 :</label>
                    <div class="col-sm-9 col-xs-12"><textarea style="height:150px;" class="form-control" name="remark" cols="70"><?php  echo $item['remark'];?></textarea></div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                         <br/>
                        <button type='submit' name='saveremark' class='btn btn-default'>保存备注</button>
                    </div>
                </div>
        </div>
    </form>
        <?php  if(count($agents)>0) { ?>
        <div class="panel panel-default">
            <h3 class="custom_page_header"> 分销商信息</h3>
            <div class="panel-body">
                <?php  if(!empty($agents['0'])) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">一级分销商 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static">
							<a href="<?php  echo $this->createWebUrl('member/list',array('op'=>'detail','id'=>$agents[0]['id']))?>" target='_blank'>
							<img src='<?php  echo $agents[0]['avatar'];?>' onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" style="width:30px;height:30px;padding:1px;border:1px solid #ccc" /> <?php  echo $agents[0]['nickname'];?> 
								  </a>
								 <b>ID:</b> <?php  echo $agents[0]['id'];?> <b>姓名:</b> <?php  echo $agents[0]['realname'];?>  <b>手机号:</b> <?php  echo $agents[0]['mobile'];?> 
								
							<b>佣金:</b> <?php  echo $commission1;?> 元
								 </p>
							
                    </div>
                </div>
                <?php  } ?>
                <?php  if(!empty($agents['1'])) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">二级分销商 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static">
							<a href="<?php  echo $this->createWebUrl('member/list',array('op'=>'detail','id'=>$agents[1]['id']))?>" target='_blank'>
								<img src='<?php  echo $agents[1]['avatar'];?>' onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" style="width:30px;height:30px;padding:1px;border:1px solid #ccc" /> <?php  echo $agents[1]['nickname'];?> 
									 </a>
							<b>ID:</b> <?php  echo $agents[1]['id'];?> <b>姓名:</b> <?php  echo $agents[1]['realname'];?>  <b>手机号:</b> <?php  echo $agents[1]['mobile'];?>
							<b>佣金:</b> <?php  echo $commission2;?> 元
						</p>
                    </div>
                </div>
                <?php  } ?>
                <?php  if(!empty($agents['2'])) { ?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">三级分销商 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static">
														<a href="<?php  echo $this->createWebUrl('member/list',array('op'=>'detail','id'=>$agents[2]['id']))?>" target='_blank'>
							<img src='<?php  echo $agents[2]['avatar'];?>' onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" style="width:30px;height:30px;padding:1px;border:1px solid #ccc" />  <?php  echo $agents[2]['nickname'];?> 
								 </a>
							<b>ID:</b> <?php  echo $agents[2]['id'];?> <b>姓名:</b> <?php  echo $agents[2]['realname'];?> <b>手机号:</b> <?php  echo $agents[2]['mobile'];?>
								<b>佣金:</b> <?php  echo $commission3;?> 元						
								 
								 </p>
                    </div>
                </div>
                <?php  } ?>
				
		
				  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static">
							<a href='javascript:;' class='btn btn-default' onclick="commission_change('<?php  echo $item['id'];?>')">修改佣金</a>
						</p>
                    </div>
                </div>
							
            </div>
        </div>
        <?php  } ?>
        <?php  if(!empty($item['addressid'])) { ?>
          <div class="panel panel-default">
            <h3 class="custom_page_header"> 收件人信息</h3>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">姓名 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static ad1"><?php  echo $user['realname'];?></p>
                        <p class="form-control-static ad2"><input type="text" name="realname" id="realname" value="<?php  echo $user['realname'];?>" class="form-control" style="width:130px;display:inline;"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">手机 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static ad1"><?php  echo $user['mobile'];?></p>
                        <p class="form-control-static ad2"><input type="text" name="mobile" id="mobile" value="<?php  echo $user['mobile'];?>" class="form-control" style="width:130px;display:inline;"></p>
                    </div>
                </div>
                <div class="form-group">

                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">地址 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static ad1" id="d_address"><?php  echo $user['address'];?>
                        </p>

                     
                        <p class="form-control-static ad2" id="e_address">
                            <select id="sel-provance" onChange="selectCity();" class="select form-control" style="width:130px;display:inline;">
                                <option value="" selected="true">省/直辖市</option>
                            </select>
                            <select id="sel-city" onChange="selectcounty(0)" class="select form-control" style="width:135px;display:inline;">
                                <option value="" selected="true">请选择</option>
                            </select>
                            <select id="sel-area" class="select form-control" style="width:130px;display:inline;">
                                <option value="" selected="true">请选择</option>
                            </select>
                            <input type="text" name="address_info" id="address_info" class="form-control changeprice_orderprice" style="width:300px;display:inline;" value="<?php  echo $address_info?>">
                        </p>

                        <button type='button' name='editaddress' id='editaddress' class='btn btn-default ad1'>编辑信息</button>
                        <button type='button' name='saveaddress' id='saveaddress' class='btn btn-default ad2'>保存信息</button>
                        <button type='button' name='backaddress' id='backaddress' class='btn btn-default ad2' style="margin-left:50px;">返回</button>
                     
                    </div>
                </div>
            </div>
        </div>
        <?php  } else if($item['isverify']==1 || !empty($item['virtual']) ||!empty($item['isvirtual'])) { ?>
		<?php  if($show==1) { ?>
        <div class="panel panel-default">
            <h3 class="custom_page_header"> 联系人</h3>
            <div class="panel-body">
                   <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">联系人姓名 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static"><?php  echo $user['carrier_realname'];?> </p>
                    </div>
                </div>
               <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">联系人手机 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static"><?php  echo $user['carrier_mobile'];?>  </p>
                    </div>
                </div>
            </div>
        </div>
		<?php  } ?> 
        <?php  } else { ?>
          <div class="panel panel-default">
            <h3 class="custom_page_header"> 自提信息</h3>
            <div class="panel-body">
                   <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">自提人姓名 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static"><?php  echo $user['carrier_realname'];?> /  <?php  echo $user['carrier_mobile'];?></p>
                    </div>
                </div>
               <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">自提地点 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static"><?php  echo $user['address'];?> (联系人： <?php  echo $user['realname'];?> / <?php  echo $user['mobile'];?> ) </p>
                    </div>
                </div>
            </div>
        </div>
        <?php  } ?>
      

 
        <?php  if(!empty($refund)) { ?>

        <div class="panel panel-default">
            <h3 class="custom_page_header"> 退款申请</h3>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">退款原因 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static"><?php  echo $refund['reason'];?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">退款说明 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <p class="form-control-static"><?php echo empty($refund['content'])?'无':$refund['content']?></p>
                    </div>
                </div>
                  <?php  if($refund['status']==0) { ?>
                  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">退款申请时间 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <div class="form-control-static"><?php  echo date('Y-m-d H:i:s',$refund['createtime'])?></div>
                    </div>
                </div>
                <?php  } ?>
                <?php  if($refund['status']==1) { ?>
                  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">退款时间 :</label>
                    <div class="col-sm-9 col-xs-12">
                        <div class="form-control-static"><?php  echo date('Y-m-d H:i:s',$item['refundtime'])?></div>
                    </div>
                </div>
                <?php  } ?>
                
          
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                        <?php  if($refund['status']==0) { ?>
                        <a class="btn btn-danger btn-sm" href="javascript:;" onclick="$('#modal-refund').find(':input[name=id]').val('<?php  echo $item['id'];?>')" data-toggle="modal" data-target="#modal-refund">处理退款申请</a>
                        <?php  } else if($refund['status']==-1) { ?>
                        <span class='label label-default'>已拒绝</span>
                        <?php  } else if($refund['status']==1) { ?>
                        <span class='label label-danger'>已退款</span>
                        <?php  } ?>
                    </div>
                </div> 
             

            </div>
        </div>
        <?php  } ?>
        <div class="panel panel-default">
            <h3 class="custom_page_header"> 商品信息</h3>
            <div class="panel-body table-responsive">
                <table class="table table-hover">
                    <thead class="navbar-inner">
                        <tr>
                            <th style="width:5%;">商品ID</th>
                            <th >商品标题<br/>商品编号/<br/>商品条码</th>
                            <th >商品规格</th>
                       
                            <th >现价/原价/成本价</th>
                            <th >属性</th>
                            <th style="text-align:center">购买数量</th>
                            <th style="color:red;">折扣前/折扣后</th>
                            
                        </tr>
                    </thead>
                    <?php  if(is_array($item['goods'])) { foreach($item['goods'] as $goods) { ?>
                    <tr>
                        <td><?php  echo $goods['id'];?></td>
                        <td>
                            <?php  if($category[$goods['pcate']]['name']) { ?>
                            <span class="text-error">[<?php  echo $category[$goods['pcate']]['name'];?>] </span><?php  } ?><?php  if($children[$goods['pcate']][$goods['ccate']]['1']) { ?>
                            <span class="text-info">[<?php  echo $children[$goods['pcate']][$goods['ccate']]['1'];?>] </span>
                            <?php  } ?>
                            <?php  echo $goods['title'];?>
                            <?php  if(!empty($goods['goodssn'])) { ?><br/>商品编号:<?php  echo $goods['goodssn'];?><?php  } ?>
                        	<?php  if(!empty($goods['productsn'])) { ?><br/>商品编号:<?php  echo $goods['productsn'];?><?php  } ?>
                        </td>
                        <td><span class="label label-info"><?php  echo $goods['optionname'];?></span></td>
                        <td>现价:<?php  echo $goods['marketprice'];?>元<br/>
                        	原价:<?php  echo $goods['productprice'];?>元<br/>
                        	成本价:<?php  echo $goods['costprice'];?>元</td>
                        <td><?php  if($goods['status']==1) { ?><span class="label label-success">上架</span><?php  } else { ?><span class="label label-error">下架</span><?php  } ?>&nbsp;<span class="label label-info" ><?php  if($goods['type'] == 1) { ?>实体商品<?php  } else { ?>虚拟商品<?php  } ?></span></td>
                        <td style="text-align:center"><?php  echo $goods['total'];?></td>
                        <td style='color:red;font-weight:bold;'><?php  echo $goods['orderprice'];?>/<?php  echo $goods['realprice'];?>
						<?php  if(intval($goods['changeprice'])!=0) { ?>
						<br/>(改价<?php  if($goods['changeprice']>0) { ?>+<?php  } ?><?php  echo number_format(abs($goods['changeprice']),2)?>)
							<?php  } ?>
						</td>
                       
                    </tr>
					     <?php   } ?>
                    <?php   } ?>
                    <tr>
                        <td colspan="7">
                             <?php  if($refund['status']==0||$refund['status']==1) { ?>
                               
                              <?php }else{ ?>
												  <?php include $this->template('ops');?>
                             <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
		<script language="javascript">
			function showDiyInfo(obj){
				var hide = $(obj).attr('hide');
				if(hide=='1'){
					$(obj).next().slideDown();
				}
				else{
					$(obj).next().slideUp();
				}
				$(obj).attr('hide',hide=='1'?'0':'1');
			}

     <?php	if(!empty($user['province']))
     	{?>
            cascdeInit("<?php echo isset($user['province'])?$user['province']:''?>","<?php echo isset($user['city'])?$user['city']:''?>","<?php echo isset($user['area'])?$user['area']:''?>");
			<?php	} ?>
            $('#editaddress').click(function() {
                show_address(1);
            });

            $('#backaddress').click(function() {
                show_address(0);
            });

            $('#saveaddress').click(function() {
                var url = "<?php  echo $this->createWebUrl('order/list',array('op'=>'saveaddress'))?>";
                var id =<?php  echo $id?>;
                var realname = $('#realname').val();
                var mobile = $('#mobile').val();
                var provance = $('#sel-provance').val();
                var city = $('#sel-city').val();
                var area = $('#sel-area').val();
                var address = $('#address_info').val();

                if(realname==''){
                    alert('请填写收件人姓名!');
                    return false;
                }

                if(mobile==''){
                    alert('请填写收件人手机!');
                    return false;
                }

                if(provance=='请选择省份'){
                    alert('请选择省份!');
                    return false;
                }

                if(address==''){
                    alert('请填写详细地址!');
                    return false;
                }

                $.ajax({
                    url: url,
                    dataType: "json",
                    data: {id:id,realname:realname,mobile:mobile,provance:provance,city:city,area:area,address:address},
                    success:function(json){
                        var result = json.result;
                        if(json.status==1){
                            location.reload();
                        } else {
                            alert(result);
                        }
                    }
                });
            });

            function show_address(flag) {
                if (flag == 1) {
                    $('.ad1').hide();
                    $('.ad2').show();
                } else {
                    $('.ad1').show();
                    $('.ad2').hide();
                }
            }
         

			</script>

		  <?php include $this->template('modals');?>
         <?php include $this->template('commission/changecommission',false);?>
		  
<?php include page("footer-base");?>