<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page('header_base');?>
<?php include page('header_plus');?>
<title>支付订单</title>
<style type="text/css">
    body {<?php if(is_mobile()){?>margin:0px;<?php }?>background:#efefef; font-family:'微软雅黑'; -moz-appearance:none;}
.order_main {height:auto; border-bottom:1px solid #f0f0f0; border-top:1px solid #f0f0f0; background:#fff;margin-top:10px;}
.order_main .line {height:44px; margin:0 5px; border-bottom:1px solid #f0f0f0; line-height:44px;}
.order_main .line .label { float:left;width:80px;}
.order_main .line .info { float:right; width:100%; margin-left:-85px;text-align: right;overflow:hidden;height:44px;}
.order_main .line .info .inner { color:#666;margin-left:85px;}
.order_main .tip { color:#666; line-height:20px;padding:5px;font-size:13px; }
 
  .order_main .line .nav {height:22px; width:40px; background:#ccc; margin:10px 0px; float:right; border-radius:40px;}
.order_main .line .on {background:#4ad966;}
.order_main .line .nav nav {height:20px; width:20px; background:#fff; margin:1px; border-radius:20px;}
.order_main .line .nav .on {margin-left:19px;}

.order_sub1 {height:44px; margin:14px 5px; background:#31cd00; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
.order_sub2 {height:44px; margin:14px 5px; background:#f49c06; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
.order_sub3 {height:44px; margin:14px 5px;background:#e2cb04; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
.order_sub4 {height:44px; margin:14px 5px; background:#18c0f7; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}

.order_main1 {height:30px;padding:10px;border-bottom:1px solid #f0f0f0; border-top:1px solid #f0f0f0; background:#fff;text-align:center;margin-top:10px; }
.order_sub5 {height:30px; width:35%;padding:5px 10px 5px 10px; border:1px solid #ccc; border-radius:4px; text-align:center; font-size:16px; line-height:30px; color:#333; }
.order_sub6 {height:44px; margin:14px 5px; background:#07c4d0; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}

.order_sub7 {height:44px; margin:14px 5px; background:#008cd7; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}
</style>

<div id='container'></div>
<script id='tpl_order_info' type='text/html'>
    <input type='hidden' id='orderid' value="<%order.id%>"/>
       <div class="page_topbar">
        <a href="javascript:;" class="back" onclick="history.back()"><i class="fa fa-angle-left"></i></a>
        <div class="title">支付订单</div>
    </div>
    <div class="order_main" >  
        <div class="line"><div class="label">订单编号</div><div class="info"><div class="inner"><%order.ordersn%></div></div></div>
        <div class="line"><div class="label">支付金额</div><div class="info"><div class="inner"><div style='color:#ff6600'>￥<span id="orderprice" price="<%order.price%>"><%order.price%></span>元</div></div></div></div>
    </div>
    <%if order.price>0%>    
    <%if wechat.success%><div class="button order_sub1">微信支付</div><%/if%>
    <%if alipay.success%><div class="button order_sub2" >支付宝支付</div><%/if%>
    
    <%if credit.success %>
        <div class="button order_sub3">余额支付(当前余额:<%credit.current%>)</div>
        <input type="hidden" id="credit" value="<%credit.current%>" />
        <%if credit.current<=0%>
        <div class="button order_sub4" onclick="location.href='<?php  echo $this->createMobileUrl('member/recharge')?>&returnurl=<%returnurl%>'">账户充值</div>
        <%/if%>  
    <%/if%>
    
    <%/if%>
    
    <%if cash.success%><div class="button order_sub6" >货到付款</div><%/if%>
    <%if unionpay.success%><div class="button order_sub7" >银联支付</div><%/if%>
</script>

<script id='tpl_order_pay' type='text/html'>
       <div class="page_topbar">
            <div class="title">支付成功</div>
        </div>
    <%if address%>
        <img src="<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/pay_ok.png" style="width:100%;" />
     <%/if%>
     <%if order.dispatchtype=='1' && order.isverify!='1'%>
        <img src="<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/pay_carrier.png" style="width:100%;" />
     <%/if%>
     <%if order.isverify=='1'%>
        <img src="<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/pay_verify.png" style="width:100%;" />
     <%/if%>
     <%if order.virtual!='0'%>
        <img src="<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/pay_virtual.png" style="width:100%;" />
     <%/if%>
	 <%if order.isvirtual=='1'%>
        <img src="<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/pay_success.png?v=1" style="width:100%;" />
     <%/if%>
    <div class="order_main" >
        <%if address%>
        <div class="line"><div class="label">收货人</div><div class="info"><div class='inner'><%address.realname%> <%address.mobile%></div></div></div>
        <div class="line"><div class="label">收货地址</div><div class="info"><div class='inner'><%address.address%></div></div></div>
        <%/if%>
        <%if carrier%>
         <%if order.isverify=='1' || order.isvirtual=='1'%> 
         <div class="line"><div class="label">联系人</div><div class="info"><div class='inner'><%carrier.carrier_realname%></div></div></div>
        <div class="line"><div class="label">联系电话</div><div class="info"><div class='inner'><%carrier.carrier_mobile%></div></div></div>
         <%else%>
        <div class="line"><div class="label">自提地点</div><div class="info"><div class='inner'><%carrier.address%></div></div></div>
        <div class="line"><div class="label">自提联系人</div><div class="info"><div class='inner'><%carrier.realname%> <%carrier.mobile%></div></div></div>
        <%/if%>
        <%/if%>
        <div class="line"><div class="label">实付款</div><div class="info"><div class='inner'><span style='color:#ff6600'>￥<%order.price%>元</span></div></div></div>
         <%if order.virtual!='0'%>
         <div class="line" style='text-align:center;'>请到订单中查看物品信息</div>
         <%/if%>
    </div>
     <div class="order_main1" >
         <span class="order_sub5" onclick="location.href='<?php  echo $this->createMobileUrl('order/detail')?>&id=<%order.id%>'">订单详情</span>
         <span class="order_sub5" onclick="location.href='<?php  echo $this->createMobileUrl('shop')?>'">返回首页</span>
     </div>
</script>

<script id='tpl_order_cash' type='text/html'>
      <div class="page_topbar">
           <div class="title">订单提交成功</div>
        </div>
    <img src="<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/pay_cash.png" style="width:100%;" />
    <div class="order_main" >
        <%if address%>
        <div class="line"><div class="label">收货人</div><div class="info"><div class='inner'><%address.realname%> <%address.mobile%></div></div></div>
        <div class="line"><div class="label">收货地址</div><div class="info"><div class='inner'><%address.address%></div></div></div>
        <%/if%>
        <%if carrier%>
         <%if order.isverify=='1' || order.isvirtual=='1'%> 
         <div class="line"><div class="label">联系人</div><div class="info"><div class='inner'><%carrier.carrier_realname%></div></div></div>
        <div class="line"><div class="label">联系电话</div><div class="info"><div class='inner'><%carrier.carrier_mobile%></div></div></div>
         <%else%>
        <div class="line"><div class="label">自提地点</div><div class="info"><div class='inner'><%carrier.address%></div></div></div>
        <div class="line"><div class="label">自提联系人</div><div class="info"><div class='inner'><%carrier.realname%> <%carrier.mobile%></div></div></div>
        <%/if%>
        <%/if%>
        <div class="line"><div class="label">需到付</div><div class="info"><div class='inner'><span style='color:#ff6600'>￥<%order.price%>元</span></div></div></div>
    </div>
     <div class="order_main1" >
         <span class="order_sub5" onclick="location.href='<?php  echo $this->createMobileUrl('order/detail')?>&id=<%order.id%>'">订单详情</span>
         <span class="order_sub5" onclick="location.href='<?php  echo $this->createMobileUrl('shop')?>'">返回首页</span>
     </div>
</script>
 

<script language="javascript">

        core_json("<?php echo 	create_url('mobile',array('do'=>'order','act'=>'pay','m'=>'eshop'))?>",{orderid:'<?php  echo $_GPC['orderid'];?>',openid:"<?php  echo $openid;?>"},function(json){
            var result = json.result;
            if(json.status==-1){
            	    tip_message(json.result,"<?php echo 	create_url('mobile',array('do'=>'order','act'=>'detail','m'=>'eshop'))?>&id=<?php  echo $_GPC['orderid'];?>",'error');
                 return;
            }
            if(json.status!=1){
                 tip_message(result,"<?php  echo $this->createMobileUrl('order/detail',array('id'=>$_GPC['orderid']))?>",'error');
                 return;
            }
            $('#container').html(tpl('tpl_order_info',result));
            
           if(result.alipay.success){
 
                 $('.order_sub2').click(function(){
                     
                    core_json("<?php echo 	create_url('mobile',array('do'=>'order','act'=>'pay','m'=>'eshop','op'=>'pay'))?>", {type: 'alipay', orderid:'<?php  echo $_GPC['orderid'];?>'}, function (rjson) {
                        if(rjson.status!=1){
                            $('.button').removeAttr('submitting');
                            tip_show(rjson.result);
                            return;
                        }
                        if(rjson.status==1){
		                       location.href="<?php echo 	create_url('mobile',array('do'=>'order','act'=>'payment','m'=>'eshop','op'=>'alipay','orderid'=>$_GPC['orderid']))?>";
		                      }
                       return;
                    },true);
                 })
           }
           if(result.credit.success){
               
               $(".order_sub3").click(function(){
                 tip_confirm('确认要立即付款?',function(){
                    $('.button').attr('submitting',1);
                     core_json("<?php echo 	create_url('mobile',array('do'=>'order','act'=>'pay','m'=>'eshop','op'=>'pay'))?>", {type: 'credit', orderid:'<?php  echo $_GPC['orderid'];?>'}, function (rjson) {
                        if(rjson.status!=1){
                            $('.button').removeAttr('submitting');
                            tip_show(rjson.result);
                            return;
                        }
                        if(rjson.status==1){
		                       location.href="<?php echo 	create_url('mobile',array('do'=>'order','act'=>'payment','m'=>'eshop','op'=>'credit','orderid'=>$_GPC['orderid']))?>";
		                      }
                       return;
                    },true);
               });
                });
           }
           

           
           if(result.wechat.success){
                $('.order_sub1').click(function(){
                       core_json("<?php echo 	create_url('mobile',array('do'=>'order','act'=>'pay','m'=>'eshop','op'=>'pay'))?>", {type: 'wechat', orderid:'<?php  echo $_GPC['orderid'];?>'}, function (rjson) {
                 		    if(rjson.status!=1){
                            $('.button').removeAttr('submitting');
                            tip_show(rjson.result);
                            return;
                        }
                        if(rjson.status==1){
		                   		   location.href="<?php echo 	create_url('mobile',array('do'=>'order','act'=>'payment','m'=>'eshop','op'=>'wechat','orderid'=>$_GPC['orderid']))?>";
		                      }
                       return;
                    },true);
                 });
             }
      
      
        if(result.unionpay.success){
                $('.order_sub7').click(function(){   
                       core_json("<?php echo 	create_url('mobile',array('do'=>'order','act'=>'pay','m'=>'eshop','op'=>'pay'))?>", {type: 'unionpay', orderid:'<?php  echo $_GPC['orderid'];?>'}, function (rjson) {
                        if(rjson.status!=1){
                            tip_show(rjson.result);
                            return;
                        }
                        if(rjson.status==1){
		                        location.href="<?php echo 	create_url('mobile',array('do'=>'order','act'=>'payment','m'=>'eshop','op'=>'unionpay','orderid'=>$_GPC['orderid']))?>";
		                      }
                       return;
                    },true);
                 });
             }
        
    },false);

 
</script>

<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>