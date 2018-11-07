<?php
	
$settings=globalSetting('dingtalk');

		
 if (checksubmit()) {
            $cfg = array(
                'appid' => trim($_GP['appid']),
                'fastlogin_agentID' => trim($_GP['fastlogin_agentID']),
                'fastlogin_corpID' => trim($_GP['fastlogin_corpID']),
                'fastlogin_corpSecret' => trim($_GP['fastlogin_corpSecret']),
                 'fastlogin_open' => intval($_GP['fastlogin_open'])
            );
    
         $cfg['qq_access_token']="";
         
          refreshSetting($cfg,'dingtalk');
            message('保存成功', 'refresh', 'success');
        }

			include page('fastlogin');