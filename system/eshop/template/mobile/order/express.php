<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page('header_base');?>
<?php include page('header_plus');?>
<title>查看物流</title>
<style type="text/css">
    body {<?php if(is_mobile()){?>margin:0px;<?php }?>background:#efefef; -moz-appearance:none;}


    .detail_topbar {height:44px; background:#5f6e8b; padding:15px;}
    .detail_topbar .ico {height:44px; width:30px; line-height:34px; float:left; font-size:26px; text-align:center; color:#fff;}
    .detail_topbar .tips {height:34px;  margin-left:10px; font-size:13px; color:#fff; line-height:17px;}
    
    .detail_good {height:auto;padding:10px;background:#fff;  margin-top:16px; border-top:1px solid #eaeaea;}
    .detail_good .ico {height:6px; width:10%; line-height:36px; float:left; text-align:center;}
    .detail_good .shop {height:36px; width:90%; padding-left:10%; border-bottom:1px solid #eaeaea; line-height:36px; font-size:18px; color:#333;}
    .detail_good .good {height:50px; width:100%; padding:10px 0px; border-bottom:1px solid #eaeaea;}
    .detail_good .img {height:50px; width:50px; float:left;}
    .detail_good .img img {height:100%; width:100%;}
    .detail_good .info {width:100%;float:left; margin-left:-50px;margin-right:-60px;}
    .detail_good .info .inner { margin-left:60px;margin-right:60px; }
    .detail_good .info .inner .name {height:32px; width:100%; float:left; font-size:12px; color:#555;overflow:hidden;}
    .detail_good .info .inner .option {height:16px; width:100%; float:left; font-size:12px; color:#888;overflow:hidden;word-break: break-all}
    .detail_good span { color:#666;}
    .detail_good .price { float:right;width:60px;;height:54px;margin-left:-60px;;}
    .detail_good .price .pnum { height:20px;width:100%;text-align:right;font-size:14px; }
    .detail_good .price .num { height:20px;width:100%;text-align:right;}
    
     .detail_express {height:auto;padding:10px;background:#fff;  margin-top:16px; border-top:1px solid #eaeaea;}
    .detail_express .ico {height:6px; width:10%; line-height:36px; float:left; text-align:center;}
    .detail_express .title {height:36px; width:90%; padding-left:10%; border-bottom:1px solid #eaeaea; line-height:36px; font-size:18px; color:#333;}
    .detail_express .content {height:auto; width:100%; padding:10px 0px; }
 .list-main {min-height:100px; background:#fff; padding:0 10px 0 10px;}
.list {height:75px; border-left:1px solid #eee; padding-left:20px; position:relative;}
.list .info {height:75px; border-top:1px solid #eee; padding:10px; font-size:14px; color:#666;}
.list .info .step { height:40px;} 
.list .info .time { height:20px;}
.list .infoon { color:#25ae5e}
.list .dot {height:10px; width:10px; border-radius:10px; background:#ddd; position:absolute; left:-6px; top:12px;}
.list .doton {height:12px; width:12px; background:#25ae5e; border-radius:12px; border:1px solid #bbe2c9; left:-8px;}
</style>
<div id='container'></div>

<script id='tpl_detail' type='text/html'>
 <div class="page_topbar">
     <a href="<?php  echo $this->createMobileUrl('order')?>" class="back"><i class="fa fa-angle-left"></i></a>
    <div class="title">查看物流</div>
</div>
<div class="detail_topbar">
    <div class="ico"><i class="fa fa-file-text-o"></i></div>
    <div class="tips">
        <%order.expresscom%>
        <br>
        <span>运单编号: <%order.expresssn%><span><br/>
</div>
 </div>
<div class="detail_good">
    <div class="ico"><i class="fa fa-gift" style="color:#666; font-size:20px;"></i></div>
    <div class="shop">物品信息</div>
    <%each goods as g%>
     <div class="good">
            <div class="img" onclick="location.href='<?php  echo $this->createMobileUrl('shop/detail')?>&id=<%g.goodsid%>'"><img src="<%g.thumb%>"/></div>
            <div class='info' onclick="location.href='<?php  echo $this->createMobileUrl('shop/detail')?>&id=<%g.goodsid%>'">
                <div class='inner'>
                       <div class="name"><%g.title%></div>     
                       <div class='option'><%if g.optionid!='0'%>规格:  <%g.optiontitle%><%/if%></div>
                </div>
            </div>
            <div class="price">
                <div class='pnum'><span class='marketprice'>￥<%g.price%></span></div>
                <div class='pnum'><span class='total'>×<%g.total%></span></div>
            </div>
        </div>
    <%/each%>
</div> 

<div class='detail_express'>
    <div class="ico"><i class="fa fa-truck" style="color:#666; font-size:20px;"></i></div>
    <div class="title">物流跟踪</div>
    <div class='content' id='express_container'>
      
    </div>
    
</div>
      <div style="height:80px;"></div>
</script>
<script id='tpl_express' type='text/html'>
      <%if list.length<=0%>
        <p>未查询到物流信息</p>
        <%else%>
        <div class="list-main">
            <%each list as row index%>
             <div class="list">
                 <div class="info <%if index==0%>infoon<%/if%>" <%if index==0%>style='border:none'<%/if%>>
                     <div class='step'><%row.step%></div>
                     <div class='time'><%row.time%></div>
                 </div>
                 <div class="dot  <%if index==0%>doton<%/if%>"></div>
             </div>
            <%/each%>
       </div>
        <%/if%>
</script>
 
<script type="text/javascript">
 

    
        core_json("<?php echo 	create_url('mobile',array('do'=>'order','act'=>'express','m'=>'eshop'))?>",{id:'<?php  echo $_GPC['id'];?>'},function(json){
                 
                 if(json.status==0){
                     tip_message( json.result ,"<?php  echo $this->createMobileUrl('order')?>" ,'error');
                     return;
                 }
                 $('#container').html(  tpl('tpl_detail',json.result) );
                 var order = json.result.order;
                 
                 core_json("<?php echo 	create_url('mobile',array('do'=>'order','act'=>'express','m'=>'eshop'))?>",{op:'step',id:'<?php  echo $_GPC['id'];?>',express:order.express,expresssn:order.expresssn,'op':'step'},function(pjson){
                        $('#express_container').html(  tpl('tpl_express',pjson.result) );
                 },true);
                 
         },false);

</script>

<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>
