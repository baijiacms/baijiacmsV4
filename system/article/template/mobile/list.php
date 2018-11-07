<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header_base");?>
<title>文章列表</title>
<style>
	.page, body {
    background-color: #f8f8f8;
}
	</style>
<script language="javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/js/bjplus.js?v=2" charset="utf-8"></script>
<title><?php  echo $article['article_title'];?></title>
        <link href="<?php echo RESOURCE_ROOT;?>public/weui.min.css" rel="stylesheet">
        <link href="<?php echo RESOURCE_ROOT;?>public/weui.plus.css?v=2" rel="stylesheet">
  
<div class="page panel js_show" style="margin-bottom:50px">
	
	<div class="page__hd">
			<?php  if(is_array($articles)) { foreach($articles as $k => $v) { ?>
		<div class="weui-panel weui-panel_access">
            <div class="weui-panel__bd">
                <a href="<?php  echo create_url('mobile',array('act' => 'article','do' => 'article', 'id' => $v['articles'][0]['id']))?>" class="weui-media-box weui-media-box_appmsg">
                
                    <div class="weui-media-box__bd">
          
                        <h4 class="weui-media-box__title"><?php  echo $v['articles'][0]['article_title'];?></h4>
                             <p class="weui-media-box__desc"><?php  echo $v['articles'][0]['article_date_v'];?></p>
                        						<?php  if(!empty($v['articles'][0]['resp_img'])) { ?>
                          <p >      <img style="width:100%;height:210px" src="<?php  echo tomedia($v['articles'][0]['resp_img'])?>" alt="">
                  </p>	<?php  } ?>
                     <p class="weui-media-box__desc"><?php  echo $v['articles'][0]['resp_desc'];?></p>
                     
                    </div>
                </a>
            </div>
            <div class="weui-panel__ft">
                <a href="<?php  echo create_url('mobile',array('act' => 'article','do' => 'article', 'id' => $v['articles'][0]['id']))?>" class="weui-cell weui-cell_access weui-cell_link">
                    <div class="weui-cell__bd" style="color:#000;">阅读原文</div>
                    <span class="weui-cell__ft"></span>
                </a>    
            </div>
        </div>
        	<?php }} ?>
        
        
        
    </div>
</div>
     	
<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>