<?php

if(!defined('IN_IA')) {
     exit('Access Denied');
}
require_once IA_ROOT. '/system/eshop/defines.php';
require_once eshop_CORE.'core.php';
class eshopAddons extends Core { 
          public function doWebIndex(){ 	$url=create_url('site',array('act' => 'index','do' => 'shop','m' => 'eshop'));
		header("Location: ".$url);  }
    //商城管理 
    public function doWebShop(){ $this->_exec(__FUNCTION__ ,'goods'); }
    //订单管理  
    public function doWebOrder(){ $this->_exec(__FUNCTION__,'list'); }
    //会员管理
    public function doWebMember(){ $this->_exec(__FUNCTION__,'list'); }
    //财务管理
    public function doWebFinance(){ $this->_exec(__FUNCTION__,'log'); }
    //统计分析
    public function doWebStatistics(){ $this->_exec(__FUNCTION__,'sale'); }
    //系统设置 
    public function doWebSysset(){ $this->_exec(__FUNCTION__,'sysset'); } 
    //插件web入口  
      public function doWebDesigner(){ $this->_exec(__FUNCTION__,'index'); } 

   public function doWebSale(){ $this->_exec(__FUNCTION__,'index'); } 

   public function doWebVerify(){ $this->_exec(__FUNCTION__,'index'); } 
 public function doWebPoster(){ $this->_exec(__FUNCTION__,'index'); } 

 public function doWebCommission(){ $this->_exec(__FUNCTION__,'index'); } 

public function doWebCoupon(){ $this->_exec(__FUNCTION__,'index'); } 
public function doWebVirtual(){ $this->_exec(__FUNCTION__,'index'); } 

}