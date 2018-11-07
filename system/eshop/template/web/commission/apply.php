<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<?php  if($operation=='display') { ?>
<div class="panel">
    
	 <h3 class="custom_page_header"> 待审核提现申请</h3>
    <div class="panel-body">
        <form action="" method="get" class="form-horizontal" role="form" id="form1">
            <input type="hidden" name="mod" value="site" />
            <input type="hidden" name="m" value="eshop" />
            <input type="hidden" name="do" value="commission" />
            <input type="hidden" name="act" value="apply" />
            <input type="hidden" name="op" value="display" />
            <input type="hidden" name="beid" value="<?php echo $GLOBALS['_CMS']['beid'];?>" />
            <input type="hidden" name="status" value="<?php  echo $status;?>" />
           
               
                  <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">提现单号</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control"  name="applyno" value="<?php  echo $_GPC['applyno'];?>"/> 
                </div> 
                
                  <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">会员信息</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control"  name="realname" value="<?php  echo $_GPC['realname'];?>" placeholder="可搜索昵称/姓名/手机号/会员ID"/> 
                </div>
                
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">等级</label>
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
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">按时间</label>
                     <div class="col-sm-2">
                       <select name='timetype' class='form-control'>
                          <option value=''>不搜索</option>
                           <?php  if($status>=1) { ?><option value='applytime' <?php  if($_GPC['timetype']=='applytime') { ?>selected<?php  } ?>>申请时间</option><?php  } ?>
                           <?php  if($status>=2) { ?><option value='checktime' <?php  if($_GPC['timetype']=='checktime') { ?>selected<?php  } ?>>审核时间</option><?php  } ?>
                           <?php  if($status>=3) { ?><option value='paytime' <?php  if($_GPC['timetype']=='paytime') { ?>selected<?php  } ?>>打款时间</option><?php  } ?>
                       </select> 
                     </div>
                    
                    <div class="col-sm-7 col-lg-9 col-xs-12">
                     
                        <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d H:i', $starttime),'endtime'=>date('Y-m-d  H:i', $endtime)),true);?>
                    </div>
                </div>
                 
			
	 <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label"></label>
                <div class="col-sm-8 col-lg-9 col-xs-12">
                       <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
					   
	
                        <button type="submit" name="export" value="1" class="btn btn-primary">导出 Excel</button>
         
						
                </div>
                 
            </div>
 
        </form>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">总数：<?php  echo $total;?></div>
    <div class="panel-body">
        <table class="table table-hover">
            <thead class="navbar-inner">
                <tr>
                    <th style='width:190px;'>提现单号</th>
                    <th >粉丝/姓名</th>
                    <th >手机号码</th>
                    <th >分销等级</th>
                    <th>提现方式</th>
                    <th >申请佣金</th>
                     <?php  if($status>=1) { ?>
                    <th >申请时间</th>
                    <?php  } ?>
                    <?php  if($status>=2) { ?>
                    <th >审核时间</th>
                    <?php  } ?>
                    <?php  if($status>=3) { ?>
                    <th >打款时间</th>
                    <?php  } ?>
                       <?php  if($status==-1) { ?>
                    <th 设置无效时间</th>
                    <?php  } ?>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td><?php  echo $row['applyno'];?></td>
                    <td><img src='<?php  echo $row['avatar'];?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' /> <?php  echo $row['nickname'];?><br/>姓名：<?php  echo $row['realname'];?></td>
                    <td><?php  echo $row['mobile'];?></td>
                    <td><?php  echo $row['levelname'];?></td>
                    <td><?php  echo $row['typestr'];?><br/>(微信号:<?php  echo $row['weixin'];?>)</td>
                    <td><?php  echo $row['commission'];?></td>
                     <?php  if($status>=1) { ?>
                     <td><?php  echo $row['applytime'];?></td>
                     <?php  } ?>
                     <?php  if($status>=2) { ?>
                    <td><?php  echo $row['checktime'];?></td>
                     <?php  } ?>
                    <?php  if($status>=3) { ?>
                    <td><?php  echo $row['paytime'];?></td>
                    <?php  } ?>
                        <?php  if($status==-1) { ?>
                    <td><?php  echo $row['invalidtime'];?></td>
                    <?php  } ?>
                     <td>
                        <a class='btn btn-default' href="<?php  echo $this->createWebUrl('commission/apply/detail',array('id' => $row['id']));?>">详情</a>		
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
            <input type="hidden" name="mod" value="site" />
            <input type="hidden" name="m" value="eshop" />
            <input type="hidden" name="do" value="commission" />
            <input type="hidden" name="act" value="apply" />
            <input type="hidden" name="op" value="detail" />
            <input type="hidden" name="beid" value="<?php echo $GLOBALS['_CMS']['beid'];?>" />
    <input type="hidden" name="id" value="<?php  echo $apply['id'];?>" />
    <div class="panel panel-default">
       <h3 class="custom_page_header"> 提现者信息</h3>
    <div class='panel-body'>
    <div style='height:auto;width:120px;float:left;'>
         <img src='<?php  echo $member['avatar'];?>' style='width:100px;height:100px;border:1px solid #ccc;padding:1px' />
    </div>
    <div style='float:left;height:auto;overflow: hidden'>
        <p><b>昵称:</b> <?php  echo $member['nickname'];?>    <b>姓名:</b> <?php  echo $member['realname'];?>  <b>手机号:</b> <?php  echo $member['mobile'];?>    <b>微信号:</b> <?php  echo $member['weixin'];?></p>
        <p><b>分销等级:</b>  <?php  echo $agentLevel['levelname'];?> (
         <?php  if($set['level']>=1) { ?>一级比例: <span style='color:blue'><?php  echo $agentLevel['commission1'];?>%</span><?php  } ?>
         <?php  if($set['level']>=2) { ?>二级比例: <span style='color:blue'><?php  echo $agentLevel['commission2'];?>%</span><?php  } ?>
         <?php  if($set['level']>=3) { ?>三级比例: <span style='color:blue'><?php  echo $agentLevel['commission3'];?>%</span><?php  } ?>
        )</p>
        <p>
        <b>下级:</b> 总共 <span style='color:red'><?php  echo $member['agentcount'];?></span> 人 
        <?php  if($set['level']>=1) { ?><b>一级:</b><span style='color:red'><?php  echo $member['level1'];?></span>  人<?php  } ?>  
        <?php  if($set['level']>=2) { ?><b>二级:</b> <span style='color:red'><?php  echo $member['level2'];?></span>  人<?php  } ?> 
        <?php  if($set['level']>=3) { ?><b>三级: </b><span style='color:red'><?php  echo $member['level3'];?></span> 人<?php  } ?>
                点击:  <span style='color:red'><?php  echo $member['clickcount'];?></span> 次 
       
                <b>累计佣金: </b><span style='color:red'><?php  echo $member['commission_total'];?></span> 元  
                <b>待审核佣金: </b><span style='color:red'><?php  echo $member['commission_apply'];?></span> 元  
                <b>待打款佣金: </b><span style='color:red'><?php  echo $member['commission_check'];?></span> 元  
                <b>结算期佣金: </b><span style='color:red'><?php  echo $member['commission_lock'];?></span> 元  </p>
      <p>
                <b>申请佣金: </b><span style='color:red'><?php  echo $apply['commission'];?></span> 元  
                <b>打款方式: </b>
                <?php  if(empty($apply['type'])) { ?>
                <span class='label label-primary'>余额</span>
                <?php  } else { ?>
                <span class='label label-success'>微信</span>(微信号:<?php  echo $member['weixin'];?>)
                <?php  } ?>

      </p>
      <p>
                <b>状态: </b>
                <?php  if($apply['status']==1) { ?>
                <span class='label label-primary'>申请中</span>
                <?php  } else if($apply['status']==2) { ?>
                <span class='label label-success'>审核完毕，准备打款</span>
                <?php  } else if($apply['status']==3) { ?>
                <span class='label label-warning'>已打款</span>
                <?php  } ?>
                <?php  if($apply['status']>=1) { ?><b>申请时间: </b> <?php  echo date('Y-m-d H:i', $apply['applytime'])?><?php  } ?>
                 <?php  if($apply['status']>=2) { ?><b>审核时间: </b> <?php  echo date('Y-m-d H:i', $apply['checktime'])?><?php  } ?>
                  <?php  if($apply['status']>=3) { ?><b>打款时间: </b> <?php  echo date('Y-m-d H:i', $apply['paytime'])?><?php  } ?>
      </p>
    </div>
        </div>
 
        <div class='panel-heading'>
            提现申请订单信息 共计 <span style="color:red; "><?php  echo $totalcount;?></span> 个订单 , 金额共计 <span style="color:red; "><?php  echo $totalmoney;?></span> 元 佣金总计 <span style="color:red; "><?php  echo $totalcommission;?></span> 元
            <?php  if($status==1 ) { ?>
            <a href="javascript:;" onclick="checkall(true)" class="btn btn-success">批量审核通过</a>
            <a href="javascript:;" onclick="checkall(false)" class="btn btn-danger">批量审核不通过</a>
			<?php  } ?>
        </div>
        <div class='panel-body'>
            <table class="table table-hover">
                       <thead class="navbar-inner">
                           <tr>
                               <th>订单号</th>
                               <th>总金额</th>
                               <th>商品金额</th>
                               <th>运费</th>
                               <th>付款方式</th>
                           
                               <th>下单时间</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php  if(is_array($list)) { foreach($list as $row) { ?>
                           <tr  style="background: #eee">
                               <td><?php  echo $row['ordersn'];?></td>
                               <td><?php  echo $row['price'];?></td>
                               <td><?php  echo $row['goodsprice'];?></td>
                               <td><?php  echo $row['dispatchprice'];?></td>
                               <td><?php  if($row['paytype'] == 1) { ?>
                                          <span class="label label-danger">余额支付</span>
                                             <?php  } else if($row['paytype'] == 11) { ?>
                                          <span class="label label-default">后台付款</span>
                                      <?php  } else if($row['paytype'] == 21) { ?>
                                          <span class="label label-success">在线支付</span>
                                          <?php  } else if($row['paytype'] == 22) { ?>
                                          <span class="label label-danger">支付宝支付</span>
                                            <?php  } else if($row['paytype'] == 22) { ?>
                                          <span class="label label-primary">银联支付</span>
                                      <?php  } else if($row['paytype'] == 3) { ?>
                                      <span class="label label-primary">货到付款</span>
                                    <?php  } ?>
                               </td>
              
                               <td><?php  echo date('Y-m-d H:i',$row['createtime'])?></td>   
                           </tr>	
                           <tr >

                               <td colspan="6">
                                   <table width="100%">
                    <thead class="navbar-inner">
                                             <tr>
                                                 <th style='width:60px;'>商品</th>
                                                 <th></th>
                                                 <th>单价</th>
                                                 <th>数量</th>
                                                 <th>总价</th>
                                                 <th>佣金</th>
                                                
                                             </tr>
                                         </thead>
                                       <tbody>
                                           <?php  if(is_array($row['goods'])) { foreach($row['goods'] as $g) { ?>
                                           <tr>
                                               <td style='height:60px;'><img src="<?php  echo tomedia($g['thumb'])?>" style="width: 50px; height: 50px;border:1px solid #ccc;padding:1px;"></td>
                                               <td><span><?php  echo $g['title'];?></span><br/><span><?php  echo $g['optionname'];?></span>
                                               </td>
                                               <td>原价: <?php  echo $g['price']/$g['total']?><br/>折扣后:<?php  echo $g['realprice']/$g['total']?></td>
                                               <td><?php  echo $g['total'];?></td>
                                               <td><strong>原价:<?php  echo round($g['price'],2)?><br/>折扣后:<?php  echo round($g['realprice'],2)?></strong></td>
                                               <td>
                                                   <?php  if($set['level']>=1 && $row['level']==1) { ?><p>
                                                   <div class='input-group'>
                                                       <span class='input-group-addon'>一级佣金</span>
                                                     <span class='input-group-addon' style='background:#fff;width:80px;'><?php  echo $g['commission1'];?></span>
                                                       <span class='input-group-addon'>状态</span>    
                                                       <span class='input-group-addon' style='background:#fff'>
                                                             <?php  if($g['status1']==-1) { ?>
                                                                <span class='label label-default'>未通过</span>
                                                                <?php  } else if($g['status1']==1) { ?>

                                                                <label class='radio-inline'><input type='radio'  class='status1' value='-1'  name="status1[<?php  echo $g['id'];?>]" /> 不通过</label>
                                                                <label class='radio-inline'><input type='radio'  value='2'   name="status1[<?php  echo $g['id'];?>]"  /> 通过</label>

                                                                <?php  } else if($g['status1']==2) { ?>
                                                                <span class='label label-success'>通过</span>
                                                                <?php  } else if($g['status1']==3) { ?>
                                                                <span class='label label-warning'>已打款</span>
                                                                <?php  } ?>
                                                          </span>
                                                        <span class='input-group-addon'>备注</span>  
                                                        <input type='text' class='form-control' name='content1[<?php  echo $g['id'];?>]' style='width:200px;' value="<?php  echo $g['content1'];?>">
                                                   </div></p>
                                                   <?php  } ?>
                                                   
                                                   <?php  if($set['level']>=2  && $row['level']==2) { ?><p>
                                              
                                                   <div class='input-group'>
                                                       <span class='input-group-addon'>二级佣金</span>
                                                       <span class='input-group-addon' style='background:#fff;width:80px;'><?php  echo $g['commission2'];?></span>
                                                       <span class='input-group-addon'>状态</span>    
                                                       <span class='input-group-addon' style='background:#fff'>
                                                             <?php  if($g['status2']==-1) { ?>
                                                                <span class='label label-default'>未通过</span>
                                                                <?php  } else if($g['status2']==1) { ?>

                                                                <label class='radio-inline'><input type='radio' class='status2' value='-1'  name="status2[<?php  echo $g['id'];?>]" /> 不通过</label>
                                                                <label class='radio-inline'><input type='radio'  value='2'  name="status2[<?php  echo $g['id'];?>]"  /> 通过</label>

                                                                <?php  } else if($g['status2']==2) { ?>
                                                                <span class='label label-success'>通过</span>
                                                                <?php  } else if($g['status2']==3) { ?>
                                                                <span class='label label-warning'>已打款</span>
                                                                <?php  } ?>
                                                          </span>
                                                        <span class='input-group-addon'>备注</span>  
                                                        <input type='text' class='form-control' name='content2[<?php  echo $g['id'];?>]' style='width:200px;' value="<?php  echo $g['content2'];?>">
                                                   </div>
                                               </p>
                                                   <?php  } ?>
                                                   <?php  if($set['level']>=2  && $row['level']==3) { ?><p>
                                                    
                                                   <div class='input-group'>
                                                       <span class='input-group-addon'>三级佣金</span>
                                                      <span class='input-group-addon' style='background:#fff;width:80px;'><?php  echo $g['commission3'];?></span>
                                                       <span class='input-group-addon'>状态</span>    
                                                       <span class='input-group-addon' style='background:#fff'>
                                                             <?php  if($g['status3']==-1) { ?>
                                                                <span class='label label-default'>未通过</span>
                                                                <?php  } else if($g['status3']==1) { ?>

                                                                <label class='radio-inline'><input type='radio' class='status3' value='-1' name="status3[<?php  echo $g['id'];?>]" /> 不通过</label>
                                                                <label class='radio-inline'><input type='radio' value='2' name="status3[<?php  echo $g['id'];?>]"  /> 通过</label>

                                                                <?php  } else if($g['status3']==2) { ?>
                                                                <span class='label label-success'>通过</span>
                                                                <?php  } else if($g['status3']==3) { ?>
                                                                <span class='label label-warning'>已打款</span>
                                                                <?php  } ?>
                                                          </span>
                                                        <span class='input-group-addon'>备注</span>  
                                                        <input type='text' class='form-control' name='content3[<?php  echo $g['id'];?>]' style='width:200px;'  value="<?php  echo $g['content3'];?>">
                                                   </div>
                                                        </p>
                                                   <?php  } ?>
                                               </td>
                                           </tr>
                                           <?php  } } ?>
                                       </tbody></table>	   
                               </td></tr>	
                       <?php  } } ?>
                   </table>
        </div>

  <?php  if($apply['status']==2) { ?>
     <div class='panel-heading'>
            打款信息
     </div>
    <div class='panel-body'>
        此次佣金总额:  <span style='color:red'><?php  echo $totalcommission;?></span> 元    应该打款：<span style='color:red'><?php  echo $totalpay;?></span> 元 
    </div>
  <?php  } ?>
  
   <?php  if($apply['status']==3) { ?>
     <div class='panel-heading'>
            打款信息
     </div>
    <div class='panel-body'>
         此次佣金总额:  <span style='color:red'><?php  echo $totalcommission;?></span> 元    实际打款：<span style='color:red'><?php  echo $totalpay;?></span> 元 
    </div>
  <?php  } ?>
  
            </div>  
        <div class="form-group col-sm-12">
        <?php  if($apply['status']==1) { ?>
  
        <input type="submit" name="submit_check" value="提交审核" class="btn btn-primary col-lg-1" onclick='return check()'/>
 
        <?php  } ?>
        
         <?php  if($apply['status']==2) { ?>
        
    
        <input type="submit" name="submit_cancel" value="重新审核" class="btn btn-default col-lg-1"  onclick='return cancel()'/>
  
           
             <input type="submit" name="submit_pay" value="打款到微信" class="btn btn-primary col-lg-1"  style='margin-left:10px;' onclick='return pay_weixin()'/>
             <input type="submit" name="submit_pay2" value="打款到余额" class="btn btn-warning col-lg-1"  style='margin-left:10px;' onclick='return pay_credit()'/>
        
         
        <?php  } ?>
        <?php  if($apply['status']==-1) { ?>
         
            <input type="submit" name="submit_cancel" value="重新审核" class="btn btn-default col-lg-1"  onclick='return cancel()'/>
   
     
        <?php  } ?>
        
        <input type="button" class="btn btn-default" name="submit" onclick="history.go(-1)" value="返回" style='margin-left:10px;' />
        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
    </div>
</form>
<script language='javascript'>
function checkall(ischeck){
 var val =  ischeck?2:-1;
 
     $('.status1,.status2,.status3').each(function(){
        $(this).closest('.input-group-addon').find(":radio[value='" + val + "']").get(0).checked = true;
     });
}
    function check(){
    var pass  = true;
     $('.status1,.status2,.status3').each(function(){
       if( !$(this).get(0).checked && !$(this).parent().next().find(':radio').get(0).checked){
         Tip.focus( $(this),'请选择审核状态!' );
         pass = false;
         return false;
       }
     });
     if(!pass){ 
          return false;
     }
     return confirm('确认已核实成功并要提交?\r\n(提交后还可以撤销审核状态, 申请将恢复到申请状态)');
    }
        function cancel(){
           return confirm('确认撤销审核?\r\n( 所有状态恢复到申请状态)'); 
        }
        function pay_credit(){
           return confirm('确认打款到此用户的余额账户?');  
        } function pay_weixin(){
           return confirm('确认打款到此用户的微信号?');  
        }function pay_manual(){
           return confirm('确认手动打款?');  
        }
      
</script>


<?php  } ?>
<?php include page("footer-base");?>