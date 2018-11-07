<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<div class="panel">
    
           <h3 class="custom_page_header"><?php  if(empty($_GPC['type'])){?>充值记录<?php  }?><?php  if($_GPC['type']==1){?>提现申请<?php  }?> </h3>
    <div class="panel-body">
        <form action="" method="get" class="form-horizontal" role="form" id="form1">
            <input type="hidden" name="mod" value="site" />
            <input type="hidden" name="m" value="eshop" />
            <input type="hidden" name="do" value="finance" />
            <input type="hidden" name="act" value="log" />
            <input type="hidden" name="type" value="<?php  echo $_GPC['type'];?>" />
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">会员信息</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control"  name="realname" value="<?php  echo $_GPC['realname'];?>" placeholder='可搜索会员昵称/姓名/手机号/会员ID'/> 
                </div>
                
             <?php  if($_GPC['type']==0) { ?> <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">充值单号</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control"  name="logno" value="<?php  echo $_GPC['logno'];?>" placeholder='可搜索充值单号'/> 
                </div><?php }?>
            </div>
             
           
 
             <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">会员等级</label>
                <div class="col-sm-4">
                       <select name='level' class='form-control'>
                        <option value=''></option>
                        <?php  if(is_array($levels)) { foreach($levels as $level) { ?>
                        <option value='<?php  echo $level['id'];?>' <?php  if($_GPC['level']==$level['id']) { ?>selected<?php  } ?>><?php  echo $level['levelname'];?></option>
                        <?php  } } ?>
                    </select>
                </div>
                  <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">会员分组</label>
                <div class="col-sm-4">
                       <select name='groupid' class='form-control'>
                        <option value=''></option>
                        <?php  if(is_array($groups)) { foreach($groups as $group) { ?>
                        <option value='<?php  echo $group['id'];?>' <?php  if($_GPC['groupid']==$level['id']) { ?>selected<?php  } ?>><?php  echo $group['groupname'];?></option>
                        <?php  } } ?>
                    </select>
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
                   
                    <label class="col-xs-2 col-sm-2 col-md-2 col-lg-1 control-label">状态：</label>
                   
                   
                     <div class="col-sm-3">
                       <select name='status' class='form-control'>
                         <option value='' <?php  if($_GPC['status']=='') { ?>selected<?php  } ?>></option>
                         <option value='1' <?php  if($_GPC['status']=='1') { ?>selected<?php  } ?>><?php  if($_GPC['type']==0) { ?>充值成功<?php  } else { ?>完成<?php  } ?></option>
                         <option value='0' <?php  if($_GPC['status']=='0') { ?>selected<?php  } ?>><?php  if($_GPC['type']==0) { ?>未充值<?php  } else { ?>申请中<?php  } ?></option>
                         <?php  if($_GPC['type']==1) { ?><option value='-1' <?php  if($_GPC['status']=='-1') { ?>selected<?php  } ?>>失败</option><?php  } ?>
                         
                    </select>
                </div>
                         
                </div>
	     
               
                   <div class="form-group"><?php  if($_GPC['type']==0) { ?>
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">充值方式</label>
                    <div class="col-sm-3">
                       <select name='rechargetype' class='form-control'>
                         <option value='' <?php  if($_GPC['rechargetype']=='') { ?>selected<?php  } ?>></option>
                         <option value='wechat' <?php  if($_GPC['rechargetype']=='wechat') { ?>selected<?php  } ?>>微信</option>
                         <option value='alipay' <?php  if($_GPC['rechargetype']=='alipay') { ?>selected<?php  } ?>>支付宝</option>
                         <option value='system' <?php  if($_GPC['rechargetype']=='system') { ?>selected<?php  } ?>>后台</option>
                         <option value='system1' <?php  if($_GPC['rechargetype']=='system1') { ?>selected<?php  } ?>>后台扣款</option>
                    </select>
                </div>
                <?php }else{ ?>  <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
               <?php } ?>
                <div class="col-sm-7">
                     <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
                         <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                    
                        <button type="submit" name="export" value="1" class="btn btn-primary">导出 Excel</button>
                    
                    </div>
               </div>
               
               
               
        </form>
    </div>
    <div class="panel-body ">
        <table class="table table-hover">
            <thead class="navbar-inner">
                <tr>
                    <th style='width:200px;'><?php  if($_GPC['type']==0) { ?>充值单号<?php  } else { ?>提现单号<?php  } ?></th>
                    <th >会员信息</th>
                    <th ><?php  if($_GPC['type']==1) { ?>提现金额<?php  } else { ?>充值金额<?php  } ?></th>
                    <?php  if($_GPC['type']==1) { ?><th >提现微信号</th><?php  } ?>
                    <th ><?php  if($_GPC['type']==1) { ?>提现时间<?php  } else { ?>充值时间<?php  } ?></th>
                    <?php  if($_GPC['type']==0) { ?><th style='width:80px;'>充值方式</th><?php  } ?>
                    <th style='width:80px;'>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                     <td><?php  if(!empty($row['logno'])) { ?>
                                <?php  if(strlen($row['logno'])<=22) { ?>
                                <?php  echo $row['logno'];?>
                                <?php  } else { ?>
                                recharge<?php  echo $row['id'];?>
                                <?php  } ?>
                         <?php  } else { ?>
                         recharge<?php  echo $row['id'];?>
                         <?php  } ?></td>
                    <td>头像：<img src='<?php  echo $row['avatar'];?>' onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" style='width:30px;height:30px;padding1px;border:1px solid #ccc' />
                    	<br/>昵称:<?php  echo $row['nickname'];?>
                    	<br/>姓名：<?php  echo $row['realname'];?><br/>手机号：<?php  echo $row['mobile'];?>
                    	</td>
                    <td><?php  echo $row['money'];?></td>
                    <td><?php  echo $row['weixin'];?></td>
                    <td><?php  echo date('Y-m-d',$row['createtime'])?><br/><?php  echo date('H:i:s',$row['createtime'])?></td>
                                            
    <?php  if($_GPC['type']==0) { ?>
    <td> 
        <?php  if($row['rechargetype']=='alipay') { ?>
        <span class='label label-warning'>支付宝</span>
        <?php  } else if($row['rechargetype']=='wechat') { ?>
        <span class='label label-success'>微信</span>
         <?php  } else if($row['rechargetype']=='system') { ?>
         <?php  if($row['money']>0) { ?>
        <span class='label label-primary'>后台</span>
        <?php  } else { ?>
        <span class='label label-default'>后台扣款</span>
        <?php  } ?>
        
        <?php  } ?>
    </td>
    <?php  } ?>
                    
                    <td>
                        <?php  if($row['status']==0) { ?>
                        <span class='label label-default'><?php  if($row['type']==1) { ?>申请中<?php  } else { ?>未充值<?php  } ?></span>
                        <?php  } else if($row['status']==1) { ?>
                        <span class='label label-success'><?php  if($row['type']==1) { ?>成功<?php  } else { ?>充值成功<?php  } ?></span>
                        <?php  } else if($row['status']==-1) { ?>
                        <span class='label label-warning'><?php  if($row['type']==1) { ?>拒绝<?php  } ?></span>
                          <?php  } else if($row['status']==3) { ?>
                        <span class='label label-danger'><?php  if($row['type']==0) { ?>充值退款<?php  } ?></span>
                        <?php  } ?>
                    </td> 
                    
                    <td>
                    
                        
                        <?php  if($row['type']==0 && $row['status']==1) { ?>
                              <?php  if($row['rechargetype']=='alipay' || $row['rechargetype']=='wechat') { ?>
                              
                                          <a class='btn btn-danger' onclick="return confirm('确认进行手动退款吗?')" href="<?php  echo $this->createWebUrl('finance/log',array('op'=>'pay','paytype'=>'refund','id' => $row['id']));?>">手动退款</a>		         
                              
                              <?php  } ?>
                        <?php  } ?>
                        <?php  if($row['type']==1 && $row['status']==0) { ?>
                      
                        <a class='btn btn-default' onclick="return confirm('确认手动提现到微信号?')" href="<?php  echo $this->createWebUrl('finance/log',array('op'=>'pay','paytype'=>'manual','id' => $row['id']));?>">手动提现到微信号</a>		
                        <a class='btn btn-default' onclick="return confirm('确认拒绝提现申请?')" href="<?php  echo $this->createWebUrl('finance/log',array('op'=>'pay','paytype'=>'refuse','id' => $row['id']));?>">拒绝</a>		
                  
                        <?php  } ?>
                     <a class='btn btn-default' href="<?php  echo $this->createWebUrl('member',array('act'=>'list','op'=>'detail','id' => $row['mid']));?>">用户信息</a>		
               
                    </td>
                </tr>
                <?php  } } ?>
            </tbody>
        </table>
           <?php  echo $pager;?>
    </div>
</div>
<?php include page("footer-base");?>