<?php defined('IN_IA') or exit('Access Denied');?>
              <h3>
						<i class="main_i_icon1 fa fa-users">&nbsp;</i>会员管理
					</h3>     
<ul>
	<li <?php  if($_GPC['do'] == 'member' ) { ?><?php  if(($_GPC['act'] == 'list' || empty($_GPC['act']))) { ?> class="current" <?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'list','do' => 'member','m' => 'eshop','isagent'=>0))?>">会员管理 </a>
                                    </li>  
                     <li <?php  if($_GPC['do'] == 'member' ) { ?><?php  if($_GPC['act'] == 'level') { ?> class="current" <?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'level','do' => 'member','m' => 'eshop'))?>" >会员等级 </a>
                                    </li>  
                                    
                                         <li <?php  if($_GPC['do'] == 'member' ) { ?><?php  if($_GPC['act'] == 'group') { ?> class="current" <?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'group','do' => 'member','m' => 'eshop'))?>">会员分组 </a>
                                    </li> 
	</ul>
					
<h3>
<i class="main_i_icon1 fa fa-money">&nbsp;</i>充值与提现
</h3>  
<ul>     
	<li <?php  if($_GPC['do'] == 'finance' ) { ?><?php  if(empty($_GPC['act']) || ( $_GPC['act'] == 'log' && $_GPC['type']==0)) { ?> class="current" <?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'log','do' => 'finance','m' => 'eshop','type'=>0))?>">充值记录 </a>
                                    </li>  
                     <li <?php  if($_GPC['do'] == 'finance' ) { ?><?php  if($_GPC['act'] == 'log' && $_GPC['type']==1) { ?> class="current" <?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'log','do' => 'finance','m' => 'eshop','type'=>1))?>" >提现申请 </a>
                                    </li>  
	</ul>    
<h3>
<i class="main_i_icon1 fa fa-money">&nbsp;</i>优惠抵扣
</h3>  
                   
     <ul> 
     	 <li 	<?php  if(($_GPC['do'] == 'coupon') ) { ?> <?php  if($_GPC['act']=='coupon') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('do' => 'coupon','m' => 'eshop','act'=>'coupon'))?>">优惠券管理 </a>
                                    </li>  
 <li 	<?php  if(($_GPC['do'] == 'sale') ) { ?> <?php  if($_GPC['act']=='deduct') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('do' => 'sale','m' => 'eshop','act'=>'deduct'))?>">抵扣设置 </a>
                                    </li>  
                                    
                                     <li 	<?php  if(($_GPC['do'] == 'sale') ) { ?> <?php  if($_GPC['act']=='enough') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('do' => 'sale','m' => 'eshop','act'=>'enough'))?>">满额优惠设置 </a>
                                    </li>  
                                    
                                     
     	
     	</ul>       