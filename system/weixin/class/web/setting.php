<?php
	
$settings=globalSetting('weixin');

		
 if (checksubmit()) {
            $cfg = array(
               'weixinname' => $_GP['weixinname'],
                'weixintoken' => trim($_GP['weixintoken']),
                'EncodingAESKey' => trim($_GP['EncodingAESKey']),
						  	'weixin_appId' => trim($_GP['weixin_appId']),
				   		  'weixin_appSecret' => trim($_GP['weixin_appSecret']),
				   		  'weixin_shareaddress'=> intval($_GP['weixin_shareaddress']),
				   		  'weixin_noaccess'=> intval($_GP['weixin_noaccess'])
            );
    
        if (!empty($_FILES['weixin_verify_file']['tmp_name'])) {
            $file=$_FILES['weixin_verify_file'];
     
	$extention = pathinfo($file['name'], PATHINFO_EXTENSION);
		$extention=strtolower($extention);
  	if($extention=='txt')
  	{
  		       $substr=substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
  		       if(empty( $substr))
  		       {
  		        $substr="/";	
  		       }
           $verify_root= substr(WEB_ROOT."/",0, strrpos(WEB_ROOT."/", $substr))."/";

  		//file_save($file['tmp_name'],$file['name'],$extention,$verify_root.$file['name'],$verify_root.$file['name'],false);
  		  		file_save($file['tmp_name'],$file['name'],$extention,WEB_ROOT."/".$file['name'],WEB_ROOT."/".$file['name'],false);
  		  		
  		  		if($verify_root!=WEB_ROOT."/")
  		  		{
  		  			copy(WEB_ROOT."/".$file['name'],$verify_root."/".$file['name']);
  		  		}
  		  		
  		 $cfg['weixin_hasverify']=$file['name'];
  	}else
  	{
  	message("不允许上传除txt结尾以外的文件");	
  	}
      }
     
          
         $cfg['weixin_access_token']="";
         
          refreshSetting($cfg,'weixin');
            message('保存成功', 'refresh', 'success');
        }
        if(empty($settings['weixintoken']))
        {
        $isfirst=true;	
        }

			include page('setting');