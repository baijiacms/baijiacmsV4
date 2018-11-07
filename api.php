<?php
$mod='mobile';
$_GET['act']="entry";
defined('SYSTEM_ACT') or define('SYSTEM_ACT', 'mobile');
$_GET['do']='process';
ob_start();
$CLASS_LOADER="driver";
require 'includes/baijiacms.php';
ob_end_flush();
exit;

