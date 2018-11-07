<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<?php  if($operation == 'post') { ?>
<div class="main">
    <form  action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
        <div class='panel '>
        	<h3 class="custom_page_header">核销员设置 </h3>
            <div class='panel-body'>
               
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 选择核销员</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type='hidden' id='openid' name='openid' value="<?php  echo $item['openid'];?>" />
                        <div class='input-group'>
                            <input type="text" name="saler" maxlength="30" value="<?php  if(!empty($saler)) { ?><?php  echo $saler['nickname'];?>/<?php  echo $saler['realname'];?>/<?php  echo $saler['mobile'];?><?php  } ?>" id="saler" class="form-control" readonly />
                            <div class='input-group-btn'>
                                <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus').modal();">选择核销员</button>
                            </div>
                        </div>
                        <?php  if(!empty($saler)) { ?>
                        <span class='help-block'><img  style="width:100px;height:100px;border:1px solid #ccc;padding:1px" src="<?php  echo $saler['avatar'];?>" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'"/></span>
                        <?php  } ?>
                        
                        <div id="modal-module-menus"  class="modal fade" tabindex="-1">
                            <div class="modal-dialog" style='width: 920px;'>
                                <div class="modal-content">
                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择核销员</h3></div>
                                    <div class="modal-body" >
                                        <div class="row">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="keyword" value="" id="search-kwd" placeholder="请输入粉丝昵称/姓名/手机号" />
                                                <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_members();">搜索</button></span>
                                            </div>
                                        </div>
                                        <div id="module-menus" style="padding-top:5px;"></div>
                                    </div>
                                    <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                </div>

                            </div>
                        </div>
                      
                    </div>
                </div>
				
				   <div class='panel-body'>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 核销员姓名</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="salername" class="form-control" value="<?php  echo $item['salername'];?>" />
                     
                    </div>
                </div>
					   
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">所属门店</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type='hidden' id='storeid' name='storeid' value="<?php  echo $store['id'];?>" />
                        <div class='input-group'>
                            <input type="text" name="store" maxlength="30" value="<?php  echo $store['storename'];?>" id="store" class="form-control" readonly />
                            <div class='input-group-btn'>
                                <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus1').modal();">选择门店</button>
                                <button class="btn btn-danger" type="button" onclick="$('#storeid').val('');$('#store').val('');">清除选择</button>
                            </div>
                        </div>
                        <span class='help-block'>如果不选择门店，则此核销员为全局核销员，所有门店的均可核销</span>
                        <div id="modal-module-menus1"  class="modal fade" tabindex="-1">
                            <div class="modal-dialog" style='width: 920px;'>
                                <div class="modal-content">
                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择门店</h3></div>
                                    <div class="modal-body" >
                                        <div class="row">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="keyword" value="" id="search-kwd1" placeholder="请输入门店名称" />
                                                <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_stores();">搜索</button></span>
                                            </div>
                                        </div>
                                        <div id="module-menus1" style="padding-top:5px;"></div>
                                    </div>
                                    <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                </div>

                            </div>
                        </div>
                     
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
                    <div class="col-sm-9 col-xs-12">
                        <label class='radio-inline'>
                            <input type='radio' name='status' value=1' <?php  if($item['status']==1) { ?>checked<?php  } ?> /> 启用
                        </label>
                        <label class='radio-inline'>
                            <input type='radio' name='status' value=0' <?php  if($item['status']==0) { ?>checked<?php  } ?> /> 禁用
                        </label>
                         
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
 
    $('form').submit(function () {
		
        if ($(':input[name=saler]').isEmpty()) {
            Tip.focus($(':input[name=saler]'), '请选择核销员!');
            return false;
        }
		  if ($(':input[name=salername]').isEmpty()) {
            Tip.focus($(':input[name=salername]'), '请输入核销员姓名!');
            return false;
        }
        return true;
    })
</script>
<?php  } else if($operation == 'display') { ?>
<form action="" method="post" onsubmit="return formcheck(this)">
    <div class='panel'>
      
               	<h3 class="custom_page_header">核销员管理    <a class='btn btn-default' href="<?php  echo $this->createWebUrl('verify/saler', array('op' => 'post'))?>"><i class="fa fa-plus"></i> 添加新核销员</a>
        </h3>
        <div class='panel-body'>

            <table class="table">
                <thead>
                    <tr>
                        <th>核销员</th>
						<th>姓名</th>
                        <th>所属门店</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  if(is_array($list)) { foreach($list as $row) { ?>
                    <tr>
                        <td><img src='<?php  echo $row['avatar'];?>' onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" style='width:30px;height:30px;padding1px;border:1px solid #ccc' /> <?php  echo $row['nickname'];?></td>
						<td><?php  echo $row['salername'];?></td>
                        <td><?php  if(empty($row['storename'])) { ?>全店核销<?php  } else { ?><?php  echo $row['storename'];?><?php  } ?></td>
						
                        <td>
                            <?php  if($row['status']==1) { ?>
                            <span class='label label-success'>启用</span>
                            <?php  } else { ?>
                            <span class='label label-danger'>禁用</span>
                            <?php  } ?>
                        </td>
                        <td>
                           <a class='btn btn-default' href="<?php  echo $this->createWebUrl('verify/saler', array('op' => 'post', 'id' => $row['id']))?>"><i class='fa fa-edit'></i></a>
                            <a class='btn btn-default'  href="<?php  echo $this->createWebUrl('verify/saler', array('op' => 'delete', 'id' => $row['id']))?>" onclick="return confirm('确认删除此核销员吗？');
                                    return false;"><i class='fa fa-remove'></i></a>
                           </td>
                    </tr>
                    <?php  } } ?>

                </tbody>
            </table>

        </div>

     

    </div>
</form>



<?php  } ?>
<script language='javascript'>
     function search_members() {
           if( $.trim($('#search-kwd').val())==''){
                 Tip.focus('#search-kwd','请输入关键词');
                 return;
             }
		$("#module-menus").html("正在搜索....")
		$.get('<?php  echo $this->createWebUrl('member/query')?>', {
			keyword: $.trim($('#search-kwd').val())
		}, function(dat){
			$('#module-menus').html(dat);
		});
	}
	function select_member(o) {
		$("#openid").val(o.openid);
		$("#saler").val( o.nickname+ "/" + o.realname + "/" + o.mobile );
		$(".close").click();
	}
        
    function search_stores() {
		$("#module-menus1").html("正在搜索....")
		$.get('<?php  echo $this->createWebUrl('verify/store',array('op'=>'query'));?>', {
			keyword: $.trim($('#search-kwd1').val())
		}, function(dat){
			$('#module-menus1').html(dat);
		});
	}
	function select_store(o) {
		$("#storeid").val(o.id);
		$("#store").val( o.storename );
		$(".close").click();
	}
    </script>
<?php include page("footer-base");?>