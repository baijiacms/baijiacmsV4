<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page("header-base");?>
<form id="setform"  action="" method="post" class="form-horizontal form" >
    <div class='panel'>
         
	 <h3 class="custom_page_header"> 文字回复</h3>
        <div class='panel-body'>
              <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">规则名称</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='entry[name]' value="<?php  echo $rule['name'];?>" />
                </div>
            </div>
            
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span> 触发关键词</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='entry[keyword]' value="<?php  echo $rule['keyword'];?>" />
                </div>
            </div>
      
              <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">描述</label>
                <div class="col-sm-9 col-xs-12">
                    <textarea name='entry[content]' class='form-control'><?php  echo $basic_reply['content'];?></textarea>
                </div>
            </div>
    
          
         <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
            <div class="col-sm-9">
                <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1" />
            </div>
        </div>
        </div>
     
    </div>
</form>
<script language='javascript'>
    $(function(){
        $('form').submit(function(){
            if($(':input[name="entry[keyword]"]').val()==""||$(':input[name="entry[keyword]"]').val().length==0){
                alert('请输入关键词!');
                return false;
            }
            return true;
        })
        
    })
    </script>
<?php include page("footer-base");?>