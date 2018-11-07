<?php defined('IN_IA') or exit('Access Denied');?>
<h3>
						<i class="main_i_icon1 fa fa-laptop">&nbsp;</i>订单管理
					</h3>         	      
<ul>
	
              <li 	<?php  if($_GPC['do'] == 'order' ) { ?><?php  if($operation == 'display' && $status == '' ) { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'list','do' => 'order','m' => 'eshop','op' => 'display','memberid'=>$_GPC['memberid']))?>">全部订单(<?php  echo $totals['all'];?>) </a>
                                    </li>  
                     <li <?php  if($_GPC['do'] == 'order' ) { ?> <?php  if($operation == 'display' && $status == '0') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'list','do' => 'order','m' => 'eshop','op' => 'display', 'status' => 0,'memberid'=>$_GPC['memberid']))?>" >待付款(<?php  echo $totals['status0'];?>) </a>
                                    </li>  
                                    
                                         <li <?php  if($_GPC['do'] == 'order' ) { ?> <?php  if($operation == 'display' && $status == '1') { ?> class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'list','do' => 'order','m' => 'eshop','op' => 'display', 'status' => 1,'memberid'=>$_GPC['memberid']))?>">待发货(<?php  echo $totals['status1'];?>) </a>
                                    </li>  
                                       <li <?php  if($_GPC['do'] == 'order' ) { ?> <?php  if($operation == 'display' && $status == '2') { ?>class="current"<?php  } ?> <?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'list','do' => 'order','m' => 'eshop','op' => 'display', 'status' => 2,'memberid'=>$_GPC['memberid']))?>">待收货(<?php  echo $totals['status2'];?>) </a>
                                    </li>  
                                    
                                        <li <?php  if($_GPC['do'] == 'order' ) { ?> <?php  if($operation == 'display' && $status == '3') { ?>class="current"<?php  } ?> <?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'list','do' => 'order','m' => 'eshop','op' => 'display', 'status' => 3,'memberid'=>$_GPC['memberid']))?>" >已完成(<?php  echo $totals['status3'];?>) </a>
                                    </li>  
                                        <li <?php  if($_GPC['do'] == 'order' ) { ?> <?php  if($operation == 'display' && $status == '-1') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'list','do' => 'order','m' => 'eshop','op' => 'display', 'status' => -1,'memberid'=>$_GPC['memberid']))?>" >已关闭(<?php  echo $totals['status_1'];?>) </a>
                                    </li>  
                                    
                                        <li <?php  if($_GPC['do'] == 'order' ) { ?> <?php  if($operation == 'display' && $status== '4') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'list','do' => 'order','m' => 'eshop','op' => 'display', 'status' => 4,'memberid'=>$_GPC['memberid']))?>" >退款申请(<?php  echo $totals['status4'];?>) </a>
                                    </li>  
                                    
                                        <li <?php  if($_GPC['do'] == 'order' ) { ?> <?php  if($operation == 'display' && $status == '5') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'list','do' => 'order','m' => 'eshop','op' => 'display', 'status' => 5,'memberid'=>$_GPC['memberid']))?>" >已退款(<?php  echo $totals['status5'];?>)</a>
                                    </li>  
	</ul>