<?php
	
$settings=globalSetting('qq');

		
 if (checksubmit()) {
            $cfg = array(
                'fastlogin_appid' => trim($_GP['fastlogin_appid']),
                'fastlogin_appkey' => trim($_GP['fastlogin_appkey']),
                 'fastlogin_open' => intval($_GP['fastlogin_open'])
            );
    
         $cfg['qq_access_token']="";
         
          refreshSetting($cfg,'qq');
            message('保存成功', 'refresh', 'success');
        }

			include page('fastlogin');