<?php defined('IN_IA') or exit('Access Denied');?>
<div class="spec_item_item" style="float:left;margin:0 5px 10px 0;width:250px;">
	<input type="hidden" class="form-control spec_item_show" name="spec_item_show_<?php  echo $spec['id'];?>[]" VALUE="<?php  echo $specitem['show'];?>" />
	<input type="hidden" class="form-control spec_item_id" name="spec_item_id_<?php  echo $spec['id'];?>[]" VALUE="<?php  echo $specitem['id'];?>" />
	<div class="input-group"  style="margin:10px 0;">
		<span class="input-group-addon">
			<label class="checkbox-inline" style="margin-top:-20px;">
				<input type="checkbox" <?php  if($specitem['show']==1) { ?>checked<?php  } ?> value="1" onclick='showItem(this)'>
			</label>
		</span>
		<input type="text" class="form-control spec_item_title error" name="spec_item_title_<?php  echo $spec['id'];?>[]" VALUE="<?php  echo $specitem['title'];?>" />
		<span class="input-group-addon">
			<a href="javascript:;" onclick="removeSpecItem(this)" title='删除'><i class="fa fa-times"></i></a>
	  		<a href="javascript:;" class="fa fa-arrows" title="拖动调整显示顺序" ></a>
		</span>
	</div>
  
                         <div class="input-group choosetemp" style='margin-bottom: 10px;<?php  if($item['type']!=3) { ?>display:none<?php  } ?>'> 
                        <input type="hidden" name="spec_item_virtual_<?php  echo $spec['id'];?>[]" value="<?php  echo $specitem['virtual'];?>" class="form-control spec_item_virtual"  id="temp_id_<?php  echo $specitem['id'];?>">
                        <input type="text" name="spec_item_virtualname_<?php  echo $spec['id'];?>[]" value="<?php  if(empty($specitem['virtual'])) { ?>未选择<?php  } else { ?><?php  echo $specitem['title2'];?><?php  } ?>" class="form-control spec_item_virtualname" readonly="" id="temp_name_<?php  echo $specitem['id'];?>">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="choosetemp('<?php  echo $specitem['id'];?>')">选择虚拟物品</button>
                        </div>
                    </div>
  
	<div>
		<?php  echo tpl_form_field_image('spec_item_thumb_'.$spec['id']."[]",$specitem['thumb'])?>
	</div>
</div>


