<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<?php  if($operation == 'display') { ?>
  
<div class="panel">
				<h3 class="custom_page_header">文章管理 
                          <a class='btn btn-default' href="<?php  echo create_url('site',array('act' => 'article','do' => 'article','op' => 'post'))?>"><i class='fa fa-plus'></i> 添加文章</a>
                          
                        </h3>
                       
                       
                       <div class="panel-body">
            <form action="" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="mod" value="site" />
                <input type="hidden" name="do" value="article" />
                <input type="hidden" name="act"  value="article" />
                <input type="hidden" name="op" value="display" />
                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                     
                <div class="form-group">
                	  
                    	 <div class="col-sm-2">
                        <input class="form-control" name="keyword" id="" type="text" value="<?php echo $_GPC['keyword'];?>" placeholder="文章名称关键字">
                    </div>
                      
					
					
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<select class="form-control tpl-category-parent" id="category" name="category" onchange="renderCategory(this,'category')">
					   <?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
					<option value="<?php echo $category['id'];?>" <?php  if($_GPC['category']==$category['id']) { ?>selected<?php  } ?>><?php echo $category['category_name'];?></option>
				            <?php  } } ?> 
				</select>
			</div>
						   <div class="col-sm-1"> <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                    	</div>
                 
                </div>
                
          
            </form>
        </div>
    <style>
        .label{cursor:pointer;}
    </style>

 
                <form action="" method="post">       <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                         
    <div class="panel-body table-responsive">
        <table class="table table-hover">
            <thead class="navbar-inner">
                <tr>
                    <th style="width:30px;">ID</th>
                    <th style='width:80px'>显示顺序</th>					
                    <th>标题</th>
                    <th style="width:90px;">文章时间</th>
                    <th>真实<br/>阅读量/点赞量</th>
                    <th>虚拟<br/>阅读量/点赞量</th>
                    <th style='width:80px'>状态</th>
                    <th >操作</th>
                </tr>
            </thead>
            <tbody><?php  if(count($articles)>0) { ?>
                <?php  if(is_array($articles)) { foreach($articles as $article) { ?>
                <tr>
                    <td><?php  echo $article['id'];?></td>
                    <td>
                
                           <input type="text" class="form-control" name="displayorder[<?php  echo $article['id'];?>]" value="<?php  echo $article['displayorder'];?>">
                     
                    </td>
                    
        <td>
					<?php  if(!empty($article['category_name'])) { ?>
						<label class="label label-primary"><?php  echo $article['category_name'];?></label><br/>
					<?php  } ?>
				<?php  echo $article['article_title'];?>
				</td>
				<td><?php  echo $article['article_date_v'];?></td>
				<td data-toggle='tooltip' >真实阅读量：<?php  echo $article['article_readnum'];?>
					<br/>真实点赞量：<?php  echo $article['article_likenum'];?></td>
						<td data-toggle='tooltip' >虚拟阅读量：<?php  echo $article['article_readnum_v'];?>
					<br/>虚拟点赞量：<?php  echo $article['article_likenum_v'];?></td>
				<td>
					<span class='label 
						<?php  if($article['article_state']==1) { ?>label-success<?php  } else { ?>label-default<?php  } ?>' >
			
						<?php  if($article['article_state']==1) { ?>开启<?php  } else { ?>关闭<?php  } ?>
					</span>
	
				</td>
				
                    <td style="text-align:center">
                    	
                    	<p>		<a href="<?php  echo create_url('mobile',array('act' => 'article','do' => 'article', 'id' => $article['id']))?>" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-link"></i>预览</a>
                   	
                    	 <a href="<?php  echo create_url('site',array('act' => 'article','do' => 'article','op' => 'post', 'id' => $article['id']))?>" class="btn btn-default btn-sm" 
                                                               title="修改"><i class="fa fa-edit"></i>修改</a> 	</p>
                         	<p>  <a href="<?php  echo create_url('site',array('act' => 'article','do' => 'article','op' => 'delete', 'id' => $article['id']))?>"class="btn btn-default btn-sm" onclick="return confirm('确认删除此幻灯片?')" title="删除"><i class="fa fa-times"></i>删除</a>
                  	</p>  </td>
                </tr>
                <?php  } } ?> 
                 <tr>
							<td colspan="8">
						
								<input name="submit" type="submit" class="btn btn-primary" value="保存排序">
					

							</td>
						</tr>
                <?php  } else { ?>
								<tr>
							<td colspan='8'>
                              <div  style='text-align: center;padding:30px;'>
                                  暂时没有文章!
                              </div>	</td>
						</tr>
                          <?php  } ?>
                          
                         
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div></form>
</div>



<?php  } else if($operation == 'post') { ?>
  <link href="<?php  echo RESOURCE_ROOT;?>eshop/article/article.css?v=2" rel="stylesheet">
<style type='text/css'>
	.tabs-container .form-group {overflow: hidden;}
	.tabs-container .tabs-left > .nav-tabs {width: 120px;}
	.tabs-container .tabs-left .panel-body {margin-left: 120px; width: 880px; text-align: left;}	
	.tab-article .nav li {width: 120px; text-align: right;}
	.popover {left: 0;}
	#source-container {position: relative;}
</style>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" onsubmit='return formcheck()'>
<input type="hidden" name="aid" value="<?php  echo $aid;?>" />
	
        <div class="panel">
        
            <h3 class="custom_page_header">  <?php  if(!empty($article['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>文章</h3>
   
   
	<div class='row'>
		
		<div class="col-sm-5" style='padding-right:1px;padding-left:1px;'>
		
		
		<div class="fart-preview">
        <div class="top"><p bind-to="art_title"><?php  if($aid) { ?><?php  echo $article['article_title'];?><?php  } else { ?>这里是文章标题<?php  } ?></p></div>
        <div class="main">
            <div class="fart-rich-primary">
                <div class="fart-rich-title" bind-to="art_title"><?php  if($aid) { ?><?php  echo $article['article_title'];?><?php  } else { ?>这里是文章标题<?php  } ?></div>
                <div class="fart-rich-mate">
                    <div class="fart-rich-mate-text" bind-to="art_date_v"><?php  if($aid) { ?><?php  echo $article['article_date_v'];?><?php  } else { ?><?php  echo date('Y-m-d');?><?php  } ?></div>
                    <div class="fart-rich-mate-text" bind-to="art_author"><?php  if($aid) { ?><?php  echo $article['article_author'];?><?php  } else { ?>编辑小美<?php  } ?></div>
                    <div class="fart-rich-mate-text href" bind-to="art_mp"><?php  if(empty($article['article_mp'])) { ?><?php  echo $mp['name'];?><?php  } else { ?><?php  echo $article['article_mp'];?><?php  } ?></div>
                </div>
                <div class="fart-rich-content" id="preview-content">
                    <?php  echo htmlspecialchars_decode($article['article_content'])?>
                </div>
                <div class="fart-rich-tool">
                    <div class="fart-rich-tool-text link">查看原文</div>
                    <div class="fart-rich-tool-text"><i class="icon icon-person2"></i></div>
                    <div class="fart-rich-tool-text" bind-to="art_read"> <?php  if($aid) { ?><?php  if($article['article_readnum_v']>100000) { ?>100000+<?php  } else { ?><?php  echo $article['article_readnum_v'];?><?php  } ?><?php  } else { ?>100000+<?php  } ?></div>
                    <div class="fart-rich-tool-text"><i class="icon icon-likefill text-danger"></i></div>
                    <div class="fart-rich-tool-text">
                        <span bind-to="art_like"> <?php  if($aid) { ?><?php  if($article['article_likenum_v']>100000) { ?>100000+<?php  } else { ?><?php  echo $article['article_likenum_v'];?><?php  } ?><?php  } else { ?>54321<?php  } ?></span>
                    </div>
                    <div class="fart-rich-tool-text right">反馈</div>
                </div>
            </div>
           
        </div>
        <!-- 手机 -->
    </div>
		
			</div>

		<div class="col-sm-7" style='padding-right:1px;padding-left:1px;position:relative'>
	

			
		

					<div class="panel-body">
						
						        <!-- start -->
						
						    <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">文章标题</label>
                    <div class="col-sm-9 col-xs-12">
                      
               	<input type="text" name="article_title" class="form-control" value="<?php  echo $article['article_title'];?>" data-rule-required='true' bind-in="art_title" />
	
                      
                    </div>
                </div>
                
                
                		    <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分类</label>
                    <div class="col-sm-9 col-xs-12">
                      
               			<select class="form-control" name="article_category" data-rule-required='true'>
                                    <option value="0">请选择文章分类</option>
                                    <?php  if(is_array($categorys)) { foreach($categorys as $category) { ?>
                                        <option value="<?php  echo $category['id'];?>" <?php  if($article['article_category']==$category['id']) { ?> selected="selected"<?php  } ?>><?php  echo $category['category_name'];?></option>
                                    <?php  } } ?>
                    </select>
                      
                    </div>
                </div>
                
					
					
					  <div class="form-group">
                 	<label class="col-sm-2 control-label"></label>

	<div class="col-sm-3">
		<input type="text" name="article_mp" class="form-control" value="<?php  echo $article['article_mp'];?>" placeholder="公众号" bind-in="art_mp" bind-de="<?php  echo $article['article_mp'];?>">
	
	</div>

	<div class="col-sm-3">
		<input type="text" name="article_author" class="form-control" value="<?php  echo $article['article_author'];?>" placeholder="发布作者" bind-in="art_author" bind-de="<?php  echo $article['article_author'];?>">
	</div>

	<div class="col-sm-3">
		<?php  echo tpl_form_field_date('article_date_v', $article['article_date_v'],false)?>
	</div>
                </div>


<div class="form-group">
 <label class="col-xs-12 col-sm-3 col-md-2 control-label">全文链接</label>

	<div class="col-sm-9 col-xs-12">
		<input type="text" name="article_linkurl" class="form-control" value="<?php  echo $article['article_linkurl'];?>" placeholder="阅读全文链接，如果不填写则不显示阅读全文">
	</div>
</div>

<div class="form-group">
 <label class="col-xs-12 col-sm-3 col-md-2 control-label">虚拟阅读数</label>

	<div class="col-sm-3">

		<input type="text" name="article_readnum_v" class="form-control" value="<?php  echo $article['article_readnum_v'];?>" placeholder="虚拟阅读数" bind-in="art_read" bind-de="0" bind-num='1'>
	</div>
	<label class="col-sm-2 control-label">虚拟点赞数</label>
	<div class="col-sm-3">
		<input type="text" name="article_likenum_v" class="form-control" value="<?php  echo $article['article_likenum_v'];?>" placeholder="虚拟点赞数" bind-in="art_like" bind-de="0" bind-num='1'>
	</div>

</div>



<div class="form-group">

         <div class="col-sm-11 col-xs-12">
		<?php  echo tpl_ueditor('article_content',$article['article_content'],array('height'=>500))?>
		</div>

</div>

<script language="javascript">
    $(function(){
        var ue =  UE.getEditor('article_content');
        ue.addListener('contentChange',function(){
            $("#preview-content").html(ue.getContent());
        });
      });
        
	        
	    
</script>




<div class="form-group">
	<label class="col-sm-2 control-label">文章描述</label>
	<div class="col-sm-9 col-xs-12">
		<textarea class="form-control" name="resp_desc"><?php echo $article['resp_desc'];?></textarea>
	</div>
</div>
<div class="form-group">
	<label class="col-sm-2 control-label">封面图片</label>
	<div class="col-sm-9 col-xs-12">
		<?php  echo tpl_form_field_image('resp_img',$article['resp_img'])?>
	</div>
</div>

<div class="form-group">
 <label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
	<div class="col-sm-9 col-xs-12">
		<label class="radio-inline"><input type="radio" name="article_state" value="1" <?php  if(!$aid || $article['article_state']==1) { ?>checked="true"<?php  } ?>> 开启</label>
		<label class="radio-inline"><input type="radio" name="article_state" value="0" <?php  if($aid && $article['article_state']==0) { ?>checked="true"<?php  } ?>> 关闭</label>
		<span class='help-block'>关闭后手机端列表不会显示</span>
	</div>
</div>
            <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="submit" name="submit" value="保存" class="btn btn-primary col-lg-3"  />
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
              
                    </div>
            </div>
                
			        <!-- end -->
						
						</div>
	
			
			</div>

		</div>


</form>
<script type="text/javascript">
	$(function() {
		$(':input[name=article_date_v]').attr('bind-in', 'art_date_v');
		$("input").bind('input propertychange', function() {
			pagestate = 1;
			var bindint = $(this).attr("bind-in");
			var bindnum = $(this).attr("bind-num");
			var bindinfo = !$(this).val() ? $(this).attr("bind-de") : $(this).val();
			if (bindnum == '1' && parseInt(bindinfo) > 100000) {
				bindinfo = '100000+';
			}
			$("*[bind-to=" + bindint + "]").text(bindinfo);
		});
	})

		
	
	function save(){
		var title = $.trim($("input[name=article_title]").val());
		if(title==''){
			$("input[name=article_title]").focus();
			tip.msgbox.err("请填写文章标题!");
			return false;
		}
		var category = $("select[name=article_category] option:selected").val();
		if(category==0){
			$("select[name=article_category]").focus();
			tip.msgbox.err("请选择文章分类!");
			return false;
		}

		
		
	}
</script>
   
   </div>
    </form>
</div>

<?php  } ?>
<?php include page("footer-base");?>