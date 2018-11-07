<?php

//这个操作被定义用来呈现 管理中心报名记录

		global $_W;

		global $_GPC; 

		$activityid = intval ( $_GPC ['activityid'] );

		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';

		if ($operation == 'display') {

			$pindex = max(1, intval($_GPC['page']));		

			//当前页码

			$psize = 10;

			//设置分页大小

			$condition = " uniacid = '{$_W['uniacid']}'";

			if (!empty($_GPC['activityid'])) {

				$condition .= " AND activityid = {$_GPC['activityid']}";

			}

			if (!empty($_GPC['keyword'])) {

				$condition .= " AND (username LIKE '%{$_GPC['keyword']}%' or mobile LIKE '%{$_GPC['keyword']}%' or nickname LIKE '%{$_GPC['keyword']}%')";

			}

			$activity = pdo_fetchall ("SELECT * FROM " . table ('activity') . " WHERE uniacid = '{$_W['uniacid']}' ORDER BY id DESC");

			$records = pdo_fetchall ("SELECT * FROM " . table ('activity_records') . " WHERE $condition ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);

			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . table('activity_records') . " WHERE $condition");

			//记录总数

			$pager = pagination($total, $pindex, $psize);

		} elseif ($operation == 'delete') {


			$id = intval($_GPC['id']);

			$row = pdo_fetch("SELECT id,pic FROM " . table('activity_records') . " WHERE id = $id and uniacid = '{$_W['uniacid']}'");

			if (empty($row)) {

				message('抱歉，用户不存在或是已经被删除！', create_url('site',array('act' => 'activity','do' => 'records','isaddons'=>'1','activityid' => $id, 'op' => 'display')), 'error');

			}




			pdo_delete('activity_records', array('id' => $id,'uniacid'=>$_W['uniacid']));


			message("删除成功",refresh(),'success');

			exit;



		} elseif ($operation == 'deleteArr') {


			if ($_GPC['id']==''){

			message ('抱歉，主题不存在或是已经被删除！');
				exit;

			}

			foreach ($_GPC['id'] as $k => $bid) {

				$id = intval($bid);

				if ($id == 0)

				continue;			

				$row = pdo_fetch("SELECT id,pic FROM " . table('activity_records') . " WHERE id = $id and uniacid = '{$_W['uniacid']}'");

				if (empty($row)) {

		message ('抱歉，主题不存在或是已经被删除！');
					exit;

				}


				pdo_delete('activity_records', array('id' => $id,'uniacid'=>$_W['uniacid']));

			}
			message("删除成功",refresh(),'success');

			exit;

		}  

		include addons_page ('records');