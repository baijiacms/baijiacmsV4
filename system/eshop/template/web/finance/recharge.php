<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

<?php  if($operation=='credit1') { ?>

<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
<div class="panel">
 
           <h3 class="custom_page_header">积分充值 </h3>
    <div class="panel-body">
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">粉丝</label>
                <div class="col-sm-9 col-xs-12">
                    <img src='<?php  echo $profile['avatar'];?>' onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" style='width:100px;height:100px;padding:1px;border:1px solid #ccc' />
                         <?php  echo $profile['nickname'];?>
                </div>
            </div>
           <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">OPENID</label>
                <div class="col-sm-9 col-xs-12">
                    <div class="form-control-static"><?php  echo $profile['openid'];?></div>
                </div>
            </div>
        
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员信息</label>
            <div class="col-sm-9 col-xs-12">
                <div class="form-control-static">姓名: <?php  echo $profile['realname'];?> / 手机号: <?php  echo $profile['mobile'];?></div>
            </div>
        </div>
        
         <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">当前积分</label>
            <div class="col-sm-9 col-xs-12">
                <div class="form-control-static"><?php  echo $profile['credit1'];?></div>
            </div>
        </div>
    
             <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">操作类型</label>
    <div class="col-sm-9 col-xs-12">
                     
                        <label class="radio radio-inline">
                              <input type="radio" name="credittype" value="0" checked=""> 充值积分
                        </label>
                       <label class="radio radio-inline">
                              <input type="radio" name="credittype" value="1"> 消费积分
                        </label>
                  
                    </div>
     </div>
    
           <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">操作积分</label>
            <div class="col-sm-9 col-xs-12">
                 <input type="text" name="num" class="form-control" value="" />
            </div>
           </div>
        
           <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
            <div class="col-sm-9 col-xs-12">
                    <input type="hidden" name="openid" value="<?php  echo $_GPC['openid'];?>" />
                    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                    <input name="submit" type="submit" value="充 值" class="btn btn-primary span2" onclick="return confirm('确认操作？');return false;" >
            </div>
           </div>
  
        </div>
    </div>
 
</form>

<?php  } else if($operation=='credit2') { ?>

<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
<div class="panel">

           <h3 class="custom_page_header">余额充值 </h3>
    <div class="panel-body">
         <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">粉丝</label>
                <div class="col-sm-9 col-xs-12">
                    <img src='<?php  echo $profile['avatar'];?>' onerror="this.src='<?php  echo RESOURCE_ROOT;?>eshop/mobile/default/static/images/tx.png'" style='width:100px;height:100px;padding:1px;border:1px solid #ccc' />
                         <?php  echo $profile['nickname'];?>
                </div>
            </div>
        <div class="form-group">
                <label class="col-xs-12 col-sm-3 col-md-2 control-label">OPENID</label>
                <div class="col-sm-9 col-xs-12">
                    <div class="form-control-static"><?php  echo $profile['openid'];?></div>
                </div>
        </div>
        
        <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">会员信息</label>
            <div class="col-sm-9 col-xs-12">
                <div class="form-control-static">姓名: <?php  echo $profile['realname'];?> / 手机号: <?php  echo $profile['mobile'];?></div>
            </div>
        </div>
         <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">当前余额</label>
            <div class="col-sm-9 col-xs-12">
                <div class="form-control-static"><?php  echo $profile['credit2'];?></div>
            </div>
        </div>
            <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">操作类型</label>
    <div class="col-sm-9 col-xs-12">
                     
                        <label class="radio radio-inline">
                              <input type="radio" name="goldtype" value="0" checked=""> 充值余额
                        </label>
                       <label class="radio radio-inline">
                              <input type="radio" name="goldtype" value="1"> 消费余额
                        </label>
                  
                    </div>
     </div>
           <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label">充值金额</label>
            <div class="col-sm-9 col-xs-12">
                 <input type="text" name="num" class="form-control" value="" />
            </div>
           </div>
        
           <div class="form-group">
            <label class="col-xs-12 col-sm-3 col-md-2 control-label"></label>
            <div class="col-sm-9 col-xs-12">
                    <input type="hidden" name="openid" value="<?php  echo $_GPC['openid'];?>" />
                    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                    <input name="submit" type="submit" value="充 值" class="btn btn-primary span2" onclick="return confirm('确认操作？');return false;">
            </div>
           </div>
  
        </div>
    </div>
 
</form>

<?php  } ?>
<?php include page("footer-base");?>