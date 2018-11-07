<?php
defined('SYSTEM_IN') or exit('Access Denied');

abstract class BJexModule {
	
	
	protected function createMobileUrl($do, $query = array(), $noredirect = true) {
		global $_W;
		$query['do'] = $do;
		if(empty($query['act']))
		{
			$query['act']='index';
		}
		$query['m'] = strtolower($this->modulename);
		return create_url('mobile', $query);
	}

	
	protected function createWebUrl($do, $query = array()) {
		$query['do'] = $do;
		$query['m'] = strtolower($this->modulename);
		return create_url('site', $query);
	}

	
	protected function template($filename) {
		global $_W;
		$name = strtolower($this->modulename);
		$defineDir = dirname($this->__define);
		if(defined('IN_SYS')) {
							$source = $defineDir . "/template/{$filename}.php";
	
		} else {			
			$source = $defineDir . "/template/mobile/{$filename}.php";
		}
		if(!is_file($source)) {
			exit("Error: template source '{$filename}' is not exist!");
		}
		
		return $source;
	}
	
	
	
	

}