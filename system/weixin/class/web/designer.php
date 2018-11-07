<?php

	$do = !empty($_GP['op']) ? $_GP['op'] : 'display';
	if($_W['isajax']) {
	$post = $_GPC['__input'];
	if(!empty($post['method'])) {
		$do = $post['method'];
	}
}
if($do == 'display') {
	if(empty($menus) || !is_array($menus)) {
		$menus = $this->menuQuery();
	}
	if (is_error($menus)) {
		message($menus['message'], '', 'error');
	}

	if(!is_array($menus)) {
		$menus = array();
	}
}
if($do=='remove')
{		$ret = $this->menuDelete();
			if(is_error($ret)) {
		exit(json_encode($ret));
	}
	exit('success');
}


if($do=='save')
{
if (!empty($post['menus'])) {
		foreach ($post['menus'] as &$m) {
			$m['title'] = preg_replace_callback('/\:\:([0-9a-zA-Z_-]+)\:\:/', create_function('$matches', 'return utf8_bytes(hexdec($matches[1]));'), $m['title']);
			if (!empty($m['subMenus'])) {
				foreach ($m['subMenus'] as &$subm) {
					$subm['title'] = preg_replace_callback('/\:\:([0-9a-zA-Z_-]+)\:\:/', create_function('$matches', 'return utf8_bytes(hexdec($matches[1]));'), $subm['title']);
				}
			}
		}
	}
	$menus = $post['menus'];
	$ret = $this->menuCreate($menus);
		if(is_error($ret)) {
		exit(json_encode($ret));
	}
	exit('success');
}
			include page('designer');