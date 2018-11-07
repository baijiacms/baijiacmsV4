<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<?php  if($operation=='display') { ?>
<div class="panel">
	 <h3 class="custom_page_header"> 会员管理</h3>
        
    <div class="panel-body">
        <form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
            <input type="hidden" name="mod" value="site" />
            <input type="hidden" name="m" value="eshop" />
            <input type="hidden" name="do" value="member" />
              <input type="hidden" name="act" value="list" />
              
                 <div class="form-group">
       
                
                  <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1 control-label">会员信息</label>
                <div class="col-sm-3 col-lg-3 col-xs-2">
                    <input type="text" class="form-control"  name="realname" value="<?php  echo $_GPC['realname'];?>" placeholder="可搜索昵称/姓名/手机号/会员ID"/> 
                </div>
                
                    <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1 control-label">黑名单</label>
                <div class="col-sm-3 col-lg-3 col-xs-2">
                    <select name='isblack' class='form-control'>
                        <option value=''></option>
                        <option value='0' <?php  if($_GPC['isblack']=='0') { ?>selected<?php  } ?>>否</option>
                        <option value='1' <?php  if($_GPC['isblack']=='1') { ?>selected<?php  } ?>>是</option>
                    </select>
                </div>
            </div>
	
             <div class="form-group">
                <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1 control-label">会员等级</label>
                <div class="col-sm-3 col-lg-3 col-xs-2">
                       <select name='level' class='form-control'>
                        <option value=''></option>
                        <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
                        <option value='<?php  echo $level['id'];?>' <?php  if($_GPC['level']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
                
                 <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1 control-label">会员分组</label>
                <div class="col-sm-3 col-lg-3 col-xs-2">
                       <select name='groupid' class='form-control'>
                        <option value=''>无分组</option>
                        <?php  if(is_array($groups)) { foreach($groups as $group) { ?>
                        <option value='<?php  echo $group['id'];?>' <?php  if($_GPC['groupid']==$group['id']) { ?>selected<?php  } ?>><?php  echo $group['groupname'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
                
                 <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                <div class="col-sm-3 col-lg-3 col-xs-2">
                  
                </div>
            </div>
            
                <div class="form-group">
                    <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1 control-label">注册时间</label>
                    
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
                     <div class="col-sm-4 col-lg-4 col-xs-4">
                       <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                       <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
   
                        <button type="submit" name="export" value="1" class="btn btn-primary">导出 Excel</button>
         
                       
                    </div>
                         
                </div>
	     
            
       
        </form>
        <table class="table table-hover" style="overflow:visible;">
            <thead class="navbar-inner">
                <tr>
                    <th style='width:195px;'>会员ID</th>



                    <th >粉丝昵称</th>
                    <th >会员信息</th>
                    <th >等级/分组</th>
                    <th >注册时间</th>
                    <th >积分/余额</th>
                    <th >成交</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td>   <?php  echo $row['openid'];?>		   <?php  if($row['isblack']==1) { ?>
                    <br/><span class="label label-default" style='color:#fff;background:black'>黑名单</span><br/>
					<?php  } ?></td>



		  
                    <td>
                    	<?php  if(!empty($row['avatar'])) { ?>
                         <img src='<?php  echo $row['avatar'];?>' onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" style='width:30px;height:30px;padding1px;border:1px solid #ccc' />
                       <?php  } ?>
                       <?php  if(empty($row['nickname'])) { ?><span style="color:#b9b3b3">未获取</span><?php  } else { ?><?php  echo $row['nickname'];?><?php  } ?>
                        
                    </td>
                    <td><?php  echo $row['realname'];?><br/><?php  echo $row['mobile'];?></td>
                    <td><?php  if(empty($row['levelname'])) { ?>普通会员<?php  } else { ?><?php  echo $row['levelname'];?><?php  } ?>
                        <br/><?php  if(empty($row['groupname'])) { ?>无分组<?php  } else { ?><?php  echo $row['groupname'];?><?php  } ?></td>
      
                    <td><?php  echo date('Y-m-d',$row['createtime'])?><br/><?php  echo date('H:i:s',$row['createtime'])?></td>
                    <td><label class="label label-primary">积分: <?php  echo intval($row['credit1'])?></label>
						<br/><label class="label label-danger">余额: <?php  echo $row['credit2'];?></label></td>
              
                    <td><label class="label label-primary">订单: <?php  echo $row['ordercount'];?></label>
						<br/><label class="label label-danger">金额: <?php  echo floatval($row['ordermoney'])?></label></td>
                   
             
                            <td  style="overflow:visible;">
                        
                        <div class="btn-group btn-group-sm" >
                                <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="javascript:;">操作 <span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-menu-left" role="menu" style='z-index: 9999'>
                               
                       <li><a href="<?php  echo $this->createWebUrl('member/list',array('op'=>'detail','id' => $row['id']));?>" title="会员详情"><i class='fa fa-edit'></i> 会员详情</a></li>
                       <li><a  href="<?php  echo $this->createWebUrl('order/list', array('op' => 'display','memberid'=>$row['openid']))?>" title='会员订单'><i class='fa fa-list'></i> 会员订单</a></li>
                      <li><a href="<?php  echo $this->createWebUrl('finance/recharge', array('op'=>'credit1','id'=>$row['id']))?>" title='充值积分'><i class='fa fa-credit-card'></i> 充值积分</a></li>
                     <li><a href="<?php  echo $this->createWebUrl('finance/recharge', array('op'=>'credit2','id'=>$row['id']))?>" title='充值余额'><i class='fa fa-money'></i> 充值余额 </a></li>
		  
                            <?php  if($row['isblack']==1) { ?>
                            <li><a href="<?php  echo $this->createWebUrl('member/list',array('op'=>'setblack','id' => $row['id'],'black'=>0));?>" title='取消黑名单'><i class='fa fa-minus-square'></i> 取消黑名单</a></li>
                            <?php  } else { ?>
                            <li><a href="<?php  echo $this->createWebUrl('member/list',array('op'=>'setblack','id' => $row['id'],'black'=>1));?>" title='设置黑名单'><i class='fa fa-minus-circle'></i> 设置黑名单</a></li>
                            <?php  } ?>
                     
                      <li><a  href="<?php  echo $this->createWebUrl('member/list',array('op'=>'delete','id' => $row['id']));?>" title='删除会员' onclick="return confirm('确定要删除该会员吗？');"><i class='fa fa-remove'></i> 删除会员</a></li>
                                </ul>
                            </div>

               
                    </td>
                   
                    </td>
                </tr>
                <?php  } } ?>
            </tbody>
        </table>
           <?php  echo $pager;?>
    </div>
</div>
<?php  } else if($operation=='detail') { ?>

<form action="" method='post' class='form-horizontal'>
    <input type="hidden" name="id" value="<?php  echo $member['id'];?>">

    <div class='panel panel-default'>
      	 <h3 class="custom_page_header">
            会员详细信息
        </h3>
        <div class='panel-body'>
             <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">粉丝</label>
                <div class="col-sm-9 col-xs-12">
                    <img src='<?php  echo $member['avatar'];?>' onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" style='width:100px;height:100px;padding:1px;border:1px solid #ccc' />
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
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否绑定微信</label>
                <div class="col-sm-9 col-xs-12">
                    <div class="form-control-static">
                    	  <?php if(!empty($member['base_member'])&&!empty($member['base_member']['weixin_openid'])){?>
                    	<label class="label label-primary" style="background-color: green;">绑定</label>微信openid：<?php  echo $member['base_member']['weixin_openid'];?>
                    	      <?php }else{?> <label class="label label-default">未绑定</label>  <?php }?>
                    	</div>
                </div>
            </div>
          
              
               <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否绑定QQ</label>
                <div class="col-sm-9 col-xs-12">
                    <div class="form-control-static">
                        <?php if(!empty($member['base_member'])&&!empty($member['base_member']['qq_openid'])){?>
                    	<label class="label label-primary">绑定</label>QQ&nbsp;openid：<?php  echo $member['base_member']['qq_openid'];?>
                    	      <?php }else{?> <label class="label label-default">未绑定</label>  <?php }?>
                    	</div>
                </div>
            </div>
          
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员等级</label>
                <div class="col-sm-9 col-xs-12">
                      <select name='data[level]' class='form-control'>
                        <option value=''><?php echo empty($shop['levelname'])?'普通会员':$shop['levelname']?></option>
                        <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
                        <option value='<?php  echo $level['id'];?>' <?php  if($member['level']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
            </div>
              <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员分组</label>
                <div class="col-sm-9 col-xs-12">
                      <select name='data[groupid]' class='form-control'>
                        <option value=''>无分组</option>
                        <?php  if(is_array($groups)) { foreach($groups as $group) { ?>
                        <option value='<?php  echo $group['id'];?>' <?php  if($member['groupid']==$group['id']) { ?>selected<?php  } ?>><?php  echo $group['groupname'];?></option>
                        <?php  } } ?>
                    </select>
                   
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
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">登陆密码</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="data[upassword]" class="form-control" value=""  />(6位数密码)
                        <span class="help-block">注意：6位数密码，不填写则不修改用户密码，如果填写会覆盖原有用户登陆的密码，请谨慎！</span>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">微信号</label>
                <div class="col-sm-9 col-xs-12">
               
                          <input type="text" name="data[weixin]" class="form-control" value="<?php  echo $member['weixin'];?>"  />
                  
                </div>
            </div>
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">积分</label>
                <div class="col-sm-3">
                     <div class='input-group'>
                        <div class=' input-group-addon'  style='width:200px;text-align: left;'><?php  echo $member['credit1'];?></div>
                      <div class='input-group-btn'>
                         <a class='btn btn-primary' href="<?php  echo $this->createWebUrl('finance/recharge', array('op'=>'credit1','id'=>$member['id']))?>">充值</a>
                          </div>
                      </div>
                 
          
                </div>
            </div>
              <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">余额</label>
                <div class="col-sm-3">  
              
                    <div class='input-group'>
                        <div class=' input-group-addon' style='width:200px;text-align: left;'><?php  echo $member['credit2'];?></div>
                       
                        <div class='input-group-btn'><a class='btn btn-primary' href="<?php  echo $this->createWebUrl('finance/recharge', array('op'=>'credit2','id'=>$member['id']))?>">充值</a>
                            </div>
                   
                    </div>
                 
                </div>
            </div>
             <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">成交订单数</label>
                <div class="col-sm-9 col-xs-12">
                    <div class='form-control-static'><?php  echo $member['self_ordercount'];?></div>
                </div>
            </div>
               <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">成交金额</label>
                <div class="col-sm-9 col-xs-12">
                    <div class='form-control-static'><?php  echo $member['self_ordermoney'];?> 元</div>
                </div>
            </div>
               <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">注册时间</label>
                <div class="col-sm-9 col-xs-12">
                    <div class='form-control-static'><?php  echo date('Y-m-d H:i:s', $member['createtime']);?></div>
                </div>
            </div>
        
        <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">黑名单</label>
                <div class="col-sm-9 col-xs-12">
                   
                    <label class="radio-inline"><input type="radio" name="data[isblack]" value="1" <?php  if($member['isblack']==1) { ?>checked<?php  } ?>>是</label>
                    <label class="radio-inline" ><input type="radio" name="data[isblack]" value="0" <?php  if($member['isblack']==0) { ?>checked<?php  } ?>>否</label>
                    <span class="help-block">设置黑名单后，此会员无法访问商城</span>
                  
                    
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">备注</label>
                <div class="col-sm-9 col-xs-12">
                  
                    <textarea name="data[content]" class='form-control'><?php  echo $member['content'];?></textarea>
                   
                </div>
            </div>
        </div>

		
       

        <?php  if($hascommission) { ?>
        <div class='panel-heading'>
            设置分销商 <small>注意: 分销商设置后，无法再此进行修改，如果要修改，请联系系统管理员</small>
        </div>
           <div class='panel-body'>
<div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">上级分销商</label>
                    <div class="col-sm-4">
                       <input type="hidden" value="<?php  echo $member['agentid'];?>" id='agentid' name='adata[agentid]' class="form-control"  />
                        
                 
                        <div class='input-group'>
                            <input type="text" name="parentagent" maxlength="30" value="<?php  if(!empty($parentagent)) { ?><?php  echo $parentagent['nickname'];?>/<?php  echo $parentagent['realname'];?>/<?php  echo $parentagent['mobile'];?><?php  } ?>" id="parentagent" class="form-control" readonly />
                            <div class='input-group-btn'>
                                <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus-notice').modal();">选择上级分销商</button>
                                <button class="btn btn-danger" type="button" onclick="$('#agentid').val('');$('#parentagent').val('');$('#parentagentavatar').hide()">清除选择</button>
                            </div> 
                        </div>
                        <span id="parentagentavatar" class='help-block' <?php  if(empty($parentagent)) { ?>style="display:none"<?php  } ?>><img  style="width:100px;height:100px;border:1px solid #ccc;padding:1px" src="<?php  echo $parentagent['avatar'];?>" onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'"/></span>
                         
                        <div id="modal-module-menus-notice"  class="modal fade" tabindex="-1">
                            <div class="modal-dialog" style='width: 920px;'>
                                <div class="modal-content">
                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择上级分销商</h3></div>
                                    <div class="modal-body" >
                                        <div class="row">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="keyword" value="" id="search-kwd-notice" placeholder="请输入分销商昵称/姓名/手机号" />
                                                <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_members();">搜索</button></span>
                                            </div>
                                        </div>
                                        <div id="module-menus-notice" style="padding-top:5px;"></div>
                                    </div>
                                    <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                </div>

                            </div>
                        </div>
                        <span class="help-block">修改后， 只有关系链改变, 以往的订单佣金都不会改变,新的订单才按新关系计算佣金 ,请谨慎选择</span>
                    
                        
                    </div>
                </div>
            
			     <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否固定上级</label>
                <div class="col-sm-9 col-xs-12">
              
                    <label class="radio-inline"><input type="radio" name="adata[fixagentid]" value="1" <?php  if($member['fixagentid']==1) { ?>checked<?php  } ?>>是</label>
                    <label class="radio-inline" ><input type="radio" name="adata[fixagentid]" value="0" <?php  if($member['fixagentid']==0) { ?>checked<?php  } ?>>否</label>
                    <span class="help-block">固定上级后，任何条件也无法改变其上级，如果不选择上级分销商，且固定上级，则上级永远为总店（是分销商）或无上线（非分销商）</span>
                
                    
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
			   
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销商等级</label>
               <div class="col-sm-9 col-xs-12">
                   
                    <select name='adata[agentlevel]' class='form-control'>
                        <option value='0'><?php echo empty($plugin_com_set['levelname'])?'普通等级':$plugin_com_set['levelname']?></option>
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
			   <?php  if($member['agenttime']!='1970-01-01 08:00') { ?>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">成为分销商时间</label>
                <div class="col-sm-9 col-xs-12">
                    <div class='form-control-static'><?php  echo $member['agenttime'];?></div> 
                </div>
            </div>
			   <?php  } ?>
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">分销商权限</label>
                <div class="col-sm-9 col-xs-12">
                   
                    <label class="radio-inline"><input type="radio" name="adata[isagent]" value="1" <?php  if($member['isagent']==1) { ?>checked<?php  } ?>>是</label>
                    <label class="radio-inline" ><input type="radio" name="adata[isagent]" value="0" <?php  if($member['isagent']==0) { ?>checked<?php  } ?>>否</label>
                 
                    
                </div>
            </div>
                      <?php if(false){?>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">审核通过</label>
                <div class="col-sm-9 col-xs-12">
               
                    <label class="radio-inline"><input type="radio" name="adata[status]" value="1" <?php  if($member['status']==1) { ?>checked<?php  } ?>>是</label>
                    <label class="radio-inline" ><input type="radio" name="adata[status]" value="0" <?php  if($member['status']==0) { ?>checked<?php  } ?>>否</label>
                    <input type='hidden' name='oldstatus' value="<?php  echo $member['status'];?>" />
                  
                </div>
            </div>
               <?php }?>
             <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">强制不自动升级</label>
                <div class="col-sm-9 col-xs-12">
                
                    <label class="radio-inline" ><input type="radio" name="adata[agentnotupgrade]" value="0" <?php  if($member['agentnotupgrade']==0) { ?>checked<?php  } ?>>允许自动升级</label>
                    <label class="radio-inline"><input type="radio" name="adata[agentnotupgrade]" value="1" <?php  if($member['agentnotupgrade']==1) { ?>checked<?php  } ?>>强制不自动升级</label>
                    <span class="help-block">如果强制不自动升级，满足任何条件，此分销商的级别也不会改变</span>
                  
                </div>
            </div>
        
       
        </div>
        <?php  } ?>
        <div class='panel-body'>
          <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                <div class="col-sm-9 col-xs-12">

                  <input type="submit" name="submit" value="提交" class="btn btn-primary" />
	<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
               
                <input type="button" class="btn btn-default" name="submit" onclick="history.go(-1)" value="返回列表" style='margin-left:10px;' />
                </div>
            </div>
         </div>

    </div>   
	
</form>
<?php  } ?>
<script language='javascript'>
    
         function search_members() {
             if( $.trim($('#search-kwd-notice').val())==''){
                 Tip.focus('#search-kwd-notice','请输入关键词');
                 return;
             }
		$("#module-menus-notice").html("正在搜索....")
		$.get('<?php  echo $this->createWebUrl('commission/agent')?>', {
			keyword: $.trim($('#search-kwd-notice').val()),'op':'query',selfid:"<?php  echo $id;?>"
		}, function(dat){
			$('#module-menus-notice').html(dat);
		});
	}
	function select_member(o) {
		$("#agentid").val(o.id);
                  $("#parentagentavatar").show();
                  $("#parentagentavatar").find('img').attr('src',o.avatar);
		$("#parentagent").val( o.nickname+ "/" + o.realname + "/" + o.mobile );
		$("#modal-module-menus-notice .close").click();
	}
        
    </script>
<?php include page("footer-base");?>