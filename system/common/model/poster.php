<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
error_reporting(0);
if (!class_exists('PosterModel')) {
    class PosterModel
    {
        public function checkScan()
        {
            global $_W, $_GPC;
            $openid   = m('user')->getOpenid(true);
            $posterid = intval($_GPC['posterid']);
            if (empty($posterid)) {
                return;
            }
            $poster = pdo_fetch('select id,times from ' . tablename('eshop_poster') . ' where id=:id and uniacid=:uniacid limit 1', array(
                ':uniacid' => $_W['uniacid'],
                ':id' => $posterid
            ));
            if (empty($poster)) {
                return;
            }
            $mid = intval($_GPC['shareid']);
            if (empty($mid)) {
                return;
            }
            $parent = m('member')->getMember($mid);
            if (empty($parent)) {
                return;
            }
            $this->scanTime($openid, $parent['openid'], $poster);
        }
        public function scanTime($openid, $from_openid, $poster)
        {
            if ($openid == $from_openid) {
                return;
            }
            global $_W, $_GPC;
            $scancount = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_poster_scan') . ' where openid=:openid  and posterid=:posterid and uniacid=:uniacid limit 1', array(
                ':openid' => $openid,
                ':posterid' => $poster['id'],
                ':uniacid' => $_W['uniacid']
            ));
            if ($scancount <= 0) {
                $scan = array(
                    'uniacid' => $_W['uniacid'],
                    'posterid' => $poster['id'],
                    'openid' => $openid,
                    'from_openid' => $from_openid,
                    'scantime' => time()
                );
                pdo_insert('eshop_poster_scan', $scan);
                pdo_update('eshop_poster', array(
                    'times' => $poster['times'] + 1
                ), array(
                    'id' => $poster['id']
                ));
            }
        }
        public function createCommissionPoster($openid, $goodsid = 0, $upload = false,$posterid=0)
        {
            global $_W;
            $type = 2;
            if (!empty($goodsid)) {
                $type = 3;
            }
            if(empty($posterid))
            {
            $poster = pdo_fetch('select * from ' . tablename('eshop_poster') . ' where uniacid=:uniacid order by isdefault desc limit 1', array(
                ':uniacid' => $_W['uniacid']
            ));
          }else
          {
          	 $poster = pdo_fetch('select * from ' . tablename('eshop_poster') . ' where uniacid=:uniacid and id=:id order by isdefault desc limit 1', array(
                ':uniacid' => $_W['uniacid'],':id'=>$posterid
            ));
          }	
            if (empty($poster)) {
                return '';
            }
            $member = m('member')->getMember($openid);
    
            $qr = $this->getQR($poster, $member, $goodsid);
            if (empty($qr)) {
                return "";
            }
            return $this->createPoster($poster, $member, $qr, $upload );
        }
        
		public function getFixedTicket($poster, $member)
		{
			global $_W, $_GPC;
			$scene_str = md5("eshop_poster:{$_W['uniacid']}:{$member['openid']}:{$poster['id']}");
			$data = '{"action_info":{"scene":{"scene_str":"' . $scene_str . '"} },"action_name":"QR_LIMIT_STR_SCENE"}';
			$access_token = get_weixin_token();
			$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
			$ch1 = curl_init();
			curl_setopt($ch1, CURLOPT_URL, $url);
			curl_setopt($ch1, CURLOPT_POST, 1);
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch1, CURLOPT_POSTFIELDS, $data);
			$res = curl_exec($ch1);
			$content = @json_decode($res, true);
			if (!is_array($content)) {
				return false;
			}
			if (!empty($content['errcode'])) {
				return false;
			}
			$ticket = $content['ticket'];
			return array('barcode' => json_decode($data, true), 'ticket' => $ticket);
		}
        public function getQR($poster, $member, $goodsid = 0)
        {
            global $_W, $_GPC;
            $acid = $poster['id'];  
            if ($poster['type'] == 1) {
                $qrimg = m('qrcode')->createShopQrcode($member['openid'], $poster['id']);
                $qr    = pdo_fetch('select * from ' . tablename('eshop_poster_qr') . ' where openid=:openid and acid=:acid and type=:type limit 1', array(
                    ':openid' => $member['openid'],
                    ':acid' => $poster['id'],
                    ':type' => 1
                ));
                if (empty($qr)) {
                    $qr = array(
                        'acid' => $acid,
                        'openid' => $member['openid'],
                        'type' => 1,
                        'qrimg' => $qrimg
                    );
                    pdo_insert('eshop_poster_qr', $qr);
                    $qr['id'] = pdo_insertid();
                }
                $qr['current_qrimg'] = $qrimg;
                return $qr;
            } else if ($poster['type'] == 4) {
        
               $acid=$poster['id'];
                $qr         = pdo_fetch('select * from ' . tablename('eshop_poster_qr') . ' where openid=:openid and acid=:acid and type=4 limit 1', array(
                    ':openid' => $member['openid'],
                    ':acid' => $acid
                ));
                if (empty($qr)) {
                    $result = $this->getFixedTicket($poster, $member);
            
                    if (empty($result)) {
                        return false;
                    }
                    $barcode    = $result['barcode'];
                    $ticket     = $result['ticket'];
                    $qrimg      = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $ticket;
           	
                    $qr = array(
                        'acid' => $acid,
                        'openid' => $member['openid'],
                        'type' => 4,
                        'sceneid' => $barcode['action_info']['scene']['scene_id'],
                        'ticket' => $result['ticket'],
                        'qrimg' => $qrimg,
                        'url' => $result['url']
                    );
                    pdo_insert('eshop_poster_qr', $qr);
                    $qr['id']            = pdo_insertid();
                    $qr['current_qrimg'] = $qrimg;
                } else {
                    $qr['current_qrimg'] = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $qr['ticket'];
                }
                return $qr;
            }
        }
        public function getRealData($data)
        {
            $data['left']   = intval(str_replace('px', '', $data['left'])) * 2;
            $data['top']    = intval(str_replace('px', '', $data['top'])) * 2;
            $data['width']  = intval(str_replace('px', '', $data['width'])) * 2;
            $data['height'] = intval(str_replace('px', '', $data['height'])) * 2;
            $data['size']   = intval(str_replace('px', '', $data['size'])) * 2;
            $data['src']    = tomedia($data['src']);
            return $data;
        }
        public function createImage($imgurl)
        {
     
            $resp = http_get($imgurl);
            return imagecreatefromstring($resp);
        }
        public function mergeImage($target, $data, $imgurl)
        {
            $img = $this->createImage($imgurl);
            $w   = imagesx($img);
            $h   = imagesy($img);
            imagecopyresized($target, $img, $data['left'], $data['top'], 0, 0, $data['width'], $data['height'], $w, $h);
            imagedestroy($img);
            return $target;
        }
        public function mergeText($target, $data, $text)
        {
            $font   = IA_ROOT . "/assets/eshop/static/fonts/msyh.ttf";
            $colors = $this->hex2rgb($data['color']);
            $color  = imagecolorallocate($target, $colors['red'], $colors['green'], $colors['blue']);
            imagettftext($target, $data['size'], 0, $data['left'], $data['top'] + $data['size'], $color, $font, $text);
            return $target;
        }
        function hex2rgb($colour)
        {
            if ($colour[0] == '#') {
                $colour = substr($colour, 1);
            }
            if (strlen($colour) == 6) {
                list($r, $g, $b) = array(
                    $colour[0] . $colour[1],
                    $colour[2] . $colour[3],
                    $colour[4] . $colour[5]
                );
            } elseif (strlen($colour) == 3) {
                list($r, $g, $b) = array(
                    $colour[0] . $colour[0],
                    $colour[1] . $colour[1],
                    $colour[2] . $colour[2]
                );
            } else {
                return false;
            }
            $r = hexdec($r);
            $g = hexdec($g);
            $b = hexdec($b);
            return array(
                'red' => $r,
                'green' => $g,
                'blue' => $b
            );
        }
        public function createPoster($poster, $member, $qr, $upload = true)
        {
            global $_W;
            $path = IA_ROOT . "/cache/data/" . $_W['uniacid'] . "/";
            if (!is_dir($path)) {
      
                mkdirs($path);
            }
            if (!empty($qr['goodsid'])) {
                $goods = pdo_fetch('select id,title,thumb,commission_thumb,marketprice,productprice from ' . tablename('eshop_goods') . ' where id=:id and uniacid=:uniacid limit 1', array(
                    ':id' => $qr['goodsid'],
                    ':uniacid' => $_W['uniacid']
                ));
                if (empty($goods)) {
                    m('message')->sendCustomNotice($member['openid'], '未找到商品，无法生成海报');
                    exit;
                }
            }
            $md5  = md5(json_encode(array(
                'openid' => $member['openid'],
                'goodsid' => $qr['goodsid'],
		'bg' => $poster['bg'], 
                'data' => $poster['data'],
                'version' => 1
            )));
            $file = $md5 . '.png';
            if (!is_file($path . $file) || $qr['qrimg'] != $qr['current_qrimg']) {     
                set_time_limit(0);
                @ini_set('memory_limit', '256M');
                $target = imagecreatetruecolor(640, 1008);
                $bg     = $this->createImage(tomedia($poster['bg']));
                imagecopy($target, $bg, 0, 0, 0, 0, 640, 1008);
                imagedestroy($bg);
                $data = json_decode(str_replace('&quot;', "'", $poster['data']), true);
                foreach ($data as $d) {
                    $d = $this->getRealData($d);
                    if ($d['type'] == 'head') {
                        $avatar = preg_replace('/\/0$/i', '/96', $member['avatar']);
                        $target = $this->mergeImage($target, $d, $avatar);
                    } else if ($d['type'] == 'img') {
                        $target = $this->mergeImage($target, $d, $d['src']);
                    } else if ($d['type'] == 'qr') {
                        $target = $this->mergeImage($target, $d, tomedia($qr['current_qrimg']));
                    } else if ($d['type'] == 'nickname') {
                        $target = $this->mergeText($target, $d, $member['nickname']);
                    } else {
                        if (!empty($goods)) {
                            if ($d['type'] == 'title') {
                                $target = $this->mergeText($target, $d, $goods['title']);
                            } else if ($d['type'] == 'thumb') {
                                $thumb  = !empty($goods['commission_thumb']) ? tomedia($goods['commission_thumb']) : tomedia($goods['thumb']);
                                $target = $this->mergeImage($target, $d, $thumb);
                            } else if ($d['type'] == 'marketprice') {
                                $target = $this->mergeText($target, $d, $goods['marketprice']);
                            } else if ($d['type'] == 'productprice') {
                                $target = $this->mergeText($target, $d, $goods['productprice']);
                            }
                        }
                    }
                }
                imagejpeg($target, $path . $file);
                imagedestroy($target);
                if ($qr['qrimg'] != $qr['current_qrimg']) {
                    pdo_update('eshop_poster_qr', array(
                        'qrimg' => $qr['current_qrimg']
                    ), array(
                        'id' => $qr['id']
                    ));
                }
            }
          
            $img = WEBSITE_ROOT . "cache/data/" . $_W['uniacid'] . "/" . $file;
            if (!$upload) {
                return $img;
            }
             
            if ($qr['qrimg'] != $qr['current_qrimg'] || empty($qr['mediaid']) || empty($qr['createtime']) || $qr['createtime'] + 3600 * 24 * 3 - 7200 < time()) {
                $mediaid       = $this->uploadImage($path . $file);
                $qr['mediaid'] = $mediaid;
                pdo_update('eshop_poster_qr', array(
                    'mediaid' => $mediaid,
                    'createtime' => time()
                ), array(
                    'id' => $qr['id']
                ));
            }
            return array(
                'img' => $img,
                'mediaid' => $qr['mediaid']
            );
        }
		public function uploadImage($img)
		{

			$access_token=get_weixin_token();
			$url = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type=image";
			$curl = curl_init();
			$data = array('media' => '@' . $img);
			if (version_compare(PHP_VERSION, '5.5.0', '>')) {
				$data = array('media' => curl_file_create($img));
			}
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			$content = @json_decode(curl_exec($curl), true);
			if (!is_array($content)) {
				$content = array('media_id' => '');
			}
			curl_close($curl);
			return $content['media_id'];
		}
  
		
		 public function createGoodsImage($dephp_6, $dephp_86)
        {
            global $_W, $_GPC;
            $dephp_6 = set_medias($dephp_6, 'thumb');
              $dephp_21   = m('user')->getOpenid(true);
            $dephp_87 = m('member')->getMember($dephp_21);
            if ($dephp_87['isagent'] == 1 && $dephp_87['status'] == 1) {
                $dephp_88 = $dephp_87;
            } else {
                $dephp_79 = intval($_GPC['shareid']);
                if (!empty($dephp_79)) {
                    $dephp_88 = m('member')->getMember($dephp_79);
                }
            }
            $dephp_81 = IA_ROOT . '/cache/data/goods/' . $_W['uniacid'] . '/';
            if (!is_dir($dephp_81)) {
                mkdirs($dephp_81);
            }
            $dephp_89 = empty($dephp_6['commission_thumb']) ? $dephp_6['thumb'] : tomedia($dephp_6['commission_thumb']);
            $dephp_90 = md5(json_encode(array('id' => $dephp_6['id'], 'marketprice' => $dephp_6['marketprice'], 'productprice' => $dephp_6['productprice'], 'img' => $dephp_89, 'openid' => $dephp_21, 'version' => 4)));
            $dephp_83 = $dephp_90 . '.jpg';
            if (!is_file($dephp_81 . $dephp_83)) {
                set_time_limit(0);
                $dephp_91 = IA_ROOT . '/assets/eshop/static/fonts/msyh.ttf';
                $dephp_92 = imagecreatetruecolor(640, 1225);
                $dephp_93 = imagecreatefromjpeg(IA_ROOT . '/assets/eshop/static/mobile/static/commission/images/poster.jpg');
                imagecopy($dephp_92, $dephp_93, 0, 0, 0, 0, 640, 1225);
                imagedestroy($dephp_93);
                $dephp_94 = preg_replace('/\\/0$/i', '/96', $dephp_88['avatar']);
                $dephp_95 = $this->createImage($dephp_94);
                $dephp_96 = imagesx($dephp_95);
                $dephp_97 = imagesy($dephp_95);
                imagecopyresized($dephp_92, $dephp_95, 24, 32, 0, 0, 88, 88, $dephp_96, $dephp_97);
                imagedestroy($dephp_95);
                $dephp_98 = $this->createImage($dephp_89);
                $dephp_96 = imagesx($dephp_98);
                $dephp_97 = imagesy($dephp_98);
                imagecopyresized($dephp_92, $dephp_98, 0, 160, 0, 0, 640, 640, $dephp_96, $dephp_97);
                imagedestroy($dephp_98);
                $dephp_99 = imagecreatetruecolor(640, 127);
                imagealphablending($dephp_99, false);
                imagesavealpha($dephp_99, true);
                $dephp_100 = imagecolorallocatealpha($dephp_99, 0, 0, 0, 25);
                imagefill($dephp_99, 0, 0, $dephp_100);
                imagecopy($dephp_92, $dephp_99, 0, 678, 0, 0, 640, 127);
                imagedestroy($dephp_99);
                $dephp_101 = tomedia(m('qrcode')->createGoodsQrcode($dephp_88['id'], $dephp_6['id']));
                $dephp_102 = $this->createImage($dephp_101);
                $dephp_96 = imagesx($dephp_102);
                $dephp_97 = imagesy($dephp_102);
                imagecopyresized($dephp_92, $dephp_102, 50, 835, 0, 0, 250, 250, $dephp_96, $dephp_97);
                imagedestroy($dephp_102);
                $dephp_103 = imagecolorallocate($dephp_92, 0, 3, 51);
                $dephp_104 = imagecolorallocate($dephp_92, 240, 102, 0);
                $dephp_105 = imagecolorallocate($dephp_92, 255, 255, 255);
                $dephp_106 = imagecolorallocate($dephp_92, 255, 255, 0);
                $dephp_107 = '我是';
                imagettftext($dephp_92, 20, 0, 150, 70, $dephp_103, $dephp_91, $dephp_107);
                imagettftext($dephp_92, 20, 0, 210, 70, $dephp_104, $dephp_91, $dephp_88['nickname']);
                $dephp_108 = '我要为';
                imagettftext($dephp_92, 20, 0, 150, 105, $dephp_103, $dephp_91, $dephp_108);
                $dephp_109 = $dephp_86['name'];
                imagettftext($dephp_92, 20, 0, 240, 105, $dephp_104, $dephp_91, $dephp_109);
                $dephp_110 = imagettfbbox(20, 0, $dephp_91, $dephp_109);
                $dephp_111 = $dephp_110[4] - $dephp_110[6];
                $dephp_112 = '代言';
                imagettftext($dephp_92, 20, 0, 240 + $dephp_111 + 10, 105, $dephp_103, $dephp_91, $dephp_112);
                $dephp_113 = mb_substr($dephp_6['title'], 0, 50, 'utf-8');
                imagettftext($dephp_92, 20, 0, 30, 730, $dephp_105, $dephp_91, $dephp_113);
                $dephp_114 = '￥' . number_format($dephp_6['marketprice'], 2);
                imagettftext($dephp_92, 25, 0, 25, 780, $dephp_106, $dephp_91, $dephp_114);
                $dephp_110 = imagettfbbox(26, 0, $dephp_91, $dephp_114);
                $dephp_111 = $dephp_110[4] - $dephp_110[6];
                if ($dephp_6['productprice'] > 0) {
                    $dephp_115 = '￥' . number_format($dephp_6['productprice'], 2);
                    imagettftext($dephp_92, 22, 0, 25 + $dephp_111 + 10, 780, $dephp_105, $dephp_91, $dephp_115);
                    $dephp_116 = 25 + $dephp_111 + 10;
                    $dephp_110 = imagettfbbox(22, 0, $dephp_91, $dephp_115);
                    $dephp_111 = $dephp_110[4] - $dephp_110[6];
                    imageline($dephp_92, $dephp_116, 770, $dephp_116 + $dephp_111 + 20, 770, $dephp_105);
                    imageline($dephp_92, $dephp_116, 771.5, $dephp_116 + $dephp_111 + 20, 771, $dephp_105);
                }
                imagejpeg($dephp_92, $dephp_81 . $dephp_83);
                imagedestroy($dephp_92);
            }
            return WEBSITE_ROOT . 'cache/data/goods/' . $_W['uniacid'] . '/' . $dephp_83;
        }
     	public function build($weixin_openid,$posterid)
     	{
     		      global $_W, $_GPC;
							$base_member = pdo_fetch("select openid from " . tablename("base_member") . " where weixin_openid=:weixin_openid and beid=:beid limit 1", array(
							        ":weixin_openid" =>$weixin_openid,
							        ":beid" => $_W["uniacid"]
							    ));
							if (empty($base_member['openid'])) {
							      return show_json(0,'您不是会员无法生成二维码',false);
							}
							$openid=$base_member['openid'];
							$eshop_member = pdo_fetch("select * from " . tablename("eshop_member") . " where openid=:openid and uniacid=:uniacid limit 1", array(
							        ":openid" =>$base_member['openid'],
							        ":uniacid" => $_W["uniacid"]
							    ));
							if (empty($eshop_member['openid'])) {
							      return show_json(0,'您不是会员无法生成二维码',false);
							}
							
							
							$poster = pdo_fetch("select * from " . tablename("eshop_poster") . " where id=:id and uniacid=:uniacid limit 1", array(
							        ":id" =>$posterid,
							        ":uniacid" => $_W["uniacid"]
							    ));
							    
							 
							if (empty($poster['id'])) {
							      return show_json(0,'未找到相关二维码海报',false);
							}
							
							if(empty(  $poster['isopen']))
							{
								if (empty($eshop_member['isagent'])||empty($eshop_member['status'])) {
								     return  show_json(0,'您不是分销员无法生成二维码',false);
								}
							}
							    
							$waittext = !empty($poster["waittext"]) ? $poster["waittext"] : "您的专属海报正在拼命生成中，请等待片刻...";
							m("message")->sendCustomNotice($openid, $waittext);
							
							  
							$commissionPoster = $this->createCommissionPoster($openid,0,true,$poster['id']);
			
					
							if (!empty($commissionPoster['mediaid'])) {
							    return show_json(1,$commissionPoster['mediaid'],false);
							} else {
								if (!empty($commissionPoster['img'])) {
							    $oktext = "<a href='" .$commissionPoster['img']. "'>点击查看您的专属海报</a>";
							   return show_json(2,$oktext,false);
							  }else
							  {
							  	   return show_json(0,'图片生成失败！',false);
							  }
							}
     	}
       
    
    }
}