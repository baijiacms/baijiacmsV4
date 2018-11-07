<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header_base");?>
<style>
	.text-danger{color:#a94442}a.text-danger:hover{color:#843534}
	</style>
<script language="javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/js/bjplus.js?v=2" charset="utf-8"></script>
<title><?php echo $data['title'];?></title>
<link href="<?php echo RESOURCE_ROOT;?>public/weui.min.css" rel="stylesheet">
<link href="<?php echo RESOURCE_ROOT;?>public/weui.plus.css?v=2" rel="stylesheet">
<div class="page_topbar">
        <a href="javascript:;" class="back" onclick="history.back()"><i class="fa fa-angle-left"></i></a>
        <div class="title">店铺公告</div>
    </div>
    
        <div class="page article js_show">
    <div class="page__hd">
        <h1 class="page__title" style=" font-weight:bold "><?php echo $data['title'];?></h1>
        <p class="page__desc" style="margin-left:5px">公告时间：<?php echo $data['createtime'];?> </p>
    </div>
    <div class="page__bd">
        <article class="weui-article"><?php echo $data['detail'];?>
    </div>
    
</div>

	
<?php include page('footer_base');?>