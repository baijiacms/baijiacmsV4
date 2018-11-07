<?php

		 $operation = !empty($_GP['op']) ? $_GP['op'] : 'list';
		 if($operation =='list')
		 {
				$addons = dir(WEB_ROOT.'/system/modules/plugin/payment/'); 
				$modules=array();
				$index=0;
				        
				while($file = $addons->read())
				{ 
					if(($file!=".") AND ($file!="..")) 
					{
						$modules[$index]['code']=$file;
						$item = mysqld_select("SELECT * FROM " . table('payment') . " WHERE enabled=1 and code = :code and beid=:beid", array(':code' => $file,":beid"=>$_CMS['beid']));
       			
						require WEB_ROOT.'/system/modules/plugin/payment/'.$file.'/lang.php';
						    if (empty($item['id'])) {
       			    	$modules[$index]['enable']=0;
       			    }else
       			    {
       			    		$modules[$index]['enable']=1;
       			    }
						$index=$index+1;
					}
				}
		include page('payment');
	}
	 if($operation =='install')
		 {
		 	
			$code=$_GP['code'];
			require WEB_ROOT.'/system/modules/plugin/payment/'.$code.'/lang.php';
						

                 $item = mysqld_select("SELECT * FROM " . table('payment') . " WHERE code = :code and beid=:beid", array(':code' => $code,":beid"=>$_CMS['beid']));
              
                 if (empty($item['id'])) {
                 				 $data = array(
                    'code' => $code,
                    'name' => $_LANG['payment_'.$code.'_name'],
                    'desc' => $_LANG['payment_'.$code.'_desc'],
                    'enabled' => '0',
                   'iscod' => $_LANG['payment_'.$code.'_iscod'],
                   'online' => $_LANG['payment_'.$code.'_online'],"beid"=>$_CMS['beid']
                  );
									 mysqld_insert('payment', $data);
                } else {
                				 $data = array(
                    'name' => $_LANG['payment_'.$code.'_name'],
                    'desc' => $_LANG['payment_'.$code.'_desc'],
                   'iscod' => $_LANG['payment_'.$code.'_iscod'],
                   'online' => $_LANG['payment_'.$code.'_online']
                  );
                    mysqld_update('payment',$data , array('code' => $code,"beid"=>$_CMS['beid']));
                }
$this->do_payment_config();
		}
		
			 if($operation =='uninstall')
		 {
		 		$code=$_GP['code'];
			require WEB_ROOT.'/system/modules/plugin/payment/'.$code.'/uninstall.php';
			 	message('关闭成功！','refresh','success');
		}
		
			 if($operation =='config')
		 {
		 				$code=$_GP['code'];
				$settings=globalSetting('payment');
			   if (checksubmit('submit')) {
			   	 require WEB_ROOT.'/system/modules/plugin/payment/'.$code.'/submit.php';
			   	 
				message('保存成功！',create_url('site', array('act' => 'modules','do' => 'payment','op'=>'list')),'success');
			  }
			$item = mysqld_select("SELECT * FROM " . table('payment') . " WHERE code = :code and beid=:beid", array(':code' => $code,":beid"=>$_CMS['beid']));
			$configs = unserialize($item['configs']);
     include WEB_ROOT.'/system/modules/plugin/payment/'.$code.'/config.php';
		}