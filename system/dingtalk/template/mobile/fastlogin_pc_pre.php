<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page('header_base');?>
<title>钉钉账户登录</title>
<link href="<?php echo RESOURCE_ROOT;?>public/weui.min.css" rel="stylesheet">
<link href="<?php echo RESOURCE_ROOT;?>public/weui.plus.css?v=2" rel="stylesheet">
<style>
	.weui-grid:before {
    border-right: 0px solid #d9d9d9;
      border-bottom: 0px solid #d9d9d9;
}	.weui-grid:after {
    border-right: 0px solid #d9d9d9;
      border-bottom: 0px solid #d9d9d9;
}
	</style>
<form  method="post" >
	   
<div class="weui-cells_form" style="  margin-bottom:50px;   border-bottom: 0px solid #FFF;   margin-top: 0;">




 <div class="icon-box" style="text-align:center;margin-top:50px;">
            <i class="weui-icon-waiting weui-icon_msg"></i>
            <div class="icon-box__ctn">
                <h3 class="icon-box__title">&nbsp;</h3>
                <p class="icon-box__desc">正在使用钉钉登陆系统...</p>
            </div>
        </div>
            
          
       

</form>

<script language="javascript" src="http://g.alicdn.com/dingding/open-develop/0.8.4/dingtalk.js"></script>

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
       alert(JSON.stringify(error));
});
dd.ready(function() {
dd.runtime.permission.requestAuthCode({
    corpId: "<?php echo $dingtalk_config['corpId'];?>",
    onSuccess: function(result) {
    	location.href='<?php echo create_url('mobile',array('act' => 'dingtalk','do' => 'fastlogin_pc','op'=>'dologin','skey'=>$_GP['skey']));?>&code='+result['code'];
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