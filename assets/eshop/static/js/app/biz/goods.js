/*
 * 人人商城
 * 
 * QQ:834633039
 */
define(['jquery','core'], function($,core){
    var shop = {
        category: { }
    };
    //获取店铺分类
    shop.getCategory = function(callback){
             core.json('shop/util/category',{},function(ret){
              shop.category = ret;
              if(callback){
                  callback(ret);
              }
           });
    }
    return shop;
});

