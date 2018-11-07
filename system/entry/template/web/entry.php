<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page("header-base");?>
<form id="setform"  action="" method="post" class="form-horizontal form" >
    <div class='panel'>
         
	 <h3 class="custom_page_header"> <?php echo $entery_name;?></h3>
        <div class='panel-body'>
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">访问链接</label>
                <div class="col-sm-9 col-xs-12">
                	
                	<div class="input-group ">
			<input type="text" class="form-control" readonly="readonly" value="<?php echo WEBSITE_ROOT.$entery_url;?>">
                    
			<span class="input-group-btn">
			<a class="btn btn-default" href='<?php echo WEBSITE_ROOT.$entery_url;?>' target="_blank" ><i class="fa fa-eye"></i> 点击预览</a>
			</span>
		</div>
                </div>
            </div>
            
            
        	
            
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style="color:red">*</span> 触发关键词</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='entry[keyword]' value="<?php  echo $rule['keyword'];?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">封面标题</label>
                <div class="col-sm-9 col-xs-12">
                     <input type='text' class='form-control' name='entry[title]' value="<?php  echo $entry['title'];?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">封面图片</label>
                <div class="col-sm-9 col-xs-12">
                     <?php  echo tpl_form_field_image('entry[thumb]',$entry['thumb'])?>
                </div>
            </div>
              <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">封面描述</label>
                <div class="col-sm-9 col-xs-12">
                    <textarea name='entry[desc]' class='form-control'><?php  echo $entry['description'];?></textarea>
                </div>
            </div>
               <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
                <div class="col-sm-9">
                    <label class="radio-inline">
                        <input type="radio" name="entry[status]" value="0" <?php  if(empty($rule['status'])) { ?> checked="checked"<?php  } ?>/>
                               禁用
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="entry[status]" value="1" <?php  if($rule['status']==1) { ?> checked="checked"<?php  } ?>/>
                               启用
                    </label>
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
        	if($(':input[name="entry[status]"]').val()==1)
        	{
            if($(':input[name="entry[keyword]"]').val()==""||$(':input[name="entry[keyword]"]').val().length==0){
                alert('请输入关键词!');
                return false;
            }
          }
            return true;
        })
        
    })
    </script>
<?php include page("footer-base");?>