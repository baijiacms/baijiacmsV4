<?php	
if (!defined("IN_IA")) {
    exit("Access Denied");
}

if(empty($_GP['pageid']))
{
exit;
}
$diypage = mysqld_select("SELECT * FROM " . table('eshop_designer')." where uniacid=:uniacid and id=:id",array(':uniacid'=> $_CMS['beid'],':id'=>$_GP['pageid'] ) );
	if(!empty($diypage['id']))
  			{
  			
  					$data=str_replace('__ATTACHMENT__',ATTACHMENT_WEBROOT,$diypage['datas']);
	
				 		$diypage['datas']=$data;
				 		$diypage['pageinfo']=unserialize($diypage['pageinfo']);
							include page('diypage');
							exit;
				
			}