<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.baijiacms.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 百家威信 <QQ:1987884799> <http://www.baijiacms.com>
// +----------------------------------------------------------------------
defined('SYSTEM_IN') or exit('Access Denied');
defined('LOCK_TO_ADDONS_UNINSTALL') or exit('Access Denied');
$sql = "
drop table `baijiacms_activity`;
drop table `baijiacms_activity_records`;
";

mysqld_batch($sql);