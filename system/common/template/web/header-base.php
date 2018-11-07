<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>百家CMS微商城V4</title>
	<script src="<?php  echo RESOURCE_ROOT;?>weengine/js/lib/jquery-1.11.1.min.js"></script>
	<link href="<?php  echo RESOURCE_ROOT;?>weengine/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php  echo RESOURCE_ROOT;?>weengine/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php  echo RESOURCE_ROOT;?>weengine/css/common.css?x=<?php  echo time()?>" rel="stylesheet">
		<link href="<?php  echo RESOURCE_ROOT;?>weengine/css/plus.css?x=<?php  echo time()?>" rel="stylesheet">
	<link href="<?php  echo RESOURCE_ROOT;?>weengine/css/main/main.css?x=<?php  echo time()?>" rel="stylesheet">
	<script>var require = { urlArgs: 'v=<?php  echo time()?>' };</script>
	<script>window.global_website="<?php echo WEBSITE_ROOT;?>";</script>
		<script>
			window.uploader_file_fetch="<?php echo create_url("site",array("do"=>"file","act"=>"public","op"=>"fetch"));?>";
	window.uploader_file_local="<?php echo create_url("site",array("do"=>"file","act"=>"public","op"=>"local"));?>";
		window.uploader_file_image="<?php echo create_url("site",array("do"=>"file","act"=>"public","op"=>"upload","type"=>"image"));?>";
		window.uploader_file_audio="<?php echo create_url("site",array("do"=>"file","act"=>"public","op"=>"audio"));?>";
				window.uploader_file_delete="<?php echo create_url("site",array("do"=>"file","act"=>"public","op"=>"delete"));?>";
				window.resource_url="<?php  echo RESOURCE_ROOT;?>";
				window.public_utility_link="";
					window.uploader_show_all_url=false;
						window.public_utility_pageLink="";
						window.public_utility_newsLink="";
						window.public_utility_articleLink="";
						window.public_utility_phoneLink="";
						window.public_utility_moduleLink="";
							window.public_utility_selectIcon="<?php echo create_url("site",array("do"=>"icon","act"=>"utility"));?>";
							window.public_utility_selectEmojiComplete="<?php echo create_url("site",array("do"=>"emoji","act"=>"utility"));?>";
							window.public_utility_selectEmoji=window.public_utility_selectEmojiComplete;
		</script>
	<script src="<?php  echo RESOURCE_ROOT;?>weengine/js/app/util.js"></script>
	<script src="<?php  echo RESOURCE_ROOT;?>weengine/js/require.js"></script>
	<script src="<?php  echo RESOURCE_ROOT;?>weengine/js/app/config.js"></script>
	<script type="text/javascript">
	if(navigator.appName == 'Microsoft Internet Explorer'){
		if(navigator.userAgent.indexOf("MSIE 5.0")>0 || navigator.userAgent.indexOf("MSIE 6.0")>0 || navigator.userAgent.indexOf("MSIE 7.0")>0) {
			alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
		}
	}
	
	window.sysinfo = {
<?php  if(!empty($_W['uniacid'])) { ?>
		'uniacid': '<?php  echo $_W['uniacid'];?>',
<?php  } ?>
<?php  if(!empty($_W['acid'])) { ?>
		'acid': '<?php  echo $_W['acid'];?>',
<?php  } ?>
<?php  if(!empty($_W['openid'])) { ?>
		'openid': '<?php  echo $_W['openid'];?>',
<?php  } ?>
<?php  if(!empty($_W['uid'])) { ?>
		'uid': '<?php  echo $_W['uid'];?>',
<?php  } ?>
		'siteroot': '<?php  echo $_W['siteroot'];?>',
		'siteurl': '<?php  echo $_W['siteurl'];?>',
		'attachurl': '<?php  echo $_W['attachurl'];?>',
		'attachurl_local': '<?php  echo $_W['attachurl_local'];?>',
		'attachurl_remote': '<?php  echo $_W['attachurl_remote'];?>',
<?php  if(defined('MODULE_URL')) { ?>
		'MODULE_URL': '<?php echo MODULE_URL;?>',
<?php  } ?>
		'cookie' : {'pre': '<?php  echo $_W['config']['cookie']['pre'];?>'}
	};
	</script>
</head>
<body>

<div class="main_header">
	<div class="main_logo">
		<a href=""
			title=""><img src="<?php  echo RESOURCE_ROOT;?>weengine/css/main/logow.png" alt=""></a>
	</div>
	<div class="main_nav_cont">

		<ul  class="main_nav">
			
			<?php $menuindex=0;?>
            	
    <li  <?php  if(($_GPC['do'] == 'virtual')||($_GPC['do'] == 'verify')||($_GPC['act'] == 'article')  ||($_GPC['do'] == 'designer')||($_GPC['do'] == 'shop'&&($_GPC['act'] == 'index'||$_GPC['act'] == 'goods'||$_GPC['act'] == 'comment'||$_GPC['act'] == 'category'||$_GPC['act'] == 'notice')) ) { $menuindex='goods';  } ?>>
            		<a href="<?php  echo create_url('site',array('act' => 'index','do' => 'shop','m' => 'eshop'))?>">商城管理</a></li>  
            	
            	
            	 	
            	 	          <li <?php  if($_GPC['do'] == 'order') { $menuindex='order';  } ?>">
            		<a href="<?php  echo create_url('site',array('act' => 'list','do' => 'order','m' => 'eshop','op' => 'display'))?>">订单管理</a></li>      
            	 	
     
     
           <li <?php  if(($_GPC['do'] == 'finance'||$_GPC['do'] == 'member') ||($_GPC['do'] == 'sale') ||($_GPC['do'] == 'coupon')) { $menuindex='member_finance';  } ?>">
            		<a href="<?php  echo create_url('site',array('act' => 'list','do' => 'member','m' => 'eshop'))?>">会员与财务</a></li> 
          
  					<li <?php  if($_GPC['do'] == 'statistics') { $menuindex='statistics';  } ?>">
            		<a href="<?php  echo create_url('site',array('act' => 'sale','do' => 'statistics','m' => 'eshop'))?>">数据统计</a></li> 
            			
            			
            			
            			   <li <?php  if($_GPC['do'] == 'commission'|| $_GPC['do'] == 'poster'||$_GPC['act'] == 'dingtalk') {  $menuindex='commission';  } ?>">
            		<a href="<?php  echo create_url('site',array('do' => 'commission','m' => 'eshop','act'=>'agent'))?>">分销</a></li>   

            			   <li <?php  if(($_GPC['act'] == 'entry'&&$_GPC['do'] == 'reply')||$_GPC['act'] == 'weixin'||$_GPC['act'] == 'qq') { ?><?php   $menuindex='entry';  } ?>">
            		<a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'reply','rtype'=>'basic'))?>">第三方接入</a></li>   
<?php $addonscount=mysqld_selectcolumn("select count(name) from ".table('modules')." where isdisable=0");if($addonscount>0){?>
   <li <?php  if($GLOBALS['_CMS']['isaddons']) { ?><?php   $menuindex='addons';  } ?>">
            		<a href="<?php  echo create_url('site',array('act' => 'public','do' => 'isaddons'))?>">扩展模块</a></li>
          <?php } ?>  	
            			
            			<li <?php  if(($_GPC['act'] == 'entry'&&$_GPC['do'] != 'reply')||($_GPC['do'] == 'shop'&&($_GPC['act'] == 'dispatch'))||$_GPC['do'] == 'sysset'||$_GPC['act'] == 'modules') { $menuindex='sysset';   } ?>">
            		<a href="<?php  echo create_url('site',array('act' => 'sysset','do' => 'sysset','m' => 'eshop','op'=>'shop'))?>">商城设置</a></li>    
            			 
			
		</ul>

		<div class="main_login">
			<span  class="main_change_link" style="color: #FFF"><?php echo $GLOBALS['_CMS'][WEB_SESSION_ACCOUNT]['username'];?></span>
		
<ul  class="main_nav_right">
	<li><i class="nav-first-i"></i> <a target="_blank" href="<?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'shopindex'))?>" >商城首页</a><i></i>
			</li>
		<li><i class="nav-first-i"></i> <a href="<?php  echo create_url('site',array('act' => 'public','do' => 'changepwd','store'=>'1'))?>" >修改密码</a><i></i>
			</li>
		<li><i class="nav-first-i"></i> <a href="<?php  echo create_url('mobile',array('act' => 'public','do' => 'logout'))?>">退出系统</a> <i></i>
			</li>
		</ul>
             
		</div>

	</div>

</div>

<!--[if lte IE 7]><div class="ietip ietipbg"></div><div  class="ietip ietiptext">您的浏览器太旧了，为了获得更好的体验，请升级您的浏览器！</div><![endif]-->
<div class="main_wrap" >
		<div class="main_wrap-bg">
<?php  if(empty($noleft)&&!empty($menuindex)){?>
			<div class="main_sidebar">
				<div class="main_subnav" >
					
				
	
    	<?php include page('menu/'.$menuindex.'_menu');?> 



				</div>
			</div><?php  } ?>
			<div id="main_tgy" class="main_tgy"  style="<?php  if(!empty($noleft)||empty($menuindex)){?>margin-left: 0px;<?php  } ?>">
				<?php  if(empty($noleft)&&!empty($menuindex)){?>
	<a  id="main_celan" class="main_celan" title="关闭侧栏"></a>
	
	<?php  } ?>
	
<script>
	$("#main_celan").click(function(){
if($(this).hasClass("main_celan main_celanon")){
$('.main_sidebar').animate({marginLeft:"0px"});
$('#main_tgy').animate({marginLeft:"200px"});
$('#main_celan').removeClass('main_celanon');
$.cookie("celan",null)}else{$('.main_sidebar').animate({marginLeft:"-210px"});
$('#main_tgy').animate({marginLeft:"0px"});
$('#main_celan').addClass('main_celanon');
$.cookie("celan","1",{expires:7})}
});
	</script>
	
	
	
	<script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>weengine/js/lib/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/jquery.gcjs.js"></script>
<script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/jquery.form.js"></script>
<script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/tooltipbox.js"></script>
<style type="text/css">
.red {float:left;color:red}
.white{float:left;color:#fff}

.tooltipbox {
	background:#fef8dd;border:1px solid #c40808; position:absolute; left:0;top:0; text-align:center;height:20px;
	color:#c40808;padding:2px 5px 1px 5px; border-radius:3px;z-index:1000;
}
.red { float:left;color:red}
</style> 
<script language='javascript'>
    function preview_html(txt)
{
var win = window.open("", "win", "width=300,height=600"); // a window object
win.document.open("text/html", "replace");
win.document.write($(txt).val());
win.document.close();
}
</script>