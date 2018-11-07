<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header_base");?>
<style>
	.text-danger{color:#a94442}a.text-danger:hover{color:#843534}
	</style>
<script language="javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/js/bjplus.js?v=2" charset="utf-8"></script>
<title><?php  echo $article['article_title'];?></title>
<link href="<?php echo RESOURCE_ROOT;?>public/weui.min.css" rel="stylesheet">
<link href="<?php echo RESOURCE_ROOT;?>public/weui.plus.css?v=2" rel="stylesheet">

    
        <div class="page article js_show">
    <div class="page__hd">
        <h1 class="page__title" style=" font-weight:bold "><?php  echo $article['article_title'];?></h1>
        <p class="page__desc" style="margin-left:5px"><?php  echo $article['article_date_v'];?><?php  if(!empty($article['article_mp'])) { ?>&nbsp;<a ><?php  echo $article['article_mp'];?></a><?php  } ?><?php  if(!empty($article['article_author'])) { ?>&nbsp;<?php  echo $article['article_author'];?><?php  } ?> </p>
    </div>
    <div class="page__bd">
        <article class="weui-article"><?php  echo $article['article_content'];?>
    </div>
    <div class="page__ft" style="text-align:left">
     
						<?php  if(!empty($article['article_linkurl'])) { ?>
					<span style="margin-left: 20px;font-size: 16px;text-decoration: none; line-height: 1.0rem;     cursor: pointer;    color: #607fa6;margin-right: 10px;" onclick="location.href='<?php  echo $article['article_linkurl'];?>'">阅读原文 </span>
				<?php  } ?>
				
					<span style="color: #8c8c8c;">阅读&nbsp;<?php  echo $readnum;?> </span>
				<span  style="color: #8c8c8c;margin-left: 10px; cursor: pointer;" id="likebtn" data-num="<?php  echo $likenum;?>" data-state="<?php if($show_icon_likefill==true){?>1<?php  } else { ?>0<?php  } ?>">
					<i class="fa  <?php if($show_icon_likefill==true){?>text-danger fa-thumbs-up<?php }else{?>fa-thumbs-o-up<?php }?>"></i>
					赞<span><?php  echo $likenum;?></span></span>
    </div>
</div>

	<script>
		$("#likebtn").click(function() {
			var _this = $(this);
			var num = _this.data('num');
			var state = _this.data('state');
		
			if (state) {
				_this.find("i").removeClass("fa-thumbs-up").removeClass("text-danger").addClass("fa-thumbs-o-up");
				_this.data({
					'state': 0
				});
				if (String(num).indexOf('+') < 0) {
					_this.data({
						'num': num - 1
					}).find("span").text(num - 1)
				}
			} else {
				_this.find("i").removeClass("fa-thumbs-o-up").addClass("text-danger").addClass("fa-thumbs-up");
				_this.data({
					'state': 1
				});
				if (String(num).indexOf('+') < 0) {
					var endnum = num + 1 > 100000 ? '100000+' : num + 1;
					_this.data({
						'num': endnum
					}).find("span").text(endnum)
				}
			}
			core_json('<?php  echo create_url('mobile',array('act' => 'article','do' => 'like', 'id' => $article['id']))?>')
		})
		</script>
<?php include page('footer_base');?>