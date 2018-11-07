<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" >
        <input type='hidden' name='setid' value="<?php  echo $set['id'];?>" />
        <input type='hidden' name='op' value="follow" />
        <div class="panel">
            
           
           <h3 class="custom_page_header">关注设置 </h3>
            
            <div class='panel-body'>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">关注引导页</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="share[followurl]" class="form-control" value="<?php  echo $set['share']['followurl'];?>" />
                        <span class='help-block'>用户未关注的引导页面，建议使用短链接：<a target="_blank" href="http://www.dwz.cn">短网址</a>
                      
                    </div>
                </div>
            </div>
            	 <h3 class="custom_page_header"> 分享设置</h3>
            <div class='panel-body'> 
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享标题</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="share[title]" class="form-control" value="<?php  echo $set['share']['title'];?>" />
                        <span class="help-block">不填写默认商城名称</span>
                   

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享图标</label>
                    <div class="col-sm-9 col-xs-12">
                     

                        <?php  echo tpl_form_field_image('share[icon]', $set['share']['icon']);?>
                        <span class="help-block">不选择默认商城LOGO</span>
                     

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享描述</label>
                    <div class="col-sm-9 col-xs-12">
                      
                        <textarea style="height:100px;" name="share[desc]" class="form-control" cols="60"><?php  echo $set['share']['desc'];?></textarea>
                   
                    </div> 
                </div> 
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享连接</label>
                    <div class="col-sm-9 col-xs-12">
                      
                        <input type="text" name="share[url]" class="form-control" value="<?php  echo $set['share']['url'];?>" />
                        <span class='help-block'>用户分享出去的连接，默认为首页</span>
                       
                    </div>
                </div>
                
                       <div class="form-group"></div>
            <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                          
                            <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"  />
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                    
                     </div>
            </div>
                       
            </div>
        </div>     
    </form>
</div>
<?php include page("footer-base");?>