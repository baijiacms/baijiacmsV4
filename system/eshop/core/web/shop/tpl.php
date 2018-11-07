<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
global $_GPC;

$tpl = trim($_GPC['tpl']);

$pv = p('virtual');
if ($tpl == 'option') {
    $tag = random(32);
    include $this->template('tpl/option');
} else if ($tpl == 'spec') {
    $spec = array(
        "id" => random(32),
        "title" => $_GPC['title']
    );
    include $this->template('tpl/spec');
} else if ($tpl == 'specitem') {
    $spec     = array(
        "id" => $_GPC['specid']
    );
    $specitem = array(
        "id" => random(32),
        "title" => $_GPC['title'],
        "show" => 1
    );
    include $this->template('tpl/spec_item');
}