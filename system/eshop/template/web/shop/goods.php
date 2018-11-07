<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<script type="text/javascript" src="<?php  echo RESOURCE_ROOT;?>weengine/js/lib/jquery-ui-1.10.3.min.js"></script>
<?php  if($operation == 'post') { ?>
<style type='text/css'>
    .tab-pane {padding:20px 0 20px 0;}
</style>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <div class="panel">
          
            <h3 class="custom_page_header">      <?php  if(empty($item['id'])) { ?>添加商品<?php  } else { ?>编辑商品<?php  } ?></h3>
        
            <div class="panel-body">
                <ul class="nav nav-arrow-next nav-tabs" id="myTab">
                    <li class="active" ><a href="#tab_basic">基本信息</a></li>
                    <li><a href="#tab_des">商品描述</a></li>
                    <li><a href="#tab_option">商品规格</a></li>
                    <li><a href="#tab_discount">会员权限及折扣设置</a></li>
					<li><a href="#tab_share">分享及关注设置</a></li>
       <!--             <li><a href="#tab_others">其他设置</a></li>-->

                    
					<li><a href="#tab_verify">线下核销设置</a></li>
               
                    <?php  if(!empty($com_set['level'])) { ?>
                    <li><a href="#tab_sell">分销设置</a></li>
                    <?php  } ?>
                  
					<li><a href="#tab_sale">营销设置</a></li>
             
                
                </ul> 
                <div class="tab-content">
                    <div class="tab-pane  active" id="tab_basic"><?php include $this->template('goods/basic');?></div>
                    <div class="tab-pane" id="tab_des"><?php include $this->template('goods/des');?></div>
                    <div class="tab-pane" id="tab_option"><?php include $this->template('goods/option');?></div>
                    <div class="tab-pane" id="tab_discount"><?php include $this->template('goods/discount');?></div>
                    <div class="tab-pane" id="tab_share"><?php include $this->template('goods/share');?></div>



                  
                    <div class="tab-pane" id="tab_verify"><?php include $this->template('goods/verify');?></div>
              

                    <?php  if( !empty($com_set['level'])) { ?>
                    <div class="tab-pane" id="tab_sell"><?php include $this->template('goods/commission');?></div>
                    <?php  } ?> 

              
                    <div class="tab-pane" id="tab_sale"><?php include $this->template('goods/sale');?></div>
            

                 

                </div>
            </div>
        </div>
        
        
        <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                        
                       <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" onclick="return formcheck()" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
	
			<input type="button" name="back" onclick='history.back()' style='margin-left:10px;' value="返回列表" class="btn btn-default" />

                       
                       </div>
            </div>
    </form>
</div>

<script type="text/javascript">
	window.type = "<?php  echo $item['type'];?>";
	window.virtual = "<?php  echo $item['virtual'];?>";

	$(function () {

		$(':radio[name=type]').click(function () {
			window.type = $("input[name='type']:checked").val();
			window.virtual = $("#virtual").val();
            if(window.type=='1'){
                $('#dispatch_info').show();
            } else {
                $('#dispatch_info').hide();
            }
			if (window.type == '3') {
				if ($('#virtual').val() == '0') {
					$('.choosetemp').show();
				}
			}
		})
	})
			var category = <?php  echo json_encode($children)?>;
	window.optionchanged = false;
	require(['bootstrap'], function () {
		$('#myTab a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		})
	});



	function formcheck() {
		window.type = $("input[name='type']:checked").val();
		window.virtual = $("#virtual").val();

		if ($("#goodsname").isEmpty()) {
		$('#myTab a[href="#tab_basic"]').tab('show');
				Tip.focus("#goodsname", "请输入商品名称!");
				return false;
		}

		if ($("#category_child").val() == '0') {
			$('#myTab a[href="#tab_basic"]').tab('show');
			Tip.focus("#category_child", "请选择完整商品分类!");
			return false;
		}


		<?php  if(empty($id)) { ?>
		if ($.trim($(':input[name="thumb"]').val()) == '') {
		$('#myTab a[href="#tab_basic"]').tab('show');
				Tip.focus(':input[name="thumb"]', '请上传缩略图.');
				return false;
		}
		<?php  } ?>
				var full = true;
		if (window.type == '3') {

			if (window.virtual != '0') {  //如果单规格，不能有规格

				if ($('#hasoption').get(0).checked) {

					$('#myTab a[href="#tab_option"]').tab('show');
					util.message('您的商品类型为：虚拟物品(卡密)的单规格形式，需要关闭商品规格！');
					return false;
				}
			}
			else {

				var has = false;
				$('.spec_item_virtual').each(function () {
					has = true;
					if ($(this).val() == '' || $(this).val() == '0') {
						$('#myTab a[href="#tab_option"]').tab('show');
						Tip.focus($(this).next(), '请选择虚拟物品模板!');
						full = false;
						return false;
					}
				});
				if (!has) {
					$('#myTab a[href="#tab_option"]').tab('show');
					util.message('您的商品类型为：虚拟物品(卡密)的多规格形式，请添加规格！');
					return false;
				}
			}
		}
		if (!full) {
			return false;
		}

		full = checkoption();
		if (!full) {
			return false;
		}
		if (optionchanged) {
			$('#myTab a[href="#tab_option"]').tab('show');
			alert('规格数据有变动，请重新点击 [刷新规格项目表] 按钮!');
			return false;
		}
		return true;
	}

	function checkoption() {

		var full = true;
		if ($("#hasoption").get(0).checked) {
			$(".spec_title").each(function (i) {
				if ($(this).isEmpty()) {
					$('#myTab a[href="#tab_option"]').tab('show');
					Tip.focus(".spec_title:eq(" + i + ")", "请输入规格名称!", "top");
					full = false;
					return false;
				}
			});
			$(".spec_item_title").each(function (i) {
				if ($(this).isEmpty()) {
					$('#myTab a[href="#tab_option"]').tab('show');
					Tip.focus(".spec_item_title:eq(" + i + ")", "请输入规格项名称!", "top");
					full = false;
					return false;
				}
			});
		}
		if (!full) {
			return false;
		}
		return full;
	}

</script>

<?php  } else if($operation == 'display') { ?>

<div class="main">
    <div class="panel">
    	  <h3 class="custom_page_header"><?php if($_GPC['goodsfrom'] == 'sale'){?>上架<?php }?><?php if($_GPC['goodsfrom'] == 'out'){?>已售完<?php }?><?php if($_GPC['goodsfrom'] == 'stock'){?>未上架<?php }?>商品管理		<a class='btn btn-default' href="<?php  echo $this->createWebUrl('shop/goods',array('op'=>'post'))?>"><i class='fa fa-plus'></i> 添加商品</a> </h3>
        <div class="panel-body">
            <form action="" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="mod" value="site" />
                <input type="hidden" name="m" value="eshop" />
                <input type="hidden" name="do" value="shop" />
                <input type="hidden" name="act"  value="goods" />
                <input type="hidden" name="op" value="display" />
                  <input type="hidden" name="goodsfrom" value="<?php  echo $_GPC['goodsfrom'];?>" />
                
                <div class="form-group">
                	  
                    	 <div class="col-sm-2">
                        <input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="商品名称关键字">
                    </div>
                      
						<?php  echo tpl_form_field_category_2level('category', $parent, $children, $params[':pcate'], $params[':ccate'])?>
					   <div class="col-sm-1"> <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    	</div>
                 
                </div>
                
          
            </form>
        </div>
    <style>
        .label{cursor:pointer;}
    </style>

    <form action="" method="post">
	
			<div class="panel-body table-responsive">
				<table class="table table-hover">
					<thead class="navbar-inner">
						<tr>
							<th style="width:50px;">ID</th>
							<th style="width:70px;">排序</th>
							<th style="width:60px;">商品</th>
							<th style="width:250px;">&nbsp;</th>
							<th  >价格</th>
							<th >库存</th>
							<th>实际销量</th>
							<th>状态<br/>(点击可修改)</th>
							<th >操作</th>
						</tr>
					</thead>
					<tbody>
						   <?php  if(count($list)>0) { ?>
						<?php  if(is_array($list)) { foreach($list as $item) { ?>
						<tr>

							<td><?php  echo $item['id'];?></td>
							<td>
						
								<input type="text" class="form-control" name="displayorder[<?php  echo $item['id'];?>]" value="<?php  echo $item['displayorder'];?>">
							
							</td>
							<td title="<?php  echo $item['title'];?>">
								<img src="<?php  echo tomedia($item['thumb'])?>" style="width:40px;height:40px;padding:1px;border:1px solid #ccc;"  />
							</td>
							<td title="<?php  echo $item['title'];?>" class='tdedit'>
								<?php  if(!empty($category[$item['pcate']])) { ?>
								<span class="text-danger">[<?php  echo $category[$item['pcate']]['name'];?>]</span>
								<?php  } ?>
								<?php  if(!empty($category[$item['ccate']])) { ?>
								<span class="text-info">[<?php  echo $category[$item['ccate']]['name'];?>]</span>
								<?php  } ?>
					
								<br/>
			

								<span class=' fa-edit-item' style='cursor:pointer'><i class='fa fa-pencil' style="display:none"></i> <span class="title"><?php  echo $item['title'];?></span> </span>
								<div class="input-group goodstitle" style="display:none" data-goodsid="<?php  echo $item['id'];?>">
									<input type='text' class='form-control' value="<?php  echo $item['title'];?>"   />
									<div class="input-group-btn">
										<button type="button" class="btn btn-default" data-goodsid='<?php  echo $item['id'];?>' data-type="title"><i class="fa fa-check"></i></button>
									</div>
								</div>
							</td>
						
							<td class='tdedit'>
								<?php  if($item['hasoption']==1) { ?>
								<span class='tip' title='多规格不支持快速修改'><?php  echo $item['marketprice'];?></span>
							
								<?php  } else { ?>
					

								<span class=' fa-edit-item' style='cursor:pointer'><i class='fa fa-pencil' style="display:none"></i> <span class="title"><?php  echo $item['marketprice'];?></span> </span>
								<div class="input-group" style="display:none" data-goodsid="<?php  echo $item['id'];?>">
									<input type='text' class='form-control' value="<?php  echo $item['marketprice'];?>"   />
									<div class="input-group-btn">
										<button type="button" class="btn btn-default" data-goodsid='<?php  echo $item['id'];?>' data-type="marketprice"><i class="fa fa-check"></i></button>
									</div>
								</div>
								<?php  } ?>

							</td>

							<td class='tdedit'>
								<?php  if($item['hasoption']==1) { ?>
				
								<span class='tip' title='多规格不支持快速修改'><?php  echo $item['total'];?></span>
							
								<?php  } else { ?>
						

								<span class=' fa-edit-item' style='cursor:pointer'><i class='fa fa-pencil' style="display:none"></i> <span class="title"><?php  echo $item['total'];?></span> </span>
								<div class="input-group" style="display:none" data-goodsid="<?php  echo $item['id'];?>">
									<input type='text' class='form-control' value="<?php  echo $item['total'];?>"   />
									<div class="input-group-btn">
										<button type="button" class="btn btn-default" data-goodsid='<?php  echo $item['id'];?>' data-type="total"><i class="fa fa-check"></i></button>
									</div>
								</div>
							<?php  } ?>

							</td>


							<td><?php  echo $item['salesreal'];?></td>
						
							<td>
								<label data='<?php  echo $item['status'];?>' class='label  label-default <?php  if($item['status']==1) { ?>label-info<?php  } ?>' onclick="setProperty(this,<?php  echo $item['id'];?>,'status')"><?php  if($item['status']==1) { ?>上架<?php  } else { ?>下架<?php  } ?></label>
								<label data='<?php  echo $item['type'];?>' class='label  label-default <?php  if($item['type']==1) { ?>label-info<?php  } ?>'onclick="setProperty(this,<?php  echo $item['id'];?>,'type')"><?php  if($item['type']==1) { ?>实体物品<?php  } else { ?>虚拟物品<?php  } ?></label>
							</td>
							<td style="text-align:center">
							<p>	<a href="<?php  echo $this->createMobileUrl('shop/detail', array('id' => $item['id']))?>" title="复制连接" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-link"></i>预览</a>
						<a href="<?php  echo $this->createWebUrl('shop/goods', array('id' => $item['id'], 'op' => 'post'))?>"class="btn btn-sm btn-default" title="编辑"><i class="fa fa-pencil"></i>编辑</a>
								</p>		<p>	<a href="<?php  echo $this->createWebUrl('shop/goods', array('id' => $item['id'], 'op' => 'delete'))?>" onclick="return confirm('确认删除此商品？');
										return false;" class="btn btn-default  btn-sm" title="删除"><i class="fa fa-times"></i>删除</a>	</p>	
							</td>
						</tr>
		
							<tr >		<td colspan='2' style="text-align:left;; padding-bottom:30px">商品属性：</td>
							<td colspan='7'  style='padding-bottom:30px;'>
                              <div style='padding:5px;'>
                              		<label data='<?php  echo $item['isindex'];?>' class='label label-default <?php  if($item['isindex']==1) { ?>label-info<?php  } else { ?><?php  } ?>'   onclick="setProperty(this,<?php  echo $item['id'];?>,'index')">首页</label>
                   	&nbsp;-&nbsp; 	<label data='<?php  echo $item['isnew'];?>' class='label label-default <?php  if($item['isnew']==1) { ?>label-info<?php  } else { ?><?php  } ?>'   onclick="setProperty(this,<?php  echo $item['id'];?>,'new')">新品</label>
							&nbsp;-&nbsp; <label data='<?php  echo $item['ishot'];?>' class='label label-default <?php  if($item['ishot']==1) { ?>label-info<?php  } ?>' onclick="setProperty(this,<?php  echo $item['id'];?>,'hot')">热卖</label>
							&nbsp;-&nbsp; <label data='<?php  echo $item['isrecommand'];?>' class='label label-default <?php  if($item['isrecommand']==1) { ?>label-info<?php  } ?>' onclick="setProperty(this,<?php  echo $item['id'];?>,'recommand')">推荐</label>
							&nbsp;-&nbsp; <label data='<?php  echo $item['isdiscount'];?>' class='label label-default <?php  if($item['isdiscount']==1) { ?>label-info<?php  } ?>' onclick="setProperty(this,<?php  echo $item['id'];?>,'discount')">促销</label>
						
							&nbsp;-&nbsp; <label data='<?php  echo $item['issendfree'];?>' class='label label-default <?php  if($item['issendfree']==1) { ?>label-info<?php  } ?>' onclick="setProperty(this,<?php  echo $item['id'];?>,'sendfree')">包邮</label>
							&nbsp;-&nbsp; <label data='<?php  echo $item['istime'];?>' class='label label-default <?php  if($item['istime']==1) { ?>label-info<?php  } ?>' onclick="setProperty(this,<?php  echo $item['id'];?>,'time')">限时卖</label>
							&nbsp;-&nbsp; <label data='<?php  echo $item['isnodiscount'];?>' class='label label-default <?php  if($item['isnodiscount']==1) { ?>label-info<?php  } ?>' onclick="setProperty(this,<?php  echo $item['id'];?>,'nodiscount')">不参与折扣</label>

                              </div>	</td>
						</tr>		
						<?php } }  } else { ?>
								<tr>
							<td colspan='9'>
                              <div  style='text-align: center;padding:30px;'>
                                  暂时没有任何商品!
                              </div>	</td>
						</tr>
                          <?php  } ?>
                             <?php  if(count($list)>0) { ?>
						<tr>
							<td colspan='9'>
						
								<input name="submit" type="submit" class="btn btn-primary" value="保存排序">
								<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
					

							</td>
						</tr>
 <?php  } ?>
						</tr>
					</tbody>
				</table>
				<?php  echo $pager;?>
			</div>
	</form>
</div>
    </div>
<script type="text/javascript">
	function fastChange(id, type, value) {
		
		$.ajax({
			url: "<?php  echo $this->createWebUrl('shop/goods')?>",
			type: "post",
			data: {op: 'change', id: id, type: type, value: value},
			cache: false,
			success: function () {

			}
		})
	}
	$(function () {
		$("form").keypress(function(e) {
			if (e.which == 13) {
			  return false;
			}
		  });

		$('.tdedit input').keydown(function (event) {
			if (event.keyCode == 13) {
			     var group = $(this).closest('.input-group');
				 var type = group.find('button').data('type');
				var goodsid = group.find('button').data('goodsid');
				var val = $.trim($(this).val());
				if(type=='title' && val==''){
					return;
				}
				group.prev().show().find('span').html(val);
				group.hide();
				fastChange(goodsid,type,val);
			}
		})
		$('.tdedit').mouseover(function () {
			$(this).find('.fa-pencil').show();
		}).mouseout(function () {
			$(this).find('.fa-pencil').hide();
		});
		$('.fa-edit-item').click(function () {
			var group = $(this).closest('span').hide().next();

			group.show().find('button').unbind('click').click(function () {
				var type = $(this).data('type');
				var goodsid = $(this).data('goodsid');
				var val = $.trim(group.find(':input').val());
				if(type=='title' && val==''){
					Tip.show(group.find(':input'), '请输入名称!');
					return;
				}
				group.prev().show().find('span').html(val);
				group.hide();
				fastChange(goodsid,type,val);
			});
		})
	})
			var category = <?php  echo json_encode($children)?>;
	function setProperty(obj, id, type) {
		$(obj).html($(obj).html() + "...");
		$.post("<?php  echo $this->createWebUrl('shop/goods')?>"
				, {'op': 'setgoodsproperty', id: id, type: type, data: obj.getAttribute("data")}
		, function (d) {
			$(obj).html($(obj).html().replace("...", ""));
			if (type == 'type') {
				$(obj).html(d.data == '1' ? '实体物品' : '虚拟物品');
			}
			if (type == 'status') {
				$(obj).html(d.data == '1' ? '上架' : '下架');
			}
			$(obj).attr("data", d.data);
			if (d.result == 1) {
				$(obj).toggleClass("label-info");
			}
		}
		, "json"
				);
	}

</script>
<?php  } ?>
<?php include page("footer-base");?>