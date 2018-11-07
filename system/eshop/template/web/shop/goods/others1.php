<?php defined('IN_IA') or exit('Access Denied');?>

<div class="form-group notice">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商家通知</label>
                    <div class="col-sm-4">
                        
                        
                         
                            
                        <input type='hidden' id='noticeopenid' name='noticeopenid' value="<?php  echo $item['noticeopenid'];?>" />
                        <div class='input-group'>
                            <input type="text" name="saler" maxlength="30" value="<?php  if(!empty($saler)) { ?><?php  echo $saler['nickname'];?>/<?php  echo $saler['realname'];?>/<?php  echo $saler['mobile'];?><?php  } ?>" id="saler" class="form-control" readonly />
                            <div class='input-group-btn'>
                                <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus-notice').modal();">选择通知人</button>
                                <button class="btn btn-danger" type="button" onclick="$('#noticeopenid').val('');$('#saler').val('');$('#saleravatar').hide()">清除选择</button>
                            </div> 
                        </div>
                        <span id="saleravatar" class='help-block' <?php  if(empty($saler)) { ?>style="display:none"<?php  } ?>><img  style="width:100px;height:100px;border:1px solid #ccc;padding:1px" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" src="<?php  echo $saler['avatar'];?>"/></span>
                        <span class="help-block">单品下单通知，可制定某个用户，通知商品下单备货通知,如果商品为同一商家，建议使用系统统一设置</span>
                        
                        <div id="modal-module-menus-notice"  class="modal fade" tabindex="-1">
                            <div class="modal-dialog" style='width: 920px;'>
                                <div class="modal-content">
                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择通知人</h3></div>
                                    <div class="modal-body" >
                                        <div class="row">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="keyword" value="" id="search-kwd-notice" placeholder="请输入粉丝昵称/姓名/手机号" />
                                                <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_members();">搜索</button></span>
                                            </div>
                                        </div>
                                        <div id="module-menus-notice" style="padding-top:5px;"></div>
                                    </div>
                                    <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                </div>

                            </div>
                        </div>
                  
                    </div>
                </div>
 <div class="form-group">
        <label class="col-xs-12 col-sm-3 col-md-2 control-label">通知方式</label>
        <div class="col-sm-9 col-xs-12">
            
                        
            <label class="checkbox-inline">
                <input type="checkbox" value="0" name='noticetype[]' <?php  if(!empty($noticetype)&&in_array(0,$noticetype)) { ?>checked<?php  } ?> /> 下单通知
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" value="1" name='noticetype[]' <?php  if(!empty($noticetype)&&in_array(1,$noticetype)) { ?>checked<?php  } ?> /> 付款通知
            </label>
             <label class="checkbox-inline">
                <input type="checkbox" value="2" name='noticetype[]' <?php  if(!empty($noticetype)&&in_array(2,$noticetype)) { ?>checked<?php  } ?> /> 买家收货通知
            </label>
            <div class="help-block">通知商家方式</div>
      
        </div>
    </div>

<script language='javascript'>
   
         function search_members() {
             if( $.trim($('#search-kwd-notice').val())==''){
                 Tip.focus('#search-kwd-notice','请输入关键词');
                 return;
             }
		$("#module-menus-notice").html("正在搜索....")
		$.get('<?php  echo $this->createWebUrl('member/query')?>', {
			keyword: $.trim($('#search-kwd-notice').val())
		}, function(dat){
			$('#module-menus-notice').html(dat);
		});
	}
	function select_member(o) {
		$("#noticeopenid").val(o.openid);
                                $("#saleravatar").show();
                                 $("#saleravatar").find('img').attr('src',o.avatar);
		$("#saler").val( o.nickname+ "/" + o.realname + "/" + o.mobile );
		$("#modal-module-menus-notice .close").click();
	}
        
    </script>
