<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page("header-base");?>
<form id="setform"  action="" method="post" class="form-horizontal form" >
    <div class='panel'>
         
	 <h3 class="custom_page_header">系统事件回复</h3>
        <div class='panel-body'>
        
        	<div class="alert alert-info">
 关键字请在消息回复一栏“文字回复”或者“图文回复”功能中设置触发关键字。
 </div>
        	
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">粉丝关注回复关键字：</label>
                <div class="col-sm-9 col-xs-12">
                	
			<input type="text" class="form-control" name="subscribe_keyword" value="<?php  echo $settings['subscribe_keyword'];?>">

                </div>
            </div>
            
               	
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">默认回复关键字：</label>
                <div class="col-sm-9 col-xs-12">
                	
			<input type="text" class="form-control" name="default_keyword" value="<?php  echo $settings['default_keyword'];?>">
			<span class="help-block">如果没有设置，则默认转向到微信官方客服接口接收。</span>
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

<?php include page("footer-base");?>