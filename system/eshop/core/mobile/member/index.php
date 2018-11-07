<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
header("Location:".create_url('mobile',array('act' => 'shopwap','do' => 'membercenter')));
exit;