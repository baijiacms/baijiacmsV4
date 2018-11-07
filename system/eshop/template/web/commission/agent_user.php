<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<div class="panel panel-default">
    <div class='panel-body'>
    <div style='height:100px;width:110px;float:left;'>
         <img onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'"  src='<?php  echo $member['avatar'];?>' style='width:100px;height:100px;border:1px solid #ccc;padding:1px' />
    </div>
    <div style='float:left;height:100px;overflow: hidden'>
    	  会员ID： <?php  echo $member['openid'];?><br/>
        昵称： <?php  echo $member['nickname'];?>/姓名： <?php  echo $member['realname'];?> <br/>
        手机号： <?php  echo $member['mobile'];?> /  微信号： <?php  echo $member['weixin'];?><br/>
        下级会员(非分销商)： <span style='color:red'><?php  echo $level11;?></span> 人    <br/>
        下级分销商： 总共 <span style='color:red'><?php  echo $member['agentcount'];?></span> 人 
        <?php  if($set['level']>=1) { ?>一级： <span style='color:red'><?php  echo $level1;?> </span>  人<?php  } ?>  
            <?php  if($set['level']>=2) { ?>二级： <span style='color:red'><?php  echo $level2;?></span>  人<?php  } ?> 
                <?php  if($set['level']>=3) { ?>三级： <span style='color:red'><?php  echo $level3;?></span> 人<?php  } ?>
          点击：  <span style='color:red'><?php  echo $member['clickcount'];?></span> 次
    </div>
        </div>
</div>
<form method='get' class='form-horizontal'>
<div class="panel ">
    <div class="panel-body">
        <form action="" method="get" class="form-horizontal" role="form" id="form1">
            <input type="hidden" name="mod" value="site" />
            <input type="hidden" name="m" value="eshop" />
            <input type="hidden" name="do" value="commission" />
            <input type="hidden" name="act" value="agent" />
            <input type="hidden" name="op" value="user" />
            <input type="hidden" name="beid" value="<?php echo $GLOBALS['_CMS']['beid'];?>" />
            <input type="hidden" name="id" value="<?php  echo $agentid;?>" />
           <div class="form-group">
             
                        <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">会员信息</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control"  name="realname" value="<?php  echo $_GPC['realname'];?>" placeholder='可搜索昵称/名称/手机号/会员ID'/> 
                </div>
                       <div class="col-sm-6">
                     <div class='input-group'>
                        <div class='input-group-addon'>成为代理时间
                            <label class='radio-inline' style='margin-top:-7px;'>
                                <input type='radio' value='0' name='searchtime' <?php  if($_GPC['searchtime']=='0') { ?>checked<?php  } ?>>不搜索
                            </label>
                            <label class='radio-inline'  style='margin-top:-7px;'>
                                <input type='radio' value='1' name='searchtime' <?php  if($_GPC['searchtime']=='1') { ?>checked<?php  } ?>>搜索
                            </label>
                        </div>
                       <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d  H:i', $endtime)),true);?>
                   	</div>
                         </div>
                </div>
                
                
                
                
           
   
                   <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 col-lg-1 control-label">推荐人</label>
                <div class="col-sm-4">
                    <select name='parentid' class='form-control'>
                        <option value=''></option>
                        <option value='0' <?php  if($_GPC['parentid']=='0') { ?>selected<?php  } ?>>总店</option>
                    </select>
                </div>
                   <label class="col-xs-12 col-sm-3 col-md-2 col-lg-1 control-label">推荐人信息</label>
                 <div class="col-sm-4">
                    <input type="text"  class="form-control" name="parentname" value="<?php  echo $_GPC['parentname'];?>" placeholder='推荐人昵称/姓名/手机号'/> 
                </div>
            </div>
             <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">分销商等级</label>
                <div class="col-sm-4 ">
                    <select name='agentlevel' class='form-control'>
                        <option value=''></option>
                         <?php  if(is_array($agentlevels)) { foreach($agentlevels as $level) { ?>
                        <option value='<?php  echo $level['id'];?>' <?php  if($_GPC['agentlevel']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
                  <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">下级层级</label>
                  <div class="col-sm-4"><select name='level' class='form-control'>
                        <option value=''>所有下线</option>
                        <?php  if($set['level']>=1) { ?><option value='1' <?php  if($_GPC['level']=='1') { ?>selected<?php  } ?>>一级下线</option><?php  } ?>
                        <?php  if($set['level']>=2) { ?><option value='2' <?php  if($_GPC['level']=='2') { ?>selected<?php  } ?>>二级下线</option><?php  } ?>
		       <?php  if($set['level']>=3) { ?><option value='3' <?php  if($_GPC['level']=='3') { ?>selected<?php  } ?>>三级下线</option><?php  } ?>
                    </select>
                     </div>
            </div>
			 
	 
			
                    <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">状态</label>
          
				<div class="col-sm-2">
                   <select name='isagent' class='form-control'>
                        <option value=''>是否分销商</option>
                        <option value='0' <?php  if($_GPC['isagent']=='0') { ?>selected<?php  } ?>>不是</option>
                        <option value='1' <?php  if($_GPC['isagent']=='1') { ?>selected<?php  } ?>>是</option>
                    </select>
			    </div>	  
				<div class="col-sm-2">
                    <select name='status' class='form-control'>
                        <option value=''>状态</option>
                        <option value='0' <?php  if($_GPC['status']=='0') { ?>selected<?php  } ?>>未审核</option>
                        <option value='1' <?php  if($_GPC['status']=='1') { ?>selected<?php  } ?>>已审核</option>
                    </select>
                       </div>
                      <div class="col-sm-2">
                       <select name='agentblack' class='form-control'>
                        <option value=''>黑名单状态</option>
                        <option value='0' <?php  if($_GPC['agentblack']=='0') { ?>selected<?php  } ?>>否</option>
                        <option value='1' <?php  if($_GPC['agentblack']=='1') { ?>selected<?php  } ?>>是</option>
                    </select>
                </div>
                <div class="col-sm-4 "><button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button></div>
            </div>
 
      
    </div>
     </form>
 
<div class="panel">
    <div class="panel-body">
        <table class="table table-hover"   style="overflow:visible;">
            <thead class="navbar-inner">
                <tr>
                     <th>推荐人</th>
                    <th >粉丝</th>
                    <th >分销等级</th>
                    <th >点击数</th>
                    <th >累计佣金<br/>打款佣金</th>
                    <th >下级分销商</th>
                    <th >状态<br/>（点击审核)</th>
                    <th >时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                      <td  <?php  if(!empty($row['agentid'])) { ?>title='ID: <?php  echo $row['agentid'];?>'<?php  } ?>>
                           <?php  if(empty($row['agentid'])) { ?>
                           <?php  if($row['isagent']==1) { ?>
				      <label class='label label-primary'>总店</label>
				      <?php  } else { ?>
				       <label class='label label-default'>暂无</label>
				      <?php  } ?>
                          <?php  } else { ?>
                          <img onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" src='<?php  echo $row['parentavatar'];?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' /> <?php  echo $row['parentname'];?>
                          <?php  } ?>
                      </td>
                    <td> 
                
                      <img onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" src='<?php  echo $row['avatar'];?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' />
               
                       <br/>昵称:<?php  if(empty($row['nickname'])) { ?>未更新<?php  } else { ?><?php  echo $row['nickname'];?><?php  } ?>
                       <br/>姓名:<?php  echo $row['realname'];?><br/>手机:<?php  echo $row['mobile'];?>
                    </td>
                    
<td>
	<?php  if($row['isagent']==1) { ?>
	<?php  if(empty($row['levelname'])) { ?> 
	普通等级<?php  } else { ?><?php  echo $row['levelname'];?><?php  } ?>
	<?php  } else { ?>
			-
			<?php  } ?>

</td>
                    <td> 	<?php  if($row['isagent']==1) { ?>
						<?php  echo $row['clickcount'];?>
						<?php  } else { ?>
			-
			<?php  } ?>
					</td>
                    <td>
						<?php  if($row['isagent']==1 && $row['status']==1) { ?>
						<?php  echo $row['commission_total'];?><br/><?php  echo $row['commission_pay'];?>
					
						<?php  } else { ?>
			-
			<?php  } ?>
					</td>
                    <td>
						<?php  if($row['isagent']==1) { ?>
                        总计：<?php  echo $row['levelcount'];?> 人
                        <?php  if($level>=1 && $row['level1']>0) { ?><br/>一级：<?php  echo $row['level1'];?> 人<?php  } ?>
                        <?php  if($level>=2  && $row['level2']>0) { ?><br/> 二级：<?php  echo $row['level2'];?> 人<?php  } ?>
                        <?php  if($level>=3  && $row['level3']>0) { ?><br/>三级：<?php  echo $row['level3'];?> 人<?php  } ?>
					
						<?php  } else { ?>
			-
			<?php  } ?>
					</td>
                    <td>
						<?php  if($row['isagent']==1) { ?>
                        <?php  if($row['status']==0) { ?>
                                <?php  if($row['agentblack']==1) { ?>
                                  <span class="label label-default" style='color:#fff;background:black'>黑名单</span>
                                <?php  } else { ?>
                                  
                              
                                   <a class="label label-default" href="<?php  echo $this->createWebUrl('commission/agent',array('id' => $row['id'],'op'=>'check'))?>" onclick="return confirm('确认要审核此分销商吗?')">未审核</a>
                                
                                <?php  } ?>
                        <?php  } else { ?>
                        <span class="label label-success">已审核</span>
                        <?php  } ?>
				<?php  } else { ?>
			-
			<?php  } ?>		
			 
                    </td>
                    <td>注册时间:<?php  echo date('Y-m-d H:i',$row['createtime'])?><br/>
                     代理时间:<?php  if(!empty($row['agenttime'])) { ?><?php  echo date('Y-m-d H:i',$row['agenttime'])?><?php  } ?> 
                    </td>
                       
                    <td  style="overflow:visible;">
                        
                        <div class="btn-group btn-group-sm">
                                <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="javascript:;">操作 <span class="caret"></span></a>
                                   <ul class="dropdown-menu dropdown-menu-left" role="menu" style='z-index: 99999'>
                       
                     <li><a href="<?php  echo $this->createWebUrl('member',array('act'=>'list','op'=>'detail', 'id' => $row['id']));?>" title='会员信息'><i class='fa fa-user'></i> 会员信息</a></li>
                          <li><a href="<?php  echo $this->createWebUrl('commission/agent/detail',array('id' => $row['id']));?>" title='详细信息'><i class='fa fa-edit'></i> 详细信息</a>	</li>
                      <li><a  href="<?php  echo $this->createWebUrl('order/list',array('op'=>'display','agentid' => $row['id']));?>" title='推广订单'><i class='fa fa-list'></i> 推广订单</a></li>
                       <li><a  href="<?php  echo $this->createWebUrl('commission/agent/user',array('id' => $row['id']));?>"  title='推广下线'><i class='fa fa-users'></i> 推广下线</a></li>
                      
                          <?php  if($row['agentblack']==1) { ?> 
                          <li><a href="<?php  echo $this->createWebUrl('commission/agent/agentblack',array('id' => $row['id'],'black'=>0));?>" title='取消黑名单'><i class='fa fa-minus-square'></i> 取消黑名单</a></li>
                           <?php  } else { ?>
                           <li><a href="<?php  echo $this->createWebUrl('commission/agent/agentblack',array('id' => $row['id'],'black'=>1));?>" title='设置黑名单'><i class='fa fa-minus-circle'></i> 设置黑名单</a></li>
                           <?php  } ?>
                  
                      <li><a href="<?php  echo $this->createWebUrl('commission/agent/delete',array('id' => $row['id']));?>" title="删除" onclick="return confirm('确定要删除该会员吗？');"><i class='fa fa-remove'></i> &nbsp;删除分销商</a></li>
                
                                </ul>
                            </div>

               
                    </td>
                </tr>
                <?php  } } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include page("footer-base");?>