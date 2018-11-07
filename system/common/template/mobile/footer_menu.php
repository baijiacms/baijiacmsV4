<?php defined('IN_IA') or exit('Access Denied');?>
<?php  if($show_footer) { ?>
<?php
if(empty($set_footer_menuid))
{
$diymenu = mysqld_select('select id,menus,params from ' . tablename('eshop_designer_menu') . ' where isdefault=1 and uniacid=:uniacid limit 1', array(
                ':uniacid' => $GLOBALS['_CMS']['beid']
            ));
            
          }else
          {
          	$diymenu = mysqld_select('select id,menus,params from ' . tablename('eshop_designer_menu') . ' where id=:id and uniacid=:uniacid limit 1', array(
                ':uniacid' => $GLOBALS['_CMS']['beid'], ':id' => $set_footer_menuid
            ));
          }
            ?>

<?php if(!empty($diymenu['id'])) {
	$diymenu_menus=$diymenu['menus'];
	$diymenu_params=$diymenu['params'];
}else
{
$diymenu_menu1_text="首页";
$diymenu_menu1_url=create_url('mobile',array('do'=>'shop','act'=>'index','m'=>'eshop'));
$diymenu_menu2_text="分类";
$diymenu_menu2_url=create_url('mobile',array('do'=>'shop','act'=>'category','m'=>'eshop'));
$diymenu_menu3_text="购物车";
$diymenu_menu3_url=create_url('mobile',array('do'=>'shop','act'=>'cart','m'=>'eshop'));
$diymenu_menu4_text="会员中心";
$diymenu_menu4_url=create_url('mobile',array('act' => 'shopwap','do' => 'membercenter'));


$diymenu_menus='[{"id":1,"title":"'.$diymenu_menu1_text.'","icon":"fa fa-home","url":"'.$diymenu_menu1_url.'","subMenus":[],"textcolor":"#666666","bgcolor":"#fafafa","bordercolor":"#bfbfbf","iconcolor":"#666666"},{"id":"menu_1473989898623","title":"'.$diymenu_menu2_text.'","icon":"fa fa-list","url":"'.$diymenu_menu2_url.'","subMenus":[],"textcolor":"#666666","bgcolor":"#fafafa","iconcolor":"#666666","bordercolor":"#bfbfbf"},{"id":"menu_1473989899293","title":"'.$diymenu_menu3_text.'","icon":"fa fa-shopping-cart","url":"'.$diymenu_menu3_url.'","subMenus":[],"textcolor":"#666666","bgcolor":"#fafafa","iconcolor":"#666666","bordercolor":"#bfbfbf"},{"id":"menu_1473989899829","title":"'.$diymenu_menu4_text.'","icon":"fa fa-user","url":"'.$diymenu_menu4_url.'","subMenus":[],"textcolor":"#666666","bgcolor":"#fafafa","iconcolor":"#666666","bordercolor":"#bfbfbf"}]';
$diymenu_params='{"previewbg":"#999999","height":"49px","textcolor":"#666666","textcolorhigh":"#666666","iconcolor":"#666666","iconcolorhigh":"#666666","bgcolor":"#fafafa","bgcolorhigh":"#fafafa","bordercolor":"#bfbfbf","bordercolorhigh":"#bfbfbf","showtext":1,"showborder":1,"showicon":1,"textcolor2":"#666666","bgcolor2":"#fafafa","bordercolor2":"#bfbfbf","showborder2":1}';
}  ?>


<div id="designer-nav" >	
<script type="text/javascript" src="<?php  echo WEBSITE_ROOT;?>/assets/eshop/static/designer/imgsrc/angular.min.js"></script>
<style>
	
.designer-menu {
	position: absolute;
	margin: 0px;
	padding: 0px;
	bottom: 0px;
	width: 100%;
	height: 49px;
	z-index: 999;
}

.designer-menu ul {
	position: relative;
	padding: 0;
	margin: 0;
	list-style-type: none;
	width: 100%;
	height: 100%;
}

.designer-menu ul li {
	float: left;
	height: 100%;
	text-align: center;
	position: relative;
	font-size: 14px;
}

.designer-menu-w1 {
	width: 100%;
}

.designer-menu-w2 {
	width: 50%;
}

.designer-menu-w3 {
	width: 33.33%;
}

.designer-menu-w4 {
	width: 25%;
}

.designer-menu-w5 {
	width: 20%;
}

.designer-menu-noborder {
	border: none
}

.designer-menu-border {
	border-top-style: solid;
	border-top-width: 1px;
}

.designer-menu-line {
	line-height: 49px;
}

.designer-menu-block {
	display: block;
	width: 100%;
}

.designer-menu-icon {
	font-size: 16px;
	padding-top: 5px;
	width: 92%;
}

.designer-menu-text {
	line-height: 20px;
	font-size: 13px;
	height: 20px;
	width: 92%;
	overflow: hidden;
}

.designer-menu-bg {
	position: absolute;
	z-index: 15;
	width: 100%;
	height: 100%;
}

;
.designer-menu-floatleft {
	float: left;
}

.designer-menu ul li {
	position: relative;
}

.designer-menu ul li .designer-menu-item {
	position: absolute;
	top: 0px;
	left: 0px;
	width: 100%;
	height: 49px;
	z-index: 20;
	padding: 0 0px;
	text-align: center;
	
	overflow: hidden;
	word-break: break-all;
}

.designer-menu ul li .designer-menu-item span {
	text-align: center; border:1px solid transparent; width:100%; text-align: center;
	
}

.designer-menu ul li .sub {
	position: absolute;
	bottom: 0px;
	margin-bottom: 15px;
	height: auto;
	text-align: center;
	z-index: 10;
	left: 50%;
	margin-left: -50px;
	background: #fafafa;
	opacity: 0;
	border-width: 1px;
	border-style: solid;
	width: auto;
	min-width: 100px;
	max-width: 120px;
	border-radius: 3px;
	/* 圆角 */
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
}

.designer-menu ul li .sub a {
	height: 43px;
	line-height: 43px;
	text-decoration: none;
	border-bottom-width: 1px;
	padding: 0 10px;
	border-bottom-style: solid;
	text-align: center;
	display: block;
	overflow: hidden;
	word-break: break-all
}

.designer-menu ul li .sub a:last-child {
	border: none
}

.designer-menu ul li .sub .corner {
	position: absolute;
	bottom: -20px;
	left: 50%;
	z-index: 998;
	width: 0;
	height: 0;
	border-width: 10px;
	border-style: solid dashed dashed;
	border-left-color: transparent;
	border-right-color: transparent;
	border-bottom-color: transparent;
	font-size: 0;
	line-height: 0;
	margin-left: -10px;
}

.designer-menu ul li .sub .corner2 {
	position: absolute;
	bottom: -16px;
	left: 50%;
	z-index: 999;
	margin-left: -8px;
	width: 0;
	height: 0;
	border-width: 8px;
	border-style: solid dashed dashed;
	border-left-color: transparent;
	border-right-color: transparent;
	border-bottom-color: transparent;
	font-size: 0;
	line-height: 0;
}

.designer-menu ul li .designer-menu-spliter {
	width: 1px;
	height: 100%;
	position: absolute;
	right: 0px;
	z-index: 22
}

.designer-menu ul li:last-child .designer-menu-spliter {
	display: none;
}
.designer-menu-label
{
cursor: pointer;	
}
	</style>
<div ng-app="myApp" >
	
<div ng-controller="MenuCtrl">
<div class="designer-menu"  style='position: fixed;bottom:0px;<?php if(is_mobile()==false){?>max-width: 750px;margin:auto;<?php }?>' data-bgalpha="{{params.bgalpha}}" >
    <ul>
        <li ng-repeat="menu in menus"
            ng-class="{'designer-menu-line':params.showicon==0 || params.showicon==1,'designer-menu-w1':menus.length == 1,
                        'designer-menu-w2':menus.length == 2,'designer-menu-w3':menus.length == 3,'designer-menu-w4':menus.length == 4,
                        'designer-menu-w5':menus.length == 5,'designer-menu-border': params.showborder==1,'designer-menu-noborder': params.showborder!=1}"
            ng-style="{'border-top-color': menu.bordercolor}"
            ng-click="openMenu(menu,$event)"
            >
         <div class="designer-menu-bg" ng-style="{'background':menu.bgcolor,'opacity':params.bgalpha}"></div>
          <div class="designer-menu-item" ng-style="{'color':menu.textcolor}" >
                <span ng-class="{'designer-menu-block':params.showicon==2,'designer-menu-icon':params.showicon==2}"><i class="{{menu.icon}} "  ng-style="{color:menu.iconcolor}" ng-show="params.showicon!=0"></i></span>
                <span class='designer-menu-label' ng-class="{'designer-menu-block':params.showicon==2,'designer-menu-text':params.showicon==2}"  ng-show="params.showtext==1"> {{menu.title}}</span>
          </div>
           <div class="sub" ng-style="{'border-color':params.bordercolor2,'background':params.bgcolor2}">
                <span>
                    <a 
                        class="designer-menu-link"
                        ng-repeat="sub in menu.subMenus" 
                        ng-style="{'border-bottom-color':params.bordercolor2,'color':params.textcolor2}"
                        href="{{sub.url}}">{{sub.title}}</a>
                </span>
                <div class="corner"  ng-style="{'border-top-color':params.bordercolor2}"></div>
                <div class="corner2"  ng-style="{'border-top-color':params.bgcolor2}"></div>
            </div>
            <div class="designer-menu-spliter"  ng-show="params.showborder==1" ng-style="{'background':menu.bordercolor}"></div>
        
          </li>
    </ul>
</div>
</div>
</div>




<script type="text/javascript">
   var app = angular.module('myApp', []);
    app.controller('MenuCtrl', ['$scope', function($scope){
    
            $scope.menus = <?php echo $diymenu_menus;?>;
            $scope.params = <?php echo $diymenu_params;?>;
            $scope.clear =function(m){
                 angular.forEach($scope.menus, function(m,index) {

                    m.textcolor  = $scope.params.textcolor;
                    m.bgcolor  =$scope.params.bgcolor;
                    m.iconcolor  = $scope.params.iconcolor;
                    m.bordercolor  = $scope.params.bordercolor;

                 });
            }
            $scope.clear();
            $scope.openMenu = function(menu,event){
                 if(menu.subMenus.length<=0){
                        if(menu.url==''){
                            return;
                        }
                        location.href = menu.url;
                         return;
                    }
                    var current = $(event.currentTarget).closest('li').find('.sub');
                    var h = current.height();
                    $scope.clear();
                    var bgalpha = $scope.params.bgalpha ;
                    //!$.isNumber(bgalpha)|| 
                    if(  parseFloat(bgalpha )>1){
                        bgalpha = 1;
                    }
          
                     if(bgalpha!=1){
                              //有透明度
                              if(parseInt(current.css('opacity'))>=1){ //弹出后隐藏
                                    current.animate({opacity:0,bottom:-h-50},200);    
                            } else{
                                current.css('bottom',50).animate({opacity:1},200);        
                                 menu.textcolor  = $scope.params.textcolorhigh;
                                 menu.bgcolor  = $scope.params.bgcolorhigh;
                                 menu.iconcolor  = $scope.params.iconcolorhigh;
                                 menu.bordercolor  = $scope.params.bordercolorhigh;
                            }
                                $(event.currentTarget).siblings().closest('li').find('.sub').each(function(){
                            var h = $(this).height();
                           $(this).animate({opacity:0},200); 
                     });
                     }
                     else{
                           if(parseInt(current.css('bottom'))>0){
                                current.animate({bottom:-h-50,opacity:0},200);       
                           } else{
                                current.animate({bottom:50,opacity:1},200);        
                                menu.textcolor  = $scope.params.textcolorhigh;
                                menu.bgcolor  = $scope.params.bgcolorhigh;
                                menu.iconcolor  = $scope.params.iconcolorhigh;
                                menu.bordercolor  = $scope.params.bordercolorhigh;
                           }
                               $(event.currentTarget).siblings().closest('li').find('.sub').each(function(){
                           var h = $(this).height();
                          $(this).animate({bottom:-h-50,opacity:0},200); 
                    });
                     }
                  
                
            }
    }]);
$(function(){
	var len =$('.designer-menu .sub').length;
 
    $('.designer-menu .sub').each(function(i){
         var h = $(this).height();
         var w = $(this).closest('li').width();
   
         $(this).css('bottom',  -h-50);
         var left = parseFloat( $(this).offset().left.toString().replace('px',''));
         if(i==0){
         	if(left<0){
         		left =Math.abs(left);
         		$(this).offset({left:5});
         	 
         		var corner = $(this).find('.corner');
         		var cornerleft = ( parseFloat( $(this).css('left').replace('px','')) - left  ) /2 + 5;
         		corner.css('left',cornerleft);
         	    $(this).find('.corner2').css('left',cornerleft);
         	}
        }else if(i+1==len){
        	
        	var right = $(this).width() + left;
         	if(right>=$(document).width()){
         		var newoffset = $(document).width() - $(this).width() - 5;
         	    $(this).offset({left:newoffset});
         	    
         	    
         	    var corner = $(this).find('.corner');
         	    var cornerleft= ($(this).width() - $(this).closest('li').width()) / 2 + $(this).width()/2 + 5;
         		corner.css('left',cornerleft);
         	    $(this).find('.corner2').css('left',cornerleft);
         	    
         	}
        }
         
    })
})
</script>

</div>

<?php  } ?> 

