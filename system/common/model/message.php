<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}
if (!class_exists('MessageModel')) {
class MessageModel
{
    public function sendTplNotice($touser, $template_id, $postdata, $url = '', $account = null)
    {
        if (!$account) {
            $account = m('common')->getAccount();
        }
        if (!$account) {
            return;
        }
        return $account->sendTplNotice($touser, $template_id, $postdata, $url);
    }
    public function sendCustomNotice($openid, $msg, $url = '', $account = null)
    { 
            if (!$account) {
                $account = m('common')->getAccount();
            }
    
            if (!$account) {
                return;
            }    
            $content = "";
            if (is_array($msg)) {
                foreach ($msg as $key => $value) {
                    if (!empty($value['title'])) {
                        $content .= $value['title'] . ":" . $value['value'] . "\n";
                    } else {
                        $content .= $value['value'] . "\n";
                        if ($key == 0) {
                            $content .= "\n";
                        }
                    }
                }
            } else {
                $content = $msg;
            }
            if (!empty($url)) {
                $content .= "<a href='{$url}'>点击查看详情</a>";
            }
            return $account->sendCustomNotice(array(
                "touser" => $openid,
                "msgtype" => "text",
                "text" => array(
                    'content' => urlencode($content)
                )
            ));
       
    }
    public function sendImage($openid, $mediaid)
    {
        $account = m('common')->getAccount();
        return $account->sendCustomNotice(array(
            "touser" => $openid,
            "msgtype" => "image",
            "image" => array(
                'media_id' => $mediaid
            )
        ));
    }
	public function sendNews($openid, $articles, $account = null)
	{
		if (!$account) {
			$account = m('common')->getAccount();
		}
		return $account->sendCustomNotice(array('touser' => $openid, 'msgtype' => 'news', 'news' => array('articles' => $articles)));
	}
}
}