<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page('header_base');?>
<title>商城商品</title>
<script language="javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/js/bjplus.js?v=2" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_ROOT;?>eshop/static/js/dist/foxui/css/foxui.min.css?v=0.1">
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_ROOT;?>eshop/static/css/diystyle.css?x=13">
    <script src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_ROOT;?>eshop/static/css/foxui.diy.css?v=0.1">
	<script>window.global_website="<?php echo WEBSITE_ROOT;?>";</script>
	<script src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/require.js"></script>
	<script>
     	var version = "<?php echo time();?>";
require.config({
    urlArgs: 'v=' + version, 
   baseUrl: '<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/' ,
    paths: {
        'jquery': '../dist/jquery/jquery-1.11.1.min',
        'jquery.gcjs': '../dist/jquery/jquery.gcjs',
        'tpl':'../dist/tmodjs',
        'foxui':'../dist/foxui/js/foxui.min',
        'foxui.picker':'../dist/foxui/js/foxui.picker.min',
        'foxui.citydata':'../dist/foxui/js/foxui.citydata.min',
    },
    shim: {
        'foxui':{
            deps:['jquery']
        },
        'foxui.picker': {
            exports: "foxui",
            deps: ['foxui','foxui.citydata']
        },
		'jquery.gcjs': {
	                 deps:['jquery']		
		}
    }
});




     	</script>
     	<style type="text/css">
     		.icon {
    font-size: 16px;
    font-style: normal;
    -webkit-font-smoothing: antialiased;
    -webkit-text-stroke-width: 0.2px;
}		
            .fui-navbar {
                max-width:750px;
            }
            .fui-navbar,.fui-footer  {
                max-width:750px;
            }
            .fui-page.fui-page-from-center-to-left,
            .fui-page-group.fui-page-from-center-to-left,
            .fui-page.fui-page-from-center-to-right,
            .fui-page-group.fui-page-from-center-to-right,
            .fui-page.fui-page-from-right-to-center,
            .fui-page-group.fui-page-from-right-to-center,
            .fui-page.fui-page-from-left-to-center,
            .fui-page-group.fui-page-from-left-to-center {
                -webkit-animation: pageFromCenterToRight 0ms forwards;
                animation: pageFromCenterToRight 0ms forwards;
            }
        </style>
  
        <script language="javascript">require(['core'],function(modal){modal.init({siteUrl: "<?php echo WEBSITE_ROOT;?>"})});</script>
   
   <body ontouchstart="">
   	
   	<div class='fui-page  fui-page-current page-goods-list'>
    <div class="fui-header">
	<div class="fui-header-left">
	    <a class="back"></a>
	</div>
	<div class="title">
		<form method="post">
				<div class="searchbar">
				<div class="search-input">
					<i class="fa fa-search"></i>
					<input type="search" id="search" placeholder="输入关键字..." value="<?php  echo $_GPC['keywords'];?>">
				</div>
				</div>
		</form>
	</div>
	<div class="fui-header-right" data-nomenu="true">
	    <a href="javascript:;"><i class="fa fa-sort" id="listblock" data-state="list"></i></a>
	</div>
    </div>
    <div class="sort">
	<div class="item on"><span class='text'>综合</span></div>
	<div class="item" data-order="sales"><span class='text'>销量</span></div>
	<div class="item item-price"  data-order="marketprice"><span class='text'>价格</span>
	    <span class="sorting">
		<i class="icon fa fa-sort-asc icon-sanjiao2" style="  font-size: 16px;position: absolute;"></i>
		<i class="icon fa fa-sort-desc icon-sanjiao1" style="  font-size: 16px;position: absolute;"></i>
		
	    </span>
	</div>
	<div class="item"  data-order="filter"><span class='text'>筛选 <i class="fa fa-filter "></i></span> </div>
    </div>



    <div class="fui-content navbar">
	<div class='fui-content-inner'>
	    <div class='content-empty' style='display:none;'>
		<i class='icon icon-searchlist'></i><br/>暂时没有任何商品
	    </div>
	    <div class="fui-goods-group container block"></div>
	    <div class='infinite-loading'><span class='fui-preloader'></span><span class='text'> 正在加载...</span></div>
	</div>
		</div>

     <div class='fui-mask-m'></div>
     <div class="screen">
	<div class="attribute">
	    <div class="item">
		<div class="btn btn-default-o block" data-type="isrecommand"><i class="fa fa-check"></i> 推荐商品</div>
	    </div>
	    <div class="item">
		<div class="btn btn-default-o block" data-type="isnew"><i class="fa fa-check"></i> 新品上市</div>
	    </div>
	    <div class="item">
		<div class="btn btn-default-o block" data-type="ishot"><i class="fa fa-check"></i> 热卖商品</div>
	    </div>
	    <div class="item">
		<div class="btn btn-default-o block" data-type="isdiscount"><i class="fa fa-check"></i> 促销商品</div>
	    </div>
	    <div class="item">
		<div class="btn btn-default-o block" data-type="issendfree"><i class="fa fa-check"></i> 卖家包邮</div>
	    </div>
	    <div class="item">
		<div class="btn btn-default-o block" data-type="istime"><i class="fa fa-check"></i> 限时抢购</div>
	    </div>
	</div>
	<?php  if($catlevel!=-1 && $opencategory) { ?>
	<div class="title">选择分类</div>
	<div class="cate" data-catlevel="<?php  echo $catlevel;?>">
		<div class="item"  data-level="1">
		   <?php  if(is_array($allcategory['parent'])) { foreach($allcategory['parent'] as $c) { ?>
		   <nav data-id="<?php  echo $c['id'];?>"><?php  echo $c['name'];?></nav>
		   <?php  } } ?>
   	         </div>
		<?php  if($catlevel>=2) { ?>
		<div class="item" data-level="2"></div>
		<?php  } ?>
		<?php  if($catlevel>=3) { ?>
		<div class="item" data-level="3"></div>
		<?php  } ?>
	</div>
	<?php  } ?>
	<div class="btns">
	    <div class="cancel">取消筛选</div>
	    <div class="confirm">确认</div>
	</div>
    </div>

<script type='text/html' id='tpl_goods_list'>
     <%each list as g%>
     
	 <div class="fui-goods-item" data-goodsid="<%g.id%>">
	  <a href="<?php echo create_url('mobile',array('act'=>'detail','do'=>'shop','m'=>'eshop'))?>&id=<%g.id%>">
	  <div class="image" style="background-image: url(<%g.thumb%>);">
		  <%if g.total<=0%><div class="salez" style="background-image: url('<?php  echo RESOURCE_ROOT;?>/eshop/static/mobile/static/images/salez.png'); "></div><%/if%>
	  </div>
        </a>
	<div class="detail">
	   <a href="<?php echo create_url('mobile',array('act'=>'detail','do'=>'shop','m'=>'eshop'))?>&id=<%g.id%>">
	           <div class="name"><%g.title%></div>
	       </a>
	           <div class="price">
		   <span class="text">￥<%g.marketprice%></span>
		   <span class="buy" onclick="location.href='<?php echo create_url('mobile',array('act'=>'detail','do'=>'shop','m'=>'eshop'))?>&id=<%g.id%>';"><i class="fa fa-shopping-cart"></i></span></div>
	    </div>
	</div>

    <%/each%>

</script>
<script id="tpl_cate_list" type="text/html">
	<div class="item">
	   <%each category as c%>
		<nav class="on"><%c.catname%></nav>
            <%/each%>
        </div>
</script>
    <script language="javascript">
    	window.goods_get_list="<?php echo WEBSITE_ROOT.create_url('mobile',array('act'=>'index','do'=>'goods','m'=>'eshop','op'=>'get_list'))?>";
	  window.category = false;
	  <?php  if($catlevel!=-1) { ?>
	      window.category = <?php  echo json_encode($allcategory)?>;
	  <?php  } ?>
	   require(['../app/biz/goods/list'], function (modal) {
                modal.init({
					page: "1",
					keywords: "<?php  echo $_GPC['keywords'];?>",
					isrecommand: "<?php  echo $_GPC['isrecommand'];?>",
					ishot: "<?php  echo $_GPC['ishot'];?>",
					isnew: "<?php  echo $_GPC['isnew'];?>",
					isdiscount: "<?php  echo $_GPC['isdiscount'];?>",
					issendfree: "<?php  echo $_GPC['issendfree'];?>",
					istime: "<?php  echo $_GPC['istime'];?>",
					cate: "<?php  echo empty($_GPC['cate'])?$_GPC['ccate']:$_GPC['cate'];?>",
					order: "<?php  echo $_GPC['order'];?>",
					by: "<?php  echo $_GPC['by'];?>",
					merchid: "<?php  echo $_GPC['merchid'];?>"
				});
            });</script>
</div>

<?php  $show_footer=true;$footer_current ='category'?> 
<?php include page('footer_menu');?>
<?php include page('footer_base');?>
