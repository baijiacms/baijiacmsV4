<?php
 if (!defined('IN_IA')){
    exit('Access Denied');
}
if (!class_exists('UserModel')) {
class UserModel{
    private $sessionid;
    public function __construct(){
        global $_W;
        $this -> sessionid = "__cookie_eshop_".CORE_VERSION."_{$_W['uniacid']}";
    }
    function getOpenid($mustlogin=true){
        return get_sysopenid($mustlogin);
    }
        
    function followed($openid = ''){
        global $_W;
        $followed = !empty($openid);
        if ($followed){
            $weixin_fans =get_weixin_fans_info('',$openid);
            $followed = $weixin_fans['follow'] == 1;
        }
        return $followed;
    }
}
}