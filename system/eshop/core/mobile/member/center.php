<?php
if (!defined("IN_IA")) {
    print("Access Denied");
}
header("Location:".create_url('mobile',array('act' => 'shopwap','do' => 'membercenter')));
?>