<?php defined('IN_IA') or exit('Access Denied');?><?php include page("header-base");?>
<div class="panel panel-default">
 	<h3 class="custom_page_header">  按年、月、日统计商城交易额、交易量 </h3>
    <div class="panel-body">

        <form action="./index.php" method="get" class="form-horizontal">
            <input type="hidden" name="mod" value="site" />
            <input type="hidden" name="m" value="eshop" />
            <input type="hidden" name="do" value="statistics" />
            <input type="hidden" name="act"  value="sale" />

            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">日期</label>
                <div class="col-sm-2">
                    <select name="year" class="form-control">
                        <?php  if(is_array($years)) { foreach($years as $y) { ?>
                        <option value="<?php  echo $y['data'];?>"  <?php  if($y['selected']) { ?>selected="selected"<?php  } ?>><?php  echo $y['data'];?>年</option>
                        <?php  } } ?>
                    </select>
                </div>
              
                <div class="col-sm-2">
                    <select name="month" class="form-control">
                        <option value=''>未选月份</option>
                        <?php  if(is_array($months)) { foreach($months as $m) { ?>
                        <option value="<?php  echo $m['data'];?>"  <?php  if($m['selected']) { ?>selected="selected"<?php  } ?>><?php  echo $m['data'];?>月</option>
                        <?php  } } ?>
                    </select>
                </div>
                 <div class="col-sm-2">
                    <select name="day" class="form-control">
                        <option value=''>未选日期</option>
                    </select>
                </div>
                <span class='help-block'>不选择月份表示年统计，不选择日，则表示月统计</span>
            </div>
            <div class="form-group">
                <label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">类型</label>
                <div class="col-sm-2 ">
                    <label class="radio-inline"><input type="radio" name="type" value="0" <?php  if($_GPC['type'] == 0) { ?>checked=""<?php  } ?>>交易额</label>
                    <label class="radio-inline"><input type="radio" name="type" value="1" <?php  if($_GPC['type'] == 1) { ?>checked=""<?php  } ?>>交易量</label>
                </div>
                    <div class="col-sm-3 ">
                    <button class="btn btn-default" ><i class="fa fa-search"></i> 搜索</button>
                    <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                    <?php  if('statistics.export.sale') { ?>
                    <button type="submit" name="export" value='1' class="btn btn-primary">导出 Excel</button>
                    <?php  } ?>
                </div>
            </div>
       

           
        </form>
    </div>

    <div class='panel-heading'>
        数据统计 
        <?php  if(empty($type)) { ?>交易额<?php  } else { ?>交易量<?php  } ?>总数：<span style="color:red; "><?php  echo $totalcount;?></span>，
        最高<?php  if(empty($type)) { ?>交易额<?php  } else { ?>交易量<?php  } ?>：<span style="color:red; "><?php  echo $maxcount;?></span> <?php  if(!empty($maxcount_date)) { ?><span>(<?php  echo $maxcount_date;?></span>)<?php  } ?>
       
    </div>
    <div class="panel-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th style='width:100px;'>
                        <?php  if(empty($_GPC['month'])) { ?>月份<?php  } else { ?>日期<?php  } ?>
                    </th>
                    <th style='width:200px;'><?php  if(empty($type)) { ?>交易额<?php  } else { ?>交易量<?php  } ?></th>
                    <th>所占比例</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td><?php  echo $row['data'];?></td>
                    <td><?php  echo $row['count'];?></td>
                    <td>
                       <div class="progress" style='max-width:500px;' >
                           <div style="width: <?php  echo $row['percent'];?>%;" class="progress-bar progress-bar-info" ><span style="color:#000"><?php echo empty($row['percent'])?'':$row['percent'].'%'?></span></div>
                       </div>
                    </td>
                </tr>
                <?php  } } ?>
            </tbody>
        </table>   
    </div>
</div>
<script language='javascript'>
    function get_days(){
          
        var year = $('select[name=year]').val();
        var month =$('select[name=month]').val();
        var day  = $('select[name=day]');
       day.get(0).options.length = 0 ;
        if(month==''){
	   day.append("<option value=''>未选日期</option");
            return;
        }
       
        day.get(0).options.length = 0 ;
        day.append("<option value=''>计算天数...</option").attr('disabled',true);
        $.post("<?php  echo $this->createWebUrl('statistics/util',array('op'=>'days'))?>",{year:year,month:month},function(days){
             day.get(0).options.length = 0 ;
             day.removeAttr('disabled');
             days =parseInt(days);
             day.append("<option value=''>未选日期</option");
             for(var i=1;i<=days;i++){
                 day.append("<option value='" + i +"'>" + i + "日</option");
             }
          
             <?php  if(!empty($day)) { ?>
                day.val( <?php  echo $day;?>);
             <?php  } ?>
        })
        
    }
    $('select[name=month]').change(function(){
           get_days();
    })
    
    get_days();
 </script>
<?php include page("footer-base");?>