<?php defined('IN_IA') or exit('Access Denied');?><style type="text/css">
.list-main {min-height:100px; background:#fff; padding:10px;}
.list {height:75px; border-left:1px solid #eee; padding-left:20px; position:relative;}
.list .info {height:75px; border-top:1px solid #eee; padding:10px; font-size:14px; color:#666;}
.list .info .step { height:40px;} 
.list .info .time { height:20px;}
.list .infoon { color:#25ae5e}
.list .dot {height:10px; width:10px; border-radius:10px; background:#ddd; position:absolute; left:-6px; top:12px;}
.list .doton {height:12px; width:12px; background:#25ae5e; border-radius:12px; border:1px solid #bbe2c9; left:-8px;}
</style>
<?php  if(empty($list)) { ?>
        <p>未查询到物流信息</p>
<?php  } else { ?>
  <div class="list-main">
            <?php  if(is_array($list)) { foreach($list as $index => $row) { ?>
             <div class="list">
                 <div class="info <?php  if($index==0) { ?>infoon<?php  } ?>" <?php  if($index==0) { ?>style='border:none'<?php  } ?>>
                     <div class='step'><?php  echo $row['step'];?></div>
                     <div class='time'><?php  echo $row['time'];?></div>
                 </div>
                 <div class="dot  <?php  if($index==0) { ?>doton<?php  } ?>"></div>
             </div>
            <?php  } } ?>
       </div>
<?php  } ?>
