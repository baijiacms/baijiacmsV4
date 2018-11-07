<?php defined('IN_IA') or exit('Access Denied');?>
<?php include page("header-base");?>


<?php  if($operation == 'post') { ?>
<div class="main">
	<form action="" method="post" onsubmit="return check(this)" class="form-horizontal form" enctype="multipart/form-data">
		    <input type="hidden" name="activityid" value="<?php  echo $activity['id'];?>" />
		   <div class="panel">
           <h3 class="custom_page_header">基本信息        <input type="submit" name="submit" value="提交保存" class="btn btn-primary "  /></h3>
                  <div class='panel-body'>  
                  	<?php  if(!empty($activity['id'])){?>
                  	     <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">访问地址</label>
                    <div class="col-sm-9 col-xs-12">
                    <div class="input-group ">
			<input type="text" class="form-control" readonly="readonly" value="<?php  echo WEBSITE_ROOT.create_url('mobile',array('act' => 'activity','do' => 'index','isaddons'=>'1','activityid' => $activity['id']));?>">
                    
			<span class="input-group-btn">
			<a class="btn btn-default" href="<?php  echo WEBSITE_ROOT.create_url('mobile',array('act' => 'activity','do' => 'index','isaddons'=>'1','activityid' => $activity['id']));?>" target="_blank"><i class="fa fa-eye"></i> 点击预览</a>
			</span>
		</div> </div>
                </div>
                
                 	<?php  }else{?>	     <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">访问地址</label>
                    <div class="col-sm-9 col-xs-12">
                    提交后生成访问地址
                     </div>
                </div>
                     	<?php  }?>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">活动名称</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="title" class="form-control" value="<?php  echo $activity['title'];?>" placeholder="活动标题名称" />
                    </div>
                </div>
                
                     <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">活动人数</label>
                    <div class="col-sm-9 col-xs-12">
                    	  <div class="input-group">
                     <input type="text" name="personnum" class="form-control" value="<?php  echo $activity['personnum'];?>" placeholder="不填写无限制" />
                            <span class="input-group-addon">人</span>
                             </div>    </div>
                </div>
                    <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">虚拟报名人数</label>
                    <div class="col-sm-9 col-xs-12">
                    	  <div class="input-group">
                     <input type="text" name="virtualrec" class="form-control" value="<?php  echo $activity['virtualrec'];?>"  />
                            <span class="input-group-addon">人</span>
                             </div>
                             <div class="help-block">在真实数据上叠加</div>
                                 </div>
                </div>
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">报名时间</label>
                    <div class="col-sm-9 col-xs-12">
                       <?php  echo tpl_form_field_daterange('joinTime', array('start' =>$activity['joinstime'],'end' =>$activity['joinetime']), true);?>
                        </div>
                </div>
                
                
                
                          <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">活动时间</label>
                    <div class="col-sm-9 col-xs-12">
                          <?php  echo tpl_form_field_daterange('activityTime', array('start' =>$activity['starttime'],'end' =>$activity['endtime']), true);?>
                          </div>
                </div>
                
                
                   <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">主办方名称</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="unit" class="form-control" value="<?php  echo $activity['unit'];?>" placeholder="主办方名称" />
                          </div>
                </div>
                
                  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">联系电话</label>
                    <div class="col-sm-9 col-xs-12">
                             <input type="text" name="tel" class="form-control" value="<?php  echo $activity['tel'];?>" placeholder="联系电话" />
                         </div>
                </div>
                
                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">门店位置</label>
                    <div class="col-sm-9 col-xs-12">
                       
                            <?php  echo tpl_form_field_coordinate('map',array('lng'=>$activity['lng'],'lat'=>$activity['lat']))?>  </div>
                </div>
                
                     <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">活动地点</label>
                    <div class="col-sm-9 col-xs-12">
                       
                    <input type="text" name="address" class="form-control" value="<?php  echo $activity['address'];?>" placeholder="活动详细地址" />
                         </div>
                     </div>
                     
                 
                        <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">详情图集</label>
                    <div class="col-sm-9 col-xs-12">
                   <?php  echo tpl_form_field_multi_image('img',$activity['atlas']);?>
                            <span class="help-block">活动详情幻灯片，建议：640X300</span>
                         </div>
                     </div>
                     
                     
                          <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">活动详情</label>
                    <div class="col-sm-9 col-xs-12" style="height:300px">
                       
                    
                            <?php  echo tpl_ueditor('detail', $activity['detail']);?>
                    
                         </div>
                     </div>
                     
                       <h3 class="custom_page_header">分享设置 </h3>
                        <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享标题</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="share[title]" class="form-control" value="<?php  echo $activity['sharetitle'];?>" placeholder="如果不填写，系统默认">
                         </div>
                     </div>
                
                        <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享图标</label>
                    <div class="col-sm-9 col-xs-12">
                                         <?php  echo tpl_form_field_image('share[pic]', $activity['sharepic']);?>
                            <div class="help-block">图片建议为正方形，如果不选择，默认为活动缩略图片</div>
                            
                             </div>
                     </div>
                     
           
                       <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">分享描述</label>
                    <div class="col-sm-9 col-xs-12">
                                     <input type="text" name="share[desc]" class="form-control" value="<?php  echo $activity['sharedesc'];?>" placeholder="如果不填写，系统默认">
                             </div>
                     </div>
                           <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">未关注-提示地址</label>
                    <div class="col-sm-9 col-xs-12">
                                     <input type="text" name="share[followurl]" class="form-control" value="<?php  echo $activity['followurl'];?>" placeholder="如果不填写，则不显示">
                             </div>
                     </div>
                         <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">未关注-提示图标</label>
                    <div class="col-sm-9 col-xs-12">
                    	          <?php  echo tpl_form_field_image('share[followicon]', $activity['followicon']);?>
                            <div class="help-block">图片建议为正方形</div>
                              </div>
                     </div>
                 
                
                     <h3 class="custom_page_header">微信回复设置 </h3>
                                 <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">标题</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="entery_title" class="form-control" value="<?php  echo $activity['entery_title'];?>"  />
                    
                         </div>
                     </div>
                        <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">关键字</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="entery_keyword" class="form-control" value="<?php  echo $activity['entery_keyword'];?>"  />
                    
                         </div>
                     </div>
                   
                     	        <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">缩略图片</label>
                    <div class="col-sm-9 col-xs-12">
                       
                            <?php  echo tpl_form_field_image('entery_thumb', $activity['entery_thumb']);?>
                    
                         </div>
                     </div>
                            <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">封面描述</label>
                    <div class="col-sm-9 col-xs-12">
                            <input type="text" name="entery_description" class="form-control" value="<?php  echo $activity['entery_description'];?>"  />
                    
                         </div>
                     </div>
                     
                          <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                    <div class="col-sm-9 col-xs-12">
                         
                            <input type="submit" name="submit" value="提交保存" class="btn btn-primary"  />
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                       
                     </div>
            </div>
                
                   </div>
          </div>
          
          



	</form>
</div>
<script type="text/javascript">
$(function () {
	window.optionchanged = false;
	$('#myTab a').click(function (e) {
		e.preventDefault();//阻止a链接的跳转行为
		$(this).tab('show');//显示当前选中的链接及关联的content
	})
});
</script>
<script type="text/javascript">
	function check(form) {

		if (!form['title'].value) {
			$("input[name='title']").focus();
			alert('主人，请输入活动的主题名称');
			return false;
		}
		if (!form['headtitle'].value) {
			$("input[name='headtitle']").focus();
			alert('主人，请输入网页标题');
			return false;
		}		
		if (!form['activitytitle'].value) {
			$("input[name='activitytitle']").focus();
			alert('主人，请输入活动的主题内容');
			return false;
		}
		if (!form['undertaker'].value) {
			$("input[name='undertaker']").focus();
			alert('主人，请输入主办方名称');
			return false;
		}	
		
		if (!form['begintime'].value) {
			$("input[name='begintime']").focus();
			alert('主人，请点击选择活动的开始日期');
			return false;
		}
		if (!form['endtime'].value) {
			$("input[name='endtime']").focus();
			alert('主人，请点击选择活动的截止日期');
			return false;
		}
		
		var str1 = $('#cal1').val();
		var str2 = $('#cal2').val();
		var d1 = new Date(str1); 
		var d2 = new Date(str2); 
		if(Date.parse(d1) - Date.parse(d2) >= 0){   
			$("input[name='endtime']").focus();
			alert('主人，截止日期要比开始日期晚一些日子'); 
			return false;
		} 
		
		if (!form['place'].value) {
			$("input[name='place']").focus();
			alert('主人，请输入兑奖地址');
			return false;
		}
		if (!form['tel'].value) {
			$("input[name='tel']").focus();
			alert('主人，请输入兑奖电话');
			return false;
		}else{
			 var tel = $('#tel').val();
		     if (tel.search(/^(13[0-9]|15[0|3|6|7|8|9]|18[8|9])\d{8}$/) == -1) {
		    		$("input[name='tel']").focus();
					//alert('主人，请输入正确的手机号码');
					return true;
				}
		}	
	}
</script>
 
<?php  } else if($operation == 'display') { ?>
<div class="panel">
    <h3 class="custom_page_header">活动列表 
                          <a class="btn btn-default" href="<?php  echo create_url('site',array('act' => 'activity','do' => 'activity','isaddons'=>'1', 'op' => 'post'))?>"><i class="fa fa-plus"></i> 添加活动</a>
                          
                        </h3>
                        
                        
                               <div class="panel-body">
                               	
        <table class="table table-hover">
            <thead class="navbar-inner">
                   <tr>
                    <th style="width:60px;text-align: center;">活动ID</th>
                    <th style="text-align: center;">活动名称</th>
                    <th style="width:80px;text-align: center;">状态</th>
                    <th style="width:80px;text-align: center;">报名/总数</th>
                    <th style="width:170px;text-align: center;">活动时间</th>
                    <th style="width:170px;text-align: center;"> <span id="timeSortEnd">结束时间<i class="fa fa-sort-numeric-asc"></i></span></th>
                    <th style="width:200px; text-align: center;">操作</th>
                </tr>
            </thead>
            <tbody>
            	
            <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td style="text-align: center;"><?php  echo $row['id'];?></td>
                    <td style="text-align: center;"><?php  echo $row['title'];?></td>
                    <td style="text-align: center;"><?php  if(TIMESTAMP < strtotime($row['endtime'])) { ?>
                    <span class="label label-primary">进行中</span>
                    <?php  } else { ?><span class="label label-warning">已结束</span>
                    <?php  } ?></td>
                    <td style="text-align: center;"><font color="red"><?php  echo  pdo_fetchcolumn('SELECT COUNT(*) FROM ' . table('activity_records') . " WHERE activityid=:activityid",array(':activityid' => $row['id']))?></font>/<?php  if($row['personnum'] == 0) { ?>不限<?php  } else { ?><?php  echo $row['personnum'];?><?php  } ?></td>
                    <td style="text-align: center;"><?php  echo date('Y-m-d H:i',strtotime($row['starttime']))?></td>
                    <td style="text-align: center;"><?php  echo date('Y-m-d H:i',strtotime($row['endtime']))?></td>
                    <td class="text-center">
                   
                    	<a href="<?php  echo create_url('site',array('act' => 'activity','do' => 'records','isaddons'=>'1','activityid' => $row['id'], 'op' => 'display'))?>" class="btn btn-primary btn-sm" data-original-title="" title="">报名记录</a>
                        <a href="<?php  echo create_url('site',array('act' => 'activity','do' => 'activity','isaddons'=>'1','activityid' => $row['id'], 'op' => 'post'))?>" class="btn btn-success btn-sm" data-original-title="" title="">编辑</a>
                        <a onclick="return confirm('此操作不可恢复，确认删除？');return false;" class="js-delete btn btn-danger btn-sm" href="<?php  echo create_url('site',array('act' => 'activity','do' => 'activity','isaddons'=>'1', 'op' => 'delete','activityid'=>$row['id']))?>" title="删除">删除</a>
                        
                    </td>
                </tr>
            <?php  } } ?>
            	
            </tbody>
        </table>
        <?php  echo $pager;?>
                               	
                               	
                               	
                              </div>
                            </div>
                        

<?php  } ?>

<?php include page("footer-base");?>