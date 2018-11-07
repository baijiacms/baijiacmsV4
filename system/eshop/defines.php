<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}
define('eshop_DEBUG', false);//false
!defined('eshop_PATH') && define('eshop_PATH', IA_ROOT . '/system/eshop/');
!defined('eshop_CORE') && define('eshop_CORE', eshop_PATH . 'core/');
!defined('eshop_URL') && define('eshop_URL', $_W['siteroot'] . 'system/eshop/');
!defined('eshop_STATIC') && define('eshop_STATIC', eshop_URL . 'static/');
!defined('eshop_PREFIX') && define('eshop_PREFIX', 'eshop_');
