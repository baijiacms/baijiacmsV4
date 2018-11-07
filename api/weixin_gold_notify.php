<?php
$mod='mobile';
$_GET['act']="modules";
defined('SYSTEM_ACT') or define('SYSTEM_ACT', 'mobile');
$_GET['do']='weixin_gold_notify';
ob_start();
$CLASS_LOADER="driver";
require '../includes/baijiacms.php';
ob_end_flush();
exit;

