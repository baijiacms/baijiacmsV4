<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page('header_base');?>
<title><?php echo $diypage['pageinfo']['title']?></title>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_ROOT;?>eshop/static/js/dist/foxui/css/foxui.min.css?v=0.1">
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_ROOT;?>eshop/static/css/diystyle.css?x=4">
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
    font-family: "icon" !important;
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

    <body>
<?php $set_footer_menuid=$diypage['pageinfo']['diymenu'];
if($set_footer_menuid==-1)
{

 $show_footer=false;
}else
{
	if(empty($set_footer_menuid))
{
	$set_footer_menuid=0;
}
	$show_footer=true;
}
?>

        <script language="javascript">require(['core'],function(modal){modal.init({siteUrl: "<?php echo WEBSITE_ROOT;?>"})});</script>
        
    <body ontouchstart="">
		<div class="fui-page-group" >
<div class="fui-page  fui-page-current" >
    <div class="fui-content " id="container" style="<?php if($show_footer){ ?>margin-bottom:49px;<?php }else{ ?>margin-bottom:0px;<?php }?>background-color: <?php echo empty($pageinfo['background'])?'#fafafa':$pageinfo['background'];?>"></div>
 	 	<?php if(is_use_weixin()){
	  $share_set=globalSetting('share');

	   if(!empty($share_set['followurl'])){
	   	$tmpopenid=get_sysopenid(false);
	   		$weixin_info=get_weixin_fans_info('',$tmpopenid); 
  if(!empty($weixin_info['weixin_openid'])&&empty($weixin_info['follow']))
	   {
?>
	<div class="fui-list follow_topbar">
	   	<div class="fui-list-media">
	   		<img class="round" src="<?php  echo $settings['logo']?>" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'">
	   	</div>
	    <div class="fui-list-inner">
	    	<div class="text"><?php if(!empty($settings['name'])){;?>欢迎进入 <?php  echo $settings['name']?> <br><?php }?> 关注公众号，享专属服务</div>
	    </div>
   		<div class="fui-list-angle">
   			<a class="btn btn-success" onclick="location.href='<?php  echo $share_set['followurl']?>';" href="javascript:;">立即关注</a>
   		</div> 
   	</div>
   	<div style='height:47px;'>&nbsp;</div>
<?php }  } } ?>
    <script type="text/html" id="tpl_show_notice">
    <%if data%>
        <div class="fui-notice" style="background: <%style.background%>" data-speed="<%params.speed%>">
            <div class="image"><img src="<%imgsrc params.iconurl%>" onerror="this.src='<?php echo RESOURCE_ROOT;?>eshop/static/images/default/hotdot.jpg'"></div>
            <div class="icon"><i class="fa fa-bullhorn" style="color: <%style.iconcolor%>;"></i></div>
            <div class="text" style="color: <%style.color%>;">
                <ul>
                    <%each data as item%>
                        <%if params.noticedata=='0'%>
                            <li><a href="<%item.linkurl||'<?php echo create_url('mobile',array('act'=>'detail','do'=>'shop','m'=>'eshop'))?>&id='+item.id%>" class="external"><%item.title%></a></li>
                        <%/if%>
                        <%if params.noticedata=='1'%>
                            <li><a href="<%item.linkurl||'javascript:;'%>" class="external"><%item.title%></a></li>
                        <%/if%>
                    <%/each%>
                </ul>
            </div>
        </div>
    <%/if%>
</script>


<script type="text/html" id="tpl_show_richtext">
    <%if params.content%>
        <div class="diy-richtext" style="background: <%style.background%>; padding: <%style.padding%>px;">
            <%=decode(params.content)%>
         </div>
    <%/if%>
</script>


<script type="text/html" id="tpl_show_banner">
    <%if data%>
        <div class='fui-swipe'>
            <div class='fui-swipe-wrapper'>
                <%each data as item%>
                    <a class='fui-swipe-item external' href="<%item.linkurl||'javascript:;'%>"><img src="<%imgsrc item.imgurl%>" style="display: block; width: 100%; height: auto;"/></a>
                <%/each%>
            </div>
            <style>
                .fui-swipe-page .fui-swipe-bullet {background: <%style.background||'#000000'%>; opacity: <%style.opacity||'0.8'%>;}
                .fui-swipe-page .fui-swipe-bullet.active {opacity: 1;}
            </style>
            <div class='fui-swipe-page <%style.dotalign||'left'%> <%style.dotstyle||'rectangle'%>' style="padding: 0 <%style.leftright||'10'%>px; bottom: <%style.bottom||'10'%>px; "></div>
        </div>
    <%/if%>
</script>


<script type="text/html" id="tpl_show_title">
    <%if params.title%>
        <div class="fui-title" style="background: <%style.background||''%>; color: <%style.color||''%>; font-size: <%style.fontsize||'12'%>px; text-align: <%style.textalign||''%>; padding: <%style.paddingtop||'0'%>px <%style.paddingleft||'5'%>px; margin: 0;">
						<a  href="<%params.link||'javascript:;'%>" style="color: <%style.color||''%>" class="external">
                <%if params.icon%><i class="fa <%params.icon%>"></i><%/if%>
                <%params.title||'请输入标题内容'%>
            </a>
        </div> 
    <%/if%>
</script>


<script type="text/html" id="tpl_show_search">
    <form action="index.php" method="get">
<input type="hidden" name="mod" value="mobile">
            <input type="hidden" name="do" value="goods">
            <input type="hidden" name="act" value="index">
                 <input type="hidden" name="m" value="eshop">
        <div class="fui-searchbar bar" style="z-index: 0;">
            <div class="searchbar" style="background: <%style.background%>; padding: <%style.paddingtop||'10'%>px <%style.paddingleft||'10'%>px;">
                <input type="submit" class="searchbar-cancel searchbtn" value="搜索" />
                <div class="search-input <%style.searchstyle%>" style="background: <%style.inputbackground||'#fff'%>;">
                    <i class="fa fa-search" style="color: <%style.iconcolor%>;"></i>
                    <input type="search" placeholder="<%params.placeholder%>" class="search" name="keywords" style="text-align: <%style.textalign%>; color: <%style.color%>; background: none;" />
                </div>
            </div>
        </div>
    </form>
</script>


<script type="text/html" id="tpl_show_line">
    <div class="fui-line-diy" style="background: <%style.background%>; padding: <%style.padding%>px 0;">
        <div class="line" style="border-top: <%style.height||'2'%>px <%style.linestyle||'solid'%> <%style.bordercolor||'#000000'%>"></div>
    </div>
</script>


<script type="text/html" id="tpl_show_blank">
    <div class="fui-blank" style="height: <%style.height%>px; background: <%style.background%>;"></div>
</script>


<script type="text/html" id="tpl_show_menu">
    <%if data%>
        <div class="fui-icon-group noborder col-<%style.rownum%> <%style.navstyle%>" style="background: <%style.background||'#ffffff'%>">
            <%each data as item%>
            <a class="fui-icon-col external" href="<%item.linkurl||'javascript:;'%>">
                <div class="icon" ><img  src="<%imgsrc item.imgurl%>"></div>
                <div class="text" style="color: <%item.color%>"><%item.text%></div>
            </a>
            <%/each%>
        </div>
    <%/if%>
</script>
 

<script type="text/html" id="tpl_show_picture">
    <%if data%>
        <div class="fui-picture" style="padding-bottom: <%style.paddingtop%>px; background: <%style.background%>;">
            <%each data as item%>
                <a href="<%item.linkurl||'javascript:;'%>" class="external" style="display: block; padding: <%style.paddingtop%>px <%style.paddingleft%>px;">
                    <img data-lazyloaded="true" src="<%imgsrc item.imgurl%>" />
                </a>
            <%/each%>
        </div>
    <%/if%>
</script>


<script type="text/html" id="tpl_show_picturew">
    <%if data%>
        <%if params.row=='1'%>
            <div class="fui-cube" style="background: <%style.background%>; <%if count(data)==1%>padding: <%style.paddingtop%>px <%style.paddingleft%>px;<%/if%>">
                <%if count(data)==1%>
                    <a href="<%toArray(data)[0].linkurl||'javasript:;'%>"><img data-lazyloaded="true" src="<%imgsrc(toArray(data)[0].imgurl)%>" /></a>
                <%/if%>
                <%if count(data)>1%>
                    <div class="fui-cube-left" style="padding: <%style.paddingtop%>px <%style.paddingleft%>px; padding-right: 0;">
                        <a href="<%toArray(data)[0].linkurl||'javasript:;'%>" class="external"><img data-lazyloaded="true" src="<%imgsrc(toArray(data)[0].imgurl)%>" /></a>
                    </div>
                    <div class="fui-cube-right" <%if count(data)==2%> style="padding: <%style.paddingtop%>px <%style.paddingleft%>px;"<%/if%>>
                        <%if count(data)==2%>
                            <a href="<%toArray(data)[1].linkurl||'javasript:;'%>" class="external"><img data-lazyloaded="true" src="<%imgsrc(toArray(data)[1].imgurl)%>" /></a>
                        <%/if%>
                        <%if count(data)>2%>
                            <div class="fui-cube-right1" style="padding: <%style.paddingtop%>px <%style.paddingleft%>px; padding-bottom: 0;">
                                <a href="<%toArray(data)[1].linkurl||'javasript:;'%>" class="external"><img data-lazyloaded="true" src="<%imgsrc(toArray(data)[1].imgurl)%>" /></a>
                            </div>
                            <div class="fui-cube-right2" <%if count(data)==3%> style="padding: <%style.paddingtop%>px <%style.paddingleft%>px;"<%/if%>>
                                <%if count(data)==3%>
                                    <a href="<%toArray(data)[2].linkurl||'javasript:;'%>" class="external"><img data-lazyloaded="true" src="<%imgsrc(toArray(data)[2].imgurl)%>" /></a>
                                <%/if%>
                                <%if count(data)>3%>
                                    <div class="left" style="padding: <%style.paddingtop%>px <%style.paddingleft%>px; padding-right: 0;">
                                        <a href="<%toArray(data)[2].linkurl||'javasript:;'%>" class="external"><img data-lazyloaded="true" src="<%imgsrc(toArray(data)[2].imgurl)%>" /></a>
                                    </div>
                                <%/if%>
                                <%if count(data)==4%>
                                    <div class="right" style="padding: <%style.paddingtop%>px <%style.paddingleft%>px;">
                                        <a href="<%toArray(data)[3].linkurl||'javasript:;'%>" class="external"><img data-lazyloaded="true" src="<%imgsrc(toArray(data)[3].imgurl)%>" /></a>
                                    </div>
                                <%/if%>
                            </div>
                        <%/if%>
                    </div>
                <%/if%>
            </div>
        <%/if%>
        <%if params.row>1%>
            <div class="fui-picturew row-<%params.row%>" style="padding: <%style.paddingleft%>px; background: <%style.background%>;">
                <%each data as item%>
                <div class="item" style="padding: <%style.paddingtop%>px <%style.paddingleft%>px;">
                    <a href="<%item.linkurl||'javasript:;'%>" class="external"><img data-lazyloaded="true" src="<%imgsrc item.imgurl%>"></a>
                </div>
                <%/each%>
            </div>
        <%/if%>
    <%/if%>
</script>


<script type="text/html" id="tpl_show_goods">
    <%if data%>
        <div class="fui-goods-group <%style.liststyle%>">
            <%each data as item%>
                <a class="fui-goods-item external" data-goodsid="<%item.gid%>" href="<?php echo create_url('mobile',array('act'=>'detail','do'=>'shop','m'=>'eshop'))?>&id=<%item.gid%>">
                 
                
                    
                    
                    <div class="image" data-lazyloaded="true" style="background-image: url(&quot;<%imgsrc item.thumb%>&quot;);">
                        <%if (params.showicon=='1' || params.showicon=='2')%>
                            <div class="goodsicon <%params.iconposition%>"
                                <%if params.iconposition=='left top'%> style="top: <%style.iconpaddingtop%>px; left: <%style.iconpaddingleft%>px; text-align: left;"<%/if%>
                                <%if params.iconposition=='right top'%> style="top: <%style.iconpaddingtop%>px; right: <%style.iconpaddingleft%>px; text-align: right;"<%/if%>
                                <%if params.iconposition=='left bottom'%> style="bottom: <%style.iconpaddingtop%>px; left: <%style.iconpaddingleft%>px; text-align: left;"<%/if%>
                                <%if params.iconposition=='right bottom'%> style="bottom: <%style.iconpaddingtop%>px; right: <%style.iconpaddingleft%>px; text-align: right;"<%/if%>
                             >
                                <%if params.showicon=='1'%>
                                    <img src="<?php echo RESOURCE_ROOT;?>eshop/static/images/default/goodsicon-<%style.goodsicon%>.png" style="width: <%style.iconzoom||'100'%>%;" />
                                <%/if%>

                                <%if params.showicon=='2' && params.goodsiconsrc%>
                                    <img src="<%imgsrc params.goodsiconsrc%>" onerror="this.src=''" style="width: <%style.iconzoom||'100'%>%;" />
                                <%/if%>

                            </div>
                        <%/if%>
                    </div>
                    <%if params.showtitle==1 || params.showprice==1%>
                        <div class="detail">
                            <%if params.showtitle=='1'%>
                                <div class="name" style="color: <%style.titlecolor%>;"><%item.title%></div>
                            <%/if%>
                            <%if params.showprice=='1'%>
                                <div class="price">
                                    <span class="text" style="color: <%style.pricecolor%>;">￥<%item.price%></span>
                                    <%if style.buystyle!=''%>
                                        <%if style.buystyle=='buybtn-1'%>
                                            <span class="buy" style="background-color: <%style.buybtncolor%>;"><i class="fa fa-shopping-cart"></i></span>
                                        <%/if%>
                                        <%if style.buystyle=='buybtn-2'%>
                                            <span class="buy" style="background-color: <%style.buybtncolor%>;"><i class="fa fa-plus"></i></span>
                                        <%/if%>
                                        <%if style.buystyle=='buybtn-3'%>
                                            <span class="buy buybtn-3" style="background-color: <%style.buybtncolor%>;">购买</span>
                                        <%/if%>
                                    <%/if%>
                                </div>
                            <%/if%>
                        </div>
                    <%/if%>
                </a>
            <%/each%>
        </div>
    <%/if%>
</script>



    <script language="javascript">
        require(['<?php echo RESOURCE_ROOT;?>eshop/static/js/mobile.js'], function(modal){
            modal.init({diypage: {"id":"<?php echo $diypage['id']?>","type":"2","name":"<?php echo $diypage['pagename']?>","data":<?php echo $diypage['datas'];?>,"createtime":"<?php echo time();?>","lastedittime":"<?php echo time();?>","keyword":"","diymenu":"-1"}, attachurl: ""});
        });
    </script>
<script language="javascript">require(['init']);</script>
</div>


</div>


<?php include page('footer_menu');?>
<?php include page('footer_base');?>