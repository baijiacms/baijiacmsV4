<?php defined('IN_IA') or exit('Access Denied');?>
<h3>
						<i class="main_i_icon1 fa fa-home">&nbsp;</i>店铺管理
					</h3>
					<ul>
						<li <?php  if($_GPC['act'] == 'manager'&&$_GPC['do'] == 'store') { ?>class="current"<?php  } ?>><a href="<?php  echo create_url('site', array('act' => 'manager','do' => 'store','op'=>'display'))?>">店铺管理</a></li>
						<li <?php  if($_GPC['act'] == 'manager'&&$_GPC['do'] == 'netattach' ) { ?>class="current"<?php  } ?>><a href="<?php  echo create_url('site', array('act' => 'manager','do' => 'netattach'))?>">附件设置</a></li>
						
					</ul>

<h3>
						<i class="main_i_icon1  fa fa-gears">&nbsp;</i>系统管理
					</h3>
					<ul>
					   <li 	<?php  if($_GPC['act'] == 'manager'&&$_GPC['do'] == 'user' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site', array('act' => 'manager','do' => 'user'))?>">系统管理员</a>
                                    </li>  
              <li 	<?php  if($_GPC['act'] == 'manager'&&$_GPC['do'] == 'database' ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site', array('act' => 'manager','do' => 'database'))?>">备份与还原</a>
                                    </li>  
                        <li 	<?php  if($_GPC['act'] == 'manager'&&$_GPC['do'] == 'modules'  ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site', array('act' => 'manager','do' => 'modules'))?>">插件扩展</a>
                                    </li>  
                       <li 	<?php  if($_GPC['act'] == 'manager'&&$_GPC['do'] == 'dev'  ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site', array('act' => 'manager','do' => 'dev'))?>">系统信息</a>
                                    </li>
                      <?php if(false){ ?>
                      <li 	<?php  if($_GPC['act'] == 'manager'&&$_GPC['do'] == 'online_update'  ) { ?>class="current"<?php  } ?>>
                      	<?php 	$t_core_version=http_get("http://update.baijiacms.com/baijiacmsv4/update/core_version.html");
                      	$t_net_core_version=intval($t_core_version);
                      	if(empty($t_net_core_version)||$t_net_core_version==0)
                      	{
                      	$t_net_core_version=	intval(CORE_VERSION);
                      	}
                      		$t_local_core_version=intval(CORE_VERSION);
                      ?>
                    <a href="<?php  echo create_url('site', array('act' => 'manager','do' => 'online_update'))?>">在线更新<?php if($t_local_core_version<$t_net_core_version){ ?><img src="<?php  echo RESOURCE_ROOT;?>public/image/new.gif" style="display:inline;"/><?php  } ?></a>
                                    </li> 
                     <?php } ?>
                                              <li 	<?php  if($_GPC['act'] == 'manager'&&$_GPC['do'] == 'license'  ) { ?>class="current"<?php  } ?>>
                    <a href="<?php  echo create_url('site', array('act' => 'manager','do' => 'license'))?>">授权许可</a>
                                    </li> 
					</ul>