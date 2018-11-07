<?php defined('IN_IA') or exit('Access Denied');?><script type="text/html" id="tpl_show_notice">
    <div class="drag" data-itemid="<%itemid%>">
        <div class="fui-notice" style="background: <%style.background%>">
            <div class="image"><img src="<%imgsrc params.iconurl%>" onerror="this.src='<?php  echo WEBSITE_ROOT;?>/assets/eshop/static/images/default/hotdot.jpg'"></div>
            <div class="icon"><i class="icon icon-notification1" style="font-size: 0.7rem; color: <%style.iconcolor%>;"></i></div>
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
            <p><span style="font-size: 20px;">哈喽大家好！这里是『富文本』区域</span></p>
            <p>你可以对文字进行<strong>加粗</strong>、<em>斜体</em>、<span style="text-decoration: underline;">下划线</span>、<span style="text-decoration: line-through;">删除线</span>、文字<span style="color: rgb(0, 176, 240);">颜色</span>、<span style="background-color: rgb(255, 192, 0); color: rgb(255, 255, 255);">背景色</span>、以及字号<span style="font-size: 20px;">大</span><span style="font-size: 14px;">小</span>等简单排版操作。
            </p>
            <p>也可在这里插入图片</p>
            <p><img src="<?php  echo WEBSITE_ROOT;?>/assets/eshop/static/designer/imgsrc/sale-by.png"></p>
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
                <i class="icon <%params.icon%>"></i>
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
                <div class="search-icon" style="color: <%style.iconcolor%>;"><i class="icon icon-search"></i></div>
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
                                        <img src="<?php  echo WEBSITE_ROOT;?>/assets/eshop/static/images/default/goodsicon-<%style.goodsicon%>.png" style="width: <%style.iconzoom||'100'%>%;" />
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
                                            <span class="buy" style="background-color: <%style.buybtncolor%>;"><i class="icon icon-cart"></i></span>
                                        <%/if%>
                                        <%if style.buystyle=='buybtn-2'%>
                                            <span class="buy" style="background-color: <%style.buybtncolor%>;"><i class="icon icon-add"></i></span>
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
                        <div class="image" style="background-image: url('<?php  echo WEBSITE_ROOT;?>/assets/eshop/static/images/default/goods-3.jpg');">
                                <%if (params.showicon=='1' || params.showicon=='2')%>
                                    <div class="goodsicon <%params.iconposition%>"
                                        <%if params.iconposition=='left top'%> style="top: <%style.iconpaddingtop%>px; left: <%style.iconpaddingleft%>px; text-align: left;"<%/if%>
                                        <%if params.iconposition=='right top'%> style="top: <%style.iconpaddingtop%>px; right: <%style.iconpaddingleft%>px; text-align: right;"<%/if%>
                                        <%if params.iconposition=='left bottom'%> style="bottom: <%style.iconpaddingtop%>px; left: <%style.iconpaddingleft%>px; text-align: left;"<%/if%>
                                        <%if params.iconposition=='right bottom'%> style="bottom: <%style.iconpaddingtop%>px; right: <%style.iconpaddingleft%>px; text-align: right;"<%/if%>
                                    >
                                    <%if params.showicon=='1'%>
                                        <img src="<?php  echo WEBSITE_ROOT;?>/assets/eshop/static/images/default/goodsicon-<%style.goodsicon%>.png" style="width: <%style.iconzoom||'100'%>%;" />
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
                                            <span class="buy" style="background-color: <%style.buybtncolor%>;"><i class="icon icon-cart"></i></span>
                                        <%/if%>
                                        <%if style.buystyle=='buybtn-2'%>
                                            <span class="buy" style="background-color: <%style.buybtncolor%>;"><i class="icon icon-add"></i></span>
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
    <div class="drag" data-itemid="<%itemid%>">
        <div style="padding: 10px; font-size: 14px;">公用模块：<%params.modname%></div>
    </div>
</script>

<!-- 另存为模板 弹出层 -->
<div class="modal fade" id="saveTempModal" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h4 class="modal-title">另存为模板</h4>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group">
                    <div class="col-sm-2 control-label must">模板名称</div>
                    <div class="col-sm-10">
                        <input class="form-control input-sm" placeholder="请输入模板名称" id="saveTempName" value="未命名模板" aria-required="true" data-rule-required="true" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">缩略图</div>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input class="form-control input-sm" placeholder="请选择模板缩略图" value="" id="saveTempPreview">
                            <span data-input="#saveTempPreview" data-img="#tempimg" data-toggle="selectImg" class="input-group-addon btn btn-default">选择图片</span>
                        </div>
                        <div class="input-group " style="margin-top:.5em;">
                            <img src="<?php  echo WEBSITE_ROOT;?>/assets/eshop/static/images/nopic.jpg" onerror="this.src='<?php  echo WEBSITE_ROOT;?>/assets/eshop/static/images/nopic.jpg';" class="img-responsive img-thumbnail" width="150" id="tempimg">
                            <em class="close" style="position:absolute; top: 0px; right: -14px;" title="删除这张图片" onclick="$('#tempsrc').val('').trigger('change');$(this).prev().attr('src', '')">×</em>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 control-label">模板分类</div>
                    <div class="col-sm-10">
                        <select class="form-control input-sm" id="saveTempCate" >
                            <?php  if(is_array($category)) { foreach($category as $item) { ?>
                                <option value="<?php  echo $item['id'];?>"><?php  echo $item['name'];?></option>
                            <?php  } } ?>
                            <option value="0">不分类</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn btn-primary" id="saveTemp">保存</div>
                <button data-dismiss="modal" class="btn btn-default" type="button">关闭</button>
            </div>
        </div>
    </div>
</div>