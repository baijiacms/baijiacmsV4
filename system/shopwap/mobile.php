<?php
defined('SYSTEM_IN') or exit('Access Denied');
class shopwapAddons  extends BjSystemModule {
				public function do_getorder()
	{
			$this->__mobile(__FUNCTION__);
		
	}		
	public function do_account()
	{
			$this->__mobile(__FUNCTION__);
		
	}		
	
		public function do_getgoldorder()
	{
			$this->__mobile(__FUNCTION__);
		
	}
	public function do_forgetpwd()
	{
			$this->__mobile(__FUNCTION__);
		
	}
	public function do_membercenter()
	{
			$this->__mobile(__FUNCTION__);
		
	}
			public function do_info()
	{
			$this->__mobile(__FUNCTION__);
		
	}
		public function do_changepwd()
	{
			$this->__mobile(__FUNCTION__);
		
	}
	public function do_diypage()
	{
			$this->__mobile(__FUNCTION__);
		
	}
		public function do_verifycode()
	{
			$this->__mobile(__FUNCTION__);
		
	}

	   function create_qrcode($homeurl)
  {
  		global $_CMS;
  	$att_target_file = $_CMS['beid'].'shopindex_qrcode.png';
		$qr_dir='/cache/'.SESSION_PREFIX.'/qrcode/url/';
		$qrcode_dir=WEB_ROOT.$qr_dir;
		if(!file_exists($qrcode_dir. $att_target_file))
		{
  	include WEB_ROOT.'/includes/lib/phpqrcode/phpqrcode/phpqrcode.php';//引入PHP QR库文件
		$value=$homeurl;
		$errorCorrectionLevel = "L";
		$matrixPointSize = "4";
		if (!is_dir($qrcode_dir))
		{
			mkdirs($qrcode_dir);
		}
		$target_file = $qrcode_dir. $att_target_file;
		
		QRcode::png($value, $target_file, $errorCorrectionLevel, $matrixPointSize);
		}
  	return 	WEBSITE_ROOT.$qr_dir.$att_target_file;
  }
	public function do_shopindex()
	{
				global $_GP;
			$this->__mobile(__FUNCTION__);
	}

	public function do_logout()
	{
			global $_CMS;
			member_logout();
		
	}
	public function do_register()
	{
		$this->__mobile(__FUNCTION__);
	}
	public function do_login()
	{
		$this->__mobile(__FUNCTION__);
	}
	
	
}


