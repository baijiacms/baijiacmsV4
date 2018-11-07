<?php defined('IN_IA') or exit('Access Denied');?>
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员等级浏览权限</label>
    <div class="col-sm-9 col-xs-12 chks">
    
       <label class="checkbox-inline">
           <input type="checkbox" class='chkall' name="showlevels" value="" <?php  if($item['showlevels']=='') { ?>checked="true"<?php  } ?>  /> 全部会员等级
       </label>
       <label class="checkbox-inline">
           <input type="checkbox" class='chksingle' name="showlevels[]" value="0" <?php  if($item['showlevels']!='' && is_array($item['showlevels']) && in_array('0', $item['showlevels'])) { ?> checked="true"<?php  } ?>  />  <?php echo empty($shop['levelname'])?'普通等级':$shop['levelname']?>
       </label>
       <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
          <label class="checkbox-inline">
           <input type="checkbox" class='chksingle' name="showlevels[]" value="<?php  echo $level['id'];?>" <?php  if($item['showlevels']!='' && is_array($item['showlevels'])  && in_array($level['id'], $item['showlevels'])) { ?>checked="true"<?php  } ?>  /> <?php  echo $level['levelname'];?>
          </label>
       <?php  } } ?>
     
    </div>
</div>   
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员等级购买权限</label>
    <div class="col-sm-9 col-xs-12 chks" >
         
              
       <label class="checkbox-inline">
           <input type="checkbox" class='chkall' name="buylevels" value="" <?php  if($item['buylevels']=='' ) { ?>checked="true"<?php  } ?>  /> 全部会员等级
       </label>
       <label class="checkbox-inline">
           <input type="checkbox" class='chksingle'  name="buylevels[]" value="0" <?php  if($item['buylevels']!='' && is_array($item['buylevels'])  && in_array('0', $item['buylevels'])) { ?>checked="true"<?php  } ?>  />  <?php echo empty($shop['levelname'])?'普通等级':$shop['levelname']?>
       </label>
       <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
          <label class="checkbox-inline">
           <input type="checkbox" class='chksingle'  name="buylevels[]" value="<?php  echo $level['id'];?>" <?php  if($item['buylevels']!='' && is_array($item['buylevels']) && in_array($level['id'], $item['buylevels']) ) { ?>checked="true"<?php  } ?>  /> <?php  echo $level['levelname'];?>
          </label>
       <?php  } } ?>
           
       
       
    </div>
</div>   
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员组浏览权限</label>
    <div class="col-sm-9 col-xs-12 chks" >
       
       <label class="checkbox-inline">
           <input type="checkbox" class='chkall' name="showgroups" value="" <?php  if($item['showgroups']=='' ) { ?>checked="true"<?php  } ?>  /> 全部会员组
       </label>
       <label class="checkbox-inline">
           <input type="checkbox" class='chksingle'  name="showgroups[]" value="0" <?php  if($item['showgroups']!='' && is_array($item['showgroups']) && in_array('0', $item['showgroups'])) { ?>checked="true"<?php  } ?>  /> 无分组
       </label>
       <?php  if(is_array($groups)) { foreach($groups as $group) { ?>
          <label class="checkbox-inline">
           <input type="checkbox" class='chksingle'  name="showgroups[]" value="<?php  echo $group['id'];?>" <?php  if($item['showgroups']!=''  && in_array($group['id'], $item['showgroups']) && is_array($item['showgroups'])) { ?>checked="true"<?php  } ?>  /> <?php  echo $group['groupname'];?>
          </label>
       <?php  } } ?>
       
        
       
    </div>
</div>   

<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员组购买权限</label>
    <div class="col-sm-9 col-xs-12 chks" >
         
       <label class="checkbox-inline">
           <input type="checkbox" class='chkall' name="buygroups" value="" <?php  if($item['buygroups']=='' ) { ?>checked="true"<?php  } ?>  /> 全部会员组
       </label>
       <label class="checkbox-inline">
           <input type="checkbox" class='chksingle'  name="buygroups[]" value="0" <?php  if($item['buygroups']!=''  && is_array($item['buygroups']) && in_array('0', $item['buygroups'])) { ?>checked="true"<?php  } ?>  />  无分组
       </label>
       <?php  if(is_array($groups)) { foreach($groups as $group) { ?>
          <label class="checkbox-inline">
           <input type="checkbox" class='chksingle'  name="buygroups[]" value="<?php  echo $group['id'];?>" <?php  if($item['buygroups']!='' &&  is_array($item['buygroups']) && in_array($group['id'], $item['buygroups']) ) { ?>checked="true"<?php  } ?>  /> <?php  echo $group['groupname'];?>
          </label>
       <?php  } } ?>
       
       
    </div>
</div>   
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
    <div class="col-sm-6 col-xs-6">
      <div class='alert alert-info'>
    只有当折扣大于0，小于10的情况下才能生效，否则按自身会员等级折扣计算
</div>
    </div>
</div>  

<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员等级折扣<br/>0.1-10之间</label>
    <div class="col-sm-6 col-xs-6">
        <div class='input-group'>
           <div class='input-group-addon'>默认等级</div>
           <input type='text' name='discounts[default]' class="form-control" value="<?php  echo $discounts['default']?>" />
           <div class='input-group-addon'>折</div>
       </div>
    </div>
</div>   
    <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
    <div class="col-sm-6 col-xs-6">
        <div class='input-group'>
           <div class='input-group-addon'><?php  echo $level['levelname'];?></div>
           <input type='text' name='discounts[level<?php  echo $level['id'];?>]' class="form-control"  value="<?php  echo $discounts['level'.$level['id']]?>" />
           <div class='input-group-addon'>折</div>
       </div>
    </div>
</div>   
<?php  } } ?>
<script language='javascript'>
    $('.chkall').click(function(){
        var checked =$(this).get(0).checked;
        if(checked) {
            $(this).closest('div').find(':checkbox[class!="chkall"]').removeAttr('checked');
        }
    });
    $('.chksingle').click(function(){
         $(this).closest('div').find(':checkbox[class="chkall"]').removeAttr('checked');
    })
    
	</script>