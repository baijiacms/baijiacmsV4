<?php

// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.baijiacms.com All rights reserved.
// +----------------------------------------------------------------------
// | Comments: ftp工具类操作
// +----------------------------------------------------------------------
// | Author: 百家cms <QQ:1987884799> <http://www.baijiacms.com>
// +----------------------------------------------------------------------
defined('SYSTEM_IN') or exit('Access Denied');
require WEB_ROOT . '/includes/lib/aliyun-oss-php-sdk/autoload.php';
use OSS\OssClient;
use OSS\Core\OssUtil;
use OSS\Core\OssException;
  
if(!defined('OSS_ERR_SERVER_DISABLED')) {
	define('OSS_ERR_SERVER_DISABLED', -100);
	define('OSS_ERR_CONFIG_OFF', -101);
	define('OSS_ERR_CONNECT_TO_SERVER', -102);
	define('OSS_ERR_USER_NO_LOGGIN', -103);
	define('OSS_ERR_CHDIR', -104);
	define('OSS_ERR_MKDIR', -105);
	define('OSS_ERR_SOURCE_READ', -106);
	define('OSS_ERR_TARGET_WRITE', -107);
	define('OSS_ERR_OSSEXCEPTION', -108);
}



class baijiacms_oss
{

	var $enabled = false;
	var $config = array();

	var $func;
	var $connectid;
	var $_error;

	function &instance($config = array()) {
		static $object;
		if(empty($object)) {
			$object = new baijiacms_oss($config);
		}
		return $object;
	}

	function __construct($config = array()) {
		$this->set_error(0);
		$this->config = globaSystemSetting();
		$this->enabled = false;
		if(empty($this->config['system_isnetattach']) ) {
			$this->set_error(OSS_ERR_CONFIG_OFF);
		} else {
		
				$this->config['system_oss_access_id'] = $this->config['system_oss_access_id'];
				$this->config['system_oss_access_key'] = $this->config['system_oss_access_key'];
			
				$this->enabled = true;
		}
	}

	function upload($source, $target,$patch) {

		if($this->error()) {
			return 0;
		}

		$ossClient = new OssClient($this->config['system_oss_access_id'],$this->config['system_oss_access_key'], $this->config['system_oss_endpoint'],false);
		try {
		//
			$ossClient->uploadFile($this->config['system_oss_bucket'], $patch.$target, $source,  false);
		 } catch (OssException $e) {
      $this->set_error(OSS_ERR_OSSEXCEPTION);
      return;
    }
	}
	function deletefile($filepatch) {

		if($this->error()) {
			return 0;
		}

		$ossClient = new OssClient($this->config['system_oss_access_id'],$this->config['system_oss_access_key'], $this->config['system_oss_endpoint'],false);
		try {
		//
			$ossClient->deleteObject($this->config['system_oss_bucket'], $filepatch,  false);
		 } catch (OssException $e) {
      $this->set_error(OSS_ERR_OSSEXCEPTION);
      return;
    }
	}
	function set_error($code = 0) {
		$this->_error = $code;
	}

	function error() {
		return $this->_error;
	}

}