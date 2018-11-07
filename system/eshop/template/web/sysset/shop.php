<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" >
        <input type='hidden' name='setid' value="<?php  echo $set['id'];?>" />
        <input type='hidden' name='op' value="shop" />
        <div class="panel">
		
           <h3 class="custom_page_header">基本设置 </h3>
            <div class='panel-body'>  
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商城名称</label>
                    <div class="col-sm-9 col-xs-12">
                       
                        <input type="text" name="shop[name]" class="form-control" value="<?php  echo $set['shop']['name'];?>" />
                     

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商城LOGO</label>
                    <div class="col-sm-9 col-xs-12">
                       
                        <?php  echo tpl_form_field_image('shop[logo]', $set['shop']['logo'])?>
                        <span class='help-block'>正方型图片</span>
                      
                    </div>
                </div>
   
      
				
				<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">QQ在线客服</label>
                    <div class="col-sm-9 col-xs-12">
                     
                        <input type="text" name="shop[kefuu]" class="form-control" value="<?php  echo $set['shop']['kefuu'];?>" />
                   

                    </div>
                </div>
				
				
				
				
				
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">全局代码</label>
                    <div class="col-sm-9 col-xs-12">
                       
			 <textarea name="shop[diycode]" class="form-control richtext" cols="70" rows="5"><?php  echo $set['shop']['diycode'];?></textarea>
                    <span class="help-block">可嵌入全局统计代码，在线客服代码</span>
                    </div>
            </div>
				
          
                       
            </div>  
			
			
			
		<div class="custom_page_header">会员设置</div>
            <div class='panel-body'>  
				
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员等级说明连接</label>
                    <div class="col-sm-9 col-xs-12">
                       
                        <input type="text" name="shop[levelurl]" class="form-control" value="<?php  echo $set['shop']['levelurl'];?>" />
                     
                    </div>
                </div>
                	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员等级升级依据</label>
                    <div class="col-sm-9 col-xs-12">
                     
                        <label class="radio radio-inline">
                              <input type="radio" name="shop[leveltype]" value="0" <?php  if(empty($set['shop']['leveltype'])) { ?>checked<?php  } ?>/> 已完成的订单金额
                        </label>
                       <label class="radio radio-inline">
                              <input type="radio" name="shop[leveltype]" value="1" <?php  if($set['shop']['leveltype']==1) { ?>checked<?php  } ?>/> 已完成的订单数量
                        </label>
                        <span class="help-block">默认为完成订单金额</span> 
                  
                    </div>
                </div>
			
			
			 <h3 class="custom_page_header">分成等级设置 </h3>
            <div class='panel-body'>  
               
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推荐分类广告</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php  echo tpl_form_field_image('shop[catadvimg]', $set['shop']['catadvimg'])?>
                        <span class='help-block'>分类页面中，推荐分类的广告图，建议尺寸640*320</span>
                     
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">推荐分类广告连接</label>
                    <div class="col-sm-9 col-xs-12">
                     
                        <input type="text" name="shop[catadvurl]" class="form-control" value="<?php  echo $set['shop']['catadvurl'];?>" />
                       
                    </div>
                </div>
                				
                   
            </div>
			 

			<div class="custom_page_header">
				商城关闭设置
			</div>
            <div class='panel-body'>
				  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商城状态</label>
                    <div class="col-sm-9 col-xs-12">
                   
						<label class="radio-inline">
							<input type="radio" name="shop[close]" value='0' <?php  if($set['shop']['close']==0) { ?>checked<?php  } ?> /> 开启
						</label>
						<label class="radio-inline">
							<input type="radio" name="shop[close]" value='1' <?php  if($set['shop']['close']==1) { ?>checked<?php  } ?> /> 关闭
						</label>
						
                      
                    </div>
            </div>
	<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商城关闭跳转连接</label>
                    <div class="col-sm-9 col-xs-12">
                    
                        <input type="text" name="shop[closeurl]" class="form-control" value="<?php  echo $set['shop']['closeurl'];?>" />
						<span class='help-block'>如果您不采用系统页面，则可以设置关闭提醒连接，当商城关闭时跳转到此链接（非任何商城的连接）</span>
                    

                    </div>
                </div>			
	  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">商城关闭提醒</label>
                    <div class="col-sm-9 col-xs-12">
              <input type="text" name="shop[closedetail]" class="form-control" value="<?php  echo $set['shop']['closedetail'];?>" />
                     
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