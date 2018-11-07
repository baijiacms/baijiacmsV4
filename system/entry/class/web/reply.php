<?php
$operation = !empty($_GP['op']) ? $_GP['op'] : 'display';
if($operation=='display')
{
	$condition = "uniacid = :uniacid AND `module`=:module";
	$params = array();
	$params[':uniacid'] = $_W['uniacid'];
	$params[':module'] = $_GP['rtype'];
	$where = "WHERE {$condition}";
	$sql = 'SELECT * FROM ' . tablename('rule') . $where . " ORDER BY id desc";
	
$list = pdo_fetchall($sql, $params);
			include page('reply_list');
}
if($operation=='delete')
{
		$rtype=$_GP['rtype'];
			$sql = 'SELECT * FROM ' . tablename('rule')  . " where uniacid = :uniacid AND `id`=:id";
		$rule = pdo_fetch($sql, array(':uniacid'=>$_W['uniacid'],':id'=>$_GPC['id']));
if(!empty($rule['id']))
	{
		$rtype=$rule['module'];		
	}
	    if (!empty($rule)) {
        pdo_delete('rule', array(
            'id' => $rule['id'],
            'uniacid' => $_CMS['beid']
        ));
        pdo_delete('rule_basic_reply', array(
            'rid' => $rule['id']
        ));
          pdo_delete('rule_news_reply', array(
            'rid' => $rule['id']
        ));
    }
     message("删除成功！",create_url('site',array('act' => 'entry','do' => 'reply','rtype'=>$rtype,'op'=>'display')),'success');
	
	
	
}
if($operation=='edit')
{
	$rtype=$_GP['rtype'];
	if(!empty($_GPC['id']))
	{
		$sql = 'SELECT * FROM ' . tablename('rule')  . " where uniacid = :uniacid AND `id`=:id";
		$rule = pdo_fetch($sql, array(':uniacid'=>$_W['uniacid'],':id'=>$_GPC['id']));	
	}

	if(!empty($rule['id']))
	{
		$rtype=$rule['module'];		
	}
	if($rtype=='basic')
	{

	if(!empty($rule['id']))
	{
	$basic_reply = pdo_fetch('SELECT * FROM ' . tablename('rule_basic_reply')  . " where rid = :rid", array(':rid'=>$rule['id']));
	}
	if (checksubmit('submit')) {
			    $data = is_array($_GPC['entry']) ? $_GPC['entry'] : array();
			 if (empty($data['keyword'])) {
        message('请输入关键词!');
    }
    
     if (!empty($rule)) {
        pdo_delete('rule', array(
            'id' => $rule['id'],
            'uniacid' => $_CMS['beid']
        ));
        pdo_delete('rule_basic_reply', array(
            'rid' => $rule['id']
        ));
          pdo_delete('rule_news_reply', array(
            'rid' => $rule['id']
        ));
    }
    
     $rule_data = array(
        'uniacid' => $_CMS['beid'],
        'name' => $data['name'],
        'module' => 'basic',
        'keyword' => trim($data['keyword']),
        'status' => 1
    );
    pdo_insert('rule', $rule_data);
    $rid          = pdo_insertid();
    $entry_data = array(
        'rid' => $rid,
        'content' => trim($data['content'])
    );
    pdo_insert('rule_basic_reply', $entry_data);
    
    message("文字回复编辑成功！",create_url('site',array('act' => 'entry','do' => 'reply','rtype'=>$rtype,'op'=>'display')),'success');
		}
		include page('reply_basic');
	}
	if($rtype=='news')
	{
			function array_elements($keys, $src) {
					$return = array();
					if(!is_array($keys)) {
						$keys = array($keys);
					}
					foreach($keys as $key) {
						if(isset($src[$key])) {
							$return[$key] = $src[$key];
						} else {
							$return[$key] = false;
						}
					}
					return $return;
				}
				
				
				$replies = array();
			if(!empty($rule['id']))
	{
		$rows = pdo_fetchall("SELECT * FROM ".tablename('rule_news_reply') ." WHERE rid = :rid ORDER BY `parent_id` ASC, `id` ASC", array(':rid' => $rule['id']));

		foreach($rows as &$row) {
			if(!empty($row['thumb'])) {
				$row['thumb'] = tomedia($row['thumb']);
			}
			if (empty($row['parent_id'])) {
				$replies[$row['id']][] = $row;
			} else {
				$replies[$row['parent_id']][] = $row;
			}
		}
		$replies = array_values($replies);
	
	
	
	}
	
		if (checksubmit('submit')) {
			    $data = is_array($_GPC['entry']) ? $_GPC['entry'] : array();
			 if (empty($data['keyword'])) {
        message('请输入关键词!');
    }
    
   



$req_replies = @json_decode(htmlspecialchars_decode($_GPC['replies']), true);
		if(empty($req_replies)) {
		message('必须填写有效的回复内容.');
		}
		$column = array('id', 'parent_id', 'title', 'author', 'displayorder', 'thumb', 'description', 'content', 'url', 'incontent', 'createtime');
		foreach($req_replies as $i => &$group) {
			foreach($group as $k => &$v) {
				if(empty($v)) {
					unset($group[$k]);
					continue;
				}
				if (trim($v['title']) == '') {
					message('必须填写有效的标题.');
				}
				if (trim($v['thumb']) == '') {
						message('必须填写有效的封面链接地址.');
				}
				$v['thumb'] = str_replace($_W['attachurl'], '', $v['thumb']);
				$v['content'] = htmlspecialchars_decode($v['content']);
				$v['createtime'] = TIMESTAMP;
				
				
			

				$v = array_elements($column, $v);
				

				
			}
			if(empty($group)) {
				unset($i);
			}
		}
		if(empty($req_replies)) {
			message('必须填写有效的回复内容.');
		}



  if (!empty($rule)) {
        pdo_delete('rule', array(
            'id' => $rule['id'],
            'uniacid' => $_CMS['beid']
        ));
        pdo_delete('rule_basic_reply', array(
            'rid' => $rule['id']
        ));
          pdo_delete('rule_news_reply', array(
            'rid' => $rule['id']
        ));
    }
    
    
     $rule_data = array(
        'uniacid' => $_CMS['beid'],
        'name' => $data['name'],
        'module' => 'news',
        'keyword' => trim($data['keyword']),
        'status' => 1
    );
    pdo_insert('rule', $rule_data);
    $rid          = pdo_insertid();
    
    
    
   $sql = 'SELECT `id` FROM ' . tablename('rule_news_reply') . " WHERE `rid` = :rid";
		$replies = pdo_fetchall($sql, array(':rid' => $rid), 'id');
		$replyids = array_keys($replies);
		$indexs = array();
		foreach($req_replies as &$group) {
			$parent_id = -1;
			foreach($group as $reply) {
				if($parent_id <= 0) {
					if($reply['parent_id'] == 0) {
						$parent_id = $reply['id'];
					} elseif($reply['parent_id'] > 0) {
						$parent_id = $reply['parent_id'];
					}
				}
			}
			if($parent_id == -1) {
								$i = 0;
				foreach($group as $reply) {
					if(!$i) {
						$i++;
						$reply['rid'] = $rid;
						$reply['parent_id'] = 0;
						pdo_insert('rule_news_reply', $reply);
						$parent_id = pdo_insertid();
					} else {
						$reply['parent_id'] = $parent_id;
						$reply['rid'] = $rid;
						pdo_insert('rule_news_reply', $reply);
					}
				}
				pdo_update('rule_news_reply', array('parent_id' => 0), array('id' => $parent_id));
			} else {
				$i = 0;
				foreach($group as $reply) {
					if(!$i) {
						$new_parent_id = $reply['id'];
						$i++;
					}
					$arr[] = $reply['id'];
					$reply['parent_id'] = $parent_id;
					if (in_array($reply['id'], $replyids)) {
						pdo_update('rule_news_reply', $reply, array('id' => $reply['id']));
						$index = array_search($reply['id'], $replyids);
						unset($replyids[$index]);
					} else {
						$reply['rid'] = $rid;
						pdo_insert('rule_news_reply', $reply);
					}
				}
				if(!in_array($parent_id, $arr)) {
					$parent_id = $new_parent_id;
				}
				pdo_update('rule_news_reply', array('parent_id' => $new_parent_id), array('parent_id' => $parent_id));
				pdo_update('rule_news_reply', array('parent_id' => 0), array('id' => $new_parent_id));
			}
		}

   
   
        message("图文回复编辑成功！",create_url('site',array('act' => 'entry','do' => 'reply','rtype'=>$rtype,'op'=>'display')),'success');
		}
		include page('reply_news');
	}
}