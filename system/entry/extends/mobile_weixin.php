<?php
defined('SYSTEM_IN') or exit('Access Denied');
class entryAddons  extends BjSystemModule {
	public function do_process()
		{
			global $_GP;
	
				$this->__mobile("do_weixin_process");
		}
		
	protected	 function respService($message) {
		$response = array();
		$response['FromUserName'] = $message['to'];
		$response['ToUserName'] = $message['from'];
		$response['MsgType'] = 'transfer_customer_service';
		return $this->response($response);
		}
		
		protected function respText($content,$message) {
			if (empty($content)) {
				return error(-1, 'Invaild value');
			}
			if(stripos($content,'./') !== false) {
				preg_match_all('/<a .*?href="(.*?)".*?>/is',$content,$urls);
				if (!empty($urls[1])) {
					foreach ($urls[1] as $url) {
						$content = str_replace($url, $this->buildSiteUrl($url), $content);
					}
				}
			}
			$content = str_replace("\r\n", "\n", $content);
			$response = array();
			$response['FromUserName'] = $message['to'];
			$response['ToUserName'] = $message['from'];
			$response['MsgType'] = 'text';
			$response['Content'] = htmlspecialchars_decode($content);
			preg_match_all('/\[U\+(\\w{4,})\]/i', $response['Content'], $matchArray);
			if(!empty($matchArray[1])) {
				foreach ($matchArray[1] as $emojiUSB) {
					$response['Content'] = str_ireplace("[U+{$emojiUSB}]", $this->utf8_bytes(hexdec($emojiUSB)), $response['Content']);
				}
			}
			return $this->response($response);
		}
		
		protected function utf8_bytes($cp) {
		if ($cp > 0x10000){
					return	chr(0xF0 | (($cp & 0x1C0000) >> 18)).
			chr(0x80 | (($cp & 0x3F000) >> 12)).
			chr(0x80 | (($cp & 0xFC0) >> 6)).
			chr(0x80 | ($cp & 0x3F));
		}else if ($cp > 0x800){
					return	chr(0xE0 | (($cp & 0xF000) >> 12)).
			chr(0x80 | (($cp & 0xFC0) >> 6)).
			chr(0x80 | ($cp & 0x3F));
		}else if ($cp > 0x80){
					return	chr(0xC0 | (($cp & 0x7C0) >> 6)).
			chr(0x80 | ($cp & 0x3F));
		}else{
					return chr($cp);
		}
	}
		
		protected function respImage($mid,$message) {
			if (empty($mid)) {
				return error(-1, 'Invaild value');
			}
			$response = array();
			$response['FromUserName'] = $message['to'];
			$response['ToUserName'] = $message['from'];
			$response['MsgType'] = 'image';
			$response['Image']['MediaId'] = $mid;
			return $this->response($response);
		}
	protected	 function requestParse($message) {
			$packet = array();
			if (!empty($message)){
				$obj = simplexml_load_string($message, 'SimpleXMLElement', LIBXML_NOCDATA);
				if($obj instanceof SimpleXMLElement) {
					$obj = json_decode(json_encode($obj),true);
					
					$packet['from'] = strval($obj['FromUserName']);
					$packet['to'] = strval($obj['ToUserName']);
					$packet['time'] = strval($obj['CreateTime']);
					$packet['type'] = strval($obj['MsgType']);
					$packet['event'] = strval($obj['Event']);
					$packet['eventkey'] = strval($obj['EventKey']);
					foreach ($obj as $variable => $property) {
						if (is_array($property)) {
							$property = array_change_key_case($property);
						}
						$packet[strtolower($variable)] = $property;
					}
					if($packet['type'] == 'event') {
						$packet['type'] = $packet['event'];
					}
				}
			}
			return $packet;
		}
		
		protected function respNews(array $news,$message) {
			if (empty($news) || count($news) > 10) {
				return error(-1, 'Invaild value');
			}
			$news = array_change_key_case($news);
			if (!empty($news['title'])) {
				$news = array($news);
			}
			$response = array();
			$response['FromUserName'] = $message['to'];
			$response['ToUserName'] = $message['from'];
			$response['MsgType'] = 'news';
			$response['ArticleCount'] = count($news);
			$response['Articles'] = array();
			foreach ($news as $row) {
				$response['Articles'][] = array(
					'Title' => $row['title'],
					'Description' => ($response['ArticleCount'] > 1) ? '' : $row['description'],
					'PicUrl' => tomedia($row['picurl']),
					'Url' => $this->buildSiteUrl($row['url']),
					'TagName' => 'item'
				);
			}
			return $this->response($response);
		}
		
		
		protected function buildSiteUrl($url) {
			global $_W;
			if(strexists($url, 'http://') || strexists($url, 'https://')) {
				return $url;
			}
	
			return WEBSITE_ROOT.$url;
	
		}
		 protected function response($packet) {
		
			if (!is_array($packet)) {
				return $packet;
			}
			if(empty($packet['CreateTime'])) {
				$packet['CreateTime'] = TIMESTAMP;
			}
			if(empty($packet['MsgType'])) {
				$packet['MsgType'] = 'text';
			}
			if(empty($packet['FuncFlag'])) {
				$packet['FuncFlag'] = 0;
			} else {
				$packet['FuncFlag'] = 1;
			}
			return $this->array2xml($packet);
		}
			protected function array2xml($arr, $level = 1, $ptagname = '') {
			$s = $level == 1 ? "<xml>" : '';
			foreach($arr as $tagname => $value) {
				if (is_numeric($tagname)) {
					$tagname = $value['TagName'];
					unset($value['TagName']);
				}
				if(!is_array($value)) {
					$s .= "<{$tagname}>".(!is_numeric($value) ? '<![CDATA[' : '').$value.(!is_numeric($value) ? ']]>' : '')."</{$tagname}>";
				} else {
					$s .= "<{$tagname}>".self::array2xml($value, $level + 1)."</{$tagname}>";
				}
			}
			$s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
			return $level == 1 ? $s."</xml>" : $s;
		}
		 protected function checkSign($token) {
			global $_GP;
		 $signature = $_GET["signature"];
	   $timestamp = $_GET["timestamp"];
	   $nonce = $_GET["nonce"];
	        		
			$tmpArr = array($token, $timestamp, $nonce);
			sort($tmpArr, SORT_STRING);
			$tmpStr = implode( $tmpArr );
			$tmpStr = sha1( $tmpStr );
			
			if( $tmpStr == $signature ){
				return true;
			}else{
				return false;
			}
		}
	
	
	
	 protected function responseSubscribe($ticket,$openid,$isnew,$from_user)
    {
        global $_W;
  		
        if (empty($ticket)) {
            return;
        }
         $eshop_member = pdo_fetch('select * from ' . tablename('eshop_member') . ' where  openid=:openid and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'],':openid'=> $openid));
        if (empty($eshop_member['openid'])) {
            return;
        }

        $eshop_poster_qr = $this->getQRByTicket($ticket);
           
        if (empty($eshop_poster_qr)) {
            return false;
        }    
        $eshop_poster = pdo_fetch('select * from ' . tablename('eshop_poster') . ' where id=:id  and uniacid=:uniacid limit 1', array(':id'=>$eshop_poster_qr['acid'],':uniacid' => $_W['uniacid']));
        if (!empty($eshop_poster['id'])&&$isnew) {
            pdo_update('eshop_poster', array('follows' => $eshop_poster['follows'] + 1), array('id' => $eshop_poster['id']));
        }
    
        $member_info = get_member_info($eshop_poster_qr['openid']);
        $eshop_poster_log = pdo_fetch('select * from ' . tablename('eshop_poster_log') . ' where openid=:openid and posterid=:posterid and uniacid=:uniacid limit 1', array(':openid' => $member_info['openid'], ':posterid' => $eshop_poster['id'], ':uniacid' => $_W['uniacid']));
        if (empty($eshop_poster_log) && $openid != $member_info['openid']) {
            $eshop_poster_log = array('uniacid' => $_W['uniacid'], 'posterid' => $eshop_poster['id'], 'openid' =>$eshop_member['openid'], 'from_openid' => $from_user, 'createtime' => time());
            pdo_insert('eshop_poster_log', $eshop_poster_log);
        }
            
        if (!empty($member_info['openid'])&&$openid != $member_info['openid']) {
        	 if ($isnew) {
        	 	
        	 	if(empty($eshop_member['fixagentid']))
        	 	{
        	 		checkAgent($member_info['openid'],$eshop_member['openid'],$eshop_poster['id'],false);
        	// pdo_update('eshop_member', array('agentid'=>$member_info['id']),array('openid'=>$eshop_member['openid']));
        	}
        	}
        }
        
    }
      public function getQRByTicket($ticket = '')
        {
            global $_W;
            if (empty($ticket)) {
                return false;
            }
            $eshop_poster_qrs = pdo_fetch('select * from ' . tablename('eshop_poster_qr') . ' where ticket=:ticket and type=4 limit 1', array(':ticket' => $ticket));
 
            if (empty($eshop_poster_qrs['id'])) {
                return false;
            }else
            {
            	 return $eshop_poster_qrs;
            }
        }

}
