<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page("header-base");?>

<script>
window.uploader_file_fetch="<?php echo create_url("site",array("do"=>"file","act"=>"public","op"=>"fetch","showallurl"=>true));?>";
	window.uploader_file_local="<?php echo create_url("site",array("do"=>"file","act"=>"public","op"=>"local","showallurl"=>true));?>";
		window.uploader_file_image="<?php echo create_url("site",array("do"=>"file","act"=>"public","op"=>"upload","type"=>"image","showallurl"=>true));?>";
		window.uploader_file_audio="<?php echo create_url("site",array("do"=>"file","act"=>"public","op"=>"audio","showallurl"=>true));?>";

	
	window.DIYSHOP_DIY_SAVE_URL= '<?php echo $this->createWebUrl('designer',array('op'=>'save','pageid'=>$page['id']));?>';
window.DIYSHOP_BASE_IMAGEURL='<?php  echo RESOURCE_ROOT;?>eshop/static/images/default/';
window.DIYSHOP_DIY_SEARCHGOODS_URL= '<?php echo $this->createWebUrl('designer',array('op'=>'api','apido'=>'selectgood','pageid'=>$page['id']));?>';
 window.DIYSHOP_DIY_LIST_URL= '<?php echo $this->createWebUrl('designer',array('op'=>'display','pageid'=>$page['id']));?>';
	</script>
        <script src="<?php  echo RESOURCE_ROOT;?>eshop/static/js/dist/jquery/jquery.gcjs.js"></script>

 <script> 
       	var version = "<?php  echo time();?>";
var myconfig =  {
	path: '<?php  echo RESOURCE_ROOT;?>eshop/static/js/',
  alias:{ 
		 'jquery': 'dist/jquery/jquery-1.11.1.min',
		 'jquery.form' : 'dist/jquery/jquery.form',
		 'jquery.gcjs' : 'dist/jquery/jquery.gcjs',
		 'jquery.validate': 'dist/jquery/jquery.validate.min',
                     'jquery.nestable': 'dist/jquery/nestable/jquery.nestable',
		 'bootstrap' : 'dist/bootstrap/bootstrap.min',
		 'bootstrap.suggest' : 'dist/bootstrap/bootstrap-suggest.min',
		 'bootbox' : 'dist/bootbox/bootbox.min',
		 'sweet':  'dist/sweetalert/sweetalert.min',
		 'select2':  'dist/select2/select2.min',
		 'jquery.confirm' : 'dist/jquery/confirm/jquery-confirm',
                     'jquery.contextMenu' : 'dist/jquery/contextMenu/jquery.contextMenu',
                     'switchery': 'dist/switchery/switchery',
		 'echarts': 'dist/echarts/echarts-all',
                     'toast': 'dist/jquery/toastr.min',
			  'tpl':'dist/tmodjs',
	}, 
	 map:{
		'js':'.js?v='+version,
		'css':'.css?v='+version
	},
  css: {
	       'jquery.confirm' : 'dist/jquery/confirm/jquery-confirm',
	       'sweet' : 'dist/sweetalert/sweetalert',
	       'select2': 'dist/select2/select2,dist/select2/select2-bootstrap',
                 'jquery.nestable': 'dist/jquery/nestable/nestable',
                 'jquery.contextMenu' : 'dist/jquery/contextMenu/jquery.contextMenu',
                 'switchery': 'dist/switchery/switchery' 
	 }
	 ,preload:['jquery']
	
};
var myrequire = function(arr, callback) {
	var newarr = [ ];
	$.each(arr, function(){
		var js = this;
		
		if( myconfig.css[js]){
			var css = myconfig.css[js].split(',');
			$.each(css,function(){
				 newarr.push( "css!" +  myconfig.path + this + myconfig.map['css']);
			});
			 
		         
		}
		
		var jsitem = this; 
		if( myconfig.alias[js]){
		      jsitem = myconfig.alias[js];

		}
		newarr.push(  myconfig.path + jsitem + myconfig.map['js']);
	});
	require(newarr,callback);
};
myrequire.path = "<?php  echo RESOURCE_ROOT;?>eshop/static/js/";
       	</script>
<?php include $this->template('diypage/_common', TEMPLATE_INCLUDEPATH);?>

		<div style="display: block;" class="page-content">
        
<div class="page-heading">
  
    <h3 style="color: #478fca !important;font-weight: lighter;font-size: 21px">
       &nbsp;&nbsp; DIY页面            </h3>
</div>

<div class="diy-phone">
    <div class="phone-head"></div>
    <div class="phone-body">
        <div class="phone-title" id="page">请输入页面标题</div>
        <div style="background-color: rgb(250, 250, 250);" class="phone-main ui-sortable" id="phone">
            <p style="text-align: center; line-height: 400px">您还没有添加任何元素</p>
        </div>
    </div>
    <div class="phone-foot"></div>
</div>

<div data-editid="page" style="margin-top: 50px; display: block;" class="diy-editor form-horizontal" id="diy-editor">
    <div class="editor-arrow"></div>
    <div class="inner"><div class="form-group">
        <div class="col-sm-2 control-label">页面名称</div>
        <div class="col-sm-10">
            <input class="form-control input-sm diy-bind" data-bind="name" data-placeholder="请输入名称" placeholder="请输入名称" value="未命名页面">
            <div class="help-block">注意：页面名称是便于后台查找，页面标题是手机端标题。</div>
        </div>
    </div>
  <div class="form-group">
        <div class="col-sm-2 control-label">页面类型</div>
        <div class="col-sm-10">
          普通页面<input type="radio" value="0" class="diy-bind" data-bind="pagetype" data-bind-init="true" checked="checked">，商城首页<input type="radio" value="1" class="diy-bind" data-bind="pagetype" data-bind-init="true">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 control-label">页面标题</div>
        <div class="col-sm-10">
            <input class="form-control input-sm diy-bind" data-bind="title" data-placeholder="请输入标题" placeholder="请输入标题" value="请输入页面标题">
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-2 control-label">背景颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind="background" value="#fafafa" type="color">
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#fafafa').trigger('propertychange')">重置</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">底部菜单</div>
        <div class="col-sm-10">
            <select class="form-control input-sm diy-bind" data-bind="diymenu">
                <option value="-1" selected="selected">不显示</option>
                <option value="0">系统默认</option>
                
            </select>
        </div>
    </div></div><div style="margin-top:150px"></div>
</div>

<div class="diy-menu">
    <div style="display: block;" class="navs" id="navs"><nav class="btn btn-link" data-id="page"><i class="fa fa-cog"></i> 页面设置</nav>
    
        <nav class="btn btn-link" data-id="notice"><i class="fa fa-plus"></i> 公告</nav>
    
        <nav class="btn btn-link" data-id="richtext"><i class="fa fa-plus"></i> 富文本</nav>
    
        <nav class="btn btn-link" data-id="banner"><i class="fa fa-plus"></i> 图片幻灯片</nav>
    
        <nav class="btn btn-link" data-id="title"><i class="fa fa-plus"></i> 标题栏</nav>
    
        <nav class="btn btn-link" data-id="line"><i class="fa fa-plus"></i> 辅助线</nav>
    
        <nav class="btn btn-link" data-id="blank"><i class="fa fa-plus"></i> 辅助空白</nav>
    
        <nav class="btn btn-link" data-id="search"><i class="fa fa-plus"></i> 搜索框</nav>
        <nav class="btn btn-link" data-id="menu"><i class="fa fa-plus"></i> 按钮组</nav>
    
        <nav class="btn btn-link" data-id="picture"><i class="fa fa-plus"></i> 单图</nav>
    
        <nav class="btn btn-link" data-id="picturew"><i class="fa fa-plus"></i> 组合图片</nav>
    
        <nav class="btn btn-link" data-id="goods"><i class="fa fa-plus"></i> 商品组</nav>
    
    </div>
    <div class="action">
                              
                                    <nav class="btn btn-primary btn-sm btn-save" data-type="save">保存页面</nav>
            </div>
</div>

<script type="text/html" id="tpl_show_notice">
    <div class="drag" data-itemid="<%itemid%>">
        <div class="fui-notice" style="background: <%style.background%>">
            <div class="image"><img src="<%imgsrc params.iconurl%>" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/static/images/default/hotdot.jpg'"></div>
            <div class="icon"><i class="fa fa-bullhorn" style="color: <%style.iconcolor%>;"></i></div>
            <div class="text" style="color: <%style.color%>;">
                <%if params.noticedata=='0'%>这里将读取商城的公告进行滚动显示<%/if%>
                <%if params.noticedata=='1'%>
                    <ul>
                        <%each data as item%>
                            <li><%item.title%></li>
                        <%/each%>
                    </ul>
                <%/if%>
            </div>
        </div>
    </div>
</script>

<script type="text/html" id="tpl_show_richtext">
    <div class="drag" data-itemid="<%itemid%>">
        <div class="diy-richtext" style="background: <%style.background%>; padding: <%style.padding%>px;">
            <%if params.content%>
                <%=decode(params.content)%>
            <%else%>
            <p><span style="font-size: 20px;">这里是富文本演示区域</span></p>
            <p>你可以对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration: underline;">下划线</span>、<span style="text-decoration: line-through;">删除线</span>、文字<span style="color: rgb(0, 176, 240);">颜色</span>、<span style="background-color: rgb(255, 192, 0); color: rgb(255, 255, 255);">背景色</span>、以及字号<span style="font-size: 20px;">大</span><span style="font-size: 14px;">小</span>等简单排版操作。
            </p>
            <p>也可在这里插入图片</p>
            <p><img src="<?php  echo RESOURCE_ROOT;?>eshop/static/images/nopic.jpg"></p>
            <p style="text-align: left;"><span style="text-align: left;">还可给文字加上<a href="http://www.baidu.com">超级链接</a>，方便用户点击。</span></p>
            <%/if%>
        </div>
    </div>
</script>

<script type="text/html" id="tpl_show_banner">
    <div class="drag" data-itemid="<%itemid%>">
        <div class="diy-banner">
            <%each data as item%>
            <img src="<%imgsrc item.imgurl%>" />
            <%/each%>
            <div class="dots <%style.dotalign||'left'%> <%style.dotstyle||'rectangle'%>" style="padding: 0 <%style.leftright||'10'%>px; bottom: <%style.bottom||'10'%>px; opacity: <%style.opacity||'0.8'%>;">
                <%each data as item%>
                    <span style="background: <%style.background||'#000000'%>;"></span>
                <%/each%>
            </div>
        </div>
    </div>
</script>

<script type="text/html" id="tpl_show_title">
    <div class="drag" data-itemid="<%itemid%>">
        <div class="fui-title" style="background: <%style.background||''%>; color: <%style.color||''%>; font-size: <%style.fontsize||'12'%>px; text-align: <%style.textalign||''%>; padding: <%style.paddingtop||'0'%>px <%style.paddingleft||'5'%>px;">
            <%if params.icon%>
                <i class="fa <%params.icon%>"></i>
            <%/if%>
            <%if params.link%>
                <a href="<%params.link%>" style="color: <%style.color||''%>"><%params.title||'请输入标题内容'%></a>
            <%else%>
                <%params.title||'请输入标题内容'%>
            <%/if%>
        </div>
    </div>
</script>

<script type="text/html" id="tpl_show_search">
    <div class="drag" data-itemid="<%itemid%>">
        <div class="diy-search <%style.searchstyle%>" style="background: <%style.background%>; padding: <%style.paddingtop||'10'%>px <%style.paddingleft||'10'%>px;">
            <div class="inner left" style="background: <%style.inputbackground||'#fff'%>;">
                <div class="search-icon" style="color: <%style.iconcolor%>;"><i class="fa-search"></i></div>
                <div class="search-input" style="text-align: <%style.textalign%>; color: <%style.color%>;">
                    <span><%params.placeholder%></span>
                </div>
            </div>
        </div>
    </div>
</script>

<script type="text/html" id="tpl_show_line">
    <div class="drag" data-itemid="<%itemid%>">
        <div class="fui-line-diy" style="background: <%style.background%>; padding: <%style.padding%>px 0;">
            <div class="line" style="border-top: <%style.height||'2'%>px <%style.linestyle||'solid'%> <%style.bordercolor||'#000000'%>"></div>
        </div>
    </div>
</script>

<script type="text/html" id="tpl_show_blank">
    <div class="drag" data-itemid="<%itemid%>" style="height: <%style.height%>px; background: <%style.background%>"></div>
</script>

<script type="text/html" id="tpl_show_menu">
    <div class="drag" data-itemid="<%itemid%>">
        <%if data==''%>
            <div class="nochild">您还没有添加图标</div>
        <%else%>
            <div class="fui-icon-group noborder col-<%style.rownum%> <%style.navstyle%>" style="background: <%style.background||'#ffffff'%>">
                <%each data as item%>
                    <div class="fui-icon-col">
                        <div class="icon"><img src="<%imgsrc item.imgurl%>"></div>
                        <div class="text" style="color: <%item.color%>"><%item.text%></div>
                    </div>
                <%/each%>
            </div>
        <%/if%>
    </div>
</script>

<script type="text/html" id="tpl_show_picture">
    <div class="drag" data-itemid="<%itemid%>">
        <div class="fui-picture" style="padding-bottom: <%style.paddingtop%>px; background: <%style.background%>;">
            <%each data as item%>
                <div style="display: block; padding: <%style.paddingtop%>px <%style.paddingleft%>px 0;">
                   <img src="<%imgsrc item.imgurl%>" />
                </div>
            <%/each%>
        </div>
    </div>
</script>

<script type="text/html" id="tpl_show_picturew">
    <div class="drag" data-itemid="<%itemid%>">
        <%if params.row=='1'%>
            <div class="fui-cube" style="background: <%style.background%>; <%if count(data)==1%>padding: <%style.paddingtop%>px <%style.paddingleft%>px;<%/if%>">
                <%if count(data)==1%>
                    <img src="<%imgsrc(toArray(data)[0].imgurl)%>" />
                <%/if%>
                <%if count(data)>1%>
                    <div class="fui-cube-left" style="padding: <%style.paddingtop%>px <%style.paddingleft%>px; padding-right: 0;">
                        <img src="<%imgsrc(toArray(data)[0].imgurl)%>" />
                    </div>
                    <div class="fui-cube-right" <%if count(data)==2%> style="padding: <%style.paddingtop%>px <%style.paddingleft%>px;"<%/if%>>
                        <%if count(data)==2%>
                            <img src="<%imgsrc(toArray(data)[1].imgurl)%>" />
                        <%/if%>
                        <%if count(data)>2%>
                            <div class="fui-cube-right1" style="padding: <%style.paddingtop%>px <%style.paddingleft%>px; padding-bottom: 0;">
                                <img src="<%imgsrc(toArray(data)[1].imgurl)%>" />
                            </div>
                             <div class="fui-cube-right2" <%if count(data)==3%> style="padding: <%style.paddingtop%>px <%style.paddingleft%>px;"<%/if%>>
                                <%if count(data)==3%>
                                    <img src="<%imgsrc(toArray(data)[2].imgurl)%>" />
                                <%/if%>
                                <%if count(data)>3%>
                                    <div class="left" style="padding: <%style.paddingtop%>px <%style.paddingleft%>px; padding-right: 0;">
                                        <img src="<%imgsrc(toArray(data)[2].imgurl)%>" />
                                    </div>
                                <%/if%>
                                <%if count(data)==4%>
                                    <div class="right" style="padding: <%style.paddingtop%>px <%style.paddingleft%>px;">
                                        <img src="<%imgsrc(toArray(data)[3].imgurl)%>" />
                                    </div>
                                <%/if%>
                            </div>
                        <%/if%>
                     </div>
                <%/if%>
            </div>
        <%/if%>
        <%if params.row>1%>
            <div class="fui-picturew row-<%params.row%>" style="padding: <%style.paddingleft%>px; background: <%style.background%>;">
                <%each data as item%>
                    <div class="item" style="padding: <%style.paddingtop%>px <%style.paddingleft%>px;">
                        <img src="<%imgsrc item.imgurl%>">
                    </div>
                <%/each%>
            </div>
        <%/if%>

    </div>
</script>

<script type="text/html" id="tpl_show_goods">
    <div class="drag" data-itemid="<%itemid%>">

        <div class="fui-goods-group <%style.liststyle%>">
            <%if params.goodsdata=='0'%>
                <%each data as item%>
                    <div class="fui-goods-item" data-goodsid="<%item.gid%>">
                        <div class="image" style="background-image: url('<%imgsrc item.thumb%>');">
                            <%if (params.showicon=='1' || params.showicon=='2')%>
                                <div class="goodsicon <%params.iconposition%>"
                                    <%if params.iconposition=='left top'%> style="top: <%style.iconpaddingtop%>px; left: <%style.iconpaddingleft%>px; text-align: left;"<%/if%>
                                    <%if params.iconposition=='right top'%> style="top: <%style.iconpaddingtop%>px; right: <%style.iconpaddingleft%>px; text-align: right;"<%/if%>
                                    <%if params.iconposition=='left bottom'%> style="bottom: <%style.iconpaddingtop%>px; left: <%style.iconpaddingleft%>px; text-align: left;"<%/if%>
                                    <%if params.iconposition=='right bottom'%> style="bottom: <%style.iconpaddingtop%>px; right: <%style.iconpaddingleft%>px; text-align: right;"<%/if%>
                                >
                                    <%if params.showicon=='1'%>
                                        <img src="<?php  echo RESOURCE_ROOT;?>eshop/static/images/default/goodsicon-<%style.goodsicon%>.png" style="width: <%style.iconzoom||'100'%>%;" />
                                    <%/if%>

                                    <%if params.showicon=='2' && params.goodsiconsrc%>
                                        <img src="<%imgsrc params.goodsiconsrc%>" onerror="this.src=''" style="width: <%style.iconzoom||'100'%>%;" />
                                    <%/if%>

                                </div>
                            <%/if%>
                        </div>
                        <div class="detail">
                            <%if params.showtitle=='1'%>
                                <div class="name" style="color: <%style.titlecolor%>;"><%item.title%></div>
                            <%/if%>
                            <%if params.showprice=='1'%>
                                <div class="price">
                                    <span class="text" style="color: <%style.pricecolor%>;">￥<%item.price%></span>
                                    <%if style.buystyle!=''%>
                                        <%if style.buystyle=='buybtn-1'%>
                                            <span class="buy" style="background-color: <%style.buybtncolor%>;"><i class="fa fa-shopping-cart"></i></span>
                                        <%/if%>
                                        <%if style.buystyle=='buybtn-2'%>
                                            <span class="buy" style="background-color: <%style.buybtncolor%>;"><i class="fa fa-plus"></i></span>
                                        <%/if%>
                                        <%if style.buystyle=='buybtn-3'%>
                                            <span class="buy buybtn-3" style="background-color: <%style.buybtncolor%>;">购买</span>
                                        <%/if%>
                                    <%/if%>
                                </div>
                            <%/if%>
                        </div>
                    </div>
                <%/each%>
            <%/if%>
            <%if params.goodsdata=='1' || params.goodsdata=='2'%>
                <%each data=["c","d"] as item%>
                    <div class="fui-goods-item">
                        <div class="image" style="background-image: url('<?php  echo RESOURCE_ROOT;?>eshop/static/images/default/goods-3.jpg');">
                                <%if (params.showicon=='1' || params.showicon=='2')%>
                                    <div class="goodsicon <%params.iconposition%>"
                                        <%if params.iconposition=='left top'%> style="top: <%style.iconpaddingtop%>px; left: <%style.iconpaddingleft%>px; text-align: left;"<%/if%>
                                        <%if params.iconposition=='right top'%> style="top: <%style.iconpaddingtop%>px; right: <%style.iconpaddingleft%>px; text-align: right;"<%/if%>
                                        <%if params.iconposition=='left bottom'%> style="bottom: <%style.iconpaddingtop%>px; left: <%style.iconpaddingleft%>px; text-align: left;"<%/if%>
                                        <%if params.iconposition=='right bottom'%> style="bottom: <%style.iconpaddingtop%>px; right: <%style.iconpaddingleft%>px; text-align: right;"<%/if%>
                                    >
                                    <%if params.showicon=='1'%>
                                        <img src="<?php  echo RESOURCE_ROOT;?>eshop/static/images/default/goodsicon-<%style.goodsicon%>.png" style="width: <%style.iconzoom||'100'%>%;" />
                                    <%/if%>

                                    <%if params.showicon=='2' && params.goodsiconsrc%>
                                        <img src="<%imgsrc params.goodsiconsrc%>" onerror="this.src=''" style="width: <%style.iconzoom||'100'%>%;" />
                                    <%/if%>
                                </div>
                            <%/if%>
                        </div>
                        <div class="detail">
                            <%if params.showtitle=='1'%>
                                <div class="name">这里是商品标题(商品从设定<%if params.goodsdata=='1'%>分类<%else%>分组<%/if%>读取)</div>
                            <%/if%>
                            <%if params.showprice=='1'%>
                                <div class="price">
                                    <span class="text" style="color: <%style.pricecolor%>;">￥20.00</span>
                                    <%if style.buystyle!=''%>
                                        <%if style.buystyle=='buybtn-1'%>
                                            <span class="buy" style="background-color: <%style.buybtncolor%>;"><i class="fa fa-shopping-cart"></i></span>
                                        <%/if%>
                                        <%if style.buystyle=='buybtn-2'%>
                                            <span class="buy" style="background-color: <%style.buybtncolor%>;"><i class="fa fa-plus"></i></span>
                                        <%/if%>
                                        <%if style.buystyle=='buybtn-3'%>
                                            <span class="buy buybtn-3" style="background-color: <%style.buybtncolor%>;">购买</span>
                                        <%/if%>
                                    <%/if%>
                                </div>
                            <%/if%>
                        </div>
                    </div>
                <%/each%>
            <%/if%>
        </div>

    </div>
</script>

<script type="text/html" id="tpl_show_diymod">

</script>

<script type="text/html" id="tpl_navs">
    <nav class="btn btn-link" data-id="page"><i class="fa fa-cog"></i> 页面设置</nav>
    <%each initnav as nav %>
        <nav class="btn btn-link" data-id="<%nav.id%>"><i class="fa fa-plus"></i> <%nav.name%></nav>
    <%/each%>
</script>

<script type="text/html" id="edit-del">
    <div class="btn-edit">编辑</div>
    <div class="btn-del">删除</div>
</script>


<script type="text/html" id="tpl_edit_page_mod">
    <div class="form-group">
        <div class="col-sm-2 control-label">模块名称</div>
        <div class="col-sm-10">
            <input class="form-control input-sm diy-bind" data-bind="name" data-placeholder="请输入名称" placeholder="请输入名称" value="<%name%>" />
        </div>
    </div>
</script>

<script type="text/html" id="tpl_edit_page">

    <div class="form-group">
        <div class="col-sm-2 control-label">页面名称</div>
        <div class="col-sm-10">
            <input class="form-control input-sm diy-bind" data-bind="name" data-placeholder="请输入名称" placeholder="请输入名称" value="<%page.name%>" />
            <div class="help-block">注意：页面名称是便于后台查找，页面标题是手机端标题。</div>
        </div>
    </div>
  <div class="form-group">
        <div class="col-sm-2 control-label">页面类型</div>
        <div class="col-sm-10">
          普通页面<input type="radio" value="0" class="diy-bind"  name="pagetype" data-bind="pagetype" data-bind-init="true" <%if (page.pagetype!=1)||page.pagetype==0%>checked="checked"<%/if%>>，商城首页<input type="radio" value="1" class="diy-bind"  name="pagetype" data-bind="pagetype" data-bind-init="true" <%if page.pagetype==1%>checked="checked"<%/if%>>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 control-label">页面标题</div>
        <div class="col-sm-10">
            <input class="form-control input-sm diy-bind" data-bind="title" data-placeholder="请输入标题" placeholder="请输入标题" value="<%page.title%>" />
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-2 control-label">背景颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind="background" value="<%page.background%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#fafafa').trigger('propertychange')">重置</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">底部菜单</div>
        <div class="col-sm-10">
            <select class="form-control input-sm diy-bind" data-bind="diymenu">
                <option value="-1"<%if page.diymenu=='-1'%>selected="selected"<%/if%>>不显示</option>
                <option value="0" <%if page.diymenu=='0'%>selected="selected"<%/if%>>系统默认</option>
                <%each diymenu as menu%>
                    <option value="<%menu.id%>" <%if page.diymenu==menu.id%>selected="selected"<%/if%>><%menu.name%></option>
                <%/each%>
            </select>
        </div>
    </div>


</script>

<script type="text/html" id="tpl_edit_banner">

    <div class="form-group">
        <div class="col-sm-2 control-label">按钮形状</div>
        <div class="col-sm-10">
            <label class="radio-inline"><input type="radio" name="dotstyle" value="rectangle" class="diy-bind" data-bind-child="style" data-bind="dotstyle" <%if style.dotstyle=='rectangle'%>checked="checked"<%/if%> > 长方形</label>
            <label class="radio-inline"><input type="radio" name="dotstyle" value="square" class="diy-bind" data-bind-child="style" data-bind="dotstyle" <%if style.dotstyle=='square'%>checked="checked"<%/if%>> 正方形</label>
            <label class="radio-inline"><input type="radio" name="dotstyle" value="round" class="diy-bind" data-bind-child="style" data-bind="dotstyle" <%if style.dotstyle=='round'%>checked="checked"<%/if%>> 圆形</label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">按钮位置</div>
        <div class="col-sm-10">
            <label class="radio-inline"><input type="radio" name="dotalign" value="left" class="diy-bind" data-bind-child="style" data-bind="dotalign" <%if style.dotalign=='left'%>checked="checked"<%/if%> > 居左</label>
            <label class="radio-inline"><input type="radio" name="dotalign" value="center" class="diy-bind" data-bind-child="style" data-bind="dotalign" <%if style.dotalign=='center'%>checked="checked"<%/if%>> 居中</label>
            <label class="radio-inline"><input type="radio" name="dotalign" value="right" class="diy-bind" data-bind-child="style" data-bind="dotalign" <%if style.dotalign=='right'%>checked="checked"<%/if%>> 居右</label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">按钮颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="background" value="<%style.background%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">清除</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">左右边距</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.leftright%>" data-min="5" data-max="50"></div>
                <div class="col-sm-4 control-labe count"><span><%style.leftright%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="leftright" value="<%style.leftright%>" type="hidden" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">底部边距</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.bottom%>" data-min="5" data-max="30"></div>
                <div class="col-sm-4 control-labe count"><span><%style.bottom%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="bottom" value="<%style.bottom%>" type="hidden" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">透明度</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8 " data-value="<%style.opacity%>" data-min="0" data-max="10" data-decimal="10"></div>
                <div class="col-sm-4 control-labe count"><span><%style.opacity%></span>(最大是1)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="opacity" value="<%style.opacity%>" type="hidden" />
            </div>
        </div>
    </div>

    <div class="form-items" data-min="1">
        <div class="inner" id="form-items">
            <%each data as child itemid %>
            <div class="item" data-id="<%itemid%>">
                <span class="btn-del" title="删除"></span>
                <div class="item-image">
                    <img src="<%imgsrc child.imgurl%>" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/static/images/nopic.jpg';" id="pimg-<%itemid%>" />
                </div>
                <div class="item-form">
                    <div class="input-group" style="margin-bottom:0px; ">
                        <input type="text" class="form-control input-sm diy-bind" data-bind-parent="data" data-bind-child="<%itemid%>" data-bind="imgurl"  id="cimg-<%itemid%>" placeholder="请选择图片或输入图片地址" value="<%child.imgurl%>" />
                        <span class="input-group-addon btn btn-default" data-toggle="selectImg" data-input="#cimg-<%itemid%>" data-img="#pimg-<%itemid%>">选择图片</span>
                    </div>
                    <div class="input-group" style="margin-top:10px; margin-bottom:0px; ">
                     <span class="input-group-addon">链接</span> 
                        <input type="text" class="form-control input-sm diy-bind" data-bind-parent="data" data-bind-child="<%itemid%>" data-bind="linkurl" id="curl-<%itemid%>" placeholder="请选择链接或输入链接地址" value="<%child.linkurl%>" />

                    </div>
                </div>
            </div>
            <%/each%>
        </div>
        <div class="btn btn-w-m btn-block btn-default btn-outline" id="addChild"><i class="fa fa-plus"></i> 添加一个</div>
    </div>

</script>

<script type="text/html" id="tpl_edit_richtext">
    <div class="form-group">
        <div class="col-sm-2 control-label">背景颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="background" value="<%style.background%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">清除</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">边距设置</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.padding%>" data-min="0" data-max="50"></div>
                <div class="col-sm-4 control-labe count"><span><%style.padding%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="padding" value="<%style.padding%>" type="hidden" />
            </div>
        </div>
    </div>

    <div class="form-richtext">
        <div id="rich"></div>
        <textarea id="richtext" class="diy-bind" data-bind-child="params" data-bind="content" style="display: none"></textarea>
    </div>

</script>

<script type="text/html" id="tpl_edit_notice">

    <div class="form-group">
        <div class="col-sm-2 control-label">背景颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="background" value="<%style.background%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">清除</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">小图标颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="iconcolor" value="<%style.iconcolor%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#fd5454').trigger('propertychange')">重置</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">公告颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="color" value="<%style.color%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#666666').trigger('propertychange')">重置</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">公告图标</div>
        <div class="col-sm-10">
            <div class="input-group">
                <input class="form-control input-sm diy-bind" data-bind-child="params" data-bind="iconurl" value="<%params.iconurl%>" id="iconsrc" />
                <span data-input="#iconsrc" data-img="#iconimg" data-toggle="selectImg" class="input-group-addon btn btn-default">选择图片</span>
            </div>
            <div class="input-group " style="margin-top:.5em;">
                <img src="<%imgsrc params.iconurl%>" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/static/images/nopic.jpg';" class="img-responsive img-thumbnail" width="150" id="iconimg">
                <span class="close" style="position:absolute; top: -10px; right: -14px;" title="重置默认图片" onclick="$('#iconsrc').val('<?php  echo RESOURCE_ROOT;?>eshop/static/images/default/hotdot.jpg').trigger('change');$(this).prev().attr('src', '<?php  echo RESOURCE_ROOT;?>eshop/static/images/default/hotdot.jpg')">×</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">滚动速度</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%params.speed%>" data-min="1" data-max="10"></div>
                <div class="col-sm-4 control-labe count"><span><%params.speed%></span>秒</div>
                <input class="diy-bind input" data-bind-child="params" data-bind="speed" value="<%params.speed%>" type="hidden" />
            </div>
        </div>
    </div>
<input type="hidden"  data-bind-child="params" data-bind="noticedata" data-bind-init="true" name="noticedata" value="1">

    <%if params.noticedata=='1'%>
        <div class="form-items indent" data-min="1">
            <div class="inner" id="form-items">
                <%each data as child itemid %>
                <div class="item" data-id="<%itemid%>">
                    <span class="btn-del" title="删除"></span>
                    <div class="item-image drag-btn square">拖动排序</div>
                    <div class="item-form">
                        <div class="input-group" style="margin-bottom:0px; ">
                            <span class="input-group-addon">标题</span>
                            <input type="text" class="form-control input-sm diy-bind" data-bind-parent="data" data-bind-child="<%itemid%>" data-bind="title" placeholder="请输入公告标题" value="<%child.title%>" />
                        </div>
                        <div class="input-group" style="margin-top:10px; margin-bottom:0px; ">
                           <span class="input-group-addon">链接</span> 
                            <input type="text" class="form-control input-sm diy-bind" data-bind-parent="data" data-bind-child="<%itemid%>" data-bind="linkurl" id="curl-<%itemid%>" placeholder="请选择链接或输入链接地址(http://开头)" value="<%child.linkurl%>" />
                   
                        </div>
                    </div>
                </div>
                <%/each%>
            </div>
            <div class="btn btn-w-m btn-block btn-default btn-outline" id="addChild"><i class="fa fa-plus"></i> 添加一个</div>
        </div>
    <%/if%>

    <%if params.noticedata=='0'%>
        <div class="form-group">
            <div class="col-sm-2 control-label">读取数量</div>
            <div class="col-sm-10">
                <label class="radio-inline"><input type="radio" name="noticenum" value="5" class="diy-bind" data-bind-child="params" data-bind="noticenum" <%if params.noticenum=='5'%>checked="checked"<%/if%> > 5条</label>
                <label class="radio-inline"><input type="radio" name="noticenum" value="10" class="diy-bind" data-bind-child="params" data-bind="noticenum" <%if params.noticenum=='10'%>checked="checked"<%/if%>> 10条</label>
                <label class="radio-inline"><input type="radio" name="noticenum" value="20" class="diy-bind" data-bind-child="params" data-bind="noticenum" <%if params.noticenum=='20'%>checked="checked"<%/if%>> 20条</label>
            </div>
        </div>
    <%/if%>

</script>


<script type="text/html" id="tpl_edit_title">
    <div class="form-group">
        <div class="col-sm-2 control-label">背景颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="background" value="<%style.background%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">清除</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 control-label">文字颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="color" value="<%style.color%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">清除</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 control-label">标题文字</div>
        <div class="col-sm-10">
            <div class="input-group form-group" style="margin: 0;">
                <input class="form-control input-sm diy-bind" data-bind-child="params" data-bind="title" data-placeholder="" placeholder="请输入标题" value="<%params.title%>" />
                 <input class="diy-bind" type="hidden" data-bind-child="params" data-bind="icon" value="<%params.icon%>" id="titleicon" />

                <span data-input="#titleicon" data-toggle="selectIcon" class="input-group-addon btn btn-default">选择图标</span>

                <span class="input-group-addon btn btn-default" onclick="$(this).prev().prev().val('').trigger('change');">清除</span>

            
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 control-label">标题链接</div>
        <div class="col-sm-10">
            <div class="form-group" style="margin: 0;">
                <input class="form-control input-sm diy-bind" data-bind-child="params" data-bind="link" data-placeholder="" placeholder="" value="<%params.link%>" id="titlelink"/>
           
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 control-label">对齐方向</div>
        <div class="col-sm-10">
            <label class="radio-inline"><input type="radio" name="textalign" value="left" class="diy-bind" data-bind-child="style" data-bind="textalign" <%if style.textalign=='left'%>checked="checked"<%/if%> > 居左</label>
            <label class="radio-inline"><input type="radio" name="textalign" value="center" class="diy-bind" data-bind-child="style" data-bind="textalign" <%if style.textalign=='center'%>checked="checked"<%/if%>> 居中</label>
            <label class="radio-inline"><input type="radio" name="textalign" value="right" class="diy-bind" data-bind-child="style" data-bind="textalign" <%if style.textalign=='right'%>checked="checked"<%/if%>> 居右</label>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 control-label">文字大小</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.fontsize%>" data-min="9" data-max="30"></div>
                <div class="col-sm-4 control-labe count"><span><%style.fontsize%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="fontsize" value="<%style.fontsize%>" type="hidden" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 control-label">上下边距</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.paddingtop%>" data-min="1" data-max="30"></div>
                <div class="col-sm-4 control-labe count"><span><%style.paddingtop%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="paddingtop" value="<%style.paddingtop%>" type="hidden" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 control-label">左右边距</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.paddingleft%>" data-min="1" data-max="30"></div>
                <div class="col-sm-4 control-labe count"><span><%style.paddingleft%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="paddingleft" value="<%style.paddingleft%>" type="hidden" />
            </div>
        </div>
    </div>
</script>


<script type="text/html" id="tpl_edit_search">

    <div class="form-group">
        <div class="col-sm-2 control-label">背景颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="background" value="<%style.background%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#f1f1f2').trigger('propertychange')">重置</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">输入框背景</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="inputbackground" value="<%style.inputbackground%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">重置</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">文字颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="color" value="<%style.color%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#999999').trigger('propertychange')">重置</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">图标颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="iconcolor" value="<%style.iconcolor%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#b4b4b4').trigger('propertychange')">重置</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">提示文字</div>
        <div class="col-sm-10">
            <input class="form-control input-sm diy-bind" data-bind-child="params" data-bind="placeholder" data-placeholder="" placeholder="请输入提示文字(不填则不显示，最长20字)" value="<%params.placeholder%>" maxlength="20" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">上下边距</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.paddingtop%>" data-min="2" data-max="30"></div>
                <div class="col-sm-4 control-labe count"><span><%style.paddingtop%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="paddingtop" value="<%style.paddingtop%>" type="hidden" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">左右边距</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.paddingleft%>" data-min="2" data-max="30"></div>
                <div class="col-sm-4 control-labe count"><span><%style.paddingleft%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="paddingleft" value="<%style.paddingleft%>" type="hidden" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">搜索框样式</div>
        <div class="col-sm-10">
            <label class="radio-inline"><input type="radio" name="searchstyle" value="" class="diy-bind" data-bind-child="style" data-bind="searchstyle" <%if style.searchstyle==''%>checked="checked"<%/if%> > 方形</label>
            <label class="radio-inline"><input type="radio" name="searchstyle" value="radius" class="diy-bind" data-bind-child="style" data-bind="searchstyle" <%if style.searchstyle=='radius'%>checked="checked"<%/if%>> 圆角</label>
            <label class="radio-inline"><input type="radio" name="searchstyle" value="round" class="diy-bind" data-bind-child="style" data-bind="searchstyle" <%if style.searchstyle=='round'%>checked="checked"<%/if%>> 圆弧</label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">文字对齐</div>
        <div class="col-sm-10">
            <label class="radio-inline"><input type="radio" name="textalign" value="left" class="diy-bind" data-bind-child="style" data-bind="textalign" <%if style.textalign=='left'%>checked="checked"<%/if%> > 居左</label>
            <label class="radio-inline"><input type="radio" name="textalign" value="center" class="diy-bind" data-bind-child="style" data-bind="textalign" <%if style.textalign=='center'%>checked="checked"<%/if%>> 居中</label>
            <label class="radio-inline"><input type="radio" name="textalign" value="right" class="diy-bind" data-bind-child="style" data-bind="textalign" <%if style.textalign=='right'%>checked="checked"<%/if%>> 居右</label>
        </div>
    </div>

</script>
<script type="text/html" id="tpl_edit_line">
    <div class="form-group">
        <div class="col-sm-2 control-label">背景颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="background" value="<%style.background%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">清除</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 control-label">线条颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="bordercolor" value="<%style.bordercolor%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">清除</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 control-label">线条样式</div>
        <div class="col-sm-10">
            <label class="radio-inline"><input type="radio" name="linestyle" value="solid" class="diy-bind" data-bind-child="style" data-bind="linestyle" <%if style.linestyle=='solid'%>checked="checked"<%/if%> > 实线</label>
            <label class="radio-inline"><input type="radio" name="linestyle" value="dashed" class="diy-bind" data-bind-child="style" data-bind="linestyle" <%if style.linestyle=='dashed'%>checked="checked"<%/if%>> 虚线(长方形)</label>
            <label class="radio-inline"><input type="radio" name="linestyle" value="dotted" class="diy-bind" data-bind-child="style" data-bind="linestyle" <%if style.linestyle=='dotted'%>checked="checked"<%/if%>> 虚线(正方形)</label>
            <label class="radio-inline"><input type="radio" name="linestyle" value="double" class="diy-bind" data-bind-child="style" data-bind="linestyle" <%if style.linestyle=='double'%>checked="checked"<%/if%>> 双实线</label>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 control-label">线条高度</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.height%>" data-min="1" data-max="20"></div>
                <div class="col-sm-4 control-labe count"><span><%style.height%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="height" value="<%style.height%>" type="hidden" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 control-label">上下边距</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.padding%>" data-min="1" data-max="30"></div>
                <div class="col-sm-4 control-labe count"><span><%style.height%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="padding" value="<%style.padding%>" type="hidden" />
            </div>
        </div>
    </div>
</script>

<script type="text/html" id="tpl_edit_blank">
    <div class="form-group">
        <div class="col-sm-2 control-label">背景颜色</div>
        <div class="col-sm-4">
            <div class="input-group input-group-sm">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="background" value="<%style.background%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">清除</span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2 control-label">元素高度</div>
            <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.height%>" data-min="1" data-max="200"></div>
                <div class="col-sm-4 control-labe count"><span><%style.height%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="height" value="<%style.height%>" type="hidden" />
            </div>
        </div>
    </div>
</script>

<script type="text/html" id="tpl_edit_menu">

    <div class="form-group">
        <div class="col-sm-2 control-label">背景颜色</div>
        <div class="col-sm-4">
            <div class="input-group">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="background" value="<%style.background%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">清除</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">按钮形状</div>
        <div class="col-sm-10">
            <label class="radio-inline"><input type="radio" name="navstyle" value="" class="diy-bind" data-bind-child="style" data-bind="navstyle" <%if style.navstyle==''%>checked="checked"<%/if%>> 正方形</label>
            <label class="radio-inline"><input type="radio" name="navstyle" value="radius" class="diy-bind" data-bind-child="style" data-bind="navstyle" <%if style.navstyle=='radius'%>checked="checked"<%/if%>> 圆角</label>
            <label class="radio-inline"><input type="radio" name="navstyle" value="circle" class="diy-bind" data-bind-child="style" data-bind="navstyle" <%if style.navstyle=='circle'%>checked="checked"<%/if%>> 圆形</label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">每行数量</div>
        <div class="col-sm-10">
            <label class="radio-inline"><input type="radio" name="rownum" value="4" class="diy-bind" data-bind-child="style" data-bind="rownum" <%if style.rownum=='4'%>checked="checked"<%/if%>> 4个</label>
            <label class="radio-inline"><input type="radio" name="rownum" value="5" class="diy-bind" data-bind-child="style" data-bind="rownum" <%if style.rownum=='5'%>checked="checked"<%/if%>> 5个</label>
        </div>
    </div>

    <div class="form-items" data-min="1">
        <div class="inner" id="form-items">
            <%each data as child itemid %>
            <div class="item" data-id="<%itemid%>">
                <span class="btn-del" title="删除"></span>
                <div class="item-image square">
                    <div class="text" data-toggle="selectImg" data-input="#cimg-<%itemid%>" data-img="#pimg-<%itemid%>">选择图片</div>
                    <img src="<%imgsrc child.imgurl%>" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/static/images/nopic.jpg';" id="pimg-<%itemid%>" />
                    <input type="hidden" class="diy-bind" data-bind-parent="data" data-bind-child="<%itemid%>" data-bind="imgurl"  id="cimg-<%itemid%>" value="<%child.imgurl%>" />
                </div>
                <div class="item-form">
                    <div class="input-group" style="margin-bottom:0px; ">
                        <span class="input-group-addon">文字</span>
                        <input type="text" class="form-control input-sm diy-bind" data-bind-parent="data" data-bind-child="<%itemid%>" data-bind="text" placeholder="请选择图片或输入图片地址" value="<%child.text%>" style="width: 60%" />
                        <input class="form-control input-sm diy-bind color " data-bind-parent="data" data-bind-child="<%itemid%>" data-bind="color" value="<%child.color%>" type="color" style="width: 40%" />
                        <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#666666').trigger('propertychange')">重置颜色</span>
                    </div>
                    <div class="input-group" style="margin-top:10px; margin-bottom:0px; ">
                      <span class="input-group-addon">链接</span> 
                        <input type="text" class="form-control input-sm diy-bind" data-bind-parent="data" data-bind-child="<%itemid%>" data-bind="linkurl" id="curl-<%itemid%>" placeholder="请选择链接或输入链接地址" value="<%child.linkurl%>" />

                    </div>
                </div>
            </div>
            <%/each%>
        </div>
        <div class="btn btn-w-m btn-block btn-default btn-outline" id="addChild"><i class="fa fa-plus"></i> 添加一个</div>
    </div>

</script>


<script type="text/html" id="tpl_edit_picture">

    <div class="form-group">
        <div class="col-sm-2 control-label">上下边距</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.paddingtop%>" data-min="0" data-max="50"></div>
                <div class="col-sm-4 control-labe count"><span><%style.paddingtop%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="paddingtop" value="<%style.paddingtop%>" type="hidden" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">左右边距</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.paddingleft%>" data-min="0" data-max="50"></div>
                <div class="col-sm-4 control-labe count"><span><%style.paddingleft%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="paddingleft" value="<%style.paddingleft%>" type="hidden" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">背景颜色</div>
        <div class="col-sm-4">
            <div class="input-group">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="background" value="<%style.background%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">清除</span>
            </div>
        </div>
    </div>

    <div class="form-items indent" data-min="1">
        <div class="inner" id="form-items">
            <%each data as child itemid %>
                <div class="item" data-id="<%itemid%>">
                    <span class="btn-del" title="删除"></span>
                    <div class="item-image">
                        <img src="<%imgsrc child.imgurl%>" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/static/images/nopic.jpg';" id="pimg-<%itemid%>" />
                    </div>
                    <div class="item-form">
                        <div class="input-group" style="margin-bottom:0px; ">
                            <input type="text" class="form-control input-sm diy-bind" data-bind-parent="data" data-bind-child="<%itemid%>" data-bind="imgurl"  id="cimg-<%itemid%>" placeholder="请选择图片或输入图片地址" value="<%child.imgurl%>" />
                            <span class="input-group-addon btn btn-default" data-toggle="selectImg" data-input="#cimg-<%itemid%>" data-img="#pimg-<%itemid%>">选择图片</span>
                        </div>
                        <div class="input-group" style="margin-top:10px; margin-bottom:0px; ">
                          <span class="input-group-addon">链接</span> 
                            <input type="text" class="form-control input-sm diy-bind" data-bind-parent="data" data-bind-child="<%itemid%>" data-bind="linkurl" id="curl-<%itemid%>" placeholder="请选择链接或输入链接地址" value="<%child.linkurl%>" />

                        </div>
                    </div>
                </div>
            <%/each%>
        </div>
        <div class="btn btn-w-m btn-block btn-default btn-outline" id="addChild"><i class="fa fa-plus"></i> 添加一个</div>
    </div>

</script>


<script type="text/html" id="tpl_edit_picturew">

    <div class="form-group">
        <div class="col-sm-2 control-label">上下边距</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.paddingtop%>" data-min="0" data-max="50"></div>
                <div class="col-sm-4 control-labe count"><span><%style.paddingtop%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="paddingtop" value="<%style.paddingtop%>" type="hidden" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">左右边距</div>
        <div class="col-sm-10">
            <div class="form-group">
                <div class="slider col-sm-8" data-value="<%style.paddingleft%>" data-min="0" data-max="50"></div>
                <div class="col-sm-4 control-labe count"><span><%style.paddingleft%></span>px(像素)</div>
                <input class="diy-bind input" data-bind-child="style" data-bind="paddingleft" value="<%style.paddingleft%>" type="hidden" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">背景颜色</div>
        <div class="col-sm-4">
            <div class="input-group">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="background" value="<%style.background%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ffffff').trigger('propertychange')">清除</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">布局方式</div>
        <div class="col-sm-10">
            <label class="radio-inline"><input type="radio" name="row" value="1" class="diy-bind" data-bind-child="params" data-bind="row" data-bind-init="true" <%if params.row=='1'%>checked="checked"<%/if%>> 橱窗样式</label>
            <label class="radio-inline"><input type="radio" name="row" value="2" class="diy-bind" data-bind-child="params" data-bind="row" data-bind-init="true" <%if params.row=='2'%>checked="checked"<%/if%>> 堆积两列</label>
            <label class="radio-inline"><input type="radio" name="row" value="3" class="diy-bind" data-bind-child="params" data-bind="row" data-bind-init="true" <%if params.row=='3'%>checked="checked"<%/if%> > 堆积三列</label>
            <label class="radio-inline"><input type="radio" name="row" value="4" class="diy-bind" data-bind-child="params" data-bind="row" data-bind-init="true" <%if params.row=='4'%>checked="checked"<%/if%> > 堆积四列</label>

            <%if params.row==1%>
               <div class="help-block">图片数量4个。</div>
            <%/if%>
            <%if params.row>1%>
            <div class="help-block">图片数量99，但请确保所有图片的尺寸/比例相同。</div>
            <%/if%>
        </div>
    </div>

    <div class="form-items indent" data-min="2" <%if params.row==1%>data-max="4"<%/if%> <%if params.row>1%>data-max="99"<%/if%> >
        <div class="inner" id="form-items">
            <%each data as child itemid %>
            <div class="item" data-id="<%itemid%>">
                <span class="btn-del" title="删除"></span>
                <div class="item-image">
                    <img src="<%imgsrc child.imgurl%>" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/static/images/nopic.jpg';" id="pimg-<%itemid%>" />
                </div>
                <div class="item-form">
                    <div class="input-group" style="margin-bottom:0px; ">
                        <input type="text" class="form-control input-sm diy-bind" data-bind-parent="data" data-bind-child="<%itemid%>" data-bind="imgurl"  id="cimg-<%itemid%>" placeholder="请选择图片或输入图片地址" value="<%child.imgurl%>" />
                        <span class="input-group-addon btn btn-default" data-toggle="selectImg" data-input="#cimg-<%itemid%>" data-img="#pimg-<%itemid%>">选择图片</span>
                    </div>
                    <div class="input-group" style="margin-top:10px; margin-bottom:0px; ">
                      <span class="input-group-addon">链接</span> 
                        <input type="text" class="form-control input-sm diy-bind" data-bind-parent="data" data-bind-child="<%itemid%>" data-bind="linkurl" id="curl-<%itemid%>" placeholder="请选择链接或输入链接地址" value="<%child.linkurl%>" />

                    </div>
                </div>
            </div>
            <%/each%>
        </div>
        <div class="btn btn-w-m btn-block btn-default btn-outline" id="addChild"><i class="fa fa-plus"></i> 添加一个</div>
    </div>

</script>

<script type="text/html" id="tpl_edit_goods">

    <div class="form-group">
        <div class="col-sm-2 control-label">列表样式</div>
        <div class="col-sm-10">
            <label class="radio-inline"><input type="radio" name="liststyle" value="block one" class="diy-bind" data-bind-child="style" data-bind="liststyle" <%if style.liststyle=='block one'%>checked="checked"<%/if%> > 单列显示</label>
            <label class="radio-inline"><input type="radio" name="liststyle" value="block" class="diy-bind" data-bind-child="style" data-bind="liststyle" <%if style.liststyle=='block'%>checked="checked"<%/if%>> 双列显示</label>
            <label class="radio-inline"><input type="radio" name="liststyle" value="" class="diy-bind" data-bind-child="style" data-bind="liststyle" <%if style.liststyle==''%>checked="checked"<%/if%>> 列表显示</label>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-2 control-label">商品名称</div>
        <div class="col-sm-10">
            <label class="radio-inline"><input type="radio" name="showtitle" value="0" class="diy-bind" data-bind-child="params" data-bind="showtitle" <%if params.showtitle=='0'%>checked="checked"<%/if%>> 不显示</label>
            <label class="radio-inline"><input type="radio" name="showtitle" value="1" class="diy-bind" data-bind-child="params" data-bind="showtitle" <%if params.showtitle=='1'%>checked="checked"<%/if%> > 显示</label>
        </div>
    </div>

    <%if params.showtitle=='1'%>
    <div class="form-group">
        <div class="col-sm-2 control-label">名称颜色</div>
        <div class="col-sm-4">
            <div class="input-group">
                <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="titlecolor" value="<%style.titlecolor%>" type="color" />
                <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#262626').trigger('propertychange')">重置</span>
            </div>
        </div>
    </div>
    <%/if%>

    <div class="form-group">
        <div class="col-sm-2 control-label">商品价格</div>
        <div class="col-sm-10">
            <label class="radio-inline"><input type="radio" name="showprice" value="0" class="diy-bind" data-bind-child="params" data-bind="showprice" data-bind-init="true" <%if params.showprice=='0'%>checked="checked"<%/if%>> 不显示</label>
            <label class="radio-inline"><input type="radio" name="showprice" value="1" class="diy-bind" data-bind-child="params" data-bind="showprice" data-bind-init="true" <%if params.showprice=='1'%>checked="checked"<%/if%> > 显示</label>
        </div>
    </div>

    <%if params.showprice=='1'%>
        <div class="form-group">
            <div class="col-sm-2 control-label">价格颜色</div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="pricecolor" value="<%style.pricecolor%>" type="color" />
                    <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#ed2822').trigger('propertychange')">重置</span>
                </div>
            </div>
        </div>
    <%/if%>

    <div class="line"></div>

    <%if params.showprice=='1'%>
        <div class="form-group">
            <div class="col-sm-2 control-label">购买按钮</div>
            <div class="col-sm-10">
                <label class="radio-inline"><input type="radio" name="buystyle" value="" class="diy-bind" data-bind-child="style" data-bind="buystyle" data-bind-init="true" <%if style.buystyle==''%>checked="checked"<%/if%> > 不显示</label>
                <label class="radio-inline"><input type="radio" name="buystyle" value="buybtn-1" class="diy-bind" data-bind-child="style" data-bind="buystyle" data-bind-init="true" <%if style.buystyle=='buybtn-1'%>checked="checked"<%/if%>> 样式一</label>
                <label class="radio-inline"><input type="radio" name="buystyle" value="buybtn-2" class="diy-bind" data-bind-child="style" data-bind="buystyle" data-bind-init="true" <%if style.buystyle=='buybtn-2'%>checked="checked"<%/if%>> 样式二</label>
                <label class="radio-inline"><input type="radio" name="buystyle" value="buybtn-3" class="diy-bind" data-bind-child="style" data-bind="buystyle" data-bind-init="true" <%if style.buystyle=='buybtn-3'%>checked="checked"<%/if%>> 样式三</label>
            </div>
        </div>
    <%/if%>

    <%if params.showprice=='1' && style.buystyle!=''%>
        <div class="form-group">
            <div class="col-sm-2 control-label">按钮颜色</div>
            <div class="col-sm-4">
                <div class="input-group">
                    <input class="form-control input-sm diy-bind color" data-bind-child="style" data-bind="buybtncolor" value="<%style.buybtncolor%>" type="color" />
                    <span class="input-group-addon btn btn-default" onclick="$(this).prev().val('#fe5455').trigger('propertychange')">重置</span>
                </div>
            </div>
        </div>
    <%/if%>

    <div class="line"></div>

    <div class="form-group">
        <div class="col-sm-2 control-label">商品图标</div>
        <div class="col-sm-10">
            <label class="radio-inline"><input type="radio" name="showicon" value="0" class="diy-bind" data-bind-child="params" data-bind="showicon" data-bind-init="true" <%if params.showicon=='0'%>checked="checked"<%/if%>> 不显示</label>
            <label class="radio-inline"><input type="radio" name="showicon" value="1" class="diy-bind" data-bind-child="params" data-bind="showicon" data-bind-init="true" <%if params.showicon=='1'%>checked="checked"<%/if%> > 系统图标</label>
            <label class="radio-inline"><input type="radio" name="showicon" value="2" class="diy-bind" data-bind-child="params" data-bind="showicon" data-bind-init="true" <%if params.showicon=='2'%>checked="checked"<%/if%> > 自定义</label>
        </div>
    </div>

    <%if params.showicon=='2'%>
        <div class="form-group">
            <div class="col-sm-2 control-label">自定义图标</div>
            <div class="col-sm-10">
                <div class="input-group">
                    <input class="form-control input-sm diy-bind" data-bind-child="params" data-bind="goodsiconsrc" placeholder="请输入图片地址或选择图片" value="<%params.goodsiconsrc%>" id="goodsiconsrc" />
                    <span data-input="#goodsiconsrc" data-img="#goodsicon" data-toggle="selectImg" class="input-group-addon btn btn-default">选择图片</span>
                </div>
                <div class="input-group " style="margin-top:.5em;">
                    <img src="<%imgsrc params.goodsiconsrc%>" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/static/images/nopic.jpg';" class="img-responsive img-thumbnail" id="goodsicon" style="width: 60px; height: 60px;">
                    <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="$('#goodsiconsrc').val('').trigger('change');$(this).prev().attr('src', '')">×</em>
                </div>
            </div>
        </div>
    <%/if%>

    <%if params.showicon=='1'%>
        <div class="form-group">
            <div class="col-sm-2 control-label">系统图标</div>
            <div class="col-sm-10">
                <label class="radio-inline"><input type="radio" name="goodsicon" value="recommand" class="diy-bind" data-bind-child="style" data-bind="goodsicon" <%if style.goodsicon=='recommand'%>checked="checked"<%/if%>> 推荐</label>
                <label class="radio-inline"><input type="radio" name="goodsicon" value="hotsale" class="diy-bind" data-bind-child="style" data-bind="goodsicon" <%if style.goodsicon=='hotsale'%>checked="checked"<%/if%>> 热销</label>
                <label class="radio-inline"><input type="radio" name="goodsicon" value="isnew" class="diy-bind" data-bind-child="style" data-bind="goodsicon" <%if style.goodsicon=='isnew'%>checked="checked"<%/if%>> 新上</label>
                <label class="radio-inline"><input type="radio" name="goodsicon" value="sendfree" class="diy-bind" data-bind-child="style" data-bind="goodsicon" <%if style.goodsicon=='sendfree'%>checked="checked"<%/if%>> 包邮</label>
                <label class="radio-inline"><input type="radio" name="goodsicon" value="istime" class="diy-bind" data-bind-child="style" data-bind="goodsicon" <%if style.goodsicon=='istime'%>checked="checked"<%/if%>> 限时卖</label>
                <label class="radio-inline"><input type="radio" name="goodsicon" value="bigsale" class="diy-bind" data-bind-child="style" data-bind="goodsicon" <%if style.goodsicon=='bigsale'%>checked="checked"<%/if%>> 促销</label>
            </div>
        </div>
    <%/if%>

    <%if params.showicon=='1' || params.showicon=='2'%>
        <div class="form-group">
            <div class="col-sm-2 control-label">图标位置</div>
            <div class="col-sm-10">
                <label class="radio-inline"><input type="radio" name="iconposition" value="left top" class="diy-bind" data-bind-child="params" data-bind="iconposition" data-bind-init="true" <%if params.iconposition=='left top'%>checked="checked"<%/if%>> 左上</label>
                <label class="radio-inline"><input type="radio" name="iconposition" value="right top" class="diy-bind" data-bind-child="params" data-bind="iconposition" data-bind-init="true" <%if params.iconposition=='right top'%>checked="checked"<%/if%> > 右上</label>
                <label class="radio-inline"><input type="radio" name="iconposition" value="left bottom" class="diy-bind" data-bind-child="params" data-bind="iconposition" data-bind-init="true" <%if params.iconposition=='left bottom'%>checked="checked"<%/if%> > 左下</label>
                <label class="radio-inline"><input type="radio" name="iconposition" value="right bottom" class="diy-bind" data-bind-child="params" data-bind="iconposition" data-bind-init="true" <%if params.iconposition=='right bottom'%>checked="checked"<%/if%> > 右下</label>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2 control-label">上下偏移</div>
            <div class="col-sm-10">
                <div class="form-group">
                    <div class="slider col-sm-8" data-value="<%style.iconpaddingtop%>" data-min="0" data-max="30"></div>
                    <div class="col-sm-4 control-labe count"><span><%style.iconpaddingtop%></span>px(像素)</div>
                    <input class="diy-bind input" data-bind-child="style" data-bind="iconpaddingtop" value="<%style.iconpaddingtop%>" type="hidden" />
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2 control-label">左右偏移</div>
            <div class="col-sm-10">
                <div class="form-group">
                    <div class="slider col-sm-8" data-value="<%style.iconpaddingleft%>" data-min="0" data-max="30"></div>
                    <div class="col-sm-4 control-labe count"><span><%style.iconpaddingleft%></span>px(像素)</div>
                    <input class="diy-bind input" data-bind-child="style" data-bind="iconpaddingleft" value="<%style.iconpaddingleft%>" type="hidden" />
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2 control-label">图标缩放</div>
            <div class="col-sm-10">
                <div class="form-group">
                    <div class="slider col-sm-8" data-value="<%style.iconzoom%>" data-min="1" data-max="100"></div>
                    <div class="col-sm-4 control-labe count"><span><%style.iconzoom%></span>%</div>
                    <input class="diy-bind input" data-bind-child="style" data-bind="iconzoom" value="<%style.iconzoom%>" type="hidden" />
                </div>
            </div>
        </div>

    <%/if%>

    <div class="line"></div>

    <div class="form-group">
        <div class="col-sm-2 control-label">商品设置</div>
        <div class="col-sm-10">
        <input type="hidden"  data-bind-child="params" data-bind="goodsdata" data-bind-init="true" name="goodsdata" value="0">
         </div>
    </div>

        <div class="form-items indent" data-min="1">
            <div class="inner" id="form-items">
                <%each data as child itemid %>
                <div class="item" data-id="<%itemid%>">
                    <span class="btn-del" title="删除"></span>
                    <div class="item-image square">
                        <div class="text goods-selector">选择商品</div>
                        <img src="<%imgsrc child.thumb%>" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/static/images/nopic.jpg';" id="pimg-<%itemid%>" />
                        <input type="hidden" class="diy-bind" data-bind-parent="data" data-bind-child="<%itemid%>" data-bind="imgurl"  id="cimg-<%itemid%>" value="<%child.imgurl%>" />
                    </div>
                    <div class="item-form">
                        <div class="input-group" style="margin-bottom:0px; ">
                            <span class="input-group-addon">名称</span>
                            <input class="form-control input-sm" value="<%child.title||'未设置'%>" readonly="readonly" />
                        </div>
                        <div class="input-group" style="margin-top:10px; margin-bottom:0px; ">
                            <span class="input-group-addon">价格</span>
                            <input class="form-control input-sm" value="￥<%child.price%>" readonly="readonly" />
                        </div>
                    </div>
                </div>
                <%/each%>
            </div>
            <div class="btn btn-w-m btn-block btn-default btn-outline" id="addChild"><i class="fa fa-plus"></i> 添加一个</div>
        </div>


</script>

<script type="text/html" id="tpl_edit_diymod">
 
</script>

<script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>weengine/components/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>weengine/components/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>weengine/components/ueditor/lang/zh-cn/zh-cn.js"></script>

<script language="javascript">
    var path = 'diy.min';
    myrequire([path,'tpl','web/biz'],function(modal,tpl){
        modal.init({
            tpl: tpl,
            attachurl: "<?php  echo ATTACHMENT_WEBROOT;?>",
            id: '<?php  echo intval($_GPC["id"])?>',
            type: 2,
            data: <?php  if(!empty($page['datas'])) { ?><?php  echo $page['datas']?><?php  } else { ?>null<?php  } ?>,
            diymenu:  <?php  if(!empty($page['diymenu'])) { ?><?php  echo $page['diymenu']?><?php  } else { ?>[]<?php  } ?>,
        });
    });
    function selectUrlCallback(href){
        var ue =  UE.getEditor('rich');
        if(href){
            ue.execCommand('link', {href: href});
        }
    }
    function callbackGoods(data) {
        myrequire([path],function(modal) {
            modal.callbackGoods(data);
        });
    }
    function callbackCategory (data) {
        myrequire([path],function(modal) {
            modal.callbackCategory(data);
        });
    }
    function callbackGroup (data) {
        myrequire([path],function(modal) {
            modal.callbackGroup(data);
        });
    }
</script>
</div>
<div id="goods-selector-modal"  class="modal fade" tabindex="-1"><div class="modal-dialog" style="width: 920px;"><div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>商品查询</h3></div><div class="modal-body" ><div class="row"><div class="input-group"><input type="text" class="form-control" name="keyword" id="goods_input" placeholder="请输入商品名称" value="" /><span class="input-group-btn"><button type="button" class="btn btn-default" onclick="biz.selector.search(this, 'goods');">搜索</button></span></div></div><div class="content" style="padding-top:5px;" data-name="goods"></div></div><div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div></div></div></div>

<div id="modal-webuploader" class="modal fade" ><div class="modal-dialog" style="width: 920px;">
	<div class="modal-content"><div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>图片上传</h3></div><div class="modal-body" >
   <!--用来存放文件信息-->
  
     <div class="btns" style="text-align:center;" ><div id="picker" style="height:34px;display: inline-block; vertical-align: middle;margin-right:12px;"></div><button id="ctlBtn" class="btn btn-default" style="margin-top:3px;height:38px;">开始上传</button></div>
  <div id="shower" style="margin-top:10px;"></div>
  </div></div>
</div>

</div>
<script language="javascript">myrequire(['web/init'],function(){
    if($('.form-validate').length<=0) {  $('#page-loading').remove(); }
});

window.goods_selector=$('#goods-selector-modal');


$(document).ready(function(){var biz={};biz.url=function(routes,params){var url='x='+routes.replace(/\//ig,'.');if(params){if(typeof(params)=='object'){url+="&"+$.toQueryString(params)}else if(typeof(params)=='string'){url+="&"+params}}return url};biz.selector={select:function(params){params=$.extend({},params||{});var name=params.name===undefined?'default':params.name;name='goods';var modalObj=window.goods_selector;modalObj.modal('show');},search:function(searchbtn,name){var input=$(searchbtn).closest('.modal').find('#'+name+'_input');var keyword=$.trim(input.val());if(keyword==''){input.focus();return}var selector=$("#"+name+'_selector');var modalObj=$('#'+name+"-selector-modal");$('.content',modalObj).html("正在搜索....");$.get(selector.data('url'),{keyword:keyword},function(dat){$('.content',modalObj).html(dat)})},remove:function(obj,name){var selector=$("#"+name+'_selector');var css=selector.data('type')=='image'?'.multi-item':'.multi-audio-item';$(obj).closest(css).remove();biz.selector.refresh(name)},set:function(obj,data){var name=$(obj).closest('.content').data('name');var modalObj=window.goods_selector;var selector=$('#'+name+"_selector");var container=$('.container',selector);var key=selector.data('key')||'id',text=selector.data('text')||'title',thumb=selector.data('thumb')||'thumb',multi=selector.data('multi')||0,type=selector.data('type')||'image',callback=selector.data('callback')||'',css=type=='image'?'.multi-item':'.multi-audio-item';if($(css+'[data-'+key+'="'+data[key]+'"]',container).length>0){if(multi===0){modalObj.modal('hide')}return}var id=multi===0?name:name+"[]";var html="";if(type=='image'){html+='';}if(multi===0){container.html(html);modalObj.modal('hide')}else{container.append(html)}biz.selector.refresh(name);if(callback!==''){var callfunc=eval(callback);if(callfunc!==undefined){callfunc(data,obj)}}},refresh:function(name){var titles='';var selector=$('#'+name+'_selector');var type=selector.data('type')||'image';if(type=='image'){$('.multi-item',selector).each(function(){titles+=" "+$(this).find('.img-nickname').html();if($('.multi-item',selector).length>1){titles+="; "}})}else{$('.multi-audio-item',selector).each(function(){titles+=" "+$(this).find('.img-textname').val();if($('.multi-audio-item',selector).length>1){titles+="; "}})}$('#'+name+"_text",selector).val(titles)}};window.biz=biz;return biz});
</script>

</div>

</body>
</html>
