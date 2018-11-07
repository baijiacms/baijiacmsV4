<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page('header_base');?>
<title>商品分类</title>
  	<script>window.global_website="<?php echo WEBSITE_ROOT;?>";</script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_ROOT;?>eshop/static/js/dist/foxui/css/foxui.min.css?v=0.1">
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_ROOT;?>eshop/static/css/diystyle.css?x=13">
    <script src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_ROOT;?>eshop/static/css/foxui.diy.css?v=0.1">
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
     		
		 #container{
        	margin-bottom:50px;
        	}
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
<div class="fui-page fui-page-current page-shop-goods_category">

    <div class="fui-header">

        <div class="fui-header-left">

            <a class="back"></a>

        </div>

        <div class="title">

            <form method="post" action="<?php echo create_url('mobile',array('act'=>'index','do'=>'goods','m'=>'eshop'))?>">

                <div class="searchbar">

                    <div class="search-input">

                        <i class="fa fa-search"></i>

                        <input type="search" name="keywords" placeholder="输入关键字...">

                    </div>

                </div>

            </form>

        </div>

    </div>

	<div class="fui-content navbar">

    <div class="fui-fullHigh-group">

        <?php  if($category_set['level']!=1) { ?>

        <div class="fui-fullHigh-item menu" id="tab">


            <nav data-cate="recommend" data-src="<?php if(!empty($category_set['advimg'])){echo $category_set['advimg']; }else{};?>" data-href="<?php  echo $category_set['advurl'];?>">推荐分类</nav>

            <?php  if(is_array($category['parent']['0'])) { foreach($category['parent']['0'] as $value) { ?>

            <nav data-cate="<?php  echo $value['id'];?>" data-src="<?php if(!empty($value['advimg'])){echo $value['advimg']; }else{};?>" data-href="<?php  echo $value['advurl'];?>"><?php  echo $value['name'];?></nav>

            <?php  } } ?>

        </div>

        <?php  } ?>

        <div class="fui-fullHigh-item container" style="position: relative">

            <a id="advurl" class="swipe external" href="javascript:">

                <img id="advimg">

            </a>

            <div id="container"></div>

        </div>

    </div>

</div>

	</div>

<script id='tpl_shop_category_list' type='text/html'>

    <%if recommend == 1%>

    <div class="fui-icon-group selecter">

        <a class="fui-icon-col external" href="<?php echo create_url('mobile',array('act'=>'index','do'=>'goods','m'=>'eshop'))?>">

            <div class="icon radius"><i class="fa fa-navicon"></i></div>

            <div class="text">所有商品</div>

        </a>

        <?php  if($category_set['level']<=2) { ?>

            <%each recommend_children as child%>

                <a class="fui-icon-col external" href="<?php echo create_url('mobile',array('act'=>'index','do'=>'goods','m'=>'eshop'))?>&cate=<%child.id%>">

                    <div class="icon radius"><img src="<%child.thumb%>" onerror="this.src='<?php echo RESOURCE_ROOT;?>weengine/images/nopic.jpg'; this.title='图片未找到.'"></div>

                    <div class="text"><%child.name%></div>

                </a>

            <%/each%>



        <?php  } else { ?>



            <%each recommend_children as child%>

                <a class="fui-icon-col show" data-children="<%child.id%>" data-pid="recommend" data-src="<%child.advimg%>" data-href="<%child.advurl%>" href="javascript:">

                    <div class="icon radius">

                        <img src="<%child.thumb%>" onerror="this.src='<?php echo RESOURCE_ROOT;?>weengine/images/nopic.jpg'; this.title='图片未找到.'">

                    </div>

                    <div class="text"><%child.name%></div>

                </a>

            <%/each%>

        <?php  } ?>



        <%each recommend_grandchildren as grandchild%>

        <a class="fui-icon-col external" href="<?php echo create_url('mobile',array('act'=>'index','do'=>'goods','m'=>'eshop'))?>&cate=<%grandchild.id%>">

            <div class="icon radius"><img src="<%grandchild.thumb%>" onerror="this.src='<?php echo RESOURCE_ROOT;?>weengine/images/nopic.jpg'; this.title='图片未找到.'"></div>

            <div class="text"><%grandchild.name%></div>

        </a>

        <%/each%>

    </div>

    <%else%>



    <?php  if($category_set['level']==1) { ?>

    <a class="fui-title">所有分类</a>

    <div class="fui-icon-group selecter">

        <a class="fui-icon-col external" href="<?php echo create_url('mobile',array('act'=>'index','do'=>'goods','m'=>'eshop'))?>">

            <div class="icon radius"><i class="fa fa-navicon"></i></div>

            <div class="text">所有商品</div>

        </a>

        <%each parent[0] as cate%>

        <a class="fui-icon-col external" href="<?php echo create_url('mobile',array('act'=>'index','do'=>'goods','m'=>'eshop'))?>&cate=<%cate.id%>">

            <div class="icon radius"><img src="<%cate.advimg%>" onerror="this.src='<?php echo RESOURCE_ROOT;?>weengine/images/nopic.jpg'; this.title='图片未找到.'"></div>

            <div class="text"><%cate.name%></div>

        </a>

        <%/each%>

    </div>



    <?php  } else if($category_set['level']==2 || empty($category_set['level']) ) { ?>

    <div class="fui-icon-group selecter">

        <%each children as child%>

        <a class="fui-icon-col external" href="<?php echo create_url('mobile',array('act'=>'index','do'=>'goods','m'=>'eshop'))?>&cate=<%child.id%>">

            <div class="icon radius"><img src="<%child.thumb%>" onerror="this.src='<?php echo RESOURCE_ROOT;?>weengine/images/nopic.jpg'; this.title='图片未找到.'"></div>

            <div class="text"><%child.name%></div>

        </a>

        <%/each%>

    </div>



    <?php  } else { ?>

    <?php  if($category_set['show']!=1) { ?>

    <%each children as child%>

    <a class="fui-title external" href="<?php echo create_url('mobile',array('act'=>'index','do'=>'goods','m'=>'eshop'))?>&cate=<%child.id%>"><%child.name%></a>

    <div class="fui-icon-group selecter">

        <%each grandchildren[child.id] as grandchild%>

        <a class="fui-icon-col external" href="<?php echo create_url('mobile',array('act'=>'index','do'=>'goods','m'=>'eshop'))?>&cate=<%grandchild.id%>">

            <div class="icon radius"><img src="<%grandchild.thumb%>" onerror="this.src='<?php echo RESOURCE_ROOT;?>weengine/images/nopic.jpg'; this.title='图片未找到.'"></div>

            <div class="text"><%grandchild.name%></div>

        </a>

        <%/each%>

    </div>

    <%/each%>

    <?php  } else { ?>

    <div class="fui-icon-group selecter">

    <%each children as child%>

    <a class="fui-icon-col show" data-children="<%child.id%>" data-pid="<%child.parentid%>"  data-src="<%child.advimg%>" data-href="<%child.advurl%>" href="javascript:">

        <div class="icon radius"><img src="<%child.thumb%>" onerror="this.src='<?php echo RESOURCE_ROOT;?>weengine/images/nopic.jpg'; this.title='图片未找到.'"></div>

        <div class="text"><%child.name%></div>

    </a>

    <%/each%>

    </div>

    <?php  } ?>

    <?php  } ?>

    <%/if%>

</script>



<script id='tpl_shop_category_show_list' type='text/html'>

    <div class="fui-icon-group selecter">

        <a class="fui-icon-col prev" data-prev="<%pid%>">

            <div class="icon radius"><i class="icon icon-toleft"></i></div>

            <div class="text">返回上一级</div>

        </a>

        <%each children as child%>

        <a class="fui-icon-col external" href="<?php echo create_url('mobile',array('act'=>'index','do'=>'goods','m'=>'eshop'))?>&cate=<%child.id%>">

            <div class="icon radius"><img src="<%child.thumb%>" onerror="this.src='<?php echo RESOURCE_ROOT;?>weengine/images/nopic.jpg'; this.title='图片未找到.'"></div>

            <div class="text"><%child.name%></div>

        </a>

        <%/each%>

    </div>

</script>

<script language='javascript'>
    require(['../app/biz/category'], function (modal) {
         modal.init(<?php  echo json_encode($category);?>,<?php echo json_encode($category_set);?>);
    });
</script>


<?php  $show_footer=true;$footer_current ='category'?> 
<?php include page('footer_menu');?>
<?php include page('footer_base');?>
