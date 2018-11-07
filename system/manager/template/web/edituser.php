<?php defined('SYSTEM_IN') or exit('Access Denied');?><?php include page("system_header");?>
<script>
	function onchange_system(itemvalue)
	{
			if(itemvalue==1)
			{
				document.getElementById("store_div").style.display="none";
			}
				if(itemvalue==0)
			{
					document.getElementById("store_div").style.display="block";
			}
	}
	</script>
<form  method="post" class="form-horizontal form">
        <input type="hidden" name="id" value="<?php  echo $account['id'];?>" />
         <div class="panel ">
        
            <h3 class="custom_page_header">  <?php   if(empty($account['id'])){ ?>新增<?php  }else{ ?>编辑<?php  } ?>管理员</h3>
	  <div class="panel-body">
	  		 	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span>类型</label>
                  <div class="col-sm-9 col-xs-12">
                    	    <label class="radio-inline">
                       			<input type="radio" name="is_admin" value="0" <?php   if(empty($account['is_admin'])){ ?>checked="true"<?php  } ?> onchange="onchange_system(0)"> 店铺管理员
            </label><label class="radio-inline">
          <input type="radio" name="is_admin"  value="1" <?php   if(!empty($account['is_admin'])){ ?>checked="true"<?php  } ?>  onchange="onchange_system(1)">系统管理员
       	  </label>
                    </div>
                </div>
                
                  		 	<div class="form-group"  id="store_div">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span>店铺</label>
                  <div class="col-sm-9 col-xs-12">
                    	  <select class="form-control" style="margin-right:15px;" id="store" name="store" >
                <option value="0">请选择店铺</option>
         		  <?php  if(is_array($store_list)) { foreach($store_list as $row) { ?>
       
                <option value="<?php  echo $row['id'];?>" <?php  if($row['id'] == $account['beid']) { ?> selected="selected"<?php  } ?>><?php  echo $row['sname'];?></option>
            
                <?php  } } ?>
            </select>
                    </div>
                </div>
                
                
	  	 	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span>用户名</label>
                    <div class="col-sm-9 col-xs-12">
               <input type="text" name="username" class="form-control" value="<?php echo $account['username'];?>"/>
                    </div>
                </div>
                	<?php   if(empty($account['id'])){ ?>
                 	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span>新密码</label>
                    <div class="col-sm-9 col-xs-12">
											   <input type="password"  name="newpassword"  class="form-control"  />
                    </div>
                </div>		
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span>确认密码</label>
                    <div class="col-sm-9 col-xs-12">
											   <input type="password"  name="confirmpassword"  class="form-control"  />
                    </div>
                </div>	
                <?php   } ?>
	  	
	  	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                        
                            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1">
                      </div>
            </div>
	  	
</div>
</div>
				
    </form>
<script>
	onchange_system(<?php echo intval($account['is_admin']);?>);
	</script>
<?php include page("footer-base");?>