<?php
global $_W;
		global $_GPC; 
		$operation = ! empty ( $_GPC ['op'] ) ? $_GPC ['op'] : 'display';
	
		if ($operation == 'post') {
			$activityid = intval ( $_GPC ['activityid'] );
			if (! empty ( $activityid )) {
				$activity = pdo_fetch ("SELECT * FROM " . table('activity') . " WHERE  uniacid = '{$_W['uniacid']}' and id =" . $activityid);
				$activity['atlas'] = unserialize($activity['atlas']);
				$activity['prize'] = unserialize($activity['prize']);
				if (empty ( $activity )) {
					message ('抱歉，主题不存在或是已经删除！', '', 'error');
				}
			}
			
			if (checksubmit('submit')) {
				if (empty ( $_GPC ['title'] )) {
					message ('请输入活动主题名称');
				}
				if (empty ( $_GPC ['unit'] )) {
					message ('请输入主办方名称');
				}
				if(empty ( $_GPC ['activityTime']['start'] )){
					message ('请选择开始日期');
				}
				if(empty ( $_GPC ['activityTime']['end'] )){
					message ('请选择截止日期');
				}
				if(strtotime($_GPC ['begintime'])-strtotime($_GPC ['endtime'] ) >= 0 ){
					//message ('开始日期不能晚于截止日期');
				}
				
				$data = array (
						'uniacid' 	=> $_W ['uniacid'],
						'title' 	=> $_GPC ['title'],
						'virtualrec' 	=> $_GPC ['virtualrec'],
						'unit' 		=> $_GPC ['unit'],
						'tel' 		=> $_GPC ['tel'],
						'detail' 	=> htmlspecialchars_decode($_GPC ['detail']),
						'starttime' => $_GPC ['activityTime']['start'],
						'endtime' 	=> $_GPC ['activityTime']['end'],
						'joinstime' => $_GPC ['joinTime']['start'],
						'joinetime' => $_GPC ['joinTime']['end'],
						'atlas' 	=> serialize($_GPC ['img']),
						'personnum' => $_GPC ['personnum'],
						'lng' 		=> $_GPC ['map']['lng'],
						'lat' 		=> $_GPC ['map']['lat'],
						'address' 	=> $_GPC ['address'],
						'sharetitle'=> $_GPC ['share']['title'],
						'followurl'=> $_GPC ['share']['followurl'],
						'followicon' 	=> $_GPC ['share']['followicon'],
						'sharedesc' => $_GPC ['share']['desc'],
						'sharepic'  => $_GPC ['share']['pic'],
						'prize' 	=> serialize($_GPC ['prize']),
						'entery_title' 	=> $_GPC ['entery_title'],
						'entery_description' 	=> $_GPC ['entery_description'],
						'entery_thumb' 	=> $_GPC ['entery_thumb'],
						'entery_keyword' 	=> $_GPC ['entery_keyword']
				);
				
				if (! empty ( $activityid )) {
					pdo_update ('activity', $data, array (
							'id' => $activityid ,'uniacid' 	=> $_W ['uniacid']
					) );
				} else {
					pdo_insert ('activity', $data );
					$activityid = pdo_insertid();
				}
				
			if(!empty($activityid)){
				
			$rule = pdo_fetch("select * from " . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(
    ':uniacid' => $_W ['uniacid'],
    ':module' => 'entry',
    ':name' => "entry报名活动入口设置id:".$activityid
));
			
				 if (!empty($rule)) {
        pdo_delete('rule', array(
            'id' => $rule['id'],
            'uniacid' => $_W ['uniacid']
        ));
        pdo_delete('rule_entry_reply', array(
            'rid' => $rule['id'],
            'uniacid' => $_W ['uniacid']
        ));
    }
					if(!empty($_GPC['entery_keyword']))
					{
						
						 $rule_data = array(
        'uniacid' => $_W['uniacid'],
        'name' => 'system文章列表入口设置',
        'module' => 'entry',
        'keyword' => trim($data['entery_keyword']),
        'status' => 1);
    pdo_insert('rule', $rule_data);
    $rid          = pdo_insertid();
    $entry_data = array(
        'uniacid' => $_W ['uniacid'],
        'rid' => $rid,
        'module' => 'entry',
        'title' => trim($data['entery_title']),
        'description' => trim($data['entery_desc']),
        'thumb' => $data['entery_thumb'],
        'url' => WEBSITE_ROOT.create_url('mobile',array('act' => 'activity','do' => 'index','isaddons'=>'1','activityid' => $activityid))
    );
    pdo_insert('rule_entry_reply', $entry_data);
						
						
					}
			}
				
				
				message ('更新成功！', create_url('site',array('act' => 'activity','do' => 'activity','isaddons'=>'1','op'=>'display')), 'success');
			}
		} else if ($operation == 'delete') {
			$activityid = intval ( $_GPC ['activityid'] );
			$row = pdo_fetch ("SELECT id FROM " . table ('activity') . " WHERE uniacid = '{$_W['uniacid']}' and id = " . $activityid );
			if (empty ($row)) {
				message ('抱歉，主题不存在或是已经被删除！');
			}
			pdo_delete ('activity', array ('id' => $activityid,'uniacid' 	=> $_W ['uniacid']));
			
				if(!empty($activityid)){
				
			$rule = pdo_fetch("select * from " . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(
    ':uniacid' => $_W ['uniacid'],
    ':module' => 'entry',
    ':name' => "entry报名活动入口设置id:".$activityid
));
			
				 if (!empty($rule)) {
        pdo_delete('rule', array(
            'id' => $rule['id'],
            'uniacid' => $_W ['uniacid']
        ));
        pdo_delete('rule_entry_reply', array(
            'rid' => $rule['id'],
            'uniacid' => $_W ['uniacid']
        ));
    }
			}
			
			
			message("删除成功",refresh(),'success');
			exit;
		} else if ($operation == 'display') {
			$pindex = max(1, intval($_GPC['page']));		
			//当前页码
			$psize = 10;
			//设置分页大小
			$condition = " uniacid = '{$_W['uniacid']}'";
			$list = pdo_fetchall ("SELECT * FROM " . table ('activity') . " WHERE $condition ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize);
			$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . table('activity') . " WHERE $condition");
			//记录总数
			$pager = pagination($total, $pindex, $psize);
		}
		include addons_page ('activity');
