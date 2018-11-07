<?php
defined('SYSTEM_IN') or exit('Access Denied');
abstract class BjSystemModule {
		public function __web($f_name){
			global $_CMS,$_GP,$_W,$_GPC;
					if(empty($_CMS['beid']))
			{
			message("未找到站点ID");	
			}
		
				
			$filephp=$_CMS['module'].'/class/web/'.strtolower(substr($f_name,3)).'.php';
	
					include_once  SYSTEM_ROOT.$filephp;
		}
		
		
		
		public function __managerweb($f_name){
		global $_CMS,$_GP,$_W,$_GPC;
			$filephp=$_CMS['module'].'/class/web/'.strtolower(substr($f_name,3)).'.php';

					include_once  SYSTEM_ROOT.$filephp;
		}

		
}