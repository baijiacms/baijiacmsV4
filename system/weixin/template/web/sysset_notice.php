<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<form id="setform"  action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
	   <input type='hidden' name='setid' value="<?php  echo $set['id'];?>" />
        <input type='hidden' name='op' value="notice" />
    <div class='panel'>
    
	 <h3 class="custom_page_header"> 提醒及模板消息设置</h3>
        <div class='panel-body'>
      <style type='text/css'>
                .multi-item { height:110px;}
                .img-thumbnail { width:100px;height:100px}
                .img-nickname { position: absolute;bottom:0px;line-height:25px;height:25px;
                                color:#fff;text-align:center;width:90px;bottom:55px;background:rgba(0,0,0,0.8);left:5px;}
                .multi-img-details { padding:5px;}
            </style>
            <div class='panel-body'>
                <div class='alert alert-info'>
                    请将公众平台模板消息所在行业选择为： IT科技/互联网|电子商务
                </div>
            </div>
            
            
             <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单生成通知</label>
                    <div class="col-sm-9 col-xs-12">
                
                        <input type="text" name="notice_new" class="form-control" value="<?php  echo $set['notice_new'];?>" />
                        <div class="help-block">通知公众平台模板消息编号: OPENTM205213550 </div>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                     

                        <div class='input-group'>
                            <input type="text" id='salers' name="salers" maxlength="30" value="<?php  if(is_array($salers)) { foreach($salers as $saler) { ?> <?php  echo $saler['nickname'];?>; <?php  } } ?>" class="form-control" readonly />
                            <div class='input-group-btn'>
                                <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus').modal();">选择通知人</button>
                            </div>
                        </div>
                        <div class="input-group multi-img-details" id='saler_container'>
                            <?php  if(!empty($salers)&&is_array($salers)) { foreach($salers as $saler) { ?>
                            <div class="multi-item saler-item" openid='<?php  echo $saler['openid'];?>'>
                                 <img class="img-responsive img-thumbnail" src='<?php  echo $saler['avatar'];?>' onerror="this.src='./resource/images/nopic.jpg'; this.title='图片未找到.'">
                                 <div class='img-nickname'><?php  echo $saler['nickname'];?></div>
                                <input type="hidden" value="<?php  echo $saler['openid'];?>" name="openids[]">
                                <em onclick="remove_member(this)"  class="close">×</em>
                            </div>
                            <?php  } } ?>
                        </div>
                        <span class='help-block'>订单生成后商家通知，可以制定多个人，如果不填写则不通知</span>
                        <div id="modal-module-menus"  class="modal fade" tabindex="-1">
                            <div class="modal-dialog" style='width: 920px;'>
                                <div class="modal-content">
                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择通知人</h3></div>
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

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">通知方式</label>
                    <div class="col-sm-9 col-xs-12">
                
                        <label class="checkbox-inline">
                            <input type="checkbox" value="1" name='notice_newtype[]' <?php  if(in_array(1,$newtype)) { ?>checked<?php  } ?> /> 下单通知
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="2" name='notice_newtype[]' <?php  if(in_array(2,$newtype)) { ?>checked<?php  } ?> /> 付款通知
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" value="3" name='notice_newtype[]' <?php  if(in_array(3,$newtype)) { ?>checked<?php  } ?> /> 买家确认收货通知
                        </label>
                        <div class="help-block">通知商家方式</div>
                      
                    </div>
                </div>

            </div>
          
           <h3 class="custom_page_header">买家通知 </h3>
            <div class='panel-body'>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单提交成功通知</label>
                    <div class="col-sm-9 col-xs-12">
                    
                        <input type="text" name="notice_submit" class="form-control" value="<?php  echo $set['notice_submit'];?>" />
                        <div class="help-block">公众平台模板消息编号: OPENTM200746866 </div>
                    
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">自提订单提交成功通知</label>
                    <div class="col-sm-9 col-xs-12">
                    
                        <input type="text" name="notice_carrier" class="form-control" value="<?php  echo $set['notice_carrier'];?>" />
                        <div class="help-block">公众平台模板消息编号:  OPENTM201594720  </div>
                        
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单取消通知</label>
                    <div class="col-sm-9 col-xs-12">
                    
                        <input type="text" name="notice_cancel" class="form-control" value="<?php  echo $set['notice_cancel'];?>" />
                        <div class="help-block">公众平台模板消息编号: TM00850 </div>
                    
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单支付成功通知</label>
                    <div class="col-sm-9 col-xs-12">
                     
                        <input type="text" name="notice_pay" class="form-control" value="<?php  echo $set['notice_pay'];?>" />
                        <div class="help-block">公众平台模板消息编号:  OPENTM204987032  </div>
                    
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单发货通知</label>
                    <div class="col-sm-9 col-xs-12">
                    
                        <input type="text" name="notice_send" class="form-control" value="<?php  echo $set['notice_send'];?>" />
                        <div class="help-block">公众平台模板消息编号:  OPENTM202243318  </div>
                    
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">订单确认收货通知</label>
                    <div class="col-sm-9 col-xs-12">
                     
                        <input type="text" name="notice_finish" class="form-control" value="<?php  echo $set['notice_finish'];?>" />
                        <div class="help-block">公众平台模板消息编号:  OPENTM202314085  </div>
                       
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">退款申请通知</label>
                    <div class="col-sm-9 col-xs-12">
                   
                        <input type="text" name="notice_refund" class="form-control" value="<?php  echo $set['notice_refund'];?>" />
                        <div class="help-block">公众平台模板消息编号:  TM00431  </div>
                     
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">退款成功通知</label>
                    <div class="col-sm-9 col-xs-12">
                       
                        <input type="text" name="notice_refund1" class="form-control" value="<?php  echo $set['notice_refund1'];?>" />
                        <div class="help-block">公众平台模板消息编号:  TM00430  </div>
                     
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">退款申请驳回通知</label>
                    <div class="col-sm-9 col-xs-12">
                   
                        <input type="text" name="notice_refund2" class="form-control" value="<?php  echo $set['notice_refund2'];?>" />
                        <div class="help-block">公众平台模板消息编号:  TM00432  </div>
                      
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员升级通知(任务处理通知)</label>
                    <div class="col-sm-9 col-xs-12">
                      
                        <input type="text" name="notice_upgrade" class="form-control" value="<?php  echo $set['notice_upgrade'];?>" />
                        <div class="help-block">请搜索“任务处理通知”公众平台模板消息编号:  OPENTM200605630  </div>
                      
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">充值成功通知</label>
                    <div class="col-sm-9 col-xs-12">
                      
                        <input type="text" name="notice_recharge_ok" class="form-control" value="<?php  echo $set['notice_recharge_ok'];?>" />
                        <div class="help-block">公众平台模板消息编号:  TM00977</div>
                     
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">充值退款通知</label>
                    <div class="col-sm-9 col-xs-12">
                     
                        <input type="text" name="notice_recharge_refund" class="form-control" value="<?php  echo $set['notice_recharge_refund'];?>" />
                        <div class="help-block">搜索“退款通知”，公众平台模板消息编号:  TM00004</div>
                       
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">提现提交通知</label>
                    <div class="col-sm-9 col-xs-12">
                      
                        <input type="text" name="notice_withdraw" class="form-control" value="<?php  echo $set['notice_withdraw'];?>" />
                        <div class="help-block">公众平台模板消息编号:  TM00979  </div>
                     
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">提现成功通知</label>
                    <div class="col-sm-9 col-xs-12">
                     
                        <input type="text" name="notice_withdraw_ok" class="form-control" value="<?php  echo $set['notice_withdraw_ok'];?>" />
                        <div class="help-block">公众平台模板消息编号:  TM00980  </div>
                     
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">提现失败通知</label>
                    <div class="col-sm-9 col-xs-12">
                      
                        <input type="text" name="notice_withdraw_fail" class="form-control" value="<?php  echo $set['notice_withdraw_fail'];?>" />
                        <div class="help-block">公众平台模板消息编号:  TM00981  </div>
                    
                    </div>
                </div>
                
            <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                         
                            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"  />
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                      
                     </div>
            </div>
                       
                       
            <script language='javascript'>
                function search_members() {
                    if ($.trim($('#search-kwd').val()) == '') {
                        Tip.focus('#search-kwd', '请输入关键词');
                        return;
                    }
                    $("#module-menus").html("正在搜索....");
                    $.get('<?php  echo create_url('site',array('act' => 'query','do' => 'member','m' => 'eshop'))?>', { 
                        keyword: $.trim($('#search-kwd').val())
                    }, function (dat) {
                        $('#module-menus').html(dat);
                    });
                }
                function select_member(o) {

                    if ($('.multi-item[openid="' + o.openid + '"]').length > 0) {
                        return;
                    }
                    var html = '<div class="multi-item" openid="' + o.openid + '">';
                    html += '<img class="img-responsive img-thumbnail" src="' + o.avatar + '" onerror="this.src=\'./resource/images/nopic.jpg\'; this.title=\'图片未找到.\'">';
                    html += '<div class="img-nickname">' + o.nickname + '</div>';
                    html += '<input type="hidden" value="' + o.openid + '" name="openids[]">';
                    html += '<em onclick="remove_member(this)"  class="close">×</em>';
                    html += '</div>';
                    $("#saler_container").append(html);
                    refresh_members();
                }

                function remove_member(obj) {
                    $(obj).parent().remove();
                    refresh_members();
                }
                function refresh_members() {
                    var nickname = "";
                    $('.multi-item').each(function () {
                        nickname += " " + $(this).find('.img-nickname').html() + "; ";
                    });
                    $('#salers').val(nickname);
                }

            </script>
				
				
				
            
        </div>
        </div>
</form>
<?php include page("footer-base");?>