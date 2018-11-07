<?php
	define('LOCK_TO_UPDATE', true);	
	 $op = !empty($_GP['op']) ? $_GP['op'] : 'display';
			if($_GP['op']=="toupdate"&&LOCK_TO_UPDATE==true)
			{
				if(is_file(WEB_ROOT.'/system/manager/class/web/updatesql.php'))
					{
						require WEB_ROOT.'/system/manager/class/web/updatesql.php';
					}
					$cfg = array(
				   		       'system_version' => CORE_VERSION
            );
						refreshSystemSetting($cfg);	
					
				
			}
		
		
					message("系统升级完成!",create_url('site', array('act' => 'manager','do' => 'main')),"success");