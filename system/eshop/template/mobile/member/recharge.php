<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page('header_base');?>
<?php include page('header_plus');?>
<title>账户充值</title>
<style type="text/css">
	body {<?php if(is_mobile()){?>margin:0px;<?php }?>background:#efefef; -moz-appearance:none;}
	.recharge {height:auto; border-bottom:1px solid #f0f0f0; border-top:1px solid #f0f0f0; background:#fff;margin-top:10px;}
	.recharge .line {height:44px; margin:0 5px; border-bottom:1px solid #f0f0f0; line-height:44px;}
	.recharge .line .label { float:left;width:60px; padding-left:5px; color:#333; font-size:14px;height:44px;line-height:44px;}
	.recharge .line .info { float:left; width:100%; margin-left:-65px;margin-right:-30px;text-align: left;overflow:hidden;height:44px;}
	.recharge .line .info .inner { color:#666;margin-left:70px;margin-right:30px;}
	.recharge .line input {
		width:100%; font-size:14px; color:#333; border:none;height:22px;line-height:18px;
	}
	.recharge .line .ico { float:right; width:30px; height:44px; line-height:42px;color:#ccc; font-size:14px; text-align: center;}

	#confirmdiv { position: fixed; top:0px; width:100%;background:#efefef; left:0;}
	#confirmdiv { position: fixed; top:0px; width:100%;background:#efefef; left:100%}

	.balance_sub0, .balance_sub1 {height:40px; margin:10px 5px; background:#31cd00; border-radius:3px; text-align:center; font-size:14px; line-height:40px; color:#fff;}
	.balance_sub2 {height:40px; margin:10px 5px; background:#f49c06; border-radius:3px; text-align:center; font-size:14px; line-height:40px; color:#fff;}
	.balance_sub3 {height:40px; margin:10px 5px;background:#e2cb04; border-radius:3px; text-align:center; font-size:14px; line-height:40px; color:#fff;}
.balance_sub7 {height:40px; margin:14px 5px; background:#008cd7; border-radius:4px; text-align:center; font-size:16px; line-height:44px; color:#fff;}

</style>
<div id="container"></div>

<script id="tpl_main" type="text/html">
	<input type="hidden" id="logid" value="<%logid%>" />

	<div class="page_topbar">
        <a href="javascript:;" class="back" onclick="history.back()"><i class="fa fa-angle-left"></i></a>
        <div class="title">账户充值</div>
    </div>
	<div class="recharge">
		<div class="line">
			<div class="label">当前余额</div>
			<div class="info"><div class="inner"><%credit%></div></div>
		</div>
		<div class="line">
			<div class="label">充值金额</div>
			<div class="info"><div class="inner"><input type="text" id="money" placeholder="请输入充值的金额"/></div></div>
			<div class="ico" id="refresh" style="display:none;"><i class="fa fa-remove"></i></div>
		</div>
	</div>
	

	<div class="button balance_sub0" id="btnnext">下一步</div>
	<%if wechat.success%><div class="button balance_sub1" style="display:none">微信支付</div><%/if%>
	
  <%if alipay.success%><div class="button balance_sub2" style="display:none">支付宝支付</div><%/if%>
  <%if unionpay.success%><div class="button balance_sub7" style="display:none">银联支付</div><%/if%>
<div class="balance_sub3" onclick="location.href = '<?php  echo $this->createMobileUrl('member/log',array('type'=>0))?>'">充值记录</div>
	
</script>


<script language="javascript">
 

	
		
		core_json("<?php echo 	create_url('mobile',array('do'=>'member','act'=>'recharge','m'=>'eshop'))?>", {}, function (json) {
			var result = json.result;
			if (json.status != 1) {
				tip_message(result, "<?php  echo $this->createMobileUrl('member')?>", 'error');
				return;
			}
			$('#container').html(tpl('tpl_main', result));
			$('#logid').val(result.logid);
		
					$('#money').bind('input propertychange',function(){
						if($.trim($(this).val())!=''){
							$('#refresh').show().unbind('click').click(function(){
								$('#money').val('');
								$('#refresh').hide();
								$('#btnnext').show();
								$('.balance_sub1').hide();
									$('.balance_sub2').hide();
										$('.balance_sub7').hide();
							})
						}else{
							$('#btnnext').show();
									$('.balance_sub1').hide();
									$('.balance_sub2').hide();
										$('.balance_sub7').hide();
							$('#refresh').hide();
						}
					})

				$('#btnnext').bind('click', function () {
					var money = $.trim($('#money').val());
					var showpay = false;

                                             if($(this).attr('submintting')=='1'){
												 return;
                                            }
					if (!$.isEmpty(money)) {
						if ($.isNumber(money)) {
							showpay = true;
						}
					}
					if (!showpay)
					{
						tip_show('请输入数字充值金额!');
						return;
					}

                                              $(this).attr('submintting','1');

						
						
								$('#btnnext').hide();
							if (window.result.wechat.success) {
								$('.balance_sub1').show();
							}
							if (window.result.alipay.success) {
								$('.balance_sub2').show();
							}
							if (window.result.unionpay.success) {
								$('.balance_sub7').show();
							}

					
				});
	            
			window.result = result;
			if (result.wechat.success) {
				$('.balance_sub1').click(function () {
					var money = $('#money').val();
					if (!$('#money').isNumber()) {
						tip_show('请输入数字金额!');
						return;
					}
					var logid = $('#logid').val();
					if (logid == '') {
						tip_show('请刷新重试!');
						return;
					}

					core_json("<?php echo 	create_url('mobile',array('do'=>'member','act'=>'recharge','m'=>'eshop'))?>", {op: 'recharge',  type: 'wechat', money: money, logid: logid}, function (rjson) {
						if (rjson.status != 1) {
							tip_show(rjson.result);
							return;
						}
					if (rjson.result.logid>0) {
					  location.href="<?php echo create_url("mobile",array("act"=>"modules","do"=>"weixin_goldbridgepay"))?>&id="+rjson.result.logid;
						return;                     
						}

				tip_show('请刷新重试!');
				
					}, true);

				});
			}
			if (result.alipay.success) {
				$('.balance_sub2').click(function () {
					var money = $('#money').val();
					if (!$('#money').isNumber()) {
						tip_show('请输入数字金额!');
						return;
					}
					var logid = $('#logid').val();
					if (logid == '') {
						tip_show('请刷新重试!');
						return;
					}

					core_json("<?php echo 	create_url('mobile',array('do'=>'member','act'=>'recharge','m'=>'eshop'))?>", {op: 'recharge',  type: 'alipay', money: money, logid: logid}, function (rjson) {
						if (rjson.status != 1) {
							tip_show(rjson.result);
							return;
						}
					if (rjson.result.logid>0) {
									  location.href="<?php echo create_url("mobile",array("act"=>"modules","do"=>"alipay_goldbridgepay"))?>&id="+rjson.result.logid;
						return;                     
						}

				tip_show('请刷新重试!');
				
					}, true);

				});
			}
			
			
			if (result.unionpay.success) {
				$('.balance_sub1').click(function () {
					var money = $('#money').val();
					if (!$('#money').isNumber()) {
						tip_show('请输入数字金额!');
						return;
					}
					var logid = $('#logid').val();
					if (logid == '') {
						tip_show('请刷新重试!');
						return;
					}

					core_json("<?php echo 	create_url('mobile',array('do'=>'member','act'=>'recharge','m'=>'eshop'))?>", {op: 'recharge',  type: 'unionpay', money: money, logid: logid}, function (rjson) {
						if (rjson.status != 1) {
							tip_show(rjson.result);
							return;
						}
					if (rjson.result.logid>0) {
					  location.href="<?php echo 	create_url('mobile',array('do'=>'recharge','act'=>'payment','m'=>'eshop','op'=>'unionpay'))?>&paylog="+rjson.result.logid;
						return;                     
						}

				tip_show('请刷新重试!');
				
					}, true);

				});
			}
			
			
			
		}, false);


</script>

<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>
