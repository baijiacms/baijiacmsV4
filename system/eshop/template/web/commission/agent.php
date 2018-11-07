<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<?php  if($operation=='display') { ?>
<div class="panel ">
     <h3 class="custom_page_header"> 分销商管理</h3>
    <div class="panel-body">
        <form action="" method="get" class="form-horizontal" role="form" id="form1">
            <input type="hidden" name="mod" value="site" />
            <input type="hidden" name="m" value="eshop" />
            <input type="hidden" name="do" value="commission" />
            <input type="hidden" name="act" value="agent" />
            <input type="hidden" name="op" value="display" />
						<input type="hidden" name="beid" value="<?php echo $GLOBALS['_CMS']['beid'];?>" />
                
                <div class="form-group">
                  
                    
                    <label class="col-sm-2 col-md-2 col-lg-1 control-label">会员信息</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control"  name="realname" value="<?php  echo $_GPC['realname'];?>" placeholder='可搜索昵称/名称/手机号/会员ID'/>
                    </div>
                    <label class="col-sm-2 col-md-2 col-lg-1 control-label">状态</label>
                    <div class="col-sm-3">
                        <select name='status' class='form-control'>
                            <option value=''>审核状态</option>
                            <option value='0' <?php  if($_GPC['status']=='0') { ?>selected<?php  } ?>>未审核</option>
                            <option value='1' <?php  if($_GPC['status']=='1') { ?>selected<?php  } ?>>已审核</option>
                        </select>
                    </div>
                </div>
         
                <div class="form-group">
                    <label class="col-sm-2  col-md-2 col-lg-1 control-label">推荐人</label>
                    <div class="col-sm-3">
                        <select name='parentid' class='form-control'>
                            <option value=''></option>
                            <option value='0' <?php  if($_GPC['parentid']=='0') { ?>selected<?php  } ?>>总店</option>
                        </select>
                    </div>
                      <label class="col-sm-2  col-md-2 col-lg-1 control-label">推荐人</label>
                    <div class="col-sm-3">
                        <input type="text"  class="form-control" name="parentname" value="<?php  echo $_GPC['parentname'];?>" placeholder='推荐人昵称/姓名/手机号/会员ID'/>
                    </div>
                    
                   
                </div>
            
                <div class="form-group">
                  
                     <label class="col-sm-2  col-md-2 col-lg-1 control-label" style="font-size: 12px;">黑名单状态</label>
                   
                    <div class="col-sm-3">
                        <select name='agentblack' class='form-control'>
                            <option value=''>黑名单状态</option>
                            <option value='0' <?php  if($_GPC['agentblack']=='0') { ?>selected<?php  } ?>>否</option>
                            <option value='1' <?php  if($_GPC['agentblack']=='1') { ?>selected<?php  } ?>>是</option>
                        </select>
                    </div>
          <label class="col-sm-2  col-md-2 col-lg-1 control-label" style="font-size: 12px;">分销商等级</label>
                       <div class="col-sm-3">
                        <select name='agentlevel' class='form-control'>
                            <option value=''>全部分销商</option>
                            <?php  if(is_array($agentlevels)) { foreach($agentlevels as $level) { ?>
                            <option value='<?php  echo $level['id'];?>' <?php  if($_GPC['agentlevel']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
                            <?php  } } ?>
                        </select>
                    </div>
                </div>
                
        
                
                        <div class="form-group">
                    <label class="col-xs-2  col-md-2 col-lg-1 control-label">成为分销商<br/>时间</label>
                    
                    <div class="col-sm-5">
                    <div class='input-group'>
                        <div class='input-group-addon'>
                            <label class='radio-inline' style='margin-top:-7px;'>
                                <input type='radio' value='0' name='searchtime' <?php  if(empty($_GPC['searchtime'])) { ?>checked<?php  } ?>>不搜索
                            </label>
                            <label class='radio-inline'  style='margin-top:-7px;'>
                                <input type='radio' value='1' name='searchtime' <?php  if($_GPC['searchtime']=='1') { ?>checked<?php  } ?>>搜索
                            </label>
                        </div>
                          <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d  H:i', $endtime)),true);?>
                   
                     		</div>
                       
            				</div>
            			
            			 <div class="col-sm-3">
                        <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
              
                        <button type="submit" name="export" value="1" class="btn btn-primary">导出 Excel</button>
                 
                    </div>
            			
                 </div>
                
        </form>
    </div>
    
    <div class="panel-body">
        <table class="table table-hover table-responsive">
            <thead class="navbar-inner" >
            <tr>
            	<th >会员ID</th>
                <th style='width:100px;'>推荐人</th>
                <th style='width:120px;'>分销商昵称</th>
                <th style='width:110px;'>姓名<br/>手机号码</th>
                <th style='width:80px;'>分销等级</th>
                <th style='width:100px;'>累计佣金<br/>打款佣金</th>
                <th style='width:120px;'>下级分销商</th>
                <th style='width:90px;'>状态<br/>(点击审核)</th>
                <th style='width:65px;'>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array($list)) { foreach($list as $row) { ?>
            <tr>
            	
                   <td><?php  echo $row['openid'];?></td>
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
                    <?php  if(!empty($row['avatar'])) { ?>
                    <img onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" src='<?php  echo $row['avatar'];?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' />
                    <?php  } ?>
                    <?php  if(empty($row['nickname'])) { ?>未更新<?php  } else { ?><?php  echo $row['nickname'];?><?php  } ?>

                </td>

                <td><?php  echo $row['realname'];?> <br/> <?php  echo $row['mobile'];?></td>
                <td><?php  if(empty($row['levelname'])) { ?> <?php echo empty($set['levelname'])?'普通等级':$set['levelname']?><?php  } else { ?><?php  echo $row['levelname'];?><?php  } ?></td>
          
                <td><?php  echo $row['commission_total'];?><br/><?php  echo $row['commission_pay'];?></td>
                <td>
                    总计：<?php  echo $row['levelcount'];?> 人
                    <?php  if($level>=1 && $row['level1']>0) { ?><br/>一级：<?php  echo $row['level1'];?> 人<?php  } ?>
                    <?php  if($level>=2  && $row['level2']>0) { ?><br/> 二级：<?php  echo $row['level2'];?> 人<?php  } ?>
                    <?php  if($level>=3  && $row['level3']>0) { ?><br/>三级：<?php  echo $row['level3'];?> 人<?php  } ?></td>
                <td>
                    <?php  if($row['status']==0) { ?>
                    <?php  if($row['agentblack']==1) { ?>
                    <span class="label label-default" style='color:#fff;background:black'>黑名单</span>
                    <?php  } else { ?>

                    <a class="label label-default" href="<?php  echo $this->createWebUrl('commission/agent',array('id' => $row['id'],'op'=>'check'))?>" onclick="return confirm('确认要审核此分销商吗?')">未审核</a>
                  
                    <?php  } ?>
                    <?php  } else { ?>
                    <span class="label label-success">已审核</span>
                    <?php  } ?>
                </td>
       
           
                <td  style="overflow:visible;">

                    <div class="btn-group btn-group-sm">
                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="javascript:;">操作 <span class="caret"></span></a>
                        <ul class="dropdown-menu dropdown-menu-left" role="menu" style='z-index: 99999'>
                            <li><a href="<?php  echo $this->createWebUrl('commission/agent',array('id' => $row['id'],'op'=>'detail'));?>" title='分销员信息'><i class='fa fa-edit'></i> 分销员信息</a>	</li>	
                          <li><a href="<?php  echo $this->createWebUrl('member',array('act'=>'list','op'=>'detail', 'id' => $row['id']));?>" title='会员信息'><i class='fa fa-user'></i> 会员信息</a></li>	
                          <li><a  href="<?php  echo $this->createWebUrl('order/list',array('op'=>'display','agentid' => $row['id']));?>" title='推广订单'><i class='fa fa-list'></i> 推广订单</a></li>
                         <li><a  href="<?php  echo $this->createWebUrl('commission/agent',array('id' => $row['id'],'op'=>'user'));?>"  title='推广下线'><i class='fa fa-users'></i> 推广下线</a></li>
                      
                            <?php  if($row['agentblack']==1) { ?>
                            <li><a href="<?php  echo $this->createWebUrl('commission/agent',array('id' => $row['id'],'black'=>0,'op'=>'agentblack'));?>" title='取消黑名单'><i class='fa fa-minus-square'></i> 取消黑名单</a></li>
                            <?php  } else { ?>
                            <li><a href="<?php  echo $this->createWebUrl('commission/agent',array('id' => $row['id'],'black'=>1,'op'=>'agentblack'));?>" title='设置黑名单'><i class='fa fa-minus-circle'></i> 设置黑名单</a></li>
                            <?php  } ?>
                     
                           <li><a href="<?php  echo $this->createWebUrl('commission/agent',array('id' => $row['id'],'op'=>'delete'));?>" title="删除" onclick="return confirm('确定要删除该会员吗？');"><i class='fa fa-remove'></i> &nbsp;删除分销商</a></li>

                        </ul>
                    </div>


                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
</div>
<?php  } else if($operation=='detail') { ?>

<form  action="" method='post' class='form-horizontal'>
<input type="hidden" name="id" value="<?php  echo $member['id'];?>">
            <input type="hidden" name="mod" value="site" />
            <input type="hidden" name="m" value="eshop" />
            <input type="hidden" name="do" value="commission" />
            <input type="hidden" name="act" value="agent" />
            <input type="hidden" name="op" value="detail" />
<div class='panel panel-default'>
    <h3 class="custom_page_header"> 分销商详细信息</h3>
    <div class='panel-body'>

        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">粉丝</label>
            <div class="col-sm-9 col-xs-12">
                <img onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" src='<?php  echo $member['avatar'];?>' style='width:100px;height:100px;padding:1px;border:1px solid #ccc' />
                <?php  echo $member['nickname'];?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">OPENID</label>
            <div class="col-sm-9 col-xs-12">
                <div class="form-control-static"><?php  echo $member['openid'];?></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">真实姓名</label>
            <div class="col-sm-9 col-xs-12">
                <input type="text" name="data[realname]" class="form-control" value="<?php  echo $member['realname'];?>"  />
         
            </div>
        </div>

        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">手机号码</label>
            <div class="col-sm-9 col-xs-12">
                <input type="text" name="data[mobile]" class="form-control" value="<?php  echo $member['mobile'];?>"  />
             
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">微信号</label>
            <div class="col-sm-9 col-xs-12">
                <input type="text" name="data[weixin]" class="form-control" value="<?php  echo $member['weixin'];?>"  />
             
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销商等级</label>
            <div class="col-sm-9 col-xs-12">
  
                <select name='data[agentlevel]' class='form-control'>
                    <option value='0'>普通等级</option>
                    <?php  if(is_array($agentlevels)) { foreach($agentlevels as $level) { ?>
                    <option value='<?php  echo $level['id'];?>' <?php  if($member['agentlevel']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
                    <?php  } } ?>
                </select>
            
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">累计佣金</label>
            <div class="col-sm-9 col-xs-12">
                <div class='form-control-static'> <?php  echo $member['commission_total'];?></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">已打款佣金</label>
            <div class="col-sm-9 col-xs-12">
                <div class='form-control-static'> <?php  echo $member['commission_pay'];?></div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">注册时间</label>
            <div class="col-sm-9 col-xs-12">
                <div class='form-control-static'><?php  echo date('Y-m-d H:i:s', $member['createtime']);?></div>
            </div>
        </div>
        <?php  if($member['agenttime']!='1970-01-01 08:00') { ?>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">成为代理时间</label>
            <div class="col-sm-9 col-xs-12">
                <div class='form-control-static'><?php  if(!strexists('1970',$member['agenttime'])) { ?><?php  echo $member['agenttime'];?><?php  } else { ?>----------<?php  } ?></div>
            </div>
        </div>
        <?php  } ?>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销商权限</label>
            <div class="col-sm-9 col-xs-12">
             
                <label class="radio-inline"><input type="radio" name="data[isagent]" value="1" <?php  if($member['isagent']==1) { ?>checked<?php  } ?>>是</label>
                <label class="radio-inline" ><input type="radio" name="data[isagent]" value="0" <?php  if($member['isagent']==0) { ?>checked<?php  } ?>>否</label>
            

            </div>
        </div>
     <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">固定上级</label>
            <div class="col-sm-9 col-xs-12">
             
                <label class="radio-inline"><input type="radio" name="data[fixagentid]" value="1" <?php  if($member['fixagentid']==1) { ?>checked<?php  } ?>>是</label>
                <label class="radio-inline" ><input type="radio" name="data[fixagentid]" value="0" <?php  if($member['fixagentid']==0) { ?>checked<?php  } ?>>否</label>
            

            </div>
        </div>
        <?php $dingtalk_setting=globalSetting('dingtalk');?>
        <?php if(!empty($dingtalk_setting['fastlogin_open'])){?>
         <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">阿里钉钉</label>
                <div class="col-sm-9 col-xs-12">
                    <div class="form-control-static">
                    	          <?php if(!empty($member['base_member'])&&!empty($member['base_member']['dingtalk_openid'])){?>
                    	<label class="label label-primary">绑定</label>阿里钉钉&nbsp;openid：<?php  echo $member['base_member']['dingtalk_openid'];?>
                    	      <?php }else{?> <label class="label label-default">未绑定</label>  <?php }?>
                    </div>
                </div>
            </div>
               <?php } ?>
                       <?php if(false){?>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">审核通过</label>
            <div class="col-sm-9 col-xs-12">
              
                <label class="radio-inline"><input type="radio" name="data[status]" value="1" <?php  if($member['status']==1) { ?>checked<?php  } ?>>是</label>
                <label class="radio-inline" ><input type="radio" name="data[status]" value="0" <?php  if($member['status']==0) { ?>checked<?php  } ?>>否</label>
                <input type='hidden' name='oldstatus' value="<?php  echo $member['status'];?>" />
           
            </div>
        </div>
       <?php } ?>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">强制不自动升级</label>
            <div class="col-sm-9 col-xs-12">
         
                <label class="radio-inline" ><input type="radio" name="data[agentnotupgrade]" value="0" <?php  if($member['agentnotupgrade']==0) { ?>checked<?php  } ?>>允许自动升级</label>
                <label class="radio-inline"><input type="radio" name="data[agentnotupgrade]" value="1" <?php  if($member['agentnotupgrade']==1) { ?>checked<?php  } ?>>强制不自动升级</label>
                <span class="help-block">如果强制不自动升级，满足任何条件，此分销商的级别也不会改变</span>
              
            </div>
        </div>

     
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">黑名单</label>
            <div class="col-sm-9 col-xs-12">
                <input type='hidden' name='oldagentblack' value="<?php  echo $member['agentblack'];?>" />
           
                <label class="radio-inline"><input type="radio" name="data[agentblack]" value="1" <?php  if($member['agentblack']==1) { ?>checked<?php  } ?>>是</label>
                <label class="radio-inline" ><input type="radio" name="data[agentblack]" value="0" <?php  if($member['agentblack']==0) { ?>checked<?php  } ?>>否</label>
            
            </div>
        </div>

        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">备注</label>
            <div class="col-sm-9 col-xs-12">
  
                <textarea name="content" class='form-control'><?php  echo $member['content'];?></textarea>
         
            </div>
        </div>

    </div>

   

    <div class='panel-body'>

        <div class="form-group"></div>
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
            <div class="col-sm-9 col-xs-12">
               
                <input type="submit" name="submit" value="提交" class="btn btn-primary col-lg-1"  />
                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
              
                <input type="button" name="back" onclick='history.back()' style='margin-left:10px;' value="返回列表" class="btn btn-default" />
            </div>
        </div>


    </div>


</div>

</form>

<?php  } ?>
<?php include page("footer-base");?>