<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page('header_base');?>
<?php include page('header_plus');?>
<title>合伙人中心</title>
<style type="text/css">
    body {<?php if(is_mobile()){?>margin:0px;<?php }?>background:#eee; font-family:'微软雅黑'; }
    a {text-decoration:none;}
 
 
    
.gold_top {height:168px; width:94%; background:#57cc31; padding:10px 3% 0px;}
.gold_top .title {height:77px; width:100%; font-size:16px; color:#fff; padding-top:10px;}
.gold_top .num {height:40px; width:100%; font-size:34px; line-height:40px; color:#fff;}
.gold_top .num a {height:40px; width:auto;  float:right; padding-right:26px; line-height:50px; color:#fff; font-size:16px;}
.gold_top .num2 {height:40px; width:100%; color:#fff; line-height:40px; font-size:16px; border-top:1px solid #eee;}
.gold_num {height:auto; padding:10px; background:#fff; border-top:1px dashed #eaeaea; font-size:16px; color:#999;}
.gold_num .nav {height:70px; width:45%; padding-left:5%; float:left; border-right:1px solid #eaeaea;}
.gold_num .nav .title {height:30px; width:100%; color:#333; font-size:14px; line-height:30px;}
.gold_num .nav .num {height:20px; width:100%; color:#666; font-size:20px; line-height:16px;}
.gold_num .nav .tip {height:20px; width:90%; color:#666; font-size:12px; line-height:20px; color:#999;}
.gold_sub {height:44px; width:94%; background:#31cd00; line-height:44px; font-size:18px; color:#fff; text-align:center; margin:16px 3%; border-radius:5px;}


</style>
<div id='container'></div>
 
<script id='tpl_main' type='text/html'>
    <div class="gold_top">
        <div class="title">可提现佣金（元）</div>
        <div class="num"><%member.commission_ok%><a href="<?php  echo $this->createMobileUrl('commission/log')?>" >查看明细&nbsp;<i class="fa fa-arrow-right" style="color:#fff;"></i></a></div>
        <div class="num2">成功提现佣金：<%member.commission_pay%></div>
    </div>
    <div class="gold_num" style="border:0px;height:70px">
        <div class="nav"><div class="title">累计佣金</div><div class="num"><%member.commission_total%></div><div class='tip'>所有佣金</div></div>
        <div class="nav" style="border:0px; width:44%;"><div class="title">已申请佣金</div><div class="num"><%member.commission_apply%></div><div class='tip'>已申请佣金</div></div>
    </div>
    <div class="gold_num" style="border:0px;height:70px">
        <div class="nav"><div class="title">待打款佣金</div><div class="num"><%member.commission_check%></div><div class='tip'>审核通过的佣金</div></div>
       <div class="nav" style="border:0px; width:44%;"><div class="title">未结算佣金</div><div class="num"><%member.commission_lock%></div><div class='tip'>结算期内的佣金</div></div>
    </div>
    <div class="gold_num">买家确认收货后，立即获得合伙人佣金。<%if set.settledays>0%>结算期（<%set.settledays%>天）后，佣金可提现。结算期内，买家退货，佣金将自动扣除。<%/if%>
        <%if set.withdraw>0%><br/><br/>注意： 可用佣金满 <span style='color:red'><%set.withdraw%></span> 元后才能申请提现<br/><%/if%>
    </div>
    <div class="gold_sub" <%if !cansettle %>style='background:#ccc'<%/if%>>我要提现</div>
        
        
</div>

</script>
<script language="javascript">

        
        core_json('<?php echo 	create_url('mobile',array('do'=>'commission','act'=>'withdraw','m'=>'eshop'))?>',{},function(json){
           $('#container').html(  tpl('tpl_main',json.result) );
             
           if(json.result.cansettle){
               $('.gold_sub').click(function(){
                   location.href="<?php  echo $this->createMobileUrl('commission/apply')?>";
               })
           }
        },true);
        

</script>

<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>