<?php

	$system_store = mysqld_select('SELECT id,website,fullwebsite FROM '.table('system_store')." where `id`=:id",array(":id"=>$GLOBALS['_CMS']['beid']));
					if(empty($system_store['fullwebsite']))
					{
					
					$store_website="http://".$system_store['website']."/";
					}else
					{
					$store_website=$system_store['fullwebsite'];
					}
header("Location:".$store_website.create_url('mobile',array('act' => 'modules','do' => 'pay_success')));