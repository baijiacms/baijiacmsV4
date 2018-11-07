<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>百家CMS微商城V4</title>
	<link href="<?php  echo RESOURCE_ROOT;?>weengine/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php  echo RESOURCE_ROOT;?>weengine/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?php  echo RESOURCE_ROOT;?>weengine/css/common.css?x=<?php  echo time()?>" rel="stylesheet">
		<link href="<?php  echo RESOURCE_ROOT;?>weengine/css/plus.css?x=<?php  echo time()?>" rel="stylesheet">
	<link href="<?php  echo RESOURCE_ROOT;?>weengine/css/main/main.css?x=<?php  echo time()?>" rel="stylesheet">
	<script>var require = { urlArgs: 'v=<?php  echo date('YmdH');?>' };</script>
		<script>window.global_website="<?php echo WEBSITE_ROOT;?>";</script>
	<script src="<?php  echo RESOURCE_ROOT;?>weengine/js/lib/jquery-1.11.1.min.js"></script>
	<script src="<?php  echo RESOURCE_ROOT;?>weengine/js/lib/bootstrap.min.js"></script>
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
	window.uploader_file_fetch="<?php echo create_url("mobile",array("do"=>"file","act"=>"public","op"=>"fetch"));?>";
	window.uploader_file_local="<?php echo create_url("mobile",array("do"=>"file","act"=>"public","op"=>"local"));?>";
		window.uploader_file_image="<?php echo create_url("mobile",array("do"=>"file","act"=>"public","op"=>"upload","type"=>"image"));?>";
		window.uploader_file_audio="<?php echo create_url("mobile",array("do"=>"file","act"=>"public","op"=>"audio"));?>";
				window.uploader_file_delete="<?php echo create_url("mobile",array("do"=>"file","act"=>"public","op"=>"delete"));?>";
				window.resource_url="<?php  echo RESOURCE_ROOT;?>";
				window.public_utility_link="";
						window.public_utility_pageLink="";
						window.public_utility_newsLink="";
						window.public_utility_articleLink="";
						window.public_utility_phoneLink="";
						window.public_utility_moduleLink="";
							window.public_utility_selectIcon="<?php echo create_url("site",array("do"=>"icon","act"=>"utility"));?>";
							window.public_utility_selectEmojiComplete="<?php echo create_url("site",array("do"=>"emoji","act"=>"utility"));?>";
	</script>
</head>
<body>
	
<div class="main_header">
	<div class="main_logo">
		<a href=""><img src="<?php  echo RESOURCE_ROOT;?>weengine/css/main/logow.png"></a>
	</div>
	<div class="main_nav_cont">

		<ul  class="main_nav">
			
			<!-- <li >	<a href="<?php  echo create_url('site',array('act' => 'manager','do' => 'store','op'=>'display'))?>">系统管理</a></li>  -->
            	
    
			
		</ul>

		<div class="main_login">
			<span  class="main_change_link" style="color: #FFF">您好，<?php echo $GLOBALS['_CMS'][WEB_SESSION_ACCOUNT]['username'];?></span>
		
<ul  class="main_nav_right">
		<li><i class="nav-first-i"></i> <a href="http://www.baijiacms.com/" target="_blank">官方首页</a> <i></i>
			</li>	<li><i class="nav-first-i"></i> <a href="<?php  echo create_url('site',array('act' => 'manager','do' => 'changepwd'))?>">修改密码</a> <i></i>
			</li>
		<li><i class="nav-first-i"></i> <a href="<?php  echo create_url('mobile',array('act' => 'public','do' => 'logout'))?>">退出系统</a> <i></i>
			</li>
		</ul>
	<span  class="main_change_link" >&nbsp;</span>
             
		</div>

	</div>

</div>

<!--[if lte IE 7]><div class="ietip ietipbg"></div><div  class="ietip ietiptext">您的浏览器太旧了，为了获得更好的体验，请升级您的浏览器！</div><![endif]-->
<div class="main_wrap" >
		<div class="main_wrap-bg">

			<div class="main_sidebar">
				<div class="main_subnav" >
					
					<?php include page('system_menu/system');?> 
					



				</div>
			</div>
			<div id="main_tgy" class="main_tgy" >
	<a  id="main_celan" class="main_celan" title="关闭侧栏"></a>
	
	

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