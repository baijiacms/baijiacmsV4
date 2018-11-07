<?php

global $_W, $_GPC;

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$set = globalSetting('commission');
$leveltype = intval($set['leveltype']);
if ($operation == 'display') {
    $list = pdo_fetchall("SELECT * FROM " . tablename('eshop_commission_level') . " WHERE uniacid = '{$_W['uniacid']}' ORDER BY commission1 asc");
} elseif ($operation == 'post') {
	$id = intval($_GPC['id']);

	$level = pdo_fetch("SELECT * FROM " . tablename('eshop_commission_level') . " WHERE id = '$id'");
	if (checksubmit('submit')) {
		if (empty($_GPC['levelname'])) {
			message('抱歉，请输入分类名称！');
		}
		$data = array('uniacid' => $_W['uniacid'], 'levelname' => $_GPC['levelname'], 'commission1' => $_GPC['commission1'], 'commission2' => $_GPC['commission2'], 'commission3' => $_GPC['commission3'], 'commissionmoney' => $_GPC['commissionmoney'], 'ordermoney' => $_GPC['ordermoney'], 'ordercount' => intval($_GPC['ordercount']), 'downcount' => intval($_GPC['downcount']),);
		if (!empty($id)) {
			pdo_update('eshop_commission_level', $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
		} else {
			pdo_insert('eshop_commission_level', $data);
			$id = pdo_insertid();
		}
		message('更新等级成功！', $this->createWebUrl('commission/level', array('op' => 'display')), 'success');
	}
} elseif ($operation == 'delete') {
		$id = intval($_GPC['id']);
	$level = pdo_fetch("SELECT id,levelname FROM " . tablename('eshop_commission_level') . " WHERE id = '$id'");
	if (empty($level)) {
		message('抱歉，等级不存在或是已经被删除！', $this->createWebUrl('commission/level', array('op' => 'display')), 'error');
	}
	pdo_delete('eshop_commission_level', array('id' => $id, 'uniacid' => $_W['uniacid']));
	message('等级删除成功！', $this->createWebUrl('commission/level', array('op' => 'display')), 'success');
}
include $this->template('level');