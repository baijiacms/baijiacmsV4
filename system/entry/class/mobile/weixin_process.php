<?php

		$settings=globalSetting('weixin');
    if(!$this->checkSign($settings['weixintoken']))
      	{
     	exit('Access Denied');
      	}
    if(strtolower($_SERVER['REQUEST_METHOD']) == 'get') {
			ob_clean();
			ob_start();
			exit($_GET['echostr']);
		}
		if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
			$message=$this->requestParse($postStr);
				if (empty($message)) {
				exit('Request Failed');
			}
				$fans = mysqld_select('SELECT * FROM '.table('weixin_fans')."   WHERE  weixin_openid = :weixin_openid and uniacid=:uniacid limit 1" , array(':weixin_openid' =>$message['from'],':uniacid'=>$_CMS['beid']));
					
			if($message['type']=='subscribe'||(($message['type']=='text'||$message['type']=='CLICK')))
			{
					 		
						if(!empty($message['from']))
						{
							 $weixinopenid=$message['from'];	
							 register_snsapi_userinfo($weixinopenid,false);		
							 $newopenid=register_from_wxfans($weixinopenid);
							if($message['type']=='subscribe')
								{
									if(!empty($newopenid))
									{
													$this->responseSubscribe($message['ticket'],$newopenid,true,$message['from']);
									}
								 }
							
						}
						
						
			}
				if($message['type']=='unsubscribe')
			{
							mysqld_update('weixin_fans',array('follow'=>0),array('weixin_openid'=>$message['from'],'uniacid'=>$_CMS['beid']));
							echo $this->respService($message);
							exit;
			}
			
		
		
			if($message['type']=='subscribe'||$message['type']=='text'||$message['type']=='CLICK')
			{
				$key=$message['content'];
				if($message['type']=='CLICK')
				{
									$key=$message['eventkey'];
				}
					if($message['type']=='subscribe')
				{
							$key=$settings['subscribe_keyword'];
				}
				
			$eshop_poster = mysqld_select('SELECT * FROM '.table('eshop_poster')."   WHERE  keyword = :keyword and uniacid=:uniacid order by isdefault desc limit 1" , array(':keyword' =>$key,':uniacid'=>$_CMS['beid']));
			if(!empty($eshop_poster['id']))
			{
						$t_base_member = mysqld_select('SELECT openid FROM '.table('base_member')."   WHERE  weixin_openid = :weixin_openid and beid=:beid limit 1" , array(':weixin_openid' =>$message['from'],':beid'=>$_CMS['beid']));
					if(!empty($t_base_member['openid']))
					{
				 		checkAgent(0,$t_base_member['openid'],0,false);
				 				
				 	}else
				 	{
				 			echo $this->respText('您还不是会员无法生成二维码',$message);
				 						exit;	
				 	}
				$returnjson=p('poster')->build($message['from'],$eshop_poster['id']);
						
				$returnjson = @json_decode($returnjson, true);
				
				if($returnjson['status']==2)
				{
					 echo $this->respText($returnjson['result'],$message);
					 exit;	
				}else if($returnjson['status']==1)
				{
						 echo $this->respImage($returnjson['result'],$message);
						 	 exit;
				}
				if($returnjson['status']==0)
				{
					 echo $this->respText($returnjson['result'],$message);
					 	 exit;
				}
				echo $this->respText('您还不是会员无法生成二维码',$message);
					 exit;
			}
		
				
			$rule = mysqld_select('SELECT * FROM '.table('rule')."   WHERE  keyword = :keyword and uniacid=:uniacid and status=1 limit 1" , array(':keyword' =>$key,':uniacid'=>$_CMS['beid']));
			
			if(empty($rule['id']))
				{
						$key=$settings['default_keyword'];
						$rule = mysqld_select('SELECT * FROM '.table('rule')."   WHERE  keyword = :keyword and uniacid=:uniacid and status=1 limit 1" , array(':keyword' =>$key,':uniacid'=>$_CMS['beid']));
		
				}
			
				if(!empty($rule['id']))
				{
						if($rule['module']=='basic')
						{
								$rule_basic_reply = mysqld_select('SELECT content FROM '.table('rule_basic_reply')."   WHERE  rid = :rid limit 1" , array(':rid' =>$rule['id']));
			
		 echo $this->respText($rule_basic_reply['content'],$message);				
		 exit;
						}
						
						if($rule['module']=='entry')
						{
								$rule_entry_reply = mysqld_select('SELECT * FROM '.table('rule_entry_reply')."   WHERE  rid = :rid limit 1" , array(':rid' =>$rule['id']));
						
						$rule_entry_reply_news=array('title'=>empty($rule_entry_reply['title'])?"无标题":$rule_entry_reply['title'],
						'picurl'=>$rule_entry_reply['thumb'],
						'url'=>$rule_entry_reply['url'],
						'description'=>$rule_entry_reply['description']
						);
						 echo  $this->respNews($rule_entry_reply_news,$message);
						 exit;
						}
						
						if($rule['module']=='news')
						{
								$rule_news_reply = mysqld_selectall('SELECT * FROM '.table('rule_news_reply')."   WHERE  rid = :rid order by parent_id" , array(':rid' =>$rule['id']));
							$rule_news_reply_news=array();
							
							foreach ($rule_news_reply as $row) {
							$rule_news_reply_news[]=	array('title'=>empty($row['title'])?"无标题":$row['title'],
						'picurl'=>$row['thumb'],
						'url'=>$row['url'],
						'description'=>$row['description']
						 );
							}
								 echo $this->respNews($rule_news_reply_news,$message);		
							exit;
							
						}
						
						
						
				}
				
				
				
				
		}
			
			
						echo $this->respService($message);
						exit;
		}