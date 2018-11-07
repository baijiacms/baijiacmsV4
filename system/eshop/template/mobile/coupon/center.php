<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page('header_base');?>
<?php include page('header_plus');?>
<script language="javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/jquery.touchslider.min.js"></script>
<script language="javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/swipe.js"></script>
<title>优惠券领取中心</title>
<link rel="stylesheet" type="text/css" href="<?php  echo RESOURCE_ROOT;?>eshop/static/mobile/static/coupon/images/style.css">
<style type="text/css">
    body {<?php if(is_mobile()){?>margin:0px;<?php }?>background:#efefef; font-family:'微软雅黑'; -moz-appearance:none;overflow-x: hidden;}
    a {text-decoration:none;}

	
	#coupon_loading { width:94%;padding:10px;color:#666;text-align: center;}
 

	.coupon_no {height:100px;  margin:50px 0px 60px; color:#ccc; font-size:12px; text-align:center;}
	.coupon_menu {height:60px; width:100%; }
	.coupon_no_nav {height:38px; background:#eee; margin:0px 3%; border:1px solid #d4d4d4; border-radius:5px; text-align:center; line-height:38px; color:#666;}



    div.flicking_con{position:absolute;bottom:10px;z-index:1;width:100%;height:12px;}
    div.flicking_con .inner { width:100%;height:9px;text-align:center;}
    div.flicking_con a{position:relative; width:10px;height:9px;background:url('<?php  echo RESOURCE_ROOT;?>eshop/static/mobile/static/images/dot.png') 0 0 no-repeat;display:inline-block;text-indent:-8730px; text-indent:-1000px}
    div.flicking_con a.on{background-position:0 -9px}
	
.coupon_footer {padding:20px 10px; font-size:13px; color:#666; line-height:20px; text-align:center;background:#efefef;}

.coupon_item .cinfo .inner .name { font-size:14px; color:#222; height:24px; text-overflow:ellipsis; white-space:nowrap; overflow:hidden; line-height: 30px}
.coupon_item .cinfo .inner .time { font-size:12px; color:#666; height:18px; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;}
.coupon_item .cinfo .inner .pay { font-size:11px; color:#666; height:20px; text-overflow:ellipsis; white-space:nowrap; overflow:hidden;}
.coupon_item .cinfo .inner span { padding: 3px 0; }
</style>
<div class="page_topbar">
	<a href="javascript:;" class="back" onclick='history.go(-1)'><i class="fa fa-angle-left"></i></a>
	<a href="<?php  echo $this->createMobileUrl('coupon/my')?>" class="btn"><i class="fa fa-user"></i></a>
	<div class="title">优惠券领取中心</div>
</div>

   
 
    
	<div id='cates'></div>
<div id='container'></div>

<script id='tpl_empty' type='text/html'>
	<div class="coupon_no"><i class="fa fa-credit-card" style="font-size:100px;"></i><br><span style="line-height:18px; font-size:16px;">还没有发布优惠券~</span></div>
</script>
<script id='tpl_list' type='text/html'>
<%each list as coupon%>

<div class="coupon_item" onclick="location.href = '<?php  echo $this->createMobileUrl('coupon/detail')?>&id=<%coupon.id%>'">
          <div class='bg cside side side-left'></div>
		 
	<div class="cthumb" <%if coupon.thumb==''%>style="width:8px;"<%/if%>> <%if coupon.thumb %><img src='<%coupon.thumb%>' /><%/if%></div>
	
	<div class="cinfo" >
		<div class="inner" >
			<div class="name"><%coupon.couponname%></div>
			<div class="time"><%if coupon.timestr=='0'%>
			永久有效 
			<%else%>
		 <%if coupon.timestr=='1'%>
		          即<%coupon.gettypestr%>日内 <%coupon.timedays%> 天有效
				  <%else%>
			有效期 <%coupon.timestr%>
			<%/if%>
			<%/if%></div>
			<div class='pay'>
				
				 
				<%if coupon.getstatus=='0'%><span class="ccreditmoney"><%coupon.money%> 元 +  <%coupon.credit%> 积分</span><%/if%>
				
				<%if coupon.getstatus=='1'%><span class="cmoney"><%coupon.money%></span> 元<%/if%>
				<%if coupon.getstatus=='2'%><span class="ccredit"><%coupon.credit%></span> 积分<%/if%>
				<%if coupon.getstatus=='3'%><span class="cfree">免费领取</span><%/if%>
					<%if coupon.getmax!=-1 && coupon.getmax!=0%>
				           每人限 <%coupon.getmax%> 张 
					<%/if%>
				 
			</div>
		</div>
	</div>
	 <div class="cright">
		   <div class="bg png png-<%coupon.css%>"></div>
		   <div class="bg sideleft side side-<%coupon.css%>"></div>
		   <div class="rinfo" >
			   <div class='rinner <%coupon.css%>'>
				 <div class="price"><%if coupon.backpre%>￥<%/if%><span><%coupon._backmoney%></span></div>
				 <div class="type"><%coupon.backstr%></div>
			   </div>
		 </div>
		   <div class="bg sideright side side-<%coupon.css%>"></div>
		
	</div>

</div>

<%/each%>
</script>

<script language='javascript'>
	$(function(){
		getCoupons('',true);
	});
var page = 1;
var loaded = false;
var stop=true; 
var init = false;
function getCoupons(catid,init){
	loaded = false;
          stop=true; 
          page=1;


		var left =0; 
		if( $("#cates .container").length>0){
		      left = $("#cates .container").scrollLeft();	
		}
		 if(init){
     
	  }else{
		  $("#cates").html($("#cates").html());
	  }
	$('#cates .item').removeClass('on');
	$('#cates .item[data-catid="' + catid + '"]').addClass('on');
	$("#cates .container").scrollLeft(left);	
		
	 core_json("<?php echo 	create_url('mobile',array('do'=>'coupon','act'=>'center','m'=>'eshop'))?>", {page:page, catid: catid}, function(json) {
                
                    if (json.result.list.length <= 0) {
                       $("#container").html(tpl('tpl_empty'));
					   $(window).unbind('scroll');loaded = false;
          stop=true; 
                       return;
                    }
                       $("#container").html(tpl('tpl_list', json.result));
                      $(window).scroll(function(){ 
                          if(loaded){
                              return;
                          }
                            totalheight = parseFloat($(window).height()) + parseFloat($(window).scrollTop()); 
                            if($(document).height() <= totalheight){ 
                                
                                if(stop==true){ 
                                    stop=false; 
                                    $('#container').append('<div id="coupon_loading"><i class="fa fa-spinner fa-spin"></i> 正在加载...</div>');
                                    page++;
                                    
                                    core_json("<?php echo 	create_url('mobile',array('do'=>'coupon','act'=>'center','m'=>'eshop'))?>", {page:page, catid: catid}, function(morejson) {  
                                        stop = true;
                                        $('#coupon_loading').remove();
                                        $("#container").append(tpl('tpl_list', morejson.result));
                                        if (morejson.result.list.length <morejson.result.pagesize) {
                                            $('#container').append('<div id="coupon_loading">已经加载全部优惠券</div>');
                                            loaded = true;
                                            return;
                                        }
                                    },true); 
                                } 
                            } 
                        });
                }, false);
  	
}
</script>


<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>