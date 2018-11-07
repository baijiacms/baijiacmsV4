<?php defined('IN_IA') or exit('Access Denied');?>
<?php if(false){?>
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">购买强制关注</label>
    <div class="col-sm-6 col-xs-6">
   
        <label class="radio-inline"><input type="radio" name="needfollow" value="0" <?php  if(empty($item['needfollow']) ) { ?>checked="true"<?php  } ?>  /> 不需关注</label>
        <label class="radio-inline"><input type="radio" name="needfollow" value="1" <?php  if($item['needfollow'] == 1) { ?>checked="true"<?php  } ?>   /> 必须关注</label>
       
    </div>
</div>   
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">未关注提示</label>
    <div class="col-sm-6 col-xs-6">

            <input type='text' class="form-control" name='followtip' value='<?php  echo $item['followtip'];?>' />
           <span  class='help-block'>购买商品必须关注，如果未关注，弹出的提示，如果为空默认为“如果您想要购买此商品，需要您关注我们的公众号，点击【确定】关注后再来购买吧~”</span>
          
    </div>
</div>    

<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">关注引导</label>
    <div class="col-sm-6 col-xs-6">

            <input type='text' class="form-control" name='followurl' value='<?php  echo $item['followurl'];?>' />
           <span  class='help-block'>购买商品必须关注，如果未关注，跳转的连接，如果为空默认为系统关注页</span>
       
    </div>
</div>    
<?php }?>
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享标题</label>
    <div class="col-sm-9 col-xs-12">

        <input type="text" name="share_title" id="share_title" class="form-control" value="<?php  echo $item['share_title'];?>" />
        <span class='help-block'>如果不填写，默认为商品名称</span>
   
    </div>
</div>
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享图标</label>
    <div class="col-sm-9 col-xs-12">

        <?php  echo tpl_form_field_image('share_icon', $item['share_icon'])?>
        <span class='help-block'>如果不选择，默认为商品缩略图片</span>
    
    </div>
</div>
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享描述</label>
    <div class="col-sm-9 col-xs-12">
            
        <textarea name="description" class="form-control" ><?php  echo $item['description'];?></textarea>
        <span class='help-block'>如果不填写，默认为店铺名称</span>
        
    </div>
</div>