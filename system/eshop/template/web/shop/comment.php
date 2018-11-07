<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
 <link href="<?php  echo RESOURCE_ROOT;?>eshop/static/mobile/static/js/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
<script src="<?php  echo RESOURCE_ROOT;?>eshop/static/mobile/static/js/star-rating.js" type="text/javascript"></script>
<?php  if($operation=='add') { ?>

<div class="main">
    <form id="dataform" action="" method="post" class="form-horizontal form" onsubmit='return formcheck()'>
        <div class='panel'>
          
            
            <h3 class="custom_page_header">   添加评价</h3>
            <div class='panel-body'>
                  
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>  选择商品</label>
                    <div class="col-sm-5">
                        <input type='hidden' id='goodsid' name='goodsid' value="<?php  echo $item['goodsid'];?>" />
                        <div class='input-group'>
                            <input type="text" name="goods" maxlength="30" value="<?php  if(!empty($goods)) { ?>[<?php  echo $goods['id'];?>]<?php  echo $goods['title'];?><?php  } ?>" id="goods" class="form-control" readonly />
                            <div class='input-group-btn'>
                                <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus-goods').modal();">选择商品</button>
                                <button class="btn btn-danger" type="button" onclick="$('#uid').val('');$('#user').val('');">清除选择</button>
                            </div>
                        </div>
                         <span id="goodsthumb" class='help-block' <?php  if(empty($goods)) { ?>style="display:none"<?php  } ?>><img  style="width:100px;height:100px;border:1px solid #ccc;padding:1px" src="<?php  echo tomedia($goods['thumb'])?>"/></span>
                          
                        <div id="modal-module-menus-goods"  class="modal fade" tabindex="-1">
                            <div class="modal-dialog" style='width: 920px;'>
                                <div class="modal-content">
                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择商品</h3></div>
                                    <div class="modal-body" >
                                        <div class="row"> 
                                            <div class="input-group"> 
                                                <input type="text" class="form-control" name="keyword" value="" id="search-kwd-goods" placeholder="请输入商品名称" />
                                                <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_goods();">搜索</button></span>
                                            </div>
                                        </div>
                                        <div id="module-menus-goods" style="padding-top:5px;"></div>
                                    </div>
                                    <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">用户头像</label>
                    <div class="col-sm-9 col-xs-12">
                         <?php  echo tpl_form_field_image('headimgurl',$item['headimgurl'])?>
                         <span class='help-block'>用户头像，如果不选择，默认从粉丝表中随机读取</span>
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">用户昵称</label>
                    <div class="col-sm-9 col-xs-12">
                         <input type='text' class='form-control' name='nickname' value='<?php  echo $item['nickname'];?>' />
                         <span class='help-block'>用户昵称，如果不填写，默认从粉丝表中随机读取</span>
                    </div>
                </div>
                 <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 评分等级</label>
                    <div class="col-sm-9 col-xs-12">
                        <input value="<?php  echo intval($item['level'])?>" type="number" name='level' class="rating" min=0 max=5 step=1 data-size="xs" >
                    </div>
                </div>
                
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 首次评价</label>
                    <div class="col-sm-9 col-xs-12">
                        <textarea name='content' class="form-control"><?php  echo $item['content'];?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                          <?php  echo tpl_form_field_multi_image('images',iunserializer($item['images']))?>
                    </div>
                </div>
          
                
                 <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">首次回复</label>
                    <div class="col-sm-9 col-xs-12">
                        <textarea name='reply_content' class="form-control"><?php  echo $item['reply_content'];?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                          <?php  echo tpl_form_field_multi_image('reply_images',iunserializer($item['reply_images']))?>
                    </div>
                </div>
                
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">追加评价</label>
                    <div class="col-sm-9 col-xs-12">
                        <textarea name='append_content' class="form-control"><?php  echo $item['append_content'];?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                          <?php  echo tpl_form_field_multi_image('append_images',iunserializer($item['append_images']))?>
                    </div>
                </div>
                
                 <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">追加回复</label>
                    <div class="col-sm-9 col-xs-12">
                        <textarea name='append_reply_content' class="form-control"><?php  echo $item['append_reply_content'];?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                          <?php  echo tpl_form_field_multi_image('append_reply_images',iunserializer($item['append_reply_images']))?>
                    </div>
                </div>
                
                
                    <div class="form-group"></div>
            <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                       <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"  />
                       <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                       <input type="button" name="back" onclick='history.back()' style='margin-left:10px;' value="返回列表" class="btn btn-default" />
                    </div>
            </div>
                    
            </div>
        </div>
     
    </form>
</div>
<script language='javascript'>
    $(function(){
          $(".rating").rating({});
    });
    function formcheck(){
        if($(':input[name=goods]').val()==''){
            Tip.focus($(':input[name=goods]'),'请选择要评价的商品!');
            return false;
        }
        if($(':input[name=level]').val()=='0'){
            alert('请选择评价等级!');
            return false;
        }
        if($.trim($('textarea[name=content]').val())==''){
            alert('请填写评价内容!');
            $('textarea[name=content]').focus();
            return false;
        }
        if($.trim($('textarea[name=append_content]').val())==''){
             if($.trim($('textarea[name=append_reply_content]').val())!=''){
                    alert('请填写追加评价后才能添加追加回复!');
                    return false;
             }
        }
        return true;
    }
        function search_goods() {
             if( $.trim($('#search-kwd-goods').val())==''){
                 Tip.focus('#search-kwd-goods','请输入关键词');
                 return;
             }
		$("#module-menus-goods").html("正在搜索....")
		$.get('<?php  echo $this->createWebUrl('shop/query')?>', {
			keyword: $.trim($('#search-kwd-goods').val())
		}, function(dat){
			$('#module-menus-goods').html(dat);
		});
	}
	function select_good(o) {
	             $("#goodsid").val(o.id);
                               $("#goodsthumb").show();
                               $("#goodsthumb").find('img').attr('src', o.thumb);
                               $("#goods").val( "[" + o.id + "]" + o.title);
   	             $("#modal-module-menus-goods .close").click();
	}
</script>

<?php  } else if($operation == 'post') { ?>
           <style type='text/css'>
                .multi-item { height:110px;}
                .img-thumbnail { width:100px;}
                .img-nickname { position: absolute;bottom:0px;line-height:25px;height:25px;
                                color:#fff;text-align:center;width:90px;bottom:55px;background:rgba(0,0,0,0.8);left:5px;}
                .multi-img-details { padding:5px;}
            </style>
<div class="main">
    <form id="dataform" action="" method="post" class="form-horizontal form" onsubmit='return formcheck()' >
        <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
        <div class='panel '>
        
            <h3 class="custom_page_header">   回复评价</h3>
            <div class='panel-body'>
                     <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单号</label>
                    <div class="col-sm-9 col-xs-12">
                        <div class='form-control-static'><?php  echo $order['ordersn'];?></div>
                    </div>
                     </div>
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">评价商品</label>
    
                        <div class="col-sm-9 col-xs-12">
                            <input type="text" name="goods" maxlength="30" value="<?php  if(!empty($goods)) { ?>[<?php  echo $goods['id'];?>]<?php  echo $goods['title'];?><?php  } ?>" id="goods" class="form-control" readonly />
                         <span id="goodsthumb" class='help-block' <?php  if(empty($goods)) { ?>style="display:none"<?php  } ?>><img  style="width:100px;height:100px;border:1px solid #ccc;padding:1px" src="<?php  echo tomedia($goods['thumb'])?>"/></span>
                        </div>
         
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">评价者</label>
                     <div class="col-sm-9 col-xs-12">
                            <input type="text" name="goods" maxlength="30" value="<?php  echo $item['nickname'];?>" id="goods" class="form-control" readonly />
                         <span id="goodsthumb" class='help-block' ><img  style="width:100px;height:100px;border:1px solid #ccc;padding:1px" src="<?php  echo tomedia($item['headimgurl'])?>" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'"/></span>
                        </div>
                </div>
                 <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">评分等级</label>
                    <div class="col-sm-9 col-xs-12">
                     <div class="form-control-static" style='color:#ff6600'>
                            <?php  if($item['level']>=1) { ?><i class='fa fa-star'></i><?php  } else { ?><i class='fa fa-star-o'></i><?php  } ?>
                           <?php  if($item['level']>=2) { ?><i class='fa fa-star'></i><?php  } else { ?><i class='fa fa-star-o'></i><?php  } ?>
                           <?php  if($item['level']>=3) { ?><i class='fa fa-star'></i><?php  } else { ?><i class='fa fa-star-o'></i><?php  } ?>
                           <?php  if($item['level']>=4) { ?><i class='fa fa-star'></i><?php  } else { ?><i class='fa fa-star-o'></i><?php  } ?>
                           <?php  if($item['level']>=5) { ?><i class='fa fa-star'></i><?php  } else { ?><i class='fa fa-star-o'></i><?php  } ?>
                           </div>
                    </div>
                </div>
                
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 首次评价</label>
                    <div class="col-sm-9 col-xs-12">
                          <div class="form-control-static"><?php  echo $item['content'];?></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                        <div class="input-group multi-img-details">
                            <?php  $images = iunserializer($item['images'])?>
                            <?php  if(is_array($images)) { foreach($images as $img) { ?>
                            <div class="multi-item">
                                <a href='<?php  echo tomedia($img)?>' target='_blank'>
                                <img class="img-responsive img-thumbnail" src='<?php  echo tomedia($img)?>' onerror="this.src='./resource/images/nopic.jpg'; this.title='图片未找到.'">
                                </a>
                            </div>
                            <?php  } } ?>
                        </div>
                    </div>
                </div>
          
                
                 <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">首次回复</label>
                    <div class="col-sm-9 col-xs-12">
                        <textarea name='reply_content' class="form-control"><?php  echo $item['reply_content'];?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                          <?php  echo tpl_form_field_multi_image('reply_images',iunserializer($item['reply_images']))?>
                    </div>
                </div>
                <?php  if(!empty($item['append_content'])) { ?>
                  <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">追加评价</label>
                    <div class="col-sm-9 col-xs-12">
                         <div class="form-control-static"><?php  echo $item['append_content'];?></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                          <div class="input-group multi-img-details">
                            <?php  $append_images = iunserializer($item['append_images'])?>
                            <?php  if(is_array($images)) { foreach($images as $img) { ?>
                            <div class="multi-item">
                                <a href='<?php  echo tomedia($img)?>' target='_blank'>
                                <img class="img-responsive img-thumbnail" src='<?php  echo tomedia($img)?>' onerror="this.src='./resource/images/nopic.jpg'; this.title='图片未找到.'">
                                </a>
                            </div>
                            <?php  } } ?>
                        </div>
                    </div>
                </div>
                
                 <div class="form-group">
                      <label class="col-xs-12 col-sm-3 col-md-2 control-label">追加回复</label>
                    <div class="col-sm-9 col-xs-12">
                        <textarea name='append_reply_content' class="form-control"><?php  echo $item['append_reply_content'];?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                          <?php  echo tpl_form_field_multi_image('append_reply_images',iunserializer($item['append_reply_images']))?>
                    </div>
                </div>
                <?php  } ?>
                
                
                    <div class="form-group"></div>
            <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                       <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"  />
                       <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                       <input type="button" name="back" onclick='history.back()' style='margin-left:10px;'value="返回列表" class="btn btn-default" />
                    </div>
            </div>
                    
            </div>
        </div>
    </form>
</div>
<script language='javascript'>
      function formcheck(){
 
     
        if($.trim($('textarea[name=reply_content]').val())==''){
            alert('请填写首次回复内容!');
            $('textarea[name=reply_content]').focus();
            return false;
        }
        <?php  if(!empty($item['append_reply_content'])) { ?>
             if($.trim($('textarea[name=append_reply_content]').val())==''){
                alert('请填写追加回复内容!');
                $('textarea[name=append_reply_content]').focus();
                return false;
            }
        <?php  } ?>
     
        return true;
    }
</script>
<?php  } else if($operation == 'display') { ?>
<form action="" method="get" class='form form-horizontal'>
    <div class="panel ">
        
            <h3 class="custom_page_header">   评价管理     <a class='btn btn-default' href="<?php  echo $this->createWebUrl('shop/comment',array('op'=>'add'))?>"><i class='fa fa-plus'></i> 添加评价</a>
       </h3>
        <div class="panel-body">
            <form action="" method="get" class="form-horizontal">
                <input type="hidden" name="mod" value="site" />
                <input type="hidden" name="m" value="eshop" />
                <input type="hidden" name="do" value="shop" />
                <input type="hidden" name="act"  value="comment" />
                <input type="hidden" name="op" value="display" />
                
                <div class="form-group">
                	  <div class="col-sm-1  control-label">
                    关键词
                    </div>
                    <div class="col-sm-2">
                      <input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="评论关键字搜索">
                    </div>
                     <div class="col-sm-1  control-label">
                    类型
                    </div>
                    <div class="col-sm-2">
                    	  <select name='fade' class='form-control'>
                          <option value='' <?php  if($_GPC['fade']=='') { ?>selected<?php  } ?>></option>
                          <option value='0' <?php  if($_GPC['fade']=='0') { ?>selected<?php  } ?>>模拟评价</option>
                          <option value='1' <?php  if($_GPC['fade']=='1') { ?>selected<?php  } ?> >真实评价</option>
                       </select> 
                    </div>
                    
                       <div class="col-sm-1  control-label">
                    回复状态
                    </div>
                    <div class="col-sm-2">
                      <select name='replystatus' class='form-control'>
                          <option value='' <?php  if($_GPC['replystatus']=='') { ?>selected<?php  } ?>></option>
                          <option value='0' <?php  if($_GPC['replystatus']=='0') { ?>selected<?php  } ?>>需要首次回复</option>
                          <option value='1' <?php  if($_GPC['replystatus']=='1') { ?>selected<?php  } ?> >需要追加回复</option>
                       </select> 
                    </div>
                    
                    
                </div>
                
                 <div class="form-group">
                 		  <div class="col-sm-1  control-label">
                    订单时间
                    </div>
                 	 <div class="col-sm-6">
                 	     <div class='input-group'>
                        <div class='input-group-addon'>
                            <label class='radio-inline' style='margin-top:-7px;'>
                                <input type='radio' value='0' name='searchtime' <?php  if(empty($_GPC['searchtime'])) { ?>checked<?php  } ?>>不搜索
                            </label>
                            <label class='radio-inline'  style='margin-top:-7px;'>
                                <input type='radio' value='1' name='searchtime' <?php  if($_GPC['searchtime']=='1') { ?>checked<?php  } ?>>搜索
                            </label>
                        </div>
                       <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d  H:i', $endtime)),true);?>
                 	  </div>  </div>
                 	
                    <div class="col-sm-5 ">
                       
                    &nbsp; &nbsp; <button class="btn btn-default"><i class="fa fa-search"></i> &nbsp; &nbsp; 搜索 &nbsp; &nbsp;</button>  </div>
 
                </div>
                
               
                
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th style='width:50px;'>商品</th>
                            <th style='width:200px;'></th>
                        <th style='width:200px;'>评价者</th>
                        <th style='width:100px;' >评分等级</th>
 
                        <th style='width:100px;'>评价状态</th>
                        <th style='width:100px;'>回复状态</th>
                        
                        <th  style='width:150px;'>评价时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody><?php  if(count($list)>0) { ?>
                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr>
                    
                        <td><img src="<?php  echo tomedia($row['thumb'])?>" style="width: 30px; height: 30px;border:1px solid #ccc;padding:1px;"></td>
                            <td>
                        <?php  echo $row['title'];?><br/>
                            <?php  if(empty($row['openid'])) { ?>
                              <label class='label label-default'>模拟评价</label>
                              <?php  } else { ?>
                              <?php  echo $row['ordersn'];?>
                              <?php  } ?>
                        </td>
                        
                         <td><img src="<?php  echo tomedia($row['headimgurl'])?>" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" style="width: 30px; height: 30px;border:1px solid #ccc;padding:1px;">
                        <?php  echo $row['nickname'];?></td>
                        <td style="color:#ff6600">
                          <?php  if($row['level']>=1) { ?><i class='fa fa-star'></i><?php  } else { ?><i class='fa fa-star-o'></i><?php  } ?>
                           <?php  if($row['level']>=2) { ?><i class='fa fa-star'></i><?php  } else { ?><i class='fa fa-star-o'></i><?php  } ?>
                           <?php  if($row['level']>=3) { ?><i class='fa fa-star'></i><?php  } else { ?><i class='fa fa-star-o'></i><?php  } ?>
                           <?php  if($row['level']>=4) { ?><i class='fa fa-star'></i><?php  } else { ?><i class='fa fa-star-o'></i><?php  } ?>
                           <?php  if($row['level']>=5) { ?><i class='fa fa-star'></i><?php  } else { ?><i class='fa fa-star-o'></i><?php  } ?>
                            
                        </td>
                  
                        <td>
                            <?php  if(!empty($row['append_content'])) { ?>
                            <label class='label label-warning'>追加了评价</label>
                            <?php  } else { ?>
                            <label class='label label-primary'>首次回复</label>
                            <?php  } ?>
                        </td>
                            <td>
                            <?php  if(empty($row['reply_content'])) { ?>
                                <label class='label label-danger'>未首次回复</label>
                            <?php  } else { ?>
                               <label class='label label-danger'>已首次回复</label>
                            <?php  } ?>
                            
                           <?php  if(!empty($row['append_content'])) { ?>
                                <?php  if(empty($row['append_reply_content'])) { ?>
                                <label class='label label-warning'>未追加回复</label>
                                <?php  } ?>
                            <?php  } ?>
                        </td>
                             <td ><?php  echo date('Y-m-d H:i:s', $row['createtime'])?></td>
                        <td>
                            <?php  if(!empty($row['openid'])) { ?>
                          <a class='btn btn-default'  href="<?php  echo $this->createWebUrl('shop/comment', array('op' => 'post', 'id' => $row['id']))?>" title='进行回复'><i class="fa fa-reply"></i></a>
                           <?php  } else { ?>
                        <a class='btn btn-default'  href="<?php  echo $this->createWebUrl('shop/comment', array('op' => 'add', 'id' => $row['id']))?>" title='修改评价'><i class="fa fa-edit"></i></a>
                           <?php  } ?>
                           
                          <a class='btn btn-default'  href="<?php  echo $this->createWebUrl('shop/comment', array('op' => 'add', 'goodsid' => $row['goodsid']))?>" title='添加此商品评价'><i class="fa fa-plus"></i></a>
                           <a class='btn btn-default'  href="<?php  echo $this->createWebUrl('shop/comment', array('op' => 'delete', 'id' => $row['id']))?>" onclick="return confirm('确认删除此评价吗？');return false;"><i class="fa fa-remove"></i></a>
                        </td>
                    </tr>
                    <?php  } } ?>
                       <?php  } else { ?>
								<tr>
							<td colspan='8'>
                              <div  style='text-align: center;padding:30px;'>
                                  暂时没有评价!
                              </div>	</td>
						</tr>
                          <?php  } ?>
                </tbody>
            </table>
            <?php  echo $pager;?>
 
        </div>
     
    </div>
</form>



<?php  } ?>
<?php include page("footer-base");?>
 