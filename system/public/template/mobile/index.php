<?php defined('SYSTEM_IN') or exit('Access Denied');?><!DOCTYPE html><!DOCTYPE html>
<html >
<head>
	<title>百家CMS微商城V4</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
	<title><?php  echo empty($settings['shop_title'])?'':$settings['shop_title'];?></title>
<meta name="description" content="<?php  echo empty($settings['shop_description'])?'':$settings['shop_description'];?>" />
<meta name="keywords" content="<?php  echo empty($settings['shop_keyword'])?'':$settings['shop_keyword'];?>">
	<link href="<?php echo RESOURCE_ROOT;?>weengine/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo RESOURCE_ROOT;?>weengine/css/bootstrap.min.css">
	  <link href="<?php echo RESOURCE_ROOT;?>public/login/style.css" rel="stylesheet" type="text/css" />
		<script src="<?php echo RESOURCE_ROOT;?>weengine/js/lib/jquery-1.11.1.min.js"></script>

     <style type="text/css">
    .code
    {
           
            font-family:Arial;
            font-style:italic;
             color:blue;
             font-size:20px;
             border:0;
             padding:2px 3px;
             letter-spacing:3px;
             font-weight:bolder;             
             float:left;            
             cursor:pointer;
             width: 256px;
                 height: 55px;
             line-height:55px;
             text-align:center;
             vertical-align:middle;

    }
  
    </style>

	<script type="text/javascript">
	if(navigator.appName == 'Microsoft Internet Explorer'){
		if(navigator.userAgent.indexOf("MSIE 5.0")>0 || navigator.userAgent.indexOf("MSIE 6.0")>0 || navigator.userAgent.indexOf("MSIE 7.0")>0) {
			alert('您使用的 IE 浏览器版本过低, 推荐使用 Chrome 浏览器或 IE8 及以上版本浏览器.');
		}
	}
	</script>

</head>
<body>
	
	
<body class="" >
<?php if(false){?>
<div id="header">
    <div class="clearfix container">
        <h2 id="logo">
           <span>百家威信</span>
        </h2>
      


    </div>

</div>
<?php }?>
<div id="PageLogin" class="clearfix container">
    <div class="tour">
       <!-- <h2>百家cms</h2>-->
        <div class="airdroid-tour">
            <div class="tour-container">
                <div class="tour1">
                    <h4>能事/services</h4>
                    <p>以“整合升级”为服务核心，以“力挺新鲜”为实践信仰，塑造内涵，传递价值，百家威信，极尽品牌创新与提升之能事。</p>
                 </div>
            </div>
            <div class="tour-container">
                <div class="tour2">
                   <h4>我们/us</h4>
                    <p>和多数人一样，怀揣改变世界的梦想；和少数人一样，不为墨守成规而苟活。百家威信，无挑战，不梦想，无新鲜，不广告。</p>
                 </div>
            </div>
            <div class="tour-container last">
                <div class="tour3">
                   <h4>联系/contact</h4>
                    <p>案不在多有“鲜”则名，意不在深有“心”则灵！深入交流，我们必将为你打开一只发光的瓶子。</p>
                 </div>
            </div>
        </div>
    </div>
    <div class="loginForm">
        <div class="form">
            <h1>登录</h1>
            <span class="meta"></span>
            	<form class="form-horizontal push-5-t" target="_parent" id="login-form" onsubmit="return login();" action="<?php  echo mobile_url('login',array('act'=>'public'))?>" method="post" role="form" >
			
                <div class="row">
                   	<input  type="text" id="login1-username" name="username"  autocomplete="off" placeholder="登录账号">
                </div>
                <div class="row">
                   <input  type="password" id="login1-password" name="password"  autocomplete="off"  placeholder="登录密码">
                </div>
                   <div class="row">
                <input type="text" id="inputCode"  name="verify"   autocomplete="off" placeholder="验证码">
                </div>
                 <div class="row" style="height: 70px">
                 <img class="code"  id="verifyimg" onClick="fleshVerify()"  alt="点击切换" src="<?php  echo mobile_url('verify',array('act'=>'public'))?>" style="cursor:pointer;"/>
		</div>
                
                <div class="row submit">
                    	<input class="signBtn" type="submit" name="submit" value="登 录" >
                </div>
         
            </form>
          
        </div>
    </div>
</div>
<script>
	function login()
		{
		
		var pw = document.getElementById("login1-password");
		var idname = document.getElementById("login1-username");
		var inputCode = document.getElementById("inputCode");
		if(idname.value == "") {
			alert("请输入用户名");
			return false;
		}
		if (pw.value == "" ){
			alert("请输入密码");
			return false;
		}	
			if(inputCode.value == "") {
			alert("请输入验证码");
			return false;
		}
			return true;
		}
	function fleshVerify(){
	var verifyimg = $("#verifyimg").attr("src");
	if( verifyimg.indexOf('?')>0){
                    $("#verifyimg").attr("src", verifyimg+'&random='+Math.random());
                }else{
                    $("#verifyimg").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
                }
	}
</script>





<div id="footer">

 
   <p >&copy; Copyright 2016 福州百家威信信息技术有限责任公司 Rights Reserved</p>
</div>
</body>
</html>