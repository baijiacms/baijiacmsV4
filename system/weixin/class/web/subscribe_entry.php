<?php
	
$settings=globalSetting('weixin');

		
 if (checksubmit()) {
            $cfg = array(
               'subscribe_keyword' => $_GP['subscribe_keyword'],
                'default_keyword' => $_GP['default_keyword']
            );
        
         
         	 refreshSetting($cfg,'weixin');
            message('保存成功', 'refresh', 'success');
        }

			include page('subscribe_entry');