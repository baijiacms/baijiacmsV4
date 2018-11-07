<?php
defined('SYSTEM_IN') or exit('Access Denied');
class managerAddons  extends BjSystemModule {
		public function do_license()
	{
		   $this->__managerweb(__FUNCTION__);
	}
	public function do_online_update()
	{
		   $this->__managerweb(__FUNCTION__);
	}
			public function do_update()
	{
    $this->__managerweb(__FUNCTION__);
	}
			public function do_loginstore()
	{
    $this->__managerweb(__FUNCTION__);
	}
			public function do_database()
	{
    $this->__managerweb(__FUNCTION__);
	}
		public function do_main()
	{
		$this->checkVersion();//版本检查更新
  		header("location:".create_url('site', array('act' => 'manager','do' => 'store','op'=>'display')));
								exit;
	}
		public function do_user()
	{
	$this->__managerweb(__FUNCTION__);
	}
	function do_changepwd()
	{
				$this->__managerweb(__FUNCTION__);
	}
		function checkVersion()
	{
		$globalconfig=globaSystemSetting();
		if(intval($globalconfig['system_version'])<intval(CORE_VERSION))
		{
			message("发现最新版本，系统将进行更新！",create_url('site', array('act' => 'manager','do' => 'update','op'=>'toupdate')),"success");
		}
	}

		public function do_store()
	{
		$this->__managerweb(__FUNCTION__);
	}

			public function do_modules()
	{
	$this->__managerweb(__FUNCTION__);
	}
		function do_checkupdate()
	{
			$this->__managerweb(__FUNCTION__);
	}
		function do_netattach()
	{
			$this->__managerweb(__FUNCTION__);
	}
	function do_dev()
	{
			$this->__managerweb(__FUNCTION__);
	}

}


