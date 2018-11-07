<?php
 $operation = !empty($_GP['op']) ? $_GP['op'] : 'display';
$modules_list=array();
if($operation=='display')
{
$addons = dir(ADDONS_ROOT); 
		while($file = $addons->read())
		{
							if(($file!=".") AND ($file!="..")) 
								{
									
									
										if(is_file(ADDONS_ROOT.$file.'/key.php'))
										{
										 $addons_key=file_get_contents(ADDONS_ROOT.$file.'/key.php');
										 $addons_name=file_get_contents(ADDONS_ROOT.$file.'/appname.php');
										 $addons_version=file_get_contents(ADDONS_ROOT.$file.'/version.php');
												if($file==$addons_key||md5($file)==$addons_key)
												{
													$modules=array('title'=>$addons_name,'name'=>$file,'status'=>0,'version'=>$addons_version);
													$item = mysqld_select("SELECT * FROM " . table('modules')." where `name`=:name", array(':name' => $file));
							       			if(empty($item['name']))
							       			{
							       		
							       				//	message("发现可用插件，系统将进行安装！",create_url('site', array('act' => 'manager','do' => 'addons_update')),"success");
							       			}else
							       			{
							       						$modules['status']=1;
							       				
														if($addons_version>$item['version'])
														{
																		$modules['version']=$item['version'];
														 	$modules['new_version']=$addons_version;
														//		message("发现插件更新，系统将进行更新！",create_url('site', array('act' => 'manager','do' => 'addons_update')),"success");
												$modules['status']=2;
														}
							       			}
							       			array_push($modules_list,$modules);
						      	 		}
						    	  }
						}
		}
}
 if($operation=='install')
 {
 	if(!empty($_GP['module_name']))
 	{
 		define('LOCK_TO_ADDONS_INSTALL',true);
 		require ADDONS_ROOT.$_GP['module_name'].'/installsql.php';
 	}
			 	message('安装成功！','refresh','success');
 }
  if($operation=='uninstall')
 {
 	 	if(!empty($_GP['module_name']))
 	{
 		 		define('LOCK_TO_ADDONS_UNINSTALL',true);
 		require ADDONS_ROOT.$_GP['module_name'].'/uninstallsql.php';
 		$sql = "
delete from `baijiacms_modules` where `name`='".$_GP['module_name']."';
delete from `baijiacms_modules_menu` where `module`='".$_GP['module_name']."';
";
mysqld_batch($sql);
 	}
			 	message('卸载成功！','refresh','success');
 	
 }
 
   if($operation=='update')
 {
 		 	if(!empty($_GP['module_name']))
 	{
 			define('LOCK_TO_ADDONS_UPDATE',true);
 		require ADDONS_ROOT.$_GP['module_name'].'/updatesql.php';
 	}
			  	message('更新成功！','refresh','success');
 	
 }
		include page('modules_list');