<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page('header_base');?>
	<title>积分排行榜</title>
	<link href="<?php  echo RESOURCE_ROOT;?>eshop/static/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php  echo RESOURCE_ROOT;?>eshop/static/css/jfpx/integral.css">
	<script>window.global_website="<?php echo WEBSITE_ROOT;?>";</script>

<body style="background-color:#FFC502;padding-top:0px; padding-bottom:0px;" class="body-gray my-memvers">

<!-- 积分排行 -->
<section style="background:#ff9900;margin-top:-17px;<?php if(is_mobile()){?>margin: 0 15px 10px 15px;<?php }?>">
	<img src="<?php  echo RESOURCE_ROOT;?>eshop/static/images/integral.jpg" border="0" width="100%">
</section>
<div class="list-myorder" style="background:#ffffff;">
	<ul class="ul-product" style="color:#ffcc00;font-size:20px;">
		<?php  $key=1?>
		<?php  if(is_array($list)&&!empty($list)) { foreach($list as $member) { ?>
			<li>
            <span style="float:left;margin-right:10px;border-radius:3px;"><?php  echo $key;?></span>
            <?php  if($key==1||$key==2||$key==3) { ?>
            <span style="float:right;margin-left:10px;border-radius:3px;"><img style="width:30px;height:42px;" src="<?php  echo RESOURCE_ROOT;?>eshop/static/images/0<?php  echo $key;?>.jpg" style="border-width:0px;"></span>
            <?php  } ?>
				<span class="pic" onClick="newMsg('<?php  echo $member["openid"];?>');"><img src="<?php  echo tomedia($member['avatar']);?>" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" style="border-radius:50px;"></span>
				<div class="text">
					<span class="pro-name">昵称：<?php  echo $member['nickname'];?></span>
						<div class="pro-pric" style="color:#ff9900;font-size:25px;"><span>积分：</span><?php  echo number_format($member['credit1'],0,'','')?></div>
				</div>
			</li>
		<?php  $key++?>
		<?php  } }else{ ?><li align="center">暂时还没有人上榜~</li>	<?php  } ?>
	</ul>
</div>
<div align="center"><span style="color:#fff;font-size:16px; padding-bottom:60px;">赶紧加油获得更多积分上榜吧</span></div>
<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>