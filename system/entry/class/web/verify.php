<?php
	$entery_name="核销员入口设置";
$entery_url=create_url('mobile',array('do' => 'verify','m' => 'eshop','act' => 'index'));
$rule = pdo_fetch("select * from " . tablename('rule') . ' where uniacid=:uniacid and module=:module and name=:name limit 1', array(
    ':uniacid' => $_CMS['beid'],
    ':module' => 'entry',
    ':name' => "system核销员入口设置"
));
if (!empty($rule)) {
    $entry   = pdo_fetch("select * from " . tablename('rule_entry_reply') . ' where uniacid=:uniacid and rid=:rid limit 1', array(
        ':uniacid' => $_CMS['beid'],
        ':rid' => $rule['id']
    ));
}
if (checksubmit('submit')) {
    $data = is_array($_GPC['entry']) ? $_GPC['entry'] : array();
    if (!empty($rule)) {
        pdo_delete('rule', array(
            'id' => $rule['id'],
            'uniacid' => $_CMS['beid']
        ));
        pdo_delete('rule_entry_reply', array(
            'rid' => $rule['id'],
            'uniacid' => $_CMS['beid']
        ));
    }
     if (empty($data['keyword'])) {
            message('核销员入口设置成功!', referer(), 'success');
    }
    $rule_data = array(
        'uniacid' => $_CMS['beid'],
        'name' => 'system核销员入口设置',
        'module' => 'entry',
        'keyword' => trim($data['keyword']),
        'status' => intval($data['status'])
    );
    pdo_insert('rule', $rule_data);
    $rid          = pdo_insertid();
    $entry_data = array(
        'uniacid' => $_CMS['beid'],
        'rid' => $rid,
        'module' => 'entry',
        'title' => trim($data['title']),
        'description' => trim($data['desc']),
        'thumb' => $data['thumb'],
        'url' => $entery_url
    );
    pdo_insert('rule_entry_reply', $entry_data);
    message('核销员入口设置成功!', referer(), 'success');
}

			include page('entry');