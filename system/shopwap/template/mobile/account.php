<?php defined('SYSTEM_IN') or exit('Access Denied');?>
<?php include page('header_base');?>
<title>账户绑定与解绑</title>
<link href="<?php echo RESOURCE_ROOT;?>public/weui.min.css" rel="stylesheet">
<link href="<?php echo RESOURCE_ROOT;?>public/weui.plus.css?v=2" rel="stylesheet">
<script>
		function account_mobile()
	{
		<?php if(empty($base_member['mobile'])){?>
			location.href='<?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'info'))?>';
			<?php }else{?>
						document.getElementById('emsg').innerText="确认解绑手机号？";
						document.getElementById('xurl').href="<?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'account',"op"=>"unbinding_mobile"))?>";
	    $('#iosDialog').fadeIn(200);
		<?php }?>
	}
	function account_weixin()
	{
		<?php if(empty($base_member['weixin_openid'])){?>
			location.href='<?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'account',"op"=>"binding_weixin"))?>';
			<?php }else{?>

						document.getElementById('emsg').innerText="确认解绑微信号？";
						document.getElementById('xurl').href="<?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'account',"op"=>"unbinding_weixin"))?>";
	    $('#iosDialog').fadeIn(200);
		<?php }?>
	}
	function account_qq()
	{
		
			<?php if(empty($base_member['qq_openid'])){?>
			location.href='<?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'account',"op"=>"binding_qq"))?>';
			<?php }else{?>
		
				
						document.getElementById('emsg').innerText="确认解绑QQ号？";
						document.getElementById('xurl').href="<?php  echo create_url('mobile',array('act' => 'shopwap','do' => 'account',"op"=>"unbinding_qq"))?>";
	    $('#iosDialog').fadeIn(200);
				<?php }?>
	}
	</script>
<form  method="post" enctype="multipart/form-data">
	   
<div class="weui-cells_form" style="  margin-bottom:50px;   border-bottom: 0px solid #FFF;   margin-top: 0;">
	 <div class="page_topbar" >
     <a href="<?php echo create_url('mobile',array('act' => 'center','do' => 'member','m'=>'eshop'));?>" class="back"  style="color: #fff;text-align:center;"><i class="fa fa-angle-left"></i></a>
    <div class="title" style="color: #fff;text-align:center;">账户绑定与解绑</div>
</div>

            
              <div class="weui-cells  weui-cell_select" style="cursor:pointer" onclick="account_mobile();">
              	  <div class="weui-cell__bd">
                <div class="weui-cell">
                <div class="weui-cell__bd">
                 <img src="<?php echo RESOURCE_ROOT;?>public/image/phone.jpg"  style="vertical-align:middle;margin-right:5px;width:24px;height:38px"><?php  echo empty($base_member['mobile'])?"未绑定手机号":"手机号：".$base_member['mobile'];?>
                </div>
                <div  style="float:right;margin-right:20px">
                	  <?php echo empty($base_member['mobile'])?"点击绑定":"点击解绑";?>
              		
                </div>
            </div>  
            
             </div>
            </div>
            
      
      
           <?php if(is_use_weixin()||(is_mobile()==false&&is_access_weixin())){?>
                   <div class="weui-cells  weui-cell_select" style="cursor:pointer" onclick="account_weixin();">
              	  <div class="weui-cell__bd" >
                <div class="weui-cell">
                <div class="weui-cell__bd" >
                 <img src="<?php echo RESOURCE_ROOT;?>public/image/weixin_icon.png"  style="vertical-align:middle;margin-right:5px;width:24px;height:24px"><?php  echo empty($base_member['weixin_openid'])?"未绑定微信号":"已绑定微信号";?>
                </div>
                <div  style="float:right;margin-right:20px">
                	  <?php echo empty($base_member['weixin_openid'])?"点击绑定":"点击解绑";?>
              		
                </div>
            </div>  
            
             </div>
            </div>
                       <?php }?>
            <?php if(!empty($qq_settings['fastlogin_open'])){?>
              <div class="weui-cells  weui-cell_select" style="cursor:pointer" onclick="account_qq();">
              	  <div class="weui-cell__bd">
                <div class="weui-cell">
                <div class="weui-cell__bd">
                <img src="<?php echo RESOURCE_ROOT;?>public/image/qq_icon.png" style="vertical-align:middle;margin-right:5px;width:24px;height:24px"><?php  echo empty($base_member['qq_openid'])?"未绑定QQ号":"已绑定QQ号";?>
                </div>
                <div  style="float:right;margin-right:20px">
                	  <?php echo empty($base_member['qq_openid'])?"点击绑定":"点击解绑";?>
              		
                </div>
            </div>  
            
             </div>
            </div>
             <?php }?>
            
       
        
      
        
        </div>
</form>


<div class="js_dialog" id="iosDialog" style="display: none;">
            <div class="weui-mask"></div>
            <div class="weui-dialog">
                <div class="weui-dialog__hd"><strong class="weui-dialog__title">操作确认</strong></div>
                <div class="weui-dialog__bd" id="emsg"></div>
                <div class="weui-dialog__ft">
                    <a href="javascript:;"  onclick=" $('#iosDialog').fadeOut(200);" class="weui-dialog__btn weui-dialog__btn_default">取消操作</a>
                    <a href="javascript:;" id="xurl" class="weui-dialog__btn weui-dialog__btn_primary">确定解绑</a>
                </div>
            </div>
        </div>
<?php  $show_footer=true;?>
<?php include page('footer_menu');?>
<?php include page('footer_base');?>