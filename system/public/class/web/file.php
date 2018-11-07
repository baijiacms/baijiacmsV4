<?php

defined('IN_IA') or exit('Access Denied');
global $_W;
$do=$_GP['op'];
if (!in_array($do, array('upload', 'fetch', 'browser', 'delete', 'local'))) {
	exit('Access Denied');
}
$result = array(
	'error' => 1,
	'message' => '',
	'data' => ''
);


$uniacid = intval($_W['uniacid']);

if ($do == 'fetch') {
	$url = trim($_GPC['url']);
$file=fetch_net_file_upload($url);
	if (is_error($file)) {
		$result['message'] = $file['message'];
		die(json_encode($result));
	}
	
}
if ($do == 'upload') {
	$file=file_upload($_FILES['file']);
		if (is_error($file)) {
		$result['message'] = $file['message'];
		die(json_encode($result));
	}
}


if ($do == 'fetch' || $do == 'upload') {
	$info = array(
		'name' => $file['name'],
		'ext' => $file['extention'],
		'filename' => $file['extention'],
		'attachment' => $file['path'],
		'url' => ATTACHMENT_ROOT.$file['path'],
		'is_image' => 1
	);
	if(!empty($_GP['showallurl']))
		{
		$info['attachment'] = tomedia($info['attachment']);
		}

	pdo_insert('core_attachment', array(
		'uniacid' => $uniacid,
		'uid' => $_W['uid'],
		'filename' =>$file['name'],
		'attachment' => $file['path'],
		'type' => 1,
		'createtime' => TIMESTAMP,
	));
	die(json_encode($info));
}

if ($do == 'delete') {
	$id = intval($_GPC['id']);
	$media = pdo_fetch('SELECT * FROM '.tablename('core_attachment').' where uniacid=:uniacid and id=:id', array(':uniacid' => $_W['uniacid'], ':id' => $id));
	if(empty($media)) {
		exit('文件不存在或已经删除');
	}
	if(empty($_W['isfounder']) && $_W['role'] != 'manager') {
		exit('您没有权限删除该文件');
	}

		$status = file_delete($media['attachment']);
	if(is_error($status)) {
		exit($status['message']);
	}
	pdo_delete('core_attachment', array('uniacid' => $uniacid, 'id' => $id));
	exit('success');
}

if ($do == 'local') {
	$types = array('image', 'audio');
	$type = in_array($_GPC['type'], $types) ? $_GPC['type'] : 'image';
	$typeindex = array('image' => 1, 'audio' => 2);
	$condition = ' WHERE uniacid = :uniacid AND type = :type';
	$params = array(':uniacid' => $_W['uniacid'], ':type' => $typeindex[$type]);
	$year = intval($_GPC['year']);
	$month = intval($_GPC['month']);
	if($year > 0 || $month > 0) {
		if($month > 0 && !$year) {
			$year = date('Y');
			$starttime = strtotime("{$year}-{$month}-01");
			$endtime = strtotime("+1 month", $starttime);
		} elseif($year > 0 && !$month) {
			$starttime = strtotime("{$year}-01-01");
			$endtime = strtotime("+1 year", $starttime);
		} elseif($year > 0 && $month > 0) {
			$year = date('Y');
			$starttime = strtotime("{$year}-{$month}-01");
			$endtime = strtotime("+1 month", $starttime);
		}
		$condition .= ' AND createtime >= :starttime AND createtime <= :endtime';
		$params[':starttime'] = $starttime;
		$params[':endtime'] = $endtime;
	}

	$page = intval($_GPC['page']);
	$page = max(1, $page);
	$size = $_GPC['pagesize'] ? intval($_GPC['pagesize']) : 32;

	$sql = 'SELECT * FROM '.tablename('core_attachment')." {$condition} ORDER BY id DESC LIMIT ".(($page-1)*$size).','.$size;
	$list = pdo_fetchall($sql, $params, 'id');

	foreach ($list as &$item) {
		$item['url'] = tomedia($item['attachment']);
		if(!empty($_GP['showallurl']))
		{
		$item['attachment'] = tomedia($item['attachment']);
		}
		$item['createtime'] = date('Y-m-d', $item['createtime']);
		unset($item['uid']);
	}
	$total = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('core_attachment') ." {$condition}", $params);
	message(array('page'=> pagination($total, $page, $size, '', array('before' => '2', 'after' => '2', 'ajaxcallback'=>'null')), 'items' => $list), '', 'ajax');
}