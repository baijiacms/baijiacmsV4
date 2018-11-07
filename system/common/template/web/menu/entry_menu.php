<?php defined('IN_IA') or exit('Access Denied');?>

<h3>
						<i class="main_i_icon1  fa fa-mail-reply">&nbsp;</i>消息回复
					</h3>
<ul>
	 <li 	<?php  if($_GPC['act'] == 'entry'&&$_GPC['do'] == 'reply'&&$_GPC['rtype'] == 'basic'  ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'reply','rtype'=>'basic'))?>">文字回复</a>
                                    </li>  
                       <li 	<?php  if($_GPC['act'] == 'entry'&&$_GPC['do'] == 'reply' &&$_GPC['rtype'] == 'news'  ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'entry','do' => 'reply','rtype'=>'news'))?>">图文回复</a>
                                    </li>  
	</ul>
              
	<h3>
						<i class="main_i_icon1  fa fa-mail-reply">&nbsp;</i>QQ接入设置
					</h3>
<ul>
	    <li 	<?php  if($_GPC['act'] == 'qq'&&$_GPC['do'] == 'fastlogin' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'qq','do' => 'fastlogin'))?>">QQ快捷登陆</a>
                                    </li>  
	</ul>
                   
         <h3>
						<i class="main_i_icon1 fa fa-wechat">&nbsp;</i>微信设置
					</h3>      
<ul>

            
                                          
              <li 	<?php  if($_GPC['act'] == 'weixin'&&$_GPC['do'] == 'setting' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'weixin','do' => 'setting'))?>">微信号设置</a>
                                    </li>  
                       <li 	<?php  if($_GPC['act'] == 'weixin'&&$_GPC['do'] == 'designer' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'weixin','do' => 'designer'))?>">菜单管理</a>
                                    </li>  
                                    
                                         <li 	<?php  if($_GPC['act'] == 'weixin'&&$_GPC['do'] == 'subscribe_entry' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'weixin','do' => 'subscribe_entry'))?>">通用事件回复</a>
                                    </li>  
                                        <li 	<?php  if($_GPC['act'] == 'weixin'&&$_GPC['do'] == 'follow'  ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'weixin','do' => 'follow'))?>">引导及分享设置</a>
                                    </li>  
                                    
                                 <li 	<?php  if($_GPC['act'] == 'weixin'&&$_GPC['do'] == 'virtual_send_notice' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'weixin','do' => 'virtual_send_notice'))?>">虚拟物品通知设置</a>
                                    </li>               
                       <li 	<?php  if($_GPC['act'] == 'weixin'&&$_GPC['do'] == 'coupon_send_notice' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'weixin','do' => 'coupon_send_notice'))?>"> 优惠券通知设置</a>
                                    </li>   
                                    
                                          <li 	<?php  if($_GPC['act'] == 'weixin'&&$_GPC['do'] == 'commission_notice' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'weixin','do' => 'commission_notice'))?>"> 分销通知设置</a>
                                    </li>  
                                    
                                    
                                      <li 	<?php  if($_GPC['act'] == 'weixin'&&$_GPC['do'] == 'sysset_notice' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'weixin','do' => 'sysset_notice'))?>">订单通知设置</a>
                                    </li>  
                                    
	</ul>


	