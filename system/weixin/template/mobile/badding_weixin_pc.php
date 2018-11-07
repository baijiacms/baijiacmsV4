<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page('header_base');?>
<title>微信账户绑定</title>
<link rel="stylesheet" type="text/css" href="<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/css/style.css">

<style type="text/css">
    body {<?php if(is_mobile()){?>margin:0px;<?php }?>background:#efefef; font-family:'微软雅黑'; -moz-appearance:none;}
    .info_main {height:auto;  background:#fff; margin-top:14px; border-bottom:1px solid #e8e8e8; border-top:1px solid #e8e8e8;}
    .info_main .line {margin:0 10px; height:40px; border-bottom:1px solid #e8e8e8; line-height:40px; color:#999;}
    .info_main .line .title {height:40px; width:80px; line-height:40px; color:#444; float:left; font-size:16px;}
    .info_main .line .info { width:100%;float:right;margin-left:-80px; }
    .info_main .line .inner { margin-left:80px; }
    .info_main .line .inner input {height:40px; width:100%;display:block; padding:0px; margin:0px; border:0px; float:left; font-size:16px;}
    .info_main .line .inner .user_sex {line-height:40px;}
    .info_sub {cursor: pointer;	height:44px; margin:14px 5px; background:#31cd00; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
    .select { border:1px solid #ccc;height:25px;}
</style>
	

				<form  method="post" >
    <div class="page_topbar" style="background: #008cd7;"  >
     <a href="<?php echo create_url('mobile',array('act' => 'center','do' => 'member','m'=>'eshop'));?>" class="back"  style="color: #fff;text-align:center;"><i class="fa fa-angle-left"></i></a>
    <div class="title" style="color: #fff;text-align:center;">微信账户绑定</div>
</div>
 
    <div style="text-align:center;">
    	<div style="height: 70px;">
                    </div>
  <img src="<?php echo $qurl;?>" style="width: 25%;vertical-align: middle;">
 
    </div>
    <div style="height: 40px;">
                    </div>
        <div style="text-align: -webkit-center;">
    <div style="width: 80%; height: 2em; line-height: 2em; text-align: center; color: #55a947;
                         border: 1px solid #808080; border-radius: 1em; font-size: 18px;    margin: 0;
    padding: 0;">
                 为保障帐号安全，请用微信扫码验证身份
                      </div>  </div>
                      <div style="height: 12px;">
                        </div>
     <div style="text-align:center;">
    	
  <a  style="font-size:16px;color: #939393;" href="<?php echo create_url('mobile',array('act' => 'shopwap','do' => 'login','op'=>'account'));?>">账户登录</a>
 
    </div>
        <button type="submit" id='submit'  name="submit" value="yes" style="display:none" >x</button>
    	</form>
<script>
	    function checkstatus(){
$.get("<?php echo create_url('mobile',array('act' => 'weixin','do' => 'banding_pc','op'=>'dologincheck','skey'=>$showkey));?>", {}, function(data){
var data= eval("(" + data + ")");

  if(data.status==1)
  {
 location.href="<?php echo create_url('mobile',array('act' => 'shopwap','do' => 'account'));?>";
  }
  if(data.status==-1)
  {
  alert("登录失败！重新刷新二维码登录");	
  location.href="<?php echo create_url('mobile',array('act' => 'weixin','do' => 'fastlogin','bizstate'=>'banding_weixin'));?>";
  }
});
} 
setInterval("checkstatus()",2000);
</script>

<?php  $show_footer=false;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>