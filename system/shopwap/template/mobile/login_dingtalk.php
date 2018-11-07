<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page('header_base');?>
<title>钉钉快捷登陆</title>
<link rel="stylesheet" type="text/css" href="<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/css/style.css">
<style type="text/css">
    body {margin:0px; background:#efefef; font-family:'微软雅黑'; -moz-appearance:none;}
    .info_main {height:auto;  background:#fff; margin-top:14px; border-bottom:1px solid #e8e8e8; border-top:1px solid #e8e8e8;}
    .info_main .line {margin:0 10px; height:40px; border-bottom:1px solid #e8e8e8; line-height:40px; color:#999;}
    .info_main .line .title {height:40px; width:80px; line-height:40px; color:#444; float:left; font-size:16px;}
    .info_main .line .info { width:100%;float:right;margin-left:-80px; }
    .info_main .line .inner { margin-left:80px; }
    .info_main .line .inner input {height:40px; width:100%;display:block; padding:0px; margin:0px; border:0px; float:left; font-size:16px;}
    .info_main .line .inner .user_sex {line-height:40px;}
    .info_sub {cursor: pointer;	height:44px; margin:14px 5px; background:#31cd00; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
    .select { border:1px solid #ccc;height:25px;}
    	.balance_sub0, .balance_sub1 {height:40px; margin:10px 5px; background:#31cd00; border-radius:3px; text-align:center; font-size:14px; line-height:40px; color:#fff;}
	.balance_sub2 {height:40px; margin:10px 5px; background:#f49c06; border-radius:3px; text-align:center; font-size:14px; line-height:40px; color:#fff;}
	.balance_sub3 {height:40px; margin:10px 5px;background:#e2cb04; border-radius:3px; text-align:center; font-size:14px; line-height:40px; color:#fff;}

</style>
	
<script language="javascript" src="http://g.alicdn.com/dingding/open-develop/0.8.4/dingtalk.js"></script>

				<form  method="post" >
    <div class="page_topbar" style="background: #008cd7;"  >
     <a href="<?php echo create_url('mobile',array('act' => 'center','do' => 'member','m'=>'eshop'));?>" class="back"  style="color: #fff;text-align:center;"><i class="fa fa-angle-left"></i></a>
    <div class="title" style="color: #fff;text-align:center;">钉钉快捷登陆</div>
</div>
 
    <div style="text-align:center;">
    	<div style="height: 30px;">
                    </div>
  <img src="<?php echo RESOURCE_ROOT;?>public/image/dingtalk.png" style="width: 25%;vertical-align: middle;">
 
    </div>
    <div style="height: 40px;">
                    </div>
        <div style="text-align: -webkit-center;">
 </div>
                      <div style="height: 12px;">
                        </div>
     <div style="text-align:center;">
    	<?php if($isregister){?>
    	<a  style="font-size:16px;color: #939393;" href="<?php echo create_url('mobile',array('act' => 'shopwap','do' => 'register','op'=>'account'));?>">账户注册</a>
 
    	<?php }else{?>
  <a  style="font-size:16px;color: blue;" href="<?php echo create_url('mobile',array('act' => 'shopwap','do' => 'login','op'=>'account'));?>">账户登录</a>
 <?php } ?>
    </div>
        <button type="submit" id='submit'  name="submit" value="yes" style="display:none" >x</button>
    	</form>
<script>
	
	dd.config({
    agentId: '<?php echo $dingtalk_config['agentId'];?>', // 必填，微应用ID
    corpId: '<?php echo $dingtalk_config['corpId'];?>',//必填，企业ID
    timeStamp: <?php echo $dingtalk_config['timeStamp'];?>, // 必填，生成签名的时间戳
    nonceStr: '<?php echo $dingtalk_config['nonceStr'];?>', // 必填，生成签名的随机串
    signature: '<?php echo $dingtalk_config['signature'];?>', // 必填，签名
    type:0,   //选填。0表示微应用的jsapi,1表示服务窗的jsapi。不填默认为0。该参数从dingtalk.js的0.8.3版本开始支持
    jsApiList : [ 'runtime.info', 'biz.contact.choose',
        'device.notification.confirm', 'device.notification.alert',
        'device.notification.prompt', 'biz.ding.post',
        'biz.util.openLink','runtime.permission.requestJsApis' ] // 必填，需要使用的jsapi列表，注意：不要带dd。
});
dd.error(function(error){
       /**
        {
           message:"错误信息",//message信息会展示出钉钉服务端生成签名使用的参数，请和您生成签名的参数作对比，找出错误的参数
           errorCode:"错误码"JSON.stringify(err)
        }
       **/
       alert(error);
});
dd.ready(function() {
dd.runtime.permission.requestAuthCode({
    corpId: "<?php echo $dingtalk_config['corpId'];?>",
    onSuccess: function(result) {
    	location.href='<?php echo create_url('mobile',array('act' => 'dingtalk','do' => 'fastlogin'));?>&code='+result['code'];
    /*{
        code: 'hYLK98jkf0m' //string authCode
    }*/
    },
    onFail : function(err) {alert(err);}
 
});
});
	</script>
<?php  $show_footer=false;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>