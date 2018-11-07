<?php	
if (!defined("IN_IA")) {
    exit("Access Denied");
}
$diypage = mysqld_select("SELECT * FROM " . table('eshop_designer')." where uniacid=:uniacid and pagetype=1 order by setdefault desc limit 1",array(':uniacid'=> $_CMS['beid']) );
	
		if(!empty($diypage['id']))
  			{
  						$data=str_replace('__ATTACHMENT__',ATTACHMENT_WEBROOT,$diypage['datas']);
	
				 		$diypage['datas']=$data;
				 				 		$diypage['pageinfo']=unserialize($diypage['pageinfo']);
							include page('diypage');
							exit;
				}else
				{
				message("请先在后台进行店铺装修，新建一个店铺首页",create_url('mobile',array('act' => 'public','do' => 'index')),'error');
				}