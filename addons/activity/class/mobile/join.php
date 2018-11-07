<?php

$openid = get_sysopenid(true);
$base_member = mysqld_select("SELECT * FROM " . table('base_member') . " WHERE openid=:openid and beid=:beid ", array(':openid' =>$openid,":beid"=>$_CMS['beid']));
$eshop_member = mysqld_select("SELECT * FROM " . table('eshop_member') . " WHERE openid=:openid and uniacid=:uniacid ", array(':openid' =>$openid,":uniacid"=>$_CMS['beid']));

		global $_W;
		global $_GPC;


		$activityid = intval ( $_GPC ['activityid'] );
		$pagetitle = "报名入口";	

		$activity = pdo_fetch ("SELECT * FROM " . table ('activity') . " WHERE uniacid = '{$_W['uniacid']}' and id = " . $activityid );
			if (empty ( $activity ['id'] )) {
				message ('活动未找到');
			}
		$activity['prize'] = unserialize($activity['prize']);
		$pagetitle=$activity['title'];
		if (checksubmit('submit')) {
			if (empty ( $_GPC ['username'] )) {
				//message ('请输入活动主题名称');
			}
			if (empty ( $_GPC ['mobile'] )) {
				//message ('请输入主办方名称');
			}
			$data = array (
					'activityid' => $activityid,
					'uniacid' => $_W['uniacid'],
					'openid' => $base_member['openid'],
					'nickname' => $eshop_member['nickname'],
					'headimgurl' => $eshop_member['avatar'],
					'username' => $_GPC['username'],
					'mobile' => $_GPC['mobile'],
						'isagent' => $eshop_member['isagent'],
					'msg' => htmlspecialchars_decode($_GPC ['msg']),
			);
			$condition = "activityid = $activityid and status=0 and openid='{$base_member['openid']}'";
			$findUser = pdo_fetch("SELECT id FROM " . table ('activity_records') . " WHERE $condition");
			if(!empty($findUser)){
				message ('不能重复报名！', create_url('mobile',array('act' => 'activity','do' => 'index','isaddons'=>'1','activityid' => $activityid, 'op' => 'display')), 'warning');
			}else{
				$result = pdo_insert ('activity_records', $data );
				if ($result){
				
					message ('报名成功！',create_url('mobile',array('act' => 'activity','do' => 'index','isaddons'=>'1','activityid' => $activityid, 'op' => 'display')), 'success');
				}
			}
		}
		
		include addons_page ('join');