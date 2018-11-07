<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>

  
<div class="panel">
				<h3 class="custom_page_header">报名记录 
                          
                        </h3>
                       
                       
                       <div class="panel-body">
            <form action="" method="get" class="form-horizontal" role="form">
                <input type="hidden" name="mod" value="site" />
                 <input type="hidden" name="activityid" value="<?php echo $_GPC['activityid'];?>" />
                <input type="hidden" name="do" value="records" />
                <input type="hidden" name="act"  value="activity" />
                <input type="hidden" name="op" value="display" />
                 <input type="hidden" name="isaddons" value="1" />
                <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                     
                <div class="form-group">
                	  
                    	 <div class="col-sm-4">
                        <input class="form-control" name="keyword" id="" type="text" value="<?php echo $_GPC['keyword'];?>" placeholder="昵称或手机号关键字">
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
               		<th style="width:80px;">照片/头像</th>
							<th class="text-center" style="width:120px;">微信昵称</th>
							<th style="width:80px;">姓名</th>
							<th class="text-center" style="width:120px;">电话</th>
							<th class="text-center" style="width:120px;">是否合伙人</th>
								<th class="text-left" style="width:120px;">留言</th>
			      	<th class="text-center" style="width:85px;">报名时间</th>
							<th class="text-center" style="width:60px;">操作</th>
                </tr>
            </thead>
            <tbody>
            	
            	
			<?php  if(is_array($records)) { foreach($records as $row) { ?>	
            <tr data-toggle="popover" data-trigger="hover" data-placement="left" class="js-goods-img">
                <td class="text-left"><?php  echo $row['id'];?></td>
				<td>
           <img class="scrollLoading" src="<?php  echo tomedia($row['headimgurl']);?>" data-url="<?php  echo tomedia($row['headimgurl']);?>" onerror="this.src='<?php  echo tomedia($row['headimgurl']);?>'" height="50" width="50">
                </td>

				<td class="text-center">
					<span><?php  echo $row['nickname'];?></span>
				</td>
								<td class="line-feed">
					<?php  echo $row['username'];?></span>
				</td>
				<td class="text-center" style="line-height:25px;">
					<span><?php  echo $row['mobile'];?></span><br>
				</td>
						<td class="text-center">
							
					<?php  if($row['isagent']==1) { ?>
                 
                    <span class="label label-info">合伙人</span>
                    <?php  } else { ?>
                       <span class="label label-default">非合伙人</span>
                    <?php  } ?>
							
				</td>
							
				<td class="text-left">
					<span><?php  if($row['msg']=='') { ?><?php  } else { ?><?php  echo $row['msg'];?><?php  } ?></span>
				</td>
                <td class="text-center">
					<span><?php  echo $row['jointime'];?></span>
				</td>
              
				<td class="text-center" style="position:relative;">
                 	   <a onclick="return confirm('此操作不可恢复，确认删除？');return false;"    href="<?php  echo create_url('site',array('act' => 'activity','do' => 'records','isaddons'=>'1', 'op' => 'delete','id'=>$row['id']))?>"  class="js-delete btn btn-danger btn-sm" data-records-id="<?php  echo $row['id'];?>" data-toggle="tooltip" data-placement="left" title="删除">删除</a>
               </td>
			</tr>
            <?php  } } ?>
          
			
            </tbody>
        </table>
        <?php  echo $pager;?>
    </div></form>
</div>


<?php include page("footer-base");?>