<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page('header_base');?>
<title>个人中心</title>
<link href="<?php echo RESOURCE_ROOT;?>public/weui.min.css" rel="stylesheet">
<link href="<?php echo RESOURCE_ROOT;?>public/weui.plus.css?v=2" rel="stylesheet">
<style>
	.header {
    height: auto;
    width: 100%;
    background-color: #3190e8;
}
    .weui-media-box .user-head {height:55px; width:55px; background:#fff; border-radius:50%; border:2px solid #fff;}
    .weui-media-box .user-head  img {height:55px; width:55px; border-radius:24px;}
 	 .weui-media-box__bd .weui-media-box__title{color:#fff;}
   .weui-media-box__bd .weui-media-box__desc{color:#fff;}
	</style>
<div class="page js_show home" style="margin-bottom:50px">
    <div class="page__hd header" style="padding: 0px;">
    
    
    
    	<div class="weui-media-box weui-media-box_appmsg" style="padding-top: 10px;padding-left: 30px;" onclick="location.href='<?php  if(!empty($islogin)) { ?><?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'info'))?><?php }else{ ?><?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'login'))?><?php  } ?>'" >
                    <div class="weui-media-box__hd">
                    <div class="user-head" ><img src="<?php  if(!empty($islogin)&&!empty($memberinfo['avatar'])) { ?><?php echo $memberinfo['avatar'];?><?php  }else { ?><?php echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png<?php }?>" onerror="this.src='<?php echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'"></div>
										</div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title"><?php  if(!empty($islogin)) { ?><?php if(!empty($memberinfo['nickname'])){echo $memberinfo['nickname'];}else{echo $memberinfo['mobile'];};?><?php  }else{ ?>登录&#47;注册<?php  } ?></h4>
                        <p class="weui-media-box__desc" <?php  if(!empty($set_shop['levelurl'])) { ?>style="cursor: pointer;" onclick='location.href="<?php  echo $set_shop['levelurl'];?>"'<?php  } ?>>等级：<?php if($islogin){?><?php echo $level['levelname']?> <?php  if(!empty($set_shop['levelurl'])) { ?><i class='fa fa-question-circle' ></i><?php  } ?><?php  }else{ ?>游客<?php  } ?></p>
                    
                    </div>
                       <div class="weui-media-box__hd">
                    <i class="fa fa-angle-right" style="color:#fff;font-size:23px"></i></div>
                </div>
    	

    </div>
            	<?php if($islogin){?>
    <div class="weui-flex" style="background-color: #fff;padding: 8px;text-align:center;">
              <?php  $showmenu=false; ?> 
               <?php  if(empty($set_trade['closerecharge'])||$set_trade['withdraw']==1) { ?>   <div  class="weui-flex__item" style=" border-right: 1px solid #ddd;" <?php  if(empty($set_trade['closerecharge'])) { ?>onclick="location.href='<?php  echo create_url('mobile',array('act' => 'recharge','do' => 'member','m'=>'eshop'))?>'"<?php } ?>><div class="placeholder"><div  style="color: #f90; font-weight: 700;font-size:21px"><?php echo $memberinfo['credit2'];?><span style="font-size:14px;font-weight: 400;">元</span></div><div style="font-weight: 400;color: #666;font-size:14px;">我的余额</div></div></div>
     
                      <?php  }else{ $showmenu=true; } ?>   <div class="weui-flex__item"  style=" border-right: 1px solid #ddd;"><div class="placeholder" style="color: #6ac20b; font-weight: 700;font-size:21px"><?php echo $memberinfo['credit1'];?><span style="font-size:14px;font-weight: 400;">分</span></div><div  style="font-weight: 400;color: #666;font-size:14px;">我的积分</div></div>
      <?php  if($hascoupon) { ?>   <div style="cursor: pointer;" onclick="location.href='<?php  echo create_url('mobile',array('act' => 'my','do' => 'coupon','m'=>'eshop'))?>'" class="weui-flex__item"><div class="placeholder" style="color:  #ff5f3e; font-weight: 700;font-size:21px"><?php echo $coupon_count;?><span style="font-size:14px;font-weight: 400;">个</span></div><div  style="font-weight: 400;color: #666;font-size:14px;">我的优惠券</div></div>
               <?php  }else{ $showmenu=true; } ?> 
               
              <?php  if($showmenu) { ?> 
          <div  class="weui-flex__item" style=" border-right: 1px solid #ddd;" onclick="location.href='<?php  echo create_url('mobile',array('act' => 'cart','do' => 'shop','m'=>'eshop'))?>'" ><div class="placeholder"><div  style="color: #f90; font-weight: 700;font-size:21px"> <?php echo intval($cart_count);?><span style="font-size:14px;font-weight: 400;">件</span></div><div style="font-weight: 400;color: #666;font-size:14px;">购物车</div></div></div>
                    <?php  } ?> 
               
        </div>
            	<?php }?>
         	<?php if($islogin){?>
    <div class="page__bd page__bd_spacing" style="padding: 0px;margin-top:5px">
    	
    		<div class="weui-cells">
    	            <a style="padding-top: 0px;padding-bottom: 0px;" class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'list','do' => 'order','m'=>'eshop'))?>">
                <div class="weui-cell__bd">
                    <p><i class="fa fa-reorder" style="line-height:44px;"></i>&nbsp;&nbsp;全部订单</p>
                </div>
                <div class="weui-cell__ft">查看我的全部订单
                </div>
            </a>
              	<div class="weui-flex" style="padding: 0px;padding-bottom:10px;text-align:center;" >
            <div style="cursor: pointer; border-right: 1px solid #ddd;" onclick="location.href='<?php  echo create_url('mobile',array('act' => 'list','do' => 'order','m'=>'eshop','status'=>0))?>';" class="weui-flex__item"><div class="placeholder"><div><?php echo intval($order['status0']);?></div><div>待付款</div></div></div>
             <div style="cursor: pointer; border-right: 1px solid #ddd;" onclick="location.href='<?php  echo create_url('mobile',array('act' => 'list','do' => 'order','m'=>'eshop','status'=>1))?>';" class="weui-flex__item" style="border-left: 1px solid #eee;"><div class="placeholder"><?php echo intval($order['status1']);?></div><div>待发货</div></div>
                 <div style="cursor: pointer; border-right: 1px solid #ddd;" onclick="location.href='<?php  echo create_url('mobile',array('act' => 'list','do' => 'order','m'=>'eshop','status'=>2))?>';" class="weui-flex__item" style=" border-left: 1px solid #eee;"><div class="placeholder"><?php echo intval($order['status2']);?></div><div>待收货</div></div>
                 <div style="cursor: pointer; border-right: 1px solid #ddd;" onclick="location.href='<?php  echo create_url('mobile',array('act' => 'list','do' => 'order','m'=>'eshop','status'=>4))?>';" class="weui-flex__item" style="border-left: 1px solid #eee;"><div class="placeholder"><?php echo intval($order['status4']);?></div><div>待退款</div></div>
       
        </div>
            
         
        </div>
    		<?php  if($hascom) { ?>
    	<div class="weui-cells" style="margin-top:10px">
            <a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'index','do' => 'commission','m'=>'eshop'))?>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-home" style="color:#f10;"></i></div>合伙人中心</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
        </div>
    		<?php  } ?>
    			  
    	
    	
    	<div class="weui-cells" style="margin-top:10px">
    		<a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'info'))?>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-user" style="color:#A6E1EC;"></i></div>我的资料</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
              <a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'address','do' => 'shop','m'=>'eshop'))?>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-street-view" style="color:#f90;"></i></div>收货地址管理</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
    		   <a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'cart','do' => 'shop','m'=>'eshop'))?>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-shopping-cart" style="color:#f90;"></i></div>我的购物车</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
                 <?php  if($hascoupon) { ?>
            <a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'my','do' => 'coupon','m'=>'eshop'))?>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-gift" style="color:#08b00e;"></i></div>我的优惠券</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>     <?php } ?>
               <a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'favorite','do' => 'shop','m'=>'eshop'))?>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-heart" style="color:#f03;"></i></div>我的收藏</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
            <a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'history','do' => 'shop','m'=>'eshop'))?>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-street-view" style="color:#096;"></i></div>我的足迹</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
        </div>
  
    	
    		<div class="weui-cells" style="margin-top:10px">
    			 
               <?php  if(empty($set_trade['closerecharge'])) { ?>
                  <a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'recharge','do' => 'member','m'=>'eshop'))?>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-money" style="color:#f03;"></i></div>余额充值</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
    			  <?php  } ?>
    			  
    			      <?php  if($set_trade['withdraw']==1) { ?>
                  <a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'withdraw','do' => 'member','m'=>'eshop'))?>>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-credit-card" style="color:#f90;"></i></div>余额提现</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
    			  <?php  } ?>
  <a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'account'))?>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-random" style="color:#f10;"></i></div>账户绑定与解绑</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
             
                <a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'changepwd'))?>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-key" style="color:#f10;"></i></div>密码修改</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
               
    	  </div>
    	
    	<div class="weui-cells" style="margin-top:10px;">
    	   <a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'logout'))?>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-sign-out" style="color:#f10;"></i></div>退出登录</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
    		  </div>
    </div>
<?php }else{?>
    <div class="page__bd page__bd_spacing" style="padding: 0px;">
    		<div class="weui-cells" style="margin-top:10px;">
    				   <a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'cart','do' => 'shop','m'=>'eshop'))?>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-shopping-cart" style="color:#f90;"></i></div>我的购物车</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
    	   <a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'login'))?>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-sign-in" style="color:#f10;"></i></div>用户登录</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
            	   <a class="weui-cell weui-cell_access" href="<?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'register'))?>">
                <div class="weui-cell__bd">
                    <p><div style="float:left;width:25px"><i class="fa fa-user" style="color:#A6E1EC;"></i></div>用户注册</p>
                </div>
                <div class="weui-cell__ft">
                </div>
            </a>
    		  </div>
   </div>
<?php }?>
</div>

<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>