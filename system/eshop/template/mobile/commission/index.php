<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page('header_base');?>
<title>合伙人中心</title>
<link href="<?php echo RESOURCE_ROOT;?>public/weui.min.css" rel="stylesheet">
<link href="<?php echo RESOURCE_ROOT;?>public/weui.plus.css?v=2" rel="stylesheet">
<style>
	.header {
    height: auto;
    width: 100%;
    background-color: #cc3431;
}
    .weui-media-box .user-head {margin:0 auto;height:55px; width:55px; background:#fff; border-radius:50%; border:2px solid #fff;}
    .weui-media-box .user-head  img {height:55px; width:55px; border-radius:24px;}
 	 .weui-media-box__bd .weui-media-box__title{color:#fff;}
   .weui-media-box__bd .weui-media-box__desc{color:#fff;}
	</style>
<div class="page js_show home" style="margin-bottom:50px">

	
    <div class="page__hd header" style="padding: 0px;">
  
                    	<div class="weui-media-box weui-media-box_appmsg" style="padding-bottom: 5px;" >
                     <div class="weui-media-box__bd" style="text-align:center">
                       <div class="user-head"  ><img src="<?php  if(!empty($member['avatar'])) { ?><?php echo $member['avatar'];?><?php  }else { ?><?php echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png<?php }?>" onerror="this.src='<?php echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'"></div>
								 
                    </div>
                     
                </div>
    	
                
    	<div style="padding-bottom: 15px;">
                     <div class="weui-media-box__bd" style="text-align:center">
                        <h4 class="weui-media-box__title" style="font-size: 15px;"><?php echo $member['nickname'];?>
                        	   <span style="color:#ffc82e;<?php  if(!empty($set['levelurl'])) { ?>cursor: pointer;<?php } ?>" <?php  if(!empty($set['levelurl'])) { ?>onclick='location.href="<?php  echo $set['levelurl'];?>"'<?php  } ?>>[<?php echo $level['levelname']?><?php  if(!empty($set['levelurl'])) { ?><i class='fa fa-question-circle' ></i><?php  }else { echo "普通等级"; } ?>]</span>
                    </h4>
                        <p class="weui-media-box__desc" >加入时间：<?php echo $member['agenttime'];?></p>
                    
                     
                    </div>
                     
                </div>
    	

    </div>
         
    <div class="weui-flex" style="background-color: #fff;padding: 8px;text-align:center;">
         <div  class="weui-flex__item" style="cursor: pointer;border-right: 1px solid #ddd;" <?php  if($member['commission_ok']>0) { ?>onclick="location.href='<?php  echo $this->createMobileUrl('commission/apply')?>'"<?php } ?>><div class="placeholder"><div  style="color: #ff5f3e; font-weight: 700;font-size:21px"><?php echo $member['commission_ok'];?><span style="font-size:14px;font-weight: 400;">元</span></div><div style="font-weight: 400;color: #666;font-size:14px;">可提现佣金</div></div></div>
      <div class="weui-flex__item"><div class="placeholder" style="color: #6ac20b; font-weight: 700;font-size:21px"><?php echo $member['commission_total'];?><span style="font-size:14px;font-weight: 400;">个</span></div><div  style="font-weight: 400;color: #666;font-size:14px;">累计佣金</div></div>
        </div>


<div class="weui-grids">
        <a href="<?php  echo $this->createMobileUrl('commission/withdraw')?>" class="weui-grid" >
            <div class="weui-grid__icon" >
                <i class="fa fa-cny fa-2x" style="color:#ff9901;"></i>
            </div>
            <p class="weui-grid__label">合伙人佣金</p>
             <p class="weui-grid__label" style="font-size: 12px;color: #999;"><span style=" color: #f90;"><?php echo $member['commission_total'];?></span>元</p>
        </a>
       <a href="<?php  echo $this->createMobileUrl('commission/order')?>" class="weui-grid" >
            <div class="weui-grid__icon" >
                <i class="fa fa-list fa-2x" style="color:#ffcb05;"></i>
            </div>
            <p class="weui-grid__label">合伙人订单</p>
             <p class="weui-grid__label"  style="font-size: 12px;color: #999;"><span style=" color: #f90;"><?php echo $member['ordercount0'];?></span>个</p>
        </a>
          <a href="<?php  echo $this->createMobileUrl('commission/log')?>" class="weui-grid" >
            <div class="weui-grid__icon" >
                <i class="fa fa-random fa-2x" style="color:#ca81d1;"></i>
            </div>
            <p class="weui-grid__label">佣金明细</p>
             <p class="weui-grid__label"  style="font-size: 12px;color: #999;">佣金明细</p>
        </a>
        <a href="<?php  echo $this->createMobileUrl('commission/team')?>" class="weui-grid" >
            <div class="weui-grid__icon" >
                <i class="fa fa-users fa-2x" style="color:#98cd37;"></i>
            </div>
            <p class="weui-grid__label">我的团队</p>
                       <p class="weui-grid__label"  style="font-size: 12px;color: #999;"><span style=" color: #f90;"><?php echo $member['agentcount'];?></span>人</p>
        </a>
        
        <a href="<?php  echo $this->createMobileUrl('commission/customer')?>" class="weui-grid" >
            <div class="weui-grid__icon" >
                <i class="fa fa-users fa-2x" style="color:#3c7bce;"></i>
            </div>
            <p class="weui-grid__label">我的客户</p>
                       <p class="weui-grid__label"  style="font-size: 12px;color: #999;"><span style=" color: #f90;"><?php echo $member['customercount'];?></span>人</p>
        </a>
        
        <a href="<?php  echo $this->createMobileUrl('commission/shares')?>" class="weui-grid" >
            <div class="weui-grid__icon" >
                <i class="fa fa-qrcode fa-2x" style="color:#53bdec;"></i>
            </div>
            <p class="weui-grid__label">二维码</p>
               <p class="weui-grid__label"  style="font-size: 12px;color: #999;">推广二维码</p>
            
        </a>
        
        
    </div>


    </div>
</div>

<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>