<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<form id="setform"  action="" method="post" class="form-horizontal form">
    <div class='panel'>
       <h3 class="custom_page_header">虚拟物品-发货提醒 </h3>
     
        <div class='panel-body'>
          <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">虚拟物品-发货提醒</label>
                    <div class="col-sm-9 col-xs-12">
                    
                        <input type="text" name="virtual_send_notice" class="form-control" value="<?php  echo $set['virtual_send_notice'];?>" />
                        <div class="help-block">公众平台模板消息编号: OPENTM203331384</div>
                    </div>
        </div>
        
        
        

         <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
            <div class="col-sm-9">
                <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"/>
                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
            </div>
        </div>
        </div>

 
</form>

<?php include page("footer-base");?>