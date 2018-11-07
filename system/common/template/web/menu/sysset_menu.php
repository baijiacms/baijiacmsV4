<?php defined('IN_IA') or exit('Access Denied');?>

<h3>
						<i class="main_i_icon1 fa fa-gears">&nbsp;</i>商城设置
					</h3>
<ul>
	
              <li 	<?php  if($_GPC['do'] == 'sysset' ) { ?><?php  if($_GPC['op']=='shop') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'sysset','do' => 'sysset','m' => 'eshop','op'=>'shop'))?>">基础设置</a>
                                    </li>  
                                    
                                   
                                    
                                         <li <?php  if($_GPC['do'] == 'shop' ) { ?> <?php  if($_GPC['act'] == 'dispatch') { ?> class="current" <?php  } ?> <?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'dispatch','do' => 'shop','m' => 'eshop'))?>">配送方式 </a>
                                    </li>  
                                   
                                    
                                    
                                    
                                           <li 	<?php  if($_GPC['do'] == 'sysset' ) { ?><?php  if($_GPC['op']=='trade') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'sysset','do' => 'sysset','m' => 'eshop','op'=>'trade'))?>">交易设置</a>
                                    </li>  
                   
                   
                       <li 	<?php  if($_GPC['act'] == 'modules'&&$_GPC['do']=='payment' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'modules','do' => 'payment','op'=>'list'))?>">支付方式设置</a>
                                    </li>  
                                    
                      <li 	<?php  if($_GPC['do'] == 'sysset' ) { ?><?php  if($_GPC['op']=='sms') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'sysset','do' => 'sysset','m' => 'eshop','op'=>'sms'))?>">短信设置</a>
                                    </li>  
                                    
</ul>

<h3>
						<i class="main_i_icon1 fa fa-location-arrow">&nbsp;</i>入口设置
					</h3>
<ul>
		 <li 	<?php  if($_GPC['act'] == 'entry'&&$_GPC['do'] == 'shopindex' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'shopindex'))?>">商城入口</a>
                                    </li>  
                       <li 	<?php  if($_GPC['act'] == 'entry'&&$_GPC['do'] == 'order' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'order'))?>">会员订单入口</a>
                                    </li>  
                                        <li 	<?php  if($_GPC['act'] == 'entry'&&$_GPC['do'] == 'cart' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'cart'))?>">购物车入口</a>
                                    </li>  
                                        <li 	<?php  if($_GPC['act'] == 'entry'&&$_GPC['do'] == 'member' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'member'))?>">会员中心入口</a>
                                    </li>  
                                    
                                        <li 	<?php  if($_GPC['act'] == 'entry'&&$_GPC['do'] == 'goods' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'goods'))?>">商品入口</a>
                                    </li> 
                                        <li 	<?php  if($_GPC['act'] == 'entry'&&$_GPC['do'] == 'notice' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'notice'))?>">公告入口</a>
                                    </li> 
                                        <li 	<?php  if($_GPC['act'] == 'entry'&&$_GPC['do'] == 'phb' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'phb'))?>">排行榜入口</a>
                                    </li> 
                                         <li 	<?php  if($_GPC['act'] == 'entry'&&$_GPC['do'] == 'article' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'article'))?>">文章列表入口</a>
                                    </li> 
                                    
                                          <li 	<?php  if($_GPC['act'] == 'entry'&&$_GPC['do'] == 'coupon' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'coupon'))?>">领券中心入口</a>
                                    </li>  
                                      <li 	<?php  if($_GPC['act'] == 'entry'&&$_GPC['do'] == 'verify' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'verify'))?>">核销员入口</a>
                                    </li> 
                                        <li 	<?php  if($_GPC['act'] == 'entry'&&$_GPC['do'] == 'commission' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'commission'))?>">分销中心入口</a>
                                    </li> 
	</ul>