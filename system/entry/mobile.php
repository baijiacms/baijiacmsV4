<?php
defined('SYSTEM_IN') or exit('Access Denied');
if($_GP['op']=='weixin')
{
		require WEB_ROOT.'/system/entry/extends/mobile_weixin.php';
}