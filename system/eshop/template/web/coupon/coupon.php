<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<?php  if($operation=='display') { ?>
        <form  method="get" class="form-horizontal" role="form" id="form1">
            <input type="hidden" name="mod" value="site" />
            <input type="hidden" name="m" value="eshop" />
            <input type="hidden" name="do" value="coupon" />
            <input type="hidden" name="act" value="coupon" />
            <input type="hidden" name="op" value="display" />
            <input type="hidden" name="beid" value="<?php echo $GLOBALS['_CMS']['beid'];?>" />
            
<div class="panel ">
    	<h3 class="custom_page_header"> 优惠券管理
    		            
                   
                  <a class='btn btn-default' href="<?php  echo $this->createWebUrl('coupon/coupon',array('op'=>'post'))?>"><i class='fa fa-plus'></i> 添加购物优惠券</a>
     <input name="submit" type="submit" class="btn btn-primary" value="保存排序">
                  
    		</h3>
    <div class="panel-body">

            <div class="form-group">
              
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">优惠券名</label>
                <div class="col-sm-3 ">
                    <input type="text" class="form-control"  name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder='可搜索优惠券名称'/> 
                </div>
                     
               
                    <label class="col-xs-12 col-sm-2 col-md-2 col-lg-2 control-label">领取中心是否显示</label>
              <div class="col-sm-3">
                    <select name='gettype' class='form-control'>
                        <option value=''></option>
                        <option value='0' <?php  if($_GPC['gettype']=='0') { ?>selected<?php  } ?>>不显示</option>
                        <option value='1' <?php  if($_GPC['gettype']=='1') { ?>selected<?php  } ?>>显示</option>
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
                           <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d', $starttime),'endtime'=>date('Y-m-d ', $endtime)),true);?>
                    
                     </div>
                       
            			</div>
                     <div class="col-sm-4 col-lg-4 col-xs-4">
                           <button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                       
                    </div>
                         
                </div>
                
   
    </div>
    
   
    <div class="panel-body">
    
    	
        <table class="table table-hover table-responsive">
            <thead class="navbar-inner" >
                <tr>
                     <th style="width:80px;">排序</th>
                     <th>优惠券名称</th>
 <th >使用条件/优惠</th>
		  <th >已使用/已发出<br/>/剩余数量</th>
		  <th>领取中心</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
					  <td>
			 
                           <input type="text" class="form-control" name="displayorder[<?php  echo $row['id'];?>]" value="<?php  echo $row['displayorder'];?>">
                 
						</td>
                
		    <td><?php  if($row['coupontype']==0) { ?>
				  <label class='label label-success'>购物</label>
						  <?php  } else { ?>
						  <label class='label label-warning'>充值</label>
					 <?php  } ?>
					 <br/><?php  echo $row['couponname'];?>
					  </td>
					  <td><?php  if($row['enough']>0) { ?>
						  <label class="label label-danger">满<?php  echo $row['enough'];?>可用</label>
						  <?php  } else { ?>
						    <label class="label label-warning">不限</label>
						  <?php  } ?>
					 
						  <br/><?php  if($row['backtype']==0) { ?>
						  立减 <?php  echo $row['deduct'];?> 元
						  <?php  } else if($row['backtype']==1) { ?>
						  打 <?php  echo $row['discount'];?> 折
						  <?php  } else if($row['backtype']==2) { ?>
						  <?php  if($row['backmoney']>0) { ?>返 <?php  echo $row['backmoney'];?> 余额;<?php  } ?>
						  <?php  if($row['backcredit']>0) { ?>返 <?php  echo $row['backcredit'];?> 积分;<?php  } ?>
						  <?php  } ?>
					 </td>
					 
                    <td>
                                   
                                           <a href="<?php  echo $this->createWebUrl('coupon/log',array('coupon'=>$row['id']))?>">
                                            已使用:      <?php  echo $row['usetotal'];?>  <br/>已发出: <?php  echo $row['gettotal'];?> <br/>无限数量<?php  if($row['total']==-1) { ?><?php  } else { ?><?php  echo $row['total'] -  $row['gettotal']?><?php  } ?>
                                            </a>
                                        
                                      
                     <td><?php  if($row['gettype']==0) { ?>
						 <label class="label label-default">不显示</label>
						 <?php  } else { ?>
						 
						 <?php  if($row['credit']>0 || $row['money']>0) { ?>
						 <?php  if($row['credit']>0) { ?><label class='label label-primary'><?php  echo $row['credit'];?> 积分</label><br/><?php  } ?>
						 <?php  if($row['money']>0) { ?><label class='label label-danger'><?php  echo $row['money'];?> 现金</label><br/><?php  } ?>
						 <?php  } else { ?>
						 <label class='label label-warning'>免费</label>
						 <?php  } ?>
					 <?php  } ?>
					 </td>
					<td><?php  echo date('Y-m-d',$row['createtime'])?></td>
					<td >
				<p>		<a target="_blank" href="<?php  echo $this->createMobileUrl('coupon/detail', array('id' => $row['id']))?>"  title="预览" class="btn btn-default btn-sm js-clip"><i class="fa fa-link"></i>预览</a>
						
                    
                              <a class='btn btn-default btn-sm' href="<?php  echo $this->createWebUrl('coupon/coupon',array('op'=>'post','id' => $row['id']));?>" title="编辑" ><i class='fa fa-edit'></i>编辑</a>
							 
                   </p> <p>
                    
                              <a class='btn btn-default  btn-sm' href="<?php  echo $this->createWebUrl('coupon/coupon',array('op'=>'delete','id' => $row['id']));?>" title="删除" onclick="return confirm('确定要删除该优惠券吗？');"><i class='fa fa-remove'></i>删除</a>
							 
                
                        
                 
                              <a  class='btn btn-primary  btn-sm' href="<?php  echo $this->createWebUrl('coupon/send',array('couponid' => $row['id']));?>" title="发放优惠券" ><i class='fa fa-send'></i>发放</a>
							
               </p> 
               
                    </td>
                </tr>
                <?php  } } ?>
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div>
    
</div>
			     </form>
<?php  } else if($operation=='post') { ?>

<form action="" method='post' class='form-horizontal'>
    <input type="hidden" name="id" value="<?php  echo $item['id'];?>">
    <input type="hidden" name="op" value="detail">
    <input type="hidden" name="mod" value="site" />
    <input type="hidden" name="m" value="eshop" />
    <input type="hidden" name="act" value="coupon" />
    <input type="hidden" name="do" value="coupon" />
    <input type="hidden" name="op" value="post" />
    <input type="hidden" name="beid" value="<?php echo $GLOBALS['_CMS']['beid'];?>" />
    <div class='panel panel-default'>
      
        
	<h3 class="custom_page_header">  编辑购物优惠券	</h3>

   <div class='panel-body'>
        <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
               <div class="col-sm-5">
                    <input type="text" name="displayorder" class="form-control" value="<?php  echo $item['displayorder'];?>"  />
		 <span class='help-block'>数字越大越靠前</span>
                    
                </div>
        </div>
	 
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 优惠券名称</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="couponname" class="form-control" value="<?php  echo $item['couponname'];?>"  />
                  
                </div>
        </div>
 
			
   
							  <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">缩略图</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php  echo tpl_form_field_image('thumb', $item['thumb'])?>
                       
                    </div>
                </div>
         <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">使用条件</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="enough" class="form-control" value="<?php  echo $item['enough'];?>"  />
                    <span class='help-block' >消费满多少可用, 空或0 不限制</span>
                
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">使用时间限制</label>
                
                    <div class="col-sm-3">
                    <div class='input-group'>
                        <span class='input-group-addon'>
                             <label class="radio-inline" style='margin-top:-5px;' ><input type="radio" name="timelimit" value="0" <?php  if($item['timelimit']==0) { ?>checked<?php  } ?>>获得后</label>
                        </span>
                   
                     <input type='text' class='form-control' name='timedays' value="<?php  echo $item['timedays'];?>" />
                     <span class='input-group-addon'>天内有效</span>
                      </div>
                     </div>
                    
                     <div class="col-sm-2">
                    <div class='input-group'>
                        <span class='input-group-addon'>
                             <label class="radio-inline" style='margin-top:-5px;' ><input type="radio" name="timelimit" value="1" <?php  if($item['timelimit']==1) { ?>checked<?php  } ?>>日期</label>
                        </span>
                         <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d', $starttime),'endtime'=>date('Y-m-d', $endtime)));?>
                          <span class='input-group-addon'>内有效</span>
                      </div>
                     </div>
                
            </div>
			<?php include $this->template("coupon/consume");?>

			

<div class="form-group">
    <label class="col-xs-12 col-sm-3 col-md-2 control-label">领券中心是否可获得</label>
    <div class="col-sm-9 col-xs-12" >
        <label class="radio-inline">
            <input type="radio" name="gettype" value="0" <?php  if($item['gettype'] == 0) { ?>checked="true"<?php  } ?>  onclick="$('.gettype').hide()"/> 不可以
        </label>
		          <label class="radio-inline">
            <input type="radio" name="gettype" value="1" <?php  if($item['gettype'] == 1) { ?>checked="true"<?php  } ?> onclick="$('.gettype').show()" /> 可以
        </label>
		  <span class='help-block'>会员是否可以在领券中心直接领取或购买</span>
		
         
    </div>
</div>
	     <div class="form-group gettype" <?php  if($item['gettype']!=1) { ?>style="display:none"<?php  } ?>>
                        <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
                        <div class="col-sm-9">
                            <div class="input-group">
			  <span class="input-group-addon">每个限领</span>
			  <input type='text' class='form-control' value="<?php  echo $item['getmax'];?>" name='getmax'/>
                                <span class="input-group-addon">张 消耗</span>
                             <input type='text' class='form-control' value="<?php  echo $item['credit'];?>" name='credit'/>
                             <span class="input-group-addon">积分 + 花费</span>
                                <input type='text' class='form-control' value="<?php  echo $item['money'];?>" name='money'/>
                              <span class="input-group-addon">元&nbsp;&nbsp;
                                  <label class="checkbox-inline" style='margin-top:-8px;'>
                                    <input type="checkbox" name='usecredit2' value="1" <?php  if($item['usecredit2']==1) { ?>checked<?php  } ?> /> 优先使用余额支付
                                </label>
                              </span></div>
                              <span class="help-block">每人限领，空不限制，领取方式可任意组合，可以单独积分兑换，单独现金兑换，或者积分+现金形式兑换, 如果都为空，则可以免费领取</span>
                                                
                             </div>
      
                    </div>
		　                    
         <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">发放总数</label>
                <div class="col-sm-9 col-xs-12">
                    <input type="text" name="total" class="form-control" value="<?php  echo $item['total'];?>"  />
                    <span class='help-block' >优惠券总数量，没有不能领取或发放,-1 为不限制张数</span>
                 
                </div>
   </div>
	 
	 
	 
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
<script language='javascript'>
    
    function showbacktype(type){
 
        $('.backtype').hide();
        $('.backtype' + type).show();
    }
	$(function(){
		
		$('form').submit(function(){
			
			if($(':input[name=couponname]').isEmpty()){
				Tip.focus($(':input[name=couponname]'),'请输入优惠券名称!');
				return false;
			}
			var backtype = $(':radio[name=backtype]:checked').val();
			if(backtype=='0'){
				if($(':input[name=deduct]').isEmpty()){
					Tip.focus($(':input[name=deduct]'),'请输入立减多少!');
					return false;
				}
			}else if(backtype=='1'){
				if($(':input[name=discount]').isEmpty()){
					Tip.focus($(':input[name=discount]'),'请输入折扣多少!');
					return false;
				}
			}else if(backtype=='2'){
				if($(':input[name=backcredit]').isEmpty() && $(':input[name=backmoney]').isEmpty() ){
					Tip.focus($(':input[name=backcredit]'),'至少输入一种返利!');
					return false;
				}
			}
			return true;
		})
		
	})
</script>
	
<?php  } ?>
<?php include page("footer-base");?>