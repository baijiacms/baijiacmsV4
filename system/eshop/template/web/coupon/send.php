<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>


<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">


    <div class='panel panel-default'>
   
	<h3 class="custom_page_header"> 发放优惠券	</h3>
    		            
             
        <div class='panel-body'>

            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 选择优惠券</label>
                <div class="col-sm-5">
                    <input type='hidden' id='couponid' name='couponid' value="<?php  echo $coupon['id'];?>"/>
                    <div class='input-group'>
                        <input type="text" name="coupon" maxlength="30" id="coupon" class="form-control" readonly value="<?php  if(!empty($coupon)) { ?>[<?php  echo $coupon['id'];?>]<?php  echo $coupon['couponname'];?><?php  } ?>" />
                        <div class='input-group-btn'>
                            <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus').modal();">选择优惠券</button>
                        </div>


                        <div id="modal-module-menus"  class="modal fade" tabindex="-1">
                            <div class="modal-dialog" style='width: 920px;'>
                                <div class="modal-content">
                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择优惠券</h3></div>
                                    <div class="modal-body" >
                                        <div class="row">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="keyword" value="" id="search-kwd" placeholder="请输入优惠券名称" />
                                                <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_coupons();">搜索</button></span>
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
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">每人发送张数</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" id="send_total" name="send_total" class="form-control" value="1"  />
		  <span class='help-block'>此处受总数限制，如果剩余张数不足以发放给选定会员数量，则无法发放</span>
                </div>
            </div>			
		</div>
			
	 <div class='panel-heading'>
            发送对象
        </div>

        <div class='panel-body'>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label" >发送类型</label>
                <div class="col-sm-9 col-xs-12">
                    <label class="radio-inline"><input type="radio" name="send1" value="1"  checked /> 按openid发送</label>
                    <label class="radio-inline"><input type="radio" name="send1" value="2"    /> 按用户等级发送</label>
                    <label class="radio-inline"><input type="radio" name="send1" value="3"  /> 按用户分组等级发送</label>
                    <?php  if(p('commission')) { ?>
                    <label class="radio-inline"><input type="radio" name="send1" value="5"  /> 按分销商等级发送</label>
                    <?php  } ?>
                    <label class="radio-inline"><input type="radio" name="send1" value="4" />全部发送</label>
                </div>
            </div>
            <div class="form-group choose choose_1">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label" >会员openid</label>
                <div class="col-sm-9 col-xs-12">
                    <textarea name="send_openid" class="form-control" style="height:250px;" placeholder="请用半角逗号隔开OPENID, 如 aaa,bbb" id="value_1"></textarea>
                </div>
            </div>

            <div class="form-group choose choose_2" style='display: none' >
                <label class="col-xs-12 col-sm-3 col-md-2 control-label" >选择会员等级</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <select name="send_level" class="form-control" id="value_2" >
                        <option value="">全部</option>
                        <option value="0">普通等级</option>
                        <?php  if(is_array($list)) { foreach($list as $type) { ?>
                        <option value="<?php  echo $type['id'];?>"><?php  echo $type['levelname'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
            </div>
            <div class="form-group choose choose_3" style='display:none '>
                <label class="col-xs-12 col-sm-3 col-md-2 control-label" >选择会员分组</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <select name="send_group" class="form-control"  id="value_3">
                        <option value="">全部</option>
                        <option value="0">无分组</option>
                        <?php  if(is_array($list2)) { foreach($list2 as $type2) { ?>
                        <option value="<?php  echo $type2['id'];?>"><?php  echo $type2['groupname'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
            </div>
            <?php  if(p('commission')) { ?>
            <div class="form-group choose choose_5" style='display:none '>
                <label class="col-xs-12 col-sm-3 col-md-2 control-label" >选择分销商等级</label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                    <select name="send_agentlevel" class="form-control"  id="value_5">
                        <option value="">全部</option>
                        <option value="0">普通等级</option>
                        <?php  if(is_array($list3)) { foreach($list3 as $type3) { ?>
                        <option value="<?php  echo $type3['id'];?>"><?php  echo $type3['levelname'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
            </div>
            <?php  } ?>
            
             <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label" ></label>
                <div class="col-sm-9 col-xs-12">
                    <div class="help-block">       
                        <input type="submit" name="submit" value="确认发放" class="btn btn-primary col-lg-4"/>
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" /></div>
                </div>
            </div>
		</div>
			


    
        </div>
</form>


<script>
    function search_coupons() {

        $("#module-menus").html("正在搜索....")
        $.get('<?php  echo $this->createWebUrl('coupon/coupon',array('op'=>'query'))?>', {
            keyword: $.trim($('#search-kwd').val())
        }, function (dat) {
            $('#module-menus').html(dat);
        });
    }
    function select_coupon(o) {
        $("#couponid").val(o.id);
        $("#coupon").val('[' + o.id + "]" + o.couponname);
        $(".close").click();
    }

    $(function () {
        $(':radio[name=send1]').click(function () {
            var v = $(this).val();
            $(".choose").hide();
            $(".choose_" + v).show();
        })

        $('form').submit(function () {
            var couponid = $('#couponid').val();
            if (couponid == '') {
                Tip.show($('#coupon'), '请选择要发放的优惠券!');
                return false;
            }
            var send_total = $('#send_total').val();
            if (!$.isInt(send_total)) {
                Tip.select($('#send_total'), '请输入整数发放数量!');
                return false;
            }
            send_total = parseInt(send_total);
            if (send_total <= 0) {
                Tip.select($('#send_total'), '最少发放一张!');
                return false;
            }
            var c = $('input[name=send1]:checked').val();
            var v = $('#value_' + c).val();
            if (c == 1 && v == '') {
                alert('请输入要发放的用户Openid!');
                return false;
            }
            return true;
        });
    });
</script>				
<?php include page("footer-base");?>