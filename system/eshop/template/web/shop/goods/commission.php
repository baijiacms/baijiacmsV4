<?php defined('IN_IA') or exit('Access Denied');?><script language="javascript">
    $(function() {
        $("#hascommission").click(function() {
            var obj = $(this);
            if (obj.get(0).checked) {
                $("#commission_div").show();
            } else {
                $("#commission_div").hide();
            }
        });
    })
</script>
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否参与分销</label>
    <div class="col-sm-9 col-xs-12">
     
       <label class="radio-inline">
            <input type="radio"  value="0" name="nocommission" <?php  if($item['nocommission']==0) { ?>checked<?php  } ?> /> 参与分销
        </label>
        <label class="radio-inline">
            <input type="radio"  value="1" name="nocommission" <?php  if($item['nocommission']==1) { ?>checked<?php  } ?> /> 不参与分销
        </label>
        <span class="help-block">如果不参与分销，则不产生分销佣金</span>
      
    </div>
</div>
<?php if(false){?>
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">显示"我要分销"按钮</label>
    <div class="col-sm-9 col-xs-12">
        
       <label class="radio-inline">
            <input type="radio"  value="0" name="hidecommission" <?php  if($item['hidecommission']==0) { ?>checked<?php  } ?> /> 显示
        </label>
        <label class="radio-inline">
            <input type="radio"  value="1" name="hidecommission" <?php  if($item['hidecommission']==1) { ?>checked<?php  } ?> /> 隐藏
        </label>
        <span class="help-block">如果隐藏了按钮，在参与分销的情况下，按钮只是隐藏，分享其他人购买后依然产生分销佣金</span>
      
    </div>
</div>
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">海报图片</label>
    <div class="col-sm-9 col-xs-12">
     
        <?php  echo tpl_form_field_image('commission_thumb', $item['commission_thumb'])?>
        <span class='help-block'>尺寸: 640*640，如果为空默认缩略图片</span>
    
    </div>
</div>
<?php }?>
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">独立规则</label>
    <div class="col-sm-9 col-xs-12">
   
       <label class="checkbox-inline">
        <input type="checkbox" id="hascommission" value="1" name="hascommission" <?php  if($item['hascommission']==1) { ?>checked<?php  } ?> />启用独立佣金比例
    </label>
        <span class="help-block">启用独立佣金设置，此商品拥有独自的佣金比例,不受分销商等级比例及默认设置限制</span>
        
    </div>
</div>
 
<div id="commission_div" <?php  if(empty($item['hascommission'])) { ?>style="display:none"<?php  } ?> >
   
     <div class='alert alert-danger'>
        如果比例为空，则使用固定规则，如果都为空则无分销佣金
    </div>
    <?php  if($com_set['level']>=1) { ?>
    <div class="form-group">
        <label class="col-xs-12 col-sm-3 col-md-2 control-label">一级分销</label>
        <div class="col-sm-4 col-xs-12">
                 
            <div class="input-group">
                <input type="text" name="commission1_rate" id="commission1_rate" class="form-control" value="<?php  echo $item['commission1_rate'];?>" />
                <div class="input-group-addon">% 固定</div>
                 <input type="text" name="commission1_pay" id="commission1_pay" class="form-control" value="<?php  echo $item['commission1_pay'];?>" />
                <div class="input-group-addon">元</div>
            </div>
                 
        </div>
    </div>
    <?php  } ?>
     <?php  if($com_set['level']>=2) { ?>
    <div class="form-group">
        <label class="col-xs-12 col-sm-3 col-md-2 control-label">二级分销</label>
        <div class="col-sm-4 col-xs-12">
             
            <div class="input-group">
                <input type="text" name="commission2_rate" id="commission2_rate" class="form-control" value="<?php  echo $item['commission2_rate'];?>" />
                <div class="input-group-addon">% 固定</div>
                <input type="text" name="commission2_pay" id="commission2_pay" class="form-control" value="<?php  echo $item['commission2_pay'];?>" />
                <div class="input-group-addon">元</div>
            </div>
              
        </div>
    </div>
     <?php  } ?>
      <?php  if($com_set['level']>=3) { ?>
    <div class="form-group">
        <label class="col-xs-12 col-sm-3 col-md-2 control-label">三级分销</label>
        <div class="col-sm-4 col-xs-12">
            
            <div class="input-group">
               <input type="text" name="commission3_rate" id="commission3_rate" class="form-control" value="<?php  echo $item['commission3_rate'];?>" />
                <div class="input-group-addon">% 固定</div>
                <input type="text" name="commission3_pay" id="commission3_pay" class="form-control" value="<?php  echo $item['commission3_pay'];?>" />
                <div class="input-group-addon">元</div>
            </div>
                 
        </div>
    </div>
      <?php  } ?>
</div>