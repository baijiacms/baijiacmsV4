<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
define('ESHOP_AREA_XMLFILE',IA_ROOT . "/assets/eshop/static/js/dist/area/Area.xml");
class Core extends BJexModule
{
    public $footer = array();
    public $header = null;
    public function __construct()
    {
        global $_W;
    }
  
    public function createMobileUrl($do, $query = array(), $noredirect = true)
    {
        global $_W, $_GPC;
        $do = explode('/', $do);
        if (isset($do[1])) {
            $query = array_merge(array(
                'act' => $do[1]
            ), $query);
        }
        if (isset($do[2])&&!empty($do[2])) {
                	$query['op']=$do[2];
        }
         
           if(empty($query['act']))
        {
        	$query['act']=$_W['default_act'];
        }
        if(empty($query['act']))
        {
        	$query['act']='index';
        }
        return parent::createMobileUrl($do[0], $query, true);
    }
    public function createWebUrl($do, $query = array())
    {
        global $_W;
        $do = explode('/', $do);
        if (count($do) > 1 && isset($do[1])) {
            $query = array_merge(array(
                'act' => $do[1]
            ), $query);
        }
           if (isset($do[2])&&!empty($do[2])) {
                	$query['op']=$do[2];
        }
           if(empty($query['act']))
        {
        	$query['act']=$_W['default_act'];
        }
            if(empty($query['act']))
        {
        	$query['act']='index';
        }
        return  parent::createWebUrl($do[0], $query, true);
    }
    public function _exec($do, $default = '', $web = true)
    {
        global $_GPC,$_W;
        $do = strtolower(substr($do, $web ? 5 : 8));
        $p  = trim($_GPC['act']);
        empty($p) && $p = $default;
        $_W['default_act']=$default;
        if ($web) {
            $file = IA_ROOT . "/system/eshop/core/web/" . $do . "/" . $p . ".php";
        } else {
            $file = IA_ROOT . "/system/eshop/core/mobile/" . $do . "/" . $p . ".php";
        }
        if (!is_file($file)) {
            message("未找到 控制器文件 {$do}::{$p} : {$file}");
        }
        include $file;
        exit;
    }
    public function template($filename, $type = true)
    {
		return page($filename,$type);
    }
}