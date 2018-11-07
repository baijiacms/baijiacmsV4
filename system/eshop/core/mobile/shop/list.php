<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}
header("location:".create_url('mobile',array('act'=>'index','do'=>'goods','m'=>'eshop')));