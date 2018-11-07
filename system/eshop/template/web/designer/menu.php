<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<!-- 导入CSS样式 -->
<link href="<?php  echo RESOURCE_ROOT;?>eshop/static/designer/imgsrc/designer.css" rel="stylesheet">
<link href="<?php  echo RESOURCE_ROOT;?>eshop/static/designer/imgsrc/menu.css" rel="stylesheet">

<?php  if($op=='display') { ?>
<!-- 筛选区域 -->
<div class="panel">
     <h3 class="custom_page_header">  自定义菜单  <a class='btn btn-default' href="<?php  echo $this->createWebUrl('designer/menu', array('op' => 'post'))?>"><i class="fa fa-plus"></i> 添加一个新菜单</a>
                            
       </h3>
    
    <div class='panel-body'>
        <table class="table" >
            <thead>
                <tr>
                    <th style="width:50px; text-align: center;">ID</th>
                    <th style=" text-align: center;">菜单名称</th>
                    <th style=" text-align: center;">创建时间</th>
                    <th style="text-align: center;">菜单类型</th>
                    <th style=" text-align: center;">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(!empty($menus)) { ?>
                    <?php  if(is_array($menus)) { foreach($menus as $menu) { ?>
                        <tr menuid="<?php  echo $menu['id'];?>">
                            <td style="width:60px; text-align: center;"><?php  echo $menu['id'];?></td>
                            <td style=" text-align: center;"><?php  echo $menu['menuname'];?></td>
                            <td style="width:150px; text-align:  center;"><?php  echo date('Y-m-d H:i',$menu['createtime'])?></td>
                            <td style="width:100px; text-align:  center;" data-id="<?php  echo $menu['id'];?>">
                                 <?php  if($menu['isdefault']==1) { ?>
                                      <label class='label label-success' style="cursor: pointer;" title="点击设置成自定义" data-do="off" onclick="setdefault(this,<?php  echo $menu['id'];?>)">全站统一菜单</label>
                                 <?php  } else { ?>
                                      <label class='label label-primary' style="cursor: pointer;" title="点击设置成全站统一菜单" data-do="on" onclick="setdefault(this,<?php  echo $menu['id'];?>)">自定义</label>
                                 <?php  } ?>
                            </td>
                            <td style="width:150px; text-align:  center;">
                             
                                <a class='btn btn-default' href="<?php  echo $this->createWebUrl('designer/menu',array('op'=>'post','menuid'=>$menu['id']))?>">编辑</a>
                               <a class='btn btn-default'  href="javascript:;" onclick="delmenu(<?php  echo $menu['id'];?>)">删除</a>
                            </td>
                        </tr>
                    <?php  } } ?>
                <?php  } else { ?>
              
                    <tr> 
                        <td style="text-align: center; line-height: 100px;" colspan="8">暂时没有自定义菜单</td>
                    </tr>
                
                <?php  } ?>     
            
               
            </tbody>
        </table><?php  echo $pager;?>
    </div>
</div>

        <!-- 预览 start -->
                <div id="modal-module-menus2"  class="modal fade" tabindex="-1">
                    <div class="modal-dialog" style='width: 413px;'>
                                <div class="fe-phone">
                                    <div class="fe-phone-left"></div>
                                    <div class="fe-phone-center">
                                        <div class="fe-phone-top"></div>
                                        <div class="fe-phone-main">
                                            <iframe style="border:0px; width:342px; height:600px; padding:0px; margin: 0px;" src=""></iframe>
                                        </div>
                                        <div class="fe-phone-bottom" style="overflow:hidden;">
                                            <div style="height:52px; width: 52px; border-radius: 52px; margin:20px 0px 0px 159px; cursor: pointer;" data-dismiss="modal" aria-hidden="true" title="点击关闭"></div>
                                        </div>
                                    </div>
                                    <div class="fe-phone-right"></div>
                                </div>
                    </div>
                </div>
        <!-- 预览 end -->    
<script type="text/javascript">
    function preview(menuid){
        var url = "<?php  echo $this->createMobileUrl('designer')?>&preview=1&menuid="+menuid;
        $('#modal-module-menus2').find("iframe").attr("src",url);
        popwin = $('#modal-module-menus2').modal();
    }
    function delmenu(id){
        if(confirm('此操作不可恢复，确认删除？')){
             $.ajax({
                type: 'POST',
                url: "<?php  echo $this->createWebUrl('designer/menu',array('op'=>'delete'))?>",
                data: {menuid:id},
                success: function(data){
                    if(data=='success'){
                        $("tr[menuid="+id+"]").fadeOut();
                    }
                    else{
                        alert(data);
                    }
                },
                error: function(){
                    alert('操作失败~请刷新页面重试！');
                }
            });
        }
    }
    function setdefault(t,id){
        thisdo = $(t).data("do");
        d = thisdo;
        $.ajax({
            type: 'POST',
   
            url: "<?php  echo $this->createWebUrl('designer/menu',array('op'=>'setdefault'))?>",
            data: {d:d,menuid:id},
            success: function(data){
                if(data=='success'){
                    location.reload();
                    return;
                }
                alert(data);
            },
            error: function(){
                alert('操作失败~请刷新页面重试！');
            }
        });
    }
</script>
<?php  } else if($op=='post') { ?>
<!-- 编辑页面 -->

<div class='panel panel-default' ng-app="FoxEditor" style="background: #f2f2f2">
    <div class='panel-heading' style="background: #ffffff"> 菜单编辑 <?php  if($_GPC['menuid']!='') { ?>(ID: <?php  echo $_GPC['menuid'];?>)<?php  } ?></div>
    
    <div class='panel-body' ng-controller="FoxController">
        <div class="fe">
           
            <div class="fe-phone">
                <div class="fe-phone-left"></div>
                <div class="fe-phone-center">
                    <div class="fe-phone-top"></div>
                    <div class="fe-phone-main fe-phone-main-menu" >
                        <div id="editor" ng-style="{background: params.previewbg}" on-finish-render-filters >
                            <?php include $this->template("temp/show-diymenu");?>
                          </div>
                    </div>
                    <div class="fe-phone-bottom"></div>
                </div>
                <div class="fe-phone-right"></div>
            </div>
            <div class="fe-panel">
              
                <!-- editor start -->
                <div class="fe-panel-editor" ng-show="focus" >
                     <?php include $this->template("temp/edit-diymenu");?>
                </div>
                <!-- editor end -->
            </div>
        </div>
     
    </div>
 
<script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/designer/imgsrc/angular.min.js"></script>
<script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/designer/imgsrc/angular-ueditor.js"></script>
<script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>eshop/static/designer/imgsrc/hhSwipe.js"></script>
 
<script type="text/javascript">
    function switchtab(tag,n){
        $("#"+tag+"-"+n).fadeIn().siblings().hide();
        $("#"+tag+"-nav-"+n).addClass("active").siblings().removeClass("active");
    }
    
    $(function(){
        require(['util'], function (util) {
            var preview_id = util.cookie.get('preview_id');
            if(preview_id){
                preview(preview_id);
            }
        });
  
       $(".fe-save-info-type-ok").click(function(){
           var pagetype = $(this).data("type");
           if(pagetype!='2' || pagetype!='3'){
                $(this).find(".fe-save-main-radio").addClass("fe-save-main-radio2").text("√");
                $(this).siblings().find(".fe-save-main-radio").removeClass("fe-save-main-radio2").text("");
           }
           $("input[name=pagetype]").val(pagetype);
       }); 
    });
    
    var myModel = angular.module('FoxEditor',['ng.ueditor']);

    myModel.controller('FoxController', ['$scope', function($scope){
            $scope.menus = <?php  echo json_encode($menus)?>;
            $scope.params = <?php  echo json_encode($params)?>;
            $scope.underscore = null;
            require(['underscore'],function(underscore){
                $scope.underscore = underscore;
            });
              $scope.clear =function(m){
                 angular.forEach($scope.menus, function(m,index) {
                        m.textcolor  =index==0?$scope.params.textcolorhigh:$scope.params.textcolor;
                        m.bgcolor  =index==0?$scope.params.bgcolorhigh:$scope.params.bgcolor;
                        m.iconcolor  = index==0?$scope.params.iconcolorhigh:$scope.params.iconcolor;
                        m.bordercolor  = index==0?$scope.params.bordercolorhigh:$scope.params.bordercolor;
                 });
            }
        
             // 1.1 选择链接
            $scope.chooseUrl = function(){
                //$('#floating-link').attr({"menid":Mid,"Cid":Cid,T:T});
                $('#floating-link').modal();
            }
            $scope.selectUrl = function(menu,event){  
            	   $scope.currentMenu = menu;   
                $('#floating-link').modal();
   
 }
 
 $scope.ajaxselect= function(type){
                val = $("#select-"+type+"-kw").val();
           
                $.ajax({
                    type: 'post',
                    dataType:'json',
                    url: "<?php  echo create_url('site',array('act' => 'public','do' => 'selectlink'))?>",
                    data: {kw:val,type:type},
                  success: function(data){
                        $scope.temp[type]=data;
                        $scope.$apply();
                    },
                    error: function(){
                        alert('查询失败！请刷新页面。');
                    }
                });
            }
   

  $scope.chooseUrl = function(menu){
                $scope.currentMenu = menu;
                $('#floating-link').modal();
            }
            
            $scope.chooseLink = function(type,hid){
                $scope.currentMenu.url =  $("#fe-tab-link-"+type+" #fe-tab-link-li-"+hid).data("href");
                $('#floating-link .close').click();
            }
 $scope.confirmUrl = function(menu,event){

     $(event.currentTarget).closest('.popovermenu').toggle();
 }
 $scope.clearUrl = function(menu,event){

        menu.url = '';
     
 }

            $scope.selectIcon = function(menu,event){
				require(["util","jquery"], function(u, $){
					var btn = $(event.currentTarget);
					var spview = btn.parent();
					var ipt = spview.find('.icon');
					u.iconBrowser(function(ico){
						ipt.val(ico);
						menu.icon = ico;
                                                                                                            $scope.$apply();
                                                                                                             
					});
				});
                
            }
            $scope.addMenu = function() {
				if($scope.menus.length >= 5) {
					return;
				}
                                                                        var mid = "menu_" + new Date().getTime();
				$scope.menus.push({
                                                                                          id: mid,
					title: '',
                                                                                          icon:'',
					url: '',
					subMenus: []
				});
				    require(['jquery.ui'],function(){
                                                                            $('.ui-sortable').sortable({handle: '.btn-move'});
                                                                        });
                                                                        $scope.clear();
			};
                        
$scope.addSubMenu = function(menu, obj) {
				$('.parentmenu').eq(obj.$index).find('a').eq(2).hide();
				if(menu.subMenus.length >= 5) {
					return;
				}
				menu.subMenus.push({
					title: '',
					type: 'url',
					url: '',
					forward: ''
				});
				    require(['jquery.ui'],function(){
                    $('.ui-sortable').sortable({handle: '.btn-move'});
                });
			};
                        
                        $scope.deleteMenu = function(menu, sub, obj) {
				if(sub) {
					if (typeof obj == 'object') {
						var text = $('.sonmenu').eq(obj.$parent.$index).find('input[type="text"]').eq(obj.$index);
                                                
						if (text.val() != '') {
							if (confirm('将删除该菜单, 是否继续? ')) {
								if (menu.subMenus.length == 1) {
									$('.parentmenu').eq(obj.$parent.$index).find('a').eq(2).show();
								}
								menu.subMenus = _.without(menu.subMenus, sub);
							}
						} else {
							if (menu.subMenus.length == 1) {
								$('.parentmenu').eq(obj.$parent.$index).find('a').eq(2).show();
							}
							menu.subMenus = _.without(menu.subMenus, sub);
						}
					}
				} else {
					if(menu.subMenus.length > 0 && !confirm('将同时删除所有子菜单, 是否继续? ')) {
						return;
					}
					$scope.menus = _.without($scope.menus, menu);
                                        $scope.clear();
				}
			};
             
            //选择链接
            $scope.currentMenu = null;
       
            
         
            $scope.temp = {
                notcie:[]
            };
        
            
            $scope.focus = 'M0000000000000';
        
            $scope.save = function(){
               var menuid = "<?php  echo $menuid;?>";
               var menus = angular.toJson($scope.menus);
               var params = angular.toJson($scope.params);
               var menuname = $.trim( $(":input[name=menuname]").val() );
               var isdefault = $('input:radio[name="isdefault"]:checked').val();
               if(!menuname){
                   alert('请填写菜单名称!');
                   $(":input[name=menuname]").focus();
                   return;
               }
               $(".fe-save-submit").text('保存中...').addClass("fe-save-disabled").data('saving','1');
               $(".fe-save-submit2").css("color","#bbb");
               if($(".fe-save-submit").data('saving')==1){
                    $.ajax({
                        type: 'POST',
                        dataType:'json',
                        url: "<?php  echo $this->createWebUrl('designer/menu',array('op'=>'post'))?>",
                        data: {
                            menuid: menuid,
                            menuname:menuname,
                            isdefault:isdefault,
                            params:params, 
                            menus:menus},
                        success: function(data){
                            if(data.result=='1'){
                                alert("保存成功！");
                                location.href = "<?php  echo $this->createWebUrl('designer/menu')?>" ;
                            }else{
                                alert(data.message);
                                $(".fe-save-submit").text('保存').removeClass("fe-save-disabled").data('saving','0');
                                $(".fe-save-submit2").css("color","#4bb5fb")
                            }
                        }
                        ,error: function(){
                            alert('保存失败请重试');
                            $(".fe-save-submit").text('保存').removeClass("fe-save-disabled").data('saving','0');
                            $(".fe-save-submit2").css("color","#4bb5fb")
                        }
                    });
               }
            }
   
                require(['jquery.ui'],function(){
                    $('.ui-sortable').sortable({handle: '.btn-move'});
                });
                $scope.openMenu = function(menu,event)          {
                    if(menu.subMenus.length<=0){
                        return;
                    }
                    $('.sub').hide();
                    var li = $(event.currentTarget).closest('li');
                    li.find('.sub').toggle().css('width',li.width()-10).css('opacity',1);
                    angular.forEach($scope.menus, function(m,index) {
                           m.textcolor  =m==menu?$scope.params.textcolorhigh:$scope.params.textcolor;
                           m.bgcolor  =m==menu?$scope.params.bgcolorhigh:$scope.params.bgcolor;
                           m.iconcolor  = m==menu?$scope.params.iconcolorhigh:$scope.params.iconcolor;
                           m.bordercolor  = m==menu?$scope.params.bordercolorhigh:$scope.params.bordercolor;
                    });
              
                }
 
    }]);
 

            
</script>

<?php  } ?>
<?php include page("footer-base");?>
