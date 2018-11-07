<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page('header_base');?>
<?php include page('header_plus');?>
<title>二维码页面</title>
<style type="text/css">
body {<?php if(is_mobile()){?>margin:0px;<?php }?>background:#f4f4f4;}
.top {height:68px; background:#fff; border-bottom:#e3e3e3; overflow:hidden;}
.top .ico {height:44px; width:44px; margin:12px; background:#fe9900; border-radius:44px; font-size:30px; line-height:44px; text-align:center; color:#fff; float:left;}
.top .info1 {height:44px; padding:12px 0px; float:left;}
.top .info1 .t1 {height:22px; font-size:16px; color:#666; line-height:26px;}
.top .info1 .t2 {height:22px; font-size:13px; color:#999; line-height:20px;}
.top span {color:#ff6600}
.img {padding:1px;overflow:hidden;height:auto;}
.img img { width:100%;}

.info {height:auto; background:#fff; padding:10px; padding-bottom:80px; border-bottom:1px solid #eee; border-top:1px solid #eee;}
.info .title {height:38px; border-bottom:1px solid #eee; overflow:hidden;}
.info .title .ico {height:24px; width:24px; background:#fd6401; margin:7px 7px 7px 0px; border-radius:24px; font-size:12px; color:#fff; line-height:24px; text-align:center; float:left;}
.info .title .text {height:38px; line-height:38px; font-size:14px; color:#666; float:left;}
.info .con {height:auto; padding:10px 0px;}
.info .con .line {height:auto; overflow:hidden; margin-bottom:5px;}
.info .con .line .t1 {height:auto; width:55px; float:left; font-size:14px; color:#666; line-height:20px;}
.info .con .line .t2 {padding-left:55px; background:#f90;}
.info .con .line .t2 .t3 {height:auto; float:left; font-size:14px; color:#999;}
.info .info2 {height:auto; background:#fe924a; padding:10px; font-size:14px; color:#fff;}

.bottom {height:50px; width:100%; background:#fff; padding:10px; border-top:1px solid #eee; position:fixed; bottom:0px; left:0px; box-shadow:1px 2px 10px rgba(0,0,0,0.2);}
.bottom .sub {height:50px; width:46%; margin-left:2%; float:left; border:1px solid #eee; border-radius:3px; font-size:16px; line-height:50px; text-align:center; color:#666;}


</style> 
    
    <!-- 系统生成图片 开始 -->
  
    <!-- 系统生成图片 结束 -->
	<div class="info" >
    
  	      <div class="img">
        <img id='posterimg' src="<?php echo $img;?>" />
    </div>
  </div>

    <!-- 底部浮层 开始 -->
    <?php if(is_weixin()){?>
    <div class="bottom">
        <div id="btn1" class="sub" style="margin:0px;"><i class="fa fa-link" style="height:18px; width:18px; color:#fcac71; border:1px solid #fcac71; border-radius:20px; line-height:18px; text-align:center; font-size:14px;"></i> 链接推广</div>
        <div id="btn2" class="sub"><i class="fa fa-image" style="height:18px; width:18px; color:#63b3aa; border:1px solid #63b3aa; border-radius:20px; line-height:18px; text-align:center; font-size:12px;"></i> 图片推广</div>
    </div>
      <?php } ?>
    <div id='cover'><img src='<?php  echo WEBSITE_ROOT;?>/assets/eshop/static/images/guide.png' style='width:100%;' /></div>
    <!-- 底部浮层 结束 -->
    <script language="javascript">
    
           
           if( "<?php  echo $infourl;?>"!=''){
                tip_message('您需要完善您的资料才能继续!',"<?php  echo $infourl;?>","warning");
          
            }else
            	{
            $('#btn1').click(function(){
                $('#cover').fadeIn(200).unbind('click').click(function(){
                    $(this).fadeOut(100);
                })
            });
            $('#btn2').click(function(){
                  tip_alert('长按图片收藏，然后发送给好友') ;
            });
         
      }
        </script>
<?php  $show_footer=(is_weixin()==false);?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?> 