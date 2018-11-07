<?php
defined('SYSTEM_IN') or exit('Access Denied');
abstract class BjModule {
	
		public function __web($f_name){
			global $_CMS,$_GP,$modulename,$_W,$_GPC;
						if(empty($_CMS['beid']))
			{
			message("未找到站点ID");	
			}
	
			include_once  ADDONS_ROOT.$modulename.'/class/web/'.strtolower(substr($f_name,3)).'.php';
		}
		public function __mobile($f_name){
			global $_CMS,$_GP,$modulename,$_W,$_GPC;
			
				if(empty($_CMS['beid']))
			{
			message("未找到站点ID");	
			}
		
		include_once  ADDONS_ROOT.$modulename.'/class/mobile/'.strtolower(substr($f_name,3)).'.php';
	}
}
function addons_page($filename) {
			global $modulename;
			if(SYSTEM_ACT=='mobile') {
				$source=ADDONS_ROOT .$modulename."/template/mobile/{$filename}.php";
			}else
			{
					$source=ADDONS_ROOT . $modulename."/template/web/{$filename}.php";
			}
			return $source;
}