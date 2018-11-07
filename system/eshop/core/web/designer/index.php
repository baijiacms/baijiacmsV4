<?php
global $_W, $_GPC;
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($op == 'display') {
    $page     = empty($_GPC['page']) ? "" : $_GPC['page'];
    $pindex   = max(1, intval($page));
    $psize    = 10;
    $pages    = pdo_fetchall("SELECT * FROM " . tablename('eshop_designer') . " WHERE uniacid= :uniacid  " . "ORDER BY savetime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(
        ':uniacid' => $_W['uniacid']
    ));
    $pagesnum = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('eshop_designer') . " WHERE uniacid= :uniacid " . "ORDER BY savetime DESC ", array(
        ':uniacid' => $_W['uniacid']
    ));
    $total    = $pagesnum;
    $pager    = pagination($total, $pindex, $psize);
    
include $this->template('index');
exit;
}
$pageid = empty($_GPC['pageid']) ? "" : $_GPC['pageid'];

if($op=='post')
{
	  $diymenu     = pdo_fetchall("SELECT id,menuname as name FROM " . tablename('eshop_designer_menu') . " WHERE uniacid= :uniacid  ", array(
        ':uniacid' => $_W['uniacid']
    ));
	
	       $page = pdo_fetch("SELECT * FROM " . tablename('eshop_designer') . " WHERE uniacid= :uniacid and id=:id", array(
            ':uniacid' => $_W['uniacid'],
            ':id' => $pageid
        ));
	      if (!empty($pageid)) {

  if(!empty($page['datas']))
  {
  	$data=$page['datas'];
		$data=str_replace('__ATTACHMENT__',ATTACHMENT_WEBROOT,$data);
	//	 $data=unserialize($data);
 	$page['datas']=$data;
 	  if(!empty($diymenu))
  {
 $page['diymenu']=json_encode($diymenu);
}
}
	
}
	include $this->template('diypage');
exit;
}

if($op=='save')
{
	 $data  = $_GPC['data'];
	 $id = intval($pageid);
	
$page = pdo_fetch("SELECT * FROM " . tablename('eshop_designer') . " WHERE uniacid= :uniacid and id=:id", array(
            ':uniacid' => $_W['uniacid'],
            ':id' => $id
        ));
 $newdata=json_encode($data);
		$newdata=str_replace(ATTACHMENT_WEBROOT,'__ATTACHMENT__',$newdata);
$pagetype=intval($data['page']['pagetype']);
$setdefault=0;
if(!empty($pagetype))
{
$setdefault=1;
}
 	$insert = array(
                'pagename' => $data['page']['name'],
                'pagetype' => $pagetype,
                'pageinfo' => serialize($data['page']),
                'savetime' => date("Y-m-d H:i:s"),
                'datas' => $newdata,
                'uniacid' => $_W['uniacid'],
                'keyword' => '',
                'setdefault' => $setdefault
            );
            if(!empty($setdefault))
            {
                    pdo_update('eshop_designer',  array(
                        'setdefault' => '0'
                    ), array('uniacid'=> $_W['uniacid']
                    ));
            }
            if (empty($id)) {
                $insert['createtime'] = date("Y-m-d H:i:s");
                pdo_insert('eshop_designer', $insert);
                $id = pdo_insertid();
            } else {
             
                pdo_update('eshop_designer', $insert, array(
                    'id' => $id,'uniacid'=> $_W['uniacid']
                ));
            }
     				
 	
	     	die(json_encode(array('status'=>1)));
}

$apido  = empty($_GPC['apido']) ? "" : $_GPC['apido'];
if ($op == 'api') {
	if ($apido == 'setdefault') {
            $do   = $_GPC['d'];
            $id   = $_GPC['id'];
            $type = $_GPC['type'];
            if ($do == 'on') {
                $pages = pdo_fetch("SELECT * FROM " . tablename('eshop_designer') . " WHERE pagetype=:pagetype and setdefault=:setdefault and uniacid=:uniacid ", array(
                    ':pagetype' => $type,
                    ':setdefault' => '1',
                    ':uniacid' => $_W['uniacid']
                ));
                if (!empty($pages)) {
                    $array = array(
                        'setdefault' => '0'
                    );
                    pdo_update('eshop_designer', $array, array(
                        'id' => $pages['id'],'uniacid'=> $_W['uniacid']
                    ));
                }
                $array  = array(
                    'setdefault' => '1'
                );
                $action = pdo_update('eshop_designer', $array, array(
                    'id' => $id,'uniacid'=> $_W['uniacid']
                ));
                if ($action) {
                    $json = array(
                        'result' => 'on',
                        'id' => $id,
                        'closeid' => $pages['id']
                    );
                    echo json_encode($json);
                }
            } else {
                $pages = pdo_fetch("SELECT * FROM " . tablename('eshop_designer') . " WHERE  id=:id and uniacid=:uniacid ", array(
                    ':id' => $id,
                    ':uniacid' => $_W['uniacid']
                ));
                if ($pages['setdefault'] == 1) {
                    $array  = array(
                        'setdefault' => '0'
                    );
                    $action = pdo_update('eshop_designer', $array, array(
                        'id' => $pages['id'],'uniacid'=> $_W['uniacid']
                    ));
                    if ($action) {
                        $json = array(
                            'result' => 'off',
                            'id' => $pages['id']
                        );
                        echo json_encode($json);
                    }
                }
            }
        }
        
        if ($apido == 'delpage') {
            if (empty($pageid)) {
                message('删除失败！Url参数错误', $this->createWebUrl('designer'), 'error');
            } else {
                $page = pdo_fetch("SELECT * FROM " . tablename('eshop_designer') . " WHERE uniacid= :uniacid and id=:id", array(
                    ':uniacid' => $_W['uniacid'],
                    ':id' => $pageid
                ));
                if (empty($page)) {
                    echo '删除失败！目标页面不存在！';
                    exit();
                } else {
                    $do = pdo_delete('eshop_designer', array(
                        'id' => $pageid
                    ));
                    if ($do) {
                       
                        echo 'success';
                    } else {
                        echo '删除失败！';
                    }
                }
            }
        }
        
        
        if ($apido == 'selectgood') {
            $kw    = $_GPC['keyword'];
            $list = pdo_fetchall("SELECT id,title,productprice,marketprice,thumb,sales,unit FROM " . tablename('eshop_goods') . " WHERE uniacid= :uniacid and status=:status and deleted=0 AND title LIKE :title ", array(
                ':title' => "%{$kw}%",
                ':uniacid' => $_W['uniacid'],
                ':status' => '1'
            ));
        
        

                  foreach ($list as $goods) {
          ?>
          
<div style='max-height:500px;overflow:auto;min-width:850px;'>
<table class="table table-hover" style="min-width:850px;">
    <tbody>   
                <tr>
          <td><img src='<?php echo ATTACHMENT_WEBROOT;?><?php  echo $goods['thumb'];?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' /> <?php echo $goods['title']?></td>
          <td style="width:80px;"><a href="javascript:;" onclick='biz.selector.set(this, <?php echo json_encode(array('id' => $goods['id'],'title' => $goods['title'],'title' => $goods['title'],'thumb'=>ATTACHMENT_WEBROOT.$goods['thumb'],'marketprice'=>$goods['marketprice'],'productprice'=>$goods['productprice'],'share_title'=>'','share_icon'=>'','description'=>'','minprice'=>$goods['marketprice']));?>)'>选择</a></td>
        </tr>
                    </tbody>
</table>
  </div>
<?php }
        
        }
        
        
        if ($apido == 'selectlink') {
            $type = $_GPC['type'];
            $kw   = $_GPC['kw'];
            if ($type == 'notice') {
                $notices = pdo_fetchall("select * from " . tablename('eshop_notice') . ' where title LIKE :title and status=:status and uniacid=:uniacid ', array(
                    ':uniacid' => $_W['uniacid'],
                    ':status' => '1',
                    ':title' => "%{$kw}%"
                ));
                echo json_encode($notices);
            } elseif ($type == 'good') {
                $goods = pdo_fetchall("select title,id,thumb,marketprice,productprice from " . tablename('eshop_goods') . ' where title LIKE :title and status=1 and deleted=0 and uniacid=:uniacid ', array(
                    ':uniacid' => $_W['uniacid'],
                    ':title' => "%{$kw}%"
                ));
                $goods = set_medias($goods, 'thumb');
                echo json_encode($goods);
            }  elseif ($type == "coupon") {
                $articles = pdo_fetchall("select id,couponname,coupontype from " . tablename("eshop_coupon") . " where couponname LIKE :title and uniacid=:uniacid ", array(
                    ":uniacid" => $_W["uniacid"],
                    ":title" => "%{$kw}%"
                ));
                echo json_encode($articles);
            } else {
                exit();
            }
        }
}
exit;

$tempdo = empty($_GPC['tempdo']) ? "" : $_GPC['tempdo'];

 if ($op == 'post') {
    $menus     = pdo_fetchall("SELECT id,menuname,isdefault FROM " . tablename('eshop_designer_menu') . " WHERE uniacid= :uniacid  ", array(
        ':uniacid' => $_W['uniacid']
    ));
    $pages     = pdo_fetchall("SELECT id,pagename,pagetype,setdefault FROM " . tablename('eshop_designer') . " WHERE uniacid= :uniacid  ", array(
        ':uniacid' => $_W['uniacid']
    ));
    $categorys = pdo_fetchall("SELECT id,name,parentid FROM " . tablename('eshop_category') . " WHERE enabled=:enabled and uniacid= :uniacid  ", array(
        ':uniacid' => $_W['uniacid'],
        ':enabled' => '1'
    ));
    if (!empty($pageid)) {
        $datas = pdo_fetch("SELECT * FROM " . tablename('eshop_designer') . " WHERE uniacid= :uniacid and id=:id", array(
            ':uniacid' => $_W['uniacid'],
            ':id' => $pageid
        ));
        $data  = htmlspecialchars_decode($datas['datas']);
        $data  = json_decode($data, true);
        if (!empty($data)) {
            foreach ($data as $i1 => &$dd) {
                if ($dd['temp'] == 'goods') {
                    foreach ($dd['data'] as $i2 => &$ddd) {
                        $goodinfo = pdo_fetchall("SELECT id,title,productprice,marketprice,thumb FROM " . tablename('eshop_goods') . " WHERE uniacid= :uniacid and id=:goodid", array(
                            ':uniacid' => $_W['uniacid'],
                            ':goodid' => $ddd['goodid']
                        ));
                        $goodinfo = set_medias($goodinfo, 'thumb');
                        if (!empty($goodinfo)) {
                            $data[$i1]['data'][$i2]['name']     = $goodinfo[0]['title'];
                            $data[$i1]['data'][$i2]['priceold'] = $goodinfo[0]['productprice'];
                            $data[$i1]['data'][$i2]['pricenow'] = $goodinfo[0]['marketprice'];
                            $data[$i1]['data'][$i2]['img']      = $goodinfo[0]['thumb'];
                        }
                    }
                    unset($ddd);
                } elseif ($dd['temp'] == 'richtext') {
                    $dd['content'] = m('designer')->unescape($dd['content']);
                } elseif ($dd['temp'] == 'cube') {
                    $dd['params']['currentLayout']['isempty'] = true;
                    $dd['params']['selection']                = null;
                    $dd['params']['currentPos']               = null;
                    $has                                      = false;
                    $newarr                                   = new stdClass();
                    foreach ($dd['params']['layout'] as $k => $v) {
                        $arr = new stdClass();
                        foreach ($v as $kk => $vv) {
                            $arr->$kk = $vv;
                        }
                        $newarr->$k = $arr;
                    }
                    $dd['params']['layout'] = $newarr;
                }
            }
            $data = json_encode($data);
        }
        $data     = rtrim($data, "]");
        $data     = ltrim($data, "[");
        $pageinfo = htmlspecialchars_decode($datas['pageinfo']);
        $pageinfo = rtrim($pageinfo, "]");
        $pageinfo = ltrim($pageinfo, "[");
        $shopset  = globalSetting('shop');
        $system   = array(
            'shop' => array(
                'name' => $shopset['name'],
                'logo' => tomedia($shopset['logo'])
            )
        );
        $system   = json_encode($system);
    } else {
        $defaultmenuid = m('designer')->getDefaultMenuID();
        $pageinfo      = "{id:'M0000000000000',temp:'topbar',params:{title:'',desc:'',img:'',kw:'',footer:'1',footermenu:'{$defaultmenuid}', floatico:'0',floatstyle:'right',floatwidth:'40px',floattop:'100px',floatimg:'',floatlink:''}}";
    }
    
    
include $this->template('diypage');
exit;
    
} elseif ($op == 'api') {
    if ($_W['ispost']) {
        if ($apido == 'savepage') {
            $id                    = $_GPC['pageid'];
            $datas                 = json_decode(htmlspecialchars_decode($_GPC['datas']), true);
            $date                  = date("Y-m-d H:i:s");
            $pagename              = $_GPC['pagename'];
            $pagetype              = $_GPC['pagetype'];
            $pageinfo              = $_GPC['pageinfo'];
            $p                     = htmlspecialchars_decode($pageinfo);
            $p                     = json_decode($p, true);
            $keyword               = empty($p[0]['params']['kw']) ? "" : $p[0]['params']['kw'];
            $p[0]['params']['img'] = save_media($p[0]['params']['img']);
            foreach ($datas as &$data) {
                if ($data['temp'] == 'banner' || $data['temp'] == 'menu' || $data['temp'] == 'picture') {
                    foreach ($data['data'] as &$d) {
                        $d['imgurl'] = save_media($d['imgurl']);
                    }
                    unset($d);
                } else if ($data['temp'] == 'shop') {
                    $data['params']['bgimg'] = save_media($data['params']['bgimg']);
                } else if ($data['temp'] == 'goods') {
                    foreach ($data['data'] as &$d) {
                        $d['img'] = save_media($d['img']);
                    }
                    unset($d);
                } else if ($data['temp'] == 'richtext') {
                    $content         = m('common')->html_images(m('designer')->unescape($data['content']));
                    $data['content'] = m('designer')->escape($content);
                } else if ($data['temp'] == 'cube') {
                    foreach ($data['params']['layout'] as &$row) {
                        foreach ($row as &$col) {
                            $col['imgurl'] = save_media($col['imgurl']);
                        }
                        unset($col);
                    }
                    unset($row);
                }
            }
            unset($data);
            $insert = array(
                'pagename' => $pagename,
                'pagetype' => $pagetype,
                'pageinfo' => json_encode($p),
                'savetime' => $date,
                'datas' => json_encode($datas),
                'uniacid' => $_W['uniacid'],
                'keyword' => $keyword
            );
            if (empty($id)) {
                $insert['createtime'] = $date;
                pdo_insert('eshop_designer', $insert);
                $id = pdo_insertid();
            } else {
                if ($pagetype == '4') {
                    $insert['setdefault'] = '0';
                }
                pdo_update('eshop_designer', $insert, array(
                    'id' => $id,'uniacid'=> $_W['uniacid']
                ));
            }
            
            echo $id;
            exit;
        } elseif ($apido == 'setdefault') {
            $do   = $_GPC['d'];
            $id   = $_GPC['id'];
            $type = $_GPC['type'];
            if ($do == 'on') {
                $pages = pdo_fetch("SELECT * FROM " . tablename('eshop_designer') . " WHERE pagetype=:pagetype and setdefault=:setdefault and uniacid=:uniacid ", array(
                    ':pagetype' => $type,
                    ':setdefault' => '1',
                    ':uniacid' => $_W['uniacid']
                ));
                if (!empty($pages)) {
                    $array = array(
                        'setdefault' => '0'
                    );
                    pdo_update('eshop_designer', $array, array(
                        'id' => $pages['id'],'uniacid'=> $_W['uniacid']
                    ));
                }
                $array  = array(
                    'setdefault' => '1'
                );
                $action = pdo_update('eshop_designer', $array, array(
                    'id' => $id,'uniacid'=> $_W['uniacid']
                ));
                if ($action) {
                    $json = array(
                        'result' => 'on',
                        'id' => $id,
                        'closeid' => $pages['id']
                    );
                    echo json_encode($json);
                }
            } else {
                $pages = pdo_fetch("SELECT * FROM " . tablename('eshop_designer') . " WHERE  id=:id and uniacid=:uniacid ", array(
                    ':id' => $id,
                    ':uniacid' => $_W['uniacid']
                ));
                if ($pages['setdefault'] == 1) {
                    $array  = array(
                        'setdefault' => '0'
                    );
                    $action = pdo_update('eshop_designer', $array, array(
                        'id' => $pages['id'],'uniacid'=> $_W['uniacid']
                    ));
                    if ($action) {
                        $json = array(
                            'result' => 'off',
                            'id' => $pages['id']
                        );
                        echo json_encode($json);
                    }
                }
            }
        }
    }
    exit();
}