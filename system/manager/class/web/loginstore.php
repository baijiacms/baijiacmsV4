<?php
	$id=$_CMS[WEB_SESSION_ACCOUNT]['id'];
        	$store = getStoreBeid(intval($_GP['beid']));
    if(empty($store['id'])||empty($id))
    {
    message("没有找到相关店铺");	
    }
    if($store['website']==$_SERVER['HTTP_HOST'])
    {
   header("location:".create_url('site',array('act' => 'public','do' => 'shop_index','beid'=> $_GP['beid']))) ;	
   exit;
    }
    $account = mysqld_select('SELECT * FROM '.table('user')." WHERE  id = :id " , array(':id' => $id));
		if(!empty($account['id'])&&!empty($account['is_admin']))
		{
		$loginkey=date('YmdHis') . random(6, 1);
		mysqld_update('user',array('loginkey'=>$loginkey),array('id'=>$id));
				header("location:".(empty($store['fullwebsite'])?('http://'.$store['website'].'/'):$store['fullwebsite']).create_url('mobile', array('beid'=>$store['id'],'act' => 'public','do' => 'login','op'=>'loginkey','loginkey'=>$loginkey)));
		}else
		{
				message("店铺登录失败！");	
		}