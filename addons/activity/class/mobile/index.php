<?php
$openid = get_sysopenid(true);
$base_member = mysqld_select("SELECT * FROM " . table('base_member') . " WHERE openid=:openid and beid=:beid ", array(':openid' =>$openid,":beid"=>$_CMS['beid']));
$fans = pdo_fetch('select * from ' . tablename('weixin_fans') . ' where  weixin_openid=:weixin_openid and uniacid=:uniacid limit 1', array(
                ':uniacid' => $_CMS['beid'],
                ':weixin_openid' =>$base_member['weixin_openid']
        ));
		global $_W,$_GPC;

		$activityid = intval ( $_GPC ['activityid'] );
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
					$pagetitle = "活动报名入口";

			$activity = pdo_fetch ("SELECT * FROM " . table ('activity') . " WHERE uniacid = '{$_W['uniacid']}' and id = " . $activityid );
			if (empty ( $activity ['id'] )) {
				message ('活动未找到');
			}
			$pagetitle=$activity['title'];
			$activity['atlas'] = unserialize($activity['atlas']);
			$activity['prize'] = unserialize($activity['prize']);
			$condition = " activityid = $activityid and status = 0";
			$records = pdo_fetchall ("SELECT * FROM " . table ('activity_records') . " WHERE $condition  and (pic!='') ORDER BY id DESC limit 16");
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . table('activity_records') . " WHERE $condition ");
			
	$total=	$total+intval($activity['virtualrec']);

			$jion  = 	pdo_fetch('SELECT id FROM ' . table('activity_records') . " WHERE activityid=:activityid and status=:status and openid=:openid ", array(':activityid' => $activityid, ':status' => 0,':openid' =>$base_member['openid']));

			
					include addons_page ('index');