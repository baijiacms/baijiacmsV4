<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page('header_base');?>
<?php include page('header_plus');?>
<title>优惠券详情</title>
<link rel="stylesheet" type="text/css" href="<?php  echo WEBSITE_ROOT;?>/assets/eshop/static/mobile/static/coupon/images/style.css">
<style type="text/css">
    body {<?php if(is_mobile()){?>margin:0px;<?php }?>background:#eee; font-family:'微软雅黑'; -moz-appearance:none;overflow-x: hidden;}
    a {text-decoration:none;}
   .coupon_num { margin:10px; background:#fff;border:1px solid #eaeaea;padding:10px; text-align:right; font-size:13px; color:#666;}
	.coupon_detail { background:#fff;border:1px solid #eaeaea;padding:5px;margin:5px 10px;}
	.coupon_detail .dtitle { color:#333; font-size:14px; padding:5px; font-weight:bold; border-bottom:1px solid #eaeaea;}
	.coupon_detail .dtitle span { float:right;font-weight:normal}
	.coupon_detail .ddetail img { width:100%;outline-width:0px;  vertical-align:top; display:block}
	.coupon_detail .ddetail p { line-height:100%;}
	.coupon_use {position: fixed;  bottom:0; width:100%; height:40px; line-height: 40px; color:#fff;font-size:14px; text-align: center;z-index:1000}    
	.coupon_detail .dgoods { overflow:hidden; padding:5px 0;}
    .coupon_detail .dgoods .good {height:auto; width:46%; padding:0px 2% 10px; float:left;}
    .coupon_detail .dgoods .good img {height:120px; width:100%;}
    .coupon_detail .dgoods .good .name {height:20px; width:100%; font-size:15px; line-height:20px; color:#666; overflow:hidden;}
    .coupon_detail .dgoods .good .price {height:20px; width:100%; color:#f03; font-size:14px;}
    .coupon_detail .dgoods .good .price span {color:#aaa; font-size:12px; text-decoration:line-through;}
	
</style>
<div class="page_topbar"> 
	<a href="javascript:;" class="back" onclick="history.back()"><i class="fa fa-angle-left"></i></a>
	<div class="title">优惠券详情</div>
</div>
<div class="coupon_content ">
	<div class="bd bd-<?php  echo $coupon['css'];?>"></div>
	
	<div class="body <?php  echo $coupon['css'];?>">
		<div class="bg png png-<?php  echo $coupon['css'];?>"></div>
		<div class='top'>
			<?php  if(!empty($coupon['thumb'])) { ?>
			<div class='left'><img src='<?php  echo tomedia($coupon['thumb'])?>'/></div>
			<?php  } ?>
			<div class='right' <?php  if(empty($coupon['thumb'])) { ?> style="margin-left:0"<?php  } ?>>
				<div class='inner'  <?php  if(empty($coupon['thumb'])) { ?> style="margin-left:0"<?php  } ?>>
					<div class="name" style="text-align: center;"><?php  echo $coupon['couponname'];?></div>		
					<div class="time" style="text-align: center;"><?php  if(empty($coupon['timestr'])) { ?>
						永久有效
						<?php  } else { ?>
						<?php  if($coupon['past']) { ?>
						已过期
						<?php  } else { ?>
						到期时间: <?php  echo $coupon['timestr'];?>
						<?php  } ?>
						<?php  } ?></div>		
				</div>
			</div>
		</div>

		<div class='enough' style=" text-align: center;border-top: 1px dashed #fff;font-size:1.2srem;"><?php  if($coupon['coupontype']==1) { ?>充值<?php  } else { ?>消费<?php  } ?><?php  if($coupon['enough']>0) { ?>满 ￥<?php  echo $coupon['enough'];?><?php  } else { ?>任意金额<?php  } ?></div>

		<div class='act' style="color:#fff; text-align: center;">

			<?php  if($coupon['backtype']==0) { ?> 
			   立减 ￥<?php  echo $coupon['deduct'];?> 
			<?php  } else if($coupon['backtype']==1) { ?> 
			   <?php  echo $coupon['discount'];?> 折
			<?php  } else if($coupon['backtype']==2) { ?> 
				返 <?php  if(!empty($coupon['backcredit'])) { ?> <?php  echo $coupon['backcredit'];?> 积分 <?php  } ?>
				<?php  if(!empty($coupon['backmoney'])) { ?> <?php  echo $coupon['backmoney'];?> 余额 <?php  } ?>
			<?php  } ?>

		</div>
	</div>
	<div class="bd1 bd-<?php  echo $coupon['css'];?> "></div>
		
</div>
<div class='coupon_detail'>
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
	<div class='dtitle'>推荐商品 <span onclick='getRecommands()'>换一批</span></div>
	<div class='dgoods' id='dgoods'>
		
	</div>
</div>
<script language='javascript'>
	$(function(){
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
<?php  if($canuse) { ?>
<div style='height:50px'>&nbsp;</div>
<div class='coupon_use  <?php  echo $coupon['css'];?>' onclick="location.href='<?php  echo $useurl;?>'">
<?php  if(empty($coupon['coupontype'])) { ?>	 
	 立即去选商品使用
	 <?php  } else { ?>
	 立即去充值
	 <?php  } ?>
</div>
<?php  } ?>

<script language='javascript'>
	function getRecommands(){

		     
		core_json("<?php echo 	create_url('mobile',array('do'=>'shop','act'=>'util','m'=>'eshop'))?>",{op:'recommand'},function(json){
                         if(json.result.list.length<=0){
                             $('#dgoods').html('暂时没有同店推荐');
                             return;
                         }
                         $('#dgoods').html( tpl('tpl_recommand',json.result));
                         $('#dgoods .good').click(function(){
                            location.href = "<?php echo 	create_url('mobile',array('do'=>'shop','act'=>'detail','m'=>'eshop'))?>&id="+$(this).data('goodsid');
                         }).find('img').each(function(){
                             $(this).height($(this).width());
                         });
                         
                     });
		
	}
</script>


<?php  $show_footer=false;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>