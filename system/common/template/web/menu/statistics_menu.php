<?php defined('IN_IA') or exit('Access Denied');?>
<h3>
						<i class="main_i_icon1 fa fa-bar-chart">&nbsp;</i>数据统计
					</h3>
	<ul>
              <li 	<?php  if($_GPC['do'] == 'statistics' ) { ?><?php  if($_GPC['act'] == 'sale' || empty($_GPC['act'])) { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'sale','do' => 'statistics','m' => 'eshop'))?>">销售统计</a>
                                    </li>  
                   
                     <li 	<?php  if($_GPC['do'] == 'statistics' ) { ?><?php  if($_GPC['act'] == 'sale_analysis') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'sale_analysis','do' => 'statistics','m' => 'eshop'))?>">销售指标</a>
                                    </li>  
                   
                       <li 	<?php  if($_GPC['do'] == 'statistics' ) { ?><?php  if($_GPC['act'] == 'order') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'order','do' => 'statistics','m' => 'eshop'))?>">订单统计</a>
                                    </li>
                                    
                                                 <li 	<?php  if($_GPC['do'] == 'statistics' ) { ?><?php  if($_GPC['act'] == 'goods') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'goods','do' => 'statistics','m' => 'eshop'))?>">商品销售明细</a>
                                    </li>  
                                                 <li 	<?php  if($_GPC['do'] == 'statistics' ) { ?><?php  if($_GPC['act'] == 'goods_rank') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'goods_rank','do' => 'statistics','m' => 'eshop'))?>">商品销售排行</a>
                                    </li>  
                                         <li 	<?php  if($_GPC['do'] == 'statistics' ) { ?><?php  if($_GPC['act'] == 'goods_trans') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'goods_trans','do' => 'statistics','m' => 'eshop'))?>">商品销售转化率</a>
                                    </li>  
                                    
                                      <li 	<?php  if($_GPC['do'] == 'statistics' ) { ?><?php  if($_GPC['act'] == 'member_cost') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'member_cost','do' => 'statistics','m' => 'eshop'))?>">会员消费排行</a>
                                    </li>  
                                         <li 	<?php  if($_GPC['do'] == 'statistics' ) { ?><?php  if($_GPC['act'] == 'member_increase') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'member_increase','do' => 'statistics','m' => 'eshop'))?>">会员增长趋势</a>
                                    </li>  
</ul>
                   
                   