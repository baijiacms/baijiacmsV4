<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page('header_base');?>
<?php include page('header_plus');?>
<title>订单核销</title>
<style type="text/css">
    body {<?php if(is_mobile()){?>margin:0px;<?php }?>background:#efefef; font-family:'微软雅黑'; -moz-appearance:none;}
    .info_main {height:auto;  background:#fff; margin-top:14px; border-bottom:1px solid #e8e8e8; border-top:1px solid #e8e8e8;}
    .info_main .line {margin:0 10px; height:40px; border-bottom:1px solid #e8e8e8; line-height:40px; color:#999;}
    .info_main .line .title {height:40px; width:80px; line-height:40px; color:#444; float:left; font-size:16px;}
    .info_main .line .info { width:100%;float:right;margin-left:-80px; }
    .info_main .line .inner { margin-left:80px; }
    .info_main .line .inner input {height:40px; width:100%;display:block; padding:0px; margin:0px; border:0px; float:left; font-size:16px;}
    .info_main .line .inner .user_sex {line-height:40px;}
    .info_sub {height:44px; margin:14px 5px; background:#31cd00; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
    .select { border:1px solid #ccc;height:25px;}
</style>
<script src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/mobiscroll/mobiscroll.core-2.5.2.js" type="text/javascript"></script>
<script src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/mobiscroll/mobiscroll.core-2.5.2-zh.js" type="text/javascript"></script>
<link href="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/mobiscroll/mobiscroll.core-2.5.2.css" rel="stylesheet" type="text/css" />
<link href="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/mobiscroll/mobiscroll.animation-2.5.2.css" rel="stylesheet" type="text/css" />
<script src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/mobiscroll/mobiscroll.datetime-2.5.1.js" type="text/javascript"></script>
<script src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/mobiscroll/mobiscroll.datetime-2.5.1-zh.js" type="text/javascript"></script>
<script src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/mobiscroll/mobiscroll.android-ics-2.5.2.js" type="text/javascript"></script>
<link href="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/mobiscroll/mobiscroll.android-ics-2.5.2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/area/cascade.js"></script>
<div id="container"></div>
<script id="order_info" type="text/html">
    <div class="page_topbar">
    <div class="title">订单核销 </div>
</div>
    <div class="info_main">
        <div class="line"><div class="title">订单编号</div><div class='info'><div class='inner'><input type="text" id='orderno' placeholder="请输入核销订单编号"  value="" /></div></div></div>
     
    </div>
    <div class="info_sub">确认核销</div>
</script>
<script language="javascript">
  
    	       $('#container').html(tpl('order_info'));
        $('.info_sub').click(function() {
                    if($(this).attr('saving')=='1')
                    {
                        return;
                    }
                   
                       if( $('#orderno').isEmpty()){
                           tip_show('请输入核销订单编号!');
                           return;
                       }
                  
                   $(this).html('正在处理...').attr('saving',1);
                   
                    core_json("<?php echo 	create_url('mobile',array('do'=>'order','act'=>'hxorder','m'=>'eshop'))?>", {
                       'ordersn':$('#orderno').val()
                    }, function(json) {
                       
                        if(json.status==1){
                             tip_show('核销成功');
                                 location.href="<?php  echo $this->createMobileUrl('order/hxorder',array('op'=>'success'))?>";
                                 return;
                        }
                          if(json.status==-1){
                           $('.info_sub').html('确认核销').removeAttr('saving');
                            tip_show('您不是核销员不能进行核销!');
                           return;
                        }
                         if(json.status==-2){
                           $('.info_sub').html('确认核销').removeAttr('saving');
                            tip_show('订单编号错误，未找到核销订单!');
                           return;
                        }
                          if(json.status==-3){
                           $('.info_sub').html('确认核销').removeAttr('saving');
                            tip_show('订单未付款，无法核销!');
                           return;
                        }
                         if(json.status==-4){
                           $('.info_sub').html('确认核销').removeAttr('saving');
                            tip_show('核销失败！订单已完成了，不能重复核销!');
                           return;
                        }
                  
                            $('.info_sub').html('确认核销').removeAttr('saving');
                            tip_show('核销失败!');
                  

                    },true);
                });


</script>

<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>