<?php defined('IN_IA') or exit('Access Denied');?>
<h3>
			<i class="main_i_icon1 fa fa-share-alt">&nbsp;</i>分销
</h3>
<ul>
					
              <li 	<?php  if($_GPC['do'] == 'commission') { ?><?php  if($_GPC['act']=='agent') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('do' => 'commission','m' => 'eshop','act'=>'agent'))?>">分销商管理</a>
                                    </li>  
                                   
                               <li 	<?php  if($_GPC['do'] == 'commission') { ?><?php  if($_GPC['act']=='apply' && ($_GPC['status']==1 || $apply['status']==1)) { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('do' => 'commission','m' => 'eshop','act'=>'apply','status'=>1))?>">待审核提现申请</a>
                                    </li>     
                                       <li 	<?php  if($_GPC['do'] == 'commission') { ?><?php  if($_GPC['act']=='apply' && ($_GPC['status']==2 || $apply['status']==2)) { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('do' => 'commission','m' => 'eshop','act'=>'apply','status'=>2))?>">待打款提现申请</a>
                                    </li>        
                      <li 	<?php  if($_GPC['do'] == 'commission') { ?><?php  if($_GPC['act']=='apply' && ($_GPC['status']==3 || $apply['status']==3)) { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('do' => 'commission','m' => 'eshop','act'=>'apply','status'=>3))?>">已打款提现申请</a>
                                    </li>    
                                 
                                    <li 	<?php  if($_GPC['do'] == 'commission') { ?><?php  if($_GPC['act']=='apply' && ($_GPC['status']==-1 || $apply['status']==-1)) { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('do' => 'commission','m' => 'eshop','act'=>'apply','status'=>-1))?>">无效提现申请</a>
                                    </li>   
               <li 	<?php  if($_GPC['do'] == 'commission') { ?><?php  if($_GPC['act']=='increase') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('do' => 'commission','m' => 'eshop','act'=>'increase'))?>">分销商增长趋势统计</a>
                                    </li>   
                                     
                                          <li 	<?php  if($_GPC['do'] == 'commission') { ?><?php  if($_GPC['act']=='level') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('do' => 'commission','m' => 'eshop','act'=>'level'))?>">分销商等级</a>
                                    </li>  
                                    
                                         <li 	<?php  if($_GPC['do'] == 'commission') { ?><?php  if($_GPC['act']=='set') { ?>class="current"<?php  } ?><?php  } ?>>
                    <a href="<?php  echo create_url('site',array('do' => 'commission','m' => 'eshop','act'=>'set'))?>">基础设置</a>
                                    </li>          
                               
</ul>
<h3>
	<i class="main_i_icon1 fa fa-file-image-o">&nbsp;</i>推广海报
</h3>
<ul>
    <li 	<?php  if($_GPC['do'] == 'poster'&&$_GPC['act']=='index') { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('do' => 'poster','act' => 'index','m' => 'eshop'))?>">推广海报</a>
                                    </li>         
</ul>
<?php if(false){?>
	<h3>
						<i class="main_i_icon1  fa fa-mail-reply">&nbsp;</i>分销中心-钉钉接入
					</h3>
<ul>
	    <li 	<?php  if($_GPC['act'] == 'dingtalk'&&$_GPC['do'] == 'fastlogin' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site',array('act' => 'dingtalk','do' => 'fastlogin'))?>">钉钉快捷登陆</a>
                                    </li>  
	</ul>
<?php } ?>