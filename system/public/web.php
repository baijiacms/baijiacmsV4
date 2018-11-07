<?php
defined('SYSTEM_IN') or exit('Access Denied');

class publicAddons  extends BjSystemModule {
	public function do_file()
	{
		$this->__web(__FUNCTION__);
	}
	public function do_isaddons()
	{
			global $_CMS,$_GP,$_W,$_GPC;
		$_CMS['isaddons']=1;
		include page('addons');
	}
	public function do_shop_index()
	{
		 header("location:".create_url('site',array('act' => 'eshop','do' => 'index','beid'=> $_CMS['beid'],'m'=>'eshop'))) ;	
	}
		public function do_selectlink()
	{
		$this->__web(__FUNCTION__);
	}
		public function do_changepwd()
	{
		$this->__web(__FUNCTION__);
	}
	

}