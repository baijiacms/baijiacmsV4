<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page('header_base');?>
<?php include page('header_plus');?>
<title>优惠券详情</title>
<link rel="stylesheet" type="text/css" href="<?php  echo RESOURCE_ROOT;?>eshop/static/mobile/static/coupon/images/style.css">
<script language="javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/sweetalert/sweetalert.min.js"></script>
<style type="text/css">
    body {<?php if(is_mobile()){?>margin:0px;<?php }?>background:#efefef; font-family:'微软雅黑'; -moz-appearance:none;overflow-x: hidden;}
    a {text-decoration:none;}
 
	.coupon_num { margin:10px; background:#fff;border:1px solid #eaeaea;padding:10px; text-align:right; font-size:13px; color:#666;}

	.coupon_detail { background:#fff;border:1px solid #eaeaea;padding:5px;margin:5px 10px; }
	.coupon_detail .dtitle { color:#333; font-size:14px; padding:5px; font-weight:bold; border-bottom:1px solid #eaeaea;}
	.coupon_detail .dtitle span { float:right;font-weight:normal;padding:3px;  border-radius:3px; text-align:center; line-height:16px;line-height:16px; }
	.coupon_detail .ddetail img { width:100%;outline-width:0px;  vertical-align:top; display:block}
	.coupon_detail .ddetail p { line-height:100%;}


	.coupon_detail .dgoods { overflow:hidden; padding:5px 0;}
	.coupon_detail .dgoods .good {height:auto; width:46%; padding:0px 2% 10px; float:left;}
    .coupon_detail .dgoods .good img {height:120px; width:100%;}
    .coupon_detail .dgoods .good .name {height:20px; width:100%; font-size:15px; line-height:20px; color:#666; overflow:hidden;}
    .coupon_detail .dgoods .good .price {height:20px; width:100%; color:#f03; font-size:14px;}
    .coupon_detail .dgoods .good .price span {color:#aaa; font-size:12px; text-decoration:line-through;}
 

	.coupon_use {position: fixed;  bottom:0; width:100%; height:40px; line-height: 40px; color:#fff;font-size:14px; text-align: center;z-index:1000}    
	.coupon_use .left { float:left;width:70%;background:rgba(0,0,0,0.5); text-align: center;}
	.coupon_use .right { float:left; width:30%;text-align: center; }
	
.coupon-detail-btn{padding:0.5rem;}
.coupon-detail-btn span{    cursor: pointer;line-height: 1.2rem;display: block;font-size:1rem;padding:0.3rem;}
.coupon-detail-btn a{    cursor: pointer;display:block;width:10rem;height:2rem;border:0.2rem solid #000;border-color: rgba(0,0,0,0.3);-webkit-border-radius: 2rem;border-radius: 2rem;margin:0 auto;
overflow: hidden;}
.coupon-detail-btn a span{        color: #f74a4a;cursor: pointer;height:1.6rem;display: block;background: #fff;line-height: 1.6rem;font-size:0.8rem;}
</style>
<div class="page_topbar"> 
	<a href="javascript:;" class="back" onclick="history.back()"><i class="fa fa-angle-left"></i></a>
	<a href="<?php  echo $this->createMobileUrl('coupon/center')?>" class="btn"><i class="fa fa-home"></i></a>
	<div class="title">优惠券详情</div>
</div>

<div class="coupon_content " style="height: 200px;">
	<div class="bd bd-<?php  echo $coupon['css'];?>"></div>
	
	<div class="body <?php  echo $coupon['css'];?>" style="height: 170px;">
		<div class='top'>
			<?php  if(!empty($coupon['thumb'])) { ?>
			<div class='left'><img src='<?php  echo tomedia($coupon['thumb'])?>'/></div>
			<?php  } ?>
			<div class='right' <?php  if(empty($coupon['thumb'])) { ?> style="margin-left:0"<?php  } ?>>
				<div class='inner'  <?php  if(empty($coupon['thumb'])) { ?> style="margin-left:0"<?php  } ?>>
					<div class="name" style="text-align: center;"><?php  echo $coupon['couponname'];?></div>		
					<div class="time" style="text-align: center;"><?php  if($coupon['timestr']=='0') { ?>
			永久有效
			<?php  } else { ?>
		 <?php  if($coupon['timestr']=='1') { ?>
		       有效期：<?php  echo $coupon['gettypestr'];?>日内 <?php  echo $coupon['timedays'];?> 天有效
				  <?php  } else { ?>
			有效期：<?php  echo $coupon['timestr'];?>
			<?php  } ?>
			<?php  } ?>
					
					</div>		
					
					
					
				</div>
			</div>
		</div>

		<div class='act' style=" text-align: center;border-top: 1px dashed #fff;font-size:1.2srem;">消费<?php  if($coupon['enough']>0) { ?>满 ￥<?php  echo $coupon['enough'];?><?php  } else { ?>任意金额<?php  } ?>

			<?php  if($coupon['backtype']==0) { ?> 
			   立减 ￥<?php  echo $coupon['deduct'];?> 
			<?php  } else if($coupon['backtype']==1) { ?> 
			   <?php  echo $coupon['discount'];?> 折
			<?php  } else if($coupon['backtype']==2) { ?> 
				返 <?php  if(!empty($coupon['backcredit'])) { ?> <?php  echo $coupon['backcredit'];?> 积分 <?php  } ?>
				<?php  if(!empty($coupon['backmoney'])) { ?> <?php  echo $coupon['backmoney'];?> 余额 <?php  } ?>
			<?php  } ?>

		</div>
		<div  style="color:#fff; text-align: center;" class="coupon-detail-btn">	<a href="javascript:void(0);" id="btncoupon"><span >立即领取</span></a></div>
		<div  style="color:#fff; text-align: center;">
			 <?php  if($coupon['cangetmax']==-1) { ?>
		 无限领取
		 <?php  } else { ?>
		 <?php  if($coupon['canget']) { ?>
		 您还可以<?php  echo $coupon['gettypestr'];?> <?php  echo $coupon['cangetmax'];?> 张
		 <?php  } else { ?>
		 您已<?php  echo $coupon['gettypestr'];?>过
		 <?php  } ?>
		 <?php  } ?>
		</div>
	</div>
	<div class="bd1 bd-<?php  echo $coupon['css'];?> "></div>
		
</div>

<div class='coupon_detail'>
	<div class='dtitle'>
		领取限制 


<?php  if($coupon['getstatus']!='3') { ?><span style='font-weight:normal'><?php  echo $coupon['gettypestr'];?></span><?php  } ?>
		<?php  if($coupon['getstatus']=='0') { ?><span class="ccreditmoney"><?php  echo $coupon['money'];?> 元 + <?php  echo $coupon['credit'];?> 积分</span><?php  } ?>
		<?php  if($coupon['getstatus']=='1') { ?><span class="cmoney"><?php  echo $coupon['money'];?> 元</span><?php  } ?>
		<?php  if($coupon['getstatus']=='2') { ?><span class="ccredit"><?php  echo $coupon['credit'];?> 积分</span><?php  } ?>
		<?php  if($coupon['getstatus']=='3') { ?><span class="cfree">免费领取</span><?php  } ?>
		
		
		
	</div>
	<div class='dtitle'>
		有效期： 

<span class="cfree">
	<?php  if($coupon['timestr']=='0') { ?>
			永久有效
			<?php  } else { ?>
		 <?php  if($coupon['timestr']=='1') { ?>
		     <?php  echo $coupon['gettypestr'];?>日内 <?php  echo $coupon['timedays'];?> 天有效
				  <?php  } else { ?>
			有效期<?php  echo $coupon['timestr'];?>
			<?php  } ?>
			<?php  } ?>
	
</span>
		
		
		
	</div>
	<div class='dtitle'>使用说明 <?php  if($num>0) { ?><span>共 <?php  echo $num;?> 张</span><?php  } ?></div>
	<div class='ddetail'>
		<?php  if(empty($coupon['descnoset'])) { ?>
		<?php  if(empty($coupon['coupontype'])) { ?>
		<?php  echo htmlspecialchars_decode($set['consumedesc'])?>
		<?php  } else { ?>
		<?php  echo htmlspecialchars_decode($set['rechargedesc'])?>
		<?php  } ?>
		<?php  } ?>
		<?php  echo $coupon['desc'];?>
	</div>
</div>
<?php  if($coupon['coupontype']==0) { ?>
<div class='coupon_detail'>
	<div class='dtitle'>推荐商品 <span onclick='getRecommands()' style="cursor: pointer;">换一批</span></div>
	<div class='dgoods' id='dgoods'></div>
</div>
<script language='javascript'>
	$(function () {
		getRecommands();
	})
</script>
<?php  } ?>
<script type='text/html' id='tpl_recommand'>
	<%each list as g%>
	<div class="good" data-goodsid="<%g.id%>">
		<img src='<%g.thumb%>'/>
		<div class="name"><%g.title%></div>
		<div class="price">￥<%g.marketprice%> <%if g.productprice>0 && g.marketprice!=g.productprice%><span>￥<%g.productprice%></span><%/if%></div>
	</div>
	<%/each%>
</script> 

<div style='height:50px'>&nbsp;</div>



	<script language='javascript'>
		
		function getRecommands() {


				core_json("<?php echo 	create_url('mobile',array('do'=>'shop','act'=>'util','m'=>'eshop'))?>", {op: 'recommand'}, function (json) {
					if (json.result.list.length <= 0) {
						$('#dgoods').html('暂时没有同店推荐');
						return;
					}
					$('#dgoods').html(tpl('tpl_recommand', json.result));
					$('#dgoods .good').click(function () {
						
						location.href = "<?php echo 	create_url('mobile',array('do'=>'shop','act'=>'detail','m'=>'eshop'))?>&id="+$(this).data('goodsid');
					}).find('img').each(function () {
						$(this).height($(this).width());
					});

				});
		
		}
		function payResult() {
			var btn = $('#btncoupon');
		
			
				core_json("<?php echo 	create_url('mobile',array('do'=>'coupon','act'=>'detail','m'=>'eshop'))?>", {
					op: 'payresult',
					'id': '<?php  echo $id;?>',
					logid: window.logid
				}, function (pay_json) {
					btn.html(btn.attr('oldhtml')).removeAttr('oldhtml').removeAttr('submitting');
					if (pay_json.status == 1) {
						var text = "";
						var button = "";
							text = "恭喜您，优惠券到手啦";
						
					 
								
	tip_message(text,"<?php  echo $this->createMobileUrl('coupon/center')?>",'success');
						return;
					}
				
					btn.html(btn.attr('oldhtml')).removeAttr('oldhtml').removeAttr('submitting');
				}, true);
			
		}
		$(function () {


			<?php  if($coupon['canget']) { ?>
			$('#btncoupon').click(function () {
				var btn = $(this);

				if (btn.attr('submitting') == '1') {
					return;
				}
				btn.attr('oldhtml', btn.html()).html('<i class="fa fa-spinner fa-spin"></i> 请稍后..').attr('submitting', 1);
			
					core_json("<?php echo 	create_url('mobile',array('do'=>'coupon','act'=>'detail','m'=>'eshop'))?>", {'op': 'pay', 'id': '<?php  echo $id;?>'}, function (ret) {
						if (ret.status == '-1') {
							btn.html(btn.attr('oldhtml')).removeAttr('oldhtml').removeAttr('submitting');
							tip_show(ret.result);
							return;
						}
						window.logid = ret.result.logid;

						if (ret.result.wechat) {
							var wechat = ret.result.wechat;
							WeixinJSBridge.invoke('getBrandWCPayRequest', {
								'appId': wechat.appid ? wechat.appid : wechat.appId,
								'timeStamp': wechat.timeStamp,
								'nonceStr': wechat.nonceStr,
								'package': wechat.package,
								'signType': wechat.signType,
								'paySign': wechat.paySign,
							}, function (res) {
								if (res.err_msg == 'get_brand_wcpay_request:ok') {
									payResult();
								} else if (res.err_msg == 'get_brand_wcpay_request:cancel') {
									btn.html(btn.attr('oldhtml')).removeAttr('oldhtml').removeAttr('submitting');
									tip_show('取消支付');
								} else {
									btn.html(btn.attr('oldhtml')).removeAttr('oldhtml').removeAttr('submitting');
									alert(res.err_msg);
								}
							});
						} else {
							payResult();
						}

					}, true);
				
			});
			<?php  } ?>

		});
	</script>


<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>