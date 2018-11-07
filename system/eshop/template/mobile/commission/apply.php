<?php defined('IN_IA') or exit('Access Denied');?><?php include page('header_base');?>
<?php include page('header_plus');?><title>申请提现</title>
<style type="text/css">
body {<?php if(is_mobile()){?>margin:0px;<?php }?>background:#efefef; -moz-appearance:none;}
input {-webkit-appearance:none; outline:none;}
.balance_img {height:80px; width:80px; margin:70px auto 0px; background:#ffb400; border-radius:40px; color:#fff; font-size:70px; text-align:center; line-height:90px;}
.balance_text {height:20px; width:100%; margin-top:16px; text-align:center; line-height:20px; font-size:16px; color:#666;}
.balance_num {height:24px; width:100%; margin-top:10px; text-align:center; line-height:24px; font-size:22px; color:#444;}

.balance_sub1 {height:44px; width:94%; margin:14px 3% 0px; background:#ff6600; border-radius:4px; text-align:center; font-size:18px; line-height:44px; color:#fff; box-shadow:#eee 1px 1px 3px;}
.balance_sub2 {height:44px; width:94%; margin:14px 3% 0px; background:#31cd00; border-radius:4px; text-align:center; font-size:18px; line-height:44px; color:#fff;}
.balance_sub3 {height:44px; width:94%; margin:14px 3% 0px; background:#ffffff; border-radius:4px; text-align:center; font-size:18px; line-height:44px; color:#666; box-shadow:#eee 1px 1px 3px;}
.disabled { background:#ccc;}
</style>
<div id='container'></div>

<script id='tpl_main' type='text/html'>
 <div class="balance_img"><i class="fa fa-cny"></i></div>
    <div class="balance_text">我的可提现佣金</div>
    <div class="balance_num">￥<%member.commission_ok%></div>
    

    <div class="balance_sub balance_sub2 <%if !cansettle%>disabled<%/if%>" data-type="1">提现到微信号</div>

        <?php  if(empty($set['closetocredit'])) { ?>
    <div class="balance_sub balance_sub1 <%if !cansettle%>disabled<%/if%>" data-type="0">提现到余额</div>
    <?php  } ?>
    
    <div class="balance_sub3" onclick="location.href='<?php  echo $this->createMobileUrl('commission/log')?>'">提现记录</div>
</script>
<script language="javascript">
   
        
        core_json('<?php echo 	create_url('mobile',array('do'=>'commission','act'=>'apply','m'=>'eshop'))?>',{},function(json){
           var result = json.result;
           $('#container').html(  tpl('tpl_main',json.result) );
           if(result.noinfo){
                tip_message('请补充您的资料后才能申请提现!',result.infourl,'warning');
                return;
            }
            
           if(json.result.cansettle){
               $('.balance_sub').click(function(){
                   if($('.balance_sub').attr('saving')=='1'){
                       return;
                   }
                 var type= $(this).data('type');
                       
                   tip_confirm('确认要申请提现? 提现申请通过之后给您打款后会通知您到的微信.',function(){
                       
                       $('.balance_sub').attr('saving',1).html('正在处理中...');
                        core_json('<?php echo 	create_url('mobile',array('do'=>'commission','act'=>'apply','m'=>'eshop'))?>',{type:type},function(pjson){
                              if(pjson.status=='1'){
                                   tip_show( pjson.result );
                                   location.href = '<?php echo 	create_url('mobile',array('do'=>'commission','act'=>'withdraw','m'=>'eshop'))?>';
                              }else
                              	{
                              		 tip_alert( pjson.result );
                              		    $('.balance_sub1').attr('saving',0).html('提现到余额');
                              		   $('.balance_sub2').attr('saving',0).html('提现到微信号');
                              		}
                               
                       },true,true);
                   });
               })
           }
        },false);
        
   
</script>
<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>