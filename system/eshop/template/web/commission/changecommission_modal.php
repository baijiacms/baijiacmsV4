<?php defined('IN_IA') or exit('Access Denied');?><div id="modal-changecommission" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<form class="form-horizontal form" action="<?php  echo $this->createWebUrl('commission/apply')?>" method="post" enctype="multipart/form-data">
		<input type='hidden' name='id' value="<?php  echo $order['id'];?>" />
		<input type='hidden' name='op' value='confirmchangecommission' />
		<div class="modal-dialog"  style="width:750px;margin:0px auto;">
			<div class="modal-content" >
				<div class="modal-header">
					<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
					<h3>修改佣金 订单号: <?php  echo $order['ordersn'];?></h3>
				</div>
				<div class="modal-body">
				<div class="form-group">
							   <label class="col-xs-12 col-sm-3 col-md-2 control-label">粉丝</label>
							   <div class="col-sm-9 col-xs-12">
								   <img src='<?php  echo $member['avatar'];?>' style='width:30px;height:30px;padding:1px;border:1px solid #ccc' />
										<?php  echo $member['nickname'];?>
							   </div>
						   </div>
						   <div class="form-group">
							   <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员信息</label>
							   <div class="col-sm-9 col-xs-12">
								   <div class='form-control-static'>ID: <?php  echo $member['id'];?> 姓名: <?php  echo $member['realname'];?> / 手机号: <?php  echo $member['mobile'];?> /微信号: <?php  echo $member['weixin'];?></div>
							   </div>
						   </div>
					<?php  $canchangeall = true;?>
					<div class="form-group">

						<div class="col-xs-12 col-sm-9 col-md-8 col-lg-8">
							<table class='table'>
								<tr>
									<th style='width:150px;'>商品名称</th>
									<th style='width:50px;'>数量</th>
									<th style='width:80px;'>小计</th>
									<?php  if($set['level']>=1 && !empty($cm1)) { ?>
									<th style='width:145px;'>
										1级</th>
									<?php  } ?>
									<?php  if($set['level']>=2  && !empty($cm2)) { ?>
									<th style='width:145px;'>
										2级</th>
									<?php  } ?>
									<?php  if($set['level']>=3  && !empty($cm3)) { ?>
									<th style='width:145px;'>
										3级</th>
									<?php  } ?>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<?php  if($set['level']>=1 && !empty($cm1) ) { ?>
									<td>
										<a href="<?php  echo $this->createWebUrl('member/list',array('op'=>'detail','id'=>$cm1['id']))?>" target='_blank'><img src="<?php  echo $cm1['avatar'];?>" style='width:30px;height:30px;padding:1px;border:1px solid #ccc' /> <?php  echo $cm1['nickname'];?></a>
										 </td>
									<?php  } ?>
									<?php  if($set['level']>=2  && !empty($cm2)) { ?>
									<td style='width:100px;'>
										<a href="<?php  echo $this->createWebUrl('member/list',array('op'=>'detail','id'=>$cm2['id']))?>" target='_blank'><img src="<?php  echo $cm2['avatar'];?>" style='width:30px;height:30px;padding:1px;border:1px solid #ccc' /> <?php  echo $cm2['nickname'];?></a>
										 </td>
									<?php  } ?>
									<?php  if($set['level']>=3  && !empty($cm3)) { ?>
									<td style='width:100px;'>
										<a  href="<?php  echo $this->createWebUrl('member/list',array('op'=>'detail','id'=>$cm2['id']))?>" target='_blank'><img src="<?php  echo $cm3['avatar'];?>" style='width:30px;height:30px;padding:1px;border:1px solid #ccc' /> <?php  echo $cm3['nickname'];?></a>
										 </td>
									<?php  } ?>
								</tr>
								<?php  if(is_array($order_goods_change)) { foreach($order_goods_change as $goods) { ?>
								<?php  if(!empty($goods['status1']) ||!empty($goods['status2']) ||!empty($goods['status3'])) { ?> <?php  $canchangeall =false;?> <?php  } ?>
								<tr>
									<td><img src="<?php  echo tomedia($goods['thumb'])?>" style='width:30px;height:30px;padding:1px;border:1px solid #ccc' /> <?php  echo $goods['title'];?></td>
									<td><?php  echo $goods['total'];?></td>
									<td><?php  echo $goods['realprice'];?></td>
									<?php  if($set['level']>=1  && !empty($cm1)) { ?><td><input type='text' class='form-control clevel' data-ogid='<?php  echo $goods['id'];?>'  value="<?php  echo $goods['c1'];?>" <?php  if(empty($goods['status1'])) { ?>data-canchange="1" data-level="1" name="cm1[<?php  echo $goods['id'];?>]"<?php  } else { ?>readonly<?php  } ?>  /></td><?php  } ?>
									<?php  if($set['level']>=2  && !empty($cm2)) { ?><td><input type='text' class='form-control clevel' data-ogid='<?php  echo $goods['id'];?>'  value="<?php  echo $goods['c2'];?>" <?php  if(empty($goods['status2'])) { ?>data-canchange="1" data-level="2" name="cm2[<?php  echo $goods['id'];?>]"<?php  } else { ?>readonly<?php  } ?> /></td><?php  } ?>
									<?php  if($set['level']>=3  && !empty($cm3)) { ?><td><input type='text' class='form-control clevel' data-ogid='<?php  echo $goods['id'];?>'  value="<?php  echo $goods['c3'];?>" <?php  if(empty($goods['status3'])) { ?>data-canchange="1" data-level="3" name="cm3[<?php  echo $goods['id'];?>]"<?php  } else { ?>readonly<?php  } ?> /></td><?php  } ?>

								</tr>
								<tr>
									<td></td>
									<td></td>
									<td>应得</td>
									<?php  if($set['level']>=1  && !empty($cm1)) { ?><td id='clevel1_sys_<?php  echo $goods['id'];?>'><?php  echo $goods['co']['level1'];?></td><?php  } ?>
									<?php  if($set['level']>=2  && !empty($cm2)) { ?><td id='clevel2_sys_<?php  echo $goods['id'];?>'><?php  echo $goods['co']['level2'];?></td><?php  } ?>
									<?php  if($set['level']>=3  && !empty($cm3)) { ?><td id='clevel3_sys_<?php  echo $goods['id'];?>'><?php  echo $goods['co']['level3'];?></td><?php  } ?>
								</tr>
								<?php  } } ?>
							 
								
								
							</table>
						</div>
					</div>
				     <div class="form-group">
							 
							   <div class="col-sm-9 col-xs-12">
								   <div class='form-control-static' style='color:red' >注: 不能修改的佣金为已申请或已结算</div>
							   </div>
						   </div>
					<div id="module-menus"></div>
				</div>
				<div class="modal-footer">
					<a style='float:left' href="javascript:;" class="btn btn-success" onclick='commission_changeall()' >按应得重新设置佣金</a>
					<button type="submit" class="btn btn-primary span2" name="submit" value="yes">确认修改</button>
					<a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a>
				</div>
			</div>
		</div>
	</form>
</div>
<script language='javascript'>
	function commission_changeall() {
		$('.clevel[data-canchange=1]').each(function(){
		       $(this).val( $('#clevel' + $(this).data('level') + '_sys_' + $(this).data('ogid')).html());
		});
		alert('设置成功， 如果确认无误，点击确认修改即可！')
		 
	}
</script>