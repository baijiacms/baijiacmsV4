<?php

if(!defined('IN_IA')) {
     exit('Access Denied');
}
require_once IA_ROOT. '/system/eshop/defines.php';
require_once eshop_CORE.'core.php';
class eshopAddons extends Core { 
  
    //购物车入口
    public function doMobileCart(){ $this->_exec('doMobileShop','cart',false); }
    //我的收藏入口
    public function doMobileFavorite(){ $this->_exec('doMobileShop','favorite',false); }
    //会员
    public function doMobileMember(){ $this->_exec(__FUNCTION__,'center',false); }
    //商城
    public function doMobileShop(){ $this->_exec(__FUNCTION__,'index',false); }
    //订单
    public function doMobileOrder(){ $this->_exec(__FUNCTION__,'list',false); }
  	//工具
    public function doMobileUtil(){ $this->_exec(__FUNCTION__,'',false); }
    

   public function doMobileGoods(){ $this->_exec(__FUNCTION__,'index',false); } 

   public function doMobileSale(){ $this->_exec(__FUNCTION__,'index',false); } 

   public function doMobileVerify(){ $this->_exec(__FUNCTION__,'index',false); } 
 public function doMobilePoster(){ $this->_exec(__FUNCTION__,'index',false); } 

 public function doMobileCommission(){ $this->_exec(__FUNCTION__,'index',false); } 


public function doMobileCoupon(){ $this->_exec(__FUNCTION__,'index',false); } 

}