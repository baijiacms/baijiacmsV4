<?php defined('IN_IA') or exit('Access Denied');?><table class="table table-hover" style="min-width:850px;">
    <tbody>   
        <?php  if(is_array($ds)) { foreach($ds as $row) { ?>
        <tr>
            <td><?php  echo $row['storename'];?></td>
            <td style="width:80px;"><a href="javascript:;" onclick='select_store(<?php  echo json_encode($row);?>)'>选择</a></td>
        </tr>
        <?php  } } ?>
        <?php  if(count($ds)<=0) { ?>
        <tr>
            <td colspan='2' align='center'>未找到门店</td>
        </tr>
        <?php  } ?>
    </tbody>
</table>